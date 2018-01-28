<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    protected $redirectTo;
    
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch (Auth::user()->type) {
                case 'superuser':
                        $this->redirectTo = route('superuser.home');
                    break;

                default:
                        $this->redirectTo = route('front.welcome');
                    break;
            }

            return redirect()->intended($this->redirectTo);
        }

        return $next($request);
    }
}
