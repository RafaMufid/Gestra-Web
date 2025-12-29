<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\SpeechController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']);
    Route::post('/history', [HistoryController::class, 'store']);
    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/community-posts', [CommunityPostController::class, 'index']);
    Route::post('/community-posts', [CommunityPostController::class, 'store']);
    Route::delete('/history/{id}', [HistoryController::class, 'destroy']);

    Route::post('/speech', [SpeechController::class, 'store']);
});
