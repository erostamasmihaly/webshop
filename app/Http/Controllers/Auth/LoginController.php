<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    // Belépés után visszatérés a főoldalra
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Felhasználó beléptetése
    public function token(Request $request) {

        // Beléptetés megpróbálása
        $exists = Auth::attempt(array('email' => $request->email, 'password' => $request->password ));

        // Ha sikeres volt a beléptetés
        if($exists){

            // Felhasználó lekérdezése
            $user = User::find(Auth::id());

            // Ha nem aktív a felhasználó
            if ($user->active==0) {

                // Kijelentkezés
                Auth::logout();
                
                // Visszatérés a bejelentketési felületre hibaüzenettel
                return response()->json(['error'=>'Bejelentkezés megtagadva a fiók inaktív állapota miatt!']);
            }    

            // Felhasználó naplózása
            activity()->causedBy($user)->event('login')->log('login');

            // Token létrehozása a felhasználónak
            $tokenResult = $user->createToken('Personal Access Token');

            // Létrehozott token lekérdezése
            $token = $tokenResult->plainTextToken;

            // Token átküldése
            return response()->json([
                'token'=> $token,
            ],200);
        }

        else{

            // Sikertelen beléptetés esetén hiba írása
            return response()->json(['error'=>'Hiba történt a belépés során!']);
        }
    }

    protected function authenticated()
    {
        
        // Felhasználó lekérdezése
        $user = User::find(Auth::id());

        // Ha nem aktív
        if ($user->active==0) {

            // Kijelentkezés
            Auth::logout();
            
            // Visszatérés a bejelentketési felületre hibaüzenettel
            return redirect('login')->withErrors(['email' => 'Bejelentkezés megtagadva a fiók inaktív állapota miatt.']);
        }    

        // Felhasználó naplózása
        activity()->causedBy($user)->event('login')->log('login');

    }
}
