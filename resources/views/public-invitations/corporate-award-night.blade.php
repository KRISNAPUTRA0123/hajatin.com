<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Corporate Award Night') . ' ' . ($invitation->title ?: 'Corporate Award Night'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--award-cream);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--award-primary) 22%, transparent), transparent 32%),
                radial-gradient(circle at 88% 0%, color-mix(in srgb, var(--award-secondary) 19%, transparent), transparent 34%),
                radial-gradient(circle at 50% 100%, color-mix(in srgb, var(--award-accent) 22%, transparent), transparent 36%),
                linear-gradient(180deg, #06070d 0%, #11121c 54%, #080910 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .award-shell {
            width: min(100%, 1500px);
            margin: 0 auto;
            padding: clamp(0px, 1.8vw, 24px);
        }

        .award-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: clamp(0px, 3vw, 46px);
            background:
                radial-gradient(circle at 16% 8%, color-mix(in srgb, var(--award-primary) 17%, transparent), transparent 31%),
                radial-gradient(circle at 82% 12%, color-mix(in srgb, var(--award-secondary) 14%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(10,12,22,.96), rgba(17,18,29,.97) 55%, rgba(7,8,13,.98));
            border: 1px solid color-mix(in srgb, var(--award-primary) 22%, rgba(255,255,255,.08));
            box-shadow: 0 42px 120px rgba(0,0,0,.42);
            isolation: isolate;
        }

        .award-wrap::before {
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
            animation: awardGridMove 28s linear infinite;
        }

        .award-wrap::after {
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

        .award-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .award-nav {
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
            border: 1px solid color-mix(in srgb, var(--award-primary) 30%, rgba(255,255,255,.12));
            box-shadow: 0 20px 54px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.12);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            scrollbar-width: none;
        }

        .award-nav::-webkit-scrollbar { display: none; }

        .award-nav a {
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

        .award-nav a:hover {
            color: #111827;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            transform: translateY(-1px);
            box-shadow: 0 12px 28px color-mix(in srgb, var(--award-primary) 30%, transparent);
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
            border: 1px solid color-mix(in srgb, var(--award-primary) 22%, transparent);
            box-shadow: 0 18px 40px rgba(0,0,0,.28);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            animation: awardFloatButton 3.8s ease-in-out infinite;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--award-primary) 32%, #ffffff); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .award-btn {
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
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 20px 46px color-mix(in srgb, var(--award-primary) 26%, transparent);
            transition: .28s ease;
        }

        .award-btn::after {
            content: "";
            position: absolute;
            top: -75%;
            left: -80%;
            width: 46%;
            height: 250%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.68), transparent);
            animation: awardShine 3.6s ease-in-out infinite;
            pointer-events: none;
        }

        .award-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 64px color-mix(in srgb, var(--award-primary) 34%, transparent);
        }

        .award-btn.secondary {
            color: var(--award-cream);
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--award-primary) 26%, rgba(255,255,255,.12));
            box-shadow: 0 14px 34px rgba(0,0,0,.22);
            backdrop-filter: blur(14px);
        }

        .award-section {
            min-height: 100vh;
            padding: clamp(68px, 7vw, 98px) clamp(20px, 4.8vw, 76px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .award-section.compact {
            min-height: auto;
            padding-top: clamp(62px, 6vw, 84px);
            padding-bottom: clamp(62px, 6vw, 84px);
        }

        .section-head { text-align: center; }

        .award-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--award-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .23em;
            text-transform: uppercase;
        }

        .award-label::before,
        .award-label::after {
            content: "";
            width: 42px;
            height: 1px;
            background: color-mix(in srgb, var(--award-primary) 52%, transparent);
        }

        .award-title,
        .section-title {
            color: var(--award-cream);
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
        .award-hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            padding: clamp(112px, 8vw, 148px) clamp(18px, 4.8vw, 76px) clamp(70px, 6vw, 96px);
            isolation: isolate;
        }

        .award-hero::before {
            content: "";
            position: absolute;
            inset: 78px clamp(10px, 1.8vw, 28px) 36px;
            z-index: -3;
            border-radius: clamp(30px, 3vw, 52px);
            background:
                radial-gradient(circle at 50% 2%, color-mix(in srgb, var(--award-primary) 28%, transparent), transparent 30%),
                linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02) 48%, rgba(255,255,255,.07)),
                linear-gradient(180deg, rgba(12,13,24,.98), rgba(22,22,36,.96) 58%, rgba(7,8,13,.98));
            border: 1px solid color-mix(in srgb, var(--award-primary) 22%, rgba(255,255,255,.10));
            box-shadow: inset 0 1px 0 rgba(255,255,255,.12), 0 38px 96px rgba(0,0,0,.42);
        }

        .award-spotlight,
        .award-orb,
        .award-spark {
            position: absolute;
            pointer-events: none;
        }

        .award-spotlight {
            top: 72px;
            bottom: 28px;
            width: 34%;
            opacity: .42;
            z-index: -2;
            filter: blur(.2px);
        }

        .award-spotlight.left {
            left: 6%;
            background: linear-gradient(102deg, transparent 0%, color-mix(in srgb, var(--award-primary) 22%, transparent) 44%, transparent 68%);
            clip-path: polygon(42% 0, 70% 0, 100% 100%, 0 100%);
        }

        .award-spotlight.right {
            right: 6%;
            background: linear-gradient(258deg, transparent 0%, color-mix(in srgb, var(--award-secondary) 20%, transparent) 46%, transparent 68%);
            clip-path: polygon(30% 0, 58% 0, 100% 100%, 0 100%);
        }

        .award-orb {
            border-radius: 999px;
            filter: blur(1px);
            z-index: -1;
            opacity: .62;
            animation: awardFloat 7s ease-in-out infinite;
        }

        .award-orb.one { width: 260px; height: 260px; left: 2%; top: 14%; background: color-mix(in srgb, var(--award-primary) 16%, transparent); }
        .award-orb.two { width: 320px; height: 320px; right: 3%; top: 12%; background: color-mix(in srgb, var(--award-secondary) 15%, transparent); animation-delay: -1.5s; }
        .award-orb.three { width: 150px; height: 150px; left: 49%; bottom: 9%; background: color-mix(in srgb, var(--award-accent) 45%, transparent); animation-delay: -3s; }

        .award-spark {
            color: var(--award-primary);
            opacity: .7;
            z-index: 1;
            font-size: 18px;
            animation: awardPulse 3s ease-in-out infinite;
        }

        .award-spark.s1 { left: 9%; top: 29%; }
        .award-spark.s2 { right: 12%; top: 34%; animation-delay: -.7s; }
        .award-spark.s3 { left: 55%; bottom: 17%; animation-delay: -1.4s; }

        .award-hero-layout {
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 220px);
            display: grid;
            grid-template-columns: minmax(180px, 240px) minmax(0, 1fr) minmax(350px, 500px);
            gap: clamp(24px, 3vw, 48px);
            align-items: center;
        }

        .award-rail {
            position: relative;
            align-self: stretch;
            display: grid;
            align-content: center;
            gap: 14px;
        }

        .award-rail::before {
            content: "";
            position: absolute;
            top: 8%;
            bottom: 8%;
            left: 24px;
            width: 1px;
            background: linear-gradient(180deg, transparent, color-mix(in srgb, var(--award-primary) 40%, transparent), transparent);
        }

        .award-rail-card {
            position: relative;
            overflow: hidden;
            min-height: 130px;
            padding: 20px 18px 20px 54px;
            border-radius: 30px;
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--award-primary) 20%, rgba(255,255,255,.10));
            box-shadow: 0 18px 42px rgba(0,0,0,.22);
            backdrop-filter: blur(14px);
        }

        .award-rail-card::before {
            content: "";
            position: absolute;
            left: 17px;
            top: 24px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 0 0 7px color-mix(in srgb, var(--award-primary) 10%, transparent);
        }

        .award-rail-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            width: 88px;
            height: 88px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--award-primary) 20%, transparent);
        }

        .award-rail-card small,
        .award-rail-card strong,
        .award-rail-card span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .award-rail-card small {
            color: var(--award-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
        }

        .award-rail-card strong {
            margin-top: 8px;
            color: var(--award-cream);
            font-size: 1.04rem;
            line-height: 1.35;
            font-weight: 950;
        }

        .award-rail-card span {
            margin-top: 6px;
            color: rgba(255,255,255,.68);
            font-size: 13px;
            line-height: 1.5;
            font-weight: 800;
        }

        .award-copy { min-width: 0; }

        .award-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--award-primary) 24%, rgba(255,255,255,.12));
            color: var(--award-primary);
            box-shadow: 0 14px 34px rgba(0,0,0,.20);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(14px);
        }

        .award-kicker::before {
            content: "✦";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 0 22px color-mix(in srgb, var(--award-primary) 36%, transparent);
        }

        .award-hero-title {
            margin-top: 24px;
            max-width: 780px;
            font-size: clamp(3rem, 6.4vw, 7rem);
            line-height: .87;
            letter-spacing: -.08em;
            color: var(--award-cream);
            font-weight: 950;
        }

        .award-hero-title span {
            background: linear-gradient(135deg, #ffffff, var(--award-primary), var(--award-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .award-hero-desc {
            max-width: 710px;
            margin-top: 24px;
            color: rgba(255,255,255,.72);
            font-size: 1.05rem;
            line-height: 1.92;
        }

        .award-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .award-glam-tags {
            width: min(100%, 780px);
            margin-top: 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .award-glam-tags span {
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

        .award-glam-tags span::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 0 14px color-mix(in srgb, var(--award-primary) 36%, transparent);
        }

        .award-stage {
            position: relative;
            min-height: 660px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .award-stage-card {
            position: relative;
            width: min(100%, 500px);
            min-height: 640px;
            overflow: hidden;
            border-radius: 260px 260px 42px 42px;
            background:
                radial-gradient(circle at 50% 10%, color-mix(in srgb, var(--award-primary) 28%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.05));
            border: 1px solid color-mix(in srgb, var(--award-primary) 26%, rgba(255,255,255,.10));
            box-shadow:
                0 36px 96px rgba(0,0,0,.34),
                inset 0 1px 0 rgba(255,255,255,.16);
            backdrop-filter: blur(18px);
        }

        .award-stage-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 240px 240px 30px 30px;
            border: 1px dashed color-mix(in srgb, var(--award-primary) 34%, transparent);
            pointer-events: none;
            z-index: 7;
        }

        .award-preview-image {
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

        .award-preview-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            filter: saturate(1.03) contrast(1.04);
        }

        .award-preview-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 30px;
        }

        .award-monogram {
            width: 150px;
            height: 150px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: #111827;
            font-size: 3rem;
            font-weight: 950;
            letter-spacing: -.08em;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 30px 64px color-mix(in srgb, var(--award-primary) 28%, transparent);
        }

        .award-badge-top {
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
            color: var(--award-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .award-badge-top::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
        }

        .award-ceremony-card {
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

        .award-ceremony-card small,
        .award-ceremony-card strong,
        .award-ceremony-card span { display: block; }

        .award-ceremony-card small {
            color: var(--award-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .award-ceremony-card strong {
            margin-top: 9px;
            color: #111827;
            font-size: clamp(1.55rem, 2.8vw, 2.45rem);
            line-height: 1.02;
            letter-spacing: -.045em;
            font-weight: 950;
        }

        .award-ceremony-card span {
            margin-top: 8px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.45;
            font-weight: 800;
        }

        .award-seal {
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
                linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            box-shadow: 0 26px 58px color-mix(in srgb, var(--award-primary) 32%, transparent);
            animation: awardFloat 5.4s ease-in-out infinite;
        }

        .award-seal strong {
            display: block;
            font-size: 1.5rem;
            line-height: .95;
            font-weight: 950;
        }

        .award-seal span {
            display: block;
            margin-top: 5px;
            font-size: 9px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .9;
        }

        .award-host-card {
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
            animation: awardFloat 5.8s ease-in-out -.8s infinite;
        }

        .award-host-card small,
        .award-host-card strong,
        .award-host-card span { display: block; }

        .award-host-card small {
            color: var(--award-dark);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .award-host-card strong {
            margin-top: 7px;
            color: #111827;
            line-height: 1.35;
            font-weight: 950;
        }

        .award-host-card span {
            margin-top: 5px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
        }

        /* Shared cards */
        .award-card,
        .person-card,
        .highlight-card,
        .gift-card,
        .form-card,
        .message-card,
        .summary-card,
        .closing-card {
            background: rgba(255,255,255,.08);
            border: 1px solid color-mix(in srgb, var(--award-primary) 20%, rgba(255,255,255,.10));
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
        .award-card::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -58px;
            bottom: -58px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--award-primary) 20%, transparent);
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
            color: var(--award-primary);
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
            background: color-mix(in srgb, var(--award-primary) 12%, transparent);
            color: var(--award-primary);
            font-size: 12px;
            font-weight: 950;
        }

        .person-card h3,
        .person-card p { position: relative; z-index: 2; }
        .person-card h3 { margin-top: 16px; color: var(--award-cream); font-size: 1.7rem; line-height: 1.12; font-weight: 950; }
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
            background: linear-gradient(135deg, var(--award-primary), var(--award-secondary));
            margin-bottom: 22px;
        }

        .highlight-card h3,
        .highlight-card p { position: relative; z-index: 2; }
        .highlight-card h3 { color: var(--award-cream); font-size: 1.42rem; font-weight: 950; }
        .highlight-card p { color: rgba(255,255,255,.66); margin-top: 10px; line-height: 1.8; }

        .detail-layout {
            display: grid;
            grid-template-columns: .96fr 1.04fr;
            gap: 24px;
            margin-top: 42px;
            align-items: start;
        }

        .award-card {
            position: relative;
            overflow: hidden;
            border-radius: 38px;
            padding: 32px;
        }

        .award-card h3 { position: relative; z-index: 2; margin: 0; color: var(--award-cream); font-size: 2rem; font-weight: 950; }
        .detail-list { position: relative; z-index: 2; display: grid; gap: 14px; margin-top: 24px; }
        .detail-row { display: grid; grid-template-columns: 112px 1fr; gap: 16px; padding: 16px 0; border-top: 1px dashed rgba(255,255,255,.15); }
        .detail-row .label { color: var(--award-primary); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .detail-row .value { color: rgba(255,255,255,.86); font-weight: 900; line-height: 1.65; }

        .countdown-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .countdown-card { padding: 22px 14px; text-align: center; border-radius: 26px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); }
        .countdown-number { display: block; color: var(--award-primary); font-size: 34px; line-height: 1; font-weight: 950; animation: awardNumberGlow 2.4s ease-in-out infinite alternate; }
        .countdown-label { display: block; margin-top: 10px; color: rgba(255,255,255,.62); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }

        .map-card { margin-top: 22px; overflow: hidden; border-radius: 32px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); box-shadow: 0 18px 40px rgba(0,0,0,.20); }
        .map-frame,
        .map-placeholder { width: 100%; height: 310px; display: block; border: 0; }
        .map-placeholder { display: flex; align-items: center; justify-content: center; padding: 32px; text-align: center; text-decoration: none; color: var(--award-cream); background: rgba(255,255,255,.06); }

        .gallery-award { display: grid; grid-template-columns: 1.1fr .9fr 1fr; gap: 18px; margin-top: 38px; align-items: stretch; }
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
        .gift-card h3 { color: var(--award-cream); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); }
        .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 950; color: var(--award-primary); }
        .gift-number { display: block; margin-top: 6px; color: var(--award-cream); font-size: 1.1rem; font-weight: 950; }
        .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: #111827; font-size: 12px; font-weight: 950; background: linear-gradient(135deg, var(--award-primary), var(--award-secondary)); }
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
        .summary-card strong { display: block; color: var(--award-primary); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: rgba(255,255,255,.64); font-size: 12px; font-weight: 950; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-info .font-black { color: var(--award-cream) !important; }
        .message-card p { color: rgba(255,255,255,.66); }
        .message-badge { padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--award-primary) 16%, transparent); color: var(--award-primary); font-size: 12px; font-weight: 950; white-space: nowrap; }

        .closing-card {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            border-radius: 44px;
            padding: 54px 36px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--award-primary) 14%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--award-secondary) 14%, transparent), transparent 36%),
                rgba(255,255,255,.08);
        }

        .closing-card h2 { color: var(--award-cream); }
        .closing-card p { color: rgba(255,255,255,.68); }
        .closing-card h3 { color: var(--award-primary); }

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
            .award-card:hover,
            .award-rail-card:hover,
            .person-card:hover,
            .highlight-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover,
            .award-stage-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--award-primary) 42%, transparent) !important;
                box-shadow:
                    0 34px 88px rgba(0,0,0,.28),
                    0 0 48px color-mix(in srgb, var(--award-primary) 16%, transparent) !important;
            }

            .gallery-card:hover img,
            .person-card:hover img,
            .award-preview-image:hover img { transform: scale(1.055); filter: saturate(1.08) contrast(1.06); }
        }

        .gallery-card img,
        .person-photo,
        .award-preview-image img { transition: transform .75s ease, filter .75s ease; }

        @keyframes awardGridMove { from { background-position: 0 0, 0 0; } to { background-position: 192px 192px, 192px 192px; } }
        @keyframes awardFloat { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.04); } }
        @keyframes awardFloatButton { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes awardPulse { 0%,100% { transform: scale(1); opacity: .55; } 50% { transform: scale(1.24); opacity: .95; } }
        @keyframes awardShine { 0%,48% { left: -80%; } 75%,100% { left: 130%; } }
        @keyframes awardNumberGlow {
            from { text-shadow: 0 0 8px color-mix(in srgb, var(--award-primary) 25%, transparent); }
            to { text-shadow: 0 0 18px color-mix(in srgb, var(--award-primary) 55%, transparent), 0 0 34px color-mix(in srgb, var(--award-secondary) 24%, transparent); }
        }

        @media (max-width: 1180px) {
            .award-hero-layout {
                grid-template-columns: 1fr;
                min-height: auto;
                justify-items: center;
                text-align: center;
            }
            .award-copy { width: min(100%, 920px); order: 1; }
            .award-rail { width: min(100%, 920px); grid-template-columns: repeat(3, minmax(0, 1fr)); align-self: auto; order: 2; }
            .award-rail::before { display: none; }
            .award-stage { width: min(100%, 720px); min-height: auto; order: 3; }
            .award-kicker,
            .award-actions,
            .award-glam-tags { justify-content: center; margin-left: auto; margin-right: auto; }
            .award-hero-title,
            .award-hero-desc { margin-left: auto; margin-right: auto; text-align: center; }
            .award-stage-card { min-height: 590px; }
            .award-host-card,
            .award-seal { position: relative; left: auto; right: auto; top: auto; bottom: auto; width: 100%; height: auto; margin-top: 14px; border-radius: 26px; animation: none; }
            .award-seal { min-height: 96px; }
            .detail-layout,
            .gift-grid { grid-template-columns: 1fr; }
            .highlight-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
            .gallery-award { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .award-shell { padding: 0; }
            .award-wrap { border-radius: 0; box-shadow: none; }
            .award-nav { top: 10px; margin: 12px auto -28px; padding: 7px 10px; }
            .award-nav a { padding: 10px 14px; font-size: 11px; }
            .award-hero { padding: 98px 16px 68px; }
            .award-hero::before { inset: 72px 8px 28px; border-radius: 30px; }
            .award-hero-title { width: 100%; max-width: 390px; font-size: clamp(2.45rem, 12vw, 3.75rem); line-height: 1; letter-spacing: -.055em; }
            .award-hero-desc { width: min(100%, 390px); font-size: .98rem; line-height: 1.82; }
            .award-kicker { max-width: 100%; white-space: normal; line-height: 1.45; justify-content: center; text-align: center; }
            .award-actions { width: min(100%, 390px); display: grid; grid-template-columns: 1fr; }
            .award-actions .award-btn { width: 100%; }
            .award-glam-tags { width: min(100%, 390px); }
            .award-glam-tags span { flex: 1 1 100%; justify-content: center; }
            .award-rail { width: min(100%, 390px); grid-template-columns: 1fr; }
            .award-rail-card { min-height: auto; text-align: left; }
            .award-stage { width: 100%; }
            .award-stage-card { width: min(100%, 390px); min-height: 510px; border-radius: 220px 220px 32px 32px; }
            .award-stage-card::before { inset: 10px; border-radius: 200px 200px 24px 24px; }
            .award-stage-card::after { display: none; }
            .award-preview-image { inset: 56px 28px 150px 28px; border-radius: 190px 190px 24px 24px; }
            .award-badge-top { top: 20px; right: 24px; font-size: 9px; }
            .award-ceremony-card { left: 24px; right: 24px; bottom: 24px; padding: 18px; border-radius: 24px; text-align: center; }
            .award-ceremony-card strong { font-size: 1.5rem; }
            .award-section { padding: 70px 20px; }
            .award-section.compact { padding-top: 64px; padding-bottom: 64px; }
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

    $eventTitle = $invitation->title ?: 'Prestige Award Night';
    $eventName = $invitation->event_name ?: 'Corporate Gala Award Night';
    $hostName = $invitation->host_name ?: 'Corporate Excellence Committee';
    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Award Night Agenda';

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
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Gala Room' : 'Gala Ballroom');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang award night atau siaran acara.'
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

            $calendarTitle = trim(($invitation->event_name ?: 'Corporate Award Night') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan corporate award night') . "\n\nLink Undangan: " . $shareUrl);
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

    $awardHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $awardHighlights->count();
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
        --award-primary: {{ $activeTheme['primary'] }};
        --award-secondary: {{ $activeTheme['secondary'] }};
        --award-accent: {{ $activeTheme['accent'] }};
        --award-dark: {{ $activeTheme['dark'] }};
        --award-cream: {{ $activeTheme['cream'] }};
        --award-text: {{ $activeTheme['text'] }};
    "
>
    <main class="award-shell">
        <div class="award-wrap">
            <nav class="award-nav" aria-label="Navigasi undangan">
                <a href="#people">Honoree</a>
                <a href="#about">Runway</a>
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
            <section id="opening" class="award-hero">
                <span class="award-spotlight left"></span>
                <span class="award-spotlight right"></span>
                <span class="award-orb one"></span>
                <span class="award-orb two"></span>
                <span class="award-orb three"></span>
                <span class="award-spark s1">✦</span>
                <span class="award-spark s2">✧</span>
                <span class="award-spark s3">✦</span>

                <div class="award-hero-layout">
                    <aside class="award-rail" data-reveal="right" style="--reveal-delay:.10s">
                        <div class="award-rail-card">
                            <small>Date</small>
                            <strong class="responsive-text">{{ $eventDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="award-rail-card">
                            <small>{{ $isOnlineEvent ? 'Mode' : 'Venue' }}</small>
                            <strong class="responsive-text">{{ $isOnlineEvent ? 'Online Gala' : 'Gala Night' }}</strong>
                            <span class="responsive-text">{{ $isOnlineEvent ? 'Join Online' : ($accessName ?: 'Venue award night') }}</span>
                        </div>

                        <div class="award-rail-card">
                            <small>Host</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span class="responsive-text">{{ $eventName }}</span>
                        </div>
                    </aside>

                    <div class="award-copy">
                        <p class="award-kicker" data-reveal="zoom" style="--reveal-delay:.04s">
                            Gala • Award • Fashion Show Atmosphere
                        </p>

                        <h1 class="award-hero-title responsive-text" data-reveal="zoom" style="--reveal-delay:.10s">
                            <span>{{ $eventTitle }}</span>
                        </h1>

                        <p class="award-hero-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.18s">
                            {{ $invitation->description ?: 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri malam penghargaan corporate yang dirancang dengan suasana gala, red carpet, apresiasi prestasi, dan momen networking yang elegan.' }}
                        </p>

                        <div class="award-actions" data-reveal="zoom" style="--reveal-delay:.26s">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="award-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="award-btn">Lihat Detail</a>
                            @endif

                            <a href="#about" class="award-btn secondary">Award Agenda</a>
                            <a href="#message" class="award-btn secondary">Konfirmasi Kehadiran</a>
                        </div>
                    </div>

                    <div class="award-stage" data-reveal="left" style="--reveal-delay:.14s">
                        <div class="award-stage-card">
                            <div class="award-badge-top">Gala Preview</div>

                            <div class="award-preview-image">
                                @if ($invitation->cover_image)
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Award Night">
                                @elseif ($firstPhoto)
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Award Night">
                                @else
                                    <div class="award-preview-fallback">
                                        <div class="award-monogram">AN</div>
                                    </div>
                                @endif
                            </div>

                            <div class="award-ceremony-card">
                                <small>Award Ceremony</small>
                                <strong class="responsive-text">{{ $eventName }}</strong>
                                <span class="responsive-text">{{ $agendaSectionTitle }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PEOPLE / HONOREE --}}
            <section id="people" class="award-section compact text-center">
                <p class="award-label" data-reveal="zoom">Honoree & Committee</p>
                <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Tamu Kehormatan</h2>
                <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                    Bagian ini menampilkan penerima penghargaan, host, perwakilan perusahaan, juri, atau tokoh utama dalam award night.
                </p>

                <div class="people-grid {{ $people->count() <= 1 ? 'single-person' : '' }}">
                    @forelse ($people as $index => $person)
                        <div class="person-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="person-photo">
                            @else
                                <div class="person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'A', 0, 1)) }}</div>
                            @endif

                            <span class="person-role">{{ $person->subtitle ?: 'Award Night Representative' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Perwakilan' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="person-card" data-reveal="zoom">
                            <div class="person-placeholder">A</div>
                            <span class="person-role">Award Night Representative</span>
                            <h3 class="responsive-text">Nama Perwakilan</h3>
                            <p>Data penerima penghargaan atau perwakilan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- HIGHLIGHTS / AWARD AGENDA --}}
            @if ($highlightCount > 0)
                <section id="about" class="award-section compact">
                    <div class="section-head">
                        <p class="award-label" data-reveal="zoom">Runway Agenda</p>
                        <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $agendaSectionTitle }}</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                            Rangkaian acara utama, sesi penghargaan, gala dinner, red carpet, entertainment, atau highlight corporate award night.
                        </p>
                    </div>

                    <div class="highlight-grid {{ $highlightGridClass }}">
                        @foreach ($awardHighlights as $index => $highlight)
                            <div class="highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <div class="highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <h3 class="responsive-text">{{ $highlight['title'] ?? 'Award Highlight' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi highlight award night.' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="award-section compact">
                <div class="section-head">
                    <p class="award-label" data-reveal="zoom">Event Access</p>
                    <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Detail Acara</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">
                        Informasi waktu, akses acara, dan lokasi/platform award night.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="award-card" data-reveal="left">
                        <h3>Informasi Gala</h3>

                        <div class="detail-list">
                            <div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $eventName }}</div></div>
                            <div class="detail-row"><div class="label">Mode</div><div class="value responsive-text">{{ $isOnlineEvent ? 'Online Award Night' : 'Offline Gala Night' }}</div></div>
                            <div class="detail-row"><div class="label">Tanggal</div><div class="value responsive-text">{{ $eventDateText }}</div></div>
                            <div class="detail-row"><div class="label">Waktu</div><div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div></div>
                            <div class="detail-row"><div class="label">{{ $accessTypeLabel }}</div><div class="value responsive-text">{{ $accessName }}</div></div>
                            <div class="detail-row"><div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div><div class="value responsive-text">{{ $accessDescription }}</div></div>
                        </div>

                        <div class="award-actions mt-6">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="award-btn">📅 Add Calendar</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="award-btn secondary">{{ $accessActionIcon }} {{ $accessActionText }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="award-card" data-reveal="right">
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
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--award-primary);">Join Online →</p>
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
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--award-primary);">Buka Google Maps →</p>
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
                <section id="gallery" class="award-section compact">
                    <div class="section-head">
                        <p class="award-label" data-reveal="zoom">Gala Gallery</p>
                        <h2 class="section-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Galeri Award Night</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Dokumentasi visual, nominasi, brand, panggung, atau suasana gala.</p>
                    </div>

                    <div class="gallery-award">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Award Night">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Award Night">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-column">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Award Night">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- SUPPORT / GIFT --}}
            @if ($giftCount)
                <section id="gift" class="award-section compact">
                    <div class="section-head">
                        <p class="award-label" data-reveal="zoom">Support</p>
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
            <section id="message" class="award-section compact">
                <div class="section-head">
                    <p class="award-label" data-reveal="zoom">RSVP & Wishes</p>
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

                        <button type="submit" class="w-full award-btn">Kirim Ucapan</button>
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
            <section id="closing" class="award-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="award-label">Standing Ovation</p>
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
