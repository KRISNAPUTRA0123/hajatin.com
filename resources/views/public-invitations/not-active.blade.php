<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Undangan Belum Aktif</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <main class="min-h-screen flex items-center justify-center px-6">
        <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md text-center">
            <h1 class="text-2xl font-bold">Undangan Belum Aktif</h1>

            <p class="text-gray-600 mt-3">
                Undangan "{{ $invitation->title }}" belum dipublish oleh pemilik undangan.
            </p>

            <a href="{{ route('home') }}"
               class="inline-block mt-6 bg-purple-600 text-white px-5 py-3 rounded-xl">
                Kembali ke Beranda
            </a>
        </div>
    </main>
</body>
</html>
