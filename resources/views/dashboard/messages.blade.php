<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ucapan Tamu - Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
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
        <a href="{{ route('dashboard') }}" class="text-purple-600">
            ← Kembali ke Dashboard
        </a>

        <div class="mt-6 flex items-start justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold">
                    Ucapan Tamu
                </h1>

                <p class="text-gray-600 mt-2">
                    Rekap tamu untuk undangan:
                    <strong>{{ $invitation->title }}</strong>
                </p>
            </div>

            <a href="{{ route('invitation.public', $invitation->slug) }}"
               target="_blank"
               class="bg-purple-600 text-white px-5 py-3 rounded-xl">
                Lihat Undangan
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
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

        <div class="bg-white rounded-3xl shadow p-6 mt-8">
            <h2 class="text-xl font-bold mb-5">
                Daftar Ucapan
            </h2>

            <div class="space-y-4">
                @forelse ($invitation->messages as $message)
                    <div class="border rounded-2xl p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-bold">
                                    {{ $message->guest_name }}
                                </h3>

                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $message->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            @if ($message->attendance_status)
                                <span class="text-xs px-3 py-1 rounded-full
                                    @if ($message->attendance_status === 'hadir')
                                        bg-green-100 text-green-700
                                    @elseif ($message->attendance_status === 'tidak_hadir')
                                        bg-red-100 text-red-700
                                    @else
                                        bg-yellow-100 text-yellow-700
                                    @endif
                                ">
                                    @if ($message->attendance_status === 'hadir')
                                        Hadir
                                    @elseif ($message->attendance_status === 'tidak_hadir')
                                        Tidak Hadir
                                    @else
                                        Ragu
                                    @endif
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-700 mt-4">
                            {{ $message->message }}
                        </p>

                        @if ($message->attendance_status === 'hadir')
                            <p class="text-sm text-gray-500 mt-3">
                                Jumlah tamu: {{ $message->guest_count }} orang
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-2xl p-8 text-center">
                        <p class="text-gray-600">
                            Belum ada ucapan tamu.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
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
