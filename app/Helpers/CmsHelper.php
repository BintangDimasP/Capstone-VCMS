<?php

use App\Models\Section;

// Cek biar gak tabrakan kalau fungsi sudah ada
if (!function_exists('cms')) {
    
    /**
     * Fungsi untuk mengambil konten dari database.
     * * @param int $page_id  ID Halaman (dari $page->id)
     * @param string $key   Kunci unik section (misal: 'hero_title')
     * @param string $default Teks default jika database masih kosong
     */
    function cms($page_id, $key, $default = '')
    {
        // Cari di tabel 'sections'
        // Cocokkan ID Halaman dan Key-nya
        $section = Section::where('page_id', $page_id)
                          ->where('section_key', $key)
                          ->first();
        
        // Kalau ketemu, ambil kolom 'content'. Kalau tidak, pakai default.
        return $section ? $section->content : $default;
    }
}