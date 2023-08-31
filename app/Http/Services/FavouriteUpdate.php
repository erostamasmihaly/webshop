<?php

namespace App\Http\Services;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavouriteUpdate
{
    private $product_id, $state;

    // Adatok lekérdezése
    public function __construct(Request $request)
    {
        $this->product_id = $request->product_id;
        $this->state = $request->state;
        $this->updateFavourite();
    }

    // Kategória frissítése
    private function updateFavourite()
    {
        DB::transaction(function () {
            if ($this->state == 1) {

                // Ha kedvelés, akkor felvinni az adatbázisba
                $favourite = new Favourite();
                $favourite->user_id = Auth::id();
                $favourite->product_id = $this->product_id;
                $favourite->save(); 
            } else {

                // Ha kedvelés visszavonása, akkor törlés az adatbázisból
                $favourite = Favourite::where('user_id', Auth::id())->where('product_id', $this->product_id)->first();
                $favourite->delete();
            }
        });
    }
}
