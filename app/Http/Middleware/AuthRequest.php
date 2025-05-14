<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthRequest
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
        $apiKey = $request->header('X-API-KEY');
        $validKey = env('API_SECRET_KEY'); 

        if ($apiKey !== $validKey) {
            return response()->json(['message' => 'Unauthorized. Invalid API Key.'], 401);
        }

        return $next($request);
    }
}
