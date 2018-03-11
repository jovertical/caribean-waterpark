<?php

namespace App\Http\Controllers\Root;

use App\Notifications\{WelcomeMessage, LoginCredential};
use App\Traits\{ComputesCosts};
use App\{User, Reservation, ReservationDay, ReservationItem, Category, Item, ItemCalendar};
use Setting, Helper;
use Str, Carbon, Notify;
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
     * @param Setting $setting Injected instance of the Setting Service.
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
            if (! $this->validateSearch($search_parameters)) {
                if (count($this->reservation_errors)) {
                    session(['reservation' => []]);

                    Notify::warning($this->reservation_errors[0].'. Please try again.', 'Whooops?');
                }

                return redirect()->route('root.reservation.search');
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
                    $reservation_item = new ReservationItem;
                    $calendar_occupied = $item_calendars->sum('quantity');
                    $calendar_occupied_days = $item_calendars->count();

                    $reservation_item->item = $item;
                    $reservation_item->quantity = 0;
                    $reservation_item->price = 0.00;
                    $reservation_item->calendar_price = $item->price * $days;
                    $reservation_item->calendar_occupied = $calendar_occupied;
                    $reservation_item->calendar_unoccupied =    $calendar_occupied_days > 0 ? $item->quantity -
                                                                    ($calendar_occupied /= $calendar_occupied_days) :
                                                                        $item->quantity;
                    // check if item has passed the filters. push if true
                    if ($this->itemFiltered($reservation_item, $filters)) {
                        $available_items->push($reservation_item);
                    }
                }
            });

            // check if reservation data are the same, if not clear the items array.
            if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
                (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d')) OR
                (session()->get('reservation.adult_quantity') != $search_parameters['adult_quantity']) OR
                (session()->get('reservation.children_quantity') != $search_parameters['children_quantity']) OR
                (session()->get('reservation.filters.minimum_price') != $filters['minimum_price']) OR
                (session()->get('reservation.filters.maximum_price') != $filters['maximum_price'])) {

                session(['reservation.available_items' => $available_items->all()]);
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

            return view('root.reservation.search', [
                'available_items' => Helper::paginate(session()->get('reservation.available_items')),
                'selected_items' => session()->get('reservation.selected_items')
            ]);
        }

        session(['reservation' => []]);

        return view('root.reservation.search', [
            'available_items' => collect([]),
            'selected_items' => collect([])
        ]);
    }

    /**
     * Validate search.
     * @param  array  $search_parameters
     * @return null
     */
    protected function validateSearch(array $search_parameters)
    {
        $checkin_date = $search_parameters['checkin_date'];
        $checkout_date = $search_parameters['checkout_date'];
        $adult_quantity = $search_parameters['adult_quantity'];
        $children_quantity = $search_parameters['children_quantity'];

        $days_prior = $this->reservation_settings['days_prior'];
        $minimum_reservation_length = $this->reservation_settings['minimum_reservation_length'];
        $maximum_reservation_length = $this->reservation_settings['maximum_reservation_length'];

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
    protected function itemFiltered($item, array $filters)
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
                $item_added->quantity = $quantity;
                $item_added->price = $item_added->calendar_price * $quantity;

                // push the item to the selected_items array
                session()->push('reservation.selected_items', $item_added);

                // re-compute item costs
                $item_costs =   $this->computeItemCosts(
                                    $this->reservation_settings,
                                    session()->get('reservation.selected_items')
                                );

                session(['reservation.item_costs' => $item_costs]);

                Notify::success($item_added->item->name.' added.', 'Success!');

                return back();
            }

            $item_added->calendar_occupied += $quantity;
            $item_added->calendar_unoccupied -= $quantity;
            $selected_items[array_search($item_added->item->id, array_column($selected_items, 'id'))]->quantity += $quantity;
            $item_added->price = $item_added->calendar_price * $item_added->quantity;

            // re-compute item costs
            $item_costs =   $this->computeItemCosts(
                                $this->reservation_settings,
                                session()->get('reservation.selected_items')
                            );

            session(['reservation.item_costs' => $item_costs]);

            Notify::success($item_added->item->name.' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning($item_added->item->name.' not added or quantity not updated.', 'Whooops?');

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

        if ($quantity <= $item_removed->quantity) {
            $item_removed->calendar_occupied -= $quantity;
            $item_removed->calendar_unoccupied += $quantity;
            $item_removed->quantity -= $quantity;
            $item_removed->price = $item_removed->calendar_price * $item_removed->quantity;

            if ($item_removed->quantity == 0) {
                // pull the item from the selected_items array
                session()->pull('reservation.selected_items.'.$index);

                // re-compute item costs
                $item_costs =   $this->computeItemCosts(
                                    $this->reservation_settings,
                                    session()->get('reservation.selected_items')
                                );

                session(['reservation.item_costs' => $item_costs]);

                Notify::success($item_removed->item->name.' removed.', 'Success!');

                return back();
            }

            // re-compute item costs
            $item_costs =   $this->computeItemCosts(
                                $this->reservation_settings,
                                session()->get('reservation.selected_items')
                            );

            session(['reservation.item_costs' => $item_costs ]);

            Notify::success($item_removed->item->name.' quantity updated.', 'Success!');

            return back();
        }

        Notify::warning($item_removed->item->name.' not removed or quantity not updated.', 'Whooops?');

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
            $item_costs =   $this->computeItemCosts(
                                $this->reservation_settings,
                                session()->get('reservation.selected_items')
                            );

            session(['reservation.item_costs' => $item_costs ]);

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

        return view('root.reservation.cart', [
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
        $users = User::where('type', 'user')->where('active', 1)->get()->all();

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
                // Welcome email.
                $user->notify(new WelcomeMessage($user));

                // Login credential email.
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
            if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                Notify::warning('The available items in the calendar is not enough. Please try again.', 'Whooops!?');

                return back();
            }

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
        } catch(Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    /**
     * Update reservation
     * @param  Request     $request
     * @param  Reservation $reservation
     * @return redirect
     */
    public function update(Request $request, Reservation $reservation)
    {
        $status = strtolower($request->input('status'));

        try {
            $items = $reservation->items->all();
            $checkin_date = $reservation->checkin_date;
            $checkout_date = $reservation->checkout_date;

            if (! $this->reservationUpdateValid($reservation, $status)) {
                Notify::warning($this->reservation_errors[0].'. Please try again.', 'Whooops?');

                return back();
            }

            switch ($status) {
                case 'paid' :
                    if (! in_array(strtolower($reservation->status), ['paid'])) {
                        $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
                    }

                    $reservation->status = 'paid';
                break;

                case 'reserved' :
                    if (! in_array(strtolower($reservation->status), ['paid', 'reserved'])) {
                        $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
                    }

                    $reservation->status = 'reserved';
                break;

                case 'cancelled' :
                    if (in_array(strtolower($reservation->status), ['paid', 'reserved'])) {
                        $this->removeItemsInCalendar($items, $checkin_date, $checkout_date);
                    }

                    $reservation->status = 'cancelled';
                break;
            }

            if ($reservation->save()) {
                Notify::success('Reservation updated.', 'Success!');
            }
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    /**
     * Validate reservation's eligibility for a status update.
     * @param  Reservation $reservation
     * @param  string      $status      Requested status update
     * @return boolean
     */
    protected function reservationUpdateValid(Reservation $reservation, $status = 'reserved')
    {
        $items = $reservation->items->all();
        $checkin_date = $reservation->checkin_date;
        $checkout_date = $reservation->checkout_date;

        // check if the status request is not the same as the reservation status.
        if (strtolower($reservation->status) == $status) {
            array_push($this->reservation_errors, 'Status is already '.$status);
        }

        // check if reservation items are not valid.
        if (in_array(strtolower($reservation->status), ['pending', 'cancelled'])) {
            if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                array_push($this->reservation_errors, 'The available items in the calendar is not enough');
            }
        }

        // for paid or reserved status update requests
        if (in_array($status, ['paid', 'reserved'])) {
            // check if the reservation has at least 1 transaction in it.
            if (count($reservation->transactions) < 1) {
                array_push($this->reservation_errors, 'You must add a payment first');
            }

            // check if reservation items are not valid. (not for reservations with paid or reserved status)
            if (! in_array(strtolower($reservation->status), ['paid', 'reserved'])) {
                if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                    array_push($this->reservation_errors, 'The available items in the calendar is not enough');
                }
            }

            // check if the reservation has passed the partial payment requirements.
            if ($reservation->price_paid < $reservation->price_partial_payable) {
                array_push($this->reservation_errors, 'The required partial payment is not satisfied');
            }

            if ($status == 'paid') {
                // check if fully paid.
                if ($reservation->price_paid != $reservation->price_payable) {
                    array_push($this->reservation_errors, 'The required payment is not satisfied');
                }
            }
        }

        return count($this->reservation_errors) > 0 ? false : true;
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

    public function transactions(Reservation $reservation)
    {
        $reservation_transactions = $reservation->transactions;

        return view('root.reservation_transactions.index', [
            'reservation_transactions' => $reservation_transactions
        ]);
    }

    public function storeTransaction(Request $request, Reservation $reservation)
    {
        $this->validate($request, [
            'transaction_type' => 'required|string',
            'payment_mode' => 'required|string'
        ]);

        $type = strtolower($request->input('transaction_type'));
        $payment_mode = strtolower($request->input('payment_mode'));
        $amount = strtolower($request->input('payment_mode')) == 'full' ? $reservation->price_left_payable :
                        $reservation->price_partial_payable;
        $status = $payment_mode == 'full' ? 'paid' : 'reserved';

        $checkin_date = $reservation->checkin_date;
        $checkout_date = $reservation->checkout_date;
        $items = $reservation->items->all();

        try {
            // check if the status request is not the same as the reservation status.
            if (strtolower($reservation->status) == $status) {
                array_push($this->reservation_errors, 'Status is already '.$status);
            }

            // check if reservation items are not valid.
            if (! in_array(strtolower($reservation->status), ['paid', 'reserved'])) {
                if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                    array_push($this->reservation_errors, 'The available items in the calendar is not enough, transaction cancelled');
                }
            }

            if (count($this->reservation_errors)) {
                Notify::warning($this->reservation_errors[0].'. Please try again.', 'Whooops?');

                return back();
            }

            // create reservation transaction.
            $transaction =  $reservation->createReservationTransaction($type, 'cash', $amount);

            if ($transaction) {
                if (in_array(strtolower($reservation->status), ['pending'])) {
                    $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
                }

                $reservation->status = $status;

                // notify customer.
                if ($request->has('notify_user')) {

                }

                if ($payment_mode == 'full') {
                    $reservation->price_paid += $reservation->price_left_payable;
                } else {
                    $reservation->price_paid += $reservation->price_partial_payable;
                }
            }

            if ($reservation->save()) {
                Notify::success('Transaction completed.', 'Success!');

                return back();
            }

            Notify::warning('Something is wrong with this transaction.', 'Whooops!?');
        } catch(Exeption $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    /**
     * @param  Reservation $reservation
     * @return redirect
     */
    public function paypalRedirect(Reservation $reservation)
    {
        try {
            $response = $this->paypal_express->redirect($reservation, true);

            if ($response['paypal_link'] == null) {
                Notify::warning('Cannot process your payment.', 'Whooops!?');

                return redirect()->route('root.reservations.show', $reservation);
            }

            return redirect($response['paypal_link']);
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        };

        return redirect()->route('root.reservations.show', $reservation);
    }

    /**
     * @param  Request     $request
     * @param  Reservation $reservation
     * @return redirect
     */
    public function paypalCallback(Request $request, Reservation $reservation)
    {
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $status = $this->paypal_express->callback($reservation, $token, $payer_id);

        if (! strcasecmp($status, 'Completed') || ! strcasecmp($status, 'Processed')) {
            Notify::success('Payment processed.', 'Success!');
        }

        return redirect()->route('root.reservations.show', $reservation);
    }

    /**
     * Check if reservation_items are valid in the calendar.
     * @param  array  $reservation_items
     * @param  string $checkin_date
     * @param  string $checkout_date
     * @return boolean
     */
    protected function reservationItemsValid(array $reservation_items, $checkin_date, $checkout_date)
    {
        /**
         * Reset indexes of the array
         * @var array
         */
        $items = array_values($reservation_items);

        for($i = 0; $i < count($items); $i++) {
            $count =    ItemCalendar::where('item_id', $items[$i]->item->id)
                            ->whereBetween('date', [$checkin_date, $checkout_date])
                            ->where('quantity', '<=', $items[$i]->quantity)
                            ->count();

            if ($count != 0) {
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
        for($i = 0; $i < count($items); $i++) {
            $date = $checkin_date;

            while ($date <= $checkout_date) {
                $item_calendar = ItemCalendar::where('date', $date)->where('item_id', $items[$i]->id)->first();

                ItemCalendar::UpdateOrCreate([
                    'item_id' => $items[$i]->item->id,
                    'date' =>  $date
                ], [
                    'item_id' => $items[$i]->item->id,
                    'date' =>  $date
                ])->save();

                $item_calendar = ItemCalendar::where('date', $date)->where('item_id', $items[$i]->item->id)->first();
                $item_calendar->quantity += $items[$i]->quantity;
                $item_calendar->save();

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
                $item_calendar = ItemCalendar::where('date', $date)->where('item_id', $item->item->id)->first();

                // Update item calendar.
                $item_calendar->quantity -= $item->quantity;
                $item_calendar->save();

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }
        }
    }
}