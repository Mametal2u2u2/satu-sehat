<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsPatient;
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
        $adminRoles = ['Super Admin', 'Admin Klinik', 'Dokter', 'Perawat', 'Petugas Pendaftaran', 'Fisioterapis', 'Apoteker', 'Approver'];
        
        if ($user && $user->hasAnyRole($adminRoles)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('patient.dashboard');
    })->name('dashboard');

    // =========================================================================
    // PORTAL PASIEN (/pasien/dashboard)
    // Dilindungi middleware EnsureUserIsPatient agar aman dari akses staf/admin
    // =========================================================================
    Route::middleware(EnsureUserIsPatient::class)->group(function () {
        Route::view('pasien/dashboard', 'pasien.dashboard')->name('patient.dashboard');
        Route::redirect('patient-dashboard', 'pasien/dashboard');
        Route::redirect('pasien', 'pasien/dashboard');
    });

    // General / Patient Sub-pages
    Route::view('antrian', 'antrian.index')->name('antrian.index');
    Route::view('antrian/detail', 'antrian.detail')->name('antrian.detail');
    Route::view('jadwal-dokter', 'jadwal.index')->name('jadwal.index');
    Route::view('rekam-medis', 'rekam-medis.index')->name('rekam-medis.index');
    Route::view('panduan', 'admin.panduan.index')->name('panduan');

    // =========================================================================
    // PORTAL ADMIN & TENAGA MEDIS (/admin/dashboard)
    // Dilindungi middleware EnsureUserIsAdmin & permission:dashboard.view
    // =========================================================================
    Route::view('admin/dashboard', 'dashboard')
        ->middleware([EnsureUserIsAdmin::class, 'permission:dashboard.view'])
        ->name('admin.dashboard');

    // Alias URL kompatibilitas
    Route::redirect('admin-dashboard', 'admin/dashboard');
    Route::redirect('admin', 'admin/dashboard');

    // Admin Specific Subroutes
    Route::prefix('admin')->name('admin.')->middleware(EnsureUserIsAdmin::class)->group(function () {
        Route::view('antrian', 'antrian.index')->middleware('permission:antrian.view')->name('antrian');
        Route::view('antrian/detail', 'antrian.detail')->middleware('permission:antrian.view')->name('antrian.detail');
        Route::view('jadwal-dokter', 'jadwal.index')->middleware('permission:jadwal.view')->name('jadwal');
        Route::view('rekam-medis', 'rekam-medis.index')->middleware('permission:rekam_medis.view')->name('rekam-medis');

        // Backup Database Manager
        Route::prefix('backup')->name('backup')->middleware('permission:backup.view')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\BackupController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->middleware('permission:backup.create')->name('.create');
            Route::get('/download/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('.download');
            Route::delete('/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->middleware('permission:backup.delete')->name('.delete');
        });

        // Manajemen Hak Akses (Role, Permission, User Role, Audit Log)
        Route::prefix('hak-akses')->name('access-control.')->middleware('permission:role.view|permission.view|audit_log.view')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AccessControlController::class, 'index'])->name('index');
            Route::put('roles/{role}/permissions', [\App\Http\Controllers\Admin\AccessControlController::class, 'updateRolePermissions'])->middleware('permission:permission.edit')->name('permissions.update');
            Route::post('roles', [\App\Http\Controllers\Admin\AccessControlController::class, 'storeRole'])->middleware('permission:role.create')->name('roles.store');
            Route::put('roles/{role}', [\App\Http\Controllers\Admin\AccessControlController::class, 'updateRole'])->middleware('permission:role.edit')->name('roles.update');
            Route::delete('roles/{role}', [\App\Http\Controllers\Admin\AccessControlController::class, 'deleteRole'])->middleware('permission:role.delete')->name('roles.delete');
            Route::put('users/{user}/role', [\App\Http\Controllers\Admin\AccessControlController::class, 'updateUserRole'])->middleware('permission:user.edit')->name('users.role.update');
            Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\AccessControlController::class, 'toggleUserStatus'])->middleware('permission:user.edit')->name('users.toggle-status');
        });

        // Panduan Singkat
        Route::view('panduan', 'admin.panduan.index')->middleware('permission:panduan.view')->name('panduan');
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
