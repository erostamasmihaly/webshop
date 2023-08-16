<?php

namespace App\Http\Controllers;

use App\Http\Services\UserUpdate;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Csak az adminok léphetnek be
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Felhasználók listája
    public function index() {

        // Felhasználók lekérdezése
        $users = User::get();

        // Oldal meghívása
        return view('admin.user',[
            'users' => $users
        ]);
    }    

    // Felhasználó szerkesztése
    public function edit($id) {

        if ($id==0) {
            
            // Új felhasználó
            $user = new User();
            $user->id = 0;

        } else {
        
            // Felhasználó adatainak lekérdezése
            $user = User::find($id);
        }

        // Oldal meghívása
        return view('admin.user_edit',[
            'user' => $user
        ]);
    }

    // Felhasználó módosítása
    public function update(UserUpdate $userUpdate) {
        return redirect()->route('admin_user')->withMessage($userUpdate->name.' sikeresen módosítva lett.');
    }

    // Új felhasználó létrehozása
    public function create() {

        // Ugrás a Szerkesztő oldalra
        return redirect()->route('admin_user_edit', 0);

    }
}
