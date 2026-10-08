<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BBC-Reads | Perpustakaan SMPN 3 Babakan Cikao' }}</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- Header Navbar Publik -->
    <header class="h-20 border-b border-slate-800 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto h-full px-6 flex items-center justify-between">
            <!-- Brand / Logo -->
            <a href="{{ route('user.home') }}" class="flex items-center gap-3">
                <div class="p-2 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl shadow-lg shadow-cyan-500/30">
                    <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-white tracking-wider">BBC-READS</h1>
                    <p class="text-[10px] text-cyan-400 font-medium">SMPN 3 Babakan Cikao</p>
                </div>
            </a>

            <!-- Navigasi Utama -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('user.home') }}" class="text-cyan-400 flex items-center gap-2">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <a href="#katalog" class="text-slate-400 hover:text-slate-200 transition flex items-center gap-2">
                    <i data-lucide="book" class="w-4 h-4"></i> Katalog Buku
                </a>
                <a href="#pengumuman" class="text-slate-400 hover:text-slate-200 transition flex items-center gap-2">
                    <i data-lucide="megaphone" class="w-4 h-4"></i> Informasi Perpus
                </a>
                <a href="#saran" class="text-slate-400 hover:text-slate-200 transition flex items-center gap-2">
                    <i data-lucide="message-square-plus" class="w-4 h-4"></i> Kirim Saran
                </a>
            </nav>

            <!-- Tombol Portal Petugas (Satu-satunya akses login admin) -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.login') }}" class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-800 hover:bg-slate-800/80 text-slate-400 hover:text-slate-200 transition flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-cyan-400"></i>
                    Portal Admin
                </a>
            </div>
        </div>
    </header>

    <!-- Body Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950/60 py-8 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 BBC-Reads — Perpustakaan Digital SMPN 3 Babakan Cikao.</p>
            <p class="text-slate-600">Dibuat untuk Literasi Siswa SMPN 3 Babakan Cikao</p>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>