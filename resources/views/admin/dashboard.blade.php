@extends('components.admin-layout')

@section('title', 'Dashboard Admin | BBC-Reads')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Dashboard Ringkasan</h1>
            <p class="text-xs text-slate-400 mt-1">Pantau statistik & tren transaksi perpustakaan digital BBC-Reads.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                Sistem Aktif
            </span>
        </div>
    </div>

    <!-- Section 1: Ringkasan Kartu Statistik (4-Grid Compact) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Siswa -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 flex items-center gap-4 hover:border-cyan-500/40 transition shadow-md">
            <div class="p-3 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 rounded-xl">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider block">Total Siswa</span>
                <strong class="text-xl font-bold text-white leading-tight block mt-0.5">{{ number_format($totalSiswa ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 2: Koleksi Buku -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 flex items-center gap-4 hover:border-cyan-500/40 transition shadow-md">
            <div class="p-3 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-xl">
                <i data-lucide="book-open" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider block">Koleksi Buku</span>
                <strong class="text-xl font-bold text-white leading-tight block mt-0.5">{{ number_format($totalBuku ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 flex items-center gap-4 hover:border-amber-500/40 transition shadow-md">
            <div class="p-3 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-xl">
                <i data-lucide="bookmark" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider block">Sedang Dipinjam</span>
                <strong class="text-xl font-bold text-amber-400 leading-tight block mt-0.5">{{ number_format($totalDipinjam ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 4: Selesai / Kembali -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 flex items-center gap-4 hover:border-emerald-500/40 transition shadow-md">
            <div class="p-3 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider block">Peminjaman Selesai</span>
                <strong class="text-xl font-bold text-emerald-400 leading-tight block mt-0.5">{{ number_format($totalSelesai ?? 0) }}</strong>
            </div>
        </div>
    </div>

    <!-- Section 2: Grafik Bulanan Compact + Tabel Transaksi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Grafik Tren Bulanan (Compact Container) -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 shadow-md flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-bold text-white">Tren Peminjaman</h2>
                        <p class="text-[11px] text-slate-400">Jumlah aktivitas per bulan ({{ date('Y') }})</p>
                    </div>
                    <div class="p-2 bg-slate-800 rounded-lg text-cyan-400">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Canvas Chart.js (Ketinggian Dibatasi) -->
                <div class="relative w-full h-48 mt-2">
                    <canvas id="peminjamanBulananChart"></canvas>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400 mt-2">
                <span>Total Tahun Ini</span>
                <strong class="text-white font-bold">{{ array_sum($grafikData ?? []) }} Transaksi</strong>
            </div>
        </div>

        <!-- Tabel Peminjaman Terbaru -->
        <div class="lg:col-span-2 bg-slate-900/80 border border-slate-800 rounded-2xl p-5 shadow-md flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-white">Aktivitas Peminjaman Terbaru</h2>
                        <p class="text-[11px] text-slate-400">5 riwayat transaksi peminjaman buku terakhir</p>
                    </div>
                    @if (\Illuminate\Support\Facades\Route::has('admin.peminjaman.index'))
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition flex items-center gap-1">
                            Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="text-[10px] uppercase bg-slate-950/80 text-slate-400 border-b border-slate-800">
                            <tr>
                                <th class="py-2.5 px-3 rounded-l-lg">Peminjam</th>
                                <th class="py-2.5 px-3">Buku</th>
                                <th class="py-2.5 px-3">Tgl Pinjam</th>
                                <th class="py-2.5 px-3 text-center rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @forelse ($peminjamanTerbaru ?? [] as $p)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="py-3 px-3 font-semibold text-white">
                                        {{ $p->siswa->nama ?? $p->anggota->nama ?? $p->user->name ?? 'Siswa' }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-300 max-w-[150px] truncate">
                                        {{ $p->buku->judul ?? '-' }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-400">
                                        {{ $p->tanggal_pinjam ?? ($p->created_at ? $p->created_at->format('d/m/Y') : '-') }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if (($p->status ?? '') == 'dipinjam')
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500">
                                        Belum ada aktivitas peminjaman buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('peminjamanBulananChart');
        if (!ctx) return;

        const labels = @json($bulanLabels ?? []);
        const dataValues = @json($grafikData ?? []);

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peminjaman',
                    data: dataValues,
                    backgroundColor: 'rgba(6, 182, 212, 0.4)',
                    borderColor: '#06b6d4',
                    borderWidth: 1.5,
                    borderRadius: 4,
                    hoverBackgroundColor: '#06b6d4'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#38bdf8',
                        borderColor: '#1e293b',
                        borderWidth: 1,
                        padding: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(30, 41, 59, 0.5)' },
                        ticks: { color: '#64748b', font: { size: 10 }, stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
@endsection