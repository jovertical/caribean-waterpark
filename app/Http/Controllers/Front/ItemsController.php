<?php

namespace App\Http\Controllers\Front;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function index()
    {
        return view('front.items.index');
    }

    public function show(Item $item)
    {
        return view('front.items.show', compact('item'));
    }
}
