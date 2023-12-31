<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Http\Services\FavouriteUpdate;
use App\Http\Services\RatingImageDelete;
use App\Http\Services\RatingUpdate;
use App\Models\Cart;
use App\Models\CategoryGroup;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\RatingImage;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('buyer');
    }

    // Felhasználó adatai
    public function get_user()
    {

        // Felhasználó adatainak lekérdezése
        $array = Auth::user();

        // Válasz küldése
        return Response::json($array);
    }

    // Felhasználó mentése
    public function post_user(BuyerUserUpdate $buyerUserUpdate)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);

    }

    // Eddigi vásárlások
    public function get_payed()
    {

        // Felhasználó adatainak lekérdezése
        $array = get_pay_history();

        // Válasz küldése
        return Response::json($array);
    }

    // Kosár tartalma
    public function get_cart()
    {

        // Felhasználó adatainak lekérdezése
        $array = get_cart();

        // Válasz küldése
        return Response::json($array);
    }

    // Kosár elem módosítása
    public function post_cart(CartAdd $cartAdd)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Termék adatainak lekérdezése
    public function get_product($id)
    {

        // Objektum létrehozása
        $obj = new \stdClass();

        // Termék adatainak lekérdezése
        $product = Product::find($id);

        // Termék adatainak átadása
        $obj->name = $product->name;
        $obj->summary = $product->summary;
        $obj->body = $product->body;
        $obj->unit = $product->unit->category->name;

        // Kategóriák
        $categories[0]['key'] = "Termékcsoport";
        $categories[0]['value'] = $product->gender->category->name;
        $categories[1]['key'] = "Nem";
        $categories[1]['value'] = $product->group->category->name;
        $categories[2]['key'] = "Korosztály";
        $categories[2]['value'] = $product->age->category->name;
        $obj->categories = $categories;

        // Termékhez tartozó méretek és azok árainak lekérdezése
        $product->sizes_array();

        // Végigmenni minden egyes méreten
        $prices = [];
        foreach ($product->prices as $price) {
            $prices[$price->size->name]["quantity"] = $price->quantity;
            $prices[$price->size->name]["id"] = $price->size->id;
        }

        // Végigmenni minden egyes áron
        foreach ($product->sizes_prices() as $key => $price) {
            $prices[$key]["discount_ft"] = $price["discount_ft"];
        }
        $obj->prices = $prices;

        // Képek lekérdezése
        $images = [];
        $i = 0;
        foreach ($product->images as $image) {
            $images[$i]["thumb"] = asset("/images/products/" . $id . "/thumb/" . $image->filename);
            $images[$i]["image"] = asset("/images/products/" . $id . "/" . $image->filename);
            $i++;
        }
        $obj->images = $images;

        // Elküldeni, hogy a felhasználó vihet-e fel értékelést
        $obj->is_buyed = (Cart::where('user_id', Auth::id())->where('product_id', $id)->whereNotNull('payment_id')->count() == 0) ? false : true;

        // Válasz küldése
        return Response::json($obj);
    }

    // Értékelés lekérdezése
    public function get_rating($id)
    {

        // Értékeléssel kapcsolatos tömb lekérdezése
        $ratings_array = get_ratings($id);
        $i = 0;
        if (count($ratings_array["ratings"]) > 0) {
            foreach ($ratings_array["ratings"] as $rating) {
                $array["items"][$i]["owner"] = $rating["user_id"] == Auth::id() ? 1 : 0;
                $array["items"][$i]["id"] = $rating["id"];
                $array["items"][$i]["title"] = $rating["title"];
                $array["items"][$i]["body"] = $rating["body"];
                $array["items"][$i]["stars"] = $rating["stars"];
                $array["items"][$i]["moderated"] = $rating["moderated"];
                $array["items"][$i]["user_name"] = $rating["user_name"];
                $array["items"][$i]["key"] = Hash::make(time());
                $i++;
            }
        } else {
            $array["items"] = [];
        }

        // Adatok lekérdezése és behelyezése egy tömbbe
        $array["total"] = $ratings_array["total"][0]["total"];
        $array["stars"] = (int)$ratings_array["total"][0]["stars"];

        // Válasz küldése
        return Response::json($array);
    }

    // Értékelés fényképeinek lekérdezése
    public function get_rating_images($id)
    {

        // Értékelés fényképeinek lekérdezése
        $images = RatingImage::where('rating_id', $id)->get(['id','filename']);
        if ($images->count() > 0) {
            $i = 0;
            $array = [];
            foreach ($images as $image) {
                $array[$i]["id"] = $image->id;
                $array[$i]["thumb"] = asset('images/ratings/' . $id . '/thumb/' . $image->filename);
                $array[$i]["image"] = asset('images/ratings/' . $id . '/' . $image->filename);
                $i++;
            }
        } else {
            $array = null;
        }

        // Válasz küldése
        return Response::json($array);
    }

    // Értékelés felvitele
    public function put_rating(RatingUpdate $ratingUpdate)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értékelés felvitele
    public function post_rating(RatingUpdate $ratingUpdate)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Termékek listájának lekérdezése
    public function get_list()
    {

        // Termék értékelésének lekérdezése
        $array = get_products(null, false);

        // Válasz küldése
        return Response::json($array);
    }

    // Kosár elem felvitele
    public function put_cart(CartAdd $cartAdd)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értesítések lekérdezése
    public function get_notification()
    {

        // Aktuális felhasználó lekérdezése
        $user = Auth::user();

        // Nem olvasott értesítések lekérdezése
        $array["unread"]["items"] = $user->notifications->whereNull('read_at');
        $array["unread"]["total"] = $user->notifications->whereNull('read_at')->count();

        // Olvasott értesítések lekérdezése
        $array["read"]["items"] = $user->notifications->whereNotNull('read_at');
        $array["read"]["total"] = $user->notifications->whereNotNull('read_at')->count();

        // Összes értékelés száma
        $array["total"] = $array["unread"]["total"] + $array["read"]["total"];

        // Dátumok formázása
        foreach ($array["unread"]["items"] as $item) {
            $item->created_formatted = $item->created_at->format('Y.m.d. H:i');
        }
        foreach ($array["read"]["items"] as $item) {
            $item->created_formatted = $item->created_at->format('Y.m.d. H:i');
            $item->read_formatted = $item->read_at->format('Y.m.d. H:i');
        }

        // Válasz küldése
        return Response::json($array);

    }

    // Értesítés olvasottnak jelölése
    public function post_notification_one(Request $request)
    {

        // Azonosító lekérdezése
        $id = $request->id;

        // Bejelölni, hogy látta az értesítést
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Összes értesítés olvasottnak jelölése
    public function post_notification_all()
    {

        // Bejelölni, hogy látta az összes értesítést
        auth()->user()->unreadNotifications->markAsRead();

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Kedvelés lekérdezése
    public function get_favourite($id)
    {

        // Lekérdezni, hogy az adott terméket mennyien kedvelték
        $array["number"] = Favourite::where('product_id', $id)->count();

        // Lekérdezni, hogy a felhasználó kedvelte-e a terméket
        $array["state"] = Favourite::where('product_id', $id)->where('user_id', Auth::id())->count();

        // Válasz küldése
        return Response::json($array);
    }

    // Kedvelés módosítása
    public function post_favourite(FavouriteUpdate $favouriteUpdate)
    {

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Értékelés képének törlése
    public function delete_rating_image($id)
    {
        // Kép törlése
        new RatingImageDelete($id);

        // Válasz küldése
        $array['OK'] = 1;
        return Response::json($array);
    }

    // Kategóriák lekérdezése
    public function get_categories() {

       // Kategória csoport elemek lekérdezése
       $array["ages"] = CategoryGroup::find(get_category_group_id('Korosztályok'))->categories;
       $array["genders"] = CategoryGroup::find(get_category_group_id('Nemek'))->categories;  
       $array["sizes"] = CategoryGroup::find(get_category_group_id('Méretek'))->categories; 

       // Boltok lekérdezése
       $array["shops"] = Shop::orderBy('name')->get();

       // Válasz küldése
       return Response::json($array);
    }
}