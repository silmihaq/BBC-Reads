<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar data siswa.
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
        }

        $siswas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Menampilkan form tambah siswa.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn'          => 'required|numeric|unique:siswas,nisn',
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.numeric'           => 'NISN harus berupa angka.',
            'nisn.unique'            => 'NISN sudah terdaftar.',
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'kelas.required'         => 'Kelas wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit siswa.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nisn'          => 'required|numeric|unique:siswas,nisn,' . $id,
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
        ], [
            'nisn.required'          => 'NISN wajib diisi.',
            'nisn.numeric'           => 'NISN harus berupa angka.',
            'nisn.unique'            => 'NISN sudah digunakan oleh siswa lain.',
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'kelas.required'         => 'Kelas wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}