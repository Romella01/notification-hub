<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Device\DeviceController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')
    ->prefix('devices')
    ->group(function () {
        Route::post('/', [DeviceController::class, 'crete']);
    });
