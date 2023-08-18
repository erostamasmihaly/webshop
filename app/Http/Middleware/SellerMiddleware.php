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

        // Megnézni, hogy van-e eladó szerepköre
        restrict_role("seller");

        return $next($request);
    }
}
