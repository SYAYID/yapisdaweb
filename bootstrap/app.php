<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuthenticated::class,
            'smp.auth' => \App\Http\Middleware\SmpAdminAuthenticated::class,
            'finance.auth' => \App\Http\Middleware\FinanceAuthenticated::class,
            'operations.auth' => \App\Http\Middleware\OperationsAuthenticated::class,
            'api.key' => \App\Http\Middleware\ApiKeyAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
