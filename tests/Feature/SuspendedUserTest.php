<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Channel;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

describe('login', function (): void {
    test('a suspended member cannot log in', function (): void {
        $user = User::factory()->suspended()->asUser()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    });

    test('the login screen points at the team and withholds the reason', function (): void {
        $user = User::factory()->asUser()->create([
            'suspended_at' => now(),
            'suspended_until' => null,
            'suspension_reason' => 'Spam répété.',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertInvalid(['email' => 'contact@laravel.sn']);

        expect($user->suspensionMessage())->not->toContain('Spam répété.');
    });

    test('a temporary suspension states the end date', function (): void {
        $user = User::factory()->suspendedUntil(now()->addDays(7))->asUser()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertInvalid(['email' => "Votre compte est suspendu jusqu'au"]);
    });

    test('a member whose suspension expired can log in again', function (): void {
        $user = User::factory()->suspendedUntil(now()->subDay())->asUser()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    });

    test('an active member can still log in', function (): void {
        $user = User::factory()->asUser()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    });

    test('a wrong password is still rejected', function (): void {
        $user = User::factory()->asUser()->create();

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'not-the-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    });
});

describe('existing sessions', function (): void {
    // Covers the remember-me cookie and any session that predates the
    // suspension: the account must not stay usable just because it was
    // already signed in when a moderator suspended it.
    test('a suspended member holding a session is logged out on the next request', function (): void {
        $user = User::factory()->suspended()->asUser()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    });

    test('a suspended member cannot create an article', function (): void {
        $user = User::factory()->suspended()->asUser()->create();

        $this->actingAs($user)
            ->post(route('articles.store'), ['title' => 'Test', 'body' => 'Contenu'])
            ->assertRedirect(route('login'));

        $this->assertGuest();
    });

    test('a suspended member cannot post a thread', function (): void {
        $user = User::factory()->suspended()->asUser()->create();
        $channel = Channel::factory()->create();

        $this->actingAs($user)
            ->post(route('forum.threads.store'), [
                'title' => 'Bonjour tout le monde',
                'body' => 'Un message suffisamment long pour passer.',
                'channel_ids' => [$channel->id],
                'locale' => 'fr',
            ])
            ->assertRedirect(route('login'));

        $this->assertGuest();
    });

    test('a suspended member cannot upload editor images', function (): void {
        $user = User::factory()->suspended()->asUser()->create();

        $this->actingAs($user)
            ->post(route('editor.images.store'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    });

    test('a suspended moderator loses access to the moderation pages', function (): void {
        $moderator = User::factory()->suspended()->moderator()->create();

        $this->actingAs($moderator)
            ->get(route('manage.articles.index'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    });

    test('a member whose suspension expired keeps their session', function (): void {
        $user = User::factory()->suspendedUntil(now()->subDay())->asUser()->create();
        $article = Article::factory()->draft()->for($user, 'author')->create();

        $this->actingAs($user)
            ->delete(route('articles.destroy', $article))
            ->assertRedirect();

        $this->assertAuthenticatedAs($user);
    });

    test('an active member is unaffected', function (): void {
        $user = User::factory()->asUser()->create();
        $article = Article::factory()->draft()->for($user, 'author')->create();

        $this->actingAs($user)
            ->delete(route('articles.destroy', $article))
            ->assertRedirect();

        $this->assertAuthenticatedAs($user);
    });

    test('guests are unaffected', function (): void {
        $this->get(route('home'))->assertOk();
    });
});
