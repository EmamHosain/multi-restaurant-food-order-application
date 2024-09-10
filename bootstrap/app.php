<?php

use App\Http\Middleware\AdminGuestMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientActiveCheckMiddleware;
use App\Http\Middleware\ClientGuestMiddleware;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            // default web route 
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // admin route
            Route::middleware('web')->prefix('admin')->name('admin.')
                ->group(base_path('routes/admin.php'));

            // client route
            Route::middleware('web')->prefix('client')->name('client.')
                ->group(base_path('routes/client.php'));

        },
        health: '/up',


    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // admin
            'adminAuth' => AdminMiddleware::class,
            'adminGuest' => AdminGuestMiddleware::class,

            // client
            'clientAuth' => ClientMiddleware::class,
            'clientGuest' => ClientGuestMiddleware::class,

            // inactive client account will not able to access this page
            'checkInactiveClientAccount' => ClientActiveCheckMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
