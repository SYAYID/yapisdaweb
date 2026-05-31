<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $configuredToken = (string) config('services.yapisda_api.token');

        if ($configuredToken === '') {
            return response()->json([
                'message' => 'Token API belum dikonfigurasi.',
            ], 503);
        }

        $requestToken = (string) ($request->bearerToken() ?: $request->header('X-API-KEY'));

        if ($requestToken === '' || !hash_equals($configuredToken, $requestToken)) {
            return response()->json([
                'message' => 'Token API tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
