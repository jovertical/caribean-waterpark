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
            'middle_name'   => 'max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password'      => 'required|string|confirmed|min:6|pwned:100',
            'birthdate'     => 'max:255',
            'address'       => 'max:510',
            'phone_number'  => 'max:255'
        ]);

        $token = base64_encode($request->input('email'));

        $user = new User;
        $user->first_name       = $request->input('first_name');
        $user->middle_name      = $request->input('middle_name');
        $user->last_name        = $request->input('last_name');
        $user->name             = Helper::createUsername($request->input('email'));
        $user->email            = $request->input('email');
        $user->email_token      = $token;
        $user->password         = bcrypt($request->input('password'));
        $user->birthdate        = $request->input('birthdate');
        $user->gender           = $request->input('gender');
        $user->address          = $request->input('address');
        $user->phone_number     = $request->input('phone_number');

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
