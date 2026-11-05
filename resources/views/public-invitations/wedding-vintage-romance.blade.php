<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Vintage Romance'));
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
            color: var(--vr-cream);
            background:
                radial-gradient(circle at 12% 8%, rgba(204, 171, 91, .16), transparent 32%),
                radial-gradient(circle at 88% 8%, rgba(255, 247, 215, .08), transparent 30%),
                linear-gradient(180deg, #34101d 0%, #651d35 42%, #2e0d18 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-line;
        }

        .vr-shell {
            width: min(100%, 1220px);
            margin: 0 auto;
            padding: 26px;
        }

        .vr-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 36px;
            isolation: isolate;
            background:
                linear-gradient(180deg, rgba(87, 18, 42, .94), rgba(49, 12, 24, .97)),
                url("{{ asset('assets/vintage-romance/vr-maroon-paper-texture.png') }}") center/cover repeat,
                #4b1328;
            border: 1px solid rgba(219, 183, 93, .22);
            box-shadow: 0 44px 140px rgba(25, 6, 13, .46);
        }

        .vr-book::before,
        .vr-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .vr-book::before {
            opacity: .46;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold.png') }}") left top/330px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold-mirror.png') }}") right top/330px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-left.png') }}") left 48%/230px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-right.png') }}") right 48%/230px auto no-repeat,
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px) 0 0/48px 48px,
                linear-gradient(0deg, rgba(255,255,255,.025) 1px, transparent 1px) 0 0/48px 48px;
        }

        .vr-book::after {
            opacity: .55;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,236,178,.16), transparent 32%),
                radial-gradient(circle at 50% 58%, rgba(255,221,153,.08), transparent 40%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center/cover repeat;
            mix-blend-mode: screen;
        }

        .vr-book > * { position: relative; z-index: 2; }

        .vr-title {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            color: var(--vr-gold);
            line-height: .96;
            letter-spacing: .03em;
            text-wrap: balance;
        }

        .vr-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .vr-note {
            max-width: 720px;
            margin: 20px auto 0;
            color: rgba(255, 249, 232, .82);
            line-height: 1.9;
        }

        .vr-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 20px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--vr-cream);
            background: rgba(255,255,255,.09);
            border: 1px solid rgba(219, 183, 93, .35);
            box-shadow: 0 14px 32px rgba(0,0,0,.16);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .vr-label::before,
        .vr-label::after { content: ""; width: 28px; height: 1px; background: var(--vr-gold); opacity: .68; }

        .vr-btn {
            position: relative;
            overflow: hidden;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,.14);
            cursor: pointer;
            text-decoration: none;
            color: #37121d;
            background: linear-gradient(135deg, #fff7dc, var(--vr-gold), #b28736);
            box-shadow: 0 18px 42px rgba(0,0,0,.24);
            font-weight: 950;
            letter-spacing: .04em;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .vr-btn:hover { transform: translateY(-2px); }
        .vr-btn.light { color: var(--vr-cream); background: rgba(255,255,255,.08); border-color: rgba(219,183,93,.35); }
        .vr-btn::after,
        .vr-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -90%;
            width: 46%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: vrShine 4.2s ease-in-out infinite;
        }

        .vr-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(58, 13, 29, .70);
            border: 1px solid rgba(219,183,93,.28);
            border-right: 0;
            box-shadow: 0 20px 46px rgba(0,0,0,.26);
            backdrop-filter: blur(14px);
        }
        .vr-floating-actions a,
        .vr-floating-actions button {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 16px 0 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            background: rgba(255,255,255,.94);
            box-shadow: 0 10px 24px rgba(0,0,0,.18);
            transition: transform .25s ease, background .25s ease;
        }
        .vr-floating-actions a:hover,
        .vr-floating-actions button:hover { transform: translateX(-3px); }
        .vr-floating-actions button.is-active { background: #f4df9d; }
        .vr-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .vr-page {
            position: relative;
            min-height: auto;
            padding: 106px 76px;
            overflow: hidden;
            text-align: center;
        }
        .vr-page.slim { padding-top: 88px; padding-bottom: 88px; }
        .vr-page > * { position: relative; z-index: 5; }
        .vr-page::before,
        .vr-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .vr-page::before {
            z-index: 1;
            opacity: .42;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top/78% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom/104% auto no-repeat;
        }
        .vr-page::after {
            z-index: 2;
            opacity: .42;
            background:
                radial-gradient(circle at 50% 36%, rgba(255,255,255,.10), transparent 40%),
                linear-gradient(180deg, rgba(255,255,255,.05), transparent 34%, rgba(0,0,0,.12));
        }

        /* HERO - chandelier, gold ornament, palace door, floral bottom */
        .vr-hero {
            min-height: 920px;
            padding: 86px 76px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(96, 19, 44, .70), rgba(66, 15, 31, .70)),
                url("{{ asset('assets/vintage-romance/vr-palace-door-soft.png') }}") center/cover no-repeat,
                #501326;
        }
        .vr-hero::before {
            opacity: .88;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top/96% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 3%/300px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left center/270px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right center/270px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom/108% auto no-repeat;
        }
        .vr-hero::after {
            opacity: .40;
            background:
                radial-gradient(circle at 50% 46%, rgba(255,244,203,.16), transparent 30%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center/cover no-repeat;
        }
        .vr-hero-inner { width: min(100%, 600px); margin: 0 auto; padding: 260px 0 250px; }
        .vr-hero-kicker { color: var(--vr-cream); font-size: 12px; font-weight: 950; letter-spacing: .22em; text-transform: uppercase; }
        .vr-hero-title {
            margin: 28px auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: var(--vr-gold);
            font-size: clamp(3rem, 7vw, 5.8rem);
            line-height: .96;
            font-weight: 700;
            text-transform: uppercase;
        }
        .vr-hero-name { display: block; line-height: .96; }
        .vr-hero-and { display: block; color: var(--vr-cream); font-size: clamp(2rem, 4vw, 3.2rem); line-height: .8; text-transform: none; }
        .vr-hero-date { margin-top: 30px; color: var(--vr-cream); font-size: 1.05rem; letter-spacing: .28em; font-weight: 850; }
        .vr-hero-arrow { width: 44px; margin: 28px auto 0; opacity: .92; animation: vrBounce 2.4s ease-in-out infinite; }
        .vr-hero-actions { margin-top: 28px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Couple */
        .vr-couple::before {
            opacity: .62;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top/94% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center top/250px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-left.png') }}") left center/230px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-right.png') }}") right center/230px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom/106% auto no-repeat;
        }
        .vr-couple-stage {
            width: min(100%, 980px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 26px;
            align-items: stretch;
        }
        .vr-person-card {
            position: relative;
            overflow: hidden;
            min-height: 640px;
            padding: 56px 32px 46px;
            border-radius: 999px 999px 42px 42px;
            background: linear-gradient(180deg, rgba(104, 26, 50, .78), rgba(57, 12, 26, .86));
            border: 1px solid rgba(219,183,93,.38);
            box-shadow: 0 30px 90px rgba(0,0,0,.28);
        }
        .vr-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .62;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 130% auto no-repeat;
            pointer-events: none;
        }

        /* Couple photo frame - clean base */
        .vr-person-photo-wrap {
            position: relative;
            z-index: 5;
            width: clamp(300px, 27vw, 410px);
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            padding: 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            overflow: visible;
        }

        .vr-person-photo-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 4;
            background: url("{{ asset('assets/vintage-romance/vr-oval-frame-gold.png') }}") center center / contain no-repeat;
            pointer-events: none;
            filter:
                drop-shadow(0 18px 28px rgba(0,0,0,.30))
                drop-shadow(0 0 12px rgba(255, 221, 120, .18));
        }

        .vr-person-photo-wrap::after { display: none; }

        .vr-photo-circle {
            position: absolute;
            left: 50%;
            top: 49.2%;
            z-index: 2;
            width: 58%;
            height: 58%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            overflow: hidden;
            background: #4f1529;
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.10),
                0 8px 20px rgba(0,0,0,.18);
        }

        .vr-photo-circle img,
        .vr-photo-circle .vr-person-initial {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center center;
            border-radius: 50%;
            background: #4f1529;
        }

        .vr-photo-circle .vr-person-initial {
            display: grid;
            place-items: center;
            color: var(--vr-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .vr-person-content {
            position: relative;
            z-index: 6;
            margin-top: -8px;
        }

        .vr-person-subtitle { width: fit-content; max-width: 100%; margin: 0 auto 16px; padding: 8px 18px; border-radius: 999px; color: #37111d; background: var(--vr-gold); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .vr-person-name { margin: 0; color: var(--vr-cream); font-family: Georgia,"Times New Roman",serif; font-size: clamp(2rem, 4vw, 3.5rem); line-height: 1.05; }
        .vr-person-family { max-width: 390px; margin: 18px auto 0; color: rgba(255,249,232,.82); line-height: 1.78; }

        /* Invitation */
        .vr-invitation-card {
            width: min(100%, 880px);
            margin: 0 auto;
            padding: 58px 50px;
            border-radius: 46px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(219,183,93,.30);
            box-shadow: 0 28px 84px rgba(0,0,0,.18);
            backdrop-filter: blur(10px);
        }
        .vr-invitation-card h2 { font-size: clamp(3rem, 6vw, 6.5rem); }

        /* Save The Date */
        .vr-save-date {
            min-height: 900px;
            display: grid;
            place-items: center;
            padding: 120px 76px 135px;
        }
        .vr-save-date::before {
            opacity: .88;
            background:
                url("{{ asset('assets/vintage-romance/vr-stage-curtain.png') }}") center top/100% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-carriage-gold.png') }}") center 25%/240px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-left.png') }}") left center/240px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-palace-column-right.png') }}") right center/240px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom/106% auto no-repeat;
        }
        .vr-count-panel {
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 84px 42px 70px;
            border-radius: 46px;
            background: rgba(73, 16, 34, .60);
            border: 1px solid rgba(219,183,93,.28);
            box-shadow: 0 30px 90px rgba(0,0,0,.22);
            backdrop-filter: blur(6px);
        }
        .vr-count-title { font-size: clamp(3rem, 6vw, 6rem); color: var(--vr-gold); }
        .vr-count-grid {
            width: min(100%, 540px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px 56px;
        }
        .vr-count-card { padding: 16px 12px; }
        .vr-count-number { display: block; color: var(--vr-cream); font-family: Georgia,"Times New Roman",serif; font-size: clamp(2.7rem, 6vw, 4.8rem); line-height: 1; }
        .vr-count-label { display: block; margin-top: 10px; color: var(--vr-gold); font-size: 13px; font-weight: 850; }
        .vr-count-actions { margin-top: 44px; }

        /* Event */
        .vr-event-layout {
            width: min(100%, 900px);
            margin: 48px auto 0;
            display: grid;
            gap: 26px;
        }
        .vr-event-card {
            position: relative;
            overflow: hidden;
            padding: 74px 46px 58px;
            border-radius: 999px 999px 42px 42px;
            background: rgba(66, 13, 31, .78);
            border: 2px solid rgba(219,183,93,.62);
            box-shadow: 0 34px 100px rgba(0,0,0,.25);
        }
        .vr-event-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 999px 999px 34px 34px;
            border: 1px solid rgba(219,183,93,.32);
            pointer-events: none;
        }
        .vr-event-icon { width: 64px; height: 64px; margin: 0 auto 24px; object-fit: contain; opacity: .95; }
        .vr-event-card h3 { font-size: clamp(2.2rem, 4.2vw, 4.2rem); color: var(--vr-gold); text-transform: uppercase; }
        .vr-date-split { margin: 36px auto 28px; display: grid; grid-template-columns: 1fr auto 1fr; gap: 22px; align-items: center; width: min(100%, 520px); }
        .vr-date-side { color: rgba(255,249,232,.86); font-family: Georgia,"Times New Roman",serif; font-size: 1.15rem; }
        .vr-date-center { padding: 0 28px; border-left: 1px solid rgba(219,183,93,.45); border-right: 1px solid rgba(219,183,93,.45); }
        .vr-date-center b { display: block; color: var(--vr-gold); font-family: Georgia,"Times New Roman",serif; font-size: clamp(3rem, 6vw, 5.2rem); line-height: .9; }
        .vr-date-center span { display: block; margin-top: 10px; color: rgba(255,249,232,.82); font-weight: 700; }
        .vr-event-line { margin-top: 18px; color: rgba(255,249,232,.86); line-height: 1.85; font-weight: 700; }
        .vr-event-place { margin-top: 32px; color: var(--vr-cream); font-weight: 950; }
        .vr-event-address { width: min(100%, 660px); margin: 10px auto 0; color: rgba(255,249,232,.78); line-height: 1.75; }
        .vr-event-actions { margin-top: 34px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .vr-map-card { margin-top: 30px; overflow: hidden; border-radius: 34px; border: 1px solid rgba(219,183,93,.32); background: rgba(255,255,255,.08); box-shadow: 0 24px 68px rgba(0,0,0,.20); }
        .vr-map-frame, .vr-map-placeholder { width: 100%; height: 390px; min-height: 390px; border: 0; display: block; }
        .vr-map-placeholder { display: flex; align-items: center; justify-content: center; color: var(--vr-cream); text-decoration: none; padding: 30px; background: rgba(255,255,255,.08); }
        .vr-map-footer { padding: 20px 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; text-align: left; background: rgba(58,13,29,.82); border-top: 1px solid rgba(219,183,93,.24); }
        .vr-map-title { margin: 0; color: var(--vr-gold); font-weight: 950; }
        .vr-map-address { margin: 6px 0 0; color: rgba(255,249,232,.78); line-height: 1.6; white-space: pre-line; overflow-wrap: anywhere; }

        .vr-event-date-group {
            width: min(100%, 560px);
            margin: 36px auto 28px;
        }

        .vr-event-date-group .vr-date-split {
            margin: 0 auto;
        }

        .vr-date-end-label {
            margin: 18px 0 14px;
            color: var(--vr-gold);
            font-size: .95rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: .04em;
            opacity: .95;
        }

        .vr-date-split-end {
            margin-top: 0;
        }

        /* Gallery */
        .vr-gallery-grid {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-rows: 92px;
            grid-auto-flow: dense;
            gap: 14px;
        }
        .vr-gallery-item { display: block; overflow: hidden; padding: 8px; border-radius: 28px; background: rgba(255,255,255,.94); border: 1px solid rgba(219,183,93,.28); box-shadow: 0 18px 46px rgba(0,0,0,.20); }
        .vr-gallery-item:nth-child(1) { grid-column: span 6; grid-row: span 4; }
        .vr-gallery-item:nth-child(2) { grid-column: span 6; grid-row: span 2; }
        .vr-gallery-item:nth-child(3), .vr-gallery-item:nth-child(4) { grid-column: span 3; grid-row: span 2; }
        .vr-gallery-item:nth-child(n+5) { grid-column: span 4; grid-row: span 2; }
        .vr-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 20px; transition: transform .7s ease; }
        .vr-gallery-item:hover img { transform: scale(1.055); }

        /* Story */
        .vr-story-wrap { width: min(100%, 860px); margin: 46px auto 0; display: grid; gap: 28px; }
        .vr-story-card { position: relative; display: grid; grid-template-columns: 300px 1fr; gap: 26px; align-items: center; padding: 24px; border-radius: 34px; background: rgba(255,255,255,.94); color: #4f1328; text-align: left; box-shadow: 0 28px 82px rgba(0,0,0,.23); }
        .vr-story-card::before { content:""; position:absolute; left:-42px; top:20px; bottom:20px; width:2px; background: rgba(219,183,93,.70); }
        .vr-story-photo { width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 24px; }
        .vr-story-content h3 { margin: 0; color: #761f3b; font-family: Georgia,"Times New Roman",serif; font-size: clamp(1.8rem, 3vw, 2.8rem); }
        .vr-story-content p { margin: 14px 0 0; color: #6d5060; line-height: 1.85; }

        /* Gift */
        .vr-gift-grid { width: min(100%, 920px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .vr-gift-grid.is-single { grid-template-columns: minmax(0, 460px); justify-content: center; }
        .vr-gift-card { position: relative; overflow: hidden; min-height: 210px; padding: 32px 28px; border-radius: 34px; text-align: left; background: rgba(255,255,255,.94); color: #4f1328; border: 1px solid rgba(219,183,93,.28); box-shadow: 0 20px 58px rgba(0,0,0,.18); }
        .vr-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: rgba(219,183,93,.22); transform: skewY(-7deg); }
        .vr-gift-title,.vr-gift-number,.vr-copy-btn { position: relative; z-index: 2; }
        .vr-gift-title { color: #651d35; font-weight: 950; font-size: 1.25rem; }
        .vr-gift-number { margin-top: 18px; color: #35111d; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .vr-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #38121e; background: var(--vr-gold); font-weight: 950; cursor: pointer; }
        .vr-copy-btn.copied { background: #16803c; color:#fff; }

        /* RSVP */
        .vr-rsvp-layout { width: min(100%, 1080px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .vr-rsvp-copy { padding: 42px 34px; border-radius: 40px; background: rgba(255,255,255,.08); border: 1px solid rgba(219,183,93,.26); box-shadow: 0 18px 48px rgba(0,0,0,.16); }
        .vr-rsvp-copy h3 {
            font-size: clamp(2rem, 3vw, 3.1rem);
            line-height: 1.05;
            word-break: normal;
            overflow-wrap: normal;
        }
        .vr-form-card { padding: 26px; border-radius: 28px; background: rgba(255,255,255,.94); border: 1px solid rgba(219,183,93,.20); box-shadow: 0 18px 48px rgba(0,0,0,.14); text-align: left; color: #3d1020; }
        .vr-form-label { display: block; color: #651d35; font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .vr-input { width: 100%; margin-top: 8px; border: 1px solid rgba(101,29,53,.16); background: rgba(255,255,255,.98); color: #37121d; border-radius: 14px; padding: 13px 14px; outline: none; text-align: left; }
        .vr-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .vr-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; background: rgba(255,255,255,.10); border: 1px solid rgba(219,183,93,.22); }
        .vr-summary-grid b { display: block; color: var(--vr-gold); font-size: 2rem; line-height: 1; }
        .vr-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .vr-message-card { padding: 18px; border-radius: 22px; background: rgba(255,255,255,.10); border: 1px solid rgba(219,183,93,.18); box-shadow: 0 10px 24px rgba(0,0,0,.12); }

        .vr-closing-card { width: min(100%, 720px); margin: 0 auto; padding: 74px 38px 220px; text-align: center; }
        .vr-closing-photo { width: min(100%, 390px); aspect-ratio: 4/5; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px 999px 26px 26px; border: 8px solid rgba(255,247,220,.95); outline: 1px solid rgba(219,183,93,.54); box-shadow: 0 24px 68px rgba(0,0,0,.28); }
        .vr-closing-card h2 { font-size: clamp(3rem, 7vw, 6.5rem); }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes vrShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes vrFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes vrBounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(12px); } }
        .vr-floating-actions a, .vr-floating-actions button { animation: vrFloat 4.4s ease-in-out infinite; }

        /* ANTI INSPECT BASIC PROTECTION */
        body { -webkit-user-select: none; user-select: none; -webkit-touch-callout: none; }
        img, a, button { -webkit-user-drag: none; user-drag: none; }
        input, textarea, select { -webkit-user-select: text; user-select: text; }

        @media (min-width: 1440px) {
            .vr-shell { width: min(100%, 1320px); }
            .vr-page { padding-left: 92px; padding-right: 92px; }
            .vr-hero-title { font-size: clamp(4.4rem, 6vw, 6.4rem); }
        }

        @media (max-width: 980px) {
            .vr-shell { padding: 14px; }
            .vr-page { padding: 92px 38px; }
            .vr-hero { min-height: 860px; padding: 76px 38px 0; }
            .vr-hero::before { background-size: 126% auto, 250px auto, 220px auto, 220px auto, 134% auto; }
            .vr-hero-inner { padding-top: 230px; padding-bottom: 220px; }
            .vr-couple-stage, .vr-rsvp-layout { grid-template-columns: 1fr; }
            .vr-gift-grid { grid-template-columns: 1fr; }
            .vr-story-card { grid-template-columns: 1fr; text-align: center; }
            .vr-story-card::before { display: none; }
            .vr-gallery-grid { grid-template-columns: repeat(6, 1fr); }
            .vr-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .vr-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .vr-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .vr-shell { padding: 0; }
            .vr-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .vr-page, .vr-page.slim { padding: 76px 22px; }
            .vr-floating-actions { right: 0; gap: 7px; }
            .vr-floating-actions a, .vr-floating-actions button { width: 40px; height: 40px; }
            .vr-hero { min-height: 100svh; padding: 58px 22px 0; }
            .vr-hero::before {
                background:
                    url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top/150% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 0/210px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left center/150px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right center/150px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom/176% auto no-repeat;
            }
            .vr-hero-inner { padding-top: 210px; padding-bottom: 190px; }
            .vr-hero-title { font-size: clamp(2.6rem, 12vw, 4rem); gap: 7px; }
            .vr-hero-and { font-size: clamp(1.8rem, 8vw, 2.5rem); }
            .vr-hero-actions, .vr-event-actions { flex-direction: column; }
            .vr-hero-actions .vr-btn, .vr-event-actions .vr-btn, .vr-btn { width: 100%; }
            .vr-label { font-size: 10px; letter-spacing: .14em; }
            .vr-label::before, .vr-label::after { width: 18px; }
            .vr-couple-stage { gap: 22px; }
            .vr-person-card { min-height: auto; padding: 40px 20px 42px; }
            .vr-person-photo-wrap { width: 230px; }
            .vr-date-split { grid-template-columns: 1fr; gap: 14px; }
            .vr-date-center { border-left: 0; border-right: 0; border-top: 1px solid rgba(219,183,93,.42); border-bottom: 1px solid rgba(219,183,93,.42); padding: 18px 0; }
            .vr-save-date { min-height: 780px; padding: 82px 22px 100px; }
            .vr-save-date::before { background-size: 180% auto, 170px auto, 150px auto, 150px auto, 176% auto; }
            .vr-count-panel { padding: 56px 20px 48px; border-radius: 34px; }
            .vr-count-grid { grid-template-columns: repeat(2, minmax(0,1fr)); gap: 16px; }
            .vr-event-card { padding: 56px 20px 42px; }
            .vr-map-frame, .vr-map-placeholder { height: 320px; min-height: 320px; }
            .vr-map-footer { flex-direction: column; align-items: stretch; }
            .vr-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .vr-gallery-item, .vr-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: auto; aspect-ratio: 4/5; }
            .vr-story-photo { aspect-ratio: 4/5; }
            .vr-rsvp-layout { gap: 22px; }
            .vr-rsvp-copy, .vr-form-card { padding: 26px 20px; border-radius: 28px; }
            .vr-summary-grid { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }


        /* =====================================================
           VINTAGE ROMANCE FINAL CLEAN OVERRIDE
           Membersihkan konflik CSS lama, menyatukan tema, foto, teks, sidebar
        ===================================================== */

        body {
            background:
                radial-gradient(circle at 12% 8%, var(--vr-glow), transparent 32%),
                radial-gradient(circle at 88% 8%, color-mix(in srgb, var(--vr-gold) 16%, transparent), transparent 30%),
                linear-gradient(180deg, var(--vr-dark) 0%, var(--vr-maroon) 44%, var(--vr-dark) 100%) !important;
        }

        .vr-book {
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 92%, #000), color-mix(in srgb, var(--vr-dark) 96%, #000)),
                url("{{ asset('assets/vintage-romance/vr-maroon-paper-texture.png') }}") center/cover repeat,
                var(--vr-maroon) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 36%, transparent) !important;
        }

        .vr-hero {
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 76%, transparent), color-mix(in srgb, var(--vr-dark) 84%, transparent)),
                url("{{ asset('assets/vintage-romance/vr-palace-door-soft.png') }}") center/cover no-repeat,
                var(--vr-maroon) !important;
        }

        .vr-title,
        .vr-hero-title,
        .vr-person-name,
        .vr-count-title,
        .vr-event-card h3,
        .vr-invitation-card h2,
        .vr-rsvp-copy h3,
        .vr-closing-card h2,
        .vr-gift-title,
        .vr-summary-grid b,
        .vr-map-title,
        #couple > h2,
        #story > h2,
        #galeri > h2,
        #gift > h2,
        #acara > h2,
        #rsvp > h2 {
            color: var(--vr-gold) !important;
            -webkit-text-fill-color: var(--vr-gold) !important;
            background: none !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.18),
                0 2px 0 rgba(58, 10, 20, .72),
                0 8px 22px rgba(0, 0, 0, .34),
                0 0 18px color-mix(in srgb, var(--vr-gold) 26%, transparent) !important;
        }

        .vr-hero-title {
            width: min(100%, 860px) !important;
            margin-left: auto !important;
            margin-right: auto !important;
            font-size: clamp(2.45rem, 5vw, 4.65rem) !important;
            line-height: .96 !important;
            letter-spacing: .035em !important;
            font-weight: 700 !important;
            text-transform: none !important;
            gap: 8px !important;
        }

        .vr-hero-name {
            display: block !important;
            max-width: 100% !important;
            line-height: .96 !important;
            overflow-wrap: break-word !important;
            word-break: normal !important;
            white-space: normal !important;
            text-align: center !important;
        }

        .vr-hero-and,
        .vr-script {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            background: none !important;
            text-shadow:
                0 1px 0 rgba(58, 10, 20, .62),
                0 6px 16px rgba(0, 0, 0, .25) !important;
        }

        .vr-hero-kicker,
        .vr-hero-date,
        .vr-count-label,
        .vr-date-side,
        .vr-event-line,
        .vr-event-place,
        .vr-event-address,
        .vr-note {
            color: color-mix(in srgb, var(--vr-cream) 94%, white) !important;
            text-shadow: 0 2px 12px rgba(0,0,0,.34) !important;
        }

        .vr-hero-inner {
            position: relative !important;
            z-index: 6 !important;
            isolation: isolate !important;
        }

        .vr-hero-inner::before {
            content: "" !important;
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            width: min(92vw, 820px) !important;
            height: 66% !important;
            transform: translate(-50%, -50%) !important;
            z-index: -1 !important;
            border-radius: 999px !important;
            pointer-events: none !important;
            background: radial-gradient(circle, color-mix(in srgb, var(--vr-dark) 66%, transparent) 0%, color-mix(in srgb, var(--vr-dark) 38%, transparent) 42%, transparent 74%) !important;
            filter: blur(2px) !important;
        }

        .vr-label {
            color: var(--vr-cream) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 46%, transparent) !important;
            background: color-mix(in srgb, var(--vr-dark) 24%, rgba(255,255,255,.12)) !important;
        }

        .vr-label::before,
        .vr-label::after {
            background: var(--vr-gold) !important;
            opacity: .86 !important;
        }

        .vr-btn,
        .vr-copy-btn {
            color: color-mix(in srgb, var(--vr-dark) 88%, #000) !important;
            background: linear-gradient(135deg, #fffbe8 0%, var(--vr-gold) 38%, var(--vr-gold-2) 72%, #bf8730 100%) !important;
            box-shadow:
                0 16px 38px rgba(0,0,0,.24),
                inset 0 1px 0 rgba(255,255,255,.45) !important;
        }

        .vr-btn.light {
            color: var(--vr-cream) !important;
            background: rgba(255,255,255,.10) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 42%, transparent) !important;
        }

        /* Foto couple: hanya satu sistem, tidak ada width/height gepeng */
        .vr-person-photo-wrap {
            position: relative !important;
            z-index: 5 !important;
            width: clamp(300px, 27vw, 410px) !important;
            aspect-ratio: 1 / 1 !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            overflow: visible !important;
        }

        .vr-person-photo-wrap::before {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 4 !important;
            background: url("{{ asset('assets/vintage-romance/vr-oval-frame-gold.png') }}") center center / contain no-repeat !important;
            pointer-events: none !important;
            filter:
                drop-shadow(0 18px 28px rgba(0,0,0,.30))
                drop-shadow(0 0 12px rgba(255, 221, 120, .18)) !important;
        }

        .vr-person-photo-wrap::after { display: none !important; }

        .vr-photo-circle {
            position: absolute !important;
            left: 50% !important;
            top: 49.2% !important;
            z-index: 2 !important;
            width: 58% !important;
            height: 58% !important;
            transform: translate(-50%, -50%) !important;
            border-radius: 50% !important;
            overflow: hidden !important;
            background: #4f1529 !important;
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.10),
                0 8px 20px rgba(0,0,0,.18) !important;
        }

        .vr-photo-circle img,
        .vr-photo-circle .vr-person-initial {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
            object-fit: cover !important;
            object-position: center center !important;
            border-radius: 50% !important;
            background: #4f1529 !important;
        }

        .vr-photo-circle .vr-person-initial {
            display: grid !important;
            place-items: center !important;
            color: var(--vr-gold) !important;
            font-family: Georgia, "Times New Roman", serif !important;
            font-size: 4rem !important;
            font-weight: 700 !important;
        }

        .vr-person-content {
            position: relative !important;
            z-index: 6 !important;
            margin-top: -8px !important;
        }

        .vr-person-name {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            background: none !important;
            font-size: clamp(2.1rem, 4vw, 3.4rem) !important;
            line-height: 1.04 !important;
            font-weight: 600 !important;
            text-shadow:
                0 2px 0 rgba(58, 10, 20, .72),
                0 8px 22px rgba(0,0,0,.34) !important;
        }

        .vr-floating-actions {
            position: fixed !important;
            right: 0 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 99999 !important;
            display: grid !important;
            gap: 8px !important;
            padding: 8px 0 8px 8px !important;
            border-radius: 18px 0 0 18px !important;
            background: rgba(255,255,255,.72) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 30%, transparent) !important;
            border-right: 0 !important;
            box-shadow: 0 18px 42px rgba(25, 6, 13, .18) !important;
            backdrop-filter: blur(14px) !important;
        }

        .vr-floating-actions a,
        .vr-floating-actions button {
            width: 42px !important;
            height: 42px !important;
            border: 0 !important;
            border-radius: 16px 0 0 16px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            cursor: pointer !important;
            background: rgba(255,255,255,.96) !important;
            box-shadow: 0 10px 22px rgba(25, 6, 13, .12) !important;
            transition: transform .25s ease, background .25s ease !important;
        }

        .vr-floating-actions a:hover,
        .vr-floating-actions button:hover { transform: translateX(-3px) !important; }
        .vr-floating-actions button.is-active { background: color-mix(in srgb, var(--vr-gold) 42%, white) !important; }
        .vr-floating-actions img { width: 22px !important; height: 22px !important; object-fit: contain !important; }

        @media (min-width: 1440px) {
            .vr-person-photo-wrap { width: clamp(360px, 23vw, 470px) !important; }
            .vr-photo-circle { width: 58% !important; height: 58% !important; top: 49.2% !important; }
            .vr-person-content { margin-top: -12px !important; }
        }

        @media (max-width: 980px) {
            .vr-person-photo-wrap { width: clamp(320px, 62vw, 430px) !important; }
            .vr-photo-circle { width: 57% !important; height: 57% !important; top: 49.2% !important; }
            .vr-person-content { margin-top: -8px !important; }
        }

        @media (max-width: 640px) {
            .vr-hero-title {
                font-size: clamp(2rem, 8.8vw, 3.25rem) !important;
                letter-spacing: .025em !important;
                line-height: .98 !important;
            }
            .vr-person-photo-wrap { width: clamp(280px, 88vw, 370px) !important; }
            .vr-photo-circle { width: 56% !important; height: 56% !important; top: 49.1% !important; }
            .vr-person-content { margin-top: -4px !important; }
            .vr-floating-actions a,
            .vr-floating-actions button { width: 40px !important; height: 40px !important; }
            .vr-floating-actions img { width: 21px !important; height: 21px !important; }
        }

        @media (max-width: 390px) {
            .vr-person-photo-wrap { width: clamp(260px, 90vw, 330px) !important; }
            .vr-photo-circle { width: 56% !important; height: 56% !important; }
        }


        /* =====================================================
           VINTAGE ROMANCE - MINIMAL LUXURY REDESIGN
           Rombak visual agar lebih elegan, bersih, dan tidak ramai.
           Letakkan blok ini paling akhir agar menimpa CSS lama.
        ===================================================== */

        body {
            background:
                radial-gradient(circle at 50% -8%, var(--vr-glow), transparent 34%),
                linear-gradient(180deg, var(--vr-dark) 0%, var(--vr-maroon) 44%, var(--vr-dark) 100%) !important;
        }

        .vr-shell {
            width: min(100%, 1180px) !important;
            padding: 22px !important;
        }

        .vr-book {
            border-radius: 34px !important;
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 94%, #000), color-mix(in srgb, var(--vr-dark) 96%, #000)),
                url("{{ asset('assets/vintage-romance/vr-maroon-paper-texture.png') }}") center / cover repeat,
                var(--vr-maroon) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 28%, transparent) !important;
            box-shadow: 0 42px 120px rgba(14, 3, 10, .48) !important;
        }

        .vr-book::before {
            opacity: .38 !important;
            background:
                linear-gradient(90deg, rgba(255,255,255,.026) 1px, transparent 1px) 0 0 / 74px 74px,
                linear-gradient(0deg, rgba(255,255,255,.020) 1px, transparent 1px) 0 0 / 74px 74px,
                radial-gradient(circle at 50% 6%, rgba(255,255,255,.055), transparent 34%) !important;
        }

        .vr-book::after {
            opacity: .20 !important;
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 18%, transparent), transparent 34%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center / cover repeat !important;
            mix-blend-mode: screen !important;
        }

        .vr-page {
            padding: 108px 74px !important;
        }

        .vr-page.slim,
        .vr-page.compact {
            padding-top: 84px !important;
            padding-bottom: 84px !important;
        }

        .vr-page::before {
            opacity: .16 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / min(82%, 940px) auto no-repeat !important;
        }

        .vr-page::after {
            opacity: .22 !important;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.075), transparent 42%),
                linear-gradient(180deg, rgba(255,255,255,.03), transparent 42%, rgba(0,0,0,.08)) !important;
        }

        .vr-label {
            margin-bottom: 18px !important;
            padding: 9px 20px !important;
            border-radius: 999px !important;
            color: var(--vr-cream) !important;
            background: rgba(255,255,255,.075) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 38%, transparent) !important;
            box-shadow: 0 12px 28px rgba(0,0,0,.14) !important;
            font-size: 11px !important;
            font-weight: 850 !important;
            letter-spacing: .19em !important;
        }

        .vr-label::before,
        .vr-label::after {
            width: 34px !important;
            background: var(--vr-gold) !important;
            opacity: .76 !important;
        }

        .vr-title,
        .vr-hero-title,
        .vr-count-title,
        .vr-event-card h3,
        .vr-invitation-card h2,
        .vr-rsvp-copy h3,
        .vr-closing-card h2,
        #couple > h2,
        #story > h2,
        #galeri > h2,
        #gift > h2,
        #acara > h2,
        #rsvp > h2 {
            color: var(--vr-gold) !important;
            -webkit-text-fill-color: var(--vr-gold) !important;
            background: none !important;
            font-family: Georgia, "Times New Roman", serif !important;
            font-weight: 500 !important;
            letter-spacing: .018em !important;
            line-height: .98 !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.13),
                0 2px 0 rgba(52, 10, 20, .62),
                0 12px 30px rgba(0,0,0,.34) !important;
        }

        .vr-note,
        .vr-hero-kicker,
        .vr-hero-date,
        .vr-count-label,
        .vr-date-side,
        .vr-event-line,
        .vr-event-place,
        .vr-event-address {
            color: color-mix(in srgb, var(--vr-cream) 86%, transparent) !important;
            text-shadow: 0 2px 12px rgba(0,0,0,.26) !important;
        }

        .vr-btn,
        .vr-copy-btn {
            color: color-mix(in srgb, var(--vr-dark) 88%, #000) !important;
            background: linear-gradient(135deg, #fffbe8 0%, var(--vr-gold) 42%, var(--vr-gold-2) 100%) !important;
            box-shadow:
                0 16px 38px rgba(0,0,0,.24),
                inset 0 1px 0 rgba(255,255,255,.48) !important;
            border: 0 !important;
        }

        .vr-btn.light {
            color: var(--vr-cream) !important;
            background: rgba(255,255,255,.08) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 34%, transparent) !important;
        }

        /* HERO lebih tenang: tanpa floral samping dan tanpa kolom yang ramai */
        .vr-hero {
            min-height: 920px !important;
            padding: 0 74px !important;
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--vr-dark) 42%, transparent), color-mix(in srgb, var(--vr-dark) 76%, transparent)),
                url("{{ asset('assets/vintage-romance/vr-palace-door-soft.png') }}") center / cover no-repeat,
                var(--vr-maroon) !important;
        }

        .vr-hero::before {
            opacity: .68 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / min(88%, 760px) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 58px / 210px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / min(92%, 980px) auto no-repeat !important;
        }

        .vr-hero::after {
            opacity: .24 !important;
            background: radial-gradient(circle at 50% 48%, color-mix(in srgb, var(--vr-gold) 16%, transparent), transparent 42%) !important;
        }

        .vr-hero-inner {
            width: min(100%, 720px) !important;
            padding: 265px 0 220px !important;
        }

        .vr-hero-inner::before {
            height: 56% !important;
            background: radial-gradient(circle, color-mix(in srgb, var(--vr-dark) 64%, transparent) 0%, color-mix(in srgb, var(--vr-dark) 28%, transparent) 46%, transparent 76%) !important;
            filter: blur(3px) !important;
        }

        .vr-hero-title {
            width: min(100%, 760px) !important;
            font-size: clamp(2.75rem, 5.3vw, 5rem) !important;
            line-height: .96 !important;
            letter-spacing: .035em !important;
            font-weight: 650 !important;
            text-transform: none !important;
            gap: 10px !important;
        }

        .vr-hero-name {
            line-height: .96 !important;
            white-space: normal !important;
            word-break: normal !important;
            overflow-wrap: break-word !important;
        }

        .vr-hero-and,
        .vr-script {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            background: none !important;
            text-shadow:
                0 1px 0 rgba(58, 10, 20, .62),
                0 6px 16px rgba(0, 0, 0, .25) !important;
        }

        /* Couple: ganti gaya frame ramai menjadi avatar lingkaran bersih */
        .vr-couple::before {
            opacity: .16 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / 70% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 78% auto no-repeat !important;
        }

        .vr-couple-stage {
            width: min(100%, 920px) !important;
            margin-top: 48px !important;
            gap: 24px !important;
        }

        .vr-person-card {
            min-height: 520px !important;
            padding: 44px 30px 42px !important;
            border-radius: 34px !important;
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 72%, rgba(255,255,255,.08)), color-mix(in srgb, var(--vr-dark) 72%, rgba(255,255,255,.08))) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 32%, transparent) !important;
            box-shadow: 0 28px 78px rgba(0,0,0,.22) !important;
        }

        .vr-person-card::before {
            opacity: .26 !important;
            inset: auto 0 0 !important;
            height: 150px !important;
            background: url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 118% auto no-repeat !important;
        }

        .vr-person-photo-wrap {
            position: relative !important;
            z-index: 4 !important;
            width: clamp(220px, 20vw, 300px) !important;
            aspect-ratio: 1 / 1 !important;
            margin: 0 auto !important;
            padding: 10px !important;
            border-radius: 50% !important;
            background:
                linear-gradient(145deg, #fff9df 0%, var(--vr-gold) 28%, var(--vr-gold-2) 68%, #8c5b18 100%) !important;
            box-shadow:
                0 22px 55px rgba(0,0,0,.30),
                inset 0 1px 0 rgba(255,255,255,.52) !important;
            overflow: visible !important;
        }

        .vr-person-photo-wrap::before,
        .vr-person-photo-wrap::after {
            display: none !important;
        }

        .vr-photo-circle {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            z-index: 2 !important;
            width: 100% !important;
            height: 100% !important;
            transform: none !important;
            border-radius: 50% !important;
            overflow: hidden !important;
            background: var(--vr-dark) !important;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.18) !important;
        }

        .vr-photo-circle img,
        .vr-photo-circle .vr-person-initial,
        .vr-person-photo-wrap img,
        .vr-person-initial {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
            object-fit: cover !important;
            object-position: center center !important;
            border-radius: 50% !important;
            background: var(--vr-dark) !important;
            position: static !important;
            transform: none !important;
            aspect-ratio: auto !important;
        }

        .vr-photo-circle .vr-person-initial,
        .vr-person-initial {
            display: grid !important;
            place-items: center !important;
            color: var(--vr-gold) !important;
            font-family: Georgia, "Times New Roman", serif !important;
            font-size: 4rem !important;
            font-weight: 700 !important;
        }

        .vr-person-content {
            margin-top: 28px !important;
        }

        .vr-person-name {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            font-size: clamp(2rem, 3.5vw, 3.25rem) !important;
            line-height: 1.06 !important;
            font-weight: 520 !important;
            text-shadow:
                0 2px 0 rgba(58, 10, 20, .65),
                0 8px 22px rgba(0,0,0,.32) !important;
        }

        .vr-person-family {
            color: color-mix(in srgb, var(--vr-cream) 82%, transparent) !important;
        }

        /* Kartu section lebih modern dan tidak terlalu ornamen */
        .vr-invitation-card,
        .vr-count-panel,
        .vr-event-card,
        .vr-rsvp-copy {
            border-radius: 34px !important;
            background: color-mix(in srgb, var(--vr-dark) 58%, rgba(255,255,255,.08)) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 28%, transparent) !important;
            box-shadow: 0 28px 80px rgba(0,0,0,.18) !important;
            backdrop-filter: blur(8px) !important;
        }

        .vr-event-card::before {
            inset: 18px !important;
            border-radius: 26px !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 22%, transparent) !important;
        }

        .vr-save-date::before {
            opacity: .52 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-stage-curtain.png') }}") center top / min(96%, 1000px) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-carriage-gold.png') }}") center 24% / 170px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / min(92%, 980px) auto no-repeat !important;
        }

        .vr-gallery-item,
        .vr-story-card,
        .vr-gift-card,
        .vr-form-card {
            border-radius: 28px !important;
            box-shadow: 0 20px 58px rgba(0,0,0,.16) !important;
        }

        .vr-floating-actions {
            background: rgba(255,255,255,.74) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 30%, transparent) !important;
        }

        @media (min-width: 1440px) {
            .vr-person-photo-wrap { width: clamp(250px, 18vw, 330px) !important; }
        }

        @media (max-width: 980px) {
            .vr-shell { padding: 14px !important; }
            .vr-page { padding: 92px 38px !important; }
            .vr-hero { min-height: 860px !important; padding: 0 38px !important; }
            .vr-hero::before {
                background:
                    url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / 118% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 42px / 190px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 126% auto no-repeat !important;
            }
            .vr-hero-inner { padding-top: 235px !important; padding-bottom: 210px !important; }
        }

        @media (max-width: 640px) {
            .vr-shell { padding: 0 !important; }
            .vr-book { border-radius: 0 !important; border-left: 0 !important; border-right: 0 !important; box-shadow: none !important; }
            .vr-page,
            .vr-page.slim,
            .vr-page.compact { padding: 76px 22px !important; }
            .vr-hero {
                min-height: 100svh !important;
                padding: 0 22px !important;
            }
            .vr-hero::before {
                opacity: .58 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / 150% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 18px / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 160% auto no-repeat !important;
            }
            .vr-hero-inner { padding-top: 205px !important; padding-bottom: 175px !important; }
            .vr-hero-title {
                font-size: clamp(2.25rem, 10vw, 3.55rem) !important;
                line-height: 1 !important;
                letter-spacing: .02em !important;
            }
            .vr-couple-stage { gap: 22px !important; }
            .vr-person-card {
                min-height: auto !important;
                padding: 36px 20px 42px !important;
                border-radius: 30px !important;
            }
            .vr-person-photo-wrap {
                width: clamp(210px, 68vw, 270px) !important;
            }
        }



        /* =====================================================
           VINTAGE ROMANCE FINAL ADJUSTMENT
           Disamakan alur UX-nya dengan Rustic Garden:
           - floating action putih/transparan
           - ornamen dikurangi agar elegan
           - foto mempelai stabil seperti Rustic Garden
           - typography gold lebih lembut
        ===================================================== */
        .vr-book::before { opacity: .24 !important; }
        .vr-book::after { opacity: .32 !important; }
        .vr-page::before { opacity: .24 !important; }
        .vr-page::after { opacity: .18 !important; }
        .vr-hero::before { opacity: .58 !important; }
        .vr-hero::after { opacity: .30 !important; }
        .vr-couple::before { opacity: .30 !important; }
        .vr-save-date::before { opacity: .42 !important; }

        .vr-floating-actions {
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(219,183,93,.22) !important;
            border-right: 0 !important;
            box-shadow: 0 18px 42px rgba(25,6,13,.15) !important;
            backdrop-filter: blur(14px) !important;
        }
        .vr-floating-actions a,
        .vr-floating-actions button {
            background: rgba(255,255,255,.96) !important;
            box-shadow: 0 10px 22px rgba(25,6,13,.12) !important;
        }
        .vr-floating-actions button.is-active {
            background: color-mix(in srgb, var(--vr-gold) 34%, white) !important;
        }

        .vr-title,
        .vr-hero-title,
        .vr-count-title,
        .vr-event-card h3,
        .vr-invitation-card h2,
        .vr-rsvp-copy h3,
        .vr-closing-card h2 {
            color: var(--vr-gold) !important;
            -webkit-text-fill-color: var(--vr-gold) !important;
            background: none !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.16),
                0 2px 0 rgba(55,12,24,.42),
                0 12px 28px rgba(0,0,0,.25) !important;
        }
        .vr-hero-title {
            font-size: clamp(2.7rem, 6.2vw, 5.2rem) !important;
            letter-spacing: .04em !important;
            line-height: .98 !important;
        }
        .vr-hero-and {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            text-shadow: 0 8px 20px rgba(0,0,0,.26) !important;
        }
        .vr-note,
        .vr-person-family,
        .vr-event-line,
        .vr-event-address {
            color: color-mix(in srgb, var(--vr-cream) 82%, transparent) !important;
        }

        .vr-couple-stage {
            width: min(100%, 1080px) !important;
            gap: 18px !important;
        }
        .vr-person-card {
            min-height: 540px !important;
            padding: 42px 32px 38px !important;
            border-radius: 999px 999px 42px 42px !important;
            background: linear-gradient(145deg, rgba(255,255,255,.10), rgba(75,18,38,.62)) !important;
            border: 1px solid rgba(219,183,93,.28) !important;
            box-shadow: 0 24px 72px rgba(0,0,0,.22) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }
        .vr-person-card::before {
            opacity: .34 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 118% auto no-repeat !important;
        }

        /* Foto mempelai dibuat stabil seperti pola Rustic Garden; tidak lagi bergantung pada posisi lubang PNG frame oval. */
        .vr-person-photo-wrap {
            position: relative !important;
            z-index: 5 !important;
            width: 255px !important;
            max-width: 100% !important;
            aspect-ratio: auto !important;
            margin: 0 auto !important;
            padding: 10px !important;
            border-radius: 999px 999px 30px 30px !important;
            background: rgba(255,248,220,.96) !important;
            box-shadow: 0 20px 52px rgba(0,0,0,.20) !important;
            overflow: visible !important;
        }
        .vr-person-photo-wrap::before,
        .vr-person-photo-wrap::after {
            display: none !important;
        }
        .vr-photo-circle {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            z-index: 2 !important;
            width: 100% !important;
            height: auto !important;
            aspect-ratio: 4 / 5 !important;
            transform: none !important;
            border-radius: 999px 999px 22px 22px !important;
            overflow: hidden !important;
            background: #4f1529 !important;
            box-shadow: none !important;
        }
        .vr-photo-circle img,
        .vr-photo-circle .vr-person-initial {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
            object-fit: cover !important;
            object-position: center center !important;
            border-radius: inherit !important;
        }
        .vr-person-content {
            margin-top: 26px !important;
        }
        .vr-person-name {
            color: var(--vr-cream) !important;
            -webkit-text-fill-color: var(--vr-cream) !important;
            font-size: clamp(2rem, 3.5vw, 3.4rem) !important;
            line-height: 1.04 !important;
            text-shadow: 0 12px 28px rgba(0,0,0,.28) !important;
        }
        .vr-person-subtitle {
            background: color-mix(in srgb, var(--vr-gold) 88%, white) !important;
            color: #3b1320 !important;
        }

        @media (max-width: 980px) {
            .vr-person-photo-wrap { width: min(250px, 70vw) !important; }
        }
        @media (max-width: 640px) {
            .vr-hero-title { font-size: clamp(2.25rem, 10vw, 3.8rem) !important; }
            .vr-person-photo-wrap { width: min(230px, 70vw) !important; }
            .vr-person-card { min-height: 500px !important; padding: 34px 22px 36px !important; }
        }


        /* =====================================================
           FINAL LUXURY BACKGROUND REDESIGN - Vintage Romance
           Tujuan:
           - background utama tidak polos
           - ornamen mewah namun tidak terlalu ramai
           - aman mobile sampai desktop besar
        ===================================================== */

        body {
            background:
                radial-gradient(circle at 12% 4%, color-mix(in srgb, var(--vr-gold) 18%, transparent), transparent 28%),
                radial-gradient(circle at 88% 10%, color-mix(in srgb, var(--vr-gold-2) 14%, transparent), transparent 30%),
                radial-gradient(circle at 50% 92%, color-mix(in srgb, var(--vr-soft) 40%, transparent), transparent 38%),
                linear-gradient(180deg, var(--vr-dark) 0%, var(--vr-maroon) 36%, var(--vr-deep) 72%, var(--vr-dark) 100%) !important;
        }

        .vr-book {
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 16%, transparent), transparent 34%),
                radial-gradient(circle at 16% 26%, color-mix(in srgb, var(--vr-gold-2) 10%, transparent), transparent 28%),
                radial-gradient(circle at 84% 38%, color-mix(in srgb, var(--vr-cream) 8%, transparent), transparent 28%),
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 88%, #000) 0%, color-mix(in srgb, var(--vr-deep) 92%, #000) 54%, color-mix(in srgb, var(--vr-dark) 96%, #000) 100%),
                url("{{ asset('assets/vintage-romance/vr-maroon-paper-texture.png') }}") center / cover repeat,
                var(--vr-maroon) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 32%, transparent) !important;
            box-shadow:
                0 44px 140px rgba(25, 6, 13, .46),
                inset 0 0 0 1px rgba(255,255,255,.035) !important;
        }

        .vr-book::before {
            opacity: .50 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold.png') }}") left top / min(280px, 28vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold-mirror.png') }}") right top / min(280px, 28vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 12% / min(260px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 18% / min(260px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 52% / min(230px, 23vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 58% / min(230px, 23vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center 101% / 108% auto no-repeat,
                linear-gradient(90deg, rgba(255,255,255,.030) 1px, transparent 1px) 0 0 / 48px 48px,
                linear-gradient(0deg, rgba(255,255,255,.022) 1px, transparent 1px) 0 0 / 48px 48px !important;
        }

        .vr-book::after {
            opacity: .62 !important;
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 24%, transparent), transparent 28%),
                radial-gradient(circle at 50% 44%, color-mix(in srgb, var(--vr-cream) 9%, transparent), transparent 34%),
                radial-gradient(circle at 12% 78%, color-mix(in srgb, var(--vr-gold-2) 10%, transparent), transparent 28%),
                radial-gradient(circle at 88% 88%, color-mix(in srgb, var(--vr-gold) 10%, transparent), transparent 30%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center top / cover repeat !important;
            mix-blend-mode: screen !important;
        }

        .vr-page {
            background:
                linear-gradient(180deg, rgba(255,255,255,.025), transparent 32%, rgba(0,0,0,.07)),
                radial-gradient(circle at 50% 12%, rgba(255,255,255,.055), transparent 30%) !important;
        }

        .vr-page::before {
            opacity: .34 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / min(940px, 86%) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 108% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold.png') }}") left 20px top 20px / 120px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold-mirror.png') }}") right 20px top 20px / 120px auto no-repeat !important;
        }

        .vr-page::after {
            opacity: .50 !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.055) 0%, transparent 24%, rgba(0,0,0,.12) 100%),
                radial-gradient(circle at 50% 36%, rgba(255,245,210,.09), transparent 40%) !important;
        }

        .vr-hero {
            background:
                radial-gradient(circle at 50% 42%, rgba(255, 235, 180, .16), transparent 34%),
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 72%, transparent), color-mix(in srgb, var(--vr-dark) 76%, transparent)),
                url("{{ asset('assets/vintage-romance/vr-palace-door-soft.png') }}") center / cover no-repeat,
                var(--vr-maroon) !important;
        }

        .vr-hero::before {
            opacity: .74 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / 88% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 3% / min(260px, 28vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left center / min(240px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right center / min(240px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 108% auto no-repeat !important;
        }

        .vr-hero::after {
            opacity: .48 !important;
            background:
                radial-gradient(circle at 50% 46%, rgba(255,244,203,.18), transparent 32%),
                radial-gradient(circle at 50% 80%, rgba(255,230,178,.10), transparent 30%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center / cover no-repeat !important;
        }

        .vr-invitation-card,
        .vr-count-panel,
        .vr-rsvp-copy,
        .vr-message-card {
            background:
                linear-gradient(145deg, rgba(255,255,255,.105), rgba(255,255,255,.045)),
                color-mix(in srgb, var(--vr-maroon) 54%, transparent) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 34%, transparent) !important;
            box-shadow:
                0 26px 72px rgba(0,0,0,.24),
                inset 0 1px 0 rgba(255,255,255,.08) !important;
            backdrop-filter: blur(12px) !important;
        }

        .vr-person-card,
        .vr-event-card {
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 10%, transparent), transparent 32%),
                linear-gradient(180deg, color-mix(in srgb, var(--vr-maroon) 78%, transparent), color-mix(in srgb, var(--vr-dark) 74%, transparent)) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 40%, transparent) !important;
        }

        .vr-title,
        .vr-hero-title,
        .vr-count-title,
        .vr-event-card h3,
        .vr-invitation-card h2,
        .vr-rsvp-copy h3,
        .vr-closing-card h2 {
            color: var(--vr-gold) !important;
            -webkit-text-fill-color: var(--vr-gold) !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.16),
                0 2px 0 rgba(45, 6, 18, .72),
                0 12px 30px rgba(0,0,0,.35) !important;
        }

        .vr-note,
        .vr-event-line,
        .vr-event-address,
        .vr-person-family {
            color: color-mix(in srgb, var(--vr-cream) 84%, transparent) !important;
        }

        @media (max-width: 980px) {
            .vr-book::before {
                opacity: .42 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 14% / 180px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 58% / 180px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 135% auto no-repeat,
                    linear-gradient(90deg, rgba(255,255,255,.024) 1px, transparent 1px) 0 0 / 38px 38px,
                    linear-gradient(0deg, rgba(255,255,255,.018) 1px, transparent 1px) 0 0 / 38px 38px !important;
            }

            .vr-page::before {
                opacity: .28 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / 96% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 130% auto no-repeat !important;
            }
        }

        @media (max-width: 640px) {
            .vr-book {
                border-radius: 0 !important;
            }

            .vr-book::before {
                opacity: .38 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 8% / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 34% / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 155% auto no-repeat,
                    linear-gradient(90deg, rgba(255,255,255,.022) 1px, transparent 1px) 0 0 / 34px 34px !important;
            }

            .vr-page::before {
                opacity: .24 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / 112% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 155% auto no-repeat !important;
            }

            .vr-hero::before {
                opacity: .64 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / 136% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 2% / 170px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left center / 150px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right center / 150px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 150% auto no-repeat !important;
            }
        }



        /* =====================================================
           FINAL DARK THEME BACKGROUND OVERRIDE
           Background lebih tua/gelap dan mengikuti 6 pilihan tema warna.
           Letakkan paling akhir agar menimpa semua background lama.
        ===================================================== */

        body {
            color: var(--vr-cream) !important;
            background:
                radial-gradient(circle at 50% -10%, var(--vr-glow), transparent 30%),
                radial-gradient(circle at 12% 18%, color-mix(in srgb, var(--vr-soft) 26%, transparent), transparent 28%),
                radial-gradient(circle at 88% 22%, color-mix(in srgb, var(--vr-gold-2) 12%, transparent), transparent 26%),
                linear-gradient(180deg,
                    color-mix(in srgb, var(--vr-dark) 96%, #000) 0%,
                    color-mix(in srgb, var(--vr-deep) 94%, #000) 38%,
                    color-mix(in srgb, var(--vr-maroon) 90%, #000) 62%,
                    color-mix(in srgb, var(--vr-dark) 98%, #000) 100%) !important;
        }

        .vr-shell {
            background: transparent !important;
        }

        .vr-book {
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 12%, transparent), transparent 30%),
                radial-gradient(circle at 14% 24%, color-mix(in srgb, var(--vr-soft) 22%, transparent), transparent 28%),
                radial-gradient(circle at 86% 34%, color-mix(in srgb, var(--vr-gold-2) 10%, transparent), transparent 28%),
                linear-gradient(180deg,
                    color-mix(in srgb, var(--vr-deep) 88%, #000) 0%,
                    color-mix(in srgb, var(--vr-maroon) 82%, #000) 42%,
                    color-mix(in srgb, var(--vr-dark) 96%, #000) 100%),
                url("{{ asset('assets/vintage-romance/vr-maroon-paper-texture.png') }}") center / cover repeat,
                var(--vr-dark) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 30%, transparent) !important;
            box-shadow:
                0 46px 150px rgba(0, 0, 0, .52),
                inset 0 0 0 1px rgba(255,255,255,.025),
                inset 0 0 120px rgba(0,0,0,.20) !important;
        }

        .vr-book::before {
            opacity: .30 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold.png') }}") left top / min(260px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold-mirror.png') }}") right top / min(260px, 26vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 13% / min(230px, 23vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 20% / min(230px, 23vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 58% / min(205px, 20vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 62% / min(205px, 20vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center 101% / 108% auto no-repeat,
                linear-gradient(90deg, rgba(255,255,255,.020) 1px, transparent 1px) 0 0 / 54px 54px,
                linear-gradient(0deg, rgba(255,255,255,.016) 1px, transparent 1px) 0 0 / 54px 54px !important;
        }

        .vr-book::after {
            opacity: .38 !important;
            background:
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--vr-gold) 16%, transparent), transparent 26%),
                radial-gradient(circle at 50% 48%, color-mix(in srgb, var(--vr-cream) 6%, transparent), transparent 38%),
                radial-gradient(circle at 14% 82%, color-mix(in srgb, var(--vr-gold-2) 7%, transparent), transparent 28%),
                radial-gradient(circle at 86% 88%, color-mix(in srgb, var(--vr-gold) 8%, transparent), transparent 30%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center top / cover repeat !important;
            mix-blend-mode: screen !important;
        }

        .vr-page {
            background:
                linear-gradient(180deg, rgba(255,255,255,.018), transparent 32%, rgba(0,0,0,.11)),
                radial-gradient(circle at 50% 12%, color-mix(in srgb, var(--vr-gold) 6%, transparent), transparent 30%) !important;
        }

        .vr-page::before {
            opacity: .20 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / min(900px, 84%) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 106% auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold.png') }}") left 18px top 18px / 106px auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-ornate-corner-gold-mirror.png') }}") right 18px top 18px / 106px auto no-repeat !important;
        }

        .vr-page::after {
            opacity: .34 !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.032) 0%, transparent 26%, rgba(0,0,0,.16) 100%),
                radial-gradient(circle at 50% 36%, color-mix(in srgb, var(--vr-gold) 8%, transparent), transparent 40%) !important;
        }

        .vr-hero {
            background:
                radial-gradient(circle at 50% 42%, color-mix(in srgb, var(--vr-gold) 12%, transparent), transparent 34%),
                linear-gradient(180deg, color-mix(in srgb, var(--vr-dark) 52%, transparent), color-mix(in srgb, var(--vr-dark) 82%, transparent)),
                url("{{ asset('assets/vintage-romance/vr-palace-door-soft.png') }}") center / cover no-repeat,
                var(--vr-dark) !important;
        }

        .vr-hero::before {
            opacity: .56 !important;
            background:
                url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / min(86%, 760px) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 54px / min(205px, 24vw) auto no-repeat,
                url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / min(94%, 1000px) auto no-repeat !important;
        }

        .vr-hero::after {
            opacity: .34 !important;
            background:
                radial-gradient(circle at 50% 46%, color-mix(in srgb, var(--vr-gold) 13%, transparent), transparent 36%),
                radial-gradient(circle at 50% 82%, color-mix(in srgb, var(--vr-gold-2) 7%, transparent), transparent 30%),
                url("{{ asset('assets/vintage-romance/vr-gold-haze.png') }}") center / cover no-repeat !important;
        }

        .vr-invitation-card,
        .vr-count-panel,
        .vr-rsvp-copy,
        .vr-message-card,
        .vr-person-card,
        .vr-event-card {
            background:
                linear-gradient(145deg, rgba(255,255,255,.075), rgba(255,255,255,.030)),
                color-mix(in srgb, var(--vr-dark) 62%, var(--vr-maroon)) !important;
            border-color: color-mix(in srgb, var(--vr-gold) 30%, transparent) !important;
            box-shadow:
                0 28px 82px rgba(0,0,0,.26),
                inset 0 1px 0 rgba(255,255,255,.06) !important;
        }

        .vr-form-card,
        .vr-gift-card,
        .vr-story-card,
        .vr-gallery-item {
            background: color-mix(in srgb, var(--vr-cream) 92%, white) !important;
        }

        .vr-title,
        .vr-hero-title,
        .vr-count-title,
        .vr-event-card h3,
        .vr-invitation-card h2,
        .vr-rsvp-copy h3,
        .vr-closing-card h2,
        #couple > h2,
        #story > h2,
        #galeri > h2,
        #gift > h2,
        #acara > h2,
        #rsvp > h2 {
            color: var(--vr-gold) !important;
            -webkit-text-fill-color: var(--vr-gold) !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.12),
                0 2px 0 rgba(0,0,0,.52),
                0 12px 30px rgba(0,0,0,.42),
                0 0 16px color-mix(in srgb, var(--vr-gold) 18%, transparent) !important;
        }

        .vr-note,
        .vr-hero-kicker,
        .vr-hero-date,
        .vr-count-label,
        .vr-date-side,
        .vr-event-line,
        .vr-event-place,
        .vr-event-address,
        .vr-person-family {
            color: color-mix(in srgb, var(--vr-cream) 82%, transparent) !important;
            text-shadow: 0 2px 12px rgba(0,0,0,.38) !important;
        }

        @media (max-width: 980px) {
            .vr-book::before {
                opacity: .26 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 16% / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 58% / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 135% auto no-repeat,
                    linear-gradient(90deg, rgba(255,255,255,.018) 1px, transparent 1px) 0 0 / 38px 38px,
                    linear-gradient(0deg, rgba(255,255,255,.014) 1px, transparent 1px) 0 0 / 38px 38px !important;
            }

            .vr-page::before {
                opacity: .16 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / 96% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 130% auto no-repeat !important;
            }
        }

        @media (max-width: 640px) {
            .vr-book::before {
                opacity: .22 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-side-left.png') }}") left 8% / 128px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-side-right.png') }}") right 34% / 128px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 150% auto no-repeat,
                    linear-gradient(90deg, rgba(255,255,255,.014) 1px, transparent 1px) 0 0 / 34px 34px !important;
            }

            .vr-page::before {
                opacity: .14 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-floral-top-cream.png') }}") center top / 112% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 155% auto no-repeat !important;
            }

            .vr-hero::before {
                opacity: .48 !important;
                background:
                    url("{{ asset('assets/vintage-romance/vr-ornate-top-gold.png') }}") center top / 130% auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-chandelier-gold.png') }}") center 2% / 160px auto no-repeat,
                    url("{{ asset('assets/vintage-romance/vr-floral-bottom-cream.png') }}") center bottom / 145% auto no-repeat !important;
            }
        }

        /* =====================================================
        EVENT DATE DETAIL FIX
        Judul aman + tanggal sampai lebih rapi
        ===================================================== */

        .vr-date-box {
            width: min(100%, 560px) !important;
            margin: 34px auto 26px !important;
            padding: 22px 22px 20px !important;
            border-radius: 28px !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.075), rgba(255,255,255,.025)),
                color-mix(in srgb, var(--vr-dark) 56%, transparent) !important;
            border: 1px solid color-mix(in srgb, var(--vr-gold) 24%, transparent) !important;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.06),
                0 18px 44px rgba(0,0,0,.18) !important;
        }

        .vr-date-box .vr-date-split {
            margin: 0 auto 18px !important;
        }

        .vr-date-full,
        .vr-date-until {
            margin: 8px auto 0 !important;
            color: color-mix(in srgb, var(--vr-cream) 88%, transparent) !important;
            font-size: .98rem !important;
            font-weight: 700 !important;
            line-height: 1.65 !important;
            text-shadow: 0 2px 10px rgba(0,0,0,.28) !important;
        }

        .vr-date-full span,
        .vr-date-until span {
            display: inline-flex !important;
            min-width: 72px !important;
            margin-right: 8px !important;
            color: var(--vr-gold) !important;
            font-size: .72rem !important;
            font-weight: 950 !important;
            letter-spacing: .16em !important;
            text-transform: uppercase !important;
        }

        @media (max-width: 640px) {
            .vr-date-box {
                padding: 18px 16px !important;
                border-radius: 24px !important;
            }

            .vr-date-full,
            .vr-date-until {
                font-size: .92rem !important;
            }

            .vr-date-full span,
            .vr-date-until span {
                display: block !important;
                min-width: 0 !important;
                margin: 0 0 2px !important;
            }
        }

        /* =====================================================
        RSVP TITLE FIX
        Agar "Kehadiran Anda" tidak terpotong
        ===================================================== */

        .vr-rsvp-copy h3 {
            font-size: clamp(1.9rem, 3vw, 3rem) !important;
            line-height: 1.08 !important;
            letter-spacing: .02em !important;
            word-break: normal !important;
            overflow-wrap: normal !important;
            white-space: normal !important;
            max-width: 100% !important;
        }

        .vr-rsvp-copy .vr-title.responsive-text {
            overflow-wrap: normal !important;
            word-break: normal !important;
            white-space: normal !important;
        }

        @media (max-width: 640px) {
            .vr-rsvp-copy h3 {
                font-size: clamp(1.75rem, 8vw, 2.45rem) !important;
                line-height: 1.12 !important;
                text-align: center !important;
            }
        }
    </style>
</head>
@php
    $vrThemeKey = $invitation->theme_color ?: 'maroon';

    $vrThemes = [
        'maroon' => [
            'maroon' => '#3b0719',
            'dark' => '#15030b',
            'deep' => '#260512',
            'gold' => '#f7df9a',
            'gold2' => '#c9983f',
            'cream' => '#fff3d8',
            'soft' => '#5c1029',
            'glow' => 'rgba(214, 156, 61, .20)',
        ],
        'gold' => [
            'maroon' => '#3a2609',
            'dark' => '#160d02',
            'deep' => '#261806',
            'gold' => '#ffe8a8',
            'gold2' => '#bd842f',
            'cream' => '#fff3d2',
            'soft' => '#5a3b12',
            'glow' => 'rgba(229, 170, 65, .22)',
        ],
        'emerald' => [
            'maroon' => '#0b3027',
            'dark' => '#03110d',
            'deep' => '#061f19',
            'gold' => '#f1d88f',
            'gold2' => '#b99a45',
            'cream' => '#eef9ed',
            'soft' => '#124b3c',
            'glow' => 'rgba(203, 181, 95, .18)',
        ],
        'navy' => [
            'maroon' => '#0b203f',
            'dark' => '#030916',
            'deep' => '#071630',
            'gold' => '#f4dc96',
            'gold2' => '#b89645',
            'cream' => '#eef5ff',
            'soft' => '#12335f',
            'glow' => 'rgba(205, 178, 95, .18)',
        ],
        'rose' => [
            'maroon' => '#4d1630',
            'dark' => '#190611',
            'deep' => '#320c20',
            'gold' => '#f8dda0',
            'gold2' => '#c28d44',
            'cream' => '#fff0ea',
            'soft' => '#6b2341',
            'glow' => 'rgba(220, 150, 88, .20)',
        ],
        'slate' => [
            'maroon' => '#272b31',
            'dark' => '#0c0e12',
            'deep' => '#1a1e24',
            'gold' => '#ead394',
            'gold2' => '#b49a55',
            'cream' => '#eef1f5',
            'soft' => '#3d434c',
            'glow' => 'rgba(200, 178, 108, .17)',
        ],
    ];

    $vrTheme = $vrThemes[$vrThemeKey] ?? $vrThemes['maroon'];
@endphp
<body style="
    --vr-maroon: {{ $vrTheme['maroon'] }};
    --vr-dark: {{ $vrTheme['dark'] }};
    --vr-deep: {{ $vrTheme['deep'] }};
    --vr-gold: {{ $vrTheme['gold'] }};
    --vr-gold-2: {{ $vrTheme['gold2'] }};
    --vr-cream: {{ $vrTheme['cream'] }};
    --vr-soft: {{ $vrTheme['soft'] }};
    --vr-glow: {{ $vrTheme['glow'] }};
">
@php
    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = $invitation->title ?: 'William & Jessica';
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'William');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Jessica');
    $brideSubtitle = $bride->subtitle ?? 'Mempelai Pertama';
    $groomSubtitle = $groom->subtitle ?? 'Mempelai Kedua';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/vintage-romance/vr-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;

    $hasDifferentEndDate = !empty($invitation->event_end_date)
        && $endDate
        && $startDate
        && !$startDate->isSameDay($endDate);

    $endDayText = $endDate ? $endDate->translatedFormat('l') : null;
    $endMonthText = $endDate ? $endDate->translatedFormat('F') : null;
    $endYearText = $endDate ? $endDate->translatedFormat('Y') : null;
    $endDayNumber = $endDate ? $endDate->format('d') : null;

    $endDayText = $endDate ? $endDate->translatedFormat('l') : null;
    $endMonthText = $endDate ? $endDate->translatedFormat('F') : null;
    $endYearText = $endDate ? $endDate->translatedFormat('Y') : null;
    $endDayNumber = $endDate ? $endDate->format('d') : null;

    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Minggu';
    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '20 . 04 . 25';
    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : '20 April 2025';
    $eventDateRangeText = $eventDateText;
    if ($startDate && $endDate) {
        if ($startDate->isSameDay($endDate)) {
            $eventDateRangeText = $startDate->translatedFormat('d F Y');
        } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
            $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y');
        } elseif ($startDate->format('Y') === $endDate->format('Y')) {
            $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y');
        } else {
            $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
        }
    }
    $eventDateFullText = $startDate
        ? $startDate->translatedFormat('l, d F Y')
        : null;

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }
    $locationText = $invitation->location_name ?: 'Grand Hyatt Hotel Jakarta';
    $addressText = $invitation->address ?: 'Jl. M. H. Thamrin Kav. 28-30, Jakarta Pusat';
    $descriptionText = $invitation->description ?: 'By the grace and blessing of God, we request the honour of your presence at the wedding of:';

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;
    if (!$mapEmbedUrl && $mapOpenUrl && \Illuminate\Support\Str::contains($mapOpenUrl, 'google.com/maps')) {
        $mapEmbedUrl = $mapOpenUrl;
    }

    $shareUrl = route('invitation.public', $invitation->slug);
    $shareMessage = "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n" .
        "*" . ($invitation->event_name ?: 'The Wedding Of') . "*\n" .
        "*{$eventTitle}*\n\n" .
        "Tanggal: {$eventDateRangeText}\n";

    if ($eventTimeText) {
        $shareMessage .= "Waktu: {$eventTimeText}\n";
    }

    if ($locationText) {
        $shareMessage .= "Tempat: {$locationText}\n";
    }

    if ($addressText) {
        $shareMessage .= "Alamat: {$addressText}\n";
    }

    if ($mapOpenUrl) {
        $shareMessage .= "Maps: {$mapOpenUrl}\n";
    }

    $shareMessage .= "\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\n" .
        "Klik link undangan berikut:\n{$shareUrl}\n\n" .
        "Terima kasih.\nWassalamu'alaikum Wr. Wb.";
    $shareText = rawurlencode($shareMessage);

    // Musik default disamakan dengan template Rustic Garden.
    // Jika user tidak upload musik, tetap pakai public/assets/music/background1.mp3.
    $musicSrc = asset('assets/music/background1.mp3');

    if ($invitation->music_url) {
        $musicPath = $invitation->music_url;
        if (\Illuminate\Support\Str::startsWith($musicPath, ['http://', 'https://'])) {
            $musicSrc = $musicPath;
        } elseif (\Illuminate\Support\Str::startsWith($musicPath, ['/storage/', 'storage/'])) {
            $musicSrc = asset(ltrim($musicPath, '/'));
        } else {
            $musicSrc = asset('storage/' . ltrim($musicPath, '/'));
        }
    }

    $targetDateTime = $startDate ? $startDate->format('Y-m-d') . 'T' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00') : now()->addDays(30)->format('Y-m-d\TH:i:s');

    $googleCalendarUrl = '#';
    if ($startDate) {
        $startDateTime = \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00'));
        $endDateTime = $invitation->event_end_time ? \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s')) : $startDateTime->copy()->addHours(3);
        $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            . '&text=' . rawurlencode(($invitation->event_name ?: 'Wedding Event') . ' - ' . $eventTitle)
            . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
            . '&details=' . rawurlencode(trim($descriptionText . "\n\nLink Undangan: " . $shareUrl))
            . '&location=' . rawurlencode(trim($locationText . ' - ' . $addressText))
            . '&ctz=Asia/Jakarta';
    }

    $photos = $invitation->photos ?? collect();
    $galleryPhotos = $photos->take(6);
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $hadir = $messages->where('attendance_status', 'hadir')->sum('guest_count');
    $tidakHadir = $messages->where('attendance_status', 'tidak_hadir')->count();
    $ragu = $messages->where('attendance_status', 'ragu')->count();
@endphp

<div class="vr-shell">
    <main class="vr-book" id="top">
        <div class="vr-floating-actions" aria-label="Aksi undangan">
            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan" aria-label="Bagikan">
                <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan">
            </a>

            <button type="button" id="music-toggle" title="Music" aria-label="Music">
                <img
                    src="{{ asset('assets/icons/music-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                    alt="Music"
                >
            </button>

            <button type="button" id="scroll-toggle" title="Auto Scroll" aria-label="Auto Scroll">
                <img
                    src="{{ asset('assets/icons/scroll-off.png') }}"
                    data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                    data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                    alt="Auto Scroll"
                >
            </button>

            @if ($mapOpenUrl)
                <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi" aria-label="Lokasi">
                    <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi">
                </a>
            @endif
        </div>

        <audio id="invitation-music" src="{{ $musicSrc }}" preload="auto" loop></audio>

        <section id="opening" class="vr-page vr-hero">
            <div class="vr-hero-inner" data-reveal="zoom">
                <p class="vr-hero-kicker responsive-text">{{ strtoupper($invitation->event_name ?: 'The Wedding Of') }}</p>
                <h1 class="vr-title vr-hero-title responsive-text">
                    <span class="vr-hero-name">{{ $brideName }}</span>
                    <span class="vr-script vr-hero-and">&</span>
                    <span class="vr-hero-name">{{ $groomName }}</span>
                </h1>
                <p class="vr-hero-date responsive-text">{{ $eventDateShort }}</p>
                <div class="vr-hero-actions">
                    <a href="#couple" class="vr-btn">Buka Undangan</a>
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="vr-btn light">Simpan Tanggal</a>
                </div>
            </div>
        </section>

        <section id="couple" class="vr-page vr-couple">
            <p class="vr-label" data-reveal="zoom">Groom & Bride</p>
            <h2 class="vr-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6.2rem);">Groom & Bride</h2>
            <p class="vr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $descriptionText }}</p>

            <div class="vr-couple-stage">
                <article class="vr-person-card" data-reveal="left">
                    <div class="vr-person-photo-wrap">
                        <div class="vr-photo-circle">
                            @if ($bridePhoto)
                                <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                            @else
                                <div class="vr-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="vr-person-content">
                        <div class="vr-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                        <h3 class="vr-person-name responsive-text">{{ $brideName }}</h3>
                        <p class="vr-person-family responsive-text">{{ $bride->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>

                <article class="vr-person-card" data-reveal="right" style="--reveal-delay:.10s">
                    <div class="vr-person-photo-wrap">
                        <div class="vr-photo-circle">
                            @if ($groomPhoto)
                                <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                            @else
                                <div class="vr-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="vr-person-content">
                        <div class="vr-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                        <h3 class="vr-person-name responsive-text">{{ $groomName }}</h3>
                        <p class="vr-person-family responsive-text">{{ $groom->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="invitation" class="vr-page slim">
            <div class="vr-invitation-card" data-reveal="zoom">
                <p class="vr-label">With Love</p>
                <h2 class="vr-title vr-script responsive-text">Undangan Pernikahan</h2>
                <p class="vr-note responsive-text">Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu pada hari bahagia kami.</p>
            </div>
        </section>

        <section id="countdown" class="vr-page vr-save-date">
            <div class="vr-count-panel" data-reveal="zoom">
                <h2 class="vr-title vr-script vr-count-title responsive-text">Save The Date</h2>
                <div class="vr-count-grid" data-countdown="{{ $targetDateTime }}">
                    <div class="vr-count-card"><span class="vr-count-number" data-days>0</span><span class="vr-count-label">Days</span></div>
                    <div class="vr-count-card"><span class="vr-count-number" data-hours>0</span><span class="vr-count-label">Hours</span></div>
                    <div class="vr-count-card"><span class="vr-count-number" data-minutes>0</span><span class="vr-count-label">Minutes</span></div>
                    <div class="vr-count-card"><span class="vr-count-number" data-seconds>0</span><span class="vr-count-label">Seconds</span></div>
                </div>
                <div class="vr-count-actions"><a href="{{ $googleCalendarUrl }}" target="_blank" class="vr-btn">Add to Calendar</a></div>
            </div>
        </section>

        <section id="acara" class="vr-page">
            <p class="vr-label" data-reveal="zoom">Wedding Event</p>
            <h2 class="vr-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6.2rem);">Wedding Event</h2>
            <p class="vr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Acara pernikahan kami akan dilaksanakan pada:</p>

            <div class="vr-event-layout">
                <article class="vr-event-card" data-reveal="zoom">
                    <img src="{{ asset('assets/vintage-romance/vr-rings-icon-gold.png') }}" alt="Wedding Event" class="vr-event-icon">
                    <h3 class="vr-title responsive-text">Acara Pernikahan</h3>
                        <div class="vr-event-date-group">
                            <div class="vr-date-split">
                                <div class="vr-date-side">{{ $eventDayText }}</div>

                                <div class="vr-date-center">
                                    <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                                    <span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span>
                                </div>

                                <div class="vr-date-side">{{ $startDate ? $startDate->translatedFormat('F') : '' }}</div>
                            </div>

                            @if ($hasDifferentEndDate)
                                <div class="vr-date-end-label">Sampai</div>

                                <div class="vr-date-split vr-date-split-end">
                                    <div class="vr-date-side">{{ $endDayText }}</div>

                                    <div class="vr-date-center">
                                        <b>{{ $endDayNumber }}</b>
                                        <span>{{ $endYearText }}</span>
                                    </div>

                                    <div class="vr-date-side">{{ $endMonthText }}</div>
                                </div>
                            @endif
                        </div>

                        @if ($eventTimeText)
                            <p class="vr-event-line responsive-text">Pukul {{ $eventTimeText }}</p>
                        @endif
                    <p class="vr-event-place responsive-text">{{ $locationText }}</p>
                    <p class="vr-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>
                    <div class="vr-event-actions">
                        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="vr-btn">Google Maps</a>@endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="vr-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="vr-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe class="vr-map-frame" src="{{ $mapEmbedUrl }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="vr-map-placeholder"><div><div style="font-size:3rem">⌖</div><strong>{{ $locationText }}</strong></div></a>
                        @endif
                        <div class="vr-map-footer">
                            <div><p class="vr-map-title responsive-text">{{ $locationText }}</p><p class="vr-map-address responsive-text">{{ $addressText }}</p></div>
                            @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="vr-btn">Buka Maps</a>@endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section id="story" class="vr-page slim">
            <p class="vr-label" data-reveal="zoom">Love Story</p>
            <h2 class="vr-title vr-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Love Story</h2>
            <div class="vr-story-wrap">
                <article class="vr-story-card" data-reveal="left">
                    <img src="{{ $coverDisplay }}" alt="Love Story" class="vr-story-photo">
                    <div class="vr-story-content">
                        <h3 class="responsive-text">Awal Bertemu</h3>
                        <p class="responsive-text">Aku memandangmu tanpa perlu menatap, aku mendengar tanpa alat, aku menemui tanpa perlu hadir. Karena kini kumiliki segalanya.</p>
                    </div>
                </article>
            </div>
        </section>

        @if ($galleryPhotos->count())
            <section id="galeri" class="vr-page">
                <p class="vr-label" data-reveal="zoom">Our Gallery</p>
                <h2 class="vr-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Precious Moment</h2>
                <div class="vr-gallery-grid">
                    @foreach ($galleryPhotos as $photo)
                        @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp
                        @if ($src)
                            <a href="{{ $src }}" target="_blank" class="vr-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s"><img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}"></a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($gifts->count())
            <section id="gift" class="vr-page slim">
                <p class="vr-label" data-reveal="zoom">Wedding Gift</p>
                <h2 class="vr-title vr-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Tanda Kasih</h2>
                <p class="vr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                <div class="vr-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                    @foreach ($gifts as $gift)
                        <div class="vr-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                            <div class="vr-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                            <div class="vr-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                            <p class="responsive-text" style="position:relative;z-index:2;margin:12px 0 0;color:#6d5060;">{{ $gift->account_name ?? $eventTitle }}</p>
                            <button type="button" class="vr-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">Salin Nomor</button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section id="rsvp" class="vr-page slim">
            <p class="vr-label" data-reveal="zoom">RSVP</p>
            <h2 class="vr-title vr-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Kirim Pesan</h2>
            <div class="vr-rsvp-layout">
                <div class="vr-rsvp-copy" data-reveal="left">
                    <h3 class="vr-title vr-script responsive-text">Kehadiran Anda</h3>
                    <p class="vr-note responsive-text" style="margin-left:0;">Mohon konfirmasi kehadiran dan kirimkan doa terbaik untuk kedua mempelai.</p>
                </div>

                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="vr-form-card space-y-4" data-reveal="right">
                    @csrf
                    <div><label class="vr-form-label">Nama</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="vr-input" placeholder="Nama lengkap" required></div>
                    <div><label class="vr-form-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="vr-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                    <div><label class="vr-form-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="vr-input"></div>
                    <div><label class="vr-form-label">Pesan</label><textarea name="message" rows="4" class="vr-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                    <button type="submit" class="vr-btn" style="width:100%;">Kirim Pesan</button>
                </form>

                <div class="vr-summary-grid" data-reveal="zoom">
                    <div><b>{{ $tidakHadir }}</b><span>Tidak Hadir</span></div>
                    <div><b>{{ $hadir }}</b><span>Hadir</span></div>
                    <div><b>{{ $ragu }}</b><span>Ragu</span></div>
                </div>

                <div class="vr-message-list">
                    @forelse ($messages->take(5) as $message)
                        <div class="vr-message-card" data-reveal="zoom">
                            <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--vr-gold);">{{ $message->guest_name }}</p><p class="text-xs mt-1" style="color:rgba(255,249,232,.65)">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(219,183,93,.18);color:var(--vr-gold);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                            <p class="responsive-text mt-3" style="color:rgba(255,249,232,.82);line-height:1.8;">{{ $message->message }}</p>
                        </div>
                    @empty
                        <div class="vr-message-card text-center" style="color:rgba(255,249,232,.72);">Belum ada ucapan.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="closing" class="vr-page vr-hero">
            <div class="vr-closing-card" data-reveal="zoom">
                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="vr-closing-photo">
                <p class="vr-note responsive-text" style="margin-bottom:18px;">Terima Kasih</p>
                <h2 class="vr-title responsive-text">{{ $eventTitle }}</h2>
                <p class="vr-note responsive-text">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu. Atas kehadiran dan doa restunya kami ucapkan terima kasih.</p>
            </div>
        </section>
    </main>
</div>

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

        const scrollToggle = document.getElementById('scroll-toggle');
        const scrollIcon = scrollToggle ? scrollToggle.querySelector('img') : null;
        let autoScrollActive = false;
        let autoScrollFrame = null;
        let lastAutoScrollTime = 0;
        const scrollSpeedPerFrame = 1.15;
        const scrollSpeedPerSecond = scrollSpeedPerFrame * 60;

        function setScrollIcon(active) {
            if (!scrollToggle || !scrollIcon) return;
            scrollToggle.classList.toggle('is-active', active);
            scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
        }

        function stopAutoScroll() {
            autoScrollActive = false;
            lastAutoScrollTime = 0;
            document.documentElement.style.scrollBehavior = '';
            if (autoScrollFrame) {
                cancelAnimationFrame(autoScrollFrame);
                autoScrollFrame = null;
            }
            setScrollIcon(false);
        }

        function autoScrollStep(timestamp) {
            if (!autoScrollActive) return;
            if (!lastAutoScrollTime) lastAutoScrollTime = timestamp;
            const delta = timestamp - lastAutoScrollTime;
            lastAutoScrollTime = timestamp;
            const scroller = document.scrollingElement || document.documentElement;
            const maxY = scroller.scrollHeight - window.innerHeight;
            const currentY = window.scrollY || scroller.scrollTop || 0;
            const nextY = Math.min(currentY + (scrollSpeedPerSecond * delta / 1000), maxY);
            window.scrollTo(0, nextY);
            if (nextY >= maxY - 1) {
                stopAutoScroll();
                return;
            }
            autoScrollFrame = requestAnimationFrame(autoScrollStep);
        }

        function startAutoScroll() {
            stopAutoScroll();
            autoScrollActive = true;
            lastAutoScrollTime = 0;
            document.documentElement.style.scrollBehavior = 'auto';
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

        const countdown = document.querySelector('[data-countdown]');
        if (countdown) {
            const target = new Date(countdown.getAttribute('data-countdown')).getTime();
            const daysEl = countdown.querySelector('[data-days]');
            const hoursEl = countdown.querySelector('[data-hours]');
            const minutesEl = countdown.querySelector('[data-minutes]');
            const secondsEl = countdown.querySelector('[data-seconds]');
            function updateCountdown() {
                const distance = Math.max(0, target - Date.now());
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((distance / (1000 * 60)) % 60);
                const seconds = Math.floor((distance / 1000) % 60);
                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        document.querySelectorAll('[data-copy]').forEach(function (button) {
            button.addEventListener('click', async function () {
                try {
                    await navigator.clipboard.writeText(button.getAttribute('data-copy') || '');
                    button.classList.add('copied');
                    const old = button.textContent;
                    button.textContent = 'Tersalin';
                    setTimeout(() => { button.classList.remove('copied'); button.textContent = old; }, 1300);
                } catch (error) {}
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('is-visible'); });
        }, { threshold: 0.12 });
        document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
    });
</script>

<script>
    document.addEventListener('contextmenu', function (event) { event.preventDefault(); });
    document.addEventListener('keydown', function (event) {
        const key = event.key ? event.key.toLowerCase() : '';
        if (
            event.key === 'F12' ||
            (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) ||
            (event.ctrlKey && ['u', 's', 'p'].includes(key))
        ) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
    document.addEventListener('dragstart', function (event) { event.preventDefault(); });
    document.addEventListener('selectstart', function (event) {
        const tag = event.target.tagName ? event.target.tagName.toLowerCase() : '';
        if (!['input', 'textarea', 'select', 'option'].includes(tag)) event.preventDefault();
    });
</script>

</body>
</html>
