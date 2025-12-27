<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// HOME
Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
})->name('login');
// LOGIN
Route::post('/login', [AuthWebController::class, 'login'])
    ->name('login.process');

// LOGOUT
Route::get('/logout', [AuthWebController::class, 'logout'])
    ->name('logout');

// SPEECH TO TEXT

Route::get('/speech-to-text', function () {
    return view('speech-to-text');
})->name('stt');

// HOME SETELAH LOGIN
Route::get('/home-after-login', function () {
    return view('home_after_login');
})->name('user.home');
