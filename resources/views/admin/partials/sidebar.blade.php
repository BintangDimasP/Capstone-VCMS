<aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl z-20">
    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-950">
        <span class="font-bold text-lg tracking-wide text-yellow-500">ADMINISTRATOR</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        <p class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Main Menu</p>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-gauge text-xl"></i>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="ph ph-users text-xl"></i>
            <span class="text-sm font-medium">Kelola Pengguna</span>
        </a>

        <p class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">System</p>
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition-colors">
            <i class="ph ph-gear text-xl"></i>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-950">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-red-400 hover:text-red-300 transition w-full">
                <i class="ph ph-sign-out text-lg"></i>
                <span class="font-bold text-sm">Keluar</span>
            </button>
        </form>
    </div>
</aside>