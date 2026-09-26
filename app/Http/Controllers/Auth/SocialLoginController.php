<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;
use Throwable;

class SocialLoginController extends Controller
{
    /** @var list<string> */
    private const array PROVIDERS = ['github', 'google'];

    public function redirect(string $provider): SymfonyRedirect
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable) {
            return redirect()->route('login')
                ->withErrors(['email' => __('La connexion via :provider a échoué. Réessayez.', ['provider' => ucfirst($provider)])]);
        }

        if (! $socialUser->getEmail()) {
            return redirect()->route('login')
                ->withErrors(['email' => __('Impossible de récupérer votre adresse e-mail depuis :provider.', ['provider' => ucfirst($provider)])]);
        }

        $user = $this->findOrCreateUser($provider, $socialUser);

        // Socialite never passes through Fortify's authentication callback,
        // so the suspension check has to be repeated on this path.
        if ($user->isSuspended()) {
            return redirect()->route('login')
                ->withErrors(['email' => (string) $user->suspensionMessage()]);
        }

        Auth::login($user, remember: true);

        session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    private function findOrCreateUser(string $provider, SocialUser $socialUser): User
    {
        $idColumn = "{$provider}_id";

        $user = User::where($idColumn, (string) $socialUser->getId())->first();

        if ($user) {
            return $user;
        }

        return DB::transaction(function () use ($idColumn, $socialUser): User {
            /** @var User|null $user */
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                $user->forceFill([$idColumn => (string) $socialUser->getId()])->save();

                if (! $user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                return $user;
            }

            $user = User::create([
                'name' => $socialUser->getName() ?: ($socialUser->getNickname() ?: 'Membre'),
                'username' => $this->generateUniqueUsername($socialUser),
                'email' => $socialUser->getEmail(),
                'password' => Str::password(),
            ]);

            $user->forceFill([$idColumn => (string) $socialUser->getId()])->save();
            $user->markEmailAsVerified();

            if (Role::where('name', 'user')->exists()) {
                $user->assignRole('user');
            }

            return $user;
        });
    }

    private function generateUniqueUsername(SocialUser $socialUser): string
    {
        $base = Str::slug($socialUser->getNickname() ?: ($socialUser->getName() ?? 'membre'), '');

        if ($base === '') {
            $base = 'membre';
        }

        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = "{$base}{$counter}";
            $counter++;
        }

        return $username;
    }
}
