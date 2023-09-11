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

        // Kíváló
        DB::table("categories")->insertOrIgnore([
            "id" => 5,
            "name" => "kíváló",
            "category_group_id" => 3,
            "sequence" => 5,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Jó
        DB::table("categories")->insertOrIgnore([
            "id" => 6,
            "name" => "jó",
            "category_group_id" => 3,
            "sequence" => 4,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Átlagos
        DB::table("categories")->insertOrIgnore([
            "id" => 7,
            "name" => "átlagos",
            "category_group_id" => 3,
            "sequence" => 3,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Rossz
        DB::table("categories")->insertOrIgnore([
            "id" => 8,
            "name" => "rossz",
            "category_group_id" => 3,
            "sequence" => 2,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Borzalmas
        DB::table("categories")->insertOrIgnore([
            "id" => 9,
            "name" => "borzalmas",
            "category_group_id" => 3,
            "sequence" => 1,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Ruha
        DB::table("categories")->insertOrIgnore([
            "id" => 10,
            "name" => "ruha",
            "category_group_id" => 1,
            "sequence" => 1,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Nadrág
        DB::table("categories")->insertOrIgnore([
            "id" => 11,
            "name" => "nadrág",
            "category_id" => 10,
            "category_group_id" => 1,
            "sequence" => 2,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Felső
        DB::table("categories")->insertOrIgnore([
            "id" => 12,
            "name" => "felső",
            "category_id" => 10,
            "category_group_id" => 1,
            "sequence" => 3,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Pulóver
        DB::table("categories")->insertOrIgnore([
            "id" => 13,
            "name" => "pulóver",
            "category_id" => 12,
            "category_group_id" => 1,
            "sequence" => 4,
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Kabát
        DB::table("categories")->insertOrIgnore([
            "id" => 14,
            "name" => "kabát",
            "category_id" => 12,
            "category_group_id" => 1,
            "sequence" => 5,
            "created_at" => $now,
            "updated_at" => $now
        ]);


    }
}