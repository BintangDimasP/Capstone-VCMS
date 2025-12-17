<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CMS Kominfo Jatim</title>

    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" type="image/png" href="https://ppid-demo.jatimprov.go.id/images/logo_provinsi_jawa_timur.png">

    <style>
        /* Animasi Blob */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        [v-cloak] { display: none; }
    </style>
</head>

<body class="bg-slate-950 flex items-center justify-center min-h-full m-0 overflow-hidden relative">

    <!-- Background Blob -->
    <div class="absolute inset-0 opacity-40 pointer-events-none">
        <div class="absolute top-10 left-10 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-[100px] animate-blob"></div>
        <div class="absolute top-0 right-10 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-1/2 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-4000"></div>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md relative z-10 px-4">
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl shadow-2xl border border-slate-800 p-8">

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/50 transition hover:rotate-6 hover:scale-110">
                    <img src="https://ppid-demo.jatimprov.go.id/images/logo_provinsi_jawa_timur.png"
                         class="w-10 h-auto"
                         alt="Logo Jatim">
                </div>

                <h2 class="text-2xl font-black text-white tracking-tight uppercase">
                    CMS<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">PANEL</span>
                </h2>
                <p class="text-slate-400 text-sm font-medium mt-1">
                    Sistem Informasi Publik Jatim
                </p>
            </div>

            <!-- Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex gap-3">
                    <i class="ph ph-warning-circle text-red-500 text-xl"></i>
                    <ul class="text-red-400 text-xs font-bold space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="block text-slate-300 text-xs font-bold uppercase tracking-widest ml-1">
                        Email Address
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 group-focus-within:text-blue-400">
                            <i class="ph ph-envelope text-xl"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full bg-slate-950/50 border border-slate-800 text-white pl-12 pr-4 py-3 rounded-xl focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder-slate-600 text-sm"
                            placeholder="admin@jatimprov.go.id">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-slate-300 text-xs font-bold uppercase tracking-widest ml-1">
                        Password
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 group-focus-within:text-blue-400">
                            <i class="ph ph-lock-key text-xl"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full bg-slate-950/50 border border-slate-800 text-white pl-12 pr-4 py-3 rounded-xl focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all placeholder-slate-600 text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span>LOGIN</span>
                    
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-800 text-center">
                <p class="text-xs text-slate-500 italic">
                    &copy; 2025 Kominfo Jawa Timur
                </p>
            </div>
        </div>
    </div>

    <!-- Scroll Fix -->
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
    </script>

</body>
</html>
