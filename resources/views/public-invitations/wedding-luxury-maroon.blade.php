<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Luxury Maroon'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }
        :root { color-scheme: light; }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--lm-cream);
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--lm-gold) 18%, transparent), transparent 30%),
                radial-gradient(circle at 86% 10%, color-mix(in srgb, var(--lm-maroon) 38%, transparent), transparent 30%),
                linear-gradient(180deg, #240015 0%, #5a082c 42%, #240015 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }
        img, a, button { -webkit-user-drag: none; user-drag: none; }
        input, textarea, select { -webkit-user-select: text; user-select: text; }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .lm-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 26px;
        }

        .lm-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 38px;
            background:
                linear-gradient(180deg, rgba(72, 5, 37, .72), rgba(102, 14, 49, .78)),
                url("{{ asset('assets/luxury-maroon/lux-maroon-paper-texture.png') }}") center/cover repeat,
                linear-gradient(180deg, var(--lm-deep), var(--lm-maroon) 46%, var(--lm-deep));
            border: 1px solid color-mix(in srgb, var(--lm-gold) 26%, transparent);
            box-shadow: 0 40px 130px rgba(22, 0, 14, .42);
        }

        .lm-book::before,
        .lm-book::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .lm-book::before {
            opacity: .70;
            background:
                url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold.png') }}") left top/330px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold-mirror.png') }}") right top/330px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palace-left.png') }}") left 18%/420px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palace-right.png') }}") right 18%/420px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat,
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, rgba(255,255,255,.020) 1px, transparent 1px) 0 0/42px 42px;
        }
        .lm-book::after {
            opacity: .30;
            background:
                radial-gradient(circle at 50% 10%, rgba(235,199,109,.20), transparent 26%),
                radial-gradient(circle at 16% 36%, rgba(255,255,255,.11), transparent 24%),
                radial-gradient(circle at 84% 64%, rgba(235,199,109,.14), transparent 26%);
        }
        .lm-book > * { position: relative; z-index: 2; }

        .lm-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255, 246, 226, .82);
            border: 1px solid color-mix(in srgb, var(--lm-gold) 32%, transparent);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(22, 0, 14, .24);
            backdrop-filter: blur(14px);
        }
        .lm-floating-actions a,
        .lm-floating-actions button {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 16px 0 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            background: rgba(255,255,255,.96);
            box-shadow: 0 10px 22px rgba(22,0,14,.16);
            transition: transform .25s ease, background .25s ease;
        }
        .lm-floating-actions a:hover,
        .lm-floating-actions button:hover { transform: translateX(-3px); }
        .lm-floating-actions button.is-active { background: color-mix(in srgb, var(--lm-gold) 38%, white); }
        .lm-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .lm-page {
            position: relative;
            min-height: auto;
            padding: 108px 76px;
            overflow: hidden;
            text-align: center;
        }
        .lm-page.slim { padding-top: 90px; padding-bottom: 90px; }
        .lm-page > * { position: relative; z-index: 5; }
        .lm-page::before,
        .lm-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .lm-page::before {
            z-index: 1;
            opacity: .38;
            background:
                url("{{ asset('assets/luxury-maroon/lux-floral-top-gold.png') }}") center top/82% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .lm-page::after {
            z-index: 2;
            opacity: .34;
            background: radial-gradient(circle at 50% 36%, rgba(255,255,255,.12), transparent 52%);
        }

        .lm-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--lm-cream);
            background: rgba(58, 4, 31, .72);
            border: 1px solid color-mix(in srgb, var(--lm-gold) 42%, transparent);
            box-shadow: 0 16px 34px rgba(22,0,14,.22);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(10px);
        }
        .lm-label::before,
        .lm-label::after { content: ""; width: 28px; height: 1px; background: var(--lm-gold); opacity: .86; }

        .lm-title {
            margin: 0;
            color: var(--lm-cream);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.045em;
            line-height: .94;
            text-wrap: balance;
        }
        .lm-script { font-family: Georgia, "Times New Roman", serif; font-style: italic; font-weight: 400; }
        .lm-gold-text { color: var(--lm-gold); }
        .lm-note { max-width: 720px; margin: 20px auto 0; color: rgba(255,246,226,.84); line-height: 1.9; }

        .lm-btn {
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
            color: #3a071f;
            background: linear-gradient(135deg, var(--lm-gold-dark), var(--lm-gold), #fff2b8);
            box-shadow: 0 18px 38px rgba(235,199,109,.20);
            font-weight: 950;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .lm-btn:hover { transform: translateY(-2px); }
        .lm-btn.light { color: var(--lm-cream); background: rgba(255,255,255,.10); border: 1px solid color-mix(in srgb, var(--lm-gold) 42%, transparent); }
        .lm-btn::after,
        .lm-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: lmShine 4.2s ease-in-out infinite;
        }

        /* HERO */
        .lm-hero {
            min-height: 930px;
            padding: 84px 76px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(43,0,24,.28), rgba(84,6,43,.24) 42%, rgba(43,0,24,.34)),
                radial-gradient(circle at 50% 42%, rgba(255,255,255,.15), transparent 42%);
        }
        .lm-hero::before {
            opacity: .96;
            background:
                url("{{ asset('assets/luxury-maroon/lux-moon.png') }}") center 48px/220px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-arch-maroon-gold.png') }}") center 95px/690px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palace-gate-soft.png') }}") center bottom/118% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palm-left.png') }}") left bottom/390px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palm-right.png') }}") right bottom/390px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold.png') }}") left top/330px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold-mirror.png') }}") right top/330px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .lm-hero::after {
            opacity: .74;
            background:
                linear-gradient(180deg, rgba(58,0,34,.10), rgba(58,0,34,.24)),
                url("{{ asset('assets/luxury-maroon/lux-haze-gold.png') }}") center/cover no-repeat;
        }
        .lm-hero-inner {
            width: min(100%, 590px);
            margin: 0 auto;
            padding: 185px 22px 255px;
        }
        .lm-hero-kicker { color: var(--lm-cream); font-size: 12px; font-weight: 950; letter-spacing: .18em; text-transform: uppercase; }
        .lm-hero-photo-wrap {
            width: min(100%, 360px);
            margin: 32px auto 26px;
            padding: 8px;
            border-radius: 999px 999px 14px 14px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--lm-gold) 78%, white), var(--lm-gold-dark));
            box-shadow: 0 26px 72px rgba(22,0,14,.36);
        }
        .lm-hero-photo,
        .lm-hero-photo-fallback {
            width: 100%;
            aspect-ratio: 4/5;
            display: grid;
            place-items: center;
            object-fit: cover;
            object-position: center;
            border-radius: 999px 999px 10px 10px;
            background: #2d2026;
            color: var(--lm-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }
        .lm-hero-title {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            font-size: clamp(2.6rem, 6vw, 4.4rem);
            color: var(--lm-cream);
            letter-spacing: .03em;
            line-height: .92;
            text-transform: uppercase;
        }
        .lm-hero-name { display: block; line-height: .92; }
        .lm-hero-and { color: var(--lm-gold); font-size: clamp(1.5rem, 3vw, 2.1rem); line-height: .8; }
        .lm-hero-date { margin-top: 24px; color: var(--lm-cream); font-size: .96rem; letter-spacing: .18em; font-weight: 850; }
        .lm-hero-actions { margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Couple */
        .lm-couple {
            background: linear-gradient(180deg, rgba(92, 9, 45, .86), rgba(73, 5, 38, .90));
        }
        .lm-couple::before {
            opacity: .55;
            background:
                url("{{ asset('assets/luxury-maroon/lux-floral-top-gold.png') }}") center top/88% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .lm-couple-intro { width: min(100%, 780px); margin: 0 auto 42px; }
        .lm-couple-intro h2 { font-size: clamp(3rem, 6vw, 6.2rem); }
        .lm-couple-stage {
            width: min(100%, 920px);
            margin: 0 auto;
            display: grid;
            gap: 36px;
        }
        .lm-person-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 620px);
            margin: 0 auto;
            padding: 34px 34px 30px;
            border-radius: 999px 999px 42px 42px;
            background: linear-gradient(180deg, rgba(255,246,226,.96), rgba(255,255,255,.82));
            border: 2px solid color-mix(in srgb, var(--lm-gold) 72%, transparent);
            box-shadow: 0 32px 92px rgba(22,0,14,.26);
            color: var(--lm-deep);
        }
        .lm-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .34;
            background:
                url("{{ asset('assets/luxury-maroon/lux-arch-outline-gold.png') }}") center top/82% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-side.png') }}") left bottom/42% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-side-mirror.png') }}") right bottom/42% auto no-repeat;
            pointer-events: none;
        }
        .lm-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: min(100%, 360px);
            margin: 0 auto;
            padding: 8px;
            border-radius: 999px 999px 16px 16px;
            background: var(--lm-gold);
        }
        .lm-person-photo-wrap img,
        .lm-person-initial {
            width: 100%;
            aspect-ratio: 4/5.15;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 10px 10px;
            background: #2d2026;
            color: var(--lm-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
        }
        .lm-person-content { position: relative; z-index: 2; margin-top: 26px; }
        .lm-person-name { color: var(--lm-maroon); font-family: Georgia,"Times New Roman",serif; font-size: clamp(2.2rem, 4.6vw, 4rem); line-height: .96; }
        .lm-person-subtitle { margin-top: 12px; color: var(--lm-gold-dark); font-weight: 950; }
        .lm-person-family { max-width: 440px; margin: 12px auto 0; color: #6b4f56; line-height: 1.78; }
        .lm-instagram {
            display: inline-flex;
            margin-top: 18px;
            padding: 10px 18px;
            border-radius: 999px;
            background: var(--lm-maroon);
            color: #fff;
            text-decoration: none;
            font-weight: 900;
            border: 1px solid color-mix(in srgb, var(--lm-gold) 42%, transparent);
        }

        /* Invitation */
        .lm-invitation-card {
            width: min(100%, 850px);
            margin: 0 auto;
            padding: 54px 48px;
            border-radius: 44px;
            background: rgba(62, 3, 34, .78);
            border: 1px solid color-mix(in srgb, var(--lm-gold) 36%, transparent);
            box-shadow: 0 28px 84px rgba(22,0,14,.22);
            backdrop-filter: blur(8px);
        }
        .lm-invitation-card h2 { font-size: clamp(3rem, 6vw, 6.4rem); }

        /* Event */
        .lm-event-section {
            min-height: 820px;
            background:
                linear-gradient(180deg, rgba(52,0,30,.72), rgba(103,15,49,.70)),
                url("{{ asset('assets/luxury-maroon/lux-event-photo-overlay.png') }}") center/cover no-repeat;
        }
        .lm-event-section::before {
            opacity: .62;
            background:
                url("{{ asset('assets/luxury-maroon/lux-floral-top-gold.png') }}") center top/84% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .lm-event-layout {
            width: min(100%, 920px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: minmax(0, 660px);
            justify-content: center;
        }
        .lm-event-card {
            position: relative;
            overflow: hidden;
            padding: 58px 44px;
            border-radius: 999px 999px 44px 44px;
            background: linear-gradient(180deg, rgba(255,246,226,.96), rgba(255,255,255,.88));
            border: 8px solid color-mix(in srgb, var(--lm-maroon) 80%, black);
            outline: 2px solid color-mix(in srgb, var(--lm-gold) 78%, transparent);
            box-shadow: 0 32px 90px rgba(22,0,14,.30);
            color: var(--lm-deep);
        }
        .lm-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .20;
            background:
                url("{{ asset('assets/luxury-maroon/lux-wayang-icon.png') }}") center 38px/100px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palace-gate-soft.png') }}") center bottom/100% auto no-repeat;
            pointer-events: none;
        }
        .lm-event-card > * { position: relative; z-index: 2; }
        .lm-event-icon { width: 86px; height: 86px; margin: 0 auto 18px; background: url("{{ asset('assets/luxury-maroon/lux-wayang-icon.png') }}") center/contain no-repeat; }
        .lm-event-card h3 { color: var(--lm-maroon); font-size: clamp(2.8rem, 5vw, 4.8rem); }
        .lm-event-countdown {
            width: min(100%, 440px);
            margin: 24px auto 20px;
            padding: 16px 18px;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.72), rgba(255,246,226,.52));
            border: 1px solid color-mix(in srgb, var(--lm-gold) 42%, transparent);
            box-shadow: 0 14px 34px rgba(22,0,14,.10);
        }

        .lm-event-countdown-head {
            margin-bottom: 12px;
            color: var(--lm-maroon);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .lm-event-countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .lm-event-countdown-box {
            padding: 10px 6px;
            border-radius: 18px;
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(92, 13, 53, .08);
        }

        .lm-event-countdown-box b {
            display: block;
            color: var(--lm-maroon);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(1.35rem, 3vw, 2rem);
            line-height: 1;
        }

        .lm-event-countdown-box span {
            display: block;
            margin-top: 6px;
            color: #6d4a38;
            font-size: 9px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .lm-event-info {
            width: min(100%, 460px);
            margin: 20px auto 0;
            display: grid;
            gap: 12px;
        }

        .lm-event-info-item {
            padding: 14px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,.62);
            border: 1px solid color-mix(in srgb, var(--lm-gold) 34%, transparent);
        }

        .lm-event-info-label {
            display: block;
            margin-bottom: 5px;
            color: var(--lm-maroon);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .lm-event-date,
        .lm-event-time {
            margin: 0;
            color: #241817;
            font-weight: 950;
            letter-spacing: .09em;
            text-transform: uppercase;
            line-height: 1.65;
        }

        .lm-event-time {
            letter-spacing: .08em;
        }
        .lm-map-pin { width: 64px; height: 64px; margin: 28px auto 18px; border-radius: 999px; display: grid; place-items: center; background: var(--lm-maroon); color: white; font-size: 2rem; }
        .lm-event-place { color: #4d353c; font-weight: 900; }
        .lm-event-address { margin-top: 10px; color: #5f5354; line-height: 1.7; }
        .lm-event-actions { margin-top: 28px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Story */
        .lm-story-section {
            text-align: left;
            background: linear-gradient(180deg, rgba(57,0,32,.84), rgba(78,7,42,.88));
        }
        .lm-story-wrap {
            width: min(100%, 920px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: 78px minmax(0,1fr);
            gap: 24px;
            align-items: stretch;
        }
        .lm-story-line { position: relative; width: 4px; margin: 0 auto; background: rgba(255,246,226,.86); border-radius: 999px; }
        .lm-story-line::before,
        .lm-story-line::after { content: ""; position: absolute; left: 50%; transform: translateX(-50%); width: 26px; height: 26px; border-radius: 999px; border: 4px solid rgba(255,246,226,.92); background: var(--lm-maroon); }
        .lm-story-line::before { top: 0; }
        .lm-story-line::after { bottom: 0; }
        .lm-story-card {
            background: #fff;
            color: var(--lm-deep);
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 28px 82px rgba(22,0,14,.30);
            border: 1px solid rgba(255,255,255,.4);
        }
        .lm-story-card img,
        .lm-story-fallback { width: 100%; height: 520px; object-fit: cover; display: grid; place-items: center; background: #2d2026; color: var(--lm-gold); font-family: Georgia,"Times New Roman",serif; font-size: 4rem; }
        .lm-story-content { padding: 38px 42px; }
        .lm-story-content h3 { color: var(--lm-maroon); font-size: clamp(2rem, 4vw, 3.2rem); }
        .lm-story-content p { color: #654e56; line-height: 1.9; }

        /* Gallery */
        .lm-gallery-grid {
            width: min(100%, 980px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-rows: 110px;
            gap: 12px;
        }
        .lm-gallery-item { display: block; overflow: hidden; padding: 6px; background: rgba(255,246,226,.90); border: 1px solid color-mix(in srgb, var(--lm-gold) 38%, transparent); box-shadow: 0 18px 46px rgba(22,0,14,.20); border-radius: 26px; }
        .lm-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; }
        .lm-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; }
        .lm-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; }
        .lm-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }
        .lm-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 20px; transition: transform .7s ease; }
        .lm-gallery-item:hover img { transform: scale(1.055); }

        /* Gift RSVP Closing */
        .lm-gift-grid { width: min(100%, 900px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .lm-gift-grid.is-single { grid-template-columns: minmax(0, 460px); justify-content: center; }
        .lm-gift-card { position: relative; overflow: hidden; min-height: 210px; padding: 32px 28px; border-radius: 34px; text-align: left; background: rgba(255,246,226,.94); color: var(--lm-deep); border: 1px solid color-mix(in srgb, var(--lm-gold) 42%, transparent); box-shadow: 0 18px 48px rgba(22,0,14,.20); }
        .lm-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: color-mix(in srgb, var(--lm-maroon) 22%, transparent); transform: skewY(-7deg); }
        .lm-gift-title,.lm-gift-number,.lm-copy-btn { position: relative; z-index: 2; }
        .lm-gift-title { color: var(--lm-maroon); font-weight: 950; font-size: 1.25rem; }
        .lm-gift-number { margin-top: 18px; color: #2f1721; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .lm-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #fff; background: var(--lm-maroon); font-weight: 950; cursor: pointer; }
        .lm-copy-btn.copied { background: #16803c; }

        .lm-rsvp-layout { width: min(100%, 1080px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .lm-rsvp-copy, .lm-form-card, .lm-message-card, .lm-summary-grid > div { background: rgba(255,246,226,.92); color: var(--lm-deep); border: 1px solid color-mix(in srgb, var(--lm-gold) 32%, transparent); box-shadow: 0 18px 48px rgba(22,0,14,.16); }
        .lm-rsvp-copy { padding: 42px 34px; border-radius: 40px; }
        .lm-rsvp-copy h3 { color: var(--lm-maroon); font-size: clamp(2.4rem, 4vw, 4.4rem); }
        .lm-form-card { padding: 26px; border-radius: 28px; text-align: left; }
        .lm-form-label { display: block; color: var(--lm-maroon); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .lm-input { width: 100%; margin-top: 8px; border: 1px solid rgba(82,8,43,.14); background: rgba(255,255,255,.94); color: var(--lm-deep); border-radius: 14px; padding: 13px 14px; outline: none; text-align: left; }
        .lm-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .lm-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; }
        .lm-summary-grid b { display: block; color: var(--lm-maroon); font-size: 2rem; line-height: 1; }
        .lm-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .lm-message-card { padding: 18px; border-radius: 22px; }

        .lm-closing {
            min-height: 880px;
            display: grid;
            place-items: center;
        }
        .lm-closing::before {
            opacity: .94;
            background:
                url("{{ asset('assets/luxury-maroon/lux-moon.png') }}") center 40px/210px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-arch-maroon-gold.png') }}") center 90px/710px auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-palace-gate-soft.png') }}") center bottom/118% auto no-repeat,
                url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .lm-closing-card { width: min(100%, 620px); margin: 0 auto; padding: 220px 34px 260px; text-align: center; }
        .lm-closing-photo { width: min(100%, 360px); aspect-ratio: 4/5; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px 999px 12px 12px; border: 6px solid var(--lm-gold); box-shadow: 0 20px 62px rgba(22,0,14,.38); }
        .lm-closing-card h2 { font-size: clamp(2rem, 5vw, 3.6rem); text-transform: uppercase; }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes lmShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes lmFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .lm-floating-actions a, .lm-floating-actions button { animation: lmFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1440px) {
            .lm-shell { width: min(100%, 1280px); }
            .lm-page { padding-left: 92px; padding-right: 92px; }
        }
        @media (max-width: 980px) {
            .lm-shell { padding: 14px; }
            .lm-page { padding: 90px 38px; }
            .lm-hero { min-height: 860px; padding: 76px 38px 0; }
            .lm-hero::before { background-size: 190px auto, 640px auto, 140% auto, 300px auto, 300px auto, 260px auto, 260px auto, 140% auto; }
            .lm-hero-inner { padding-top: 170px; padding-bottom: 240px; }
            .lm-rsvp-layout { grid-template-columns: 1fr; text-align: center; }
            .lm-gift-grid { grid-template-columns: 1fr; }
            .lm-gallery-grid { grid-template-columns: repeat(6, minmax(0, 1fr)); }
            .lm-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .lm-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .lm-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }
        @media (max-width: 640px) {
            .lm-shell { padding: 0; }
            .lm-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .lm-page, .lm-page.slim { padding: 78px 22px; }
            .lm-floating-actions { right: 0; gap: 7px; }
            .lm-floating-actions a, .lm-floating-actions button { width: 40px; height: 40px; }
            .lm-hero { min-height: 100svh; padding: 58px 22px 0; }
            .lm-hero::before {
                background:
                    url("{{ asset('assets/luxury-maroon/lux-moon.png') }}") center 36px/150px auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-arch-maroon-gold.png') }}") center 78px/128% auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-palace-gate-soft.png') }}") center bottom/170% auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-palm-left.png') }}") left bottom/72% auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-palm-right.png') }}") right bottom/72% auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold.png') }}") left top/210px auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-floral-corner-gold-mirror.png') }}") right top/210px auto no-repeat,
                    url("{{ asset('assets/luxury-maroon/lux-floral-bottom.png') }}") center bottom/172% auto no-repeat;
            }
            .lm-hero-inner { padding-top: 145px; padding-bottom: 240px; }
            .lm-hero-photo-wrap { width: min(100%, 270px); margin-top: 24px; }
            .lm-hero-title { font-size: clamp(2.05rem, 10vw, 3.2rem); gap: 4px; }
            .lm-hero-date { font-size: .82rem; letter-spacing: .14em; }
            .lm-hero-actions { flex-direction: column; }
            .lm-hero-actions .lm-btn, .lm-btn { width: 100%; }
            .lm-label { font-size: 10px; letter-spacing: .14em; }
            .lm-label::before, .lm-label::after { width: 18px; }
            .lm-event-card { padding: 48px 22px; border-radius: 999px 999px 32px 32px; border-width: 5px; }
            .lm-event-card h3 { font-size: clamp(2.3rem, 12vw, 3.8rem); }
            .lm-event-actions { flex-direction: column; }
            .lm-story-wrap { grid-template-columns: 38px minmax(0,1fr); gap: 14px; }
            .lm-story-card img, .lm-story-fallback { height: 360px; }
            .lm-story-content { padding: 28px 24px; }
            .lm-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .lm-gallery-item, .lm-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: auto; aspect-ratio: 4/5; }
            .lm-summary-grid { grid-template-columns: 1fr; }
            .lm-rsvp-copy, .lm-form-card { padding: 26px 20px; border-radius: 28px; }
            .lm-closing::before { background-size: 150px auto, 128% auto, 170% auto, 172% auto; }
            .lm-closing-card { padding: 160px 20px 220px; }
            .lm-event-countdown {
                margin-top: 20px;
                padding: 14px 12px;
                border-radius: 24px;
            }

            .lm-event-countdown-grid {
                gap: 6px;
            }

            .lm-event-countdown-box {
                padding: 9px 4px;
                border-radius: 14px;
            }

            .lm-event-countdown-box b {
                font-size: 1.35rem;
            }

            .lm-event-countdown-box span {
                font-size: 8px;
                letter-spacing: .08em;
            }

            .lm-event-info-item {
                border-radius: 22px;
                padding: 13px 14px;
            }

            .lm-event-date,
            .lm-event-time {
                font-size: .82rem;
                letter-spacing: .06em;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'maroon';
    if ($themeColor === 'golden') { $themeColor = 'gold'; }

    $lmThemes = [
        'maroon' => ['deep'=>'#2a0018','maroon'=>'#650d35','gold'=>'#d6b25d','goldDark'=>'#9b7330','cream'=>'#fff1d5','ink'=>'#ffe9c3'],
        'gold' => ['deep'=>'#2d1710','maroon'=>'#6d351d','gold'=>'#d8b55f','goldDark'=>'#9f7130','cream'=>'#fff4dc','ink'=>'#ffe9c8'],
        'rose' => ['deep'=>'#35101f','maroon'=>'#8b2f51','gold'=>'#d8ad6a','goldDark'=>'#a8753d','cream'=>'#fff1e5','ink'=>'#ffe7d4'],
        'emerald' => ['deep'=>'#06281e','maroon'=>'#174d38','gold'=>'#d5b45f','goldDark'=>'#947038','cream'=>'#efffea','ink'=>'#e8f8dc'],
        'navy' => ['deep'=>'#071224','maroon'=>'#21355c','gold'=>'#d5b45f','goldDark'=>'#947038','cream'=>'#edf3ff','ink'=>'#e4ecff'],
        'slate' => ['deep'=>'#171b22','maroon'=>'#3d4653','gold'=>'#c6aa66','goldDark'=>'#927545','cream'=>'#f7f4ea','ink'=>'#f1eadc'],
    ];
    $lmTheme = $lmThemes[$themeColor] ?? $lmThemes['maroon'];

    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
    $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;
    $people = ($invitation->people ?? collect())->values();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();

    $eventTitle = $invitation->title ?: 'Juwita & Seno';
    $eventName = $invitation->event_name ?: 'The Wedding Of';
    $hostName = $invitation->host_name ?: 'Keluarga Besar';

    $titleParts = array_map('trim', explode('&', $eventTitle));
    $bride = $people->get(0);
    $groom = $people->get(1);
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Juwita');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Seno');
    $monogram = strtoupper(\Illuminate\Support\Str::substr($brideName, 0, 1) . \Illuminate\Support\Str::substr($groomName, 0, 1));

    $assetPhoto = function ($path) {
        if (!$path) return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };
    $personPhotoUrl = function ($person, $fallback) use ($assetPhoto) {
        $path = $person->photo ?? $person->image ?? null;
        return $assetPhoto($path) ?: $fallback;
    };

    $shareUrl = route('invitation.public', $invitation->slug);
    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date) : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date) : null;

    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : 'Tanggal belum diatur';
    $eventDateShort = $startDate ? $startDate->translatedFormat('d • m • y') : 'Tanggal belum diatur';
    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Hari belum diatur';
    $eventDateRangeText = $eventDateText;
    if ($startDate && $endDate) {
        if ($startDate->isSameDay($endDate)) { $eventDateRangeText = $startDate->translatedFormat('d F Y'); }
        elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) { $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y'); }
        elseif ($startDate->format('Y') === $endDate->format('Y')) { $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y'); }
        else { $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y'); }
    }

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H.i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H.i'); }
    elseif ($eventTimeText) { $eventTimeText .= ' - Selesai'; }

    $countdownTarget = null;

    if ($startDate) {
        $datePart = $startDate->format('Y-m-d');
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

    $locationText = $invitation->location_name ?: 'Kediaman Mempelai Wanita';
    $addressText = $invitation->address ?: 'Alamat lengkap belum ditambahkan.';
    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

    $countdownTarget = null;
    if ($startDate) {
        $datePart = $startDate->format('Y-m-d');
        $timePart = '00:00:00';
        if (!empty($invitation->event_time)) {
            try { $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s'); } catch (\Exception $e) { $timePart = '00:00:00'; }
        }
        $countdownTarget = $datePart . 'T' . $timePart;
    }

    $googleCalendarUrl = null;
    if ($startDate) {
        try {
            $startDateTime = \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00'));
            $endDateValue = $endDate ? $endDate->format('Y-m-d') : $startDate->format('Y-m-d');
            $endDateTime = $invitation->event_end_time ? \Carbon\Carbon::parse($endDateValue . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s')) : $startDateTime->copy()->addHours(3);
            if ($endDateTime->lessThanOrEqualTo($startDateTime)) { $endDateTime = $startDateTime->copy()->addHours(3); }
            $calendarDetails = trim(($invitation->description ?: 'Undangan pernikahan') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));
            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($eventName . ' - ' . $eventTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }

    $shareMessage = "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" . "*{$eventTitle}*\n\n" . "Tanggal: {$eventDateRangeText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    $shareMessage .= "\nBuka undangan lengkap:\n{$shareUrl}";
    $shareText = urlencode($shareMessage);

    $coverPhoto = $assetPhoto($invitation->cover_image);
    $defaultCover = asset('assets/luxury-maroon/lux-couple-placeholder.png');
    $coverDisplay = $coverPhoto ?: $defaultCover;
    $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
    $groomPhoto = $personPhotoUrl($groom, $coverDisplay);
    $storyPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;
    $closingPhoto = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
@endphp

<body style="--lm-deep: {{ $lmTheme['deep'] }}; --lm-maroon: {{ $lmTheme['maroon'] }}; --lm-gold: {{ $lmTheme['gold'] }}; --lm-gold-dark: {{ $lmTheme['goldDark'] }}; --lm-cream: {{ $lmTheme['cream'] }}; --lm-ink: {{ $lmTheme['ink'] }};">
    <div class="lm-floating-actions">
        <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan"></a>
        <button type="button" id="music-toggle" title="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music"></button>
        <button type="button" id="scroll-toggle" title="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll"></button>
        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi"></a>@endif
    </div>

    <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}" preload="auto" loop></audio>

    <main class="lm-shell">
        <div class="lm-book">
            <section id="cover" class="lm-page lm-hero">
                <div class="lm-hero-inner" data-reveal="zoom">
                    <div class="lm-hero-kicker">{{ $eventName }}</div>
                    <div class="lm-hero-photo-wrap">
                        @if ($coverDisplay)
                            <img src="{{ $coverDisplay }}" alt="Foto Mempelai" class="lm-hero-photo">
                        @else
                            <div class="lm-hero-photo-fallback">{{ $monogram }}</div>
                        @endif
                    </div>
                    <h1 class="lm-title lm-hero-title">
                        <span class="lm-hero-name responsive-text">{{ $brideName }}</span>
                        <span class="lm-script lm-hero-and">&</span>
                        <span class="lm-hero-name responsive-text">{{ $groomName }}</span>
                    </h1>
                    <div class="lm-hero-date responsive-text">{{ $eventDayText }}, {{ $eventDateText }}</div>
                    <div class="lm-hero-actions">
                        <a href="#couple" class="lm-btn">Buka Undangan</a>
                        <a href="#acara" class="lm-btn light">Simpan Tanggal</a>
                    </div>
                </div>
            </section>

            <section id="couple" class="lm-page lm-couple">
                <div class="lm-couple-intro" data-reveal="zoom">
                    <h2 class="lm-title"><span class="lm-script">The</span> <span class="lm-gold-text">Couple</span></h2>
                    <p class="lm-note responsive-text">Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.</p>
                </div>
                <div class="lm-couple-stage">
                    <div class="lm-person-card" data-reveal="zoom">
                        <div class="lm-person-photo-wrap">
                            <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                        </div>
                        <div class="lm-person-content">
                            <h3 class="lm-person-name responsive-text">{{ $brideName }}</h3>
                            <div class="lm-person-subtitle responsive-text">{{ $bride->subtitle ?? 'Mempelai Wanita' }}</div>
                            <p class="lm-person-family responsive-text">{{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}</p>
                            @if (!empty($bride->instagram))<a class="lm-instagram" href="https://instagram.com/{{ ltrim($bride->instagram, '@') }}" target="_blank">Instagram</a>@endif
                        </div>
                    </div>

                    <div class="lm-person-card" data-reveal="zoom" style="--reveal-delay:.08s">
                        <div class="lm-person-photo-wrap">
                            <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                        </div>
                        <div class="lm-person-content">
                            <h3 class="lm-person-name responsive-text">{{ $groomName }}</h3>
                            <div class="lm-person-subtitle responsive-text">{{ $groom->subtitle ?? 'Mempelai Pria' }}</div>
                            <p class="lm-person-family responsive-text">{{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}</p>
                            @if (!empty($groom->instagram))<a class="lm-instagram" href="https://instagram.com/{{ ltrim($groom->instagram, '@') }}" target="_blank">Instagram</a>@endif
                        </div>
                    </div>
                </div>
            </section>

            <section id="invitation" class="lm-page slim">
                <div class="lm-invitation-card" data-reveal="zoom">
                    <p class="lm-label">Assalamu'alaikum</p>
                    <h2 class="lm-title lm-script responsive-text">Undangan Pernikahan</h2>
                    <p class="lm-note responsive-text">{{ $invitation->description ?: 'Tanpa mengurangi rasa hormat, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami. Kehadiran dan doa restu Anda merupakan kebahagiaan bagi kami.' }}</p>
                </div>
            </section>

            <section id="acara" class="lm-page lm-event-section">
                <p class="lm-label" data-reveal="zoom">Wedding Event</p>
                <h2 class="lm-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,7vw,6.5rem);"><span class="lm-script">Wedding</span> <span class="lm-gold-text">Event</span></h2>
                <p class="lm-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.</p>

                <div class="lm-event-layout">
                    <div class="lm-event-card" data-reveal="zoom">
                        <div class="lm-event-icon"></div>
                        <h3 class="lm-title lm-script responsive-text">Acara Pernikahan</h3>
                        @if ($countdownTarget)
                            <div class="lm-event-countdown" data-countdown-target="{{ $countdownTarget }}">
                                <div class="lm-event-countdown-head">
                                    Menuju Acara
                                </div>

                                <div class="lm-event-countdown-grid">
                                    <div class="lm-event-countdown-box">
                                        <b data-unit="days">00</b>
                                        <span>Hari</span>
                                    </div>

                                    <div class="lm-event-countdown-box">
                                        <b data-unit="hours">00</b>
                                        <span>Jam</span>
                                    </div>

                                    <div class="lm-event-countdown-box">
                                        <b data-unit="minutes">00</b>
                                        <span>Menit</span>
                                    </div>

                                    <div class="lm-event-countdown-box">
                                        <b data-unit="seconds">00</b>
                                        <span>Detik</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="lm-event-info">
                            <div class="lm-event-info-item">
                                <span class="lm-event-info-label">Hari & Tanggal</span>
                                <div class="lm-event-date responsive-text">
                                    {{ $eventDateRangeText }}
                                </div>
                            </div>

                            @if ($eventTimeText)
                                <div class="lm-event-info-item">
                                    <span class="lm-event-info-label">Waktu</span>
                                    <div class="lm-event-time responsive-text">
                                        Pukul {{ $eventTimeText }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="lm-map-pin">●</div>
                        <div class="lm-event-place responsive-text">{{ $locationText }}</div>
                        <div class="lm-event-address responsive-text">{!! nl2br(e($addressText)) !!}</div>
                        <div class="lm-event-actions">
                            @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="lm-btn">Google Map</a>@endif
                            @if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="lm-btn light">Calendar</a>@endif
                        </div>
                    </div>
                </div>

                @if ($mapEmbedUrl)
                    <div class="lm-event-layout mt-8">
                        <div class="lm-event-card" style="border-radius:44px;padding:16px;">
                            <iframe src="{{ $mapEmbedUrl }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" style="width:100%;height:360px;border:0;border-radius:30px;"></iframe>
                        </div>
                    </div>
                @endif
            </section>

            <section id="story" class="lm-page lm-story-section">
                <p class="lm-label" data-reveal="zoom">Love Story</p>
                <h2 class="lm-title lm-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,7vw,6rem);">Love Story</h2>
                <div class="lm-story-wrap">
                    <div class="lm-story-line" data-reveal="left"></div>
                    <div class="lm-story-card" data-reveal="zoom">
                        @if ($storyPhoto)
                            <img src="{{ $storyPhoto }}" alt="Love Story">
                        @else
                            <div class="lm-story-fallback">{{ $monogram }}</div>
                        @endif
                        <div class="lm-story-content">
                            <h3 class="lm-title lm-script responsive-text">Awal Bertemu</h3>
                            <p class="responsive-text">Setiap kisah memiliki awal yang indah. Dari pertemuan sederhana, tumbuh doa dan keyakinan untuk melangkah bersama menuju hari bahagia.</p>
                        </div>
                    </div>
                </div>
            </section>

            @if ($photos->count())
                <section id="galeri" class="lm-page slim">
                    <p class="lm-label" data-reveal="zoom">Our Gallery</p>
                    <h2 class="lm-title lm-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,7vw,6rem);">Precious Moment</h2>
                    <div class="lm-gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="lm-gallery-item" data-reveal="zoom" style="--reveal-delay: {{ min($index * .05, .30) }}s"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Pernikahan"></a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="lm-page slim">
                    <p class="lm-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="lm-title lm-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,7vw,6rem);">Wedding Gift</h2>
                    <p class="lm-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                    <div class="lm-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            <div class="lm-gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .06, .30) }}s">
                                <div class="lm-gift-title responsive-text">{{ $gift->label ?: 'Wedding Gift' }}</div>
                                <div class="lm-gift-number responsive-text">{{ $gift->account_number ?: '-' }}</div>
                                <p class="responsive-text mt-2" style="position:relative;z-index:2;color:#6b4f56;">{{ $gift->account_name ?: 'Atas nama penerima' }}</p>
                                @if ($gift->account_number)<button type="button" class="lm-copy-btn" data-copy="{{ $gift->account_number }}">Salin Nomor</button>@endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="lm-page slim">
                <p class="lm-label" data-reveal="zoom">RSVP</p>
                <h2 class="lm-title lm-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,7vw,6rem);">Kirim Pesan</h2>
                <div class="lm-rsvp-layout">
                    <div class="lm-rsvp-copy" data-reveal="left">
                        <h3 class="lm-title lm-script responsive-text">Ucapan & Doa</h3>
                        <p class="responsive-text mt-4">Silakan kirim ucapan dan konfirmasi kehadiran Anda untuk kedua mempelai.</p>
                    </div>

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="lm-form-card space-y-4" data-reveal="right">
                        @csrf
                        <div><label class="lm-form-label">Nama</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="lm-input" placeholder="Nama" required></div>
                        <div><label class="lm-form-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="lm-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                        <div><label class="lm-form-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="lm-input"></div>
                        <div><label class="lm-form-label">Pesan</label><textarea name="message" rows="4" class="lm-input" placeholder="Tulis pesan..." required>{{ old('message') }}</textarea></div>
                        <button type="submit" class="w-full lm-btn">Kirim Pesan</button>
                    </form>

                    <div class="lm-summary-grid">
                        <div data-reveal="zoom"><b>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</b><span>Tidak Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.06s"><b>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><span>Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.12s"><b>{{ $messages->where('attendance_status', 'ragu')->count() }}</b><span>Ragu</span></div>
                    </div>

                    <div class="lm-message-list">
                        @forelse ($messages as $index => $message)
                            <div class="lm-message-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--lm-maroon);">{{ $message->guest_name }}</p><p class="text-xs mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:#fff1dd;color:var(--lm-maroon);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                                <p class="responsive-text mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="lm-message-card text-center" data-reveal="zoom"><p>Belum ada ucapan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="lm-page lm-closing">
                <div class="lm-closing-card" data-reveal="zoom">
                    @if ($closingPhoto)<img src="{{ $closingPhoto }}" alt="Foto Penutup" class="lm-closing-photo">@endif
                    <p class="lm-label">Terima Kasih</p>
                    <h2 class="lm-title responsive-text mt-8">{{ $eventTitle }}</h2>
                    <p class="lm-note responsive-text mt-6">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const music = document.getElementById('invitation-music');
            const musicToggle = document.getElementById('music-toggle');
            const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
            let isMusicPlaying = false;
            function setMusicIcon(active) {
                if (!musicToggle || !musicIcon) return;
                musicToggle.classList.toggle('is-active', active);
                musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
            }
            if (musicToggle && music) {
                musicToggle.addEventListener('click', async function () {
                    try {
                        if (isMusicPlaying) { music.pause(); isMusicPlaying = false; }
                        else { await music.play(); isMusicPlaying = true; }
                        setMusicIcon(isMusicPlaying);
                    } catch (error) { isMusicPlaying = false; setMusicIcon(false); }
                });
            }

            const scrollToggle = document.getElementById('scroll-toggle');
            const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;
            let lastTime = null;
            function setScrollIcon(active) {
                if (!scrollToggle || !scrollIcon) return;
                scrollToggle.classList.toggle('is-active', active);
                scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
            }
            function stopAutoScroll() {
                autoScrollActive = false;
                lastTime = null;
                if (autoScrollFrame) { cancelAnimationFrame(autoScrollFrame); autoScrollFrame = null; }
                setScrollIcon(false);
            }
            function autoScrollStep(timestamp) {
                if (!autoScrollActive) return;
                if (lastTime === null) lastTime = timestamp;
                const delta = Math.min(32, timestamp - lastTime);
                lastTime = timestamp;
                const maxY = document.documentElement.scrollHeight - window.innerHeight;
                const nextY = Math.min(window.scrollY + (scrollSpeed * delta / 16.67), maxY);
                window.scrollTo({ top: nextY, behavior: 'auto' });
                if (nextY >= maxY) { stopAutoScroll(); return; }
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }
            function startAutoScroll() { stopAutoScroll(); autoScrollActive = true; setScrollIcon(true); autoScrollFrame = requestAnimationFrame(autoScrollStep); }
            if (scrollToggle) {
                scrollToggle.addEventListener('click', function () { autoScrollActive ? stopAutoScroll() : startAutoScroll(); });
                ['wheel','touchstart','keydown'].forEach(function (eventName) { window.addEventListener(eventName, function () { if (autoScrollActive) stopAutoScroll(); }, { passive: true }); });
            }

            document.querySelectorAll('.lm-copy-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';
                    const oldText = button.textContent;
                    try { await navigator.clipboard.writeText(value); }
                    catch (error) {
                        const textarea = document.createElement('textarea');
                        textarea.value = value;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
                    button.classList.add('copied');
                    button.textContent = 'Tersalin';
                    setTimeout(function () { button.textContent = oldText; button.classList.remove('copied'); }, 1600);
                });
            });

            const revealElements = document.querySelectorAll('[data-reveal]');
            if (!('IntersectionObserver' in window)) { revealElements.forEach(function (el) { el.classList.add('is-visible'); }); }
            else {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); revealObserver.unobserve(entry.target); } });
                }, { threshold: 0.14, rootMargin: '0px 0px -60px 0px' });
                revealElements.forEach(function (el) { revealObserver.observe(el); });
            }

            document.addEventListener('contextmenu', function (event) { event.preventDefault(); });
            document.addEventListener('keydown', function (event) {
                const key = event.key ? event.key.toLowerCase() : '';
                const blocked = event.key === 'F12' ||
                    (event.ctrlKey && event.shiftKey && ['i','j','c'].includes(key)) ||
                    (event.ctrlKey && ['u','s','p'].includes(key)) ||
                    (event.metaKey && event.altKey && ['i','j','c'].includes(key)) ||
                    (event.metaKey && ['u','s','p'].includes(key));
                if (blocked) { event.preventDefault(); event.stopPropagation(); return false; }
            });
            document.addEventListener('dragstart', function (event) { event.preventDefault(); });
            document.addEventListener('selectstart', function (event) {
                const tag = event.target.tagName ? event.target.tagName.toLowerCase() : '';
                if (!['input','textarea','select','option'].includes(tag)) event.preventDefault();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-countdown-target]').forEach(function (wrap) {
                const targetValue = wrap.dataset.countdownTarget;

                if (!targetValue) {
                    return;
                }

                const target = new Date(targetValue).getTime();

                if (Number.isNaN(target)) {
                    return;
                }

                const units = {
                    days: wrap.querySelector('[data-unit="days"]'),
                    hours: wrap.querySelector('[data-unit="hours"]'),
                    minutes: wrap.querySelector('[data-unit="minutes"]'),
                    seconds: wrap.querySelector('[data-unit="seconds"]')
                };

                function pad(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    let diff = Math.max(0, target - Date.now());

                    const days = Math.floor(diff / 86400000);
                    diff -= days * 86400000;

                    const hours = Math.floor(diff / 3600000);
                    diff -= hours * 3600000;

                    const minutes = Math.floor(diff / 60000);
                    diff -= minutes * 60000;

                    const seconds = Math.floor(diff / 1000);

                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });
        });
    </script>
</body>
</html>
