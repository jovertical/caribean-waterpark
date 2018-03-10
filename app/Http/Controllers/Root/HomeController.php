<?php

namespace App\Http\Controllers\Root;

use Carbon;
use App\{Reservation, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from'));
        $to = Carbon::parse($request->input('to'))->addDays(1);

        if (($request->input('from') == null) OR ($request->input('to') == null)) {
            return redirect(route('root.home').'?from='.now()->format('Y-m-d').'&to='.now()->format('Y-m-d').'&selected=1');
        }

        $users = User::where('type', 'user')->get();
        $active_users = User::where('type', 'user')->whereBetween('created_at', [$from, $to])->get();
        $reservations = Reservation::whereIn('status', ['paid', 'reserved'])->get();
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

        $profit_change = $profit != 0.00 ? ( $active_profit / $profit) * 100 : 0.00;

        // -------------------------------------- Reservations

        $reservation_change =   $reservations->count() > 0 ? ($active_reservations->count() / 
                                    $reservations->count()) * 100 : 0;

        // -------------------------------------- Customer

        $user_change =   $users->count() > 0 ? ($active_users->count() / $users->count()) * 100 : 0;

        $totals = collect([
            'profit'        => [
                'active'    => $active_profit,
                'change'    => number_format($profit_change, 0)
            ],
            'feedbacks'     => [
                'active'    => 0,
                'change'    => 0
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

        return view('root.home', ['totals' => $totals]);
    }
}
