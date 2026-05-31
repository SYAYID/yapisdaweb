<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinanceAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('finance')->user() ?: Auth::guard('web')->user();

        if (!$user || !$user->hasRole(['finance', 'super_admin'])) {
            return redirect()->route('admin.finance.login')
                ->with('error', 'Silakan login sebagai bagian keuangan.');
        }

        Auth::shouldUse(Auth::guard('finance')->check() ? 'finance' : 'web');

        return $next($request);
    }
}
