<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        // Fekete bőrkabát hozzáadása a Centrumhoz
        Product::insertOrIgnore([
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
            "created_at" => now(),
            "updated_at" => now()
        ]);  
        
        // Fehér téli kabát hozzáadása a Centrumhoz
        Product::insertOrIgnore([
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
            "created_at" => now(),
            "updated_at" => now()
        ]);  

        // Futó nadrág hozzáadása a Centrumhoz
        Product::insertOrIgnore([
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
            "created_at" => now(),
            "updated_at" => now()
        ]); 
    }
}
