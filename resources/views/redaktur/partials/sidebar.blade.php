<aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl z-20">
    
    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center font-bold">V</div>
            <span class="font-bold text-lg tracking-wide">CMS<span class="text-blue-500">PANEL</span></span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        <p class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>
        
        <a href="{{ route('redaktur.dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('redaktur.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-squares-four text-xl"></i>
            <span class="text-sm font-medium">Beranda</span>
        </a>

        <a href="#" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('vcms.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-browsers text-xl"></i>
            <span class="text-sm font-medium">Profile</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Regulasi</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Dokumen</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Daftar Informasi</span>
        </a>

        <a href="{{ route('redaktur.publication') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Publikasi</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Data Publik</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
            <i class="ph ph-newspaper text-xl group-hover:text-blue-400"></i>
            <span class="text-sm font-medium">Regulasi</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-950">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">RD</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Redaktur' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->role ?? 'Editor' }}</p>
            </div>
        </div>
    </div>
</aside>