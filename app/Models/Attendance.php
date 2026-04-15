<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'lat',
        'lng',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getCheckInTimeAttribute()
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('H:i:s') : null;
    }

    public function getCheckOutTimeAttribute()
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('H:i:s') : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isLate()
    {
        return $this->status === 'late';
    }

    public function isPresent()
    {
        return !is_null($this->check_in);
    }

    public function isAbsent()
    {
        return is_null($this->check_in);
    }

    public function hasCheckedOut()
    {
        return !is_null($this->check_out);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    public function scopeForStaff($query, $staffId)
    {
        return $query->where('staff_id', $staffId);
    }
}