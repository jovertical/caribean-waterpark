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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
