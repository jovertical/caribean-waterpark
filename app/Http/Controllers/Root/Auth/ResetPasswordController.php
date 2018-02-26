<?php

namespace App\Http\Controllers\Root\Auth;

use Toastr as Notify;
use App\{User, PasswordReset};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    protected $redirectTo = '/superuser';

    public function __construct()
    {
        $this->middleware('root.guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('root.auth.passwords.reset', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    public function reset(Request $request, $token)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|max:255',
            'password_confirmation' => 'required|min:6|max:255'
        ]);

        $password_reset = PasswordReset::where('token', $token)->first();

        $user = User::where('email', $password_reset->email)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        PasswordReset::where('token', $token)->delete();

        Auth::loginUsingId($user->id);

        Notify::success('Good luck for the day ahead.', 'Welcome back!');

        return redirect()->route('root.home');
    }
}
