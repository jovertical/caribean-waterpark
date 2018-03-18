<?php

namespace App\Traits;

use Carbon;
use App\ItemCalendar;

trait ItemCalendarProcesses
{
    public function computeItemCosts(array $reservation_settings, array $items, float $deductable = null)
    {
        foreach ($items as $index => $item) {
            $price_taxable = $item->price * ($reservation_settings['tax_rate'] / 100);
            $price_subpayable = $item->price;
            $price_deductable = 0.00;
            $price_payable = $item->price - $price_deductable;

            $item->costs = [
                'price_taxable'         => $price_taxable,
                'price_subpayable'      => $price_subpayable,
                'price_deductable'      => $price_deductable,
                'price_payable'         => $price_payable
            ];
        }

        if (count($items)) {
            $price_partial_payable = $price_payable / max($reservation_settings['partial_payment_rate'], 1);
            $price_taxable = array_sum(array_column(array_column($items, 'costs'), 'price_taxable'));
            $price_subpayable = array_sum(array_column(array_column($items, 'costs'), 'price_subpayable'));
            $price_deductable = 0.00;
            $price_payable = $price_subpayable - $price_deductable;

            return [
                'price_partial_payable' => $price_partial_payable,
                'price_taxable'         => $price_taxable,
                'price_subpayable'      => $price_subpayable,
                'price_deductable'      => $price_deductable,
                'price_payable'         => $price_payable,
            ];
        }

        return [
            'price_partial_payable' => 0.00,
            'price_taxable'         => 0.00,
            'price_subpayable'      => 0.00,
            'price_deductable'      => 0.00,
            'price_payable'         => 0.00
        ];
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

        $reservation_errors = [];

        if (($checkin_date == null) OR ($checkout_date == null)) {
            array_push($reservation_errors, 'You must set a checkin and checkout date');
        }

        if (($adult_quantity == null) OR (! is_numeric($adult_quantity))) {
            array_push($reservation_errors, 'Adult quantity is not valid');
        }

        if ($children_quantity != null) {
            if (! is_numeric($children_quantity)) {
                array_push($reservation_errors, 'Children quantity is not valid');
            }
        }

        $checkin_date = Carbon::parse($checkin_date);
        $checkout_date = Carbon::parse($checkout_date);
        $days = $checkin_date->diffInDays($checkout_date) + 1;
        $earliest = Carbon::parse(now()->addDays($days_prior)->format('Y-m-d'));

        if ($checkin_date > $checkout_date) {
            array_push($reservation_errors, 'Invalid date');
        }

        if ($checkin_date < $earliest) {
            array_push($reservation_errors, 'Check-in date must be '.$days_prior.' day(s) prior today');
        }

        if ($days > $maximum_reservation_length) {
            array_push($reservation_errors,
                'Reservation length must not be greater than '.$maximum_reservation_length.' day(s)');
        }

        if ($days < $minimum_reservation_length) {
            array_push($reservation_errors,
                'Reservation length must not be lesser than '.$minimum_reservation_length.' day(s)');
        }

        return $reservation_errors;
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
                $item_calendar = ItemCalendar::where('date', $date)
                                    ->where('item_id', $items[$i]->id)
                                    ->first();

                ItemCalendar::UpdateOrCreate([
                    'item_id' => $items[$i]->item->id,
                    'date' =>  $date
                ], [
                    'item_id' => $items[$i]->item->id,
                    'date' =>  $date
                ])->save();

                $item_calendar = ItemCalendar::where('date', $date)
                                    ->where('item_id', $items[$i]->item->id)
                                    ->first();
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
                $item_calendar = ItemCalendar::where('date', $date)
                                    ->where('item_id', $item->item->id)
                                    ->first();

                // Update item calendar.
                $item_calendar->quantity -= $item->quantity;
                $item_calendar->save();

                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }
        }
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
            $item_calendar =    ItemCalendar::where('item_id', $items[$i]->item->id)
                                    ->whereBetween('date', [$checkin_date, $checkout_date]);

            /**
             * Calendar quantity plus the requested quantity.
             * @var int
             */
            $quantity = $item_calendar->max('quantity') + $items[$i]->quantity;

            if ($items[$i]->item->quantity < $quantity) {
                return false;
            }
        }

        return true;
    }
}