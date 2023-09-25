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
use App\Models\Rating;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\FavouriteShop;
use App\Notifications\RatingShop;
use App\Notifications\UnfavouriteShop;
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
            $this->favourite_notification($favouriteUpdate->favourite_id);
        } else {
            $this->unfavourite_notification($favouriteUpdate->product_id, Auth::id());
        }
        
        // Válasz küldése
        $array['total'] = Favourite::where('product_id', $favouriteUpdate->product_id)->count();
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értékelés módosítása
    public function rating_change(RatingUpdate $ratingUpdate) {

        // Értesítés küldése
        $this->rating_notification($ratingUpdate->id);
        
        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értesítések kiküldése - Kedvelés
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

    // Értesítések kiküldése - Kedvelés visszavonása
    public function unfavourite_notification($product_id, $user_id) {

        // Termék és felhasználó lekérdezése
        $product = Product::find($product_id);
        $user = User::find($user_id);

        // Kérés létrehozása az értesítéshez
        $notification_request = new Request();
        $notification_request->setMethod('POST');
        $notification_request->request->add([
            'shop' => $product->shop,
            'user' => $user,
            'product' => $product
        ]);

        // Üzlet e-mail címének és nevének lekérdezése
        $shop = [
            $product->shop->email => $product->shop->name
        ];

        // Értesítés beállítása
        $unfavourite_shop = new UnfavouriteShop($notification_request);

        // E-mail értesítés küldése az üzletnek
        Notification::route('mail', $shop)->notify($unfavourite_shop);

        // Üzlet összes alkalmazottjának lekérdezése
        $users = Shop::find($product->shop->id)->users();

        // Adatbázis értesítés küldése minden alkalmazottnak
        if ($users->count() > 0) {
            Notification::send($users, $unfavourite_shop);
        }

    }

    // Értesítések kiküldése - Kedvelés
    public function rating_notification($id) {

        // Értékelés lekérdezése
        $rating = Rating::find($id);

        // Üzlet e-mail címének és nevének lekérdezése
        $shop = [
            $rating->product->shop->email => $rating->product->shop->name
        ];

        // Értesítés beállítása
        $rating_shop = new RatingShop($rating);

        // E-mail értesítés küldése az üzletnek
        Notification::route('mail', $shop)->notify($rating_shop);

        // Üzlet összes alkalmazottjának lekérdezése
        $users = Shop::find($rating->product->shop->id)->users();

        // Adatbázis értesítés küldése minden alkalmazottnak
        if ($users->count() > 0) {
            Notification::send($users, $rating_shop);
        }

    }
}
