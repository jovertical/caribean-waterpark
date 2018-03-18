<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Setting
{
    public function reservation()
    {
        $settings = [
            'days_prior' => $this->table()->where('name', 'days_prior')->first()->value,
            'minimum_reservation_length' => $this->table()->where('name', 'minimum_reservation_length')->first()->value,
            'maximum_reservation_length' => $this->table()->where('name', 'maximum_reservation_length')->first()->value,
            'partial_payment_rate' => $this->table()->where('name', 'partial_payment_rate')->first()->value,
            'tax_rate' => $this->table()->where('name', 'tax_rate')->first()->value,
            'allow_refund' => $this->table()->where('name', 'allow_refund')->first()->value,
            'days_refundable' => $this->table()->where('name', 'days_refundable')->first()->value,
            'refundable_rate' => $this->table()->where('name', 'refundable_rate')->first()->value
        ];

        return array_map(function($setting) {
            return (int) $setting;
        }, $settings);
    }

    public function calendar()
    {
        return [
            'calendar_days' => [
                [
                    'day' => 'Sunday',
                    'active' => $this->table()->where('name', 'sunday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'sunday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'sunday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'sunday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'sunday_night_closing_time')->first()->value,
                    'adult_rate' => (float)  $this->table()->where('name', 'sunday_adult_rate')->first()->value,
                    'children_rate' => (float)  $this->table()->where('name', 'sunday_children_rate')->first()->value
                ],
                [
                    'day' => 'Monday',
                    'active' => (boolean) $this->table()->where('name', 'monday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'monday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'monday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'monday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'monday_night_closing_time')->first()->value,
                    'adult_rate' => (float) $this->table()->where('name', 'monday_adult_rate')->first()->value,
                    'children_rate' => (float) $this->table()->where('name', 'monday_children_rate')->first()->value
                ],

                [
                    'day' => 'Tuesday',
                    'active' => (boolean) $this->table()->where('name', 'tuesday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'tuesday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'tuesday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'tuesday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'tuesday_night_closing_time')->first()->value,
                    'adult_rate' =>  (float) $this->table()->where('name', 'tuesday_adult_rate')->first()->value,
                    'children_rate' => (float) $this->table()->where('name', 'tuesday_children_rate')->first()->value
                ],

                [
                    'day' => 'Wednesday',
                    'active' => (boolean) $this->table()->where('name', 'wednesday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'wednesday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'wednesday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'wednesday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'wednesday_night_closing_time')->first()->value,
                    'adult_rate' => (float) $this->table()->where('name', 'wednesday_adult_rate')->first()->value,
                    'children_rate' => (float) $this->table()->where('name', 'wednesday_children_rate')->first()->value
                ],

                [
                    'day' => 'Thursday',
                    'active' => 1,
                    'active' => (boolean) $this->table()->where('name', 'thursday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'thursday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'thursday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'thursday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'thursday_night_closing_time')->first()->value,
                    'adult_rate' => (float)  $this->table()->where('name', 'thursday_adult_rate')->first()->value,
                    'children_rate' => (float)  $this->table()->where('name', 'thursday_children_rate')->first()->value
                ],

                [
                    'day' => 'Friday',
                    'active' => (boolean) $this->table()->where('name', 'monday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'friday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'friday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'friday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'friday_night_closing_time')->first()->value,
                    'adult_rate' => (float) $this->table()->where('name', 'friday_adult_rate')->first()->value,
                    'children_rate' => (float) $this->table()->where('name', 'friday_children_rate')->first()->value
                ],

                [
                    'day' => 'Saturday',
                    'active' => (boolean) $this->table()->where('name', 'saturday')->first()->value,
                    'day_opening_time' => $this->table()->where('name', 'saturday_day_opening_time')->first()->value,
                    'day_closing_time' => $this->table()->where('name', 'saturday_day_closing_time')->first()->value,
                    'night_opening_time' => $this->table()->where('name', 'saturday_night_opening_time')->first()->value,
                    'night_closing_time' => $this->table()->where('name', 'saturday_night_closing_time')->first()->value,
                    'adult_rate' => (float) $this->table()->where('name', 'saturday_adult_rate')->first()->value,
                    'children_rate' => (float) $this->table()->where('name', 'saturday_children_rate')->first()->value
                ],


            ]
        ];
    }

    protected function table()
    {
        return DB::table('settings');
    }
}