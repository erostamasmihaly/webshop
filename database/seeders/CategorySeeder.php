<?php

namespace Database\Seeders;

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
        $category_groups = CategoryGroup::get();
        foreach ($category_groups AS $category_group) {
            $cg_array[$category_group->name] = $category_group->id;
        }

        // Mértékegységek
        $array = ["darab","liter","kilogramm","méter"];
        for ($i = 0; $i < count($array); $i++) {
            DB::table("categories")->insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Mértékegységek"],
                "sequence" => $i + 1,
                "created_at" => get_now(),
                "updated_at" => get_now()
            ]);
        }

        // Értékelések
        $array = ["borzalmas","rossz","átlagos","jó","kíváló"];
        for ($i = 0; $i < count($array); $i++) {
            DB::table("categories")->insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_group_id" => $cg_array["Értékelések"],
                "sequence" => $i + 1,
                "created_at" => get_now(),
                "updated_at" => get_now()
            ]);
        }

        //// Termék kategóriák
        $sequence = 1;

        // Ruha
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "ruha",
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);
        $c_array["ruha"] = DB::getPdo()->lastInsertId();

        // Nadrág
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "nadrág",
            "category_id" => $c_array["ruha"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);
        $c_array["nadrág"] = DB::getPdo()->lastInsertId();

        // Rövid nadrág
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "rövid nadrág",
            "category_id" => $c_array["nadrág"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Hosszú nadrág
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "hosszú nadrág",
            "category_id" => $c_array["nadrág"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Felső
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "felső",
            "category_id" => $c_array["ruha"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);
        $c_array["felső"] = DB::getPdo()->lastInsertId();

        // Pulóver
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "pulóver",
            "category_id" => $c_array["felső"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Kabát
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "kabát",
            "category_id" => $c_array["felső"],
            "category_group_id" => $cg_array["Termék csoportok"],
            "sequence" => $sequence++,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        //// Méretek
        // Ruha méretek
        DB::table("categories")->insertOrIgnore([
            "id" => $id++,
            "name" => "ruha méretek",
            "category_id" => null,
            "category_group_id" => $cg_array["Méretek"],
            "sequence" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);
        $c_array["ruha méretek"] = DB::getPdo()->lastInsertId();

        // Ruha méretek felvitele
        $array = ["XS","S","M","L","XL","2XL","3XL","4XL"];
        for ($i=0; $i<count($array); $i++) {
            DB::table("categories")->insertOrIgnore([
                "id" => $id++,
                "name" => $array[$i],
                "category_id" => $c_array["ruha méretek"],
                "category_group_id" => $cg_array["Méretek"],
                "sequence" => $i+2,
                "created_at" => get_now(),
                "updated_at" => get_now()
            ]);
        }

    }
}