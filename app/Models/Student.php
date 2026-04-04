<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'admission_number',
        'first_name',
        'other_names',
        'last_name',
        'gender',
        'date_of_birth',
        'status',
        'class_arm_id', // ✅ current class shortcut
    ];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    /*
    |--------------------------------------------------------------------------
    | Booted Method (Admission Number Generator)
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function ($student) {

            if (!$student->admission_number) {

                $year = now()->year;

                $lastStudent = self::whereYear('created_at', $year)
                    ->orderByDesc('id')
                    ->first();

                $sequence = 1;

                if ($lastStudent && $lastStudent->admission_number) {
                    $lastSequence = substr($lastStudent->admission_number, -4);
                    $sequence = (int) $lastSequence + 1;
                }

                $student->admission_number =
                    'DFA/' . $year . '/' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Current Class (FAST ACCESS)
     */
    public function classArm(): BelongsTo
    {
        return $this->belongsTo(ClassArm::class);
    }

    /**
     * Enrollment History
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Current Enrollment (based on active session)
     */
    public function currentEnrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class)
            ->whereHas('academicSession', function ($query) {
                $query->where('is_current', true);
            });
    }

    /**
     * Class history (via enrollments)
     */
    public function classArms(): HasManyThrough
    {
        return $this->hasManyThrough(
            ClassArm::class,
            Enrollment::class,
            'student_id',
            'id',
            'id',
            'class_arm_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TIMELINE (🔥 FIXED - REQUIRED BY CONTROLLER)
    |--------------------------------------------------------------------------
    */

    /**
     * Student Timeline (Enrollment + Class + Session History)
     */
    public function timeline()
    {
        return $this->enrollments()
            ->with([
                'classArm.level.program',
                'academicSession'
            ])
            ->orderByDesc('created_at')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Full Name
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->other_names} {$this->last_name}");
    }

    /**
     * Formatted Date of Birth
     */
    public function getFormattedDobAttribute(): ?string
    {
        return $this->date_of_birth?->format('d M Y');
    }

    /**
     * DOB for Form Input
     */
    public function getDobForInputAttribute(): ?string
    {
        return $this->date_of_birth?->format('Y-m-d');
    }

    /**
     * Age
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }
}