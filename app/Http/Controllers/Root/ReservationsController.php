<?php

namespace App\Http\Controllers\Root;

use App\Notifications\{ResourceCreated, ResourceUpdated, WelcomeMessage, LoginCredential};
use App\Traits\{ItemCalendarProcesses, ReservationProcesses};
use App\{User, Reservation, ReservationDay, ReservationItem, Category, Item, ItemCalendar};
use Setting, Helper;
use Carbon, Notify, Excel, PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    /**
     * Item calendar functionalities
     */
    use ItemCalendarProcesses;

    /**
     * Reservation process functionalities
     */
    use ReservationProcesses;

    /**
     * Array of calendar settings.
     * @var array
     */
    protected $calendar_settings;

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
     * @var User
     */
    protected $superusers;

    public function __construct()
    {
        $this->calendar_settings = app('Setting')->calendar();
        $this->reservation_settings = app('Setting')->reservation();
        $this->superusers = User::where('type', 'superuser')->get();
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
    public function search(Request $request)
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

        if (($search_parameters['checkin_date'] != null) OR ($search_parameters['checkout_date'] != null)) {
            if (count($validate_search = $this->validateSearch($search_parameters, $this->reservation_settings))) {
                session(['reservation' => []]);

                Notify::warning($validate_search[0].'. Please try again.', 'Whooops?');

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
                    $calendar_occupied = $item_calendars->max('quantity');
                    $calendar_occupied_days = $item_calendars->count();
                    $calendar_unoccupied = $item->quantity - $calendar_occupied;

                    $reservation_item->item = $item;
                    $reservation_item->quantity = 0;
                    $reservation_item->price = 0.00;
                    $reservation_item->calendar_price = $item->price * $days;
                    $reservation_item->calendar_occupied = $calendar_occupied;
                    $reservation_item->calendar_unoccupied = $calendar_unoccupied;

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
                'available_items' => Helper::paginate(session()->get('reservation.available_items'), 5),
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
     * Add specific item to the cart.
     * @param  Request $request
     * @param  int  $index
     * @return back
     */
    public function addItem(Request $request, $index)
    {
        $quantity = $request->input('quantity');

        $available_items = session()->get('reservation.available_items');
        $selected_items = session()->get('reservation.selected_items');

        $item_added = $available_items[$index];

        if ($quantity <= $item_added->calendar_unoccupied) {
            if(! in_array($item_added->item->id, array_column(array_column($selected_items, 'item'), 'id'))) {
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
            $selected_items[array_search(
                $item_added->item->id, array_column(array_column($selected_items, 'item'), 'id')
            )]->quantity += $quantity;
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
        $quantity = $request->input('quantity') ?? 1;

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

                // reset indexes of selected_items array
                session(['reservation.selected_items' => array_values(session()->get('reservation.selected_items'))]);

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
     * Show selected items
     * @return view
     */
    public function cart()
    {
        $items = session()->get('reservation.selected_items') ?? [];
        $item_costs = session()->get('reservation.item_costs');

        return view('root.reservation.cart', [
            'items' => $items,
            'item_costs' => $item_costs
        ]);
    }

    /**
     * Clear all cart items
     * @return back
     */
    public function destroyCart()
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
     *
     * @return view
     */
    public function user()
    {
        $users = User::where('type', 'user')->where('active', 1)->get()->all();

        if (session()->has('reservation')) {
            return view('root.reservation.user', [
                'users' => $users
            ]);
        }

        return redirect()->route('root.reservation.cart.index');
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
            $name = Helper::createUsername($request->input('email'));
            $password = Helper::createPassword();

            $user = new User;
            $user->verified        = true;
            $user->type            = 'user';
            $user->name            = $name;
            $user->email           = $request->input('email');
            $user->password        = bcrypt($password);
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
                $user->notify(new LoginCredential($name, $password));

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
        $calendar_day = $this->calendar_settings['calendar_days'][Carbon::now()->dayOfWeek];
        $guests = ['adult' => $adult_quantity, 'children' => $children_quantity];
        $rates = ['adult' => $calendar_day['adult_rate'], 'children' => $calendar_day['children_rate']];
        $item_costs = session()->get('reservation.item_costs');
        $name = Carbon::now()->format('Y').'-'.Helper::createPaddedCounter(mt_rand(100000, 999999));

        try {
            if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                Notify::warning('The available items in the calendar is not enough. Please try again.', 'Whooops!?');

                // clear reservation data from the session.
                session()->pull('reservation');

                return back();
            }

            // create a new reservation.
            $reservation =  $user->createReservation($name, $checkin_date, $checkout_date, $item_costs);

            // store reservation items.
            $this->storeReservationItems($reservation, $items, $item_costs);

            // store reservation days.
            $this->storeReservationDays($reservation, $guests, $rates);

            // clear reservation data from the session.
            session()->pull('reservation');

            // notify superusers
            $this->superusers->each(function($notifiable) use ($reservation) {
                $notifiable->notify(
                    new ResourceCreated(
                        auth()->user(),
                        $reservation,
                        route('root.reservations.show', $reservation),
                        [
                            'text' => 'Pending',
                            'class' => 'warning'
                        ]
                    )
                );
            });

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

                    if (strtolower($reservation->status) != 'pending') {
                        // send message if not refundable.
                        if (! $reservation->refundable) {
                            session()->flash('message',  [
                                'type' => 'danger',
                                'content' => '
                                    This reservation is not refundable because it is
                                    <span class="m--font-boldest">'.
                                    $reservation->days_refundable.' days late</span>
                                    of the set refundable day(s) prior the check-in date.
                                '
                            ]);
                        } else {
                            session()->flash('message',  [
                                'type' => 'success',
                                'content' => '
                                    This reservation is refundable. The system calculated an amount of '.
                                    Helper::moneyString($reservation->price_refundable).' refundable.
                                '
                            ]);
                        }
                    }

                    $reservation->status = 'cancelled';
                break;
            }

            if ($reservation->save()) {
                // notify superusers
                $this->superusers->each(function($notifiable) use ($reservation) {
                    $notifiable->notify(
                        new ResourceUpdated(
                            auth()->user(),
                            $reservation,
                            route('root.reservations.show', $reservation),
                            [
                                'text' => $reservation->status,
                                'class' => $reservation->status_class
                            ]
                        )
                    );
                });

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
        if (! in_array(strtolower($status), ['cancelled', 'void'])) {
            if (in_array(strtolower($reservation->status), ['pending'])) {
                if (! $this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                    array_push($this->reservation_errors, 'The available items in the calendar is not enough');
                }
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
        return view('root.reservation_transactions.index', compact('reservation'));
    }

    public function storeTransaction(Request $request, Reservation $reservation)
    {
        $this->validate($request, [
            'transaction_type' => 'required|string'
        ]);

        $type = strtolower($request->input('transaction_type'));
        $payment_mode = strtolower($request->input('payment_mode'));

        try {
            switch ($type) {
                case 'payment':
                    $amount = strtolower($request->input('payment_mode')) == 'full' ?
                                $reservation->price_left_payable : $reservation->price_partial_payable;
                    $status = $payment_mode == 'full' ? 'paid' : 'reserved';

                    $checkin_date = $reservation->checkin_date;
                    $checkout_date = $reservation->checkout_date;
                    $items = $reservation->items->all();

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

                        $reservation->price_paid += $amount;

                        if ($this->reservation_settings['allow_refund']) {
                            // save the days_refundable from settings;
                            $reservation->days_refundable = $this->reservation_settings['days_refundable'];
                            // save price_refundable.
                            $refundable =   $reservation->price_paid * (max(
                                                $this->reservation_settings['refundable_rate'], 1
                                            ) / 100);
                            $reservation->price_refundable = $refundable;
                        } else {
                            session()->flash('message',  [
                                'type' => 'danger',
                                'content' => '
                                    This reservation is not refundable because
                                    <span class="m--font-bolder">refund</span>
                                    is not enabled in the <a href="'.route('root.settings.index').
                                    '" class="m-link m--font-boldest">Settings</a></span>
                                '
                            ]);
                        }
                    }
                break;

                case 'refund':
                    $amount = $reservation->price_refundable;

                    // create reservation transaction.
                    $transaction = $reservation->createReservationTransaction($type, 'cash', $amount);

                    if ($transaction) {
                        // notify customer.
                        if ($request->has('notify_user')) {

                        }

                        $reservation->price_paid -= $amount;
                    }
                break;
            }

            if ($reservation->save()) {
                // notify superusers
                $this->superusers->each(function($notifiable) use ($reservation) {
                    $notifiable->notify(
                        new ResourceUpdated(
                            auth()->user(),
                            $reservation,
                            route('root.reservations.show', $reservation),
                            [
                                'text' => $reservation->status,
                                'class' => $reservation->status_class
                            ]
                        )
                    );
                });

                Notify::success('Transaction completed.', 'Success!');

                return back();
            }

            Notify::warning('Something is wrong with this transaction.', 'Whooops!?');
        } catch(Exeption $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    public function exportTransactions(Request $request, Reservation $reservation)
    {
        $file_type = strtolower($request->input('file_type'));
        $file_name = $request->input('file_name');

        try {
            $transactions = $reservation->transactions->all();

            switch ($file_type) {
                case 'pdf':
                        return  $this->exportTransactionsAsPDF(
                                    $transactions, $file_name
                                );
                    break;

                case 'excel':
                        return  $this->exportTransactionsAsSpreadsheet(
                                    $transactions, $file_name
                                );
                    break;

                case 'csv':
                        return  $this->exportTransactionsAsSpreadsheet(
                                    $transactions, $file_name, 'csv'
                                );
                    break;
            }

            Notify::warning('We cannot export this data.', 'Whoops?!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }

    protected function exportTransactionsAsPDF(array $data, $file_name = 'transactions')
    {
        $pdf = PDF::loadView('root.reservation_transactions.pdf', compact('data'))
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-seriff']);

        return $pdf->download($file_name.'.pdf');
    }

    protected function exportTransactionsAsSpreadsheet(
        array $data,
        $file_name = 'transactions',
        $file_type = 'xls'
    ) {
        $export = Excel::create($file_name, function($excel) use ($data) {
            $excel->sheet('Sheetname', function($sheet) use ($data)  {
                $sheet->setOrientation('landscape');

                $sheet->row(1, ['#', 'Type', 'Mode', 'Amount']);

                foreach($data as $index => $metadata) {
                    $sheet->row($index + 2, [
                        $index + 1,
                        $metadata->type,
                        $metadata->mode,
                        Helper::decimalFormat($metadata->amount)
                    ]);
                }
            });
        })->export($file_type);

        return $export;
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

    public function export(Request $request, Reservation $reservation)
    {
        $pdf = PDF::loadView('root.reservations.pdf', compact('reservation'))
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-seriff']);

        return $pdf->download($request->input('file_name').'.pdf');
    }
}