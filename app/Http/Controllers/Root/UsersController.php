<?php

namespace App\Http\Controllers\Root;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('type', 'user')->get()->all();

        return view('root.users.index', ['users' => $users]);
    }
}
