<?php

use Illuminate\Support\Facades\Route;
use App\Models\User; // 🔥 TAMBAHKAN INI
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
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\StrukturController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\BackupController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

////////////////////////////////////////////////////
/// 🌐 HALAMAN PUBLIK
////////////////////////////////////////////////////

Route::get('/', [DashboardController::class, 'warga']);

// BERITA
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);


////////////////////////////////////////////////////
/// 🔐 AUTH
////////////////////////////////////////////////////

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout']);


////////////////////////////////////////////////////
/// ✉️ EMAIL VERIFICATION (TAMBAHAN)
////////////////////////////////////////////////////

// halaman pemberitahuan
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// proses verifikasi
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {

    $user = User::find($id);

    if (!$user) {
        abort(404);
    }

    // 🔥 validasi hash email
    if (!hash_equals($hash, sha1($user->email))) {
        abort(403);
    }

    // 🔥 validasi signature (biar aman)
    if (!URL::hasValidSignature(request())) {
        abort(403);
    }

    // 🔥 isi email_verified_at
    if (!$user->hasVerifiedEmail()) {
        $user->email_verified_at = now();
        $user->save();
    }

    return redirect('/login')->with('success', 'Email berhasil diverifikasi');
})->name('verification.verify');
// kirim ulang email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi dikirim ulang');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


////////////////////////////////////////////////////
/// 🔑 SETELAH LOGIN
////////////////////////////////////////////////////

Route::middleware(['auth'])->group(function () {

    ////////////////////////////////////////////
    /// 👤 WARGA
    ////////////////////////////////////////////

    // PROFIL
    Route::get('/profil', [AuthController::class, 'profil']);
    Route::post('/profil/update', [AuthController::class, 'updateProfil']);
    Route::get('/struktur-desa', [StrukturController::class, 'index']);

    // SURAT
    Route::get('/ajukan-surat', [SuratController::class, 'create']);
    Route::post('/ajukan-surat', [SuratController::class, 'store']);
    Route::get('/riwayat-surat', [SuratController::class, 'riwayat']);
    Route::get('/surat/{id}/edit', [SuratController::class, 'edit'])->name('surat.edit');
    Route::post('/surat/{id}/update', [SuratController::class, 'update']);
    Route::delete('/hapus-surat/{id}', [SuratController::class, 'destroy']);
    Route::get('/form-surat/{id}', [SuratController::class, 'getForm']);
    Route::get('/generate-surat/{id}', [SuratController::class, 'generate']);
    Route::get('/surat/{id}', [SuratController::class, 'show'])->name('surat.show');
    Route::post('/surat/{id}/update-detail', [SuratController::class, 'updateDetail']);


    ////////////////////////////////////////////
    /// 👑 ADMIN ONLY
    ////////////////////////////////////////////

    Route::middleware('admin')->group(function () {

        // DASHBOARD ADMIN
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // DATA WARGA
        Route::get('/warga', [WargaController::class, 'index']);
        Route::get('/warga/create', [WargaController::class, 'create']);
        Route::post('/warga', [WargaController::class, 'store']);
        Route::get('/warga/{id}/edit', [WargaController::class, 'edit']);
        Route::post('/warga/{id}/update', [WargaController::class, 'update']);
        Route::delete('/warga/{id}', [WargaController::class, 'destroy']);

        // KELOLA SURAT
        Route::get('/kelola-surat', [AdminSuratController::class, 'index']);
        Route::get('/kelola-surat/{id}', [AdminSuratController::class, 'show']);
        Route::post('/kelola-surat/{id}/update-status', [AdminSuratController::class, 'updateStatus']);
        Route::delete('/kelola-surat/{id}', [AdminSuratController::class, 'destroy']);
        Route::get('/rekap-surat', [\App\Http\Controllers\Admin\SuratController::class, 'rekap']);
        Route::get('/rekap-surat/export', [\App\Http\Controllers\Admin\SuratController::class, 'exportCsv']);
        Route::get('/kelola-surat/{id}/pdf', [AdminSuratController::class, 'pdf']);
        Route::post('/kelola-surat/{id}/update-isi', [AdminSuratController::class, 'updateIsi']);
        Route::get('/kelola-surat/{id}/download', [AdminSuratController::class, 'downloadPdf']);

        // SETTING & BERITA
        Route::prefix('setting')->group(function () {

            // BERITA
            Route::get('/berita', [SettingController::class, 'berita']);
            Route::post('/berita', [SettingController::class, 'storeBerita']);
            Route::get('/berita/{id}/edit', [SettingController::class, 'editBerita']);
            Route::post('/berita/{id}/update', [SettingController::class, 'updateBerita']);
            Route::post('/berita/{id}/delete', [SettingController::class, 'deleteBerita']);

            // PASSWORD
            Route::get('/password', [SettingController::class, 'password']);
            Route::post('/update-password', [SettingController::class, 'updatePassword']);

            // PERANGKAT DESA
            Route::get('/perangkat-desa', [SettingController::class, 'perangkatDesa']);
            Route::post('/perangkat-desa', [SettingController::class, 'storePerangkat']);
            Route::post('/wallpaper', [SettingController::class, 'uploadWallpaper']);
            Route::post('/wallpaper/set', [SettingController::class, 'setWallpaper']);
            Route::post('/wallpaper/delete', [SettingController::class, 'deleteWallpaper']);
            Route::get('/admin/backup', [BackupController::class, 'backup'])
                ->middleware('auth')
                ->name('admin.backup');
        });

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
        Route::get('/ahp/prioritas-global', [AhpController::class, 'prioritasGlobal']);
        Route::get('/ahp/matriks-alternatif', [AhpController::class, 'matriksAlternatif']);
        Route::post('/kriteria/simpan-bobot', [PerbandinganKriteriaController::class, 'simpanBobot']);
        Route::get('/perbandingan-kriteria/hasil-terakhir', [PerbandinganKriteriaController::class, 'hasilTerakhir']);
        Route::get('/perbandingan-kriteria', [PerbandinganKriteriaController::class, 'index']);
        Route::post('/perbandingan-kriteria/hitung', [PerbandinganKriteriaController::class, 'hitung']);

        // JENIS SURAT
        Route::get('/jenis-surat', [JenisSuratController::class, 'index']);
        Route::post('/jenis-surat', [JenisSuratController::class, 'store']);
        Route::post('/jenis-surat/{id}/update-nilai', [JenisSuratController::class, 'updateNilai']);
        Route::post('/jenis-surat/{id}/delete', [JenisSuratController::class, 'destroy']);

        // HASIL AHP
        Route::get('/ahp/prioritas', [AhpController::class, 'prioritas']);
    });
});
