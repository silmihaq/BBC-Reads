@extends('components.admin-layout')

@section('title', 'Saran & Masukan | BBC-Reads')

@section('content')
<div class="space-y-6">
    <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Saran & Masukan User</h1>
            <p class="text-xs text-slate-400 mt-1">Daftar umpan balik dan masukan dari siswa/pengunjung perpustakaan digital.</p>
        </div>
        <div class="p-3 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 rounded-xl w-fit">
            <i data-lucide="message-square" class="w-6 h-6"></i>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs font-bold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="text-[10px] uppercase bg-slate-950/80 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4 rounded-l-lg" width="5%">No</th>
                        <th class="py-3 px-4" width="20%">Nama Pengirim</th>
                        <th class="py-3 px-4" width="20%">Email / NISN</th>
                        <th class="py-3 px-4" width="40%">Pesan / Masukan</th>
                        <th class="py-3 px-4" width="10%">Tanggal</th>
                        <th class="py-3 px-4 text-center rounded-r-lg" width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse ($sarans as $index => $saran)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-400">{{ $sarans->firstItem() + $index }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">{{ $saran->nama }}</td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $saran->email_or_nisn ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-slate-300 leading-relaxed">{{ $saran->pesan }}</td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $saran->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus saran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-400 hover:bg-rose-500/10 rounded-lg transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Belum ada saran atau masukan dari pengunjung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sarans->hasPages())
            <div class="pt-4 border-t border-slate-800 mt-4">
                {{ $sarans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection