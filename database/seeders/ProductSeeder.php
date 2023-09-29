<?php

namespace Database\Seeders;

use App\Http\Services\ImageUpload;
use App\Models\Category;
use App\Models\CategoryGroup;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{

    public function run(): void
    {

        // Számlálók definiálása
        $i = 1;
        $j = 1;
        $p = 0;

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

        //// Fekete bőrkabát hozzáadása a Centrumhoz
        $p++;
        
        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Fekete bőrkabát",
            "summary" => "Fekete kabát, eredeti bőrből!",
            "body" => "<p>Anyag: Eredeti bőr</p><p>Szín: Fekete</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["kabát"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["M"], 3, 10000, 27, 10],
            [ $size_array["L"], 2, 10000, 27, 10],
            [ $size_array["XL"], 4, 12000, 27, 10]
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(1);

        //// Fehér téli kabát hozzáadása a Centrumhoz
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Fehér téli kabát",
            "summary" => "Fehér színű kabát, ami télen véd a lehülés ellen!",
            "body" => "<p>Évszak: Tél</p><p>Szín: Fehér</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);  

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["kabát"] ],
            [ $category_group_array["Nemek"], $gender_array["nő"] ],
            [ $category_group_array["Korosztályok"], $age_array["ifjú"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["S"], 7, 13000, 27, 0],
            [ $size_array["M"], 3, 13000, 27, 0],
            [ $size_array["L"], 1, 13000, 27, 0]
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(2);

        //// Futó rövid nadrág hozzáadása a Centrumhoz
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Futó rövid nadrág",
            "summary" => "Melegebb napokra!",
            "body" => "<p>Tavasztól Őszig ajánlott a használata, avagy amíg kellemes az idő!</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["rövid nadrág"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["L"], 2, 9000, 27, 0],
            [ $size_array["XL"], 4, 10000, 27, 0]
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(3);

        //// Futó hosszú nadrág hozzáadása a Centrumhoz
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Futó hosszú nadrág",
            "summary" => "Hideg napokra!",
            "body" => "<p>Ősztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["hosszú nadrág"] ],
            [ $category_group_array["Nemek"], $gender_array["nő"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["M"], 3, 20000, 27, 15],
            [ $size_array["L"], 1, 20000, 27, 15]
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(4);

        //// Edző cipő hozzáadása a Centrumhoz
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Edző cipő",
            "summary" => "Hideg napokra!",
            "body" => "<p>Ősztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["edző cipő"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["44"], 2, 20000, 27, 5],
            [ $size_array["45"], 3, 20000, 27, 5],
            [ $size_array["46"], 3, 20000, 27, 5]
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(5);

        //// Kék bakancs hozzáadása a Centrumhoz
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Centrum"],
            "name" => "Kék bakancs",
            "summary" => "Hideg napokra!",
            "body" => "<p>Ősztől Tavaszig ajánlott a használata, avagy amikor már zordabb az idő!</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["bakancs"] ],
            [ $category_group_array["Nemek"], $gender_array["nő"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["40"], 7, 15000, 27, 0],
            [ $size_array["41"], 3, 15000, 27, 0],
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(6);

        //// Futó hosszú nadrág hozzáadása a Sportsdirecthez
        $p++;

        // Termék létrehozása
        Product::insertOrIgnore([
            "id" => $p,
            "shop_id" => $shop_array["Sportsdirect"],
            "name" => "Futó hosszú nadrág",
            "summary" => "Melegebb napokra!",
            "body" => "<p>Tavaszig őszig, amikor még nincs túl meleg!</p>",
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]); 

        // Kategóriák felvitele
        $array = [
            [ $category_group_array["Mértékegységek"], $unit_array["darab"] ],
            [ $category_group_array["Termékcsoportok"], $product_group_array["hosszú nadrág"] ],
            [ $category_group_array["Nemek"], $gender_array["férfi"] ],
            [ $category_group_array["Korosztályok"], $age_array["felnőtt"] ]
        ];

        foreach ($array AS $subarray) {
            ProductCategory::insertOrIgnore([
                "id" => $i++,
                "product_id" => $p,
                "category_group_id" => $subarray[0],
                "category_id" => $subarray[1],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Méret, árak és mennyiség felvitele
        $array = [
            [ $size_array["L"], 4, 13000, 27, 10],
            [ $size_array["XL"], 2, 13000, 27, 10],
        ];

        foreach ($array AS $subarray) {
            $brutto_price = brutto_price($subarray[2], $subarray[3]);
            $discount_price = discount_price($brutto_price, $subarray[4]);
            ProductPrice::insertOrIgnore([
                "id" => $j++,
                "product_id" => $p,
                "size_id" => $subarray[0],
                "quantity" => $subarray[1],
                "price" => $subarray[2],
                "vat" => $subarray[3],
                "discount" => $subarray[4],
                "brutto_price" => $brutto_price,
                "discount_price" => $discount_price
            ]);
        }

        // Képek hozzárendelése
        $this->uploadSetupImages(7);

    }

    // Setup könyvtárba lévő képek feltöltése a megfelelő termékhez
    private function uploadSetupImages($product_id) {

        // Könyvtár megadása
        $dir = "images/setup/$product_id/";

        // Fájlok lekérdezése
        $files = File::files(public_path($dir));

        // Képek gyűjtemények
        $collection = collect();

        // Végigmenni minden egyes képen
        foreach ($files AS $file) {

            // Fájlnév meghatározása
            $filename = $file->getBasename();

            // Megnézni, hogy az adott fájl már fel van-e töltve
            if (!Image::where('product_id', $product_id)->where('filename', $filename)->first()) {

                // Visszatérés a feltöltött fájl adataival
                $uploaded_file = new UploadedFile($file, $filename);

                // Fájl behelyezése a gyűjteménybe
                $collection->push($uploaded_file);
            }
        } 

        // Ha van elmenteni való kép
        if ($collection->count()>0) {

            // Kérés létrehozása
            $request = new Request();
            $request->setMethod('POST');
            $request->request->add([
                'product_id' => $product_id,
                'images' => $collection
            ]);

            // Kérés végrehajtása a kép feltöltővel
            new ImageUpload($request);
        }

    }
}
