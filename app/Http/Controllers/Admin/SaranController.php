<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saran;

class SaranController extends Controller
{
    public function index()
    {
        $sarans = Saran::latest()->paginate(10);
        Saran::where('is_read', false)->update(['is_read' => true]);

        return view('admin.saran.index', compact('sarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email_or_nisn' => 'nullable|string|max:100',
            'pesan'         => 'required|string',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'pesan.required' => 'Pesan masukan tidak boleh kosong.',
        ]);

        Saran::create([
            'nama'          => $request->nama,
            'email_or_nisn' => $request->email_or_nisn,
            'pesan'         => $request->pesan,
            'is_read'        => false,
        ]);

        return back()->with('success', 'Saran dan masukan Anda berhasil terkirim.');
    }

    public function destroy($id)
    {
        $saran = Saran::findOrFail($id);
        $saran->delete();

        return back()->with('success', 'Pesan masukan berhasil dihapus.');
    }
}