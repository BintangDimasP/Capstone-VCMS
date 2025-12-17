<aside class="w-64 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white flex flex-col shadow-2xl z-20 relative overflow-hidden h-screen">
    
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-sky-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="h-16 flex items-center px-6 border-b border-slate-800/50 bg-slate-950/50 backdrop-blur-xl relative z-10">
        <div class="flex items-center gap-3 group">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center font-bold shadow-lg shadow-blue-500/50 transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-6">
                A
            </div>
            <span class="font-bold text-lg tracking-wide uppercase">
                dmin<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Panel</span>
            </span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 relative z-10 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
        
        <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 mt-2 flex items-center gap-2">
            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
            Main Menu
        </p>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-gauge text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Dashboard</span>
            @if(request()->routeIs('admin.dashboard'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-lg shadow-blue-500/50 scale-[1.02]' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white hover:translate-x-1' }}">
            <i class="ph ph-users text-xl transition-transform duration-300 group-hover:scale-110"></i>
            <span class="text-sm font-medium">Kelola Pengguna</span>
            @if(request()->routeIs('admin.users.*'))
                <span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
            @endif
        </a>

     

        
    </nav>

    <div class="p-4 border-t border-slate-800/50 bg-slate-950/50 backdrop-blur-xl relative z-10">
        <div class="mb-4 flex items-center gap-3 p-2 rounded-xl bg-slate-900/50 border border-slate-800 group cursor-pointer hover:bg-slate-800/50 transition-all">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-500/30 ring-2 ring-slate-700 group-hover:ring-blue-400 transition-all">
                AD
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate group-hover:text-blue-400 transition-colors">
                    {{ Auth::user()->name ?? 'Admin' }}
                </p>
                <p class="text-[10px] text-cyan-400 font-bold uppercase tracking-tighter flex items-center gap-1">
                    <span class="w-1 h-1 bg-cyan-400 rounded-full animate-pulse"></span>
                    Super Admin
                </p>
            </div>
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