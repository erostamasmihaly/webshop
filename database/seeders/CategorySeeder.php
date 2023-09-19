<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        // Számláló definiálása
        $id = 1;

        // Tömbök definiálása
        $category_groups = []; // Kategória csoport
        $categories = []; // Kategóriák

        // Csoport ID-k lekérdezése
        foreach (CategoryGroup::get() AS $category_group) {
            $category_groups[$category_group->name] = $category_group->id;
        }

        // Mértékegységek
        $array = ["darab","liter","kilogramm","méter"];
        for ($i = 0; $i < count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $category_groups["Mértékegységek"],
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
                "category_group_id" => $category_groups["Értékelések"],
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
                "category_group_id" => $category_groups["Nemek"],
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
                "category_group_id" => $category_groups["Korosztályok"],
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
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["ruha"] = Category::where('name','ruha')->first()->id;

        // Nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "nadrág",
            "category_id" => $categories["ruha"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["nadrág"] = Category::where('name','nadrág')->first()->id;

        // Rövid nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "rövid nadrág",
            "category_id" => $categories["nadrág"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Hosszú nadrág
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "hosszú nadrág",
            "category_id" => $categories["nadrág"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Felső
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "felső",
            "category_id" => $categories["ruha"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["felső"] = Category::where('name','felső')->first()->id;

        // Pulóver
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "pulóver",
            "category_id" => $categories["felső"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Kabát
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "kabát",
            "category_id" => $categories["felső"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Cipő
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "cipő",
            "category_id" => null,
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["cipő"] = Category::where('name','cipő')->first()->id;

        // Edző cipő
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "edző cipő",
            "category_id" => $categories["cipő"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Bakancs
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "bakancs",
            "category_id" => $categories["cipő"],
            "category_group_id" => $category_groups["Termékcsoportok"],
            "sequence" => $sequence++,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        //// Méretek
        $size = 1;

        // Ruha méretek
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "ruha méretek",
            "category_id" => null,
            "category_group_id" => $category_groups["Méretek"],
            "sequence" => $size++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["ruha méretek"] = Category::where('name','ruha méretek')->first()->id;

        // Ruha méretek felvitele
        $array = ["XS","S","M","L","XL","2XL","3XL","4XL"];
        for ($i=0; $i<count($array); $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_id" => $categories["ruha méretek"],
                "category_group_id" => $category_groups["Méretek"],
                "sequence" => $size++,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Cipő méretek
        Category::insertOrIgnore([
            "id" => $id++,
            "name" => "cipő méretek",
            "category_id" => null,
            "category_group_id" => $category_groups["Méretek"],
            "sequence" => $size++,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $categories["cipő méretek"] = Category::where('name','cipő méretek')->first()->id;

        // Cipő méretek felvitele
        for ($i=30; $i<=51; $i++) {
            Category::insertOrIgnore([
                "id" => $id++,
                "name" => $i,
                "category_id" => $categories["cipő méretek"],
                "category_group_id" => $category_groups["Méretek"],
                "sequence" => $size++,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

    }
}