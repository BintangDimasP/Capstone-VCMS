@extends('layouts.public')

@section('title', 'Regulasi - Kominfo Jatim')

@section('content')

    <div class="max-w-4xl mx-auto px-6 py-12">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {!! cms($page->id, 'regulasi_title', 'Produk Hukum & Regulasi') !!}
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto">
                {!! cms($page->id, 'regulasi_desc', 'Daftar peraturan perundang-undangan yang berlaku di lingkungan Pemerintah Provinsi Jawa Timur.') !!}
            </p>
        </div>

        <div class="mb-8 relative">
            <input type="text" id="searchReg" onkeyup="searchRegulation()" placeholder="Cari dokumen..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
            <i class="ph ph-magnifying-glass absolute left-4 top-3.5 text-xl text-gray-400"></i>
        </div>

        <div class="space-y-4" id="publicRegList">
            @forelse($regulations as $item)
                <div class="reg-item bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                            <i class="ph ph-file-pdf text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg leading-tight mb-1">{{ $item['title'] }}</h3>
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded font-semibold">{{ $item['year'] }}</span>
                        </div>
                    </div>

                    <a href="{{ $item['url'] ?? '#' }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm flex items-center justify-center gap-2 transition shadow-lg shadow-blue-500/20">
                        <i class="ph ph-download-simple text-lg"></i> Download
                    </a>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <i class="ph ph-files text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada regulasi yang diunggah.</p>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        function searchRegulation() {
            let input = document.getElementById('searchReg');
            let filter = input.value.toUpperCase();
            let container = document.getElementById("publicRegList");
            let items = container.getElementsByClassName('reg-item');

            for (let i = 0; i < items.length; i++) {
                let h3 = items[i].getElementsByTagName("h3")[0];
                let txtValue = h3.textContent || h3.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }
    </script>

@endsection
