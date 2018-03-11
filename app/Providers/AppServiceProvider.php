<?php

namespace App\Providers;

use Carbon;
use App\Services\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (Schema::hasTable('settings')) {
            $reservation_settings = app(Setting::class)->reservation();

            view()->composer('*', function($view) use ($reservation_settings) {
                $days_prior = $reservation_settings['days_prior'];
                $max_length = $reservation_settings['maximum_reservation_length'];
                $minimum_date = Carbon::now()->addDays($days_prior)->format('Y-m-d');
                $maximum_date = Carbon::parse($minimum_date)->addDays($max_length)->format('Y-m-d');

                $view->with([
                    'days_prior' => $reservation_settings['days_prior'],
                    'minimum_reservation_length' => $reservation_settings['minimum_reservation_length'],
                    'maximum_reservation_length' => $reservation_settings['maximum_reservation_length'],
                    'partial_payment_rate' => $reservation_settings['partial_payment_rate'],
                    'tax_rate' => $reservation_settings['tax_rate'],
                    'allow_refund' => $reservation_settings['allow_refund'],
                    'days_refundable' => $reservation_settings['days_refundable'],
                    'refundable_rate' => $reservation_settings['refundable_rate'],
                    'minimum_reservation_date' => $minimum_date,
                    'maximum_reservation_date' => $maximum_date
                ]);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Setting::class, function ($app) {
            return new Setting();
        });
    }
}
