<?php

namespace App\Http\Controllers\Root;

use App\Category;
use App\Item;
use File, Str, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $items = Item::all();

        return view('root.items.index', ['items' => $items, 'categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('root.items.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category'      => 'required|integer',
            'name'          => 'required|max:100|unique:items,name,NULL,id,deleted_at,NULL',
            'description'   => 'max:500',
            'price'         => 'required'
        ]);

        try {
            $item = new Item;

            $item->category_id  = $request->input('category');
            $item->name         = Str::lower($request->input('name'));
            $item->description  = $request->input('description');
            $item->price        = $request->input('price');
            $item->quantity     = $request->input('quantity');

            if ($item->save()) {
                Notify::success('Item created.', 'Success!');

                return redirect()->route('root.items.image', $item->id);
            }

            Notify::warning('Cannot create a item', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $item = Item::find($id);

        return view('root.categories.edit', ['item' => $item]);
    }
}
