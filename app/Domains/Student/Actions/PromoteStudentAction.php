<?php

namespace App\Domains\Student\Actions;

use App\Models\Enrollment;

class PromoteStudentAction
{

    public function execute($studentId, $newClassArmId, $sessionId)
    {

        return Enrollment::create([
            'student_id' => $studentId,
            'class_arm_id' => $newClassArmId,
            'academic_session_id' => $sessionId
        ]);

    }

}