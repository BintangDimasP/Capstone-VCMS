@extends('admin.layout')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
                <i class="ph ph-users-three"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</h3>
            </div>
        </div>
        </div>

    <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl shadow-lg p-8 text-white">
        <h2 class="text-2xl font-bold mb-2">Selamat Datang, Admin! 🛡️</h2>
        <p class="opacity-90 max-w-2xl">
            Panel ini khusus untuk manajemen sistem dan pengguna.
        </p>
    </div>
@endsection