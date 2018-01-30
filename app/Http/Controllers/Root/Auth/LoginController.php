<?php

namespace App\Http\Controllers\Root\Auth;

use Toastr as Notify;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $redirectTo = '/superuser';

    public function __construct()
    {
        $this->middleware('superuser.guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('root.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // login attempt
        if ($this->attempt($request)) {
            // if login attempt is successful
            $request->session()->regenerate();

            $this->authenticated($request, Auth::user());

            return redirect()->intended($this->redirectTo);
        }

        // if login attempt failed
        $this->sendFailedLoginResponse($request);

        return redirect()->route('superuser.login');
    }

    protected function attempt(Request $request)
    {
        $username = filter_var($request->input('name'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return  Auth::guard()->attempt([
                    $username   => $request->input('name'),
                    'password'  => $request->input('password'),
                    'verified'  => true,
                    'active'    => true,
                    'type'      => 'superuser'
                ], $request->filled('remember'));
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username()   => 'required|string|min:6|max:255',
            'password'          => 'required|string|min:6|max:255',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function username()
    {
        return 'name';
    }

    protected function authenticated(Request $request, $user)
    {
        Notify::success('Good luck for the day ahead.', 'Welcome back!');
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('superuser.login');
    }
}
