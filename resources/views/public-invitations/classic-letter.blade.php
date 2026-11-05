<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $browserTitle = trim(($invitation->event_name ?: 'Undangan') . ' ' . ($invitation->title ?: 'Digital'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, var(--theme-body-1), transparent 32%),
                radial-gradient(circle at top right, var(--theme-body-2), transparent 28%),
                linear-gradient(180deg, #f7f1ec 0%, var(--theme-soft) 45%, #f5eee8 100%);
        }

        .invite-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .paper-wrap {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 20% 20%, var(--theme-paper), transparent 25%),
                radial-gradient(circle at 80% 30%, var(--theme-paper), transparent 22%),
                linear-gradient(180deg, #fffdf8 0%, #fffaf5 100%);
            border-radius: 32px;
            min-height: 100vh;
            box-shadow: 0 30px 90px rgba(15, 23, 42, .16);
        }

        .paper-wrap::before,
        .paper-wrap::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 18px;
            background-image: radial-gradient(circle, #f7f1ec 8px, transparent 9px);
            background-size: 18px 22px;
            z-index: 0;
            opacity: .65;
            pointer-events: none;
        }

        .paper-wrap::before {
            left: -9px;
        }

        .paper-wrap::after {
            right: -9px;
        }

        .paper-wrap > * {
            position: relative;
            z-index: 1;
        }

        .detail-icon-circle {
            background:
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--theme-primary) 14%, white),
                    color-mix(in srgb, var(--theme-secondary) 18%, white)
                );
            border: 1px solid color-mix(in srgb, var(--theme-primary) 10%, transparent);
        }

        .decorative-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .decor-item {
            position: absolute;
            opacity: .08;
            pointer-events: none;
            transform-origin: center;
        }

        .decor-item svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .decor-primary {
            color: var(--theme-primary);
        }

        .decor-secondary {
            color: var(--theme-secondary);
        }

        .decor-dark {
            color: var(--theme-dark);
        }

        /* Ornamen atas kiri */
        .decor-top-left {
            width: 280px;
            height: 280px;
            top: -36px;
            left: -58px;
            opacity: .07;
            transform: rotate(-10deg);
        }

        /* Ornamen kanan atas */
        .decor-top-right {
            width: 220px;
            height: 220px;
            top: 90px;
            right: -36px;
            opacity: .06;
            transform: rotate(14deg);
        }

        /* Lingkaran halus tengah */
        .decor-middle-ring {
            width: 220px;
            height: 220px;
            top: 680px;
            left: 50%;
            transform: translateX(-50%);
            opacity: .05;
        }

        /* Floral swirl kiri tengah */
        .decor-middle-left {
            width: 190px;
            height: 190px;
            top: 980px;
            left: -24px;
            opacity: .06;
            transform: rotate(-16deg);
        }

        /* Ornamen kanan bawah */
        .decor-bottom-right {
            width: 300px;
            height: 300px;
            bottom: 110px;
            right: -56px;
            opacity: .07;
            transform: rotate(8deg);
        }

        /* Wave bawah kiri */
        .decor-bottom-left {
            width: 240px;
            height: 200px;
            bottom: 220px;
            left: -44px;
            opacity: .05;
            transform: rotate(-12deg);
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            word-wrap: break-word;
            white-space: pre-line;
        }

        @media (max-width: 900px) {
            .decor-top-left {
                width: 220px;
                height: 220px;
                left: -50px;
            }

            .decor-top-right {
                width: 180px;
                height: 180px;
                right: -30px;
            }

            .decor-middle-ring {
                width: 180px;
                height: 180px;
            }

            .decor-middle-left {
                width: 150px;
                height: 150px;
            }

            .decor-bottom-right {
                width: 220px;
                height: 220px;
                right: -44px;
            }

            .decor-bottom-left {
                width: 180px;
                height: 150px;
            }
        }

        @media (max-width: 640px) {
            .decor-item {
                opacity: .05;
            }

            .decor-top-left {
                width: 150px;
                height: 150px;
                top: -8px;
                left: -34px;
            }

            .decor-top-right {
                width: 120px;
                height: 120px;
                top: 100px;
                right: -24px;
            }

            .decor-middle-ring {
                width: 120px;
                height: 120px;
                top: 720px;
            }

            .decor-middle-left {
                width: 110px;
                height: 110px;
                top: 980px;
                left: -18px;
            }

            .decor-bottom-right {
                width: 150px;
                height: 150px;
                bottom: 120px;
                right: -24px;
            }

            .decor-bottom-left {
                width: 120px;
                height: 100px;
                bottom: 220px;
                left: -20px;
            }
        }

        .page-section {
            position: relative;
            min-height: 100vh;
            padding: 96px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .page-section.compact {
            min-height: auto;
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .opening-content {
            width: min(100%, 620px);
            margin: 0 auto;
            text-align: center;
        }

        .section-card {
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(68, 45, 35, .10);
            border-radius: 26px;
            box-shadow: 0 18px 45px rgba(68, 45, 35, .09);
            padding: 26px;
        }

        .section-title {
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            line-height: 1.12;
        }

        .script-text {
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            letter-spacing: .02em;
        }

        .bookmark {
            width: 34px;
            height: 54px;
            background: linear-gradient(180deg, var(--theme-primary), var(--theme-secondary));
            position: absolute;
            top: 24px;
            right: 38px;
            border: 3px solid #1f2937;
            z-index: 10;
            border-radius: 3px 3px 0 0;
        }

        .bookmark::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -16px;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 13px solid transparent;
            border-right: 13px solid transparent;
            border-top: 15px solid #e05268;
        }

        .ribbon {
            position: relative;
            height: 64px;
            background: var(--theme-primary);
            margin-left: -56px;
            margin-right: -56px;
            box-shadow: 0 15px 35px rgba(92, 18, 63, .24);
        }

        .ribbon::before,
        .ribbon::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 7px;
            background-image: linear-gradient(90deg, #fff 50%, transparent 50%);
            background-size: 14px 7px;
            opacity: .95;
        }

        .ribbon::before {
            top: -7px;
        }

        .ribbon::after {
            bottom: -7px;
        }

        .seal {
            width: 166px;
            height: 166px;
            border-radius: 999px;
            background: var(--theme-primary);
            border: 7px solid #fff;
            color: #fff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .24);
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            text-decoration: none;
            z-index: 5;
        }

        .seal span:first-child {
            font-size: 12px;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .seal span:last-child {
            margin-top: 8px;
            font-size: 22px;
            font-weight: 900;
            line-height: 1.15;
        }

        .soft-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 12px 22px;
            font-weight: 700;
            transition: .2s ease;
            text-decoration: none;
        }

        .btn-maroon {
            background: var(--theme-primary);
            color: white;
        }

        .btn-maroon:hover {
            background: var(--theme-secondary);
        }

        .btn-green {
            background: var(--theme-tertiary);
            color: white;
        }

        .btn-green:hover {
            background: var(--theme-quaternary);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 40;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: white;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .floating-actions a:hover,
        .floating-action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .22);
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--theme-primary) 12%, white);
            box-shadow: 0 14px 30px rgba(92, 18, 63, .20);
        }

        .floating-icon {
            width: 22px;
            height: 22px;
            object-fit: contain;
            display: block;
        }

        .floating-icon {
            width: 22px;
            height: 22px;
            object-fit: contain;
            display: block;
        }

        .photo-polaroid {
            background: white;
            padding: 8px;
            box-shadow: 0 14px 30px rgba(68,45,35,.14);
            border-radius: 8px;
        }

        .fade-up {
            animation: fadeUp .7s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cover-frame {
            width: min(100%, 320px);
            aspect-ratio: 3 / 4;
            margin: 0 auto;
            background: #ffffff;
            padding: 12px;
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .18);
        }

        .cover-frame img,
        .cover-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 16px;
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary));
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: 0 12px 26px rgba(92, 18, 63, .25);
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            max-width: 520px;
            margin: 0 auto;
        }

        .countdown-card {
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(68, 45, 35, .08);
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(68, 45, 35, .08);
            padding: 18px 12px;
        }

        .countdown-number {
            display: block;
            font-size: 28px;
            font-weight: 900;
            color: var(--theme-primary);
            line-height: 1;
        }

        .countdown-label {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
        }

        .countdown-note {
            margin-top: 16px;
            font-size: 14px;
            color: #64748b;
        }

        .map-card {
            width: min(100%, 672px);
            margin: 24px auto 0;
            background: rgba(255,255,255,.9);
            border: 1px solid rgba(68, 45, 35, .10);
            border-radius: 26px;
            box-shadow: 0 18px 45px rgba(68, 45, 35, .09);
            overflow: hidden;
        }

        .map-click-area {
            display: block;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .map-frame {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            height: 320px;
            background:
                linear-gradient(135deg, rgba(15,76,69,.12), rgba(92,18,63,.10)),
                radial-gradient(circle at 30% 30%, var(--theme-paper), transparent 28%),
                #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
        }

        .map-pin {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 999px;
            background: var(--theme-tertiary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 14px 30px rgba(15, 76, 69, .25);
        }

        .map-footer {
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: rgba(255,255,255,.96);
        }

        .map-footer-title {
            font-weight: 900;
            color: #3b2a22;
        }

        .map-footer-desc {
            font-size: 13px;
            color: #64748b;
            margin-top: 3px;
        }

        .map-footer-button {
            white-space: nowrap;
            background: var(--theme-tertiary);
            color: white;
            font-weight: 800;
            padding: 10px 16px;
            border-radius: 999px;
        }

        .couple-wrap {
            max-width: 1100px;
            margin: 46px auto 0;
        }

        .couple-grid {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 0;
            position: relative;
        }

        .person-card {
            position: relative;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(68, 45, 35, .08);
            border-radius: 34px;
            padding: 42px 28px 34px;
            box-shadow: 0 18px 45px rgba(68, 45, 35, .08);
            overflow: visible;
            text-align: center;
            min-height: 360px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Foto utama dibuat lebih besar */
        .person-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 28px;
            margin: 0 auto;
            display: block;
            box-shadow: 0 12px 28px rgba(0,0,0,.10);
            border: 6px solid #fff;
        }

        /* Ornamen bunga */
        .person-ornament {
            position: absolute;
            width: 156px;
            height: 156px;
            object-fit: contain;
            pointer-events: none;
            z-index: 3;
        }

        /* kiri atas: posisi normal */
        .person-ornament.left {
            top: -22px;
            left: -18px;
            transform: none;
        }

        /* kanan bawah: putar 180 derajat, bukan mirror */
        .person-ornament.right {
            bottom: -22px;
            right: -18px;
            transform: rotate(180deg);
            transform-origin: center;
        }

        .person-name {
            margin-top: 20px;
            font-size: 34px;
            font-weight: 900;
            line-height: 1.08;
            color: var(--theme-dark);
            font-family: Georgia, "Times New Roman", serif;
        }

        .person-subtitle {
            margin-top: 10px;
            color: #7c879d;
            font-size: 17px;
        }

        .person-family {
            margin-top: 10px;
            color: #4b5563;
            font-size: 20px;
        }

        /* Tanda & dibuat benar-benar di tengah tanpa jarak */
        .couple-and {
            width: 84px;
            height: 84px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(68,45,35,.08);
            box-shadow: 0 16px 35px rgba(68,45,35,.10);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 900;
            color: var(--theme-primary);
            font-family: Georgia, "Times New Roman", serif;
            line-height: 1;
            position: relative;
            z-index: 5;
            margin-left: -22px;
            margin-right: -22px;
        }

        .couple-and span {
            display: inline-block;
            transform: translateY(-2px);
        }

        /* Responsive tablet */
        @media (max-width: 900px) {
            .person-card {
                min-height: 320px;
                padding: 36px 22px 28px;
            }

            .person-photo {
                width: 130px;
                height: 130px;
                border-radius: 24px;
            }

            .person-name {
                font-size: 28px;
            }

            .person-family {
                font-size: 18px;
            }

            .couple-and {
                width: 74px;
                height: 74px;
                font-size: 42px;
                margin-left: -16px;
                margin-right: -16px;
            }
        }

        /* Responsive mobile */
        @media (max-width: 768px) {
            .couple-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .person-card {
                min-height: auto;
                padding: 34px 20px 26px;
            }

            .person-photo {
                width: 112px;
                height: 112px;
                border-radius: 22px;
            }

            .person-name {
                font-size: 24px;
            }

            .person-subtitle {
                font-size: 15px;
            }

            .person-family {
                font-size: 17px;
            }

            .person-ornament {
                position: absolute;
                width: 156px;
                height: 156px;
                object-fit: contain;
                pointer-events: none;
                z-index: 3;
            }

            /* kiri atas: posisi normal */
            .person-ornament.left {
                top: -22px;
                left: -18px;
                transform: none;
            }

            /* kanan bawah: putar 180 derajat, bukan mirror */
            .person-ornament.right {
                bottom: -22px;
                right: -18px;
                transform: rotate(180deg);
                transform-origin: center;
            }

            .couple-and {
                width: 66px;
                height: 66px;
                font-size: 38px;
                margin: -6px auto;
            }
        }

        @media (max-width: 768px) {
            .couple-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .couple-and {
                width: 62px;
                height: 62px;
                margin: -4px auto;
                font-size: 34px;
            }

            .person-card {
                padding: 30px 20px 24px;
            }

            .person-name {
                font-size: 24px;
            }

            .person-subtitle {
                font-size: 14px;
            }

            .person-family {
                font-size: 16px;
            }

            .person-photo {
                width: 96px;
                height: 96px;
                border-radius: 18px;
            }

            .person-ornament {
                position: absolute;
                width: 156px;
                height: 156px;
                object-fit: contain;
                pointer-events: none;
                z-index: 3;
            }
        }

        @media (max-width: 640px) {
            .map-frame,
            .map-placeholder {
                height: 260px;
            }

            .map-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .map-footer-button {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 900px) {
            .invite-shell {
                padding: 16px;
            }

            .paper-wrap {
                border-radius: 26px;
            }

            .page-section {
                padding: 86px 42px;
            }

            .ribbon {
                margin-left: -42px;
                margin-right: -42px;
            }
        }

        @media (max-width: 640px) {
            body {
                background: #fffaf5;
            }

            .invite-shell {
                padding: 0;
            }

            .paper-wrap {
                border-radius: 0;
                min-height: 100vh;
                box-shadow: none;
            }

            .paper-wrap::before,
            .paper-wrap::after {
                opacity: .42;
            }

            .page-section {
                padding: 84px 30px;
            }

            .page-section.compact {
                padding-top: 76px;
                padding-bottom: 76px;
            }

            .ribbon {
                margin-left: -30px;
                margin-right: -30px;
            }

            .seal {
                width: 150px;
                height: 150px;
            }

            .seal span:last-child {
                font-size: 20px;
            }

            .bookmark {
                right: 26px;
                top: 22px;
            }

            .floating-actions {
                right: 12px;
            }

            .cover-frame {
                width: min(100%, 290px);
                padding: 10px;
                border-radius: 20px;
            }

            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .countdown-number {
                font-size: 24px;
            }
        }

        /* =====================================================
        LUXURY ANIMATION - CLASSIC LETTER / GENERAL INVITATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen konten muncul halus saat scroll */
        .lux-reveal,
        .cl-section-heading,
        .cl-hero-copy,
        .cl-letter-panel,
        .cl-cover-photo-card,
        .cl-cover-info-card,
        .cl-person-lux-card,
        .cl-couple-symbol,
        .cl-detail-main-card,
        .cl-map-lux-card,
        .page-section > p,
        .page-section > h1,
        .page-section > h2,
        .page-section > h3,
        .section-card,
        .countdown-card,
        .map-card,
        .photo-polaroid,
        .detail-icon-circle {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .9s cubic-bezier(.2, .8, .2, 1),
                transform .9s cubic-bezier(.2, .8, .2, 1),
                filter .9s cubic-bezier(.2, .8, .2, 1),
                box-shadow .35s ease,
                border-color .35s ease;
            will-change: opacity, transform, filter;
        }

        .lux-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Opening langsung tampil elegan */
        #opening .opening-content {
            animation: luxHeroEnter 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .ribbon {
            animation: luxRibbonEnter .95s cubic-bezier(.2, .8, .2, 1) .22s both;
        }

        #opening .seal {
            animation:
                luxSealEnter .95s cubic-bezier(.2, .8, .2, 1) .38s both,
                luxSealFloat 3.8s ease-in-out 1.4s infinite;
        }

        /* Background kertas terasa hidup */
        .paper-wrap {
            animation: luxPaperGlow 8s ease-in-out infinite alternate;
        }

        .decorative-bg {
            animation: luxBgBreath 11s ease-in-out infinite alternate;
        }

        /* Ornamen bergerak halus */
        .decor-item {
            animation: luxDecorFloat 7.5s ease-in-out infinite;
            transform-origin: center center;
            will-change: transform, opacity;
        }

        .decor-top-right,
        .decor-bottom-right {
            animation-name: luxDecorFloatReverse;
        }

        .decor-middle-ring {
            animation-name: luxDecorRotate;
            animation-duration: 18s;
            animation-timing-function: linear;
        }

        .decor-middle-left,
        .decor-bottom-left {
            animation-duration: 8.8s;
        }

        /* Bookmark bergerak lembut */
        .bookmark {
            animation: luxBookmarkDrop .85s cubic-bezier(.2, .8, .2, 1) both, luxBookmarkFloat 4s ease-in-out 1s infinite;
        }

        /* Card hover premium untuk desktop */
        @media (hover: hover) {
            .section-card:hover,
            .person-card:hover,
            .countdown-card:hover,
            .map-card:hover,
            .photo-polaroid:hover,
            .cover-frame:hover {
                transform: translateY(-7px) scale(1.01) !important;
                border-color: color-mix(in srgb, var(--theme-primary) 24%, transparent) !important;
                box-shadow:
                    0 28px 74px rgba(68, 45, 35, .16),
                    0 0 42px color-mix(in srgb, var(--theme-primary) 10%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.72) !important;
            }

            .photo-polaroid img,
            .cover-frame img {
                transition: transform .75s ease, filter .75s ease;
            }

            .photo-polaroid:hover img,
            .cover-frame:hover img {
                transform: scale(1.045);
                filter: saturate(1.05) contrast(1.03);
            }
        }

        /* Button / seal / tombol ada kilau */
        .soft-button,
        .btn-maroon,
        .btn-green,
        .map-footer-button,
        button[type="submit"],
        button[onclick*="clipboard"],
        .seal {
            position: relative;
            overflow: hidden;
        }

        .soft-button::after,
        .btn-maroon::after,
        .btn-green::after,
        .map-footer-button::after,
        button[type="submit"]::after,
        button[onclick*="clipboard"]::after,
        .seal::before {
            content: "";
            position: absolute;
            top: -70%;
            left: -80%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.48),
                transparent
            );
            animation: luxButtonShine 3.4s ease-in-out infinite;
            pointer-events: none;
        }

        /* Jangan ganggu isi seal */
        .seal > * {
            position: relative;
            z-index: 2;
        }

        /* Icon detail lebih hidup */
        .detail-icon-circle {
            animation: luxIconPulse 3.2s ease-in-out infinite;
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: luxNumberGlow 2.4s ease-in-out infinite alternate;
        }

        /* Couple ornament bergerak halus */
        .person-ornament.left {
            animation: luxFlowerLeft 5.8s ease-in-out infinite;
            transform-origin: center center;
        }

        .person-ornament.right {
            animation: luxFlowerRight 5.8s ease-in-out infinite;
            transform-origin: center center;
        }

        /* Floating button */
        .floating-actions a,
        .floating-action-button {
            animation: luxFloatingButton 3.4s ease-in-out infinite;
        }

        .floating-actions a:nth-child(2),
        .floating-action-button:nth-child(2) {
            animation-delay: .2s;
        }

        .floating-actions a:nth-child(3),
        .floating-action-button:nth-child(3) {
            animation-delay: .4s;
        }

        .floating-actions a:nth-child(4),
        .floating-action-button:nth-child(4) {
            animation-delay: .6s;
        }

        /* Keyframes */
        @keyframes luxHeroEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes luxRibbonEnter {
            from {
                opacity: 0;
                transform: translateY(24px) scaleX(.92);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scaleX(1);
                filter: blur(0);
            }
        }

        @keyframes luxSealEnter {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(.78) rotate(-8deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes luxSealFloat {
            0%, 100% {
                transform: translate(-50%, -50%) translateY(0) scale(1);
            }
            50% {
                transform: translate(-50%, -50%) translateY(-6px) scale(1.025);
            }
        }

        @keyframes luxPaperGlow {
            from {
                box-shadow:
                    0 30px 90px rgba(15, 23, 42, .16),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 36px 105px rgba(15, 23, 42, .18),
                    0 0 46px color-mix(in srgb, var(--theme-primary) 9%, transparent);
            }
        }

        @keyframes luxBgBreath {
            from {
                transform: translate3d(-8px, -8px, 0) scale(1);
                opacity: .88;
            }
            to {
                transform: translate3d(10px, 10px, 0) scale(1.02);
                opacity: 1;
            }
        }

        @keyframes luxDecorFloat {
            0%, 100% {
                transform: translateY(0) rotate(-10deg) scale(1);
            }
            50% {
                transform: translateY(-12px) rotate(-6deg) scale(1.025);
            }
        }

        @keyframes luxDecorFloatReverse {
            0%, 100% {
                transform: translateY(0) rotate(14deg) scale(1);
            }
            50% {
                transform: translateY(-12px) rotate(10deg) scale(1.025);
            }
        }

        @keyframes luxDecorRotate {
            from {
                transform: translateX(-50%) rotate(0deg);
            }
            to {
                transform: translateX(-50%) rotate(360deg);
            }
        }

        @keyframes luxBookmarkDrop {
            from {
                opacity: 0;
                transform: translateY(-18px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes luxBookmarkFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes luxButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes luxIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 12px 28px rgba(68,45,35,.10);
            }
            50% {
                transform: translateY(-4px) scale(1.035);
                box-shadow:
                    0 18px 38px rgba(68,45,35,.14),
                    0 0 28px color-mix(in srgb, var(--theme-primary) 10%, transparent);
            }
        }

        @keyframes luxNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--theme-primary) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--theme-primary) 36%, transparent),
                    0 0 34px color-mix(in srgb, var(--theme-secondary) 16%, transparent);
            }
        }

        @keyframes luxFlowerLeft {
            0%, 100% {
                transform: translateY(0) rotate(0deg) scale(1);
            }
            50% {
                transform: translateY(-7px) rotate(3deg) scale(1.025);
            }
        }

        @keyframes luxFlowerRight {
            0%, 100% {
                transform: rotate(180deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(183deg) translateY(-7px) scale(1.025);
            }
        }

        @keyframes luxFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .lux-reveal,
            .page-section > p,
            .page-section > h1,
            .page-section > h2,
            .page-section > h3,
            .opening-content,
            .section-card,
            .cover-frame,
            .event-badge,
            .countdown-card,
            .map-card,
            .person-card,
            .couple-and,
            .photo-polaroid,
            .detail-icon-circle,
            .ribbon,
            .seal {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .decor-item {
                animation-duration: 9s;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .lux-reveal,
            .page-section > p,
            .page-section > h1,
            .page-section > h2,
            .page-section > h3,
            .opening-content,
            .section-card,
            .cover-frame,
            .event-badge,
            .countdown-card,
            .map-card,
            .person-card,
            .couple-and,
            .photo-polaroid,
            .detail-icon-circle,
            .ribbon,
            .seal,
            .paper-wrap,
            .decorative-bg,
            .decor-item,
            .bookmark,
            .person-ornament,
            .floating-actions a,
            .floating-action-button,
            .countdown-number {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        /* =====================================================
        CLASSIC LETTER ROYAL FLORAL - TOTAL REDESIGN
        ===================================================== */

        .classic-letter-silhouette {
            overflow-x: hidden !important;
            color: #3b2a22 !important;
            background:
                radial-gradient(circle at 8% 8%, color-mix(in srgb, var(--theme-primary) 13%, transparent), transparent 30%),
                radial-gradient(circle at 92% 10%, color-mix(in srgb, var(--theme-secondary) 10%, transparent), transparent 28%),
                linear-gradient(180deg, #eadfd8 0%, #fff9f2 42%, #eadfd8 100%) !important;
        }

        .classic-letter-silhouette * {
            box-sizing: border-box;
        }

        .classic-letter-silhouette .invite-shell {
            width: min(100%, 1320px) !important;
            padding: 26px !important;
            margin: 0 auto !important;
        }

        .classic-letter-silhouette .paper-wrap {
            position: relative !important;
            overflow: hidden !important;
            border-radius: 42px !important;
            min-height: 100vh !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.84), rgba(255,249,242,.82)),
                url("{{ asset('assets/classic-letter/paper-texture-soft.png') }}") center / cover repeat,
                linear-gradient(180deg, #fffdf8, #fff7ee) !important;
            border: 1px solid rgba(110,80,50,.14) !important;
            box-shadow:
                0 40px 130px rgba(68,45,35,.18),
                inset 0 0 0 1px rgba(255,255,255,.72) !important;
        }

        .classic-letter-silhouette .paper-wrap::before,
        .classic-letter-silhouette .paper-wrap::after {
            opacity: .34 !important;
        }

        /* Global decoration */
        .classic-letter-silhouette .classic-letter-decor {
            position: absolute !important;
            inset: 0 !important;
            z-index: 0 !important;
            pointer-events: none !important;
            overflow: hidden !important;
        }

        .classic-letter-silhouette .classic-flower {
            position: absolute !important;
            object-fit: contain !important;
            pointer-events: none !important;
            filter: drop-shadow(0 20px 34px rgba(68,45,35,.08));
        }

        .classic-letter-silhouette .classic-flower-top-left {
            width: min(560px, 42vw) !important;
            top: -90px !important;
            left: -120px !important;
            opacity: .32 !important;
            transform: rotate(-6deg) !important;
        }

        .classic-letter-silhouette .classic-flower-top-right {
            width: min(540px, 40vw) !important;
            top: 40px !important;
            right: -130px !important;
            opacity: .30 !important;
            transform: rotate(4deg) !important;
        }

        .classic-letter-silhouette .classic-flower-middle-left {
            width: min(450px, 34vw) !important;
            top: 45% !important;
            left: -150px !important;
            opacity: .18 !important;
            transform: rotate(-18deg) !important;
        }

        .classic-letter-silhouette .classic-flower-middle-right {
            width: min(460px, 34vw) !important;
            top: 66% !important;
            right: -155px !important;
            opacity: .18 !important;
            transform: rotate(16deg) !important;
        }

        /* Section base */
        .classic-letter-silhouette .page-section {
            position: relative !important;
            min-height: auto !important;
            padding: 118px 86px !important;
            display: block !important;
            overflow: hidden !important;
            text-align: center !important;
        }

        .classic-letter-silhouette .page-section::before {
            content: "" !important;
            position: absolute !important;
            inset: 28px !important;
            border-radius: 36px !important;
            border: 1px solid rgba(130,95,55,.10) !important;
            pointer-events: none !important;
            opacity: .55 !important;
            background:
                radial-gradient(circle at 12% 18%, rgba(154,107,22,.08), transparent 24%),
                radial-gradient(circle at 88% 82%, rgba(92,18,63,.07), transparent 26%) !important;
        }

        .classic-letter-silhouette .page-section > * {
            position: relative !important;
            z-index: 3 !important;
        }

        /* Heading */
        .cl-section-heading {
            width: min(100%, 840px);
            margin: 0 auto 54px;
            text-align: center;
        }

        .cl-kicker {
            margin: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--theme-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .28em;
            text-transform: uppercase;
        }

        .cl-kicker::before,
        .cl-kicker::after {
            content: "";
            width: 34px;
            height: 1px;
            background: var(--theme-primary);
            opacity: .45;
        }

        .cl-section-title {
            margin: 18px auto 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            font-size: clamp(3.1rem, 5.4vw, 6.4rem);
            line-height: .9;
            letter-spacing: -.05em;
        }

        .cl-divider {
            display: block;
            width: min(320px, 70%);
            height: 52px;
            margin: 24px auto 0;
            opacity: .44;
            background:
                url("{{ asset('assets/classic-letter/classic-floral-bottom.png') }}") center / contain no-repeat;
        }

        .cl-section-desc {
            max-width: 660px;
            margin: 22px auto 0;
            color: #6f655c;
            line-height: 1.9;
        }

        /* Buttons */
        .cl-primary-btn,
        .cl-secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 900;
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .cl-primary-btn {
            color: #fffaf0;
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary));
            box-shadow: 0 18px 44px color-mix(in srgb, var(--theme-primary) 22%, transparent);
        }

        .cl-secondary-btn {
            color: var(--theme-primary);
            background: rgba(255,255,255,.82);
            border: 1px solid color-mix(in srgb, var(--theme-primary) 18%, transparent);
        }

        .cl-primary-btn:hover,
        .cl-secondary-btn:hover {
            transform: translateY(-3px);
        }

        /* HERO */
        .cl-hero-section {
            min-height: 860px !important;
            padding: 108px 86px 260px !important;
            display: grid !important;
            align-items: center !important;
        }

        .cl-hero-grid {
            width: min(100%, 1080px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1.04fr) minmax(360px, .96fr);
            gap: 54px;
            align-items: center;
            text-align: left;
        }

        .cl-hero-copy {
            padding: 46px 0;
        }

        .cl-hero-title {
            margin: 18px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            font-size: clamp(4.2rem, 7.5vw, 8.4rem);
            line-height: .88;
            letter-spacing: -.06em;
        }

        .cl-hero-subtitle {
            margin-top: 22px;
            color: #6f655c;
            font-size: 1.12rem;
            line-height: 1.8;
        }

        .cl-hero-date {
            width: fit-content;
            margin-top: 34px;
            padding: 18px 22px;
        }

        .cl-hero-date span {
            display: block;
            color: var(--theme-dark);
            font-weight: 950;
            letter-spacing: .04em;
        }

        .cl-hero-date small {
            display: block;
            margin-top: 6px;
            color: #7a7068;
            font-weight: 700;
        }

        .cl-hero-actions {
            margin-top: 34px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .cl-letter-panel {
            position: relative;
            padding: 18px;
            border-radius: 44px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,247,235,.62));
            border: 1px solid rgba(130,95,55,.18);
            box-shadow: 0 34px 90px rgba(68,45,35,.13);
        }

        .cl-letter-panel::before {
            content: "";
            position: absolute;
            inset: -18px;
            z-index: -1;
            opacity: .28;
            background:
                url("{{ asset('assets/classic-letter/classic-floral-corner-gold.png') }}") left top / 220px auto no-repeat,
                url("{{ asset('assets/classic-letter/classic-floral-corner-gold-mirror.png') }}") right bottom / 230px auto no-repeat;
        }

        .cl-letter-panel-inner {
            min-height: 480px;
            padding: 54px 38px;
            border-radius: 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.86), transparent 42%),
                linear-gradient(180deg, rgba(255,255,255,.70), rgba(255,250,242,.50));
            border: 1px solid rgba(130,95,55,.12);
        }

        .cl-letter-small {
            margin: 0;
            color: var(--theme-primary);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .cl-letter-panel h2 {
            margin: 18px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            font-size: clamp(2.4rem, 4vw, 4.4rem);
            line-height: .95;
        }

        .cl-letter-panel p:last-of-type {
            max-width: 360px;
            margin: 18px auto 0;
            color: #746b62;
            line-height: 1.8;
        }

        .cl-wax-seal {
            width: 152px;
            height: 152px;
            margin: 36px auto 0;
            border-radius: 999px;
            display: grid;
            place-items: center;
            align-content: center;
            text-decoration: none;
            color: #fff;
            background:
                radial-gradient(circle at 50% 24%, color-mix(in srgb, var(--theme-secondary) 36%, #fff), transparent 34%),
                linear-gradient(145deg, var(--theme-primary), var(--theme-secondary));
            border: 8px solid #fff7ec;
            box-shadow: 0 24px 62px rgba(68,45,35,.22);
        }

        .cl-wax-seal span {
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .cl-wax-seal strong {
            margin-top: 5px;
            font-size: 1.1rem;
        }

        .cl-hero-bottom-floral {
            position: absolute !important;
            left: -9%;
            right: auto;
            bottom: 0;
            width: 118%;
            height: 290px;
            opacity: .32;
            z-index: 1 !important;
            background:
                url("{{ asset('assets/classic-letter/classic-floral-bottom.png') }}") center bottom / 100% auto no-repeat;
            pointer-events: none;
        }

        /* COVER */
        .cl-cover-section {
            padding-top: 116px !important;
        }

        .cl-cover-layout {
            width: min(100%, 1080px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(330px, .82fr) minmax(0, 1.18fr);
            gap: 52px;
            align-items: center;
            text-align: left;
        }

        .cl-cover-photo-card {
            position: relative;
            overflow: hidden;
            min-height: 560px;
            border-radius: 999px 999px 48px 48px;
            padding: 16px;
            background:
                linear-gradient(145deg, #fff, color-mix(in srgb, var(--theme-primary) 8%, #fff));
            border: 1px solid rgba(130,95,55,.16);
            box-shadow: 0 34px 92px rgba(68,45,35,.14);
        }

        .cl-cover-photo-card::after {
            content: "";
            position: absolute;
            inset: 28px;
            border: 1px solid rgba(255,255,255,.54);
            border-radius: 999px 999px 34px 34px;
            pointer-events: none;
        }

        .cl-cover-photo-card img,
        .cl-cover-placeholder {
            width: 100%;
            height: 100%;
            min-height: 528px;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 34px 34px;
            color: var(--theme-primary);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 900;
            background: color-mix(in srgb, var(--theme-primary) 8%, #fff);
        }

        .cl-cover-info-card {
            padding: 48px;
            border-radius: 42px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.90), rgba(255,250,243,.60));
            border: 1px solid rgba(130,95,55,.14);
            box-shadow: 0 28px 84px rgba(68,45,35,.10);
        }

        .cl-event-badge {
            display: inline-flex;
            padding: 9px 18px;
            border-radius: 999px;
            color: #fffaf0;
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary));
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .cl-cover-event {
            margin-top: 20px;
            color: #6f655c;
            font-weight: 700;
        }

        .cl-script-title {
            margin: 28px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            color: var(--theme-primary);
            font-size: clamp(2.4rem, 4.5vw, 4.8rem);
            line-height: .95;
        }

        .cl-date-box {
            margin-top: 24px;
            display: grid;
            gap: 10px;
            color: #6d6259;
        }

        .cl-date-box strong {
            color: var(--theme-dark);
            font-size: 1.15rem;
        }

        .cl-countdown-wrap {
            margin-top: 32px;
        }

        .classic-letter-silhouette .countdown-grid {
            max-width: none !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }

        .classic-letter-silhouette .countdown-card {
            border-radius: 22px !important;
            padding: 18px 10px !important;
            background: rgba(255,255,255,.86) !important;
            border: 1px solid rgba(130,95,55,.12) !important;
            box-shadow: 0 14px 34px rgba(68,45,35,.07) !important;
        }

        .classic-letter-silhouette .countdown-number {
            font-size: clamp(1.55rem, 3vw, 2.5rem) !important;
            color: var(--theme-primary) !important;
        }

        .cl-text-link {
            display: inline-flex;
            margin-top: 30px;
            color: var(--theme-primary);
            font-weight: 900;
            text-decoration: none;
        }

        /* COUPLE */
        .cl-couple-stage {
            width: min(100%, 1080px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 90px 1fr;
            gap: 0;
            align-items: center;
        }

        .cl-person-lux-card {
            position: relative;
            min-height: 500px;
            padding: 40px 34px;
            border-radius: 48px;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(145deg, rgba(255,255,255,.92), rgba(255,248,238,.62));
            border: 1px solid rgba(130,95,55,.16);
            box-shadow: 0 32px 92px rgba(68,45,35,.12);
            overflow: hidden;
        }

        .cl-person-lux-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .22;
            background:
                url("{{ asset('assets/classic-letter/classic-floral-corner-gold.png') }}") left top / 220px auto no-repeat,
                url("{{ asset('assets/classic-letter/classic-floral-corner-gold-mirror.png') }}") right bottom / 240px auto no-repeat;
            pointer-events: none;
        }

        .cl-person-photo-wrap {
            width: 190px;
            height: 230px;
            padding: 8px;
            border-radius: 999px 999px 32px 32px;
            background:
                linear-gradient(145deg, color-mix(in srgb, var(--theme-primary) 16%, #fff), #fff);
            box-shadow: 0 22px 52px rgba(68,45,35,.13);
        }

        .cl-person-photo-wrap img,
        .cl-person-initial {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 24px 24px;
            background: color-mix(in srgb, var(--theme-primary) 8%, #fff);
            color: var(--theme-primary);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 900;
        }

        .cl-person-content {
            position: relative;
            z-index: 2;
            margin-top: 28px;
        }

        .cl-person-content span {
            color: var(--theme-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .cl-person-content h3 {
            margin: 12px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            font-size: clamp(2.5rem, 4.3vw, 4.8rem);
            line-height: .9;
            letter-spacing: -.04em;
        }

        .cl-person-content p {
            margin: 18px auto 0;
            max-width: 360px;
            color: #6f655c;
            line-height: 1.8;
        }

        .cl-couple-symbol {
            width: 92px;
            height: 92px;
            margin: 0 -1px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--theme-primary);
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(130,95,55,.16);
            box-shadow: 0 22px 54px rgba(68,45,35,.12);
            z-index: 4;
        }

        .cl-couple-symbol span {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 3.3rem;
            line-height: 1;
        }

        /* DETAIL */
        .cl-detail-layout {
            width: min(100%, 1080px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(340px, 1.05fr);
            gap: 34px;
            align-items: stretch;
        }

        .cl-detail-main-card,
        .cl-map-lux-card {
            border-radius: 44px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.92), rgba(255,248,238,.64));
            border: 1px solid rgba(130,95,55,.15);
            box-shadow: 0 30px 88px rgba(68,45,35,.11);
            overflow: hidden;
        }

        .cl-detail-main-card {
            padding: 50px 40px;
            text-align: left;
        }

        .cl-detail-main-card h3 {
            margin: 0 0 28px;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--theme-dark);
            font-size: clamp(2.4rem, 4vw, 4.6rem);
            line-height: .92;
        }

        .cl-detail-list {
            display: grid;
            gap: 14px;
        }

        .cl-detail-item {
            display: grid;
            grid-template-columns: 46px 1fr;
            gap: 14px;
            align-items: center;
            padding: 16px;
            border-radius: 24px;
            background: rgba(255,255,255,.70);
            border: 1px solid rgba(130,95,55,.10);
        }

        .cl-detail-item span {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--theme-primary);
            background: color-mix(in srgb, var(--theme-primary) 12%, #fff);
        }

        .cl-detail-item small {
            display: block;
            color: var(--theme-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .cl-detail-item strong {
            display: block;
            margin-top: 4px;
            color: #62584f;
            line-height: 1.6;
        }

        .cl-detail-actions {
            margin-top: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cl-map-lux-card .map-placeholder {
            height: 100%;
            min-height: 520px;
        }

        /* Floating fixed */
        .classic-letter-silhouette .floating-actions {
            position: fixed !important;
            top: 50% !important;
            right: 8px !important;
            left: auto !important;
            transform: translateY(-50%) !important;
            z-index: 99999 !important;
            display: grid !important;
            gap: 8px !important;
        }

        .classic-letter-silhouette .floating-actions a,
        .classic-letter-silhouette .floating-action-button {
            width: 42px !important;
            height: 42px !important;
            border-radius: 999px !important;
            background: rgba(255,255,255,.96) !important;
            box-shadow: 0 14px 34px rgba(15,23,42,.16) !important;
            animation: none !important;
        }

        /* Tablet */
        @media (max-width: 980px) {
            .classic-letter-silhouette .invite-shell {
                padding: 14px !important;
            }

            .classic-letter-silhouette .page-section {
                padding: 92px 38px !important;
            }

            .cl-hero-section {
                padding-bottom: 220px !important;
            }

            .cl-hero-grid,
            .cl-cover-layout,
            .cl-detail-layout {
                grid-template-columns: 1fr !important;
                gap: 34px !important;
                text-align: center !important;
            }

            .cl-hero-copy,
            .cl-detail-main-card {
                text-align: center !important;
            }

            .cl-hero-date,
            .cl-hero-actions,
            .cl-detail-actions {
                margin-left: auto;
                margin-right: auto;
                justify-content: center;
            }

            .cl-couple-stage {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            .cl-couple-symbol {
                margin: -8px auto !important;
            }

            .cl-cover-photo-card {
                width: min(100%, 430px);
                margin: 0 auto;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .classic-letter-silhouette .invite-shell {
                padding: 0 !important;
            }

            .classic-letter-silhouette .paper-wrap {
                border-radius: 0 !important;
                box-shadow: none !important;
            }

            .classic-letter-silhouette .page-section {
                padding: 78px 22px !important;
            }

            .cl-hero-section {
                min-height: 100svh !important;
                padding-top: 84px !important;
                padding-bottom: 190px !important;
            }

            .cl-hero-title {
                font-size: clamp(3.2rem, 15vw, 5.2rem);
                text-align: center;
            }

            .cl-letter-panel {
                padding: 10px;
                border-radius: 34px;
            }

            .cl-letter-panel-inner {
                min-height: auto;
                padding: 38px 22px;
                border-radius: 26px;
            }

            .cl-wax-seal {
                width: 126px;
                height: 126px;
            }

            .cl-hero-bottom-floral {
                left: -28%;
                width: 156%;
                height: 210px;
                opacity: .28;
            }

            .cl-section-title {
                font-size: clamp(2.8rem, 13vw, 4.6rem);
            }

            .cl-cover-info-card,
            .cl-detail-main-card {
                padding: 32px 20px;
                border-radius: 32px;
            }

            .cl-cover-photo-card {
                min-height: 430px;
                border-radius: 999px 999px 34px 34px;
            }

            .cl-cover-photo-card img,
            .cl-cover-placeholder {
                min-height: 398px;
            }

            .classic-letter-silhouette .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            .cl-person-lux-card {
                min-height: auto;
                padding: 34px 20px;
                border-radius: 34px;
            }

            .cl-person-photo-wrap {
                width: 150px;
                height: 184px;
            }

            .cl-detail-item {
                grid-template-columns: 40px 1fr;
                text-align: left;
            }

            .cl-detail-item span {
                width: 40px;
                height: 40px;
            }

            .cl-map-lux-card .map-placeholder {
                min-height: 320px;
            }

            .cl-primary-btn,
            .cl-secondary-btn {
                width: 100%;
            }

            .classic-letter-silhouette .classic-flower-top-left {
                width: 260px !important;
                top: -48px !important;
                left: -130px !important;
                opacity: .22 !important;
            }

            .classic-letter-silhouette .classic-flower-top-right {
                width: 260px !important;
                top: 84px !important;
                right: -136px !important;
                opacity: .20 !important;
            }
        }

        /* Matikan floral lama berbasis pseudo-element */
        .classic-letter-silhouette #opening::after {
            content: none !important;
            display: none !important;
            background: none !important;
        }

        /* Pastikan floral baru yang aktif */
        .classic-letter-silhouette .cl-hero-bottom-floral {
            display: block !important;
            position: absolute !important;
            left: -9% !important;
            right: auto !important;
            bottom: 0 !important;
            width: 118% !important;
            height: 290px !important;
            opacity: .32 !important;
            z-index: 1 !important;
            pointer-events: none !important;
            background:
                url("{{ asset('assets/classic-letter/classic-floral-bottom.png') }}") center bottom / 100% auto no-repeat !important;
        }

        @media (max-width: 640px) {
            .classic-letter-silhouette .cl-hero-bottom-floral {
                left: -28% !important;
                width: 156% !important;
                height: 210px !important;
                opacity: .28 !important;
            }
        }

        /* =====================================================
        DETAIL MAP + LONG ADDRESS FIX
        ===================================================== */

        .classic-letter-silhouette .cl-address-text,
        .classic-letter-silhouette .cl-map-address,
        .classic-letter-silhouette .cl-map-title {
            display: block !important;
            max-width: 100% !important;
            white-space: pre-line !important;
            overflow-wrap: anywhere !important;
            word-break: break-word !important;
            line-height: 1.75 !important;
        }

        .classic-letter-silhouette .cl-detail-address-item {
            align-items: flex-start !important;
        }

        .classic-letter-silhouette .cl-detail-address-item > span {
            margin-top: 2px !important;
        }

        .classic-letter-silhouette .cl-map-lux-card {
            display: flex !important;
            flex-direction: column !important;
            min-height: 520px !important;
            overflow: hidden !important;
        }

        .classic-letter-silhouette .cl-map-iframe {
            width: 100% !important;
            height: 430px !important;
            border: 0 !important;
            display: block !important;
            filter: saturate(.92) contrast(.96);
            background: #eef0f2 !important;
        }

        .classic-letter-silhouette .cl-map-footer {
            padding: 24px 28px !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 18px !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,248,238,.72)) !important;
            border-top: 1px solid rgba(130,95,55,.12) !important;
        }

        .classic-letter-silhouette .cl-map-title {
            margin: 0 !important;
            color: var(--theme-dark) !important;
            font-weight: 950 !important;
            font-size: 1.08rem !important;
        }

        .classic-letter-silhouette .cl-map-address {
            margin: 8px 0 0 !important;
            color: #6b625a !important;
            font-size: .94rem !important;
        }

        .classic-letter-silhouette .cl-map-open-btn {
            flex: 0 0 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 44px !important;
            padding: 12px 20px !important;
            border-radius: 999px !important;
            color: #fffaf0 !important;
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary)) !important;
            font-weight: 900 !important;
            text-decoration: none !important;
            box-shadow: 0 14px 34px color-mix(in srgb, var(--theme-primary) 22%, transparent) !important;
        }

        @media (max-width: 640px) {
            .classic-letter-silhouette .cl-map-lux-card {
                min-height: auto !important;
            }

            .classic-letter-silhouette .cl-map-iframe {
                height: 320px !important;
            }

            .classic-letter-silhouette .cl-map-footer {
                flex-direction: column !important;
                align-items: stretch !important;
                padding: 20px !important;
            }

            .classic-letter-silhouette .cl-map-open-btn {
                width: 100% !important;
            }
        }

        /* =====================================================
        GOOGLE MAPS EMBED FIX - USE EDITOR GMAPS LINK
        ===================================================== */

        .classic-letter-silhouette .cl-detail-layout {
            align-items: stretch !important;
        }

        .classic-letter-silhouette .cl-map-lux-card {
            display: grid !important;
            grid-template-rows: minmax(420px, 1fr) auto !important;
            min-height: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
            background: rgba(255,255,255,.92) !important;
        }

        .classic-letter-silhouette .cl-map-iframe {
            width: 100% !important;
            height: 100% !important;
            min-height: 420px !important;
            border: 0 !important;
            display: block !important;
            background: #eef0f2 !important;
        }

        .classic-letter-silhouette .cl-map-placeholder-clean {
            height: 100% !important;
            min-height: 420px !important;
        }

        .classic-letter-silhouette .cl-map-footer {
            padding: 22px 26px !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 18px !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.96), rgba(255,248,238,.78)) !important;
            border-top: 1px solid rgba(130,95,55,.12) !important;
        }

        .classic-letter-silhouette .cl-map-title,
        .classic-letter-silhouette .cl-map-address,
        .classic-letter-silhouette .cl-address-text {
            display: block !important;
            max-width: 100% !important;
            white-space: pre-line !important;
            overflow-wrap: anywhere !important;
            word-break: break-word !important;
        }

        .classic-letter-silhouette .cl-map-title {
            margin: 0 !important;
            color: var(--theme-dark) !important;
            font-weight: 950 !important;
            font-size: 1.05rem !important;
            line-height: 1.45 !important;
        }

        .classic-letter-silhouette .cl-map-address {
            margin: 8px 0 0 !important;
            color: #6b625a !important;
            font-size: .92rem !important;
            line-height: 1.7 !important;
        }

        .classic-letter-silhouette .cl-map-open-btn {
            flex: 0 0 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 44px !important;
            padding: 12px 20px !important;
            border-radius: 999px !important;
            color: #fffaf0 !important;
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary)) !important;
            font-weight: 900 !important;
            text-decoration: none !important;
            box-shadow: 0 14px 34px color-mix(in srgb, var(--theme-primary) 22%, transparent) !important;
        }

        .classic-letter-silhouette .cl-detail-address-item {
            align-items: flex-start !important;
        }

        .classic-letter-silhouette .cl-detail-address-item > span {
            margin-top: 2px !important;
        }

        @media (max-width: 980px) {
            .classic-letter-silhouette .cl-map-lux-card {
                grid-template-rows: 420px auto !important;
                height: auto !important;
                min-height: auto !important;
            }
        }

        @media (max-width: 640px) {
            .classic-letter-silhouette .cl-map-lux-card {
                grid-template-rows: 320px auto !important;
            }

            .classic-letter-silhouette .cl-map-iframe,
            .classic-letter-silhouette .cl-map-placeholder-clean {
                min-height: 320px !important;
            }

            .classic-letter-silhouette .cl-map-footer {
                flex-direction: column !important;
                align-items: stretch !important;
                padding: 20px !important;
            }

            .classic-letter-silhouette .cl-map-open-btn {
                width: 100% !important;
            }
        }

        /* =====================================================
        RSVP FORM LABEL LEFT ALIGN FIX
        Label Nama, Kehadiran, Jumlah Tamu, Pesan dibuat rata kiri
        ===================================================== */

        .classic-letter-silhouette #rsvp form,
        .classic-letter-silhouette #rsvp .section-card,
        .classic-letter-silhouette #message form,
        .classic-letter-silhouette #message .section-card,
        .classic-letter-silhouette #messages form,
        .classic-letter-silhouette #messages .section-card {
            text-align: left !important;
        }

        .classic-letter-silhouette #rsvp label,
        .classic-letter-silhouette #message label,
        .classic-letter-silhouette #messages label {
            display: block !important;
            width: 100% !important;
            margin-bottom: 8px !important;
            text-align: left !important;
            color: #4b5563 !important;
            font-weight: 800 !important;
            letter-spacing: .02em !important;
        }

        .classic-letter-silhouette #rsvp input,
        .classic-letter-silhouette #rsvp select,
        .classic-letter-silhouette #rsvp textarea,
        .classic-letter-silhouette #message input,
        .classic-letter-silhouette #message select,
        .classic-letter-silhouette #message textarea,
        .classic-letter-silhouette #messages input,
        .classic-letter-silhouette #messages select,
        .classic-letter-silhouette #messages textarea {
            text-align: left !important;
        }

        .classic-letter-silhouette #rsvp .uk-label,
        .classic-letter-silhouette #message .uk-label,
        .classic-letter-silhouette #messages .uk-label {
            text-align: left !important;
        }

        /* Judul section tetap center */
        .classic-letter-silhouette #rsvp > h2,
        .classic-letter-silhouette #message > h2,
        .classic-letter-silhouette #messages > h2,
        .classic-letter-silhouette #rsvp .cl-section-heading,
        .classic-letter-silhouette #message .cl-section-heading,
        .classic-letter-silhouette #messages .cl-section-heading {
            text-align: center !important;
        }

        .classic-letter-silhouette .cl-rsvp-section form,
        .classic-letter-silhouette .cl-rsvp-section .section-card {
            text-align: left !important;
        }

        .classic-letter-silhouette .cl-rsvp-section label {
            display: block !important;
            width: 100% !important;
            margin-bottom: 8px !important;
            text-align: left !important;
            font-weight: 800 !important;
        }

        .classic-letter-silhouette .cl-rsvp-section input,
        .classic-letter-silhouette .cl-rsvp-section select,
        .classic-letter-silhouette .cl-rsvp-section textarea {
            text-align: left !important;
        }

        .classic-letter-silhouette .cl-rsvp-section h2 {
            text-align: center !important;
        }

        /* =====================================================
        CLASSIC LETTER HERO MOBILE PREMIUM FIX
        Hero mobile dibuat lebih ramai, rapi, lembut, dan tidak kaku
        ===================================================== */

        @media (max-width: 640px) {
            .classic-letter-silhouette .cl-hero-section {
                min-height: 100svh !important;
                padding: 58px 18px 210px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                overflow: hidden !important;
            }

            .classic-letter-silhouette .cl-hero-section::before {
                content: "" !important;
                position: absolute !important;
                inset: 14px !important;
                border-radius: 34px !important;
                border: 1px solid rgba(130,95,55,.14) !important;
                background:
                    radial-gradient(circle at 50% 8%, rgba(255,255,255,.75), transparent 34%),
                    radial-gradient(circle at 18% 26%, color-mix(in srgb, var(--theme-primary) 8%, transparent), transparent 24%),
                    radial-gradient(circle at 88% 42%, color-mix(in srgb, var(--theme-secondary) 8%, transparent), transparent 26%) !important;
                opacity: 1 !important;
                pointer-events: none !important;
                z-index: 0 !important;
            }

            .classic-letter-silhouette .cl-hero-section::after {
                content: "" !important;
                position: absolute !important;
                left: 50% !important;
                top: 28px !important;
                width: 82% !important;
                height: 120px !important;
                transform: translateX(-50%) !important;
                opacity: .24 !important;
                pointer-events: none !important;
                z-index: 1 !important;
                background:
                    url("{{ asset('assets/classic-letter/classic-floral-bottom.png') }}") center top / contain no-repeat !important;
            }

            .classic-letter-silhouette .cl-hero-grid {
                width: 100% !important;
                max-width: 420px !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 22px !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                margin: 0 auto !important;
                position: relative !important;
                z-index: 4 !important;
            }

            .classic-letter-silhouette .cl-hero-copy {
                width: 100% !important;
                padding: 0 !important;
                text-align: center !important;
            }

            .classic-letter-silhouette .cl-kicker {
                padding: 8px 16px !important;
                border-radius: 999px !important;
                background: rgba(255,255,255,.68) !important;
                border: 1px solid rgba(130,95,55,.13) !important;
                box-shadow: 0 12px 30px rgba(68,45,35,.06) !important;
                font-size: 10px !important;
                letter-spacing: .24em !important;
            }

            .classic-letter-silhouette .cl-kicker::before,
            .classic-letter-silhouette .cl-kicker::after {
                width: 24px !important;
            }

            .classic-letter-silhouette .cl-hero-title {
                margin-top: 28px !important;
                font-size: clamp(4.1rem, 18vw, 6.2rem) !important;
                line-height: .86 !important;
                letter-spacing: -.07em !important;
                text-align: center !important;
                text-shadow: 0 14px 34px rgba(68,45,35,.08) !important;
            }

            .classic-letter-silhouette .cl-hero-subtitle {
                width: fit-content !important;
                min-width: 160px !important;
                margin: 24px auto 0 !important;
                padding: 9px 18px !important;
                color: #766b61 !important;
                font-size: .98rem !important;
                line-height: 1.4 !important;
            }

            .classic-letter-silhouette .cl-hero-date {
                width: min(100%, 230px) !important;
                margin: 24px auto 0 !important;
                padding: 17px 18px !important;
                text-align: center !important;
            }

            .classic-letter-silhouette .cl-hero-date span {
                font-size: 1.05rem !important;
                letter-spacing: .02em !important;
            }

            .classic-letter-silhouette .cl-hero-date small {
                margin-top: 9px !important;
                font-size: .86rem !important;
            }

            .classic-letter-silhouette .cl-hero-actions {
                width: 100% !important;
                margin-top: 28px !important;
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .classic-letter-silhouette .cl-primary-btn,
            .classic-letter-silhouette .cl-secondary-btn {
                width: 100% !important;
                min-height: 54px !important;
                border-radius: 999px !important;
                font-size: .98rem !important;
            }

            .classic-letter-silhouette .cl-secondary-btn {
                background: rgba(255,255,255,.78) !important;
            }

            /* Panel kanan di mobile dijadikan kartu kecil, bukan layout desktop */
            .classic-letter-silhouette .cl-letter-panel {
                width: min(100%, 330px) !important;
                margin: 22px auto 0 !important;
                padding: 10px !important;
                border-radius: 30px !important;
                display: block !important;
            }

            /*
            Jika ingin kartu "Kepada Yth" tetap muncul di hero mobile,
            ganti display none di atas menjadi display block.
            */
        }

        /* =====================================================
        HERO MOBILE ORNAMENT ENHANCEMENT
        ===================================================== */

        @media (max-width: 640px) {
            .classic-letter-silhouette .classic-flower-top-left {
                width: 310px !important;
                top: -76px !important;
                left: -168px !important;
                opacity: .32 !important;
                transform: rotate(-12deg) !important;
                z-index: 1 !important;
            }

            .classic-letter-silhouette .classic-flower-top-right {
                width: 320px !important;
                top: 132px !important;
                right: -178px !important;
                opacity: .30 !important;
                transform: rotate(10deg) !important;
                z-index: 1 !important;
            }

            .classic-letter-silhouette .classic-flower-middle-left {
                width: 260px !important;
                top: 48% !important;
                left: -158px !important;
                opacity: .18 !important;
                transform: rotate(-20deg) !important;
            }

            .classic-letter-silhouette .classic-flower-middle-right {
                width: 270px !important;
                top: 60% !important;
                right: -165px !important;
                opacity: .20 !important;
                transform: rotate(18deg) !important;
            }

            .classic-letter-silhouette .cl-hero-bottom-floral {
                left: -42% !important;
                bottom: 0 !important;
                width: 184% !important;
                height: 260px !important;
                opacity: .34 !important;
                background-size: 100% auto !important;
                background-position: center bottom !important;
                z-index: 1 !important;
            }
        }

    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'maroon';

    $themes = [
        'maroon' => [
            'primary' => '#5c123f',
            'secondary' => '#8d2c63',
            'tertiary' => '#0f4c45',
            'quaternary' => '#0c3d38',
            'dark' => '#3b2a22',
            'soft' => '#fffaf5',
            'paper' => '#fffdf8',
            'body1' => 'rgba(92, 18, 63, .15)',
            'body2' => 'rgba(15, 76, 69, .10)',
        ],
        'emerald' => [
            'primary' => '#0f4c45',
            'secondary' => '#1f7a68',
            'tertiary' => '#0f4c45',
            'quaternary' => '#0c3d38',
            'dark' => '#243b35',
            'soft' => '#f4fffb',
            'paper' => '#fbfffd',
            'body1' => 'rgba(15, 76, 69, .16)',
            'body2' => 'rgba(31, 122, 104, .10)',
        ],
        'navy' => [
            'primary' => '#1e293b',
            'secondary' => '#475569',
            'tertiary' => '#334155',
            'quaternary' => '#1e293b',
            'dark' => '#172033',
            'soft' => '#f8fafc',
            'paper' => '#ffffff',
            'body1' => 'rgba(30, 41, 59, .14)',
            'body2' => 'rgba(71, 85, 105, .10)',
        ],
        'rose' => [
            'primary' => '#be3b63',
            'secondary' => '#f06292',
            'tertiary' => '#be3b63',
            'quaternary' => '#9f2f52',
            'dark' => '#4a2433',
            'soft' => '#fff7fa',
            'paper' => '#fffafb',
            'body1' => 'rgba(190, 59, 99, .14)',
            'body2' => 'rgba(240, 98, 146, .10)',
        ],
        'gold' => [
            'primary' => '#9a6b16',
            'secondary' => '#d6a43a',
            'tertiary' => '#9a6b16',
            'quaternary' => '#7d5511',
            'dark' => '#4a3511',
            'soft' => '#fffaf0',
            'paper' => '#fffdf7',
            'body1' => 'rgba(154, 107, 22, .15)',
            'body2' => 'rgba(214, 164, 58, .10)',
        ],
        'slate' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'tertiary' => '#334155',
            'quaternary' => '#1e293b',
            'dark' => '#1e293b',
            'soft' => '#f8fafc',
            'paper' => '#ffffff',
            'body1' => 'rgba(51, 65, 85, .13)',
            'body2' => 'rgba(100, 116, 139, .09)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['maroon'];

    $firstPhoto = $invitation->photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Acara';
    $eventName = $invitation->event_name ?: 'Acara';
    $hostName = $invitation->host_name ?: null;

    if ($invitation->event_date) {
        $startDate = \Carbon\Carbon::parse($invitation->event_date);

        if ($invitation->event_end_date) {
            $endDate = \Carbon\Carbon::parse($invitation->event_end_date);

            if ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                // Contoh: 06-15 Mei 2026
                $eventDateText = $startDate->translatedFormat('d') . '-' . $endDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                // Contoh: 30 Mei - 02 Jun 2026
                $eventDateText = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
            } else {
                // Contoh: 30 Des 2026 - 02 Jan 2027
                $eventDateText = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
            }
        } else {
            // Contoh: 06 Mei 2026
            $eventDateText = $startDate->translatedFormat('d M Y');
        }
    } else {
        $eventDateText = 'Tanggal belum diatur';
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: null;

    $addressText = trim($invitation->address ?? '');

    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    | Jangan generate iframe dari link pendek maps.app.goo.gl.
    | Link pendek aman untuk tombol Buka Maps, tetapi sering meleset jika dipaksa
    | menjadi iframe.
    */
    $mapOpenUrl = isset($mapData)
        ? ($mapData['open_url'] ?? $invitation->maps_url)
        : $invitation->maps_url;

    $mapEmbedUrl = isset($mapData)
        ? ($mapData['embed_url'] ?? null)
        : null;

    $shareMessage =
        "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) {
        $shareMessage .= "Diselenggarakan oleh: {$hostName}\n";
    }

    $shareMessage .= "Tanggal: {$eventDateText}\n";

    if ($eventTimeText) {
        $shareMessage .= "Waktu: {$eventTimeText}\n";
    }

    if ($locationText) {
        $shareMessage .= "Tempat: {$locationText}\n";
    }

    $shareMessage .=
        "\nSilakan buka undangan lengkap melalui link berikut:\n" .
        $shareUrl .
        "\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\n" .
        "Wassalamu'alaikum Wr. Wb.";

    $shareText = urlencode($shareMessage);

    $countdownTarget = null;

    if ($invitation->event_date) {
        $datePart = $invitation->event_date->format('Y-m-d');
        $timePart = '00:00:00';

        if (!empty($invitation->event_time)) {
            try {
                $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s');
            } catch (\Exception $e) {
                $timePart = '00:00:00';
            }
        }

        $countdownTarget = $datePart . 'T' . $timePart;
    }
    $googleCalendarUrl = null;

    if ($invitation->event_date) {
        try {
            $startDate = $invitation->event_date->format('Y-m-d');
            $startTime = !empty($invitation->event_time)
                ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s')
                : '00:00:00';

            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);

            if ($invitation->event_end_date) {
                $endDate = $invitation->event_end_date->format('Y-m-d');
            } else {
                $endDate = $startDate;
            }

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(2);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(2);
            }

            $calendarTitle = trim(($invitation->event_name ?: $invitation->category->name) . ' - ' . $invitation->title);

            $calendarDetails = trim(
                ($invitation->description ?: 'Undangan acara') .
                "\n\nLink Undangan: " .
                route('invitation.public', $invitation->slug)
            );

            $calendarLocation = trim(
                ($invitation->location_name ?: '') .
                ($invitation->address ? ' - ' . $invitation->address : '')
            );

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) {
            $googleCalendarUrl = null;
        }
    }
@endphp

<body class="text-slate-900 classic-letter-silhouette"
      style="
        --theme-primary: {{ $activeTheme['primary'] }};
        --theme-secondary: {{ $activeTheme['secondary'] }};
        --theme-tertiary: {{ $activeTheme['tertiary'] }};
        --theme-quaternary: {{ $activeTheme['quaternary'] }};
        --theme-dark: {{ $activeTheme['dark'] }};
        --theme-soft: {{ $activeTheme['soft'] }};
        --theme-paper: {{ $activeTheme['paper'] }};
        --theme-body-1: {{ $activeTheme['body1'] }};
        --theme-body-2: {{ $activeTheme['body2'] }};
      ">

    <main class="invite-shell">
        <div class="floating-actions">
            {{-- Bagikan --}}
            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                <img src="{{ asset('assets/icons/paperlane.png') }}"
                    alt="Bagikan"
                    class="floating-icon">
            </a>

            {{-- Music On / Off --}}
            <button type="button"
                    id="music-toggle"
                    class="floating-action-button"
                    title="Music">
                <img src="{{ asset('assets/icons/music-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                    alt="Music"
                    class="floating-icon">
            </button>

            {{-- Auto Scroll On / Off --}}
            <button type="button"
                    id="scroll-toggle"
                    class="floating-action-button"
                    title="Auto Scroll">
                <img src="{{ asset('assets/icons/scroll-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                    alt="Auto Scroll"
                    class="floating-icon">
            </button>

            {{-- Lokasi --}}
            @if ($invitation->maps_url)
                <a href="{{ $invitation->maps_url }}" target="_blank" title="Lokasi">
                    <img src="{{ asset('assets/icons/map.png') }}"
                        alt="Lokasi"
                        class="floating-icon">
                </a>
             @endif
        </div>

            <audio id="invitation-music"
                src="{{ asset('assets/music/background1.mp3') }}"
                preload="auto"
                loop>
            </audio>

        <div class="paper-wrap">
            <div class="decorative-bg classic-letter-decor" aria-hidden="true">
                <img src="{{ asset('assets/classic-letter/classic-floral-corner-gold.png') }}"
                        class="classic-flower classic-flower-top-left"
                        alt="">

                <img src="{{ asset('assets/classic-letter/classic-floral-corner-gold-mirror.png') }}"
                        class="classic-flower classic-flower-top-right"
                        alt="">

                <img src="{{ asset('assets/classic-letter/classic-floral-corner-gold.png') }}"
                        class="classic-flower classic-flower-middle-left"
                        alt="">

                <img src="{{ asset('assets/classic-letter/classic-floral-corner-gold-mirror.png') }}"
                        class="classic-flower classic-flower-middle-right"
                        alt="">
            </div>

            {{-- OPENING / HERO --}}
            <section id="opening" class="page-section cl-hero-section">
                <div class="cl-hero-floral cl-hero-floral-left"></div>
                <div class="cl-hero-floral cl-hero-floral-right"></div>

                <div class="cl-hero-grid">
                    <div class="cl-hero-copy">
                        <p class="cl-kicker">Undangan Digital</p>

                        <h1 class="cl-hero-title responsive-text">
                            {{ $invitation->title }}
                        </h1>

                        <p class="cl-hero-subtitle responsive-text">
                            {{ $invitation->event_name ?: $invitation->category->name }}
                        </p>

                        <div class="cl-hero-date">
                            <span>{{ $eventDateText }}</span>
                            @if ($eventTimeText)
                                <small>Pukul {{ $eventTimeText }}</small>
                            @endif
                        </div>

                        <div class="cl-hero-actions">
                            <a href="#cover" class="cl-primary-btn">
                                Buka Undangan
                            </a>

                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="cl-secondary-btn">
                                    Simpan Tanggal
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="cl-letter-panel">
                        <div class="cl-letter-panel-inner">
                            <p class="cl-letter-small">Kepada Yth.</p>
                            <h2>Tamu Undangan</h2>
                            <p class="responsive-text">
                                {{ $invitation->description ?: 'Dengan hormat kami mengundang Anda untuk hadir dalam momen bahagia ini.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="cl-hero-bottom-floral"></div>
            </section>

            {{-- COVER --}}
            <section id="cover" class="page-section cl-cover-section">
                <div class="cl-section-heading">
                    <p class="cl-kicker">The Wedding Of</p>
                    <h2 class="cl-section-title responsive-text">{{ $invitation->title }}</h2>
                </div>

                <div class="cl-cover-layout">
                    <div class="cl-cover-photo-card">
                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Undangan">
                        @else
                            <div class="cl-cover-placeholder">
                                {{ \Illuminate\Support\Str::substr($invitation->title ?: 'CL', 0, 2) }}
                            </div>
                        @endif
                    </div>

                    <div class="cl-cover-info-card">
                        <span class="cl-event-badge">{{ $invitation->category->name }}</span>

                        @if ($invitation->event_name && $invitation->event_name !== $invitation->category->name)
                            <p class="cl-cover-event responsive-text">{{ $invitation->event_name }}</p>
                        @endif

                        <h3 class="cl-script-title">Save The Date</h3>

                        <div class="cl-date-box">
                            <strong>{{ $eventDateText }}</strong>
                            @if ($eventTimeText)
                                <span>Pukul {{ $eventTimeText }}</span>
                            @endif
                            @if ($locationText)
                                <span>{{ $locationText }}</span>
                            @endif
                        </div>

                        <div class="cl-countdown-wrap">
                            <div class="countdown-grid"
                                @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card">
                                    <span class="countdown-number" id="countdown-days">00</span>
                                    <span class="countdown-label">Hari</span>
                                </div>

                                <div class="countdown-card">
                                    <span class="countdown-number" id="countdown-hours">00</span>
                                    <span class="countdown-label">Jam</span>
                                </div>

                                <div class="countdown-card">
                                    <span class="countdown-number" id="countdown-minutes">00</span>
                                    <span class="countdown-label">Menit</span>
                                </div>

                                <div class="countdown-card">
                                    <span class="countdown-number" id="countdown-seconds">00</span>
                                    <span class="countdown-label">Detik</span>
                                </div>
                            </div>
                        </div>

                        <a href="#intro" class="cl-text-link">Lihat Mempelai ↓</a>
                    </div>
                </div>
            </section>

            {{-- MEMPELAI --}}
            <section id="intro" class="page-section cl-couple-section">
                <div class="cl-section-heading">
                    <p class="cl-kicker">Bride & Groom</p>
                    <h2 class="cl-section-title responsive-text">Mempelai</h2>
                    <p class="cl-section-desc">
                        Dengan penuh rasa syukur, kami memperkenalkan kedua mempelai yang akan memulai perjalanan baru bersama.
                    </p>
                </div>

                @if ($invitation->people->count() >= 2)
                    @php
                        $people = $invitation->people->take(2)->values();
                    @endphp

                    <div class="cl-couple-stage">
                        <div class="cl-person-lux-card">
                            <div class="cl-person-photo-wrap">
                                @if ($people[0]->photo)
                                    <img src="{{ asset('storage/' . $people[0]->photo) }}" alt="{{ $people[0]->name }}">
                                @else
                                    <div class="cl-person-initial">
                                        {{ \Illuminate\Support\Str::substr($people[0]->name ?: 'A', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="cl-person-content">
                                <span>{{ $people[0]->subtitle ?: 'Mempelai Wanita' }}</span>
                                <h3 class="responsive-text">{{ $people[0]->name ?: 'Nama belum diisi' }}</h3>

                                @if ($people[0]->family_name)
                                    <p class="responsive-text">{{ $people[0]->family_name }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="cl-couple-symbol">
                            <span>&</span>
                        </div>

                        <div class="cl-person-lux-card">
                            <div class="cl-person-photo-wrap">
                                @if ($people[1]->photo)
                                    <img src="{{ asset('storage/' . $people[1]->photo) }}" alt="{{ $people[1]->name }}">
                                @else
                                    <div class="cl-person-initial">
                                        {{ \Illuminate\Support\Str::substr($people[1]->name ?: 'B', 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="cl-person-content">
                                <span>{{ $people[1]->subtitle ?: 'Mempelai Pria' }}</span>
                                <h3 class="responsive-text">{{ $people[1]->name ?: 'Nama belum diisi' }}</h3>

                                @if ($people[1]->family_name)
                                    <p class="responsive-text">{{ $people[1]->family_name }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="cl-empty-card">
                        Data mempelai belum ditambahkan.
                    </div>
                @endif
            </section>

            {{-- DETAIL ACARA --}}
            <section id="detail" class="page-section cl-detail-section">
                <div class="cl-section-heading">
                    <p class="cl-kicker">Wedding Detail</p>
                    <h2 class="cl-section-title responsive-text">Detail Acara</h2>
                </div>

                <div class="cl-detail-layout">
                    <div class="cl-detail-main-card">
                        <h3>Acara Pernikahan</h3>

                        <div class="cl-detail-list">
                            <div class="cl-detail-item">
                                <span><img src="{{ asset('assets/icons/Tanggal.png') }}" alt="alamat" class="w-6 h-6"></span>
                                <div>
                                    <small>Tanggal</small>
                                    <strong>{{ $eventDateText }}</strong>
                                </div>
                            </div>

                            @if ($eventTimeText)
                                <div class="cl-detail-item">
                                    <span><img src="{{ asset('assets/icons/Waktu.png') }}" alt="alamat" class="w-6 h-6"></span>
                                    <div>
                                        <small>Waktu</small>
                                        <strong>Pukul {{ $eventTimeText }}</strong>
                                    </div>
                                </div>
                            @endif

                            @if ($locationText)
                                <div class="cl-detail-item">
                                    <span><img src="{{ asset('assets/icons/Lokasi.png') }}" alt="alamat" class="w-6 h-6"></span>
                                    <div>
                                        <small>Tempat</small>
                                        <strong>{{ $locationText }}</strong>
                                    </div>
                                </div>
                            @endif

                            @if ($invitation->address)
                                <div class="cl-detail-item cl-detail-address-item">
                                    <span><img src="{{ asset('assets/icons/Peta.png') }}" alt="alamat" class="w-6 h-6"></span>
                                    <div>
                                        <small>Alamat</small>
                                        <strong class="cl-address-text responsive-text">
                                            {!! nl2br(e($invitation->address)) !!}
                                        </strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="cl-detail-actions">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="cl-primary-btn">
                                    Tambah ke Kalender
                                </a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="cl-secondary-btn">
                                    Buka Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($mapOpenUrl)
                        <div class="cl-map-lux-card">
                            @if ($mapEmbedUrl)
                                <iframe
                                    src="{{ $mapEmbedUrl }}"
                                    class="cl-map-iframe"
                                    loading="lazy"
                                    allowfullscreen
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @else
                                <a href="{{ $mapOpenUrl }}"
                                target="_blank"
                                class="map-placeholder cl-map-placeholder-clean"
                                aria-label="Buka lokasi di Google Maps">
                                    <div>
                                        <div class="map-pin">📍</div>

                                        <p class="map-footer-title responsive-text">
                                            {{ $locationText ?: 'Lokasi Acara' }}
                                        </p>

                                        <p class="map-footer-desc responsive-text">
                                            Klik area ini untuk membuka lokasi asli di Google Maps.
                                        </p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </section>

            {{-- STORY --}}
            <section id="story" class="page-section text-center">
                <div class="detail-icon-circle mx-auto w-28 h-28 rounded-full flex items-center justify-center shadow-md">
                        <img src="{{ asset('assets/icons/Buku.png') }}"
                            alt="Our Story"
                            class="w-28 h-28 object-contain">
                    </div>

                <h2 class="section-title text-4xl md:text-5xl font-black mt-6">
                    Our Story
                </h2>

                <p class="text-slate-500 mt-2">
                    Cerita singkat acara kami
                </p>

                <div class="section-card mt-8 overflow-hidden p-0 max-w-2xl mx-auto">
                    @if ($firstPhoto)
                        <img src="{{ asset('storage/' . $firstPhoto->image_path) }}"
                             class="w-full h-80 object-cover"
                             alt="Story">
                    @elseif ($invitation->cover_image)
                        <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                             class="w-full h-80 object-cover"
                             alt="Story">
                    @else
                        <div class="w-full h-80 bg-gradient-to-br from-purple-100 to-pink-100"></div>
                    @endif

                    <div class="p-7">
                        <p class="font-black text-[#3b2a22]">
                            Perjalanan Momen Ini
                        </p>

                        <p class="text-slate-600 mt-4 leading-8">
                            Setiap acara memiliki cerita. Terima kasih sudah menjadi bagian dari momen istimewa ini.
                        </p>
                    </div>
                </div>
            </section>

            {{-- GALERI --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="page-section compact text-center">
                    <h2 class="section-title text-4xl md:text-5xl font-black">
                        Galeri
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Album foto
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mt-10 max-w-4xl mx-auto">
                        @foreach ($invitation->photos as $photo)
                            <div class="photo-polaroid">
                                <img src="{{ asset('storage/' . $photo->image_path) }}"
                                     class="w-full h-44 object-cover rounded"
                                     alt="Galeri Foto">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- AMPLOP DIGITAL --}}
            <section id="gift" class="page-section compact text-center">
                <div class="detail-icon-circle mx-auto w-28 h-28 rounded-full flex items-center justify-center shadow-md">
                        <img src="{{ asset('assets/icons/Amplop.png') }}"
                            alt="Amplop Digital"
                            class="w-28 h-28 object-contain">
                    </div>

                <h2 class="section-title text-3xl md:text-4xl font-black mt-4">
                    Amplop Digital
                </h2>

                <p class="text-slate-600 mt-5 leading-8 max-w-xl mx-auto">
                    Bagi yang ingin mengirimkan tanda kasih, dapat melalui informasi berikut.
                </p>

                <div class="mt-8 space-y-4 max-w-2xl mx-auto">
                    @forelse ($invitation->gifts as $gift)
                        <div class="section-card flex items-center justify-between gap-4 text-left">
                            <div>
                                <p class="text-sm text-slate-500">
                                    {{ $gift->label ?: 'Bank / E-wallet' }}
                                </p>

                                <p class="font-black">
                                    {{ $gift->account_number ?: '-' }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    Atas Nama {{ $gift->account_name ?: '-' }}
                                </p>
                            </div>

                            @if ($gift->account_number)
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $gift->account_number }}')"
                                        class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl font-bold">
                                    Salin
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="section-card text-center">
                            <p class="text-slate-500">
                                Informasi amplop digital belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- BUKU TAMU --}}
            <section id="message" class="page-section compact">
                <h2 class="section-title text-4xl md:text-5xl font-black text-center">
                    Kirim Pesan
                </h2>

                <div class="max-w-3xl mx-auto w-full">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mt-6">
                            {{ session('message_success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mt-6">
                            <p class="font-bold">Mohon periksa kembali isian:</p>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('guest-messages.store', $invitation) }}"
                          class="section-card mt-8 space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama"
                                   required>
                        </div>

                        <div>
                            <label class="uk-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="uk-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="uk-label">Jumlah Tamu</label>
                            <input type="number"
                                   name="guest_count"
                                   value="{{ old('guest_count', 1) }}"
                                   min="1"
                                   max="10"
                                   class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Pesan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis pesan..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-[#0f4c45] hover:bg-[#0c3d38] text-white font-black py-3 rounded-xl">
                            Kirim Pesan
                        </button>
                    </form>

                    <div class="mt-10 text-center">
                        <div class="inline-flex items-center gap-3">
                            <div class="w-16 h-px bg-slate-300"></div>
                            <span class="bg-[#0f4c45] text-white px-7 py-2 rounded-full font-black">
                                Kehadiran
                            </span>
                            <div class="w-16 h-px bg-slate-300"></div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-8">
                            <div>
                                <p class="text-3xl font-black">
                                    {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                            </div>

                            <div>
                                <p class="text-3xl font-black">
                                    {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Hadir</p>
                            </div>

                            <div>
                                <p class="text-3xl font-black">
                                    {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Ragu</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="section-card">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-black">{{ $message->guest_name }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="text-xs px-3 py-1 rounded-full bg-purple-100 text-purple-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @empty
                            <div class="section-card text-center">
                                <p class="text-slate-500">
                                    Belum ada pesan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="page-section text-center">
                <p class="text-slate-600 leading-8">
                    Atas kehadiran dan doa restunya kami ucapkan,
                </p>

                <h2 class="script-text text-4xl md:text-5xl font-black text-[#3b2a22] mt-10">
                    Terima Kasih
                </h2>

                <p class="mt-14 text-slate-600">
                    Hormat Kami,
                </p>

                <h3 class="section-title text-4xl md:text-5xl font-black mt-7">
                    {{ $invitation->title }}
                </h3>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');

            if (!countdownContainer) {
                return;
            }

            const targetValue = countdownContainer.getAttribute('data-countdown-target');

            if (!targetValue) {
                return;
            }

            const targetDate = new Date(targetValue);
            const daysEl = document.getElementById('countdown-days');
            const hoursEl = document.getElementById('countdown-hours');
            const minutesEl = document.getElementById('countdown-minutes');
            const secondsEl = document.getElementById('countdown-seconds');
            const noteEl = document.getElementById('countdown-note');

            if (isNaN(targetDate.getTime())) {
                if (noteEl) {
                    noteEl.textContent = 'Format tanggal atau waktu acara belum valid.';
                }
                return;
            }

            function formatNumber(number) {
                return String(number).padStart(2, '0');
            }

            function updateCountdown() {
                const now = new Date();
                let distance = targetDate.getTime() - now.getTime();

                if (distance < 0) {
                    distance = 0;
                }

                const totalSeconds = Math.floor(distance / 1000);
                const days = Math.floor(totalSeconds / (60 * 60 * 24));
                const hours = Math.floor((totalSeconds % (60 * 60 * 24)) / (60 * 60));
                const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
                const seconds = Math.floor(totalSeconds % 60);

                if (daysEl) daysEl.textContent = formatNumber(days);
                if (hoursEl) hoursEl.textContent = formatNumber(hours);
                if (minutesEl) minutesEl.textContent = formatNumber(minutes);
                if (secondsEl) secondsEl.textContent = formatNumber(seconds);

                if (noteEl) {
                    if (distance > 0) {
                        noteEl.textContent = 'Menghitung mundur menuju acara';
                    } else {
                        noteEl.textContent = 'Acara sedang berlangsung atau telah dimulai';
                    }
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });

        document.addEventListener('DOMContentLoaded', function () {
        /*
        |--------------------------------------------------------------------------
        | Music Toggle
        |--------------------------------------------------------------------------
        */
        const musicToggle = document.getElementById('music-toggle');
        const musicAudio = document.getElementById('invitation-music');

        if (musicToggle && musicAudio) {
            const musicIcon = musicToggle.querySelector('img');

            musicToggle.addEventListener('click', async function () {
                try {
                    if (musicAudio.paused) {
                        await musicAudio.play();

                        musicToggle.classList.add('is-active');

                        if (musicIcon) {
                            musicIcon.src = musicIcon.dataset.iconOn;
                        }
                    } else {
                        musicAudio.pause();

                        musicToggle.classList.remove('is-active');

                        if (musicIcon) {
                            musicIcon.src = musicIcon.dataset.iconOff;
                        }
                    }
                } catch (error) {
                    console.log('Audio tidak bisa diputar otomatis sebelum interaksi user.', error);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Auto Scroll Toggle
        |--------------------------------------------------------------------------
        */
        const scrollToggle = document.getElementById('scroll-toggle');

        let autoScrollActive = false;
        let autoScrollFrame = null;
        let scrollSpeed = 1.15;

        function getScroller() {
            return document.scrollingElement || document.documentElement || document.body;
        }

        function updateScrollButton(active) {
            if (!scrollToggle) return;

            const scrollIcon = scrollToggle.querySelector('img');

            if (active) {
                scrollToggle.classList.add('is-active');

                if (scrollIcon && scrollIcon.dataset.iconOn) {
                    scrollIcon.src = scrollIcon.dataset.iconOn;
                }
            } else {
                scrollToggle.classList.remove('is-active');

                if (scrollIcon && scrollIcon.dataset.iconOff) {
                    scrollIcon.src = scrollIcon.dataset.iconOff;
                }

                if (autoScrollFrame) {
                    cancelAnimationFrame(autoScrollFrame);
                    autoScrollFrame = null;
                }
            }
        }

        function autoScrollStep() {
            if (!autoScrollActive) return;

            const scroller = getScroller();
            const maxScroll = scroller.scrollHeight - window.innerHeight;
            const currentScroll = scroller.scrollTop;

            if (currentScroll >= maxScroll - 2) {
                autoScrollActive = false;
                updateScrollButton(false);
                return;
            }

            scroller.scrollTop = currentScroll + scrollSpeed;

            autoScrollFrame = requestAnimationFrame(autoScrollStep);
        }

        if (scrollToggle) {
            scrollToggle.addEventListener('click', function () {
                autoScrollActive = !autoScrollActive;

                updateScrollButton(autoScrollActive);

                if (autoScrollActive) {
                    autoScrollStep();
                }
            });
        }

        window.addEventListener('wheel', function () {
            if (autoScrollActive) {
                autoScrollActive = false;
                updateScrollButton(false);
            }
        }, { passive: true });

        window.addEventListener('touchstart', function () {
            if (autoScrollActive) {
                autoScrollActive = false;
                updateScrollButton(false);
            }
        }, { passive: true });

        /*
        |--------------------------------------------------------------------------
        | Luxury Scroll Reveal
        |--------------------------------------------------------------------------
        */
        const revealElements = document.querySelectorAll(`
            .lux-reveal,

            .cl-section-heading,
            .cl-hero-copy,
            .cl-letter-panel,
            .cl-cover-photo-card,
            .cl-cover-info-card,
            .cl-person-lux-card,
            .cl-couple-symbol,
            .cl-detail-main-card,
            .cl-map-lux-card,

            .page-section > p,
            .page-section > h1,
            .page-section > h2,
            .page-section > h3,
            .section-card,
            .countdown-card,
            .map-card,
            .photo-polaroid,
            .detail-icon-circle
        `);

        revealElements.forEach(function (element, index) {
            element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
        });

        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('lux-show');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.14,
            rootMargin: '0px 0px -60px 0px'
        });

        revealElements.forEach(function (element) {
            revealObserver.observe(element);
        });

        /*
        |--------------------------------------------------------------------------
        | Anti Inspect Ringan Tanpa Notice
        | Aktif untuk public preview dan preview editor iframe
        |--------------------------------------------------------------------------
        */

        /* Blok klik kanan */
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });

        /* Blok select text kecuali input/form */
        document.addEventListener('selectstart', function (event) {
            const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';

            if (!['input', 'textarea', 'select', 'option'].includes(tagName)) {
                event.preventDefault();
            }
        });

        /* Blok drag gambar / teks */
        document.addEventListener('dragstart', function (event) {
            event.preventDefault();
        });

        /* Blok shortcut inspect umum */
        document.addEventListener('keydown', function (event) {
            const key = event.key ? event.key.toLowerCase() : '';

            const blocked =
                event.key === 'F12' ||
                (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) ||
                (event.ctrlKey && ['u', 's', 'p'].includes(key)) ||
                (event.metaKey && event.altKey && ['i', 'j', 'c'].includes(key)) ||
                (event.metaKey && ['u', 's', 'p'].includes(key));

            if (blocked) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        });
    });
    </script>
</body>
</html>
