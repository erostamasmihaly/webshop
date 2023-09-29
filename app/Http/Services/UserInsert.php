<?php

namespace App\Http\Services;

use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserInsert {

    public $user;
    private $id, $email, $password, $surname, $forename, $name;

    // Adatok lekérdezése
    function __construct(UserUpdateRequest $userUpdateRequest) {
        $this->id = $userUpdateRequest->id;
        $this->email = $userUpdateRequest->email;
        $this->name = $userUpdateRequest->name;
        $this->password = $userUpdateRequest->password;   
        $this->surname = $userUpdateRequest->surname;
        $this->forename = $userUpdateRequest->forename;     
        $this->insertUser();
    }

    // Felhasználó módosítása
    private function insertUser() {
        DB::transaction(function () {

            // Felhasználó létrehozása
            $user = new User();
            $user->email = $this->email;          
            $user->password = Hash::make($this->password);
            $user->name = $this->name;
            $user->active = 0;
            $user->surname = $this->surname;
            $user->forename = $this->forename;
            $user->activation_code = generate_activation_code();

            // Felhasználó mentése
            $user->save();

            // Felhasználó publikussá tétele
            $this->user = $user;

            // Felhasználói azonosító lekérdezése
            $this->id = $user->id;

            // Szerepkör felvitele
            $user_role = new UserRole();
            $user_role->user_id = $this->id;
            $user_role->role_id = Role::where('name','vásárló')->first()->id;
            $user_role->save();
        });
    }

}