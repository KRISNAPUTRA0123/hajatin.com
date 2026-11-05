<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Rustic Garden'));
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
            color: var(--rg-ink);
            background:
                radial-gradient(circle at 10% 8%, color-mix(in srgb, var(--rg-green) 16%, transparent), transparent 30%),
                radial-gradient(circle at 90% 10%, color-mix(in srgb, var(--rg-lavender) 16%, transparent), transparent 28%),
                linear-gradient(180deg, #dfe8da 0%, #f9fbf1 42%, #dce7d8 100%);
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

        .rg-shell {
            width: min(100%, 1240px);
            margin: 0 auto;
            padding: 26px;
        }

        .rg-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 38px;
            isolation: isolate;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.82) 0%, rgba(255,255,255,.28) 38%, transparent 68%),
                linear-gradient(180deg, #edf4ea 0%, #f7fbf3 14%, #f5f9f0 34%, #eef6eb 62%, #e3ede0 100%),
                url("{{ asset('assets/rustic-garden/garden-paper-texture.png') }}") center/cover repeat;
            border: 1px solid rgba(42, 79, 60, .18);
            box-shadow: 0 40px 130px rgba(27, 52, 38, .20);
        }

        .rg-book::before,
        .rg-book::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .rg-book::before {
            opacity: .72;
            background:
                url("{{ asset('assets/rustic-garden/garden-floral-corner.png') }}") left top/310px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-corner-mirror.png') }}") right top/310px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left 18%/390px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right 18%/390px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left 56%/420px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right 56%/420px auto no-repeat,
                linear-gradient(90deg, rgba(37, 78, 61, .035) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, rgba(37, 78, 61, .028) 1px, transparent 1px) 0 0/42px 42px;
        }

        .rg-book::after {
            opacity: .34;
            background:
                radial-gradient(circle at 18% 18%, rgba(99, 140, 101, .16), transparent 25%),
                radial-gradient(circle at 82% 28%, rgba(180, 143, 191, .15), transparent 25%),
                radial-gradient(circle at 20% 74%, rgba(236, 161, 100, .12), transparent 26%),
                radial-gradient(circle at 82% 88%, rgba(88, 132, 106, .14), transparent 26%);
        }

        .rg-book > * { position: relative; z-index: 2; }

        .rg-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(56, 102, 70, .16);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(24, 50, 34, .13);
            backdrop-filter: blur(14px);
        }
        .rg-floating-actions a,
        .rg-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(24,50,34,.10);
            transition: transform .25s ease, background .25s ease;
        }
        .rg-floating-actions a:hover,
        .rg-floating-actions button:hover { transform: translateX(-3px); }
        .rg-floating-actions button.is-active { background: color-mix(in srgb, var(--rg-sage) 35%, white); }
        .rg-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .rg-page {
            position: relative;
            min-height: auto;
            padding: 104px 76px;
            overflow: hidden;
            text-align: center;
        }
        .rg-page > * { position: relative; z-index: 5; }
        .rg-page.slim { padding-top: 86px; padding-bottom: 86px; }

        .rg-page::before,
        .rg-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .rg-page::before {
            z-index: 1;
            opacity: .26;
            background:
                url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top/72% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom/100% auto no-repeat;
        }
        .rg-page::after {
            z-index: 2;
            opacity: .16;
            background: linear-gradient(180deg, transparent, rgba(255,255,255,.46), transparent);
        }

        .rg-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--rg-deep);
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(76, 117, 83, .18);
            box-shadow: 0 12px 28px rgba(37, 76, 53, .07);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .rg-label::before,
        .rg-label::after { content: ""; width: 26px; height: 1px; background: var(--rg-deep); opacity: .46; }

        .rg-title {
            margin: 0;
            color: var(--rg-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.045em;
            line-height: .94;
            text-wrap: balance;
        }
        .rg-script { font-family: Georgia, "Times New Roman", serif; font-style: italic; font-weight: 400; }
        .rg-note { max-width: 680px; margin: 20px auto 0; color: #59675c; line-height: 1.9; }

        .rg-btn {
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
            color: #fffdf1;
            background: linear-gradient(135deg, var(--rg-deep), var(--rg-green));
            box-shadow: 0 16px 34px rgba(38, 88, 61, .20);
            font-weight: 950;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .rg-btn:hover { transform: translateY(-2px); }
        .rg-btn.light { color: var(--rg-deep); background: rgba(255,255,255,.86); border: 1px solid rgba(56, 102, 70, .18); }
        .rg-btn.sun { color: #3a341c; background: linear-gradient(135deg, #e1c772, #f7e9a7); }
        .rg-btn::after,
        .rg-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: rgShine 4.2s ease-in-out infinite;
        }

        /* HERO sesuai Undangan212: arch greenhouse + fountain garden */
        .rg-hero {
            min-height: 900px;
            padding: 96px 76px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(248,252,245,.92) 0%, rgba(242,248,240,.74) 26%, rgba(236,244,235,.54) 60%, rgba(229,239,229,.82) 100%),
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.92), rgba(255,255,255,.18) 40%, transparent 68%);
        }
        .rg-hero::before {
            opacity: .94;
            background:
                url("{{ asset('assets/rustic-garden/greenhouse-arch-frame.png') }}") center top/82% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top/84% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-fountain-soft.png') }}") center 50%/118% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left bottom/42% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right bottom/42% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .rg-hero::after {
            opacity: .55;
            background:
                linear-gradient(180deg, rgba(255,255,255,.08) 0%, rgba(244,249,243,.16) 26%, rgba(230,239,229,.34) 100%),
                url("{{ asset('assets/rustic-garden/garden-haze-soft.png') }}") center center/124% 100% no-repeat;
        }
        .rg-hero-inner { width: min(100%, 620px); margin: 0 auto; padding: 220px 0 220px; }
        .rg-hero-kicker { color: var(--rg-ink); font-size: 12px; font-weight: 950; letter-spacing: .18em; text-transform: uppercase; }
        .rg-hero-title { margin-top: 24px; font-size: clamp(3.8rem, 8vw, 7.6rem); color: var(--rg-deep); }
        .rg-hero-and { display: block; margin: 10px auto; color: var(--rg-ink); font-size: clamp(2.2rem, 4vw, 3.4rem); }
        .rg-hero-date { margin-top: 28px; color: #313a33; font-size: 1.05rem; letter-spacing: .24em; font-weight: 850; }
        .rg-hero-actions { margin-top: 34px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Couple */
        .rg-couple {
            background: linear-gradient(180deg, rgba(255,255,255,.58), rgba(247,252,241,.62));
        }
        .rg-couple-stage {
            width: min(100%, 1080px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: stretch;
            gap: 14px;
        }
        .rg-person-card {
            position: relative;
            min-height: 540px;
            padding: 40px 32px 36px;
            border-radius: 999px 999px 42px 42px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.92), rgba(247,252,241,.62));
            border: 1px solid rgba(56, 102, 70, .16);
            box-shadow: 0 28px 84px rgba(27, 52, 38, .13);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }
        .rg-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .30;
            background:
                url("{{ asset('assets/rustic-garden/garden-wreath.png') }}") center 26px/80% auto no-repeat,
                url("{{ asset('assets/rustic-garden/wildflower-cluster.png') }}") left bottom/48% auto no-repeat,
                url("{{ asset('assets/rustic-garden/wildflower-cluster-mirror.png') }}") right bottom/48% auto no-repeat;
        }
        .rg-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: 250px;
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
            border-radius: 999px 999px 30px 30px;
            background: #fff;
            box-shadow: 0 20px 52px rgba(27,52,38,.14);
        }
        .rg-person-photo-wrap img,
        .rg-person-initial {
            width: 100%;
            aspect-ratio: 4/5;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 22px 22px;
            background: color-mix(in srgb, var(--rg-sage) 18%, #fff);
            color: var(--rg-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4.2rem;
            font-weight: 700;
        }
        .rg-person-content { position: relative; z-index: 2; margin-top: 28px; }
        .rg-person-content .rg-script { color: var(--rg-deep); font-size: clamp(2rem, 4vw, 3.4rem); }
        .rg-person-name { margin: 10px 0 0; color: #27362d; font-family: Georgia,"Times New Roman",serif; font-size: clamp(2rem, 3.5vw, 3.8rem); line-height: 1; }
        .rg-person-family { max-width: 390px; margin: 16px auto 0; color: #59675c; line-height: 1.78; }
        .rg-couple-symbol {
            align-self: center;
            width: 86px;
            height: 86px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--rg-deep);
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(56,102,70,.16);
            box-shadow: 0 20px 52px rgba(27,52,38,.12);
            font-family: Georgia,"Times New Roman",serif;
            font-style: italic;
            font-size: 3.4rem;
            z-index: 4;
            margin-left: -24px;
            margin-right: -24px;
        }

        .rg-invitation-card {
            width: min(100%, 880px);
            margin: 0 auto;
            padding: 52px 48px;
            border-radius: 44px;
            background: linear-gradient(145deg, rgba(255,255,255,.86), rgba(248,253,242,.58));
            border: 1px solid rgba(56,102,70,.16);
            box-shadow: 0 28px 84px rgba(27,52,38,.10);
        }
        .rg-invitation-card h2 { font-size: clamp(3rem, 6vw, 6.8rem); }

        /* Save the date */
        .rg-save-date {
            min-height: 880px;
            padding: 112px 76px 130px;
            display: grid;
            place-items: center;
        }
        .rg-save-date::before {
            opacity: .90;
            background:
                url("{{ asset('assets/rustic-garden/greenhouse-arch-frame.png') }}") center top/80% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-fountain-soft.png') }}") center 46%/114% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left bottom/42% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right bottom/42% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .rg-count-panel {
            width: min(100%, 650px);
            margin: 0 auto;
            padding: 190px 30px 120px;
            text-align: center;
        }
        .rg-count-title { font-size: clamp(2.8rem, 5.4vw, 5.8rem); }
        .rg-count-grid {
            width: min(100%, 520px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px 48px;
        }
        .rg-count-card { padding: 12px 8px; }
        .rg-count-number { display: block; color: #29372f; font-family: Georgia,"Times New Roman",serif; font-size: clamp(2.5rem, 6vw, 4.4rem); line-height: 1; }
        .rg-count-label { display: block; margin-top: 8px; color: #59675c; font-size: 13px; font-weight: 800; }
        .rg-count-actions { margin-top: 42px; }

        /* Event */
        .rg-event-layout {
            width: min(100%, 1040px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: minmax(0, .96fr) minmax(340px, 1.04fr);
            gap: 34px;
            align-items: stretch;
        }
        .rg-event-layout.is-single {
            grid-template-columns: minmax(0, 760px);
            justify-content: center;
        }

        .rg-event-layout.is-single .rg-event-card {
            width: 100%;
            margin: 0 auto;
        }
        .rg-event-card,
        .rg-map-card {
            border-radius: 42px;
            background: linear-gradient(145deg, rgba(255,255,255,.90), rgba(248,253,242,.62));
            border: 1px solid rgba(56,102,70,.15);
            box-shadow: 0 28px 82px rgba(27,52,38,.12);
            overflow: hidden;
        }
        .rg-event-card { padding: 48px 38px; text-align: center; }
        .rg-event-card h3 {
            font-size: clamp(2.2rem, 4.2vw, 4.2rem);
            line-height: 1.04;
            max-width: 420px;
            margin: 0 auto;
            text-wrap: balance;
        }
        .rg-date-split { margin: 34px auto 28px; display: grid; grid-template-columns: 1fr auto 1fr; gap: 22px; align-items: center; width: min(100%, 520px); }
        .rg-date-side { color: #4c5b50; font-family: Georgia,"Times New Roman",serif; font-size: 1.2rem; }
        .rg-date-center { padding: 0 28px; border-left: 1px solid rgba(45,82,60,.30); border-right: 1px solid rgba(45,82,60,.30); }
        .rg-date-center b { display: block; color: var(--rg-deep); font-family: Georgia,"Times New Roman",serif; font-size: clamp(3rem, 6vw, 5.2rem); line-height: .9; }
        .rg-date-center span { display: block; margin-top: 10px; color: #4c5b50; font-weight: 700; }
        .rg-date-stack {
            margin: 34px auto 28px;
            display: grid;
            gap: 14px;
        }

        .rg-date-stack .rg-date-split {
            margin: 0 auto;
        }

        .rg-date-until {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin: 0 auto;
            color: var(--rg-deep);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .rg-date-until::before,
        .rg-date-until::after {
            content: "";
            width: 42px;
            height: 1px;
            background: var(--rg-deep);
            opacity: .42;
        }

        .rg-date-range-final {
            margin: 4px auto 0;
            color: #4d5c50;
            font-size: .9rem;
            font-weight: 900;
            letter-spacing: .08em;
            line-height: 1.7;
        }
        .rg-event-line { margin-top: 20px; color: #4d5c50; line-height: 1.85; font-weight: 700; }
        .rg-event-place { margin-top: 32px; color: #26352b; font-weight: 950; }
        .rg-event-address { margin-top: 10px; color: #59675c; line-height: 1.75; }
        .rg-event-actions { margin-top: 34px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .rg-map-card { display: flex; flex-direction: column; min-height: 520px; }
        .rg-map-frame,
        .rg-map-placeholder { width: 100%; height: 420px; min-height: 420px; border: 0; display: block; }
        .rg-map-placeholder { display: flex; align-items: center; justify-content: center; text-align: center; text-decoration: none; color: inherit; padding: 32px; background: linear-gradient(135deg, rgba(56,102,70,.13), rgba(180,143,191,.11)), #edf4ec; }
        .rg-map-pin { width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 999px; display: grid; place-items: center; background: var(--rg-deep); color: #fff; font-size: 2rem; box-shadow: 0 18px 40px rgba(27,52,38,.20); }
        .rg-map-footer { padding: 22px 26px; display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; background: rgba(255,255,255,.88); border-top: 1px solid rgba(56,102,70,.12); }
        .rg-map-title { margin: 0; color: #26352b; font-weight: 950; }
        .rg-map-address { margin: 7px 0 0; color: #59675c; line-height: 1.65; white-space: pre-line; overflow-wrap: anywhere; }

        /* Gallery */
        .rg-gallery-grid {
            width: min(100%, 1060px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 110px;
            gap: 12px;
        }
        .rg-gallery-item { display: block; overflow: hidden; padding: 6px; background: rgba(255,255,255,.84); border: 1px solid rgba(56,102,70,.15); box-shadow: 0 14px 34px rgba(27,52,38,.08); border-radius: 999px 999px 24px 24px; }
        .rg-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; }
        .rg-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; border-radius: 34px; }
        .rg-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; }
        .rg-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }
        .rg-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit; transition: transform .7s ease; }
        .rg-gallery-item:hover img { transform: scale(1.055); }

        /* Gift */
        .rg-gift-grid { width: min(100%, 920px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .rg-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 34px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255,255,255,.88), rgba(248,253,242,.68));
            border: 1px solid rgba(56,102,70,.15);
            box-shadow: 0 18px 48px rgba(27,52,38,.10);
        }

        .rg-gift-grid.is-single .rg-gift-card {
            text-align: left;
        }
        .rg-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: color-mix(in srgb, var(--rg-sage) 18%, transparent); transform: skewY(-7deg); }
        .rg-gift-title,.rg-gift-number,.rg-copy-btn { position: relative; z-index: 2; }
        .rg-gift-title { color: var(--rg-deep); font-weight: 950; font-size: 1.25rem; }
        .rg-gift-number { margin-top: 18px; color: #26352b; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .rg-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #fffdf1; background: var(--rg-deep); font-weight: 950; cursor: pointer; }
        .rg-copy-btn.copied { background: #16803c; }

        /* RSVP */
        .rg-rsvp-layout { width: min(100%, 1080px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .rg-rsvp-copy { padding: 42px 34px; border-radius: 40px; background: linear-gradient(145deg, rgba(255,255,255,.80), rgba(248,253,242,.58)); border: 1px solid rgba(56,102,70,.14); box-shadow: 0 18px 48px rgba(27,52,38,.08); }
        .rg-rsvp-copy h3 { font-size: clamp(2.4rem, 4vw, 4.4rem); }
        .rg-form-card { padding: 26px; border-radius: 28px; background: rgba(255,255,255,.86); border: 1px solid rgba(56,102,70,.14); box-shadow: 0 18px 48px rgba(27,52,38,.08); text-align: left; }
        .rg-form-label { display: block; color: var(--rg-deep); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .rg-input { width: 100%; margin-top: 8px; border: 1px solid rgba(56,102,70,.14); background: rgba(255,255,255,.94); color: var(--rg-ink); border-radius: 14px; padding: 13px 14px; outline: none; text-align: left; }
        .rg-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .rg-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; background: rgba(255,255,255,.76); border: 1px solid rgba(56,102,70,.12); }
        .rg-summary-grid b { display: block; color: var(--rg-deep); font-size: 2rem; line-height: 1; }
        .rg-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .rg-message-card { padding: 18px; border-radius: 22px; background: rgba(255,255,255,.82); border: 1px solid rgba(56,102,70,.12); box-shadow: 0 10px 24px rgba(27,52,38,.06); }

        .rg-closing-card { width: min(100%, 720px); margin: 0 auto; padding: 80px 34px 240px; text-align: center; }
        .rg-closing-card h2 { font-size: clamp(3rem, 7vw, 6.5rem); }
        .rg-closing-photo { width: 210px; height: 270px; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px 999px 28px 28px; border: 8px solid #fff; outline: 1px solid rgba(56,102,70,.20); box-shadow: 0 20px 52px rgba(27,52,38,.14); }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes rgShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes rgFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .rg-floating-actions a, .rg-floating-actions button { animation: rgFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1440px) {
            .rg-shell { width: min(100%, 1320px); }
            .rg-page { padding-left: 92px; padding-right: 92px; }
            .rg-hero-title { font-size: clamp(5rem, 7vw, 8.4rem); }
        }

        @media (max-width: 980px) {
            .rg-shell { padding: 14px; }
            .rg-page { padding: 90px 38px; }
            .rg-hero { min-height: 820px; padding: 88px 38px 0; }
            .rg-hero::before { background-size: 116% auto, 100% auto, 132% auto, 62% auto, 62% auto, 130% auto; }
            .rg-hero-inner { padding-top: 170px; padding-bottom: 210px; }
            .rg-couple-stage,
            .rg-event-layout,
            .rg-rsvp-layout { grid-template-columns: 1fr; text-align: center; }
            .rg-couple-symbol { margin: -8px auto; }
            .rg-event-card { text-align: center; }
            .rg-gift-grid { grid-template-columns: 1fr; }
            .rg-gallery-grid { grid-template-columns: repeat(6, 1fr); }
            .rg-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .rg-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .rg-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .rg-shell { padding: 0; }
            .rg-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .rg-page,
            .rg-page.slim { padding: 76px 22px; }
            .rg-floating-actions { right: 0; gap: 7px; }
            .rg-floating-actions a, .rg-floating-actions button { width: 40px; height: 40px; }
            .rg-hero { min-height: 100svh; padding: 72px 22px 0; }
            .rg-hero::before {
                background:
                    url("{{ asset('assets/rustic-garden/greenhouse-arch-frame.png') }}") center top/138% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top/118% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-fountain-soft.png') }}") center 49%/158% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left bottom/78% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right bottom/78% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom/156% auto no-repeat;
            }
            .rg-hero::after {
                opacity: .62;
                background:
                    linear-gradient(180deg, rgba(255,255,255,.06) 0%, rgba(243,249,241,.14) 30%, rgba(229,238,228,.36) 100%),
                    url("{{ asset('assets/rustic-garden/garden-haze-soft.png') }}") center center/150% 100% no-repeat;
            }

            .rg-date-stack {
                gap: 16px;
            }

            .rg-date-until::before,
            .rg-date-until::after {
                width: 30px;
            }

            .rg-date-range-final {
                font-size: .82rem;
                letter-spacing: .05em;
            }

            .rg-save-date::before {
                background-size: 138% auto, 156% auto, 78% auto, 78% auto, 156% auto;
            }
            .rg-hero-inner { padding-top: 128px; padding-bottom: 210px; }
            .rg-hero-title { font-size: clamp(3.3rem, 14vw, 5.4rem); }
            .rg-hero-actions { flex-direction: column; }
            .rg-hero-actions .rg-btn { width: 100%; }
            .rg-label { font-size: 10px; letter-spacing: .14em; }
            .rg-label::before, .rg-label::after { width: 18px; }
            .rg-person-card { min-height: auto; border-radius: 999px 999px 32px 32px; padding: 34px 20px; }
            .rg-person-photo-wrap { width: 180px; }
            .rg-date-split { grid-template-columns: 1fr; gap: 14px; }
            .rg-date-center { border-left: 0; border-right: 0; border-top: 1px solid rgba(45,82,60,.25); border-bottom: 1px solid rgba(45,82,60,.25); padding: 18px 0; }
            .rg-save-date { min-height: 780px; padding: 80px 22px 100px; }
            .rg-save-date::before { background-size: 138% auto, 112% auto, 78% auto, 78% auto, 156% auto; }
            .rg-count-panel { padding-top: 146px; padding-bottom: 110px; }
            .rg-count-grid { grid-template-columns: repeat(2, 1fr); gap: 22px; }
            .rg-map-frame, .rg-map-placeholder { height: 320px; min-height: 320px; }
            .rg-map-footer { flex-direction: column; align-items: stretch; }
            .rg-map-footer .rg-btn { width: 100%; }
            .rg-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .rg-gallery-item, .rg-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: 270px; }
            .rg-rsvp-layout { gap: 22px; }
            .rg-rsvp-copy, .rg-form-card { padding: 26px 20px; border-radius: 28px; }
            .rg-summary-grid { grid-template-columns: 1fr; }
            .rg-btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        .rg-gift-grid.is-single {
            grid-template-columns: minmax(0, 450px);
            justify-content: center;
        }

        .rg-gift-grid.is-single .rg-gift-card {
            width: 100%;
            margin: 0 auto;
        }

        /* =====================================================
        SAVE THE DATE READABILITY FIX
        Membuat tulisan countdown lebih jelas
        ===================================================== */

        .rg-save-date {
            position: relative !important;
            isolation: isolate !important;
        }

        /* Background tetap terlihat, tapi dibuat lebih soft */
        .rg-save-date::before {
            opacity: .58 !important;
            filter: saturate(.88) contrast(.92) brightness(1.08) !important;
        }

        /* Tambahkan layer kabut putih agar teks tidak kalah dengan background */
        .rg-save-date::after {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 2 !important;
            pointer-events: none !important;
            opacity: 1 !important;
            background:
                radial-gradient(circle at 50% 42%, rgba(255,255,255,.82) 0%, rgba(255,255,255,.64) 30%, rgba(255,255,255,.28) 56%, transparent 78%),
                linear-gradient(180deg, rgba(245,250,242,.24), rgba(255,255,255,.46), rgba(238,247,236,.22)) !important;
        }

        /* Judul Save The Date dibuat lebih tegas */
        .rg-count-title {
            color: var(--rg-deep) !important;
            font-size: clamp(3rem, 6vw, 6rem) !important;
            line-height: .9 !important;
            text-shadow:
                0 2px 0 rgba(255,255,255,.72),
                0 18px 38px rgba(27,52,38,.16) !important;
        }

        /* Grid countdown lebih rapi */
        .rg-count-grid {
            margin-top: 38px !important;
            gap: 18px !important;
        }

        /* Setiap angka diberi kartu putih soft */
        .rg-count-card {
            padding: 22px 14px !important;
            border-radius: 28px !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,253,242,.78)) !important;
            border: 1px solid rgba(56,102,70,.13) !important;
            box-shadow: 0 14px 36px rgba(27,52,38,.09) !important;
        }

        /* Angka countdown dibuat gelap dan jelas */
        .rg-count-number {
            color: #1f3328 !important;
            font-weight: 800 !important;
            text-shadow:
                0 1px 0 rgba(255,255,255,.8),
                0 10px 24px rgba(27,52,38,.14) !important;
        }

        /* Label Days, Hours, Minutes, Seconds */
        .rg-count-label {
            color: #34483b !important;
            font-weight: 950 !important;
            letter-spacing: .08em !important;
            text-transform: uppercase !important;
            text-shadow: 0 1px 0 rgba(255,255,255,.8) !important;
        }

        /* Tombol calendar lebih tegas */
        .rg-count-actions .rg-btn {
            min-width: 190px !important;
            box-shadow: 0 18px 42px rgba(27,52,38,.22) !important;
        }

        @media (max-width: 640px) {
            .rg-save-date {
                min-height: 760px !important;
                padding: 86px 22px 110px !important;
            }

            .rg-save-date::before {
                opacity: .48 !important;
            }

            .rg-save-date::after {
                background:
                    radial-gradient(circle at 50% 42%, rgba(255,255,255,.88) 0%, rgba(255,255,255,.70) 34%, rgba(255,255,255,.30) 62%, transparent 82%),
                    linear-gradient(180deg, rgba(245,250,242,.20), rgba(255,255,255,.48), rgba(238,247,236,.22)) !important;
            }

            .rg-count-panel {
                padding: 46px 20px 44px !important;
                border-radius: 34px !important;
            }

            .rg-count-title {
                font-size: clamp(2.7rem, 13vw, 4.4rem) !important;
            }

            .rg-count-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
                margin-top: 30px !important;
            }

            .rg-count-card {
                padding: 18px 10px !important;
                border-radius: 22px !important;
            }

            .rg-count-number {
                font-size: clamp(2rem, 11vw, 3.4rem) !important;
            }

            .rg-count-label {
                font-size: 11px !important;
            }
        }

        /* =====================================================
        HERO NAME SPACING FIX
        Nama 1 dan nama 2 dibuat lebih dekat
        ===================================================== */

        .rg-hero-title {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: clamp(4px, 1vw, 12px) !important;
            line-height: .86 !important;
        }

        .rg-hero-name {
            display: block !important;
            line-height: .86 !important;
        }

        .rg-hero-and {
            display: block !important;
            margin: 0 auto !important;
            line-height: .8 !important;
            font-size: clamp(1.8rem, 3vw, 2.8rem) !important;
            color: #26352b !important;
        }

        /* Desktop besar */
        @media (min-width: 981px) {
            .rg-hero-title {
                gap: 6px !important;
            }

            .rg-hero-name {
                margin: 0 !important;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .rg-hero-title {
                gap: 4px !important;
                line-height: .88 !important;
            }

            .rg-hero-and {
                font-size: clamp(1.7rem, 8vw, 2.6rem) !important;
            }
        }

        /* =====================================================
        COUPLE SUBTITLE FIX
        Tulisan hijau menjadi subtitle, bukan nama dobel
        ===================================================== */

        .rg-person-subtitle {
            width: fit-content !important;
            max-width: 100% !important;
            margin: 0 auto 14px !important;
            padding: 8px 18px !important;
            border-radius: 999px !important;

            color: var(--rg-deep) !important;
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(56,102,70,.14) !important;

            font-family: Inter, ui-sans-serif, system-ui, sans-serif !important;
            font-size: 11px !important;
            font-weight: 950 !important;
            letter-spacing: .16em !important;
            text-transform: uppercase !important;
            line-height: 1.4 !important;
        }

        .rg-person-name {
            margin-top: 0 !important;
        }

        /* Matikan style rg-script lama di dalam card supaya tidak memengaruhi subtitle */
        .rg-person-content > .rg-script {
            display: none !important;
        }

        /* =====================================================
        RSVP REMOVE BOTTOM FLORAL
        Hapus garden-floral-bottom.png khusus section RSVP
        ===================================================== */

        #rsvp.rg-page::before {
            background:
                url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 72% auto no-repeat !important;
            opacity: .18 !important;
        }

        /* =====================================================
        MOBILE DETAIL ACARA FLORAL FIX
        Cegah garden-side-left/right menutupi section Gift di mobile
        ===================================================== */

        @media (max-width: 640px) {
            #acara.rg-page {
                padding-bottom: 86px !important;
                overflow: hidden !important;
            }

            /* Khusus mobile: detail acara tidak lagi memakai floral bawah besar */
            #acara.rg-page::before {
                opacity: .20 !important;
                background:
                    url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 108% auto no-repeat !important;
            }

            /* Tambahkan gradasi bawah supaya transisi ke Gift tetap halus */
            #acara.rg-page::after {
                opacity: 1 !important;
                background:
                    linear-gradient(
                        180deg,
                        transparent 0%,
                        rgba(245,250,242,.42) 62%,
                        rgba(236,246,232,.92) 100%
                    ) !important;
            }

            .rg-event-card {
                position: relative !important;
                z-index: 5 !important;
            }
        }

        /* =====================================================
        RSVP - CLOSING PREMIUM BACKGROUND
        Background mewah dari RSVP sampai Terima Kasih
        ===================================================== */

        #rsvp.rg-page,
        #closing.rg-page {
            position: relative !important;
            background:
                radial-gradient(circle at 16% 18%, rgba(180,143,191,.16), transparent 28%),
                radial-gradient(circle at 84% 26%, rgba(231,201,109,.13), transparent 30%),
                radial-gradient(circle at 50% 88%, rgba(78,139,98,.16), transparent 36%),
                linear-gradient(180deg, rgba(238,247,236,.84), rgba(250,253,244,.94) 46%, rgba(230,241,226,.88)) !important;
        }

        /* RSVP: hilangkan floral-bottom yang terlalu ramai */
        #rsvp.rg-page::before {
            opacity: .20 !important;
            background:
                url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 78% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-corner.png') }}") left bottom / 320px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-corner-mirror.png') }}") right bottom / 320px auto no-repeat !important;
        }

        /* Layer cahaya supaya form tetap terbaca */
        #rsvp.rg-page::after {
            opacity: 1 !important;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.78), rgba(255,255,255,.34) 44%, transparent 72%),
                linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.46), rgba(255,255,255,.20)) !important;
        }

        /* Closing / Terima Kasih dibuat lebih dekoratif */
        #closing.rg-page::before {
            opacity: .28 !important;
            background:
                url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 82% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom / 112% auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-left.png') }}") left center / 340px auto no-repeat,
                url("{{ asset('assets/rustic-garden/garden-side-right.png') }}") right center / 340px auto no-repeat !important;
        }

        #closing.rg-page::after {
            opacity: 1 !important;
            background:
                radial-gradient(circle at 50% 38%, rgba(255,255,255,.82), rgba(255,255,255,.34) 44%, transparent 76%),
                linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.48), rgba(255,255,255,.22)) !important;
        }

        /* =====================================================
        RSVP - CLOSING MOBILE BACKGROUND FIX
        ===================================================== */

        @media (max-width: 640px) {
            #rsvp.rg-page {
                padding-top: 82px !important;
                padding-bottom: 86px !important;
                background:
                    radial-gradient(circle at 14% 14%, rgba(180,143,191,.14), transparent 30%),
                    radial-gradient(circle at 88% 22%, rgba(231,201,109,.12), transparent 32%),
                    linear-gradient(180deg, rgba(238,247,236,.90), rgba(250,253,244,.96), rgba(230,241,226,.90)) !important;
            }

            #rsvp.rg-page::before {
                opacity: .18 !important;
                background:
                    url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 116% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-floral-corner.png') }}") left bottom / 210px auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-floral-corner-mirror.png') }}") right bottom / 210px auto no-repeat !important;
            }

            #rsvp.rg-page::after {
                opacity: 1 !important;
                background:
                    radial-gradient(circle at 50% 34%, rgba(255,255,255,.86), rgba(255,255,255,.48) 44%, transparent 74%),
                    linear-gradient(180deg, rgba(255,255,255,.20), rgba(255,255,255,.52), rgba(255,255,255,.22)) !important;
            }

            #closing.rg-page {
                background:
                    radial-gradient(circle at 50% 18%, rgba(231,201,109,.12), transparent 34%),
                    linear-gradient(180deg, rgba(250,253,244,.96), rgba(232,243,228,.92)) !important;
            }

            #closing.rg-page::before {
                opacity: .22 !important;
                background:
                    url("{{ asset('assets/rustic-garden/garden-floral-top.png') }}") center top / 116% auto no-repeat,
                    url("{{ asset('assets/rustic-garden/garden-floral-bottom.png') }}") center bottom / 156% auto no-repeat !important;
            }

            #closing.rg-page::after {
                opacity: 1 !important;
                background:
                    radial-gradient(circle at 50% 40%, rgba(255,255,255,.86), rgba(255,255,255,.42) 44%, transparent 76%) !important;
            }
        }

        /* =====================================================
        ANTI INSPECT BASIC PROTECTION
        Tanpa notice / popup
        ===================================================== */

        body {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }

        img,
        a,
        button {
            -webkit-user-drag: none;
            user-drag: none;
        }

        input,
        textarea,
        select {
            -webkit-user-select: text;
            user-select: text;
        }

    </style>

    @php
        $themeColor = $invitation->theme_color ?? 'emerald';
        if ($themeColor === 'golden') { $themeColor = 'gold'; }

        $rgThemes = [
            'emerald' => ['deep'=>'#2f684b','green'=>'#4e8b62','sage'=>'#a7c7a3','soft'=>'#f4fbef','ink'=>'#29362e','lavender'=>'#b38bd2','sun'=>'#e7c96d'],
            'maroon' => ['deep'=>'#6b2d3b','green'=>'#4f7654','sage'=>'#a9c09a','soft'=>'#fff7ee','ink'=>'#3e2a27','lavender'=>'#d9a4c4','sun'=>'#e7c96d'],
            'rose' => ['deep'=>'#8d3b52','green'=>'#5f8a62','sage'=>'#b7c99f','soft'=>'#fff7f3','ink'=>'#442c34','lavender'=>'#c79bd2','sun'=>'#e7c96d'],
            'gold' => ['deep'=>'#6a5526','green'=>'#617e46','sage'=>'#bdc68f','soft'=>'#fff9e9','ink'=>'#46391d','lavender'=>'#bca2d7','sun'=>'#e2bd48'],
            'navy' => ['deep'=>'#2b3c52','green'=>'#54785e','sage'=>'#a8c0a0','soft'=>'#f6fbf3','ink'=>'#202a39','lavender'=>'#9da7cf','sun'=>'#e7c96d'],
            'slate' => ['deep'=>'#39434a','green'=>'#59715d','sage'=>'#a8b9a3','soft'=>'#f8faf5','ink'=>'#222b30','lavender'=>'#a8a2c8','sun'=>'#d8bd66'],
        ];
        $rgTheme = $rgThemes[$themeColor] ?? $rgThemes['emerald'];

        $photos = ($invitation->photos ?? collect())->values();
        $firstPhoto = $photos->first();
        $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
        $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;
        $people = ($invitation->people ?? collect())->values();
        $gifts = $invitation->gifts ?? collect();
        $messages = $invitation->messages ?? collect();

        $eventTitle = $invitation->title ?: 'Putri and Alex';
        $eventName = $invitation->event_name ?: 'The Wedding Of';
        $hostName = $invitation->host_name ?: 'Keluarga Besar';

        $bride = $people->get(0);
        $groom = $people->get(1);

        $titleParts = str_contains($eventTitle, '&')
            ? array_map('trim', explode('&', $eventTitle, 2))
            : [];

        $brideName = $bride->name
            ?? ($titleParts[0] ?? 'Putri');

        $groomName = $groom->name
            ?? ($titleParts[1] ?? 'Alex');

        $brideSubtitle = $bride->subtitle ?? 'Mempelai Wanita';
        $groomSubtitle = $groom->subtitle ?? 'Mempelai Pria';

        $personPhotoUrl = function ($person, $fallback) {
            $path = $person->photo ?? $person->image ?? null;
            if (!$path) { return $fallback; }
            if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) { return $path; }
            if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) { return asset(ltrim($path, '/')); }
            return asset('storage/' . ltrim($path, '/'));
        };

        $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date) : null;
        $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date) : null;
        $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : 'Tanggal belum diatur';
        $eventDateShort = $startDate ? $startDate->format('d . m . y') : 'Tanggal belum diatur';
        $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Hari belum diatur';
        $eventDateRangeText = $eventDateText;
        if ($startDate && $endDate) {
            if ($startDate->isSameDay($endDate)) { $eventDateRangeText = $startDate->translatedFormat('d F Y'); }
            elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) { $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y'); }
            elseif ($startDate->format('Y') === $endDate->format('Y')) { $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y'); }
            else { $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y'); }
        }

        $hasEndDate = $startDate && $endDate && !$startDate->isSameDay($endDate);
        $eventDateNumericRange = null;

        if ($hasEndDate) {
            $eventDateNumericRange = $startDate->format('d.m.Y') . ' - ' . $endDate->format('d.m.Y');
        }

        $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
        if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }

        $locationText = $invitation->location_name ?: 'Lokasi acara belum diatur';
        $addressText = trim($invitation->address ?: 'Alamat lengkap belum ditambahkan.');
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

        $shareUrl = route('invitation.public', $invitation->slug);
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

        $coverPhoto = $invitation->cover_image ? asset('storage/' . $invitation->cover_image) : null;
        $defaultCover = asset('assets/rustic-garden/couple-placeholder.png');
        $coverDisplay = $coverPhoto ?: $defaultCover;
        $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
        $groomPhoto = $personPhotoUrl($groom, $coverDisplay);
        $momentPhotoUrl = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
        $closingPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;
    @endphp
</head>

<body style="--rg-deep: {{ $rgTheme['deep'] }}; --rg-green: {{ $rgTheme['green'] }}; --rg-sage: {{ $rgTheme['sage'] }}; --rg-soft: {{ $rgTheme['soft'] }}; --rg-ink: {{ $rgTheme['ink'] }}; --rg-lavender: {{ $rgTheme['lavender'] }}; --rg-sun: {{ $rgTheme['sun'] }};">
    <div class="rg-floating-actions">
        <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan"></a>
        <button type="button" id="music-toggle" title="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music"></button>
        <button type="button" id="scroll-toggle" title="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll"></button>
        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi"></a>@endif
    </div>

    <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}" preload="auto" loop></audio>

    <main class="rg-shell">
        <div class="rg-book">
            <section id="cover" class="rg-page rg-hero">
                <div class="rg-hero-inner" data-reveal="zoom">
                    <div class="rg-hero-kicker">{{ $eventName }}</div>
                    <h1 class="rg-title rg-hero-title responsive-text">
                        <span class="rg-hero-name">{{ $brideName }}</span>
                        <span class="rg-script rg-hero-and">&</span>
                        <span class="rg-hero-name">{{ $groomName }}</span>
                    </h1>
                    <div class="rg-hero-date responsive-text">{{ $eventDateShort }}</div>
                    <div class="rg-hero-actions">
                        <a href="#mempelai" class="rg-btn sun">Buka Undangan</a>
                        @if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="rg-btn light">Add to Calendar</a>@endif
                    </div>
                </div>
            </section>

            <section id="mempelai" class="rg-page rg-couple">
                <p class="rg-label" data-reveal="zoom">Bride & Groom</p>
                <h2 class="rg-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6.4rem);">Mempelai</h2>
                <p class="rg-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">The pleasure of your company is requested at the marriage of kedua mempelai yang akan memulai perjalanan baru bersama.</p>

                <div class="rg-couple-stage">
                    <article class="rg-person-card" data-reveal="left">
                        <div class="rg-person-photo-wrap">
                            <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                        </div>
                        <div class="rg-person-content">
                            <div class="rg-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                            <h3 class="rg-person-name responsive-text">{{ $bride->name ?? $brideName }}</h3>
                            <p class="rg-person-family responsive-text">{{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}</p>
                        </div>
                    </article>

                    <div class="rg-couple-symbol" data-reveal="zoom">&</div>

                    <article class="rg-person-card" data-reveal="right">
                        <div class="rg-person-photo-wrap">
                            <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                        </div>
                        <div class="rg-person-content">
                           <div class="rg-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                            <h3 class="rg-person-name responsive-text">{{ $groom->name ?? $groomName }}</h3>
                            <p class="rg-person-family responsive-text">{{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}</p>
                        </div>
                    </article>
                </div>
            </section>

            <section id="invitation" class="rg-page slim">
                <div class="rg-invitation-card" data-reveal="zoom">
                    <p class="rg-label">With Love</p>
                    <h2 class="rg-title rg-script responsive-text">Dear Family & Friends</h2>
                    <p class="rg-note responsive-text">{{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan kami. Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.' }}</p>
                </div>
            </section>

            <section id="save-date" class="rg-page rg-save-date">
                <div class="rg-count-panel" data-reveal="zoom">
                    <h2 class="rg-title rg-count-title responsive-text">Save The Date</h2>
                    <div class="rg-count-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                        <div class="rg-count-card"><span class="rg-count-number" data-unit="days">00</span><span class="rg-count-label">Days</span></div>
                        <div class="rg-count-card"><span class="rg-count-number" data-unit="hours">00</span><span class="rg-count-label">Hours</span></div>
                        <div class="rg-count-card"><span class="rg-count-number" data-unit="minutes">00</span><span class="rg-count-label">Minutes</span></div>
                        <div class="rg-count-card"><span class="rg-count-number" data-unit="seconds">00</span><span class="rg-count-label">Seconds</span></div>
                    </div>
                    @if ($googleCalendarUrl)<div class="rg-count-actions"><a href="{{ $googleCalendarUrl }}" target="_blank" class="rg-btn">Add to Calendar</a></div>@endif
                </div>
            </section>

            <section id="acara" class="rg-page">
                <p class="rg-label" data-reveal="zoom">Wedding Event</p>
                <h2 class="rg-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6.4rem);">Detail Acara</h2>
                <p class="rg-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">By the grace of God, we are pleased to announce our wedding to you, our family, and our friends.</p>

                <div class="rg-event-layout {{ $mapOpenUrl ? '' : 'is-single' }}">
                    <div class="rg-event-card" data-reveal="left">
                        <h3 class="rg-title rg-script responsive-text rg-event-title">Acara Pernikahan</h3>
                        <div class="rg-date-stack">
                            <div class="rg-date-split">
                                <div class="rg-date-side">
                                    {{ $eventDayText }}
                                </div>

                                <div class="rg-date-center">
                                    <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                                    <span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span>
                                </div>

                                <div class="rg-date-side">
                                    {{ $startDate ? $startDate->translatedFormat('F') : '' }}
                                </div>
                            </div>

                            @if ($hasEndDate)
                                <div class="rg-date-until">
                                    sampai
                                </div>

                                <div class="rg-date-split">
                                    <div class="rg-date-side">
                                        {{ $endDate->translatedFormat('l') }}
                                    </div>

                                    <div class="rg-date-center">
                                        <b>{{ $endDate->format('d') }}</b>
                                        <span>{{ $endDate->translatedFormat('Y') }}</span>
                                    </div>

                                    <div class="rg-date-side">
                                        {{ $endDate->translatedFormat('F') }}
                                    </div>
                                </div>

                                <p class="rg-date-range-final responsive-text">
                                    {{ $eventDateNumericRange }}
                                </p>
                            @endif
                        </div>

                        @if ($eventTimeText)
                            <p class="rg-event-line">{{ $eventTimeText }}</p>
                        @endif
                        <p class="rg-event-place responsive-text">{{ $locationText }}</p>
                        <p class="rg-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>
                        <div class="rg-event-actions">
                            @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="rg-btn">View Location</a>@endif
                            @if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="rg-btn light">Calendar</a>@endif
                        </div>
                    </div>

                    @if ($mapOpenUrl)
                        <div class="rg-map-card" data-reveal="right">
                            @if ($mapEmbedUrl)
                                <iframe src="{{ $mapEmbedUrl }}" class="rg-map-frame" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                            @else
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="rg-map-placeholder" aria-label="Buka lokasi di Google Maps">
                                    <div>
                                        <div class="rg-map-pin">📍</div>
                                        <p class="rg-map-title responsive-text">{{ $locationText }}</p>
                                        <p class="rg-map-address responsive-text">Klik untuk membuka lokasi asli di Google Maps.</p>
                                    </div>
                                </a>
                            @endif
                            <div class="rg-map-footer">
                                <div>
                                    <p class="rg-map-title responsive-text">{{ $locationText }}</p>
                                    <p class="rg-map-address responsive-text">{!! nl2br(e($addressText)) !!}</p>
                                </div>
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="rg-btn">Maps</a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            @if ($photos->count())
                <section id="galeri" class="rg-page slim">
                    <p class="rg-label" data-reveal="zoom">Our Gallery</p>
                    <h2 class="rg-title rg-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6.4rem);">Precious Moment</h2>
                    <div class="rg-gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="rg-gallery-item" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri {{ $index + 1 }}">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="rg-page slim">
                    <p class="rg-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="rg-title rg-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6.4rem);">Tanda Kasih</h2>
                    <p class="rg-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                    <div class="rg-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            <div class="rg-gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .05, .2) }}s">
                                <div class="rg-gift-title responsive-text">{{ $gift->bank_name ?? $gift->type ?? 'Hadiah' }}</div>
                                <div class="rg-gift-number responsive-text">{{ $gift->account_number ?? $gift->value ?? '-' }}</div>
                                <p class="responsive-text" style="position:relative;z-index:2;margin-top:10px;color:#59675c;">{{ $gift->account_name ?? $gift->holder_name ?? $gift->description ?? '' }}</p>
                                @if ($gift->account_number ?? $gift->value ?? null)<button type="button" class="rg-copy-btn" data-copy="{{ $gift->account_number ?? $gift->value }}">Salin Nomor</button>@endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="rg-page slim">
                <p class="rg-label" data-reveal="zoom">Reservation Reply</p>
                <h2 class="rg-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6.4rem);">RSVP</h2>
                <div class="rg-rsvp-layout">
                    <div class="rg-rsvp-copy" data-reveal="left">
                        <h3 class="rg-title rg-script responsive-text">Kirim Pesan</h3>
                        <p class="rg-note responsive-text" style="margin-left:0;">Silakan kirim ucapan dan konfirmasi kehadiran Anda. Setiap doa baik akan menjadi kenangan indah bagi kami.</p>
                    </div>

                    <div data-reveal="right">
                        @if (session('message_success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>@endif
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5 text-left"><p class="font-bold">Mohon periksa kembali isian:</p><ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="rg-form-card space-y-4">
                            @csrf
                            <div><label class="rg-form-label">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="rg-input" placeholder="Nama lengkap" required></div>
                            <div><label class="rg-form-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="rg-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                            <div><label class="rg-form-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="rg-input"></div>
                            <div><label class="rg-form-label">Ucapan / Doa</label><textarea name="message" rows="4" class="rg-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                            <button type="submit" class="rg-btn" style="width:100%;">Kirim Pesan</button>
                        </form>
                    </div>

                    <div class="rg-summary-grid">
                        <div data-reveal="zoom"><b>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</b><span>Tidak Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.06s"><b>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><span>Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.12s"><b>{{ $messages->where('attendance_status', 'ragu')->count() }}</b><span>Ragu</span></div>
                    </div>

                    <div class="rg-message-list">
                        @forelse ($messages as $index => $message)
                            <div class="rg-message-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--rg-deep);">{{ $message->guest_name }}</p><p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:#eef7e7;color:var(--rg-deep);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                                <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="rg-message-card text-center" data-reveal="zoom"><p class="text-slate-500">Belum ada ucapan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="rg-page">
                <div class="rg-closing-card" data-reveal="zoom">
                    @if ($closingPhoto)<img src="{{ $closingPhoto }}" alt="Foto Penutup" class="rg-closing-photo">@endif
                    <p class="rg-label">Thank You</p>
                    <h2 class="rg-title rg-script responsive-text mt-8">Terima Kasih</h2>
                    <p class="rg-note responsive-text">Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
                    <h3 class="rg-title rg-script responsive-text mt-8" style="font-size:clamp(2.2rem,7vw,4.8rem);">{{ $eventTitle }}</h3>
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
                if (autoScrollFrame) { cancelAnimationFrame(autoScrollFrame); autoScrollFrame = null; }
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
                if (nextY >= maxY - 1) { stopAutoScroll(); return; }
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }
            function startAutoScroll() {
                stopAutoScroll();
                autoScrollActive = true;
                document.documentElement.style.scrollBehavior = 'auto';
                setScrollIcon(true);
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }
            if (scrollToggle) {
                scrollToggle.addEventListener('click', function () { autoScrollActive ? stopAutoScroll() : startAutoScroll(); });
                ['wheel','touchstart','keydown'].forEach(function (eventName) { window.addEventListener(eventName, function () { if (autoScrollActive) stopAutoScroll(); }, { passive: true }); });
            }

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
                    let diff = Math.max(0, target - Date.now());
                    const days = Math.floor(diff / 86400000); diff -= days * 86400000;
                    const hours = Math.floor(diff / 3600000); diff -= hours * 3600000;
                    const minutes = Math.floor(diff / 60000); diff -= minutes * 60000;
                    const seconds = Math.floor(diff / 1000);
                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }
                updateCountdown(); setInterval(updateCountdown, 1000);
            });

            document.querySelectorAll('.rg-copy-btn').forEach(function (button) {
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
                    setTimeout(function () { button.classList.remove('copied'); button.textContent = oldText; }, 1600);
                });
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
            document.querySelectorAll('[data-reveal]').forEach(function (element) { revealObserver.observe(element); });

            // Anti inspect basic protection tanpa notice
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

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

            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });

            document.addEventListener('selectstart', function (event) {
                const tag = event.target.tagName ? event.target.tagName.toLowerCase() : '';

                if (!['input', 'textarea', 'select', 'option'].includes(tag)) {
                    event.preventDefault();
                }
            });

        });
    </script>
</body>
</html>
