
@extends('layouts.public')

@section('title', 'Publikasi & Agenda - Kominfo Jatim')

@section('content')

    <!-- 1 -->
    <section class="relative w-full bg-cover bg-center bg-no-repeat min-h-[800px] flex items-center"
         style="background-image: url('{{ cms($page->id, 'hero_bg_image', '/storage/images/kominfo.jpg') }}');">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative w-full max-w-6xl mx-auto px-6 text-left text-white z-10">
        
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
            {!! cms($page->id, 'hero_title', 'Kementerian Komunikasi dan Informatika') !!}
        </h1>

        <p class="text-lg md:text-xl mb-8 text-gray-100 md:text-justify max-w-2xl break-words">
            {!! cms($page->id, 'hero_desc', 'Deskripsi default jika database kosong...') !!}
        </p>

        <a href="{!! cms($page->id, 'hero_btn_url', '#') !!}" 
            class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium hover:shadow-blue-500/30">
            {!! cms($page->id, 'hero_btn_text', 'Lihat Selengkapnya') !!}
        </a>
        
    </div>
</section>

    <!-- 2 -->
    <section class="py-16 bg-gray-100">
    <div class="max-w-4xl mx-auto text-center px-4">
    
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            {!! cms($page->id, 'search_title', 'Pencarian Informasi') !!}
        </h2>

        <p class="text-gray-500 mt-2">
            {!! cms($page->id, 'search_desc', 'Temukan Informasi Publik Jawa Timur') !!}
        </p>

        <form method="POST" 
              action="https://ppid-demo.jatimprov.go.id/kategori/blog/search#blogdetail"
              class="mt-6">
            @csrf

            <div class="flex items-center bg-white rounded-full shadow-md overflow-hidden mx-auto max-w-xl">
                <input 
                    type="text" 
                    name="keywords" 
                    required
                    placeholder="Masukkan kata kunci..."
                    class="flex-1 px-5 py-3 focus:outline-none text-gray-700"
                >

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </form>

    </div>
</section>

    <!-- 3 -->
    <section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center">
            {!! cms($page->id, 'services_title', 'Layanan Informasi') !!}
        </h2>
        
        <p class="text-gray-500 mt-2 text-center mb-12">
            {!! cms($page->id, 'services_desc', 'Layanan informasi dapat dilakukan baik melalui daring atau luring') !!}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                // 1. Ambil data JSON
                $cardsJson = cms($page->id, 'services_cards', '[]');
                
                // 2. Decode jadi Array
                $cards = json_decode($cardsJson, true);
                
                // 3. Dummy Data jika kosong
                if(!$cards || count($cards) == 0) {
                     $cards = [
                        ['title' => 'Informasi Berkala', 'desc' => 'Informasi yang wajib diperbaharui dan diumumkan secara berkala...'],
                        ['title' => 'Informasi Serta Merta', 'desc' => 'Informasi berkaitan hajat hidup orang banyak dan ketertiban umum...'],
                        ['title' => 'Informasi Setiap Saat', 'desc' => 'Informasi yang harus tersedia setiap saat dan dapat diakses publik...']
                    ];
                }
            @endphp

            @foreach($cards as $card)
    <a href="{{ $card['url'] ?? '#' }}" target="_blank" class="block p-8 border border-blue-200 rounded-2xl shadow-sm hover:shadow-md transition bg-white text-center min-w-0 w-full h-[350px] flex flex-col mx-auto group">
        
        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-xl bg-blue-50 shrink-0 group-hover:bg-blue-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a2.625 2.625 0 00-2.625-2.625h-9a2.625 2.625 0 00-2.625 2.625v2.625M12 7.5v9m-4.5-4.5h9" />
            </svg>
        </div>

        <h3 class="text-xl font-semibold mb-3 h-[60px] overflow-hidden flex items-center justify-center px-1 break-words leading-tight group-hover:text-blue-600 transition">
            {{ $card['title'] }}
        </h3>

        <div class="text-gray-500 leading-relaxed text-sm flex-1 overflow-hidden px-1 break-words">
            {{ $card['desc'] }}
        </div>
        
    </a>
@endforeach
        </div>

    </div>
</section>

    <!-- 4 -->
    <section class="py-20 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6">
        
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 text-center">
            {!! cms($page->id, 'gallery_title', 'Galeri Berita') !!}
        </h2>
        <p class="text-gray-500 mt-2 text-center mb-12">
            {!! cms($page->id, 'gallery_desc', 'Galeri Foto kegiatan PPID...') !!}
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $galleryJson = cms($page->id, 'gallery_items', '[]');
                $gallery = json_decode($galleryJson, true);
                
                // Dummy kalau kosong
                if(!$gallery || count($gallery) == 0) {
                    $gallery = [ ['image'=>''], ['image'=>''], ['image'=>''] ];
                }
            @endphp

            @foreach($gallery as $item)
                <div class="h-64 rounded-xl shadow-sm bg-gray-300 bg-cover bg-center hover:shadow-lg transition duration-300 transform hover:scale-[1.02]"
                     style="background-image: url('{{ $item['image'] ?? '' }}');">
                </div>
            @endforeach
        </div>
        <div class="mt-12 text-center">
            <a href="{!! cms($page->id, 'gallery_btn_url', '#') !!}" 
               class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium hover:shadow-blue-500/30">
               
               {!! cms($page->id, 'gallery_btn_text', 'Lihat Semua Foto') !!}
               
               <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

    <!-- 5 -->
    <section id="news" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="text-center mb-12" data-aos="fade-up">
            <h4 class="text-2xl md:text-3xl font-bold text-gray-800 text-center">
                {!! cms($page->id, 'news_title', 'Kabar Berita') !!}
            </h4>
            <p class="text-gray-500 mt-2 text-center mb-12">
                {!! cms($page->id, 'news_desc', 'Berita Kegiatan PPID Pemerintah Provinsi Jawa Timur') !!}
            </p>
            
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="100">
            @php
                // 1. Ambil data dari JSON Database
                $newsJson = cms($page->id, 'news_cards', '[]');
                $news = json_decode($newsJson, true);
                
                // 2. Data Dummy jika kosong
                if(!$news || count($news) == 0) {
                    $news = [
                        ['title' => 'Judul Berita Contoh', 'date' => '2025-01-01', 'image' => '', 'desc' => 'Deskripsi singkat berita ini...', 'url' => '#'],
                        ['title' => 'Berita Terbaru Hari Ini', 'date' => '2025-01-02', 'image' => '', 'desc' => 'Deskripsi singkat berita ini...', 'url' => '#'],
                        ['title' => 'Update Kegiatan Dinas', 'date' => '2025-01-03', 'image' => '', 'desc' => 'Deskripsi singkat berita ini...', 'url' => '#']
                    ];
                }
            @endphp

            @foreach($news as $item)
    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 h-[380px] flex flex-col group">
        
        <div class="h-[200px] w-full bg-gray-200 overflow-hidden relative shrink-0">
            <img src="{{ !empty($item['image']) ? $item['image'] : 'https://placehold.co/600x400?text=No+Image' }}" 
                 alt="{{ $item['title'] }}"
                 class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            
            <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 ease-in-out">
                {{ $item['date'] ?? now()->format('Y-m-d') }}
            </div>
        </div>

        <div class="p-6 flex flex-col flex-1 justify-between">
            
            <h3 class="text-lg font-bold text-gray-800 h-[4.5rem] overflow-hidden leading-tight line-clamp-3 group-hover:text-blue-600 transition">
                <a href="{{ $item['url'] ?? '#' }}">
                    {{ $item['title'] }}
                </a>
            </h3>
            
            <div class="pt-4 border-t border-gray-100 mt-auto">
                <a href="{{ $item['url'] ?? '#' }}" class="text-blue-600 font-semibold text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                    Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="#" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-blue-500/30 font-medium">
                Lihat Semua Berita <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>

    </div>
</section>

@endsection


