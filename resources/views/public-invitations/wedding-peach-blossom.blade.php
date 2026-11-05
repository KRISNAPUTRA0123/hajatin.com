<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Peach Blossom'));
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
            color: var(--pb-ink);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--pb-peach) 28%, transparent), transparent 32%),
                radial-gradient(circle at 86% 10%, color-mix(in srgb, var(--pb-lavender) 22%, transparent), transparent 30%),
                linear-gradient(180deg, var(--pb-mist) 0%, var(--pb-paper) 46%, var(--pb-sage-soft) 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body { -webkit-user-select: none; user-select: none; -webkit-touch-callout: none; }
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

        .pb-shell {
            width: min(100%, 1160px);
            margin: 0 auto;
            padding: 24px;
        }

        .pb-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid rgba(86, 91, 64, .18);
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.88), rgba(255,255,255,.22) 44%, transparent 68%),
                linear-gradient(180deg, rgba(255,253,238,.94), rgba(247,249,230,.92)),
                url("{{ asset('assets/peach-blossom/pb-paper-texture.png') }}") center/cover repeat;
            box-shadow: 0 42px 120px rgba(69, 82, 52, .18);
        }

        .pb-book::before,
        .pb-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .pb-book::before {
            opacity: .58;
            background:
                url("{{ asset('assets/peach-blossom/pb-text-paper-lines.png') }}") center top/820px auto repeat-y,
                linear-gradient(90deg, rgba(96,112,79,.030) 1px, transparent 1px) 0 0/44px 44px,
                linear-gradient(0deg, rgba(96,112,79,.026) 1px, transparent 1px) 0 0/44px 44px;
        }

        .pb-book::after {
            opacity: .38;
            background:
                radial-gradient(circle at 20% 18%, color-mix(in srgb, var(--pb-peach) 20%, transparent), transparent 30%),
                radial-gradient(circle at 82% 28%, color-mix(in srgb, var(--pb-lavender) 20%, transparent), transparent 30%),
                radial-gradient(circle at 50% 78%, color-mix(in srgb, var(--pb-sage) 18%, transparent), transparent 34%);
        }

        .pb-book > * { position: relative; z-index: 2; }

        .pb-floating-actions {
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
            border: 1px solid rgba(99,112,76,.16);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(50, 65, 38, .12);
            backdrop-filter: blur(14px);
        }

        .pb-floating-actions a,
        .pb-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(50,65,38,.10);
            transition: transform .25s ease, background .25s ease;
        }

        .pb-floating-actions a:hover,
        .pb-floating-actions button:hover { transform: translateX(-3px); }
        .pb-floating-actions button.is-active { background: color-mix(in srgb, var(--pb-peach) 38%, white); }
        .pb-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .pb-page {
            position: relative;
            min-height: auto;
            padding: 104px 72px;
            overflow: hidden;
            text-align: center;
        }

        .pb-page.slim { padding-top: 84px; padding-bottom: 84px; }
        .pb-page > * { position: relative; z-index: 5; }

        .pb-page::before,
        .pb-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .pb-page::before {
            z-index: 1;
            opacity: .38;
            background:
                url("{{ asset('assets/peach-blossom/pb-floral-top-corners.png') }}") center top/88% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/108% auto no-repeat;
        }

        .pb-page::after {
            z-index: 2;
            opacity: .38;
            background:
                radial-gradient(circle at 50% 36%, rgba(255,255,255,.72), rgba(255,255,255,.24) 44%, transparent 72%),
                linear-gradient(180deg, transparent, rgba(255,255,255,.28), transparent);
        }

        .pb-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--pb-deep);
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(111,119,79,.16);
            box-shadow: 0 12px 28px rgba(77, 94, 53, .07);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .pb-label::before,
        .pb-label::after { content: ""; width: 28px; height: 1px; background: var(--pb-deep); opacity: .38; }

        .pb-title {
            margin: 0;
            color: var(--pb-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .02em;
            line-height: .96;
            text-wrap: balance;
        }

        .pb-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .pb-note {
            max-width: 700px;
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--pb-ink) 82%, transparent);
            line-height: 1.9;
        }

        .pb-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 28px;
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #fffdf1;
            background: linear-gradient(135deg, var(--pb-deep), var(--pb-olive));
            box-shadow: 0 16px 34px rgba(91, 106, 58, .20);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .pb-btn:hover { transform: translateY(-2px); }
        .pb-btn.light { color: var(--pb-deep); background: rgba(255,255,255,.84); border: 1px solid rgba(99,112,76,.16); }
        .pb-btn.peach { color: #513322; background: linear-gradient(135deg, #f6c4a9, #f8dfb8); }

        .pb-btn::after,
        .pb-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: pbShine 4.2s ease-in-out infinite;
        }

        /* HERO: mengikuti halaman 1 Undangan251 - paper, floral top, forest, mansion, railing */
        .pb-hero {
            min-height: 920px;
            padding: 72px 72px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,252,236,.84), rgba(244,247,225,.48) 48%, rgba(229,238,211,.66)),
                radial-gradient(circle at 50% 24%, rgba(255,255,255,.92), rgba(255,255,255,.26) 48%, transparent 72%);
        }

        .pb-hero::before {
            opacity: .95;
            background:
                url("{{ asset('assets/peach-blossom/pb-floral-top-corners.png') }}") center top/92% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-mountain-soft.png') }}") center 34%/104% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-tree-left.png') }}") left 44%/42% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-tree-right.png') }}") right 44%/42% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-mansion-soft.png') }}") center 76%/72% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/108% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-balcony-rail.png') }}") center bottom/104% auto no-repeat;
        }

        .pb-hero::after {
            opacity: .72;
            background:
                linear-gradient(180deg, rgba(255,255,255,.34) 0%, rgba(255,255,255,.20) 42%, rgba(255,255,255,.08) 100%),
                url("{{ asset('assets/peach-blossom/pb-haze-soft.png') }}") center/cover no-repeat;
        }

        .pb-hero-inner {
            width: min(100%, 620px);
            margin: 0 auto;
            padding: 128px 0 410px;
        }

        .pb-hero-kicker {
            color: var(--pb-ink);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 1.35rem;
            font-weight: 500;
            letter-spacing: .02em;
        }

        .pb-hero-title {
            margin-top: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: var(--pb-deep);
            font-size: clamp(3rem, 6.2vw, 6.4rem);
            line-height: .94;
            text-transform: uppercase;
        }

        .pb-hero-name { display: block; line-height: .94; }
        .pb-hero-and { display: block; margin: 0 auto; color: var(--pb-ink); font-size: clamp(2rem, 4vw, 3.2rem); line-height: .78; text-transform: none; }
        .pb-hero-date { margin-top: 26px; color: #58614b; font-size: 1.02rem; letter-spacing: .24em; font-weight: 850; }
        .pb-hero-actions { margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Couple: mengikuti halaman 2 Undangan251 - arch photo, flowers, mountain */
        .pb-couple {
            background:
                linear-gradient(180deg, rgba(255,255,255,.48), rgba(244,249,229,.72)),
                url("{{ asset('assets/peach-blossom/pb-mountain-soft.png') }}") center/cover no-repeat;
        }

        .pb-couple::before {
            opacity: .46;
            background:
                url("{{ asset('assets/peach-blossom/pb-text-paper-lines.png') }}") center top/800px auto repeat-y,
                url("{{ asset('assets/peach-blossom/pb-floral-top-corners.png') }}") center top/86% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/108% auto no-repeat;
        }

        .pb-couple-stage {
            width: min(100%, 1040px);
            margin: 48px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 28px;
            align-items: stretch;
        }

        .pb-person-card {
            position: relative;
            min-height: 660px;
            padding: 42px 32px 44px;
            border-radius: 999px 999px 42px 42px;
            background: linear-gradient(180deg, rgba(255,255,255,.64), rgba(246,249,230,.42));
            border: 1px solid rgba(99,112,76,.16);
            box-shadow: 0 30px 84px rgba(77,94,53,.12);
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            text-align: center;
        }

        .pb-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .62;
            background:
                url("{{ asset('assets/peach-blossom/pb-photo-arch-frame.png') }}") center 22px/82% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-flower-frame-left.png') }}") left 32%/45% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-flower-frame-right.png') }}") right 32%/45% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/126% auto no-repeat;
            pointer-events: none;
        }

        .pb-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: min(100%, 290px);
            margin: 0 auto;
            padding: 10px;
            border-radius: 999px 999px 32px 32px;
            background: rgba(255,255,255,.90);
            box-shadow: 0 20px 52px rgba(77,94,53,.12);
        }

        .pb-person-photo-wrap img,
        .pb-person-initial {
            width: 100%;
            aspect-ratio: 3/4;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 24px 24px;
            background: color-mix(in srgb, var(--pb-peach) 14%, white);
            color: var(--pb-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4.2rem;
            font-weight: 700;
        }

        .pb-person-content { position: relative; z-index: 2; margin-top: 32px; }
        .pb-person-subtitle {
            color: var(--pb-deep);
            font-family: "Great Vibes", Georgia, serif;
            font-size: clamp(2.4rem, 4.5vw, 4rem);
            line-height: 1;
        }
        .pb-person-name { margin: 10px 0 0; color: #272d24; font-family: Georgia,"Times New Roman",serif; font-size: clamp(1.7rem, 3vw, 2.4rem); line-height: 1.16; font-weight: 700; }
        .pb-person-family { max-width: 390px; margin: 16px auto 0; color: #566150; line-height: 1.78; }

        .pb-invitation-card {
            width: min(100%, 880px);
            margin: 0 auto;
            padding: 54px 48px;
            border-radius: 44px;
            background: linear-gradient(145deg, rgba(255,255,255,.78), rgba(249,248,231,.56));
            border: 1px solid rgba(99,112,76,.16);
            box-shadow: 0 28px 84px rgba(77,94,53,.10);
        }

        .pb-invitation-card h2 { font-size: clamp(3rem, 6vw, 6.6rem); }

        /* Save the Date */
        .pb-save-date {
            min-height: 820px;
            padding: 100px 72px 120px;
            display: grid;
            place-items: center;
        }

        .pb-save-date::before {
            opacity: .78;
            background:
                url("{{ asset('assets/peach-blossom/pb-mountain-soft.png') }}") center 42%/116% auto no-repeat;
        }

        .pb-count-panel {
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 62px 36px;
            border-radius: 46px;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(99,112,76,.16);
            box-shadow: 0 26px 72px rgba(77,94,53,.10);
            backdrop-filter: blur(8px);
        }

        .pb-count-title { font-size: clamp(3rem, 6vw, 6rem); }
        .pb-count-grid { width: min(100%, 540px); margin: 40px auto 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .pb-count-card { padding: 22px 14px; border-radius: 28px; background: rgba(255,255,255,.82); border: 1px solid rgba(99,112,76,.12); box-shadow: 0 14px 34px rgba(77,94,53,.08); }
        .pb-count-number { display: block; color: var(--pb-deep); font-family: Georgia,"Times New Roman",serif; font-size: clamp(2.5rem, 6vw, 4.6rem); line-height: 1; font-weight: 800; }
        .pb-count-label { display: block; margin-top: 8px; color: #596450; font-size: 12px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase; }
        .pb-count-actions { margin-top: 40px; }

        /* Event: mengikuti halaman 3 Undangan251 - circle panel, flowers, view location */
        .pb-event-layout {
            width: min(100%, 1040px);
            margin: 46px auto 0;
            display: grid;
            grid-template-columns: minmax(0, .96fr) minmax(340px, 1.04fr);
            gap: 34px;
            align-items: stretch;
        }

        .pb-event-layout.is-single { grid-template-columns: minmax(0, 760px); justify-content: center; }

        .pb-event-card,
        .pb-map-card {
            border-radius: 42px;
            background: linear-gradient(145deg, rgba(255,255,255,.82), rgba(249,248,231,.60));
            border: 1px solid rgba(99,112,76,.15);
            box-shadow: 0 28px 82px rgba(77,94,53,.11);
            overflow: hidden;
        }

        .pb-event-card {
            position: relative;
            padding: 64px 38px 52px;
            text-align: center;
            border-radius: 999px 999px 42px 42px;
            overflow: hidden;
        }

        .pb-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .50;
            background:
                url("{{ asset('assets/peach-blossom/pb-circle-event-bg.png') }}") center 20px/88% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-flower-side-right.png') }}") right 18%/34% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/118% auto no-repeat;
            pointer-events: none;
        }

        .pb-event-card > * { position: relative; z-index: 2; }

        .pb-event-card h3 {
            font-size: clamp(2.4rem, 4.8vw, 4.4rem);
            line-height: 1.04;
            max-width: 440px;
            margin: 0 auto;
            color: var(--pb-deep);
        }

        .pb-date-split { margin: 32px auto 24px; display: grid; grid-template-columns: 1fr auto 1fr; gap: 22px; align-items: center; width: min(100%, 520px); }
        .pb-date-side { color: #566150; font-family: Georgia,"Times New Roman",serif; font-size: 1.08rem; }
        .pb-date-center { padding: 0 26px; border-left: 1px solid rgba(99,112,76,.30); border-right: 1px solid rgba(99,112,76,.30); }
        .pb-date-center b { display: block; color: var(--pb-deep); font-family: Georgia,"Times New Roman",serif; font-size: clamp(3rem, 6vw, 5.2rem); line-height: .9; }
        .pb-date-center span { display: block; margin-top: 10px; color: #566150; font-weight: 700; }

        .pb-date-end-label { margin: 16px 0 10px; color: var(--pb-deep); font-size: .9rem; font-weight: 850; letter-spacing: .08em; text-transform: uppercase; opacity: .82; }
        .pb-date-split-end { margin-top: 0; }

        .pb-event-line { margin-top: 20px; color: #4d5849; line-height: 1.85; font-weight: 750; }
        .pb-event-place { margin-top: 30px; color: #263126; font-weight: 950; }
        .pb-event-address { margin: 10px auto 0; color: #596450; line-height: 1.75; width: min(100%, 560px); }
        .pb-event-actions { margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .pb-map-card { display: flex; flex-direction: column; min-height: 520px; }
        .pb-map-frame,
        .pb-map-placeholder { width: 100%; height: 420px; min-height: 420px; border: 0; display: block; }
        .pb-map-placeholder { display: flex; align-items: center; justify-content: center; text-align: center; text-decoration: none; color: inherit; padding: 32px; background: linear-gradient(135deg, rgba(151,168,116,.13), rgba(215,145,164,.11)), #f4f4e5; }
        .pb-map-pin { width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 999px; display: grid; place-items: center; background: var(--pb-deep); color: #fff; font-size: 2rem; box-shadow: 0 18px 40px rgba(77,94,53,.20); }
        .pb-map-footer { padding: 22px 26px; display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; background: rgba(255,255,255,.84); border-top: 1px solid rgba(99,112,76,.12); }
        .pb-map-title { margin: 0; color: #263126; font-weight: 950; }
        .pb-map-address { margin: 7px 0 0; color: #596450; line-height: 1.65; white-space: pre-line; overflow-wrap: anywhere; }

        .pb-gallery-grid {
            width: min(100%, 1040px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 110px;
            gap: 12px;
        }

        .pb-gallery-item { display: block; overflow: hidden; padding: 6px; background: rgba(255,255,255,.84); border: 1px solid rgba(99,112,76,.15); box-shadow: 0 14px 34px rgba(77,94,53,.08); border-radius: 999px 999px 24px 24px; }
        .pb-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; }
        .pb-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; border-radius: 34px; }
        .pb-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; }
        .pb-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }
        .pb-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit; transition: transform .7s ease; }
        .pb-gallery-item:hover img { transform: scale(1.055); }

        .pb-gift-grid { width: min(100%, 920px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .pb-gift-grid.is-single { grid-template-columns: minmax(0, 450px); justify-content: center; }
        .pb-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 34px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255,255,255,.88), rgba(249,248,231,.68));
            border: 1px solid rgba(99,112,76,.15);
            box-shadow: 0 18px 48px rgba(77,94,53,.10);
        }

        .pb-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: color-mix(in srgb, var(--pb-peach) 20%, transparent); transform: skewY(-7deg); }
        .pb-gift-title,.pb-gift-number,.pb-copy-btn { position: relative; z-index: 2; }
        .pb-gift-title { color: var(--pb-deep); font-weight: 950; font-size: 1.25rem; }
        .pb-gift-number { margin-top: 18px; color: #263126; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .pb-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #fffdf1; background: var(--pb-deep); font-weight: 950; cursor: pointer; }
        .pb-copy-btn.copied { background: #16803c; }

        .pb-rsvp-layout { width: min(100%, 1080px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .pb-rsvp-copy { padding: 42px 34px; border-radius: 40px; background: linear-gradient(145deg, rgba(255,255,255,.78), rgba(249,248,231,.58)); border: 1px solid rgba(99,112,76,.14); box-shadow: 0 18px 48px rgba(77,94,53,.08); }
        .pb-rsvp-copy h3 { font-size: clamp(2rem, 3.6vw, 3.5rem); }
        .pb-form-card { padding: 26px; border-radius: 28px; background: rgba(255,255,255,.86); border: 1px solid rgba(99,112,76,.14); box-shadow: 0 18px 48px rgba(77,94,53,.08); text-align: left; }
        .pb-form-label { display: block; color: var(--pb-deep); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .pb-input { width: 100%; margin-top: 8px; border: 1px solid rgba(99,112,76,.14); background: rgba(255,255,255,.94); color: var(--pb-ink); border-radius: 14px; padding: 13px 14px; outline: none; text-align: left; }
        .pb-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .pb-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; background: rgba(255,255,255,.76); border: 1px solid rgba(99,112,76,.12); }
        .pb-summary-grid b { display: block; color: var(--pb-deep); font-size: 2rem; line-height: 1; }
        .pb-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .pb-message-card { padding: 18px; border-radius: 22px; background: rgba(255,255,255,.82); border: 1px solid rgba(99,112,76,.12); box-shadow: 0 10px 24px rgba(77,94,53,.06); }

        .pb-closing-card { width: min(100%, 720px); margin: 0 auto; padding: 72px 34px 230px; text-align: center; }
        .pb-closing-card h2 { font-size: clamp(3rem, 7vw, 6.4rem); }
        .pb-closing-photo { width: 220px; height: 280px; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px 999px 28px 28px; border: 8px solid #fff; outline: 1px solid rgba(99,112,76,.20); box-shadow: 0 20px 52px rgba(77,94,53,.14); }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes pbShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes pbFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .pb-floating-actions a, .pb-floating-actions button { animation: pbFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1440px) {
            .pb-shell { width: min(100%, 1260px); }
            .pb-page { padding-left: 88px; padding-right: 88px; }
            .pb-hero-title { font-size: clamp(4rem, 6.4vw, 7.2rem); }
        }

        @media (max-width: 980px) {
            .pb-shell { padding: 14px; }
            .pb-page { padding: 90px 38px; }
            .pb-hero { min-height: 860px; padding: 64px 38px 0; }
            .pb-hero::before {
                background-size: 110% auto, 130% auto, 58% auto, 58% auto, 88% auto, 136% auto, 120% auto;
            }
            .pb-hero-inner { padding-top: 118px; padding-bottom: 360px; }
            .pb-couple-stage,
            .pb-event-layout,
            .pb-rsvp-layout { grid-template-columns: 1fr; text-align: center; }
            .pb-gift-grid { grid-template-columns: 1fr; }
            .pb-gallery-grid { grid-template-columns: repeat(6, 1fr); }
            .pb-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .pb-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .pb-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .pb-shell { padding: 0; }
            .pb-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .pb-page,
            .pb-page.slim { padding: 76px 22px; }
            .pb-floating-actions { right: 0; gap: 7px; }
            .pb-floating-actions a, .pb-floating-actions button { width: 40px; height: 40px; }
            .pb-hero { min-height: 100svh; padding: 52px 22px 0; }
            .pb-hero::before {
                background:
                    url("{{ asset('assets/peach-blossom/pb-floral-top-corners.png') }}") center top/132% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-mountain-soft.png') }}") center 34%/170% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-tree-left.png') }}") left 55%/74% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-tree-right.png') }}") right 55%/74% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-mansion-soft.png') }}") center 76%/116% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom/168% auto no-repeat,
                    url("{{ asset('assets/peach-blossom/pb-balcony-rail.png') }}") center bottom/150% auto no-repeat;
            }
            .pb-hero::after { opacity: .82; }
            .pb-hero-inner { padding-top: 104px; padding-bottom: 330px; }
            .pb-hero-title { font-size: clamp(2.55rem, 11vw, 4.4rem); gap: 6px; }
            .pb-hero-and { font-size: clamp(1.7rem, 8vw, 2.6rem); }
            .pb-hero-actions { flex-direction: column; }
            .pb-hero-actions .pb-btn, .pb-btn { width: 100%; }
            .pb-label { font-size: 10px; letter-spacing: .14em; }
            .pb-label::before, .pb-label::after { width: 18px; }
            .pb-person-card { min-height: auto; padding: 36px 20px 44px; }
            .pb-person-photo-wrap { width: 210px; }
            .pb-date-split { grid-template-columns: 1fr; gap: 14px; }
            .pb-date-center { border-left: 0; border-right: 0; border-top: 1px solid rgba(99,112,76,.25); border-bottom: 1px solid rgba(99,112,76,.25); padding: 18px 0; }
            .pb-save-date { min-height: 760px; padding: 82px 22px 100px; }
            .pb-count-panel { padding: 44px 18px; border-radius: 34px; }
            .pb-count-grid { grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; }
            .pb-count-card { padding: 18px 10px; border-radius: 22px; }
            .pb-count-number { font-size: clamp(2rem, 11vw, 3.4rem); }
            .pb-count-label { font-size: 11px; }
            .pb-map-frame, .pb-map-placeholder { height: 320px; min-height: 320px; }
            .pb-map-footer { flex-direction: column; align-items: stretch; }
            .pb-map-footer .pb-btn { width: 100%; }
            .pb-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .pb-gallery-item, .pb-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: 270px; }
            .pb-rsvp-layout { gap: 22px; }
            .pb-rsvp-copy, .pb-form-card { padding: 26px 20px; border-radius: 28px; }
            .pb-summary-grid { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        /* =====================================================
        PEACH BLOSSOM HAZE FULL WIDTH FIX
        Agar pb-haze-soft.png penuh kiri kanan tanpa space kosong
        ===================================================== */

        .pb-hero::after {
            left: -12% !important;
            right: -12% !important;
            top: 0 !important;
            bottom: 0 !important;
            width: auto !important;
            height: auto !important;
            opacity: .78 !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.36) 0%, rgba(255,255,255,.22) 42%, rgba(255,255,255,.10) 100%),
                url("{{ asset('assets/peach-blossom/pb-haze-soft.png') }}") center center / 100% 100% no-repeat !important;
        }

        /* Khusus mobile agar tetap penuh */
        @media (max-width: 640px) {
            .pb-hero::after {
                left: -22% !important;
                right: -22% !important;
                background:
                    linear-gradient(180deg, rgba(255,255,255,.38) 0%, rgba(255,255,255,.24) 42%, rgba(255,255,255,.10) 100%),
                    url("{{ asset('assets/peach-blossom/pb-haze-soft.png') }}") center center / 100% 100% no-repeat !important;
            }
        }

        /* =====================================================
        PEACH BLOSSOM PAPER LINES FULL WIDTH FIX
        Agar pb-text-paper-lines.png penuh kiri kanan
        ===================================================== */

        .pb-book::before {
            opacity: .52 !important;
            background:
                url("{{ asset('assets/peach-blossom/pb-text-paper-lines.png') }}") center top / 100% auto repeat-y,
                linear-gradient(90deg, rgba(96,112,79,.030) 1px, transparent 1px) 0 0 / 44px 44px,
                linear-gradient(0deg, rgba(96,112,79,.026) 1px, transparent 1px) 0 0 / 44px 44px !important;
        }

        .pb-couple::before {
            opacity: .46 !important;
            background:
                url("{{ asset('assets/peach-blossom/pb-text-paper-lines.png') }}") center top / 100% auto repeat-y,
                url("{{ asset('assets/peach-blossom/pb-floral-top-corners.png') }}") center top / 86% auto no-repeat,
                url("{{ asset('assets/peach-blossom/pb-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat !important;
        }

    </style>
</head>

@php
    $pbThemeKey = $invitation->theme_color ?: 'rose';

    $pbThemes = [
        'maroon' => [
            'paper' => '#fff8ed',
            'mist' => '#f3e9df',
            'sageSoft' => '#e6ead6',
            'sage' => '#9dae7d',
            'olive' => '#6d7652',
            'deep' => '#7a3d45',
            'ink' => '#332a28',
            'peach' => '#efb39d',
            'lavender' => '#b99ac7',
        ],

        'emerald' => [
            'paper' => '#fbfae9',
            'mist' => '#e7efdc',
            'sageSoft' => '#d5e2c8',
            'sage' => '#8fa46f',
            'olive' => '#556c45',
            'deep' => '#536947',
            'ink' => '#293528',
            'peach' => '#f1b59d',
            'lavender' => '#a99bc8',
        ],

        'navy' => [
            'paper' => '#f8f8ee',
            'mist' => '#e7edf4',
            'sageSoft' => '#dbe5d4',
            'sage' => '#8fa284',
            'olive' => '#536b64',
            'deep' => '#465f79',
            'ink' => '#26303a',
            'peach' => '#efb79f',
            'lavender' => '#9ca6c9',
        ],

        'rose' => [
            'paper' => '#fff7ee',
            'mist' => '#f4e9e5',
            'sageSoft' => '#e4ead4',
            'sage' => '#9daf7b',
            'olive' => '#7a6946',
            'deep' => '#8a6b4b',
            'ink' => '#342b27',
            'peach' => '#e9a38f',
            'lavender' => '#b89cc7',
        ],

        'gold' => [
            'paper' => '#fffbea',
            'mist' => '#f2f1df',
            'sageSoft' => '#dee6cd',
            'sage' => '#9cac78',
            'olive' => '#6b7049',
            'deep' => '#7a6638',
            'ink' => '#2e3229',
            'peach' => '#f4c0a3',
            'lavender' => '#b6a0c7',
        ],

        'slate' => [
            'paper' => '#fbfaf0',
            'mist' => '#e7e9e8',
            'sageSoft' => '#d9e0d0',
            'sage' => '#8f9b82',
            'olive' => '#5f6757',
            'deep' => '#5f6762',
            'ink' => '#2b302e',
            'peach' => '#e8ad96',
            'lavender' => '#a9a0bd',
        ],
    ];

    $pbTheme = $pbThemes[$pbThemeKey] ?? $pbThemes['rose'];
@endphp

<body style="
    --pb-paper: {{ $pbTheme['paper'] }};
    --pb-mist: {{ $pbTheme['mist'] }};
    --pb-sage-soft: {{ $pbTheme['sageSoft'] }};
    --pb-sage: {{ $pbTheme['sage'] }};
    --pb-olive: {{ $pbTheme['olive'] }};
    --pb-deep: {{ $pbTheme['deep'] }};
    --pb-ink: {{ $pbTheme['ink'] }};
    --pb-peach: {{ $pbTheme['peach'] }};
    --pb-lavender: {{ $pbTheme['lavender'] }};
">

@php
    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = $invitation->title ?: 'Stella & Devian';
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Stella');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Devian');
    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/peach-blossom/pb-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;
    $hasDifferentEndDate = !empty($invitation->event_end_date) && $endDate && $startDate && !$startDate->isSameDay($endDate);

    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Sunday';
    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '19 . 10 . 25';
    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : '19 October 2025';

    $endDayText = $endDate ? $endDate->translatedFormat('l') : null;
    $endMonthText = $endDate ? $endDate->translatedFormat('F') : null;
    $endYearText = $endDate ? $endDate->translatedFormat('Y') : null;
    $endDayNumber = $endDate ? $endDate->format('d') : null;

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }

    $locationText = $invitation->location_name ?: 'St. Yohanes Penginjil Church';
    $addressText = $invitation->address ?: 'Jl. Melawai Raya No. 197, RT. 01 / RW. 06, Kramat Pela, Kebayoran Baru';
    $descriptionText = $invitation->description ?: 'By the grace and blessing of God, we request the honour of your presence at the wedding of:';

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

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;
    if (!$mapEmbedUrl && $mapOpenUrl && \Illuminate\Support\Str::contains($mapOpenUrl, 'google.com/maps')) {
        $mapEmbedUrl = $mapOpenUrl;
    }

    $shareUrl = route('invitation.public', $invitation->slug);
    $shareMessage = "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n" .
        "*" . ($invitation->event_name ?: 'The Wedding Of') . "*\n" .
        "*{$brideName} & {$groomName}*\n\n" .
        "Tanggal: {$eventDateRangeText}\n";

    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    if ($addressText) { $shareMessage .= "Alamat: {$addressText}\n"; }
    if ($mapOpenUrl) { $shareMessage .= "Maps: {$mapOpenUrl}\n"; }

    $shareMessage .= "\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\n" .
        "Klik link undangan berikut:\n{$shareUrl}\n\n" .
        "Terima kasih.\nWassalamu'alaikum Wr. Wb.";
    $shareText = rawurlencode($shareMessage);

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
            . '&text=' . rawurlencode(($invitation->event_name ?: 'Wedding Event') . ' - ' . $brideName . ' & ' . $groomName)
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

<div class="pb-shell">
    <main class="pb-book" id="top">
        <div class="pb-floating-actions" aria-label="Aksi undangan">
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

        <section id="opening" class="pb-page pb-hero">
            <div class="pb-hero-inner" data-reveal="zoom">
                <p class="pb-hero-kicker responsive-text">{{ $invitation->event_name ?: 'The Wedding Of' }}</p>

                <h1 class="pb-title pb-hero-title responsive-text">
                    <span class="pb-hero-name">{{ $brideName }}</span>
                    <span class="pb-script pb-hero-and">&</span>
                    <span class="pb-hero-name">{{ $groomName }}</span>
                </h1>

                <p class="pb-hero-date responsive-text">{{ $eventDateShort }}</p>

                <div class="pb-hero-actions">
                    <a href="#couple" class="pb-btn">Buka Undangan</a>
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="pb-btn light">Save the Date</a>
                </div>
            </div>
        </section>

        <section id="couple" class="pb-page pb-couple">
            <p class="pb-label" data-reveal="zoom">Bride & Groom</p>
            <h2 class="pb-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6.2rem);">Bride & Groom</h2>
            <p class="pb-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $descriptionText }}</p>

            <div class="pb-couple-stage">
                <article class="pb-person-card" data-reveal="left">
                    <div class="pb-person-photo-wrap">
                        @if ($bridePhoto)
                            <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                        @else
                            <div class="pb-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                        @endif
                    </div>

                    <div class="pb-person-content">
                        <div class="pb-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                        <h3 class="pb-person-name responsive-text">{{ $brideName }}</h3>
                        <p class="pb-person-family responsive-text">{{ $bride->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>

                <article class="pb-person-card" data-reveal="right" style="--reveal-delay:.10s">
                    <div class="pb-person-photo-wrap">
                        @if ($groomPhoto)
                            <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                        @else
                            <div class="pb-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                        @endif
                    </div>

                    <div class="pb-person-content">
                        <div class="pb-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                        <h3 class="pb-person-name responsive-text">{{ $groomName }}</h3>
                        <p class="pb-person-family responsive-text">{{ $groom->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="invitation" class="pb-page slim">
            <div class="pb-invitation-card" data-reveal="zoom">
                <p class="pb-label">With Love</p>
                <h2 class="pb-title pb-script responsive-text">Undangan Pernikahan</h2>
                <p class="pb-note responsive-text">Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu pada hari bahagia kami.</p>
            </div>
        </section>

        <section id="countdown" class="pb-page pb-save-date">
            <div class="pb-count-panel" data-reveal="zoom">
                <h2 class="pb-title pb-script pb-count-title responsive-text">Save The Date</h2>
                <div class="pb-count-grid" data-countdown="{{ $targetDateTime }}">
                    <div class="pb-count-card"><span class="pb-count-number" data-days>0</span><span class="pb-count-label">Days</span></div>
                    <div class="pb-count-card"><span class="pb-count-number" data-hours>0</span><span class="pb-count-label">Hours</span></div>
                    <div class="pb-count-card"><span class="pb-count-number" data-minutes>0</span><span class="pb-count-label">Minutes</span></div>
                    <div class="pb-count-card"><span class="pb-count-number" data-seconds>0</span><span class="pb-count-label">Seconds</span></div>
                </div>
                <div class="pb-count-actions"><a href="{{ $googleCalendarUrl }}" target="_blank" class="pb-btn">Add to Calendar</a></div>
            </div>
        </section>

        <section id="acara" class="pb-page">
            <p class="pb-label" data-reveal="zoom">Wedding Details</p>
            <h2 class="pb-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6.2rem);">Wedding Details</h2>
            <p class="pb-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Together with joyful hearts and the grace of God, we cordially request the honour of your presence at our wedding celebration:</p>

            <div class="pb-event-layout {{ ($mapOpenUrl || $mapEmbedUrl) ? '' : 'is-single' }}">
                <article class="pb-event-card" data-reveal="zoom">
                    <h3 class="pb-title pb-script responsive-text">Acara Pernikahan</h3>

                    <div class="pb-date-split">
                        <div class="pb-date-side">{{ $eventDayText }}</div>

                        <div class="pb-date-center">
                            <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                            <span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span>
                        </div>

                        <div class="pb-date-side">{{ $startDate ? $startDate->translatedFormat('F') : '' }}</div>
                    </div>

                    @if ($hasDifferentEndDate)
                        <div class="pb-date-end-label">Sampai</div>

                        <div class="pb-date-split pb-date-split-end">
                            <div class="pb-date-side">{{ $endDayText }}</div>

                            <div class="pb-date-center">
                                <b>{{ $endDayNumber }}</b>
                                <span>{{ $endYearText }}</span>
                            </div>

                            <div class="pb-date-side">{{ $endMonthText }}</div>
                        </div>
                    @endif

                    @if ($eventTimeText)
                        <p class="pb-event-line responsive-text">{{ $eventTimeText }}</p>
                    @endif

                    <p class="pb-event-place responsive-text">{{ $locationText }}</p>
                    <p class="pb-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="pb-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="pb-btn">View Location</a>
                        @endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="pb-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="pb-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe class="pb-map-frame" src="{{ $mapEmbedUrl }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="pb-map-placeholder">
                                <div>
                                    <div class="pb-map-pin">⌖</div>
                                    <strong>{{ $locationText }}</strong>
                                </div>
                            </a>
                        @endif

                        <div class="pb-map-footer">
                            <div>
                                <p class="pb-map-title responsive-text">{{ $locationText }}</p>
                                <p class="pb-map-address responsive-text">{{ $addressText }}</p>
                            </div>
                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="pb-btn">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section id="story" class="pb-page slim">
            <p class="pb-label" data-reveal="zoom">Love Story</p>
            <h2 class="pb-title pb-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Love Story</h2>
            <div class="pb-invitation-card" data-reveal="zoom" style="margin-top:42px;">
                <p class="pb-note responsive-text">Aku memandangmu tanpa perlu menatap, aku mendengar tanpa alat, aku menemui tanpa perlu hadir. Karena kini kumiliki segalanya.</p>
            </div>
        </section>

        @if ($galleryPhotos->count())
            <section id="galeri" class="pb-page">
                <p class="pb-label" data-reveal="zoom">Our Gallery</p>
                <h2 class="pb-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Precious Moment</h2>
                <div class="pb-gallery-grid">
                    @foreach ($galleryPhotos as $photo)
                        @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp
                        @if ($src)
                            <a href="{{ $src }}" target="_blank" class="pb-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s">
                                <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($gifts->count())
            <section id="gift" class="pb-page slim">
                <p class="pb-label" data-reveal="zoom">Wedding Gift</p>
                <h2 class="pb-title pb-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Tanda Kasih</h2>
                <p class="pb-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                <div class="pb-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                    @foreach ($gifts as $gift)
                        <div class="pb-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                            <div class="pb-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                            <div class="pb-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                            <p class="responsive-text" style="position:relative;z-index:2;margin:12px 0 0;color:#6b705d;">{{ $gift->account_name ?? $eventTitle }}</p>
                            <button type="button" class="pb-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">Salin Nomor</button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section id="rsvp" class="pb-page slim">
            <p class="pb-label" data-reveal="zoom">RSVP</p>
            <h2 class="pb-title pb-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Kirim Pesan</h2>

            <div class="pb-rsvp-layout">
                <div class="pb-rsvp-copy" data-reveal="left">
                    <h3 class="pb-title pb-script responsive-text">Kehadiran Anda</h3>
                    <p class="pb-note responsive-text" style="margin-left:0;">Mohon konfirmasi kehadiran dan kirimkan doa terbaik untuk kedua mempelai.</p>
                </div>

                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="pb-form-card space-y-4" data-reveal="right">
                    @csrf
                    <div>
                        <label class="pb-form-label">Nama</label>
                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="pb-input" placeholder="Nama lengkap" required>
                    </div>

                    <div>
                        <label class="pb-form-label">Konfirmasi Kehadiran</label>
                        <select name="attendance_status" class="pb-input">
                            <option value="">Pilih status kehadiran</option>
                            <option value="hadir">Saya berencana hadir</option>
                            <option value="tidak_hadir">Tidak bisa hadir</option>
                            <option value="ragu">Masih ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="pb-form-label">Jumlah Tamu</label>
                        <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="pb-input">
                    </div>

                    <div>
                        <label class="pb-form-label">Pesan</label>
                        <textarea name="message" rows="4" class="pb-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="pb-btn" style="width:100%;">Kirim Pesan</button>
                </form>

                <div class="pb-summary-grid" data-reveal="zoom">
                    <div><b>{{ $tidakHadir }}</b><span>Tidak Hadir</span></div>
                    <div><b>{{ $hadir }}</b><span>Hadir</span></div>
                    <div><b>{{ $ragu }}</b><span>Ragu</span></div>
                </div>

                <div class="pb-message-list">
                    @forelse ($messages->take(5) as $message)
                        <div class="pb-message-card" data-reveal="zoom">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="responsive-text font-black" style="color:var(--pb-deep);">{{ $message->guest_name }}</p>
                                    <p class="text-xs mt-1" style="color:#7a806f">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                @if ($message->attendance_status)
                                    <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(111,119,79,.12);color:var(--pb-deep);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                @endif
                            </div>
                            <p class="responsive-text mt-3" style="color:#596450;line-height:1.8;">{{ $message->message }}</p>
                        </div>
                    @empty
                        <div class="pb-message-card text-center" style="color:#7a806f;">Belum ada ucapan.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="closing" class="pb-page pb-hero">
            <div class="pb-closing-card" data-reveal="zoom">
                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="pb-closing-photo">
                <p class="pb-note responsive-text" style="margin-bottom:18px;">Terima Kasih</p>
                <h2 class="pb-title responsive-text">{{ $brideName }} & {{ $groomName }}</h2>
                <p class="pb-note responsive-text">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu. Atas kehadiran dan doa restunya kami ucapkan terima kasih.</p>
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
                    setTimeout(() => {
                        button.classList.remove('copied');
                        button.textContent = old;
                    }, 1300);
                } catch (error) {}
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('is-visible');
            });
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
        if (!['input', 'textarea', 'select', 'option'].includes(tag)) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
