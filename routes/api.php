<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// define a route named password.reset that returns true simply
Route::post('/api/password/reset', function () {
    // This route doesn't need to return anything

})->name('password.reset');
