
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
        <div class="cms-editable inline-block mb-2" onclick="openEditor('search_title')" id="wrapper_search_title">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                {!! cms($page->id, 'search_title', 'Pencarian Informasi') !!}
            </h2>
        </div>
        <br>
        <div class="cms-editable inline-block mb-6" onclick="openEditor('search_desc')" id="wrapper_search_desc">
            <p class="text-gray-500 mt-2">
                {!! cms($page->id, 'search_desc', 'Temukan Informasi Publik Jawa Timur') !!}
            </p>
        </div>

        <div class="mt-6"> 
    <div class="flex items-center bg-white rounded-full shadow-md overflow-hidden mx-auto max-w-xl border-2 border-transparent focus-within:border-blue-500 transition-all">
        <input 
            type="text" 
            id="liveSearchInput" 
            placeholder="Ketik untuk mencari berita..."
            class="flex-1 px-5 py-3 focus:outline-none text-gray-700"
        >
        <button type="button" id="btnSearchClick" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 transition">
            <i class="ph ph-magnifying-glass text-xl"></i>
        </button>
    </div>
    <p id="searchStatus" class="text-xs text-gray-400 mt-3 hidden"></p>
</div>
    </div>
</section>

    <!-- 3 -->
    <section id="services" class="py-20 bg-gray-50">
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
            <i class="ph ph-file-pdf text-3xl text-blue-500"></i>
                        
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
                $gallery = array_slice($gallery, 0, 3);
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
                $newsJson = cms($page->id, 'news_cards', '[]');
                $news = json_decode($newsJson, true);
              
                if(!$news || count($news) == 0) {
                    $news = [
                        ['title' => 'Judul Berita Contoh', 'date' => '2025-01-01', 'image' => '', 'desc' => '...'],
                        ['title' => 'Berita Terbaru Hari Ini', 'date' => '2025-01-02', 'image' => '', 'desc' => '...'],
                        ['title' => 'Update Kegiatan Dinas', 'date' => '2025-01-03', 'image' => '', 'desc' => '...']
                    ];
                }

                $news = array_slice($news, 0, 3);
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
    <a href="{!! cms($page->id, 'news_btn_url', route('publikasi.index')) !!}" 
       class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-blue-500/30 font-medium">
       
       {!! cms($page->id, 'news_btn_text', 'Lihat Semua Berita') !!} 
       
       <i class="bi bi-arrow-right ml-2"></i>
    </a>
</div>

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearchInput');
    const searchBtn = document.getElementById('btnSearchClick');
    const searchStatus = document.getElementById('searchStatus');

    // Fungsi untuk mencari dan scroll ke konten
    function searchAndScroll() {
        const keyword = searchInput.value.trim().toLowerCase();
        
        if (!keyword) {
            showStatus('Masukkan kata kunci pencarian', 'warning');
            return;
        }

        // Reset highlight sebelumnya
        removeAllHighlights();

        // Array untuk menyimpan elemen yang cocok
        let matchedElements = [];

        // 1. Cari di bagian Services (Layanan Informasi)
        const serviceCards = document.querySelectorAll('#services .grid > a');
        serviceCards.forEach(card => {
            const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.text-gray-500')?.textContent.toLowerCase() || '';
            
            if (title.includes(keyword) || desc.includes(keyword)) {
                matchedElements.push({
                    element: card,
                    score: title.includes(keyword) ? 2 : 1
                });
            }
        });

        // 2. Cari di bagian News (Kabar Berita)
        const newsCards = document.querySelectorAll('#news .grid > div');
        newsCards.forEach(card => {
            const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
            
            if (title.includes(keyword)) {
                matchedElements.push({
                    element: card,
                    score: 3 // News diberi score lebih tinggi
                });
            }
        });

        // Urutkan berdasarkan score (relevansi)
        matchedElements.sort((a, b) => b.score - a.score);

        if (matchedElements.length > 0) {
            // Highlight dan scroll ke elemen pertama yang cocok
            const firstMatch = matchedElements[0].element;
            highlightElement(firstMatch);
            
            // Smooth scroll ke elemen
            const offset = 100; // Offset dari top
            const elementPosition = firstMatch.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });

            // Highlight semua elemen yang cocok
            matchedElements.forEach(item => {
                highlightElement(item.element);
            });

            
        } else {
            showStatus(`Tidak ada hasil untuk "${keyword}"`, 'error');
        }
    }

    // Fungsi untuk highlight elemen
    function highlightElement(element) {
        element.classList.add('search-highlight');
        
        // Hapus highlight setelah 3 detik
        setTimeout(() => {
            element.classList.remove('search-highlight');
        }, 3000);
    }

    // Fungsi untuk menghapus semua highlight
    function removeAllHighlights() {
        document.querySelectorAll('.search-highlight').forEach(el => {
            el.classList.remove('search-highlight');
        });
    }

    // Fungsi untuk menampilkan status
    function showStatus(message, type) {
        searchStatus.textContent = message;
        searchStatus.classList.remove('hidden', 'text-red-500', 'text-green-500', 'text-yellow-500');
        
        if (type === 'error') {
            searchStatus.classList.add('text-red-500');
        } else if (type === 'success') {
            searchStatus.classList.add('text-green-500');
        } else {
            searchStatus.classList.add('text-yellow-500');
        }

        // Sembunyikan status setelah 5 detik
        setTimeout(() => {
            searchStatus.classList.add('hidden');
        }, 5000);
    }

    // Event listener untuk button search
    searchBtn.addEventListener('click', searchAndScroll);

    // Event listener untuk Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchAndScroll();
        }
    });

    // CSS untuk highlight effect (tambahkan via JavaScript)
    const style = document.createElement('style');
    style.textContent = `
        .search-highlight {
            animation: highlightPulse 0.6s ease-in-out;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.5) !important;
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        
        @keyframes highlightPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.3);
            }
        }
    `;
    document.head.appendChild(style);

    const scrollTopBtn = document.createElement('button');
    scrollTopBtn.id = 'scrollTopBtn';
    scrollTopBtn.innerHTML = '<i class="ph ph-arrow-up text-2xl"></i>';
    scrollTopBtn.setAttribute('aria-label', 'Scroll to top');
    document.body.appendChild(scrollTopBtn);

 
    const scrollBtnStyle = document.createElement('style');
    scrollBtnStyle.textContent = `
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 9999;
        }
        
        #scrollTopBtn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        #scrollTopBtn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
            transform: translateY(-3px);
        }
        
        #scrollTopBtn:active {
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            #scrollTopBtn {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }
        }
    `;
    document.head.appendChild(scrollBtnStyle);

    // Tampilkan/sembunyikan tombol saat scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    // Event listener untuk scroll to top
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>
@endpush