<?php

namespace App\Http\Controllers\Root;

use Toastr as Notify;
use App\Category;
use Carbon, ImageUploader, File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('s');

        switch($status) {
            case null:
                    $categories = Category::where('active', true)->get();
                break;

            case 'inactive':
                    $categories = Category::where('active', false)->get();
                break;

            case 'trashed':
                    $categories = Category::onlyTrashed()->get();
                break;

            default:
                    //
                break;
        }

        return view('root.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('root.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:100|unique:categories,name,NULL,id,deleted_at,NULL',
            'description'   => 'max:500'
        ]);

        try {
            $category = new Category();

            $category->name         = $request->input('name');
            $category->description  = $request->input('description');

            if ($category->save()) {
                Notify::success('Category created.', 'Success!');

                return redirect()->route('root.categories.image', $category->id);
            }

            Notify::warning('Cannot create a category', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('root.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => "required|max:100|unique:categories,name,{$id},id,deleted_at,NULL",
            'description'   => 'max:500'
        ]);

        try {
            $category = Category::find($id);

            $category->name         = $request->input('name');
            $category->description  = $request->input('description');

            if ($category->save()) {
                Notify::success('Category updated.', 'Success!');

                return redirect()->route('root.categories.image', $category->id);
            }

            Notify::warning('Cannot update category', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if ($category->delete()) {
                Notify::success('Category deleted.', 'Success!');

                return redirect()->back();
            }

            Notify::warning('Cannot delete category', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return redirect()->back();
    }

    public function restore($id)
    {
        //
    }

    public function selectImage($id)
    {
        $category = Category::find($id);

        return view('root.categories.image', ['category' => $category]);
    }

    public function uploadImage(Request $request, $id)
    {
        try {
            $category = Category::find($id);

            $uploaded = ImageUploader::upload($request->file('image'), "storage/root/categories/{$category->id}");

            if ($uploaded) {
                if (File::exists("{$category->file_path}/{$category->file_name}")) {
                    File::delete("{$category->file_path}/{$category->file_name}");
                }
                if (File::exists("{$category->file_path}/resized/{$category->file_name}")) {
                    File::delete("{$category->file_path}/resized/{$category->file_name}");
                }
                if (File::exists("{$category->file_path}/thumbnail/{$category->file_name}")) {
                    File::delete("{$category->file_path}/thumbnail/{$category->file_name}");
                }
            }

            $category->file_path = $uploaded['file_path'];
            $category->file_name = $uploaded['file_name'];

            if ($category->save()) {
                Notify::success('Image for category uploaded.', 'Success!');

                return redirect()->route('root.categories.index');
            }

           Notify::warning('Cannot upload your image.', 'Ooops?');

        } catch(Exception $e) {
           Notify::error('Cannot upload your image.', 'Ooops!');
        }

        return redirect()->back();
    }
}
