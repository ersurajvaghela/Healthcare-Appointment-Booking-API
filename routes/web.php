<?php

use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('logs', [LogViewerController::class, 'index']); // optional middleware


Route::get('/login', function () {
    return response()->json(['error' => 'Unauthenticated.'], 401);
})->name('login');

Route::get('/', function () {
    return view('welcome');
});
