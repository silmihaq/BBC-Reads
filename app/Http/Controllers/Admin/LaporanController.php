<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman filter laporan.
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Memproses filter data dan langsung mengunduh file PDF.
     */
    public function downloadPdf(Request $request)
    {
        $request->validate([
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'tgl_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tgl_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $tglMulai   = $request->tgl_mulai;
        $tglSelesai = $request->tgl_selesai;

        // Query data peminjaman berdasarkan rentang tanggal
        $query = Peminjaman::whereBetween('created_at', [$tglMulai . ' 00:00:00', $tglSelesai . ' 23:59:59']);

        // Load relasi siswa & buku secara fleksibel
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

        $laporans = $query->latest()->get();

        // Render PDF dengan kertas A4 Portrait
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporans', 'tglMulai', 'tglSelesai'))
                  ->setPaper('a4', 'portrait');

        $fileName = 'Laporan_Peminjaman_' . $tglMulai . '_s.d_' . $tglSelesai . '.pdf';

        // Mengunduh langsung file PDF
        return $pdf->download($fileName);
    }
}