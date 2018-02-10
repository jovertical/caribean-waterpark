<?php

Route::group(['namespace' => 'Root', 'prefix' => 'superuser', 'as' => 'root.'], function () {

    Route::group(['namespace' => 'Auth'], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset/{token}', 'ResetPasswordController@reset');
    });

    Route::middleware('root.auth')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('superusers', 'UsersController');

        Route::resource('/categories', 'CategoryController');
        Route::get('/categories/{id}/image', 'CategoryController@selectImage')->name('categories.image');
        Route::post('/categories/{id}/image', 'CategoryController@uploadImage');

        Route::resource('items', 'ItemController');
        Route::resource('coupons', 'CouponController');
    });
});