<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {

        // Felhasználók lekérdezése
        $users = [];
        foreach (User::get() AS $user) {
            $users[$user->name] = $user->id;
        }

        // Centrum
        Shop::insertOrIgnore([
            "id" => 1,
            "name" => "Centrum",
            "summary" => "Ruhák és egyéb lakásban használt eszközök áruháza",
            "address" => "Miskolc, Széchenyi István u. 111.",
            "latitude" => 48.1034,
            "longitude" => 20.7896,
            "email" => config("app.test_shop_email_1"), // Mivel az .env-ből közvetlenül nem tud kiolvasni, csak a config-on keresztük közvetetten!
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $shops["Centrum"] = 1;

        // Boltos pozíció létrehozása
        Position::insertOrIgnore([
            "id" => 1,
            "shop_id" => $shops["Centrum"],
            "name" => "boltos",
            "summary" => "<p>Bolton belüli szükséges feladatok ellátása</p>",
            "body" => "<p>Feladatok:</p><ul><li>Polcok feltöltése</li><li>Termékek árainak ellenőrzése</li><li>Pénztári feladatok elvégzése</li></ul>",
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $positions["boltos"] = 1;

        // Boltos hozzárendelése a Boltos pozícióhoz
        UserPosition::insertOrIgnore([
            "id" => 1,
            "user_id" => $users["boltos"],
            "position_id" => $positions["boltos"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Sportsdirect
        Shop::insertOrIgnore([
            "id" => 2,
            "name" => "Sportsdirect",
            "summary" => "Ruhák és egyéb lakásban használt eszközök áruháza",
            "address" => "Miskolc, Szentpéteri kapu 103.",
            "latitude" => 48.1271,
            "longitude" => 20.7825,
            "email" => config("app.test_shop_email_1"),
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $shops["Sportsdirect"] = 2;

    }
}