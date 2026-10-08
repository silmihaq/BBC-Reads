<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index()
    {
        $bukus = Buku::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'penerbit'  => 'required|string|max:255',
            'tahun'     => 'required|numeric|digits:4',
            'stok'      => 'required|integer|min:0',
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

        Buku::create($validated);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);

        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'penerbit'  => 'required|string|max:255',
            'tahun'     => 'required|numeric|digits:4',
            'stok'      => 'required|integer|min:0',
        ], [
            'judul.required'    => 'Judul buku wajib diisi.',
            'penulis.required'  => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun.required'    => 'Tahun terbit wajib diisi.',
            'stok.required'     => 'Jumlah stok wajib diisi.',
        ]);

        $buku->update($validated);

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