<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        return view('front.accounts.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

    }

    public function settings()
    {
        $user = auth()->user();

        return view('front.accounts.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {

    }
}