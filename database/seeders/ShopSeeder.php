<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run(): void
    {

        // Aktuális idő lekérdezése
        $now = date("Y-m-d H:i:s", time());

        // Centrum
        DB::table("shops")->insertOrIgnore([
            "id" => 1,
            "name" => "Centrum",
            "summary" => "Ruhák és egyéb lakásban használt eszközök áruháza",
            "address" => "Miskolc, Széchenyi István u. 111.",
            "latitude" => 48.1034,
            "longitude" => 20.7896,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Boltos pozíció létrehozása
        DB::table("positions")->insertOrIgnore([
            "id" => 1,
            "shop_id" => 1,
            "name" => "boltos",
            "summary" => "<p>Bolton belüli szükséges feladatok ellátása</p>",
            "body" => "<p>Feladatok:</p><ul><li>Polcok feltöltése</li><li>Termékek árainak ellenőrzése</li><li>Pénztári feladatok elvégzése</li></ul>",
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Boltos hozzárendelése a Boltos pozícióhoz
        DB::table("user_positions")->insertOrIgnore([
            "id" => 1,
            "user_id" => 3,
            "position_id" => 1,
            "created_at" => $now,
            "updated_at" => $now
        ]);

    }
}