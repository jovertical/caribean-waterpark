<?php

namespace App\Http\Controllers\Root\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    protected $redirectTo = '/su';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('root.auth.login');
    }
}
