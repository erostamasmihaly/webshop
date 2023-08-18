<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
