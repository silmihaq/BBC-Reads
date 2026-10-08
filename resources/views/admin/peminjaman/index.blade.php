@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Transaksi Peminjaman</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola sirkulasi peminjaman dan pengembalian buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs shadow-lg shadow-cyan-500/20 hover:opacity-90 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Peminjaman Baru</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabel Transaksi Peminjaman -->
    <div class="rounded-2xl bg-slate-950/60 border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Peminjam (Siswa)</th>
                        <th class="px-6 py-4">Buku yang Dipinjam</th>
                        <th class="px-6 py-4">Tgl Pinjam / Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($peminjamans as $index => $item)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="px-6 py-4 text-slate-500 font-mono">
                                {{ $peminjamans->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-white">{{ $item->siswa->nama ?? 'Siswa Terhapus' }}</p>
                                <p class="text-[10px] text-slate-500">NISN: {{ $item->siswa->nisn ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-cyan-400">
                                {{ $item->buku->judul ?? 'Buku Terhapus' }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 space-y-0.5">
                                <p><span class="text-slate-500">Pinjam:</span> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</p>
                                <p><span class="text-slate-500">Batas:</span> {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status === 'dipinjam')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold uppercase">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold uppercase">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($item->status === 'dipinjam')
                                        <form action="{{ route('admin.peminjaman.kembalikan', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 font-semibold text-[11px] transition cursor-pointer" title="Kembalikan Buku">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-600 text-[11px] font-medium">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada data transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($peminjamans->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>
@endsection