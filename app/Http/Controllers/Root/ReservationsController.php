<?php

namespace App\Http\Controllers\Root;

use App\Traits\{ComputesCosts};
use App\{User, Reservation, Category, Item, ItemCalendar};
use Helper;
use Str, Carbon, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    use ComputesCosts;

    /**
     * Search calendar for available items, compute costs as well.
     * @param  Request $request
     * @return view
     */
    public function searchItems(Request $request)
    {
        $checkin_date = Carbon::parse($request->input('ci'));
        $checkout_date = Carbon::parse($request->input('co'));
        $earliest = Carbon::parse(now()->addDays(1)->format('Y-m-d'));

        $items = collect([]);

        if (($request->input('ci') != null) AND ($request->input('co') != null)) {
             // check for invalid date
            if (($checkin_date < $earliest) OR ($checkout_date < $earliest) OR ($checkin_date > $checkout_date)) {
                // set reservation data to empty array
                session(['reservation' => []]);

                Notify::warning('Please select a valid date.', 'Whooops?');

                return redirect()->route('root.reservation.search-items');
            }

            $items =    Item::with('category')->whereHas('category', function($category) {
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

        // check if dates are the same, if not clear the items array.
        if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
            (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d'))) {

            // set the items array as empty
            session(['reservation.available_items' => $items->all()]);
            session(['reservation.selected_items' => []]);
        }

        // set reservation dates
        session(['reservation.checkin_date' => $checkin_date->format('Y-m-d')]);
        session(['reservation.checkout_date' => $checkout_date->format('Y-m-d')]);
        session(['reservation.days' => $checkin_date->diffInDays($checkout_date)]);

        return view('root.reservation.search_items', [
            'available_items' => Helper::paginate(session()->get('reservation.available_items')),
            'selected_items' => session()->get('reservation.selected_items')
        ]);
    }

    /**
     * Add specific item to the cart.
     * @param  Request $request
     * @param  int  $index
     * @return back
     */
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

                // push the item to the selected_items array
                session()->push('reservation.selected_items', $item_added);

                // re-compute item costs
                session([
                    'reservation.item_costs' => $this->computeItemCosts(session()->get('reservation.selected_items'))
                ]);

                Notify::success($item_added->name.' added.', 'Success!');

                return back();
            }

            $item_added->calendar_occupied += $quantity;
            $item_added->calendar_unoccupied -= $quantity;
            $selected_items[array_search($item_added->id, array_column($selected_items, 'id'))]->order_quantity += $quantity;
            $item_added->order_price = $item_added->calendar_price * $item_added->order_quantity;

            // re-compute item costs
            session([
                'reservation.item_costs' => $this->computeItemCosts(session()->get('reservation.selected_items'))
            ]);

            Notify::success($item_added->name.' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning($item_added->name.' not added or quantity not updated.', 'Whooops?');

        return back();
    }

    /**
     * Remove specific item from the cart.
     * @param  Request $request
     * @param  int  $index
     * @return back
     */
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
                // pull the item from the selected_items array
                session()->pull('reservation.selected_items.'.$index);

                // re-compute item costs
                session([
                    'reservation.item_costs' => $this->computeItemCosts(session()->get('reservation.selected_items'))
                ]);

                Notify::success($item_removed->name.' removed.', 'Success!');

                return back();
            }

            // re-compute item costs
            session([
                'reservation.item_costs' => $this->computeItemCosts(session()->get('reservation.selected_items'))
            ]);

            Notify::success($item_removed->name.' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning($item_removed->name.' not removed or quantity not updated.', 'Whooops?');

        return back();
    }

    /**
     * Clear all cart items
     * @return back
     */
    public function clearItems()
    {
        try {
            session(['reservation.selected_items' => []]);

            // re-compute item costs
            session([
                'reservation.item_costs' => $this->computeItemCosts(session()->get('reservation.selected_items'))
            ]);

            Notify::success('Items removed.', 'Success!');
        } catch (Exception $e) {
            Notify::error($e, 'Whooops!');
        }

        return back();
    }

    /**
     * Show selected items
     * @return view
     */
    public function showItems()
    {
        $items = session()->get('reservation.selected_items') ?? [];
        $item_costs = session()->get('reservation.item_costs');

        return view('root.reservation.show_items', [
            'items' => $items,
            'item_costs' => $item_costs
        ]);
    }

    /**
     *
     * @return view
     */
    public function user()
    {
        $users = User::get()->all();

        return view('root.reservation.user', [
            'users' => $users
        ]);
    }

    /**
     * Store the reservation.
     * @param  Request $request
     * @param  User    $user
     * @return
     */
    public function store(Request $request, User $user)
    {
        $selected_items = session()->get('reservation.selected_items');
        $checkin_date = session()->get('reservation.checkin_date');
        $checkout_date = session()->get('reservation.checkout_date');

        dd(session()->all());

        try {
            if ($this->selectedItemsValid($selected_items, $checkin_date, $checkout_date)) {
                // create a new reservation.
                
                
                // reserve the selected items of the newly created reservation.
                $this->reserveSelectedItems($reservation);
            }

        } catch(Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }
    }

    /**
     * Validate selected items
     * @param  array $reservation
     * @return boolean
     */
    protected function selectedItemsValid(array $selected_items, $checkin_date, $checkout_date)
    {
        foreach($selected_items as $index => $selected_item) {
            $count =    ItemCalendar::where('item_id', $selected_item->id)
                            ->whereBetween('date', [
                                $checkin_date,
                                $checkout_date
                            ])
                            ->where('quantity', '>=', $selected_item->quantity)
                            ->count();

            if ($count > 0) {
                return false;
            }
        }

        return true;
    }

    protected function reserveSelectedItems(array $selected_items)
    {

    }

    /**
     * list of all reservations
     * @return view
     */
    public function index()
    {
        $reservations = Reservation::latest()->get();

        return view('root.reservations.index', ['reservations' => $reservations]);
    }
}