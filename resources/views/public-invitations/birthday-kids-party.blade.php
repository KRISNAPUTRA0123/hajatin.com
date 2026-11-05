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
            color: var(--kids-dark);
            background:
                radial-gradient(circle at top left, var(--kids-body-1), transparent 32%),
                radial-gradient(circle at top right, var(--kids-body-2), transparent 30%),
                linear-gradient(180deg, var(--kids-soft) 0%, #ffffff 48%, var(--kids-paper) 100%);
        }

        .kids-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .kids-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                radial-gradient(circle at 14% 10%, rgba(255,255,255,.92), transparent 26%),
                radial-gradient(circle at 88% 15%, rgba(255,255,255,.82), transparent 24%),
                linear-gradient(180deg, #ffffff 0%, var(--kids-paper) 52%, var(--kids-soft) 100%);
            box-shadow: 0 30px 90px rgba(15, 23, 42, .12);
        }

        .kids-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, var(--kids-dot-1) 2px, transparent 3px),
                radial-gradient(circle, var(--kids-dot-2) 2px, transparent 3px),
                radial-gradient(circle, var(--kids-dot-3) 2px, transparent 3px);
            background-size: 42px 42px, 58px 58px, 72px 72px;
            background-position: 0 0, 16px 20px, 35px 10px;
            opacity: .42;
            pointer-events: none;
            z-index: 0;
        }

        .kids-wrap > * {
            position: relative;
            z-index: 1;
        }

        .kids-section {
            min-height: 100vh;
            padding: 96px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .kids-section.compact {
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

        .guest-message-card {
            text-align: left !important;
        }

        .guest-message-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            text-align: left !important;
        }

        .guest-message-info {
            min-width: 0;
            flex: 1;
            text-align: left !important;
        }

        .guest-message-text {
            display: block;
            width: 100%;
            text-align: left !important;
            margin-left: 0;
            margin-right: 0;
        }

        .kids-title {
            font-weight: 950;
            line-height: 1.04;
            letter-spacing: -.045em;
            color: var(--kids-dark);
        }

        .kids-gradient-text {
            background: linear-gradient(135deg, var(--kids-primary), var(--kids-secondary), var(--kids-accent));
            -webkit-background-clip: text;
            color: transparent;
        }

        .crew-grid.single-crew {
            grid-template-columns: minmax(0, 320px);
            justify-content: center;
        }

        .crew-grid.single-crew .crew-card {
            width: 100%;
        }

        @media (max-width: 640px) {
            .crew-grid.single-crew {
                grid-template-columns: minmax(0, 100%);
            }
        }

        .kids-card {
            background: rgba(255,255,255,.9);
            border: 2px solid color-mix(in srgb, var(--kids-primary) 12%, white);
            border-radius: 34px;
            box-shadow: 0 18px 46px rgba(15, 23, 42, .09);
            padding: 28px;
            backdrop-filter: blur(10px);
        }

        .invitation-description {
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        @media (max-width: 640px) {
            .invitation-description {
                font-size: 14px;
                line-height: 1.7;
            }
        }

        .address-card {
            width: min(100%, 760px);
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
        }

        .address-text {
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
        }

        @media (max-width: 640px) {
            .address-card {
                width: 100%;
                padding: 22px 18px;
                border-radius: 28px;
            }

            .address-text {
                font-size: 14px;
                line-height: 1.7;
            }
        }

        .kids-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 900;
            color: var(--kids-dark);
            background: linear-gradient(
                135deg,
                color-mix(in srgb, var(--kids-accent) 34%, white),
                color-mix(in srgb, var(--kids-primary) 20%, white)
            );
            box-shadow: 0 12px 28px color-mix(in srgb, var(--kids-primary) 14%, transparent);
        }

        .kids-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            padding: 14px 24px;
            font-weight: 900;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, var(--kids-primary), var(--kids-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--kids-primary) 24%, transparent);
            transition: .2s ease;
        }

        .kids-btn:hover {
            transform: translateY(-2px);
        }

        .kids-btn.secondary {
            background: linear-gradient(135deg, var(--kids-third), var(--kids-secondary));
        }

        .kids-decor-img {
            position: absolute;
            pointer-events: none;
            object-fit: contain;
            filter: drop-shadow(0 16px 20px rgba(15, 23, 42, .10));
            animation: kidsFloat 4.5s ease-in-out infinite;
            z-index: 2;
        }

        .kids-decor-img.decor-one {
            width: 120px;
            left: 6%;
            top: 80px;
        }

        .kids-decor-img.decor-two {
            width: 96px;
            right: 8%;
            top: 150px;
            animation-delay: .7s;
        }

        .kids-decor-img.decor-three {
            width: 130px;
            right: 10%;
            bottom: 130px;
            animation-delay: 1.1s;
        }

        @media (max-width: 640px) {
            .kids-decor-img {
                opacity: .65;
            }

            .kids-decor-img.decor-one {
                width: 82px;
                left: 4%;
                top: 70px;
            }

            .kids-decor-img.decor-two {
                width: 72px;
                right: 5%;
                top: 130px;
            }

            .kids-decor-img.decor-three {
                width: 90px;
                right: 6%;
                bottom: 100px;
            }
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
            background: color-mix(in srgb, var(--kids-accent) 24%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .kids-cloud,
        .kids-star,
        .kids-bubble {
            position: absolute;
            pointer-events: none;
            opacity: .9;
        }

        .kids-cloud {
            width: 120px;
            height: 58px;
            background: rgba(255,255,255,.9);
            border-radius: 999px;
            box-shadow: 0 14px 22px rgba(15, 23, 42, .06);
        }

        .kids-cloud::before,
        .kids-cloud::after {
            content: "";
            position: absolute;
            background: rgba(255,255,255,.95);
            border-radius: 999px;
        }

        .kids-cloud::before {
            width: 52px;
            height: 52px;
            left: 14px;
            top: -20px;
        }

        .kids-cloud::after {
            width: 62px;
            height: 62px;
            right: 14px;
            top: -26px;
        }

        .kids-cloud.one { left: 5%; top: 80px; }
        .kids-cloud.two { right: 7%; top: 140px; transform: scale(.9); }

        .kids-star {
            width: 24px;
            height: 24px;
            background: var(--kids-accent);
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
            animation: kidsFloat 4s ease-in-out infinite;
        }

        .kids-star.one { left: 11%; top: 210px; }
        .kids-star.two { right: 14%; top: 260px; animation-delay: .7s; }
        .kids-star.three { right: 18%; bottom: 140px; animation-delay: 1.2s; }

        .kids-bubble {
            border-radius: 999px;
            animation: kidsFloat 5s ease-in-out infinite;
        }

        .kids-bubble.one {
            width: 26px;
            height: 26px;
            left: 8%;
            bottom: 18%;
            background: color-mix(in srgb, var(--kids-primary) 26%, white);
        }

        .kids-bubble.two {
            width: 18px;
            height: 18px;
            right: 8%;
            bottom: 22%;
            background: color-mix(in srgb, var(--kids-third) 22%, white);
            animation-delay: .8s;
        }

        .kids-bubble.three {
            width: 34px;
            height: 34px;
            right: 12%;
            top: 34%;
            background: color-mix(in srgb, var(--kids-accent) 26%, white);
            animation-delay: 1.1s;
        }

        @keyframes kidsFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .poster-card {
            width: min(100%, 760px);
            margin: 0 auto;
            text-align: center;
            background: rgba(255,255,255,.95);
            border: 3px solid color-mix(in srgb, var(--kids-primary) 12%, white);
            border-radius: 40px;
            padding: 42px 30px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
            position: relative;
        }

        .poster-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--kids-primary), var(--kids-secondary));
            box-shadow: 0 12px 26px color-mix(in srgb, var(--kids-primary) 24%, transparent);
        }

        .hero-stage {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px;
            align-items: center;
        }

        .hero-stage-card {
            background: rgba(255,255,255,.92);
            border-radius: 36px;
            padding: 32px;
            border: 2px solid color-mix(in srgb, var(--kids-primary) 12%, white);
            box-shadow: 0 20px 50px rgba(15, 23, 42, .09);
        }

        .hero-photo-frame {
            width: min(100%, 360px);
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            padding: 14px;
            border-radius: 42px;
            background: linear-gradient(135deg, var(--kids-primary), var(--kids-accent), var(--kids-third));
            box-shadow: 0 24px 56px rgba(15, 23, 42, .14);
            transform: rotate(-3deg);
        }

        .hero-photo-frame img,
        .hero-photo-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 30px;
            object-fit: cover;
            display: block;
            background: linear-gradient(
                135deg,
                color-mix(in srgb, var(--kids-accent) 30%, white),
                color-mix(in srgb, var(--kids-primary) 20%, white),
                color-mix(in srgb, var(--kids-third) 18%, white)
            );
        }

        .crew-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            max-width: 920px;
            margin: 36px auto 0;
        }

        .crew-card {
            background: rgba(255,255,255,.92);
            border-radius: 32px;
            padding: 22px;
            border: 2px solid color-mix(in srgb, var(--kids-primary) 10%, white);
            box-shadow: 0 16px 38px rgba(15, 23, 42, .08);
            text-align: center;
        }

        .crew-avatar {
            width: 112px;
            height: 112px;
            border-radius: 28px;
            object-fit: cover;
            display: block;
            margin: 0 auto 16px;
            border: 6px solid white;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
        }

        .crew-avatar-placeholder {
            width: 112px;
            height: 112px;
            border-radius: 28px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            background: linear-gradient(135deg, var(--kids-soft), #ffffff);
            border: 6px solid white;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            max-width: 650px;
            margin: 32px auto 0;
        }

        .countdown-card {
            border-radius: 28px;
            color: white;
            padding: 22px 12px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .10);
        }

        .countdown-card:nth-child(1) { background: linear-gradient(135deg, var(--kids-primary), var(--kids-secondary)); }
        .countdown-card:nth-child(2) { background: linear-gradient(135deg, var(--kids-secondary), var(--kids-third)); }
        .countdown-card:nth-child(3) { background: linear-gradient(135deg, var(--kids-third), var(--kids-primary)); }
        .countdown-card:nth-child(4) { background: linear-gradient(135deg, var(--kids-accent), var(--kids-secondary)); }

        .countdown-number {
            display: block;
            font-size: 34px;
            font-weight: 950;
            line-height: 1;
        }

        .countdown-label {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .plan-board {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 36px;
        }

        .plan-card {
            background: rgba(255,255,255,.92);
            border-radius: 28px;
            padding: 24px;
            border: 2px dashed color-mix(in srgb, var(--kids-primary) 18%, white);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .07);
            text-align: center;
        }

        .plan-emoji {
            font-size: 34px;
            margin-bottom: 10px;
        }

        .map-card {
            width: min(100%, 760px);
            margin: 26px auto 0;
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
            background: linear-gradient(
                135deg,
                color-mix(in srgb, var(--kids-third) 16%, white),
                color-mix(in srgb, var(--kids-primary) 14%, white),
                color-mix(in srgb, var(--kids-accent) 20%, white)
            );
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            max-width: 920px;
            margin: 34px auto 0;
        }

        .gallery-item {
            background: white;
            padding: 10px;
            border-radius: 28px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
            transform: rotate(-1.5deg);
        }

        .gallery-item:nth-child(even) {
            transform: rotate(1.5deg);
        }

        .gallery-item img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        .gift-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            text-align: left;
        }

        @media (max-width: 900px) {
            .kids-shell {
                padding: 16px;
            }

            .kids-section {
                padding: 86px 36px;
            }

            .hero-stage,
            .crew-grid,
            .plan-board,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .kids-shell {
                padding: 0;
            }

            .kids-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .kids-section {
                padding: 76px 24px;
            }

            .kids-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .floating-actions {
                right: 12px;
            }

            .gift-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .kids-cloud,
            .kids-star,
            .kids-bubble {
                opacity: .55;
            }
        }

        /* =====================================================
        LUXURY KIDS PARTY ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .kids-reveal,
        .kids-section > p,
        .kids-section > h1,
        .kids-section > h2,
        .kids-section > h3,
        .kids-title,
        .kids-gradient-text,
        .kids-pill,
        .poster-card,
        .poster-badge,
        .hero-stage-card,
        .hero-photo-frame,
        .kids-card,
        .crew-card,
        .countdown-card,
        .plan-card,
        .map-card,
        .gallery-item,
        .gift-card,
        .kids-btn,
        .address-card {
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

        .kids-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Opening langsung tampil elegan */
        #opening .poster-card {
            animation: kidsPosterEnter 1.05s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .poster-badge {
            animation: kidsBadgePop .85s cubic-bezier(.2, .8, .2, 1) .18s both;
        }

        #opening .kids-title {
            animation: kidsTitleEnter 1.15s cubic-bezier(.2, .8, .2, 1) .3s both;
        }

        #opening .kids-btn {
            animation: kidsFadeUp .85s ease .55s both;
        }

        /* Background lebih hidup */
        .kids-wrap {
            animation: kidsWrapGlow 8s ease-in-out infinite alternate;
        }

        .kids-wrap::before {
            animation: kidsDotsMove 18s linear infinite;
        }

        /* Ornamen gambar bergerak */
        .kids-decor-img.decor-one {
            animation: kidsDecorOne 5.2s ease-in-out infinite;
        }

        .kids-decor-img.decor-two {
            animation: kidsDecorTwo 5.6s ease-in-out .25s infinite;
        }

        .kids-decor-img.decor-three {
            animation: kidsDecorThree 6s ease-in-out .45s infinite;
        }

        /* Cloud, star, bubble lebih hidup */
        .kids-cloud.one {
            animation: kidsCloudOne 7s ease-in-out infinite;
        }

        .kids-cloud.two {
            animation: kidsCloudTwo 7.5s ease-in-out .35s infinite;
        }

        .kids-star.one,
        .kids-star.two,
        .kids-star.three {
            animation: kidsStarTwinkle 3.2s ease-in-out infinite;
        }

        .kids-star.two {
            animation-delay: .35s;
        }

        .kids-star.three {
            animation-delay: .7s;
        }

        .kids-bubble.one,
        .kids-bubble.two,
        .kids-bubble.three {
            animation: kidsBubbleFloat 4.8s ease-in-out infinite;
        }

        .kids-bubble.two {
            animation-delay: .4s;
        }

        .kids-bubble.three {
            animation-delay: .8s;
        }

        /* Hero image floating */
        .hero-photo-frame {
            animation: kidsHeroPhotoFloat 4.8s ease-in-out infinite;
        }

        .hero-photo-frame img,
        .hero-photo-placeholder,
        .crew-avatar,
        .crew-avatar-placeholder {
            transition: transform .7s ease, filter .7s ease;
        }

        /* Tombol efek kilau */
        .kids-btn,
        button.kids-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .kids-btn::after,
        button.kids-btn::after,
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
            animation: kidsButtonShine 3.3s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium untuk desktop */
        @media (hover: hover) {
            .poster-card:hover,
            .hero-stage-card:hover,
            .hero-photo-frame:hover,
            .kids-card:hover,
            .crew-card:hover,
            .countdown-card:hover,
            .plan-card:hover,
            .gallery-item:hover,
            .map-card:hover,
            .address-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--kids-primary) 32%, white) !important;
                box-shadow:
                    0 32px 82px rgba(15, 23, 42, .16),
                    0 0 42px color-mix(in srgb, var(--kids-primary) 13%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.76) !important;
            }

            .gallery-item:hover img,
            .hero-photo-frame:hover img,
            .crew-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        /* Countdown glow */
        .countdown-number {
            animation: kidsNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Plan icon / emoji pulse */
        .plan-emoji img,
        #countdown > img,
        #gift > img {
            animation: kidsIconPulse 3s ease-in-out infinite;
        }

        /* Floating buttons */
        .floating-actions a,
        .floating-action-button {
            animation: kidsFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes kidsPosterEnter {
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

        @keyframes kidsBadgePop {
            from {
                opacity: 0;
                transform: translateY(-18px) scale(.78);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes kidsTitleEnter {
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

        @keyframes kidsFadeUp {
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

        @keyframes kidsWrapGlow {
            from {
                box-shadow:
                    0 30px 90px rgba(15, 23, 42, .12),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 36px 108px rgba(15, 23, 42, .16),
                    0 0 52px color-mix(in srgb, var(--kids-primary) 12%, transparent);
            }
        }

        @keyframes kidsDotsMove {
            from {
                background-position: 0 0, 16px 20px, 35px 10px;
            }
            to {
                background-position: 190px 120px, 230px 165px, 280px 110px;
            }
        }

        @keyframes kidsDecorOne {
            0%, 100% {
                transform: translateY(0) rotate(-2deg) scale(1);
            }
            50% {
                transform: translateY(-16px) rotate(3deg) scale(1.025);
            }
        }

        @keyframes kidsDecorTwo {
            0%, 100% {
                transform: translateY(0) rotate(2deg) scale(1);
            }
            50% {
                transform: translateY(-18px) rotate(-3deg) scale(1.03);
            }
        }

        @keyframes kidsDecorThree {
            0%, 100% {
                transform: translateY(0) rotate(-1deg) scale(1);
            }
            50% {
                transform: translateY(-14px) rotate(2deg) scale(1.025);
            }
        }

        @keyframes kidsCloudOne {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-10px) translateX(8px);
            }
        }

        @keyframes kidsCloudTwo {
            0%, 100% {
                transform: scale(.9) translateY(0) translateX(0);
            }
            50% {
                transform: scale(.9) translateY(-10px) translateX(-8px);
            }
        }

        @keyframes kidsStarTwinkle {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
                opacity: .82;
            }
            50% {
                transform: translateY(-8px) rotate(12deg) scale(1.18);
                opacity: 1;
            }
        }

        @keyframes kidsBubbleFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
                opacity: .72;
            }
            50% {
                transform: translateY(-14px) scale(1.08);
                opacity: .95;
            }
        }

        @keyframes kidsHeroPhotoFloat {
            0%, 100% {
                transform: rotate(-3deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(1deg) translateY(-8px) scale(1.018);
            }
        }

        @keyframes kidsButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes kidsNumberGlow {
            from {
                text-shadow: 0 0 8px rgba(255,255,255,.25);
            }
            to {
                text-shadow:
                    0 0 18px rgba(255,255,255,.58),
                    0 0 34px color-mix(in srgb, var(--kids-accent) 34%, transparent);
            }
        }

        @keyframes kidsIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-5px) scale(1.055);
            }
        }

        @keyframes kidsFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .kids-reveal,
            .kids-section > p,
            .kids-section > h1,
            .kids-section > h2,
            .kids-section > h3,
            .kids-title,
            .kids-gradient-text,
            .kids-pill,
            .poster-card,
            .poster-badge,
            .hero-stage-card,
            .hero-photo-frame,
            .kids-card,
            .crew-card,
            .countdown-card,
            .plan-card,
            .map-card,
            .gallery-item,
            .gift-card,
            .kids-btn,
            .address-card {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .kids-decor-img,
            .kids-cloud,
            .kids-star,
            .kids-bubble {
                animation-duration: 7s;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .kids-reveal,
            .kids-section > p,
            .kids-section > h1,
            .kids-section > h2,
            .kids-section > h3,
            .kids-title,
            .kids-gradient-text,
            .kids-pill,
            .poster-card,
            .poster-badge,
            .hero-stage-card,
            .hero-photo-frame,
            .kids-card,
            .crew-card,
            .countdown-card,
            .plan-card,
            .map-card,
            .gallery-item,
            .gift-card,
            .kids-btn,
            .address-card,
            .kids-wrap,
            .kids-wrap::before,
            .kids-decor-img,
            .kids-cloud,
            .kids-star,
            .kids-bubble,
            .floating-actions a,
            .floating-action-button,
            .countdown-number,
            .plan-emoji img,
            #countdown > img,
            #gift > img {
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
            'primary' => '#e11d48',
            'secondary' => '#fb7185',
            'accent' => '#f59e0b',
            'third' => '#8b5cf6',
            'dark' => '#4a1d2f',
            'soft' => '#fff1f2',
            'paper' => '#fff8fb',
            'body1' => 'rgba(225, 29, 72, .18)',
            'body2' => 'rgba(251, 113, 133, .14)',
            'dot1' => 'rgba(225, 29, 72, .16)',
            'dot2' => 'rgba(251, 113, 133, .14)',
            'dot3' => 'rgba(245, 158, 11, .18)',
        ],

        'emerald' => [
            'primary' => '#10b981',
            'secondary' => '#34d399',
            'accent' => '#f59e0b',
            'third' => '#06b6d4',
            'dark' => '#064e3b',
            'soft' => '#ecfdf5',
            'paper' => '#f7fffb',
            'body1' => 'rgba(16, 185, 129, .16)',
            'body2' => 'rgba(6, 182, 212, .13)',
            'dot1' => 'rgba(16, 185, 129, .14)',
            'dot2' => 'rgba(52, 211, 153, .14)',
            'dot3' => 'rgba(245, 158, 11, .18)',
        ],

        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#38bdf8',
            'accent' => '#f472b6',
            'third' => '#6366f1',
            'dark' => '#1e293b',
            'soft' => '#eff6ff',
            'paper' => '#ffffff',
            'body1' => 'rgba(37, 99, 235, .16)',
            'body2' => 'rgba(56, 189, 248, .13)',
            'dot1' => 'rgba(37, 99, 235, .14)',
            'dot2' => 'rgba(99, 102, 241, .13)',
            'dot3' => 'rgba(244, 114, 182, .16)',
        ],

        'rose' => [
            'primary' => '#ec4899',
            'secondary' => '#8b5cf6',
            'accent' => '#facc15',
            'third' => '#3b82f6',
            'dark' => '#4a2433',
            'soft' => '#fff7fa',
            'paper' => '#fffafb',
            'body1' => 'rgba(236, 72, 153, .18)',
            'body2' => 'rgba(59, 130, 246, .14)',
            'dot1' => 'rgba(236, 72, 153, .16)',
            'dot2' => 'rgba(139, 92, 246, .14)',
            'dot3' => 'rgba(250, 204, 21, .18)',
        ],

        'gold' => [
            'primary' => '#d97706',
            'secondary' => '#f59e0b',
            'accent' => '#ec4899',
            'third' => '#8b5cf6',
            'dark' => '#4a3511',
            'soft' => '#fff7ed',
            'paper' => '#fffdf7',
            'body1' => 'rgba(217, 119, 6, .16)',
            'body2' => 'rgba(245, 158, 11, .12)',
            'dot1' => 'rgba(217, 119, 6, .14)',
            'dot2' => 'rgba(236, 72, 153, .14)',
            'dot3' => 'rgba(139, 92, 246, .16)',
        ],

        'slate' => [
            'primary' => '#475569',
            'secondary' => '#94a3b8',
            'accent' => '#f59e0b',
            'third' => '#64748b',
            'dark' => '#1e293b',
            'soft' => '#f8fafc',
            'paper' => '#ffffff',
            'body1' => 'rgba(71, 85, 105, .12)',
            'body2' => 'rgba(148, 163, 184, .10)',
            'dot1' => 'rgba(71, 85, 105, .12)',
            'dot2' => 'rgba(148, 163, 184, .12)',
            'dot3' => 'rgba(245, 158, 11, .14)',
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
        --kids-primary: {{ $activeTheme['primary'] }};
        --kids-secondary: {{ $activeTheme['secondary'] }};
        --kids-accent: {{ $activeTheme['accent'] }};
        --kids-third: {{ $activeTheme['third'] }};
        --kids-dark: {{ $activeTheme['dark'] }};
        --kids-soft: {{ $activeTheme['soft'] }};
        --kids-paper: {{ $activeTheme['paper'] }};
        --kids-body-1: {{ $activeTheme['body1'] }};
        --kids-body-2: {{ $activeTheme['body2'] }};
        --kids-dot-1: {{ $activeTheme['dot1'] }};
        --kids-dot-2: {{ $activeTheme['dot2'] }};
        --kids-dot-3: {{ $activeTheme['dot3'] }};
    "
>
    <main class="kids-shell">
        <div class="kids-wrap">

            <img src="{{ asset('assets/templates/birthday-kids-party/lego-block.png') }}"
                class="kids-decor-img decor-one"
                alt="Lego Block">

            <img src="{{ asset('assets/templates/birthday-kids-party/lego-star.png') }}"
                class="kids-decor-img decor-two"
                alt="Lego Star">

            <img src="{{ asset('assets/templates/birthday-kids-party/lego-confetti.png') }}"
                class="kids-decor-img decor-three"
                alt="Confetti">

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

                @if ($invitation->maps_url)
                    <a href="{{ $invitation->maps_url }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ asset('assets/music/background2.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            {{-- OPENING --}}
            <section id="opening" class="kids-section text-center">
                <div class="poster-card">
                    <div class="poster-badge">
                        <span>Kids Party Invitation</span>
                    </div>

                    <h1 class="kids-title kids-gradient-text text-5xl md:text-7xl mt-6">
                        Birthday Kids Party
                    </h1>

                    <p class="text-3xl md:text-5xl font-black mt-6" style="color: var(--kids-dark)">
                        {{ $invitation->title ?: 'Happy Kids Party' }}
                    </p>

                    <p class="responsive-text invitation-description text-slate-600 mt-5 max-w-2xl mx-auto leading-8">
                        {{ $invitation->description ?: 'Yuk datang ke pesta ulang tahun seru penuh permainan, tawa, dan momen spesial bersama teman-teman!' }}
                    </p>

                    <div class="mt-10 flex flex-wrap justify-center gap-3">
                        <a href="#hero" class="kids-btn">🎈 Buka Undangan</a>
                        <a href="#detail" class="kids-btn secondary">📍 Lihat Detail</a>
                    </div>
                </div>
            </section>

            {{-- HERO --}}
            <section id="hero" class="kids-section">
                <div class="hero-stage">
                    <div class="hero-stage-card text-center md:text-left">
                        <span class="kids-pill">
                            {{ $invitation->event_name ?: 'Ulang Tahun Anak' }}
                        </span>

                        <h2 class="kids-title text-4xl md:text-6xl mt-6">
                            Let’s Play, Laugh, and Celebrate!
                        </h2>

                        <p class="text-slate-600 mt-5 leading-8 text-lg">
                            {{ $invitation->host_name ? 'Bersama ' . $invitation->host_name : 'Dengan penuh keceriaan, kami mengundang teman-teman untuk hadir di pesta ulang tahun yang seru dan penuh warna.' }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3 justify-center md:justify-start">
                            <a href="#crew" class="kids-btn">🧒 Birthday Crew</a>
                            <a href="#countdown" class="kids-btn secondary">⏰ Countdown</a>
                        </div>
                    </div>

                    <div>
                        <div class="hero-photo-frame">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Ulang Tahun">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Ulang Tahun">
                            @else
                                <div class="hero-photo-placeholder flex items-center justify-center">
                                    <img src="{{ asset('assets/templates/birthday-kids-party/lego-cake.png') }}"
                                        class="w-36 h-36 object-contain"
                                        alt="Lego Cake">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- CREW --}}
            <section id="crew" class="kids-section compact text-center">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                    Birthday Crew
                </p>

                <h2 class="kids-title text-4xl md:text-5xl mt-4">
                    Tokoh Utama Pesta
                </h2>

                <p class="text-slate-500 mt-3 max-w-2xl mx-auto">
                    Kenalan dulu dengan bintang acara hari ini.
                </p>

                <div class="crew-grid {{ $invitation->people->count() === 1 ? 'single-crew' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="crew-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="crew-avatar"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="crew-avatar-placeholder">
                                    <img src="{{ asset($loop->first
                                        ? 'assets/templates/birthday-kids-party/lego-boy.png'
                                        : 'assets/templates/birthday-kids-party/lego-girl.png') }}"
                                        class="w-20 h-20 object-contain"
                                        alt="Lego Character">
                                </div>
                            @endif

                            <h3 class="text-2xl font-black" style="color: var(--kids-dark)">
                                {{ $person->name }}
                            </h3>

                            @if ($person->subtitle)
                                <p class="text-slate-600 mt-2">
                                    {{ $person->subtitle }}
                                </p>
                            @endif

                            @if ($person->family_name)
                                <p class="text-slate-500 mt-2">
                                    {{ $person->family_name }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="crew-card">
                            <div class="crew-avatar-placeholder">🎉</div>
                            <h3 class="text-2xl font-black" style="color: var(--kids-dark)">
                                {{ $invitation->title ?: 'Birthday Star' }}
                            </h3>
                            <p class="text-slate-500 mt-2">
                                Tokoh utama belum ditambahkan.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- COUNTDOWN --}}
            <section id="countdown" class="kids-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-kids-party/lego-clock.png') }}"
                    class="w-24 h-24 object-contain mx-auto mb-4"
                    alt="Lego Clock">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                    Mission Countdown
                </p>

                <h2 class="kids-title text-4xl md:text-5xl mt-4">
                    Hitung Mundur ke Hari Seru
                </h2>

                <p class="text-slate-500 mt-3" id="countdown-note">
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

            {{-- DETAIL --}}
            <section id="detail" class="kids-section compact text-center">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                    Party Plan Board
                </p>

                <h2 class="kids-title text-4xl md:text-5xl mt-4">
                    Detail Acara
                </h2>

                <div class="plan-board">
                    <div class="plan-card">
                        <div class="plan-emoji">
                            <img src="{{ asset('assets/templates/birthday-kids-party/lego-calendar.png') }}"
                                class="w-14 h-14 object-contain mx-auto"
                                alt="Tanggal">
                        </div>
                        <p class="text-sm text-slate-500">Tanggal</p>
                        <p class="font-black text-lg mt-2" style="color: var(--kids-dark)">
                            @if ($invitation->event_date)
                                {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}

                                @if ($invitation->event_end_date)
                                    <br>
                                    <span class="text-sm text-slate-500">
                                        - {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            @else
                                Belum diatur
                            @endif
                        </p>
                    </div>

                    <div class="plan-card">
                        <div class="plan-emoji">
                            <img src="{{ asset('assets/templates/birthday-kids-party/lego-clock.png') }}"
                                class="w-14 h-14 object-contain mx-auto"
                                alt="Waktu">
                        </div>
                        <p class="text-sm text-slate-500">Waktu</p>
                        <p class="font-black text-lg mt-2" style="color: var(--kids-dark)">
                           @if ($invitation->event_time)
                                {{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}

                                @if ($invitation->event_end_time)
                                    - {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}
                                @endif
                            @else
                                Belum diatur
                            @endif
                        </p>
                    </div>

                    <div class="plan-card">
                        <div class="plan-emoji">
                            <img src="{{ asset('assets/templates/birthday-kids-party/lego-location.png') }}"
                                class="w-14 h-14 object-contain mx-auto"
                                alt="Lokasi">
                        </div>
                        <p class="text-sm text-slate-500">Lokasi</p>
                        <p class="font-black text-lg mt-2" style="color: var(--kids-dark)">
                            {{ $invitation->location_name ?: 'Belum diatur' }}
                        </p>
                    </div>
                </div>

                @if ($invitation->address)
                    <div class="kids-card address-card mt-6 text-center">
                        <p class="text-sm text-slate-500">
                            Alamat Lengkap
                        </p>

                        <p class="responsive-text address-text text-slate-700 mt-3 leading-7">
                            {{ $invitation->address }}
                        </p>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    @if ($googleCalendarUrl)
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="kids-btn">
                            📅 Atur Pengingat
                        </a>
                    @endif

                    @if ($mapOpenUrl)
                        <a href="{{ $mapOpenUrl }}" target="_blank" class="kids-btn secondary">
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
                                    <img src="{{ asset('assets/templates/birthday-kids-party/lego-map.png') }}"
                                        class="w-24 h-24 object-contain mx-auto"
                                        alt="Lego Map">
                                    <p class="font-black mt-3" style="color: var(--kids-dark)">
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
                <section id="gallery" class="kids-section compact text-center">
                    <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                        Fun Gallery
                    </p>

                    <h2 class="kids-title text-4xl md:text-5xl mt-4">
                        Momen Seru
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Kumpulan foto ceria dari hari spesial.
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
            <section id="gift" class="kids-section compact text-center">
                <img src="{{ asset('assets/templates/birthday-kids-party/lego-gift.png') }}"
                    class="w-24 h-24 object-contain mx-auto mb-4"
                    alt="Lego Gift">
                <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                    Treasure Box
                </p>

                <h2 class="kids-title text-4xl md:text-5xl mt-4">
                    Amplop Digital
                </h2>

                <p class="text-slate-600 mt-4 max-w-xl mx-auto leading-8">
                    Bagi yang ingin mengirimkan tanda kasih, bisa melalui informasi berikut.
                </p>

                <div class="mt-8 space-y-4 max-w-2xl mx-auto">
                    @forelse ($invitation->gifts as $gift)
                        <div class="kids-card gift-card">
                            <div>
                                <p class="text-sm text-slate-500">{{ $gift->label ?: 'Bank / E-wallet' }}</p>
                                <p class="font-black text-xl mt-1" style="color: var(--kids-dark)">
                                    {{ $gift->account_number ?: '-' }}
                                </p>
                                <p class="text-sm text-slate-500 mt-1">
                                    Atas Nama {{ $gift->account_name ?: '-' }}
                                </p>
                            </div>

                            @if ($gift->account_number)
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $gift->account_number }}')"
                                        class="kids-btn">
                                    Salin
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="kids-card text-center">
                            <p class="text-slate-500">Informasi gift belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- RSVP --}}
            <section id="message" class="kids-section compact">
                <div class="text-center">
                    <p class="uppercase tracking-[.30em] text-sm font-black" style="color: var(--kids-primary)">
                        Guest Wall
                    </p>

                    <h2 class="kids-title text-4xl md:text-5xl mt-4">
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
                          class="kids-card space-y-4">
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

                        <button type="submit" class="w-full kids-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="kids-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="kids-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="kids-card">
                            <p class="text-3xl font-black">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="kids-card guest-message-card">
                                <div class="guest-message-header">
                                    <div class="guest-message-info">
                                        <p class="font-black text-left">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 text-left">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="shrink-0 text-xs px-3 py-1 rounded-full bg-pink-100 text-pink-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text guest-message-text text-slate-600 mt-4 leading-7">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @empty
                            <div class="kids-card text-center">
                                <p class="text-slate-500">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="kids-section text-center">
                <div class="poster-card">
                    <div class="poster-badge">🌟 See You at the Party</div>

                    <h2 class="kids-title kids-gradient-text text-5xl md:text-7xl mt-6">
                        Thank You!
                    </h2>

                    <p class="text-slate-600 mt-6 leading-8 max-w-xl mx-auto">
                        Terima kasih sudah menjadi bagian dari hari spesial ini.
                        Kehadiran dan doa kalian akan membuat pesta semakin ceria.
                    </p>

                    <h3 class="text-4xl md:text-5xl font-black mt-10" style="color: var(--kids-dark)">
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

                            if (musicIcon) musicIcon.src = musicIcon.dataset.iconOn;
                        } else {
                            musicAudio.pause();
                            musicToggle.classList.remove('is-active');

                            if (musicIcon) musicIcon.src = musicIcon.dataset.iconOff;
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
                .kids-section > p,
                .kids-section > h1,
                .kids-section > h2,
                .kids-section > h3,
                .kids-title,
                .kids-gradient-text,
                .kids-pill,
                .poster-card,
                .poster-badge,
                .hero-stage-card,
                .hero-photo-frame,
                .kids-card,
                .crew-card,
                .countdown-card,
                .plan-card,
                .map-card,
                .gallery-item,
                .gift-card,
                .kids-btn,
                .address-card
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('kids-show');
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
