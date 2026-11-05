<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Classic Letter'));
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
            color: var(--wl-ink);
            background:
                radial-gradient(circle at 10% 8%, var(--wl-glow), transparent 32%),
                radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--wl-charcoal) 13%, transparent), transparent 30%),
                radial-gradient(circle at 50% 88%, color-mix(in srgb, var(--wl-gold) 10%, transparent), transparent 36%),
                linear-gradient(180deg, var(--wl-bg1) 0%, var(--wl-bg2) 42%, var(--wl-bg3) 100%);
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

        .wl-shell {
            width: min(100%, 1180px);
            margin: 0 auto;
            padding: 24px;
        }

        .wl-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 34px;
            isolation: isolate;
            background:
                linear-gradient(180deg, rgba(255,255,255,.88), color-mix(in srgb, var(--wl-soft) 82%, transparent)),
                url("{{ asset('assets/wedding-classic-letter/classic-letter-paper-texture.png') }}") center/cover repeat,
                linear-gradient(180deg, var(--wl-bg2) 0%, var(--wl-soft) 52%, var(--wl-bg3) 100%);
            border: 1px solid color-mix(in srgb, var(--wl-charcoal) 18%, transparent);
            box-shadow: 0 40px 130px color-mix(in srgb, var(--wl-charcoal) 22%, transparent);
        }

        .wl-book::before,
        .wl-book::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .wl-book::before {
            opacity: .56;
            background:
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-left.png') }}") left 8%/330px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-right.png') }}") right 6%/360px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-right.png') }}") right 58%/360px auto no-repeat,
                linear-gradient(90deg, rgba(52,58,64,.035) 1px, transparent 1px) 0 0/46px 46px,
                linear-gradient(0deg, rgba(52,58,64,.028) 1px, transparent 1px) 0 0/46px 46px;
        }

        .wl-book::after {
            opacity: .42;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.85), transparent 34%),
                radial-gradient(circle at 84% 28%, rgba(171,145,77,.12), transparent 24%),
                radial-gradient(circle at 18% 72%, rgba(118,125,132,.12), transparent 28%);
        }

        .wl-book > * { position: relative; z-index: 2; }

        .wl-floating-actions {
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
            border: 1px solid rgba(52,58,64,.14);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(23,28,33,.13);
            backdrop-filter: blur(14px);
        }
        .wl-floating-actions a,
        .wl-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(23,28,33,.10);
            transition: transform .25s ease, background .25s ease;
        }
        .wl-floating-actions a:hover,
        .wl-floating-actions button:hover { transform: translateX(-3px); }
        .wl-floating-actions button.is-active { background: color-mix(in srgb, var(--wl-gold) 18%, white); }
        .wl-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .wl-page {
            position: relative;
            min-height: auto;
            padding: 108px 74px;
            overflow: hidden;
            text-align: center;
        }
        .wl-page > * { position: relative; z-index: 5; }
        .wl-page.slim { padding-top: 86px; padding-bottom: 86px; }

        .wl-page::before,
        .wl-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .wl-page::before {
            z-index: 1;
            opacity: .26;
            background:
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-top.png') }}") right top/470px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-bottom.png') }}") left bottom/470px auto no-repeat;
        }
        .wl-page::after {
            z-index: 2;
            opacity: .18;
            background: linear-gradient(180deg, transparent, rgba(255,255,255,.58), transparent);
        }

        .wl-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--wl-charcoal);
            background: rgba(255,255,255,.82);
            border: 1px solid rgba(55,61,66,.14);
            box-shadow: 0 12px 28px rgba(35,40,45,.06);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .wl-label::before,
        .wl-label::after { content: ""; width: 28px; height: 1px; background: var(--wl-charcoal); opacity: .46; }

        .wl-title {
            margin: 0;
            color: var(--wl-charcoal);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.035em;
            line-height: .96;
            text-wrap: balance;
        }
        .wl-script { font-family: Georgia, "Times New Roman", serif; font-style: italic; font-weight: 400; }
        .wl-note { max-width: 680px; margin: 20px auto 0; color: #63666a; line-height: 1.9; }

        .wl-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 26px;
            border-radius: 6px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, var(--wl-charcoal), #4e555b);
            box-shadow: 0 16px 34px rgba(35,40,45,.20);
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .wl-btn:hover { transform: translateY(-2px); }
        .wl-btn.light { color: var(--wl-charcoal); background: rgba(255,255,255,.88); border: 1px solid rgba(55,61,66,.18); }
        .wl-btn.gold { color: #fff; background: linear-gradient(135deg, var(--wl-gold), #9f873d); }
        .wl-btn::after,
        .wl-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: wlShine 4.2s ease-in-out infinite;
        }

        /* HERO: classic white letter with silk wave */
        .wl-hero {
            min-height: 900px;
            padding: 92px 72px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.70), rgba(246,247,246,.64)),
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.94), rgba(255,255,255,.20) 44%, transparent 70%);
        }
        .wl-hero::before {
            opacity: .76;
            background:
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-top.png') }}") center top/100% auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-left.png') }}") left 10%/470px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-right.png') }}") right 58%/500px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-bottom.png') }}") center bottom/110% auto no-repeat;
        }
        .wl-hero::after {
            opacity: .58;
            background:
                linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,.46), rgba(238,240,239,.20)),
                url("{{ asset('assets/wedding-classic-letter/classic-letter-haze-soft.png') }}") center/cover no-repeat;
        }
        .wl-hero-inner { width: min(100%, 680px); margin: 0 auto; padding: 180px 0 220px; }
        .wl-hero-rings {
            width: 78px;
            height: 78px;
            margin: 0 auto 24px;
            background: url("{{ asset('assets/wedding-classic-letter/classic-letter-rings-icon.png') }}") center/contain no-repeat;
            opacity: .9;
            filter: drop-shadow(0 10px 22px rgba(35,40,45,.12));
        }
        .wl-hero-kicker { color: var(--wl-charcoal); font-size: 12px; font-weight: 950; letter-spacing: .20em; text-transform: uppercase; }
        .wl-hero-title {
            margin: 24px auto 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: clamp(3.6rem, 8vw, 7.6rem);
            color: var(--wl-charcoal);
            line-height: .86;
            text-align: center;
        }

        .wl-hero-name {
            display: block;
            margin: 0;
            line-height: .86;
        }

        .wl-hero-and {
            display: block;
            margin: 0 auto;
            color: var(--wl-gold);
            font-size: clamp(1.8rem, 3.2vw, 2.6rem);
            line-height: .8;
        }
        .wl-hero-date { margin-top: 28px; color: #343a40; font-size: 1.04rem; letter-spacing: .24em; font-weight: 850; }
        .wl-hero-actions { margin-top: 34px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        /* Couple */
        .wl-couple { background: linear-gradient(180deg, rgba(255,255,255,.72), rgba(245,246,245,.68)); }
        .wl-couple-stage {
            width: min(100%, 920px);
            margin: 50px auto 0;
            display: grid;
            gap: 42px;
        }
        .wl-person-card {
            position: relative;
            width: min(100%, 720px);
            margin: 0 auto;
            padding: 44px 34px 50px;
            border-radius: 44px;
            background: linear-gradient(145deg, rgba(255,255,255,.92), rgba(246,247,247,.70));
            border: 1px solid rgba(55,61,66,.12);
            box-shadow: 0 28px 80px rgba(35,40,45,.12);
            display: grid;
            place-items: center;
            text-align: center;
            overflow: hidden;
        }
        .wl-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .32;
            background:
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-left.png') }}") left top/280px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-right.png') }}") right bottom/300px auto no-repeat;
        }
        .wl-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: 270px;
            max-width: 100%;
            margin: 0 auto;
            padding: 8px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid rgba(55,61,66,.12);
            box-shadow: 0 22px 56px rgba(35,40,45,.14);
        }
        .wl-person-photo-wrap img,
        .wl-person-initial {
            width: 100%;
            aspect-ratio: 1/1;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px;
            background: #eef0f0;
            color: var(--wl-gold);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
        }
        .wl-person-content { position: relative; z-index: 2; margin-top: 28px; }
        .wl-person-subtitle {
            width: fit-content;
            max-width: 100%;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--wl-gold);
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(171,145,77,.22);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }
        .wl-person-name { margin: 10px 0 0; color: var(--wl-gold); font-family: Georgia,"Times New Roman",serif; font-size: clamp(1.9rem, 4vw, 3.2rem); line-height: 1.08; }
        .wl-person-line { width: 220px; max-width: 70%; height: 1px; margin: 24px auto 0; background: var(--wl-charcoal); opacity: .48; }
        .wl-person-family { max-width: 440px; margin: 20px auto 0; color: #565b60; line-height: 1.82; }
        .wl-couple-symbol {
            width: 86px;
            height: 86px;
            margin: -8px auto;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: var(--wl-charcoal);
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(55,61,66,.14);
            box-shadow: 0 20px 52px rgba(35,40,45,.12);
            font-family: Georgia,"Times New Roman",serif;
            font-style: italic;
            font-size: 3.2rem;
            z-index: 4;
        }

        .wl-invitation-card {
            width: min(100%, 860px);
            margin: 0 auto;
            padding: 54px 48px;
            border-radius: 42px;
            background: linear-gradient(145deg, rgba(255,255,255,.88), rgba(246,247,247,.70));
            border: 1px solid rgba(55,61,66,.12);
            box-shadow: 0 28px 84px rgba(35,40,45,.10);
        }
        .wl-invitation-card h2 { font-size: clamp(2.6rem, 6vw, 5.8rem); }

        /* Event */
        .wl-event-section::before {
            opacity: .38;
            background:
                url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-top.png') }}") center top/100% auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-left.png') }}") left center/330px auto no-repeat,
                url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-right.png') }}") right bottom/380px auto no-repeat;
        }
        .wl-event-layout {
            width: min(100%, 960px);
            margin: 46px auto 0;
            display: grid;
            gap: 28px;
        }

        .wl-event-layout-single {
            grid-template-columns: minmax(0, 640px);
            justify-content: center;
        }

        .wl-event-layout-single .wl-event-card {
            width: 100%;
            margin: 0 auto;
        }

        .wl-event-card {
            position: relative;
            overflow: hidden;
            width: min(100%, 640px);
            margin: 0 auto;
            padding: 50px 38px;
            border-radius: 38px;
            background: linear-gradient(145deg, rgba(255,255,255,.92), rgba(246,247,247,.72));
            border: 1px solid rgba(55,61,66,.13);
            box-shadow: 0 28px 82px rgba(35,40,45,.12);
            text-align: center;
        }
        .wl-event-card::before {
            content: "";
            position: absolute;
            inset: auto -18px -86px -18px;
            height: 210px;
            opacity: .24;
            background: url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-bottom.png') }}") center bottom/100% auto no-repeat;
            pointer-events: none;
        }
        .wl-event-icon { width: 72px; height: 72px; margin: 0 auto 18px; background-position:center; background-size:contain; background-repeat:no-repeat; opacity:.9; }
        .wl-icon-rings { background-image: url("{{ asset('assets/wedding-classic-letter/classic-letter-rings-icon.png') }}"); }
        .wl-icon-cheers { background-image: url("{{ asset('assets/wedding-classic-letter/classic-letter-cheers-icon.png') }}"); }
        .wl-event-card h3 { position: relative; z-index:2; color: var(--wl-gold); font-size: clamp(2.1rem, 5vw, 3.8rem); }
        .wl-date-split { position: relative; z-index:2; margin: 28px auto 24px; display: grid; grid-template-columns: 1fr auto 1fr; gap: 18px; align-items: center; width: min(100%, 420px); }
        .wl-date-side { color: #454b50; font-family: Georgia,"Times New Roman",serif; font-size: 1.1rem; }
        .wl-date-center { padding: 0 24px; border-left: 1px solid rgba(52,58,64,.34); border-right: 1px solid rgba(52,58,64,.34); }
        .wl-date-center b { display: block; color: var(--wl-gold); font-family: Georgia,"Times New Roman",serif; font-size: clamp(3rem, 7vw, 5rem); line-height: .9; }
        .wl-date-center span { display: block; margin-top: 10px; color: #4d5257; font-weight: 700; }
        .wl-date-stack {
            position: relative;
            z-index: 2;
            width: min(100%, 460px);
            margin: 28px auto 24px;
            display: grid;
            gap: 14px;
        }

        .wl-date-split {
            margin: 0 auto;
        }

        .wl-date-until {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin: 2px auto;
            color: var(--wl-gold);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .wl-date-until::before,
        .wl-date-until::after {
            content: "";
            width: 48px;
            height: 1px;
            background: var(--wl-gold);
            opacity: .48;
        }

        .wl-date-range-final {
            position: relative;
            z-index: 2;
            margin: 20px auto 0;
            color: #4d5257;
            font-size: .92rem;
            font-weight: 900;
            letter-spacing: .12em;
            line-height: 1.7;
        }
        .wl-event-line { position: relative; z-index:2; margin-top: 18px; color: #4d5257; line-height: 1.85; font-weight: 800; letter-spacing: .06em; }
        .wl-event-place { position: relative; z-index:2; margin-top: 28px; color: #2f3438; font-weight: 950; }
        .wl-event-address { position: relative; z-index:2; margin-top: 10px; color: #5d6266; line-height: 1.78; }
        .wl-event-actions { position: relative; z-index:2; margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .wl-map-card {
            width: min(100%, 760px);
            margin: 34px auto 0;
            border-radius: 34px;
            background: linear-gradient(145deg, rgba(255,255,255,.92), rgba(246,247,247,.74));
            border: 1px solid rgba(55,61,66,.13);
            box-shadow: 0 22px 68px rgba(35,40,45,.10);
            overflow: hidden;
        }
        .wl-map-frame,
        .wl-map-placeholder { width: 100%; height: 360px; min-height: 360px; border: 0; display: block; }
        .wl-map-placeholder { display: flex; align-items: center; justify-content: center; text-align: center; text-decoration: none; color: inherit; padding: 32px; background: linear-gradient(135deg, rgba(52,58,64,.12), rgba(171,145,77,.10)), #edf0ef; }
        .wl-map-pin { width: 68px; height: 68px; margin: 0 auto 16px; border-radius: 999px; display: grid; place-items: center; background: var(--wl-charcoal); color: #fff; font-size: 2rem; box-shadow: 0 18px 40px rgba(35,40,45,.20); }
        .wl-map-footer { padding: 20px 24px; display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; background: rgba(255,255,255,.90); border-top: 1px solid rgba(55,61,66,.12); text-align:left; }
        .wl-map-title { margin: 0; color: #2f3438; font-weight: 950; }
        .wl-map-address { margin: 7px 0 0; color: #5d6266; line-height: 1.65; white-space: pre-line; overflow-wrap: anywhere; }

        /* Gallery */
        .wl-gallery-grid {
            width: min(100%, 980px);
            margin: 44px auto 0;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: 108px;
            gap: 12px;
        }
        .wl-gallery-item { display: block; overflow: hidden; padding: 6px; background: rgba(255,255,255,.88); border: 1px solid rgba(55,61,66,.13); box-shadow: 0 14px 34px rgba(35,40,45,.08); border-radius: 32px; }
        .wl-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; border-radius: 999px 999px 28px 28px; }
        .wl-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; }
        .wl-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; border-radius: 999px; }
        .wl-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }
        .wl-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit; transition: transform .7s ease; }
        .wl-gallery-item:hover img { transform: scale(1.055); }

        /* Gift */
        .wl-gift-grid { width: min(100%, 880px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .wl-gift-grid.is-single { grid-template-columns: minmax(0, 450px); justify-content: center; }
        .wl-gift-card {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            padding: 32px 28px;
            border-radius: 30px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255,255,255,.90), rgba(246,247,247,.74));
            border: 1px solid rgba(55,61,66,.13);
            box-shadow: 0 18px 48px rgba(35,40,45,.09);
        }
        .wl-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: color-mix(in srgb, var(--wl-gold) 14%, transparent); transform: skewY(-7deg); }
        .wl-gift-title,.wl-gift-number,.wl-copy-btn { position: relative; z-index: 2; }
        .wl-gift-title { color: var(--wl-gold); font-weight: 950; font-size: 1.2rem; }
        .wl-gift-number { margin-top: 18px; color: #2f3438; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.3rem); }
        .wl-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 6px; padding: 12px 18px; color: #fff; background: var(--wl-charcoal); font-weight: 950; cursor: pointer; letter-spacing:.06em; text-transform:uppercase; }
        .wl-copy-btn.copied { background: #16803c; }

        /* RSVP */
        .wl-rsvp-layout { width: min(100%, 1040px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .wl-rsvp-copy { padding: 42px 34px; border-radius: 34px; background: linear-gradient(145deg, rgba(255,255,255,.84), rgba(246,247,247,.66)); border: 1px solid rgba(55,61,66,.13); box-shadow: 0 18px 48px rgba(35,40,45,.08); }
        .wl-rsvp-copy h3 { font-size: clamp(2.2rem, 4vw, 4rem); }
        .wl-form-card { padding: 26px; border-radius: 26px; background: rgba(255,255,255,.88); border: 1px solid rgba(55,61,66,.13); box-shadow: 0 18px 48px rgba(35,40,45,.08); text-align: left; }
        .wl-form-label { display: block; color: var(--wl-charcoal); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .wl-input { width: 100%; margin-top: 8px; border: 1px solid rgba(55,61,66,.14); background: rgba(255,255,255,.96); color: var(--wl-ink); border-radius: 12px; padding: 13px 14px; outline: none; text-align: left; }
        .wl-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .wl-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 20px; background: rgba(255,255,255,.78); border: 1px solid rgba(55,61,66,.12); }
        .wl-summary-grid b { display: block; color: var(--wl-gold); font-size: 2rem; line-height: 1; }
        .wl-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .wl-message-card { padding: 18px; border-radius: 22px; background: rgba(255,255,255,.84); border: 1px solid rgba(55,61,66,.12); box-shadow: 0 10px 24px rgba(35,40,45,.06); }

        .wl-closing-card { width: min(100%, 720px); margin: 0 auto; padding: 80px 34px 220px; text-align: center; }
        .wl-closing-card h2 { font-size: clamp(3rem, 7vw, 6.5rem); }
        .wl-closing-photo { width: 210px; height: 210px; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px; border: 8px solid #fff; outline: 1px solid rgba(55,61,66,.18); box-shadow: 0 20px 52px rgba(35,40,45,.14); }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes wlShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes wlFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .wl-floating-actions a, .wl-floating-actions button { animation: wlFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1440px) {
            .wl-shell { width: min(100%, 1280px); }
            .wl-page { padding-left: 90px; padding-right: 90px; }
            .wl-hero-title { font-size: clamp(5rem, 7vw, 8.4rem); }
        }

        @media (max-width: 980px) {
            .wl-shell { padding: 14px; }
            .wl-page { padding: 90px 38px; }
            .wl-hero { min-height: 820px; padding: 86px 38px 0; }
            .wl-hero::before {
                background-size: 120% auto, 390px auto, 420px auto, 130% auto;
                background-position: center top, left 10%, right 58%, center bottom;
            }
            .wl-hero-inner { padding-top: 150px; padding-bottom: 200px; }
            .wl-rsvp-layout { grid-template-columns: 1fr; text-align: center; }
            .wl-gift-grid { grid-template-columns: 1fr; }
            .wl-gallery-grid { grid-template-columns: repeat(6, 1fr); }
            .wl-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .wl-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .wl-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .wl-shell { padding: 0; }
            .wl-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .wl-page, .wl-page.slim { padding: 76px 22px; }
            .wl-floating-actions { right: 0; gap: 7px; }
            .wl-floating-actions a, .wl-floating-actions button { width: 40px; height: 40px; }
            .wl-hero { min-height: 100svh; padding: 72px 22px 0; }
            .wl-hero::before {
                opacity: .70;
                background:
                    url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-top.png') }}") center top/132% auto no-repeat,
                    url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-left.png') }}") left 10%/270px auto no-repeat,
                    url("{{ asset('assets/wedding-classic-letter/classic-letter-silk-right.png') }}") right 62%/280px auto no-repeat,
                    url("{{ asset('assets/wedding-classic-letter/classic-letter-wave-bottom.png') }}") center bottom/160% auto no-repeat;
            }
            .wl-hero::after { opacity: .64; }
            .wl-hero-inner { padding-top: 124px; padding-bottom: 200px; }
            .wl-hero-title {
                font-size: clamp(3.2rem, 14vw, 5.1rem);
                gap: 2px;
                line-height: .88;
            }

            .wl-hero-name {
                line-height: .88;
            }

            .wl-hero-and {
                font-size: clamp(1.7rem, 7vw, 2.2rem);
            }
            .wl-hero-actions { flex-direction: column; }
            .wl-hero-actions .wl-btn { width: 100%; }
            .wl-label { font-size: 10px; letter-spacing: .14em; }
            .wl-label::before, .wl-label::after { width: 18px; }
            .wl-person-card { padding: 34px 20px; border-radius: 32px; }
            .wl-person-photo-wrap { width: 200px; }
            .wl-date-split { grid-template-columns: 1fr; gap: 14px; }
            .wl-date-center { border-left: 0; border-right: 0; border-top: 1px solid rgba(52,58,64,.25); border-bottom: 1px solid rgba(52,58,64,.25); padding: 18px 0; }
            .wl-map-frame, .wl-map-placeholder { height: 320px; min-height: 320px; }
            .wl-map-footer { flex-direction: column; align-items: stretch; }
            .wl-map-footer .wl-btn { width: 100%; }
            .wl-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .wl-gallery-item, .wl-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: 270px; }
            .wl-rsvp-layout { gap: 22px; }
            .wl-rsvp-copy, .wl-form-card { padding: 26px 20px; border-radius: 28px; }
            .wl-summary-grid { grid-template-columns: 1fr; }
            .wl-btn { width: 100%; }

            .wl-event-layout-single {
                grid-template-columns: 1fr;
            }

            .wl-event-card {
                width: 100%;
                padding: 38px 20px;
                border-radius: 30px;
            }

            .wl-event-card h3 {
                font-size: clamp(2.2rem, 12vw, 3.4rem);
            }

            .wl-event-icon {
                width: 56px;
                height: 56px;
                margin-bottom: 14px;
            }

            .wl-event-actions {
                flex-direction: column;
            }

            .wl-event-actions .wl-btn {
                width: 100%;
            }

            .wl-date-stack {
                width: 100%;
                gap: 16px;
            }

            .wl-date-until::before,
            .wl-date-until::after {
                width: 34px;
            }

            .wl-date-range-final {
                font-size: .82rem;
                letter-spacing: .08em;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        /* =====================================================
        THEME COLOR ENHANCEMENT
        Supaya 6 tema terlihat beda
        ===================================================== */

        .wl-page {
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.58), transparent 34%),
                linear-gradient(180deg, color-mix(in srgb, var(--wl-bg2) 88%, transparent), color-mix(in srgb, var(--wl-soft) 82%, transparent));
        }

        .wl-hero {
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.94), rgba(255,255,255,.24) 46%, transparent 72%),
                linear-gradient(180deg, color-mix(in srgb, var(--wl-bg2) 90%, transparent), color-mix(in srgb, var(--wl-soft) 84%, transparent)) !important;
        }

        .wl-person-card,
        .wl-invitation-card,
        .wl-event-card,
        .wl-map-card,
        .wl-gift-card,
        .wl-rsvp-copy,
        .wl-form-card,
        .wl-message-card {
            border-color: color-mix(in srgb, var(--wl-charcoal) 16%, transparent) !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.90), color-mix(in srgb, var(--wl-soft) 72%, rgba(255,255,255,.46))) !important;
            box-shadow: 0 24px 70px color-mix(in srgb, var(--wl-charcoal) 13%, transparent) !important;
        }

        .wl-label {
            color: var(--wl-charcoal) !important;
            border-color: color-mix(in srgb, var(--wl-gold) 28%, transparent) !important;
            background: color-mix(in srgb, var(--wl-soft) 72%, rgba(255,255,255,.86)) !important;
        }

        .wl-btn {
            background: linear-gradient(135deg, var(--wl-charcoal), color-mix(in srgb, var(--wl-charcoal) 72%, #ffffff)) !important;
        }

        .wl-btn.gold,
        .wl-copy-btn {
            background: linear-gradient(135deg, var(--wl-gold), color-mix(in srgb, var(--wl-gold) 74%, var(--wl-charcoal))) !important;
        }

        .wl-btn.light {
            color: var(--wl-charcoal) !important;
            background: color-mix(in srgb, var(--wl-soft) 80%, #ffffff) !important;
            border-color: color-mix(in srgb, var(--wl-charcoal) 18%, transparent) !important;
        }

        body {
            -webkit-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }

        input,
        textarea,
        select {
            -webkit-user-select: text;
            user-select: text;
        }
    </style>

    @php
        $themeColor = $invitation->theme_color ?? 'gold';
        if ($themeColor === 'golden') { $themeColor = 'gold'; }

        $wlThemes = [
            'gold' => [
                'charcoal'=>'#3d4247',
                'gold'=>'#aa8f42',
                'ink'=>'#2d3034',
                'soft'=>'#f7f7f4',
                'bg1'=>'#f4f1e8',
                'bg2'=>'#ffffff',
                'bg3'=>'#e7e4dc',
                'glow'=>'rgba(170,143,66,.18)',
            ],
            'slate' => [
                'charcoal'=>'#364047',
                'gold'=>'#87909a',
                'ink'=>'#24292e',
                'soft'=>'#f7f9fa',
                'bg1'=>'#e8ecef',
                'bg2'=>'#ffffff',
                'bg3'=>'#dfe4e8',
                'glow'=>'rgba(54,64,71,.16)',
            ],
            'navy' => [
                'charcoal'=>'#27364f',
                'gold'=>'#b5964d',
                'ink'=>'#1e293b',
                'soft'=>'#f4f7fb',
                'bg1'=>'#e8eef7',
                'bg2'=>'#ffffff',
                'bg3'=>'#dce5f0',
                'glow'=>'rgba(39,54,79,.17)',
            ],
            'maroon' => [
                'charcoal'=>'#5a2d39',
                'gold'=>'#c1974d',
                'ink'=>'#3e242c',
                'soft'=>'#fff6f7',
                'bg1'=>'#f4e6e8',
                'bg2'=>'#fffafa',
                'bg3'=>'#ead7dc',
                'glow'=>'rgba(90,45,57,.16)',
            ],
            'rose' => [
                'charcoal'=>'#74435a',
                'gold'=>'#bd8d60',
                'ink'=>'#442c34',
                'soft'=>'#fff7fa',
                'bg1'=>'#f7e7ee',
                'bg2'=>'#ffffff',
                'bg3'=>'#efd8e3',
                'glow'=>'rgba(116,67,90,.16)',
            ],
            'emerald' => [
                'charcoal'=>'#2f5947',
                'gold'=>'#b3954f',
                'ink'=>'#243a30',
                'soft'=>'#f4faf6',
                'bg1'=>'#e5f0e9',
                'bg2'=>'#ffffff',
                'bg3'=>'#d9e9df',
                'glow'=>'rgba(47,89,71,.17)',
            ],
        ];
        $wlTheme = $wlThemes[$themeColor] ?? $wlThemes['gold'];

        $photos = ($invitation->photos ?? collect())->values();
        $firstPhoto = $photos->first();
        $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
        $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;
        $people = ($invitation->people ?? collect())->values();
        $gifts = $invitation->gifts ?? collect();
        $messages = $invitation->messages ?? collect();

        $eventTitle = $invitation->title ?: 'Theodorus & Felicia';
        $eventName = $invitation->event_name ?: 'Pernikahan';
        $hostName = $invitation->host_name ?: 'Keluarga Besar';

        $bride = $people->get(0);
        $groom = $people->get(1);

        $titleParts = str_contains($eventTitle, '&')
            ? array_map('trim', explode('&', $eventTitle, 2))
            : [];

        $groomName = $groom->name ?? ($titleParts[0] ?? 'Theodorus Ferry Setiawan');
        $brideName = $bride->name ?? ($titleParts[1] ?? 'Felicia Gracia');
        $groomSubtitle = $groom->subtitle ?? 'Mempelai Pria';
        $brideSubtitle = $bride->subtitle ?? 'Mempelai Wanita';

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

        if ($startDate && $endDate && !$startDate->isSameDay($endDate)) {
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
        $defaultCover = asset('assets/wedding-classic-letter/classic-letter-couple-placeholder.png');
        $coverDisplay = $coverPhoto ?: $defaultCover;
        $groomPhoto = $personPhotoUrl($groom, $coverDisplay);
        $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
        $momentPhotoUrl = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
        $closingPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;
    @endphp
</head>

<body style="
    --wl-charcoal: {{ $wlTheme['charcoal'] }};
    --wl-gold: {{ $wlTheme['gold'] }};
    --wl-ink: {{ $wlTheme['ink'] }};
    --wl-soft: {{ $wlTheme['soft'] }};
    --wl-bg1: {{ $wlTheme['bg1'] }};
    --wl-bg2: {{ $wlTheme['bg2'] }};
    --wl-bg3: {{ $wlTheme['bg3'] }};
    --wl-glow: {{ $wlTheme['glow'] }};
">
    <div class="wl-floating-actions">
        <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan"></a>
        <button type="button" id="music-toggle" title="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music"></button>
        <button type="button" id="scroll-toggle" title="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll"></button>
        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi"></a>@endif
    </div>

    <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}" preload="auto" loop></audio>

    <main class="wl-shell">
        <div class="wl-book">
            <section id="cover" class="wl-page wl-hero">
                <div class="wl-hero-inner" data-reveal="zoom">
                    <div class="wl-hero-rings"></div>
                    <div class="wl-hero-kicker">{{ $eventName }}</div>
                    <h1 class="wl-title wl-hero-title">
                        <span class="wl-hero-name responsive-text">{{ $brideName }}</span>
                        <span class="wl-script wl-hero-and">&</span>
                        <span class="wl-hero-name responsive-text">{{ $groomName }}</span>
                    </h1>
                    <div class="wl-hero-date responsive-text">{{ $eventDateShort }}</div>
                    <div class="wl-hero-actions">
                        <a href="#mempelai" class="wl-btn gold">Buka Undangan</a>
                        @if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="wl-btn light">Simpan Tanggal</a>@endif
                    </div>
                </div>
            </section>

            <section id="mempelai" class="wl-page wl-couple">
                <p class="wl-label" data-reveal="zoom">Bride & Groom</p>
                <h2 class="wl-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6rem);">Mempelai</h2>
                <p class="wl-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Atas puji Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan acara pernikahan kami.</p>

                <div class="wl-couple-stage">

                    <article class="wl-person-card" data-reveal="right">
                        <div class="wl-person-photo-wrap">
                            <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                        </div>
                        <div class="wl-person-content">
                            <div class="wl-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                            <h3 class="wl-person-name responsive-text">{{ $bride->name ?? $brideName }}</h3>
                            <div class="wl-person-line"></div>
                            <p class="wl-person-family responsive-text">{{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}</p>
                        </div>
                    </article>

                    <div class="wl-couple-symbol" data-reveal="zoom">&</div>

                    <article class="wl-person-card" data-reveal="left">
                        <div class="wl-person-photo-wrap">
                            <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                        </div>
                        <div class="wl-person-content">
                            <div class="wl-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                            <h3 class="wl-person-name responsive-text">{{ $groom->name ?? $groomName }}</h3>
                            <div class="wl-person-line"></div>
                            <p class="wl-person-family responsive-text">{{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}</p>
                        </div>
                    </article>

                </div>
            </section>

            <section id="invitation" class="wl-page slim">
                <div class="wl-invitation-card" data-reveal="zoom">
                    <p class="wl-label">With Love</p>
                    <h2 class="wl-title wl-script responsive-text">Undangan Pernikahan</h2>
                    <p class="wl-note responsive-text">{{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan kami. Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.' }}</p>
                </div>
            </section>

            <section id="acara" class="wl-page wl-event-section">
                <p class="wl-label" data-reveal="zoom">Wedding Event</p>
                <h2 class="wl-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6rem);">Detail Acara</h2>
                <p class="wl-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Acara pernikahan kami akan dilaksanakan pada:</p>

                <div class="wl-event-layout wl-event-layout-single">
                    <div class="wl-event-card" data-reveal="zoom">
                        <div class="wl-event-icon wl-icon-rings"></div>

                        <h3 class="wl-title responsive-text">Pernikahan</h3>

                        <div class="wl-date-stack">
                            <div class="wl-date-split">
                                <div class="wl-date-side">
                                    {{ $eventDayText }}
                                </div>

                                <div class="wl-date-center">
                                    <b>{{ $startDate ? $startDate->format('d') : '--' }}</b>
                                    <span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span>
                                </div>

                                <div class="wl-date-side">
                                    {{ $startDate ? $startDate->translatedFormat('F') : '' }}
                                </div>
                            </div>

                            @if ($hasEndDate)
                                <div class="wl-date-until">
                                    sampai
                                </div>

                                <div class="wl-date-split">
                                    <div class="wl-date-side">
                                        {{ $endDate->translatedFormat('l') }}
                                    </div>

                                    <div class="wl-date-center">
                                        <b>{{ $endDate->format('d') }}</b>
                                        <span>{{ $endDate->translatedFormat('Y') }}</span>
                                    </div>

                                    <div class="wl-date-side">
                                        {{ $endDate->translatedFormat('F') }}
                                    </div>
                                </div>

                                <p class="wl-date-range-final responsive-text">
                                    {{ $eventDateNumericRange }}
                                </p>
                            @endif
                        </div>

                        @if ($eventTimeText)
                            <p class="wl-event-line">{{ $eventTimeText }}</p>
                        @endif

                        <p class="wl-event-place responsive-text">{{ $locationText }}</p>
                        <p class="wl-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>

                        <div class="wl-event-actions">
                            @if ($mapOpenUrl)
                                <a href="{{ $mapOpenUrl }}" target="_blank" class="wl-btn">Petunjuk Arah</a>
                            @endif

                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="wl-btn light">Calendar</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($mapOpenUrl)
                    <div class="wl-map-card" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe src="{{ $mapEmbedUrl }}" class="wl-map-frame" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="wl-map-placeholder" aria-label="Buka lokasi di Google Maps">
                                <div>
                                    <div class="wl-map-pin">⌖</div>
                                    <p class="wl-map-title responsive-text">{{ $locationText }}</p>
                                    <p class="wl-map-address responsive-text">Klik untuk membuka lokasi asli di Google Maps.</p>
                                </div>
                            </a>
                        @endif
                        <div class="wl-map-footer">
                            <div>
                                <p class="wl-map-title responsive-text">{{ $locationText }}</p>
                                <p class="wl-map-address responsive-text">{!! nl2br(e($addressText)) !!}</p>
                            </div>
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="wl-btn">Maps</a>
                        </div>
                    </div>
                @endif
            </section>

            @if ($photos->count())
                <section id="galeri" class="wl-page slim">
                    <p class="wl-label" data-reveal="zoom">Our Gallery</p>
                    <h2 class="wl-title wl-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6rem);">Precious Moment</h2>
                    <div class="wl-gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="wl-gallery-item" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri {{ $index + 1 }}">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="wl-page slim">
                    <p class="wl-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="wl-title wl-script responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6rem);">Tanda Kasih</h2>
                    <p class="wl-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                    <div class="wl-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            <div class="wl-gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .05, .2) }}s">
                                <div class="wl-gift-title responsive-text">{{ $gift->bank_name ?? $gift->type ?? $gift->label ?? 'Hadiah' }}</div>
                                <div class="wl-gift-number responsive-text">{{ $gift->account_number ?? $gift->value ?? '-' }}</div>
                                <p class="responsive-text" style="position:relative;z-index:2;margin-top:10px;color:#5d6266;">{{ $gift->account_name ?? $gift->holder_name ?? $gift->description ?? '' }}</p>
                                @if ($gift->account_number ?? $gift->value ?? null)<button type="button" class="wl-copy-btn" data-copy="{{ $gift->account_number ?? $gift->value }}">Salin Nomor</button>@endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="wl-page slim">
                <p class="wl-label" data-reveal="zoom">Reservation Reply</p>
                <h2 class="wl-title responsive-text" data-reveal="zoom" style="font-size:clamp(2.8rem,6vw,6rem);">RSVP</h2>
                <div class="wl-rsvp-layout">
                    <div class="wl-rsvp-copy" data-reveal="left">
                        <h3 class="wl-title wl-script responsive-text">Kirim Pesan</h3>
                        <p class="wl-note responsive-text" style="margin-left:0;">Silakan kirim ucapan dan konfirmasi kehadiran Anda. Setiap doa baik akan menjadi kenangan indah bagi kami.</p>
                    </div>

                    <div data-reveal="right">
                        @if (session('message_success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>@endif
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5 text-left"><p class="font-bold">Mohon periksa kembali isian:</p><ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="wl-form-card space-y-4">
                            @csrf
                            <div><label class="wl-form-label">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="wl-input" placeholder="Nama lengkap" required></div>
                            <div><label class="wl-form-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="wl-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                            <div><label class="wl-form-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="wl-input"></div>
                            <div><label class="wl-form-label">Ucapan / Doa</label><textarea name="message" rows="4" class="wl-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                            <button type="submit" class="wl-btn" style="width:100%;">Kirim Pesan</button>
                        </form>
                    </div>

                    <div class="wl-summary-grid">
                        <div data-reveal="zoom"><b>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</b><span>Tidak Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.06s"><b>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><span>Hadir</span></div>
                        <div data-reveal="zoom" style="--reveal-delay:.12s"><b>{{ $messages->where('attendance_status', 'ragu')->count() }}</b><span>Ragu</span></div>
                    </div>

                    <div class="wl-message-list">
                        @forelse ($messages as $index => $message)
                            <div class="wl-message-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                                <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--wl-gold);">{{ $message->guest_name }}</p><p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:#f4f1e8;color:var(--wl-charcoal);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                                <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="wl-message-card text-center" data-reveal="zoom"><p class="text-slate-500">Belum ada ucapan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="wl-page">
                <div class="wl-closing-card" data-reveal="zoom">
                    @if ($closingPhoto)<img src="{{ $closingPhoto }}" alt="Foto Penutup" class="wl-closing-photo">@endif
                    <p class="wl-label">Thank You</p>
                    <h2 class="wl-title wl-script responsive-text mt-8">Terima Kasih</h2>
                    <p class="wl-note responsive-text">Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
                    <h3 class="wl-title wl-script responsive-text mt-8" style="font-size:clamp(2.2rem,7vw,4.8rem);">{{ $eventTitle }}</h3>
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

            document.querySelectorAll('.wl-copy-btn').forEach(function (button) {
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

            if (!['input', 'textarea', 'select'].includes(tag)) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
