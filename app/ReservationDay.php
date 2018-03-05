<?php

namespace App;

class ReservationDay extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function getEnteredAtAttribute($value)
    {
        return $value != null ? date('h:i:s A', strtotime($value)) : null;
    }

    public function getExitedAtAttribute($value)
    {
        return $value != null ? date('h:i:s A', strtotime($value)) : null;
    }
}
