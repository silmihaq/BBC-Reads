@extends('components.admin-layout')

@section('title', 'Pengaturan Sistem | BBC-Reads')

@section('content')
<div class="max-w-5xl space-y-6">
    <!-- Header -->
    <div class="bg-white border border-blue-100 p-6 rounded-2xl shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-blue-900 tracking-tight">Pengaturan Sistem</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola identitas sekolah, daftar tim pustakawan, dan keamanan akun administrator.</p>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 border border-blue-100 rounded-xl w-fit">
            <i data-lucide="settings" class="w-6 h-6"></i>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-xs font-bold flex items-center gap-2 shadow-sm">
            <i data-lucide="check-circle" class="w-4 h-4"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Section 1: Informasi Sekolah -->
    <form action="{{ route('admin.setting.update') }}" method="POST" class="bg-white border border-blue-100 rounded-2xl p-6 shadow-sm space-y-4">
        @csrf
        <div class="flex items-center gap-2 pb-3 border-b border-blue-50">
            <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
            <h2 class="text-sm font-bold text-blue-900 uppercase tracking-wider">Informasi Sekolah</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $settings['nama_sekolah']) }}" required
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Alamat Sekolah</label>
                <input type="text" name="alamat_sekolah" value="{{ old('alamat_sekolah', $settings['alamat_sekolah']) }}" required
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telepon_sekolah" value="{{ old('telepon_sekolah', $settings['telepon_sekolah']) }}"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Email Resmi Sekolah</label>
                <input type="email" name="email_sekolah" value="{{ old('email_sekolah', $settings['email_sekolah']) }}"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Informasi Sekolah
            </button>
        </div>
    </form>

    <!-- Section 2: Manajemen Pustakawan -->
    <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-blue-50">
            <div class="flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                <h2 class="text-sm font-bold text-blue-900 uppercase tracking-wider">Tim Pustakawan</h2>
            </div>
        </div>

        <!-- Form Tambah Pustakawan Baru -->
        <form action="{{ route('admin.pustakawan.store') }}" method="POST" enctype="multipart/form-data" class="bg-blue-50/50 p-4 border border-blue-100 rounded-xl space-y-4">
            @csrf
            <h3 class="text-xs font-bold text-blue-700 uppercase tracking-wider">Tambah Pustakawan Baru</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Nama Pustakawan"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">NIP (Opsional)</label>
                    <input type="text" name="nip" placeholder="Nomor NIP"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jabatan / Peran</label>
                    <input type="text" name="jabatan" value="Kepala Perpustakaan" required
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pesan Sambutan / Kutipan</label>
                    <input type="text" name="sambutan" placeholder="Kutipan semangat membaca..."
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*"
                        class="block w-full text-[10px] text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 file:transition cursor-pointer">
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Pustakawan
                </button>
            </div>
        </form>

        <!-- Daftar Pustakawan Terdaftar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($pustakawans as $p)
                <div class="p-4 bg-white border border-gray-200 hover:border-blue-200 hover:shadow-sm rounded-xl flex items-center justify-between gap-4 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="user" class="w-6 h-6 text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-blue-900 leading-tight">{{ $p->nama }}</h4>
                            <span class="text-[10px] font-semibold text-blue-600 block mt-0.5">{{ $p->jabatan }}</span>
                            <span class="text-[10px] text-gray-500 block">NIP. {{ $p->nip ?? '-' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('admin.pustakawan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pustakawan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-xs text-gray-500 col-span-2 text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">Belum ada data pustakawan yang ditambahkan.</p>
            @endforelse
        </div>
    </div>

    <!-- Section 3: Ubah Password Admin -->
    <div class="bg-white border border-blue-100 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex items-center gap-2 pb-3 border-b border-blue-50">
            <i data-lucide="key-round" class="w-4 h-4 text-amber-500"></i>
            <h2 class="text-sm font-bold text-blue-900 uppercase tracking-wider">Ubah Password Admin</h2>
        </div>

        <form action="{{ route('admin.setting.password') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="new_password" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-800 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-md shadow-amber-500/20 transition flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection