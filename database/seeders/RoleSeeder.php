<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {

        // Ha nincs még szerepkörök
        if (Role::count()==0) {
            
            // Admin
            $role = new Role();
            $role->name = "admin";
            $role->save();

            // Vásárló
            $role = new Role();
            $role->name = "buyer";
            $role->save();

            // Boltos
            $role = new Role();
            $role->name = "seller";
            $role->save();
            
        }
    }
}
