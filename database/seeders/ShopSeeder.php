<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run(): void
    {

        // Centrum
        DB::table("shops")->insertOrIgnore([
            "id" => 1,
            "name" => "Centrum",
            "summary" => "Ruhák és egyéb lakásban használt eszközök áruháza",
            "address" => "Miskolc, Széchenyi István u. 111.",
            "latitude" => 48.1034,
            "longitude" => 20.7896,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Boltos pozíció létrehozása
        DB::table("positions")->insertOrIgnore([
            "id" => 1,
            "shop_id" => 1,
            "name" => "boltos",
            "summary" => "<p>Bolton belüli szükséges feladatok ellátása</p>",
            "body" => "<p>Feladatok:</p><ul><li>Polcok feltöltése</li><li>Termékek árainak ellenőrzése</li><li>Pénztári feladatok elvégzése</li></ul>",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Boltos hozzárendelése a Boltos pozícióhoz
        DB::table("user_positions")->insertOrIgnore([
            "id" => 1,
            "user_id" => 3,
            "position_id" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);


        // Fekete bőrkabát hozzáadása a Centrumhoz
        DB::table("products")->insertOrIgnore([
            "id" => 1,
            "shop_id" => 1,
            "unit_id" => 1,
            "category_id" => 14,
            "name" => "Fekete bőrkabát",
            "summary" => "<p>Fekete kabát, eredeti bőrből!</p>",
            "body" => "<p>Anyag: Eredeti bőr</p><p>Szín: Fekete</p>",
            "price" => 10000,
            "vat" => 27,
            "discount" => 10,
            "active" => 1,
            "quantity" => 23,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);  
        
        // Fehér téli kabát hozzáadása a Centrumhoz
        DB::table("products")->insertOrIgnore([
            "id" => 2,
            "shop_id" => 1,
            "unit_id" => 1,
            "category_id" => 14,
            "name" => "Fehér téli kabát",
            "summary" => "<p>Fehér színű kabát, ami télen véd a lehülés ellen!</p>",
            "body" => "<p>Évszak: Tél</p><p>Szín: Fehér</p>",
            "price" => 13000,
            "vat" => 27,
            "discount" => 5,
            "active" => 1,
            "quantity" => 10,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);  

        // Futó nadrág hozzáadása a Centrumhoz
        DB::table("products")->insertOrIgnore([
            "id" => 3,
            "shop_id" => 1,
            "unit_id" => 1,
            "category_id" => 11,
            "name" => "Futó nadrág",
            "summary" => "<p>Melegebb napokra!</p>",
            "body" => "<p>Tavasztól Őszig ajánlott a használata, avagy amíg kellemes az idő!</p>",
            "price" => 8500,
            "vat" => 27,
            "discount" => 0,
            "active" => 1,
            "quantity" => 15,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]); 

    }
}