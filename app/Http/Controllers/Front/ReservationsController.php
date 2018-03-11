<?php

namespace App\Http\Controllers\Front;

use App\Traits\{ComputesCosts};
use App\{User, Reservation, ReservationDay, ReservationItem, Category, Item, ItemCalendar};
use Setting, Helper, PaypalExpress;
use Str, Carbon;
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
            if (! $this->validateSearch($search_parameters)) {
                if (count($this->reservation_errors)) {
                    session(['reservation' => []]);

                    session()->flash('message', [
                        'type' => 'warning',
                        'content' => $this->reservation_errors[0].'. Please try again.'
                    ]);
                }

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

    public function showItem(Item $item)
    {
        return view('front.items.show', compact('item'));
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
                    'content' => $item_added->item->name.' was added to '.'<a href="'.
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
            'content' => "{$item_added->item->name} was not added."
        ]);

        return $redirect_to != null ? redirect($redirect_to) : back();
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

                // re-compute item costs
                $item_costs =   $this->computeItemCosts(
                                    $this->reservation_settings,
                                    session()->get('reservation.selected_items')
                                );

                session(['reservation.item_costs' => $item_costs]);

                session()->flash('message', [
                    'type' => 'success',
                    'content' => "{$item_removed->item->name} removed."
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
        $users = User::where('type', 'user')->where('active', 1)->get();

        return view('front.reservation.user', compact('users'));
    }
}