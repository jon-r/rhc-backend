<?php

namespace App\Http\Middleware;

use Closure;

class Debug
{
    public function handle($request, Closure $next)
    {
        if (env('APP_DEBUG', false)) {
            \DB::enableQueryLog();
        }

        return $next($request);
    }
}