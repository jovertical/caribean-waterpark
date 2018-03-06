<?php

namespace App\Http\Controllers\Root;

use App\Notifications\LoginCredential;
use App\Traits\{ComputesCosts};
use App\{User, Reservation, ReservationDay, Category, Item, ItemCalendar};
use Setting, Helper;
use Str, Carbon, Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    use ComputesCosts;

    /**
     * Array of reservation settings.
     * @var array
     */
    protected $reservation_settings;

    /**
     * Reservation error messages.
     * @var array
     */
    protected $reservation_errors = [];

    /**
     * @param Settings $settings Injected instance of the settings service.
     */
    public function __construct(Setting $setting)
    {
        $this->reservation_settings = $setting->reservation();
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

    /**
     * Search calendar for available items, compute costs as well.
     * @param  Request $request
     * @return view
     */
    public function searchItems(Request $request)
    {
        $search_parameters = [
            'checkin_date' => $request->input('ci'),
            'checkout_date' => $request->input('co'),
            'adult_quantity' => $request->input('aq'),
            'children_quantity' => $request->input('cq')
        ];

        $filters = [
            'minimum_price' => $request->input('mnp'),
            'maximum_price' => $request->input('mxp')
        ];

        $items = collect([]);

        if (($search_parameters['checkin_date'] != null) AND ($search_parameters['checkout_date'] != null)) {
            // Validate search.
            if (! $this->validateSearch($search_parameters, $this->reservation_settings)) {
                // set reservation data to empty array
                session(['reservation' => []]);

                if (count($this->reservation_errors)) {
                    Notify::warning($this->reservation_errors[0].'. Please try again.', 'Whooops?');
                } else {
                    Notify::warning('There are errors in your search, Please try again.', 'Whooops?');
                }

                return redirect()->route('root.reservation.search-items');
            }
        }

        $checkin_date = Carbon::parse($search_parameters['checkin_date']);
        $checkout_date = Carbon::parse($search_parameters['checkout_date']);
        $days = $checkin_date->diffInDays($checkout_date) + 1;

        $items =    Item::with('category')->whereHas('category', function($category) {
                        $category->where('active', true);
                    })
                    ->where('active', true)
                    ->orderBy('price');

        $available_items = collect([]);

        $items->each(function($item) use ($available_items, $checkin_date, $checkout_date, $days, $filters) {
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
                $calendar_occupied = $item_calendars->sum('quantity');
                $calendar_occupied_days = $item_calendars->count();

                $item->calendar_occupied = $calendar_occupied;
                $item->calendar_unoccupied =    $calendar_occupied_days > 0 ? $item->quantity - $calendar_occupied /=
                                                    $calendar_occupied_days : $item->quantity;

                $item->calendar_price = $item->price * $days;
                $item->order_quantity = 0;
                $item->order_price = 0.00;

                // check if item has passed the filters. push if true
                if ($this->itemFiltered($item, $filters)) {
                    $available_items->push($item);
                }
            }
        });

        $items = $available_items;

        // check if reservation data are the same, if not clear the items array.
        if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
            (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d')) OR
            (session()->get('reservation.adult_quantity') != $search_parameters['adult_quantity']) OR
            (session()->get('reservation.children_quantity') != $search_parameters['children_quantity']) OR
            (session()->get('reservation.filters.minimum_price') != $filters['minimum_price']) OR
            (session()->get('reservation.filters.maximum_price') != $filters['maximum_price'])) {

            session(['reservation.available_items' => $items->all()]);
            session(['reservation.selected_items' => []]);
        }

        // set reservation data
        session(['reservation.checkin_date' => $checkin_date->format('Y-m-d')]);
        session(['reservation.checkout_date' => $checkout_date->format('Y-m-d')]);
        session(['reservation.days' => $days]);
        session(['reservation.adult_quantity' => $search_parameters['adult_quantity']]);
        session(['reservation.children_quantity' => $search_parameters['children_quantity']]);
        session(['reservation.filters.minimum_price' => $filters['minimum_price']]);
        session(['reservation.filters.maximum_price' => $filters['maximum_price']]);

        return view('root.reservation.search_items', [
            'available_items' => Helper::paginate(session()->get('reservation.available_items')),
            'selected_items' => session()->get('reservation.selected_items')
        ]);
    }

    /**
     * Validate search.
     * @param  array  $search_parameters
     * @return null
     */
    protected function validateSearch(array $search_parameters, array $reservation_settings)
    {
        $checkin_date = $search_parameters['checkin_date'];
        $checkout_date = $search_parameters['checkout_date'];
        $adult_quantity = $search_parameters['adult_quantity'];
        $children_quantity = $search_parameters['children_quantity'];

        $days_prior = $reservation_settings['days_prior'];
        $minimum_reservation_length = $reservation_settings['minimum_reservation_length'];
        $maximum_reservation_length = $reservation_settings['maximum_reservation_length'];
           
        if (($checkin_date == null) OR ($checkout_date == null)) {
            array_push($this->reservation_errors, 'You must set a checkin and checkout date');
        }

        if (($adult_quantity == null) OR (! is_numeric($adult_quantity))) {
            array_push($this->reservation_errors, 'Adult quantity is not valid');
        }

        if ($children_quantity != null) {
            if (! is_numeric($children_quantity)) {
                array_push($this->reservation_errors, 'Children quantity is not valid');
            }
        }

        $checkin_date = Carbon::parse($checkin_date);
        $checkout_date = Carbon::parse($checkout_date);
        $days = $checkin_date->diffInDays($checkout_date) + 1;
        $earliest = Carbon::parse(now()->addDays($days_prior)->format('Y-m-d'));

        if ($checkin_date > $checkout_date) {
            array_push($this->reservation_errors, 'Invalid date');
        }

        if ($checkin_date < $earliest) {
            array_push($this->reservation_errors, 'Check-in date must be '.$days_prior.' day(s) prior today');
        }

        if ($days > $maximum_reservation_length) {
            array_push($this->reservation_errors, 
                'Reservation length must not be greater than '.$maximum_reservation_length.' day(s)');
        }

        if ($days < $minimum_reservation_length) {
            array_push($this->reservation_errors, 
                'Reservation length must not be lesser than '.$minimum_reservation_length.' day(s)');
        }

        return count($this->reservation_errors) > 0 ? false : true;
    }

    /**
     * Check if item has passed the filters.
     * @param  Item   $item    Instance of Item.
     * @param  array  $filters
     * @return boolean
     */
    protected function itemFiltered(Item $item, array $filters)
    {
        if (($item->calendar_price >= $filters['minimum_price']) AND
            ($item->calendar_price <= $filters['maximum_price'])) {
            return true;
        }

        return false;
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
                $item_added->index = $index;
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
        $adult_quantity = session()->get('reservation.adult_quantity');
        $children_quantity = session()->get('reservation.children_quantity');
        $guests = ['adult' => $adult_quantity, 'children' => $children_quantity];
        $rates = ['adult' => 200, 'children' => 120];
        $item_costs = session()->get('reservation.item_costs');
        $reference_number = Carbon::now()->format('Y').'-'.Helper::createPaddedCounter(Reservation::count()+1);

        try {
            if ($this->selectedItemsValid($items, $checkin_date, $checkout_date)) {
                // create a new reservation.
                $reservation =  $user->createReservation($reference_number, $checkin_date, $checkout_date, $item_costs);

                // store reservation items.
                $this->storeReservationItems($reservation, $items, $item_costs);

                // store reservation days.
                $this->storeReservationDays($reservation, $guests, $rates);

                // clear reservation data from the session.
                session()->pull('reservation');

                Notify::success('Reservation created.', 'Success!');

                return redirect()->route('root.reservations.show', $reservation);
            }
        } catch(Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }
    }

    /**
     * Update reservation
     * @param  Request     $request
     * @param  Reservation $reservation
     * @return redirect
     */
    public function update(Request $request, Reservation $reservation)
    {
        $status = $request->input('status');

        try {
            if (strtolower($reservation->status) == strtolower($status)) {
                Notify::warning('Status is already '.$status, 'Ooops?!');

                return back();
            }

            $items = $reservation->items->all();
            $checkin_date = $reservation->checkin_date;
            $checkout_date = $reservation->checkout_date;

            // check if selected items are valid.
            if ($this->selectedItemsValid($items, $checkin_date, $checkout_date)) {
                switch ($status) {
                    case 'reserved' :
                        // update reservation status.
                        $reservation->status = 'reserved';

                        if ($reservation->save()) {
                            // store the items in the calendar.
                            $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
                        }
                    break;

                    case 'paid' :
                        // update reservation status.
                        $reservation->status = 'paid';

                        if ($reservation->save()) {
                            if (strtolower($reservation->status) != 'reserved') {
                                // store the items in the calendar.
                                $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
                            }
                        }
                    break;

                    case 'cancelled' :
                        if ((strtolower($reservation->status) == 'reserved') OR (strtolower($reservation->status) == 'paid')) {
                            // update item calendar and subtract the quantity of each items.
                            $this->removeItemsInCalendar($items, $checkin_date, $checkout_date);
                        }

                        // update reservation status.
                        $reservation->status = 'cancelled';
                        $reservation->save();
                    break;
                }

                Notify::success('Reservation updated.', 'Success!');

                return back();
            }

            Notify::warning('Cannot updated reservation.', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    /**
     * Show reservation.
     * @param  Reservation $reservation
     * @return view
     */
    public function show(Reservation $reservation)
    {
        // assign reservation day for the active date
        $reservation->day = $reservation->days->where('date', Carbon::now()->format('Y-m-d'))->first();

        return view('root.reservations.show', [
            'reservation' => $reservation
        ]);
    }

    /**
     * Reservation days.
     * @param  Reservation $reservation
     * @return view
     */
    public function days(Reservation $reservation)
    {
        $days = $reservation->days;

        return view('root.reservation_days.index', [
            'days' => $days
        ]);
    }

    /**
     * Update reservation day.
     * @param  Request        $request
     * @param  ReservationDay $reservation_day
     * @return redirect
     */
    public function updateDay(Request $request, ReservationDay $reservation_day)
    {
        $status = $request->input('status');

        try {
            if ($status == 'enter') {
                if ((! $reservation_day->reservation->has_entered) AND (! $reservation_day->reservation->has_exited)) {
                    $reservation_day->entered = true;
                    $reservation_day->entered_at = date('Y-m-d H:i:s');
                    $reservation_day->adult_quantity = $request->input('adult_quantity');
                    $reservation_day->children_quantity = $request->input('children_quantity');

                    if ($reservation_day->save()) {
                        Notify::success('Reservation day updated.', 'Success');

                        return back();
                    }
                }
            }

            if ($status == 'exit') {
                if ((! $reservation_day->reservation->has_exited) AND ($reservation_day->reservation->has_entered)) {
                    $reservation_day->exited = true;
                    $reservation_day->exited_at = date('Y-m-d H:i:s');

                    if ($reservation_day->save()) {
                        Notify::success('Reservation day updated.', 'Success');

                        return back();
                    }
                }
            }

            Notify::warning('Cannot updated reservation day.', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
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
                            ->where('quantity', '>=', $item->order_quantity ?? $item->quantity)
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
     * Store reservation days.
     * @param  Reservation $reservation
     * @param  array       $guests
     * @return null
     */
    protected function storeReservationDays(Reservation $reservation, array $guests, array $rates)
    {
        $date = $reservation->checkin_date;

        while ($date <= $reservation->checkout_date) {
            $reservation->createReservationDay($date, $guests, $rates);

            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
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
                    $item_calendar->quantity = $item->order_quantity ?? $item->quantity;
                    $item_calendar->save();
                } else {
                    // Update item calendar.
                    $item_calendar->quantity += $item->order_quantity ?? $item->quantity;
                    $item_calendar->save();
                }

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }
        }
    }

    /**
     * Remove the items from the calendar.
     * @param  array  $items
     * @param  string $checkin_date
     * @param  string $checkout_date
     * @return null
     */
    protected function removeItemsInCalendar(array $items, $checkin_date, $checkout_date)
    {
        foreach($items as $item) {
            $date = $checkin_date;

            while ($date <= $checkout_date) {
                $item_calendar = ItemCalendar::where('date', $date)->where('item_id', $item->id)->first();

                // Update item calendar.
                $item_calendar->quantity -= $item->quantity;
                $item_calendar->save();

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }
        }
    }
}