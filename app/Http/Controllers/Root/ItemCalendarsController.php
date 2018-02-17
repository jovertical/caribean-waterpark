<?php

namespace App\Http\Controllers\Root;

use App\Traits\{SearchesAvailableItems};
use Carbon, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemCalendarsController extends Controller
{
    use SearchesAvailableItems;

    public function searchItems(Request $request)
    {
        $items = [];

        if (($request->input('checkin_date') != null) && ($request->input('checkout_date') != null)) {
            $checkin_date   = Carbon::parse($request->input('checkin_date'));
            $checkout_date  = Carbon::parse($request->input('checkout_date'));
            $max_price      = $request->input('max_price') ?? 0.00;

            $items = $this->filterItemCalendars($checkin_date, $checkout_date);

            $items = $this->filterItems($items, $max_price);
        }

        return view('root.reservations.search_items', ['items' => $items]);
    }
}