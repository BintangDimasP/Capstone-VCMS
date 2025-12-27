<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    public function index()
    {
        // 1. Ambil Page
        $page = Page::where('slug', 'home')->first();

        if (!$page) {
            abort(404);
        }

        // 2. Ambil BERITA
        $newsJson = $page->sections()
            ->where('section_key', 'news_cards')
            ->value('content');

        $newsArray = $newsJson ? json_decode($newsJson, true) : [];

        // 3. Ambil AGENDA
        $galleryJson = $page->sections()
            ->where('section_key', 'gallery_items')
            ->value('content');

        $galleryArray = $galleryJson ? json_decode($galleryJson, true) : [];

        // 4. Normalisasi BERITA
        foreach ($newsArray as &$item) {
            $item['type'] = 'Berita';
            $item['badge_color'] = 'bg-blue-600';

            // 🔥 WAJIB ADA
            $item['slug'] = $item['slug'] ?? Str::slug($item['title']);
        }

        // 5. Normalisasi AGENDA
        foreach ($galleryArray as &$item) {
            $item['type'] = 'Agenda';
            $item['badge_color'] = 'bg-purple-600';

            $item['title'] = $item['title'] ?? 'Agenda Kegiatan';
            $item['date']  = $item['date'] ?? '-';
            $item['desc']  = $item['desc'] ?? 'Dokumentasi foto kegiatan resmi.';
            $item['url']   = $item['url'] ?? '#';

            // 🔥 WAJIB ADA
            $item['slug'] = $item['slug'] ?? Str::slug($item['title']);
        }

        // 6. Gabung & Urutkan
        $allPublications = array_merge($newsArray, $galleryArray);

        usort($allPublications, function ($a, $b) {
            return strtotime($b['date'] ?? '1970-01-01') 
                 - strtotime($a['date'] ?? '1970-01-01');
        });

        // 7. Pagination
        $perPage = 99;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice(
            $allPublications,
            ($currentPage - 1) * $perPage,
            $perPage
        );

        $paginatedItems = new LengthAwarePaginator(
            $currentItems,
            count($allPublications),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('publication.index', [
            'publications' => $paginatedItems,
        ]);
    }

    // =============================
    // DETAIL BERITA
    // =============================
    public function showBerita($slug)
    {
        $page = Page::where('slug', 'home')->firstOrFail();

        $newsJson = $page->sections()
            ->where('section_key', 'news_cards')
            ->value('content');

        $news = collect(json_decode($newsJson, true))
            ->map(function ($item) {
                $item['slug'] = $item['slug'] ?? Str::slug($item['title']);
                return $item;
            })
            ->firstWhere('slug', $slug);

        abort_if(!$news, 404);

        return view('publication.detail-berita', compact('news'));
    }

    // =============================
    // DETAIL AGENDA
    // =============================
    public function showAgenda($slug)
{
    $page = Page::where('slug', 'home')->firstOrFail();

    $galleryJson = $page->sections()
        ->where('section_key', 'gallery_items')
        ->value('content');

    $agenda = collect(json_decode($galleryJson, true))
        ->map(function ($item) {
            // 🔥 NORMALISASI WAJIB
            $item['title'] = $item['title'] ?? 'Agenda Kegiatan';
            $item['slug']  = $item['slug'] ?? Str::slug($item['title']);
            $item['date']  = $item['date'] ?? '-';
            $item['desc']  = $item['desc'] ?? 'Dokumentasi kegiatan resmi.';
            $item['image'] = $item['image'] ?? 'https://placehold.co/800x500';
            return $item;
        })
        ->firstWhere('slug', $slug);

    abort_if(!$agenda, 404);

    return view('publication.detail-agenda', compact('agenda'));
}


}
