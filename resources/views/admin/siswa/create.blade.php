@extends('components.admin-layout')

@section('content')
    <x-slot:title>Tambah Siswa Baru | BBC-Reads Admin</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <!-- Header & Kembali -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-wide">Tambah Siswa Baru</h2>
                <p class="text-slate-400 text-sm mt-1">Daftarkan anggota/siswa baru ke dalam sistem perpustakaan</p>
            </div>
            <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 font-semibold text-xs border border-slate-800 transition flex items-center gap-2 cursor-pointer">
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
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- NISN -->
                <div>
                    <label for="nisn" class="block text-xs font-semibold text-slate-300 mb-2">
                        NISN <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="nisn" 
                           name="nisn" 
                           value="{{ old('nisn') }}" 
                           placeholder="Contoh: 0051234567" 
                           required 
                           class="w-full bg-slate-900 border @error('nisn') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white placeholder:text-slate-600 focus:outline-none focus:border-cyan-500 transition font-mono">
                    @error('nisn')
                        <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-xs font-semibold text-slate-300 mb-2">
                        Nama Lengkap Siswa <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}" 
                           placeholder="Masukkan nama lengkap siswa" 
                           required 
                           class="w-full bg-slate-900 border @error('nama') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white placeholder:text-slate-600 focus:outline-none focus:border-cyan-500 transition">
                    @error('nama')
                        <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid Kelas & Jenis Kelamin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kelas -->
                    <div>
                        <label for="kelas" class="block text-xs font-semibold text-slate-300 mb-2">
                            Kelas <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" 
                               id="kelas" 
                               name="kelas" 
                               value="{{ old('kelas') }}" 
                               placeholder="Contoh: X RPL 1, XI TKJ 2" 
                               required 
                               class="w-full bg-slate-900 border @error('kelas') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white placeholder:text-slate-600 focus:outline-none focus:border-cyan-500 transition">
                        @error('kelas')
                            <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-semibold text-slate-300 mb-2">
                            Jenis Kelamin <span class="text-rose-400">*</span>
                        </label>
                        <select id="jenis_kelamin" 
                                name="jenis_kelamin" 
                                required 
                                class="w-full bg-slate-900 border @error('jenis_kelamin') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-cyan-500 transition cursor-pointer">
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-[11px] text-rose-400 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.siswa.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition cursor-pointer">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition cursor-pointer flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Data Siswa</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection