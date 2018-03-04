<?php

namespace App;

class ReservationDay extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
