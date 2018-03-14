<?php

namespace App;

class ItemReview extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAverageRatingAttribute()
    {
        return  ($this->facility_rating + $this->service_rating +
                    $this->cleanliness_rating + $this->value_for_money_rating) / 4;
    }

    public function getRatingRemarkAttribute()
    {
        $average_rating = $this->average_rating;

        if (($average_rating >= 5) AND ($average_rating <= 7)) {
            return 'fine';
        } elseif (($average_rating >= 7) AND ($average_rating <= 10)) {
            return 'good';
        } 

        return;
    }
}
