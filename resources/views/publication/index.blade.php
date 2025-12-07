@extends('layouts.public')

@section('title', 'Publikasi & Agenda - Kominfo Jatim')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Pusat Informasi</h1>
            
            <div class="flex justify-center gap-4 mt-8 flex-wrap">
                <button onclick="filterSelection('all')" class="filter-btn active px-6 py-2 rounded-full border border-gray-300 bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-md">
                    Semua
                </button>
                <button onclick="filterSelection('Berita')" class="filter-btn px-6 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 transition font-medium">
                    Kabar Berita
                </button>
                <button onclick="filterSelection('Agenda')" class="filter-btn px-6 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 transition font-medium">
                    Agenda Kegiatan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($publications as $item)
                <div class="filter-item group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-[450px] flex flex-col" data-category="{{ $item['type'] }}">
                    
                    <div class="h-[220px] w-full bg-gray-200 overflow-hidden relative shrink-0">
                        <img src="{{ !empty($item['image']) ? $item['image'] : 'https://placehold.co/600x400' }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        
                        <div class="absolute top-4 left-4 {{ $item['badge_color'] ?? 'bg-gray-500' }} text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
    {{ $item['type'] ?? 'Umum' }}
</div>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <div class="text-xs text-gray-400 font-bold mb-2 uppercase tracking-wider">
                            {{ $item['date'] }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-[3.5rem] overflow-hidden leading-tight flex items-start">
                            <a href="{{ $item['url'] }}" class="hover:text-blue-600 line-clamp-2 transition">{{ $item['title'] }}</a>
                        </h3>
                        
                        <div class="text-gray-500 text-sm h-[4.5rem] overflow-hidden line-clamp-3 leading-relaxed">
                            {{ strip_tags($item['desc']) }}
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                            @if($item['type'] == 'Berita')
                                <a href="{{ $item['url'] }}" class="text-blue-600 font-semibold text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                                    Baca Detail <i class="ph ph-arrow-right"></i>
                                </a>
                            @else
                                <span class="text-gray-400 text-sm italic flex items-center gap-1">
                                    <i class="ph ph-image"></i> Lihat Foto
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $publications->links() }} 
        </div>

    </div>
    

@endsection

@push('scripts')
    <script>
        function filterSelection(category) {
            let items = document.getElementsByClassName("filter-item");
            
            // 1. Filter Item
            for (let i = 0; i < items.length; i++) {
                // Reset display
                items[i].style.display = ""; // Kembali ke default (flex/block)
                
                if (category !== 'all' && items[i].getAttribute('data-category') !== category) {
                    items[i].style.display = "none"; // Sembunyikan yang tidak cocok
                }
            }

            // 2. Update Warna Tombol (Opsional)
            // (Logic ini agar tombol yang diklik berubah warna jadi biru)
            let buttons = document.getElementsByClassName("filter-btn");
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('bg-blue-600', 'text-white');
                buttons[i].classList.add('bg-white', 'text-gray-600');
                
                // Cek teks di dalam tombol
                if (buttons[i].textContent.trim().includes(category === 'all' ? 'Semua' : (category === 'Berita' ? 'Kabar Berita' : 'Agenda'))) {
                     buttons[i].classList.remove('bg-white', 'text-gray-600');
                     buttons[i].classList.add('bg-blue-600', 'text-white');
                }
            }
        }
    </script>
@endpush