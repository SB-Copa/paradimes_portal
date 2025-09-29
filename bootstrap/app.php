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
        //

         $middleware->group('api', [
            \Illuminate\Session\Middleware\StartSession::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,// Needed for cookie-based authentication
            // \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // except login etc
            // \App\Http\Middleware\VerifyCSRFToken::class,
            // \App\Http\Middleware\RefreshSanctumToken::class, //refresh the session because auth sanctum does not automatically reset the session unlike web (to refresh not to logout)
            // 'throttle:api',
            // SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
