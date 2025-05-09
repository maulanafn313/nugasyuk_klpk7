<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UpdateScheduleStatus;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    //middleware untuk pengaturan autentikasi akses masuk
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'userMiddleware' => UserMiddleware::class,
            'adminMiddleware' => AdminMiddleware::class,
        ]);

        // Tambahkan middleware global
        $middleware->use([
            UpdateScheduleStatus::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
