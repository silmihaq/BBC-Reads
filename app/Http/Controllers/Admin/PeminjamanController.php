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
     * Menampilkan daftar transaksi peminjaman aktif.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with('buku');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('buku', function ($bukuQuery) use ($search) {
                      $bukuQuery->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan halaman Pengembalian & Denda.
     */
    public function pengembalianIndex(Request $request)
    {
        $query = Peminjaman::with('buku');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('buku', function ($bukuQuery) use ($search) {
                      $bukuQuery->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $pengembalians = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.pengembalian.index', compact('pengembalians'));
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
     * Memproses pengembalian buku secara normal.
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (strtolower($peminjaman->status) === 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $now = Carbon::now();

        $peminjaman->update([
            'status'      => 'dikembalikan',
            'tgl_kembali' => $now->toDateString(),
            'denda'       => 0,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Memproses laporan buku hilang (Denda otomatis: Wajib Ganti Buku).
     */
    public function laporkanHilang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status'           => 'hilang',
            'denda_keterangan' => 'Wajib Ganti Buku',
        ]);

        return redirect()->back()->with('success', 'Status diubah menjadi Buku Hilang. Denda otomatis diset ke "Wajib Ganti Buku".');
    }

    /**
     * Memproses penyelesaian denda ganti buku (Status denda menjadi Sudah Diganti).
     */
    public function gantiBuku($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $now = Carbon::now();

        $peminjaman->update([
            'status'           => 'dikembalikan',
            'tgl_kembali'      => $now->toDateString(),
            'denda_keterangan' => 'Sudah Diganti',
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->back()->with('success', 'Buku pengganti telah diterima. Status denda kini "Sudah Diganti".');
    }
}