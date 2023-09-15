<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        // Számláló definiálása
        $id = 1;

        // Tömbök definiálása
        $cg_array = []; // Kategória csoport
        $c_array = []; // Kategóriák

        // Csoport ID-k lekérdezése
        foreach (CategoryGroup::get() AS $category_group) {
            $cg_array[$category_group->name] = $category_group->id;
        }

        // Mértékegységek
        $array = ["darab","liter","kilogramm","méter"];
        for ($i = 0; $i < count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Mértékegységek"],
                "sequence" => $i + 1,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Értékelések
        $array = ["borzalmas","rossz","átlagos","jó","kíváló"];
        for ($i = 0; $i < count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Értékelések"],
                "sequence" => $i + 1,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Nemek
        $array = ["unisex","férfi","nő"];
        for ($i = 0; $i < count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Nemek"],
                "sequence" => $i + 1,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Korosztályok
        $array = ["bébi","gyerek","tinédzser","ifjú","felnőtt","öreg"];
        for ($i = 0; $i < count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Korosztályok"],
                "sequence" => $i + 1,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        //// Termék kategóriák
        $sequence = 1;

        // Ruha
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "ruha",
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $c_array["ruha"] = DB::getPdo()->lastInsertId();

        // Nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "nadrág",
            "category_id" => $c_array["ruha"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $c_array["nadrág"] = DB::getPdo()->lastInsertId();

        // Rövid nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "rövid nadrág",
            "category_id" => $c_array["nadrág"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Hosszú nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "hosszú nadrág",
            "category_id" => $c_array["nadrág"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Felső
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "felső",
            "category_id" => $c_array["ruha"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $c_array["felső"] = DB::getPdo()->lastInsertId();

        // Pulóver
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "pulóver",
            "category_id" => $c_array["felső"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Kabát
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "kabát",
            "category_id" => $c_array["felső"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Cipő
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "cipő",
            "category_id" => null,
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $c_array["cipő"] = DB::getPdo()->lastInsertId();

        // Edző cipő
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "edző cipő",
            "category_id" => $c_array["cipő"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Bakancs
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "bakancs",
            "category_id" => $c_array["cipő"],
            "category_group_id" => $cg_array["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        //// Méretek
        // Ruha méretek
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "ruha méretek",
            "category_id" => null,
            "category_group_id" => $cg_array["Méretek"],
            "sequence" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $c_array["ruha méretek"] = DB::getPdo()->lastInsertId();

        // Ruha méretek felvitele
        $array = ["XS","S","M","L","XL","2XL","3XL","4XL"];
        for ($i=0; $i<count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_id" => $c_array["ruha méretek"],
                "category_group_id" => $cg_array["Méretek"],
                "sequence" => $i+2,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

    }
}