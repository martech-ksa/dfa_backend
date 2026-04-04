<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ClassArm extends Model
{
    use HasFactory;

    protected $table = 'class_arms';

    protected $fillable = [
        'arm',
        'level_id',
        'is_active',
    ];

    /**
     * Level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Enrollments
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Students via enrollments
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'class_arm_id',
            'id',
            'id',
            'student_id'
        );
    }

    /**
     * Full Class Name
     */
    public function getFullClassNameAttribute(): string
    {
        return $this->level
            ? $this->level->name . ' ' . $this->arm
            : $this->arm;
    }
}