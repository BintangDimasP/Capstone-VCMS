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
                <button onclick="openGalleryModal(-1)"
    class="bg-purple-600 text-white px-4 py-2 rounded-lg
           hover:bg-purple-700 font-bold text-sm flex items-center gap-2">
    <i class="ph ph-plus"></i> Tambah Agenda Baru
</button>

            </div>
        </div>

        <input type="hidden" id="json_gallery_items" value="{{ cms($homePage->id, 'gallery_items', '[]') }}">
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="galleryGrid"></div>
    </div>

    {{-- Modal Edit Berita --}}
<div id="newsEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-auto overflow-hidden">
        
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-4 flex justify-between items-center">
            <h3 id="newsModalTitle" class="text-lg font-bold flex items-center gap-2">
                <i class="ph ph-newspaper"></i> Edit Berita
            </h3>
            <button onclick="closeNewsModal()" class="text-white/80 hover:text-white">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
        
        <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <input type="hidden" id="newsIndex">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" id="newsInputTitle" 
                       placeholder="Contoh: Peluncuran Layanan Digital PPID"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Tanggal Publikasi <span class="text-red-500">*</span>
                </label>
                <input type="date" id="newsInputDate" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Deskripsi Singkat <span class="text-red-500">*</span>
                </label>
                <textarea id="newsInputDesc" rows="4" 
                          placeholder="Jelaskan isi berita secara singkat..."
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Link/URL Berita <span class="text-red-500">*</span>
                </label>
                <input type="url" id="newsInputUrl" 
                       placeholder="https://example.com/berita-lengkap"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Gambar Berita <span class="text-red-500" id="newsImageRequired">*</span>
                </label>
                <input type="file" id="newsInputImage" accept="image/*" 
                       class="block w-full text-sm text-gray-500 
                       file:mr-4 file:py-2 file:px-4 file:rounded-lg
                       file:border-0 file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100 border rounded-lg cursor-pointer">
                
                <img id="newsPreviewImg" class="hidden mt-3 w-full h-48 object-cover rounded border bg-gray-100">
                
                <p class="mt-1 text-xs text-gray-500">
                    <i class="ph ph-info"></i> Format: JPG, PNG. Rekomendasi: 1200x630px
                </p>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t">
            <button id="deleteNewsBtn" onclick="deleteNews()" 
                    class="text-red-500 font-bold text-sm hover:text-red-700 flex items-center gap-1">
                <i class="ph ph-trash"></i> Hapus
            </button>

            <div class="flex gap-2">
                <button onclick="closeNewsModal()" 
                        class="px-4 py-2 bg-white border rounded-lg text-gray-600 hover:bg-gray-100">
                    Batal
                </button>
                <button onclick="applyNewsChange()" 
                        class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                    <i class="ph ph-check-circle"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Agenda/Gallery - LENGKAP --}}
<div id="galleryEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden">

        <div class="bg-gradient-to-r from-purple-600 to-purple-400 text-white px-6 py-4 flex justify-between items-center">
            <h3 id="galleryModalTitle" class="text-lg font-bold flex items-center gap-2">
                <i class="ph ph-image"></i> Edit Agenda
            </h3>
            <button onclick="closeGalleryModal()" class="text-white/80 hover:text-white">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <input type="hidden" id="galleryIndex">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Judul Agenda <span class="text-red-500">*</span>
                </label>
                <input type="text" id="galleryTitle"
                       placeholder="Contoh: Sosialisasi UU Keterbukaan Informasi"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Tanggal Agenda <span class="text-red-500">*</span>
                </label>
                <input type="date" id="galleryDate"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Deskripsi Agenda <span class="text-red-500">*</span>
                </label>
                <textarea id="galleryDesc" rows="3"
                          placeholder="Jelaskan kegiatan agenda ini..."
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Foto Agenda <span class="text-red-500" id="galleryImageRequired">*</span>
                </label>
                <input type="file" id="galleryImage" accept="image/*"
                       class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4 file:rounded-lg
                       file:border-0 file:bg-purple-50 file:text-purple-700
                       hover:file:bg-purple-100 border rounded-lg cursor-pointer">

                <img id="galleryPreview"
                     class="hidden mt-3 w-full h-40 object-cover rounded border bg-gray-100">
                
                <p class="mt-1 text-xs text-gray-500">
                    <i class="ph ph-info"></i> Format: JPG, PNG. Maksimal 5MB
                </p>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t">
            <button id="deleteGalleryBtn" onclick="deleteGalleryItem()"
                    class="text-red-500 font-bold text-sm hover:text-red-700 flex items-center gap-1 hidden">
                <i class="ph ph-trash"></i> Hapus
            </button>

            <div class="flex gap-2 ml-auto">
                <button onclick="closeGalleryModal()"
                        class="px-4 py-2 bg-white border rounded-lg text-gray-600 hover:bg-gray-100">
                    Batal
                </button>
                <button onclick="saveGalleryItem()"
                        class="px-4 py-2 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700">
                    <i class="ph ph-check-circle"></i> Simpan
                </button>
            </div>
        </div>
    </div>
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

try {
    let rawNews = document.getElementById('json_news_cards').value;
    if(rawNews && rawNews !== '[]') newsData = JSON.parse(rawNews);
} catch(e) { console.error("Error parsing News", e); }

try {
    let rawGallery = document.getElementById('json_gallery_items').value;
    if(rawGallery && rawGallery !== '[]') galleryData = JSON.parse(rawGallery);
} catch(e) { console.error("Error parsing Gallery", e); }

renderNewsGrid();
renderGalleryGrid();

// =========================================================
// 1. LOGIC BERITA (NEWS) - WITH VALIDATION
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
                        
                        <button onclick="confirmDeleteNews(${index})" class="text-gray-400 hover:text-red-600 text-sm font-medium flex items-center gap-1 transition">
                            <i class="ph ph-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>`;
        container.innerHTML += html;
    });
}

// Tambah berita baru - langsung buka modal
function addNewsCard() {
    document.getElementById('newsIndex').value = -1; // Mode tambah baru
    document.getElementById('newsInputTitle').value = '';
    document.getElementById('newsInputDate').value = '';
    document.getElementById('newsInputDesc').value = '';
    document.getElementById('newsInputUrl').value = '';
    document.getElementById('newsInputImage').value = '';
    document.getElementById('newsPreviewImg').classList.add('hidden');
    
    // Ubah judul modal & tombol hapus
    document.getElementById('newsModalTitle').innerHTML = '<i class="ph ph-plus-circle"></i> Tambah Berita Baru';
    document.getElementById('deleteNewsBtn').classList.add('hidden');
    
    document.getElementById('newsEditorModal').classList.remove('hidden');
    document.getElementById('newsEditorModal').classList.add('flex');
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
    
    // Ubah judul modal & tampilkan tombol hapus
    document.getElementById('newsModalTitle').innerHTML = '<i class="ph ph-newspaper"></i> Edit Berita';
    document.getElementById('deleteNewsBtn').classList.remove('hidden');
    
    document.getElementById('newsEditorModal').classList.remove('hidden');
    document.getElementById('newsEditorModal').classList.add('flex');
}

function closeNewsModal() {
    document.getElementById('newsEditorModal').classList.add('hidden');
    document.getElementById('newsEditorModal').classList.remove('flex');
}

// VALIDASI saat simpan
function applyNewsChange() {
    let index = parseInt(document.getElementById('newsIndex').value);
    let title = document.getElementById('newsInputTitle').value.trim();
    let date = document.getElementById('newsInputDate').value.trim();
    let desc = document.getElementById('newsInputDesc').value.trim();
    let url = document.getElementById('newsInputUrl').value.trim();
    let fileInput = document.getElementById('newsInputImage');
    
    // VALIDASI
    if (!title) {
        alert('⚠️ Judul berita harus diisi!');
        document.getElementById('newsInputTitle').focus();
        return;
    }
    
    if (!date) {
        alert('⚠️ Tanggal publikasi harus diisi!');
        document.getElementById('newsInputDate').focus();
        return;
    }
    
    if (!desc) {
        alert('⚠️ Deskripsi berita harus diisi!');
        document.getElementById('newsInputDesc').focus();
        return;
    }
    
    if (!url) {
        alert('⚠️ URL/Link berita harus diisi!');
        document.getElementById('newsInputUrl').focus();
        return;
    }
    
    // Mode tambah baru
    if (index === -1) {
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('⚠️ Gambar berita harus diupload!');
            document.getElementById('newsInputImage').focus();
            return;
        }
        
        let newIndex = newsData.push({
            title: title,
            date: date,
            desc: desc,
            url: url,
            image: ''
        }) - 1;
        
        pendingNewsImages[newIndex] = fileInput.files[0];
    }
    // Mode edit
    else {
        newsData[index].title = title;
        newsData[index].date = date;
        newsData[index].desc = desc;
        newsData[index].url = url;
        
        if (fileInput.files && fileInput.files.length > 0) {
            pendingNewsImages[index] = fileInput.files[0];
        }
    }
    
    renderNewsGrid();
    saveNewsToPending();
    closeNewsModal();
}

function confirmDeleteNews(index) {
    if(confirm('⚠️ Yakin ingin menghapus berita ini?')) {
        deleteNews(index);
    }
}

function deleteNews(index) {
    // Jika dipanggil dari modal
    if (index === undefined) {
        index = parseInt(document.getElementById('newsIndex').value);
    }
    
    newsData.splice(index, 1);
    delete pendingNewsImages[index];
    
    // Reindex pendingNewsImages
    const newPendingImages = {};
    Object.keys(pendingNewsImages).forEach(key => {
        const oldIndex = parseInt(key);
        if (oldIndex > index) {
            newPendingImages[oldIndex - 1] = pendingNewsImages[oldIndex];
        } else if (oldIndex < index) {
            newPendingImages[oldIndex] = pendingNewsImages[oldIndex];
        }
    });
    pendingNewsImages = newPendingImages;
    
    renderNewsGrid();
    saveNewsToPending();
    closeNewsModal();
}

function saveNewsToPending() {
    pendingChanges['news_cards'] = JSON.stringify(newsData);
    updateSaveButtonState();
}

// Preview image saat upload
document.getElementById('newsInputImage').addEventListener('change', function(e) {
    const preview = document.getElementById('newsPreviewImg');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(this.files[0]);
    }
});

// =========================================================
// 2. LOGIC GALERI / AGENDA - WITH VALIDATION
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
        
        let html = `
            <div class="relative group h-64 rounded-2xl overflow-hidden shadow-sm border border-gray-200 ${bgColor} bg-cover bg-center hover:shadow-lg transition-all duration-300" style="${bgStyle}">
                
                ${ (!displayImage || displayImage === '') ? 
                    '<div class="flex flex-col items-center justify-center h-full text-gray-400"><i class="ph ph-image text-3xl mb-2"></i><span class="text-xs font-medium">Belum ada foto</span></div>' 
                    : '' 
                }

                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-3 backdrop-blur-[2px]">
                    <span class="text-white text-xs font-bold uppercase tracking-wider mb-1">Kelola Foto</span>
                    <div class="flex gap-2">
                        <button onclick="editGalleryModal(${index})" class="bg-white hover:bg-gray-100 text-gray-900 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110" title="Edit">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <button onclick="confirmDeleteGallery(${index})" class="bg-red-600 hover:bg-red-700 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110" title="Hapus">
                            <i class="ph ph-trash text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <div class="absolute bottom-3 left-3 right-3">
                     <span class="bg-purple-600/90 backdrop-blur text-white text-xs font-bold px-2.5 py-1.5 rounded-md shadow-sm block truncate">
                        ${item.title || 'AGENDA'}
                     </span>
                </div>

                ${isNewFile ? 
                    '<div class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm animate-pulse">BARU</div>' 
                    : ''}
            </div>`;
        container.innerHTML += html;
    });
}

// Tambah agenda baru via modal


function openGalleryModal(index) {
    const modal      = document.getElementById('galleryEditorModal');
    const titleInput = document.getElementById('galleryTitle');
    const dateInput  = document.getElementById('galleryDate');
    const descInput  = document.getElementById('galleryDesc');
    const imageInput = document.getElementById('galleryImage');
    const preview    = document.getElementById('galleryPreview');
    const deleteBtn  = document.getElementById('deleteGalleryBtn');
    const indexInput = document.getElementById('galleryIndex');

    // ===== RESET =====
    titleInput.value = '';
    dateInput.value  = '';
    descInput.value  = '';
    imageInput.value = '';
    preview.src = '';
    preview.classList.add('hidden');

    indexInput.value = index;

    // ===== EDIT =====
    if (index >= 0 && galleryData[index]) {
        const item = galleryData[index];

        titleInput.value = item.title || '';
        dateInput.value  = item.date  || '';
        descInput.value  = item.desc  || '';

        let displayImage = item.image;
        if (pendingGalleryFiles[index]) {
            displayImage = URL.createObjectURL(pendingGalleryFiles[index]);
        }

        if (displayImage) {
            preview.src = displayImage;
            preview.classList.remove('hidden');
        }

        deleteBtn.classList.remove('hidden');
        document.getElementById('galleryModalTitle').innerHTML =
            '<i class="ph ph-image"></i> Edit Agenda';
    }
    // ===== ADD =====
    else {
        deleteBtn.classList.add('hidden');
        document.getElementById('galleryModalTitle').innerHTML =
            '<i class="ph ph-plus-circle"></i> Tambah Agenda Baru';
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function editGalleryModal(index) {
    openGalleryModal(index);
}

function closeGalleryModal() {
    const modal = document.getElementById('galleryEditorModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Preview gallery image
document.getElementById('galleryImage').addEventListener('change', function(e) {
    const preview = document.getElementById('galleryPreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(this.files[0]);
    }
});

// VALIDASI saat simpan gallery
function saveGalleryItem() {
    const index = parseInt(document.getElementById('galleryIndex').value);
    const title = document.getElementById('galleryTitle').value.trim();
    const date  = document.getElementById('galleryDate').value.trim();
    const desc  = document.getElementById('galleryDesc').value.trim();
    const imageInput = document.getElementById('galleryImage');

    if (!title) {
        alert('⚠️ Judul agenda harus diisi!');
        galleryTitle.focus();
        return;
    }

    if (!date) {
        alert('⚠️ Tanggal agenda harus diisi!');
        galleryDate.focus();
        return;
    }

    if (!desc) {
        alert('⚠️ Deskripsi agenda harus diisi!');
        galleryDesc.focus();
        return;
    }

    // ===== TAMBAH =====
    if (index === -1) {
        if (!imageInput.files || !imageInput.files.length) {
            alert('⚠️ Foto agenda wajib diupload!');
            galleryImage.focus();
            return;
        }

        const newIndex = galleryData.push({
            title,
            date,
            desc,
            image: ''
        }) - 1;

        pendingGalleryFiles[newIndex] = imageInput.files[0];
    }
    // ===== EDIT =====
    else {
        galleryData[index] = {
            ...galleryData[index],
            title,
            date,
            desc
        };

        if (imageInput.files && imageInput.files.length > 0) {
            pendingGalleryFiles[index] = imageInput.files[0];
        }
    }

    renderGalleryGrid();
    saveGalleryToPending();
    closeGalleryModal();
}



function confirmDeleteGallery(index) {
    if(confirm('⚠️ Yakin ingin menghapus foto agenda ini?')) {
        deleteGalleryItem(index);
    }
}

function deleteGalleryItem(index) {
    if (index === undefined) {
        index = parseInt(document.getElementById('galleryIndex').value);
    }
    
    galleryData.splice(index, 1);
    delete pendingGalleryFiles[index];
    
    const newPendingFiles = {};
    Object.keys(pendingGalleryFiles).forEach(key => {
        const oldIndex = parseInt(key);
        if (oldIndex > index) {
            newPendingFiles[oldIndex - 1] = pendingGalleryFiles[oldIndex];
        } else if (oldIndex < index) {
            newPendingFiles[oldIndex] = pendingGalleryFiles[oldIndex];
        }
    });
    pendingGalleryFiles = newPendingFiles;
    
    renderGalleryGrid();
    saveGalleryToPending();
    closeGalleryModal();
}

function saveGalleryToPending() {
    pendingChanges['gallery_items'] = JSON.stringify(galleryData);
    updateSaveButtonState();
}

// =========================================================
// 3. FINAL SAVE GLOBAL
// =========================================================
if(btnSaveGlobal) {
    btnSaveGlobal.addEventListener('click', function() {
        let slug = 'home';
        let originalText = btnSaveGlobal.innerHTML;
        btnSaveGlobal.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
        btnSaveGlobal.disabled = true;

        let formData = new FormData();
        formData.append('page_slug', slug);
        
        for (let key in pendingChanges) {
            formData.append(`changes[${key}]`, pendingChanges[key]);
        }

        for (let index in pendingNewsImages) {
            formData.append(`news_image_${index}`, pendingNewsImages[index]);
        }

        for (let index in pendingGalleryFiles) {
            formData.append(`gallery_image_${index}`, pendingGalleryFiles[index]);
        }

        fetch("{{ route('redaktur.page.update_batch') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                alert('✅ Berhasil! Data publikasi tersimpan.');
                window.location.reload();
            } else {
                alert('❌ Gagal: ' + data.message);
                btnSaveGlobal.disabled = false;
                btnSaveGlobal.innerHTML = originalText;
            }
        })
        .catch(err => {
            console.error(err);
            alert('❌ Terjadi kesalahan server.');
            btnSaveGlobal.disabled = false;
            btnSaveGlobal.innerHTML = originalText;
        });
    });
}
</script>
@endpush