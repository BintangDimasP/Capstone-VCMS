<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CMS Kominfo Jatim</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="https://ppid-demo.jatimprov.go.id/images/logo_provinsi_jawa_timur.png">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Sistem</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded border border-red-200 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" 
                    required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" 
                    required>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>