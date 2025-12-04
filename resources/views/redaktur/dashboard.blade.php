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
    
    <div class="absolute top-5 right-5 z-30 hidden group-hover:block animate-fade-in">
        <button onclick="openImageEditor('hero_bg_image')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95">
            <i class="ph ph-image"></i> Ganti Background
        </button>
        <input type="hidden" id="val_hero_bg_image" value="{{ cms($page->id, 'hero_bg_image', '/storage/images/kominfo.jpg') }}">
    </div>

    <div class="absolute inset-0 bg-black/40 transition-opacity group-hover:bg-black/60"></div>
    
    <div class="relative max-w-6xl mx-auto px-6 text-left text-white">
        <div class="cms-editable mb-12 inline-block" onclick="openEditor('hero_title')" id="wrapper_hero_title">
            <h1 class="text-4xl font-bold">
                {!! cms($page->id, 'hero_title', 'Kementerian Komunikasi dan Informatika') !!}
            </h1>
        </div>

        <div class="cms-editable mb-12 block" onclick="openEditor('hero_desc')" id="wrapper_hero_desc">
            <p class="text-lg text-gray-200 md:text-justify break-all max-w-2xl">
                {!! cms($page->id, 'hero_desc', 'Dinas Komunikasi dan Informatika Kota Surabaya yang bertugas mengelola informasi publik...') !!}
            </p>
        </div>

        <div class="cms-editable inline-block" onclick="openLinkEditor('hero_btn_text', 'hero_btn_url')" id="wrapper_hero_btn">
            <a href="javascript:void(0)" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium hover:shadow-blue-500/30">
                <span id="preview_hero_btn_text">{!! cms($page->id, 'hero_btn_text', 'Lihat Selengkapnya') !!}</span>
            </a>
            <input type="hidden" id="val_hero_btn_url" value="{!! cms($page->id, 'hero_btn_url', '#') !!}">
        </div>
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
            <button onclick="addServiceCard()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95">
                <i class="ph ph-plus"></i> Tambah Layanan
            </button>
        </div>

        <input type="hidden" id="json_services_cards" value="{{ cms($page->id, 'services_cards', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="servicesGrid"></div>

    </div>
</section>

<!-- 4 -->
<section class="py-20 bg-gray-200 relative group">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="text-center mb-12">
            <div class="cms-editable inline-block mb-2" onclick="openEditor('gallery_title')" id="wrapper_gallery_title">
                <h2 class="text-3xl font-semibold text-gray-800">{!! cms($page->id, 'gallery_title', 'Galeri Berita') !!}</h2>
            </div>
            <br>
            <div class="cms-editable inline-block" onclick="openEditor('gallery_desc')" id="wrapper_gallery_desc">
                <p class="text-gray-500 mt-2">{!! cms($page->id, 'gallery_desc', 'Galeri Foto kegiatan PPID Pemerintah Provinsi Jawa Timur') !!}</p>
            </div>
        </div>

        <div class="absolute top-10 right-10 hidden group-hover:block z-10">
            <input type="file" id="galleryUploadInput" accept="image/*" class="hidden" onchange="handleGalleryUpload(this)">
            
            <button onclick="document.getElementById('galleryUploadInput').click()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow-lg font-bold flex items-center gap-2 transition transform active:scale-95">
                <i class="ph ph-image-square"></i> Tambah Foto
            </button>
        </div>

        <input type="hidden" id="json_gallery_items" value="{{ cms($page->id, 'gallery_items', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="galleryGrid"></div>

    <div class="mt-12 text-center">
        
        <div class="cms-editable inline-block" 
             onclick="openLinkEditor('gallery_btn_text', 'gallery_btn_url')" 
             id="wrapper_gallery_btn">
            
            <a href="javascript:void(0)" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg font-medium pointer-events-none">
                <span id="preview_gallery_btn_text">
                    {!! cms($page->id, 'gallery_btn_text', 'Lihat Semua Foto') !!}
                </span>
                <i class="ph ph-arrow-right ml-2"></i>
            </a>

            <input type="hidden" id="val_gallery_btn_url" value="{!! cms($page->id, 'gallery_btn_url', '#') !!}">
        </div>

    </div>

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

            <br> <div class="cms-editable inline-block mb-4" onclick="openEditor('news_desc')" id="wrapper_news_desc">
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

    </div>
</section>

<!-- 5 -->
<div id="newsEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <div class="bg-gradient-to-r from-orange-600 to-orange-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 class="text-lg font-bold tracking-wide flex items-center gap-2"><i class="ph ph-newspaper"></i> Edit Berita</h3>
            <button onclick="closeNewsModal()" class="text-white/80 hover:text-white"><i class="ph ph-x text-lg"></i></button>
        </div>

        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="newsIndex">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita</label>
                <input type="text" id="newsInputTitle" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                <input type="date" id="newsInputDate" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Thumbnail</label>
                <input type="file" id="newsInputImage" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 border rounded-lg cursor-pointer">
                <img id="newsPreviewImg" src="" class="h-32 w-full mt-2 rounded border hidden object-cover bg-gray-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Cuplikan Isi</label>
                <textarea id="newsInputDesc" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Link Selengkapnya (URL)</label>
                <input type="text" id="newsInputUrl" placeholder="/berita/judul-berita" class="w-full px-4 py-2 border rounded-lg bg-gray-50">
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
            <button onclick="deleteNews()" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus Berita</button>
            <div class="flex gap-2">
                <button onclick="closeNewsModal()" class="px-4 py-2 text-gray-600 bg-white border rounded-lg">Batal</button>
                <button onclick="applyNewsChange()" class="px-4 py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- 4 -->
<div id="cardEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 class="text-lg font-bold tracking-wide flex items-center gap-2"><i class="ph ph-cards"></i> Edit Layanan</h3>
            <button onclick="closeCardModal()" class="text-white/80 hover:text-white"><i class="ph ph-x text-lg"></i></button>
        </div>
        
        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="cardIndex"> <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Layanan</label>
                <input type="text" id="cardInputTitle" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                <textarea id="cardInputDesc" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
            </div>
            <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Dokumen (PDF)</label>
    
    <input type="file" id="cardInputFile" accept="application/pdf" 
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 border border-gray-300 rounded-lg cursor-pointer">
    
    <div class="mt-2 text-xs text-gray-500 bg-gray-100 p-2 rounded flex justify-between items-center">
        <span>File saat ini:</span>
        <a id="currentFileLink" href="#" target="_blank" class="text-blue-600 hover:underline font-bold truncate max-w-[200px]">
            Belum ada file
        </a>
    </div>
</div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
            <button onclick="deleteCard()" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus Kartu Ini</button>
            <div class="flex gap-2">
                <button onclick="closeCardModal()" class="px-4 py-2 text-gray-600 bg-white border rounded-lg">Batal</button>
                <button onclick="applyCardChange()" class="px-4 py-2 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700">Simpan</button>
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
        class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
                <h3 class="text-lg font-bold tracking-wide flex items-center gap-2">
                    <i class="ph ph-link"></i> Edit Tombol & Link
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Link Tujuan (URL)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="ph ph-globe"></i>
                        </span>
                        <input type="text" id="linkInputUrl" placeholder="https://..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-gray-800 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5 ml-1">Contoh: <code>https://google.com</code> atau <code>/profil</code></p>
                </div>
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

<!-- 4 -->
<div id="imageEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">
        
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 class="text-lg font-bold tracking-wide flex items-center gap-2">
                <i class="ph ph-image"></i> Ganti Gambar
            </h3>
            <button onclick="closeImageModal()" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-1 transition">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="imageKey">

            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Gambar Baru</label>
            <input type="file" id="imageInputFile" accept="image/*" 
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer border border-gray-300 rounded-lg">
            
            <p class="text-sm font-semibold text-gray-700 mt-4 mb-2">Preview:</p>
            <div class="w-full h-48 bg-gray-100 rounded-lg border border-gray-300 flex items-center justify-center overflow-hidden bg-cover bg-center" 
                 id="imagePreviewBox" 
                 style="background-image: url('/storage/images/placeholder.jpg');">
                 </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
            <button onclick="closeImageModal()" class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">Batal</button>
            <button onclick="applyImageChangeLocal()" class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transform active:scale-95 transition flex items-center gap-2">
                <i class="ph ph-check"></i> Terapkan Gambar
            </button>
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


    // =========================================================
    // 4. IMAGE EDITOR LOGIC (BACKGROUND HERO)
    // =========================================================
    function openImageEditor(key) {
        document.getElementById('imageKey').value = key;
        document.getElementById('imageInputFile').value = ''; 
        let currentUrl = document.getElementById('val_' + key).value;
        document.getElementById('imagePreviewBox').style.backgroundImage = `url('${currentUrl}')`;
        document.getElementById('imageEditorModal').classList.remove('hidden');
        document.getElementById('imageEditorModal').classList.add('flex');
    }
    function closeImageModal() {
        document.getElementById('imageEditorModal').classList.add('hidden');
        document.getElementById('imageEditorModal').classList.remove('flex');
    }
    document.getElementById('imageInputFile').addEventListener('change', function(e) {
        let file = e.target.files[0];
        if(file) {
            let reader = new FileReader();
            reader.onload = function(e) { document.getElementById('imagePreviewBox').style.backgroundImage = `url('${e.target.result}')`; }
            reader.readAsDataURL(file);
        }
    });
    function applyImageChangeLocal() {
        let key = document.getElementById('imageKey').value;
        let file = document.getElementById('imageInputFile').files[0];
        if(file) {
            pendingChanges[key] = file; 
            let reader = new FileReader();
            reader.onload = function(e) { document.getElementById('heroSectionPreview').style.backgroundImage = `url('${e.target.result}')`; }
            reader.readAsDataURL(file);
            updateSaveButtonState();
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
        else servicesData = [{ title: 'Layanan', desc: 'Deskripsi...', url: '#' }];
    } catch(e) { console.error("Error parsing JSON cards", e); }

    renderServicesGrid();

    function renderServicesGrid() {
        const container = document.getElementById('servicesGrid');
        if(!container) return;
        container.innerHTML = ''; 
        servicesData.forEach((item, index) => {
            let fileStatus = pendingCardFiles[index] ? '<span class="text-green-600 text-xs font-bold mt-2 block">📄 File Baru Dipilih</span>' : '';
            let html = `
                <div class="relative group/card p-8 border border-blue-200 rounded-2xl shadow-sm hover:shadow-md transition bg-white text-center cursor-pointer flex flex-col justify-start h-[350px] overflow-hidden" onclick="editCard(${index})">
                    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-xl bg-blue-50 shrink-0"><i class="ph ph-file-pdf text-3xl text-blue-500"></i></div>
                    <h3 class="text-xl font-semibold mb-3 h-[60px] overflow-hidden flex items-center justify-center px-2 leading-tight">${item.title}</h3>
                    <div class="text-gray-500 leading-relaxed text-sm h-[100px] overflow-hidden px-2">${item.desc}</div>
                    ${fileStatus}
                    <div class="absolute inset-0 bg-purple-500/10 border-2 border-purple-500 rounded-2xl hidden group-hover/card:flex items-center justify-center"><span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow">Edit Kartu</span></div>
                </div>`;
            container.innerHTML += html;
        });
    }
    function addServiceCard() {
        servicesData.push({ title: 'Layanan Baru', desc: 'Deskripsi...', url: '#' });
        renderServicesGrid();
        saveCardsToPending();
    }
    function editCard(index) {
        let item = servicesData[index];
        document.getElementById('cardIndex').value = index;
        document.getElementById('cardInputTitle').value = item.title;
        document.getElementById('cardInputDesc').value = item.desc;
        document.getElementById('cardInputFile').value = '';
        let linkLabel = document.getElementById('currentFileLink');
        if(item.url && item.url !== '#') { linkLabel.href = item.url; linkLabel.innerText = "Buka File PDF"; linkLabel.classList.remove('text-gray-400'); linkLabel.classList.add('text-blue-600'); }
        else { linkLabel.href = '#'; linkLabel.innerText = "Belum ada file"; linkLabel.classList.add('text-gray-400'); }
        document.getElementById('cardEditorModal').classList.remove('hidden');
        document.getElementById('cardEditorModal').classList.add('flex');
    }
    function closeCardModal() {
        document.getElementById('cardEditorModal').classList.add('hidden');
        document.getElementById('cardEditorModal').classList.remove('flex');
    }
    function applyCardChange() {
        let index = document.getElementById('cardIndex').value;
        servicesData[index].title = document.getElementById('cardInputTitle').value;
        servicesData[index].desc = document.getElementById('cardInputDesc').value;
        let fileInput = document.getElementById('cardInputFile');
        if(fileInput.files.length > 0) pendingCardFiles[index] = fileInput.files[0];
        renderServicesGrid();
        saveCardsToPending();
        closeCardModal();
    }
    function deleteCard() {
        let index = document.getElementById('cardIndex').value;
        if(confirm('Yakin hapus?')) {
            servicesData.splice(index, 1);
            delete pendingCardFiles[index];
            renderServicesGrid();
            saveCardsToPending();
            closeCardModal();
        }
    }
    function saveCardsToPending() {
        pendingChanges['services_cards'] = JSON.stringify(servicesData);
        updateSaveButtonState();
    }


    // 6
    // =========================================================
    // 7. GALERI FOTO (FOTO)
    // =========================================================
    let galleryData = [];
    try {
        let rawGallery = document.getElementById('json_gallery_items').value;
        if(rawGallery && rawGallery !== '[]') galleryData = JSON.parse(rawGallery); 
        else galleryData = [{ image: '' }, { image: '' }, { image: '' }];
    } catch(e) { console.error("Error parsing Gallery", e); }

    renderGalleryGrid();

    function renderGalleryGrid() {
        const container = document.getElementById('galleryGrid');
        if(!container) return;
        container.innerHTML = '';
        galleryData.forEach((item, index) => {
            let displayImage = item.image;
            let isNewFile = false;
            
            if(pendingGalleryFiles[index]) { 
                displayImage = URL.createObjectURL(pendingGalleryFiles[index]); 
                isNewFile = true; 
            }
            
            let bgStyle = (displayImage && displayImage !== '') ? `background-image: url('${displayImage}');` : '';
            let bgColor = (displayImage && displayImage !== '') ? 'bg-white' : 'bg-gray-300';
            
            let html = `
                <div class="relative group/item h-64 rounded-xl shadow-sm overflow-hidden ${bgColor} bg-cover bg-center border border-gray-200" style="${bgStyle}">
                    ${ (!displayImage || displayImage === '') ? '<div class="flex items-center justify-center h-full text-gray-500 font-medium">No Image</div>' : '' }
                    
                    <div class="absolute inset-0 bg-black/40 hidden group-hover/item:flex items-center justify-center gap-2 transition-opacity">
                        
                        <button onclick="editGalleryItem(${index})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-bold shadow transition transform hover:scale-105">
                            <i class="ph ph-pencil"></i> Ganti
                        </button>

                        <button onclick="deleteGalleryItem(${index})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-bold shadow transition transform hover:scale-105">
                            <i class="ph ph-trash"></i> Hapus
                        </button>
                    </div>
                    
                    ${isNewFile ? '<div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Baru</div>' : ''}
                </div>`;
            container.innerHTML += html;
        });
    }

    function handleGalleryUpload(input) {
        if (input.files && input.files[0]) {
            let file = input.files[0];
            let newIndex = galleryData.push({ image: '' }) - 1;
            pendingGalleryFiles[newIndex] = file;
            renderGalleryGrid();
            saveGalleryToPending();
            input.value = ''; 
        }
    }

    // --- PASTE FUNGSI BARU DI SINI (ANTARA UPLOAD DAN DELETE) ---
    function editGalleryItem(index) {
        // Buat elemen input file on-the-fly atau pakai yang sudah ada
        let input = document.getElementById('galleryEditInput');
        if (!input) {
            // Kalau belum ada di HTML, kita buat lewat JS
            input = document.createElement('input');
            input.type = 'file';
            input.id = 'galleryEditInput';
            input.accept = 'image/*';
            input.className = 'hidden';
            document.body.appendChild(input);
        }

        // Saat file dipilih
        input.onchange = function(e) {
            if (this.files && this.files[0]) {
                let file = this.files[0];
                
                // Update file di pending berdasarkan index kartu yang diklik
                pendingGalleryFiles[index] = file;
                
                // Update tampilan grid
                renderGalleryGrid();
                saveGalleryToPending();
                
                // Reset input
                this.value = '';
            }
        };

        // Buka dialog file browser
        input.click();
    }
    // -----------------------------------------------------------

    function deleteGalleryItem(index) {
        if(confirm('Hapus foto ini?')) {
            galleryData.splice(index, 1);
            delete pendingGalleryFiles[index];
            renderGalleryGrid();
            saveGalleryToPending();
        }
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
        newsData.push({ title: 'Berita Baru', date: '2025-01-01', image: '', desc: '...', url: '#' });
        renderNewsGrid();
        saveNewsToPending();
    }
    function editNews(index) {
        let item = newsData[index];
        document.getElementById('newsIndex').value = index;
        document.getElementById('newsInputTitle').value = item.title;
        document.getElementById('newsInputDate').value = item.date;
        document.getElementById('newsInputDesc').value = item.desc;
        document.getElementById('newsInputUrl').value = item.url;
        document.getElementById('newsInputImage').value = ''; 
        let preview = document.getElementById('newsPreviewImg');
        if(item.image) { preview.src = item.image; preview.classList.remove('hidden'); } 
        else { preview.classList.add('hidden'); }
        document.getElementById('newsEditorModal').classList.remove('hidden');
        document.getElementById('newsEditorModal').classList.add('flex');
    }
    function closeNewsModal() {
        document.getElementById('newsEditorModal').classList.add('hidden');
        document.getElementById('newsEditorModal').classList.remove('flex');
    }
    function applyNewsChange() {
        let index = document.getElementById('newsIndex').value;
        newsData[index].title = document.getElementById('newsInputTitle').value;
        newsData[index].date = document.getElementById('newsInputDate').value;
        newsData[index].desc = document.getElementById('newsInputDesc').value;
        newsData[index].url = document.getElementById('newsInputUrl').value;
        let fileInput = document.getElementById('newsInputImage');
        if(fileInput.files.length > 0) pendingNewsImages[index] = fileInput.files[0];
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