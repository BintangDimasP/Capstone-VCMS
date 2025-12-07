@extends('redaktur.layout')

@section('title', 'Kelola Daftar Informasi')

@section('content')

    <input type="hidden" id="pageSlug" value="home">

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Informasi Publik</h2>
            <p class="text-gray-500">Kelola dokumen informasi berkala, serta merta, dan setiap saat.</p>
        </div>
        <button onclick="addInfoItem()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-bold flex items-center gap-2 transition transform active:scale-95">
            <i class="ph ph-plus"></i> Tambah Dokumen
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <input type="hidden" id="json_information_list" value="{{ cms($homePage->id, 'information_list', '[]') }}">

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Judul Dokumen</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4">File / Dokumen</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="infoTableBody" class="divide-y divide-gray-100 text-sm">
                </tbody>
        </table>
    </div>

    <div id="infoEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000] transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 transform scale-100 transition-transform">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Edit Dokumen Informasi</h3>
                <button onclick="closeInfoModal()" class="text-gray-400 hover:text-red-500"><i class="ph ph-x text-xl"></i></button>
            </div>

            <input type="hidden" id="infoIndex">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Dokumen</label>
                    <input type="text" id="infoTitle" class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select id="infoCategory" class="w-full border border-gray-300 p-2.5 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Berkala">Informasi Berkala</option>
                        <option value="Serta Merta">Informasi Serta Merta</option>
                        <option value="Setiap Saat">Informasi Setiap Saat</option>
                        <option value="Dikecualikan">Informasi Dikecualikan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tahun</label>
                    <input type="number" id="infoYear" class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="2024">
                </div>

                <div class="border-t pt-4 mt-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Upload File (PDF)</label>
                    <input type="file" id="infoFileInput" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer">

                    <div id="currentFileSection" class="mt-3 text-sm bg-gray-50 p-3 rounded-lg border border-gray-200 hidden flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-file-pdf text-red-500 text-xl"></i>
                            <span class="text-gray-600 font-medium">File Terupload</span>
                        </div>
                        <a id="currentFileLink" href="#" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-bold bg-blue-50 px-3 py-1 rounded border border-blue-100">
                            Lihat / Download
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                <button onclick="closeInfoModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition">Batal</button>
                <button onclick="applyInfoChange()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold shadow-md transition transform active:scale-95">Simpan Perubahan</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- GLOBAL VARIABLES ---
    if (typeof pendingInfoFiles === 'undefined') var pendingInfoFiles = {};
    if (typeof pendingChanges === 'undefined') var pendingChanges = {};

    // --- LOGIC UTAMA ---
    let infoData = [];
    try {
        let raw = document.getElementById('json_information_list').value;
        if(raw && raw !== '[]') infoData = JSON.parse(raw);
    } catch(e) { console.error(e); }

    renderInfoTable();

    function renderInfoTable() {
        const tbody = document.getElementById('infoTableBody');
        tbody.innerHTML = '';

        if (infoData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50">Belum ada dokumen. Klik "Tambah Dokumen" untuk mulai.</td></tr>`;
            return;
        }

        infoData.forEach((item, index) => {
            // Logika Status File untuk Tabel
            let fileHtml = '<span class="text-gray-400 italic text-xs">Belum ada file</span>';

            // 1. Cek Pending (File Baru dipilih tapi belum save global)
            if(pendingInfoFiles[index]) {
                fileHtml = '<span class="text-green-600 font-bold text-xs flex items-center gap-1 bg-green-50 px-2 py-1 rounded border border-green-100"><i class="ph ph-check-circle"></i> Siap Upload</span>';
            }
            // 2. Cek Database (File Lama)
            else if (item.file_url) {
                fileHtml = `<a href="${item.file_url}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-xs flex items-center gap-1 bg-blue-50 px-2 py-1 rounded border border-blue-100 w-fit">
                                <i class="ph ph-eye"></i> Lihat File
                            </a>`;
            }

            // Warna Badge Kategori
            let badgeColor = 'bg-gray-100 text-gray-600';
            if(item.category === 'Berkala') badgeColor = 'bg-blue-100 text-blue-700';
            if(item.category === 'Serta Merta') badgeColor = 'bg-orange-100 text-orange-700';
            if(item.category === 'Setiap Saat') badgeColor = 'bg-green-100 text-green-700';

            let row = `
                <tr class="hover:bg-gray-50 transition border-b border-gray-100 group">
                    <td class="px-6 py-4 font-medium text-gray-800">${item.title}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold ${badgeColor}">${item.category}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${item.year}</td>

                    <td class="px-6 py-4">
                        ${fileHtml}
                    </td>

                    <td class="px-6 py-4 text-center flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="editInfo(${index})" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition" title="Edit"><i class="ph ph-pencil-simple text-xl"></i></button>
                        <button onclick="deleteInfo(${index})" class="p-2 text-red-600 hover:bg-red-100 rounded transition" title="Hapus"><i class="ph ph-trash text-xl"></i></button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // --- ADD ---
    function addInfoItem() {
        // Tambah item kosong ke array
        infoData.unshift({ title: 'Dokumen Baru', category: 'Berkala', year: new Date().getFullYear(), file_url: '' });
        renderInfoTable();
        saveInfoToPending();
        // Langsung buka modal edit untuk item yang baru dibuat (index 0)
        editInfo(0);
    }

    // --- EDIT (Buka Modal) ---
    function editInfo(index) {
        let item = infoData[index];
        document.getElementById('infoIndex').value = index;
        document.getElementById('infoTitle').value = item.title;
        document.getElementById('infoCategory').value = item.category;
        document.getElementById('infoYear').value = item.year;

        // Reset Input File
        document.getElementById('infoFileInput').value = '';

        // Logic Tampilkan Link File Lama
        let fileSection = document.getElementById('currentFileSection');
        let fileLink = document.getElementById('currentFileLink');

        if (item.file_url) {
            fileLink.href = item.file_url;
            fileSection.classList.remove('hidden');
            fileSection.classList.add('flex');
        } else {
            fileSection.classList.add('hidden');
            fileSection.classList.remove('flex');
        }

        document.getElementById('infoEditorModal').classList.remove('hidden');
        document.getElementById('infoEditorModal').classList.add('flex');
    }

    function closeInfoModal() {
        document.getElementById('infoEditorModal').classList.add('hidden');
        document.getElementById('infoEditorModal').classList.remove('flex');
    }

    // --- APPLY ---
    function applyInfoChange() {
        let index = document.getElementById('infoIndex').value;

        // Update Data Teks
        infoData[index].title = document.getElementById('infoTitle').value;
        infoData[index].category = document.getElementById('infoCategory').value;
        infoData[index].year = document.getElementById('infoYear').value;

        // Cek File Baru
        let fileInput = document.getElementById('infoFileInput');
        if(fileInput.files.length > 0) {
            pendingInfoFiles[index] = fileInput.files[0];
        }

        renderInfoTable();
        saveInfoToPending();
        closeInfoModal();
    }

    // --- DELETE ---
    function deleteInfo(index) {
        if(confirm('Hapus dokumen ini?')) {
            infoData.splice(index, 1);
            delete pendingInfoFiles[index];
            renderInfoTable();
            saveInfoToPending();
        }
    }

    // --- SAVE TO PENDING ---
    function saveInfoToPending() {
        pendingChanges['information_list'] = JSON.stringify(infoData);
        // Trigger update tombol save global
        if(typeof updateSaveButtonState === 'function') {
            updateSaveButtonState();
        } else {
            const btn = document.getElementById('btnSaveGlobal');
            if(btn) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btn.innerHTML = '<i class="ph ph-floppy-disk"></i> Simpan Perubahan';
            }
        }
    }

  // --- GLOBAL SAVE OVERRIDE ---
  const btnSaveLocal = document.getElementById('btnSaveGlobal');
    if(btnSaveLocal) {
        // Clone button untuk reset event listener
        let newBtn = btnSaveLocal.cloneNode(true);
        btnSaveLocal.parentNode.replaceChild(newBtn, btnSaveLocal);

        newBtn.addEventListener('click', function() {
             let slug = document.getElementById('pageSlug').value;
             let originalText = newBtn.innerHTML;
             newBtn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Menyimpan...';
             newBtn.disabled = true;

             let formData = new FormData();
             formData.append('page_slug', slug);

             // 1. Kirim Text (Judul, Kategori, Tahun)
             for (let key in pendingChanges) {
                 formData.append(`changes[${key}]`, pendingChanges[key]);
             }

             // 2. KIRIM FILE PDF (WAJIB ADA)
             for (let index in pendingInfoFiles) {
                 // Key ini ('info_file_X') harus sama dengan yang ditangkap Controller
                 formData.append(`info_file_${index}`, pendingInfoFiles[index]);
             }

             fetch("{{ route('redaktur.page.update_batch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil! File dan Data tersimpan.');
                    window.location.reload();
                } else {
                    alert('Gagal: ' + data.message);
                    newBtn.disabled = false;
                    newBtn.innerHTML = originalText;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error server (Cek Console).');
                newBtn.disabled = false;
                newBtn.innerHTML = originalText;
            });
        });
    }
</script>
@endpush
