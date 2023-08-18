<?php

namespace App\Http\Services;

use App\Models\UserShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserShopUpdate
{

    public $shop_id;

    private $user_id, $new_position_id, $prev_position_id;

    // Adatok lekérdezése
    public function __construct(Request $request)
    {
        $this->user_id = $request->user_id;
        $this->prev_position_id = $request->prev_position_id;
        $this->new_position_id = $request->new_position_id;
        $this->shop_id = $request->shop_id;
        $this->user_update();
    }

    // Alkalmazott módosítása
    private function user_update()
    {
        DB::transaction(function () {

            // Ellenőrizni, hogy ilyen alkalmazott-munkakör páros létezik-e
            

            // Megnézni, hogy létrehozásról vagy módosításról van szó
            if ($this->prev_position_id == 0) {

                //// Ha még nem volt előző munkakör megadva: Felvinni újként
                $user_shop = new UserShop();
                $user_shop->user_id = $this->user_id;
                $user_shop->position_id = $this->new_position_id;
                $user_shop->save();
            } else {

                //// Ha már volt előző munkakör megadva: Módosítás


            }
        });
    }
}