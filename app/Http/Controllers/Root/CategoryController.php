<?php

namespace App\Http\Controllers\Root;

use Toastr as Notify;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('root.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('root.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:100',
            'description'   => 'max:500'
        ]);

        try {
            Category::create([
                'name'          => $request->input('name'),
                'description'   => $request->input('description'),
            ]);

            Notify::success('Category created.', 'Success!');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');

            return redirect()->back();
        }

        return redirect()->route('root.categories.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('root.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|max:100',
            'description'   => 'max:500'
        ]);

        try {
            Category::find($id)->update([
                'name'          => $request->input('name'),
                'description'   => $request->input('description'),
            ]);
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');

            return redirect()->back();
        }

        Notify::success('Category updated.', 'Success!');

        return redirect()->route('root.categories.index');
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            $category->delete();
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');

            return redirect()->back();
        }

        Notify::success('Category deleted.', 'Success!');

        return redirect()->back();
    }

    public function selectPicture($id)
    {
        $category = Category::find($id);

        return view('root.categories.picture', ['category' => $category]);
    }

    public function uploadPicture(Request $request, $id)
    {

    }
}
