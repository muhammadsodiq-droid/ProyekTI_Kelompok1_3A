<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PemberkasanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaturanController;

Route::middleware('auth')->group(function () {
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/change-password', [PengaturanController::class, 'changePassword'])->name('pengaturan.changePassword');
});


// Profile (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.uploadPhoto');
    Route::post('/profile/reset-photo', [ProfileController::class, 'resetPhoto'])->name('profile.resetPhoto');
});

// Pemberkasan
Route::get('/pemberkasan', [PemberkasanController::class, 'index'])->name('pemberkasan.index');
// nanti bisa tambah: Route::post('/pemberkasan', [PemberkasanController::class, 'store'])->name('pemberkasan.store');

// Dashboard
Route::get('/', fn() => redirect()->route('dashboard'));
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman statis lain (tanpa tabrakan profile lagi)
Route::get('/mitra',    [PageController::class, 'mitra'])->name('mitra.index');
Route::get('/settings', [PageController::class, 'settings'])->name('settings.index');

// Welcome page
Route::get('/welcome', function () {
    return view('welcome');
});

// Auth
Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');
