<?php

namespace App\Http\Services;

use App\Http\Requests\BuyerUserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BuyerUserUpdate {

    private $id, $name, $surname, $forename, $country, $state, $zip, $city, $address;

    // Adatok lekérdezése
    function __construct(BuyerUserUpdateRequest $buyerUserUpdateRequest) {
        $this->id = $buyerUserUpdateRequest->id;
        $this->name = $buyerUserUpdateRequest->name; 
        $this->surname = $buyerUserUpdateRequest->surname;
        $this->forename = $buyerUserUpdateRequest->forename;  
        $this->country = $buyerUserUpdateRequest->country;
        $this->state = $buyerUserUpdateRequest->state;
        $this->zip = $buyerUserUpdateRequest->zip;
        $this->city = $buyerUserUpdateRequest->city;
        $this->address = $buyerUserUpdateRequest->address;
        $this->updateUser();
    }

    // Felhasználó módosítása
    private function updateUser() {
        DB::transaction(function () {
            $user = User::find($this->id);         
            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->forename = $this->forename;
            $user->country = $this->country;
            $user->state = $this->state;
            $user->zip = $this->zip;
            $user->city = $this->city;
            $user->address = $this->address;
            $user->save();
        });
    }
}