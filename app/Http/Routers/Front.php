<?php

Route::namespace('Front')->name('front.')->group(function () {
    Route::get('/', 'PagesController@welcome')->name('welcome');

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
        Route::get('/user', 'ReservationsController@user')->name('user');
        Route::post('/user', 'ReservationsController@storeUser');
        Route::post('/store', 'ReservationsController@store')->name('store');
        Route::get('/review', 'ReservationsController@review')->name('review');
    });

    Route::middleware('front.auth')->prefix('user')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
    });
});