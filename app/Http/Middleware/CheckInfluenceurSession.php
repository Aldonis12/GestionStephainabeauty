<?php

namespace App\Http\Middleware;

use Closure;

class CheckInfluenceurSession
{
    public function handle($request, Closure $next)
    {
        if (session('influenceur') !== null) {
            return $next($request);
        }

        return redirect('/NotFound/Gestion-Influenceur/influenceur');
    }
}
