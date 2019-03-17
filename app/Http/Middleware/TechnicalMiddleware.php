<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TechnicalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->user()->can('technical_team')) {
            return $next($request);
        }

        return response()->json([
            'data'          => [],
            'successfully'  => false,
            'errors'        => ['unauthenticated'],
        ],401);
    }
}
