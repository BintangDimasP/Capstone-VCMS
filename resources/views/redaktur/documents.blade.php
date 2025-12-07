@extends('redaktur.layout')

@section('title', 'Kelola Dokumen Publik')

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
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Master Dokumen Publik</h2>
            <p class="text-gray-500">Upload Laporan, Renstra, SOP, dan dokumen lainnya.</p>
        </div>
        <button onclick="addDocument()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md font-bold flex items-center gap-2 transition transform active:scale-95">
            <i class="ph ph-plus-circle text-xl"></i> Tambah Dokumen
        </button>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 mb-8 text-center">
        <div class="cms-editable inline-block mb-2" onclick="openEditor('doc_title')" id="wrapper_doc_title">
            <h2 class="text-3xl font-bold text-gray-800">{!! cms($page->id, 'doc_title', 'Dokumen & Laporan') !!}</h2>
        </div>
        <br>
        <div class="cms-editable inline-block" onclick="openEditor('doc_desc')" id="wrapper_doc_desc">
            <p class="text-gray-500 max-w-2xl mx-auto">{!! cms($page->id, 'doc_desc', 'Transparansi informasi publik melalui dokumen yang dapat diakses masyarakat.') !!}</p>
        </div>
    </div>

    <input type="hidden" id="json_document_items" value="{{ cms($homePage->id, 'document_items', '[]') }}">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="documentList"></div>

  <!-- =======================
     MODAL EDIT DOKUMEN
     ======================= -->
<div id="docEditorModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-md hidden items-center justify-center z-[1000] p-4">

    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-xl
                animate-[fadeIn_.25s_ease-out] border border-white/40 relative overflow-hidden">

        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/70 to-transparent pointer-events-none"></div>

        <div class="relative p-7">

            <!-- Header -->
            <div class="flex justify-between items-center mb-5 border-b border-gray-200 pb-4">
                <h3 class="font-bold text-xl text-gray-900 flex items-center gap-2">
                    <span class="h-2 w-2 bg-indigo-600 rounded-full animate-pulse"></span>
                    Edit Dokumen
                </h3>

                <button onclick="closeDocModal()"
                        class="text-gray-400 hover:text-red-500 hover:rotate-90 transition-all duration-200">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>

            <input type="hidden" id="docIndex">

            <!-- Inputs -->
            <div class="space-y-6">

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-1 group-hover:text-indigo-600 transition">
                        Nama Dokumen
                    </label>
                    <input id="docInputTitle"
                           class="w-full border-gray-300 p-3 rounded-lg shadow-sm focus:ring-2
                                  focus:ring-indigo-500 focus:border-indigo-500 transition bg-white" />
                </div>

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-1 group-hover:text-indigo-600 transition">
                        Keterangan / Tahun
                    </label>
                    <input id="docInputMeta"
                           class="w-full border-gray-300 p-3 rounded-lg shadow-sm focus:ring-2
                                  focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                           placeholder="Misal: Laporan 2025" />
                </div>

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-1 group-hover:text-indigo-600 transition">
                        File Dokumen
                    </label>

                    <!-- DROPZONE -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center
                                hover:border-indigo-500 hover:bg-indigo-50/30 transition cursor-pointer"
                         onclick="document.getElementById('docInputFile').click()">

                        <i class="ph ph-upload-simple text-3xl text-indigo-600"></i>
                        <p class="text-gray-600 mt-2">Klik untuk upload atau seret file ke sini</p>

                        <input type="file" id="docInputFile"
                               class="hidden"
                               accept=".pdf,.doc,.docx,.xls,.xlsx">

                        <a id="docCurrentFile" target="_blank"
                           class="text-xs text-indigo-600 mt-3 hidden hover:underline block">
                            Lihat File Saat Ini →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center mt-8 pt-5 border-t border-gray-100">

                <button onclick="deleteDocument()"
                        class="text-red-600 font-semibold hover:underline hover:text-red-700 transition">
                    Hapus
                </button>

                <div class="flex gap-3">

                    <button onclick="closeDocModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-sm
                                   hover:bg-gray-200 hover:shadow transition-all duration-150">
                        Batal
                    </button>

                    <button onclick="applyDocChange()"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-semibold
                                   shadow-md hover:bg-indigo-700 hover:shadow-lg active:scale-95
                                   transition-all duration-150">
                        Simpan
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- =======================
     MODAL EDIT TEKS
     ======================= -->
<div id="editorModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-md hidden items-center justify-center z-[1000] p-4">

    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-lg
                p-6 animate-[fadeIn_.25s_ease-out] border border-white/40 relative">

        <h3 class="font-bold text-xl text-gray-900 mb-4 flex items-center gap-2">
            <i class="ph ph-pencil-line text-blue-600"></i>
            Edit Teks
        </h3>

        <input type="hidden" id="inputKey">

        <textarea id="inputContent" rows="4"
                  class="w-full border-gray-300 p-4 rounded-xl shadow-sm bg-white
                         focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>

        <div class="flex justify-end gap-3 mt-5">

            <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-sm
                           hover:bg-gray-200 hover:shadow transition-all duration-150">
                Batal
            </button>

            <button onclick="applyChangeLocal()"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow-md font-semibold
                           hover:bg-blue-700 hover:shadow-lg active:scale-95 transition-all duration-150">
                Terapkan
            </button>

        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    // ============================================
    // 1. GLOBAL VARIABLES (WAJIB DI PALING ATAS)
    // ============================================
    let pendingChanges = {};
    let pendingDocFiles = {};

    // Variabel Dummy (Agar script Save Global tidak error)
    let pendingCardFiles = {};
    let pendingNewsImages = {};
    let pendingGalleryFiles = {};
    let pendingAgendaImages = {};

    const btnSaveGlobal = document.getElementById('btnSaveGlobal');
    const unsavedIndicator = document.getElementById('unsavedIndicator');

    function updateSaveButtonState() {
        if(btnSaveGlobal) {
            btnSaveGlobal.disabled = false;
            btnSaveGlobal.classList.remove('opacity-50', 'cursor-not-allowed');
            btnSaveGlobal.classList.add('hover:bg-blue-700');

            // Hitung total perubahan
            let total = Object.keys(pendingChanges).length + Object.keys(pendingDocFiles).length;
            btnSaveGlobal.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan (' + total + ')';
        }
        if(unsavedIndicator) unsavedIndicator.classList.remove('hidden');
    }

    // ============================================
    // 2. FUNGSI ADD DOCUMENT (FIXED SCOPE)
    // ============================================
    // Menggunakan window.addDocument agar terbaca oleh onclick HTML
    window.addDocument = function() {
        // Tambahkan data baru
        docData.unshift({
            title: 'Dokumen Baru',
            meta: 'Tahun ' + new Date().getFullYear(),
            url: '#'
        });

        // Render ulang tampilan
        renderDocList();

        // Simpan perubahan ke pending
        saveDocToPending();
    }

    // ============================================
    // 3. LOGIC TEXT EDITOR (HEADER)
    // ============================================
    window.openEditor = function(key) {
        let content = pendingChanges[key] !== undefined ? pendingChanges[key] : document.getElementById('wrapper_' + key).innerText.trim();
        document.getElementById('inputKey').value = key;
        document.getElementById('inputContent').value = content;
        document.getElementById('editorModal').classList.remove('hidden');
        document.getElementById('editorModal').classList.add('flex');
    }

    window.closeModal = function() {
        document.getElementById('editorModal').classList.add('hidden');
        document.getElementById('editorModal').classList.remove('flex');
    }

    window.applyChangeLocal = function() {
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

    // ============================================
    // 4. LOGIC RENDER & EDIT DOKUMEN
    // ============================================
    let docData = [];
    try {
        let rawDoc = document.getElementById('json_document_items').value;
        if(rawDoc && rawDoc !== '[]') docData = JSON.parse(rawDoc);
        else docData = [];
    } catch(e) { console.error("Error parsing JSON:", e); }

    // Render Awal (Pastikan dipanggil setelah definisi data)
    renderDocList();

    function renderDocList() {
        const container = document.getElementById('documentList');
        if(!container) return;
        container.innerHTML = '';

        docData.forEach((item, index) => {
            let fileStatus = pendingDocFiles[index] ? '<span class="text-green-600 text-xs font-bold bg-green-100 px-2 py-1 rounded">File Baru</span>' : '';

            let html = `
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition group flex flex-col items-center text-center h-full relative cursor-pointer" onclick="editDocument(${index})">

                    <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-sm border border-indigo-100">
                        <i class="ph ph-files text-3xl"></i>
                    </div>

                    <h4 class="font-bold text-gray-800 text-lg mb-2 leading-tight">${item.title}</h4>
                    <p class="text-sm text-gray-500 mb-4 bg-gray-100 px-3 py-1 rounded-full">${item.meta}</p>
                    ${fileStatus}

                    <div class="mt-auto pt-4 border-t border-gray-100 w-full flex justify-center gap-4">
                        <span class="text-indigo-600 text-sm font-bold flex items-center gap-1"><i class="ph ph-pencil"></i> Edit</span>
                    </div>
                </div>`;
            container.innerHTML += html;
        });
    }

    window.editDocument = function(index) {
        let item = docData[index];
        document.getElementById('docIndex').value = index;
        document.getElementById('docInputTitle').value = item.title;
        document.getElementById('docInputMeta').value = item.meta;
        document.getElementById('docInputFile').value = '';

        let link = document.getElementById('docCurrentFile');
        if(item.url && item.url !== '#') {
            link.href = item.url;
            link.classList.remove('hidden');
            link.innerText = "Lihat File Saat Ini";
        }
        else { link.classList.add('hidden'); }

        document.getElementById('docEditorModal').classList.remove('hidden');
        document.getElementById('docEditorModal').classList.add('flex');
    }

    window.closeDocModal = function() {
        document.getElementById('docEditorModal').classList.add('hidden');
        document.getElementById('docEditorModal').classList.remove('flex');
    }

    window.applyDocChange = function() {
        let index = document.getElementById('docIndex').value;
        docData[index].title = document.getElementById('docInputTitle').value;
        docData[index].meta = document.getElementById('docInputMeta').value;

        let fileInput = document.getElementById('docInputFile');
        if(fileInput.files.length > 0) {
            pendingDocFiles[index] = fileInput.files[0];
        }

        renderDocList();
        saveDocToPending();
        closeDocModal();
    }

    window.deleteDocument = function() {
        let index = document.getElementById('docIndex').value;
        if(confirm('Hapus dokumen ini?')) {
            docData.splice(index, 1);
            delete pendingDocFiles[index];
            renderDocList();
            saveDocToPending();
            closeDocModal();
        }
    }

    function saveDocToPending() {
        pendingChanges['document_items'] = JSON.stringify(docData);
        updateSaveButtonState();
    }

    // ============================================
    // 5. SAVE GLOBAL (MENGIRIM SEMUA)
    // ============================================
    if(btnSaveGlobal) {
        btnSaveGlobal.addEventListener('click', function() {
            let slug = document.getElementById('pageSlug').value;
            let originalText = btnSaveGlobal.innerHTML;
            btnSaveGlobal.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
            btnSaveGlobal.disabled = true;

            let formData = new FormData();
            formData.append('page_slug', slug);

            // PERBAIKAN 1: Tambahkan Backtick (`) di sekitar string key
            for (let key in pendingChanges) {
                formData.append(`changes[${key}]`, pendingChanges[key]);
            }

            // PERBAIKAN 2: Tambahkan Backtick (`) di sini juga
            for (let index in pendingDocFiles) {
                formData.append(`document_file_${index}`, pendingDocFiles[index]);
            }

            fetch("{{ route('redaktur.documents.update') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil! Dokumen tersimpan.');
                    window.location.reload();
                } else {
                    alert('Gagal: ' + (data.message || 'Unknown Error'));
                    btnSaveGlobal.disabled = false;
                    btnSaveGlobal.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error Server. Cek Console.');
                btnSaveGlobal.disabled = false;
                btnSaveGlobal.innerHTML = originalText;
            });
        });
    }
</script>
@endpush
