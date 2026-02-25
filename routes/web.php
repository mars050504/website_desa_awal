<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerbandinganKriteriaController;
use App\Http\Controllers\Admin\SuratController as AdminSuratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AhpController;


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ================= HALAMAN PUBLIK =================
Route::get('/', function () {
    return view('warga.dashboard');
});

// BERITA DESA (PUBLIK)
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);


// ================= AUTH =================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout']);


// ================= SETELAH LOGIN =================
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // ================= FITUR WARGA =================
    Route::get('/pengajuan-surat', [SuratController::class, 'pengajuan']);
    Route::get('/ajukan-surat', [SuratController::class, 'create']);
    Route::post('/ajukan-surat', [SuratController::class, 'store']);
    Route::get('/riwayat-surat', [SuratController::class, 'riwayat']);
    Route::get('/surat/{id}/edit', [SuratController::class, 'edit']);
    Route::post('/surat/{id}/update', [SuratController::class, 'update']);

    // ================= ADMIN =================
    Route::middleware('admin')->group(function () {

        Route::get('/warga', [App\Http\Controllers\Admin\WargaController::class, 'index']);

        Route::get('/kelola-surat', [AdminSuratController::class, 'index']);
        Route::post('/kelola-surat/{id}/update-status',[AdminSuratController::class, 'updateStatus']);

        // SETTING & BERITA ADMIN
        Route::get('/setting', [SettingController::class, 'index']);
        Route::post('/setting/berita', [SettingController::class, 'storeBerita']);
        Route::get('/setting/berita/{id}/edit', [SettingController::class, 'editBerita']);
        Route::post('/setting/berita/{id}/update', [SettingController::class, 'updateBerita']);
        Route::post('/setting/berita/{id}/delete', [SettingController::class, 'deleteBerita']);

        // KRITERIA
        Route::get('/kriteria', [KriteriaController::class, 'index']);
        Route::post('/kriteria', [KriteriaController::class, 'store']);
        Route::post('/kriteria/{id}/update', [KriteriaController::class, 'update']);
        Route::post('/kriteria/{id}/delete', [KriteriaController::class, 'destroy']);

        // ALTERNATIF
        Route::get('/alternatif', [AlternatifController::class, 'index']);
        Route::post('/alternatif', [AlternatifController::class, 'store']);
        Route::post('/alternatif/{id}/update', [AlternatifController::class, 'update']);
        Route::post('/alternatif/{id}/delete', [AlternatifController::class, 'destroy']);

        // AHP
        Route::get('/perbandingan-kriteria', [PerbandinganKriteriaController::class, 'index']);
        Route::post('/perbandingan-kriteria/hitung', [PerbandinganKriteriaController::class, 'hitung']);
        Route::get('/jenis-surat', [App\Http\Controllers\Admin\JenisSuratController::class, 'index']);
        Route::post('/jenis-surat', [App\Http\Controllers\Admin\JenisSuratController::class, 'store']);
        Route::post('/jenis-surat/{id}/update', [App\Http\Controllers\Admin\JenisSuratController::class, 'update']);
        Route::post('/jenis-surat/{id}/delete', [App\Http\Controllers\Admin\JenisSuratController::class, 'destroy']);
        Route::get('/ahp/prioritas', [App\Http\Controllers\Admin\AhpController::class, 'prioritas']);
        Route::get('/kelola-surat/{id}', [AdminSuratController::class, 'show']);
        Route::delete('/kelola-surat/{id}', [AdminSuratController::class, 'destroy']);

        // Data Warga
        Route::get('/warga/{id}/edit', [App\Http\Controllers\Admin\WargaController::class, 'edit']);
        Route::post('/warga/{id}/update', [App\Http\Controllers\Admin\WargaController::class, 'update']);
        Route::delete('/warga/{id}', [App\Http\Controllers\Admin\WargaController::class, 'destroy']);
    });
});
