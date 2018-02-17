<?php

namespace App\Traits;

use App\ItemCalendar;

trait SearchesAvailableItems {

    protected function filterItemCalendars($items, $checkin_date, $checkout_date)
    {
        $available_items = [];

        foreach ($items as $item) {
            $item_calendars =   ItemCalendar::where('item_id', $item->id)
                                    ->whereBetween('date', [
                                        $checkin_date->format('Y-m-d'),
                                        $checkout_date->format('Y-m-d')
                                    ])
                                    ->get();

            if ($item_calendars->filter(function($ic) use ($item) { return $ic->quantity >= $item->quantity; })->count() == 0) {
                $item->calendar_quantity = $item->quantity - $item_calendars->sum('quantity');
                $item->calendar_price = $item->price * ($checkin_date->diffInDays($checkout_date) + 1);
                array_push($available_items, $item);
            }
        };

        return $available_items;
    }
}