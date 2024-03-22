<?php

use App\Http\Middleware\API\V1\SetLocaleMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        //For newer versions use the following syntax:
        //then: function () {
        //    Route::middleware('api')
        //        ->prefix('api/v2')
        //        ->group(base_path('routes/api_v2.php'));
        //}
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

        //Use the following exceptions only for production or your capacity to find BUGs will be diminished

        /**
         * Unauthenticated exception
         */
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        });

        /**
         * Route not found
         */
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
            ], 404);
        });

        /**
         * General error in DB query
         */
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'success' => false,
                    'message' => 'Query error 23000',
                ], 409);
            }

            return response()->json([
                'success' => false,
                'message' => 'Query error',
            ], 404);
        });

        /**
         * Error with method
         */
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Operation not found',
            ], 404);
        });

        /**
         * For type hint errors
         */
        $exceptions->render(function (TypeError $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Check your request',
            ], 404);
        });

        /**
         * For relationship errors
         */
        $exceptions->render(function (RelationNotFoundException $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => 'Bad relationship provided or not found',
            ], 404);
        });

    })->create();
