<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaultSettings = [
            'nama_sekolah'         => 'SMP NEGERI 3 BABAKAN CIKAO',
            'alamat_sekolah'       => 'Jl. Raya Babakan Cikao, Kab. Purwakarta, Jawa Barat',
            'telepon_sekolah'      => '(0264) 123456',
            'email_sekolah'        => 'info@smpn3babakancikao.sch.id',
            'nama_kepala_perpus'    => 'Nuraeni, S.Pd.',
            'nip_kepala_perpus'     => '19820315 200801 2 004',
            'sambutan_pustakawan'  => 'Selamat datang di Perpustakaan Digital BBC-Reads. Kami berkomitmen untuk menyediakan akses literasi digital yang inklusif, cepat, dan mudah bagi seluruh sivitas akademika sekolah.',
            'foto_pustakawan'      => null,
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}