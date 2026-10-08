<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | BBC-Reads</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo / Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center p-3 bg-cyan-500/10 border border-cyan-500/20 rounded-2xl mb-3">
                <i data-lucide="shield-check" class="w-8 h-8 text-cyan-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">BBC-Reads Admin</h1>
            <p class="text-slate-400 text-xs mt-1">Sistem Informasi Perpustakaan SMPN 3 Babakan Cikao</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 sm:p-8 backdrop-blur-sm shadow-xl">
            <h2 class="text-lg font-bold text-white mb-6 border-b border-slate-800/80 pb-3">Masuk ke Panel Admin</h2>

            <!-- Session Alert Error -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-1.5">
                            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off" class="space-y-5">
                @csrf

                <!-- Username / Email Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                        Email / Username Admin
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            autocomplete="new-password"
                            placeholder="Masukkan Email"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-cyan-500 transition"
                        >
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-300">
                        <input type="checkbox" name="remember" class="rounded bg-slate-950 border-slate-800 text-cyan-500 focus:ring-0 focus:ring-offset-0">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-cyan-500/20 transition flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk Sistem</span>
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-slate-600 text-xs mt-6">
            &copy; {{ date('Y') }} SMPN 3 Babakan Cikao. All rights reserved.
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>