<?php

namespace App\Http\Controllers\Front\Auth;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    protected $redirectTo = '/user';

    public function __construct()
    {
        $this->middleware('front.guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('front.auth.passwords.reset', [
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

        $password_reset = DB::table('password_resets')->where('token', $token)->first();

        $user = User::where('email', $password_reset->email)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        DB::table('password_resets')->where('token', $token)->delete();

        Auth::loginUsingId($user->id);

        return redirect()->route('front.home');
    }
}
