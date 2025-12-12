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
    Route::get('/admin/daftar-pekebun', [AdminController::class,'get_daftar_pekebun'])->name('admin.daftar-pekebun');
    Route::get('/admin/pengajuan-ispo', [AdminController::class,'get_pengajuan_ispo'])->name('admin.pengajuan-ispo');
    Route::get('/admin/pengajuan-ispo/{id}', [AdminController::class,'get_detail_pengajuan_ispo'])->name('admin.detail-pengajuan-ispo');
});

// Pekebun Routes
Route::group(['middleware' => ['pekebun', 'no-cache']], function () {
    Route::get('/pekebun', [PekebunController::class, 'get_dashboard_pekebun'])->name('pekebun');
    Route::get('/pekebun/data-diri', [PekebunController::class, 'get_data_diri_pekebun'])->name('pekebun.data-diri');
    Route::get('/pekebun/daftar-kebun', [PekebunController::class, 'get_daftar_kebun_pekebun'])->name('pekebun.daftar-kebun');
    Route::get('/pekebun/daftar-kebun/{id}', [PekebunController::class, 'get_detail_data_kebun'])->name('pekebun.detail-data-kebun');
    Route::post('/pekebun/daftar-kebun/{id}/delete', [PekebunController::class, 'delete_kebun'])->name('pekebun.delete-kebun');
    Route::post('/pekebun/daftar-kebun/{id}/finalisasi', [PekebunController::class,'post_finalisasiKebun'])->name('pekebun.finalisasi-kebun');
    Route::post('/pekebun/daftar-kebun/{id}/pernyataan-stdb', [PekebunController::class,'post_pernyataanStdb'])->name('pekebun.pernyataan-stdb');
    Route::get('/pekebun/daftar-pemetaan', [PekebunController::class, 'get_daftar_pemetaan_kebun'])->name('pekebun.daftar-pemetaan');
    Route::get('/pekebun/daftar-pemetaan/semua-pemetaan', [PekebunController::class, 'get_allPemetaan'])->name('pekebun.allPemetaan');
    Route::get('/pekebun/daftar-pemetaan/{id}', [PekebunController::class, 'get_pemetaan_kebun'])->name('pekebun.pemetaan-kebun');
    Route::post('/pekebun/daftar-pemetaan/{id}', [PekebunController::class, 'post_pemetaan_kebun'])->name('pekebun.pemetaan.simpan');
    Route::get('/pekebun/daftar-kuisioner', [PekebunController::class, 'get_daftar_kuisioner_kebun'])->name('pekebun.daftar-kuisioner');
    Route::get('/pekebun/daftar-kuisioner/{id}', [PekebunController::class, 'get_kuisioner_kebun'])->name('pekebun.kuisioner-kebun');
});

