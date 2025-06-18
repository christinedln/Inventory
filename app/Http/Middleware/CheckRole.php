<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            if ($request->user()) {
                // Redirect to their appropriate dashboard if authenticated
                return redirect()->route($request->user()->getDashboardRoute());
            }
            // Redirect to login if not authenticated
            return redirect()->route('login');
        }

        return $next($request);
    }
}
