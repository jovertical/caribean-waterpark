<?php

namespace App\Traits;

use App\Reservation;

trait ReservationProcesses 
{
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
}