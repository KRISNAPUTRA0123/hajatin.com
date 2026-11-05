<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Aqiqah') . ' ' . ($invitation->title ?: 'Aqiqah Soft'));
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
        AQIQAH SOFT - HERO BARU
        Lebih kalem, beda dari baby blessing
        ===================================================== */

        .aqs-hero {
            min-height: 100vh;
            padding: 92px 64px;
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 44px;
            align-items: center;
        }

        .aqs-copy {
            max-width: 620px;
        }

        .aqs-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 12px 24px rgba(31, 41, 55, .05);
            color: var(--aq-primary, var(--simple-primary));
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .aqs-kicker::before {
            content: "";
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
            box-shadow: 0 0 0 6px color-mix(in srgb, var(--simple-primary) 12%, white);
        }

        .aqs-title {
            margin: 24px 0 0;
            font-size: clamp(3rem, 6vw, 5.4rem);
            line-height: .95;
            letter-spacing: -.06em;
            font-weight: 950;
            color: var(--simple-ink);
        }

        .aqs-title .soft-accent {
            display: block;
            color: color-mix(in srgb, var(--simple-primary) 82%, var(--simple-ink));
        }

        .aqs-desc {
            margin-top: 22px;
            max-width: 560px;
            color: #64776a;
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .aqs-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .aqs-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 10px 22px rgba(31, 41, 55, .05);
            color: #5d7265;
            font-size: 12px;
            font-weight: 900;
        }

        .aqs-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .aqs-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
            max-width: 560px;
        }

        .aqs-stat {
            position: relative;
            overflow: hidden;
            padding: 18px 18px 16px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(64, 84, 71, .08);
            border-radius: 24px;
            box-shadow: 0 12px 28px rgba(31, 41, 55, .05);
        }

        .aqs-stat::after {
            content: "";
            position: absolute;
            width: 72px;
            height: 72px;
            right: -18px;
            bottom: -18px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--simple-primary) 12%, white);
        }

        .aqs-stat strong {
            position: relative;
            z-index: 2;
            display: block;
            color: var(--simple-ink);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .aqs-stat span {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 10px;
            color: #7e9082;
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .aqs-stage {
            position: relative;
            min-height: 640px;
        }

        .aqs-back-panel {
            position: absolute;
            left: 24px;
            right: 34px;
            top: 48px;
            bottom: 18px;
            border-radius: 42px;
            background:
                linear-gradient(180deg, rgba(245,248,244,.96), rgba(236,243,238,.92));
            border: 1px solid rgba(64, 84, 71, .06);
            transform: rotate(-4deg);
            box-shadow: 0 28px 58px rgba(31, 41, 55, .06);
        }

        .aqs-main-panel {
            position: relative;
            z-index: 2;
            min-height: 610px;
            border-radius: 40px;
            padding: 26px;
            background:
                radial-gradient(circle at top right, rgba(220,232,223,.45), transparent 22%),
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(249,252,249,.98));
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 30px 60px rgba(31, 41, 55, .08);
            overflow: hidden;
        }

        .aqs-main-panel::before {
            content: "";
            position: absolute;
            inset: 16px;
            border-radius: 30px;
            border: 1.5px dashed rgba(146, 176, 152, .45);
            pointer-events: none;
        }

        .aqs-cover {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .08;
        }

        .aqs-flower {
            position: absolute;
            pointer-events: none;
            opacity: .12;
            z-index: 1;
        }

        .aqs-flower.top {
            width: 130px;
            top: 14px;
            right: 24px;
            transform: rotate(10deg);
        }

        .aqs-flower.bottom {
            width: 150px;
            left: 10px;
            bottom: 18px;
            transform: rotate(-10deg);
        }

        .aqs-panel-content {
            position: relative;
            z-index: 2;
            min-height: 560px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 20px;
        }

        .aqs-topline {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .aqs-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 10px 20px rgba(31, 41, 55, .04);
            color: var(--simple-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .aqs-dots {
            display: flex;
            gap: 6px;
            padding-top: 8px;
        }

        .aqs-dots span {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: rgba(64, 84, 71, .22);
        }

        .aqs-dots span:nth-child(1) { background: #b8cab8; }
        .aqs-dots span:nth-child(2) { background: #98b29c; }
        .aqs-dots span:nth-child(3) { background: #d8e6d8; }

        .aqs-feature-card {
            max-width: 360px;
            padding: 26px;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 18px 38px rgba(31, 41, 55, .06);
        }

        .aqs-feature-icon {
            width: 78px;
            height: 78px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(234,241,235,.92), rgba(255,255,255,.98));
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 12px 24px rgba(31, 41, 55, .04);
            margin-bottom: 18px;
        }

        .aqs-feature-icon img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .aqs-feature-card h3 {
            margin: 0;
            color: var(--simple-ink);
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.02;
            letter-spacing: -.04em;
            font-weight: 950;
        }

        .aqs-feature-card p {
            margin-top: 14px;
            color: #627568;
            line-height: 1.9;
        }

        .aqs-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .aqs-meta {
            padding: 16px 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 10px 22px rgba(31, 41, 55, .04);
        }

        .aqs-meta small {
            display: block;
            color: #87988a;
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .aqs-meta strong {
            display: block;
            margin-top: 8px;
            color: var(--simple-ink);
            font-size: 15px;
            line-height: 1.55;
            font-weight: 900;
        }

        .aqs-side-notes {
            margin-top: 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .aqs-note {
            border-radius: 24px;
            padding: 20px 22px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(64, 84, 71, .08);
            box-shadow: 0 12px 26px rgba(31, 41, 55, .05);
        }

        .aqs-note small {
            display: block;
            color: #819383;
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aqs-note p {
            margin-top: 10px;
            color: var(--simple-ink);
            font-weight: 900;
            line-height: 1.6;
        }

        .aqs-note.soft-tone {
            background:
                linear-gradient(180deg, rgba(246,249,246,.98), rgba(240,246,241,.98));
        }

        @media (max-width: 1100px) {
            .aqs-hero {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .aqs-copy {
                max-width: 100%;
                text-align: center;
            }

            .aqs-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .aqs-pill-row,
            .aqs-actions {
                justify-content: center;
            }

            .aqs-stats {
                margin-left: auto;
                margin-right: auto;
            }

            .aqs-stage {
                min-height: auto;
            }

            .aqs-back-panel {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .aqs-hero {
                padding: 74px 24px;
            }

            .aqs-title {
                font-size: clamp(2.5rem, 12vw, 4.1rem);
                line-height: 1.02;
            }

            .aqs-stats,
            .aqs-meta-grid,
            .aqs-side-notes {
                grid-template-columns: 1fr;
            }

            .aqs-main-panel {
                min-height: auto;
                padding: 20px;
                border-radius: 28px;
            }

            .aqs-panel-content {
                min-height: auto;
            }

            .aqs-feature-card {
                max-width: 100%;
                padding: 22px;
            }

            .aqs-feature-card h3 {
                font-size: 2.1rem;
            }

            .aqs-flower.top {
                width: 96px;
            }

            .aqs-flower.bottom {
                width: 108px;
            }
        }

        /* =====================================================
        AQIQAH SOFT HERO - LUXURY BOTANICAL REVISION
        Desain lebih mewah, soft, tidak monoton, dan responsif.
        ===================================================== */

        .aq-rev-hero {
            position: relative;
            min-height: 100vh;
            padding: 92px 64px 104px;
            display: grid;
            grid-template-columns: minmax(0, .98fr) minmax(420px, 1.02fr);
            gap: 54px;
            align-items: center;
            overflow: hidden;
        }

        .aq-rev-hero::before {
            content: "";
            position: absolute;
            left: -180px;
            bottom: -180px;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            background:
                radial-gradient(circle at 40% 35%, rgba(255,255,255,.86), transparent 36%),
                color-mix(in srgb, var(--aqiqah-primary) 10%, white);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            z-index: 0;
        }

        .aq-rev-hero::after {
            content: "";
            position: absolute;
            right: -120px;
            top: 8%;
            width: 330px;
            height: 330px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--aqiqah-accent) 48%, transparent);
            z-index: 0;
        }

        .aq-rev-left,
        .aq-rev-right {
            position: relative;
            z-index: 2;
        }

        .aq-rev-left {
            max-width: 660px;
        }

        .aq-rev-kicker {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 16%, transparent);
            box-shadow: 0 14px 28px rgba(30,41,59,.06);
            color: var(--aqiqah-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .aq-rev-kicker::before {
            content: "";
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: var(--aqiqah-primary);
            box-shadow: 0 0 0 6px color-mix(in srgb, var(--aqiqah-primary) 13%, white);
        }

        .aq-rev-title {
            margin: 30px 0 0;
            color: var(--aqiqah-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(3.2rem, 6.4vw, 6rem);
            line-height: .96;
            letter-spacing: -.055em;
            font-weight: 700;
        }

        .aq-rev-title span {
            display: block;
            color: color-mix(in srgb, var(--aqiqah-primary) 84%, var(--aqiqah-dark));
        }

        .aq-rev-ornament {
            width: min(100%, 470px);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 26px;
            color: color-mix(in srgb, var(--aqiqah-primary) 70%, #c9a86a);
        }

        .aq-rev-ornament::before,
        .aq-rev-ornament::after {
            content: "";
            height: 1px;
            flex: 1;
            background: currentColor;
            opacity: .45;
        }

        .aq-rev-ornament span {
            font-size: 18px;
            line-height: 1;
        }

        .aq-rev-desc {
            margin-top: 24px;
            max-width: 590px;
            color: var(--aqiqah-text);
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .aq-rev-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .aq-rev-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 13%, transparent);
            box-shadow: 0 10px 22px rgba(30,41,59,.05);
            color: var(--aqiqah-dark);
            font-size: 12px;
            font-weight: 900;
        }

        .aq-rev-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            align-items: center;
            margin-top: 32px;
        }

        .aq-rev-primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 15px 32px;
            border-radius: 999px;
            text-decoration: none;
            color: #ffffff;
            font-weight: 950;
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--aqiqah-primary) 92%, #ffffff),
                    color-mix(in srgb, var(--aqiqah-dark) 78%, var(--aqiqah-primary))
                );
            border: 1px solid rgba(255,255,255,.6);
            box-shadow:
                inset 0 0 0 2px rgba(255,255,255,.18),
                0 18px 38px color-mix(in srgb, var(--aqiqah-primary) 24%, transparent);
        }

        .aq-rev-link {
            display: inline-flex;
            align-items: center;
            color: var(--aqiqah-dark);
            font-weight: 900;
            text-decoration: none;
            border-bottom: 1px solid color-mix(in srgb, var(--aqiqah-primary) 48%, transparent);
            padding-bottom: 5px;
        }

        .aq-rev-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            max-width: 520px;
            margin-top: 48px;
            border-top: 1px solid color-mix(in srgb, var(--aqiqah-primary) 18%, transparent);
            border-bottom: 1px solid color-mix(in srgb, var(--aqiqah-primary) 18%, transparent);
        }

        .aq-rev-stat {
            text-align: center;
            padding: 22px 16px;
            position: relative;
        }

        .aq-rev-stat:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 22px;
            right: 0;
            width: 1px;
            height: calc(100% - 44px);
            background: color-mix(in srgb, var(--aqiqah-primary) 18%, transparent);
        }

        .aq-rev-stat .stat-icon {
            display: block;
            color: color-mix(in srgb, var(--aqiqah-primary) 80%, #c9a86a);
            font-size: 20px;
            line-height: 1;
            margin-bottom: 10px;
        }

        .aq-rev-stat strong {
            display: block;
            color: var(--aqiqah-dark);
            font-size: 2.1rem;
            line-height: 1;
            font-weight: 950;
        }

        .aq-rev-stat span {
            display: block;
            margin-top: 10px;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        /* RIGHT VISUAL */
        .aq-rev-right {
            min-height: 690px;
        }

        .aq-rev-visual {
            position: relative;
            min-height: 690px;
        }

        .aq-rev-arch-back {
            position: absolute;
            right: 28px;
            top: 0;
            width: 310px;
            height: 430px;
            border-radius: 160px 160px 48px 48px;
            background:
                radial-gradient(circle at 40% 30%, rgba(255,255,255,.58), transparent 38%),
                color-mix(in srgb, var(--aqiqah-primary) 11%, white);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 10%, transparent);
            box-shadow: 0 24px 50px rgba(30,41,59,.05);
        }

        .aq-rev-arch-main {
            position: absolute;
            top: 6px;
            left: 42px;
            width: 214px;
            min-height: 290px;
            border-radius: 120px 120px 44px 44px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), color-mix(in srgb, var(--aqiqah-soft) 90%, white));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 16%, transparent);
            box-shadow:
                inset 0 0 0 10px rgba(255,255,255,.38),
                0 24px 46px rgba(30,41,59,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        .aq-rev-arch-main::before {
            content: "✦";
            position: absolute;
            top: 24px;
            color: color-mix(in srgb, var(--aqiqah-primary) 55%, #c9a86a);
            font-size: 18px;
        }

        .aq-rev-lamb {
            width: 96px;
            height: 96px;
            object-fit: contain;
            opacity: .78;
            filter: drop-shadow(0 12px 16px rgba(30,41,59,.12));
        }

        .aq-rev-flower {
            position: absolute;
            z-index: 4;
            width: 172px;
            right: 0;
            top: 50px;
            opacity: .42;
            transform: rotate(8deg);
            pointer-events: none;
        }

        .aq-rev-leaf {
            position: absolute;
            z-index: 4;
            width: 120px;
            left: 16px;
            top: 196px;
            opacity: .58;
            transform: rotate(-14deg);
            pointer-events: none;
        }

        .aq-rev-quote-card {
            position: absolute;
            z-index: 5;
            right: 18px;
            top: 170px;
            width: min(100%, 420px);
            min-height: 330px;
            padding: 42px 38px 34px;
            border-radius: 44px 44px 44px 90px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,255,255,.94));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow:
                0 26px 60px rgba(30,41,59,.12),
                inset 0 0 0 1px rgba(255,255,255,.7);
            text-align: center;
        }

        .aq-rev-quote-mark {
            display: block;
            margin-bottom: 18px;
            color: color-mix(in srgb, var(--aqiqah-primary) 72%, #c9a86a);
            font-family: Georgia, serif;
            font-size: 4rem;
            line-height: .5;
        }

        .aq-rev-quote-card h2 {
            margin: 0 auto;
            max-width: 330px;
            color: var(--aqiqah-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2rem, 3.2vw, 3rem);
            line-height: 1.12;
            letter-spacing: -.035em;
            font-weight: 700;
        }

        .aq-rev-mini-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            max-width: 250px;
            margin: 24px auto 0;
            color: color-mix(in srgb, var(--aqiqah-primary) 55%, #c9a86a);
        }

        .aq-rev-mini-ornament::before,
        .aq-rev-mini-ornament::after {
            content: "";
            height: 1px;
            flex: 1;
            background: currentColor;
            opacity: .55;
        }

        .aq-rev-quote-card p {
            max-width: 320px;
            margin: 22px auto 0;
            color: var(--aqiqah-text);
            line-height: 1.75;
            font-size: .98rem;
        }

        .aq-rev-detail-panel {
            position: absolute;
            z-index: 4;
            right: 0;
            top: 475px;
            width: min(100%, 500px);
            padding: 26px 30px;
            border-radius: 42px;
            background:
                linear-gradient(180deg,
                    color-mix(in srgb, var(--aqiqah-primary) 14%, white),
                    color-mix(in srgb, var(--aqiqah-primary) 9%, white)
                );
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 14%, transparent);
            box-shadow: 0 24px 52px rgba(30,41,59,.10);
        }

        .aq-rev-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .aq-rev-detail-item {
            position: relative;
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 12px;
            align-items: center;
            padding: 18px 16px;
        }

        .aq-rev-detail-item:nth-child(1),
        .aq-rev-detail-item:nth-child(2) {
            border-bottom: 1px solid rgba(255,255,255,.76);
        }

        .aq-rev-detail-item:nth-child(1),
        .aq-rev-detail-item:nth-child(3) {
            border-right: 1px solid rgba(255,255,255,.76);
        }

        .aq-rev-detail-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.82);
            border: 1px solid rgba(255,255,255,.92);
            color: color-mix(in srgb, var(--aqiqah-primary) 72%, #c9a86a);
            box-shadow: 0 8px 16px rgba(30,41,59,.06);
        }

        .aq-rev-detail-item small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 10px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-rev-detail-item strong {
            display: block;
            margin-top: 6px;
            color: var(--aqiqah-dark);
            font-size: 14px;
            line-height: 1.45;
            font-weight: 950;
        }

        .aq-rev-footer-pill {
            position: absolute;
            z-index: 6;
            right: 34px;
            bottom: 0;
            width: min(100%, 520px);
            display: grid;
            grid-template-columns: 92px 1fr 1fr;
            gap: 18px;
            align-items: center;
            padding: 18px 22px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
            box-shadow: 0 24px 54px rgba(30,41,59,.10);
            backdrop-filter: blur(16px);
        }

        .aq-rev-emblem {
            width: 70px;
            height: 70px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at center, #ffffff, color-mix(in srgb, var(--aqiqah-accent) 50%, white));
            border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 14%, transparent);
            color: var(--aqiqah-primary);
            font-size: 28px;
        }

        .aq-rev-footer-text {
            min-width: 0;
        }

        .aq-rev-footer-text:not(:last-child) {
            border-right: 1px solid color-mix(in srgb, var(--aqiqah-primary) 14%, transparent);
            padding-right: 18px;
        }

        .aq-rev-footer-text small {
            display: block;
            color: var(--aqiqah-text);
            font-size: 9px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .aq-rev-footer-text strong,
        .aq-rev-footer-text span {
            display: block;
            margin-top: 7px;
            color: var(--aqiqah-dark);
            font-size: 14px;
            line-height: 1.45;
            font-weight: 900;
        }

        /* Decorative mobile-safe flowers */
        .aq-rev-side-flower {
            position: absolute;
            left: -26px;
            bottom: 44px;
            width: 170px;
            opacity: .34;
            z-index: 1;
            pointer-events: none;
        }

        @media (max-width: 1100px) {
            .aq-rev-hero {
                grid-template-columns: 1fr;
                gap: 48px;
            }

            .aq-rev-left {
                text-align: center;
                margin: 0 auto;
            }

            .aq-rev-kicker,
            .aq-rev-tags,
            .aq-rev-actions {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }

            .aq-rev-ornament,
            .aq-rev-desc,
            .aq-rev-stats {
                margin-left: auto;
                margin-right: auto;
            }

            .aq-rev-right,
            .aq-rev-visual {
                min-height: 700px;
            }
        }

        @media (max-width: 720px) {
            .aq-rev-hero {
                padding: 74px 22px 86px;
            }

            .aq-rev-title {
                font-size: clamp(2.7rem, 13vw, 4.1rem);
                line-height: 1;
            }

            .aq-rev-stats {
                grid-template-columns: 1fr;
                border: 0;
                gap: 12px;
            }

            .aq-rev-stat {
                border-radius: 24px;
                background: rgba(255,255,255,.88);
                border: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
                box-shadow: 0 12px 24px rgba(30,41,59,.05);
            }

            .aq-rev-stat:not(:last-child)::after {
                display: none;
            }

            .aq-rev-right,
            .aq-rev-visual {
                min-height: auto;
            }

            .aq-rev-arch-back,
            .aq-rev-arch-main,
            .aq-rev-quote-card,
            .aq-rev-detail-panel,
            .aq-rev-footer-pill {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: 100%;
            }

            .aq-rev-visual {
                display: grid;
                gap: 16px;
            }

            .aq-rev-arch-back {
                display: none;
            }

            .aq-rev-arch-main {
                min-height: 180px;
                border-radius: 90px 90px 34px 34px;
                margin: 0 auto;
                max-width: 220px;
            }

            .aq-rev-quote-card {
                border-radius: 34px;
                padding: 34px 24px 30px;
            }

            .aq-rev-detail-panel {
                padding: 18px;
                border-radius: 30px;
            }

            .aq-rev-detail-grid {
                grid-template-columns: 1fr;
            }

            .aq-rev-detail-item {
                border-right: 0 !important;
                border-bottom: 1px solid rgba(255,255,255,.76);
            }

            .aq-rev-detail-item:last-child {
                border-bottom: 0;
            }

            .aq-rev-footer-pill {
                grid-template-columns: 1fr;
                border-radius: 30px;
                text-align: center;
            }

            .aq-rev-emblem {
                margin: 0 auto;
            }

            .aq-rev-footer-text:not(:last-child) {
                border-right: 0;
                padding-right: 0;
                border-bottom: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent);
                padding-bottom: 14px;
            }

            .aq-rev-flower,
            .aq-rev-leaf,
            .aq-rev-side-flower {
                display: none;
            }
        }

        /* =====================================================
        FIX HERO AQIQAH SOFT FINAL
        Judul lebih kecil + sisi kanan tidak overlap
        ===================================================== */

        /* Kiri: kecilkan judul dan cegah kata pecah aneh */
        .aq-rev-left {
            max-width: 600px !important;
        }

        .aq-rev-title {
            font-size: clamp(2.55rem, 4.1vw, 4.25rem) !important;
            line-height: 1.04 !important;
            letter-spacing: -0.04em !important;
            max-width: 590px !important;
            word-break: normal !important;
            overflow-wrap: normal !important;
            hyphens: none !important;
        }

        .aq-rev-title span {
            margin-top: 2px;
        }

        /* Supaya layout kanan tidak saling tindih */
        .aq-rev-right {
            min-height: auto !important;
        }

        .aq-rev-visual {
            min-height: auto !important;
            display: grid !important;
            grid-template-columns: 150px minmax(0, 1fr) !important;
            grid-template-areas:
                "arch quote"
                "detail detail"
                "footer footer" !important;
            gap: 18px !important;
            align-items: stretch !important;
        }

        /* Matikan cover absolut di hero kanan agar tidak mengganggu layout */
        .aq-rev-visual > .aq-cover-photo {
            display: none !important;
        }

        /* Hiasan belakang cukup jadi dekorasi, tidak ikut menabrak */
        .aq-rev-arch-back {
            position: absolute !important;
            right: 18px !important;
            top: 16px !important;
            width: 260px !important;
            height: 340px !important;
            opacity: .5 !important;
            z-index: 0 !important;
            pointer-events: none !important;
        }

        /* Arch icon kambing dibuat ikut grid, bukan absolute penuh */
        .aq-rev-arch-main {
            grid-area: arch !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
            width: 150px !important;
            min-height: 250px !important;
            border-radius: 90px 90px 34px 34px !important;
            z-index: 3 !important;
            align-self: start !important;
        }

        /* Card doa jadi rapi di kanan */
        .aq-rev-quote-card {
            grid-area: quote !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
            width: 100% !important;
            min-height: auto !important;
            padding: 34px 32px 32px !important;
            border-radius: 38px 38px 38px 70px !important;
            z-index: 4 !important;
        }

        .aq-rev-quote-mark {
            margin-bottom: 12px !important;
            font-size: 3rem !important;
        }

        .aq-rev-quote-card h2 {
            font-size: clamp(1.85rem, 2.7vw, 2.55rem) !important;
            line-height: 1.16 !important;
            max-width: 330px !important;
        }

        .aq-rev-quote-card p {
            font-size: .94rem !important;
            margin-top: 18px !important;
        }

        /* Panel detail turun normal di bawah */
        .aq-rev-detail-panel {
            grid-area: detail !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
            width: 100% !important;
            padding: 20px !important;
            border-radius: 34px !important;
            z-index: 4 !important;
        }

        .aq-rev-detail-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .aq-rev-detail-item {
            grid-template-columns: 36px 1fr !important;
            gap: 10px !important;
            padding: 14px 12px !important;
            border-bottom: 0 !important;
            border-right: 1px solid rgba(255,255,255,.76) !important;
        }

        .aq-rev-detail-item:last-child {
            border-right: 0 !important;
        }

        .aq-rev-detail-icon {
            width: 34px !important;
            height: 34px !important;
            font-size: 13px !important;
        }

        .aq-rev-detail-item small {
            font-size: 9px !important;
        }

        .aq-rev-detail-item strong {
            font-size: 12px !important;
        }

        /* Footer pill tidak menutupi quote/detail */
        .aq-rev-footer-pill {
            grid-area: footer !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
            width: 100% !important;
            border-radius: 34px !important;
            z-index: 4 !important;
            grid-template-columns: 70px 1fr 1fr !important;
            padding: 16px 18px !important;
        }

        .aq-rev-emblem {
            width: 58px !important;
            height: 58px !important;
            font-size: 24px !important;
        }

        .aq-rev-footer-text small {
            font-size: 8px !important;
        }

        .aq-rev-footer-text strong,
        .aq-rev-footer-text span {
            font-size: 12px !important;
        }

        /* Hiasan bunga/daun dibuat lebih halus agar tidak menabrak konten */
        .aq-rev-flower {
            width: 120px !important;
            right: 18px !important;
            top: 12px !important;
            opacity: .26 !important;
        }

        .aq-rev-leaf {
            width: 88px !important;
            left: 96px !important;
            top: 190px !important;
            opacity: .34 !important;
        }

        .aq-rev-side-flower {
            width: 120px !important;
            left: -18px !important;
            bottom: 98px !important;
            opacity: .22 !important;
        }

        /* Tablet */
        @media (max-width: 1100px) {
            .aq-rev-title {
                max-width: 680px !important;
                margin-left: auto !important;
                margin-right: auto !important;
                font-size: clamp(2.8rem, 8vw, 4.4rem) !important;
                text-align: center !important;
            }

            .aq-rev-visual {
                grid-template-columns: 150px minmax(0, 1fr) !important;
                max-width: 720px !important;
                margin: 0 auto !important;
            }
        }

        /* Mobile */
        @media (max-width: 720px) {
            .aq-rev-title {
                font-size: clamp(2.25rem, 10vw, 3.35rem) !important;
                line-height: 1.05 !important;
                max-width: 100% !important;
            }

            .aq-rev-visual {
                grid-template-columns: 1fr !important;
                grid-template-areas:
                    "arch"
                    "quote"
                    "detail"
                    "footer" !important;
                gap: 16px !important;
            }

            .aq-rev-arch-main {
                width: 170px !important;
                min-height: 180px !important;
                margin: 0 auto !important;
            }

            .aq-rev-arch-back,
            .aq-rev-flower,
            .aq-rev-leaf,
            .aq-rev-side-flower {
                display: none !important;
            }

            .aq-rev-quote-card {
                border-radius: 32px !important;
                padding: 30px 24px !important;
            }

            .aq-rev-detail-grid {
                grid-template-columns: 1fr !important;
            }

            .aq-rev-detail-item {
                border-right: 0 !important;
                border-bottom: 1px solid rgba(255,255,255,.76) !important;
            }

            .aq-rev-detail-item:last-child {
                border-bottom: 0 !important;
            }

            .aq-rev-footer-pill {
                grid-template-columns: 1fr !important;
                text-align: center !important;
            }

            .aq-rev-emblem {
                margin: 0 auto !important;
            }

            .aq-rev-footer-text:not(:last-child) {
                border-right: 0 !important;
                padding-right: 0 !important;
                border-bottom: 1px solid color-mix(in srgb, var(--aqiqah-primary) 12%, transparent) !important;
                padding-bottom: 14px !important;
            }
        }

        /* =====================================================
        LUXURY AQIQAH SOFT ANIMATION
        Tempel paling bawah sebelum style
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
        .aq-hero,
        .aq-hero-left,
        .aq-kicker,
        .aq-hero-title,
        .aq-hero-desc,
        .aq-hero-tags span,
        .aq-hero-actions,
        .aq-strip-item,
        .aq-hero-right,
        .aq-paper-pass,
        .aq-paper-inner,
        .aq-pass-badge,
        .aq-pass-icon,
        .aq-note,
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
        .aq-btn,

        /* Hero revisi botanical */
        .aq-rev-hero,
        .aq-rev-left,
        .aq-rev-right,
        .aq-rev-kicker,
        .aq-rev-title,
        .aq-rev-ornament,
        .aq-rev-desc,
        .aq-rev-tag,
        .aq-rev-actions,
        .aq-rev-stat,
        .aq-rev-visual,
        .aq-rev-arch-back,
        .aq-rev-arch-main,
        .aq-rev-quote-card,
        .aq-rev-detail-panel,
        .aq-rev-detail-item,
        .aq-rev-footer-pill,
        .aq-rev-emblem,
        .aq-rev-primary-btn,
        .aq-rev-link {
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
            animation: aqNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero lama langsung hidup */
        #opening .aq-hero-left,
        #opening .aq-rev-left {
            animation: aqHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .aq-kicker,
        #opening .aq-rev-kicker {
            animation: aqFadeDown .85s ease .18s both;
        }

        #opening .aq-hero-title,
        #opening .aq-rev-title {
            animation: aqTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .aq-hero-desc,
        #opening .aq-rev-desc {
            animation: aqFadeUp .85s ease .48s both;
        }

        #opening .aq-hero-tags span,
        #opening .aq-rev-tag {
            animation: aqFadeUp .85s ease .58s both;
        }

        #opening .aq-hero-actions,
        #opening .aq-rev-actions {
            animation: aqFadeUp .85s ease .70s both;
        }

        #opening .aq-strip-item,
        #opening .aq-rev-stat {
            animation: aqFadeUp .9s ease .82s both;
        }

        #opening .aq-paper-pass,
        #opening .aq-rev-quote-card {
            animation:
                aqPanelEnter 1.12s cubic-bezier(.2, .8, .2, 1) .28s both,
                aqPanelFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .aq-rev-arch-main {
            animation:
                aqArchEnter 1s cubic-bezier(.2, .8, .2, 1) .38s both,
                aqArchFloat 5.2s ease-in-out 1.4s infinite;
        }

        #opening .aq-rev-detail-panel,
        #opening .aq-rev-footer-pill,
        #opening .aq-note {
            animation: aqFadeUp .9s ease .82s both;
        }

        /* Background dan ornamen halus */
        .aq-wrap {
            animation: aqWrapGlow 8s ease-in-out infinite alternate;
        }

        .aq-wrap::before {
            animation: aqPatternMove 18s linear infinite;
        }

        .aq-hero-left::before,
        .aq-paper-pass::before,
        .aq-paper-inner::before,
        .aq-paper-inner::after,
        .aq-strip-item::after,
        .aq-note::after,
        .aq-highlight-card::after,
        .baby-card::before,
        .closing-card::before,
        .closing-card::after,
        .aq-rev-hero::before,
        .aq-rev-hero::after,
        .aq-rev-arch-back,
        .aq-rev-detail-panel,
        .aq-rev-footer-pill {
            animation: aqDecorFloat 6.4s ease-in-out infinite;
        }

        /* Gambar ornamen botanical */
        .aq-rev-flower,
        .aq-rev-leaf,
        .aq-rev-side-flower,
        .aqs-flower {
            animation: aqFlowerFloat 6s ease-in-out infinite;
        }

        /* Label glow */
        .aq-label::before,
        .aq-kicker::before,
        .aq-rev-kicker::before,
        .aq-rev-ornament span,
        .aq-rev-mini-ornament span {
            animation: aqLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Dots kecil bergerak */
        .aq-pass-dots span,
        .aqs-dots span {
            animation: aqDotPulse 1.8s ease-in-out infinite;
        }

        .aq-pass-dots span:nth-child(2),
        .aqs-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        .aq-pass-dots span:nth-child(3),
        .aqs-dots span:nth-child(3) {
            animation-delay: .36s;
        }

        /* Tombol efek kilau */
        .aq-btn,
        button.aq-btn,
        .aq-rev-primary-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .aq-btn::after,
        button.aq-btn::after,
        .aq-rev-primary-btn::after,
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
            animation: aqButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .aq-strip-item:hover,
            .aq-paper-pass:hover,
            .aq-note:hover,
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
            .closing-card:hover,
            .aq-rev-quote-card:hover,
            .aq-rev-detail-panel:hover,
            .aq-rev-footer-pill:hover,
            .aq-rev-stat:hover,
            .aq-rev-arch-main:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--aqiqah-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--aqiqah-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--aqiqah-accent) 28%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .gallery-card:hover img,
            .baby-card:hover img,
            .aq-paper-pass:hover img,
            .aq-rev-quote-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .gallery-card img,
        .baby-photo,
        .aq-cover-photo,
        .aq-rev-lamb {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: aqNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon / angka pulse */
        .aq-highlight-number,
        .baby-placeholder,
        .aq-pass-icon,
        .aq-rev-emblem,
        .aq-rev-detail-icon,
        .gift-number,
        .message-badge {
            animation: aqSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: aqGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: aqGalleryTwo 4.8s ease-in-out .18s infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: aqGalleryThree 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: aqFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes aqNavEnter {
            from { opacity: 0; transform: translateY(-18px) scale(.96); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes aqHeroCopyIn {
            from { opacity: 0; transform: translateX(-24px) translateY(34px) scale(.96); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes aqPanelEnter {
            from { opacity: 0; transform: translateX(28px) translateY(36px) scale(.93) rotate(2deg); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes aqPanelFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.012); }
        }

        @keyframes aqArchEnter {
            from { opacity: 0; transform: translateY(28px) scale(.9); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes aqArchFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-7px) scale(1.018); }
        }

        @keyframes aqFadeDown {
            from { opacity: 0; transform: translateY(-20px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes aqFadeUp {
            from { opacity: 0; transform: translateY(26px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes aqTitleIn {
            from { opacity: 0; transform: translateY(38px) scale(.94); filter: blur(12px); letter-spacing: -.02em; }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes aqWrapGlow {
            from { box-shadow: 0 34px 90px rgba(30, 41, 59, .08); }
            to {
                box-shadow:
                    0 42px 118px rgba(30, 41, 59, .11),
                    0 0 58px color-mix(in srgb, var(--aqiqah-accent) 28%, transparent);
            }
        }

        @keyframes aqPatternMove {
            from { background-position: 0 0; }
            to { background-position: 120px 120px; }
        }

        @keyframes aqDecorFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.04); }
        }

        @keyframes aqFlowerFloat {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-10px) rotate(4deg) scale(1.04); }
        }

        @keyframes aqLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--aqiqah-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--aqiqah-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes aqDotPulse {
            0%, 100% { opacity: .42; transform: translateY(0); }
            50% { opacity: .95; transform: translateY(-2px); }
        }

        @keyframes aqButtonShine {
            0%, 48% { left: -80%; }
            75%, 100% { left: 130%; }
        }

        @keyframes aqNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--aqiqah-primary) 16%, transparent); }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--aqiqah-primary) 38%, transparent),
                    0 0 34px color-mix(in srgb, var(--aqiqah-accent) 48%, transparent);
            }
        }

        @keyframes aqSoftPulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-3px) scale(1.035); }
        }

        @keyframes aqGalleryOne {
            0%, 100% { transform: translateY(0) rotate(-.4deg); }
            50% { transform: translateY(-7px) rotate(-.9deg); }
        }

        @keyframes aqGalleryTwo {
            0%, 100% { transform: translateY(0) rotate(.4deg); }
            50% { transform: translateY(-6px) rotate(.9deg); }
        }

        @keyframes aqGalleryThree {
            0%, 100% { transform: translateY(0) rotate(.2deg); }
            50% { transform: translateY(-7px) rotate(.7deg); }
        }

        @keyframes aqFloatingButton {
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
            .aq-hero,
            .aq-hero-left,
            .aq-hero-right,
            .aq-paper-pass,
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
            .closing-card,
            .aq-btn,
            .aq-rev-hero,
            .aq-rev-left,
            .aq-rev-right,
            .aq-rev-quote-card,
            .aq-rev-detail-panel,
            .aq-rev-footer-pill,
            .aq-rev-stat {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .aq-paper-pass,
            #opening .aq-rev-quote-card {
                animation:
                    aqFadeUp .9s ease .3s both,
                    aqFloatingButton 5s ease-in-out 1.2s infinite;
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
            .aq-hero,
            .aq-hero-left,
            .aq-kicker,
            .aq-hero-title,
            .aq-hero-desc,
            .aq-hero-tags span,
            .aq-hero-actions,
            .aq-strip-item,
            .aq-hero-right,
            .aq-paper-pass,
            .aq-paper-inner,
            .aq-pass-badge,
            .aq-pass-icon,
            .aq-note,
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
            .aq-btn,
            .aq-rev-hero,
            .aq-rev-left,
            .aq-rev-right,
            .aq-rev-kicker,
            .aq-rev-title,
            .aq-rev-ornament,
            .aq-rev-desc,
            .aq-rev-tag,
            .aq-rev-actions,
            .aq-rev-stat,
            .aq-rev-visual,
            .aq-rev-arch-back,
            .aq-rev-arch-main,
            .aq-rev-quote-card,
            .aq-rev-detail-panel,
            .aq-rev-detail-item,
            .aq-rev-footer-pill,
            .aq-rev-emblem,
            .aq-rev-primary-btn,
            .aq-rev-link,
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

        /* FIX WAKTU AGAR 1 BARIS */
        .aq-rev-time-line {
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
            word-break: normal !important;
            overflow-wrap: normal !important;
            color: var(--aqiqah-dark);
            font-size: 13px;
            line-height: 1.35;
            font-weight: 950;
        }

        .aq-rev-time-line span {
            display: inline-block !important;
            white-space: nowrap !important;
        }

        /* Supaya isi kartu detail tidak terlalu sempit */
        .aq-rev-detail-item {
            grid-template-columns: 36px minmax(0, 1fr) !important;
        }

        /* Mobile tetap 1 baris, tapi font sedikit diperkecil */
        @media (max-width: 720px) {
            .aq-rev-time-line {
                justify-content: center !important;
                font-size: 12px !important;
                gap: 3px !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'emerald';

    $themes = [
        'maroon' => [
            'primary' => '#b46a7b',
            'secondary' => '#d8a0ad',
            'accent' => '#fbedf1',
            'dark' => '#5a3640',
            'text' => '#735c64',
            'soft' => '#fffafb',
            'glow1' => 'rgba(180, 106, 123, .08)',
            'glow2' => 'rgba(251, 237, 241, .78)',
        ],

        'emerald' => [
            'primary' => '#7f9f83',
            'secondary' => '#b7c9b2',
            'accent' => '#f1f7ef',
            'dark' => '#405447',
            'text' => '#66786b',
            'soft' => '#fcfffb',
            'glow1' => 'rgba(127, 159, 131, .08)',
            'glow2' => 'rgba(241, 247, 239, .82)',
        ],

        'navy' => [
            'primary' => '#7e95a8',
            'secondary' => '#bdcbd6',
            'accent' => '#f1f5f8',
            'dark' => '#40515f',
            'text' => '#667582',
            'soft' => '#fbfdff',
            'glow1' => 'rgba(126, 149, 168, .08)',
            'glow2' => 'rgba(241, 245, 248, .82)',
        ],

        'rose' => [
            'primary' => '#c79aa7',
            'secondary' => '#dec5cd',
            'accent' => '#fbf2f5',
            'dark' => '#5b4650',
            'text' => '#7b6670',
            'soft' => '#fffafb',
            'glow1' => 'rgba(199, 154, 167, .09)',
            'glow2' => 'rgba(251, 242, 245, .82)',
        ],

        'gold' => [
            'primary' => '#b79c74',
            'secondary' => '#d9c8a8',
            'accent' => '#fbf7ee',
            'dark' => '#5a4d39',
            'text' => '#776b5a',
            'soft' => '#fffdf8',
            'glow1' => 'rgba(183, 156, 116, .08)',
            'glow2' => 'rgba(251, 247, 238, .82)',
        ],

        'slate' => [
            'primary' => '#8a96a3',
            'secondary' => '#c4ccd4',
            'accent' => '#f4f6f8',
            'dark' => '#4a5561',
            'text' => '#6c747d',
            'soft' => '#ffffff',
            'glow1' => 'rgba(138, 150, 163, .07)',
            'glow2' => 'rgba(244, 246, 248, .82)',
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
            <section id="opening" class="aq-rev-hero">
                <div class="aq-rev-left">
                    <div class="aq-rev-kicker">
                        Aqiqah Soft
                    </div>

                    <h1 class="aq-rev-title responsive-text">
                        {{ $invitation->title ?: 'Tasyakuran Aqiqah' }}
                        <span>Penuh Syukur</span>
                    </h1>

                    <div class="aq-rev-ornament">
                        <span>❖</span>
                    </div>

                    <p class="aq-rev-desc responsive-text">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran aqiqah buah hati kami.' }}
                    </p>

                    <div class="aq-rev-tags">
                        <span class="aq-rev-tag">{{ $invitation->event_name ?: 'Aqiqah' }}</span>
                        <span class="aq-rev-tag">{{ $invitation->host_name ?: 'Keluarga Besar' }}</span>
                    </div>

                    <div class="aq-rev-actions">
                        <a href="#detail" class="aq-rev-primary-btn">
                            Lihat Detail <span>→</span>
                        </a>

                        <a href="#message" class="aq-rev-link">
                            Kirim Ucapan
                        </a>
                    </div>

                    <div class="aq-rev-stats">
                        <div class="aq-rev-stat">
                            <span class="stat-icon">♡</span>
                            <strong>{{ max($babyCount, 1) }}</strong>
                            <span>Buah Hati</span>
                        </div>

                        <div class="aq-rev-stat">
                            <span class="stat-icon">✿</span>
                            <strong>{{ $highlightCount }}</strong>
                            <span>Poin Acara</span>
                        </div>

                        <div class="aq-rev-stat">
                            <span class="stat-icon">▣</span>
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

                <div class="aq-rev-right">
                    <div class="aq-rev-visual">
                        <div class="aq-rev-arch-back"></div>

                        <div class="aq-rev-arch-main">
                            <img src="{{ asset('assets/icons/Kambing.png') }}" alt="Aqiqah" class="aq-rev-lamb">
                        </div>

                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Aqiqah" class="aq-cover-photo">
                        @elseif ($firstPhoto)
                            <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Aqiqah" class="aq-cover-photo">
                        @endif

                        <div class="aq-rev-quote-card">
                            <span class="aq-rev-quote-mark">“</span>

                            <h2 class="responsive-text">
                                {{ $invitation->seminar_about_title ?: 'Doa, Syukur, dan Kebahagiaan Keluarga' }}
                            </h2>

                            <div class="aq-rev-mini-ornament">
                                <span>❖</span>
                            </div>

                            <p class="responsive-text">
                                {{ $invitation->host_name
                                    ? 'Diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen syukur dan doa terbaik untuk buah hati tercinta.'
                                    : 'Momen penuh syukur untuk menyambut kehadiran buah hati dengan doa, kebahagiaan, dan kebersamaan keluarga.' }}
                            </p>
                        </div>

                        <div class="aq-rev-detail-panel">
                            <div class="aq-rev-detail-grid">
                                <div class="aq-rev-detail-item">
                                    <div class="aq-rev-detail-icon"><img src="{{ asset('assets/icons/Tanggal.png') }}" alt="tanggal" class="w-6 h-6"></div>
                                    <div>
                                        <small>Tanggal</small>
                                        <strong class="responsive-text">
                                            @if ($invitation->event_date)
                                                {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}
                                            @else
                                                Belum diatur
                                            @endif
                                        </strong>
                                    </div>
                                </div>

                                <div class="aq-rev-detail-item">
                                    <div class="aq-rev-detail-icon">
                                        <img src="{{ asset('assets/icons/Waktu.png') }}" alt="Waktu" class="w-6 h-6">
                                    </div>

                                    <div>
                                        <small class="mb-5">Waktu</small>

                                        <strong class="aq-rev-time-line">
                                            @if ($invitation->event_time)
                                                <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>

                                                @if ($invitation->event_end_time)
                                                    <span>-</span>
                                                    <span>{{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                                @endif
                                            @else
                                                <span>Belum diatur</span>
                                            @endif
                                        </strong>
                                    </div>
                                </div>

                                <div class="aq-rev-detail-item">
                                    <div class="aq-rev-detail-icon"><img src="{{ asset('assets/icons/Lokasi.png') }}" alt="Lokasi" class="w-6 h-6"></div>
                                    <div>
                                        <small>Lokasi</small>
                                        <strong class="responsive-text">
                                            {{ $invitation->location_name ?: 'Kediaman Keluarga' }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="aq-rev-footer-pill">
                            <div class="aq-rev-emblem">
                                ❧
                            </div>

                            <div class="aq-rev-footer-text">
                                <small>Diselenggarakan Oleh</small>
                                <strong class="responsive-text">
                                    {{ $invitation->host_name ?: 'Keluarga Besar' }}
                                </strong>
                            </div>

                            <div class="aq-rev-footer-text">
                                <small>Harapan</small>
                                <span class="responsive-text">
                                    Semoga menjadi anak yang sehat, sholeh/sholehah, dan penuh keberkahan.
                                </span>
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

                            <div class="detail-row">
                                <div class="label">Lokasi</div>
                                <div class="value responsive-text">
                                    {{ $invitation->location_name ?: 'Lokasi Acara' }}
                                </div>
                            </div>

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
                        {{ $invitation->title ?: 'Aqiqah & Tasyakuran' }}
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
            | Luxury Scroll Reveal - Aqiqah Soft
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
                .aq-hero,
                .aq-hero-left,
                .aq-kicker,
                .aq-hero-title,
                .aq-hero-desc,
                .aq-hero-tags span,
                .aq-hero-actions,
                .aq-strip-item,
                .aq-hero-right,
                .aq-paper-pass,
                .aq-paper-inner,
                .aq-pass-badge,
                .aq-pass-icon,
                .aq-note,
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
                .aq-btn,

                .aq-rev-hero,
                .aq-rev-left,
                .aq-rev-right,
                .aq-rev-kicker,
                .aq-rev-title,
                .aq-rev-ornament,
                .aq-rev-desc,
                .aq-rev-tag,
                .aq-rev-actions,
                .aq-rev-stat,
                .aq-rev-visual,
                .aq-rev-arch-back,
                .aq-rev-arch-main,
                .aq-rev-quote-card,
                .aq-rev-detail-panel,
                .aq-rev-detail-item,
                .aq-rev-footer-pill,
                .aq-rev-emblem,
                .aq-rev-primary-btn,
                .aq-rev-link
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
