@extends('components.admin-layout')

@section('title', 'Laporan Peminjaman | BBC-Reads')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Header Page -->
    <div class="bg-white border border-blue-100 p-6 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-blue-900 tracking-tight">Laporan Peminjaman</h1>
            <p class="text-xs text-slate-500 mt-1">Pilih rentang tanggal untuk mengunduh laporan format PDF.</p>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 border border-blue-200 rounded-xl w-fit">
            <i data-lucide="file-text" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- Form Filter Tanggal -->
    <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-sm">
        <form action="{{ route('admin.laporan.pdf') }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal Mulai -->
                <div>
                    <label for="tgl_mulai" class="block text-xs font-bold uppercase tracking-wider text-blue-800 mb-2">
                        Dari Tanggal
                    </label>
                    <input type="date" id="tgl_mulai" name="tgl_mulai" value="{{ date('Y-m-01') }}" required
                        class="w-full bg-blue-50/50 border border-blue-200 rounded-xl px-4 py-2.5 text-xs text-blue-900 focus:outline-none focus:border-blue-500 transition">
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="tgl_selesai" class="block text-xs font-bold uppercase tracking-wider text-blue-800 mb-2">
                        Sampai Tanggal
                    </label>
                    <input type="date" id="tgl_selesai" name="tgl_selesai" value="{{ date('Y-m-d') }}" required
                        class="w-full bg-blue-50/50 border border-blue-200 rounded-xl px-4 py-2.5 text-xs text-blue-900 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div class="pt-4 border-t border-blue-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Download PDF Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection