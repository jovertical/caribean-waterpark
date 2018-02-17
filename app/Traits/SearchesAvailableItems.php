<?php

namespace App\Traits;

use App\{Item, ItemCalendar};

trait SearchesAvailableItems {

    protected function filterItemCalendars($checkin_date, $checkout_date)
    {
        $items =    Item::with('category')->whereHas('category', function($category) {
                        $category->where('type', 'accomodation');
                    })
                    ->where('active', true)
                    ->get();

        $available_items = [];

        foreach ($items as $item) {
            $item_calendars =   ItemCalendar::where('item_id', $item->id)
                                    ->whereBetween('date', [
                                        $checkin_date->format('Y-m-d'),
                                        $checkout_date->format('Y-m-d')
                                    ])
                                    ->get();

            if ($item_calendars->filter(function($ic) use ($item) { return $ic->quantity >= $item->quantity; })->count() == 0) {
                $item->calendar = [
                    'quantity' => $item->quantity - $item_calendars->sum('quantity'),
                    'price' => $item->price * ($checkin_date->diffInDays($checkout_date))
                ];

                array_push($available_items, $item);
            }
        };

        return $available_items;
    }

    protected function filterItems($items, float $max_price)
    {
        return array_filter($items, function($item) use ($max_price) {
            return $item->calendar['price'] <= $max_price;
        });
    }
}