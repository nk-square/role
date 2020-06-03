<?php

namespace Nksquare\Role\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {
        if($request->user() && !$request->user()->hasRole($roles))
        {
            throw new AuthorizationException();
        }
        return $next($request);
    }
}