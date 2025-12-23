<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home-after-login', function () {
    return view('home_after_login');
})->middleware('auth.user');


