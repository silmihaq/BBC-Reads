<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->string('kode_transaksi');
            $table->string('nama_peminjam');
            $table->string('nisn')->nullable();
            $table->string('kelas');
            $table->date('tgl_pinjam');
            $table->date('tgl_tenggat');
            $table->date('tgl_kembali')->nullable();
            $table->string('status')->default('dipinjam'); // dipinjam, dikembalikan, hilang
            $table->decimal('denda', 10, 2)->default(0);
            $table->string('denda_keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};