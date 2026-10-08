<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan form tambah transaksi peminjaman.
     */
    public function create()
    {
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul', 'asc')->get();

        return view('admin.peminjaman.create', compact('siswas', 'bukus'));
    }

    /**
     * Menyimpan transaksi peminjaman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn'          => 'required|string',
            'nama_peminjam' => 'required|string',
            'kelas'         => 'required|string',
            'buku_id'       => 'required|exists:bukus,id',
            'tgl_pinjam'    => 'required|date',
            'tgl_tenggat'   => 'required|date|after_or_equal:tgl_pinjam',
        ], [
            'nisn.required'          => 'NISN wajib diisi/dipilih.',
            'nama_peminjam.required' => 'Nama peminjam wajib diisi/dipilih.',
            'kelas.required'         => 'Kelas wajib diisi/dipilih.',
            'buku_id.required'       => 'Buku wajib dipilih.',
            'buku_id.exists'         => 'Buku yang dipilih tidak valid.',
            'tgl_pinjam.required'    => 'Tanggal pinjam wajib diisi.',
            'tgl_tenggat.required'   => 'Tenggat pengembalian wajib diisi.',
            'tgl_tenggat.after_or_equal' => 'Tenggat pengembalian tidak boleh sebelum tanggal pinjam.',
        ]);

        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        Peminjaman::create([
            'kode_transaksi' => $kodeTransaksi,
            'nisn'           => $request->nisn,
            'nama_peminjam'  => $request->nama_peminjam,
            'kelas'          => $request->kelas,
            'buku_id'        => $request->buku_id,
            'tgl_pinjam'     => $request->tgl_pinjam,
            'tgl_tenggat'    => $request->tgl_tenggat,
            'status'         => 'dipinjam',
            'denda'          => 0,
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Transaksi peminjaman berhasil ditambahkan.');
    }

    /**
     * Memproses pengembalian buku.
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $now = Carbon::now();
        $tenggat = Carbon::parse($peminjaman->tgl_tenggat);
        $denda = 0;

        if ($now->greaterThan($tenggat)) {
            $hariTerlambat = $now->diffInDays($tenggat);
            $denda = $hariTerlambat * 1000;
        }

        $peminjaman->update([
            'status'      => 'dikembalikan',
            'tgl_kembali' => $now->toDateString(),
            'denda'       => $denda,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}