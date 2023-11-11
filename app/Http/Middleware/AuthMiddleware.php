<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$this->isValidToken($token)) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token)
    {
        return $token === 'YIo6abISPQq56tJhH6LtD7kIE2ZXacjRvjbLGzbXZHE';
    }
}