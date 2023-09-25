<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Http\Services\FavouriteUpdate;
use App\Http\Services\RatingUpdate;
use App\Models\Cart;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\FavouriteShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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

        // Értesítés küldése állapot függvényében
        if ($favouriteUpdate->state == 1) {
            $this->favourite_notification($favouriteUpdate->product_id);
        }
        
        // Válasz küldése
        $array['total'] = Favourite::where('product_id', $favouriteUpdate->product_id)->count();
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értékelés módosítása
    public function rating_change(RatingUpdate $ratingUpdate) {
        
        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értesítések kiküldése
    public function favourite_notification($id) {

        // Kedvelés lekérdezése
        $favourite = Favourite::find($id);

        // Kérés létrehozása az értesítéshez
        $notification_request = new Request();
        $notification_request->setMethod('POST');
        $notification_request->request->add([
            'shop' => $favourite->product->shop,
            'user' => $favourite->user,
            'product' => $favourite->product
        ]);

        // Üzlet e-mail címének és nevének lekérdezése
        $shop = [
            $favourite->product->shop->email => $favourite->product->shop->name
        ];

        // Értesítés beállítása
        $favourite_shop = new FavouriteShop($notification_request);

        // E-mail értesítés küldése az üzletnek
        Notification::route('mail', $shop)->notify($favourite_shop);

        // Üzlet összes alkalmazottjának lekérdezése
        $users = Shop::find($favourite->product->shop->id)->users();

        // Adatbázis értesítés küldése minden alkalmazottnak
        if ($users->count() > 0) {
            Notification::send($users, $favourite_shop);
         }

    }
}
