<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PemberkasanController;

Route::get('/pemberkasan', [PemberkasanController::class, 'index'])->name('pemberkasan.index');
// nanti: Route::post('/pemberkasan', [PemberkasanController::class, 'store'])->name('pemberkasan.store');

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman target
Route::get('/pemberkasan', [PageController::class, 'pemberkasan'])->name('pemberkasan.index');
Route::get('/mitra',       [PageController::class, 'mitra'])->name('mitra.index');
Route::get('/profile',     [PageController::class, 'profile'])->name('profile.show');
Route::get('/settings',    [PageController::class, 'settings'])->name('settings.index');


Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);