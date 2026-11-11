@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-blue-900 tracking-wide">Transaksi Peminjaman</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola sirkulasi peminjaman dan pengembalian buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold text-xs shadow-lg shadow-blue-500/30 hover:opacity-90 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Peminjaman Baru</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2 shadow-sm">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabel Transaksi Peminjaman -->
    <div class="rounded-2xl bg-white border border-blue-100 shadow-xl shadow-blue-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-blue-600 text-white uppercase tracking-wider border-b border-blue-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Peminjam (Siswa)</th>
                        <th class="px-6 py-4 font-semibold">Buku yang Dipinjam</th>
                        <th class="px-6 py-4 font-semibold">Tgl Pinjam / Tenggat</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @forelse ($peminjamans as $index => $item)
                        @php
                            $statusLower = strtolower($item->status);
                        @endphp
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 text-gray-400 font-mono">
                                {{ isset($peminjamans) && method_exists($peminjamans, 'firstItem') ? $peminjamans->firstItem() + $index : $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-blue-900">{{ $item->nama_peminjam ?? ($item->siswa->nama ?? 'Siswa Terhapus') }}</p>
                                <p class="text-[10px] text-gray-500 font-mono">NISN: {{ $item->nisn ?? ($item->siswa->nisn ?? '-') }} ({{ $item->kelas ?? '-' }})</p>
                            </td>
                            <td class="px-6 py-4 font-semibold text-blue-700">
                                {{ $item->buku->judul ?? 'Buku Terhapus' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 space-y-0.5">
                                <p><span class="text-gray-400">Pinjam:</span> <span class="font-mono text-gray-700">{{ \Carbon\Carbon::parse($item->tgl_pinjam ?? $item->tanggal_pinjam)->format('d M Y') }}</span></p>
                                <p><span class="text-gray-400">Batas:</span> <span class="font-mono text-blue-600">{{ \Carbon\Carbon::parse($item->tgl_tenggat ?? $item->tanggal_kembali)->format('d M Y') }}</span></p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'dipinjam')
                                    @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($item->tgl_tenggat ?? $item->tanggal_kembali)))
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-700 border border-amber-200 font-bold uppercase">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-blue-100 text-blue-700 border border-blue-200 font-bold uppercase">
                                            Dipinjam
                                        </span>
                                    @endif
                                @elseif ($statusLower === 'hilang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-100 text-rose-700 border border-rose-200 font-bold uppercase">
                                        Hilang
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold uppercase">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($statusLower === 'dipinjam')
                                        <!-- Form POST Murni tanpa @method('PATCH') -->
                                        <form action="{{ route('admin.peminjaman.kembalikan', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-600 hover:text-emerald-700 font-semibold text-[11px] transition cursor-pointer" title="Kembalikan Buku">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-300 text-[11px] font-medium">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 bg-white">
                                Belum ada data transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($peminjamans) && method_exists($peminjamans, 'hasPages') && $peminjamans->hasPages())
            <div class="p-4 border-t border-blue-50 bg-gray-50/50">
                {{ $peminjamans->links() }}
            </div>
        @endif
    </div>
@endsection