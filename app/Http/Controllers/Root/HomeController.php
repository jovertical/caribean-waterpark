<?php

namespace App\Http\Controllers\Root;

use Carbon;
use App\{Reservation, User, ItemReview};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from'));
        $to = Carbon::parse($request->input('to'))->addDays(1)->subSeconds(1);

        if (($request->input('from') == null) OR ($request->input('to') == null)) {
            return redirect(route('root.home').'?from='.now()->format('Y-m-d').'&to='.now()->format('Y-m-d').'&selected=1');
        }

        $users = User::where('type', 'user')->get();
        $active_users = User::where('type', 'user')->whereBetween('created_at', [$from, $to])->get();
        $item_reviews = ItemReview::get();
        $active_item_reviews = ItemReview::whereBetween('created_at', [$from, $to])->get();
        $reservations = Reservation::get();
        $reservations_taxable = $reservations->sum('price_taxable');
        $active_reservations =  Reservation::whereBetween('created_at', [$from, $to])
                                    ->whereIn('status', ['paid', 'reserved'])->get();
        $active_reservations_taxable = $active_reservations->sum('price_taxable');

        // -------------------------------------- Profit

        $profits = collect([]);
        $reservations->each(function($reservation) use ($profits) {
            $paid_amount = $reservation->transactions->filter(function($transaction) {
                return strtolower($transaction->type) == 'payment';
            })->sum('amount');
            $refunded = $reservation->transactions->filter(function($transaction) {
                return strtolower($transaction->type) == 'refund';
            })->sum('amount');
            $profits->push($paid_amount - $refunded);
        });
        $profit = $profits->sum() - $reservations_taxable;

        $active_profits = collect([]);
        $active_reservations->each(function($reservation) use ($active_profits) {
            $paid_amount = $reservation->transactions->filter(function($transaction) {
                return strtolower($transaction->type) == 'payment';
            })->sum('amount');
            $refunded = $reservation->transactions->filter(function($transaction) {
                return strtolower($transaction->type) == 'refund';
            })->sum('amount');
            $active_profits->push($paid_amount - $refunded);
        });
        $active_profit = $active_profits->sum() - $active_reservations_taxable;

        $profit_change = ($active_profit / max($profit, 1)) * 100;


        // -------------------------------------- Item Reviews
        $item_review_change =   ($active_item_reviews->count() / max($item_reviews->count(), 1)) * 100;

        // -------------------------------------- Reservations
        $reservation_change =   ($active_reservations->count() / max($reservations->count(), 1)) * 100;

        // -------------------------------------- Customer

        $user_change =   ($active_users->count() / max($users->count(), 1)) * 100;

        $totals = collect([
            'profit'        => [
                'active'    => $active_profit,
                'change'    => number_format($profit_change, 0)
            ],
            'feedbacks'     => [
                'active'    => $active_item_reviews->count(),
                'change'    => number_format($item_review_change, 0)
            ],
            'reservations'  => [
                'active'    => $active_reservations->count(),
                'change'    => number_format($reservation_change, 0)
            ],
            'users'         => [
                'active'    => $active_users->count(),
                'change'    => number_format($user_change, 0)
            ]
        ]);

        return view('root.home', compact('totals'));
    }
}
