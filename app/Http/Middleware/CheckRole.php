<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        try {
            // Mendapatkan user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Cek apakah role user ada dalam daftar role yang diizinkan
            if (!in_array($user->role, $roles)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access - insufficient role',
                ], 403); // Forbidden
            }

            // Lanjutkan ke request berikutnya
            return $next($request);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalid or expired',
            ], 401); // Unauthorized
        }
    }
}
