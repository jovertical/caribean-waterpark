<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Setting {

    public function reservation()
    {
        return [
            'days_prior' => DB::table('settings')->where('name', 'days_prior')->first()->value,
            'minimum_reservation_length' => DB::table('settings')->where('name', 'minimum_reservation_length')->first()->value,
            'maximum_reservation_length' => DB::table('settings')->where('name', 'maximum_reservation_length')->first()->value,
            'partial_payment_rate' => DB::table('settings')->where('name', 'partial_payment_rate')->first()->value,
            'allow_refund' => DB::table('settings')->where('name', 'allow_refund')->first()->value,
            'days_refundable' => DB::table('settings')->where('name', 'days_refundable')->first()->value,
            'refundable_rate' => DB::table('settings')->where('name', 'refundable_rate')->first()->value
        ];
    }
}