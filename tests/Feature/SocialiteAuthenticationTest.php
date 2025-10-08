<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery\MockInterface;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

it('redirects to github oauth provider', function () {
    $response = get(route('socialite.redirect', 'github'));

    $response->assertRedirect();
});

it('redirects to google oauth provider', function () {
    $response = get(route('socialite.redirect', 'google'));

    $response->assertRedirect();
});

it('returns 404 for invalid oauth provider', function () {
    $response = get(route('socialite.redirect', 'invalid-provider'));

    $response->assertNotFound();
});

it('creates new user from github oauth callback', function () {
    $socialiteUser = $this->mock(SocialiteUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('getId')->andReturn('12345');
        $mock->shouldReceive('getEmail')->andReturn('john@example.com');
        $mock->shouldReceive('getName')->andReturn('John Doe');
        $mock->shouldReceive('getNickname')->andReturn('johndoe');
        $mock->allows()->token = 'github-token-12345';
    });

    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

    $response = get(route('socialite.callback', 'github'));

    $response->assertRedirect(route('dashboard'));

    assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'name' => 'John Doe',
        'provider' => 'github',
        'provider_id' => '12345',
    ]);

    $user = User::query()->where('email', 'john@example.com')->first();
    expect($user->role)->toBe(UserRole::USER);
    expect($user->email_verified_at)->not->toBeNull();
});

it('creates new user from google oauth callback', function () {
    $socialiteUser = $this->mock(SocialiteUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('getId')->andReturn('google-12345');
        $mock->shouldReceive('getEmail')->andReturn('jane@example.com');
        $mock->shouldReceive('getName')->andReturn('Jane Smith');
        $mock->shouldReceive('getNickname')->andReturn('janesmith');
        $mock->allows()->token = 'google-token-12345';
    });

    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

    $response = get(route('socialite.callback', 'google'));

    $response->assertRedirect(route('dashboard'));

    assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'name' => 'Jane Smith',
        'provider' => 'google',
        'provider_id' => 'google-12345',
    ]);
});

it('logs in existing oauth user', function () {
    $user = User::factory()->create([
        'email' => 'existing@example.com',
        'provider' => 'github',
        'provider_id' => '54321',
        'provider_token' => 'old-token',
    ]);

    $socialiteUser = $this->mock(SocialiteUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('getId')->andReturn('54321');
        $mock->shouldReceive('getEmail')->andReturn('existing@example.com');
        $mock->shouldReceive('getName')->andReturn('Existing User');
        $mock->shouldReceive('getNickname')->andReturn('existinguser');
        $mock->allows()->token = 'new-token-12345';
    });

    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

    $response = get(route('socialite.callback', 'github'));

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->provider_token)->toBe('new-token-12345');
});

it('links oauth provider to existing email user', function () {
    $user = User::factory()->create([
        'email' => 'link@example.com',
        'password' => Hash::make('password'),
        'provider' => null,
        'provider_id' => null,
    ]);

    $socialiteUser = $this->mock(SocialiteUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('getId')->andReturn('link-12345');
        $mock->shouldReceive('getEmail')->andReturn('link@example.com');
        $mock->shouldReceive('getName')->andReturn('Link User');
        $mock->shouldReceive('getNickname')->andReturn('linkuser');
        $mock->allows()->token = 'link-token-12345';
    });

    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

    $response = get(route('socialite.callback', 'github'));

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->provider)->toBe('github');
    expect($user->provider_id)->toBe('link-12345');
    expect($user->provider_token)->toBe('link-token-12345');
});

it('redirects to login with error on oauth failure', function () {
    Socialite::shouldReceive('driver->user')->andThrow(new Exception('OAuth failed'));

    $response = get(route('socialite.callback', 'github'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('error');
});
