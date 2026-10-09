<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\AuthController;

// Halaman Utama Publik (Mendukung panggilan route('home') maupun route('user.home'))
Route::get('/', function () {
    return view('user.home');
})->name('home');

// Alias Route 'user.home' agar link berbasis route('user.home') tidak error
Route::get('/home', function () {
    return view('user.home');
})->name('user.home');

// Route Authentication Admin (Tanpa Prefix Name Agar Memiliki Route 'login' Default)
Route::middleware(['guest'])->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Alias Route 'admin.login' (Agar Link Berbasis admin.login Tetap Berfungsi)
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');

// Grup Route Admin (Auth Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Modules
    Route::resource('siswa', SiswaController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);

    // Transaksi Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});