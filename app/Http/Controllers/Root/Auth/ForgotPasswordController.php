<?php

namespace App\Http\Controllers\Root\Auth;

use App\{User, PasswordReset};
use App\Notifications\PasswordResetLink;
use Helper;
use Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('root.guest');
    }

    public function showLinkRequestForm()
    {
        return view('root.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->input('email');
        $token = Helper::createRandomToken();

        $user = User::where('email', $email)->first();
        $user->notify(new PasswordResetLink($token));
        $this->saveResetToken($user, $token);

        session()->flash('message', [
            'type' => 'success',
            'content' => 'Password reset link has been sent to your email.'
        ]);

        return redirect()->back();
    }

    protected function saveResetToken(User $user, $token) 
    {
        PasswordReset::where('email', $user->email)->delete();

        $password_reset = new PasswordReset;
        $password_reset->email = $user->email;
        $password_reset->token = $token;
        $password_reset->save();
    }
}
