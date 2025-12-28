<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\ProfileWebController;

// HOME

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthWebController::class, 'login'])
    ->name('login.process');

Route::get('/logout', [AuthWebController::class, 'logout'])
    ->name('logout');

Route::get('/home-after-login', function () {
    return view('home_after_login');
})->name('user.home');

Route::get('/speech-to-text', function () {
    return view('speech-to-text');
})->name('stt');

Route::get('/register', function () {
    return view('register'); // file blade: resources/views/register.blade.php
})->name('register');

// Proses register
Route::post('/register', [AuthWebController::class, 'register'])
    ->name('register.post');


Route::get('/profile', [ProfileWebController::class, 'index'])->name('profile');
Route::get('/profile/edit', [ProfileWebController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileWebController::class, 'update'])->name('profile.update');