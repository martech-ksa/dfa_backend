<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    protected $table = 'student_results';

    protected $fillable = [
        'student_id',
        'class_arm_id',
        'subject_id',
        'first_ca',
        'second_ca',
        'exam',
        'total',
        'grade'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Class Arm
    public function classArm()
    {
        return $this->belongsTo(ClassArm::class);
    }

}