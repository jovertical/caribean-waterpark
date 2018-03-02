<?php

namespace App\Http\Controllers\Root;

use App\Notifications\LoginCredential;
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
                $item_calendars =    ItemCalendar::where('item_id', $item->id)
                                        ->whereBetween('date', [
                                            $checkin_date->format('Y-m-d'),
                                            $checkout_date->format('Y-m-d')
                                        ])
                                        ->get();

                $count = $item_calendars->filter(function($item_calendar) use ($item) {
                    return $item_calendar->quantity >= $item->quantity;
                })->count();

                if ($count == 0) {
                    $item->calendar_occupied = 0;
                    $item->calendar_unoccupied = $item->quantity - $item_calendars->sum('quantity');
                    $item->calendar_price = $item->price * ($checkin_date->diffInDays($checkout_date) + 1);
                    $item->order_quantity = 0;
                    $item->order_price = 0.00;

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
        $users = User::where('type', 'user')->get()->all();

        return view('root.reservation.user', [
            'users' => $users
        ]);
    }

    /**
     * Store the user for the next reservation.
     * @param  Request $request
     * @return null
     */
    public function storeUser(Request $request)
    {
        $this->validate($request, [
            'email'         => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|string|max:255',
            'birthdate'     => 'max:255',
            'address'       => 'max:510',
            'phone_number'  => 'max:255'
        ]);

        try {
            $user = new User;
            $login_credential = Helper::createLoginCredential($request->input('email'));

            $user->verified        = true;
            $user->type            = 'user';
            $user->name            = $login_credential;
            $user->email           = $request->input('email');
            $user->password        = bcrypt($login_credential);
            $user->first_name      = $request->input('first_name');
            $user->middle_name     = $request->input('middle_name');
            $user->last_name       = $request->input('last_name');
            $user->birthdate       = $request->input('birthdate');
            $user->gender          = $request->input('gender');
            $user->address         = $request->input('address');
            $user->phone_number    = $request->input('phone_number');

            if ($user->save()) {
                $user->notify(new LoginCredential($login_credential, $login_credential));

                // Proceed to reservation.
                return $this->store($user);
            }

            Notify::warning('Cannot create a user', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    /**
     * Store the reservation.
     * @param  User    $user
     * @return
     */
    public function store(User $user)
    {
        $items = session()->get('reservation.selected_items');
        $checkin_date = session()->get('reservation.checkin_date');
        $checkout_date = session()->get('reservation.checkout_date');
        $item_costs = session()->get('reservation.item_costs');

        try {
            if ($this->selectedItemsValid($items, $checkin_date, $checkout_date)) {
                // create a new reservation.
                $reservation = $user->createReservation($checkin_date, $checkout_date, $item_costs);

                // store the items.
                $this->storeReservationItems($reservation, $items, $item_costs);

                // store the items in the calendar.
                $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);

                return redirect()->route('root.reservations.index');
            }
        } catch(Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }
    }

    /**
     * Check if items is valid in the calendar.
     * @param  array  $items
     * @param  string $checkin_date
     * @param  string $checkout_date
     * @return boolean
     */
    protected function selectedItemsValid(array $items, $checkin_date, $checkout_date)
    {
        foreach($items as $index => $item) {
            $count =    ItemCalendar::where('item_id', $item->id)
                            ->whereBetween('date', [
                                $checkin_date,
                                $checkout_date
                            ])
                            ->where('quantity', '>=', $item->order_quantity)
                            ->count();

            if ($count == 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Store the selected items for the reservation.
     * @param  Reservation $reservation
     * @param  array       $items
     * @param  array       $item_costs
     * @return null
     */
    protected function storeReservationItems(Reservation $reservation, array $items, array $item_costs)
    {
        foreach($items as $item) {
            $reservation->createReservationItem($item, $item_costs);
        }
    }

    /**
     * Store the selected items in the calendar.
     * @param  array  $items
     * @param  string $checkin_date
     * @param  string $checkout_date
     * @return null
     */
    protected function storeItemsInCalendar(array $items, $checkin_date, $checkout_date)
    {
        foreach($items as $item) {
            $date = $checkin_date;

            while ($date <= $checkout_date) {
                $item_calendar = ItemCalendar::where('date', $date)->where('item_id', $item->id)->first();

                if ($item_calendar == null) {
                    // store item calendar.
                    $item_calendar = new ItemCalendar;
                    $item_calendar->item_id = $item->id;
                    $item_calendar->date = $date;
                    $item_calendar->quantity = $item->order_quantity;
                    $item_calendar->save();
                } else {
                    // Update item calendar.
                    $item_calendar->quantity += $item->order_quantity;
                    $item_calendar->save();
                }

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }
        }
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