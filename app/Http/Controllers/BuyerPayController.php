<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerPayController extends Controller
{
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Megerősítés oldal megjelenítése
    public function confirm() {

        // Oldal meghívása
        return view('buyer.pay_confirm',[
            'carts' => get_cart()['carts'],
            'total_ft' => get_cart()['total_ft']
        ]);

    } 
}
