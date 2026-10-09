<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
        }

        $bukus = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('admin.buku.create', compact('kategoris'));
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'required|string|max:255',
            'tahun'       => 'required|numeric|digits:4',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'nullable',
            'isbn'        => 'nullable|string',
            'sinopsis'    => 'nullable|string',
        ], [
            'judul.required'    => 'Judul buku wajib diisi.',
            'penulis.required'  => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun.required'    => 'Tahun terbit wajib diisi.',
            'tahun.numeric'     => 'Tahun terbit harus berupa angka.',
            'tahun.digits'      => 'Tahun terbit harus 4 digit angka.',
            'stok.required'     => 'Jumlah stok wajib diisi.',
            'stok.integer'      => 'Jumlah stok harus berupa angka.',
        ]);

        $namaKategori = 'Umum';
        if ($request->filled('kategori_id')) {
            $kat = Kategori::find($request->kategori_id);
            if ($kat) {
                $namaKategori = $kat->nama_kategori;
            }
        }

        // HANYA gunakan 'tahun_terbit' (karena kolom di DB adalah tahun_terbit)
        Buku::create([
            'judul'        => $validated['judul'],
            'penulis'      => $validated['penulis'],
            'penerbit'     => $validated['penerbit'],
            'tahun_terbit' => $validated['tahun'], 
            'stok'         => $validated['stok'],
            'kategori'     => $namaKategori,
            'isbn'         => $request->isbn,
            'sinopsis'     => $request->sinopsis,
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Memperbarui data buku.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'required|string|max:255',
            'tahun'       => 'required|numeric|digits:4',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'nullable',
            'isbn'        => 'nullable|string',
            'sinopsis'    => 'nullable|string',
        ], [
            'judul.required'    => 'Judul buku wajib diisi.',
            'penulis.required'  => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun.required'    => 'Tahun terbit wajib diisi.',
            'stok.required'     => 'Jumlah stok wajib diisi.',
        ]);

        $namaKategori = $buku->kategori ?? 'Umum';
        if ($request->filled('kategori_id')) {
            $kat = Kategori::find($request->kategori_id);
            if ($kat) {
                $namaKategori = $kat->nama_kategori;
            }
        }

        $buku->update([
            'judul'        => $validated['judul'],
            'penulis'      => $validated['penulis'],
            'penerbit'     => $validated['penerbit'],
            'tahun_terbit' => $validated['tahun'],
            'stok'         => $validated['stok'],
            'kategori'     => $namaKategori,
            'isbn'         => $request->isbn,
            'sinopsis'     => $request->sinopsis,
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus data buku.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil dihapus.');
    }
}