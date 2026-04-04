<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\ClassArm;

class ImportIslamiyyaStudents extends Command
{
    protected $signature = 'import:islamiyya';

    protected $description = 'Import Islamiyya students';

    public function handle()
    {
        $this->info('Starting Islamiyya import...');

        // 🔥 Mapping OLD class_id → NEW level_id
        $classMap = [
            7  => 18,
            8  => 18,
            9  => 19,
            10 => 20,
        ];

        // 🔥 Get old students
        $oldStudents = DB::connection('mysql_old')
            ->table('acad_students')
            ->get();

        foreach ($oldStudents as $old) {

            // Skip if not mapped
            if (!isset($classMap[$old->class_id])) {
                $this->warn("Skipped: {$old->full_name}");
                continue;
            }

            // Create student
            $student = Student::firstOrCreate(
                ['admission_number' => $old->reg_number],
                [
                    'first_name'  => $old->first_name ?? $old->full_name,
                    'last_name'   => $old->surname ?? '',
                    'other_names' => $old->middle_name ?? '',
                    'gender'      => 'male',
                    'status'      => 'active',
                ]
            );

            // Get class arm
            $classArm = ClassArm::where('level_id', $classMap[$old->class_id])->first();

            if (!$classArm) {
                $this->error("No class arm for level {$classMap[$old->class_id]}");
                continue;
            }

            // Attach student to class
            $student->classArms()->syncWithoutDetaching([$classArm->id]);

            $this->info("Imported: {$student->first_name}");
        }

        $this->info('Import completed successfully.');
    }
}