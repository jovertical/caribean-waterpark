<?php

namespace App\Http\Controllers\Root;

use App\Notifications\LoginCredential;
use App\{User};
use Helper, ImageUploader;
use Storage, File, Str, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('type', 'user')->get()->all();

        return view('root.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('root.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'         => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|string|max:255',
            'birthdate'     => 'max:255',
            'gender'        => 'max:255',
            'address'       => 'max:510',
            'phone_number'  => 'max:255'
        ]);

        try {
            $user = new User;
            $username = Helper::createUsername($request->input('email'));
            $password = Helper::createPassword();

            $user->verified        = true;
            $user->type            = 'user';
            $user->name            = $username;
            $user->email           = $request->input('email');
            $user->password        = bcrypt($password);
            $user->first_name      = $request->input('first_name');
            $user->middle_name     = $request->input('middle_name');
            $user->last_name       = $request->input('last_name');
            $user->birthdate       = $request->input('birthdate');
            $user->gender          = $request->input('gender');
            $user->address         = $request->input('address');
            $user->phone_number    = $request->input('phone_number');

            if ($user->save()) {
                $user->notify(new LoginCredential($username, $password));

                Notify::success('User created.', 'Success!');

                return redirect()->route('root.users.image', $user);
            }

            Notify::warning('Cannot create a user', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function edit(User $user)
    {
        return view('root.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email'         => "required|string|email|max:255|unique:users,email,{$user->id},id,deleted_at,NULL",
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|string|max:255',
            'birthdate'     => 'max:255',
            'gender'        => 'max:255',
            'address'       => 'max:510',
            'phone_number'  => 'max:255'
        ]);

        try {
            $user->email           = $request->input('email');
            $user->first_name      = $request->input('first_name');
            $user->middle_name     = $request->input('middle_name');
            $user->last_name       = $request->input('last_name');
            $user->birthdate       = $request->input('birthdate');
            $user->gender          = $request->input('gender');
            $user->address         = $request->input('address');
            $user->phone_number    = $request->input('phone_number');

            if ($user->save()) {
                Notify::success('User updated.', 'Success!');

                return redirect()->route('root.users.index');
            }

            Notify::warning('Cannot update user', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function toggle(User $user)
    {
        try {
            $user->active = $user->active ? false : true;

            if ($user->save()) {
                Notify::success('User toggled.', 'Success!');

                return back();
            }

            Notify::warning('Cannot toggle user', 'Ooops?');

        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function selectImage(User $user)
    {
        try {
            if ($user != null) {
                return view('root.users.image', ['user' => $user]);
            }

            Notify::warning('Cannot find user', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function uploadedImage(Request $request, User $user)
    {
        $thumbs_directory = $user->file_directory.'/thumbnails';

        if (File::exists($thumbs_directory.'/'.$user->file_name)) {
            $file_path = $thumbs_directory.'/'.$user->file_name;

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

    public function uploadImage(Request $request, User $user)
    {
        try {
            $upload = ImageUploader::upload($request->file('image'), "users/{$user->id}");

            $user->file_path = $upload['file_path'];
            $user->file_directory = $upload['file_directory'];
            $user->file_name = $upload['file_name'];

            if ($user->save()) {
                return response()->json($upload);
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not uploaded.');
    }

    public function destroyImage(Request $request, User $user)
    {
       try {
            $file_name = $request->input('file_name');

            if (File::exists($user->file_directory.'/'.$file_name)) {
                File::delete($user->file_directory.'/'.$file_name);
            }

            if (File::exists($user->file_directory.'/thumbnails/'.$file_name)) {
                File::delete($user->file_directory.'/thumbnails/'.$file_name);
            }

            $user->file_path = null;
            $user->file_directory = null;
            $user->file_name = null;

            if ($user->save()) {
                return response()->json('File deleted.');
            }
        } catch(Exception $e) {
            return response()->json($e, 400);
        }

        return response()->json('File not deleted.');
    }
}