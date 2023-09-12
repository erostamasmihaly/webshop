<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{

    public function run(): void
    {

        // Termék csoportok
        DB::table("category_groups")->insertOrIgnore([
            "id" => 1,
            "name" => "Termék csoportok",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Mértékegységek
        DB::table("category_groups")->insertOrIgnore([
            "id" => 2,
            "name" => "Mértékegységek",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Értékelések
        DB::table("category_groups")->insertOrIgnore([
            "id" => 3,
            "name" => "Értékelések",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);
    }
}
