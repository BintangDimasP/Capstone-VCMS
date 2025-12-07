<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class DaftarInformasiController extends Controller
{
    public function showInformation()
    {
        // 1. Ambil Page 'informasi' (Hanya untuk Header/Judul Halaman ini sendiri)
        $page = Page::firstOrCreate(
            ['slug' => 'informasi'],
            ['title' => 'Daftar Informasi', 'content' => []]
        );

        // 2. Ambil Page 'home' (Sumber Data Dokumen Utama)
        // Karena di VcmsController.php kita menyimpan 'information_list' ke page_id home
        $homePage = Page::where('slug', 'home')->first();

        $documents = []; // Variable untuk dikirim ke view

        if ($homePage) {
            // Ambil data 'information_list' dari halaman Home
            $infoJson = $homePage->sections()->where('section_key', 'information_list')->value('content');
            $documents = $infoJson ? json_decode($infoJson, true) : [];
        }

        // 3. Kirim ke View
        // Kita kirim $documents agar view tidak perlu decode json lagi
        return view('information', compact('page', 'documents'));
    }
}
