<?php

namespace App\Http\Controllers;

use App\Http\Services\UserInsert;
use App\Models\Product;
use Illuminate\Http\Request;

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
        
        // Visszatérés a főoldalra
        return redirect()->route('home')->withMessage('Felhasználói fiók sikeresen létrehozva. A regisztráció befejezéséhez szükség e-mail elküldve.');
    }

}
