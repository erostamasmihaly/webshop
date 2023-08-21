<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Ha nincs még Admin felhasználó, akkor létrehozni
        $has_admin = User::where("email","admin@etm.hu")->first();
        if (!$has_admin) {
            $user = new User();
            $user->name = "admin";
            $user->email = "admin@etm.hu";
            $user->password = Hash::make("Admin1234");
            $user->save();
        } 
        
        // Ha nincs még Admin szerepkör, akkor létrehozni
        $has_admin_role = Role::where("name","admin")->first();
        if (!$has_admin_role) {
            $role = new Role();
            $role->name = "admin";
            $role->save();
        }

        // Ha nincs még Buyer szerepkör, akkor létrehozni
        $has_buyer_role = Role::where("name","buyer")->first();
        if (!$has_buyer_role) {
            $role = new Role();
            $role->name = "buyer";
            $role->save();
        }

        // Ha nincs még Seller szerepkör, akkor létrehozni
        $has_seller_role = Role::where("name","seller")->first();
        if (!$has_seller_role) {
            $role = new Role();
            $role->name = "seller";
            $role->save();
        }

        // Ha az Admin nincs hozzárendelve az Admin szerepkörhöz
        $has_admin_to_admin_role = UserRole::where("user_id",1)->where("role_id",1)->first();
        if (!$has_admin_to_admin_role) {
            $user_role = new UserRole();
            $user_role->user_id = 1;
            $user_role->role_id = 1;
            $user_role->save();
        }

        // Ha nincs még DB mértékegység
        $has_unit_db = Unit::where("name","db")->first();
        if (!$has_unit_db) {
            $unit = new Unit();
            $unit->name = "db";
            $unit->save();
        }

        // Ha nincs még KG mértékegység
        $has_unit_db = Unit::where("name","kg")->first();
        if (!$has_unit_db) {
            $unit = new Unit();
            $unit->name = "kg";
            $unit->save();
        }

        // Ha nincs még liter mértékegység
        $has_unit_db = Unit::where("name","liter")->first();
        if (!$has_unit_db) {
            $unit = new Unit();
            $unit->name = "liter";
            $unit->save();
        }
    }
}
