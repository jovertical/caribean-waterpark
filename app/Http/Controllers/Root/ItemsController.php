<?php

namespace App\Http\Controllers\Root;

use App\Category;
use App\Item;
use ImageUploader;
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

    public function uploadedImage(Request $request, $id)
    {
        try {
            $item = Item::find($id);

            $item_images = $item->images;

            $images = [];

            foreach($item_images as $item_image) {
                $thumbs_directory = $item_image->file_directory.'/thumbnails';

                if (File::exists($thumbs_directory.'/'.$item_image->file_name)) {
                    $file_path = $thumbs_directory.'/'.$item_image->file_name;

                    $images[] = [
                        'directory' => URL::to($thumbs_directory),
                        'name'      => File::name($file_path).'.'.File::extension($file_path),
                        'size'      => File::size($file_path)
                    ];
                }
            }

            return response()->json(['images' => $images]);
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('Cannot find your images.');
    }

    public function uploadImage(Request $request, $id)
    {
        try {
            $item = Item::find($id);

            $upload = ImageUploader::upload($request->file('image'), "items/{$item->id}");

            if ($upload) {
                if ($item->images()->count() < 5) {
                    $item->images()->create([
                        'count'             => $item->images()->count() + 1,
                        'file_path'         => $upload['file_path'],
                        'file_directory'    => $upload['file_directory'],
                        'file_name'         => $upload['file_name']
                    ]);
                }
            }

            return response()->json($upload);
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('Upload is not successful.');
    }

    public function destroyImage(Request $request, $id)
    {
        try {
            $item = Item::find($id);

            return response()->json($item);

            $file_name = $request->input('file_name');

            $item->images->each(function($image) use ($file_name) {

                if (File::exists($image->file_directory.'/'.$file_name)) {
                    File::delete($image->file_directory.'/'.$file_name);
                }

                if (File::exists($image->file_directory.'/thumbnails/'.$file_name)) {
                    File::delete($image->file_directory.'/thumbnails/'.$file_name);
                }

                // $image->file_path = null;
                // $image->file_directory = null;
                // $image->file_name = null;

                if ($image->save()) {
                    return response()->json([]);
                }
            });
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('Cannot delete your image.');
    }

}
