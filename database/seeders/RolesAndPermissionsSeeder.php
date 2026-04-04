<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | CREATE PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [
            'edit users',
            'delete users',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE ROLES
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher',
            'guard_name' => 'web',
        ]);

        $parentRole = Role::create([
            'name' => 'parent',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $adminRole->givePermissionTo(Permission::all());

        $teacherRole->givePermissionTo([
            'view dashboard',
        ]);

        $parentRole->givePermissionTo([
            'view dashboard',
        ]);
    }
}