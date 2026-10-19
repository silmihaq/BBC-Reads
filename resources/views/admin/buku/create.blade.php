@extends('components.admin-layout')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Buku
            </a>
            <h2 class="text-2xl font-bold text-white tracking-wide">Tambah Buku Baru</h2>
            <p class="text-slate-400 text-sm mt-1">Tambahkan koleksi buku baru ke dalam katalog perpustakaan</p>
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
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Buku -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Laskar Pelangi" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penulis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Penulis / Pengarang <span class="text-rose-500">*</span></label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" required placeholder="Contoh: Andrea Hirata" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penerbit -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Penerbit <span class="text-rose-500">*</span></label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" required placeholder="Contoh: Bentang Pustaka" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Tahun Terbit -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tahun Terbit <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" required placeholder="Contoh: 2005" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jumlah Stok <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" required min="0" placeholder="Contoh: 10" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kategori Buku</label>
                    <select name="kategori_id" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-cyan-500 transition">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Upload Foto Sampul -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Foto Sampul Buku (Opsional)</label>
                <div class="relative border-2 border-dashed border-slate-800 rounded-2xl p-6 text-center hover:border-cyan-500/50 transition cursor-pointer bg-slate-900/30 group" id="drop-zone">
                    <input type="file" name="sampul" id="sampul-input" accept="image/png, image/jpeg, image/jpg, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    
                    <!-- Default State Container -->
                    <div id="upload-placeholder" class="space-y-2">
                        <div class="w-12 h-12 rounded-xl bg-slate-800/60 border border-slate-700/50 flex items-center justify-center mx-auto text-slate-400 group-hover:text-cyan-400 group-hover:border-cyan-500/30 transition">
                            <i data-lucide="cloud-upload" class="w-6 h-6"></i>
                        </div>
                        <div class="text-xs text-slate-300">
                            <span class="text-cyan-400 font-semibold">Klik untuk upload</span> atau drag and drop
                        </div>
                        <p class="text-[11px] text-slate-500">PNG, JPG, JPEG, atau WEBP (Maksimal 2MB)</p>
                    </div>

                    <!-- Live Preview Container -->
                    <div id="preview-container" class="hidden flex flex-col items-center justify-center gap-3">
                        <img id="image-preview" src="#" alt="Preview Sampul" class="max-h-48 rounded-xl object-cover border border-slate-700 shadow-lg">
                        <p id="file-name" class="text-xs text-cyan-400 font-medium"></p>
                        <span class="text-[10px] text-slate-500">Klik atau drag gambar baru untuk mengganti</span>
                    </div>
                </div>
            </div>

            <!-- Sinopsis -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ringkasan / Sinopsis Buku</label>
                <textarea name="sinopsis" rows="4" placeholder="Tuliskan ringkasan singkat isi buku..." 
                    class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">{{ old('sinopsis') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('admin.buku.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-800 text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition cursor-pointer flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript Live Preview Image -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sampulInput = document.getElementById('sampul-input');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const fileName = document.getElementById('file-name');

            sampulInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        fileName.textContent = file.name;
                        uploadPlaceholder.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection