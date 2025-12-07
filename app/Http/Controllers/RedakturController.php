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
    // Halaman Editor Regulasi
    public function regulation()
    {
        // Siapkan halaman 'regulasi'
        $regPage = Page::firstOrCreate(
            ['slug' => 'regulasi'],
            ['title' => 'Regulasi', 'content' => []]
        );

        // Ambil data regulasi dari halaman 'home' (karena numpang simpan disana)
        // Atau kalau mau rapi, simpan di halaman 'regulasi' sendiri juga boleh.
        // TAPI biar konsisten dengan sebelumnya (numpang di home), kita ambil dari home.
        $homePage = Page::where('slug', 'home')->first();

        $regulations = [];
        if ($homePage) {
            $json = $homePage->sections()->where('section_key', 'regulation_items')->value('content');
            $regulations = $json ? json_decode($json, true) : [];
        }

        return view('redaktur.regulation', [
            'page' => $regPage,
            'homePage' => $homePage, // Kirim homePage untuk ID input hidden
            'items' => $regulations
        ]);
    }
    // Halaman Editor Profil
    public function profile()
    {
        // Buat atau Ambil page dengan slug 'profil'
        $page = Page::firstOrCreate(
            ['slug' => 'profil'],
            ['title' => 'Profil Dinas', 'content' => []]
        );

        return view('redaktur.profile', compact('page'));
    }
    public function information()
    {
        // 1. Halaman Informasi (Header)
        $page = Page::firstOrCreate(
            ['slug' => 'informasi'],
            ['title' => 'Daftar Informasi', 'content' => []]
        );

        // 2. Halaman Home (Sumber Data Dokumen) --- INI YANG KURANG TADI
        $homePage = Page::firstOrCreate(
            ['slug' => 'home'],
            ['title' => 'Beranda', 'content' => []]
        );

        // 3. Kirim KEDUANYA ke view
        return view('redaktur.information', [
            'page' => $page,
            'homePage' => $homePage // <-- Variabel ini wajib dikirim!
        ]);
    }
}
