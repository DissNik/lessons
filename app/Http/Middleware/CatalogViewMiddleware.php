<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CatalogViewMiddleware
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($request->has('view')) {
            Cookie::queue(
                cookie()->forever('view_products', $request->get('view'))
            );
        }

        return $next($request);
    }
}
