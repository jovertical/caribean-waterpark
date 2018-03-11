<?php

Route::namespace('Front')->name('front.')->group(function () {
    Route::get('/', 'PagesController@welcome')->name('welcome');

    Route::prefix('items')->name('items.')->group(function() {
        Route::get('/', 'ItemsController@index')->name('index');
        Route::get('/{item}', 'ItemsController@show')->name('show');
    });

    Route::namespace('Auth')->group(function() {
        Route::get('register', 'RegisterController@showRegisterForm')->name('register');
        Route::post('register', 'RegisterController@register');
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
        Route::post('/user', 'ReservationsController@storeUser');
        Route::post('/store', 'ReservationsController@store')->name('store');
        Route::get('/review', 'ReservationsController@review')->name('review');
    });

    Route::middleware('front.auth')->prefix('user')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
    });
});