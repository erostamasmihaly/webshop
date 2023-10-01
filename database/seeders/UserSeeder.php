<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Szerepkörök lekérdezése
        $roles = [];
        foreach (Role::get() AS $role) {
            $roles[$role->name] = $role->id;
        }

        // Admin
        User::insertOrIgnore([
            "id" => 1,
            "name" => "admin",
            "surname" => "Admin",
            "forename" => "Felhasználó",
            "email" => "admin@etm.hu",
            "password" => Hash::make("Admin1234"),
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $users["admin"] = 1;

        UserRole::insertOrIgnore([
            "id" => 1,
            "user_id" => $users["admin"],
            "role_id" => $roles["admin"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Vásárló
        User::insertOrIgnore([
            "id" => 2,
            "name" => "vasarlo",
            "surname" => "Vásárló",
            "forename" => "Felhasználó",
            "email" => "vasarlo@etm.hu",
            "password" => Hash::make("Vasarlo1234"),
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $users["vasarlo"] = 2;

        UserRole::insertOrIgnore([
            "id" => 2,
            "user_id" => $users["vasarlo"],
            "role_id" => $roles["vásárló"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Alkalmazott
        User::insertOrIgnore([
            "id" => 3,
            "name" => "alkalmazott",
            "surname" => "Alkalmazott",
            "forename" => "Felhasználó",
            "email" => "alkalmazott@etm.hu",
            "password" => Hash::make("Alkalmazott1234"),
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $users["alkalmazott"] = 3;

        UserRole::insertOrIgnore([
            "id" => 3,
            "user_id" => $users["alkalmazott"],
            "role_id" => $roles["alkalmazott"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

    }
}
