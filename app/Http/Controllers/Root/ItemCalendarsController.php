<?php

namespace App\Http\Controllers\Root;

use App\Item;
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

            if ($checkin_date <= $checkout_date) {
                $price =    $request->input('max_price') / ($checkin_date->diffInDays($checkout_date) + 1);

                $items =    Item::with('category')->whereHas('category', function($category) {
                                $category->where('type', 'accomodation');
                            })
                            ->where('active', true)
                            ->where('price', '<=', $price)
                            ->orderBy('price')
                            ->get();

                $items = $this->filterItemCalendars($items, $checkin_date, $checkout_date);
            }

            return view('root.reservations.search_items', ['items' => $items]);
        }
    }
}