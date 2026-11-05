<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Khitanan') . ' ' . ($invitation->title ?: 'Khitanan Blue'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--kh-dark);
            background:
                radial-gradient(circle at 8% 4%, var(--kh-glow-1), transparent 31%),
                radial-gradient(circle at 92% 0%, var(--kh-glow-2), transparent 32%),
                linear-gradient(180deg, #f8fbff 0%, var(--kh-soft) 48%, #ffffff 100%);
        }

        .blue-shell {
            width: min(100%, 1260px);
            margin: 0 auto;
            padding: 24px;
        }

        .blue-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 48px;
            background:
                radial-gradient(circle at 13% 10%, color-mix(in srgb, var(--kh-accent) 72%, transparent), transparent 32%),
                radial-gradient(circle at 92% 8%, color-mix(in srgb, var(--kh-primary) 14%, transparent), transparent 34%),
                radial-gradient(circle at 48% 92%, color-mix(in srgb, var(--kh-secondary) 11%, transparent), transparent 32%),
                linear-gradient(180deg, rgba(255,255,255,.995), rgba(248,251,255,.965));
            border: 1px solid color-mix(in srgb, var(--kh-primary) 13%, transparent);
            box-shadow: 0 36px 100px rgba(15, 23, 42, .10);
            isolation: isolate;
        }

        .blue-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .16;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--kh-primary) 10%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--kh-primary) 10%, transparent) 1px, transparent 1px);
            background-size: 44px 44px;
            z-index: 0;
        }

        .blue-wrap::after {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 38px;
            border: 1px solid rgba(255,255,255,.70);
            pointer-events: none;
            z-index: 0;
        }

        .blue-wrap > * {
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

        .blue-section {
            min-height: 100vh;
            padding: 96px 66px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .blue-section.compact {
            min-height: auto;
            padding-top: 82px;
            padding-bottom: 82px;
        }

        .blue-nav {
            position: sticky;
            top: 18px;
            z-index: 40;
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
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 16px 36px rgba(15,23,42,.09);
        }

        .blue-nav a {
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--kh-text);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            transition: .28s ease;
        }

        .blue-nav a:hover {
            color: var(--kh-primary);
            background: color-mix(in srgb, var(--kh-primary) 8%, white);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 70;
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
            box-shadow: 0 14px 30px rgba(15,23,42,.16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
            cursor: pointer;
            padding: 0;
            transition: .25s ease;
        }

        .floating-actions a:hover,
        .floating-action-button:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 18px 38px rgba(15,23,42,.20);
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--kh-accent) 48%, white);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .blue-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--kh-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .22em;
            text-transform: uppercase;
        }

        .blue-label::before,
        .blue-label::after {
            content: "";
            width: 38px;
            height: 1px;
            background: color-mix(in srgb, var(--kh-primary) 36%, transparent);
        }

        .blue-title {
            color: var(--kh-dark);
            line-height: .96;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .blue-gradient-text {
            background: linear-gradient(135deg, var(--kh-dark), var(--kh-primary), var(--kh-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .blue-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 950;
            color: white;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
            box-shadow: 0 18px 42px color-mix(in srgb, var(--kh-primary) 22%, transparent);
            transition: transform .28s ease, box-shadow .28s ease;
        }

        .blue-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(255,255,255,.32) 45%, transparent 70%);
            transform: translateX(-115%);
            transition: transform .72s ease;
        }

        .blue-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 52px color-mix(in srgb, var(--kh-primary) 28%, transparent);
        }

        .blue-btn:hover::after { transform: translateX(115%); }

        .blue-btn.secondary {
            color: var(--kh-dark);
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
        }

        /* ================= HERO KHITANAN BLUE ================= */
        .blue-hero {
            position: relative;
            padding: 96px 66px 104px;
            min-height: auto;
            display: grid;
            grid-template-columns: minmax(0, .98fr) minmax(420px, 1.02fr);
            gap: 58px;
            align-items: center;
            isolation: isolate;
        }

        .blue-hero-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .blue-orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(.1px);
            opacity: .72;
            animation: blueFloat 7s ease-in-out infinite;
        }

        .blue-orb.one {
            width: 360px;
            height: 360px;
            right: 11%;
            top: 9%;
            background: color-mix(in srgb, var(--kh-accent) 78%, white);
        }

        .blue-orb.two {
            width: 210px;
            height: 210px;
            left: 5%;
            bottom: 8%;
            background: color-mix(in srgb, var(--kh-secondary) 18%, white);
            animation-delay: -2.5s;
        }

        .blue-orb.three {
            width: 110px;
            height: 110px;
            left: 48%;
            top: 12%;
            background: color-mix(in srgb, var(--kh-primary) 11%, white);
            animation-delay: -1.3s;
        }

        .blue-spark {
            position: absolute;
            width: 18px;
            height: 18px;
            background: var(--kh-primary);
            clip-path: polygon(50% 0%, 60% 36%, 100% 50%, 60% 64%, 50% 100%, 40% 64%, 0% 50%, 40% 36%);
            opacity: .48;
            animation: sparklePulse 3.8s ease-in-out infinite;
        }

        .blue-spark.s1 { left: 9%; top: 24%; }
        .blue-spark.s2 { right: 8%; top: 36%; background: var(--kh-secondary); animation-delay: -1s; }
        .blue-spark.s3 { left: 46%; bottom: 18%; width: 13px; height: 13px; animation-delay: -2s; }

        .blue-copy,
        .blue-visual {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .blue-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(15,23,42,.08);
            color: var(--kh-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .blue-kicker span {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
        }

        .blue-hero-title {
            margin-top: 30px;
            max-width: 680px;
            font-size: clamp(3.15rem, 5.4vw, 5.35rem);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .blue-hero-title .line-accent {
            display: block;
            width: fit-content;
            color: var(--kh-primary);
            position: relative;
            z-index: 1;
        }

        .blue-hero-title .line-accent::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: .07em;
            height: .24em;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 82%, transparent);
            z-index: -1;
        }

        .blue-desc {
            max-width: 610px;
            margin-top: 24px;
            color: var(--kh-text);
            font-size: 1.06rem;
            line-height: 1.95;
        }

        .blue-host-card {
            width: min(100%, 560px);
            margin-top: 30px;
            padding: 17px 19px;
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 15px;
            align-items: center;
            border-radius: 30px;
            background: rgba(255,255,255,.92);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 18px 38px rgba(15,23,42,.07);
        }

        .blue-host-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 35% 30%, #ffffff, transparent 35%),
                color-mix(in srgb, var(--kh-accent) 70%, white);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 14%, transparent);
        }

        .blue-host-icon img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .blue-host-card small {
            display: block;
            color: var(--kh-text);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .blue-host-card strong {
            display: block;
            margin-top: 6px;
            color: var(--kh-dark);
            font-size: 1.08rem;
            font-weight: 950;
            line-height: 1.45;
        }

        .blue-action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .blue-quick-row {
            max-width: 610px;
            margin-top: 34px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .blue-quick-card {
            position: relative;
            overflow: hidden;
            min-width: 0;
            padding: 18px 16px;
            border-radius: 30px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 16px 34px rgba(15,23,42,.07);
        }

        .blue-quick-card::after {
            content: "";
            position: absolute;
            right: -24px;
            bottom: -30px;
            width: 90px;
            height: 90px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 62%, white);
        }

        .blue-quick-card small,
        .blue-quick-card strong {
            position: relative;
            z-index: 1;
            display: block;
        }

        .blue-quick-card small {
            color: var(--kh-text);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .blue-quick-card strong {
            margin-top: 7px;
            color: var(--kh-dark);
            font-size: 1rem;
            line-height: 1.45;
            font-weight: 950;
        }

        .blue-visual-stage {
            position: relative;
            min-height: 720px;
        }

        .blue-arch-glow {
            position: absolute;
            right: 14px;
            top: 56px;
            width: 510px;
            height: 560px;
            border-radius: 260px 260px 70px 70px;
            background:
                radial-gradient(circle at 40% 20%, rgba(255,255,255,.88), transparent 34%),
                linear-gradient(180deg, color-mix(in srgb, var(--kh-accent) 86%, white), rgba(255,255,255,.68));
            box-shadow:
                inset 0 0 0 1px color-mix(in srgb, var(--kh-primary) 9%, transparent),
                0 30px 70px rgba(15,23,42,.08);
            transform: rotate(2deg);
        }

        .blue-main-card {
            position: absolute;
            z-index: 4;
            right: 52px;
            top: 86px;
            width: min(100%, 440px);
            min-height: 560px;
            padding: 28px;
            border-radius: 56px;
            background: rgba(255,255,255,.96);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 14%, transparent);
            box-shadow: 0 36px 96px rgba(15,23,42,.14);
            overflow: hidden;
        }

        .blue-main-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 42px;
            border: 2px dashed color-mix(in srgb, var(--kh-primary) 15%, transparent);
            pointer-events: none;
            z-index: 2;
        }

        .blue-main-card::after {
            content: "";
            position: absolute;
            right: -88px;
            top: -78px;
            width: 240px;
            height: 240px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 64%, transparent);
            z-index: 0;
        }

        .blue-cover-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .10;
            z-index: 0;
        }

        .blue-card-content {
            position: relative;
            z-index: 3;
            min-height: 505px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .blue-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .blue-card-badge {
            padding: 8px 13px;
            border-radius: 999px;
            color: var(--kh-primary);
            background: color-mix(in srgb, var(--kh-accent) 50%, white);
            font-size: 11px;
            font-weight: 950;
        }

        .blue-dots {
            display: flex;
            gap: 7px;
            padding-top: 7px;
        }

        .blue-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--kh-primary);
            opacity: .72;
        }

        .blue-dots span:nth-child(2) { background: var(--kh-secondary); }
        .blue-dots span:nth-child(3) { background: var(--kh-accent); }

        .blue-medal {
            width: 114px;
            height: 114px;
            margin: 28px auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 36px;
            color: white;
            background:
                radial-gradient(circle at 34% 24%, rgba(255,255,255,.40), transparent 36%),
                linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
            box-shadow: 0 22px 44px color-mix(in srgb, var(--kh-primary) 22%, transparent);
            transform: rotate(-4deg);
        }

        .blue-medal img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            transform: rotate(4deg);
        }

        .blue-card-title {
            max-width: 360px;
            margin: 0 auto;
            color: var(--kh-dark);
            font-size: clamp(2.3rem, 4.1vw, 3.5rem);
            line-height: 1.02;
            letter-spacing: -.055em;
            font-weight: 950;
        }

        .blue-card-desc {
            max-width: 370px;
            margin: 18px auto 0;
            color: var(--kh-text);
            line-height: 1.85;
        }

        .blue-info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 28px;
        }

        .blue-info-pill {
            min-width: 0;
            padding: 13px 12px;
            border-radius: 22px;
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
            box-shadow: 0 10px 24px rgba(15,23,42,.06);
            text-align: center;
        }

        .blue-info-pill small {
            display: block;
            color: var(--kh-text);
            font-size: 9px;
            letter-spacing: .14em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .blue-info-pill strong {
            display: block;
            margin-top: 7px;
            color: var(--kh-dark);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 950;
        }

        .blue-name-ticket {
            position: absolute;
            z-index: 6;
            left: 8px;
            top: 52px;
            width: 190px;
            padding: 22px 18px;
            border-radius: 38px 38px 38px 90px;
            background: rgba(255,255,255,.97);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 14%, transparent);
            box-shadow: 0 24px 56px rgba(15,23,42,.12);
            text-align: center;
            transform: rotate(-5deg);
        }

        .blue-avatar {
            width: 78px;
            height: 78px;
            margin: 0 auto 12px;
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 950;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
            box-shadow: 0 16px 30px color-mix(in srgb, var(--kh-primary) 22%, transparent);
        }

        .blue-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blue-name-ticket small {
            display: block;
            color: var(--kh-text);
            font-size: 10px;
            letter-spacing: .17em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .blue-name-ticket strong {
            display: block;
            margin-top: 8px;
            color: var(--kh-dark);
            font-size: 1.2rem;
            line-height: 1.35;
            font-weight: 950;
        }

        .blue-date-card {
            position: absolute;
            z-index: 6;
            left: 88px;
            bottom: 72px;
            width: 152px;
            min-height: 152px;
            padding: 22px 18px;
            border-radius: 40px;
            background: linear-gradient(180deg, rgba(255,255,255,.97), color-mix(in srgb, var(--kh-soft) 88%, white));
            border: 1px solid color-mix(in srgb, var(--kh-primary) 14%, transparent);
            box-shadow: 0 24px 56px rgba(15,23,42,.12);
            text-align: center;
            transform: rotate(5deg);
        }

        .blue-date-card b {
            display: block;
            color: var(--kh-dark);
            font-size: 3rem;
            line-height: 1;
            font-weight: 950;
        }

        .blue-date-card span {
            display: block;
            margin-top: 9px;
            color: var(--kh-primary);
            font-size: 11px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .blue-blessing-pill {
            position: absolute;
            z-index: 7;
            right: 0;
            bottom: 10px;
            width: min(78%, 390px);
            padding: 18px 22px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 13px;
            background: rgba(255,255,255,.97);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 14%, transparent);
            box-shadow: 0 22px 50px rgba(15,23,42,.13);
            color: var(--kh-dark);
            font-weight: 950;
            line-height: 1.55;
        }

        .blue-blessing-pill span {
            width: 44px;
            height: 44px;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
        }

        .section-head { text-align: center; }

        .section-head .desc {
            max-width: 760px;
            margin: 16px auto 0;
            color: var(--kh-text);
            line-height: 1.8;
        }

        .blue-grid {
            display: grid;
            gap: 20px;
            margin-top: 38px;
            justify-content: center;
        }

        .blue-grid.count-1 { grid-template-columns: minmax(280px, 460px); }
        .blue-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .blue-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .blue-highlight-card,
        .child-card,
        .blue-card,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card {
            background: rgba(255,255,255,.93);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 11%, transparent);
            box-shadow: 0 18px 46px rgba(15,23,42,.075);
        }

        .blue-highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 236px;
            padding: 30px;
            border-radius: 36px;
        }

        .blue-highlight-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.55), transparent);
            pointer-events: none;
        }

        .blue-highlight-card::after {
            content: "";
            position: absolute;
            width: 144px;
            height: 144px;
            right: -48px;
            bottom: -48px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 34%, transparent);
        }

        .blue-highlight-number {
            position: relative;
            z-index: 2;
            width: 50px;
            height: 50px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
            margin-bottom: 18px;
            box-shadow: 0 16px 30px color-mix(in srgb, var(--kh-primary) 18%, transparent);
        }

        .blue-highlight-card h3,
        .blue-highlight-card p {
            position: relative;
            z-index: 2;
        }

        .blue-highlight-card h3 {
            color: var(--kh-dark);
            font-size: 1.35rem;
            font-weight: 950;
        }

        .blue-highlight-card p {
            margin-top: 10px;
            color: var(--kh-text);
            line-height: 1.8;
        }

        .child-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 38px;
        }

        .child-grid.single-child { grid-template-columns: minmax(0, 390px); }

        .child-card {
            position: relative;
            overflow: hidden;
            padding: 26px;
            border-radius: 38px;
            text-align: left;
            transition: .35s ease;
        }

        .child-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 64px rgba(15,23,42,.11);
        }

        .child-card::before {
            content: "";
            position: absolute;
            width: 138px;
            height: 138px;
            right: -48px;
            top: -48px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 34%, transparent);
        }

        .child-photo,
        .child-placeholder {
            position: relative;
            z-index: 2;
            width: 122px;
            height: 122px;
            border-radius: 34px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--kh-soft) 90%, white));
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            font-size: 42px;
            font-weight: 950;
            color: var(--kh-primary);
        }

        .child-role {
            position: relative;
            z-index: 2;
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-primary) 10%, white);
            color: var(--kh-primary);
            font-size: 12px;
            font-weight: 950;
        }

        .child-card h3 {
            position: relative;
            z-index: 2;
            margin-top: 16px;
            color: var(--kh-dark);
            font-size: 1.75rem;
            font-weight: 950;
        }

        .child-card p {
            position: relative;
            z-index: 2;
            margin-top: 8px;
            color: var(--kh-text);
            line-height: 1.7;
        }

        .blue-detail-layout {
            display: grid;
            grid-template-columns: 1fr .95fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .blue-card {
            position: relative;
            overflow: hidden;
            padding: 32px;
            border-radius: 38px;
        }

        .blue-card::after {
            content: "";
            position: absolute;
            right: -50px;
            top: -54px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--kh-accent) 36%, transparent);
            pointer-events: none;
        }

        .blue-card h3 {
            position: relative;
            z-index: 2;
            margin: 0;
            color: var(--kh-dark);
            font-size: 2rem;
            font-weight: 950;
        }

        .detail-list {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 14px;
            margin-top: 24px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 112px 1fr;
            gap: 16px;
            padding: 16px 0;
            border-top: 1px dashed color-mix(in srgb, var(--kh-primary) 17%, transparent);
        }

        .detail-row .label {
            color: var(--kh-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--kh-dark);
            font-weight: 900;
            line-height: 1.65;
        }

        .blue-date-line,
        .blue-time-line {
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
            border-radius: 28px;
            padding: 22px 14px;
            text-align: center;
            background: linear-gradient(180deg, color-mix(in srgb, var(--kh-soft) 92%, white), white);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
        }

        .countdown-number {
            display: block;
            color: var(--kh-dark);
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: var(--kh-text);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 24px;
            overflow: hidden;
            border-radius: 36px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--kh-primary) 11%, transparent);
            box-shadow: 0 18px 46px rgba(15,23,42,.08);
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
            color: var(--kh-dark);
            text-decoration: none;
            background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--kh-soft) 90%, white));
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
            border-radius: 30px;
            background: white;
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
            box-shadow: 0 18px 44px rgba(15,23,42,.08);
            transition: .35s ease;
        }

        .gallery-card:hover { transform: translateY(-6px) rotate(.4deg); }
        .gallery-card.tall img { height: 340px; }
        .gallery-card.short img { height: 220px; }

        .gallery-card img {
            width: 100%;
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
            grid-template-columns: minmax(280px, 470px);
            justify-content: center;
        }

        .gift-card {
            position: relative;
            overflow: hidden;
            padding: 28px;
            border-radius: 36px;
        }

        .gift-card h3 {
            color: var(--kh-dark);
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
            border-radius: 22px;
            background: color-mix(in srgb, var(--kh-primary) 7%, white);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
        }

        .gift-copy-box small {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 950;
            color: var(--kh-text);
        }

        .gift-number {
            display: block;
            margin-top: 6px;
            color: var(--kh-primary);
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
            font-weight: 950;
            background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary));
        }

        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        .rsvp-wrap {
            max-width: 880px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            border-radius: 32px;
        }

        .form-card { padding: 30px; }

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
            color: var(--kh-dark);
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--kh-text);
            font-size: 12px;
            font-weight: 950;
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
            background: color-mix(in srgb, var(--kh-primary) 10%, white);
            color: var(--kh-primary);
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
        }

        .closing-card {
            position: relative;
            overflow: hidden;
            max-width: 860px;
            margin: 0 auto;
            padding: 50px 36px;
            text-align: center;
            border-radius: 44px;
            background:
                radial-gradient(circle at 12% 14%, rgba(255,255,255,.72), transparent 28%),
                linear-gradient(135deg, color-mix(in srgb, var(--kh-primary) 10%, white), color-mix(in srgb, var(--kh-accent) 36%, white));
            border: 1px solid color-mix(in srgb, var(--kh-primary) 11%, transparent);
            box-shadow: 0 22px 50px rgba(15,23,42,.08);
        }

        .closing-card::before,
        .closing-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: rgba(255,255,255,.38);
        }

        .closing-card::before { left: -46px; top: -46px; }
        .closing-card::after { right: -46px; bottom: -46px; }

        /* ================= SCROLL ANIMATION ================= */
        [data-reveal] {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .78s cubic-bezier(.2,.8,.2,1),
                transform .78s cubic-bezier(.2,.8,.2,1),
                filter .78s cubic-bezier(.2,.8,.2,1);
            transition-delay: var(--reveal-delay, 0s);
            will-change: transform, opacity, filter;
        }

        [data-reveal="left"] { transform: translateX(-38px) scale(.985); }
        [data-reveal="right"] { transform: translateX(38px) scale(.985); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0, 0) scale(1);
            filter: blur(0);
        }

        .blue-main-card,
        .blue-name-ticket,
        .blue-date-card,
        .blue-blessing-pill,
        .blue-orb,
        .blue-spark,
        .blue-card,
        .blue-highlight-card,
        .gallery-card,
        .gift-card,
        .message-card,
        .summary-card,
        .form-card,
        .child-card,
        .closing-card {
            will-change: transform;
        }

        .blue-orb,
        .blue-arch-glow,
        .blue-name-ticket,
        .blue-date-card,
        .blue-blessing-pill {
            animation: blueFloat 6.5s ease-in-out infinite;
        }

        .blue-name-ticket { animation-delay: -.8s; }
        .blue-date-card { animation-delay: -1.6s; }
        .blue-blessing-pill { animation-delay: -2.4s; }

        @keyframes blueFloat {
            0%, 100% { transform: translateY(0) rotate(var(--rotate, 0deg)); }
            50% { transform: translateY(-9px) rotate(var(--rotate, 0deg)); }
        }

        @keyframes sparklePulse {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: .42; }
            50% { transform: scale(1.22) rotate(18deg); opacity: .82; }
        }

        @media (prefers-reduced-motion: reduce) {
            [data-reveal] {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
                transition: none !important;
            }

            .blue-orb,
            .blue-arch-glow,
            .blue-name-ticket,
            .blue-date-card,
            .blue-blessing-pill,
            .blue-spark {
                animation: none !important;
            }
        }

        @media (max-width: 1100px) {
            .blue-hero,
            .blue-detail-layout,
            .gift-grid {
                grid-template-columns: 1fr;
            }

            .blue-copy { text-align: center; }
            .blue-kicker,
            .blue-action-row { justify-content: center; margin-left: auto; margin-right: auto; }
            .blue-hero-title,
            .blue-desc,
            .blue-host-card,
            .blue-quick-row { margin-left: auto; margin-right: auto; }
            .blue-hero-title .line-accent { margin-left: auto; margin-right: auto; }
            .blue-visual-stage { min-height: auto; display: grid; gap: 16px; }
            .blue-arch-glow,
            .blue-spark { display: none; }

            .blue-main-card,
            .blue-name-ticket,
            .blue-date-card,
            .blue-blessing-pill {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: 100%;
                min-height: auto;
                transform: none;
                animation: none;
            }

            .blue-name-ticket {
                display: grid;
                grid-template-columns: 86px 1fr;
                gap: 16px;
                align-items: center;
                text-align: left;
                border-radius: 34px;
            }

            .blue-avatar { margin: 0; }
            .blue-main-card { border-radius: 42px; }
            .blue-main-card::before { border-radius: 30px; }
            .blue-card-content { min-height: auto; gap: 30px; }
            .blue-date-card { border-radius: 30px; }
            .blue-blessing-pill { border-radius: 30px; }
            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .blue-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        }

        @media (max-width: 980px) {
            .blue-shell { padding: 16px; }
            .blue-section { padding: 82px 38px; }
            .blue-hero { padding: 82px 38px 90px; }
            .summary-grid,
            .countdown-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .blue-shell { padding: 0; }
            .blue-wrap { border-radius: 0; box-shadow: none; }
            .blue-wrap::after { display: none; }
            .blue-section { padding: 72px 22px; }
            .blue-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .blue-hero { padding: 72px 22px 82px; }
            .blue-hero-title { font-size: clamp(2.45rem, 11vw, 3.75rem); line-height: 1.02; }
            .blue-quick-row,
            .blue-info-grid,
            .blue-grid,
            .blue-grid.count-1,
            .blue-grid.count-2,
            .blue-grid.count-3,
            .gallery-column,
            .summary-grid,
            .countdown-grid,
            .gift-grid,
            .gift-grid.gift-count-1 {
                grid-template-columns: 1fr;
            }

            .blue-host-card {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .blue-host-icon { margin: 0 auto; }
            .blue-name-ticket { grid-template-columns: 1fr; text-align: center; }
            .blue-avatar { margin: 0 auto 8px; }
            .blue-main-card { padding: 18px; border-radius: 32px; }
            .blue-main-card::before { inset: 12px; border-radius: 24px; }
            .blue-card-content { padding: 12px 4px 6px; }
            .blue-card-title { font-size: clamp(2rem, 10vw, 3rem); }
            .blue-blessing-pill { flex-direction: column; text-align: center; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
            .floating-actions { right: 10px; }
        }

        /* =========================================================
        KHITANAN BLUE - WOW HERO CONCEPT
        ========================================================= */
        .blue-wow-hero {
            position: relative;
            overflow: hidden;
            padding: 38px 34px 44px;
            border-radius: 42px;
            background:
                radial-gradient(circle at top right, rgba(59,130,246,.14), transparent 28%),
                radial-gradient(circle at bottom left, rgba(96,165,250,.18), transparent 28%),
                linear-gradient(135deg, #f8fbff 0%, #eef6ff 40%, #f8fbff 100%);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow:
                0 32px 80px rgba(15,23,42,.08),
                inset 0 1px 0 rgba(255,255,255,.8);
            isolation: isolate;
        }

        .blue-wow-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .blue-wow-orb,
        .blue-wow-line,
        .blue-wow-star {
            position: absolute;
        }

        .blue-wow-orb {
            border-radius: 999px;
            filter: blur(2px);
            opacity: .65;
            animation: blueFloat 8s ease-in-out infinite;
        }

        .blue-wow-orb.orb-1 {
            width: 320px;
            height: 320px;
            top: -60px;
            right: -40px;
            background: rgba(96,165,250,.20);
        }

        .blue-wow-orb.orb-2 {
            width: 180px;
            height: 180px;
            left: -40px;
            bottom: 40px;
            background: rgba(147,197,253,.22);
            animation-delay: -2s;
        }

        .blue-wow-orb.orb-3 {
            width: 90px;
            height: 90px;
            left: 48%;
            top: 12%;
            background: rgba(59,130,246,.15);
            animation-delay: -3.4s;
        }

        .blue-wow-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59,130,246,.25), transparent);
        }

        .blue-wow-line.line-1 {
            width: 220px;
            top: 110px;
            right: 140px;
        }

        .blue-wow-line.line-2 {
            width: 180px;
            bottom: 120px;
            left: 120px;
        }

        .blue-wow-star {
            width: 18px;
            height: 18px;
            clip-path: polygon(50% 0%, 61% 38%, 100% 50%, 61% 62%, 50% 100%, 39% 62%, 0% 50%, 39% 38%);
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            opacity: .55;
            animation: sparklePulse 4s ease-in-out infinite;
        }

        .blue-wow-star.star-1 { top: 18%; left: 8%; }
        .blue-wow-star.star-2 { top: 28%; right: 12%; animation-delay: -1s; }
        .blue-wow-star.star-3 { bottom: 18%; right: 32%; width: 12px; height: 12px; animation-delay: -2s; }

        .blue-wow-topbar,
        .blue-wow-layout,
        .blue-wow-ribbon {
            position: relative;
            z-index: 2;
        }

        .blue-wow-topbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 28px;
        }

        .blue-wow-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            box-shadow: 0 16px 34px rgba(37,99,235,.18);
        }

        .blue-wow-pill.soft {
            background: rgba(255,255,255,.84);
            color: #1e3a8a;
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 10px 24px rgba(15,23,42,.06);
        }

        .blue-wow-layout {
            display: grid;
            grid-template-columns: minmax(320px, .88fr) minmax(0, 1.12fr);
            gap: 36px;
            align-items: center;
        }

        .blue-wow-stage,
        .blue-wow-content {
            min-width: 0;
            position: relative;
        }

        .blue-wow-photo-shell {
            position: relative;
            padding: 22px;
            border-radius: 42px;
            background: rgba(255,255,255,.58);
            border: 1px solid rgba(59,130,246,.08);
            backdrop-filter: blur(10px);
            box-shadow: 0 26px 70px rgba(15,23,42,.08);
        }

        .blue-wow-photo-frame {
            position: relative;
            overflow: hidden;
            min-height: 560px;
            border-radius: 34px 110px 34px 34px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.7), rgba(255,255,255,.3)),
                linear-gradient(135deg, #dbeafe, #eff6ff);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.65),
                0 28px 70px rgba(15,23,42,.10);
        }

        .blue-wow-photo-frame img {
            width: 100%;
            height: 560px;
            object-fit: cover;
            display: block;
        }

        .blue-wow-avatar-fallback {
            width: 100%;
            height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8rem;
            font-weight: 900;
            color: #ffffff;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }

        .blue-wow-tag {
            position: absolute;
            min-width: 180px;
            max-width: 230px;
            padding: 14px 16px;
            border-radius: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 18px 42px rgba(15,23,42,.12);
            backdrop-filter: blur(8px);
        }

        .blue-wow-tag small,
        .blue-wow-tag strong {
            display: block;
        }

        .blue-wow-tag small {
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: #64748b;
        }

        .blue-wow-tag strong {
            margin-top: 6px;
            font-size: 14px;
            line-height: 1.45;
            font-weight: 900;
            color: #0f172a;
        }

        .blue-wow-tag.tag-date {
            top: 44px;
            right: -20px;
        }

        .blue-wow-tag.tag-location {
            bottom: 130px;
            left: -20px;
        }

        .blue-wow-host {
            position: absolute;
            left: 42px;
            right: 42px;
            bottom: 32px;
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 14px;
            align-items: center;
            padding: 16px 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 18px 38px rgba(15,23,42,.10);
            backdrop-filter: blur(10px);
        }

        .blue-wow-host-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            box-shadow: 0 14px 28px rgba(37,99,235,.18);
        }

        .blue-wow-host-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .blue-wow-host small {
            display: block;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: #64748b;
        }

        .blue-wow-host strong {
            display: block;
            margin-top: 5px;
            font-size: 1.05rem;
            line-height: 1.45;
            font-weight: 900;
            color: #0f172a;
        }

        .blue-wow-mark {
            width: 66px;
            height: 66px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            font-size: 26px;
            box-shadow: 0 16px 36px rgba(37,99,235,.18);
        }

        .blue-wow-kicker {
            margin: 20px 0 0;
            color: #2563eb;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .blue-wow-title {
            margin-top: 16px;
            font-size: clamp(3rem, 5vw, 5.4rem);
            line-height: .95;
            letter-spacing: -.06em;
            font-weight: 950;
            color: #0f172a;
        }

        .blue-wow-subtitle {
            margin-top: 12px;
            font-size: clamp(1.5rem, 2.4vw, 2.4rem);
            line-height: 1.08;
            letter-spacing: -.04em;
            font-weight: 900;
            color: #2563eb;
        }

        .blue-wow-desc {
            max-width: 700px;
            margin-top: 22px;
            color: #475569;
            font-size: 1.03rem;
            line-height: 1.95;
        }

        .blue-wow-info-strip {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .blue-wow-info-card {
            min-width: 0;
            padding: 18px 18px;
            border-radius: 28px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 16px 34px rgba(15,23,42,.07);
        }

        .blue-wow-info-card small,
        .blue-wow-info-card strong {
            display: block;
        }

        .blue-wow-info-card small {
            color: #64748b;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .blue-wow-info-card strong {
            margin-top: 7px;
            color: #0f172a;
            font-size: 14px;
            line-height: 1.55;
            font-weight: 900;
        }

        .blue-wow-blessing {
            margin-top: 24px;
            padding: 20px 22px;
            border-radius: 28px;
            display: grid;
            grid-template-columns: 46px 1fr;
            gap: 14px;
            align-items: start;
            background: linear-gradient(135deg, rgba(255,255,255,.94), rgba(239,246,255,.96));
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 18px 40px rgba(15,23,42,.07);
        }

        .blue-wow-blessing span {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            font-size: 20px;
            box-shadow: 0 12px 28px rgba(37,99,235,.16);
        }

        .blue-wow-blessing p {
            margin: 0;
            color: #0f172a;
            line-height: 1.8;
            font-weight: 700;
        }

        .blue-wow-ribbon {
            margin-top: 28px;
            padding: 16px 22px;
            border-radius: 999px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(59,130,246,.10);
            box-shadow: 0 14px 30px rgba(15,23,42,.05);
            color: #1e3a8a;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        @media (max-width: 1180px) {
            .blue-wow-layout {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .blue-wow-content {
                text-align: center;
            }

            .blue-wow-mark {
                margin: 0 auto;
            }

            .blue-wow-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .blue-wow-info-strip {
                grid-template-columns: 1fr;
            }

            .blue-action-row {
                justify-content: center;
            }

            .blue-wow-blessing {
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            .blue-wow-hero {
                padding: 22px 16px 26px;
                border-radius: 28px;
            }

            .blue-wow-topbar {
                justify-content: center;
            }

            .blue-wow-photo-shell {
                padding: 14px;
                border-radius: 28px;
            }

            .blue-wow-photo-frame {
                min-height: 340px;
                border-radius: 24px 60px 24px 24px;
            }

            .blue-wow-photo-frame img,
            .blue-wow-avatar-fallback {
                height: 340px;
            }

            .blue-wow-tag {
                position: static;
                max-width: none;
                margin-top: 12px;
            }

            .blue-wow-host {
                position: static;
                margin-top: 12px;
                left: auto;
                right: auto;
                bottom: auto;
            }

            .blue-wow-title {
                font-size: clamp(2.4rem, 10vw, 3.8rem);
            }

            .blue-wow-subtitle {
                font-size: clamp(1.25rem, 5vw, 1.8rem);
            }

            .blue-wow-blessing {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .blue-wow-blessing span {
                margin: 0 auto;
            }

            .blue-wow-ribbon {
                border-radius: 26px;
                gap: 8px;
                line-height: 1.6;
            }
        }

        /* =========================================================
        FIX HERO KHITANAN BLUE - IKUT WARNA TEMA USER
        ========================================================= */

        /* Hero utama mengikuti warna pilihan editor */
        .blue-wow-hero {
            background:
                radial-gradient(
                    circle at top right,
                    color-mix(in srgb, var(--kh-primary) 16%, transparent),
                    transparent 30%
                ),
                radial-gradient(
                    circle at bottom left,
                    color-mix(in srgb, var(--kh-secondary) 18%, transparent),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 52% 12%,
                    color-mix(in srgb, var(--kh-accent) 76%, transparent),
                    transparent 36%
                ),
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--kh-soft) 92%, white) 0%,
                    color-mix(in srgb, var(--kh-accent) 54%, white) 42%,
                    color-mix(in srgb, var(--kh-soft) 92%, white) 100%
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;

            box-shadow:
                0 32px 80px rgba(15,23,42,.08),
                inset 0 1px 0 rgba(255,255,255,.82) !important;
        }

        /* Ornamen bulat mengikuti tema */
        .blue-wow-orb.orb-1 {
            background: color-mix(in srgb, var(--kh-primary) 18%, transparent) !important;
        }

        .blue-wow-orb.orb-2 {
            background: color-mix(in srgb, var(--kh-secondary) 20%, transparent) !important;
        }

        .blue-wow-orb.orb-3 {
            background: color-mix(in srgb, var(--kh-accent) 72%, transparent) !important;
        }

        /* Garis dekoratif mengikuti tema */
        .blue-wow-line {
            background:
                linear-gradient(
                    90deg,
                    transparent,
                    color-mix(in srgb, var(--kh-primary) 28%, transparent),
                    transparent
                ) !important;
        }

        /* Bintang dekoratif mengikuti tema */
        .blue-wow-star {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;
        }

        /* Pill bagian atas mengikuti tema */
        .blue-wow-pill {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;

            color: #ffffff !important;
            box-shadow: 0 16px 34px color-mix(in srgb, var(--kh-primary) 20%, transparent) !important;
        }

        .blue-wow-pill.soft {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.88),
                    color-mix(in srgb, var(--kh-accent) 50%, white)
                ) !important;

            color: var(--kh-dark) !important;
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
        }

        /* Frame foto mengikuti tema */
        .blue-wow-photo-shell {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.66),
                    color-mix(in srgb, var(--kh-accent) 38%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent) !important;
        }

        .blue-wow-photo-frame {
            background:
                linear-gradient(
                    180deg,
                    rgba(255,255,255,.72),
                    color-mix(in srgb, var(--kh-accent) 36%, white)
                ),
                linear-gradient(
                    135deg,
                    color-mix(in srgb, var(--kh-primary) 12%, white),
                    color-mix(in srgb, var(--kh-secondary) 10%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
        }

        .blue-wow-avatar-fallback {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;
        }

        /* Floating tag tanggal & lokasi mengikuti tema */
        .blue-wow-tag {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.94),
                    color-mix(in srgb, var(--kh-accent) 34%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
            box-shadow: 0 18px 42px color-mix(in srgb, var(--kh-primary) 13%, transparent) !important;
        }

        .blue-wow-tag small {
            color: var(--kh-text) !important;
        }

        .blue-wow-tag strong {
            color: var(--kh-dark) !important;
        }

        /* Host card mengikuti tema */
        .blue-wow-host {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.94),
                    color-mix(in srgb, var(--kh-accent) 30%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
            box-shadow: 0 18px 38px color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
        }

        .blue-wow-host-icon {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;

            box-shadow: 0 14px 28px color-mix(in srgb, var(--kh-primary) 20%, transparent) !important;
        }

        .blue-wow-host small {
            color: var(--kh-text) !important;
        }

        .blue-wow-host strong {
            color: var(--kh-dark) !important;
        }

        /* Icon mark di kanan mengikuti tema */
        .blue-wow-mark {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;

            box-shadow: 0 16px 36px color-mix(in srgb, var(--kh-primary) 20%, transparent) !important;
        }

        /* Text hero mengikuti tema */
        .blue-wow-kicker {
            color: var(--kh-primary) !important;
        }

        .blue-wow-title {
            color: var(--kh-dark) !important;
        }

        .blue-wow-subtitle {
            color: var(--kh-primary) !important;
        }

        .blue-wow-desc {
            color: var(--kh-text) !important;
        }

        /* Info strip mengikuti tema */
        .blue-wow-info-card {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.92),
                    color-mix(in srgb, var(--kh-accent) 30%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
            box-shadow: 0 16px 34px color-mix(in srgb, var(--kh-primary) 10%, transparent) !important;
        }

        .blue-wow-info-card small {
            color: var(--kh-text) !important;
        }

        .blue-wow-info-card strong {
            color: var(--kh-dark) !important;
        }

        /* Blessing card mengikuti tema */
        .blue-wow-blessing {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.94),
                    color-mix(in srgb, var(--kh-accent) 42%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
            box-shadow: 0 18px 40px color-mix(in srgb, var(--kh-primary) 10%, transparent) !important;
        }

        .blue-wow-blessing span {
            background:
                linear-gradient(
                    135deg,
                    var(--kh-primary),
                    var(--kh-secondary)
                ) !important;

            box-shadow: 0 12px 28px color-mix(in srgb, var(--kh-primary) 18%, transparent) !important;
        }

        .blue-wow-blessing p {
            color: var(--kh-dark) !important;
        }

        /* Ribbon bawah mengikuti tema */
        .blue-wow-ribbon {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.86),
                    color-mix(in srgb, var(--kh-accent) 38%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent) !important;
            color: var(--kh-dark) !important;
        }

        /* Navbar juga ikut warna tema agar menyatu dengan hero */
        .blue-nav {
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.74),
                    color-mix(in srgb, var(--kh-accent) 54%, white)
                ) !important;

            border: 1px solid color-mix(in srgb, var(--kh-primary) 16%, transparent) !important;

            box-shadow:
                0 18px 42px color-mix(in srgb, var(--kh-primary) 12%, transparent),
                inset 0 1px 0 rgba(255,255,255,.78) !important;
        }

        .blue-nav::before {
            background:
                radial-gradient(
                    circle at 50% 20%,
                    color-mix(in srgb, var(--kh-primary) 18%, transparent),
                    transparent 68%
                ) !important;
        }

        .blue-nav a {
            color: var(--kh-text) !important;
        }

        .blue-nav a:hover {
            color: var(--kh-primary) !important;
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.92),
                    color-mix(in srgb, var(--kh-accent) 52%, white)
                ) !important;

            box-shadow:
                0 10px 22px color-mix(in srgb, var(--kh-primary) 13%, transparent),
                inset 0 1px 0 rgba(255,255,255,.90) !important;
        }

    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?: 'blue';

    $themes = [
        'blue' => ['primary'=>'#2563eb','secondary'=>'#38bdf8','accent'=>'#e0f2fe','dark'=>'#102a56','text'=>'#5f718c','soft'=>'#f6fbff','glow1'=>'rgba(37, 99, 235, .12)','glow2'=>'rgba(56, 189, 248, .12)'],
        'navy' => ['primary'=>'#2563eb','secondary'=>'#38bdf8','accent'=>'#e8f3ff','dark'=>'#172554','text'=>'#5b6b82','soft'=>'#f8fbff','glow1'=>'rgba(37, 99, 235, .11)','glow2'=>'rgba(56, 189, 248, .10)'],
        'maroon' => ['primary'=>'#e11d48','secondary'=>'#fb7185','accent'=>'#fde2e9','dark'=>'#4a1623','text'=>'#76505b','soft'=>'#fff7fa','glow1'=>'rgba(225, 29, 72, .12)','glow2'=>'rgba(251, 113, 133, .10)'],
        'emerald' => ['primary'=>'#10b981','secondary'=>'#34d399','accent'=>'#e4f8ee','dark'=>'#064e3b','text'=>'#58766b','soft'=>'#f7fffb','glow1'=>'rgba(16, 185, 129, .12)','glow2'=>'rgba(52, 211, 153, .10)'],
        'rose' => ['primary'=>'#ec4899','secondary'=>'#f472b6','accent'=>'#fff0f7','dark'=>'#5b2140','text'=>'#765c69','soft'=>'#fffafd','glow1'=>'rgba(236, 72, 153, .12)','glow2'=>'rgba(244, 114, 182, .10)'],
        'gold' => ['primary'=>'#d97706','secondary'=>'#f59e0b','accent'=>'#fff4d7','dark'=>'#4a3511','text'=>'#75644e','soft'=>'#fffdf7','glow1'=>'rgba(217, 119, 6, .12)','glow2'=>'rgba(245, 158, 11, .10)'],
        'slate' => ['primary'=>'#475569','secondary'=>'#94a3b8','accent'=>'#f1f5f9','dark'=>'#1e293b','text'=>'#64748b','soft'=>'#ffffff','glow1'=>'rgba(71, 85, 105, .08)','glow2'=>'rgba(148, 163, 184, .08)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['blue'];
    $firstPhoto = $invitation->photos->first();
    $children = $invitation->people ?? collect();
    $childCount = $children->count();
    $firstChild = $children->first();
    $eventTitle = $invitation->title ?: 'Khitanan Blue';
    $eventName = $invitation->event_name ?: 'Tasyakuran Khitanan';
    $hostName = $invitation->host_name ?: null;
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventDateText = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') : 'Tanggal belum diatur';
    if ($invitation->event_end_date) {
        $eventDateText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y');
    }

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: null;

    // Template Khitanan hanya mendukung acara offline.
    // Variabel ini dipertahankan agar aman jika ada sisa pengecekan lama.
    $eventMode = 'offline';
    $isOnlineEvent = false;
    $onlineUrl = '';

    $shareMessage = "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) {
        $shareMessage .= "Diselenggarakan oleh: {$hostName}\n";
    }

    $shareMessage .= "Tanggal: {$eventDateText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    if ($invitation->address) { $shareMessage .= "Alamat: {$invitation->address}\n"; }

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n" .
        $shareUrl .
        "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\n" .
        "Wassalamu'alaikum Wr. Wb.";

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
            $endDateTime = !empty($invitation->event_end_time)
                ? \Carbon\Carbon::parse($endDate . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s'))
                : $startDateTime->copy()->addHours(3);

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Khitanan') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan khitanan') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));
            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE' .
                '&text=' . rawurlencode($calendarTitle) .
                '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis') .
                '&details=' . rawurlencode($calendarDetails) .
                '&location=' . rawurlencode($calendarLocation) .
                '&ctz=Asia/Jakarta';
        } catch (\Exception $e) {
            $googleCalendarUrl = null;
        }
    }

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

    $khitanHighlights = collect($invitation->event_highlights ?? [])
        ->filter(fn($item) => !empty($item['title']) || !empty($item['description']))
        ->take(12)
        ->values();

    $highlightCount = $khitanHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3'
    };

    $giftCount = $invitation->gifts->count();
@endphp

<body style="--kh-primary: {{ $activeTheme['primary'] }}; --kh-secondary: {{ $activeTheme['secondary'] }}; --kh-accent: {{ $activeTheme['accent'] }}; --kh-dark: {{ $activeTheme['dark'] }}; --kh-text: {{ $activeTheme['text'] }}; --kh-soft: {{ $activeTheme['soft'] }}; --kh-glow-1: {{ $activeTheme['glow1'] }}; --kh-glow-2: {{ $activeTheme['glow2'] }};">
    <main class="blue-shell">
        <div class="blue-wrap">
            <div class="floating-actions" data-reveal="right">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan" class="floating-icon">
                </a>

                <button type="button" id="music-toggle" class="floating-action-button" title="Music">
                    <img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music" class="floating-icon">
                </button>

                <button type="button" id="scroll-toggle" class="floating-action-button" title="Auto Scroll">
                    <img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll" class="floating-icon">
                </button>

                @if ($mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background4.mp3') }}" preload="auto" loop></audio>

            <section id="opening" class="blue-wow-hero">
                <nav class="blue-nav" data-reveal="zoom">
                    <a href="#children">Ananda</a>
                    <a href="#detail">Detail</a>
                    @if ($invitation->photos->count())<a href="#gallery">Galeri</a>@endif
                    @if ($giftCount)<a href="#gift">Amplop</a>@endif
                    <a href="#message">Ucapan</a>
                </nav>

                <div class="blue-wow-bg" aria-hidden="true">
                    <span class="blue-wow-orb orb-1"></span>
                    <span class="blue-wow-orb orb-2"></span>
                    <span class="blue-wow-orb orb-3"></span>
                    <span class="blue-wow-line line-1"></span>
                    <span class="blue-wow-line line-2"></span>
                    <span class="blue-wow-star star-1"></span>
                    <span class="blue-wow-star star-2"></span>
                    <span class="blue-wow-star star-3"></span>
                </div>

                <div class="blue-wow-layout">
                    <div class="blue-wow-stage" data-reveal="left">
                        <div class="blue-wow-photo-shell">
                            <div class="blue-wow-photo-frame">
                                @if ($invitation->cover_image)
                                    <img
                                        src="{{ asset('storage/' . $invitation->cover_image) }}"
                                        alt="Cover Khitanan"
                                        class="blue-wow-hero-img is-cover"
                                    >
                                @else
                                    <img
                                        src="{{ asset('assets/icons/khitan.png') }}"
                                        alt="Ilustrasi Khitanan"
                                        class="blue-wow-hero-img is-default"
                                    >
                                @endif
                            </div>

                            <div class="blue-wow-tag tag-date" data-reveal="zoom" style="--reveal-delay:.08s">
                                <small>Tanggal</small>
                                <strong>
                                    @if ($invitation->event_date)
                                        {{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}
                                    @else
                                        Belum diatur
                                    @endif
                                </strong>
                            </div>

                            <div class="blue-wow-host" data-reveal="up" style="--reveal-delay:.20s">
                                <div class="blue-wow-host-icon">
                                    <img src="{{ asset('assets/icons/family.png') }}" alt="Keluarga">
                                </div>
                                <div>
                                    <small>Diselenggarakan Oleh</small>
                                    <strong class="responsive-text">{{ $invitation->host_name ?: 'Keluarga Besar' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="blue-wow-content">
                        <h1 class="blue-wow-title responsive-text" data-reveal="right" style="--reveal-delay:.10s">
                            {{ $invitation->title ?: 'Khitanan Blue' }}
                        </h1>

                        <h2 class="blue-wow-subtitle responsive-text" data-reveal="right" style="--reveal-delay:.16s">
                            {{ $invitation->seminar_about_title ?: 'Hari Bahagia untuk Jagoan Kecil' }}
                        </h2>

                        <p class="blue-wow-desc responsive-text" data-reveal="right" style="--reveal-delay:.22s">
                            {{ $invitation->description ?: 'Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara khitanan putra kami.' }}
                        </p>

                        <div class="blue-wow-info-strip" data-reveal="up" style="--reveal-delay:.28s">
                            <div class="blue-wow-info-card">
                                <small>Acara</small>
                                <strong class="responsive-text">{{ $invitation->event_name ?: 'Tasyakuran Khitanan' }}</strong>
                            </div>

                            <div class="blue-wow-info-card">
                                <small>Waktu</small>
                                <strong>
                                    @if ($invitation->event_time)
                                        {{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}
                                        @if ($invitation->event_end_time)
                                            - {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}
                                        @endif
                                    @else
                                        Belum diatur
                                    @endif
                                </strong>
                            </div>

                            <div class="blue-wow-info-card">
                                <small>Alamat</small>
                                <strong class="responsive-text">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan' }}</strong>
                            </div>
                        </div>

                        <div class="blue-action-row" data-reveal="up" style="--reveal-delay:.34s">
                            <a href="#detail" class="blue-btn">Lihat Detail</a>
                            <a href="#message" class="blue-btn secondary">Kirim Ucapan</a>
                        </div>

                        <div class="blue-wow-blessing" data-reveal="up" style="--reveal-delay:.40s">
                            <span>❝</span>
                            <p class="responsive-text">
                                Semoga menjadi anak yang saleh, sehat, berani, membanggakan orang tua, serta selalu dilimpahi keberkahan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="blue-wow-ribbon" data-reveal="zoom" style="--reveal-delay:.48s">
                    <span>Khitanan</span>
                    <span>•</span>
                    <span>Doa Terbaik</span>
                    <span>•</span>
                    <span>Momen Bahagia</span>
                    <span>•</span>
                    <span>Keluarga Tercinta</span>
                </div>
            </section>

            <section id="about" class="blue-section compact text-center">
                <p class="blue-label" data-reveal="zoom">Tentang Acara</p>

                <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">
                    {{ $invitation->seminar_about_title ?: 'Doa, Syukur, dan Kebahagiaan Keluarga' }}
                </h2>

                <p class="responsive-text desc text-slate-600 mt-4 max-w-3xl mx-auto leading-8" data-reveal="zoom" style="--reveal-delay:.16s">
                    {{ $invitation->host_name
                        ? 'Acara ini dipersembahkan oleh ' . $invitation->host_name . ' sebagai wujud syukur dan doa baik untuk ananda tercinta.'
                        : 'Acara khitanan ini menjadi momen untuk berkumpul, berbagi doa, dan merayakan hari bahagia ananda dengan penuh rasa syukur.' }}
                </p>

                @if ($highlightCount > 0)
                    <div class="blue-grid {{ $highlightGridClass }} text-left">
                        @foreach ($khitanHighlights as $index => $highlight)
                            <div class="blue-highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <div class="blue-highlight-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <h3 class="responsive-text">
                                    {{ $highlight['title'] ?: 'Momen Khitanan' }}
                                </h3>

                                <p class="responsive-text">
                                    {{ $highlight['description'] ?: 'Deskripsi momen khitanan akan tampil di sini.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section id="children" class="blue-section compact text-center">
                <p class="blue-label" data-reveal="zoom">Ananda</p>
                <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Yang Berbahagia</h2>
                <p class="responsive-text text-slate-600 mt-4 max-w-2xl mx-auto leading-7" data-reveal="zoom" style="--reveal-delay:.16s">Data ananda akan tampil di bagian ini sesuai isian pada editor.</p>

                <div class="child-grid {{ $childCount <= 1 ? 'single-child' : '' }}">
                    @forelse ($children as $person)
                        <div class="child-card" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" class="child-photo" alt="{{ $person->name }}">
                            @else
                                <div class="child-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'A', 0, 1)) }}</div>
                            @endif

                            <span class="child-role">{{ $person->subtitle ?: 'Ananda' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Anak' }}</h3>

                            @if (!empty($person->description))
                                <p class="responsive-text">{{ $person->description }}</p>
                            @elseif (!empty($person->family_name))
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="child-card" data-reveal="zoom">
                            <div class="child-placeholder">A</div>
                            <span class="child-role">Ananda</span>
                            <h3>Nama Anak</h3>
                            <p>Data ananda belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="detail" class="blue-section compact">
                <div class="section-head">
                    <p class="blue-label" data-reveal="zoom">Detail Acara</p>
                    <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Informasi Kehadiran</h2>
                    <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">Simpan jadwalnya, lihat lokasinya, dan jangan sampai terlewat momen bahagia ini.</p>
                </div>

                <div class="blue-detail-layout">
                    <div class="blue-card" data-reveal="left">
                        <h3>Detail Khitanan</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label">Acara</div>
                                <div class="value responsive-text">{{ $invitation->event_name ?: 'Tasyakuran Khitanan' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value blue-date-line">
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
                                <div class="value blue-time-line">
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
                                <div class="value responsive-text">{{ $invitation->location_name ?: 'Kediaman Keluarga' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="label">Alamat</div>
                                <div class="value responsive-text">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan' }}</div>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="blue-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="blue-btn secondary">📍 Buka Maps</a>
                            @endif
                        </div>
                    </div>

                    <div data-reveal="right">
                        <div class="blue-card">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget) Hitung mundur menuju acara @else Tanggal acara belum diatur @endif
                            </p>

                            <h3 class="mt-3">Countdown Acara</h3>
                            <p class="responsive-text text-slate-600 mt-3 leading-7">Siapkan waktu terbaik untuk hadir dan memberikan doa untuk ananda.</p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div>
                            </div>
                        </div>

                        @if ($invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card" data-reveal="zoom">
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
                                            <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                            <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p>
                                            <p class="responsive-text mt-4 font-bold" style="color: var(--kh-primary);">Buka Google Maps →</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="map-placeholder">
                                        <div>
                                            <p class="text-5xl">📍</p>
                                            <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p>
                                            <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan.' }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            @if ($invitation->photos->count())
                <section id="gallery" class="blue-section compact text-center">
                    <p class="blue-label" data-reveal="zoom">Galeri</p>
                    <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Momen Bahagia</h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos->chunk(2) as $chunk)
                            <div class="gallery-column">
                                @foreach ($chunk as $photo)
                                    <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->parent->index * 0.08 + $loop->index * 0.05, 0.35) }}s">
                                        <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Khitanan">
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($giftCount)
                <section id="gift" class="blue-section compact text-center">
                    <p class="blue-label" data-reveal="zoom">Amplop Digital</p>
                    <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Kirim Tanda Kasih</h2>
                    <p class="responsive-text text-slate-600 mt-4 max-w-2xl mx-auto leading-8" data-reveal="zoom" style="--reveal-delay:.16s">Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi di bawah ini.</p>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }} text-left">
                        @foreach ($invitation->gifts as $gift)
                            @php
                                $giftLabel = $gift->label ?? ($gift->bank_name ?? ($gift->ewallet_name ?? 'Amplop Digital'));
                                $accountName = $gift->account_name ?? null;
                                $accountNumber = $gift->account_number ?? ($gift->ewallet_number ?? null);
                            @endphp

                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.07, 0.28) }}s">
                                <h3 class="responsive-text">{{ $giftLabel ?: 'Amplop Digital' }}</h3>
                                <p class="responsive-text text-slate-600 mt-2 leading-7">{{ $accountName ?: 'Atas nama penerima' }}</p>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Nomor</small>
                                        <strong class="gift-number responsive-text">{{ $accountNumber ?: '-' }}</strong>
                                    </div>

                                    @if ($accountNumber)
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $accountNumber }}">Salin</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="message" class="blue-section compact">
                <div class="section-head">
                    <p class="blue-label" data-reveal="zoom">RSVP & Ucapan</p>
                    <h2 class="responsive-text blue-title text-5xl md:text-6xl mt-6" data-reveal="zoom" style="--reveal-delay:.08s">Konfirmasi Kehadiran</h2>
                    <p class="responsive-text desc" data-reveal="zoom" style="--reveal-delay:.16s">Silakan isi form untuk konfirmasi kehadiran dan kirim ucapan terbaik.</p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5" data-reveal="zoom">{{ session('message_success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5" data-reveal="zoom">
                            <p class="font-bold">Mohon periksa kembali isian:</p>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4" data-reveal="zoom">
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
                            <textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan atau pesan..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full blue-btn">Kirim Konfirmasi</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card" data-reveal="zoom"><strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong><span>Tidak hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.08s"><strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong><span>Hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.16s"><strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong><span>Ragu</span></div>
                    </div>

                    <div class="message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="message-card" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.04, 0.24) }}s">
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
                            <div class="message-card text-center" data-reveal="zoom">
                                <p class="text-slate-500">Belum ada konfirmasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="blue-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="blue-label">Terima Kasih</p>
                    <h2 class="responsive-text blue-title blue-gradient-text text-5xl md:text-7xl mt-8">Sampai Jumpa</h2>
                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">Terima kasih atas doa, perhatian, dan kehadiran Anda. Semoga acara khitanan ini menjadi momen penuh kebahagiaan dan keberkahan bagi keluarga kami.</p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">{{ $invitation->title ?: 'Khitanan Blue' }}</h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');
            if (countdownContainer) {
                const targetDate = new Date(countdownContainer.getAttribute('data-countdown-target'));
                const daysEl = document.getElementById('countdown-days');
                const hoursEl = document.getElementById('countdown-hours');
                const minutesEl = document.getElementById('countdown-minutes');
                const secondsEl = document.getElementById('countdown-seconds');
                const noteEl = document.getElementById('countdown-note');

                function pad(n) { return String(n).padStart(2, '0'); }

                function updateCountdown() {
                    if (isNaN(targetDate.getTime())) {
                        if (noteEl) noteEl.textContent = 'Format tanggal atau waktu acara belum valid.';
                        return;
                    }

                    const now = new Date();
                    let distance = targetDate.getTime() - now.getTime();
                    if (distance < 0) distance = 0;

                    const total = Math.floor(distance / 1000);
                    const days = Math.floor(total / (60 * 60 * 24));
                    const hours = Math.floor((total % (60 * 60 * 24)) / (60 * 60));
                    const minutes = Math.floor((total % (60 * 60)) / 60);
                    const seconds = Math.floor(total % 60);

                    if (daysEl) daysEl.textContent = pad(days);
                    if (hoursEl) hoursEl.textContent = pad(hours);
                    if (minutesEl) minutesEl.textContent = pad(minutes);
                    if (secondsEl) secondsEl.textContent = pad(seconds);
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
                    } catch (error) {
                        musicToggle.classList.remove('is-active');
                    }
                });
            }

            const scrollToggle = document.getElementById('scroll-toggle');
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            if (scrollToggle) {
                const scrollIcon = scrollToggle.querySelector('img');

                function setScrollIcon(active) {
                    scrollToggle.classList.toggle('is-active', active);

                    if (scrollIcon) {
                        scrollIcon.src = active
                            ? scrollIcon.dataset.iconOn
                            : scrollIcon.dataset.iconOff;
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

                    window.scrollTo({
                        top: nextY,
                        behavior: 'auto'
                    });

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
                    if (autoScrollActive) {
                        stopAutoScroll();
                    } else {
                        startAutoScroll();
                    }
                });

                ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                    window.addEventListener(eventName, function () {
                        if (autoScrollActive) {
                            stopAutoScroll();
                        }
                    }, { passive: true });
                });
            }

            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.getAttribute('data-copy');
                    if (!value) return;

                    try {
                        await navigator.clipboard.writeText(value);
                        const originalText = button.textContent;
                        button.textContent = 'Tersalin';
                        button.classList.add('copied');

                        setTimeout(function () {
                            button.textContent = originalText;
                            button.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        button.textContent = 'Gagal';
                    }
                });
            });

            const revealItems = document.querySelectorAll('[data-reveal]');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });

                revealItems.forEach(function (item) {
                    observer.observe(item);
                });
            } else {
                revealItems.forEach(function (item) {
                    item.classList.add('is-visible');
                });
            }

            // Anti inspect sederhana tanpa notice. Ini hanya penghambat ringan di sisi frontend.
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            document.addEventListener('keydown', function (event) {
                const key = (event.key || '').toLowerCase();
                const blocked =
                    key === 'f12' ||
                    (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) ||
                    (event.ctrlKey && ['u', 's'].includes(key));

                if (blocked) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            }, true);

            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });
        });
    </script>
</body>
</html>
