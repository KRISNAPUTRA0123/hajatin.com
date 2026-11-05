<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Syukuran') . ' ' . ($invitation->title ?: 'Syukuran Warm'));
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
            color: var(--warm-dark);
            background:
                radial-gradient(circle at top left, var(--warm-glow-1), transparent 32%),
                radial-gradient(circle at top right, var(--warm-glow-2), transparent 30%),
                linear-gradient(180deg, #fff8ed 0%, var(--warm-soft) 48%, #ffffff 100%);
        }

        .warm-shell {
            width: min(100%, 1220px);
            margin: 0 auto;
            padding: 22px;
        }

        .warm-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,247,235,.96)),
                radial-gradient(circle at 14% 12%, var(--warm-glow-1), transparent 24%),
                radial-gradient(circle at 84% 20%, var(--warm-glow-2), transparent 24%);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 16%, transparent);
            box-shadow: 0 34px 95px rgba(120, 70, 30, .12);
        }

        .warm-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--warm-primary) 12%, transparent) 1.2px, transparent 1.2px);
            background-size: 26px 26px;
            opacity: .55;
            pointer-events: none;
            z-index: 0;
        }

        .warm-wrap > * {
            position: relative;
            z-index: 1;
        }

        .warm-section {
            min-height: 100vh;
            padding: 90px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .warm-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
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

        .warm-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--warm-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .warm-label::before {
            content: "";
            width: 38px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--warm-primary), var(--warm-accent));
        }

        .warm-title {
            color: var(--warm-dark);
            letter-spacing: -.06em;
            line-height: .96;
            font-weight: 950;
        }

        .warm-gradient-text {
            background: linear-gradient(135deg, var(--warm-dark), var(--warm-primary), var(--warm-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .warm-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--warm-primary), var(--warm-secondary));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--warm-primary) 24%, transparent);
        }

        .warm-btn.secondary {
            background: #ffffff;
            color: var(--warm-dark);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 16%, transparent);
            box-shadow: 0 14px 28px rgba(120, 70, 30, .08);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 60;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 14px 32px rgba(120, 70, 30, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--warm-accent) 34%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .warm-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 28px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.86);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 16px 36px rgba(120, 70, 30, .10);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .warm-nav a {
            text-decoration: none;
            color: var(--warm-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .warm-nav a:hover {
            color: var(--warm-primary);
            background: color-mix(in srgb, var(--warm-primary) 9%, white);
        }

        .hero-layout {
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            gap: 46px;
            align-items: center;
        }

        .hero-photo-card {
            position: relative;
            min-height: 610px;
            border-radius: 44px;
            padding: 18px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--warm-primary) 18%, white), color-mix(in srgb, var(--warm-accent) 28%, white));
            box-shadow: 0 30px 80px rgba(120, 70, 30, .16);
        }

        .hero-photo-inner {
            position: relative;
            min-height: 574px;
            overflow: hidden;
            border-radius: 34px;
            background:
                radial-gradient(circle at 24% 18%, color-mix(in srgb, var(--warm-accent) 28%, transparent), transparent 34%),
                linear-gradient(180deg, #fffaf2, #ffffff);
            border: 2px dashed color-mix(in srgb, var(--warm-primary) 20%, transparent);
        }

        .hero-photo-inner img.cover-main-image {
            width: 100%;
            height: 100%;
            min-height: 574px;
            object-fit: cover;
            display: block;
        }

        .hero-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }

        .hero-placeholder h2 {
            font-size: clamp(2.5rem, 5vw, 4.7rem);
            line-height: .94;
            letter-spacing: -.06em;
            font-weight: 950;
            color: var(--warm-dark);
        }

        .hero-placeholder p {
            color: var(--warm-text);
            margin-top: 16px;
            line-height: 1.8;
        }

        .warm-ornament {
            position: absolute;
            width: 138px;
            height: 138px;
            border-radius: 999px;
            background:
                radial-gradient(circle, color-mix(in srgb, var(--warm-accent) 60%, white) 0%, color-mix(in srgb, var(--warm-accent) 22%, transparent) 62%, transparent 70%);
            pointer-events: none;
            opacity: .8;
            z-index: 2;
        }

        .ornament-one {
            top: -34px;
            right: -18px;
        }

        .ornament-two {
            bottom: -42px;
            left: -28px;
            background:
                radial-gradient(circle, color-mix(in srgb, var(--warm-primary) 42%, white) 0%, color-mix(in srgb, var(--warm-primary) 18%, transparent) 62%, transparent 72%);
        }

        .hero-copy {
            max-width: 690px;
        }

        .warm-chip-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .warm-chip {
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 12px 26px rgba(120, 70, 30, .07);
            color: var(--warm-text);
            font-size: 12px;
            font-weight: 900;
        }

        .warm-stat-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 36px;
        }

        .warm-stat {
            padding: 22px;
            text-align: center;
            border-radius: 28px;
            background: rgba(255,255,255,.86);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 14px 30px rgba(120, 70, 30, .08);
        }

        .warm-stat strong {
            display: block;
            color: var(--warm-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .warm-stat span {
            display: block;
            margin-top: 9px;
            color: var(--warm-text);
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .section-head {
            text-align: center;
        }

        .section-head .desc {
            max-width: 780px;
            margin: 16px auto 0;
            color: var(--warm-text);
            line-height: 1.8;
        }

        .gratitude-grid {
            display: grid;
            gap: 20px;
            margin-top: 38px;
            justify-content: center;
        }

        .gratitude-grid.count-1 {
            grid-template-columns: minmax(280px, 460px);
        }

        .gratitude-grid.count-2 {
            grid-template-columns: repeat(2, minmax(280px, 460px));
        }

        .gratitude-grid.count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .gratitude-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            border-radius: 34px;
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(120, 70, 30, .08);
        }

        .gratitude-card::after {
            content: "";
            position: absolute;
            width: 132px;
            height: 132px;
            right: -46px;
            top: -46px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--warm-accent) 28%, transparent);
        }

        .gratitude-number {
            position: relative;
            z-index: 2;
            width: 46px;
            height: 46px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--warm-primary), var(--warm-secondary));
            margin-bottom: 18px;
        }

        .gratitude-card h3,
        .gratitude-card p {
            position: relative;
            z-index: 2;
        }

        .gratitude-card h3 {
            color: var(--warm-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .gratitude-card p {
            margin-top: 10px;
            color: var(--warm-text);
            line-height: 1.8;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 1fr .92fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .warm-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(120, 70, 30, .08);
            border-radius: 36px;
            padding: 30px;
        }

        .warm-card h3 {
            color: var(--warm-dark);
            font-size: 2rem;
            font-weight: 950;
            margin: 0;
        }

        .detail-list {
            display: grid;
            gap: 14px;
            margin-top: 24px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--warm-primary) 20%, transparent);
        }

        .detail-row .label {
            color: var(--warm-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--warm-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .warm-date-line,
        .warm-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .warm-date-line span,
        .warm-time-line span {
            display: inline;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 20px;
        }

        .countdown-card {
            border-radius: 26px;
            padding: 22px 14px;
            text-align: center;
            background: linear-gradient(180deg, #fffaf2, #ffffff);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--warm-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--warm-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 24px;
            border-radius: 34px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(120, 70, 30, .08);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 320px;
            display: block;
            border: 0;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            color: var(--warm-dark);
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--warm-accent) 24%, transparent), transparent 34%),
                linear-gradient(180deg, #fffaf2, #ffffff);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: .9fr 1.1fr .9fr;
            gap: 18px;
            margin-top: 36px;
        }

        .gallery-card {
            border-radius: 30px;
            overflow: hidden;
            padding: 10px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(120, 70, 30, .08);
        }

        .gallery-card:nth-child(2) {
            transform: translateY(28px);
        }

        .gallery-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            display: block;
            border-radius: 22px;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 460px);
            justify-content: center;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            padding: 26px;
            border-radius: 34px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(120, 70, 30, .08);
        }

        .gift-card h3 {
            color: var(--warm-dark);
            font-size: 1.4rem;
            font-weight: 950;
        }

        .gift-copy-box {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px;
            border-radius: 20px;
            background: color-mix(in srgb, var(--warm-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--warm-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--warm-primary);
            font-size: 1.1rem;
            font-weight: 950;
        }

        .copy-gift-btn {
            flex-shrink: 0;
            border: none;
            cursor: pointer;
            border-radius: 999px;
            padding: 10px 14px;
            color: white;
            font-size: 12px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--warm-primary), var(--warm-secondary));
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .rsvp-wrap {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 16px 36px rgba(120, 70, 30, .08);
            border-radius: 30px;
        }

        .form-card {
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            text-align: center;
            padding: 20px;
        }

        .summary-card strong {
            display: block;
            color: var(--warm-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--warm-text);
            font-size: 12px;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .message-card {
            padding: 22px;
        }

        .message-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .message-info {
            min-width: 0;
            flex: 1;
        }

        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--warm-primary) 12%, white);
            color: var(--warm-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 820px;
            margin: 0 auto;
            border-radius: 38px;
            padding: 44px 34px;
            text-align: center;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--warm-primary) 12%, white), color-mix(in srgb, var(--warm-accent) 22%, white));
            border: 1px solid color-mix(in srgb, var(--warm-primary) 14%, transparent);
            box-shadow: 0 20px 46px rgba(120, 70, 30, .08);
        }

        @media (max-width: 980px) {
            .warm-shell {
                padding: 16px;
            }

            .warm-section {
                padding: 82px 38px;
            }

            .hero-layout,
            .detail-layout,
            .gallery-grid,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .gratitude-grid.count-3 {
                grid-template-columns: repeat(2, minmax(280px, 460px));
            }

            .warm-stat-grid,
            .countdown-grid,
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .gallery-card:nth-child(2) {
                transform: none;
            }
        }

        @media (max-width: 640px) {
            .warm-shell {
                padding: 0;
            }

            .warm-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .warm-section {
                padding: 72px 22px;
            }

            .warm-section.compact {
                padding-top: 64px;
                padding-bottom: 64px;
            }

            .hero-copy {
                text-align: center;
            }

            .warm-chip-row,
            .hero-copy .flex {
                justify-content: center;
            }

            .hero-photo-card,
            .hero-photo-inner,
            .hero-photo-inner img.cover-main-image {
                min-height: 460px;
            }

            .warm-stat-grid,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .gratitude-grid,
            .gratitude-grid.count-1,
            .gratitude-grid.count-2,
            .gratitude-grid.count-3 {
                grid-template-columns: 1fr;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .gift-copy-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .copy-gift-btn {
                width: 100%;
            }

            .floating-actions {
                right: 10px;
            }
        }

        /* =====================================================
        LUXURY WARM ANIMATION - SYUKURAN WARM
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .warm-reveal,
        .warm-section > p,
        .warm-section > h1,
        .warm-section > h2,
        .warm-section > h3,
        .warm-label,
        .warm-title,
        .warm-gradient-text,
        .warm-nav,
        .hero-copy,
        .hero-photo-card,
        .hero-photo-inner,
        .hero-placeholder,
        .warm-ornament,
        .warm-chip,
        .warm-stat,
        .gratitude-card,
        .gratitude-number,
        .warm-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .warm-btn {
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

        .warm-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .warm-nav {
            animation: warmNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil elegan */
        #opening .hero-photo-card {
            animation:
                warmPhotoEnter 1.1s cubic-bezier(.2, .8, .2, 1) .2s both,
                warmPhotoFloat 5.4s ease-in-out 1.4s infinite;
        }

        #opening .hero-copy {
            animation: warmHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .12s both;
        }

        #opening .warm-label {
            animation: warmFadeDown .85s ease .2s both;
        }

        #opening .warm-title {
            animation: warmTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .34s both;
        }

        #opening .warm-chip {
            animation: warmFadeUp .85s ease .52s both;
        }

        #opening .warm-btn {
            animation: warmFadeUp .85s ease .64s both;
        }

        #opening .warm-stat {
            animation: warmFadeUp .85s ease .76s both;
        }

        /* Background bergerak halus */
        .warm-wrap {
            animation: warmWrapGlow 8s ease-in-out infinite alternate;
        }

        .warm-wrap::before {
            animation: warmPatternMove 18s linear infinite;
        }

        /* Ornamen lingkaran hero */
        .ornament-one {
            animation: warmOrnamentOne 5.8s ease-in-out infinite;
        }

        .ornament-two {
            animation: warmOrnamentTwo 6.2s ease-in-out .25s infinite;
        }

        /* Dekorasi card bergerak */
        .gratitude-card::after {
            animation: warmDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label glow */
        .warm-label::before {
            animation: warmLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Button efek kilau */
        .warm-btn,
        button.warm-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .warm-btn::after,
        button.warm-btn::after,
        .copy-gift-btn::after,
        button[onclick*="clipboard"]::after {
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
                rgba(255,255,255,.58),
                transparent
            );
            animation: warmButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover card premium desktop */
        @media (hover: hover) {
            .hero-photo-card:hover,
            .warm-stat:hover,
            .gratitude-card:hover,
            .warm-card:hover,
            .detail-row:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--warm-primary) 32%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--warm-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--warm-accent) 16%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .hero-photo-card:hover img,
            .gallery-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .warm-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--warm-primary) 12%, transparent);
            }
        }

        .cover-main-image,
        .gallery-card img {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: warmNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Badge dan nomor pulse */
        .gratitude-number,
        .gift-number,
        .message-badge {
            animation: warmSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: warmGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: warmGalleryMiddle 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: warmGalleryRight 4.8s ease-in-out infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: warmFloatingButton 3.4s ease-in-out infinite;
        }

        .floating-actions a:nth-child(2),
        .floating-action-button:nth-child(2) {
            animation-delay: .18s;
        }

        .floating-actions a:nth-child(3),
        .floating-action-button:nth-child(3) {
            animation-delay: .36s;
        }

        .floating-actions a:nth-child(4),
        .floating-action-button:nth-child(4) {
            animation-delay: .54s;
        }

        /* Keyframes */
        @keyframes warmNavEnter {
            from {
                opacity: 0;
                transform: translateY(-18px) scale(.96);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes warmHeroCopyIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes warmPhotoEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.93) rotate(-2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes warmPhotoFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes warmFadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes warmFadeUp {
            from {
                opacity: 0;
                transform: translateY(26px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes warmTitleIn {
            from {
                opacity: 0;
                transform: translateY(38px) scale(.94);
                filter: blur(12px);
                letter-spacing: -.02em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes warmWrapGlow {
            from {
                box-shadow:
                    0 34px 95px color-mix(in srgb, var(--warm-primary) 10%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 42px 118px color-mix(in srgb, var(--warm-primary) 14%, transparent),
                    0 0 58px color-mix(in srgb, var(--warm-accent) 18%, transparent);
            }
        }

        @keyframes warmPatternMove {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 104px 104px;
            }
        }

        @keyframes warmOrnamentOne {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-12px) scale(1.06);
            }
        }

        @keyframes warmOrnamentTwo {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.05);
            }
        }

        @keyframes warmDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes warmLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--warm-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--warm-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes warmButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes warmNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--warm-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--warm-accent) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--warm-primary) 18%, transparent);
            }
        }

        @keyframes warmSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes warmGalleryLeft {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-7px);
            }
        }

        @keyframes warmGalleryMiddle {
            0%, 100% {
                transform: translateY(28px);
            }
            50% {
                transform: translateY(18px);
            }
        }

        @keyframes warmGalleryRight {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-7px);
            }
        }

        @keyframes warmFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .warm-reveal,
            .warm-section > p,
            .warm-section > h1,
            .warm-section > h2,
            .warm-section > h3,
            .warm-label,
            .warm-title,
            .warm-gradient-text,
            .warm-nav,
            .hero-copy,
            .hero-photo-card,
            .hero-photo-inner,
            .hero-placeholder,
            .warm-ornament,
            .warm-chip,
            .warm-stat,
            .gratitude-card,
            .gratitude-number,
            .warm-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .warm-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .hero-photo-card {
                animation:
                    warmFadeUp .9s ease .3s both,
                    warmFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .warm-reveal,
            .warm-section > p,
            .warm-section > h1,
            .warm-section > h2,
            .warm-section > h3,
            .warm-label,
            .warm-title,
            .warm-gradient-text,
            .warm-nav,
            .hero-copy,
            .hero-photo-card,
            .hero-photo-inner,
            .hero-placeholder,
            .warm-ornament,
            .warm-chip,
            .warm-stat,
            .gratitude-card,
            .gratitude-number,
            .warm-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .warm-btn,
            .warm-wrap,
            .warm-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-number,
            .gift-number,
            .message-badge {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'gold';

    $themes = [
        'maroon' => [
            'primary' => '#be123c',
            'secondary' => '#e11d48',
            'accent' => '#fbbf24',
            'dark' => '#4a1623',
            'text' => '#6b3440',
            'soft' => '#fff1f2',
            'glow1' => 'rgba(244, 63, 94, .18)',
            'glow2' => 'rgba(251, 191, 36, .18)',
        ],
        'emerald' => [
            'primary' => '#2f855a',
            'secondary' => '#68a357',
            'accent' => '#f6d365',
            'dark' => '#173f2c',
            'text' => '#4f725e',
            'soft' => '#f3fff5',
            'glow1' => 'rgba(104, 163, 87, .20)',
            'glow2' => 'rgba(246, 211, 101, .22)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#38bdf8',
            'accent' => '#facc15',
            'dark' => '#0f172a',
            'text' => '#475569',
            'soft' => '#eff6ff',
            'glow1' => 'rgba(37, 99, 235, .14)',
            'glow2' => 'rgba(250, 204, 21, .18)',
        ],
        'rose' => [
            'primary' => '#db2777',
            'secondary' => '#f472b6',
            'accent' => '#fde68a',
            'dark' => '#831843',
            'text' => '#70415b',
            'soft' => '#fff7fb',
            'glow1' => 'rgba(244, 114, 182, .18)',
            'glow2' => 'rgba(253, 230, 138, .20)',
        ],
        'gold' => [
            'primary' => '#b45309',
            'secondary' => '#d97706',
            'accent' => '#facc15',
            'dark' => '#4a2c0a',
            'text' => '#72512d',
            'soft' => '#fffbeb',
            'glow1' => 'rgba(245, 158, 11, .18)',
            'glow2' => 'rgba(250, 204, 21, .20)',
        ],
        'slate' => [
            'primary' => '#475569',
            'secondary' => '#64748b',
            'accent' => '#cbd5e1',
            'dark' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#f8fafc',
            'glow1' => 'rgba(100, 116, 139, .14)',
            'glow2' => 'rgba(203, 213, 225, .18)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['gold'];

    $firstPhoto = $invitation->photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Syukuran';
    $eventName = $invitation->event_name ?: 'Syukuran';
    $hostName = $invitation->host_name ?: null;

    $eventDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y')
        : 'Tanggal belum diatur';

    if ($invitation->event_end_date) {
        $eventDateText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y');
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: null;

    $shareMessage =
        "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa syukur dan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
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
        "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\n" .
        "Wassalamu'alaikum Wr. Wb.";

    $shareText = urlencode($shareMessage);

    $countdownTarget = null;

    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
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
            $startDate = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
            $startTime = !empty($invitation->event_time)
                ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s')
                : '00:00:00';

            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);

            $endDate = $invitation->event_end_date
                ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d')
                : $startDate;

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Syukuran') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan syukuran') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

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

    $mapOpenUrl = $mapData['open_url'] ?? $invitation->maps_url;
    $mapEmbedUrl = $mapData['embed_url'] ?? null;

    $warmHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $warmHighlights->count();
    $giftCount = $invitation->gifts->count();
@endphp

<body
    style="
        --warm-primary: {{ $activeTheme['primary'] }};
        --warm-secondary: {{ $activeTheme['secondary'] }};
        --warm-accent: {{ $activeTheme['accent'] }};
        --warm-dark: {{ $activeTheme['dark'] }};
        --warm-text: {{ $activeTheme['text'] }};
        --warm-soft: {{ $activeTheme['soft'] }};
        --warm-glow-1: {{ $activeTheme['glow1'] }};
        --warm-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="warm-shell">
        <div class="warm-wrap">

            <div class="floating-actions">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan" class="floating-icon">
                </a>

                <button type="button" id="music-toggle" class="floating-action-button" title="Music">
                    <img src="{{ asset('assets/icons/music-off.png') }}"
                         data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                         data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                         alt="Music"
                         class="floating-icon">
                </button>

                <button type="button" id="scroll-toggle" class="floating-action-button" title="Auto Scroll">
                    <img src="{{ asset('assets/icons/scroll-off.png') }}"
                         data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                         data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                         alt="Auto Scroll"
                         class="floating-icon">
                </button>

                @if ($mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background4.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="warm-nav">
                <a href="#detail">Detail</a>
                @if ($invitation->photos->count())
                    <a href="#gallery">Galeri</a>
                @endif
                @if ($giftCount)
                    <a href="#gift">Amplop</a>
                @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="warm-section">
                <div class="hero-layout">
                    <div class="hero-photo-card">
                        <div class="warm-ornament ornament-one"></div>
                        <div class="warm-ornament ornament-two"></div>

                        <div class="hero-photo-inner">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Syukuran" class="cover-main-image">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Syukuran" class="cover-main-image">
                            @else
                                <div class="hero-placeholder">
                                    <div class="warm-label">Syukur & Kebersamaan</div>
                                    <h2 class="responsive-text mt-6">
                                        {{ $invitation->event_name ?: 'Acara Syukuran' }}
                                    </h2>
                                    <p class="responsive-text">
                                        {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Momen hangat untuk berkumpul, berbagi kebahagiaan, dan mensyukuri nikmat bersama keluarga serta kerabat.' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hero-copy">
                        <div class="warm-label">
                            Syukuran Warm
                        </div>

                        <h1 class="responsive-text warm-title warm-gradient-text text-5xl md:text-7xl mt-8">
                            {{ $invitation->title ?: 'Syukuran Keluarga' }}
                        </h1>

                        <p class="responsive-text text-slate-600 mt-6 leading-8 text-lg">
                            {{ $invitation->description ?: 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara syukuran kami.' }}
                        </p>

                        <div class="warm-chip-row">
                            <span class="warm-chip">{{ $invitation->event_name ?: 'Syukuran' }}</span>
                            <span class="warm-chip">{{ $invitation->host_name ?: 'Tuan Rumah' }}</span>
                            <span class="warm-chip">Nuansa Hangat</span>
                        </div>

                        <div class="mt-9 flex flex-wrap gap-3">
                            <a href="#detail" class="warm-btn">Lihat Detail</a>
                            <a href="#message" class="warm-btn secondary">Kirim Ucapan</a>
                        </div>

                        <div class="warm-stat-grid">
                            <div class="warm-stat">
                                <strong>
                                    @if ($invitation->event_date)
                                        {{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}
                                    @else
                                        --
                                    @endif
                                </strong>
                                <span>Tanggal</span>
                            </div>

                            <div class="warm-stat">
                                <strong>{{ $invitation->photos->count() }}</strong>
                                <span>Galeri</span>
                            </div>

                            <div class="warm-stat">
                                <strong>{{ $invitation->messages->count() }}</strong>
                                <span>Ucapan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $warmHighlights->count())
                <section id="about" class="warm-section compact">
                    <div class="section-head">
                        <p class="warm-label justify-center">
                            Tentang Acara
                        </p>

                        <h2 class="responsive-text warm-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Momen Syukuran yang Hangat dan Bermakna' }}
                        </h2>

                        <p class="responsive-text desc">
                            {{ $invitation->host_name ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' sebagai bentuk rasa syukur, doa, dan kebersamaan.' : 'Acara ini menjadi momen untuk mempererat silaturahmi dan berbagi kebahagiaan dengan keluarga, sahabat, dan kerabat.' }}
                        </p>
                    </div>

                    @if ($highlightCount)
                        <div class="gratitude-grid count-{{ min($highlightCount, 3) }}">
                            @foreach ($warmHighlights as $index => $highlight)
                                <div class="gratitude-card">
                                    <div class="gratitude-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    @if (!empty($highlight['title']))
                                        <h3 class="responsive-text">{{ $highlight['title'] }}</h3>
                                    @endif

                                    @if (!empty($highlight['description']))
                                        <p class="responsive-text">{{ $highlight['description'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="warm-section compact">
                <div class="section-head">
                    <p class="warm-label justify-center">
                        Detail Acara
                    </p>

                    <h2 class="warm-title text-5xl md:text-6xl mt-6">
                        Informasi Syukuran
                    </h2>

                    <p class="responsive-text desc">
                        Simpan jadwalnya dan lihat lokasi acara melalui informasi berikut.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="warm-card">
                        <h3>Rincian Acara</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label ml-2">Acara</div>
                                <div class="value responsive-text ml-2">
                                    {{ $invitation->event_name ?: 'Syukuran' }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value warm-date-line ml-2">
                                    @if ($invitation->event_date)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>

                                        @if ($invitation->event_end_date)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Waktu</div>
                                <div class="value warm-time-line ml-2">
                                    @if ($invitation->event_time)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>

                                        @if ($invitation->event_end_time)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Lokasi</div>
                                <div class="value responsive-text ml-2">
                                    {{ $invitation->location_name ?: 'Lokasi acara belum diatur' }}
                                </div>
                            </div>

                            @if ($invitation->address)
                                <div class="detail-row">
                                    <div class="label ml-2">Alamat</div>
                                    <div class="value responsive-text ml-2">
                                        {{ $invitation->address }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="warm-btn">
                                    📅 Atur Pengingat
                                </a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="warm-btn secondary">
                                    📍 Buka Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="warm-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Menuju Hari Acara</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Semoga menjadi momen yang penuh keberkahan dan kebahagiaan.
                            </p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
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

                        @if ($invitation->address || $mapOpenUrl)
                            <div class="map-card">
                                @if ($mapEmbedUrl)
                                    <iframe
                                        src="{{ $mapEmbedUrl }}"
                                        class="map-frame"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen>
                                    </iframe>
                                @elseif ($mapOpenUrl)
                                    <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">
                                                {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                            </p>
                                            <p class="responsive-text text-slate-600 mt-2">
                                                {{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}
                                            </p>
                                        </div>
                                    </a>
                                @else
                                    <div class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">
                                                {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                            </p>
                                            <p class="responsive-text text-slate-600 mt-2">
                                                {{ $invitation->address }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GALLERY --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="warm-section compact">
                    <div class="section-head">
                        <p class="warm-label justify-center">
                            Galeri
                        </p>

                        <h2 class="warm-title text-5xl md:text-6xl mt-6">
                            Momen Kebersamaan
                        </h2>
                    </div>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-card">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Syukuran">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="warm-section compact">
                    <div class="section-head">
                        <p class="warm-label justify-center">
                            Amplop Digital
                        </p>

                        <h2 class="warm-title text-5xl md:text-6xl mt-6">
                            Kirim Doa & Dukungan
                        </h2>

                        <p class="responsive-text desc">
                            Jika berkenan, tamu dapat mengirimkan amplop digital melalui informasi berikut.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            <div class="gift-card">
                                <h3 class="responsive-text">
                                    {{ $gift->label ?: 'Amplop Digital' }}
                                </h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>

                                        <div class="gift-number responsive-text">
                                            {{ $gift->account_number ?: '-' }}
                                        </div>
                                    </div>

                                    @if ($gift->account_number)
                                        <button
                                            type="button"
                                            class="copy-gift-btn"
                                            data-copy="{{ $gift->account_number }}"
                                        >
                                            Salin
                                        </button>
                                    @endif
                                </div>

                                <p class="responsive-text font-bold mt-3">
                                    {{ $gift->account_name ?: 'Nama penerima belum diatur' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="warm-section compact mb-2">
                <div class="section-head mb-4">
                    <p class="warm-label justify-center">
                        Ucapan & RSVP
                    </p>

                    <h2 class="warm-title text-5xl md:text-6xl mt-6 mb-2">
                        Kirim Konfirmasi Kehadiran
                    </h2>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
                            {{ session('message_success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
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
                          class="form-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Tamu</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama lengkap"
                                   required>
                        </div>

                        <div>
                            <label class="uk-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="uk-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak hadir</option>
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
                            <label class="uk-label">Ucapan / Doa</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1 uk-break-input"
                                      placeholder="Tulis ucapan dan doa terbaik..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full warm-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong>
                            <span>Tidak hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong>
                            <span>Hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="message-card">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black text-slate-950">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">
                                    {{ trim($message->message) }}
                                </p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p class="text-slate-500">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="warm-section text-center">
                <div class="closing-card">
                    <p class="warm-label justify-center">
                        Terima Kasih
                    </p>

                    <h2 class="responsive-text warm-title warm-gradient-text text-5xl md:text-7xl mt-8">
                        Sampai Jumpa
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda.
                        Semoga acara ini membawa kebahagiaan, keberkahan, dan mempererat silaturahmi.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
                        {{ $invitation->title }}
                    </h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');

            if (countdownContainer) {
                const targetValue = countdownContainer.getAttribute('data-countdown-target');
                const targetDate = new Date(targetValue);

                const daysEl = document.getElementById('countdown-days');
                const hoursEl = document.getElementById('countdown-hours');
                const minutesEl = document.getElementById('countdown-minutes');
                const secondsEl = document.getElementById('countdown-seconds');
                const noteEl = document.getElementById('countdown-note');

                function formatNumber(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    if (isNaN(targetDate.getTime())) {
                        if (noteEl) {
                            noteEl.textContent = 'Format tanggal atau waktu acara belum valid.';
                        }
                        return;
                    }

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
                        noteEl.textContent = distance > 0
                            ? 'Hitung mundur menuju acara'
                            : 'Acara sedang berlangsung atau telah dimulai';
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

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
                        console.log('Audio tidak bisa diputar:', error);
                    }
                });
            }

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

            const copyGiftButtons = document.querySelectorAll('.copy-gift-btn');

            copyGiftButtons.forEach(function (button) {
                button.addEventListener('click', async function () {
                    const textToCopy = button.dataset.copy || '';

                    if (!textToCopy) {
                        return;
                    }

                    try {
                        await navigator.clipboard.writeText(textToCopy);

                        const originalText = button.textContent;
                        button.textContent = 'Tersalin';
                        button.classList.add('copied');

                        setTimeout(function () {
                            button.textContent = originalText;
                            button.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        const tempInput = document.createElement('input');
                        tempInput.value = textToCopy;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);

                        const originalText = button.textContent;
                        button.textContent = 'Tersalin';
                        button.classList.add('copied');

                        setTimeout(function () {
                            button.textContent = originalText;
                            button.classList.remove('copied');
                        }, 1800);
                    }
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .warm-section > p,
                .warm-section > h1,
                .warm-section > h2,
                .warm-section > h3,
                .warm-label,
                .warm-title,
                .warm-gradient-text,
                .warm-nav,
                .hero-copy,
                .hero-photo-card,
                .hero-photo-inner,
                .hero-placeholder,
                .warm-ornament,
                .warm-chip,
                .warm-stat,
                .gratitude-card,
                .gratitude-number,
                .warm-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .warm-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('warm-show');
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
