@extends('components.admin-layout')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Edit Buku</h2>
            <p class="text-slate-400 text-sm mt-1">Perbarui informasi detail dan cover buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.buku.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs space-y-1">
            <div class="font-bold">Gagal memperbarui data:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6 rounded-2xl bg-slate-950/60 border border-slate-800">
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Buku -->
                <div class="space-y-2">
                    <label for="judul" class="block text-xs font-semibold text-slate-300">Judul Buku <span class="text-rose-400">*</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $buku->judul) }}" required
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Kategori Buku (Dynamic Select) -->
                <div class="space-y-2">
                    <label for="kategori_id" class="block text-xs font-semibold text-slate-300">Kategori Buku <span class="text-rose-400">*</span></label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Penulis -->
                <div class="space-y-2">
                    <label for="penulis" class="block text-xs font-semibold text-slate-300">Penulis / Pengarang</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $buku->penulis) }}"
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penerbit -->
                <div class="space-y-2">
                    <label for="penerbit" class="block text-xs font-semibold text-slate-300">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Tahun Terbit -->
                <div class="space-y-2">
                    <label for="tahun_terbit" class="block text-xs font-semibold text-slate-300">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" placeholder="Contoh: 2024"
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Stok -->
                <div class="space-y-2">
                    <label for="stok" class="block text-xs font-semibold text-slate-300">Jumlah Stok <span class="text-rose-400">*</span></label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $buku->stok) }}" min="0" required
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">
                </div>
            </div>

            <!-- Upload Cover File -->
            <div class="space-y-2">
                <label for="cover" class="block text-xs font-semibold text-slate-300">Cover Buku (JPG, PNG, WEBP max 2MB)</label>
                <div class="flex items-center gap-4">
                    @if ($buku->cover && file_exists(public_path('storage/' . $buku->cover)))
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Preview" class="w-12 h-16 object-cover rounded-lg border border-slate-800 shrink-0">
                    @endif
                    <input type="file" name="cover" id="cover" accept="image/*"
                        class="w-full px-4 py-2 bg-slate-900 border border-slate-800 rounded-xl text-slate-400 text-xs file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-500/10 file:text-cyan-400 hover:file:bg-cyan-500/20 cursor-pointer">
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <label for="deskripsi" class="block text-xs font-semibold text-slate-300">Deskripsi / Sinopsis</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 text-xs focus:outline-none focus:border-cyan-500 transition">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800/80">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection