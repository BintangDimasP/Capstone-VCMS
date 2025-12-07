@extends('redaktur.layout')

@section('title', 'Kelola Regulasi')

@section('content')

    <input type="hidden" id="pageSlug" value="regulasi">
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
   <div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Master Regulasi</h2>
        <p class="text-gray-500">Kelola dokumen hukum dan peraturan daerah.</p>
    </div>
    <button onclick="addRegulation()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md font-bold flex items-center gap-2 transition transform active:scale-95">
        <i class="ph ph-plus"></i> Tambah Regulasi
    </button>
</div>

<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 mb-8 text-center">
    <div class="cms-editable inline-block mb-2" onclick="openEditor('regulasi_title')" id="wrapper_regulasi_title">
        <h2 class="text-3xl font-bold text-gray-800">{!! cms($page->id, 'regulasi_title', 'Produk Hukum & Regulasi') !!}</h2>
    </div>
    <br>
    <div class="cms-editable inline-block" onclick="openEditor('regulasi_desc')" id="wrapper_regulasi_desc">
        <p class="text-gray-500 max-w-2xl mx-auto">{!! cms($page->id, 'regulasi_desc', 'Daftar peraturan perundang-undangan yang berlaku.') !!}</p>
    </div>
</div>

<input type="hidden" id="json_regulation_items" value="{{ cms($page->id, 'regulation_items', '[]') }}">
<div class="space-y-4" id="regulationList"></div>


<div id="regEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all scale-100">

        <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-6 py-4 flex items-center justify-between shadow-md">
            <h3 class="text-lg font-bold tracking-wide flex items-center gap-2">
                <i class="ph ph-file-text"></i> Edit Dokumen
            </h3>
            <button onclick="closeRegModal()" class="text-white/80 hover:text-white"><i class="ph ph-x text-lg"></i></button>
        </div>

        <div class="px-6 py-6 space-y-4">
            <input type="hidden" id="regIndex">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul / Nomor Regulasi</label>
                <input type="text" id="regInputTitle" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori / Tahun</label>
                <input type="text" id="regInputYear" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <label class="block text-sm font-bold text-blue-800 mb-2">File Dokumen</label>

                <input type="file" id="regInputFile" accept=".pdf, image/*" onchange="previewFile(this)"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">

                <div id="newFilePreview" class="mt-3 hidden">
                    <p class="text-xs font-bold text-green-600 mb-1">File Baru Dipilih:</p>
                    <div class="flex items-center gap-2 bg-white p-2 rounded border border-green-200 text-green-700 text-sm">
                        <i class="ph ph-check-circle text-lg"></i> <span id="newFileName">filename.pdf</span>
                    </div>
                </div>

                <div id="existingFilePreview" class="mt-4 pt-3 border-t border-blue-200 hidden">
                    <p class="text-xs font-bold text-gray-500 mb-1">File Tersimpan Saat Ini:</p>
                    <div class="flex items-center justify-between bg-white p-2 rounded border border-gray-300">
                        <div class="flex items-center gap-2 overflow-hidden">
                            <i class="ph ph-file text-gray-500 text-lg"></i>
                            <a id="existingFileLink" href="#" target="_blank" class="text-sm text-blue-600 font-bold hover:underline truncate max-w-[200px]">
                                Lihat File
                            </a>
                        </div>
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">Server</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-between border-t border-gray-100">
            <button onclick="deleteRegulation()" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-1">
                <i class="ph ph-trash"></i> Hapus
            </button>
            <div class="flex gap-2">
                <button onclick="closeRegModal()" class="px-4 py-2 text-gray-600 bg-white border rounded-lg hover:bg-gray-50">Batal</button>
                <button onclick="applyRegChange()" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="editorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
        <h3 class="font-bold text-lg mb-4">Edit Teks</h3>
        <input type="hidden" id="inputKey">
        <textarea id="inputContent" rows="4" class="w-full border p-3 rounded-lg"></textarea>
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal()" class="px-4 py-2 text-gray-600">Batal</button>
            <button onclick="applyChangeLocal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Terapkan</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// --- GLOBAL VARIABLES ---
let pendingChanges = {};
let pendingRegFiles = {}; // Penampung File

// Dummy Vars (Agar script global tidak error)
let pendingCardFiles = {};
let pendingNewsImages = {};
let pendingGalleryFiles = {};

const btnSaveGlobal = document.getElementById('btnSaveGlobal');
const unsavedIndicator = document.getElementById('unsavedIndicator');

function updateSaveButtonState() {
    if(btnSaveGlobal) {
        btnSaveGlobal.disabled = false;
        btnSaveGlobal.classList.remove('opacity-50', 'cursor-not-allowed');
        btnSaveGlobal.classList.add('hover:bg-blue-700');

        let total = Object.keys(pendingChanges).length + Object.keys(pendingRegFiles).length;
        btnSaveGlobal.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan (' + total + ')';
    }
    if(unsavedIndicator) unsavedIndicator.classList.remove('hidden');
}

// --- LOGIC TEXT EDITOR ---
function openEditor(key) {
    let content = pendingChanges[key] !== undefined ? pendingChanges[key] : document.getElementById('wrapper_' + key).innerText.trim();
    document.getElementById('inputKey').value = key;
    document.getElementById('inputContent').value = content;
    document.getElementById('editorModal').classList.remove('hidden');
    document.getElementById('editorModal').classList.add('flex');
}
function closeModal() { document.getElementById('editorModal').classList.add('hidden'); document.getElementById('editorModal').classList.remove('flex'); }
function applyChangeLocal() {
    let key = document.getElementById('inputKey').value;
    let content = document.getElementById('inputContent').value;
    pendingChanges[key] = content;
    let wrapper = document.getElementById('wrapper_' + key);
    if(wrapper.querySelector('h2')) wrapper.querySelector('h2').innerText = content;
    else if(wrapper.querySelector('p')) wrapper.querySelector('p').innerText = content;
    else wrapper.innerText = content;
    updateSaveButtonState();
    closeModal();
}

// ==============================================
    // LOGIC REGULASI (UPDATED PREVIEW)
    // ==============================================
    let regData = [];

    // 1. Load Data
    try {
        let rawReg = document.getElementById('json_regulation_items').value;
        if(rawReg && rawReg !== '[]') regData = JSON.parse(rawReg);
    } catch(e) { console.error("Error load regulasi", e); }

    renderRegList();

    // 2. Render List (Tampilkan tombol MATA jika file ada)
    function renderRegList() {
        const container = document.getElementById('regulationList');
        if(!container) return;
        container.innerHTML = '';

        regData.forEach((item, index) => {
            // Cek Pending
            let hasPending = pendingRegFiles[index] ? true : false;
            let fileStatus = hasPending ? '<span class="text-green-600 text-xs font-bold ml-2 animate-pulse">📄 File Baru</span>' : '';

            // Cek URL Database
            let hasUrl = item.url && item.url !== '#';
            let viewBtn = '';

            // Icon Logic
            let icon = '<i class="ph ph-file-text text-2xl"></i>';
            if (hasUrl || hasPending) icon = '<i class="ph ph-file-pdf text-2xl text-red-500"></i>';

            // Tombol LIHAT (Hanya muncul jika file ada di server atau pending)
            let previewLink = hasPending ? URL.createObjectURL(pendingRegFiles[index]) : item.url;

            if (hasUrl || hasPending) {
                viewBtn = `<a href="${previewLink}" target="_blank" class="bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 p-2 rounded-lg transition" title="Lihat File">
                                <i class="ph ph-eye text-xl"></i>
                           </a>`;
            } else {
                viewBtn = `<span class="text-gray-300 p-2 cursor-not-allowed" title="Belum ada file"><i class="ph ph-eye-slash text-xl"></i></span>`;
            }

            let html = `
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between hover:border-blue-300 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center border border-gray-100">
                            ${icon}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-base leading-tight">${item.title}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded font-medium">${item.year}</span>
                                ${fileStatus}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        ${viewBtn}
                        <button onclick="editRegulation(${index})" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition" title="Edit">
                            <i class="ph ph-pencil-simple text-xl"></i>
                        </button>
                    </div>
                </div>`;
            container.innerHTML += html;
        });
    }

    function addRegulation() {
        regData.unshift({ title: 'Regulasi Baru', year: new Date().getFullYear(), url: '#' });
        renderRegList();
        saveRegToPending();
    }

    // 3. Edit & Tampilkan Preview di Modal
    function editRegulation(index) {
        let item = regData[index];
        document.getElementById('regIndex').value = index;
        document.getElementById('regInputTitle').value = item.title;
        document.getElementById('regInputYear').value = item.year;

        // Reset Input
        let input = document.getElementById('regInputFile');
        input.value = '';

        // --- LOGIC PREVIEW DI MODAL ---
        let newPreview = document.getElementById('newFilePreview');
        let newName = document.getElementById('newFileName');

        let oldPreview = document.getElementById('existingFilePreview');
        let oldLink = document.getElementById('existingFileLink');

        // Reset Tampilan
        newPreview.classList.add('hidden');
        oldPreview.classList.add('hidden');

        // A. Apakah ada file baru (Pending) yang belum di-save global?
        if (pendingRegFiles[index]) {
            newPreview.classList.remove('hidden');
            newName.innerText = pendingRegFiles[index].name + " (Belum Disimpan)";
        }

        // B. Apakah sudah ada file di database?
        if (item.url && item.url !== '#') {
            oldPreview.classList.remove('hidden');
            oldLink.href = item.url;
            oldLink.innerText = "Buka File PDF / Gambar";
        }

        document.getElementById('regEditorModal').classList.remove('hidden');
        document.getElementById('regEditorModal').classList.add('flex');
    }

    // 4. Preview Saat Pilih File Baru
    function previewFile(input) {
        let newPreview = document.getElementById('newFilePreview');
        let newName = document.getElementById('newFileName');

        if(input.files && input.files[0]) {
            let file = input.files[0];
            newPreview.classList.remove('hidden');
            newName.innerText = file.name;
        } else {
            newPreview.classList.add('hidden');
        }
    }

    function closeRegModal() {
        document.getElementById('regEditorModal').classList.add('hidden');
        document.getElementById('regEditorModal').classList.remove('flex');
    }

    function applyRegChange() {
        let index = document.getElementById('regIndex').value;
        regData[index].title = document.getElementById('regInputTitle').value;
        regData[index].year = document.getElementById('regInputYear').value;

        let fileInput = document.getElementById('regInputFile');
        if(fileInput.files.length > 0) {
            pendingRegFiles[index] = fileInput.files[0];
        }

        renderRegList();
        saveRegToPending();
        closeRegModal();
    }

    // ... (Fungsi deleteRegulation dan saveRegToPending TETAP SAMA) ...
    function deleteRegulation() {
        let index = document.getElementById('regIndex').value;
        if(confirm('Hapus regulasi ini?')) {
            regData.splice(index, 1);
            delete pendingRegFiles[index];
            renderRegList();
            saveRegToPending();
            closeRegModal();
        }
    }

    function saveRegToPending() {
        pendingChanges['regulation_items'] = JSON.stringify(regData);
        updateSaveButtonState();
    }

// --- LOGIC PREVIEW FILE (PDF / GAMBAR) ---
function previewFile(input) {
    if(input.files && input.files[0]) {
        let file = input.files[0];
        let container = document.getElementById('previewContainer');
        let pdfBox = document.getElementById('pdfPreviewBox');
        let pdfName = document.getElementById('pdfFileName');
        let imgBox = document.getElementById('imgPreviewBox');

        // Reset dulu
        container.classList.remove('hidden');
        pdfBox.classList.add('hidden');
        imgBox.classList.add('hidden');

        if(file.type === 'application/pdf') {
            // Tampilkan Kotak Hijau PDF
            pdfBox.classList.remove('hidden');
            pdfBox.classList.add('flex');
            pdfName.innerText = file.name;
        } else if (file.type.startsWith('image/')) {
            // Tampilkan Gambar
            imgBox.classList.remove('hidden');
            imgBox.src = URL.createObjectURL(file);
        }
    }
}

function resetPreviewUI() {
    document.getElementById('previewContainer').classList.add('hidden');
    document.getElementById('regCurrentFile').classList.add('hidden');
}

function closeRegModal() {
    document.getElementById('regEditorModal').classList.add('hidden');
    document.getElementById('regEditorModal').classList.remove('flex');
}

function applyRegChange() {
    let index = document.getElementById('regIndex').value;
    regData[index].title = document.getElementById('regInputTitle').value;
    regData[index].year = document.getElementById('regInputYear').value;

    let fileInput = document.getElementById('regInputFile');
    if(fileInput.files.length > 0) {
        pendingRegFiles[index] = fileInput.files[0];
    }

    renderRegList();
    saveRegToPending();
    closeRegModal();
}

function deleteRegulation() {
    let index = document.getElementById('regIndex').value;
    if(confirm('Hapus regulasi ini?')) {
        regData.splice(index, 1);
        delete pendingRegFiles[index];
        renderRegList();
        saveRegToPending();
        closeRegModal();
    }
}

function saveRegToPending() {
    pendingChanges['regulation_items'] = JSON.stringify(regData);
    updateSaveButtonState();
}

// --- SAVE GLOBAL ---
if(btnSaveGlobal) {
    btnSaveGlobal.addEventListener('click', function() {
        let slug = document.getElementById('pageSlug').value;
        let originalText = btnSaveGlobal.innerHTML;
        btnSaveGlobal.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
        btnSaveGlobal.disabled = true;

        let formData = new FormData();
        formData.append('page_slug', slug);

        for (let key in pendingChanges) formData.append(`changes[${key}]`, pendingChanges[key]);

        // Loop Files
        for (let index in pendingRegFiles) {
            formData.append(`regulation_file_${index}`, pendingRegFiles[index]);
        }

        fetch("{{ route('redaktur.regulation.save') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Berhasil! Data regulasi tersimpan.');
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
