<?php

namespace App\Http\Controllers\Front;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function welcome()
    {
        $items = Item::where('active', 1)->paginate(5);

        return view('front.pages.welcome', compact('items'));
    }
}
