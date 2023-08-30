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
        $carts = Cart::join('products','carts.product_id','products.id')->where('user_id', Auth::id())->whereNull('payment_id')->get('products.id','products.name','carts.quantity');

        // Oldal meghívása
        return view('buyer.cart',[
            'carts' => $carts
        ]);
    }

    // Termék felvitele a kosárba
    public function add(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }
}
