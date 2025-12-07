@extends('redaktur.layout')

@section('title', 'Kelola Daftar Informasi')

@section('content')

    <input type="hidden" id="pageSlug" value="informasi">

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Informasi Publik</h2>
            <p class="text-gray-500">Kelola dokumen informasi berkala, serta merta, dan setiap saat.</p>
        </div>
        <button onclick="addInfoItem()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-bold flex items-center gap-2">
            <i class="ph ph-plus"></i> Tambah Dokumen
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <input type="hidden" id="json_information_list" value="{{ cms($page->id, 'information_list', '[]') }}">

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Judul Informasi</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4">File</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="infoTableBody" class="divide-y divide-gray-100 text-sm">
                </tbody>
        </table>
    </div>

    <div id="infoEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Edit Dokumen Informasi</h3>
            <input type="hidden" id="infoIndex">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Dokumen</label>
                    <input type="text" id="infoTitle" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select id="infoCategory" class="w-full border p-2 rounded bg-white">
                        <option value="Berkala">Informasi Berkala</option>
                        <option value="Serta Merta">Informasi Serta Merta</option>
                        <option value="Setiap Saat">Informasi Setiap Saat</option>
                        <option value="Dikecualikan">Informasi Dikecualikan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tahun</label>
                    <input type="number" id="infoYear" class="w-full border p-2 rounded" placeholder="2024">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Upload File (PDF)</label>
                    <input type="file" id="infoFile" accept="application/pdf" class="w-full border p-2 rounded">
                    <p class="text-xs text-gray-400 mt-1">File saat ini: <a id="currentFileLink" href="#" target="_blank" class="text-blue-600 hover:underline">-</a></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button onclick="closeInfoModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200">Batal</button>
                <button onclick="applyInfoChange()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Simpan</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- GLOBAL VARIABLES ---
    let pendingChanges = {};
    let pendingCardFiles = {};
    let pendingNewsImages = {};
    let pendingGalleryFiles = {};
    let pendingInfoFiles = {}; // <--- VARIABEL BARU UNTUK FILE DOKUMEN

    const btnSaveGlobal = document.getElementById('btnSaveGlobal');
    const unsavedIndicator = document.getElementById('unsavedIndicator');

    function updateSaveButtonState() {
        if(btnSaveGlobal) {
            btnSaveGlobal.disabled = false;
            btnSaveGlobal.classList.remove('opacity-50', 'cursor-not-allowed');
            btnSaveGlobal.classList.add('hover:bg-blue-700');
            btnSaveGlobal.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan';
        }
        if(unsavedIndicator) unsavedIndicator.classList.remove('hidden');
    }

    // --- LOGIC INFORMASI ---
    let infoData = [];
    try {
        let raw = document.getElementById('json_information_list').value;
        if(raw && raw !== '[]') infoData = JSON.parse(raw);
    } catch(e) {}

    renderInfoTable();

    function renderInfoTable() {
        const tbody = document.getElementById('infoTableBody');
        tbody.innerHTML = '';

        infoData.forEach((item, index) => {
            // Cek file pending
            let fileLabel = item.file_url ? 'Lihat File' : 'Belum ada';
            let fileClass = item.file_url ? 'text-blue-600 hover:underline' : 'text-gray-400 italic';

            if(pendingInfoFiles[index]) {
                fileLabel = '<span class="text-green-600 font-bold">File Baru Siap Upload</span>';
                fileClass = '';
            }

            let badgeColor = 'bg-gray-100 text-gray-600';
            if(item.category === 'Berkala') badgeColor = 'bg-blue-100 text-blue-700';
            if(item.category === 'Serta Merta') badgeColor = 'bg-orange-100 text-orange-700';
            if(item.category === 'Setiap Saat') badgeColor = 'bg-green-100 text-green-700';

            let row = `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800">${item.title}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold ${badgeColor}">${item.category}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${item.year}</td>
                    <td class="px-6 py-4 text-sm ${fileClass}">
                        ${item.file_url ? `<a href="${item.file_url}" target="_blank">${fileLabel}</a>` : fileLabel}
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <button onclick="editInfo(${index})" class="p-2 text-blue-600 hover:bg-blue-50 rounded"><i class="ph ph-pencil-simple text-xl"></i></button>
                        <button onclick="deleteInfo(${index})" class="p-2 text-red-600 hover:bg-red-50 rounded"><i class="ph ph-trash text-xl"></i></button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    function addInfoItem() {
        infoData.unshift({ title: 'Dokumen Baru', category: 'Berkala', year: new Date().getFullYear(), file_url: '' });
        renderInfoTable();
        saveInfoToPending();
    }

    function editInfo(index) {
        let item = infoData[index];
        document.getElementById('infoIndex').value = index;
        document.getElementById('infoTitle').value = item.title;
        document.getElementById('infoCategory').value = item.category;
        document.getElementById('infoYear').value = item.year;
        document.getElementById('infoFile').value = '';

        let link = document.getElementById('currentFileLink');
        link.href = item.file_url || '#';
        link.innerText = item.file_url ? 'Lihat File Saat Ini' : 'Belum ada file';

        document.getElementById('infoEditorModal').classList.remove('hidden');
        document.getElementById('infoEditorModal').classList.add('flex');
    }

    function closeInfoModal() {
        document.getElementById('infoEditorModal').classList.add('hidden');
        document.getElementById('infoEditorModal').classList.remove('flex');
    }

    function applyInfoChange() {
        let index = document.getElementById('infoIndex').value;
        infoData[index].title = document.getElementById('infoTitle').value;
        infoData[index].category = document.getElementById('infoCategory').value;
        infoData[index].year = document.getElementById('infoYear').value;

        let fileInput = document.getElementById('infoFile');
        if(fileInput.files.length > 0) {
            pendingInfoFiles[index] = fileInput.files[0];
        }

        renderInfoTable();
        saveInfoToPending();
        closeInfoModal();
    }

    function deleteInfo(index) {
        if(confirm('Hapus dokumen ini?')) {
            infoData.splice(index, 1);
            delete pendingInfoFiles[index];
            renderInfoTable();
            saveInfoToPending();
        }
    }

    function saveInfoToPending() {
        pendingChanges['information_list'] = JSON.stringify(infoData);
        updateSaveButtonState();
    }

    // --- SAVE GLOBAL ---
    if(btnSaveGlobal) {
        btnSaveGlobal.addEventListener('click', function() {
            let slug = document.getElementById('pageSlug').value;
            let btn = this;
            let originalText = btn.innerHTML;
            btn.innerHTML = 'Menyimpan...';
            btn.disabled = true;

            let formData = new FormData();
            formData.append('page_slug', slug);

            // 1. Text Changes
            for (let key in pendingChanges) formData.append(`changes[${key}]`, pendingChanges[key]);

            // 2. Info Files (BARU)
            for (let index in pendingInfoFiles) {
                formData.append(`info_file_${index}`, pendingInfoFiles[index]);
            }

            fetch("{{ route('redaktur.page.update_batch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert('Berhasil!');
                window.location.reload();
            });
        });
    }
</script>
@endpush
