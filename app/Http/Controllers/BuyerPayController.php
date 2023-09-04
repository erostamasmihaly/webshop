<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerPayController extends Controller
{
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Megerősítés oldal megjelenítése
    public function confirm() {

        // Felhasználó adatainak lekérdezése
        $user = User::where('id', Auth::id())->first();

        // Oldal meghívása
        return view('buyer.pay_confirm',[
            'carts' => get_cart()['carts'],
            'total_ft' => get_cart()['total_ft'],
            'user' => $user
        ]);

    } 
}
