<?php

namespace App\Http\Services;

use App\Http\Requests\CartAddRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartAdd
{

    // Privát adatok
    private $product_id, $quantity, $size_id;

    // Adatok lekérdezése
    public function __construct(CartAddRequest $cartAddRequest)
    {
        $this->product_id = $cartAddRequest->product_id;
        $this->quantity = $cartAddRequest->quantity;
        $this->size_id = $cartAddRequest->size_id;
        $this->addToCart();
    }

    // Adatok felvitele
    private function addToCart() {

        DB::transaction(function () {

            // Megnézni, hogy már ezen termék benne van-e a kosárban
            $cart = Cart::where("user_id", Auth::id())->where("product_id", $this->product_id)->where("size_id",$this->size_id)->whereNull("payment_id")->first();

            if (!$cart) {

                // Ha nincsen, akkor felvinni újként
                $cart = new Cart();
                $cart->user_id = Auth::id();
                $cart->product_id = $this->product_id;
                $cart->quantity = $this->quantity;
                $cart->size_id = $this->size_id;
                $cart->save();
            
            } else {

                // Ha igen, akkor csak a mennyiséget növelni
                $cart->quantity += $this->quantity;

                // Ha az új mennyiség 0, akkor törölni, különben menteni
                if ($cart->quantity == 0) {
                    $cart->delete();
                } else {
                    $cart->save();
                }

            }
        });
    }

}