<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori buku.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('bukus')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar.',
        ]);

        $validated['slug'] = Str::slug($request->nama_kategori);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar.',
        ]);

        $validated['slug'] = Str::slug($request->nama_kategori);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori buku berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        if ($kategori->bukus()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data buku.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori buku berhasil dihapus.');
    }
}