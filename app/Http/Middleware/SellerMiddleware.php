<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    // Belépés csak Alkalmazottaknak
    public function handle(Request $request, Closure $next): Response
    {

        // Megnézni, hogy van-e Alkalmazott szerepköre
        restrict_role("alkalmazott");

        return $next($request);
    }
}
