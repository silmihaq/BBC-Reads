@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Koleksi Buku Perpustakaan</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola katalog buku, sampul, sinopsis, dan stok ketersediaan</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Buku Baru</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.buku.index') }}" method="GET" class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 mb-8 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, penerbit, atau sinopsis..." 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 text-xs focus:outline-none focus:border-cyan-500 transition">
            <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.buku.index') }}" class="px-3.5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition font-semibold">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Horizontal Cards Grid (Tanpa ID) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse ($bukus as $item)
            <div class="group bg-slate-950/60 border border-slate-800 hover:border-slate-700/80 rounded-2xl overflow-hidden transition-all duration-300 flex flex-col sm:flex-row shadow-xl">
                
                <!-- SISI KIRI: Sampul Buku -->
                <div class="w-full sm:w-48 h-64 sm:h-auto bg-slate-900 shrink-0 relative border-b sm:border-b-0 sm:border-r border-slate-800/80 flex items-center justify-center p-3">
                    @if ($item->cover)
                        <img src="{{ asset('storage/' . $item->cover) }}" 
                             alt="{{ $item->judul }}" 
                             class="w-full h-full object-contain rounded-xl shadow-md group-hover:scale-105 transition-transform duration-300"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400/0f172a/94a3b8?text=Tidak+Ada+Sampul';">
                    @else
                        <div class="flex flex-col items-center gap-2 text-slate-600">
                            <i data-lucide="book-open" class="w-10 h-10 stroke-[1.5]"></i>
                            <span class="text-[11px] font-semibold">Tidak Ada Sampul</span>
                        </div>
                    @endif

                    <!-- Badge Kategori -->
                    <div class="absolute top-4 left-4">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase bg-slate-950/80 text-cyan-400 border border-cyan-500/30 backdrop-blur-md">
                            {{ $item->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>

                <!-- SISI KANAN: Detail Informasi, Sinopsis, dan Aksi -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <!-- Judul & Badge Stok -->
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-bold text-white group-hover:text-cyan-400 transition leading-snug">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1">
                                    <span class="text-slate-300 font-medium">{{ $item->penulis ?? 'Penulis Tidak Diketahui' }}</span>
                                    @if($item->penerbit || $item->tahun_terbit)
                                        <span class="text-slate-600">•</span> {{ $item->penerbit ?? '-' }} ({{ $item->tahun_terbit ?? '-' }})
                                    @endif
                                </p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border shrink-0 {{ $item->stok > 0 ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                                Stok: {{ $item->stok }}
                            </span>
                        </div>

                        <!-- Sinopsis Buku -->
                        <div class="pt-2 border-t border-slate-800/60">
                            <span class="text-[10px] uppercase tracking-wider font-bold text-slate-500 block mb-1">Sinopsis:</span>
                            <p class="text-xs text-slate-300 leading-relaxed line-clamp-4">
                                {{ $item->deskripsi ?? 'Belum ada sinopsis atau deskripsi singkat untuk buku ini.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi (Edit & Hapus) - Rata Kanan Murni -->
                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-end gap-2">
                        <a href="{{ route('admin.buku.edit', $item->id) }}" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 text-xs font-semibold transition flex items-center gap-1.5 cursor-pointer">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-xs font-semibold transition flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full p-12 text-center rounded-2xl bg-slate-950/60 border border-slate-800 text-slate-500 space-y-3">
                <i data-lucide="book-x" class="w-10 h-10 mx-auto text-slate-600"></i>
                <p class="text-sm">Belum ada koleksi buku yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if (isset($bukus) && method_exists($bukus, 'hasPages') && $bukus->hasPages())
        <div class="mt-8 p-4 rounded-2xl bg-slate-950/60 border border-slate-800">
            {{ $bukus->links() }}
        </div>
    @endif
@endsection