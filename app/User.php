<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFirstNameAttribute($value)
    {
        return strtolower($value);
    }

    public function getMiddleNameAttribute($value)
    {
        return strtolower($value);
    }

    public function getLastNameAttribute($value)
    {
        return strtolower($value);
    }
}
