<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function welcome()
    {
        session()->flush();
        
        return view('front.pages.welcome');
    }
}
