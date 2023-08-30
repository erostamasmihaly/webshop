<?php

namespace App\Http\Services;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartAdd
{

    // Privát adatok
    private $product_id, $quantity;

    // Adatok lekérdezése
    public function __construct(Request $request)
    {
        $this->product_id = $request->product_id;
        $this->quantity = $request->quantity;
        $this->addToCart();
    }

    // Adatok felvitele
    private function addToCart() {

        DB::transaction(function () {

            // Megnézni, hogy már ezen termék benne van-e a kosásrban
            $cart = Cart::where("user_id", Auth::id())->where("product_id", $this->product_id)->whereNull("payment_id")->first();

            if (!$cart) {

                // Ha nincsen, akkor felvinni újként
                $cart = new Cart();
                $cart->user_id = Auth::id();
                $cart->product_id = $this->product_id;
                $cart->quantity = $this->quantity;
                $cart->save();
            
            } else {

                // Ha igen, akkor csak a mennyiséget növelni
                $cart->quantity += $this->quantity;
                $cart->save();
            }
        });
    }

}