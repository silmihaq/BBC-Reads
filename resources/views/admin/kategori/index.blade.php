@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-blue-950 tracking-wide">Kategori Buku</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola kategori dan klasifikasi buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <form action="{{ route('admin.kategori.index') }}" method="GET" class="p-4 rounded-2xl bg-white border border-blue-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori atau deskripsi..." 
                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-blue-950 placeholder-slate-400 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.kategori.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Kategori -->
    <div class="rounded-2xl bg-white border border-blue-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-blue-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Kategori</th>
                        <th class="px-6 py-4 font-semibold">Slug</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-center font-semibold">Jumlah Buku</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kategoris as $index => $kategori)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 text-slate-500 font-mono">
                                {{ isset($kategoris) && method_exists($kategoris, 'firstItem') ? $kategoris->firstItem() + $index : $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-bold text-blue-950">
                                {{ $kategori->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 font-mono text-blue-500">
                                {{ $kategori->slug ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                {{ $kategori->deskripsi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] bg-blue-50 text-blue-700 border border-blue-200 font-bold">
                                    {{ $kategori->bukus_count ?? $kategori->bukus->count() ?? 0 }} Buku
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-600 transition shadow-sm" title="Edit Data">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 transition shadow-sm cursor-pointer" title="Hapus Data">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada data kategori. Klik tombol <span class="text-blue-600 font-semibold">Tambah Kategori</span> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($kategoris) && method_exists($kategoris, 'hasPages') && $kategoris->hasPages())
            <div class="p-4 border-t border-blue-100 bg-slate-50/50">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>
@endsection