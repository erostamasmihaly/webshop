<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Http\Services\FavouriteUpdate;
use App\Models\Favourite;
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
    public function cart() {

        // Oldal meghívása
        return view('buyer.cart',[
            'carts' => get_cart()['carts'],
            'total_ft' => get_cart()['total_ft']
        ]);
    }

    // Termék felvitele a kosárba
    public function cart_add(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Kosár módosítása
    public function cart_change(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK'] = 1;
        $array['total'] = numformat_with_unit(get_cart()['total'],'Ft');
        return Response::json($array);
    }

    // Felhasználó adatai
    public function user() {

        // Felhasználó adatainak lekérdezése
        $user = User::where('id', Auth::id())->first();

        // Kedvencek lekérdezése
        $favs = Favourite::where('user_id', Auth::id())->join('products','favourites.product_id','products.id')->get(['products.id','products.name']);

        // Kedvencek esetén a bruttó és kedvezményes ár lekérdezése
        foreach ($favs AS $fav) {
            $fav->discount = product_prices($fav->id)["discount_ft"];
        }

        // Oldal meghívása
        return view('buyer.user', [
            'user' => $user,
            'favs' => $favs
        ]);

    }

    // Felhasználó adatainak mentése
    public function user_update(BuyerUserUpdate $buyerUserUpdate) {
        
        // Válasz küldése
        return redirect()->route('buyer_user')->withMessage('Sikeres művelet!');

    }

    // Kedvelés módosítása
    public function favourite_change(FavouriteUpdate $favouriteUpdate) {
        
        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }
}
