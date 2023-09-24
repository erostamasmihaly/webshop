<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserPosition;
use App\Notifications\PaymentShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function index() {

        $return = Product::find(1)->group;
        dd($return);

        // Fizetéshez tartozó kosár bejegyzések lekérdezése
        /*$carts = Payment::find(1)->carts;

        // Végigmenni minden ilyen bejegyzésen
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
            Notification::route('mail', $shop)->notify(new PaymentShop($notification_request));

        }*/
    }
}
