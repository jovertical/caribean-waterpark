<?php

Route::group(['namespace' => 'Root', 'prefix' => 'superuser', 'as' => 'root.'], function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset/{token}', 'Auth\ResetPasswordController@reset');

    Route::middleware('root.auth')->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('superusers', 'UsersController');
    });
});

Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::get('/', 'PagesController@welcome')->name('welcome');
});
