<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Doa Bersama') . ' ' . ($invitation->title ?: 'Syukuran Doa Bersama'));
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
            color: var(--doa-dark);
            background:
                radial-gradient(circle at top left, var(--doa-glow-1), transparent 30%),
                radial-gradient(circle at top right, var(--doa-glow-2), transparent 26%),
                linear-gradient(180deg, #ffffff 0%, var(--doa-soft) 44%, #ffffff 100%);
        }

        .doa-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .doa-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 44px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(255,255,255,.98)),
                radial-gradient(circle at 16% 16%, var(--doa-glow-1), transparent 26%),
                radial-gradient(circle at 84% 14%, var(--doa-glow-2), transparent 24%);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 36px 95px rgba(40, 40, 60, .10);
        }

        .doa-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .35;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--doa-primary) 7%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--doa-primary) 7%, transparent) 1px, transparent 1px);
            background-size: 34px 34px;
        }

        .doa-wrap > * {
            position: relative;
            z-index: 1;
        }

        .doa-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .doa-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
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

        .doa-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: .22em;
            color: var(--doa-primary);
        }

        .doa-label::before {
            content: "";
            width: 40px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
        }

        .doa-title {
            color: var(--doa-dark);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .doa-gradient-text {
            background: linear-gradient(135deg, var(--doa-dark), var(--doa-primary), var(--doa-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .doa-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--doa-primary) 20%, transparent);
        }

        .doa-btn.secondary {
            color: var(--doa-dark);
            background: white;
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 16px 30px rgba(30, 30, 50, .07);
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
            background: rgba(255,255,255,.96);
            box-shadow: 0 14px 30px rgba(20, 20, 40, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--doa-accent) 34%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .doa-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 28px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.86);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 16px 36px rgba(20, 20, 40, .08);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .doa-nav a {
            text-decoration: none;
            color: var(--doa-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .doa-nav a:hover {
            color: var(--doa-primary);
            background: color-mix(in srgb, var(--doa-primary) 10%, white);
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 42px;
            align-items: center;
        }

        .hero-copy {
            max-width: 650px;
        }

        .hero-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .hero-badge {
            padding: 10px 14px;
            border-radius: 999px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 12px 24px rgba(20, 20, 40, .06);
            color: var(--doa-text);
            font-size: 12px;
            font-weight: 900;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
        }

        .hero-stat {
            padding: 22px;
            text-align: center;
            border-radius: 28px;
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 14px 26px rgba(20, 20, 40, .06);
        }

        .hero-stat strong {
            display: block;
            color: var(--doa-dark);
            font-size: 33px;
            line-height: 1;
            font-weight: 950;
        }

        .hero-stat span {
            display: block;
            margin-top: 9px;
            color: var(--doa-text);
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .hero-stage {
            position: relative;
            min-height: 630px;
        }

        .hero-orb {
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(.4px);
        }

        .hero-orb.one {
            width: 160px;
            height: 160px;
            top: -16px;
            right: 10px;
            background: radial-gradient(circle, color-mix(in srgb, var(--doa-accent) 62%, white), color-mix(in srgb, var(--doa-accent) 18%, transparent), transparent 70%);
        }

        .hero-orb.two {
            width: 190px;
            height: 190px;
            left: -26px;
            bottom: 10px;
            background: radial-gradient(circle, color-mix(in srgb, var(--doa-primary) 38%, white), color-mix(in srgb, var(--doa-primary) 14%, transparent), transparent 72%);
        }

        .hero-main-card {
            position: absolute;
            inset: 48px 0 0 32px;
            padding: 18px;
            border-radius: 40px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--doa-primary) 18%, white), color-mix(in srgb, var(--doa-accent) 24%, white));
            box-shadow: 0 30px 80px rgba(20, 20, 40, .12);
        }

        .hero-main-inner {
            position: relative;
            overflow: hidden;
            min-height: 560px;
            border-radius: 30px;
            background:
                radial-gradient(circle at 20% 18%, color-mix(in srgb, var(--doa-accent) 24%, transparent), transparent 32%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--doa-soft) 88%, white));
            border: 2px dashed color-mix(in srgb, var(--doa-primary) 16%, transparent);
        }

        .hero-main-inner img.cover-main-image {
            width: 100%;
            height: 100%;
            min-height: 560px;
            object-fit: cover;
            display: block;
        }

        .hero-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }

        .hero-placeholder h2 {
            font-size: clamp(2.4rem, 4.8vw, 4.9rem);
            line-height: .94;
            letter-spacing: -.06em;
            font-weight: 950;
            color: var(--doa-dark);
        }

        .hero-placeholder p {
            color: var(--doa-text);
            margin-top: 16px;
            line-height: 1.8;
        }

        .hero-side-note {
            position: absolute;
            left: 0;
            top: 0;
            width: 220px;
            padding: 22px;
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 16px 34px rgba(20, 20, 40, .08);
        }

        .hero-side-note small {
            display: block;
            color: var(--doa-text);
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .hero-side-note strong {
            display: block;
            margin-top: 8px;
            color: var(--doa-dark);
            font-size: 1.1rem;
            line-height: 1.5;
            font-weight: 900;
        }

        .hero-bottom-note {
            position: absolute;
            right: 14px;
            bottom: 0;
            width: 260px;
            padding: 20px;
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 16px 34px rgba(20, 20, 40, .08);
        }

        .hero-bottom-note p {
            color: var(--doa-text);
            line-height: 1.7;
            font-size: 14px;
            margin: 0;
        }

        .section-head {
            text-align: center;
        }

        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--doa-text);
            line-height: 1.8;
        }

        .blessing-grid {
            display: grid;
            gap: 20px;
            margin-top: 38px;
            justify-content: center;
        }

        .blessing-grid.count-1 {
            grid-template-columns: minmax(280px, 460px);
        }

        .blessing-grid.count-2 {
            grid-template-columns: repeat(2, minmax(280px, 460px));
        }

        .blessing-grid.count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .blessing-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            border-radius: 34px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(20, 20, 40, .07);
        }

        .blessing-card::after {
            content: "";
            position: absolute;
            width: 138px;
            height: 138px;
            right: -44px;
            top: -44px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--doa-accent) 24%, transparent);
        }

        .blessing-index {
            position: relative;
            z-index: 2;
            width: 48px;
            height: 48px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
            margin-bottom: 18px;
        }

        .blessing-card h3,
        .blessing-card p {
            position: relative;
            z-index: 2;
        }

        .blessing-card h3 {
            color: var(--doa-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .blessing-card p {
            margin-top: 10px;
            color: var(--doa-text);
            line-height: 1.8;
        }

        .focus-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .doa-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            border-radius: 36px;
            box-shadow: 0 18px 44px rgba(20, 20, 40, .07);
            padding: 30px;
        }

        .doa-card h3 {
            color: var(--doa-dark);
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
            grid-template-columns: 110px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--doa-primary) 18%, transparent);
        }

        .detail-row .label {
            color: var(--doa-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--doa-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .doa-date-line,
        .doa-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .doa-date-line span,
        .doa-time-line span {
            display: inline;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .countdown-card {
            border-radius: 26px;
            padding: 22px 14px;
            text-align: center;
            background: linear-gradient(180deg, color-mix(in srgb, var(--doa-soft) 88%, white), white);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--doa-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--doa-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 24px;
            border-radius: 34px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 18px 44px rgba(20, 20, 40, .07);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 320px;
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
            color: var(--doa-dark);
            background:
                radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--doa-accent) 22%, transparent), transparent 36%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--doa-soft) 90%, white));
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr 1.1fr;
            gap: 18px;
            margin-top: 38px;
            align-items: stretch;
        }

        .gallery-column {
            display: grid;
            gap: 18px;
        }

        .gallery-card {
            border-radius: 28px;
            overflow: hidden;
            padding: 10px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(20, 20, 40, .07);
        }

        .gallery-card.tall img {
            height: 340px;
        }

        .gallery-card.short img {
            height: 220px;
        }

        .gallery-card img {
            width: 100%;
            object-fit: cover;
            display: block;
            border-radius: 20px;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 460px);
            justify-content: center;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            padding: 26px;
            border-radius: 34px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(20, 20, 40, .07);
        }

        .gift-card h3 {
            color: var(--doa-dark);
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
            background: color-mix(in srgb, var(--doa-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--doa-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--doa-primary);
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
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .rsvp-wrap {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 16px 34px rgba(20, 20, 40, .07);
            border-radius: 30px;
        }

        .form-card {
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            text-align: center;
            padding: 20px;
        }

        .summary-card strong {
            display: block;
            color: var(--doa-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--doa-text);
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
            background: color-mix(in srgb, var(--doa-primary) 12%, white);
            color: var(--doa-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 840px;
            margin: 0 auto;
            border-radius: 40px;
            padding: 46px 34px;
            text-align: center;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--doa-primary) 12%, white), color-mix(in srgb, var(--doa-accent) 22%, white));
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 20px 44px rgba(20, 20, 40, .07);
        }

        @media (max-width: 980px) {
            .doa-shell {
                padding: 16px;
            }

            .doa-section {
                padding: 82px 38px;
            }

            .hero-layout,
            .focus-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .hero-stage {
                min-height: 720px;
            }

            .hero-side-note {
                left: 0;
                top: 0;
            }

            .hero-bottom-note {
                right: 12px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-column {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .blessing-grid.count-3 {
                grid-template-columns: repeat(2, minmax(280px, 460px));
            }

            .hero-stats,
            .countdown-grid,
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .doa-shell {
                padding: 0;
            }

            .doa-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .doa-section {
                padding: 72px 22px;
            }

            .doa-section.compact {
                padding-top: 64px;
                padding-bottom: 64px;
            }

            .hero-copy {
                text-align: center;
            }

            .hero-copy .flex,
            .hero-badges {
                justify-content: center;
            }

            .hero-stage {
                min-height: auto;
            }

            .hero-main-card {
                position: relative;
                inset: 0;
            }

            .hero-main-inner,
            .hero-main-inner img.cover-main-image {
                min-height: 450px;
            }

            .hero-side-note,
            .hero-bottom-note {
                position: relative;
                width: auto;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                margin-top: 16px;
            }

            .hero-stats,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .blessing-grid,
            .blessing-grid.count-1,
            .blessing-grid.count-2,
            .blessing-grid.count-3,
            .gallery-column {
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

            .floating-actions {
                right: 10px;
            }
        }
        /* ===============================
        NEW HERO - SYUKURAN DOA BERSAMA
        Desain lebih beda, editorial, premium
        ================================ */

        .doa-hero-new {
            min-height: 100vh;
            padding: 86px 64px 96px;
            display: grid;
            grid-template-columns: 0.78fr 1.12fr 0.9fr;
            gap: 28px;
            align-items: center;
        }

        .doa-hero-panel {
            position: relative;
            min-height: 520px;
            border-radius: 38px;
            padding: 30px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(255,255,255,.78)),
                radial-gradient(circle at top left, color-mix(in srgb, var(--doa-accent) 26%, transparent), transparent 38%);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 22px 54px rgba(20, 20, 40, .08);
            overflow: hidden;
        }

        .doa-hero-panel::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -70px;
            bottom: -70px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--doa-primary) 13%, transparent);
        }

        .doa-date-box {
            position: relative;
            z-index: 2;
            width: 138px;
            height: 138px;
            border-radius: 34px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
            color: white;
            box-shadow: 0 18px 38px color-mix(in srgb, var(--doa-primary) 25%, transparent);
        }

        .doa-date-box strong {
            font-size: 46px;
            line-height: 1;
            font-weight: 950;
        }

        .doa-date-box span {
            margin-top: 8px;
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .doa-hero-panel-title {
            position: relative;
            z-index: 2;
            margin-top: 44px;
            color: var(--doa-dark);
            font-size: 1.85rem;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .doa-hero-panel-text {
            position: relative;
            z-index: 2;
            margin-top: 18px;
            color: var(--doa-text);
            line-height: 1.8;
        }

        .doa-mini-info {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 12px;
            margin-top: 30px;
        }

        .doa-mini-info-item {
            padding: 15px 16px;
            border-radius: 22px;
            background: rgba(255,255,255,.74);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 11%, transparent);
        }

        .doa-mini-info-item small {
            display: block;
            color: var(--doa-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .doa-mini-info-item p {
            margin-top: 5px;
            color: var(--doa-dark);
            font-weight: 900;
            line-height: 1.5;
        }

        .doa-hero-center {
            text-align: center;
            position: relative;
            padding: 24px 0;
        }

        .doa-hero-center::before {
            content: "";
            position: absolute;
            inset: 50% auto auto 50%;
            width: 360px;
            height: 360px;
            transform: translate(-50%, -50%);
            border-radius: 999px;
            background:
                radial-gradient(circle, color-mix(in srgb, var(--doa-accent) 22%, transparent), transparent 68%);
            z-index: -1;
        }

        .doa-hero-kicker {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--doa-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .doa-hero-kicker::before,
        .doa-hero-kicker::after {
            content: "";
            width: 42px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--doa-primary), var(--doa-accent));
        }

        .doa-hero-title {
            margin-top: 24px;
            color: var(--doa-dark);
            font-size: clamp(2.8rem, 6vw, 5.8rem);
            line-height: .92;
            letter-spacing: -.06em;
            font-weight: 950;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }

        .doa-hero-desc {
            max-width: 620px;
            margin: 28px auto 0;
            color: var(--doa-text);
            line-height: 1.85;
            font-size: 1.05rem;
        }

        .doa-hero-actions {
            margin-top: 34px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .doa-visual-frame {
            position: relative;
            min-height: 590px;
            border-radius: 999px 999px 42px 42px;
            padding: 16px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--doa-primary) 18%, white), color-mix(in srgb, var(--doa-accent) 28%, white));
            box-shadow: 0 30px 75px rgba(20, 20, 40, .11);
        }

        .doa-visual-inner {
            position: relative;
            overflow: hidden;
            min-height: 558px;
            border-radius: 999px 999px 30px 30px;
            background:
                radial-gradient(circle at 50% 16%, color-mix(in srgb, var(--doa-accent) 28%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--doa-soft) 88%, white));
            border: 2px dashed color-mix(in srgb, var(--doa-primary) 18%, transparent);
        }

        .doa-visual-inner img {
            width: 100%;
            height: 100%;
            min-height: 558px;
            object-fit: cover;
            display: block;
        }

        .doa-visual-placeholder {
            min-height: 558px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 38px;
            text-align: center;
        }

        .doa-visual-placeholder-inner {
            width: 100%;
        }

        .doa-visual-symbol {
            width: 104px;
            height: 104px;
            margin: 0 auto 24px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 44px;
            font-weight: 950;
            background: linear-gradient(135deg, var(--doa-primary), var(--doa-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--doa-primary) 24%, transparent);
        }

        .doa-visual-placeholder h2 {
            color: var(--doa-dark);
            font-size: clamp(2rem, 4vw, 3.6rem);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .doa-visual-placeholder p {
            margin-top: 18px;
            color: var(--doa-text);
            line-height: 1.75;
        }

        .doa-floating-location {
            position: absolute;
            left: -28px;
            bottom: -75px;
            width: 230px;
            padding: 18px;
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 14%, transparent);
            box-shadow: 0 18px 36px rgba(20, 20, 40, .10);
            z-index: 4;
        }

        .doa-floating-location small {
            display: block;
            color: var(--doa-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .doa-floating-location p {
            margin-top: 7px;
            color: var(--doa-dark);
            font-weight: 900;
            line-height: 1.5;
        }

        .doa-floating-note {
            position: absolute;
            right: -20px;
            top: 76px;
            width: 164px;
            height: 164px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 18px;
            color: var(--doa-dark);
            background: color-mix(in srgb, var(--doa-accent) 26%, white);
            border: 1px solid color-mix(in srgb, var(--doa-primary) 12%, transparent);
            box-shadow: 0 18px 38px rgba(20, 20, 40, .09);
            font-size: 13px;
            line-height: 1.55;
            font-weight: 900;
        }

        @media (max-width: 1100px) {
            .doa-hero-new {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .doa-hero-panel {
                min-height: auto;
            }

            .doa-visual-frame {
                min-height: 520px;
            }

            .doa-visual-inner,
            .doa-visual-inner img,
            .doa-visual-placeholder {
                min-height: 488px;
            }

            .doa-floating-location {
                left: 18px;
            }

            .doa-floating-note {
                right: 18px;
            }
        }

        @media (max-width: 640px) {
            .doa-hero-new {
                padding: 72px 22px;
            }

            .doa-hero-title {
                font-size: clamp(3.2rem, 18vw, 5.2rem);
            }

            .doa-hero-panel {
                padding: 24px;
                border-radius: 30px;
            }

            .doa-date-box {
                width: 116px;
                height: 116px;
                border-radius: 28px;
            }

            .doa-date-box strong {
                font-size: 38px;
            }

            .doa-visual-frame {
                min-height: auto;
                border-radius: 46px;
            }

            .doa-visual-inner,
            .doa-visual-inner img,
            .doa-visual-placeholder {
                min-height: 430px;
                border-radius: 34px;
            }

            .doa-floating-location,
            .doa-floating-note {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: auto;
                margin-top: 14px;
                border-radius: 26px;
            }
        }

        /* =====================================================
        LUXURY DOA ANIMATION - SYUKURAN DOA BERSAMA
        Tempel sebelum penutup style
        ===================================================== */

        .doa-reveal,
        .doa-section > p,
        .doa-section > h1,
        .doa-section > h2,
        .doa-section > h3,
        .doa-label,
        .doa-title,
        .doa-gradient-text,
        .doa-nav,
        .doa-hero-panel,
        .doa-date-box,
        .doa-hero-panel-title,
        .doa-mini-info-item,
        .doa-hero-center,
        .doa-hero-kicker,
        .doa-hero-title,
        .doa-hero-desc,
        .doa-hero-actions,
        .doa-visual-frame,
        .doa-visual-inner,
        .doa-visual-placeholder,
        .doa-visual-symbol,
        .doa-floating-note,
        .doa-floating-location,
        .blessing-card,
        .blessing-index,
        .doa-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .doa-btn {
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

        .doa-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar */
        .doa-nav {
            animation: doaNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil elegan */
        #opening .doa-hero-panel {
            animation: doaPanelEnter 1s cubic-bezier(.2, .8, .2, 1) .12s both;
        }

        #opening .doa-date-box {
            animation: doaDatePop .9s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .doa-hero-kicker {
            animation: doaFadeDown .85s ease .22s both;
        }

        #opening .doa-hero-title {
            animation: doaTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .36s both;
        }

        #opening .doa-hero-desc {
            animation: doaFadeUp .85s ease .52s both;
        }

        #opening .doa-hero-actions {
            animation: doaFadeUp .85s ease .66s both;
        }

        #opening .doa-visual-frame {
            animation:
                doaVisualEnter 1.12s cubic-bezier(.2, .8, .2, 1) .32s both,
                doaVisualFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .doa-floating-note {
            animation:
                doaFloatingIn .9s cubic-bezier(.2, .8, .2, 1) .72s both,
                doaFloatingNoteMove 4.8s ease-in-out 1.4s infinite;
        }

        #opening .doa-floating-location {
            animation:
                doaFloatingIn .9s cubic-bezier(.2, .8, .2, 1) .82s both,
                doaFloatingLocationMove 5.1s ease-in-out 1.6s infinite;
        }

        /* Background mewah bergerak */
        .doa-wrap {
            animation: doaWrapGlow 8s ease-in-out infinite alternate;
        }

        .doa-wrap::before {
            animation: doaGridMove 20s linear infinite;
        }

        /* Hero center glow */
        .doa-hero-center::before {
            animation: doaCenterGlow 6.5s ease-in-out infinite alternate;
        }

        /* Orb / dekorasi */
        .hero-orb.one,
        .hero-orb.two,
        .doa-hero-panel::after,
        .blessing-card::after {
            animation: doaDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label / kicker glow */
        .doa-label::before,
        .doa-hero-kicker::before,
        .doa-hero-kicker::after {
            animation: doaLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .doa-btn,
        button.doa-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .doa-btn::after,
        button.doa-btn::after,
        .copy-gift-btn::after,
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
                rgba(255,255,255,.58),
                transparent
            );
            animation: doaButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .doa-hero-panel:hover,
            .doa-visual-frame:hover,
            .doa-floating-note:hover,
            .doa-floating-location:hover,
            .blessing-card:hover,
            .doa-card:hover,
            .detail-row:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--doa-primary) 32%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--doa-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--doa-accent) 16%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .doa-visual-frame:hover img,
            .gallery-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .doa-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--doa-primary) 12%, transparent);
            }
        }

        .doa-visual-inner img,
        .gallery-card img {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: doaNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Badge / angka pulse */
        .doa-date-box,
        .blessing-index,
        .doa-visual-symbol,
        .gift-number,
        .message-badge {
            animation: doaSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery hidup */
        .gallery-card:nth-child(3n+1) {
            animation: doaGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: doaGalleryMiddle 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: doaGalleryRight 4.8s ease-in-out infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: doaFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes doaNavEnter {
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

        @keyframes doaPanelEnter {
            from {
                opacity: 0;
                transform: translateX(-28px) translateY(28px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes doaDatePop {
            from {
                opacity: 0;
                transform: translateY(-18px) scale(.78) rotate(-6deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes doaVisualEnter {
            from {
                opacity: 0;
                transform: translateX(28px) translateY(34px) scale(.93);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes doaVisualFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes doaFloatingIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.92);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes doaFloatingNoteMove {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.025);
            }
        }

        @keyframes doaFloatingLocationMove {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-7px) scale(1.018);
            }
        }

        @keyframes doaFadeDown {
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

        @keyframes doaFadeUp {
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

        @keyframes doaTitleIn {
            from {
                opacity: 0;
                transform: translateY(38px) scale(.94);
                filter: blur(12px);
                letter-spacing: -.02em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes doaWrapGlow {
            from {
                box-shadow:
                    0 36px 95px color-mix(in srgb, var(--doa-primary) 9%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 44px 122px color-mix(in srgb, var(--doa-primary) 13%, transparent),
                    0 0 58px color-mix(in srgb, var(--doa-accent) 16%, transparent);
            }
        }

        @keyframes doaGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 136px 136px, 136px 136px;
            }
        }

        @keyframes doaCenterGlow {
            from {
                opacity: .72;
                transform: translate(-50%, -50%) scale(.96);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1.06);
            }
        }

        @keyframes doaDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes doaLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--doa-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--doa-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes doaButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes doaNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--doa-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--doa-accent) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--doa-primary) 18%, transparent);
            }
        }

        @keyframes doaSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes doaGalleryLeft {
            0%, 100% {
                transform: translateY(0) rotate(-.4deg);
            }
            50% {
                transform: translateY(-7px) rotate(-.9deg);
            }
        }

        @keyframes doaGalleryMiddle {
            0%, 100% {
                transform: translateY(0) rotate(.4deg);
            }
            50% {
                transform: translateY(-6px) rotate(.9deg);
            }
        }

        @keyframes doaGalleryRight {
            0%, 100% {
                transform: translateY(0) rotate(.2deg);
            }
            50% {
                transform: translateY(-7px) rotate(.7deg);
            }
        }

        @keyframes doaFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .doa-reveal,
            .doa-section > p,
            .doa-section > h1,
            .doa-section > h2,
            .doa-section > h3,
            .doa-label,
            .doa-title,
            .doa-gradient-text,
            .doa-nav,
            .doa-hero-panel,
            .doa-date-box,
            .doa-hero-panel-title,
            .doa-mini-info-item,
            .doa-hero-center,
            .doa-hero-kicker,
            .doa-hero-title,
            .doa-hero-desc,
            .doa-hero-actions,
            .doa-visual-frame,
            .doa-visual-inner,
            .doa-visual-placeholder,
            .doa-visual-symbol,
            .doa-floating-note,
            .doa-floating-location,
            .blessing-card,
            .blessing-index,
            .doa-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .doa-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .doa-visual-frame {
                animation:
                    doaFadeUp .9s ease .3s both,
                    doaFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .doa-reveal,
            .doa-section > p,
            .doa-section > h1,
            .doa-section > h2,
            .doa-section > h3,
            .doa-label,
            .doa-title,
            .doa-gradient-text,
            .doa-nav,
            .doa-hero-panel,
            .doa-date-box,
            .doa-hero-panel-title,
            .doa-mini-info-item,
            .doa-hero-center,
            .doa-hero-kicker,
            .doa-hero-title,
            .doa-hero-desc,
            .doa-hero-actions,
            .doa-visual-frame,
            .doa-visual-inner,
            .doa-visual-placeholder,
            .doa-visual-symbol,
            .doa-floating-note,
            .doa-floating-location,
            .blessing-card,
            .blessing-index,
            .doa-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .doa-btn,
            .doa-wrap,
            .doa-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-number,
            .gift-number,
            .message-badge {
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
    $themeColor = $invitation->theme_color ?? 'emerald';

    $themes = [
        'maroon' => [
            'primary' => '#9f1239',
            'secondary' => '#e11d48',
            'accent' => '#fbbf24',
            'dark' => '#4a1623',
            'text' => '#6b3440',
            'soft' => '#fff1f2',
            'glow1' => 'rgba(244, 63, 94, .18)',
            'glow2' => 'rgba(251, 191, 36, .18)',
        ],
        'emerald' => [
            'primary' => '#2f855a',
            'secondary' => '#16a34a',
            'accent' => '#f6d365',
            'dark' => '#163d2c',
            'text' => '#517060',
            'soft' => '#f4fff6',
            'glow1' => 'rgba(34, 197, 94, .16)',
            'glow2' => 'rgba(246, 211, 101, .18)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#38bdf8',
            'accent' => '#facc15',
            'dark' => '#0f172a',
            'text' => '#475569',
            'soft' => '#eff6ff',
            'glow1' => 'rgba(37, 99, 235, .14)',
            'glow2' => 'rgba(250, 204, 21, .18)',
        ],
        'rose' => [
            'primary' => '#db2777',
            'secondary' => '#f472b6',
            'accent' => '#fde68a',
            'dark' => '#831843',
            'text' => '#70415b',
            'soft' => '#fff7fb',
            'glow1' => 'rgba(244, 114, 182, .18)',
            'glow2' => 'rgba(253, 230, 138, .20)',
        ],
        'gold' => [
            'primary' => '#b45309',
            'secondary' => '#d97706',
            'accent' => '#facc15',
            'dark' => '#4a2c0a',
            'text' => '#72512d',
            'soft' => '#fffbeb',
            'glow1' => 'rgba(245, 158, 11, .18)',
            'glow2' => 'rgba(250, 204, 21, .20)',
        ],
        'slate' => [
            'primary' => '#475569',
            'secondary' => '#64748b',
            'accent' => '#cbd5e1',
            'dark' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#f8fafc',
            'glow1' => 'rgba(100, 116, 139, .14)',
            'glow2' => 'rgba(203, 213, 225, .18)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];

    $firstPhoto = $invitation->photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Doa Bersama';
    $eventName = $invitation->event_name ?: 'Doa Bersama';
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
        "Halo Bapak/Ibu/Saudara/i,\n\n" .
        "Dengan penuh sukacita dan rasa syukur, kami mengundang Anda untuk hadir dalam acara:\n\n" .
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
        "\n\nTerima kasih atas perhatian, doa, dan kehadirannya.";

    $shareText = urlencode($shareMessage);

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

            $calendarTitle = trim(($invitation->event_name ?: 'Doa Bersama') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan doa bersama') . "\n\nLink Undangan: " . $shareUrl);
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

    $eventHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $eventHighlights->count();
    $giftCount = $invitation->gifts->count();
    $photos = $invitation->photos->values();
@endphp

<body
    style="
        --doa-primary: {{ $activeTheme['primary'] }};
        --doa-secondary: {{ $activeTheme['secondary'] }};
        --doa-accent: {{ $activeTheme['accent'] }};
        --doa-dark: {{ $activeTheme['dark'] }};
        --doa-text: {{ $activeTheme['text'] }};
        --doa-soft: {{ $activeTheme['soft'] }};
        --doa-glow-1: {{ $activeTheme['glow1'] }};
        --doa-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="doa-shell">
        <div class="doa-wrap">

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
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="doa-nav">
                <a href="#detail">Detail</a>
                @if ($photos->count())
                    <a href="#gallery">Galeri</a>
                @endif
                @if ($giftCount)
                    <a href="#gift">Amplop</a>
                @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="doa-hero-new">
                <aside class="doa-hero-panel">
                    <div class="doa-date-box">
                        @if ($invitation->event_date)
                            <strong>{{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('M') }}</span>
                        @else
                            <strong>--</strong>
                            <span>Tgl</span>
                        @endif
                    </div>

                    <h3 class="responsive-text doa-hero-panel-title">
                        {{ $invitation->event_name ?: 'Syukuran & Doa Bersama' }}
                    </h3>

                    <p class="responsive-text doa-hero-panel-text">
                        {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Momen kebersamaan untuk berkumpul, bersyukur, dan berbagi harapan baik.' }}
                    </p>

                    <div class="doa-mini-info">
                        <div class="doa-mini-info-item">
                            <small>Waktu</small>
                            <p>
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

                        <div class="doa-mini-info-item">
                            <small>Tempat</small>
                            <p class="responsive-text">
                                {{ $invitation->location_name ?: 'Lokasi belum diatur' }}
                            </p>
                        </div>
                    </div>
                </aside>

                <div class="doa-hero-center">
                    <div class="doa-hero-kicker">
                        Kebersamaan & Harapan
                    </div>

                    <h1 class="responsive-text doa-hero-title doa-gradient-text">
                        {{ $invitation->title ?: 'Syukuran & Doa Bersama' }}
                    </h1>

                    <p class="responsive-text doa-hero-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan kebersamaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara doa bersama ini.' }}
                    </p>

                    <div class="doa-hero-actions">
                        <a href="#detail" class="doa-btn">
                            Lihat Detail
                        </a>

                        <a href="#message" class="doa-btn secondary">
                            Kirim Ucapan
                        </a>
                    </div>
                </div>

                <div class="doa-visual-frame">
                    <div class="doa-visual-inner">
                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Doa Bersama">
                        @elseif ($firstPhoto)
                            <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Acara">
                        @else
                            <div class="doa-visual-placeholder">
                                <div class="doa-visual-placeholder-inner">
                                    <div class="doa-visual-symbol">
                                        ✦
                                    </div>

                                    <h2 class="responsive-text">
                                        Momen Penuh Syukur
                                    </h2>

                                    <p class="responsive-text">
                                        Acara ini menjadi ruang untuk berkumpul, menyampaikan harapan baik, dan mempererat kebersamaan.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="doa-floating-note">
                        Doa baik, harapan baik, dan kebersamaan.
                    </div>

                    <div class="doa-floating-location">
                        <small>Lokasi</small>
                        <p class="responsive-text">
                            {{ $invitation->location_name ?: 'Lokasi acara belum diatur' }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $highlightCount)
                <section id="about" class="doa-section compact">
                    <div class="section-head">
                        <p class="doa-label justify-center">
                            Tentang Acara
                        </p>

                        <h2 class="responsive-text doa-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Momen Syukur, Doa, dan Kebersamaan' }}
                        </h2>

                        <p class="responsive-text desc">
                            {{ $invitation->host_name ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen untuk berkumpul, bersyukur, dan berbagi harapan baik bersama.' : 'Acara ini menjadi momen untuk mempererat kebersamaan, berbagi rasa syukur, dan menyampaikan doa-doa baik bersama.' }}
                        </p>
                    </div>

                    @if ($highlightCount)
                        <div class="blessing-grid count-{{ min($highlightCount, 3) }}">
                            @foreach ($eventHighlights as $index => $highlight)
                                <div class="blessing-card">
                                    <div class="blessing-index">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

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
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="doa-section compact">
                <div class="section-head">
                    <p class="doa-label justify-center">
                        Detail Acara
                    </p>

                    <h2 class="doa-title text-5xl md:text-6xl mt-6">
                        Jadwal & Lokasi
                    </h2>

                    <p class="responsive-text desc">
                        Simpan jadwal acara dan lihat lokasi agar Anda dapat hadir tepat waktu.
                    </p>
                </div>

                <div class="focus-layout">
                    <div class="doa-card">
                        <h3>Informasi Utama</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label ml-2">Acara</div>
                                <div class="value responsive-text ml-2">
                                    {{ $invitation->event_name ?: 'Doa Bersama' }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value doa-date-line ml-2">
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
                                <div class="value doa-time-line ml-2">
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
                                <div class="label ml-2">Lokasi</div>
                                <div class="value responsive-text ml-2">
                                    {{ $invitation->location_name ?: 'Lokasi acara belum diatur' }}
                                </div>
                            </div>

                            @if ($invitation->address)
                                <div class="detail-row">
                                    <div class="label ml-2">Alamat</div>
                                    <div class="value responsive-text ml-2">
                                        {{ $invitation->address }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="doa-btn">
                                    📅 Atur Pengingat
                                </a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="doa-btn secondary">
                                    📍 Buka Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="doa-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Menuju Hari Acara</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Semoga acara ini menjadi momen yang penuh ketenangan, kebahagiaan, dan kebersamaan.
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
                        </div>

                        @if ($invitation->address || $mapOpenUrl)
                            <div class="map-card">
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
                                            <p class="responsive-text font-black mt-3 text-slate-900">
                                                {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                            </p>
                                            <p class="responsive-text text-slate-600 mt-2">
                                                {{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}
                                            </p>
                                        </div>
                                    </a>
                                @else
                                    <div class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">
                                                {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                            </p>
                                            <p class="responsive-text text-slate-600 mt-2">
                                                {{ $invitation->address }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="doa-section compact">
                    <div class="section-head">
                        <p class="doa-label justify-center">
                            Galeri
                        </p>

                        <h2 class="doa-title text-5xl md:text-6xl mt-6">
                            Momen Kebersamaan
                        </h2>
                    </div>

                    <div class="gallery-grid">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Acara">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'short' : 'tall' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Acara">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Acara">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($photos->count() > 6)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                            @foreach ($photos->slice(6) as $photo)
                                <div class="gallery-card short">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Acara">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="doa-section compact">
                    <div class="section-head">
                        <p class="doa-label justify-center">
                            Amplop Digital
                        </p>

                        <h2 class="doa-title text-5xl md:text-6xl mt-6">
                            Kirim Dukungan
                        </h2>

                        <p class="responsive-text desc">
                            Jika berkenan, Anda dapat mengirimkan amplop digital melalui informasi berikut.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            <div class="gift-card">
                                <h3 class="responsive-text">
                                    {{ $gift->label ?: 'Amplop Digital' }}
                                </h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>

                                        <div class="gift-number responsive-text">
                                            {{ $gift->account_number ?: '-' }}
                                        </div>
                                    </div>

                                    @if ($gift->account_number)
                                        <button
                                            type="button"
                                            class="copy-gift-btn"
                                            data-copy="{{ $gift->account_number }}"
                                        >
                                            Salin
                                        </button>
                                    @endif
                                </div>

                                <p class="responsive-text font-bold mt-3">
                                    {{ $gift->account_name ?: 'Nama penerima belum diatur' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="doa-section compact">
                <div class="section-head mb-4">
                    <p class="doa-label justify-center">
                        Ucapan & RSVP
                    </p>

                    <h2 class="doa-title text-5xl md:text-6xl mt-6">
                        Kirim Kehadiran & Ucapan
                    </h2>
                </div>

                <div class="rsvp-wrap mt-8">
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
                          class="form-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Tamu</label>
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
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak hadir</option>
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
                            <label class="uk-label">Ucapan / Doa</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1 uk-break-input"
                                      placeholder="Tulis ucapan dan doa terbaik..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full doa-btn">
                            Kirim Ucapan
                        </button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong>
                            <span>Tidak hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong>
                            <span>Hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="message-card">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black text-slate-950">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">
                                    {{ trim($message->message) }}
                                </p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p class="text-slate-500">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="doa-section text-center">
                <div class="closing-card">
                    <p class="doa-label justify-center">
                        Terima Kasih
                    </p>

                    <h2 class="responsive-text doa-title doa-gradient-text text-5xl md:text-7xl mt-8">
                        Sampai Jumpa
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda.
                        Semoga momen ini membawa kebahagiaan, kedamaian, dan mempererat kebersamaan.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
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
                            ? 'Hitung mundur menuju acara'
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

            const copyGiftButtons = document.querySelectorAll('.copy-gift-btn');

            copyGiftButtons.forEach(function (button) {
                button.addEventListener('click', async function () {
                    const textToCopy = button.dataset.copy || '';

                    if (!textToCopy) {
                        return;
                    }

                    try {
                        await navigator.clipboard.writeText(textToCopy);

                        const originalText = button.textContent;
                        button.textContent = 'Tersalin';
                        button.classList.add('copied');

                        setTimeout(function () {
                            button.textContent = originalText;
                            button.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        const tempInput = document.createElement('input');
                        tempInput.value = textToCopy;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);

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

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .doa-section > p,
                .doa-section > h1,
                .doa-section > h2,
                .doa-section > h3,
                .doa-label,
                .doa-title,
                .doa-gradient-text,
                .doa-nav,
                .doa-hero-panel,
                .doa-date-box,
                .doa-hero-panel-title,
                .doa-mini-info-item,
                .doa-hero-center,
                .doa-hero-kicker,
                .doa-hero-title,
                .doa-hero-desc,
                .doa-hero-actions,
                .doa-visual-frame,
                .doa-visual-inner,
                .doa-visual-placeholder,
                .doa-visual-symbol,
                .doa-floating-note,
                .doa-floating-location,
                .blessing-card,
                .blessing-index,
                .doa-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .doa-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('doa-show');
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
