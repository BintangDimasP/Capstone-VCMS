<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class RedakturController extends Controller
{
    public function dashboard()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Beranda',
                // UBAH DARI '' MENJADI [] (Array Kosong)
                'content' => [] 
            ]
        );

        return view('redaktur.dashboard', compact('page'));
    }
}