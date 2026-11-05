<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Digital Online Elegan untuk Pernikahan, Ulang Tahun, Seminar | Hajatin.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Hajatin.com adalah platform undangan digital online untuk membuat undangan pernikahan, ulang tahun, seminar, syukuran, grand opening, dan berbagai acara lainnya. Pilih template, edit data acara, tambahkan foto, lokasi Google Maps, RSVP, buku tamu, amplop digital, lalu bagikan undangan melalui link.">
    <meta name="keywords" content="undangan digital, undangan online, undangan pernikahan digital, undangan ulang tahun online, template undangan digital, undangan website, undangan dengan RSVP, undangan Google Maps, undangan amplop digital">
    <meta name="author" content="Spektakuler.id">

    <meta property="og:title" content="Hajatin.com - Platform Undangan Digital Online">
    <meta property="og:description" content="Buat undangan digital elegan untuk pernikahan, ulang tahun, seminar, syukuran, grand opening, dan berbagai acara lainnya.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="{{ url('/') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .wa-floating {
            position: fixed;
            right: 26px;
            bottom: 26px;
            z-index: 9999;
            width: 64px;
            height: 64px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #25D366, #16A34A);
            box-shadow: 0 18px 38px rgba(22, 163, 74, .28);
            border: 4px solid rgba(255, 255, 255, .92);
            text-decoration: none;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .wa-floating:hover {
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 22px 46px rgba(22, 163, 74, .36);
        }

        .wa-floating-icon {
            width: 34px;
            height: 34px;
            object-fit: contain;
            position: relative;
            z-index: 2;
        }

        .wa-floating-pulse {
            position: absolute;
            inset: -7px;
            border-radius: 999px;
            background: rgba(37, 211, 102, .22);
            animation: waPulse 1.8s infinite;
            z-index: 1;
        }

        @keyframes waPulse {
            0% {
                transform: scale(.9);
                opacity: .9;
            }

            70% {
                transform: scale(1.22);
                opacity: 0;
            }

            100% {
                transform: scale(1.22);
                opacity: 0;
            }
        }

        @media (max-width: 640px) {
            .wa-floating {
                right: 18px;
                bottom: 18px;
                width: 58px;
                height: 58px;
            }

            .wa-floating-icon {
                width: 30px;
                height: 30px;
            }
        }
        .wa-floating-with-text {
            position: fixed;
            right: 26px;
            bottom: 26px;
            z-index: 9999;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .wa-floating-text {
            padding: 11px 14px;
            border-radius: 999px;
            background: #ffffff;
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
            border: 1px solid rgba(148, 163, 184, .18);
        }

        .wa-floating-circle {
            position: relative;
            width: 62px;
            height: 62px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #25D366, #16A34A);
            box-shadow: 0 18px 38px rgba(22, 163, 74, .28);
            border: 4px solid rgba(255, 255, 255, .92);
        }

        @media (max-width: 640px) {
            .wa-floating-text {
                display: none;
            }

            .wa-floating-with-text {
                right: 18px;
                bottom: 18px;
            }
        }

        .home-preview-shell {
            position: relative;
            border-radius: 2rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #f5ecff 0%, #fdf7ff 45%, #fff8fc 100%);
            border: 1px solid rgba(255,255,255,.9);
            overflow: hidden;
        }

        .home-preview-glow {
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 999px;
            background: rgba(168, 85, 247, .14);
            top: -40px;
            right: -40px;
            filter: blur(8px);
            pointer-events: none;
        }

        .home-preview-glow.second {
            width: 140px;
            height: 140px;
            background: rgba(236, 72, 153, .10);
            bottom: -30px;
            left: -20px;
            top: auto;
            right: auto;
        }

        .home-preview-frame {
            position: relative;
            z-index: 2;
            border-radius: 1.75rem;
            padding: 1rem;
            background: rgba(255,255,255,.45);
            border: 1px solid rgba(255,255,255,.75);
            backdrop-filter: blur(8px);
        }

        .home-preview-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .home-preview-dots {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .home-preview-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #c084fc, #a855f7);
            opacity: .9;
        }

        .home-preview-dots span:nth-child(2) {
            background: linear-gradient(135deg, #f9a8d4, #ec4899);
        }

        .home-preview-dots span:nth-child(3) {
            background: linear-gradient(135deg, #ddd6fe, #8b5cf6);
        }

        .home-preview-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .55rem .95rem;
            border-radius: 999px;
            background: #fff;
            color: #7c3aed;
            font-size: .78rem;
            font-weight: 800;
            border: 1px solid rgba(168, 85, 247, .14);
            box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
        }

        .home-preview-card {
            position: relative;
            min-height: 290px;
            border-radius: 1.75rem;
            padding: 1.3rem;
            background: linear-gradient(180deg, #ffffff 0%, #fdfaff 100%);
            border: 1px solid rgba(226, 232, 240, .9);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .home-preview-inner {
            position: relative;
            z-index: 2;
            height: 100%;
            border-radius: 1.35rem;
            padding: 1.5rem 1.25rem;
            border: 1px dashed rgba(168, 85, 247, .22);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .home-preview-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .45rem .9rem;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(168,85,247,.12), rgba(236,72,153,.10));
            color: #7c3aed;
            font-size: .78rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .home-preview-title {
            max-width: 520px;
            text-align: center;
            font-size: 2.2rem;
            line-height: 1.15;
            font-weight: 900;
            color: #0f172a;
            margin: 0;
        }

        .home-preview-date {
            margin-top: .9rem;
            font-size: 1rem;
            color: #64748b;
            font-weight: 500;
        }

        .home-preview-meta {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-top: 1.3rem;
        }

        .home-preview-meta-item {
            min-width: 130px;
            padding: .85rem 1rem;
            border-radius: 1rem;
            background: #fff;
            border: 1px solid rgba(226, 232, 240, .95);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .04);
            text-align: center;
        }

        .home-preview-meta-item .meta-title {
            display: block;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #a78bfa;
            margin-bottom: .35rem;
        }

        .home-preview-meta-item strong {
            display: block;
            font-size: .95rem;
            color: #0f172a;
            font-weight: 800;
        }

        .home-preview-ornament {
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .home-preview-ornament.ornament-top {
            width: 130px;
            height: 130px;
            top: -28px;
            right: -28px;
            background: radial-gradient(circle at center, rgba(192, 132, 252, .18), rgba(192, 132, 252, .04));
        }

        .home-preview-ornament.ornament-bottom {
            width: 115px;
            height: 115px;
            bottom: -24px;
            left: -24px;
            background: radial-gradient(circle at center, rgba(244, 114, 182, .15), rgba(244, 114, 182, .04));
        }

        @media (max-width: 768px) {
            .home-preview-title {
                font-size: 1.7rem;
            }

            .home-preview-card {
                min-height: 250px;
            }

            .home-preview-meta {
                flex-direction: column;
                align-items: center;
            }

            .home-preview-meta-item {
                width: 100%;
                max-width: 220px;
            }
        }

        /* =========================================================
        HOME HERO TEMPLATE PREVIEW - TINGGI DISESUAIKAN SISI KIRI
        ========================================================= */

        .home-template-slider {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            padding: 1rem;
            background:
                radial-gradient(circle at 85% 12%, rgba(168, 85, 247, .18), transparent 28%),
                radial-gradient(circle at 8% 88%, rgba(236, 72, 153, .12), transparent 28%),
                linear-gradient(135deg, #f6edff 0%, #fff7fb 46%, #ffffff 100%);
            border: 1px solid rgba(255,255,255,.9);
        }

        .home-slider-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: .9rem;
            position: relative;
            z-index: 3;
        }

        .home-slider-dots {
            display: flex;
            gap: 7px;
        }

        .home-slider-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #c084fc, #8b5cf6);
        }

        .home-slider-dots span:nth-child(2) {
            background: linear-gradient(135deg, #f9a8d4, #ec4899);
        }

        .home-slider-dots span:nth-child(3) {
            background: linear-gradient(135deg, #ddd6fe, #6366f1);
        }

        .home-slider-badge {
            padding: .55rem .9rem;
            border-radius: 999px;
            background: #ffffff;
            color: #7c3aed;
            font-size: .78rem;
            font-weight: 900;
            border: 1px solid rgba(168, 85, 247, .14);
            box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
        }

        /* KUNCI UTAMA:
        height dibuat clamp, bukan aspect-ratio tinggi.
        Jadi kanan tidak lebih tinggi dari area kiri. */
        .home-slider-stage {
            position: relative;
            width: 100%;
            height: clamp(390px, 34vw, 520px);
            min-height: 0 !important;
            aspect-ratio: auto !important;
            border-radius: 1.75rem;
            overflow: hidden;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(255,255,255,.88);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.72);
        }

        .home-slider-item {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateX(32px) scale(.985);
            pointer-events: none;
            transition: opacity .45s ease, transform .45s ease;
        }

        .home-slider-item.is-active {
            opacity: 1;
            transform: translateX(0) scale(1);
            pointer-events: auto;
        }

        /* Preview tidak gepeng karena iframe tidak di-stretch,
        hanya di-scale dari tengah */
        .home-slider-iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 1440px;
            height: 1200px;
            border: 0;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(.34);
            transform-origin: center center;
        }

        .home-slider-info {
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 18px;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 1.35rem;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(226, 232, 240, .9);
            box-shadow: 0 16px 35px rgba(15, 23, 42, .10);
            backdrop-filter: blur(14px);
        }

        .home-slider-category {
            margin: 0;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .13em;
            font-weight: 900;
            color: #8b5cf6;
        }

        .home-slider-title {
            margin: .25rem 0 0;
            font-size: 1.15rem;
            font-weight: 950;
            color: #0f172a;
            line-height: 1.15;
        }

        .home-slider-link {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .72rem 1rem;
            border-radius: 999px;
            text-decoration: none;
            color: white;
            font-size: .82rem;
            font-weight: 900;
            background: linear-gradient(135deg, #9333ea, #a855f7);
            box-shadow: 0 12px 24px rgba(147, 51, 234, .22);
        }

        .home-slider-nav {
            position: absolute;
            top: 50%;
            z-index: 6;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            border: 1px solid rgba(226, 232, 240, .95);
            background: rgba(255,255,255,.94);
            color: #7c3aed;
            font-size: 30px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transform: translateY(-50%);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
            transition: .18s ease;
        }

        .home-slider-prev {
            left: 18px;
        }

        .home-slider-next {
            right: 18px;
        }

        .home-slider-indicators {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
        }

        .home-slider-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            background: rgba(124, 58, 237, .22);
            transition: .18s ease;
        }

        .home-slider-dot.is-active {
            width: 28px;
            background: linear-gradient(135deg, #9333ea, #ec4899);
        }

        /* Tablet: preview tetap turun ke bawah, tapi tidak terlalu tinggi */
        @media (max-width: 1023px) {
            .home-slider-stage {
                width: min(100%, 560px);
                height: 520px;
                margin: 0 auto;
            }

            .home-slider-iframe {
                width: 1440px;
                height: 1250px;
                transform: translate(-50%, -50%) scale(.34);
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .home-template-slider {
                border-radius: 1.5rem;
                padding: .85rem;
            }

            .home-slider-head {
                gap: 8px;
            }

            .home-slider-badge {
                font-size: .68rem;
                padding: .48rem .72rem;
            }

            .home-slider-stage {
                width: min(100%, 360px);
                height: 430px;
            }

            .home-slider-iframe {
                width: 1360px;
                height: 1350px;
                transform: translate(-50%, -50%) scale(.255);
            }

            .home-slider-info {
                left: 12px;
                right: 12px;
                bottom: 12px;
                flex-direction: column;
                align-items: flex-start;
            }

            .home-slider-link {
                width: 100%;
            }

            .home-slider-nav {
                width: 38px;
                height: 38px;
                font-size: 26px;
            }
        }

        /* =========================================================
        TEMPLATE CARD PREVIEW - FULLER, MOBILE L & 1024 FIX
        Untuk daftar template bagian bawah
        ========================================================= */

        .template-preview-frame {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 2.72;
            overflow: hidden;
            border-radius: 24px 24px 0 0;
            background:
                radial-gradient(circle at 85% 12%, rgba(147, 197, 253, .30), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef6ff 100%);
        }

        .template-preview-stage {
            position: absolute;
            inset: 0;
            overflow: hidden;
            border-radius: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .template-preview-iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 1280px;
            height: 930px;
            border: 0;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(.285);
            transform-origin: center center;
        }

        /* Laptop 1024 - grid 2 kolom, card lebar, preview diperbesar */
        @media (min-width: 768px) and (max-width: 1279px) {
            .template-preview-frame {
                aspect-ratio: 4 / 2.95;
            }

            .template-preview-iframe {
                width: 1280px;
                height: 960px;
                transform: translate(-50%, -50%) scale(.37);
            }
        }

        /* Desktop besar - grid 3 kolom */
        @media (min-width: 1280px) {
            .template-preview-frame {
                aspect-ratio: 4 / 2.85;
            }

            .template-preview-iframe {
                width: 1280px;
                height: 940px;
                transform: translate(-50%, -50%) scale(.29);
            }
        }

        /* Mobile L tetap 1 kolom, preview dibuat memenuhi area */
        @media (max-width: 767px) {
            .template-preview-frame {
                aspect-ratio: 4 / 2.75;
                border-radius: 22px 22px 0 0;
            }

            .template-preview-iframe {
                width: 1280px;
                height: 930px;
                transform: translate(-50%, -50%) scale(.30);
            }
        }

        /* Mobile kecil */
        @media (max-width: 380px) {
            .template-preview-frame {
                aspect-ratio: 4 / 2.9;
            }

            .template-preview-iframe {
                width: 1280px;
                height: 960px;
                transform: translate(-50%, -50%) scale(.255);
            }
        }
    </style>
</head>
<body class="uk-gradient-bg text-slate-900">
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
                <a href="{{ route('home') }}" class="hover:text-purple-600">
                    Beranda
                </a>

                <a href="#template" class="hover:text-purple-600">
                    Template
                </a>

                <a href="#" class="hover:text-purple-600">
                    Bantuan
                </a>
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

    @php
        $templateBackUrl = request()->fullUrl() . '#template';
    @endphp

    <main>
        <section class="uk-container py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white border border-purple-100 rounded-full px-4 py-2 text-sm text-purple-700 font-semibold shadow-sm">
                    ✨ Platform undangan digital semua acara
                </div>

                <h1 class="mt-6 text-5xl md:text-6xl font-extrabold leading-tight tracking-tight text-slate-950">
                    Buat Undangan Digital Lebih Mudah dan Elegan
                </h1>

                <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                    Pilih template, isi detail acara, lakukan pembayaran, lalu publish undangan dalam bentuk link yang siap dibagikan.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#template" class="uk-btn-primary">
                        Lihat Template
                    </a>

                    <a href="#cara-kerja" class="uk-btn-secondary">
                        Cara Kerja
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-3 gap-4 max-w-md">
                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">50+</p>
                        <p class="text-sm text-slate-500">Template Undangan</p>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">QRIS</p>
                        <p class="text-sm text-slate-500">Pembayaran</p>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">Link</p>
                        <p class="text-sm text-slate-500">Siap bagikan</p>
                    </div>
                </div>
            </div>

            @php
                $heroFallbackTemplates = isset($heroPreviewTemplates) && $heroPreviewTemplates->count()
                    ? $heroPreviewTemplates
                    : $templates->take(5);

                $heavyPreviewTemplates = [
                    'corporate-grand-opening-pro',
                    'corporate-award-night',
                    'corporate-networking-night',
                ];
            @endphp

            <div class="relative w-full max-w-[620px] mx-auto lg:mx-0">
                <div class="absolute -inset-6 bg-purple-200/40 blur-3xl rounded-full"></div>

                <div class="relative uk-card p-4 md:p-5 overflow-hidden">
                    <div class="home-template-slider" data-home-template-slider>
                        <div class="home-slider-head">
                            <div class="home-slider-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="home-slider-badge">
                                Live Preview Template
                            </div>
                        </div>

                        <div class="home-slider-stage">
                            @foreach ($heroFallbackTemplates as $index => $template)
                                <div class="home-slider-item {{ $index === 0 ? 'is-active' : '' }}"
                                    data-slide-index="{{ $index }}">
                                    <iframe
                                        data-src="{{ route('templates.live-preview', $template) }}"
                                        class="home-slider-iframe"
                                        loading="lazy"
                                        scrolling="no"
                                        title="Preview {{ $template->name }}">
                                    </iframe>

                                    <div class="home-slider-info">
                                        <div>
                                            <p class="home-slider-category">
                                                {{ $template->category->name ?? 'Template' }}
                                            </p>

                                            <h3 class="home-slider-title">
                                                {{ $template->name }}
                                            </h3>
                                        </div>

                                        <a href="{{ route('templates.show', $template->slug) . '?back=' . urlencode($templateBackUrl) }}"
                                        class="home-slider-link">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="home-slider-nav home-slider-prev" data-slider-prev aria-label="Preview sebelumnya">
                            ‹
                        </button>

                        <button type="button" class="home-slider-nav home-slider-next" data-slider-next aria-label="Preview berikutnya">
                            ›
                        </button>

                        <div class="home-slider-indicators">
                            @foreach ($heroFallbackTemplates as $index => $template)
                                <button type="button"
                                        class="home-slider-dot {{ $index === 0 ? 'is-active' : '' }}"
                                        data-slider-dot="{{ $index }}"
                                        aria-label="Tampilkan {{ $template->name }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cara-kerja" class="max-w-6xl mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold mb-6">Cara Kerja</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="uk-card p-6">
                    <div class="text-purple-600 font-bold text-xl">1</div>
                    <h3 class="font-bold text-lg mt-3">Pilih Template</h3>
                    <p class="text-gray-600 mt-2">Pilih desain sesuai jenis acara kamu.</p>
                </div>

                <div class="uk-card p-6">
                    <div class="text-purple-600 font-bold text-xl">2</div>
                    <h3 class="font-bold text-lg mt-3">Edit Undangan</h3>
                    <p class="text-gray-600 mt-2">Isi nama acara, tanggal, lokasi, dan detail lainnya.</p>
                </div>

                <div class="uk-card p-6">
                    <div class="text-purple-600 font-bold text-xl">3</div>
                    <h3 class="font-bold text-lg mt-3">Publish & Bagikan</h3>
                    <p class="text-gray-600 mt-2">Dapatkan link undangan dan bagikan ke tamu.</p>
                </div>
            </div>
        </section>

        <section id="template" class="max-w-6xl mx-auto px-6 py-14">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold">Pilih Template Acara</h2>
                    <p class="text-gray-600 mt-2">
                        Pilih template untuk pernikahan, ulang tahun, seminar, syukuran, dan acara lainnya.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('templates.index') }}#template"
                   class="px-4 py-2 rounded-full border bg-white hover:bg-purple-600 hover:text-white">
                    Semua
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('templates.index', ['category' => $category->slug]) }}#template"
                       class="px-4 py-2 rounded-full border bg-white hover:bg-purple-600 hover:text-white">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse ($templates as $template)
                    <div class="uk-card uk-card-hover overflow-hidden">
                        <div class="template-preview-frame">
                            <div class="template-preview-stage">
                                @php
                                    $templatePreviewUrl = route('templates.live-preview', $template);

                                    if (in_array($template->view_name, $heavyPreviewTemplates, true)) {
                                        $templatePreviewUrl .= '?card_preview=1';
                                    }
                                @endphp

                                <iframe
                                    data-src="{{ $templatePreviewUrl }}"
                                    class="template-preview-iframe"
                                    loading="lazy"
                                    scrolling="no"
                                    title="Preview {{ $template->name }}">
                                </iframe>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-xl font-extrabold text-slate-900">
                                        {{ $template->name }}
                                    </h3>

                                    <p class="text-slate-500 text-sm mt-1">
                                        {{ $template->category->name }}
                                    </p>
                                </div>

                                @if ($template->is_premium)
                                    <span class="uk-badge bg-yellow-100 text-yellow-700">
                                        Premium
                                    </span>
                                @else
                                    <span class="uk-badge bg-green-100 text-green-700">
                                        Basic
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5 flex items-center justify-between">
                                <p class="text-2xl font-extrabold text-purple-600">
                                    Rp{{ number_format($template->price, 0, ',', '.') }}
                                </p>

                                <span class="text-xs text-slate-400">
                                    Sekali bayar
                                </span>
                            </div>

                            <a href="{{ route('templates.show', $template->slug) . '?back=' . urlencode($templateBackUrl) }}"
                            class="mt-5 w-full uk-btn-primary">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada template tersedia.</p>
                @endforelse
            </div>
            @if ($templates->hasPages())
                <div class="mt-10">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-500">
                            Menampilkan
                            <span class="font-bold text-slate-800">{{ $templates->firstItem() }}</span>
                            sampai
                            <span class="font-bold text-slate-800">{{ $templates->lastItem() }}</span>
                            dari
                            <span class="font-bold text-purple-600">{{ $templates->total() }}</span>
                            template
                        </p>

                        <div class="inline-flex flex-wrap items-center justify-center gap-2 bg-white/90 border border-purple-100 rounded-2xl p-2 shadow-sm">
                            {{-- Tombol Previous --}}
                            @if ($templates->onFirstPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $templates->previousPageUrl() }}#template"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-purple-100 hover:bg-purple-50 hover:text-purple-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Nomor halaman --}}
                            @foreach ($templates->getUrlRange(1, $templates->lastPage()) as $page => $url)
                                @if ($page == $templates->currentPage())
                                    <span class="min-w-[40px] h-10 px-3 flex items-center justify-center rounded-xl bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold shadow-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}#template"
                                    class="min-w-[40px] h-10 px-3 flex items-center justify-center rounded-xl bg-white text-slate-700 border border-purple-100 hover:bg-purple-50 hover:text-purple-600 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($templates->hasMorePages())
                                <a href="{{ $templates->nextPageUrl() }}#template"
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
        </section>

        <section class="max-w-6xl mx-auto px-6 py-12">
            <div class="uk-card p-8 md:p-10 bg-white/90">
                <div class="max-w-4xl">
                    <p class="text-sm font-bold uppercase tracking-[0.25em] text-purple-600">
                        Undangan Digital Online
                    </p>

                    <h2 class="mt-4 text-3xl md:text-4xl font-extrabold text-slate-950 leading-tight">
                        Solusi Praktis Membuat Undangan Digital untuk Semua Jenis Acara
                    </h2>

                    <p class="mt-5 text-slate-600 leading-8">
                        Hajatin.com membantu kamu membuat undangan digital online dengan tampilan modern,
                        elegan, dan mudah dibagikan. Platform ini cocok digunakan untuk undangan pernikahan,
                        ulang tahun, seminar, syukuran, khitanan, grand opening, reuni, gathering, hingga acara
                        keluarga dan acara resmi lainnya. Pengguna cukup memilih template, mengisi detail acara,
                        menambahkan foto, lokasi Google Maps, musik, RSVP, buku tamu, serta amplop digital.
                    </p>

                    <p class="mt-4 text-slate-600 leading-8">
                        Dengan undangan berbasis link, tamu dapat membuka undangan langsung melalui browser
                        tanpa perlu mengunduh aplikasi tambahan. Setiap undangan dapat dipersonalisasi sesuai
                        kebutuhan acara, mulai dari nama acara, tanggal, waktu, alamat, tema warna, galeri foto,
                        hingga ucapan tamu. Hajatin.com dirancang untuk membantu proses pembuatan undangan
                        menjadi lebih cepat, hemat, rapi, dan profesional.
                    </p>

                    <div class="mt-7 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-purple-50 border border-purple-100 p-5">
                            <h3 class="font-bold text-slate-900">
                                Template Siap Pakai
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 leading-6">
                                Pilih desain undangan sesuai kategori acara dan langsung edit melalui dashboard.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-pink-50 border border-pink-100 p-5">
                            <h3 class="font-bold text-slate-900">
                                Fitur Lengkap
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 leading-6">
                                Mendukung RSVP, buku tamu, Google Maps, galeri foto, musik, dan amplop digital.
                            </p>
                        </div>

                        <div class="rounded-2xl bg-indigo-50 border border-indigo-100 p-5">
                            <h3 class="font-bold text-slate-900">
                                Mudah Dibagikan
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 leading-6">
                                Undangan bisa dibagikan melalui WhatsApp, media sosial, atau link pribadi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <footer class="relative overflow-hidden border-t border-purple-100 bg-white">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-20 left-10 w-64 h-64 bg-purple-200/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 right-10 w-72 h-72 bg-pink-200/30 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-extrabold">
                            H
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-slate-950">
                                Hajatin.com
                            </h2>
                            <p class="text-xs text-slate-500">
                                Digital Invitation Platform
                            </p>
                        </div>
                    </div>

                    <p class="text-slate-600 text-sm leading-7 mt-4">
                        Platform pembuatan undangan digital online untuk berbagai acara dengan template modern,
                        fitur lengkap, dan link undangan yang mudah dibagikan.
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900">
                        Fitur Utama
                    </h3>

                    <div class="mt-4 grid gap-2 text-sm text-slate-600">
                        <p>Template undangan digital</p>
                        <p>RSVP dan buku tamu</p>
                        <p>Google Maps dan kalender</p>
                        <p>Amplop digital dan galeri foto</p>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900">
                        Cocok Untuk
                    </h3>

                    <div class="mt-4 grid gap-2 text-sm text-slate-600">
                        <p>Undangan pernikahan</p>
                        <p>Undangan ulang tahun</p>
                        <p>Seminar dan acara resmi</p>
                        <p>Syukuran, grand opening, dan gathering</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-3">
                <p class="text-sm text-slate-500">
                    © 2026 <span class="font-bold text-slate-900">Spektakuler.id</span>. All rights reserved.
                </p>

                <p class="text-sm text-slate-400">
                    Crafted with care for digital invitation creators.
                </p>
            </div>
        </div>
    </footer>
    <a href="https://wa.me/6282141248062?text={{ urlencode('Halo admin hajatin, saya ingin bertanya tentang undangan digital.') }}"
    target="_blank"
    rel="noopener noreferrer"
    class="wa-floating-with-text"
    aria-label="Chat WhatsApp">
        <span class="wa-floating-text">Butuh Bantuan?</span>

        <span class="wa-floating-circle">
            <span class="wa-floating-pulse"></span>
            <img src="{{ asset('assets/icons/whatsapp.png') }}"
                alt="WhatsApp"
                class="wa-floating-icon">
        </span>
    </a>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('[data-home-template-slider]');

            if (!slider) {
                return;
            }

            const slides = Array.from(slider.querySelectorAll('.home-slider-item'));
            const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
            const prevBtn = slider.querySelector('[data-slider-prev]');
            const nextBtn = slider.querySelector('[data-slider-next]');

            if (!slides.length) {
                return;
            }

            let activeIndex = 0;
            let autoSlideTimer = null;

            function loadSlideIframe(slide) {
                const iframe = slide.querySelector('iframe[data-src]');

                if (iframe && !iframe.src) {
                    iframe.src = iframe.dataset.src;
                }
            }

            function showSlide(index) {
                activeIndex = (index + slides.length) % slides.length;

                slides.forEach(function (slide, slideIndex) {
                    const isActive = slideIndex === activeIndex;
                    slide.classList.toggle('is-active', isActive);

                    if (isActive) {
                        loadSlideIframe(slide);
                    }
                });

                dots.forEach(function (dot, dotIndex) {
                    dot.classList.toggle('is-active', dotIndex === activeIndex);
                });
            }

            function nextSlide() {
                showSlide(activeIndex + 1);
            }

            function prevSlide() {
                showSlide(activeIndex - 1);
            }

            function startAutoSlide() {
                stopAutoSlide();

                autoSlideTimer = setInterval(function () {
                    nextSlide();
                }, 4500);
            }

            function stopAutoSlide() {
                if (autoSlideTimer) {
                    clearInterval(autoSlideTimer);
                    autoSlideTimer = null;
                }
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    nextSlide();
                    startAutoSlide();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    prevSlide();
                    startAutoSlide();
                });
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    const index = parseInt(this.dataset.sliderDot || '0', 10);
                    showSlide(index);
                    startAutoSlide();
                });
            });

            slider.addEventListener('mouseenter', stopAutoSlide);
            slider.addEventListener('mouseleave', startAutoSlide);

            showSlide(0);
            startAutoSlide();

            const lazyPreviewIframes = document.querySelectorAll('.template-preview-iframe[data-src]');

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

            lazyPreviewIframes.forEach(function (iframe) {
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
