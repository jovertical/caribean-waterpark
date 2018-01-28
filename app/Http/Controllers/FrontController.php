<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function welcome()
    {
        session()->flush();
        
        return view('front.pages.welcome');
    }
}
