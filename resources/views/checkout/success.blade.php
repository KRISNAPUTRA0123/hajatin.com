<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil - Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <main class="min-h-screen flex items-center justify-center px-6">
        <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center">
            <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto text-3xl">
                ✓
            </div>

            <h1 class="text-2xl font-bold mt-6">
                Pembayaran Berhasil
            </h1>

            <p class="text-gray-600 mt-3">
                Template {{ $transaction->template->name }} berhasil dibeli.
            </p>

            @if ($transaction->invitation)
                <a href="{{ route('editor.edit', $transaction->invitation) }}"
                   class="block mt-6 bg-purple-600 text-white py-3 rounded-xl">
                    Edit Undangan
                </a>
            @endif

            <a href="{{ route('dashboard') }}"
               class="block mt-3 bg-white border py-3 rounded-xl">
                Ke Dashboard
            </a>
        </div>
    </main>
</body>
</html>
