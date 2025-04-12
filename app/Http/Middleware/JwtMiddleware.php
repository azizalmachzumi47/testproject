<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Cek apakah token ada dan valid
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // Token tidak ada atau tidak valid
            return response()->json(['message' => 'Token tidak valid atau telah kadaluarsa.'], 401);
        }

        // Menambahkan user ke request untuk digunakan di controller
        $request->attributes->add(['user' => $user]);

        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}