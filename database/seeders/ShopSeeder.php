<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run(): void
    {

        // Felhasználók lekérdezése
        $u_array = [];
        foreach (User::get() AS $user) {
            $u_array[$user->name] = $user->id;
        }

        // Centrum
        Shop::insertOrIgnore([
            "id" => 1,
            "name" => "Centrum",
            "summary" => "Ruhák és egyéb lakásban használt eszközök áruháza",
            "address" => "Miskolc, Széchenyi István u. 111.",
            "latitude" => 48.1034,
            "longitude" => 20.7896,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $array["Centrum"] = DB::getPdo()->lastInsertId();

        // Boltos pozíció létrehozása
        Position::insertOrIgnore([
            "id" => 1,
            "shop_id" => $array["Centrum"],
            "name" => "boltos",
            "summary" => "<p>Bolton belüli szükséges feladatok ellátása</p>",
            "body" => "<p>Feladatok:</p><ul><li>Polcok feltöltése</li><li>Termékek árainak ellenőrzése</li><li>Pénztári feladatok elvégzése</li></ul>",
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $array["boltos"] = DB::getPdo()->lastInsertId();

        // Boltos hozzárendelése a Boltos pozícióhoz
        UserPosition::insertOrIgnore([
            "id" => 1,
            "user_id" => $u_array["seller"],
            "position_id" => $array["boltos"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

    }
}