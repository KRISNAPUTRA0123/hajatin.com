<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Soft Sakura'));
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
            color: var(--ss-ink);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--ss-pink) 20%, transparent), transparent 30%),
                radial-gradient(circle at 88% 10%, color-mix(in srgb, var(--ss-blue) 16%, transparent), transparent 32%),
                linear-gradient(180deg, var(--ss-paper) 0%, var(--ss-soft) 48%, #f7fbff 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
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

        .ss-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .ss-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 36px;
            border: 1px solid rgba(120, 145, 155, .18);
            background:
                linear-gradient(180deg, rgba(255,255,255,.72), rgba(250,244,248,.68)),
                url("{{ asset('assets/soft-sakura/ss-paper-texture.png') }}") center / cover repeat,
                var(--ss-paper);
            box-shadow: 0 42px 130px rgba(89, 102, 112, .16);
        }

        .ss-book::before,
        .ss-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .ss-book::before {
            opacity: .34;
            background:
                url("{{ asset('assets/soft-sakura/ss-sakura-corner-left.png') }}") left top / 250px auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-sakura-corner-right.png') }}") right top / 250px auto no-repeat,
                linear-gradient(90deg, rgba(88, 112, 126, .025) 1px, transparent 1px) 0 0 / 42px 42px,
                linear-gradient(0deg, rgba(88, 112, 126, .022) 1px, transparent 1px) 0 0 / 42px 42px;
        }

        .ss-book::after {
            opacity: .42;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.82), transparent 38%),
                radial-gradient(circle at 50% 72%, color-mix(in srgb, var(--ss-pink) 14%, transparent), transparent 42%);
        }

        .ss-book > * { position: relative; z-index: 2; }

        .ss-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(121, 145, 156, .16);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(74, 91, 103, .13);
            backdrop-filter: blur(14px);
        }

        .ss-floating-actions a,
        .ss-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(74, 91, 103, .11);
            transition: transform .25s ease, background .25s ease;
        }

        .ss-floating-actions a:hover,
        .ss-floating-actions button:hover { transform: translateX(-3px); }
        .ss-floating-actions button.is-active { background: color-mix(in srgb, var(--ss-pink) 34%, white); }
        .ss-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .ss-page {
            position: relative;
            min-height: auto;
            padding: 104px 74px;
            overflow: hidden;
            text-align: center;
        }

        .ss-page > * { position: relative; z-index: 5; }
        .ss-page.slim { padding-top: 86px; padding-bottom: 86px; }

        .ss-page::before,
        .ss-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .ss-page::before {
            z-index: 1;
            opacity: .35;
            background:
                url("{{ asset('assets/soft-sakura/ss-floral-top-sakura.png') }}") center top / 118% auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 112% auto no-repeat;
        }

        .ss-page::after {
            z-index: 2;
            opacity: .20;
            background:
                linear-gradient(180deg, rgba(255,255,255,.18), transparent 44%, rgba(255,255,255,.22)),
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.42), transparent 48%);
        }

        .ss-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--ss-blue-deep);
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(120, 145, 155, .16);
            box-shadow: 0 12px 28px rgba(74, 91, 103, .08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .ss-label::before,
        .ss-label::after {
            content: "";
            width: 26px;
            height: 1px;
            background: var(--ss-blue-deep);
            opacity: .42;
        }

        .ss-title {
            margin: 0;
            color: var(--ss-blue-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .04em;
            line-height: .96;
            text-wrap: balance;
        }

        .ss-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .ss-note {
            width: min(100%, 700px);
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--ss-ink) 78%, transparent);
            line-height: 1.9;
        }

        .ss-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 13px 26px;
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #fffaf8;
            background: linear-gradient(135deg, var(--ss-blue-deep), var(--ss-blue));
            box-shadow: 0 16px 36px rgba(74, 91, 103, .22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .ss-btn:hover { transform: translateY(-2px); }
        .ss-btn.sakura { color: #51353c; background: linear-gradient(135deg, #fff3f5, var(--ss-pink), #e8a8b3); }
        .ss-btn.light {
            color: var(--ss-blue-deep);
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(120, 145, 155, .16);
        }

        .ss-btn::after,
        .ss-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: ssShine 4.4s ease-in-out infinite;
        }

        /* HERO */
        .ss-hero {
            min-height: 940px;
            display: grid;
            place-items: center;
            padding: 76px 72px 0;
            background:
                linear-gradient(180deg, rgba(247,253,255,.70), rgba(255,246,249,.52) 46%, rgba(245,251,255,.74)),
                url("{{ asset('assets/soft-sakura/ss-blue-sky-paper.png') }}") center / cover no-repeat,
                var(--ss-paper);
        }

        .ss-hero::before {
            opacity: .96;
            background:
                url("{{ asset('assets/soft-sakura/ss-tree-left.png') }}") left bottom / min(360px, 42vw) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-tree-right.png') }}") right bottom / min(360px, 42vw) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-gazebo-sakura.png') }}") center 56% / min(920px, 112%) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-swan-lake.png') }}") center 76% / min(560px, 78%) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 112% auto no-repeat;
        }

        .ss-hero::after {
            opacity: .68;
            background:
                linear-gradient(180deg, rgba(255,255,255,.26), rgba(255,255,255,.10) 42%, rgba(255,255,255,.24)),
                url("{{ asset('assets/soft-sakura/ss-haze-soft.png') }}") center / cover no-repeat;
        }

        .ss-hero-inner {
            width: min(100%, 580px);
            margin: 0 auto;
            padding: 135px 0 365px;
        }

        .ss-hero-kicker {
            margin: 0;
            color: var(--ss-ink);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .ss-hero-title {
            margin: 18px auto 0;
            color: var(--ss-blue-deep);
            font-size: clamp(2.8rem, 6.2vw, 5.8rem);
            line-height: .88;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ss-hero-name {
            display: block;
            line-height: .88;
            margin: 0;
        }

        .ss-hero-and {
            display: block;
            margin: -8px auto -12px;
            color: #617982;
            font-family: "Great Vibes", Georgia, serif;
            font-size: clamp(1.45rem, 2.8vw, 2.25rem);
            line-height: 1;
            text-transform: none;
            letter-spacing: 0;
        }

        .ss-hero-date {
            margin-top: 28px;
            color: var(--ss-ink);
            font-size: 1rem;
            font-weight: 850;
            letter-spacing: .24em;
        }

        .ss-hero-actions {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        /* COUPLE */
        .ss-couple {
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), rgba(248,252,255,.70)),
                url("{{ asset('assets/soft-sakura/ss-blue-sky-paper.png') }}") center / cover repeat,
                var(--ss-paper);
        }

        .ss-couple::before {
            opacity: .72;
            background:
                url("{{ asset('assets/soft-sakura/ss-floral-top-sakura.png') }}") center top / 96% auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-sakura-branch-left.png') }}") left 48% / 250px auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-sakura-branch-right.png') }}") right 48% / 250px auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 112% auto no-repeat;
        }

        .ss-couple-stack {
            width: min(100%, 820px);
            margin: 44px auto 0;
            display: grid;
            gap: 46px;
        }

        .ss-person-card {
            position: relative;
            display: grid;
            justify-items: center;
            text-align: center;
            padding: 36px 24px 44px;
            border-radius: 999px 999px 34px 34px;
            background: linear-gradient(180deg, rgba(255,255,255,.82), rgba(247,252,255,.62));
            border: 1px solid rgba(120, 145, 155, .16);
            box-shadow: 0 22px 64px rgba(74, 91, 103, .11);
            overflow: hidden;
        }

        .ss-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .28;
            background:
                url("{{ asset('assets/soft-sakura/ss-photo-arch-frame.png') }}") center 20px / min(380px, 78%) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 118% auto no-repeat;
        }

        .ss-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: min(100%, 310px);
            padding: 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(120,145,155,.16);
            box-shadow: 0 20px 52px rgba(74,91,103,.14);
        }

        .ss-person-photo-wrap img,
        .ss-person-initial {
            width: 100%;
            aspect-ratio: 4 / 5;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px;
            background: color-mix(in srgb, var(--ss-pink) 18%, white);
            color: var(--ss-blue-deep);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .ss-person-content { position: relative; z-index: 2; margin-top: 26px; }
        .ss-person-name { color: var(--ss-blue-deep); font-size: clamp(2.5rem, 5vw, 4.8rem); line-height: .96; text-transform: capitalize; }
        .ss-person-fullname { margin: 14px 0 0; color: #374f58; font-weight: 950; letter-spacing: .06em; }
        .ss-person-family { width: min(100%, 430px); margin: 14px auto 0; color: rgba(56, 73, 82, .76); line-height: 1.78; font-weight: 650; }
        .ss-person-subtitle { width: fit-content; margin: 14px auto 0; padding: 7px 18px; border-radius: 999px; color: var(--ss-blue-deep); background: rgba(255,255,255,.76); border: 1px solid rgba(120,145,155,.15); font-size: 10px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .ss-instagram-btn { margin-top: 18px; min-height: 38px; padding: 10px 22px; font-size: .78rem; }

        /* LOVE STORY */
        .ss-story {
            background:
                linear-gradient(180deg, rgba(248,253,255,.82), rgba(255,247,250,.76)),
                url("{{ asset('assets/soft-sakura/ss-card-arch-bg.png') }}") center / cover no-repeat,
                var(--ss-paper);
        }

        .ss-story-card {
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 54px 38px 64px;
            border-radius: 46px;
            background: rgba(255,255,255,.80);
            border: 1px solid rgba(120,145,155,.15);
            box-shadow: 0 24px 74px rgba(74,91,103,.11);
            backdrop-filter: blur(8px);
        }

        .ss-story-card h2 { font-size: clamp(2.2rem, 5vw, 4.2rem); }

        /* COUNTDOWN */
        .ss-save-date {
            min-height: 820px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.84), rgba(248,252,255,.70)),
                url("{{ asset('assets/soft-sakura/ss-blue-sky-paper.png') }}") center / cover no-repeat,
                var(--ss-paper);
        }

        .ss-count-date {
            display: inline-block;
            width: fit-content;
            max-width: min(100%, 420px);
            margin: 28px auto 0;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--ss-blue-deep);
            background: rgba(255, 255, 255, .68);
            border: 1px solid rgba(120, 145, 155, .16);
            box-shadow: 0 10px 26px rgba(74, 91, 103, .08);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            font-size: clamp(.95rem, 2.2vw, 1.12rem);
            font-weight: 750;
            line-height: 1.45;
            letter-spacing: .02em;
            text-align: center;
            text-shadow: 0 1px 1px rgba(255, 255, 255, .85);
        }

        .ss-save-date::before {
            opacity: .76;
            background:
                url("{{ asset('assets/soft-sakura/ss-floral-top-sakura.png') }}") center top / 94% auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-gazebo-sakura.png') }}") center 50% / 114% auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 112% auto no-repeat;
        }

        .ss-count-panel {
            width: min(100%, 650px);
            margin: 0 auto;
            padding: 78px 28px 94px;
            text-align: center;
        }

        .ss-count-title { font-size: clamp(2.4rem, 5.4vw, 5rem); color: var(--ss-blue-deep); }

        .ss-count-grid {
            width: min(100%, 470px);
            margin: 38px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .ss-count-card {
            padding: 22px 12px;
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,.93), rgba(255,244,248,.74));
            border: 1px solid rgba(120,145,155,.14);
            box-shadow: 0 14px 34px rgba(74,91,103,.08);
        }

        .ss-count-number { display: block; color: var(--ss-blue-deep); font-family: Georgia, serif; font-size: clamp(2.1rem, 5vw, 3.6rem); line-height: 1; font-weight: 800; }
        .ss-count-label { display: block; margin-top: 7px; color: var(--ss-ink); font-size: .72rem; font-weight: 950; letter-spacing: .08em; text-transform: uppercase; }
        .ss-count-actions { margin-top: 34px; }

        /* EVENT */
        .ss-event {
            background:
                radial-gradient(circle at 50% 28%, rgba(255,255,255,.74), transparent 42%),
                linear-gradient(180deg, rgba(248,253,255,.84), rgba(255,247,250,.72)),
                url("{{ asset('assets/soft-sakura/ss-card-arch-bg.png') }}") center / cover no-repeat,
                var(--ss-paper);
        }

        .ss-event::before {
            opacity: .78;
            background:
                url("{{ asset('assets/soft-sakura/ss-photo-arch-frame.png') }}") center 50px / min(760px, 92%) auto no-repeat,
                url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 114% auto no-repeat;
        }

        .ss-event-card {
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 116px 38px 70px;
            text-align: center;
            border-radius: 52px;
            background: rgba(255,255,255,.64);
            border: 1px solid rgba(120,145,155,.13);
            box-shadow: 0 24px 74px rgba(74,91,103,.10);
            backdrop-filter: blur(6px);
        }

        .ss-event-card h2 { color: var(--ss-blue-deep); font-size: clamp(2.2rem, 4.8vw, 4.2rem); line-height: 1.06; }
        .ss-event-date-list { width: min(100%, 430px); margin: 32px auto 0; display: grid; gap: 14px; }
        .ss-event-date-item { display: grid; gap: 8px; }
        .ss-event-date-item span { color: var(--ss-blue); font-size: .74rem; font-weight: 950; letter-spacing: .18em; text-transform: uppercase; }
        .ss-event-date-item strong { color: #344a54; font-size: clamp(1rem, 2vw, 1.15rem); font-weight: 950; letter-spacing: .08em; text-transform: uppercase; line-height: 1.6; }
        .ss-event-date-until { width: fit-content; margin: 0 auto; padding: 6px 16px; border-radius: 999px; color: #fff; background: var(--ss-blue); font-size: .78rem; font-weight: 850; }
        .ss-event-line { margin: 24px auto 0; color: #344a54; font-weight: 850; line-height: 1.8; }
        .ss-event-place { margin: 30px auto 0; color: #344a54; font-weight: 950; letter-spacing: .04em; text-transform: uppercase; }
        .ss-event-address { width: min(100%, 500px); margin: 10px auto 0; color: rgba(52,74,84,.76); line-height: 1.75; }
        .ss-event-actions { margin-top: 28px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .ss-map-card,
        .ss-gift-card,
        .ss-rsvp-copy,
        .ss-form-card,
        .ss-message-card,
        .ss-closing-card {
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(120,145,155,.13);
            box-shadow: 0 18px 48px rgba(74,91,103,.10);
        }

        .ss-map-card { width: min(100%, 830px); margin: 34px auto 0; overflow: hidden; border-radius: 30px; }
        .ss-map-frame, .ss-map-placeholder { width: 100%; height: 360px; min-height: 360px; border: 0; display: block; }
        .ss-map-placeholder { display: flex; align-items: center; justify-content: center; color: var(--ss-blue-deep); text-decoration: none; padding: 28px; background: rgba(255,255,255,.58); }
        .ss-map-footer { padding: 20px 22px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; text-align: left; background: rgba(255,255,255,.86); border-top: 1px solid rgba(120,145,155,.12); }
        .ss-map-title { margin: 0; color: var(--ss-blue-deep); font-weight: 950; }
        .ss-map-address { margin: 6px 0 0; color: rgba(52,74,84,.72); line-height: 1.6; white-space: pre-line; overflow-wrap: anywhere; }

        /* GIFT, GALLERY, RSVP, CLOSING */
        .ss-gift, .ss-gallery, .ss-rsvp, .ss-closing {
            background:
                radial-gradient(circle at 50% 18%, rgba(255,255,255,.72), transparent 34%),
                linear-gradient(180deg, rgba(248,253,255,.86), rgba(255,247,250,.82)),
                url("{{ asset('assets/soft-sakura/ss-blue-sky-paper.png') }}") center / cover no-repeat,
                var(--ss-paper);
        }

        .ss-gift-grid { width: min(100%, 850px); margin: 44px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .ss-gift-grid.is-single { grid-template-columns: minmax(0, 440px); justify-content: center; }
        .ss-gift-card { position: relative; overflow: hidden; min-height: 220px; padding: 38px 30px; border-radius: 28px; text-align: center; }
        .ss-gift-title { color: var(--ss-blue-deep); font-family: Georgia, serif; font-size: 1.35rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .ss-gift-number { margin-top: 18px; color: #344a54; font-size: clamp(1.45rem, 4vw, 2.2rem); font-weight: 950; }
        .ss-copy-btn { position: relative; overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #fff8f8; background: var(--ss-blue); font-weight: 950; cursor: pointer; }
        .ss-copy-btn.copied { background: #16803c; color: #fff; }

        .ss-gallery-grid { width: min(100%, 860px); margin: 44px auto 0; display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); grid-auto-rows: 110px; grid-auto-flow: dense; gap: 14px; }
        .ss-gallery-item { display: block; overflow: hidden; border-radius: 999px 999px 24px 24px; background: var(--ss-blue-deep); border: 7px solid rgba(255,255,255,.88); box-shadow: 0 16px 38px rgba(74,91,103,.13); }
        .ss-gallery-item:nth-child(1) { grid-column: span 12; grid-row: span 3; }
        .ss-gallery-item:nth-child(n + 2) { grid-column: span 3; grid-row: span 2; }
        .ss-gallery-item img { width: 100%; height: 100%; display: block; object-fit: cover; transition: transform .7s ease; }
        .ss-gallery-item:hover img { transform: scale(1.055); }

        .ss-rsvp-layout { width: min(100%, 960px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(260px, .86fr) minmax(390px, 1.14fr); gap: 32px; align-items: start; text-align: left; }
        .ss-rsvp-copy { position: relative; overflow: hidden; padding: 34px 24px 30px; border-radius: 28px; backdrop-filter: blur(8px); }
        .ss-rsvp-copy h3 { font-size: clamp(1.8rem, 4vw, 3.2rem); line-height: 1.05; word-break: break-word; overflow-wrap: anywhere; }
        .ss-form-card { padding: 28px; border-radius: 28px; color: var(--ss-ink); }
        .ss-form-label { display: block; color: var(--ss-blue-deep); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; }
        .ss-input { width: 100%; margin-top: 8px; border: 1px solid rgba(120,145,155,.18); background: rgba(255,255,255,.98); color: var(--ss-ink); border-radius: 12px; padding: 13px 14px; outline: none; }
        .ss-summary-grid { grid-column: 1 / -1; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .ss-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; background: rgba(255,255,255,.62); border: 1px solid rgba(120,145,155,.12); box-shadow: 0 10px 28px rgba(74,91,103,.08); }
        .ss-summary-grid b { display: block; color: var(--ss-blue-deep); font-size: 2rem; line-height: 1; }
        .ss-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 10px; }
        .ss-message-card { padding: 18px; border-radius: 22px; }

        .ss-closing { min-height: 820px; display: grid; place-items: center; }
        .ss-closing-card { position: relative; overflow: hidden; width: min(100%, 640px); margin: 0 auto; padding: 60px 36px 120px; border-radius: 34px; backdrop-filter: blur(10px); }
        .ss-closing-photo { width: min(100%, 240px); aspect-ratio: 1 / 1; margin: 0 auto 28px; display: block; object-fit: cover; border-radius: 50%; border: 8px solid rgba(255,255,255,.94); box-shadow: 0 20px 54px rgba(74,91,103,.18); }

        [data-reveal] { opacity: 0; transform: translateY(32px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0, 0) scale(1); filter: blur(0); }

        @keyframes ssShine { 0%, 48% { left: -88%; } 76%, 100% { left: 135%; } }
        @keyframes ssPetalFloat { 0% { transform: translateY(-12vh) rotate(0deg); opacity: 0; } 12% { opacity: .62; } 100% { transform: translateY(112vh) rotate(220deg); opacity: 0; } }

        .ss-petal-layer { position: fixed; inset: 0; z-index: 9999; pointer-events: none; overflow: hidden; }
        .ss-petal-layer span { position: absolute; top: -10vh; width: 18px; height: 18px; background: url("{{ asset('assets/soft-sakura/ss-petal.png') }}") center / contain no-repeat; opacity: .55; animation: ssPetalFloat linear infinite; }
        .ss-petal-layer span:nth-child(1) { left: 8%; animation-duration: 13s; animation-delay: 0s; }
        .ss-petal-layer span:nth-child(2) { left: 20%; animation-duration: 16s; animation-delay: 2s; }
        .ss-petal-layer span:nth-child(3) { left: 38%; animation-duration: 14s; animation-delay: 4s; }
        .ss-petal-layer span:nth-child(4) { left: 55%; animation-duration: 18s; animation-delay: 1s; }
        .ss-petal-layer span:nth-child(5) { left: 72%; animation-duration: 15s; animation-delay: 3s; }
        .ss-petal-layer span:nth-child(6) { left: 88%; animation-duration: 17s; animation-delay: 5s; }

        @media (max-width: 980px) {
            .ss-shell { padding: 14px; }
            .ss-page { padding: 92px 36px; }
            .ss-hero { min-height: 860px; padding: 66px 36px 0; }
            .ss-hero::before {
                background:
                    url("{{ asset('assets/soft-sakura/ss-tree-left.png') }}") left bottom / 48% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-tree-right.png') }}") right bottom / 48% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-gazebo-sakura.png') }}") center 55% / 142% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-swan-lake.png') }}") center 76% / 96% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 142% auto no-repeat;
            }
            .ss-hero-inner { padding-top: 130px; padding-bottom: 310px; }
            .ss-rsvp-layout { grid-template-columns: 1fr; }
            .ss-gift-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .ss-shell { padding: 0; }
            .ss-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .ss-page, .ss-page.slim { padding: 76px 22px; }
            .ss-floating-actions a, .ss-floating-actions button { width: 40px; height: 40px; }

            .ss-hero-title {
                width: min(100%, 420px);
                margin-top: 10px;
                font-size: clamp(2.35rem, 11vw, 3.9rem);
                line-height: .68;
                letter-spacing: .045em;
            }

            .ss-hero-name {
                display: block;
                line-height: .88;
                margin: 0;
            }

            .ss-hero-and {
                display: block;
                margin: -10px auto -12px;
                font-size: clamp(1.15rem, 5.5vw, 1.65rem);
                line-height: 1;
            }

            .ss-page::before {
                background:
                    url("{{ asset('assets/soft-sakura/ss-floral-top-sakura.png') }}") center top / 150% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 170% auto no-repeat;
            }

            .ss-count-date {
                margin-top: 24px;
                padding: 8px 15px;
                max-width: min(100%, 320px);
                font-size: .92rem;
                line-height: 1.45;
            }

            .ss-hero { min-height: 100svh; padding: 54px 22px 0; }
            .ss-hero::before {
                background:
                    url("{{ asset('assets/soft-sakura/ss-tree-left.png') }}") left bottom / 78% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-tree-right.png') }}") right bottom / 78% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-gazebo-sakura.png') }}") center 53% / 205% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-swan-lake.png') }}") center 75% / 132% auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 168% auto no-repeat;
            }
            .ss-hero-inner { padding-top: 108px; padding-bottom: 290px; }
            .ss-hero-kicker { font-size: 11px; letter-spacing: .19em; }

            .ss-person-card { padding: 30px 18px 40px; }
            .ss-person-photo-wrap { width: min(100%, 245px); }
            .ss-couple-stack { gap: 28px; }

            .ss-count-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
            .ss-count-card { border-radius: 22px; padding: 18px 10px; }

            .ss-event { padding: 66px 12px 78px; }
            .ss-event::before {
                background:
                    url("{{ asset('assets/soft-sakura/ss-photo-arch-frame.png') }}") center 36px / min(410px, 108%) auto no-repeat,
                    url("{{ asset('assets/soft-sakura/ss-floral-bottom-sakura.png') }}") center bottom / 170% auto no-repeat;
            }
            .ss-event-card { width: min(100%, 360px); padding: 100px 22px 56px; border-radius: 38px; }
            .ss-event-card h2 { width: min(100%, 280px); margin: 0 auto; font-size: clamp(1.85rem, 8vw, 2.45rem); line-height: 1.08; }
            .ss-event-date-list { margin-top: 22px; gap: 10px; }
            .ss-event-line { margin-top: 18px; }
            .ss-event-place { margin-top: 20px; font-size: .9rem; }
            .ss-event-address { width: min(100%, 280px); font-size: .86rem; line-height: 1.65; }
            .ss-event-actions { margin-top: 22px; }

            .ss-event-actions, .ss-hero-actions { flex-direction: column; align-items: center; }
            .ss-event-actions .ss-btn, .ss-hero-actions .ss-btn { width: min(100%, 280px); }

            .ss-map-frame, .ss-map-placeholder { height: 310px; min-height: 310px; }
            .ss-map-footer { flex-direction: column; align-items: stretch; }

            .ss-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-auto-rows: 132px; }
            .ss-gallery-item:nth-child(1), .ss-gallery-item:nth-child(n + 2) { grid-column: span 1; grid-row: span 1; }
            .ss-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }

            .ss-summary-grid { grid-template-columns: 1fr; }
            .ss-rsvp-copy { padding: 28px 18px 24px; }
            .ss-rsvp-copy h3 { font-size: clamp(1.65rem, 8vw, 2.5rem); line-height: 1.02; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
            .ss-petal-layer { display: none !important; }
        }
    </style>
</head>

@php
    $ssThemeKey = $invitation->theme_color ?: 'rose';

    $ssThemes = [
        'maroon' => [
            'paper' => '#fbf1ee',
            'soft' => '#f1ded9',
            'ink' => '#4d2930',
            'blue' => '#8d5a65',
            'blue_deep' => '#663443',
            'pink' => '#efc4c9',
        ],
        'emerald' => [
            'paper' => '#f2f9f3',
            'soft' => '#dfeee3',
            'ink' => '#2a3d31',
            'blue' => '#7aa088',
            'blue_deep' => '#2f6b45',
            'pink' => '#f0c5cc',
        ],
        'navy' => [
            'paper' => '#eef4fb',
            'soft' => '#dfe8f2',
            'ink' => '#26384a',
            'blue' => '#55718b',
            'blue_deep' => '#253f5b',
            'pink' => '#e7c0cf',
        ],
        'rose' => [
            'paper' => '#fff4f6',
            'soft' => '#f7e0e6',
            'ink' => '#5d3d48',
            'blue' => '#b56f82',
            'blue_deep' => '#6d3448',
            'pink' => '#f2bdc9',
        ],
        'gold' => [
            'paper' => '#fbf5e8',
            'soft' => '#efe3c7',
            'ink' => '#4e3e25',
            'blue' => '#b89d5c',
            'blue_deep' => '#755d2b',
            'pink' => '#f1c5ba',
        ],
        'slate' => [
            'paper' => '#f0f4f6',
            'soft' => '#dde5e8',
            'ink' => '#29343a',
            'blue' => '#64748b',
            'blue_deep' => '#334155',
            'pink' => '#e8c5cd',
        ],
    ];

    $ssTheme = $ssThemes[$ssThemeKey] ?? $ssThemes['rose'];

    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'Winsen & Fenny');
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Winsen');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Fenny');

    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/soft-sakura/ss-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;

    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '22 . 02 . 26';
    $eventDateText = $startDate ? $startDate->translatedFormat('l, d F Y') : 'Minggu, 22 Februari 2026';
    $eventDateRangeText = $eventDateText;

    if ($startDate && $endDate) {
        if ($startDate->isSameDay($endDate)) {
            $eventDateRangeText = $startDate->translatedFormat('l, d F Y');
        } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
            $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y');
        } elseif ($startDate->format('Y') === $endDate->format('Y')) {
            $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y');
        } else {
            $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
        }
    }

    $eventStartShortText = $startDate ? $startDate->translatedFormat('l, d M Y') : 'Tanggal belum diatur';
    $hasDifferentEndDate = !empty($invitation->event_end_date) && $endDate && $startDate && !$startDate->isSameDay($endDate);
    $eventEndShortText = $hasDifferentEndDate ? $endDate->translatedFormat('l, d M Y') : null;

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time && $eventTimeText) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    } elseif ($invitation->event_end_time) {
        $eventTimeText = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Sakura Garden Hall';
    $addressText = $invitation->address ?: 'Jl. Garden Sakura No. 22, Jakarta';
    $descriptionText = $invitation->description ?: 'Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada acara pernikahan kami.';

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;
    if (!$mapEmbedUrl && $mapOpenUrl && \Illuminate\Support\Str::contains($mapOpenUrl, 'google.com/maps')) $mapEmbedUrl = $mapOpenUrl;

    $shareUrl = route('invitation.public', $invitation->slug);
    $shareMessage = "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n"
        . "*" . ($invitation->event_name ?: 'The Wedding Of') . "*\n"
        . "*{$eventTitle}*\n\n"
        . "Tanggal: {$eventDateRangeText}\n";
    if ($eventTimeText) $shareMessage .= "Waktu: {$eventTimeText}\n";
    if ($locationText) $shareMessage .= "Tempat: {$locationText}\n";
    if ($addressText) $shareMessage .= "Alamat: {$addressText}\n";
    if ($mapOpenUrl) $shareMessage .= "Maps: {$mapOpenUrl}\n";
    $shareMessage .= "\nKlik link undangan berikut:\n{$shareUrl}\n\nTerima kasih.";
    $shareText = rawurlencode($shareMessage);

    $musicSrc = asset('assets/music/background1.mp3');
    if ($invitation->music_url) {
        $musicPath = $invitation->music_url;
        if (\Illuminate\Support\Str::startsWith($musicPath, ['http://', 'https://'])) $musicSrc = $musicPath;
        elseif (\Illuminate\Support\Str::startsWith($musicPath, ['/storage/', 'storage/'])) $musicSrc = asset(ltrim($musicPath, '/'));
        else $musicSrc = asset('storage/' . ltrim($musicPath, '/'));
    }

    $targetDateTime = $startDate
        ? $startDate->format('Y-m-d') . 'T' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00')
        : now()->addDays(30)->format('Y-m-d\TH:i:s');

    $googleCalendarUrl = '#';
    if ($startDate) {
        $startDateTime = \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . ($invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00'));
        $endDateTime = $invitation->event_end_time
            ? \Carbon\Carbon::parse($startDate->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s'))
            : $startDateTime->copy()->addHours(3);

        $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            . '&text=' . rawurlencode(($invitation->event_name ?: 'Wedding Event') . ' - ' . $eventTitle)
            . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
            . '&details=' . rawurlencode(trim($descriptionText . "\n\nLink Undangan: " . $shareUrl))
            . '&location=' . rawurlencode(trim($locationText . ' - ' . $addressText))
            . '&ctz=Asia/Jakarta';
    }

    $photos = $invitation->photos ?? collect();
    $galleryPhotos = $photos->take(9);
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();

    $hadir = $messages->where('attendance_status', 'hadir')->sum('guest_count');
    $tidakHadir = $messages->where('attendance_status', 'tidak_hadir')->count();
    $ragu = $messages->where('attendance_status', 'ragu')->count();
@endphp

<body style="
    --ss-paper: {{ $ssTheme['paper'] }};
    --ss-soft: {{ $ssTheme['soft'] }};
    --ss-ink: {{ $ssTheme['ink'] }};
    --ss-blue: {{ $ssTheme['blue'] }};
    --ss-blue-deep: {{ $ssTheme['blue_deep'] }};
    --ss-pink: {{ $ssTheme['pink'] }};
">
    <div class="ss-petal-layer" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="ss-shell">
        <main class="ss-book" id="top">
            <div class="ss-floating-actions" aria-label="Aksi undangan">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan" aria-label="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan">
                </a>
                <button type="button" id="music-toggle" title="Music" aria-label="Music">
                    <img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music">
                </button>
                <button type="button" id="scroll-toggle" title="Auto Scroll" aria-label="Auto Scroll">
                    <img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll">
                </button>
                @if ($mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi" aria-label="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi">
                    </a>
                @endif
            </div>

            <audio id="invitation-music" src="{{ $musicSrc }}" preload="auto" loop></audio>

            <section id="opening" class="ss-page ss-hero">
                <div class="ss-hero-inner" data-reveal="zoom">
                    <p class="ss-hero-kicker responsive-text">{{ strtoupper($invitation->event_name ?: 'The Wedding Of') }}</p>
                    <h1 class="ss-title ss-hero-title responsive-text">
                        <span class="ss-hero-name">{{ $brideName }}</span>
                        <span class="ss-hero-and">&</span>
                        <span class="ss-hero-name">{{ $groomName }}</span>
                    </h1>
                    <p class="ss-hero-date responsive-text">{{ $eventDateShort }}</p>
                    <div class="ss-hero-actions">
                        <a href="#couple" class="ss-btn sakura">Buka Undangan</a>
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ss-btn light">Simpan Tanggal</a>
                    </div>
                </div>
            </section>

            <section id="couple" class="ss-page ss-couple">
                <p class="ss-label" data-reveal="zoom">Bride & Groom</p>
                <h2 class="ss-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.3rem);text-transform:uppercase;">
                    Bride & Groom
                </h2>
                <p class="ss-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    {{ $descriptionText }}
                </p>

                <div class="ss-couple-stack">
                    <article class="ss-person-card" data-reveal="zoom">
                        <div class="ss-person-photo-wrap">
                            @if ($bridePhoto)
                                <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                            @else
                                <div class="ss-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="ss-person-content">
                            <h3 class="ss-title ss-script ss-person-name responsive-text">{{ $brideName }}</h3>
                            <div class="ss-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                            <p class="ss-person-family responsive-text">{{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}</p>
                            @if (!empty($bride->instagram))
                                <a href="{{ $bride->instagram }}" target="_blank" class="ss-btn sakura ss-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>

                    <div class="ss-title ss-script" data-reveal="zoom" style="font-size:clamp(2rem,6vw,4rem);color:#7895a5;">&</div>

                    <article class="ss-person-card" data-reveal="zoom">
                        <div class="ss-person-photo-wrap">
                            @if ($groomPhoto)
                                <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                            @else
                                <div class="ss-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="ss-person-content">
                            <h3 class="ss-title ss-script ss-person-name responsive-text">{{ $groomName }}</h3>
                            <div class="ss-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                            <p class="ss-person-family responsive-text">{{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}</p>
                            @if (!empty($groom->instagram))
                                <a href="{{ $groom->instagram }}" target="_blank" class="ss-btn sakura ss-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>
                </div>
            </section>

            <section id="story" class="ss-page ss-story slim">
                <div class="ss-story-card" data-reveal="zoom">
                    <p class="ss-label">Love Story</p>
                    <h2 class="ss-title ss-script responsive-text">Our Love Story</h2>
                    <p class="ss-note responsive-text">
                        From a simple meeting, it leads to a lifelong promise. This is our love story, and it has only just begun.
                    </p>
                </div>
            </section>

            <section id="countdown" class="ss-page ss-save-date">
                <div class="ss-count-panel" data-reveal="zoom">
                    <p class="ss-label">Save The Date</p>
                    <h2 class="ss-title ss-script ss-count-title responsive-text">Menuju Hari Bahagia</h2>
                    <div class="ss-count-grid" data-countdown="{{ $targetDateTime }}">
                        <div class="ss-count-card"><span class="ss-count-number" data-days>0</span><span class="ss-count-label">Hari</span></div>
                        <div class="ss-count-card"><span class="ss-count-number" data-hours>0</span><span class="ss-count-label">Jam</span></div>
                        <div class="ss-count-card"><span class="ss-count-number" data-minutes>0</span><span class="ss-count-label">Menit</span></div>
                        <div class="ss-count-card"><span class="ss-count-number" data-seconds>0</span><span class="ss-count-label">Detik</span></div>
                    </div>
                    <p class="ss-note ss-count-date responsive-text">{{ $eventDateText }}</p>
                    <div class="ss-count-actions">
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ss-btn">Simpan ke Kalender</a>
                    </div>
                </div>
            </section>

            <section id="acara" class="ss-page ss-event">
                <article class="ss-event-card" data-reveal="zoom">
                    <h2 class="ss-title ss-script responsive-text">Acara Pernikahan</h2>

                    <div class="ss-event-date-list">
                        <div class="ss-event-date-item">
                            <span>Tanggal</span>
                            <strong>{{ $eventStartShortText }}</strong>
                        </div>
                        @if ($hasDifferentEndDate)
                            <div class="ss-event-date-until">Sampai</div>
                            <div class="ss-event-date-item">
                                <strong>{{ $eventEndShortText }}</strong>
                            </div>
                        @endif
                    </div>

                    @if ($eventTimeText)
                        <p class="ss-event-line responsive-text">Pukul {{ $eventTimeText }}</p>
                    @endif
                    <p class="ss-event-place responsive-text">{{ $locationText }}</p>
                    <p class="ss-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="ss-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ss-btn sakura">Google Maps</a>
                        @endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ss-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="ss-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe class="ss-map-frame" src="{{ $mapEmbedUrl }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ss-map-placeholder">
                                <div><div style="font-size:3rem">⌖</div><strong>{{ $locationText }}</strong></div>
                            </a>
                        @endif

                        <div class="ss-map-footer">
                            <div>
                                <p class="ss-map-title responsive-text">{{ $locationText }}</p>
                                <p class="ss-map-address responsive-text">{{ $addressText }}</p>
                            </div>
                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="ss-btn sakura">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            @if ($gifts->count())
                <section id="gift" class="ss-page ss-gift slim">
                    <p class="ss-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="ss-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.2rem);text-transform:uppercase;">Wedding Gift</h2>
                    <p class="ss-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>
                    <div class="ss-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $gift)
                            <div class="ss-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                                <div class="ss-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                                <div class="ss-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                                <p class="responsive-text" style="margin:12px 0 0;color:rgba(52,74,84,.72);">{{ $gift->account_name ?? $eventTitle }}</p>
                                <button type="button" class="ss-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">Salin Nomor</button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($galleryPhotos->count())
                <section id="galeri" class="ss-page ss-gallery">
                    <p class="ss-label" data-reveal="zoom">Sharing Memories</p>
                    <h2 class="ss-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.2rem);text-transform:uppercase;">Sharing Memories</h2>
                    <p class="ss-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Terima kasih sudah membagikan momen terbaik bersama kami.
                    </p>
                    <div class="ss-gallery-grid">
                        @foreach ($galleryPhotos as $photo)
                            @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp
                            @if ($src)
                                <a href="{{ $src }}" target="_blank" class="ss-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s">
                                    <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="ss-page ss-rsvp slim">
                <p class="ss-label" data-reveal="zoom">RSVP</p>
                <h2 class="ss-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">RSVP Form</h2>
                <div class="ss-rsvp-layout">
                    <div class="ss-rsvp-copy" data-reveal="left">
                        <h3 class="ss-title ss-script responsive-text">Kehadiran Anda</h3>
                        <p class="ss-note responsive-text" style="margin-left:0;">
                            Kami tidak sabar menunggu hari pernikahan kami bersama Anda. Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="ss-form-card space-y-4" data-reveal="right">
                        @csrf
                        <div>
                            <label class="ss-form-label">Nama</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="ss-input" placeholder="Nama lengkap" required>
                        </div>
                        <div>
                            <label class="ss-form-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="ss-input">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>
                        <div>
                            <label class="ss-form-label">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="ss-input">
                        </div>
                        <div>
                            <label class="ss-form-label">Pesan</label>
                            <textarea name="message" rows="4" class="ss-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="ss-btn" style="width:100%;">Kirim</button>
                    </form>

                    <div class="ss-summary-grid" data-reveal="zoom">
                        <div><b>{{ $tidakHadir }}</b><span>Tidak Hadir</span></div>
                        <div><b>{{ $hadir }}</b><span>Hadir</span></div>
                        <div><b>{{ $ragu }}</b><span>Ragu</span></div>
                    </div>

                    <div class="ss-message-list">
                        @forelse ($messages->take(5) as $message)
                            <div class="ss-message-card" data-reveal="zoom">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color:var(--ss-blue-deep);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color:rgba(52,74,84,.58)">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    @if ($message->attendance_status)
                                        <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(120,149,165,.13);color:var(--ss-blue-deep);">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>
                                <p class="responsive-text mt-3" style="color:rgba(52,74,84,.78);line-height:1.8;">{{ $message->message }}</p>
                            </div>
                        @empty
                            <div class="ss-message-card text-center" style="color:rgba(52,74,84,.66);">Belum ada ucapan.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="ss-page ss-closing">
                <div class="ss-closing-card" data-reveal="zoom">
                    <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="ss-closing-photo">
                    <h2 class="ss-title responsive-text" style="font-size:clamp(2rem,5vw,3.2rem);">Terima Kasih</h2>
                    <p class="ss-note responsive-text">
                        Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.
                    </p>
                    <h3 class="ss-title ss-script responsive-text" style="margin-top:22px;font-size:clamp(2.5rem,6vw,4.8rem);letter-spacing:.01em;">
                        {{ $eventTitle }}
                    </h3>
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
            const scrollSpeedPerSecond = 68;

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
                        setTimeout(function () {
                            button.classList.remove('copied');
                            button.textContent = old;
                        }, 1300);
                    } catch (error) {}
                });
            });

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) entry.target.classList.add('is-visible');
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('[data-reveal]').forEach(function (el) {
                observer.observe(el);
            });
        });
    </script>

    <script>
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
            if (!['input', 'textarea', 'select', 'option'].includes(tag)) event.preventDefault();
        });
    </script>
</body>
</html>
