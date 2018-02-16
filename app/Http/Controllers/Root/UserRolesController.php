<?php

namespace App\Http\Controllers\Root;

use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRolesController extends Controller
{
    public function index()
    {
        return 'user roles';
    }
}