<?php

namespace App\Http\Controllers\Front\Auth;

use Helper;
use App\Jobs\SendVerificationEmail;
use App\Notifications\{WelcomeMessage, EmailVerification, LoginCredential};
use App\User;
use Illuminate\Auth\Events\Registered;
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
        $token = base64_encode($request->input('email'));

        $user = new User;
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->name         = Helper::createUsername($request->input('email'));
        $user->email        = $request->input('email');
        $user->password     = bcrypt($request->input('password'));
        $user->email_token  = $token;

        if ($user->save()) {
            $user->notify(new WelcomeMessage($user));

            event(new Registered($user));

            dispatch(new SendVerificationEmail($user, $token));

            // Prompt user for email verification.
            session()->flash('message', [
                'type' => 'success',
                'content' => 'Your account has been created, check your email for verification.'
            ]);

            return back();
        }

        session()->flash('message', [
            'type' => 'warning',
            'content' => 'We cannot process your registration, Please try again.'
        ]);

        return back();
    }

    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();
        $user->verified = 1;

        if ($user->save()) {
            auth()->login($user);

            session()->flash('message', [
                'type' => 'success',
                'content' => 'Account has been successfuly verified! What are you waiting for?
                                <a href="'.route('front.reservation.search').'">Search for accomodations</a>'
            ]);

            return redirect()->route('front.home');
        }
    }
}
