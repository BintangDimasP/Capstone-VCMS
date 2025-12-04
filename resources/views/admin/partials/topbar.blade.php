<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-sm z-10">
    
    <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Admin Panel')</h1>
    
    <div class="flex items-center gap-3">
        <div class="text-right hidden md:block">
            <p class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500">Super Admin</p>
        </div>
        <div class="w-9 h-9 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center font-bold border border-yellow-200">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
    </div>
</header>