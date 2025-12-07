@extends('layouts.public')

@section('title', 'Profil Dinas - Kominfo Jatim')

@section('content')

    <div class="relative bg-gray-900 text-white py-24 text-center">
         <div class="absolute inset-0 bg-cover bg-center opacity-30"
              style="background-image: url('{{ cms($page->id, 'profile_hero_bg', 'https://ppid-demo.jatimprov.go.id/assets/images/building.png') }}');">
         </div>

         <div class="relative z-10 max-w-4xl mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                {!! cms($page->id, 'profile_title', 'Profil Dinas Kominfo') !!}
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {!! cms($page->id, 'profile_desc', 'Mengenal lebih dekat visi dan misi kami.') !!}
            </p>
         </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-20">
        <div class="flex flex-col md:flex-row items-center gap-12">

            <div class="w-full md:w-1/3">
                <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[3/4] bg-gray-200">
                    <img src="{{ cms($page->id, 'kadis_image', 'https://placehold.co/400x500?text=Foto+Kadis') }}"
                         class="w-full h-full object-cover hover:scale-105 transition duration-700">
                </div>
            </div>

            <div class="w-full md:w-2/3">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    {!! cms($page->id, 'kadis_name', 'Nama Kepala Dinas') !!}
                </h2>
                <p class="text-blue-600 font-semibold mb-6 text-lg">
                    {!! cms($page->id, 'kadis_jabatan', 'Kepala Dinas Komunikasi dan Informatika') !!}
                </p>

                <div class="p-6 border-l-4 border-blue-600 bg-gray-50 rounded-r-lg">
                    <div class="prose text-gray-600 italic text-lg leading-relaxed">
                        {!! cms($page->id, 'kadis_quote', '"Selamat datang di portal resmi kami..."') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-white p-10 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl">
                        <i class="ph ph-eye"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                </div>
                <div class="text-gray-600 leading-relaxed whitespace-pre-line text-lg">
                    {!! cms($page->id, 'visi_text', 'Tuliskan Visi Dinas di sini...') !!}
                </div>
            </div>

            <div class="bg-white p-10 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-2xl">
                        <i class="ph ph-target"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                </div>
                <div class="text-gray-600 leading-relaxed whitespace-pre-line text-lg">
                    {!! cms($page->id, 'misi_text', '1. Tuliskan Misi...') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 text-center max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Struktur Organisasi</h2>
        <div class="w-24 h-1 bg-blue-600 mx-auto mb-12 rounded-full"></div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-100">
            <img src="{{ cms($page->id, 'struktur_image', 'https://placehold.co/1200x600?text=Bagan+Struktur') }}"
                 class="w-full h-auto">
        </div>
    </div>

@endsection
