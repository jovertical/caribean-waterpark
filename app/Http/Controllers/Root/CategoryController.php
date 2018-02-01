<?php

namespace App\Http\Controllers\Root;

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
            'name'          => 'required|unique:categories',
            'description'   => 'required',
        ]);

        Category::create([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
        ]);

        session()->flash('message', [
            'type' => 'success',
            'content' => 'Category created.'
        ]);

        return redirect()->route('root.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        session()->flash('message', [
            'type' => 'success',
            'content' => 'Category deleted.'
        ]);

        return redirect()->back();
    }
}
