<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\PayedSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index() {

        $carts = Payment::find(1)->carts;
        foreach ($carts AS $cart) {

            // Kérés létrehozása az értesítéshez
            $notification_request = new Request();
            $notification_request->setMethod('POST');
            $notification_request->request->add([
                'shop' => $cart->product->shop,
                'user' => $cart->user,
                'cart' => $cart
            ]);

            // Üzlet e-mail címének és nevének lekérdezése
            $shop = [
                $cart->product->shop->email => $cart->product->shop->name
            ];

            // Értesítés küldése az üzletnek
            Notification::route('mail', $shop)->notify(new PayedSeller($notification_request));

        }
    }
}
