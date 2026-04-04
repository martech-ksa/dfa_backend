<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Level;
use App\Models\ClassArm;

class SchoolStructureSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | PROGRAMS
        |--------------------------------------------------------------------------
        */

        $conventional = Program::create([
            'name' => 'Conventional Morning',
            'category' => 'morning'
        ]);

        $creche = Program::create([
            'name' => 'Creche Morning',
            'category' => 'morning'
        ]);

        $islamiyya = Program::create([
            'name' => 'Islamiyya Evening',
            'category' => 'evening'
        ]);

        $tahfiz = Program::create([
            'name' => 'Tahfiz Weekend',
            'category' => 'weekend'
        ]);


        /*
        |--------------------------------------------------------------------------
        | CONVENTIONAL MORNING LEVELS
        |--------------------------------------------------------------------------
        */

        $conventionalLevels = [

            'KG 1',
            'KG 2',

            'Nursery 1',
            'Nursery 2',

            'Primary 1',
            'Primary 2',
            'Primary 3',
            'Primary 4',
            'Primary 5',
            'Primary 6',

            'JSS 1',
            'JSS 2',
            'JSS 3',

            'SS 1',
            'SS 2',
            'SS 3'
        ];

        foreach ($conventionalLevels as $levelName) {

            $level = Level::create([
                'name' => $levelName,
                'program_id' => $conventional->id
            ]);

            ClassArm::create([
                'level_id' => $level->id,
                'arm' => 'A',
                'is_active' => true
            ]);

            ClassArm::create([
                'level_id' => $level->id,
                'arm' => 'B',
                'is_active' => true
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CRECHE LEVELS
        |--------------------------------------------------------------------------
        */

        $crecheLevels = [
            'Baby',
            'Toddlers'
        ];

        foreach ($crecheLevels as $levelName) {

            $level = Level::create([
                'name' => $levelName,
                'program_id' => $creche->id
            ]);

            ClassArm::create([
                'level_id' => $level->id,
                'arm' => 'A',
                'is_active' => true
            ]);

            ClassArm::create([
                'level_id' => $level->id,
                'arm' => 'B',
                'is_active' => true
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ISLAMIYYA EVENING
        |--------------------------------------------------------------------------
        */

        $islamiyyaLevels = [
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4',
            'Class 5'
        ];

        foreach ($islamiyyaLevels as $levelName) {

            $level = Level::create([
                'name' => $levelName,
                'program_id' => $islamiyya->id
            ]);

            // Only Class 1 has arms
            if ($levelName === 'Class 1') {

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => 'A',
                    'is_active' => true
                ]);

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => 'B',
                    'is_active' => true
                ]);

            } else {

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => '',
                    'is_active' => true
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TAHFIZ WEEKEND
        |--------------------------------------------------------------------------
        */

        $tahfizLevels = [
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4',
            'Class 5'
        ];

        foreach ($tahfizLevels as $levelName) {

            $level = Level::create([
                'name' => $levelName,
                'program_id' => $tahfiz->id
            ]);

            if ($levelName === 'Class 1') {

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => 'A',
                    'is_active' => true
                ]);

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => 'B',
                    'is_active' => true
                ]);

            } else {

                ClassArm::create([
                    'level_id' => $level->id,
                    'arm' => '',
                    'is_active' => true
                ]);
            }
        }
    }
}