@extends('components.admin-layout')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Siswa
            </a>
            <h2 class="text-2xl font-bold text-white tracking-wide">Edit Data Siswa</h2>
            <p class="text-slate-400 text-sm mt-1">Perbarui informasi data siswa terdaftar di perpustakaan</p>
        </div>
    </div>

    <!-- Alert Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs space-y-1 max-w-4xl">
            <p class="font-bold flex items-center gap-2 mb-1">
                <i data-lucide="alert-circle" class="w-4 h-4"></i> Terjadi kesalahan input:
            </p>
            <ul class="list-disc list-inside space-y-0.5 text-slate-300">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="p-6 md:p-8 rounded-2xl bg-slate-950/60 border border-slate-800 max-w-4xl">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NISN -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">NISN <span class="text-rose-500">*</span></label>
                    <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required placeholder="Contoh: 0012345678" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required placeholder="Contoh: Ahmad Rizky" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kelas <span class="text-rose-500">*</span></label>
                    <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required placeholder="Contoh: X RPL 1" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-cyan-500 transition">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('admin.siswa.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-800 text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition cursor-pointer flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection