<?php

namespace App;

class ItemCalendar extends Model
{
    protected $casts = [
        'date'      => 'D-m-y',
        'quantity'  => 'int'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
