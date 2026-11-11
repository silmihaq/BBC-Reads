@extends('components.admin-layout')

@section('title', 'Saran & Masukan | BBC-Reads')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white border border-blue-100 p-6 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-blue-900 tracking-tight">Saran & Masukan User</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar umpan balik dan masukan dari siswa/pengunjung perpustakaan digital.</p>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl w-fit">
            <i data-lucide="message-square" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-xs font-bold flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Umpan Balik -->
    <div class="bg-white border border-blue-100 rounded-2xl shadow-xl shadow-blue-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead class="bg-blue-600 text-white uppercase tracking-wider border-b border-blue-700">
                    <tr>
                        <th class="py-4 px-6 font-semibold" width="5%">No</th>
                        <th class="py-4 px-6 font-semibold" width="20%">Nama Pengirim</th>
                        <th class="py-4 px-6 font-semibold" width="20%">Email / NISN</th>
                        <th class="py-4 px-6 font-semibold" width="40%">Pesan / Masukan</th>
                        <th class="py-4 px-6 font-semibold" width="10%">Tanggal</th>
                        <th class="py-4 px-6 font-semibold text-center" width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @forelse ($sarans as $index => $saran)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="py-4 px-6 text-gray-400 font-mono">{{ $sarans->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-bold text-blue-900">{{ $saran->nama }}</td>
                            <td class="py-4 px-6 text-gray-500 font-mono">{{ $saran->email_or_nisn ?? '-' }}</td>
                            <td class="py-4 px-6 text-gray-700 leading-relaxed">{{ $saran->pesan }}</td>
                            <td class="py-4 px-6 text-gray-500 font-mono">{{ $saran->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus saran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 bg-white">
                                Belum ada saran atau masukan dari pengunjung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($sarans->hasPages())
            <div class="p-4 border-t border-blue-50 bg-gray-50/50">
                {{ $sarans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection