<?php

namespace App;

class Coupon extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function item_coupon_applicables()
    {
        return $this->hasMany(ItemCouponApplicables::class);
    }
}
