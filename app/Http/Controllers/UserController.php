<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Users\AssignUserRole;
use App\Actions\Users\LiftUserSuspension;
use App\Actions\Users\SuspendUser;
use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

final class UserController extends Controller
{
    /** @var list<string> */
    private const array ROLES = ['user', 'moderator', 'admin'];

    public function manageIndex(Request $request): Response
    {
        Gate::authorize('users:moderate');

        $q = $request->string('q')->trim()->toString();
        $role = $request->string('role')->toString();
        $tab = $request->string('tab', 'all')->toString();

        $query = User::query()
            ->with(['media', 'roles:id,name', 'suspendedBy:id,name,username'])
            ->when($q !== '', fn (Builder $sub) => $sub->where(
                fn (Builder $where) => $where->where('name', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
            ))
            ->when(in_array($role, self::ROLES, true), fn (Builder $sub) => $sub->role($role));

        match ($tab) {
            'moderators' => $query->role(['admin', 'moderator'])->latest(),
            'suspended' => $query->suspended()->latest('suspended_at'),
            default => $query->latest(),
        };

        $users = $query->paginate(24)->withQueryString();

        $users->getCollection()->transform(fn (User $user): array => $this->toManageUser($user));

        return Inertia::render('dashboard/manage/users', [
            'users' => $users,
            'filters' => [
                'q' => $q ?: null,
                'role' => in_array($role, self::ROLES, true) ? $role : null,
                'tab' => $tab,
            ],
            'stats' => [
                'total' => User::query()->count(),
                'moderators' => User::query()->role(['admin', 'moderator'])->count(),
                'suspended' => User::query()->suspended()->count(),
                'recent' => User::query()->where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'roles' => self::ROLES,
            'canManage' => Gate::allows('users:manage'),
        ]);
    }

    public function updateRole(Request $request, User $user, AssignUserRole $assignUserRole): RedirectResponse
    {
        Gate::authorize('users:manage');

        $data = $request->validate([
            'role' => ['required', 'string', Rule::in(self::ROLES)],
        ]);

        $assignUserRole($user, $data['role']);

        return back();
    }

    public function suspend(Request $request, User $user, SuspendUser $suspendUser): RedirectResponse
    {
        Gate::authorize('users:moderate');

        $data = $request->validate([
            'reason' => ['required', 'string', 'max:255'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'max:365'],
        ]);

        $suspendUser($user, $request->user(), $data['reason'], $data['duration_days'] ?? null);

        return back();
    }

    public function unsuspend(Request $request, User $user, LiftUserSuspension $liftUserSuspension): RedirectResponse
    {
        Gate::authorize('users:moderate');

        $liftUserSuspension($user, $request->user());

        return back();
    }

    public function manageDestroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('users:manage');

        if ($user->is($request->user())) {
            throw ValidationException::withMessages([
                'user' => 'Vous ne pouvez pas supprimer votre propre compte depuis cette page.',
            ]);
        }

        if ($user->isAdmin()) {
            throw ValidationException::withMessages([
                'user' => 'Un administrateur ne peut pas être supprimé depuis cette page.',
            ]);
        }

        $user->delete();

        return redirect()->route('manage.users.index');
    }

    /**
     * Shape a user row for the moderation table. Built explicitly so the
     * suspension metadata hidden on the model stays out of public payloads.
     *
     * @return array<string, mixed>
     */
    private function toManageUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'location' => $user->location,
            'role' => $user->getRoleNames()->first() ?? 'user',
            'email_verified_at' => $user->email_verified_at?->toISOString(),
            'created_at' => $user->created_at?->toISOString(),
            'last_active_at' => $user->last_active_at?->toISOString(),
            'is_suspended' => $user->isSuspended(),
            'suspended_at' => $user->suspended_at?->toISOString(),
            'suspended_until' => $user->suspended_until?->toISOString(),
            'suspension_reason' => $user->suspension_reason,
            'suspended_by' => $user->suspendedBy?->only(['id', 'name', 'username']),
        ];
    }

    public function show(string $username): Response
    {
        $user = User::where('username', $username)->with(['media', 'roles:name'])->firstOrFail();

        $articles = Article::query()
            ->where('author_id', $user->id)
            ->published()
            ->with(['author:id,name,username', 'author.media', 'tags:id,name,slug'])
            ->latest('published_at')
            ->get()
            ->each->makeHidden(['body', 'seo_meta', 'submitted_at', 'approved_at', 'declined_at']);

        $threads = Thread::query()
            ->where('user_id', $user->id)
            ->with('channels:id,name,slug,color')
            ->latest()
            ->get(['id', 'slug', 'title', 'replies_count', 'created_at', 'solution_reply_id']);

        $replies = Reply::query()
            ->where('user_id', $user->id)
            ->with(['thread:id,slug,title'])
            ->latest()
            ->get(['id', 'thread_id', 'body', 'created_at']);

        $solutionThreadIds = $threads->whereNotNull('solution_reply_id')->pluck('id');
        $solutions = $solutionThreadIds->isNotEmpty()
            ? Reply::query()
                ->whereIn('thread_id', $solutionThreadIds)
                ->where('user_id', $user->id)
                ->whereIn('id', $threads->whereNotNull('solution_reply_id')->pluck('solution_reply_id'))
                ->with(['thread:id,slug,title'])
                ->latest()
                ->get(['id', 'thread_id', 'body', 'created_at'])
            : collect();

        $locale = (string) config('app.locale');

        $activity = collect()
            ->merge($articles->map(fn (Article $a): array => [
                'type' => 'article',
                'title' => $a->title,
                'url' => '/articles/'.$a->slug,
                'excerpt' => null,
                'date' => $a->published_at,
                'date_human' => $a->published_at?->locale($locale)->diffForHumans(),
            ]))
            ->merge($threads->map(fn (Thread $t): array => [
                'type' => 'thread',
                'title' => $t->title,
                'url' => '/forum/threads/'.$t->slug,
                'excerpt' => null,
                'date' => $t->created_at->toISOString(),
                'date_human' => $t->created_at->locale($locale)->diffForHumans(),
            ]))
            ->merge($replies->map(fn (Reply $r): array => [
                'type' => 'reply',
                'title' => $r->thread->title,
                'url' => '/forum/threads/'.$r->thread->slug.'#reply-'.$r->id,
                'excerpt' => str($r->body)->limit(200)->toString(),
                'date' => $r->created_at->toISOString(),
                'date_human' => $r->created_at->locale($locale)->diffForHumans(),
            ]))
            ->sortByDesc('date')
            ->values();

        $role = $user->getRoleNames()->first();

        return Inertia::render('membres/show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'avatar' => $user->avatar,
                'bio' => $user->bio,
                'location' => $user->location,
                'github_handle' => $user->github_handle,
                'twitter_handle' => $user->twitter_handle,
                'website_url' => $user->website_url,
                'created_at' => $user->created_at,
                'role' => $role,
            ],
            'articles' => $articles,
            'threads' => $threads,
            'replies' => $replies,
            'solutions' => $solutions,
            'activity' => $activity,
        ]);
    }
}
