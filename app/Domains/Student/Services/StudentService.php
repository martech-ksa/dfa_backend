<?php

namespace App\Domains\Student\Services;

use App\Models\Student;

use App\Domains\Student\DTO\StudentData;
use App\Domains\Student\Actions\CreateStudentAction;
use App\Domains\Student\Actions\UpdateStudentAction;
use App\Domains\Student\Actions\DeleteStudentAction;

class StudentService
{
    protected $createStudentAction;
    protected $updateStudentAction;
    protected $deleteStudentAction;

    public function __construct(
        CreateStudentAction $createStudentAction,
        UpdateStudentAction $updateStudentAction,
        DeleteStudentAction $deleteStudentAction
    ) {
        $this->createStudentAction = $createStudentAction;
        $this->updateStudentAction = $updateStudentAction;
        $this->deleteStudentAction = $deleteStudentAction;
    }

    /*
    |--------------------------------------------------------------------------
    | Get Students List
    |--------------------------------------------------------------------------
    */

    public function getStudents()
    {
        return Student::with([
            'classArm.level.program'
        ])
        ->latest()
        ->paginate(15);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Single Student Profile
    |--------------------------------------------------------------------------
    */

    public function getStudentProfile($studentId)
    {
        return Student::with([
            'classArm.level.program'
        ])->findOrFail($studentId);
    }

    /*
    |--------------------------------------------------------------------------
    | Create Student (UPDATED → DTO)
    |--------------------------------------------------------------------------
    */

    public function createStudent(StudentData $data)
    {
        return $this->createStudentAction->execute($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Student (UPDATED → DTO)
    |--------------------------------------------------------------------------
    */

    public function updateStudent($studentId, StudentData $data)
    {
        return $this->updateStudentAction->execute($studentId, $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Student
    |--------------------------------------------------------------------------
    */

    public function deleteStudent($studentId)
    {
        return $this->deleteStudentAction->execute($studentId);
    }
}