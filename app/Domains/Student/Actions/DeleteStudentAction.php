<?php

namespace App\Domains\Student\Actions;

use App\Models\Student;

class DeleteStudentAction
{

    public function execute($studentId)
    {
        $student = Student::findOrFail($studentId);

        return $student->delete();
    }

}