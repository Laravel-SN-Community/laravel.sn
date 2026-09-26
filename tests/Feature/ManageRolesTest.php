<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

test('guests are redirected to login', function (): void {
    $this->get(route('manage.roles.index'))->assertRedirect(route('login'));
});

test('regular members are forbidden', function (): void {
    $this->actingAs(User::factory()->asUser()->create())
        ->get(route('manage.roles.index'))
        ->assertForbidden();
});

test('moderators are forbidden', function (): void {
    $this->actingAs(User::factory()->moderator()->create())
        ->get(route('manage.roles.index'))
        ->assertForbidden();
});

test('an admin sees the full role matrix', function (): void {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('manage.roles.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('dashboard/manage/roles')
            ->count('roles', 3)
            ->count('permissions', 6)
        );
});

test('the matrix reports each role permissions and member count', function (): void {
    $admin = User::factory()->admin()->create();
    User::factory()->moderator()->count(2)->create();

    $this->actingAs($admin)
        ->get(route('manage.roles.index'))
        ->assertOk()
        ->assertInertia(function (Assert $page): void {
            $roles = collect($page->toArray()['props']['roles']);

            $adminRole = $roles->firstWhere('name', 'admin');
            $moderatorRole = $roles->firstWhere('name', 'moderator');
            $userRole = $roles->firstWhere('name', 'user');

            expect($adminRole['permissions'])->toHaveCount(6)
                ->and($adminRole['users_count'])->toBe(1)
                ->and($moderatorRole['permissions'])->toContain('users:moderate')
                ->and($moderatorRole['permissions'])->not->toContain('users:manage')
                ->and($moderatorRole['users_count'])->toBe(2)
                ->and($userRole['permissions'])->toBeEmpty();
        });
});
