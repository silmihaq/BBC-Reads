<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'buku_id',
        'kode_transaksi',
        'nama_peminjam',
        'nisn',
        'kelas',
        'tgl_pinjam',
        'tgl_tenggat',
        'tgl_kembali',
        'status',
        'denda',
        'catatan',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_tenggat' => 'date',
        'tgl_kembali' => 'date',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}