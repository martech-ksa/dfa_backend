<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = 'student_attendances';

    protected $fillable = [
        'student_id',
        'class_arm_id',
        'score'
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Each attendance belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Each attendance belongs to a class arm
    public function classArm()
    {
        return $this->belongsTo(ClassArm::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Ensure score never exceeds 10
    public function setScoreAttribute($value)
    {
        $this->attributes['score'] = min(max((int) $value, 0), 10);
    }
}