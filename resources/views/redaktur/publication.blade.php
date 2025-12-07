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

    <div class="flex gap-4 border-b border-gray-200 mb-8">
        <button onclick="switchTab('news')" id="tab-news" class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-bold transition">
            <i class="ph ph-newspaper"></i> Kabar Berita
        </button>
        <button onclick="switchTab('agenda')" id="tab-agenda" class="px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-purple-600 transition">
            <i class="ph ph-calendar-check"></i> Agenda / Galeri
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

            let html = `
                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden flex flex-col h-[320px] relative group hover:shadow-lg transition">
                    <div class="h-36 bg-gray-200 overflow-hidden relative shrink-0">
                        <img src="${displayImage}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center">
                            <button onclick="editNews(${index})" class="bg-white text-gray-800 px-4 py-1 rounded-full text-sm font-bold shadow hover:bg-gray-100 flex items-center gap-2">
                                <i class="ph ph-pencil"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <div class="text-xs text-blue-600 font-bold mb-1 uppercase tracking-wider">${item.date || '-'}</div>
                        <h4 class="font-bold text-gray-800 text-sm leading-tight line-clamp-2 h-[2.5rem] overflow-hidden">${item.title}</h4>
                        <div class="text-gray-500 text-xs mt-2 line-clamp-3 h-[3.5rem] overflow-hidden">${item.desc}</div>
                        
                        <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium">Berita</span>
                            <button onclick="deleteNews(${index})" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-wide">Hapus</button>
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
            
            let bgStyle = (displayImage && displayImage !== '') ? `background-image: url('${displayImage}');` : 'background-color: #eee;';
            
            let html = `
                <div class="h-48 rounded-lg shadow-sm border border-gray-200 bg-cover bg-center relative group hover:shadow-md transition" style="${bgStyle}">
                    ${ (!displayImage || displayImage === '') ? '<div class="flex items-center justify-center h-full text-gray-500 font-medium text-xs">No Image</div>' : '' }
                    
                    <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center gap-2 transition-opacity">
                        <button onclick="editGalleryItem(${index})" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded shadow transition transform hover:scale-105" title="Ganti Foto">
                            <i class="ph ph-pencil"></i>
                        </button>
                        <button onclick="deleteGalleryItem(${index})" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded shadow transition transform hover:scale-105" title="Hapus">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                    
                    <div class="absolute bottom-2 left-2 bg-purple-600 text-white text-[10px] px-2 py-0.5 rounded shadow">Agenda</div>
                    ${isNewFile ? '<div class="absolute top-2 right-2 bg-green-500 text-white text-[10px] px-2 py-0.5 rounded shadow">Baru</div>' : ''}
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