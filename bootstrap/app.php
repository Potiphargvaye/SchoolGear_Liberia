<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


use Spatie\Permission\Middleware\RoleMiddleware as SpatieRoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware): void {

    // Trust proxy headers (required for HTTPS behind Nginx / load balancers)
    $middleware->trustProxies(at: '*');

    $middleware->alias([
        'role' => SpatieRoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,

        'custom_role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);


    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();