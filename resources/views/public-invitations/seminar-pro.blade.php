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
            color: var(--seminar-dark);
            background:
                radial-gradient(circle at top left, var(--seminar-body-1), transparent 34%),
                radial-gradient(circle at top right, var(--seminar-body-2), transparent 30%),
                linear-gradient(180deg, var(--seminar-bg) 0%, #ffffff 46%, var(--seminar-soft) 100%);
        }

        .seminar-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .seminar-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.96), rgba(255,255,255,.88)),
                radial-gradient(circle at 12% 12%, var(--seminar-glow-1), transparent 24%),
                radial-gradient(circle at 88% 16%, var(--seminar-glow-2), transparent 30%);
            box-shadow: 0 34px 100px rgba(15, 23, 42, .16);
        }

        .seminar-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(color-mix(in srgb, var(--seminar-primary) 7%, transparent) 1px, transparent 1px),
                linear-gradient(90deg, color-mix(in srgb, var(--seminar-primary) 7%, transparent) 1px, transparent 1px);
            background-size: 70px 70px;
            opacity: .35;
            pointer-events: none;
            z-index: 0;
        }

        .seminar-wrap::after {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            right: -180px;
            top: -180px;
            border-radius: 999px;
            border: 1px solid color-mix(in srgb, var(--seminar-accent) 38%, transparent);
            box-shadow:
                0 0 0 48px color-mix(in srgb, var(--seminar-accent) 8%, transparent),
                0 0 0 96px color-mix(in srgb, var(--seminar-primary) 5%, transparent);
            opacity: .9;
            pointer-events: none;
            z-index: 0;
        }

        .seminar-wrap > * {
            position: relative;
            z-index: 1;
        }

        .seminar-section {
            min-height: 100vh;
            padding: 96px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .seminar-section.compact {
            min-height: auto;
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .meta-date-line,
        .meta-time-line {
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

        .meta-date-line span,
        .meta-time-line span {
            display: inline;
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

        .seminar-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--seminar-primary);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .28em;
            text-transform: uppercase;
        }

        .seminar-label::before {
            content: "";
            width: 42px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--seminar-primary), var(--seminar-accent));
            display: inline-block;
        }

        .seminar-title {
            color: var(--seminar-dark);
            letter-spacing: -.055em;
            line-height: .98;
            font-weight: 950;
        }

        .seminar-gradient-text {
            background: linear-gradient(135deg, var(--seminar-primary), var(--seminar-secondary), var(--seminar-accent));
            -webkit-background-clip: text;
            color: transparent;
        }

        .seminar-card {
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 13%, transparent);
            border-radius: 34px;
            box-shadow: 0 22px 56px rgba(15, 23, 42, .10);
            padding: 30px;
            backdrop-filter: blur(14px);
        }

        .seminar-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            padding: 14px 26px;
            color: white;
            text-decoration: none;
            font-weight: 900;
            background: linear-gradient(135deg, var(--seminar-primary), var(--seminar-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--seminar-primary) 28%, transparent);
            border: none;
            cursor: pointer;
        }

        .seminar-btn.secondary {
            background: linear-gradient(135deg, var(--seminar-accent), var(--seminar-primary));
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
            background: color-mix(in srgb, var(--seminar-accent) 22%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            gap: 48px;
            align-items: center;
        }

        .hero-copy {
            max-width: 650px;
        }

        .conference-board {
            position: relative;
            border-radius: 42px;
            padding: 18px;
            background:
                linear-gradient(135deg, var(--seminar-primary), var(--seminar-accent)),
                rgba(255,255,255,.9);
            box-shadow: 0 30px 80px rgba(15, 23, 42, .22);
        }

        .conference-screen {
            border-radius: 30px;
            overflow: hidden;
            min-height: 440px;
            background:
                radial-gradient(circle at 28% 22%, color-mix(in srgb, var(--seminar-accent) 20%, white), transparent 34%),
                linear-gradient(145deg, #ffffff, var(--seminar-soft));
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 36px;
            position: relative;
        }

        .conference-screen img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .conference-screen::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,.16), rgba(15,23,42,.42));
            opacity: var(--cover-overlay-opacity);
        }

        .screen-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .screen-placeholder {
            font-size: 80px;
            font-weight: 950;
            color: var(--seminar-primary);
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 34px;
        }

        .meta-card {
            border-radius: 26px;
            background: rgba(255,255,255,.86);
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 12%, transparent);
            padding: 20px;
            min-height: 122px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .meta-label {
            font-size: 11px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 900;
        }

        .meta-value {
            margin-top: 10px;
            color: var(--seminar-dark);
            font-size: 18px;
            font-weight: 950;
            line-height: 1.35;
        }

        .speaker-grid {
            display: grid;
            gap: 20px;
            margin-top: 36px;
            justify-content: center;
        }

        .speaker-grid.speaker-count-1 {
            grid-template-columns: minmax(280px, 360px);
        }

        .speaker-grid.speaker-count-2 {
            grid-template-columns: repeat(2, minmax(280px, 360px));
        }

        .speaker-grid.speaker-count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .speaker-card {
            text-align: center;
            border-radius: 34px;
            padding: 26px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.82));
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
        }

        .speaker-photo,
        .speaker-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            object-fit: cover;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--seminar-accent) 18%, white), transparent 34%),
                linear-gradient(135deg, var(--seminar-soft), white);
            border: 6px solid white;
            box-shadow: 0 14px 32px rgba(15, 23, 42, .12);
            font-size: 40px;
            font-weight: 900;
            color: var(--seminar-primary);
        }

        .agenda-grid {
            display: grid;
            gap: 20px;
            margin-top: 36px;
            justify-content: center;
        }

        .agenda-grid.agenda-count-1 {
            grid-template-columns: minmax(280px, 360px);
        }

        .agenda-grid.agenda-count-2 {
            grid-template-columns: repeat(2, minmax(280px, 360px));
        }

        .agenda-grid.agenda-count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .agenda-card {
            border-radius: 30px;
            padding: 26px;
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
        }

        .agenda-number {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--seminar-primary), var(--seminar-accent));
            margin-bottom: 18px;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            max-width: 680px;
            margin: 34px auto 0;
        }

        .countdown-card {
            border-radius: 28px;
            padding: 26px 14px;
            text-align: center;
            background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.80));
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 14%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .08);
        }

        .countdown-number {
            display: block;
            font-size: 38px;
            line-height: 1;
            font-weight: 950;
            color: var(--seminar-primary);
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

        .map-card {
            width: min(100%, 760px);
            margin: 28px auto 0;
            border-radius: 34px;
            overflow: hidden;
            background: white;
            box-shadow: 0 20px 54px rgba(15, 23, 42, .12);
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 12%, transparent);
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
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--seminar-accent) 16%, white), transparent 32%),
                linear-gradient(135deg, var(--seminar-soft), white);
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
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-item {
            border-radius: 30px;
            overflow: hidden;
            background: white;
            padding: 10px;
            box-shadow: 0 18px 46px rgba(15, 23, 42, .10);
            border: 1px solid color-mix(in srgb, var(--seminar-primary) 12%, transparent);
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
            .seminar-shell {
                padding: 16px;
            }

            .seminar-section {
                padding: 86px 38px;
            }

            .hero-grid,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .speaker-grid.speaker-count-3,
            .agenda-grid.agenda-count-3 {
                grid-template-columns: repeat(2, minmax(280px, 360px));
            }

            .speaker-grid.speaker-count-1,
            .agenda-grid.agenda-count-1 {
                grid-template-columns: minmax(280px, 360px);
            }

            .speaker-grid.speaker-count-2,
            .agenda-grid.agenda-count-2 {
                grid-template-columns: repeat(2, minmax(280px, 360px));
            }

            .meta-grid,
            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .seminar-shell {
                padding: 0;
            }

            .seminar-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .seminar-section {
                padding: 76px 24px;
            }

            .speaker-grid,
            .speaker-grid.speaker-count-1,
            .speaker-grid.speaker-count-2,
            .speaker-grid.speaker-count-3,
            .agenda-grid,
            .agenda-grid.agenda-count-1,
            .agenda-grid.agenda-count-2,
            .agenda-grid.agenda-count-3 {
                grid-template-columns: 1fr;
            }

            .seminar-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .seminar-title {
                font-size: 3rem;
                line-height: 1.03;
            }

            .seminar-label {
                letter-spacing: .18em;
                font-size: 11px;
            }

            .seminar-label::before {
                width: 24px;
            }

            .hero-copy {
                text-align: center;
            }

            .conference-screen {
                min-height: 360px;
            }

            .meta-grid,
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
        LUXURY SEMINAR ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .seminar-reveal,
        .seminar-section > p,
        .seminar-section > h1,
        .seminar-section > h2,
        .seminar-section > h3,
        .seminar-label,
        .seminar-title,
        .seminar-gradient-text,
        .hero-copy,
        .conference-board,
        .conference-screen,
        .meta-card,
        .speaker-card,
        .agenda-card,
        .agenda-number,
        .countdown-card,
        .seminar-card,
        .map-card,
        .gallery-item,
        .seminar-btn {
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

        .seminar-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Hero langsung tampil elegan */
        #opening .hero-copy {
            animation: seminarHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .seminar-label {
            animation: seminarFadeDown .85s ease .12s both;
        }

        #opening .seminar-title {
            animation: seminarTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .seminar-btn {
            animation: seminarFadeUp .85s ease .52s both;
        }

        #opening .conference-board {
            animation:
                seminarBoardEnter 1.1s cubic-bezier(.2, .8, .2, 1) .32s both,
                seminarBoardFloat 5s ease-in-out 1.4s infinite;
        }

        /* Background premium bergerak */
        .seminar-wrap {
            animation: seminarWrapGlow 8s ease-in-out infinite alternate;
        }

        .seminar-wrap::before {
            animation: seminarGridMove 20s linear infinite;
        }

        .seminar-wrap::after {
            animation: seminarCircleFloat 7s ease-in-out infinite alternate;
        }

        /* Label garis hidup */
        .seminar-label::before {
            animation: seminarLineGlow 2.8s ease-in-out infinite alternate;
        }

        /* Conference screen glow */
        .conference-board::after {
            content: "";
            position: absolute;
            inset: -14px;
            border-radius: 54px;
            border: 1px solid color-mix(in srgb, var(--seminar-accent) 36%, transparent);
            opacity: .72;
            pointer-events: none;
            animation: seminarFrameGlow 4.2s ease-in-out infinite alternate;
        }

        .conference-screen img,
        .gallery-item img,
        .speaker-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Button efek kilau */
        .seminar-btn,
        button.seminar-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .seminar-btn::after,
        button.seminar-btn::after,
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
            animation: seminarButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .seminar-card:hover,
            .meta-card:hover,
            .speaker-card:hover,
            .agenda-card:hover,
            .countdown-card:hover,
            .gallery-item:hover,
            .map-card:hover,
            .conference-board:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--seminar-accent) 38%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(15, 23, 42, .16),
                    0 0 46px color-mix(in srgb, var(--seminar-primary) 16%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.76) !important;
            }

            .conference-board:hover img,
            .gallery-item:hover img,
            .speaker-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }
        }

        /* Agenda number pulse */
        .agenda-number {
            animation: seminarIconPulse 3s ease-in-out infinite;
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: seminarNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: seminarFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes seminarHeroCopyIn {
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

        @keyframes seminarFadeDown {
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

        @keyframes seminarFadeUp {
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

        @keyframes seminarTitleIn {
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

        @keyframes seminarBoardEnter {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.92) rotate(2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes seminarBoardFloat {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-8px) rotate(-.8deg) scale(1.012);
            }
        }

        @keyframes seminarWrapGlow {
            from {
                box-shadow:
                    0 34px 100px rgba(15, 23, 42, .16),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 40px 118px rgba(15, 23, 42, .18),
                    0 0 58px color-mix(in srgb, var(--seminar-primary) 13%, transparent);
            }
        }

        @keyframes seminarGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 140px 140px, 140px 140px;
            }
        }

        @keyframes seminarCircleFloat {
            from {
                transform: translateY(0) scale(1);
                opacity: .78;
            }
            to {
                transform: translateY(18px) scale(1.045);
                opacity: .95;
            }
        }

        @keyframes seminarLineGlow {
            from {
                opacity: .55;
                transform: scaleX(.86);
            }
            to {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        @keyframes seminarFrameGlow {
            from {
                opacity: .45;
                box-shadow: 0 0 0 color-mix(in srgb, var(--seminar-accent) 0%, transparent);
            }
            to {
                opacity: .95;
                box-shadow: 0 0 34px color-mix(in srgb, var(--seminar-accent) 20%, transparent);
            }
        }

        @keyframes seminarButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes seminarIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 24px color-mix(in srgb, var(--seminar-primary) 16%, transparent);
            }
            50% {
                transform: translateY(-4px) scale(1.055);
                box-shadow:
                    0 18px 38px color-mix(in srgb, var(--seminar-primary) 24%, transparent),
                    0 0 28px color-mix(in srgb, var(--seminar-accent) 20%, transparent);
            }
        }

        @keyframes seminarNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--seminar-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--seminar-accent) 42%, transparent),
                    0 0 34px color-mix(in srgb, var(--seminar-primary) 18%, transparent);
            }
        }

        @keyframes seminarFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .seminar-reveal,
            .seminar-section > p,
            .seminar-section > h1,
            .seminar-section > h2,
            .seminar-section > h3,
            .seminar-label,
            .seminar-title,
            .seminar-gradient-text,
            .hero-copy,
            .conference-board,
            .conference-screen,
            .meta-card,
            .speaker-card,
            .agenda-card,
            .agenda-number,
            .countdown-card,
            .seminar-card,
            .map-card,
            .gallery-item,
            .seminar-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .seminar-reveal,
            .seminar-section > p,
            .seminar-section > h1,
            .seminar-section > h2,
            .seminar-section > h3,
            .seminar-label,
            .seminar-title,
            .seminar-gradient-text,
            .hero-copy,
            .conference-board,
            .conference-screen,
            .meta-card,
            .speaker-card,
            .agenda-card,
            .agenda-number,
            .countdown-card,
            .seminar-card,
            .map-card,
            .gallery-item,
            .seminar-btn,
            .seminar-wrap,
            .seminar-wrap::before,
            .seminar-wrap::after,
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
    $themeColor = $invitation->theme_color ?? 'navy';

    $themes = [
        'maroon' => [
            'primary' => '#7f1d1d',
            'secondary' => '#be123c',
            'accent' => '#d4af37',
            'dark' => '#1f1517',
            'bg' => '#fff7f5',
            'soft' => '#fff1f2',
            'body1' => 'rgba(127, 29, 29, .14)',
            'body2' => 'rgba(212, 175, 55, .16)',
            'glow1' => 'rgba(212, 175, 55, .18)',
            'glow2' => 'rgba(190, 18, 60, .10)',
        ],
        'emerald' => [
            'primary' => '#064e3b',
            'secondary' => '#0f766e',
            'accent' => '#d4af37',
            'dark' => '#0f2f2a',
            'bg' => '#f5fffb',
            'soft' => '#ecfdf5',
            'body1' => 'rgba(6, 78, 59, .15)',
            'body2' => 'rgba(212, 175, 55, .12)',
            'glow1' => 'rgba(212, 175, 55, .14)',
            'glow2' => 'rgba(15, 118, 110, .10)',
        ],
        'navy' => [
            'primary' => '#0f172a',
            'secondary' => '#2563eb',
            'accent' => '#d4af37',
            'dark' => '#0f172a',
            'bg' => '#f8fafc',
            'soft' => '#eef2ff',
            'body1' => 'rgba(15, 23, 42, .13)',
            'body2' => 'rgba(37, 99, 235, .11)',
            'glow1' => 'rgba(212, 175, 55, .14)',
            'glow2' => 'rgba(37, 99, 235, .10)',
        ],
        'rose' => [
            'primary' => '#9f1239',
            'secondary' => '#db2777',
            'accent' => '#d4af37',
            'dark' => '#4a2433',
            'bg' => '#fff7fa',
            'soft' => '#fff1f2',
            'body1' => 'rgba(159, 18, 57, .14)',
            'body2' => 'rgba(219, 39, 119, .10)',
            'glow1' => 'rgba(212, 175, 55, .15)',
            'glow2' => 'rgba(219, 39, 119, .10)',
        ],
        'gold' => [
            'primary' => '#7c2d12',
            'secondary' => '#b45309',
            'accent' => '#d4af37',
            'dark' => '#3f2516',
            'bg' => '#fffaf0',
            'soft' => '#fff7ed',
            'body1' => 'rgba(180, 83, 9, .14)',
            'body2' => 'rgba(212, 175, 55, .16)',
            'glow1' => 'rgba(212, 175, 55, .18)',
            'glow2' => 'rgba(180, 83, 9, .10)',
        ],
        'slate' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'accent' => '#d4af37',
            'dark' => '#1e293b',
            'bg' => '#f8fafc',
            'soft' => '#ffffff',
            'body1' => 'rgba(51, 65, 85, .12)',
            'body2' => 'rgba(212, 175, 55, .12)',
            'glow1' => 'rgba(212, 175, 55, .12)',
            'glow2' => 'rgba(100, 116, 139, .10)',
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

    $isOnlineEvent = ($invitation->event_mode ?? 'offline') === 'online';
    $isOfflineEvent = ! $isOnlineEvent;

    $eventModeLabel = $isOnlineEvent ? 'Online' : 'Offline';

    $venueLabel = $isOnlineEvent ? 'Platform' : 'Venue';

    $venueText = $isOnlineEvent
        ? ($invitation->location_name ?: 'Online Event')
        : ($invitation->location_name ?: 'Belum diatur');

    $onlineUrl = $invitation->online_url ?: null;

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

    if ($isOnlineEvent) {
        $shareMessage .= "Mode Acara: Online\n";

        if ($venueText) {
            $shareMessage .= "Platform: {$venueText}\n";
        }

        if ($onlineUrl) {
            $shareMessage .= "Link Online: {$onlineUrl}\n";
        }
    } else {
        if ($locationText) {
            $shareMessage .= "Tempat: {$locationText}\n";
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

            $calendarTitle = trim(($invitation->event_name ?: 'Seminar') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan seminar') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = $isOnlineEvent
                 ? trim(($venueText ?: 'Online Event') . ($onlineUrl ? ' - ' . $onlineUrl : ''))
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
@endphp

<body
    style="
        --seminar-primary: {{ $activeTheme['primary'] }};
        --seminar-secondary: {{ $activeTheme['secondary'] }};
        --seminar-accent: {{ $activeTheme['accent'] }};
        --seminar-dark: {{ $activeTheme['dark'] }};
        --seminar-bg: {{ $activeTheme['bg'] }};
        --seminar-soft: {{ $activeTheme['soft'] }};
        --seminar-body-1: {{ $activeTheme['body1'] }};
        --seminar-body-2: {{ $activeTheme['body2'] }};
        --seminar-glow-1: {{ $activeTheme['glow1'] }};
        --seminar-glow-2: {{ $activeTheme['glow2'] }};
        --cover-overlay-opacity: {{ $invitation->cover_image || $firstPhoto ? '.75' : '0' }};
    "
>
    <main class="seminar-shell">
        <div class="seminar-wrap">

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

            {{-- HERO --}}
            <section id="opening" class="seminar-section">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <div class="seminar-label">
                            Professional Event Invitation
                        </div>

                        <h1 class="responsive-text seminar-title seminar-gradient-text text-5xl md:text-7xl mt-8">
                            {{ $invitation->title ?: 'Seminar Profesional' }}
                        </h1>

                        <p class="responsive-text text-slate-600 mt-7 leading-8 text-lg">
                            {{ $invitation->description ?: 'Kami mengundang Anda untuk menghadiri seminar profesional dengan pembahasan relevan, narasumber kompeten, dan suasana acara yang dirancang untuk membuka wawasan baru.' }}
                        </p>

                        <div class="mt-9 flex flex-wrap gap-3 justify-center md:justify-start">
                            <a href="#about" class="seminar-btn">
                                Buka Undangan
                            </a>

                            <a href="#detail" class="seminar-btn secondary">
                                Lihat Jadwal
                            </a>
                        </div>

                        <div class="meta-grid">
                            <div class="meta-card">
                                <p class="meta-label">Jenis</p>
                                <p class="responsive-text meta-value">
                                    {{ $invitation->event_name ?: 'Seminar' }}
                                </p>
                            </div>

                            <div class="meta-card">
                                <p class="meta-label mb-6">Tanggal</p>
                                <p class="meta-date-line meta-value">
                                    @if ($invitation->event_date)
                                        {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}

                                        @if ($invitation->event_end_date)
                                                - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                        @endif
                                    @else
                                        Belum diatur
                                    @endif
                                </p>
                            </div>

                            <div class="meta-card">
                                <p class="meta-label">{{ $venueLabel }}</p>
                                <p class="responsive-text meta-value">
                                    {{ $venueText }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="conference-board">
                        <div class="conference-screen">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Seminar">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Seminar">
                            @else
                                <div class="screen-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($invitation->title ?: 'S', 0, 1)) }}
                                </div>
                            @endif

                            @if ($invitation->cover_image || $firstPhoto)
                                <div class="screen-content">
                                    <p class="text-xs uppercase tracking-[.28em] font-black">
                                        Seminar Pro
                                    </p>

                                    <h2 class="responsive-text text-4xl font-black mt-4">
                                        {{ $invitation->title ?: 'Seminar Profesional' }}
                                    </h2>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            <section id="about" class="seminar-section compact text-center">
                <p class="seminar-label justify-center">
                    About The Event
                </p>

                <h2 class="responsive-text seminar-title text-5xl md:text-6xl mt-6">
                    {{ $invitation->seminar_about_title ?: 'Seminar yang Dirancang untuk Insight, Networking, dan Aksi' }}
                </h2>

                <p class="responsive-text text-slate-600 mt-6 max-w-3xl mx-auto leading-8 text-lg">
                    {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Acara ini disusun untuk menghadirkan pengalaman profesional, materi yang terarah, serta kesempatan membangun koneksi dengan peserta dan pembicara.' }}
                </p>

                @php
                    $seminarHighlights = collect($invitation->event_highlights ?? [])
                        ->filter(function ($item) {
                            return !empty($item['title']) || !empty($item['description']);
                        })
                        ->take(12)
                        ->values();
                @endphp

                @php
                    $highlightCount = $seminarHighlights->count();
                @endphp

                @if ($highlightCount)
                    <div class="agenda-grid agenda-count-{{ min($highlightCount, 3) }}">
                        @foreach ($seminarHighlights as $index => $highlight)
                            <div class="agenda-card text-left">
                                <div class="agenda-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                @if (!empty($highlight['title']))
                                    <h3 class="responsive-text text-xl font-black text-slate-900">
                                        {{ $highlight['title'] }}
                                    </h3>
                                @endif

                                @if (!empty($highlight['description']))
                                    <p class="responsive-text text-slate-600 mt-3 leading-7">
                                        {{ $highlight['description'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- SPEAKERS --}}
            <section id="speakers" class="seminar-section compact text-center">
                <p class="seminar-label justify-center">
                    Featured Speakers
                </p>

                <h2 class="seminar-title text-5xl md:text-6xl mt-6">
                    Pembicara Acara
                </h2>

                @php
                    $speakerCount = $invitation->people->count();
                @endphp

                <div class="speaker-grid speaker-count-{{ min(max($speakerCount, 1), 3) }}">
                    @forelse ($invitation->people as $person)
                        <div class="speaker-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="speaker-photo"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="speaker-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'S', 0, 1)) }}
                                </div>
                            @endif

                            <h3 class="responsive-text text-2xl font-black text-slate-900 mt-4">
                                {{ $person->name ?: 'Nama Pembicara' }}
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
                        <div class="speaker-card">
                            <div class="speaker-placeholder">S</div>

                            <h3 class="text-2xl font-black text-slate-900 mt-4">
                                Pembicara Utama
                            </h3>

                            <p class="text-slate-500 mt-3">
                                Data pembicara belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="seminar-section compact text-center">
                <p class="seminar-label justify-center">
                    Event Schedule
                </p>

                <h2 class="seminar-title text-5xl md:text-6xl mt-6">
                    Detail Acara
                </h2>

                <div class="meta-grid">
                    @if ($isOnlineEvent)
                        <div class="seminar-card mt-6 max-w-3xl mx-auto text-center">
                            <p class="meta-label">
                                Link Online
                            </p>

                            <p class="responsive-text text-slate-700 mt-3 leading-7">
                                {{ $venueText }}
                            </p>

                            @if ($onlineUrl)
                                <div class="mt-5">
                                    <a href="{{ $onlineUrl }}" target="_blank" class="seminar-btn">
                                        🔗 Masuk ke Acara Online
                                    </a>
                                </div>
                            @else
                                <p class="text-slate-500 mt-4">
                                    Link online belum ditambahkan oleh penyelenggara.
                                </p>
                            @endif
                        </div>
                    @endif
                    <div class="meta-card">
                        <p class="meta-label mb-6">Tanggal</p>
                        <p class="meta-date-line meta-value">
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

                    <div class="meta-card">
                        <p class="meta-label mb-6">Waktu</p>
                        <p class="meta-time-line meta-value">
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

                    <div class="meta-card">
                        <p class="meta-label">{{ $isOnlineEvent ? 'Mode Acara' : 'Lokasi' }}</p>
                        <p class="responsive-text meta-value">
                            {{ $isOnlineEvent ? 'Online' : $venueText }}
                        </p>
                    </div>
                </div>

                @if ($isOfflineEvent && $invitation->address)
                    <div class="seminar-card mt-6 max-w-3xl mx-auto text-center">
                        <p class="meta-label">
                            Alamat Lengkap
                        </p>

                        <p class="responsive-text text-slate-700 mt-3 leading-7">
                            {{ $invitation->address }}
                        </p>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @if ($googleCalendarUrl)
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="seminar-btn">
                            📅 Atur Pengingat
                        </a>
                    @endif

                    @if ($isOnlineEvent && $onlineUrl)
                        <a href="{{ $onlineUrl }}" target="_blank" class="seminar-btn secondary">
                            🔗 Masuk Online
                        </a>
                    @elseif ($isOfflineEvent && $mapOpenUrl)
                        <a href="{{ $mapOpenUrl }}" target="_blank" class="seminar-btn secondary">
                            📍 Buka Maps
                        </a>
                    @endif
                </div>

                @if ($isOfflineEvent && $mapOpenUrl)
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
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                <div>
                                    <p class="text-5xl">📍</p>
                                    <p class="responsive-text font-black mt-3" style="color: var(--seminar-dark)">
                                        {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                    </p>
                                    <p class="text-slate-500 mt-2">
                                        Klik untuk membuka lokasi acara.
                                    </p>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </section>

            {{-- COUNTDOWN --}}
            <section id="countdown" class="seminar-section compact text-center">
                <p class="seminar-label justify-center">
                    Registration Reminder
                </p>

                <h2 class="seminar-title text-5xl md:text-6xl mt-6">
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
                <section id="gallery" class="seminar-section compact text-center">
                    <p class="seminar-label justify-center">
                        Event Gallery
                    </p>

                    <h2 class="seminar-title text-5xl md:text-6xl mt-6">
                        Galeri Acara
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Seminar">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="seminar-section compact">
                <div class="text-center">
                    <p class="seminar-label justify-center">
                        RSVP & Guest Book
                    </p>

                    <h2 class="seminar-title text-5xl md:text-6xl mt-6">
                        Konfirmasi Kehadiran
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Isi data kehadiran dan pesan singkat untuk panitia
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
                          class="seminar-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Peserta</label>
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
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="uk-label">Jumlah Peserta</label>
                            <input type="number"
                                   name="guest_count"
                                   value="{{ old('guest_count', 1) }}"
                                   min="1"
                                   max="10"
                                   class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Pesan / Pertanyaan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis pesan atau pertanyaan untuk panitia..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full seminar-btn">
                            Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="seminar-card">
                            <p class="text-3xl font-black" style="color: var(--seminar-dark)">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="seminar-card">
                            <p class="text-3xl font-black" style="color: var(--seminar-dark)">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="seminar-card">
                            <p class="text-3xl font-black" style="color: var(--seminar-dark)">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="seminar-card guest-message-card">
                                <div class="guest-message-header">
                                    <div class="guest-message-info">
                                        <p class="responsive-text font-black" style="color: var(--seminar-dark)">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="shrink-0 text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text guest-message-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="seminar-card text-center">
                                <p class="text-slate-500">
                                    Belum ada konfirmasi.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="seminar-section text-center">
                <p class="seminar-label justify-center">
                    See You At The Event
                </p>

                <h2 class="responsive-text seminar-title seminar-gradient-text text-5xl md:text-7xl mt-8">
                    Terima Kasih
                </h2>

                <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                    Terima kasih atas perhatian dan partisipasi Anda.
                    Kami menantikan kehadiran Anda dalam acara ini.
                </p>

                <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--seminar-dark)">
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
                .seminar-section > p,
                .seminar-section > h1,
                .seminar-section > h2,
                .seminar-section > h3,
                .seminar-label,
                .seminar-title,
                .seminar-gradient-text,
                .hero-copy,
                .conference-board,
                .conference-screen,
                .meta-card,
                .speaker-card,
                .agenda-card,
                .agenda-number,
                .countdown-card,
                .seminar-card,
                .map-card,
                .gallery-item,
                .seminar-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('seminar-show');
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
