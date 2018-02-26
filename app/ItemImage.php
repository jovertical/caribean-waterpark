<?php

namespace App;

class ItemImage extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
