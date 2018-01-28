<?php

Route::group(['prefix' => 'superuser', 'as' => 'superuser.'], function () {
    Route::get('/login', 'Root\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Root\Auth\LoginController@login');
    Route::post('/logout', 'Root\Auth\LoginController@logout')->name('logout');

    Route::middleware('superuser.auth')->group(function() {
        Route::get('/', 'Root\HomeController@index')->name('home');
        Route::resource('superusers', 'Root\UsersController');
    });
});

Route::group(['as' => 'front.'], function () {
    Route::get('/', 'FrontController@welcome')->name('welcome');
});
