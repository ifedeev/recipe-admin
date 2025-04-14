<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthDeviceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->headers->has('X-Device-Id')) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
