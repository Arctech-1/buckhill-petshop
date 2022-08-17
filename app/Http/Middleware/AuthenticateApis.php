<?php

namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;

class AuthenticateApis
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // check if user request has a bearer token  
        if ($request->bearerToken() == '') {
            return response()->json(['error' => ['message' => 'no token parsed. Make sure you are authenticated.']], 401);
        }

        $jwtService = new JwtService(env('JWT_PUBLIC_KEY'));

        // check if the user has a valid token 
        if (!$jwtService->validateToken($request->bearerToken())) {
            return response()->json(['error' => ['message' => "Invalid token. Token doesn't match any user records."]], 401);
        }

        // check if token is expired 
        if ($jwtService->checkIfTokenIsExpired($request->bearerToken())) {
            return response()->json(['error' => ['message' => 'Token expired. Login to refresh token.']], 401);
            // return $next($request);
        }

        return $next($request);
    }
}
