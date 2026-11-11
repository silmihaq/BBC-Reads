<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function downloadPdf(Request $request)
    {
        $request->validate([
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tglMulai   = $request->tgl_mulai;
        $tglSelesai = $request->tgl_selesai;

        // Query data peminjaman
        $laporans = Peminjaman::with('buku')
            ->whereBetween('tgl_pinjam', [$tglMulai, $tglSelesai])
            ->orWhereBetween('created_at', [$tglMulai . ' 00:00:00', $tglSelesai . ' 23:59:59'])
            ->latest()
            ->get();

        // Ambil data setting dengan nilai default agar tidak null/error
        $namaSekolah      = Setting::get('nama_sekolah', 'SMP NEGERI 3 BABAKAN CIKAO');
        $alamatSekolah    = Setting::get('alamat_sekolah', 'Jl. Raya Babakan Cikao, Kab. Purwakarta, Jawa Barat');
        $namaKepalaPerpus  = Setting::get('nama_kepala_perpus', 'Nuraeni, S.Pd.');
        $nipKepalaPerpus   = Setting::get('nip_kepala_perpus', '-');

        // Pastikan semua variabel terkirim lewat compact
        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'laporans',
            'tglMulai',
            'tglSelesai',
            'namaSekolah',
            'alamatSekolah',
            'namaKepalaPerpus',
            'nipKepalaPerpus'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Peminjaman_' . $tglMulai . '_sd_' . $tglSelesai . '.pdf');
    }
}