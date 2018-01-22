<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('su')->group(function() {
    Route::get('/login', 'Root\Auth\SessionController@showLoginForm')->name('superuser.login');
    Route::post('/login', 'Root\Auth\SessionController@login');
    Route::post('/logout', 'Root\Auth\SessionController@logout')->name('superuser.logout');
});
