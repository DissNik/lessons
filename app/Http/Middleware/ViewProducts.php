<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViewProducts
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if ($request->has('view')) {
            return back()->cookie(
                cookie()->forever('view_products', $request->get('view'))
            );
        }

        return $next($request);
    }
}
