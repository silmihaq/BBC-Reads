@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Koleksi Data Buku</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola katalog dan ketersediaan stok buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Buku Baru</span>
        </a>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Search Bar -->
    <form action="{{ route('admin.buku.index') }}" method="GET" class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau ISBN..." 
                class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 text-xs focus:outline-none focus:border-cyan-500 transition">
            <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.buku.index') }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Buku -->
    <div class="rounded-2xl bg-slate-950/60 border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penerbit / Tahun</th>
                        <th class="px-6 py-4 text-center">Stok Total</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($bukus as $index => $buku)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="px-6 py-4 text-slate-500 font-medium">{{ $bukus->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($buku->sampul)
                                        <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="w-10 h-12 rounded object-cover border border-slate-700">
                                    @else
                                        <div class="w-10 h-12 rounded bg-slate-800 border border-slate-700 flex-shrink-0 flex items-center justify-center text-slate-500">
                                            <i data-lucide="book-open" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.buku.show', $buku->id) }}" class="font-bold text-white hover:text-cyan-400 transition">{{ $buku->judul }}</a>
                                        <p class="text-[10px] text-slate-500">{{ $buku->penulis }} • ISBN: {{ $buku->isbn ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 font-semibold uppercase">
                                    {{ $buku->kategori->nama_kategori ?? $buku->kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $buku->penerbit }} ({{ $buku->tahun_terbit ?? '-' }})</td>
                            <td class="px-6 py-4 text-center font-semibold text-slate-300">{{ $buku->stok }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buku.show', $buku->id) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition" title="Detail">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('admin.buku.edit', $buku->id) }}" class="p-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 transition" title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition cursor-pointer" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada data buku. Klik tombol <span class="text-cyan-400 font-semibold">Tambah Buku Baru</span> untuk memasukkan data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bukus->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $bukus->links() }}
            </div>
        @endif
    </div>
@endsection