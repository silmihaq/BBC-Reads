<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    /**
     * Relasi ke model Buku (Satu kategori bisa memiliki banyak buku)
     */
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}