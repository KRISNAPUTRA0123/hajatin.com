<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Nusantara'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
        }

        :root {
            color-scheme: light;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--wn-ink);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--wn-gold) 14%, transparent), transparent 30%),
                radial-gradient(circle at 90% 14%, color-mix(in srgb, var(--wn-maroon) 14%, transparent), transparent 34%),
                linear-gradient(180deg, var(--wn-paper) 0%, var(--wn-soft) 52%, var(--wn-paper) 100%);
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

        .wn-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .wn-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid color-mix(in srgb, var(--wn-maroon) 26%, transparent);
            background:
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat,
                linear-gradient(180deg, var(--wn-paper) 0%, var(--wn-soft) 45%, var(--wn-paper) 100%);
            box-shadow: 0 42px 130px rgba(55, 17, 26, .16);
        }

        .wn-book::before,
        .wn-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .wn-book::before {
            opacity: .22;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-batik-border-bottom.png') }}") center bottom / 100% auto repeat-x;
        }

        .wn-book::after {
            opacity: .24;
            background:
                radial-gradient(circle at 50% 0%, rgba(255, 255, 255, .72), transparent 36%),
                radial-gradient(circle at 50% 74%, color-mix(in srgb, var(--wn-gold) 12%, transparent), transparent 38%);
        }

        .wn-book > * {
            position: relative;
            z-index: 2;
        }

        .wn-floating-actions {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 99999;
            display: grid;
            gap: 8px;
            padding: 8px 0 8px 8px;
            border-radius: 18px 0 0 18px;
            background: rgba(255, 255, 255, .74);
            border: 1px solid rgba(92, 35, 44, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(46, 19, 24, .13);
            backdrop-filter: blur(14px);
        }

        .wn-floating-actions a,
        .wn-floating-actions button {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 16px 0 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 10px 22px rgba(46, 19, 24, .11);
            transition: transform .25s ease, background .25s ease;
        }

        .wn-floating-actions a:hover,
        .wn-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .wn-floating-actions button.is-active {
            background: color-mix(in srgb, var(--wn-gold) 40%, white);
        }

        .wn-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .wn-page {
            position: relative;
            min-height: auto;
            padding: 104px 74px;
            overflow: hidden;
            text-align: center;
        }

        .wn-page > * {
            position: relative;
            z-index: 5;
        }

        .wn-page.slim {
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .wn-page::before,
        .wn-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .wn-page::before {
            z-index: 1;
            opacity: .42;
            background:
                url("{{ asset('assets/nusantara/wn-top-hanging-ornament.png') }}") center top / min(760px, 96%) auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 106% auto no-repeat;
        }

        .wn-page::after {
            z-index: 2;
            opacity: .22;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .20), transparent 42%, rgba(255, 255, 255, .18)),
                radial-gradient(circle at 50% 32%, rgba(255, 255, 255, .34), transparent 44%);
        }

        .wn-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--wn-maroon);
            background: rgba(255, 255, 255, .76);
            border: 1px solid color-mix(in srgb, var(--wn-maroon) 18%, transparent);
            box-shadow: 0 12px 28px rgba(68, 22, 30, .08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .wn-label::before,
        .wn-label::after {
            content: "";
            width: 26px;
            height: 1px;
            background: var(--wn-maroon);
            opacity: .42;
        }

        .wn-title {
            margin: 0;
            color: var(--wn-maroon);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .01em;
            line-height: .96;
            text-wrap: balance;
        }

        .wn-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .wn-note {
            width: min(100%, 700px);
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--wn-ink) 78%, transparent);
            line-height: 1.9;
        }

        .wn-btn {
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
            color: #fff9e9;
            background: linear-gradient(135deg, var(--wn-maroon), var(--wn-deep));
            box-shadow: 0 16px 36px rgba(84, 31, 42, .22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .wn-btn:hover {
            transform: translateY(-2px);
        }

        .wn-btn.gold {
            color: #381b20;
            background: linear-gradient(135deg, #fff2be, var(--wn-gold), #ad8438);
        }

        .wn-btn.light {
            color: var(--wn-maroon);
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(92, 35, 44, .16);
        }

        .wn-btn::after,
        .wn-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .58), transparent);
            animation: wnShine 4.4s ease-in-out infinite;
        }

        /* HERO */
        .wn-hero {
            min-height: 920px;
            display: grid;
            place-items: center;
            padding: 78px 72px 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .72), rgba(255, 245, 246, .38) 44%, rgba(255, 246, 238, .72)),
                url("{{ asset('assets/nusantara/wn-hero-landscape.png') }}") center / cover no-repeat,
                var(--wn-paper);
        }

        .wn-hero::before {
            opacity: .95;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-arch-frame-maroon.png') }}") center 14% / min(760px, 88%) auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-foliage-left.png') }}") left 56% / min(300px, 34vw) auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-foliage-right.png') }}") right 56% / min(300px, 34vw) auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 112% auto no-repeat;
        }

        .wn-hero::after {
            opacity: .48;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .36), rgba(255, 255, 255, .15) 45%, rgba(255, 255, 255, .42)),
                radial-gradient(circle at 50% 34%, rgba(255, 255, 255, .68), transparent 40%);
        }

        .wn-hero-inner {
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 220px 0 240px;
        }

        .wn-hero-kicker {
            margin: 0;
            color: var(--wn-ink);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .20em;
            text-transform: uppercase;
        }

        .wn-hero-title {
            width: min(100%, 820px);
            margin: 14px auto 0;
            color: var(--wn-maroon);
            font-size: clamp(2.5rem, 5.8vw, 4.8rem);
            line-height: 1;
            text-align: center;
            white-space: normal;
        }

        .wn-hero-name {
            display: inline;
            line-height: 1;
        }

        .wn-hero-and {
            display: block;
            margin: -6px 0 -2px;
            color: var(--wn-maroon);
            font-size: clamp(1.25rem, 2.3vw, 1.75rem);
            font-style: italic;
            line-height: 1;
        }

        .wn-hero-date {
            margin-top: 28px;
            color: var(--wn-ink);
            font-size: 1rem;
            font-weight: 850;
            letter-spacing: .24em;
        }

        .wn-hero-actions {
            margin-top: 28px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        /* QUOTE */
        .wn-quote {
            padding-top: 0;
            background:
                linear-gradient(180deg, rgba(92, 35, 44, .58) 0 36%, rgba(255, 244, 245, .92) 36% 100%),
                url("{{ asset('assets/nusantara/wn-maroon-texture.png') }}") center top / cover no-repeat;
        }

        .wn-quote::before {
            opacity: .92;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-bottom.png') }}") center 35% / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .wn-quote-photo {
            width: min(100%, 560px);
            height: min(62vh, 560px);
            min-height: 380px;
            margin: 0 auto;
            object-fit: cover;
            display: block;
            box-shadow: 0 22px 62px rgba(63, 23, 30, .24);
        }

        .wn-quote-card {
            width: min(100%, 620px);
            margin: -4px auto 0;
            padding: 52px 42px 140px;
            background:
                linear-gradient(180deg, rgba(255, 250, 248, .94), rgba(255, 241, 242, .88)),
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(92, 35, 44, .10);
            box-shadow: 0 22px 70px rgba(64, 26, 32, .12);
        }

        .wn-quote-card h2 {
            font-size: clamp(2.7rem, 6vw, 4.8rem);
        }

        .wn-quote-card p {
            color: color-mix(in srgb, var(--wn-ink) 76%, transparent);
            line-height: 1.95;
            margin: 20px auto 0;
        }

        /* COUPLE */
        .wn-couple {
            background:
                radial-gradient(circle at 50% 20%, color-mix(in srgb, var(--wn-gold) 8%, transparent), transparent 34%),
                url("{{ asset('assets/nusantara/wn-maroon-texture.png') }}") center / cover repeat,
                var(--wn-maroon);
            color: var(--wn-cream);
        }

        .wn-couple::before {
            opacity: .86;
            background:
                url("{{ asset('assets/nusantara/wn-floral-corner-left.png') }}") left top / 280px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-corner-right.png') }}") right top / 280px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-flower-left.png') }}") left bottom / 260px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-flower-right.png') }}") right bottom / 260px auto no-repeat;
        }

        .wn-couple::after {
            opacity: .18;
            background: radial-gradient(circle at 50% 44%, rgba(255, 240, 190, .34), transparent 40%);
        }

        .wn-couple .wn-title,
        .wn-couple .wn-label {
            color: var(--wn-gold);
        }

        .wn-couple .wn-label {
            background: rgba(255, 255, 255, .08);
            border-color: rgba(224, 188, 102, .28);
        }

        .wn-couple .wn-note {
            color: rgba(255, 248, 235, .86);
        }

        .wn-couple-layout {
            width: min(100%, 940px);
            margin: 54px auto 0;
            display: grid;
            gap: 80px;
        }

        .wn-person-card {
            position: relative;
            min-height: 520px;
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            align-items: center;
            gap: 34px;
            text-align: left;
        }

        .wn-person-card.is-reverse {
            grid-template-columns: 1.05fr 1fr;
            text-align: right;
        }

        .wn-person-card.is-reverse .wn-person-photo-wrap {
            order: 2;
        }

        .wn-person-card.is-reverse .wn-person-info {
            order: 1;
        }

        .wn-person-photo-wrap {
            position: relative;
            width: min(100%, 360px);
            aspect-ratio: 1 / 1;
            margin: 0 auto;
        }

        .wn-person-photo-wrap::before {
            content: "";
            position: absolute;
            inset: -10px;
            z-index: 3;
            background: url("{{ asset('assets/nusantara/wn-oval-frame-gold.png') }}") center / contain no-repeat;
            pointer-events: none;
            filter: drop-shadow(0 20px 38px rgba(0, 0, 0, .28));
        }

        .wn-person-photo {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 74%;
            height: 74%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            overflow: hidden;
            background: var(--wn-deep);
        }

        .wn-person-photo img,
        .wn-person-initial {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .wn-person-initial {
            display: grid;
            place-items: center;
            color: var(--wn-gold);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .wn-person-script {
            color: var(--wn-gold);
            font-size: clamp(3rem, 6vw, 5.8rem);
            line-height: .9;
        }

        .wn-person-name {
            margin: 18px 0 0;
            color: #fff7e8;
            font-size: clamp(1.25rem, 2.6vw, 1.7rem);
            font-weight: 950;
            letter-spacing: .03em;
        }

        .wn-person-family {
            margin: 12px 0 0;
            color: rgba(255, 248, 235, .86);
            line-height: 1.75;
        }

        .wn-instagram-btn {
            margin-top: 20px;
            min-height: 38px;
            padding: 10px 22px;
            font-size: .78rem;
        }

        /* COUNTDOWN */
        .wn-save-date {
            min-height: 900px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255, 250, 250, .88), rgba(255, 239, 242, .48), rgba(255, 249, 240, .86)),
                url("{{ asset('assets/nusantara/wn-save-date-landscape.png') }}") center bottom / cover no-repeat,
                var(--wn-paper);
        }

        .wn-save-date::before {
            opacity: .92;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-batik-border-bottom.png') }}") center bottom / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-side-foliage-left.png') }}") left bottom / 250px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-foliage-right.png') }}") right bottom / 250px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .wn-count-panel {
            width: min(100%, 650px);
            margin: 0 auto;
            padding: 70px 38px 120px;
        }

        .wn-count-title {
            font-size: clamp(3rem, 7vw, 5.8rem);
        }

        .wn-count-grid {
            width: min(100%, 430px);
            margin: 42px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px 38px;
        }

        .wn-count-number {
            display: block;
            color: var(--wn-maroon);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.4rem, 6vw, 3.8rem);
            line-height: 1;
        }

        .wn-count-label {
            display: block;
            margin-top: 8px;
            color: var(--wn-ink);
            font-family: Georgia, "Times New Roman", serif;
            font-size: .78rem;
            letter-spacing: .06em;
        }

        .wn-count-actions {
            margin-top: 38px;
        }

        /* EVENT */
        .wn-event {
            color: var(--wn-cream);
            background:
                url("{{ asset('assets/nusantara/wn-maroon-texture.png') }}") center / cover repeat,
                var(--wn-maroon);
        }

        .wn-event::before {
            opacity: .82;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-side-foliage-left.png') }}") left 48% / 200px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-side-foliage-right.png') }}") right 48% / 200px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 106% auto no-repeat;
        }

        .wn-event .wn-title,
        .wn-event .wn-label {
            color: var(--wn-gold);
        }

        .wn-event .wn-note {
            color: rgba(255, 248, 235, .88);
        }

        .wn-event-intro {
            padding-top: 52px;
        }

        .wn-event-icon {
            width: 76px;
            max-height: 76px;
            height: auto;
            margin: 0 auto 16px;
            display: block;
            object-fit: contain;
            opacity: .95;
        }

        .wn-event-card {
            width: min(100%, 720px);
            margin: 34px auto 0;
            padding: 50px 38px 48px;
            border-radius: 34px;
            background: rgba(68, 21, 31, .62);
            border: 1px solid rgba(224, 188, 102, .28);
            box-shadow: 0 28px 80px rgba(0, 0, 0, .20);
            backdrop-filter: blur(8px);
        }

        .wn-event-card h3 {
            color: var(--wn-gold);
            font-size: clamp(1.8rem, 4.2vw, 3rem);
            text-transform: uppercase;
            letter-spacing: .08em;
            line-height: 1.15;
        }

        .wn-event-date {
            margin: 28px auto 0;
            padding-top: 26px;
            border-top: 1px solid rgba(224, 188, 102, .34);
            width: min(100%, 460px);
            color: rgba(255, 248, 235, .92);
            font-weight: 850;
            letter-spacing: .12em;
        }

        .wn-event-date-list {
            width: min(100%, 470px);
            margin: 24px auto 0;
            padding-top: 24px;
            border-top: 1px solid rgba(224, 188, 102, .34);
            display: grid;
            gap: 14px;
        }

        .wn-event-date-item {
            display: grid;
            gap: 8px;
            color: rgba(255, 248, 235, .92);
        }

        .wn-event-date-item span {
            color: var(--wn-gold);
            font-size: .74rem;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .wn-event-date-item strong {
            color: #fff8e9;
            font-size: .95rem;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
            line-height: 1.6;
        }

        .wn-event-date-until {
            width: fit-content;
            margin: 2px auto;
            padding: 6px 16px;
            border-radius: 999px;
            color: var(--wn-gold);
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(224, 188, 102, .26);
            font-size: .78rem;
            font-weight: 850;
            letter-spacing: .06em;
        }

        .wn-event-line {
            margin: 24px auto 0;
            color: rgba(255, 248, 235, .92);
            font-weight: 800;
            line-height: 1.8;
        }

        .wn-event-place {
            margin: 26px auto 0;
            color: #fff8e9;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .wn-event-address {
            width: min(100%, 560px);
            margin: 10px auto 0;
            color: rgba(255, 248, 235, .82);
            line-height: 1.75;
        }

        .wn-event-actions {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .wn-map-card {
            width: min(100%, 830px);
            margin: 34px auto 0;
            overflow: hidden;
            border-radius: 30px;
            border: 1px solid rgba(224, 188, 102, .24);
            background: rgba(255, 255, 255, .08);
            box-shadow: 0 22px 60px rgba(0, 0, 0, .18);
        }

        .wn-map-frame,
        .wn-map-placeholder {
            width: 100%;
            height: 360px;
            min-height: 360px;
            border: 0;
            display: block;
        }

        .wn-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff8e9;
            text-decoration: none;
            padding: 28px;
            background: rgba(255, 255, 255, .08);
        }

        .wn-map-footer {
            padding: 20px 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            background: rgba(58, 18, 27, .76);
            border-top: 1px solid rgba(224, 188, 102, .20);
        }

        .wn-map-title {
            margin: 0;
            color: var(--wn-gold);
            font-weight: 950;
        }

        .wn-map-address {
            margin: 6px 0 0;
            color: rgba(255, 248, 235, .78);
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* GIFT */
        .wn-gift {
            background:
                linear-gradient(180deg, rgba(255, 248, 248, .82), rgba(255, 238, 241, .70)),
                url("{{ asset('assets/nusantara/wn-save-date-landscape.png') }}") center / cover no-repeat,
                var(--wn-paper);
        }

        .wn-gift::before {
            opacity: .92;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .wn-gift-grid {
            width: min(100%, 850px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .wn-gift-grid.is-single {
            grid-template-columns: minmax(0, 440px);
            justify-content: center;
        }

        .wn-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 220px;
            padding: 38px 30px;
            border-radius: 28px;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255, 250, 248, .92), rgba(255, 238, 240, .84)),
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat;
            border: 2px solid var(--wn-maroon);
            box-shadow: 0 24px 60px rgba(64, 26, 32, .16);
        }

        .wn-gift-card::before,
        .wn-gift-card::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 38px;
            background: url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center / auto 100% repeat-x;
            opacity: .74;
        }

        .wn-gift-card::before {
            top: 0;
        }

        .wn-gift-card::after {
            bottom: 0;
            transform: rotate(180deg);
        }

        .wn-gift-title,
        .wn-gift-number,
        .wn-copy-btn,
        .wn-gift-card p {
            position: relative;
            z-index: 2;
        }

        .wn-gift-title {
            color: var(--wn-maroon);
            font-family: Georgia, serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .wn-gift-number {
            margin-top: 18px;
            color: var(--wn-deep);
            font-size: clamp(1.45rem, 4vw, 2.2rem);
            font-weight: 950;
        }

        .wn-copy-btn {
            overflow: hidden;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            padding: 12px 18px;
            color: #fff8e7;
            background: var(--wn-maroon);
            font-weight: 950;
            cursor: pointer;
        }

        .wn-copy-btn.copied {
            background: #16803c;
            color: #fff;
        }

        /* GALLERY */
        .wn-gallery {
            background: #fff5f6;
        }

        .wn-gallery::before {
            opacity: .64;
            background:
                url("{{ asset('assets/nusantara/wn-top-hanging-ornament.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") left top / 180px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") right bottom / 180px auto no-repeat;
        }

        .wn-gallery-grid {
            width: min(100%, 860px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-rows: 108px;
            grid-auto-flow: dense;
            gap: 14px;
        }

        .wn-gallery-item {
            display: block;
            overflow: hidden;
            border-radius: 18px;
            background: var(--wn-deep);
            border: 7px solid rgba(255, 255, 255, .88);
            box-shadow: 0 16px 38px rgba(68, 22, 30, .16);
        }

        .wn-gallery-item:nth-child(1) {
            grid-column: span 12;
            grid-row: span 3;
        }

        .wn-gallery-item:nth-child(n + 2) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .wn-gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .7s ease;
        }

        .wn-gallery-item:hover img {
            transform: scale(1.055);
        }

        /* RSVP */
        .wn-rsvp {
            background:
                radial-gradient(circle at 20% 18%, rgba(255,255,255,.62), transparent 28%),
                radial-gradient(circle at 80% 28%, rgba(215,185,107,.14), transparent 24%),
                linear-gradient(180deg, rgba(255,247,247,.90), rgba(255,238,241,.76), rgba(255,248,240,.92)),
                url("{{ asset('assets/nusantara/wn-rsvp-landscape.png') }}") center bottom / cover no-repeat,
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat,
                var(--wn-paper);
        }

        .wn-rsvp::before {
            opacity: .82;
            background:
                url("{{ asset('assets/nusantara/wn-top-hanging-ornament.png') }}") center top / min(760px, 96%) auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") left top / 180px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") right top / 180px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .wn-rsvp-layout {
            width: min(100%, 960px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(260px, .86fr) minmax(390px, 1.14fr);
            gap: 32px;
            align-items: start;
            text-align: left;
        }

        .wn-rsvp-copy {
            position: relative;
            overflow: hidden;
            padding: 34px 24px 30px;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.82), rgba(255,245,246,.72)),
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(92, 35, 44, .14);
            box-shadow: 0 18px 48px rgba(64, 26, 32, .10);
            backdrop-filter: blur(8px);
        }

        .wn-rsvp-copy::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .22;
            background:
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") left bottom / 120px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") right top / 110px auto no-repeat;
        }

        .wn-rsvp-copy > * {
            position: relative;
            z-index: 2;
        }

        .wn-rsvp-copy h3 {
            font-size: clamp(1.8rem, 4vw, 3.2rem);
            line-height: 1.05;
            letter-spacing: .01em;
            word-break: break-word;
            overflow-wrap: anywhere;
            text-wrap: balance;
        }

        .wn-form-card {
            padding: 28px;
            border-radius: 28px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid rgba(92, 35, 44, .12);
            box-shadow: 0 18px 48px rgba(64, 26, 32, .13);
            color: var(--wn-ink);
        }

        .wn-form-label {
            display: block;
            color: var(--wn-maroon);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .wn-input {
            width: 100%;
            margin-top: 8px;
            border: 1px solid rgba(92, 35, 44, .18);
            background: rgba(255, 255, 255, .98);
            color: var(--wn-ink);
            border-radius: 12px;
            padding: 13px 14px;
            outline: none;
        }

        .wn-summary-grid {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .wn-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 22px;
            background: rgba(255, 255, 255, .62);
            border: 1px solid rgba(92, 35, 44, .12);
            box-shadow: 0 10px 28px rgba(64, 26, 32, .08);
        }

        .wn-summary-grid b {
            display: block;
            color: var(--wn-maroon);
            font-size: 2rem;
            line-height: 1;
        }

        .wn-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 10px;
        }

        .wn-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .66);
            border: 1px solid rgba(92, 35, 44, .12);
            box-shadow: 0 10px 28px rgba(64, 26, 32, .08);
        }

        /* CLOSING */
        .wn-closing {
            min-height: 880px;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at 50% 20%, rgba(255,255,255,.72), transparent 28%),
                radial-gradient(circle at 50% 82%, rgba(215,185,107,.12), transparent 24%),
                linear-gradient(180deg, rgba(255,247,247,.92), rgba(255,238,241,.80), rgba(255,249,242,.94)),
                url("{{ asset('assets/nusantara/wn-rsvp-landscape.png') }}") center / cover no-repeat,
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat,
                var(--wn-paper);
        }

        .wn-closing::before {
            opacity: .92;
            background:
                url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-batik-border-bottom.png') }}") center bottom / 100% auto repeat-x,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") left top / 170px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") right top / 170px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .wn-closing-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 62px 36px 130px;
            border-radius: 34px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), rgba(255,245,246,.70)),
                url("{{ asset('assets/nusantara/wn-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(92, 35, 44, .12);
            box-shadow: 0 26px 72px rgba(64, 26, 32, .14);
            backdrop-filter: blur(10px);
        }

        .wn-closing-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .18;
            background:
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") left top / 140px auto no-repeat,
                url("{{ asset('assets/nusantara/wn-gallery-corner.png') }}") right bottom / 140px auto no-repeat;
        }

        .wn-closing-card > * {
            position: relative;
            z-index: 2;
        }

        .wn-closing-photo {
            width: min(100%, 300px);
            aspect-ratio: 4 / 5;
            margin: 0 auto 28px;
            display: block;
            object-fit: cover;
            border-radius: 999px 999px 30px 30px;
            border: 8px solid rgba(255, 255, 255, .94);
            box-shadow: 0 20px 54px rgba(64, 26, 32, .20);
        }

        .wn-closing-card h2 {
            font-size: clamp(2.8rem, 7vw, 5.6rem);
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(32px);
            filter: blur(7px);
            transition:
                opacity .85s cubic-bezier(.2, .8, .2, 1),
                transform .85s cubic-bezier(.2, .8, .2, 1),
                filter .85s cubic-bezier(.2, .8, .2, 1);
            transition-delay: var(--reveal-delay, 0s);
        }

        [data-reveal="left"] {
            transform: translateX(-34px);
        }

        [data-reveal="right"] {
            transform: translateX(34px);
        }

        [data-reveal="zoom"] {
            transform: translateY(20px) scale(.94);
        }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0, 0) scale(1);
            filter: blur(0);
        }

        @keyframes wnShine {
            0%, 48% {
                left: -88%;
            }

            76%, 100% {
                left: 135%;
            }
        }

        @media (min-width: 1440px) {
            .wn-shell {
                width: min(100%, 1280px);
            }
        }

        @media (max-width: 980px) {
            .wn-shell {
                padding: 14px;
            }

            .wn-page {
                padding: 92px 36px;
            }

            .wn-hero {
                min-height: 860px;
                padding: 68px 36px 0;
            }

            .wn-hero::before {
                background-size:
                    100% auto,
                    min(760px, 94%) auto,
                    220px auto,
                    220px auto,
                    130% auto;
            }

            .wn-hero-inner {
                padding-top: 205px;
                padding-bottom: 210px;
            }

            .wn-person-card,
            .wn-person-card.is-reverse {
                grid-template-columns: 1fr;
                text-align: center;
                min-height: auto;
                gap: 18px;
            }

            .wn-person-card.is-reverse .wn-person-photo-wrap,
            .wn-person-card.is-reverse .wn-person-info {
                order: initial;
            }

            .wn-rsvp-layout {
                grid-template-columns: 1fr;
            }

            .wn-gift-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .wn-shell {
                padding: 0;
            }

            .wn-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .wn-page,
            .wn-page.slim {
                padding: 76px 22px;
            }

            .wn-event-intro {
                padding-top: 58px;
            }

            .wn-event-icon {
                width: 58px;
                max-height: 58px;
                margin-bottom: 12px;
            }

            .wn-event-card {
                margin-top: 30px;
            }

            .wn-event-date-item strong {
                font-size: .82rem;
                letter-spacing: .05em;
            }

            .wn-floating-actions a,
            .wn-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .wn-hero {
                min-height: 100svh;
                padding: 54px 22px 0;
            }

            .wn-rsvp-copy {
                padding: 28px 18px 24px;
            }

            .wn-rsvp-copy h3 {
                font-size: clamp(1.65rem, 8vw, 2.5rem);
                line-height: 1.02;
            }

            .wn-hero::before {
                background:
                    url("{{ asset('assets/nusantara/wn-batik-border-top.png') }}") center top / 160% auto repeat-x,
                    url("{{ asset('assets/nusantara/wn-arch-frame-maroon.png') }}") center 12% / 104% auto no-repeat,
                    url("{{ asset('assets/nusantara/wn-side-foliage-left.png') }}") left 54% / 150px auto no-repeat,
                    url("{{ asset('assets/nusantara/wn-side-foliage-right.png') }}") right 54% / 150px auto no-repeat,
                    url("{{ asset('assets/nusantara/wn-floral-bottom-meadow.png') }}") center bottom / 170% auto no-repeat;
            }

            .wn-hero-inner {
                padding-top: 170px;
                padding-bottom: 180px;
            }

            .wn-hero-title {
                width: min(100%, 420px);
                font-size: clamp(2.25rem, 11vw, 3.65rem);
                line-height: 1;
            }

            .wn-hero-name {
                display: inline;
                line-height: 1;
            }

            .wn-hero-and {
                display: block;
                margin: -5px 0 -2px;
                font-size: clamp(1.05rem, 5vw, 1.45rem);
                line-height: 1;
            }

            .wn-quote-photo {
                height: 420px;
                min-height: 420px;
            }

            .wn-quote-card {
                padding: 44px 22px 120px;
            }

            .wn-person-photo-wrap {
                width: min(100%, 300px);
            }

            .wn-couple-layout {
                gap: 54px;
            }

            .wn-count-grid {
                gap: 24px 20px;
            }

            .wn-event-card {
                padding: 48px 22px;
            }

            .wn-event-actions,
            .wn-hero-actions {
                flex-direction: column;
                align-items: center;
            }

            .wn-event-actions .wn-btn,
            .wn-hero-actions .wn-btn {
                width: min(100%, 280px);
            }

            .wn-map-frame,
            .wn-map-placeholder {
                height: 310px;
                min-height: 310px;
            }

            .wn-map-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .wn-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-auto-rows: 132px;
            }

            .wn-gallery-item:nth-child(1),
            .wn-gallery-item:nth-child(n + 2) {
                grid-column: span 1;
                grid-row: span 1;
            }

            .wn-gallery-item:nth-child(1) {
                grid-column: span 2;
                grid-row: span 2;
            }

            .wn-summary-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important;
            }

            [data-reveal] {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        /* ANTI INSPECT BASIC PROTECTION */
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

        @media (max-width: 640px) {
            .wn-side-flower-left,
            .wn-side-flower-right {
                width: 120px;
                max-width: 34vw;
                opacity: .09;
            }

            .wn-side-flower-left {
                left: -6px;
                bottom: 0;
            }

            .wn-side-flower-right {
                right: -6px;
                bottom: 0;
            }
        }
    </style>
</head>

@php
    $wnThemeKey = $invitation->theme_color ?: 'maroon';

    $wnThemes = [
        'maroon' => [
            'paper' => '#f8eeee',
            'soft' => '#f1dfdf',
            'ink' => '#4d2930',
            'maroon' => '#5a232d',
            'deep' => '#321119',
            'gold' => '#d7b96b',
            'cream' => '#fff4df',
        ],
        'emerald' => [
            'paper' => '#eef6ef',
            'soft' => '#dfeee2',
            'ink' => '#193f36',
            'maroon' => '#164b40',
            'deep' => '#08241e',
            'gold' => '#d7bd72',
            'cream' => '#f7fff4',
        ],
        'navy' => [
            'paper' => '#eef2f8',
            'soft' => '#dfe6f1',
            'ink' => '#1a304a',
            'maroon' => '#17375d',
            'deep' => '#07172b',
            'gold' => '#d7bd72',
            'cream' => '#f5f9ff',
        ],
        'rose' => [
            'paper' => '#fff0ef',
            'soft' => '#f5dddd',
            'ink' => '#5a253c',
            'maroon' => '#74324b',
            'deep' => '#35101e',
            'gold' => '#d7b96b',
            'cream' => '#fff3ee',
        ],
        'gold' => [
            'paper' => '#fbf3df',
            'soft' => '#efe0bd',
            'ink' => '#4f3b1a',
            'maroon' => '#725126',
            'deep' => '#2c1c08',
            'gold' => '#d8b65c',
            'cream' => '#fff6dc',
        ],
        'slate' => [
            'paper' => '#f0f2f4',
            'soft' => '#dde0e4',
            'ink' => '#292f37',
            'maroon' => '#3f454d',
            'deep' => '#11151a',
            'gold' => '#d2b875',
            'cream' => '#f8f8f2',
        ],
    ];

    $wnTheme = $wnThemes[$wnThemeKey] ?? $wnThemes['maroon'];

    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'Alisha & Rangga');
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Alisha');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Rangga');

    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/nusantara/wn-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;

    $eventDateShort = $startDate ? $startDate->format('d . m . y') : '29 . 03 . 26';
    $eventDateText = $startDate ? $startDate->translatedFormat('l, d F Y') : 'Minggu, 29 Maret 2026';
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

    $eventStartShortText = $startDate
        ? $startDate->translatedFormat('l, d M Y')
        : 'Tanggal belum diatur';

    $hasDifferentEndDate = !empty($invitation->event_end_date)
        && $endDate
        && $startDate
        && !$startDate->isSameDay($endDate);

    $eventEndShortText = $hasDifferentEndDate
        ? $endDate->translatedFormat('l, d M Y')
        : null;

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;

    if ($invitation->event_end_time && $eventTimeText) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    } elseif ($invitation->event_end_time) {
        $eventTimeText = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Upperhills Convention Hall';
    $addressText = $invitation->address ?: 'Jl. Metro Tj. Bunga No.995, Maccini Sombala, Kec. Tamalate, Kota Makassar';
    $descriptionText = $invitation->description ?: 'Dengan memohon rahmat dan ridho Allah Subhanahu Wa Ta’ala, InsyaAllah kami akan menyelenggarakan acara pernikahan kami.';

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
    --wn-paper: {{ $wnTheme['paper'] }};
    --wn-soft: {{ $wnTheme['soft'] }};
    --wn-ink: {{ $wnTheme['ink'] }};
    --wn-maroon: {{ $wnTheme['maroon'] }};
    --wn-deep: {{ $wnTheme['deep'] }};
    --wn-gold: {{ $wnTheme['gold'] }};
    --wn-cream: {{ $wnTheme['cream'] }};
">
    <div class="wn-shell">
        <main class="wn-book" id="top">
            <div class="wn-floating-actions" aria-label="Aksi undangan">
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

            <section id="opening" class="wn-page wn-hero">
                <div class="wn-hero-inner" data-reveal="zoom">
                    <p class="wn-hero-kicker responsive-text">
                        {{ strtoupper($invitation->event_name ?: 'The Wedding Of') }}
                    </p>

                    <h1 class="wn-title wn-script wn-hero-title responsive-text">
                        <span class="wn-hero-name">{{ $brideName }}</span>
                        <span class="wn-hero-and">&</span>
                        <span class="wn-hero-name">{{ $groomName }}</span>
                    </h1>

                    <p class="wn-hero-date responsive-text">{{ $eventDateShort }}</p>

                    <div class="wn-hero-actions">
                        <a href="#quote" class="wn-btn gold">Buka Undangan</a>
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="wn-btn light">Simpan Tanggal</a>
                    </div>
                </div>
            </section>

            <section id="quote" class="wn-page wn-quote">
                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="wn-quote-photo" data-reveal="zoom">

                <div class="wn-quote-card" data-reveal="zoom">
                    <h2 class="wn-title wn-script responsive-text">With Love</h2>

                    <p class="responsive-text">
                        “Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu
                        dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu
                        rasa kasih dan sayang.”
                    </p>

                    <p class="responsive-text" style="font-weight:950;">QS Ar-Rum : 21</p>
                </div>
            </section>

            <section id="couple" class="wn-page wn-couple">
                <p class="wn-label" data-reveal="zoom">Bride & Groom</p>

                <h2 class="wn-title wn-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,5.8rem);">
                    Bride & Groom
                </h2>

                <p class="wn-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    {{ $descriptionText }}
                </p>

                <div class="wn-couple-layout">
                    <article class="wn-person-card" data-reveal="left">
                        <div class="wn-person-photo-wrap">
                            <div class="wn-person-photo">
                                @if ($bridePhoto)
                                    <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                                @else
                                    <div class="wn-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="wn-person-info">
                            <div class="wn-title wn-script wn-person-script responsive-text">{{ $brideName }}</div>
                            <h3 class="wn-person-name responsive-text">{{ $brideSubtitle }}</h3>
                            <p class="wn-person-family responsive-text">
                                {{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}
                            </p>

                            @if (!empty($bride->instagram))
                                <a href="{{ $bride->instagram }}" target="_blank" class="wn-btn gold wn-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>

                    <article class="wn-person-card is-reverse" data-reveal="right">
                        <div class="wn-person-photo-wrap">
                            <div class="wn-person-photo">
                                @if ($groomPhoto)
                                    <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                                @else
                                    <div class="wn-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="wn-person-info">
                            <div class="wn-title wn-script wn-person-script responsive-text">{{ $groomName }}</div>
                            <h3 class="wn-person-name responsive-text">{{ $groomSubtitle }}</h3>
                            <p class="wn-person-family responsive-text">
                                {{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}
                            </p>

                            @if (!empty($groom->instagram))
                                <a href="{{ $groom->instagram }}" target="_blank" class="wn-btn gold wn-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>
                </div>
            </section>

            <section id="countdown" class="wn-page wn-save-date">
                <div class="wn-count-panel" data-reveal="zoom">
                    <h2 class="wn-title wn-script wn-count-title responsive-text">Save the Date</h2>

                    <div class="wn-count-grid" data-countdown="{{ $targetDateTime }}">
                        <div class="wn-count-card">
                            <span class="wn-count-number" data-days>0</span>
                            <span class="wn-count-label">Days</span>
                        </div>

                        <div class="wn-count-card">
                            <span class="wn-count-number" data-hours>0</span>
                            <span class="wn-count-label">Hours</span>
                        </div>

                        <div class="wn-count-card">
                            <span class="wn-count-number" data-minutes>0</span>
                            <span class="wn-count-label">Minutes</span>
                        </div>

                        <div class="wn-count-card">
                            <span class="wn-count-number" data-seconds>0</span>
                            <span class="wn-count-label">Seconds</span>
                        </div>
                    </div>

                    <div class="wn-count-actions">
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="wn-btn">Add to Calendar</a>
                    </div>
                </div>
            </section>

            <section id="acara" class="wn-page wn-event">
                <div class="wn-event-intro" data-reveal="zoom">
                    <h2 class="wn-title wn-script responsive-text" style="font-size:clamp(2.7rem,6vw,5rem);">
                        Detail Acara
                    </h2>

                    <p class="wn-note responsive-text">
                        Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir
                        dan memberikan doa restu pada acara pernikahan kami.
                    </p>
                </div>

                <article class="wn-event-card" data-reveal="zoom">
                    <h3 class="wn-title responsive-text">Acara Pernikahan</h3>

                    <div class="wn-event-date-list">
                        <div class="wn-event-date-item">
                            <span>Tanggal</span>
                            <strong>{{ $eventStartShortText }}</strong>
                        </div>

                        @if ($hasDifferentEndDate)
                            <div class="wn-event-date-until">Sampai</div>

                            <div class="wn-event-date-item">
                                <strong>{{ $eventEndShortText }}</strong>
                            </div>
                        @endif
                    </div>

                    @if ($eventTimeText)
                        <p class="wn-event-line responsive-text">
                            Pukul {{ $eventTimeText }}
                        </p>
                    @endif

                    <p class="wn-event-place responsive-text">{{ $locationText }}</p>
                    <p class="wn-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="wn-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="wn-btn gold">Lihat Lokasi</a>
                        @endif

                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="wn-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="wn-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe
                                class="wn-map-frame"
                                src="{{ $mapEmbedUrl }}"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="wn-map-placeholder">
                                <div>
                                    <div style="font-size:3rem">⌖</div>
                                    <strong>{{ $locationText }}</strong>
                                </div>
                            </a>
                        @endif

                        <div class="wn-map-footer">
                            <div>
                                <p class="wn-map-title responsive-text">{{ $locationText }}</p>
                                <p class="wn-map-address responsive-text">{{ $addressText }}</p>
                            </div>

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="wn-btn gold">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            @if ($gifts->count())
                <section id="gift" class="wn-page wn-gift slim">
                    <p class="wn-label" data-reveal="zoom">Wedding Gift</p>

                    <h2 class="wn-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.2rem);text-transform:uppercase;">
                        Wedding Gift
                    </h2>

                    <p class="wn-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan,
                        Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>

                    <div class="wn-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $gift)
                            <div class="wn-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                                <div class="wn-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                                <div class="wn-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>

                                <p class="responsive-text" style="margin:12px 0 0;color:rgba(77,41,48,.72);">
                                    {{ $gift->account_name ?? $eventTitle }}
                                </p>

                                <button type="button" class="wn-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">
                                    Salin Nomor
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($galleryPhotos->count())
                <section id="galeri" class="wn-page wn-gallery">
                    <p class="wn-label" data-reveal="zoom">Our Moments</p>

                    <h2 class="wn-title wn-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,5rem);">
                        Our Moments
                    </h2>

                    <div class="wn-gallery-grid">
                        @foreach ($galleryPhotos as $photo)
                            @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp

                            @if ($src)
                                <a
                                    href="{{ $src }}"
                                    target="_blank"
                                    class="wn-gallery-item"
                                    data-reveal="zoom"
                                    style="--reveal-delay:{{ $loop->index * .04 }}s"
                                >
                                    <img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="wn-page wn-rsvp slim">
                <p class="wn-label" data-reveal="zoom">RSVP</p>

                <h2 class="wn-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">
                    RSVP Form
                </h2>

                <div class="wn-rsvp-layout">
                    <div class="wn-rsvp-copy" data-reveal="left">
                        <h3 class="wn-title wn-script responsive-text">Kehadiran Anda</h3>

                        <p class="wn-note responsive-text" style="margin-left:0;">
                            Kami tidak sabar menunggu hari pernikahan kami bersama Anda.
                            Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="wn-form-card space-y-4" data-reveal="right">
                        @csrf

                        <div>
                            <label class="wn-form-label">Nama</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="wn-input" placeholder="Nama lengkap" required>
                        </div>

                        <div>
                            <label class="wn-form-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="wn-input">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="wn-form-label">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="wn-input">
                        </div>

                        <div>
                            <label class="wn-form-label">Pesan</label>
                            <textarea name="message" rows="4" class="wn-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="wn-btn" style="width:100%;">Kirim</button>
                    </form>

                    <div class="wn-summary-grid" data-reveal="zoom">
                        <div>
                            <b>{{ $tidakHadir }}</b>
                            <span>Tidak Hadir</span>
                        </div>

                        <div>
                            <b>{{ $hadir }}</b>
                            <span>Hadir</span>
                        </div>

                        <div>
                            <b>{{ $ragu }}</b>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="wn-message-list">
                        @forelse ($messages->take(5) as $message)
                            <div class="wn-message-card" data-reveal="zoom">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color:var(--wn-maroon);">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs mt-1" style="color:rgba(77,41,48,.58)">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(90,35,45,.10);color:var(--wn-maroon);">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-3" style="color:rgba(77,41,48,.78);line-height:1.8;">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @empty
                            <div class="wn-message-card text-center" style="color:rgba(77,41,48,.66);">
                                Belum ada ucapan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="wn-page wn-closing">
                <div class="wn-closing-card" data-reveal="zoom">
                    <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="wn-closing-photo">

                    <h2 class="wn-title responsive-text" style="font-size:clamp(2rem,5vw,3.2rem);">
                        Terima Kasih
                    </h2>

                    <p class="wn-note responsive-text">
                        Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i
                        berkenan hadir dan memberikan doa restu kepada kami.
                    </p>

                    <h3 class="wn-title wn-script responsive-text" style="margin-top:22px;font-size:clamp(2.5rem,6vw,4.8rem);">
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
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
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

            if (!['input', 'textarea', 'select', 'option'].includes(tag)) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
