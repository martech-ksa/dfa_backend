<?php

namespace App\Domains\Enrollment\Services;

use App\Models\Enrollment;

class EnrollmentService
{

    public function enrollStudent($studentId, $classArmId, $sessionId)
    {

        return Enrollment::create([
            'student_id' => $studentId,
            'class_arm_id' => $classArmId,
            'academic_session_id' => $sessionId
        ]);

    }

}