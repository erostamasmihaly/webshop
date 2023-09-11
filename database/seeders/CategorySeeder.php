<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

    public function run(): void
    {

        // Aktuális idő lekérdezése
        $now = date("Y-m-d H:i:s", time());

        // Darab
        DB::table("categories")->insertOrIgnore([
            "id" => 1,
            "name" => "darab",
            "category_group_id" => 2,
            "sequence" => 1,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Liter
        DB::table("categories")->insertOrIgnore([
            "id" => 2,
            "name" => "liter",
            "category_group_id" => 2,
            "sequence" => 2,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Kilogramm
        DB::table("categories")->insertOrIgnore([
            "id" => 3,
            "name" => "kilogramm",
            "category_group_id" => 2,
            "sequence" => 3,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Méter
        DB::table("categories")->insertOrIgnore([
            "id" => 4,
            "name" => "méter",
            "category_group_id" => 2,
            "sequence" => 4,
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
