<?php

namespace App;

class Category extends Model
{
    public static function boot()
    {
        parent::boot();

        static::deleting(function($items) {
            $items->items()->each(function($item) {
                $item->delete();
            });
        });
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
