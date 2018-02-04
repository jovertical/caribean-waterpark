<?php

Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::middleware(['front.guest'])->group(function() {
        Route::get('/', 'PagesController@welcome')->name('welcome');
    });
});