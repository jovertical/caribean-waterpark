<?php

namespace App\Http\Controllers\Root;

use App\{Reservation, Category, Item, ItemCalendar};
use Helper;
use Carbon, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    public function searchItems(Request $request)
    {
        $checkin_date = Carbon::parse($request->input('ci'));
        $checkout_date = Carbon::parse($request->input('co'));

        $items = collect([]);

        if (($request->input('ci') != null) AND ($request->input('co') != null)) {
            if ($checkin_date <= $checkout_date) {
                $items =    Item::with('category')->whereHas('category', function($category) {
                                $category->where('type', 'accomodation');
                            })
                            ->where('active', true)
                            ->orderBy('price');

                $available_items = collect([]);

                $items->each(function($item) use ($available_items, $checkin_date, $checkout_date) {
                    $item_calendar =    ItemCalendar::where('item_id', $item->id)
                                            ->whereBetween('date', [
                                                $checkin_date->format('Y-m-d'),
                                                $checkout_date->format('Y-m-d')
                                            ])
                                            ->get();

                    $count = $item_calendar->filter(function($ic) use ($item) {
                        return $ic->quantity <= $item->quantity;
                    })->count();

                    if ($count == 0) {
                        $item->calendar_quantity = $item->quantity - $item_calendar->sum('quantity');
                        $item->calendar_price = $item->price * ($checkin_date->diffInDays($checkout_date) + 1);

                        $available_items->push($item);
                    }
                });

                $items = $available_items;
            }
        }

        if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
            (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d'))) {

            session(['reservation.available_items' => $items]);
            session(['reservation.selected_items' => collect([])]);
        }

        session(['reservation.checkin_date' => $checkin_date->format('Y-m-d')]);
        session(['reservation.checkout_date' => $checkout_date->format('Y-m-d')]);

        return view('root.reservations.search_items', [
            'available_items' => Helper::paginate(session()->get('reservation.available_items'), 5),
            'selected_items' => collect([])
        ]);
    }

    public function addItem(Request $request, $index)
    {
        

        return redirect()->back();
    }

    public function index()
    {
        $reservations = Reservation::latest()->get();

        return view('root.reservations.index', ['reservations' => $reservations]);
    }
}