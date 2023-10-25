<?php

namespace App\Http\Controllers;

use App\Http\Services\BuyerUserUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
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

    // Hozzáadás a kosár elemhez
    public function add_cart(Request $request) {

        $array['id']=$request->id;

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Elvétel a kosár elemből
    public function remove_cart(Request $request) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Kosár elem törlése
    public function delete_cart(Request $request) {

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }
}
