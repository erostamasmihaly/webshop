<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {

        // Számláló definiálása
        $i = 1;

        // Boltok lekérdezése
        $shop_array = [];
        foreach (Shop::get() AS $shop) {
            $shop_array[$shop->name] = $shop->id;
        }

        // Kategória csoportok lekérdezése
        $category_group_array = [];
        foreach (CategoryGroup::get() AS $category_group) {
            $category_group_array[$category_group->name] = $category_group->id;
        }

        // Mértékegységek lekérdezése
        $unit_array = [];
        foreach (Category::where('category_group_id',$category_group_array["Mértékegységek"])->get() AS $category) {
            $unit_array[$category->name] = $category->id;
        } 
        
        // Termékcsoportok lekérdezése
        $product_group_array = [];
        foreach (Category::where('category_group_id',$category_group_array["Termékcsoportok"])->get() AS $category) {
            $product_group_array[$category->name] = $category->id;
        }      

        // Méretek lekérdezése
        $size_array = [];
        foreach (Category::where('category_group_id',$category_group_array["Méretek"])->get() AS $category) {
            $size_array[$category->name] = $category->id;
        }      
        
        // Nemek lekérdezése
        $gender_array = [];
        foreach (Category::where('category_group_id',$category_group_array["Nemek"])->get() AS $category) {
            $gender_array[$category->name] = $category->id;
        }  

        // Korosztályok lekérdezése
        $age_array = [];
        foreach (Category::where('category_group_id',$category_group_array["Korosztályok"])->get() AS $category) {
            $age_array[$category->name] = $category->id;
        }  

        // Fekete bőrkabát hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => 1,
            "shop_id" => $shop_array["Centrum"],
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

        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["kabát"] ],
            [ $category_group_array["Méretek"], $size_array["L"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => 1,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Fehér téli kabát hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => 2,
            "shop_id" => $shop_array["Centrum"],
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

        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["kabát"] ],
            [ $category_group_array["Méretek"], $size_array["M"] ],
            [ $category_group_array["Nemek"], $gender_array["nő"] ],
            [ $category_group_array["Korosztályok"], $age_array["ifjú"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => 2,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Futó rövid nadrág hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => 3,
            "shop_id" => $shop_array["Centrum"],
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

        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["rövid nadrág"] ],
            [ $category_group_array["Méretek"], $size_array["L"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => 3,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Futó hosszú nadrág hozzáadása a Centrumhoz
        Product::insertOrIgnore([
            "id" => 4,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Futó hosszú nadrág",
            "summary" => "<p>Hideg napokra!</p>",
            "body" => "<p>Ősztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "price" => 11000,
            "vat" => 27,
            "discount" => 10,
            "active" => 1,
            "quantity" => 10,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["hosszú nadrág"] ],
            [ $category_group_array["Méretek"], $size_array["XL"] ],
            [ $category_group_array["Nemek"], $gender_array["nő"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => 4,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
