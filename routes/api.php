<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HealthcareProfessionalController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from API!']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // Healthcare professionals
    Route::get('/healthcare-professionals', [HealthcareProfessionalController::class, 'index']);
    Route::get('/healthcare-professionals/{healthcareProfessional}', [HealthcareProfessionalController::class, 'show']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete']);
});
