<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VCMS Redaktur - Jatim</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="https://ppid-demo.jatimprov.go.id/images/logo_provinsi_jawa_timur.png">
    
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        @include('redaktur.partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            @include('redaktur.partials.topbar')

            <main class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>