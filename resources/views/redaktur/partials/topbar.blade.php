<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-sm z-10">
    
    <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-2 font-medium">
            <i class="ph ph-arrow-square-out text-lg"></i> Lihat Website
        </a>
    </div>

    <div class="flex items-center gap-4">
        <span id="unsavedIndicator" class="hidden text-xs text-yellow-600 font-bold bg-yellow-100 px-2 py-1 rounded">
            Ada perubahan belum disimpan
        </span>

        <button type="button" id="btnSaveGlobal" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold opacity-50 cursor-not-allowed" disabled>
            <i class="ph ph-floppy-disk"></i> Save Changes
        </button>
        
        <div class="h-6 w-px bg-gray-300"></div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-sm font-bold text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg transition-colors">
                <i class="ph ph-sign-out text-lg"></i>
                Log Out
            </button>
        </form>
    </div>
</header>