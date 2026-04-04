<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | SCHOOL STRUCTURE
        |--------------------------------------------------------------------------
        */

        $this->call([
            ProgramSeeder::class,
            LevelSeeder::class,
            ClassArmSeeder::class,
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE ADMIN ROLE
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE SUPER ADMIN USER
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(

            ['email' => 'admin@test.com'],

            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]

        );


        /*
        |--------------------------------------------------------------------------
        | ASSIGN ROLE
        |--------------------------------------------------------------------------
        */

        if (!$admin->hasRole('admin')) {

            $admin->assignRole($adminRole);

        }

    }
}