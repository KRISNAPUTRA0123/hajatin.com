<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Royal Javanese'));
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
            color: var(--rj-ink);
            background:
                radial-gradient(circle at 12% 8%, var(--rj-glow), transparent 25%),
                radial-gradient(circle at 90% 16%, rgba(127, 86, 58, .16), transparent 28%),
                linear-gradient(180deg, #e9d7c5 0%, #fbf2e8 44%, #d7bfa9 100%);
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .rj-shell {
            width: min(100%, 1060px);
            margin: 0 auto;
            padding: 24px;
        }

        .rj-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 34px;
            background:
                radial-gradient(circle at 50% -6%, rgba(255,255,255,.74), transparent 34%),
                linear-gradient(90deg, rgba(93, 59, 42, .035) 1px, transparent 1px) 0 0 / 42px 42px,
                linear-gradient(0deg, rgba(93, 59, 42, .030) 1px, transparent 1px) 0 0 / 42px 42px,
                radial-gradient(circle at center, rgba(126, 84, 57, .08) 0 1.4px, transparent 2px) 0 0 / 26px 26px,
                linear-gradient(180deg, var(--rj-paper) 0%, #fff5eb 48%, var(--rj-paper) 100%);
            border: 1px solid rgba(93, 59, 42, .18);
            box-shadow: 0 34px 100px rgba(75, 43, 27, .18);
        }

        .rj-wrap::before,
        .rj-wrap::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 34px;
            z-index: 8;
            pointer-events: none;
            background:
                linear-gradient(90deg, var(--rj-primary) 0 13px, transparent 13px 22px) 0 0 / 22px 10px repeat-x,
                linear-gradient(90deg, var(--rj-gold) 0 10px, transparent 10px 20px) 0 15px / 20px 8px repeat-x,
                linear-gradient(90deg, var(--rj-primary), var(--rj-secondary), var(--rj-primary));
            opacity: .95;
        }

        /* hilangkan ornamen atas */
        .rj-wrap::before {
            display: none;
        }

        /* ornamen bawah tetap */
        .rj-wrap::after {
            bottom: 0;
            transform: rotate(180deg);
        }

        .rj-noise {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .34;
            background:
                linear-gradient(135deg, transparent 46%, rgba(159, 110, 65, .09) 47%, transparent 49%) 0 0/56px 56px,
                linear-gradient(45deg, transparent 46%, rgba(93, 59, 42, .06) 47%, transparent 49%) 0 0/56px 56px;
        }

        .rj-wrap > * {
            position: relative;
            z-index: 2;
        }

        .rj-decor {
            position: absolute;
            z-index: 3;
            pointer-events: none;
            object-fit: contain;
            filter: drop-shadow(0 14px 24px rgba(77, 43, 24, .16));
        }

        .rj-corner-left {
            width: 260px;
            top: 38px;
            left: -52px;
        }

        .rj-corner-right {
            width: 260px;
            top: 38px;
            right: -52px;
            transform: scaleX(-1);
        }

        .rj-bottom-landscape {
            width: min(760px, 100%);
            left: 50%;
            bottom: 18px;
            transform: translateX(-50%);
            opacity: .20;
        }

        .rj-nav {
            position: sticky;
            top: 14px;
            z-index: 50;
            width: fit-content;
            max-width: calc(100% - 24px);
            margin: 18px auto 0;
            padding: 7px;
            border-radius: 999px;
            display: flex;
            gap: 4px;
            overflow-x: auto;
            background: rgba(87, 50, 31, .85);
            border: 1px solid rgba(220, 178, 111, .38);
            box-shadow: 0 16px 36px rgba(77, 43, 24, .16);
            backdrop-filter: blur(16px);
        }

        .rj-nav a {
            color: #ffe7bc;
            text-decoration: none;
            padding: 9px 13px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .06em;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .rj-nav a:hover {
            background: rgba(220, 178, 111, .16);
        }

        .rj-section {
            position: relative;
            min-height: 100vh;
            padding: 94px 54px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rj-section.compact {
            min-height: auto;
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .rj-title {
            font-family: Georgia, "Times New Roman", serif;
            color: var(--rj-primary);
            line-height: 1.02;
            font-weight: 500;
            letter-spacing: -.025em;
        }

        .rj-script {
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
        }

        .rj-label {
            width: fit-content;
            margin: 0 auto;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            border-radius: 999px;
            background: rgba(255, 250, 243, .88);
            border: 1px solid rgba(94, 60, 43, .14);
            color: var(--rj-primary);
            box-shadow: 0 12px 28px rgba(79, 46, 28, .08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .rj-label::before {
            content: "✦";
            color: var(--rj-gold);
        }

        .rj-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 999px;
            padding: 13px 24px;
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: #fff7ea;
            font-weight: 950;
            box-shadow: 0 16px 30px rgba(82, 47, 29, .18);
        }

        .rj-btn.gold {
            color: #422615;
            background: linear-gradient(135deg, var(--rj-gold-dark), var(--rj-gold), #f5d8a1);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 70;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 45px;
            height: 45px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 14px 30px rgba(77, 43, 24, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 1px solid rgba(93, 59, 42, .10);
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: var(--rj-gold);
        }

        .floating-icon {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        /* HERO */
        .rj-hero {
            padding-top: 80px;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 18%, rgba(255,255,255,.64), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,.35), rgba(255,244,232,.72));
        }

        .rj-hero-frame {
            position: relative;
            width: min(100%, 720px);
            min-height: 730px;
            margin: 0 auto;
            padding: 96px 54px 104px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            isolation: isolate;
        }

        .rj-hero-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -2;
            border-radius: 45% 45% 34px 34px / 110px 110px 34px 34px;
            border: 8px double rgba(92, 55, 38, .76);
            background:
                linear-gradient(180deg, rgba(255, 246, 237, .56), rgba(255, 239, 222, .62)),
                var(--rj-hero-image, none);
            background-size: cover;
            background-position: center bottom;
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.5),
                0 30px 76px rgba(79, 46, 28, .14);
        }

        .rj-hero-frame::after {
            content: "";
            position: absolute;
            inset: 20px;
            z-index: -1;
            border-radius: 43% 43% 24px 24px / 92px 92px 24px 24px;
            border: 1px solid rgba(220, 178, 111, .66);
            background:
                radial-gradient(circle at 50% 15%, rgba(255,255,255,.38), transparent 26%),
                radial-gradient(circle at 50% 90%, rgba(116, 75, 50, .12), transparent 32%);
            pointer-events: none;
        }

        .rj-frame-top {
            position: absolute;
            top: -128px; /* dinaikkan lagi */
            left: 50%;
            transform: translateX(-50%);
            width: min(720px, 114%);
            z-index: 4;
            pointer-events: none;
        }

        @media (max-width: 1024px) and (min-width: 641px) {
            .rj-frame-top {
                top: -108px;   /* tablet & laptop kecil */
                width: 116%;
            }
        }

        @media (max-width: 640px) {
            .rj-frame-top {
                width: 128%;
                top: -68px;   /* mobile tetap aman */
            }
        }

        .rj-wayang-left,
        .rj-wayang-right {
            position: absolute;
            bottom: -126px;
            width: 380px;
            z-index: 4;
            opacity: .86;
            pointer-events: none;
        }

        .rj-wayang-left {
            left: -150px;
        }

        .rj-wayang-right {
            right: -150px;
        }

        .rj-hero-house {
            position: absolute;
            left: 50%;
            bottom: 28px;
            width: min(560px, 88%);
            transform: translateX(-50%);
            z-index: 2;
            opacity: .26;
            pointer-events: none;
        }

        .rj-hero-kicker {
            color: var(--rj-primary);
            font-weight: 950;
            letter-spacing: .18em;
            font-size: 12px;
            text-transform: uppercase;
        }

        .rj-names {
            margin-top: 24px;
            color: var(--rj-primary);
            font-size: clamp(4rem, 8.6vw, 7.4rem);
            line-height: .88;
            text-shadow: 0 12px 28px rgba(80, 45, 25, .12);
        }

        .rj-names small {
            display: block;
            font-size: clamp(1.8rem, 3.2vw, 2.6rem);
            line-height: 1;
            margin: 14px 0;
            color: var(--rj-secondary);
        }

        .rj-date {
            margin-top: 26px;
            color: var(--rj-ink);
            font-size: 15px;
            font-weight: 900;
            letter-spacing: .25em;
        }

        .rj-open {
            margin-top: 30px;
        }

        /* QUOTE */
        .rj-arch-panel {
            position: relative;
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 86px 54px;
            border-radius: 999px 999px 42px 42px;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.7), transparent 26%),
                linear-gradient(180deg, #fff7ec, #f4e3d2);
            border: 10px solid rgba(116, 75, 50, .20);
            box-shadow:
                0 26px 70px rgba(80, 45, 25, .12),
                inset 0 0 0 1px rgba(255,255,255,.74);
            text-align: center;
            overflow: hidden;
        }

        .rj-arch-panel::before {
            content: "";
            position: absolute;
            inset: 22px;
            border-radius: 999px 999px 32px 32px;
            border: 1px solid rgba(116, 75, 50, .18);
            pointer-events: none;
        }

        .rj-gunungan-img {
            width: min(210px, 54%);
            margin: 0 auto 22px;
            opacity: .72;
            filter: sepia(.28);
        }

        .rj-quote-title {
            color: var(--rj-primary);
            font-size: clamp(3rem, 7vw, 5.4rem);
        }

        .rj-quote-text {
            margin-top: 22px;
            color: #5e4a3b;
            line-height: 2;
            font-size: 1.05rem;
        }

        /* COUPLE */
        .rj-couple-grid {
            margin-top: 42px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 28px;
        }

        .rj-person {
            position: relative;
            text-align: center;
            padding: 28px 24px 34px;
            border-radius: 999px 999px 34px 34px;
            background: rgba(255, 246, 236, .82);
            border: 1px solid rgba(93, 59, 42, .14);
            box-shadow: 0 20px 52px rgba(79, 46, 28, .10);
            overflow: hidden;
        }

        .rj-person::before {
            content: "";
            position: absolute;
            inset: 14px;
            border: 1px solid rgba(220, 178, 111, .42);
            border-radius: 999px 999px 24px 24px;
            pointer-events: none;
        }

        .rj-person-photo,
        .rj-person-placeholder {
            width: 100%;
            max-width: 330px;
            height: 440px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            object-fit: cover;
            object-position: center;
            border-radius: 999px 999px 26px 26px;
            border: 8px solid #fff7ec;
            outline: 1px solid rgba(93, 59, 42, .18);
            box-shadow: 0 18px 42px rgba(79, 46, 28, .14);
            background:
                radial-gradient(circle at center, rgba(220, 178, 111, .18), transparent 26%),
                #e9d7c5;
            filter: sepia(.28) saturate(.78);
            color: var(--rj-primary);
            font-size: 4rem;
            font-weight: 950;
        }

        .rj-person h3 {
            margin-top: 24px;
            color: var(--rj-primary);
            font-size: clamp(2.4rem, 5vw, 4rem);
        }

        .rj-person .sub {
            margin-top: 8px;
            color: var(--rj-secondary);
            font-weight: 900;
        }

        .rj-person .family {
            margin-top: 12px;
            color: #6a5545;
            line-height: 1.8;
        }

        /* DETAIL */
        .rj-detail-panel {
            position: relative;
            width: min(100%, 740px);
            margin: 36px auto 0;
            padding: 58px 34px;
            color: #fff3e4;
            text-align: center;
            border-radius: 999px 999px 38px 38px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(94, 59, 39, .88), rgba(112, 73, 49, .82)),
                var(--rj-detail-image, none);
            background-size: cover;
            background-position: center bottom;
            border: 1px solid rgba(220, 178, 111, .38);
            box-shadow: 0 26px 68px rgba(79, 46, 28, .18);
        }

        .rj-detail-panel::before {
            content: "";
            position: absolute;
            inset: 18px;
            border: 1px solid rgba(255, 236, 204, .36);
            border-radius: 999px 999px 26px 26px;
            pointer-events: none;
        }

        .rj-detail-title {
            color: #fff6e8;
            font-size: clamp(3.2rem, 7vw, 5.2rem);
        }

        .rj-detail-line {
            margin-top: 22px;
            color: #fff6e8;
            font-size: clamp(1.15rem, 3vw, 1.65rem);
            line-height: 2;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .rj-detail-place {
            margin-top: 20px;
            color: rgba(255, 246, 232, .86);
            line-height: 1.9;
        }

        .rj-count-grid {
            max-width: 660px;
            margin: 34px auto 0;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .rj-count-card {
            padding: 18px 10px;
            border-radius: 999px 999px 20px 20px;
            background: rgba(112, 73, 49, .92);
            color: #fff6e8;
            text-align: center;
            border: 1px solid rgba(220, 178, 111, .34);
            box-shadow: 0 14px 30px rgba(79, 46, 28, .12);
        }

        .rj-count-number {
            display: block;
            color: #ffe0a4;
            font-size: 2.1rem;
            line-height: 1;
            font-weight: 950;
        }

        .rj-count-label {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .rj-map-card {
            width: min(100%, 820px);
            margin: 28px auto 0;
            overflow: hidden;
            border-radius: 30px;
            background: #fff7ec;
            border: 1px solid rgba(93, 59, 42, .12);
            box-shadow: 0 18px 48px rgba(79, 46, 28, .10);
        }

        .rj-map-frame,
        .rj-map-placeholder {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }

        .rj-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 28px;
            text-decoration: none;
            color: var(--rj-primary);
            background:
                radial-gradient(circle at center, rgba(220, 178, 111, .16), transparent 28%),
                #fff7ec;
        }

        /* GALLERY */
        .rj-gallery-grid {
            margin-top: 34px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .rj-gallery-item {
            display: block;
            overflow: hidden;
            border-radius: 999px 999px 24px 24px;
            padding: 7px;
            background: #fff7ec;
            border: 1px solid rgba(93, 59, 42, .12);
            box-shadow: 0 14px 36px rgba(79, 46, 28, .10);
        }

        .rj-gallery-item:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }

        .rj-gallery-item img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            border-radius: 999px 999px 18px 18px;
            filter: sepia(.24) saturate(.88);
        }

        .rj-gallery-item:first-child img {
            height: 366px;
        }

        /* GIFT & RSVP */
        .rj-gift-grid {
            margin-top: 34px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }

        .rj-card {
            border-radius: 28px;
            padding: 28px;
            background:
                radial-gradient(circle at 50% 0%, rgba(220, 178, 111, .16), transparent 34%),
                rgba(255, 247, 236, .86);
            border: 1px solid rgba(93, 59, 42, .14);
            box-shadow: 0 18px 44px rgba(79, 46, 28, .10);
        }

        .rj-gift-title {
            color: var(--rj-primary);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .rj-gift-box {
            margin-top: 18px;
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(93, 59, 42, .10);
        }

        .rj-copy-btn {
            width: 100%;
            margin-top: 16px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            padding: 12px 16px;
            background: var(--rj-primary);
            color: #fff7ec;
            font-weight: 950;
        }

        .rj-form-wrap {
            width: min(100%, 760px);
            margin: 34px auto 0;
        }

        .rj-input {
            width: 100%;
            border: 1px solid rgba(93, 59, 42, .14);
            background: rgba(255,255,255,.86);
            color: var(--rj-ink);
            border-radius: 14px;
            padding: 13px 14px;
            outline: none;
        }

        .rj-label-form {
            display: block;
            color: #654a38;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .04em;
        }

        .rj-summary-grid {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            text-align: center;
        }

        .rj-summary-grid > div {
            padding: 18px 12px;
            border-radius: 18px;
            background: rgba(255,247,236,.84);
            border: 1px solid rgba(93,59,42,.12);
        }

        .rj-summary-grid b {
            color: var(--rj-primary);
            font-size: 2rem;
            line-height: 1;
        }

        .rj-message-list {
            margin-top: 24px;
            display: grid;
            gap: 14px;
        }

        .rj-message-card {
            border-radius: 22px;
            padding: 20px;
            background: rgba(255,247,236,.84);
            border: 1px solid rgba(93,59,42,.12);
            box-shadow: 0 12px 30px rgba(79,46,28,.08);
        }

        .rj-closing-card {
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 44px 34px;
            text-align: center;
            border-radius: 999px 999px 34px 34px;
            background: rgba(255,247,236,.86);
            border: 1px solid rgba(93,59,42,.14);
            box-shadow: 0 20px 52px rgba(79,46,28,.10);
        }

        .rj-closing-photo {
            width: 220px;
            height: 270px;
            object-fit: cover;
            object-position: center;
            display: block;
            margin: 0 auto 26px;
            border-radius: 999px 999px 24px 24px;
            border: 8px solid #fff7ec;
            outline: 1px solid rgba(93,59,42,.14);
            filter: sepia(.24) saturate(.86);
            background: #e9d7c5;
        }

        @media (max-width: 900px) {
            .rj-shell {
                padding: 14px;
            }

            .rj-wrap {
                border-radius: 26px;
            }

            .rj-section {
                padding: 84px 36px;
            }

            .rj-couple-grid {
                grid-template-columns: 1fr;
            }

            .rj-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            body {
                background: #f6eadf;
            }

            .rj-shell {
                padding: 0;
            }

            .rj-wrap {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
            }

            .rj-section {
                padding: 74px 22px;
            }

            .rj-section.compact {
                padding-top: 66px;
                padding-bottom: 66px;
            }

            .rj-nav {
                top: 10px;
                max-width: calc(100% - 18px);
            }

            .rj-hero-frame {
                min-height: 660px;
                padding: 82px 24px 100px;
            }

            .rj-wayang-left,
            .rj-wayang-right {
                width: 296px;
                bottom: -62px;
                opacity: .72;
            }

            .rj-wayang-left {
                left: -40px;
            }

            .rj-wayang-right {
                right: -40px;
            }

            .rj-hero-house {
                width: 106%;
                opacity: .20;
            }

            .rj-names {
                font-size: clamp(3.2rem, 17vw, 5.3rem);
            }

            .rj-arch-panel {
                padding: 70px 24px;
            }

            .rj-person-photo,
            .rj-person-placeholder {
                height: auto;
                aspect-ratio: 4 / 5;
            }

            .rj-count-grid,
            .rj-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .rj-gallery-grid {
                grid-template-columns: 1fr;
            }

            .rj-gallery-item:first-child {
                grid-column: auto;
                grid-row: auto;
            }

            .rj-gallery-item img,
            .rj-gallery-item:first-child img {
                height: 260px;
            }

            .floating-actions {
                right: 10px;
                gap: 8px;
            }

            .floating-actions a,
            .floating-action-button {
                width: 42px;
                height: 42px;
            }
        }

        /* =====================================================
        FIX MOBILE - CORNER GOLD ROYAL JAVANESE
        Desktop/tablet tetap, mobile saja diperkecil
        ===================================================== */

        @media (max-width: 640px) {
            .rj-corner-left,
            .rj-corner-right {
                width: 118px;
                top: -18px;
                opacity: .88;
                z-index: 2;
            }

            .rj-corner-left {
                left: -22px;
            }

            .rj-corner-right {
                right: -22px;
                transform: scaleX(-1);
            }
        }

        /* =====================================================
        WAYANG - LAPTOP KECIL / TABLET LANDSCAPE 1024px
        ===================================================== */
        @media (max-width: 1024px) and (min-width: 769px) {
            .rj-wayang-left,
            .rj-wayang-right {
                width: 300px;
                bottom: 52px;
                opacity: .82;
                bottom: -110px;
            }

            .rj-wayang-left {
                left: -130px;
            }

            .rj-wayang-right {
                right: -130px;
            }
        }

        /* =====================================================
        WAYANG - TABLET 768px
        ===================================================== */
        @media (max-width: 768px) and (min-width: 641px) {
            .rj-wayang-left,
            .rj-wayang-right {
                width: 240px;
                bottom: -86px;
                opacity: .76;
            }

            .rj-wayang-left {
                left: -45px;
            }

            .rj-wayang-right {
                right: -45px;
            }
        }

        /* =====================================================
        PREMIUM BACKGROUND + WAYANG ANIMATION
        Royal Javanese
        ===================================================== */

        /* kalau media query 768px sebelumnya belum ditutup, pastikan ada penutup ini */
        /* } */

        /* Background utama lebih mewah */
        .rj-wrap {
            background:
                radial-gradient(circle at 50% -8%, rgba(255,255,255,.82), transparent 28%),
                radial-gradient(circle at 12% 10%, color-mix(in srgb, var(--rj-gold) 28%, transparent), transparent 24%),
                radial-gradient(circle at 88% 18%, color-mix(in srgb, var(--rj-primary) 18%, transparent), transparent 25%),
                radial-gradient(circle at 10% 82%, color-mix(in srgb, var(--rj-secondary) 16%, transparent), transparent 25%),
                radial-gradient(circle at 90% 88%, color-mix(in srgb, var(--rj-gold) 22%, transparent), transparent 24%),
                linear-gradient(90deg, rgba(93, 59, 42, .045) 1px, transparent 1px) 0 0 / 38px 38px,
                linear-gradient(0deg, rgba(93, 59, 42, .038) 1px, transparent 1px) 0 0 / 38px 38px,
                radial-gradient(circle at center, rgba(126, 84, 57, .10) 0 1.6px, transparent 2.4px) 0 0 / 24px 24px,
                linear-gradient(180deg, #fff7ec 0%, var(--rj-paper) 42%, #f8e7d6 72%, #fff4e8 100%) !important;
        }

        /* Motif batik halus agar tidak polos */
        .rj-noise {
            opacity: .62 !important;
            background:
                radial-gradient(circle at center, rgba(216, 177, 104, .22) 0 1.6px, transparent 2.2px) 0 0 / 28px 28px,
                radial-gradient(circle at center, rgba(109, 70, 48, .11) 0 1px, transparent 2px) 14px 14px / 28px 28px,
                linear-gradient(135deg, transparent 45%, rgba(216, 177, 104, .10) 46%, transparent 49%) 0 0 / 58px 58px,
                linear-gradient(45deg, transparent 45%, rgba(109, 70, 48, .075) 46%, transparent 49%) 0 0 / 58px 58px !important;
        }

        /* Watermark ornamen per section */
        .rj-section::before {
            content: "";
            position: absolute;
            inset: 28px;
            z-index: 0;
            pointer-events: none;
            opacity: .16;
            border-radius: 34px;
            background:
                radial-gradient(circle at 8% 12%, color-mix(in srgb, var(--rj-gold) 40%, transparent) 0 3px, transparent 4px) 0 0 / 42px 42px,
                radial-gradient(circle at 92% 84%, color-mix(in srgb, var(--rj-primary) 28%, transparent) 0 2px, transparent 3px) 0 0 / 52px 52px,
                linear-gradient(135deg, transparent 46%, color-mix(in srgb, var(--rj-gold) 12%, transparent) 47%, transparent 50%) 0 0 / 72px 72px;
        }

        .rj-section > * {
            position: relative;
            z-index: 2;
        }

        /* Ornamen lingkaran samar di sudut tiap section */
        .rj-section::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            right: -120px;
            top: 80px;
            z-index: 1;
            pointer-events: none;
            opacity: .14;
            border-radius: 999px;
            background:
                conic-gradient(
                    from 45deg,
                    transparent 0 14%,
                    color-mix(in srgb, var(--rj-gold) 55%, transparent) 15% 18%,
                    transparent 19% 38%,
                    color-mix(in srgb, var(--rj-primary) 38%, transparent) 39% 42%,
                    transparent 43% 100%
                );
        }

        /* Hero background lebih premium */
        .rj-hero {
            background:
                radial-gradient(circle at 50% 18%, rgba(255,255,255,.78), transparent 24%),
                radial-gradient(circle at 18% 26%, color-mix(in srgb, var(--rj-gold) 24%, transparent), transparent 22%),
                radial-gradient(circle at 86% 78%, color-mix(in srgb, var(--rj-primary) 18%, transparent), transparent 26%),
                linear-gradient(180deg, rgba(255,255,255,.46), rgba(255,244,232,.82)) !important;
        }

        /* Frame hero lebih berlapis */
        .rj-hero-frame::before {
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.55),
                inset 0 0 70px rgba(255,255,255,.36),
                0 30px 76px rgba(79, 46, 28, .18),
                0 0 0 14px color-mix(in srgb, var(--rj-gold) 10%, transparent) !important;
        }

        .rj-hero-frame::after {
            background:
                radial-gradient(circle at 50% 12%, rgba(255,255,255,.44), transparent 25%),
                radial-gradient(circle at 50% 88%, rgba(116, 75, 50, .13), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.12), transparent) !important;
        }

        /* Tambahan glow di belakang nama */
        .rj-names {
            text-shadow:
                0 10px 24px rgba(80, 45, 25, .16),
                0 0 28px color-mix(in srgb, var(--rj-gold) 18%, transparent) !important;
        }

        /* Card/panel lebih mewah */
        .rj-arch-panel,
        .rj-person,
        .rj-detail-panel,
        .rj-card,
        .rj-message-card,
        .rj-closing-card,
        .rj-map-card {
            box-shadow:
                0 24px 64px rgba(79, 46, 28, .13),
                inset 0 1px 0 rgba(255,255,255,.62) !important;
        }

        /* Border gold halus pada panel utama */
        .rj-arch-panel,
        .rj-person,
        .rj-card,
        .rj-message-card,
        .rj-closing-card {
            border-color: color-mix(in srgb, var(--rj-gold) 42%, rgba(93, 59, 42, .14)) !important;
        }

        /* =====================================================
        ANIMASI WAYANG
        ===================================================== */

        .rj-wayang-left,
        .rj-wayang-right {
            transform-origin: bottom center;
            will-change: transform, filter, opacity;
            animation-duration: 5.8s;
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
            filter:
                drop-shadow(0 16px 24px rgba(77, 43, 24, .18))
                sepia(.10)
                saturate(1.06);
        }

        .rj-wayang-left {
            animation-name: rjWayangLeftFloat;
        }

        .rj-wayang-right {
            animation-name: rjWayangRightFloat;
        }

        @keyframes rjWayangLeftFloat {
            0% {
                transform: translateY(0) rotate(-1.2deg) scale(1);
                opacity: .84;
            }

            35% {
                transform: translateY(-8px) rotate(1.4deg) scale(1.015);
                opacity: .92;
            }

            70% {
                transform: translateY(4px) rotate(-.6deg) scale(1.006);
                opacity: .88;
            }

            100% {
                transform: translateY(0) rotate(-1.2deg) scale(1);
                opacity: .84;
            }
        }

        @keyframes rjWayangRightFloat {
            0% {
                transform: translateY(0) rotate(1.2deg) scale(1);
                opacity: .84;
            }

            35% {
                transform: translateY(-8px) rotate(-1.4deg) scale(1.015);
                opacity: .92;
            }

            70% {
                transform: translateY(4px) rotate(.6deg) scale(1.006);
                opacity: .88;
            }

            100% {
                transform: translateY(0) rotate(1.2deg) scale(1);
                opacity: .84;
            }
        }

        /* Animasi ornamen atas agar lebih hidup */
        .rj-frame-top {
            animation: rjFrameTopGlow 4.8s ease-in-out infinite;
        }

        @keyframes rjFrameTopGlow {
            0%, 100% {
                filter:
                    drop-shadow(0 12px 18px rgba(77, 43, 24, .14))
                    saturate(1);
            }

            50% {
                filter:
                    drop-shadow(0 18px 24px rgba(154, 107, 22, .24))
                    saturate(1.12);
            }
        }

        /* Animasi joglo/background hero pelan */
        .rj-hero-house {
            animation: rjJogloBreath 7s ease-in-out infinite;
        }

        @keyframes rjJogloBreath {
            0%, 100% {
                transform: translateX(-50%) translateY(0) scale(1);
                opacity: .24;
            }

            50% {
                transform: translateX(-50%) translateY(-5px) scale(1.02);
                opacity: .32;
            }
        }

        /* Animasi tombol */
        .rj-open .rj-btn {
            animation: rjButtonPulse 2.6s ease-in-out infinite;
        }

        @keyframes rjButtonPulse {
            0%, 100% {
                box-shadow:
                    0 16px 30px rgba(82, 47, 29, .18),
                    0 0 0 0 color-mix(in srgb, var(--rj-gold) 28%, transparent);
            }

            50% {
                box-shadow:
                    0 18px 34px rgba(82, 47, 29, .24),
                    0 0 0 8px color-mix(in srgb, var(--rj-gold) 0%, transparent);
            }
        }

        /* =====================================================
        RESPONSIVE: background tetap mewah tapi tidak terlalu ramai
        ===================================================== */

        @media (max-width: 1024px) {
            .rj-section::before {
                inset: 22px;
                opacity: .13;
            }

            .rj-section::after {
                width: 220px;
                height: 220px;
                right: -96px;
                opacity: .11;
            }

            .rj-wrap {
                background:
                    radial-gradient(circle at 50% -8%, rgba(255,255,255,.76), transparent 28%),
                    radial-gradient(circle at 14% 12%, color-mix(in srgb, var(--rj-gold) 22%, transparent), transparent 24%),
                    radial-gradient(circle at 86% 18%, color-mix(in srgb, var(--rj-primary) 14%, transparent), transparent 25%),
                    linear-gradient(90deg, rgba(93, 59, 42, .038) 1px, transparent 1px) 0 0 / 34px 34px,
                    linear-gradient(0deg, rgba(93, 59, 42, .030) 1px, transparent 1px) 0 0 / 34px 34px,
                    radial-gradient(circle at center, rgba(126, 84, 57, .075) 0 1.4px, transparent 2px) 0 0 / 22px 22px,
                    linear-gradient(180deg, var(--rj-paper) 0%, #fff5eb 48%, var(--rj-paper) 100%) !important;
            }
        }

        @media (max-width: 640px) {
            .rj-section::before {
                inset: 14px;
                opacity: .10;
                background:
                    radial-gradient(circle at 8% 12%, color-mix(in srgb, var(--rj-gold) 32%, transparent) 0 2px, transparent 3px) 0 0 / 34px 34px,
                    linear-gradient(135deg, transparent 46%, color-mix(in srgb, var(--rj-gold) 9%, transparent) 47%, transparent 50%) 0 0 / 54px 54px;
            }

            .rj-section::after {
                width: 150px;
                height: 150px;
                right: -70px;
                top: 60px;
                opacity: .08;
            }

            .rj-noise {
                opacity: .42 !important;
            }

            .rj-wayang-left,
            .rj-wayang-right {
                animation-duration: 6.4s;
            }
        }

        /* Untuk user yang mengaktifkan reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .rj-wayang-left,
            .rj-wayang-right,
            .rj-frame-top,
            .rj-hero-house,
            .rj-open .rj-btn {
                animation: none !important;
            }
        }


        /* =====================================================
        LUXURY REVEAL ANIMATION - ROYAL JAVANESE
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen yang muncul saat scroll */
        .rj-reveal,
        .rj-label,
        .rj-title,
        .rj-hero-kicker,
        .rj-names,
        .rj-date,
        .rj-open,
        .rj-arch-panel,
        .rj-gunungan-img,
        .rj-person,
        .rj-detail-panel,
        .rj-count-card,
        .rj-map-card,
        .rj-gallery-item,
        .rj-card,
        .rj-message-card,
        .rj-closing-card {
            opacity: 0;
            transform: translateY(36px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .9s cubic-bezier(.2, .8, .2, 1),
                transform .9s cubic-bezier(.2, .8, .2, 1),
                filter .9s cubic-bezier(.2, .8, .2, 1),
                box-shadow .35s ease,
                border-color .35s ease;
            will-change: opacity, transform, filter;
        }

        .rj-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Hero muncul otomatis saat halaman dibuka */
        .rj-hero .rj-hero-frame {
            animation: rjHeroEnter 1.1s cubic-bezier(.2, .8, .2, 1) both;
        }

        .rj-hero .rj-frame-top {
            animation:
                rjFrameTopEnter 1.05s cubic-bezier(.2, .8, .2, 1) .12s both,
                rjFrameTopGlow 4.8s ease-in-out 1.3s infinite;
        }

        .rj-hero .rj-hero-kicker {
            animation: rjFadeDown .8s ease .25s both;
        }

        .rj-hero .rj-names {
            animation: rjLuxuryName 1.15s cubic-bezier(.2, .8, .2, 1) .38s both;
        }

        .rj-hero .rj-date {
            animation: rjFadeUp .85s ease .58s both;
        }

        .rj-hero .rj-open {
            animation: rjFadeUp .85s ease .78s both;
        }

        /* Ornamen sudut bergerak halus */
        .rj-corner-left {
            animation: rjCornerLeftFloat 6.4s ease-in-out infinite;
            transform-origin: center center;
        }

        .rj-corner-right {
            animation: rjCornerRightFloat 6.4s ease-in-out infinite;
            transform-origin: center center;
        }

        /* Wayang tetap bergerak, lebih halus */
        .rj-wayang-left {
            animation: rjWayangLeftLuxury 5.8s ease-in-out infinite;
            transform-origin: bottom center;
        }

        .rj-wayang-right {
            animation: rjWayangRightLuxury 5.8s ease-in-out infinite;
            transform-origin: bottom center;
        }

        /* Background motif bergerak pelan */
        .rj-noise {
            animation: rjNoiseDrift 14s ease-in-out infinite alternate;
        }

        /* Rumah/joglo background bernapas */
        .rj-hero-house {
            animation: rjHouseBreath 7s ease-in-out infinite;
        }

        /* Label ada efek kilau */
        .rj-label {
            position: relative;
            overflow: hidden;
        }

        .rj-label::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -75%;
            width: 46%;
            height: 210%;
            transform: rotate(22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, .56),
                transparent
            );
            animation: rjLabelShine 3.8s ease-in-out infinite;
        }

        /* Tombol ada efek kilau */
        .rj-btn,
        .rj-copy-btn {
            position: relative;
            overflow: hidden;
        }

        .rj-btn::after,
        .rj-copy-btn::after {
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
                rgba(255, 255, 255, .48),
                transparent
            );
            animation: rjButtonShine 3.2s ease-in-out infinite;
        }

        /* Card hover terlihat mahal di desktop */
        @media (hover: hover) {
            .rj-arch-panel:hover,
            .rj-person:hover,
            .rj-detail-panel:hover,
            .rj-count-card:hover,
            .rj-map-card:hover,
            .rj-gallery-item:hover,
            .rj-card:hover,
            .rj-message-card:hover,
            .rj-closing-card:hover {
                transform: translateY(-7px) scale(1.01) !important;
                border-color: color-mix(in srgb, var(--rj-gold) 58%, transparent) !important;
                box-shadow:
                    0 30px 78px rgba(79, 46, 28, .18),
                    0 0 44px color-mix(in srgb, var(--rj-gold) 18%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.66) !important;
            }

            .rj-gallery-item img {
                transition: transform .75s ease, filter .75s ease;
            }

            .rj-gallery-item:hover img {
                transform: scale(1.055);
                filter: sepia(.18) saturate(1.02) contrast(1.04);
            }
        }

        /* Countdown glow */
        .rj-count-number {
            animation: rjNumberGlow 2.4s ease-in-out infinite alternate;
        }

        /* Floating action button */
        .floating-actions a,
        .floating-action-button {
            animation: rjFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes rjHeroEnter {
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

        @keyframes rjFrameTopEnter {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-26px) scale(.94);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes rjFadeUp {
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

        @keyframes rjFadeDown {
            from {
                opacity: 0;
                transform: translateY(-22px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes rjLuxuryName {
            from {
                opacity: 0;
                transform: translateY(36px) scale(.94);
                letter-spacing: .08em;
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes rjCornerLeftFloat {
            0%, 100% {
                transform: translateY(0) rotate(-1deg) scale(1);
            }
            50% {
                transform: translateY(-10px) rotate(1.2deg) scale(1.025);
            }
        }

        @keyframes rjCornerRightFloat {
            0%, 100% {
                transform: scaleX(-1) translateY(0) rotate(1deg) scale(1);
            }
            50% {
                transform: scaleX(-1) translateY(-10px) rotate(-1.2deg) scale(1.025);
            }
        }

        @keyframes rjWayangLeftLuxury {
            0%, 100% {
                transform: translateY(0) rotate(-1.2deg) scale(1);
                opacity: .82;
            }
            35% {
                transform: translateY(-9px) rotate(1.5deg) scale(1.018);
                opacity: .92;
            }
            70% {
                transform: translateY(4px) rotate(-.6deg) scale(1.006);
                opacity: .86;
            }
        }

        @keyframes rjWayangRightLuxury {
            0%, 100% {
                transform: translateY(0) rotate(1.2deg) scale(1);
                opacity: .82;
            }
            35% {
                transform: translateY(-9px) rotate(-1.5deg) scale(1.018);
                opacity: .92;
            }
            70% {
                transform: translateY(4px) rotate(.6deg) scale(1.006);
                opacity: .86;
            }
        }

        @keyframes rjNoiseDrift {
            from {
                transform: translate3d(-8px, -8px, 0);
                opacity: .46;
            }
            to {
                transform: translate3d(10px, 10px, 0);
                opacity: .64;
            }
        }

        @keyframes rjHouseBreath {
            0%, 100% {
                transform: translateX(-50%) translateY(0) scale(1);
                opacity: .24;
            }
            50% {
                transform: translateX(-50%) translateY(-5px) scale(1.025);
                opacity: .34;
            }
        }

        @keyframes rjFrameTopGlow {
            0%, 100% {
                filter:
                    drop-shadow(0 12px 18px rgba(77, 43, 24, .14))
                    saturate(1);
            }
            50% {
                filter:
                    drop-shadow(0 18px 24px rgba(154, 107, 22, .24))
                    saturate(1.12);
            }
        }

        @keyframes rjLabelShine {
            0%, 48% {
                left: -75%;
            }
            72%, 100% {
                left: 130%;
            }
        }

        @keyframes rjButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes rjNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--rj-gold) 20%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--rj-gold) 44%, transparent),
                    0 0 34px color-mix(in srgb, var(--rj-gold) 20%, transparent);
            }
        }

        @keyframes rjFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .rj-reveal,
            .rj-label,
            .rj-title,
            .rj-hero-kicker,
            .rj-names,
            .rj-date,
            .rj-open,
            .rj-arch-panel,
            .rj-gunungan-img,
            .rj-person,
            .rj-detail-panel,
            .rj-count-card,
            .rj-map-card,
            .rj-gallery-item,
            .rj-card,
            .rj-message-card,
            .rj-closing-card {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .rj-wayang-left,
            .rj-wayang-right,
            .rj-corner-left,
            .rj-corner-right {
                animation-duration: 7.2s;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .rj-reveal,
            .rj-label,
            .rj-title,
            .rj-hero-kicker,
            .rj-names,
            .rj-date,
            .rj-open,
            .rj-arch-panel,
            .rj-gunungan-img,
            .rj-person,
            .rj-detail-panel,
            .rj-count-card,
            .rj-map-card,
            .rj-gallery-item,
            .rj-card,
            .rj-message-card,
            .rj-closing-card,
            .rj-wayang-left,
            .rj-wayang-right,
            .rj-corner-left,
            .rj-corner-right,
            .rj-frame-top,
            .rj-hero-house,
            .rj-noise,
            .floating-actions a,
            .floating-action-button,
            .rj-count-number {
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
    $themeColor = $invitation->theme_color ?? 'brown';

    $rjThemes = [
        'maroon' => [
            'primary' => '#673029',
            'secondary' => '#8f4f3c',
            'gold' => '#d9b56a',
            'goldDark' => '#a97834',
            'paper' => '#fff3e5',
            'ink' => '#3f2c23',
            'glow' => 'rgba(103,48,41,.15)',
        ],
        'emerald' => [
            'primary' => '#164f43',
            'secondary' => '#32775f',
            'gold' => '#d9b56a',
            'goldDark' => '#a97834',
            'paper' => '#f4fff8',
            'ink' => '#203d35',
            'glow' => 'rgba(22,79,67,.13)',
        ],
        'navy' => [
            'primary' => '#243047',
            'secondary' => '#495c7e',
            'gold' => '#d9b56a',
            'goldDark' => '#a97834',
            'paper' => '#f7f9ff',
            'ink' => '#20283a',
            'glow' => 'rgba(36,48,71,.12)',
        ],
        'rose' => [
            'primary' => '#8d3b52',
            'secondary' => '#b66b7b',
            'gold' => '#d9b56a',
            'goldDark' => '#a97834',
            'paper' => '#fff3f6',
            'ink' => '#432a33',
            'glow' => 'rgba(141,59,82,.13)',
        ],
        'gold' => [
            'primary' => '#6a461f',
            'secondary' => '#9b6b28',
            'gold' => '#d6a846',
            'goldDark' => '#8c641c',
            'paper' => '#fff8e8',
            'ink' => '#493816',
            'glow' => 'rgba(154,107,22,.14)',
        ],
        'slate' => [
            'primary' => '#374151',
            'secondary' => '#64748b',
            'gold' => '#d6a846',
            'goldDark' => '#8c641c',
            'paper' => '#f8fafc',
            'ink' => '#1f2937',
            'glow' => 'rgba(55,65,81,.11)',
        ],
        'brown' => [
            'primary' => '#6d4630',
            'secondary' => '#9a6949',
            'gold' => '#d8b168',
            'goldDark' => '#9a6f32',
            'paper' => '#fff2e3',
            'ink' => '#4a3326',
            'glow' => 'rgba(109,70,48,.16)',
        ],
    ];

    $rjTheme = $rjThemes[$themeColor] ?? $rjThemes['brown'];

    $photos = $invitation->photos ?? collect();
    $firstPhoto = $photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Alfanov & Mutiara';
    $eventName = $invitation->event_name ?: 'Pernikahan';

    $nameParts = preg_split('/\s+(?:&|dan|\+)\s+/i', $eventTitle);
    $firstName = trim($nameParts[0] ?? $eventTitle);
    $secondName = trim($nameParts[1] ?? '');

    if ($secondName === '' && str_contains($eventTitle, '&')) {
        [$firstName, $secondName] = array_map('trim', explode('&', $eventTitle, 2));
    }

    if ($secondName === '') {
        $secondName = 'Pasangan';
    }

    $people = $invitation->people ?? collect();
    $groom = $people->get(0);
    $bride = $people->get(1);

    $eventDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y')
        : 'Tanggal belum diatur';

    $eventEndDateText = $invitation->event_end_date
        ? \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d F Y')
        : null;

    $startDate = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)
        : null;

    $endDate = $invitation->event_end_date
        ? \Carbon\Carbon::parse($invitation->event_end_date)
        : null;

    $eventDateText = $startDate
        ? $startDate->translatedFormat('d F Y')
        : 'Tanggal belum diatur';

    $eventDateRangeText = $eventDateText;

    if ($startDate && $endDate && !$startDate->isSameDay($endDate)) {
        if ($startDate->format('Y-m') === $endDate->format('Y-m')) {
            // Contoh: 31 - 30 Mei 2026
            $eventDateRangeText = $startDate->format('j') . ' - ' . $endDate->translatedFormat('j F Y');
        } elseif ($startDate->format('Y') === $endDate->format('Y')) {
            // Contoh: 31 Mei - 2 Juni 2026
            $eventDateRangeText = $startDate->translatedFormat('j F') . ' - ' . $endDate->translatedFormat('j F Y');
        } else {
            // Contoh: 31 Desember 2026 - 1 Januari 2027
            $eventDateRangeText = $startDate->translatedFormat('j F Y') . ' - ' . $endDate->translatedFormat('j F Y');
        }
    }

    $heroDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . y')
        : '-- . -- . --';

    $dayText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l')
        : 'Hari belum diatur';

    $endDayText = $invitation->event_end_date
        ? \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('l')
        : null;

    $dayRangeText = $dayText;

    if ($endDayText && $endDayText !== $dayText) {
        $dayRangeText = $dayText . ' - ' . $endDayText;
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Lokasi Acara';

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

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

            $calendarDetails = trim(($invitation->description ?: 'Undangan pernikahan') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($eventName . ' - ' . $eventTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) {
            $googleCalendarUrl = null;
        }
    }

    $shareMessage =
        "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n" .
        "Tanggal: {$eventDateRangeText}\n";

    if ($eventTimeText) {
        $shareMessage .= "Waktu: {$eventTimeText}\n";
    }

    if ($locationText) {
        $shareMessage .= "Tempat: {$locationText}\n";
    }

    $shareMessage .= "\nBuka undangan lengkap:\n{$shareUrl}";
    $shareText = urlencode($shareMessage);

    $heroImage = asset('assets/royal-javanese/hero-bg.png');

    $coverPhoto = null;
    if ($invitation->cover_image) {
        $coverPhoto = asset('storage/' . $invitation->cover_image);
    } elseif ($firstPhoto) {
        $coverPhoto = asset('storage/' . $firstPhoto->image_path);
    }

    $detailImage = asset('assets/royal-javanese/detail-bg.png');
    $closingPhoto = $coverPhoto;
@endphp

<body
    style="
        --rj-primary: {{ $rjTheme['primary'] }};
        --rj-secondary: {{ $rjTheme['secondary'] }};
        --rj-gold: {{ $rjTheme['gold'] }};
        --rj-gold-dark: {{ $rjTheme['goldDark'] }};
        --rj-paper: {{ $rjTheme['paper'] }};
        --rj-ink: {{ $rjTheme['ink'] }};
        --rj-glow: {{ $rjTheme['glow'] }};
    "
>
    <main class="rj-shell">
        <div class="rj-wrap">
            <div class="rj-noise"></div>

            <img src="{{ asset('assets/royal-javanese/corner-gold.png') }}" alt="" class="rj-decor rj-corner-left" onerror="this.style.display='none'">
            <img src="{{ asset('assets/royal-javanese/corner-gold.png') }}" alt="" class="rj-decor rj-corner-right" onerror="this.style.display='none'">

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
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background6.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            {{-- HERO --}}
            <section id="opening" class="rj-section rj-hero">
                <div class="rj-hero-frame" style="--rj-hero-image: url('{{ $heroImage }}');">
                    <img src="{{ asset('assets/royal-javanese/frame-top.png') }}" alt="" class="rj-frame-top" onerror="this.style.display='none'">
                    <img src="{{ asset('assets/royal-javanese/wayang-left.png') }}" alt="" class="rj-wayang-left" onerror="this.style.display='none'">
                    <img src="{{ asset('assets/royal-javanese/wayang-right.png') }}" alt="" class="rj-wayang-right" onerror="this.style.display='none'">

                    <p class="rj-hero-kicker">The Wedding Of</p>

                    <h1 class="rj-title rj-script rj-names">
                        {{ $firstName }}
                        <small>&</small>
                        {{ $secondName }}
                    </h1>

                    <p class="rj-date">{{ $heroDateText }}</p>

                    <div class="rj-open">
                        <a href="#quote" class="rj-btn gold">Buka Undangan ↓</a>
                    </div>
                </div>
            </section>

            {{-- QUOTE --}}
            <section id="quote" class="rj-section compact">
                <div class="rj-arch-panel">
                    <img src="{{ asset('assets/royal-javanese/gunungan.png') }}" alt="" class="rj-gunungan-img" onerror="this.style.display='none'">

                    <h2 class="rj-title rj-script rj-quote-title">Endless Love</h2>

                    <p class="rj-quote-text responsive-text">
                        “Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.”
                    </p>

                    <p class="font-black mt-6" style="color: var(--rj-primary);">
                        QS Ar-Rum : 21
                    </p>
                </div>
            </section>

            {{-- COUPLE --}}
            <section id="couple" class="rj-section compact text-center">
                <p class="rj-label">Groom & Bride</p>

                <h2 class="rj-title rj-script text-5xl md:text-7xl mt-6">
                    Groom & Bride
                </h2>

                <p class="responsive-text mt-5 max-w-2xl mx-auto leading-8" style="color:#6a5545;">
                    {{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.' }}
                </p>

                <div class="rj-couple-grid">
                    <div class="rj-person">
                        @if ($groom?->photo)
                            <img src="{{ asset('storage/' . $groom->photo) }}" alt="{{ $groom->name }}" class="rj-person-photo">
                        @elseif ($coverPhoto)
                            <img src="{{ $coverPhoto }}" alt="{{ $groom?->name ?: $firstName }}" class="rj-person-photo">
                        @else
                            <div class="rj-person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($groom?->name ?: $firstName, 0, 1)) }}</div>
                        @endif

                        <h3 class="rj-title rj-script responsive-text">{{ $groom?->name ?: $firstName }}</h3>
                        <div class="sub responsive-text">{{ $groom?->subtitle ?: 'Mempelai Pria' }}</div>
                        <div class="family responsive-text">{{ $groom?->family_name ?: 'Putra dari keluarga tercinta' }}</div>
                    </div>

                    <div class="rj-person">
                        @if ($bride?->photo)
                            <img src="{{ asset('storage/' . $bride->photo) }}" alt="{{ $bride->name }}" class="rj-person-photo">
                        @elseif ($coverPhoto)
                            <img src="{{ $coverPhoto }}" alt="{{ $bride?->name ?: $secondName }}" class="rj-person-photo">
                        @else
                            <div class="rj-person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($bride?->name ?: $secondName, 0, 1)) }}</div>
                        @endif

                        <h3 class="rj-title rj-script responsive-text">{{ $bride?->name ?: $secondName }}</h3>
                        <div class="sub responsive-text">{{ $bride?->subtitle ?: 'Mempelai Wanita' }}</div>
                        <div class="family responsive-text">{{ $bride?->family_name ?: 'Putri dari keluarga tercinta' }}</div>
                    </div>
                </div>
            </section>

            {{-- DATE --}}
            <section id="date" class="rj-section compact text-center">
                <p class="rj-label">Count The Date</p>

                <h2 class="rj-title rj-script text-5xl md:text-7xl mt-6">
                    Save the Date
                </h2>

                <div class="rj-count-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                    <div class="rj-count-card"><span class="rj-count-number" id="countdown-days">00</span><span class="rj-count-label">Hari</span></div>
                    <div class="rj-count-card"><span class="rj-count-number" id="countdown-hours">00</span><span class="rj-count-label">Jam</span></div>
                    <div class="rj-count-card"><span class="rj-count-number" id="countdown-minutes">00</span><span class="rj-count-label">Menit</span></div>
                    <div class="rj-count-card"><span class="rj-count-number" id="countdown-seconds">00</span><span class="rj-count-label">Detik</span></div>
                </div>

                @if ($googleCalendarUrl)
                    <div class="mt-8">
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="rj-btn gold">Tambah ke Kalender</a>
                    </div>
                @endif
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="rj-section compact text-center">
                <p class="rj-label">Wedding Detail</p>

                <div class="rj-detail-panel" style="--rj-detail-image: url('{{ $detailImage }}');">
                    <h2 class="rj-title rj-script rj-detail-title">Pernikahan</h2>

                    <div class="rj-detail-line">
                        {{ strtoupper($eventDateRangeText) }}<br>
                        {{ $eventTimeText ? $eventTimeText : 'Waktu belum diatur' }}
                    </div>

                    <div class="rj-detail-place responsive-text">
                        {{ $locationText }}
                        @if ($invitation->address)
                            <br>{{ $invitation->address }}
                        @endif
                    </div>

                    @if ($mapOpenUrl)
                        <div class="mt-7">
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="rj-btn gold">Petunjuk Arah</a>
                        </div>
                    @endif
                </div>

                @if ($invitation->address || $mapOpenUrl)
                    <div class="rj-map-card">
                        @if ($mapEmbedUrl)
                            <iframe src="{{ $mapEmbedUrl }}" class="rj-map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                        @elseif ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="rj-map-placeholder">
                                <div>
                                    <p class="text-5xl">📍</p>
                                    <p class="font-black mt-3">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                    <p class="text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p>
                                </div>
                            </a>
                        @else
                            <div class="rj-map-placeholder">
                                <div>
                                    <p class="text-5xl">📍</p>
                                    <p class="font-black mt-3">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                    <p class="text-slate-600 mt-2">{{ $invitation->address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </section>

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="rj-section compact text-center">
                    <p class="rj-label">Galeri Momen</p>

                    <h2 class="rj-title rj-script text-5xl md:text-7xl mt-6">
                        Our Gallery
                    </h2>

                    <div class="rj-gallery-grid">
                        @foreach ($photos as $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="rj-gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFT --}}
            @if ($invitation->gifts->count())
                <section id="gift" class="rj-section compact">
                    <div class="text-center">
                        <p class="rj-label">Wedding Gift</p>

                        <h2 class="rj-title rj-script text-5xl md:text-7xl mt-6">
                            Wedding Gift
                        </h2>

                        <p class="responsive-text mt-5 max-w-2xl mx-auto leading-8" style="color:#6a5545;">
                            Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                        </p>
                    </div>

                    <div class="rj-gift-grid">
                        @foreach ($invitation->gifts as $gift)
                            <div class="rj-card">
                                <div class="rj-gift-title responsive-text">{{ $gift->label ?: 'Wedding Gift' }}</div>

                                <div class="rj-gift-box">
                                    <small class="font-black uppercase tracking-[.15em] text-slate-500">Nomor / Rekening</small>
                                    <strong class="responsive-text block mt-2 text-xl" style="color: var(--rj-primary);">{{ $gift->account_number ?: '-' }}</strong>
                                    <p class="responsive-text text-slate-600 mt-2">{{ $gift->account_name ?: 'Atas nama penerima' }}</p>
                                </div>

                                @if ($gift->account_number)
                                    <button type="button" class="rj-copy-btn" data-copy="{{ $gift->account_number }}">Salin Nomor</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="rj-section compact">
                <div class="text-center">
                    <p class="rj-label">RSVP Form</p>

                    <h2 class="rj-title text-5xl md:text-6xl mt-6">
                        RSVP Form
                    </h2>

                    <p class="responsive-text mt-5 max-w-2xl mx-auto leading-8" style="color:#6a5545;">
                        Kami tidak sabar menunggu hari pernikahan kami bersama Bapak/Ibu/Saudara/i. Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                    </p>
                </div>

                <div class="rj-form-wrap">
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

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="rj-card space-y-4">
                        @csrf

                        <div>
                            <label class="rj-label-form">Nama</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="rj-input mt-1" placeholder="Nama" required>
                        </div>

                        <div>
                            <label class="rj-label-form">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="rj-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="rj-label-form">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="rj-input mt-1">
                        </div>

                        <div>
                            <label class="rj-label-form">Pesan</label>
                            <textarea name="message" rows="4" class="rj-input mt-1" placeholder="Tulis pesan..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full rj-btn">Submit</button>
                    </form>

                    <div class="rj-summary-grid">
                        <div><b>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</b><p class="text-xs text-slate-500 mt-2">Tidak hadir</p></div>
                        <div><b>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><p class="text-xs text-slate-500 mt-2">Hadir</p></div>
                        <div><b>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</b><p class="text-xs text-slate-500 mt-2">Ragu</p></div>
                    </div>

                    <div class="rj-message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="rj-message-card">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color: var(--rj-primary);">{{ $message->guest_name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="rj-message-card text-center">
                                <p class="text-slate-500">Belum ada pesan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="rj-section compact text-center">
                <div class="rj-closing-card">
                    @if ($closingPhoto)
                        <img src="{{ $closingPhoto }}" alt="{{ $eventTitle }}" class="rj-closing-photo">
                    @else
                        <img src="{{ asset('assets/royal-javanese/joglo.png') }}" alt="" class="rj-closing-photo" onerror="this.style.display='none'">
                    @endif

                    <p class="rj-label">Terima Kasih</p>

                    <h2 class="rj-title rj-script text-5xl md:text-7xl mt-6 responsive-text">
                        {{ $firstName }} & {{ $secondName }}
                    </h2>

                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color:#6a5545;">
                        Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.
                    </p>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');

            if (countdownContainer) {
                const targetDate = new Date(countdownContainer.getAttribute('data-countdown-target'));
                const daysEl = document.getElementById('countdown-days');
                const hoursEl = document.getElementById('countdown-hours');
                const minutesEl = document.getElementById('countdown-minutes');
                const secondsEl = document.getElementById('countdown-seconds');

                function pad(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    if (isNaN(targetDate.getTime())) return;

                    let distance = targetDate.getTime() - new Date().getTime();

                    if (distance < 0) {
                        distance = 0;
                    }

                    const totalSeconds = Math.floor(distance / 1000);
                    const days = Math.floor(totalSeconds / (60 * 60 * 24));
                    const hours = Math.floor((totalSeconds % (60 * 60 * 24)) / (60 * 60));
                    const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
                    const seconds = Math.floor(totalSeconds % 60);

                    if (daysEl) daysEl.textContent = pad(days);
                    if (hoursEl) hoursEl.textContent = pad(hours);
                    if (minutesEl) minutesEl.textContent = pad(minutes);
                    if (secondsEl) secondsEl.textContent = pad(seconds);
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
            const scrollSpeed = 1.15;

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

            document.querySelectorAll('[data-copy]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const text = this.getAttribute('data-copy');

                    try {
                        await navigator.clipboard.writeText(text);
                        const original = this.textContent;
                        this.textContent = 'Berhasil Disalin';
                        setTimeout(() => {
                            this.textContent = original;
                        }, 1800);
                    } catch (error) {
                        alert('Gagal menyalin teks.');
                    }
                });
            });

            /* =====================================================
            SCROLL REVEAL ANIMATION - ROYAL JAVANESE
            ===================================================== */

            const revealElements = document.querySelectorAll(`
                .rj-label,
                .rj-title,
                .rj-arch-panel,
                .rj-gunungan-img,
                .rj-person,
                .rj-detail-panel,
                .rj-count-card,
                .rj-map-card,
                .rj-gallery-item,
                .rj-card,
                .rj-message-card,
                .rj-closing-card
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 38, 320) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('rj-show');
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

            /* =====================================================
            ANTI INSPECT RINGAN TANPA NOTICE
            Aktif di public preview dan preview editor iframe
            ===================================================== */

            /* Blok klik kanan */
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            /* Blok select text kecuali input/form RSVP */
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
