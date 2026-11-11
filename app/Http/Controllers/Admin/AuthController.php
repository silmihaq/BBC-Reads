<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Buku;
use App\Models\Peminjaman;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Memproses otentikasi/login admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan Dashboard Admin dengan grafik tren bulanan & statistik.
     */
    public function dashboard()
    {
        // 1. Master Data Counts
        $totalSiswa = class_exists(Siswa::class) ? Siswa::count() : 0;
        $totalBuku  = class_exists(Buku::class) ? Buku::count() : 0;

        // 2. Transaction Status Counts
        $totalDipinjam   = class_exists(Peminjaman::class) ? Peminjaman::where('status', 'dipinjam')->count() : 0;
        $totalPeminjaman = class_exists(Peminjaman::class) ? Peminjaman::count() : 0;
        $totalSelesai    = class_exists(Peminjaman::class) ? Peminjaman::whereIn('status', ['kembali', 'dikembalikan', 'selesai'])->count() : 0;

        // 3. Peminjaman Terbaru
        $peminjamanTerbaru = collect();
        if (class_exists(Peminjaman::class)) {
            $query = Peminjaman::query();
            $peminjamanInstance = new Peminjaman();
            $relations = [];

            if (method_exists($peminjamanInstance, 'siswa')) {
                $relations[] = 'siswa';
            } elseif (method_exists($peminjamanInstance, 'anggota')) {
                $relations[] = 'anggota';
            } elseif (method_exists($peminjamanInstance, 'user')) {
                $relations[] = 'user';
            }

            if (method_exists($peminjamanInstance, 'buku')) {
                $relations[] = 'buku';
            }

            if (!empty($relations)) {
                $query->with($relations);
            }

            $peminjamanTerbaru = $query->latest()->take(5)->get();
        }

        // 4. Hitung Data Grafik Peminjaman Per Bulan (Jan - Des Tahun Ini)
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $grafikData  = array_fill(0, 12, 0);

        if (class_exists(Peminjaman::class)) {
            $tahunIni = date('Y');
            $peminjamanPerBulan = Peminjaman::select(
                DB::raw('DATE_FORMAT(created_at, "%m") as bulan'),
                DB::raw('count(*) as total')
            )
            ->whereYear('created_at', $tahunIni)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

            foreach ($peminjamanPerBulan as $bulan => $total) {
                $index = (int)$bulan - 1;
                if ($index >= 0 && $index < 12) {
                    $grafikData[$index] = (int)$total;
                }
            }
        }

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalBuku',
            'totalDipinjam',
            'totalPeminjaman',
            'totalSelesai',
            'peminjamanTerbaru',
            'bulanLabels',
            'grafikData'
        ));
    }

    /**
     * Memproses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}