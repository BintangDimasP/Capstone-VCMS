<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
public function showProfile()
    {
        $page = Page::where('slug', 'profil')->first();

        if (!$page) {
            $page = new Page();
            $page->id = 0;
        }

        return view('profile', compact('page'));
    }
}
