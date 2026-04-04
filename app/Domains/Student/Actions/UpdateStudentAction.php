<?php

namespace App\Domains\Student\Actions;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicSession;
use App\Models\ClassArm;
use Illuminate\Support\Facades\DB;
use App\Domains\Student\DTO\StudentData;

class UpdateStudentAction
{
    public function execute(int $studentId, StudentData $data): Student
    {
        return DB::transaction(function () use ($studentId, $data) {

            $student = Student::findOrFail($studentId);

            /*
            |--------------------------------------------------------------------------
            | Update Student Core Data
            |--------------------------------------------------------------------------
            */

            $student->update([
                'first_name'    => $data->first_name,
                'other_names'   => $data->other_names,
                'last_name'     => $data->last_name,
                'gender'        => $data->gender,
                'date_of_birth' => $data->date_of_birth,
                'status'        => $data->status,
            ]);

            /*
            |--------------------------------------------------------------------------
            | MULTI-PROGRAM ENROLLMENT (STRICT & CLEAN)
            |--------------------------------------------------------------------------
            */

            if (!empty($data->class_selection)) {

                $sessionId = AcademicSession::where('is_current', true)->value('id');

                // 🔥 Track programs selected in this update
                $selectedProgramIds = [];

                foreach ($data->class_selection as $classArmId) {

                    $classArm = ClassArm::with('level.program')->find($classArmId);
                    if (!$classArm) continue;

                    $programId = $classArm->level->program->id;

                    $selectedProgramIds[] = $programId;

                    /*
                    |--------------------------------------------------------------------------
                    | KEY FIX: Match by student + program + session
                    |--------------------------------------------------------------------------
                    */
                    Enrollment::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'program_id' => $programId,
                            'academic_session_id' => $sessionId,
                        ],
                        [
                            'class_arm_id' => $classArmId,
                        ]
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | REMOVE UNCHECKED PROGRAMS (VERY IMPORTANT)
                |--------------------------------------------------------------------------
                */
                Enrollment::where('student_id', $student->id)
                    ->where('academic_session_id', $sessionId)
                    ->whereNotIn('program_id', $selectedProgramIds)
                    ->delete();

                /*
                |--------------------------------------------------------------------------
                | Update Default Class (optional shortcut)
                |--------------------------------------------------------------------------
                */
                $student->update([
                    'class_arm_id' => $data->class_selection[0]
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Return Fresh Data (optimized eager loading)
            |--------------------------------------------------------------------------
            */
            return $student->fresh([
                'classArm',
                'enrollments.classArm.level.program',
                'enrollments.academicSession'
            ]);
        });
    }
}