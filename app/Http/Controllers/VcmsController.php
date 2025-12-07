<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VcmsController extends Controller
{
    // Function untuk menampilkan Halaman Depan (Public)
    public function showHome()
    {
        $page = Page::where('slug', 'home')->first();

        // Handle jika database kosong (biar tidak error)
        if (!$page) {
            $page = new Page();
            $page->id = 0;
        }

        return view('home', compact('page'));
    }

    // Function Legacy (Bisa dibiarkan atau dihapus jika tidak dipakai)
    public function index()
    {
        $pages = Page::all();
        return view('vcms.index', compact('pages'));
    }

    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('vcms.edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $page->content = json_encode($request->content);
        $page->save();
        return redirect()->back()->with('success', 'Updated!');
    }

    // =================================================================
    // CORE FUNCTION: UPDATE BATCH (Text, PDF, Images)
    // =================================================================
    public function updatePageBatch(Request $request)
    {
        // A. VALIDASI DASAR
        $request->validate([
            'page_slug' => 'required',
        ]);

        $page = Page::where('slug', $request->page_slug)->firstOrFail();

        // B. GABUNGKAN DATA INPUT (TEKS) DAN FILES (GAMBAR/PDF)
        // Supaya controller 'sadar' kalau ada perubahan, baik itu teks atau file
        $changesInput = $request->input('changes', []);
        $changesFiles = $request->file('changes', []);
        $changes = array_merge($changesInput, $changesFiles);

        // ---------------------------------------------------------
        // TAHAP 1: SIMPAN PERUBAHAN STANDAR (Key-Value)
        // (Judul Hero, Deskripsi, Background Hero, Judul Section Lain)
        // ---------------------------------------------------------
        foreach ($changes as $key => $content) {
            $finalContent = $content;

            // Cek apakah ini File Upload biasa (misal: Background Hero)
            if ($request->hasFile("changes.$key")) {
                $file = $request->file("changes.$key");
                $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads', $filename, 'public');
                $finalContent = '/storage/' . $path;
            }

            // Simpan ke Database (Tabel Sections)
            Section::updateOrCreate(
                ['page_id' => $page->id, 'section_key' => $key],
                ['content' => $finalContent]
            );
        }

        // ---------------------------------------------------------
        // TAHAP 2: HANDLE LAYANAN (PDF di dalam JSON)
        // ---------------------------------------------------------
        if (isset($changes['services_cards'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'services_cards')->first();
            $cardsArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($cardsArray) {
                foreach ($cardsArray as $index => &$card) {
                    // Key file dari Javascript: 'service_file_0'
                    $fileKey = "service_file_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'doc_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('documents', $filename, 'public');

                        // Update property 'url'
                        $card['url'] = '/storage/' . $path;
                        $hasFileUpdate = true;
                    }
                }
            }

            if ($hasFileUpdate) {
                $section->content = json_encode($cardsArray);
                $section->save();
            }
        }

        // ---------------------------------------------------------
        // TAHAP 3: HANDLE GALERI FOTO (GAMBAR di dalam JSON)
        // (Ditaruh SEBELUM Berita sesuai request)
        // ---------------------------------------------------------
        if (isset($changes['gallery_items'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'gallery_items')->first();
            $galleryArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($galleryArray) {
                foreach ($galleryArray as $index => &$item) {
                    // Key file dari Javascript: 'gallery_image_0'
                    $fileKey = "gallery_image_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'galeri_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('uploads/gallery', $filename, 'public');

                        // Update property 'image'
                        $item['image'] = '/storage/' . $path;
                        $hasFileUpdate = true;
                    }
                }
            }

            if ($hasFileUpdate) {
                $section->content = json_encode($galleryArray);
                $section->save();
            }
        }

        // ---------------------------------------------------------
        // TAHAP 4: HANDLE BERITA (GAMBAR THUMBNAIL di dalam JSON)
        // (Ditaruh SETELAH Galeri)
        // ---------------------------------------------------------
        if (isset($changes['news_cards'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'news_cards')->first();
            $newsArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($newsArray) {
                foreach ($newsArray as $index => &$item) {
                    // Key file dari Javascript: 'news_image_0'
                    $fileKey = "news_image_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'news_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('uploads', $filename, 'public');

                        // Update property 'image'
                        $item['image'] = '/storage/' . $path;
                        $hasFileUpdate = true;
                    }
                }
            }

            if ($hasFileUpdate) {
                $section->content = json_encode($newsArray);
                $section->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Semua data dan file berhasil disimpan!']);
    }
}
