<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {

        // Szerepkörök felvitele
        $array = ["admin","vásárló","alkalmazott"];
        for ($i=0; $i<count($array); $i++) {
            Role::insertOrIgnore([
                "id" => $i + 1,
                "name" => $array[$i],
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
