<?php

use App\Http\Middleware\API\V1\SetLocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //Incoming requests from SPA can authenticate using Laravel's session cookies
        //while still allowing requests from third parties or mobile applications to authenticate using API tokens
        $middleware->statefulApi();

        //For API there is no need for verifying CSRF token
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        //Localization middleware
        $middleware->append(SetLocaleMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {


        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
            ], 404);
        });

    })->create();
