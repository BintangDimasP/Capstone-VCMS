<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import Model User
use App\Models\Page; // Import Model Page (buat statistik)

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung statistik ringkas
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRedakturs = User::where('role', 'redaktur')->count();
        
        // Kirim data ke view
        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalRedakturs'));
    }

    // Nanti kita tambahkan fungsi kelola user di sini (index, create, store, etc)
}