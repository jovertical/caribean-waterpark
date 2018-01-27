<?php

Route::group(['prefix' => 'su', 'as' => 'superuser.'], function () {
    Route::get('/login', 'Root\Auth\SessionController@showLoginForm')->name('login');
    Route::post('/login', 'Root\Auth\SessionController@login');
    Route::post('/logout', 'Root\Auth\SessionController@logout')->name('logout');
});

Route::group(['as' => 'front.'], function () {
    return \App\User::all();
    
    Route::get('/', 'FrontController@welcome')->name('welcome');
});
