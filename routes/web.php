<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PeminjamanController;

/*
|--------------------------------------------------------------------------
| Web Routes - BBC-Reads Admin Panel
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin Group Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Routes (Login & Logout)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Route
    Route::get('/dashboard', function () {
        return redirect()->route('admin.peminjaman.index');
    })->name('dashboard');

    // 1. Modul Buku
    Route::resource('buku', BukuController::class);

    // 2. Modul Kategori
    Route::resource('kategori', KategoriController::class);

    // 3. Modul Siswa
    Route::resource('siswa', SiswaController::class);

    // 4. Modul Peminjaman & Pengembalian
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // 5. Modul Pengembalian & Denda
    Route::get('/pengembalian', [PeminjamanController::class, 'pengembalianIndex'])->name('pengembalian.index');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/{id}/hilang', [PeminjamanController::class, 'laporkanHilang'])->name('peminjaman.hilang');
    Route::post('/peminjaman/{id}/ganti-buku', [PeminjamanController::class, 'gantiBuku'])->name('peminjaman.ganti-buku');

});