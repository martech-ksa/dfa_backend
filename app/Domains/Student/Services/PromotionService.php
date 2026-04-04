<?php

namespace App\Domains\Student\Services;

use App\Models\Enrollment;
use App\Models\ClassArm;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    public function promoteClass($fromClassArmId, $toClassArmId, $sessionId)
    {
        DB::beginTransaction();

        try {

            $students = Enrollment::where('class_arm_id', $fromClassArmId)
                ->whereHas('academicSession', function ($q) {
                    $q->where('is_current', true);
                })
                ->get();

            foreach ($students as $enrollment) {

                Enrollment::create([
                    'student_id' => $enrollment->student_id,
                    'class_arm_id' => $toClassArmId,
                    'academic_session_id' => $sessionId,
                ]);
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}