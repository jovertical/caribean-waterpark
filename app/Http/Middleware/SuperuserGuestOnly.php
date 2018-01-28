<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperuserGuestOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::guard($guard)->user()->type != 'superuser') {
                return abort(403, '403 - Access forbidden');
            }

            return redirect()->route('superuser.home');
        }

        return $next($request);
    }
}
