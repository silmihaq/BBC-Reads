<x-admin-layout>
    <x-slot:title>Tambah Transaksi Peminjaman | BBC-Reads Admin</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <!-- Header & Kembali -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-wide">Tambah Transaksi Peminjaman</h2>
                <p class="text-slate-400 text-sm mt-1">Pilih anggota dan buku yang akan dipinjam</p>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 font-semibold text-xs border border-slate-800 transition flex items-center gap-2 cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Alert Error Global -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs space-y-1">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span>Terjadi kesalahan pengisian form:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-slate-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Form -->
        <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-6 md:p-8">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- SEKSI 1: PILIH ANGGOTA (AUTO FILL) -->
                <div class="p-4 rounded-xl bg-slate-900/50 border border-slate-800 space-y-4">
                    <div class="flex items-center gap-2 text-cyan-400 font-bold text-xs uppercase tracking-wider mb-2">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                        <span>Data Peminjam / Anggota</span>
                    </div>

                    <!-- Dropdown Pilih Siswa -->
                    <div>
                        <label for="select-siswa" class="block text-xs font-semibold text-slate-300 mb-2">
                            Pilih Siswa / Anggota Terdaftar <span class="text-rose-400">*</span>
                        </label>
                        <select id="select-siswa" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-500 transition cursor-pointer">
                            <option value="">-- Cari NISN / Nama Siswa --</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}" 
                                        data-nisn="{{ $siswa->nisn }}" 
                                        data-nama="{{ $siswa->nama }}" 
                                        data-kelas="{{ $siswa->kelas }}">
                                    {{ $siswa->nisn }} — {{ $siswa->nama }} ({{ $siswa->kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Auto-Filled (Readonly) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1">NISN</label>
                            <input type="text" id="input-nisn" name="nisn" value="{{ old('nisn') }}" readonly required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-cyan-400 font-mono font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1">Nama Peminjam</label>
                            <input type="text" id="input-nama" name="nama_peminjam" value="{{ old('nama_peminjam') }}" readonly required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-400 mb-1">Kelas</label>
                            <input type="text" id="input-kelas" name="kelas" value="{{ old('kelas') }}" readonly required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-slate-300 font-semibold cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: PILIH BUKU & TANGGAL -->
                <div class="space-y-6">
                    <!-- Pilih Buku -->
                    <div>
                        <label for="buku_id" class="block text-xs font-semibold text-slate-300 mb-2">
                            Pilih Buku yang Dipinjam <span class="text-rose-400">*</span>
                        </label>
                        <select id="buku_id" name="buku_id" required class="w-full bg-slate-900 border @error('buku_id') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-500 transition cursor-pointer">
                            <option value="" disabled selected>-- Pilih Buku --</option>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pinjam & Tenggat -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tgl_pinjam" class="block text-xs font-semibold text-slate-300 mb-2">
                                Tanggal Pinjam <span class="text-rose-400">*</span>
                            </label>
                            <input type="date" 
                                   id="tgl_pinjam" 
                                   name="tgl_pinjam" 
                                   value="{{ old('tgl_pinjam', date('Y-m-d')) }}" 
                                   required 
                                   class="w-full bg-slate-900 border @error('tgl_pinjam') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                            @error('tgl_pinjam')
                                <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tgl_tenggat" class="block text-xs font-semibold text-slate-300 mb-2">
                                Tenggat Pengembalian <span class="text-rose-400">*</span>
                            </label>
                            <input type="date" 
                                   id="tgl_tenggat" 
                                   name="tgl_tenggat" 
                                   value="{{ old('tgl_tenggat', date('Y-m-d', strtotime('+7 days'))) }}" 
                                   required 
                                   class="w-full bg-slate-900 border @error('tgl_tenggat') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                            @error('tgl_tenggat')
                                <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.peminjaman.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition cursor-pointer">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition cursor-pointer flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Proses Peminjaman</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT AUTO-FILL SISWA -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectSiswa = document.getElementById('select-siswa');
            const inputNisn = document.getElementById('input-nisn');
            const inputNama = document.getElementById('input-nama');
            const inputKelas = document.getElementById('input-kelas');

            selectSiswa.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                
                inputNisn.value = selected.getAttribute('data-nisn') || '';
                inputNama.value = selected.getAttribute('data-nama') || '';
                inputKelas.value = selected.getAttribute('data-kelas') || '';
            });
        });
    </script>
</x-admin-layout>