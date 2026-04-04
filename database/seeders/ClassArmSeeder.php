<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use App\Models\ClassArm;

class ClassArmSeeder extends Seeder
{
    public function run(): void
    {
        $levels = Level::all();

        foreach ($levels as $level) {

            // For now create only Arm A
            ClassArm::firstOrCreate([
                'arm' => 'A',
                'level_id' => $level->id,
            ]);

            // Optional: Uncomment to auto-create B arm
            /*
            ClassArm::firstOrCreate([
                'arm' => 'B',
                'level_id' => $level->id,
            ]);
            */
        }
    }
}