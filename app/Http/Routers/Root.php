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
        Route::prefix('account')->name('account.')->group(function() {
            Route::get('/profile', 'AccountController@profile')->name('profile');
            Route::patch('/profile', 'AccountController@updateProfile');
            Route::get('/password', 'AccountController@password')->name('password');
            Route::patch('/password', 'AccountController@updatePassword');
        });

        Route::resource('users', 'UsersController');
        Route::prefix('users')->name('users.')->group(function() {
            Route::patch('/{user}/toggle', 'UsersController@toggle')->name('toggle');
            Route::get('/{user}/image', 'UsersController@selectImage')->name('image');
            Route::post('/{user}/image/upload', 'UsersController@uploadImage')->name('image.upload');
            Route::get('/{user}/image/uploaded', 'UsersController@uploadedImage')->name('image.uploaded');
            Route::delete('/{user}/image/destroy', 'UsersController@destroyImage')->name('image.destroy');
        });

        Route::resource('superusers', 'SuperusersController');
        Route::prefix('superusers')->name('superusers.')->group(function() {
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

        Route::resource('categories', 'CategoriesController');
        Route::prefix('categories')->name('categories.')->group(function() {
            Route::patch('/{category}/toggle', 'CategoriesController@toggle')->name('toggle');
            Route::get('/{category}/image', 'CategoriesController@selectImage')->name('image');
            Route::post('/{category}/image/upload', 'CategoriesController@uploadImage')->name('image.upload');
            Route::get('/{category}/image/uploaded', 'CategoriesController@uploadedImage')->name('image.uploaded');
            Route::delete('/{category}/image/destroy', 'CategoriesController@destroyImage')->name('image.destroy');
        });

        Route::resource('items', 'ItemsController');
        Route::prefix('items')->name('items.')->group(function() {
            Route::patch('/{item}/toggle', 'ItemsController@toggle')->name('toggle');
            Route::get('/{item}/image', 'ItemsController@selectImage')->name('image');
            Route::post('/{item}/image/upload', 'ItemsController@uploadImage')->name('image.upload');
            Route::get('/{item}/image/uploaded', 'ItemsController@uploadedImage')->name('image.uploaded');
            Route::delete('/{item}/image/destroy', 'ItemsController@destroyImage')->name('image.destroy');
            Route::get('/{item}/calendar', 'ItemsController@calendar')->name('calendar');
        });

        Route::resource('coupons', 'CouponsController');
        Route::prefix('coupons')->name('coupons.')->group(function() {
            Route::get('/{coupon}/image', 'CouponsController@selectImage')->name('image');
            Route::post('/{coupon}/image/upload', 'CouponsController@uploadImage')->name('image.upload');
            Route::get('/{coupon}/image/uploaded', 'CouponsController@uploadedImage')->name('image.uploaded');
            Route::delete('/{coupon}/image/destroy', 'CouponsController@destroyImage')->name('image.destroy');
        });

        Route::prefix('reservations')->name('reservations.')->group(function() {
            Route::get('/', 'ReservationsController@index')->name('index');
            Route::patch('/{reservation}/update', 'ReservationsController@update')->name('update');
            Route::get('/{reservation}', 'ReservationsController@show')->name('show');
            Route::post('/{reservation}/export', 'ReservationsController@export')->name('export');
            Route::get('/{reservation}/transactions', 'ReservationsController@transactions')->name('transactions.index');
            Route::post('/{reservation}/transactions', 'ReservationsController@storeTransaction')->name('transactions.store');
            Route::post('/{reservation}/transactions/export','ReservationsController@exportTransactions')
                ->name('transactions.export');
            Route::get('/{reservation}/days', 'ReservationsController@days')->name('days.index');
            Route::patch('/days/{reservation_day}/update', 'ReservationsController@updateDay')->name('days.update');
        });

        Route::prefix('reservation')->name('reservation.')->group(function() {
            Route::get('/search', 'ReservationsController@search')->name('search');
            Route::post('/cart/{index}/add', 'ReservationsController@addItem')->name('add-item');
            Route::post('/cart/{index}/remove', 'ReservationsController@removeItem')->name('remove-item');
            Route::get('/cart', 'ReservationsController@cart')->name('cart.index');
            Route::post('/cart/clear', 'ReservationsController@destroyCart')->name('cart.destroy');
            Route::get('/user', 'ReservationsController@user')->name('user');
            Route::post('/user', 'ReservationsController@storeUser');
            Route::post('/{user}/store', 'ReservationsController@store')->name('store');
        });

        Route::prefix('reports')->name('reports.')->group(function() {
            Route::get('/sales', 'ReportsController@sales')->name('sales');
            Route::post('/sales', 'ReportsController@exportSales');
            Route::get('/allocations', 'ReportsController@allocations')->name('allocations');
            Route::post('/allocations', 'ReportsController@exportAllocations');
        });

        Route::patch('/notification/{user}', function(\App\User $user) {
            $user->unreadNotifications->find(request('id'))->markAsRead();
        })->name('notification.read');

        Route::patch('/notifications/{user}', function(\App\User $user) {
            $user->unreadNotifications->markAsRead();

            return back();
        })->name('notifications.read');
    });
});