<?php

namespace App;

class ReservationItem extends Model
{
    public function cart()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function getNetPayableAttribute()
    {
        return $this->price_payable - $this->price_taxable - $this->price_deductable;
    }
}
