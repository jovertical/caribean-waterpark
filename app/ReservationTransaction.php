<?php

namespace App;

class ReservationTransaction extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }

    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }

    public function getTypeCodeAttribute()
    {
        switch (strtolower($this->type)) {
            case 'payment':
                    $status_code = 1;
                break;
            case 'refund':
                    $status_code = 2;
                break;
        }

        return $status_code;
    }

    public function setModeAttribute($value)
    {
        $this->attributes['mode'] = strtolower($value);
    }

    public function getModeAttribute($value)
    {
        return ucfirst($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (float) $value;
    }
}