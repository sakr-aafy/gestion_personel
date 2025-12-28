<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('jwt_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté');
        }

        try {
            JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            session()->forget('jwt_token');
            session()->forget('user_name');
            return redirect()->route('login')->with('error', 'Session expirée, veuillez vous reconnecter');
        }

        return $next($request);
    }
}