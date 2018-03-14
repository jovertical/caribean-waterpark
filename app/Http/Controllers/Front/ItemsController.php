<?php

namespace App\Http\Controllers\Front;

use App\{Item, ItemReview};
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
        $item_reviews = ItemReview::where('item_id', $item->id)->paginate(5);

        return view('front.items.show', compact('item', 'item_reviews'));
    }
}
