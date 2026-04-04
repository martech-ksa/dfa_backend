<?php

namespace App\Domains\Student\Repositories;

use App\Models\Student;

class StudentRepository
{

    public function create(array $data)
    {
        return Student::create($data);
    }

    public function getAll()
    {
        return Student::with([
            'enrollments.classArm.level.program',
            'enrollments.academicSession'
        ])
        ->latest()
        ->paginate(20);
    }

    public function find($id)
    {
        return Student::findOrFail($id);
    }

}