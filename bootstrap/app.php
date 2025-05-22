<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\CustomAuthenticate;
use App\Http\Middleware\Kasir;
use App\Http\Middleware\Pengguna;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use PhpParser\Builder\Class_;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\CustomAuthenticate::class,
            'admin' => Admin::class,
            'pengguna' => Pengguna::class,
            'kasir' => Kasir::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
