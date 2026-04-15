<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'office_lat',
        'office_lng',
        'radius',
        'resumption_time'
    ];
}