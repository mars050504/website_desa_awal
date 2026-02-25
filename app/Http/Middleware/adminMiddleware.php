<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
