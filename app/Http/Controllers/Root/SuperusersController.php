<?php

namespace App\Http\Controllers\Root;

use App\Notifications\LoginCredential;
use App\{User};
use Helper, ImageUploader;
use Storage, File, Str, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperusersController extends Controller
{
    public function index()
    {
        $superusers = User::where('type', 'superuser')->get()->all();

        return view('root.superusers.index', ['superusers' => $superusers]);
    }

    public function create()
    {
        return view('root.superusers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'         => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'first_name'    => 'required|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|max:255',
            'birthdate'     => 'required|date',
            'gender'        => 'required|max:255',
            'address'       => 'required|max:510',
            'phone_number'  => 'max:255'
        ]);

        try {
            $superuser = new User;
            $login_credential = Helper::createLoginCredential($request->input('last_name'), User::count());

            $superuser->verified        = true;
            $superuser->type            = 'superuser';
            $superuser->name            = $login_credential;
            $superuser->email           = $request->input('email');
            $superuser->password        = bcrypt($login_credential);
            $superuser->first_name      = $request->input('first_name');
            $superuser->middle_name     = $request->input('middle_name');
            $superuser->last_name       = $request->input('last_name');
            $superuser->birthdate       = $request->input('birthdate');
            $superuser->gender          = $request->input('gender');
            $superuser->address         = $request->input('address');
            $superuser->phone_number    = $request->input('phone_number');

            if ($superuser->save()) {
                $superuser->notify(new LoginCredential($login_credential, $login_credential));

                Notify::success('Superuser created.', 'Success!');

                return redirect()->route('root.superusers.image', $superuser);
            }

            Notify::warning('Cannot create a superuser', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function edit(User $superuser)
    {
        return view('root.superusers.edit', ['superuser' => $superuser]);
    }

    public function update(Request $request, User $superuser)
    {
        $this->validate($request, [
            'email'         => "required|string|email|max:255|unique:users,email,{$superuser->id},id,deleted_at,NULL",
            'first_name'    => 'required|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|max:255',
            'birthdate'     => 'required|date',
            'gender'        => 'required|max:255',
            'address'       => 'required|max:510',
            'phone_number'  => 'max:255'
        ]);

        try {
            $superuser->email           = $request->input('email');
            $superuser->first_name      = $request->input('first_name');
            $superuser->middle_name     = $request->input('middle_name');
            $superuser->last_name       = $request->input('last_name');
            $superuser->birthdate       = $request->input('birthdate');
            $superuser->gender          = $request->input('gender');
            $superuser->address         = $request->input('address');
            $superuser->phone_number    = $request->input('phone_number');

            if ($superuser->save()) {
                Notify::success('Superuser updated.', 'Success!');

                return redirect()->route('root.superusers.index');
            }

            Notify::warning('Cannot update superuser', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function toggle(User $superuser)
    {
        try {
            $superuser->active = $superuser->active ? false : true;

            if ($superuser->save()) {
                Notify::success('Superuser toggled.', 'Success!');

                return back();
            }

            Notify::warning('Cannot toggle superuser', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function selectImage(User $superuser)
    {
        try {
            if ($superuser != null) {
                return view('root.superusers.image', ['superuser' => $superuser]);
            }

            Notify::warning('Cannot find superuser', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function uploadedImage(Request $request, User $superuser)
    {
        $thumbs_directory = $superuser->file_directory.'/thumbnails';

        if (File::exists($thumbs_directory.'/'.$superuser->file_name)) {
            $file_path = $thumbs_directory.'/'.$superuser->file_name;

            $images = [
                [
                    'directory' => URL::to($thumbs_directory),
                    'name'      => File::name($file_path).'.'.File::extension($file_path),
                    'size'      => File::size($file_path)
                ]
            ];

            return response()->json(['images' => $images]);
        }

        return response()->json('No image.');
    }

    public function uploadImage(Request $request, User $superuser)
    {
        try {
            $upload = ImageUploader::upload($request->file('image'), "superusers/{$superuser->id}");

            $superuser->file_path = $upload['file_path'];
            $superuser->file_directory = $upload['file_directory'];
            $superuser->file_name = $upload['file_name'];

            if ($superuser->save()) {
                return response()->json($upload);
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not uploaded.');
    }

    public function destroyImage(Request $request, User $superuser)
    {
       try {
            $file_name = $request->input('file_name');

            if (File::exists($superuser->file_directory.'/'.$file_name)) {
                File::delete($superuser->file_directory.'/'.$file_name);
            }

            if (File::exists($superuser->file_directory.'/thumbnails/'.$file_name)) {
                File::delete($superuser->file_directory.'/thumbnails/'.$file_name);
            }

            $superuser->file_path = null;
            $superuser->file_directory = null;
            $superuser->file_name = null;

            if ($superuser->save()) {
                return response()->json('File deleted.');
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not deleted.');
    }
}