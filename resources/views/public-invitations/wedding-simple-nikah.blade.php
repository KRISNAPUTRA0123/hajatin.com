<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Simple Nikah'));
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
            color: var(--sn-ink);
            background:
                radial-gradient(circle at 10% 10%, var(--sn-glow), transparent 30%),
                radial-gradient(circle at 90% 18%, color-mix(in srgb, var(--sn-gold) 12%, transparent), transparent 28%),
                linear-gradient(180deg, var(--sn-bg1) 0%, var(--sn-bg2) 52%, var(--sn-bg3) 100%);
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

        img {
            max-width: 100%;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .sn-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .sn-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 34px;
            isolation: isolate;
            background:
                linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.76)),
                url("{{ asset('assets/wedding-simple-nikah/sn-paper-texture.png') }}") center / cover repeat,
                linear-gradient(180deg, var(--sn-bg2), var(--sn-soft));
            border: 1px solid color-mix(in srgb, var(--sn-accent) 14%, transparent);
            box-shadow: 0 38px 120px rgba(32, 35, 45, .12);
        }

        .sn-book::before,
        .sn-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .sn-book::before {
            opacity: .35;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-floral-pattern-soft.png') }}") center / 680px auto repeat;
            mix-blend-mode: multiply;
        }

        .sn-book::after {
            opacity: .42;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.92), transparent 30%),
                radial-gradient(circle at 92% 30%, color-mix(in srgb, var(--sn-gold) 12%, transparent), transparent 22%),
                radial-gradient(circle at 8% 76%, color-mix(in srgb, var(--sn-accent) 10%, transparent), transparent 26%);
        }

        .sn-book > * {
            position: relative;
            z-index: 2;
        }

        /* ===================== FLOATING ACTIONS ===================== */

        .sn-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(80, 90, 110, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(80,90,110,.13);
            backdrop-filter: blur(14px);
        }

        .sn-floating-actions a,
        .sn-floating-actions button {
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

        .sn-floating-actions a:hover,
        .sn-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .sn-floating-actions button.is-active {
            background: color-mix(in srgb, var(--sn-gold) 22%, white);
        }

        .sn-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        /* ===================== GENERAL ===================== */

        .sn-page {
            position: relative;
            min-height: auto;
            padding: 104px 72px;
            overflow: hidden;
            text-align: center;
        }

        .sn-page.slim {
            padding-top: 84px;
            padding-bottom: 84px;
        }

        .sn-page > * {
            position: relative;
            z-index: 6;
        }

        .sn-page::before,
        .sn-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .sn-page::before {
            z-index: 1;
            opacity: .36;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-top-right.png') }}") right top / 300px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-bottom-left.png') }}") left bottom / 300px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 8% 36% / 92px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 92% 62% / 88px auto no-repeat;
        }

        .sn-page::after {
            z-index: 2;
            opacity: .28;
            background:
                radial-gradient(circle at 50% 16%, rgba(255,255,255,.88), transparent 34%),
                radial-gradient(circle at 50% 86%, color-mix(in srgb, var(--sn-gold) 12%, transparent), transparent 30%);
        }

        .sn-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--sn-accent);
            background: rgba(255,255,255,.82);
            border: 1px solid color-mix(in srgb, var(--sn-gold) 34%, transparent);
            box-shadow: 0 12px 28px rgba(80,90,110,.06);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .sn-label::before,
        .sn-label::after {
            content: "";
            width: 28px;
            height: 1px;
            background: var(--sn-accent);
            opacity: .42;
        }

        .sn-title {
            margin: 0;
            color: var(--sn-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.035em;
            line-height: 1;
            text-wrap: balance;
        }

        .sn-script {
            font-family: "Brush Script MT", "Segoe Script", Georgia, serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: -.03em;
        }

        .sn-note {
            max-width: 720px;
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--sn-ink) 74%, white);
            line-height: 1.9;
            font-weight: 400;
        }

        .sn-btn {
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
            background: linear-gradient(135deg, var(--sn-accent), color-mix(in srgb, var(--sn-accent) 72%, #ffffff));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--sn-accent) 18%, transparent);
            font-weight: 900;
            letter-spacing: .06em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .sn-btn:hover {
            transform: translateY(-2px);
        }

        .sn-btn.light {
            color: var(--sn-accent);
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 18%, transparent);
        }

        .sn-btn.gold {
            color: color-mix(in srgb, var(--sn-accent) 72%, #111);
            background: linear-gradient(135deg, var(--sn-gold), color-mix(in srgb, var(--sn-gold) 74%, white));
        }

        .sn-btn::after,
        .sn-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: snShine 4.2s ease-in-out infinite;
        }

        /* ===================== HERO ===================== */

        .sn-hero {
            min-height: 900px;
            padding: 86px 72px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                radial-gradient(circle at 50% 30%, rgba(255,255,255,.98), rgba(255,255,255,.54) 42%, transparent 70%),
                linear-gradient(180deg, rgba(255,255,255,.78), color-mix(in srgb, var(--sn-soft) 88%, transparent));
        }

        .sn-hero::before {
            opacity: .94;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-top-right.png') }}") right top / 370px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-bottom-left.png') }}") left bottom / 340px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 9% 42% / 88px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 92% 46% / 82px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-abstract-gold-line.png') }}") left 8% top 8% / 260px auto no-repeat;
        }

        .sn-hero::after {
            opacity: .60;
            background:
                linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.50), rgba(255,255,255,.24));
        }

        .sn-hero-inner {
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 74px 0 150px;
        }

        .sn-hero-photo-area {
            position: relative;
            width: 310px;
            height: 310px;
            margin: 0 auto 32px;
            display: grid;
            place-items: center;
        }

        .sn-hero-circle {
            position: absolute;
            inset: -18px;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-gold-circle-frame.png') }}") center / contain no-repeat;
            opacity: .92;
            filter: drop-shadow(0 14px 26px rgba(80,90,110,.10));
        }

        .sn-hero-flower {
            position: absolute;
            z-index: 4;
            width: 175px;
            height: 110px;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-white-flower-cluster.png') }}") center / contain no-repeat;
            filter: drop-shadow(0 12px 20px rgba(80,90,110,.10));
            opacity: .96;
        }

        .sn-hero-flower.top {
            left: -42px;
            top: 4px;
        }

        .sn-hero-flower.bottom {
            right: -38px;
            bottom: 8px;
            transform: rotate(180deg);
        }

        .sn-hero-photo {
            position: relative;
            z-index: 3;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            overflow: hidden;
            border: 8px solid rgba(255,255,255,.95);
            outline: 1px solid color-mix(in srgb, var(--sn-gold) 50%, transparent);
            background: var(--sn-soft);
            box-shadow: 0 20px 54px rgba(80,90,110,.14);
        }

        .sn-hero-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sn-hero-kicker {
            color: var(--sn-accent);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .sn-hero-title {
            margin: 28px auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            font-size: clamp(3.2rem, 7vw, 6.6rem);
            color: var(--sn-accent);
            line-height: .96;
            text-align: center;
        }

        .sn-hero-name {
            display: block;
            line-height: .95;
        }

        .sn-hero-and {
            display: block;
            margin: 0 auto;
            color: var(--sn-gold);
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: .82;
        }

        .sn-hero-quote {
            max-width: 620px;
            margin: 34px auto 0;
            color: color-mix(in srgb, var(--sn-accent) 88%, #111);
            line-height: 1.85;
            font-weight: 500;
        }

        .sn-hero-date {
            margin-top: 26px;
            color: var(--sn-accent);
            font-size: 1rem;
            letter-spacing: .23em;
            font-weight: 850;
        }

        .sn-hero-actions {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===================== COUPLE ===================== */

        .sn-couple {
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), color-mix(in srgb, var(--sn-soft) 84%, transparent));
        }

        .sn-couple::before {
            opacity: .40;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-abstract-black-gold-wave.png') }}") left top / 330px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-top-right.png') }}") right top / 280px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-floral-pattern-soft.png') }}") center / 680px auto repeat;
        }

        .sn-couple-stage {
            width: min(100%, 980px);
            margin: 52px auto 0;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 24px;
            align-items: center;
        }

        .sn-person-card {
            position: relative;
            width: 100%;
            margin: 0 auto;
            min-height: 610px;
            padding: 62px 34px 48px;
            border-radius: 18px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,255,255,.78)),
                url("{{ asset('assets/wedding-simple-nikah/sn-card-marble-bg.png') }}") center / cover no-repeat;
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 30px 80px rgba(40,40,45,.12);
            display: grid;
            place-items: start center;
            text-align: center;
            overflow: hidden;
        }

        .sn-person-card::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 44px;
            width: 260px;
            height: 330px;
            transform: translateX(-50%);
            opacity: .72;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-oval-photo-frame.png') }}") center / contain no-repeat;
            pointer-events: none;
        }

        .sn-person-card::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 52px;
            opacity: .92;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-bottom-gold-bar.png') }}") center bottom / 100% 100% no-repeat;
            pointer-events: none;
        }

        .sn-person-photo-wrap {
            position: relative;
            z-index: 3;
            width: 210px;
            height: 250px;
            margin: 0 auto;
            padding: 7px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--sn-gold) 36%, transparent);
            box-shadow: 0 22px 56px rgba(80,90,110,.13);
        }

        .sn-person-photo-wrap img,
        .sn-person-initial {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px;
            background: var(--sn-soft);
            color: var(--sn-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .sn-person-content {
            position: relative;
            z-index: 4;
            margin-top: 44px;
        }

        .sn-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--sn-accent);
            background: rgba(255,255,255,.82);
            border: 1px solid color-mix(in srgb, var(--sn-gold) 30%, transparent);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .sn-person-name {
            margin: 12px 0 0;
            color: var(--sn-accent);
            font-family: "Brush Script MT", "Segoe Script", Georgia, serif;
            font-size: clamp(2.3rem, 4.8vw, 4.2rem);
            line-height: 1.05;
            font-weight: 400;
        }

        .sn-person-line {
            width: 170px;
            max-width: 70%;
            height: 1px;
            margin: 24px auto 0;
            background: var(--sn-gold);
            opacity: .62;
        }

        .sn-person-family {
            max-width: 360px;
            margin: 22px auto 0;
            color: color-mix(in srgb, var(--sn-ink) 70%, white);
            line-height: 1.82;
        }

        .sn-couple-symbol {
            width: 74px;
            height: 74px;
            margin: 0 auto;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--sn-accent);
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--sn-gold) 32%, transparent);
            box-shadow: 0 20px 52px color-mix(in srgb, var(--sn-accent) 10%, transparent);
            font-family: "Brush Script MT", "Segoe Script", Georgia, serif;
            font-style: italic;
            font-size: 3rem;
            z-index: 4;
        }

        /* ===================== INVITATION ===================== */

        .sn-invitation-section::before {
            opacity: .42;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-abstract-black-gold-wave.png') }}") left top / 330px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-top-right.png') }}") right top / 280px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-floral-pattern-soft.png') }}") center / 660px auto repeat;
        }

        .sn-invitation-card {
            position: relative;
            width: min(100%, 840px);
            margin: 0 auto;
            padding: 58px 48px;
            border-radius: 24px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,255,255,.78)),
                url("{{ asset('assets/wedding-simple-nikah/sn-card-marble-bg.png') }}") center / cover no-repeat;
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 28px 84px rgba(40,40,45,.10);
            overflow: hidden;
        }

        .sn-invitation-card::before,
        .sn-invitation-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            opacity: .82;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-thin-corner-gold.png') }}") center / contain no-repeat;
            pointer-events: none;
        }

        .sn-invitation-card::before {
            left: 18px;
            top: 18px;
        }

        .sn-invitation-card::after {
            right: 18px;
            bottom: 18px;
            transform: rotate(180deg);
        }

        .sn-rings-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 20px;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-rings-icon-gold.png') }}") center / contain no-repeat;
            opacity: .9;
        }

        .sn-invitation-card h2 {
            font-size: clamp(2.8rem, 6vw, 5.6rem);
        }

        /* ===================== EVENT ===================== */

        .sn-event-section::before {
            opacity: .48;
            background:
                url("{{ asset('assets/wedding-simple-nikah/sn-floral-pattern-soft.png') }}") center / 520px auto repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-abstract-black-gold-wave.png') }}") right top / 310px auto no-repeat,
                url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-bottom-left.png') }}") left bottom / 260px auto no-repeat;
        }

        .sn-event-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 720px);
            margin: 46px auto 0;
            padding: 72px 44px 62px;
            border-radius: 999px 999px 28px 28px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,255,255,.82)),
                url("{{ asset('assets/wedding-simple-nikah/sn-save-date-arch-bg.png') }}") center / cover no-repeat;
            border: 1px solid color-mix(in srgb, var(--sn-gold) 34%, transparent);
            box-shadow: 0 30px 88px rgba(40,40,45,.11);
            text-align: center;
        }

        .sn-event-card::before,
        .sn-event-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            opacity: .76;
            background: url("{{ asset('assets/wedding-simple-nikah/sn-thin-corner-gold.png') }}") center / contain no-repeat;
            pointer-events: none;
        }

        .sn-event-card::before {
            left: 20px;
            top: 26px;
        }

        .sn-event-card::after {
            right: 20px;
            bottom: 26px;
            transform: rotate(180deg);
        }

        .sn-event-card h3 {
            position: relative;
            z-index: 2;
            color: var(--sn-gold);
            font-size: clamp(2.2rem, 5vw, 4.4rem);
            margin-bottom: 26px;
        }

        .sn-date-row {
            position: relative;
            z-index: 2;
            width: min(100%, 480px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 20px;
        }

        .sn-date-side {
            color: var(--sn-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 1.08rem;
            font-weight: 600;
        }

        .sn-date-center {
            min-width: 120px;
            padding: 0 24px;
            border-left: 1px solid color-mix(in srgb, var(--sn-accent) 30%, transparent);
            border-right: 1px solid color-mix(in srgb, var(--sn-accent) 30%, transparent);
        }

        .sn-date-center b {
            display: block;
            color: var(--sn-accent);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(3rem, 8vw, 5rem);
            line-height: .9;
        }

        .sn-date-center span {
            display: block;
            margin-top: 10px;
            color: color-mix(in srgb, var(--sn-ink) 68%, white);
            font-weight: 800;
        }

        .sn-date-until {
            position: relative;
            z-index: 2;
            width: fit-content;
            margin: 22px auto 18px;
            padding: 7px 18px;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(135deg, var(--sn-accent), color-mix(in srgb, var(--sn-accent) 70%, white));
            box-shadow: 0 12px 28px color-mix(in srgb, var(--sn-accent) 16%, transparent);
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .sn-event-line {
            position: relative;
            z-index: 2;
            margin: 28px auto 0;
            color: color-mix(in srgb, var(--sn-ink) 82%, white);
            line-height: 1.85;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .sn-event-place {
            position: relative;
            z-index: 2;
            margin-top: 24px;
            color: var(--sn-ink);
            font-weight: 950;
        }

        .sn-event-address {
            position: relative;
            z-index: 2;
            margin-top: 10px;
            color: color-mix(in srgb, var(--sn-ink) 72%, white);
            line-height: 1.78;
        }

        .sn-event-actions {
            position: relative;
            z-index: 2;
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===================== MAP ===================== */

        .sn-map-card {
            width: min(100%, 760px);
            margin: 34px auto 0;
            border-radius: 30px;
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 22px 68px rgba(40,40,45,.09);
            overflow: hidden;
        }

        .sn-map-frame,
        .sn-map-placeholder {
            width: 100%;
            height: 360px;
            min-height: 360px;
            border: 0;
            display: block;
        }

        .sn-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            color: inherit;
            padding: 32px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--sn-accent) 10%, transparent), color-mix(in srgb, var(--sn-gold) 12%, transparent)),
                var(--sn-soft);
        }

        .sn-map-pin {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: var(--sn-accent);
            color: #fff;
            font-size: 2rem;
            box-shadow: 0 18px 40px color-mix(in srgb, var(--sn-accent) 20%, transparent);
        }

        .sn-map-footer {
            padding: 20px 24px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            background: rgba(255,255,255,.92);
            border-top: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            text-align: left;
        }

        .sn-map-title {
            margin: 0;
            color: var(--sn-ink);
            font-weight: 950;
        }

        .sn-map-address {
            margin: 7px 0 0;
            color: color-mix(in srgb, var(--sn-ink) 74%, white);
            line-height: 1.65;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* ===================== GALLERY ===================== */

        .sn-gallery-grid {
            width: min(100%, 980px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 110px;
            gap: 12px;
        }

        .sn-gallery-item {
            display: block;
            overflow: hidden;
            padding: 7px;
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 14px 34px rgba(40,40,45,.08);
            border-radius: 28px;
        }

        .sn-gallery-item:nth-child(1) {
            grid-column: span 5;
            grid-row: span 4;
            border-radius: 999px 999px 28px 28px;
        }

        .sn-gallery-item:nth-child(2) {
            grid-column: span 4;
            grid-row: span 2;
        }

        .sn-gallery-item:nth-child(3) {
            grid-column: span 3;
            grid-row: span 2;
            border-radius: 999px;
        }

        .sn-gallery-item:nth-child(n+4) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .sn-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: inherit;
            transition: transform .7s ease;
        }

        .sn-gallery-item:hover img {
            transform: scale(1.055);
        }

        /* ===================== GIFT ===================== */

        .sn-gift-grid {
            width: min(100%, 880px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .sn-gift-grid.is-single {
            grid-template-columns: minmax(0, 450px);
            justify-content: center;
        }

        .sn-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 26px;
            text-align: left;
            background:
                linear-gradient(145deg, rgba(255,255,255,.94), rgba(255,255,255,.80)),
                url("{{ asset('assets/wedding-simple-nikah/sn-card-marble-bg.png') }}") center / cover no-repeat;
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 18px 48px rgba(40,40,45,.08);
        }

        .sn-gift-card::before {
            content: "";
            position: absolute;
            inset: auto -20px -65px -20px;
            height: 140px;
            background: color-mix(in srgb, var(--sn-gold) 22%, transparent);
            transform: skewY(-7deg);
        }

        .sn-gift-title,
        .sn-gift-number,
        .sn-gift-owner,
        .sn-copy-btn {
            position: relative;
            z-index: 2;
        }

        .sn-gift-title {
            color: var(--sn-accent);
            font-weight: 950;
            font-size: 1.2rem;
        }

        .sn-gift-number {
            margin-top: 18px;
            color: var(--sn-ink);
            font-weight: 950;
            font-size: clamp(1.5rem, 4vw, 2.3rem);
        }

        .sn-gift-owner {
            margin-top: 12px;
            color: color-mix(in srgb, var(--sn-ink) 72%, white);
        }

        .sn-copy-btn {
            overflow: hidden;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            padding: 12px 18px;
            color: #fff;
            background: var(--sn-accent);
            font-weight: 900;
            cursor: pointer;
            letter-spacing: .06em;
        }

        .sn-copy-btn.copied {
            background: #16803c;
        }

        /* ===================== RSVP ===================== */

        .sn-rsvp-layout {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr);
            gap: 34px;
            align-items: start;
            text-align: left;
        }

        .sn-rsvp-copy {
            padding: 42px 34px;
            border-radius: 30px;
            background: rgba(255,255,255,.86);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 18px 48px rgba(40,40,45,.07);
        }

        .sn-rsvp-copy h3 {
            font-size: clamp(2.2rem, 4vw, 4rem);
        }

        .sn-form-card {
            padding: 26px;
            border-radius: 26px;
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 18px 48px rgba(40,40,45,.08);
            text-align: left;
        }

        .sn-form-label {
            display: block;
            color: var(--sn-accent);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            text-align: left;
        }

        .sn-input {
            width: 100%;
            margin-top: 8px;
            border: 1px solid color-mix(in srgb, var(--sn-accent) 14%, transparent);
            background: rgba(255,255,255,.96);
            color: var(--sn-ink);
            border-radius: 14px;
            padding: 13px 14px;
            outline: none;
            text-align: left;
        }

        .sn-summary-grid {
            grid-column: 1 / -1;
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .sn-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 20px;
            background: rgba(255,255,255,.78);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
        }

        .sn-summary-grid b {
            display: block;
            color: var(--sn-accent);
            font-size: 2rem;
            line-height: 1;
        }

        .sn-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }

        .sn-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.86);
            border: 1px solid color-mix(in srgb, var(--sn-accent) 12%, transparent);
            box-shadow: 0 10px 24px rgba(40,40,45,.06);
        }

        /* ===================== CLOSING ===================== */

        .sn-closing-card {
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 70px 34px 150px;
            text-align: center;
        }

        .sn-closing-card h2 {
            font-size: clamp(3rem, 7vw, 6.2rem);
        }

        .sn-closing-photo {
            width: 190px;
            height: 190px;
            margin: 0 auto 28px;
            object-fit: cover;
            display: block;
            border-radius: 999px;
            border: 8px solid #fff;
            outline: 1px solid color-mix(in srgb, var(--sn-gold) 34%, transparent);
            box-shadow: 0 20px 52px rgba(40,40,45,.12);
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

        @keyframes snShine {
            0%, 48% {
                left: -90%;
            }

            75%, 100% {
                left: 135%;
            }
        }

        @keyframes snFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .sn-floating-actions a,
        .sn-floating-actions button {
            animation: snFloat 4.4s ease-in-out infinite;
        }

        /* ===================== RESPONSIVE ===================== */

        @media (min-width: 1440px) {
            .sn-shell {
                width: min(100%, 1280px);
            }

            .sn-page {
                padding-left: 90px;
                padding-right: 90px;
            }

            .sn-hero-title {
                font-size: clamp(4.5rem, 6.5vw, 7.4rem);
            }
        }

        @media (max-width: 980px) {
            .sn-shell {
                padding: 14px;
            }

            .sn-page {
                padding: 90px 38px;
            }

            .sn-hero {
                min-height: 820px;
                padding: 80px 38px 0;
            }

            .sn-hero::before {
                background-size: 300px auto, 280px auto, 74px auto, 70px auto, 210px auto;
            }

            .sn-hero-inner {
                padding-top: 48px;
                padding-bottom: 140px;
            }

            .sn-couple-stage {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .sn-couple-symbol {
                margin: -4px auto;
            }

            .sn-rsvp-layout {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .sn-gift-grid {
                grid-template-columns: 1fr;
            }

            .sn-gallery-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .sn-gallery-item:nth-child(1) {
                grid-column: span 3;
                grid-row: span 3;
            }

            .sn-gallery-item:nth-child(2) {
                grid-column: span 3;
                grid-row: span 2;
            }

            .sn-gallery-item:nth-child(n+3) {
                grid-column: span 2;
                grid-row: span 2;
            }
        }

        @media (max-width: 640px) {
            .sn-shell {
                padding: 0;
            }

            .sn-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .sn-page,
            .sn-page.slim {
                padding: 76px 22px;
            }

            .sn-floating-actions {
                right: 0;
                gap: 7px;
            }

            .sn-floating-actions a,
            .sn-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .sn-hero {
                min-height: 100svh;
                padding: 68px 20px 0;
            }

            .sn-hero::before {
                opacity: .84;
                background:
                    url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-top-right.png') }}") right top / 220px auto no-repeat,
                    url("{{ asset('assets/wedding-simple-nikah/sn-gold-leaf-bottom-left.png') }}") left bottom / 210px auto no-repeat,
                    url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 8% 42% / 62px auto no-repeat,
                    url("{{ asset('assets/wedding-simple-nikah/sn-gold-dot-cluster.png') }}") 92% 48% / 58px auto no-repeat;
            }

            .sn-hero-inner {
                padding-top: 34px;
                padding-bottom: 110px;
            }

            .sn-hero-photo-area {
                width: 250px;
                height: 250px;
                margin-bottom: 24px;
            }

            .sn-hero-photo {
                width: 172px;
                height: 172px;
                border-width: 7px;
            }

            .sn-hero-flower {
                width: 138px;
                height: 92px;
            }

            .sn-hero-flower.top {
                left: -28px;
                top: 4px;
            }

            .sn-hero-flower.bottom {
                right: -26px;
                bottom: 8px;
            }

            .sn-hero-title {
                font-size: clamp(3rem, 13vw, 4.8rem);
                gap: 2px;
                line-height: .94;
            }

            .sn-hero-name {
                line-height: .94;
            }

            .sn-hero-and {
                font-size: clamp(1.8rem, 7vw, 2.3rem);
            }

            .sn-hero-actions {
                flex-direction: column;
            }

            .sn-hero-actions .sn-btn {
                width: 100%;
            }

            .sn-label {
                font-size: 10px;
                letter-spacing: .14em;
            }

            .sn-label::before,
            .sn-label::after {
                width: 18px;
            }

            .sn-person-card {
                min-height: 560px;
                padding: 44px 20px 38px;
                border-radius: 18px;
            }

            .sn-person-photo-wrap {
                width: 185px;
                height: 225px;
            }

            .sn-date-row {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .sn-date-center {
                border-left: 0;
                border-right: 0;
                border-top: 1px solid color-mix(in srgb, var(--sn-accent) 25%, transparent);
                border-bottom: 1px solid color-mix(in srgb, var(--sn-accent) 25%, transparent);
                padding: 18px 0;
            }

            .sn-event-card {
                width: 100%;
                padding: 54px 20px 44px;
                border-radius: 160px 160px 26px 26px;
            }

            .sn-event-actions {
                flex-direction: column;
            }

            .sn-event-actions .sn-btn {
                width: 100%;
            }

            .sn-map-frame,
            .sn-map-placeholder {
                height: 320px;
                min-height: 320px;
            }

            .sn-map-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .sn-map-footer .sn-btn {
                width: 100%;
            }

            .sn-gallery-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .sn-gallery-item,
            .sn-gallery-item:nth-child(n) {
                grid-column: auto;
                grid-row: auto;
                height: 270px;
            }

            .sn-rsvp-layout {
                gap: 22px;
            }

            .sn-rsvp-copy,
            .sn-form-card {
                padding: 26px 20px;
                border-radius: 26px;
            }

            .sn-summary-grid {
                grid-template-columns: 1fr;
            }

            .sn-btn {
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

        $themeColor = $invitation->theme_color ?? 'gold';

        if ($themeColor === 'golden') {
            $themeColor = 'gold';
        }

        /*
        |--------------------------------------------------------------------------
        | Tetap 6 theme bawaan editor:
        | maroon, emerald, navy, rose, gold, slate
        |--------------------------------------------------------------------------
        */

        $snThemes = [
            'maroon' => [
                'accent' => '#7f4b4f',
                'gold'   => '#b5a05d',
                'ink'    => '#3d3030',
                'soft'   => '#fff8f7',
                'bg1'    => '#f4e8e6',
                'bg2'    => '#ffffff',
                'bg3'    => '#ead8d5',
                'glow'   => 'rgba(127, 75, 79, .16)',
            ],

            'emerald' => [
                'accent' => '#5f7866',
                'gold'   => '#b9a35f',
                'ink'    => '#2d3a32',
                'soft'   => '#f8fbf8',
                'bg1'    => '#e6eee8',
                'bg2'    => '#ffffff',
                'bg3'    => '#d8e4db',
                'glow'   => 'rgba(95, 120, 102, .16)',
            ],

            'navy' => [
                'accent' => '#526577',
                'gold'   => '#b9a35f',
                'ink'    => '#28323c',
                'soft'   => '#f7f9fb',
                'bg1'    => '#e4eaf0',
                'bg2'    => '#ffffff',
                'bg3'    => '#d6dfe8',
                'glow'   => 'rgba(82, 101, 119, .15)',
            ],

            'rose' => [
                'accent' => '#98666e',
                'gold'   => '#b9a35f',
                'ink'    => '#423236',
                'soft'   => '#fff8f9',
                'bg1'    => '#f1e2e5',
                'bg2'    => '#ffffff',
                'bg3'    => '#e8d1d6',
                'glow'   => 'rgba(152, 102, 110, .16)',
            ],

            'gold' => [
                'accent' => '#847846',
                'gold'   => '#c2ae67',
                'ink'    => '#37342a',
                'soft'   => '#fffdf5',
                'bg1'    => '#eee9d8',
                'bg2'    => '#ffffff',
                'bg3'    => '#e3dcc6',
                'glow'   => 'rgba(132, 120, 70, .16)',
            ],

            'slate' => [
                'accent' => '#73777f',
                'gold'   => '#b9a35f',
                'ink'    => '#353841',
                'soft'   => '#fafafa',
                'bg1'    => '#e8e8e8',
                'bg2'    => '#ffffff',
                'bg3'    => '#dbdde1',
                'glow'   => 'rgba(115, 119, 127, .14)',
            ],
        ];

        $snTheme = $snThemes[$themeColor] ?? $snThemes['gold'];

        $photos = ($invitation->photos ?? collect())->values();
        $firstPhoto = $photos->first();
        $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
        $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;

        $people = ($invitation->people ?? collect())->values();
        $gifts = $invitation->gifts ?? collect();
        $messages = $invitation->messages ?? collect();

        $eventTitle = $invitation->title ?: 'Justin & Sisca';
        $eventName = $invitation->event_name ?: 'The Wedding of';
        $hostName = $invitation->host_name ?: 'Keluarga Besar';

        $bride = $people->get(0);
        $groom = $people->get(1);

        $titleParts = str_contains($eventTitle, '&')
            ? array_map('trim', explode('&', $eventTitle, 2))
            : [];

        $brideName = $bride->name ?? ($titleParts[0] ?? 'Justin');
        $groomName = $groom->name ?? ($titleParts[1] ?? 'Sisca');

        $brideSubtitle = $bride->subtitle ?? 'Mempelai Pria';
        $groomSubtitle = $groom->subtitle ?? 'Mempelai Wanita';

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
        $defaultCover = asset('assets/wedding-simple-nikah/sn-couple-placeholder.png');
        $coverDisplay = $coverPhoto ?: $defaultCover;

        $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
        $groomPhoto = $personPhotoUrl($groom, $coverDisplay);

        $momentPhotoUrl = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
        $closingPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;

        $messageStats = [
            'total' => $messages->count(),
            'hadir' => $messages->where('attendance_status', 'hadir')->count(),
            'tidak_hadir' => $messages->where('attendance_status', 'tidak_hadir')->count(),
        ];
    @endphp
</head>

<body style="
    --sn-accent: {{ $snTheme['accent'] }};
    --sn-gold: {{ $snTheme['gold'] }};
    --sn-ink: {{ $snTheme['ink'] }};
    --sn-soft: {{ $snTheme['soft'] }};
    --sn-bg1: {{ $snTheme['bg1'] }};
    --sn-bg2: {{ $snTheme['bg2'] }};
    --sn-bg3: {{ $snTheme['bg3'] }};
    --sn-glow: {{ $snTheme['glow'] }};
">
    <div class="sn-floating-actions">
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

    <main class="sn-shell">
        <div class="sn-book">
            <section id="cover" class="sn-page sn-hero">
                <div class="sn-hero-inner" data-reveal="zoom">
                    <div class="sn-hero-photo-area">
                        <div class="sn-hero-circle"></div>
                        <div class="sn-hero-flower top"></div>
                        <div class="sn-hero-flower bottom"></div>

                        <div class="sn-hero-photo">
                            <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}">
                        </div>
                    </div>

                    <div class="sn-hero-kicker responsive-text">
                        {{ $eventName }}
                    </div>

                    <h1 class="sn-title sn-script sn-hero-title">
                        <span class="sn-hero-name responsive-text">{{ $brideName }}</span>
                        <span class="sn-hero-and">&</span>
                        <span class="sn-hero-name responsive-text">{{ $groomName }}</span>
                    </h1>

                    <div class="sn-hero-date responsive-text">
                        {{ $eventDateShort }}
                    </div>

                    <div class="sn-hero-actions">
                        <a href="#mempelai" class="sn-btn gold">
                            Buka Undangan
                        </a>

                        @if ($googleCalendarUrl)
                            <a href="{{ $googleCalendarUrl }}" target="_blank" class="sn-btn light">
                                Simpan Tanggal
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <section id="mempelai" class="sn-page sn-couple">
                <p class="sn-label" data-reveal="zoom">
                    Bride & Groom
                </p>

                <h2
                    class="sn-title sn-script responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,5.8rem);">
                    Mempelai
                </h2>

                <p class="sn-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    Dengan penuh rasa syukur, kami memperkenalkan kedua mempelai yang akan melangsungkan pernikahan.
                </p>

                <div class="sn-couple-stage">
                    <article class="sn-person-card" data-reveal="left">
                        <div class="sn-person-photo-wrap">
                            @if ($bridePhoto)
                                <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                            @else
                                <div class="sn-person-initial">
                                    {{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="sn-person-content">
                            <div class="sn-person-subtitle responsive-text">
                                {{ $brideSubtitle }}
                            </div>

                            <h3 class="sn-person-name responsive-text">
                                {{ $bride->name ?? $brideName }}
                            </h3>

                            <div class="sn-person-line"></div>

                            <p class="sn-person-family responsive-text">
                                {{ $bride->family_name ?? 'Putra dari keluarga tercinta' }}
                            </p>
                        </div>
                    </article>

                    <div class="sn-couple-symbol" data-reveal="zoom">
                        &
                    </div>

                    <article class="sn-person-card" data-reveal="right">
                        <div class="sn-person-photo-wrap">
                            @if ($groomPhoto)
                                <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                            @else
                                <div class="sn-person-initial">
                                    {{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="sn-person-content">
                            <div class="sn-person-subtitle responsive-text">
                                {{ $groomSubtitle }}
                            </div>

                            <h3 class="sn-person-name responsive-text">
                                {{ $groom->name ?? $groomName }}
                            </h3>

                            <div class="sn-person-line"></div>

                            <p class="sn-person-family responsive-text">
                                {{ $groom->family_name ?? 'Putri dari keluarga tercinta' }}
                            </p>
                        </div>
                    </article>
                </div>
            </section>

            <section id="invitation" class="sn-page slim sn-invitation-section">
                <div class="sn-invitation-card" data-reveal="zoom">
                    <div class="sn-rings-icon"></div>

                    <p class="sn-label">
                        Wedding Invitation
                    </p>

                    <h2 class="sn-title sn-script responsive-text">
                        Undangan Pernikahan
                    </h2>

                    <p class="sn-note responsive-text">
                        {{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan kami. Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.' }}
                    </p>
                </div>
            </section>

            <section id="acara" class="sn-page sn-event-section">
                <p class="sn-label" data-reveal="zoom">
                    Save The Date
                </p>

                <h2
                    class="sn-title sn-script responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,5.8rem);">
                    Save The Date
                </h2>

                <div class="sn-event-card" data-reveal="zoom">
                    <h3 class="sn-title sn-script responsive-text">
                        Acara Pernikahan
                    </h3>

                    <div class="sn-date-row">
                        <div class="sn-date-side">
                            {{ $eventDayText }}
                        </div>

                        <div class="sn-date-center">
                            <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                            <span>{{ $startDate ? $startDate->translatedFormat('F Y') : '' }}</span>
                        </div>

                        <div class="sn-date-side">
                            {{ $eventDateShort }}
                        </div>
                    </div>

                    @if ($hasDifferentEndDate)
                        <div class="sn-date-until">
                            Sampai
                        </div>

                        <div class="sn-date-row">
                            <div class="sn-date-side">
                                {{ $eventEndDayText }}
                            </div>

                            <div class="sn-date-center">
                                <b>{{ $endDate ? $endDate->format('d') : '--' }}</b>
                                <span>{{ $endDate ? $endDate->translatedFormat('F Y') : '' }}</span>
                            </div>

                            <div class="sn-date-side">
                                {{ $eventEndDateShort }}
                            </div>
                        </div>
                    @endif

                    @if ($eventTimeText)
                        <p class="sn-event-line">
                            Pukul {{ $eventTimeText }}
                        </p>
                    @endif

                    <p class="sn-event-place responsive-text">
                        {{ $locationText }}
                    </p>

                    <p class="sn-event-address responsive-text">
                        {{ $addressText }}
                    </p>

                    <div class="sn-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="sn-btn light">
                                Maps Lokasi Acara
                            </a>
                        @endif

                        @if ($googleCalendarUrl)
                            <a href="{{ $googleCalendarUrl }}" target="_blank" class="sn-btn gold">
                                Calendar
                            </a>
                        @endif
                    </div>
                </div>

                @if ($mapEmbedUrl || $mapOpenUrl)
                    <div class="sn-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe
                                src="{{ $mapEmbedUrl }}"
                                class="sn-map-frame"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="sn-map-placeholder">
                                <div>
                                    <div class="sn-map-pin">⌖</div>
                                    <strong>Lihat Lokasi Acara</strong>
                                    <p class="sn-note" style="margin-top:8px;">
                                        Klik untuk membuka Google Maps.
                                    </p>
                                </div>
                            </a>
                        @endif

                        <div class="sn-map-footer">
                            <div>
                                <p class="sn-map-title">{{ $locationText }}</p>
                                <p class="sn-map-address">{{ $addressText }}</p>
                            </div>

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="sn-btn light">
                                    Buka Maps
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            @if ($photos->count())
                <section id="galeri" class="sn-page">
                    <p class="sn-label" data-reveal="zoom">
                        Gallery
                    </p>

                    <h2
                        class="sn-title sn-script responsive-text"
                        data-reveal="zoom"
                        style="font-size:clamp(2.8rem,6vw,5.8rem);">
                        Momen Bahagia
                    </h2>

                    <p class="sn-note responsive-text" data-reveal="zoom">
                        Beberapa kenangan indah yang menjadi bagian dari perjalanan kami.
                    </p>

                    <div class="sn-gallery-grid">
                        @foreach ($photos->take(6) as $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="sn-gallery-item" data-reveal="zoom">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Gallery {{ $loop->iteration }}">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="sn-page slim">
                    <p class="sn-label" data-reveal="zoom">
                        Wedding Gift
                    </p>

                    <h2
                        class="sn-title sn-script responsive-text"
                        data-reveal="zoom"
                        style="font-size:clamp(2.8rem,6vw,5.8rem);">
                        Wedding Gift
                    </h2>

                    <p class="sn-note responsive-text" data-reveal="zoom">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>

                    <div class="sn-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $gift)
                            <div class="sn-gift-card" data-reveal="zoom">
                                <div class="sn-gift-title responsive-text">
                                    {{ $gift->label ?: 'Wedding Gift' }}
                                </div>

                                <div class="sn-gift-number responsive-text">
                                    {{ $gift->account_number ?: '-' }}
                                </div>

                                <div class="sn-gift-owner responsive-text">
                                    {{ $gift->account_name ?: $eventTitle }}
                                </div>

                                @if ($gift->account_number)
                                    <button
                                        type="button"
                                        class="sn-copy-btn"
                                        data-copy="{{ $gift->account_number }}">
                                        Salin Nomor
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="sn-page">
                <p class="sn-label" data-reveal="zoom">
                    RSVP
                </p>

                <h2
                    class="sn-title sn-script responsive-text"
                    data-reveal="zoom"
                    style="font-size:clamp(2.8rem,6vw,5.8rem);">
                    Ucapan & Kehadiran
                </h2>

                <div class="sn-rsvp-layout">
                    <div class="sn-rsvp-copy" data-reveal="left">
                        <h3 class="sn-title sn-script responsive-text">
                            Kirim Doa Terbaik
                        </h3>

                        <p class="sn-note responsive-text" style="margin-left:0;">
                            Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('guest-messages.store', $invitation) }}"
                        class="sn-form-card"
                        data-reveal="right">
                        @csrf

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="sn-form-label">Nama</label>
                                <input
                                    type="text"
                                    name="guest_name"
                                    class="sn-input"
                                    placeholder="Nama Anda"
                                    required>
                            </div>

                            <div>
                                <label class="sn-form-label">Status Kehadiran</label>
                                <select name="attendance_status" class="sn-input" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="tidak_hadir">Tidak Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                </select>
                            </div>

                            <div>
                                <label class="sn-form-label">Jumlah Tamu</label>
                                <input
                                    type="number"
                                    name="guest_count"
                                    class="sn-input"
                                    min="1"
                                    value="1">
                            </div>

                            <div>
                                <label class="sn-form-label">Ucapan</label>
                                <textarea
                                    name="message"
                                    rows="4"
                                    class="sn-input"
                                    placeholder="Tulis doa dan ucapan..."
                                    required></textarea>
                            </div>

                            <button type="submit" class="sn-btn gold" style="width:100%;">
                                Kirim Ucapan
                            </button>
                        </div>
                    </form>

                    <div class="sn-summary-grid" data-reveal="zoom">
                        <div>
                            <b>{{ $messageStats['total'] }}</b>
                            <span>Total Ucapan</span>
                        </div>

                        <div>
                            <b>{{ $messageStats['hadir'] }}</b>
                            <span>Hadir</span>
                        </div>

                        <div>
                            <b>{{ $messageStats['tidak_hadir'] }}</b>
                            <span>Tidak Hadir</span>
                        </div>
                    </div>

                    @if ($messages->count())
                        <div class="sn-message-list">
                            @foreach ($messages->take(6) as $message)
                                <div class="sn-message-card" data-reveal="zoom">
                                    <strong class="responsive-text">
                                        {{ $message->guest_name ?? 'Tamu Undangan' }}
                                    </strong>

                                    <p class="responsive-text" style="margin:8px 0 0;color:color-mix(in srgb,var(--sn-ink) 72%,white);line-height:1.75;">
                                        {{ $message->message ?? '' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section id="closing" class="sn-page slim">
                <div class="sn-closing-card" data-reveal="zoom">
                    <img src="{{ $closingPhoto }}" class="sn-closing-photo" alt="{{ $eventTitle }}">

                    <p class="sn-label">
                        Thank You
                    </p>

                    <h2 class="sn-title sn-script responsive-text">
                        Terima Kasih
                    </h2>

                    <p class="sn-note responsive-text">
                        Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami mengucapkan terima kasih.
                    </p>

                    <h3
                        class="sn-title sn-script responsive-text"
                        style="margin-top:32px;font-size:clamp(2.4rem,5vw,4.8rem);">
                        {{ $brideName }} & {{ $groomName }}
                    </h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /*
            |--------------------------------------------------------------------------
            | Music Toggle
            |--------------------------------------------------------------------------
            */
            const music = document.getElementById('invitation-music');
            const musicToggle = document.getElementById('music-toggle');
            const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
            let isMusicPlaying = false;

            function setMusicIcon(active) {
                if (!musicToggle || !musicIcon) return;

                musicToggle.classList.toggle('is-active', active);
                musicIcon.src = active
                    ? musicIcon.dataset.iconOn
                    : musicIcon.dataset.iconOff;
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

            /*
            |--------------------------------------------------------------------------
            | Auto Scroll
            |--------------------------------------------------------------------------
            */
            const scrollToggle = document.getElementById('scroll-toggle');
            const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;

            let autoScrollActive = false;
            let autoScrollFrame = null;
            let lastAutoScrollTime = 0;

            // Kecepatan sama seperti script referensi Peach Blossom
            const scrollSpeedPerFrame = 1.15;
            const scrollSpeedPerSecond = scrollSpeedPerFrame * 60;

            function setScrollIcon(active) {
                if (!scrollToggle || !scrollIcon) return;

                scrollToggle.classList.toggle('is-active', active);
                scrollIcon.src = active
                    ? scrollIcon.dataset.iconOn
                    : scrollIcon.dataset.iconOff;
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

                const nextY = Math.min(
                    currentY + (scrollSpeedPerSecond * delta / 1000),
                    maxY
                );

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
                    if (autoScrollActive) {
                        stopAutoScroll();
                    } else {
                        startAutoScroll();
                    }
                });

                ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                    window.addEventListener(eventName, function () {
                        if (autoScrollActive) {
                            stopAutoScroll();
                        }
                    }, { passive: true });
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Countdown
            |--------------------------------------------------------------------------
            | Mendukung data-countdown-target dan data-countdown.
            |--------------------------------------------------------------------------
            */
            document.querySelectorAll('[data-countdown-target]').forEach(function (wrap) {
                const targetValue = wrap.dataset.countdownTarget;
                if (!targetValue) return;

                const target = new Date(targetValue).getTime();

                const units = {
                    days: wrap.querySelector('[data-unit="days"]'),
                    hours: wrap.querySelector('[data-unit="hours"]'),
                    minutes: wrap.querySelector('[data-unit="minutes"]'),
                    seconds: wrap.querySelector('[data-unit="seconds"]')
                };

                function pad(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    let diff = Math.max(0, target - Date.now());

                    const days = Math.floor(diff / 86400000);
                    diff -= days * 86400000;

                    const hours = Math.floor(diff / 3600000);
                    diff -= hours * 3600000;

                    const minutes = Math.floor(diff / 60000);
                    diff -= minutes * 60000;

                    const seconds = Math.floor(diff / 1000);

                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

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

            /*
            |--------------------------------------------------------------------------
            | Copy Button Amplop Digital
            |--------------------------------------------------------------------------
            */
            document.querySelectorAll('.sn-copy-btn, [data-copy]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || button.getAttribute('data-copy') || '';
                    const oldText = button.textContent;

                    try {
                        await navigator.clipboard.writeText(value);
                    } catch (error) {
                        const textarea = document.createElement('textarea');
                        textarea.value = value;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }

                    button.classList.add('copied');
                    button.textContent = 'Tersalin';

                    setTimeout(function () {
                        button.classList.remove('copied');
                        button.textContent = oldText;
                    }, 1600);
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Reveal Animation
            |--------------------------------------------------------------------------
            */
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
                    threshold: 0.12,
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

            /*
            |--------------------------------------------------------------------------
            | Anti Inspect Ringan Tanpa Notice
            |--------------------------------------------------------------------------
            */

            document.addEventListener('contextmenu', function (event) {
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

            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });

            document.addEventListener('selectstart', function (event) {
                const tag = event.target.tagName ? event.target.tagName.toLowerCase() : '';

                if (!['input', 'textarea', 'select', 'option'].includes(tag)) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
