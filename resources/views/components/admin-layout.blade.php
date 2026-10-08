<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BBC-Reads Admin' }}</title>
    
    <!-- Tailwind CSS v4 & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-full md:w-64 bg-slate-950/80 backdrop-blur-md border-r border-slate-800/80 shrink-0 min-h-screen p-4 flex flex-col justify-between">
        <div class="space-y-6">
            <!-- Brand / Logo -->
            <div class="flex items-center gap-3 px-2 py-3 border-b border-slate-800/60">
                <div class="p-2.5 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl text-slate-950 font-extrabold shadow-lg shadow-cyan-500/20">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-white tracking-wider">BBC-READS</h1>
                    <p class="text-[10px] text-slate-500 font-medium">Perpustakaan Digital</p>
                </div>
            </div>

            <!-- Menu Navigasi Utama -->
            <nav class="space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Anggota (Siswa) -->
                <a href="{{ route('admin.siswa.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Data Anggota (Siswa)</span>
                </a>

                <!-- Data Buku -->
                <a href="{{ route('admin.buku.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.buku.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="book" class="w-4 h-4"></i>
                    <span>Data Buku</span>
                </a>

                <!-- Kategori Buku -->
                <a href="{{ Route::has('admin.kategori.index') ? route('admin.kategori.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="tags" class="w-4 h-4"></i>
                    <span>Kategori Buku</span>
                </a>

                <!-- Transaksi Peminjaman -->
                <a href="{{ route('admin.peminjaman.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="repeat" class="w-4 h-4"></i>
                    <span>Peminjaman Buku</span>
                </a>

                <!-- Pengembalian & Denda -->
                <a href="{{ Route::has('admin.pengembalian.index') ? route('admin.pengembalian.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengembalian.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Pengembalian & Denda</span>
                </a>

                <!-- Laporan Transaksi -->
                <a href="{{ Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>Laporan</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ Route::has('admin.pengaturan.index') ? route('admin.pengaturan.index') : '#' }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 shadow-sm' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Tombol Logout -->
        <div class="pt-4 border-t border-slate-800/60">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 hover:border hover:border-rose-500/20 transition-all duration-200 cursor-pointer">
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