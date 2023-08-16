<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    // Belépés csak Vásárlóknak
    public function handle(Request $request, Closure $next): Response
    {

        // Alapértelmezetten nincs vásárló szerepköre
        $has_buyer_role = false;

        // Ha be van jelentkezve a felhasználó
        if (Auth::user()) {

            // Vásárló szerepkör ID lekérdezése
            $role_id = Role::where("name", "buyer")->first()->id;
             
            // Megnézni, hogy van-e vásárló szerepköre a felhasználónak
            $has_buyer_role = UserRole::where("user_id", Auth::id())->where("role_id", $role_id)->first();
            
        }

        // Ha nincs vásárló szerepköre, akkor 403-as hiba
        if (!$has_buyer_role) {
            abort(403);
        }

        return $next($request);
    }
}
