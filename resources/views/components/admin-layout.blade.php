<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BBC-Reads Admin' }}</title>
    
    <!-- Tailwind CSS & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-full md:w-64 bg-white border-r border-slate-200 shrink-0 min-h-screen p-4 flex flex-col justify-between shadow-sm">
        <div class="space-y-6">
            <!-- Brand / Logo -->
            <div class="flex items-center gap-3 px-2 py-3 border-b border-slate-100">
                <div class="p-2.5 bg-gradient-to-tr from-blue-500 to-blue-700 rounded-xl text-white font-extrabold shadow-md shadow-blue-500/20">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-blue-950 tracking-wider">BBC-READS</h1>
                    <p class="text-[10px] text-slate-500 font-medium">Perpustakaan Digital</p>
                </div>
            </div>

            <!-- Menu Navigasi Utama -->
            <nav class="space-y-1.5">
                <span class="px-3 text-[10px] text-slate-500 uppercase tracking-wider block mb-2 font-bold">Menu Utama</span>

                <!-- Dashboard -->
                <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Anggota (Siswa) -->
                <a href="{{ Route::has('admin.siswa.index') ? route('admin.siswa.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Data Anggota (Siswa)</span>
                </a>

                <!-- Data Buku -->
                <a href="{{ Route::has('admin.buku.index') ? route('admin.buku.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.buku.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="book" class="w-4 h-4"></i>
                    <span>Data Buku</span>
                </a>

                <!-- Kategori Buku -->
                <a href="{{ Route::has('admin.kategori.index') ? route('admin.kategori.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="tags" class="w-4 h-4"></i>
                    <span>Kategori Buku</span>
                </a>

                <span class="px-3 text-[10px] text-slate-500 uppercase tracking-wider block mt-4 mb-2 font-bold">Transaksi & Laporan</span>

                <!-- Transaksi Peminjaman -->
                <a href="{{ Route::has('admin.peminjaman.index') ? route('admin.peminjaman.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="repeat" class="w-4 h-4"></i>
                    <span>Peminjaman Buku</span>
                </a>

                <!-- Pengembalian & Denda -->
                <a href="{{ Route::has('admin.pengembalian.index') ? route('admin.pengembalian.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengembalian.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Pengembalian & Denda</span>
                </a>

                <!-- Laporan Transaksi -->
                <a href="{{ Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>Laporan</span>
                </a>

                <span class="px-3 text-[10px] text-slate-500 uppercase tracking-wider block mt-4 mb-2 font-bold">Sistem</span>

                <!-- Pengaturan System -->
                <a href="{{ Route::has('admin.setting.index') ? route('admin.setting.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.setting.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Pengaturan</span>
                </a>

                <!-- Saran & Masukan User -->
                <a href="{{ Route::has('admin.saran.index') ? route('admin.saran.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.saran.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-blue-700' }}">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                    <span>Saran & Masukan</span>
                </a>
            </nav>
        </div>

        <!-- Profil Admin & Tombol Logout -->
        <div class="pt-4 border-t border-slate-100 space-y-3">
            <div class="px-2 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold text-xs shrink-0">
                    A
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-blue-950 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@bbc.reads' }}</p>
                </div>
            </div>

            <form action="{{ Route::has('admin.logout') ? route('admin.logout') : '#' }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:border hover:border-rose-200 transition-all duration-200 cursor-pointer">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 p-6 md:p-8 overflow-y-auto">
        @yield('content') 
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>