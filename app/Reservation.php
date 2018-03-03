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

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function createReservationItem($item, $item_costs)
    {
        return $this->items()->create([
            'item_id'           => $item->id,
            'quantity'          => $item->order_quantity,
            'price_taxable'     => $item->costs['price_taxable'],
            'price_subpayable'  => $item->costs['price_subpayable'],
            'price_deductable'  => $item->costs['price_deductable'],
            'price_payable'     => $item->costs['price_payable']
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

    public function getStatusClassAttribute($value)
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
}