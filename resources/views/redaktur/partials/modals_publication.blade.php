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

{{-- Modal Edit Agenda/Gallery --}}
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

        <div class="px-6 py-6 space-y-4">
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