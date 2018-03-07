<?php

namespace App;

use Carbon;

class Reservation extends Model
{
    public static function boot()
    {
        parent::boot();

        $user = auth()->check() ? auth()->user() : null;

        self::creating(function ($model) use ($user) {
            $model->source = $user->type = 'superuser' ? 'root' : 'frontend';
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function days()
    {
        return $this->hasMany(ReservationDay::class);
    }

    public function transactions()
    {
        return $this->hasMany(ReservationTransaction::class);
    }

    public function createReservationItem($item, $item_costs)
    {
        return $this->items()->create([
            'item_id'           => $item->id,
            'quantity'          => $item->order_quantity,
            'price'             => $item->price * $this->day_count,
            'price_taxable'     => $item->costs['price_taxable'],
            'price_subpayable'  => $item->costs['price_subpayable'],
            'price_deductable'  => $item->costs['price_deductable'],
            'price_payable'     => $item->costs['price_payable']
        ]);
    }

    public function createReservationDay($date, array $guests, array $rates)
    {
        return $this->days()->create([
            'date'              => $date,
            'adult_rate'        => $rates['adult'],
            'children_rate'     => $rates['children'],
            'adult_quantity'    => $guests['adult'],
            'children_quantity' => $guests['children']
        ]);
    }

    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = strtolower($value);
    }

    public function getSourceAttribute($value)
    {
        return ucfirst($value);
    }

    public function setCheckinDateAttribute($value)
    {
        $this->attributes['checkin_date'] = date('Y-m-d', strtotime($value));
    }

    public function getCheckinDateAttribute($value)
    {
        return $value;
    }

    public function setCheckoutDateAttribute($value)
    {
        $this->attributes['checkout_date'] = date('Y-m-d', strtotime($value));
    }

    public function getCheckoutDateAttribute($value)
    {
        return $value;
    }

    public function getDayCountAttribute()
    {
        return Carbon::parse($this->checkin_date)->diffIndays(Carbon::parse($this->checkout_date)) + 1;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function getStatusCodeAttribute()
    {
        switch (strtolower($this->status)) {
            case 'pending':
                    $status_code = 1;
                break;
            case 'reserved':
                    $status_code = 2;
                break;
            case 'paid':
                    $status_code = 3;
                break;
            case 'cancelled':
                    $status_code = 4;
                break;
            case 'waiting':
                    $status_code = 5;
                break;
            case 'void':
                    $status_code = 6;
                break;
        }

        return $status_code;
    }

    public function getStatusClassAttribute()
    {
        switch (strtolower($this->status)) {
            case 'pending':
                    $status_class = 'warning';
                break;
            case 'reserved':
                    $status_class = 'info';
                break;
            case 'paid':
                    $status_class = 'success';
                break;
            case 'cancelled':
                    $status_class = 'danger';
                break;
            case 'waiting':
                    $status_class = 'brand';
                break;
            case 'void':
                    $status_class = 'metal';
                break;
        }

        return $status_class;
    }

    public function getHasEnteredAttribute()
    {
        $date_now = date('Y-m-d');

        if (in_array($date_now, array_column($this->days->all(), 'date'))) {
            if ($this->days->where('date', $date_now)->where('entered', true)->count() == 1) {
                return true;
            }
        }

        return false;
    }

    public function getHasExitedAttribute()
    {
        $date_now = date('Y-m-d');

        if (in_array($date_now, array_column($this->days->all(), 'date'))) {
            if ($this->days->where('date', $date_now)->where('exited', true)->count() == 1) {
                return true;
            }
        }

        return false;
    }
}