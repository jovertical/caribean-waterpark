<?php

namespace App\Http\Controllers\Front;

use App\{Item};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemReviewsController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'facility_rating' => 'required|integer',
            'service_rating' => 'required|integer',
            'cleanliness_rating' => 'required|integer',
            'value_for_money_rating' => 'required|integer',
            'body' => 'max:510'
        ]);

        try {
            $item->createReview(auth()->user(), $request->all());

            session()->flash('message', [
                'type' => 'success',
                'content' => 'Review submitted! Thanks for your time.'
            ]);
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage()
            ]);
        }

        return back();
    }
}