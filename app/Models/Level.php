<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program_id',
        'is_active',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function classArms()
    {
        return $this->hasMany(ClassArm::class);
    }
}