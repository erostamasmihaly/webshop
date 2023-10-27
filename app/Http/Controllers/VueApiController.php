<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Http\Services\RatingUpdate;
use App\Models\Cart;
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
            $prices[$price->size->name]["id"] = $price->size->id;
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

        // Elküldeni, hogy a felhasználó vihet-e fel értékelést
        $obj->is_buyed = (Cart::where('user_id', Auth::id())->where('product_id', $id)->whereNotNull('payment_id')->count() == 0) ? false : true;
        
        // Válasz küldése
        return Response::json($obj);
    }

    // Értékelés lekérdezése
    public function get_rating($id) {

        // Értékeléssel kapcsolatos tömb lekérdezése
        $ratings_array = get_ratings($id);
        $i = 0;
        if (count($ratings_array["ratings"])>0) {
            foreach ($ratings_array["ratings"] AS $rating) {
                $array["items"][$i]["title"] = $rating["title"];
                $array["items"][$i]["body"] = $rating["body"];
                $array["items"][$i]["stars"] = $rating["stars"];
                $array["items"][$i]["moderated"] = $rating["moderated"];
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

    // Kosár elem felvitele
    public function put_cart(CartAdd $cartAdd) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }
}
