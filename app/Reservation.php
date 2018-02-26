<?php

namespace App;

class Reservation extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reservation_items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
