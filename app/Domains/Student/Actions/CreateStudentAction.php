<?php

namespace App\Domains\Student\Actions;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;

use App\Domains\Student\DTO\StudentData;

class CreateStudentAction
{
    public function execute(StudentData $data)
    {
        DB::beginTransaction();

        try {

            // ✅ Create student (NO class_arm_id here)
            $student = Student::create([
                'first_name'     => $data->first_name,
                'other_names'    => $data->other_names,
                'last_name'      => $data->last_name,
                'gender'         => $data->gender,
                'date_of_birth'  => $data->date_of_birth,
                'status'         => $data->status,
            ]);

            // ✅ Get current session
            $session = AcademicSession::where('is_current', 1)->first();

            if (!$session) {
                throw new \Exception("No active academic session found.");
            }

            // ✅ MULTI-CLASS ENROLLMENT
            foreach ($data->class_selection as $classArmId) {

                Enrollment::create([
                    'student_id'          => $student->id,
                    'class_arm_id'        => $classArmId,
                    'academic_session_id' => $session->id
                ]);
            }

            DB::commit();

            return $student;

        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}