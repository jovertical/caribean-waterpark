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
            $settings = app(Setting::class);

            view()->composer('*', function($view) use ($settings) {
                $calendar_settings = $settings->calendar();
                $reservation_settings = $settings->reservation();

                $days_prior = $reservation_settings['days_prior'];
                $max_length = $reservation_settings['maximum_reservation_length'];
                $minimum_reservation_date = Carbon::now()->addDays($days_prior)->format('Y-m-d');
                $maximum_reservation_date = Carbon::parse($minimum_reservation_date)
                                                ->addDays($max_length)->format('Y-m-d');
                $reservation_settings = array_merge(
                    $reservation_settings, compact([
                        'minimum_reservation_date', 'maximum_reservation_date'
                    ])
                );

                $view->with(array_merge($calendar_settings, $reservation_settings));
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
