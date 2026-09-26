<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RoleController extends Controller
{
    /**
     * Read-only audit view of the role/permission matrix. The grid is
     * seeded by RolesAndPermissionsSeeder, which stays the source of
     * truth — editing it here would drift on the next deploy.
     */
    public function index(): Response
    {
        Gate::authorize('users:manage');

        $roles = Role::query()
            ->with('permissions:id,name')
            ->withCount('users')
            ->orderBy('id')
            ->get(['id', 'name'])
            ->map(fn (Role $role): array => [
                'id' => $role->id,
                'name' => $role->name,
                'users_count' => $role->users_count,
                'permissions' => $role->permissions->pluck('name')->all(),
            ]);

        return Inertia::render('dashboard/manage/roles', [
            'roles' => $roles,
            'permissions' => Permission::query()->orderBy('name')->pluck('name'),
        ]);
    }
}
