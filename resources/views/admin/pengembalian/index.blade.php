@extends('components.admin-layout')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-blue-900 tracking-wide">Pengembalian & Denda</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola pemrosesan pengembalian buku, keterlambatan, dan denda penggantian buku hilang</p>
        </div>
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

    <!-- Search Bar (Form Mandiri) -->
    <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="p-4 rounded-2xl bg-white border border-blue-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam, NISN, atau buku..." 
                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.pengembalian.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs transition">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Pengembalian -->
    <div class="rounded-2xl bg-white border border-blue-100 shadow-xl shadow-blue-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-blue-600 text-white uppercase tracking-wider border-b border-blue-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold">NO</th>
                        <th class="px-6 py-4 font-semibold">PEMINJAM (SISWA)</th>
                        <th class="px-6 py-4 font-semibold">BUKU</th>
                        <th class="px-6 py-4 font-semibold">TGL PINJAM / TENGGAT</th>
                        <th class="px-6 py-4 font-semibold text-center">STATUS</th>
                        <th class="px-6 py-4 font-semibold text-center">BENTUK DENDA</th>
                        <th class="px-6 py-4 font-semibold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @forelse ($pengembalians as $index => $item)
                        @php
                            $statusLower = strtolower($item->status);
                        @endphp
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 text-gray-400 font-mono">
                                {{ isset($pengembalians) && method_exists($pengembalians, 'firstItem') ? $pengembalians->firstItem() + $index : $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-900">{{ $item->nama_peminjam ?? '-' }}</div>
                                <div class="text-[11px] text-gray-500 font-mono">NISN: {{ $item->nisn ?? '-' }} ({{ $item->kelas ?? '-' }})</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-blue-700">
                                {{ $item->buku->judul ?? 'Buku Dihapus' }}
                            </td>
                            <td class="px-6 py-4 space-y-0.5">
                                <div class="text-gray-500">Pinjam: <span class="font-mono text-gray-700">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</span></div>
                                <div class="text-gray-500">Tenggat: <span class="font-mono text-blue-600">{{ \Carbon\Carbon::parse($item->tgl_tenggat)->format('d M Y') }}</span></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'dipinjam')
                                    @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($item->tgl_tenggat)))
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-amber-100 text-amber-700 border border-amber-200 font-bold">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] bg-blue-100 text-blue-700 border border-blue-200 font-bold">Dipinjam</span>
                                    @endif
                                @elseif ($statusLower === 'hilang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-100 text-rose-700 border border-rose-200 font-bold">Buku Hilang</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'hilang')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-100 text-rose-700 border border-rose-200 font-bold inline-flex items-center gap-1">
                                        <i data-lucide="book-x" class="w-3 h-3"></i> Wajib Ganti Buku
                                    </span>
                                @elseif ($item->denda_keterangan === 'Sudah Diganti' || str_contains(strtolower($item->denda_keterangan ?? ''), 'diganti'))
                                    <span class="px-2.5 py-1 rounded-full text-[10px] bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold inline-flex items-center gap-1">
                                        <i data-lucide="check-circle-2" class="w-3 h-3"></i> Sudah Diganti
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($statusLower === 'dipinjam')
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Kembali -->
                                        <button type="button" 
                                            onclick="openActionModal('kembali', '{{ route('admin.peminjaman.kembalikan', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                            class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-600 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            <span>Kembali</span>
                                        </button>

                                        <!-- Tombol Hilang -->
                                        <button type="button" 
                                            onclick="openActionModal('hilang', '{{ route('admin.peminjaman.hilang', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                            class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1">
                                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                            <span>Hilang</span>
                                        </button>
                                    </div>
                                @elseif ($statusLower === 'hilang')
                                    <!-- Tombol Ganti Buku -->
                                    <button type="button" 
                                        onclick="openActionModal('ganti', '{{ route('admin.peminjaman.ganti-buku', $item->id) }}', '{{ addslashes($item->buku->judul ?? 'Buku') }}', '{{ addslashes($item->nama_peminjam) }}')"
                                        class="px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-600 font-semibold text-[11px] transition cursor-pointer flex items-center gap-1.5 mx-auto">
                                        <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                                        <span>Konfirmasi Diganti</span>
                                    </button>
                                @else
                                    <span class="text-[11px] text-gray-400 italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 bg-white">
                                Belum ada riwayat transaksi pengembalian buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (isset($pengembalians) && method_exists($pengembalians, 'hasPages') && $pengembalians->hasPages())
            <div class="p-4 border-t border-blue-50 bg-gray-50/50">
                {{ $pengembalians->links() }}
            </div>
        @endif
    </div>

    <!-- CUSTOM CONFIRMATION MODAL -->
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white border border-blue-100 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-6">
            <div class="flex items-start gap-4">
                <div id="modal-icon-bg" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0">
                    <i id="modal-icon" data-lucide="help-circle" class="w-6 h-6"></i>
                </div>
                <div class="space-y-1">
                    <h3 id="modal-title" class="text-lg font-bold text-blue-900">Konfirmasi Aksi</h3>
                    <p id="modal-description" class="text-xs text-gray-500 leading-relaxed"></p>
                </div>
            </div>

            <!-- Detail Peminjam -->
            <div class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 space-y-1 text-xs">
                <div class="text-gray-500">Peminjam: <span id="modal-peminjam" class="text-blue-900 font-bold"></span></div>
                <div class="text-gray-500">Buku: <span id="modal-buku" class="text-blue-600 font-semibold"></span></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeActionModal()" class="px-4 py-2 rounded-xl border border-gray-300 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="modal-submit-btn" onclick="submitMasterForm()" class="px-4 py-2 rounded-xl font-bold text-xs text-white transition flex items-center gap-1.5 cursor-pointer">
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
                iconBg.className = "w-12 h-12 rounded-xl bg-rose-100 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0";
                title.textContent = "Laporkan Buku Hilang";
                desc.textContent = "Tandai transaksi ini sebagai BUKU HILANG? Bentuk denda akan otomatis terisi menjadi 'Wajib Ganti Buku'.";
                submitBtn.className = "px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 font-bold text-xs transition cursor-pointer";
            } else if (type === 'ganti') {
                iconBg.className = "w-12 h-12 rounded-xl bg-blue-100 border border-blue-200 text-blue-600 flex items-center justify-center shrink-0";
                title.textContent = "Konfirmasi Penggantian Buku";
                desc.textContent = "Apakah siswa telah menyerahkan buku fisik pengganti? Status denda akan diperbarui menjadi 'Sudah Diganti'.";
                submitBtn.className = "px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 font-bold text-xs transition cursor-pointer";
            } else {
                iconBg.className = "w-12 h-12 rounded-xl bg-emerald-100 border border-emerald-200 text-emerald-600 flex items-center justify-center shrink-0";
                title.textContent = "Proses Pengembalian Buku";
                desc.textContent = "Proses pengembalian buku ini secara normal dan kembalikan stok buku ke perpustakaan?";
                submitBtn.className = "px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 font-bold text-xs transition cursor-pointer";
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