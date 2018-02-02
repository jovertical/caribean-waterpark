<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserGuestOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->type != 'user') {
                if (Auth::user()->type == 'superuser') {
                    return redirect()->route('root.home');
                }

                return abort(403, 'Access forbidden');
            }

            return redirect()->route('front.home');
        }

        return $next($request);
    }
}
