<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin_smk')->user() ?: Auth::guard('web')->user();

        if (!$user || !$user->hasRole(['admin_smk', 'super_admin'])) {
            return redirect()->route('admin.login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        Auth::shouldUse(Auth::guard('admin_smk')->check() ? 'admin_smk' : 'web');

        return $next($request);
    }
}
