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
            color: #0f172a;
            background:
                radial-gradient(circle at top left, color-mix(in srgb, var(--tech-primary) 10%, transparent), transparent 34%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--tech-accent) 12%, transparent), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 48%, #ffffff 100%);
        }

        .tech-shell {
            width: min(100%, 1220px);
            margin: 0 auto;
            padding: 24px;
        }

        .tech-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 46px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.96)),
                radial-gradient(circle at 15% 10%, color-mix(in srgb, var(--tech-primary) 10%, transparent), transparent 28%),
                radial-gradient(circle at 85% 15%, color-mix(in srgb, var(--tech-accent) 12%, transparent), transparent 28%);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 34px 100px rgba(15, 23, 42, .10);
        }

        .tech-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(15, 23, 42, .045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, .045) 1px, transparent 1px);
            background-size: 58px 58px;
            mask-image: linear-gradient(180deg, black 0%, rgba(0,0,0,.65) 50%, transparent 92%);
            pointer-events: none;
            z-index: 0;
        }

        .tech-wrap::after {
            content: "";
            position: absolute;
            width: 680px;
            height: 680px;
            right: -260px;
            top: -260px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--tech-accent) 18%, transparent) 0%, transparent 62%);
            filter: blur(2px);
            pointer-events: none;
            z-index: 0;
        }

        .tech-wrap > * {
            position: relative;
            z-index: 1;
        }

        .tech-section {
            min-height: 100vh;
            padding: 96px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tech-section.compact {
            min-height: auto;
            padding-top: 88px;
            padding-bottom: 88px;
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

        .tech-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--tech-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .28em;
            text-transform: uppercase;
        }

        .tech-label::before {
            content: "";
            width: 44px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--tech-primary), var(--tech-accent));
            display: inline-block;
        }

        .tech-title {
            color: #0f172a;
            letter-spacing: -.07em;
            line-height: .95;
            font-weight: 950;
        }

        .tech-gradient-text {
            background: linear-gradient(135deg, #0f172a, var(--tech-primary), var(--tech-accent));
            -webkit-background-clip: text;
            color: transparent;
        }

        .tech-card {
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 34px;
            box-shadow: 0 20px 56px rgba(15, 23, 42, .09);
            padding: 30px;
            color: #0f172a;
            backdrop-filter: blur(18px);
        }

        .tech-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            padding: 14px 26px;
            color: white;
            text-decoration: none;
            font-weight: 950;
            background: linear-gradient(135deg, var(--tech-primary), var(--tech-secondary));
            box-shadow: 0 18px 42px color-mix(in srgb, var(--tech-primary) 24%, transparent);
            border: 1px solid rgba(255,255,255,.16);
            cursor: pointer;
        }

        .tech-btn.secondary {
            background: #ffffff;
            color: #0f172a;
            border: 1px solid rgba(15, 23, 42, .10);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .07);
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
            background: rgba(255,255,255,.94);
            box-shadow: 0 14px 30px rgba(15,23,42,.16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--tech-accent) 28%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .tech-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            margin: 18px auto 0;
            width: fit-content;
            max-width: calc(100% - 32px);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(15, 23, 42, .08);
            backdrop-filter: blur(18px);
            box-shadow: 0 16px 42px rgba(15, 23, 42, .10);
            overflow-x: auto;
        }

        .tech-nav a {
            flex: 0 0 auto;
            color: #475569;
            text-decoration: none;
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
        }

        .tech-nav a:hover {
            color: var(--tech-primary);
            background: color-mix(in srgb, var(--tech-primary) 8%, white);
        }

        .hero-premium-grid {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 54px;
            align-items: center;
        }

        .hero-copy {
            max-width: 680px;
        }

        .hero-badge-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .hero-badge {
            border-radius: 999px;
            padding: 10px 14px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, .08);
            color: #334155;
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
        }

        .metric-strip {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 40px;
        }

        .metric-card {
            border-radius: 30px;
            padding: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 20px 56px rgba(15, 23, 42, .07);
            text-align: center;
        }

        .metric-card .value {
            color: #0f172a;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .metric-card .text {
            color: #94a3b8;
            margin-top: 10px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .conference-visual {
            position: relative;
            min-height: 560px;
        }

        .summit-frame {
            position: absolute;
            inset: 0 0 auto auto;
            width: min(100%, 460px);
            min-height: 560px;
            border-radius: 42px;
            padding: 14px;
            background: linear-gradient(135deg, var(--tech-primary), var(--tech-accent));
            box-shadow: 0 28px 80px rgba(15, 23, 42, .18);
        }

        .summit-screen {
            position: relative;
            overflow: hidden;
            min-height: 532px;
            border-radius: 32px;
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--tech-accent) 22%, white), transparent 36%),
                linear-gradient(145deg, #ffffff, #f8fafc);
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .summit-screen img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .24;
        }

        .summit-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.82)),
                radial-gradient(circle at 76% 18%, rgba(255,255,255,.4), transparent 28%);
            z-index: 1;
        }

        .summit-top,
        .summit-middle,
        .summit-bottom {
            position: relative;
            z-index: 2;
        }

        .summit-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .summit-chip {
            border-radius: 999px;
            padding: 9px 13px;
            background: #ffffff;
            color: var(--tech-primary);
            border: 1px solid rgba(15, 23, 42, .08);
            font-size: 12px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: .12em;
            box-shadow: 0 12px 28px rgba(15,23,42,.08);
        }

        .summit-dots {
            display: flex;
            gap: 7px;
        }

        .summit-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .22);
        }

        .summit-year {
            font-size: clamp(4rem, 10vw, 7rem);
            font-weight: 950;
            line-height: .9;
            letter-spacing: -.08em;
            color: #0f172a;
        }

        .summit-caption {
            color: #64748b;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-size: 12px;
            margin-top: 10px;
        }

        .summit-middle h2 {
            color: #0f172a;
        }

        .summit-bottom {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .summit-mini {
            border-radius: 18px;
            padding: 12px;
            background: rgba(255,255,255,.9);
            border: 1px solid rgba(15, 23, 42, .08);
            text-align: center;
            box-shadow: 0 12px 28px rgba(15,23,42,.06);
        }

        .summit-mini p:first-child {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .summit-mini p:last-child {
            color: #0f172a;
            font-size: 13px;
            font-weight: 950;
            margin-top: 6px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 36px;
        }

        .feature-card {
            border-radius: 30px;
            padding: 26px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 20px 56px rgba(15, 23, 42, .09);
        }

        .feature-number {
            width: 46px;
            height: 46px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--tech-primary), var(--tech-accent));
            margin-bottom: 18px;
        }

        .feature-card h3 {
            color: #0f172a;
        }

        .feature-card p {
            color: #64748b;
        }

        .speaker-showcase {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-top: 38px;
        }

        .speaker-showcase.single-speaker {
            grid-template-columns: minmax(0, 390px);
            justify-content: center;
        }

        .speaker-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 36px;
            padding: 24px;
            min-height: 350px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 20px 56px rgba(15, 23, 42, .09);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .speaker-card::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -70px;
            top: -70px;
            border-radius: 999px;
            background: var(--tech-accent);
            opacity: .12;
            filter: blur(2px);
        }

        .speaker-photo,
        .speaker-placeholder {
            position: relative;
            z-index: 2;
            width: 126px;
            height: 126px;
            border-radius: 32px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--tech-accent) 18%, white), transparent 34%),
                linear-gradient(135deg, #ffffff, #f8fafc);
            border: 1px solid rgba(15,23,42,.08);
            box-shadow: 0 14px 34px rgba(15,23,42,.12);
            font-size: 42px;
            font-weight: 950;
            color: var(--tech-primary);
        }

        .speaker-card h3 {
            color: #0f172a;
        }

        .speaker-card p {
            color: #64748b;
        }

        .detail-pass-layout {
            display: grid;
            grid-template-columns: .82fr 1.18fr;
            gap: 24px;
            margin-top: 44px;
            align-items: stretch;
        }

        .event-pass {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 34px;
            background: linear-gradient(145deg, #0f172a, #1e293b);
            color: white;
            box-shadow: 0 28px 80px rgba(15, 23, 42, .22);
        }

        .event-pass::before {
            content: "";
            position: absolute;
            inset: 18px;
            border: 1px dashed rgba(255,255,255,.22);
            border-radius: 28px;
            pointer-events: none;
        }

        .event-pass::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -80px;
            top: -80px;
            border-radius: 999px;
            background: var(--tech-accent);
            opacity: .18;
        }

        .pass-content {
            position: relative;
            z-index: 2;
        }

        .pass-label {
            font-size: 11px;
            letter-spacing: .28em;
            text-transform: uppercase;
            font-weight: 950;
            color: var(--tech-accent);
        }

        .pass-title {
            font-size: clamp(2rem, 4vw, 3.8rem);
            line-height: .95;
            letter-spacing: -.06em;
            font-weight: 950;
            margin-top: 18px;
            color: white;
        }

        .pass-meta {
            display: grid;
            gap: 14px;
            margin-top: 30px;
        }

        .pass-meta-item {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 14px;
            align-items: start;
            padding: 14px 0;
            border-top: 1px solid rgba(255,255,255,.13);
        }

        .pass-meta-item .label {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .pass-meta-item .value {
            color: white;
            font-weight: 800;
            line-height: 1.65;
        }

        .pass-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .timeline-panel {
            border-radius: 38px;
            padding: 32px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 20px 56px rgba(15, 23, 42, .09);
        }

        .timeline-heading {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 26px;
        }

        .timeline-heading h3 {
            font-size: 28px;
            line-height: 1.1;
            font-weight: 950;
            color: #0f172a;
        }

        .timeline-heading p {
            color: #64748b;
            margin-top: 8px;
        }

        .modern-countdown {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .countdown-card {
            border-radius: 24px;
            padding: 22px 12px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .07);
            text-align: center;
        }

        .countdown-number {
            display: block;
            color: #0f172a;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: .16em;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 900;
        }

        .tech-date-line,
        .tech-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .tech-date-line span,
        .tech-time-line span {
            display: inline;
        }

        .pass-meta-item .value.tech-date-line,
        .pass-meta-item .value.tech-time-line {
            justify-content: flex-start;
            text-align: left;
        }

        .detail-map-card {
            margin-top: 24px;
            border-radius: 34px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 18px 48px rgba(15, 23, 42, .08);
        }

        .map-card {
            margin-top: 28px;
            border-radius: 36px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 20px 54px rgba(15,23,42,.08);
            border: 1px solid rgba(15,23,42,.08);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 340px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--tech-primary) 10%, white), transparent 32%),
                linear-gradient(135deg, #ffffff, #f8fafc);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
            text-decoration: none;
            color: #0f172a;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr 1fr;
            gap: 18px;
            margin-top: 38px;
        }

        .gallery-item {
            border-radius: 32px;
            overflow: hidden;
            background: #ffffff;
            padding: 10px;
            box-shadow: 0 18px 46px rgba(15,23,42,.10);
            border: 1px solid rgba(15,23,42,.08);
        }

        .gallery-item:nth-child(2) {
            transform: translateY(30px);
        }

        .gallery-item img {
            width: 100%;
            height: 270px;
            object-fit: cover;
            border-radius: 24px;
            display: block;
        }

        .guest-message-card {
            text-align: left;
        }

        .guest-message-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .guest-message-info {
            min-width: 0;
            flex: 1;
        }

        .guest-message-text {
            text-align: left;
            margin-left: 0;
        }

        .tech-wrap .text-slate-300 {
            color: #475569 !important;
        }

        .tech-wrap .text-slate-400 {
            color: #64748b !important;
        }

        .tech-wrap .text-white {
            color: #0f172a !important;
        }

        .event-pass .text-white,
        .event-pass .text-slate-300,
        .event-pass .text-slate-400 {
            color: inherit !important;
        }

        .event-pass .tech-btn {
            color: white !important;
        }

        .event-pass .tech-btn.secondary {
            color: #0f172a !important;
        }

        @media (max-width: 980px) {
            .tech-shell {
                padding: 16px;
            }

            .tech-section {
                padding: 86px 38px;
            }

            .hero-premium-grid,
            .feature-grid,
            .speaker-showcase,
            .detail-pass-layout,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .conference-visual {
                min-height: auto;
            }

            .summit-frame {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .summit-screen {
                min-height: 500px;
            }

            .metric-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .modern-countdown {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .gallery-item:nth-child(2) {
                transform: none;
            }

            .tech-nav {
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .tech-shell {
                padding: 0;
            }

            .tech-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .tech-section {
                padding: 76px 24px;
            }

            .tech-section.compact {
                padding-top: 70px;
                padding-bottom: 70px;
            }

            .tech-title {
                font-size: 3rem;
                line-height: 1.02;
            }

            .tech-label {
                letter-spacing: .18em;
                font-size: 11px;
            }

            .tech-label::before {
                width: 24px;
            }

            .hero-copy {
                text-align: center;
            }

            .hero-badge-row {
                justify-content: center;
            }

            .summit-screen {
                min-height: 430px;
            }

            .summit-bottom,
            .metric-strip,
            .modern-countdown {
                grid-template-columns: 1fr;
            }

            .event-pass,
            .timeline-panel {
                border-radius: 28px;
                padding: 24px;
            }

            .pass-meta-item {
                grid-template-columns: 1fr;
            }

            .floating-actions {
                right: 10px;
            }

            .gallery-item img {
                height: 220px;
            }
        }

        /* =====================================================
        HERO REMAKE - SEMINAR TECH CONFERENCE
        Lebih dinamis, tidak kaku, tetap pakai field yang sama
        ===================================================== */

        .hero-premium-grid--v2 {
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(390px, .98fr);
            gap: 42px;
            align-items: center;
        }

        .hero-copy--v2 {
            position: relative;
            max-width: 700px;
            padding-top: 10px;
        }

        .hero-copy--v2::after {
            content: "";
            position: absolute;
            left: -24px;
            top: 70px;
            width: 120px;
            height: 120px;
            border-radius: 28px;
            background: linear-gradient(135deg, var(--tech-glow-1), transparent);
            transform: rotate(-10deg);
            z-index: -1;
        }

        .hero-copy--v2 .hero-main-title {
            margin-top: 18px;
            font-size: clamp(2.7rem, 5.4vw, 4.9rem);
            line-height: .96;
            letter-spacing: -.055em;
            max-width: 620px;
        }

        .hero-summary {
            margin-top: 26px;
            color: #475569;
            line-height: 1.9;
            font-size: 1.08rem;
            max-width: 620px;
        }

        .hero-badge-row--v2 {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .hero-badge-row--v2 .hero-badge {
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
        }

        .hero-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 34px;
        }

        .metric-strip--v2 {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-top: 38px;
            max-width: 560px;
        }

        .metric-strip--v2 .metric-card {
            text-align: left;
            border-radius: 28px;
            padding: 22px 22px 20px;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(248,250,252,.96));
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
        }

        .metric-strip--v2 .metric-card::after {
            content: "";
            position: absolute;
            width: 78px;
            height: 78px;
            right: -24px;
            bottom: -24px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--tech-accent) 20%, white);
        }

        .metric-strip--v2 .metric-card:nth-child(2),
        .metric-strip--v2 .metric-card:nth-child(4) {
            transform: translateY(18px);
        }

        .metric-strip--v2 .value {
            position: relative;
            z-index: 2;
            font-size: 2.35rem;
            line-height: 1;
            font-weight: 950;
            color: #0f172a;
        }

        .metric-strip--v2 .text {
            position: relative;
            z-index: 2;
            margin-top: 10px;
            color: #94a3b8;
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .conference-visual--v2 {
            position: relative;
            min-height: 650px;
        }

        .conference-visual--v2::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            left: 10px;
            top: 70px;
            border-radius: 999px;
            background: radial-gradient(circle, var(--tech-glow-2) 0%, transparent 70%);
            filter: blur(2px);
            z-index: 0;
        }

        .conference-visual--v2::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: 10px;
            bottom: 20px;
            border-radius: 36px;
            background: linear-gradient(135deg, var(--tech-glow-1), transparent);
            transform: rotate(12deg);
            z-index: 0;
        }

        .summit-frame--v2 {
            position: absolute;
            right: 0;
            top: 70px;
            width: min(100%, 435px);
            min-height: 540px;
            padding: 16px;
            border-radius: 40px;
            background: linear-gradient(135deg, var(--tech-primary), var(--tech-accent));
            box-shadow: 0 28px 80px rgba(15, 23, 42, .16);
            transform: rotate(-3deg);
            z-index: 2;
        }

        .summit-frame--v2::before {
            content: "";
            position: absolute;
            inset: -18px 38px auto auto;
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: color-mix(in srgb, var(--tech-accent) 24%, white);
            opacity: .8;
            z-index: -1;
        }

        .summit-screen--v2 {
            position: relative;
            overflow: hidden;
            min-height: 508px;
            border-radius: 30px;
            background:
                radial-gradient(circle at 18% 18%, color-mix(in srgb, var(--tech-accent) 18%, white), transparent 34%),
                linear-gradient(180deg, #ffffff, #f8fafc);
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transform: rotate(3deg);
        }

        .summit-screen--v2::before {
            content: "";
            position: absolute;
            inset: 14px;
            border-radius: 22px;
            border: 1px dashed rgba(37, 99, 235, .18);
            pointer-events: none;
            z-index: 1;
        }

        .summit-screen--v2 img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .14;
        }

        .summit-overlay--v2 {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.88)),
                radial-gradient(circle at 82% 18%, rgba(255,255,255,.4), transparent 24%);
            z-index: 1;
        }

        .summit-top--v2,
        .summit-middle--v2,
        .summit-bottom--v2 {
            position: relative;
            z-index: 2;
        }

        .summit-top--v2 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .summit-kicker {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .summit-middle--v2 {
            margin-top: 18px;
        }

        .summit-middle--v2 h2 {
            color: #0f172a;
            font-size: clamp(2.3rem, 5vw, 3.7rem);
            line-height: .95;
            letter-spacing: -.065em;
            font-weight: 950;
            max-width: 320px;
        }

        .summit-subtext {
            margin-top: 14px;
            color: #64748b;
            line-height: 1.8;
            max-width: 300px;
            font-size: .98rem;
        }

        .summit-bottom--v2 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .summit-bottom--v2 .summit-mini {
            border-radius: 18px;
            padding: 14px 12px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
            text-align: center;
        }

        .summit-bottom--v2 .summit-mini p:first-child {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .summit-bottom--v2 .summit-mini p:last-child {
            color: #0f172a;
            font-size: 13px;
            font-weight: 950;
            line-height: 1.5;
        }

        .hero-floating-card {
            position: absolute;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(15, 23, 42, .08);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .10);
            backdrop-filter: blur(18px);
            z-index: 3;
        }

        .hero-floating-card.top {
            left: 0;
            top: 8px;
            width: 210px;
            border-radius: 28px;
            padding: 18px 18px 16px;
        }

        .hero-floating-card.bottom {
            left: 20px;
            bottom: 22px;
            width: 240px;
            border-radius: 30px;
            padding: 18px;
        }

        .hero-floating-card small {
            display: block;
            color: #94a3b8;
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .hero-floating-card strong {
            display: block;
            color: #0f172a;
            font-size: 1.35rem;
            line-height: 1.1;
            font-weight: 950;
            margin-top: 8px;
        }

        .hero-floating-card span {
            display: block;
            margin-top: 8px;
            color: #475569;
            font-size: .95rem;
            line-height: 1.6;
        }

        .floating-metrics {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .floating-metric-box {
            border-radius: 18px;
            padding: 14px 12px;
            text-align: center;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            border: 1px solid rgba(15, 23, 42, .06);
        }

        .floating-metric-box b {
            display: block;
            color: #0f172a;
            font-size: 1.5rem;
            line-height: 1;
            font-weight: 950;
        }

        .floating-metric-box em {
            display: block;
            margin-top: 8px;
            font-style: normal;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .14em;
        }

        @media (max-width: 980px) {
            .hero-premium-grid--v2 {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .hero-copy--v2 {
                text-align: center;
                max-width: 100%;
            }

            .hero-copy--v2::after {
                left: 50%;
                transform: translateX(-50%) rotate(-10deg);
                top: 38px;
            }

            .hero-copy--v2 .hero-main-title,
            .hero-summary {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-badge-row--v2,
            .hero-action-row {
                justify-content: center;
            }

            .metric-strip--v2 {
                max-width: 100%;
            }

            .conference-visual--v2 {
                min-height: auto;
                display: grid;
                gap: 18px;
            }

            .summit-frame--v2 {
                position: relative;
                right: auto;
                top: auto;
                width: 100%;
                transform: none;
                min-height: auto;
                order: 2;
            }

            .summit-screen--v2 {
                transform: none;
                min-height: 500px;
            }

            .hero-floating-card {
                position: relative;
                left: auto !important;
                top: auto !important;
                bottom: auto !important;
                width: 100% !important;
                order: 1;
            }

            .hero-floating-card.bottom {
                order: 3;
            }
        }

        @media (max-width: 640px) {
            .hero-copy--v2 .hero-main-title {
                font-size: clamp(2.8rem, 14vw, 4.8rem);
                line-height: .98;
            }

            .metric-strip--v2 {
                grid-template-columns: 1fr;
            }

            .metric-strip--v2 .metric-card:nth-child(2),
            .metric-strip--v2 .metric-card:nth-child(4) {
                transform: none;
            }

            .summit-screen--v2 {
                min-height: 430px;
                padding: 22px;
            }

            .summit-middle--v2 h2 {
                max-width: 100%;
                font-size: clamp(2rem, 10vw, 3rem);
            }

            .summit-subtext {
                max-width: 100%;
            }

            .summit-bottom--v2 {
                grid-template-columns: 1fr;
            }

            .floating-metrics {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* =====================================================
        LUXURY TECH CONFERENCE ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .tech-reveal,
        .tech-section > p,
        .tech-section > h1,
        .tech-section > h2,
        .tech-section > h3,
        .tech-label,
        .tech-title,
        .tech-gradient-text,
        .hero-copy,
        .hero-badge,
        .metric-card,
        .conference-visual,
        .summit-frame,
        .summit-frame--v2,
        .summit-screen,
        .summit-screen--v2,
        .summit-chip,
        .summit-mini,
        .hero-floating-card,
        .feature-card,
        .feature-number,
        .speaker-card,
        .event-pass,
        .timeline-panel,
        .countdown-card,
        .detail-map-card,
        .map-card,
        .gallery-item,
        .tech-card,
        .tech-btn,
        .tech-nav {
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

        .tech-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar masuk halus */
        .tech-nav {
            animation: techNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-copy {
            animation: techHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .tech-label {
            animation: techFadeDown .85s ease .12s both;
        }

        #opening .tech-title {
            animation: techTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .tech-btn {
            animation: techFadeUp .85s ease .52s both;
        }

        #opening .metric-card {
            animation: techFadeUp .85s ease .62s both;
        }

        #opening .summit-frame--v2,
        #opening .summit-frame {
            animation:
                techSummitEnter 1.1s cubic-bezier(.2, .8, .2, 1) .32s both,
                techSummitFloat 5.2s ease-in-out 1.4s infinite;
        }

        #opening .hero-floating-card.top {
            animation:
                techFloatingCardIn .95s cubic-bezier(.2, .8, .2, 1) .55s both,
                techFloatingCardMove 4.6s ease-in-out 1.4s infinite;
        }

        #opening .hero-floating-card.bottom {
            animation:
                techFloatingCardIn .95s cubic-bezier(.2, .8, .2, 1) .72s both,
                techFloatingCardMove 4.9s ease-in-out 1.5s infinite;
        }

        /* Background premium bergerak */
        .tech-wrap {
            animation: techWrapGlow 8s ease-in-out infinite alternate;
        }

        .tech-wrap::before {
            animation: techGridMove 20s linear infinite;
        }

        .tech-wrap::after {
            animation: techOrbFloat 7s ease-in-out infinite alternate;
        }

        /* Shape di hero bergerak */
        .hero-copy--v2::after,
        .conference-visual--v2::before,
        .conference-visual--v2::after,
        .summit-frame--v2::before {
            animation: techDecorFloat 6.5s ease-in-out infinite;
        }

        /* Label garis glow */
        .tech-label::before {
            animation: techLineGlow 2.8s ease-in-out infinite alternate;
        }

        /* Dots monitor bergerak */
        .summit-dots span {
            animation: techDotPulse 1.8s ease-in-out infinite;
        }

        .summit-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        .summit-dots span:nth-child(3) {
            animation-delay: .36s;
        }

        /* Frame glow */
        .summit-frame--v2::after,
        .summit-frame::after {
            content: "";
            position: absolute;
            inset: -14px;
            border-radius: 54px;
            border: 1px solid color-mix(in srgb, var(--tech-accent) 34%, transparent);
            opacity: .7;
            pointer-events: none;
            animation: techFrameGlow 4.2s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .tech-btn,
        button.tech-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .tech-btn::after,
        button.tech-btn::after,
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
            animation: techButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .tech-card:hover,
            .metric-card:hover,
            .feature-card:hover,
            .speaker-card:hover,
            .event-pass:hover,
            .timeline-panel:hover,
            .countdown-card:hover,
            .detail-map-card:hover,
            .map-card:hover,
            .gallery-item:hover,
            .summit-frame:hover,
            .summit-frame--v2:hover,
            .hero-floating-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--tech-accent) 38%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(15, 23, 42, .16),
                    0 0 46px color-mix(in srgb, var(--tech-primary) 14%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.72) !important;
            }

            .summit-frame:hover img,
            .summit-frame--v2:hover img,
            .gallery-item:hover img,
            .speaker-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }

            .tech-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--tech-primary) 14%, transparent);
            }
        }

        .summit-screen img,
        .summit-screen--v2 img,
        .gallery-item img,
        .speaker-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Feature number pulse */
        .feature-number {
            animation: techIconPulse 3s ease-in-out infinite;
        }

        /* Speaker glow */
        .speaker-card::before {
            animation: techSpeakerGlow 4s ease-in-out infinite alternate;
        }

        /* Event pass glow */
        .event-pass::after {
            animation: techPassGlow 4s ease-in-out infinite alternate;
        }

        /* Countdown angka glow */
        .countdown-number {
            animation: techNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Gallery item tengah tetap hidup desktop */
        .gallery-item:nth-child(2) {
            animation: techGalleryMiddle 4.8s ease-in-out infinite;
        }

        /* Metric card yang turun tetap bergerak halus */
        .metric-strip--v2 .metric-card:nth-child(2),
        .metric-strip--v2 .metric-card:nth-child(4) {
            animation:
                techMetricOffsetIn .9s cubic-bezier(.2, .8, .2, 1) both,
                techMetricFloat 4.6s ease-in-out 1.2s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: techFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes techNavEnter {
            from {
                opacity: 0;
                transform: translateY(-18px) scale(.96);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes techHeroCopyIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes techFadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes techFadeUp {
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

        @keyframes techTitleIn {
            from {
                opacity: 0;
                transform: translateY(36px) scale(.94);
                filter: blur(12px);
                letter-spacing: .02em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes techSummitEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.92) rotate(2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(-3deg);
                filter: blur(0);
            }
        }

        @keyframes techSummitFloat {
            0%, 100% {
                transform: translateY(0) rotate(-3deg) scale(1);
            }
            50% {
                transform: translateY(-8px) rotate(-2deg) scale(1.012);
            }
        }

        @keyframes techFloatingCardIn {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.94);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes techFloatingCardMove {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes techWrapGlow {
            from {
                box-shadow:
                    0 34px 100px rgba(15, 23, 42, .10),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 40px 118px rgba(15, 23, 42, .13),
                    0 0 58px color-mix(in srgb, var(--tech-primary) 11%, transparent);
            }
        }

        @keyframes techGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 116px 116px, 116px 116px;
            }
        }

        @keyframes techOrbFloat {
            from {
                transform: translateY(0) scale(1);
                opacity: .68;
            }
            to {
                transform: translateY(18px) scale(1.06);
                opacity: .9;
            }
        }

        @keyframes techDecorFloat {
            0%, 100% {
                transform: translateY(0) rotate(-10deg) scale(1);
            }
            50% {
                transform: translateY(-10px) rotate(-6deg) scale(1.025);
            }
        }

        @keyframes techLineGlow {
            from {
                opacity: .55;
                transform: scaleX(.86);
            }
            to {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        @keyframes techDotPulse {
            0%, 100% {
                opacity: .32;
                transform: translateY(0);
            }
            50% {
                opacity: .88;
                transform: translateY(-2px);
            }
        }

        @keyframes techFrameGlow {
            from {
                opacity: .42;
                box-shadow: 0 0 0 color-mix(in srgb, var(--tech-accent) 0%, transparent);
            }
            to {
                opacity: .95;
                box-shadow: 0 0 38px color-mix(in srgb, var(--tech-accent) 22%, transparent);
            }
        }

        @keyframes techButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes techIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 24px color-mix(in srgb, var(--tech-primary) 16%, transparent);
            }
            50% {
                transform: translateY(-4px) scale(1.055);
                box-shadow:
                    0 18px 38px color-mix(in srgb, var(--tech-primary) 24%, transparent),
                    0 0 30px color-mix(in srgb, var(--tech-accent) 22%, transparent);
            }
        }

        @keyframes techSpeakerGlow {
            from {
                opacity: .08;
                transform: scale(1);
            }
            to {
                opacity: .18;
                transform: scale(1.08);
            }
        }

        @keyframes techPassGlow {
            from {
                opacity: .14;
                transform: scale(1);
            }
            to {
                opacity: .26;
                transform: scale(1.08);
            }
        }

        @keyframes techNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--tech-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--tech-accent) 42%, transparent),
                    0 0 34px color-mix(in srgb, var(--tech-primary) 18%, transparent);
            }
        }

        @keyframes techGalleryMiddle {
            0%, 100% {
                transform: translateY(30px);
            }
            50% {
                transform: translateY(20px);
            }
        }

        @keyframes techMetricOffsetIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(18px) scale(1);
                filter: blur(0);
            }
        }

        @keyframes techMetricFloat {
            0%, 100% {
                transform: translateY(18px);
            }
            50% {
                transform: translateY(10px);
            }
        }

        @keyframes techFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .tech-reveal,
            .tech-section > p,
            .tech-section > h1,
            .tech-section > h2,
            .tech-section > h3,
            .tech-label,
            .tech-title,
            .tech-gradient-text,
            .hero-copy,
            .hero-badge,
            .metric-card,
            .conference-visual,
            .summit-frame,
            .summit-frame--v2,
            .summit-screen,
            .summit-screen--v2,
            .summit-chip,
            .summit-mini,
            .hero-floating-card,
            .feature-card,
            .feature-number,
            .speaker-card,
            .event-pass,
            .timeline-panel,
            .countdown-card,
            .detail-map-card,
            .map-card,
            .gallery-item,
            .tech-card,
            .tech-btn,
            .tech-nav {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-item:nth-child(2),
            .metric-strip--v2 .metric-card:nth-child(2),
            .metric-strip--v2 .metric-card:nth-child(4) {
                animation: none;
                transform: none;
            }

            #opening .summit-frame--v2,
            #opening .summit-frame {
                animation:
                    techFadeUp .9s ease .3s both,
                    techFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .tech-reveal,
            .tech-section > p,
            .tech-section > h1,
            .tech-section > h2,
            .tech-section > h3,
            .tech-label,
            .tech-title,
            .tech-gradient-text,
            .hero-copy,
            .hero-badge,
            .metric-card,
            .conference-visual,
            .summit-frame,
            .summit-frame--v2,
            .summit-screen,
            .summit-screen--v2,
            .summit-chip,
            .summit-mini,
            .hero-floating-card,
            .feature-card,
            .feature-number,
            .speaker-card,
            .event-pass,
            .timeline-panel,
            .countdown-card,
            .detail-map-card,
            .map-card,
            .gallery-item,
            .tech-card,
            .tech-btn,
            .tech-nav,
            .tech-wrap,
            .tech-wrap::before,
            .tech-wrap::after,
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
    $themeColor = $invitation->theme_color ?? 'navy';

    $themes = [
        'maroon' => [
            'primary' => '#e11d48',
            'secondary' => '#7c3aed',
            'accent' => '#fb7185',
            'bg' => '#fff7f8',
            'glow1' => 'rgba(225, 29, 72, .14)',
            'glow2' => 'rgba(124, 58, 237, .12)',
            'glow3' => 'rgba(251, 113, 133, .10)',
        ],
        'emerald' => [
            'primary' => '#059669',
            'secondary' => '#0891b2',
            'accent' => '#14b8a6',
            'bg' => '#f0fdf4',
            'glow1' => 'rgba(16, 185, 129, .14)',
            'glow2' => 'rgba(8, 145, 178, .12)',
            'glow3' => 'rgba(20, 184, 166, .10)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#7c3aed',
            'accent' => '#38bdf8',
            'bg' => '#f8fafc',
            'glow1' => 'rgba(37, 99, 235, .14)',
            'glow2' => 'rgba(124, 58, 237, .12)',
            'glow3' => 'rgba(56, 189, 248, .10)',
        ],
        'rose' => [
            'primary' => '#db2777',
            'secondary' => '#9333ea',
            'accent' => '#f472b6',
            'bg' => '#fff7fb',
            'glow1' => 'rgba(219, 39, 119, .14)',
            'glow2' => 'rgba(147, 51, 234, .12)',
            'glow3' => 'rgba(244, 114, 182, .10)',
        ],
        'gold' => [
            'primary' => '#b45309',
            'secondary' => '#92400e',
            'accent' => '#f59e0b',
            'bg' => '#fffbeb',
            'glow1' => 'rgba(245, 158, 11, .14)',
            'glow2' => 'rgba(180, 83, 9, .12)',
            'glow3' => 'rgba(250, 204, 21, .10)',
        ],
        'slate' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'accent' => '#94a3b8',
            'bg' => '#f8fafc',
            'glow1' => 'rgba(100, 116, 139, .12)',
            'glow2' => 'rgba(51, 65, 85, .10)',
            'glow3' => 'rgba(203, 213, 225, .10)',
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

        $eventMode = strtolower($invitation->event_mode ?: 'offline');
        $isOnlineEvent = $eventMode === 'online';
        $onlineUrl = trim((string) ($invitation->online_url ?? ''));
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

        if ($isOnlineEvent) {
            $shareMessage .= "Mode: Online\n";
            $shareMessage .= "Platform: " . ($locationText ?: 'Online Event') . "\n";

            if ($onlineUrl) {
                $shareMessage .= "Link Online: {$onlineUrl}\n";
            }
        } else {
            if ($locationText) {
                $shareMessage .= "Tempat: {$locationText}\n";
            }

            if ($invitation->address) {
                $shareMessage .= "Alamat: {$invitation->address}\n";
            }
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
                $endDateTime = $startDateTime->copy()->addHours(6);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(6);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Tech Conference') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan tech conference') . "\n\nLink Undangan: " . $shareUrl);

            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online Conference'))
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

        $mapOpenUrl = $isOnlineEvent ? null : ($mapData['open_url'] ?? $invitation->maps_url);
        $mapEmbedUrl = $isOnlineEvent ? null : ($mapData['embed_url'] ?? null);

        $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
        $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Event' : 'Venue belum diatur');
        $accessDescription = $invitation->address ?: ($isOnlineEvent
            ? 'Gunakan tombol Join Online untuk masuk ke ruang webinar/conference.'
            : 'Alamat lengkap belum ditambahkan.');
        $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
        $accessActionText = $isOnlineEvent ? 'Join Online' : 'Open Maps';
        $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';
        $accessReadyTitle = $isOnlineEvent ? 'Online Access Ready' : 'Venue Access Ready';
        $accessReadyDescription = $isOnlineEvent
            ? ($onlineUrl ? 'Link conference tersedia dan bisa dibuka melalui tombol Join Online.' : 'Link conference belum ditambahkan. Tampilkan informasi platform terlebih dahulu.')
            : ($mapOpenUrl ? 'Lokasi acara tersedia dan bisa dibuka melalui Google Maps.' : 'Link Google Maps belum ditambahkan. Alamat tetap ditampilkan sebagai informasi utama.');

    $techHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();
@endphp

<body
    style="
        --tech-primary: {{ $activeTheme['primary'] }};
        --tech-secondary: {{ $activeTheme['secondary'] }};
        --tech-accent: {{ $activeTheme['accent'] }};
        --tech-bg: {{ $activeTheme['bg'] }};
        --tech-glow-1: {{ $activeTheme['glow1'] }};
        --tech-glow-2: {{ $activeTheme['glow2'] }};
        --tech-glow-3: {{ $activeTheme['glow3'] }};
    "
>
    <main class="tech-shell">
        <div class="tech-wrap">

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
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background3.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="tech-nav">
                <a href="#opening">Home</a>
                <a href="#overview">Overview</a>
                <a href="#speakers">Speakers</a>
                <a href="#access">Access</a>
                <a href="#message">RSVP</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="tech-section">
                <div class="hero-premium-grid hero-premium-grid--v2">
                    <div class="hero-copy hero-copy--v2">
                        <div class="tech-label">
                            Premium Tech Conference
                        </div>

                        <h1 class="responsive-text tech-title tech-gradient-text hero-main-title">
                            {{ $invitation->title ?: 'Future Tech Conference 2026' }}
                        </h1>

                        <p class="responsive-text hero-summary">
                            {{ $invitation->description ?: 'Konferensi teknologi modern untuk membahas AI, software engineering, startup, product development, dan transformasi digital.' }}
                        </p>

                        <div class="hero-badge-row hero-badge-row--v2">
                            <span class="hero-badge">
                                {{ $invitation->event_name ?: 'Tech Conference' }}
                            </span>

                            <span class="hero-badge">
                                {{ $isOnlineEvent ? 'Online Access' : 'On-Site Venue' }}
                            </span>

                            <span class="hero-badge">
                                {{ $invitation->host_name ?: 'Digital Tech Community' }}
                            </span>
                        </div>

                        <div class="hero-action-row">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="tech-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#access" class="tech-btn">
                                    Detail Access
                                </a>
                            @endif

                            <a href="#overview" class="tech-btn secondary">
                                Explore Conference
                            </a>
                        </div>

                        <div class="metric-strip metric-strip--v2">
                            <div class="metric-card">
                                <div class="value">{{ max($invitation->people->count(), 1) }}</div>
                                <div class="text">Speakers</div>
                            </div>

                            <div class="metric-card">
                                <div class="value">{{ $techHighlights->count() ?: 0 }}</div>
                                <div class="text">Topics</div>
                            </div>

                            <div class="metric-card">
                                <div class="value">{{ $isOnlineEvent ? 'ON' : 'OFF' }}</div>
                                <div class="text">Mode</div>
                            </div>

                            <div class="metric-card">
                                <div class="value">
                                    @if ($invitation->event_date)
                                        {{ $invitation->event_date->format('d') }}
                                    @else
                                        --
                                    @endif
                                </div>
                                <div class="text">Date</div>
                            </div>
                        </div>
                    </div>

                    <div class="conference-visual conference-visual--v2">
                        <div class="summit-frame summit-frame--v2">
                            <div class="summit-screen summit-screen--v2">
                                @if ($invitation->cover_image)
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Tech Conference">
                                @elseif ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Tech Conference">
                                @endif

                                <div class="summit-overlay summit-overlay--v2"></div>

                                <div class="summit-top summit-top--v2">
                                    <div>
                                        <div class="summit-dots">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="summit-chip">
                                        {{ $isOnlineEvent ? 'Online' : 'Offline' }}
                                    </div>
                                </div>

                                <div class="summit-middle summit-middle--v2">
                                    <p class="summit-kicker">Next Gen Experience</p>

                                    <h2 class="responsive-text">
                                        {{ $invitation->title ?: 'Future Tech Conference 2026' }}
                                    </h2>

                                    <p class="responsive-text summit-subtext">
                                        {{ $invitation->host_name
                                            ? 'Diselenggarakan oleh ' . $invitation->host_name
                                            : 'Ruang bertemu para developer, founder, creator, dan profesional digital dalam satu conference experience yang modern.' }}
                                    </p>
                                </div>

                                <div class="summit-bottom summit-bottom--v2">
                                    <div class="summit-mini">
                                        <p class="mb-6">Tanggal</p>
                                        <p class="tech-date-line">
                                            @if ($invitation->event_date)
                                                <span>{{ $invitation->event_date->translatedFormat('d M') }}</span>
                                                @if ($invitation->event_end_date)
                                                    <span>- {{ $invitation->event_end_date->translatedFormat('d M') }}</span>
                                                @endif
                                            @else
                                                <span>--</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="summit-mini">
                                        <p class="mb-6">Waktu</p>
                                        <p class="tech-time-line">
                                            @if ($invitation->event_time)
                                                <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>
                                                @if ($invitation->event_end_time)
                                                    <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                                @endif
                                            @else
                                                <span>--:--</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="summit-mini">
                                        <p>Venue</p>
                                        <p class="responsive-text">
                                            {{ $invitation->location_name ?: ($isOnlineEvent ? 'Online Venue' : 'Main Venue') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- OVERVIEW --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $techHighlights->count())
                <section id="overview" class="tech-section compact">
                    <div class="text-center">
                        <p class="tech-label justify-center">
                            Conference Overview
                        </p>

                        <h2 class="responsive-text tech-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Conference untuk Developer, Founder, Creator, dan Tech Enthusiast' }}
                        </h2>

                        <p class="responsive-text text-slate-600 mt-6 max-w-3xl mx-auto leading-8 text-lg">
                            {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Acara ini dirancang untuk menghadirkan wawasan teknologi, networking profesional, dan sesi diskusi yang relevan dengan dunia digital.' }}
                        </p>
                    </div>

                    @if ($techHighlights->count())
                        <div class="feature-grid">
                            @foreach ($techHighlights as $index => $highlight)
                                <div class="feature-card">
                                    <div class="feature-number">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    @if (!empty($highlight['title']))
                                        <h3 class="responsive-text text-xl font-black">
                                            {{ $highlight['title'] }}
                                        </h3>
                                    @endif

                                    @if (!empty($highlight['description']))
                                        <p class="responsive-text mt-3 leading-7">
                                            {{ $highlight['description'] }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- SPEAKERS --}}
            <section id="speakers" class="tech-section compact text-center">
                <p class="tech-label justify-center">
                    Featured Speakers
                </p>

                <h2 class="tech-title text-5xl md:text-6xl mt-6">
                    Speakers & Mentors
                </h2>

                <p class="text-slate-500 mt-4 max-w-2xl mx-auto leading-7">
                    Tampilkan pembicara, mentor, panelis, moderator, atau host utama acara.
                </p>

                <div class="speaker-showcase {{ $invitation->people->count() <= 1 ? 'single-speaker' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="speaker-card">
                            <div>
                                @if ($person->photo)
                                    <img src="{{ asset('storage/' . $person->photo) }}"
                                         class="speaker-photo"
                                         alt="{{ $person->name }}">
                                @else
                                    <div class="speaker-placeholder">
                                        {{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'T', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400">
                                    Speaker
                                </p>

                                <h3 class="responsive-text text-2xl font-black mt-1">
                                    {{ $person->name ?: 'Nama Pembicara' }}
                                </h3>

                                @if ($person->subtitle)
                                    <p class="responsive-text">
                                        {{ $person->subtitle }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="speaker-card">
                            <div>
                                <div class="speaker-placeholder">T</div>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400">
                                    Speaker
                                </p>

                                <h3 class="text-2xl font-black mt-3">
                                    Tech Speaker
                                </h3>

                                <p class="text-slate-500 mt-3">
                                    Data pembicara belum ditambahkan.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ACCESS --}}
            <section id="access" class="tech-section compact">
                <div class="text-center">
                    <p class="tech-label justify-center">
                        Schedule & Access
                    </p>

                    <h2 class="tech-title text-5xl md:text-6xl mt-6">
                        Detail Conference
                    </h2>

                    <p class="responsive-text text-slate-500 mt-5 max-w-2xl mx-auto leading-8">
                        Informasi waktu, mode acara, akses lokasi, dan countdown conference.
                    </p>
                </div>

                <div class="detail-pass-layout">
                    <div class="event-pass">
                        <div class="pass-content">
                            <p class="pass-label">
                                Conference Pass
                            </p>

                            <h3 class="pass-title responsive-text">
                                {{ $invitation->title ?: 'Tech Conference' }}
                            </h3>

                            <div class="pass-meta">
                                <div class="pass-meta-item">
                                    <div class="label mb-6">Tanggal</div>
                                    <div class="value tech-date-line">
                                        @if ($invitation->event_date)
                                            <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>

                                            @if ($invitation->event_end_date)
                                                <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                            @endif
                                        @else
                                            <span>Tanggal belum diatur</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="pass-meta-item">
                                    <div class="label mb-6">Waktu</div>
                                    <div class="value tech-time-line">
                                        @if ($invitation->event_time)
                                            <span>Mulai pukul {{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>

                                            @if ($invitation->event_end_time)
                                                <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                            @endif
                                        @else
                                            <span>Waktu acara belum diatur.</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="pass-meta-item">
                                    <div class="label">Mode</div>
                                    <div class="value responsive-text">
                                        {{ $isOnlineEvent ? 'Online Conference' : 'Offline / On-Site Conference' }}
                                    </div>
                                </div>

                                <div class="pass-meta-item">
                                    <div class="label">{{ $accessTypeLabel }}</div>
                                    <div class="value responsive-text">
                                        {{ $accessName }}
                                    </div>
                                </div>

                                @if ($invitation->address)
                                    <div class="pass-meta-item">
                                        <div class="label">
                                            {{ $isOnlineEvent ? 'Info' : 'Alamat' }}
                                        </div>
                                        <div class="value responsive-text">
                                            {{ $accessDescription }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="pass-actions">
                                @if ($googleCalendarUrl)
                                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="tech-btn">
                                        📅 Add Calendar
                                    </a>
                                @endif

                                @if ($accessActionUrl)
                                    <a href="{{ $accessActionUrl }}" target="_blank" class="tech-btn secondary">
                                        {{ $accessActionIcon }} {{ $accessActionText }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <div>
                                <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                    @if ($countdownTarget)
                                        Countdown menuju conference
                                    @else
                                        Tanggal acara belum diatur
                                    @endif
                                </p>

                                <h3>
                                    Time Remaining
                                </h3>

                                <p>
                                    Hitung mundur menuju waktu utama conference.
                                </p>
                            </div>
                        </div>

                        <div class="modern-countdown" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
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

                        <div class="mt-8 rounded-3xl p-6 bg-slate-50 border border-slate-100">
                            <p class="text-sm uppercase tracking-[.2em] font-black text-slate-400">
                                Access Summary
                            </p>

                            <h4 class="responsive-text text-2xl font-black text-slate-950 mt-3">
                                {{ $isOnlineEvent ? 'Online Access Ready' : 'Venue Access Ready' }}
                            </h4>

                            <p class="responsive-text text-slate-600 mt-3 leading-7">
                                @if ($isOnlineEvent)
                                    {{ $onlineUrl ? 'Link conference tersedia dan bisa dibuka melalui tombol Join Conference.' : 'Link conference belum ditambahkan.' }}
                                @else
                                    {{ $mapOpenUrl ? 'Lokasi acara tersedia dan bisa dibuka melalui Google Maps.' : 'Link Google Maps belum ditambahkan.' }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                    <div class="detail-map-card">
                        @if ($isOnlineEvent)
                            @if ($onlineUrl)
                                <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">🌐</p>
                                        <p class="responsive-text font-black mt-3 text-slate-950">
                                            {{ $accessName }}
                                        </p>
                                        <p class="responsive-text text-slate-600 mt-2">
                                            {{ $accessDescription }}
                                        </p>
                                        <p class="responsive-text text-sky-600 mt-4 font-bold">
                                            Join Online →
                                        </p>
                                    </div>
                                </a>
                            @else
                                <div class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">🌐</p>
                                        <p class="responsive-text font-black mt-3 text-slate-950">
                                            {{ $accessName }}
                                        </p>
                                        <p class="responsive-text text-slate-600 mt-2">
                                            {{ $accessDescription }}
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
                                        <p class="responsive-text font-black mt-3 text-slate-950">
                                            {{ $accessName }}
                                        </p>
                                        <p class="responsive-text text-slate-600 mt-2">
                                            {{ $accessDescription }}
                                        </p>
                                    </div>
                                </a>
                            @else
                                <div class="map-placeholder">
                                    <div>
                                        <p class="text-5xl">📍</p>
                                        <p class="responsive-text font-black mt-3 text-slate-950">
                                            {{ $accessName }}
                                        </p>
                                        <p class="responsive-text text-slate-600 mt-2">
                                            {{ $accessDescription }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </section>

            {{-- GALLERY --}}
            @if ($invitation->photos->count())
                <section id="gallery" class="tech-section compact text-center">
                    <p class="tech-label justify-center">
                        Conference Media
                    </p>

                    <h2 class="tech-title text-5xl md:text-6xl mt-6">
                        Galeri Event
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Tech Conference">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="tech-section compact">
                <div class="text-center">
                    <p class="tech-label justify-center">
                        Register & RSVP
                    </p>

                    <h2 class="tech-title text-5xl md:text-6xl mt-6">
                        Konfirmasi Kehadiran
                    </h2>

                    <p class="text-slate-500 mt-3">
                        Isi data kehadiran dan pesan untuk panitia.
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
                          class="tech-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Peserta</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama lengkap"
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
                            <label class="uk-label">Jumlah Peserta</label>
                            <input type="number"
                                   name="guest_count"
                                   value="{{ old('guest_count', 1) }}"
                                   min="1"
                                   max="10"
                                   class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Pesan / Pertanyaan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis pesan atau pertanyaan untuk panitia..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full tech-btn">
                            Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="grid grid-cols-3 gap-4 mt-8 text-center">
                        <div class="tech-card">
                            <p class="text-3xl font-black text-slate-950">
                                {{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Tidak hadir</p>
                        </div>

                        <div class="tech-card">
                            <p class="text-3xl font-black text-slate-950">
                                {{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Hadir</p>
                        </div>

                        <div class="tech-card">
                            <p class="text-3xl font-black text-slate-950">
                                {{ $invitation->messages->where('attendance_status', 'ragu')->count() }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Ragu</p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @forelse ($invitation->messages as $message)
                            <div class="tech-card guest-message-card">
                                <div class="guest-message-header">
                                    <div class="guest-message-info">
                                        <p class="responsive-text font-black text-slate-950">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="shrink-0 text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text guest-message-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="tech-card text-center">
                                <p class="text-slate-500">
                                    Belum ada konfirmasi.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="tech-section text-center">
                <p class="tech-label justify-center">
                    End Of Program
                </p>

                <h2 class="responsive-text tech-title tech-gradient-text text-5xl md:text-7xl mt-8">
                    See You
                </h2>

                <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                    Terima kasih atas perhatian dan partisipasi Anda.
                    Sampai jumpa di conference.
                </p>

                <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
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
                            ? 'Countdown menuju conference'
                            : 'Conference sedang berlangsung atau telah dimulai';
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
                .tech-section > p,
                .tech-section > h1,
                .tech-section > h2,
                .tech-section > h3,
                .tech-label,
                .tech-title,
                .tech-gradient-text,
                .hero-copy,
                .hero-badge,
                .metric-card,
                .conference-visual,
                .summit-frame,
                .summit-frame--v2,
                .summit-screen,
                .summit-screen--v2,
                .summit-chip,
                .summit-mini,
                .hero-floating-card,
                .feature-card,
                .feature-number,
                .speaker-card,
                .event-pass,
                .timeline-panel,
                .countdown-card,
                .detail-map-card,
                .map-card,
                .gallery-item,
                .tech-card,
                .tech-btn,
                .tech-nav
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('tech-show');
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
