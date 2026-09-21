<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page Resmi & Utama
Route::view('/', 'welcome')->name('home');

// 2. Autentikasi Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// 3. Rute Terproteksi Pengguna (Auth & Verified)
Route::middleware(['auth', 'verified'])->group(function () {

    // Smart Dashboard Router (Mengarahkan otomatis sesuai Role)
    Route::get('dashboard', function () {
        $user = auth()->user();
        $adminRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Fisioterapis', 'Apoteker', 'Approver'];
        
        if ($user && $user->hasAnyRole($adminRoles)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('patient.dashboard');
    })->name('dashboard');

    // =========================================================================
    // PORTAL PASIEN (/pasien/dashboard)
    // =========================================================================
    Route::view('pasien/dashboard', 'pasien.dashboard')->name('patient.dashboard');
    Route::redirect('patient-dashboard', 'pasien/dashboard');
    Route::redirect('pasien', 'pasien/dashboard');

    // General / Patient Sub-pages
    Route::view('antrian', 'antrian.index')->name('antrian.index');
    Route::view('antrian/detail', 'antrian.detail')->name('antrian.detail');
    Route::view('jadwal-dokter', 'jadwal.index')->name('jadwal.index');
    Route::view('rekam-medis', 'rekam-medis.index')->name('rekam-medis.index');
    Route::view('panduan', 'admin.panduan.index')->name('panduan');

    // =========================================================================
    // PORTAL ADMIN & TENAGA MEDIS (/admin/dashboard)
    // Dilindungi middleware EnsureUserIsAdmin agar aman dari akses pasien
    // =========================================================================
    Route::view('admin/dashboard', 'dashboard')
        ->middleware(EnsureUserIsAdmin::class)
        ->name('admin.dashboard');

    // Alias URL kompatibilitas
    Route::redirect('admin-dashboard', 'admin/dashboard');
    Route::redirect('admin', 'admin/dashboard');

    // Admin Specific Subroutes
    Route::prefix('admin')->name('admin.')->middleware(EnsureUserIsAdmin::class)->group(function () {
        Route::view('antrian', 'antrian.index')->name('antrian');
        Route::view('antrian/detail', 'antrian.detail')->name('antrian.detail');
        Route::view('jadwal-dokter', 'jadwal.index')->name('jadwal');
        Route::view('rekam-medis', 'rekam-medis.index')->name('rekam-medis');

        // Backup Database Manager
        Route::get('backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup');
        Route::post('backup', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
        Route::get('backup/download/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
        Route::delete('backup/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backup.delete');

        // Panduan Singkat
        Route::view('panduan', 'admin.panduan.index')->name('panduan');
    });

    // Profil Pengguna
    Route::view('profile', 'profile')->name('profile');
});

// Logout
Route::post('logout', function (Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
