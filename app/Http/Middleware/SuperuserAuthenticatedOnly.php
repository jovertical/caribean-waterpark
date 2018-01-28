<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class SuperuserAuthenticatedOnly
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $this->authenticate();

        if ($this->auth->check()) {
            if ($this->auth->user()->type != 'superuser') {
                abort(403, 'Access Forbidden');
            }
        }

        return $next($request);
    }

    protected function authenticate()
    {
        return $this->auth->authenticate();
    }
}
