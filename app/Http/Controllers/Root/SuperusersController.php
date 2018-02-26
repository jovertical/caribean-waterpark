<?php

namespace App\Http\Controllers\Root;

use App\{User};
use ImageUploader;
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

            $superuser->verified        = true;
            $superuser->name            = $request->input('email');
            $superuser->email           = $request->input('email');
            $superuser->password        = bcrypt($request->input('last_name').'_'.date('Y'));
            $superuser->first_name      = $request->input('first_name');
            $superuser->middle_name     = $request->input('middle_name');
            $superuser->last_name       = $request->input('last_name');
            $superuser->birthdate       = $request->input('birthdate');
            $superuser->gender          = $request->input('gender');
            $superuser->address         = $request->input('address');
            $superuser->phone_number    = $request->input('phone_number');

            if ($superuser->save()) {
                Notify::success('Superuser created.', 'Success!');

                return redirect()->route('root.superuser.image', $superuser->id);
            }

            Notify::warning('Cannot create a superuser', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function edit(User $superuser)
    {
        return view('root.categories.edit', ['superuser' => $superuser]);
    }
}