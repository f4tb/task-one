<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register',[\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login',[\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'user']);
    Route::resource('/contact', \App\Http\Controllers\Api\ContactController::class);
    Route::group(['middleware' => \App\Http\Middleware\AdminRole::class], function () {
        Route::prefix('/admin')->group(function () {
            Route::resource('/user', \App\Http\Controllers\Api\UserController::class);
            Route::resource('/user/{user}/contact', \App\Http\Controllers\Api\AdminContactController::class);
            Route::get('/dashboard',[\App\Http\Controllers\Api\AdminContactController::class, 'dashboard']);
        });
    });
});
