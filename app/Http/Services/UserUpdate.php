<?php

namespace App\Http\Services;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserUpdate {

    public $name;
    private $id, $email, $password, $roles;

    // Adatok lekérdezése
    function __construct(UserUpdateRequest $userUpdateRequest) {
        $this->id = $userUpdateRequest->id;
        $this->email = $userUpdateRequest->email;
        $this->name = $userUpdateRequest->name;
        $this->password = $userUpdateRequest->password;   
        $this->roles = $userUpdateRequest->roles;     
        $this->updateRoles();
    }

    // Szerepkörök frissítése
    private function updateRoles() {

        DB::transaction(function () {

            // Aktuális szerepkörök lekérdezése
            $current_roles = UserRole::where("user_id", $this->id)->pluck("role_id")->toArray();

            // Új szerepkörök lekérdezése
            $new_roles = array_map("intval", $this->roles);

            // Törlendő szerepkörök
            $remove_roles = array_values(array_diff($current_roles, $new_roles));

            // Ezen szerepkörök törlése
            for ($i=0; $i<count($remove_roles); $i++) {
                UserRole::where("user_id", $this->id)->where("role_id", $remove_roles[$i])->delete();
            }

            // Hozzáadandó szererkörök
            $add_roles = array_values(array_diff($new_roles, $current_roles));

            // Ezen szerepkörök hozzáadása
            for ($i=0; $i<count($add_roles); $i++) {
                $user_role = new UserRole();
                $user_role->user_id = $this->id;
                $user_role->role_id = $add_roles[$i];
                $user_role->save();
            }

            // Felhasználó módosítása
            $this->updateUser();
        });
    }

    // Felhasználó módosítása
    private function updateUser() {
        DB::transaction(function () {

            // Ha nincs ilyen felhasználó, akkor létrehozni
            // Ha van, akkor meg lekérdezni
            if ($this->id == 0) {
                $user = new User();
                $user->email = $this->email;
            } else {
                $user = User::find($this->id);
            }            

            // Ha van új jelszó megadva, akkor az új tárolása HASHelve
            if ($this->password!=null) {
                $user->password = Hash::make($this->password);
            }

            // További adatok mentése
            $user->name = $this->name;

            // Felhasználó mentése
            $user->save();
        });
    }

}