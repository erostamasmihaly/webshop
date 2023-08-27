<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserActivate {

    public $ok = false;
    private $activation_code;

    // Adatok lekérdezése
    function __construct($activation_code) {
        $this->activation_code = $activation_code; 
        $this->insertUser();
    }

    // Felhasználó módosítása
    private function insertUser() {
        DB::transaction(function () {

            // Megnézni, hogy melyik felhasználóhoz tartozik a megadott aktiváló kód
            $user = User::where('activation_code', $this->activation_code)->first();

            // Ha létezik ezen felhasználó, akkor a felhasználó aktívvá tétele és a hozzá tartozó kód törlése
            if ($user) {
                $user->active = 1;
                $user->activation_code = null;
                $user->save();
                $this->ok = true;
            }            
        });
    }

}