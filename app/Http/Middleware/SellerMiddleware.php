<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    // Belépés csak Eladóknak
    public function handle(Request $request, Closure $next): Response
    {

        // Megnézni, hogy van-e eladó szerepköre
        restrict_role("boltos");

        return $next($request);
    }
}
