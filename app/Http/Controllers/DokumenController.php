<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // =========================================================
    // 1. PUBLIC VIEW (Halaman Depan)
    // =========================================================
    public function index()
    {
        // 1. Ambil Page 'dokumen' (Hanya untuk Judul Header & Deskripsi)
        $page = Page::where('slug', 'dokumen')->first();
        if (!$page) $page = new Page();

        // 2. Ambil Page 'home' (Karena List Dokumen kita simpan di sini)
        $homePage = Page::where('slug', 'home')->first();

        $documents = [];

        if ($homePage) {
            // PENTING: Ambil section 'document_items' dari $homePage, BUKAN dari $page
            $json = $homePage->sections()->where('section_key', 'document_items')->value('content');
            $documents = $json ? json_decode($json, true) : [];
        }

        return view('documents', compact('page', 'documents'));
    }

    // =========================================================
    // 2. REDAKTUR VIEW (Halaman Editor)
    // =========================================================
    // =========================================================
    // 2. REDAKTUR VIEW (Halaman Editor)
    // =========================================================
    public function edit()
    {
        // 1. Ambil Halaman 'dokumen' (Untuk Header Title/Desc)
        $docPage = Page::firstOrCreate(
            ['slug' => 'dokumen'],
            ['title' => 'Dokumen Publik', 'content' => []]
        );

        // 2. Ambil Halaman 'home' (Untuk Data List Dokumen yang numpang disana)
        // Kita pakai firstOrCreate biar aman (gak null)
        $homePage = Page::firstOrCreate(
            ['slug' => 'home'],
            ['title' => 'Beranda', 'content' => []]
        );

        // 3. Kirim KEDUA variabel ini ke View
        return view('redaktur.documents', [
            'page' => $docPage,      // Dipakai buat Header
            'homePage' => $homePage  // <--- INI YANG HILANG TADI
        ]);
    }

    // =========================================================
    // 3. UPDATE LOGIC (Simpan Data & File)
    // =========================================================
    public function update(Request $request)
    {
        $request->validate(['page_slug' => 'required']);

        // 1. Halaman Header (Milik Halaman 'dokumen')
        $docPage = Page::where('slug', 'dokumen')->firstOrFail();

        // 2. Halaman List Dokumen (Milik Halaman 'home' -> Sesuai request 'numpang' kamu)
        $homePage = Page::where('slug', 'home')->firstOrFail();

        $changesInput = $request->input('changes', []);

        // A. SIMPAN HEADER (Judul & Deskripsi) -> Masuk ke $docPage
        foreach ($changesInput as $key => $content) {
            if (in_array($key, ['doc_title', 'doc_desc'])) {
                Section::updateOrCreate(
                    ['page_id' => $docPage->id, 'section_key' => $key],
                    ['content' => $content]
                );
            }
        }

        // B. SIMPAN LIST DOKUMEN (PDF) -> Masuk ke $homePage
        if ($request->has('changes.document_items') || count($request->files) > 0) {

            $jsonContent = $changesInput['document_items'] ?? null;
            if(!$jsonContent) {
                // Ambil data lama dari HOME PAGE
                $section = Section::where('page_id', $homePage->id)->where('section_key', 'document_items')->first();
                $jsonContent = $section ? $section->content : '[]';
            }

            $docArray = json_decode($jsonContent, true);
            $hasFileUpdate = false;

            if ($docArray) {
                foreach ($docArray as $index => &$item) {
                    $fileKey = "document_file_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'doc_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('documents/public', $filename, 'public');

                        $item['url'] = '/storage/' . $path;
                        $hasFileUpdate = true;
                    }
                }
            }

            if ($hasFileUpdate || $jsonContent) {
                if($docArray) {
                     // PENTING: Simpan ke $homePage->id
                     Section::updateOrCreate(
                        ['page_id' => $homePage->id, 'section_key' => 'document_items'],
                        ['content' => json_encode($docArray)]
                    );
                }
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Dokumen berhasil diperbarui!']);
    }
}
