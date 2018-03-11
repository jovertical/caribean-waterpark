<?php

include_once app_path('Http/Routers/Root.php');
include_once app_path('Http/Routers/Front.php');

Route::get('/logout', function() {
    session()->flush();

    return redirect('/');
});