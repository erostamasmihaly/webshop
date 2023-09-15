<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    // Belépés csak Vásárlóknak
    public function handle(Request $request, Closure $next): Response
    {

        // Megnézni, hogy van-e vásárló szerepköre
        restrict_role("vásárló");

        return $next($request);
    }
}
