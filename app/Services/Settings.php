<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Settings {

    public function reservation()
    {
        return [
            'days_prior' => DB::table('settings')->where('name', 'days_prior')->first()->value,
            'initial_payment_rate' => DB::table('settings')->where('name', 'initial_payment_rate')->first()->value,
            'allow_refund' => DB::table('settings')->where('name', 'allow_refund')->first()->value,
            'days_refundable' => DB::table('settings')->where('name', 'days_refundable')->first()->value,
            'pre_reservation_refund_rate' => DB::table('settings')->where('name', 'pre_reservation_refund_rate')->first()->value,
            'post_reservation_refund_rate' => DB::table('settings')->where('name', 'post_reservation_refund_rate')->first()->value
        ];
    }
}