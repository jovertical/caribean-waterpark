<?php

namespace App;

class Reservation extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
