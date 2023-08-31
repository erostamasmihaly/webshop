<?php

namespace App\Http\Controllers;

use App\Http\Services\CartAdd;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BuyerProtectedController extends Controller
{
    
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Kosár tartalma
    public function index() {

        // Oldal meghívása
        return view('buyer.cart',[
            'carts' => get_cart()['carts'],
            'total' => get_cart()['total']
        ]);
    }

    // Termék felvitele a kosárba
    public function add(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Kosár módosítása
    public function change(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK'] = 1;
        $array['total'] = numformat_with_unit(get_cart()['total'],'Ft');
        return Response::json($array);
    }

    // Felhasználó adatai
    public function user() {

        // Felhasználó adatainak lekérdezése
        $user = User::where('id', Auth::id())->first();

        // Oldal meghívása
        return view('buyer.user', [
            'user' => $user
        ]);

    }
}
