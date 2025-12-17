<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VcmsController extends Controller
{
    // public
    public function showHome()
    {
        $page = Page::where('slug', 'home')->first();
        if (!$page) {
            $page = new Page();
            $page->id = 0;
        }

        return view('home', compact('page'));
    }

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

    public function updatePageBatch(Request $request)
    {
        $request->validate([
            'page_slug' => 'required',
        ]);

        $page = Page::where('slug', $request->page_slug)->firstOrFail();

        $changesInput = $request->input('changes', []);
        $changesFiles = $request->file('changes', []);
        $changes = array_merge($changesInput, $changesFiles);

        foreach ($changes as $key => $content) {
            $finalContent = $content;

            if ($request->hasFile("changes.$key")) {
                $file = $request->file("changes.$key");
                $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads', $filename, 'public');
                $finalContent = '/storage/' . $path;
            }

            Section::updateOrCreate(
                ['page_id' => $page->id, 'section_key' => $key],
                ['content' => $finalContent]
            );
        }

        if (isset($changes['services_cards'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'services_cards')->first();
            $cardsArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($cardsArray) {
                foreach ($cardsArray as $index => &$card) {
                    
                    $fileKey = "service_file_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'doc_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('documents', $filename, 'public');

                        
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

        // s3
        if (isset($changes['gallery_items'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'gallery_items')->first();
            $galleryArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($galleryArray) {
                foreach ($galleryArray as $index => &$item) {
                    
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

        if (isset($changes['news_cards'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'news_cards')->first();
            $newsArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($newsArray) {
                foreach ($newsArray as $index => &$item) {
                    
                    $fileKey = "news_image_" . $index;

                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'news_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('uploads', $filename, 'public');

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

        if (isset($changes['information_list'])) {
            $section = Section::where('page_id', $page->id)->where('section_key', 'information_list')->first();
            $infoArray = $section ? json_decode($section->content, true) : [];
            $hasFileUpdate = false;

            if($infoArray) {
                foreach ($infoArray as $index => &$item) {
                    $fileKey = "info_file_" . $index;
                    if ($request->hasFile($fileKey)) {
                        $file = $request->file($fileKey);
                        $filename = 'info_' . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('documents/public', $filename, 'public');
                        $item['file_url'] = '/storage/' . $path;
                        $hasFileUpdate = true;
                    }
                }
            }

            if ($hasFileUpdate) {
                $section->content = json_encode($infoArray);
                $section->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Semua data berhasil disimpan!']);
    }

}

