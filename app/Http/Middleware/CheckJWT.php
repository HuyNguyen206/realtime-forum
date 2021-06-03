<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;


class CheckJWT
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth ::parseToken()->authenticate();
        } catch (Exception $e) {
            //
            return response()->error(['message' => $e->getMessage(),'isJwt' => true], 500);
        }
        return $next($request);
    }
}
