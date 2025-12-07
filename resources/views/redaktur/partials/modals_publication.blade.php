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