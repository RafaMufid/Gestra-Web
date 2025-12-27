<?php

namespace App\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthUser
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect('/');
        }

        return $next($request);
    }
}
