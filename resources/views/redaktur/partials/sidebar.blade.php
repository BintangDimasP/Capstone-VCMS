<aside class="w-64 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white flex flex-col shadow-2xl z-20 relative overflow-hidden">
    
    <!-- Animated Background Effect -->
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Header -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800/50 bg-slate-950/50 backdrop-blur-xl relative z-10">
        <div class="flex items-center gap-3 group">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center font-bold shadow-lg shadow-blue-500/50 transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
                V
            </div>
            <span class="font-bold text-lg tracking-wide">
                CMS<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">PANEL</span>
            </span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 relative z-10 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
        <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 mt-2 flex items-center gap-2">
            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
            Menu Utama
        </p>

        <a href="{{ route('redaktur.dashboard') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-squares-four text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Beranda</span>
            @if(request()->routeIs('redaktur.dashboard'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('redaktur.profile') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.profile') ? 'bg-gradient-to-r from-blue-500 to-sky-400 text-white shadow-lg shadow-blue-400/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-building-office text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Profil Dinas</span>
            @if(request()->routeIs('redaktur.profile'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('redaktur.regulation') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.regulation') ? 'bg-gradient-to-r from-cyan-600 to-teal-500 text-white shadow-lg shadow-cyan-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-gavel text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Regulasi</span>
            @if(request()->routeIs('redaktur.regulation'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('redaktur.documents.edit') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.documents.*') ? 'bg-gradient-to-r from-sky-600 to-cyan-500 text-white shadow-lg shadow-sky-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-files text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Dokumen Publik</span>
            @if(request()->routeIs('redaktur.documents.*'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('redaktur.information') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.information') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-lg shadow-blue-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-list-dashes text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Daftar Informasi</span>
            @if(request()->routeIs('redaktur.information'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('redaktur.publication') }}" 
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('redaktur.publication') ? 'bg-gradient-to-r from-teal-600 to-cyan-500 text-white shadow-lg shadow-teal-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-newspaper-clipping text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Publikasi</span>
            @if(request()->routeIs('redaktur.publication'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-slate-800/50 bg-slate-950/50 backdrop-blur-xl relative z-10">
        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-all duration-300 cursor-pointer group">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-xs font-bold shadow-lg shadow-blue-500/30 ring-2 ring-slate-700 group-hover:ring-cyan-400 transition-all duration-300">
                RD
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate group-hover:text-cyan-400 transition-colors">
                    {{ Auth::user()->name ?? 'Redaktur' }}
                </p>
                <p class="text-xs text-slate-400 truncate flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse"></span>
                    {{ Auth::user()->role ?? 'Editor' }}
                </p>
            </div>
            <i class="ph ph-caret-right text-slate-600 group-hover:text-cyan-400 transition-all duration-300 group-hover:translate-x-1"></i>
        </div>
    </div>
</aside>

<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Custom Scrollbar */
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 20px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #475569;
}

/* Smooth hover effect for nav items */
.nav-item {
    position: relative;
    overflow: hidden;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: linear-gradient(to bottom, #3b82f6, #06b6d4);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.nav-item:hover::before {
    transform: scaleY(1);
}
</style>