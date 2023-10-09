<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerNotificationController extends Controller
{
    // Csak az alkalmazottak léphetnek be
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Értesítések oldal
    public function index() {

        // Felhasználóhoz rendelt értesítések lekérdezése és megjelenítése
        return view('buyer.notification', [
            'notifications' => auth()->user()->notifications
        ]);
    }

    // Értesítés bejelölése, hogy látta
    public function read($id) {

        // Bejelölni, hogy látta az értesítést
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        // Visszatérni az előző oldalra
        return redirect()->back();
    }

    // Összes értesítés bejelölése, hogy látta
    public function readall() {
        
        // Bejelölni, hogy látta az összes értesítést
        auth()->user()->unreadNotifications->markAsRead();

        // Visszatérni az előző oldalra
        return redirect()->back();
    }
}
