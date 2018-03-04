<?php

Route::namespace('Root')->prefix('superuser')->name('root.')->group(function () {
    Route::namespace('Auth')->group(function() {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset/{token}', 'ResetPasswordController@reset');

        Route::get('credentials/set/{token}', 'SetCredentialsController@showSetForm')->name('credentials.set');
        Route::post('credentials/set/{token}', 'SetCredentialsController@set');
    });

    Route::middleware('root.auth')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');

        Route::resource('users', 'UsersController');
        Route::patch('users/{user}/toggle', 'UsersController@toggle')->name('users.toggle');
        Route::get('users/{user}/image', 'UsersController@selectImage')->name('users.image');
        Route::post('users/{user}/image/upload', 'UsersController@uploadImage')->name('users.image.upload');
        Route::get('users/{user}/image/uploaded', 'UsersController@uploadedImage')->name('users.image.uploaded');
        Route::delete('users/{user}/image/destroy', 'UsersController@destroyImage')->name('users.image.destroy');

        Route::resource('superusers', 'SuperusersController');
        Route::patch('superusers/{superuser}/toggle', 'SuperusersController@toggle')->name('superusers.toggle');
        Route::get('superusers/{superuser}/image', 'SuperusersController@selectImage')->name('superusers.image');
        Route::post('superusers/{superuser}/image/upload', 'SuperusersController@uploadImage')->name('superusers.image.upload');
        Route::get('superusers/{superuser}/image/uploaded', 'SuperusersController@uploadedImage')->name('superusers.image.uploaded');
        Route::delete('superusers/{superuser}/image/destroy', 'SuperusersController@destroyImage')->name('superusers.image.destroy');

        Route::get('settings', 'SettingsController@index')->name('settings');

        Route::resource('categories', 'CategoriesController');
        Route::patch('categories/{category}/toggle', 'CategoriesController@toggle')->name('categories.toggle');
        Route::get('categories/{category}/image', 'CategoriesController@selectImage')->name('categories.image');
        Route::post('categories/{category}/image/upload', 'CategoriesController@uploadImage')->name('categories.image.upload');
        Route::get('categories/{category}/image/uploaded', 'CategoriesController@uploadedImage')->name('categories.image.uploaded');
        Route::delete('categories/{category}/image/destroy', 'CategoriesController@destroyImage')->name('categories.image.destroy');

        Route::resource('items', 'ItemsController');
        Route::patch('items/{item}/toggle', 'ItemsController@toggle')->name('items.toggle');
        Route::get('items/{item}/image', 'ItemsController@selectImage')->name('items.image');
        Route::post('items/{item}/image/upload', 'ItemsController@uploadImage')->name('items.image.upload');
        Route::get('items/{item}/image/uploaded', 'ItemsController@uploadedImage')->name('items.image.uploaded');
        Route::delete('items/{item}/image/destroy', 'ItemsController@destroyImage')->name('items.image.destroy');

        Route::resource('coupons', 'CouponsController');
        Route::get('coupons/{coupon}/image', 'CouponsController@selectImage')->name('coupons.image');
        Route::post('coupons/{coupon}/image/upload', 'CouponsController@uploadImage')->name('coupons.image.upload');
        Route::get('coupons/{coupon}/image/uploaded', 'CouponsController@uploadedImage')->name('coupons.image.uploaded');
        Route::delete('coupons/{coupon}/image/destroy', 'CouponsController@destroyImage')->name('coupons.image.destroy');

        Route::get('reservations', 'ReservationsController@index')->name('reservations.index');
        Route::patch('reservations/{reservation}/update', 'ReservationsController@update')->name('reservations.update');
        Route::get('reservations/{reservation}', 'ReservationsController@show')->name('reservations.show');

        Route::patch('reservation-days/{reservationday}/update', 'ReservationsController@updateDay')->name('reservation-days.update');

        Route::get('reservation/search', 'ReservationsController@searchItems')->name('reservation.search-items');
        Route::post('reservation/cart/{index}/add', 'ReservationsController@addItem')->name('reservation.add-item');
        Route::post('reservation/cart/{index}/remove', 'ReservationsController@removeItem')->name('reservation.remove-item');
        Route::post('reservation/cart/clear', 'ReservationsController@clearItems')->name('reservation.clear-items');
        Route::get('reservation/cart', 'ReservationsController@showItems')->name('reservation.show-items');
        Route::get('reservation/user', 'ReservationsController@user')->name('reservation.user');
        Route::post('reservation/user/store', 'ReservationsController@storeUser')->name('reservation.store-user');
        Route::post('reservation/{user}/store', 'ReservationsController@store')->name('reservation.store');
    });
});