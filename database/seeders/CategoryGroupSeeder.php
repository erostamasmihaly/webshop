<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{

    public function run(): void
    {

        // Aktuális idő lekérdezése
        $now = date("Y-m-d H:i:s", time());

        // Termék csoportok
        DB::table("category_groups")->insertOrIgnore([
            "id" => 1,
            "name" => "Termék csoportok",
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Mértékegységek
        DB::table("category_groups")->insertOrIgnore([
            "id" => 2,
            "name" => "Mértékegységek",
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Értékelések
        DB::table("category_groups")->insertOrIgnore([
            "id" => 3,
            "name" => "Értékelések",
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }
}
