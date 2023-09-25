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
    public function notification_read($id) {

        // Bejelölni, hogy látta az értesítést
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        // Visszatérni az előző oldalra
        return redirect()->back();
    }

    // Összes értesítés bejelölése, hogy látta
    public function notification_readall() {
        
        // Bejelölni, hogy látta az összes értesítést
        auth()->user()->unreadNotifications->markAsRead();

        // Visszatérni az előző oldalra
        return redirect()->back();
    }
    
}