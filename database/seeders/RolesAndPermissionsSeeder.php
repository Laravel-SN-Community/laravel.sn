<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'articles:publish',
            'articles:delete',
            'events:manage',
            'forum:moderate',
            'users:moderate',
            'users:manage',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        Role::firstOrCreate(['name' => 'user']);

        $moderator = Role::firstOrCreate(['name' => 'moderator']);
        $moderator->syncPermissions([
            'articles:publish',
            'events:manage',
            'forum:moderate',
            'users:moderate',
        ]);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);
    }
}
