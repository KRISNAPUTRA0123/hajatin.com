<x-guest-layout>
    <div class="relative overflow-hidden rounded-[32px] bg-white border border-purple-100 shadow-2xl shadow-purple-100/50 p-7 sm:p-8">
        <div class="absolute -top-20 -right-20 w-44 h-44 rounded-full bg-purple-200/40 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-44 h-44 rounded-full bg-pink-200/40 blur-3xl"></div>

        <div class="relative">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-purple-600 to-pink-500 text-white shadow-lg shadow-purple-200">
                <span class="text-2xl font-extrabold">U</span>
            </div>

            <div class="text-center mb-7">
                <p class="inline-flex items-center justify-center rounded-full bg-purple-50 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.18em] text-purple-700">
                    Login hajatin
                </p>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-950">
                    Masuk ke Akun Kamu
                </h1>

                <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-slate-500">
                    Gunakan akun Google untuk masuk ke dashboard, membeli template, dan mengelola undangan digital kamu.
                </p>
            </div>

            <button type="button"
                data-firebase-google-login
                data-redirect-after-login="{{ route('dashboard') }}"
                class="group w-full inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-extrabold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:bg-purple-50 hover:text-purple-700 hover:shadow-lg">

                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-slate-100">
                    <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20c10 0 19-7.3 19-20 0-1.3-.1-2.4-.4-3.5z"/>
                        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                        <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.3 35.1 26.8 36 24 36c-5.3 0-9.7-3.3-11.3-7.9l-6.5 5C9.5 39.5 16.2 44 24 44z"/>
                        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.1 5.5l6.3 5.3C36.9 39.3 43 34.8 43 24c0-1.3-.1-2.4-.4-3.5z"/>
                    </svg>
                </span>

                <span>Masuk dengan Google</span>
            </button>

            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-slate-100"></div>
                <span class="text-xs font-semibold text-slate-400">Aman dan cepat</span>
                <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <div class="grid grid-cols-1 gap-3 text-sm">
                <div class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-slate-600">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-purple-100 text-purple-700">
                        🔒
                    </span>
                    <span>Link undangan tetap aman memakai akun kamu.</span>
                </div>

                <div class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-slate-600">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-pink-100 text-pink-700">
                        ✨
                    </span>
                    <span>Kelola template, checkout, dan dashboard lebih mudah.</span>
                </div>
            </div>

            <div class="mt-7 text-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-2 text-sm font-bold text-purple-700 hover:bg-purple-50">
                    <span>←</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
