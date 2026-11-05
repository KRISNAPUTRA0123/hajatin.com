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
            color: var(--elegant-dark);
            background:
                radial-gradient(circle at top left, var(--elegant-body-1), transparent 34%),
                radial-gradient(circle at top right, var(--elegant-body-2), transparent 30%),
                linear-gradient(180deg, var(--elegant-bg) 0%, #ffffff 48%, var(--elegant-soft) 100%);
        }

        .elegant-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .elegant-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.96), rgba(255,255,255,.84)),
                radial-gradient(circle at 18% 12%, var(--elegant-glow-1), transparent 26%),
                radial-gradient(circle at 88% 18%, var(--elegant-glow-2), transparent 28%);
            box-shadow: 0 34px 100px rgba(15, 23, 42, .16);
        }

        .elegant-wrap::before {
            content: "";
            position: absolute;
            inset: 22px;
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 42%, transparent);
            border-radius: 34px;
            pointer-events: none;
            z-index: 0;
        }

        .detail-date-line,
        .detail-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
            margin-top: 10px;
        }

        .detail-date-line span,
        .detail-time-line span {
            display: inline;
        }

        .detail-lux-card {
            min-height: auto;
        }

        @media (max-width: 640px) {
        .detail-lux-card {
            padding: 22px 18px;
        }

        .detail-date-line,
        .detail-time-line {
            margin-top: 8px;
            gap: 5px;
            font-size: 15px;
        }
    }

        .elegant-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(color-mix(in srgb, var(--elegant-gold) 10%, transparent) 1px, transparent 1px),
                linear-gradient(90deg, color-mix(in srgb, var(--elegant-gold) 10%, transparent) 1px, transparent 1px);
            background-size: 72px 72px;
            opacity: .25;
            pointer-events: none;
            z-index: 0;
        }

        .elegant-wrap > * {
            position: relative;
            z-index: 1;
        }

        .elegant-section {
            min-height: 100vh;
            padding: 96px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .elegant-section.compact {
            min-height: auto;
            padding-top: 86px;
            padding-bottom: 86px;
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

        .luxury-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--elegant-primary);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .32em;
            text-transform: uppercase;
        }

        .luxury-label::before,
        .luxury-label::after {
            content: "";
            width: 38px;
            height: 1px;
            background: var(--elegant-gold);
            display: inline-block;
        }

        .elegant-title {
            font-family: Georgia, "Times New Roman", serif;
            color: var(--elegant-dark);
            letter-spacing: -.045em;
            line-height: .98;
            font-weight: 900;
        }

        .gold-text {
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-gold), var(--elegant-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .elegant-card {
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 26%, transparent);
            border-radius: 34px;
            box-shadow: 0 22px 56px rgba(15, 23, 42, .10);
            padding: 30px;
            backdrop-filter: blur(14px);
        }

        .elegant-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            padding: 14px 26px;
            color: white;
            text-decoration: none;
            font-weight: 900;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--elegant-primary) 28%, transparent);
            border: none;
            cursor: pointer;
        }

        .elegant-btn.gold {
            background: linear-gradient(135deg, var(--elegant-gold), var(--elegant-primary));
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
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
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--elegant-gold) 24%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 48px;
            align-items: center;
        }

        .hero-copy {
            max-width: 620px;
        }

        .hero-frame {
            position: relative;
            width: min(100%, 430px);
            margin: 0 auto;
            aspect-ratio: 4 / 5;
            border-radius: 40px;
            padding: 14px;
            background: linear-gradient(145deg, var(--elegant-gold), rgba(255,255,255,.95), var(--elegant-primary));
            box-shadow: 0 28px 70px rgba(15, 23, 42, .20);
        }

        .hero-frame::before {
            content: "";
            position: absolute;
            inset: -18px;
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 44%, transparent);
            border-radius: 50px;
            z-index: -1;
        }

        .hero-frame img,
        .hero-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 28px;
            object-fit: cover;
            display: block;
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--elegant-gold) 22%, white), transparent 34%),
                linear-gradient(135deg, var(--elegant-soft), #ffffff);
        }

        .hero-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 72px;
            color: var(--elegant-primary);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 900;
        }

        .stat-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 32px;
        }

        .stat-box {
            border-radius: 24px;
            background: rgba(255,255,255,.82);
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 20%, transparent);
            padding: 18px;
            text-align: center;
        }

        .honoree-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
            max-width: 880px;
            margin: 34px auto 0;
        }

        .honoree-grid.single-honoree {
            grid-template-columns: minmax(0, 360px);
            justify-content: center;
        }

        .honoree-card {
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(255,255,255,.78));
            border-radius: 36px;
            padding: 28px;
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 24%, transparent);
            box-shadow: 0 20px 50px rgba(15, 23, 42, .09);
        }

        .honoree-photo,
        .honoree-placeholder {
            width: 132px;
            height: 132px;
            border-radius: 999px;
            object-fit: cover;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--elegant-soft), #fff);
            border: 6px solid white;
            box-shadow: 0 14px 32px rgba(15, 23, 42, .12);
            font-size: 44px;
        }

        .detail-lux-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .detail-lux-card {
            text-align: center;
            border-radius: 30px;
            padding: 26px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 22%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
        }

        .detail-icon {
            width: 58px;
            height: 58px;
            border-radius: 999px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-gold));
            color: white;
            font-size: 26px;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            max-width: 680px;
            margin: 34px auto 0;
        }

        .countdown-card {
            border-radius: 30px;
            padding: 26px 14px;
            text-align: center;
            background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.78));
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 28%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
        }

        .countdown-number {
            display: block;
            font-size: 38px;
            line-height: 1;
            font-weight: 950;
            color: var(--elegant-primary);
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: .16em;
            font-size: 11px;
            color: #64748b;
            font-weight: 900;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr 1.1fr;
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-item {
            border-radius: 32px;
            overflow: hidden;
            background: white;
            padding: 10px;
            box-shadow: 0 18px 46px rgba(15, 23, 42, .10);
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 18%, transparent);
        }

        .gallery-item:nth-child(2) {
            transform: translateY(28px);
        }

        .gallery-item img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 24px;
            display: block;
        }

        .map-card {
            width: min(100%, 760px);
            margin: 28px auto 0;
            border-radius: 34px;
            overflow: hidden;
            background: white;
            box-shadow: 0 20px 54px rgba(15, 23, 42, .12);
            border: 1px solid color-mix(in srgb, var(--elegant-gold) 22%, transparent);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 330px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--elegant-gold) 18%, white), transparent 32%),
                linear-gradient(135deg, var(--elegant-soft), white);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
        }

        .gift-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            text-align: left;
        }

        .guest-message-card {
            text-align: left;
        }

        .guest-message-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .guest-message-info {
            min-width: 0;
            flex: 1;
        }

        .guest-message-text {
            text-align: left;
            margin-left: 0;
        }

        @media (max-width: 900px) {
            .elegant-shell {
                padding: 16px;
            }

            .elegant-section {
                padding: 86px 38px;
            }

            .hero-grid,
            .honoree-grid,
            .detail-lux-grid,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-item:nth-child(2) {
                transform: none;
            }

            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .elegant-shell {
                padding: 0;
            }

            .elegant-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .elegant-wrap::before {
                inset: 12px;
                border-radius: 22px;
            }

            .elegant-section {
                padding: 76px 24px;
            }

            .elegant-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .luxury-label {
                letter-spacing: .20em;
                font-size: 11px;
            }

            .luxury-label::before,
            .luxury-label::after {
                width: 22px;
            }

            .hero-copy {
                text-align: center;
            }

            .hero-frame {
                width: min(100%, 310px);
                border-radius: 32px;
            }

            .hero-frame::before {
                inset: -10px;
                border-radius: 40px;
            }

            .elegant-title {
                font-size: 3rem;
                line-height: 1.02;
            }

            .stat-row {
                grid-template-columns: 1fr;
            }

            .floating-actions {
                right: 10px;
            }

            .gift-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .gallery-item img {
                height: 220px;
            }
        }

        /* =====================================================
        LUXURY ELEGANT ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .elegant-reveal,
        .elegant-section > p,
        .elegant-section > h1,
        .elegant-section > h2,
        .elegant-section > h3,
        .luxury-label,
        .elegant-title,
        .gold-text,
        .hero-copy,
        .hero-frame,
        .elegant-card,
        .stat-box,
        .honoree-card,
        .detail-lux-card,
        .detail-icon,
        .countdown-card,
        .gallery-item,
        .map-card,
        .gift-card,
        .elegant-btn {
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

        .elegant-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-copy {
            animation: elegantHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .luxury-label {
            animation: elegantFadeDown .85s ease .12s both;
        }

        #opening .elegant-title {
            animation: elegantTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .elegant-btn {
            animation: elegantFadeUp .85s ease .52s both;
        }

        #opening .hero-frame {
            animation: elegantPhotoEnter 1.1s cubic-bezier(.2, .8, .2, 1) .32s both, elegantHeroFloat 5s ease-in-out 1.4s infinite;
        }

        /* Background bergerak halus */
        .elegant-wrap {
            animation: elegantWrapGlow 8s ease-in-out infinite alternate;
        }

        .elegant-wrap::after {
            animation: elegantGridMove 20s linear infinite;
        }

        .elegant-wrap::before {
            animation: elegantBorderGlow 4.8s ease-in-out infinite alternate;
        }

        /* Garis label terlihat hidup */
        .luxury-label::before,
        .luxury-label::after {
            animation: elegantLineGlow 2.8s ease-in-out infinite alternate;
        }

        /* Frame foto ada glow */
        .hero-frame::before {
            animation: elegantFrameGlow 4.2s ease-in-out infinite alternate;
        }

        /* Button efek kilau */
        .elegant-btn,
        button.elegant-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .elegant-btn::after,
        button.elegant-btn::after,
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
                rgba(255,255,255,.55),
                transparent
            );
            animation: elegantButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Card hover premium desktop */
        @media (hover: hover) {
            .elegant-card:hover,
            .stat-box:hover,
            .honoree-card:hover,
            .detail-lux-card:hover,
            .countdown-card:hover,
            .gallery-item:hover,
            .map-card:hover,
            .hero-frame:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--elegant-gold) 42%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(15, 23, 42, .16),
                    0 0 46px color-mix(in srgb, var(--elegant-gold) 18%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.76) !important;
            }

            .gallery-item:hover img,
            .hero-frame:hover img,
            .honoree-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }
        }

        .gallery-item img,
        .hero-frame img,
        .honoree-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Detail icon pulse */
        .detail-icon {
            animation: elegantIconPulse 3s ease-in-out infinite;
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: elegantNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Floating buttons */
        .floating-actions a,
        .floating-action-button {
            animation: elegantFloatingButton 3.4s ease-in-out infinite;
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

        /* Gallery posisi tengah tetap punya animasi */
        .gallery-item:nth-child(2) {
            animation: elegantGalleryMiddle 4.8s ease-in-out infinite;
        }

        /* Keyframes */
        @keyframes elegantHeroCopyIn {
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

        @keyframes elegantFadeDown {
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

        @keyframes elegantFadeUp {
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

        @keyframes elegantTitleIn {
            from {
                opacity: 0;
                transform: translateY(36px) scale(.94);
                filter: blur(12px);
                letter-spacing: .02em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes elegantPhotoEnter {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.92) rotate(-4deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes elegantHeroFloat {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-8px) rotate(1deg) scale(1.015);
            }
        }

        @keyframes elegantWrapGlow {
            from {
                box-shadow:
                    0 34px 100px rgba(15, 23, 42, .16),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 40px 118px rgba(15, 23, 42, .18),
                    0 0 58px color-mix(in srgb, var(--elegant-gold) 14%, transparent);
            }
        }

        @keyframes elegantGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 144px 144px, 144px 144px;
            }
        }

        @keyframes elegantBorderGlow {
            from {
                border-color: color-mix(in srgb, var(--elegant-gold) 32%, transparent);
            }
            to {
                border-color: color-mix(in srgb, var(--elegant-gold) 62%, transparent);
            }
        }

        @keyframes elegantLineGlow {
            from {
                opacity: .55;
                transform: scaleX(.85);
            }
            to {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        @keyframes elegantFrameGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--elegant-gold) 0%, transparent);
            }
            to {
                box-shadow: 0 0 34px color-mix(in srgb, var(--elegant-gold) 24%, transparent);
            }
        }

        @keyframes elegantButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes elegantIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 24px color-mix(in srgb, var(--elegant-primary) 18%, transparent);
            }
            50% {
                transform: translateY(-4px) scale(1.055);
                box-shadow:
                    0 18px 38px color-mix(in srgb, var(--elegant-primary) 24%, transparent),
                    0 0 28px color-mix(in srgb, var(--elegant-gold) 24%, transparent);
            }
        }

        @keyframes elegantNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--elegant-gold) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--elegant-gold) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--elegant-primary) 18%, transparent);
            }
        }

        @keyframes elegantFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes elegantGalleryMiddle {
            0%, 100% {
                transform: translateY(28px);
            }
            50% {
                transform: translateY(18px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .elegant-reveal,
            .elegant-section > p,
            .elegant-section > h1,
            .elegant-section > h2,
            .elegant-section > h3,
            .luxury-label,
            .elegant-title,
            .gold-text,
            .hero-copy,
            .hero-frame,
            .elegant-card,
            .stat-box,
            .honoree-card,
            .detail-lux-card,
            .detail-icon,
            .countdown-card,
            .gallery-item,
            .map-card,
            .gift-card,
            .elegant-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-item:nth-child(2) {
                animation: none;
                transform: none;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .elegant-reveal,
            .elegant-section > p,
            .elegant-section > h1,
            .elegant-section > h2,
            .elegant-section > h3,
            .luxury-label,
            .elegant-title,
            .gold-text,
            .hero-copy,
            .hero-frame,
            .elegant-card,
            .stat-box,
            .honoree-card,
            .detail-lux-card,
            .detail-icon,
            .countdown-card,
            .gallery-item,
            .map-card,
            .gift-card,
            .elegant-btn,
            .elegant-wrap,
            .elegant-wrap::before,
            .elegant-wrap::after,
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
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'gold';

    $themes = [
        'maroon' => [
            'primary' => '#7f1d1d',
            'secondary' => '#be123c',
            'gold' => '#d4af37',
            'dark' => '#2f1518',
            'bg' => '#fff7f5',
            'soft' => '#fff1f2',
            'body1' => 'rgba(127, 29, 29, .16)',
            'body2' => 'rgba(212, 175, 55, .18)',
            'glow1' => 'rgba(212, 175, 55, .18)',
            'glow2' => 'rgba(190, 18, 60, .13)',
        ],
        'emerald' => [
            'primary' => '#064e3b',
            'secondary' => '#0f766e',
            'gold' => '#d4af37',
            'dark' => '#0f2f2a',
            'bg' => '#f5fffb',
            'soft' => '#ecfdf5',
            'body1' => 'rgba(6, 78, 59, .15)',
            'body2' => 'rgba(212, 175, 55, .14)',
            'glow1' => 'rgba(212, 175, 55, .17)',
            'glow2' => 'rgba(15, 118, 110, .12)',
        ],
        'navy' => [
            'primary' => '#0f172a',
            'secondary' => '#334155',
            'gold' => '#d4af37',
            'dark' => '#0f172a',
            'bg' => '#f8fafc',
            'soft' => '#eef2ff',
            'body1' => 'rgba(15, 23, 42, .13)',
            'body2' => 'rgba(212, 175, 55, .16)',
            'glow1' => 'rgba(212, 175, 55, .16)',
            'glow2' => 'rgba(51, 65, 85, .10)',
        ],
        'rose' => [
            'primary' => '#9f1239',
            'secondary' => '#db2777',
            'gold' => '#d4af37',
            'dark' => '#4a2433',
            'bg' => '#fff7fa',
            'soft' => '#fff1f2',
            'body1' => 'rgba(159, 18, 57, .14)',
            'body2' => 'rgba(212, 175, 55, .16)',
            'glow1' => 'rgba(212, 175, 55, .18)',
            'glow2' => 'rgba(219, 39, 119, .10)',
        ],
        'gold' => [
            'primary' => '#7c2d12',
            'secondary' => '#b45309',
            'gold' => '#d4af37',
            'dark' => '#3f2516',
            'bg' => '#fffaf0',
            'soft' => '#fff7ed',
            'body1' => 'rgba(180, 83, 9, .14)',
            'body2' => 'rgba(212, 175, 55, .18)',
            'glow1' => 'rgba(212, 175, 55, .22)',
            'glow2' => 'rgba(180, 83, 9, .10)',
        ],
        'slate' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'gold' => '#d4af37',
            'dark' => '#1e293b',
            'bg' => '#f8fafc',
            'soft' => '#ffffff',
            'body1' => 'rgba(51, 65, 85, .12)',
            'body2' => 'rgba(212, 175, 55, .13)',
            'glow1' => 'rgba(212, 175, 55, .13)',
            'glow2' => 'rgba(100, 116, 139, .10)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['gold'];

    $firstPhoto = $invitation->photos->first();
    $birthdayPerson = $invitation->people->first();

    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Acara';
    $eventName = $invitation->event_name ?: 'Acara';
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

            $endDate = $invitation->event_end_date
                ? $invitation->event_end_date->format('Y-m-d')
                : $startDate;

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(2);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(2);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Ulang Tahun') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan ulang tahun') . "\n\nLink Undangan: " . $shareUrl);
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
@endphp

<body
    style="
        --elegant-primary: {{ $activeTheme['primary'] }};
        --elegant-secondary: {{ $activeTheme['secondary'] }};
        --elegant-gold: {{ $activeTheme['gold'] }};
        --elegant-dark: {{ $activeTheme['dark'] }};
        --elegant-bg: {{ $activeTheme['bg'] }};
        --elegant-soft: {{ $activeTheme['soft'] }};
        --elegant-body-1: {{ $activeTheme['body1'] }};
        --elegant-body-2: {{ $activeTheme['body2'] }};
        --elegant-glow-1: {{ $activeTheme['glow1'] }};
        --elegant-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="elegant-shell">
        <div class="elegant-wrap">

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
                   src="{{ asset('assets/music/background2.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            {{-- HERO --}}
            <section id="opening" class="elegant-section">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="luxury-label">
                            Luxury Birthday Invitation
                        </div>

                        <h1 class="responsive-text elegant-title gold-text text-6xl md:text-8xl mt-8">
                            {{ $invitation->title ?: 'Birthday Soirée' }}
                        </h1>

                        <p class="responsive-text text-slate-600 mt-7 leading-8 text-lg">
                            {{ $invitation->description ?: 'Dengan penuh kebahagiaan, kami mengundang Anda untuk menghadiri perayaan ulang tahun istimewa yang dirancang dengan suasana elegan, hangat, dan berkesan.' }}
                        </p>

                        <div class="mt-9 flex flex-wrap gap-3 justify-center md:justify-start">
                            <a href="#intro" class="elegant-btn">
                                Buka Undangan
                            </a>

                            <a href="#detail" class="elegant-btn gold">
                                Lihat Detail
                            </a>
                        </div>

                        <div class="stat-row">
                            <div class="stat-box">
                                <p class="text-xs uppercase tracking-[.18em] text-slate-400 font-black">
                                    Acara
                                </p>
                                <p class="responsive-text font-black" style="color: var(--elegant-dark)">
                                    {{ $invitation->event_name ?: 'Ulang Tahun' }}
                                </p>
                            </div>

                            <div class="stat-box">
                                <p class="text-xs uppercase tracking-[.18em] text-slate-400 font-black mb-6">
                                    Tanggal
                                </p>
                                <p class="responsive-text detail-date-line font-black text-lg" style="color: var(--elegant-dark)">
                                    @if ($invitation->event_date)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>

                                        @if ($invitation->event_end_date)
                                            <span>
                                                - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </p>
                            </div>

                            <div class="stat-box">
                                <p class="text-xs uppercase tracking-[.18em] text-slate-400 font-black">
                                    Lokasi
                                </p>
                                <p class="responsive-text font-black" style="color: var(--elegant-dark)">
                                    {{ $invitation->location_name ?: 'Belum diatur' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="hero-frame">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Birthday Elegant">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Birthday Elegant">
                            @else
                                <div class="hero-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($invitation->title ?: 'B', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- INTRO --}}
            <section id="intro" class="elegant-section compact text-center">
                <p class="luxury-label justify-center">
                    An Elegant Celebration
                </p>

                <h2 class="elegant-title text-5xl md:text-7xl mt-6">
                    A Moment Worth Celebrating
                </h2>

                <p class="responsive-text text-slate-600 mt-6 max-w-3xl mx-auto leading-8 text-lg">
                    {{ $invitation->host_name ? 'Dipersembahkan oleh ' . $invitation->host_name : 'Kami mengundang Anda untuk hadir dalam perayaan penuh kebahagiaan, kehangatan, dan momen berharga bersama orang-orang terkasih.' }}
                </p>
            </section>

            {{-- HONOREE --}}
            <section id="honoree" class="elegant-section compact text-center">
                <p class="luxury-label justify-center">
                    Birthday Honoree
                </p>

                <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                    Tokoh Utama
                </h2>

                <div class="honoree-grid {{ $invitation->people->count() <= 1 ? 'single-honoree' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="honoree-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="honoree-photo"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="honoree-placeholder">
                                    ✦
                                </div>
                            @endif

                            <h3 class="responsive-text elegant-title text-3xl mt-4">
                                {{ $person->name ?: $invitation->title }}
                            </h3>

                            @if ($person->subtitle)
                                <p class="responsive-text text-slate-600 mt-3">
                                    {{ $person->subtitle }}
                                </p>
                            @endif

                            @if ($person->family_name)
                                <p class="responsive-text text-slate-500 mt-2">
                                    {{ $person->family_name }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="honoree-card">
                            <div class="honoree-placeholder">
                                ✦
                            </div>

                            <h3 class="responsive-text elegant-title text-3xl mt-4">
                                {{ $invitation->title ?: 'Birthday Star' }}
                            </h3>

                            <p class="text-slate-500 mt-3">
                                Tokoh utama belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="elegant-section compact text-center">
                <p class="luxury-label justify-center">
                    Date & Venue
                </p>

                <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                    Detail Acara
                </h2>

                <div class="detail-lux-grid">
                    <div class="detail-lux-card">
                        <div class="detail-icon"><img src="{{ asset('assets/icons/Tanggal.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Tanggal"></div>
                        <p class="text-sm text-slate-500 mb-6">Tanggal</p>
                        <p class="detail-date-line font-black text-lg" style="color: var(--elegant-dark)">
                            @if ($invitation->event_date)
                                <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>

                                @if ($invitation->event_end_date)
                                    <span>
                                        - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            @else
                                <span>Belum diatur</span>
                            @endif
                        </p>
                    </div>

                    <div class="detail-lux-card">
                        <div class="detail-icon"><img src="{{ asset('assets/icons/Waktu.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Waktu"></div>
                        <p class="text-sm text-slate-500 mb-6">Waktu</p>
                        <p class="detail-time-line font-black text-lg" style="color: var(--elegant-dark)">
                            @if ($invitation->event_time)
                                <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>

                                @if ($invitation->event_end_time)
                                    <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                @endif
                            @else
                                <span>Belum diatur</span>
                            @endif
                        </p>
                    </div>

                    <div class="detail-lux-card">
                        <div class="detail-icon"><img src="{{ asset('assets/icons/Lokasi.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Lokasi"></div>
                        <p class="text-sm text-slate-500">Lokasi</p>
                        <p class="responsive-text font-black text-lg" style="color: var(--elegant-dark)">
                            {{ $invitation->location_name ?: 'Belum diatur' }}
                        </p>
                    </div>
                </div>

                @if ($invitation->address)
                    <div class="elegant-card mt-6 max-w-3xl mx-auto text-center">
                        <p class="text-sm text-slate-500">
                            Alamat Lengkap
                        </p>

                        <p class="responsive-text text-slate-700 mt-3 leading-7">
                            {{ $invitation->address }}
                        </p>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @if ($googleCalendarUrl)
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="elegant-btn">
                            📅 Atur Pengingat
                        </a>
                    @endif

                    @if ($mapOpenUrl)
                        <a href="{{ $mapOpenUrl }}" target="_blank" class="elegant-btn gold">
                            📍 Buka Maps
                        </a>
                    @endif
                </div>

                @if ($mapOpenUrl)
                    <div class="map-card">
                        @if ($mapEmbedUrl)
                            <iframe
                                src="{{ $mapEmbedUrl }}"
                                class="map-frame"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen>
                            </iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder text-decoration-none">
                                <div>
                                    <p class="text-5xl">📍</p>
                                    <p class="responsive-text font-black mt-3" style="color: var(--elegant-dark)">
                                        {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                    </p>
                                    <p class="text-slate-500 mt-2">
                                        Klik untuk membuka lokasi di Google Maps.
                                    </p>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </section>

            {{-- COUNTDOWN --}}
            <section id="countdown" class="elegant-section compact text-center">
                <p class="luxury-label justify-center">
                    Save The Moment
                </p>

                <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                    Countdown
                </h2>

                <p class="text-slate-500 mt-4" id="countdown-note">
                    @if ($countdownTarget)
                        Menghitung mundur menuju acara
                    @else
                        Tanggal acara belum diatur
                    @endif
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
            </section>

            {{-- GALLERY --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="elegant-section compact text-center">
                    <p class="luxury-label justify-center">
                        Memory Gallery
                    </p>

                    <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                        Galeri Momen
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Birthday Elegant">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFT --}}
            <section id="gift" class="elegant-section compact text-center">
                <p class="luxury-label justify-center">
                    Gift Corner
                </p>

                <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                    Amplop Digital
                </h2>

                <p class="responsive-text text-slate-600 mt-5 max-w-2xl mx-auto leading-8">
                    Bagi yang ingin mengirimkan tanda kasih, dapat melalui informasi berikut.
                </p>

                <div class="mt-8 space-y-4 max-w-2xl mx-auto">
                    @forelse ($invitation->gifts as $gift)
                        <div class="elegant-card gift-card">
                            <div>
                                <p class="responsive-text text-sm text-slate-500">
                                    {{ $gift->label ?: 'Bank / E-wallet' }}
                                </p>

                                <p class="responsive-text font-black text-xl mt-1" style="color: var(--elegant-dark)">
                                    {{ $gift->account_number ?: '-' }}
                                </p>

                                <p class="responsive-text text-sm text-slate-500 mt-1">
                                    Atas Nama {{ $gift->account_name ?: '-' }}
                                </p>
                            </div>

                            @if ($gift->account_number)
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $gift->account_number }}')"
                                        class="elegant-btn">
                                    Salin
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="elegant-card text-center">
                            <p class="text-slate-500">
                                Informasi gift belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- RSVP --}}
            <section id="message" class="elegant-section compact">
                <div class="text-center">
                    <p class="luxury-label justify-center">
                        Guest Book
                    </p>

                    <h2 class="elegant-title text-5xl md:text-6xl mt-6">
                        Kirim Ucapan
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Tulis doa dan konfirmasi kehadiran
                    </p>
                </div>

                <div class="max-w-3xl mx-auto w-full mt-8">
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
                          class="elegant-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama tamu"
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
                            <label class="uk-label">Ucapan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis ucapan ulang tahun..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full elegant-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="elegant-card">
                            <p class="text-3xl font-black" style="color: var(--elegant-dark)">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="elegant-card">
                            <p class="text-3xl font-black" style="color: var(--elegant-dark)">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="elegant-card">
                            <p class="text-3xl font-black" style="color: var(--elegant-dark)">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="elegant-card guest-message-card">
                                <div class="guest-message-header">
                                    <div class="guest-message-info">
                                        <p class="responsive-text font-black" style="color: var(--elegant-dark)">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="shrink-0 text-xs px-3 py-1 rounded-full bg-pink-100 text-pink-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text guest-message-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="elegant-card text-center">
                                <p class="text-slate-500">
                                    Belum ada ucapan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="elegant-section text-center">
                <p class="luxury-label justify-center">
                    Thank You
                </p>

                <h2 class="elegant-title gold-text text-6xl md:text-8xl mt-8">
                    See You
                </h2>

                <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                    Terima kasih sudah menjadi bagian dari hari spesial ini.
                    Kehadiran dan doa Anda akan membuat perayaan ini semakin berkesan.
                </p>

                <h3 class="responsive-text elegant-title text-4xl md:text-5xl mt-10">
                    {{ $invitation->title }}
                </h3>
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
                        if (noteEl) noteEl.textContent = 'Format tanggal atau waktu acara belum valid.';
                        return;
                    }

                    const now = new Date();
                    let distance = targetDate.getTime() - now.getTime();

                    if (distance < 0) distance = 0;

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
                            ? 'Menghitung mundur menuju acara'
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

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .elegant-section > p,
                .elegant-section > h1,
                .elegant-section > h2,
                .elegant-section > h3,
                .luxury-label,
                .elegant-title,
                .gold-text,
                .hero-copy,
                .hero-frame,
                .elegant-card,
                .stat-box,
                .honoree-card,
                .detail-lux-card,
                .detail-icon,
                .countdown-card,
                .gallery-item,
                .map-card,
                .gift-card,
                .elegant-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('elegant-show');
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
