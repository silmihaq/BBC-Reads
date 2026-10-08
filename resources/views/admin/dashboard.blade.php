@extends('components.admin-layout')

@section('content')
    <!-- Welcome Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white tracking-wide">Selamat Datang di Admin Dashboard</h2>
        <p class="text-slate-400 text-sm mt-1">Ringkasan aktivitas perpustakaan dan statistik transaksi BBC-Reads</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Card Total Siswa -->
        <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Total Anggota/Siswa</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $totalSiswa }}</h3>
            </div>
            <div class="p-3 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 rounded-xl">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card Total Buku -->
        <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Total Judul Buku</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $totalBuku }}</h3>
            </div>
            <div class="p-3 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-xl">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card Sedang Dipinjam -->
        <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Buku Sedang Dipinjam</p>
                <h3 class="text-2xl font-bold text-amber-400 mt-1">{{ $totalDipinjam }}</h3>
            </div>
            <div class="p-3 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Card Selesai/Dikembalikan -->
        <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Transaksi Selesai</p>
                <h3 class="text-2xl font-bold text-emerald-400 mt-1">{{ $totalSelesai }}</h3>
            </div>
            <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Chart Section (Diagram Batang) -->
    <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-bold text-white">Grafik Transaksi Peminjaman</h3>
                <p class="text-xs text-slate-400 mt-0.5">Statistik peminjaman buku bulanan</p>
            </div>
        </div>
        <div class="relative w-full h-72">
            <canvas id="peminjamanChart"></canvas>
        </div>
    </div>

    <!-- Tabel Peminjaman Terbaru -->
    <div class="rounded-2xl bg-slate-950/60 border border-slate-800 overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Transaksi Peminjaman Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">5 Peminjaman terakhir yang terdaftar dalam sistem</p>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="text-xs text-cyan-400 font-semibold hover:underline flex items-center gap-1">
                <span>Lihat Semua</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-3.5">Kode</th>
                        <th class="px-6 py-3.5">Peminjam</th>
                        <th class="px-6 py-3.5">Buku</th>
                        <th class="px-6 py-3.5">Tgl Pinjam</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($peminjamanTerbaru as $trx)
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="px-6 py-4 font-mono font-bold text-cyan-400">
                                {{ $trx->kode_transaksi }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-white">
                                {{ $trx->nama_peminjam }}
                                <span class="block text-[10px] text-slate-400 font-mono">{{ $trx->nisn }} ({{ $trx->kelas }})</span>
                            </td>
                            <td class="px-6 py-4 text-slate-300">
                                {{ $trx->buku->judul ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-400">
                                {{ date('d M Y', strtotime($trx->tgl_pinjam)) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($trx->status === 'dipinjam')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold uppercase">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold uppercase">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Belum ada riwayat transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Chart.js library & Script Render Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            
            // Mengambil data dinamis dari controller (jika ada) atau fallback ke data sampel
            const chartLabels = {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!};
            const chartData = {!! json_encode($chartData ?? [12, 19, 15, 25, 22, 30, 28, 35, 40, 20, 18, 24]) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: chartData,
                        backgroundColor: '#06b6d4', // Cyan color matching theme
                        borderColor: '#22d3ee',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#f8fafc',
                            bodyColor: '#38bdf8',
                            borderColor: '#334155',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(51, 65, 85, 0.3)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(51, 65, 85, 0.3)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                },
                                stepSize: 5
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection