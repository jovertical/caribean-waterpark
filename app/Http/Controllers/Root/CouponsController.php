<?php

namespace App\Http\Controllers\Root;

use App\Notifications\{ResourceCreated, ResourceUpdated, ResourceDeleted};
use App\{Coupon, User};
use ImageUploader;
use File, URL;
use Carbon, Image, Notify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    protected $superusers;

    public function __construct()
    {
        $this->superusers = User::where('type', 'superuser')->get();
    }

    public function index()
    {
        $coupon = Coupon::all();

        return view('root.coupons.index', ['coupons' => $coupon]);
    }

    
}
