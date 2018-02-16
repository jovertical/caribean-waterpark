<?php

namespace App\Http\Controllers\Root;

use App\{Reservation, Item, ItemCalendar};
use Str, URL;
use Carbon, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::latest()->get();

        return view('root.reservations.index', ['reservations' => $reservations]);
    }

    public function searchItems()
    {
        $items = Item::all();

        return view('root.reservations.search_items', ['items' => $items]);
    }
}
