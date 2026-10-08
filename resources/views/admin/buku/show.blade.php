<x-admin-layout>
    <x-slot:title>Detail Buku | BBC-Reads Admin</x-slot:title>

    <!-- Header & Navigation Back -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Buku
            </a>
            <h2 class="text-2xl font-bold text-white tracking-wide">Detail Informasi Buku</h2>
            <p class="text-slate-400 text-sm mt-1">Spesifikasi lengkap dan ketersediaan stok di perpustakaan</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.buku.edit', $buku->id) }}" class="px-4 py-2.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 font-semibold text-xs transition flex items-center gap-2">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Buku</span>
            </a>
            <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 font-semibold text-xs transition flex items-center gap-2 cursor-pointer">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Card Detail -->
    <div class="p-6 md:p-8 rounded-2xl bg-slate-950/60 border border-slate-800 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Sampul & Badge Stok -->
        <div class="flex flex-col items-center">
            <div class="w-full max-w-[220px] aspect-[3/4] rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-xl flex items-center justify-center mb-4">
                @if ($buku->sampul)
                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                @else
                    <div class="flex flex-col items-center text-slate-600">
                        <i data-lucide="book-open" class="w-16 h-16 mb-2"></i>
                        <span class="text-xs">Tidak Ada Sampul</span>
                    </div>
                @endif
            </div>

            <!-- Status Ketersediaan Stok -->
            <div class="w-full max-w-[220px] p-3 rounded-xl bg-slate-900/80 border border-slate-800 text-center">
                <span class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold block mb-1">Status Stok</span>
                @if ($buku->stok > 0)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Tersedia {{ $buku->stok }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                        Stok Habis
                    </span>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Rincian Metadata -->
        <div class="md:col-span-2 space-y-6">
            <div>
                <span class="px-3 py-1 rounded-full text-[10px] bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 font-bold uppercase tracking-wider">
                    {{ $buku->kategori }}
                </span>
                <h1 class="text-3xl font-extrabold text-white mt-3 mb-1 tracking-wide">{{ $buku->judul }}</h1>
                <p class="text-slate-400 text-sm">Ditulis oleh <span class="text-cyan-400 font-semibold">{{ $buku->penulis }}</span></p>
            </div>

            <!-- Metadata Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800/80">
                <div class="p-3.5 rounded-xl bg-slate-900/50 border border-slate-800">
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Penerbit</p>
                    <p class="text-xs text-white font-medium mt-1">{{ $buku->penerbit }}</p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-900/50 border border-slate-800">
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Tahun Terbit</p>
                    <p class="text-xs text-white font-medium mt-1">{{ $buku->tahun_terbit ?? '-' }}</p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-900/50 border border-slate-800">
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Nomor ISBN</p>
                    <p class="text-xs text-white font-medium mt-1">{{ $buku->isbn ?? '-' }}</p>
                </div>
            </div>

            <!-- Ringkasan / Sinopsis -->
            <div class="pt-4 border-t border-slate-800/80">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Sinopsis / Ringkasan Buku</h3>
                <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800/60 text-xs text-slate-300 leading-relaxed whitespace-pre-line">
                    {{ $buku->sinopsis ?? 'Belum ada sinopsis untuk buku ini.' }}
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>