<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptTypeRequest
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
        // if (!$request->expectsJson()) {
        //     return response()->json('Set header to accept type application/json or text/html');
        // }
        return $next($request);
    }
}
