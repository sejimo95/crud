<?php

use App\Http\Controllers\Api\V1\Auth\AdminLoginController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ClientLoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Client\StatementController;
use Illuminate\Support\Facades\Route;

// api v1
Route::prefix('v1')->group( function () {

// auth
    Route::prefix('auth')->group( function () {
        Route::post('client-login', [ClientLoginController::class, 'login']);
        Route::post('admin-login', [AdminLoginController::class, 'login']);
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('is-login', [AuthController::class, 'isLogin']);
    });

    // panel client
    Route::prefix('panel/client')->middleware('auth:client')->group( function () {
        Route::apiResource('statement', StatementController::class);
    });

});
