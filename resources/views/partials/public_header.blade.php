@php
    // 1. Cek Route
    $isHome = Request::is('/');

    // 2. Setup Kelas CSS Awal
    // Home: Fixed + Transparan
    // Halaman Lain: Fixed + Gray-900 (Gelap) + Shadow
    $headerClass = $isHome ? 'bg-transparent fixed' : 'bg-gray-900 shadow-md fixed';

    // 3. Setup Text Color (Konsisten Putih/Abu Terang karena background selalu gelap)
    $textClass   = 'text-white';
    $linkClass   = 'text-gray-300 hover:text-white transition duration-300';
    $activeClass = 'text-white font-bold underline decoration-blue-500 decoration-2 underline-offset-4';

    // 4. Logo
    // Pastikan menggunakan Logo versi Putih/Terang agar terlihat di background gelap
    $logoSrc = 'https://ppid-demo.jatimprov.go.id/images/logo-ppid-dark.png';
    // Jika tidak punya logo putih, gunakan yang ada:
    // $logoSrc = 'https://ppid-demo.jatimprov.go.id/images/logo-ppid-light.png';
@endphp

<header id="mainHeader" class="top-0 left-0 w-full z-50 transition-all duration-300 {{ $headerClass }} {{ $textClass }}">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}">
                <img src="{{ $logoSrc }}" class="h-10 w-auto" alt="Logo PPID">
            </a>
        </div>

        <nav class="hidden md:flex space-x-8 text-sm font-medium">
            <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? $activeClass : $linkClass }}">Beranda</a>
            <a href="#" class="{{ $linkClass }}">Profil</a>
            <a href="{{ route('regulasi') }}" class="{{ $linkClass }}">Regulasi</a>
            <a href="{{ route('dokumen') }}" class="{{ $linkClass }}">Dokumen</a>
            <a href="#" class="{{ $linkClass }}">Daftar Informasi</a>
            <a href="{{ route('publikasi.index') }}" class="{{ Request::routeIs('publikasi.*') ? $activeClass : $linkClass }}">Publikasi</a>
            <a href="https://opendata.jatimprov.go.id/" class="{{ $linkClass }}">Data Publik</a>
        </nav>

        <button class="md:hidden flex items-center text-white focus:outline-none"
                onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <i class="fas fa-bars text-2xl"></i>
        </button>

    </div>

    <div id="mobileMenu" class="md:hidden hidden bg-gray-900 border-t border-gray-700 text-white shadow-lg">
        <nav class="px-6 py-4 flex flex-col space-y-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-400">Beranda</a>
            <a href="#" class="hover:text-blue-400">Profil</a>
            <a href="#" class="hover:text-blue-400">Regulasi</a>
            <a href="{{ route('publikasi.index') }}" class="hover:text-blue-400">Publikasi</a>
        </nav>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('mainHeader');
        // Ambil status halaman dari PHP
        const isHomePage = @json($isHome);

        // Logic Scroll HANYA jalan di Home
        if (isHomePage) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    // Saat Scroll ke Bawah: Tambah Background Gelap
                    header.classList.remove('bg-transparent');
                    header.classList.add('bg-gray-900', 'shadow-md');
                } else {
                    // Saat di Posisi Atas: Kembalikan Transparan
                    header.classList.add('bg-transparent');
                    header.classList.remove('bg-gray-900', 'shadow-md');
                }
            });
        }
    });
</script>
@endpush
