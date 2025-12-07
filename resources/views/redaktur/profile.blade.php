@extends('redaktur.layout')

@section('title', 'Edit Profil Dinas')

@section('content')

    <input type="hidden" id="pageSlug" value="profil">
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
            <h2 class="text-2xl font-bold text-gray-800">Editor Halaman Profil</h2>
            <p class="text-gray-500">Edit Sambutan, Visi Misi, dan Struktur Organisasi.</p>
        </div>
    </div>

    <div class="bg-white shadow-xl min-h-screen rounded-xl overflow-hidden border border-gray-200">

        <div class="relative bg-gray-900 text-white py-24 text-center group">
             <div class="absolute inset-0 bg-cover bg-center opacity-30"
                  id="heroSectionPreview"
                  style="background-image: url('{{ cms($page->id, 'profile_hero_bg', 'https://ppid-demo.jatimprov.go.id/assets/images/building.png') }}');">
             </div>

             <div class="absolute top-5 right-5 z-20 hidden group-hover:block">
                 <button onclick="openImageEditor('profile_hero_bg')" class="bg-white text-gray-900 px-3 py-1 rounded shadow text-sm font-bold flex items-center gap-2">
                     <i class="ph ph-image"></i> Ganti Background
                 </button>
                 <input type="hidden" id="val_profile_hero_bg" value="{{ cms($page->id, 'profile_hero_bg', '') }}">
             </div>

             <div class="relative z-10 max-w-4xl mx-auto px-6">
                <div class="cms-editable inline-block mb-4" onclick="openEditor('profile_title')" id="wrapper_profile_title">
                    <h1 class="text-4xl font-bold">{!! cms($page->id, 'profile_title', 'Profil Dinas Kominfo') !!}</h1>
                </div>
                <br>
                <div class="cms-editable inline-block" onclick="openEditor('profile_desc')" id="wrapper_profile_desc">
                    <p class="text-xl text-gray-300">{!! cms($page->id, 'profile_desc', 'Mengenal lebih dekat visi dan misi kami.') !!}</p>
                </div>
             </div>
        </div>

        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/3 relative group/kadis">
                    <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[3/4] bg-gray-200 relative">
                        <img src="{{ cms($page->id, 'kadis_image', 'https://placehold.co/400x500?text=Foto+Kadis') }}"
                             id="img_kadis_image" class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-black/50 hidden group-hover/kadis:flex items-center justify-center">
                             <button onclick="openImageEditor('kadis_image')" class="bg-white px-4 py-2 rounded-full font-bold text-sm shadow">
                                <i class="ph ph-camera"></i> Ganti Foto
                             </button>
                        </div>
                        <input type="hidden" id="val_kadis_image" value="{{ cms($page->id, 'kadis_image', '') }}">
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="cms-editable inline-block mb-2" onclick="openEditor('kadis_name')" id="wrapper_kadis_name">
                        <h2 class="text-3xl font-bold text-gray-900">{!! cms($page->id, 'kadis_name', 'Nama Kepala Dinas') !!}</h2>
                    </div>
                    <br>
                    <div class="cms-editable inline-block mb-6" onclick="openEditor('kadis_jabatan')" id="wrapper_kadis_jabatan">
                        <p class="text-blue-600 font-semibold">{!! cms($page->id, 'kadis_jabatan', 'Kepala Dinas Komunikasi dan Informatika') !!}</p>
                    </div>

                    <div class="cms-editable block p-4 border border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition" onclick="openEditor('kadis_quote')" id="wrapper_kadis_quote">
                        <div class="prose text-gray-600 italic">
                            {!! cms($page->id, 'kadis_quote', '"Selamat datang di portal resmi kami. Kami berkomitmen untuk memberikan pelayanan informasi terbaik bagi masyarakat Jawa Timur."') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 py-16">
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Visi</h3>
                    <div class="cms-editable block" onclick="openEditor('visi_text')" id="wrapper_visi_text">
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                            {!! cms($page->id, 'visi_text', 'Tuliskan Visi Dinas di sini...') !!}
                        </p>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Misi</h3>
                    <div class="cms-editable block" onclick="openEditor('misi_text')" id="wrapper_misi_text">
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                            {!! cms($page->id, 'misi_text', '1. Tuliskan Misi 1\n2. Tuliskan Misi 2\n3. Tuliskan Misi 3') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-16 text-center max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Struktur Organisasi</h2>

            <div class="relative group/struktur border-2 border-dashed border-gray-300 rounded-xl p-2 hover:border-blue-500 transition">
                <img src="{{ cms($page->id, 'struktur_image', 'https://placehold.co/1200x600?text=Bagan+Struktur') }}"
                     id="img_struktur_image" class="w-full h-auto rounded-lg shadow-lg">

                <div class="absolute inset-0 bg-black/50 hidden group-hover/struktur:flex items-center justify-center rounded-lg">
                    <button onclick="openImageEditor('struktur_image')" class="bg-white px-6 py-3 rounded-full font-bold shadow-lg flex items-center gap-2 hover:bg-gray-100">
                        <i class="ph ph-upload-simple"></i> Upload Bagan Struktur
                    </button>
                </div>
                <input type="hidden" id="val_struktur_image" value="{{ cms($page->id, 'struktur_image', '') }}">
            </div>
        </div>

    </div>

    <div id="editorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
            <h3 class="font-bold text-lg mb-4">Edit Teks</h3>
            <input type="hidden" id="inputKey">
            <textarea id="inputContent" rows="6" class="w-full border p-3 rounded-lg"></textarea>
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="closeModal()" class="px-4 py-2 text-gray-600">Batal</button>
                <button onclick="applyChangeLocal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </div>
    </div>

    <div id="imageEditorModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-[1000]">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
            <h3 class="font-bold text-lg mb-4">Ganti Gambar</h3>
            <input type="hidden" id="imageKey">
            <input type="file" id="imageInputFile" accept="image/*" class="w-full border p-2 rounded mb-4">
            <div id="imagePreviewBox" class="w-full h-48 bg-gray-100 bg-cover bg-center rounded mb-4"></div>
            <div class="flex justify-end gap-2">
                <button onclick="closeImageModal()" class="px-4 py-2 text-gray-600">Batal</button>
                <button onclick="applyImageChangeLocal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Terapkan</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- COPY PASTE SCRIPT GLOBAL DARI DASHBOARD ---
    // (Script yang variabel globalnya di paling atas tadi)
    // Cukup ambil bagian Variable Global, Text Editor, Image Editor, dan Save Button
    // Tidak perlu Logic News/Services/Gallery karena halaman ini tidak pakai itu.

    let pendingChanges = {};
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

    // --- TEXT EDITOR ---
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
        // Cek elemen anak (h1, h2, p) atau wrapper langsung
        if(wrapper.querySelector('h1')) wrapper.querySelector('h1').innerText = content;
        else if(wrapper.querySelector('h2')) wrapper.querySelector('h2').innerText = content;
        else if(wrapper.querySelector('p')) wrapper.querySelector('p').innerText = content;
        else if(wrapper.querySelector('.prose')) wrapper.querySelector('.prose').innerText = content;
        else wrapper.innerText = content;

        updateSaveButtonState();
        closeModal();
    }

    // --- IMAGE EDITOR ---
    function openImageEditor(key) {
        document.getElementById('imageKey').value = key;
        document.getElementById('imageInputFile').value = '';
        let currentUrl = document.getElementById('val_' + key).value;
        document.getElementById('imagePreviewBox').style.backgroundImage = `url('${currentUrl}')`;
        document.getElementById('imageEditorModal').classList.remove('hidden');
        document.getElementById('imageEditorModal').classList.add('flex');
    }
    function closeImageModal() { document.getElementById('imageEditorModal').classList.add('hidden'); document.getElementById('imageEditorModal').classList.remove('flex'); }

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
            pendingChanges[key] = file; // Simpan file

            let reader = new FileReader();
            reader.onload = function(e) {
                // Update tampilan khusus (karena ada yang background, ada yang img src)
                if(key === 'profile_hero_bg') {
                    document.getElementById('heroSectionPreview').style.backgroundImage = `url('${e.target.result}')`;
                } else if(key === 'kadis_image') {
                    document.getElementById('img_kadis_image').src = e.target.result;
                } else if(key === 'struktur_image') {
                    document.getElementById('img_struktur_image').src = e.target.result;
                }
            }
            reader.readAsDataURL(file);
            updateSaveButtonState();
        }
        closeImageModal();
    }

    // --- SAVE GLOBAL ---
    if(btnSaveGlobal) {
        btnSaveGlobal.addEventListener('click', function() {
            let slug = document.getElementById('pageSlug').value; // value="profil"
            let formData = new FormData();
            formData.append('page_slug', slug);

            for (let key in pendingChanges) {
                formData.append(`changes[${key}]`, pendingChanges[key]);
            }

            fetch("{{ route('redaktur.page.update_batch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert('Berhasil! Profil diperbarui.');
                window.location.reload();
            });
        });
    }
</script>
@endpush
