<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Graduation Day') . ' ' . ($invitation->title ?: 'Wisuda Graduation Day'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--grad-dark);
            background:
                radial-gradient(circle at top left, var(--grad-glow-1), transparent 34%),
                radial-gradient(circle at top right, var(--grad-glow-2), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, var(--grad-soft) 48%, #ffffff 100%);
        }

        .grad-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .grad-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 46px;
            background:
                radial-gradient(circle at 12% 10%, color-mix(in srgb, var(--grad-accent) 24%, transparent), transparent 26%),
                radial-gradient(circle at 86% 8%, color-mix(in srgb, var(--grad-primary) 16%, transparent), transparent 28%),
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,255,255,.94));
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            box-shadow: 0 36px 96px rgba(26, 35, 64, .11);
        }

        .grad-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .32;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--grad-primary) 7%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--grad-primary) 7%, transparent) 1px, transparent 1px);
            background-size: 34px 34px;
        }

        .grad-wrap > * {
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

        .grad-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .grad-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .grad-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--grad-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-label::before {
            content: "";
            width: 38px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-accent));
        }

        .grad-title {
            color: var(--grad-dark);
            font-weight: 950;
            letter-spacing: -.065em;
            line-height: .94;
        }

        .grad-gradient {
            background: linear-gradient(135deg, var(--grad-dark), var(--grad-primary), var(--grad-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .grad-btn {
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
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--grad-primary) 22%, transparent);
        }

        .grad-btn.secondary {
            color: var(--grad-dark);
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            box-shadow: 0 14px 30px rgba(26,35,64,.08);
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
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(26,35,64,.16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--grad-accent) 34%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .grad-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            width: fit-content;
            max-width: calc(100% - 26px);
            margin: 18px auto 0;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.86);
            backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(26,35,64,.08);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .grad-nav a {
            text-decoration: none;
            color: var(--grad-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .grad-nav a:hover {
            color: var(--grad-primary);
            background: color-mix(in srgb, var(--grad-primary) 9%, white);
        }

        .hero-grad {
            min-height: 100vh;
            padding: 82px 64px 54px;
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            gap: 38px;
            align-items: center;
        }

        .grad-hero-left {
            position: relative;
            min-width: 0;
        }

        .grad-top-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 12px 26px rgba(26,35,64,.07);
            color: var(--grad-primary);
            font-size: 12px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-top-badge span {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: white;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
        }

        .hero-grad-title {
            margin-top: 26px;
            font-size: clamp(3.4rem, 7vw, 6.8rem);
            max-width: 690px;
        }

        .hero-grad-desc {
            max-width: 580px;
            margin-top: 24px;
            color: var(--grad-text);
            line-height: 1.9;
            font-size: 1.05rem;
        }

        .graduate-name-card {
            margin-top: 30px;
            width: min(100%, 520px);
            border-radius: 34px;
            padding: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
            position: relative;
            overflow: hidden;
        }

        .graduate-name-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -48px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-accent) 26%, transparent);
        }

        .graduate-name-card small {
            position: relative;
            z-index: 2;
            display: block;
            color: var(--grad-text);
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .graduate-name-card strong {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 8px;
            color: var(--grad-dark);
            font-size: clamp(1.8rem, 4vw, 3rem);
            line-height: 1;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .hero-grad-right {
            position: relative;
            min-height: 690px;
        }

        .confetti-dot {
            position: absolute;
            border-radius: 999px;
            background: var(--grad-accent);
            box-shadow: 0 8px 18px color-mix(in srgb, var(--grad-accent) 30%, transparent);
        }

        .confetti-dot.one { width: 18px; height: 18px; top: 14px; left: 18%; }
        .confetti-dot.two { width: 14px; height: 14px; top: 86px; right: 9%; background: var(--grad-primary); }
        .confetti-dot.three { width: 22px; height: 22px; bottom: 70px; left: 2%; background: var(--grad-secondary); }

        .photo-stage {
            position: absolute;
            inset: 44px 36px 40px 62px;
            border-radius: 48px;
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--grad-primary) 20%, white), color-mix(in srgb, var(--grad-accent) 32%, white));
            padding: 18px;
            box-shadow: 0 32px 80px rgba(26,35,64,.16);
            transform: rotate(2deg);
        }

        .photo-frame {
            position: relative;
            overflow: hidden;
            min-height: 580px;
            height: 100%;
            border-radius: 36px;
            background:
                radial-gradient(circle at 18% 14%, color-mix(in srgb, var(--grad-accent) 26%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--grad-soft) 90%, white));
            border: 2px dashed color-mix(in srgb, var(--grad-primary) 18%, transparent);
            transform: rotate(-2deg);
        }

        .photo-frame img.cover-photo {
            width: 100%;
            height: 100%;
            min-height: 580px;
            object-fit: cover;
            display: block;
        }

        .photo-placeholder {
            min-height: 580px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 42px;
            text-align: center;
        }

        .photo-placeholder-icon {
            width: 124px;
            height: 124px;
            margin: 0 auto 24px;
            border-radius: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 54px;
            background: color-mix(in srgb, var(--grad-primary) 12%, white);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
        }

        .photo-placeholder h2 {
            color: var(--grad-dark);
            font-size: clamp(2rem, 4.6vw, 4rem);
            line-height: 1;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .photo-placeholder p {
            max-width: 420px;
            margin: 16px auto 0;
            color: var(--grad-text);
            line-height: 1.8;
        }

        .cap-card {
            position: absolute;
            left: 10px;
            top: 0;
            width: 190px;
            padding: 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 18px 40px rgba(26,35,64,.12);
            z-index: 4;
        }

        .cap-card .cap-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
            margin-bottom: 14px;
        }

        .cap-card small {
            display: block;
            color: var(--grad-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .cap-card p {
            margin-top: 7px;
            color: var(--grad-dark);
            font-weight: 950;
            line-height: 1.4;
        }

        .date-ribbon {
            position: absolute;
            right: 0;
            bottom: 20px;
            z-index: 5;
            width: 260px;
            padding: 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.95);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 18px 40px rgba(26,35,64,.12);
        }

        .date-ribbon small {
            display: block;
            color: var(--grad-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .date-ribbon strong {
            display: block;
            margin-top: 8px;
            color: var(--grad-dark);
            line-height: 1.45;
            font-weight: 950;
        }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--grad-text);
            line-height: 1.85;
        }

        .grad-date-line,
        .grad-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            line-height: 1.5;
        }

        .grad-date-line span,
        .grad-time-line span { display: inline; }

        .achievement-grid {
            display: grid;
            gap: 20px;
            margin-top: 40px;
            justify-content: center;
        }

        .achievement-grid.count-1 { grid-template-columns: minmax(280px, 460px); }
        .achievement-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 440px)); }
        .achievement-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .achievement-card {
            position: relative;
            overflow: hidden;
            min-height: 230px;
            padding: 30px;
            border-radius: 34px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
        }

        .achievement-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -52px;
            bottom: -52px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-accent) 28%, transparent);
        }

        .achievement-number {
            position: relative;
            z-index: 2;
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
            margin-bottom: 22px;
        }

        .achievement-card h3,
        .achievement-card p { position: relative; z-index: 2; }

        .achievement-card h3 {
            color: var(--grad-dark);
            font-size: 1.45rem;
            font-weight: 950;
        }

        .achievement-card p {
            color: var(--grad-text);
            margin-top: 10px;
            line-height: 1.8;
        }

        .graduate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 22px;
            margin-top: 40px;
        }

        .graduate-grid.single-graduate {
            grid-template-columns: minmax(280px, 430px);
        }

        .graduate-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 34px;
            padding: 26px;
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--grad-accent) 22%, transparent), transparent 34%),
                rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
        }

        .graduate-photo,
        .graduate-placeholder {
            width: 132px;
            height: 132px;
            border-radius: 34px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--grad-primary) 9%, white);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(26,35,64,.08);
            color: var(--grad-primary);
            font-size: 44px;
            font-weight: 950;
        }

        .graduate-role {
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-primary) 10%, white);
            color: var(--grad-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .graduate-card h3 {
            margin-top: 16px;
            color: var(--grad-dark);
            font-size: 1.7rem;
            line-height: 1.1;
            font-weight: 950;
        }

        .graduate-card p {
            margin-top: 8px;
            color: var(--grad-text);
            line-height: 1.7;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .grad-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            border-radius: 36px;
            box-shadow: 0 18px 44px rgba(26,35,64,.08);
            padding: 30px;
        }

        .grad-card h3 {
            color: var(--grad-dark);
            font-size: 2rem;
            font-weight: 950;
            margin: 0;
        }

        .detail-list { display: grid; gap: 14px; margin-top: 24px; }
        .detail-row {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--grad-primary) 18%, transparent);
        }

        .detail-row .label {
            color: var(--grad-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--grad-dark);
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
            background: linear-gradient(180deg, color-mix(in srgb, var(--grad-soft) 90%, white), white);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--grad-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--grad-text);
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
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(26,35,64,.08);
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
            color: var(--grad-dark);
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--grad-soft) 92%, white));
        }

        .gallery-masonry {
            display: grid;
            grid-template-columns: 1fr .8fr 1fr;
            gap: 18px;
            margin-top: 38px;
            align-items: stretch;
        }

        .gallery-column { display: grid; gap: 18px; }

        .gallery-card {
            padding: 10px;
            border-radius: 30px;
            overflow: hidden;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
        }

        .gallery-card.tall img { height: 350px; }
        .gallery-card.short img { height: 220px; }
        .gallery-card img {
            width: 100%;
            object-fit: cover;
            border-radius: 22px;
            display: block;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 { grid-template-columns: minmax(280px, 520px); justify-content: center; }

        .gift-card {
            position: relative;
            overflow: hidden;
            padding: 26px;
            border-radius: 34px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -50px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-accent) 24%, transparent);
        }

        .gift-card h3 {
            position: relative;
            z-index: 2;
            color: var(--grad-dark);
            font-size: 1.4rem;
            font-weight: 950;
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
            background: color-mix(in srgb, var(--grad-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--grad-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--grad-primary);
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
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
        }

        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        .rsvp-wrap {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(26,35,64,.08);
            border-radius: 30px;
        }

        .form-card { padding: 28px; }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card { padding: 20px; text-align: center; }
        .summary-card strong { display: block; color: var(--grad-dark); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: var(--grad-text); font-size: 12px; font-weight: 900; }

        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-primary) 11%, white);
            color: var(--grad-primary);
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
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--grad-primary) 12%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--grad-accent) 24%, transparent), transparent 36%),
                rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(26,35,64,.08);
        }

        @media (max-width: 1080px) {
            .hero-grad,
            .detail-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .hero-grad-right { min-height: 640px; }
            .photo-stage { inset: 22px 20px 30px 20px; }
            .achievement-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 440px)); }
            .gallery-masonry { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .grad-shell { padding: 0; }
            .grad-wrap { border-radius: 0; box-shadow: none; }
            .grad-section,
            .hero-grad { padding: 72px 22px; }
            .grad-section.compact { padding-top: 64px; padding-bottom: 64px; }

            .hero-grad-title { font-size: clamp(2.8rem, 15vw, 4.6rem); line-height: 1; }
            .grad-hero-left { text-align: center; }
            .hero-actions { justify-content: center; }
            .graduate-name-card { text-align: left; }

            .hero-grad-right { min-height: auto; }
            .photo-stage {
                position: relative;
                inset: auto;
                margin-top: 28px;
                transform: none;
                border-radius: 34px;
            }
            .photo-frame,
            .photo-frame img.cover-photo,
            .photo-placeholder {
                min-height: 420px;
                border-radius: 26px;
                transform: none;
            }

            .cap-card,
            .date-ribbon {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: auto;
                margin-top: 14px;
            }

            .achievement-grid,
            .achievement-grid.count-1,
            .achievement-grid.count-2,
            .achievement-grid.count-3,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .gallery-column {
                grid-template-columns: 1fr;
            }

            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .floating-actions { right: 10px; }
        }

        /* =====================================================
        NEW HERO WISUDA - TICKET SPOTLIGHT LAYOUT
        Lebih beda, meriah, dan tidak memakai pola split biasa
        ===================================================== */

        .grad-hero-ticket {
            min-height: 100vh;
            padding: 92px 64px 72px;
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr) 390px;
            gap: 28px;
            align-items: center;
        }

        .grad-date-ticket {
            min-height: 560px;
            border-radius: 999px;
            padding: 28px 18px;
            background:
                linear-gradient(180deg,
                    color-mix(in srgb, var(--grad-primary) 12%, white),
                    color-mix(in srgb, var(--grad-accent) 30%, white)
                );
            border: 1px solid color-mix(in srgb, var(--grad-primary) 16%, transparent);
            box-shadow: 0 24px 58px rgba(26,35,64,.10);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }

        .grad-host-mini {
            margin-top: 8px;
            color: var(--grad-text);
            font-size: .95rem;
            line-height: 1.5;
            font-weight: 700;
        }

        .grad-ticket-top {
            width: 94px;
            height: 94px;
            border-radius: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 38px;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
            box-shadow: 0 18px 36px color-mix(in srgb, var(--grad-primary) 25%, transparent);
        }

        .grad-ticket-date strong {
            display: block;
            color: var(--grad-dark);
            font-size: clamp(3.2rem, 6vw, 5rem);
            line-height: .9;
            font-weight: 950;
            letter-spacing: -.06em;
        }

        .grad-ticket-date span {
            display: block;
            margin-top: 10px;
            color: var(--grad-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-ticket-line {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            color: var(--grad-text);
            font-size: 11px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-ticket-main {
            position: relative;
            min-width: 0;
            padding: 42px 0;
        }

        .grad-ticket-main::before {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            left: -110px;
            top: 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-accent) 22%, transparent);
            z-index: -1;
        }

        .grad-mini-kicker {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 10%, transparent);
            box-shadow: 0 6px 14px rgba(26,35,64,.05);
            color: var(--grad-primary);
            font-size: 9px;
            letter-spacing: .09em;
            text-transform: uppercase;
            font-weight: 950;
            line-height: 1;
        }

        .grad-mini-kicker::before {
            content: "";
            width: 14px;
            height: 14px;
            border-radius: 999px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--grad-primary), var(--grad-secondary));
        }

        .grad-ticket-title {
            margin-top: 22px;
            max-width: 520px;
            font-size: clamp(2.4rem, 4.8vw, 4.7rem);
            line-height: .96;
            letter-spacing: -.055em;
            word-break: normal;
            overflow-wrap: normal;
        }

        .grad-ticket-desc {
            max-width: 650px;
            margin-top: 26px;
            color: var(--grad-text);
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .grad-graduate-strip {
            margin-top: 32px;
            width: min(100%, 650px);
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: center;
            padding: 16px;
            border-radius: 30px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 13%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.08);
        }

        .grad-graduate-strip small {
            display: block;
            color: var(--grad-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-graduate-strip strong {
            display: block;
            margin-top: 6px;
            color: var(--grad-dark);
            font-size: clamp(1.5rem, 4vw, 2.6rem);
            line-height: 1;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .grad-strip-badge {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--grad-accent) 34%, white);
            color: var(--grad-dark);
            font-size: 34px;
        }

        .grad-ticket-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .grad-info-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
            width: min(100%, 720px);
        }

        .grad-info-chip {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 12%, transparent);
            box-shadow: 0 14px 32px rgba(26,35,64,.07);
        }

        .grad-info-chip::after {
            content: "";
            position: absolute;
            width: 80px;
            height: 80px;
            right: -32px;
            top: -32px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--grad-accent) 22%, transparent);
        }

        .grad-info-chip small,
        .grad-info-chip strong {
            position: relative;
            z-index: 2;
        }

        .grad-info-chip small {
            display: block;
            color: var(--grad-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-info-chip strong {
            display: block;
            margin-top: 8px;
            color: var(--grad-dark);
            font-weight: 950;
            line-height: 1.45;
        }

        .grad-spotlight {
            position: relative;
            min-height: 640px;
        }

        .grad-spotlight::before {
            content: "";
            position: absolute;
            inset: 44px 28px 0 0;
            border-radius: 46px;
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--grad-primary) 16%, white),
                    color-mix(in srgb, var(--grad-accent) 32%, white)
                );
            transform: rotate(-4deg);
            box-shadow: 0 28px 70px rgba(26,35,64,.14);
        }

        .grad-spotlight-card {
            position: relative;
            z-index: 2;
            margin-top: 18px;
            min-height: 610px;
            border-radius: 44px 44px 120px 44px;
            overflow: hidden;
            background:
                radial-gradient(circle at top left, color-mix(in srgb, var(--grad-accent) 26%, transparent), transparent 36%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--grad-soft) 90%, white));
            border: 2px dashed color-mix(in srgb, var(--grad-primary) 18%, transparent);
            box-shadow: 0 24px 56px rgba(26,35,64,.10);
        }

        .grad-spotlight-card img.cover-photo {
            width: 100%;
            height: 610px;
            object-fit: cover;
            display: block;
        }

        .grad-spotlight-placeholder {
            min-height: 610px;
            padding: 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .grad-spotlight-icon {
            width: 112px;
            height: 112px;
            margin: 0 auto 26px;
            border-radius: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--grad-primary) 12%, white);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 14%, transparent);
            font-size: 52px;
        }

        .grad-spotlight-placeholder h2 {
            color: var(--grad-dark);
            font-size: clamp(2.2rem, 4vw, 3.8rem);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .grad-spotlight-placeholder p {
            max-width: 360px;
            margin: 18px auto 0;
            color: var(--grad-text);
            line-height: 1.85;
        }

        .grad-floating-medal {
            position: absolute;
            z-index: 4;
            left: -28px;
            bottom: 46px;
            width: 190px;
            padding: 18px;
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--grad-primary) 13%, transparent);
            box-shadow: 0 18px 42px rgba(26,35,64,.13);
        }

        .grad-floating-medal small {
            display: block;
            color: var(--grad-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .grad-floating-medal strong {
            display: block;
            margin-top: 8px;
            color: var(--grad-dark);
            font-size: 1.1rem;
            line-height: 1.4;
            font-weight: 950;
        }

        .grad-confetti {
            position: absolute;
            z-index: 3;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: var(--grad-accent);
        }

        .grad-confetti.c1 { right: 18px; top: 52px; }
        .grad-confetti.c2 { left: -8px; top: 160px; background: var(--grad-secondary); }
        .grad-confetti.c3 { right: 38px; bottom: 112px; background: var(--grad-primary); }

        @media (max-width: 1080px) {
            .grad-hero-ticket {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .grad-date-ticket {
                min-height: auto;
                border-radius: 36px;
                flex-direction: row;
                justify-content: space-between;
                gap: 18px;
                padding: 22px;
            }

            .grad-ticket-line {
                writing-mode: initial;
                transform: none;
            }

            .grad-info-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grad-spotlight {
                min-height: auto;
            }

            .grad-spotlight-card {
                min-height: 520px;
            }

            .grad-spotlight-card img.cover-photo,
            .grad-spotlight-placeholder {
                height: auto;
                min-height: 520px;
            }
        }

        @media (max-width: 640px) {
            .grad-hero-ticket {
                padding: 72px 22px;
            }

            .grad-date-ticket {
                align-items: center;
                text-align: left;
            }

            .grad-ticket-top {
                width: 72px;
                height: 72px;
                border-radius: 24px;
                font-size: 30px;
            }

            .grad-ticket-date strong {
                font-size: 3rem;
            }

            .grad-ticket-title {
                max-width: 100%;
                font-size: clamp(2.2rem, 11vw, 3.4rem);
                line-height: 1;
                letter-spacing: -.045em;
            }

            .grad-ticket-main {
                text-align: center;
                padding: 20px 0;
            }

            .grad-graduate-strip {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .grad-strip-badge {
                margin: 0 auto;
            }

            .grad-ticket-actions {
                justify-content: center;
            }

            .grad-info-row {
                grid-template-columns: 1fr;
            }

            .grad-spotlight::before {
                inset: 28px 0 0 0;
            }

            .grad-spotlight-card {
                border-radius: 34px;
                min-height: 440px;
            }

            .grad-spotlight-card img.cover-photo,
            .grad-spotlight-placeholder {
                min-height: 440px;
                height: auto;
            }

            .grad-floating-medal {
                position: relative;
                left: auto;
                bottom: auto;
                width: auto;
                margin-top: 14px;
            }
        }
        .grad-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
            gap: 34px;
            align-items: center;
        }

        .grad-hero-copy {
            min-width: 0;
        }

        .grad-hero-title {
            margin: 0;
            max-width: 420px;
            font-size: clamp(2.6rem, 5vw, 4.8rem);
            line-height: 0.95;
            letter-spacing: -0.05em;
            font-weight: 950;
            color: #2563eb;
            word-break: normal;
            overflow-wrap: break-word;
        }

        .grad-hero-subtitle {
            margin-top: 18px;
            max-width: 500px;
            font-size: 1.05rem;
            line-height: 1.8;
            color: #44526b;
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .grad-hero-grid {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .grad-hero-title {
                max-width: 100%;
                font-size: clamp(2.8rem, 8vw, 4.8rem);
            }
        }

        @media (max-width: 640px) {
            .grad-hero-title {
                font-size: clamp(2.4rem, 12vw, 3.6rem);
                line-height: 0.96;
                letter-spacing: -0.05em;
            }
        }

        .grad-host-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px 20px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(37, 99, 235, 0.08);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            position: relative;
        }

        .grad-host-label {
            margin: 0 0 8px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #3b5b9a;
        }

        .grad-host-card h3 {
            margin: 0;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            line-height: 1;
            font-weight: 950;
            color: #0f172a;
        }

        .grad-host-motif {
            position: relative;
            width: 86px;
            height: 86px;
            flex-shrink: 0;
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(250, 204, 21, 0.30), transparent 38%),
                linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,248,220,0.95));
            border: 1px solid rgba(250, 204, 21, 0.20);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .grad-host-motif span {
            position: absolute;
            display: block;
            border-radius: 999px;
        }

        .grad-host-motif span:nth-child(1) {
            width: 42px;
            height: 42px;
            background: rgba(250, 204, 21, 0.35);
            top: 12px;
            right: 12px;
        }

        .grad-host-motif span:nth-child(2) {
            width: 18px;
            height: 18px;
            background: rgba(59, 130, 246, 0.85);
            bottom: 16px;
            left: 16px;
        }

        .grad-host-motif span:nth-child(3) {
            width: 58px;
            height: 2px;
            background: rgba(37, 99, 235, 0.22);
            transform: rotate(-35deg);
        }

        .grad-host-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 96px;
            align-items: center;
            gap: 18px;
            padding: 20px 22px;
            border-radius: 28px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(26, 35, 64, .08);
            box-shadow: 0 14px 30px rgba(26, 35, 64, .08);
        }

        .grad-host-content {
            min-width: 0;
        }

        .grad-host-label {
            margin: 0 0 12px 0;
            font-size: 12px;
            line-height: 1.4;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 900;
            color: #4b6aa5;
        }

        .grad-host-title {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: .95;
            font-weight: 950;
            color: #0f1d44;
            letter-spacing: -.04em;
            max-width: 100%;
        }

        .grad-host-mini {
            margin: 12px 0 0 0;
            font-size: 1rem;
            line-height: 1.6;
            font-weight: 700;
            color: #5f6f8d;
        }

        .grad-host-motif {
            width: 96px;
            height: 96px;
            border-radius: 24px;
            position: relative;
            flex-shrink: 0;
            background:
                radial-gradient(circle at 70% 30%, rgba(255, 226, 122, .9) 0 18px, transparent 19px),
                linear-gradient(145deg, rgba(255, 243, 192, .9), rgba(255, 255, 255, .96));
            border: 1px solid rgba(240, 203, 77, .35);
            overflow: hidden;
        }

        .grad-host-motif span {
            position: absolute;
            display: block;
            border-radius: 999px;
        }

        .grad-host-motif span:nth-child(1) {
            width: 18px;
            height: 18px;
            background: #5a8df6;
            left: 16px;
            bottom: 14px;
        }

        .grad-host-motif span:nth-child(2) {
            width: 44px;
            height: 2px;
            background: rgba(210, 180, 70, .75);
            right: 14px;
            top: 26px;
            transform: rotate(-35deg);
            transform-origin: center;
        }

        .grad-host-motif span:nth-child(3) {
            width: 42px;
            height: 42px;
            border: 2px solid rgba(240, 203, 77, .45);
            right: 16px;
            top: 14px;
            background: transparent;
        }

        .grad-host-motif {
            position: relative;
            width: 88px;
            height: 88px;
            border-radius: 22px;
            background: #fffdf5;
            border: 1px solid rgba(235, 206, 109, .45);
            flex-shrink: 0;
            overflow: hidden;
        }

        .grad-host-motif span {
            position: absolute;
            display: block;
            border-radius: 999px;
        }

        .grad-host-motif span:nth-child(1) {
            width: 40px;
            height: 40px;
            background: rgba(248, 223, 122, .9);
            top: 12px;
            right: 12px;
        }

        .grad-host-motif span:nth-child(2) {
            width: 54px;
            height: 54px;
            border: 2px solid rgba(232, 195, 64, .35);
            top: 10px;
            right: 4px;
            background: transparent;
        }

        .grad-host-motif span:nth-child(3) {
            width: 20px;
            height: 20px;
            background: rgba(91, 141, 239, .95);
            left: 14px;
            bottom: 16px;
        }

        @media (max-width: 640px) {

            .grad-host-content {
                min-width: 0;
                width: 100%;
            }

            .grad-host-label {
                margin-bottom: 14px;
                font-size: 10px;
                letter-spacing: .18em;
            }

            .grad-host-title {
                font-size: clamp(1.45rem, 6.4vw, 2rem);
                line-height: 1.05;
                letter-spacing: -.035em;
                margin: 0;
            }

            .grad-host-mini {
                margin-top: 8px;
                font-size: .9rem;
            }

            .grad-host-motif {
                width: 64px;
                height: 64px;
                border-radius: 20px;
                justify-self: end;
                align-self: center;
            }

            .grad-host-motif span:nth-child(1) {
                width: 14px;
                height: 14px;
                left: 12px;
                bottom: 11px;
            }

            .grad-host-motif span:nth-child(2) {
                width: 34px;
                right: 10px;
                top: 22px;
            }

            .grad-host-motif span:nth-child(3) {
                width: 32px;
                height: 32px;
                right: 11px;
                top: 12px;
            }
            .grad-host-card {
                gap: 14px;
                align-items: center;
            }

            .grad-host-motif {
                width: 72px;
                height: 72px;
                border-radius: 18px;
            }

            .grad-host-motif span:nth-child(1) {
                width: 32px;
                height: 32px;
                top: 10px;
                right: 10px;
            }

            .grad-host-motif span:nth-child(2) {
                width: 40px;
                height: 40px;
                top: 10px;
                right: 5px;
            }

            .grad-host-motif span:nth-child(3) {
                width: 16px;
                height: 16px;
                left: 12px;
                bottom: 12px;
            }
        }

        @media (max-width: 640px) {
            .grad-host-card {
                grid-template-columns: minmax(0, 1fr) 58px;
                gap: 10px;
                padding: 18px 16px;
                border-radius: 24px;
            }

            .grad-host-title {
                font-size: clamp(1.2rem, 5.2vw, 1.55rem);
                line-height: 1.12;
                letter-spacing: -0.025em;

                /* agar tidak pecah per huruf */
                word-break: normal;
                overflow-wrap: normal;
                white-space: normal;
                text-wrap: balance;
            }

            .grad-host-label {
                font-size: 9px;
                margin-bottom: 10px;
            }

            .grad-host-motif {
                width: 58px;
                height: 58px;
                border-radius: 16px;
            }

            .grad-host-motif span:nth-child(1) {
                width: 26px;
                height: 26px;
                top: 8px;
                right: 8px;
            }

            .grad-host-motif span:nth-child(2) {
                width: 34px;
                height: 34px;
                top: 8px;
                right: 4px;
            }

            .grad-host-motif span:nth-child(3) {
                width: 14px;
                height: 14px;
                left: 10px;
                bottom: 10px;
            }
        }

        /* =====================================================
        LUXURY GRADUATION ANIMATION - WISUDA
        Tempel sebelum penutup style
        ===================================================== */

        .grad-reveal,
        .grad-section > p,
        .grad-section > h1,
        .grad-section > h2,
        .grad-section > h3,
        .grad-label,
        .grad-title,
        .grad-gradient,
        .grad-nav,
        .grad-hero-ticket,
        .grad-date-ticket,
        .grad-ticket-top,
        .grad-ticket-date,
        .grad-ticket-line,
        .grad-ticket-main,
        .grad-mini-kicker,
        .grad-ticket-title,
        .grad-ticket-desc,
        .grad-graduate-strip,
        .grad-strip-badge,
        .grad-ticket-actions,
        .grad-info-row,
        .grad-info-chip,
        .grad-spotlight,
        .grad-spotlight-card,
        .grad-spotlight-placeholder,
        .grad-spotlight-icon,
        .grad-floating-medal,
        .grad-confetti,
        .graduate-name-card,
        .graduate-card,
        .graduate-photo,
        .graduate-placeholder,
        .achievement-card,
        .achievement-number,
        .grad-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .grad-btn {
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

        .grad-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .grad-nav {
            animation: gradNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .grad-date-ticket {
            animation: gradDateTicketEnter 1s cubic-bezier(.2, .8, .2, 1) .08s both;
        }

        #opening .grad-ticket-top {
            animation:
                gradIconPop .85s cubic-bezier(.2, .8, .2, 1) .24s both,
                gradIconFloat 3.8s ease-in-out 1.3s infinite;
        }

        #opening .grad-mini-kicker {
            animation: gradFadeDown .85s ease .18s both;
        }

        #opening .grad-ticket-title {
            animation: gradTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .34s both;
        }

        #opening .grad-ticket-desc {
            animation: gradFadeUp .85s ease .50s both;
        }

        #opening .grad-graduate-strip {
            animation: gradFadeUp .85s ease .62s both;
        }

        #opening .grad-ticket-actions {
            animation: gradFadeUp .85s ease .74s both;
        }

        #opening .grad-info-chip {
            animation: gradFadeUp .85s ease .84s both;
        }

        #opening .grad-spotlight-card {
            animation:
                gradSpotlightEnter 1.12s cubic-bezier(.2, .8, .2, 1) .32s both,
                gradSpotlightFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .grad-floating-medal {
            animation:
                gradMedalEnter .95s cubic-bezier(.2, .8, .2, 1) .76s both,
                gradMedalFloat 4.8s ease-in-out 1.5s infinite;
        }

        /* Background grid hidup */
        .grad-wrap {
            animation: gradWrapGlow 8s ease-in-out infinite alternate;
        }

        .grad-wrap::before {
            animation: gradGridMove 20s linear infinite;
        }

        /* Dekorasi lingkaran/card */
        .graduate-name-card::after,
        .achievement-card::after,
        .gift-card::after,
        .grad-info-chip::after,
        .grad-ticket-main::before,
        .grad-spotlight::before {
            animation: gradDecorFloat 6.4s ease-in-out infinite;
        }

        /* Confetti bergerak */
        .confetti-dot.one,
        .grad-confetti.c1 {
            animation: gradConfettiOne 4.6s ease-in-out infinite;
        }

        .confetti-dot.two,
        .grad-confetti.c2 {
            animation: gradConfettiTwo 5s ease-in-out .2s infinite;
        }

        .confetti-dot.three,
        .grad-confetti.c3 {
            animation: gradConfettiThree 5.3s ease-in-out .35s infinite;
        }

        /* Label glow */
        .grad-label::before,
        .grad-mini-kicker::before {
            animation: gradLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .grad-btn,
        button.grad-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .grad-btn::after,
        button.grad-btn::after,
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
            animation: gradButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .grad-date-ticket:hover,
            .grad-graduate-strip:hover,
            .grad-info-chip:hover,
            .grad-spotlight-card:hover,
            .grad-floating-medal:hover,
            .graduate-name-card:hover,
            .graduate-card:hover,
            .achievement-card:hover,
            .grad-card:hover,
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
                border-color: color-mix(in srgb, var(--grad-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--grad-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--grad-accent) 18%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .grad-spotlight-card:hover img,
            .photo-frame:hover img,
            .gallery-card:hover img,
            .graduate-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .grad-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--grad-primary) 12%, transparent);
            }
        }

        .grad-spotlight-card img,
        .photo-frame img,
        .gallery-card img,
        .graduate-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: gradNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon dan angka pulse */
        .achievement-number,
        .grad-strip-badge,
        .grad-spotlight-icon,
        .photo-placeholder-icon,
        .cap-icon,
        .gift-number,
        .message-badge,
        .graduate-placeholder {
            animation: gradSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: gradGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: gradGalleryMiddle 4.8s ease-in-out .18s infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: gradGalleryRight 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: gradFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes gradNavEnter {
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

        @keyframes gradDateTicketEnter {
            from {
                opacity: 0;
                transform: translateX(-30px) translateY(34px) scale(.94);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes gradSpotlightEnter {
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

        @keyframes gradSpotlightFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes gradMedalEnter {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.9) rotate(-5deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes gradMedalFloat {
            0%, 100% {
                transform: translateY(0) rotate(0);
            }
            50% {
                transform: translateY(-8px) rotate(-1.5deg);
            }
        }

        @keyframes gradIconPop {
            from {
                opacity: 0;
                transform: translateY(-14px) scale(.75) rotate(-8deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes gradIconFloat {
            0%, 100% {
                transform: translateY(0) rotate(0);
            }
            50% {
                transform: translateY(-6px) rotate(3deg);
            }
        }

        @keyframes gradFadeDown {
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

        @keyframes gradFadeUp {
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

        @keyframes gradTitleIn {
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

        @keyframes gradWrapGlow {
            from {
                box-shadow:
                    0 36px 96px color-mix(in srgb, var(--grad-primary) 9%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 44px 124px color-mix(in srgb, var(--grad-primary) 14%, transparent),
                    0 0 62px color-mix(in srgb, var(--grad-accent) 18%, transparent);
            }
        }

        @keyframes gradGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 136px 136px, 136px 136px;
            }
        }

        @keyframes gradDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes gradConfettiOne {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-13px) rotate(12deg) scale(1.12);
            }
        }

        @keyframes gradConfettiTwo {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-10px) rotate(-10deg) scale(1.1);
            }
        }

        @keyframes gradConfettiThree {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-12px) rotate(8deg) scale(1.12);
            }
        }

        @keyframes gradLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--grad-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--grad-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes gradButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes gradNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--grad-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--grad-accent) 46%, transparent),
                    0 0 34px color-mix(in srgb, var(--grad-primary) 18%, transparent);
            }
        }

        @keyframes gradSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes gradGalleryLeft {
            0%, 100% {
                transform: translateY(0) rotate(-.5deg);
            }
            50% {
                transform: translateY(-7px) rotate(-1deg);
            }
        }

        @keyframes gradGalleryMiddle {
            0%, 100% {
                transform: translateY(0) rotate(.3deg);
            }
            50% {
                transform: translateY(-6px) rotate(.8deg);
            }
        }

        @keyframes gradGalleryRight {
            0%, 100% {
                transform: translateY(0) rotate(.2deg);
            }
            50% {
                transform: translateY(-7px) rotate(.7deg);
            }
        }

        @keyframes gradFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .grad-reveal,
            .grad-section > p,
            .grad-section > h1,
            .grad-section > h2,
            .grad-section > h3,
            .grad-label,
            .grad-title,
            .grad-gradient,
            .grad-nav,
            .grad-hero-ticket,
            .grad-date-ticket,
            .grad-ticket-top,
            .grad-ticket-date,
            .grad-ticket-line,
            .grad-ticket-main,
            .grad-mini-kicker,
            .grad-ticket-title,
            .grad-ticket-desc,
            .grad-graduate-strip,
            .grad-strip-badge,
            .grad-ticket-actions,
            .grad-info-row,
            .grad-info-chip,
            .grad-spotlight,
            .grad-spotlight-card,
            .grad-spotlight-placeholder,
            .grad-spotlight-icon,
            .grad-floating-medal,
            .grad-confetti,
            .graduate-name-card,
            .graduate-card,
            .graduate-photo,
            .graduate-placeholder,
            .achievement-card,
            .achievement-number,
            .grad-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .grad-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .grad-spotlight-card {
                animation:
                    gradFadeUp .9s ease .3s both,
                    gradFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .grad-reveal,
            .grad-section > p,
            .grad-section > h1,
            .grad-section > h2,
            .grad-section > h3,
            .grad-label,
            .grad-title,
            .grad-gradient,
            .grad-nav,
            .grad-hero-ticket,
            .grad-date-ticket,
            .grad-ticket-top,
            .grad-ticket-date,
            .grad-ticket-line,
            .grad-ticket-main,
            .grad-mini-kicker,
            .grad-ticket-title,
            .grad-ticket-desc,
            .grad-graduate-strip,
            .grad-strip-badge,
            .grad-ticket-actions,
            .grad-info-row,
            .grad-info-chip,
            .grad-spotlight,
            .grad-spotlight-card,
            .grad-spotlight-placeholder,
            .grad-spotlight-icon,
            .grad-floating-medal,
            .grad-confetti,
            .graduate-name-card,
            .graduate-card,
            .graduate-photo,
            .graduate-placeholder,
            .achievement-card,
            .achievement-number,
            .grad-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .grad-btn,
            .grad-wrap,
            .grad-wrap::before,
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
    $themeColor = $invitation->theme_color ?? 'gold';

    $themes = [
        'maroon' => ['primary' => '#9f1239', 'secondary' => '#e11d48', 'accent' => '#fbbf24', 'dark' => '#4a1623', 'text' => '#6b3440', 'soft' => '#fff1f2', 'glow1' => 'rgba(244, 63, 94, .18)', 'glow2' => 'rgba(251, 191, 36, .22)'],
        'emerald' => ['primary' => '#15803d', 'secondary' => '#22c55e', 'accent' => '#facc15', 'dark' => '#163d2c', 'text' => '#4f6f5f', 'soft' => '#f4fff6', 'glow1' => 'rgba(34, 197, 94, .16)', 'glow2' => 'rgba(250, 204, 21, .20)'],
        'navy' => ['primary' => '#1d4ed8', 'secondary' => '#38bdf8', 'accent' => '#facc15', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#eff6ff', 'glow1' => 'rgba(37, 99, 235, .15)', 'glow2' => 'rgba(250, 204, 21, .20)'],
        'rose' => ['primary' => '#db2777', 'secondary' => '#f472b6', 'accent' => '#fde68a', 'dark' => '#831843', 'text' => '#70415b', 'soft' => '#fff7fb', 'glow1' => 'rgba(244, 114, 182, .18)', 'glow2' => 'rgba(253, 230, 138, .22)'],
        'gold' => ['primary' => '#b45309', 'secondary' => '#d97706', 'accent' => '#facc15', 'dark' => '#4a2c0a', 'text' => '#72512d', 'soft' => '#fffbeb', 'glow1' => 'rgba(245, 158, 11, .18)', 'glow2' => 'rgba(250, 204, 21, .24)'],
        'slate' => ['primary' => '#475569', 'secondary' => '#64748b', 'accent' => '#cbd5e1', 'dark' => '#1e293b', 'text' => '#64748b', 'soft' => '#f8fafc', 'glow1' => 'rgba(100, 116, 139, .14)', 'glow2' => 'rgba(203, 213, 225, .20)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['gold'];
    $firstPhoto = $invitation->photos->first();
    $photos = $invitation->photos->values();
    $giftCount = $invitation->gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Wisuda Graduation Day';
    $eventName = $invitation->event_name ?: 'Graduation Day';
    $hostName = $invitation->host_name ?: null;
    $firstGraduate = $invitation->people->first();
    $graduateName = $firstGraduate?->name ?: ($invitation->host_name ?: 'Nama Wisudawan');

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
        "Dengan penuh rasa bahagia dan syukur, kami mengundang Anda untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) {
        $shareMessage .= "Diselenggarakan oleh: {$hostName}\n";
    }

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
            if ($endDateTime->lessThanOrEqualTo($startDateTime)) { $endDateTime = $startDateTime->copy()->addHours(3); }

            $calendarTitle = trim(($invitation->event_name ?: 'Graduation Day') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan wisuda') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Graduation' : 'Lokasi Wisuda');

    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang wisuda online atau webinar.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $gradHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $gradHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --grad-primary: {{ $activeTheme['primary'] }};
        --grad-secondary: {{ $activeTheme['secondary'] }};
        --grad-accent: {{ $activeTheme['accent'] }};
        --grad-dark: {{ $activeTheme['dark'] }};
        --grad-text: {{ $activeTheme['text'] }};
        --grad-soft: {{ $activeTheme['soft'] }};
        --grad-glow-1: {{ $activeTheme['glow1'] }};
        --grad-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="grad-shell">
        <div class="grad-wrap">
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

            <nav class="grad-nav">
                <a href="#opening">Home</a>
                <a href="#detail">Detail</a>
                @if ($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if ($giftCount) <a href="#gift">Hadiah</a> @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="grad-hero-ticket">
                <aside class="grad-date-ticket">
                    <div class="grad-ticket-top"><img src="{{ asset('assets/icons/Topi.png') }}" alt="Topi" class="floating-icon"></div>

                    <div class="grad-ticket-date">
                        @if ($invitation->event_date)
                            <strong>{{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('M Y') }}</span>
                        @else
                            <strong>--</strong>
                            <span>Tanggal</span>
                        @endif
                    </div>

                    <div class="grad-ticket-line">
                        Graduation Celebration
                    </div>
                </aside>

                <div class="grad-ticket-main">
                    <div class="grad-mini-kicker">
                        {{ $invitation->event_name ?: 'Graduation Day' }}
                    </div>

                    <h1 class="responsive-text grad-title grad-gradient grad-ticket-title">
                        {{ $invitation->title ?: 'Wisuda Graduation Day' }}
                    </h1>

                    <p class="responsive-text grad-ticket-desc mb-4">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang berkesan ini.' }}
                    </p>

                    @php
                        $graduateCount = $invitation->people->count();
                    @endphp

                    <div class="grad-host-card">
                        <div class="grad-host-content">
                            <p class="grad-host-label">Yang Berbahagia</p>

                            <h3 class="grad-host-title responsive-text">
                                @if ($graduateCount >= 2)
                                    Wisudawan & Wisudawati
                                @else
                                    {{ $graduateName }}
                                @endif
                            </h3>

                            @if ($graduateCount < 2)
                                <p class="grad-host-mini responsive-text">
                                    {{ $firstGraduate?->subtitle ?: 'Wisudawan / Wisudawati' }}
                                </p>
                            @endif
                        </div>

                        <div class="grad-host-motif" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <div class="grad-ticket-actions">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="grad-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="grad-btn">Lihat Detail</a>
                        @endif

                        <a href="#detail" class="grad-btn secondary">Detail Acara</a>
                        <a href="#message" class="grad-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="grad-info-row">
                        <div class="grad-info-chip">
                            <small class="mb-6">Waktu</small>
                            <strong class="grad-time-line">
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

                        <div class="grad-info-chip">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">
                                {{ $accessName }}
                            </strong>
                        </div>

                        <div class="grad-info-chip">
                            <small>Host</small>
                            <strong class="responsive-text">
                                {{ $invitation->host_name ?: 'Keluarga Besar' }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="grad-spotlight">
                    <span class="grad-confetti c1"></span>
                    <span class="grad-confetti c2"></span>
                    <span class="grad-confetti c3"></span>

                    <div class="grad-spotlight-card">
                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                                alt="Cover Wisuda"
                                class="cover-photo">
                        @elseif ($firstPhoto)
                            <img src="{{ asset('storage/' . $firstPhoto->image_path) }}"
                                alt="Foto Wisuda"
                                class="cover-photo">
                        @else
                            <div class="grad-spotlight-placeholder">
                                <div class="grad-spotlight-icon">🎓</div>

                                <h2 class="responsive-text">
                                    Hari Bahagia Penuh Prestasi
                                </h2>

                                <p class="responsive-text">
                                    Mari rayakan langkah baru, doa terbaik, dan kebahagiaan bersama keluarga serta sahabat.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GRADUATE --}}
            <section id="graduate" class="grad-section compact text-center">
                <p class="grad-label justify-center">The Graduate</p>
                <h2 class="responsive-text grad-title text-5xl md:text-6xl mt-6">Wisudawan / Wisudawati</h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--grad-text); line-height: 1.85;">
                    Bagian ini memakai data tokoh utama pada editor. Cocok untuk menampilkan satu atau beberapa wisudawan.
                </p>

                <div class="graduate-grid {{ $invitation->people->count() <= 1 ? 'single-graduate' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="graduate-card">
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
                        <div class="graduate-card">
                            <div class="graduate-placeholder">W</div>
                            <span class="graduate-role">Graduate</span>
                            <h3 class="responsive-text">Nama Wisudawan</h3>
                            <p>Data wisudawan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            @if ($highlightCount || $invitation->seminar_about_title)
            {{-- ABOUT / ACHIEVEMENT --}}
            <section id="about" class="grad-section compact">
                <div class="section-head">
                    <p class="grad-label justify-center">Achievement Moment</p>

                    <h2 class="responsive-text grad-title text-5xl md:text-6xl mt-6">
                        {{ $invitation->seminar_about_title ?: 'Hari Bahagia Penuh Prestasi' }}
                    </h2>

                    <p class="responsive-text desc">
                        {{ $invitation->host_name
                            ? 'Acara ini diselenggarakan oleh ' . $invitation->host_name . ' untuk merayakan pencapaian, perjuangan, dan langkah baru yang membanggakan.'
                            : 'Momen wisuda adalah perayaan atas doa, perjuangan, dan pencapaian yang penuh makna.'
                        }}
                    </p>
                </div>

                @if ($highlightCount)
                    <div class="achievement-grid {{ $highlightGridClass }}">
                        @foreach ($gradHighlights as $index => $highlight)
                            <div class="achievement-card">
                                <div class="achievement-number">
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
            <section id="detail" class="grad-section compact">
                <div class="section-head">
                    <p class="grad-label justify-center">Schedule & Venue</p>
                    <h2 class="grad-title text-5xl md:text-6xl mt-6">Detail Acara Wisuda</h2>
                    <p class="responsive-text desc">Simpan jadwal dan pastikan hadir pada momen bahagia ini.</p>
                </div>

                <div class="detail-layout">
                    <div class="grad-card">
                        <h3>Informasi Acara</h3>
                        <div class="detail-list">
                            <div class="detail-row"><div class="label ml-2">Acara</div><div class="value responsive-text ml-2">{{ $invitation->event_name ?: 'Graduation Day' }}</div></div>
                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value grad-date-line ml-2">
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
                                <div class="value grad-time-line ml-2">
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
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="grad-btn">📅 Atur Pengingat</a>
                            @endif
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="grad-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="grad-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget) Hitung mundur menuju acara @else Tanggal acara belum diatur @endif
                            </p>
                            <h3 class="mt-3">Countdown Graduation</h3>
                            <p class="text-slate-600 mt-3 leading-7">Bersiaplah untuk merayakan momen penuh bangga dan kebahagiaan.</p>

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
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--grad-primary);">Join Online →</p>
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
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--grad-primary);">Buka Google Maps →</p>
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
            @if ($photos->count())
                <section id="gallery" class="grad-section compact">
                    <div class="section-head">
                        <p class="grad-label justify-center">Graduation Memories</p>
                        <h2 class="grad-title text-5xl md:text-6xl mt-6">Galeri Kenangan</h2>
                    </div>

                    <div class="gallery-masonry">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'short' : 'tall' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(4, 2) as $index => $photo)
                                <div class="gallery-card {{ $index === 0 ? 'tall' : 'short' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda"></div>
                            @endforeach
                        </div>
                    </div>

                    @if ($photos->count() > 6)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                            @foreach ($photos->slice(6) as $photo)
                                <div class="gallery-card short"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda"></div>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="grad-section compact">
                    <div class="section-head">
                        <p class="grad-label justify-center">Hadiah & Apresiasi</p>
                        <h2 class="grad-title text-5xl md:text-6xl mt-6">Kirim Hadiah</h2>
                        <p class="responsive-text desc">Jika berkenan, tamu dapat mengirimkan hadiah digital melalui informasi berikut.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            <div class="gift-card">
                                <h3 class="responsive-text">{{ $gift->label ?: 'Hadiah Digital' }}</h3>
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
            <section id="message" class="grad-section compact">
                <div class="section-head">
                    <p class="grad-label justify-center">Guest Book</p>
                    <h2 class="grad-title text-5xl md:text-6xl mt-6">Ucapan & Kehadiran</h2>
                    <p class="responsive-text desc">Kirim ucapan terbaik dan konfirmasi kehadiran pada momen bahagia ini.</p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                            <p class="font-bold">Mohon periksa kembali isian:</p>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4">
                        @csrf
                        <div><label class="uk-label">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="uk-input mt-1" placeholder="Nama lengkap" required></div>
                        <div>
                            <label class="uk-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="uk-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>
                        <div><label class="uk-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1"></div>
                        <div><label class="uk-label">Ucapan / Doa</label><textarea name="message" rows="4" class="uk-input mt-1 uk-break-input" placeholder="Tulis ucapan dan doa terbaik..." required>{{ old('message') }}</textarea></div>
                        <button type="submit" class="w-full grad-btn">Kirim Ucapan</button>
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
            <section id="closing" class="grad-section text-center">
                <div class="closing-card">
                    <p class="grad-label justify-center">Thank You</p>
                    <h2 class="responsive-text grad-title grad-gradient text-5xl md:text-7xl mt-8">Sampai Jumpa</h2>
                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian, doa, dan kehadiran Anda. Semoga momen wisuda ini menjadi awal langkah baru yang penuh keberhasilan.
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
                    if (noteEl) noteEl.textContent = distance > 0 ? 'Hitung mundur menuju acara' : 'Acara sedang berlangsung atau telah dimulai';
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
                    } catch (error) { console.log('Audio tidak bisa diputar:', error); }
                });
            }

            const scrollToggle = document.getElementById('scroll-toggle');
            let autoScrollActive = false;
            let autoScrollFrame = null;
            let scrollSpeed = 1.15;
            function getScroller() { return document.scrollingElement || document.documentElement || document.body; }
            function updateScrollButton(active) {
                if (!scrollToggle) return;
                const scrollIcon = scrollToggle.querySelector('img');
                if (active) {
                    scrollToggle.classList.add('is-active');
                    if (scrollIcon && scrollIcon.dataset.iconOn) scrollIcon.src = scrollIcon.dataset.iconOn;
                } else {
                    scrollToggle.classList.remove('is-active');
                    if (scrollIcon && scrollIcon.dataset.iconOff) scrollIcon.src = scrollIcon.dataset.iconOff;
                    if (autoScrollFrame) { cancelAnimationFrame(autoScrollFrame); autoScrollFrame = null; }
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
            window.addEventListener('wheel', function () { if (autoScrollActive) { autoScrollActive = false; updateScrollButton(false); } }, { passive: true });
            window.addEventListener('touchstart', function () { if (autoScrollActive) { autoScrollActive = false; updateScrollButton(false); } }, { passive: true });

            const copyGiftButtons = document.querySelectorAll('.copy-gift-btn');
            copyGiftButtons.forEach(function (button) {
                button.addEventListener('click', async function () {
                    const textToCopy = button.dataset.copy || '';
                    if (!textToCopy) return;
                    try { await navigator.clipboard.writeText(textToCopy); }
                    catch (error) {
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
                .grad-section > p,
                .grad-section > h1,
                .grad-section > h2,
                .grad-section > h3,
                .grad-label,
                .grad-title,
                .grad-gradient,
                .grad-nav,
                .grad-hero-ticket,
                .grad-date-ticket,
                .grad-ticket-top,
                .grad-ticket-date,
                .grad-ticket-line,
                .grad-ticket-main,
                .grad-mini-kicker,
                .grad-ticket-title,
                .grad-ticket-desc,
                .grad-graduate-strip,
                .grad-strip-badge,
                .grad-ticket-actions,
                .grad-info-row,
                .grad-info-chip,
                .grad-spotlight,
                .grad-spotlight-card,
                .grad-spotlight-placeholder,
                .grad-spotlight-icon,
                .grad-floating-medal,
                .grad-confetti,
                .graduate-name-card,
                .graduate-card,
                .graduate-photo,
                .graduate-placeholder,
                .achievement-card,
                .achievement-number,
                .grad-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .grad-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('grad-show');
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
