<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Corporate Networking Night') . ' ' . ($invitation->title ?: 'Corporate Networking Night'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--network-cream);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--network-primary) 22%, transparent), transparent 32%),
                radial-gradient(circle at 88% 0%, color-mix(in srgb, var(--network-secondary) 19%, transparent), transparent 34%),
                radial-gradient(circle at 50% 100%, color-mix(in srgb, var(--network-accent) 22%, transparent), transparent 36%),
                linear-gradient(180deg, #06070d 0%, #11121c 54%, #080910 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .network-shell {
            width: min(100%, 1500px);
            margin: 0 auto;
            padding: clamp(0px, 1.8vw, 24px);
        }

        .network-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: clamp(0px, 3vw, 46px);
            background:
                radial-gradient(circle at 16% 8%, color-mix(in srgb, var(--network-primary) 17%, transparent), transparent 31%),
                radial-gradient(circle at 82% 12%, color-mix(in srgb, var(--network-secondary) 14%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(10,12,22,.96), rgba(17,18,29,.97) 55%, rgba(7,8,13,.98));
            border: 1px solid color-mix(in srgb, var(--network-primary) 22%, rgba(255,255,255,.08));
            box-shadow: 0 42px 120px rgba(0,0,0,.42);
            isolation: isolate;
        }

        .network-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .16;
            background-image:
                linear-gradient(to right, rgba(255,255,255,.09) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 48px 48px;
            z-index: 0;
            animation: networkGridMove 28s linear infinite;
        }

        .network-wrap::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(70deg, transparent 0 21%, rgba(255,255,255,.06) 22%, transparent 37%),
                linear-gradient(110deg, transparent 0 60%, rgba(255,255,255,.05) 61%, transparent 76%);
            opacity: .95;
            z-index: 0;
        }

        .network-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .network-nav {
            position: sticky;
            top: 16px;
            z-index: 80;
            width: fit-content;
            max-width: calc(100% - 24px);
            margin: 18px auto -42px;
            padding: 8px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-radius: 999px;
            background: rgba(8,9,15,.62);
            border: 1px solid color-mix(in srgb, var(--network-primary) 30%, rgba(255,255,255,.12));
            box-shadow: 0 20px 54px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.12);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            scrollbar-width: none;
        }

        .network-nav::-webkit-scrollbar { display: none; }

        .network-nav a {
            flex: 0 0 auto;
            padding: 10px 15px;
            border-radius: 999px;
            text-decoration: none;
            white-space: nowrap;
            color: rgba(255,255,255,.76);
            font-size: 12px;
            font-weight: 950;
            transition: .28s ease;
        }

        .network-nav a:hover {
            color: #111827;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            transform: translateY(-1px);
            box-shadow: 0 12px 28px color-mix(in srgb, var(--network-primary) 30%, transparent);
        }

        .floating-actions {
            position: fixed;
            right: clamp(10px, 1.7vw, 24px);
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
            background: rgba(255,255,255,.94);
            border: 1px solid color-mix(in srgb, var(--network-primary) 22%, transparent);
            box-shadow: 0 18px 40px rgba(0,0,0,.28);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            animation: networkFloatButton 3.8s ease-in-out infinite;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--network-primary) 32%, #ffffff); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .network-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 26px;
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #111827;
            font-weight: 950;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 20px 46px color-mix(in srgb, var(--network-primary) 26%, transparent);
            transition: .28s ease;
        }

        .network-btn::after {
            content: "";
            position: absolute;
            top: -75%;
            left: -80%;
            width: 46%;
            height: 250%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.68), transparent);
            animation: networkShine 3.6s ease-in-out infinite;
            pointer-events: none;
        }

        .network-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 64px color-mix(in srgb, var(--network-primary) 34%, transparent);
        }

        .network-btn.secondary {
            color: var(--network-cream);
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--network-primary) 26%, rgba(255,255,255,.12));
            box-shadow: 0 14px 34px rgba(0,0,0,.22);
            backdrop-filter: blur(14px);
        }

        .network-section {
            min-height: 100vh;
            padding: clamp(68px, 7vw, 98px) clamp(20px, 4.8vw, 76px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .network-section.compact {
            min-height: auto;
            padding-top: clamp(62px, 6vw, 84px);
            padding-bottom: clamp(62px, 6vw, 84px);
        }

        .section-head { text-align: center; }

        .network-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--network-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .23em;
            text-transform: uppercase;
        }

        .network-label::before,
        .network-label::after {
            content: "";
            width: 42px;
            height: 1px;
            background: color-mix(in srgb, var(--network-primary) 52%, transparent);
        }

        .network-title,
        .section-title {
            color: var(--network-cream);
            font-weight: 950;
            letter-spacing: -.06em;
            line-height: .95;
        }

        .section-title {
            margin-top: 18px;
            font-size: clamp(2.35rem, 5vw, 5.2rem);
        }

        .section-desc {
            width: min(100%, 760px);
            margin: 16px auto 0;
            color: rgba(255,255,255,.68);
            line-height: 1.88;
            text-align: center;
        }

        /* ================= HERO AWARD NIGHT / GALA RUNWAY ================= */
        .network-hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            padding: clamp(112px, 8vw, 148px) clamp(18px, 4.8vw, 76px) clamp(70px, 6vw, 96px);
            isolation: isolate;
        }

        .network-hero::before {
            content: "";
            position: absolute;
            inset: 78px clamp(10px, 1.8vw, 28px) 36px;
            z-index: -3;
            border-radius: clamp(30px, 3vw, 52px);
            background:
                radial-gradient(circle at 50% 2%, color-mix(in srgb, var(--network-primary) 28%, transparent), transparent 30%),
                linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02) 48%, rgba(255,255,255,.07)),
                linear-gradient(180deg, rgba(12,13,24,.98), rgba(22,22,36,.96) 58%, rgba(7,8,13,.98));
            border: 1px solid color-mix(in srgb, var(--network-primary) 22%, rgba(255,255,255,.10));
            box-shadow: inset 0 1px 0 rgba(255,255,255,.12), 0 38px 96px rgba(0,0,0,.42);
        }

        .network-spotlight,
        .network-orb,
        .network-spark {
            position: absolute;
            pointer-events: none;
        }

        .network-spotlight {
            top: 72px;
            bottom: 28px;
            width: 34%;
            opacity: .42;
            z-index: -2;
            filter: blur(.2px);
        }

        .network-spotlight.left {
            left: 6%;
            background: linear-gradient(102deg, transparent 0%, color-mix(in srgb, var(--network-primary) 22%, transparent) 44%, transparent 68%);
            clip-path: polygon(42% 0, 70% 0, 100% 100%, 0 100%);
        }

        .network-spotlight.right {
            right: 6%;
            background: linear-gradient(258deg, transparent 0%, color-mix(in srgb, var(--network-secondary) 20%, transparent) 46%, transparent 68%);
            clip-path: polygon(30% 0, 58% 0, 100% 100%, 0 100%);
        }

        .network-orb {
            border-radius: 999px;
            filter: blur(1px);
            z-index: -1;
            opacity: .62;
            animation: networkFloat 7s ease-in-out infinite;
        }

        .network-orb.one { width: 260px; height: 260px; left: 2%; top: 14%; background: color-mix(in srgb, var(--network-primary) 16%, transparent); }
        .network-orb.two { width: 320px; height: 320px; right: 3%; top: 12%; background: color-mix(in srgb, var(--network-secondary) 15%, transparent); animation-delay: -1.5s; }
        .network-orb.three { width: 150px; height: 150px; left: 49%; bottom: 9%; background: color-mix(in srgb, var(--network-accent) 45%, transparent); animation-delay: -3s; }

        .network-spark {
            color: var(--network-primary);
            opacity: .7;
            z-index: 1;
            font-size: 18px;
            animation: networkPulse 3s ease-in-out infinite;
        }

        .network-spark.s1 { left: 9%; top: 29%; }
        .network-spark.s2 { right: 12%; top: 34%; animation-delay: -.7s; }
        .network-spark.s3 { left: 55%; bottom: 17%; animation-delay: -1.4s; }

        .network-hero-layout {
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 220px);
            display: grid;
            grid-template-columns: minmax(180px, 240px) minmax(0, 1fr) minmax(350px, 500px);
            gap: clamp(24px, 3vw, 48px);
            align-items: center;
        }

        .network-rail {
            position: relative;
            align-self: stretch;
            display: grid;
            align-content: center;
            gap: 14px;
        }

        .network-rail::before {
            content: "";
            position: absolute;
            top: 8%;
            bottom: 8%;
            left: 24px;
            width: 1px;
            background: linear-gradient(180deg, transparent, color-mix(in srgb, var(--network-primary) 40%, transparent), transparent);
        }

        .network-rail-card {
            position: relative;
            overflow: hidden;
            min-height: 130px;
            padding: 20px 18px 20px 54px;
            border-radius: 30px;
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--network-primary) 20%, rgba(255,255,255,.10));
            box-shadow: 0 18px 42px rgba(0,0,0,.22);
            backdrop-filter: blur(14px);
        }

        .network-rail-card::before {
            content: "";
            position: absolute;
            left: 17px;
            top: 24px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 0 0 7px color-mix(in srgb, var(--network-primary) 10%, transparent);
        }

        .network-rail-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            width: 88px;
            height: 88px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--network-primary) 20%, transparent);
        }

        .network-rail-card small,
        .network-rail-card strong,
        .network-rail-card span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .network-rail-card small {
            color: var(--network-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
        }

        .network-rail-card strong {
            margin-top: 8px;
            color: var(--network-cream);
            font-size: 1.04rem;
            line-height: 1.35;
            font-weight: 950;
        }

        .network-rail-card span {
            margin-top: 6px;
            color: rgba(255,255,255,.68);
            font-size: 13px;
            line-height: 1.5;
            font-weight: 800;
        }

        .network-copy { min-width: 0; }

        .network-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--network-primary) 24%, rgba(255,255,255,.12));
            color: var(--network-primary);
            box-shadow: 0 14px 34px rgba(0,0,0,.20);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(14px);
        }

        .network-kicker::before {
            content: "✦";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 0 22px color-mix(in srgb, var(--network-primary) 36%, transparent);
        }

        .network-hero-title {
            margin-top: 24px;
            max-width: 780px;
            font-size: clamp(3rem, 6.4vw, 7rem);
            line-height: .87;
            letter-spacing: -.08em;
            color: var(--network-cream);
            font-weight: 950;
        }

        .network-hero-title span {
            background: linear-gradient(135deg, #ffffff, var(--network-primary), var(--network-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .network-hero-desc {
            max-width: 710px;
            margin-top: 24px;
            color: rgba(255,255,255,.72);
            font-size: 1.05rem;
            line-height: 1.92;
        }

        .network-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .network-glam-tags {
            width: min(100%, 780px);
            margin-top: 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .network-glam-tags span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 9px 13px;
            border-radius: 999px;
            color: rgba(255,255,255,.86);
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 12px 26px rgba(0,0,0,.16);
            font-size: 12px;
            font-weight: 900;
        }

        .network-glam-tags span::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 0 14px color-mix(in srgb, var(--network-primary) 36%, transparent);
        }

        .network-stage {
            position: relative;
            min-height: 660px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .network-stage-card {
            position: relative;
            width: min(100%, 500px);
            min-height: 640px;
            overflow: hidden;
            border-radius: 260px 260px 42px 42px;
            background:
                radial-gradient(circle at 50% 10%, color-mix(in srgb, var(--network-primary) 28%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.05));
            border: 1px solid color-mix(in srgb, var(--network-primary) 26%, rgba(255,255,255,.10));
            box-shadow:
                0 36px 96px rgba(0,0,0,.34),
                inset 0 1px 0 rgba(255,255,255,.16);
            backdrop-filter: blur(18px);
        }

        .network-stage-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 240px 240px 30px 30px;
            border: 1px dashed color-mix(in srgb, var(--network-primary) 34%, transparent);
            pointer-events: none;
            z-index: 7;
        }

        .network-stage-card::after {
            content: "AWARD NIGHT";
            position: absolute;
            left: 24px;
            top: 120px;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            color: color-mix(in srgb, var(--network-primary) 54%, transparent);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .26em;
            z-index: 8;
        }

        .network-preview-image {
            position: absolute;
            inset: 72px 44px 188px 64px;
            z-index: 2;
            overflow: hidden;
            border-radius: 220px 220px 30px 30px;
            background:
                radial-gradient(circle at 50% 18%, rgba(255,255,255,.18), transparent 30%),
                linear-gradient(135deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
            border: 1px solid rgba(255,255,255,.14);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.14);
        }

        .network-preview-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            filter: saturate(1.03) contrast(1.04);
        }

        .network-preview-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 30px;
        }

        .network-monogram {
            width: 150px;
            height: 150px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: #111827;
            font-size: 3rem;
            font-weight: 950;
            letter-spacing: -.08em;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 30px 64px color-mix(in srgb, var(--network-primary) 28%, transparent);
        }

        .network-badge-top {
            position: absolute;
            top: 30px;
            right: 34px;
            z-index: 9;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(255,255,255,.16);
            box-shadow: 0 14px 32px rgba(0,0,0,.16);
            color: var(--network-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .network-badge-top::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
        }

        .network-ceremony-card {
            position: absolute;
            left: 38px;
            right: 38px;
            bottom: 34px;
            z-index: 10;
            padding: 24px;
            border-radius: 32px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(255,255,255,.18);
            box-shadow: 0 22px 50px rgba(0,0,0,.22);
            backdrop-filter: blur(16px);
        }

        .network-ceremony-card small,
        .network-ceremony-card strong,
        .network-ceremony-card span { display: block; }

        .network-ceremony-card small {
            color: var(--network-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .network-ceremony-card strong {
            margin-top: 9px;
            color: #111827;
            font-size: clamp(1.55rem, 2.8vw, 2.45rem);
            line-height: 1.02;
            letter-spacing: -.045em;
            font-weight: 950;
        }

        .network-ceremony-card span {
            margin-top: 8px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.45;
            font-weight: 800;
        }

        .network-seal {
            position: absolute;
            right: -20px;
            top: 42%;
            z-index: 12;
            width: 134px;
            height: 134px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 18px;
            color: #111827;
            background:
                radial-gradient(circle at 30% 25%, rgba(255,255,255,.42), transparent 30%),
                linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 26px 58px color-mix(in srgb, var(--network-primary) 32%, transparent);
            animation: networkFloat 5.4s ease-in-out infinite;
        }

        .network-seal strong {
            display: block;
            font-size: 1.5rem;
            line-height: .95;
            font-weight: 950;
        }

        .network-seal span {
            display: block;
            margin-top: 5px;
            font-size: 9px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .9;
        }

        .network-host-card {
            position: absolute;
            left: -24px;
            bottom: 146px;
            z-index: 11;
            width: 238px;
            padding: 18px 20px;
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(255,255,255,.18);
            box-shadow: 0 22px 48px rgba(0,0,0,.22);
            backdrop-filter: blur(16px);
            animation: networkFloat 5.8s ease-in-out -.8s infinite;
        }

        .network-host-card small,
        .network-host-card strong,
        .network-host-card span { display: block; }

        .network-host-card small {
            color: var(--network-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .network-host-card strong {
            margin-top: 7px;
            color: #111827;
            line-height: 1.35;
            font-weight: 950;
        }

        .network-host-card span {
            margin-top: 5px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
        }

        /* Shared cards */
        .network-card,
        .person-card,
        .highlight-card,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card,
        .closing-card {
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--network-primary) 20%, rgba(255,255,255,.10));
            box-shadow: 0 20px 48px rgba(0,0,0,.22);
            backdrop-filter: blur(14px);
        }

        .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 330px));
            justify-content: center;
            gap: 22px;
            margin-top: 42px;
        }

        .people-grid.single-person { grid-template-columns: minmax(280px, 430px); }

        .person-card {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 26px;
            text-align: left;
            transition: .35s ease;
        }

        .person-card::after,
        .highlight-card::after,
        .gift-card::after,
        .network-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--network-primary) 20%, transparent);
        }

        .person-photo,
        .person-placeholder {
            position: relative;
            z-index: 2;
            width: 132px;
            height: 132px;
            border-radius: 999px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.08);
            border: 8px solid rgba(255,255,255,.12);
            box-shadow: 0 18px 36px rgba(0,0,0,.24);
            color: var(--network-primary);
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
            background: color-mix(in srgb, var(--network-primary) 12%, transparent);
            color: var(--network-primary);
            font-size: 12px;
            font-weight: 950;
        }

        .person-card h3,
        .person-card p { position: relative; z-index: 2; }
        .person-card h3 { margin-top: 16px; color: var(--network-cream); font-size: 1.7rem; line-height: 1.12; font-weight: 950; }
        .person-card p { margin-top: 8px; color: rgba(255,255,255,.64); line-height: 1.7; }

        .highlight-grid {
            display: grid;
            gap: 20px;
            margin-top: 42px;
            justify-content: center;
        }
        .highlight-grid.count-1 { grid-template-columns: minmax(280px, 540px); }
        .highlight-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 480px)); }
        .highlight-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .highlight-card {
            position: relative;
            overflow: hidden;
            min-height: 236px;
            padding: 30px;
            border-radius: 38px;
        }

        .highlight-number {
            position: relative;
            z-index: 2;
            width: 58px;
            height: 58px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            font-weight: 950;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            margin-bottom: 22px;
        }

        .highlight-card h3,
        .highlight-card p { position: relative; z-index: 2; }
        .highlight-card h3 { color: var(--network-cream); font-size: 1.42rem; font-weight: 950; }
        .highlight-card p { color: rgba(255,255,255,.66); margin-top: 10px; line-height: 1.8; }

        .detail-layout {
            display: grid;
            grid-template-columns: .96fr 1.04fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .network-card {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 32px;
        }

        .network-card h3 { position: relative; z-index: 2; margin: 0; color: var(--network-cream); font-size: 2rem; font-weight: 950; }
        .detail-list { position: relative; z-index: 2; display: grid; gap: 14px; margin-top: 24px; }
        .detail-row { display: grid; grid-template-columns: 112px 1fr; gap: 16px; padding: 16px 0; border-top: 1px dashed rgba(255,255,255,.15); }
        .detail-row .label { color: var(--network-primary); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .detail-row .value { color: rgba(255,255,255,.86); font-weight: 900; line-height: 1.65; }

        .countdown-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .countdown-card { padding: 22px 14px; text-align: center; border-radius: 26px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); }
        .countdown-number { display: block; color: var(--network-primary); font-size: 34px; line-height: 1; font-weight: 950; animation: networkNumberGlow 2.4s ease-in-out infinite alternate; }
        .countdown-label { display: block; margin-top: 10px; color: rgba(255,255,255,.62); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }

        .map-card { margin-top: 22px; overflow: hidden; border-radius: 32px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); box-shadow: 0 18px 40px rgba(0,0,0,.20); }
        .map-frame,
        .map-placeholder { width: 100%; height: 310px; display: block; border: 0; }
        .map-placeholder { display: flex; align-items: center; justify-content: center; padding: 32px; text-align: center; text-decoration: none; color: var(--network-cream); background: rgba(255,255,255,.06); }

        .gallery-network { display: grid; grid-template-columns: 1.1fr .9fr 1fr; gap: 18px; margin-top: 38px; align-items: stretch; }
        .gallery-column { display: grid; gap: 18px; }
        .gallery-card { padding: 10px; border-radius: 30px; overflow: hidden; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); box-shadow: 0 20px 44px rgba(0,0,0,.20); transition: .35s ease; }
        .gallery-card.tall img { height: 380px; }
        .gallery-card.short img { height: 230px; }
        .gallery-card img { width: 100%; object-fit: cover; border-radius: 22px; display: block; transition: .7s ease; }

        .gift-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 34px; }
        .gift-grid.gift-count-1 { grid-template-columns: minmax(280px, 560px); justify-content: center; }
        .gift-card { position: relative; overflow: hidden; padding: 28px; border-radius: 36px; }
        .gift-card h3,
        .gift-copy-box,
        .gift-card p { position: relative; z-index: 2; }
        .gift-card h3 { color: var(--network-cream); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); }
        .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 950; color: var(--network-primary); }
        .gift-number { display: block; margin-top: 6px; color: var(--network-cream); font-size: 1.1rem; font-weight: 950; }
        .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: #111827; font-size: 12px; font-weight: 950; background: linear-gradient(135deg, var(--network-primary), var(--network-secondary)); }
        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); color: white; }

        .rsvp-wrap { max-width: 920px; width: 100%; margin: 0 auto; }
        .form-card,
        .message-card,
        .summary-card { border-radius: 30px; }
        .form-card { padding: 28px; }
        .form-card .uk-label { color: rgba(255,255,255,.74); font-weight: 900; }
        .form-card .uk-input { background: rgba(255,255,255,.92); color: #111827; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .summary-card { padding: 20px; text-align: center; }
        .summary-card strong { display: block; color: var(--network-primary); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: rgba(255,255,255,.64); font-size: 12px; font-weight: 950; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-info .font-black { color: var(--network-cream) !important; }
        .message-card p { color: rgba(255,255,255,.66); }
        .message-badge { padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--network-primary) 16%, transparent); color: var(--network-primary); font-size: 12px; font-weight: 950; white-space: nowrap; }

        .closing-card {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            border-radius: 44px;
            padding: 54px 36px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--network-primary) 14%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--network-secondary) 14%, transparent), transparent 36%),
                rgba(255,255,255,.08);
        }

        .closing-card h2 { color: var(--network-cream); }
        .closing-card p { color: rgba(255,255,255,.68); }
        .closing-card h3 { color: var(--network-primary); }

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
            .network-card:hover,
            .network-rail-card:hover,
            .person-card:hover,
            .highlight-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover,
            .network-stage-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--network-primary) 42%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(0,0,0,.28),
                    0 0 48px color-mix(in srgb, var(--network-primary) 16%, transparent) !important;
            }

            .gallery-card:hover img,
            .person-card:hover img,
            .network-preview-image:hover img { transform: scale(1.055); filter: saturate(1.08) contrast(1.06); }
        }

        .gallery-card img,
        .person-photo,
        .network-preview-image img { transition: transform .75s ease, filter .75s ease; }

        @keyframes networkGridMove { from { background-position: 0 0, 0 0; } to { background-position: 192px 192px, 192px 192px; } }
        @keyframes networkFloat { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.04); } }
        @keyframes networkFloatButton { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes networkPulse { 0%,100% { transform: scale(1); opacity: .55; } 50% { transform: scale(1.24); opacity: .95; } }
        @keyframes networkShine { 0%,48% { left: -80%; } 75%,100% { left: 130%; } }
        @keyframes networkNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--network-primary) 25%, transparent); }
            to { text-shadow: 0 0 18px color-mix(in srgb, var(--network-primary) 55%, transparent), 0 0 34px color-mix(in srgb, var(--network-secondary) 24%, transparent); }
        }

        @media (max-width: 1180px) {
            .network-hero-layout {
                grid-template-columns: 1fr;
                min-height: auto;
                justify-items: center;
                text-align: center;
            }
            .network-copy { width: min(100%, 920px); order: 1; }
            .network-rail { width: min(100%, 920px); grid-template-columns: repeat(3, minmax(0, 1fr)); align-self: auto; order: 2; }
            .network-rail::before { display: none; }
            .network-stage { width: min(100%, 720px); min-height: auto; order: 3; }
            .network-kicker,
            .network-actions,
            .network-glam-tags { justify-content: center; margin-left: auto; margin-right: auto; }
            .network-hero-title,
            .network-hero-desc { margin-left: auto; margin-right: auto; text-align: center; }
            .network-stage-card { min-height: 590px; }
            .network-host-card,
            .network-seal { position: relative; left: auto; right: auto; top: auto; bottom: auto; width: 100%; height: auto; margin-top: 14px; border-radius: 26px; animation: none; }
            .network-seal { min-height: 96px; }
            .detail-layout,
            .gift-grid { grid-template-columns: 1fr; }
            .highlight-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
            .gallery-network { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .network-shell { padding: 0; }
            .network-wrap { border-radius: 0; box-shadow: none; }
            .network-nav { top: 10px; margin: 12px auto -28px; padding: 7px 10px; }
            .network-nav a { padding: 10px 14px; font-size: 11px; }
            .network-hero { padding: 98px 16px 68px; }
            .network-hero::before { inset: 72px 8px 28px; border-radius: 30px; }
            .network-hero-title { width: 100%; max-width: 390px; font-size: clamp(2.45rem, 12vw, 3.75rem); line-height: 1; letter-spacing: -.055em; }
            .network-hero-desc { width: min(100%, 390px); font-size: .98rem; line-height: 1.82; }
            .network-kicker { max-width: 100%; white-space: normal; line-height: 1.45; justify-content: center; text-align: center; }
            .network-actions { width: min(100%, 390px); display: grid; grid-template-columns: 1fr; }
            .network-actions .network-btn { width: 100%; }
            .network-glam-tags { width: min(100%, 390px); }
            .network-glam-tags span { flex: 1 1 100%; justify-content: center; }
            .network-rail { width: min(100%, 390px); grid-template-columns: 1fr; }
            .network-rail-card { min-height: auto; text-align: left; }
            .network-stage { width: 100%; }
            .network-stage-card { width: min(100%, 390px); min-height: 510px; border-radius: 220px 220px 32px 32px; }
            .network-stage-card::before { inset: 10px; border-radius: 200px 200px 24px 24px; }
            .network-stage-card::after { display: none; }
            .network-preview-image { inset: 56px 28px 150px 28px; border-radius: 190px 190px 24px 24px; }
            .network-badge-top { top: 20px; right: 24px; font-size: 9px; }
            .network-ceremony-card { left: 24px; right: 24px; bottom: 24px; padding: 18px; border-radius: 24px; text-align: center; }
            .network-ceremony-card strong { font-size: 1.5rem; }
            .network-section { padding: 70px 20px; }
            .network-section.compact { padding-top: 64px; padding-bottom: 64px; }
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
            .floating-actions { right: 10px; transform: translateY(-50%) scale(.9); transform-origin: right center; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        /* =========================================================
           CORPORATE NETWORKING NIGHT - VISUAL OVERRIDE
           Tema jaringan kabel, node connection, dan grafik trading
        ========================================================= */
        body {
            color: var(--network-cream);
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--network-primary) 20%, transparent), transparent 32%),
                radial-gradient(circle at 92% 4%, color-mix(in srgb, var(--network-secondary) 18%, transparent), transparent 34%),
                linear-gradient(180deg, #050816 0%, #0b1020 48%, #050816 100%) !important;
        }

        .network-wrap {
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--network-primary) 16%, transparent), transparent 30%),
                radial-gradient(circle at 88% 14%, color-mix(in srgb, var(--network-secondary) 13%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(7, 12, 26, .98), rgba(12, 18, 34, .97) 55%, rgba(6, 9, 18, .98)) !important;
        }

        .network-wrap::before {
            opacity: .20 !important;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--network-primary) 14%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--network-secondary) 12%, transparent) 1px, transparent 1px),
                radial-gradient(circle, color-mix(in srgb, var(--network-primary) 28%, transparent) 1px, transparent 1px) !important;
            background-size: 54px 54px, 54px 54px, 27px 27px !important;
        }

        .network-hero::before {
            background:
                linear-gradient(135deg, rgba(255,255,255,.07), rgba(255,255,255,.025) 48%, rgba(255,255,255,.06)),
                radial-gradient(circle at 24% 20%, color-mix(in srgb, var(--network-primary) 20%, transparent), transparent 28%),
                radial-gradient(circle at 78% 16%, color-mix(in srgb, var(--network-secondary) 18%, transparent), transparent 30%),
                linear-gradient(180deg, rgba(7,12,26,.98), rgba(11,18,36,.96) 58%, rgba(5,8,18,.98)) !important;
        }

        .network-hero::after {
            content: "";
            position: absolute;
            inset: 86px 28px 40px;
            z-index: -2;
            pointer-events: none;
            opacity: .34;
            background:
                linear-gradient(115deg, transparent 0 16%, color-mix(in srgb, var(--network-primary) 22%, transparent) 17%, transparent 18% 48%, color-mix(in srgb, var(--network-secondary) 18%, transparent) 49%, transparent 50%),
                linear-gradient(65deg, transparent 0 34%, color-mix(in srgb, var(--network-primary) 17%, transparent) 35%, transparent 36% 70%, color-mix(in srgb, var(--network-secondary) 15%, transparent) 71%, transparent 72%);
            border-radius: clamp(30px, 3vw, 52px);
        }

        .network-spotlight.left,
        .network-spotlight.right {
            opacity: .30;
            clip-path: none;
            width: 46%;
        }

        .network-spotlight.left {
            background: linear-gradient(110deg, transparent 0%, color-mix(in srgb, var(--network-primary) 18%, transparent) 38%, transparent 70%);
        }

        .network-spotlight.right {
            background: linear-gradient(250deg, transparent 0%, color-mix(in srgb, var(--network-secondary) 16%, transparent) 42%, transparent 72%);
        }

        .network-kicker::before {
            content: "⌁" !important;
        }

        .network-stage-card {
            min-height: 620px;
            border-radius: 44px !important;
            background:
                radial-gradient(circle at 22% 18%, color-mix(in srgb, var(--network-primary) 18%, transparent), transparent 30%),
                radial-gradient(circle at 86% 10%, color-mix(in srgb, var(--network-secondary) 16%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.045)) !important;
        }

        .network-stage-card::before {
            inset: 18px !important;
            border-radius: 32px !important;
            border-style: solid !important;
            opacity: .75;
        }

        .network-stage-card::after {
            content: "";
            position: absolute;
            inset: 82px 34px 186px;
            z-index: 4;
            pointer-events: none;
            border-radius: 28px;
            background:
                linear-gradient(135deg, transparent 0 18%, color-mix(in srgb, var(--network-primary) 18%, transparent) 19%, transparent 20% 48%, color-mix(in srgb, var(--network-secondary) 18%, transparent) 49%, transparent 50%),
                linear-gradient(25deg, transparent 0 24%, rgba(255,255,255,.11) 25%, transparent 26% 64%, rgba(255,255,255,.09) 65%, transparent 66%);
            mix-blend-mode: screen;
        }

        .network-preview-image {
            inset: 82px 34px 186px 34px !important;
            border-radius: 30px !important;
            background:
                linear-gradient(180deg, rgba(8, 13, 28, .88), rgba(12, 20, 38, .96)),
                radial-gradient(circle at 20% 20%, color-mix(in srgb, var(--network-primary) 18%, transparent), transparent 30%) !important;
        }

        .network-preview-image::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            opacity: .44;
            background:
                linear-gradient(to right, rgba(255,255,255,.10) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,.08) 1px, transparent 1px),
                linear-gradient(145deg, transparent 0 30%, color-mix(in srgb, var(--network-primary) 34%, transparent) 31%, transparent 32% 52%, color-mix(in srgb, var(--network-secondary) 26%, transparent) 53%, transparent 54%);
            background-size: 36px 36px, 36px 36px, 100% 100%;
        }

        .network-preview-image::after {
            content: "";
            position: absolute;
            left: 11%;
            right: 11%;
            bottom: 17%;
            height: 44%;
            z-index: 4;
            pointer-events: none;
            background:
                linear-gradient(135deg, transparent 0 15%, var(--network-primary) 16%, transparent 17% 34%, var(--network-secondary) 35%, transparent 36% 52%, var(--network-primary) 53%, transparent 54% 70%, var(--network-secondary) 71%, transparent 72%),
                radial-gradient(circle at 16% 82%, var(--network-primary) 0 5px, transparent 6px),
                radial-gradient(circle at 35% 48%, var(--network-secondary) 0 5px, transparent 6px),
                radial-gradient(circle at 54% 62%, var(--network-primary) 0 5px, transparent 6px),
                radial-gradient(circle at 72% 26%, var(--network-secondary) 0 5px, transparent 6px),
                radial-gradient(circle at 88% 34%, var(--network-primary) 0 5px, transparent 6px);
            filter: drop-shadow(0 0 18px color-mix(in srgb, var(--network-primary) 32%, transparent));
            opacity: .88;
        }

        .network-monogram {
            border-radius: 34px !important;
        }

        .network-ceremony-card {
            border-radius: 30px !important;
        }

        .network-badge-top::before,
        .network-glam-tags span::before,
        .network-rail-card::before {
            box-shadow: 0 0 20px color-mix(in srgb, var(--network-primary) 42%, transparent);
        }

        .network-glam-tags span:nth-child(2n)::before {
            background: linear-gradient(135deg, var(--network-secondary), var(--network-primary));
        }



        .network-node-map {
            position: absolute;
            inset: 82px 34px 186px;
            z-index: 6;
            pointer-events: none;
        }
        .network-node-map .node {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--network-primary), var(--network-secondary));
            box-shadow: 0 0 0 7px color-mix(in srgb, var(--network-primary) 12%, transparent), 0 0 24px color-mix(in srgb, var(--network-primary) 42%, transparent);
            animation: networkPulse 2.8s ease-in-out infinite;
        }
        .network-node-map .n1 { left: 13%; top: 72%; }
        .network-node-map .n2 { left: 33%; top: 40%; animation-delay: -.4s; }
        .network-node-map .n3 { left: 53%; top: 54%; animation-delay: -.8s; }
        .network-node-map .n4 { left: 72%; top: 24%; animation-delay: -1.2s; }
        .network-node-map .n5 { left: 87%; top: 34%; animation-delay: -1.6s; }

        @media (max-width: 760px) {
            .network-stage-card {
                border-radius: 32px !important;
            }
            .network-stage-card::before {
                border-radius: 24px !important;
            }
            .network-preview-image {
                inset: 58px 24px 150px 24px !important;
                border-radius: 24px !important;
            }
        }

        /* =========================================================
        FIX UKURAN JUDUL HERO - CORPORATE NETWORKING NIGHT
        ========================================================= */

        .network-hero-title {
            max-width: 680px !important;
            font-size: clamp(2.45rem, 4.8vw, 5.25rem) !important;
            line-height: .94 !important;
            letter-spacing: -.065em !important;
        }

        /* Tablet / laptop kecil */
        @media (max-width: 1180px) {
            .network-hero-title {
                max-width: 620px !important;
                font-size: clamp(2.35rem, 6.5vw, 4.45rem) !important;
                line-height: .98 !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        /* Mobile */
        @media (max-width: 760px) {
            .network-hero-title {
                max-width: 350px !important;
                font-size: clamp(2rem, 9.4vw, 3rem) !important;
                line-height: 1 !important;
                letter-spacing: -.045em !important;
            }
        }

        /* =========================================================
        CARD PREVIEW LIGHT - KHUSUS 3 TEMPLATE BERAT
        ========================================================= */

        .template-card-preview-light .floating-actions {
            display: none !important;
        }

        /* Reveal langsung terlihat agar tidak blink/blur saat iframe diload */
        .template-card-preview-light [data-reveal] {
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
            transition: none !important;
        }

        /* GRAND OPENING PRO */
        .template-card-preview-light .startup-wrap::before,
        .template-card-preview-light .startup-wrap::after,
        .template-card-preview-light .grand-opening-hero::after,
        .template-card-preview-light .go-pro-hero-v2::after,
        .template-card-preview-light .go-orb,
        .template-card-preview-light .go-line,
        .template-card-preview-light .go-mark,
        .template-card-preview-light .go-pro-bg-orb,
        .template-card-preview-light .go-pro-line,
        .template-card-preview-light .go-pro-dot,
        .template-card-preview-light .editor-orb,
        .template-card-preview-light .editor-line,
        .template-card-preview-light .editor-star,
        .template-card-preview-light .editor-float-card,
        .template-card-preview-light .go-pro-seal,
        .template-card-preview-light .go-pro-host-card,
        .template-card-preview-light .startup-btn::after {
            animation: none !important;
        }

        /* AWARD NIGHT */
        .template-card-preview-light .award-wrap::before,
        .template-card-preview-light .award-wrap::after,
        .template-card-preview-light .award-hero::before,
        .template-card-preview-light .award-spotlight,
        .template-card-preview-light .award-orb,
        .template-card-preview-light .award-spark,
        .template-card-preview-light .award-btn::after,
        .template-card-preview-light .award-seal,
        .template-card-preview-light .award-host-card,
        .template-card-preview-light .countdown-number {
            animation: none !important;
        }

        /* NETWORKING NIGHT */
        .template-card-preview-light .network-wrap::before,
        .template-card-preview-light .network-wrap::after,
        .template-card-preview-light .network-hero::before,
        .template-card-preview-light .network-spotlight,
        .template-card-preview-light .network-orb,
        .template-card-preview-light .network-spark,
        .template-card-preview-light .network-node-map .node,
        .template-card-preview-light .network-node-map,
        .template-card-preview-light .network-btn::after,
        .template-card-preview-light .network-seal,
        .template-card-preview-light .network-host-card,
        .template-card-preview-light .countdown-number {
            animation: none !important;
        }

        /* Kurangi efek repaint berat di preview kecil */
        .template-card-preview-light .award-wrap,
        .template-card-preview-light .startup-wrap,
        .template-card-preview-light .network-wrap,
        .template-card-preview-light .award-hero,
        .template-card-preview-light .grand-opening-hero,
        .template-card-preview-light .go-pro-hero-v2,
        .template-card-preview-light .network-hero,
        .template-card-preview-light .award-stage-card,
        .template-card-preview-light .network-stage-card,
        .template-card-preview-light .editor-vscode-window {
            backface-visibility: hidden;
            transform: translateZ(0);
            will-change: auto !important;
        }

    </style>
</head>
@php
    $themeColor = $invitation->theme_color ?? 'navy';
    if ($themeColor === 'golden') { $themeColor = 'gold'; }

    $themes = [
        'maroon' => ['primary' => '#f43f5e', 'secondary' => '#fb7185', 'accent' => '#ffe4e6', 'dark' => '#be123c', 'cream' => '#fff1f2', 'text' => '#fecdd3'],
        'emerald' => ['primary' => '#34d399', 'secondary' => '#6ee7b7', 'accent' => '#d1fae5', 'dark' => '#047857', 'cream' => '#ecfdf5', 'text' => '#a7f3d0'],
        'navy' => ['primary' => '#60a5fa', 'secondary' => '#38bdf8', 'accent' => '#dbeafe', 'dark' => '#1d4ed8', 'cream' => '#eff6ff', 'text' => '#bfdbfe'],
        'rose' => ['primary' => '#f472b6', 'secondary' => '#fb7185', 'accent' => '#fce7f3', 'dark' => '#db2777', 'cream' => '#fff1f8', 'text' => '#fbcfe8'],
        'gold' => ['primary' => '#fbbf24', 'secondary' => '#f59e0b', 'accent' => '#fef3c7', 'dark' => '#b45309', 'cream' => '#fff7ed', 'text' => '#fde68a'],
        'slate' => ['primary' => '#cbd5e1', 'secondary' => '#94a3b8', 'accent' => '#e2e8f0', 'dark' => '#475569', 'cream' => '#f8fafc', 'text' => '#cbd5e1'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];
    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $people = $invitation->people ?? collect();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $giftCount = $gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Strategic Networking Night';
    $eventName = $invitation->event_name ?: 'Corporate Networking Night';
    $hostName = $invitation->host_name ?: 'Nusantara Business Network';
    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Networking Night Agenda';

    $eventDateText = 'Tanggal belum diatur';
    if ($invitation->event_date) {
        $startDate = \Carbon\Carbon::parse($invitation->event_date);
        $eventDateText = $startDate->translatedFormat('d M Y');

        if ($invitation->event_end_date) {
            $endDate = \Carbon\Carbon::parse($invitation->event_end_date);

            if ($startDate->isSameDay($endDate)) {
                $eventDateText = $startDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                $eventDateText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                $eventDateText = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
            } else {
                $eventDateText = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
            }
        }
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));
    $locationText = $invitation->location_name ?: null;

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Venue';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Networking Room' : 'Executive Networking Hall');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang networking night atau siaran acara.'
        : 'Alamat lengkap venue belum ditambahkan.');
    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '';

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

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n" . $shareUrl . "\n\nMerupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.\n\nTerima kasih.";
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

            $calendarTitle = trim(($invitation->event_name ?: 'Corporate Networking Night') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan corporate networking night') . "\n\nLink Undangan: " . $shareUrl);
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

    $networkHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $networkHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };

    $isCardPreview = request()->routeIs('templates.live-preview')
    && request()->query('card_preview') === '1';
@endphp

<body
    class="{{ $isCardPreview ? 'template-card-preview-light' : '' }}"
    style="
        --network-primary: {{ $activeTheme['primary'] }};
        --network-secondary: {{ $activeTheme['secondary'] }};
        --network-accent: {{ $activeTheme['accent'] }};
        --network-dark: {{ $activeTheme['dark'] }};
        --network-cream: {{ $activeTheme['cream'] }};
        --network-text: {{ $activeTheme['text'] }};
    "
>
    <main class="network-shell">
        <div class="network-wrap">
            <nav class="network-nav" aria-label="Navigasi undangan">
                <a href="#people">Partner</a>
                <a href="#about">Agenda</a>
                <a href="#detail">Access</a>
                @if ($giftCount)<a href="#gift">Support</a>@endif
                <a href="#message">RSVP</a>
            </nav>

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

            {{-- HERO - CORPORATE AWARD NIGHT / GALA RUNWAY --}}
            <section id="opening" class="network-hero">
                <span class="network-spotlight left"></span>
                <span class="network-spotlight right"></span>
                <span class="network-orb one"></span>
                <span class="network-orb two"></span>
                <span class="network-orb three"></span>
                <span class="network-spark s1">✦</span>
                <span class="network-spark s2">✧</span>
                <span class="network-spark s3">✦</span>

                <div class="network-hero-layout">
                    <aside class="network-rail" data-reveal="right" style="--reveal-delay:.10s">
                        <div class="network-rail-card">
                            <small>Date</small>
                            <strong class="responsive-text">{{ $eventDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="network-rail-card">
                            <small>{{ $isOnlineEvent ? 'Mode' : 'Venue' }}</small>
                            <strong class="responsive-text">{{ $isOnlineEvent ? 'Online Networking' : 'Networking Night' }}</strong>
                            <span class="responsive-text">{{ $isOnlineEvent ? 'Join Online' : ($accessName ?: 'Venue networking night') }}</span>
                        </div>

                        <div class="network-rail-card">
                            <small>Host</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span class="responsive-text">{{ $eventName }}</span>
                        </div>
                    </aside>

                    <div class="network-copy">
                        <p class="network-kicker" data-reveal="zoom" style="--reveal-delay:.04s">
                            Network • Trading Graph • Executive Connections
                        </p>

                        <h1 class="network-hero-title responsive-text" data-reveal="zoom" style="--reveal-delay:.10s">
                            <span>{{ $eventTitle }}</span>
                        </h1>

                        <p class="network-hero-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.18s">
                            {{ $invitation->description ?: 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri networking night corporate yang dirancang dengan suasana networking, business matching, market insight, relasi strategis, dan momen networking yang elegan.' }}
                        </p>

                        <div class="network-actions" data-reveal="zoom" style="--reveal-delay:.26s">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="network-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="network-btn">Lihat Detail</a>
                            @endif

                            <a href="#about" class="network-btn secondary">Networking Agenda</a>
                            <a href="#message" class="network-btn secondary">Konfirmasi Kehadiran</a>
                        </div>
                    </div>

                    <div class="network-stage" data-reveal="left" style="--reveal-delay:.14s">
                        <div class="network-stage-card">
                            <div class="network-badge-top">Network Preview</div>

                            <div class="network-node-map" aria-hidden="true">
                                <span class="node n1"></span>
                                <span class="node n2"></span>
                                <span class="node n3"></span>
                                <span class="node n4"></span>
                                <span class="node n5"></span>
                            </div>

                            <div class="network-preview-image">
                                @if ($invitation->cover_image)
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Networking Night">
                                @elseif ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Networking Night">
                                @else
                                    <div class="network-preview-fallback">
                                        <div class="network-monogram">NN</div>
                                    </div>
                                @endif
                            </div>

                            <div class="network-ceremony-card">
                                <small>Networking Session</small>
                                <strong class="responsive-text">{{ $eventName }}</strong>
                                <span class="responsive-text">{{ $agendaSectionTitle }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PEOPLE / HONOREE --}}
            <section id="people" class="network-section compact text-center">
                <p class="network-label" data-reveal="zoom">Network Partner</p>
                <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Partner & Relasi</h2>
                <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                    Bagian ini menampilkan partner utama, host, perwakilan perusahaan, partner, investor, atau tokoh utama dalam networking night.
                </p>

                <div class="people-grid {{ $people->count() <= 1 ? 'single-person' : '' }}">
                    @forelse ($people as $index => $person)
                        <div class="person-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="person-photo">
                            @else
                                <div class="person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'A', 0, 1)) }}</div>
                            @endif

                            <span class="person-role">{{ $person->subtitle ?: 'Network Representative' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Perwakilan' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="person-card" data-reveal="zoom">
                            <div class="person-placeholder">A</div>
                            <span class="person-role">Network Representative</span>
                            <h3 class="responsive-text">Nama Perwakilan</h3>
                            <p>Data partner utama, relasi, atau perwakilan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- HIGHLIGHTS / AWARD AGENDA --}}
            @if ($highlightCount > 0)
                <section id="about" class="network-section compact">
                    <div class="section-head">
                        <p class="network-label" data-reveal="zoom">Networking Agenda</p>
                        <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $agendaSectionTitle }}</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                            Rangkaian acara utama, business matching, sesi networking, market insight, partner meetup, grafik bisnis, atau highlight corporate networking night.
                        </p>
                    </div>

                    <div class="highlight-grid {{ $highlightGridClass }}">
                        @foreach ($networkHighlights as $index => $highlight)
                            <div class="highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <div class="highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <h3 class="responsive-text">{{ $highlight['title'] ?? 'Networking Highlight' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi highlight networking night.' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="network-section compact">
                <div class="section-head">
                    <p class="network-label" data-reveal="zoom">Network Access</p>
                    <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Detail Networking</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                        Informasi waktu, akses acara, dan lokasi/platform networking night.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="network-card" data-reveal="left">
                        <h3>Informasi Networking</h3>

                        <div class="detail-list">
                            <div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $eventName }}</div></div>
                            <div class="detail-row"><div class="label">Mode</div><div class="value responsive-text">{{ $isOnlineEvent ? 'Online Networking Night' : 'Offline Networking Night' }}</div></div>
                            <div class="detail-row"><div class="label">Tanggal</div><div class="value responsive-text">{{ $eventDateText }}</div></div>
                            <div class="detail-row"><div class="label">Waktu</div><div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div></div>
                            <div class="detail-row"><div class="label">{{ $accessTypeLabel }}</div><div class="value responsive-text">{{ $accessName }}</div></div>
                            <div class="detail-row"><div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div><div class="value responsive-text">{{ $accessDescription }}</div></div>
                        </div>

                        <div class="network-actions mt-6">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="network-btn">📅 Add Calendar</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="network-btn secondary">{{ $accessActionIcon }} {{ $accessActionText }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="network-card" data-reveal="right">
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
                                                <p class="responsive-text mt-2" style="color: rgba(255,255,255,.66);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--network-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: rgba(255,255,255,.66);">Link online belum ditambahkan.</p>
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
                                                <p class="responsive-text mt-2" style="color: rgba(255,255,255,.66);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--network-primary);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: rgba(255,255,255,.66);">{{ $accessDescription }}</p>
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
                <section id="gallery" class="network-section compact">
                    <div class="section-head">
                        <p class="network-label" data-reveal="zoom">Networking Gallery</p>
                        <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Galeri Networking Night</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Dokumentasi visual, nominasi, brand, panggung, atau suasana networking.</p>
                    </div>

                    <div class="gallery-network">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Networking Night">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Networking Night">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Networking Night">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- SUPPORT / GIFT --}}
            @if ($giftCount)
                <section id="gift" class="network-section compact">
                    <div class="section-head">
                        <p class="network-label" data-reveal="zoom">Support</p>
                        <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Support / Partner / Contact</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Jika disediakan, bagian ini dapat digunakan untuk informasi partner, sponsor, contact desk, atau support acara.</p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Support / Contact';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>

                                <div class="gift-copy-box">
                                    <div>
                                        <small>Kontak / Link / Rekening</small>
                                        <div class="gift-number responsive-text">{{ $giftNumber }}</div>
                                        <p class="responsive-text text-sm mt-2" style="color: rgba(255,255,255,.64);">Atas Nama {{ $giftName }}</p>
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
            <section id="message" class="network-section compact">
                <div class="section-head">
                    <p class="network-label" data-reveal="zoom">RSVP & Wishes</p>
                    <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Ucapan & Kehadiran</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
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

                        <button type="submit" class="w-full network-btn">Kirim Ucapan</button>
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
                                        <p class="responsive-text font-black">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: rgba(255,255,255,.50);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center" data-reveal="up">
                                <p>Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="network-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="network-label">Standing Ovation</p>
                    <h2 class="section-title responsive-text mt-8">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas waktu, dukungan, dan kehadiran Anda. Semoga malam penghargaan ini menjadi momen apresiasi yang berkesan, elegan, dan penuh inspirasi.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10">{{ $eventTitle }}</h3>
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
            const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            function setScrollIcon(active) {
                if (!scrollIcon || !scrollToggle) return;
                scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
                scrollToggle.classList.toggle('is-active', active);
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

            if (scrollToggle) {
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
