<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    // Muestra el formulario de creación de cupones
    public function create()
    {
        return view('auth.coupon');
    }
}
