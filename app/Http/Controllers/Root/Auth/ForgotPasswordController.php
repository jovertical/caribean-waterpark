<?php

namespace App\Http\Controllers\Root\Auth;

use App\User;
use App\Notifications\PasswordResetLink;
use Helper;
use Illuminate\Support\Facades\DB;
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
        $user = User::where('email', $email)->where('type', 'superuser')->first();
        
        if ($user != null) {
            $user->notify(new PasswordResetLink($token, $user));
            $this->storeResetToken($user, $token);

            session()->flash('message', [
                'type' => 'success',
                'content' => 'Password reset link has been sent to your email.'
            ]);         

            return back();
        }

        session()->flash('message', [
            'type' => 'danger',
            'content' => 'We cannot find your account.'
        ]);    

        return back();
    }

    protected function storeResetToken(User $user, $token) 
    {
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::table('password_resets')->insert(
            ['email' => $user->email, 'token' => $token]
        );
    }
}
