<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Campus Pride Graduation') . ' ' . ($invitation->title ?: 'Wisuda Campus Pride'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--campus-dark);
            background:
                radial-gradient(circle at 8% 4%, var(--campus-glow-1), transparent 34%),
                radial-gradient(circle at 92% 8%, var(--campus-glow-2), transparent 36%),
                linear-gradient(180deg, #ffffff 0%, #ffffff 64%, #fbfffd 100%);
        }

        .campus-shell { width: min(100%, 1240px); margin: 0 auto; padding: 24px; }

        .campus-wrap {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            border-radius: 46px;
            background:
                radial-gradient(circle at 8% 10%, color-mix(in srgb, var(--campus-primary) 5%, transparent), transparent 30%),
                radial-gradient(circle at 92% 14%, color-mix(in srgb, var(--campus-accent) 50%, transparent), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, #ffffff 100%);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 9%, transparent);
            box-shadow: 0 34px 90px rgba(16, 24, 40, .06);
        }

        .campus-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .22;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--campus-primary) 3%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--campus-primary) 3%, transparent) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .campus-wrap::after {
            content: "";
            position: absolute;
            width: 680px;
            height: 680px;
            left: -360px;
            bottom: -360px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--campus-primary) 8%, transparent), transparent 68%);
            pointer-events: none;
        }

        .campus-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            word-wrap: break-word;
            white-space: pre-line;
        }

        .campus-nav {
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
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(16,24,40,.08);
            display: flex;
            gap: 6px;
            overflow-x: auto;
        }

        .campus-nav a {
            text-decoration: none;
            color: var(--campus-text);
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .campus-nav a:hover {
            color: var(--campus-primary);
            background: color-mix(in srgb, var(--campus-primary) 8%, white);
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
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(16,24,40,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--campus-accent) 28%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .campus-btn {
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
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
            box-shadow: 0 18px 38px color-mix(in srgb, var(--campus-primary) 22%, transparent);
        }

        .campus-btn.secondary {
            color: var(--campus-dark);
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 14%, transparent);
            box-shadow: 0 14px 30px rgba(16,24,40,.08);
        }

        .campus-section {
            min-height: 100vh;
            padding: 88px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .campus-section.compact { min-height: auto; padding-top: 78px; padding-bottom: 78px; }

        .campus-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: var(--campus-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .campus-label::before {
            content: "";
            width: 38px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-accent));
        }

        .campus-title {
            color: var(--campus-dark);
            font-weight: 950;
            letter-spacing: -.065em;
            line-height: .95;
        }

        .campus-gradient {
            background: linear-gradient(135deg, var(--campus-dark), var(--campus-primary), var(--campus-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-head { text-align: center; }
        .section-head .desc { max-width: 760px; margin: 16px auto 0; color: var(--campus-text); line-height: 1.85; }

        /* HERO */
        .campus-hero {
            min-height: 100vh;
            padding: 78px 64px 72px;
            display: grid;
            grid-template-columns: minmax(280px, .86fr) minmax(0, 1.14fr);
            gap: 34px;
            align-items: center;
        }

        .campus-id-card {
            position: relative;
            min-height: 660px;
            border-radius: 42px;
            padding: 26px;
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--campus-accent) 46%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--campus-soft) 94%, white));
            border: 1px solid color-mix(in srgb, var(--campus-primary) 9%, transparent);
            box-shadow: 0 24px 62px rgba(16, 24, 40, .065);
            overflow: hidden;
        }

        .campus-id-card::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            right: -145px;
            top: -145px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-accent) 28%, transparent);
        }

        .campus-id-card::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            left: -120px;
            bottom: -120px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-primary) 10%, transparent);
        }

        .id-top {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
        }

        .id-chip {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 13px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            color: var(--campus-primary);
            font-size: 11px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
            box-shadow: 0 10px 24px rgba(16,24,40,.06);
        }

        .id-chip::before {
            content: "";
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
        }

        .id-number {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            font-size: 28px;
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
            box-shadow: 0 18px 34px color-mix(in srgb, var(--campus-primary) 22%, transparent);
        }

        .graduate-id-body {
            position: relative;
            z-index: 2;
            min-height: 472px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .id-photo-frame {
            position: relative;
            width: min(100%, 370px);
            margin: 34px auto 0;
            border-radius: 40px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(16,24,40,.09);
        }

        .id-photo-frame img {
            width: 100%;
            height: 330px;
            object-fit: cover;
            display: block;
        }

        .id-photo-placeholder {
            width: 100%;
            height: 330px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 28% 22%, color-mix(in srgb, var(--campus-accent) 30%, transparent), transparent 35%),
                color-mix(in srgb, var(--campus-soft) 84%, white);
            color: var(--campus-primary);
            font-size: 76px;
            font-weight: 950;
        }

        .id-details {
            margin-top: 24px;
            padding: 24px;
            border-radius: 32px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 10%, transparent);
        }

        .id-details small {
            display: block;
            color: var(--campus-text);
            font-size: 10px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .id-details strong {
            display: block;
            margin-top: 8px;
            color: var(--campus-dark);
            font-size: clamp(1.7rem, 4vw, 2.6rem);
            line-height: 1.02;
            letter-spacing: -.04em;
            font-weight: 950;
        }

        .id-details span {
            display: block;
            margin-top: 8px;
            color: var(--campus-text);
            font-weight: 800;
            line-height: 1.5;
        }

        .campus-hero-main { position: relative; min-width: 0; }

        .campus-hero-main::before {
            content: "";
            position: absolute;
            width: 460px;
            height: 460px;
            right: -160px;
            top: -150px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-primary) 8%, transparent);
            z-index: -1;
        }

        .campus-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 14%, transparent);
            box-shadow: 0 12px 28px rgba(16,24,40,.08);
            color: var(--campus-primary);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .campus-kicker::before {
            content: "";
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
            box-shadow: inset 0 0 0 7px rgba(255,255,255,.24);
        }

        .hero-campus-title {
            margin-top: 30px;
            max-width: 780px;
            font-size: clamp(3.1rem, 7vw, 6.6rem);
            line-height: .9;
            letter-spacing: -.075em;
        }

        .hero-campus-desc {
            max-width: 650px;
            margin-top: 26px;
            color: var(--campus-text);
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .campus-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 32px; }

        .campus-info-band {
            margin-top: 36px;
            width: min(100%, 760px);
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .campus-info-card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.9);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 14px 34px rgba(16,24,40,.07);
        }

        .campus-info-card::after {
            content: "";
            position: absolute;
            width: 86px;
            height: 86px;
            right: -36px;
            bottom: -36px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-accent) 26%, transparent);
        }

        .campus-info-card small,
        .campus-info-card strong { position: relative; z-index: 2; }

        .campus-info-card small {
            display: block;
            color: var(--campus-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .campus-info-card strong {
            display: block;
            margin-top: 8px;
            color: var(--campus-dark);
            line-height: 1.45;
            font-weight: 950;
        }

        .campus-stamp-row { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }

        .campus-stamp {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 12px 14px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 12px 24px rgba(16,24,40,.06);
            color: var(--campus-text);
            font-size: 12px;
            font-weight: 900;
        }

        .campus-stamp span {
            width: 12px;
            height: 12px;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
            transform: rotate(12deg);
        }

        .campus-date-line,
        .campus-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 6px;
            line-height: 1.5;
        }

        .campus-date-line span,
        .campus-time-line span { display: inline; }

        .graduate-campus-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .graduate-campus-grid.single-graduate { grid-template-columns: minmax(280px, 430px); }

        .graduate-campus-card {
            position: relative;
            overflow: hidden;
            text-align: left;
            border-radius: 34px;
            padding: 26px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 13%, transparent);
            box-shadow: 0 18px 42px rgba(16,24,40,.08);
        }

        .graduate-campus-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 8px;
            background: linear-gradient(90deg, var(--campus-primary), var(--campus-secondary), var(--campus-accent));
        }

        .graduate-campus-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-primary) 8%, transparent);
        }

        .graduate-photo,
        .graduate-placeholder {
            width: 132px;
            height: 132px;
            border-radius: 32px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--campus-primary) 9%, white);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 13%, transparent);
            box-shadow: 0 14px 30px rgba(16,24,40,.08);
            color: var(--campus-primary);
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
            background: color-mix(in srgb, var(--campus-primary) 10%, white);
            color: var(--campus-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .graduate-campus-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--campus-dark);
            font-size: 1.75rem;
            line-height: 1.1;
            font-weight: 950;
        }

        .graduate-campus-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--campus-text);
            line-height: 1.7;
        }

        .pride-layout {
            display: grid;
            grid-template-columns: .86fr 1.14fr;
            gap: 24px;
            align-items: stretch;
            margin-top: 42px;
        }

        .pride-panel {
            position: relative;
            overflow: hidden;
            border-radius: 40px;
            padding: 34px;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--campus-soft) 86%, white));
            border: 1px solid color-mix(in srgb, var(--campus-primary) 13%, transparent);
            box-shadow: 0 22px 54px rgba(16,24,40,.08);
            min-height: 360px;
        }

        .pride-panel::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            right: -96px;
            bottom: -96px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-primary) 9%, transparent);
        }

        .pride-panel .big-number {
            position: relative;
            z-index: 2;
            color: var(--campus-primary);
            font-size: clamp(4rem, 10vw, 8rem);
            line-height: .8;
            letter-spacing: -.08em;
            font-weight: 950;
        }

        .pride-panel h3 {
            position: relative;
            z-index: 2;
            margin-top: 26px;
            color: var(--campus-dark);
            font-size: clamp(2rem, 4vw, 3.4rem);
            line-height: 1;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .pride-panel p { position: relative; z-index: 2; color: var(--campus-text); margin-top: 18px; line-height: 1.85; }

        .achievement-campus {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .achievement-campus.count-1 { grid-template-columns: minmax(280px, 500px); justify-content: center; }
        .achievement-campus.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .campus-achievement-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 26px;
            border-radius: 32px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(16,24,40,.07);
        }

        .campus-achievement-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            right: -46px;
            bottom: -46px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--campus-accent) 26%, transparent);
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
            background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary));
            margin-bottom: 20px;
        }

        .campus-achievement-card h3,
        .campus-achievement-card p { position: relative; z-index: 2; }
        .campus-achievement-card h3 { color: var(--campus-dark); font-size: 1.35rem; font-weight: 950; }
        .campus-achievement-card p { color: var(--campus-text); margin-top: 10px; line-height: 1.8; }

        .detail-layout { display: grid; grid-template-columns: .95fr 1.05fr; gap: 24px; margin-top: 42px; align-items: start; }

        .campus-card {
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 13%, transparent);
            border-radius: 36px;
            box-shadow: 0 20px 48px rgba(16,24,40,.08);
            padding: 30px;
        }

        .campus-card h3 { color: var(--campus-dark); font-size: 2rem; font-weight: 950; margin: 0; }
        .detail-list { display: grid; gap: 14px; margin-top: 24px; }
        .detail-row { display: grid; grid-template-columns: 112px 1fr; gap: 16px; padding: 16px 0; border-top: 1px dashed color-mix(in srgb, var(--campus-primary) 18%, transparent); }
        .detail-row .label { color: var(--campus-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .detail-row .value { color: var(--campus-dark); font-weight: 900; line-height: 1.65; }

        .countdown-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .countdown-card { padding: 22px 14px; text-align: center; border-radius: 26px; background: linear-gradient(180deg, color-mix(in srgb, var(--campus-soft) 90%, white), white); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); }
        .countdown-number { display: block; color: var(--campus-dark); font-size: 34px; line-height: 1; font-weight: 950; }
        .countdown-label { display: block; margin-top: 10px; color: var(--campus-text); font-size: 11px; font-weight: 900; letter-spacing: .16em; text-transform: uppercase; }

        .map-card { margin-top: 22px; overflow: hidden; border-radius: 30px; background: #ffffff; border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); box-shadow: 0 16px 38px rgba(16,24,40,.08); }
        .map-frame, .map-placeholder { width: 100%; height: 300px; display: block; border: 0; }
        .map-placeholder { display: flex; align-items: center; justify-content: center; padding: 32px; text-align: center; text-decoration: none; color: var(--campus-dark); background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--campus-soft) 92%, white)); }

        .gallery-campus { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-top: 38px; align-items: stretch; }
        .gallery-campus-feature { border-radius: 38px; overflow: hidden; padding: 12px; background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); box-shadow: 0 18px 42px rgba(16,24,40,.08); }
        .gallery-campus-feature img { width: 100%; height: 560px; object-fit: cover; border-radius: 28px; display: block; }
        .gallery-campus-side { display: grid; gap: 18px; }
        .gallery-campus-card { border-radius: 32px; overflow: hidden; padding: 10px; background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); box-shadow: 0 18px 42px rgba(16,24,40,.08); }
        .gallery-campus-card img { width: 100%; height: 262px; object-fit: cover; border-radius: 22px; display: block; }

        .gift-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 34px; }
        .gift-grid.gift-count-1 { grid-template-columns: minmax(280px, 520px); justify-content: center; }
        .gift-card { position: relative; overflow: hidden; padding: 26px; border-radius: 34px; background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); box-shadow: 0 20px 44px rgba(16,24,40,.08); }
        .gift-card::after { content: ""; position: absolute; width: 140px; height: 140px; right: -50px; top: -50px; border-radius: 999px; background: color-mix(in srgb, var(--campus-accent) 24%, transparent); }
        .gift-card h3, .gift-copy-box, .gift-card p { position: relative; z-index: 2; }
        .gift-card h3 { color: var(--campus-dark); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: color-mix(in srgb, var(--campus-primary) 8%, white); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); }
        .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 900; color: var(--campus-text); }
        .gift-number { display: block; margin-top: 6px; color: var(--campus-primary); font-size: 1.1rem; font-weight: 950; }
        .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: white; font-size: 12px; font-weight: 900; background: linear-gradient(135deg, var(--campus-primary), var(--campus-secondary)); }
        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        .rsvp-wrap { max-width: 900px; width: 100%; margin: 0 auto; }
        .form-card, .message-card, .summary-card { background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent); box-shadow: 0 16px 34px rgba(16,24,40,.08); border-radius: 30px; }
        .form-card { padding: 28px; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .summary-card { padding: 20px; text-align: center; }
        .summary-card strong { display: block; color: var(--campus-dark); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: var(--campus-text); font-size: 12px; font-weight: 900; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-badge { padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--campus-primary) 11%, white); color: var(--campus-primary); font-size: 12px; font-weight: 900; white-space: nowrap; }

        .closing-card {
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
            border-radius: 42px;
            padding: 48px 34px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--campus-primary) 10%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--campus-accent) 24%, transparent), transparent 36%),
                rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--campus-primary) 12%, transparent);
            box-shadow: 0 18px 44px rgba(16,24,40,.08);
        }

        .campus-id-card,
        .campus-info-card,
        .campus-card,
        .graduate-campus-card,
        .campus-achievement-card,
        .pride-panel,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card,
        .closing-card,
        .gallery-campus-feature,
        .gallery-campus-card {
            background-color: rgba(255, 255, 255, .97);
            border-color: color-mix(in srgb, var(--campus-primary) 8%, transparent);
            box-shadow: 0 18px 46px rgba(16, 24, 40, .055);
        }

        .campus-info-card::after,
        .campus-achievement-card::after,
        .gift-card::after {
            background: color-mix(in srgb, var(--campus-accent) 46%, transparent);
        }

        @media (max-width: 1080px) {
            .campus-hero, .detail-layout, .pride-layout, .gift-grid, .gallery-campus { grid-template-columns: 1fr; }
            .campus-id-card { min-height: auto; }
            .graduate-id-body { min-height: auto; }
            .campus-info-band, .achievement-campus, .achievement-campus.count-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .gallery-campus-feature img { height: 380px; }
        }

        @media (max-width: 640px) {
            .campus-shell { padding: 0; }
            .campus-wrap { border-radius: 0; box-shadow: none; }
            .campus-section, .campus-hero { padding: 72px 22px; }
            .campus-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .campus-hero { gap: 30px; }
            .campus-hero-main { text-align: center; }
            .hero-campus-title { font-size: clamp(2.55rem, 13vw, 4rem); line-height: .98; }
            .hero-campus-desc { font-size: 1rem; }
            .campus-actions, .campus-stamp-row { justify-content: center; }
            .campus-info-band, .achievement-campus, .achievement-campus.count-1, .achievement-campus.count-3, .countdown-grid, .summary-grid, .gift-grid, .gift-grid.gift-count-1 { grid-template-columns: 1fr; }
            .id-number { width: 64px; height: 64px; border-radius: 20px; font-size: 24px; }
            .id-photo-frame img, .id-photo-placeholder { height: 280px; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .gallery-campus-feature img, .gallery-campus-card img { height: 260px; }
            .floating-actions { right: 10px; transform: translateY(-50%) scale(.9); transform-origin: right center; }
        }

        /* =====================================================
        LUXURY CAMPUS PRIDE ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        .campus-reveal,
        .campus-section > p,
        .campus-section > h1,
        .campus-section > h2,
        .campus-section > h3,
        .campus-label,
        .campus-title,
        .campus-gradient,
        .campus-nav,
        .campus-hero,
        .campus-id-card,
        .id-top,
        .id-chip,
        .id-number,
        .graduate-id-body,
        .id-photo-frame,
        .id-photo-placeholder,
        .id-details,
        .campus-hero-main,
        .campus-kicker,
        .hero-campus-title,
        .hero-campus-desc,
        .campus-actions,
        .campus-stamp-row,
        .campus-stamp,
        .campus-info-band,
        .campus-info-card,
        .graduate-campus-card,
        .graduate-photo,
        .graduate-placeholder,
        .graduate-role,
        .pride-panel,
        .big-number,
        .campus-achievement-card,
        .achievement-number,
        .campus-card,
        .detail-row,
        .countdown-card,
        .map-card,
        .gallery-campus-feature,
        .gallery-campus-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .campus-btn {
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

        .campus-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar muncul halus */
        .campus-nav {
            animation: campusNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil mewah */
        #opening .campus-id-card {
            animation:
                campusIdCardEnter 1.08s cubic-bezier(.2, .8, .2, 1) .12s both,
                campusIdCardFloat 5.6s ease-in-out 1.5s infinite;
        }

        #opening .id-chip {
            animation: campusFadeDown .85s ease .24s both;
        }

        #opening .id-number {
            animation:
                campusNumberPop .9s cubic-bezier(.2, .8, .2, 1) .32s both,
                campusSoftPulse 3s ease-in-out 1.4s infinite;
        }

        #opening .id-photo-frame {
            animation: campusFadeUp .9s ease .42s both;
        }

        #opening .id-details {
            animation: campusFadeUp .9s ease .54s both;
        }

        #opening .campus-kicker {
            animation: campusFadeDown .85s ease .18s both;
        }

        #opening .hero-campus-title {
            animation: campusTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .34s both;
        }

        #opening .hero-campus-desc {
            animation: campusFadeUp .85s ease .50s both;
        }

        #opening .campus-actions {
            animation: campusFadeUp .85s ease .62s both;
        }

        #opening .campus-stamp {
            animation: campusFadeUp .85s ease .72s both;
        }

        #opening .campus-info-card {
            animation: campusFadeUp .9s ease .84s both;
        }

        /* Background lembut tapi hidup */
        .campus-wrap {
            animation: campusWrapGlow 8s ease-in-out infinite alternate;
        }

        .campus-wrap::before {
            animation: campusGridMove 20s linear infinite;
        }

        .campus-wrap::after,
        .campus-id-card::before,
        .campus-id-card::after,
        .campus-hero-main::before,
        .campus-info-card::after,
        .graduate-campus-card::after,
        .pride-panel::after,
        .campus-achievement-card::after,
        .gift-card::after {
            animation: campusDecorFloat 6.4s ease-in-out infinite;
        }

        /* Label/kicker glow */
        .campus-label::before,
        .campus-kicker::before,
        .id-chip::before {
            animation: campusLabelGlow 2.8s ease-in-out infinite alternate;
        }

        /* Stamp icon bergerak */
        .campus-stamp span {
            animation: campusStampSpin 3.8s ease-in-out infinite;
        }

        /* Tombol efek kilau */
        .campus-btn,
        button.campus-btn,
        .copy-gift-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .campus-btn::after,
        button.campus-btn::after,
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
            animation: campusButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .campus-id-card:hover,
            .id-photo-frame:hover,
            .id-details:hover,
            .campus-info-card:hover,
            .campus-stamp:hover,
            .graduate-campus-card:hover,
            .pride-panel:hover,
            .campus-achievement-card:hover,
            .campus-card:hover,
            .detail-row:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-campus-feature:hover,
            .gallery-campus-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--campus-primary) 32%, transparent) !important;
                box-shadow:
                    0 34px 88px color-mix(in srgb, var(--campus-primary) 12%, transparent),
                    0 0 46px color-mix(in srgb, var(--campus-accent) 32%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .id-photo-frame:hover img,
            .gallery-campus-feature:hover img,
            .gallery-campus-card:hover img,
            .graduate-campus-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }

            .campus-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--campus-primary) 12%, transparent);
            }
        }

        .id-photo-frame img,
        .gallery-campus-feature img,
        .gallery-campus-card img,
        .graduate-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Countdown glow */
        .countdown-number {
            animation: campusNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Icon/angka pulse */
        .id-number,
        .graduate-placeholder,
        .achievement-number,
        .big-number,
        .gift-number,
        .message-badge {
            animation: campusSoftPulse 3s ease-in-out infinite;
        }

        /* Gallery bergerak halus */
        .gallery-campus-feature {
            animation: campusGalleryFeature 5s ease-in-out infinite;
        }

        .gallery-campus-card:nth-child(3n+1) {
            animation: campusGalleryOne 4.8s ease-in-out infinite;
        }

        .gallery-campus-card:nth-child(3n+2) {
            animation: campusGalleryTwo 4.8s ease-in-out .18s infinite;
        }

        .gallery-campus-card:nth-child(3n+3) {
            animation: campusGalleryThree 4.8s ease-in-out .36s infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: campusFloatingButton 3.4s ease-in-out infinite;
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
        @keyframes campusNavEnter {
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

        @keyframes campusIdCardEnter {
            from {
                opacity: 0;
                transform: translateX(-30px) translateY(36px) scale(.94) rotate(-2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes campusIdCardFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.01);
            }
        }

        @keyframes campusFadeDown {
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

        @keyframes campusFadeUp {
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

        @keyframes campusTitleIn {
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

        @keyframes campusNumberPop {
            from {
                opacity: 0;
                transform: translateY(-16px) scale(.76) rotate(-7deg);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes campusWrapGlow {
            from {
                box-shadow:
                    0 34px 90px color-mix(in srgb, var(--campus-primary) 6%, transparent),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 42px 118px color-mix(in srgb, var(--campus-primary) 10%, transparent),
                    0 0 58px color-mix(in srgb, var(--campus-accent) 36%, transparent);
            }
        }

        @keyframes campusGridMove {
            from {
                background-position: 0 0, 0 0;
            }
            to {
                background-position: 160px 160px, 160px 160px;
            }
        }

        @keyframes campusDecorFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.04);
            }
        }

        @keyframes campusLabelGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--campus-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--campus-primary) 22%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes campusStampSpin {
            0%, 100% {
                transform: rotate(12deg) scale(1);
            }
            50% {
                transform: rotate(24deg) scale(1.12);
            }
        }

        @keyframes campusButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes campusNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--campus-primary) 14%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--campus-primary) 34%, transparent),
                    0 0 34px color-mix(in srgb, var(--campus-accent) 42%, transparent);
            }
        }

        @keyframes campusSoftPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.035);
            }
        }

        @keyframes campusGalleryFeature {
            0%, 100% {
                transform: translateY(0) rotate(-.25deg);
            }
            50% {
                transform: translateY(-7px) rotate(.25deg);
            }
        }

        @keyframes campusGalleryOne {
            0%, 100% {
                transform: translateY(0) rotate(-.4deg);
            }
            50% {
                transform: translateY(-7px) rotate(-.9deg);
            }
        }

        @keyframes campusGalleryTwo {
            0%, 100% {
                transform: translateY(0) rotate(.4deg);
            }
            50% {
                transform: translateY(-6px) rotate(.8deg);
            }
        }

        @keyframes campusGalleryThree {
            0%, 100% {
                transform: translateY(0) rotate(.2deg);
            }
            50% {
                transform: translateY(-7px) rotate(.7deg);
            }
        }

        @keyframes campusFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .campus-reveal,
            .campus-section > p,
            .campus-section > h1,
            .campus-section > h2,
            .campus-section > h3,
            .campus-label,
            .campus-title,
            .campus-gradient,
            .campus-nav,
            .campus-hero,
            .campus-id-card,
            .id-top,
            .id-chip,
            .id-number,
            .graduate-id-body,
            .id-photo-frame,
            .id-photo-placeholder,
            .id-details,
            .campus-hero-main,
            .campus-kicker,
            .hero-campus-title,
            .hero-campus-desc,
            .campus-actions,
            .campus-stamp-row,
            .campus-stamp,
            .campus-info-band,
            .campus-info-card,
            .graduate-campus-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .pride-panel,
            .big-number,
            .campus-achievement-card,
            .achievement-number,
            .campus-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-campus-feature,
            .gallery-campus-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .campus-btn {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-campus-feature,
            .gallery-campus-card:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .campus-id-card {
                animation:
                    campusFadeUp .9s ease .3s both,
                    campusFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .campus-reveal,
            .campus-section > p,
            .campus-section > h1,
            .campus-section > h2,
            .campus-section > h3,
            .campus-label,
            .campus-title,
            .campus-gradient,
            .campus-nav,
            .campus-hero,
            .campus-id-card,
            .id-top,
            .id-chip,
            .id-number,
            .graduate-id-body,
            .id-photo-frame,
            .id-photo-placeholder,
            .id-details,
            .campus-hero-main,
            .campus-kicker,
            .hero-campus-title,
            .hero-campus-desc,
            .campus-actions,
            .campus-stamp-row,
            .campus-stamp,
            .campus-info-band,
            .campus-info-card,
            .graduate-campus-card,
            .graduate-photo,
            .graduate-placeholder,
            .graduate-role,
            .pride-panel,
            .big-number,
            .campus-achievement-card,
            .achievement-number,
            .campus-card,
            .detail-row,
            .countdown-card,
            .map-card,
            .gallery-campus-feature,
            .gallery-campus-card,
            .gift-card,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .campus-btn,
            .campus-wrap,
            .campus-wrap::before,
            .campus-wrap::after,
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

        /* =====================================================
        FIX ANCHOR NAVBAR TERPOTONG SAAT KLIK MENU
        Untuk template Campus Pride Graduation
        ===================================================== */

        /* Jarak scroll saat klik href="#..." */
        html {
            scroll-padding-top: 110px;
        }

        /* Semua section target navbar diberi jarak dari atas */
        #opening,
        #graduate,
        #detail,
        #gallery,
        #gift,
        #message {
            scroll-margin-top: 110px;
        }

        /* Tablet */
        @media (max-width: 1080px) {
            html {
                scroll-padding-top: 105px;
            }

            #opening,
            #graduate,
            #detail,
            #gallery,
            #gift,
            #message {
                scroll-margin-top: 105px;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            html {
                scroll-padding-top: 96px;
            }

            #opening,
            #graduate,
            #detail,
            #gallery,
            #gift,
            #message {
                scroll-margin-top: 96px;
            }
        }

        /* =====================================================
        FIX SECTION SAAT NAVBAR DIKLIK
        ===================================================== */

        .campus-nav {
            scroll-margin-top: 0 !important;
        }

        /* Beri ruang bagian atas section supaya judul tidak mepet navbar */
        #graduate,
        #detail,
        #gallery,
        #gift,
        #message {
            padding-top: 120px !important;
        }

        /* Karena padding atas ditambah, bawah dikurangi agar tinggi section tetap enak */
        #graduate.campus-section.compact,
        #detail.campus-section.compact,
        #gallery.campus-section.compact,
        #gift.campus-section.compact,
        #message.campus-section.compact {
            padding-bottom: 72px !important;
        }

        @media (max-width: 1080px) {
            #graduate,
            #detail,
            #gallery,
            #gift,
            #message {
                padding-top: 130px !important;
            }
        }

        @media (max-width: 640px) {
            #graduate,
            #detail,
            #gallery,
            #gift,
            #message {
                padding-top: 140px !important;
            }

            .campus-nav {
                top: 10px !important;
                max-width: calc(100% - 30px);
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'emerald';

    $themes = [
        'maroon' => [
            'primary' => '#9b1c31',
            'secondary' => '#d6455d',
            'accent' => '#ffe4e6',
            'dark' => '#351018',
            'text' => '#694651',
            'soft' => '#fffafa',
            'glow1' => 'rgba(155, 28, 49, .055)',
            'glow2' => 'rgba(255, 228, 230, .55)',
        ],

        'emerald' => [
            'primary' => '#0f766e',
            'secondary' => '#14b8a6',
            'accent' => '#ccfbf1',
            'dark' => '#0f2f2b',
            'text' => '#526b68',
            'soft' => '#f8fffd',
            'glow1' => 'rgba(20, 184, 166, .075)',
            'glow2' => 'rgba(204, 251, 241, .70)',
        ],

        'navy' => [
            'primary' => '#334155',
            'secondary' => '#64748b',
            'accent' => '#e2e8f0',
            'dark' => '#0f172a',
            'text' => '#526074',
            'soft' => '#fbfdff',
            'glow1' => 'rgba(51, 65, 85, .055)',
            'glow2' => 'rgba(226, 232, 240, .60)',
        ],

        'rose' => [
            'primary' => '#be376d',
            'secondary' => '#e879a8',
            'accent' => '#fdebf4',
            'dark' => '#45172a',
            'text' => '#72576a',
            'soft' => '#fffafd',
            'glow1' => 'rgba(190, 55, 109, .055)',
            'glow2' => 'rgba(253, 235, 244, .62)',
        ],

        'gold' => [
            'primary' => '#a16207',
            'secondary' => '#ca8a04',
            'accent' => '#fef3c7',
            'dark' => '#3f2a08',
            'text' => '#6d6048',
            'soft' => '#fffdf6',
            'glow1' => 'rgba(161, 98, 7, .055)',
            'glow2' => 'rgba(254, 243, 199, .65)',
        ],

        'slate' => [
            'primary' => '#475569',
            'secondary' => '#94a3b8',
            'accent' => '#f1f5f9',
            'dark' => '#1e293b',
            'text' => '#64748b',
            'soft' => '#ffffff',
            'glow1' => 'rgba(71, 85, 105, .045)',
            'glow2' => 'rgba(241, 245, 249, .72)',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];
    $firstPhoto = $invitation->photos->first();
    $photos = $invitation->photos->values();
    $giftCount = $invitation->gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Campus Pride Graduation';
    $eventName = $invitation->event_name ?: 'Wisuda Kampus';
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
        "Dengan penuh rasa bangga dan syukur, kami mengundang Anda untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) { $shareMessage .= "Diselenggarakan oleh: {$hostName}\n"; }
    $shareMessage .= "Tanggal: {$eventDateText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n" . $shareUrl . "\n\nMerupakan kebanggaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\nTerima kasih.";
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

            $calendarTitle = trim(($invitation->event_name ?: 'Campus Pride Graduation') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan wisuda kampus') . "\n\nLink Undangan: " . $shareUrl);
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

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Tempat';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Graduation' : 'Lokasi Wisuda');

    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang wisuda online atau webinar.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $campusHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $campusHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --campus-primary: {{ $activeTheme['primary'] }};
        --campus-secondary: {{ $activeTheme['secondary'] }};
        --campus-accent: {{ $activeTheme['accent'] }};
        --campus-dark: {{ $activeTheme['dark'] }};
        --campus-text: {{ $activeTheme['text'] }};
        --campus-soft: {{ $activeTheme['soft'] }};
        --campus-glow-1: {{ $activeTheme['glow1'] }};
        --campus-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="campus-shell">
        <div class="campus-wrap">
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

            <nav class="campus-nav">
                <a href="#graduate">Wisudawan</a>
                <a href="#detail">Detail</a>
                @if ($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if ($giftCount) <a href="#gift">Hadiah</a> @endif
                <a href="#message">Ucapan</a>
            </nav>

            {{-- HERO --}}
            <section id="opening" class="campus-hero">
                <div class="campus-id-card">
                    <div class="id-top">
                        <div class="id-chip">Campus Pride</div>
                        <div class="id-number">
                            @if ($invitation->event_date)
                                {{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}
                            @else
                                --
                            @endif
                        </div>
                    </div>

                    <div class="graduate-id-body">
                        <div class="id-photo-frame">
                            @if ($firstGraduate?->photo)
                                <img src="{{ asset('storage/' . $firstGraduate->photo) }}" alt="{{ $firstGraduate->name }}">
                            @elseif ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Wisuda">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Wisuda">
                            @else
                                <div class="id-photo-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($graduateHeroName ?: 'W', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="id-details">
                            <small>Yang Berbahagia</small>
                            <strong class="responsive-text">{{ $graduateHeroName }}</strong>
                            @if ($graduateHeroSubtitle)
                                <span class="responsive-text">{{ $graduateHeroSubtitle }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="campus-hero-main">
                    <div class="campus-kicker">{{ $eventName }}</div>

                    <h1 class="responsive-text campus-title campus-gradient hero-campus-title">
                        {{ $eventTitle }}
                    </h1>

                    <p class="responsive-text hero-campus-desc">
                        {{ $invitation->description ?: 'Dengan penuh rasa bangga dan syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang modern, hangat, dan penuh kebanggaan kampus.' }}
                    </p>

                    <div class="campus-actions">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="campus-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="campus-btn">Lihat Detail</a>
                        @endif

                        <a href="#detail" class="campus-btn secondary">Detail Acara</a>
                        <a href="#message" class="campus-btn secondary">Kirim Ucapan</a>
                    </div>

                    <div class="campus-stamp-row">
                        <div class="campus-stamp"><span></span> Proud Graduate</div>
                        <div class="campus-stamp"><span></span> Campus Moment</div>
                        <div class="campus-stamp"><span></span> Future Ready</div>
                    </div>

                    <div class="campus-info-band">
                        <div class="campus-info-card">
                            <small>Tanggal</small>
                            <strong class="campus-date-line">
                                @if ($invitation->event_date)
                                    <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span>Belum diatur</span>
                                @endif
                            </strong>
                        </div>

                        <div class="campus-info-card">
                            <small>Waktu</small>
                            <strong class="campus-time-line">
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

                        <div class="campus-info-card">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">{{ $accessName }}</strong>
                        </div>
                    </div>
                </div>
            </section>

            {{-- GRADUATE --}}
            <section id="graduate" class="campus-section compact text-center">
                <p class="campus-label justify-center">The Graduate</p>
                <h2 class="responsive-text campus-title text-5xl md:text-6xl mt-6">Wisudawan / Wisudawati</h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--campus-text); line-height: 1.85;">
                    Bagian ini menampilkan tokoh utama acara, lulusan, atau wisudawan yang sedang merayakan momen kelulusan.
                </p>

                <div class="graduate-campus-grid {{ $invitation->people->count() <= 1 ? 'single-graduate' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="graduate-campus-card">
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
                        <div class="graduate-campus-card">
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
                <section id="achievement" class="campus-section compact">
                    <div class="section-head">
                        <p class="campus-label justify-center">Campus Pride</p>
                        <h2 class="responsive-text campus-title text-5xl md:text-6xl mt-6">
                            {{ $invitation->seminar_about_title ?: 'Prestasi, Perjalanan, dan Masa Depan' }}
                        </h2>
                        <p class="responsive-text desc">
                            {{ $hostName
                                ? 'Acara ini diselenggarakan oleh ' . $hostName . ' sebagai momen kebanggaan untuk merayakan pencapaian dan langkah baru.'
                                : 'Momen wisuda adalah perayaan atas doa, perjuangan, pencapaian, dan awal perjalanan baru yang penuh harapan.'
                            }}
                        </p>
                    </div>

                    <div class="pride-layout">
                        <div class="pride-panel">
                            <div class="big-number">{{ str_pad(max($highlightCount, 1), 2, '0', STR_PAD_LEFT) }}</div>
                            <h3>Stories of Achievement</h3>
                            <p>Setiap poin menjadi cerita kecil tentang perjalanan, kebanggaan, dan masa depan yang siap disambut.</p>
                        </div>

                        @if ($highlightCount)
                            <div class="achievement-campus {{ $highlightGridClass }}">
                                @foreach ($campusHighlights as $index => $highlight)
                                    <div class="campus-achievement-card">
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
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="campus-section compact">
                <div class="section-head">
                    <p class="campus-label justify-center">Schedule & Venue</p>
                    <h2 class="campus-title text-5xl md:text-6xl mt-6">Detail Acara Wisuda</h2>
                    <p class="responsive-text desc">Simpan jadwal dan pastikan hadir pada momen kebanggaan kampus ini.</p>
                </div>

                <div class="detail-layout">
                    <div class="campus-card">
                        <h3>Informasi Acara</h3>
                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label ml-2">Acara</div>
                                <div class="value responsive-text ml-2">{{ $eventName }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label ml-2">Tanggal</div>
                                <div class="value campus-date-line ml-2">
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
                                <div class="value campus-time-line ml-2">
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
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="campus-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="campus-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="campus-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black" style="color: var(--campus-text);" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Countdown Graduation</h3>
                            <p class="responsive-text mt-3 leading-7" style="color: var(--campus-text);">
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
                                                <p class="responsive-text mt-2" style="color: var(--campus-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--campus-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--campus-text);">Link online belum ditambahkan.</p>
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
                                                <p class="responsive-text mt-2" style="color: var(--campus-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--campus-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--campus-text);">{{ $accessDescription }}</p>
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
                <section id="gallery" class="campus-section compact text-center">
                    <p class="campus-label justify-center">Campus Memories</p>
                    <h2 class="campus-title text-5xl md:text-6xl mt-6">Galeri Wisuda</h2>
                    <p class="responsive-text desc max-w-2xl mx-auto mt-4" style="color: var(--campus-text); line-height: 1.85;">
                        Kenangan istimewa dari momen kelulusan yang penuh rasa syukur dan kebanggaan.
                    </p>

                    <div class="gallery-campus">
                        @if ($photos->first())
                            <div class="gallery-campus-feature">
                                <img src="{{ asset('storage/' . $photos->first()->image_path) }}" alt="Galeri Wisuda">
                            </div>
                        @endif

                        <div class="gallery-campus-side">
                            @foreach ($photos->slice(1) as $photo)
                                <div class="gallery-campus-card">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Wisuda">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="campus-section compact">
                    <div class="section-head">
                        <p class="campus-label justify-center">Gift & Appreciation</p>
                        <h2 class="campus-title text-5xl md:text-6xl mt-6">Kirim Hadiah</h2>
                        <p class="responsive-text desc">Jika berkenan, tamu dapat mengirimkan hadiah digital melalui informasi berikut.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Hadiah Digital';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>
                                        <div class="gift-number responsive-text">{{ $giftNumber }}</div>
                                        <p class="responsive-text text-sm mt-2" style="color: var(--campus-text);">Atas Nama {{ $giftName }}</p>
                                    </div>

                                    @if ($giftNumber !== '-')
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $giftNumber }}">Salin</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="campus-section compact">
                <div class="text-center">
                    <p class="campus-label justify-center">RSVP & Wishes</p>
                    <h2 class="campus-title text-5xl md:text-6xl mt-6">Ucapan & Kehadiran</h2>
                    <p class="responsive-text mt-4 max-w-2xl mx-auto" style="color: var(--campus-text); line-height: 1.85;">
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

                        <button type="submit" class="w-full campus-btn">Kirim Ucapan</button>
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
                                        <p class="responsive-text font-black" style="color: var(--campus-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--campus-text);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--campus-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p style="color: var(--campus-text);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="campus-section text-center">
                <div class="closing-card">
                    <p class="campus-label justify-center">Thank You</p>
                    <h2 class="responsive-text campus-title campus-gradient text-5xl md:text-7xl mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--campus-text);">
                        Terima kasih atas doa, kehadiran, dan dukungan yang diberikan. Semoga momen kelulusan ini menjadi awal perjalanan baru yang penuh keberkahan dan kebanggaan.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--campus-dark);">{{ $eventTitle }}</h3>
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
                    try {
                        await navigator.clipboard.writeText(text);
                        const originalText = this.textContent;
                        this.textContent = 'Tersalin';
                        this.classList.add('copied');
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        alert('Nomor belum bisa disalin otomatis. Silakan salin manual: ' + text);
                    }
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .campus-section > p,
                .campus-section > h1,
                .campus-section > h2,
                .campus-section > h3,
                .campus-label,
                .campus-title,
                .campus-gradient,
                .campus-nav,
                .campus-hero,
                .campus-id-card,
                .id-top,
                .id-chip,
                .id-number,
                .graduate-id-body,
                .id-photo-frame,
                .id-photo-placeholder,
                .id-details,
                .campus-hero-main,
                .campus-kicker,
                .hero-campus-title,
                .hero-campus-desc,
                .campus-actions,
                .campus-stamp-row,
                .campus-stamp,
                .campus-info-band,
                .campus-info-card,
                .graduate-campus-card,
                .graduate-photo,
                .graduate-placeholder,
                .graduate-role,
                .pride-panel,
                .big-number,
                .campus-achievement-card,
                .achievement-number,
                .campus-card,
                .detail-row,
                .countdown-card,
                .map-card,
                .gallery-campus-feature,
                .gallery-campus-card,
                .gift-card,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card,
                .campus-btn
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('campus-show');
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

            /*
            |--------------------------------------------------------------------------
            | FIX NAVBAR ANCHOR TERPOTONG
            | Scroll manual dengan offset tinggi navbar
            |--------------------------------------------------------------------------
            */
            const campusNavLinks = document.querySelectorAll('.campus-nav a[href^="#"]');

            campusNavLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    const targetId = link.getAttribute('href');

                    if (!targetId || targetId === '#') {
                        return;
                    }

                    const targetElement = document.querySelector(targetId);
                    const navElement = document.querySelector('.campus-nav');

                    if (!targetElement || !navElement) {
                        return;
                    }

                    event.preventDefault();

                    const navHeight = navElement.offsetHeight || 0;

                    let extraOffset = 42;

                    if (window.innerWidth <= 640) {
                        extraOffset = 76;
                    } else if (window.innerWidth <= 1080) {
                        extraOffset = 58;
                    }

                    const targetPosition =
                        targetElement.getBoundingClientRect().top +
                        window.pageYOffset -
                        navHeight -
                        extraOffset;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>
