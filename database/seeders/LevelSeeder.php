<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $conventional = Program::where('name', 'Conventional')->first();
        $creche       = Program::where('name', 'Creche')->first();
        $islamiyya    = Program::where('name', 'Islamiyya')->first();
        $taafiz       = Program::where('name', 'Taafiz')->first();

        // Conventional Levels
        $conventionalLevels = [
            'KG1', 'KG2',
            'Nursery 1', 'Nursery 2',
            'Basic 1', 'Basic 2', 'Basic 3',
            'Basic 4', 'Basic 5',
            'JSS 1', 'JSS 2', 'JSS 3'
        ];

        foreach ($conventionalLevels as $level) {
            Level::firstOrCreate([
                'name' => $level,
                'program_id' => $conventional->id,
            ]);
        }

        // Creche Levels
        foreach (['Creche 1', 'Creche 2'] as $level) {
            Level::firstOrCreate([
                'name' => $level,
                'program_id' => $creche->id,
            ]);
        }

        // Islamiyya Levels
        foreach (['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'] as $level) {
            Level::firstOrCreate([
                'name' => $level,
                'program_id' => $islamiyya->id,
            ]);
        }

        // Taafiz Levels
        foreach (['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'] as $level) {
            Level::firstOrCreate([
                'name' => $level,
                'program_id' => $taafiz->id,
            ]);
        }
    }
}