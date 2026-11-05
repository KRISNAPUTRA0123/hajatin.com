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
            color: var(--candy-dark);
            background:
                radial-gradient(circle at top left, var(--candy-body-1), transparent 32%),
                radial-gradient(circle at top right, var(--candy-body-2), transparent 30%),
                linear-gradient(180deg, var(--candy-soft) 0%, #ffffff 48%, var(--candy-soft) 100%);
        }

        .candy-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .candy-world {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                radial-gradient(circle at 15% 10%, rgba(255,255,255,.9), transparent 24%),
                radial-gradient(circle at 90% 18%, rgba(255,255,255,.72), transparent 22%),
                linear-gradient(180deg, var(--candy-paper) 0%, #ffffff 54%, var(--candy-soft) 100%);
            box-shadow: 0 30px 90px rgba(15, 23, 42, .14);
        }

        .candy-world::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--candy-primary) 28%, transparent) 2px, transparent 3px),
                radial-gradient(circle, color-mix(in srgb, var(--candy-accent) 30%, transparent) 2px, transparent 3px),
                radial-gradient(circle, color-mix(in srgb, var(--candy-mint) 34%, transparent) 2px, transparent 3px);
            background-size: 42px 42px, 58px 58px, 76px 76px;
            background-position: 0 0, 18px 20px, 35px 12px;
            opacity: .55;
            pointer-events: none;
            z-index: 0;
        }

        .candy-world > * {
            position: relative;
            z-index: 1;
        }

        .candy-section {
            min-height: 100vh;
            padding: 96px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .candy-section.compact {
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

        .candy-title {
            font-weight: 950;
            line-height: 1.04;
            letter-spacing: -.045em;
            color: var(--candy-dark);
        }

        .candy-gradient-text {
            background: linear-gradient(135deg, var(--candy-primary), var(--candy-secondary), var(--candy-accent));
            -webkit-background-clip: text;
            color: transparent;
        }

        .candy-ticket {
            position: relative;
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 44px 34px;
            border-radius: 34px;
            background: rgba(255,255,255,.92);
            border: 3px dashed color-mix(in srgb, var(--candy-primary) 32%, white);
            box-shadow: 0 24px 60px rgba(15, 23, 42, .12);
        }

        .candy-ticket::before,
        .candy-ticket::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            background: var(--candy-soft);
            transform: translateY(-50%);
        }

        .candy-ticket::before {
            left: -20px;
        }

        .candy-ticket::after {
            right: -20px;
        }

        .candy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            padding: 14px 24px;
            font-weight: 900;
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, var(--candy-primary), var(--candy-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--candy-primary) 24%, transparent);
            transition: .2s ease;
            border: none;
            cursor: pointer;
        }

        .candy-btn:hover {
            transform: translateY(-2px);
        }

        .candy-btn.secondary {
            background: linear-gradient(135deg, var(--candy-mint), var(--candy-secondary));
        }

        .candy-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 900;
            color: var(--candy-dark);
            background:
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--candy-accent) 38%, white),
                    color-mix(in srgb, var(--candy-mint) 34%, white)
                );
            box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
        }

        .candy-hero-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 34px;
            align-items: center;
        }

        .candy-hero-card {
            background: rgba(255,255,255,.9);
            border: 2px solid color-mix(in srgb, var(--candy-primary) 14%, white);
            border-radius: 42px;
            padding: 34px;
            box-shadow: 0 22px 54px rgba(15, 23, 42, .11);
        }

        .candy-cover-frame {
            position: relative;
            width: min(100%, 360px);
            aspect-ratio: 4 / 5;
            margin: 0 auto;
            padding: 14px;
            border-radius: 42px;
            background:
                linear-gradient(135deg, var(--candy-primary), var(--candy-accent), var(--candy-mint));
            box-shadow: 0 26px 58px rgba(15, 23, 42, .16);
            transform: rotate(-3deg);
        }

        .candy-cover-frame img,
        .candy-cover-placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 30px;
            display: block;
            background: linear-gradient(135deg, #fff, var(--candy-soft));
        }

        .candy-star-card {
            width: min(100%, 760px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 26px;
            align-items: center;
            background: rgba(255,255,255,.92);
            border-radius: 40px;
            padding: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
            border: 2px solid color-mix(in srgb, var(--candy-accent) 28%, white);
        }

        .candy-star-photo {
            width: 170px;
            height: 170px;
            border-radius: 36px;
            object-fit: cover;
            border: 8px solid white;
            box-shadow: 0 16px 32px rgba(15, 23, 42, .12);
        }

        .candy-star-placeholder {
            width: 170px;
            height: 170px;
            border-radius: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--candy-soft), #ffffff);
            font-size: 58px;
            border: 8px solid white;
            box-shadow: 0 16px 32px rgba(15, 23, 42, .10);
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            max-width: 620px;
            margin: 0 auto;
        }

        .countdown-card {
            position: relative;
            overflow: hidden;
            border-radius: 999px;
            padding: 22px 12px;
            color: white;
            background: linear-gradient(135deg, var(--candy-primary), var(--candy-secondary));
            box-shadow: 0 16px 34px rgba(15, 23, 42, .10);
        }

        .countdown-card:nth-child(2) {
            background: linear-gradient(135deg, var(--candy-secondary), var(--candy-mint));
        }

        .countdown-card:nth-child(3) {
            background: linear-gradient(135deg, var(--candy-accent), var(--candy-secondary));
        }

        .countdown-card:nth-child(4) {
            background: linear-gradient(135deg, var(--candy-mint), var(--candy-primary));
        }

        .countdown-number {
            display: block;
            font-size: 32px;
            font-weight: 950;
            line-height: 1;
        }

        .countdown-label {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 900;
        }

        .candy-timeline {
            max-width: 760px;
            margin: 36px auto 0;
            display: grid;
            gap: 16px;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: 86px 1fr;
            gap: 16px;
            align-items: stretch;
        }

        .timeline-icon {
            border-radius: 26px;
            background: linear-gradient(135deg, var(--candy-primary), var(--candy-secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .12);
        }

        .timeline-content {
            background: rgba(255,255,255,.92);
            border-radius: 26px;
            padding: 22px;
            border: 2px solid color-mix(in srgb, var(--candy-primary) 12%, white);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
        }

        .gallery-shelf {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            max-width: 900px;
            margin: 36px auto 0;
        }

        .gallery-candy-item {
            background: white;
            padding: 10px 10px 24px;
            border-radius: 28px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .10);
            transform: rotate(-2deg);
        }

        .gallery-candy-item:nth-child(even) {
            transform: rotate(2deg);
        }

        .gallery-candy-item img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 20px;
        }

        .candy-card {
            background: rgba(255,255,255,.9);
            border-radius: 32px;
            padding: 28px;
            border: 2px solid color-mix(in srgb, var(--candy-primary) 12%, white);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .09);
        }

        .map-card {
            width: min(100%, 720px);
            margin: 24px auto 0;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 18px 44px rgba(15, 23, 42, .10);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            background: linear-gradient(135deg, var(--candy-soft), #ffffff);
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
            transition: .2s ease;
        }

        .floating-actions a:hover,
        .floating-action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .22);
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--candy-primary) 12%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .candy-floating {
            position: absolute;
            pointer-events: none;
            opacity: .9;
            filter: drop-shadow(0 18px 20px rgba(30, 41, 59, .10));
            animation: candyFloat 4.5s ease-in-out infinite;
        }

        .candy-floating.one {
            width: 120px;
            left: 24px;
            top: 60px;
        }

        .candy-floating.two {
            width: 110px;
            right: 34px;
            top: 120px;
            animation-delay: .7s;
        }

        .candy-floating.three {
            width: 130px;
            right: 42px;
            bottom: 70px;
            animation-delay: 1.1s;
        }

        .candy-lollipop-img {
            position: absolute;
            width: 128px;
            max-width: 24vw;
            height: auto;
            z-index: 2;
            pointer-events: none;
            filter: drop-shadow(0 18px 20px rgba(30, 41, 59, .12));
            animation: candyFloat 4.5s ease-in-out infinite;
        }

        .candy-lollipop-img.left {
            left: 7%;
            bottom: 17%;
            transform: rotate(-12deg);
        }

        .candy-lollipop-img.right {
            right: 9%;
            top: 30%;
            transform: rotate(14deg);
            animation-delay: .8s;
        }

        @media (max-width: 640px) {
            .candy-lollipop-img {
                width: 92px;
                opacity: .75;
            }

            .candy-lollipop-img.left {
                left: 4%;
                bottom: 16%;
            }

            .candy-lollipop-img.right {
                right: 5%;
                top: 34%;
            }
        }

        @keyframes candyFloat {
            0%, 100% {
                transform: translateY(0) rotate(-2deg);
            }

            50% {
                transform: translateY(-14px) rotate(2deg);
            }
        }

        @media (max-width: 900px) {
            .candy-shell {
                padding: 16px;
            }

            .candy-section {
                padding: 86px 36px;
            }

            .candy-hero-grid,
            .candy-star-card {
                grid-template-columns: 1fr;
            }

            .candy-star-card {
                text-align: center;
            }

            .candy-star-photo,
            .candy-star-placeholder {
                margin: 0 auto;
            }

            .gallery-shelf {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .candy-shell {
                padding: 0;
            }

            .candy-world {
                border-radius: 0;
                box-shadow: none;
            }

            .candy-section {
                padding: 78px 24px;
            }

            .candy-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .timeline-item {
                grid-template-columns: 1fr;
            }

            .timeline-icon {
                width: 76px;
                height: 76px;
            }

            .gallery-shelf {
                grid-template-columns: 1fr;
            }

            .floating-actions {
                right: 12px;
            }

            .gift-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .candy-floating {
                opacity: .45;
            }
        }

        /* =====================================================
        LUXURY CANDY ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .candy-reveal,
        .candy-section > p,
        .candy-section > h1,
        .candy-section > h2,
        .candy-section > h3,
        .candy-title,
        .candy-gradient-text,
        .candy-pill,
        .candy-ticket,
        .candy-hero-card,
        .candy-cover-frame,
        .candy-star-card,
        .countdown-card,
        .timeline-item,
        .timeline-icon,
        .timeline-content,
        .gallery-candy-item,
        .candy-card,
        .map-card,
        .gift-card,
        .candy-btn {
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

        .candy-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Opening langsung tampil elegan */
        #opening .candy-ticket {
            animation: candyTicketEnter 1.05s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .candy-title {
            animation: candyTitleEnter 1.15s cubic-bezier(.2, .8, .2, 1) .18s both;
        }

        #opening .candy-btn {
            animation: candyFadeUp .85s ease .48s both;
        }

        /* Background terasa hidup */
        .candy-world {
            animation: candyWorldGlow 8s ease-in-out infinite alternate;
        }

        .candy-world::before {
            animation: candyDotsMove 18s linear infinite;
        }

        /* Ornamen candy bergerak mewah */
        .candy-floating.one {
            animation: candyFloatOne 5.2s ease-in-out infinite;
        }

        .candy-floating.two {
            animation: candyFloatTwo 5.6s ease-in-out .25s infinite;
        }

        .candy-floating.three {
            animation: candyFloatThree 6s ease-in-out .45s infinite;
        }

        .candy-lollipop-img.left {
            animation: candyLollipopLeft 5.6s ease-in-out infinite;
        }

        .candy-lollipop-img.right {
            animation: candyLollipopRight 5.8s ease-in-out .35s infinite;
        }

        /* Hero image floating */
        .candy-cover-frame {
            animation: candyCoverFloat 4.8s ease-in-out infinite;
        }

        .candy-cover-frame img,
        .candy-cover-placeholder,
        .candy-star-photo,
        .candy-star-placeholder {
            transition: transform .7s ease, filter .7s ease;
        }

        /* Tombol efek kilau */
        .candy-btn,
        button.candy-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .candy-btn::after,
        button.candy-btn::after,
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
            animation: candyButtonShine 3.3s ease-in-out infinite;
            pointer-events: none;
        }

        /* Ticket ada kilau tipis */
        .candy-ticket {
            overflow: hidden;
        }

        .candy-ticket::before,
        .candy-ticket::after {
            z-index: 3;
        }

        .candy-ticket > * {
            position: relative;
            z-index: 2;
        }

        .candy-ticket::selection {
            background: transparent;
        }

        .candy-ticket::marker {
            color: transparent;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .candy-ticket:hover,
            .candy-hero-card:hover,
            .candy-star-card:hover,
            .countdown-card:hover,
            .timeline-content:hover,
            .gallery-candy-item:hover,
            .candy-card:hover,
            .map-card:hover,
            .candy-cover-frame:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--candy-primary) 34%, white) !important;
                box-shadow:
                    0 32px 82px rgba(15, 23, 42, .16),
                    0 0 42px color-mix(in srgb, var(--candy-primary) 14%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.76) !important;
            }

            .gallery-candy-item:hover img,
            .candy-cover-frame:hover img,
            .candy-star-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        /* Countdown glow */
        .countdown-number {
            animation: candyNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Timeline icon pulse */
        .timeline-icon {
            animation: candyIconPulse 3s ease-in-out infinite;
        }

        /* Floating buttons */
        .floating-actions a,
        .floating-action-button {
            animation: candyFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes candyTicketEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.94) rotate(-1.5deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes candyTitleEnter {
            from {
                opacity: 0;
                transform: translateY(36px) scale(.94);
                filter: blur(12px);
                letter-spacing: .04em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes candyFadeUp {
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

        @keyframes candyWorldGlow {
            from {
                box-shadow:
                    0 30px 90px rgba(15, 23, 42, .14),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 36px 108px rgba(15, 23, 42, .17),
                    0 0 52px color-mix(in srgb, var(--candy-primary) 12%, transparent);
            }
        }

        @keyframes candyDotsMove {
            from {
                background-position: 0 0, 18px 20px, 35px 12px;
            }
            to {
                background-position: 190px 120px, 230px 165px, 280px 110px;
            }
        }

        @keyframes candyFloatOne {
            0%, 100% {
                transform: translateY(0) rotate(-2deg) scale(1);
            }
            50% {
                transform: translateY(-16px) rotate(3deg) scale(1.025);
            }
        }

        @keyframes candyFloatTwo {
            0%, 100% {
                transform: translateY(0) rotate(2deg) scale(1);
            }
            50% {
                transform: translateY(-18px) rotate(-3deg) scale(1.03);
            }
        }

        @keyframes candyFloatThree {
            0%, 100% {
                transform: translateY(0) rotate(-1deg) scale(1);
            }
            50% {
                transform: translateY(-14px) rotate(2deg) scale(1.025);
            }
        }

        @keyframes candyLollipopLeft {
            0%, 100% {
                transform: rotate(-12deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(-7deg) translateY(-14px) scale(1.025);
            }
        }

        @keyframes candyLollipopRight {
            0%, 100% {
                transform: rotate(14deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(9deg) translateY(-14px) scale(1.025);
            }
        }

        @keyframes candyCoverFloat {
            0%, 100% {
                transform: rotate(-3deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(1deg) translateY(-8px) scale(1.018);
            }
        }

        @keyframes candyButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes candyNumberGlow {
            from {
                text-shadow: 0 0 8px rgba(255,255,255,.25);
            }
            to {
                text-shadow:
                    0 0 18px rgba(255,255,255,.58),
                    0 0 34px color-mix(in srgb, var(--candy-accent) 34%, transparent);
            }
        }

        @keyframes candyIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-4px) scale(1.045);
            }
        }

        @keyframes candyFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .candy-reveal,
            .candy-section > p,
            .candy-section > h1,
            .candy-section > h2,
            .candy-section > h3,
            .candy-title,
            .candy-gradient-text,
            .candy-pill,
            .candy-ticket,
            .candy-hero-card,
            .candy-cover-frame,
            .candy-star-card,
            .countdown-card,
            .timeline-item,
            .timeline-icon,
            .timeline-content,
            .gallery-candy-item,
            .candy-card,
            .map-card,
            .gift-card,
            .candy-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .candy-floating,
            .candy-lollipop-img {
                animation-duration: 7s;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .candy-reveal,
            .candy-section > p,
            .candy-section > h1,
            .candy-section > h2,
            .candy-section > h3,
            .candy-title,
            .candy-gradient-text,
            .candy-pill,
            .candy-ticket,
            .candy-hero-card,
            .candy-cover-frame,
            .candy-star-card,
            .countdown-card,
            .timeline-item,
            .timeline-icon,
            .timeline-content,
            .gallery-candy-item,
            .candy-card,
            .map-card,
            .gift-card,
            .candy-btn,
            .candy-world,
            .candy-world::before,
            .candy-floating,
            .candy-lollipop-img,
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
            'accent' => '#facc15',
            'mint' => '#5eead4',
            'dark' => '#4a1d2f',
            'soft' => '#fff1f2',
            'paper' => '#fff7f9',
            'body1' => 'rgba(244, 63, 94, .22)',
            'body2' => 'rgba(250, 204, 21, .16)',
        ],
        'emerald' => [
            'primary' => '#059669',
            'secondary' => '#34d399',
            'accent' => '#fbbf24',
            'mint' => '#a7f3d0',
            'dark' => '#064e3b',
            'soft' => '#ecfdf5',
            'paper' => '#f7fffb',
            'body1' => 'rgba(16, 185, 129, .20)',
            'body2' => 'rgba(251, 191, 36, .14)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#38bdf8',
            'accent' => '#f472b6',
            'mint' => '#bfdbfe',
            'dark' => '#1e293b',
            'soft' => '#eff6ff',
            'paper' => '#ffffff',
            'body1' => 'rgba(37, 99, 235, .18)',
            'body2' => 'rgba(56, 189, 248, .14)',
        ],
        'rose' => [
            'primary' => '#ec4899',
            'secondary' => '#fb7185',
            'accent' => '#facc15',
            'mint' => '#67e8f9',
            'dark' => '#4a2433',
            'soft' => '#fff7fa',
            'paper' => '#fffafb',
            'body1' => 'rgba(236, 72, 153, .20)',
            'body2' => 'rgba(103, 232, 249, .14)',
        ],
        'gold' => [
            'primary' => '#d97706',
            'secondary' => '#f59e0b',
            'accent' => '#ec4899',
            'mint' => '#fde68a',
            'dark' => '#4a3511',
            'soft' => '#fff7ed',
            'paper' => '#fffdf7',
            'body1' => 'rgba(245, 158, 11, .18)',
            'body2' => 'rgba(236, 72, 153, .12)',
        ],
        'slate' => [
            'primary' => '#475569',
            'secondary' => '#94a3b8',
            'accent' => '#f472b6',
            'mint' => '#cbd5e1',
            'dark' => '#1e293b',
            'soft' => '#f8fafc',
            'paper' => '#ffffff',
            'body1' => 'rgba(71, 85, 105, .14)',
            'body2' => 'rgba(244, 114, 182, .10)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['rose'];

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
        --candy-primary: {{ $activeTheme['primary'] }};
        --candy-secondary: {{ $activeTheme['secondary'] }};
        --candy-accent: {{ $activeTheme['accent'] }};
        --candy-mint: {{ $activeTheme['mint'] }};
        --candy-dark: {{ $activeTheme['dark'] }};
        --candy-soft: {{ $activeTheme['soft'] }};
        --candy-paper: {{ $activeTheme['paper'] }};
        --candy-body-1: {{ $activeTheme['body1'] }};
        --candy-body-2: {{ $activeTheme['body2'] }};
    "
>
    <main class="candy-shell">
        <div class="candy-world">

            <img src="{{ asset('assets/templates/birthday-candy/lollipop.png') }}"
                class="candy-lollipop-img left"
                alt="Lollipop">

            <img src="{{ asset('assets/templates/birthday-candy/lollipop.png') }}"
                class="candy-lollipop-img right"
                alt="Lollipop">

            <img src="{{ asset('assets/templates/birthday-fun/confetti.png') }}"
                 class="candy-floating one"
                 alt="Confetti">

            <img src="{{ asset('assets/templates/birthday-candy/cupcake.png') }}"
                class="candy-floating two"
                alt="Cupcake">

            <img src="{{ asset('assets/templates/birthday-candy/gift-candy.png') }}"
                class="candy-floating three"
                alt="Gift Candy">

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
            <section id="opening" class="candy-section text-center">
                <div class="candy-ticket">
                    <p class="uppercase tracking-[.35em] text-sm font-black" style="color: var(--candy-primary)">
                        Sweet Party Pass
                    </p>

                    <h1 class="candy-title candy-gradient-text text-5xl md:text-7xl mt-5">
                        Candy Birthday
                    </h1>

                    <div class="my-8 border-t-2 border-dashed"
                         style="border-color: color-mix(in srgb, var(--candy-primary) 30%, white)">
                    </div>

                    <p class="text-2xl md:text-4xl font-black text-slate-900">
                        {{ $invitation->title ?: 'Alya Sweet Party' }}
                    </p>

                    <p class="responsive-text text-slate-600 mt-5 leading-8">
                        {{ $invitation->description ?: 'Yuk datang dan rayakan hari manis penuh warna bersama kami!' }}
                    </p>

                    <div class="mt-10">
                        <a href="#cover" class="candy-btn">
                            🍭 Masuk ke Candy Party
                        </a>
                    </div>

                    <p class="text-xs text-slate-400 mt-8 uppercase tracking-[.24em]">
                        Admit One Special Guest
                    </p>
                </div>
            </section>

            {{-- COVER --}}
            <section id="cover" class="candy-section">
                <div class="candy-hero-grid">
                    <div class="candy-hero-card text-center md:text-left">
                        <span class="candy-pill">
                            {{ $invitation->event_name ?: 'Ulang Tahun' }}
                        </span>

                        <h2 class="candy-title text-4xl md:text-6xl mt-6">
                            Welcome to the Sweetest Day
                        </h2>

                        <p class="text-slate-600 mt-5 leading-8 text-lg">
                            {{ $invitation->host_name ? 'Dari ' . $invitation->host_name : 'Dengan bahagia kami mengundang teman-teman untuk hadir di pesta ulang tahun ini.' }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3 justify-center md:justify-start">
                            <a href="#birthday-star" class="candy-btn">
                                Lihat Bintang Pesta
                            </a>

                            <a href="#detail" class="candy-btn secondary">
                                Detail Acara
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="candy-cover-frame">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                                     alt="Cover Ulang Tahun">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}"
                                     alt="Foto Ulang Tahun">
                            @else
                                <div class="candy-cover-placeholder flex items-center justify-center">
                                    <img src="{{ asset('assets/templates/birthday-candy/cupcake.png') }}"
                                         class="w-32 h-32 object-contain"
                                         alt="Cake">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- BIRTHDAY STAR --}}
            <section id="birthday-star" class="candy-section compact text-center">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--candy-primary)">
                    Birthday Star
                </p>

                <h2 class="candy-title text-4xl md:text-5xl mt-4 mb-4">
                    Yang Berbahagia
                </h2>

                <div class="candy-star-card mt-10 text-left">
                    <div>
                        @if ($birthdayPerson && $birthdayPerson->photo)
                            <img src="{{ asset('storage/' . $birthdayPerson->photo) }}"
                                 class="candy-star-photo"
                                 alt="{{ $birthdayPerson->name }}">
                        @else
                            <div class="candy-star-placeholder">
                                🎂
                            </div>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm uppercase tracking-[.25em] font-black" style="color: var(--candy-secondary)">
                            Special Day For
                        </p>

                        <h3 class="candy-title text-4xl md:text-5xl mt-3">
                            {{ $birthdayPerson?->name ?: $invitation->title }}
                        </h3>

                        @if ($birthdayPerson?->subtitle)
                            <p class="text-slate-600 mt-3 text-lg">
                                {{ $birthdayPerson->subtitle }}
                            </p>
                        @endif

                        @if ($birthdayPerson?->family_name)
                            <p class="text-slate-500 mt-2">
                                {{ $birthdayPerson->family_name }}
                            </p>
                        @endif

                        <p class="text-slate-600 mt-5 leading-8">
                            Mari hadir dan ikut merayakan hari penuh tawa, warna, dan kebahagiaan.
                        </p>
                    </div>
                </div>
            </section>

            {{-- COUNTDOWN --}}
            <section id="countdown" class="candy-section compact text-center">
                <h2 class="candy-title text-4xl md:text-5xl">
                    Sweet Countdown
                </h2>

                <p class="text-slate-500 mt-3" id="countdown-note">
                    @if ($countdownTarget)
                        Menghitung mundur menuju pesta
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
            <section id="detail" class="candy-section compact text-center">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--candy-primary)">
                    Party Timeline
                </p>

                <h2 class="candy-title text-4xl md:text-5xl mt-4">
                    Detail Acara
                </h2>

                <div class="candy-timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">📅</div>

                        <div class="timeline-content text-left">
                            <p class="text-sm text-slate-500">Tanggal Acara</p>

                            <p class="font-black text-xl mt-1">
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}

                                    @if ($invitation->event_end_date)
                                        - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                    @endif
                                @else
                                    Tanggal belum diatur
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-icon">⏰</div>

                        <div class="timeline-content text-left">
                            <p class="text-sm text-slate-500">Waktu</p>

                            <p class="font-black text-xl mt-1">
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
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-icon">📍</div>

                        <div class="timeline-content text-left">
                            <p class="text-sm text-slate-500">Lokasi</p>

                            <p class="font-black text-xl mt-1">
                                {{ $invitation->location_name ?: 'Lokasi belum diatur' }}
                            </p>

                            @if ($invitation->address)
                                <p class="responsive-text text-slate-600 mt-3 leading-7">
                                    {{ $invitation->address }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @if ($googleCalendarUrl)
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="candy-btn">
                            📅 Atur Pengingat
                        </a>
                    @endif

                    @if ($mapOpenUrl)
                        <a href="{{ $mapOpenUrl }}" target="_blank" class="candy-btn secondary">
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
                <section id="gallery" class="candy-section compact text-center">
                    <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--candy-primary)">
                        Candy Shelf
                    </p>

                    <h2 class="candy-title text-4xl md:text-5xl mt-4">
                        Sweet Moments
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Foto-foto manis dari hari spesial
                    </p>

                    <div class="gallery-shelf">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-candy-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}"
                                     alt="Galeri Ulang Tahun">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFT --}}
            <section id="gift" class="candy-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-candy/gift-candy.png') }}"
                    class="w-24 h-24 object-contain mx-auto mb-4"
                    alt="Gift Candy">

                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--candy-primary)">
                    Sweet Gift
                </p>

                <h2 class="candy-title text-4xl md:text-5xl mt-4">
                    Amplop Digital
                </h2>

                <p class="text-slate-600 mt-4 max-w-xl mx-auto leading-8">
                    Bagi yang ingin mengirimkan tanda kasih, dapat melalui informasi berikut.
                </p>

                <div class="mt-8 space-y-4 max-w-2xl mx-auto">
                    @forelse ($invitation->gifts as $gift)
                        <div class="candy-card gift-card">
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
                                        class="candy-btn">
                                    Salin
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="candy-card text-center">
                            <p class="text-slate-500">
                                Informasi gift belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- RSVP --}}
            <section id="message" class="candy-section compact">
                <div class="text-center">
                    <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--candy-primary)">
                        Guest Candy Notes
                    </p>

                    <h2 class="candy-title text-4xl md:text-5xl mt-4">
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
                          class="candy-card space-y-4">
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

                        <button type="submit" class="w-full candy-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="candy-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>

                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="candy-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>

                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="candy-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>

                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="candy-card">
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
                            <div class="candy-card text-center">
                                <p class="text-slate-500">
                                    Belum ada ucapan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="candy-section text-center">
                <div class="candy-ticket">
                    <p class="uppercase tracking-[.35em] text-sm font-black" style="color: var(--candy-primary)">
                        Sweet Thank You
                    </p>

                    <h2 class="candy-title candy-gradient-text text-5xl md:text-7xl mt-5">
                        Thank You!
                    </h2>

                    <p class="text-slate-600 mt-6 leading-8 max-w-xl mx-auto">
                        Terima kasih sudah menjadi bagian dari hari spesial ini.
                        Kehadiran dan doa kalian membuat hari ini semakin manis.
                    </p>

                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 mt-10">
                        {{ $invitation->title }}
                    </h3>

                    <p class="text-xs text-slate-400 mt-8 uppercase tracking-[.24em]">
                        Hajatin.com
                    </p>
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
                            ? 'Menghitung mundur menuju pesta'
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
                .candy-section > p,
                .candy-section > h1,
                .candy-section > h2,
                .candy-section > h3,
                .candy-title,
                .candy-gradient-text,
                .candy-pill,
                .candy-ticket,
                .candy-hero-card,
                .candy-cover-frame,
                .candy-star-card,
                .countdown-card,
                .timeline-item,
                .timeline-icon,
                .timeline-content,
                .gallery-candy-item,
                .candy-card,
                .map-card,
                .gift-card,
                .candy-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('candy-show');
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
