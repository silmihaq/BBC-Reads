<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Setting;
use App\Models\Pustakawan;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SaranController;
use App\Http\Controllers\Admin\PustakawanController;

// ==========================================
// PUBLIC / USER ROUTES
// ==========================================
Route::get('/', function (Request $request) {
    $query = Buku::query();

    if (class_exists(Kategori::class)) {
        $query->with('kategori');
    }

    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%");
        });
    }

    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    $bukus = $query->latest()->get();
    $kategoris = class_exists(Kategori::class) ? Kategori::all() : collect();

    // Mengambil Informasi Sekolah & Seluruh Pustakawan
    $namaSekolah    = Setting::get('nama_sekolah', 'SMP NEGERI 3 BABAKAN CIKAO');
    $alamatSekolah  = Setting::get('alamat_sekolah', 'Jl. Raya Babakan Cikao, Kab. Purwakarta');
    $teleponSekolah = Setting::get('telepon_sekolah');
    $emailSekolah   = Setting::get('email_sekolah');
    $pustakawans    = Pustakawan::all();

    return view('user.home', compact(
        'bukus',
        'kategoris',
        'namaSekolah',
        'alamatSekolah',
        'teleponSekolah',
        'emailSekolah',
        'pustakawans'
    ));
})->name('user.home');

Route::post('/saran', [SaranController::class, 'store'])->name('saran.store');

Route::get('/buku/{id}', function ($id) {
    $buku = Buku::with('kategori')->findOrFail($id);
    return response()->json($buku);
})->name('user.buku.detail');

// ==========================================
// ADMIN AUTHENTICATION ROUTES
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// ADMIN PANEL PROTECTED ROUTES
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Data Master
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('siswa', SiswaController::class);

    // Transaksi Peminjaman & Pengembalian
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    Route::get('/pengembalian', [PeminjamanController::class, 'pengembalianIndex'])->name('pengembalian.index');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/{id}/hilang', [PeminjamanController::class, 'laporkanHilang'])->name('peminjaman.hilang');
    Route::post('/peminjaman/{id}/ganti-buku', [PeminjamanController::class, 'gantiBuku'])->name('peminjaman.ganti-buku');

    // Modul Laporan PDF
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/pdf', [LaporanController::class, 'downloadPdf'])->name('laporan.pdf');

    // Modul Pengaturan System & Tim Pustakawan
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/setting/password', [SettingController::class, 'updatePassword'])->name('setting.password');

    Route::post('/pustakawan', [PustakawanController::class, 'store'])->name('pustakawan.store');
    Route::delete('/pustakawan/{id}', [PustakawanController::class, 'destroy'])->name('pustakawan.destroy');

    // Modul Saran & Masukan
    Route::get('/saran', [SaranController::class, 'index'])->name('saran.index');
    Route::delete('/saran/{id}', [SaranController::class, 'destroy'])->name('saran.destroy');
});