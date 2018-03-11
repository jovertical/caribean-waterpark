<?php

namespace App\Http\Controllers\Front\Auth;

use Helper;
use App\Notifications\{WelcomeMessage, LoginCredential};
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('front.guest');
    }

    public function showRegisterForm()
    {
        return view('front.auth.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|string|confirmed|min:6|pwned:100'
        ]);

        $user = new User;
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->name         = Helper::createLoginCredential($request->input('email'));
        $user->email        = $request->input('email');
        $user->password     = bcrypt($request->input('password'));
        
        if ($user->save()) {
            auth()->login($user);

            $user->notify(new WelcomeMessage($user));

            session()->flash('message', [
                'type' => 'success',
                'content' => "Welcome {$user->first_name}! Thanks for registering."
            ]);

            return redirect()->route('front.home');
        }

        session()->flash('message', [
            'type' => 'warning',
            'content' => 'We cannot process your registration, Please try again.'
        ]);

        return back();
    }
}
