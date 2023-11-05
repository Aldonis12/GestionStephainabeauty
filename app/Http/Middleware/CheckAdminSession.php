<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminSession
{
    public function handle($request, Closure $next)
    {
        if (session('idadmin') !== null) {
            return $next($request);
        }

        return redirect('/NotFound/ADMINISTRATEUR/admin');
    }
}
