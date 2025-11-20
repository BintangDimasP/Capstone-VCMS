<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class VcmsController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('vcms.index', compact('pages'));
    }

    // Ambil satu section untuk ditampilkan di modal
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('vcms.edit', compact('page'));
    }

    // Simpan perubahan section
    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // Semua content disimpan dalam kolom JSON
        $page->content = json_encode($request->content);
        $page->save();

        return redirect()->back()->with('success', 'Updated!');
    }
}
