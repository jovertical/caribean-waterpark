<?php

namespace App;

class Item extends Model
{
    protected $casts = [
        'price' => 'float', 
        'quantity' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ItemReview::class);
    }

    public function createReview($user, $request)
    {
        return $this->reviews()->create([
            'user_id' => $user->id,
            'title' => $request['title'],
            'facility_rating' => $request['facility_rating'],
            'service_rating' => $request['service_rating'],
            'cleanliness_rating' => $request['cleanliness_rating'],
            'value_for_money_rating' => $request['value_for_money_rating'],
            'body' => $request['body']
        ]);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getFacilityRatingAttribute()
    {
        return $this->reviews()->sum('facility_rating') / max($this->reviews()->count(), 1);
    }

    public function getServiceRatingAttribute()
    {
        return $this->reviews()->sum('service_rating') / max($this->reviews()->count(), 1);
    }

    public function getCleanlinessRatingAttribute()
    {
        return $this->reviews()->sum('cleanliness_rating') / max($this->reviews()->count(), 1);
    }

    public function getValueForMoneyRatingAttribute()
    {
        return $this->reviews()->sum('value_for_money_rating') / max($this->reviews()->count(), 1);
    }

    public function getAverageRatingAttribute()
    {
        return  ($this->facility_rating + $this->service_rating +
                    $this->cleanliness_rating + $this->value_for_money_rating) / 4;
    }

    public function getRatingStarsAttribute()
    {
        $average_rating = $this->average_rating;

        if (($average_rating >= 5) AND ($average_rating < 6)) {
            return 1;
        } elseif (($average_rating >= 6) AND ($average_rating < 7)) {
            return 2;
        } elseif (($average_rating >= 7) AND ($average_rating < 8)) {
            return 3;
        } elseif (($average_rating >= 8) AND ($average_rating < 9)) {
            return 4;
        } elseif (($average_rating >= 9) AND ($average_rating <= 10)) {
            return 5;
        } else {
            return 0;
        }
    }

    public function getRatingRemarkAttribute()
    {
        $average_rating = $this->average_rating;

        if (($average_rating >= 5) AND ($average_rating <= 7)) {
            return 'fine';
        } elseif (($average_rating >= 7) AND ($average_rating <= 10)) {
            return 'good';
        }

        return 'No rating yet';
    }
}
