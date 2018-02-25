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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = strtolower($value);
    }

    public function getMiddleNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtolower($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = strtolower($value);
    }

    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }
}
