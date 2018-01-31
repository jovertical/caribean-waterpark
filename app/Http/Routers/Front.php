<?php

Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::get('/', 'PagesController@welcome')->name('welcome');
});