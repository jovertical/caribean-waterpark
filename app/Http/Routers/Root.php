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
    });

    Route::middleware('root.auth')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');

        Route::prefix('users')->name('users.')->group(function() {
            Route::resource('/', 'UsersController');
            Route::patch('/{user}/toggle', 'UsersController@toggle')->name('toggle');
            Route::get('/{user}/image', 'UsersController@selectImage')->name('image');
            Route::post('/{user}/image/upload', 'UsersController@uploadImage')->name('image.upload');
            Route::get('/{user}/image/uploaded', 'UsersController@uploadedImage')->name('image.uploaded');
            Route::delete('/{user}/image/destroy', 'UsersController@destroyImage')->name('image.destroy');
        });

        Route::prefix('superusers')->name('superusers.')->group(function() {
            Route::resource('/', 'SuperusersController');
            Route::patch('/{superuser}/toggle', 'SuperusersController@toggle')->name('toggle');
            Route::get('/{superuser}/image', 'SuperusersController@selectImage')->name('image');
            Route::post('/{superuser}/image/upload', 'SuperusersController@uploadImage')->name('image.upload');
            Route::get('/{superuser}/image/uploaded', 'SuperusersController@uploadedImage')->name('image.uploaded');
            Route::delete('/{superuser}/image/destroy', 'SuperusersController@destroyImage')->name('image.destroy');
        });

        Route::prefix('settings')->name('settings.')->group(function() {
            Route::get('/', 'SettingsController@index')->name('index');
            Route::patch('/update', 'SettingsController@update')->name('update');
        });

        Route::prefix('categories')->name('categories.')->group(function() {
            Route::resource('/', 'CategoriesController');
            Route::patch('/{category}/toggle', 'CategoriesController@toggle')->name('toggle');
            Route::get('/{category}/image', 'CategoriesController@selectImage')->name('image');
            Route::post('/{category}/image/upload', 'CategoriesController@uploadImage')->name('image.upload');
            Route::get('/{category}/image/uploaded', 'CategoriesController@uploadedImage')->name('image.uploaded');
            Route::delete('/{category}/image/destroy', 'CategoriesController@destroyImage')->name('image.destroy');
        });

        Route::prefix('items')->name('items.')->group(function() {
            Route::resource('/', 'ItemsController');
            Route::patch('/{item}/toggle', 'ItemsController@toggle')->name('toggle');
            Route::get('/{item}/image', 'ItemsController@selectImage')->name('image');
            Route::post('/{item}/image/upload', 'ItemsController@uploadImage')->name('image.upload');
            Route::get('/{item}/image/uploaded', 'ItemsController@uploadedImage')->name('image.uploaded');
            Route::delete('/{item}/image/destroy', 'ItemsController@destroyImage')->name('image.destroy');
        });
        Route::prefix('coupons')->name('coupons.')->group(function() {
            Route::resource('/', 'CouponsController');
            Route::get('/{coupon}/image', 'CouponsController@selectImage')->name('image');
            Route::post('/{coupon}/image/upload', 'CouponsController@uploadImage')->name('image.upload');
            Route::get('/{coupon}/image/uploaded', 'CouponsController@uploadedImage')->name('image.uploaded');
            Route::delete('/{coupon}/image/destroy', 'CouponsController@destroyImage')->name('image.destroy');
        });

        Route::prefix('reservations')->name('reservations.')->group(function() {
            Route::get('/', 'ReservationsController@index')->name('index');
            Route::patch('/{reservation}/update', 'ReservationsController@update')->name('update');
            Route::get('/{reservation}', 'ReservationsController@show')->name('show');
            Route::get('/{reservation}/transactions', 'ReservationsController@transactions')->name('transactions.index');
            Route::post('/{reservation}/transactions', 'ReservationsController@storeTransaction')->name('transactions.store');
            Route::get('/{reservation}/paypal-express-redirect', 'ReservationsController@paypalRedirect')->name('paypal.redirect');
            Route::get('/{reservation}/paypal-express-callback', 'ReservationsController@paypalCallback')->name('paypal.callback');
            Route::get('/{reservation}/days', 'ReservationsController@days')->name('days.index');
            Route::patch('/days/{reservation_day}/update', 'ReservationsController@updateDay')->name('days.update');
        });

        Route::prefix('reservation')->name('reservation.')->group(function() {
            Route::get('/search', 'ReservationsController@searchItems')->name('search-items');
            Route::post('/cart/{index}/add', 'ReservationsController@addItem')->name('add-item');
            Route::post('/cart/{index}/remove', 'ReservationsController@removeItem')->name('remove-item');
            Route::post('/cart/clear', 'ReservationsController@clearItems')->name('clear-items');
            Route::get('/cart', 'ReservationsController@showItems')->name('show-items');
            Route::get('/user', 'ReservationsController@user')->name('user');
            Route::post('/user/store', 'ReservationsController@storeUser')->name('store-user');
            Route::post('/{user}/store', 'ReservationsController@store')->name('store');
        });

        Route::prefix('paypal-express')->name('paypal-express.')->group(function() {
            Route::get('/checkout', 'PaypalController@checkout')->name('checkout');
            Route::get('/checkout', 'PaypalController@checkout')->name('checkout');
        });
    });
});