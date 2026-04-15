<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SectionClass extends Model
{
    protected $fillable = [
        'name',
        'program_id',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * A class belongs to a program
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * A class can have many students (many-to-many)
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
                    ->withTimestamps();
    }
}