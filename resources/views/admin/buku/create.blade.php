@extends('components.admin-layout')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Buku
            </a>
            <h2 class="text-2xl font-bold text-white tracking-wide">Tambah Koleksi Buku</h2>
            <p class="text-slate-400 text-sm mt-1">Isi formulir di bawah ini untuk menambahkan buku baru ke pustaka</p>
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
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Judul Buku <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Laskar Pelangi" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Penulis / Pengarang -->
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

                <!-- Kategori Buku (Dinamis dari Controller) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-cyan-500 transition">
                        <option value="">-- Pilih Kategori --</option>
                        @if(isset($kategoris))
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Nomor ISBN -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nomor ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxx-x" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Tahun Terbit (Diselaraskan name="tahun") -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Tahun Terbit <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" min="1900" max="{{ date('Y') }}" required placeholder="2024" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Jumlah Stok Total -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Jumlah Stok Buku <span class="text-rose-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok') }}" min="0" required placeholder="0" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <!-- Upload Sampul Buku -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Foto Sampul Buku (Opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-800 rounded-2xl cursor-pointer bg-slate-900/50 hover:bg-slate-900 transition border-hover">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-500 mb-2"></i>
                                <p class="text-xs text-slate-400"><span class="font-semibold text-cyan-400">Klik untuk upload</span> atau drag and drop</p>
                                <p class="text-[10px] text-slate-500 mt-1">PNG, JPG, JPEG, atau WEBP (Maksimal 2MB)</p>
                            </div>
                            <input type="file" name="sampul" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </div>

                <!-- Ringkasan / Sinopsis -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ringkasan / Sinopsis Buku</label>
                    <textarea name="sinopsis" rows="4" placeholder="Tuliskan deskripsi singkat isi buku..." 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition">{{ old('sinopsis') }}</textarea>
                </div>
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
@endsection