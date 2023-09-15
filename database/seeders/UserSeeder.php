<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Szerepkörök lekérdezése
        $array = [];
        $roles = Role::get();
        foreach ($roles AS $role) {
            $array[$role->name] = $role->id;
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
        $user_id = DB::getPdo()->lastInsertId();

        UserRole::insertOrIgnore([
            "id" => 1,
            "user_id" => $user_id,
            "role_id" => $array["admin"],
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
        $user_id = DB::getPdo()->lastInsertId();

        UserRole::insertOrIgnore([
            "id" => 2,
            "user_id" => $user_id,
            "role_id" => $array["vásárló"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

        // Boltos
        User::insertOrIgnore([
            "id" => 3,
            "name" => "boltos",
            "surname" => "Boltos",
            "forename" => "Felhasználó",
            "email" => "boltos@etm.hu",
            "password" => Hash::make("Boltos1234"),
            "active" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);
        $user_id = DB::getPdo()->lastInsertId();

        UserRole::insertOrIgnore([
            "id" => 3,
            "user_id" => $user_id,
            "role_id" => $array["boltos"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

    }
}
