<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Modern Couple'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--mc-ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(180deg, var(--mc-night), var(--mc-teal) 45%, var(--mc-lavender));
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }

        input,
        textarea,
        select {
            -webkit-user-select: text;
            user-select: text;
        }

        img,
        a,
        button {
            -webkit-user-drag: none;
            user-drag: none;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .mc-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .mc-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid rgba(255, 255, 255, .18);
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .05)),
                url("{{ asset('assets/modern-couple/mc-paper-texture.png') }}") center / cover repeat,
                var(--mc-cream);
            box-shadow: 0 44px 130px rgba(18, 30, 47, .28);
        }

        .mc-book::before,
        .mc-book::after,
        .mc-page::before,
        .mc-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .mc-book::before {
            z-index: 0;
            opacity: .42;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 820px auto repeat,
                linear-gradient(90deg, rgba(255, 255, 255, .035) 1px, transparent 1px) 0 0 / 46px 46px,
                linear-gradient(0deg, rgba(255, 255, 255, .03) 1px, transparent 1px) 0 0 / 46px 46px;
        }

        .mc-book::after {
            z-index: 0;
            opacity: .36;
            background:
                radial-gradient(circle at 18% 18%, color-mix(in srgb, var(--mc-gold) 22%, transparent), transparent 26%),
                radial-gradient(circle at 82% 28%, color-mix(in srgb, var(--mc-pink) 20%, transparent), transparent 28%);
        }

        .mc-book > * {
            position: relative;
            z-index: 2;
        }

        .mc-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            transform: translateY(-50%);
            border-radius: 18px 0 0 18px;
            background: rgba(255, 255, 255, .74);
            border: 1px solid rgba(40, 58, 83, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(18, 30, 47, .14);
            backdrop-filter: blur(14px);
        }

        .mc-floating-actions a,
        .mc-floating-actions button {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 16px 0 0 16px;
            cursor: pointer;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 10px 22px rgba(18, 30, 47, .12);
            transition: transform .25s ease, background .25s ease;
            animation: mcFloat 4.4s ease-in-out infinite;
        }

        .mc-floating-actions a:hover,
        .mc-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .mc-floating-actions button.is-active {
            background: color-mix(in srgb, var(--mc-gold) 38%, white);
        }

        .mc-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .mc-page {
            position: relative;
            min-height: auto;
            overflow: hidden;
            padding: 104px 72px;
            text-align: center;
            isolation: isolate;
        }

        .mc-page.slim {
            padding-top: 84px;
            padding-bottom: 84px;
        }

        .mc-page > * {
            position: relative;
            z-index: 6;
        }

        .mc-page::after {
            z-index: 2;
            opacity: .12;
            background: radial-gradient(circle at 50% 34%, rgba(255, 255, 255, .52), rgba(255, 255, 255, .18) 46%, transparent 72%);
        }

        .mc-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--mc-deep);
            background: rgba(255, 255, 255, .74);
            border: 1px solid rgba(255, 255, 255, .32);
            box-shadow: 0 12px 28px rgba(18, 30, 47, .08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .mc-label::before,
        .mc-label::after {
            content: "";
            width: 28px;
            height: 1px;
            background: var(--mc-deep);
            opacity: .46;
        }

        .mc-title {
            margin: 0;
            color: var(--mc-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .02em;
            line-height: .96;
            text-wrap: balance;
        }

        .mc-script {
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
        }

        .mc-note {
            max-width: 700px;
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--mc-ink) 84%, transparent);
            line-height: 1.9;
        }

        .mc-btn {
            position: relative;
            overflow: hidden;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border: 0;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            color: #fffdf1;
            background: linear-gradient(135deg, var(--mc-deep), var(--mc-night));
            box-shadow: 0 16px 34px rgba(18, 30, 47, .22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease;
        }

        .mc-btn:hover {
            transform: translateY(-2px);
        }

        .mc-btn.light {
            color: var(--mc-deep);
            background: rgba(255, 255, 255, .84);
            border: 1px solid rgba(40, 58, 83, .15);
        }

        .mc-btn.gold,
        .mc-copy-btn {
            color: #31301d;
            background: linear-gradient(135deg, #dfc45b, #fff1a8);
        }

        .mc-btn::after,
        .mc-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .55), transparent);
            animation: mcShine 4.2s ease-in-out infinite;
        }

        /* Hero */
        .mc-hero {
            position: relative;
            min-height: 100vh;
            display: grid;
            place-items: center;
            overflow: hidden;
            padding: 80px 24px;
            text-align: center;
            color: #f8f6e8;
            background:
                linear-gradient(180deg, rgba(18, 55, 85, .54), rgba(65, 88, 105, .34) 34%, rgba(222, 150, 70, .14) 54%, rgba(26, 132, 132, .42)),
                url("{{ asset('assets/modern-couple/mc-sky-night-gradient.png') }}") center top / cover no-repeat,
                var(--mc-night);
        }

        .mc-hero::before {
            z-index: 1;
            opacity: .98;
            background:
                url("{{ asset('assets/modern-couple/mc-palace-tower.png') }}") center 25% / 280px auto no-repeat,
                url("{{ asset('assets/modern-couple/mc-palace-facade.png') }}") center 56% / 108% auto no-repeat,
                url("{{ asset('assets/modern-couple/mc-fountain.png') }}") center 67% / 118px auto no-repeat;
        }

        .mc-hero::after {
            z-index: 4;
            opacity: 1;
            background:
                radial-gradient(circle at 50% 34%, rgba(9, 17, 32, .12), transparent 36%),
                linear-gradient(180deg, rgba(12, 22, 40, .20) 0%, rgba(12, 22, 40, .28) 44%, rgba(12, 22, 40, .18) 100%);
        }

        .mc-hero-pattern {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .34;
            background: url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 760px auto repeat;
            mix-blend-mode: soft-light;
        }

        .mc-lantern-layer {
            position: absolute;
            inset: -4% -3%;
            z-index: 3;
            pointer-events: none;
            opacity: .72;
            background: url("{{ asset('assets/modern-couple/mc-floating-lanterns.png') }}") center top / 105% auto no-repeat;
            animation: mcLanternFloat 7.5s ease-in-out infinite;
            transform-origin: center top;
            will-change: transform, opacity;
        }

        .mc-hero-inner {
            position: relative;
            z-index: 6;
            width: min(100%, 760px);
            min-height: min(76vh, 680px);
            margin: 0 auto;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .mc-hero-inner::before,
        .mc-closing-card::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: -1;
            width: min(92vw, 760px);
            height: 58%;
            transform: translate(-50%, -50%);
            border-radius: 999px;
            background: radial-gradient(circle, rgba(9, 17, 32, .34) 0%, rgba(9, 17, 32, .18) 44%, transparent 74%);
            filter: blur(2px);
            pointer-events: none;
        }

        .mc-hero-kicker {
            margin: 0 0 16px;
            color: #fffaf0;
            font-size: 13px;
            font-weight: 950;
            letter-spacing: .24em;
            text-transform: uppercase;
            text-shadow: 0 2px 10px rgba(0, 0, 0, .42);
        }

        .mc-hero-title {
            margin: 0;
            color: #fff8e8;
            -webkit-text-fill-color: #fff8e8;
            font-size: clamp(3rem, 7vw, 6rem);
            line-height: .96;
            font-weight: 650;
            letter-spacing: .035em;
            text-align: center;
            text-transform: uppercase;
            text-shadow:
                0 2px 0 rgba(0, 0, 0, .20),
                0 8px 28px rgba(0, 0, 0, .44),
                0 0 18px rgba(255, 232, 162, .20);
        }

        .mc-hero-and {
            display: block;
            margin: 9px 0;
            color: #f7d778;
            -webkit-text-fill-color: #f7d778;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: .9;
            text-transform: none;
            text-shadow: 0 6px 18px rgba(0, 0, 0, .34);
        }

        .mc-hero-date {
            margin-top: 22px;
            color: #fff6df;
            font-size: 1rem;
            font-weight: 850;
            letter-spacing: .24em;
            text-shadow: 0 2px 10px rgba(0, 0, 0, .40);
        }

        .mc-hero-actions {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* Lampion dekoratif dari 1 objek */
        .mc-has-lanterns {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .mc-section-lanterns {
            position: absolute;
            inset: 0;
            z-index: 3;
            overflow: hidden;
            pointer-events: none;
        }

        .mc-section-lantern {
            position: absolute;
            left: var(--x, 50%);
            bottom: -140px;
            width: var(--size, 72px);
            height: auto;
            opacity: var(--op, .65);
            filter: blur(var(--blur, 0px)) drop-shadow(0 10px 18px rgba(255, 193, 77, .28));
            transform: translateX(-50%) rotate(var(--rot, 0deg));
            transform-origin: center center;
            will-change: transform, opacity, margin-left;
            animation:
                mcLanternRise var(--dur, 20s) linear infinite,
                mcLanternSway calc(var(--dur, 20s) * .30) ease-in-out infinite;
            animation-delay: var(--delay, 0s), var(--delay, 0s);
        }

        .mc-section-lantern.is-1 { --x: 5%; --size: 78px; --dur: 17s; --delay: -2s; --rot: -8deg; --op: .72; --blur: 0px; }
        .mc-section-lantern.is-2 { --x: 14%; --size: 56px; --dur: 21s; --delay: -8s; --rot: 7deg; --op: .52; --blur: 1px; }
        .mc-section-lantern.is-3 { --x: 26%; --size: 88px; --dur: 19s; --delay: -5s; --rot: -11deg; --op: .62; --blur: 0px; }
        .mc-section-lantern.is-4 { --x: 40%; --size: 62px; --dur: 24s; --delay: -11s; --rot: 10deg; --op: .40; --blur: 1px; }
        .mc-section-lantern.is-5 { --x: 56%; --size: 98px; --dur: 18s; --delay: -4s; --rot: -6deg; --op: .66; --blur: 0px; }
        .mc-section-lantern.is-6 { --x: 68%; --size: 52px; --dur: 23s; --delay: -9s; --rot: 9deg; --op: .46; --blur: 1px; }
        .mc-section-lantern.is-7 { --x: 80%; --size: 74px; --dur: 20s; --delay: -6s; --rot: -12deg; --op: .58; --blur: 0px; }
        .mc-section-lantern.is-8 { --x: 91%; --size: 60px; --dur: 26s; --delay: -13s; --rot: 8deg; --op: .42; --blur: 1px; }

        .mc-section-lantern:nth-child(2n) {
            animation-name: mcLanternRiseAlt, mcLanternSwayAlt;
        }

        .mc-section-lantern:nth-child(3n) {
            filter: blur(var(--blur, 1px)) drop-shadow(0 14px 24px rgba(255, 204, 102, .22));
        }

        /* Section warna */

        .mc-invitation-card {
            width: min(100%, 790px);
            margin: 0 auto;
            padding: 60px 46px;
            border-radius: 42px;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .22);
            box-shadow: 0 28px 84px rgba(17, 70, 78, .20);
            backdrop-filter: blur(8px);
        }

        .mc-invitation-card h2 {
            font-size: clamp(3rem, 6vw, 6.2rem);
        }

        /* =====================================================
        ROMBAK SAVE THE DATE - MODERN COUPLE LUXURY
        ===================================================== */

        .mc-save-date {
            position: relative;
            min-height: 820px;
            padding: 110px 72px 120px;
            display: grid;
            place-items: center;
            overflow: hidden;
            color: #fffdf1;
            background:
                radial-gradient(circle at 18% 16%, rgba(255, 236, 170, .30), transparent 28%),
                radial-gradient(circle at 86% 22%, rgba(255, 255, 255, .24), transparent 30%),
                linear-gradient(145deg,
                    color-mix(in srgb, var(--mc-teal) 88%, white) 0%,
                    color-mix(in srgb, var(--mc-sky) 76%, white) 42%,
                    color-mix(in srgb, var(--mc-lavender) 78%, white) 100%
                );
        }

        .mc-save-date::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .42;
            background:
                url('{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}') center / 760px auto repeat,
                url('{{ asset('assets/modern-couple/mc-gold-haze.png') }}') center / cover no-repeat;
            mix-blend-mode: soft-light;
        }

        .mc-save-date .mc-palace-silhouette {
            position: absolute;
            left: 50%;
            bottom: -8px; /* lebih mepet ke bawah */
            transform: translateX(-50%);
            width: 128%; /* lebih mepet kiri-kanan */
            max-width: none;
            height: auto;
            z-index: 3;
            opacity: .34;
            pointer-events: none;
        }

        .mc-save-date::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .34;
            background:
                radial-gradient(circle at 50% 0%, rgba(255, 255, 255, .35), transparent 32%),
                linear-gradient(180deg, transparent 0%, rgba(255, 255, 255, .18) 100%);
        }

        .mc-count-panel {
            position: relative;
            z-index: 6;
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 58px 42px 54px;
            border-radius: 46px;
            overflow: hidden;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.34), rgba(255,255,255,.16));
            border: 1px solid rgba(255,255,255,.48);
            box-shadow:
                0 34px 90px rgba(18, 30, 47, .18),
                inset 0 1px 0 rgba(255,255,255,.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .mc-count-panel::before {
            content: "";
            position: absolute;
            inset: -45%;
            z-index: 0;
            opacity: .68;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.60), transparent 28%),
                radial-gradient(circle at 82% 86%, color-mix(in srgb, var(--mc-gold) 36%, transparent), transparent 34%),
                radial-gradient(circle at 10% 86%, rgba(255,255,255,.24), transparent 32%);
        }

        .mc-count-panel > * {
            position: relative;
            z-index: 2;
        }

        .mc-save-date .mc-label {
            color: var(--mc-deep);
            background: rgba(255,255,255,.84);
        }

        .mc-count-title {
            margin: 0;
            color: #fffdf1;
            font-size: clamp(3rem, 6vw, 5.8rem);
            line-height: 1;
            text-shadow:
                0 10px 26px rgba(18, 30, 47, .16),
                0 0 24px rgba(255, 255, 255, .16);
        }

        .mc-count-grid {
            width: min(100%, 620px);
            margin: 40px auto 0;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .mc-count-card {
            position: relative;
            overflow: hidden;
            min-height: 138px;
            padding: 28px 12px 22px;
            border-radius: 30px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,248,225,.78));
            border: 1px solid rgba(255,255,255,.78);
            box-shadow:
                0 18px 40px rgba(18, 30, 47, .10),
                inset 0 1px 0 rgba(255,255,255,.96);
        }

        .mc-count-card::after {
            content: "";
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 12px;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, var(--mc-gold), transparent);
            opacity: .85;
        }

        .mc-count-number {
            display: block;
            color: var(--mc-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.3rem, 5vw, 4.4rem);
            line-height: 1;
            font-weight: 800;
        }

        .mc-count-label {
            display: block;
            margin-top: 10px;
            color: #4f5d6b;
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .mc-count-actions {
            margin-top: 36px;
        }


        /* =====================================================
        ROMBAK BRIDE & GROOM - MODERN COUPLE LUXURY
        ===================================================== */

        /* ===================== BRIDE & GROOM / COUPLE ===================== */

        .mc-couple {
            position: relative;
            overflow: hidden;
            color: #fffdf1;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(
                    180deg,
                    color-mix(in srgb, var(--mc-lavender) 92%, white) 0%,
                    color-mix(in srgb, var(--mc-sky) 84%, white) 48%,
                    color-mix(in srgb, var(--mc-teal) 82%, white) 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .mc-couple::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .34;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 720px auto repeat;
            mix-blend-mode: soft-light;
        }

        .mc-couple::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .18;
            background:
                radial-gradient(circle at 18% 18%, rgba(255, 237, 170, .30), transparent 28%),
                radial-gradient(circle at 82% 18%, rgba(255, 255, 255, .32), transparent 30%),
                linear-gradient(180deg, rgba(255,255,255,.10), transparent 48%, rgba(255,255,255,.12));
        }

        .mc-couple > * {
            position: relative;
            z-index: 6;
        }

        .mc-couple .mc-label {
            color: var(--mc-deep);
            background: rgba(255,255,255,.86);
        }

        .mc-couple .mc-title {
            color: #fffdf1;
            text-shadow: 0 10px 28px rgba(18, 30, 47, .16);
        }

        .mc-couple .mc-note {
            color: rgba(255,255,255,.86);
            font-weight: 600;
        }

        .mc-couple-stage {
            position: relative;
            width: min(100%, 1040px);
            margin: 58px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 34px;
            align-items: stretch;
        }

        .mc-couple-and {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 30;
            transform: translate(-50%, -50%);
            width: 74px;
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #f2d36b;
            background: rgba(255, 255, 255, .68);
            border: 1px solid rgba(255, 255, 255, .72);
            box-shadow:
                0 16px 38px rgba(18, 30, 47, .16),
                inset 0 1px 0 rgba(255, 255, 255, .82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 52px;
            line-height: 1;
            font-weight: 500;
            text-shadow: 0 3px 12px rgba(18, 30, 47, .12);
            pointer-events: none;
        }

        .mc-person-card {
            position: relative;
            min-height: 580px;
            padding: 38px 30px 36px;
            border-radius: 42px;
            overflow: hidden;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.36), rgba(255,255,255,.14));
            border: 1px solid rgba(255,255,255,.48);
            box-shadow:
                0 30px 84px rgba(18, 30, 47, .16),
                inset 0 1px 0 rgba(255,255,255,.58);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .mc-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            opacity: .52;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.55), transparent 30%),
                radial-gradient(circle at 90% 84%, color-mix(in srgb, var(--mc-gold) 25%, transparent), transparent 36%);
        }

        .mc-person-card::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 26px;
            width: 128px;
            height: 2px;
            transform: translateX(-50%);
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, var(--mc-gold), transparent);
            opacity: .9;
        }

        .mc-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: min(100%, 238px);
            margin: 0 auto;
            padding: 9px;
            border-radius: 32px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,248,226,.82));
            box-shadow:
                0 22px 54px rgba(18, 30, 47, .16),
                0 0 0 1px rgba(255,255,255,.76);
        }

        .mc-person-photo-wrap img,
        .mc-person-initial {
            width: 100%;
            aspect-ratio: 4 / 5;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 24px;
            background: color-mix(in srgb, var(--mc-gold) 16%, #fff);
            color: var(--mc-deep);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .mc-person-content {
            position: relative;
            z-index: 2;
            margin-top: 30px;
        }

        .mc-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 16px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--mc-deep);
            background: rgba(255,255,255,.86);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .20em;
            text-transform: uppercase;
        }

        .mc-person-name {
            margin: 0;
            color: #fffdf1;
            font-family: Georgia, serif;
            font-size: clamp(2.35rem, 4.5vw, 4.1rem);
            line-height: 1.04;
            text-shadow: 0 10px 24px rgba(18, 30, 47, .18);
        }

        .mc-person-family {
            max-width: 380px;
            margin: 18px auto 0;
            color: rgba(255,255,255,.86);
            line-height: 1.8;
            font-weight: 650;
        }

        /* Event */
        .mc-event-layout {
            width: min(100%, 1040px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: minmax(0, .96fr) minmax(340px, 1.04fr);
            gap: 34px;
            align-items: stretch;
        }

        .mc-event-layout.is-single {
            grid-template-columns: minmax(0, 760px);
            justify-content: center;
        }

        .mc-event-card,
        .mc-map-card {
            overflow: hidden;
            border-radius: 40px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .88), rgba(255, 249, 230, .62));
            border: 1px solid rgba(40, 58, 83, .13);
            box-shadow: 0 28px 82px rgba(18, 30, 47, .10);
        }

        .mc-event-card {
            position: relative;
            padding: 58px 38px 50px;
            text-align: center;
        }

        .mc-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .28;
            background:
                url("{{ asset('assets/modern-couple/mc-palace-facade.png') }}") center bottom / 120% auto no-repeat,
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 740px auto repeat;
        }

        .mc-event-card > * {
            position: relative;
            z-index: 2;
        }

        .mc-event-card h3 {
            max-width: 440px;
            margin: 0 auto;
            color: var(--mc-deep);
            font-size: clamp(2.2rem, 4.2vw, 4.2rem);
        }

        .mc-date-split {
            width: min(100%, 520px);
            margin: 32px auto 24px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 22px;
            align-items: center;
        }

        .mc-date-side {
            color: #58616e;
            font-family: Georgia, serif;
            font-size: 1.08rem;
        }

        .mc-date-center {
            padding: 0 26px;
            border-left: 1px solid rgba(40, 58, 83, .25);
            border-right: 1px solid rgba(40, 58, 83, .25);
        }

        .mc-date-center b {
            display: block;
            color: var(--mc-deep);
            font-family: Georgia, serif;
            font-size: clamp(3rem, 6vw, 5.2rem);
            line-height: .9;
        }

        .mc-date-center span {
            display: block;
            margin-top: 10px;
            color: #58616e;
            font-weight: 700;
        }

        .mc-date-end-label {
            margin: 16px 0 10px;
            color: var(--mc-deep);
            font-size: .9rem;
            font-weight: 850;
            letter-spacing: .08em;
            text-transform: uppercase;
            opacity: .82;
        }

        .mc-date-split-end {
            margin-top: 0;
        }

        .mc-event-line {
            margin-top: 20px;
            color: #4c5664;
            line-height: 1.85;
            font-weight: 750;
        }

        .mc-event-place {
            margin-top: 30px;
            color: #263242;
            font-weight: 950;
        }

        .mc-event-address {
            width: min(100%, 560px);
            margin: 10px auto 0;
            color: #58616e;
            line-height: 1.75;
        }

        .mc-event-actions {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .mc-map-card {
            min-height: 520px;
            display: flex;
            flex-direction: column;
        }

        .mc-map-frame,
        .mc-map-placeholder {
            width: 100%;
            height: 420px;
            min-height: 420px;
            border: 0;
            display: block;
        }

        .mc-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            background: #eef6f2;
        }

        .mc-map-pin {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: var(--mc-deep);
            color: #fff;
            font-size: 2rem;
        }

        .mc-map-footer {
            padding: 22px 26px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            text-align: left;
            background: rgba(255, 255, 255, .84);
            border-top: 1px solid rgba(40, 58, 83, .12);
        }

        .mc-map-title {
            margin: 0;
            color: #263242;
            font-weight: 950;
        }

        .mc-map-address {
            margin: 7px 0 0;
            color: #58616e;
            line-height: 1.65;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* Gallery, gift, RSVP */
        .mc-gallery-grid {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 110px;
            gap: 12px;
        }

        .mc-gallery-item {
            display: block;
            overflow: hidden;
            padding: 6px;
            border-radius: 28px;
            background: rgba(255, 255, 255, .86);
            box-shadow: 0 14px 34px rgba(18, 30, 47, .08);
        }

        .mc-gallery-item:nth-child(1) {
            grid-column: span 5;
            grid-row: span 4;
        }

        .mc-gallery-item:nth-child(2) {
            grid-column: span 4;
            grid-row: span 2;
        }

        .mc-gallery-item:nth-child(3) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .mc-gallery-item:nth-child(n+4) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .mc-gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            border-radius: 22px;
        }

        .mc-gift-grid {
            width: min(100%, 920px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .mc-gift-grid.is-single {
            grid-template-columns: minmax(0, 450px);
            justify-content: center;
        }

        .mc-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 34px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255, 255, 255, .88), rgba(255, 249, 230, .68));
            box-shadow: 0 18px 48px rgba(18, 30, 47, .08);
        }

        .mc-gift-card::before {
            content: "";
            position: absolute;
            inset: auto -20px -65px -20px;
            height: 140px;
            background: color-mix(in srgb, var(--mc-gold) 22%, transparent);
            transform: skewY(-7deg);
        }

        .mc-gift-title,
        .mc-gift-number,
        .mc-copy-btn {
            position: relative;
            z-index: 2;
        }

        .mc-gift-title {
            color: var(--mc-deep);
            font-weight: 950;
            font-size: 1.25rem;
        }

        .mc-gift-number {
            margin-top: 18px;
            color: #263242;
            font-weight: 950;
            font-size: clamp(1.5rem, 4vw, 2.4rem);
        }

        .mc-copy-btn {
            overflow: hidden;
            margin-top: 18px;
            padding: 12px 18px;
            border: 0;
            border-radius: 999px;
            font-weight: 950;
            cursor: pointer;
        }

        .mc-copy-btn.copied {
            background: #16803c;
            color: #fff;
        }

        .mc-rsvp-layout {
            width: min(100%, 1080px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(280px, .84fr) minmax(420px, 1.16fr);
            gap: 34px;
            align-items: start;
            text-align: left;
        }

        .mc-rsvp-copy {
            padding: 42px 34px;
            border-radius: 40px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .82), rgba(255, 249, 230, .60));
            box-shadow: 0 18px 48px rgba(18, 30, 47, .08);
        }

        .mc-rsvp-copy h3 {
            font-size: clamp(2rem, 3.3vw, 3.4rem);
        }

        .mc-form-card {
            padding: 26px;
            border-radius: 28px;
            text-align: left;
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 18px 48px rgba(18, 30, 47, .08);
        }

        .mc-form-label {
            display: block;
            color: var(--mc-deep);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
            text-align: left;
        }

        .mc-input {
            width: 100%;
            margin-top: 8px;
            padding: 13px 14px;
            border: 1px solid rgba(40, 58, 83, .14);
            border-radius: 14px;
            outline: none;
            background: rgba(255, 255, 255, .94);
            color: var(--mc-ink);
            text-align: left;
        }

        .mc-summary-grid {
            grid-column: 1 / -1;
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .mc-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 22px;
            background: rgba(255, 255, 255, .76);
        }

        .mc-summary-grid b {
            display: block;
            color: var(--mc-deep);
            font-size: 2rem;
        }

        .mc-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }

        .mc-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .82);
            box-shadow: 0 10px 24px rgba(18, 30, 47, .06);
        }

        /* Closing */
        .mc-closing-card {
            position: relative;
            z-index: 6;
            width: min(100%, 820px);
            min-height: min(78vh, 700px);
            margin: 0 auto;
            padding: 42px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .mc-closing-photo {
            width: min(210px, 58vw);
            height: auto;
            aspect-ratio: 4 / 5;
            margin: 0 auto 22px;
            object-fit: cover;
            border-radius: 28px;
            border: 8px solid rgba(255, 255, 255, .96);
            box-shadow: 0 22px 58px rgba(0, 0, 0, .26);
        }

        .mc-closing-card .mc-note:first-of-type {
            margin: 0 0 14px;
            color: #f7d778;
            font-weight: 800;
            letter-spacing: .04em;
            text-shadow: 0 2px 12px rgba(0, 0, 0, .45);
        }

        .mc-closing-card h2 {
            margin: 0;
            color: #fff8e8;
            -webkit-text-fill-color: #fff8e8;
            font-size: clamp(2.8rem, 6vw, 5.6rem);
            line-height: 1;
            text-shadow:
                0 2px 0 rgba(0, 0, 0, .18),
                0 8px 28px rgba(0, 0, 0, .42);
        }

        .mc-closing-card p {
            max-width: 760px;
            color: rgba(255, 248, 232, .96);
            line-height: 1.9;
            text-shadow: 0 2px 12px rgba(0, 0, 0, .42);
        }

        /* Reveal */
        [data-reveal] {
            opacity: 0;
            transform: translateY(34px);
            filter: blur(7px);
            transition: opacity .85s cubic-bezier(.2, .8, .2, 1), transform .85s cubic-bezier(.2, .8, .2, 1), filter .85s cubic-bezier(.2, .8, .2, 1);
            transition-delay: var(--reveal-delay, 0s);
        }

        [data-reveal="left"] {
            transform: translateX(-34px);
        }

        [data-reveal="right"] {
            transform: translateX(34px);
        }

        [data-reveal="zoom"] {
            transform: translateY(20px) scale(.94);
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0, 0) scale(1);
            filter: blur(0);
        }

        @keyframes mcShine {
            0%, 48% { left: -90%; }
            75%, 100% { left: 135%; }
        }

        @keyframes mcFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes mcLanternFloat {
            0%, 100% { transform: translateY(0) scale(1); opacity: .90; }
            25% { transform: translateY(-8px) scale(1.012); opacity: .96; }
            50% { transform: translateY(-16px) scale(1.018); opacity: 1; }
            75% { transform: translateY(-8px) scale(1.012); opacity: .96; }
        }

        @keyframes mcCarFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes mcLanternRise {
            0% {
                transform: translate(-50%, 0) rotate(var(--rot, 0deg)) scale(1);
                opacity: 0;
            }
            8% {
                opacity: var(--op, .65);
            }
            40% {
                transform: translate(calc(-50% - 10px), -34vh) rotate(calc(var(--rot, 0deg) - 4deg)) scale(1.03);
            }
            75% {
                transform: translate(calc(-50% + 12px), -76vh) rotate(calc(var(--rot, 0deg) + 5deg)) scale(.96);
                opacity: calc(var(--op, .65) * .9);
            }
            100% {
                transform: translate(calc(-50% - 6px), -118vh) rotate(calc(var(--rot, 0deg) - 2deg)) scale(.92);
                opacity: 0;
            }
        }

        @keyframes mcLanternRiseAlt {
            0% {
                transform: translate(-50%, 0) rotate(var(--rot, 0deg)) scale(.98);
                opacity: 0;
            }
            10% {
                opacity: var(--op, .65);
            }
            35% {
                transform: translate(calc(-50% + 14px), -30vh) rotate(calc(var(--rot, 0deg) + 6deg)) scale(1.02);
            }
            72% {
                transform: translate(calc(-50% - 16px), -78vh) rotate(calc(var(--rot, 0deg) - 5deg)) scale(.95);
                opacity: calc(var(--op, .65) * .92);
            }
            100% {
                transform: translate(calc(-50% + 8px), -118vh) rotate(calc(var(--rot, 0deg) + 2deg)) scale(.9);
                opacity: 0;
            }
        }

        @keyframes mcLanternSway {
            0%, 100% { margin-left: 0; }
            25% { margin-left: -8px; }
            50% { margin-left: 10px; }
            75% { margin-left: -6px; }
        }

        @keyframes mcLanternSwayAlt {
            0%, 100% { margin-left: 0; }
            20% { margin-left: 9px; }
            55% { margin-left: -12px; }
            80% { margin-left: 7px; }
        }

        @media (max-width: 980px) {
            .mc-shell {
                padding: 14px;
            }

            .mc-page {
                padding: 90px 38px;
            }

            .mc-hero::before {
                background:
                    url("{{ asset('assets/modern-couple/mc-palace-tower.png') }}") center 25% / 230px auto no-repeat,
                    url("{{ asset('assets/modern-couple/mc-palace-facade.png') }}") center 58% / 150% auto no-repeat,
                    url("{{ asset('assets/modern-couple/mc-fountain.png') }}") center 68% / 90px auto no-repeat;
            }

            .mc-lantern-layer {
                inset: -3% -14%;
                background-size: 145% auto;
            }

            .mc-couple-stage,
            .mc-event-layout,
            .mc-rsvp-layout {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .mc-gift-grid {
                grid-template-columns: 1fr;
            }

            .mc-gallery-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .mc-gallery-item:nth-child(1) {
                grid-column: span 3;
                grid-row: span 3;
            }

            .mc-gallery-item:nth-child(2) {
                grid-column: span 3;
                grid-row: span 2;
            }

            .mc-gallery-item:nth-child(n+3) {
                grid-column: span 2;
                grid-row: span 2;
            }
        }

        @media (max-width: 640px) {
            .mc-shell {
                padding: 0;
            }

            .mc-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .mc-page,
            .mc-page.slim {
                padding: 76px 22px;
            }

            .mc-floating-actions a,
            .mc-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .mc-hero {
                min-height: 100svh;
                padding: 56px 22px;
            }

            .mc-hero::before {
                background:
                    url("{{ asset('assets/modern-couple/mc-palace-tower.png') }}") center 21% / 185px auto no-repeat,
                    url("{{ asset('assets/modern-couple/mc-palace-facade.png') }}") center 60% / 205% auto no-repeat,
                    url("{{ asset('assets/modern-couple/mc-fountain.png') }}") center 69% / 70px auto no-repeat;
            }

            .mc-lantern-layer {
                inset: -2% -28%;
                opacity: .64;
                background-size: 190% auto;
                animation-duration: 8.8s;
            }

            .mc-hero-inner,
            .mc-closing-card {
                min-height: 78svh;
            }

            .mc-hero-title {
                font-size: clamp(2.4rem, 10vw, 4.2rem);
            }

            .mc-hero-actions,
            .mc-event-actions {
                width: 100%;
                flex-direction: column;
            }

            .mc-btn,
            .mc-hero-actions .mc-btn {
                width: min(100%, 280px);
            }

            .mc-save-date {
                min-height: 760px;
                padding: 80px 22px 100px;
            }

            .mc-count-panel {
                padding: 44px 20px;
                border-radius: 32px;
            }

            .mc-count-car {
                width: min(210px, 76%);
                margin-bottom: 18px;
            }

            .mc-count-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .mc-person-card {
                min-height: auto;
                padding: 36px 20px;
            }

            .mc-person-photo-wrap {
                width: 200px;
            }

            .mc-date-split {
                grid-template-columns: 1fr;
            }

            .mc-date-center {
                padding: 18px 0;
                border-left: 0;
                border-right: 0;
                border-top: 1px solid rgba(40, 58, 83, .25);
                border-bottom: 1px solid rgba(40, 58, 83, .25);
            }

            .mc-map-frame,
            .mc-map-placeholder {
                height: 320px;
                min-height: 320px;
            }

            .mc-map-footer {
                flex-direction: column;
            }

            .mc-gallery-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .mc-gallery-item,
            .mc-gallery-item:nth-child(n) {
                grid-column: auto;
                grid-row: auto;
                height: 270px;
            }

            .mc-rsvp-layout {
                gap: 22px;
            }

            .mc-rsvp-copy,
            .mc-form-card {
                padding: 26px 20px;
                border-radius: 28px;
            }

            .mc-summary-grid {
                grid-template-columns: 1fr;
            }

            .mc-section-lantern {
                width: calc(var(--size, 72px) * .78);
                opacity: calc(var(--op, .65) * .88);
            }

            .mc-save-date {
                min-height: auto;
                padding: 84px 20px 96px;
            }

            .mc-count-panel {
                width: min(100%, 390px);
                padding: 42px 18px 40px;
                border-radius: 34px;
            }

            .mc-count-title {
                font-size: clamp(2.4rem, 12vw, 3.7rem);
            }

            .mc-count-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .mc-count-card {
                min-height: 118px;
                padding: 22px 10px 20px;
                border-radius: 24px;
            }

            .mc-couple {
                padding: 86px 18px 96px;
            }

            .mc-couple-stage {
                grid-template-columns: 1fr;
                gap: 26px;
                margin-top: 40px;
            }

            .mc-person-card {
                min-height: auto;
                padding: 34px 18px 40px;
                border-radius: 32px;
            }

            .mc-person-card::before {
                background:
                    radial-gradient(circle at 50% 0%, rgba(255,255,255,.55), transparent 30%),
                    radial-gradient(circle at 90% 84%, color-mix(in srgb, var(--mc-gold) 25%, transparent), transparent 36%);
            }

            .mc-person-photo-wrap {
                width: min(100%, 210px);
            }

            .mc-person-name {
                font-size: clamp(2.2rem, 12vw, 3.5rem);
            }

            .mc-person-family {
                font-size: .92rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important;
            }

            [data-reveal] {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        /* =====================================================
        FIX JARAK NAMA HERO - Modern Couple
        Membuat Imran, &, Zara lebih rapat dan proporsional
        ===================================================== */

        .mc-hero-title {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0 !important;
            font-size: clamp(2.9rem, 6vw, 5.2rem) !important;
            line-height: .86 !important;
            letter-spacing: .035em !important;
        }

        .mc-hero-title > span {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: .86 !important;
        }

        .mc-hero-and {
            margin: 4px 0 8px !important;
            font-size: clamp(1.7rem, 3.4vw, 2.5rem) !important;
            line-height: .75 !important;
        }

        /* =====================================================
        FIX BUTTON CALENDAR DETAIL ACARA CENTER
        ===================================================== */

        .mc-event-actions {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
        }

        .mc-event-actions .mc-btn {
            margin-left: auto !important;
            margin-right: auto !important;
            text-align: center !important;
            justify-content: center !important;
        }

        /* Khusus mobile agar tombol tidak melebar aneh */
        @media (max-width: 640px) {
            .mc-event-actions {
                flex-direction: column !important;
                align-items: center !important;
            }

            .mc-event-actions .mc-btn {
                width: min(100%, 280px) !important;
                max-width: 280px !important;
            }
        }

        /* =====================================================
        ORNAMEN TAMBAHAN MODERN COUPLE
        ===================================================== */

        .mc-wave-divider {
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: auto;
            z-index: 4;
            pointer-events: none;
            opacity: .96;
        }

        /* Wave khusus section Invitation */
        .mc-invite > .mc-wave-divider {
            position: absolute;
            left: 50%;
            bottom: -72px;
            width: 118%;
            max-width: none;
            height: auto;
            transform: translateX(-50%);
            opacity: .96;
            z-index: 7;
            pointer-events: none;
        }

        .mc-gold-line-ornament {
            display: block;
            width: 170px;
            max-width: 52%;
            height: auto;
            margin: 14px auto;
            opacity: .95;
            pointer-events: none;
        }

        .mc-gold-line-ornament.is-top {
            margin-top: 0;
            margin-bottom: 18px;
        }

        .mc-gold-line-ornament.is-bottom {
            margin-top: 18px;
            margin-bottom: 0;
        }

        .mc-sparkle {
            position: absolute;
            width: var(--size, 18px);
            height: auto;
            opacity: var(--op, .75);
            pointer-events: none;
            z-index: 2;
            filter: drop-shadow(0 0 12px rgba(255, 235, 160, .35));
        }

        .mc-side-lantern {
            position: absolute;
            width: var(--size, 62px);
            height: auto;
            opacity: var(--op, .92);
            pointer-events: none;
            z-index: 3;
            filter: drop-shadow(0 10px 22px rgba(255, 196, 90, .24));
        }

        .mc-section-decor {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            overflow: hidden;
        }

        /* ===================== INVITATION ===================== */

        .mc-invite {
            position: relative;
            padding-top: 112px;
            padding-bottom: 210px;
            overflow: hidden;
            color: #fffdf1;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 560px auto repeat,
                linear-gradient(
                    180deg,
                    var(--mc-teal) 0%,
                    color-mix(in srgb, var(--mc-teal) 88%, var(--mc-sky)) 58%,
                    color-mix(in srgb, var(--mc-teal) 78%, white) 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .mc-invite::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .42;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 720px auto repeat;
            mix-blend-mode: soft-light;
        }

        .mc-invite::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .14;
            background:
                radial-gradient(circle at 50% 22%, rgba(255,255,255,.42), transparent 34%),
                linear-gradient(180deg, transparent 0%, rgba(255,255,255,.10) 100%);
        }

        .mc-invite > * {
            position: relative;
            z-index: 6;
        }

        .mc-invite .mc-title,
        .mc-invite .mc-label {
            color: #fffdf1;
        }

        .mc-invite .mc-note {
            color: rgba(255, 255, 255, .86);
        }
        /* ===================== SAVE THE DATE ===================== */

        .mc-save-date {
            position: relative;
            min-height: 860px;
            padding: 128px 72px 150px;
            background:
                linear-gradient(145deg,
                    color-mix(in srgb, var(--mc-teal) 78%, white) 0%,
                    color-mix(in srgb, var(--mc-sky) 82%, white) 40%,
                    color-mix(in srgb, var(--mc-lavender) 78%, white) 100%
                );
        }

        .mc-save-date::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: 1;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 760px auto repeat,
                url("{{ asset('assets/modern-couple/mc-gold-haze.png') }}") center / cover no-repeat;
            mix-blend-mode: soft-light;
        }

        .mc-save-date::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .24;
            background:
                radial-gradient(circle at 50% 8%, rgba(255,255,255,.36), transparent 30%),
                linear-gradient(180deg, transparent 0%, rgba(255,255,255,.14) 100%);
        }

        .mc-count-panel {
            position: relative;
            z-index: 6;
        }

        .mc-save-decor .mc-side-lantern.is-left-mid {
            left: 20px;
            top: 44%;
            --size: 74px;
            --op: .88;
        }

        .mc-save-decor .mc-side-lantern.is-right-mid {
            right: 16px;
            top: 46%;
            --size: 66px;
            --op: .88;
        }

        .mc-save-decor .mc-side-lantern.is-left-low {
            left: 28px;
            bottom: 126px;
            --size: 50px;
            --op: .74;
        }

        .mc-save-decor .mc-side-lantern.is-right-low {
            right: 34px;
            bottom: 104px;
            --size: 56px;
            --op: .76;
        }

        .mc-save-decor .mc-sparkle.s1 { left: 90px; top: 134px; --size: 18px; }
        .mc-save-decor .mc-sparkle.s2 { right: 84px; top: 154px; --size: 16px; }
        .mc-save-decor .mc-sparkle.s3 { left: 112px; bottom: 138px; --size: 20px; }
        .mc-save-decor .mc-sparkle.s4 { right: 120px; bottom: 170px; --size: 18px; }
        .mc-save-decor .mc-sparkle.s5 { left: 44%; top: 190px; --size: 14px; --op: .55; }
        .mc-save-decor .mc-sparkle.s6 { left: 56%; bottom: 118px; --size: 14px; --op: .55; }

        /* ===================== BRIDE & GROOM / COUPLE ===================== */

        .mc-couple {
            position: relative;
            overflow: hidden;
            color: #fffdf1;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(
                    180deg,
                    color-mix(in srgb, var(--mc-lavender) 92%, white) 0%,
                    color-mix(in srgb, var(--mc-sky) 84%, white) 48%,
                    color-mix(in srgb, var(--mc-teal) 82%, white) 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .mc-couple::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .34;
            background:
                url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 720px auto repeat;
            mix-blend-mode: soft-light;
        }

        .mc-couple::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .18;
            background:
                radial-gradient(circle at 18% 18%, rgba(255, 237, 170, .30), transparent 28%),
                radial-gradient(circle at 82% 18%, rgba(255, 255, 255, .32), transparent 30%),
                linear-gradient(180deg, rgba(255,255,255,.10), transparent 48%, rgba(255,255,255,.12));
        }

        .mc-couple > * {
            position: relative;
            z-index: 6;
        }

        .mc-couple .mc-label {
            color: var(--mc-deep);
            background: rgba(255,255,255,.86);
            margin-bottom: 16px;
        }

        .mc-couple .mc-title {
            color: #fffdf1;
            line-height: 1.05;
            text-shadow: 0 10px 26px rgba(18, 30, 47, .16);
        }

        .mc-couple .mc-note {
            max-width: 560px;
            margin: 14px auto 0;
            color: rgba(255,255,255,.88);
            font-weight: 600;
            line-height: 1.75;
        }

        .mc-couple .mc-gold-line-ornament {
            width: 140px;
            margin-top: 14px;
            margin-bottom: 8px;
        }

        /* dekor blur lampion besar */
        .mc-couple-decor .mc-blur-lantern {
            position: absolute;
            width: var(--size, 130px);
            height: auto;
            opacity: var(--op, .56);
            pointer-events: none;
            z-index: 2;
            filter: blur(2px) drop-shadow(0 18px 30px rgba(255, 196, 96, .18));
            animation: mcFloat 6.8s ease-in-out infinite;
        }

        .mc-couple-decor .mc-blur-lantern.b1 {
            left: -22px;
            top: 68px;
            --size: 128px;
            --op: .56;
            animation-delay: -.8s;
        }

        .mc-couple-decor .mc-blur-lantern.b2 {
            right: -14px;
            top: 76px;
            --size: 138px;
            --op: .58;
            animation-delay: -2.2s;
        }

        .mc-couple-decor .mc-blur-lantern.b3 {
            left: 8px;
            bottom: 72px;
            --size: 108px;
            --op: .48;
            animation-delay: -1.6s;
        }

        .mc-couple-decor .mc-blur-lantern.b4 {
            right: 4px;
            bottom: 88px;
            --size: 118px;
            --op: .50;
            animation-delay: -3s;
        }

        .mc-couple-decor .mc-sparkle.s1 { left: 70px; top: 210px; --size: 15px; }
        .mc-couple-decor .mc-sparkle.s2 { right: 86px; top: 196px; --size: 16px; }
        .mc-couple-decor .mc-sparkle.s3 { left: 96px; bottom: 162px; --size: 16px; }
        .mc-couple-decor .mc-sparkle.s4 { right: 76px; bottom: 154px; --size: 16px; }
        .mc-couple-decor .mc-sparkle.s5 { left: 50%; top: 176px; --size: 13px; --op: .55; }

        /* KEMBALIKAN lampion animasi kecil */
        .mc-couple .mc-section-lanterns {
            z-index: 5;
            opacity: 1;
        }

        .mc-couple .mc-section-lantern {
            opacity: var(--op, .72);
            filter: blur(var(--blur, 0px)) drop-shadow(0 12px 22px rgba(255, 193, 77, .30));
        }

        .mc-couple .mc-section-lantern.is-1 { --x: 6%;  --size: 60px; --dur: 18s; --delay: -2s;  --rot: -8deg; --op: .66; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-2 { --x: 18%; --size: 44px; --dur: 22s; --delay: -9s;  --rot: 7deg;  --op: .52; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-3 { --x: 31%; --size: 58px; --dur: 20s; --delay: -6s;  --rot: -10deg; --op: .58; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-4 { --x: 44%; --size: 42px; --dur: 24s; --delay: -12s; --rot: 10deg; --op: .42; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-5 { --x: 58%; --size: 66px; --dur: 19s; --delay: -4s;  --rot: -6deg; --op: .62; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-6 { --x: 71%; --size: 44px; --dur: 23s; --delay: -8s;  --rot: 9deg;  --op: .46; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-7 { --x: 84%; --size: 56px; --dur: 21s; --delay: -5s;  --rot: -11deg; --op: .58; --blur: 1px; }
        .mc-couple .mc-section-lantern.is-8 { --x: 94%; --size: 46px; --dur: 26s; --delay: -13s; --rot: 8deg;  --op: .44; --blur: 1px; }

        /* layout card dibuat lebih kecil, elegan, tidak terlalu penuh */
        .mc-couple-stage {
            width: min(100%, 920px);
            margin: 52px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(280px, 360px));
            justify-content: center;
            gap: 42px;
            align-items: end;
            position: relative;
            z-index: 8;
        }

        .mc-person-card {
            position: relative;
            min-height: 640px;
            padding: 42px 30px 38px;
            border-radius: 34px;
            overflow: hidden;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.58), rgba(255,255,255,.26));
            border: 1px solid rgba(255,255,255,.52);
            box-shadow:
                0 28px 76px rgba(18, 30, 47, .14),
                inset 0 1px 0 rgba(255,255,255,.70);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .mc-person-card::before {
            content: "";
            position: absolute;
            inset: 16px;
            z-index: 0;
            pointer-events: none;
            border-radius: 28px;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.45), transparent 34%),
                radial-gradient(circle at 88% 86%, rgba(238,202,104,.16), transparent 36%);
        }

        .mc-person-card::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 24px;
            width: 82px;
            height: 2px;
            transform: translateX(-50%);
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, var(--mc-gold), transparent);
            opacity: .95;
            z-index: 2;
        }

        .mc-card-back-ornament {
            position: absolute;
            left: 50%;
            top: 72px;
            width: min(112%, 430px);
            height: auto;
            transform: translateX(-50%);
            opacity: .46;
            z-index: 1;
            pointer-events: none;
        }

        .mc-mini-floral-corner {
            position: absolute;
            width: 92px;
            height: auto;
            z-index: 3;
            pointer-events: none;
            opacity: .95;
            filter: drop-shadow(0 8px 14px rgba(255, 208, 120, .18));
        }

        .mc-mini-floral-corner.is-left {
            left: 54px;
            top: 255px;
            transform: scaleX(-1);
        }

        .mc-mini-floral-corner.is-right {
            right: 54px;
            top: 255px;
        }

        .mc-person-photo-wrap {
            position: relative;
            z-index: 5;
            width: min(100%, 210px);
            margin: 0 auto;
            padding: 8px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,248,226,.88));
            box-shadow:
                0 18px 44px rgba(18, 30, 47, .14),
                0 0 0 1px rgba(255,255,255,.82);
        }

        .mc-person-photo-wrap img,
        .mc-person-initial {
            width: 100%;
            aspect-ratio: 4 / 5;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 18px;
            background: color-mix(in srgb, var(--mc-gold) 16%, #fff);
            color: var(--mc-deep);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .mc-person-content {
            position: relative;
            z-index: 5;
            margin-top: 24px;
        }

        .mc-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 16px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--mc-deep);
            background: rgba(255,255,255,.92);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .20em;
            text-transform: uppercase;
        }

        .mc-person-name {
            margin: 0;
            color: var(--mc-deep);
            font-family: Georgia, serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            line-height: 1.02;
            text-shadow: none;
        }

        .mc-person-family {
            max-width: 260px;
            margin: 16px auto 0;
            color: #37577f;
            font-weight: 650;
            line-height: 1.7;
        }

        /* ===================== RESPONSIVE ===================== */

        @media (max-width: 768px) {
            .mc-wave-divider {
                width: 140%;
                left: 50%;
                transform: translateX(-50%);
            }

            .mc-gold-line-ornament {
                width: 130px;
                max-width: 46%;
            }

            .mc-invite,
            .mc-save-date,
            .mc-couple {
                padding-left: 20px;
                padding-right: 20px;
            }

            .mc-invite {
                padding-bottom: 110px;
            }

            .mc-save-date {
                padding-top: 100px;
                padding-bottom: 120px;
                min-height: auto;
            }

            .mc-couple {
                padding-top: 100px;
                padding-bottom: 120px;
            }

            .mc-side-lantern {
                opacity: .82;
            }

            .mc-invite-decor .mc-side-lantern.is-left-top,
            .mc-invite-decor .mc-side-lantern.is-right-top,
            .mc-save-decor .mc-side-lantern.is-left-mid,
            .mc-save-decor .mc-side-lantern.is-right-mid {
                --size: 48px;
            }

            .mc-invite-decor .mc-side-lantern.is-left-bottom,
            .mc-invite-decor .mc-side-lantern.is-right-bottom {
                --size: 58px;
            }

            .mc-couple-decor .mc-blur-lantern.b1,
            .mc-couple-decor .mc-blur-lantern.b2 {
                --size: 110px;
            }

            .mc-couple-decor .mc-blur-lantern.b3,
            .mc-couple-decor .mc-blur-lantern.b4 {
                --size: 92px;
            }

            .mc-person-card {
                min-height: 600px;
                padding: 34px 18px 36px;
                border-radius: 28px;
            }

            .mc-card-back-ornament {
                width: min(86%, 270px);
                bottom: 18px;
            }

            .mc-mini-floral-corner {
                width: 72px;
                top: 208px;
            }

            .mc-person-content {
                margin-top: 28px;
            }

            .mc-invite {
                padding-top: 90px;
                padding-bottom: 165px;
                background-size:
                    420px auto,
                    auto;
            }

            .mc-invite::before {
                background-size: 520px auto;
                opacity: .32;
            }

            .mc-invite > .mc-wave-divider {
                bottom: -44px;
                width: 160%;
            }
        }

        /* Divider gelombang di antara Invitation dan Save The Date */
        .mc-between-wave {
            position: relative;
            z-index: 20;
            height: 92px;
            margin-top: -46px;
            margin-bottom: -46px;
            overflow: visible;
            pointer-events: none;
        }

        .mc-between-wave img {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 112%;
            max-width: none;
            height: auto;
            transform: translate(-50%, -50%);
            opacity: .96;
            display: block;
        }

        @media (max-width: 640px) {
            .mc-save-date .mc-palace-silhouette {
                width: 190%;
                bottom: 48px;
                opacity: .28;
            }
        }

        @media (max-width: 768px) {
            .mc-save-date .mc-palace-silhouette {
                width: 180%;
                bottom: -6px;
                opacity: .28;
            }
        }

        @media (max-width: 768px) {
            .mc-couple {
                padding-top: 92px;
                padding-bottom: 120px;
            }

            .mc-couple-stage {
                grid-template-columns: 1fr;
                width: min(100%, 360px);
                gap: 26px;
                margin-top: 38px;
            }

            .mc-person-card {
                min-height: 500px;
                padding: 26px 18px 24px;
                border-radius: 24px;
            }

            .mc-person-card::before {
                width: 88%;
                height: 74%;
            }

            .mc-card-back-ornament {
                width: min(84%, 250px);
                bottom: 30px;
                opacity: .15;
            }

            .mc-mini-floral-corner {
                width: 60px;
                top: 220px;
            }

            .mc-person-photo-wrap {
                width: min(100%, 190px);
            }

            .mc-couple-decor .mc-blur-lantern.b1,
            .mc-couple-decor .mc-blur-lantern.b2 {
                --size: 102px;
            }

            .mc-couple-decor .mc-blur-lantern.b3,
            .mc-couple-decor .mc-blur-lantern.b4 {
                --size: 88px;
            }
        }

        /* Paksa lampion couple tampil kembali */
        .mc-couple .mc-section-lanterns {
            display: block !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 5 !important;
            opacity: 1 !important;
            pointer-events: none !important;
            overflow: hidden !important;
        }

        .mc-couple .mc-section-lantern {
            display: block !important;
            opacity: var(--op, .62) !important;
            visibility: visible !important;
        }

        /* Hilangkan garis putih aneh dari efek shine */
        .mc-btn::after,
        .mc-copy-btn::after {
            display: none !important;
        }

        @media (max-width: 640px) {
            .mc-couple {
                background:
                    url("{{ asset('assets/modern-couple/mc-pattern-overlay.png') }}") center / 380px auto repeat,
                    linear-gradient(
                        180deg,
                        color-mix(in srgb, var(--mc-lavender) 92%, white) 0%,
                        color-mix(in srgb, var(--mc-sky) 84%, white) 50%,
                        color-mix(in srgb, var(--mc-teal) 82%, white) 100%
                    );
                background-blend-mode: soft-light, normal;
            }

            .mc-couple::before {
                opacity: .26;
                background-size: 460px auto;
            }
        }

        @media (max-width: 980px) {
            .mc-couple-and {
                position: relative;
                left: auto;
                top: auto;
                transform: none;
                margin: -4px auto;
                grid-row: 2;
                width: 64px;
                height: 64px;
                font-size: 44px;
            }
        }
    </style>
</head>

@php
    $mcThemeKey = $invitation->theme_color ?: 'navy';

    $mcThemes = [
        'maroon' => [
            'night' => '#261225',
            'teal' => '#146f72',
            'lavender' => '#bc96c6',
            'deep' => '#7a3144',
            'ink' => '#2c2630',
            'gold' => '#e2c768',
            'cream' => '#fff8df',
            'sky' => '#416c99',
            'pink' => '#ce8ab2',
        ],
        'emerald' => [
            'night' => '#123334',
            'teal' => '#12817d',
            'lavender' => '#a2b887',
            'deep' => '#28614f',
            'ink' => '#243333',
            'gold' => '#ddc567',
            'cream' => '#fff8df',
            'sky' => '#3e7895',
            'pink' => '#c98cae',
        ],
        'navy' => [
            'night' => '#142945',
            'teal' => '#1b858b',
            'lavender' => '#b79ccb',
            'deep' => '#315f8a',
            'ink' => '#263242',
            'gold' => '#e4c75f',
            'cream' => '#fff7df',
            'sky' => '#3a74a5',
            'pink' => '#cc8cb6',
        ],
        'rose' => [
            'night' => '#2f1d37',
            'teal' => '#1a7f82',
            'lavender' => '#c69aba',
            'deep' => '#8d4a66',
            'ink' => '#342c35',
            'gold' => '#e5c45e',
            'cream' => '#fff5de',
            'sky' => '#4d6f99',
            'pink' => '#d28aa5',
        ],
        'gold' => [
            'night' => '#2d2a1c',
            'teal' => '#218077',
            'lavender' => '#bca77b',
            'deep' => '#8b7130',
            'ink' => '#302d22',
            'gold' => '#e8cf65',
            'cream' => '#fff8db',
            'sky' => '#466f90',
            'pink' => '#c998a2',
        ],
        'slate' => [
            'night' => '#222c38',
            'teal' => '#29767a',
            'lavender' => '#9fa1b6',
            'deep' => '#586579',
            'ink' => '#29313b',
            'gold' => '#d9c16a',
            'cream' => '#f7f3e4',
            'sky' => '#486d8c',
            'pink' => '#b98da4',
        ],
    ];

    $mcTheme = $mcThemes[$mcThemeKey] ?? $mcThemes['navy'];
@endphp

<body
    style="
        --mc-night: {{ $mcTheme['night'] }};
        --mc-teal: {{ $mcTheme['teal'] }};
        --mc-lavender: {{ $mcTheme['lavender'] }};
        --mc-deep: {{ $mcTheme['deep'] }};
        --mc-ink: {{ $mcTheme['ink'] }};
        --mc-gold: {{ $mcTheme['gold'] }};
        --mc-cream: {{ $mcTheme['cream'] }};
        --mc-sky: {{ $mcTheme['sky'] }};
        --mc-pink: {{ $mcTheme['pink'] }};
    "
>
@php
    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'Imran & Zoya');
    $titleParts = str_contains($eventTitle, '&')
        ? array_map('trim', explode('&', $eventTitle, 2))
        : [];

    $brideName = $bride->name ?? ($titleParts[0] ?? 'Imran');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Zoya');
    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) {
            return $fallback;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/modern-couple/mc-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;
    $hasDifferentEndDate = $endDate && $startDate && !$startDate->isSameDay($endDate);

    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Minggu';
    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '20 . 04 . 25';
    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : '20 April 2025';

    $endDayText = $endDate ? $endDate->translatedFormat('l') : '';
    $endDayNumber = $endDate ? $endDate->format('d') : '';
    $endYearText = $endDate ? $endDate->translatedFormat('Y') : '';
    $endMonthText = $endDate ? $endDate->translatedFormat('F') : '';

    $eventDateRangeText = $eventDateText;
    if ($startDate && $endDate) {
        $eventDateRangeText = $startDate->isSameDay($endDate)
            ? $startDate->translatedFormat('d F Y')
            : $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Modern Palace Hall';
    $addressText = $invitation->address ?: 'Jl. Palace Avenue No. 21, Jakarta';
    $descriptionText = $invitation->description ?: 'With the blessing of God, we invite you to celebrate our wedding.';

    $mapOpenUrl = isset($mapData)
        ? ($mapData['open_url'] ?? $invitation->maps_url)
        : $invitation->maps_url;

    $mapEmbedUrl = isset($mapData)
        ? ($mapData['embed_url'] ?? null)
        : null;

    if (!$mapEmbedUrl && $mapOpenUrl && \Illuminate\Support\Str::contains($mapOpenUrl, 'google.com/maps')) {
        $mapEmbedUrl = $mapOpenUrl;
    }

    $shareUrl = route('invitation.public', $invitation->slug);
    $shareMessage = "Assalamu'alaikum Wr. Wb.\n\n"
        . "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n"
        . "*" . ($invitation->event_name ?: 'The Wedding Of') . "*\n"
        . "*{$eventTitle}*\n\n"
        . "Tanggal: {$eventDateRangeText}\n";

    if ($eventTimeText) {
        $shareMessage .= "Waktu: {$eventTimeText}\n";
    }

    if ($locationText) {
        $shareMessage .= "Tempat: {$locationText}\n";
    }

    if ($addressText) {
        $shareMessage .= "Alamat: {$addressText}\n";
    }

    if ($mapOpenUrl) {
        $shareMessage .= "Maps: {$mapOpenUrl}\n";
    }

    $shareMessage .= "\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\n"
        . "Klik link undangan berikut:\n{$shareUrl}\n\n"
        . "Terima kasih.\nWassalamu'alaikum Wr. Wb.";

    $shareText = rawurlencode($shareMessage);

    $musicSrc = asset('assets/music/background1.mp3');
    if ($invitation->music_url) {
        $musicPath = $invitation->music_url;

        if (\Illuminate\Support\Str::startsWith($musicPath, ['http://', 'https://'])) {
            $musicSrc = $musicPath;
        } elseif (\Illuminate\Support\Str::startsWith($musicPath, ['/storage/', 'storage/'])) {
            $musicSrc = asset(ltrim($musicPath, '/'));
        } else {
            $musicSrc = asset('storage/' . ltrim($musicPath, '/'));
        }
    }

    $targetDateTime = $startDate
        ? $startDate->format('Y-m-d') . 'T' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00')
        : now()->addDays(30)->format('Y-m-d\TH:i:s');

    $googleCalendarUrl = '#';
    if ($startDate) {
        $startDateTime = \Carbon\Carbon::parse(
            $startDate->format('Y-m-d') . ' ' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00')
        );

        $endDateTime = $invitation->event_end_time
            ? \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s'))
            : $startDateTime->copy()->addHours(3);

        $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            . '&text=' . rawurlencode(($invitation->event_name ?: 'Wedding Event') . ' - ' . $eventTitle)
            . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
            . '&details=' . rawurlencode(trim($descriptionText . "\n\nLink Undangan: " . $shareUrl))
            . '&location=' . rawurlencode(trim($locationText . ' - ' . $addressText))
            . '&ctz=Asia/Jakarta';
    }

    $galleryPhotos = ($invitation->photos ?? collect())->take(6);
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $hadir = $messages->where('attendance_status', 'hadir')->sum('guest_count');
    $tidakHadir = $messages->where('attendance_status', 'tidak_hadir')->count();
    $ragu = $messages->where('attendance_status', 'ragu')->count();

    $singleLantern = asset('assets/modern-couple/mc-lantern-single.png');
@endphp

<div class="mc-shell">
    <main class="mc-book" id="top">
        <div class="mc-floating-actions" aria-label="Aksi undangan">
            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan" aria-label="Bagikan">
                <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan">
            </a>

            <button type="button" id="music-toggle" title="Music" aria-label="Music">
                <img
                    src="{{ asset('assets/icons/music-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                    alt="Music"
                >
            </button>

            <button type="button" id="scroll-toggle" title="Auto Scroll" aria-label="Auto Scroll">
                <img
                    src="{{ asset('assets/icons/scroll-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                    alt="Auto Scroll"
                >
            </button>

            @if ($mapOpenUrl)
                <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi" aria-label="Lokasi">
                    <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi">
                </a>
            @endif
        </div>

        <audio id="invitation-music" src="{{ $musicSrc }}" preload="auto" loop></audio>

        <section id="opening" class="mc-page mc-hero">
            <div class="mc-hero-pattern" aria-hidden="true"></div>
            <div class="mc-lantern-layer" aria-hidden="true"></div>

            <div class="mc-hero-inner" data-reveal="zoom">
                <p class="mc-hero-kicker responsive-text">
                    {{ strtoupper($invitation->event_name ?: 'The Wedding Of') }}
                </p>

                <h1 class="mc-title mc-hero-title responsive-text">
                    <span>{{ $brideName }}</span>
                    <span class="mc-script mc-hero-and">&</span>
                    <span>{{ $groomName }}</span>
                </h1>

                <p class="mc-hero-date responsive-text">{{ $eventDateShort }}</p>

                <div class="mc-hero-actions">
                    <a href="#invitation" class="mc-btn gold">Buka Undangan</a>
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="mc-btn light">Save the Date</a>
                </div>
            </div>
        </section>

        <section id="invitation" class="mc-page mc-invite mc-has-lanterns">

            <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

            <div class="mc-invitation-card" data-reveal="zoom">
                <p class="mc-label">Invitation</p>

                <img
                    src="{{ asset('assets/modern-couple/mc-gold-line-ornament.png') }}"
                    class="mc-gold-line-ornament is-top"
                    alt=""
                >

                <p class="mc-note responsive-text">
                    With the loving blessings of our families, we invite you to our wedding celebration.
                </p>

                <h2 class="mc-title mc-script responsive-text">Invite</h2>

                <img
                    src="{{ asset('assets/modern-couple/mc-gold-line-ornament.png') }}"
                    class="mc-gold-line-ornament"
                    alt=""
                >

                <p class="mc-note responsive-text">{{ $brideName }} &amp; {{ $groomName }}</p>
            </div>
        </section>

        <div class="mc-between-wave" aria-hidden="true">
            <img
                src="{{ asset('assets/modern-couple/mc-wave-divider-soft.png') }}"
                alt=""
            >
        </div>

        <section id="countdown" class="mc-page mc-save-date mc-has-lanterns">

            <img
                src="{{ asset('assets/modern-couple/mc-palace-silhouette-soft.png') }}"
                class="mc-palace-silhouette"
                alt=""
            >

            <div class="mc-section-decor mc-save-decor" aria-hidden="true">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s1" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s2" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s3" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s4" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s5" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s6" alt="">
            </div>

            <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

            <div class="mc-count-panel" data-reveal="zoom">
                <p class="mc-label">See The Route</p>

                <img
                    src="{{ asset('assets/modern-couple/mc-gold-line-ornament.png') }}"
                    class="mc-gold-line-ornament is-top"
                    alt=""
                >

                <h2 class="mc-title mc-script mc-count-title responsive-text">
                    Save The Date
                </h2>

                <div class="mc-count-grid" data-countdown="{{ $targetDateTime }}">
                    <div class="mc-count-card">
                        <span class="mc-count-number" data-days>0</span>
                        <span class="mc-count-label">Days</span>
                    </div>

                    <div class="mc-count-card">
                        <span class="mc-count-number" data-hours>0</span>
                        <span class="mc-count-label">Hours</span>
                    </div>

                    <div class="mc-count-card">
                        <span class="mc-count-number" data-minutes>0</span>
                        <span class="mc-count-label">Minutes</span>
                    </div>

                    <div class="mc-count-card">
                        <span class="mc-count-number" data-seconds>0</span>
                        <span class="mc-count-label">Seconds</span>
                    </div>
                </div>

                <div class="mc-count-actions">
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="mc-btn gold">
                        Add to Calendar
                    </a>
                </div>

                <img
                    src="{{ asset('assets/modern-couple/mc-gold-line-ornament.png') }}"
                    class="mc-gold-line-ornament is-bottom"
                    alt=""
                >
            </div>
        </section>

        <div class="mc-between-wave" aria-hidden="true">
            <img
                src="{{ asset('assets/modern-couple/mc-wave-divider-soft.png') }}"
                alt=""
            >
        </div>

        <section id="couple" class="mc-page mc-couple mc-has-lanterns">

            <div class="mc-section-decor mc-couple-decor" aria-hidden="true">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s1" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s2" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s3" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s4" alt="">
                <img src="{{ asset('assets/modern-couple/mc-soft-sparkle.png') }}" class="mc-sparkle s5" alt="">
            </div>

            <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

            <p class="mc-label" data-reveal="zoom">Meet The</p>
            <h2 class="mc-title responsive-text" data-reveal="zoom" style="font-size: clamp(2.6rem, 5vw, 5.4rem);">
                Bride and Groom
            </h2>
            <p class="mc-note responsive-text" data-reveal="zoom">{{ $descriptionText }}</p>

            <img
                src="{{ asset('assets/modern-couple/mc-gold-line-ornament.png') }}"
                class="mc-gold-line-ornament"
                alt=""
                data-reveal="zoom"
            >

            <div class="mc-couple-stage">
                @foreach ([
                    [$bride, $brideName, $brideSubtitle, $bridePhoto, 'Putri dari keluarga tercinta'],
                    [$groom, $groomName, $groomSubtitle, $groomPhoto, 'Putra dari keluarga tercinta'],
                ] as $person)
                    <article class="mc-person-card" data-reveal="{{ $loop->first ? 'left' : 'right' }}">
                        <img
                            src="{{ asset('assets/modern-couple/mc-card-back-ornament.png') }}"
                            class="mc-card-back-ornament"
                            alt=""
                        >

                        <img
                            src="{{ asset('assets/modern-couple/mc-mini-floral-corner.png') }}"
                            class="mc-mini-floral-corner is-left"
                            alt=""
                        >

                        <img
                            src="{{ asset('assets/modern-couple/mc-mini-floral-corner.png') }}"
                            class="mc-mini-floral-corner is-right"
                            alt=""
                        >

                        <div class="mc-person-photo-wrap">
                            @if ($person[3])
                                <img src="{{ $person[3] }}" alt="{{ $person[1] }}">
                            @else
                                <div class="mc-person-initial">
                                    {{ \Illuminate\Support\Str::substr($person[1], 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="mc-person-content">
                            <div class="mc-person-subtitle responsive-text">{{ $person[2] }}</div>
                            <h3 class="mc-person-name responsive-text">{{ $person[1] }}</h3>
                            <p class="mc-person-family responsive-text">
                                {{ $person[0]->family_name ?? $person[4] }}
                            </p>
                        </div>
                    </article>

                    @if ($loop->first)
                        <div class="mc-couple-and" aria-hidden="true">&</div>
                    @endif
                @endforeach
            </div>
        </section>

        <section id="acara" class="mc-page mc-has-lanterns">
            <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

            <p class="mc-label" data-reveal="zoom">Follow The Action</p>
            <h2 class="mc-title responsive-text" data-reveal="zoom" style="font-size: clamp(2.8rem, 5.4vw, 5.8rem);">
                Wedding Event
            </h2>
            <p class="mc-note responsive-text">Acara pernikahan kami akan dilaksanakan pada:</p>

            <div class="mc-event-layout {{ $mapOpenUrl || $mapEmbedUrl ? '' : 'is-single' }}">
                <article class="mc-event-card" data-reveal="left">
                    <h3 class="mc-title responsive-text">Acara Pernikahan</h3>

                    <div class="mc-date-split">
                        <div class="mc-date-side">{{ $eventDayText }}</div>
                        <div class="mc-date-center">
                            <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                            <span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span>
                        </div>
                        <div class="mc-date-side">{{ $startDate ? $startDate->translatedFormat('F') : '' }}</div>
                    </div>

                    @if ($hasDifferentEndDate)
                        <div class="mc-date-end-label">Sampai</div>
                        <div class="mc-date-split mc-date-split-end">
                            <div class="mc-date-side">{{ $endDayText }}</div>
                            <div class="mc-date-center">
                                <b>{{ $endDayNumber }}</b>
                                <span>{{ $endYearText }}</span>
                            </div>
                            <div class="mc-date-side">{{ $endMonthText }}</div>
                        </div>
                    @endif

                    @if ($eventTimeText)
                        <p class="mc-event-line responsive-text">Pukul {{ $eventTimeText }}</p>
                    @endif

                    <p class="mc-event-place responsive-text">{{ $locationText }}</p>
                    <p class="mc-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="mc-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="mc-btn">Google Maps</a>
                        @endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="mc-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="mc-map-card" data-reveal="right">
                        @if ($mapEmbedUrl)
                            <iframe
                                class="mc-map-frame"
                                src="{{ $mapEmbedUrl }}"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="mc-map-placeholder">
                                <div>
                                    <div class="mc-map-pin">⌖</div>
                                    <strong>{{ $locationText }}</strong>
                                </div>
                            </a>
                        @endif

                        <div class="mc-map-footer">
                            <div>
                                <p class="mc-map-title responsive-text">{{ $locationText }}</p>
                                <p class="mc-map-address responsive-text">{{ $addressText }}</p>
                            </div>
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="mc-btn">Buka Maps</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @if ($galleryPhotos->count())
            <section id="galeri" class="mc-page mc-has-lanterns">
                <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

                <p class="mc-label">Our Gallery</p>
                <h2 class="mc-title responsive-text" style="font-size: clamp(2.8rem, 5.4vw, 5.8rem);">
                    Precious Moment
                </h2>

                <div class="mc-gallery-grid">
                    @foreach ($galleryPhotos as $photo)
                        @php
                            $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null);
                        @endphp

                        @if ($src)
                            <a href="{{ $src }}" target="_blank" class="mc-gallery-item">
                                <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($gifts->count())
            <section id="gift" class="mc-page slim mc-has-lanterns">
                <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

                <p class="mc-label">Wedding Gift</p>
                <h2 class="mc-title mc-script responsive-text" style="font-size: clamp(3rem, 6vw, 6rem);">
                    Tanda Kasih
                </h2>
                <p class="mc-note responsive-text">Doa restu Anda merupakan karunia yang sangat berarti bagi kami.</p>

                <div class="mc-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                    @foreach ($gifts as $gift)
                        <div class="mc-gift-card">
                            <div class="mc-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                            <div class="mc-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                            <p class="responsive-text" style="position: relative; z-index: 2; margin: 12px 0 0; color: #58616e;">
                                {{ $gift->account_name ?? $eventTitle }}
                            </p>
                            <button type="button" class="mc-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">
                                Salin Nomor
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section id="rsvp" class="mc-page slim mc-has-lanterns">
            <div class="mc-section-lanterns" aria-hidden="true">
                @for ($i = 1; $i <= 8; $i++)
                    <img
                        src="{{ $singleLantern }}"
                        class="mc-section-lantern is-{{ $i }}"
                        alt=""
                    >
                @endfor
            </div>

            <p class="mc-label">RSVP</p>
            <h2 class="mc-title mc-script responsive-text" style="font-size: clamp(3rem, 6vw, 6rem);">
                Kirim Pesan
            </h2>

            <div class="mc-rsvp-layout">
                <div class="mc-rsvp-copy">
                    <h3 class="mc-title mc-script responsive-text">Kehadiran Anda</h3>
                    <p class="mc-note responsive-text" style="margin-left: 0;">
                        Mohon konfirmasi kehadiran dan kirimkan doa terbaik untuk kedua mempelai.
                    </p>
                </div>

                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="mc-form-card space-y-4">
                    @csrf

                    <div>
                        <label class="mc-form-label">Nama</label>
                        <input
                            type="text"
                            name="guest_name"
                            value="{{ old('guest_name') }}"
                            class="mc-input"
                            placeholder="Nama lengkap"
                            required
                        >
                    </div>

                    <div>
                        <label class="mc-form-label">Konfirmasi Kehadiran</label>
                        <select name="attendance_status" class="mc-input">
                            <option value="">Pilih status kehadiran</option>
                            <option value="hadir">Saya berencana hadir</option>
                            <option value="tidak_hadir">Tidak bisa hadir</option>
                            <option value="ragu">Masih ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="mc-form-label">Jumlah Tamu</label>
                        <input
                            type="number"
                            name="guest_count"
                            value="{{ old('guest_count', 1) }}"
                            min="1"
                            max="10"
                            class="mc-input"
                        >
                    </div>

                    <div>
                        <label class="mc-form-label">Pesan</label>
                        <textarea
                            name="message"
                            rows="4"
                            class="mc-input"
                            placeholder="Tulis ucapan terbaik..."
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="mc-btn" style="width: 100%;">
                        Kirim Pesan
                    </button>
                </form>

                <div class="mc-summary-grid">
                    <div>
                        <b>{{ $tidakHadir }}</b>
                        <span>Tidak Hadir</span>
                    </div>
                    <div>
                        <b>{{ $hadir }}</b>
                        <span>Hadir</span>
                    </div>
                    <div>
                        <b>{{ $ragu }}</b>
                        <span>Ragu</span>
                    </div>
                </div>

                <div class="mc-message-list">
                    @forelse ($messages->take(5) as $message)
                        <div class="mc-message-card">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="responsive-text font-black" style="color: var(--mc-deep);">
                                        {{ $message->guest_name }}
                                    </p>
                                    <p class="text-xs mt-1" style="color: #6b7480;">
                                        {{ $message->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if ($message->attendance_status)
                                    <span class="text-xs font-black px-3 py-1 rounded-full" style="background: rgba(49, 95, 138, .12); color: var(--mc-deep);">
                                        {{ str_replace('_', ' ', $message->attendance_status) }}
                                    </span>
                                @endif
                            </div>

                            <p class="responsive-text mt-3" style="color: #58616e; line-height: 1.8;">
                                {{ $message->message }}
                            </p>
                        </div>
                    @empty
                        <div class="mc-message-card text-center" style="color: #6b7480;">
                            Belum ada ucapan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="closing" class="mc-page mc-hero">
            <div class="mc-hero-pattern" aria-hidden="true"></div>
            <div class="mc-lantern-layer" aria-hidden="true"></div>

            <div class="mc-closing-card">
                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="mc-closing-photo">
                <p class="mc-note responsive-text">Terima Kasih</p>
                <h2 class="mc-title responsive-text">{{ $eventTitle }}</h2>
                <p class="mc-note responsive-text">
                    Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
                </p>
            </div>
        </section>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const music = document.getElementById('invitation-music');
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
        let isMusicPlaying = false;

        function setMusicIcon(active) {
            if (!musicToggle || !musicIcon) return;
            musicToggle.classList.toggle('is-active', active);
            musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
        }

        if (musicToggle && music) {
            musicToggle.addEventListener('click', async function () {
                try {
                    if (isMusicPlaying) {
                        music.pause();
                        isMusicPlaying = false;
                    } else {
                        await music.play();
                        isMusicPlaying = true;
                    }
                    setMusicIcon(isMusicPlaying);
                } catch (error) {
                    isMusicPlaying = false;
                    setMusicIcon(false);
                }
            });
        }

        const scrollToggle = document.getElementById('scroll-toggle');
        const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;
        let autoScrollActive = false;
        let autoScrollFrame = null;
        let lastAutoScrollTime = 0;
        const scrollSpeedPerSecond = 69;

        function setScrollIcon(active) {
            if (!scrollToggle || !scrollIcon) return;
            scrollToggle.classList.toggle('is-active', active);
            scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
        }

        function stopAutoScroll() {
            autoScrollActive = false;
            lastAutoScrollTime = 0;
            document.documentElement.style.scrollBehavior = '';

            if (autoScrollFrame) {
                cancelAnimationFrame(autoScrollFrame);
            }

            autoScrollFrame = null;
            setScrollIcon(false);
        }

        function autoScrollStep(timestamp) {
            if (!autoScrollActive) return;
            if (!lastAutoScrollTime) lastAutoScrollTime = timestamp;

            const delta = timestamp - lastAutoScrollTime;
            lastAutoScrollTime = timestamp;

            const scroller = document.scrollingElement || document.documentElement;
            const maxY = scroller.scrollHeight - window.innerHeight;
            const currentY = window.scrollY || scroller.scrollTop || 0;
            const nextY = Math.min(currentY + (scrollSpeedPerSecond * delta / 1000), maxY);

            window.scrollTo(0, nextY);

            if (nextY >= maxY - 1) {
                stopAutoScroll();
                return;
            }

            autoScrollFrame = requestAnimationFrame(autoScrollStep);
        }

        function startAutoScroll() {
            stopAutoScroll();
            autoScrollActive = true;
            lastAutoScrollTime = 0;
            document.documentElement.style.scrollBehavior = 'auto';
            setScrollIcon(true);
            autoScrollFrame = requestAnimationFrame(autoScrollStep);
        }

        if (scrollToggle) {
            scrollToggle.addEventListener('click', function () {
                if (autoScrollActive) stopAutoScroll();
                else startAutoScroll();
            });

            ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                window.addEventListener(eventName, function () {
                    if (autoScrollActive) stopAutoScroll();
                }, { passive: true });
            });
        }

        const countdown = document.querySelector('[data-countdown]');
        if (countdown) {
            const target = new Date(countdown.getAttribute('data-countdown')).getTime();
            const daysEl = countdown.querySelector('[data-days]');
            const hoursEl = countdown.querySelector('[data-hours]');
            const minutesEl = countdown.querySelector('[data-minutes]');
            const secondsEl = countdown.querySelector('[data-seconds]');

            function updateCountdown() {
                const distance = Math.max(0, target - Date.now());
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((distance / (1000 * 60)) % 60);
                const seconds = Math.floor((distance / 1000) % 60);

                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        document.querySelectorAll('[data-copy]').forEach(function (button) {
            button.addEventListener('click', async function () {
                try {
                    await navigator.clipboard.writeText(button.getAttribute('data-copy') || '');
                    button.classList.add('copied');

                    const old = button.textContent;
                    button.textContent = 'Tersalin';

                    setTimeout(function () {
                        button.classList.remove('copied');
                        button.textContent = old;
                    }, 1300);
                } catch (error) {}
            });
        });

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: .12 });

        document.querySelectorAll('[data-reveal]').forEach(function (element) {
            observer.observe(element);
        });
    });
</script>

<script>
    document.addEventListener('contextmenu', function (event) {
        event.preventDefault();
    });

    document.addEventListener('keydown', function (event) {
        const key = event.key ? event.key.toLowerCase() : '';

        if (
            event.key === 'F12' ||
            (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) ||
            (event.ctrlKey && ['u', 's', 'p'].includes(key))
        ) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });

    document.addEventListener('dragstart', function (event) {
        event.preventDefault();
    });

    document.addEventListener('selectstart', function (event) {
        const tag = event.target.tagName ? event.target.tagName.toLowerCase() : '';
        if (!['input', 'textarea', 'select', 'option'].includes(tag)) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
