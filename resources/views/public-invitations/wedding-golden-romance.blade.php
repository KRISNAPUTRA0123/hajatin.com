<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Golden Romance'));
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
            color: var(--gr-ink);
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--gr-gold) 18%, transparent), transparent 32%),
                radial-gradient(circle at 88% 14%, color-mix(in srgb, var(--gr-rose) 14%, transparent), transparent 30%),
                linear-gradient(180deg, var(--gr-paper) 0%, var(--gr-soft) 48%, var(--gr-paper) 100%);
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

        .gr-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .gr-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid rgba(89, 71, 47, .16);
            background:
                linear-gradient(180deg, rgba(255,255,255,.70), rgba(255,249,241,.78)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat,
                var(--gr-paper);
            box-shadow: 0 42px 130px rgba(52, 39, 23, .16);
        }

        .gr-book::before,
        .gr-book::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .gr-book::before {
            opacity: .32;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-corner-left.png') }}") left top / 230px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-corner-right.png') }}") right top / 230px auto no-repeat,
                linear-gradient(90deg, rgba(89, 71, 47, .035) 1px, transparent 1px) 0 0 / 42px 42px,
                linear-gradient(0deg, rgba(89, 71, 47, .028) 1px, transparent 1px) 0 0 / 42px 42px;
        }

        .gr-book::after {
            opacity: .34;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.78), transparent 36%),
                radial-gradient(circle at 50% 72%, color-mix(in srgb, var(--gr-gold) 12%, transparent), transparent 40%);
        }

        .gr-book > * {
            position: relative;
            z-index: 2;
        }

        .gr-floating-actions {
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
            border: 1px solid rgba(89, 71, 47, .14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(52, 39, 23, .13);
            backdrop-filter: blur(14px);
        }

        .gr-floating-actions a,
        .gr-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(52, 39, 23, .11);
            transition: transform .25s ease, background .25s ease;
        }

        .gr-floating-actions a:hover,
        .gr-floating-actions button:hover {
            transform: translateX(-3px);
        }

        .gr-floating-actions button.is-active {
            background: color-mix(in srgb, var(--gr-gold) 36%, white);
        }

        .gr-floating-actions img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .gr-page {
            position: relative;
            min-height: auto;
            padding: 104px 74px;
            overflow: hidden;
            text-align: center;
        }

        .gr-page > * {
            position: relative;
            z-index: 5;
        }

        .gr-page.slim {
            padding-top: 86px;
            padding-bottom: 86px;
        }

        .gr-page::before,
        .gr-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .gr-page::before {
            z-index: 1;
            opacity: .34;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-top-vine.png') }}") center top / min(820px, 96%) auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .gr-page::after {
            z-index: 2;
            opacity: .20;
            background:
                linear-gradient(180deg, rgba(255,255,255,.24), transparent 42%, rgba(255,255,255,.18)),
                radial-gradient(circle at 50% 32%, rgba(255,255,255,.38), transparent 46%);
        }

        .gr-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--gr-brown);
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(89, 71, 47, .15);
            box-shadow: 0 12px 28px rgba(52, 39, 23, .07);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .gr-label::before,
        .gr-label::after {
            content: "";
            width: 26px;
            height: 1px;
            background: var(--gr-brown);
            opacity: .42;
        }

        .gr-title {
            margin: 0;
            color: var(--gr-brown);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .01em;
            line-height: .96;
            text-wrap: balance;
        }

        .gr-script {
            font-family: "Great Vibes", "Cormorant Garamond", Georgia, "Times New Roman", serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .gr-note {
            width: min(100%, 700px);
            margin: 20px auto 0;
            color: color-mix(in srgb, var(--gr-ink) 78%, transparent);
            line-height: 1.9;
        }

        .gr-btn {
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
            background: linear-gradient(135deg, var(--gr-brown), var(--gr-deep));
            box-shadow: 0 16px 36px rgba(89, 71, 47, .22);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .gr-btn:hover {
            transform: translateY(-2px);
        }

        .gr-btn.gold {
            color: #342716;
            background: linear-gradient(135deg, #fff2be, var(--gr-gold), #ad8438);
        }

        .gr-btn.light {
            color: var(--gr-brown);
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(89, 71, 47, .15);
        }

        .gr-btn::after,
        .gr-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: grShine 4.4s ease-in-out infinite;
        }

        /* HERO - halaman 1 Undangan4 */
        .gr-hero {
            min-height: 940px;
            display: grid;
            place-items: center;
            padding: 72px 72px 0;
            background:
                linear-gradient(180deg, rgba(255,252,247,.88), rgba(255,249,241,.44) 48%, rgba(244,238,226,.80)),
                url("{{ asset('assets/golden-romance/gr-palace-hero.png') }}") center 48% / cover no-repeat,
                var(--gr-paper);
        }

        .gr-hero::before {
            opacity: .98;
            background:
                url("{{ asset('assets/golden-romance/gr-palace-garden-foreground.png') }}") center bottom / 112% auto no-repeat;
        }

        .gr-hero::after {
            opacity: .58;
            background:
                linear-gradient(180deg, rgba(255,255,255,.36), rgba(255,255,255,.12) 42%, rgba(255,255,255,.36)),
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.68), transparent 42%);
        }

        .gr-hero-inner {
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 42px 0 330px;
        }

        .gr-hero-kicker {
            margin: 0;
            color: var(--gr-ink);
            font-size: 13px;
            font-weight: 950;
            letter-spacing: .20em;
            text-transform: capitalize;
        }

        .gr-hero-title {
            width: min(100%, 760px);
            margin: 20px auto 0;
            color: var(--gr-brown);
            font-size: clamp(2.8rem, 6vw, 5rem);
            line-height: 1;
            text-align: center;
            white-space: normal;
        }

        .gr-hero-name {
            display: inline;
            line-height: 1;
        }

        .gr-hero-and {
            display: block;
            margin: 4px 0 6px;
            color: var(--gr-brown);
            font-size: clamp(1.25rem, 2.6vw, 1.9rem);
            font-style: italic;
            line-height: 1;
        }

        .gr-hero-date {
            margin-top: 20px;
            color: var(--gr-ink);
            font-size: 1rem;
            font-weight: 850;
            letter-spacing: .24em;
        }

        .gr-hero-photo {
            width: 220px;
            max-width: 58%;
            aspect-ratio: 3 / 4;
            margin: 32px auto 0;
            object-fit: cover;
            display: block;
            border-radius: 999px 999px 28px 28px;
            border: 8px solid rgba(255,255,255,.94);
            outline: 1px solid rgba(89, 71, 47, .22);
            box-shadow: 0 22px 62px rgba(52, 39, 23, .18);
        }

        .gr-scroll-hint {
            margin-top: 24px;
            color: rgba(67, 57, 43, .78);
            font-size: .95rem;
            letter-spacing: .08em;
        }

        .gr-hero-actions {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        /* COUPLE - halaman 2 */
        .gr-couple {
            background:
                linear-gradient(180deg, rgba(255,250,247,.94), rgba(255,247,239,.82)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat,
                var(--gr-paper);
        }

        .gr-couple::before {
            opacity: .72;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-top-vine.png') }}") center top / 96% auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-side-left.png') }}") left 38% / 220px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-side-right.png') }}") right 38% / 220px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .gr-couple-grid {
            width: min(100%, 960px);
            margin: 54px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 34px;
            align-items: start;
        }

        .gr-person-card {
            position: relative;
            min-height: 620px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: center;
        }

        .gr-person-frame {
            position: relative;
            width: min(100%, 360px);
            margin: 0 auto;
            aspect-ratio: 3 / 4.25;
        }

        .gr-person-frame::before {
            content: "";
            position: absolute;
            inset: -26px -36px;
            z-index: 3;
            background: url("{{ asset('assets/golden-romance/gr-ornate-mirror-frame.png') }}") center / contain no-repeat;
            pointer-events: none;
            filter: drop-shadow(0 20px 34px rgba(52, 39, 23, .20));
        }

        .gr-person-photo {
            position: absolute;
            inset: 14% 18% 14% 18%;
            border-radius: 999px 999px 18px 18px;
            overflow: hidden;
            background: var(--gr-deep);
        }

        .gr-person-photo img,
        .gr-person-initial {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .gr-person-initial {
            display: grid;
            place-items: center;
            color: var(--gr-gold);
            font-family: Georgia, serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .gr-person-meta {
            margin-top: 16px;
        }

        .gr-person-script {
            color: var(--gr-brown);
            font-size: clamp(2.4rem, 4.8vw, 4.5rem);
            line-height: .92;
        }

        .gr-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 8px auto 10px;
            padding: 6px 18px;
            border-radius: 999px;
            color: var(--gr-brown);
            background: rgba(255, 255, 255, .78);
            border: 1px solid rgba(89, 71, 47, .14);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
            box-shadow: 0 8px 18px rgba(52, 39, 23, .06);
        }

        .gr-person-family {
            position: relative;
            width: min(100%, 340px);
            margin: 8px auto 0;
            padding: 14px 8px 0;
            color: #4b3b28;
            background: transparent;
            border: 0;
            border-radius: 0;
            font-size: clamp(.86rem, 1.35vw, .96rem);
            font-weight: 700;
            line-height: 1.6;
            letter-spacing: .01em;
            text-align: center;
            text-shadow: 0 1px 0 rgba(255, 255, 255, .75);
            box-shadow: none;
        }

        .gr-person-family::before {
            content: "";
            display: block;
            width: 54px;
            height: 1px;
            margin: 0 auto 12px;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(114, 81, 38, .55),
                transparent
            );
        }

        .gr-instagram-btn {
            margin-top: 18px;
            min-height: 38px;
            padding: 10px 22px;
            font-size: .78rem;
        }

        /* MOMENT - halaman 3 */
        .gr-moment {
            background:
                linear-gradient(180deg, rgba(255,250,247,.92), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-gallery-haze-soft.png') }}") center / cover no-repeat,
                var(--gr-paper);
        }

        .gr-moment::before {
            opacity: .48;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-corner-left.png') }}") left top / 210px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-corner-right.png') }}") right bottom / 210px auto no-repeat;
        }

        .gr-moment-photo {
            width: min(100%, 720px);
            height: min(72vh, 660px);
            min-height: 420px;
            margin: 44px auto 0;
            object-fit: cover;
            display: block;
            border-radius: 24px;
            border: 10px solid rgba(255,255,255,.88);
            box-shadow: 0 26px 78px rgba(52, 39, 23, .16);
        }

        /* SAVE DATE - halaman 4 */
        .gr-save-date {
            min-height: 880px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255,250,247,.92), rgba(255,247,239,.78)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat,
                var(--gr-paper);
        }

        .gr-save-date::before {
            opacity: .72;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-top-vine.png') }}") center top / 94% auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-side-left.png') }}") left 52% / 200px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-side-right.png') }}") right 52% / 200px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .gr-count-panel {
            width: min(100%, 620px);
            margin: 0 auto;
            padding: 36px 28px 90px;
        }

        .gr-key {
            width: min(46%, 230px);
            margin: 0 auto 18px;
            display: block;
            filter: drop-shadow(0 18px 28px rgba(52, 39, 23, .12));
        }

        .gr-count-title {
            width: min(100%, 520px);
            margin: 0 auto 10px;
            color: var(--gr-brown);
            font-size: clamp(1.8rem, 3.8vw, 3.2rem);
            line-height: 1.08;
            letter-spacing: .01em;
        }

        .gr-count-grid {
            width: min(100%, 430px);
            margin: 34px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px 34px;
        }

        .gr-count-card {
            padding: 18px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(89, 71, 47, .12);
            box-shadow: 0 14px 34px rgba(52, 39, 23, .08);
        }

        .gr-count-number {
            display: block;
            color: var(--gr-brown);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.1rem, 5vw, 3.5rem);
            line-height: 1;
            font-weight: 800;
        }

        .gr-count-label {
            display: block;
            margin-top: 7px;
            color: var(--gr-ink);
            font-size: .72rem;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .gr-count-actions {
            margin-top: 34px;
        }

        /* EVENT - halaman 5 */
        .gr-event {
            background:
                linear-gradient(180deg, rgba(255,250,247,.94), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat,
                var(--gr-paper);
        }

        .gr-event::before {
            opacity: .82;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-corner-left.png') }}") left top / 180px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-corner-right.png') }}") right top / 180px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-palace-door-frame.png') }}") center bottom / min(760px, 92%) auto no-repeat;
        }

        .gr-event-card {
            width: min(100%, 560px);
            min-height: auto;
            margin: 34px auto 0;
            padding: 44px 34px 42px;
            border-radius: 32px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .82), rgba(255, 248, 238, .72)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(89, 71, 47, .14);
            box-shadow: 0 24px 70px rgba(52, 39, 23, .12);
            backdrop-filter: blur(8px);
            display: grid;
            align-content: start;
            justify-items: center;
            text-align: center;
        }

        .gr-event-card h3 {
            display: none;
        }

        .gr-event-date-list {
            width: min(100%, 420px);
            margin: 0 auto;
            padding-bottom: 20px;
            display: grid;
            gap: 12px;
            border-bottom: 1px solid rgba(89, 71, 47, .14);
        }

        .gr-event-date-item {
            display: grid;
            gap: 8px;
            color: var(--gr-ink);
        }

        .gr-event-date-item span {
            color: var(--gr-brown);
            font-size: .74rem;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .gr-event-date-item strong {
            color: var(--gr-ink);
            font-size: .95rem;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
            line-height: 1.6;
        }

        .gr-event-date-until {
            width: fit-content;
            margin: 0 auto;
            padding: 6px 16px;
            border-radius: 999px;
            color: var(--gr-brown);
            background: rgba(255,255,255,.58);
            border: 1px solid rgba(89, 71, 47, .15);
            font-size: .78rem;
            font-weight: 850;
        }

        .gr-event-line {
            margin: 18px auto 0;
            color: var(--gr-ink);
            font-weight: 800;
            line-height: 1.8;
        }

        .gr-event-place {
            margin: 22px auto 0;
            color: var(--gr-brown);
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .gr-event-address {
            width: min(100%, 500px);
            margin: 10px auto 0;
            color: rgba(67,57,43,.74);
            line-height: 1.75;
        }

        .gr-event-actions {
            margin-top: 28px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .gr-map-card {
            width: min(100%, 830px);
            margin: 30px auto 0;
            overflow: hidden;
            border-radius: 30px;
            border: 1px solid rgba(89, 71, 47, .14);
            background: rgba(255,255,255,.62);
            box-shadow: 0 22px 60px rgba(52, 39, 23, .12);
        }

        .gr-map-frame,
        .gr-map-placeholder {
            width: 100%;
            height: 360px;
            min-height: 360px;
            border: 0;
            display: block;
        }

        .gr-map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gr-brown);
            text-decoration: none;
            padding: 28px;
            background: rgba(255,255,255,.58);
        }

        .gr-map-footer {
            padding: 20px 22px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            text-align: left;
            background: rgba(255,255,255,.78);
            border-top: 1px solid rgba(89, 71, 47, .12);
        }

        .gr-map-title {
            margin: 0;
            color: var(--gr-brown);
            font-weight: 950;
        }

        .gr-map-address {
            margin: 6px 0 0;
            color: rgba(67,57,43,.72);
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* GIFT */
        .gr-gift {
            background:
                linear-gradient(180deg, rgba(255,250,247,.94), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-gallery-haze-soft.png') }}") center / cover no-repeat,
                var(--gr-paper);
        }

        .gr-gift-grid {
            width: min(100%, 850px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .gr-gift-grid.is-single {
            grid-template-columns: minmax(0, 440px);
            justify-content: center;
        }

        .gr-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 220px;
            padding: 38px 30px;
            border-radius: 28px;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.86), rgba(255,248,238,.78)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(89, 71, 47, .16);
            box-shadow: 0 24px 60px rgba(52, 39, 23, .12);
        }

        .gr-gift-title {
            color: var(--gr-brown);
            font-family: Georgia, serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .gr-gift-number {
            margin-top: 18px;
            color: var(--gr-deep);
            font-size: clamp(1.45rem, 4vw, 2.2rem);
            font-weight: 950;
        }

        .gr-copy-btn {
            position: relative;
            overflow: hidden;
            margin-top: 18px;
            border: 0;
            border-radius: 999px;
            padding: 12px 18px;
            color: #fff8e7;
            background: var(--gr-brown);
            font-weight: 950;
            cursor: pointer;
        }

        .gr-copy-btn.copied {
            background: #16803c;
            color: #fff;
        }

        /* GALLERY */
        .gr-gallery {
            background:
                linear-gradient(180deg, rgba(255,250,247,.94), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat,
                var(--gr-paper);
        }

        .gr-gallery-grid {
            width: min(100%, 860px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            grid-auto-rows: 110px;
            grid-auto-flow: dense;
            gap: 14px;
        }

        .gr-gallery-item {
            display: block;
            overflow: hidden;
            border-radius: 18px;
            background: var(--gr-deep);
            border: 7px solid rgba(255,255,255,.88);
            box-shadow: 0 16px 38px rgba(52, 39, 23, .13);
        }

        .gr-gallery-item:nth-child(1) {
            grid-column: span 12;
            grid-row: span 3;
        }

        .gr-gallery-item:nth-child(n + 2) {
            grid-column: span 3;
            grid-row: span 2;
        }

        .gr-gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .7s ease;
        }

        .gr-gallery-item:hover img {
            transform: scale(1.055);
        }

        /* RSVP */
        .gr-rsvp {
            background:
                radial-gradient(circle at 18% 18%, rgba(255,255,255,.64), transparent 30%),
                radial-gradient(circle at 82% 28%, rgba(209,169,89,.12), transparent 28%),
                linear-gradient(180deg, rgba(255,250,247,.92), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-gallery-haze-soft.png') }}") center / cover no-repeat,
                var(--gr-paper);
        }

        .gr-rsvp::before {
            opacity: .42;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-corner-left.png') }}") left top / 170px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-corner-right.png') }}") right top / 170px auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .gr-rsvp-layout {
            width: min(100%, 960px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: minmax(260px, .86fr) minmax(390px, 1.14fr);
            gap: 32px;
            align-items: start;
            text-align: left;
        }

        .gr-rsvp-copy {
            position: relative;
            overflow: hidden;
            padding: 34px 24px 30px;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.82), rgba(255,248,238,.72)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(89, 71, 47, .14);
            box-shadow: 0 18px 48px rgba(52, 39, 23, .10);
            backdrop-filter: blur(8px);
        }

        .gr-rsvp-copy h3 {
            font-size: clamp(1.8rem, 4vw, 3.2rem);
            line-height: 1.05;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .gr-form-card {
            padding: 28px;
            border-radius: 28px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(89, 71, 47, .12);
            box-shadow: 0 18px 48px rgba(52, 39, 23, .13);
            color: var(--gr-ink);
        }

        .gr-form-label {
            display: block;
            color: var(--gr-brown);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .gr-input {
            width: 100%;
            margin-top: 8px;
            border: 1px solid rgba(89, 71, 47, .18);
            background: rgba(255,255,255,.98);
            color: var(--gr-ink);
            border-radius: 12px;
            padding: 13px 14px;
            outline: none;
        }

        .gr-summary-grid {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .gr-summary-grid > div {
            padding: 18px 10px;
            text-align: center;
            border-radius: 22px;
            background: rgba(255,255,255,.62);
            border: 1px solid rgba(89, 71, 47, .12);
            box-shadow: 0 10px 28px rgba(52, 39, 23, .08);
        }

        .gr-summary-grid b {
            display: block;
            color: var(--gr-brown);
            font-size: 2rem;
            line-height: 1;
        }

        .gr-message-list {
            grid-column: 1 / -1;
            display: grid;
            gap: 12px;
            margin-top: 10px;
        }

        .gr-message-card {
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.66);
            border: 1px solid rgba(89, 71, 47, .12);
            box-shadow: 0 10px 28px rgba(52, 39, 23, .08);
        }

        /* CLOSING */
        .gr-closing {
            min-height: 840px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255,250,247,.92), rgba(255,247,239,.86)),
                url("{{ asset('assets/golden-romance/gr-gallery-haze-soft.png') }}") center / cover no-repeat,
                var(--gr-paper);
        }

        .gr-closing::before {
            opacity: .64;
            background:
                url("{{ asset('assets/golden-romance/gr-floral-top-vine.png') }}") center top / 92% auto no-repeat,
                url("{{ asset('assets/golden-romance/gr-floral-bottom-meadow.png') }}") center bottom / 108% auto no-repeat;
        }

        .gr-closing-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 60px 36px 120px;
            border-radius: 34px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), rgba(255,248,238,.70)),
                url("{{ asset('assets/golden-romance/gr-paper-texture-soft.png') }}") center / cover repeat;
            border: 1px solid rgba(89, 71, 47, .12);
            box-shadow: 0 26px 72px rgba(52, 39, 23, .14);
            backdrop-filter: blur(10px);
        }

        .gr-closing-photo {
            width: min(100%, 240px);
            aspect-ratio: 3 / 4;
            margin: 0 auto 28px;
            display: block;
            object-fit: cover;
            border-radius: 999px 999px 28px 28px;
            border: 8px solid rgba(255,255,255,.94);
            box-shadow: 0 20px 54px rgba(52, 39, 23, .18);
        }

        .gr-closing-card h2 {
            font-size: clamp(2rem, 5vw, 3.2rem);
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(32px);
            filter: blur(7px);
            transition:
                opacity .85s cubic-bezier(.2,.8,.2,1),
                transform .85s cubic-bezier(.2,.8,.2,1),
                filter .85s cubic-bezier(.2,.8,.2,1);
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

        @keyframes grShine {
            0%, 48% {
                left: -88%;
            }

            76%, 100% {
                left: 135%;
            }
        }

        @media (min-width: 1440px) {
            .gr-shell {
                width: min(100%, 1280px);
            }
        }

        @media (max-width: 980px) {
            .gr-shell {
                padding: 14px;
            }

            .gr-page {
                padding: 92px 36px;
            }

            .gr-hero {
                min-height: 860px;
                padding: 66px 36px 0;
            }

            .gr-hero-inner {
                padding-top: 38px;
                padding-bottom: 300px;
            }

            .gr-couple-grid {
                grid-template-columns: 1fr;
                gap: 52px;
            }

            .gr-person-card {
                min-height: auto;
            }

            .gr-rsvp-layout {
                grid-template-columns: 1fr;
            }

            .gr-gift-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .gr-shell {
                padding: 0;
            }

            .gr-book {
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                box-shadow: none;
            }

            .gr-page,
            .gr-page.slim {
                padding: 76px 22px;
            }

            .gr-floating-actions a,
            .gr-floating-actions button {
                width: 40px;
                height: 40px;
            }

            .gr-hero {
                min-height: 100svh;
                padding: 54px 22px 0;
            }

            .gr-hero::before {
                background:
                    url("{{ asset('assets/golden-romance/gr-palace-garden-foreground.png') }}") center bottom / 170% auto no-repeat;
            }

            .gr-hero-inner {
                padding-top: 28px;
                padding-bottom: 270px;
            }

            .gr-hero-title {
                width: min(100%, 420px);
                font-size: clamp(2.25rem, 10vw, 3.65rem);
                line-height: 1;
            }

            .gr-hero-name {
                line-height: 1;
            }

            .gr-hero-and {
                margin: 2px 0 4px;
                font-size: clamp(1.05rem, 5vw, 1.45rem);
                line-height: 1;
            }

            .gr-hero-photo {
                width: 170px;
                max-width: 62%;
                margin-top: 24px;
            }

            .gr-person-frame {
                width: min(100%, 300px);
            }

            .gr-person-frame::before {
                inset: -22px -28px;
            }

            .gr-person-script {
                font-size: clamp(2.3rem, 11vw, 3.7rem);
            }

            .gr-count-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .gr-count-card {
                border-radius: 14px;
                padding: 18px 10px;
            }

            .gr-event-card {
                width: min(100%, 340px);
                min-height: auto;
                margin-top: 26px;
                padding: 34px 20px 32px;
                background-size: cover;
            }

            .gr-event-card h3 {
                display: none;
            }

            .gr-event-actions,
            .gr-hero-actions {
                flex-direction: column;
                align-items: center;
            }

            .gr-event-actions .gr-btn,
            .gr-hero-actions .gr-btn {
                width: min(100%, 280px);
            }

            .gr-map-frame,
            .gr-map-placeholder {
                height: 310px;
                min-height: 310px;
            }

            .gr-map-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .gr-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-auto-rows: 132px;
            }

            .gr-gallery-item:nth-child(1),
            .gr-gallery-item:nth-child(n + 2) {
                grid-column: span 1;
                grid-row: span 1;
            }

            .gr-gallery-item:nth-child(1) {
                grid-column: span 2;
                grid-row: span 2;
            }

            .gr-summary-grid {
                grid-template-columns: 1fr;
            }

            .gr-rsvp-copy {
                padding: 28px 18px 24px;
            }

            .gr-rsvp-copy h3 {
                font-size: clamp(1.65rem, 8vw, 2.5rem);
                line-height: 1.02;
            }

            .gr-person-meta {
                margin-top: 12px;
            }

            .gr-person-subtitle {
                margin: 6px auto 8px;
                padding: 6px 14px;
                font-size: 9px;
            }

            .gr-person-family {
                width: min(100%, 280px);
                margin-top: 6px;
                padding-top: 12px;
                font-size: .84rem;
                line-height: 1.55;
            }

            .gr-person-family::before {
                width: 46px;
                margin-bottom: 10px;
            }

            .gr-count-title {
                width: min(100%, 300px);
                font-size: clamp(1.45rem, 7vw, 2.25rem);
                line-height: 1.12;
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
</head>

@php
    $grThemeKey = $invitation->theme_color ?: 'gold';

    $grThemes = [
        'maroon' => [
            'paper' => '#fbf1ee',
            'soft' => '#f1ded9',
            'ink' => '#4d2930',
            'brown' => '#663443',
            'deep' => '#35121d',
            'gold' => '#d7b96b',
            'rose' => '#b56d72',
        ],
        'emerald' => [
            'paper' => '#eef6ef',
            'soft' => '#dfeee2',
            'ink' => '#193f36',
            'brown' => '#164b40',
            'deep' => '#08241e',
            'gold' => '#d7bd72',
            'rose' => '#9fb8a4',
        ],
        'navy' => [
            'paper' => '#eef2f8',
            'soft' => '#dfe6f1',
            'ink' => '#1a304a',
            'brown' => '#17375d',
            'deep' => '#07172b',
            'gold' => '#d7bd72',
            'rose' => '#9aa7bf',
        ],
        'rose' => [
            'paper' => '#fff0ef',
            'soft' => '#f5dddd',
            'ink' => '#5a253c',
            'brown' => '#74324b',
            'deep' => '#35101e',
            'gold' => '#d7b96b',
            'rose' => '#c7858c',
        ],
        'gold' => [
            'paper' => '#fbf3df',
            'soft' => '#efe0bd',
            'ink' => '#4f3b1a',
            'brown' => '#725126',
            'deep' => '#2c1c08',
            'gold' => '#d8b65c',
            'rose' => '#b88969',
        ],
        'slate' => [
            'paper' => '#f0f2f4',
            'soft' => '#dde0e4',
            'ink' => '#292f37',
            'brown' => '#3f454d',
            'deep' => '#11151a',
            'gold' => '#d2b875',
            'rose' => '#9a9da3',
        ],
    ];

    $grTheme = $grThemes[$grThemeKey] ?? $grThemes['gold'];

    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'Alin & Aldi');
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'Alin');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Aldi');

    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/golden-romance/gr-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;

    $eventDateShort = $startDate ? $startDate->format('d . m . Y') : '30 . 11 . 2026';
    $eventDateText = $startDate ? $startDate->translatedFormat('l, d F Y') : 'Senin, 30 November 2026';
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

    $locationText = $invitation->location_name ?: 'Reception Hall';
    $addressText = $invitation->address ?: 'Bukit Tinggi Sekali, Wetan Ngalor. 12980';
    $descriptionText = $invitation->description ?: 'Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu.';

    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

    if (!$mapEmbedUrl && $mapOpenUrl && \Illuminate\Support\Str::contains($mapOpenUrl, 'google.com/maps')) {
        $mapEmbedUrl = $mapOpenUrl;
    }

    $shareUrl = route('invitation.public', $invitation->slug);
    $shareMessage = "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n" .
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

    $shareMessage .= "\nKlik link undangan berikut:\n{$shareUrl}\n\nTerima kasih.";
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
    --gr-paper: {{ $grTheme['paper'] }};
    --gr-soft: {{ $grTheme['soft'] }};
    --gr-ink: {{ $grTheme['ink'] }};
    --gr-brown: {{ $grTheme['brown'] }};
    --gr-deep: {{ $grTheme['deep'] }};
    --gr-gold: {{ $grTheme['gold'] }};
    --gr-rose: {{ $grTheme['rose'] }};
">
    <div class="gr-shell">
        <main class="gr-book" id="top">
            <div class="gr-floating-actions" aria-label="Aksi undangan">
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

            <section id="opening" class="gr-page gr-hero">
                <div class="gr-hero-inner" data-reveal="zoom">
                    <p class="gr-hero-kicker responsive-text">
                        {{ $invitation->event_name ?: 'The Wedding Of' }}
                    </p>

                    <h1 class="gr-title gr-script gr-hero-title responsive-text">
                        <span class="gr-hero-name">{{ $brideName }}</span>
                        <span class="gr-hero-and">&</span>
                        <span class="gr-hero-name">{{ $groomName }}</span>
                    </h1>

                    <p class="gr-hero-date responsive-text">{{ $eventDateShort }}</p>

                    <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="gr-hero-photo">

                    <div class="gr-hero-actions">
                        <a href="#couple" class="gr-btn gold">Buka Undangan</a>
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="gr-btn light">Simpan Tanggal</a>
                    </div>
                </div>
            </section>

            <section id="couple" class="gr-page gr-couple">
                <p class="gr-label" data-reveal="zoom">Bride & Groom</p>

                <h2 class="gr-title gr-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,5.4rem);">
                    Bride & Groom
                </h2>

                <p class="gr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    {{ $descriptionText }}
                </p>

                <div class="gr-couple-grid">
                    <article class="gr-person-card" data-reveal="left">
                        <div class="gr-person-frame">
                            <div class="gr-person-photo">
                                @if ($bridePhoto)
                                    <img src="{{ $bridePhoto }}" alt="{{ $brideName }}">
                                @else
                                    <div class="gr-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="gr-person-meta">
                            <h3 class="gr-title gr-script gr-person-script responsive-text">{{ $brideName }}</h3>
                            <div class="gr-person-subtitle responsive-text">{{ $brideSubtitle }}</div>

                            <p class="gr-person-family responsive-text">
                                {{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}
                            </p>

                            @if (!empty($bride->instagram))
                                <a href="{{ $bride->instagram }}" target="_blank" class="gr-btn gold gr-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>

                    <article class="gr-person-card" data-reveal="right">
                        <div class="gr-person-frame">
                            <div class="gr-person-photo">
                                @if ($groomPhoto)
                                    <img src="{{ $groomPhoto }}" alt="{{ $groomName }}">
                                @else
                                    <div class="gr-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="gr-person-meta">
                            <h3 class="gr-title gr-script gr-person-script responsive-text">{{ $groomName }}</h3>
                            <div class="gr-person-subtitle responsive-text">{{ $groomSubtitle }}</div>

                            <p class="gr-person-family responsive-text">
                                {{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}
                            </p>

                            @if (!empty($groom->instagram))
                                <a href="{{ $groom->instagram }}" target="_blank" class="gr-btn gold gr-instagram-btn">Instagram</a>
                            @endif
                        </div>
                    </article>
                </div>
            </section>

            <section id="moment" class="gr-page gr-moment">
                <p class="gr-label" data-reveal="zoom">Our Moment</p>

                <h2 class="gr-title gr-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.6rem,5vw,4.8rem);">
                    Moment Yang Berharga
                </h2>

                <p class="gr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                    “Menciptakan kenangan adalah hadiah yang tak ternilai harganya.
                    Kenangan akan bertahan seumur hidup; benda-benda hanya dalam waktu singkat.”
                </p>

                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="gr-moment-photo" data-reveal="zoom">
            </section>

            <section id="countdown" class="gr-page gr-save-date">
                <div class="gr-count-panel" data-reveal="zoom">
                    <h2 class="gr-title gr-script gr-count-title responsive-text">Acara Akan Diselenggarakan</h2>

                    <img src="{{ asset('assets/golden-romance/gr-vintage-key-gold.png') }}" alt="Save The Date" class="gr-key">

                    <div class="gr-count-grid" data-countdown="{{ $targetDateTime }}">
                        <div class="gr-count-card">
                            <span class="gr-count-number" data-days>0</span>
                            <span class="gr-count-label">Hari</span>
                        </div>

                        <div class="gr-count-card">
                            <span class="gr-count-number" data-hours>0</span>
                            <span class="gr-count-label">Jam</span>
                        </div>

                        <div class="gr-count-card">
                            <span class="gr-count-number" data-minutes>0</span>
                            <span class="gr-count-label">Menit</span>
                        </div>

                        <div class="gr-count-card">
                            <span class="gr-count-number" data-seconds>0</span>
                            <span class="gr-count-label">Detik</span>
                        </div>
                    </div>

                    <p class="gr-note responsive-text" style="margin-top:32px;">{{ $eventDateText }}</p>

                    <div class="gr-count-actions">
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="gr-btn">Simpan acara ke kalender</a>
                    </div>
                </div>
            </section>

            <section id="acara" class="gr-page gr-event">
                <p class="gr-label" data-reveal="zoom">Detail Acara</p>

                <h2 class="gr-title gr-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.7rem,5vw,4.8rem);">
                    Acara Pernikahan
                </h2>

                <article class="gr-event-card" data-reveal="zoom">

                    <div class="gr-event-date-list">
                        <div class="gr-event-date-item">
                            <span>Tanggal</span>
                            <strong>{{ $eventStartShortText }}</strong>
                        </div>

                        @if ($hasDifferentEndDate)
                            <div class="gr-event-date-until">Sampai</div>

                            <div class="gr-event-date-item">
                                <strong>{{ $eventEndShortText }}</strong>
                            </div>
                        @endif
                    </div>

                    @if ($eventTimeText)
                        <p class="gr-event-line responsive-text">
                            Pukul {{ $eventTimeText }}
                        </p>
                    @endif

                    <p class="gr-event-place responsive-text">{{ $locationText }}</p>
                    <p class="gr-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                    <div class="gr-event-actions">
                        @if ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="gr-btn gold">Lihat Lokasi</a>
                        @endif

                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="gr-btn light">Calendar</a>
                    </div>
                </article>

                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="gr-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe
                                class="gr-map-frame"
                                src="{{ $mapEmbedUrl }}"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="gr-map-placeholder">
                                <div>
                                    <div style="font-size:3rem">⌖</div>
                                    <strong>{{ $locationText }}</strong>
                                </div>
                            </a>
                        @endif

                        <div class="gr-map-footer">
                            <div>
                                <p class="gr-map-title responsive-text">{{ $locationText }}</p>
                                <p class="gr-map-address responsive-text">{{ $addressText }}</p>
                            </div>

                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="gr-btn gold">Buka Maps</a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            @if ($gifts->count())
                <section id="gift" class="gr-page gr-gift slim">
                    <p class="gr-label" data-reveal="zoom">Wedding Gift</p>

                    <h2 class="gr-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.2rem);text-transform:uppercase;">
                        Wedding Gift
                    </h2>

                    <p class="gr-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">
                        Doa restu Anda merupakan karunia yang sangat berarti bagi kami.
                        Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.
                    </p>

                    <div class="gr-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $gift)
                            <div class="gr-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                                <div class="gr-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                                <div class="gr-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>

                                <p class="responsive-text" style="margin:12px 0 0;color:rgba(67,57,43,.72);">
                                    {{ $gift->account_name ?? $eventTitle }}
                                </p>

                                <button type="button" class="gr-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">
                                    Salin Nomor
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($galleryPhotos->count())
                <section id="galeri" class="gr-page gr-gallery">
                    <p class="gr-label" data-reveal="zoom">Gallery</p>

                    <h2 class="gr-title gr-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,5rem);">
                        Our Gallery
                    </h2>

                    <div class="gr-gallery-grid">
                        @foreach ($galleryPhotos as $photo)
                            @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp

                            @if ($src)
                                <a
                                    href="{{ $src }}"
                                    target="_blank"
                                    class="gr-gallery-item"
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

            <section id="rsvp" class="gr-page gr-rsvp slim">
                <p class="gr-label" data-reveal="zoom">RSVP</p>

                <h2 class="gr-title responsive-text" data-reveal="zoom" style="font-size:clamp(2rem,5vw,3.4rem);text-transform:uppercase;">
                    RSVP Form
                </h2>

                <div class="gr-rsvp-layout">
                    <div class="gr-rsvp-copy" data-reveal="left">
                        <h3 class="gr-title gr-script responsive-text">Kehadiran Anda</h3>

                        <p class="gr-note responsive-text" style="margin-left:0;">
                            Kami tidak sabar menunggu hari pernikahan kami bersama Anda.
                            Mohon konfirmasi kehadiran melalui form RSVP di bawah ini.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="gr-form-card space-y-4" data-reveal="right">
                        @csrf

                        <div>
                            <label class="gr-form-label">Nama</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="gr-input" placeholder="Nama lengkap" required>
                        </div>

                        <div>
                            <label class="gr-form-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="gr-input">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="gr-form-label">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="gr-input">
                        </div>

                        <div>
                            <label class="gr-form-label">Pesan</label>
                            <textarea name="message" rows="4" class="gr-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="gr-btn" style="width:100%;">Kirim</button>
                    </form>

                    <div class="gr-summary-grid" data-reveal="zoom">
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

                    <div class="gr-message-list">
                        @forelse ($messages->take(5) as $message)
                            <div class="gr-message-card" data-reveal="zoom">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="responsive-text font-black" style="color:var(--gr-brown);">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs mt-1" style="color:rgba(67,57,43,.58)">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(89,71,47,.10);color:var(--gr-brown);">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-3" style="color:rgba(67,57,43,.78);line-height:1.8;">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @empty
                            <div class="gr-message-card text-center" style="color:rgba(67,57,43,.66);">
                                Belum ada ucapan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="gr-page gr-closing">
                <div class="gr-closing-card" data-reveal="zoom">
                    <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="gr-closing-photo">

                    <h2 class="gr-title responsive-text" style="font-size:clamp(2rem,5vw,3.2rem);">
                        Terima Kasih
                    </h2>

                    <p class="gr-note responsive-text">
                        Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i
                        berkenan hadir dan memberikan doa restu kepada kami.
                    </p>

                    <h3 class="gr-title gr-script responsive-text" style="margin-top:22px;font-size:clamp(2.5rem,6vw,4.8rem);">
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
