<?php

declare(strict_types=1);

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

describe('Thread show', function (): void {
    it('renders forum/thread with thread and replies', function (): void {
        $thread = Thread::factory()->create();
        Reply::factory()->for($thread)->count(3)->create();

        $this->get(route('forum.threads.show', $thread))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->component('forum/thread')
                ->has('thread')
                ->has('replies.data', 3)
                ->has('isSubscribed')
            );
    });

    it('shows isSubscribed as false for guests', function (): void {
        $thread = Thread::factory()->create();

        $this->get(route('forum.threads.show', $thread))
            ->assertInertia(fn (Assert $page): Assert => $page
                ->where('isSubscribed', false)
            );
    });

    it('shows isSubscribed as true for subscribed user', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $thread->subscribers()->attach($user->id);

        $this->actingAs($user)
            ->get(route('forum.threads.show', $thread))
            ->assertInertia(fn (Assert $page): Assert => $page
                ->where('isSubscribed', true)
            );
    });

    it('only returns top-level replies, not nested ones', function (): void {
        $thread = Thread::factory()->create();
        $parent = Reply::factory()->for($thread)->create();
        Reply::factory()->asChildOf($parent)->create();

        $this->get(route('forum.threads.show', $thread))
            ->assertInertia(fn (Assert $page): Assert => $page
                ->has('replies.data', 1)
            );
    });

    // The swoole extension registers a global defer() that shadows Laravel's
    // helper and throws outside a coroutine, killing the process with no
    // output. The controller must use Illuminate\Support\defer explicitly.
    it('defers the view increment through the framework helper, not a shadowing extension', function (): void {
        $thread = Thread::factory()->create();
        $before = $thread->views_count;

        $this->get(route('forum.threads.show', $thread))->assertOk();

        expect($thread->fresh()->views_count)->toBe($before + 1);
    });
});

describe('Thread store', function (): void {
    it('keeps the legacy threads redirect GET-only so it never shadows the store route', function (): void {
        // Route::redirect() answers every HTTP method; with cached routes
        // (production) the first URI match wins, which silently swallowed
        // POST /forum/threads. Guard against reintroducing it.
        $route = Route::getRoutes()->getByName('forum.threads.index');

        expect($route->methods())->toBe(['GET', 'HEAD']);

        $this->get('/forum/threads')->assertRedirect('/forum');
    });

    it('requires authentication', function (): void {
        $channel = Channel::factory()->create();

        $this->post(route('forum.threads.store'), [
            'title' => 'Comment faire X avec Laravel ?',
            'body' => 'Je cherche à faire quelque chose de spécifique avec Laravel.',
            'channel_ids' => [$channel->id],
        ])->assertRedirect(route('login'));
    });

    it('creates a thread and attaches channels', function (): void {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $this->actingAs($user)
            ->post(route('forum.threads.store'), [
                'title' => 'Comment faire X avec Laravel ?',
                'body' => 'Je cherche à faire quelque chose de spécifique avec Laravel.',
                'channel_ids' => [$channel->id],
                'locale' => 'fr',
            ])
            ->assertRedirect();

        $thread = Thread::first();

        expect($thread)->not->toBeNull();
        expect($thread->user_id)->toBe($user->id);
        expect($thread->channels)->toHaveCount(1);
    });

    it('auto-subscribes the author', function (): void {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $this->actingAs($user)->post(route('forum.threads.store'), [
            'title' => 'Comment faire X avec Laravel ?',
            'body' => 'Je cherche à faire quelque chose de spécifique avec Laravel.',
            'channel_ids' => [$channel->id],
            'locale' => 'fr',
        ]);

        $thread = Thread::first();

        expect($thread->subscribers()->where('user_id', $user->id)->exists())->toBeTrue();
    });

    it('increments channel threads_count', function (): void {
        $user = User::factory()->create();
        $channel = Channel::factory()->create(['threads_count' => 0]);

        $this->actingAs($user)->post(route('forum.threads.store'), [
            'title' => 'Comment faire X avec Laravel ?',
            'body' => 'Je cherche à faire quelque chose de spécifique avec Laravel.',
            'channel_ids' => [$channel->id],
            'locale' => 'fr',
        ]);

        expect($channel->fresh()->threads_count)->toBe(1);
    });

    it('validates required fields', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('forum.threads.store'), [])
            ->assertSessionHasErrors(['title', 'body', 'channel_ids']);
    });

    it('requires at least 10 characters in title', function (): void {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $this->actingAs($user)
            ->post(route('forum.threads.store'), [
                'title' => 'Court',
                'body' => 'Trop court',
                'channel_ids' => [$channel->id],
            ])
            ->assertSessionHasErrors(['title', 'body']);
    });
});

describe('Thread markSolution', function (): void {
    it('allows thread owner to mark a reply as solution', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->for($user, 'author')->create();
        $reply = Reply::factory()->for($thread)->create();

        $this->actingAs($user)
            ->post(route('forum.threads.solution', [$thread, $reply]))
            ->assertRedirect();

        expect($thread->fresh()->solution_reply_id)->toBe($reply->id);
    });

    it('denies non-owner from marking solution', function (): void {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $thread = Thread::factory()->for($owner, 'author')->create();
        $reply = Reply::factory()->for($thread)->create();

        $this->actingAs($other)
            ->post(route('forum.threads.solution', [$thread, $reply]))
            ->assertForbidden();
    });

    it('returns error if reply does not belong to thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->for($user, 'author')->create();
        $otherThread = Thread::factory()->create();
        $replyFromOtherThread = Reply::factory()->for($otherThread)->create();

        $this->actingAs($user)
            ->post(route('forum.threads.solution', [$thread, $replyFromOtherThread]))
            ->assertSessionHasErrors('solution');
    });
});

describe('Thread subscribe / unsubscribe', function (): void {
    it('requires authentication', function (): void {
        $thread = Thread::factory()->create();

        $this->post(route('forum.threads.subscribe', $thread))
            ->assertRedirect(route('login'));
    });

    it('subscribes user to thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $this->actingAs($user)
            ->post(route('forum.threads.subscribe', $thread));

        expect($thread->subscribers()->where('user_id', $user->id)->exists())->toBeTrue();
    });

    it('unsubscribes user from thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $thread->subscribers()->attach($user->id);

        $this->actingAs($user)
            ->delete(route('forum.threads.unsubscribe', $thread));

        expect($thread->subscribers()->where('user_id', $user->id)->exists())->toBeFalse();
    });
});

describe('Thread lock', function (): void {
    it('allows admin to lock a thread', function (): void {
        $admin = User::factory()->admin()->create();
        $thread = Thread::factory()->create(['is_locked' => false]);

        $this->actingAs($admin)
            ->post(route('forum.threads.lock', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_locked)->toBeTrue();
    });

    it('allows moderator to lock a thread', function (): void {
        $mod = User::factory()->moderator()->create();
        $thread = Thread::factory()->create(['is_locked' => false]);

        $this->actingAs($mod)
            ->post(route('forum.threads.lock', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_locked)->toBeTrue();
    });

    it('denies regular user from locking a thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['is_locked' => false]);

        $this->actingAs($user)
            ->post(route('forum.threads.lock', $thread))
            ->assertForbidden();
    });

    it('allows admin to unlock a thread', function (): void {
        $admin = User::factory()->admin()->create();
        $thread = Thread::factory()->create(['is_locked' => true]);

        $this->actingAs($admin)
            ->delete(route('forum.threads.unlock', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_locked)->toBeFalse();
    });

    it('allows moderator to unlock a thread', function (): void {
        $mod = User::factory()->moderator()->create();
        $thread = Thread::factory()->create(['is_locked' => true]);

        $this->actingAs($mod)
            ->delete(route('forum.threads.unlock', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_locked)->toBeFalse();
    });

    it('denies regular user from unlocking a thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['is_locked' => true]);

        $this->actingAs($user)
            ->delete(route('forum.threads.unlock', $thread))
            ->assertForbidden();
    });
});

describe('Thread pin', function (): void {
    it('allows admin to pin a thread', function (): void {
        $admin = User::factory()->admin()->create();
        $thread = Thread::factory()->create(['is_pinned' => false]);

        $this->actingAs($admin)
            ->post(route('forum.threads.pin', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_pinned)->toBeTrue();
    });

    it('allows moderator to pin a thread', function (): void {
        $mod = User::factory()->moderator()->create();
        $thread = Thread::factory()->create(['is_pinned' => false]);

        $this->actingAs($mod)
            ->post(route('forum.threads.pin', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_pinned)->toBeTrue();
    });

    it('denies regular user from pinning a thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['is_pinned' => false]);

        $this->actingAs($user)
            ->post(route('forum.threads.pin', $thread))
            ->assertForbidden();
    });

    it('allows admin to unpin a thread', function (): void {
        $admin = User::factory()->admin()->create();
        $thread = Thread::factory()->create(['is_pinned' => true]);

        $this->actingAs($admin)
            ->delete(route('forum.threads.unpin', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_pinned)->toBeFalse();
    });

    it('allows moderator to unpin a thread', function (): void {
        $mod = User::factory()->moderator()->create();
        $thread = Thread::factory()->create(['is_pinned' => true]);

        $this->actingAs($mod)
            ->delete(route('forum.threads.unpin', $thread))
            ->assertRedirect();

        expect($thread->fresh()->is_pinned)->toBeFalse();
    });

    it('denies regular user from unpinning a thread', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['is_pinned' => true]);

        $this->actingAs($user)
            ->delete(route('forum.threads.unpin', $thread))
            ->assertForbidden();
    });
});
