<?php

namespace App\Traits;

use App\ItemCalendar;

trait SearchesAvailableItems {

    protected function filterItemCalendars($items, $checkin_date, $checkout_date)
    {
        $available_items = collect([]);

        $items->each(function($item) use ($available_items, $checkin_date, $checkout_date) {
            $item_calendar =    ItemCalendar::where('item_id', $item->id)
                                    ->whereBetween('date', [
                                        $checkin_date->format('Y-m-d'),
                                        $checkout_date->format('Y-m-d')
                                    ])
                                    ->get();

            if ($item_calendar->filter(function($ic) use ($item) { return $ic->quantity <= $item->quantity; })->count() == 0) {
                $item->calendar_quantity = $item->quantity - $item_calendar->sum('quantity');
                $item->calendar_price = $item->price * ($checkin_date->diffInDays($checkout_date) + 1);

                $available_items->push($item);
            }
        });

        return $available_items;
    }
}