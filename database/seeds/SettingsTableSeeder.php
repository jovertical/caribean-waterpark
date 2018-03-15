<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['name' => 'days_prior', 'value' => 0],
            ['name' => 'minimum_reservation_length', 'value' => 1],
            ['name' => 'maximum_reservation_length', 'value' => 15],
            ['name' => 'tax_rate', 'value' => 12],
            ['name' => 'partial_payment_rate', 'value' => 10],
            ['name' => 'allow_refund', 'value' => 0],
            ['name' => 'days_refundable', 'value' => 1],
            ['name' => 'refundable_rate', 'value' => 10]
        ];

        foreach ($settings as $index => $setting) {
            DB::table('settings')->insert([
                'name' => $setting['name'],
                'value' => $setting['value']
            ]);
        }
    }
}
