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

        // Megnézni, hogy van-e vásárló szerepköre
        restrict_role("buyer");

        return $next($request);
    }
}
