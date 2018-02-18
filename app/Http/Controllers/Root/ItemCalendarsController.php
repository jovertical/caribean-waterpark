<?php

namespace App\Http\Controllers\Root;

use App\Item;
use Helper;
use App\Traits\{SearchesAvailableItems};
use Carbon, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemCalendarsController extends Controller
{
    use SearchesAvailableItems;

    public function searchItems(Request $request)
    {
        $checkin_date = $request->input('ci');
        $checkout_date = $request->input('co');

        $items = [];

        if (($checkin_date != null) && ($checkout_date != null)) {
            $checkin_date   = Carbon::parse($checkin_date);
            $checkout_date  = Carbon::parse($checkout_date);

            if ($checkin_date <= $checkout_date) {
                $price =    $request->input('mp') / ($checkin_date->diffInDays($checkout_date) + 1);

                $items =    Item::with('category')->whereHas('category', function($category) {
                                $category->where('type', 'accomodation');
                            })
                            ->where('active', true)
                            ->where('price', '<=', $price)
                            ->orderBy('price');

                $items = $this->filterItemCalendars($items, $checkin_date, $checkout_date);
            }
        }

        return view('root.reservations.search_items', ['items' => Helper::paginate($items, 5)]);
    }
}