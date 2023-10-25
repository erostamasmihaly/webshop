<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Http\Services\CartAdd;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\Cast\Object_;

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
        $array['user'] = Auth::user();

        // Válasz küldése
        $array['OK']=1;
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
        $array['payed'] = get_pay_history();

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Kosár tartalma
    public function get_cart() {

        // Felhasználó adatainak lekérdezése
        $array['cart'] = get_cart();

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Kosár elem módosítása
    public function change_cart(CartAdd $cartAdd) {

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

        // Termékhez tartozó méretek és azok árainak lekérdezése
        $product->sizes_array();

        // Végigmenni minden egyes méreten
        foreach($product->prices AS $price) {
            dd($price);
        }

        // Termék adatainak behelyezése a tömbbe
        $array['product'] = $obj;
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

}
