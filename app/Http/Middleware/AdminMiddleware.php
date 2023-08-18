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

        // Megnézni, hogy van-e admin szerepköre
        restrict_role("admin");

        return $next($request);
    }
}
