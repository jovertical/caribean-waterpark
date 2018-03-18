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
            $model->source = $user->environment;
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
            'item_id'           => $item->item->id,
            'quantity'          => $item->quantity,
            'price_original'    => $item->item->price,
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

    public function createReservationTransaction($type, $mode, float $amount)
    {
        return $this->transactions()->create(['type' => $type, 'mode' => $mode, 'amount' => $amount]);
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

    public function getNetPayableAttribute()
    {
        return $this->price_payable - $this->price_taxable - $this->price_deductable;
    }

    public function getPriceLeftPayableAttribute()
    {
        return $this->price_payable - $this->price_paid;
    }

    /**
     * Check if price left payable property == 0.
     * @return boolean
     */
    public function getFullyPaidAttribute()
    {
        return $this->price_left_payable == 0 ? true : false;
    }

    public function getRefundableStatusesAttribute()
    {
        return ['cancelled'];
    }

    /**
     * Determine if reservation is refundable
     * @return boolean
     */
    public function getRefundableAttribute()
    {
        $days_prior = Carbon::parse($this->checkin_date)->addDays(1)
                        ->diffInDays(Carbon::now());

        $payment_transactions = $this->transactions->filter(function($t) {
                                    return strtolower($t->type) == 'payment';
                                });

        $refund_transactions =  $this->transactions->filter(function($t) {
                                    return strtolower($t->type) == 'refund';
                                });

        if (($this->days_refundable != null) AND ($days_prior >= $this->days_refundable)) {
            if ($payment_transactions->count()) {
                if (in_array(strtolower($this->status), $this->refundable_statuses)) {
                    return $refund_transactions->count() == 0 ? 1 : 0;
                }

                return $refund_transactions->count() == 0 ? 1 : 0;
            }

            return 1;
        }

        return 0;
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
        $status_class = '';

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