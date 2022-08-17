<?php

namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;

class CheckUserIsAdmin
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

        $jwtService = new JwtService();
        if (!$jwtService->checkIfTokenIsAdmin($request->bearerToken())) {
            return response()->json(['error' => ['message' => "Forbidden. Unauthorized access."]], 403);
        }
        return $next($request);
    }
}
