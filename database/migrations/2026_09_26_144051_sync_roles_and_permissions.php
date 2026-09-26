<?php

declare(strict_types=1);

use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Bring the roles/permissions tables in line with the seeder.
     *
     * RolesAndPermissionsSeeder stays the single source of truth for the
     * grid, but a seeder only runs on demand — so an environment whose
     * database was seeded before a permission was added never receives it,
     * and every gate naming that permission throws PermissionDoesNotExist.
     * Running the sync from a migration means `php artisan migrate`, which
     * already runs on deploy, is enough to converge any environment.
     *
     * Add a fresh migration like this one whenever the permission grid
     * changes; the seeder itself is idempotent (firstOrCreate + sync).
     */
    public function up(): void
    {
        (new RolesAndPermissionsSeeder)->run();
    }

    /**
     * Deliberately a no-op: roles and permissions are shared state that
     * other migrations and records depend on, and the previous grid is not
     * reconstructable from here.
     */
    public function down(): void
    {
        //
    }
};
