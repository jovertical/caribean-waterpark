<?php

namespace App\Http\Controllers\Root;

use App\{User};
use ImageUploader;
use Storage, File, Str, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperusersController extends Controller
{
    public function index()
    {
        $superusers = User::where('type', 'superuser')->get()->all();

        return view('root.superusers.index', ['superusers' => $superusers]);
    }

    public function create()
    {
        return view('root.superusers.create');
    }
}

