<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="{{ url('/') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="uk-navbar">
        <div class="uk-container py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-bold">
                    H
                </div>

                <div>
                    <div class="text-xl font-extrabold text-slate-900">
                        Hajatin
                    </div>
                    <div class="text-xs text-slate-500 -mt-1">
                        Digital Invitation Platform
                    </div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-purple-600">Beranda</a>
                <a href="{{ route('templates.index') }}" class="hover:text-purple-600">Template</a>
                <a href="#" class="hover:text-purple-600">Bantuan</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth


                    <div class="relative" id="user-menu-wrap">
                        <button type="button"
                            id="user-menu-button"
                            class="w-11 h-11 rounded-full overflow-hidden border-2 border-purple-100 bg-white shadow-sm flex items-center justify-center hover:border-purple-300 transition"
                            aria-label="Menu akun">

                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}"
                                    alt="{{ Auth::user()->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="w-full h-full flex items-center justify-center bg-purple-600 text-white font-extrabold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>
                            @endif
                        </button>

                        <div id="user-menu-dropdown"
                            class="hidden absolute right-0 mt-3 w-72 rounded-3xl bg-white border border-slate-100 shadow-2xl p-4 z-[9999]">

                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-purple-100 flex items-center justify-center shrink-0">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}"
                                            alt="{{ Auth::user()->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <span class="text-purple-700 font-extrabold text-lg">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <p class="font-extrabold text-slate-900 truncate">
                                        {{ Auth::user()->name ?? 'Pengguna' }}
                                    </p>

                                    <p class="text-xs text-slate-500 truncate">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="pt-4 grid gap-2">
                                <a href="{{ route('dashboard') }}"
                                    class="w-full text-left px-4 py-3 rounded-2xl bg-slate-50 hover:bg-purple-50 text-slate-700 hover:text-purple-700 font-bold transition">
                                    Dashboard
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 rounded-2xl bg-red-50 hover:bg-red-100 text-red-600 font-bold transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <button type="button"
                        data-firebase-google-login
                        data-redirect-after-login="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 font-bold text-slate-700 shadow-sm transition hover:border-purple-200 hover:bg-purple-50 hover:text-purple-700">

                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white">
                            <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20c10 0 19-7.3 19-20 0-1.3-.1-2.4-.4-3.5z"/>
                                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                                <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.3 35.1 26.8 36 24 36c-5.3 0-9.7-3.3-11.3-7.9l-6.5 5C9.5 39.5 16.2 44 24 44z"/>
                                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.1 5.5l6.3 5.3C36.9 39.3 43 34.8 43 24c0-1.3-.1-2.4-.4-3.5z"/>
                            </svg>
                        </span>

                        <span class="hidden sm:inline">Masuk dengan Google</span>

                    </button>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">
                    Undangan Saya
                </h1>
                <p class="text-gray-600 mt-2">
                    Kelola semua undangan digital yang sudah kamu beli.
                </p>
            </div>

            <a href="{{ route('templates.index') }}"
               class="bg-purple-600 text-white px-5 py-3 rounded-xl">
                Cari Template
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-8">
            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Total Undangan</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalInvitations }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Total Ucapan</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalMessages }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Tamu Hadir</p>
                <h2 class="text-3xl font-bold mt-2 text-green-600">
                    {{ $totalAttend }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Tidak Hadir</p>
                <h2 class="text-3xl font-bold mt-2 text-red-600">
                    {{ $totalNotAttend }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Ragu</p>
                <h2 class="text-3xl font-bold mt-2 text-yellow-600">
                    {{ $totalMaybe }}
                </h2>
            </div>
        </div>

        <div id="undangan" class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            @forelse ($invitations as $invitation)
                <div class="bg-white rounded-2xl shadow p-5">
                    <div class="h-40 rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 overflow-hidden relative">
                        <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                            <div>
                                <p class="text-sm font-bold text-purple-600">
                                    Preview Undangan
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Akan dimuat saat terlihat
                                </p>
                            </div>
                        </div>
                        <iframe
                            data-src="{{ route('editor.preview', $invitation) }}"
                            class="dashboard-preview-iframe absolute top-0 left-0 border-0 pointer-events-none"
                            style="
                                width: 360%;
                                height: 640px;
                                transform: scale(.28);
                                transform-origin: top left;
                            "
                            loading="lazy"
                            title="Preview {{ $invitation->title }}">
                        </iframe>
                    </div>

                    <h2 class="text-xl font-bold mt-4">
                        {{ $invitation->title }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Template: {{ $invitation->template->name }}
                    </p>

                    <div class="grid grid-cols-3 gap-2 mt-4 text-center text-xs">
                        <div class="bg-gray-50 rounded-xl p-2">
                            <p class="font-bold">
                                {{ $invitation->messages_count ?? 0 }}
                            </p>
                            <p class="text-gray-500">Ucapan</p>
                        </div>

                        <div class="bg-green-50 rounded-xl p-2">
                            <p class="font-bold text-green-700">
                                {{ $invitation->attend_guest_total ?? 0 }}
                            </p>
                            <p class="text-gray-500">Hadir</p>
                        </div>

                        <div class="bg-yellow-50 rounded-xl p-2">
                            <p class="font-bold text-yellow-700">
                                {{ $invitation->maybe_messages_count ?? 0 }}
                            </p>
                            <p class="text-gray-500">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <span class="text-xs px-3 py-1 rounded-full
                            @if ($invitation->status === 'draft')
                                bg-yellow-100 text-yellow-700
                            @elseif ($invitation->status === 'active')
                                bg-green-100 text-green-700
                            @else
                                bg-gray-100 text-gray-700
                            @endif
                        ">
                            {{ strtoupper($invitation->status) }}
                        </span>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <a href="{{ route('editor.edit', $invitation) }}"
                        class="text-center bg-purple-600 text-white py-2 rounded-xl">
                            Edit
                        </a>

                        <a href="{{ route('invitation.public', $invitation->slug) }}"
                        target="_blank"
                        class="text-center bg-white border py-2 rounded-xl">
                            Preview
                        </a>

                        <a href="{{ route('dashboard.messages', $invitation) }}"
                        class="text-center bg-white border py-2 rounded-xl">
                            Ucapan
                        </a>

                        <a href="https://wa.me/?text={{ urlencode('Ini link undangan saya: ' . route('invitation.public', $invitation->slug)) }}"
                        target="_blank"
                        class="text-center bg-green-600 text-white py-2 rounded-xl">
                            Bagikan
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-2xl shadow p-8 text-center">
                    <h2 class="text-xl font-bold">Belum ada undangan</h2>
                    <p class="text-gray-600 mt-2">
                        Pilih template dulu untuk mulai membuat undangan digital.
                    </p>

                    <a href="{{ route('templates.index') }}"
                       class="inline-block mt-5 bg-purple-600 text-white px-5 py-3 rounded-xl">
                        Lihat Template
                    </a>
                </div>
            @endforelse
        </div>

        @if ($invitations->hasPages())
            <div class="mt-10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        <span class="font-bold text-slate-800">{{ $invitations->firstItem() }}</span>
                        sampai
                        <span class="font-bold text-slate-800">{{ $invitations->lastItem() }}</span>
                        dari
                        <span class="font-bold text-purple-600">{{ $invitations->total() }}</span>
                        undangan
                    </p>

                    <div class="inline-flex flex-wrap items-center justify-center gap-2 bg-white/90 border border-purple-100 rounded-2xl p-2 shadow-sm">
                        {{-- Previous --}}
                        @if ($invitations->onFirstPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $invitations->previousPageUrl() }}#undangan"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-purple-100 hover:bg-purple-50 hover:text-purple-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        {{-- Nomor halaman --}}
                        @foreach ($invitations->getUrlRange(1, $invitations->lastPage()) as $page => $url)
                            @if ($page == $invitations->currentPage())
                                <span class="min-w-[40px] h-10 px-3 flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold shadow-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}#undangan"
                                class="min-w-[40px] h-10 px-3 flex items-center justify-center rounded-xl bg-white text-slate-700 border border-purple-100 hover:bg-purple-50 hover:text-purple-600 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($invitations->hasMorePages())
                            <a href="{{ $invitations->nextPageUrl() }}#undangan"
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-purple-100 hover:bg-purple-50 hover:text-purple-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow p-6 mt-10">
            <h2 class="text-xl font-bold mb-5">
                Transaksi Terbaru
            </h2>

            <div class="space-y-3">
                @forelse ($transactions as $transaction)
                    <div class="flex items-center justify-between border rounded-2xl p-4">
                        <div>
                            <p class="font-bold">
                                {{ $transaction->template->name }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $transaction->invoice_number }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-bold text-purple-600">
                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>

                            <p class="text-xs uppercase
                                @if ($transaction->status === 'paid')
                                    text-green-600
                                @else
                                    text-yellow-600
                                @endif
                            ">
                                {{ $transaction->status }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">
                        Belum ada transaksi.
                    </p>
                @endforelse
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const previewIframes = document.querySelectorAll('.dashboard-preview-iframe[data-src]');

            if (!previewIframes.length) {
                return;
            }

            const iframeObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const iframe = entry.target;

                    if (!iframe.src) {
                        iframe.src = iframe.dataset.src;
                    }

                    iframeObserver.unobserve(iframe);
                });
            }, {
                rootMargin: '250px 0px',
                threshold: 0.01
            });

            previewIframes.forEach(function (iframe) {
                iframeObserver.observe(iframe);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const userMenuWrap = document.getElementById('user-menu-wrap');

            if (!userMenuButton || !userMenuDropdown || !userMenuWrap) {
                return;
            }

            userMenuButton.addEventListener('click', function (event) {
                event.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!userMenuWrap.contains(event.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    userMenuDropdown.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
