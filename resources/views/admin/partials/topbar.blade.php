<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-end px-6 shadow-sm z-10">
    
    <div class="flex items-center gap-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-sm font-bold text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg transition-colors">
                <i class="ph ph-sign-out text-lg"></i>
                Log Out
            </button>
        </form>
    </div>

</header>