<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Company Gathering') . ' ' . ($invitation->title ?: 'Corporate Gathering'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--corp-dark);
            background:
                radial-gradient(circle at 10% 4%, var(--corp-glow-1), transparent 34%),
                radial-gradient(circle at 88% 0%, var(--corp-glow-2), transparent 34%),
                linear-gradient(180deg, #ffffff 0%, var(--corp-soft) 100%);
        }

        .corp-shell {
            width: min(100%, 1280px);
            margin: 0 auto;
            padding: 24px;
        }

        .corp-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 46px;
            background:
                radial-gradient(circle at 10% 12%, color-mix(in srgb, var(--corp-primary) 8%, transparent), transparent 30%),
                radial-gradient(circle at 90% 10%, color-mix(in srgb, var(--corp-secondary) 11%, transparent), transparent 32%),
                linear-gradient(180deg, rgba(255,255,255,.98), color-mix(in srgb, var(--corp-soft) 72%, white));
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 38px 110px rgba(15, 23, 42, .10);
            isolation: isolate;
        }

        .corp-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .08;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--corp-primary) 12%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--corp-primary) 12%, transparent) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: corpGridMove 24s linear infinite;
            z-index: 0;
        }

        .corp-wrap::after {
            content: "";
            position: absolute;
            width: 720px;
            height: 720px;
            right: -360px;
            top: -280px;
            border-radius: 999px;
            background: radial-gradient(circle, color-mix(in srgb, var(--corp-secondary) 12%, transparent), transparent 70%);
            pointer-events: none;
            z-index: 0;
            animation: corpDecorFloat 7s ease-in-out infinite;
        }

        .corp-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .corp-nav {
            position: sticky;
            top: 18px;
            z-index: 70;
            width: fit-content;
            max-width: calc(100% - 26px);
            margin: 18px auto -34px;
            padding: 7px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(255,255,255,.82), color-mix(in srgb, var(--corp-accent) 35%, white));
            border: 1px solid color-mix(in srgb, var(--corp-primary) 14%, transparent);
            box-shadow:
                0 18px 42px color-mix(in srgb, var(--corp-primary) 10%, transparent),
                inset 0 1px 0 rgba(255,255,255,.86);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            scrollbar-width: none;
        }

        .corp-nav::-webkit-scrollbar { display: none; }

        .corp-nav a {
            padding: 10px 15px;
            border-radius: 999px;
            text-decoration: none;
            white-space: nowrap;
            color: var(--corp-text);
            font-size: 12px;
            font-weight: 950;
            transition: .26s ease;
        }

        .corp-nav a:hover {
            color: var(--corp-primary);
            transform: translateY(-1px);
            background: rgba(255,255,255,.90);
            box-shadow: 0 10px 24px color-mix(in srgb, var(--corp-primary) 12%, transparent);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 90;
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
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(15,23,42,.14);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            animation: corpFloatButton 3.6s ease-in-out infinite;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--corp-accent) 48%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .corp-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary));
            box-shadow: 0 18px 42px color-mix(in srgb, var(--corp-primary) 24%, transparent);
            transition: .28s ease;
        }

        .corp-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -80%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: corpButtonShine 3.4s ease-in-out infinite;
            pointer-events: none;
        }

        .corp-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 26px 58px color-mix(in srgb, var(--corp-primary) 30%, transparent);
        }

        .corp-btn.secondary {
            color: var(--corp-dark);
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 13%, transparent);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
        }

        .corp-section {
            min-height: 100vh;
            padding: 92px 66px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .corp-section.compact {
            min-height: auto;
            padding-top: 78px;
            padding-bottom: 78px;
        }

        .corp-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--corp-primary);
            font-size: 12px;
            letter-spacing: .22em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .corp-label::before,
        .corp-label::after {
            content: "";
            width: 42px;
            height: 1px;
            background: color-mix(in srgb, var(--corp-primary) 36%, transparent);
        }

        .corp-title {
            color: var(--corp-dark);
            font-weight: 950;
            letter-spacing: -.065em;
            line-height: .95;
        }

        .corp-gradient {
            background: linear-gradient(135deg, var(--corp-dark), var(--corp-primary), var(--corp-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .section-head { text-align: center; }
        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--corp-text);
            line-height: 1.85;
        }

        /* =========================================================
           COMPANY GATHERING HERO - LOUNGE BOARD
           Berbeda dari launch/opening/product: konsep networking lounge.
        ========================================================= */
        .gathering-hero {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            padding: 126px 58px 72px;
            isolation: isolate;
        }

        .gathering-hero::before {
            content: "";
            position: absolute;
            inset: 74px 24px 36px;
            border-radius: 46px;
            z-index: -1;
            background:
                radial-gradient(circle at 18% 22%, color-mix(in srgb, var(--corp-primary) 12%, transparent), transparent 32%),
                radial-gradient(circle at 86% 15%, color-mix(in srgb, var(--corp-secondary) 14%, transparent), transparent 34%),
                linear-gradient(135deg, rgba(255,255,255,.94), color-mix(in srgb, var(--corp-accent) 30%, white));
            border: 1px solid rgba(255,255,255,.76);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.92), 0 28px 80px rgba(15,23,42,.07);
        }

        .gathering-bg { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
        .g-orb,
        .g-line,
        .g-dot,
        .g-spark { position: absolute; }

        .g-orb {
            border-radius: 999px;
            opacity: .58;
            filter: blur(1px);
            animation: corpDecorFloat 7s ease-in-out infinite;
        }
        .g-orb-a { width: 300px; height: 300px; right: -70px; top: 115px; background: color-mix(in srgb, var(--corp-secondary) 15%, transparent); }
        .g-orb-b { width: 210px; height: 210px; left: -34px; bottom: 105px; background: color-mix(in srgb, var(--corp-primary) 12%, transparent); animation-delay: -1.7s; }
        .g-orb-c { width: 98px; height: 98px; left: 48%; top: 16%; background: color-mix(in srgb, var(--corp-accent) 62%, transparent); animation-delay: -2.8s; }
        .g-line { height: 1px; background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--corp-primary) 24%, transparent), transparent); }
        .g-line-a { width: 310px; left: 12%; top: 170px; }
        .g-line-b { width: 250px; right: 10%; bottom: 150px; }
        .g-dot { width: 10px; height: 10px; border-radius: 999px; background: var(--corp-primary); opacity: .24; animation: corpSoftPulse 3.2s ease-in-out infinite; }
        .g-dot-a { left: 10%; top: 34%; }
        .g-dot-b { right: 16%; top: 28%; animation-delay: -.8s; }
        .g-dot-c { right: 38%; bottom: 16%; animation-delay: -1.5s; }
        .g-spark { color: var(--corp-primary); opacity: .46; font-size: 21px; animation: corpSoftPulse 3.4s ease-in-out infinite; }
        .g-spark-a { left: 8%; top: 22%; }
        .g-spark-b { right: 10%; top: 40%; color: var(--corp-secondary); animation-delay: -1s; }

        .gathering-layout {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, .90fr) minmax(340px, .72fr) minmax(0, .90fr);
            gap: 26px;
            align-items: center;
        }

        .g-info-column,
        .g-visual-column,
        .g-copy-column { min-width: 0; }

        .g-info-column {
            display: grid;
            gap: 14px;
        }

        .g-info-card {
            position: relative;
            overflow: hidden;
            min-height: 122px;
            padding: 20px;
            border-radius: 30px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 18px 46px rgba(15,23,42,.07);
            transition: .35s ease;
        }

        .g-info-card.feature {
            color: #fff;
            background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary));
            border-color: transparent;
            box-shadow: 0 24px 52px color-mix(in srgb, var(--corp-primary) 22%, transparent);
        }

        .g-info-card::after {
            content: "";
            position: absolute;
            width: 92px;
            height: 92px;
            right: -34px;
            bottom: -34px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--corp-accent) 46%, transparent);
        }

        .g-info-card small,
        .g-info-card strong,
        .g-info-card span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .g-info-card small {
            color: var(--corp-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .g-info-card.feature small,
        .g-info-card.feature strong,
        .g-info-card.feature span { color: #fff; }

        .g-info-card strong {
            margin-top: 10px;
            color: var(--corp-dark);
            line-height: 1.35;
            font-weight: 950;
            font-size: 1.08rem;
        }

        .g-info-card span {
            margin-top: 6px;
            color: var(--corp-text);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 800;
        }

        .g-visual-column {
            position: relative;
            min-height: 660px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .g-cover-frame {
            position: relative;
            width: min(100%, 420px);
            height: 640px;
            border-radius: 58px;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 12%, color-mix(in srgb, var(--corp-accent) 62%, white), transparent 42%),
                linear-gradient(180deg, #fff, color-mix(in srgb, var(--corp-soft) 70%, white));
            border: 1px solid color-mix(in srgb, var(--corp-primary) 13%, transparent);
            box-shadow:
                0 38px 100px color-mix(in srgb, var(--corp-primary) 14%, transparent),
                inset 0 1px 0 rgba(255,255,255,.96);
            transition: .35s ease;
        }

        .g-cover-frame::before {
            content: "";
            position: absolute;
            inset: 20px;
            border-radius: 42px;
            border: 1px dashed color-mix(in srgb, var(--corp-primary) 23%, transparent);
            pointer-events: none;
            z-index: 5;
        }

        .g-cover-top {
            position: absolute;
            top: 24px;
            left: 30px;
            right: 30px;
            z-index: 6;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .g-cover-top span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--corp-primary) 28%, white);
        }
        .g-cover-top span:nth-child(2) { background: color-mix(in srgb, var(--corp-secondary) 35%, white); }
        .g-cover-top span:nth-child(3) { background: color-mix(in srgb, var(--corp-accent) 70%, white); }
        .g-cover-top b {
            margin-left: auto;
            color: var(--corp-primary);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .g-cover-screen {
            position: absolute;
            inset: 68px 28px 126px;
            overflow: hidden;
            border-radius: 38px;
            background: linear-gradient(135deg, #fff, color-mix(in srgb, var(--corp-accent) 38%, white));
            border: 1px solid color-mix(in srgb, var(--corp-primary) 10%, transparent);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.86);
        }

        .g-cover-img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .g-default-cover {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background:
                radial-gradient(circle at 50% 22%, rgba(255,255,255,.82), transparent 32%),
                linear-gradient(135deg, color-mix(in srgb, var(--corp-primary) 8%, white), color-mix(in srgb, var(--corp-accent) 52%, white));
        }

        .g-default-cover img {
            width: min(94%, 360px);
            height: auto;
            max-height: 360px;
            object-fit: contain;
            filter: drop-shadow(0 24px 52px color-mix(in srgb, var(--corp-primary) 20%, transparent)) saturate(1.08);
            animation: corpSoftPulse 4.2s ease-in-out infinite;
        }

        .g-cover-frame.has-photo .g-cover-screen::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 48%, rgba(15,23,42,.30));
            pointer-events: none;
        }

        .g-cover-caption {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 28px;
            z-index: 7;
            padding: 20px;
            border-radius: 26px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(15,23,42,.08);
            backdrop-filter: blur(14px);
        }

        .g-cover-caption small {
            display: block;
            color: var(--corp-primary);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .g-cover-caption strong {
            display: block;
            margin-top: 8px;
            color: var(--corp-dark);
            font-size: clamp(1.28rem, 2.4vw, 1.9rem);
            line-height: 1.08;
            font-weight: 950;
        }

        .g-floating-badge {
            position: absolute;
            z-index: 9;
            width: 210px;
            padding: 18px 20px;
            border-radius: 26px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 13%, transparent);
            box-shadow: 0 22px 52px rgba(15,23,42,.11);
            backdrop-filter: blur(14px);
            animation: corpMiniFloat 5s ease-in-out infinite;
        }

        .g-floating-badge.access { left: -22px; top: 82px; }
        .g-floating-badge.host { right: -24px; bottom: 106px; width: 230px; animation-delay: -1.1s; }

        .g-floating-badge small,
        .g-floating-badge strong,
        .g-floating-badge span { display: block; }
        .g-floating-badge small { color: var(--corp-text); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .g-floating-badge strong { margin-top: 8px; color: var(--corp-dark); line-height: 1.42; font-weight: 950; }
        .g-floating-badge span { margin-top: 6px; color: var(--corp-text); font-size: 13px; line-height: 1.45; font-weight: 800; }

        .g-copy-column {
            padding: 12px 0;
        }

        .g-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 14px 34px rgba(15,23,42,.06);
            color: var(--corp-primary);
            font-size: 11px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .g-kicker::before {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary));
            box-shadow: inset 0 0 0 8px rgba(255,255,255,.24);
        }

        .g-title {
            max-width: 720px;
            margin-top: 24px;
            font-size: clamp(2.8rem, 5.6vw, 5.8rem);
            line-height: .92;
            letter-spacing: -.075em;
        }

        .g-desc {
            max-width: 670px;
            margin-top: 22px;
            color: var(--corp-text);
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .g-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .g-signature {
            margin-top: 28px;
            max-width: 620px;
            display: grid;
            grid-template-columns: 58px 1fr;
            gap: 14px;
            align-items: center;
            padding: 16px;
            border-radius: 28px;
            background: rgba(255,255,255,.90);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 18px 42px rgba(15,23,42,.06);
        }

        .g-signature-icon {
            width: 58px;
            height: 58px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 950;
            background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary));
        }

        .g-signature small { display: block; color: var(--corp-text); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .g-signature strong { display: block; margin-top: 6px; color: var(--corp-dark); font-weight: 950; }

        .g-bottom-strip {
            position: relative;
            z-index: 2;
            margin-top: 30px;
            padding: 16px 22px;
            border-radius: 999px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 16px 36px rgba(15,23,42,.05);
            color: var(--corp-dark);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        /* people */
        .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 330px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .people-grid.single-person { grid-template-columns: minmax(280px, 430px); }

        .person-card,
        .corp-highlight-card,
        .corp-card,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card,
        .gallery-card,
        .closing-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 18px 46px rgba(15,23,42,.075);
        }

        .person-card {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 26px;
            text-align: left;
            transition: .35s ease;
        }

        .person-card::after,
        .corp-highlight-card::after,
        .corp-card::after,
        .gift-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--corp-accent) 35%, transparent);
            pointer-events: none;
        }

        .person-photo,
        .person-placeholder {
            position: relative;
            z-index: 2;
            width: 132px;
            height: 132px;
            border-radius: 34px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--corp-primary) 9%, white);
            border: 8px solid rgba(255,255,255,.9);
            box-shadow: 0 14px 30px rgba(15,23,42,.09);
            color: var(--corp-primary);
            font-size: 44px;
            font-weight: 950;
        }

        .person-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--corp-primary) 10%, white);
            color: var(--corp-primary);
            font-size: 12px;
            font-weight: 950;
        }

        .person-card h3,
        .person-card p { position: relative; z-index: 2; }
        .person-card h3 { margin-top: 16px; color: var(--corp-dark); font-size: 1.7rem; line-height: 1.12; font-weight: 950; }
        .person-card p { margin-top: 8px; color: var(--corp-text); line-height: 1.7; }

        /* highlights */
        .highlight-grid {
            display: grid;
            gap: 20px;
            margin-top: 42px;
            justify-content: center;
        }
        .highlight-grid.count-1 { grid-template-columns: minmax(280px, 520px); }
        .highlight-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .highlight-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .corp-highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 232px;
            padding: 30px;
            border-radius: 36px;
            transition: .35s ease;
        }

        .highlight-number {
            position: relative;
            z-index: 2;
            width: 56px;
            height: 56px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary));
            margin-bottom: 22px;
        }

        .corp-highlight-card h3,
        .corp-highlight-card p { position: relative; z-index: 2; }
        .corp-highlight-card h3 { color: var(--corp-dark); font-size: 1.42rem; font-weight: 950; }
        .corp-highlight-card p { color: var(--corp-text); margin-top: 10px; line-height: 1.8; }

        /* detail */
        .detail-layout {
            display: grid;
            grid-template-columns: .96fr 1.04fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .corp-card {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 32px;
            transition: .35s ease;
        }

        .corp-card::after { right: -50px; top: -54px; bottom: auto; }
        .corp-card h3 { position: relative; z-index: 2; margin: 0; color: var(--corp-dark); font-size: 2rem; font-weight: 950; }
        .detail-list { position: relative; z-index: 2; display: grid; gap: 14px; margin-top: 24px; }
        .detail-row {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--corp-primary) 18%, transparent);
        }
        .detail-row .label { color: var(--corp-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .detail-row .value { color: var(--corp-dark); font-weight: 900; line-height: 1.65; }

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
            background: linear-gradient(180deg, color-mix(in srgb, var(--corp-soft) 92%, white), white);
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
        }

        .countdown-number { display: block; color: var(--corp-dark); font-size: 34px; line-height: 1; font-weight: 950; animation: corpNumberGlow 2.4s ease-in-out infinite alternate; }
        .countdown-label { display: block; margin-top: 10px; color: var(--corp-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }

        .map-card {
            margin-top: 22px;
            overflow: hidden;
            border-radius: 32px;
            background: #ffffff;
            border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent);
            box-shadow: 0 16px 38px rgba(15,23,42,.08);
        }
        .map-frame,
        .map-placeholder { width: 100%; height: 310px; display: block; border: 0; }
        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            text-align: center;
            text-decoration: none;
            color: var(--corp-dark);
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--corp-soft) 92%, white));
        }

        /* gallery */
        .gallery-corporate {
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
            transition: .35s ease;
        }
        .gallery-card.tall img { height: 360px; }
        .gallery-card.short img { height: 220px; }
        .gallery-card img { width: 100%; object-fit: cover; border-radius: 22px; display: block; transition: .7s ease; }

        /* gifts */
        .gift-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 34px; }
        .gift-grid.gift-count-1 { grid-template-columns: minmax(280px, 520px); justify-content: center; }
        .gift-card { position: relative; overflow: hidden; padding: 28px; border-radius: 36px; transition: .35s ease; }
        .gift-card::after { right: -50px; top: -50px; bottom: auto; }
        .gift-card h3,
        .gift-copy-box,
        .gift-card p { position: relative; z-index: 2; }
        .gift-card h3 { color: var(--corp-dark); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: color-mix(in srgb, var(--corp-primary) 8%, white); border: 1px solid color-mix(in srgb, var(--corp-primary) 12%, transparent); }
        .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 950; color: var(--corp-text); }
        .gift-number { display: block; margin-top: 6px; color: var(--corp-primary); font-size: 1.1rem; font-weight: 950; }
        .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: white; font-size: 12px; font-weight: 950; background: linear-gradient(135deg, var(--corp-primary), var(--corp-secondary)); }
        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        /* rsvp */
        .rsvp-wrap { max-width: 900px; width: 100%; margin: 0 auto; }
        .form-card,
        .message-card,
        .summary-card { border-radius: 30px; }
        .form-card { padding: 28px; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .summary-card { padding: 20px; text-align: center; }
        .summary-card strong { display: block; color: var(--corp-dark); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: var(--corp-text); font-size: 12px; font-weight: 950; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-badge { padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--corp-primary) 10%, white); color: var(--corp-primary); font-size: 12px; font-weight: 950; white-space: nowrap; }

        .closing-card {
            max-width: 880px;
            margin: 0 auto;
            text-align: center;
            border-radius: 44px;
            padding: 52px 36px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--corp-primary) 12%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--corp-accent) 30%, transparent), transparent 36%),
                rgba(255,255,255,.92);
        }

        /* ================= SCROLL ANIMATION ================= */
        [data-reveal] {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .82s cubic-bezier(.2,.8,.2,1),
                transform .82s cubic-bezier(.2,.8,.2,1),
                filter .82s cubic-bezier(.2,.8,.2,1),
                box-shadow .35s ease,
                border-color .35s ease;
            transition-delay: var(--reveal-delay, 0s);
            will-change: opacity, transform, filter;
        }
        [data-reveal="left"] { transform: translateX(-38px) scale(.985); }
        [data-reveal="right"] { transform: translateX(38px) scale(.985); }
        [data-reveal="zoom"] { transform: translateY(22px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @media (hover: hover) {
            .g-info-card:hover,
            .g-cover-frame:hover,
            .g-floating-badge:hover,
            .g-signature:hover,
            .person-card:hover,
            .corp-highlight-card:hover,
            .corp-card:hover,
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
                border-color: color-mix(in srgb, var(--corp-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 88px color-mix(in srgb, var(--corp-primary) 14%, transparent),
                    0 0 48px color-mix(in srgb, var(--corp-accent) 20%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.86) !important;
            }

            .g-cover-frame:hover img,
            .gallery-card:hover img,
            .person-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .g-cover-frame,
        .g-info-card,
        .g-floating-badge,
        .g-signature,
        .person-card,
        .corp-highlight-card,
        .corp-card,
        .gallery-card,
        .gift-card,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card,
        .g-cover-img,
        .gallery-card img,
        .person-photo { transition: .35s ease; }

        @keyframes corpGridMove { from { background-position: 0 0, 0 0; } to { background-position: 192px 192px, 192px 192px; } }
        @keyframes corpDecorFloat { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.04); } }
        @keyframes corpMiniFloat { 0%,100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-8px) rotate(1deg); } }
        @keyframes corpFloatButton { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes corpSoftPulse { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-3px) scale(1.035); } }
        @keyframes corpButtonShine { 0%,48% { left: -80%; } 75%,100% { left: 130%; } }
        @keyframes corpNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--corp-accent) 18%, transparent); }
            to { text-shadow: 0 0 18px color-mix(in srgb, var(--corp-accent) 48%, transparent), 0 0 34px color-mix(in srgb, var(--corp-primary) 20%, transparent); }
        }

        @media (max-width: 1160px) {
            .gathering-hero { padding: 112px 40px 70px; }
            .gathering-layout {
                grid-template-columns: 1fr;
                gap: 28px;
            }
            .g-copy-column,
            .g-info-column { text-align: center; }
            .g-info-column {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                max-width: 760px;
                margin: 0 auto;
            }
            .g-kicker,
            .g-actions,
            .g-signature { justify-content: center; margin-left: auto; margin-right: auto; }
            .g-desc { margin-left: auto; margin-right: auto; }
            .g-visual-column { min-height: auto; display: grid; gap: 14px; }
            .g-cover-frame { width: min(100%, 520px); height: 620px; margin: 0 auto; }
            .g-floating-badge { position: relative; left: auto !important; right: auto !important; top: auto !important; bottom: auto !important; width: 100% !important; animation: none; }
            .highlight-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
            .detail-layout,
            .gift-grid { grid-template-columns: 1fr; }
            .gallery-corporate { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .corp-shell { padding: 0; }
            .corp-wrap { border-radius: 0; box-shadow: none; }
            .corp-nav {
                top: 10px !important;
                width: fit-content !important;
                max-width: calc(100% - 28px) !important;
                justify-content: center !important;
                align-items: center !important;
                margin: 12px auto -26px !important;
                padding: 7px 10px !important;
            }
            .corp-nav a { flex: 0 0 auto; text-align: center; padding: 10px 14px; font-size: 11px; }
            .floating-actions { right: 10px; transform: translateY(-50%) scale(.9); transform-origin: right center; }

            .gathering-hero { padding: 96px 20px 62px; }
            .gathering-hero::before { inset: 72px 10px 26px; border-radius: 32px; }
            .g-info-column { grid-template-columns: 1fr; }
            .g-title { font-size: clamp(2.45rem, 11.5vw, 4rem); line-height: .95; }
            .g-desc { font-size: 1rem; }
            .g-actions { display: grid; grid-template-columns: 1fr; }
            .g-signature { grid-template-columns: 1fr; text-align: center; }
            .g-signature-icon { margin: 0 auto; }
            .g-cover-frame { width: min(94vw, 390px); height: 560px; border-radius: 36px; }
            .g-cover-frame::before { inset: 10px; border-radius: 28px; }
            .g-cover-screen { inset: 58px 14px 112px; border-radius: 28px; }
            .g-cover-top { left: 22px; right: 22px; }
            .g-cover-top b { display: none; }
            .g-default-cover { padding: 12px; }
            .g-default-cover img { width: min(90%, 280px); max-height: 280px; }
            .g-cover-caption { left: 16px; right: 16px; bottom: 18px; padding: 14px 16px; border-radius: 20px; }
            .g-cover-caption strong { font-size: 1.18rem; }
            .g-bottom-strip { border-radius: 28px; gap: 8px; line-height: 1.6; }

            .corp-section { padding: 82px 22px; }
            .corp-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .corp-label { flex-wrap: wrap; }
            .highlight-grid,
            .highlight-grid.count-1,
            .highlight-grid.count-2,
            .highlight-grid.count-3,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .gallery-column { grid-template-columns: 1fr; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important;
            }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        /* =========================================================
        FIX HERO IMAGE - CORPORATE COMPANY GATHERING
        ========================================================= */

        #opening .g-visual-column {
            position: relative !important;
            width: 100% !important;
            min-height: 660px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex: 0 0 auto !important;
        }

        #opening .g-cover-frame {
            position: relative !important;
            width: min(100%, 430px) !important;
            max-width: 430px !important;
            height: 640px !important;
            min-height: 640px !important;
            flex: 0 0 auto !important;
            margin: 0 auto !important;
            display: block !important;
            overflow: hidden !important;
        }

        #opening .g-cover-screen {
            position: absolute !important;
            inset: 68px 28px 126px !important;
            width: auto !important;
            height: auto !important;
            overflow: hidden !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        #opening .g-cover-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
        }

        #opening .g-default-cover {
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
        }

        #opening .g-default-cover img {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
            filter: none !important;
            animation: none !important;
        }

        #opening .g-cover-caption {
            left: 22px !important;
            right: 22px !important;
            bottom: 22px !important;
        }

        /* ================= TABLET ================= */
        @media (max-width: 1160px) {
            #opening .gathering-layout {
                grid-template-columns: 1fr !important;
                gap: 28px !important;
            }

            #opening .g-info-column,
            #opening .g-copy-column {
                text-align: center !important;
            }

            #opening .g-info-column {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                max-width: 760px !important;
                margin: 0 auto !important;
            }

            #opening .g-visual-column {
                order: 2 !important;
                width: 100% !important;
                min-height: 620px !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                margin: 0 auto !important;
            }

            #opening .g-cover-frame {
                width: min(100%, 520px) !important;
                max-width: 520px !important;
                height: 620px !important;
                min-height: 620px !important;
            }

            #opening .g-cover-screen {
                inset: 62px 22px 122px !important;
            }

            #opening .g-floating-badge {
                position: relative !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                width: 100% !important;
                animation: none !important;
            }

            #opening .g-copy-column {
                order: 3 !important;
            }
        }

        /* ================= MOBILE ================= */
        @media (max-width: 640px) {
            #opening .g-visual-column {
                width: 100% !important;
                min-height: 560px !important;
            }

            #opening .g-cover-frame {
                width: min(94vw, 390px) !important;
                max-width: 390px !important;
                height: 560px !important;
                min-height: 560px !important;
                border-radius: 36px !important;
            }

            #opening .g-cover-frame::before {
                inset: 10px !important;
                border-radius: 28px !important;
            }

            #opening .g-cover-screen {
                inset: 58px 14px 112px !important;
                border-radius: 28px !important;
            }

            #opening .g-default-cover {
                padding: 0 !important;
            }

            #opening .g-default-cover img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
                object-position: center !important;
            }

            #opening .g-cover-caption {
                left: 16px !important;
                right: 16px !important;
                bottom: 18px !important;
                padding: 14px 16px !important;
                border-radius: 20px !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'navy';

    $themes = [
        'maroon' => ['primary' => '#9f1239', 'secondary' => '#e11d48', 'accent' => '#fce7f3', 'dark' => '#4a1623', 'text' => '#6b3440', 'soft' => '#fff1f2', 'glow1' => 'rgba(244, 63, 94, .16)', 'glow2' => 'rgba(236, 72, 153, .14)'],
        'emerald' => ['primary' => '#047857', 'secondary' => '#10b981', 'accent' => '#d1fae5', 'dark' => '#063d31', 'text' => '#4f6f63', 'soft' => '#f4fff9', 'glow1' => 'rgba(16, 185, 129, .15)', 'glow2' => 'rgba(52, 211, 153, .13)'],
        'navy' => ['primary' => '#1d4ed8', 'secondary' => '#38bdf8', 'accent' => '#dbeafe', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#eff6ff', 'glow1' => 'rgba(37, 99, 235, .15)', 'glow2' => 'rgba(56, 189, 248, .14)'],
        'rose' => ['primary' => '#db2777', 'secondary' => '#f472b6', 'accent' => '#fce7f3', 'dark' => '#831843', 'text' => '#70415b', 'soft' => '#fff7fb', 'glow1' => 'rgba(244, 114, 182, .16)', 'glow2' => 'rgba(251, 207, 232, .17)'],
        'gold' => ['primary' => '#b45309', 'secondary' => '#f59e0b', 'accent' => '#fef3c7', 'dark' => '#4a2c0a', 'text' => '#72512d', 'soft' => '#fffbeb', 'glow1' => 'rgba(245, 158, 11, .17)', 'glow2' => 'rgba(250, 204, 21, .16)'],
        'slate' => ['primary' => '#475569', 'secondary' => '#64748b', 'accent' => '#e2e8f0', 'dark' => '#1e293b', 'text' => '#64748b', 'soft' => '#f8fafc', 'glow1' => 'rgba(100, 116, 139, .13)', 'glow2' => 'rgba(203, 213, 225, .14)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];
    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $people = $invitation->people ?? collect();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $giftCount = $gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Company Gathering';
    $eventName = $invitation->event_name ?: 'Corporate Gathering';
    $hostName = $invitation->host_name ?: 'Corporate Team';

    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Gathering Agenda';

    $firstPerson = $people->first();
    $peopleCount = $people->count();
    $mainPersonName = $peopleCount >= 2 ? 'Team, Partner & Community' : ($firstPerson?->name ?: $hostName);
    $mainPersonSubtitle = $peopleCount >= 2 ? 'Company Gathering Circle' : ($firstPerson?->subtitle ?: 'Gathering Host');

    $eventDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y')
        : 'Tanggal belum diatur';

    $heroDateText = $eventDateText;

    if ($invitation->event_date && $invitation->event_end_date) {
        $startDate = \Carbon\Carbon::parse($invitation->event_date);
        $endDate = \Carbon\Carbon::parse($invitation->event_end_date);
        $eventDateText .= ' - ' . $endDate->translatedFormat('d M Y');

        if ($startDate->isSameDay($endDate)) {
            $heroDateText = $startDate->translatedFormat('d M Y');
        } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
            $heroDateText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d M Y');
        } elseif ($startDate->format('Y') === $endDate->format('Y')) {
            $heroDateText = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
        } else {
            $heroDateText = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
        }
    } elseif ($invitation->event_end_date) {
        $eventDateText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y');
        $heroDateText = $eventDateText;
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

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Gathering Room' : 'Gathering Venue');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang gathering atau meeting online.'
        : 'Alamat lengkap belum ditambahkan.');
    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $shareMessage = "Halo Bapak/Ibu/Saudara/i,\n\n" .
        "Dengan hormat, kami mengundang Anda untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n" .
        "Diselenggarakan oleh: {$hostName}\n" .
        "Tanggal: {$eventDateText}\n";

    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }

    if ($isOnlineEvent) {
        $shareMessage .= "Mode: Online\n";
        if ($onlineUrl) { $shareMessage .= "Link Online: {$onlineUrl}\n"; }
    } else {
        $shareMessage .= "Mode: Offline\n";
        if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
        if ($invitation->address) { $shareMessage .= "Alamat: {$invitation->address}\n"; }
    }

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n" .
        $shareUrl .
        "\n\nMerupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.\n\nTerima kasih.";

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

            $calendarTitle = trim(($invitation->event_name ?: 'Company Gathering') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan company gathering') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online'))
                : trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }

    $gatheringHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    if ($gatheringHighlights->count() === 0) {
        $gatheringHighlights = collect([
            ['title' => 'Team Bonding', 'description' => 'Momen kebersamaan untuk memperkuat hubungan, komunikasi, dan rasa memiliki dalam lingkungan perusahaan.'],
            ['title' => 'Appreciation Session', 'description' => 'Sesi apresiasi untuk tim, partner, komunitas, atau pihak yang mendukung perkembangan perusahaan.'],
            ['title' => 'Networking Moment', 'description' => 'Kesempatan membangun relasi profesional dalam suasana hangat, santai, dan tetap elegan.'],
        ]);
    }

    $highlightCount = $gatheringHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --corp-primary: {{ $activeTheme['primary'] }};
        --corp-secondary: {{ $activeTheme['secondary'] }};
        --corp-accent: {{ $activeTheme['accent'] }};
        --corp-dark: {{ $activeTheme['dark'] }};
        --corp-text: {{ $activeTheme['text'] }};
        --corp-soft: {{ $activeTheme['soft'] }};
        --corp-glow-1: {{ $activeTheme['glow1'] }};
        --corp-glow-2: {{ $activeTheme['glow2'] }};
    "
>
    <main class="corp-shell">
        <div class="corp-wrap">
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

            {{-- HERO - COMPANY GATHERING LOUNGE BOARD --}}
            <section id="opening" class="gathering-hero">
                <div class="gathering-bg" aria-hidden="true">
                    <span class="g-orb g-orb-a"></span>
                    <span class="g-orb g-orb-b"></span>
                    <span class="g-orb g-orb-c"></span>
                    <span class="g-line g-line-a"></span>
                    <span class="g-line g-line-b"></span>
                    <span class="g-dot g-dot-a"></span>
                    <span class="g-dot g-dot-b"></span>
                    <span class="g-dot g-dot-c"></span>
                    <span class="g-spark g-spark-a">✦</span>
                    <span class="g-spark g-spark-b">✧</span>
                </div>

                <div class="gathering-layout">
                    <div class="g-info-column" data-reveal="right" style="--reveal-delay:.08s">
                        <div class="g-info-card feature">
                            <small>Gathering Date</small>
                            <strong class="responsive-text">{{ $heroDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="g-info-card">
                            <small>Hosted by</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span class="responsive-text">{{ $mainPersonName }}</span>
                        </div>

                        <div class="g-info-card">
                            <small>Mode</small>
                            <strong>{{ $isOnlineEvent ? 'Online Gathering' : 'Offline Gathering' }}</strong>
                            <span>{{ $accessActionText }}</span>
                        </div>

                        <div class="g-info-card">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">{{ $accessName }}</strong>
                            <span class="responsive-text">{{ $isOnlineEvent ? 'Gathering room access' : 'Venue gathering' }}</span>
                        </div>
                    </div>

                    <div class="g-visual-column" data-reveal="zoom" style="--reveal-delay:.16s">
                        <div class="g-cover-frame {{ $invitation->cover_image || $firstPhoto ? 'has-photo' : '' }}">
                            <div class="g-cover-top">
                                <span></span>
                                <span></span>
                                <span></span>
                                <b>{{ $isOnlineEvent ? 'ONLINE ACCESS' : 'VENUE ACCESS' }}</b>
                            </div>

                            <div class="g-cover-screen">
                                @if ($invitation->cover_image)
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Company Gathering" class="g-cover-img">
                                @elseif ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Company Gathering" class="g-cover-img">
                                @else
                                    <div class="g-default-cover">
                                        <img src="{{ asset('assets/icons/corporate2.png') }}" alt="Company Gathering">
                                    </div>
                                @endif
                            </div>

                            <div class="g-cover-caption">
                                <small>Company Gathering</small>
                                <strong class="responsive-text">{{ $eventTitle }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="g-copy-column">
                        <p class="g-kicker" data-reveal="left" style="--reveal-delay:.04s">
                            Team • Appreciation • Togetherness
                        </p>

                        <h1 class="responsive-text corp-title corp-gradient g-title" data-reveal="left" style="--reveal-delay:.10s">
                            {{ $eventTitle }}
                        </h1>

                        <p class="responsive-text g-desc" data-reveal="left" style="--reveal-delay:.18s">
                            {{ $invitation->description ?: 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara company gathering sebagai momen kebersamaan, apresiasi, relasi, dan penguatan hubungan profesional dalam suasana hangat dan elegan.' }}
                        </p>

                        <div class="g-actions" data-reveal="left" style="--reveal-delay:.26s">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="corp-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="corp-btn">Lihat Detail</a>
                            @endif

                            <a href="#about" class="corp-btn secondary">Agenda Gathering</a>
                            <a href="#message" class="corp-btn secondary">Konfirmasi Kehadiran</a>
                        </div>
                    </div>
                </div>

                <div class="g-bottom-strip" data-reveal="zoom" style="--reveal-delay:.44s">
                    <span>{{ $agendaSectionTitle }}</span>
                    <span>•</span>
                    <span>Team Bonding</span>
                    <span>•</span>
                    <span>Appreciation</span>
                    <span>•</span>
                    <span>Networking</span>
                </div>
            </section>

            {{-- PEOPLE / TEAM --}}
            <section id="people" class="corp-section compact text-center">
                <p class="corp-label" data-reveal="zoom">Gathering Circle</p>
                <h2 class="responsive-text corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Tim & Perwakilan</h2>
                <p class="responsive-text desc max-w-2xl mx-auto mt-4" data-reveal="zoom" style="color: var(--corp-text); line-height: 1.85; --reveal-delay:.16s">
                    Menampilkan host, perwakilan perusahaan, pembicara, partner, atau tokoh utama dalam acara company gathering.
                </p>

                <div class="people-grid {{ $people->count() <= 1 ? 'single-person' : '' }}">
                    @forelse ($people as $index => $person)
                        <div class="person-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="person-photo">
                            @else
                                <div class="person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'C', 0, 1)) }}</div>
                            @endif

                            <span class="person-role">{{ $person->subtitle ?: 'Corporate Representative' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Perwakilan' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="person-card" data-reveal="zoom">
                            <div class="person-placeholder">C</div>
                            <span class="person-role">Corporate Representative</span>
                            <h3 class="responsive-text">Nama Perwakilan</h3>
                            <p>Data tim atau perwakilan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- HIGHLIGHTS --}}
            <section id="about" class="corp-section compact">
                <div class="section-head">
                    <p class="corp-label" data-reveal="zoom">Gathering Agenda</p>
                    <h2 class="responsive-text corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                        {{ $agendaSectionTitle }}
                    </h2>
                    <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                        Bagian ini menampilkan agenda utama, momen kebersamaan, sesi apresiasi, atau informasi penting dalam acara gathering perusahaan.
                    </p>
                </div>

                <div class="highlight-grid {{ $highlightGridClass }}">
                    @foreach ($gatheringHighlights as $index => $highlight)
                        <div class="corp-highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            <div class="highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3 class="responsive-text">{{ $highlight['title'] ?? 'Agenda Gathering' }}</h3>
                            <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi agenda company gathering.' }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="corp-section compact">
                <div class="section-head">
                    <p class="corp-label" data-reveal="zoom">Event Access</p>
                    <h2 class="responsive-text corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Detail Acara</h2>
                    <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">
                        Informasi waktu, akses acara, dan lokasi/platform gathering.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="corp-card" data-reveal="left">
                        <h3>Informasi Gathering</h3>

                        <div class="detail-list">
                            <div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $eventName }}</div></div>
                            <div class="detail-row"><div class="label">Mode</div><div class="value responsive-text">{{ $isOnlineEvent ? 'Online Gathering' : 'Offline Gathering' }}</div></div>
                            <div class="detail-row"><div class="label">Tanggal</div><div class="value responsive-text">{{ $eventDateText }}</div></div>
                            <div class="detail-row"><div class="label">Waktu</div><div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div></div>
                            <div class="detail-row"><div class="label">{{ $accessTypeLabel }}</div><div class="value responsive-text">{{ $accessName }}</div></div>
                            <div class="detail-row"><div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div><div class="value responsive-text">{{ $accessDescription }}</div></div>
                        </div>

                        <div class="g-actions mt-6">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="corp-btn">📅 Add Calendar</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="corp-btn secondary">{{ $accessActionIcon }} {{ $accessActionText }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="corp-card" data-reveal="right">
                        <h3>Menuju Acara</h3>

                        <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                            <div class="countdown-card"><span class="countdown-number" data-unit="days">00</span><span class="countdown-label">Hari</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="hours">00</span><span class="countdown-label">Jam</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="minutes">00</span><span class="countdown-label">Menit</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="seconds">00</span><span class="countdown-label">Detik</span></div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--corp-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--corp-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--corp-text);">Link online belum ditambahkan.</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--corp-text);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--corp-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--corp-text);">{{ $accessDescription }}</p>
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
                <section id="gallery" class="corp-section compact">
                    <div class="section-head">
                        <p class="corp-label" data-reveal="zoom">Gathering Gallery</p>
                        <h2 class="responsive-text corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Galeri Gathering</h2>
                        <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">Dokumentasi visual, suasana tim, aktivitas, atau momen kebersamaan perusahaan.</p>
                    </div>

                    <div class="gallery-corporate">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Company Gathering">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Company Gathering">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Company Gathering">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- GIFTS / SUPPORT --}}
            @if ($giftCount)
                <section id="gift" class="corp-section compact">
                    <div class="section-head">
                        <p class="corp-label" data-reveal="zoom">Support</p>
                        <h2 class="corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Informasi Support</h2>
                        <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">Jika disediakan, tamu dapat menggunakan informasi berikut.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Support / Kontak';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Kontak / Rekening / Link</small>
                                        <div class="gift-number responsive-text">{{ $giftNumber }}</div>
                                        <p class="responsive-text text-sm mt-2" style="color: var(--corp-text);">Atas Nama {{ $giftName }}</p>
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
            <section id="message" class="corp-section compact">
                <div class="text-center">
                    <p class="corp-label" data-reveal="zoom">RSVP & Wishes</p>
                    <h2 class="corp-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Ucapan & Kehadiran</h2>
                    <p class="responsive-text mt-4 max-w-2xl mx-auto" data-reveal="zoom" style="color: var(--corp-text); line-height: 1.85; --reveal-delay:.16s">
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

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4" data-reveal="up">
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

                        <button type="submit" class="w-full corp-btn">Kirim Ucapan</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card" data-reveal="zoom"><strong>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</strong><span>Tidak hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.06s"><strong>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong><span>Hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.12s"><strong>{{ $messages->where('attendance_status', 'ragu')->count() }}</strong><span>Ragu</span></div>
                    </div>

                    <div class="message-list">
                        @forelse ($messages as $index => $message)
                            <div class="message-card" data-reveal="up" style="--reveal-delay: {{ min($index * 0.04, 0.24) }}s">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black" style="color: var(--corp-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--corp-text);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--corp-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center" data-reveal="up">
                                <p style="color: var(--corp-text);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="corp-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="corp-label">Togetherness</p>
                    <h2 class="responsive-text corp-title corp-gradient text-5xl md:text-7xl mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--corp-text);">
                        Terima kasih atas waktu, dukungan, dan kehadiran Anda. Semoga acara gathering ini menjadi momen yang mempererat relasi, kebersamaan, dan semangat kolaborasi.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: var(--corp-dark);">{{ $eventTitle }}</h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Music toggle */
            const music = document.getElementById('invitation-music');
            const musicToggle = document.getElementById('music-toggle');
            const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
            let isMusicPlaying = false;

            function setMusicIcon(active) {
                if (!musicIcon || !musicToggle) return;
                musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
                musicToggle.classList.toggle('is-active', active);
            }

            if (musicToggle && music) {
                musicToggle.addEventListener('click', async function () {
                    try {
                        if (isMusicPlaying) {
                            music.pause();
                            isMusicPlaying = false;
                        } else {
                            await music.play();
                            isMusicPlaying = true;
                        }
                        setMusicIcon(isMusicPlaying);
                    } catch (error) {
                        isMusicPlaying = false;
                        setMusicIcon(false);
                    }
                });
            }

            /* Auto scroll toggle - smooth requestAnimationFrame */
            const scrollToggle = document.getElementById('scroll-toggle');
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            if (scrollToggle) {
                const scrollIcon = scrollToggle.querySelector('img');

                function setScrollIcon(active) {
                    scrollToggle.classList.toggle('is-active', active);
                    if (scrollIcon) {
                        scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
                    }
                }

                function stopAutoScroll() {
                    autoScrollActive = false;
                    if (autoScrollFrame) {
                        cancelAnimationFrame(autoScrollFrame);
                        autoScrollFrame = null;
                    }
                    setScrollIcon(false);
                }

                function autoScrollStep() {
                    if (!autoScrollActive) return;

                    const maxY = document.documentElement.scrollHeight - window.innerHeight;
                    const nextY = Math.min(window.scrollY + scrollSpeed, maxY);

                    window.scrollTo({ top: nextY, behavior: 'auto' });

                    if (nextY >= maxY) {
                        stopAutoScroll();
                        return;
                    }

                    autoScrollFrame = requestAnimationFrame(autoScrollStep);
                }

                function startAutoScroll() {
                    stopAutoScroll();
                    autoScrollActive = true;
                    setScrollIcon(true);
                    autoScrollFrame = requestAnimationFrame(autoScrollStep);
                }

                scrollToggle.addEventListener('click', function () {
                    if (autoScrollActive) stopAutoScroll();
                    else startAutoScroll();
                });

                ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                    window.addEventListener(eventName, function () {
                        if (autoScrollActive) stopAutoScroll();
                    }, { passive: true });
                });
            }

            /* Countdown */
            document.querySelectorAll('[data-countdown-target]').forEach(function (wrap) {
                const targetValue = wrap.dataset.countdownTarget;
                if (!targetValue) return;

                const target = new Date(targetValue).getTime();
                const units = {
                    days: wrap.querySelector('[data-unit="days"]'),
                    hours: wrap.querySelector('[data-unit="hours"]'),
                    minutes: wrap.querySelector('[data-unit="minutes"]'),
                    seconds: wrap.querySelector('[data-unit="seconds"]')
                };

                function pad(number) { return String(number).padStart(2, '0'); }

                function updateCountdown() {
                    const now = Date.now();
                    let diff = Math.max(0, target - now);

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    diff -= days * (1000 * 60 * 60 * 24);
                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    diff -= hours * (1000 * 60 * 60);
                    const minutes = Math.floor(diff / (1000 * 60));
                    diff -= minutes * (1000 * 60);
                    const seconds = Math.floor(diff / 1000);

                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

            /* Copy gift/support */
            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';
                    try {
                        await navigator.clipboard.writeText(value);
                        button.classList.add('copied');
                        const oldText = button.textContent;
                        button.textContent = 'Tersalin';
                        setTimeout(function () {
                            button.textContent = oldText;
                            button.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        const textarea = document.createElement('textarea');
                        textarea.value = value;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
                });
            });

            /* Scroll reveal animation */
            const revealElements = document.querySelectorAll('[data-reveal]');

            if (!('IntersectionObserver' in window)) {
                revealElements.forEach(function (element) { element.classList.add('is-visible'); });
            } else {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.14, rootMargin: '0px 0px -60px 0px' });

                revealElements.forEach(function (element) { revealObserver.observe(element); });
            }

            /* Anti inspect ringan tanpa notice */
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
