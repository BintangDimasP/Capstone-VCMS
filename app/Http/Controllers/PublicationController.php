<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PublicationController extends Controller
{
    public function index()
{
    // 1. Ambil Data
    $page = Page::where('slug', 'home')->first();
    if (!$page) {
        $page = new Page();
        $page->id = 0;
    }

    // 2. Ambil BERITA
    $newsJson = $page->sections()->where('section_key', 'news_cards')->value('content');
    $newsArray = $newsJson ? json_decode($newsJson, true) : [];

    // 3. Ambil AGENDA/GALERI
    $galleryJson = $page->sections()->where('section_key', 'gallery_items')->value('content');
    $galleryArray = $galleryJson ? json_decode($galleryJson, true) : [];

    // 4. Normalisasi Data (SETTING WARNA BADGE DISINI)
    
    // A. Berita
    foreach ($newsArray as &$item) {
        $item['type'] = 'Berita'; 
        $item['badge_color'] = 'bg-blue-600'; // <--- PASTIKAN INI 'badge_color'
    }

    // B. Galeri
    foreach ($galleryArray as &$item) {
        $item['type'] = 'Agenda';
        $item['badge_color'] = 'bg-purple-600'; // <--- PASTIKAN INI 'badge_color'
        
        // Data default agenda
        $item['title'] = 'Dokumentasi Kegiatan';
        $item['date']  = '-';
        $item['desc']  = 'Dokumentasi foto kegiatan resmi.';
        $item['url']   = '#';
    }

    // 5. Gabung & Sortir
    $allPublications = array_merge($newsArray, $galleryArray);
    
    // Sort by Date (Terbaru di atas)
    usort($allPublications, function ($a, $b) {
        $t1 = isset($a['date']) ? strtotime($a['date']) : 0;
        $t2 = isset($b['date']) ? strtotime($b['date']) : 0;
        return $t2 - $t1;
    });

    // 6. Pagination Manual
    $perPage = 9;
    $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
    $currentItems = array_slice($allPublications, ($currentPage - 1) * $perPage, $perPage);
    
    $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
        $currentItems, 
        count($allPublications), 
        $perPage, 
        $currentPage, 
        ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
    );

    return view('publication.index', [
        'publications' => $paginatedItems,
        'page' => $page 
    ]);
}
}