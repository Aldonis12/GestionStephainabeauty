<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSalonSession
{
    public function handle($request, Closure $next)
    {
        if (session('idsalon') !== null) {
            return $next($request);
        }

        return redirect('/NotFound/Gestion-Salon/salon');
    }
}
