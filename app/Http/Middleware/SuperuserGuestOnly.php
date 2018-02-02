<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperuserGuestOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->type != 'superuser') {
                return abort(403, '403 - Access forbidden');
            }

            return redirect()->route('root.home');
        }

        return $next($request);
    }
}
