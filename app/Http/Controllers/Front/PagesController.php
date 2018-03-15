<?php

namespace App\Http\Controllers\Front;

use App\{Reservation, Item, ItemReview};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function welcome()
    {
        $items = Item::where('active', 1)->paginate(5);

        $reservations = Reservation::where('status', 'paid')
                            ->orWhere('status', 'reserved')
                            ->get();

        $item_reviews = ItemReview::get();

        $best_selling_items = $this->bestSellingItems($reservations);

        $top_rated_items = $this->topRatedItems($item_reviews);

        return view('front.pages.welcome', compact([
            'items', 'item_reviews', 'best_selling_items', 'top_rated_items'
        ]));
    }

    protected function bestSellingItems(Collection $reservations)
    {
        $items = [];

        foreach($reservations as $reservation) {
            foreach($reservation->items as $reservation_item) {
                if (! in_array($reservation_item->item->id, array_column($items, 'id'))) {
                    $item = $reservation_item->item;
                    $item->order_count = 1;
                    $items[] = $item;
                } else {
                    $items[array_search(
                        $reservation_item->item->id, array_column($items, 'id')
                    )]->order_count+=1;
                }
            }
        }

        return collect($items)->sortByDesc('order_count')->take(5);
    }

    protected function topRatedItems(Collection $item_reviews)
    {
        $items = [];

        foreach($item_reviews as $item_review) {
            if (! in_array($item_review->item->id, array_column($items, 'id'))) {
                $items[] = $item_review->item;
            }
        }

        return collect($items)->sortByDesc('average_rating')->take(5);
    }
}
