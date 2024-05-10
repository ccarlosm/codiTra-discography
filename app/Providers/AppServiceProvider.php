<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Macro for responses in API/V1
        Response::macro('apiV1', function ($data, $success = true, $status = 200) {
            return Response::json([
                'success' => $success,
                'data' => $data,
            ], $status);
        });
    }
}
