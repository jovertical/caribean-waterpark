<?php

namespace App\Http\Controllers\Root;

use Notify;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function profile()
    {
        $superuser = auth()->user();

        return view('root.account.profile', compact('superuser'));
    }

    public function updateProfile(Request $request)
    {
        $superuser = auth()->user();

        $this->validate($request, [
            'email'         => "required|string|email|max:255|unique:users,email,{$superuser->id},id,deleted_at,NULL",
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'max:255',
            'last_name'     => 'required|string|max:255',
            'birthdate'     => 'max:255',
            'gender'        => 'max:255',
            'address'       => 'max:510',
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
                Notify::success('Profile updated.', 'Success!');

                return back();
            }

            Notify::warning('Cannot update your profile', 'Ooops?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Ooops!');
        }

        return back();
    }

    public function password()
    {
        $superuser = auth()->user();

        return view('root.account.password', compact('superuser'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'  => 'required|string|min:6',
            'password'      => 'required|string|confirmed|min:6|pwned:100'
        ]);

        $superuser = auth()->user();

        try {
            if (Hash::check($request->input('old_password'), $superuser->password)) {
                $superuser->password = bcrypt($request->input('password'));
                if ($superuser->save()) {
                    Notify::success('Password updated.', 'Success!');
                }

                return back();
            }

            Notify::warning('Cannot update password.',  'Whooops!?');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Whooops!');
        }

        return back();
    }
}
