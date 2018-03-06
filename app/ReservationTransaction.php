<?php

namespace App;

class ReservationTransaction extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}