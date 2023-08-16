<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    // Belépés csak Adminoknak
    public function handle(Request $request, Closure $next): Response
    {

        // Alapértelmezetten nincs admin szerepköre
        $has_admin_role = false;

        // Ha be van jelentkezve a felhasználó
        if (Auth::user()) {

            // Admin szerepkör ID lekérdezése
            $role_id = Role::where("name", "admin")->first()->id;
             
            // Megnézni, hogy van-e admin szerepköre a felhasználónak
            $has_admin_role = UserRole::where("user_id", Auth::id())->where("role_id", $role_id)->first();
            
        }

        // Ha nincs admin szerepköre, akkor 403-as hiba
        if (!$has_admin_role) {
            abort(403);
        }

        return $next($request);
    }
}
