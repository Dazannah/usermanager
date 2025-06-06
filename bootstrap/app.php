<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckIfInstalled;
use App\Http\Middleware\IsLocalUserEnabled;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckIfInstalled::class);

        $middleware->alias([
            'isLocalUserEnabled' => IsLocalUserEnabled::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
