@extends('components.admin-layout')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Pengembalian & Denda</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola pemrosesan pengembalian buku, keterlambatan, dan denda penggantian buku hilang</p>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Bar (Form Mandiri) -->
    <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam, NISN, atau buku..." 
                class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 text-xs focus:outline-none focus:border-cyan-500 transition">
            <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.pengembalian.index') }}" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Pengembalian -->
    <div class="rounded-2xl bg-slate-950/60 border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">NO</th>
                        <th class="px-6 py-4">PEMINJAM (SISWA)</th>
                        <th class="px-6 py-4">BUKU</th>
                        <th class="px-6 py-4">TGL PINJAM / TENGGAT</th>
                        <th class="px-6 py-4 text-center">STATUS</th>
                        <th class="px-6 py-4 text-center">BENTUK DENDA</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($pengembalians as $index => $item)
                        @php
                            $statusLower = strtolower($item->status);
                        @endphp
                        <tr class="hover:bg-slate-900/40 transition">
                            <td class="px-6 py-4 text-slate-500 font-mono">
                                {{ isset($pengembalians) && method_exists($pengembalians, 'firstItem') ? $pengembalians->firstItem() + $index : $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white">{{ $item->nama_peminjam ?? '-' }}</div>
                                <div class="text-[11px] text-slate-500 font-mono">NISN: {{ $item->nisn ?? '-' }} ({{ $item->kelas ?? '-' }})</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-200">
                                {{ $item->buku->judul ?? 'Buku Dihapus' }}
                            </td>
                            <td class="px-6 py-4 space-y-0.5">
                                <div class="text-slate-300">Pinjam: <span class="font-mono text-slate-400">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</span></div>
                                <div class="text-slate-300">Tenggat: <span class="font-mono text-cyan-400">{{ \Carbon\Carbon::parse($item->tgl_tenggat)->format('d M Y') }}</span></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'dipinjam')
                                    @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($item->tgl_tenggat)))
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 font-bold">Dipinjam</span>
                                    @endif
                                @elseif ($statusLower === 'hilang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 font-bold">Buku Hilang</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'hilang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 font-bold inline-flex items-center gap-1">
                                        <i data-lucide="book-x" class="w-3 h-3"></i> Wajib Ganti Buku
                                    </span>
                                @elseif ($item->denda_keterangan === 'Sudah Diganti' || str_contains(strtolower($item->denda_keterangan ?? ''), 'diganti'))
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold inline-flex items-center gap-1">
                                        <i data-lucide="check-circle-2" class="w-3 h-3"></i> Sudah Diganti
                                    </span>
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'dipinjam')
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Kembali -->
                                        <button type="button" 
                                            onclick="openActionModal('kembali', '{{ route('admin.peminjaman.kembalikan', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                            class="px-2.5 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            <span>Kembali</span>
                                        </button>

                                        <!-- Tombol Hilang -->
                                        <button type="button" 
                                            onclick="openActionModal('hilang', '{{ route('admin.peminjaman.hilang', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                            class="px-2.5 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                            <span>Hilang</span>
                                        </button>
                                    </div>
                                @elseif ($statusLower === 'hilang')
                                    <!-- Tombol Ganti Buku -->
                                    <button type="button" 
                                        onclick="openActionModal('ganti', '{{ route('admin.peminjaman.ganti-buku', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                        class="px-3 py-1.5 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 border border-cyan-500/20 text-cyan-400 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1.5 mx-auto">
                                        <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                                        <span>Konfirmasi Diganti</span>
                                    </button>
                                @else
                                    <span class="text-[11px] text-slate-500 italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                Belum ada riwayat transaksi pengembalian buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($pengembalians) && method_exists($pengembalians, 'hasPages') && $pengembalians->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $pengembalians->links() }}
            </div>
        @endif
    </div>

    <!-- CUSTOM CONFIRMATION MODAL -->
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-opacity">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
            <div class="flex items-start gap-4">
                <div id="modal-icon-bg" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0">
                    <i id="modal-icon" data-lucide="help-circle" class="w-6 h-6"></i>
                </div>
                <div class="space-y-1">
                    <h3 id="modal-title" class="text-lg font-bold text-white">Konfirmasi Aksi</h3>
                    <p id="modal-description" class="text-xs text-slate-400 leading-relaxed"></p>
                </div>
            </div>

            <!-- Detail Peminjam -->
            <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800/80 space-y-1 text-xs">
                <div class="text-slate-500">Peminjam: <span id="modal-peminjam" class="text-slate-200 font-bold"></span></div>
                <div class="text-slate-500">Buku: <span id="modal-buku" class="text-cyan-400 font-semibold"></span></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeActionModal()" class="px-4 py-2 rounded-xl border border-slate-800 text-xs font-semibold text-slate-400 hover:bg-slate-800 hover:text-white transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="modal-submit-btn" onclick="submitMasterForm()" class="px-4 py-2 rounded-xl font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                    <span>Ya, Proses</span>
                </button>
            </div>
        </div>
    </div>

    <!-- FORM MASTER POST KHUSUS (DILUAR MODAL & DILUAR TABEL) -->
    <form id="master-post-form" action="" method="POST" style="display: none !important;">
        @csrf
    </form>

    <!-- JAVASCRIPT HANDLER -->
    <script>
        let selectedActionUrl = '';

        function openActionModal(type, actionUrl, bukuTitle, peminjamName) {
            selectedActionUrl = actionUrl;

            const modal = document.getElementById('confirm-modal');
            const iconBg = document.getElementById('modal-icon-bg');
            const title = document.getElementById('modal-title');
            const desc = document.getElementById('modal-description');
            const submitBtn = document.getElementById('modal-submit-btn');
            
            document.getElementById('modal-peminjam').textContent = peminjamName;
            document.getElementById('modal-buku').textContent = bukuTitle;

            if (type === 'hilang') {
                iconBg.className = "w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center shrink-0";
                title.textContent = "Laporkan Buku Hilang";
                desc.textContent = "Tandai transaksi ini sebagai BUKU HILANG? Bentuk denda akan otomatis terisi menjadi 'Wajib Ganti Buku'.";
                submitBtn.className = "px-4 py-2 rounded-xl bg-rose-500 text-slate-950 hover:bg-rose-400 font-bold text-xs transition cursor-pointer";
            } else if (type === 'ganti') {
                iconBg.className = "w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center shrink-0";
                title.textContent = "Konfirmasi Penggantian Buku";
                desc.textContent = "Apakah siswa telah menyerahkan buku fisik pengganti? Status denda akan diperbarui menjadi 'Sudah Diganti'.";
                submitBtn.className = "px-4 py-2 rounded-xl bg-cyan-500 text-slate-950 hover:bg-cyan-400 font-bold text-xs transition cursor-pointer";
            } else {
                iconBg.className = "w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0";
                title.textContent = "Proses Pengembalian Buku";
                desc.textContent = "Proses pengembalian buku ini secara normal dan kembalikan stok buku ke perpustakaan?";
                submitBtn.className = "px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 hover:bg-emerald-400 font-bold text-xs transition cursor-pointer";
            }

            modal.classList.remove('hidden');
        }

        function closeActionModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            selectedActionUrl = '';
        }

        function submitMasterForm() {
            if (selectedActionUrl) {
                const masterForm = document.getElementById('master-post-form');
                masterForm.action = selectedActionUrl;
                masterForm.submit();
            }
        }
    </script>
@endsection