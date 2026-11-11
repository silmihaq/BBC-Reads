@extends('components.admin-layout')

@section('title', 'Dashboard Admin | BBC-Reads')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-blue-100 p-6 rounded-2xl shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-blue-950 tracking-tight">Dashboard Ringkasan</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau statistik & tren transaksi perpustakaan digital BBC-Reads.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 text-xs font-semibold rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                Sistem Aktif
            </span>
        </div>
    </div>

    <!-- Section 1: Ringkasan Kartu Statistik (4-Grid Compact) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Siswa -->
        <div class="bg-white border border-blue-100 rounded-2xl p-4 flex items-center gap-4 hover:border-blue-300 transition shadow-sm hover:shadow-md">
            <div class="p-3 bg-blue-50 text-blue-600 border border-blue-200 rounded-xl">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Total Siswa</span>
                <strong class="text-xl font-bold text-blue-950 leading-tight block mt-0.5">{{ number_format($totalSiswa ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 2: Koleksi Buku -->
        <div class="bg-white border border-blue-100 rounded-2xl p-4 flex items-center gap-4 hover:border-blue-300 transition shadow-sm hover:shadow-md">
            <div class="p-3 bg-indigo-50 text-indigo-600 border border-indigo-200 rounded-xl">
                <i data-lucide="book-open" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Koleksi Buku</span>
                <strong class="text-xl font-bold text-blue-950 leading-tight block mt-0.5">{{ number_format($totalBuku ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="bg-white border border-blue-100 rounded-2xl p-4 flex items-center gap-4 hover:border-amber-300 transition shadow-sm hover:shadow-md">
            <div class="p-3 bg-amber-50 text-amber-600 border border-amber-200 rounded-xl">
                <i data-lucide="bookmark" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Sedang Dipinjam</span>
                <strong class="text-xl font-bold text-amber-600 leading-tight block mt-0.5">{{ number_format($totalDipinjam ?? 0) }}</strong>
            </div>
        </div>

        <!-- Card 4: Selesai / Kembali -->
        <div class="bg-white border border-blue-100 rounded-2xl p-4 flex items-center gap-4 hover:border-emerald-300 transition shadow-sm hover:shadow-md">
            <div class="p-3 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-xl">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider block">Peminjaman Selesai</span>
                <strong class="text-xl font-bold text-emerald-600 leading-tight block mt-0.5">{{ number_format($totalSelesai ?? 0) }}</strong>
            </div>
        </div>
    </div>

    <!-- Section 2: Grafik Bulanan Compact + Tabel Transaksi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Grafik Tren Bulanan (Compact Container) -->
        <div class="bg-white border border-blue-100 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-bold text-blue-950">Tren Peminjaman</h2>
                        <p class="text-[11px] text-slate-500">Jumlah aktivitas per bulan ({{ date('Y') }})</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600 border border-blue-100">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Canvas Chart.js (Ketinggian Dibatasi) -->
                <div class="relative w-full h-48 mt-2">
                    <canvas id="peminjamanBulananChart"></canvas>
                </div>
            </div>

            <div class="pt-3 border-t border-blue-100 flex items-center justify-between text-xs text-slate-500 mt-2">
                <span>Total Tahun Ini</span>
                <strong class="text-blue-950 font-bold">{{ array_sum($grafikData ?? []) }} Transaksi</strong>
            </div>
        </div>

        <!-- Tabel Peminjaman Terbaru -->
        <div class="lg:col-span-2 bg-white border border-blue-100 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-bold text-blue-950">Aktivitas Peminjaman Terbaru</h2>
                        <p class="text-[11px] text-slate-500">5 riwayat transaksi peminjaman buku terakhir</p>
                    </div>
                    @if (\Illuminate\Support\Facades\Route::has('admin.peminjaman.index'))
                        <a href="{{ route('admin.peminjaman.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                            Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="text-[10px] uppercase bg-slate-50 text-slate-500 border-b border-blue-100">
                            <tr>
                                <th class="py-2.5 px-3 rounded-l-lg">Peminjam</th>
                                <th class="py-2.5 px-3">Buku</th>
                                <th class="py-2.5 px-3">Tgl Pinjam</th>
                                <th class="py-2.5 px-3 text-center rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($peminjamanTerbaru ?? [] as $p)
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="py-3 px-3 font-semibold text-blue-950">
                                        {{ $p->siswa->nama ?? $p->anggota->nama ?? $p->user->name ?? 'Siswa' }}
                                    </td>
                                    <td class="py-3 px-3 max-w-[150px] truncate">
                                        {{ $p->buku->judul ?? '-' }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $p->tanggal_pinjam ?? ($p->created_at ? $p->created_at->format('d/m/Y') : '-') }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if (($p->status ?? '') == 'dipinjam')
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400">
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
                    backgroundColor: 'rgba(59, 130, 246, 0.2)', // Biru muda transparan
                    borderColor: '#3b82f6', // Biru solid
                    borderWidth: 1.5,
                    borderRadius: 4,
                    hoverBackgroundColor: '#2563eb' // Biru lebih gelap saat dihover
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#1e3a8a',
                        bodyColor: '#3b82f6',
                        borderColor: '#bfdbfe',
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
                        grid: { color: 'rgba(226, 232, 240, 0.8)' }, // Grid abu-abu sangat muda
                        ticks: { color: '#64748b', font: { size: 10 }, stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
@endsection