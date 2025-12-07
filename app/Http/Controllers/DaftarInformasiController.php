<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DaftarInformasiController extends Controller
{
public function showInformation()
    {
        $page = Page::firstOrCreate(['slug' => 'informasi'], ['title' => 'Daftar Informasi', 'content' => []]);
        return view('information', compact('page'));
    }
}
