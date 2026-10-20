<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pustakawan;
use Illuminate\Support\Facades\Storage;

class PustakawanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nip'      => 'nullable|string|max:100',
            'jabatan'  => 'required|string|max:100',
            'sambutan' => 'nullable|string',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama', 'nip', 'jabatan', 'sambutan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pustakawan', 'public');
        }

        Pustakawan::create($data);

        return back()->with('success', 'Data pustakawan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pustakawan = Pustakawan::findOrFail($id);

        if ($pustakawan->foto && Storage::disk('public')->exists($pustakawan->foto)) {
            Storage::disk('public')->delete($pustakawan->foto);
        }

        $pustakawan->delete();

        return back()->with('success', 'Data pustakawan berhasil dihapus.');
    }
}