<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/stories', [StoryController::class, 'index']);
    Route::post('/stories', [StoryController::class, 'store']);
    Route::get('/stories/location', [StoryController::class, 'storiesWithLocation']);
});
