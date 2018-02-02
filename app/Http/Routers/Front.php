<?php

Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::middleware(['front.guest', 'front.auth'])->group(function() {
        Route::get('/', 'PagesController@welcome')->name('welcome');
    });
});