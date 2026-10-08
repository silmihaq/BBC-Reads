<x-admin-layout>
    <x-slot:title>Edit Buku | BBC-Reads Admin</x-slot:title>

    <!-- Header & Navigation Back -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Buku
            </a>
            <h2 class="text-2xl font-bold text-white tracking-wide">Edit Data Buku</h2>
            <p class="text-slate-400 text-sm mt-1">Ubah informasi atau ketersediaan stok buku</p>
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
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Buku -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penulis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Penulis / Pengarang <span class="text-rose-500">*</span></label>
                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Penerbit <span class="text-rose-500">*</span></label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-cyan-500 transition">
                        <option value="fiksi" {{ old('kategori', $buku->kategori) == 'fiksi' ? 'selected' : '' }}>Fiksi / Novel</option>
                        <option value="non-fiksi" {{ old('kategori', $buku->kategori) == 'non-fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                        <option value="pelajaran" {{ old('kategori', $buku->kategori) == 'pelajaran' ? 'selected' : '' }}>Buku Pelajaran</option>
                        <option value="referensi" {{ old('kategori', $buku->kategori) == 'referensi' ? 'selected' : '' }}>Kamus & Referensi</option>
                    </select>
                </div>

                <!-- ISBN -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nomor ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Tahun Terbit -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="2026" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jumlah Stok Buku <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" min="0" required 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Sampul saat ini & Input Upload -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Foto Sampul Buku</label>
                    @if ($buku->sampul)
                        <div class="flex items-center gap-4 mb-3 p-3 rounded-xl bg-slate-900 border border-slate-800 w-fit">
                            <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="w-12 h-16 object-cover rounded border border-slate-700">
                            <div>
                                <p class="text-xs text-white font-medium">Sampul Saat Ini</p>
                                <p class="text-[10px] text-slate-500">Upload file baru jika ingin mengganti</p>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="sampul" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-cyan-400 hover:file:bg-slate-700">
                </div>

                <!-- Sinopsis -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ringkasan / Sinopsis Buku</label>
                    <textarea name="sinopsis" rows="4" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-cyan-500 transition">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('admin.buku.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-800 text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition cursor-pointer flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Update Buku
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>