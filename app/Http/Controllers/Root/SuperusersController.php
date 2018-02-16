<?php

namespace App\Http\Controllers\Root;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperusersController extends Controller
{
    public function index()
    {
        $superusers = User::where('type', 'superuser')->get()->all();

        return view('root.superusers.index', ['superusers' => $superusers]);
    }
}

