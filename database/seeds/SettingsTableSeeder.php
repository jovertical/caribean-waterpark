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
            /* Company settings */
            ['name' => 'name', 'value' => 'Caribbean-waterpark'],
            ['name' => 'email', 'value' => 'caribbeanwaterpark@yahoo.com'],
            ['name' => 'phone_number', 'value' => '(+63) 9754539538'],
            ['name' => 'facebook_url', 'value' => 'https://www.facebook.com/carrebianwavesresort'],
            ['name' => 'twitter_url', 'value' => ''],

            /* Reservation settings */
            ['name' => 'days_prior', 'value' => 0],
            ['name' => 'minimum_reservation_length', 'value' => 1],
            ['name' => 'maximum_reservation_length', 'value' => 15],
            ['name' => 'tax_rate', 'value' => 12],
            ['name' => 'partial_payment_rate', 'value' => 10],
            ['name' => 'allow_refund', 'value' => 0],
            ['name' => 'days_refundable', 'value' => 1],
            ['name' => 'refundable_rate', 'value' => 90],

            /* Calendar settings */
            ['name' => 'monday', 'value' => 1],
            ['name' => 'monday_day_opening_time', 'value' => '06:00'],
            ['name' => 'monday_day_closing_time', 'value' => '17:00'],
            ['name' => 'monday_night_opening_time', 'value' => '18:00'],
            ['name' => 'monday_night_closing_time', 'value' => '24:00'],
            ['name' => 'monday_adult_rate', 'value' => 200.00],
            ['name' => 'monday_children_rate', 'value' => 170],
            ['name' => 'tuesday', 'value' => 1],
            ['name' => 'tuesday_day_opening_time', 'value' => '06:00'],
            ['name' => 'tuesday_day_closing_time', 'value' => '17:00'],
            ['name' => 'tuesday_night_opening_time', 'value' => '18:00'],
            ['name' => 'tuesday_night_closing_time', 'value' => '24:00'],
            ['name' => 'tuesday_adult_rate', 'value' => 200.00],
            ['name' => 'tuesday_children_rate', 'value' => 170.00],
            ['name' => 'wednesday', 'value' => 1],
            ['name' => 'wednesday_day_opening_time', 'value' => '06:00'],
            ['name' => 'wednesday_day_closing_time', 'value' => '17:00'],
            ['name' => 'wednesday_night_opening_time', 'value' => '18:00'],
            ['name' => 'wednesday_night_closing_time', 'value' => '24:00'],
            ['name' => 'wednesday_adult_rate', 'value' => 200.00],
            ['name' => 'wednesday_children_rate', 'value' => 170.00],
            ['name' => 'thursday', 'value' => 1],
            ['name' => 'thursday_day_opening_time', 'value' => '06:00'],
            ['name' => 'thursday_day_closing_time', 'value' => '17:00'],
            ['name' => 'thursday_night_opening_time', 'value' => '18:00'],
            ['name' => 'thursday_night_closing_time', 'value' => '24:00'],
            ['name' => 'thursday_adult_rate', 'value' => 200.00],
            ['name' => 'thursday_children_rate', 'value' => 170.00],
            ['name' => 'friday', 'value' => 1],
            ['name' => 'friday_day_opening_time', 'value' => '06:00'],
            ['name' => 'friday_day_closing_time', 'value' => '17:00'],
            ['name' => 'friday_night_opening_time', 'value' => '18:00'],
            ['name' => 'friday_night_closing_time', 'value' => '24:00'],
            ['name' => 'friday_adult_rate', 'value' => 200.00],
            ['name' => 'friday_children_rate', 'value' => 170.00],
            ['name' => 'saturday', 'value' => 1],
            ['name' => 'saturday_day_opening_time', 'value' => '06:00'],
            ['name' => 'saturday_day_closing_time', 'value' => '17:00'],
            ['name' => 'saturday_night_opening_time', 'value' => '18:00'],
            ['name' => 'saturday_night_closing_time', 'value' => '24:00'],
            ['name' => 'saturday_adult_rate', 'value' => 250.00],
            ['name' => 'saturday_children_rate', 'value' => 200.00],
            ['name' => 'sunday', 'value' => 1],
            ['name' => 'sunday_day_opening_time', 'value' => '06:00'],
            ['name' => 'sunday_day_closing_time', 'value' => '17:00'],
            ['name' => 'sunday_night_opening_time', 'value' => '18:00'],
            ['name' => 'sunday_night_closing_time', 'value' => '24:00'],
            ['name' => 'sunday_adult_rate', 'value' => 250.00],
            ['name' => 'sunday_children_rate', 'value' => 200.00],
        ];

        foreach ($settings as $index => $setting) {
            DB::table('settings')->insert([
                'name' => $setting['name'],
                'value' => $setting['value']
            ]);
        }
    }
}
