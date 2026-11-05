{{-- resources/views/public-invitations/wedding-ocean-love.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Ocean Love'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--ol-ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(180deg, var(--ol-night), var(--ol-teal) 44%, var(--ol-lavender));
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }

        input, textarea, select {
            -webkit-user-select: text;
            user-select: text;
        }

        img, a, button {
            -webkit-user-drag: none;
            user-drag: none;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .ol-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .ol-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid rgba(255,255,255,.18);
            background:
                linear-gradient(180deg, rgba(255,255,255,.11), rgba(255,255,255,.05)),
                url("{{ asset('assets/ocean-love/ol-paper-texture.png') }}") center / cover repeat,
                var(--ol-cream);
            box-shadow: 0 44px 130px rgba(18, 30, 47, .28);
        }

        .ol-book::before,
        .ol-book::after,
        .ol-page::before,
        .ol-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .ol-book::before {
            z-index: 0;
            opacity: .38;
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 780px auto repeat,
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px) 0 0 / 46px 46px,
                linear-gradient(0deg, rgba(255,255,255,.03) 1px, transparent 1px) 0 0 / 46px 46px;
        }

        .ol-book::after {
            z-index: 0;
            opacity: .34;
            background:
                radial-gradient(circle at 18% 18%, color-mix(in srgb, var(--ol-gold) 22%, transparent), transparent 26%),
                radial-gradient(circle at 82% 28%, color-mix(in srgb, var(--ol-pink) 20%, transparent), transparent 28%);
        }

        .ol-book > * {
            position: relative;
            z-index: 2;
        }

        .ol-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            transform: translateY(-50%);
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(40,58,83,.14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(18,30,47,.14);
            backdrop-filter: blur(14px);
        }

        .ol-floating-actions a,
        .ol-floating-actions button {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 16px 0 0 16px;
            cursor: pointer;
            background: rgba(255,255,255,.96);
            box-shadow: 0 10px 22px rgba(18,30,47,.12);
            transition: transform .25s ease, background .25s ease;
        }

        .ol-floating-actions a:hover,
        .ol-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .ol-floating-actions button.is-active {
            background: color-mix(in srgb, var(--ol-gold) 38%, white);
        }

        .ol-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .ol-page {
            position: relative;
            min-height: auto;
            overflow: hidden;
            padding: 104px 72px;
            text-align: center;
            isolation: isolate;
        }

        .ol-page.slim {
            padding-top: 84px;
            padding-bottom: 84px;
        }

        .ol-page > * {
            position: relative;
            z-index: 6;
        }

        .ol-page::after {
            z-index: 2;
            opacity: .12;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.52), rgba(255,255,255,.18) 46%, transparent 72%);
        }

        .ol-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--ol-deep);
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(255,255,255,.32);
            box-shadow: 0 12px 28px rgba(18,30,47,.08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .ol-label::before,
        .ol-label::after {
            content: "";
            width: 28px;
            height: 1px;
            background: var(--ol-deep);
            opacity: .46;
        }

        .ol-title {
            margin: 0;
            color: var(--ol-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .02em;
            line-height: .96;
            text-wrap: balance;
        }

        .ol-script {
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
        }

        .ol-note {
            width: min(100%, 700px);
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--ol-ink) 84%, transparent);
            line-height: 1.9;
        }

        .ol-btn {
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
            background: linear-gradient(135deg, var(--ol-deep), var(--ol-night));
            box-shadow: 0 16px 34px rgba(18,30,47,.22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease;
        }

        .ol-btn:hover {
            transform: translateY(-2px);
        }

        .ol-btn.light {
            color: var(--ol-deep);
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(40,58,83,.15);
        }

        .ol-btn.gold,
        .ol-copy-btn {
            color: #31301d;
            background: linear-gradient(135deg, #dfc45b, #fff1a8);
        }

        .ol-btn::after,
        .ol-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: olShine 4.2s ease-in-out infinite;
        }

        /* HERO */
        .ol-hero {
            position: relative;
            min-height: 100vh;
            display: grid;
            place-items: center;
            overflow: hidden;
            padding: 42px 20px 46px;
            text-align: center;
            color: #f8f6e8;
            background:
                linear-gradient(
                    180deg,
                    rgba(87, 189, 244, .72) 0%,
                    rgba(98, 202, 248, .62) 38%,
                    rgba(143, 226, 252, .50) 68%,
                    rgba(62, 171, 215, .74) 100%
                ),
                url("{{ asset('assets/ocean-love/ol-sky-ocean-gradient.png') }}") center top / cover no-repeat,
                #63caff;
        }

        .ol-hero::before {
            z-index: 1;
            opacity: .96;
            background:
                url("{{ asset('assets/ocean-love/ol-palace-tower.png') }}") center 28% / 235px auto no-repeat,
                url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center 62% / 108% auto no-repeat,
                url("{{ asset('assets/ocean-love/ol-ocean-carpet.png') }}") center bottom / 64% auto no-repeat,
                url("{{ asset('assets/ocean-love/ol-fountain.png') }}") center 72% / 112px auto no-repeat;
        }

        .ol-hero::after {
            z-index: 4;
            opacity: 1;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.10), transparent 34%),
                linear-gradient(
                    180deg,
                    rgba(6, 35, 58, .08) 0%,
                    rgba(6, 35, 58, .12) 48%,
                    rgba(6, 35, 58, .10) 100%
                );
        }

        .ol-hero-pattern {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .32;
            background: url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 760px auto repeat;
            mix-blend-mode: soft-light;
        }

        .ol-lantern-layer {
            position: absolute;
            inset: -4% -3%;
            z-index: 3;
            pointer-events: none;
            opacity: .78;
            background: url("{{ asset('assets/ocean-love/ol-floating-lanterns.png') }}") center top / 105% auto no-repeat;
            animation: olLanternFloat 7.5s ease-in-out infinite;
            transform-origin: center top;
            will-change: transform, opacity;
        }

        .ol-hero-inner {
            position: relative;
            z-index: 6;
            width: min(100%, 760px);
            min-height: min(70vh, 620px);
            margin: 0 auto;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;

            /* ini yang mengatur posisi hero */
            padding-top: 54px;

            /* ini yang mengatur jarak antar teks */
            gap: 6px;
        }

        .ol-hero-inner::before {
            content: none !important;
            display: none !important;
            background: none !important;
            filter: none !important;
            box-shadow: none !important;
        }

        /* Closing tetap boleh punya efek sendiri kalau dibutuhkan */
        .ol-closing-card::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: -1;
            width: min(92vw, 620px);
            height: 38%;
            transform: translate(-50%, -50%);
            border-radius: 999px;
            background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%);
            filter: blur(2px);
            pointer-events: none;
        }

        .ol-hero-kicker {
            margin: 0 0 4px;
            color: #fffaf0;
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .20em;
            text-transform: uppercase;
            text-shadow: none;
        }

        .ol-hero-title {
            margin: 0;
            color: #fff8e8;
            -webkit-text-fill-color: #fff8e8;
            font-size: clamp(2.7rem, 7vw, 5.5rem);
            line-height: .78;
            font-weight: 650;
            letter-spacing: .03em;
            text-align: center;
            text-transform: uppercase;
            text-shadow: none;
        }

        .ol-hero-name {
            display: block;
            margin: 0;
            padding: 0;
            line-height: .18;
        }

        .ol-hero-and {
            display: block;
            margin: 0 0 2px;
            color: #f7d778;
            -webkit-text-fill-color: #f7d778;
            font-size: clamp(1.45rem, 3.4vw, 2.35rem);
            line-height: .18;
            text-transform: none;
            text-shadow: none;
        }

        .ol-hero-date {
            margin: 8px 0 0;
            color: #fff6df;
            font-size: .92rem;
            font-weight: 850;
            letter-spacing: .22em;
            text-shadow: none;
        }

        .ol-hero-actions {
            margin-top: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* LANTERN SMALL ANIMATION */
        .ol-has-lanterns {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .ol-section-lanterns {
            position: absolute;
            inset: 0;
            z-index: 3;
            overflow: hidden;
            pointer-events: none;
        }

        .ol-section-lantern {
            position: absolute;
            left: var(--x, 50%);
            bottom: -140px;
            width: var(--size, 72px);
            height: auto;
            opacity: var(--op, .65);
            filter: blur(var(--blur, 0px)) drop-shadow(0 10px 18px rgba(255,193,77,.28));
            transform: translateX(-50%) rotate(var(--rot, 0deg));
            transform-origin: center center;
            will-change: transform, opacity, margin-left;
            animation:
                olLanternRise var(--dur, 20s) linear infinite,
                olLanternSway calc(var(--dur, 20s) * .30) ease-in-out infinite;
            animation-delay: var(--delay, 0s), var(--delay, 0s);
        }

        .ol-section-lantern.is-1 { --x: 5%; --size: 78px; --dur: 17s; --delay: -2s; --rot: -8deg; --op: .72; --blur: 0px; }
        .ol-section-lantern.is-2 { --x: 14%; --size: 56px; --dur: 21s; --delay: -8s; --rot: 7deg; --op: .52; --blur: 1px; }
        .ol-section-lantern.is-3 { --x: 26%; --size: 88px; --dur: 19s; --delay: -5s; --rot: -11deg; --op: .62; --blur: 0px; }
        .ol-section-lantern.is-4 { --x: 40%; --size: 62px; --dur: 24s; --delay: -11s; --rot: 10deg; --op: .40; --blur: 1px; }
        .ol-section-lantern.is-5 { --x: 56%; --size: 98px; --dur: 18s; --delay: -4s; --rot: -6deg; --op: .66; --blur: 0px; }
        .ol-section-lantern.is-6 { --x: 68%; --size: 52px; --dur: 23s; --delay: -9s; --rot: 9deg; --op: .46; --blur: 1px; }
        .ol-section-lantern.is-7 { --x: 80%; --size: 74px; --dur: 20s; --delay: -6s; --rot: -12deg; --op: .58; --blur: 0px; }
        .ol-section-lantern.is-8 { --x: 91%; --size: 60px; --dur: 26s; --delay: -13s; --rot: 8deg; --op: .42; --blur: 1px; }

        /* ===================== OCEAN ORNAMENT HELPERS ===================== */

        /* Divider gelombang di antara 2 section */
        .ol-between-wave {
            position: relative;
            z-index: 20;
            height: 130px;
            margin-top: -64px;
            margin-bottom: -66px;
            overflow: visible;
            pointer-events: none;
        }

        .ol-between-wave img {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 112%;
            max-width: none;
            height: auto;
            display: block;
            transform: translate(-50%, -50%);
            opacity: .98;
        }

        .ol-palace-side {
            position: absolute;
            bottom: 70px;
            width: 240px;
            max-width: 24vw;
            opacity: .24;
            pointer-events: none;
            z-index: 1;
            filter: drop-shadow(0 10px 18px rgba(255,255,255,.10));
        }

        .ol-palace-side.left {
            left: 0;
            transform: translateX(-10%);
        }

        .ol-palace-side.right {
            right: 0;
            transform: translateX(10%) scaleX(-1);
        }

        .ol-soft-bubbles {
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            opacity: .55;
            background: url("{{ asset('assets/ocean-love/ol-soft-sparkle-bubbles.png') }}") center / cover no-repeat;
        }

        .ol-pearl-top-center {
            position: absolute;
            top: 22px;
            left: 50%;
            width: 78px;
            height: auto;
            transform: translateX(-50%);
            z-index: 7;
            pointer-events: none;
            filter: drop-shadow(0 8px 18px rgba(255, 232, 182, .22));
        }

        .ol-section-coral {
            position: absolute;
            bottom: 14px;
            width: 160px;
            height: auto;
            z-index: 4;
            pointer-events: none;
            opacity: .92;
        }

        .ol-section-coral.left {
            left: 10px;
        }

        .ol-section-coral.right {
            right: 10px;
            transform: scaleX(-1);
        }

        .ol-gold-corner {
            position: absolute;
            width: 108px;
            height: auto;
            z-index: 7;
            pointer-events: none;
            opacity: .92;
        }

        .ol-gold-corner.tl {
            top: 16px;
            left: 16px;
        }

        .ol-gold-corner.tr {
            top: 16px;
            right: 16px;
            transform: scaleX(-1);
        }

        .ol-gold-corner.bl {
            bottom: 16px;
            left: 16px;
            transform: scaleY(-1);
        }

        .ol-gold-corner.br {
            bottom: 16px;
            right: 16px;
            transform: scale(-1);
        }

        /* ===================== INVITE ===================== */

        .ol-invite {
            position: relative;
            color: #fffdf1;
            padding-top: 130px;
            padding-bottom: 150px;
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(
                    180deg,
                    #178da9 0%,
                    #32aeca 42%,
                    #4dbddd 72%,
                    #60cde8 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .ol-invite::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            opacity: .22;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 24%, rgba(255,255,255,.20), transparent 35%),
                linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.08));
        }

        .ol-invite .ol-title,
        .ol-invite .ol-label {
            color: #fffdf1;
        }

        .ol-invite .ol-note {
            color: rgba(255,255,255,.88);
        }

        .ol-invitation-card {
            position: relative;
            width: min(100%, 780px);
            margin: 0 auto;
            padding: 72px 54px 64px;
            border-radius: 42px;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(102, 211, 235, .20), rgba(62, 171, 195, .18));
            border: 1px solid rgba(255,255,255,.26);
            box-shadow: 0 30px 90px rgba(12, 72, 86, .22);
            backdrop-filter: blur(10px);
        }

        .ol-invitation-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 32px;
            border: 1px solid rgba(255, 233, 179, .34);
            pointer-events: none;
            z-index: 1;
        }

        .ol-invitation-card > * {
            position: relative;
            z-index: 3;
        }

        .ol-invitation-card h2 {
            font-size: clamp(3rem, 6vw, 6rem);
            margin-top: 8px;
        }

        .ol-invite .ol-label {
            margin-bottom: 22px;
        }

        .ol-invite .ol-btn {
            margin-top: 4px;
        }

        /* ===================== COUNTDOWN ===================== */

        .ol-save-date {
            position: relative;
            min-height: 780px;
            padding: 130px 72px 150px;
            display: grid;
            place-items: center;
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(
                    180deg,
                    #47bdd9 0%,
                    #73d1ea 35%,
                    #68c8e3 68%,
                    #59b9d7 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .ol-save-date::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .16;
            background:
                radial-gradient(circle at 50% 26%, rgba(255,255,255,.22), transparent 40%);
        }

        .ol-count-panel {
            position: relative;
            overflow: hidden;
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 78px 38px 62px;
            border-radius: 42px;
            background: linear-gradient(180deg, rgba(109, 204, 230, .18), rgba(90, 191, 220, .16));
            border: 1px solid rgba(255,255,255,.28);
            box-shadow: 0 28px 84px rgba(18,30,47,.15);
            backdrop-filter: blur(10px);
        }

        .ol-count-panel::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 30px;
            border: 1px solid rgba(255, 233, 179, .34);
            z-index: 1;
            pointer-events: none;
        }

        .ol-count-panel > * {
            position: relative;
            z-index: 3;
        }

        .ol-count-title {
            font-size: clamp(2.6rem, 5vw, 5rem);
            color: #fffdf1;
            line-height: .95;
            text-shadow: 0 10px 24px rgba(0,0,0,.12);
        }

        .ol-count-grid {
            width: min(100%, 540px);
            margin: 34px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .ol-count-card {
            padding: 22px 14px;
            border-radius: 24px;
            background: rgba(255,255,255,.92);
            box-shadow: 0 18px 40px rgba(18,30,47,.10);
        }

        .ol-count-number {
            display: block;
            color: var(--ol-deep);
            font-family: Georgia, serif;
            font-size: clamp(2.5rem, 6vw, 4.2rem);
            line-height: 1;
            font-weight: 800;
        }

        .ol-count-label {
            display: block;
            margin-top: 8px;
            color: #4f5d6b;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .10em;
            text-transform: uppercase;
        }

        .ol-count-actions {
            margin-top: 28px;
        }

        /* ===================== COUPLE ===================== */

        .ol-couple {
            position: relative;
            color: #fffdf1;
            padding-top: 120px;
            padding-bottom: 130px;
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(
                    180deg,
                    #61c7df 0%,
                    #74d3eb 34%,
                    #5ec6df 72%,
                    #4cb7d1 100%
                );
            background-blend-mode: soft-light, normal;
        }

        .ol-couple::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: .12;
            background:
                radial-gradient(circle at 50% 16%, rgba(255,255,255,.20), transparent 32%);
        }

        .ol-couple .ol-title,
        .ol-couple .ol-label {
            color: #fffdf1;
        }

        .ol-couple .ol-note {
            color: rgba(255,255,255,.88);
        }

        .ol-couple-stage {
            width: min(100%, 960px);
            margin: 54px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 34px;
            align-items: stretch;
        }

        .ol-person-card {
            position: relative;
            min-height: 610px;
            padding: 52px 30px 38px;
            border-radius: 36px;
            overflow: hidden;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            background: linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.10));
            border: 1px solid rgba(255,255,255,.24);
            box-shadow: 0 26px 76px rgba(18,30,47,.16);
            backdrop-filter: blur(8px);
        }

        .ol-person-card > * {
            position: relative;
            z-index: 4;
        }

        .ol-person-card-bg {
            position: absolute;
            inset: 34px 24px 26px;
            z-index: 1;
            width: calc(100% - 48px);
            height: calc(100% - 60px);
            object-fit: contain;
            object-position: center;
            opacity: .42;
            pointer-events: none;
        }

        .ol-person-gold-corner {
            position: absolute;
            width: 82px;
            height: auto;
            z-index: 2;
            opacity: .88;
            pointer-events: none;
        }

        .ol-person-gold-corner.tl { top: 18px; left: 18px; }
        .ol-person-gold-corner.tr { top: 18px; right: 18px; transform: scaleX(-1); }
        .ol-person-gold-corner.bl { bottom: 18px; left: 18px; transform: scaleY(-1); }
        .ol-person-gold-corner.br { bottom: 18px; right: 18px; transform: scale(-1); }

        .ol-person-coral {
            position: absolute;
            bottom: 8px;
            width: 120px;
            height: auto;
            z-index: 2;
            opacity: .92;
            pointer-events: none;
        }

        .ol-person-coral.left {
            left: 0;
        }

        .ol-person-coral.right {
            right: 0;
            transform: scaleX(-1);
        }

        .ol-person-photo-wrap {
            position: relative;
            z-index: 4;
            width: min(100%, 215px);
            margin: 0 auto;
            padding: 8px;
            border-radius: 26px;
            background: rgba(255,255,255,.92);
            box-shadow: 0 20px 52px rgba(18,30,47,.16);
        }

        .ol-person-photo-wrap img,
        .ol-person-initial {
            width: 100%;
            aspect-ratio: 4 / 5;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 20px;
            background: color-mix(in srgb, var(--ol-gold) 16%, #fff);
            color: var(--ol-deep);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .ol-person-content {
            position: relative;
            z-index: 4;
            margin-top: 22px;
        }

        .ol-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 16px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--ol-deep);
            background: rgba(255,255,255,.84);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .ol-person-name {
            margin: 0;
            color: #fffdf1;
            font-family: Georgia, serif;
            font-size: clamp(2rem, 3.6vw, 3.2rem);
            line-height: 1.02;
            text-shadow: 0 8px 18px rgba(0,0,0,.14);
        }

        .ol-person-family {
            max-width: 340px;
            margin: 14px auto 0;
            color: rgba(255,255,255,.84);
            line-height: 1.75;
        }

        .ol-couple-heading-ornament {
            width: 150px;
            height: auto;
            margin: 12px auto 0;
            opacity: .95;
        }

        /* EVENT */
        .ol-event {
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(180deg, #f8f3dc, #e9fbfb 52%, #f7f0dc);
        }

        .ol-event::before {
            opacity: .22;
            background:
                url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center bottom / 100% auto no-repeat;
        }

        .ol-event-layout {
            width: min(100%, 1040px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: minmax(0, .96fr) minmax(340px, 1.04fr);
            gap: 34px;
            align-items: stretch;
        }

        .ol-event-layout.is-single {
            grid-template-columns: minmax(0, 760px);
            justify-content: center;
        }

        .ol-event-card,
        .ol-map-card {
            overflow: hidden;
            border-radius: 40px;
            background: linear-gradient(145deg, rgba(255,255,255,.90), rgba(255,249,230,.66));
            border: 1px solid rgba(40,58,83,.13);
            box-shadow: 0 28px 82px rgba(18,30,47,.10);
        }

        .ol-event-card {
            position: relative;
            padding: 58px 38px 50px;
            text-align: center;
        }

        .ol-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .22;
            background:
                url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center bottom / 120% auto no-repeat,
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 740px auto repeat;
        }

        .ol-event-card > * {
            position: relative;
            z-index: 2;
        }

        .ol-route-icon {
            width: 56px;
            height: 56px;
            object-fit: contain;
            margin: 0 auto 18px;
            opacity: .88;
        }

        .ol-event-card h3 {
            max-width: 440px;
            margin: 0 auto;
            color: var(--ol-deep);
            font-size: clamp(2.2rem, 4.2vw, 4.2rem);
        }

        .ol-date-split {
            width: min(100%, 520px);
            margin: 32px auto 24px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 22px;
            align-items: center;
        }

        .ol-date-side {
            color: #58616e;
            font-family: Georgia, serif;
            font-size: 1.08rem;
        }

        .ol-date-center {
            padding: 0 26px;
            border-left: 1px solid rgba(40,58,83,.25);
            border-right: 1px solid rgba(40,58,83,.25);
        }

        .ol-date-center b {
            display: block;
            color: var(--ol-deep);
            font-family: Georgia, serif;
            font-size: clamp(3rem, 6vw, 5.2rem);
            line-height: .9;
        }

        .ol-date-center span {
            display: block;
            margin-top: 10px;
            color: #58616e;
            font-weight: 700;
        }

        .ol-date-end-label {
            margin: 16px 0 10px;
            color: var(--ol-deep);
            font-size: .9rem;
            font-weight: 850;
            letter-spacing: .08em;
            text-transform: uppercase;
            opacity: .82;
        }

        .ol-event-line {
            margin-top: 20px;
            color: #4c5664;
            line-height: 1.85;
            font-weight: 750;
        }

        .ol-event-place {
            margin-top: 30px;
            color: #263242;
            font-weight: 950;
        }

        .ol-event-address {
            width: min(100%, 560px);
            margin: 10px auto 0;
            color: #58616e;
            line-height: 1.75;
        }

        .ol-event-actions {
            width: 100%;
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ol-map-card {
            min-height: 520px;
            display: flex;
            flex-direction: column;
        }

        .ol-map-frame,
        .ol-map-placeholder {
            width: 100%;
            height: 420px;
            min-height: 420px;
            border: 0;
            display: block;
        }

        .ol-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            background: #eef6f2;
        }

        .ol-map-pin {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: var(--ol-deep);
            color: #fff;
            font-size: 2rem;
        }

        .ol-map-footer {
            padding: 22px 26px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            text-align: left;
            background: rgba(255,255,255,.84);
            border-top: 1px solid rgba(40,58,83,.12);
        }

        .ol-map-title {
            margin: 0;
            color: #263242;
            font-weight: 950;
        }

        .ol-map-address {
            margin: 7px 0 0;
            color: #58616e;
            line-height: 1.65;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* GALLERY, GIFT, RSVP */
        .ol-gallery,
        .ol-gift,
        .ol-rsvp {
            background:
                url("{{ asset('assets/ocean-love/ol-pattern-overlay.png') }}") center / 520px auto repeat,
                linear-gradient(180deg, rgba(255,255,255,.88), rgba(235,251,251,.78));
        }

        .ol-gallery-grid {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 110px;
            gap: 12px;
        }

        .ol-gallery-item {
            display: block;
            overflow: hidden;
            padding: 6px;
            border-radius: 28px;
            background: rgba(255,255,255,.86);
            box-shadow: 0 14px 34px rgba(18,30,47,.08);
        }

        .ol-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; }
        .ol-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; }
        .ol-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; }
        .ol-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }

        .ol-gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            border-radius: 22px;
            transition: transform .7s ease;
        }

        .ol-gallery-item:hover img {
            transform: scale(1.055);
        }

        .ol-gift-grid {
            width: min(100%, 920px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .ol-gift-grid.is-single {
            grid-template-columns: minmax(0, 450px);
            justify-content: center;
        }

        .ol-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 34px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255,255,255,.88), rgba(255,249,230,.68));
            box-shadow: 0 18px 48px rgba(18,30,47,.08);
        }

        .ol-gift-card::before {
            content: "";
            position: absolute;
            inset: auto -20px -65px -20px;
            height: 140px;
            background: color-mix(in srgb, var(--ol-gold) 22%, transparent);
            transform: skewY(-7deg);
        }

        .ol-gift-title,
        .ol-gift-number,
        .ol-copy-btn {
            position: relative;
            z-index: 2;
        }

        .ol-gift-title {
            color: var(--ol-deep);
            font-weight: 950;
            font-size: 1.25rem;
        }

        .ol-gift-number {
            margin-top: 18px;
            color: #263242;
            font-weight: 950;
            font-size: clamp(1.5rem, 4vw, 2.4rem);
        }

        .ol-copy-btn {
            overflow: hidden;
            margin-top: 18px;
            padding: 12px 18px;
            border: 0;
            border-radius: 999px;
            font-weight: 950;
            cursor: pointer;
        }

        .ol-copy-btn.copied {
            background: #16803c;
            color: #fff;
        }

        .ol-rsvp-layout {
            width: min(100%, 1080px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(280px, .84fr) minmax(420px, 1.16fr);
            gap: 34px;
            align-items: start;
            text-align: left;
        }

        .ol-rsvp-copy {
            padding: 42px 34px;
            border-radius: 40px;
            background: linear-gradient(145deg, rgba(255,255,255,.82), rgba(255,249,230,.60));
            box-shadow: 0 18px 48px rgba(18,30,47,.08);
        }

        .ol-rsvp-copy h3 {
            font-size: clamp(2rem, 3.3vw, 3.4rem);
        }

        .ol-form-card {
            padding: 26px;
            border-radius: 28px;
            text-align: left;
            background: rgba(255,255,255,.88);
            box-shadow: 0 18px 48px rgba(18,30,47,.08);
        }

        .ol-form-label {
            display: block;
            color: var(--ol-deep);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
            text-align: left;
        }

        .ol-input {
            width: 100%;
            margin-top: 8px;
            padding: 13px 14px;
            border: 1px solid rgba(40,58,83,.14);
            border-radius: 14px;
            outline: none;
            background: rgba(255,255,255,.94);
            color: var(--ol-ink);
            text-align: left;
        }

        .ol-summary-grid {
            grid-column: 1 / -1;
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .ol-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 22px;
            background: rgba(255,255,255,.76);
        }

        .ol-summary-grid b {
            display: block;
            color: var(--ol-deep);
            font-size: 2rem;
        }

        .ol-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }

        .ol-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.82);
            box-shadow: 0 10px 24px rgba(18,30,47,.06);
        }

        /* CLOSING */
        .ol-closing {
            min-height: 880px;
            display: grid;
            place-items: center;
            color: #fff8e8;
            background:
                linear-gradient(180deg, rgba(8,16,32,.18), rgba(8,16,32,.38)),
                url("{{ asset('assets/ocean-love/ol-palace-night.png') }}") center bottom / cover no-repeat,
                var(--ol-night);
        }

        .ol-closing::before {
            z-index: 1;
            opacity: .90;
            background:
                url("{{ asset('assets/ocean-love/ol-floating-lanterns.png') }}") center top / 112% auto no-repeat;
        }

        .ol-closing::after {
            z-index: 2;
            opacity: .72;
            background:
                linear-gradient(180deg, rgba(5,14,28,.16), rgba(5,14,28,.52)),
                radial-gradient(circle at 50% 42%, rgba(255,255,255,.14), transparent 40%);
        }

        .ol-closing-card {
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

        .ol-closing-photo {
            width: min(210px, 58vw);
            height: auto;
            aspect-ratio: 4 / 5;
            margin: 0 auto 22px;
            object-fit: cover;
            border-radius: 28px;
            border: 8px solid rgba(255,255,255,.96);
            box-shadow: 0 22px 58px rgba(0,0,0,.26);
        }

        .ol-closing-card .ol-note:first-of-type {
            margin: 0 0 14px;
            color: #f7d778;
            font-weight: 800;
            letter-spacing: .04em;
            text-shadow: 0 2px 12px rgba(0,0,0,.45);
        }

        .ol-closing-card h2 {
            margin: 0;
            color: #fff8e8;
            -webkit-text-fill-color: #fff8e8;
            font-size: clamp(2.8rem, 6vw, 5.6rem);
            line-height: 1;
            text-shadow:
                0 2px 0 rgba(0,0,0,.18),
                0 8px 28px rgba(0,0,0,.42);
        }

        .ol-closing-card p {
            max-width: 760px;
            color: rgba(255,248,232,.96);
            line-height: 1.9;
            text-shadow: 0 2px 12px rgba(0,0,0,.42);
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(34px);
            filter: blur(7px);
            transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1);
            transition-delay: var(--reveal-delay, 0s);
        }

        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0, 0) scale(1);
            filter: blur(0);
        }

        @keyframes olShine {
            0%, 48% { left: -90%; }
            75%, 100% { left: 135%; }
        }

        @keyframes olFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes olLanternFloat {
            0%, 100% { transform: translateY(0) scale(1); opacity: .90; }
            25% { transform: translateY(-8px) scale(1.012); opacity: .96; }
            50% { transform: translateY(-16px) scale(1.018); opacity: 1; }
            75% { transform: translateY(-8px) scale(1.012); opacity: .96; }
        }

        @keyframes olLanternRise {
            0% {
                transform: translate(-50%, 0) rotate(var(--rot, 0deg)) scale(1);
                opacity: 0;
            }
            8% { opacity: var(--op, .65); }
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

        @keyframes olLanternSway {
            0%, 100% { margin-left: 0; }
            25% { margin-left: -8px; }
            50% { margin-left: 10px; }
            75% { margin-left: -6px; }
        }

        @media (max-width: 980px) {
            .ol-shell { padding: 14px; }
            .ol-page { padding: 90px 38px; }

            .ol-hero::before {
                background:
                    url("{{ asset('assets/ocean-love/ol-palace-tower.png') }}") center 20% / 210px auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center 56% / 150% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-ocean-carpet.png') }}") center bottom / 90% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-fountain.png') }}") center 68% / 90px auto no-repeat;
            }

            .ol-lantern-layer {
                inset: -3% -14%;
                background-size: 145% auto;
            }

            .ol-couple-stage,
            .ol-event-layout,
            .ol-rsvp-layout {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .ol-gift-grid { grid-template-columns: 1fr; }
            .ol-gallery-grid { grid-template-columns: repeat(6, 1fr); }

            .ol-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .ol-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .ol-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .ol-shell { padding: 0; }

            .ol-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .ol-page,
            .ol-page.slim {
                padding: 76px 22px;
            }

            .ol-floating-actions a,
            .ol-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .ol-hero {
                min-height: 100svh;
                padding: 56px 22px;
            }

            .ol-hero::before {
                background:
                    url("{{ asset('assets/ocean-love/ol-palace-tower.png') }}") center 20% / 170px auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center 60% / 205% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-ocean-carpet.png') }}") center bottom / 145% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-fountain.png') }}") center 70% / 70px auto no-repeat;
            }

            .ol-lantern-layer {
                inset: -2% -28%;
                opacity: .66;
                background-size: 190% auto;
                animation-duration: 8.8s;
            }

            .ol-hero-inner,
            .ol-closing-card {
                min-height: 78svh;
                padding-top: 10px;
            }

            .ol-hero-title {
                font-size: clamp(2.35rem, 10vw, 4.1rem);
                line-height: .86;
            }

            .ol-hero-name { line-height: .86; }
            .ol-hero-and { margin: 5px 0 7px; }

            .ol-hero-actions,
            .ol-event-actions {
                width: 100%;
                flex-direction: column;
                align-items: center;
            }

            .ol-btn,
            .ol-hero-actions .ol-btn,
            .ol-event-actions .ol-btn {
                width: min(100%, 280px);
                max-width: 280px;
            }

            .ol-invitation-card {
                padding: 44px 22px;
                border-radius: 32px;
            }

            .ol-save-date {
                min-height: 760px;
                padding: 80px 22px 100px;
            }

            .ol-count-panel {
                padding: 44px 20px;
                border-radius: 32px;
            }

            .ol-count-car {
                width: min(210px, 76%);
                margin-bottom: 18px;
            }

            .ol-count-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .ol-person-card {
                min-height: auto;
                padding: 36px 20px;
            }

            .ol-person-photo-wrap {
                width: 200px;
            }

            .ol-date-split {
                grid-template-columns: 1fr;
            }

            .ol-date-center {
                padding: 18px 0;
                border-left: 0;
                border-right: 0;
                border-top: 1px solid rgba(40,58,83,.25);
                border-bottom: 1px solid rgba(40,58,83,.25);
            }

            .ol-map-frame,
            .ol-map-placeholder {
                height: 320px;
                min-height: 320px;
            }

            .ol-map-footer {
                flex-direction: column;
            }

            .ol-gallery-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .ol-gallery-item,
            .ol-gallery-item:nth-child(n) {
                grid-column: auto;
                grid-row: auto;
                height: 270px;
            }

            .ol-rsvp-layout { gap: 22px; }

            .ol-rsvp-copy,
            .ol-form-card {
                padding: 26px 20px;
                border-radius: 28px;
            }

            .ol-summary-grid {
                grid-template-columns: 1fr;
            }

            .ol-section-lantern {
                width: calc(var(--size, 72px) * .78);
                opacity: calc(var(--op, .65) * .88);
            }

            .ol-closing::before {
                background:
                    url("{{ asset('assets/ocean-love/ol-floating-lanterns.png') }}") center top / 180% auto no-repeat;
            }

            .ol-hero {
                min-height: 100svh;
                padding: 38px 18px 42px;
                background:
                    linear-gradient(
                        180deg,
                        rgba(87, 189, 244, .78) 0%,
                        rgba(98, 202, 248, .66) 40%,
                        rgba(143, 226, 252, .52) 70%,
                        rgba(62, 171, 215, .76) 100%
                    ),
                    url("{{ asset('assets/ocean-love/ol-sky-ocean-gradient.png') }}") center top / cover no-repeat,
                    #63caff;
            }

            .ol-hero::before {
                background:
                    url("{{ asset('assets/ocean-love/ol-palace-tower.png') }}") center 30% / 180px auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-palace-ocean.png') }}") center 62% / 170% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-ocean-carpet.png') }}") center bottom / 120% auto no-repeat,
                    url("{{ asset('assets/ocean-love/ol-fountain.png') }}") center 72% / 88px auto no-repeat;
            }

            .ol-lantern-layer {
                opacity: .68;
                background-size: 185% auto;
                background-position: center top;
            }

            .ol-hero-inner {
                min-height: min(72vh, 580px);
                padding-top: 64px;
                gap: 5px;
            }

            .ol-hero-inner::before {
                content: none !important;
                display: none !important;
                opacity: 0 !important;
                background: none !important;
                filter: none !important;
            }

            .ol-hero-kicker {
                margin-bottom: 3px;
                font-size: 10px;
                letter-spacing: .18em;
            }

            .ol-hero-title {
                font-size: clamp(2.55rem, 12vw, 4.2rem);
                line-height: .76;
                letter-spacing: .025em;
            }

            .ol-hero-name {
                line-height: .76;
            }

            .ol-hero-and {
                margin: 0 0 2px;
                font-size: clamp(1.25rem, 6vw, 1.85rem);
                line-height: .65;
            }

            .ol-hero-date {
                margin-top: 8px;
                font-size: .78rem;
                letter-spacing: .18em;
            }

            .ol-hero-actions {
                margin-top: 12px;
                gap: 8px;
            }

            .ol-hero-actions .ol-btn {
                min-height: 42px;
                padding: 11px 18px;
                font-size: .82rem;
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

        /* Hilangkan semua layer gelap di area hero */
        .ol-hero::before,
        .ol-hero::after,
        .ol-hero-overlay,
        .ol-hero-panel,
        .ol-hero-inner,
        .ol-hero-content,
        .ol-hero-card,
        .ol-hero-box,
        .ol-hero-names {
            background: transparent !important;
            box-shadow: none !important;
            filter: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* Hilangkan bayangan pada teks hero */
        .ol-hero-kicker,
        .ol-hero-title,
        .ol-hero-and,
        .ol-hero-date,
        .ol-hero-name {
            text-shadow: none !important;
            filter: none !important;
        }

        /* FINAL FIX HERO OCEAN LOVE - hapus semua efek hitam */
        #opening.ol-hero .ol-hero-inner::before,
        #opening .ol-hero-inner::before {
            content: none !important;
            display: none !important;
            opacity: 0 !important;
            background: none !important;
            box-shadow: none !important;
            filter: none !important;
        }

        #opening.ol-hero .ol-hero-kicker,
        #opening.ol-hero .ol-hero-title,
        #opening.ol-hero .ol-hero-name,
        #opening.ol-hero .ol-hero-and,
        #opening.ol-hero .ol-hero-date,
        #opening .ol-hero-kicker,
        #opening .ol-hero-title,
        #opening .ol-hero-name,
        #opening .ol-hero-and,
        #opening .ol-hero-date {
            text-shadow: none !important;
            filter: none !important;
        }

        /* =====================================================
        FINAL FIX MOBILE HERO OCEAN LOVE - RAPATKAN NAMA
        Hanya berlaku di HP, desktop tidak berubah
        ===================================================== */

        @media (max-width: 640px) {
            #opening.ol-hero .ol-hero-inner {
                padding-top: 46px !important;
                gap: 0 !important;
                justify-content: flex-start !important;
            }

            #opening.ol-hero .ol-hero-kicker {
                margin: 0 0 14px !important;
                font-size: 10px !important;
                letter-spacing: .18em !important;
                line-height: 1.2 !important;
            }

            #opening.ol-hero .ol-hero-title {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: clamp(2.05rem, 8.6vw, 3.15rem) !important;
                line-height: .9 !important;
                letter-spacing: .015em !important;
                max-width: 92vw !important;
            }

            #opening.ol-hero .ol-hero-name {
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
                line-height: .9 !important;
            }

            #opening.ol-hero .ol-hero-and {
                display: block !important;
                margin: 1px 0 3px !important;
                padding: 0 !important;
                font-size: clamp(1.25rem, 5.4vw, 1.85rem) !important;
                line-height: .9 !important;
            }

            #opening.ol-hero .ol-hero-date {
                margin-top: 16px !important;
                font-size: .78rem !important;
                letter-spacing: .18em !important;
            }

            #opening.ol-hero .ol-hero-actions {
                margin-top: 18px !important;
                gap: 10px !important;
            }
        }

        @media (min-width: 641px) and (max-width: 980px) {
            #opening.ol-hero .ol-hero-title {
                font-size: clamp(2.6rem, 7.4vw, 4rem) !important;
                line-height: .88 !important;
                letter-spacing: .018em !important;
                max-width: 88vw !important;
            }

            #opening.ol-hero .ol-hero-name {
                line-height: .88 !important;
            }

            #opening.ol-hero .ol-hero-and {
                margin: 3px 0 5px !important;
                font-size: clamp(1.25rem, 3vw, 2rem) !important;
                line-height: .8 !important;
            }
        }

        /* ===============================
        FIX RSVP BUTTON CENTER
        ================================ */

        .ol-form-card .ol-btn,
        .ol-form-card button[type="submit"] {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 20px auto 0 !important;
            text-align: center !important;
            width: fit-content !important;
            min-width: 190px !important;
        }

        @media (max-width: 640px) {
            .ol-form-card .ol-btn,
            .ol-form-card button[type="submit"] {
                width: min(100%, 260px) !important;
                max-width: 260px !important;
            }
        }

        /* ===============================
        FIX CLOSING NOTE LEBIH TIPIS
        ================================ */

        .ol-closing-card > p.ol-note {
            font-weight: 400 !important;
            font-size: clamp(.95rem, 1.7vw, 1.08rem) !important;
            line-height: 1.85 !important;
            letter-spacing: .01em !important;
            color: rgba(255, 248, 232, .86) !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, .24) !important;
        }

        /* =====================================================
        FINAL FIX HERO NAME OCEAN LOVE
        Desktop tidak menumpuk, mobile maksimal 2 kata/baris
        ===================================================== */

        #opening.ol-hero .ol-hero-title {
            width: min(100%, 920px) !important;
            max-width: 920px !important;
            margin: 0 auto !important;
            padding: 0 18px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            font-size: clamp(3.2rem, 5.4vw, 5.6rem) !important;
            line-height: 1 !important;
            letter-spacing: .035em !important;
            text-align: center !important;
            overflow: visible !important;
            word-break: normal !important;
            overflow-wrap: normal !important;
            white-space: normal !important;
        }

        #opening.ol-hero .ol-hero-name {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1 !important;
            text-align: center !important;
            white-space: normal !important;
        }

        #opening.ol-hero .ol-hero-name-line {
            display: block !important;
            line-height: .96 !important;
            white-space: nowrap !important;
        }

        #opening.ol-hero .ol-hero-and {
            display: block !important;
            margin: -2px 0 0 !important;
            padding: 0 !important;
            font-size: clamp(1.35rem, 2.4vw, 2.1rem) !important;
            line-height: 1 !important;
            color: #f7d778 !important;
            -webkit-text-fill-color: #f7d778 !important;
        }

        /* Tablet */
        @media (min-width: 641px) and (max-width: 980px) {
            #opening.ol-hero .ol-hero-title {
                width: min(100%, 760px) !important;
                max-width: 760px !important;
                font-size: clamp(2.8rem, 6vw, 4.4rem) !important;
                gap: 8px !important;
                letter-spacing: .028em !important;
            }

            #opening.ol-hero .ol-hero-name-line {
                line-height: .96 !important;
            }

            #opening.ol-hero .ol-hero-and {
                margin: -1px 0 1px !important;
                font-size: clamp(1.25rem, 3vw, 1.8rem) !important;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            #opening.ol-hero .ol-hero-inner {
                padding-top: 54px !important;
                gap: 0 !important;
            }

            #opening.ol-hero .ol-hero-kicker {
                margin: 0 0 18px !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
                letter-spacing: .18em !important;
            }

            #opening.ol-hero .ol-hero-title {
                width: 100% !important;
                max-width: 94vw !important;
                padding: 0 8px !important;
                gap: 6px !important;
                font-size: clamp(2.05rem, 9.2vw, 3.05rem) !important;
                line-height: .96 !important;
                letter-spacing: .018em !important;
            }

            #opening.ol-hero .ol-hero-name {
                line-height: .96 !important;
            }

            #opening.ol-hero .ol-hero-name-line {
                display: block !important;
                line-height: .94 !important;
                white-space: nowrap !important;
            }

            #opening.ol-hero .ol-hero-and {
                margin: 0 !important;
                font-size: clamp(1.18rem, 5vw, 1.55rem) !important;
                line-height: 1 !important;
            }

            #opening.ol-hero .ol-hero-date {
                margin-top: 18px !important;
            }

            #opening.ol-hero .ol-hero-actions {
                margin-top: 16px !important;
            }
        }

        @media (max-width: 768px) {
            .ol-wave-divider {
                width: 160%;
            }

            .ol-palace-side {
                width: 150px;
                max-width: none;
                bottom: 48px;
                opacity: .18;
            }

            .ol-section-coral {
                width: 98px;
                bottom: 8px;
            }

            .ol-pearl-top-center {
                width: 58px;
                top: 18px;
            }

            .ol-gold-corner {
                width: 72px;
            }

            .ol-invite,
            .ol-save-date,
            .ol-couple {
                padding-top: 96px;
                padding-bottom: 120px;
            }

            .ol-invitation-card,
            .ol-count-panel {
                padding: 58px 24px 48px;
                border-radius: 28px;
            }

            .ol-couple-stage {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .ol-person-card {
                min-height: auto;
                padding: 42px 20px 30px;
                border-radius: 28px;
            }

            .ol-person-card-bg {
                inset: 24px 16px 20px;
                width: calc(100% - 32px);
                height: calc(100% - 44px);
            }
        }

    </style>
</head>

@php
    $olThemeKey = $invitation->theme_color ?: 'navy';

    $olThemes = [
        'maroon' => [
            'night' => '#241626',
            'teal' => '#0e7a83',
            'lavender' => '#b994bd',
            'deep' => '#7a3144',
            'ink' => '#2c2630',
            'gold' => '#e4c66a',
            'cream' => '#fff8df',
            'sky' => '#3e75a5',
            'pink' => '#cc8aae',
        ],
        'emerald' => [
            'night' => '#123334',
            'teal' => '#0b8f91',
            'lavender' => '#99b996',
            'deep' => '#28614f',
            'ink' => '#243333',
            'gold' => '#ddc567',
            'cream' => '#fff8df',
            'sky' => '#3e7895',
            'pink' => '#c98cae',
        ],
        'navy' => [
            'night' => '#0f2d4a',
            'teal' => '#0f8f9b',
            'lavender' => '#a8a6c9',
            'deep' => '#265f8e',
            'ink' => '#263242',
            'gold' => '#e4c75f',
            'cream' => '#fff7df',
            'sky' => '#3479ad',
            'pink' => '#cc8cb6',
        ],
        'rose' => [
            'night' => '#2f1d37',
            'teal' => '#12858f',
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

    $olTheme = $olThemes[$olThemeKey] ?? $olThemes['navy'];
@endphp

<body style="
    --ol-night: {{ $olTheme['night'] }};
    --ol-teal: {{ $olTheme['teal'] }};
    --ol-lavender: {{ $olTheme['lavender'] }};
    --ol-deep: {{ $olTheme['deep'] }};
    --ol-ink: {{ $olTheme['ink'] }};
    --ol-gold: {{ $olTheme['gold'] }};
    --ol-cream: {{ $olTheme['cream'] }};
    --ol-sky: {{ $olTheme['sky'] }};
    --ol-pink: {{ $olTheme['pink'] }};
">
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

    $splitHeroName = function ($name) {
        $words = preg_split('/\s+/', trim($name));

        if (!$words || count($words) <= 2) {
            return [trim($name)];
        }

        return array_map(function ($chunk) {
            return implode(' ', $chunk);
        }, array_chunk($words, 2));
    };

    $brideHeroLines = $splitHeroName($brideName);
    $groomHeroLines = $splitHeroName($groomName);

    $brideSubtitle = $bride->subtitle ?? 'Groom';
    $groomSubtitle = $groom->subtitle ?? 'Bride';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/ocean-love/ol-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;
    $hasDifferentEndDate = $endDate && $startDate && !$startDate->isSameDay($endDate);

    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Minggu';
    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '20 . 09 . 26';
    $eventEndDateShort = $endDate ? $endDate->format('d . m . y') : null;
    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : '20 September 2026';
    $eventMonthText = $startDate ? $startDate->translatedFormat('F') : 'September';
    $eventDayNumber = $startDate ? $startDate->format('d') : '20';
    $eventYearText = $startDate ? $startDate->translatedFormat('Y') : '2026';

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

    if ($invitation->event_end_time && $eventTimeText) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    } elseif ($invitation->event_end_time) {
        $eventTimeText = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Ocean Palace Wedding Hall';
    $addressText = $invitation->address ?: 'Jl. Ocean Palace Garden No. 21, Jakarta';
    $descriptionText = $invitation->description ?: 'With the blessing of God, we invite you to celebrate our wedding day in a beautiful ocean palace atmosphere.';

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

    if ($eventTimeText) $shareMessage .= "Waktu: {$eventTimeText}\n";
    if ($locationText) $shareMessage .= "Tempat: {$locationText}\n";
    if ($addressText) $shareMessage .= "Alamat: {$addressText}\n";
    if ($mapOpenUrl) $shareMessage .= "Maps: {$mapOpenUrl}\n";

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

    $singleLantern = asset('assets/ocean-love/ol-lantern-single.png');
@endphp

<div class="ol-shell">
    <main class="ol-book" id="top">
        <div class="ol-floating-actions" aria-label="Aksi undangan">
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

        <section id="opening" class="ol-page ol-hero">
            <div class="ol-hero-pattern"></div>
            <div class="ol-lantern-layer"></div>

            <div class="ol-hero-inner" data-reveal="zoom">
                <p class="ol-hero-kicker responsive-text">{{ $invitation->event_name ?: 'The Wedding Of' }}</p>

                <h1 class="ol-title ol-hero-title">
                    <span class="ol-hero-name">
                        @foreach ($brideHeroLines as $line)
                            <span class="ol-hero-name-line">{{ $line }}</span>
                        @endforeach
                    </span>

                    <span class="ol-hero-and">&</span>

                    <span class="ol-hero-name">
                        @foreach ($groomHeroLines as $line)
                            <span class="ol-hero-name-line">{{ $line }}</span>
                        @endforeach
                    </span>
                </h1>

                <p class="ol-hero-date responsive-text">{{ $eventDateShort }}</p>

                <div class="ol-hero-actions">
                    <a href="#invite" class="ol-btn gold">Buka Undangan</a>
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="ol-btn light">Simpan Tanggal</a>
                </div>
            </div>
        </section>

        <section id="invite" class="ol-page ol-invite ol-has-lanterns">

            <img src="{{ asset('assets/ocean-love/ol-palace-ocean-silhouette.png') }}" class="ol-palace-side left" alt="">
            <img src="{{ asset('assets/ocean-love/ol-palace-ocean-silhouette.png') }}" class="ol-palace-side right" alt="">
            <div class="ol-soft-bubbles"></div>

            <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-section-coral left" alt="">
            <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-section-coral right" alt="">

            <div class="ol-section-lanterns">
                @for ($i = 1; $i <= 8; $i++)
                    <img src="{{ $singleLantern }}" class="ol-section-lantern is-{{ $i }}" alt="">
                @endfor
            </div>

            <article class="ol-invitation-card" data-reveal="zoom">

                <p class="ol-label">Wedding Invitation</p>
                <h2 class="ol-title ol-script responsive-text">Invite</h2>

                <p class="ol-note responsive-text">
                    You are invited to our wedding celebration.
                </p>

                <p class="ol-note responsive-text">
                    {{ $descriptionText }}
                </p>

                <div style="margin-top:34px;">
                    <a href="#couple" class="ol-btn gold">Meet Bride & Groom</a>
                </div>
            </article>
        </section>

            <div class="ol-between-wave">
                <img src="{{ asset('assets/ocean-love/ol-ocean-wave-divider.png') }}" alt="">
            </div>

        <section id="countdown" class="ol-page ol-save-date ol-has-lanterns">

            <img src="{{ asset('assets/ocean-love/ol-palace-ocean-silhouette.png') }}" class="ol-palace-side left" alt="">
            <img src="{{ asset('assets/ocean-love/ol-palace-ocean-silhouette.png') }}" class="ol-palace-side right" alt="">
            <div class="ol-soft-bubbles"></div>

            <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-section-coral left" alt="">
            <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-section-coral right" alt="">

            <div class="ol-section-lanterns">
                @for ($i = 1; $i <= 8; $i++)
                    <img src="{{ $singleLantern }}" class="ol-section-lantern is-{{ $i }}" alt="">
                @endfor
            </div>

            <div class="ol-count-panel" data-reveal="zoom">

                <p class="ol-label">See The Route</p>
                <h2 class="ol-title ol-script ol-count-title responsive-text">Menuju Hari Bahagia</h2>

                <div class="ol-count-grid" data-countdown="{{ $targetDateTime }}">
                    <div class="ol-count-card">
                        <span class="ol-count-number" data-days>00</span>
                        <span class="ol-count-label">Hari</span>
                    </div>
                    <div class="ol-count-card">
                        <span class="ol-count-number" data-hours>00</span>
                        <span class="ol-count-label">Jam</span>
                    </div>
                    <div class="ol-count-card">
                        <span class="ol-count-number" data-minutes>00</span>
                        <span class="ol-count-label">Menit</span>
                    </div>
                    <div class="ol-count-card">
                        <span class="ol-count-number" data-seconds>00</span>
                        <span class="ol-count-label">Detik</span>
                    </div>
                </div>

                <p class="ol-note responsive-text" style="margin-top:28px;color:rgba(255,255,255,.92);font-weight:750;">
                    {{ $eventDateRangeText }}
                </p>

                <div class="ol-count-actions">
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="ol-btn gold">Simpan ke Kalender</a>
                </div>
            </div>
        </section>

            <div class="ol-between-wave">
                <img src="{{ asset('assets/ocean-love/ol-ocean-wave-divider.png') }}" alt="">
            </div>

        <section id="couple" class="ol-page ol-couple ol-has-lanterns">

            <div class="ol-soft-bubbles"></div>
            <div class="ol-section-lanterns">
                @for ($i = 1; $i <= 6; $i++)
                    <img src="{{ $singleLantern }}" class="ol-section-lantern is-{{ $i }}" alt="">
                @endfor
            </div>

            <p class="ol-label" data-reveal="zoom">Meet The</p>
            <h2 class="ol-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.4rem,5vw,4.8rem);text-transform:uppercase;color:#fffdf1;">
                Bride and Groom
            </h2>

            <img src="{{ asset('assets/ocean-love/ol-gold-line-ornament.png') }}" class="ol-couple-heading-ornament" alt="">

            <p class="ol-note responsive-text" data-reveal="zoom">
                Together with our families, we joyfully invite you to celebrate our wedding day.
            </p>

            <div class="ol-couple-stage">
                {{-- CARD 1 --}}
                <article class="ol-person-card" data-reveal="left">
                    <img src="{{ asset('assets/ocean-love/ol-bride-card-ornament-bg.png') }}" class="ol-person-card-bg" alt="">

                    <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-person-coral left" alt="">
                    <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-person-coral right" alt="">

                    <div class="ol-person-photo-wrap">
                        @if ($bridePhoto)
                            <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                        @else
                            <div class="ol-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                        @endif
                    </div>

                    <div class="ol-person-content">
                        <div class="ol-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                        <h3 class="ol-person-name responsive-text">{{ $brideName }}</h3>
                        <p class="ol-person-family responsive-text">
                            {{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}
                        </p>
                    </div>
                </article>

                {{-- CARD 2 --}}
                <article class="ol-person-card" data-reveal="right">
                    <img src="{{ asset('assets/ocean-love/ol-bride-card-ornament-bg.png') }}" class="ol-person-card-bg" alt="">

                    <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-person-coral left" alt="">
                    <img src="{{ asset('assets/ocean-love/ol-coral-shell-corner.png') }}" class="ol-person-coral right" alt="">

                    <div class="ol-person-photo-wrap">
                        @if ($groomPhoto)
                            <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                        @else
                            <div class="ol-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                        @endif
                    </div>

                    <div class="ol-person-content">
                        <div class="ol-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                        <h3 class="ol-person-name responsive-text">{{ $groomName }}</h3>
                        <p class="ol-person-family responsive-text">
                            {{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <section id="acara" class="ol-page ol-event">
            <p class="ol-label" data-reveal="zoom">Follow The Action</p>
            <h2 class="ol-title ol-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,5.2rem);">
                Detail Acara
            </h2>

            <div class="ol-event-layout {{ ($mapOpenUrl || $mapEmbedUrl) ? '' : 'is-single' }}">
                <article class="ol-event-card" data-reveal="left">
                    <img src="{{ asset('assets/ocean-love/ol-route-icon.png') }}" alt="Route" class="ol-route-icon">

                    <h3 class="ol-title ol-script responsive-text">Wedding Day</h3>

                    <div class="ol-date-split">
                        <div class="ol-date-side responsive-text">{{ $eventDayText }}</div>

                        <div class="ol-date-center">
                            <b>{{ $eventDayNumber }}</b>
                            <span>{{ $eventMonthText }} {{ $eventYearText }}</span>
                        </div>

                        <div class="ol-date-side responsive-text">{{ $eventDateShort }}</div>
                    </div>

                    @if ($hasDifferentEndDate)
                        <div class="ol-date-end-label">Sampai</div>

                        <div class="ol-date-split">
                            <div class="ol-date-side responsive-text">{{ $endDayText }}</div>

                            <div class="ol-date-center">
                                <b>{{ $endDayNumber }}</b>
                                <span>{{ $endMonthText }} {{ $endYearText }}</span>
                            </div>

                            <div class="ol-date-side responsive-text">
                                {{ $hasDifferentEndDate ? $eventEndDateShort : $eventDateShort }}
                            </div>
                        </div>
                    @endif

                    @if ($eventTimeText)
                        <p class="ol-event-line responsive-text">Pukul {{ $eventTimeText }}</p>
                    @endif

                    <p class="ol-event-place responsive-text">{{ $locationText }}</p>
                    <p class="ol-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="ol-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ol-btn">Google Maps</a>
                        @endif

                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ol-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="ol-map-card" data-reveal="right">
                        @if ($mapEmbedUrl)
                            <iframe
                                class="ol-map-frame"
                                src="{{ $mapEmbedUrl }}"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ol-map-placeholder">
                                <div>
                                    <div class="ol-map-pin">⌖</div>
                                    <strong class="responsive-text">{{ $locationText }}</strong>
                                </div>
                            </a>
                        @endif

                        <div class="ol-map-footer">
                            <div>
                                <p class="ol-map-title responsive-text">{{ $locationText }}</p>
                                <p class="ol-map-address responsive-text">{{ $addressText }}</p>
                            </div>

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="ol-btn">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @if ($galleryPhotos->count())
            <section id="galeri" class="ol-page ol-gallery slim">
                <p class="ol-label" data-reveal="zoom">Gallery</p>
                <h2 class="ol-title ol-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,5rem);">
                    Our Gallery
                </h2>

                <div class="ol-gallery-grid">
                    @foreach ($galleryPhotos as $photo)
                        @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp

                        @if ($src)
                            <a href="{{ $src }}" target="_blank" class="ol-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s">
                                <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($gifts->count())
            <section id="gift" class="ol-page ol-gift slim">
                <p class="ol-label" data-reveal="zoom">Wedding Gift</p>
                <h2 class="ol-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">
                    Wedding Gift
                </h2>

                <p class="ol-note responsive-text" data-reveal="zoom">
                    Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                </p>

                <div class="ol-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                    @foreach ($gifts as $gift)
                        <div class="ol-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                            <div class="ol-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>

                            <div class="ol-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>

                            <p class="responsive-text" style="position:relative;z-index:2;margin:12px 0 0;color:rgba(38,50,66,.72);">
                                {{ $gift->account_name ?? $eventTitle }}
                            </p>

                            <button type="button" class="ol-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">
                                Salin Nomor
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section id="rsvp" class="ol-page ol-rsvp slim">
            <p class="ol-label" data-reveal="zoom">RSVP</p>
            <h2 class="ol-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">
                RSVP Form
            </h2>

            <div class="ol-rsvp-layout">
                <div class="ol-rsvp-copy" data-reveal="left">
                    <h3 class="ol-title ol-script responsive-text">Kehadiran Anda</h3>

                    <p class="ol-note responsive-text" style="margin-left:0;">
                        Kami tidak sabar menunggu hari pernikahan kami bersama Anda. Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                    </p>
                </div>

                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="ol-form-card space-y-4" data-reveal="right">
                    @csrf

                    <div>
                        <label class="ol-form-label">Nama</label>
                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="ol-input" placeholder="Nama lengkap" required>
                    </div>

                    <div>
                        <label class="ol-form-label">Konfirmasi Kehadiran</label>
                        <select name="attendance_status" class="ol-input">
                            <option value="">Pilih status kehadiran</option>
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="ol-form-label">Jumlah Tamu</label>
                        <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="ol-input">
                    </div>

                    <div>
                        <label class="ol-form-label">Pesan</label>
                        <textarea name="message" rows="4" class="ol-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="ol-btn" style="width:100%;">
                        Kirim
                    </button>
                </form>

                <div class="ol-summary-grid" data-reveal="zoom">
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

                <div class="ol-message-list">
                    @forelse ($messages->take(5) as $message)
                        <div class="ol-message-card" data-reveal="zoom">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="responsive-text font-black" style="color:var(--ol-deep);">
                                        {{ $message->guest_name }}
                                    </p>

                                    <p class="text-xs mt-1" style="color:rgba(38,50,66,.58)">
                                        {{ $message->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if ($message->attendance_status)
                                    <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(38,95,142,.10);color:var(--ol-deep);">
                                        {{ str_replace('_', ' ', $message->attendance_status) }}
                                    </span>
                                @endif
                            </div>

                            <p class="responsive-text mt-3" style="color:rgba(38,50,66,.78);line-height:1.8;">
                                {{ $message->message }}
                            </p>
                        </div>
                    @empty
                        <div class="ol-message-card text-center" style="color:rgba(38,50,66,.66);">
                            Belum ada ucapan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="closing" class="ol-page ol-closing">
            <div class="ol-closing-card" data-reveal="zoom">

                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="ol-closing-photo">

                <h2 class="ol-title ol-script responsive-text">Thank You</h2>

                <p class="ol-note responsive-text">
                    Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.
                </p>

                <h3 class="ol-title responsive-text" style="margin-top:22px;font-size:clamp(2.2rem,5vw,4.6rem);color:#fff8e8;text-shadow:0 8px 28px rgba(0,0,0,.42);">
                    {{ $eventTitle }}
                </h3>
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
        const scrollSpeedPerSecond = 68;

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
                autoScrollFrame = null;
            }

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
                if (entry.isIntersecting) entry.target.classList.add('is-visible');
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            observer.observe(el);
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
