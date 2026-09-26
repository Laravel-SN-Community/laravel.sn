<?php

declare(strict_types=1);

namespace App\Http\Controllers\Forum;

use App\Actions\Forum\CreateThread;
use App\Actions\Forum\IncrementThreadViews;
use App\Actions\Forum\MarkReplyAsSolution;
use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Thread;
use App\Support\Exceptions\ForumException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use function Illuminate\Support\defer;

use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

final class ThreadController extends Controller
{
    public function show(Request $request, Thread $thread, IncrementThreadViews $incrementViews): Response
    {
        $thread->load([
            'author' => fn ($q) => $q->select('id', 'name', 'username')->with(['roles:name', 'media']),
            'channels:id,name,slug,color',
            'solution.author' => fn ($q) => $q->select('id', 'name', 'username')->with(['roles:name', 'media']),
        ]);

        $thread->loadCount(['reactions as likes_count' => fn ($q) => $q->where('type', 'like')]);
        $thread->setAttribute('user_liked', auth()->check() && $thread->reactions()->where('user_id', auth()->id())->where('type', 'like')->exists()
        );

        defer(fn () => ($incrementViews)($thread, (string) $request->ip()));

        $isSubscribed = auth()->check() && $thread->subscribers()->where('user_id', auth()->id())->exists();

        return Inertia::render('forum/thread', [
            'thread' => $thread,
            'isSubscribed' => $isSubscribed,
            'replies' => Inertia::scroll(fn () => $thread->replies()
                ->with([
                    'author' => fn ($q) => $q->select('id', 'name', 'username')->with(['roles:name', 'media']),
                    'children' => fn ($q) => $q->with([
                        'author' => fn ($qq) => $qq->select('id', 'name', 'username')->with('roles:name'),
                    ]),
                ])
                ->oldest()
                ->paginate(30)),
        ]);
    }

    public function store(Request $request, CreateThread $createThread): RedirectResponse
    {
        Gate::authorize('create', Thread::class);

        $data = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:255'],
            'body' => ['required', 'string', 'min:20'],
            'channel_ids' => ['required', 'array', 'min:1', 'max:3'],
            'channel_ids.*' => ['integer', 'exists:channels,id'],
            'locale' => ['required', 'string', 'in:fr,en'],
        ]);

        $thread = $createThread($request->user(), $data['title'], $data['body'], $data['channel_ids'], $data['locale']);

        return redirect()->route('forum.threads.show', $thread->slug)
            ->with('success', 'Discussion créée avec succès.');
    }

    public function markSolution(Thread $thread, Reply $reply, MarkReplyAsSolution $action): RedirectResponse
    {
        Gate::authorize('markSolution', $thread);

        try {
            $action($thread, $reply, auth()->user());
        } catch (ForumException $e) {
            return back()->withErrors(['solution' => $e->getMessage()]);
        }

        return back()->with('success', 'Solution marquée.');
    }

    public function revokeSolution(Thread $thread): RedirectResponse
    {
        Gate::authorize('revokeSolution', $thread);

        $thread->unmarkAsResolved();

        return back()->with('success', 'Solution révoquée.');
    }

    public function lock(Thread $thread): RedirectResponse
    {
        Gate::authorize('lock', $thread);

        $thread->update(['is_locked' => true]);

        return back()->with('success', 'Discussion verrouillée.');
    }

    public function unlock(Thread $thread): RedirectResponse
    {
        Gate::authorize('lock', $thread);

        $thread->update(['is_locked' => false]);

        return back()->with('success', 'Discussion déverrouillée.');
    }

    public function pin(Thread $thread): RedirectResponse
    {
        Gate::authorize('pin', $thread);

        $thread->update(['is_pinned' => true]);

        return back()->with('success', 'Discussion épinglée.');
    }

    public function unpin(Thread $thread): RedirectResponse
    {
        Gate::authorize('pin', $thread);

        $thread->update(['is_pinned' => false]);

        return back()->with('success', 'Discussion désépinglée.');
    }

    public function subscribe(Thread $thread): RedirectResponse
    {
        $thread->subscribers()->syncWithoutDetaching([auth()->id()]);

        return back();
    }

    public function unsubscribe(Thread $thread): RedirectResponse
    {
        $thread->subscribers()->detach(auth()->id());

        return back();
    }
}
