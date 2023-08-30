<?php

namespace App\Http\Controllers;

use App\Http\Services\CartAdd;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BuyerCartController extends Controller
{
    
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Kosár tartalma
    public function index() {

        // Kosár lekérdezése
        $carts = Cart::join('products','carts.product_id','products.id')->join('units','products.unit_id','units.id')->where('user_id', Auth::id())->whereNull('payment_id')->get(['products.id','products.name','carts.quantity','units.name AS unit','products.price']);

        // Fizetendő összeg meghatározása
        $total = 0;

        // További árak meghatározása
        foreach($carts AS $cart) {
            $cart->brutto_price = brutto_price($cart->price, $cart->vat);
            $cart->discount_price = discount_price($cart->brutto_price, $cart->discount);
            $total += $cart->discount_price * $cart->quantity;
        }

        // Oldal meghívása
        return view('buyer.cart',[
            'carts' => $carts,
            'total' => $total
        ]);
    }

    // Termék felvitele a kosárba
    public function add(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }
}
