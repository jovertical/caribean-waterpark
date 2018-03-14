<?php

Route::namespace('Front')->name('front.')->group(function () {
    Route::get('/', 'PagesController@welcome')->name('welcome');
    Route::get('/contact', 'PagesController@contact')->name('contact');
    Route::get('/terms', 'PagesController@terms')->name('terms');
    Route::prefix('accomodations')->name('items.')->group(function() {
        Route::get('/', 'ItemsController@index')->name('index');
        Route::get('/{item}', 'ItemsController@show')->name('show');
    });

    Route::namespace('Auth')->group(function() {
        Route::get('register', 'RegisterController@showRegisterForm')->name('register');
        Route::post('register', 'RegisterController@register');
        Route::get('verify/{token}', 'RegisterController@verify')->name('register.verify');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset/{token}', 'ResetPasswordController@reset');
    });

    Route::prefix('reservation')->name('reservation.')->group(function() {
        Route::get('/search', 'ReservationsController@search')->name('search');
        Route::get('/search/{item}', 'ReservationsController@showItem')->name('show-item');
        Route::post('/cart/{index}/add', 'ReservationsController@addItem')->name('add-item');
        Route::post('/cart/{index}/remove', 'ReservationsController@removeItem')->name('remove-item');
        Route::get('/cart', 'ReservationsController@cart')->name('cart.index');
        Route::post('/cart', 'ReservationsController@destroyCart')->name('cart.destroy');
        Route::get('/user', 'ReservationsController@user')->name('user');
        Route::post('/store', 'ReservationsController@store')->name('store');
        Route::get('/paypal-express-redirect/{reservation}', 'ReservationsController@paypalRedirect')->name('paypal.redirect');
        Route::get('/paypal-express-callback/{reservation}', 'ReservationsController@paypalCallback')->name('paypal.callback');
        Route::get('/review/{reservation}', 'ReservationsController@review')->name('review');
    });

    Route::middleware('front.auth')->prefix('user')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');

        Route::get('/profile', 'AccountController@profile')->name('profile');
        Route::patch('/profile', 'AccountController@updateProfile');
        Route::get('/settings', 'AccountController@settings')->name('settings');
        Route::patch('/settings', 'AccountController@updateSettings');

        Route::prefix('reservations')->name('reservations.')->group(function() {
            Route::get('/', 'ReservationsController@index')->name('index');
            Route::get('/{reservation}', 'ReservationsController@show')->name('show');
        });

        Route::prefix('item-reviews')->name('item-reviews.')->group(function() {
            Route::post('/{item}', 'ItemReviewsController@store')->name('store');
            Route::patch('/{item}', 'ItemReviewsController@update')->name('update');
            Route::delete('/{item}', 'ItemReviewsController@destroy')->name('destroy');
        });
    });
});