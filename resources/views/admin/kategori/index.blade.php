@extends('components.admin-layout')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Kategori Buku</h1>
            <p class="text-xs text-slate-400 mt-1">Kelola kategori dan klasifikasi buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Notifikasi Error -->
    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs flex items-center gap-3">
            <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabel Data Kategori -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/60 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="p-4">No</th>
                        <th class="p-4">Nama Kategori</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4 text-center">Jumlah Buku</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($kategoris as $index => $item)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="p-4 font-medium text-slate-400">{{ $kategoris->firstItem() + $index }}</td>
                            <td class="p-4 font-semibold text-white">{{ $item->nama_kategori }}</td>
                            <td class="p-4 text-slate-400 font-mono text-[11px]">{{ $item->slug }}</td>
                            <td class="p-4 text-slate-400 max-w-xs truncate">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full bg-slate-800 border border-slate-700 text-cyan-400 text-[11px] font-semibold">
                                    {{ $item->bukus_count ?? 0 }} Buku
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $item->id) }}" 
                                       class="p-2 rounded-lg bg-slate-800 text-amber-400 hover:bg-amber-500/10 transition"
                                       title="Edit">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg bg-slate-800 text-rose-400 hover:bg-rose-500/10 transition cursor-pointer"
                                                title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Belum ada data kategori. Klik tombol <strong>Tambah Kategori</strong> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kategoris->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>

</div>
@endsection