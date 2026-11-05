<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Syukuran') . ' ' . ($invitation->title ?: 'Syukuran Soft'));
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
            color: var(--soft-dark);
            background:
                radial-gradient(circle at top left, var(--soft-glow-1), transparent 34%),
                radial-gradient(circle at top right, var(--soft-glow-2), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, var(--soft-base) 46%, #ffffff 100%);
        }

        .soft-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 22px;
        }

        .soft-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 44px;
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--soft-accent) 15%, transparent), transparent 24%),
                radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--soft-primary) 10%, transparent), transparent 26%),
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,255,255,.96));
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 34px 90px rgba(42, 58, 44, .08);
        }

        .soft-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .42;
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--soft-primary) 11%, transparent) 1.2px, transparent 1.2px);
            background-size: 28px 28px;
        }

        .soft-wrap > * {
            position: relative;
            z-index: 1;
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

        .soft-section {
            min-height: 100vh;
            padding: 88px 62px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .soft-section.compact {
            min-height: auto;
            padding-top: 76px;
            padding-bottom: 76px;
        }

        .soft-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--soft-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .soft-label::before,
        .soft-label::after {
            content: "";
            width: 28px;
            height: 1.5px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--soft-primary), var(--soft-accent));
        }

        .soft-title {
            color: var(--soft-dark);
            font-weight: 950;
            letter-spacing: -.055em;
            line-height: .98;
        }

        .soft-gradient-text {
            background: linear-gradient(135deg, var(--soft-dark), var(--soft-primary), var(--soft-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .soft-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            color: white;
            padding: 13px 24px;
            border-radius: 999px;
            font-weight: 950;
            background: linear-gradient(135deg, var(--soft-primary), var(--soft-secondary));
            box-shadow: 0 16px 32px color-mix(in srgb, var(--soft-primary) 22%, transparent);
        }

        .soft-btn.secondary {
            color: var(--soft-dark);
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 14%, transparent);
            box-shadow: 0 14px 28px rgba(42, 58, 44, .07);
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
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 14px 30px rgba(42, 58, 44, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--soft-accent) 32%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .soft-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 26px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.84);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 11%, transparent);
            box-shadow: 0 16px 34px rgba(42, 58, 44, .07);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .soft-nav a {
            text-decoration: none;
            color: var(--soft-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .soft-nav a:hover {
            color: var(--soft-primary);
            background: color-mix(in srgb, var(--soft-primary) 7%, white);
        }

        .hero-soft {
            min-height: 100vh;
            padding: 76px 62px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-soft-card {
            position: relative;
            overflow: hidden;
            border-radius: 42px;
            min-height: 590px;
            padding: 62px;
            background:
                linear-gradient(90deg, rgba(255,255,255,.96) 0%, rgba(255,255,255,.88) 48%, color-mix(in srgb, var(--soft-accent) 10%, white) 100%);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 24px 60px rgba(42,58,44,.08);
        }

        .hero-soft-card::before {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            left: -150px;
            bottom: -170px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-primary) 13%, transparent);
        }

        .hero-soft-card::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            right: -140px;
            top: -130px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-accent) 22%, transparent);
        }

        .hero-soft-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr .92fr;
            gap: 44px;
            align-items: center;
        }

        .hero-soft-copy {
            min-width: 0;
            max-width: 620px;
        }

        .soft-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-accent) 18%, white);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            color: var(--soft-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .soft-badge span {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: var(--soft-primary);
        }

        .hero-soft-title {
            margin-top: 22px;
            font-size: clamp(2.8rem, 5.8vw, 5.2rem);
            line-height: .96;
            letter-spacing: -.05em;
            max-width: 620px;
        }

        .hero-soft-desc {
            margin-top: 24px;
            color: var(--soft-text);
            line-height: 1.9;
            font-size: 1.05rem;
            max-width: 560px;
        }

        .host-line {
            margin-top: 28px;
            padding-left: 22px;
            border-left: 2px solid color-mix(in srgb, var(--soft-primary) 26%, transparent);
        }

        .host-line small {
            display: block;
            color: var(--soft-text);
            font-weight: 700;
        }

        .host-line strong {
            display: block;
            margin-top: 4px;
            color: var(--soft-dark);
            font-size: 1.15rem;
            font-weight: 950;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .hero-soft-visual {
            position: relative;
            min-height: 470px;
        }

        .soft-cover-frame {
            position: absolute;
            inset: 0 0 0 30px;
            overflow: hidden;
            border-radius: 140px 42px 140px 42px;
            border: 10px solid rgba(255,255,255,.8);
            background:
                radial-gradient(circle at 35% 30%, color-mix(in srgb, var(--soft-accent) 26%, transparent), transparent 36%),
                linear-gradient(180deg, color-mix(in srgb, var(--soft-primary) 7%, white), #ffffff);
            box-shadow: 0 28px 54px rgba(42,58,44,.12);
        }

        .soft-cover-frame img {
            width: 100%;
            height: 100%;
            min-height: 470px;
            object-fit: cover;
            display: block;
            opacity: .94;
        }

        .soft-cover-placeholder {
            min-height: 470px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 34px;
            text-align: center;
        }

        .soft-cover-placeholder .vase {
            width: 128px;
            height: 128px;
            margin: 0 auto 22px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--soft-primary) 12%, white);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 14%, transparent);
            box-shadow: 0 14px 30px rgba(42, 58, 44, .08);
            overflow: hidden;
        }

        .soft-cover-placeholder .vase-img {
            width: 82px;
            height: 82px;
            max-width: 82px;
            max-height: 82px;
            object-fit: contain;
            display: block;
        }

        .soft-cover-placeholder h2 {
            color: var(--soft-dark);
            font-size: clamp(1.9rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -.045em;
            font-weight: 950;
        }

        .soft-cover-placeholder p {
            margin-top: 14px;
            color: var(--soft-text);
            line-height: 1.8;
        }

        .leaf-line {
            position: absolute;
            color: color-mix(in srgb, var(--soft-primary) 40%, transparent);
            font-size: 56px;
            pointer-events: none;
            z-index: 3;
        }

        .leaf-line.one { top: 24px; left: 26px; transform: rotate(-18deg); }
        .leaf-line.two { right: 24px; bottom: 24px; transform: rotate(20deg); }
        .leaf-line.three { top: 64px; right: 44%; transform: rotate(12deg); font-size: 40px; }

        .hero-detail-strip {
            position: relative;
            z-index: 3;
            margin-top: -32px;
            padding: 18px;
            border-radius: 30px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 20px 46px rgba(42,58,44,.09);
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0;
        }

        .strip-card {
            padding: 20px 18px;
            text-align: center;
            border-right: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
        }

        .strip-card:last-child {
            border-right: 0;
        }

        .strip-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            color: var(--soft-primary);
            background: color-mix(in srgb, var(--soft-primary) 11%, white);
        }

        .strip-card:nth-child(even) .strip-icon {
            color: var(--soft-secondary);
            background: color-mix(in srgb, var(--soft-accent) 25%, white);
        }

        .strip-card small {
            display: block;
            color: var(--soft-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .strip-card strong {
            display: block;
            margin-top: 10px;
            color: var(--soft-dark);
            font-size: 14px;
            line-height: 1.55;
            font-weight: 950;
        }

        .soft-date-line,
        .soft-time-line {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
            line-height: 1.5;
        }

        .section-head {
            text-align: center;
        }

        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--soft-text);
            line-height: 1.85;
        }

        .about-soft-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .about-soft-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            min-height: 190px;
            border-radius: 30px;
            background: color-mix(in srgb, var(--soft-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 18px 40px rgba(42,58,44,.06);
        }

        .about-soft-card:nth-child(even) {
            background: color-mix(in srgb, var(--soft-accent) 18%, white);
        }

        .about-soft-card::after {
            content: "";
            position: absolute;
            right: -42px;
            bottom: -42px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-primary) 9%, transparent);
            opacity: .8;
            pointer-events: none;
        }

        .about-soft-icon {
            width: 58px;
            height: 58px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--soft-primary);
            background: rgba(255,255,255,.75);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 12%, transparent);
            font-size: 24px;
            margin-bottom: 16px;
        }

        .about-soft-card h3,
        .about-soft-card p {
            position: relative;
            z-index: 2;
        }

        .about-soft-card h3 {
            color: var(--soft-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .about-soft-card p {
            margin-top: 10px;
            color: var(--soft-text);
            line-height: 1.8;
        }

        .detail-soft-grid {
            display: grid;
            grid-template-columns: 1fr .9fr;
            gap: 22px;
            margin-top: 38px;
            align-items: start;
        }

        .soft-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(42,58,44,.07);
            border-radius: 34px;
            padding: 30px;
        }

        .soft-card h3 {
            color: var(--soft-dark);
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
            border-top: 1px dashed color-mix(in srgb, var(--soft-primary) 16%, transparent);
        }

        .detail-row .label {
            color: var(--soft-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--soft-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .detail-row .soft-date-line,
        .detail-row .soft-time-line {
            justify-content: flex-start;
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
            background: linear-gradient(180deg, color-mix(in srgb, var(--soft-base) 88%, white), white);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--soft-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--soft-text);
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
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 16px 38px rgba(42,58,44,.07);
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
            color: var(--soft-dark);
            background:
                radial-gradient(circle at 28% 24%, color-mix(in srgb, var(--soft-accent) 22%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--soft-base) 94%, white));
        }

        .gallery-soft-wrap {
            margin-top: 34px;
            padding: 18px;
            border-radius: 34px;
            background: rgba(255,255,255,.76);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(42,58,44,.06);
        }

        .gallery-soft-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .gallery-soft-item {
            border-radius: 22px;
            overflow: hidden;
            background: color-mix(in srgb, var(--soft-base) 80%, white);
            min-height: 170px;
        }

        .gallery-soft-item img {
            width: 100%;
            height: 100%;
            min-height: 170px;
            object-fit: cover;
            display: block;
        }

        .gallery-soft-placeholder {
            min-height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--soft-primary);
            font-size: 34px;
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--soft-accent) 20%, transparent), transparent 32%),
                color-mix(in srgb, var(--soft-primary) 8%, white);
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 580px);
            justify-content: center;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            background:
                radial-gradient(circle at left, color-mix(in srgb, var(--soft-primary) 10%, transparent), transparent 38%),
                rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(42,58,44,.07);
            padding: 26px;
        }

        .gift-card h3 {
            color: var(--soft-dark);
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
            border-radius: 20px;
            background: color-mix(in srgb, var(--soft-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--soft-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--soft-primary);
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
            background: linear-gradient(135deg, var(--soft-primary), var(--soft-secondary));
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .rsvp-grid {
            max-width: 980px;
            width: 100%;
            margin: 34px auto 0;
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 18px;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 16px 34px rgba(42,58,44,.07);
            border-radius: 30px;
        }

        .form-card {
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .summary-card {
            padding: 18px;
            text-align: center;
        }

        .summary-card strong {
            display: block;
            color: var(--soft-dark);
            font-size: 28px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--soft-text);
            font-size: 12px;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message-card {
            padding: 18px;
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

        .message-avatar {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--soft-primary);
            background: color-mix(in srgb, var(--soft-primary) 9%, white);
            font-weight: 950;
        }

        .message-badge {
            padding: 7px 10px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-primary) 10%, white);
            color: var(--soft-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-soft-card {
            max-width: 830px;
            margin: 0 auto;
            text-align: center;
            border-radius: 42px;
            padding: 48px 34px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--soft-primary) 11%, transparent), transparent 36%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--soft-accent) 20%, transparent), transparent 34%),
                rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(42,58,44,.07);
        }

        @media (max-width: 1024px) {
            .hero-soft-grid,
            .detail-soft-grid,
            .rsvp-grid {
                grid-template-columns: 1fr;
            }

            .hero-soft-card {
                padding: 46px;
            }

            .soft-cover-frame {
                position: relative;
                inset: auto;
                min-height: 420px;
            }

            .hero-detail-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .strip-card:nth-child(2) {
                border-right: 0;
            }

            .strip-card:nth-child(1),
            .strip-card:nth-child(2) {
                border-bottom: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            }

            .about-soft-grid,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .gallery-soft-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .soft-shell {
                padding: 0;
            }

            .soft-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .soft-nav {
                top: 8px;
            }

            .soft-section,
            .hero-soft {
                padding: 72px 22px;
            }

            .soft-section.compact {
                padding-top: 64px;
                padding-bottom: 64px;
            }

            .hero-soft-card {
                padding: 30px 24px;
                border-radius: 32px;
            }

            .hero-soft-copy {
                text-align: center;
            }

            .hero-soft-title {
                font-size: clamp(3rem, 16vw, 4.8rem);
            }

            .hero-actions {
                justify-content: center;
            }

            .host-line {
                padding-left: 0;
                border-left: 0;
                border-top: 1px solid color-mix(in srgb, var(--soft-primary) 18%, transparent);
                padding-top: 18px;
            }

            .hero-soft-visual {
                min-height: auto;
            }

            .soft-cover-frame,
            .soft-cover-frame img,
            .soft-cover-placeholder {
                min-height: 360px;
                border-radius: 42px;
            }

            .hero-detail-strip,
            .summary-grid,
            .countdown-grid,
            .gallery-soft-grid {
                grid-template-columns: 1fr;
            }

            .strip-card {
                border-right: 0;
                border-bottom: 1px solid color-mix(in srgb, var(--soft-primary) 10%, transparent);
            }

            .strip-card:last-child {
                border-bottom: 0;
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
        .soft-about-grid {
            display: grid;
            gap: 24px;
            margin-top: 38px;
            justify-content: center;
            align-items: stretch;
        }

        .soft-about-grid.count-1 {
            grid-template-columns: minmax(280px, 460px);
        }

        .soft-about-grid.count-2 {
            grid-template-columns: repeat(2, minmax(280px, 420px));
        }

        .soft-about-grid.count-3 {
            grid-template-columns: repeat(3, minmax(280px, 1fr));
        }

        .about-soft-card {
            position: relative;
            background: rgba(255,255,255,.82);
            border: 1px solid rgba(80, 104, 77, .12);
            border-radius: 32px;
            padding: 34px 28px 28px;
            box-shadow: 0 18px 40px rgba(80, 104, 77, .08);
            overflow: hidden;
            min-height: 220px;
        }

        .about-soft-card::after {
            content: "";
            position: absolute;
            right: -42px;
            bottom: -42px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--soft-primary) 9%, transparent);
            opacity: .8;
            pointer-events: none;
        }

        .about-soft-number {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--soft-primary), var(--soft-secondary));
            box-shadow: 0 14px 28px rgba(80, 104, 77, .16);
            margin-bottom: 22px;
        }

        .about-soft-card h3 {
            font-size: 1.9rem;
            line-height: 1.15;
            font-weight: 900;
            color: var(--soft-ink);
            margin: 0 0 14px;
        }

        .about-soft-card p {
            margin: 0;
            color: rgba(59, 78, 56, .82);
            line-height: 1.9;
            font-size: 1rem;
        }

        @media (max-width: 980px) {
            .soft-about-grid.count-3 {
                grid-template-columns: repeat(2, minmax(260px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .soft-about-grid,
            .soft-about-grid.count-1,
            .soft-about-grid.count-2,
            .soft-about-grid.count-3 {
                grid-template-columns: 1fr;
            }

            .about-soft-card {
                min-height: auto;
            }
        }

        /* =====================================================
        LUXURY SOFT ANIMATION - SYUKURAN SOFT
        Tempel sebelum penutup style
        ===================================================== */

        .soft-reveal,
        .soft-section > p,
        .soft-section > h1,
        .soft-section > h2,
        .soft-section > h3,
        .soft-label,
        .soft-title,
        .soft-gradient-text,
        .soft-nav,
        .hero-soft-card,
        .hero-soft-copy,
        .soft-badge,
        .hero-soft-title,
        .hero-soft-desc,
        .host-line,
        .hero-actions,
        .hero-soft-visual,
        .soft-cover-frame,
        .soft-cover-placeholder,
        .vase,
        .leaf-line,
        .hero-detail-strip,
        .strip-card,
        .strip-icon,
        .about-soft-card,
        .about-soft-number,
        .soft-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-soft-wrap,
        .gallery-soft-item,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-soft-card,
        .soft-btn {
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

        .soft-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .soft-nav {
            animation: softNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-soft-card {
            animation: softHeroCardEnter 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .soft-badge {
            animation: softFadeDown .85s ease .18s both;
        }

        #opening .hero-soft-title {
            animation: softTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .hero-soft-desc {
            animation: softFadeUp .85s ease .48s both;
        }

        #opening .host-line {
            animation: softFadeUp .85s ease .58s both;
        }

        #opening .hero-actions {
            animation: softFadeUp .85s ease .70s both;
        }

        #opening .soft-cover-frame {
            animation:
                softCoverEnter 1.1s cubic-bezier(.2, .8, .2, 1) .28s both,
                softCoverFloat 5.4s ease-in-out 1.4s infinite;
        }

        #opening .hero-detail-strip {
            animation: softStripEnter .95s cubic-bezier(.2, .8, .2, 1) .72s both;
        }

        /* Background lembut bergerak */
        .soft-wrap {
            animation: softWrapGlow 8s ease-in-out infinite alternate;
        }

        .soft-wrap::before {
            animation: softPatternMove 18s linear infinite;
        }

        /* Dekorasi hero */
        .hero-soft-card::before,
        .hero-soft-card::after,
        .about-soft-card::after,
        .gift-card::before,
        .closing-soft-card::before,
        .closing-soft-card::after {
            animation: softDecorFloat 6.4s ease-in-out infinite;
        }

        /* Leaf ornament */
        .leaf-line.one {
            animation: softLeafOne 5.8s ease-in-out infinite;
        }

        .leaf-line.two {
            animation: softLeafTwo 6.2s ease-in-out .25s infinite;
        }

        .leaf-line.three {
            animation: softLeafThree 5.6s ease-in-out .45s infinite;
        }

        /* Label glow */
        .soft-label::before,
        .soft-label::after {
            animation: softLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .soft-btn,
        button.soft-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .soft-btn::after,
        button.soft-btn::after,
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
            animation: softButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .hero-soft-card:hover,
            .soft-cover-frame:hover,
            .hero-detail-strip:hover,
            .strip-card:hover,
            .about-soft-card:hover,
            .soft-card:hover,
            .detail-row:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-soft-wrap:hover,
            .gallery-soft-item:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-soft-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--soft-primary) 32%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--soft-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--soft-accent) 16%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .soft-cover-frame:hover img,
            .gallery-soft-item:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .soft-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--soft-primary) 12%, transparent);
            }
        }

        .soft-cover-frame img,
        .gallery-soft-item img,
        .vase-img {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: softNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon dan angka pulse */
        .strip-icon,
        .about-soft-number,
        .vase,
        .gift-number,
        .message-badge,
        .message-avatar {
            animation: softSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-soft-item:nth-child(4n+1) {
            animation: softGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-soft-item:nth-child(4n+2) {
            animation: softGalleryTwo 4.8s ease-in-out .15s infinite;
        }

        .gallery-soft-item:nth-child(4n+3) {
            animation: softGalleryThree 4.8s ease-in-out .3s infinite;
        }

        .gallery-soft-item:nth-child(4n+4) {
            animation: softGalleryFour 4.8s ease-in-out .45s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: softFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes softNavEnter {
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

        @keyframes softHeroCardEnter {
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

        @keyframes softCoverEnter {
            from {
                opacity: 0;
                transform: translateX(28px) translateY(34px) scale(.93) rotate(3deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes softCoverFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes softStripEnter {
            from {
                opacity: 0;
                transform: translateY(36px) scale(.96);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes softFadeDown {
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

        @keyframes softFadeUp {
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

        @keyframes softTitleIn {
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

        @keyframes softWrapGlow {
            from {
                box-shadow:
                    0 34px 90px color-mix(in srgb, var(--soft-primary) 9%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 42px 118px color-mix(in srgb, var(--soft-primary) 13%, transparent),
                    0 0 58px color-mix(in srgb, var(--soft-accent) 16%, transparent);
            }
        }

        @keyframes softPatternMove {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 112px 112px;
            }
        }

        @keyframes softDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes softLeafOne {
            0%, 100% {
                transform: rotate(-18deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(-13deg) translateY(-9px) scale(1.05);
            }
        }

        @keyframes softLeafTwo {
            0%, 100% {
                transform: rotate(20deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(15deg) translateY(-9px) scale(1.05);
            }
        }

        @keyframes softLeafThree {
            0%, 100% {
                transform: rotate(12deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(17deg) translateY(-7px) scale(1.05);
            }
        }

        @keyframes softLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--soft-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--soft-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes softButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes softNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--soft-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--soft-accent) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--soft-primary) 18%, transparent);
            }
        }

        @keyframes softSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes softGalleryOne {
            0%, 100% {
                transform: translateY(0) rotate(-.4deg);
            }
            50% {
                transform: translateY(-7px) rotate(-.9deg);
            }
        }

        @keyframes softGalleryTwo {
            0%, 100% {
                transform: translateY(0) rotate(.4deg);
            }
            50% {
                transform: translateY(-6px) rotate(.9deg);
            }
        }

        @keyframes softGalleryThree {
            0%, 100% {
                transform: translateY(0) rotate(.2deg);
            }
            50% {
                transform: translateY(-7px) rotate(.7deg);
            }
        }

        @keyframes softGalleryFour {
            0%, 100% {
                transform: translateY(0) rotate(-.2deg);
            }
            50% {
                transform: translateY(-6px) rotate(-.6deg);
            }
        }

        @keyframes softFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .soft-reveal,
            .soft-section > p,
            .soft-section > h1,
            .soft-section > h2,
            .soft-section > h3,
            .soft-label,
            .soft-title,
            .soft-gradient-text,
            .soft-nav,
            .hero-soft-card,
            .hero-soft-copy,
            .soft-badge,
            .hero-soft-title,
            .hero-soft-desc,
            .host-line,
            .hero-actions,
            .hero-soft-visual,
            .soft-cover-frame,
            .soft-cover-placeholder,
            .vase,
            .leaf-line,
            .hero-detail-strip,
            .strip-card,
            .strip-icon,
            .about-soft-card,
            .about-soft-number,
            .soft-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-soft-wrap,
            .gallery-soft-item,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-soft-card,
            .soft-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-soft-item:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .soft-cover-frame {
                animation:
                    softFadeUp .9s ease .3s both,
                    softFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .soft-reveal,
            .soft-section > p,
            .soft-section > h1,
            .soft-section > h2,
            .soft-section > h3,
            .soft-label,
            .soft-title,
            .soft-gradient-text,
            .soft-nav,
            .hero-soft-card,
            .hero-soft-copy,
            .soft-badge,
            .hero-soft-title,
            .hero-soft-desc,
            .host-line,
            .hero-actions,
            .hero-soft-visual,
            .soft-cover-frame,
            .soft-cover-placeholder,
            .vase,
            .leaf-line,
            .hero-detail-strip,
            .strip-card,
            .strip-icon,
            .about-soft-card,
            .about-soft-number,
            .soft-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-soft-wrap,
            .gallery-soft-item,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-soft-card,
            .soft-btn,
            .soft-wrap,
            .soft-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-number,
            .gift-number,
            .message-badge,
            .message-avatar {
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
            'primary' => '#a73552',
            'secondary' => '#c95c77',
            'accent' => '#f3d3ba',
            'dark' => '#4b2631',
            'text' => '#795866',
            'base' => '#fff8f8',
            'glow1' => 'rgba(201, 92, 119, .12)',
            'glow2' => 'rgba(243, 211, 186, .24)',
        ],
        'emerald' => [
            'primary' => '#6f8b67',
            'secondary' => '#9caf88',
            'accent' => '#ead7bd',
            'dark' => '#42583d',
            'text' => '#6c7667',
            'base' => '#fbfff9',
            'glow1' => 'rgba(111, 139, 103, .12)',
            'glow2' => 'rgba(234, 215, 189, .26)',
        ],
        'navy' => [
            'primary' => '#60758f',
            'secondary' => '#8da3bd',
            'accent' => '#ead7bd',
            'dark' => '#27384e',
            'text' => '#697789',
            'base' => '#f7fbff',
            'glow1' => 'rgba(96, 117, 143, .12)',
            'glow2' => 'rgba(141, 163, 189, .16)',
        ],
        'rose' => [
            'primary' => '#c77a8f',
            'secondary' => '#e4a4b4',
            'accent' => '#f5dccd',
            'dark' => '#6d3d4b',
            'text' => '#866473',
            'base' => '#fff9fb',
            'glow1' => 'rgba(199, 122, 143, .12)',
            'glow2' => 'rgba(245, 220, 205, .25)',
        ],
        'gold' => [
            'primary' => '#b28b52',
            'secondary' => '#d2ad74',
            'accent' => '#f3dfbd',
            'dark' => '#5a4327',
            'text' => '#806b50',
            'base' => '#fffdf6',
            'glow1' => 'rgba(178, 139, 82, .13)',
            'glow2' => 'rgba(243, 223, 189, .28)',
        ],
        'slate' => [
            'primary' => '#6b7280',
            'secondary' => '#9ca3af',
            'accent' => '#e5e7eb',
            'dark' => '#334155',
            'text' => '#64748b',
            'base' => '#fafafa',
            'glow1' => 'rgba(107, 114, 128, .10)',
            'glow2' => 'rgba(229, 231, 235, .24)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];
    $firstPhoto = $invitation->photos->first();
    $photos = $invitation->photos->values();
    $giftCount = $invitation->gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Syukuran';
    $eventName = $invitation->event_name ?: 'Syukuran';
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
        "Dengan penuh rasa syukur dan hormat, kami mengundang Anda untuk hadir dalam acara:\n\n" .
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
        "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\n" .
        "Terima kasih.";

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

    $softHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();
@endphp

<body
    style="
        --soft-primary: {{ $activeTheme['primary'] }};
        --soft-secondary: {{ $activeTheme['secondary'] }};
        --soft-accent: {{ $activeTheme['accent'] }};
        --soft-dark: {{ $activeTheme['dark'] }};
        --soft-text: {{ $activeTheme['text'] }};
        --soft-base: {{ $activeTheme['base'] }};
        --soft-glow-1: {{ $activeTheme['glow1'] }};
        --soft-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="soft-shell">
        <div class="soft-wrap">
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

            <nav class="soft-nav">
                <a href="#opening">Home</a>
                <a href="#detail">Detail</a>
                <a href="#about">Tentang</a>
                @if ($photos->count())
                    <a href="#gallery">Galeri</a>
                @endif
                @if ($giftCount)
                    <a href="#gift">Amplop</a>
                @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="hero-soft">
                <div class="hero-soft-card">
                    <div class="leaf-line one">⌞</div>
                    <div class="leaf-line two">⌝</div>
                    <div class="leaf-line three">❧</div>

                    <div class="hero-soft-grid">
                        <div class="hero-soft-copy">
                            <div class="soft-badge">
                                <span></span>
                                {{ $invitation->event_name ?: 'Undangan Syukuran' }}
                            </div>

                            <h1 class="responsive-text soft-title soft-gradient-text hero-soft-title">
                                {{ $invitation->title ?: 'Syukuran Keluarga' }}
                            </h1>

                            <p class="responsive-text hero-soft-desc">
                                {{ $invitation->description ?: 'Mari berkumpul dalam rasa syukur, mempererat silaturahmi, dan berbagi kebahagiaan bersama keluarga tersayang.' }}
                            </p>

                            <div class="host-line">
                                <small>Diselenggarakan oleh</small>
                                <strong class="responsive-text">{{ $invitation->host_name ?: 'Keluarga Besar' }}</strong>
                            </div>

                            <div class="hero-actions">
                                <a href="#detail" class="soft-btn">Lihat Detail</a>
                                @if ($googleCalendarUrl)
                                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="soft-btn secondary">Atur Pengingat</a>
                                @else
                                    <a href="#message" class="soft-btn secondary">Kirim Ucapan</a>
                                @endif
                            </div>
                        </div>

                        <div class="hero-soft-visual">
                            <div class="soft-cover-frame">
                                @if ($invitation->cover_image)
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Syukuran">
                                @elseif ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Syukuran">
                                @else
                                    <div class="soft-cover-placeholder">
                                        <div>
                                            <div class="vase">
                                                <img src="{{ asset('assets/icons/Bunga.png') }}"
                                                    class="vase-img"
                                                    alt="Bunga">
                                            </div>
                                            <h2 class="responsive-text">Syukur & Doa</h2>
                                            <p class="responsive-text">Mari hadir dalam momen sederhana yang penuh rasa syukur, doa baik, dan kehangatan bersama keluarga.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hero-detail-strip">
                    <div class="strip-card">
                        <div class="strip-icon"><img src="{{ asset('assets/icons/Tanggal.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Tanggal"></div>
                        <small>Tanggal</small>
                        <strong class="soft-date-line">
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

                    <div class="strip-card">
                        <div class="strip-icon"><img src="{{ asset('assets/icons/Waktu.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Waktu"></div>
                        <small>Waktu</small>
                        <strong class="soft-time-line">
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

                    <div class="strip-card">
                        <div class="strip-icon"><img src="{{ asset('assets/icons/Lokasi.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Lokasi"></div>
                        <small>Lokasi</small>
                        <strong class="responsive-text">{{ $invitation->location_name ?: 'Lokasi Acara' }}</strong>
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="inline-flex mt-3 text-xs font-black" style="color: var(--soft-primary);">Buka Maps →</a>
                        @endif
                    </div>

                    <div class="strip-card">
                        <div class="strip-icon"><img src="{{ asset('assets/icons/Peta.png') }}"
                                class="w-10 h-10 object-contain"
                                alt="Peta"></div>
                        <small>Alamat</small>
                        <strong class="responsive-text">{{ $invitation->address ?: 'Alamat belum ditambahkan' }}</strong>
                    </div>
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="soft-section compact">
                <div class="section-head">
                    <p class="soft-label justify-center">Detail Acara</p>
                    <h2 class="soft-title text-5xl md:text-6xl mt-6">Jadwal & Lokasi</h2>
                    <p class="responsive-text desc">Simpan jadwal dan pastikan Anda hadir di waktu terbaik.</p>
                </div>

                <div class="detail-soft-grid">
                    <div class="soft-card">
                        <h3>Informasi Utama</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label">Acara</div>
                                <div class="value responsive-text">{{ $invitation->event_name ?: 'Syukuran' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value soft-date-line">
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
                                <div class="label">Waktu</div>
                                <div class="value soft-time-line">
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
                                <div class="label">Lokasi</div>
                                <div class="value responsive-text">{{ $invitation->location_name ?: 'Lokasi acara belum diatur' }}</div>
                            </div>

                            @if ($invitation->address)
                                <div class="detail-row">
                                    <div class="label">Alamat</div>
                                    <div class="value responsive-text">{{ $invitation->address }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="soft-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="soft-btn secondary">📍 Buka Maps</a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="soft-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>
                            <h3 class="mt-3">Menuju Hari Acara</h3>
                            <p class="text-slate-600 mt-3 leading-7">Semoga acara ini menjadi momen yang penuh rasa syukur dan kebahagiaan.</p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div>
                            </div>
                        </div>

                        @if ($invitation->address || $mapOpenUrl)
                            <div class="map-card">
                                @if ($mapEmbedUrl)
                                    <iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                @elseif ($mapOpenUrl)
                                    <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                            <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                            <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $softHighlights->count())
                <section id="about" class="soft-section compact">
                    <div class="section-head">
                        <p class="soft-label justify-center">Tentang Acara</p>

                        <h2 class="responsive-text soft-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Momen Syukur yang Lembut dan Berkesan' }}
                        </h2>

                        <p class="responsive-text desc">
                            {{ $invitation->host_name
                                ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen berbagi rasa syukur, doa, dan kebersamaan.'
                                : 'Acara ini menjadi ruang hangat untuk berkumpul, mempererat silaturahmi, dan berbagi kebahagiaan.'
                            }}
                        </p>
                    </div>

                    @php
                        $softCount = $softHighlights->count();

                        $softGridClass = match (true) {
                            $softCount === 1 => 'count-1',
                            $softCount === 2 => 'count-2',
                            default => 'count-3',
                        };
                    @endphp

                    @if ($softCount > 0)
                        <div class="soft-about-grid {{ $softGridClass }}">
                            @foreach ($softHighlights as $index => $highlight)
                                <div class="about-soft-card">
                                    <div class="about-soft-number">
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

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="soft-section compact">
                    <div class="section-head">
                        <p class="soft-label justify-center">Galeri Kenangan</p>
                        <h2 class="soft-title text-5xl md:text-6xl mt-6">Momen Kebersamaan</h2>
                    </div>

                    <div class="gallery-soft-wrap">
                        <div class="gallery-soft-grid">
                            @foreach ($photos->take(8) as $photo)
                                <div class="gallery-soft-item">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Syukuran">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="soft-section compact">
                    <div class="section-head">
                        <p class="soft-label justify-center">Amplop Digital</p>
                        <h2 class="soft-title text-5xl md:text-6xl mt-6">Kirim Doa & Dukungan</h2>
                        <p class="responsive-text desc">Jika berkenan, tamu dapat mengirimkan amplop digital melalui informasi berikut.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            <div class="gift-card">
                                <h3 class="responsive-text">{{ $gift->label ?: 'Amplop Digital' }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>
                                        <div class="gift-number responsive-text">{{ $gift->account_number ?: '-' }}</div>
                                    </div>

                                    @if ($gift->account_number)
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $gift->account_number }}">Salin Nomor</button>
                                    @endif
                                </div>

                                <p class="responsive-text font-bold mt-3">{{ $gift->account_name ?: 'Nama penerima belum diatur' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="soft-section compact">
                <div class="section-head">
                    <p class="soft-label justify-center">Buku Tamu</p>
                    <h2 class="soft-title text-5xl md:text-6xl mt-6">Kirim Ucapan</h2>
                    <p class="responsive-text desc">Konfirmasi kehadiran dan berikan ucapan terbaik untuk acara ini.</p>
                </div>

                <div class="rsvp-grid">
                    <div>
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
                                    <option value="hadir">Hadir</option>
                                    <option value="tidak_hadir">Tidak hadir</option>
                                    <option value="ragu">Masih ragu</option>
                                </select>
                            </div>

                            <div>
                                <label class="uk-label">Jumlah Tamu</label>
                                <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1">
                            </div>

                            <div>
                                <label class="uk-label">Ucapan / Doa</label>
                                <textarea name="message" rows="4" class="uk-input mt-1 uk-break-input" placeholder="Tulis ucapan dan doa terbaik..." required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="w-full soft-btn">Kirim Ucapan</button>
                        </form>
                    </div>

                    <div>
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

                        <div class="message-list mt-4">
                            @forelse ($invitation->messages as $message)
                                <div class="message-card">
                                    <div class="message-head">
                                        <div class="message-avatar">{{ strtoupper(\Illuminate\Support\Str::substr($message->guest_name ?: 'T', 0, 1)) }}</div>
                                        <div class="message-info">
                                            <p class="responsive-text font-black text-slate-950">{{ $message->guest_name }}</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                        </div>

                                        @if ($message->attendance_status)
                                            <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                        @endif
                                    </div>

                                    <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                                </div>
                            @empty
                                <div class="message-card text-center mt-4">
                                    <p class="text-slate-500">Belum ada ucapan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="soft-section text-center">
                <div class="closing-soft-card">
                    <p class="soft-label justify-center">Terima Kasih</p>
                    <h2 class="responsive-text soft-title soft-gradient-text text-5xl md:text-7xl mt-8">Sampai Jumpa</h2>
                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda. Semoga momen ini membawa kebahagiaan, keberkahan, dan mempererat silaturahmi.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">{{ $invitation->title }}</h3>
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

            const copyGiftButtons = document.querySelectorAll('.copy-gift-btn');

            copyGiftButtons.forEach(function (button) {
                button.addEventListener('click', async function () {
                    const textToCopy = button.dataset.copy || '';
                    if (!textToCopy) return;

                    try {
                        await navigator.clipboard.writeText(textToCopy);
                    } catch (error) {
                        const tempInput = document.createElement('input');
                        tempInput.value = textToCopy;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand('copy');
                        document.body.removeChild(tempInput);
                    }

                    const originalText = button.textContent;
                    button.textContent = 'Tersalin';
                    button.classList.add('copied');

                    setTimeout(function () {
                        button.textContent = originalText;
                        button.classList.remove('copied');
                    }, 1800);
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .soft-section > p,
                .soft-section > h1,
                .soft-section > h2,
                .soft-section > h3,
                .soft-label,
                .soft-title,
                .soft-gradient-text,
                .soft-nav,
                .hero-soft-card,
                .hero-soft-copy,
                .soft-badge,
                .hero-soft-title,
                .hero-soft-desc,
                .host-line,
                .hero-actions,
                .hero-soft-visual,
                .soft-cover-frame,
                .soft-cover-placeholder,
                .vase,
                .leaf-line,
                .hero-detail-strip,
                .strip-card,
                .strip-icon,
                .about-soft-card,
                .about-soft-number,
                .soft-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-soft-wrap,
                .gallery-soft-item,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-soft-card,
                .soft-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('soft-show');
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
