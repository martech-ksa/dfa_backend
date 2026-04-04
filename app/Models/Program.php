<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'category',
        'schedule',
        'description',
        'is_active',
    ];

    /**
     * A program has many section classes
     */
    public function sectionClasses()
    {
        return $this->hasMany(SectionClass::class);
    }
}