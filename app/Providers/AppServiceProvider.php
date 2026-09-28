<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureGates();
    }

    protected function configureGates(): void
    {
        // Admins bypass all gates
        Gate::before(fn ($user): ?true => $user->hasRole('admin') ? true : null);

        // checkPermissionTo() rather than hasPermissionTo(): the latter throws
        // PermissionDoesNotExist when the row is missing, so code naming a
        // permission the database has not been seeded with takes the whole
        // page down with a 500 instead of simply denying access.
        Gate::define('articles:publish', fn ($user): bool => $user->checkPermissionTo('articles:publish'));
        Gate::define('articles:delete', fn ($user): bool => $user->checkPermissionTo('articles:delete'));
        Gate::define('events:manage', fn ($user): bool => $user->checkPermissionTo('events:manage'));
        Gate::define('forum:moderate', fn ($user): bool => $user->checkPermissionTo('forum:moderate'));
        Gate::define('users:manage', fn ($user): bool => $user->checkPermissionTo('users:manage'));
        Gate::define('users:moderate', fn ($user): bool => $user->checkPermissionTo('users:moderate'));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
