<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    // Belépés csak Eladóknak
    public function handle(Request $request, Closure $next): Response
    {

        // Alapértelmezetten nincs eladó szerepköre
        $has_seller_role = false;

        // Ha be van jelentkezve a felhasználó
        if (Auth::user()) {

            // Eladó szerepkör ID lekérdezése
            $role_id = Role::where("name", "seller")->first()->id;
             
            // Megnézni, hogy van-e eladó szerepköre a felhasználónak
            $has_seller_role = UserRole::where("user_id", Auth::id())->where("role_id", $role_id)->first();
            
        }

        // Ha nincs eladó szerepköre, akkor 403-as hiba
        if (!$has_seller_role) {
            abort(403);
        }

        return $next($request);
    }
}
