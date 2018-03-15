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

        // assign reviewable attribute
        $item->reviewable = $this->itemReviewable($item);

        return view('front.items.show', compact('item', 'item_reviews'));
    }

    /**
     * Determine if reviewable by the user, based on past reservations.
     * @param  Item   $item
     * @return boolean
     */
    protected function itemReviewable(Item $item)
    {
        if (auth()->check()) {
            $user_reservations = auth()->user()->reservations;

            foreach ($user_reservations as $index => $user_reservation) {
                if (in_array(strtolower($user_reservation->status), ['paid', 'reserved'])) {
                    if ($user_reservation->days->where('entered_at', '!=', null)->count()) {
                        if ($user_reservation->items->contains('item_id', $item->id)) {
                            if (! $item->reviews->contains('user_id', auth()->user()->id)) {
                                return true;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }
}
