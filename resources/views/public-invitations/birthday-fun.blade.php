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
            color: var(--birthday-dark);
            background:
                radial-gradient(circle at top left, var(--birthday-body-1), transparent 32%),
                radial-gradient(circle at top right, var(--birthday-body-2), transparent 30%),
                linear-gradient(180deg, var(--birthday-soft) 0%, #ffffff 45%, var(--birthday-paper) 100%);
        }

        .birthday-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .birthday-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 34px;
            background:
                radial-gradient(circle at 12% 10%, rgba(255, 255, 255, .9), transparent 24%),
                radial-gradient(circle at 86% 14%, rgba(255, 255, 255, .82), transparent 22%),
                linear-gradient(180deg, #ffffff 0%, var(--birthday-paper) 50%, var(--birthday-soft) 100%);
            box-shadow: 0 28px 80px rgba(30, 41, 59, .14);
        }

        .birthday-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, var(--birthday-dot-1) 2px, transparent 3px),
                radial-gradient(circle, var(--birthday-dot-2) 2px, transparent 3px),
                radial-gradient(circle, var(--birthday-dot-3) 2px, transparent 3px);
            background-size: 42px 42px, 54px 54px, 66px 66px;
            background-position: 0 0, 16px 20px, 30px 8px;
            opacity: .45;
            pointer-events: none;
            z-index: 0;
        }

        .birthday-wrap > * {
            position: relative;
            z-index: 1;
        }

        .birthday-section {
            min-height: 100vh;
            padding: 96px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .birthday-section.compact {
            min-height: auto;
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .birthday-card {
            background: rgba(255, 255, 255, .9);
            border: 1px solid color-mix(in srgb, var(--birthday-primary) 14%, transparent);
            border-radius: 34px;
            box-shadow: 0 18px 44px rgba(30, 41, 59, .10);
            padding: 28px;
            backdrop-filter: blur(10px);
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

        .hero-copy {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .hero-copy .responsive-text,
        .hero-copy .birthday-title {
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            word-wrap: break-word;
        }

        @media (max-width: 640px) {
            .hero-copy {
                text-align: center;
                padding-left: 0;
                padding-right: 0;
            }

            .hero-copy .responsive-text {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                font-size: 15px;
                line-height: 1.7;
            }

            .hero-copy .birthday-title {
                font-size: 2.25rem;
                line-height: 1.08;
            }
        }

        .birthday-title {
            font-weight: 950;
            line-height: 1.05;
            color: var(--birthday-dark);
            letter-spacing: -.04em;
        }

        .birthday-gradient-text {
            background: linear-gradient(135deg, var(--birthday-primary), var(--birthday-secondary), var(--birthday-third));
            -webkit-background-clip: text;
            color: transparent;
        }

        .birthday-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 900;
            background:
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--birthday-accent) 34%, white),
                    color-mix(in srgb, var(--birthday-primary) 20%, white)
                );
            color: var(--birthday-dark);
            box-shadow: 0 12px 28px color-mix(in srgb, var(--birthday-primary) 16%, transparent);
        }

        .party-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            padding: 14px 24px;
            font-weight: 900;
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, var(--birthday-primary), var(--birthday-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--birthday-primary) 25%, transparent);
            transition: .2s ease;
        }

        .party-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 44px color-mix(in srgb, var(--birthday-secondary) 34%, transparent);
        }

        .party-btn.secondary {
            background: linear-gradient(135deg, var(--birthday-third), var(--birthday-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--birthday-third) 22%, transparent);
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
            background: color-mix(in srgb, var(--birthday-accent) 28%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .balloon {
            position: absolute;
            width: 190px;
            max-width: 28vw;
            pointer-events: none;
            filter: drop-shadow(0 18px 20px rgba(30, 41, 59, .12));
            animation: floatBalloon 4s ease-in-out infinite;
        }

        .balloon.left {
            left: 22px;
            top: 54px;
        }

        .balloon.right {
            right: 22px;
            top: 80px;
            animation-delay: .7s;
        }

        .confetti-img {
            position: absolute;
            width: 240px;
            max-width: 34vw;
            opacity: .72;
            pointer-events: none;
        }

        .confetti-img.top {
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
        }

        .confetti-img.bottom {
            bottom: 18px;
            right: 30px;
            transform: rotate(180deg);
        }

        @keyframes floatBalloon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-14px); }
        }

        .hero-photo-frame {
            width: min(100%, 340px);
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            border-radius: 42px;
            padding: 12px;
            background: linear-gradient(135deg, var(--birthday-accent), var(--birthday-primary), var(--birthday-third));
            box-shadow: 0 22px 52px rgba(30, 41, 59, .16);
            transform: rotate(-2deg);
        }

        .hero-photo-frame img,
        .hero-photo-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 32px;
            background:
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--birthday-accent) 30%, white),
                    color-mix(in srgb, var(--birthday-primary) 18%, white),
                    color-mix(in srgb, var(--birthday-third) 18%, white)
                );
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            max-width: 560px;
            margin: 0 auto;
        }

        .countdown-card {
            border-radius: 26px;
            padding: 20px 12px;
            color: white;
            box-shadow: 0 16px 34px rgba(30, 41, 59, .10);
        }

        .countdown-card:nth-child(1) {
            background: linear-gradient(135deg, var(--birthday-primary), var(--birthday-secondary));
        }

        .countdown-card:nth-child(2) {
            background: linear-gradient(135deg, var(--birthday-secondary), var(--birthday-third));
        }

        .countdown-card:nth-child(3) {
            background: linear-gradient(135deg, var(--birthday-third), var(--birthday-primary));
        }

        .countdown-card:nth-child(4) {
            background: linear-gradient(135deg, var(--birthday-accent), var(--birthday-secondary));
        }

        .countdown-number {
            display: block;
            font-size: 32px;
            font-weight: 950;
            line-height: 1;
        }

        .countdown-label {
            display: block;
            margin-top: 9px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 900;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .detail-box {
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--birthday-primary) 14%, transparent);
            border-radius: 26px;
            padding: 22px;
            text-align: center;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            max-width: 900px;
            margin: 36px auto 0;
        }

        .gallery-item {
            background: white;
            padding: 10px;
            border-radius: 24px;
            box-shadow: 0 16px 34px rgba(30, 41, 59, .10);
        }

        .gallery-item img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 18px;
        }

        .map-card {
            width: min(100%, 720px);
            margin: 24px auto 0;
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 18px 44px rgba(30, 41, 59, .10);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            background:
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--birthday-third) 18%, white),
                    color-mix(in srgb, var(--birthday-primary) 16%, white),
                    color-mix(in srgb, var(--birthday-accent) 20%, white)
                );
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

        @media (max-width: 900px) {
            .birthday-shell {
                padding: 16px;
            }

            .birthday-section {
                padding: 86px 36px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .birthday-shell {
                padding: 0;
            }

            .birthday-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .birthday-section {
                padding: 78px 24px;
            }

            .birthday-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .balloon {
                width: 112px;
            }

            .confetti-img {
                width: 160px;
            }

            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .floating-actions {
                right: 12px;
            }

            .gift-card {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* =====================================================
        LUXURY FUN ANIMATION - BIRTHDAY TEMPLATE
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .bday-reveal,
        .birthday-section > p,
        .birthday-section > h1,
        .birthday-section > h2,
        .birthday-section > h3,
        .birthday-title,
        .birthday-pill,
        .birthday-card,
        .hero-photo-frame,
        .countdown-card,
        .detail-box,
        .gallery-item,
        .map-card,
        .gift-card,
        .party-btn,
        .event-badge {
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

        .bday-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Opening langsung tampil elegan */
        #opening .birthday-title {
            animation: bdayTitleIn 1s cubic-bezier(.2, .8, .2, 1) .18s both;
        }

        #opening .party-btn {
            animation: bdayFadeUp .9s ease .48s both;
        }

        #opening img[alt="Party"] {
            animation: bdayIconPop 1s cubic-bezier(.2, .8, .2, 1) both, bdaySoftFloat 3.6s ease-in-out 1s infinite;
        }

        /* Background lebih hidup */
        .birthday-wrap {
            animation: bdayWrapGlow 8s ease-in-out infinite alternate;
        }

        .birthday-wrap::before {
            animation: bdayDotsMove 18s linear infinite;
        }

        /* Balon dan confetti lebih halus */
        .balloon.left {
            animation: bdayBalloonLeft 4.8s ease-in-out infinite;
        }

        .balloon.right {
            animation: bdayBalloonRight 5.2s ease-in-out .35s infinite;
        }

        .confetti-img.top {
            animation: bdayConfettiTop 6.8s ease-in-out infinite;
        }

        .confetti-img.bottom {
            animation: bdayConfettiBottom 7s ease-in-out infinite;
        }

        /* Foto hero terasa premium */
        .hero-photo-frame {
            animation: bdayPhotoFloat 4.8s ease-in-out infinite;
        }

        .hero-photo-frame img,
        .hero-photo-placeholder {
            transition: transform .7s ease, filter .7s ease;
        }

        /* Tombol kilau */
        .party-btn,
        button.party-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .party-btn::after,
        button.party-btn::after,
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
                rgba(255,255,255,.52),
                transparent
            );
            animation: bdayButtonShine 3.3s ease-in-out infinite;
            pointer-events: none;
        }

        /* Card hover desktop */
        @media (hover: hover) {
            .birthday-card:hover,
            .countdown-card:hover,
            .detail-box:hover,
            .gallery-item:hover,
            .map-card:hover,
            .gift-card:hover,
            .hero-photo-frame:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--birthday-primary) 28%, transparent) !important;
                box-shadow:
                    0 30px 78px rgba(30, 41, 59, .16),
                    0 0 42px color-mix(in srgb, var(--birthday-primary) 13%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.72) !important;
            }

            .gallery-item:hover img,
            .hero-photo-frame:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: bdayNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: bdayFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes bdayTitleIn {
            from {
                opacity: 0;
                transform: translateY(38px) scale(.94);
                filter: blur(12px);
                letter-spacing: .04em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes bdayFadeUp {
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

        @keyframes bdayIconPop {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(.78) rotate(-8deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes bdaySoftFloat {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-8px) rotate(4deg);
            }
        }

        @keyframes bdayWrapGlow {
            from {
                box-shadow:
                    0 28px 80px rgba(30, 41, 59, .14),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 34px 100px rgba(30, 41, 59, .17),
                    0 0 48px color-mix(in srgb, var(--birthday-primary) 12%, transparent);
            }
        }

        @keyframes bdayDotsMove {
            from {
                background-position: 0 0, 16px 20px, 30px 8px;
            }
            to {
                background-position: 180px 120px, 220px 160px, 260px 100px;
            }
        }

        @keyframes bdayBalloonLeft {
            0%, 100% {
                transform: translateY(0) rotate(-2deg) scale(1);
            }
            50% {
                transform: translateY(-16px) rotate(2deg) scale(1.025);
            }
        }

        @keyframes bdayBalloonRight {
            0%, 100% {
                transform: translateY(0) rotate(2deg) scale(1);
            }
            50% {
                transform: translateY(-18px) rotate(-2deg) scale(1.025);
            }
        }

        @keyframes bdayConfettiTop {
            0%, 100% {
                transform: translateX(-50%) translateY(0) rotate(0deg);
                opacity: .68;
            }
            50% {
                transform: translateX(-50%) translateY(-8px) rotate(3deg);
                opacity: .86;
            }
        }

        @keyframes bdayConfettiBottom {
            0%, 100% {
                transform: rotate(180deg) translateY(0);
                opacity: .66;
            }
            50% {
                transform: rotate(184deg) translateY(-8px);
                opacity: .84;
            }
        }

        @keyframes bdayPhotoFloat {
            0%, 100% {
                transform: rotate(-2deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(1deg) translateY(-8px) scale(1.018);
            }
        }

        @keyframes bdayButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes bdayNumberGlow {
            from {
                text-shadow: 0 0 8px rgba(255,255,255,.25);
            }
            to {
                text-shadow:
                    0 0 18px rgba(255,255,255,.55),
                    0 0 34px color-mix(in srgb, var(--birthday-accent) 34%, transparent);
            }
        }

        @keyframes bdayFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .bday-reveal,
            .birthday-section > p,
            .birthday-section > h1,
            .birthday-section > h2,
            .birthday-section > h3,
            .birthday-title,
            .birthday-pill,
            .birthday-card,
            .hero-photo-frame,
            .countdown-card,
            .detail-box,
            .gallery-item,
            .map-card,
            .gift-card,
            .party-btn,
            .event-badge {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .balloon,
            .confetti-img {
                animation-duration: 7s;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .bday-reveal,
            .birthday-section > p,
            .birthday-section > h1,
            .birthday-section > h2,
            .birthday-section > h3,
            .birthday-title,
            .birthday-pill,
            .birthday-card,
            .hero-photo-frame,
            .countdown-card,
            .detail-box,
            .gallery-item,
            .map-card,
            .gift-card,
            .party-btn,
            .event-badge,
            .birthday-wrap,
            .birthday-wrap::before,
            .balloon,
            .confetti-img,
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
    $themeColor = $invitation->theme_color ?? 'rose';

    $themes = [
        'maroon' => [
            'primary' => '#be123c',
            'secondary' => '#fb7185',
            'accent' => '#f59e0b',
            'third' => '#8b5cf6',
            'dark' => '#4a1d2f',
            'soft' => '#fff1f2',
            'paper' => '#fff7f9',
            'body1' => 'rgba(190, 18, 60, .22)',
            'body2' => 'rgba(251, 113, 133, .16)',
            'dot1' => 'rgba(190, 18, 60, .18)',
            'dot2' => 'rgba(251, 113, 133, .15)',
            'dot3' => 'rgba(245, 158, 11, .18)',
        ],
        'emerald' => [
            'primary' => '#059669',
            'secondary' => '#34d399',
            'accent' => '#f59e0b',
            'third' => '#0ea5e9',
            'dark' => '#064e3b',
            'soft' => '#ecfdf5',
            'paper' => '#f7fffb',
            'body1' => 'rgba(5, 150, 105, .20)',
            'body2' => 'rgba(52, 211, 153, .15)',
            'dot1' => 'rgba(5, 150, 105, .18)',
            'dot2' => 'rgba(52, 211, 153, .15)',
            'dot3' => 'rgba(245, 158, 11, .18)',
        ],
        'navy' => [
            'primary' => '#1d4ed8',
            'secondary' => '#38bdf8',
            'accent' => '#f472b6',
            'third' => '#6366f1',
            'dark' => '#172033',
            'soft' => '#eff6ff',
            'paper' => '#ffffff',
            'body1' => 'rgba(29, 78, 216, .18)',
            'body2' => 'rgba(56, 189, 248, .15)',
            'dot1' => 'rgba(29, 78, 216, .18)',
            'dot2' => 'rgba(56, 189, 248, .15)',
            'dot3' => 'rgba(244, 114, 182, .18)',
        ],
        'rose' => [
            'primary' => '#ec4899',
            'secondary' => '#8b5cf6',
            'accent' => '#f59e0b',
            'third' => '#3b82f6',
            'dark' => '#4a2433',
            'soft' => '#fff7fa',
            'paper' => '#fffafb',
            'body1' => 'rgba(236, 72, 153, .22)',
            'body2' => 'rgba(59, 130, 246, .18)',
            'dot1' => 'rgba(236, 72, 153, .18)',
            'dot2' => 'rgba(59, 130, 246, .14)',
            'dot3' => 'rgba(250, 204, 21, .20)',
        ],
        'gold' => [
            'primary' => '#d97706',
            'secondary' => '#f59e0b',
            'accent' => '#ec4899',
            'third' => '#92400e',
            'dark' => '#4a3511',
            'soft' => '#fff7ed',
            'paper' => '#fffdf7',
            'body1' => 'rgba(217, 119, 6, .20)',
            'body2' => 'rgba(245, 158, 11, .15)',
            'dot1' => 'rgba(217, 119, 6, .18)',
            'dot2' => 'rgba(245, 158, 11, .16)',
            'dot3' => 'rgba(236, 72, 153, .16)',
        ],
        'slate' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'accent' => '#f472b6',
            'third' => '#0f172a',
            'dark' => '#1e293b',
            'soft' => '#f8fafc',
            'paper' => '#ffffff',
            'body1' => 'rgba(51, 65, 85, .14)',
            'body2' => 'rgba(100, 116, 139, .10)',
            'dot1' => 'rgba(51, 65, 85, .16)',
            'dot2' => 'rgba(100, 116, 139, .13)',
            'dot3' => 'rgba(244, 114, 182, .14)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['rose'];

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
        --birthday-primary: {{ $activeTheme['primary'] }};
        --birthday-secondary: {{ $activeTheme['secondary'] }};
        --birthday-accent: {{ $activeTheme['accent'] }};
        --birthday-third: {{ $activeTheme['third'] }};
        --birthday-dark: {{ $activeTheme['dark'] }};
        --birthday-soft: {{ $activeTheme['soft'] }};
        --birthday-paper: {{ $activeTheme['paper'] }};
        --birthday-body-1: {{ $activeTheme['body1'] }};
        --birthday-body-2: {{ $activeTheme['body2'] }};
        --birthday-dot-1: {{ $activeTheme['dot1'] }};
        --birthday-dot-2: {{ $activeTheme['dot2'] }};
        --birthday-dot-3: {{ $activeTheme['dot3'] }};
    "
>
    <main class="birthday-shell">
        <div class="birthday-wrap">

            <img src="{{ asset('assets/templates/birthday-fun/balloon-left.png') }}"
                 class="balloon left"
                 alt="Balloon">

            <img src="{{ asset('assets/templates/birthday-fun/balloon-right.png') }}"
                 class="balloon right"
                 alt="Balloon">

            <img src="{{ asset('assets/templates/birthday-fun/confetti.png') }}"
                 class="confetti-img top"
                 alt="Confetti">

            <div class="floating-actions">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}"
                         alt="Bagikan"
                         class="floating-icon">
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

                @if ($invitation->maps_url)
                    <a href="{{ $invitation->maps_url }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}"
                             alt="Lokasi"
                             class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ asset('assets/music/background2.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            {{-- OPENING --}}
            <section id="opening" class="birthday-section text-center">
                <div class="mx-auto max-w-3xl">
                    <div class="inline-flex mx-auto mb-7">
                        <img src="{{ asset('assets/templates/birthday-fun/party-hat.png') }}"
                             class="w-24 h-24 object-contain"
                             alt="Party">
                    </div>

                    <p class="uppercase tracking-[.35em] text-sm text-slate-500 font-black">
                        You're Invited
                    </p>

                    <h1 class="birthday-title birthday-gradient-text text-5xl md:text-7xl mt-5">
                        Birthday Fun
                    </h1>

                    <p class="text-3xl md:text-5xl font-black mt-6" style="color: var(--birthday-dark)">
                        {{ $invitation->title ?: 'Alya Turns 10' }}
                    </p>

                    <p class="responsive-text text-slate-600 mt-5 text-lg">
                        {{ $invitation->description ?: 'Yuk rayakan hari spesial ini bersama teman dan keluarga!' }}
                    </p>

                    <div class="mt-10">
                        <a href="#hero" class="party-btn">
                            🎉 Buka Undangan
                        </a>
                    </div>

                    <p class="text-sm text-slate-400 mt-10">
                        Klik tombol untuk melanjutkan
                    </p>
                </div>
            </section>

            {{-- HERO --}}
            <section id="hero" class="birthday-section text-center">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div>
                        <div class="hero-photo-frame">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                                     alt="Cover Ulang Tahun">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}"
                                     alt="Foto Ulang Tahun">
                            @else
                                <div class="hero-photo-placeholder flex items-center justify-center">
                                    <img src="{{ asset('assets/templates/birthday-fun/cake.png') }}"
                                         class="w-32 h-32 object-contain"
                                         alt="Cake">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hero-copy text-center md:text-left">
                        <span class="birthday-pill">
                            {{ $invitation->event_name ?: 'Ulang Tahun' }}
                        </span>

                        <h2 class="responsive-text birthday-title text-4xl md:text-6xl mt-6">
                            {{ $invitation->title ?: 'Birthday Party' }}
                        </h2>

                        <p class="responsive-text text-slate-600 mt-5 leading-8 text-lg">{{ trim($invitation->host_name ? 'Dari ' . $invitation->host_name : 'Dengan bahagia kami mengundang teman-teman untuk hadir di pesta ulang tahun ini.') }}</p>

                        <a href="#detail" class="party-btn secondary mt-8">
                            Lihat Detail Acara
                        </a>
                    </div>
                </div>
            </section>

            {{-- COUNTDOWN --}}
            <section id="countdown" class="birthday-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-fun/cake.png') }}"
                     class="w-24 h-24 object-contain mx-auto"
                     alt="Cake">

                <h2 class="birthday-title text-4xl md:text-5xl mt-5">
                    Hitung Mundur Pesta
                </h2>

                <p class="text-slate-500 mt-3" id="countdown-note">
                    @if ($countdownTarget)
                        Menghitung mundur menuju acara
                    @else
                        Tanggal acara belum diatur
                    @endif
                </p>

                <div class="countdown-grid mt-8"
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
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="birthday-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-fun/gift.png') }}"
                     class="w-24 h-24 object-contain mx-auto"
                     alt="Gift">

                <h2 class="birthday-title text-4xl md:text-5xl mt-5">
                    Detail Acara
                </h2>

                <div class="birthday-card max-w-4xl mx-auto mt-8">
                    <h3 class="text-3xl font-black" style="color: var(--birthday-dark)">
                        {{ $invitation->event_name ?: 'Ulang Tahun' }}
                    </h3>

                    <div class="detail-grid mt-8">
                        <div class="detail-box">
                            <p class="text-sm text-slate-500">Tanggal</p>
                            <p class="font-black text-lg mt-2">
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}

                                    @if ($invitation->event_end_date)
                                        <br>
                                        <span class="text-sm text-slate-500">
                                            - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                        </span>
                                    @endif
                                @else
                                    Tanggal belum diatur
                                @endif
                            </p>
                        </div>

                        <div class="detail-box">
                            <p class="text-sm text-slate-500">Waktu</p>
                            <p class="font-black text-lg mt-2">
                                @if ($invitation->event_time)
                                    {{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}

                                    @if ($invitation->event_end_time)
                                            - {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}
                                    @endif
                                @else
                                    Waktu belum diatur
                                @endif
                            </p>
                        </div>

                        <div class="detail-box">
                            <p class="text-sm text-slate-500">Lokasi</p>
                            <p class="font-black text-lg mt-2">
                                {{ $invitation->location_name ?: 'Lokasi belum diatur' }}
                            </p>
                        </div>
                    </div>

                    @if ($invitation->address)
                        <div class="detail-box mt-5">
                            <p class="text-sm text-slate-500">Alamat Lengkap</p>
                            <p class="responsive-text text-slate-700 mt-2 leading-7">
                                {{ $invitation->address }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-7 flex flex-wrap justify-center gap-3">
                        @if ($googleCalendarUrl)
                            <a href="{{ $googleCalendarUrl }}" target="_blank" class="party-btn">
                                📅 Atur Pengingat
                            </a>
                        @endif

                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="party-btn secondary">
                                📍 Buka Maps
                            </a>
                        @endif
                    </div>
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
                                    <p class="font-black text-slate-900 mt-3">
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

            {{-- GALLERY --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="birthday-section compact text-center">
                    <h2 class="birthday-title text-4xl md:text-5xl">
                        Momen Ceria
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Galeri foto spesial
                    </p>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}"
                                     alt="Galeri Ulang Tahun">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFT --}}
            <section id="gift" class="birthday-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-fun/gift.png') }}"
                     class="w-24 h-24 object-contain mx-auto"
                     alt="Gift">

                <h2 class="birthday-title text-4xl md:text-5xl mt-5">
                    Birthday Gift
                </h2>

                <p class="text-slate-600 mt-4 max-w-xl mx-auto leading-8">
                    Bagi yang ingin mengirimkan tanda kasih, dapat melalui informasi berikut.
                </p>

                <div class="mt-8 space-y-4 max-w-2xl mx-auto">
                    @forelse ($invitation->gifts as $gift)
                        <div class="birthday-card gift-card">
                            <div>
                                <p class="text-sm text-slate-500">
                                    {{ $gift->label ?: 'Bank / E-wallet' }}
                                </p>

                                <p class="font-black text-xl mt-1">
                                    {{ $gift->account_number ?: '-' }}
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Atas Nama {{ $gift->account_name ?: '-' }}
                                </p>
                            </div>

                            @if ($gift->account_number)
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $gift->account_number }}')"
                                        class="party-btn">
                                    Salin
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="birthday-card text-center">
                            <p class="text-slate-500">
                                Informasi gift belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- RSVP --}}
            <section id="message" class="birthday-section compact">
                <div class="text-center">
                    <h2 class="birthday-title text-4xl md:text-5xl">
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
                          class="birthday-card space-y-4">
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

                        <button type="submit" class="w-full party-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="birthday-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="birthday-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="birthday-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="birthday-card">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-black">{{ $message->guest_name }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="text-xs px-3 py-1 rounded-full bg-pink-100 text-pink-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @empty
                            <div class="birthday-card text-center">
                                <p class="text-slate-500">
                                    Belum ada ucapan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="birthday-section text-center">
                <img src="{{ asset('assets/templates/birthday-fun/confetti.png') }}"
                     class="confetti-img bottom"
                     alt="Confetti">

                <img src="{{ asset('assets/templates/birthday-fun/cake.png') }}"
                     class="w-28 h-28 object-contain mx-auto"
                     alt="Cake">

                <h2 class="birthday-title birthday-gradient-text text-5xl md:text-7xl mt-8">
                    Thank You!
                </h2>

                <p class="text-slate-600 mt-6 leading-8 max-w-xl mx-auto">
                    Terima kasih sudah menjadi bagian dari hari spesial ini.
                    Kehadiran dan doa kalian sangat berarti.
                </p>

                <h3 class="text-4xl md:text-5xl font-black mt-10" style="color: var(--birthday-dark)">
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
                .birthday-section > p,
                .birthday-section > h1,
                .birthday-section > h2,
                .birthday-section > h3,
                .birthday-title,
                .birthday-pill,
                .birthday-card,
                .hero-photo-frame,
                .countdown-card,
                .detail-box,
                .gallery-item,
                .map-card,
                .gift-card,
                .party-btn,
                .event-badge
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('bday-show');
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
