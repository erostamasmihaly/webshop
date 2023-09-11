<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{

    public function run(): void
    {

        // Aktuális idő lekérdezése
        $now = date("Y-m-d H:i:s", time());

        // Admin
        DB::table("roles")->insertOrIgnore([
            "id" => 1,
            "name" => "admin",
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Vásárló
        DB::table("roles")->insertOrIgnore([
            "id" => 2,
            "name" => "buyer",
            "created_at" => $now,
            "updated_at" => $now
        ]);

        // Boltos
        DB::table("roles")->insertOrIgnore([
            "id" => 3,
            "name" => "seller",
            "created_at" => $now,
            "updated_at" => $now
        ]);

    }
}
