<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Elegant Graduation') . ' ' . ($invitation->title ?: 'Wisuda Elegant Graduate'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--elegant-dark);
            background:
                radial-gradient(circle at 8% 5%, var(--elegant-glow-1), transparent 34%),
                radial-gradient(circle at 92% 8%, var(--elegant-glow-2), transparent 36%),
                linear-gradient(180deg, #ffffff 0%, #ffffff 72%, #fbfbfb 100%);
        }

        .elegant-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .elegant-wrap {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            border-radius: 48px;
            background:
                radial-gradient(circle at 12% 10%, color-mix(in srgb, var(--elegant-primary) 7%, transparent), transparent 28%),
                radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--elegant-accent) 18%, transparent), transparent 28%),
                linear-gradient(180deg, rgba(255,255,255,.99), rgba(255,255,255,.97));
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 34px 90px rgba(15, 23, 42, .08);
        }

        .elegant-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .28;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--elegant-primary) 5%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--elegant-primary) 5%, transparent) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .elegant-wrap::after {
            content: "";
            position: absolute;
            width: 720px;
            height: 720px;
            right: -360px;
            bottom: -390px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--elegant-primary) 7%, transparent), transparent 68%);
            pointer-events: none;
        }

        .elegant-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            word-wrap: break-word;
            white-space: pre-line;
        }

        .elegant-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 26px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 11%, transparent);
            box-shadow: 0 16px 34px rgba(15,23,42,.07);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .elegant-nav a {
            text-decoration: none;
            color: var(--elegant-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .elegant-nav a:hover {
            color: var(--elegant-primary);
            background: color-mix(in srgb, var(--elegant-primary) 7%, white);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 60;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255,255,255,.97);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(15,23,42,.14);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--elegant-accent) 26%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .elegant-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            color: white;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 950;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--elegant-primary) 22%, transparent);
        }

        .elegant-btn.secondary {
            color: var(--elegant-dark);
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 13%, transparent);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
        }

        .elegant-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .elegant-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .elegant-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--elegant-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .elegant-label::before {
            content: "";
            width: 38px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-accent));
        }

        .elegant-title {
            color: var(--elegant-dark);
            font-weight: 950;
            letter-spacing: -.066em;
            line-height: .96;
        }

        .elegant-gradient {
            background: linear-gradient(135deg, var(--elegant-dark), var(--elegant-primary), var(--elegant-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--elegant-text);
            line-height: 1.85;
        }

        /* HERO */
        .elegant-hero {
            min-height: 100vh;
            padding: 82px 64px 76px;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(330px, .92fr);
            gap: 44px;
            align-items: center;
        }

        .hero-editorial {
            position: relative;
            min-width: 0;
        }

        .hero-editorial::before {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            left: -130px;
            top: -70px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-accent) 17%, transparent);
            z-index: -1;
        }

        .elegant-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 13%, transparent);
            box-shadow: 0 12px 28px rgba(15,23,42,.07);
            color: var(--elegant-primary);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .elegant-kicker::before {
            content: "";
            width: 26px;
            height: 26px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
            box-shadow: inset 0 0 0 7px rgba(255,255,255,.24);
        }

        .hero-elegant-title {
            margin-top: 30px;
            max-width: 750px;
            font-size: clamp(3rem, 6.7vw, 6.2rem);
            line-height: .92;
            letter-spacing: -.076em;
        }

        .hero-elegant-desc {
            max-width: 650px;
            margin-top: 26px;
            color: var(--elegant-text);
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .elegant-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .graduate-signature {
            margin-top: 34px;
            width: min(100%, 680px);
            display: grid;
            grid-template-columns: 1fr 106px;
            gap: 16px;
            align-items: stretch;
            padding: 16px;
            border-radius: 34px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 22px 54px rgba(15,23,42,.08);
        }

        .signature-copy {
            padding: 10px 12px;
            min-width: 0;
        }

        .signature-copy small {
            display: block;
            color: var(--elegant-text);
            font-size: 10px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .signature-copy strong {
            display: block;
            margin-top: 8px;
            color: var(--elegant-dark);
            font-size: clamp(1.65rem, 4vw, 2.75rem);
            line-height: 1.05;
            letter-spacing: -.04em;
            font-weight: 950;
        }

        .signature-copy span {
            display: block;
            margin-top: 8px;
            color: var(--elegant-text);
            font-weight: 800;
            line-height: 1.5;
        }

        .signature-mark {
            position: relative;
            overflow: hidden;
            min-height: 106px;
            border-radius: 26px;
            background:
                radial-gradient(circle at 72% 26%, color-mix(in srgb, var(--elegant-accent) 70%, white) 0 22px, transparent 23px),
                linear-gradient(135deg, color-mix(in srgb, var(--elegant-primary) 10%, white), #ffffff);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
        }

        .signature-mark::before,
        .signature-mark::after {
            content: "";
            position: absolute;
            border-radius: 999px;
        }

        .signature-mark::before {
            width: 46px;
            height: 46px;
            right: 18px;
            top: 16px;
            border: 2px solid color-mix(in srgb, var(--elegant-primary) 22%, transparent);
        }

        .signature-mark::after {
            width: 18px;
            height: 18px;
            left: 18px;
            bottom: 18px;
            background: var(--elegant-primary);
        }

        .elegant-info-row {
            margin-top: 34px;
            width: min(100%, 760px);
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .elegant-info-card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.91);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 14px 34px rgba(15,23,42,.07);
        }

        .elegant-info-card::after {
            content: "";
            position: absolute;
            width: 86px;
            height: 86px;
            right: -38px;
            bottom: -38px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-accent) 23%, transparent);
        }

        .elegant-info-card small,
        .elegant-info-card strong {
            position: relative;
            z-index: 2;
        }

        .elegant-info-card small {
            display: block;
            color: var(--elegant-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .elegant-info-card strong {
            display: block;
            margin-top: 8px;
            color: var(--elegant-dark);
            line-height: 1.45;
            font-weight: 950;
        }

        .elegant-portrait {
            position: relative;
            min-height: 690px;
        }

        .portrait-arch {
            position: relative;
            z-index: 2;
            min-height: 650px;
            overflow: hidden;
            border-radius: 260px 260px 42px 42px;
            background:
                radial-gradient(circle at 50% 18%, color-mix(in srgb, var(--elegant-accent) 25%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--elegant-soft) 84%, white));
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 13%, transparent);
            box-shadow: inset 0 0 0 10px rgba(255,255,255,.42), 0 22px 56px rgba(15,23,42,.10);
        }

        .portrait-arch::before {
            content: "";
            position: absolute;
            inset: 24px;
            border-radius: 230px 230px 30px 30px;
            border: 1px dashed color-mix(in srgb, var(--elegant-primary) 18%, transparent);
            z-index: 3;
            pointer-events: none;
        }

        .portrait-arch img.cover-photo {
            width: 100%;
            height: 650px;
            object-fit: cover;
            display: block;
        }

        .portrait-empty {
            min-height: 650px;
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .portrait-icon {
            width: 118px;
            height: 118px;
            margin-bottom: 28px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--elegant-primary) 22%, transparent);
        }

        .portrait-empty h2 {
            max-width: 360px;
            color: var(--elegant-dark);
            font-size: clamp(2.1rem, 4.4vw, 3.7rem);
            line-height: 1;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .portrait-empty p {
            max-width: 390px;
            margin-top: 18px;
            color: var(--elegant-text);
            line-height: 1.85;
        }

        .date-plaque {
            position: absolute;
            z-index: 5;
            left: -30px;
            bottom: 56px;
            width: 168px;
            padding: 24px 18px;
            border-radius: 34px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 14%, transparent);
            box-shadow: 0 20px 48px rgba(15,23,42,.12);
            text-align: center;
        }

        .date-plaque strong {
            display: block;
            color: var(--elegant-primary);
            font-size: 48px;
            line-height: .9;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .date-plaque span {
            display: block;
            margin-top: 8px;
            color: var(--elegant-text);
            font-size: 11px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .host-note {
            position: absolute;
            z-index: 6;
            right: -22px;
            top: 84px;
            width: 220px;
            padding: 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 14%, transparent);
            box-shadow: 0 20px 48px rgba(15,23,42,.12);
        }

        .host-note small {
            display: block;
            color: var(--elegant-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .host-note strong {
            display: block;
            margin-top: 9px;
            color: var(--elegant-dark);
            font-weight: 950;
            line-height: 1.45;
        }

        .elegant-date-line,
        .elegant-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            line-height: 1.5;
        }

        .elegant-date-line span,
        .elegant-time-line span { display: inline; }

        /* graduate */
        .graduate-elegant-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .graduate-elegant-grid.single-graduate {
            grid-template-columns: minmax(280px, 430px);
        }

        .graduate-elegant-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 38px;
            padding: 28px;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 20px 48px rgba(15,23,42,.08);
        }

        .graduate-elegant-card::before {
            content: "";
            position: absolute;
            left: 28px;
            top: 0;
            width: 74px;
            height: 8px;
            border-radius: 0 0 999px 999px;
            background: linear-gradient(90deg, var(--elegant-primary), var(--elegant-accent));
        }

        .graduate-elegant-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-primary) 7%, transparent);
        }

        .graduate-photo,
        .graduate-placeholder {
            width: 132px;
            height: 132px;
            border-radius: 999px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--elegant-primary) 8%, white);
            border: 8px solid rgba(255,255,255,.92);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            color: var(--elegant-primary);
            font-size: 44px;
            font-weight: 950;
            position: relative;
            z-index: 2;
        }

        .graduate-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-primary) 9%, white);
            color: var(--elegant-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .graduate-elegant-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--elegant-dark);
            font-size: 1.75rem;
            line-height: 1.1;
            font-weight: 950;
        }

        .graduate-elegant-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--elegant-text);
            line-height: 1.7;
        }

        /* achievement */
        .elegant-story-layout {
            display: grid;
            grid-template-columns: .9fr 1.1fr;
            gap: 24px;
            margin-top: 42px;
            align-items: stretch;
        }

        .story-panel {
            position: relative;
            overflow: hidden;
            min-height: 360px;
            border-radius: 40px;
            padding: 34px;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--elegant-soft) 86%, white));
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 22px 54px rgba(15,23,42,.08);
        }

        .story-panel::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            right: -96px;
            bottom: -96px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-accent) 22%, transparent);
        }

        .story-panel .big-word,
        .story-panel h3,
        .story-panel p {
            position: relative;
            z-index: 2;
        }

        .story-panel .big-word {
            color: var(--elegant-primary);
            font-size: clamp(3.2rem, 9vw, 7rem);
            line-height: .85;
            letter-spacing: -.08em;
            font-weight: 950;
        }

        .story-panel h3 {
            margin-top: 28px;
            color: var(--elegant-dark);
            font-size: clamp(2rem, 4vw, 3.35rem);
            line-height: 1;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .story-panel p {
            color: var(--elegant-text);
            margin-top: 18px;
            line-height: 1.85;
        }

        .achievement-elegant {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .achievement-elegant.count-1 { grid-template-columns: minmax(280px, 500px); justify-content: center; }
        .achievement-elegant.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .elegant-achievement-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 26px;
            border-radius: 32px;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(15,23,42,.07);
        }

        .elegant-achievement-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            right: -46px;
            bottom: -46px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-accent) 24%, transparent);
        }

        .achievement-number {
            position: relative;
            z-index: 2;
            width: 54px;
            height: 54px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
            margin-bottom: 20px;
        }

        .elegant-achievement-card h3,
        .elegant-achievement-card p {
            position: relative;
            z-index: 2;
        }

        .elegant-achievement-card h3 {
            color: var(--elegant-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .elegant-achievement-card p {
            color: var(--elegant-text);
            margin-top: 10px;
            line-height: 1.8;
        }

        /* detail */
        .detail-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .elegant-card {
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            border-radius: 36px;
            box-shadow: 0 20px 48px rgba(15,23,42,.08);
            padding: 30px;
        }

        .elegant-card h3 {
            color: var(--elegant-dark);
            font-size: 2rem;
            font-weight: 950;
            margin: 0;
        }

        .detail-list {
            display: grid;
            gap: 14px;
            margin-top: 24px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--elegant-primary) 17%, transparent);
        }

        .detail-row .label {
            color: var(--elegant-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--elegant-dark);
            font-weight: 900;
            line-height: 1.65;
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
            border-radius: 26px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--elegant-soft) 88%, white), white);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 11%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--elegant-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--elegant-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 22px;
            overflow: hidden;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(15,23,42,.08);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 300px;
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
            color: var(--elegant-dark);
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--elegant-soft) 90%, white));
        }

        /* gallery */
        .gallery-elegant {
            display: grid;
            grid-template-columns: .86fr 1.14fr;
            gap: 18px;
            margin-top: 38px;
            align-items: stretch;
        }

        .gallery-elegant-feature,
        .gallery-elegant-card {
            overflow: hidden;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(15,23,42,.08);
        }

        .gallery-elegant-feature {
            border-radius: 44px;
            padding: 12px;
        }

        .gallery-elegant-feature img {
            width: 100%;
            height: 560px;
            object-fit: cover;
            border-radius: 32px;
            display: block;
        }

        .gallery-elegant-side {
            display: grid;
            gap: 18px;
        }

        .gallery-elegant-card {
            border-radius: 34px;
            padding: 10px;
        }

        .gallery-elegant-card img {
            width: 100%;
            height: 262px;
            object-fit: cover;
            border-radius: 24px;
            display: block;
        }

        /* gifts */
        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
            padding: 26px;
            border-radius: 34px;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 20px 44px rgba(15,23,42,.08);
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -50px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--elegant-accent) 24%, transparent);
        }

        .gift-card h3,
        .gift-copy-box,
        .gift-card p { position: relative; z-index: 2; }

        .gift-card h3 {
            color: var(--elegant-dark);
            font-size: 1.4rem;
            font-weight: 950;
        }

        .gift-copy-box {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px;
            border-radius: 20px;
            background: color-mix(in srgb, var(--elegant-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 11%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--elegant-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--elegant-primary);
            font-size: 1.1rem;
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
            background: linear-gradient(135deg, var(--elegant-primary), var(--elegant-secondary));
        }

        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        /* rsvp */
        .rsvp-wrap {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(15,23,42,.08);
            border-radius: 30px;
        }

        .form-card { padding: 28px; }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            padding: 20px;
            text-align: center;
        }

        .summary-card strong {
            display: block;
            color: var(--elegant-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--elegant-text);
            font-size: 12px;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .message-card { padding: 22px; }

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
            background: color-mix(in srgb, var(--elegant-primary) 10%, white);
            color: var(--elegant-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
            border-radius: 42px;
            padding: 48px 34px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--elegant-primary) 8%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--elegant-accent) 23%, transparent), transparent 36%),
                rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--elegant-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(15,23,42,.08);
        }

        @media (max-width: 1080px) {
            .elegant-hero,
            .detail-layout,
            .elegant-story-layout,
            .gift-grid,
            .gallery-elegant {
                grid-template-columns: 1fr;
            }

            .elegant-portrait { min-height: auto; }
            .portrait-arch { min-height: 560px; }
            .portrait-arch img.cover-photo,
            .portrait-empty { min-height: 560px; height: auto; }
            .date-plaque,
            .host-note {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: auto;
                margin-top: 14px;
            }

            .achievement-elegant,
            .achievement-elegant.count-3 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .gallery-elegant-feature img { height: 380px; }
        }

        @media (max-width: 640px) {
            .elegant-shell { padding: 0; }
            .elegant-wrap { border-radius: 0; box-shadow: none; }
            .elegant-section,
            .elegant-hero { padding: 72px 22px; }
            .elegant-section.compact { padding-top: 64px; padding-bottom: 64px; }

            .hero-editorial { text-align: center; }
            .hero-elegant-title {
                font-size: clamp(2.45rem, 12.5vw, 3.9rem);
                line-height: .99;
                letter-spacing: -.055em;
            }
            .hero-elegant-desc { font-size: 1rem; }
            .elegant-actions { justify-content: center; }

            .graduate-signature {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .signature-mark {
                min-height: 82px;
            }

            .elegant-info-row,
            .achievement-elegant,
            .achievement-elegant.count-1,
            .achievement-elegant.count-3,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1 {
                grid-template-columns: 1fr;
            }

            .portrait-arch {
                min-height: 470px;
                border-radius: 160px 160px 32px 32px;
            }

            .portrait-arch::before {
                border-radius: 138px 138px 24px 24px;
            }

            .portrait-arch img.cover-photo,
            .portrait-empty {
                min-height: 470px;
                height: auto;
            }

            .portrait-empty { padding: 30px; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .gallery-elegant-feature img,
            .gallery-elegant-card img { height: 260px; }
            .floating-actions { right: 10px; transform: translateY(-50%) scale(.9); transform-origin: right center; }
        }

        /* =====================================================
        LUXURY ELEGANT GRADUATION ANIMATION
        Tempel paling bawah sebelum style
        ===================================================== */

        .elegant-reveal,
        .elegant-section > p,
        .elegant-section > h1,
        .elegant-section > h2,
        .elegant-section > h3,
        .elegant-label,
        .elegant-title,
        .elegant-gradient,
        .elegant-nav,
        .elegant-hero,
        .hero-editorial,
        .elegant-kicker,
        .hero-elegant-title,
        .hero-elegant-desc,
        .graduate-signature,
        .signature-copy,
        .signature-mark,
        .elegant-actions,
        .elegant-info-card,
        .elegant-portrait,
        .portrait-arch,
        .portrait-empty,
        .portrait-icon,
        .date-plaque,
        .host-note,
        .graduate-elegant-card,
        .graduate-photo,
        .graduate-placeholder,
        .graduate-role,
        .story-panel,
        .elegant-achievement-card,
        .achievement-number,
        .elegant-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-elegant-feature,
        .gallery-elegant-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .elegant-btn {
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

        .elegant-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Hero awal langsung tampil mewah */
        .elegant-nav {
            animation: elegantNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .hero-editorial {
            animation: elegantHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .elegant-kicker {
            animation: elegantFadeDown .85s ease .18s both;
        }

        #opening .hero-elegant-title {
            animation: elegantTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .hero-elegant-desc {
            animation: elegantFadeUp .85s ease .48s both;
        }

        #opening .graduate-signature {
            animation: elegantFadeUp .9s ease .62s both;
        }

        #opening .elegant-actions {
            animation: elegantFadeUp .9s ease .74s both;
        }

        #opening .elegant-info-card {
            animation: elegantFadeUp .9s ease .84s both;
        }

        #opening .portrait-arch {
            animation:
                elegantPortraitEnter 1.12s cubic-bezier(.2, .8, .2, 1) .28s both,
                elegantPortraitFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .date-plaque {
            animation:
                elegantPlaqueEnter .95s cubic-bezier(.2, .8, .2, 1) .72s both,
                elegantPlaqueFloat 4.8s ease-in-out 1.5s infinite;
        }

        #opening .host-note {
            animation:
                elegantNoteEnter .95s cubic-bezier(.2, .8, .2, 1) .82s both,
                elegantNoteFloat 5s ease-in-out 1.6s infinite;
        }

        /* Background hidup */
        .elegant-wrap {
            animation: elegantWrapGlow 8s ease-in-out infinite alternate;
        }

        .elegant-wrap::before {
            animation: elegantGridMove 20s linear infinite;
        }

        .elegant-wrap::after,
        .hero-editorial::before,
        .signature-mark::before,
        .signature-mark::after,
        .elegant-info-card::after,
        .graduate-elegant-card::after,
        .story-panel::after,
        .elegant-achievement-card::after,
        .gift-card::after {
            animation: elegantDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label glow */
        .elegant-label::before,
        .elegant-kicker::before {
            animation: elegantLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Button shine */
        .elegant-btn,
        button.elegant-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .elegant-btn::after,
        button.elegant-btn::after,
        .copy-gift-btn::after,
        button[onclick*="clipboard"]::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -80%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.58), transparent);
            animation: elegantButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover mewah desktop */
        @media (hover: hover) {
            .graduate-signature:hover,
            .elegant-info-card:hover,
            .portrait-arch:hover,
            .date-plaque:hover,
            .host-note:hover,
            .graduate-elegant-card:hover,
            .story-panel:hover,
            .elegant-achievement-card:hover,
            .elegant-card:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-elegant-feature:hover,
            .gallery-elegant-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--elegant-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 88px color-mix(in srgb, var(--elegant-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--elegant-accent) 30%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .portrait-arch:hover img,
            .gallery-elegant-feature:hover img,
            .gallery-elegant-card:hover img,
            .graduate-elegant-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .portrait-arch img,
        .gallery-elegant-feature img,
        .gallery-elegant-card img,
        .graduate-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: elegantNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon pulse */
        .portrait-icon,
        .graduate-placeholder,
        .achievement-number,
        .gift-number,
        .message-badge {
            animation: elegantSoftPulse 3s ease-in-out infinite;
        }

        /* Floating actions */
        .floating-actions a,
        .floating-action-button {
            animation: elegantFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes elegantNavEnter {
            from { opacity: 0; transform: translateY(-18px) scale(.96); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes elegantHeroCopyIn {
            from { opacity: 0; transform: translateX(-24px) translateY(34px) scale(.96); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes elegantFadeDown {
            from { opacity: 0; transform: translateY(-20px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes elegantFadeUp {
            from { opacity: 0; transform: translateY(26px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes elegantTitleIn {
            from { opacity: 0; transform: translateY(38px) scale(.94); filter: blur(12px); letter-spacing: -.02em; }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes elegantPortraitEnter {
            from { opacity: 0; transform: translateX(30px) translateY(36px) scale(.92) rotate(3deg); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes elegantPortraitFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.012); }
        }

        @keyframes elegantPlaqueEnter {
            from { opacity: 0; transform: translateY(30px) scale(.86) rotate(-6deg); filter: blur(9px); }
            to { opacity: 1; transform: translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes elegantPlaqueFloat {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-8px) rotate(-1.5deg); }
        }

        @keyframes elegantNoteEnter {
            from { opacity: 0; transform: translateY(24px) scale(.9); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes elegantNoteFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        @keyframes elegantWrapGlow {
            from {
                box-shadow: 0 34px 90px rgba(15, 23, 42, .08);
            }
            to {
                box-shadow:
                    0 42px 118px rgba(15, 23, 42, .12),
                    0 0 58px color-mix(in srgb, var(--elegant-accent) 28%, transparent);
            }
        }

        @keyframes elegantGridMove {
            from { background-position: 0 0, 0 0; }
            to { background-position: 150px 150px, 150px 150px; }
        }

        @keyframes elegantDecorFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.04); }
        }

        @keyframes elegantLabelGlow {
            from { box-shadow: 0 0 0 color-mix(in srgb, var(--elegant-primary) 0%, transparent); filter: saturate(1); }
            to { box-shadow: 0 0 22px color-mix(in srgb, var(--elegant-primary) 24%, transparent); filter: saturate(1.12); }
        }

        @keyframes elegantButtonShine {
            0%, 48% { left: -80%; }
            75%, 100% { left: 130%; }
        }

        @keyframes elegantNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--elegant-primary) 16%, transparent); }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--elegant-primary) 38%, transparent),
                    0 0 34px color-mix(in srgb, var(--elegant-accent) 48%, transparent);
            }
        }

        @keyframes elegantSoftPulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-3px) scale(1.035); }
        }

        @keyframes elegantFloatingButton {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .elegant-reveal,
            .elegant-section > p,
            .elegant-section > h1,
            .elegant-section > h2,
            .elegant-section > h3,
            .elegant-label,
            .elegant-title,
            .elegant-gradient,
            .elegant-nav,
            .elegant-hero,
            .hero-editorial,
            .elegant-kicker,
            .hero-elegant-title,
            .hero-elegant-desc,
            .graduate-signature,
            .elegant-info-card,
            .elegant-portrait,
            .portrait-arch,
            .date-plaque,
            .host-note,
            .graduate-elegant-card,
            .story-panel,
            .elegant-achievement-card,
            .elegant-card,
            .countdown-card,
            .map-card,
            .gallery-elegant-feature,
            .gallery-elegant-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .elegant-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            #opening .portrait-arch {
                animation:
                    elegantFadeUp .9s ease .3s both,
                    elegantFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .elegant-reveal,
            .elegant-section > p,
            .elegant-section > h1,
            .elegant-section > h2,
            .elegant-section > h3,
            .elegant-label,
            .elegant-title,
            .elegant-gradient,
            .elegant-nav,
            .elegant-hero,
            .hero-editorial,
            .elegant-kicker,
            .hero-elegant-title,
            .hero-elegant-desc,
            .graduate-signature,
            .signature-copy,
            .signature-mark,
            .elegant-actions,
            .elegant-info-card,
            .elegant-portrait,
            .portrait-arch,
            .portrait-empty,
            .portrait-icon,
            .date-plaque,
            .host-note,
            .graduate-elegant-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .story-panel,
            .elegant-achievement-card,
            .achievement-number,
            .elegant-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-elegant-feature,
            .gallery-elegant-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .elegant-btn,
            .elegant-wrap,
            .elegant-wrap::before,
            .elegant-wrap::after,
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

        /* =====================================================
        FIX ANCHOR NAVBAR ELEGANT GRADUATION
        ===================================================== */

        html {
            scroll-padding-top: 150px;
        }

        #opening,
        #graduate,
        #achievement,
        #detail,
        #gallery,
        #gift,
        #message {
            scroll-margin-top: 150px;
        }

        .elegant-nav {
            top: 14px !important;
        }

        @media (max-width: 1080px) {
            html {
                scroll-padding-top: 165px;
            }

            #opening,
            #graduate,
            #achievement,
            #detail,
            #gallery,
            #gift,
            #message {
                scroll-margin-top: 165px;
            }
        }

        @media (max-width: 640px) {
            html {
                scroll-padding-top: 180px;
            }

            #opening,
            #graduate,
            #achievement,
            #detail,
            #gallery,
            #gift,
            #message {
                scroll-margin-top: 180px;
            }

            .elegant-nav {
                top: 10px !important;
                max-width: calc(100% - 28px);
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'slate';

    $themes = [
        'maroon' => [
            'primary' => '#8f1d3f',
            'secondary' => '#c2415d',
            'accent' => '#f4d7df',
            'dark' => '#32111d',
            'text' => '#6b4a55',
            'soft' => '#fffafa',
            'glow1' => 'rgba(143, 29, 63, .045)',
            'glow2' => 'rgba(244, 215, 223, .36)',
        ],

        'emerald' => [
            'primary' => '#17735d',
            'secondary' => '#2fa58a',
            'accent' => '#dff5eb',
            'dark' => '#12352e',
            'text' => '#516a62',
            'soft' => '#fbfffd',
            'glow1' => 'rgba(23, 115, 93, .045)',
            'glow2' => 'rgba(223, 245, 235, .44)',
        ],

        'navy' => [
            'primary' => '#244f9e',
            'secondary' => '#4f7fd8',
            'accent' => '#e7efff',
            'dark' => '#111827',
            'text' => '#526074',
            'soft' => '#fbfdff',
            'glow1' => 'rgba(36, 79, 158, .045)',
            'glow2' => 'rgba(231, 239, 255, .55)',
        ],

        'rose' => [
            'primary' => '#b83273',
            'secondary' => '#de77a8',
            'accent' => '#fdebf4',
            'dark' => '#421629',
            'text' => '#72576a',
            'soft' => '#fffafd',
            'glow1' => 'rgba(184, 50, 115, .045)',
            'glow2' => 'rgba(253, 235, 244, .55)',
        ],

        'gold' => [
            'primary' => '#9a6a1f',
            'secondary' => '#c69236',
            'accent' => '#fff4cf',
            'dark' => '#3c2b12',
            'text' => '#6d6048',
            'soft' => '#fffdf7',
            'glow1' => 'rgba(154, 106, 31, .045)',
            'glow2' => 'rgba(255, 244, 207, .58)',
        ],

        'slate' => [
            'primary' => '#5d6b7a',
            'secondary' => '#94a3b8',
            'accent' => '#f1f5f9',
            'dark' => '#1f2937',
            'text' => '#64748b',
            'soft' => '#ffffff',
            'glow1' => 'rgba(100, 116, 139, .035)',
            'glow2' => 'rgba(241, 245, 249, .72)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];
    $firstPhoto = $invitation->photos->first();
    $photos = $invitation->photos->values();
    $giftCount = $invitation->gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Elegant Graduate';
    $eventName = $invitation->event_name ?: 'Wisuda Elegan';
    $hostName = $invitation->host_name ?: null;
    $firstGraduate = $invitation->people->first();
    $graduateCount = $invitation->people->count();
    $graduateName = $firstGraduate?->name ?: ($invitation->host_name ?: 'Nama Wisudawan');
    $graduateHeroName = $graduateCount >= 2 ? 'Wisudawan / Wisudawati' : $graduateName;
    $graduateHeroSubtitle = $graduateCount >= 2 ? null : ($firstGraduate?->subtitle ?: 'Wisudawan / Wisudawati');

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

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));

    $shareMessage =
        "Halo Bapak/Ibu/Saudara/i,\n\n" .
        "Dengan penuh rasa syukur dan bangga, kami mengundang Anda untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) { $shareMessage .= "Diselenggarakan oleh: {$hostName}\n"; }
    $shareMessage .= "Tanggal: {$eventDateText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }

    $shareMessage .=
        "\nSilakan buka undangan lengkap melalui link berikut:\n" .
        $shareUrl .
        "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\nTerima kasih.";

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

            $calendarTitle = trim(($invitation->event_name ?: 'Elegant Graduation') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan wisuda elegan') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }

    $mapOpenUrl = $isOnlineEvent ? null : ($mapData['open_url'] ?? $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : ($mapData['embed_url'] ?? null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Tempat';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Graduation' : 'Lokasi Wisuda');

    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang wisuda online atau webinar.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $elegantHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $elegantHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --elegant-primary: {{ $activeTheme['primary'] }};
        --elegant-secondary: {{ $activeTheme['secondary'] }};
        --elegant-accent: {{ $activeTheme['accent'] }};
        --elegant-dark: {{ $activeTheme['dark'] }};
        --elegant-text: {{ $activeTheme['text'] }};
        --elegant-soft: {{ $activeTheme['soft'] }};
        --elegant-glow-1: {{ $activeTheme['glow1'] }};
        --elegant-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="elegant-shell">
        <div class="elegant-wrap">
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
                   loop>
            </audio>

            <nav class="elegant-nav">
                <a href="#graduate">Wisudawan</a>
                <a href="#detail">Detail</a>
                @if ($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if ($giftCount) <a href="#gift">Hadiah</a> @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="elegant-hero">
                <div class="hero-editorial">
                    <div class="elegant-kicker">{{ $eventName }}</div>

                    <h1 class="responsive-text elegant-title elegant-gradient hero-elegant-title">
                        {{ $eventTitle }}
                    </h1>

                    <p class="responsive-text hero-elegant-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan bangga, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang elegan, hangat, dan penuh makna.' }}
                    </p>

                    <div class="graduate-signature">
                        <div class="signature-copy">
                            <small>Yang Berbahagia</small>
                            <strong class="responsive-text">{{ $graduateHeroName }}</strong>
                            @if ($graduateHeroSubtitle)
                                <span class="responsive-text">{{ $graduateHeroSubtitle }}</span>
                            @endif
                        </div>
                        <div class="signature-mark" aria-hidden="true"></div>
                    </div>

                    <div class="elegant-actions">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="elegant-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="elegant-btn">Lihat Detail</a>
                        @endif

                        <a href="#detail" class="elegant-btn secondary">Detail Acara</a>
                        <a href="#message" class="elegant-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="elegant-info-row">
                        <div class="elegant-info-card">
                            <small>Tanggal</small>
                            <strong class="elegant-date-line">
                                @if ($invitation->event_date)
                                    <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span>Belum diatur</span>
                                @endif
                            </strong>
                        </div>

                        <div class="elegant-info-card">
                            <small>Waktu</small>
                            <strong class="elegant-time-line">
                                @if ($invitation->event_time)
                                    <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>
                                    @if ($invitation->event_end_time)
                                        <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                    @endif
                                @else
                                    <span>Belum diatur</span>
                                @endif
                            </strong>
                        </div>

                        <div class="elegant-info-card">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">{{ $accessName }}</strong>
                        </div>
                    </div>
                </div>

                <div class="elegant-portrait">
                    <div class="portrait-arch">
                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Wisuda" class="cover-photo">
                        @elseif ($firstPhoto)
                            <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Wisuda" class="cover-photo">
                        @else
                            <div class="portrait-empty">
                                <div class="portrait-icon"><img src="{{ asset('assets/icons/Topi.png') }}" alt="Topi" class="w-10 h-10"></div>
                                <h2 class="responsive-text">Elegant Moment of Graduation</h2>
                                <p class="responsive-text">Rayakan pencapaian, doa keluarga, dan langkah baru menuju masa depan yang lebih indah.</p>
                            </div>
                        @endif
                    </div>

                    <div class="date-plaque">
                        @if ($invitation->event_date)
                            <strong>{{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('M Y') }}</span>
                        @else
                            <strong>--</strong>
                            <span>Tanggal</span>
                        @endif
                    </div>

                    <div class="host-note">
                        <small>Hosted by</small>
                        <strong class="responsive-text">{{ $hostName ?: 'Keluarga Besar' }}</strong>
                    </div>
                </div>
            </section>

            {{-- GRADUATE --}}
            <section id="graduate" class="elegant-section compact text-center">
                <p class="elegant-label justify-center">The Graduate</p>
                <h2 class="responsive-text elegant-title text-5xl md:text-6xl mt-6">Wisudawan / Wisudawati</h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--elegant-text); line-height: 1.85;">
                    Bagian ini menampilkan tokoh utama acara, lulusan, atau wisudawan yang sedang merayakan momen kelulusan.
                </p>

                <div class="graduate-elegant-grid {{ $invitation->people->count() <= 1 ? 'single-graduate' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="graduate-elegant-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="graduate-photo">
                            @else
                                <div class="graduate-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'W', 0, 1)) }}</div>
                            @endif

                            <span class="graduate-role">{{ $person->subtitle ?: 'Graduate' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Wisudawan' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="graduate-elegant-card">
                            <div class="graduate-placeholder">W</div>
                            <span class="graduate-role">Graduate</span>
                            <h3 class="responsive-text">Nama Wisudawan</h3>
                            <p>Data wisudawan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ACHIEVEMENT --}}
            @if ($highlightCount || $invitation->seminar_about_title)
                <section id="achievement" class="elegant-section compact">
                    <div class="section-head">
                        <p class="elegant-label justify-center">Elegant Story</p>
                        <h2 class="responsive-text elegant-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Perjalanan, Prestasi, dan Masa Depan' }}
                        </h2>
                        <p class="responsive-text desc">
                            {{ $hostName
                                ? 'Acara ini diselenggarakan oleh ' . $hostName . ' sebagai momen penuh rasa syukur untuk merayakan pencapaian dan langkah baru.'
                                : 'Momen wisuda adalah perayaan atas doa, perjuangan, pencapaian, dan awal perjalanan baru yang penuh harapan.'
                            }}
                        </p>
                    </div>

                    <div class="elegant-story-layout">
                        <div class="story-panel">
                            <div class="big-word">Grace</div>
                            <h3>Stories of Achievement</h3>
                            <p>Setiap poin menjadi cerita kecil tentang proses, kebanggaan, dan masa depan yang siap disambut dengan elegan.</p>
                        </div>

                        @if ($highlightCount)
                            <div class="achievement-elegant {{ $highlightGridClass }}">
                                @foreach ($elegantHighlights as $index => $highlight)
                                    <div class="elegant-achievement-card">
                                        <div class="achievement-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                                        @if (!empty($highlight['title']))
                                            <h3 class="responsive-text">{{ $highlight['title'] }}</h3>
                                        @endif

                                        @if (!empty($highlight['description']))
                                            <p class="responsive-text">{{ $highlight['description'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="elegant-section compact">
                <div class="section-head">
                    <p class="elegant-label justify-center">Schedule & Venue</p>
                    <h2 class="elegant-title text-5xl md:text-6xl mt-6">Detail Acara Wisuda</h2>
                    <p class="responsive-text desc">Simpan jadwal dan pastikan hadir pada momen kelulusan yang penuh kebanggaan ini.</p>
                </div>

                <div class="detail-layout">
                    <div class="elegant-card">
                        <h3>Informasi Acara</h3>
                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label ml-2">Acara</div>
                                <div class="value responsive-text ml-2">{{ $eventName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value elegant-date-line ml-2">
                                    @if ($invitation->event_date)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                        @if ($invitation->event_end_date)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Waktu</div>
                                <div class="value elegant-time-line ml-2">
                                    @if ($invitation->event_time)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>
                                        @if ($invitation->event_end_time)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Mode</div>
                                <div class="value responsive-text ml-2">
                                    {{ $isOnlineEvent ? 'Online Graduation' : 'Offline Graduation' }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">{{ $accessTypeLabel }}</div>
                                <div class="value responsive-text ml-2">{{ $accessName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div>
                                <div class="value responsive-text ml-2">{{ $accessDescription }}</div>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="elegant-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="elegant-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="elegant-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black" style="color: var(--elegant-text);" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Countdown Graduation</h3>
                            <p class="responsive-text mt-3 leading-7" style="color: var(--elegant-text);">
                                Persiapkan diri untuk hadir dan ikut merayakan hari yang penuh rasa bangga ini.
                            </p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div>
                            </div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>

                                                <p class="responsive-text font-black mt-3">
                                                    {{ $accessName }}
                                                </p>

                                                <p class="responsive-text mt-2" style="color: var(--elegant-text);">
                                                    {{ $accessDescription }}
                                                </p>

                                                <p class="responsive-text mt-4 font-bold" style="color: var(--elegant-primary);">
                                                    Join Online →
                                                </p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>

                                                <p class="responsive-text font-black mt-3">
                                                    {{ $accessName }}
                                                </p>

                                                <p class="responsive-text mt-2" style="color: var(--elegant-text);">
                                                    Link online belum ditambahkan.
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe
                                            src="{{ $mapEmbedUrl }}"
                                            class="map-frame"
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            allowfullscreen>
                                        </iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>

                                                <p class="responsive-text font-black mt-3">
                                                    {{ $accessName }}
                                                </p>

                                                <p class="responsive-text mt-2" style="color: var(--elegant-text);">
                                                    {{ $accessDescription }}
                                                </p>

                                                <p class="responsive-text mt-4 font-bold" style="color: var(--elegant-primary);">
                                                    Buka Google Maps →
                                                </p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>

                                                <p class="responsive-text font-black mt-3">
                                                    {{ $accessName }}
                                                </p>

                                                <p class="responsive-text mt-2" style="color: var(--elegant-text);">
                                                    {{ $accessDescription }}
                                                </p>
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
                <section id="gallery" class="elegant-section compact text-center">
                    <p class="elegant-label justify-center">Elegant Memories</p>
                    <h2 class="elegant-title text-5xl md:text-6xl mt-6">Galeri Wisuda</h2>
                    <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--elegant-text); line-height: 1.85;">
                        Kenangan istimewa dari momen kelulusan yang penuh rasa syukur dan kebanggaan.
                    </p>

                    <div class="gallery-elegant">
                        @if ($photos->first())
                            <div class="gallery-elegant-feature">
                                <img src="{{ asset('storage/' . $photos->first()->image_path) }}" alt="Galeri Wisuda">
                            </div>
                        @endif

                        <div class="gallery-elegant-side">
                            @foreach ($photos->slice(1) as $photo)
                                <div class="gallery-elegant-card">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="elegant-section compact">
                    <div class="section-head">
                        <p class="elegant-label justify-center">Gift & Appreciation</p>
                        <h2 class="elegant-title text-5xl md:text-6xl mt-6">Kirim Hadiah</h2>
                        <p class="responsive-text desc">Jika berkenan, tamu dapat mengirimkan hadiah digital melalui informasi berikut.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Hadiah Digital';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>
                                        <div class="gift-number responsive-text">{{ $giftNumber }}</div>
                                        <p class="responsive-text text-sm mt-2" style="color: var(--elegant-text);">Atas Nama {{ $giftName }}</p>
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
            <section id="message" class="elegant-section compact">
                <div class="text-center">
                    <p class="elegant-label justify-center">RSVP & Wishes</p>
                    <h2 class="elegant-title text-5xl md:text-6xl mt-6">Ucapan & Kehadiran</h2>
                    <p class="responsive-text mt-4 max-w-2xl mx-auto" style="color: var(--elegant-text); line-height: 1.85;">
                        Kirimkan ucapan terbaik dan konfirmasi kehadiran Anda.
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

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4">
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

                        <button type="submit" class="w-full elegant-btn">Kirim Ucapan</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong><span>Tidak hadir</span></div>
                        <div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong><span>Hadir</span></div>
                        <div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong><span>Ragu</span></div>
                    </div>

                    <div class="message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="message-card">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black" style="color: var(--elegant-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--elegant-text);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--elegant-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p style="color: var(--elegant-text);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="elegant-section text-center">
                <div class="closing-card">
                    <p class="elegant-label justify-center">Thank You</p>
                    <h2 class="responsive-text elegant-title elegant-gradient text-5xl md:text-7xl mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--elegant-text);">
                        Terima kasih atas doa, kehadiran, dan dukungan yang diberikan. Semoga momen kelulusan ini menjadi awal perjalanan baru yang penuh keberkahan dan kebahagiaan.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--elegant-dark);">{{ $eventTitle }}</h3>
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

                function formatNumber(number) { return String(number).padStart(2, '0'); }

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
                            ? 'Hitung mundur menuju acara'
                            : 'Acara sedang berlangsung atau telah dimulai';
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            const copyButtons = document.querySelectorAll('.copy-gift-btn');
            copyButtons.forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = this.getAttribute('data-copy');
                    if (!value) return;

                    try {
                        await navigator.clipboard.writeText(value);
                        this.textContent = 'Tersalin';
                        this.classList.add('copied');

                        setTimeout(() => {
                            this.textContent = 'Salin';
                            this.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        const tempInput = document.createElement('input');
                        tempInput.value = value;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);

                        this.textContent = 'Tersalin';
                        this.classList.add('copied');

                        setTimeout(() => {
                            this.textContent = 'Salin';
                            this.classList.remove('copied');
                        }, 1800);
                    }
                });
            });

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
                    if (scrollIcon && scrollIcon.dataset.iconOn) scrollIcon.src = scrollIcon.dataset.iconOn;
                } else {
                    scrollToggle.classList.remove('is-active');
                    if (scrollIcon && scrollIcon.dataset.iconOff) scrollIcon.src = scrollIcon.dataset.iconOff;

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
                    if (autoScrollActive) autoScrollStep();
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
            | Luxury Scroll Reveal - Elegant Graduation
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .elegant-section > p,
                .elegant-section > h1,
                .elegant-section > h2,
                .elegant-section > h3,
                .elegant-label,
                .elegant-title,
                .elegant-gradient,
                .elegant-nav,
                .elegant-hero,
                .hero-editorial,
                .elegant-kicker,
                .hero-elegant-title,
                .hero-elegant-desc,
                .graduate-signature,
                .signature-copy,
                .signature-mark,
                .elegant-actions,
                .elegant-info-card,
                .elegant-portrait,
                .portrait-arch,
                .portrait-empty,
                .portrait-icon,
                .date-plaque,
                .host-note,
                .graduate-elegant-card,
                .graduate-photo,
                .graduate-placeholder,
                .graduate-role,
                .story-panel,
                .elegant-achievement-card,
                .achievement-number,
                .elegant-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-elegant-feature,
                .gallery-elegant-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .elegant-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('elegant-show');
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
            | FIX NAVBAR TERPOTONG - Elegant Graduation
            |--------------------------------------------------------------------------
            */
            const elegantNavLinks = document.querySelectorAll('.elegant-nav a[href^="#"], .elegant-actions a[href^="#"]');

            function getElegantOffset() {
                const navElement = document.querySelector('.elegant-nav');
                const navHeight = navElement ? navElement.offsetHeight : 0;

                if (window.innerWidth <= 640) {
                    return navHeight + 105;
                }

                if (window.innerWidth <= 1080) {
                    return navHeight + 88;
                }

                return navHeight + 76;
            }

            elegantNavLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    const targetId = link.getAttribute('href');

                    if (!targetId || targetId === '#') {
                        return;
                    }

                    const targetElement = document.querySelector(targetId);

                    if (!targetElement) {
                        return;
                    }

                    event.preventDefault();

                    const targetPosition =
                        targetElement.getBoundingClientRect().top +
                        window.pageYOffset -
                        getElegantOffset();

                    window.scrollTo({
                        top: Math.max(targetPosition, 0),
                        behavior: 'smooth'
                    });
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Anti Inspect Ringan Tanpa Notice
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
        });
    </script>
</body>
</html>
