@extends('redaktur.layout') 

@section('content')

    <input type="hidden" id="pageSlug" value="home">

    <style>
    .cms-editable {
        position: relative;
        padding: 10px 16px;
        border: 2px dashed transparent;
        border-radius: 6px;
        transition: 0.2s ease-in-out;
        cursor: pointer;
    }

    .cms-editable:hover {
        border-color: #f5c518;
        background: rgba(255, 255, 255, 0.05);
    }

    /* Label kuning kiri atas */
    .cms-editable::before {
        content: "Has Edit";
        position: absolute;
        top: -12px;
        left: 0;
        background: #f5c518;
        color: #000;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 4px;
        opacity: 0;
        transition: 0.2s;
        font-weight: 600;
    }
    .cms-editable:hover::before { opacity: 1; }


    /* ==================================================================
       IKON PENA — dibikin pake SVG supaya mirip banget kayak di gambar
       ================================================================== */
    .cms-editable::after {
    content: "";
    position: absolute;
    top: -14px;
    right: -12px;
    width: 22px;
    height: 22px;
    background: #ffd739; /* kuning lingkaran */
    border-radius: 50%;
    display: none;

    /* <-- gunakan data:image/svg+xml;base64,... (tanpa newline) -->
       Ini versi base64 dari SVG pena hitam */
    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAyNCAyNCc+PHBhdGggZmlsbD0nYmxhY2snIGQ9J00zIDE3LjI1VjIxaDMuNzVMMTcuODEgOS45NGwtMy43NS0zLjc1TDQgMTcuMjV6TTIwLjcxIDcuMDRjLjM5LS4zOS4zOS0xLjAyIDAtMS40MWwtMi4zNC0yLjM0YTEgMSAwIDAwLTEuNDEgMGwtMS44MyAxLjgzIDMuNzUgMy43NSAxLjgzLTEuODN6Jy8+PC9zdmc+");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 70%;
    transform: rotate(10deg);
}

.cms-editable:hover::after {
    display: block;
}

</style>

<section id="heroSectionPreview" class="relative py-68 bg-cover bg-center bg-no-repeat group transition-all duration-300"
         style="background-image: url('{{ cms($page->id, 'hero_bg_image', '/storage/images/kominfo.jpg') }}');">
    
    <div class="absolute inset-0 bg-black/40 transition-opacity group-hover:bg-black/60 z-0 pointer-events-none"></div>
    
    <div class="relative max-w-6xl mx-auto px-6 text-left text-white z-10">
        
        <div class="cms-editable mb-12 inline-block" onclick="openEditor('hero_title')" id="wrapper_hero_title">
            <h1 class="text-4xl font-bold">
                {!! cms($page->id, 'hero_title', 'Kementerian Komunikasi dan Informatika') !!}
            </h1>
        </div>

        <div class="cms-editable mb-12 block" onclick="openEditor('hero_desc')" id="wrapper_hero_desc">
            <p class="text-lg text-gray-200 md:text-justify break-all max-w-2xl">
                {!! cms($page->id, 'hero_desc', 'Dinas Komunikasi dan Informatika...') !!}
            </p>
        </div>

        <div class="cms-editable inline-block" onclick="openLinkEditor('hero_btn_text', 'hero_btn_url')" id="wrapper_hero_btn">
            <a href="javascript:void(0)" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium hover:shadow-blue-500/30 pointer-events-none">
                <span id="preview_hero_btn_text">{!! cms($page->id, 'hero_btn_text', 'Lihat Selengkapnya') !!}</span>
            </a>
            <input type="hidden" id="val_hero_btn_url" value="{!! cms($page->id, 'hero_btn_url', '#') !!}">
        </div>
    </div>

    <div class="absolute top-5 right-5 z-50 hidden group-hover:block animate-fade-in">
        <button type="button" 
                onclick="event.stopPropagation(); window.openImageEditor('hero_bg_image')" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95 cursor-pointer">
            <i class="ph ph-image"></i> Ganti Background
        </button>
        <input type="hidden" id="val_hero_bg_image" value="{{ cms($page->id, 'hero_bg_image', '/storage/images/kominfo.jpg') }}">
    </div>

</section>
<!-- 2 -->
<section class="py-16 bg-gray-200">
    <div class="max-w-4xl mx-auto text-center px-4">
    
        <div class="cms-editable inline-block mb-2" onclick="openEditor('search_title')" id="wrapper_search_title">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                {!! cms($page->id, 'search_title', 'Pencarian Informasi') !!}
            </h2>
        </div>

        <br> <div class="cms-editable inline-block mb-6" onclick="openEditor('search_desc')" id="wrapper_search_desc">
            <p class="text-gray-500 mt-2">
                {!! cms($page->id, 'search_desc', 'Temukan Informasi Publik Jawa Timur') !!}
            </p>
        </div>

        <form class="mt-2 pointer-events-none opacity-90"> 
            <div class="flex items-center bg-white rounded-full shadow-md overflow-hidden mx-auto max-w-xl">
                <input 
                    type="text" 
                    placeholder="Masukkan kata kunci..."
                    class="flex-1 px-5 py-3 focus:outline-none text-gray-700"
                    disabled
                >
                <button type="button" class="bg-blue-600 text-white px-6 py-3 flex items-center justify-center">
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
<section class="py-20 relative group">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="text-center mb-12">
            <div class="cms-editable inline-block mb-4" onclick="openEditor('services_title')" id="wrapper_services_title">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{!! cms($page->id, 'services_title', 'Layanan Informasi') !!}</h2>
            </div>
            <br>
            <div class="cms-editable inline-block" onclick="openEditor('services_desc')" id="wrapper_services_desc">
                <p class="text-gray-500">{!! cms($page->id, 'services_desc', 'Layanan informasi dapat dilakukan baik melalui daring atau luring') !!}</p>
            </div>
        </div>

        <div class="absolute top-10 right-10 hidden group-hover:block z-10">
            <button onclick="addServiceCard()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95">
                <i class="ph ph-plus"></i> Tambah Layanan
            </button>
        </div>

        <input type="hidden" id="json_services_cards" value="{{ cms($page->id, 'services_cards', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="servicesGrid"></div>

    </div>
</section>

<!-- 4 -->
<section class="py-20 bg-gray-200 relative">
    <div class="max-w-6xl mx-auto px-6">

        <!-- Heading -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-semibold text-gray-800">
                {!! cms($page->id, 'gallery_title', 'Agenda Kegiatan') !!}
            </h2>
            <p class="text-gray-500 mt-2">
                {!! cms($page->id, 'gallery_desc', 'Dokumentasi kegiatan resmi') !!}
            </p>
        </div>

        <!-- Button tambah -->
        <div class="absolute top-10 right-10 hidden group-hover:block z-10">
            <button onclick="openGalleryModal(-1)"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2">
                <i class="ph ph-image"></i> Tambah Agenda
            </button>
        </div>

        <input type="hidden" id="json_gallery_items"
               value="{{ cms($page->id, 'gallery_items', '[]') }}">

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="galleryGrid"></div>
    </div>
</section>


<!-- 5 -->
<section class="py-20 bg-gray-50 relative group">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="text-center mb-12">
            <div class="cms-editable inline-block mb-2" onclick="openEditor('news_title')" id="wrapper_news_title">
                <h2 class="text-3xl font-semibold">
                    {!! cms($page->id, 'news_title', 'Berita Terkini') !!}
                </h2>
            </div>
            <br> 
            <div class="cms-editable inline-block mb-4" onclick="openEditor('news_desc')" id="wrapper_news_desc">
                <p class="text-gray-500">
                    {!! cms($page->id, 'news_desc', 'Ikuti perkembangan kegiatan dan informasi terbaru.') !!}
                </p>
            </div>
        </div>

        <div class="absolute top-10 right-10 hidden group-hover:block z-10">
            <button onclick="addNewsCard()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95">
                <i class="ph ph-plus"></i> Tambah Berita
            </button>
        </div>

        <input type="hidden" id="json_news_cards" value="{{ cms($page->id, 'news_cards', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="newsGrid"></div>

        <div class="mt-12 text-center">
            
            <div class="cms-editable inline-block" 
                 onclick="openLinkEditor('news_btn_text', 'news_btn_url')" 
                 id="wrapper_news_btn">
                
                <a href="javascript:void(0)" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium pointer-events-none">
                    <span id="preview_news_btn_text">
                        {!! cms($page->id, 'news_btn_text', 'Lihat Semua Berita') !!}
                    </span>
                    <i class="ph ph-arrow-right ml-2"></i>
                </a>

                <input type="hidden" id="val_news_btn_url" value="{!! cms($page->id, 'news_btn_url', '#') !!}">
            </div>

        </div>

    </div>
</section>

<!-- 5 -->
<div id="newsEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 id="newsModalTitle"
    class="text-lg font-bold tracking-wide flex items-center gap-2">
    <i class="ph ph-newspaper"></i> Edit Berita
</h3>

            <button onclick="closeNewsModal()" class="text-white/80 hover:text-white">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="newsIndex">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita</label>
                <input type="text" id="newsInputTitle"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                <input type="date" id="newsInputDate"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Thumbnail</label>
                <input type="file" id="newsInputImage" accept="image/*"
                    class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100
                           border rounded-lg cursor-pointer">
                <img id="newsPreviewImg" src="" class="h-32 w-full mt-2 rounded border hidden object-cover bg-gray-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Cuplikan Isi</label>
                <textarea id="newsInputDesc" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Link Selengkapnya (URL)</label>
                <input type="text" id="newsInputUrl"
                    placeholder="/berita/judul-berita"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-50">
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
            <button id="deleteNewsBtn"
    onclick="deleteNews()"
    class="text-red-500 hover:text-red-700 font-bold text-sm">
    Hapus Berita
</button>

            <div class="flex gap-2">
                <button onclick="closeNewsModal()"
                    class="px-4 py-2 text-gray-600 bg-white border rounded-lg">
                    Batal
                </button>
                <button onclick="applyNewsChange()"
                    class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>


<!-- 4 -->
<div id="cardEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 id="modalTitle" class="text-lg font-bold tracking-wide flex items-center gap-2">
                <i class="ph ph-cards"></i> Edit Layanan
            </h3>
            <button onclick="closeCardModal()" class="text-white/80 hover:text-white transition">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
        
        <!-- Body Modal -->
        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="cardIndex"> 
            
            <!-- Judul Layanan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Judul Layanan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="cardInputTitle" 
                       placeholder="Contoh: Permohonan Informasi Publik"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Singkat <span class="text-red-500">*</span>
                </label>
                <textarea id="cardInputDesc" 
                          rows="3" 
                          placeholder="Jelaskan layanan ini secara singkat..."
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                          required></textarea>
            </div>

            <!-- Upload File -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload Dokumen (PDF) <span class="text-red-500" id="fileRequired">*</span>
                </label>
                
                <input type="file" 
                       id="cardInputFile" 
                       accept="application/pdf" 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer transition">
                
                <div class="mt-2 text-xs text-gray-500 bg-gray-50 p-2 rounded flex justify-between items-center border border-gray-200">
                    <span>File saat ini:</span>
                    <a id="currentFileLink" 
                       href="#" 
                       target="_blank" 
                       class="text-gray-400 hover:underline font-bold truncate max-w-[200px]">
                        Belum ada file
                    </a>
                </div>
                
                <p class="mt-1 text-xs text-gray-500">
                    <i class="ph ph-info"></i> Format: PDF, Maksimal 10MB
                </p>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
            <button id="deleteCardBtn"
                    onclick="deleteCard()" 
                    class="text-red-500 hover:text-red-700 font-bold text-sm transition flex items-center gap-1">
                <i class="ph ph-trash"></i> Hapus
            </button>
            
            <div class="flex gap-2">
                <button onclick="closeCardModal()" 
                        class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition shadow-sm font-medium">
                    Batal
                </button>
                <button onclick="applyCardChange()" 
                        class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md transition transform active:scale-95">
                    <i class="ph ph-check-circle"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

    <div id="editorModal" 
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 class="text-lg font-bold tracking-wide flex items-center gap-2">
                <i class="ph ph-pencil-simple"></i> Edit Konten Text
            </h3>
            <button onclick="closeModal()" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-1 transition">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="inputKey">
            <input type="hidden" id="editType" value="text"> 

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Konten</label>
                <textarea id="inputContent" rows="6" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none placeholder-gray-400 bg-gray-50 focus:bg-white"
                          placeholder="Tulis perubahan konten di sini..."></textarea>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
            <button onclick="closeModal()" 
                    class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                Batal
            </button>
            <button onclick="applyChangeLocal()" 
                    class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transform active:scale-95 transition flex items-center gap-2">
                <i class="ph ph-floppy-disk"></i> Simpan Konten
            </button>
        </div>

    </div>
</div>

    <div id="linkEditorModal" 
        class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[40] transition-opacity duration-300">
    
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
                <h3 class="text-lg font-bold tracking-wide flex items-center gap-2">
                    <i class="ph ph-link"></i> Edit Button
                </h3>
                <button onclick="closeLinkModal()" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-1 transition">
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>

            <div class="px-6 py-6 space-y-5">
                <input type="hidden" id="linkKeyText">
                <input type="hidden" id="linkKeyUrl">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Label Tombol</label>
                    <input type="text" id="linkInputText" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Input URL</label>
                    <div class="relative">
                        <input type="text" id="linkInputUrl" placeholder="https://..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-gray-800 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                            <i class="ph ph-globe text-lg"></i>
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5 ml-1">Contoh: <code>https://google.com</code> atau <code>/profil</code></p>
                </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
                <button onclick="closeLinkModal()" 
                        class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                    Batal
                </button>
                <button onclick="applyLinkChangeLocal()" 
                        class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transform active:scale-95 transition flex items-center gap-2">
                    <i class="ph ph-floppy-disk"></i> Simpan Tombol
                </button>
            </div>
</div>
    </div>
</div>

<!-- Gallery Editor Modal -->
<div id="galleryEditorModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[1000]">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">

        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold text-lg">Editor Agenda</h3>
            <button onclick="closeGalleryModal()">✕</button>
        </div>

        <!-- Body -->
        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="galleryIndex">

            <div>
                <label class="text-sm font-semibold">Judul Agenda</label>
                <input id="galleryTitle" type="text"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm font-semibold">Tanggal Agenda</label>
                <input id="galleryDate" type="date"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm font-semibold">Deskripsi</label>
                <textarea id="galleryDesc" rows="3"
                          class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div>
                <label class="text-sm font-semibold">Foto Agenda</label>
                <input id="galleryImage" type="file" accept="image/*"
                       class="w-full border rounded">
                <img id="galleryPreview"
                     class="hidden mt-3 w-full h-40 object-cover rounded">
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between">
            <button id="deleteGalleryBtn"
                    onclick="deleteGalleryItem()"
                    class="text-red-600 font-bold hidden">
                Hapus
            </button>

            <div class="flex gap-2">
                <button onclick="closeGalleryModal()"
                        class="border px-4 py-2 rounded">
                    Batal
                </button>
                <button onclick="saveGalleryItem()"
                        class="bg-blue-600 text-white px-4 py-2 rounded font-bold">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>



@endsection


@push('scripts')
<script>
    // =========================================================
    // 1. GLOBAL VARIABLES (WAJIB DI PALING ATAS)
    // =========================================================
    let pendingChanges = {};        // Text & JSON Structures
    let pendingCardFiles = {};      // File PDF Layanan
    let pendingNewsImages = {};     // File Thumbnail Berita
    let pendingGalleryFiles = {};   // File Foto Galeri

    // Global Elements
    const btnSaveGlobal = document.getElementById('btnSaveGlobal'); 
    const unsavedIndicator = document.getElementById('unsavedIndicator');

    // Helper: Update Tombol Save
    function updateSaveButtonState() {
        if(btnSaveGlobal) {
            btnSaveGlobal.disabled = false;
            btnSaveGlobal.classList.remove('opacity-50', 'cursor-not-allowed');
            btnSaveGlobal.classList.add('hover:bg-blue-700');
            
            let total = Object.keys(pendingChanges).length + 
                        Object.keys(pendingCardFiles).length + 
                        Object.keys(pendingNewsImages).length + 
                        Object.keys(pendingGalleryFiles).length;

            btnSaveGlobal.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan (' + total + ')';
        }
        if(unsavedIndicator) unsavedIndicator.classList.remove('hidden');
    }


    // =========================================================
    // 2. TEXT EDITOR LOGIC (JUDUL & DESKRIPSI BIASA)
    // =========================================================
    function openEditor(key) {
        let content = pendingChanges[key] !== undefined ? pendingChanges[key] : document.getElementById('wrapper_' + key).innerText.trim();
        document.getElementById('inputKey').value = key;
        document.getElementById('inputContent').value = content;
        document.getElementById('editorModal').classList.remove('hidden');
        document.getElementById('editorModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('editorModal').classList.add('hidden');
        document.getElementById('editorModal').classList.remove('flex');
    }
    function applyChangeLocal() {
        let key = document.getElementById('inputKey').value;
        let content = document.getElementById('inputContent').value;
        pendingChanges[key] = content;
        
        // Update UI
        let wrapper = document.getElementById('wrapper_' + key);
        if(wrapper.querySelector('h1')) wrapper.querySelector('h1').innerText = content;
        else if(wrapper.querySelector('p')) wrapper.querySelector('p').innerText = content;
        else wrapper.innerText = content;

        updateSaveButtonState();
        closeModal();
    }


    // =========================================================
    // 3. LINK EDITOR LOGIC (TOMBOL HERO)
    // =========================================================
    function openLinkEditor(textKey, urlKey) {
        let currentText = pendingChanges[textKey] !== undefined ? pendingChanges[textKey] : document.getElementById('preview_' + textKey).innerText.trim();
        let currentUrl = pendingChanges[urlKey] !== undefined ? pendingChanges[urlKey] : document.getElementById('val_' + urlKey).value;
        document.getElementById('linkKeyText').value = textKey;
        document.getElementById('linkKeyUrl').value = urlKey;
        document.getElementById('linkInputText').value = currentText;
        document.getElementById('linkInputUrl').value = currentUrl;
        document.getElementById('linkEditorModal').classList.remove('hidden');
        document.getElementById('linkEditorModal').classList.add('flex');
    }
    function closeLinkModal() {
        document.getElementById('linkEditorModal').classList.add('hidden');
        document.getElementById('linkEditorModal').classList.remove('flex');
    }
    function applyLinkChangeLocal() {
        let textKey = document.getElementById('linkKeyText').value;
        let urlKey = document.getElementById('linkKeyUrl').value;
        let newText = document.getElementById('linkInputText').value;
        let newUrl = document.getElementById('linkInputUrl').value;
        
        pendingChanges[textKey] = newText;
        pendingChanges[urlKey] = newUrl;
        
        document.getElementById('preview_' + textKey).innerText = newText;
        document.getElementById('val_' + urlKey).value = newUrl;
        
        updateSaveButtonState();
        closeLinkModal();
    }


    // Make sure these are defined globally at the top of your script
    // let pendingChanges = {};
    // function updateSaveButtonState() { ... }

    window.openImageEditor = function(key) {
        console.log("Opening image editor for key:", key); // Debug log

        const modal = document.getElementById('imageEditorModal');
        if(!modal) {
            console.error("Modal #imageEditorModal not found!");
            return;
        }

        document.getElementById('imageKey').value = key;
        
        const input = document.getElementById('imageInputFile');
        if(input) input.value = ''; 
        
        let currentUrl = '';
        let hiddenInput = document.getElementById('val_' + key);
        if(hiddenInput) {
            currentUrl = hiddenInput.value;
        } else {
            console.warn("Hidden input val_" + key + " not found.");
        }

        let previewBox = document.getElementById('imagePreviewBox');
        if(previewBox) {
            previewBox.style.backgroundImage = `url('${currentUrl}')`;
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    window.closeImageModal = function() {
        const modal = document.getElementById('imageEditorModal');
        if(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Initialize listener safely
    const imgInput = document.getElementById('imageInputFile');
    if(imgInput) {
        // Remove existing listeners to prevent duplicates if re-run (optional but good practice)
        let newElement = imgInput.cloneNode(true);
        imgInput.parentNode.replaceChild(newElement, imgInput);
        
        newElement.addEventListener('change', function(e) {
            let file = e.target.files[0];
            if(file) {
                let reader = new FileReader();
                reader.onload = function(e) { 
                    const box = document.getElementById('imagePreviewBox');
                    if(box) box.style.backgroundImage = `url('${e.target.result}')`; 
                }
                reader.readAsDataURL(file);
            }
        });
    }

    window.applyImageChangeLocal = function() {
        let key = document.getElementById('imageKey').value;
        // Re-select input because we might have cloned it above
        let file = document.getElementById('imageInputFile').files[0];
        
        if(file) {
            if(typeof pendingChanges !== 'undefined') {
                pendingChanges[key] = file; 
            } else {
                console.error("pendingChanges variable is missing!");
                return;
            }
            
            let reader = new FileReader();
            reader.onload = function(e) { 
                let heroSection = document.getElementById('heroSectionPreview');
                // Also check for profile elements just in case this is used there
                let kadisImg = document.getElementById('img_kadis_image');
                let strukturImg = document.getElementById('img_struktur_image');

                if(key === 'hero_bg_image' && heroSection) {
                    heroSection.style.backgroundImage = `url('${e.target.result}')`; 
                } else if(key === 'kadis_image' && kadisImg) {
                    kadisImg.src = e.target.result;
                } else if(key === 'struktur_image' && strukturImg) {
                    strukturImg.src = e.target.result;
                }
            }
            reader.readAsDataURL(file);
            
            if(typeof updateSaveButtonState === 'function') {
                updateSaveButtonState();
            }
        }
        closeImageModal();
    }


    // =========================================================
    // 5. SERVICES / LAYANAN (PDF)
    // =========================================================
    let servicesData = [];
try {
    let rawData = document.getElementById('json_services_cards').value;
    if(rawData && rawData !== '[]') servicesData = JSON.parse(rawData); 
    else servicesData = [];
} catch(e) { console.error("Error parsing JSON cards", e); }

renderServicesGrid();

function renderServicesGrid() {
    const container = document.getElementById('servicesGrid');
    if(!container) return;
    container.innerHTML = ''; 
    
    servicesData.forEach((item, index) => {
        let fileStatus = pendingCardFiles[index] ? 
            '<span class="text-blue-600 text-xs font-bold mt-2 block">📄 File Baru Dipilih</span>' : '';

        let html = `
            <div class="relative group/card p-8 border border-blue-200 rounded-2xl shadow-sm hover:shadow-md transition bg-white text-center cursor-pointer flex flex-col justify-start h-[350px] overflow-hidden" onclick="editCard(${index})">
                
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-xl bg-blue-50 shrink-0">
                    <i class="ph ph-file-pdf text-3xl text-blue-500"></i>
                </div>
                
                <h3 class="text-xl font-semibold mb-3 h-[60px] overflow-hidden flex items-center justify-center px-2 leading-tight">
                    ${item.title}
                </h3>
                
                <div class="text-gray-500 leading-relaxed text-sm h-[100px] overflow-hidden px-2">
                    ${item.desc}
                </div>
                
                ${fileStatus}
                
                <div class="absolute inset-0 bg-blue-500/10 border-2 border-blue-500 rounded-2xl hidden group-hover/card:flex items-center justify-center">
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow">Edit Kartu</span>
                </div>

            </div>`;
        container.innerHTML += html;
    });
}

// Fungsi tambah layanan - langsung buka modal
function addServiceCard() {
    // Set mode tambah baru (index = -1)
    document.getElementById('cardIndex').value = -1;
    document.getElementById('cardInputTitle').value = '';
    document.getElementById('cardInputDesc').value = '';
    document.getElementById('cardInputFile').value = '';
    
    // Reset file link
    let linkLabel = document.getElementById('currentFileLink');
    linkLabel.href = '#';
    linkLabel.innerText = "Belum ada file";
    linkLabel.classList.remove('text-blue-600');
    linkLabel.classList.add('text-gray-400');
    
    // Tampilkan/sembunyikan tombol hapus
    document.getElementById('deleteCardBtn').classList.add('hidden');
    
    // Ubah judul modal
    document.getElementById('modalTitle').innerHTML = '<i class="ph ph-plus-circle"></i> Tambah Layanan Baru';
    
    // Buka modal
    document.getElementById('cardEditorModal').classList.remove('hidden');
    document.getElementById('cardEditorModal').classList.add('flex');
}

function editCard(index) {
    let item = servicesData[index];
    
    // Set mode edit (index >= 0)
    document.getElementById('cardIndex').value = index;
    document.getElementById('cardInputTitle').value = item.title;
    document.getElementById('cardInputDesc').value = item.desc;
    document.getElementById('cardInputFile').value = '';
    
    // Update file link
    let linkLabel = document.getElementById('currentFileLink');
    if(item.url && item.url !== '#') {
        linkLabel.href = item.url;
        linkLabel.innerText = "Buka File PDF";
        linkLabel.classList.remove('text-gray-400');
        linkLabel.classList.add('text-blue-600');
    } else {
        linkLabel.href = '#';
        linkLabel.innerText = "Belum ada file";
        linkLabel.classList.remove('text-blue-600');
        linkLabel.classList.add('text-gray-400');
    }
    
    // Tampilkan tombol hapus saat edit
    document.getElementById('deleteCardBtn').classList.remove('hidden');
    
    // Ubah judul modal
    document.getElementById('modalTitle').innerHTML = '<i class="ph ph-cards"></i> Edit Layanan';
    
    // Buka modal
    document.getElementById('cardEditorModal').classList.remove('hidden');
    document.getElementById('cardEditorModal').classList.add('flex');
}

function closeCardModal() {
    document.getElementById('cardEditorModal').classList.add('hidden');
    document.getElementById('cardEditorModal').classList.remove('flex');
}

function applyCardChange() {
    let index = parseInt(document.getElementById('cardIndex').value);
    let title = document.getElementById('cardInputTitle').value.trim();
    let desc = document.getElementById('cardInputDesc').value.trim();
    let fileInput = document.getElementById('cardInputFile');
    
    // VALIDASI: Cek semua field wajib diisi
    if (!title) {
        alert('⚠️ Judul Layanan harus diisi!');
        document.getElementById('cardInputTitle').focus();
        return;
    }
    
    if (!desc) {
        alert('⚠️ Deskripsi harus diisi!');
        document.getElementById('cardInputDesc').focus();
        return;
    }
    
    // Mode tambah baru (index = -1)
    if (index === -1) {
        // Wajib upload file untuk layanan baru
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('⚠️ Dokumen PDF harus diupload untuk layanan baru!');
            document.getElementById('cardInputFile').focus();
            return;
        }
        
        // Tambah data baru
        let newIndex = servicesData.push({
            title: title,
            desc: desc,
            url: '#' // URL akan diupdate saat save ke server
        }) - 1;
        
        // Simpan file pending
        pendingCardFiles[newIndex] = fileInput.files[0];
    }
    // Mode edit (index >= 0)
    else {
        // Update data
        servicesData[index].title = title;
        servicesData[index].desc = desc;
        
        // Update file jika ada file baru
        if (fileInput.files && fileInput.files.length > 0) {
            pendingCardFiles[index] = fileInput.files[0];
        }
    }
    
    // Render ulang dan simpan
    renderServicesGrid();
    saveCardsToPending();
    closeCardModal();
}

function deleteCard() {
    let index = document.getElementById('cardIndex').value;
    
    if (confirm('⚠️ Yakin ingin menghapus layanan ini?')) {
        servicesData.splice(index, 1);
        delete pendingCardFiles[index];
        
        // Reindex pendingCardFiles
        const newPendingFiles = {};
        Object.keys(pendingCardFiles).forEach(key => {
            const oldIndex = parseInt(key);
            if (oldIndex > index) {
                newPendingFiles[oldIndex - 1] = pendingCardFiles[oldIndex];
            } else if (oldIndex < index) {
                newPendingFiles[oldIndex] = pendingCardFiles[oldIndex];
            }
        });
        pendingCardFiles = newPendingFiles;
        
        renderServicesGrid();
        saveCardsToPending();
        closeCardModal();
    }
}

function saveCardsToPending() {
    pendingChanges['services_cards'] = JSON.stringify(servicesData);
    updateSaveButtonState();
}


    let galleryData = [];


try {
    galleryData = JSON.parse(
        document.getElementById('json_gallery_items').value || '[]'
    );
} catch (e) {
    galleryData = [];
}

renderGalleryGrid();

/* ===============================
   RENDER GRID
================================ */
function renderGalleryGrid() {
    const grid = document.getElementById('galleryGrid');
    grid.innerHTML = '';

    galleryData.forEach((item, i) => {
        const img = pendingGalleryFiles[i]
            ? URL.createObjectURL(pendingGalleryFiles[i])
            : item.image;

        grid.innerHTML += `
        <div class="group relative rounded-xl overflow-hidden shadow bg-white">

            <div class="aspect-[4/3] bg-gray-200">
                ${img ? `
                <img src="${img}"
                     class="w-full h-full object-cover transition-transform duration-300
                            group-hover:scale-105">
                ` : ''}
            </div>

            <div class="absolute inset-0 bg-black/50 opacity-0
                        group-hover:opacity-100 transition
                        flex items-center justify-center gap-3
                        pointer-events-none group-hover:pointer-events-auto">

                <button onclick="openGalleryModal(${i})"
                        class="bg-white px-4 py-2 rounded-lg font-semibold">
                    Edit
                </button>

                <button onclick="confirmDeleteGalleryItem(${i})"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">
                    Hapus
                </button>
            </div>

            <div class="p-4">
                <h4 class="font-semibold truncate">
                    ${item.title || 'Agenda'}
                </h4>
                <p class="text-sm text-gray-500">
                    ${item.date || ''}
                </p>
            </div>
        </div>`;
    });
}


/* ===============================
   MODAL
================================ */
function openGalleryModal(index) {
    document.getElementById('galleryEditorModal').classList.remove('hidden');
    document.getElementById('galleryEditorModal').classList.add('flex');

    document.getElementById('galleryIndex').value = index;

    document.getElementById('galleryTitle').value = '';
    document.getElementById('galleryDate').value = '';
    document.getElementById('galleryDesc').value = '';
    document.getElementById('galleryPreview').classList.add('hidden');

    document.getElementById('deleteGalleryBtn').classList.add('hidden');

    if (index >= 0) {
        const item = galleryData[index];
        document.getElementById('galleryTitle').value = item.title || '';
        document.getElementById('galleryDate').value = item.date || '';
        document.getElementById('galleryDesc').value = item.desc || '';

        if (item.image) {
            document.getElementById('galleryPreview').src = item.image;
            document.getElementById('galleryPreview').classList.remove('hidden');
        }

        document.getElementById('deleteGalleryBtn').classList.remove('hidden');
    }
}

function closeGalleryModal() {
    document.getElementById('galleryEditorModal').classList.add('hidden');
}

/* ===============================
   SAVE
================================ */
function saveGalleryItem() {
    const index = parseInt(document.getElementById('galleryIndex').value);
    const title = galleryTitle.value.trim();
    const date = galleryDate.value;
    const desc = galleryDesc.value.trim();
    const file = galleryImage.files[0];

    if (!title) {
        alert('Judul wajib diisi');
        return;
    }

    if (index === -1) {
        const newIndex = galleryData.push({
            title, date, desc, image: ''
        }) - 1;

        if (file) pendingGalleryFiles[newIndex] = file;
    } else {
        galleryData[index].title = title;
        galleryData[index].date = date;
        galleryData[index].desc = desc;

        if (file) pendingGalleryFiles[index] = file;
    }

    saveGalleryToPending();
    renderGalleryGrid();
    closeGalleryModal();
}

/* ===============================
   DELETE
================================ */
function confirmDeleteGalleryItem(i) {
    if (confirm('Hapus agenda ini?')) deleteGalleryItem(i);
}

function deleteGalleryItem(i) {
    galleryData.splice(i, 1);
    delete pendingGalleryFiles[i];
    saveGalleryToPending();
    renderGalleryGrid();
    closeGalleryModal();
}

function saveGalleryToPending() {
    pendingChanges['gallery_items'] = JSON.stringify(galleryData);
    updateSaveButtonState();
}
    // =========================================================
    // 7. NEWS / BERITA (THUMBNAIL)
    // =========================================================
    let newsData = [];
    try {
        let rawNews = document.getElementById('json_news_cards').value;
        if(rawNews && rawNews !== '[]') newsData = JSON.parse(rawNews); 
        else newsData = [{ title: 'Berita Baru', date: '2025-01-01', image: '', desc: '...', url: '#' }];
    } catch(e) { console.error("Error parsing News", e); }

    renderNewsGrid();

    function renderNewsGrid() {
        const container = document.getElementById('newsGrid');
        if(!container) return;
        container.innerHTML = '';
        
        newsData.forEach((item, index) => {
            // Logic Gambar
            let displayImage = item.image;
            if(pendingNewsImages[index]) {
                displayImage = URL.createObjectURL(pendingNewsImages[index]);
            }
            if(!displayImage || displayImage === '') {
                displayImage = 'https://placehold.co/600x400?text=Upload+Image';
            }

            let html = `
                <div class="group/card bg-white rounded-xl shadow-sm hover:shadow-xl transition overflow-hidden cursor-pointer h-[380px] flex flex-col border border-gray-100" onclick="editNews(${index})">
                    
                    <div class="h-[200px] w-full bg-gray-200 overflow-hidden relative shrink-0">
                        <img src="${displayImage}" class="w-full h-full object-cover transition duration-500 group-hover/card:scale-110">
                        
                        <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            ${item.date || '-'}
                        </div>

                        <div class="absolute inset-0 bg-black/50 hidden group-hover/card:flex items-center justify-center">
                            <span class="text-white font-bold border border-white px-4 py-1 rounded-full"><i class="ph ph-pencil"></i> Edit</span>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-1 justify-between">
                        
                        <h3 class="text-lg font-bold text-gray-800 h-[4.5rem] overflow-hidden leading-tight line-clamp-3">
                            ${item.title}
                        </h3>
                        
                        <div class="pt-4 border-t border-gray-100 mt-auto text-blue-600 font-semibold text-sm flex items-center gap-2">
                            Baca Selengkapnya <i class="ph ph-arrow-right"></i>
                        </div>
                    </div>
                </div>`;
            container.innerHTML += html;
        });
    }
    function addNewsCard() {
    document.getElementById('newsIndex').value = -1;

    // UI mode: TAMBAH
    document.getElementById('newsModalTitle').innerText = 'Tambah Berita';
    document.getElementById('deleteNewsBtn').classList.add('hidden');

    // reset form
    document.getElementById('newsInputTitle').value = '';
    document.getElementById('newsInputDate').value = '';
    document.getElementById('newsInputDesc').value = '';
    document.getElementById('newsInputUrl').value = '';
    document.getElementById('newsInputImage').value = '';

    const preview = document.getElementById('newsPreviewImg');
    preview.src = '';
    preview.classList.add('hidden');

    document.getElementById('newsEditorModal').classList.remove('hidden');
    document.getElementById('newsEditorModal').classList.add('flex');
}


    function editNews(index) {
    let item = newsData[index];

    document.getElementById('newsIndex').value = index;

    // UI mode: EDIT
    document.getElementById('newsModalTitle').innerText = 'Edit Berita';
    document.getElementById('deleteNewsBtn').classList.remove('hidden');

    document.getElementById('newsInputTitle').value = item.title;
    document.getElementById('newsInputDate').value = item.date;
    document.getElementById('newsInputDesc').value = item.desc;
    document.getElementById('newsInputUrl').value = item.url;
    document.getElementById('newsInputImage').value = '';

    let preview = document.getElementById('newsPreviewImg');
    if (item.image) {
        preview.src = item.image;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }

    document.getElementById('newsEditorModal').classList.remove('hidden');
    document.getElementById('newsEditorModal').classList.add('flex');
}

    function closeNewsModal() {
        document.getElementById('newsEditorModal').classList.add('hidden');
        document.getElementById('newsEditorModal').classList.remove('flex');
    }
    function applyNewsChange() {
    const title = document.getElementById('newsInputTitle').value.trim();
    const date  = document.getElementById('newsInputDate').value;
    const desc  = document.getElementById('newsInputDesc').value.trim();
    const url   = document.getElementById('newsInputUrl').value.trim();

    // VALIDASI WAJIB
    if (!title || !date || !desc || !url) {
        alert('Semua field wajib diisi!');
        return;
    }

    const index = parseInt(document.getElementById('newsIndex').value);
    const fileInput = document.getElementById('newsInputImage');

    // ========================
    // MODE TAMBAH
    // ========================
    if (index === -1) {
        const newIndex = newsData.length;

        newsData.push({
            title,
            date,
            desc,
            url,
            image: ''
        });

        if (fileInput.files.length > 0) {
            pendingNewsImages[newIndex] = fileInput.files[0];
        }

    // ========================
    // MODE EDIT
    // ========================
    } else {
        newsData[index].title = title;
        newsData[index].date  = date;
        newsData[index].desc  = desc;
        newsData[index].url   = url;

        if (fileInput.files.length > 0) {
            pendingNewsImages[index] = fileInput.files[0];
        }
    }

    renderNewsGrid();
    saveNewsToPending();
    closeNewsModal();
}

    function deleteNews() {
        let index = document.getElementById('newsIndex').value;
        if(confirm('Hapus berita ini?')) {
            newsData.splice(index, 1);
            delete pendingNewsImages[index];
            renderNewsGrid();
            saveNewsToPending();
            closeNewsModal();
        }
    }
    function saveNewsToPending() {
        pendingChanges['news_cards'] = JSON.stringify(newsData);
        updateSaveButtonState();
    }


    // =========================================================
    // 8. FINAL SAVE GLOBAL (SEMUA JADI SATU)
    // =========================================================
    if(btnSaveGlobal) {
        btnSaveGlobal.addEventListener('click', function() {
            let slug = document.getElementById('pageSlug').value;
            let originalText = btnSaveGlobal.innerHTML;
            btnSaveGlobal.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
            btnSaveGlobal.disabled = true;

            let formData = new FormData();
            formData.append('page_slug', slug);
            
            // A. APPEND SEMUA TEXT & JSON
            for (let key in pendingChanges) {
                formData.append(`changes[${key}]`, pendingChanges[key]);
            }
            // B. APPEND FILE LAYANAN (PDF)
            for (let index in pendingCardFiles) {
                formData.append(`service_file_${index}`, pendingCardFiles[index]);
            }
            // C. APPEND FILE BERITA (THUMBNAIL)
            for (let index in pendingNewsImages) {
                formData.append(`news_image_${index}`, pendingNewsImages[index]);
            }
            // D. APPEND FILE GALERI (FOTO)
            for (let index in pendingGalleryFiles) {
                formData.append(`gallery_image_${index}`, pendingGalleryFiles[index]);
            }

            // KIRIM AJAX
            fetch("{{ route('redaktur.page.update_batch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil! Data & File tersimpan.');
                    window.location.reload(); 
                } else {
                    alert('Gagal: ' + data.message);
                    btnSaveGlobal.disabled = false;
                    btnSaveGlobal.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Server Error. Cek console.');
                btnSaveGlobal.disabled = false;
                btnSaveGlobal.innerHTML = originalText;
            });
        });
    }
</script>
@endpush