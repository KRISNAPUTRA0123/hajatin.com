<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Aqiqah') . ' ' . ($invitation->title ?: 'Little Prince'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--prince-dark);
            background:
                radial-gradient(circle at 8% 4%, var(--prince-glow-1), transparent 30%),
                radial-gradient(circle at 92% 0%, var(--prince-glow-2), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, var(--prince-soft) 46%, #ffffff 100%);
        }

        .prince-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .prince-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 46px;
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--prince-accent) 46%, transparent), transparent 30%),
                radial-gradient(circle at 88% 14%, color-mix(in srgb, var(--prince-primary) 10%, transparent), transparent 32%),
                linear-gradient(180deg, rgba(255,255,255,.99), rgba(255,255,255,.96));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 34px 90px rgba(15, 23, 42, .08);
        }

        .prince-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .20;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--prince-primary) 9%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--prince-primary) 9%, transparent) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .prince-wrap > * {
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

        .prince-section {
            min-height: 100vh;
            padding: 90px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .prince-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .prince-nav {
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
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
        }

        .prince-nav a {
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--prince-text);
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .prince-nav a:hover {
            color: var(--prince-primary);
            background: color-mix(in srgb, var(--prince-primary) 8%, white);
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
            box-shadow: 0 14px 30px rgba(15, 23, 42, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--prince-accent) 42%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .prince-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--prince-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .prince-label::before,
        .prince-label::after {
            content: "";
            width: 36px;
            height: 1px;
            background: color-mix(in srgb, var(--prince-primary) 36%, transparent);
        }

        .prince-title {
            color: var(--prince-dark);
            line-height: .96;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .prince-gradient-text {
            background: linear-gradient(135deg, var(--prince-dark), var(--prince-primary), var(--prince-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .prince-btn {
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
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--prince-primary) 20%, transparent);
        }

        .prince-btn.secondary {
            color: var(--prince-dark);
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 14px 28px rgba(15, 23, 42, .07);
        }

        /* HERO - LITTLE PRINCE UNIQUE */
        .lp-hero {
            position: relative;
            min-height: auto;
            padding: 86px 64px 100px;
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(420px, 1.1fr);
            gap: 56px;
            align-items: center;
        }

        .lp-hero::before {
            content: "";
            position: absolute;
            left: 48%;
            top: 54%;
            width: 520px;
            height: 520px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--prince-accent) 42%, transparent), transparent 68%);
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        .lp-copy,
        .lp-visual {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .lp-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 16px 32px rgba(15, 23, 42, .07);
            color: var(--prince-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .lp-kicker span {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0;
            color: white;
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
        }

        .lp-title {
            margin-top: 30px;
            max-width: 660px;
            font-size: clamp(3rem, 5.6vw, 5.25rem);
            line-height: .96;
            letter-spacing: -.058em;
            font-weight: 950;
        }

        .lp-title .line-soft {
            display: block;
            color: color-mix(in srgb, var(--prince-primary) 78%, var(--prince-dark));
        }

        .lp-desc {
            max-width: 590px;
            margin-top: 24px;
            color: var(--prince-text);
            font-size: 1.05rem;
            line-height: 1.95;
        }

        .lp-host-ticket {
            width: min(100%, 520px);
            margin-top: 30px;
            padding: 18px 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.86);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 16px 34px rgba(15, 23, 42, .06);
            display: grid;
            grid-template-columns: 54px 1fr;
            gap: 16px;
            align-items: center;
        }

        .lp-host-icon {
            width: 54px;
            height: 54px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--prince-accent) 64%, white));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            color: var(--prince-primary);
            font-size: 24px;
        }

        .lp-host-ticket small {
            display: block;
            color: var(--prince-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .lp-host-ticket strong {
            display: block;
            margin-top: 6px;
            color: var(--prince-dark);
            font-size: 1.08rem;
            font-weight: 950;
            line-height: 1.45;
        }

        .lp-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .lp-mini-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 36px;
            max-width: 610px;
        }

        .lp-mini-stat {
            position: relative;
            overflow: hidden;
            padding: 17px 18px;
            border-radius: 999px 999px 26px 26px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .06);
            text-align: center;
        }

        .lp-mini-stat::after {
            content: "";
            position: absolute;
            right: -28px;
            bottom: -34px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-accent) 42%, white);
        }

        .lp-mini-stat strong,
        .lp-mini-stat span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .lp-mini-stat strong {
            color: var(--prince-dark);
            font-size: 1.8rem;
            line-height: 1;
            font-weight: 950;
        }

        .lp-mini-stat span {
            margin-top: 8px;
            color: var(--prince-text);
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .lp-visual {
            min-height: 710px;
        }

        .lp-stage {
            position: relative;
            min-height: 690px;
        }

        .lp-moon {
            position: absolute;
            right: 16px;
            top: 12px;
            width: 238px;
            height: 238px;
            border-radius: 999px;
            background:
                radial-gradient(circle at 32% 32%, rgba(255,255,255,.92), transparent 38%),
                color-mix(in srgb, var(--prince-accent) 60%, white);
            box-shadow: 0 28px 58px rgba(15, 23, 42, .06);
            z-index: 0;
        }

        .lp-orbit {
            position: absolute;
            left: 28px;
            top: 96px;
            width: 360px;
            height: 360px;
            border: 1px solid color-mix(in srgb, var(--prince-primary) 13%, transparent);
            border-radius: 999px;
            transform: rotate(-18deg);
            z-index: 0;
        }

        .lp-orbit::before,
        .lp-orbit::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            background: var(--prince-primary);
        }

        .lp-orbit::before {
            width: 14px;
            height: 14px;
            left: 44px;
            top: 42px;
            opacity: .7;
        }

        .lp-orbit::after {
            width: 9px;
            height: 9px;
            right: 58px;
            bottom: 52px;
            background: var(--prince-secondary);
            opacity: .75;
        }

        .lp-crown-card {
            position: absolute;
            z-index: 4;
            left: 8px;
            top: 40px;
            width: 168px;
            min-height: 210px;
            padding: 24px 18px;
            border-radius: 999px 999px 36px 36px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 24px 52px rgba(15, 23, 42, .10);
            text-align: center;
        }

        .lp-crown-card .crown {
            width: 70px;
            height: 70px;
            margin: 0 auto 14px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 34px;
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            box-shadow: 0 16px 30px color-mix(in srgb, var(--prince-primary) 20%, transparent);
        }

        .lp-crown-card small {
            display: block;
            color: var(--prince-text);
            font-size: 10px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .lp-crown-card strong {
            display: block;
            margin-top: 8px;
            color: var(--prince-dark);
            font-size: 1.1rem;
            line-height: 1.45;
            font-weight: 950;
        }

        .lp-main-card {
            position: absolute;
            z-index: 3;
            right: 8px;
            top: 86px;
            width: min(100%, 470px);
            min-height: 520px;
            padding: 26px;
            border-radius: 56px 56px 56px 120px;
            background: rgba(255,255,255,.97);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 34px 86px rgba(15, 23, 42, .12);
            overflow: hidden;
        }

        .lp-main-card::before {
            content: "";
            position: absolute;
            inset: 16px;
            border-radius: 42px 42px 42px 98px;
            border: 2px dashed color-mix(in srgb, var(--prince-primary) 14%, transparent);
            pointer-events: none;
            z-index: 2;
        }

        .lp-main-card::after {
            content: "";
            position: absolute;
            right: -76px;
            top: -54px;
            width: 210px;
            height: 210px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-accent) 52%, transparent);
            z-index: 0;
        }

        .lp-cover-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .11;
            z-index: 0;
        }

        .lp-main-content {
            position: relative;
            z-index: 3;
            min-height: 468px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .lp-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .lp-card-badge {
            display: inline-flex;
            padding: 8px 13px;
            border-radius: 999px;
            color: var(--prince-primary);
            background: color-mix(in srgb, var(--prince-accent) 40%, white);
            font-size: 11px;
            font-weight: 950;
        }

        .lp-card-dots {
            display: flex;
            gap: 7px;
            padding-top: 6px;
        }

        .lp-card-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--prince-primary);
            opacity: .65;
        }

        .lp-card-dots span:nth-child(2) { background: var(--prince-secondary); }
        .lp-card-dots span:nth-child(3) { background: var(--prince-accent); }

        .lp-card-body {
            max-width: 360px;
            margin: 34px auto 0;
            text-align: center;
        }

        .lp-baby-mark {
            width: 96px;
            height: 96px;
            margin: 0 auto 24px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 35% 25%, #ffffff, color-mix(in srgb, var(--prince-accent) 48%, white));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .08);
        }

        .lp-baby-mark img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            opacity: .82;
        }

        .lp-card-body h2 {
            color: var(--prince-dark);
            font-size: clamp(2.25rem, 4.2vw, 3.5rem);
            line-height: 1.02;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .lp-card-body p {
            margin-top: 18px;
            color: var(--prince-text);
            line-height: 1.85;
        }

        .lp-info-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 28px;
        }

        .lp-info-pill {
            min-width: 0;
            padding: 13px 12px;
            border-radius: 22px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .05);
            text-align: center;
        }

        .lp-info-pill small {
            display: block;
            color: var(--prince-text);
            font-size: 9px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .lp-info-pill strong {
            display: block;
            margin-top: 7px;
            color: var(--prince-dark);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 950;
        }

        .lp-floating-date {
            position: absolute;
            z-index: 6;
            left: 114px;
            bottom: 86px;
            width: 140px;
            min-height: 140px;
            padding: 20px 18px;
            border-radius: 40px;
            background: linear-gradient(180deg, rgba(255,255,255,.97), color-mix(in srgb, var(--prince-soft) 88%, white));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 12%, transparent);
            box-shadow: 0 24px 48px rgba(15, 23, 42, .10);
            text-align: center;
            transform: rotate(-5deg);
        }

        .lp-floating-date b {
            display: block;
            color: var(--prince-dark);
            font-size: 2.8rem;
            line-height: 1;
            font-weight: 950;
        }

        .lp-floating-date span {
            display: block;
            margin-top: 9px;
            color: var(--prince-primary);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .lp-blessing-card {
            position: absolute;
            z-index: 6;
            right: 26px;
            bottom: 8px;
            width: min(74%, 360px);
            padding: 18px 22px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 20px 44px rgba(15, 23, 42, .10);
            color: var(--prince-dark);
            font-weight: 950;
            line-height: 1.55;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .lp-blessing-card span {
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            color: white;
        }

        .lp-star {
            position: absolute;
            z-index: 5;
            color: color-mix(in srgb, var(--prince-primary) 78%, #c9a86a);
            font-size: 20px;
            opacity: .82;
        }

        .lp-star.one { right: 130px; top: 52px; }
        .lp-star.two { left: 250px; top: 170px; font-size: 14px; }
        .lp-star.three { right: 190px; bottom: 156px; font-size: 16px; }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--prince-text);
            line-height: 1.8;
        }

        .prince-grid {
            display: grid;
            gap: 20px;
            margin-top: 38px;
            justify-content: center;
        }

        .prince-grid.count-1 { grid-template-columns: minmax(280px, 460px); }
        .prince-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .prince-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .prince-highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 230px;
            padding: 28px;
            border-radius: 34px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
        }

        .prince-highlight-card::after {
            content: "";
            position: absolute;
            width: 138px;
            height: 138px;
            right: -44px;
            bottom: -44px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-accent) 26%, transparent);
        }

        .prince-highlight-number {
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
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            margin-bottom: 18px;
        }

        .prince-highlight-card h3,
        .prince-highlight-card p {
            position: relative;
            z-index: 2;
        }

        .prince-highlight-card h3 {
            color: var(--prince-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .prince-highlight-card p {
            margin-top: 10px;
            color: var(--prince-text);
            line-height: 1.8;
        }

        .baby-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 38px;
        }

        .baby-grid.single-baby {
            grid-template-columns: minmax(0, 380px);
        }

        .baby-card {
            position: relative;
            overflow: hidden;
            padding: 24px;
            border-radius: 34px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
        }

        .baby-card::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            right: -46px;
            top: -46px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-accent) 30%, transparent);
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
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--prince-soft) 90%, white));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .07);
            font-size: 42px;
            font-weight: 950;
            color: var(--prince-primary);
        }

        .baby-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-primary) 10%, white);
            color: var(--prince-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .baby-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--prince-dark);
            font-size: 1.7rem;
            font-weight: 950;
        }

        .baby-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--prince-text);
            line-height: 1.7;
        }

        .focus-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .prince-card {
            padding: 30px;
            border-radius: 36px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .07);
        }

        .prince-card h3 {
            margin: 0;
            color: var(--prince-dark);
            font-size: 2rem;
            font-weight: 950;
        }

        .detail-list { display: grid; gap: 14px; margin-top: 24px; }

        .detail-row {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--prince-primary) 16%, transparent);
        }

        .detail-row .label {
            color: var(--prince-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--prince-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .prince-date-line,
        .prince-time-line {
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
            background: linear-gradient(180deg, color-mix(in srgb, var(--prince-soft) 90%, white), white);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--prince-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--prince-text);
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
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .07);
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
            color: var(--prince-dark);
            text-decoration: none;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--prince-soft) 90%, white));
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
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
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
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 18px 42px rgba(15, 23, 42, .07);
        }

        .gift-card h3 {
            color: var(--prince-dark);
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
            background: color-mix(in srgb, var(--prince-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--prince-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--prince-primary);
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
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
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
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 16px 34px rgba(15, 23, 42, .07);
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
            color: var(--prince-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--prince-text);
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
            background: color-mix(in srgb, var(--prince-primary) 10%, white);
            color: var(--prince-primary);
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
            background: linear-gradient(135deg, color-mix(in srgb, var(--prince-primary) 10%, white), color-mix(in srgb, var(--prince-accent) 26%, white));
            border: 1px solid color-mix(in srgb, var(--prince-primary) 10%, transparent);
            box-shadow: 0 20px 44px rgba(15, 23, 42, .07);
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
            .lp-hero,
            .focus-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .lp-copy {
                text-align: center;
            }

            .lp-kicker,
            .lp-action-row {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }

            .lp-title,
            .lp-desc,
            .lp-mini-row,
            .lp-host-ticket {
                margin-left: auto;
                margin-right: auto;
            }

            .lp-visual {
                min-height: auto;
            }

            .lp-stage {
                min-height: auto;
                display: grid;
                gap: 16px;
            }

            .lp-moon,
            .lp-orbit,
            .lp-star {
                display: none;
            }

            .lp-crown-card,
            .lp-main-card,
            .lp-floating-date,
            .lp-blessing-card {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: 100%;
                margin: 0;
                transform: none;
            }

            .lp-crown-card {
                min-height: auto;
                border-radius: 34px;
                display: grid;
                grid-template-columns: 88px 1fr;
                gap: 16px;
                align-items: center;
                text-align: left;
            }

            .lp-crown-card .crown {
                margin: 0;
            }

            .lp-main-card {
                border-radius: 42px;
            }

            .lp-main-card::before {
                border-radius: 30px;
            }

            .lp-main-content {
                min-height: auto;
            }

            .lp-floating-date {
                border-radius: 28px;
            }

            .lp-blessing-card {
                border-radius: 28px;
            }

            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .prince-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        }

        @media (max-width: 980px) {
            .prince-shell { padding: 16px; }
            .prince-section { padding: 82px 38px; }
            .lp-hero { padding: 82px 38px 90px; }
            .summary-grid,
            .countdown-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .prince-shell { padding: 0; }
            .prince-wrap { border-radius: 0; box-shadow: none; }
            .prince-section { padding: 72px 22px; }
            .prince-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .lp-hero { padding: 72px 22px 82px; }

            .lp-title {
                font-size: clamp(2.45rem, 11.5vw, 3.8rem);
                line-height: 1.02;
            }

            .lp-mini-row,
            .lp-info-row,
            .prince-grid,
            .prince-grid.count-1,
            .prince-grid.count-2,
            .prince-grid.count-3,
            .gallery-column,
            .summary-grid,
            .countdown-grid,
            .gift-grid,
            .gift-grid.gift-count-1 {
                grid-template-columns: 1fr;
            }

            .lp-host-ticket {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .lp-host-icon {
                margin: 0 auto;
            }

            .lp-crown-card {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .lp-crown-card .crown {
                margin: 0 auto 8px;
            }

            .lp-main-card {
                padding: 18px;
                border-radius: 32px;
            }

            .lp-main-card::before {
                inset: 12px;
                border-radius: 24px;
            }

            .lp-main-content {
                padding: 12px 4px 6px;
            }

            .lp-card-body h2 {
                font-size: clamp(2rem, 10vw, 3rem);
            }

            .lp-blessing-card {
                flex-direction: column;
                text-align: center;
            }

            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .floating-actions { right: 10px; }
        }

        /* =========================================
        AQIQAH LITTLE PRINCE - HERO RIGHT TIDY
        ========================================= */

        .prince-right-wrap {
            position: relative;
            width: 100%;
            max-width: 620px;
            min-height: 760px;
            margin-left: auto;
        }

        .prince-main-panel {
            position: relative;
            z-index: 1;
            min-height: 720px;
            border-radius: 42px;
            padding: 34px 28px 28px;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(255,255,255,.97), rgba(248,250,255,.98));
            border: 1px solid rgba(106, 140, 196, .12);
            box-shadow: 0 26px 60px rgba(28, 43, 75, .10);
        }

        .prince-main-panel::before {
            content: "";
            position: absolute;
            inset: 14px;
            border-radius: 30px;
            border: 2px dashed rgba(106, 140, 196, .20);
            pointer-events: none;
        }

        .prince-main-topbar {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .prince-main-pill {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(106, 140, 196, .10);
            color: var(--prince-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .prince-main-dots {
            display: flex;
            gap: 8px;
        }

        .prince-main-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--prince-primary) 70%, white);
        }

        .prince-main-icon {
            position: relative;
            z-index: 2;
            width: 110px;
            height: 110px;
            border-radius: 999px;
            margin: 28px auto 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #f9fbff, #ffffff);
            border: 1px solid rgba(106, 140, 196, .12);
            box-shadow: 0 12px 28px rgba(28, 43, 75, .06);
        }

        .prince-main-icon img {
            width: 54px;
            height: 54px;
            object-fit: contain;
            opacity: .7;
        }

        .prince-main-title {
            position: relative;
            z-index: 2;
            margin: 34px auto 0;
            max-width: 430px;
            text-align: center;
            font-size: clamp(2.6rem, 4.3vw, 4.3rem);
            line-height: .98;
            letter-spacing: -.05em;
            font-weight: 950;
            color: var(--prince-ink);
        }

        .prince-main-desc {
            position: relative;
            z-index: 2;
            max-width: 420px;
            margin: 18px auto 0;
            text-align: center;
            color: #5f6f86;
            line-height: 1.85;
        }

        .prince-info-grid {
            position: relative;
            z-index: 2;
            margin-top: 34px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .prince-info-box {
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(106, 140, 196, .10);
            border-radius: 24px;
            padding: 16px 14px;
            text-align: center;
            box-shadow: 0 10px 24px rgba(28, 43, 75, .05);
        }

        .prince-info-box small {
            display: block;
            color: #7d8faa;
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 900;
        }

        .prince-info-box strong {
            display: block;
            margin-top: 10px;
            color: var(--prince-ink);
            font-size: 17px;
            line-height: 1.55;
            font-weight: 900;
        }

        /* === 3 floating cards yang dirapikan === */

        .prince-floating-card {
            position: absolute;
            z-index: 3;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(106, 140, 196, .10);
            box-shadow: 0 18px 42px rgba(28, 43, 75, .10);
        }

        /* Little Prince card -> turun sedikit */
        .prince-floating-prince {
            top: 86px;
            left: -64px;
            width: 165px;
            border-radius: 36px 36px 12px 12px;
            padding: 18px 16px 20px;
            text-align: center;
        }

        .prince-floating-prince .icon-wrap {
            width: 68px;
            height: 68px;
            margin: 0 auto 14px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            box-shadow: 0 14px 30px color-mix(in srgb, var(--prince-primary) 20%, transparent);
        }

        .prince-floating-prince .icon-wrap img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .prince-floating-prince .mini-label {
            font-size: 12px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 900;
            color: #5f6f86;
        }

        .prince-floating-prince h4 {
            margin: 14px 0 0;
            font-size: 2rem;
            line-height: 1.05;
            font-weight: 950;
            color: var(--prince-ink);
        }

        /* Tanggal -> taruh di depan area tanggal */
        .prince-floating-date {
            left: 26px;
            bottom: 226px;
            width: 138px;
            border-radius: 30px;
            padding: 18px 14px;
            text-align: center;
        }

        .prince-floating-date strong {
            display: block;
            font-size: 2.9rem;
            line-height: 1;
            font-weight: 950;
            color: var(--prince-ink);
        }

        .prince-floating-date span {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 900;
            color: var(--prince-primary);
        }

        /* Harapan -> turun di bawah, lebih rapi */
        .prince-floating-wish {
            right: -10px;
            bottom: 158px;
            width: 330px;
            border-radius: 999px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .prince-floating-wish .wish-icon {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--prince-primary), var(--prince-secondary));
            color: white;
            font-size: 18px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .prince-floating-wish p {
            margin: 0;
            color: var(--prince-ink);
            font-weight: 850;
            line-height: 1.55;
        }

        /* background ornament */
        .prince-bg-circle {
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            z-index: 0;
        }

        .prince-bg-circle.one {
            width: 210px;
            height: 210px;
            top: 24px;
            right: -32px;
            background: color-mix(in srgb, var(--prince-accent) 42%, white);
            opacity: .55;
        }

        .prince-bg-circle.two {
            width: 180px;
            height: 180px;
            left: -46px;
            top: 140px;
            background: color-mix(in srgb, var(--prince-secondary) 16%, white);
            opacity: .35;
        }

        /* ===== Ornament tambahan hero kanan ===== */
        .prince-right-wrap {
            position: relative;
            isolation: isolate;
        }

        .prince-hero-orb {
            position: absolute;
            top: -42px;
            right: -34px;
            width: 360px;
            height: 360px;
            border-radius: 999px;
            background:
                radial-gradient(
                    circle,
                    color-mix(in srgb, var(--prince-accent) 52%, white) 0%,
                    color-mix(in srgb, var(--prince-primary) 8%, white) 55%,
                    rgba(255,255,255,0) 100%
                );
            opacity: .65;
            z-index: 0;
            pointer-events: none;
            filter: blur(.2px);
        }

        .prince-hero-spark {
            position: absolute;
            top: 34px;
            right: 168px;
            width: 18px;
            height: 18px;
            z-index: 1;
            pointer-events: none;
            transform: rotate(45deg);
            opacity: .72;
        }

        .prince-hero-spark::before,
        .prince-hero-spark::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            background: color-mix(in srgb, var(--prince-primary) 62%, white);
            border-radius: 999px;
            transform: translate(-50%, -50%);
        }

        .prince-hero-spark::before {
            width: 18px;
            height: 3px;
        }

        .prince-hero-spark::after {
            width: 3px;
            height: 18px;
        }

        .prince-main-panel {
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .prince-panel-corner-blob {
            position: absolute;
            top: 0;
            right: 0;
            width: 210px;
            height: 190px;
            background: color-mix(in srgb, var(--prince-primary) 10%, white);
            opacity: .55;
            border-bottom-left-radius: 150px;
            border-top-right-radius: 34px;
            z-index: 0;
            pointer-events: none;
        }

        /* supaya isi panel tetap di atas ornamen */
        .prince-main-panel > *:not(.prince-panel-corner-blob) {
            position: relative;
            z-index: 1;
        }

        /* responsive */
        @media (max-width: 1100px) {
            .prince-right-wrap {
                max-width: 100%;
                min-height: auto;
            }

            .prince-main-panel {
                min-height: auto;
                padding-bottom: 180px;
            }

            .prince-floating-prince {
                left: 10px;
                top: -34px;
            }

            .prince-floating-date {
                left: 20px;
                bottom: 170px;
            }

            .prince-floating-wish {
                right: 18px;
                bottom: 74px;
                width: calc(100% - 36px);
            }
        }

        @media (max-width: 640px) {
            .prince-main-title {
                font-size: clamp(2rem, 10vw, 3rem);
            }

            .prince-info-grid {
                grid-template-columns: 1fr;
            }

            .prince-main-panel {
                padding: 22px 18px 220px;
                border-radius: 30px;
            }

            .prince-floating-prince {
                position: relative;
                top: auto;
                left: auto;
                width: 100%;
                margin-bottom: 14px;
                border-radius: 28px;
            }

            .prince-right-wrap {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            .prince-floating-date,
            .prince-floating-wish {
                position: relative;
                left: auto;
                right: auto;
                bottom: auto;
                top: auto;
                width: 100%;
                margin-top: 14px;
            }

            .prince-floating-wish {
                border-radius: 26px;
            }

            .prince-main-panel {
                padding-bottom: 24px;
            }
        }

        /* =====================================================
        LUXURY LITTLE PRINCE ANIMATION
        ===================================================== */

        .prince-reveal,
        .prince-section > p,
        .prince-section > h1,
        .prince-section > h2,
        .prince-section > h3,
        .prince-label,
        .prince-title,
        .prince-gradient-text,
        .prince-nav,
        .prince-btn,

        /* Hero Little Prince */
        .lp-hero,
        .lp-copy,
        .lp-kicker,
        .lp-title,
        .lp-desc,
        .lp-host-ticket,
        .lp-host-icon,
        .lp-action-row,
        .lp-mini-stat,
        .lp-visual,
        .lp-stage,
        .lp-moon,
        .lp-orbit,
        .lp-crown-card,
        .lp-main-card,
        .lp-main-content,
        .lp-card-badge,
        .lp-baby-mark,
        .lp-card-body,
        .lp-info-pill,
        .lp-floating-date,
        .lp-blessing-card,
        .lp-star,

        /* Hero right tidy */
        .prince-right-wrap,
        .prince-main-panel,
        .prince-main-pill,
        .prince-main-icon,
        .prince-main-title,
        .prince-main-desc,
        .prince-info-box,
        .prince-floating-card,
        .prince-floating-prince,
        .prince-floating-date,
        .prince-floating-wish,
        .prince-hero-orb,
        .prince-hero-spark,

        /* Section content */
        .prince-highlight-card,
        .prince-highlight-number,
        .baby-card,
        .baby-photo,
        .baby-placeholder,
        .baby-role,
        .prince-card,
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

        .prince-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .prince-nav {
            animation: princeNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .lp-copy {
            animation: princeHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .lp-kicker {
            animation: princeFadeDown .85s ease .18s both;
        }

        #opening .lp-title {
            animation: princeTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .lp-desc {
            animation: princeFadeUp .85s ease .48s both;
        }

        #opening .lp-host-ticket {
            animation: princeFadeUp .85s ease .58s both;
        }

        #opening .lp-action-row {
            animation: princeFadeUp .85s ease .70s both;
        }

        #opening .lp-mini-stat {
            animation: princeFadeUp .9s ease .82s both;
        }

        #opening .lp-main-card,
        #opening .prince-main-panel {
            animation:
                princeMainCardEnter 1.12s cubic-bezier(.2, .8, .2, 1) .28s both,
                princeMainCardFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .lp-crown-card,
        #opening .prince-floating-prince {
            animation:
                princeCrownEnter .95s cubic-bezier(.2, .8, .2, 1) .62s both,
                princeCrownFloat 4.8s ease-in-out 1.5s infinite;
        }

        #opening .lp-floating-date,
        #opening .prince-floating-date {
            animation:
                princeDateEnter .95s cubic-bezier(.2, .8, .2, 1) .74s both,
                princeDateFloat 5s ease-in-out 1.6s infinite;
        }

        #opening .lp-blessing-card,
        #opening .prince-floating-wish {
            animation:
                princeFloatingIn .95s cubic-bezier(.2, .8, .2, 1) .86s both,
                princeFloatingMove 5.1s ease-in-out 1.7s infinite;
        }

        /* Background dan ornamen hidup */
        .prince-wrap {
            animation: princeWrapGlow 8s ease-in-out infinite alternate;
        }

        .prince-wrap::before {
            animation: princeGridMove 20s linear infinite;
        }

        .lp-hero::before,
        .lp-moon,
        .lp-orbit,
        .lp-mini-stat::after,
        .lp-main-card::after,
        .prince-highlight-card::after,
        .baby-card::before,
        .gift-card::after,
        .closing-card::before,
        .closing-card::after,
        .prince-hero-orb,
        .prince-bg-circle,
        .prince-panel-corner-blob {
            animation: princeDecorFloat 6.4s ease-in-out infinite;
        }

        /* Bintang dan spark */
        .lp-star.one,
        .prince-hero-spark {
            animation: princeStarOne 4.6s ease-in-out infinite;
        }

        .lp-star.two {
            animation: princeStarTwo 5s ease-in-out .2s infinite;
        }

        .lp-star.three {
            animation: princeStarThree 5.3s ease-in-out .35s infinite;
        }

        /* Label glow */
        .prince-label::before,
        .prince-label::after,
        .lp-kicker span,
        .lp-baby-mark,
        .lp-crown-card .crown,
        .prince-floating-prince .icon-wrap {
            animation: princeLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Dots bergerak */
        .lp-card-dots span,
        .prince-main-dots span {
            animation: princeDotPulse 1.8s ease-in-out infinite;
        }

        .lp-card-dots span:nth-child(2),
        .prince-main-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        .lp-card-dots span:nth-child(3),
        .prince-main-dots span:nth-child(3) {
            animation-delay: .36s;
        }

        /* Tombol efek kilau */
        .prince-btn,
        button.prince-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .prince-btn::after,
        button.prince-btn::after,
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
            animation: princeButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .lp-host-ticket:hover,
            .lp-mini-stat:hover,
            .lp-crown-card:hover,
            .lp-main-card:hover,
            .lp-floating-date:hover,
            .lp-blessing-card:hover,
            .prince-main-panel:hover,
            .prince-floating-card:hover,
            .prince-info-box:hover,
            .prince-highlight-card:hover,
            .baby-card:hover,
            .prince-card:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--prince-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--prince-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--prince-accent) 30%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .lp-main-card:hover img,
            .gallery-card:hover img,
            .baby-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .lp-cover-photo,
        .gallery-card img,
        .baby-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: princeNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon / angka pulse */
        .prince-highlight-number,
        .baby-placeholder,
        .lp-baby-mark,
        .lp-host-icon,
        .prince-main-icon,
        .prince-floating-date strong,
        .gift-number,
        .message-badge {
            animation: princeSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: princeGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: princeGalleryTwo 4.8s ease-in-out .18s infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: princeGalleryThree 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: princeFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes princeNavEnter {
            from { opacity: 0; transform: translateY(-18px) scale(.96); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes princeHeroCopyIn {
            from { opacity: 0; transform: translateX(-24px) translateY(34px) scale(.96); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes princeMainCardEnter {
            from { opacity: 0; transform: translateX(30px) translateY(36px) scale(.92) rotate(3deg); filter: blur(12px); }
            to { opacity: 1; transform: translateX(0) translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes princeMainCardFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-8px) scale(1.012); }
        }

        @keyframes princeCrownEnter {
            from { opacity: 0; transform: translateY(30px) scale(.86) rotate(-6deg); filter: blur(9px); }
            to { opacity: 1; transform: translateY(0) scale(1) rotate(0); filter: blur(0); }
        }

        @keyframes princeCrownFloat {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-8px) rotate(-1.5deg); }
        }

        @keyframes princeDateEnter {
            from { opacity: 0; transform: translateY(28px) scale(.86) rotate(-7deg); filter: blur(9px); }
            to { opacity: 1; transform: translateY(0) scale(1) rotate(-5deg); filter: blur(0); }
        }

        @keyframes princeDateFloat {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-8px) rotate(-3deg); }
        }

        @keyframes princeFloatingIn {
            from { opacity: 0; transform: translateY(24px) scale(.9); filter: blur(8px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes princeFloatingMove {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        @keyframes princeFadeDown {
            from { opacity: 0; transform: translateY(-20px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes princeFadeUp {
            from { opacity: 0; transform: translateY(26px); filter: blur(7px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes princeTitleIn {
            from { opacity: 0; transform: translateY(38px) scale(.94); filter: blur(12px); letter-spacing: -.02em; }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        @keyframes princeWrapGlow {
            from { box-shadow: 0 34px 90px rgba(15, 23, 42, .08); }
            to {
                box-shadow:
                    0 42px 118px rgba(15, 23, 42, .11),
                    0 0 58px color-mix(in srgb, var(--prince-accent) 30%, transparent);
            }
        }

        @keyframes princeGridMove {
            from { background-position: 0 0, 0 0; }
            to { background-position: 126px 126px, 126px 126px; }
        }

        @keyframes princeDecorFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.04); }
        }

        @keyframes princeStarOne {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-13px) rotate(12deg) scale(1.15); }
        }

        @keyframes princeStarTwo {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-10px) rotate(-10deg) scale(1.12); }
        }

        @keyframes princeStarThree {
            0%, 100% { transform: translateY(0) rotate(0) scale(1); }
            50% { transform: translateY(-12px) rotate(8deg) scale(1.14); }
        }

        @keyframes princeLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--prince-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--prince-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes princeDotPulse {
            0%, 100% { opacity: .42; transform: translateY(0); }
            50% { opacity: .95; transform: translateY(-2px); }
        }

        @keyframes princeButtonShine {
            0%, 48% { left: -80%; }
            75%, 100% { left: 130%; }
        }

        @keyframes princeNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--prince-primary) 16%, transparent); }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--prince-primary) 38%, transparent),
                    0 0 34px color-mix(in srgb, var(--prince-accent) 48%, transparent);
            }
        }

        @keyframes princeSoftPulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-3px) scale(1.035); }
        }

        @keyframes princeGalleryOne {
            0%, 100% { transform: translateY(0) rotate(-.4deg); }
            50% { transform: translateY(-7px) rotate(-.9deg); }
        }

        @keyframes princeGalleryTwo {
            0%, 100% { transform: translateY(0) rotate(.4deg); }
            50% { transform: translateY(-6px) rotate(.9deg); }
        }

        @keyframes princeGalleryThree {
            0%, 100% { transform: translateY(0) rotate(.2deg); }
            50% { transform: translateY(-7px) rotate(.7deg); }
        }

        @keyframes princeFloatingButton {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .prince-reveal,
            .prince-section > p,
            .prince-section > h1,
            .prince-section > h2,
            .prince-section > h3,
            .prince-label,
            .prince-title,
            .prince-gradient-text,
            .prince-nav,
            .prince-btn,
            .lp-hero,
            .lp-copy,
            .lp-kicker,
            .lp-title,
            .lp-desc,
            .lp-host-ticket,
            .lp-action-row,
            .lp-mini-stat,
            .lp-visual,
            .lp-main-card,
            .lp-crown-card,
            .lp-floating-date,
            .lp-blessing-card,
            .prince-main-panel,
            .prince-floating-card,
            .prince-highlight-card,
            .baby-card,
            .prince-card,
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

            #opening .lp-main-card,
            #opening .prince-main-panel {
                animation:
                    princeFadeUp .9s ease .3s both,
                    princeFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .prince-reveal,
            .prince-section > p,
            .prince-section > h1,
            .prince-section > h2,
            .prince-section > h3,
            .prince-label,
            .prince-title,
            .prince-gradient-text,
            .prince-nav,
            .prince-btn,
            .lp-hero,
            .lp-copy,
            .lp-kicker,
            .lp-title,
            .lp-desc,
            .lp-host-ticket,
            .lp-host-icon,
            .lp-action-row,
            .lp-mini-stat,
            .lp-visual,
            .lp-stage,
            .lp-moon,
            .lp-orbit,
            .lp-crown-card,
            .lp-main-card,
            .lp-main-content,
            .lp-card-badge,
            .lp-baby-mark,
            .lp-card-body,
            .lp-info-pill,
            .lp-floating-date,
            .lp-blessing-card,
            .lp-star,
            .prince-right-wrap,
            .prince-main-panel,
            .prince-main-pill,
            .prince-main-icon,
            .prince-main-title,
            .prince-main-desc,
            .prince-info-box,
            .prince-floating-card,
            .prince-floating-prince,
            .prince-floating-date,
            .prince-floating-wish,
            .prince-hero-orb,
            .prince-hero-spark,
            .prince-highlight-card,
            .prince-highlight-number,
            .baby-card,
            .baby-photo,
            .baby-placeholder,
            .baby-role,
            .prince-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .prince-wrap,
            .prince-wrap::before,
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

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];

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

    // Template Aqiqah Little Prince hanya mendukung acara offline.
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
        --prince-primary: {{ $activeTheme['primary'] }};
        --prince-secondary: {{ $activeTheme['secondary'] }};
        --prince-accent: {{ $activeTheme['accent'] }};
        --prince-dark: {{ $activeTheme['dark'] }};
        --prince-text: {{ $activeTheme['text'] }};
        --prince-soft: {{ $activeTheme['soft'] }};
        --prince-glow-1: {{ $activeTheme['glow1'] }};
        --prince-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="prince-shell">
        <div class="prince-wrap">

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

            <nav class="prince-nav">
                <a href="#babies">Buah Hati</a>
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
            <section id="opening" class="lp-hero">
                <div class="lp-copy">
                    <div class="lp-kicker"><span>♛</span> Little Prince</div>

                    <h1 class="responsive-text prince-title lp-title">
                        {{ $invitation->title ?: 'Aqiqah Little Prince' }}
                        <span class="line-soft">Penuh Berkah</span>
                    </h1>

                    <p class="responsive-text lp-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen aqiqah buah hati kami.' }}
                    </p>

                    <div class="lp-host-ticket">
                        <div class="lp-host-icon">❦</div>
                        <div>
                            <small>Diselenggarakan oleh</small>
                            <strong class="responsive-text">{{ $invitation->host_name ?: 'Keluarga Besar' }}</strong>
                        </div>
                    </div>

                    <div class="lp-action-row">
                        <a href="#detail" class="prince-btn">Lihat Detail</a>
                        <a href="#message" class="prince-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="lp-mini-row">
                        <div class="lp-mini-stat">
                            <strong>{{ max($babyCount, 1) }}</strong>
                            <span>Buah Hati</span>
                        </div>

                        <div class="lp-mini-stat">
                            <strong>{{ $highlightCount }}</strong>
                            <span>Poin Acara</span>
                        </div>

                        <div class="lp-mini-stat">
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

                @php
                    $littlePrince = $invitation->people->first();
                    $littlePrinceName = $littlePrince?->name ?: 'Alex';
                @endphp

                <div class="prince-right-wrap">
                    <div class="prince-hero-orb"></div>
                    <div class="prince-hero-spark"></div>
                    <div class="prince-back-layer prince-back-layer-one"></div>
                    <div class="prince-back-layer prince-back-layer-two"></div>

                    <div class="prince-deco prince-deco-dots" aria-hidden="true">
                        <span></span><span></span><span></span>
                        <span></span><span></span><span></span>
                    </div>

                    <div class="prince-deco prince-deco-spark prince-deco-spark-one" aria-hidden="true"></div>
                    <div class="prince-deco prince-deco-spark prince-deco-spark-two" aria-hidden="true"></div>
                    <div class="prince-bg-circle one"></div>
                    <div class="prince-bg-circle two"></div>

                    {{-- card little prince --}}
                    <div class="prince-floating-card prince-floating-prince">
                        <div class="icon-wrap">
                            <img src="{{ asset('assets/icons/crown.png') }}" alt="Little Prince" class="w-12 h-12">
                        </div>
                        <div class="mini-label">Little Prince</div>
                        <h4 class="responsive-text">{{ $littlePrinceName }}</h4>
                    </div>

                    {{-- panel utama --}}
                    <div class="prince-main-panel">
                        <div class="prince-panel-corner-blob"></div>
                        <div class="prince-main-topbar">
                            <div class="prince-main-pill">{{ $invitation->event_name ?: 'Tasyakuran Aqiqah' }}</div>

                            <div class="prince-main-dots">
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                        <div class="prince-main-icon">
                            <img src="{{ asset('assets/icons/Kambing.png') }}" alt="Kambing">
                        </div>

                        <h2 class="prince-main-title responsive-text">
                            {{ $invitation->seminar_about_title ?: 'Doa Baik untuk Pangeran Kecil Kami' }}
                        </h2>

                        <p class="prince-main-desc responsive-text">
                            {{ $invitation->host_name
                                ? 'Diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen syukur dan doa terbaik untuk buah hati tercinta.'
                                : 'Momen syukur dan doa terbaik untuk buah hati tercinta.' }}
                        </p>

                        <div class="prince-info-grid">
                            <div class="prince-info-box">
                                <small>Tanggal</small>
                                <strong class="responsive-text">
                                    @if ($invitation->event_date)
                                        {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}
                                    @else
                                        Belum diatur
                                    @endif
                                </strong>
                            </div>

                            <div class="prince-info-box">
                                <small>Waktu</small>
                                <strong class="responsive-text">
                                    @if ($invitation->event_time)
                                        {{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}
                                    @else
                                        Belum diatur
                                    @endif
                                </strong>
                            </div>

                            <div class="prince-info-box">
                                <small>Lokasi</small>
                                <strong class="responsive-text">
                                    {{ $invitation->location_name ?: 'Kediaman Keluarga' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            <section id="about" class="prince-section compact text-center">
                <p class="prince-label">Tentang Aqiqah</p>

                <h2 class="responsive-text prince-title text-5xl md:text-6xl mt-6">
                    {{ $invitation->seminar_about_title ?: 'Doa, Syukur, dan Kebahagiaan Keluarga' }}
                </h2>

                <p class="responsive-text desc text-slate-600 mt-4 max-w-3xl mx-auto leading-8">
                    {{ $invitation->host_name
                        ? 'Acara ini dipersembahkan oleh ' . $invitation->host_name . ' sebagai wujud syukur dan doa baik untuk buah hati tercinta.'
                        : 'Acara aqiqah ini menjadi momen untuk berkumpul, berbagi doa, dan merayakan hadirnya buah hati dengan penuh rasa syukur.' }}
                </p>

                @if ($highlightCount > 0)
                    <div class="prince-grid {{ $highlightGridClass }} text-left">
                        @foreach ($aqiqahHighlights as $index => $highlight)
                            <div class="prince-highlight-card">
                                <div class="prince-highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                                <h3 class="responsive-text">{{ $highlight['title'] ?: 'Momen Aqiqah' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?: 'Deskripsi momen aqiqah akan tampil di sini.' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- BABIES --}}
            <section id="babies" class="prince-section compact text-center">
                <p class="prince-label">Buah Hati</p>

                <h2 class="prince-title text-5xl md:text-6xl mt-6">
                    Pangeran Kecil Kami
                </h2>

                <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-7">
                    Tampilkan data buah hati atau keluarga yang berbahagia.
                </p>

                <div class="baby-grid {{ $babyCount <= 1 ? 'single-baby' : '' }}">
                    @forelse ($babies as $person)
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
                    @empty
                        <div class="baby-card text-left">
                            <div class="baby-placeholder">A</div>
                            <span class="baby-role">Buah Hati</span>
                            <h3>Nama Buah Hati</h3>
                            <p>Data buah hati belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="prince-section compact">
                <div class="section-head">
                    <p class="prince-label">Detail Acara</p>
                    <h2 class="prince-title text-5xl md:text-6xl mt-6">Informasi Kehadiran</h2>
                    <p class="desc">Informasi lengkap mengenai waktu, tempat, dan akses menuju acara aqiqah.</p>
                </div>

                <div class="focus-layout">
                    <div class="prince-card">
                        <h3>Aqiqah Pass</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label">Acara</div>
                                <div class="value responsive-text">{{ $invitation->event_name ?: 'Aqiqah' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value prince-date-line">
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
                                <div class="value prince-time-line">
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
                                <div class="value responsive-text">{{ $invitation->location_name ?: 'Lokasi Acara' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Alamat</div>
                                <div class="value responsive-text">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan' }}</div>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="prince-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="prince-btn secondary">📍 Buka Maps</a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="prince-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Countdown Aqiqah</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Siapkan waktu terbaik untuk hadir dalam momen penuh syukur ini.
                            </p>

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
                                            <p class="responsive-text mt-4 font-bold" style="color: var(--prince-primary);">
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
                <section id="gallery" class="prince-section compact text-center">
                    <p class="prince-label">Galeri</p>
                    <h2 class="prince-title text-5xl md:text-6xl mt-6">Momen Aqiqah</h2>

                    <div class="gallery-grid">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'short' : 'tall' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Aqiqah">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- DIGITAL GIFT --}}
            @if ($giftCount)
                <section id="gift" class="prince-section compact text-center">
                    <p class="prince-label">Amplop Digital</p>
                    <h2 class="prince-title text-5xl md:text-6xl mt-6">Kirim Tanda Kasih</h2>
                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-8">
                        Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi di bawah ini.
                    </p>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }} text-left">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $bankName = $gift->bank_name ?? ($gift->label ?? null);
                                $accountName = $gift->account_name ?? null;
                                $accountNumber = $gift->account_number ?? null;
                                $ewalletName = $gift->ewallet_name ?? null;
                                $ewalletNumber = $gift->ewallet_number ?? null;
                            @endphp

                            <div class="gift-card">
                                @if ($bankName || $accountNumber)
                                    <h3>{{ $bankName ?: 'Rekening Bank' }}</h3>
                                    <p class="responsive-text text-slate-500 mt-2">{{ $accountName ?: 'Atas nama penerima' }}</p>

                                    <div class="gift-copy-box">
                                        <div>
                                            <small>Nomor Rekening</small>
                                            <span class="gift-number responsive-text">{{ $accountNumber ?: '-' }}</span>
                                        </div>

                                        @if ($accountNumber)
                                            <button type="button" class="copy-gift-btn" data-copy="{{ $accountNumber }}">Salin</button>
                                        @endif
                                    </div>
                                @elseif ($ewalletName || $ewalletNumber)
                                    <h3>{{ $ewalletName ?: 'E-Wallet' }}</h3>
                                    <p class="responsive-text text-slate-500 mt-2">{{ $accountName ?: 'Atas nama penerima' }}</p>

                                    <div class="gift-copy-box">
                                        <div>
                                            <small>Nomor</small>
                                            <span class="gift-number responsive-text">{{ $ewalletNumber ?: '-' }}</span>
                                        </div>

                                        @if ($ewalletNumber)
                                            <button type="button" class="copy-gift-btn" data-copy="{{ $ewalletNumber }}">Salin</button>
                                        @endif
                                    </div>
                                @else
                                    <h3>Amplop Digital</h3>
                                    <p class="text-slate-500 mt-2">Data amplop digital belum lengkap.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="prince-section compact">
                <div class="text-center">
                    <p class="prince-label">RSVP & Ucapan</p>
                    <h2 class="prince-title text-5xl md:text-6xl mt-6">Konfirmasi Kehadiran</h2>
                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto">Silakan isi form untuk konfirmasi kehadiran dan kirim ucapan terbaik.</p>
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
                            <label class="uk-label">Ucapan / Pesan</label>
                            <textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan atau doa..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full prince-btn">Kirim Konfirmasi</button>
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
                            <div class="message-card text-center">
                                <p class="text-slate-500">Belum ada konfirmasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="prince-section text-center">
                <div class="closing-card">
                    <p class="prince-label">Terima Kasih</p>

                    <h2 class="responsive-text prince-title prince-gradient-text text-5xl md:text-7xl mt-8">
                        Sampai Jumpa
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda.
                        Semoga momen aqiqah ini membawa keberkahan dan kebahagiaan bagi keluarga.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
                        {{ $invitation->title ?: 'Aqiqah Little Prince' }}
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
                        this.textContent = 'Disalin';
                        this.classList.add('copied');
                        setTimeout(() => {
                            this.textContent = original;
                            this.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        alert('Gagal menyalin teks.');
                    }
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal - Little Prince
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .prince-section > p,
                .prince-section > h1,
                .prince-section > h2,
                .prince-section > h3,
                .prince-label,
                .prince-title,
                .prince-gradient-text,
                .prince-nav,
                .prince-btn,

                .lp-hero,
                .lp-copy,
                .lp-kicker,
                .lp-title,
                .lp-desc,
                .lp-host-ticket,
                .lp-host-icon,
                .lp-action-row,
                .lp-mini-stat,
                .lp-visual,
                .lp-stage,
                .lp-moon,
                .lp-orbit,
                .lp-crown-card,
                .lp-main-card,
                .lp-main-content,
                .lp-card-badge,
                .lp-baby-mark,
                .lp-card-body,
                .lp-info-pill,
                .lp-floating-date,
                .lp-blessing-card,
                .lp-star,

                .prince-right-wrap,
                .prince-main-panel,
                .prince-main-pill,
                .prince-main-icon,
                .prince-main-title,
                .prince-main-desc,
                .prince-info-box,
                .prince-floating-card,
                .prince-floating-prince,
                .prince-floating-date,
                .prince-floating-wish,
                .prince-hero-orb,
                .prince-hero-spark,

                .prince-highlight-card,
                .prince-highlight-number,
                .baby-card,
                .baby-photo,
                .baby-placeholder,
                .baby-role,
                .prince-card,
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
                        entry.target.classList.add('prince-show');
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
