<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SmpAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin_smp')->user() ?: Auth::guard('web')->user();

        if (!$user || !$user->hasRole(['admin_smp', 'super_admin'])) {
            return redirect()->route('admin.smp.login')->with('error', 'Silakan login sebagai admin SMP terlebih dahulu.');
        }

        Auth::shouldUse(Auth::guard('admin_smp')->check() ? 'admin_smp' : 'web');

        return $next($request);
    }
}
