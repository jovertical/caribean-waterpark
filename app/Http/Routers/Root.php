<?php

Route::group(['namespace' => 'Root', 'prefix' => 'superuser', 'as' => 'root.'], function () {

    Route::group(['namespace' => 'Auth'], function() {
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

        Route::resource('users', 'UsersController');
        Route::get('users/{id}/image', 'UsersController@selectImage')->name('users.image');
        Route::post('users/{id}/image/upload', 'UsersController@uploadImage')->name('users.image.upload');
        Route::get('users/{id}/image/uploaded', 'UsersController@uploadedImage')->name('users.image.uploaded');
        Route::delete('users/{id}/image/destroy', 'UsersController@destroyImage')->name('users.image.destroy');

        Route::resource('superusers', 'SuperusersController');
        Route::get('superusers/{id}/image', 'SuperusersController@selectImage')->name('superusers.image');
        Route::post('superusers/{id}/image/upload', 'SuperusersController@uploadImage')->name('superusers.image.upload');
        Route::get('superusers/{id}/image/uploaded', 'SuperusersController@uploadedImage')->name('superusers.image.uploaded');
        Route::delete('superusers/{id}/image/destroy', 'SuperusersController@destroyImage')->name('superusers.image.destroy');

        Route::resource('user-roles', 'UserRolesController');

        Route::get('settings', 'SettingsController@index')->name('settings');

        Route::resource('categories', 'CategoriesController');
        Route::get('categories/{id}/image', 'CategoriesController@selectImage')->name('categories.image');
        Route::post('categories/{id}/image/upload', 'CategoriesController@uploadImage')->name('categories.image.upload');
        Route::get('categories/{id}/image/uploaded', 'CategoriesController@uploadedImage')->name('categories.image.uploaded');
        Route::delete('categories/{id}/image/destroy', 'CategoriesController@destroyImage')->name('categories.image.destroy');

        Route::resource('items', 'ItemsController');
        Route::get('items/{id}/image', 'ItemsController@selectImage')->name('items.image');
        Route::post('items/{id}/image/upload', 'ItemsController@uploadImage')->name('items.image.upload');
        Route::get('items/{id}/image/uploaded', 'ItemsController@uploadedImage')->name('items.image.uploaded');
        Route::delete('items/{id}/image/destroy', 'ItemsController@destroyImage')->name('items.image.destroy');

        Route::resource('coupons', 'CouponsController');
        Route::get('coupons/{id}/image', 'ItemsController@selectImage')->name('coupons.image');
        Route::post('coupons/{id}/image/upload', 'ItemsController@uploadImage')->name('coupons.image.upload');
        Route::get('coupons/{id}/image/uploaded', 'ItemsController@uploadedImage')->name('coupons.image.uploaded');
        Route::delete('coupons/{id}/image/destroy', 'ItemsController@destroyImage')->name('coupons.image.destroy');

        Route::get('reservations', 'ReservationsController@index')->name('reservations.index');
        Route::get('reservations/search-items', 'ReservationsController@searchItems')->name('reservations.search-items');
    });
});