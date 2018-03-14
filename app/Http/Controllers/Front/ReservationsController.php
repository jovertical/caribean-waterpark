<?php

namespace App\Http\Controllers\Front;

use App\Notifications\{WelcomeMessage, LoginCredential};
use App\Traits\{ItemCalendarProcesses, ReservationProcesses};
use App\{User, Reservation, ReservationDay, ReservationItem, Category, Item, ItemCalendar};
use Setting, Helper, PaypalExpress;
use Carbon;
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
     * Paypal express instance.
     * @var PaypalExpress
     */
    protected $paypal_express;

    /**
     * @param Setting $setting Injected instance of the Setting Service.
     * @param PaypalExpress $paypal_express Injected instance of the PaypalExpress Service.
     */
    public function __construct(Setting $setting, PaypalExpress $paypal_express)
    {
        $this->reservation_settings = $setting->reservation();
        $this->paypal_express = $paypal_express;
    }

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

        if (($search_parameters['checkin_date'] != null) AND ($search_parameters['checkout_date'] != null)) {
            if (count($validate_search = $this->validateSearch($search_parameters, $this->reservation_settings))) {
                session(['reservation' => []]);

                session()->flash('message', [
                    'type' => 'warning',
                    'content' => $validate_search[0].'. Please try again.'
                ]);

                return redirect()->route('front.reservation.search');
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

                    $available_items->push($reservation_item);
                }
            });

            // check if reservation data are the same, if not clear the items array.
            if ((session()->get('reservation.checkin_date') != $checkin_date->format('Y-m-d')) OR
                (session()->get('reservation.checkout_date') != $checkout_date->format('Y-m-d')) OR
                (session()->get('reservation.adult_quantity') != $search_parameters['adult_quantity']) OR
                (session()->get('reservation.children_quantity') != $search_parameters['children_quantity']) OR
                (session()->get('reservation.filters.minimum_price') != $filters['minimum_price']) OR
                (session()->get('reservation.filters.maximum_price') != $filters['maximum_price'])) {

                if (session()->has('reservation.selected_items')) {
                    if (count(session()->get('reservation.selected_items'))) {
                        session()->flash('message', [
                            'type' => 'info',
                            'content' => 'Cart cleared.'
                        ]);
                    }
                }

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

            // add item if available
            if ($request->has('item')) {
                $items = array_column($available_items->all(), 'item');
                $index = array_search($request->input('item'), array_column($items, 'slug'));
                $redirect_to = Helper::searchRequestUrl(request(['ci', 'co', 'aq', 'cq']));

                return $this->addItem($request, $index, $redirect_to);
            }

            return view('front.reservation.search', [
                'available_items' => Helper::paginate(session()->get('reservation.available_items'), 5),
                'selected_items' => session()->get('reservation.selected_items')
            ]);
        }

        return view('front.reservation.search', [
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
    public function addItem(Request $request, $index, $redirect_to = null)
    {
        $quantity = $request->input('quantity') ?? 1;

        $available_items = session()->get('reservation.available_items');
        $selected_items = session()->get('reservation.selected_items');

        $item_added = $available_items[$index];

        try {
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

                    session()->flash('message', [
                        'type' => 'success',
                        'content' => $item_added->item->name.' was added to your '.'<a href="'.
                                        route('front.reservation.cart.index').'">cart.</a>'
                    ]);

                    return $redirect_to != null ? redirect($redirect_to) : back();
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

                session()->flash('message', [
                    'type' => 'success',
                    'content' => "{$item_added->item->name} quantity has been updated."
                ]);

                return $redirect_to != null ? redirect($redirect_to) : back();
            }

            session()->flash('message', [
                'type' => 'success',
                'content' => "{$item_added->item->name} was not added to your cart."
            ]);

            return $redirect_to != null ? redirect($redirect_to) : back();
        } catch (Exception $e) {
            session()->pull('reservation');

            session()->flash('message', [
                'type' => 'danger',
                'content' => $e->getMessage()
            ]);
        }

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

        try {
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

                    session()->flash('message', [
                        'type' => 'success',
                        'content' => "{$item_removed->item->name} removed from your ".'<a href="'.
                                        route('front.reservation.cart.index').'">cart.</a>'
                    ]);

                    return back();
                }

                // re-compute item costs
                $item_costs =   $this->computeItemCosts(
                                    $this->reservation_settings,
                                    session()->get('reservation.selected_items')
                                );

                session(['reservation.item_costs' => $item_costs ]);

                session()->flash('message', [
                    'type' => 'success',
                    'content' => "{$item_removed->item->name} quantity updated."
                ]);

                return back();
            }

            session()->flash('message', [
                'type' => 'success',
                'content' => "{$item_removed->item->name} not removed."
            ]);
        } catch (Exception $e) {
            session()->pull('reservation');

            session()->flash('message', [
                'type' => 'danger',
                'content' => $e->getMessage()
            ]);
        }

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

        return view('front.reservation.cart', [
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

            session()->flash('message', [
                'type' => 'success',
                'content' => 'Cart cleared.'
            ]);
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage()
            ]);
        }

        return back();
    }

    /**
     * @return view
     */
    public function user()
    {
        if (session()->has('reservation')) {
            if (count($reservation = session()->get('reservation'))) {
                if (isset($reservation['selected_items'])) {
                    if (count($reservation['selected_items']) < 1) {
                        return redirect()->route('front.reservation.cart.index');
                    }
                }

                return view('front.reservation.user');
            }
        }

        return redirect()->route('front.welcome');
    }

    /**
     * Store the reservation.
     * @param  User    $user
     * @return
     */
    public function store(Request $request)
    {
        $user = auth()->user();
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
                session()->flash('message', [
                    'type' => 'warning',
                    'content' => 'The available items in the calendar is not enough. Please try again.'
                ]);

                return back();
            }

            // create a new reservation.
            $reservation =  $user->createReservation($reference_number, $checkin_date, $checkout_date, $item_costs);

            // store reservation items.
            $this->storeReservationItems($reservation, $items, $item_costs);

            // store reservation days.
            $this->storeReservationDays($reservation, $guests, $rates);

            // If payment mode is paypal_express, redirect.
            if (strtolower($request->input('payment_mode')) == 'paypal_express') {
                return $this->paypalRedirect($reservation);
            }

            // clear reservation data from the session.
            session()->pull('reservation');

            return redirect()->route('front.reservation.review', $reservation);
        } catch(Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage()
            ]);
        }

        return back();
    }

    public function storeTransaction(Reservation $reservation)
    {
        $type = 'payment';
        $payment_mode = 'paypal_express';
        $amount = $reservation->price_left_payable;

        // create reservation transaction.
        $transaction =  $reservation->createReservationTransaction($type, $payment_mode, $amount);

        $checkin_date = $reservation->checkin_date;
        $checkout_date = $reservation->checkout_date;
        $items = $reservation->items->all();

        if ($transaction) {
            $this->storeItemsInCalendar($items, $checkin_date, $checkout_date);
        }

        return [
            'amount' => $amount
        ];
    }

    /**
     * @return view
     */
    public function review(Reservation $reservation)
    {
        return view('front.reservation.review', compact('reservation'));
    }

    /**
     * Display listing of the resource
     * @return view
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)
                            ->latest()
                            ->paginate(5);

        return view('front.reservations.index', compact('reservations'));
    }

    /**
     * Show reservation
     * @param  Reservation $reservation
     * @return view
     */
    public function show(Reservation $reservation)
    {
        return view('front.reservations.show', compact('reservation'));
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
                if ($reservation->delete()) {
                    // clear reservation from session.
                    session()->pull('reservation');

                    session()->flash('message', [
                        'type' => 'warning',
                        'content' =>    'We cannot process your payment. Transaction has been cancelled.'
                    ]);
                }

                return redirect()->route('front.reservation.cart');
            }

            return redirect($response['paypal_link']);
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage()
            ]);
        };

        return redirect()->route('front.reservation.welcome');
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

        $items = $reservation->items->all();
        $checkin_date = $reservation->checkin_date;
        $checkout_date = $reservation->checkout_date;

        try {
            if ($this->reservationItemsValid($items, $checkin_date, $checkout_date)) {
                $status = $this->paypal_express->callback($reservation, $token, $payer_id);

                if (in_array(strtolower($status), ['completed', 'processed', 'pending'])) {
                    // store transaction.
                    $transaction = $this->storeTransaction($reservation);

                    $reservation->price_paid = $transaction['amount'];
                    $reservation->status = 'paid';

                    if ($reservation->save()) {
                        // clear reservation from session.
                        session()->pull('reservation');

                        session()->flash('message', [
                            'type' => 'success',
                            'content' => 'Your reservation has been completed. We cannot wait to see you!'
                        ]);
                    }

                    return redirect()->route('front.reservation.review', $reservation);
                }
            }

            if ($reservation->delete()) {
                // clear reservation from session.
                session()->pull('reservation');

                session()->flash('message', [
                    'type' => 'warning',
                    'content' =>    'We cannot process your payment. Transaction has been cancelled.'
                ]);
            }
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage()
            ]);
        }

        return redirect()->route('front.reservation.cart');
    }
}