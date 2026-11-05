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
            color: #e5e7eb;
            background:
                radial-gradient(circle at top left, var(--webinar-glow-1), transparent 36%),
                radial-gradient(circle at top right, var(--webinar-glow-2), transparent 34%),
                linear-gradient(180deg, var(--webinar-bg) 0%, #020617 55%, #030712 100%);
        }

        .webinar-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .webinar-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(2, 6, 23, .98)),
                radial-gradient(circle at 18% 14%, var(--webinar-soft-glow), transparent 30%),
                radial-gradient(circle at 82% 16%, rgba(255,255,255,.08), transparent 26%);
            box-shadow: 0 34px 120px rgba(0, 0, 0, .45);
            border: 1px solid rgba(255,255,255,.10);
        }

        .webinar-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.055) 1px, transparent 1px);
            background-size: 64px 64px;
            mask-image: linear-gradient(180deg, black 0%, transparent 84%);
            pointer-events: none;
            z-index: 0;
        }

        .webinar-wrap::after {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            right: -180px;
            top: -160px;
            border-radius: 999px;
            background: radial-gradient(circle, var(--webinar-accent) 0%, transparent 62%);
            opacity: .20;
            filter: blur(4px);
            pointer-events: none;
            z-index: 0;
        }

        .webinar-wrap > * {
            position: relative;
            z-index: 1;
        }

        .webinar-section {
            min-height: 100vh;
            padding: 96px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .webinar-section.compact {
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

        .webinar-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--webinar-accent);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .28em;
            text-transform: uppercase;
        }

        .webinar-label::before {
            content: "";
            width: 42px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--webinar-primary), var(--webinar-accent));
            display: inline-block;
        }

        .webinar-title {
            color: #ffffff;
            letter-spacing: -.06em;
            line-height: .96;
            font-weight: 950;
        }

        .webinar-gradient-text {
            background: linear-gradient(135deg, #ffffff, var(--webinar-accent), var(--webinar-primary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .webinar-card {
            background: linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.06));
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 34px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .28);
            padding: 30px;
            backdrop-filter: blur(18px);
        }

        .webinar-date-line,
        .webinar-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .webinar-date-line span,
        .webinar-time-line span {
            display: inline;
        }

        .webinar-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            padding: 14px 26px;
            color: white;
            text-decoration: none;
            font-weight: 950;
            background: linear-gradient(135deg, var(--webinar-primary), var(--webinar-secondary));
            box-shadow: 0 18px 42px color-mix(in srgb, var(--webinar-primary) 36%, transparent);
            border: 1px solid rgba(255,255,255,.16);
            cursor: pointer;
        }

        .webinar-btn.secondary {
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.18);
            box-shadow: none;
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
            background: rgba(255,255,255,.94);
            box-shadow: 0 14px 30px rgba(0,0,0,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--webinar-accent) 28%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 48px;
            align-items: center;
        }

        .hero-copy {
            max-width: 620px;
        }

        .webinar-stage {
            position: relative;
            border-radius: 38px;
            padding: 14px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.20), rgba(255,255,255,.06)),
                linear-gradient(135deg, var(--webinar-primary), var(--webinar-accent));
            box-shadow: 0 34px 90px rgba(0, 0, 0, .42);
        }

        .webinar-screen {
            min-height: 460px;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            background:
                radial-gradient(circle at 28% 18%, color-mix(in srgb, var(--webinar-accent) 26%, transparent), transparent 32%),
                linear-gradient(145deg, #0f172a, #020617);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px;
        }

        .webinar-screen img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .36;
        }

        .screen-topbar {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .screen-dots {
            display: flex;
            gap: 7px;
        }

        .screen-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.38);
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 8px 12px;
            color: white;
            background: rgba(239, 68, 68, .92);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .live-badge::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: white;
            box-shadow: 0 0 0 6px rgba(255,255,255,.18);
        }

        .screen-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 24px;
        }

        .screen-title {
            font-size: clamp(2rem, 5vw, 4.2rem);
            line-height: .98;
            letter-spacing: -.06em;
            font-weight: 950;
            color: white;
        }

        .screen-footer {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .mini-stat {
            border-radius: 20px;
            padding: 14px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.12);
            text-align: center;
        }

        .mini-stat p:first-child {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .mini-stat p:last-child {
            color: #ffffff;
            font-weight: 950;
            margin-top: 6px;
            line-height: 1.25;
        }

        .webinar-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            margin: 18px auto 0;
            width: fit-content;
            max-width: calc(100% - 32px);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px;
            border-radius: 999px;
            background: rgba(15,23,42,.72);
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 45px rgba(0,0,0,.24);
            overflow-x: auto;
        }

        .webinar-nav a {
            flex: 0 0 auto;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
        }

        .webinar-nav a:hover {
            color: white;
            background: rgba(255,255,255,.10);
        }

        .overview-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-top: 34px;
        }

        .feature-grid {
            display: grid;
            gap: 20px;
            margin-top: 36px;
            justify-content: center;
        }

        .feature-grid.feature-count-1 {
            grid-template-columns: minmax(280px, 360px);
        }

        .feature-grid.feature-count-2 {
            grid-template-columns: repeat(2, minmax(280px, 360px));
        }

        .feature-grid.feature-count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .feature-card {
            border-radius: 30px;
            padding: 26px;
            background: linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.06));
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 18px 50px rgba(0,0,0,.20);
        }

        .feature-number {
            width: 46px;
            height: 46px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--webinar-primary), var(--webinar-accent));
            margin-bottom: 18px;
        }

        .speaker-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-top: 36px;
        }

        .speaker-row.single-speaker {
            grid-template-columns: minmax(0, 380px);
            justify-content: center;
        }

        .speaker-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 34px;
            padding: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.13), rgba(255,255,255,.06));
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 18px 50px rgba(0,0,0,.22);
        }

        .speaker-card::before {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -50px;
            border-radius: 999px;
            background: var(--webinar-accent);
            opacity: .16;
            filter: blur(2px);
        }

        .speaker-photo,
        .speaker-placeholder {
            width: 116px;
            height: 116px;
            border-radius: 28px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--webinar-accent) 18%, transparent), transparent 34%),
                linear-gradient(135deg, #111827, #020617);
            border: 1px solid rgba(255,255,255,.16);
            box-shadow: 0 14px 34px rgba(0,0,0,.28);
            font-size: 42px;
            font-weight: 950;
            color: white;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: .9fr 1.1fr;
            gap: 22px;
            margin-top: 34px;
            align-items: stretch;
        }

        .schedule-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .countdown-card {
            border-radius: 26px;
            padding: 24px 14px;
            text-align: center;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.12);
        }

        .countdown-number {
            display: block;
            font-size: 38px;
            line-height: 1;
            font-weight: 950;
            color: white;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: .16em;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 900;
        }

        .map-card {
            margin-top: 28px;
            border-radius: 34px;
            overflow: hidden;
            background: rgba(255,255,255,.08);
            box-shadow: 0 20px 54px rgba(0,0,0,.28);
            border: 1px solid rgba(255,255,255,.12);
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
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--webinar-accent) 18%, transparent), transparent 32%),
                linear-gradient(135deg, #0f172a, #020617);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
            text-decoration: none;
            color: inherit;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr 1fr;
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-item {
            border-radius: 30px;
            overflow: hidden;
            background: rgba(255,255,255,.10);
            padding: 10px;
            box-shadow: 0 18px 46px rgba(0,0,0,.24);
            border: 1px solid rgba(255,255,255,.12);
        }

        .gallery-item:nth-child(2) {
            transform: translateY(28px);
        }

        .gallery-item img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 22px;
            display: block;
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
            .webinar-shell {
                padding: 16px;
            }

            .webinar-section {
                padding: 86px 38px;
            }

            .hero-grid,
            .overview-grid,
            .speaker-row,
            .schedule-grid,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .feature-grid.feature-count-3 {
                grid-template-columns: repeat(2, minmax(280px, 360px));
            }

            .gallery-item:nth-child(2) {
                transform: none;
            }

            .webinar-nav {
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .webinar-shell {
                padding: 0;
            }

            .feature-grid,
            .feature-grid.feature-count-1,
            .feature-grid.feature-count-2,
            .feature-grid.feature-count-3 {
                grid-template-columns: 1fr;
            }

            .webinar-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .webinar-section {
                padding: 76px 24px;
            }

            .webinar-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .webinar-title {
                font-size: 3rem;
                line-height: 1.02;
            }

            .webinar-label {
                letter-spacing: .18em;
                font-size: 11px;
            }

            .webinar-label::before {
                width: 24px;
            }

            .hero-copy {
                text-align: center;
            }

            .webinar-screen {
                min-height: 380px;
            }

            .screen-footer {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .countdown-grid {
                grid-template-columns: 1fr;
            }

            .floating-actions {
                right: 10px;
            }

            .gallery-item img {
                height: 220px;
            }
        }

        /* =====================================================
        LUXURY WEBINAR ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .webinar-reveal,
        .webinar-section > p,
        .webinar-section > h1,
        .webinar-section > h2,
        .webinar-section > h3,
        .webinar-label,
        .webinar-title,
        .webinar-gradient-text,
        .hero-copy,
        .webinar-stage,
        .webinar-screen,
        .webinar-card,
        .mini-stat,
        .feature-card,
        .feature-number,
        .speaker-card,
        .countdown-card,
        .map-card,
        .gallery-item,
        .webinar-btn,
        .webinar-nav {
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

        .webinar-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar masuk halus */
        .webinar-nav {
            animation: webinarNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-copy {
            animation: webinarHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .webinar-label {
            animation: webinarFadeDown .85s ease .12s both;
        }

        #opening .webinar-title {
            animation: webinarTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .webinar-btn {
            animation: webinarFadeUp .85s ease .52s both;
        }

        #opening .webinar-stage {
            animation:
                webinarStageEnter 1.1s cubic-bezier(.2, .8, .2, 1) .32s both,
                webinarStageFloat 5.2s ease-in-out 1.4s infinite;
        }

        /* Background digital bergerak halus */
        .webinar-wrap {
            animation: webinarWrapGlow 8s ease-in-out infinite alternate;
        }

        .webinar-wrap::before {
            animation: webinarGridMove 20s linear infinite;
        }

        .webinar-wrap::after {
            animation: webinarOrbFloat 7s ease-in-out infinite alternate;
        }

        /* Label garis glow */
        .webinar-label::before {
            animation: webinarLineGlow 2.8s ease-in-out infinite alternate;
        }

        /* Stage glow */
        .webinar-stage::after {
            content: "";
            position: absolute;
            inset: -14px;
            border-radius: 52px;
            border: 1px solid color-mix(in srgb, var(--webinar-accent) 34%, transparent);
            opacity: .7;
            pointer-events: none;
            animation: webinarFrameGlow 4.2s ease-in-out infinite alternate;
        }

        /* Live badge terasa hidup */
        .live-badge::before {
            animation: webinarLivePulse 1.5s ease-in-out infinite;
        }

        /* Screen dots bergerak */
        .screen-dots span {
            animation: webinarDotPulse 1.8s ease-in-out infinite;
        }

        .screen-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        .screen-dots span:nth-child(3) {
            animation-delay: .36s;
        }

        /* Tombol efek kilau */
        .webinar-btn,
        button.webinar-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .webinar-btn::after,
        button.webinar-btn::after,
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
            animation: webinarButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .webinar-card:hover,
            .mini-stat:hover,
            .feature-card:hover,
            .speaker-card:hover,
            .countdown-card:hover,
            .gallery-item:hover,
            .map-card:hover,
            .webinar-stage:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--webinar-accent) 42%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(0, 0, 0, .34),
                    0 0 46px color-mix(in srgb, var(--webinar-primary) 20%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.18) !important;
            }

            .webinar-stage:hover img,
            .gallery-item:hover img,
            .speaker-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.05);
            }

            .webinar-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--webinar-accent) 18%, transparent);
            }
        }

        .webinar-screen img,
        .gallery-item img,
        .speaker-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Feature number pulse */
        .feature-number {
            animation: webinarIconPulse 3s ease-in-out infinite;
        }

        /* Speaker glow */
        .speaker-card::before {
            animation: webinarSpeakerGlow 4s ease-in-out infinite alternate;
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: webinarNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: webinarFloatingButton 3.4s ease-in-out infinite;
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

        /* Gallery item tengah tetap punya animasi desktop */
        .gallery-item:nth-child(2) {
            animation: webinarGalleryMiddle 4.8s ease-in-out infinite;
        }

        /* Keyframes */
        @keyframes webinarNavEnter {
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

        @keyframes webinarHeroCopyIn {
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

        @keyframes webinarFadeDown {
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

        @keyframes webinarFadeUp {
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

        @keyframes webinarTitleIn {
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

        @keyframes webinarStageEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.92) rotate(2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes webinarStageFloat {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-8px) rotate(-.8deg) scale(1.012);
            }
        }

        @keyframes webinarWrapGlow {
            from {
                box-shadow:
                    0 34px 120px rgba(0, 0, 0, .45),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 40px 135px rgba(0, 0, 0, .52),
                    0 0 62px color-mix(in srgb, var(--webinar-primary) 18%, transparent);
            }
        }

        @keyframes webinarGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 128px 128px, 128px 128px;
            }
        }

        @keyframes webinarOrbFloat {
            from {
                transform: translateY(0) scale(1);
                opacity: .16;
            }
            to {
                transform: translateY(20px) scale(1.08);
                opacity: .28;
            }
        }

        @keyframes webinarLineGlow {
            from {
                opacity: .55;
                transform: scaleX(.86);
            }
            to {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        @keyframes webinarFrameGlow {
            from {
                opacity: .42;
                box-shadow: 0 0 0 color-mix(in srgb, var(--webinar-accent) 0%, transparent);
            }
            to {
                opacity: .95;
                box-shadow: 0 0 38px color-mix(in srgb, var(--webinar-accent) 24%, transparent);
            }
        }

        @keyframes webinarLivePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(255,255,255,.18);
            }
            50% {
                transform: scale(1.16);
                box-shadow: 0 0 0 10px rgba(255,255,255,.10);
            }
        }

        @keyframes webinarDotPulse {
            0%, 100% {
                opacity: .38;
                transform: translateY(0);
            }
            50% {
                opacity: .9;
                transform: translateY(-2px);
            }
        }

        @keyframes webinarButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes webinarIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 24px color-mix(in srgb, var(--webinar-primary) 20%, transparent);
            }
            50% {
                transform: translateY(-4px) scale(1.055);
                box-shadow:
                    0 18px 38px color-mix(in srgb, var(--webinar-primary) 28%, transparent),
                    0 0 30px color-mix(in srgb, var(--webinar-accent) 24%, transparent);
            }
        }

        @keyframes webinarSpeakerGlow {
            from {
                opacity: .10;
                transform: scale(1);
            }
            to {
                opacity: .22;
                transform: scale(1.08);
            }
        }

        @keyframes webinarNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--webinar-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--webinar-accent) 48%, transparent),
                    0 0 34px color-mix(in srgb, var(--webinar-primary) 22%, transparent);
            }
        }

        @keyframes webinarFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes webinarGalleryMiddle {
            0%, 100% {
                transform: translateY(28px);
            }
            50% {
                transform: translateY(18px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .webinar-reveal,
            .webinar-section > p,
            .webinar-section > h1,
            .webinar-section > h2,
            .webinar-section > h3,
            .webinar-label,
            .webinar-title,
            .webinar-gradient-text,
            .hero-copy,
            .webinar-stage,
            .webinar-screen,
            .webinar-card,
            .mini-stat,
            .feature-card,
            .feature-number,
            .speaker-card,
            .countdown-card,
            .map-card,
            .gallery-item,
            .webinar-btn,
            .webinar-nav {
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
            .webinar-reveal,
            .webinar-section > p,
            .webinar-section > h1,
            .webinar-section > h2,
            .webinar-section > h3,
            .webinar-label,
            .webinar-title,
            .webinar-gradient-text,
            .hero-copy,
            .webinar-stage,
            .webinar-screen,
            .webinar-card,
            .mini-stat,
            .feature-card,
            .feature-number,
            .speaker-card,
            .countdown-card,
            .map-card,
            .gallery-item,
            .webinar-btn,
            .webinar-nav,
            .webinar-wrap,
            .webinar-wrap::before,
            .webinar-wrap::after,
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
        FIX HERO DATE & DETAIL SCHEDULE RAPI
        ===================================================== */

        .hero-mini-value {
            display: block;
            color: #ffffff;
            font-weight: 950;
            margin-top: 6px;
            line-height: 1.25;
            white-space: normal;
            word-break: keep-all;
            overflow-wrap: normal;
        }

        .hero-mini-date {
            font-size: clamp(14px, 1.5vw, 17px);
            letter-spacing: -.02em;
        }

        .screen-footer .mini-stat {
            min-width: 0;
        }

        .screen-footer .mini-stat p:last-child {
            overflow-wrap: normal;
            word-break: keep-all;
        }

        .schedule-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .schedule-info-box {
            border-radius: 24px;
            padding: 18px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.10);
        }

        .schedule-info-box--full {
            grid-column: 1 / -1;
        }

        .schedule-info-label {
            margin: 0 0 8px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .schedule-info-value {
            margin: 0;
            color: #ffffff;
            font-size: clamp(18px, 2vw, 24px);
            line-height: 1.35;
            font-weight: 950;
            word-break: keep-all;
            overflow-wrap: anywhere;
        }

        .schedule-info-desc {
            margin-top: 10px;
            color: #cbd5e1;
            line-height: 1.65;
            word-break: break-word;
        }

        .schedule-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
        }

        /* Tablet */
        @media (max-width: 900px) {
            .screen-footer {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .mini-stat {
                padding: 12px 10px;
            }

            .hero-mini-date {
                font-size: 14px;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .screen-footer {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .mini-stat {
                padding: 12px 8px;
                border-radius: 18px;
            }

            .mini-stat p:first-child {
                font-size: 10px;
                letter-spacing: .12em;
            }

            .hero-mini-value {
                font-size: 13px;
                line-height: 1.3;
            }

            .hero-mini-date {
                font-size: 12.5px;
            }

            .schedule-info-grid {
                grid-template-columns: 1fr;
            }

            .schedule-info-box--full {
                grid-column: auto;
            }

            .schedule-info-value {
                font-size: 18px;
            }

            .schedule-action-row {
                flex-direction: column;
            }

            .schedule-action-row .webinar-btn {
                width: 100%;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'navy';

    $themes = [
        'maroon' => [
            'primary' => '#e11d48',
            'secondary' => '#be123c',
            'accent' => '#fb7185',
            'bg' => '#100711',
            'glow1' => 'rgba(225, 29, 72, .28)',
            'glow2' => 'rgba(251, 113, 133, .18)',
            'softGlow' => 'rgba(225, 29, 72, .18)',
        ],
        'emerald' => [
            'primary' => '#10b981',
            'secondary' => '#0f766e',
            'accent' => '#5eead4',
            'bg' => '#031714',
            'glow1' => 'rgba(16, 185, 129, .26)',
            'glow2' => 'rgba(94, 234, 212, .16)',
            'softGlow' => 'rgba(16, 185, 129, .18)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#7c3aed',
            'accent' => '#38bdf8',
            'bg' => '#020617',
            'glow1' => 'rgba(37, 99, 235, .28)',
            'glow2' => 'rgba(56, 189, 248, .18)',
            'softGlow' => 'rgba(124, 58, 237, .18)',
        ],
        'rose' => [
            'primary' => '#db2777',
            'secondary' => '#9333ea',
            'accent' => '#f9a8d4',
            'bg' => '#140716',
            'glow1' => 'rgba(219, 39, 119, .28)',
            'glow2' => 'rgba(249, 168, 212, .16)',
            'softGlow' => 'rgba(219, 39, 119, .18)',
        ],
        'gold' => [
            'primary' => '#f59e0b',
            'secondary' => '#b45309',
            'accent' => '#facc15',
            'bg' => '#120d04',
            'glow1' => 'rgba(245, 158, 11, .28)',
            'glow2' => 'rgba(250, 204, 21, .16)',
            'softGlow' => 'rgba(245, 158, 11, .18)',
        ],
        'slate' => [
            'primary' => '#64748b',
            'secondary' => '#334155',
            'accent' => '#cbd5e1',
            'bg' => '#020617',
            'glow1' => 'rgba(100, 116, 139, .22)',
            'glow2' => 'rgba(203, 213, 225, .12)',
            'softGlow' => 'rgba(100, 116, 139, .16)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];

    $firstPhoto = $invitation->photos->first();
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

    if (($invitation->event_mode ?? 'offline') === 'online') {
        $shareMessage .= "Mode Acara: Online\n";

        if ($locationText) {
            $shareMessage .= "Platform: {$locationText}\n";
        }

        if ($invitation->online_url) {
            $shareMessage .= "Link Online: {$invitation->online_url}\n";
        }
    } else {
        $shareMessage .= "Mode Acara: Offline\n";

        if ($locationText) {
            $shareMessage .= "Tempat: {$locationText}\n";
        }

        if ($invitation->address) {
            $shareMessage .= "Alamat: {$invitation->address}\n";
        }
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

            $calendarTitle = trim(($invitation->event_name ?: 'Webinar') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan webinar') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = ($invitation->event_mode ?? 'offline') === 'online'
                ? trim(($invitation->location_name ?: 'Online Webinar') . ($invitation->online_url ? ' - ' . $invitation->online_url : ''))
                : trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

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

    $eventMode = $invitation->event_mode ?: 'offline';
    $isOnlineEvent = $eventMode === 'online';
    $isOfflineEvent = ! $isOnlineEvent;

    $onlineUrl = $invitation->online_url ?: null;

    $modeLabel = $isOnlineEvent ? 'Online' : 'Offline';

    $platformText = $isOnlineEvent
        ? ($invitation->location_name ?: 'Online Webinar')
        : ($invitation->location_name ?: 'Lokasi belum diatur');

    $detailButtonText = $isOnlineEvent ? 'Masuk Webinar' : 'Buka Lokasi';

    $heroDateText = 'Belum diatur';
    $detailDateText = 'Tanggal belum diatur';
    $detailTimeText = 'Waktu belum diatur';

    try {
        if ($invitation->event_date) {
            $startDate = \Carbon\Carbon::parse($invitation->event_date);
            $endDate = $invitation->event_end_date
                ? \Carbon\Carbon::parse($invitation->event_end_date)
                : null;

            if ($endDate) {
                if ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                    // Contoh: 14–28 Mei 2026
                    $heroDateText = $startDate->format('d') . '–' . $endDate->format('d') . ' ' . $startDate->translatedFormat('M Y');
                } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                    // Contoh: 28 Mei – 02 Jun 2026
                    $heroDateText = $startDate->translatedFormat('d M') . ' – ' . $endDate->translatedFormat('d M Y');
                } else {
                    // Contoh: 28 Des 2026 – 02 Jan 2027
                    $heroDateText = $startDate->translatedFormat('d M Y') . ' – ' . $endDate->translatedFormat('d M Y');
                }

                $detailDateText = $heroDateText;
            } else {
                $heroDateText = $startDate->translatedFormat('d M Y');
                $detailDateText = $heroDateText;
            }
        }

        if (!empty($invitation->event_time)) {
            $startTime = \Carbon\Carbon::parse($invitation->event_time)->format('H:i');

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
                $detailTimeText = $startTime . ' - ' . $endTime;
            } else {
                $detailTimeText = $startTime;
            }
        }
    } catch (\Exception $e) {
        $heroDateText = 'Belum diatur';
        $detailDateText = 'Tanggal belum diatur';
        $detailTimeText = 'Waktu belum diatur';
    }

    $webinarHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();
@endphp

<body
    style="
        --webinar-primary: {{ $activeTheme['primary'] }};
        --webinar-secondary: {{ $activeTheme['secondary'] }};
        --webinar-accent: {{ $activeTheme['accent'] }};
        --webinar-bg: {{ $activeTheme['bg'] }};
        --webinar-glow-1: {{ $activeTheme['glow1'] }};
        --webinar-glow-2: {{ $activeTheme['glow2'] }};
        --webinar-soft-glow: {{ $activeTheme['softGlow'] }};
    "
>
    <main class="webinar-shell">
        <div class="webinar-wrap">

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

                @if ($isOnlineEvent && $onlineUrl)
                    <a href="{{ $onlineUrl }}" target="_blank" title="Masuk Online">
                        <img src="{{ asset('assets/icons/meeting.png') }}" alt="Masuk Online" class="floating-icon">
                    </a>
                @elseif ($isOfflineEvent && $mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ asset('assets/music/background3.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="webinar-nav">
                <a href="#overview">Overview</a>
                <a href="#speakers">Speakers</a>
                <a href="#schedule">Schedule</a>
                <a href="#message">RSVP</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="webinar-section">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="webinar-label">
                            Modern Webinar Invitation
                        </div>

                        <h1 class="responsive-text webinar-title webinar-gradient-text text-5xl md:text-7xl mt-8">
                            {{ $invitation->title ?: 'Webinar Modern' }}
                        </h1>

                        <p class="responsive-text text-slate-300 mt-7 leading-8 text-lg">
                            {{ $invitation->description ?: 'Bergabung dalam sesi webinar modern dengan pembicara inspiratif, insight praktis, dan pengalaman digital yang dirancang profesional.' }}
                        </p>

                        <div class="mt-9 flex flex-wrap gap-3 justify-center md:justify-start">
                            @if ($isOnlineEvent && $onlineUrl)
                                <a href="{{ $onlineUrl }}" target="_blank" class="webinar-btn">
                                    Masuk Webinar
                                </a>
                            @else
                                <a href="#schedule" class="webinar-btn">
                                    {{ $isOnlineEvent ? 'Detail Webinar' : 'Detail Acara' }}
                                </a>
                            @endif

                            <a href="#schedule" class="webinar-btn secondary">
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>

                    <div class="webinar-stage">
                        <div class="webinar-screen">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Webinar">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Webinar">
                            @endif

                            <div class="screen-topbar">
                                <div class="screen-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>

                                <div class="live-badge">
                                    {{ $isOnlineEvent ? 'Live Online' : 'Offline Event' }}
                                </div>
                            </div>

                            <div class="screen-content">
                                <p class="text-xs uppercase tracking-[.28em] font-black text-slate-300">
                                    {{ $invitation->event_name ?: 'Webinar' }}
                                </p>

                                <h2 class="responsive-text screen-title mt-4">
                                    {{ $invitation->title ?: 'Modern Webinar' }}
                                </h2>

                                <p class="responsive-text text-slate-300 mt-5">
                                    {{ $invitation->host_name ? 'Presented by ' . $invitation->host_name : 'Digital Event Experience' }}
                                </p>
                            </div>

                            <div class="screen-footer">
                                <div class="mini-stat">
                                    <p>Tanggal</p>
                                    <p class="hero-mini-value hero-mini-date">
                                        {{ $heroDateText }}
                                    </p>
                                </div>

                                <div class="mini-stat">
                                    <p>Waktu</p>
                                    <p class="hero-mini-value">
                                        {{ $detailTimeText }}
                                    </p>
                                </div>

                                <div class="mini-stat">
                                    <p>Mode</p>
                                    <p class="responsive-text">
                                        {{ $isOnlineEvent ? 'Online' : 'Offline' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- OVERVIEW --}}
            <section id="overview" class="webinar-section compact text-center">
                <p class="webinar-label justify-center">
                    Event Overview
                </p>

                <h2 class="responsive-text webinar-title text-5xl md:text-6xl mt-6">
                    {{ $invitation->seminar_about_title ?: 'Webinar Modern untuk Insight, Skill, dan Networking Digital' }}
                </h2>

                <p class="responsive-text text-slate-300 mt-6 max-w-3xl mx-auto leading-8 text-lg">
                    {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Acara ini dirancang untuk memberikan pengalaman belajar online yang rapi, profesional, dan mudah diikuti oleh peserta.' }}
                </p>

                @php
                    $highlightCount = $webinarHighlights->count();
                @endphp

                @if ($highlightCount)
                    <div class="feature-grid feature-count-{{ min($highlightCount, 3) }}">
                        @foreach ($webinarHighlights as $index => $highlight)
                            <div class="feature-card text-left">
                                <div class="feature-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                @if (!empty($highlight['title']))
                                    <h3 class="responsive-text text-xl font-black text-white">
                                        {{ $highlight['title'] }}
                                    </h3>
                                @endif

                                @if (!empty($highlight['description']))
                                    <p class="responsive-text text-slate-300 mt-3 leading-7">
                                        {{ $highlight['description'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- SPEAKERS --}}
            <section id="speakers" class="webinar-section compact text-center">
                <p class="webinar-label justify-center">
                    Webinar Speakers
                </p>

                <h2 class="webinar-title text-5xl md:text-6xl mt-6">
                    Pembicara & Narasumber
                </h2>

                <div class="speaker-row {{ $invitation->people->count() <= 1 ? 'single-speaker' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="speaker-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="speaker-photo"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="speaker-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'W', 0, 1)) }}
                                </div>
                            @endif

                            <h3 class="responsive-text text-2xl font-black text-white mt-5">
                                {{ $person->name ?: 'Nama Pembicara' }}
                            </h3>

                            @if ($person->subtitle)
                                <p class="responsive-text text-slate-300 mt-3">
                                    {{ $person->subtitle }}
                                </p>
                            @endif

                            @if ($person->family_name)
                                <p class="responsive-text text-slate-400 mt-2">
                                    {{ $person->family_name }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="speaker-card">
                            <div class="speaker-placeholder">W</div>

                            <h3 class="text-2xl font-black text-white mt-5">
                                Pembicara Webinar
                            </h3>

                            <p class="text-slate-400 mt-3">
                                Data pembicara belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- SCHEDULE --}}
            <section id="schedule" class="webinar-section compact">
                <div class="text-center">
                    <p class="webinar-label justify-center">
                        Schedule & Countdown
                    </p>

                    <h2 class="webinar-title text-5xl md:text-6xl mt-6">
                        Detail Webinar
                    </h2>
                </div>

                <div class="schedule-grid">
                    <div class="webinar-card schedule-panel">
                        <p class="text-sm uppercase tracking-[.22em] font-black text-slate-400">
                            Tanggal & Waktu
                        </p>

                        <div class="schedule-info-grid">
                            <div class="schedule-info-box">
                                <p class="schedule-info-label">Tanggal</p>
                                <p class="schedule-info-value">
                                    {{ $detailDateText }}
                                </p>
                            </div>

                            <div class="schedule-info-box">
                                <p class="schedule-info-label">Waktu</p>
                                <p class="schedule-info-value">
                                    {{ $detailTimeText }}
                                </p>
                            </div>

                            <div class="schedule-info-box schedule-info-box--full">
                                <p class="schedule-info-label">
                                    {{ $isOnlineEvent ? 'Platform Online' : 'Lokasi Acara' }}
                                </p>

                                <p class="schedule-info-value">
                                    {{ $platformText }}
                                </p>

                                @if (!empty($invitation->address))
                                    <p class="schedule-info-desc">
                                        {{ $invitation->address }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="schedule-action-row">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="webinar-btn">
                                    📅 Atur Pengingat
                                </a>
                            @endif

                            @if ($isOnlineEvent && $onlineUrl)
                                <a href="{{ $onlineUrl }}" target="_blank" class="webinar-btn secondary">
                                    🔗 Masuk Webinar
                                </a>
                            @elseif (!$isOnlineEvent && $mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="webinar-btn secondary">
                                    📍 Buka Lokasi
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="webinar-card">
                        <p class="text-sm uppercase tracking-[.22em] font-black text-slate-400 text-center" id="countdown-note">
                            @if ($countdownTarget)
                                Countdown menuju event
                            @else
                                Tanggal acara belum diatur
                            @endif
                        </p>

                        <div class="countdown-grid mt-6" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
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
                </div>

                @if (($isOnlineEvent && ($onlineUrl || $invitation->address || $invitation->location_name)) || (!$isOnlineEvent && ($invitation->address || $mapOpenUrl)))
                    <div class="map-card">
                        @if ($isOnlineEvent)
                            @if ($onlineUrl)
                                <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">🌐</p>
                                        <p class="responsive-text font-black mt-3 text-white">
                                            {{ $invitation->location_name ?: 'Online Webinar' }}
                                        </p>
                                        <p class="responsive-text text-slate-300 mt-2">
                                            {{ $invitation->address ?: 'Klik untuk masuk ke ruang webinar.' }}
                                        </p>
                                        <p class="responsive-text text-sky-300 mt-4 font-bold">
                                            Masuk Webinar →
                                        </p>
                                    </div>
                                </a>
                            @else
                                <div class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">🌐</p>
                                        <p class="responsive-text font-black mt-3 text-white">
                                            {{ $invitation->location_name ?: 'Online Webinar' }}
                                        </p>
                                        <p class="responsive-text text-slate-300 mt-2">
                                            {{ $invitation->address ?: 'Link webinar belum ditambahkan.' }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @else
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
                                        <p class="responsive-text font-black mt-3 text-white">
                                            {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                        </p>
                                        <p class="responsive-text text-slate-300 mt-2">
                                            {{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}
                                        </p>
                                    </div>
                                </a>
                            @else
                                <div class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">📍</p>
                                        <p class="responsive-text font-black mt-3 text-white">
                                            {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                        </p>
                                        <p class="responsive-text text-slate-300 mt-2">
                                            {{ $invitation->address }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </section>

            {{-- GALLERY --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="webinar-section compact text-center">
                    <p class="webinar-label justify-center">
                        Event Media
                    </p>

                    <h2 class="webinar-title text-5xl md:text-6xl mt-6">
                        Galeri Event
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Webinar">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="webinar-section compact">
                <div class="text-center">
                    <p class="webinar-label justify-center">
                        Register & RSVP
                    </p>

                    <h2 class="webinar-title text-5xl md:text-6xl mt-6">
                        Konfirmasi Kehadiran
                    </h2>

                    <p class="text-slate-400 mt-3">
                        Isi data kehadiran dan pesan untuk panitia
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
                          class="webinar-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label text-slate-300">Nama Peserta</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama lengkap"
                                   required>
                        </div>

                        <div>
                            <label class="uk-label text-slate-300">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="uk-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="uk-label text-slate-300">Jumlah Peserta</label>
                            <input type="number"
                                   name="guest_count"
                                   value="{{ old('guest_count', 1) }}"
                                   min="1"
                                   max="10"
                                   class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label text-slate-300">Pesan / Pertanyaan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis pesan atau pertanyaan untuk panitia..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full webinar-btn">
                            Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="webinar-card">
                            <p class="text-3xl font-black text-white">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">Tidak hadir</p>
                        </div>

                        <div class="webinar-card">
                            <p class="text-3xl font-black text-white">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">Hadir</p>
                        </div>

                        <div class="webinar-card">
                            <p class="text-3xl font-black text-white">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="webinar-card guest-message-card">
                                <div class="guest-message-header">
                                    <div class="guest-message-info">
                                        <p class="responsive-text font-black text-white">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="shrink-0 text-xs px-3 py-1 rounded-full bg-blue-500/20 text-blue-100">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text guest-message-text text-slate-300 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="webinar-card text-center">
                                <p class="text-slate-400">
                                    Belum ada konfirmasi.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="webinar-section text-center">
                <p class="webinar-label justify-center">
                    {{ $isOnlineEvent ? 'See You Online' : 'See You At The Event' }}
                </p>

                <h2 class="responsive-text webinar-title webinar-gradient-text text-5xl md:text-7xl mt-8">
                    Terima Kasih
                </h2>

                <p class="responsive-text text-slate-300 mt-6 leading-8 max-w-2xl mx-auto">
                    Terima kasih atas perhatian dan partisipasi Anda.
                    {{ $isOnlineEvent ? 'Sampai jumpa di sesi webinar.' : 'Sampai jumpa di lokasi acara.' }}
                </p>

                <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-white">
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
                            ? 'Countdown menuju event'
                            : 'Event sedang berlangsung atau telah dimulai';
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
                .webinar-section > p,
                .webinar-section > h1,
                .webinar-section > h2,
                .webinar-section > h3,
                .webinar-label,
                .webinar-title,
                .webinar-gradient-text,
                .hero-copy,
                .webinar-stage,
                .webinar-screen,
                .webinar-card,
                .mini-stat,
                .feature-card,
                .feature-number,
                .speaker-card,
                .countdown-card,
                .map-card,
                .gallery-item,
                .webinar-btn,
                .webinar-nav
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('webinar-show');
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
