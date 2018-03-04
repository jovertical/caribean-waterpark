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

    public static function boot()
    {
        parent::boot();

        $user = auth()->check() ? auth()->user() : null;

        self::creating(function ($model) use ($user) {
            $model->slug = str_random(20);

            if ($user != null) {
                $model->created_by = $user->id;
            }
        });

        self::updating(function($model) use ($user) {
            if ($user != null) {
                $model->updated_by = $user->id;
            }
        });

        self::deleting(function($model) use ($user) {
            if ($user != null) {
                $model->deleted_by = $user->id;
            }
        });
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function createReservation($reference_number, $checkin_date, $checkout_date, $item_costs)
    {
        return $this->reservations()->create([
            'reference_number'  => $reference_number,
            'checkin_date'      => $checkin_date,
            'checkout_date'     => $checkout_date,
            'price_taxable'     => $item_costs['price_taxable'],
            'price_subpayable'  => $item_costs['price_subpayable'],
            'price_deductable'  => $item_costs['price_deductable'],
            'price_payable'     => $item_costs['price_payable'],
        ]);
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

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = strtolower($value);
    }

    public function getAddressAttribute($value)
    {
        return ucfirst($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}