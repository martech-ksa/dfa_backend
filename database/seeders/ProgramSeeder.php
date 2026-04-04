<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Program::updateOrCreate(
            ['name' => 'Conventional'],
            ['category' => 'Morning']
        );

        Program::updateOrCreate(
            ['name' => 'Creche'],
            ['category' => 'Morning']
        );

        Program::updateOrCreate(
            ['name' => 'Islamiyya'],
            ['category' => 'Evening']
        );

        Program::updateOrCreate(
            ['name' => 'Taafiz'],
            ['category' => 'Weekend']
        );
    }
}