<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Spatie permission guard
     */
    protected $guard_name = 'web';


    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}