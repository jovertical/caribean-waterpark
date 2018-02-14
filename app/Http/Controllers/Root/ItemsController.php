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
        try {
            $item = Item::find($id);

            if ($item != null) {
                $categories = Category::all();

                return view('root.items.edit', ['categories' => $categories, 'item' => $item]);
            }

            Notify::warning('Cannot find this item', 'Ooops?');
        } catch(Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category'      => 'required|integer',
            'name'          => "required|max:100|unique:items,name,{$id},id,deleted_at,NULL",
            'description'   => 'max:500',
            'price'         => 'required'
        ]);

        try {
            $item = Item::find($id);

            $item->category_id  = $request->input('category');
            $item->name         = Str::lower($request->input('name'));
            $item->description  = $request->input('description');
            $item->price        = $request->input('price');
            $item->quantity     = $request->input('quantity');

            if ($item->save()) {
                Notify::success('Item updated.', 'Success!');

                return redirect()->route('root.items.index');
            }

            Notify::warning('Cannot update this item', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $item = Item::find($id);

            if ($item->delete()) {
                Notify::success('Item deleted.', 'Success!');

                return redirect()->back();
            }

            Notify::warning('Cannot delete item', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function selectImage($id)
    {
        try {
            $item = Item::find($id);

            if ($item != null) {
                return view('root.items.image', ['item' => $item]);
            }

            Notify::warning('Cannot find item', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }
}
