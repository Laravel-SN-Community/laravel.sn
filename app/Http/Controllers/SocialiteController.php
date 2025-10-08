<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the OAuth provider authentication page.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the OAuth provider callback.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with '.$provider.'. Please try again.');
        }

        $user = User::query()->where([
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
        ])->first();

        if (! $user) {
            $user = User::query()->where('email', $socialiteUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialiteUser->getId(),
                    'provider_token' => $socialiteUser->token,
                ]);
            } else {
                $user = User::query()->create([
                    'name' => $socialiteUser->getName() ?? $socialiteUser->getNickname(),
                    'email' => $socialiteUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialiteUser->getId(),
                    'provider_token' => $socialiteUser->token,
                    'email_verified_at' => now(),
                    'role' => UserRole::USER,
                ]);
            }
        } else {
            $user->update([
                'provider_token' => $socialiteUser->token,
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->route('dashboard');
    }

    /**
     * Validate the OAuth provider.
     */
    protected function validateProvider(string $provider): void
    {
        if (! in_array($provider, ['github', 'google'])) {
            abort(404);
        }
    }
}
