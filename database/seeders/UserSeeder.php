<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Admin
        DB::table("users")->insertOrIgnore([
            "id" => 1,
            "name" => "admin",
            "surname" => "Admin",
            "forename" => "Felhasználó",
            "email" => "admin@etm.hu",
            "password" => Hash::make("Admin1234"),
            "active" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        DB::table("user_roles")->insertOrIgnore([
            "id" => 1,
            "user_id" => 1,
            "role_id" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Vásárló
        DB::table("users")->insertOrIgnore([
            "id" => 2,
            "name" => "buyer",
            "surname" => "Vásárló",
            "forename" => "Felhasználó",
            "email" => "buyer@etm.hu",
            "password" => Hash::make("Buyer1234"),
            "active" => 1,
            "country" => "Magyarország",
            "state" => "Borsod-Abaúj-Zemplén",
            "zip" => 3530,
            "city" => "Miskolc",
            "address" => "Király utca 12. 2/1.",
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        DB::table("user_roles")->insertOrIgnore([
            "id" => 2,
            "user_id" => 2,
            "role_id" => 2,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        // Boltos
        DB::table("users")->insertOrIgnore([
            "id" => 3,
            "name" => "seller",
            "surname" => "Boltos",
            "forename" => "Felhasználó",
            "email" => "seller@etm.hu",
            "password" => Hash::make("Seller1234"),
            "active" => 1,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

        DB::table("user_roles")->insertOrIgnore([
            "id" => 3,
            "user_id" => 3,
            "role_id" => 3,
            "created_at" => get_now(),
            "updated_at" => get_now()
        ]);

    }
}
