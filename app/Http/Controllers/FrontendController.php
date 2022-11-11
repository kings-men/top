<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Models\Coupon;

use App\Http\Resources\API\CategoryResource;
use App\Http\Resources\API\ServiceResource;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\ServiceDetailResource;
use App\Http\Resources\API\BookingRatingResource;
use App\Http\Resources\API\CouponResource;

class FrontendController extends Controller
{
    public function index(){
        $locale = app()->getLocale();
        return view('auth.login',compact('locale'));
    }
}
