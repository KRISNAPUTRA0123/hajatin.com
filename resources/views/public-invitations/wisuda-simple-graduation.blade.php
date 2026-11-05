<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Wisuda') . ' ' . ($invitation->title ?: 'Simple Graduation'));
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
            color: #1f2937;
            background:
                radial-gradient(circle at top left, rgba(126, 211, 151, .18), transparent 26%),
                radial-gradient(circle at top right, rgba(223, 246, 231, .75), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, #fafffc 48%, #ffffff 100%);
        }

        .simple-shell {
            width: min(100%, 1220px);
            margin: 0 auto;
            padding: 24px;
        }

        .simple-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 40px;
            background:
                radial-gradient(circle at 10% 12%, rgba(197, 240, 211, .42), transparent 22%),
                radial-gradient(circle at 92% 9%, rgba(229, 244, 233, .7), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(249,253,250,.98));
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 30px 80px rgba(31, 41, 55, .08);
        }

        .simple-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(68, 91, 76, .07) 1.2px, transparent 1.2px);
            background-size: 22px 22px;
            opacity: .4;
            pointer-events: none;
            z-index: 0;
        }

        .simple-wrap > * {
            position: relative;
            z-index: 1;
        }

        .simple-section {
            min-height: 100vh;
            padding: 92px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .simple-section.compact {
            min-height: auto;
            padding-top: 82px;
            padding-bottom: 82px;
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

        .simple-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            margin: 18px auto 0;
            width: fit-content;
            max-width: calc(100% - 24px);
            display: flex;
            gap: 6px;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 12px 28px rgba(31, 41, 55, .08);
            overflow-x: auto;
        }

        .simple-nav a {
            text-decoration: none;
            color: #557062;
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .simple-nav a:hover {
            background: rgba(76, 175, 80, .08);
            color: var(--simple-primary);
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
            background: rgba(255,255,255,.96);
            box-shadow: 0 14px 30px rgba(31, 41, 55, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: rgba(197, 240, 211, .75);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .simple-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--simple-primary);
        }

        .simple-label::before {
            content: "";
            width: 34px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
            display: inline-block;
        }

        .simple-title {
            color: var(--simple-ink);
            line-height: .95;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .simple-gradient {
            background: linear-gradient(135deg, var(--simple-ink), var(--simple-primary), var(--simple-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .simple-btn {
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
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
            box-shadow: 0 16px 34px rgba(76, 175, 80, .18);
        }

        .simple-btn.secondary {
            background: #ffffff;
            color: #23324a;
            border: 1px solid rgba(50, 82, 58, .12);
            box-shadow: 0 10px 24px rgba(31, 41, 55, .08);
        }

        .simple-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 24px;
        }

        .simple-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 10px 24px rgba(31, 41, 55, .06);
            color: #567060;
            font-size: 12px;
            font-weight: 900;
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 42px;
            align-items: center;
        }

        .hero-copy {
            max-width: 660px;
        }

        .hero-title {
            font-size: clamp(3.2rem, 7vw, 6.2rem);
            margin: 20px 0 0;
        }

        .hero-desc {
            margin-top: 24px;
            color: #5d7265;
            font-size: 1.06rem;
            line-height: 1.95;
            max-width: 620px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 36px;
        }

        .hero-stat {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 14px 30px rgba(31, 41, 55, .06);
            border-radius: 28px;
            padding: 22px;
            text-align: center;
        }

        .hero-stat::after {
            content: "";
            position: absolute;
            width: 88px;
            height: 88px;
            right: -28px;
            bottom: -28px;
            border-radius: 999px;
            background: rgba(201, 231, 208, .55);
        }

        .hero-stat strong {
            position: relative;
            z-index: 2;
            display: block;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            color: var(--simple-ink);
        }

        .hero-stat span {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 10px;
            font-size: 11px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 900;
            color: #7f9483;
        }

        .hero-card-stack {
            position: relative;
            min-height: 620px;
        }

        .hero-card-back {
            position: absolute;
            inset: 40px 0 0 80px;
            border-radius: 40px;
            background: linear-gradient(180deg, rgba(228, 244, 232, .85), rgba(248, 252, 249, .95));
            border: 1px solid rgba(50, 82, 58, .08);
            transform: rotate(4deg);
        }

        .hero-main-card {
            position: relative;
            z-index: 2;
            min-height: 600px;
            border-radius: 42px;
            background: linear-gradient(180deg, #ffffff, #fbfefb);
            border: 1px solid rgba(50, 82, 58, .10);
            box-shadow: 0 24px 56px rgba(31, 41, 55, .10);
            padding: 30px;
            overflow: hidden;
        }

        .hero-main-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 32px;
            border: 2px dashed rgba(151, 185, 159, .45);
            pointer-events: none;
        }

        .hero-flower {
            position: absolute;
            z-index: 1;
            opacity: .18;
            pointer-events: none;
        }

        .hero-flower.top-left {
            width: 150px;
            top: 18px;
            left: 14px;
            transform: rotate(-12deg);
        }

        .hero-flower.bottom-right {
            width: 180px;
            right: 10px;
            bottom: 16px;
            transform: rotate(14deg);
        }

        .hero-cover-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .10;
        }

        .hero-card-content {
            position: relative;
            z-index: 2;
            min-height: 540px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            color: var(--simple-primary);
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 12px 24px rgba(31, 41, 55, .06);
        }

        .hero-mini-card {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 15% 10%, rgba(222, 245, 228, .75), transparent 32%),
                radial-gradient(circle at 88% 82%, rgba(232, 247, 236, .9), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,255,255,.94));
            border: 1px solid rgba(50, 82, 58, .10);
            box-shadow: 0 18px 42px rgba(31, 41, 55, .08);
            border-radius: 34px;
            padding: 34px 30px 30px;
            max-width: 340px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-mini-card::before {
            content: "";
            position: absolute;
            inset: 12px;
            border-radius: 26px;
            border: 1px dashed rgba(91, 132, 101, .20);
            pointer-events: none;
        }

        .hero-mini-card::after {
            content: "";
            position: absolute;
            width: 110px;
            height: 110px;
            right: -44px;
            bottom: -44px;
            border-radius: 999px;
            background: rgba(207, 234, 214, .58);
            pointer-events: none;
        }

        .mini-flower {
            position: absolute;
            width: 118px;
            opacity: .12;
            pointer-events: none;
            z-index: 1;
        }

        .mini-flower-left {
            left: -30px;
            top: 16px;
            transform: rotate(-16deg);
        }

        .mini-flower-right {
            right: -34px;
            bottom: 12px;
            transform: rotate(14deg);
        }

        .mini-top {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .mini-icon {
            width: 82px;
            height: 82px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 35% 30%, #ffffff, rgba(230, 246, 235, .95));
            border: 1px solid rgba(50, 82, 58, .12);
            box-shadow:
                inset 0 0 0 8px rgba(255,255,255,.62),
                0 12px 26px rgba(31, 41, 55, .07);
        }

        .mini-icon img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .mini-label {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 13px;
            border-radius: 999px;
            background: rgba(232, 247, 236, .88);
            color: var(--simple-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .mini-divider {
            position: relative;
            z-index: 2;
            width: 74px;
            height: 8px;
            margin: 24px auto 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
            opacity: .8;
        }

        .hero-mini-card h3 {
            position: relative;
            z-index: 2;
            margin: 0 auto;
            max-width: 270px;
            color: var(--simple-ink);
            font-size: clamp(2rem, 3.6vw, 2.8rem);
            line-height: 1.05;
            letter-spacing: -.045em;
            font-weight: 950;
            text-align: center;
        }

        .hero-mini-card p {
            position: relative;
            z-index: 2;
            margin: 20px auto 0;
            max-width: 280px;
            text-align: center;
            color: #5f7467;
            line-height: 1.9;
        }

        .mini-bottom-note {
            position: relative;
            z-index: 2;
            width: fit-content;
            margin: 24px auto 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 10px 22px rgba(31, 41, 55, .06);
            color: var(--simple-ink);
            font-size: 12px;
        }

        .mini-bottom-note strong {
            font-weight: 900;
        }

        .soft-about-grid {
            display: grid;
            gap: 20px;
            margin-top: 36px;
            justify-content: center;
        }

        .soft-about-grid.count-1 {
            grid-template-columns: minmax(280px, 380px);
        }

        .soft-about-grid.count-2 {
            grid-template-columns: repeat(2, minmax(280px, 360px));
        }

        .soft-about-grid.count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .about-soft-card {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 28px;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 16px 36px rgba(31, 41, 55, .07);
        }

        .about-soft-card::after {
            content: "";
            position: absolute;
            right: -14px;
            bottom: -14px;
            width: 95px;
            height: 95px;
            border-radius: 999px;
            background: rgba(212, 233, 217, .65);
        }

        .about-soft-number {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            font-size: 18px;
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
            box-shadow: 0 12px 24px rgba(76, 175, 80, .18);
        }

        .about-soft-card h3 {
            margin-top: 18px;
            color: var(--simple-ink);
            font-size: 1.38rem;
            font-weight: 900;
        }

        .about-soft-card p {
            margin-top: 10px;
            color: #5f7467;
            line-height: 1.85;
        }

        .graduate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 36px;
        }

        .graduate-grid.single-graduate {
            grid-template-columns: minmax(0, 380px);
            justify-content: center;
        }

        .graduate-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 18px 38px rgba(31, 41, 55, .08);
            border-radius: 32px;
            padding: 24px;
            text-align: left;
        }

        .graduate-card::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            right: -45px;
            top: -45px;
            border-radius: 999px;
            background: rgba(229, 244, 233, .75);
        }

        .graduate-card::after {
            content: "";
            position: absolute;
            width: 85px;
            height: 85px;
            left: -25px;
            bottom: -25px;
            border-radius: 999px;
            background: rgba(204, 234, 211, .35);
        }

        .graduate-photo,
        .graduate-placeholder {
            width: 122px;
            height: 122px;
            border-radius: 30px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff, #f5fbf6);
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 12px 28px rgba(31, 41, 55, .08);
            font-size: 42px;
            font-weight: 950;
            color: var(--simple-primary);
        }

        .graduate-role {
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(76, 175, 80, .10);
            color: var(--simple-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .graduate-card h3 {
            margin-top: 16px;
            color: var(--simple-ink);
            font-size: 1.7rem;
            font-weight: 900;
        }

        .graduate-card p {
            color: #5f7467;
            margin-top: 8px;
            line-height: 1.7;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 40px;
            align-items: start;
        }

        .detail-card {
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 18px 42px rgba(31, 41, 55, .08);
            border-radius: 34px;
            padding: 28px;
        }

        .detail-card h3 {
            color: var(--simple-ink);
            font-size: 2rem;
            font-weight: 900;
            margin: 0;
        }

        .detail-list {
            display: grid;
            gap: 14px;
            margin-top: 22px;
        }

        .detail-item {
            display: grid;
            grid-template-columns: 110px 1fr;
            gap: 14px;
            padding: 16px 0;
            border-top: 1px dashed rgba(50, 82, 58, .16);
        }

        .detail-item small {
            color: #7c9080;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 950;
        }

        .detail-item strong {
            color: var(--simple-ink);
            line-height: 1.65;
            font-weight: 900;
        }

        .line-date,
        .line-time {
            display: inline-flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            white-space: normal;
            line-height: 1.6;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .countdown-card {
            background: linear-gradient(180deg, #ffffff, #f8fcf8);
            border: 1px solid rgba(50, 82, 58, .08);
            border-radius: 24px;
            text-align: center;
            padding: 20px 12px;
            box-shadow: 0 10px 24px rgba(31, 41, 55, .05);
        }

        .countdown-number {
            display: block;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            color: var(--simple-ink);
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: #8a9c8d;
            font-size: 11px;
            letter-spacing: .16em;
            font-weight: 900;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 20px;
            overflow: hidden;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 16px 34px rgba(31, 41, 55, .07);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 300px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
            background: linear-gradient(180deg, #ffffff, #f7fcf8);
            color: var(--simple-ink);
            text-decoration: none;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-item {
            background: #ffffff;
            border-radius: 26px;
            padding: 10px;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 16px 36px rgba(31, 41, 55, .08);
        }

        .gallery-item:nth-child(2) {
            transform: rotate(-2deg);
        }

        .gallery-item:nth-child(3) {
            transform: rotate(2deg);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            border-radius: 20px;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 360px));
            gap: 18px;
            justify-content: center;
            margin-top: 34px;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 16px 34px rgba(31, 41, 55, .07);
            border-radius: 30px;
            padding: 24px;
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            right: -18px;
            top: -18px;
            border-radius: 999px;
            background: rgba(220, 241, 225, .65);
        }

        .gift-title {
            color: var(--simple-ink);
            font-size: 1.2rem;
            font-weight: 900;
        }

        .gift-sub {
            color: #6b816f;
            margin-top: 6px;
            line-height: 1.7;
        }

        .gift-box {
            margin-top: 18px;
            background: #f9fcfa;
            border: 1px solid rgba(50, 82, 58, .08);
            border-radius: 20px;
            padding: 16px;
        }

        .gift-box small {
            display: block;
            color: #7c9080;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .gift-box strong {
            display: block;
            margin-top: 8px;
            color: var(--simple-ink);
            font-size: 18px;
            line-height: 1.5;
        }

        .gift-copy-btn {
            margin-top: 16px;
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 16px;
            padding: 12px 16px;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary));
        }

        .rsvp-wrap {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: #ffffff;
            border: 1px solid rgba(50, 82, 58, .08);
            box-shadow: 0 16px 34px rgba(31, 41, 55, .07);
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
            color: var(--simple-ink);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: #7c9080;
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
            background: rgba(76, 175, 80, .10);
            color: var(--simple-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 780px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(228, 244, 232, .72), rgba(255,255,255,.95));
            border: 1px solid rgba(50, 82, 58, .08);
            border-radius: 38px;
            padding: 40px 34px;
            box-shadow: 0 20px 44px rgba(31, 41, 55, .07);
            position: relative;
            overflow: hidden;
        }

        .closing-card .flower-a,
        .closing-card .flower-b {
            position: absolute;
            width: 120px;
            opacity: .12;
            pointer-events: none;
        }

        .closing-card .flower-a {
            left: 10px;
            top: 10px;
            transform: rotate(-10deg);
        }

        .closing-card .flower-b {
            right: 10px;
            bottom: 10px;
            transform: rotate(12deg);
        }

        @media (max-width: 1100px) {
            .hero-layout,
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .hero-card-stack {
                min-height: auto;
            }

            .hero-card-back {
                display: none;
            }
        }

        @media (max-width: 980px) {
            .simple-shell {
                padding: 16px;
            }

            .simple-section {
                padding: 82px 38px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .summary-grid,
            .hero-stats,
            .countdown-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .soft-about-grid.count-3 {
                grid-template-columns: repeat(2, minmax(280px, 360px));
            }
        }

        @media (max-width: 640px) {
            .simple-shell {
                padding: 0;
            }

            .simple-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .simple-section {
                padding: 74px 24px;
            }

            .simple-section.compact {
                padding-top: 68px;
                padding-bottom: 68px;
            }

            .hero-mini-card {
                max-width: 100%;
                padding: 30px 24px 28px;
                border-radius: 30px;
            }

            .hero-mini-card h3 {
                font-size: clamp(1.9rem, 9vw, 2.5rem);
            }

            .mini-flower {
                width: 96px;
            }

            .mini-icon {
                width: 74px;
                height: 74px;
            }

            .mini-icon img {
                width: 42px;
                height: 42px;
            }

            .hero-layout,
            .detail-layout,
            .gallery-grid,
            .summary-grid,
            .hero-stats,
            .countdown-grid {
                grid-template-columns: 1fr;
            }

            .soft-about-grid,
            .soft-about-grid.count-1,
            .soft-about-grid.count-2,
            .soft-about-grid.count-3 {
                grid-template-columns: 1fr;
            }

            .detail-item {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .floating-actions {
                right: 10px;
            }

            .hero-title {
                font-size: clamp(2.8rem, 15vw, 4.6rem);
            }

            .hero-mini-card {
                max-width: 100%;
            }

            .hero-main-card {
                padding: 22px;
                min-height: auto;
            }

            .hero-card-content {
                min-height: auto;
                gap: 24px;
            }
        }

        /* =====================================================
        THEME SYNC FIX - SIMPLE GRADUATION
        Supaya warna mengikuti 6 theme editor
        ===================================================== */

        body {
            color: var(--simple-ink);
            background:
                radial-gradient(circle at top left, var(--simple-glow-1), transparent 26%),
                radial-gradient(circle at top right, var(--simple-glow-2), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, var(--simple-soft) 48%, #ffffff 100%) !important;
        }

        .simple-wrap {
            background:
                radial-gradient(circle at 10% 12%, color-mix(in srgb, var(--simple-primary) 10%, transparent), transparent 22%),
                radial-gradient(circle at 92% 9%, color-mix(in srgb, var(--simple-accent) 55%, transparent), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,.98), color-mix(in srgb, var(--simple-soft) 94%, white)) !important;
            border-color: color-mix(in srgb, var(--simple-primary) 10%, transparent) !important;
        }

        .simple-wrap::before {
            background-image:
                radial-gradient(circle, color-mix(in srgb, var(--simple-primary) 10%, transparent) 1.2px, transparent 1.2px) !important;
        }

        .simple-nav {
            border-color: color-mix(in srgb, var(--simple-primary) 10%, transparent) !important;
        }

        .simple-nav a,
        .hero-desc,
        .about-soft-card p,
        .graduate-card p,
        .gift-sub,
        .summary-card span,
        .countdown-label,
        .message-card p {
            color: var(--simple-text) !important;
        }

        .simple-nav a:hover,
        .simple-label,
        .hero-badge,
        .mini-label,
        .graduate-placeholder,
        .graduate-role,
        .message-badge {
            color: var(--simple-primary) !important;
        }

        .simple-label::before,
        .about-soft-number,
        .simple-btn,
        .gift-copy-btn {
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary)) !important;
        }

        .simple-btn {
            box-shadow: 0 16px 34px color-mix(in srgb, var(--simple-primary) 22%, transparent) !important;
        }

        .simple-btn.secondary {
            color: var(--simple-ink) !important;
            background: #ffffff !important;
            border-color: color-mix(in srgb, var(--simple-primary) 14%, transparent) !important;
        }

        .simple-pill,
        .hero-stat,
        .hero-main-card,
        .hero-mini-card,
        .about-soft-card,
        .graduate-card,
        .detail-card,
        .countdown-card,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card,
        .closing-card {
            border-color: color-mix(in srgb, var(--simple-primary) 10%, transparent) !important;
        }

        .simple-pill {
            color: var(--simple-text) !important;
        }

        .hero-card-back {
            background: linear-gradient(
                180deg,
                color-mix(in srgb, var(--simple-accent) 70%, white),
                color-mix(in srgb, var(--simple-soft) 95%, white)
            ) !important;
        }

        .hero-main-card {
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--simple-soft) 96%, white)) !important;
        }

        .hero-main-card::before {
            border-color: color-mix(in srgb, var(--simple-primary) 28%, transparent) !important;
        }

        .hero-stat::after,
        .about-soft-card::after,
        .graduate-card::before,
        .graduate-card::after,
        .gift-card::after,
        .hero-mini-card::after {
            background: color-mix(in srgb, var(--simple-accent) 68%, white) !important;
        }

        .hero-stat strong,
        .about-soft-card h3,
        .graduate-card h3,
        .detail-card h3,
        .detail-item strong,
        .countdown-number,
        .gift-title,
        .gift-box strong,
        .summary-card strong,
        .closing-card h3 {
            color: var(--simple-ink) !important;
        }

        .hero-stat span,
        .detail-item small,
        .gift-box small {
            color: var(--simple-text) !important;
        }

        .hero-mini-card {
            background:
                radial-gradient(circle at 15% 10%, color-mix(in srgb, var(--simple-accent) 72%, white), transparent 32%),
                radial-gradient(circle at 88% 82%, color-mix(in srgb, var(--simple-accent) 82%, white), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,255,255,.94)) !important;
        }

        .hero-mini-card::before {
            border-color: color-mix(in srgb, var(--simple-primary) 22%, transparent) !important;
        }

        .mini-icon {
            background:
                radial-gradient(circle at 35% 30%, #ffffff, color-mix(in srgb, var(--simple-accent) 76%, white)) !important;
            border-color: color-mix(in srgb, var(--simple-primary) 14%, transparent) !important;
        }

        .mini-label {
            background: color-mix(in srgb, var(--simple-accent) 72%, white) !important;
        }

        .mini-divider {
            background: linear-gradient(135deg, var(--simple-primary), var(--simple-secondary)) !important;
        }

        .mini-bottom-note {
            color: var(--simple-ink) !important;
            border-color: color-mix(in srgb, var(--simple-primary) 10%, transparent) !important;
        }

        .graduate-role,
        .message-badge {
            background: color-mix(in srgb, var(--simple-primary) 10%, white) !important;
        }

        .detail-item {
            border-top-color: color-mix(in srgb, var(--simple-primary) 16%, transparent) !important;
        }

        .countdown-card,
        .map-placeholder,
        .gift-box {
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--simple-soft) 94%, white)) !important;
        }

        .closing-card {
            background: linear-gradient(
                135deg,
                color-mix(in srgb, var(--simple-accent) 72%, white),
                rgba(255,255,255,.95)
            ) !important;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--simple-accent) 70%, white) !important;
        }

        /* =====================================================
        LUXURY SIMPLE GRADUATION ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        .simple-reveal,
        .simple-section > p,
        .simple-section > h1,
        .simple-section > h2,
        .simple-section > h3,
        .simple-label,
        .simple-title,
        .simple-gradient,
        .simple-nav,
        .hero-layout,
        .hero-copy,
        .hero-title,
        .hero-desc,
        .simple-pill-row,
        .simple-pill,
        .hero-actions,
        .hero-stats,
        .hero-stat,
        .hero-card-stack,
        .hero-card-back,
        .hero-main-card,
        .hero-card-content,
        .hero-badge,
        .hero-mini-card,
        .mini-icon,
        .mini-label,
        .mini-divider,
        .mini-bottom-note,
        .hero-flower,
        .mini-flower,
        .about-soft-card,
        .about-soft-number,
        .graduate-card,
        .graduate-photo,
        .graduate-placeholder,
        .graduate-role,
        .detail-card,
        .detail-item,
        .countdown-card,
        .map-card,
        .gallery-item,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .simple-btn {
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

        .simple-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .simple-nav {
            animation: simpleNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .hero-copy {
            animation: simpleHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) .12s both;
        }

        #opening .simple-label {
            animation: simpleFadeDown .85s ease .18s both;
        }

        #opening .hero-title {
            animation: simpleTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .hero-desc {
            animation: simpleFadeUp .85s ease .48s both;
        }

        #opening .simple-pill {
            animation: simpleFadeUp .85s ease .58s both;
        }

        #opening .hero-actions {
            animation: simpleFadeUp .85s ease .70s both;
        }

        #opening .hero-stat {
            animation: simpleFadeUp .9s ease .82s both;
        }

        #opening .hero-card-back {
            animation: simpleBackCardEnter 1s cubic-bezier(.2, .8, .2, 1) .20s both;
        }

        #opening .hero-main-card {
            animation:
                simpleMainCardEnter 1.12s cubic-bezier(.2, .8, .2, 1) .30s both,
                simpleCardFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .hero-mini-card {
            animation: simpleMiniCardEnter 1s cubic-bezier(.2, .8, .2, 1) .52s both;
        }

        #opening .mini-icon {
            animation:
                simpleIconPop .9s cubic-bezier(.2, .8, .2, 1) .72s both,
                simpleSoftPulse 3.2s ease-in-out 1.5s infinite;
        }

        /* Background lembut bergerak */
        .simple-wrap {
            animation: simpleWrapGlow 8s ease-in-out infinite alternate;
        }

        .simple-wrap::before {
            animation: simplePatternMove 18s linear infinite;
        }

        /* Ornamen bunga bergerak */
        .hero-flower.top-left,
        .mini-flower-left,
        .closing-card .flower-a {
            animation: simpleFlowerLeft 5.8s ease-in-out infinite;
        }

        .hero-flower.bottom-right,
        .mini-flower-right,
        .closing-card .flower-b {
            animation: simpleFlowerRight 6.2s ease-in-out .25s infinite;
        }

        /* Dekorasi card bergerak */
        .hero-stat::after,
        .hero-mini-card::after,
        .about-soft-card::after,
        .graduate-card::before,
        .graduate-card::after,
        .gift-card::after {
            animation: simpleDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label glow */
        .simple-label::before,
        .mini-divider {
            animation: simpleLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Button efek kilau */
        .simple-btn,
        button.simple-btn,
        .gift-copy-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .simple-btn::after,
        button.simple-btn::after,
        .gift-copy-btn::after,
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
            animation: simpleButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .hero-stat:hover,
            .hero-main-card:hover,
            .hero-mini-card:hover,
            .simple-pill:hover,
            .about-soft-card:hover,
            .graduate-card:hover,
            .detail-card:hover,
            .detail-item:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-item:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--simple-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--simple-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--simple-accent) 34%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.80) !important;
            }

            .gallery-item:hover img,
            .graduate-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }

            .simple-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--simple-primary) 12%, transparent);
            }
        }

        .gallery-item img,
        .graduate-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: simpleNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon dan angka pulse */
        .about-soft-number,
        .graduate-placeholder,
        .hero-stat strong,
        .gift-box strong,
        .message-badge {
            animation: simpleSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-item:nth-child(3n+1) {
            animation: simpleGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-item:nth-child(3n+2) {
            animation: simpleGalleryTwo 4.8s ease-in-out .18s infinite;
        }

        .gallery-item:nth-child(3n+3) {
            animation: simpleGalleryThree 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: simpleFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes simpleNavEnter {
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

        @keyframes simpleHeroCopyIn {
            from {
                opacity: 0;
                transform: translateX(-24px) translateY(34px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes simpleBackCardEnter {
            from {
                opacity: 0;
                transform: translateY(40px) rotate(0deg) scale(.94);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) rotate(4deg) scale(1);
                filter: blur(0);
            }
        }

        @keyframes simpleMainCardEnter {
            from {
                opacity: 0;
                transform: translateX(28px) translateY(36px) scale(.93) rotate(3deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes simpleCardFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes simpleMiniCardEnter {
            from {
                opacity: 0;
                transform: translateY(34px) scale(.92);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes simpleIconPop {
            from {
                opacity: 0;
                transform: translateY(-16px) scale(.76) rotate(-8deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes simpleFadeDown {
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

        @keyframes simpleFadeUp {
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

        @keyframes simpleTitleIn {
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

        @keyframes simpleWrapGlow {
            from {
                box-shadow:
                    0 30px 80px color-mix(in srgb, var(--simple-primary) 8%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 40px 118px color-mix(in srgb, var(--simple-primary) 13%, transparent),
                    0 0 58px color-mix(in srgb, var(--simple-accent) 38%, transparent);
            }
        }

        @keyframes simplePatternMove {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 132px 132px;
            }
        }

        @keyframes simpleFlowerLeft {
            0%, 100% {
                transform: rotate(-12deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(-7deg) translateY(-9px) scale(1.05);
            }
        }

        @keyframes simpleFlowerRight {
            0%, 100% {
                transform: rotate(14deg) translateY(0) scale(1);
            }
            50% {
                transform: rotate(9deg) translateY(-9px) scale(1.05);
            }
        }

        @keyframes simpleDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes simpleLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--simple-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--simple-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes simpleButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes simpleNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--simple-primary) 16%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--simple-primary) 38%, transparent),
                    0 0 34px color-mix(in srgb, var(--simple-accent) 48%, transparent);
            }
        }

        @keyframes simpleSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes simpleGalleryOne {
            0%, 100% {
                transform: translateY(0) rotate(-.4deg);
            }
            50% {
                transform: translateY(-7px) rotate(-.9deg);
            }
        }

        @keyframes simpleGalleryTwo {
            0%, 100% {
                transform: translateY(0) rotate(-2deg);
            }
            50% {
                transform: translateY(-7px) rotate(-1.2deg);
            }
        }

        @keyframes simpleGalleryThree {
            0%, 100% {
                transform: translateY(0) rotate(2deg);
            }
            50% {
                transform: translateY(-7px) rotate(1.2deg);
            }
        }

        @keyframes simpleFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .simple-reveal,
            .simple-section > p,
            .simple-section > h1,
            .simple-section > h2,
            .simple-section > h3,
            .simple-label,
            .simple-title,
            .simple-gradient,
            .simple-nav,
            .hero-layout,
            .hero-copy,
            .hero-title,
            .hero-desc,
            .simple-pill-row,
            .simple-pill,
            .hero-actions,
            .hero-stats,
            .hero-stat,
            .hero-card-stack,
            .hero-card-back,
            .hero-main-card,
            .hero-card-content,
            .hero-badge,
            .hero-mini-card,
            .mini-icon,
            .mini-label,
            .mini-divider,
            .mini-bottom-note,
            .hero-flower,
            .mini-flower,
            .about-soft-card,
            .about-soft-number,
            .graduate-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .detail-card,
            .detail-item,
            .countdown-card,
            .map-card,
            .gallery-item,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .simple-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-item:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .hero-main-card {
                animation:
                    simpleFadeUp .9s ease .3s both,
                    simpleFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .simple-reveal,
            .simple-section > p,
            .simple-section > h1,
            .simple-section > h2,
            .simple-section > h3,
            .simple-label,
            .simple-title,
            .simple-gradient,
            .simple-nav,
            .hero-layout,
            .hero-copy,
            .hero-title,
            .hero-desc,
            .simple-pill-row,
            .simple-pill,
            .hero-actions,
            .hero-stats,
            .hero-stat,
            .hero-card-stack,
            .hero-card-back,
            .hero-main-card,
            .hero-card-content,
            .hero-badge,
            .hero-mini-card,
            .mini-icon,
            .mini-label,
            .mini-divider,
            .mini-bottom-note,
            .hero-flower,
            .mini-flower,
            .about-soft-card,
            .about-soft-number,
            .graduate-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .detail-card,
            .detail-item,
            .countdown-card,
            .map-card,
            .gallery-item,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .simple-btn,
            .simple-wrap,
            .simple-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-number,
            .gift-box strong,
            .message-badge {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        /* =====================================================
        FIX LINGKARAN CARD ABOUT & GRADUATES
        Lingkaran tetap tampil, tapi berada di belakang konten
        ===================================================== */

        /* ABOUT CARD */
        #about .about-soft-card {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        #about .about-soft-card::after {
            z-index: 0 !important;
            pointer-events: none;
            opacity: 0.28 !important;
        }

        #about .about-soft-card > * {
            position: relative;
            z-index: 2 !important;
        }


        /* GRADUATE CARD */
        #graduates .graduate-card {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        #graduates .graduate-card::before,
        #graduates .graduate-card::after {
            z-index: 0 !important;
            pointer-events: none;
            opacity: 0.24 !important;
        }

        #graduates .graduate-card > * {
            position: relative;
            z-index: 2 !important;
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
            'ink' => '#4a1623',
            'text' => '#6b4450',
            'soft' => '#fff8fa',
            'glow1' => 'rgba(244, 63, 94, .10)',
            'glow2' => 'rgba(253, 226, 233, .72)',
        ],

        'emerald' => [
            'primary' => '#2f855a',
            'secondary' => '#68a67d',
            'accent' => '#e4f6eb',
            'ink' => '#163d2c',
            'text' => '#557266',
            'soft' => '#fbfffd',
            'glow1' => 'rgba(47, 133, 90, .09)',
            'glow2' => 'rgba(228, 246, 235, .74)',
        ],

        'navy' => [
            'primary' => '#3b6ea8',
            'secondary' => '#7aa6d8',
            'accent' => '#e9f3ff',
            'ink' => '#17263d',
            'text' => '#5a6a7d',
            'soft' => '#fbfdff',
            'glow1' => 'rgba(59, 110, 168, .08)',
            'glow2' => 'rgba(233, 243, 255, .78)',
        ],

        'rose' => [
            'primary' => '#d16d8b',
            'secondary' => '#e99caf',
            'accent' => '#fff0f5',
            'ink' => '#5a2c3c',
            'text' => '#755d66',
            'soft' => '#fffafb',
            'glow1' => 'rgba(209, 109, 139, .10)',
            'glow2' => 'rgba(255, 240, 245, .82)',
        ],

        'gold' => [
            'primary' => '#b88930',
            'secondary' => '#d8ad5a',
            'accent' => '#fff4d7',
            'ink' => '#4c3818',
            'text' => '#74634d',
            'soft' => '#fffdf7',
            'glow1' => 'rgba(184, 137, 48, .09)',
            'glow2' => 'rgba(255, 244, 215, .78)',
        ],

        'slate' => [
            'primary' => '#64748b',
            'secondary' => '#94a3b8',
            'accent' => '#f1f5f9',
            'ink' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#ffffff',
            'glow1' => 'rgba(100, 116, 139, .07)',
            'glow2' => 'rgba(241, 245, 249, .78)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];

    $firstPhoto = $invitation->photos->first();

    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Wisuda';
    $eventName = $invitation->event_name ?: 'Wisuda';
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
        "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.\n\n" .
        "Wassalamu'alaikum Wr. Wb.";

    $shareText = urlencode($shareMessage);

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));

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

            $calendarTitle = trim(($invitation->event_name ?: 'Wisuda') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan wisuda') . "\n\nLink Undangan: " . $shareUrl);

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

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Graduation Session' : 'Lokasi Acara');

    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang wisuda online atau webinar.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $graduates = $invitation->people ?? collect();
    $graduateCount = $graduates->count();

    $highlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $highlights->count();

    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --simple-primary: {{ $activeTheme['primary'] }};
        --simple-secondary: {{ $activeTheme['secondary'] }};
        --simple-accent: {{ $activeTheme['accent'] }};
        --simple-ink: {{ $activeTheme['ink'] }};
        --simple-text: {{ $activeTheme['text'] }};
        --simple-soft: {{ $activeTheme['soft'] }};
        --simple-glow-1: {{ $activeTheme['glow1'] }};
        --simple-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="simple-shell">
        <div class="simple-wrap">

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

            <nav class="simple-nav">
                <a href="#graduates">Wisudawan</a>
                <a href="#detail">Detail</a>
                @if ($invitation->gifts->count())
                    <a href="#gift">Amplop</a>
                @endif
                <a href="#message">RSVP</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="simple-section">
                <div class="hero-layout">
                    <div class="hero-copy">
                        <p class="simple-label">
                            Wisuda & Syukuran Kelulusan
                        </p>

                        <h1 class="simple-title simple-gradient hero-title responsive-text">
                            {{ $invitation->title ?: 'Simple Graduation' }}
                        </h1>

                        <p class="hero-desc responsive-text">
                            {{ $invitation->description ?: 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen spesial kelulusan ini.' }}
                        </p>

                        <div class="simple-pill-row">
                            <span class="simple-pill">{{ $invitation->event_name ?: 'Wisuda' }}</span>
                            <span class="simple-pill">{{ $invitation->host_name ?: 'Keluarga Besar' }}</span>
                            <span class="simple-pill">{{ $isOnlineEvent ? 'Online' : 'Offline' }}</span>
                        </div>

                        <div class="hero-actions">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="simple-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="simple-btn">Lihat Detail</a>
                            @endif

                            <a href="#detail" class="simple-btn secondary">Detail Acara</a>
                            <a href="#message" class="simple-btn secondary">Kirim Ucapan</a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat">
                                <strong>{{ max($graduateCount, 1) }}</strong>
                                <span>Tokoh Utama</span>
                            </div>
                            <div class="hero-stat">
                                <strong>{{ $highlightCount }}</strong>
                                <span>Highlight</span>
                            </div>
                            <div class="hero-stat">
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

                    <div class="hero-card-stack">
                        <div class="hero-card-back"></div>

                        <div class="hero-main-card">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover" class="hero-cover-img">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto" class="hero-cover-img">
                            @endif

                            <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="hero-flower top-left">
                            <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="hero-flower bottom-right">

                            <div class="hero-card-content">

                                <div class="hero-mini-card">
                                    <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="mini-flower mini-flower-left">
                                    <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="mini-flower mini-flower-right">

                                    <div class="mini-top">
                                        <div class="mini-icon">
                                            <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga">
                                        </div>

                                        <span class="mini-label">
                                            Yang Berbahagia
                                        </span>
                                    </div>

                                    <div class="mini-divider"></div>

                                    <h3 class="responsive-text">
                                        {{ $invitation->event_name ?: 'Wisuda & Syukuran Kelulusan' }}
                                    </h3>

                                    <p class="responsive-text">
                                        {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Dengan penuh rasa syukur, doa, dan kebahagiaan bersama keluarga.' }}
                                    </p>

                                    <div class="mini-bottom-note">
                                        <strong>Doa & Kebahagiaan</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            <section id="about" class="simple-section compact text-center">
                <p class="simple-label justify-center">Tentang Acara</p>

                <h2 class="simple-title text-5xl md:text-6xl mt-6 responsive-text">
                    Momen Kelulusan yang Hangat dan Berkesan
                </h2>

                <p class="text-slate-600 mt-4 max-w-3xl mx-auto leading-8 responsive-text">
                    {{ $invitation->host_name
                        ? 'Acara ini dipersembahkan oleh ' . $invitation->host_name . ' sebagai wujud rasa syukur atas pencapaian yang telah diraih.'
                        : 'Acara ini dibuat untuk merayakan hari kelulusan dengan nuansa elegan, putih bersih, sentuhan hijau, dan suasana yang hangat.' }}
                </p>

                @if ($highlightCount > 0)
                    <div class="soft-about-grid {{ $highlightGridClass }}">
                        @foreach ($highlights as $index => $highlight)
                            <div class="about-soft-card text-left">
                                <div class="about-soft-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <h3 class="responsive-text">
                                    {{ $highlight['title'] ?: 'Highlight Acara' }}
                                </h3>

                                <p class="responsive-text">
                                    {{ $highlight['description'] ?: 'Deskripsi highlight akan tampil di sini.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="soft-about-grid count-2">
                        <div class="about-soft-card text-left">
                            <div class="about-soft-number">01</div>
                            <h3>Nuansa Putih yang Elegan</h3>
                            <p>Desain utama dibuat cerah, lembut, dan bersih agar momen wisuda terasa lebih istimewa.</p>
                        </div>

                        <div class="about-soft-card text-left">
                            <div class="about-soft-number">02</div>
                            <h3>Syukur & Kebahagiaan</h3>
                            <p>Undangan ini cocok untuk merayakan keberhasilan, rasa syukur, dan kebersamaan keluarga besar.</p>
                        </div>
                    </div>
                @endif
            </section>

            {{-- GRADUATES --}}
            <section id="graduates" class="simple-section compact text-center">
                <p class="simple-label justify-center">Tokoh Utama</p>

                <h2 class="simple-title text-5xl md:text-6xl mt-6">
                    Wisudawan / Wisudawati
                </h2>

                <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-7">
                    Tampilkan tokoh utama wisuda, keluarga, atau pihak yang berbahagia.
                </p>

                <div class="graduate-grid {{ $graduateCount <= 1 ? 'single-graduate' : '' }}">
                    @forelse ($graduates as $person)
                        <div class="graduate-card">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="graduate-photo"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="graduate-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'W', 0, 1)) }}
                                </div>
                            @endif

                            <span class="graduate-role">
                                {{ $person->subtitle ?: 'Wisudawan / Wisudawati' }}
                            </span>

                            <h3 class="responsive-text">
                                {{ $person->name ?: 'Nama Tokoh Utama' }}
                            </h3>

                            @if (!empty($person->description))
                                <p class="responsive-text">{{ $person->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="graduate-card">
                            <div class="graduate-placeholder">W</div>
                            <span class="graduate-role">Wisudawan / Wisudawati</span>
                            <h3>Nama Belum Ditambahkan</h3>
                            <p>Data wisudawan / wisudawati belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="simple-section compact">
                <div class="text-center">
                    <p class="simple-label justify-center">Detail Acara</p>

                    <h2 class="simple-title text-5xl md:text-6xl mt-6">
                        Informasi Kehadiran
                    </h2>

                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-8">
                        Informasi lengkap jadwal, waktu, lokasi, dan akses menuju acara.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="detail-card">
                        <h3>Graduation Pass</h3>

                        <div class="detail-list">
                            <div class="detail-item">
                                <small class="ml-2">Acara</small>
                                <strong class="responsive-text ml-2">{{ $invitation->event_name ?: 'Wisuda' }}</strong>
                            </div>

                            <div class="detail-item">
                                <small class="ml-2">Tanggal</small>
                                <strong class="line-date ml-2">
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
                                <small class="ml-2">Waktu</small>
                                <strong class="line-time ml-2">
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
                                <small class="ml-2">Mode</small>
                                <strong class="responsive-text ml-2">{{ $isOnlineEvent ? 'Online Session' : 'Offline Session' }}</strong>
                            </div>

                            <div class="detail-item">
                                <small class="ml-2">{{ $accessTypeLabel }}</small>
                                <strong class="responsive-text ml-2">{{ $accessName }}</strong>
                            </div>

                            <div class="detail-item">
                                <small class="ml-2">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</small>
                                <strong class="responsive-text ml-2">{{ $accessDescription }}</strong>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="simple-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="simple-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
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

                            <h3 class="mt-3">Countdown Wisuda</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Siapkan waktu terbaikmu untuk hadir di hari bahagia ini.
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
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $accessName }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--simple-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $accessName }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">Link online belum ditambahkan.</p>
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
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $accessName }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--simple-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $accessName }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $accessDescription }}</p>
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
            @if ($invitation->photos->count())
                <section id="gallery" class="simple-section compact text-center">
                    <p class="simple-label justify-center">Galeri</p>

                    <h2 class="simple-title text-5xl md:text-6xl mt-6">
                        Momen Wisuda
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DIGITAL GIFT --}}
            @if ($invitation->gifts->count())
                <section id="gift" class="simple-section compact text-center">
                    <p class="simple-label justify-center">Amplop Digital</p>

                    <h2 class="simple-title text-5xl md:text-6xl mt-6">
                        Kirim Tanda Kasih
                    </h2>

                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-8">
                        Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi di bawah ini.
                    </p>

                    <div class="gift-grid text-left">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $bankName = $gift->bank_name ?? null;
                                $accountName = $gift->account_name ?? null;
                                $accountNumber = $gift->account_number ?? null;
                                $ewalletName = $gift->ewallet_name ?? null;
                                $ewalletNumber = $gift->ewallet_number ?? null;
                            @endphp

                            <div class="gift-card">
                                @if ($bankName || $accountNumber)
                                    <div class="gift-title">{{ $bankName ?: 'Rekening Bank' }}</div>
                                    <p class="gift-sub responsive-text">{{ $accountName ?: 'Atas nama penerima' }}</p>

                                    <div class="gift-box">
                                        <small>Nomor Rekening</small>
                                        <strong class="responsive-text">{{ $accountNumber ?: '-' }}</strong>
                                    </div>

                                    @if ($accountNumber)
                                        <button type="button" class="gift-copy-btn" data-copy="{{ $accountNumber }}">
                                            Salin Nomor Rekening
                                        </button>
                                    @endif
                                @elseif ($ewalletName || $ewalletNumber)
                                    <div class="gift-title">{{ $ewalletName ?: 'E-Wallet' }}</div>
                                    <p class="gift-sub responsive-text">{{ $accountName ?: 'Atas nama penerima' }}</p>

                                    <div class="gift-box">
                                        <small>Nomor</small>
                                        <strong class="responsive-text">{{ $ewalletNumber ?: '-' }}</strong>
                                    </div>

                                    @if ($ewalletNumber)
                                        <button type="button" class="gift-copy-btn" data-copy="{{ $ewalletNumber }}">
                                            Salin Nomor
                                        </button>
                                    @endif
                                @else
                                    <div class="gift-title">Amplop Digital</div>
                                    <p class="gift-sub">Data amplop digital belum lengkap.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="simple-section compact">
                <div class="text-center">
                    <p class="simple-label justify-center">RSVP & Ucapan</p>

                    <h2 class="simple-title text-5xl md:text-6xl mt-6">
                        Konfirmasi Kehadiran
                    </h2>

                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto">
                        Silakan isi form untuk konfirmasi kehadiran dan kirim ucapan terbaik.
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
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
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
                            <label class="uk-label">Ucapan / Pesan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis ucapan atau pesan..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full simple-btn">
                            Kirim Konfirmasi
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
            <section id="closing" class="simple-section text-center">
                <div class="closing-card">
                    <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="flower-a">
                    <img src="{{ asset('assets/icons/Bunga.png') }}" alt="Bunga" class="flower-b">

                    <p class="simple-label justify-center">
                        Sampai Jumpa
                    </p>

                    <h2 class="simple-title simple-gradient text-5xl md:text-7xl mt-8 responsive-text">
                        Terima Kasih
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda.
                        Semoga momen kelulusan ini membawa kebahagiaan dan keberkahan bagi kita semua.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
                        {{ $invitation->title ?: 'Simple Graduation' }}
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

            document.querySelectorAll('[data-copy]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const text = this.getAttribute('data-copy');

                    try {
                        await navigator.clipboard.writeText(text);
                        const original = this.textContent;
                        this.textContent = 'Berhasil Disalin';
                        setTimeout(() => {
                            this.textContent = original;
                        }, 1800);
                    } catch (error) {
                        alert('Gagal menyalin teks.');
                    }
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .simple-section > p,
                .simple-section > h1,
                .simple-section > h2,
                .simple-section > h3,
                .simple-label,
                .simple-title,
                .simple-gradient,
                .simple-nav,
                .hero-layout,
                .hero-copy,
                .hero-title,
                .hero-desc,
                .simple-pill-row,
                .simple-pill,
                .hero-actions,
                .hero-stats,
                .hero-stat,
                .hero-card-stack,
                .hero-card-back,
                .hero-main-card,
                .hero-card-content,
                .hero-badge,
                .hero-mini-card,
                .mini-icon,
                .mini-label,
                .mini-divider,
                .mini-bottom-note,
                .hero-flower,
                .mini-flower,
                .about-soft-card,
                .about-soft-number,
                .graduate-card,
                .graduate-photo,
                .graduate-placeholder,
                .graduate-role,
                .detail-card,
                .detail-item,
                .countdown-card,
                .map-card,
                .gallery-item,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .simple-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('simple-show');
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
