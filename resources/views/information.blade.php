@extends('layouts.public')

@section('title', 'Daftar Informasi - Kominfo Jatim')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Daftar Informasi Publik</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Akses dan unduh dokumen informasi publik yang tersedia secara berkala, serta merta, dan setiap saat.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button onclick="filterTable('all')" class="filter-btn active px-4 py-2 rounded-full bg-blue-600 text-white font-medium shadow transition">Semua</button>
            <button onclick="filterTable('Berkala')" class="filter-btn px-4 py-2 rounded-full bg-white border text-gray-600 hover:bg-gray-100 transition">Berkala</button>
            <button onclick="filterTable('Serta Merta')" class="filter-btn px-4 py-2 rounded-full bg-white border text-gray-600 hover:bg-gray-100 transition">Serta Merta</button>
            <button onclick="filterTable('Setiap Saat')" class="filter-btn px-4 py-2 rounded-full bg-white border text-gray-600 hover:bg-gray-100 transition">Setiap Saat</button>
        </div>

        @php
            $infoJson = cms($page->id, 'information_list', '[]');
            $infoData = json_decode($infoJson, true);
            if(!$infoData) $infoData = [];
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4 text-center">Unduh</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($infoData as $item)
                        <tr class="info-row hover:bg-blue-50 transition" data-category="{{ $item['category'] }}">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $item['title'] }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badge = 'bg-gray-100 text-gray-600';
                                    if($item['category'] == 'Berkala') $badge = 'bg-blue-100 text-blue-700';
                                    if($item['category'] == 'Serta Merta') $badge = 'bg-orange-100 text-orange-700';
                                    if($item['category'] == 'Setiap Saat') $badge = 'bg-green-100 text-green-700';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                    {{ $item['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $item['year'] }}</td>
                            <td class="px-6 py-4 text-center">
                                @if(!empty($item['file_url']))
                                    <a href="{{ $item['file_url'] }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                                        <i class="ph ph-download-simple"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if(count($infoData) == 0)
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data informasi.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function filterTable(category) {
            let rows = document.getElementsByClassName("info-row");
            let buttons = document.getElementsByClassName("filter-btn");

            // Logic Row
            for (let row of rows) {
                row.style.display = "";
                if (category !== 'all' && row.getAttribute('data-category') !== category) {
                    row.style.display = "none";
                }
            }

            // Logic Button Active State
            for (let btn of buttons) {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow');
                btn.classList.add('bg-white', 'text-gray-600', 'border');

                if(btn.innerText.includes(category === 'all' ? 'Semua' : category)) {
                    btn.classList.remove('bg-white', 'text-gray-600', 'border');
                    btn.classList.add('bg-blue-600', 'text-white', 'shadow');
                }
            }
        }
    </script>
@endsection
