<x-user-layout>
    <x-slot:title>BBC-Reads | Katalog Perpustakaan Digital SMPN 3 Babakan Cikao</x-slot:title>

    <!-- Hero Section: Hero Banner + Search Bar -->
    <section class="mb-16 text-center max-w-3xl mx-auto">
        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 inline-block mb-4">
            Selamat Datang di Perpustakaan Digital
        </span>
        <h1 class="text-3xl md:text-5xl font-black tracking-tight text-white mb-4">
            Temukan Buku Favoritmu di <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">BBC-Reads</span>
        </h1>
        <p class="text-slate-400 text-sm md:text-base mb-8">
            Jelajahi koleksi buku perpustakaan SMPN 3 Babakan Cikao. Cek ketersediaan stok buku secara mudah dan cepat di mana saja.
        </p>

        <!-- Search Bar Futuristik -->
        <form action="#katalog" method="GET" class="relative max-w-xl mx-auto">
            <input type="text" placeholder="Cari judul buku, penulis, atau topik..." 
                class="w-full pl-12 pr-28 py-3.5 bg-slate-950/80 border border-slate-800 rounded-2xl text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-500 shadow-xl shadow-cyan-500/5 text-sm transition">
            <i data-lucide="search" class="w-5 h-5 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2"></i>
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition">
                Cari Buku
            </button>
        </form>
    </section>

    <!-- Section 1: Pengumuman / Informasi dari Admin -->
    <section id="pengumuman" class="mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-xl">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Informasi & Pengumuman Perpus</h2>
                <p class="text-xs text-slate-400">Kabar terbaru dan pengumuman resmi dari petugas perpustakaan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="p-5 rounded-2xl bg-slate-950/50 border border-slate-800 hover:border-cyan-500/30 transition">
                <span class="text-[10px] font-semibold text-cyan-400 uppercase tracking-wider">08 Oktober 2026</span>
                <h3 class="text-base font-bold text-white mt-1 mb-2">Jam Operasional Terbaru Perpustakaan</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Perpustakaan buka setiap hari Senin - Jumat pukul 07.30 - 15.00 WIB. Bagi siswa yang ingin meminjam buku fisik wajib membawa Kartu Pelajar.
                </p>
            </div>
            <div class="p-5 rounded-2xl bg-slate-950/50 border border-slate-800 hover:border-cyan-500/30 transition">
                <span class="text-[10px] font-semibold text-cyan-400 uppercase tracking-wider">05 Oktober 2026</span>
                <h3 class="text-base font-bold text-white mt-1 mb-2">Penambahan Koleksi Buku Paket & Novel Baru!</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Telah ditambah 50 judul novel terpopuler dan buku referensi IPA/Matematika kurikulum terbaru. Silakan cek di daftar katalog di bawah ini.
                </p>
            </div>
        </div>
    </section>

    <!-- Section 2: Katalog Buku -->
    <section id="katalog" class="mb-16">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl font-bold text-white">Katalog Koleksi Buku</h2>
                <p class="text-xs text-slate-400">Pilih dan lihat ketersediaan stok buku</p>
            </div>

            <!-- Filter Kategori -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs">
                <button class="px-3.5 py-2 rounded-xl bg-cyan-500 text-slate-950 font-bold">Semua</button>
                <button class="px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 hover:text-slate-200">Fiksi / Novel</button>
                <button class="px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 hover:text-slate-200">Pelajaran</button>
                <button class="px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 hover:text-slate-200">Pengetahuan</button>
            </div>
        </div>

        <!-- Grid Card Buku -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between hover:border-cyan-500/40 transition group">
                <div>
                    <div class="w-full h-48 bg-slate-900 rounded-xl mb-3 flex items-center justify-center border border-slate-800 group-hover:scale-[1.02] transition">
                        <i data-lucide="book-open" class="w-12 h-12 text-slate-700"></i>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">Fiksi</span>
                    <h3 class="font-bold text-white text-sm mt-1 line-clamp-1">Laskar Pelangi</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Andrea Hirata</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Stok: <strong class="text-emerald-400">12 Tersedia</strong></span>
                    <button class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between hover:border-cyan-500/40 transition group">
                <div>
                    <div class="w-full h-48 bg-slate-900 rounded-xl mb-3 flex items-center justify-center border border-slate-800 group-hover:scale-[1.02] transition">
                        <i data-lucide="book-open" class="w-12 h-12 text-slate-700"></i>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">Fiksi</span>
                    <h3 class="font-bold text-white text-sm mt-1 line-clamp-1">Bumi Manusia</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pramoedya A. Toer</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Stok: <strong class="text-emerald-400">5 Tersedia</strong></span>
                    <button class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between hover:border-cyan-500/40 transition group">
                <div>
                    <div class="w-full h-48 bg-slate-900 rounded-xl mb-3 flex items-center justify-center border border-slate-800 group-hover:scale-[1.02] transition">
                        <i data-lucide="book-open" class="w-12 h-12 text-slate-700"></i>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">Pelajaran</span>
                    <h3 class="font-bold text-white text-sm mt-1 line-clamp-1">Matematika SMP Kelas 8</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tim Kemendikbud</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Stok: <strong class="text-emerald-400">45 Tersedia</strong></span>
                    <button class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between hover:border-cyan-500/40 transition group">
                <div>
                    <div class="w-full h-48 bg-slate-900 rounded-xl mb-3 flex items-center justify-center border border-slate-800 group-hover:scale-[1.02] transition">
                        <i data-lucide="book-open" class="w-12 h-12 text-slate-700"></i>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">Pelajaran</span>
                    <h3 class="font-bold text-white text-sm mt-1 line-clamp-1">IPA Terpadu Kelas 7</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tim Kemendikbud</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Stok: <strong class="text-amber-400">0 Habis (Dipinjam)</strong></span>
                    <button class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Form Kotak Saran & Masukan Publik -->
    <section id="saran" class="bg-slate-950/80 border border-slate-800 rounded-3xl p-8 max-w-3xl mx-auto shadow-2xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center gap-3 mb-6">
            <div class="p-2.5 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 rounded-xl">
                <i data-lucide="message-square-plus" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Kotak Saran & Usulan Buku</h2>
                <p class="text-xs text-slate-400">Punya usulan buku baru atau saran untuk perpustakaan? Kirim di sini!</p>
            </div>
        </div>

        <form action="#" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nama Kamu (Opsional)</label>
                    <input type="text" placeholder="Contoh: Budi (Kelas 8B)" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-600 text-xs focus:outline-none focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Jenis Masukan</label>
                    <select class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-300 text-xs focus:outline-none focus:border-cyan-500">
                        <option>Usulan Judul Buku Baru</option>
                        <option>Saran Pelayanan Perpus</option>
                        <option>Lainnya</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan / Saran Kamu</label>
                <textarea rows="4" placeholder="Tuliskan judul buku yang ingin kamu usulkan atau saran untuk perpustakaan..." 
                    class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-600 text-xs focus:outline-none focus:border-cyan-500"></textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-4 h-4"></i>
                Kirim Saran Sekarang
            </button>
        </form>
    </section>
</x-user-layout>