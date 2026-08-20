<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleAuthController;

Route::view('/', 'welcome');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'pasien.dashboard')->name('dashboard');
    Route::view('pasien/dashboard', 'pasien.dashboard')->name('pasien.dashboard');
    Route::view('admin/dashboard', 'dashboard')->name('admin.dashboard');
    Route::view('antrian', 'antrian.index')->name('antrian.index');
    Route::view('antrian/detail', 'antrian.detail')->name('antrian.detail');
    Route::view('jadwal-dokter', 'jadwal.index')->name('jadwal.index');
    Route::view('rekam-medis', 'rekam-medis.index')->name('rekam-medis.index');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

use App\Livewire\Actions\Logout;

Route::post('logout', function (Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';

