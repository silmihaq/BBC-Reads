<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($kat) use ($search) {
                      $kat->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $bukus = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penulis'     => 'nullable|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'tahun_terbit'=> 'nullable|numeric',
            'stok'        => 'required|integer|min:0',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'   => 'nullable|string',
        ], [
            'judul.required'       => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Silakan pilih kategori buku.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'stok.required'        => 'Stok buku wajib diisi.',
            'stok.integer'         => 'Stok harus berupa angka.',
            'cover.image'          => 'File cover harus berupa gambar.',
            'cover.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Buku::create([
            'judul'       => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penulis'     => $request->penulis,
            'penerbit'    => $request->penerbit,
            'tahun_terbit'=> $request->tahun_terbit,
            'stok'        => $request->stok,
            'cover'       => $coverPath,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penulis'     => 'nullable|string|max:255',
            'penerbit'    => 'nullable|string|max:255',
            'tahun_terbit'=> 'nullable|numeric',
            'stok'        => 'required|integer|min:0',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'   => 'nullable|string',
        ], [
            'judul.required'       => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Silakan pilih kategori buku.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'stok.required'        => 'Stok buku wajib diisi.',
            'stok.integer'         => 'Stok harus berupa angka.',
            'cover.image'          => 'File cover harus berupa gambar.',
            'cover.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $coverPath = $buku->cover;
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $buku->update([
            'judul'       => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penulis'     => $request->penulis,
            'penerbit'    => $request->penerbit,
            'tahun_terbit'=> $request->tahun_terbit,
            'stok'        => $request->stok,
            'cover'       => $coverPath,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}