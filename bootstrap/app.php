<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\ClearCheckoutSession;
use App\Http\Middleware\PelangganAuthenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(ClearCheckoutSession::class);
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'auth-pelanggan' => PelangganAuthenticate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
