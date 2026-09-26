<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Laravel\Socialite\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

// ── redirect ───────────────────────────────────────────────────────────────

test('guests are redirected to the github oauth provider', function (): void {
    Socialite::fake('github');

    $this->get('/auth/github/redirect')->assertRedirect();
});

test('guests are redirected to the google oauth provider', function (): void {
    Socialite::fake('google');

    $this->get('/auth/google/redirect')->assertRedirect();
});

test('unknown providers return 404', function (): void {
    $this->get('/auth/facebook/redirect')->assertNotFound();
    $this->get('/auth/facebook/callback')->assertNotFound();
});

test('authenticated users cannot start a social flow', function (): void {
    $this->actingAs(User::factory()->create())
        ->get('/auth/github/redirect')
        ->assertRedirect();
});

// ── callback: account creation ─────────────────────────────────────────────

test('a new user is created and logged in from a github callback', function (): void {
    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-123',
        'nickname' => 'fatou-dev',
        'name' => 'Fatou Ndiaye',
        'email' => 'fatou@example.com',
    ]));

    $this->get('/auth/github/callback')->assertRedirect('/dashboard');

    $user = User::where('email', 'fatou@example.com')->firstOrFail();

    expect($user->github_id)->toBe('github-123');
    expect($user->username)->toBe('fatoudev');
    expect($user->email_verified_at)->not->toBeNull();
    expect($user->hasRole('user'))->toBeTrue();
    expect(auth()->id())->toBe($user->id);
});

test('a new user is created from a google callback', function (): void {
    Socialite::fake('google', (new SocialiteUser)->map([
        'id' => 'google-987',
        'name' => 'Moussa Sarr',
        'email' => 'moussa@example.com',
    ]));

    $this->get('/auth/google/callback')->assertRedirect('/dashboard');

    $user = User::where('email', 'moussa@example.com')->firstOrFail();

    expect($user->google_id)->toBe('google-987');
    expect(auth()->id())->toBe($user->id);
});

test('username collisions get a numeric suffix', function (): void {
    User::factory()->create(['username' => 'fatoudev']);

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-456',
        'nickname' => 'fatou-dev',
        'name' => 'Other Fatou',
        'email' => 'other@example.com',
    ]));

    $this->get('/auth/github/callback');

    expect(User::where('email', 'other@example.com')->firstOrFail()->username)
        ->toBe('fatoudev1');
});

// ── callback: linking existing accounts ────────────────────────────────────

test('an existing user with a matching email gets the provider linked', function (): void {
    $existing = User::factory()->create([
        'email' => 'fatou@example.com',
        'email_verified_at' => null,
    ]);

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-123',
        'name' => 'Fatou Ndiaye',
        'email' => 'fatou@example.com',
    ]));

    $this->get('/auth/github/callback')->assertRedirect('/dashboard');

    $existing->refresh();

    expect($existing->github_id)->toBe('github-123');
    expect($existing->email_verified_at)->not->toBeNull();
    expect(auth()->id())->toBe($existing->id);
    expect(User::count())->toBe(1);
});

test('a returning user logs in by provider id even after changing email', function (): void {
    $existing = User::factory()->create(['email' => 'old@example.com']);
    $existing->forceFill(['github_id' => 'github-123'])->save();

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-123',
        'name' => 'Fatou Ndiaye',
        'email' => 'new-email@example.com',
    ]));

    $this->get('/auth/github/callback')->assertRedirect('/dashboard');

    expect(auth()->id())->toBe($existing->id);
    expect(User::count())->toBe(1);
});

test('a migrated legacy user logs in seamlessly via their carried-over provider id', function (): void {
    $legacyUser = User::factory()->create(['email' => 'legacy@example.com']);
    $legacyUser->forceFill(['google_id' => '99887'])->save();

    Socialite::fake('google', (new SocialiteUser)->map([
        'id' => '99887',
        'name' => 'Legacy Member',
        'email' => 'legacy@example.com',
    ]));

    $this->get('/auth/google/callback')->assertRedirect('/dashboard');

    expect(auth()->id())->toBe($legacyUser->id);
});

// ── callback: failures ─────────────────────────────────────────────────────

test('a callback without an email redirects back to login with an error', function (): void {
    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-123',
        'name' => 'No Email',
        'email' => null,
    ]));

    $this->get('/auth/github/callback')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    expect(auth()->check())->toBeFalse();
});

// ── callback: suspended accounts ───────────────────────────────────────────

test('a suspended user cannot log in through a linked github account', function (): void {
    $user = User::factory()->suspended()->asUser()->create(['email' => 'banned@example.com']);
    $user->forceFill(['github_id' => 'github-666'])->save();

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-666',
        'nickname' => 'banned',
        'name' => 'Banned Member',
        'email' => 'banned@example.com',
    ]));

    $this->get('/auth/github/callback')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    expect(auth()->check())->toBeFalse();
});

test('a suspended user cannot log in through google either', function (): void {
    $user = User::factory()->suspended()->asUser()->create(['email' => 'banned@example.com']);
    $user->forceFill(['google_id' => 'google-666'])->save();

    Socialite::fake('google', (new SocialiteUser)->map([
        'id' => 'google-666',
        'name' => 'Banned Member',
        'email' => 'banned@example.com',
    ]));

    $this->get('/auth/google/callback')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    expect(auth()->check())->toBeFalse();
});

test('a suspended user cannot link a fresh provider to slip past the check', function (): void {
    User::factory()->suspended()->asUser()->create(['email' => 'banned@example.com']);

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'brand-new-github-id',
        'nickname' => 'banned',
        'name' => 'Banned Member',
        'email' => 'banned@example.com',
    ]));

    $this->get('/auth/github/callback')
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    expect(auth()->check())->toBeFalse();
});

test('a rejected social login points the member at the team, never at the reason', function (): void {
    $user = User::factory()->asUser()->create(['email' => 'banned@example.com']);
    $user->forceFill([
        'suspended_at' => now(),
        'suspended_until' => null,
        'suspension_reason' => 'Spam répété.',
        'github_id' => 'github-666',
    ])->save();

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-666',
        'name' => 'Banned Member',
        'email' => 'banned@example.com',
    ]));

    $this->get('/auth/github/callback')
        ->assertRedirect(route('login'))
        ->assertInvalid(['email' => 'contact@laravel.sn']);

    // The reason is moderator-facing context and must not leak to the
    // person being locked out.
    expect($user->suspensionMessage())
        ->toContain('Votre compte a été suspendu.')
        ->not->toContain('Spam répété.');
});

test('a user whose suspension expired can log in socially again', function (): void {
    $user = User::factory()->suspendedUntil(now()->subDay())->asUser()->create(['email' => 'freed@example.com']);
    $user->forceFill(['github_id' => 'github-777'])->save();

    Socialite::fake('github', (new SocialiteUser)->map([
        'id' => 'github-777',
        'name' => 'Freed Member',
        'email' => 'freed@example.com',
    ]));

    $this->get('/auth/github/callback')->assertRedirect('/dashboard');

    expect(auth()->id())->toBe($user->id);
});
