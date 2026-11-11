@extends('components.admin-layout')

@section('content')
    <!-- Header & Action Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-blue-950 tracking-wide">Data Anggota / Siswa</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola data siswa terdaftar untuk kemudahan transaksi peminjaman buku</p>
        </div>
        <a href="{{ route('admin.siswa.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition flex items-center gap-2 self-start md:self-auto cursor-pointer">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Tambah Siswa Baru</span>
        </a>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2 shadow-sm">
            <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <form action="{{ route('admin.siswa.index') }}" method="GET" class="p-4 rounded-2xl bg-white border border-blue-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NISN, nama, atau kelas..." 
                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-blue-950 placeholder-slate-400 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
            @if(request('search'))
                <a href="{{ route('admin.siswa.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-medium transition border border-slate-200">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <!-- Tabel Data Siswa -->
    <div class="rounded-2xl bg-white border border-blue-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-blue-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">NISN</th>
                        <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                        <th class="px-6 py-4 font-semibold">Kelas</th>
                        <th class="px-6 py-4 text-center font-semibold">L/P</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($siswas as $index => $siswa)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-6 py-4 text-slate-500 font-mono">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-blue-600">
                                {{ $siswa->nisn }}
                            </td>
                            <td class="px-6 py-4 font-bold text-blue-950">
                                {{ $siswa->nama }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] bg-slate-100 border border-slate-200 text-slate-600 font-medium">
                                    {{ $siswa->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if (strtoupper($siswa->jenis_kelamin) === 'L' || strtoupper($siswa->jenis_kelamin) === 'LAKI-LAKI')
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-blue-50 text-blue-700 border border-blue-200 font-bold uppercase">
                                        Laki-Laki
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-pink-50 text-pink-700 border border-pink-200 font-bold uppercase">
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-600 transition shadow-sm" title="Edit Data">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button" 
                                            data-id="{{ $siswa->id }}"
                                            data-nama="{{ $siswa->nama }}"
                                            class="btn-hapus-modal p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 transition shadow-sm cursor-pointer" 
                                            title="Hapus Data">
                                        <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                                    </button>
                                </div>
                                <form id="form-hapus-{{ $siswa->id }}" action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada data anggota / siswa terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($siswas->hasPages())
            <div class="p-4 border-t border-blue-100 bg-slate-50/50">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL POP-UP KONFIRMASI HAPUS -->
    <div id="modal-hapus" 
         style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 999999; display: none; align-items: center; justify-content: center; background-color: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);"
         class="p-4">
        
        <div class="bg-white border border-slate-200 rounded-2xl p-6 w-full max-w-md shadow-2xl relative" style="margin: auto;">
            
            <div class="flex items-center gap-3 text-rose-600 mb-4">
                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-950">Konfirmasi Hapus Data</h3>
                    <p class="text-xs text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600 space-y-2 mb-6">
                <p>Apakah Anda yakin ingin menghapus data anggota berikut?</p>
                <div class="pt-2 border-t border-slate-200 space-y-1">
                    <p class="text-slate-500">Nama Siswa: <span id="modal-nama-siswa" class="text-rose-600 font-bold"></span></p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" id="btn-batal-modal-hapus" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-konfirmasi-hapus" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition cursor-pointer">
                    Ya, Hapus Data
                </button>
            </div>

        </div>
    </div>

    <!-- SCRIPT POP-UP HAPUS -->
    <script>
        (function() {
            function initModalHapus() {
                const modal = document.getElementById('modal-hapus');
                if (!modal) return;

                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }

                let activeFormId = null;

                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('.btn-hapus-modal');
                    if (btn) {
                        e.preventDefault();
                        const id = btn.getAttribute('data-id');
                        const nama = btn.getAttribute('data-nama');

                        activeFormId = 'form-hapus-' + id;

                        document.getElementById('modal-nama-siswa').textContent = nama;
                        modal.style.display = 'flex';
                    }

                    if (e.target.id === 'btn-batal-modal-hapus' || e.target === modal) {
                        modal.style.display = 'none';
                        activeFormId = null;
                    }

                    if (e.target.id === 'btn-konfirmasi-hapus') {
                        if (activeFormId) {
                            const form = document.getElementById(activeFormId);
                            if (form) form.submit();
                        }
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initModalHapus);
            } else {
                initModalHapus();
            }
        })();
    </script>
@endsection