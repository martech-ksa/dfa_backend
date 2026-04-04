<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultSetting extends Model
{
    protected $fillable = [
        'ca1',
        'ca2',
        'attendance',
        'exam'
    ];
}