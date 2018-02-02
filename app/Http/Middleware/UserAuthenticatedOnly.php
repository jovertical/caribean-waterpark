<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserAuthenticatedOnly
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $this->auth->authenticate();

        if ($this->auth->check()) {
            if ($this->auth->user()->type != 'user') {
                if ($this->auth->user()->type == 'superuser') {
                    return redirect()->route('root.home');
                }

                abort(403, 'Access Forbidden');
            }
        }

        return $next($request);
    }
}
