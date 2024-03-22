<?php

namespace App\Http\Middleware\API\V1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('locale', 'en');

        if ($locale && in_array($locale, ['en', 'es'])) { // Add more locales to the array as needed
            App::setLocale($locale);
        }

        return $next($request);
    }
}
