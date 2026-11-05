<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Emerald Wedding'));
    @endphp
    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--ew-ink);
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--ew-green) 16%, transparent), transparent 30%),
                radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--ew-sage) 18%, transparent), transparent 28%),
                linear-gradient(180deg, var(--ew-paper) 0%, var(--ew-soft) 48%, var(--ew-paper) 100%);
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

        .ew-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .ew-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid rgba(51, 91, 68, .18);
            background:
                linear-gradient(180deg, rgba(255,255,255,.70), rgba(244,250,241,.78)),
                url("{{ asset('assets/emerald-wedding/ew-paper-texture.png') }}") center / cover repeat,
                var(--ew-paper);
            box-shadow: 0 42px 130px rgba(29, 57, 40, .16);
        }

        .ew-book::before,
        .ew-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .ew-book::before {
            opacity: .30;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-corner-left.png') }}") left top / 260px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-corner-right.png') }}") right top / 260px auto no-repeat,
                linear-gradient(90deg, rgba(51, 91, 68, .035) 1px, transparent 1px) 0 0 / 42px 42px,
                linear-gradient(0deg, rgba(51, 91, 68, .028) 1px, transparent 1px) 0 0 / 42px 42px;
        }

        .ew-book::after {
            opacity: .34;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.80), transparent 36%),
                radial-gradient(circle at 50% 72%, color-mix(in srgb, var(--ew-sage) 14%, transparent), transparent 40%);
        }

        .ew-book > * { position: relative; z-index: 2; }

        .ew-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(51, 91, 68, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(29, 57, 40, .13);
            backdrop-filter: blur(14px);
        }

        .ew-floating-actions a,
        .ew-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(29, 57, 40, .11);
            transition: transform .25s ease, background .25s ease;
        }

        .ew-floating-actions a:hover,
        .ew-floating-actions button:hover { transform: translateX(-3px); }
        .ew-floating-actions button.is-active { background: color-mix(in srgb, var(--ew-sage) 38%, white); }
        .ew-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .ew-page {
            position: relative;
            min-height: auto;
            padding: 104px 74px;
            overflow: hidden;
            text-align: center;
        }

        .ew-page > * { position: relative; z-index: 5; }
        .ew-page.slim { padding-top: 86px; padding-bottom: 86px; }

        .ew-page::before,
        .ew-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .ew-page::before {
            z-index: 1;
            opacity: .34;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-top-frame.png') }}") center top / min(820px, 96%) auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 108% auto no-repeat;
        }

        .ew-page::after {
            z-index: 2;
            opacity: .20;
            background:
                linear-gradient(180deg, rgba(255,255,255,.24), transparent 42%, rgba(255,255,255,.18)),
                radial-gradient(circle at 50% 32%, rgba(255,255,255,.38), transparent 46%);
        }

        .ew-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--ew-green);
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(51, 91, 68, .15);
            box-shadow: 0 12px 28px rgba(29, 57, 40, .07);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .ew-label::before,
        .ew-label::after {
            content: "";
            width: 26px;
            height: 1px;
            background: var(--ew-green);
            opacity: .42;
        }

        .ew-title {
            margin: 0;
            color: var(--ew-green);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .01em;
            line-height: .96;
            text-wrap: balance;
        }

        .ew-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .ew-note {
            width: min(100%, 700px);
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--ew-ink) 78%, transparent);
            line-height: 1.9;
        }

        .ew-btn {
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
            color: #fffaf0;
            background: linear-gradient(135deg, var(--ew-green), var(--ew-deep));
            box-shadow: 0 16px 36px rgba(29, 57, 40, .22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .ew-btn:hover { transform: translateY(-2px); }
        .ew-btn.sage { color: #20362a; background: linear-gradient(135deg, #e9f3df, var(--ew-sage), #78956e); }
        .ew-btn.light {
            color: var(--ew-green);
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(51, 91, 68, .15);
        }

        .ew-btn::after,
        .ew-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: ewShine 4.4s ease-in-out infinite;
        }

        /* HERO */
        .ew-hero {
            min-height: 940px;
            display: grid;
            place-items: center;
            padding: 72px 72px 0;
            background:
                linear-gradient(180deg, rgba(253,255,247,.90), rgba(248,252,241,.58) 44%, rgba(231,242,225,.82)),
                url("{{ asset('assets/emerald-wedding/ew-line-paper-bg.png') }}") center top / cover no-repeat,
                var(--ew-paper);
        }

        .ew-hero::before {
            opacity: .98;
            background:
                url("{{ asset('assets/emerald-wedding/ew-tree-shadow-right.png') }}") right 9% / 46% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-side-left.png') }}") left bottom 8% / 220px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-side-right.png') }}") right bottom 8% / 220px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-gazebo-watercolor.png') }}") center bottom / 100% auto no-repeat;
        }

        .ew-hero::after {
            opacity: .58;
            background:
                linear-gradient(180deg, rgba(255,255,255,.28), rgba(255,255,255,.12) 42%, rgba(255,255,255,.20)),
                radial-gradient(circle at 50% 33%, rgba(255,255,255,.66), transparent 42%);
        }

        .ew-hero-inner {
            width: min(100%, 620px);
            margin: 0 auto;
            padding: 160px 0 340px;
        }

        .ew-hero-kicker {
            margin: 0;
            color: var(--ew-ink);
            font-size: clamp(1.15rem, 2.1vw, 1.85rem);
            font-family: Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 500;
            letter-spacing: -.02em;
        }

        .ew-hero-title {
            width: min(100%, 720px);
            margin: 20px auto 0;
            color: var(--ew-green);
            font-size: clamp(2.7rem, 6vw, 5.2rem);
            line-height: .96;
            text-align: center;
            white-space: normal;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .ew-hero-name { display: block; line-height: .96; }
        .ew-hero-and {
            display: block;
            margin: 6px 0 8px;
            color: var(--ew-green);
            font-size: clamp(1.35rem, 2.6vw, 2rem);
            font-style: italic;
            line-height: 1;
            text-transform: none;
            letter-spacing: 0;
        }

        .ew-hero-hashtag {
            margin-top: 22px;
            color: var(--ew-ink);
            font-size: .95rem;
            font-weight: 850;
            letter-spacing: .03em;
        }

        .ew-hero-date {
            margin-top: 18px;
            color: var(--ew-ink);
            font-size: .98rem;
            font-weight: 850;
            letter-spacing: .22em;
        }

        .ew-scroll-mark {
            width: 44px;
            height: 72px;
            margin: 28px auto 0;
            border-radius: 999px;
            border: 2px solid rgba(42, 70, 51, .45);
            display: grid;
            place-items: center;
            color: var(--ew-green);
            font-weight: 950;
            animation: ewFloat 2.6s ease-in-out infinite;
        }

        .ew-hero-actions {
            margin-top: 22px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        /* INTRO */
        .ew-intro {
            background:
                linear-gradient(180deg, rgba(255,255,255,.72), rgba(246,252,243,.74)),
                url("{{ asset('assets/emerald-wedding/ew-garden-haze.png') }}") center / cover no-repeat,
                var(--ew-paper);
        }

        .ew-intro::before {
            opacity: .70;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-top-frame.png') }}") center top / 96% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-gazebo-watercolor.png') }}") center 25% / 100% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-lily-left.png') }}") left 62% / 260px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-lily-right.png') }}") right 62% / 260px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 108% auto no-repeat;
        }

        .ew-intro-card {
            width: min(100%, 900px);
            margin: 0 auto;
            padding: 86px 48px 96px;
            border-radius: 38px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), rgba(255,255,255,.52)),
                url("{{ asset('assets/emerald-wedding/ew-paper-texture.png') }}") center / cover repeat;
            border: 1px solid rgba(51, 91, 68, .13);
            box-shadow: 0 28px 84px rgba(29, 57, 40, .12);
            backdrop-filter: blur(6px);
        }

        .ew-bouquet {
            width: min(180px, 42%);
            margin: 0 auto 40px;
            display: block;
        }

        .ew-intro-title {
            font-size: clamp(2rem, 4.6vw, 4rem);
            color: #26382d;
            line-height: 1.05;
        }

        .ew-couple-stack {
            width: min(100%, 760px);
            margin: 46px auto 0;
            display: grid;
            gap: 56px;
        }

        .ew-person-card {
            position: relative;
            display: grid;
            justify-items: center;
            text-align: center;
        }

        .ew-person-photo {
            width: min(100%, 320px);
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            padding: 10px;
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(51, 91, 68, .16);
            box-shadow: 0 24px 58px rgba(29, 57, 40, .13);
            overflow: hidden;
        }

        .ew-person-photo img,
        .ew-person-initial {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 50%;
            color: var(--ew-green);
            background: color-mix(in srgb, var(--ew-sage) 20%, white);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .ew-person-name {
            margin-top: 28px;
            color: var(--ew-green);
            font-size: clamp(2.5rem, 5.5vw, 4.8rem);
            line-height: .95;
            text-transform: capitalize;
        }

        .ew-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 14px auto 0;
            padding: 7px 18px;
            border-radius: 999px;
            color: var(--ew-green);
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(51, 91, 68, .14);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .ew-person-family {
            width: min(100%, 440px);
            margin: 16px auto 0;
            color: rgba(42, 61, 49, .78);
            line-height: 1.75;
            font-weight: 650;
        }

        .ew-instagram-btn {
            margin-top: 18px;
            min-height: 38px;
            padding: 10px 22px;
            font-size: .78rem;
        }

        /* COUNTDOWN */
        .ew-save-date {
            min-height: 840px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.82), rgba(246,252,243,.76)),
                url("{{ asset('assets/emerald-wedding/ew-garden-haze.png') }}") center / cover no-repeat,
                var(--ew-paper);
        }

        .ew-save-date::before {
            opacity: .72;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-top-frame.png') }}") center top / 94% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-gazebo-watercolor.png') }}") center 46% / 104% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 108% auto no-repeat;
        }

        .ew-count-panel {
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 54px 28px 92px;
            text-align: center;
        }

        .ew-count-title { font-size: clamp(2.4rem, 5.5vw, 5rem); color: var(--ew-green); }

        .ew-count-grid {
            width: min(100%, 450px);
            margin: 38px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .ew-count-card {
            padding: 22px 12px;
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(245,252,240,.78));
            border: 1px solid rgba(51, 91, 68, .13);
            box-shadow: 0 14px 34px rgba(29, 57, 40, .08);
        }

        .ew-count-number {
            display: block;
            color: var(--ew-green);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.1rem, 5vw, 3.6rem);
            line-height: 1;
            font-weight: 800;
        }

        .ew-count-label {
            display: block;
            margin-top: 7px;
            color: var(--ew-ink);
            font-size: .72rem;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .ew-count-actions { margin-top: 34px; }

        /* EVENT */
        .ew-event {
            position: relative;
            overflow: hidden;
            padding: 80px 0 90px;
            background:
                linear-gradient(
                    180deg,
                    rgba(151,176,138,.92),
                    rgba(142,168,131,.94)
                ),
                url("{{ asset('assets/emerald-wedding/ew-line-paper-bg.png') }}") center top / 560px auto repeat,
                var(--ew-sage);
        }

        .ew-event::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .18;
            background:
                radial-gradient(circle at 20% 12%, rgba(255,255,255,.14), transparent 28%),
                radial-gradient(circle at 84% 30%, rgba(255,255,255,.10), transparent 24%),
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 170% auto no-repeat;
        }

        .ew-event::after {
            display: none;
        }

        .ew-event > * {
            position: relative;
            z-index: 3;
        }

        .ew-event-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 620px);
            min-height: 760px;
            margin: 0 auto;
            padding: 150px 42px 105px;
            display: grid;
            align-content: center;
            justify-items: center;
            text-align: center;
        }

        .ew-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                url("{{ asset('assets/emerald-wedding/ew-oval-event-frame.png') }}") center center / contain no-repeat;
        }

        .ew-event-card::after {
            content: none;
        }

        .ew-event-card > * {
            position: relative;
            z-index: 2;
        }

        .ew-event-card h2 {
            color: #26382d;
            width: min(100%, 360px);
            margin: 0 auto;
            font-size: clamp(2rem, 4.2vw, 3.6rem);
            line-height: 1.08;
            letter-spacing: .015em;
            text-align: center;
            text-wrap: balance;
        }

        .ew-event-date-list {
            width: min(100%, 430px);
            margin: 32px auto 0;
            display: grid;
            gap: 14px;
        }

        .ew-event-date-item { display: grid; gap: 8px; }

        .ew-event-date-item span {
            color: var(--ew-green);
            font-size: .74rem;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .ew-event-date-item strong {
            color: #1f2f26;
            font-size: clamp(1rem, 2vw, 1.2rem);
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
            line-height: 1.6;
        }

        .ew-event-date-until {
            width: fit-content;
            margin: 0 auto;
            padding: 6px 16px;
            border-radius: 999px;
            color: #fff;
            background: var(--ew-green);
            font-size: .78rem;
            font-weight: 850;
        }

        .ew-event-line {
            margin: 24px auto 0;
            color: #1f2f26;
            font-weight: 850;
            line-height: 1.8;
        }

        .ew-event-place {
            margin: 32px auto 0;
            color: #1f2f26;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ew-event-address {
            width: min(100%, 500px);
            margin: 10px auto 0;
            color: rgba(31, 47, 38, .78);
            line-height: 1.75;
        }

        .ew-event-actions {
            margin-top: 28px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ew-map-card,
        .ew-gift-card,
        .ew-rsvp-copy,
        .ew-form-card,
        .ew-message-card,
        .ew-closing-card {
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(51, 91, 68, .13);
            box-shadow: 0 18px 48px rgba(29, 57, 40, .10);
        }

        .ew-map-card {
            width: min(100%, 830px);
            margin: 34px auto 0;
            overflow: hidden;
            border-radius: 30px;
        }

        .ew-map-frame,
        .ew-map-placeholder {
            width: 100%;
            height: 360px;
            min-height: 360px;
            border: 0;
            display: block;
        }

        .ew-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ew-green);
            text-decoration: none;
            padding: 28px;
            background: rgba(255,255,255,.58);
        }

        .ew-map-footer {
            padding: 20px 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            background: rgba(255,255,255,.86);
            border-top: 1px solid rgba(51, 91, 68, .12);
        }

        .ew-map-title {
            margin: 0;
            color: var(--ew-green);
            font-weight: 950;
        }

        .ew-map-address {
            margin: 6px 0 0;
            color: rgba(42, 61, 49, .72);
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* GIFT & GALLERY */
        .ew-gift, .ew-gallery, .ew-rsvp, .ew-closing {
            background:
                linear-gradient(180deg, rgba(255,255,255,.86), rgba(246,252,243,.78)),
                url("{{ asset('assets/emerald-wedding/ew-garden-haze.png') }}") center / cover no-repeat,
                var(--ew-paper);
        }

        .ew-gift-grid {
            width: min(100%, 850px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .ew-gift-grid.is-single {
            grid-template-columns: minmax(0, 440px);
            justify-content: center;
        }

        .ew-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 220px;
            padding: 38px 30px;
            border-radius: 28px;
            text-align: center;
        }

        .ew-gift-title {
            color: var(--ew-green);
            font-family: Georgia, serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ew-gift-number {
            margin-top: 18px;
            color: var(--ew-deep);
            font-size: clamp(1.45rem, 4vw, 2.2rem);
            font-weight: 950;
        }

        .ew-copy-btn {
            position: relative;
            overflow: hidden;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            padding: 12px 18px;
            color: #fff8e7;
            background: var(--ew-green);
            font-weight: 950;
            cursor: pointer;
        }

        .ew-copy-btn.copied { background: #16803c; color: #fff; }

        .ew-gallery-grid {
            width: min(100%, 860px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-rows: 110px;
            grid-auto-flow: dense;
            gap: 14px;
        }

        .ew-gallery-item {
            display: block;
            overflow: hidden;
            border-radius: 999px 999px 24px 24px;
            background: var(--ew-deep);
            border: 7px solid rgba(255,255,255,.88);
            box-shadow: 0 16px 38px rgba(29, 57, 40, .13);
        }

        .ew-gallery-item:nth-child(1) { grid-column: span 12; grid-row: span 3; }
        .ew-gallery-item:nth-child(n + 2) { grid-column: span 3; grid-row: span 2; }

        .ew-gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .7s ease;
        }

        .ew-gallery-item:hover img { transform: scale(1.055); }

        /* RSVP */
        .ew-rsvp::before {
            opacity: .42;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-corner-left.png') }}") left top / 190px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-corner-right.png') }}") right top / 190px auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 108% auto no-repeat;
        }

        .ew-rsvp-layout {
            width: min(100%, 960px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(260px, .86fr) minmax(390px, 1.14fr);
            gap: 32px;
            align-items: start;
            text-align: left;
        }

        .ew-rsvp-copy {
            position: relative;
            overflow: hidden;
            padding: 34px 24px 30px;
            border-radius: 28px;
            backdrop-filter: blur(8px);
        }

        .ew-rsvp-copy h3 {
            font-size: clamp(1.8rem, 4vw, 3.2rem);
            line-height: 1.05;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .ew-form-card {
            padding: 28px;
            border-radius: 28px;
            color: var(--ew-ink);
        }

        .ew-form-label {
            display: block;
            color: var(--ew-green);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .ew-input {
            width: 100%;
            margin-top: 8px;
            border: 1px solid rgba(51, 91, 68, .18);
            background: rgba(255,255,255,.98);
            color: var(--ew-ink);
            border-radius: 12px;
            padding: 13px 14px;
            outline: none;
        }

        .ew-summary-grid {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .ew-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 22px;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(51, 91, 68, .12);
            box-shadow: 0 10px 28px rgba(29, 57, 40, .08);
        }

        .ew-summary-grid b {
            display: block;
            color: var(--ew-green);
            font-size: 2rem;
            line-height: 1;
        }

        .ew-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 10px;
        }

        .ew-message-card {
            padding: 18px;
            border-radius: 22px;
        }

        /* CLOSING */
        .ew-closing {
            min-height: 820px;
            display: grid;
            place-items: center;
        }

        .ew-closing::before {
            opacity: .64;
            background:
                url("{{ asset('assets/emerald-wedding/ew-leaf-top-frame.png') }}") center top / 92% auto no-repeat,
                url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 108% auto no-repeat;
        }

        .ew-closing-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 60px 36px 120px;
            border-radius: 34px;
            backdrop-filter: blur(10px);
        }

        .ew-closing-photo {
            width: min(100%, 240px);
            aspect-ratio: 1 / 1;
            margin: 0 auto 28px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
            border: 8px solid rgba(255,255,255,.94);
            box-shadow: 0 20px 54px rgba(29, 57, 40, .18);
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(32px);
            filter: blur(7px);
            transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1);
            transition-delay: var(--reveal-delay, 0s);
        }

        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0, 0) scale(1); filter: blur(0); }

        @keyframes ewShine { 0%, 48% { left: -88%; } 76%, 100% { left: 135%; } }
        @keyframes ewFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

        @media (max-width: 980px) {
            .ew-shell { padding: 14px; }
            .ew-page { padding: 92px 36px; }
            .ew-hero { min-height: 860px; padding: 66px 36px 0; }
            .ew-hero-inner { padding-top: 130px; padding-bottom: 300px; }
            .ew-hero::before {
                background:
                    url("{{ asset('assets/emerald-wedding/ew-tree-shadow-right.png') }}") right 7% / 58% auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-leaf-side-left.png') }}") left 8% / 160px auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-leaf-side-right.png') }}") right 8% / 160px auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-gazebo-watercolor.png') }}") center bottom / 132% auto no-repeat;
            }
            .ew-rsvp-layout { grid-template-columns: 1fr; }
            .ew-gift-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .ew-shell { padding: 0; }
            .ew-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .ew-page, .ew-page.slim { padding: 76px 22px; }
            .ew-floating-actions a, .ew-floating-actions button { width: 40px; height: 40px; }

            .ew-hero { min-height: 100svh; padding: 54px 22px 0; }
            .ew-hero::before {
                background:
                    url("{{ asset('assets/emerald-wedding/ew-tree-shadow-right.png') }}") right 8% / 86% auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-leaf-side-left.png') }}") left 8% / 110px auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-leaf-side-right.png') }}") right 8% / 110px auto no-repeat,
                    url("{{ asset('assets/emerald-wedding/ew-gazebo-watercolor.png') }}") center bottom / 185% auto no-repeat;
            }
            .ew-hero-inner { padding-top: 112px; padding-bottom: 265px; }
            .ew-hero-kicker { font-size: clamp(1rem, 5vw, 1.35rem); }
            .ew-hero-title { width: min(100%, 420px); font-size: clamp(2.25rem, 10vw, 3.7rem); line-height: 1; letter-spacing: .06em; }
            .ew-hero-name { line-height: 1; }
            .ew-hero-and { margin: 2px 0 4px; font-size: clamp(1.05rem, 5vw, 1.45rem); line-height: 1; }

            .ew-intro-card { padding: 58px 20px 70px; border-radius: 30px; }
            .ew-bouquet { width: min(150px, 48%); }
            .ew-person-photo { width: min(100%, 250px); }

            .ew-count-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
            .ew-count-card { border-radius: 22px; padding: 18px 10px; }

            .ew-event {
                padding: 64px 0 76px;
                background:
                    linear-gradient(
                        180deg,
                        rgba(151,176,138,.92),
                        rgba(142,168,131,.94)
                    ),
                    url("{{ asset('assets/emerald-wedding/ew-line-paper-bg.png') }}") center top / 420px auto repeat,
                    var(--ew-sage);
            }

            .ew-event::before {
                inset: 0;
                opacity: .16;
                background:
                    radial-gradient(circle at 20% 12%, rgba(255,255,255,.14), transparent 28%),
                    radial-gradient(circle at 84% 30%, rgba(255,255,255,.10), transparent 24%),
                    url("{{ asset('assets/emerald-wedding/ew-leaf-bottom-frame.png') }}") center bottom / 190% auto no-repeat;
            }

            .ew-event::after {
                display: none;
            }

            .ew-event-card {
                width: min(100% - 24px, 360px);
                min-height: 620px;
                margin: 0 auto;
                padding: 150px 24px 76px;
            }

            .ew-event-card > * {
                transform: translateY(18px);
            }

            .ew-event-card::after {
                content: none;
            }

            .ew-event-card::before {
                background-size: contain;
                background-position: center center;
            }

            .ew-event-card h2 {
                width: min(100%, 270px);
                margin: 0 auto 8px;
                font-size: clamp(1.85rem, 7.6vw, 2.35rem);
                line-height: 1.08;
                letter-spacing: .01em;
                text-align: center;
            }

            .ew-event-date-list {
                margin-top: 22px;
                gap: 10px;
            }

            .ew-event-line {
                margin-top: 18px;
            }

            .ew-event-place {
                margin-top: 20px;
                font-size: .9rem;
            }

            .ew-event-address {
                width: min(100%, 280px);
                font-size: .86rem;
                line-height: 1.65;
            }

            .ew-event-actions {
                margin-top: 22px;
            }

            .ew-event-actions, .ew-hero-actions { flex-direction: column; align-items: center; }
            .ew-event-actions .ew-btn, .ew-hero-actions .ew-btn { width: min(100%, 280px); }

            .ew-map-frame, .ew-map-placeholder { height: 310px; min-height: 310px; }
            .ew-map-footer { flex-direction: column; align-items: stretch; }

            .ew-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-auto-rows: 132px; }
            .ew-gallery-item:nth-child(1), .ew-gallery-item:nth-child(n + 2) { grid-column: span 1; grid-row: span 1; }
            .ew-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }

            .ew-summary-grid { grid-template-columns: 1fr; }
            .ew-rsvp-copy { padding: 28px 18px 24px; }
            .ew-rsvp-copy h3 { font-size: clamp(1.65rem, 8vw, 2.5rem); line-height: 1.02; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }
    </style>
</head>

@php
    $ewThemeKey = $invitation->theme_color ?: 'emerald';
    $ewThemes = [
        'maroon' => ['paper' => '#fbf1ee', 'soft' => '#f1ded9', 'ink' => '#4d2930', 'green' => '#663443', 'deep' => '#35121d', 'sage' => '#d7b96b'],
        'emerald' => ['paper' => '#f4f8ed', 'soft' => '#ddebd7', 'ink' => '#2a3d31', 'green' => '#2f6b45', 'deep' => '#123423', 'sage' => '#8fae82'],
        'navy' => ['paper' => '#eef2f8', 'soft' => '#dfe6f1', 'ink' => '#1a304a', 'green' => '#17375d', 'deep' => '#07172b', 'sage' => '#d7bd72'],
        'rose' => ['paper' => '#fff0ef', 'soft' => '#f5dddd', 'ink' => '#5a253c', 'green' => '#74324b', 'deep' => '#35101e', 'sage' => '#d7b96b'],
        'gold' => ['paper' => '#fbf3df', 'soft' => '#efe0bd', 'ink' => '#4f3b1a', 'green' => '#725126', 'deep' => '#2c1c08', 'sage' => '#d8b65c'],
        'slate' => ['paper' => '#f0f2f4', 'soft' => '#dde0e4', 'ink' => '#292f37', 'green' => '#3f454d', 'deep' => '#11151a', 'sage' => '#d2b875'],
    ];
    $ewTheme = $ewThemes[$ewThemeKey] ?? $ewThemes['emerald'];

    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'Anita & Olga');
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Anita');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Olga');

    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/emerald-wedding/ew-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;

    $eventDateShort = $startDate ? $startDate->format('d . m . Y') : '31 . 12 . 2026';
    $eventDateText = $startDate ? $startDate->translatedFormat('l, d F Y') : 'Kamis, 31 Desember 2026';
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

    $locationText = $invitation->location_name ?: 'Auditorium Masjid';
    $addressText = $invitation->address ?: 'Jalan Raya Bojong Sari No. 5, Gunung Putri, Citeureup, Bogor, Jawa Barat';
    $descriptionText = $invitation->description ?: 'Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Ya Allah semoga ridho-Mu tercurah mengiringi pernikahan kami.';

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
    --ew-paper: {{ $ewTheme['paper'] }};
    --ew-soft: {{ $ewTheme['soft'] }};
    --ew-ink: {{ $ewTheme['ink'] }};
    --ew-green: {{ $ewTheme['green'] }};
    --ew-deep: {{ $ewTheme['deep'] }};
    --ew-sage: {{ $ewTheme['sage'] }};
">
    <div class="ew-shell">
        <main class="ew-book" id="top">
            <div class="ew-floating-actions" aria-label="Aksi undangan">
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

            <section id="opening" class="ew-page ew-hero">
                <div class="ew-hero-inner" data-reveal="zoom">
                    <p class="ew-hero-kicker responsive-text">{{ $invitation->event_name ?: 'The Wedding of' }}</p>
                    <h1 class="ew-title ew-hero-title responsive-text">
                        <span class="ew-hero-name">{{ $brideName }}</span>
                        <span class="ew-hero-and">&</span>
                        <span class="ew-hero-name">{{ $groomName }}</span>
                    </h1>
                    <p class="ew-hero-date responsive-text">{{ $eventDateShort }}</p>
                    <div class="ew-hero-actions">
                        <a href="#intro" class="ew-btn sage">Buka Undangan</a>
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ew-btn light">Simpan Tanggal</a>
                    </div>
                </div>
            </section>

            <section id="intro" class="ew-page ew-intro">
                <div class="ew-intro-card" data-reveal="zoom">
                    <img src="{{ asset('assets/emerald-wedding/ew-bouquet-white.png') }}" alt="Bouquet" class="ew-bouquet">
                    <h2 class="ew-title ew-script ew-intro-title responsive-text">We Are<br>Getting Married!</h2>
                    <p class="ew-note responsive-text">{{ $descriptionText }}</p>

                    <div class="ew-couple-stack">
                        <article class="ew-person-card" data-reveal="zoom">
                            <div class="ew-person-photo">
                                @if ($bridePhoto)
                                    <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                                @else
                                    <div class="ew-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                                @endif
                            </div>
                            <h3 class="ew-title ew-script ew-person-name responsive-text">{{ $brideName }}</h3>
                            <div class="ew-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                            <p class="ew-person-family responsive-text">{{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}</p>
                            @if (!empty($bride->instagram))
                                <a href="{{ $bride->instagram }}" target="_blank" class="ew-btn sage ew-instagram-btn">Instagram</a>
                            @endif
                        </article>

                        <article class="ew-person-card" data-reveal="zoom">
                            <div class="ew-person-photo">
                                @if ($groomPhoto)
                                    <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                                @else
                                    <div class="ew-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                                @endif
                            </div>
                            <h3 class="ew-title ew-script ew-person-name responsive-text">{{ $groomName }}</h3>
                            <div class="ew-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                            <p class="ew-person-family responsive-text">{{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}</p>
                            @if (!empty($groom->instagram))
                                <a href="{{ $groom->instagram }}" target="_blank" class="ew-btn sage ew-instagram-btn">Instagram</a>
                            @endif
                        </article>
                    </div>
                </div>
            </section>

            <section id="countdown" class="ew-page ew-save-date">
                <div class="ew-count-panel" data-reveal="zoom">
                    <p class="ew-label">Save The Date</p>
                    <h2 class="ew-title ew-script ew-count-title responsive-text">Menuju Hari Bahagia</h2>
                    <div class="ew-count-grid" data-countdown="{{ $targetDateTime }}">
                        <div class="ew-count-card"><span class="ew-count-number" data-days>0</span><span class="ew-count-label">Hari</span></div>
                        <div class="ew-count-card"><span class="ew-count-number" data-hours>0</span><span class="ew-count-label">Jam</span></div>
                        <div class="ew-count-card"><span class="ew-count-number" data-minutes>0</span><span class="ew-count-label">Menit</span></div>
                        <div class="ew-count-card"><span class="ew-count-number" data-seconds>0</span><span class="ew-count-label">Detik</span></div>
                    </div>
                    <p class="ew-note responsive-text" style="margin-top:32px;">{{ $eventDateText }}</p>
                    <div class="ew-count-actions">
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ew-btn">Simpan ke Kalender</a>
                    </div>
                </div>
            </section>

            <section id="acara" class="ew-page ew-event">
                <article class="ew-event-card" data-reveal="zoom">
                    <h2 class="ew-title ew-script responsive-text">Acara Pernikahan</h2>

                    <div class="ew-event-date-list">
                        <div class="ew-event-date-item">
                            <span>Tanggal</span>
                            <strong>{{ $eventStartShortText }}</strong>
                        </div>
                        @if ($hasDifferentEndDate)
                            <div class="ew-event-date-until">Sampai</div>
                            <div class="ew-event-date-item">
                                <strong>{{ $eventEndShortText }}</strong>
                            </div>
                        @endif
                    </div>

                    @if ($eventTimeText)
                        <p class="ew-event-line responsive-text">Pukul {{ $eventTimeText }}</p>
                    @endif
                    <p class="ew-event-place responsive-text">{{ $locationText }}</p>
                    <p class="ew-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="ew-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ew-btn sage">Google Maps</a>
                        @endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="ew-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="ew-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe class="ew-map-frame" src="{{ $mapEmbedUrl }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="ew-map-placeholder">
                                <div><div style="font-size:3rem">⌖</div><strong>{{ $locationText }}</strong></div>
                            </a>
                        @endif

                        <div class="ew-map-footer">
                            <div>
                                <p class="ew-map-title responsive-text">{{ $locationText }}</p>
                                <p class="ew-map-address responsive-text">{{ $addressText }}</p>
                            </div>
                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="ew-btn sage">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            @if ($gifts->count())
                <section id="gift" class="ew-page ew-gift slim">
                    <p class="ew-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="ew-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.2rem);text-transform:uppercase;">Wedding Gift</h2>
                    <p class="ew-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>

                    <div class="ew-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $gift)
                            <div class="ew-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                                <div class="ew-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                                <div class="ew-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                                <p class="responsive-text" style="margin:12px 0 0;color:rgba(42,61,49,.72);">{{ $gift->account_name ?? $eventTitle }}</p>
                                <button type="button" class="ew-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">Salin Nomor</button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($galleryPhotos->count())
                <section id="galeri" class="ew-page ew-gallery">
                    <p class="ew-label" data-reveal="zoom">Gallery</p>
                    <h2 class="ew-title ew-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,5rem);">Our Gallery</h2>
                    <div class="ew-gallery-grid">
                        @foreach ($galleryPhotos as $photo)
                            @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp
                            @if ($src)
                                <a href="{{ $src }}" target="_blank" class="ew-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s">
                                    <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="ew-page ew-rsvp slim">
                <p class="ew-label" data-reveal="zoom">RSVP</p>
                <h2 class="ew-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">RSVP Form</h2>

                <div class="ew-rsvp-layout">
                    <div class="ew-rsvp-copy" data-reveal="left">
                        <h3 class="ew-title ew-script responsive-text">Kehadiran Anda</h3>
                        <p class="ew-note responsive-text" style="margin-left:0;">
                            Kami tidak sabar menunggu hari pernikahan kami bersama Anda. Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="ew-form-card space-y-4" data-reveal="right">
                        @csrf
                        <div>
                            <label class="ew-form-label">Nama</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="ew-input" placeholder="Nama lengkap" required>
                        </div>
                        <div>
                            <label class="ew-form-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="ew-input">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>
                        <div>
                            <label class="ew-form-label">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="ew-input">
                        </div>
                        <div>
                            <label class="ew-form-label">Pesan</label>
                            <textarea name="message" rows="4" class="ew-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="ew-btn" style="width:100%;">Kirim</button>
                    </form>

                    <div class="ew-summary-grid" data-reveal="zoom">
                        <div><b>{{ $tidakHadir }}</b><span>Tidak Hadir</span></div>
                        <div><b>{{ $hadir }}</b><span>Hadir</span></div>
                        <div><b>{{ $ragu }}</b><span>Ragu</span></div>
                    </div>

                    <div class="ew-message-list">
                        @forelse ($messages->take(5) as $message)
                            <div class="ew-message-card" data-reveal="zoom">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color:var(--ew-green);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color:rgba(42,61,49,.58)">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    @if ($message->attendance_status)
                                        <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(47,107,69,.10);color:var(--ew-green);">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>
                                <p class="responsive-text mt-3" style="color:rgba(42,61,49,.78);line-height:1.8;">{{ $message->message }}</p>
                            </div>
                        @empty
                            <div class="ew-message-card text-center" style="color:rgba(42,61,49,.66);">Belum ada ucapan.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="ew-page ew-closing">
                <div class="ew-closing-card" data-reveal="zoom">
                    <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="ew-closing-photo">
                    <h2 class="ew-title responsive-text" style="font-size:clamp(2rem,5vw,3.2rem);">Terima Kasih</h2>
                    <p class="ew-note responsive-text">
                        Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.
                    </p>
                    <h3 class="ew-title ew-script responsive-text" style="margin-top:22px;font-size:clamp(2.5rem,6vw,4.8rem);">{{ $eventTitle }}</h3>
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
