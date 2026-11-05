<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Corporate Business Seminar') . ' ' . ($invitation->title ?: 'Corporate Business Seminar'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--biz-dark);
            background:
                radial-gradient(circle at 8% 4%, var(--biz-glow-1), transparent 28%),
                radial-gradient(circle at 92% 6%, var(--biz-glow-2), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, var(--biz-soft) 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .biz-shell {
            width: min(100%, 1440px);
            margin: 0 auto;
            padding: clamp(0px, 1.6vw, 24px);
        }

        .biz-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: clamp(0px, 2.8vw, 40px);
            background:
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,255,255,.95)),
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--biz-primary) 10%, transparent), transparent 24%),
                radial-gradient(circle at 86% 8%, color-mix(in srgb, var(--biz-secondary) 10%, transparent), transparent 28%);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 34px 100px rgba(15,23,42,.08);
            isolation: isolate;
        }

        .biz-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .06;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--biz-primary) 24%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--biz-primary) 24%, transparent) 1px, transparent 1px);
            background-size: 44px 44px;
            z-index: 0;
        }

        .biz-wrap > * {
            position: relative;
            z-index: 1;
        }

        .responsive-text {
            display: block;
            min-width: 0;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .biz-nav {
            position: sticky;
            top: 14px;
            z-index: 60;
            width: fit-content;
            max-width: calc(100% - 28px);
            margin: 18px auto -32px;
            padding: 8px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 16px 40px rgba(15,23,42,.08);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            scrollbar-width: none;
        }

        .biz-nav::-webkit-scrollbar { display: none; }

        .biz-nav a {
            flex: 0 0 auto;
            padding: 10px 15px;
            border-radius: 999px;
            text-decoration: none;
            color: var(--biz-text);
            font-size: 12px;
            font-weight: 900;
            transition: .25s ease;
        }

        .biz-nav a:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            transform: translateY(-1px);
        }

        .floating-actions {
            position: fixed;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 90;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 14px 32px rgba(15,23,42,.12);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            transition: .25s ease;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--biz-accent) 55%, white);
        }

        .floating-actions a:hover,
        .floating-action-button:hover {
            transform: translateY(-2px);
        }

        .floating-icon {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .biz-section {
            min-height: 100vh;
            padding: 92px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .biz-section.compact {
            min-height: auto;
            padding-top: 76px;
            padding-bottom: 76px;
        }

        .biz-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--biz-primary);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .biz-label::before,
        .biz-label::after {
            content: "";
            width: 36px;
            height: 1px;
            background: color-mix(in srgb, var(--biz-primary) 34%, transparent);
        }

        .biz-title {
            color: var(--biz-dark);
            font-weight: 950;
            letter-spacing: -.055em;
            line-height: .98;
        }

        .biz-gradient {
            background: linear-gradient(135deg, var(--biz-dark), var(--biz-primary), var(--biz-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-head {
            text-align: center;
        }

        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--biz-text);
            line-height: 1.84;
        }

        .biz-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 24px;
            border-radius: 999px;
            border: none;
            text-decoration: none;
            color: #fff;
            font-weight: 900;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--biz-primary) 22%, transparent);
            transition: .26s ease;
        }

        .biz-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 52px color-mix(in srgb, var(--biz-primary) 28%, transparent);
        }

        .biz-btn.secondary {
            color: var(--biz-dark);
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 12px 24px rgba(15,23,42,.06);
        }

        /* HERO */
        .biz-hero {
            position: relative;
            min-height: 100vh;
            padding: 132px 64px 76px;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(340px, .98fr);
            gap: 36px;
            align-items: center;
        }

        .biz-hero::before {
            content: "";
            position: absolute;
            inset: 78px 28px 36px;
            border-radius: 38px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.84), color-mix(in srgb, var(--biz-accent) 30%, white)),
                radial-gradient(circle at 18% 14%, color-mix(in srgb, var(--biz-primary) 10%, transparent), transparent 28%);
            border: 1px solid rgba(255,255,255,.80);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.90), 0 24px 70px rgba(15,23,42,.05);
            z-index: -1;
        }

        .biz-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.9);
            border: 1px solid rgba(148,163,184,.16);
            color: var(--biz-primary);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
            box-shadow: 0 12px 28px rgba(15,23,42,.06);
        }

        .biz-kicker::before {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            box-shadow: inset 0 0 0 8px rgba(255,255,255,.28);
        }

        .biz-hero-title {
            max-width: 760px;
            margin-top: 24px;
            font-size: clamp(3rem, 6vw, 6rem);
            line-height: .92;
        }

        .biz-hero-desc {
            max-width: 700px;
            margin-top: 20px;
            color: var(--biz-text);
            font-size: 1.03rem;
            line-height: 1.92;
        }

        .biz-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .biz-hero-meta {
            width: min(100%, 760px);
            margin-top: 32px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .biz-meta-card,
        .biz-card,
        .speaker-card,
        .highlight-card,
        .gift-card,
        .message-card,
        .summary-card,
        .form-card {
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 16px 40px rgba(15,23,42,.07);
        }

        .biz-meta-card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 24px;
        }

        .biz-meta-card::after {
            content: "";
            position: absolute;
            right: -30px;
            bottom: -30px;
            width: 86px;
            height: 86px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 38%, transparent);
        }

        .biz-meta-card small,
        .biz-meta-card strong {
            position: relative;
            z-index: 2;
            display: block;
        }

        .biz-meta-card small {
            color: var(--biz-text);
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .biz-meta-card strong {
            margin-top: 8px;
            color: var(--biz-dark);
            line-height: 1.45;
            font-weight: 950;
        }

        .biz-hero-side {
            position: relative;
            min-height: 610px;
        }

        .biz-main-visual {
            position: relative;
            width: min(100%, 480px);
            min-height: 580px;
            margin-left: auto;
            border-radius: 34px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(255,255,255,.86), rgba(255,255,255,.92)),
                radial-gradient(circle at 18% 12%, color-mix(in srgb, var(--biz-primary) 12%, transparent), transparent 28%),
                radial-gradient(circle at 88% 8%, color-mix(in srgb, var(--biz-secondary) 12%, transparent), transparent 28%);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 28px 80px rgba(15,23,42,.10);
        }

        .biz-main-visual::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 26px;
            border: 1px dashed color-mix(in srgb, var(--biz-primary) 18%, transparent);
            pointer-events: none;
            z-index: 4;
        }

        .biz-main-visual-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            z-index: 1;
        }

        .biz-main-visual.has-photo::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(15,23,42,.20));
            z-index: 2;
        }

        .biz-visual-placeholder {
            position: relative;
            z-index: 3;
            min-height: 580px;
            padding: 42px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .biz-visual-icon {
            width: 118px;
            height: 118px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2.2rem;
            font-weight: 950;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            box-shadow: 0 20px 48px color-mix(in srgb, var(--biz-primary) 28%, transparent);
        }

        .biz-visual-placeholder h2 {
            max-width: 340px;
            margin-top: 24px;
            color: var(--biz-dark);
            font-size: clamp(2.2rem, 4vw, 3.25rem);
            line-height: 1.02;
            letter-spacing: -.05em;
            font-weight: 950;
        }

        .biz-visual-placeholder p {
            max-width: 330px;
            margin-top: 14px;
            color: var(--biz-text);
            line-height: 1.8;
        }

        .biz-floating-badge {
            position: absolute;
            z-index: 8;
            padding: 18px 20px;
            border-radius: 26px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(15,23,42,.10);
            backdrop-filter: blur(14px);
        }

        .biz-floating-badge small,
        .biz-floating-badge strong,
        .biz-floating-badge span {
            display: block;
        }

        .biz-floating-badge small {
            color: var(--biz-text);
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .biz-floating-badge strong {
            margin-top: 8px;
            color: var(--biz-dark);
            line-height: 1.42;
            font-weight: 950;
        }

        .biz-floating-badge span {
            margin-top: 6px;
            color: var(--biz-text);
            font-size: 13px;
            line-height: 1.45;
        }

        .biz-badge-mode {
            left: 0;
            top: 56px;
            width: 200px;
        }

        .biz-badge-host {
            right: -8px;
            bottom: 64px;
            width: 220px;
        }

        .biz-stat-panel {
            position: absolute;
            left: 22px;
            right: 22px;
            bottom: 20px;
            z-index: 7;
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 12px;
            padding: 14px;
            border-radius: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 16px 32px rgba(15,23,42,.08);
            backdrop-filter: blur(10px);
        }

        .biz-stat-panel .item {
            text-align: center;
            padding: 10px 8px;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255,255,255,.96), color-mix(in srgb, var(--biz-soft) 90%, white));
        }

        .biz-stat-panel .item small {
            display: block;
            color: var(--biz-text);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
        }

        .biz-stat-panel .item strong {
            display: block;
            margin-top: 8px;
            color: var(--biz-dark);
            font-size: 1rem;
            line-height: 1.4;
            font-weight: 950;
        }

        /* Cards / grids */
        .speaker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .speaker-grid.single-person {
            grid-template-columns: minmax(280px, 420px);
        }

        .speaker-card {
            position: relative;
            overflow: hidden;
            border-radius: 34px;
            padding: 24px;
            transition: .3s ease;
        }

        .speaker-card::after {
            content: "";
            position: absolute;
            width: 145px;
            height: 145px;
            right: -54px;
            bottom: -54px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 38%, transparent);
        }

        .speaker-photo,
        .speaker-placeholder {
            position: relative;
            z-index: 2;
            width: 128px;
            height: 128px;
            border-radius: 30px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--biz-primary) 9%, white);
            border: 8px solid rgba(255,255,255,.9);
            box-shadow: 0 14px 30px rgba(15,23,42,.09);
            color: var(--biz-primary);
            font-size: 42px;
            font-weight: 950;
        }

        .speaker-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 16px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-primary) 10%, white);
            color: var(--biz-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .speaker-card h3,
        .speaker-card p {
            position: relative;
            z-index: 2;
        }

        .speaker-card h3 {
            margin-top: 16px;
            color: var(--biz-dark);
            font-size: 1.65rem;
            line-height: 1.12;
            font-weight: 950;
        }

        .speaker-card p {
            margin-top: 8px;
            color: var(--biz-text);
            line-height: 1.75;
        }

        .highlight-grid {
            display: grid;
            gap: 20px;
            margin-top: 42px;
            justify-content: center;
        }

        .highlight-grid.count-1 { grid-template-columns: minmax(280px, 520px); }
        .highlight-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .highlight-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 226px;
            padding: 28px;
            border-radius: 34px;
        }

        .highlight-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -54px;
            bottom: -54px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 32%, transparent);
        }

        .highlight-number {
            position: relative;
            z-index: 2;
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 950;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            margin-bottom: 20px;
        }

        .highlight-card h3,
        .highlight-card p {
            position: relative;
            z-index: 2;
        }

        .highlight-card h3 {
            color: var(--biz-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .highlight-card p {
            color: var(--biz-text);
            margin-top: 10px;
            line-height: 1.82;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: .96fr 1.04fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .biz-card {
            position: relative;
            overflow: hidden;
            border-radius: 34px;
            padding: 30px;
        }

        .biz-card::after {
            content: "";
            position: absolute;
            width: 146px;
            height: 146px;
            right: -52px;
            top: -54px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 36%, transparent);
            pointer-events: none;
        }

        .biz-card h3 {
            position: relative;
            z-index: 2;
            margin: 0;
            color: var(--biz-dark);
            font-size: 1.95rem;
            font-weight: 950;
        }

        .detail-list {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 14px;
            margin-top: 24px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--biz-primary) 18%, transparent);
        }

        .detail-row .label {
            color: var(--biz-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--biz-dark);
            font-weight: 900;
            line-height: 1.68;
        }

        .biz-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .countdown-card {
            padding: 22px 14px;
            text-align: center;
            border-radius: 24px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--biz-soft) 92%, white), white);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--biz-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--biz-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 22px;
            overflow: hidden;
            border-radius: 30px;
            background: #fff;
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 14px 36px rgba(15,23,42,.08);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 310px;
            display: block;
            border: 0;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            color: var(--biz-dark);
            background: linear-gradient(180deg, #fff, color-mix(in srgb, var(--biz-soft) 92%, white));
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 18px;
            margin-top: 38px;
        }

        .gallery-card {
            padding: 10px;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(15,23,42,.08);
        }

        .gallery-card img {
            width: 100%;
            height: 290px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 520px);
            justify-content: center;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            border-radius: 32px;
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            right: -44px;
            top: -44px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 28%, transparent);
        }

        .gift-card h3,
        .gift-copy-box,
        .gift-card p {
            position: relative;
            z-index: 2;
        }

        .gift-card h3 {
            color: var(--biz-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .gift-copy-box {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px;
            border-radius: 18px;
            background: color-mix(in srgb, var(--biz-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--biz-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--biz-primary);
            font-size: 1.08rem;
            font-weight: 950;
        }

        .copy-gift-btn {
            flex-shrink: 0;
            border: none;
            cursor: pointer;
            border-radius: 999px;
            padding: 10px 14px;
            color: white;
            font-size: 12px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .rsvp-wrap {
            max-width: 920px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            border-radius: 30px;
        }

        .form-card {
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            padding: 20px;
            text-align: center;
        }

        .summary-card strong {
            display: block;
            color: var(--biz-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--biz-text);
            font-size: 12px;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .message-card {
            padding: 22px;
        }

        .message-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .message-info {
            min-width: 0;
            flex: 1;
        }

        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-primary) 10%, white);
            color: var(--biz-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 880px;
            margin: 0 auto;
            text-align: center;
            border-radius: 42px;
            padding: 52px 36px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--biz-primary) 12%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--biz-accent) 28%, transparent), transparent 36%),
                rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 18px 40px rgba(15,23,42,.08);
        }

        /* Scroll reveal */
        [data-reveal] {
            opacity: 0;
            transform: translateY(28px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .76s cubic-bezier(.2,.8,.2,1),
                transform .76s cubic-bezier(.2,.8,.2,1),
                filter .76s cubic-bezier(.2,.8,.2,1);
            transition-delay: var(--reveal-delay, 0s);
        }

        [data-reveal="left"] { transform: translateX(-34px) scale(.985); }
        [data-reveal="right"] { transform: translateX(34px) scale(.985); }
        [data-reveal="zoom"] { transform: translateY(22px) scale(.94); }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0,0) scale(1);
            filter: blur(0);
        }

        @media (hover: hover) {
            .biz-meta-card:hover,
            .biz-card:hover,
            .speaker-card:hover,
            .highlight-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover,
            .map-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 24px 54px rgba(15,23,42,.10);
                border-color: color-mix(in srgb, var(--biz-primary) 28%, transparent);
            }

            .gallery-card img:hover,
            .speaker-photo:hover {
                transform: scale(1.03);
            }
        }

        .gallery-card img,
        .speaker-photo {
            transition: transform .5s ease;
        }

        @keyframes bizPulse {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        /* Responsive */
        @media (max-width: 1120px) {
            .biz-hero,
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .biz-hero {
                gap: 34px;
            }

            .biz-hero-side {
                min-height: auto;
            }

            .biz-main-visual {
                width: 100%;
                min-height: 540px;
                margin: 0 auto;
            }

            .biz-visual-placeholder {
                min-height: 540px;
            }

            .biz-floating-badge {
                position: relative;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                width: 100% !important;
                margin-top: 14px;
            }

            .biz-stat-panel {
                position: relative;
                left: auto;
                right: auto;
                bottom: auto;
                margin-top: 16px;
            }

            .highlight-grid.count-3 {
                grid-template-columns: repeat(2, minmax(280px, 460px));
            }

            .gallery-grid {
                grid-template-columns: repeat(2, minmax(0,1fr));
            }
        }

        @media (max-width: 1024px) {
            .floating-actions {
                top: auto;
                bottom: 16px;
                right: 14px;
                transform: none;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: flex-end;
                max-width: min(320px, calc(100% - 24px));
            }
        }

        @media (max-width: 640px) {
            .biz-shell { padding: 0; }
            .biz-wrap { border-radius: 0; box-shadow: none; }

            .biz-nav {
                top: 10px;
                max-width: calc(100% - 24px);
                margin: 12px auto -24px;
            }

            .biz-section,
            .biz-hero {
                padding: 84px 22px;
            }

            .biz-section.compact {
                padding-top: 64px;
                padding-bottom: 64px;
            }

            .biz-hero::before {
                inset: 72px 12px 26px;
                border-radius: 28px;
            }

            .biz-hero-title {
                font-size: clamp(2.4rem, 11vw, 4rem);
                line-height: .98;
            }

            .biz-hero-desc {
                font-size: .98rem;
            }

            .biz-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .biz-hero-meta,
            .highlight-grid,
            .highlight-grid.count-1,
            .highlight-grid.count-2,
            .highlight-grid.count-3,
            .countdown-grid,
            .summary-grid,
            .gallery-grid,
            .gift-grid,
            .gift-grid.gift-count-1 {
                grid-template-columns: 1fr;
            }

            .biz-main-visual {
                min-height: 460px;
                border-radius: 28px;
            }

            .biz-visual-placeholder {
                min-height: 460px;
                padding: 28px;
            }

            .biz-visual-icon {
                width: 102px;
                height: 102px;
                font-size: 2rem;
                border-radius: 26px;
            }

            .biz-stat-panel {
                grid-template-columns: 1fr;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .gift-copy-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .copy-gift-btn {
                width: 100%;
            }

            .message-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .floating-actions a,
            .floating-action-button {
                width: 44px;
                height: 44px;
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

        /* =========================================================
        BUSINESS SEMINAR - HERO EXCLUSIVE / EXECUTIVE HALL
        Ringan, profesional, beda dari hero corporate lain
        ========================================================= */

        .biz-seminar-hero-pro {
            position: relative;
            min-height: 100vh;
            padding: 128px 64px 78px;
            overflow: hidden;
            isolation: isolate;
        }

        .biz-seminar-hero-pro::before {
            content: "";
            position: absolute;
            inset: 78px 28px 36px;
            z-index: -2;
            border-radius: 42px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,255,255,.88)),
                radial-gradient(circle at 18% 20%, color-mix(in srgb, var(--biz-primary) 12%, transparent), transparent 32%),
                radial-gradient(circle at 84% 18%, color-mix(in srgb, var(--biz-secondary) 10%, transparent), transparent 34%),
                linear-gradient(135deg, #ffffff, color-mix(in srgb, var(--biz-soft) 88%, white));
            border: 1px solid rgba(255,255,255,.82);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.92),
                0 28px 80px rgba(15,23,42,.065);
        }

        .biz-seminar-hero-pro::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 94px;
            width: min(82%, 980px);
            height: 1px;
            transform: translateX(-50%);
            background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--biz-primary) 32%, transparent), transparent);
            z-index: -1;
        }

        .seminar-hero-head {
            position: relative;
            z-index: 2;
            max-width: 980px;
            margin: 0 auto 38px;
            text-align: center;
        }

        .seminar-kicker {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            color: var(--biz-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
            box-shadow: 0 12px 28px rgba(15,23,42,.055);
        }

        .seminar-kicker::before,
        .seminar-kicker::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
        }

        .seminar-hero-title {
            margin-top: 24px;
            color: var(--biz-dark);
            font-size: clamp(3rem, 6.2vw, 6.4rem);
            line-height: .9;
            letter-spacing: -.075em;
            font-weight: 950;
        }

        .seminar-hero-title span {
            background: linear-gradient(135deg, var(--biz-dark), var(--biz-primary), var(--biz-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .seminar-hero-desc {
            max-width: 760px;
            margin: 22px auto 0;
            color: var(--biz-text);
            font-size: 1.03rem;
            line-height: 1.88;
        }

        .seminar-hero-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-top: 28px;
        }

        .seminar-pro-layout {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(230px, .72fr) minmax(420px, 1.38fr) minmax(230px, .72fr);
            gap: 18px;
            align-items: stretch;
        }

        .seminar-side-panel,
        .seminar-access-panel {
            display: grid;
            gap: 16px;
            align-content: center;
        }

        .seminar-panel-card,
        .seminar-access-card,
        .seminar-stage {
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--biz-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(15,23,42,.075);
        }

        .seminar-panel-card,
        .seminar-access-card {
            position: relative;
            overflow: hidden;
            min-height: 136px;
            padding: 20px;
            border-radius: 28px;
        }

        .seminar-panel-card::after,
        .seminar-access-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-accent) 38%, transparent);
        }

        .seminar-panel-card small,
        .seminar-panel-card strong,
        .seminar-panel-card span,
        .seminar-access-card small,
        .seminar-access-card strong,
        .seminar-access-card span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .seminar-panel-card small,
        .seminar-access-card small {
            color: var(--biz-primary);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .seminar-panel-card strong,
        .seminar-access-card strong {
            margin-top: 8px;
            color: var(--biz-dark);
            line-height: 1.38;
            font-weight: 950;
        }

        .seminar-panel-card span,
        .seminar-access-card span {
            margin-top: 6px;
            color: var(--biz-text);
            font-size: 13px;
            line-height: 1.55;
            font-weight: 800;
        }

        .seminar-panel-card.featured {
            color: #fff;
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.26), transparent 26%),
                linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            border-color: transparent;
        }

        .seminar-panel-card.featured small,
        .seminar-panel-card.featured strong,
        .seminar-panel-card.featured span {
            color: #fff;
        }

        .seminar-stage {
            position: relative;
            overflow: hidden;
            min-height: 590px;
            border-radius: 38px;
            padding: 18px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.92), color-mix(in srgb, var(--biz-soft) 88%, white)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--biz-accent) 50%, transparent), transparent 56%);
        }

        .seminar-stage::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 28px;
            border: 1px dashed color-mix(in srgb, var(--biz-primary) 22%, transparent);
            pointer-events: none;
            z-index: 6;
        }

        .seminar-stage-top {
            position: relative;
            z-index: 7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 12px 26px rgba(15,23,42,.055);
        }

        .seminar-stage-top .dots {
            display: flex;
            gap: 7px;
        }

        .seminar-stage-top .dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--biz-primary) 38%, white);
        }

        .seminar-stage-top .dots span:nth-child(2) {
            background: color-mix(in srgb, var(--biz-secondary) 42%, white);
        }

        .seminar-stage-top .dots span:nth-child(3) {
            background: color-mix(in srgb, var(--biz-accent) 82%, white);
        }

        .seminar-stage-top b {
            color: var(--biz-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .seminar-screen {
            position: relative;
            z-index: 3;
            margin-top: 18px;
            min-height: 390px;
            overflow: hidden;
            border-radius: 30px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.98), color-mix(in srgb, var(--biz-soft) 88%, white));
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
        }

        .seminar-screen img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .seminar-screen.has-photo::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 48%, rgba(15,23,42,.36));
            pointer-events: none;
        }

        .seminar-screen-fallback {
            min-height: 390px;
            display: grid;
            place-items: center;
            padding: 36px;
            text-align: center;
        }

        .seminar-screen-icon {
            width: 124px;
            height: 124px;
            margin: 0 auto;
            border-radius: 34px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 2.4rem;
            font-weight: 950;
            background: linear-gradient(135deg, var(--biz-primary), var(--biz-secondary));
            box-shadow: 0 22px 48px color-mix(in srgb, var(--biz-primary) 24%, transparent);
        }

        .seminar-screen-fallback h2 {
            max-width: 420px;
            margin-top: 24px;
            color: var(--biz-dark);
            font-size: clamp(2rem, 3.8vw, 3.2rem);
            line-height: 1.02;
            letter-spacing: -.05em;
            font-weight: 950;
        }

        .seminar-screen-fallback p {
            max-width: 420px;
            margin-top: 14px;
            color: var(--biz-text);
            line-height: 1.76;
        }

        .seminar-stage-footer {
            position: relative;
            z-index: 7;
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .seminar-stage-footer .item {
            min-height: 86px;
            padding: 14px;
            border-radius: 22px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.14);
            text-align: center;
        }

        .seminar-stage-footer .item small {
            display: block;
            color: var(--biz-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .seminar-stage-footer .item strong {
            display: block;
            margin-top: 8px;
            color: var(--biz-dark);
            font-size: .95rem;
            line-height: 1.35;
            font-weight: 950;
        }

        .seminar-access-card.action {
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.26), transparent 26%),
                linear-gradient(135deg, var(--biz-dark), var(--biz-primary));
            border-color: transparent;
        }

        .seminar-access-card.action small,
        .seminar-access-card.action strong,
        .seminar-access-card.action span {
            color: #fff;
        }

        .seminar-access-card.action .mini-link {
            position: relative;
            z-index: 2;
            display: inline-flex;
            margin-top: 14px;
            padding: 9px 13px;
            border-radius: 999px;
            background: rgba(255,255,255,.18);
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 950;
        }

        /* responsive hero */
        @media (max-width: 1180px) {
            .biz-seminar-hero-pro {
                padding: 118px 42px 72px;
            }

            .seminar-pro-layout {
                grid-template-columns: 1fr;
                max-width: 940px;
                margin: 0 auto;
            }

            .seminar-side-panel,
            .seminar-access-panel {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                align-content: stretch;
            }

            .seminar-stage {
                order: -1;
                min-height: auto;
            }

            .seminar-screen {
                min-height: 420px;
            }

            .seminar-screen-fallback {
                min-height: 420px;
            }
        }

        @media (max-width: 760px) {
            .biz-seminar-hero-pro {
                padding: 96px 18px 66px;
            }

            .biz-seminar-hero-pro::before {
                inset: 72px 8px 28px;
                border-radius: 30px;
            }

            .seminar-hero-title {
                font-size: clamp(2.35rem, 11vw, 3.75rem);
                line-height: .98;
                letter-spacing: -.055em;
            }

            .seminar-hero-desc {
                font-size: .98rem;
                line-height: 1.78;
            }

            .seminar-hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .seminar-side-panel,
            .seminar-access-panel,
            .seminar-stage-footer {
                grid-template-columns: 1fr;
            }

            .seminar-stage {
                border-radius: 28px;
                padding: 14px;
            }

            .seminar-stage::before {
                inset: 10px;
                border-radius: 22px;
            }

            .seminar-stage-top {
                flex-direction: column;
                text-align: center;
            }

            .seminar-screen {
                min-height: 330px;
                border-radius: 24px;
            }

            .seminar-screen-fallback {
                min-height: 330px;
                padding: 26px;
            }

            .seminar-screen-icon {
                width: 104px;
                height: 104px;
                border-radius: 28px;
                font-size: 2rem;
            }
        }

        /* =========================================================
        FIX SPEAKER & HOST - CENTER CONTENT
        ========================================================= */

        #people {
            text-align: center !important;
            align-items: center !important;
        }

        #people .biz-label {
            margin-left: auto !important;
            margin-right: auto !important;
            justify-content: center !important;
            width: fit-content !important;
        }

        #people .speaker-grid {
            width: 100% !important;
            max-width: 1120px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            justify-content: center !important;
            justify-items: center !important;
            align-items: stretch !important;
        }

        #people .speaker-card {
            width: 100% !important;
            max-width: 340px !important;
            min-height: 300px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
        }

        #people .speaker-photo,
        #people .speaker-placeholder {
            margin-left: auto !important;
            margin-right: auto !important;
            align-self: center !important;
        }

        #people .speaker-role {
            margin-left: auto !important;
            margin-right: auto !important;
            text-align: center !important;
        }

        #people .speaker-card h3,
        #people .speaker-card p {
            text-align: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        #people .speaker-card p {
            max-width: 260px !important;
        }

        /* Tablet */
        @media (max-width: 900px) {
            #people .speaker-grid {
                grid-template-columns: repeat(2, minmax(260px, 340px)) !important;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            #people .speaker-grid {
                grid-template-columns: 1fr !important;
                max-width: 360px !important;
            }

            #people .speaker-card {
                max-width: 100% !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'navy';

    if ($themeColor === 'golden') {
        $themeColor = 'gold';
    }

    $themes = [
        'maroon' => ['primary' => '#9f1239', 'secondary' => '#e11d48', 'accent' => '#ffe4e6', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fff7f8', 'glow1' => 'rgba(225, 29, 72, .14)', 'glow2' => 'rgba(251, 113, 133, .12)'],
        'emerald' => ['primary' => '#047857', 'secondary' => '#10b981', 'accent' => '#d1fae5', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f4fff9', 'glow1' => 'rgba(16, 185, 129, .13)', 'glow2' => 'rgba(52, 211, 153, .12)'],
        'navy' => ['primary' => '#2563eb', 'secondary' => '#38bdf8', 'accent' => '#dbeafe', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f5f9ff', 'glow1' => 'rgba(37, 99, 235, .13)', 'glow2' => 'rgba(56, 189, 248, .12)'],
        'rose' => ['primary' => '#db2777', 'secondary' => '#fb7185', 'accent' => '#fce7f3', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fff7fb', 'glow1' => 'rgba(219, 39, 119, .14)', 'glow2' => 'rgba(251, 113, 133, .12)'],
        'gold' => ['primary' => '#b45309', 'secondary' => '#f59e0b', 'accent' => '#fef3c7', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fffbeb', 'glow1' => 'rgba(245, 158, 11, .14)', 'glow2' => 'rgba(250, 204, 21, .12)'],
        'slate' => ['primary' => '#475569', 'secondary' => '#64748b', 'accent' => '#e2e8f0', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f8fafc', 'glow1' => 'rgba(100, 116, 139, .12)', 'glow2' => 'rgba(148, 163, 184, .12)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];

    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $people = $invitation->people ?? collect();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $giftCount = $gifts->count();

    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Executive Business Seminar';
    $eventName = $invitation->event_name ?: 'Corporate Business Seminar';
    $hostName = $invitation->host_name ?: 'Business Relations Team';
    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Agenda Seminar';

    $eventDateText = 'Tanggal belum diatur';
    if ($invitation->event_date) {
        $startDate = \Carbon\Carbon::parse($invitation->event_date);
        $eventDateText = $startDate->translatedFormat('d M Y');

        if ($invitation->event_end_date) {
            $endDate = \Carbon\Carbon::parse($invitation->event_end_date);

            if ($startDate->isSameDay($endDate)) {
                $eventDateText = $startDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                $eventDateText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                $eventDateText = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
            } else {
                $eventDateText = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
            }
        }
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Seminar Room' : 'Venue Seminar');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang seminar atau webinar.'
        : 'Alamat lengkap belum ditambahkan.');
    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '';

    $shareMessage = "Halo Bapak/Ibu/Saudara/i,\n\n"
        . "Dengan hormat, kami mengundang Anda untuk hadir dalam acara:\n\n"
        . "*{$eventName}*\n"
        . "*{$eventTitle}*\n\n"
        . "Diselenggarakan oleh: {$hostName}\n"
        . "Tanggal: {$eventDateText}\n";

    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }

    if ($isOnlineEvent) {
        $shareMessage .= "Mode: Online\n";
        if ($onlineUrl) { $shareMessage .= "Link Online: {$onlineUrl}\n"; }
    } else {
        $shareMessage .= "Mode: Offline\n";
        if ($invitation->location_name) { $shareMessage .= "Tempat: {$invitation->location_name}\n"; }
        if ($invitation->address) { $shareMessage .= "Alamat: {$invitation->address}\n"; }
    }

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n{$shareUrl}\n\nTerima kasih.";
    $shareText = urlencode($shareMessage);

    $countdownTarget = null;
    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
        $timePart = '00:00:00';
        if (!empty($invitation->event_time)) {
            try { $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s'); }
            catch (\Exception $e) { $timePart = '00:00:00'; }
        }
        $countdownTarget = $datePart . 'T' . $timePart;
    }

    $googleCalendarUrl = null;
    if ($invitation->event_date) {
        try {
            $startDate = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
            $startTime = !empty($invitation->event_time) ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00';
            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);
            $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d') : $startDate;

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Business Seminar') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan seminar bisnis') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online'))
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

    $eventHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $eventHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --biz-primary: {{ $activeTheme['primary'] }};
        --biz-secondary: {{ $activeTheme['secondary'] }};
        --biz-accent: {{ $activeTheme['accent'] }};
        --biz-dark: {{ $activeTheme['dark'] }};
        --biz-text: {{ $activeTheme['text'] }};
        --biz-soft: {{ $activeTheme['soft'] }};
        --biz-glow-1: {{ $activeTheme['glow1'] }};
        --biz-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="biz-shell">
        <div class="biz-wrap">
            <nav class="biz-nav">
                <a href="#people">Pembicara</a>
                @if($highlightCount) <a href="#about">Agenda</a> @endif
                <a href="#detail">Detail</a>
                @if($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if($giftCount) <a href="#gift">Support</a> @endif
                <a href="#message">RSVP</a>
            </nav>

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

                @if (!$isOnlineEvent && $mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif

                @if ($isOnlineEvent && $onlineUrl)
                    <a href="{{ $onlineUrl }}" target="_blank" title="Join Online">
                        <img src="{{ asset('assets/icons/meeting.png') }}" alt="Join Online" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background5.mp3') }}"
                   preload="auto"
                   loop></audio>

            {{-- HERO - BUSINESS SEMINAR EXECUTIVE HALL --}}
            <section id="opening" class="biz-seminar-hero-pro">
                <div class="seminar-hero-head">
                    <p class="seminar-kicker" data-reveal="zoom" style="--reveal-delay:.04s">
                        Executive Seminar • Business Insight • Professional Forum
                    </p>

                    <h1 class="responsive-text seminar-hero-title" data-reveal="zoom" style="--reveal-delay:.10s">
                        <span>{{ $eventTitle }}</span>
                    </h1>

                    <p class="responsive-text seminar-hero-desc" data-reveal="zoom" style="--reveal-delay:.18s">
                        {{ $invitation->description ?: 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam seminar bisnis eksklusif sebagai ruang berbagi wawasan, strategi, relasi profesional, dan peluang kolaborasi yang lebih luas.' }}
                    </p>

                    <div class="seminar-hero-actions" data-reveal="zoom" style="--reveal-delay:.26s">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="biz-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="biz-btn">Lihat Detail</a>
                        @endif

                        <a href="#people" class="biz-btn secondary">Pembicara</a>
                        <a href="#message" class="biz-btn secondary">Konfirmasi Kehadiran</a>
                    </div>
                </div>

                <div class="seminar-pro-layout">
                    <aside class="seminar-side-panel" data-reveal="right" style="--reveal-delay:.18s">
                        <div class="seminar-panel-card featured">
                            <small>Seminar Agenda</small>
                            <strong class="responsive-text">{{ $agendaSectionTitle }}</strong>
                            <span>Rangkaian topik dan insight bisnis untuk peserta undangan.</span>
                        </div>

                        <div class="seminar-panel-card">
                            <small>Tanggal</small>
                            <strong class="responsive-text">{{ $eventDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="seminar-panel-card">
                            <small>Presented by</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span class="responsive-text">{{ $eventName }}</span>
                        </div>
                    </aside>

                    <div class="seminar-stage" data-reveal="zoom" style="--reveal-delay:.14s">
                        <div class="seminar-stage-top">
                            <div class="dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <b>{{ $isOnlineEvent ? 'Online Seminar Room' : 'Executive Seminar Hall' }}</b>
                        </div>

                        <div class="seminar-screen {{ $invitation->cover_image || $firstPhoto ? 'has-photo' : '' }}">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Business Seminar">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Business Seminar">
                            @else
                                <div class="seminar-screen-fallback">
                                    <div>
                                        <div class="seminar-screen-icon">BS</div>
                                        <h2 class="responsive-text">{{ $eventName }}</h2>
                                        <p class="responsive-text">
                                            Tampilan seminar bisnis yang profesional, eksklusif, ringan, dan cocok untuk forum corporate.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="seminar-stage-footer">
                            <div class="item">
                                <small>Acara</small>
                                <strong class="responsive-text">{{ $eventName }}</strong>
                            </div>

                            <div class="item">
                                <small>Mode</small>
                                <strong>{{ $isOnlineEvent ? 'Online' : 'Offline' }}</strong>
                            </div>

                            <div class="item">
                                <small>{{ $accessTypeLabel }}</small>
                                <strong class="responsive-text">{{ $accessName }}</strong>
                            </div>
                        </div>
                    </div>

                    <aside class="seminar-access-panel" data-reveal="left" style="--reveal-delay:.22s">
                        <div class="seminar-access-card action">
                            <small>Akses Acara</small>
                            <strong>{{ $isOnlineEvent ? 'Join Online' : 'Datang ke Lokasi' }}</strong>
                            <span class="responsive-text">{{ $accessDescription }}</span>

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="mini-link">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>

                        <div class="seminar-access-card">
                            <small>Waktu</small>
                            <strong class="responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</strong>
                            <span>Pastikan hadir tepat waktu sesuai jadwal seminar.</span>
                        </div>

                        <div class="seminar-access-card">
                            <small>RSVP</small>
                            <strong>Konfirmasi Kehadiran</strong>
                            <span>Silakan isi ucapan dan konfirmasi pada bagian RSVP.</span>
                        </div>
                    </aside>
                </div>
            </section>

            {{-- PEOPLE --}}
            <section id="people" class="biz-section compact text-center">
                <p class="biz-label" data-reveal="zoom">Speaker & Host</p>
                <h2 class="responsive-text biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                    Pembicara & Perwakilan
                </h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" data-reveal="zoom" style="color: var(--biz-text); line-height: 1.84; --reveal-delay:.16s">
                    Menampilkan pembicara, host, moderator, atau perwakilan penting dalam seminar bisnis ini.
                </p>

                <div class="speaker-grid {{ $people->count() <= 1 ? 'single-person' : '' }}">
                    @forelse ($people as $index => $person)
                        <div class="speaker-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="speaker-photo">
                            @else
                                <div class="speaker-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'B', 0, 1)) }}</div>
                            @endif

                            <span class="speaker-role">{{ $person->subtitle ?: 'Business Speaker' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Pembicara' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="speaker-card" data-reveal="zoom">
                            <div class="speaker-placeholder">B</div>
                            <span class="speaker-role">Business Speaker</span>
                            <h3 class="responsive-text">Nama Pembicara</h3>
                            <p>Data pembicara belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ABOUT / HIGHLIGHTS --}}
            @if ($highlightCount > 0)
                <section id="about" class="biz-section compact">
                    <div class="section-head">
                        <p class="biz-label" data-reveal="zoom">Seminar Agenda</p>
                        <h2 class="responsive-text biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                            {{ $agendaSectionTitle }}
                        </h2>
                        <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                            Rangkaian agenda, topik bahasan, atau highlight utama seminar bisnis Anda.
                        </p>
                    </div>

                    <div class="highlight-grid {{ $highlightGridClass }}">
                        @foreach ($eventHighlights as $index => $highlight)
                            <div class="highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <div class="highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <h3 class="responsive-text">{{ $highlight['title'] ?? 'Agenda Seminar' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi agenda seminar bisnis.' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="biz-section compact">
                <div class="section-head">
                    <p class="biz-label" data-reveal="zoom">Event Access</p>
                    <h2 class="responsive-text biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                        Detail Acara
                    </h2>
                    <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                        Informasi waktu, akses seminar, dan lokasi atau platform acara.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="biz-card" data-reveal="left">
                        <h3>Informasi Seminar</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label">Acara</div>
                                <div class="value responsive-text">{{ $eventName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Mode</div>
                                <div class="value responsive-text">{{ $isOnlineEvent ? 'Online Seminar' : 'Offline Seminar' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value responsive-text">{{ $eventDateText }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Waktu</div>
                                <div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">{{ $accessTypeLabel }}</div>
                                <div class="value responsive-text">{{ $accessName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div>
                                <div class="value responsive-text">{{ $accessDescription }}</div>
                            </div>
                        </div>

                        <div class="biz-actions">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="biz-btn">📅 Add Calendar</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="biz-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="biz-card" data-reveal="right">
                        <h3>Menuju Acara</h3>

                        <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                            <div class="countdown-card"><span class="countdown-number" data-unit="days">00</span><span class="countdown-label">Hari</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="hours">00</span><span class="countdown-label">Jam</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="minutes">00</span><span class="countdown-label">Menit</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="seconds">00</span><span class="countdown-label">Detik</span></div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--biz-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--biz-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--biz-text);">Link online belum ditambahkan.</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--biz-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--biz-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--biz-text);">{{ $accessDescription }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="biz-section compact">
                    <div class="section-head">
                        <p class="biz-label" data-reveal="zoom">Seminar Gallery</p>
                        <h2 class="responsive-text biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                            Galeri Acara
                        </h2>
                        <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                            Dokumentasi visual seminar, suasana acara, atau materi pendukung.
                        </p>
                    </div>

                    <div class="gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <div class="gallery-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.05, 0.30) }}s">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Business Seminar">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- SUPPORT / GIFT --}}
            @if ($giftCount)
                <section id="gift" class="biz-section compact">
                    <div class="section-head">
                        <p class="biz-label" data-reveal="zoom">Support</p>
                        <h2 class="biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                            Support / Partner / Kontak
                        </h2>
                        <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                            Bagian ini dapat dipakai untuk menampilkan partner, sponsor, contact desk, atau informasi support tanpa menambah form baru.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Support / Partner / Kontak';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor / Kontak / Informasi</small>
                                        <div class="gift-number responsive-text">{{ $giftNumber }}</div>
                                        <p class="responsive-text text-sm mt-2" style="color: var(--biz-text);">Atas Nama {{ $giftName }}</p>
                                    </div>

                                    @if ($giftNumber !== '-')
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $giftNumber }}">Salin</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="biz-section compact">
                <div class="text-center">
                    <p class="biz-label" data-reveal="zoom">RSVP & Wishes</p>
                    <h2 class="biz-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                        Ucapan & Kehadiran
                    </h2>
                    <p class="responsive-text mt-4 max-w-2xl mx-auto" data-reveal="zoom" style="color: var(--biz-text); line-height: 1.84; --reveal-delay:.16s">
                        Kirimkan ucapan terbaik dan konfirmasi kehadiran Anda pada seminar ini.
                    </p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>
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

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4" data-reveal="up">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Tamu</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="uk-input mt-1" placeholder="Nama lengkap" required>
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
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Ucapan / Doa</label>
                            <textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full biz-btn">Kirim Ucapan</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card" data-reveal="zoom">
                            <strong>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</strong>
                            <span>Tidak hadir</span>
                        </div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.06s">
                            <strong>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong>
                            <span>Hadir</span>
                        </div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.12s">
                            <strong>{{ $messages->where('attendance_status', 'ragu')->count() }}</strong>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="message-list">
                        @forelse ($messages as $index => $message)
                            <div class="message-card" data-reveal="up" style="--reveal-delay: {{ min($index * 0.04, 0.24) }}s">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black" style="color: var(--biz-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--biz-text);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--biz-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center" data-reveal="up">
                                <p style="color: var(--biz-text);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="biz-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="biz-label">Thank You</p>
                    <h2 class="responsive-text biz-title biz-gradient text-5xl md:text-7xl mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--biz-text);">
                        Terima kasih atas perhatian, dukungan, dan kehadiran Anda. Semoga seminar ini membawa manfaat, wawasan baru, dan peluang kerja sama yang lebih luas.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--biz-dark);">
                        {{ $eventTitle }}
                    </h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Music toggle */
            const music = document.getElementById('invitation-music');
            const musicToggle = document.getElementById('music-toggle');
            const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
            let isMusicPlaying = false;

            function setMusicIcon(active) {
                if (!musicIcon || !musicToggle) return;
                musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
                musicToggle.classList.toggle('is-active', active);
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

            /* Auto scroll ringan dan halus */
            const scrollToggle = document.getElementById('scroll-toggle');
            const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            function setScrollIcon(active) {
                if (!scrollToggle || !scrollIcon) return;
                scrollToggle.classList.toggle('is-active', active);
                scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
            }

            function stopAutoScroll() {
                autoScrollActive = false;

                if (autoScrollFrame) {
                    cancelAnimationFrame(autoScrollFrame);
                    autoScrollFrame = null;
                }

                setScrollIcon(false);
            }

            function autoScrollStep() {
                if (!autoScrollActive) return;

                const maxY = document.documentElement.scrollHeight - window.innerHeight;
                const nextY = Math.min(window.scrollY + scrollSpeed, maxY);

                window.scrollTo({
                    top: nextY,
                    behavior: 'auto'
                });

                if (nextY >= maxY) {
                    stopAutoScroll();
                    return;
                }

                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }

            function startAutoScroll() {
                stopAutoScroll();
                autoScrollActive = true;
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

            /* Countdown */
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
                    const now = Date.now();
                    let diff = Math.max(0, target - now);

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    diff -= days * (1000 * 60 * 60 * 24);

                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    diff -= hours * (1000 * 60 * 60);

                    const minutes = Math.floor(diff / (1000 * 60));
                    diff -= minutes * (1000 * 60);

                    const seconds = Math.floor(diff / 1000);

                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

            /* Copy button */
            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';

                    try {
                        await navigator.clipboard.writeText(value);
                        button.classList.add('copied');
                        const oldText = button.textContent;
                        button.textContent = 'Tersalin';

                        setTimeout(function () {
                            button.textContent = oldText;
                            button.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        const textarea = document.createElement('textarea');
                        textarea.value = value;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
                });
            });

            /* Scroll reveal */
            const revealElements = document.querySelectorAll('[data-reveal]');

            if (!('IntersectionObserver' in window)) {
                revealElements.forEach(function (element) {
                    element.classList.add('is-visible');
                });
            } else {
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

                revealElements.forEach(function (element) {
                    revealObserver.observe(element);
                });
            }

            /* Anti inspect ringan tanpa notice */
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
        });
    </script>
</body>
</html>
