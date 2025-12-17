@extends('redaktur.layout')


@section('content')

    <input type="hidden" id="pageSlug" value="home"> <div class="mb-8 flex justify-between items-center">

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

    <div>
            <h2 class="text-2xl font-bold text-gray-800">Master Data Publikasi</h2>
            <p class="text-gray-500">Kelola semua Berita dan Agenda kegiatan di sini.</p>
        </div>
    </div>

    <div class="flex gap-2 border-b border-gray-200 mb-8 overflow-x-auto pb-1">
        
        <button onclick="switchTab('news')" id="tab-news" 
            class="group flex items-center gap-2 px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-bold transition-all hover:bg-blue-50 rounded-t-lg focus:outline-none">
            <div class="p-1.5 rounded-md bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="ph ph-newspaper text-lg"></i>
            </div>
            <span>Kabar Berita</span>
        </button>
        
        <button onclick="switchTab('agenda')" id="tab-agenda" 
            class="group flex items-center gap-2 px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 transition-all hover:bg-purple-50 rounded-t-lg focus:outline-none">
            <div class="p-1.5 rounded-md bg-gray-100 text-gray-500 group-hover:bg-purple-600 group-hover:text-white transition">
                <i class="ph ph-calendar-check text-lg"></i>
            </div>
            <span>Agenda / Galeri</span>
        </button>
        
    </div>

    <div id="panel-news" class="block">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700">Daftar Berita</h3>
            <button onclick="addNewsCard()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-bold text-sm flex items-center gap-2">
                <i class="ph ph-plus"></i> Tambah Berita Baru
            </button>
        </div>

        <input type="hidden" id="json_news_cards" value="{{ cms($homePage->id, 'news_cards', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="newsGrid"></div>
    </div>

    <div id="panel-agenda" class="hidden">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-700">Daftar Agenda & Dokumentasi</h3>
            
            <div class="flex gap-2">
                <input type="file" id="galleryUploadInput" accept="image/*" class="hidden" onchange="handleGalleryUpload(this)">
                <button onclick="document.getElementById('galleryUploadInput').click()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 font-bold text-sm flex items-center gap-2">
                    <i class="ph ph-image-square"></i> Upload Foto Agenda
                </button>
            </div>
        </div>

        <input type="hidden" id="json_gallery_items" value="{{ cms($homePage->id, 'gallery_items', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="galleryGrid"></div>
    </div>

    @include('redaktur.partials.modals_publication') 

@endsection

@push('scripts')
<script>
    // --- TABS LOGIC ---
    function switchTab(tab) {
        if(tab === 'news') {
            document.getElementById('panel-news').classList.remove('hidden');
            document.getElementById('panel-agenda').classList.add('hidden');
            document.getElementById('tab-news').classList.add('border-blue-600', 'text-blue-600');
            document.getElementById('tab-agenda').classList.remove('border-purple-600', 'text-purple-600');
            document.getElementById('tab-agenda').classList.add('text-gray-500', 'border-transparent');
        } else {
            document.getElementById('panel-news').classList.add('hidden');
            document.getElementById('panel-agenda').classList.remove('hidden');
            document.getElementById('tab-news').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('tab-news').classList.add('text-gray-500', 'border-transparent');
            document.getElementById('tab-agenda').classList.add('border-purple-600', 'text-purple-600');
            document.getElementById('tab-agenda').classList.remove('text-gray-500', 'border-transparent');
        }
    }

    // --- GLOBAL VARIABLES (State Management) ---
    let pendingChanges = {};
    let pendingNewsImages = {};
    let pendingGalleryFiles = {};
    
    // Global Elements
    const btnSaveGlobal = document.getElementById('btnSaveGlobal');
    const unsavedIndicator = document.getElementById('unsavedIndicator');

    function updateSaveButtonState() {
        if(btnSaveGlobal) {
            btnSaveGlobal.disabled = false;
            btnSaveGlobal.classList.remove('opacity-50', 'cursor-not-allowed');
            btnSaveGlobal.classList.add('hover:bg-blue-700');
            
            let total = Object.keys(pendingChanges).length + 
                        Object.keys(pendingNewsImages).length + 
                        Object.keys(pendingGalleryFiles).length;

            btnSaveGlobal.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan (' + total + ')';
        }
        if(unsavedIndicator) unsavedIndicator.classList.remove('hidden');
    }

    // --- LOAD DATA ---
    let newsData = [];
    let galleryData = [];

    // Load News
    try {
        let rawNews = document.getElementById('json_news_cards').value;
        if(rawNews && rawNews !== '[]') newsData = JSON.parse(rawNews);
    } catch(e) { console.error("Error parsing News", e); }

    // Load Gallery
    try {
        let rawGallery = document.getElementById('json_gallery_items').value;
        if(rawGallery && rawGallery !== '[]') galleryData = JSON.parse(rawGallery);
    } catch(e) { console.error("Error parsing Gallery", e); }

    // Initial Render
    renderNewsGrid();
    renderGalleryGrid();


    // =========================================================
    // 1. LOGIC BERITA (NEWS)
    // =========================================================
    function renderNewsGrid() {
        const container = document.getElementById('newsGrid');
        if(!container) return;
        container.innerHTML = '';
        
        newsData.forEach((item, index) => {
            let displayImage = item.image;
            if(pendingNewsImages[index]) {
                displayImage = URL.createObjectURL(pendingNewsImages[index]);
            }
            if(!displayImage) displayImage = 'https://placehold.co/600x400?text=No+Image';

            // --- STYLE BARU (MODERN CARD) ---
            let html = `
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col relative">
                    
                    <div class="h-48 w-full bg-gray-100 overflow-hidden relative shrink-0">
                        <img src="${displayImage}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-gray-100 flex items-center gap-1">
                            <i class="ph ph-calendar text-blue-600"></i> ${item.date || '-'}
                        </div>

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                            <button onclick="editNews(${index})" class="bg-white text-gray-900 px-5 py-2 rounded-full font-bold shadow-lg hover:bg-blue-50 transition transform hover:scale-105 flex items-center gap-2">
                                <i class="ph ph-pencil-simple text-blue-600"></i> Edit Berita
                            </button>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h4 class="font-bold text-gray-800 text-lg leading-snug line-clamp-2 mb-2 group-hover:text-blue-600 transition">
                            ${item.title}
                        </h4>
                        <div class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4 h-[4.5rem] overflow-hidden">
                            ${item.desc}
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-dashed border-gray-200 flex justify-between items-center">
                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Berita</span>
                            
                            <button onclick="deleteNews(${index})" class="text-gray-400 hover:text-red-600 text-sm font-medium flex items-center gap-1 transition">
                                <i class="ph ph-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>`;
            container.innerHTML += html;
        });
    }

    function addNewsCard() {
        newsData.push({ title: 'Berita Baru', date: '', image: '', desc: '...', url: '#' });
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
        if(pendingNewsImages[index]) {
            preview.src = URL.createObjectURL(pendingNewsImages[index]);
            preview.classList.remove('hidden');
        } else if(item.image) { 
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
        let index = document.getElementById('newsIndex').value;
        newsData[index].title = document.getElementById('newsInputTitle').value;
        newsData[index].date = document.getElementById('newsInputDate').value;
        newsData[index].desc = document.getElementById('newsInputDesc').value;
        newsData[index].url = document.getElementById('newsInputUrl').value;
        
        let fileInput = document.getElementById('newsInputImage');
        if(fileInput.files.length > 0) {
            pendingNewsImages[index] = fileInput.files[0];
        }
        
        renderNewsGrid();
        saveNewsToPending();
        closeNewsModal();
    }

    function deleteNews(index) {
        if(confirm('Hapus berita ini?')) {
            newsData.splice(index, 1);
            delete pendingNewsImages[index];
            renderNewsGrid();
            saveNewsToPending();
        }
    }

    function saveNewsToPending() {
        pendingChanges['news_cards'] = JSON.stringify(newsData);
        updateSaveButtonState();
    }


    // =========================================================
    // 2. LOGIC GALERI / AGENDA
    // =========================================================
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
            let bgColor = (displayImage && displayImage !== '') ? 'bg-white' : 'bg-gray-100';
            
            // --- STYLE BARU (GALLERY CARD) ---
            let html = `
                <div class="relative group h-64 rounded-2xl overflow-hidden shadow-sm border border-gray-200 ${bgColor} bg-cover bg-center hover:shadow-lg transition-all duration-300" style="${bgStyle}">
                    
                    ${ (!displayImage || displayImage === '') ? 
                        '<div class="flex flex-col items-center justify-center h-full text-gray-400"><i class="ph ph-image text-3xl mb-2"></i><span class="text-xs font-medium">Belum ada foto</span></div>' 
                        : '' 
                    }

                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-3 backdrop-blur-[2px]">
                        <span class="text-white text-xs font-bold uppercase tracking-wider mb-1">Kelola Foto</span>
                        <div class="flex gap-2">
                            <button onclick="editGalleryItem(${index})" class="bg-white hover:bg-gray-100 text-gray-900 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110" title="Ganti Foto">
                                <i class="ph ph-camera text-lg"></i>
                            </button>
                            <button onclick="deleteGalleryItem(${index})" class="bg-red-600 hover:bg-red-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110" title="Hapus Foto">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-3 left-3">
                         <span class="bg-purple-600/90 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm">
                            AGENDA
                         </span>
                    </div>

                    ${isNewFile ? 
                        '<div class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm animate-pulse">BARU</div>' 
                        : ''}
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

    // Helper Input for Edit Gallery (Created on fly if needed)
    function editGalleryItem(index) {
        let input = document.getElementById('galleryEditInput');
        if (!input) {
            input = document.createElement('input');
            input.type = 'file';
            input.id = 'galleryEditInput';
            input.accept = 'image/*';
            input.className = 'hidden';
            document.body.appendChild(input);
        }
        input.onchange = function(e) {
            if (this.files && this.files[0]) {
                pendingGalleryFiles[index] = this.files[0];
                renderGalleryGrid();
                saveGalleryToPending();
                this.value = '';
            }
        };
        input.click();
    }

    function deleteGalleryItem(index) {
        if(confirm('Hapus foto agenda ini?')) {
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
    // 3. FINAL SAVE GLOBAL (PENTING!)
    // =========================================================
    if(btnSaveGlobal) {
        btnSaveGlobal.addEventListener('click', function() {
            // Kita paksa slug 'home' karena data berita disimpan di page Home
            let slug = 'home'; 
            
            let originalText = btnSaveGlobal.innerHTML;
            btnSaveGlobal.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
            btnSaveGlobal.disabled = true;

            let formData = new FormData();
            formData.append('page_slug', slug);
            
            // 1. Text & JSON Arrays
            for (let key in pendingChanges) {
                formData.append(`changes[${key}]`, pendingChanges[key]);
            }

            // 2. News Images
            for (let index in pendingNewsImages) {
                formData.append(`news_image_${index}`, pendingNewsImages[index]);
            }

            // 3. Gallery Images
            for (let index in pendingGalleryFiles) {
                formData.append(`gallery_image_${index}`, pendingGalleryFiles[index]);
            }

            // AJAX Request
            fetch("{{ route('redaktur.page.update_batch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil! Data publikasi tersimpan.');
                    window.location.reload();
                } else {
                    alert('Gagal: ' + data.message);
                    btnSaveGlobal.disabled = false;
                    btnSaveGlobal.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan server.');
                btnSaveGlobal.disabled = false;
                btnSaveGlobal.innerHTML = originalText;
            });
        });
    }
</script>
@endpush