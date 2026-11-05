<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Golden Graduation') . ' ' . ($invitation->title ?: 'Wisuda Golden Graduation'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--gold-dark);
            background:
                radial-gradient(circle at 12% 4%, var(--gold-glow-1), transparent 34%),
                radial-gradient(circle at 92% 8%, var(--gold-glow-2), transparent 34%),
                linear-gradient(180deg, #fffaf0 0%, var(--gold-soft) 46%, #ffffff 100%);
        }

        .gold-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 24px;
        }

        .gold-wrap {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            border-radius: 48px;
            background:
                radial-gradient(circle at 14% 8%, color-mix(in srgb, var(--gold-accent) 22%, transparent), transparent 28%),
                radial-gradient(circle at 82% 10%, color-mix(in srgb, var(--gold-primary) 16%, transparent), transparent 30%),
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,252,244,.95));
            border: 1px solid color-mix(in srgb, var(--gold-primary) 16%, transparent);
            box-shadow: 0 38px 96px rgba(46, 34, 12, .12);
        }

        .gold-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .42;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--gold-primary) 6%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--gold-primary) 6%, transparent) 1px, transparent 1px);
            background-size: 38px 38px;
        }

        .gold-wrap::after {
            content: "";
            position: absolute;
            width: 780px;
            height: 780px;
            right: -380px;
            top: -260px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--gold-accent) 18%, transparent), transparent 70%);
            pointer-events: none;
        }

        .gold-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            word-wrap: break-word;
            white-space: pre-line;
        }

        .gold-nav {
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
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 18px 40px rgba(46, 34, 12, .09);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .gold-nav a {
            text-decoration: none;
            color: var(--gold-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .gold-nav a:hover {
            color: var(--gold-primary);
            background: color-mix(in srgb, var(--gold-primary) 9%, white);
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
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 16px 34px rgba(46,34,12,.14);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--gold-accent) 28%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .gold-btn {
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
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--gold-primary) 23%, transparent);
        }

        .gold-btn.secondary {
            color: var(--gold-dark);
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 14px 30px rgba(46,34,12,.08);
        }

        .gold-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .gold-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .gold-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--gold-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .gold-label::before {
            content: "";
            width: 38px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-accent));
        }

        .gold-title {
            color: var(--gold-dark);
            font-weight: 950;
            letter-spacing: -.065em;
            line-height: .95;
        }

        .gold-gradient {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-primary), var(--gold-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--gold-text);
            line-height: 1.85;
        }

        /* HERO: luxury diagonal award layout */
        .gold-hero {
            min-height: 100vh;
            padding: 86px 64px 72px;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(330px, .92fr);
            gap: 46px;
            align-items: center;
        }

        .hero-left { position: relative; min-width: 0; }

        .hero-left::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            left: -120px;
            top: 40px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-accent) 23%, transparent);
            z-index: -1;
        }

        .gold-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 12px 28px rgba(46,34,12,.08);
            color: var(--gold-primary);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .gold-kicker::before {
            content: "";
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            box-shadow: inset 0 0 0 7px rgba(255,255,255,.24);
        }

        .hero-title {
            margin-top: 28px;
            max-width: 690px;
            font-size: clamp(3.2rem, 7vw, 6.4rem);
            line-height: .9;
            letter-spacing: -.075em;
        }

        .hero-desc {
            max-width: 620px;
            margin-top: 26px;
            color: var(--gold-text);
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .graduate-marquee {
            margin-top: 34px;
            width: min(100%, 650px);
            display: grid;
            grid-template-columns: 96px 1fr;
            align-items: stretch;
            overflow: hidden;
            border-radius: 34px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 22px 52px rgba(46,34,12,.10);
        }

        .graduate-mark {
            min-height: 124px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 30% 25%, rgba(255,255,255,.45), transparent 24%),
                linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            color: white;
            font-size: 38px;
            font-weight: 950;
        }

        .graduate-copy {
            padding: 22px 24px;
            min-width: 0;
        }

        .graduate-copy small {
            display: block;
            color: var(--gold-text);
            font-size: 10px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .graduate-copy strong {
            display: block;
            margin-top: 8px;
            color: var(--gold-dark);
            font-size: clamp(1.75rem, 4vw, 3rem);
            line-height: 1.02;
            letter-spacing: -.04em;
            font-weight: 950;
        }

        .graduate-copy span {
            display: block;
            margin-top: 8px;
            color: var(--gold-text);
            font-weight: 800;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .gold-visual {
            position: relative;
            min-height: 690px;
        }

        .gold-visual::before {
            content: "";
            position: absolute;
            inset: 42px 24px 28px 44px;
            border-radius: 220px 46px 46px 46px;
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--gold-primary) 18%, white),
                    color-mix(in srgb, var(--gold-accent) 32%, white)
                );
            transform: rotate(-4deg);
            box-shadow: 0 32px 78px rgba(46,34,12,.14);
        }

        .portrait-stage {
            position: relative;
            z-index: 2;
            min-height: 650px;
            border-radius: 190px 42px 42px 42px;
            overflow: hidden;
            background:
                radial-gradient(circle at 30% 14%, color-mix(in srgb, var(--gold-accent) 30%, transparent), transparent 32%),
                linear-gradient(180deg, rgba(255,255,255,.97), color-mix(in srgb, var(--gold-soft) 90%, white));
            border: 2px solid color-mix(in srgb, var(--gold-primary) 16%, transparent);
            box-shadow: inset 0 0 0 10px rgba(255,255,255,.42), 0 22px 52px rgba(46,34,12,.10);
        }

        .portrait-stage::after {
            content: "";
            position: absolute;
            inset: 22px;
            border-radius: 168px 30px 30px 30px;
            border: 1px dashed color-mix(in srgb, var(--gold-primary) 20%, transparent);
            pointer-events: none;
        }

        .portrait-stage img.cover-photo {
            width: 100%;
            height: 650px;
            object-fit: cover;
            display: block;
        }

        .portrait-placeholder {
            min-height: 650px;
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .portrait-emblem {
            width: 118px;
            height: 118px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            background:
                radial-gradient(circle at 30% 30%, rgba(255,255,255,.72), transparent 28%),
                linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            color: white;
            font-size: 50px;
            box-shadow: 0 18px 38px color-mix(in srgb, var(--gold-primary) 22%, transparent);
        }

        .portrait-placeholder h2 {
            max-width: 360px;
            color: var(--gold-dark);
            font-size: clamp(2.2rem, 4.4vw, 3.7rem);
            line-height: 1;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .portrait-placeholder p {
            max-width: 380px;
            margin-top: 18px;
            color: var(--gold-text);
            line-height: 1.85;
        }

        .date-medal {
            position: absolute;
            z-index: 5;
            left: -34px;
            bottom: 58px;
            width: 180px;
            min-height: 180px;
            border-radius: 999px;
            background:
                radial-gradient(circle at 30% 24%, rgba(255,255,255,.7), transparent 26%),
                linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            color: white;
            box-shadow: 0 22px 50px color-mix(in srgb, var(--gold-primary) 25%, transparent);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 18px;
        }

        .date-medal strong {
            font-size: 52px;
            line-height: .9;
            font-weight: 950;
            letter-spacing: -.06em;
        }

        .date-medal span {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            letter-spacing: .19em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .mini-ticket {
            position: absolute;
            z-index: 6;
            right: -22px;
            top: 68px;
            width: 220px;
            padding: 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 18px 46px rgba(46,34,12,.12);
        }

        .mini-ticket small {
            display: block;
            color: var(--gold-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .mini-ticket strong {
            display: block;
            margin-top: 9px;
            color: var(--gold-dark);
            font-weight: 950;
            line-height: 1.45;
        }

        .dot-luxe {
            position: absolute;
            z-index: 3;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: var(--gold-accent);
        }

        .dot-luxe.one { right: 20px; bottom: 94px; }
        .dot-luxe.two { left: 44px; top: 66px; background: var(--gold-secondary); }
        .dot-luxe.three { right: 120px; top: 26px; width: 12px; height: 12px; background: var(--gold-primary); }

        .quick-info {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
            width: min(100%, 720px);
        }

        .quick-card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 13%, transparent);
            box-shadow: 0 14px 34px rgba(46,34,12,.07);
        }

        .quick-card::after {
            content: "";
            position: absolute;
            width: 82px;
            height: 82px;
            right: -34px;
            bottom: -34px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-accent) 24%, transparent);
        }

        .quick-card small,
        .quick-card strong { position: relative; z-index: 2; }

        .quick-card small {
            display: block;
            color: var(--gold-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .quick-card strong {
            display: block;
            margin-top: 8px;
            color: var(--gold-dark);
            line-height: 1.45;
            font-weight: 950;
        }

        .gold-date-line,
        .gold-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            line-height: 1.5;
        }

        .gold-date-line span,
        .gold-time-line span { display: inline; }

        /* graduates */
        .graduate-royal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .graduate-royal-grid.single-graduate { grid-template-columns: minmax(280px, 430px); }

        .graduate-royal-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 38px;
            padding: 26px;
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--gold-accent) 26%, transparent), transparent 34%),
                rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 20px 48px rgba(46,34,12,.09);
        }

        .graduate-royal-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-primary) 8%, transparent);
        }

        .graduate-photo,
        .graduate-placeholder {
            width: 138px;
            height: 138px;
            border-radius: 999px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--gold-primary) 9%, white);
            border: 8px solid rgba(255,255,255,.9);
            box-shadow: 0 14px 30px rgba(46,34,12,.10);
            color: var(--gold-primary);
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
            background: color-mix(in srgb, var(--gold-primary) 10%, white);
            color: var(--gold-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .graduate-royal-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--gold-dark);
            font-size: 1.75rem;
            line-height: 1.1;
            font-weight: 950;
        }

        .graduate-royal-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--gold-text);
            line-height: 1.7;
        }

        /* highlights */
        .achievement-luxe {
            display: grid;
            gap: 20px;
            margin-top: 42px;
            justify-content: center;
        }

        .achievement-luxe.count-1 { grid-template-columns: minmax(280px, 500px); }
        .achievement-luxe.count-2 { grid-template-columns: repeat(2, minmax(280px, 440px)); }
        .achievement-luxe.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .luxe-achievement-card {
            position: relative;
            overflow: hidden;
            min-height: 230px;
            padding: 30px;
            border-radius: 36px;
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            box-shadow: 0 20px 46px rgba(46,34,12,.08);
        }

        .luxe-achievement-card::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-accent) 28%, transparent);
        }

        .achievement-number {
            position: relative;
            z-index: 2;
            width: 56px;
            height: 56px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
            margin-bottom: 22px;
        }

        .luxe-achievement-card h3,
        .luxe-achievement-card p { position: relative; z-index: 2; }

        .luxe-achievement-card h3 {
            color: var(--gold-dark);
            font-size: 1.45rem;
            font-weight: 950;
        }

        .luxe-achievement-card p {
            color: var(--gold-text);
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

        .gold-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 14%, transparent);
            border-radius: 36px;
            box-shadow: 0 20px 48px rgba(46,34,12,.08);
            padding: 30px;
        }

        .gold-card h3 {
            color: var(--gold-dark);
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
            border-top: 1px dashed color-mix(in srgb, var(--gold-primary) 18%, transparent);
        }

        .detail-row .label {
            color: var(--gold-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--gold-dark);
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
            background: linear-gradient(180deg, color-mix(in srgb, var(--gold-soft) 90%, white), white);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--gold-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--gold-text);
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
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(46,34,12,.08);
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
            color: var(--gold-dark);
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--gold-soft) 92%, white));
        }

        /* gallery */
        .gallery-golden {
            display: grid;
            grid-template-columns: 1.1fr .9fr 1fr;
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
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(46,34,12,.08);
        }

        .gallery-card.tall img { height: 360px; }
        .gallery-card.short img { height: 220px; }
        .gallery-card img {
            width: 100%;
            object-fit: cover;
            border-radius: 22px;
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
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
            box-shadow: 0 20px 44px rgba(46,34,12,.08);
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -50px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-accent) 24%, transparent);
        }

        .gift-card h3,
        .gift-copy-box,
        .gift-card p { position: relative; z-index: 2; }

        .gift-card h3 {
            color: var(--gold-dark);
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
            background: color-mix(in srgb, var(--gold-primary) 8%, white);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            color: var(--gold-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--gold-primary);
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
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-secondary));
        }

        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        /* rsvp */
        .rsvp-wrap { max-width: 900px; width: 100%; margin: 0 auto; }

        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(46,34,12,.08);
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
        .summary-card strong { display: block; color: var(--gold-dark); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: var(--gold-text); font-size: 12px; font-weight: 900; }

        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold-primary) 11%, white);
            color: var(--gold-primary);
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
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--gold-primary) 12%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--gold-accent) 24%, transparent), transparent 36%),
                rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--gold-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(46,34,12,.08);
        }

        @media (max-width: 1080px) {
            .gold-hero,
            .detail-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .gold-visual { min-height: auto; }
            .portrait-stage { min-height: 560px; }
            .portrait-stage img.cover-photo,
            .portrait-placeholder { min-height: 560px; height: auto; }
            .date-medal,
            .mini-ticket { position: relative; left: auto; right: auto; top: auto; bottom: auto; width: auto; min-height: auto; margin-top: 14px; border-radius: 30px; }
            .mini-ticket { width: auto; }
            .achievement-luxe.count-3 { grid-template-columns: repeat(2, minmax(280px, 440px)); }
            .gallery-golden { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .gold-shell { padding: 0; }
            .gold-wrap { border-radius: 0; box-shadow: none; }
            .gold-section,
            .gold-hero { padding: 72px 22px; }
            .gold-section.compact { padding-top: 64px; padding-bottom: 64px; }

            .gold-hero { gap: 30px; }
            .hero-left { text-align: center; }
            .hero-title { font-size: clamp(2.5rem, 13vw, 4rem); line-height: .98; }
            .hero-desc { font-size: 1rem; }
            .hero-actions { justify-content: center; }

            .graduate-marquee { grid-template-columns: 1fr; text-align: center; }
            .graduate-mark { min-height: 82px; }
            .quick-info,
            .achievement-luxe,
            .achievement-luxe.count-1,
            .achievement-luxe.count-2,
            .achievement-luxe.count-3,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .gallery-column {
                grid-template-columns: 1fr;
            }

            .portrait-stage {
                min-height: 470px;
                border-radius: 110px 30px 30px 30px;
            }
            .portrait-stage::after { border-radius: 94px 22px 22px 22px; }
            .portrait-stage img.cover-photo,
            .portrait-placeholder { min-height: 470px; height: auto; }
            .portrait-placeholder { padding: 30px; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .floating-actions { right: 10px; transform: translateY(-50%) scale(.9); transform-origin: right center; }
        }

        /* =====================================================
        LUXURY GOLDEN GRADUATION ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        .gold-reveal,
        .gold-section > p,
        .gold-section > h1,
        .gold-section > h2,
        .gold-section > h3,
        .gold-label,
        .gold-title,
        .gold-gradient,
        .gold-nav,
        .gold-hero,
        .hero-left,
        .gold-kicker,
        .hero-title,
        .hero-desc,
        .graduate-marquee,
        .graduate-mark,
        .graduate-copy,
        .hero-actions,
        .quick-info,
        .quick-card,
        .gold-visual,
        .portrait-stage,
        .portrait-placeholder,
        .portrait-emblem,
        .date-medal,
        .mini-ticket,
        .dot-luxe,
        .graduate-royal-card,
        .graduate-photo,
        .graduate-placeholder,
        .graduate-role,
        .luxe-achievement-card,
        .achievement-number,
        .gold-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .gold-btn {
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

        .gold-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .gold-nav {
            animation: goldNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .gold-kicker {
            animation: goldFadeDown .85s ease .16s both;
        }

        #opening .hero-title {
            animation: goldTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .32s both;
        }

        #opening .hero-desc {
            animation: goldFadeUp .85s ease .48s both;
        }

        #opening .graduate-marquee {
            animation: goldFadeUp .9s ease .62s both;
        }

        #opening .hero-actions {
            animation: goldFadeUp .9s ease .74s both;
        }

        #opening .quick-card {
            animation: goldFadeUp .9s ease .84s both;
        }

        #opening .portrait-stage {
            animation:
                goldPortraitEnter 1.12s cubic-bezier(.2, .8, .2, 1) .28s both,
                goldPortraitFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .date-medal {
            animation:
                goldMedalEnter .95s cubic-bezier(.2, .8, .2, 1) .72s both,
                goldMedalFloat 4.8s ease-in-out 1.5s infinite;
        }

        #opening .mini-ticket {
            animation:
                goldTicketEnter .95s cubic-bezier(.2, .8, .2, 1) .82s both,
                goldTicketFloat 5s ease-in-out 1.6s infinite;
        }

        /* Background hidup dan mahal */
        .gold-wrap {
            animation: goldWrapGlow 8s ease-in-out infinite alternate;
        }

        .gold-wrap::before {
            animation: goldGridMove 20s linear infinite;
        }

        .gold-wrap::after,
        .hero-left::before,
        .gold-visual::before,
        .quick-card::after,
        .gift-card::after,
        .graduate-royal-card::after,
        .luxe-achievement-card::after {
            animation: goldDecorFloat 6.4s ease-in-out infinite;
        }

        /* Dot ornamen */
        .dot-luxe.one {
            animation: goldDotOne 4.8s ease-in-out infinite;
        }

        .dot-luxe.two {
            animation: goldDotTwo 5.2s ease-in-out .2s infinite;
        }

        .dot-luxe.three {
            animation: goldDotThree 5.4s ease-in-out .35s infinite;
        }

        /* Label / kicker glow */
        .gold-label::before,
        .gold-kicker::before {
            animation: goldLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Tombol efek kilau */
        .gold-btn,
        button.gold-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .gold-btn::after,
        button.gold-btn::after,
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
            animation: goldButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .graduate-marquee:hover,
            .quick-card:hover,
            .portrait-stage:hover,
            .date-medal:hover,
            .mini-ticket:hover,
            .graduate-royal-card:hover,
            .luxe-achievement-card:hover,
            .gold-card:hover,
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
                border-color: color-mix(in srgb, var(--gold-primary) 36%, transparent) !important;
                box-shadow:
                    0 34px 88px color-mix(in srgb, var(--gold-primary) 16%, transparent),
                    0 0 48px color-mix(in srgb, var(--gold-accent) 20%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.80) !important;
            }

            .portrait-stage:hover img,
            .gallery-card:hover img,
            .graduate-royal-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }

            .gold-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--gold-primary) 14%, transparent);
            }
        }

        .portrait-stage img,
        .gallery-card img,
        .graduate-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: goldNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon dan angka pulse */
        .graduate-mark,
        .portrait-emblem,
        .achievement-number,
        .date-medal,
        .graduate-placeholder,
        .gift-number,
        .message-badge {
            animation: goldSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-card:nth-child(3n+1) {
            animation: goldGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-card:nth-child(3n+2) {
            animation: goldGalleryMiddle 4.8s ease-in-out .18s infinite;
        }

        .gallery-card:nth-child(3n+3) {
            animation: goldGalleryRight 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: goldFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes goldNavEnter {
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

        @keyframes goldFadeDown {
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

        @keyframes goldFadeUp {
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

        @keyframes goldTitleIn {
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

        @keyframes goldPortraitEnter {
            from {
                opacity: 0;
                transform: translateX(30px) translateY(36px) scale(.92) rotate(4deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes goldPortraitFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes goldMedalEnter {
            from {
                opacity: 0;
                transform: translateY(30px) scale(.82) rotate(-8deg);
                filter: blur(9px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes goldMedalFloat {
            0%, 100% {
                transform: translateY(0) rotate(0);
            }
            50% {
                transform: translateY(-8px) rotate(-1.5deg);
            }
        }

        @keyframes goldTicketEnter {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.9) rotate(4deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes goldTicketFloat {
            0%, 100% {
                transform: translateY(0) rotate(0);
            }
            50% {
                transform: translateY(-7px) rotate(1deg);
            }
        }

        @keyframes goldWrapGlow {
            from {
                box-shadow:
                    0 38px 96px color-mix(in srgb, var(--gold-primary) 10%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 46px 126px color-mix(in srgb, var(--gold-primary) 15%, transparent),
                    0 0 66px color-mix(in srgb, var(--gold-accent) 20%, transparent);
            }
        }

        @keyframes goldGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 152px 152px, 152px 152px;
            }
        }

        @keyframes goldDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes goldDotOne {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-13px) rotate(12deg) scale(1.15);
            }
        }

        @keyframes goldDotTwo {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-10px) rotate(-10deg) scale(1.12);
            }
        }

        @keyframes goldDotThree {
            0%, 100% {
                transform: translateY(0) rotate(0) scale(1);
            }
            50% {
                transform: translateY(-12px) rotate(8deg) scale(1.14);
            }
        }

        @keyframes goldLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--gold-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--gold-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes goldButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes goldNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--gold-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--gold-accent) 48%, transparent),
                    0 0 34px color-mix(in srgb, var(--gold-primary) 20%, transparent);
            }
        }

        @keyframes goldSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes goldGalleryLeft {
            0%, 100% {
                transform: translateY(0) rotate(-.5deg);
            }
            50% {
                transform: translateY(-7px) rotate(-1deg);
            }
        }

        @keyframes goldGalleryMiddle {
            0%, 100% {
                transform: translateY(0) rotate(.3deg);
            }
            50% {
                transform: translateY(-6px) rotate(.8deg);
            }
        }

        @keyframes goldGalleryRight {
            0%, 100% {
                transform: translateY(0) rotate(.2deg);
            }
            50% {
                transform: translateY(-7px) rotate(.7deg);
            }
        }

        @keyframes goldFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .gold-reveal,
            .gold-section > p,
            .gold-section > h1,
            .gold-section > h2,
            .gold-section > h3,
            .gold-label,
            .gold-title,
            .gold-gradient,
            .gold-nav,
            .gold-hero,
            .hero-left,
            .gold-kicker,
            .hero-title,
            .hero-desc,
            .graduate-marquee,
            .graduate-mark,
            .graduate-copy,
            .hero-actions,
            .quick-info,
            .quick-card,
            .gold-visual,
            .portrait-stage,
            .portrait-placeholder,
            .portrait-emblem,
            .date-medal,
            .mini-ticket,
            .dot-luxe,
            .graduate-royal-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .luxe-achievement-card,
            .achievement-number,
            .gold-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .gold-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .portrait-stage {
                animation:
                    goldFadeUp .9s ease .3s both,
                    goldFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .gold-reveal,
            .gold-section > p,
            .gold-section > h1,
            .gold-section > h2,
            .gold-section > h3,
            .gold-label,
            .gold-title,
            .gold-gradient,
            .gold-nav,
            .gold-hero,
            .hero-left,
            .gold-kicker,
            .hero-title,
            .hero-desc,
            .graduate-marquee,
            .graduate-mark,
            .graduate-copy,
            .hero-actions,
            .quick-info,
            .quick-card,
            .gold-visual,
            .portrait-stage,
            .portrait-placeholder,
            .portrait-emblem,
            .date-medal,
            .mini-ticket,
            .dot-luxe,
            .graduate-royal-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .luxe-achievement-card,
            .achievement-number,
            .gold-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .gold-btn,
            .gold-wrap,
            .gold-wrap::before,
            .gold-wrap::after,
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

    $eventTitle = $invitation->title ?: 'Golden Graduation';
    $eventName = $invitation->event_name ?: 'Wisuda & Syukuran Kelulusan';
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
        "Dengan penuh rasa bahagia dan syukur, kami mengundang Anda untuk hadir dalam acara:\n\n" .
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
            if ($endDateTime->lessThanOrEqualTo($startDateTime)) { $endDateTime = $startDateTime->copy()->addHours(3); }

            $calendarTitle = trim(($invitation->event_name ?: 'Golden Graduation') . ' - ' . $invitation->title);
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

    $goldHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $goldHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --gold-primary: {{ $activeTheme['primary'] }};
        --gold-secondary: {{ $activeTheme['secondary'] }};
        --gold-accent: {{ $activeTheme['accent'] }};
        --gold-dark: {{ $activeTheme['dark'] }};
        --gold-text: {{ $activeTheme['text'] }};
        --gold-soft: {{ $activeTheme['soft'] }};
        --gold-glow-1: {{ $activeTheme['glow1'] }};
        --gold-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="gold-shell">
        <div class="gold-wrap">
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

            <nav class="gold-nav">
                <a href="#graduate">Wisudawan</a>
                <a href="#detail">Detail</a>
                @if ($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if ($giftCount) <a href="#gift">Hadiah</a> @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="gold-hero">
                <div class="hero-left">
                    <div class="gold-kicker">{{ $eventName }}</div>

                    <h1 class="responsive-text gold-title gold-gradient hero-title">
                        {{ $eventTitle }}
                    </h1>

                    <p class="responsive-text hero-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa syukur dan bangga, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang istimewa ini.' }}
                    </p>

                    <div class="graduate-marquee">
                        <div class="graduate-mark"><img src="{{ asset('assets/icons/Topi.png') }}" alt="Topi" class="w-10 h-10"></div>
                        <div class="graduate-copy">
                            <small>Yang Berbahagia</small>
                            <strong class="responsive-text">{{ $graduateHeroName }}</strong>
                            @if ($graduateHeroSubtitle)
                                <span class="responsive-text">{{ $graduateHeroSubtitle }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="hero-actions">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="gold-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="gold-btn">Lihat Detail</a>
                        @endif

                        <a href="#detail" class="gold-btn secondary">Detail Acara</a>
                        <a href="#message" class="gold-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="quick-info">
                        <div class="quick-card">
                            <small>Tanggal</small>
                            <strong class="gold-date-line">
                                @if ($invitation->event_date)
                                    <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span>Belum diatur</span>
                                @endif
                            </strong>
                        </div>

                        <div class="quick-card">
                            <small>Waktu</small>
                            <strong class="gold-time-line">
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

                        <div class="quick-card">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">{{ $accessName }}</strong>
                        </div>
                    </div>
                </div>

                <div class="gold-visual">
                    <span class="dot-luxe one"></span>
                    <span class="dot-luxe two"></span>
                    <span class="dot-luxe three"></span>

                    <div class="portrait-stage">
                        @if ($invitation->cover_image)
                            <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Wisuda" class="cover-photo">
                        @elseif ($firstPhoto)
                            <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Wisuda" class="cover-photo">
                        @else
                            <div class="portrait-placeholder">
                                <div class="portrait-emblem"><img src="{{ asset('assets/icons/Topi.png') }}" alt="Topi" class="w-10 h-10"></div>
                                <h2 class="responsive-text">Golden Moment of Graduation</h2>
                                <p class="responsive-text">Rayakan pencapaian, doa keluarga, dan langkah baru menuju masa depan yang lebih gemilang.</p>
                            </div>
                        @endif
                    </div>

                    <div class="date-medal">
                        @if ($invitation->event_date)
                            <strong>{{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}</strong>
                            <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('M Y') }}</span>
                        @else
                            <strong>--</strong>
                            <span>Tanggal</span>
                        @endif
                    </div>

                    <div class="mini-ticket">
                        <small>Hosted by</small>
                        <strong class="responsive-text">{{ $hostName ?: 'Keluarga Besar' }}</strong>
                    </div>
                </div>
            </section>

            {{-- GRADUATE --}}
            <section id="graduate" class="gold-section compact text-center">
                <p class="gold-label justify-center">The Graduate</p>
                <h2 class="responsive-text gold-title text-5xl md:text-6xl mt-6">Wisudawan / Wisudawati</h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--gold-text); line-height: 1.85;">
                    Bagian ini menampilkan tokoh utama acara, lulusan, atau wisudawan yang sedang merayakan momen kelulusan.
                </p>

                <div class="graduate-royal-grid {{ $invitation->people->count() <= 1 ? 'single-graduate' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="graduate-royal-card">
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
                        <div class="graduate-royal-card">
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
                <section id="achievement" class="gold-section compact">
                    <div class="section-head">
                        <p class="gold-label justify-center">Achievement Moment</p>
                        <h2 class="responsive-text gold-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Hari Bahagia Penuh Prestasi' }}
                        </h2>
                        <p class="responsive-text desc">
                            {{ $hostName
                                ? 'Acara ini diselenggarakan oleh ' . $hostName . ' untuk merayakan pencapaian, perjuangan, dan langkah baru yang membanggakan.'
                                : 'Momen wisuda adalah perayaan atas doa, perjuangan, pencapaian, dan awal perjalanan baru yang penuh harapan.'
                            }}
                        </p>
                    </div>

                    @if ($highlightCount)
                        <div class="achievement-luxe {{ $highlightGridClass }}">
                            @foreach ($goldHighlights as $index => $highlight)
                                <div class="luxe-achievement-card">
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
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="gold-section compact">
                <div class="section-head">
                    <p class="gold-label justify-center">Schedule & Venue</p>
                    <h2 class="gold-title text-5xl md:text-6xl mt-6">Detail Acara Wisuda</h2>
                    <p class="responsive-text desc">Simpan jadwal dan pastikan hadir pada momen bahagia ini.</p>
                </div>

                <div class="detail-layout">
                    <div class="gold-card">
                        <h3>Informasi Acara</h3>
                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label ml-2">Acara</div>
                                <div class="value responsive-text ml-2">{{ $eventName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value gold-date-line ml-2">
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
                                <div class="value gold-time-line ml-2">
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
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="gold-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="gold-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="gold-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black" style="color: var(--gold-text);" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Countdown Kelulusan</h3>
                            <p class="responsive-text mt-3 leading-7" style="color: var(--gold-text);">
                                Persiapkan diri untuk hadir dan ikut merayakan hari yang penuh kebanggaan ini.
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
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--gold-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--gold-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--gold-text);">Link online belum ditambahkan.</p>
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
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--gold-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--gold-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--gold-text);">{{ $accessDescription }}</p>
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
                <section id="gallery" class="gold-section compact text-center">
                    <p class="gold-label justify-center">Golden Memories</p>
                    <h2 class="gold-title text-5xl md:text-6xl mt-6">Galeri Wisuda</h2>
                    <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--gold-text); line-height: 1.85;">
                        Kenangan istimewa dari momen kelulusan yang penuh rasa syukur dan kebanggaan.
                    </p>

                    <div class="gallery-golden">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="gold-section compact">
                    <div class="section-head">
                        <p class="gold-label justify-center">Gift & Appreciation</p>

                        <h2 class="gold-title text-5xl md:text-6xl mt-6">
                            Kirim Hadiah
                        </h2>

                        <p class="responsive-text desc">
                            Jika berkenan, tamu dapat mengirimkan hadiah digital melalui informasi berikut.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Hadiah Digital';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card">
                                <h3 class="responsive-text">
                                    {{ $giftLabel }}
                                </h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>

                                        <div class="gift-number responsive-text">
                                            {{ $giftNumber }}
                                        </div>

                                        <p class="responsive-text text-sm mt-2" style="color: var(--gold-text);">
                                            Atas Nama {{ $giftName }}
                                        </p>
                                    </div>

                                    @if ($giftNumber !== '-')
                                        <button type="button"
                                                class="copy-gift-btn"
                                                data-copy="{{ $giftNumber }}">
                                            Salin
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="gold-section compact">
                <div class="text-center">
                    <p class="gold-label justify-center">RSVP & Wishes</p>
                    <h2 class="gold-title text-5xl md:text-6xl mt-6">Ucapan & Kehadiran</h2>
                    <p class="responsive-text mt-4 max-w-2xl mx-auto" style="color: var(--gold-text); line-height: 1.85;">
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

                        <button type="submit" class="w-full gold-btn">Kirim Ucapan</button>
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
                                        <p class="responsive-text font-black" style="color: var(--gold-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--gold-text);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--gold-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p style="color: var(--gold-text);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="gold-section text-center">
                <div class="closing-card">
                    <p class="gold-label justify-center">Thank You</p>
                    <h2 class="responsive-text gold-title gold-gradient text-5xl md:text-7xl mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--gold-text);">
                        Terima kasih atas doa, kehadiran, dan dukungan yang diberikan. Semoga momen kelulusan ini menjadi awal perjalanan baru yang penuh keberkahan dan kebahagiaan.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--gold-dark);">{{ $eventTitle }}</h3>
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

            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = this.getAttribute('data-copy');
                    if (!value) return;

                    try {
                        await navigator.clipboard.writeText(value);
                        const original = this.textContent;
                        this.textContent = 'Tersalin';
                        this.classList.add('copied');

                        setTimeout(() => {
                            this.textContent = original;
                            this.classList.remove('copied');
                        }, 1800);
                    } catch (error) {
                        alert('Nomor belum bisa disalin otomatis. Silakan salin manual: ' + value);
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
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .gold-section > p,
                .gold-section > h1,
                .gold-section > h2,
                .gold-section > h3,
                .gold-label,
                .gold-title,
                .gold-gradient,
                .gold-nav,
                .gold-hero,
                .hero-left,
                .gold-kicker,
                .hero-title,
                .hero-desc,
                .graduate-marquee,
                .graduate-mark,
                .graduate-copy,
                .hero-actions,
                .quick-info,
                .quick-card,
                .gold-visual,
                .portrait-stage,
                .portrait-placeholder,
                .portrait-emblem,
                .date-medal,
                .mini-ticket,
                .dot-luxe,
                .graduate-royal-card,
                .graduate-photo,
                .graduate-placeholder,
                .graduate-role,
                .luxe-achievement-card,
                .achievement-number,
                .gold-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .gold-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('gold-show');
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
