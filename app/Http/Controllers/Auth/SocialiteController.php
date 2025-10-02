<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     */
    public function redirectToGithub(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleGithubCallback(): \Illuminate\Http\RedirectResponse
    {
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Unable to authenticate with GitHub. Please try again.']);
        }

        // Check if user already exists with this GitHub ID
        $user = User::where('github_id', $githubUser->id)->first();

        if ($user) {
            // Update existing user's GitHub token and info
            $user->update([
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
                'avatar' => $githubUser->avatar,
            ]);
        } else {
            // Check if user exists with same email
            $existingUser = User::where('email', $githubUser->email)->first();

            if ($existingUser) {
                // Link GitHub account to existing user
                $existingUser->update([
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken,
                    'avatar' => $githubUser->avatar,
                ]);
                $user = $existingUser;
            } else {
                // Create new user
                $user = User::create([
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email,
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken,
                    'avatar' => $githubUser->avatar,
                    'password' => Hash::make(Str::random(24)), // Random password for OAuth users
                    'email_verified_at' => now(), // GitHub emails are considered verified
                ]);
            }
        }

        // Log the user in
        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}
