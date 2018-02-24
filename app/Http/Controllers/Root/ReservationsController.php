<?php

namespace App\Http\Controllers\Root;

use App\{Reservation, Category, Item, ItemCalendar};
use Helper;
use Str, Carbon, Notify;
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
                                $category->where('active', true);
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
                        $item->calendar_occupied = 0;
                        $item->calendar_unoccupied = $item->quantity - $item_calendar->sum('quantity');
                        $item->calendar_price = $item->price * ($checkin_date->diffInDays($checkout_date) + 1);
                        $item->order_quantity = 0;
                        $item->order_price = 0;

                        $available_items->push($item);
                    }
                });

                $items = $available_items;
            }
        }

        if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
            (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d'))) {

            session(['reservation.available_items' => $items->all()]);
            session(['reservation.selected_items' => []]);
        }

        session(['reservation.checkin_date' => $checkin_date->format('Y-m-d')]);
        session(['reservation.checkout_date' => $checkout_date->format('Y-m-d')]);

        return view('root.reservation.search_items', [
            'available_items' => Helper::paginate(session()->get('reservation.available_items'), 5),
            'selected_items' => session()->get('reservation.selected_items')
        ]);
    }

    public function addItem(Request $request, $index)
    {
        $quantity = (int) $request->input('quantity');

        $available_items = session()->get('reservation.available_items');
        $selected_items = session()->get('reservation.selected_items');
        $item_added = $available_items[$index];

        if ($quantity <= $item_added->calendar_unoccupied) {
            if(! in_array($item_added->id, array_column($selected_items, 'id'))) {
                $item_added->calendar_occupied += $quantity;
                $item_added->calendar_unoccupied -= $quantity;
                $item_added->order_quantity = $quantity;
                $item_added->order_price = $item_added->calendar_price * $quantity;

                session()->push('reservation.selected_items', $item_added);

                Notify::success(Str::ucfirst($item_added->name).' added.', 'Success!');

                return back();
            }

            $item_added->calendar_occupied += $quantity;
            $item_added->calendar_unoccupied -= $quantity;
            $selected_items[array_search($item_added->id, array_column($selected_items, 'id'))]->order_quantity += $quantity;
            $item_added->order_price = $item_added->calendar_price * $item_added->order_quantity;

            Notify::success(Str::ucfirst($item_added->name).' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning(Str::ucfirst($item_added->name).' not added or quantity not updated.', 'Whooops?');

        return back();
    }

    public function removeItem(Request $request, $index)
    {
        $quantity = (int) $request->input('quantity');

        $available_items = session()->get('reservation.available_items');
        $selected_items = session()->get('reservation.selected_items');
        $item_removed = $selected_items[$index];

        if ($quantity <= $item_removed->order_quantity) {
            $item_removed->calendar_occupied -= $quantity;
            $item_removed->calendar_unoccupied += $quantity;
            $item_removed->order_quantity -= $quantity;
            $item_removed->order_price = $item_removed->calendar_price * $item_removed->order_quantity;

            if ($item_removed->order_quantity == 0) {
                session()->pull('reservation.selected_items.'.$index);

                Notify::success(Str::ucfirst($item_removed->name).' removed.', 'Success!');

                return back();
            }

            Notify::success(Str::ucfirst($item_removed->name).' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning(Str::ucfirst($item_removed->name).' not removed or quantity not updated.', 'Whooops?');

        return back();
    }

    public function showItems()
    {
        $items = session()->get('reservation.selected_items');

        return view('root.reservation.show_items', ['items' => $items ?? []]);
    }

    public function index()
    {
        $reservations = Reservation::latest()->get();

        return view('root.reservations.index', ['reservations' => $reservations]);
    }
}