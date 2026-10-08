<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Admin.
     */
    public function index()
    {
        $totalSiswa = class_exists(Siswa::class) ? Siswa::count() : 0;
        $totalBuku = class_exists(Buku::class) ? Buku::count() : 0;
        $totalDipinjam = class_exists(Peminjaman::class) ? Peminjaman::where('status', 'dipinjam')->count() : 0;
        $totalSelesai = class_exists(Peminjaman::class) ? Peminjaman::where('status', 'dikembalikan')->count() : 0;

        $peminjamanTerbaru = class_exists(Peminjaman::class) 
            ? Peminjaman::with('buku')->orderBy('created_at', 'desc')->take(5)->get() 
            : collect([]);

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalBuku',
            'totalDipinjam',
            'totalSelesai',
            'peminjamanTerbaru'
        ));
    }
}