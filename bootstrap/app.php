<?php

use App\Exceptions\GlobalException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function () {
            Route::middleware('api')
                ->prefix('web/v1')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->redirectTo(guests: function (Request $request) {
            //
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

        $exceptions->render(function (Throwable $e, $request) {
            $global = new GlobalException();
            return $global->render($e, $request);
        });
    })->create();
