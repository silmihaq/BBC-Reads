<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Pustakawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_sekolah'    => Setting::get('nama_sekolah', 'SMP NEGERI 3 BABAKAN CIKAO'),
            'alamat_sekolah'  => Setting::get('alamat_sekolah', 'Jl. Raya Babakan Cikao, Kab. Purwakarta, Jawa Barat'),
            'telepon_sekolah' => Setting::get('telepon_sekolah', '-'),
            'email_sekolah'   => Setting::get('email_sekolah', '-'),
        ];

        $pustakawans = Pustakawan::latest()->get();

        return view('admin.setting.index', compact('settings', 'pustakawans'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'    => 'required|string|max:255',
            'alamat_sekolah'  => 'required|string',
            'telepon_sekolah' => 'nullable|string|max:50',
            'email_sekolah'   => 'nullable|email|max:100',
        ]);

        $fields = ['nama_sekolah', 'alamat_sekolah', 'telepon_sekolah', 'email_sekolah'];

        foreach ($fields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $request->input($field)]
            );
        }

        return back()->with('success', 'Informasi sekolah berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password administrator berhasil diubah.');
    }
}