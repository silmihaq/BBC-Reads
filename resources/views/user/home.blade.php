<x-user-layout>
    <x-slot:title>BBC-Reads | Katalog Perpustakaan Digital {{ $namaSekolah ?? 'SMPN 3 Babakan Cikao' }}</x-slot:title>

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
            Jelajahi koleksi buku perpustakaan {{ $namaSekolah ?? 'SMPN 3 Babakan Cikao' }}. Cek ketersediaan stok buku secara mudah dan cepat di mana saja.
        </p>

        <!-- Search Bar Futuristik -->
        <form action="{{ route('user.home') }}#katalog" method="GET" class="relative max-w-xl mx-auto">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul buku, penulis, atau topik..." 
                class="w-full pl-12 pr-28 py-3.5 bg-slate-950/80 border border-slate-800 rounded-2xl text-slate-100 placeholder-slate-500 focus:outline-none focus:border-cyan-500 shadow-xl shadow-cyan-500/5 text-sm transition">
            <i data-lucide="search" class="w-5 h-5 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2"></i>
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition">
                Cari Buku
            </button>
        </form>
    </section>

    <!-- Section: Tim Pustakawan Estetik (Multi-Pustakawan Grid) -->
    @if (isset($pustakawans) && $pustakawans->count() > 0)
        <section id="pustakawan" class="mb-16">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-widest block">Pengelola Perpustakaan</span>
                    <h2 class="text-xl font-bold text-white">Tim Pustakawan Usaha Literasi</h2>
                </div>
                <div class="hidden md:flex items-center gap-4 text-xs text-slate-400">
                    <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-cyan-400"></i> {{ $alamatSekolah }}</span>
                </div>
            </div>

            <!-- Grid Card Pustakawan Estetik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($pustakawans as $p)
                    <div class="bg-slate-950/60 border border-slate-800 hover:border-cyan-500/40 rounded-3xl p-5 shadow-xl transition-all duration-300 group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-900 border-2 border-cyan-500/30 group-hover:border-cyan-400 shrink-0 transition">
                                    @if ($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-600">
                                            <i data-lucide="user" class="w-7 h-7"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider block">{{ $p->jabatan }}</span>
                                    <h3 class="text-sm font-bold text-white leading-tight mt-0.5 group-hover:text-cyan-300 transition">{{ $p->nama }}</h3>
                                    <p class="text-[10px] text-slate-500 mt-0.5">NIP. {{ $p->nip ?? '-' }}</p>
                                </div>
                            </div>
                            @if ($p->sambutan)
                                <p class="text-xs text-slate-400 italic leading-relaxed border-t border-slate-800/80 pt-3">
                                    "{{ $p->sambutan }}"
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

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
                <p class="text-xs text-slate-400">Pilih buku untuk melihat detail sinopsis dan status ketersediaan</p>
            </div>

            <!-- Filter Kategori -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs">
                <a href="{{ route('user.home') }}#katalog" 
                   class="px-3.5 py-2 rounded-xl {{ !request('kategori') ? 'bg-cyan-500 text-slate-950 font-bold' : 'bg-slate-950 border border-slate-800 text-slate-400 hover:text-slate-200' }}">
                   Semua
                </a>
                @if (isset($kategoris))
                    @foreach ($kategoris as $kat)
                        <a href="{{ route('user.home', ['kategori' => $kat->id]) }}#katalog" 
                           class="px-3.5 py-2 rounded-xl {{ request('kategori') == $kat->id ? 'bg-cyan-500 text-slate-950 font-bold' : 'bg-slate-950 border border-slate-800 text-slate-400 hover:text-slate-200' }}">
                           {{ $kat->nama_kategori }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Grid Card Buku Dinamis -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($bukus as $buku)
                <div onclick="openBookModal({{ $buku->id }})" 
                     class="bg-slate-950/60 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between hover:border-cyan-500/50 hover:shadow-xl hover:shadow-cyan-500/10 transition group cursor-pointer">
                    <div>
                        <!-- Sampul Buku Full (object-contain) -->
                        <div class="w-full h-52 bg-slate-900/90 rounded-xl mb-3 flex items-center justify-center border border-slate-800/80 group-hover:scale-[1.02] transition overflow-hidden p-2">
                            @if ($buku->sampul)
                                <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain rounded-lg">
                            @elseif ($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain rounded-lg">
                            @else
                                <div class="text-center">
                                    <i data-lucide="book-open" class="w-10 h-10 text-slate-700 mx-auto mb-1"></i>
                                    <span class="text-[10px] text-slate-600 block">Tanpa Sampul</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">
                            {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <h3 class="font-bold text-white text-sm mt-1 line-clamp-1 group-hover:text-cyan-400 transition" title="{{ $buku->judul }}">{{ $buku->judul }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $buku->penulis ?? 'Penulis Tidak Diketahui' }}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">
                            Stok: 
                            @if ($buku->stok > 0)
                                <strong class="text-emerald-400">{{ $buku->stok }} Tersedia</strong>
                            @else
                                <strong class="text-amber-400">0 Habis</strong>
                            @endif
                        </span>
                        <button class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 group-hover:bg-cyan-500 group-hover:text-slate-950 transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-2 md:col-span-4 text-center py-12 bg-slate-950/40 border border-slate-800/60 rounded-3xl">
                    <i data-lucide="book-open-check" class="w-12 h-12 mx-auto text-slate-600 mb-3"></i>
                    <p class="text-sm font-semibold text-slate-300">Belum Ada Koleksi Buku yang Tersedia</p>
                    <p class="text-xs text-slate-500 mt-1">Buku yang ditambahkan oleh admin akan otomatis tampil di sini.</p>
                </div>
            @endforelse
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

        @if (session('success'))
            <div class="mb-4 p-3.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs font-bold flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('saran.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nama Kamu</label>
                    <input type="text" name="nama" required placeholder="Contoh: Budi (Kelas 8B)" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-600 text-xs focus:outline-none focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email / NISN (Opsional)</label>
                    <input type="text" name="email_or_nisn" placeholder="NISN atau Email" 
                        class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-600 text-xs focus:outline-none focus:border-cyan-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan / Saran Kamu</label>
                <textarea name="pesan" rows="4" required placeholder="Tuliskan judul buku yang ingin kamu usulkan atau saran untuk perpustakaan..." 
                    class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-600 text-xs focus:outline-none focus:border-cyan-500"></textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-cyan-500/20 hover:opacity-90 transition flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-4 h-4"></i>
                Kirim Saran Sekarang
            </button>
        </form>
    </section>

    <!-- Modal Detail Buku Futuristik -->
    <div id="bookModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md hidden opacity-0 transition-opacity duration-300">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 md:p-8 relative shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <!-- Close Button -->
            <button onclick="closeBookModal()" class="absolute top-5 right-5 p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="flex flex-col md:flex-row gap-6 items-start">
                <!-- Sampul Modal Full -->
                <div class="w-full md:w-1/3 bg-slate-950 p-3 rounded-2xl border border-slate-800 flex justify-center items-center h-64 md:h-72">
                    <img id="modalCover" src="" alt="Cover" class="w-full h-full object-contain rounded-lg hidden">
                    <div id="modalCoverPlaceholder" class="text-center py-10 text-slate-600">
                        <i data-lucide="book-open" class="w-16 h-16 mx-auto mb-2"></i>
                        <span class="text-xs">Sampul Tidak Tersedia</span>
                    </div>
                </div>

                <!-- Info Detail -->
                <div class="w-full md:w-2/3 space-y-4">
                    <div>
                        <span id="modalKategori" class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider px-2.5 py-1 bg-cyan-500/10 border border-cyan-500/20 rounded-full inline-block mb-2"></span>
                        <h2 id="modalJudul" class="text-2xl font-black text-white leading-tight"></h2>
                        <p id="modalPenulis" class="text-sm text-slate-400 mt-1"></p>
                    </div>

                    <!-- Meta Grid -->
                    <div class="grid grid-cols-2 gap-3 p-3 bg-slate-950/60 border border-slate-800/80 rounded-2xl text-xs">
                        <div>
                            <span class="text-slate-500 block">Penerbit</span>
                            <strong id="modalPenerbit" class="text-slate-200"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Tahun Terbit</span>
                            <strong id="modalTahun" class="text-slate-200"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">ISBN</span>
                            <strong id="modalIsbn" class="text-slate-200"></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Status Stok</span>
                            <strong id="modalStok"></strong>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Sinopsis Buku</h4>
                        <p id="modalSinopsis" class="text-xs text-slate-400 leading-relaxed max-h-36 overflow-y-auto pr-1"></p>
                    </div>

                    <div class="pt-2 flex gap-3">
                        <button onclick="closeBookModal()" class="w-full py-2.5 bg-slate-800 text-slate-300 font-bold text-xs rounded-xl hover:bg-slate-700 transition">
                            Tutup Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Modal Fetching -->
    <script>
        function openBookModal(id) {
            const modal = document.getElementById('bookModal');
            modal.classList.remove('hidden');
            setTimeout(function() {
                modal.classList.remove('opacity-0');
            }, 10);

            document.getElementById('modalJudul').innerText = 'Memuat data...';
            document.getElementById('modalPenulis').innerText = '';
            document.getElementById('modalKategori').innerText = '...';
            document.getElementById('modalPenerbit').innerText = '-';
            document.getElementById('modalTahun').innerText = '-';
            document.getElementById('modalIsbn').innerText = '-';
            document.getElementById('modalStok').innerText = '-';
            document.getElementById('modalSinopsis').innerText = 'Sedang mengambil sinopsis...';

            fetch('/buku/' + id)
                .then(function(res) { return res.json(); })
                .then(function(buku) {
                    document.getElementById('modalJudul').innerText = buku.judul || 'Tanpa Judul';
                    document.getElementById('modalPenulis').innerText = 'Karya: ' + (buku.penulis || buku.pengarang || 'Tidak Diketahui');
                    document.getElementById('modalKategori').innerText = buku.kategori ? buku.kategori.nama_kategori : (buku.kategori || 'Umum');
                    document.getElementById('modalPenerbit').innerText = buku.penerbit || '-';
                    document.getElementById('modalTahun').innerText = buku.tahun_terbit || buku.tahun || '-';
                    document.getElementById('modalIsbn').innerText = buku.isbn || '-';
                    document.getElementById('modalSinopsis').innerText = buku.sinopsis || buku.deskripsi || 'Belum ada deskripsi / sinopsis untuk buku ini.';

                    const stokElem = document.getElementById('modalStok');
                    if ((buku.stok || 0) > 0) {
                        stokElem.className = 'text-emerald-400';
                        stokElem.innerText = buku.stok + ' Buku Tersedia';
                    } else {
                        stokElem.className = 'text-amber-400';
                        stokElem.innerText = 'Stok Habis (Dipinjam)';
                    }

                    const modalCover = document.getElementById('modalCover');
                    const placeholder = document.getElementById('modalCoverPlaceholder');
                    const coverPath = buku.sampul || buku.cover;

                    if (coverPath) {
                        modalCover.src = '/storage/' + coverPath;
                        modalCover.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    } else {
                        modalCover.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                    }
                })
                .catch(function(err) {
                    document.getElementById('modalSinopsis').innerText = 'Gagal memuat detail buku.';
                });
        }

        function closeBookModal() {
            const modal = document.getElementById('bookModal');
            modal.classList.add('opacity-0');
            setTimeout(function() {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</x-user-layout>