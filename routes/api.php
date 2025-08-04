<?php

use App\Http\Controllers\Api\v1\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EventController;

Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/login', [AuthController::class, 'login']);

    // Events (Public + Admin)
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);

    // Event Registrations (Authenticated)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events/{event}/register', [RegistrationController::class, 'register']);
        Route::delete('/events/{event}/unregister', [RegistrationController::class, 'unregister']);
        Route::get('/user/registrations', [RegistrationController::class, 'userRegistrations']);
    });
});
