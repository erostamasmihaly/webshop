<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ha nincs még felhasználók létrehozva
        if (User::count()==0) {

            // Admin felhasználó
            $user = new User();
            $user->name = "admin";
            $user->surname = "Admin";
            $user->forename = "Felhasználó";
            $user->email = "admin@etm.hu";
            $user->password = Hash::make("Admin1234");
            $user->active = 1;
            $user->save();

            // Admin felhasználó felvitele az Admin szerepkörhöz
            $user_role = new UserRole();
            $user_role->user_id = 1;
            $user_role->role_id = 1;
            $user_role->save();

            // Vásárló felhasználó
            $user = new User();
            $user->name = "buyer";
            $user->surname = "Vásárló";
            $user->forename = "Felhasználó";
            $user->email = "buyer@etm.hu";
            $user->password = Hash::make("Buyer1234");
            $user->active = 1;
            $user->country = "Magyarország";
            $user->state = "Borsod-Abaúj-Zemplén vármegye";
            $user->zip = 3630;
            $user->city = "Miskolc";
            $user->address = "Király utca 12. 2/1.";
            $user->save();

            // Vásárló felhasználó felvitele a Vásárló szerepkörhöz
            $user_role = new UserRole();
            $user_role->user_id = 2;
            $user_role->role_id = 2;
            $user_role->save();

            // Boltos felhasználó
            $user = new User();
            $user->name = "seller";
            $user->surname = "Boltos";
            $user->forename = "Felhasználó";
            $user->email = "seller@etm.hu";
            $user->password = Hash::make("Seller1234");
            $user->active = 1;
            $user->save();

            // Boltos felhasználó felvitele a Boltos szerepkörhöz
            $user_role = new UserRole();
            $user_role->user_id = 3;
            $user_role->role_id = 3;
            $user_role->save();

        } 
    }
}
