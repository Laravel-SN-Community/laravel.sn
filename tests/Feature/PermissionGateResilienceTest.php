<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

// Gates must deny when a permission row is missing, not throw. Spatie's
// hasPermissionTo() raises PermissionDoesNotExist, which turns a database
// that has not been seeded with a newly added permission into a 500 on every
// gated page rather than a 403. This happened twice while building the
// moderation module, so the gates use checkPermissionTo() instead.

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

/**
 * Drop a permission and clear Spatie's cache, simulating an environment
 * whose database predates the permission being added.
 */
function forgetPermission(string $name): void
{
    Permission::where('name', $name)->delete();

    app(PermissionRegistrar::class)->forgetCachedPermissions();
}

test('a gate denies instead of throwing when its permission is missing', function (): void {
    $moderator = User::factory()->moderator()->create();

    forgetPermission('articles:publish');

    expect(Gate::forUser($moderator)->allows('articles:publish'))->toBeFalse();
});

test('a moderation page returns 403 rather than 500 when a permission is missing', function (): void {
    $moderator = User::factory()->moderator()->create();

    forgetPermission('articles:publish');

    $this->actingAs($moderator)
        ->get(route('manage.articles.index'))
        ->assertForbidden();
});

test('every defined gate survives its permission going missing', function (string $permission): void {
    $moderator = User::factory()->moderator()->create();

    forgetPermission($permission);

    expect(Gate::forUser($moderator)->allows($permission))->toBeFalse();
})->with([
    'articles:publish',
    'articles:delete',
    'events:manage',
    'forum:moderate',
    'users:manage',
    'users:moderate',
]);

test('admins still bypass every gate through Gate::before', function (): void {
    $admin = User::factory()->admin()->create();

    forgetPermission('articles:publish');

    expect(Gate::forUser($admin)->allows('articles:publish'))->toBeTrue();
});

test('a granted permission still resolves normally', function (): void {
    $moderator = User::factory()->moderator()->create();

    expect(Gate::forUser($moderator)->allows('articles:publish'))->toBeTrue()
        ->and(Gate::forUser($moderator)->allows('users:manage'))->toBeFalse();
});
