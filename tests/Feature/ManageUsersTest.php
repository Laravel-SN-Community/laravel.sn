<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

describe('access', function (): void {
    test('guests are redirected to login', function (): void {
        $this->get(route('manage.users.index'))->assertRedirect(route('login'));
    });

    test('regular members are forbidden', function (): void {
        $this->actingAs(User::factory()->asUser()->create())
            ->get(route('manage.users.index'))
            ->assertForbidden();
    });

    test('moderators can open the users page', function (): void {
        $this->actingAs(User::factory()->moderator()->create())
            ->get(route('manage.users.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->component('dashboard/manage/users')
                ->where('canManage', false)
            );
    });

    test('admins can open the users page and manage roles', function (): void {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('manage.users.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->component('dashboard/manage/users')
                ->where('canManage', true)
            );
    });
});

describe('listing', function (): void {
    test('search matches name, username and email', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->asUser()->create(['name' => 'Awa Ndiaye', 'username' => 'awand', 'email' => 'awa@example.com']);
        User::factory()->asUser()->create(['name' => 'Moussa Fall', 'username' => 'moussaf', 'email' => 'moussa@example.com']);

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['q' => 'Awa']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page->count('users.data', 1));

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['q' => 'moussaf']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page->count('users.data', 1));

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['q' => 'moussa@example.com']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page->count('users.data', 1));
    });

    test('the suspended tab lists only active suspensions', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->suspended()->asUser()->create();
        User::factory()->suspendedUntil(now()->subDay())->asUser()->create();
        User::factory()->asUser()->create();

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['tab' => 'suspended']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->count('users.data', 1)
                ->where('stats.suspended', 1)
            );
    });

    test('the moderators tab lists admins and moderators', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->moderator()->create();
        User::factory()->asUser()->count(3)->create();

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['tab' => 'moderators']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page->count('users.data', 2));
    });

    test('the role filter narrows the list', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->moderator()->count(2)->create();
        User::factory()->asUser()->create();

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['role' => 'moderator']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page->count('users.data', 2));
    });

    test('the list paginates and exposes working page links', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->asUser()->count(30)->create();

        $this->actingAs($admin)
            ->get(route('manage.users.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->count('users.data', 24)
                ->where('users.current_page', 1)
                ->where('users.last_page', 2)
                ->where('users.prev_page_url', null)
                ->where('users.next_page_url', fn (?string $url): bool => is_string($url)
                    && str_contains($url, '/dashboard/manage/users')
                    && str_contains($url, 'page=2')
                )
            );

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['page' => 2]))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->count('users.data', 7)
                ->where('users.current_page', 2)
            );
    });

    test('pagination links keep the active search and tab', function (): void {
        $admin = User::factory()->admin()->create();
        User::factory()->asUser()->count(30)->create(['location' => 'Dakar']);

        $this->actingAs($admin)
            ->get(route('manage.users.index', ['q' => 'a', 'tab' => 'all']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->where('users.next_page_url', fn (?string $url): bool => is_string($url)
                    && str_contains($url, 'q=a')
                    && str_contains($url, 'tab=all')
                )
            );
    });

    test('suspension details are exposed to moderators', function (): void {
        $moderator = User::factory()->moderator()->create();
        User::factory()->suspended()->asUser()->create();

        $this->actingAs($moderator)
            ->get(route('manage.users.index', ['tab' => 'suspended']))
            ->assertOk()
            ->assertInertia(fn (Assert $page): Assert => $page
                ->where('users.data.0.is_suspended', true)
                ->where('users.data.0.suspension_reason', 'Non-respect du code de conduite.')
            );
    });
});

describe('role assignment', function (): void {
    test('an admin can promote a member to moderator', function (): void {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($admin)
            ->patch(route('manage.users.role', $member), ['role' => 'moderator'])
            ->assertRedirect();

        expect($member->fresh()->hasRole('moderator'))->toBeTrue()
            ->and($member->fresh()->hasRole('user'))->toBeFalse();
    });

    test('a moderator cannot change roles', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->patch(route('manage.users.role', $member), ['role' => 'admin'])
            ->assertForbidden();

        expect($member->fresh()->hasRole('admin'))->toBeFalse();
    });

    test('an unknown role is rejected', function (): void {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($admin)
            ->patch(route('manage.users.role', $member), ['role' => 'superuser'])
            ->assertSessionHasErrors('role');
    });

    test('the last admin cannot be demoted', function (): void {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('manage.users.role', $admin), ['role' => 'user'])
            ->assertSessionHasErrors('role');

        expect($admin->fresh()->hasRole('admin'))->toBeTrue();
    });

    test('an admin can be demoted while another admin remains', function (): void {
        $admin = User::factory()->admin()->create();
        $other = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('manage.users.role', $other), ['role' => 'moderator'])
            ->assertRedirect();

        expect($other->fresh()->hasRole('moderator'))->toBeTrue();
    });
});

describe('suspension', function (): void {
    test('a moderator can suspend a member for a fixed duration', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $member), [
                'reason' => 'Spam répété dans le forum.',
                'duration_days' => 7,
            ])
            ->assertRedirect();

        $member->refresh();

        expect($member->isSuspended())->toBeTrue()
            ->and($member->suspension_reason)->toBe('Spam répété dans le forum.')
            ->and($member->suspended_by_id)->toBe($moderator->id)
            ->and($member->suspended_until?->isFuture())->toBeTrue();
    });

    test('omitting the duration makes the suspension permanent', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $member), ['reason' => 'Propos haineux.'])
            ->assertRedirect();

        $member->refresh();

        expect($member->isSuspended())->toBeTrue()
            ->and($member->suspended_until)->toBeNull();
    });

    test('a reason is required', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $member), ['reason' => ''])
            ->assertSessionHasErrors('reason');

        expect($member->fresh()->isSuspended())->toBeFalse();
    });

    test('a moderator cannot suspend themselves', function (): void {
        $moderator = User::factory()->moderator()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $moderator), ['reason' => 'Test.'])
            ->assertSessionHasErrors('reason');

        expect($moderator->fresh()->isSuspended())->toBeFalse();
    });

    test('a moderator cannot suspend another moderator', function (): void {
        $moderator = User::factory()->moderator()->create();
        $peer = User::factory()->moderator()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $peer), ['reason' => 'Abus.'])
            ->assertSessionHasErrors('reason');

        expect($peer->fresh()->isSuspended())->toBeFalse();
    });

    test('an admin can suspend a moderator', function (): void {
        $admin = User::factory()->admin()->create();
        $moderator = User::factory()->moderator()->create();

        $this->actingAs($admin)
            ->post(route('manage.users.suspend', $moderator), ['reason' => 'Abus de pouvoir.'])
            ->assertRedirect();

        expect($moderator->fresh()->isSuspended())->toBeTrue();
    });

    test('a moderator cannot lift a suspension an admin placed on a moderator', function (): void {
        $admin = User::factory()->admin()->create();
        $suspendedModerator = User::factory()->suspended()->moderator()->create();
        $moderator = User::factory()->moderator()->create();

        $this->actingAs($moderator)
            ->delete(route('manage.users.unsuspend', $suspendedModerator))
            ->assertSessionHasErrors('user');

        expect($suspendedModerator->fresh()->isSuspended())->toBeTrue();

        $this->actingAs($admin)
            ->delete(route('manage.users.unsuspend', $suspendedModerator))
            ->assertRedirect();

        expect($suspendedModerator->fresh()->isSuspended())->toBeFalse();
    });

    test('a moderator can still suspend and lift a regular member', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $member), ['reason' => 'Spam.'])
            ->assertRedirect();

        expect($member->fresh()->isSuspended())->toBeTrue();

        $this->actingAs($moderator)
            ->delete(route('manage.users.unsuspend', $member))
            ->assertRedirect();

        expect($member->fresh()->isSuspended())->toBeFalse();
    });

    test('an admin cannot be suspended', function (): void {
        $moderator = User::factory()->moderator()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($moderator)
            ->post(route('manage.users.suspend', $admin), ['reason' => 'Test.'])
            ->assertSessionHasErrors('reason');

        expect($admin->fresh()->isSuspended())->toBeFalse();
    });

    test('a regular member cannot suspend anyone', function (): void {
        $member = User::factory()->asUser()->create();
        $target = User::factory()->asUser()->create();

        $this->actingAs($member)
            ->post(route('manage.users.suspend', $target), ['reason' => 'Test.'])
            ->assertForbidden();
    });

    test('a moderator can lift a suspension', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->suspended()->asUser()->create();

        $this->actingAs($moderator)
            ->delete(route('manage.users.unsuspend', $member))
            ->assertRedirect();

        $member->refresh();

        expect($member->isSuspended())->toBeFalse()
            ->and($member->suspended_at)->toBeNull()
            ->and($member->suspension_reason)->toBeNull();
    });

    test('an expired suspension is no longer active', function (): void {
        $member = User::factory()->suspendedUntil(now()->subDay())->asUser()->create();

        expect($member->isSuspended())->toBeFalse();
    });
});

describe('deletion', function (): void {
    test('an admin can delete a member', function (): void {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($admin)
            ->delete(route('manage.users.destroy', $member))
            ->assertRedirect(route('manage.users.index'));

        $this->assertModelMissing($member);
    });

    test('a moderator cannot delete a member', function (): void {
        $moderator = User::factory()->moderator()->create();
        $member = User::factory()->asUser()->create();

        $this->actingAs($moderator)
            ->delete(route('manage.users.destroy', $member))
            ->assertForbidden();

        $this->assertModelExists($member);
    });

    test('an admin cannot delete their own account here', function (): void {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete(route('manage.users.destroy', $admin))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($admin);
    });

    test('an admin cannot delete another admin', function (): void {
        $admin = User::factory()->admin()->create();
        $other = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete(route('manage.users.destroy', $other))
            ->assertSessionHasErrors('user');

        $this->assertModelExists($other);
    });
});
