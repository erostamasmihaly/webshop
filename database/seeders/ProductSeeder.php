<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {

        // Számláló definiálása
        $i = 1;

        // Boltok lekérdezése
        $s_array = [];
        foreach (Shop::get() AS $shop) {
            $s_array[$shop->name] = $shop->id;
        }

        // Kategória csoportok lekérdezése
        $cg_array = [];
        foreach (CategoryGroup::get() AS $category_group) {
            $cg_array[$category_group->name] = $category_group->id;
        }
        
        // Termékcsoportok lekérdezése
        $c_array = [];
        foreach (Category::where('category_group_id',$cg_array["Termékcsoportok"])->get() AS $category) {
            $c_array[$category->name] = $category->id;
        }

        // Mértékegységek lekérdezése
        $u_array = [];
        foreach (Category::where('category_group_id',$cg_array["Mértékegységek"])->get() AS $category) {
            $u_array[$category->name] = $category->id;
        }       

        // Fekete bőrkabát hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => $i++,
            "shop_id" => $s_array["Centrum"],
            "unit_id" => $u_array["darab"],
            "category_id" => $c_array["kabát"],
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
            "id" => $i++,
            "shop_id" => $s_array["Centrum"],
            "unit_id" => $u_array["darab"],
            "category_id" => $c_array["kabát"],
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

        // Futó rövid nadrág hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => $i++,
            "shop_id" => $s_array["Centrum"],
            "unit_id" => $u_array["darab"],
            "category_id" => $c_array["rövid nadrág"],
            "name" => "Futó rövid nadrág",
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

        // Futó hosszú nadrág hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => $i++,
            "shop_id" => $s_array["Centrum"],
            "unit_id" => $u_array["darab"],
            "category_id" => $c_array["hosszú nadrág"],
            "name" => "Futó hosszú nadrág",
            "summary" => "<p>Hideg napokra!</p>",
            "body" => "<p>ŐSztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "price" => 11000,
            "vat" => 27,
            "discount" => 10,
            "active" => 1,
            "quantity" => 10,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Téli bakancs hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => $i++,
            "shop_id" => $s_array["Centrum"],
            "unit_id" => $u_array["darab"],
            "category_id" => $c_array["bakancs"],
            "name" => "Téli bakancs",
            "summary" => "<p>Hideg napokra!</p>",
            "body" => "<p>ŐSztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "price" => 21000,
            "vat" => 27,
            "discount" => 15,
            "active" => 1,
            "quantity" => 16,
            "created_at" => now(),
            "updated_at" => now()
        ]); 
    }
}
