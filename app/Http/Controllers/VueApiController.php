<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Http\Services\RatingUpdate;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class VueApiController extends Controller
{
    // Csak a vásárlók férhetnek hozzá az itteni tartalmakhoz
    public function __construct()
    {
        $this->middleware('buyer');
    }

    // Felhasználó adatai
    public function get_user() {

        // Felhasználó adatainak lekérdezése
        $array = Auth::user();

        // Válasz küldése
        return Response::json($array);
    }

    // Felhasználó mentése
    public function post_user(BuyerUserUpdate $buyerUserUpdate) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);

    }

    // Eddigi vásárlások
    public function get_payed() {

        // Felhasználó adatainak lekérdezése
        $array = get_pay_history();

        // Válasz küldése
        return Response::json($array);
    }

    // Kosár tartalma
    public function get_cart() {

        // Felhasználó adatainak lekérdezése
        $array = get_cart();

        // Válasz küldése
        return Response::json($array);
    }

    // Kosár elem módosítása
    public function post_cart(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Termék adatainak lekérdezése
    public function get_product($id) {

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
        foreach ($product->prices AS $price) {
            $prices[$price->size->name]["quantity"] = $price->quantity; 
        }

        // Végigmenni minden egyes áron
        foreach ($product->sizes_prices() AS $key => $price) {
            $prices[$key]["discount_ft"] = $price["discount_ft"];
        }
        $obj->prices = $prices;

        // Képek lekérdezése
        $images = [];
        $i = 0;
        foreach ($product->images AS $image) {
            $images[$i]["thumb"] = asset("/images/products/".$id."/thumb/".$image->filename);
            $images[$i]["image"] = asset("/images/products/".$id."/".$image->filename);
            $i++;
        }
        $obj->images = $images;
        
        // Válasz küldése
        return Response::json($obj);
    }

    // Értékelés lekérdezése
    public function get_rating($id) {
        
        // Termék értékelésének lekérdezése
        $array = Product::find($id)->ratingsModerated;

        // Válasz küldése
        return Response::json($array);
    }

    // Értékelés felvitele
    public function put_rating(RatingUpdate $ratingUpdate) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Termékek listájának lekérdezése
    public function get_list() {

        // Termék értékelésének lekérdezése
        $array = get_products(null, false);

        // Válasz küldése
        return Response::json($array);
    } 
}
