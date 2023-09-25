<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Shop;
use App\Notifications\RatingShop;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index() {

        // Értesítés beállítása
        $rating = Rating::find(1);
        $rating_shop = new RatingShop($rating);
        $shop = [
            $rating->product->shop->email => $rating->product->shop->name
        ];

        // E-mail értesítés küldése az üzletnek
        Notification::route('mail', $shop)->notify($rating_shop);
    }
}
