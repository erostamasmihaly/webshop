<?php

namespace App\Http\Controllers;

use App\Http\Services\UserActivate;
use App\Http\Services\UserInsert;
use App\Mail\RegisterMail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BuyerIndexController extends Controller
{

    public function __construct()
    { }

    // Fő oldal
    public function index()
    {

        // Termékek lekérdezése
        $products = Product::join('shops','products.shop_id','shops.id')->join('units','products.unit_id','units.id')->where(function($query) {return $query->where('active', 1)->orWhere('quantity', '>', 0);})->get(['products.id','products.name','products.summary','products.price','products.vat','products.discount','shops.name AS shop','units.name AS unit']);

        // Bruttó és kedvezményes árak behelyezése a listába
        foreach($products AS $product) {
            $product->brutto_price = brutto_price($product->price, $product->vat);
            $product->discount_price = discount_price($product->brutto_price, $product->discount);
        }

        // Felület betöltése
        return view('buyer.index', [
            'products' => $products
        ]);
    }

    // Regisztrációs felület
    public function register() {
        return view('buyer.register');
    }

    // Regisztráció mentése
    public function register_save(UserInsert $userInsert) {

        // E-mail elküldése
        $is_success = Mail::to($userInsert->user->email)->send(new RegisterMail($userInsert->user));

        // Megnézni, hogy az e-mail küldése sikeres volt-e
        if ($is_success) {

            // Ha igen, akkor pozitív visszajelzés
            return redirect()->route('home')->withMessage('Felhasználói fiók sikeresen létrehozva. A regisztráció befejezéséhez szükség e-mail elküldve.');
        } else {

            // Na nem, akkor hiba jelzése
            return redirect()->route('home')->withErrors(['Felhasználói fiók sikeresen létrehozva. Az aktiváló e-mail elküldése viszont meghiúsult. Kérem vegye fel a kapcsolatot a kollégáinkkal.']);
        }
        
    }

    // Regisztráció aktiválása
    public function register_activate($activation_code) {

        // Fiók aktiválása
        $activate = new UserActivate($activation_code);

        // Megnézni, hogy minden rendben volt-e
        if ($activate->ok) {
            
            // Ha igen, akkor pozitív visszajelzés
            return redirect()->route('home')->withMessage('Felhasználói fiók sikeresen aktiválva.');

        } else {

            // Ha nem, akkor hiba jelzése
            return redirect()->route('home')->withErrors(['Hiba történt az aktiválás során.']);

        }
        

    }

}
