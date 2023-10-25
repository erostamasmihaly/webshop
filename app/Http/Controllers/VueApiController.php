<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyerUserUpdateRequest;
use Illuminate\Http\Request;
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
        $array['user'] = Auth::user();

        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);
    }

    // Felhasználó mentése
    public function post_user(BuyerUserUpdateRequest $buyerUserUpdateRequest) {
        
        // Válasz küldése
        $array['OK']=1;
        return Response::json($array);

    }
}
