<?php

namespace App\Http\Controllers;

class SellerIndexController extends Controller
{

    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('seller');
    }

    // Alkalmazottak főoldal
    public function index()
    {
        return view('seller.index');
    }

    // Értesítések oldal
    public function notification() {

        // Felhasználóhoz rendelt értesítések lekérdezése és megjelenítése
        return view('seller.notification', [
            'notifications' => auth()->user()->notifications
        ]);
    }

    // Értesítés bejelölése, hogy látta
    public function notification_read() {

    }

    // Összes értesítés bejelölése, hogy látta
    public function notification_readall() {
        
    }
    
}