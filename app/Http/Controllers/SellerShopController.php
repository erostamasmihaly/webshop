<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerShopController extends Controller
{

    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Boltok listája - Csak a felhasználóhoz tartozóak!
    public function index() {

        // Felhasználóhoz tartozó boltok lekérdezése
        $shops = User::find(Auth::id())->shops();

        // Oldal meghívása
        return view('seller.shop',[
            'shops' => $shops
        ]);

    } 
    
    // Egy bolthoz tartozó kifizetett termékek listája
    public function payed_carts($shop_id) {

        // Lekérdezni a bolt minden olyan kosarát, amiért fizettek is
        $carts = Shop::find($shop_id)->payed_carts()->sortByDesc('updated_at');

        // Végigmenni minden egyes elemen
        foreach ($carts AS $cart) {

            // Formázott teljes ár
            $cart->full_price_ft = numformat_with_unit($cart->price * $cart->quantity, "Ft");
        }

        // Oldal meghívása
        return view('seller.shop_payed_carts',[
            'carts' => $carts
        ]);

    }
}
