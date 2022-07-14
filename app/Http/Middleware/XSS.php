<?php

namespace App\Http\Middleware;

use Closure;

class XSS
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function handle($request, Closure $next)
    {
        $userInput = $request->all();
        array_walk_recursive($userInput, function (&$userInput) {
            $userInput = htmlentities($userInput);
        });
        $request->merge($userInput);
        return $next($request);
    }
}
