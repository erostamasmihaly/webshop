<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rating;
use App\Models\Shop;
use App\Notifications\RatingShop;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index() {
        $cart = Cart::find(3); 
        //cart_quantity_split($cart);
        cart_quantity_join($cart);
    }
}
