@extends('layouts.public')

@section('title', 'Publikasi & Agenda - Kominfo Jatim')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-12">

    {{-- HEADER --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Pusat Informasi</h1>

        <div class="flex justify-center gap-4 mt-8 flex-wrap">
            <button
    onclick="filterSelection('Berita')"
    data-category="Berita"
    class="filter-btn px-6 py-2 rounded-full border bg-blue-600 text-white font-medium transition">
    Kabar Berita
</button>

<button
    onclick="filterSelection('Agenda')"
    data-category="Agenda"
    class="filter-btn px-6 py-2 rounded-full border bg-white text-gray-600 font-medium transition">
    Agenda Kegiatan
</button>

        </div>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($publications as $item)
            <div
                class="filter-item group bg-white rounded-xl border border-gray-100
                       shadow-sm hover:shadow-xl transition-all duration-300
                       overflow-hidden h-[450px] flex flex-col"
                data-category="{{ $item['type'] }}"
            >

                {{-- IMAGE --}}
                <div class="h-[220px] overflow-hidden relative">
                    <img
                        src="{{ $item['image'] ?? 'https://placehold.co/600x400' }}"
                        alt="{{ $item['title'] }}"
                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                    >

                    <span
                        class="absolute top-4 left-4 {{ $item['badge_color'] }}
                               text-white text-xs font-bold px-3 py-1 rounded-full
                               shadow-md uppercase tracking-wider"
                    >
                        {{ $item['type'] }}
                    </span>
                </div>

                {{-- CONTENT --}}
                <div class="p-6 flex flex-col flex-1">

                    <div class="text-xs text-gray-400 font-semibold mb-2">
                        {{ $item['date'] }}
                    </div>

                    <h3 class="text-xl font-bold mb-3 line-clamp-2">
                        @if($item['type'] === 'Berita')
                            <a
                                href="{{ route('publikasi.berita.show', $item['slug']) }}"
                                class="hover:text-blue-600 transition"
                            >
                                {{ $item['title'] }}
                            </a>
                        @else
                            <a
                                href="{{ route('publikasi.agenda.show', $item['slug']) }}"
                                class="hover:text-purple-600 transition"
                            >
                                {{ $item['title'] }}
                            </a>
                        @endif
                    </h3>

                    <p class="text-gray-500 text-sm line-clamp-3">
                        {{ strip_tags($item['desc']) }}
                    </p>

                    {{-- FOOTER --}}
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        @if($item['type'] === 'Berita')
                            <a
                                href="{{ route('publikasi.berita.show', $item['slug']) }}"
                                class="text-blue-600 font-semibold text-sm
                                       flex items-center gap-2
                                       group-hover:gap-3 transition-all"
                            >
                                Baca Detail →
                            </a>
                        @else
                            <a
                                href="{{ route('publikasi.agenda.show', $item['slug']) }}"
                                class="text-purple-600 font-semibold text-sm
                                       flex items-center gap-2
                                       group-hover:gap-3 transition-all"
                            >
                                Lihat Agenda →
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- PAGINATION --}}
    <div class="mt-12 flex justify-center">
        {{ $publications->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script>
function filterSelection(category) {
    const items = document.querySelectorAll('.filter-item');
    const buttons = document.querySelectorAll('.filter-btn');

    // filter card
    items.forEach(item => {
        item.style.display =
            item.dataset.category === category ? 'flex' : 'none';
    });

    // reset button
    buttons.forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-white', 'text-gray-600');

        if (btn.dataset.category === category) {
            btn.classList.remove('bg-white', 'text-gray-600');
            btn.classList.add('bg-blue-600', 'text-white');
        }
    });
}


// default tampil Berita
document.addEventListener('DOMContentLoaded', () => {
    filterSelection('Berita');
});
</script>
@endpush
