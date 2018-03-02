<?php

namespace App;

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

    public function reservation_items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function createReservationItem($item, $item_costs)
    {
        return $this->reservation_items()->create([
            'item_id'           => $item->id,
            'quantity'          => $item->order_quantity,
            'price_taxable'     => $item_costs['price_taxable'],
            'price_deductable'  => $item_costs['price_deductable'],
            'price_payable'     => $item_costs['price_payable']
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

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function getStatusCodeAttribute($value)
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
}