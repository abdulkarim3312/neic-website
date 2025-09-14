<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/frontend.php',
            __DIR__.'/../routes/backend.php',
            __DIR__.'/../routes/customer.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->web(append: [
        ]);

        $middleware->alias([
            'check.role' => \App\Http\Middleware\CheckRole::class,
            'check.auth' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'check.permission' => \App\Http\Middleware\CheckPermission::class,
            'customer' => \App\Http\Middleware\CustomerMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
