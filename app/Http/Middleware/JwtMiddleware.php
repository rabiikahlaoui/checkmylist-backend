<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }

        try {

            // Stip Bearer keyword
            $token = str_replace('Bearer ', '', $token);

            $credentials = JWT::decode($token, new key(env('JWT_SECRET'), 'HS256'));

        } catch (ExpiredException $e) {

            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }

        $user = User::find($credentials->sub);
        $request->auth = $user;

        return $next($request);
    }
}
