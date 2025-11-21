<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PekebunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


// Authentication Routes
Route::get('/login', [AuthController::class, 'get_login_page']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'get_register_page']);

// Admin Routes
Route::group(['middleware' => ['admin', 'no-cache']], function () {
    Route::get('/admin', [AdminController::class, 'get_dashboard_admin'])->name('admin');
});

// Pekebun Routes
Route::group(['middleware' => ['pekebun', 'no-cache']], function () {
    Route::get('/pekebun', [PekebunController::class, 'get_dashboard_pekebun'])->name('pekebun');
    Route::get('/pekebun/data-diri', [PekebunController::class, 'get_data_diri_pekebun'])->name('pekebun.data-diri');
    Route::get('/pekebun/daftar-kebun', [PekebunController::class, 'get_daftar_kebun_pekebun'])->name('pekebun.daftar-kebun');
    Route::get('/pekebun/daftar-kebun/{id}', [PekebunController::class, 'get_detail_data_kebun'])->name('pekebun.detail-data-kebun');
});

