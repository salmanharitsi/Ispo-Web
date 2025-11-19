<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


// Authentication Routes
Route::get('/login', [AuthController::class, 'get_login_page']);
