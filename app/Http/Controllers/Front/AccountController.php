<?php

namespace App\Http\Controllers\Front;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('front.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

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
                session()->flash('message', [
                    'type' => 'success',
                    'content' => 'Profile updated.'
                ]);

                return back();
            }

            session()->flash('message', [
                'type' => 'warning',
                'content' => 'Cannot update your profile'
            ]);
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'content' => $e->getMessage(), 'Ooops!'
            ]);
        }

        return back();
    }

    public function password()
    {
        $user = auth()->user();

        return view('front.account.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'  => 'required|string|min:6',
            'password'      => 'required|string|confirmed|min:6|pwned:100'
        ]);

        $user = auth()->user();

        try {
            if (Hash::check($request->input('old_password'), $user->password)) {
                $user->password = bcrypt($request->input('password'));
                if ($user->save()) {
                    session()->flash('message', [
                        'type' => 'success',
                        'content' => 'Password updated.'
                    ]);
                }

                auth()->logout($user);

                return redirect()->route('front.login');
            }

            session()->flash('message', [
                'type' => 'success',
                'content' => 'Cannot update password. Please double check your existing password.'
            ]);
        } catch (Exception $e) {
            session()->flash('message', [
                'type' => 'success',
                'content' => $e->getMessage()
            ]);
        }

        return back();
    }
}