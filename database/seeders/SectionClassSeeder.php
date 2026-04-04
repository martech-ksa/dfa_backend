<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\SectionClass;

class SectionClassSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Conventional Classes
        |--------------------------------------------------------------------------
        */

        $conventional = Program::where('name', 'Conventional')->first();

        if ($conventional) {

            SectionClass::updateOrCreate(
                ['name' => 'Basic 1A', 'program_id' => $conventional->id],
                ['is_active' => true]
            );

            SectionClass::updateOrCreate(
                ['name' => 'Basic 1B', 'program_id' => $conventional->id],
                ['is_active' => true]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Islamiyya Classes
        |--------------------------------------------------------------------------
        */

        $islamiyya = Program::where('name', 'Islamiyya')->first();

        if ($islamiyya) {

            SectionClass::updateOrCreate(
                ['name' => 'Islamiyya Level 1', 'program_id' => $islamiyya->id],
                ['is_active' => true]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tahfiz Classes
        |--------------------------------------------------------------------------
        */

        $tahfiz = Program::where('name', 'Tahfiz')->first();

        if ($tahfiz) {

            SectionClass::updateOrCreate(
                ['name' => 'Tahfiz Beginner', 'program_id' => $tahfiz->id],
                ['is_active' => true]
            );
        }
    }
}