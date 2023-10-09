<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Shop;
use App\Notifications\RatingShop;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index() {
        $favourite_users = Product::find(1)->favourite_users(); 
        dd($favourite_users);
    }
}
