<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegulationController extends Controller
{
    // =========================================================
    // 1. TAMPILKAN HALAMAN PUBLIC
    // =========================================================
    public function showRegulation()
    {
        // Ambil Page 'regulasi'
        $page = Page::where('slug', 'regulasi')->firstOrCreate([
            'slug' => 'regulasi',
            'title' => 'Regulasi'
        ]);

        // Ambil data regulasi LANGSUNG dari page regulasi (Bukan Home lagi)
        $json = $page->sections()->where('section_key', 'regulation_items')->value('content');
        $regulations = $json ? json_decode($json, true) : [];

        return view('regulation', compact('page', 'regulations'));
    }

    // =========================================================
    // 2. SIMPAN DATA (UPDATE)
    // =========================================================
    public function update(Request $request)
    {
        // 1. Validasi
        $request->validate(['page_slug' => 'required']);

        // 2. Tentukan Halaman Target Berdasarkan Request (Dinamis)
        // JANGAN DI-HARDCODE KE 'home' LAGI
        $page = Page::where('slug', $request->page_slug)->firstOrFail();

        // 3. Ambil Data Text
        $changes = $request->input('changes', []);

        // --- SIMPAN TEXT HEADER ---
        foreach ($changes as $key => $content) {
            if (in_array($key, ['regulasi_title', 'regulasi_desc'])) {
                Section::updateOrCreate(
                    ['page_id' => $page->id, 'section_key' => $key],
                    ['content' => $content]
                );
            }
        }

        // --- SIMPAN LIST REGULASI & UPLOAD FILE ---
        if (isset($changes['regulation_items'])) {
            $regArray = json_decode($changes['regulation_items'], true);

            if ($regArray) {
                // Gunakan reference (&$item) agar array asli berubah saat diedit
                foreach ($regArray as $index => &$item) {

                    // Key File: 'regulation_file_0', 'regulation_file_1'
                    // File dikirim terpisah di root request, bukan di dalam array changes
                    $fileKey = "regulation_file_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);

                        // Cek Tipe File & Tentukan Folder
                        $ext = $file->getClientOriginalExtension();
                        $folder = in_array(strtolower($ext), ['pdf', 'doc', 'docx']) ? 'documents/regulations' : 'uploads/regulations';

                        $filename = 'reg_' . Str::random(15) . '.' . $ext;

                        // Simpan File
                        $path = $file->storeAs($folder, $filename, 'public');

                        // Update URL di dalam item array
                        $item['url'] = '/storage/' . $path;
                    }
                }
                unset($item); // Lepaskan reference

                // Simpan Array FINAL ke Database
                Section::updateOrCreate(
                    ['page_id' => $page->id, 'section_key' => 'regulation_items'],
                    ['content' => json_encode($regArray)]
                );
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Data Regulasi berhasil disimpan!']);
    }
}
