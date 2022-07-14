<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        foreach ($roles as $role) {
            if ($user->getRoleNames()[0] === $role) {
                return $next($request);
            }
        }

        abort(403, 'You must be have access to this page.');
    }
}
