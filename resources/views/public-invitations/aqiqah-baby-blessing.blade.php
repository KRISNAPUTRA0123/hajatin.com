<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Aqiqah') . ' ' . ($invitation->title ?: 'Baby Blessing'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--aqiqah-dark);
            background:
                radial-gradient(circle at 8% 0%, var(--aqiqah-glow-1), transparent 30%),
                radial-gradient(circle at 94% 6%, var(--aqiqah-glow-2), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, var(--aqiqah-soft) 48%, #ffffff 100%);
        }

        .aq-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .aq-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 44px;
            background:
                radial-gradient(circle at 12% 12%, color-mix(in srgb, var(--aqiqah-primary) 8%, transparent), transparent 30%),
                radial-gradient(circle at 90% 10%, color-mix(in srgb, var(--aqiqah-accent) 42%, transparent), transparent 32%),
                linear-gradient(180deg, rgba(255,255,255,.985), rgba(255,255,255,.96));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 34px 90px rgba(30, 41, 59, .08);
        }

        .aq-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .22;
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--aqiqah-primary) 10%, transparent) 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }

        .aq-wrap > * {
            position: relative;
            z-index: 1;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .aq-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .aq-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .aq-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 28px);
            margin: 18px auto 0;
            padding: 8px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 14px 34px rgba(30, 41, 59, .08);
        }

        .aq-nav a {
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--aqiqah-text);
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .aq-nav a:hover {
            color: var(--aqiqah-primary);
            background: color-mix(in srgb, var(--aqiqah-primary) 8%, white);
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
            box-shadow: 0 14px 30px rgba(30, 41, 59, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--aqiqah-accent) 40%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .aq-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--aqiqah-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .aq-label::before {
            content: "";
            width: 40px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
        }

        .aq-title {
            color: var(--aqiqah-dark);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .aq-gradient-text {
            background: linear-gradient(135deg, var(--aqiqah-dark), var(--aqiqah-primary), var(--aqiqah-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .aq-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--aqiqah-primary) 20%, transparent);
        }

        .aq-btn.secondary {
            color: var(--aqiqah-dark);
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 14px 28px rgba(30, 41, 59, .07);
        }

        /* HERO */
        .aq-hero {
            min-height: auto;
            padding: 86px 64px 96px;
            display: grid;
            grid-template-columns: .88fr 1.12fr;
            gap: 44px;
            align-items: center;
        }

        .aq-hero-left {
            position: relative;
            min-width: 0;
        }

        .aq-hero-left::before {
            content: "";
            position: absolute;
            left: -36px;
            top: 24px;
            width: 150px;
            height: 126px;
            border-radius: 42px;
            background: color-mix(in srgb, var(--aqiqah-accent) 36%, transparent);
            transform: rotate(-9deg);
            z-index: -1;
        }

        .aq-kicker {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 999px;
            color: var(--aqiqah-primary);
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 12px 26px rgba(30, 41, 59, .06);
            font-size: 12px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-kicker::before {
            content: "✦";
            width: 28px;
            height: 28px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            letter-spacing: 0;
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
        }

        .aq-hero-title {
            font-size: clamp(2.4rem, 5.2vw, 4.8rem);
            line-height: 1;
            letter-spacing: -0.045em;
            max-width: 680px;
        }

        .aq-hero-desc {
            margin-top: 24px;
            max-width: 610px;
            color: var(--aqiqah-text);
            line-height: 1.9;
            font-size: 1.05rem;
        }

        .aq-hero-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .aq-hero-tags span {
            padding: 10px 14px;
            border-radius: 16px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 10px 22px rgba(30, 41, 59, .055);
            color: var(--aqiqah-text);
            font-size: 12px;
            font-weight: 900;
        }

        .aq-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 34px;
        }

        .aq-hero-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 620px;
            margin-top: 38px;
        }

        .aq-strip-item {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 14px 30px rgba(30, 41, 59, .065);
        }

        .aq-strip-item::after {
            content: "";
            position: absolute;
            right: -28px;
            bottom: -38px;
            width: 92px;
            height: 92px;
            border-radius: 24px;
            background: color-mix(in srgb, var(--aqiqah-accent) 34%, transparent);
            transform: rotate(14deg);
        }

        .aq-strip-item strong,
        .aq-strip-item span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .aq-strip-item strong {
            color: var(--aqiqah-dark);
            font-size: 1.7rem;
            line-height: 1;
            font-weight: 950;
        }

        .aq-strip-item span {
            margin-top: 9px;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-hero-right {
            position: relative;
            min-height: 640px;
        }

        .aq-paper-pass {
            position: relative;
            min-height: 570px;
            padding: 20px;
            border-radius: 42px;
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--aqiqah-primary) 14%, white),
                color-mix(in srgb, var(--aqiqah-accent) 35%, white));
            box-shadow: 0 28px 70px rgba(30, 41, 59, .12);
            transform: rotate(1.4deg);
        }

        .aq-paper-pass::before {
            content: "";
            position: absolute;
            left: 36px;
            top: -22px;
            width: 190px;
            height: 54px;
            border-radius: 18px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(30,41,59,.06);
            box-shadow: 0 14px 26px rgba(30,41,59,.08);
            transform: rotate(-3deg);
        }

        .aq-paper-inner {
            position: relative;
            min-height: 530px;
            overflow: hidden;
            border-radius: 32px;
            padding: 34px;
            background:
                radial-gradient(circle at 18% 18%, color-mix(in srgb, var(--aqiqah-accent) 28%, transparent), transparent 32%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--aqiqah-soft) 90%, white));
            border: 2px dashed color-mix(in srgb, var(--aqiqah-primary) 16%, transparent);
            transform: rotate(-1.4deg);
        }

        .aq-paper-inner::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 130px;
            right: -64px;
            top: 62px;
            border-radius: 38px;
            background: color-mix(in srgb, var(--aqiqah-accent) 24%, transparent);
            transform: rotate(-12deg);
        }

        .aq-paper-inner::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 118px;
            left: -58px;
            bottom: 36px;
            border-radius: 34px;
            background: color-mix(in srgb, var(--aqiqah-secondary) 9%, transparent);
            transform: rotate(10deg);
        }

        .aq-cover-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .16;
        }

        .aq-pass-content {
            position: relative;
            z-index: 2;
            min-height: 458px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .aq-pass-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .aq-pass-badge {
            display: inline-flex;
            padding: 9px 13px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            color: var(--aqiqah-primary);
            font-size: 11px;
            font-weight: 950;
        }

        .aq-pass-dots {
            display: flex;
            gap: 7px;
        }

        .aq-pass-dots span {
            width: 10px;
            height: 10px;
            border-radius: 4px;
            background: var(--aqiqah-primary);
        }

        .aq-pass-dots span:nth-child(2) { background: var(--aqiqah-accent); }
        .aq-pass-dots span:nth-child(3) { background: var(--aqiqah-secondary); }

        .aq-pass-main {
            margin-top: 48px;
        }

        .aq-pass-icon {
            width: 76px;
            height: 76px;
            margin-bottom: 22px;
            border-radius: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 12px 26px rgba(30, 41, 59, .07);
            font-size: 32px;
        }

        .aq-pass-main h2 {
            max-width: 390px;
            color: var(--aqiqah-dark);
            font-size: clamp(2.3rem, 4.5vw, 3.9rem);
            line-height: .98;
            letter-spacing: -.058em;
            font-weight: 950;
        }

        .aq-pass-main p {
            max-width: 390px;
            margin-top: 18px;
            color: var(--aqiqah-text);
            line-height: 1.85;
        }

        .aq-pass-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 28px;
        }

        .aq-pass-info-item {
            padding: 15px;
            border-radius: 20px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 10px 22px rgba(30,41,59,.055);
        }

        .aq-pass-info-item small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 9px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-pass-info-item strong {
            display: block;
            margin-top: 7px;
            color: var(--aqiqah-dark);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 950;
        }

        .aq-note-row {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 14px;
            margin-top: 18px;
        }

        .aq-note {
            position: relative;
            overflow: hidden;
            padding: 18px 20px;
            border-radius: 26px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 16px 34px rgba(30, 41, 59, .075);
        }

        .aq-note::after {
            content: "";
            position: absolute;
            right: -24px;
            top: -28px;
            width: 92px;
            height: 92px;
            border-radius: 24px;
            background: color-mix(in srgb, var(--aqiqah-accent) 28%, transparent);
            transform: rotate(12deg);
        }

        .aq-note small,
        .aq-note p {
            position: relative;
            z-index: 2;
        }

        .aq-note small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-note p {
            margin-top: 8px;
            color: var(--aqiqah-dark);
            font-weight: 950;
            line-height: 1.5;
        }

        .aq-note.accent {
            background: linear-gradient(180deg, color-mix(in srgb, var(--aqiqah-accent) 30%, white), rgba(255,255,255,.96));
        }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--aqiqah-text);
            line-height: 1.8;
        }

        .aq-grid {
            display: grid;
            gap: 20px;
            margin-top: 38px;
            justify-content: center;
        }

        .aq-grid.count-1 { grid-template-columns: minmax(280px, 460px); }
        .aq-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .aq-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .aq-highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 230px;
            padding: 28px;
            border-radius: 34px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(30, 41, 59, .07);
        }

        .aq-highlight-card::after {
            content: "";
            position: absolute;
            width: 138px;
            height: 138px;
            right: -44px;
            bottom: -44px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-accent) 26%, transparent);
        }

        .aq-highlight-number {
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
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
            margin-bottom: 18px;
        }

        .aq-highlight-card h3,
        .aq-highlight-card p {
            position: relative;
            z-index: 2;
        }

        .aq-highlight-card h3 {
            color: var(--aqiqah-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .aq-highlight-card p {
            margin-top: 10px;
            color: var(--aqiqah-text);
            line-height: 1.8;
        }

        .baby-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 38px;
        }

        .baby-card {
            position: relative;
            overflow: hidden;
            padding: 24px;
            border-radius: 34px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(30, 41, 59, .07);
        }

        .baby-card::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            right: -46px;
            top: -46px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-accent) 30%, transparent);
        }

        .baby-photo,
        .baby-placeholder {
            position: relative;
            z-index: 2;
            width: 118px;
            height: 118px;
            border-radius: 32px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--aqiqah-soft) 90%, white));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 12px 28px rgba(30, 41, 59, .07);
            font-size: 42px;
            font-weight: 950;
            color: var(--aqiqah-primary);
        }

        .baby-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-primary) 10%, white);
            color: var(--aqiqah-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .baby-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--aqiqah-dark);
            font-size: 1.7rem;
            font-weight: 950;
        }

        .baby-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--aqiqah-text);
            line-height: 1.7;
        }

        .focus-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .aq-card {
            padding: 30px;
            border-radius: 36px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(30, 41, 59, .07);
        }

        .aq-card h3 {
            margin: 0;
            color: var(--aqiqah-dark);
            font-size: 2rem;
            font-weight: 950;
        }

        .detail-list { display: grid; gap: 14px; margin-top: 24px; }

        .detail-row {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--aqiqah-primary) 16%, transparent);
        }

        .detail-row .label {
            color: var(--aqiqah-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--aqiqah-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .aq-date-line,
        .aq-time-line {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            line-height: 1.5;
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
            background: linear-gradient(180deg, color-mix(in srgb, var(--aqiqah-soft) 90%, white), white);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--aqiqah-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--aqiqah-text);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 24px;
            overflow: hidden;
            border-radius: 34px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(30, 41, 59, .07);
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
            text-align: center;
            padding: 32px;
            color: var(--aqiqah-dark);
            text-decoration: none;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--aqiqah-soft) 90%, white));
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr 1.1fr;
            gap: 18px;
            margin-top: 38px;
            align-items: stretch;
        }

        .gallery-column { display: grid; gap: 18px; }

        .gallery-card {
            padding: 10px;
            overflow: hidden;
            border-radius: 28px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(30, 41, 59, .07);
        }

        .gallery-card.tall img { height: 340px; }
        .gallery-card.short img { height: 220px; }

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
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(30, 41, 59, .07);
        }

        .gift-card h3 {
            color: var(--aqiqah-dark);
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
            background: color-mix(in srgb, var(--aqiqah-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--aqiqah-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--aqiqah-primary);
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
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
        }

        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        .rsvp-wrap {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            border-radius: 30px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 16px 34px rgba(30, 41, 59, .07);
        }

        .form-card { padding: 28px; }

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
            color: var(--aqiqah-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--aqiqah-text);
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

        .message-info { min-width: 0; flex: 1; }

        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-primary) 10%, white);
            color: var(--aqiqah-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            position: relative;
            overflow: hidden;
            max-width: 840px;
            margin: 0 auto;
            padding: 46px 34px;
            text-align: center;
            border-radius: 40px;
            background: linear-gradient(135deg, color-mix(in srgb, var(--aqiqah-primary) 10%, white), color-mix(in srgb, var(--aqiqah-accent) 26%, white));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 20px 44px rgba(30, 41, 59, .07);
        }

        .closing-card::before,
        .closing-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 999px;
            background: rgba(255,255,255,.38);
        }

        .closing-card::before { left: -42px; top: -42px; }
        .closing-card::after { right: -42px; bottom: -42px; }

        @media (max-width: 1100px) {
            .aq-hero,
            .focus-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .aq-hero-left {
                text-align: center;
            }

            .aq-kicker,
            .aq-hero-actions,
            .aq-hero-tags {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }

            .aq-hero-title,
            .aq-hero-desc,
            .aq-hero-strip {
                margin-left: auto;
                margin-right: auto;
            }

            .aq-hero-right {
                min-height: auto;
            }

            .aq-paper-pass,
            .aq-paper-inner { transform: none; }

            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .aq-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        }

        @media (max-width: 980px) {
            .aq-shell { padding: 16px; }
            .aq-section { padding: 82px 38px; }
            .aq-hero { padding: 82px 38px 90px; }
            .summary-grid,
            .countdown-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .aq-shell { padding: 0; }
            .aq-wrap { border-radius: 0; box-shadow: none; }
            .aq-section { padding: 72px 22px; }
            .aq-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .aq-hero { padding: 72px 22px 82px; }

            .aq-hero-title {
                font-size: clamp(2.55rem, 12vw, 3.9rem);
                line-height: 1;
                letter-spacing: -.045em;
            }

            .aq-hero-strip,
            .aq-note-row,
            .aq-pass-info,
            .summary-grid,
            .countdown-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .aq-grid,
            .aq-grid.count-1,
            .aq-grid.count-2,
            .aq-grid.count-3,
            .gallery-column {
                grid-template-columns: 1fr;
            }

            .aq-paper-pass {
                padding: 14px;
                border-radius: 32px;
            }

            .aq-paper-pass::before { display: none; }

            .aq-paper-inner {
                min-height: auto;
                padding: 24px;
                border-radius: 26px;
            }

            .aq-pass-content { min-height: auto; }
            .aq-pass-main { margin-top: 38px; }
            .aq-pass-main h2 { font-size: clamp(2rem, 10vw, 3rem); max-width: 100%; }
            .aq-pass-main p { max-width: 100%; }

            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .floating-actions { right: 10px; }
        }


        /* =====================================================
           BABY BLESSING HERO - LUXURY EDITORIAL
           Hero baru untuk aqiqah-baby-blessing. Tidak menambah form,
           hanya memakai field yang sudah tersedia di template aqiqah.
        ===================================================== */
        .bb-hero {
            position: relative;
            min-height: auto;
            padding: 88px 64px 98px;
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(430px, 1.05fr);
            gap: 52px;
            align-items: center;
        }

        .bb-hero::before {
            content: "";
            position: absolute;
            left: 42px;
            top: 74px;
            width: 210px;
            height: 210px;
            border-radius: 42px;
            background: color-mix(in srgb, var(--aqiqah-accent) 58%, white);
            opacity: .72;
            transform: rotate(-12deg);
            z-index: 0;
        }

        .bb-hero::after {
            content: "";
            position: absolute;
            right: 76px;
            bottom: 52px;
            width: 260px;
            height: 150px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            filter: blur(.2px);
            z-index: 0;
        }

        .bb-copy,
        .bb-visual {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .bb-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 16px 32px rgba(30, 41, 59, .07);
            color: var(--aqiqah-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .bb-kicker span {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0;
            color: white;
            background: linear-gradient(135deg, var(--aqiqah-primary), var(--aqiqah-secondary));
        }

        .bb-title {
            margin-top: 28px;
            max-width: 660px;
            font-size: clamp(2.8rem, 5.3vw, 5.05rem);
            line-height: .98;
            letter-spacing: -.055em;
        }

        .bb-desc {
            max-width: 590px;
            margin-top: 24px;
            color: var(--aqiqah-text);
            font-size: 1.05rem;
            line-height: 1.95;
        }

        .bb-host-line {
            margin-top: 28px;
            padding: 17px 0 17px 22px;
            border-left: 3px solid color-mix(in srgb, var(--aqiqah-primary) 28%, transparent);
        }

        .bb-host-line small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .bb-host-line strong {
            display: block;
            margin-top: 6px;
            color: var(--aqiqah-dark);
            font-size: 1.18rem;
            font-weight: 950;
            line-height: 1.5;
        }

        .bb-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .bb-mini-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 36px;
            max-width: 610px;
        }

        .bb-mini-stat {
            position: relative;
            overflow: hidden;
            padding: 16px 18px;
            border-radius: 24px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 14px 30px rgba(30, 41, 59, .065);
        }

        .bb-mini-stat::after {
            content: "";
            position: absolute;
            right: -26px;
            bottom: -34px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-accent) 46%, white);
        }

        .bb-mini-stat strong,
        .bb-mini-stat span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .bb-mini-stat strong {
            color: var(--aqiqah-dark);
            font-size: 1.8rem;
            line-height: 1;
            font-weight: 950;
        }

        .bb-mini-stat span {
            margin-top: 8px;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-visual {
            min-height: 700px;
        }

        .bb-arch-stage {
            position: relative;
            min-height: 620px;
        }

        .bb-arch-back {
            position: absolute;
            inset: 42px 24px 34px 74px;
            border-radius: 180px 180px 46px 46px;
            background: linear-gradient(180deg,
                color-mix(in srgb, var(--aqiqah-accent) 58%, white),
                rgba(255,255,255,.92)
            );
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            transform: rotate(4deg);
            box-shadow: 0 30px 70px rgba(30, 41, 59, .08);
        }

        .bb-arch-card {
            position: relative;
            z-index: 2;
            width: min(100%, 500px);
            min-height: 590px;
            margin-left: auto;
            padding: 28px;
            border-radius: 190px 190px 46px 46px;
            background: rgba(255,255,255,.98);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 34px 80px rgba(30, 41, 59, .12);
            overflow: hidden;
        }

        .bb-arch-card::before {
            content: "";
            position: absolute;
            inset: 16px;
            border-radius: 174px 174px 34px 34px;
            border: 2px dashed color-mix(in srgb, var(--aqiqah-primary) 16%, transparent);
            pointer-events: none;
            z-index: 2;
        }

        .bb-arch-card::after {
            content: "";
            position: absolute;
            right: -70px;
            top: 82px;
            width: 220px;
            height: 220px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-accent) 50%, transparent);
            z-index: 0;
        }

        .bb-cover-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .14;
            z-index: 0;
        }

        .bb-card-content {
            position: relative;
            z-index: 3;
            min-height: 534px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 42px 22px 10px;
        }

        .bb-top-mark {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bb-baby-mark {
            width: 92px;
            height: 92px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            background:
                radial-gradient(circle at 36% 24%, #ffffff, color-mix(in srgb, var(--aqiqah-accent) 50%, white));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 18px 38px rgba(30, 41, 59, .09);
        }

        .bb-card-main {
            text-align: center;
            margin: 30px auto 0;
            max-width: 360px;
        }

        .bb-card-main small {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            color: var(--aqiqah-primary);
            background: color-mix(in srgb, var(--aqiqah-accent) 38%, white);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-card-main h2 {
            margin-top: 18px;
            color: var(--aqiqah-dark);
            font-size: clamp(2.3rem, 4.4vw, 3.75rem);
            line-height: .98;
            letter-spacing: -.058em;
            font-weight: 950;
        }

        .bb-card-main p {
            margin-top: 18px;
            color: var(--aqiqah-text);
            line-height: 1.85;
        }

        .bb-info-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 32px;
        }

        .bb-info-pill {
            min-width: 0;
            padding: 13px 12px;
            border-radius: 20px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 10px 22px rgba(30, 41, 59, .055);
            text-align: center;
        }

        .bb-info-pill small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 9px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-info-pill strong {
            display: block;
            margin-top: 7px;
            color: var(--aqiqah-dark);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 950;
        }

        .bb-date-medallion {
            position: absolute;
            z-index: 5;
            left: 0;
            top: 92px;
            width: 146px;
            min-height: 188px;
            padding: 22px 18px;
            border-radius: 999px 999px 34px 34px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 22px 48px rgba(30, 41, 59, .11);
            text-align: center;
        }

        .bb-date-medallion b {
            display: block;
            color: var(--aqiqah-dark);
            font-size: 3rem;
            line-height: 1;
            font-weight: 950;
        }

        .bb-date-medallion span {
            display: block;
            margin-top: 8px;
            color: var(--aqiqah-primary);
            font-size: 11px;
            letter-spacing: .20em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-date-medallion small {
            display: block;
            margin-top: 36px;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            margin-left: auto;
            margin-right: auto;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-floating-host {
            position: absolute;
            z-index: 6;
            right: 0;
            bottom: 70px;
            width: min(78%, 310px);
            padding: 18px 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 20px 44px rgba(30, 41, 59, .12);
        }

        .bb-floating-host small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .bb-floating-host strong {
            display: block;
            margin-top: 8px;
            color: var(--aqiqah-dark);
            font-size: 1.1rem;
            line-height: 1.5;
            font-weight: 950;
        }

        .bb-blessing-ribbon {
            position: absolute;
            z-index: 5;
            left: 74px;
            bottom: 4px;
            width: min(78%, 390px);
            padding: 17px 20px;
            border-radius: 999px;
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--aqiqah-accent) 42%, white),
                rgba(255,255,255,.96)
            );
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 20px 44px rgba(30, 41, 59, .08);
            color: var(--aqiqah-dark);
            font-weight: 950;
            line-height: 1.55;
        }

        .bb-sparkle {
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: var(--aqiqah-primary);
            opacity: .72;
            z-index: 4;
        }

        .bb-sparkle.one { right: 54px; top: 72px; }
        .bb-sparkle.two { left: 120px; bottom: 236px; width: 12px; height: 12px; background: var(--aqiqah-secondary); }
        .bb-sparkle.three { right: 170px; bottom: 32px; width: 10px; height: 10px; background: var(--aqiqah-accent); }

        @media (max-width: 1100px) {
            .bb-hero {
                grid-template-columns: 1fr;
                gap: 36px;
            }

            .bb-copy {
                text-align: center;
            }

            .bb-kicker,
            .bb-action-row {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }

            .bb-title,
            .bb-desc,
            .bb-mini-row {
                margin-left: auto;
                margin-right: auto;
            }

            .bb-host-line {
                max-width: 560px;
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }

            .bb-visual {
                min-height: auto;
            }

            .bb-arch-stage {
                min-height: auto;
                display: grid;
                gap: 16px;
            }

            .bb-arch-back,
            .bb-sparkle {
                display: none;
            }

            .bb-arch-card,
            .bb-date-medallion,
            .bb-floating-host,
            .bb-blessing-ribbon {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: 100%;
                margin: 0;
            }

            .bb-date-medallion {
                min-height: auto;
                border-radius: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 14px;
            }

            .bb-date-medallion small {
                writing-mode: horizontal-tb;
                margin: 0;
            }

            .bb-arch-card {
                border-radius: 42px;
            }

            .bb-arch-card::before {
                border-radius: 30px;
            }

            .bb-card-content {
                min-height: auto;
            }

            .bb-blessing-ribbon {
                border-radius: 28px;
            }
        }

        @media (max-width: 640px) {
            .bb-hero {
                padding: 72px 22px 82px;
            }

            .bb-title {
                font-size: clamp(2.4rem, 11.5vw, 3.7rem);
                line-height: 1.02;
            }

            .bb-mini-row,
            .bb-info-row {
                grid-template-columns: 1fr;
            }

            .bb-arch-card {
                padding: 18px;
                border-radius: 32px;
            }

            .bb-arch-card::before {
                inset: 12px;
                border-radius: 24px;
            }

            .bb-card-content {
                padding: 30px 16px 8px;
            }

            .bb-card-main h2 {
                font-size: clamp(2rem, 10vw, 3rem);
            }

            .bb-date-medallion {
                flex-wrap: wrap;
                text-align: center;
            }
        }

        /* =====================================================
        LUXURY BABY BLESSING ANIMATION
        ===================================================== */

        .aq-reveal,
        .aq-section > p,
        .aq-section > h1,
        .aq-section > h2,
        .aq-section > h3,
        .aq-label,
        .aq-title,
        .aq-gradient-text,
        .aq-nav,
        .aq-btn,

        /* Hero Baby Blessing */
        .bb-hero,
        .bb-copy,
        .bb-kicker,
        .bb-title,
        .bb-desc,
        .bb-host-line,
        .bb-action-row,
        .bb-mini-stat,
        .bb-visual,
        .bb-arch-stage,
        .bb-arch-back,
        .bb-arch-card,
        .bb-card-content,
        .bb-baby-mark,
        .bb-card-main,
        .bb-info-pill,
        .bb-date-medallion,
        .bb-floating-host,
        .bb-blessing-ribbon,
        .bb-sparkle,

        /* Section content */
        .aq-highlight-card,
        .aq-highlight-number,
        .baby-card,
        .baby-photo,
        .baby-placeholder,
        .baby-role,
        .aq-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card {
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

        .aq-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .aq-nav {
            animation: bbNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .bb-copy {
            animation: bbHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .bb-kicker {
            animation: bbFadeDown .85s ease .18s both;
        }

        #opening .bb-title {
            animation: bbTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .bb-desc {
            animation: bbFadeUp .85s ease .48s both;
        }

        #opening .bb-host-line {
            animation: bbFadeUp .85s ease .58s both;
        }

        #opening .bb-action-row {
            animation: bbFadeUp .85s ease .70s both;
        }

        #opening .bb-mini-stat {
            animation: bbFadeUp .9s ease .82s both;
        }

        #opening .bb-arch-card {
            animation:
                bbArchCardEnter 1.12s cubic-bezier(.2, .8, .2, 1) .28s both,
                bbArchCardFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .bb-date-medallion {
            animation:
                bbMedallionEnter .95s cubic-bezier(.2, .8, .2, 1) .62s both,
                bbMedallionFloat 4.8s ease-in-out 1.5s infinite;
        }

        #opening .bb-floating-host {
            animation:
                bbFloatingIn .95s cubic-bezier(.2, .8, .2, 1) .78s both,
                bbFloatingMove 5s ease-in-out 1.6s infinite;
        }

        #opening .bb-blessing-ribbon {
            animation: bbFadeUp .95s ease .9s both;
        }

        /* Background dan ornamen hidup */
        .aq-wrap {
            animation: bbWrapGlow 8s ease-in-out infinite alternate;
        }

        .aq-wrap::before {
            animation: bbPatternMove 18s linear infinite;
        }

        .bb-hero::before,
        .bb-hero::after,
        .bb-arch-back,
        .bb-arch-card::after,
        .bb-mini-stat::after,
        .aq-highlight-card::after,
        .baby-card::before,
        .gift-card::after,
        .closing-card::before,
        .closing-card::after {
            animation: bbDecorFloat 6.4s ease-in-out infinite;
        }

        /* Sparkle hero */
        .bb-sparkle.one {
            animation: bbSparkleOne 4.6s ease-in-out infinite;
        }

        .bb-sparkle.two {
            animation: bbSparkleTwo 5s ease-in-out .2s infinite;
        }

        .bb-sparkle.three {
            animation: bbSparkleThree 5.3s ease-in-out .35s infinite;
        }

        /* Label glow */
        .aq-label::before,
        .bb-kicker span,
        .bb-baby-mark {
            animation: bbLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .aq-btn,
        button.aq-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .aq-btn::after,
        button.aq-btn::after,
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
            animation: bbButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .bb-mini-stat:hover,
            .bb-arch-card:hover,
            .bb-date-medallion:hover,
            .bb-floating-host:hover,
            .bb-blessing-ribbon:hover,
            .aq-highlight-card:hover,
            .baby-card:hover,
            .aq-card:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--aqiqah-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--aqiqah-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--aqiqah-accent) 28%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .bb-arch-card:hover img,
            .gallery-card:hover img,
            .baby-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .bb-cover-photo,
        .gallery-card img,
        .baby-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: bbNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon / angka pulse */
        .aq-highlight-number,
        .baby-placeholder,
        .bb-baby-mark,
        .gift-number,
        .message-badge {
            animation: bbSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: bbGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: bbGalleryTwo 4.8s ease-in-out .18s infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: bbGalleryThree 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: bbFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes bbNavEnter {
            from { opacity: 0; transform: translateY(-18px) scale(.96); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes bbHeroCopyIn {
            from { opacity: 0; transform: translateX(-24px) translateY(34px) scale(.96); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes bbArchCardEnter {
            from { opacity: 0; transform: translateX(30px) translateY(36px) scale(.92) rotate(3deg); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes bbArchCardFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.012); }
        }

        @keyframes bbMedallionEnter {
            from { opacity: 0; transform: translateY(30px) scale(.86) rotate(-6deg); filter: blur(9px); }
            to { opacity: 1; transform: translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes bbMedallionFloat {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-8px) rotate(-1.5deg); }
        }

        @keyframes bbFloatingIn {
            from { opacity: 0; transform: translateY(24px) scale(.9); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes bbFloatingMove {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        @keyframes bbFadeDown {
            from { opacity: 0; transform: translateY(-20px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes bbFadeUp {
            from { opacity: 0; transform: translateY(26px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes bbTitleIn {
            from { opacity: 0; transform: translateY(38px) scale(.94); filter: blur(12px); letter-spacing: -.02em; }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes bbWrapGlow {
            from { box-shadow: 0 34px 90px rgba(30, 41, 59, .08); }
            to {
                box-shadow:
                    0 42px 118px rgba(30, 41, 59, .11),
                    0 0 58px color-mix(in srgb, var(--aqiqah-accent) 28%, transparent);
            }
        }

        @keyframes bbPatternMove {
            from { background-position: 0 0; }
            to { background-position: 120px 120px; }
        }

        @keyframes bbDecorFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.04); }
        }

        @keyframes bbSparkleOne {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-13px) rotate(12deg) scale(1.15); }
        }

        @keyframes bbSparkleTwo {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-10px) rotate(-10deg) scale(1.12); }
        }

        @keyframes bbSparkleThree {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-12px) rotate(8deg) scale(1.14); }
        }

        @keyframes bbLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--aqiqah-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--aqiqah-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes bbButtonShine {
            0%, 48% { left: -80%; }
            75%, 100% { left: 130%; }
        }

        @keyframes bbNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--aqiqah-primary) 16%, transparent); }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--aqiqah-primary) 38%, transparent),
                    0 0 34px color-mix(in srgb, var(--aqiqah-accent) 48%, transparent);
            }
        }

        @keyframes bbSoftPulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-3px) scale(1.035); }
        }

        @keyframes bbGalleryOne {
            0%, 100% { transform: translateY(0) rotate(-.4deg); }
            50% { transform: translateY(-7px) rotate(-.9deg); }
        }

        @keyframes bbGalleryTwo {
            0%, 100% { transform: translateY(0) rotate(.4deg); }
            50% { transform: translateY(-6px) rotate(.9deg); }
        }

        @keyframes bbGalleryThree {
            0%, 100% { transform: translateY(0) rotate(.2deg); }
            50% { transform: translateY(-7px) rotate(.7deg); }
        }

        @keyframes bbFloatingButton {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .aq-reveal,
            .aq-section > p,
            .aq-section > h1,
            .aq-section > h2,
            .aq-section > h3,
            .aq-label,
            .aq-title,
            .aq-gradient-text,
            .aq-nav,
            .aq-btn,
            .bb-hero,
            .bb-copy,
            .bb-kicker,
            .bb-title,
            .bb-desc,
            .bb-host-line,
            .bb-action-row,
            .bb-mini-stat,
            .bb-visual,
            .bb-arch-card,
            .bb-date-medallion,
            .bb-floating-host,
            .bb-blessing-ribbon,
            .aq-highlight-card,
            .baby-card,
            .aq-card,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .bb-arch-card {
                animation:
                    bbFadeUp .9s ease .3s both,
                    bbFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .aq-reveal,
            .aq-section > p,
            .aq-section > h1,
            .aq-section > h2,
            .aq-section > h3,
            .aq-label,
            .aq-title,
            .aq-gradient-text,
            .aq-nav,
            .aq-btn,
            .bb-hero,
            .bb-copy,
            .bb-kicker,
            .bb-title,
            .bb-desc,
            .bb-host-line,
            .bb-action-row,
            .bb-mini-stat,
            .bb-visual,
            .bb-arch-stage,
            .bb-arch-back,
            .bb-arch-card,
            .bb-card-content,
            .bb-baby-mark,
            .bb-card-main,
            .bb-info-pill,
            .bb-date-medallion,
            .bb-floating-host,
            .bb-blessing-ribbon,
            .bb-sparkle,
            .aq-highlight-card,
            .aq-highlight-number,
            .baby-card,
            .baby-photo,
            .baby-placeholder,
            .baby-role,
            .aq-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .aq-wrap,
            .aq-wrap::before,
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
    $themeColor = $invitation->theme_color ?? 'emerald';

    $themes = [
        'maroon' => [
            'primary' => '#9f1239',
            'secondary' => '#be3455',
            'accent' => '#fde2e9',
            'dark' => '#4a1623',
            'text' => '#6b4450',
            'soft' => '#fff8fa',
            'glow1' => 'rgba(244, 63, 94, .10)',
            'glow2' => 'rgba(253, 226, 233, .72)',
        ],

        'emerald' => [
            'primary' => '#2f855a',
            'secondary' => '#68a67d',
            'accent' => '#e4f6eb',
            'dark' => '#163d2c',
            'text' => '#557266',
            'soft' => '#fbfffd',
            'glow1' => 'rgba(47, 133, 90, .09)',
            'glow2' => 'rgba(228, 246, 235, .74)',
        ],

        'navy' => [
            'primary' => '#3b6ea8',
            'secondary' => '#7aa6d8',
            'accent' => '#e9f3ff',
            'dark' => '#17263d',
            'text' => '#5a6a7d',
            'soft' => '#fbfdff',
            'glow1' => 'rgba(59, 110, 168, .08)',
            'glow2' => 'rgba(233, 243, 255, .78)',
        ],

        'rose' => [
            'primary' => '#d16d8b',
            'secondary' => '#e99caf',
            'accent' => '#fff0f5',
            'dark' => '#5a2c3c',
            'text' => '#755d66',
            'soft' => '#fffafb',
            'glow1' => 'rgba(209, 109, 139, .10)',
            'glow2' => 'rgba(255, 240, 245, .82)',
        ],

        'gold' => [
            'primary' => '#b88930',
            'secondary' => '#d8ad5a',
            'accent' => '#fff4d7',
            'dark' => '#4c3818',
            'text' => '#74634d',
            'soft' => '#fffdf7',
            'glow1' => 'rgba(184, 137, 48, .09)',
            'glow2' => 'rgba(255, 244, 215, .78)',
        ],

        'slate' => [
            'primary' => '#64748b',
            'secondary' => '#94a3b8',
            'accent' => '#f1f5f9',
            'dark' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#ffffff',
            'glow1' => 'rgba(100, 116, 139, .07)',
            'glow2' => 'rgba(241, 245, 249, .78)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];

    $firstPhoto = $invitation->photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Aqiqah';
    $eventName = $invitation->event_name ?: 'Aqiqah';
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
        "Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
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
        "Wassalamu'alaikum Wr. Wb.";

    $shareText = urlencode($shareMessage);

    // Template Aqiqah hanya mendukung acara offline.
    // Variabel ini dipertahankan agar kode lama tetap aman jika masih ada pengecekan lama.
    $eventMode = 'offline';
    $isOnlineEvent = false;
    $onlineUrl = '';

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

            $calendarTitle = trim(($invitation->event_name ?: 'Aqiqah') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan aqiqah') . "\n\nLink Undangan: " . $shareUrl);

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

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

    $babies = $invitation->people ?? collect();
    $babyCount = $babies->count();
    $photos = $invitation->photos->values();
    $giftCount = $invitation->gifts->count();

    $aqiqahHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $aqiqahHighlights->count();

    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --aqiqah-primary: {{ $activeTheme['primary'] }};
        --aqiqah-secondary: {{ $activeTheme['secondary'] }};
        --aqiqah-accent: {{ $activeTheme['accent'] }};
        --aqiqah-dark: {{ $activeTheme['dark'] }};
        --aqiqah-text: {{ $activeTheme['text'] }};
        --aqiqah-soft: {{ $activeTheme['soft'] }};
        --aqiqah-glow-1: {{ $activeTheme['glow1'] }};
        --aqiqah-glow-2: {{ $activeTheme['glow2'] }};

        --simple-primary: {{ $activeTheme['primary'] }};
        --simple-secondary: {{ $activeTheme['secondary'] }};
        --simple-accent: {{ $activeTheme['accent'] }};
        --simple-ink: {{ $activeTheme['dark'] }};
    "
>
    <main class="aq-shell">
        <div class="aq-wrap">

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

            <nav class="aq-nav">
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
            <section id="opening" class="bb-hero">
                <div class="bb-copy">
                    <div class="bb-kicker"><span>✦</span> Baby Blessing</div>

                    <h1 class="responsive-text aq-title aq-gradient-text bb-title">
                        {{ $invitation->title ?: 'Baby Blessing Aqiqah' }}
                    </h1>

                    <p class="responsive-text bb-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan kasih, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen aqiqah buah hati kami.' }}
                    </p>

                    <div class="bb-host-line">
                        <small>Diselenggarakan oleh</small>
                        <strong class="responsive-text">{{ $invitation->host_name ?: 'Keluarga Besar' }}</strong>
                    </div>

                    <div class="bb-action-row">
                        <a href="#detail" class="aq-btn">Lihat Detail</a>
                        <a href="#message" class="aq-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="bb-mini-row">
                        <div class="bb-mini-stat">
                            <strong>{{ max($babyCount, 1) }}</strong>
                            <span>Buah Hati</span>
                        </div>

                        <div class="bb-mini-stat">
                            <strong>{{ $highlightCount }}</strong>
                            <span>Poin Acara</span>
                        </div>

                        <div class="bb-mini-stat">
                            <strong>
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}
                                @else
                                    --
                                @endif
                            </strong>
                            <span>Tanggal</span>
                        </div>
                    </div>
                </div>

                <div class="bb-visual">
                    <div class="bb-arch-stage">
                        <div class="bb-arch-back"></div>
                        <span class="bb-sparkle one"></span>
                        <span class="bb-sparkle two"></span>
                        <span class="bb-sparkle three"></span>

                        <div class="bb-date-medallion">
                            <b>
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}
                                @else
                                    --
                                @endif
                            </b>
                            <span>
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('M Y') }}
                                @else
                                    Tanggal
                                @endif
                            </span>
                            <small>Baby Blessing</small>
                        </div>

                        <div class="bb-arch-card">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Baby Blessing" class="bb-cover-photo">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Baby Blessing" class="bb-cover-photo">
                            @endif

                            <div class="bb-card-content">
                                <div class="bb-top-mark">
                                    <div class="bb-baby-mark"><img src="{{ asset('assets/icons/rose.png') }}" alt="Bunga" class="w-10 h-10"></div>
                                </div>

                                <div class="bb-card-main">
                                    <small>{{ $invitation->event_name ?: 'Aqiqah' }}</small>

                                    <h2 class="responsive-text">
                                        {{ $invitation->seminar_about_title ?: 'Doa Terbaik untuk Buah Hati' }}
                                    </h2>

                                    <p class="responsive-text">
                                        {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Momen penuh syukur untuk menyambut hadirnya buah hati dengan doa, kasih, dan kebahagiaan keluarga.' }}
                                    </p>
                                </div>

                                <div class="bb-info-row">
                                    <div class="bb-info-pill">
                                        <small class="mb-6">Waktu</small>
                                        <strong class="aq-time-line">
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

                                    <div class="bb-info-pill">
                                        <small>Lokasi</small>
                                        <strong class="responsive-text">
                                            {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            @if ($invitation->seminar_about_title || $invitation->host_name || $highlightCount)
                <section id="about" class="aq-section compact">
                    <div class="section-head">
                        <p class="aq-label justify-center">Tentang Acara</p>

                        <h2 class="responsive-text aq-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Momen Aqiqah yang Lembut dan Bermakna' }}
                        </h2>

                        <p class="responsive-text desc">
                            {{ $invitation->host_name ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' sebagai bentuk rasa syukur, doa, dan kebahagiaan atas kehadiran buah hati.' : 'Acara ini menjadi momen untuk berkumpul, bersyukur, dan menyampaikan doa terbaik untuk buah hati.' }}
                        </p>
                    </div>

                    @if ($highlightCount)
                        <div class="aq-grid {{ $highlightGridClass }}">
                            @foreach ($aqiqahHighlights as $index => $highlight)
                                <div class="aq-highlight-card">
                                    <div class="aq-highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

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

            {{-- BABY / PEOPLE --}}
            @if ($babyCount)
                <section id="baby" class="aq-section compact text-center">
                    <p class="aq-label justify-center">Buah Hati</p>
                    <h2 class="aq-title text-5xl md:text-6xl mt-6">Ananda yang Berbahagia</h2>
                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-7">Data ini memakai bagian tokoh utama / people yang sudah tersedia pada editor.</p>

                    <div class="baby-grid">
                        @foreach ($babies as $person)
                            <div class="baby-card text-left">
                                @if ($person->photo)
                                    <img src="{{ asset('storage/' . $person->photo) }}" class="baby-photo" alt="{{ $person->name }}">
                                @else
                                    <div class="baby-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'A', 0, 1)) }}</div>
                                @endif

                                <span class="baby-role">{{ $person->subtitle ?: 'Buah Hati' }}</span>
                                <h3 class="responsive-text">{{ $person->name ?: 'Nama Buah Hati' }}</h3>

                                @if (!empty($person->description))
                                    <p class="responsive-text">{{ $person->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="aq-section compact">
                <div class="section-head">
                    <p class="aq-label justify-center">Detail Acara</p>
                    <h2 class="aq-title text-5xl md:text-6xl mt-6">Jadwal & Lokasi</h2>
                    <p class="responsive-text desc">Simpan jadwal acara dan lihat lokasi agar dapat hadir tepat waktu.</p>
                </div>

                <div class="focus-layout">
                    <div class="aq-card">
                        <h3>Informasi Utama</h3>

                        <div class="detail-list">
                            <div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $invitation->event_name ?: 'Aqiqah' }}</div></div>

                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value aq-date-line">
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
                                <div class="value aq-time-line">
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

                            <div class="detail-row"><div class="label">Lokasi</div><div class="value responsive-text">{{ $invitation->location_name ?: 'Lokasi Acara' }}</div></div>

                            @if ($invitation->address)
                                <div class="detail-row"><div class="label">Alamat</div><div class="value responsive-text">{{ $invitation->address }}</div></div>
                            @endif
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="aq-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="aq-btn secondary">📍 Buka Maps</a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="aq-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Menuju Hari Aqiqah</h3>
                            <p class="text-slate-600 mt-3 leading-7">Semoga acara ini menjadi momen penuh doa, kebahagiaan, dan keberkahan.</p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div>
                            </div>
                        </div>

                        @if ($invitation->address || $mapOpenUrl || $mapEmbedUrl)
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
                                            <p class="responsive-text mt-4 font-bold" style="color: var(--aqiqah-primary);">
                                                Buka Google Maps →
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
                                                {{ $invitation->address ?: 'Alamat lengkap belum ditambahkan.' }}
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
                <section id="gallery" class="aq-section compact">
                    <div class="section-head">
                        <p class="aq-label justify-center">Galeri</p>
                        <h2 class="aq-title text-5xl md:text-6xl mt-6">Momen Keluarga</h2>
                    </div>

                    <div class="gallery-grid">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'short' : 'tall' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(4, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah"></div>
                            @endforeach
                        </div>
                    </div>

                    @if ($photos->count() > 6)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                            @foreach ($photos->slice(6) as $photo)
                                <div class="gallery-card short"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah"></div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="aq-section compact">
                    <div class="section-head">
                        <p class="aq-label justify-center">Amplop Digital</p>
                        <h2 class="aq-title text-5xl md:text-6xl mt-6">Kirim Tanda Kasih</h2>
                        <p class="responsive-text desc">Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
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
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $gift->account_number }}">Salin</button>
                                    @endif
                                </div>

                                <p class="responsive-text font-bold mt-3">{{ $gift->account_name ?: 'Nama penerima belum diatur' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="aq-section compact">
                <div class="section-head">
                    <p class="aq-label justify-center">Ucapan & RSVP</p>
                    <h2 class="aq-title text-5xl md:text-6xl mt-6">Kirim Kehadiran & Ucapan</h2>
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

                        <button type="submit" class="w-full aq-btn">Kirim Ucapan</button>
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
                            <div class="message-card text-center"><p class="text-slate-500">Belum ada ucapan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="aq-section text-center">
                <div class="closing-card">
                    <p class="aq-label justify-center">Terima Kasih</p>
                    <h2 class="responsive-text aq-title aq-gradient-text text-5xl md:text-7xl mt-8">Jazakumullahu Khairan</h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda. Semoga acara aqiqah ini membawa keberkahan dan kebahagiaan bagi keluarga kami.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
                        {{ $invitation->title ?: 'Baby Blessing Aqiqah' }}
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

            document.querySelectorAll('[data-copy]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const text = this.getAttribute('data-copy');
                    const original = this.textContent;

                    try {
                        await navigator.clipboard.writeText(text);
                        this.textContent = 'Tersalin';
                        this.classList.add('copied');
                        setTimeout(() => {
                            this.textContent = original;
                            this.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        alert('Gagal menyalin teks.');
                    }
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal - Baby Blessing
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .aq-section > p,
                .aq-section > h1,
                .aq-section > h2,
                .aq-section > h3,
                .aq-label,
                .aq-title,
                .aq-gradient-text,
                .aq-nav,
                .aq-btn,

                .bb-hero,
                .bb-copy,
                .bb-kicker,
                .bb-title,
                .bb-desc,
                .bb-host-line,
                .bb-action-row,
                .bb-mini-stat,
                .bb-visual,
                .bb-arch-stage,
                .bb-arch-back,
                .bb-arch-card,
                .bb-card-content,
                .bb-baby-mark,
                .bb-card-main,
                .bb-info-pill,
                .bb-date-medallion,
                .bb-floating-host,
                .bb-blessing-ribbon,
                .bb-sparkle,

                .aq-highlight-card,
                .aq-highlight-number,
                .baby-card,
                .baby-photo,
                .baby-placeholder,
                .baby-role,
                .aq-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('aq-show');
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
