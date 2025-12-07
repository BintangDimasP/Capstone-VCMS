<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class RedakturController extends Controller
{
    // =========================================================
    // 1. DASHBOARD REDAKTUR (Editor Home)
    // =========================================================
    public function dashboard()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Beranda',
                'content' => [] 
            ]
        );

        return view('redaktur.dashboard', compact('page'));
    }

    // =========================================================
    // 2. HALAMAN PUBLIKASI (Master Data Berita & Agenda)
    // =========================================================
    public function publication()
    {
        // 1. Siapkan Halaman 'Publikasi' (Untuk simpan Judul/Deskripsi Header Publikasi)
        $pubPage = Page::firstOrCreate(
            ['slug' => 'publication'],
            ['title' => 'Publikasi', 'content' => []]
        );

        // 2. Ambil Data Halaman 'Home' (Tempat penyimpanan Berita & Galeri)
        // Kita pakai firstOrCreate biar aman kalau belum ada
        $homePage = Page::firstOrCreate(
            ['slug' => 'home'],
            ['title' => 'Beranda', 'content' => []]
        );
        
        // 3. Ambil Data JSON untuk Preview (Opsional, buat Grid Preview di bawah)
        $newsJson = $homePage->sections()->where('section_key', 'news_cards')->value('content');
        $newsArray = $newsJson ? json_decode($newsJson, true) : [];
        
        $galleryJson = $homePage->sections()->where('section_key', 'gallery_items')->value('content');
        $galleryArray = $galleryJson ? json_decode($galleryJson, true) : [];

        // 4. Normalisasi Data untuk Preview
        foreach ($newsArray as &$item) { $item['type'] = 'Berita'; $item['color'] = 'bg-blue-600'; }
        foreach ($galleryArray as &$item) { 
            $item['type'] = 'Agenda'; 
            $item['color'] = 'bg-purple-600';
            $item['title'] = 'Dokumentasi'; 
            $item['desc'] = 'Dokumentasi kegiatan...';
            $item['date'] = '-';
            $item['url'] = '#';
        }

        $allPublications = array_merge($newsArray, $galleryArray);

        // 5. KIRIM DATA KE VIEW
        return view('redaktur.publication', [
            'page' => $pubPage,       // Dipakai untuk Header (Judul Halaman Publikasi)
            'homePage' => $homePage,  // PENTING: Dipakai untuk Input Hidden Berita & Galeri
            'items' => $allPublications // Dipakai untuk Grid Preview (jika ada)
        ]);
    }
}