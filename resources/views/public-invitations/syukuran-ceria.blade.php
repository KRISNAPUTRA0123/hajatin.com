<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Syukuran') . ' ' . ($invitation->title ?: 'Syukuran Ceria'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            color: var(--ceria-dark);
            background:
                radial-gradient(circle at top left, var(--ceria-bg-1), transparent 26%),
                radial-gradient(circle at top right, var(--ceria-bg-2), transparent 26%),
                linear-gradient(180deg, #ffffff 0%, var(--ceria-soft) 45%, #ffffff 100%);
        }

        .ceria-wrap {
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), color-mix(in srgb, var(--ceria-soft) 82%, white));
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent);
        }

        .ceria-wrap::before {
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--ceria-primary) 14%, transparent) 1.3px, transparent 1.3px);
        }

        .ceria-title,
        .cover-placeholder h2,
        .wave-card h3,
        .detail-card h3,
        .detail-item strong,
        .hero-stat strong,
        .gift-card h3,
        .summary-card strong,
        .closing-card h3 {
            color: var(--ceria-dark);
        }

        .cover-placeholder p,
        .wave-card p,
        .section-head p.desc,
        .detail-item small,
        .gift-card p,
        .hero-tag,
        .hero-stat span,
        .message-card p {
            color: var(--ceria-text);
        }

        .cover-blob {
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--ceria-primary) 20%, white), color-mix(in srgb, var(--ceria-accent) 26%, white)),
                linear-gradient(180deg, var(--ceria-soft), #ffffff);
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent);
        }

        .cover-inner {
            background: linear-gradient(180deg, rgba(255,255,255,.94), color-mix(in srgb, var(--ceria-soft) 90%, white));
            border-color: color-mix(in srgb, var(--ceria-primary) 20%, transparent);
        }

        .cover-placeholder {
            background:
                radial-gradient(circle at top left, color-mix(in srgb, var(--ceria-primary) 20%, transparent), transparent 28%),
                radial-gradient(circle at bottom right, color-mix(in srgb, var(--ceria-accent) 24%, transparent), transparent 30%),
                linear-gradient(180deg, var(--ceria-soft), #ffffff);
        }

        .wave-card::before,
        .gift-card::after {
            background: color-mix(in srgb, var(--ceria-primary) 16%, transparent);
        }

        .wave-card:nth-child(2)::before {
            background: color-mix(in srgb, var(--ceria-accent) 24%, transparent);
        }

        .detail-item,
        .map-placeholder,
        .countdown-card {
            background: linear-gradient(180deg, var(--ceria-soft), #ffffff);
        }

        .closing-card {
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--ceria-primary) 16%, white), color-mix(in srgb, var(--ceria-accent) 24%, white));
        }

        .ceria-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 20px;
        }

        .ceria-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 38px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(245,255,247,.96));
            border: 1px solid rgba(30, 80, 50, .08);
            box-shadow: 0 28px 80px rgba(50, 100, 70, .10);
        }

        .ceria-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(46, 125, 50, .06) 1.3px, transparent 1.3px);
            background-size: 24px 24px;
            opacity: .45;
            pointer-events: none;
            z-index: 0;
        }

        .ceria-wrap > * {
            position: relative;
            z-index: 1;
        }

        .ceria-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .ceria-section.compact {
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

        .ceria-date-line,
        .ceria-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .ceria-date-line span,
        .ceria-time-line span {
            display: inline;
        }

        .ceria-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--ceria-primary);
        }

        .ceria-label::before {
            content: "";
            width: 36px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--ceria-primary), var(--ceria-accent));
            display: inline-block;
        }

        .ceria-title {
            color: #17412f;
            line-height: .96;
            letter-spacing: -.05em;
            font-weight: 950;
        }

        .ceria-gradient-text {
            background: linear-gradient(135deg, #1d5e3a, var(--ceria-primary), var(--ceria-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .ceria-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 30px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.90);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 14px 34px rgba(30, 80, 50, .08);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .ceria-nav a {
            text-decoration: none;
            color: #52725c;
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .ceria-nav a:hover {
            background: rgba(61, 153, 92, .08);
            color: var(--ceria-primary);
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
            box-shadow: 0 14px 32px rgba(30, 80, 50, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: rgba(185, 246, 202, .8);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .ceria-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            padding: 15px 28px;
            border-radius: 999px;
            color: white;
            font-weight: 900;
            background: linear-gradient(135deg, var(--ceria-primary), var(--ceria-secondary));
            box-shadow: 0 16px 34px rgba(76, 175, 80, .24);
        }

        .ceria-btn.secondary {
            background: #ffffff;
            color: #17412f;
            border: 1px solid rgba(23, 65, 47, .10);
            box-shadow: 0 12px 26px rgba(30, 80, 50, .08);
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 44px;
            align-items: center;
        }

        .hero-copy {
            max-width: 690px;
        }

        .hero-tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .hero-tag {
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 10px 24px rgba(30, 80, 50, .06);
            font-size: 12px;
            font-weight: 900;
            color: #466a52;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 36px;
        }

        .hero-stat {
            background: #ffffff;
            border-radius: 26px;
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 14px 30px rgba(30, 80, 50, .07);
            padding: 22px;
            text-align: center;
        }

        .hero-stat strong {
            display: block;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            color: #17412f;
        }

        .hero-stat span {
            display: block;
            margin-top: 10px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .15em;
            color: #7b9b85;
        }

        .hero-board {
            position: relative;
            min-height: 600px;
        }

        .cover-blob {
            position: relative;
            min-height: 600px;
            border-radius: 40px;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(110, 200, 120, .28), rgba(255, 240, 170, .30)),
                linear-gradient(180deg, #effff1, #f8fff8);
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 24px 56px rgba(30, 80, 50, .12);
            padding: 22px;
        }

        .cover-inner {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 556px;
            border-radius: 30px;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(243,255,245,.96));
            border: 2px dashed rgba(76, 175, 80, .18);
        }

        .cover-main-image {
            width: 100%;
            height: 100%;
            min-height: 556px;
            object-fit: cover;
            display: block;
        }

        .cover-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 42px;
            background:
                radial-gradient(circle at top left, rgba(185, 246, 202, .55), transparent 28%),
                radial-gradient(circle at bottom right, rgba(255, 236, 179, .45), transparent 30%),
                linear-gradient(180deg, #f4fff4, #fbfffb);
        }

        .cover-placeholder h2 {
            margin: 0;
            font-size: clamp(2.3rem, 5vw, 4.4rem);
            line-height: .95;
            font-weight: 950;
            letter-spacing: -.05em;
            color: #17412f;
        }

        .cover-placeholder p {
            margin-top: 14px;
            color: #52725c;
            line-height: 1.8;
            max-width: 520px;
        }

        .leaf-ornament {
            position: absolute;
            width: clamp(82px, 13vw, 145px);
            height: auto !important;
            min-height: 0 !important;
            max-height: 170px;
            object-fit: contain !important;
            z-index: 2;
            pointer-events: none;
            opacity: .92;
            filter: drop-shadow(0 14px 22px rgba(30, 80, 50, .14));
        }

        .leaf-top {
            top: 22px;
            right: 22px;
            transform: rotate(18deg);
            transform-origin: center;
        }

        .leaf-bottom {
            left: 22px;
            bottom: 22px;
            transform: rotate(-20deg) scaleX(-1);
            transform-origin: center;
        }

        .cover-placeholder {
            z-index: 1;
        }

        .cover-placeholder .ceria-label,
        .cover-placeholder h2,
        .cover-placeholder p {
            position: relative;
            z-index: 4;
        }

        .wave-card-row {
            display: grid;
            gap: 22px;
            margin-top: 42px;
            justify-content: center;
        }

        .wave-card-row.wave-count-1 {
            grid-template-columns: minmax(280px, 460px);
        }

        .wave-card-row.wave-count-2 {
            grid-template-columns: repeat(2, minmax(280px, 460px));
        }

        .wave-card-row.wave-count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .wave-card,
        .detail-card,
        .gift-card,
        .gallery-card,
        .message-card,
        .summary-card,
        .form-card {
            background: #ffffff;
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 16px 36px rgba(30, 80, 50, .08);
        }

        .wave-card {
            border-radius: 34px;
            padding: 28px;
            position: relative;
            overflow: hidden;
        }

        .wave-card::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -30px;
            width: 170px;
            height: 170px;
            border-radius: 999px;
            background: rgba(185, 246, 202, .4);
        }

        .wave-card:nth-child(2)::before {
            background: rgba(255, 236, 179, .45);
        }

        .wave-card h3 {
            color: #17412f;
            font-size: 1.9rem;
            font-weight: 950;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .wave-card p {
            margin-top: 14px;
            color: #56755f;
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        .section-head {
            text-align: center;
        }

        .section-head p.desc {
            max-width: 780px;
            margin: 16px auto 0;
            color: #5b7a65;
            line-height: 1.8;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 24px;
            margin-top: 40px;
            align-items: start;
        }

        .detail-card {
            border-radius: 34px;
            padding: 28px;
        }

        .detail-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 950;
            color: #17412f;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .detail-item {
            background: linear-gradient(180deg, #f8fff8, #ffffff);
            border: 1px solid rgba(23, 65, 47, .06);
            border-radius: 24px;
            padding: 18px;
        }

        .detail-item.full {
            grid-column: span 2;
        }

        .detail-item small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .16em;
            font-weight: 900;
            color: #7f9a88;
        }

        .detail-item strong {
            display: block;
            margin-top: 10px;
            color: #17412f;
            font-size: 18px;
            line-height: 1.6;
            font-weight: 900;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .countdown-card {
            border-radius: 24px;
            padding: 20px;
            text-align: center;
            background: linear-gradient(180deg, #fcfff5, #ffffff);
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 10px 24px rgba(30, 80, 50, .06);
        }

        .countdown-card strong {
            display: block;
            font-size: 34px;
            line-height: 1;
            color: #17412f;
            font-weight: 950;
        }

        .countdown-card span {
            display: block;
            margin-top: 10px;
            color: #7b9b85;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .15em;
            font-weight: 900;
        }

        .map-card {
            margin-top: 22px;
            border-radius: 30px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 16px 34px rgba(30, 80, 50, .08);
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
            padding: 30px;
            text-align: center;
            text-decoration: none;
            background: linear-gradient(180deg, #f8fff8, #ffffff);
            color: #17412f;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-card {
            border-radius: 28px;
            overflow: hidden;
            padding: 10px;
            transform: rotate(0deg);
        }

        .gallery-card:nth-child(2) {
            transform: rotate(-2deg);
        }

        .gallery-card:nth-child(3) {
            transform: rotate(2deg);
        }

        .gallery-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            display: block;
            border-radius: 22px;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 440px);
            justify-content: center;
        }

        .gift-card {
            border-radius: 30px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .gift-card::after {
            content: "";
            position: absolute;
            bottom: -24px;
            right: -24px;
            width: 90px;
            height: 90px;
            border-radius: 999px;
            background: rgba(185, 246, 202, .35);
        }

        .gift-card h3 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 950;
            color: #17412f;
            position: relative;
            z-index: 2;
        }

        .gift-card p {
            margin-top: 8px;
            color: #5b7a65;
            position: relative;
            z-index: 2;
        }

        .gift-number {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 14px;
            border-radius: 16px;
            background: #f3fff4;
            color: var(--ceria-primary);
            font-weight: 900;
            position: relative;
            z-index: 2;
        }

        .rsvp-wrap {
            max-width: 860px;
            margin: 0 auto;
            width: 100%;
        }

        .form-card {
            border-radius: 30px;
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            border-radius: 24px;
            padding: 20px;
            text-align: center;
        }

        .summary-card strong {
            display: block;
            font-size: 30px;
            line-height: 1;
            color: #17412f;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            font-size: 12px;
            color: #7d9887;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .message-card {
            border-radius: 26px;
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
            background: rgba(185, 246, 202, .55);
            color: #2d6943;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 820px;
            margin: 0 auto;
            border-radius: 36px;
            padding: 42px 34px;
            text-align: center;
            background:
                linear-gradient(135deg, rgba(185, 246, 202, .40), rgba(255, 236, 179, .32));
            border: 1px solid rgba(23, 65, 47, .08);
            box-shadow: 0 18px 40px rgba(30, 80, 50, .08);
        }

        @media (max-width: 980px) {
            .ceria-shell {
                padding: 16px;
            }

            .ceria-section {
                padding: 80px 36px;
            }

            .hero-layout,
            .detail-layout,
            .gallery-grid,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .wave-card-row.wave-count-3 {
                grid-template-columns: repeat(2, minmax(280px, 460px));
            }

            .hero-stats,
            .detail-grid,
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .gift-grid.gift-count-1 {
                grid-template-columns: minmax(280px, 440px);
            }
        }

        @media (max-width: 640px) {
            .ceria-shell {
                padding: 0;
            }

            .ceria-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .wave-card-row,
            .wave-card-row.wave-count-1,
            .wave-card-row.wave-count-2,
            .wave-card-row.wave-count-3 {
                grid-template-columns: 1fr;
            }

            .ceria-section {
                padding: 72px 22px;
            }

            .ceria-section.compact {
                padding-top: 64px;
                padding-bottom: 64px;
            }

            .leaf-ornament {
                width: 78px;
                max-height: 100px;
                opacity: .82;
            }

            .leaf-top {
                top: 16px;
                right: 14px;
                transform: rotate(18deg);
            }

            .leaf-bottom {
                left: 14px;
                bottom: 16px;
                transform: rotate(-18deg) scaleX(-1);
            }

            .hero-copy {
                text-align: center;
            }

            .hero-tag-row,
            .hero-copy .flex {
                justify-content: center;
            }

            .hero-stats,
            .detail-grid,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1 {
                grid-template-columns: 1fr;
            }

            .detail-item.full {
                grid-column: span 1;
            }

            .cover-blob,
            .hero-board,
            .cover-inner,
            .cover-inner img {
                min-height: 460px;
            }

            .cover-placeholder {
                padding: 28px;
            }

            .floating-actions {
                right: 10px;
            }
        }
        /* ================================
        THEME OVERRIDE - WAJIB DI PALING BAWAH
        ================================ */

        body {
            color: var(--ceria-dark) !important;
            background:
                radial-gradient(circle at top left, var(--ceria-bg-1), transparent 26%),
                radial-gradient(circle at top right, var(--ceria-bg-2), transparent 26%),
                linear-gradient(180deg, #ffffff 0%, var(--ceria-soft) 45%, #ffffff 100%) !important;
        }

        .ceria-wrap {
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), color-mix(in srgb, var(--ceria-soft) 82%, white)) !important;
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent) !important;
        }

        .ceria-wrap::before {
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--ceria-primary) 14%, transparent) 1.3px, transparent 1.3px) !important;
        }

        .ceria-title,
        .cover-placeholder h2,
        .wave-card h3,
        .detail-card h3,
        .detail-item strong,
        .hero-stat strong,
        .gift-card h3,
        .summary-card strong,
        .closing-card h3 {
            color: var(--ceria-dark) !important;
        }

        .cover-placeholder p,
        .wave-card p,
        .section-head p.desc,
        .detail-item small,
        .gift-card p,
        .hero-tag,
        .hero-stat span,
        .message-card p {
            color: var(--ceria-text) !important;
        }

        .ceria-gradient-text {
            background: linear-gradient(135deg, var(--ceria-dark), var(--ceria-primary), var(--ceria-secondary)) !important;
            -webkit-background-clip: text !important;
            color: transparent !important;
        }

        .ceria-nav a:hover {
            background: color-mix(in srgb, var(--ceria-primary) 10%, white) !important;
            color: var(--ceria-primary) !important;
        }

        .ceria-btn {
            background: linear-gradient(135deg, var(--ceria-primary), var(--ceria-secondary)) !important;
            box-shadow: 0 16px 34px color-mix(in srgb, var(--ceria-primary) 24%, transparent) !important;
        }

        .ceria-btn.secondary {
            color: var(--ceria-dark) !important;
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent) !important;
        }

        .cover-blob {
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--ceria-primary) 20%, white), color-mix(in srgb, var(--ceria-accent) 26%, white)),
                linear-gradient(180deg, var(--ceria-soft), #ffffff) !important;
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent) !important;
        }

        .cover-inner {
            background: linear-gradient(180deg, rgba(255,255,255,.94), color-mix(in srgb, var(--ceria-soft) 90%, white)) !important;
            border-color: color-mix(in srgb, var(--ceria-primary) 20%, transparent) !important;
        }

        .cover-placeholder {
            background:
                radial-gradient(circle at top left, color-mix(in srgb, var(--ceria-primary) 20%, transparent), transparent 28%),
                radial-gradient(circle at bottom right, color-mix(in srgb, var(--ceria-accent) 24%, transparent), transparent 30%),
                linear-gradient(180deg, var(--ceria-soft), #ffffff) !important;
        }

        .wave-card,
        .detail-card,
        .gift-card,
        .gallery-card,
        .message-card,
        .summary-card,
        .form-card {
            border-color: color-mix(in srgb, var(--ceria-primary) 14%, transparent) !important;
            box-shadow: 0 16px 36px color-mix(in srgb, var(--ceria-primary) 10%, transparent) !important;
        }

        .wave-card::before,
        .gift-card::after {
            background: color-mix(in srgb, var(--ceria-primary) 16%, transparent) !important;
        }

        .wave-card:nth-child(2)::before {
            background: color-mix(in srgb, var(--ceria-accent) 24%, transparent) !important;
        }

        .detail-item,
        .map-placeholder,
        .countdown-card {
            background: linear-gradient(180deg, var(--ceria-soft), #ffffff) !important;
        }

        .gift-number {
            background: color-mix(in srgb, var(--ceria-primary) 10%, white) !important;
            color: var(--ceria-primary) !important;
        }

        .message-badge {
            background: color-mix(in srgb, var(--ceria-primary) 14%, white) !important;
            color: var(--ceria-primary) !important;
        }

        .closing-card {
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--ceria-primary) 16%, white), color-mix(in srgb, var(--ceria-accent) 24%, white)) !important;
        }

        .gift-copy-box {
            position: relative;
            z-index: 2;
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px;
            border-radius: 20px;
            background: color-mix(in srgb, var(--ceria-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--ceria-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--ceria-text);
        }

        .gift-copy-box .gift-number {
            display: block;
            margin-top: 6px;
            padding: 0;
            background: transparent !important;
            color: var(--ceria-primary) !important;
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
            background: linear-gradient(135deg, var(--ceria-primary), var(--ceria-secondary));
            box-shadow: 0 10px 22px color-mix(in srgb, var(--ceria-primary) 20%, transparent);
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        @media (max-width: 640px) {
            .gift-copy-box {
                align-items: flex-start;
                flex-direction: column;
            }

            .copy-gift-btn {
                width: 100%;
            }
        }

        /* =====================================================
        LUXURY CERIA ANIMATION - SYUKURAN CERIA
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .ceria-reveal,
        .ceria-section > p,
        .ceria-section > h1,
        .ceria-section > h2,
        .ceria-section > h3,
        .ceria-label,
        .ceria-title,
        .ceria-gradient-text,
        .ceria-nav,
        .hero-copy,
        .hero-tag,
        .hero-stat,
        .hero-board,
        .cover-blob,
        .cover-inner,
        .cover-placeholder,
        .leaf-ornament,
        .wave-card,
        .detail-card,
        .detail-item,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .ceria-btn {
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

        .ceria-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .ceria-nav {
            animation: ceriaNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-copy {
            animation: ceriaHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .ceria-label {
            animation: ceriaFadeDown .85s ease .12s both;
        }

        #opening .ceria-title {
            animation: ceriaTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .hero-tag {
            animation: ceriaFadeUp .85s ease .48s both;
        }

        #opening .ceria-btn {
            animation: ceriaFadeUp .85s ease .62s both;
        }

        #opening .hero-stat {
            animation: ceriaFadeUp .85s ease .74s both;
        }

        #opening .cover-blob {
            animation:
                ceriaCoverEnter 1.1s cubic-bezier(.2, .8, .2, 1) .35s both,
                ceriaCoverFloat 5.4s ease-in-out 1.4s infinite;
        }

        /* Background bergerak halus */
        .ceria-wrap {
            animation: ceriaWrapGlow 8s ease-in-out infinite alternate;
        }

        .ceria-wrap::before {
            animation: ceriaPatternMove 18s linear infinite;
        }

        /* Ornamen daun hidup */
        .leaf-top {
            animation: ceriaLeafTop 5.8s ease-in-out infinite;
        }

        .leaf-bottom {
            animation: ceriaLeafBottom 6.2s ease-in-out .25s infinite;
        }

        /* Dekorasi lingkaran card bergerak */
        .wave-card::before,
        .gift-card::after {
            animation: ceriaDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label glow */
        .ceria-label::before {
            animation: ceriaLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Button efek kilau */
        .ceria-btn,
        button.ceria-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .ceria-btn::after,
        button.ceria-btn::after,
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
            animation: ceriaButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover card premium desktop */
        @media (hover: hover) {
            .hero-stat:hover,
            .cover-blob:hover,
            .wave-card:hover,
            .detail-card:hover,
            .detail-item:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--ceria-primary) 30%, transparent) !important;
                box-shadow:
                    0 32px 82px color-mix(in srgb, var(--ceria-primary) 14%, transparent),
                    0 0 44px color-mix(in srgb, var(--ceria-accent) 14%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .cover-blob:hover img,
            .gallery-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .ceria-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--ceria-primary) 12%, transparent);
            }
        }

        .cover-main-image,
        .gallery-card img {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-card strong {
            animation: ceriaNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Gift number pulse */
        .gift-number,
        .message-badge {
            animation: ceriaSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery tetap hidup */
        .gallery-card:nth-child(3n+1) {
            animation: ceriaGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: ceriaGalleryMiddle 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: ceriaGalleryRight 4.8s ease-in-out infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: ceriaFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes ceriaNavEnter {
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

        @keyframes ceriaHeroCopyIn {
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

        @keyframes ceriaFadeDown {
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

        @keyframes ceriaFadeUp {
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

        @keyframes ceriaTitleIn {
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

        @keyframes ceriaCoverEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.93) rotate(2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes ceriaCoverFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes ceriaWrapGlow {
            from {
                box-shadow:
                    0 28px 80px color-mix(in srgb, var(--ceria-primary) 10%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 38px 112px color-mix(in srgb, var(--ceria-primary) 14%, transparent),
                    0 0 54px color-mix(in srgb, var(--ceria-accent) 18%, transparent);
            }
        }

        @keyframes ceriaPatternMove {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 96px 96px;
            }
        }

        @keyframes ceriaLeafTop {
            0%, 100% {
                transform: rotate(18deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(23deg) translateY(-10px) scale(1.04);
            }
        }

        @keyframes ceriaLeafBottom {
            0%, 100% {
                transform: rotate(-20deg) scaleX(-1) translateY(0) scale(1);
            }
            50% {
                transform: rotate(-15deg) scaleX(-1) translateY(-10px) scale(1.04);
            }
        }

        @keyframes ceriaDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes ceriaLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--ceria-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--ceria-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes ceriaButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes ceriaNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--ceria-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--ceria-accent) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--ceria-primary) 18%, transparent);
            }
        }

        @keyframes ceriaSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes ceriaGalleryLeft {
            0%, 100% {
                transform: rotate(0deg) translateY(0);
            }
            50% {
                transform: rotate(-1deg) translateY(-6px);
            }
        }

        @keyframes ceriaGalleryMiddle {
            0%, 100% {
                transform: rotate(-2deg) translateY(0);
            }
            50% {
                transform: rotate(-1.2deg) translateY(-7px);
            }
        }

        @keyframes ceriaGalleryRight {
            0%, 100% {
                transform: rotate(2deg) translateY(0);
            }
            50% {
                transform: rotate(1.2deg) translateY(-7px);
            }
        }

        @keyframes ceriaFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .ceria-reveal,
            .ceria-section > p,
            .ceria-section > h1,
            .ceria-section > h2,
            .ceria-section > h3,
            .ceria-label,
            .ceria-title,
            .ceria-gradient-text,
            .ceria-nav,
            .hero-copy,
            .hero-tag,
            .hero-stat,
            .hero-board,
            .cover-blob,
            .cover-inner,
            .cover-placeholder,
            .leaf-ornament,
            .wave-card,
            .detail-card,
            .detail-item,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .ceria-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .cover-blob {
                animation:
                    ceriaFadeUp .9s ease .3s both,
                    ceriaFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .ceria-reveal,
            .ceria-section > p,
            .ceria-section > h1,
            .ceria-section > h2,
            .ceria-section > h3,
            .ceria-label,
            .ceria-title,
            .ceria-gradient-text,
            .ceria-nav,
            .hero-copy,
            .hero-tag,
            .hero-stat,
            .hero-board,
            .cover-blob,
            .cover-inner,
            .cover-placeholder,
            .leaf-ornament,
            .wave-card,
            .detail-card,
            .detail-item,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .ceria-btn,
            .ceria-wrap,
            .ceria-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-card strong,
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
            'primary' => '#be123c',
            'secondary' => '#e11d48',
            'accent' => '#fbbf24',
            'dark' => '#4a1623',
            'text' => '#5f2634',
            'soft' => '#fff1f2',
            'bg1' => 'rgba(244, 63, 94, .18)',
            'bg2' => 'rgba(251, 191, 36, .20)',
        ],
        'emerald' => [
            'primary' => '#2e7d32',
            'secondary' => '#4caf50',
            'accent' => '#ffee58',
            'dark' => '#17412f',
            'text' => '#56755f',
            'soft' => '#f2fff4',
            'bg1' => 'rgba(170, 230, 180, .40)',
            'bg2' => 'rgba(255, 233, 166, .35)',
        ],
        'navy' => [
            'primary' => '#2563eb',
            'secondary' => '#38bdf8',
            'accent' => '#facc15',
            'dark' => '#0f172a',
            'text' => '#475569',
            'soft' => '#eff6ff',
            'bg1' => 'rgba(37, 99, 235, .16)',
            'bg2' => 'rgba(56, 189, 248, .18)',
        ],
        'rose' => [
            'primary' => '#db2777',
            'secondary' => '#f472b6',
            'accent' => '#fde68a',
            'dark' => '#831843',
            'text' => '#6b3754',
            'soft' => '#fff7fb',
            'bg1' => 'rgba(244, 114, 182, .20)',
            'bg2' => 'rgba(253, 230, 138, .24)',
        ],
        'gold' => [
            'primary' => '#b45309',
            'secondary' => '#f59e0b',
            'accent' => '#84cc16',
            'dark' => '#4a2c0a',
            'text' => '#72512d',
            'soft' => '#fffbeb',
            'bg1' => 'rgba(245, 158, 11, .18)',
            'bg2' => 'rgba(132, 204, 22, .16)',
        ],
        'slate' => [
            'primary' => '#475569',
            'secondary' => '#64748b',
            'accent' => '#94a3b8',
            'dark' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#f8fafc',
            'bg1' => 'rgba(100, 116, 139, .14)',
            'bg2' => 'rgba(148, 163, 184, .16)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];

    $syukuranHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $syukuranHighlights->count();

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
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Syukuran') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan syukuran') . "\n\nLink Undangan: " . $shareUrl);
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

    $giftCount = $invitation->gifts->count();
@endphp

<body
    style="
        --ceria-primary: {{ $activeTheme['primary'] }};
        --ceria-secondary: {{ $activeTheme['secondary'] }};
        --ceria-accent: {{ $activeTheme['accent'] }};
        --ceria-dark: {{ $activeTheme['dark'] }};
        --ceria-text: {{ $activeTheme['text'] }};
        --ceria-soft: {{ $activeTheme['soft'] }};
        --ceria-bg-1: {{ $activeTheme['bg1'] }};
        --ceria-bg-2: {{ $activeTheme['bg2'] }};
    "
>
    <main class="ceria-shell">
        <div class="ceria-wrap">

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
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background4.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="ceria-nav">
                <a href="#opening">Home</a>
                <a href="#about">Tentang</a>
                <a href="#detail">Detail</a>
                @if ($invitation->photos->count())
                    <a href="#gallery">Galeri</a>
                @endif
                @if ($invitation->gifts->count())
                    <a href="#gift">Amplop</a>
                @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="ceria-section">
                <div class="hero-layout">
                    <div class="hero-copy">
                        <div class="ceria-label">
                            Syukuran Ceria
                        </div>

                        <h1 class="responsive-text ceria-title ceria-gradient-text text-5xl md:text-7xl mt-8">
                            {{ $invitation->title ?: 'Syukuran Ceria' }}
                        </h1>

                        <p class="responsive-text text-slate-600 mt-6 leading-8 text-lg">
                            {{ $invitation->description ?: 'Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan meramaikan acara syukuran kami.' }}
                        </p>

                        <div class="hero-tag-row">
                            <span class="hero-tag">{{ $invitation->event_name ?: 'Acara Syukuran' }}</span>
                            <span class="hero-tag">{{ $invitation->host_name ?: 'Tuan Rumah' }}</span>
                            <span class="hero-tag">Nuansa Hangat & Ceria</span>
                        </div>

                        <div class="mt-9 flex flex-wrap gap-3">
                            <a href="#detail" class="ceria-btn">Lihat Detail</a>
                            <a href="#message" class="ceria-btn">Kirim Ucapan</a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat">
                                <strong>
                                    @if ($invitation->event_date)
                                        {{ $invitation->event_date->format('d') }}
                                    @else
                                        --
                                    @endif
                                </strong>
                                <span>Tanggal</span>
                            </div>

                            <div class="hero-stat">
                                <strong>{{ $invitation->photos->count() }}</strong>
                                <span>Galeri</span>
                            </div>

                            <div class="hero-stat">
                                <strong>{{ $invitation->messages->count() }}</strong>
                                <span>Ucapan</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-board">
                        <div class="cover-blob">
                            <div class="cover-inner">
                                @if ($invitation->cover_image)
                                    <img
                                        src="{{ asset('storage/' . $invitation->cover_image) }}"
                                        alt="Cover Undangan"
                                        class="cover-main-image"
                                    >
                                @elseif ($firstPhoto)
                                    <img
                                        src="{{ asset('storage/' . $firstPhoto->image_path) }}"
                                        alt="Galeri Utama"
                                        class="cover-main-image"
                                    >
                                @else
                                    <div class="cover-placeholder">
                                        <div class="ceria-label">Rasa Syukur & Kebersamaan</div>

                                        <h2 class="responsive-text mt-6">
                                            {{ $invitation->event_name ?: 'Acara Syukuran' }}
                                        </h2>

                                        <p class="responsive-text">
                                            {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Momen hangat untuk berkumpul, berbagi kebahagiaan, dan mensyukuri nikmat bersama orang-orang tercinta.' }}
                                        </p>
                                    </div>
                                @endif

                                <img
                                    src="{{ asset('assets/templates/syukuran-ceria/daun.png') }}"
                                    alt="Ornamen daun"
                                    class="leaf-ornament leaf-top"
                                >

                                <img
                                    src="{{ asset('assets/templates/syukuran-ceria/daun.png') }}"
                                    alt="Ornamen daun"
                                    class="leaf-ornament leaf-bottom"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $syukuranHighlights->count())
                <section id="about" class="ceria-section compact">
                    <div class="section-head">
                        <p class="ceria-label justify-center">
                            Tentang Acara
                        </p>

                        <h2 class="responsive-text ceria-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Momen Syukuran yang Hangat dan Menyenangkan' }}
                        </h2>

                        <p class="responsive-text desc">
                            {{ $invitation->host_name ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen berbagi rasa syukur, kebahagiaan, dan kebersamaan.' : 'Acara ini menjadi momen untuk mempererat silaturahmi, berbagi rasa syukur, dan merayakan kebersamaan dengan suasana yang ceria.' }}
                        </p>
                    </div>

                    @if ($highlightCount)
                        <div class="wave-card-row wave-count-{{ min($highlightCount, 3) }}">
                            @foreach ($syukuranHighlights as $index => $highlight)
                                <div class="wave-card">
                                    <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl text-white font-black"
                                        style="background: linear-gradient(135deg, var(--ceria-primary), var(--ceria-secondary));">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    @if (!empty($highlight['title']))
                                        <h3 class="responsive-text">
                                            {{ $highlight['title'] }}
                                        </h3>
                                    @endif

                                    @if (!empty($highlight['description']))
                                        <p class="responsive-text">
                                            {{ $highlight['description'] }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="ceria-section compact">
                <div class="section-head">
                    <p class="ceria-label justify-center">
                        Detail Acara
                    </p>

                    <h2 class="ceria-title text-5xl md:text-6xl mt-6">
                        Informasi Syukuran
                    </h2>

                    <p class="responsive-text desc">
                        Simpan jadwalnya, lihat lokasinya, dan jangan sampai terlewat momen bahagia ini.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="detail-card">
                        <h3>Info Utama</h3>

                        <div class="detail-grid">
                            <div class="detail-item">
                                <small>Jenis Acara</small>
                                <strong class="responsive-text">
                                    {{ $invitation->event_name ?: 'Syukuran' }}
                                </strong>
                            </div>

                            <div class="detail-item">
                                <small class="mb-6">Tanggal</small>
                                <strong class="ceria-date-line">
                                    @if ($invitation->event_date)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>

                                        @if ($invitation->event_end_date)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </strong>
                            </div>

                            <div class="detail-item">
                                <small class="mb-6">Waktu</small>
                                <strong class="ceria-time-line">
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

                            <div class="detail-item">
                                <small class="mb-[-20px]">Nama Lokasi</small>
                                <strong class="responsive-text">
                                    {{ $invitation->location_name ?: 'Lokasi acara belum diatur' }}
                                </strong>
                            </div>

                            @if ($invitation->address)
                                <div class="detail-item full">
                                    <small>Alamat Lengkap</small>
                                    <strong class="responsive-text">
                                        {{ $invitation->address }}
                                    </strong>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="ceria-btn">
                                    📅 Atur Pengingat
                                </a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="ceria-btn">
                                    📍 Buka Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="detail-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Menuju Hari Acara</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Yuk siapkan waktu untuk hadir di acara syukuran ini.
                            </p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card">
                                    <strong id="countdown-days">00</strong>
                                    <span>Hari</span>
                                </div>

                                <div class="countdown-card">
                                    <strong id="countdown-hours">00</strong>
                                    <span>Jam</span>
                                </div>

                                <div class="countdown-card">
                                    <strong id="countdown-minutes">00</strong>
                                    <span>Menit</span>
                                </div>

                                <div class="countdown-card">
                                    <strong id="countdown-seconds">00</strong>
                                    <span>Detik</span>
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
            @if ($invitation->photos->count())
                <section id="gallery" class="ceria-section compact">
                    <div class="section-head">
                        <p class="ceria-label justify-center">
                            Galeri Acara
                        </p>

                        <h2 class="ceria-title text-5xl md:text-6xl mt-6">
                            Potret Kebahagiaan
                        </h2>

                        <p class="responsive-text desc">
                            Dokumentasi yang bisa melengkapi undangan agar tampil lebih hidup dan berkesan.
                        </p>
                    </div>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-card">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Syukuran">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="ceria-section compact">
                    <div class="section-head">
                        <p class="ceria-label justify-center">
                            Amplop Digital
                        </p>

                        <h2 class="ceria-title text-5xl md:text-6xl mt-6">
                            Kirim Doa & Dukungan
                        </h2>

                        <p class="responsive-text desc">
                            Jika berkenan, tamu dapat mengirimkan amplop digital melalui informasi berikut.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            <div class="gift-card">
                                <h3 class="responsive-text ml-2">
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

                                <p class="responsive-text font-bold ml-2">
                                    {{ $gift->account_name ?: 'Nama penerima belum diatur' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="ceria-section compact">
                <div class="section-head">
                    <p class="ceria-label justify-center">
                        Ucapan & RSVP
                    </p>

                    <h2 class="ceria-title text-5xl md:text-6xl mt-6">
                        Kirim Konfirmasi Kehadiran
                    </h2>

                    <p class="responsive-text desc">
                        Silakan isi konfirmasi kehadiran dan tuliskan doa atau ucapan terbaik Anda.
                    </p>
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

                        <button type="submit" class="w-full ceria-btn">
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
            <section id="closing" class="ceria-section text-center">
                <div class="closing-card">
                    <p class="ceria-label justify-center">
                        Terima Kasih
                    </p>

                    <h2 class="responsive-text ceria-title ceria-gradient-text text-5xl md:text-7xl mt-8">
                        Sampai Jumpa
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda.
                        Semoga acara ini membawa kebahagiaan, keberkahan, dan mempererat tali silaturahmi.
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
                .ceria-section > p,
                .ceria-section > h1,
                .ceria-section > h2,
                .ceria-section > h3,
                .ceria-label,
                .ceria-title,
                .ceria-gradient-text,
                .ceria-nav,
                .hero-copy,
                .hero-tag,
                .hero-stat,
                .hero-board,
                .cover-blob,
                .cover-inner,
                .cover-placeholder,
                .leaf-ornament,
                .wave-card,
                .detail-card,
                .detail-item,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .ceria-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('ceria-show');
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
