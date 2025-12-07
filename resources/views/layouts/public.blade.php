<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kominfo Jatim')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="https://ppid-demo.jatimprov.go.id/images/logo_provinsi_jawa_timur.png">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    @include('partials.public_header')

    <main class="{{ Request::is('/') ? '' : 'pt-20' }}">
        @yield('content')
        <section class="w-full h-30 bg-bottom bg-cover" 
         style="background-image: url('https://ppid-demo.jatimprov.go.id/assets/images/building.png')">
    </section>
    </main>
    
    <footer class="bg-gray-900 text-gray-300 py-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- Logo + Sosial Media -->
        <div>
            <img src="https://ppid-demo.jatimprov.go.id/images/logo-ppid-dark.png" 
                 alt="Logo" 
                 class="h-12 mb-4">

            <div class="flex space-x-4 mt-4">
                <a href="#" class="w-9 h-9 flex items-center justify-center bg-gray-800 rounded-full hover:bg-blue-600 transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-9 h-9 flex items-center justify-center bg-gray-800 rounded-full hover:bg-red-600 transition">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="w-9 h-9 flex items-center justify-center bg-gray-800 rounded-full hover:bg-pink-600 transition">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-9 h-9 flex items-center justify-center bg-gray-800 rounded-full hover:bg-blue-400 transition">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>

        <!-- Kontak -->
        <div>
            <h6 class="text-white font-semibold mb-4">Hubungi Kami</h6>

            <p class="mb-2 flex items-start">
                <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                Jl. A Yani No 242-244 Surabaya
            </p>

            <p class="mb-2 flex items-center">
                <i class="fas fa-envelope mr-2"></i>
                <a href="mailto:bkd@jatimprov.go.id" class="hover:text-white">bkd@jatimprov.go.id</a>
            </p>

            <p class="flex items-center">
                <i class="fas fa-phone mr-2"></i>
                <a href="tel:0318477551" class="hover:text-white">031 8477551</a>
            </p>
        </div>

        <!-- Link Terkait -->
        <div>
            <h6 class="text-white font-semibold mb-4">Link Terkait</h6>
            <ul class="space-y-2">
                <li>
                    <a href="https://jatimprov.go.id" class="hover:text-white">Pemerintah Provinsi Jawa Timur</a>
                </li>
                <li>
                    <a href="https://kominfo.jatimprov.go.id" class="hover:text-white">Dinas Komunikasi dan Informatika Provinsi Jawa Timur</a>
                </li>
                <li>
                    <a href="https://www.lapor.go.id/" class="hover:text-white">SP4N LAPOR</a>
                </li>
            </ul>
        </div>

    </div>

    <!-- Copyright -->
    <div class="mt-10 border-t border-gray-700 pt-4 text-center text-sm text-gray-500">
        © <script>document.write(new Date().getFullYear())</script> PPID Pemerintah Provinsi Jawa Timur
    </div>
</footer>


    @stack('scripts')
</body>
</html>