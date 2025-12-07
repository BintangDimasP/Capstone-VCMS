@extends('layouts.public')

@section('title', 'Dokumen Publik - Kominfo Jatim')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {!! cms($page->id, 'doc_title', 'Dokumen & Laporan') !!}
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto">
                {!! cms($page->id, 'doc_desc', 'Transparansi informasi publik melalui dokumen yang dapat diakses masyarakat.') !!}
            </p>
        </div>

        <div class="mb-12 relative max-w-xl mx-auto">
            <input type="text" id="searchDoc" onkeyup="searchDocument()" placeholder="Cari nama dokumen..." class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition shadow-sm outline-none">
            <i class="ph ph-magnifying-glass absolute left-5 top-3.5 text-lg text-gray-400"></i>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="publicDocList">
            @forelse($documents as $item)
                <div class="doc-item bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-indigo-200 transition flex flex-col items-center text-center h-full group">

                    <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-sm border border-indigo-100">
                        <i class="ph ph-files text-3xl"></i>
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg mb-2 leading-tight group-hover:text-indigo-700 transition">{{ $item['title'] }}</h3>
                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full font-medium mb-6">
                        {{ $item['meta'] }}
                    </span>

                    <div class="mt-auto w-full">
                        <a href="{{ $item['url'] ?? '#' }}" target="_blank" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-bold text-sm transition shadow-md shadow-indigo-200">
                            <i class="ph ph-download-simple mr-2"></i> Unduh File
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="ph ph-folder-open text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700">Belum ada dokumen</h3>
                    <p class="text-gray-500 text-sm">Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        function searchDocument() {
            let input = document.getElementById('searchDoc');
            let filter = input.value.toUpperCase();
            let container = document.getElementById("publicDocList");
            let items = container.getElementsByClassName('doc-item');

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
