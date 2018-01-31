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
        $this->middleware('root.guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('root.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string|min:6|max:255',
            'password'  => 'required|string|min:6|max:255',
        ]);

        // login attempt
        if ($this->attempt($request)) {
            // if login attempt is successful
            $request->session()->regenerate();

            Notify::success('Good luck for the day ahead.', 'Welcome back!');

            return redirect()->intended($this->redirectTo);
        }

        // if login attempt failed
        throw ValidationException::withMessages(['name' => [trans('auth.failed')]]);

        return redirect()->back();
    }

    protected function attempt(Request $request)
    {
        $username = filter_var($request->input('name'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return  Auth::attempt([
                    $username   => $request->input('name'),
                    'password'  => $request->input('password'),
                    'verified'  => true,
                    'active'    => true,
                    'type'      => 'superuser'
                ], $request->filled('remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        session()->flash('message', [
            'type' => 'success',
            'content' => 'You have been logged out from the system.'
        ]);

        return redirect()->route('root.login');
    }
}
