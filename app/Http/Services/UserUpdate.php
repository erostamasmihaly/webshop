<?php

namespace App\Http\Services;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserUpdate {

    public $name;
    private $id, $email, $password;

    // Adatok lekérdezése
    function __construct(UserUpdateRequest $userUpdateRequest) {
        $this->id = $userUpdateRequest->id;
        $this->email = $userUpdateRequest->email;
        $this->name = $userUpdateRequest->name;
        $this->password = $userUpdateRequest->password;        
        $this->updateUser();
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