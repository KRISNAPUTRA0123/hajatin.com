<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Pastel Wedding'));
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

        :root {
            color-scheme: light;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--pw-ink);
            background:
                radial-gradient(circle at 10% 8%, var(--pw-glow), transparent 32%),
                radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--pw-accent) 14%, transparent), transparent 30%),
                radial-gradient(circle at 50% 88%, color-mix(in srgb, var(--pw-gold) 12%, transparent), transparent 36%),
                linear-gradient(180deg, var(--pw-bg1) 0%, var(--pw-bg2) 45%, var(--pw-bg3) 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
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

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .pw-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .pw-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 36px;
            isolation: isolate;
            background:
                linear-gradient(180deg, rgba(255,255,255,.86), color-mix(in srgb, var(--pw-soft) 86%, transparent)),
                url("{{ asset('assets/wedding-pastel-wedding/pastel-paper-texture.png') }}") center / cover repeat,
                linear-gradient(180deg, var(--pw-bg2) 0%, var(--pw-soft) 52%, var(--pw-bg3) 100%);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 18%, transparent);
            box-shadow: 0 40px 130px color-mix(in srgb, var(--pw-accent) 18%, transparent);
        }

        .pw-book::before,
        .pw-book::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .pw-book::before {
            opacity: .42;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-pattern-overlay.png') }}") center / 760px auto repeat,
                linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px) 0 0 / 46px 46px,
                linear-gradient(0deg, rgba(255,255,255,.07) 1px, transparent 1px) 0 0 / 46px 46px;
            mix-blend-mode: soft-light;
        }

        .pw-book::after {
            opacity: .46;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.90), transparent 34%),
                radial-gradient(circle at 84% 28%, color-mix(in srgb, var(--pw-gold) 15%, transparent), transparent 24%),
                radial-gradient(circle at 18% 72%, color-mix(in srgb, var(--pw-accent) 13%, transparent), transparent 28%);
        }

        .pw-book > * {
            position: relative;
            z-index: 2;
        }

        /* ===================== FLOATING ACTIONS ===================== */

        .pw-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(80, 90, 110, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(80,90,110,.13);
            backdrop-filter: blur(14px);
        }

        .pw-floating-actions a,
        .pw-floating-actions button {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 16px 0 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            background: rgba(255,255,255,.96);
            box-shadow: 0 10px 22px rgba(80,90,110,.10);
            transition: transform .25s ease, background .25s ease;
        }

        .pw-floating-actions a:hover,
        .pw-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .pw-floating-actions button.is-active {
            background: color-mix(in srgb, var(--pw-gold) 20%, white);
        }

        .pw-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        /* ===================== GENERAL ===================== */

        .pw-page {
            position: relative;
            min-height: auto;
            padding: 108px 74px;
            overflow: hidden;
            text-align: center;
        }

        .pw-page.slim {
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .pw-page > * {
            position: relative;
            z-index: 5;
        }

        .pw-page::before,
        .pw-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .pw-page::before {
            z-index: 1;
            opacity: .42;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-floral-top.png') }}") center top / 100% auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-floral-bottom.png') }}") center bottom / 100% auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-sparkle.png') }}") center / cover no-repeat;
        }

        .pw-page::after {
            z-index: 2;
            opacity: .22;
            background:
                linear-gradient(180deg, transparent, rgba(255,255,255,.64), transparent),
                url("{{ asset('assets/wedding-pastel-wedding/pastel-haze-soft.png') }}") center / cover no-repeat;
        }

        .pw-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--pw-accent);
            background: rgba(255,255,255,.78);
            border: 1px solid color-mix(in srgb, var(--pw-gold) 28%, transparent);
            box-shadow: 0 12px 28px rgba(80,90,110,.06);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .pw-label::before,
        .pw-label::after {
            content: "";
            width: 28px;
            height: 1px;
            background: var(--pw-accent);
            opacity: .42;
        }

        .pw-title {
            margin: 0;
            color: var(--pw-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.035em;
            line-height: .96;
            text-wrap: balance;
        }

        .pw-script {
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
        }

        .pw-note {
            max-width: 700px;
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--pw-ink) 78%, white);
            line-height: 1.9;
            font-weight: 400;
        }

        .pw-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 26px;
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, var(--pw-accent), color-mix(in srgb, var(--pw-accent) 72%, #ffffff));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--pw-accent) 20%, transparent);
            font-weight: 950;
            letter-spacing: .07em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .pw-btn:hover {
            transform: translateY(-2px);
        }

        .pw-btn.light {
            color: var(--pw-accent);
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 18%, transparent);
        }

        .pw-btn.gold {
            color: color-mix(in srgb, var(--pw-accent) 72%, #111);
            background: linear-gradient(135deg, var(--pw-gold), color-mix(in srgb, var(--pw-gold) 76%, white));
        }

        .pw-btn::after,
        .pw-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: pwShine 4.2s ease-in-out infinite;
        }

        /* ===================== HERO ===================== */

        .pw-hero {
            min-height: 900px;
            padding: 92px 72px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.96), rgba(255,255,255,.28) 46%, transparent 72%),
                linear-gradient(180deg, color-mix(in srgb, var(--pw-bg2) 90%, transparent), color-mix(in srgb, var(--pw-soft) 84%, transparent));
        }

        .pw-hero::before {
            opacity: .86;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-top.png') }}") center top / 100% auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-left.png') }}") left 12% / 470px auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-right.png') }}") right 58% / 500px auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-wave-bottom.png') }}") center bottom / 110% auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-sparkle.png') }}") center / cover no-repeat;
        }

        .pw-hero::after {
            opacity: .64;
            background:
                linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.50), rgba(255,255,255,.24)),
                url("{{ asset('assets/wedding-pastel-wedding/pastel-haze-soft.png') }}") center / cover no-repeat;
        }

        .pw-hero-inner {
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 180px 0 220px;
        }

        .pw-hero-rings {
            width: 84px;
            height: 84px;
            margin: 0 auto 24px;
            background: url("{{ asset('assets/wedding-pastel-wedding/pastel-rings-icon.png') }}") center / contain no-repeat;
            opacity: .92;
            filter: drop-shadow(0 10px 22px rgba(80,90,110,.12));
        }

        .pw-hero-kicker {
            color: var(--pw-accent);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .pw-hero-title {
            margin: 24px auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: clamp(3.6rem, 8vw, 7.6rem);
            color: var(--pw-accent);
            line-height: .86;
            text-align: center;
        }

        .pw-hero-name {
            display: block;
            margin: 0;
            line-height: .86;
        }

        .pw-hero-and {
            display: block;
            margin: 0 auto;
            color: var(--pw-gold);
            font-size: clamp(1.8rem, 3.2vw, 2.6rem);
            line-height: .8;
        }

        .pw-hero-date {
            margin-top: 28px;
            color: var(--pw-accent);
            font-size: 1.04rem;
            letter-spacing: .24em;
            font-weight: 850;
        }

        .pw-hero-actions {
            margin-top: 34px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===================== COUPLE ===================== */

        .pw-couple {
            background:
                linear-gradient(180deg, rgba(255,255,255,.70), color-mix(in srgb, var(--pw-soft) 84%, transparent));
        }

        .pw-couple-stage {
            width: min(100%, 980px);
            margin: 54px auto 0;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 24px;
            align-items: center;
        }

        .pw-person-card {
            position: relative;
            width: 100%;
            margin: 0 auto;
            padding: 42px 28px 46px;
            border-radius: 42px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.90), color-mix(in srgb, var(--pw-soft) 74%, rgba(255,255,255,.50)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 14%, transparent);
            box-shadow: 0 28px 80px color-mix(in srgb, var(--pw-accent) 12%, transparent);
            display: grid;
            place-items: center;
            text-align: center;
            overflow: hidden;
        }

        .pw-person-card::before {
            content: "";
            position: absolute;
            inset: 12px;
            opacity: .30;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-card-ornament.png') }}") center / contain no-repeat;
            pointer-events: none;
        }

        .pw-person-card::after {
            content: "";
            position: absolute;
            inset: auto -18px -70px -18px;
            height: 160px;
            opacity: .34;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-floral-bottom.png') }}") center bottom / 100% auto no-repeat;
            pointer-events: none;
        }

        .pw-person-frame {
            position: absolute;
            inset: 26px;
            opacity: .42;
            background: url("{{ asset('assets/wedding-pastel-wedding/pastel-photo-frame.png') }}") center / contain no-repeat;
            pointer-events: none;
        }

        .pw-person-photo-wrap {
            position: relative;
            z-index: 3;
            width: 245px;
            max-width: 100%;
            margin: 0 auto;
            padding: 8px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid color-mix(in srgb, var(--pw-accent) 12%, transparent);
            box-shadow: 0 22px 56px color-mix(in srgb, var(--pw-accent) 14%, transparent);
        }

        .pw-person-photo-wrap img,
        .pw-person-initial {
            width: 100%;
            aspect-ratio: 1 / 1;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px;
            background: var(--pw-soft);
            color: var(--pw-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .pw-person-content {
            position: relative;
            z-index: 4;
            margin-top: 28px;
        }

        .pw-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--pw-accent);
            background: rgba(255,255,255,.80);
            border: 1px solid color-mix(in srgb, var(--pw-gold) 25%, transparent);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .pw-person-name {
            margin: 10px 0 0;
            color: var(--pw-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(1.9rem, 4vw, 3.2rem);
            line-height: 1.08;
        }

        .pw-person-line {
            width: 180px;
            max-width: 70%;
            height: 1px;
            margin: 22px auto 0;
            background: var(--pw-gold);
            opacity: .58;
        }

        .pw-person-family {
            max-width: 440px;
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--pw-ink) 78%, white);
            line-height: 1.82;
        }

        .pw-couple-symbol {
            width: 78px;
            height: 78px;
            margin: 0 auto;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--pw-accent);
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--pw-gold) 24%, transparent);
            box-shadow: 0 20px 52px color-mix(in srgb, var(--pw-accent) 12%, transparent);
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            font-size: 3rem;
            z-index: 4;
        }

        /* ===================== INVITATION ===================== */

        .pw-invitation-card {
            width: min(100%, 860px);
            margin: 0 auto;
            padding: 58px 48px;
            border-radius: 42px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.88), color-mix(in srgb, var(--pw-soft) 76%, rgba(255,255,255,.52)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 28px 84px color-mix(in srgb, var(--pw-accent) 10%, transparent);
        }

        .pw-invitation-card h2 {
            font-size: clamp(2.6rem, 6vw, 5.8rem);
        }

        .pw-heart-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            background: url("{{ asset('assets/wedding-pastel-wedding/pastel-heart-icon.png') }}") center / contain no-repeat;
            opacity: .9;
        }

        /* ===================== EVENT ===================== */

        .pw-event-section::before {
            opacity: .46;
            background:
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-top.png') }}") center top / 100% auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-left.png') }}") left center / 330px auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-right.png') }}") right bottom / 380px auto no-repeat,
                url("{{ asset('assets/wedding-pastel-wedding/pastel-sparkle.png') }}") center / cover no-repeat;
        }

        .pw-event-layout {
            width: min(100%, 960px);
            margin: 46px auto 0;
            display: grid;
            gap: 28px;
        }

        .pw-event-layout-single {
            grid-template-columns: minmax(0, 660px);
            justify-content: center;
        }

        .pw-event-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 660px);
            margin: 0 auto;
            padding: 52px 38px;
            border-radius: 40px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.92), color-mix(in srgb, var(--pw-soft) 74%, rgba(255,255,255,.50)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 28px 82px color-mix(in srgb, var(--pw-accent) 12%, transparent);
            text-align: center;
        }

        .pw-event-card::before {
            content: "";
            position: absolute;
            inset: auto -18px -86px -18px;
            height: 210px;
            opacity: .30;
            background: url("{{ asset('assets/wedding-pastel-wedding/pastel-wave-bottom.png') }}") center bottom / 100% auto no-repeat;
            pointer-events: none;
        }

        .pw-event-icon {
            position: relative;
            z-index: 2;
            width: 74px;
            height: 74px;
            margin: 0 auto 18px;
            background: url("{{ asset('assets/wedding-pastel-wedding/pastel-rings-icon.png') }}") center / contain no-repeat;
            opacity: .9;
        }

        .pw-event-card h3 {
            position: relative;
            z-index: 2;
            color: var(--pw-accent);
            font-size: clamp(2.1rem, 5vw, 3.8rem);
        }

        .pw-date-split {
            position: relative;
            z-index: 2;
            margin: 28px auto 24px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 18px;
            align-items: center;
            width: min(100%, 420px);
        }

        .pw-date-until {
            position: relative;
            z-index: 2;
            width: fit-content;
            margin: 8px auto 16px;
            padding: 7px 18px;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(135deg, var(--pw-accent), color-mix(in srgb, var(--pw-accent) 72%, white));
            box-shadow: 0 12px 28px color-mix(in srgb, var(--pw-accent) 16%, transparent);
            font-size: .72rem;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .pw-date-split-end {
            margin-top: 0;
        }

        .pw-date-side {
            color: color-mix(in srgb, var(--pw-ink) 82%, white);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 1.1rem;
        }

        .pw-date-center {
            padding: 0 24px;
            border-left: 1px solid color-mix(in srgb, var(--pw-accent) 30%, transparent);
            border-right: 1px solid color-mix(in srgb, var(--pw-accent) 30%, transparent);
        }

        .pw-date-center b {
            display: block;
            color: var(--pw-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(3rem, 7vw, 5rem);
            line-height: .9;
        }

        .pw-date-center span {
            display: block;
            margin-top: 10px;
            color: color-mix(in srgb, var(--pw-ink) 78%, white);
            font-weight: 700;
        }

        .pw-event-line {
            position: relative;
            z-index: 2;
            margin-top: 18px;
            color: color-mix(in srgb, var(--pw-ink) 82%, white);
            line-height: 1.85;
            font-weight: 800;
            letter-spacing: .06em;
        }

        .pw-event-place {
            position: relative;
            z-index: 2;
            margin-top: 28px;
            color: var(--pw-ink);
            font-weight: 950;
        }

        .pw-event-address {
            position: relative;
            z-index: 2;
            margin-top: 10px;
            color: color-mix(in srgb, var(--pw-ink) 76%, white);
            line-height: 1.78;
        }

        .pw-event-actions {
            position: relative;
            z-index: 2;
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===================== MAP ===================== */

        .pw-map-card {
            width: min(100%, 760px);
            margin: 34px auto 0;
            border-radius: 34px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.92), color-mix(in srgb, var(--pw-soft) 74%, rgba(255,255,255,.50)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 22px 68px color-mix(in srgb, var(--pw-accent) 10%, transparent);
            overflow: hidden;
        }

        .pw-map-frame,
        .pw-map-placeholder {
            width: 100%;
            height: 360px;
            min-height: 360px;
            border: 0;
            display: block;
        }

        .pw-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            color: inherit;
            padding: 32px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--pw-accent) 12%, transparent), color-mix(in srgb, var(--pw-gold) 12%, transparent)),
                var(--pw-soft);
        }

        .pw-map-pin {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: var(--pw-accent);
            color: #fff;
            font-size: 2rem;
            box-shadow: 0 18px 40px color-mix(in srgb, var(--pw-accent) 20%, transparent);
        }

        .pw-map-footer {
            padding: 20px 24px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            background: rgba(255,255,255,.90);
            border-top: 1px solid color-mix(in srgb, var(--pw-accent) 12%, transparent);
            text-align: left;
        }

        .pw-map-title {
            margin: 0;
            color: var(--pw-ink);
            font-weight: 950;
        }

        .pw-map-address {
            margin: 7px 0 0;
            color: color-mix(in srgb, var(--pw-ink) 76%, white);
            line-height: 1.65;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* ===================== GALLERY ===================== */

        .pw-gallery-grid {
            width: min(100%, 980px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 108px;
            gap: 12px;
        }

        .pw-gallery-item {
            display: block;
            overflow: hidden;
            padding: 6px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 14px 34px color-mix(in srgb, var(--pw-accent) 8%, transparent);
            border-radius: 32px;
        }

        .pw-gallery-item:nth-child(1) {
            grid-column: span 5;
            grid-row: span 4;
            border-radius: 999px 999px 28px 28px;
        }

        .pw-gallery-item:nth-child(2) {
            grid-column: span 4;
            grid-row: span 2;
        }

        .pw-gallery-item:nth-child(3) {
            grid-column: span 3;
            grid-row: span 2;
            border-radius: 999px;
        }

        .pw-gallery-item:nth-child(n+4) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .pw-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: inherit;
            transition: transform .7s ease;
        }

        .pw-gallery-item:hover img {
            transform: scale(1.055);
        }

        /* ===================== GIFT ===================== */

        .pw-gift-grid {
            width: min(100%, 880px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .pw-gift-grid.is-single {
            grid-template-columns: minmax(0, 450px);
            justify-content: center;
        }

        .pw-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 30px;
            text-align: left;
            background:
                linear-gradient(145deg, rgba(255,255,255,.90), color-mix(in srgb, var(--pw-soft) 74%, rgba(255,255,255,.50)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 18px 48px color-mix(in srgb, var(--pw-accent) 9%, transparent);
        }

        .pw-gift-card::before {
            content: "";
            position: absolute;
            inset: auto -20px -65px -20px;
            height: 140px;
            background: color-mix(in srgb, var(--pw-gold) 18%, transparent);
            transform: skewY(-7deg);
        }

        .pw-gift-title,
        .pw-gift-number,
        .pw-copy-btn {
            position: relative;
            z-index: 2;
        }

        .pw-gift-title {
            color: var(--pw-accent);
            font-weight: 950;
            font-size: 1.2rem;
        }

        .pw-gift-number {
            margin-top: 18px;
            color: var(--pw-ink);
            font-weight: 950;
            font-size: clamp(1.5rem, 4vw, 2.3rem);
        }

        .pw-copy-btn {
            overflow: hidden;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            padding: 12px 18px;
            color: #fff;
            background: var(--pw-accent);
            font-weight: 950;
            cursor: pointer;
            letter-spacing: .06em;
        }

        .pw-copy-btn.copied {
            background: #16803c;
        }

        /* ===================== RSVP ===================== */

        .pw-rsvp-layout {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr);
            gap: 34px;
            align-items: start;
            text-align: left;
        }

        .pw-rsvp-copy {
            padding: 42px 34px;
            border-radius: 34px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.84), color-mix(in srgb, var(--pw-soft) 72%, rgba(255,255,255,.44)));
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 18px 48px color-mix(in srgb, var(--pw-accent) 8%, transparent);
        }

        .pw-rsvp-copy h3 {
            font-size: clamp(2.2rem, 4vw, 4rem);
        }

        .pw-form-card {
            padding: 26px;
            border-radius: 26px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 13%, transparent);
            box-shadow: 0 18px 48px color-mix(in srgb, var(--pw-accent) 8%, transparent);
            text-align: left;
        }

        .pw-form-label {
            display: block;
            color: var(--pw-accent);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
            text-align: left;
        }

        .pw-input {
            width: 100%;
            margin-top: 8px;
            border: 1px solid color-mix(in srgb, var(--pw-accent) 14%, transparent);
            background: rgba(255,255,255,.96);
            color: var(--pw-ink);
            border-radius: 14px;
            padding: 13px 14px;
            outline: none;
            text-align: left;
        }

        .pw-summary-grid {
            grid-column: 1 / -1;
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .pw-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 20px;
            background: rgba(255,255,255,.78);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 12%, transparent);
        }

        .pw-summary-grid b {
            display: block;
            color: var(--pw-accent);
            font-size: 2rem;
            line-height: 1;
        }

        .pw-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }

        .pw-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.84);
            border: 1px solid color-mix(in srgb, var(--pw-accent) 12%, transparent);
            box-shadow: 0 10px 24px color-mix(in srgb, var(--pw-accent) 6%, transparent);
        }

        /* ===================== CLOSING ===================== */

        .pw-closing-card {
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 80px 34px 220px;
            text-align: center;
        }

        .pw-closing-card h2 {
            font-size: clamp(3rem, 7vw, 6.5rem);
        }

        .pw-closing-photo {
            width: 210px;
            height: 210px;
            margin: 0 auto 28px;
            object-fit: cover;
            display: block;
            border-radius: 999px;
            border: 8px solid #fff;
            outline: 1px solid color-mix(in srgb, var(--pw-accent) 18%, transparent);
            box-shadow: 0 20px 52px color-mix(in srgb, var(--pw-accent) 14%, transparent);
        }

        /* ===================== ANIMATION ===================== */

        [data-reveal] {
            opacity: 0;
            transform: translateY(34px);
            filter: blur(7px);
            transition:
                opacity .85s cubic-bezier(.2,.8,.2,1),
                transform .85s cubic-bezier(.2,.8,.2,1),
                filter .85s cubic-bezier(.2,.8,.2,1);
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
            transform: translate(0,0) scale(1);
            filter: blur(0);
        }

        @keyframes pwShine {
            0%, 48% {
                left: -90%;
            }

            75%, 100% {
                left: 135%;
            }
        }

        @keyframes pwFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .pw-floating-actions a,
        .pw-floating-actions button {
            animation: pwFloat 4.4s ease-in-out infinite;
        }

        /* ===================== RESPONSIVE ===================== */

        @media (min-width: 1440px) {
            .pw-shell {
                width: min(100%, 1280px);
            }

            .pw-page {
                padding-left: 90px;
                padding-right: 90px;
            }

            .pw-hero-title {
                font-size: clamp(5rem, 7vw, 8.4rem);
            }
        }

        @media (max-width: 980px) {
            .pw-shell {
                padding: 14px;
            }

            .pw-page {
                padding: 90px 38px;
            }

            .pw-hero {
                min-height: 820px;
                padding: 86px 38px 0;
            }

            .pw-hero::before {
                background-size: 120% auto, 390px auto, 420px auto, 130% auto, cover;
                background-position: center top, left 10%, right 58%, center bottom, center;
            }

            .pw-hero-inner {
                padding-top: 150px;
                padding-bottom: 200px;
            }

            .pw-couple-stage {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .pw-couple-symbol {
                margin: -4px auto;
            }

            .pw-rsvp-layout {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .pw-gift-grid {
                grid-template-columns: 1fr;
            }

            .pw-gallery-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .pw-gallery-item:nth-child(1) {
                grid-column: span 3;
                grid-row: span 3;
            }

            .pw-gallery-item:nth-child(2) {
                grid-column: span 3;
                grid-row: span 2;
            }

            .pw-gallery-item:nth-child(n+3) {
                grid-column: span 2;
                grid-row: span 2;
            }
        }

        @media (max-width: 640px) {
            .pw-shell {
                padding: 0;
            }

            .pw-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .pw-page,
            .pw-page.slim {
                padding: 76px 22px;
            }

            .pw-date-until {
                margin: 4px auto 14px;
                font-size: .68rem;
                letter-spacing: .1em;
            }

            .pw-date-split-end {
                margin-top: 0;
            }

            .pw-floating-actions {
                right: 0;
                gap: 7px;
            }

            .pw-floating-actions a,
            .pw-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .pw-hero {
                min-height: 100svh;
                padding: 72px 22px 0;
            }

            .pw-hero::before {
                opacity: .82;
                background:
                    url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-top.png') }}") center top / 132% auto no-repeat,
                    url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-left.png') }}") left 10% / 270px auto no-repeat,
                    url("{{ asset('assets/wedding-pastel-wedding/pastel-silk-right.png') }}") right 62% / 280px auto no-repeat,
                    url("{{ asset('assets/wedding-pastel-wedding/pastel-wave-bottom.png') }}") center bottom / 160% auto no-repeat,
                    url("{{ asset('assets/wedding-pastel-wedding/pastel-sparkle.png') }}") center / cover no-repeat;
            }

            .pw-hero::after {
                opacity: .68;
            }

            .pw-hero-inner {
                padding-top: 124px;
                padding-bottom: 200px;
            }

            .pw-hero-title {
                font-size: clamp(3.2rem, 14vw, 5.1rem);
                gap: 2px;
                line-height: .88;
            }

            .pw-hero-name {
                line-height: .88;
            }

            .pw-hero-and {
                font-size: clamp(1.7rem, 7vw, 2.2rem);
            }

            .pw-hero-actions {
                flex-direction: column;
            }

            .pw-hero-actions .pw-btn {
                width: 100%;
            }

            .pw-label {
                font-size: 10px;
                letter-spacing: .14em;
            }

            .pw-label::before,
            .pw-label::after {
                width: 18px;
            }

            .pw-person-card {
                padding: 34px 20px;
                border-radius: 32px;
            }

            .pw-person-photo-wrap {
                width: 200px;
            }

            .pw-date-split {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .pw-date-center {
                border-left: 0;
                border-right: 0;
                border-top: 1px solid color-mix(in srgb, var(--pw-accent) 25%, transparent);
                border-bottom: 1px solid color-mix(in srgb, var(--pw-accent) 25%, transparent);
                padding: 18px 0;
            }

            .pw-map-frame,
            .pw-map-placeholder {
                height: 320px;
                min-height: 320px;
            }

            .pw-map-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .pw-map-footer .pw-btn {
                width: 100%;
            }

            .pw-gallery-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .pw-gallery-item,
            .pw-gallery-item:nth-child(n) {
                grid-column: auto;
                grid-row: auto;
                height: 270px;
            }

            .pw-rsvp-layout {
                gap: 22px;
            }

            .pw-rsvp-copy,
            .pw-form-card {
                padding: 26px 20px;
                border-radius: 28px;
            }

            .pw-summary-grid {
                grid-template-columns: 1fr;
            }

            .pw-btn {
                width: 100%;
            }

            .pw-event-layout-single {
                grid-template-columns: 1fr;
            }

            .pw-event-card {
                width: 100%;
                padding: 38px 20px;
                border-radius: 30px;
            }

            .pw-event-card h3 {
                font-size: clamp(2.2rem, 12vw, 3.4rem);
            }

            .pw-event-icon {
                width: 56px;
                height: 56px;
                margin-bottom: 14px;
            }

            .pw-event-actions {
                flex-direction: column;
            }

            .pw-event-actions .pw-btn {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
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
    </style>

    @php
        /*
        |--------------------------------------------------------------------------
        | Data utama
        |--------------------------------------------------------------------------
        */

        $themeColor = $invitation->theme_color ?? 'rose';
        if ($themeColor === 'golden') {
            $themeColor = 'gold';
        }

        /*
        |--------------------------------------------------------------------------
        | Tetap 6 theme bawaan editor:
        | maroon, emerald, navy, rose, gold, slate
        | Tidak menambah value theme baru.
        |--------------------------------------------------------------------------
        */

        $pwThemes = [
            'maroon' => [
                'accent' => '#8b4f63',
                'gold'   => '#e7c977',
                'ink'    => '#3f2b34',
                'soft'   => '#fff1f5',
                'bg1'    => '#f7dfe8',
                'bg2'    => '#fff9fb',
                'bg3'    => '#ead1dc',
                'glow'   => 'rgba(222, 143, 171, .24)',
            ],

            'emerald' => [
                'accent' => '#5b8b78',
                'gold'   => '#e8cf89',
                'ink'    => '#263b34',
                'soft'   => '#f2fbf6',
                'bg1'    => '#dcefe7',
                'bg2'    => '#ffffff',
                'bg3'    => '#cfe6db',
                'glow'   => 'rgba(91, 139, 120, .20)',
            ],

            'navy' => [
                'accent' => '#52749c',
                'gold'   => '#ead08a',
                'ink'    => '#223246',
                'soft'   => '#f2f7ff',
                'bg1'    => '#dbe9fa',
                'bg2'    => '#ffffff',
                'bg3'    => '#cadcf2',
                'glow'   => 'rgba(82, 116, 156, .20)',
            ],

            'rose' => [
                'accent' => '#b86d8c',
                'gold'   => '#e8c77a',
                'ink'    => '#4b2e3d',
                'soft'   => '#fff5f8',
                'bg1'    => '#f8dce8',
                'bg2'    => '#ffffff',
                'bg3'    => '#f0cadb',
                'glow'   => 'rgba(184, 109, 140, .22)',
            ],

            'gold' => [
                'accent' => '#b08b57',
                'gold'   => '#f1d98e',
                'ink'    => '#423629',
                'soft'   => '#fff9ec',
                'bg1'    => '#f3e8cd',
                'bg2'    => '#ffffff',
                'bg3'    => '#ead9b4',
                'glow'   => 'rgba(176, 139, 87, .20)',
            ],

            'slate' => [
                'accent' => '#7b8195',
                'gold'   => '#e8cf89',
                'ink'    => '#313541',
                'soft'   => '#f6f7fb',
                'bg1'    => '#e7e9f1',
                'bg2'    => '#ffffff',
                'bg3'    => '#d8dce8',
                'glow'   => 'rgba(123, 129, 149, .20)',
            ],
        ];

        $pwTheme = $pwThemes[$themeColor] ?? $pwThemes['rose'];

        $photos = ($invitation->photos ?? collect())->values();
        $firstPhoto = $photos->first();
        $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
        $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;

        $people = ($invitation->people ?? collect())->values();
        $gifts = $invitation->gifts ?? collect();
        $messages = $invitation->messages ?? collect();

        $eventTitle = $invitation->title ?: 'Aurelia & Naufal';
        $eventName = $invitation->event_name ?: 'The Wedding Of';
        $hostName = $invitation->host_name ?: 'Keluarga Besar';

        $bride = $people->get(0);
        $groom = $people->get(1);

        $titleParts = str_contains($eventTitle, '&')
            ? array_map('trim', explode('&', $eventTitle, 2))
            : [];

        $brideName = $bride->name ?? ($titleParts[0] ?? 'Aurelia Putri');
        $groomName = $groom->name ?? ($titleParts[1] ?? 'Naufal Pratama');

        $brideSubtitle = $bride->subtitle ?? 'Mempelai Wanita';
        $groomSubtitle = $groom->subtitle ?? 'Mempelai Pria';

        $personPhotoUrl = function ($person, $fallback) {
            $path = $person->photo ?? $person->image ?? null;

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

        $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date) : null;
        $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date) : null;

        $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : 'Tanggal belum diatur';
        $eventDateShort = $startDate ? $startDate->format('d . m . y') : 'Tanggal belum diatur';
        $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Hari belum diatur';

        $hasDifferentEndDate = !empty($invitation->event_end_date)
            && $endDate
            && $startDate
            && !$startDate->isSameDay($endDate);

        $eventEndDateText = $hasDifferentEndDate
            ? $endDate->translatedFormat('d F Y')
            : null;

        $eventEndDateShort = $hasDifferentEndDate
            ? $endDate->format('d . m . y')
            : null;

        $eventEndDayText = $hasDifferentEndDate
            ? $endDate->translatedFormat('l')
            : null;

        $eventDateRangeText = $eventDateText;

        if ($startDate && $endDate) {
            if ($startDate->isSameDay($endDate)) {
                $eventDateRangeText = $startDate->translatedFormat('d F Y');
            } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y');
            } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y');
            } else {
                $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
            }
        }

        $eventTimeText = $invitation->event_time
            ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
            : null;

        if ($invitation->event_end_time) {
            $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
        }

        $locationText = $invitation->location_name ?: 'Lokasi acara belum diatur';
        $addressText = trim($invitation->address ?: 'Alamat lengkap belum ditambahkan.');

        $mapOpenUrl = isset($mapData)
            ? ($mapData['open_url'] ?? $invitation->maps_url)
            : $invitation->maps_url;

        $mapEmbedUrl = isset($mapData)
            ? ($mapData['embed_url'] ?? null)
            : null;

        $countdownTarget = null;

        if ($startDate) {
            $datePart = $startDate->format('Y-m-d');
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

        $shareUrl = route('invitation.public', $invitation->slug);

        $googleCalendarUrl = null;

        if ($startDate) {
            try {
                $startDateTime = \Carbon\Carbon::parse(
                    $startDate->format('Y-m-d') . ' ' .
                    ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00')
                );

                $endDateValue = $endDate ? $endDate->format('Y-m-d') : $startDate->format('Y-m-d');

                $endDateTime = $invitation->event_end_time
                    ? \Carbon\Carbon::parse($endDateValue . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s'))
                    : $startDateTime->copy()->addHours(3);

                if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                    $endDateTime = $startDateTime->copy()->addHours(3);
                }

                $calendarDetails = trim(($invitation->description ?: 'Undangan pernikahan') . "\n\nLink Undangan: " . $shareUrl);

                $calendarLocation = trim(
                    ($invitation->location_name ?: '') .
                    ($invitation->address ? ' - ' . $invitation->address : '')
                );

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

        $shareMessage = "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
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

        $coverPhoto = $invitation->cover_image ? asset('storage/' . $invitation->cover_image) : null;
        $defaultCover = asset('assets/wedding-pastel-wedding/pastel-couple-placeholder.png');
        $coverDisplay = $coverPhoto ?: $defaultCover;

        $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
        $groomPhoto = $personPhotoUrl($groom, $coverDisplay);

        $momentPhotoUrl = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
        $closingPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;
    @endphp
</head>

<body style="
    --pw-accent: {{ $pwTheme['accent'] }};
    --pw-gold: {{ $pwTheme['gold'] }};
    --pw-ink: {{ $pwTheme['ink'] }};
    --pw-soft: {{ $pwTheme['soft'] }};
    --pw-bg1: {{ $pwTheme['bg1'] }};
    --pw-bg2: {{ $pwTheme['bg2'] }};
    --pw-bg3: {{ $pwTheme['bg3'] }};
    --pw-glow: {{ $pwTheme['glow'] }};
">
    <div class="pw-floating-actions">
        <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
            <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan">
        </a>

        <button type="button" id="music-toggle" title="Music">
            <img
                src="{{ asset('assets/icons/music-off.png') }}"
                data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                alt="Music"
            >
        </button>

        <button type="button" id="scroll-toggle" title="Auto Scroll">
            <img
                src="{{ asset('assets/icons/scroll-off.png') }}"
                data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                alt="Auto Scroll"
            >
        </button>

        @if ($mapOpenUrl)
            <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi">
            </a>
        @endif
    </div>

    <audio
        id="invitation-music"
        src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}"
        preload="auto"
        loop>
    </audio>

    <main class="pw-shell">
        <div class="pw-book">
            <section id="cover" class="pw-page pw-hero">
                <div class="pw-hero-inner" data-reveal="zoom">
                    <div class="pw-hero-rings"></div>

                    <div class="pw-hero-kicker responsive-text">
                        {{ $eventName }}
                    </div>

                    <h1 class="pw-title pw-hero-title">
                        <span class="pw-hero-name responsive-text">{{ $brideName }}</span>
                        <span class="pw-script pw-hero-and">&</span>
                        <span class="pw-hero-name responsive-text">{{ $groomName }}</span>
                    </h1>

                    <div class="pw-hero-date responsive-text">
                        {{ $eventDateShort }}
                    </div>

                    <div class="pw-hero-actions">
                        <a href="#mempelai" class="pw-btn gold">
                            Buka Undangan
                        </a>

                        @if ($googleCalendarUrl)
                            <a href="{{ $googleCalendarUrl }}" target="_blank" class="pw-btn light">
                                Simpan Tanggal
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <section id="mempelai" class="pw-page pw-couple">
                <p class="pw-label" data-reveal="zoom">
                    Bride & Groom
                </p>

                <h2
                    class="pw-title responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,6rem);">
                    Mempelai
                </h2>

                <p class="pw-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    Dengan penuh rasa syukur, kami memperkenalkan kedua mempelai yang akan melangsungkan pernikahan.
                </p>

                <div class="pw-couple-stage">
                    <article class="pw-person-card" data-reveal="left">
                        <div class="pw-person-frame"></div>

                        <div class="pw-person-photo-wrap">
                            @if ($bridePhoto)
                                <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                            @else
                                <div class="pw-person-initial">
                                    {{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="pw-person-content">
                            <div class="pw-person-subtitle responsive-text">
                                {{ $brideSubtitle }}
                            </div>

                            <h3 class="pw-person-name responsive-text">
                                {{ $bride->name ?? $brideName }}
                            </h3>

                            <div class="pw-person-line"></div>

                            <p class="pw-person-family responsive-text">
                                {{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}
                            </p>
                        </div>
                    </article>

                    <div class="pw-couple-symbol" data-reveal="zoom">
                        &
                    </div>

                    <article class="pw-person-card" data-reveal="right">
                        <div class="pw-person-frame"></div>

                        <div class="pw-person-photo-wrap">
                            @if ($groomPhoto)
                                <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                            @else
                                <div class="pw-person-initial">
                                    {{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="pw-person-content">
                            <div class="pw-person-subtitle responsive-text">
                                {{ $groomSubtitle }}
                            </div>

                            <h3 class="pw-person-name responsive-text">
                                {{ $groom->name ?? $groomName }}
                            </h3>

                            <div class="pw-person-line"></div>

                            <p class="pw-person-family responsive-text">
                                {{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section id="invitation" class="pw-page slim">
                <div class="pw-invitation-card" data-reveal="zoom">
                    <div class="pw-heart-icon"></div>

                    <p class="pw-label">
                        Wedding Invitation
                    </p>

                    <h2 class="pw-title pw-script responsive-text">
                        Undangan Pernikahan
                    </h2>

                    <p class="pw-note responsive-text">
                        {{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan kami. Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.' }}
                    </p>
                </div>
            </section>

            <section id="acara" class="pw-page pw-event-section">
                <p class="pw-label" data-reveal="zoom">
                    Wedding Event
                </p>

                <h2
                    class="pw-title responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,6rem);">
                    Detail Acara
                </h2>

                <p class="pw-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    Acara pernikahan kami akan dilaksanakan pada:
                </p>

                <div class="pw-event-layout pw-event-layout-single">
                    <div class="pw-event-card" data-reveal="zoom">
                        <div class="pw-event-icon"></div>

                        <h3 class="pw-title responsive-text">
                            Pernikahan
                        </h3>

                        <div class="pw-date-split">
                            <div class="pw-date-side">
                                {{ $eventDayText }}
                            </div>

                            <div class="pw-date-center">
                                <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                                <span>{{ $startDate ? $startDate->translatedFormat('F Y') : '' }}</span>
                            </div>

                            <div class="pw-date-side">
                                {{ $eventDateShort }}
                            </div>
                        </div>

                        @if ($hasDifferentEndDate)
                            <div class="pw-date-until">
                                Sampai
                            </div>

                            <div class="pw-date-split pw-date-split-end">
                                <div class="pw-date-side">
                                    {{ $eventEndDayText }}
                                </div>

                                <div class="pw-date-center">
                                    <b>{{ $endDate ? $endDate->format('d') : '--' }}</b>
                                    <span>{{ $endDate ? $endDate->translatedFormat('F Y') : '' }}</span>
                                </div>

                                <div class="pw-date-side">
                                    {{ $eventEndDateShort }}
                                </div>
                            </div>
                        @endif

                        @if ($eventTimeText)
                            <p class="pw-event-line">
                                Pukul {{ $eventTimeText }}
                            </p>
                        @endif

                        <p class="pw-event-place responsive-text">
                            {{ $locationText }}
                        </p>

                        <p class="pw-event-address responsive-text">
                            {!! nl2br(e($addressText)) !!}
                        </p>

                        <div class="pw-event-actions">
                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="pw-btn">
                                    Petunjuk Arah
                                </a>
                            @endif

                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="pw-btn light">
                                    Calendar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($mapOpenUrl)
                    <div class="pw-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe
                                src="{{ $mapEmbedUrl }}"
                                class="pw-map-frame"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <a
                                href="{{ $mapOpenUrl }}"
                                target="_blank"
                                class="pw-map-placeholder"
                                aria-label="Buka lokasi di Google Maps">
                                <div>
                                    <div class="pw-map-pin">⌖</div>

                                    <p class="pw-map-title responsive-text">
                                        {{ $locationText }}
                                    </p>

                                    <p class="pw-map-address responsive-text">
                                        Klik untuk membuka lokasi asli di Google Maps.
                                    </p>
                                </div>
                            </a>
                        @endif

                        <div class="pw-map-footer">
                            <div>
                                <p class="pw-map-title responsive-text">
                                    {{ $locationText }}
                                </p>

                                <p class="pw-map-address responsive-text">
                                    {!! nl2br(e($addressText)) !!}
                                </p>
                            </div>

                            <a href="{{ $mapOpenUrl }}" target="_blank" class="pw-btn">
                                Maps
                            </a>
                        </div>
                    </div>
                @endif
            </section>

            @if ($photos->count())
                <section id="galeri" class="pw-page slim">
                    <p class="pw-label" data-reveal="zoom">
                        Our Gallery
                    </p>

                    <h2
                        class="pw-title pw-script responsive-text"
                        data-reveal="zoom"
                        style="font-size:clamp(2.8rem,6vw,6rem);">
                        Precious Moment
                    </h2>

                    <div class="pw-gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <a
                                href="{{ asset('storage/' . $photo->image_path) }}"
                                target="_blank"
                                class="pw-gallery-item"
                                data-reveal="zoom"
                                style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <img
                                    src="{{ asset('storage/' . $photo->image_path) }}"
                                    alt="Galeri {{ $index + 1 }}">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="pw-page slim">
                    <p class="pw-label" data-reveal="zoom">
                        Wedding Gift
                    </p>

                    <h2
                        class="pw-title pw-script responsive-text"
                        data-reveal="zoom"
                        style="font-size:clamp(2.8rem,6vw,6rem);">
                        Tanda Kasih
                    </h2>

                    <p class="pw-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>

                    <div class="pw-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            <div
                                class="pw-gift-card"
                                data-reveal="zoom"
                                style="--reveal-delay: {{ min($index * .05, .2) }}s">
                                <div class="pw-gift-title responsive-text">
                                    {{ $gift->bank_name ?? $gift->type ?? $gift->label ?? 'Hadiah' }}
                                </div>

                                <div class="pw-gift-number responsive-text">
                                    {{ $gift->account_number ?? $gift->value ?? '-' }}
                                </div>

                                <p
                                    class="responsive-text"
                                    style="position:relative;z-index:2;margin-top:10px;color:color-mix(in srgb, var(--pw-ink) 76%, white);">
                                    {{ $gift->account_name ?? $gift->holder_name ?? $gift->description ?? '' }}
                                </p>

                                @if ($gift->account_number ?? $gift->value ?? null)
                                    <button
                                        type="button"
                                        class="pw-copy-btn"
                                        data-copy="{{ $gift->account_number ?? $gift->value }}">
                                        Salin Nomor
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="pw-page slim">
                <p class="pw-label" data-reveal="zoom">
                    Reservation Reply
                </p>

                <h2
                    class="pw-title responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,6rem);">
                    RSVP
                </h2>

                <div class="pw-rsvp-layout">
                    <div class="pw-rsvp-copy" data-reveal="left">
                        <h3 class="pw-title pw-script responsive-text">
                            Kirim Pesan
                        </h3>

                        <p class="pw-note responsive-text" style="margin-left:0;">
                            Silakan kirim ucapan dan konfirmasi kehadiran Anda. Setiap doa baik akan menjadi kenangan indah bagi kami.
                        </p>
                    </div>

                    <div data-reveal="right">
                        @if (session('message_success'))
                            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
                                {{ session('message_success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5 text-left">
                                <p class="font-bold">
                                    Mohon periksa kembali isian:
                                </p>

                                <ul class="list-disc ml-5 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('guest-messages.store', $invitation) }}"
                            class="pw-form-card space-y-4">
                            @csrf

                            <div>
                                <label class="pw-form-label">Nama Tamu</label>
                                <input
                                    type="text"
                                    name="guest_name"
                                    value="{{ old('guest_name') }}"
                                    class="pw-input"
                                    placeholder="Nama lengkap"
                                    required>
                            </div>

                            <div>
                                <label class="pw-form-label">Konfirmasi Kehadiran</label>
                                <select name="attendance_status" class="pw-input">
                                    <option value="">Pilih status kehadiran</option>
                                    <option value="hadir">Saya berencana hadir</option>
                                    <option value="tidak_hadir">Tidak bisa hadir</option>
                                    <option value="ragu">Masih ragu</option>
                                </select>
                            </div>

                            <div>
                                <label class="pw-form-label">Jumlah Tamu</label>
                                <input
                                    type="number"
                                    name="guest_count"
                                    value="{{ old('guest_count', 1) }}"
                                    min="1"
                                    max="10"
                                    class="pw-input">
                            </div>

                            <div>
                                <label class="pw-form-label">Ucapan / Doa</label>
                                <textarea
                                    name="message"
                                    rows="4"
                                    class="pw-input"
                                    placeholder="Tulis ucapan terbaik..."
                                    required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="pw-btn" style="width:100%;">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>

                    <div class="pw-summary-grid">
                        <div data-reveal="zoom">
                            <b>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</b>
                            <span>Tidak Hadir</span>
                        </div>

                        <div data-reveal="zoom" style="--reveal-delay:.06s">
                            <b>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b>
                            <span>Hadir</span>
                        </div>

                        <div data-reveal="zoom" style="--reveal-delay:.12s">
                            <b>{{ $messages->where('attendance_status', 'ragu')->count() }}</b>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="pw-message-list">
                        @forelse ($messages as $index => $message)
                            <div
                                class="pw-message-card"
                                data-reveal="zoom"
                                style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color:var(--pw-accent);">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span
                                            class="text-xs font-black px-3 py-1 rounded-full"
                                            style="background:var(--pw-soft);color:var(--pw-accent);">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">
                                    {{ trim($message->message) }}
                                </p>
                            </div>
                        @empty
                            <div class="pw-message-card text-center" data-reveal="zoom">
                                <p class="text-slate-500">
                                    Belum ada ucapan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="pw-page">
                <div class="pw-closing-card" data-reveal="zoom">
                    @if ($closingPhoto)
                        <img
                            src="{{ $closingPhoto }}"
                            alt="Foto Penutup"
                            class="pw-closing-photo">
                    @endif

                    <p class="pw-label">
                        Thank You
                    </p>

                    <h2 class="pw-title pw-script responsive-text mt-8">
                        Terima Kasih
                    </h2>

                    <p class="pw-note responsive-text">
                        Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
                    </p>

                    <h3
                        class="pw-title pw-script responsive-text mt-8"
                        style="font-size:clamp(2.2rem,7vw,4.8rem);">
                        {{ $eventTitle }}
                    </h3>
                </div>
            </section>
        </div>
    </main>

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
            const scrollSpeedPerFrame = 1.15;
            const scrollSpeedPerSecond = scrollSpeedPerFrame * 60;

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

                if (!lastAutoScrollTime) {
                    lastAutoScrollTime = timestamp;
                }

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
                document.documentElement.style.scrollBehavior = 'auto';
                setScrollIcon(true);
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }

            if (scrollToggle) {
                scrollToggle.addEventListener('click', function () {
                    if (autoScrollActive) {
                        stopAutoScroll();
                    } else {
                        startAutoScroll();
                    }
                });
            }

            ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                window.addEventListener(eventName, function () {
                    if (autoScrollActive) {
                        stopAutoScroll();
                    }
                }, { passive: true });
            });

            const revealItems = document.querySelectorAll('[data-reveal]');

            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.14,
                    rootMargin: '0px 0px -60px 0px'
                });

                revealItems.forEach(function (item) {
                    revealObserver.observe(item);
                });
            } else {
                revealItems.forEach(function (item) {
                    item.classList.add('is-visible');
                });
            }

            document.querySelectorAll('.pw-copy-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';

                    try {
                        await navigator.clipboard.writeText(value);

                        const originalText = button.textContent;
                        button.textContent = 'Tersalin';
                        button.classList.add('copied');

                        setTimeout(function () {
                            button.textContent = originalText;
                            button.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        const tempInput = document.createElement('input');
                        tempInput.value = value;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        tempInput.remove();

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
        });
    </script>

    <script>
            /*
            |--------------------------------------------------------------------------
            | Anti Inspect Ringan Tanpa Notice
            | Aktif untuk public preview dan preview editor iframe
            |--------------------------------------------------------------------------
            */

            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';

                if (!['input', 'textarea', 'select', 'option'].includes(tagName)) {
                    event.preventDefault();
                }
            });

            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });

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
        </script>

</body>
</html>
