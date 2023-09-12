<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{

    public function run(): void
    {

        // Admin
        DB::table("roles")->insertOrIgnore([
            "id" => 1,
            "name" => "admin",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Vásárló
        DB::table("roles")->insertOrIgnore([
            "id" => 2,
            "name" => "buyer",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Boltos
        DB::table("roles")->insertOrIgnore([
            "id" => 3,
            "name" => "seller",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

    }
}
