@extends('components.admin-layout')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Tambah Kategori Buku</h1>
            <p class="text-xs text-slate-400 mt-1">Buat kategori baru untuk pengelompokan buku</p>
        </div>
        <a href="{{ route('admin.kategori.index') }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 text-slate-300 font-semibold text-xs border border-slate-700 hover:bg-slate-700 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-xl">
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="nama_kategori" class="block text-xs font-semibold text-slate-300 mb-2">Nama Kategori <span class="text-rose-500">*</span></label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       value="{{ old('nama_kategori') }}"
                       placeholder="Misal: Pemrograman, Fiksi, Sains"
                       class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border @error('nama_kategori') border-rose-500 @else border-slate-800 @enderror text-white text-xs focus:outline-none focus:border-cyan-500 transition">
                @error('nama_kategori')
                    <p class="text-rose-400 text-[11px] mt-1.5 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-semibold text-slate-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          rows="4" 
                          placeholder="Penjelasan singkat mengenai kategori ini..."
                          class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-cyan-500 transition">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold hover:bg-slate-700 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

</div>
@endsection