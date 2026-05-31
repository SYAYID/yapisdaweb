<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OperationsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('operations')->user();

        if (!$user || !$user->hasRole(['operasional', 'admin_smk', 'admin_smp', 'finance', 'kepala_sekolah', 'yayasan', 'super_admin'])) {
            return redirect()->route('admin.operations.login')->with('error', 'Silakan login ke panel operasional.');
        }

        Auth::shouldUse('operations');

        return $next($request);
    }
}
