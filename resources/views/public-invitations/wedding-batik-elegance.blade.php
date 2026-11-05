<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Batik Elegance'));
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
            color: var(--be-ink);
            background:
                radial-gradient(circle at 12% 6%, color-mix(in srgb, var(--be-accent) 24%, transparent), transparent 32%),
                radial-gradient(circle at 86% 12%, color-mix(in srgb, var(--be-terracotta) 22%, transparent), transparent 30%),
                linear-gradient(180deg, var(--be-paper) 0%, var(--be-mist) 42%, var(--be-dark) 100%);
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

        .be-shell {
            width: min(100%, 1160px);
            margin: 0 auto;
            padding: 24px;
        }

        .be-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            isolation: isolate;
            border-radius: 34px;
            border: 1px solid color-mix(in srgb, var(--be-gold) 24%, transparent);
            background:
                radial-gradient(circle at 50% 0%, rgba(255,255,255,.82), rgba(255,255,255,.20) 42%, transparent 68%),
                linear-gradient(180deg, color-mix(in srgb, var(--be-paper) 94%, white), color-mix(in srgb, var(--be-mist) 92%, white) 42%, color-mix(in srgb, var(--be-dark) 92%, black)),
                url("{{ asset('assets/batik-elegance/be-paper-texture.png') }}") center/cover repeat;
            box-shadow: 0 42px 120px rgba(40, 27, 18, .22);
        }

        .be-book::before,
        .be-book::after,
        .be-page::before,
        .be-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .be-book::before {
            z-index: 0;
            opacity: .42;
            background:
                url("{{ asset('assets/batik-elegance/be-batik-patch-left.png') }}") left 5%/260px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-batik-patch-right.png') }}") right 18%/260px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-dark-batik-cloud.png') }}") center bottom/112% auto no-repeat,
                linear-gradient(90deg, rgba(73,54,35,.035) 1px, transparent 1px) 0 0/46px 46px,
                linear-gradient(0deg, rgba(73,54,35,.030) 1px, transparent 1px) 0 0/46px 46px;
        }

        .be-book::after {
            z-index: 0;
            opacity: .28;
            background:
                radial-gradient(circle at 20% 20%, color-mix(in srgb, var(--be-accent) 20%, transparent), transparent 28%),
                radial-gradient(circle at 82% 28%, color-mix(in srgb, var(--be-terracotta) 22%, transparent), transparent 30%),
                radial-gradient(circle at 48% 78%, rgba(255,255,255,.18), transparent 34%);
        }

        .be-book > * { position: relative; z-index: 2; }

        .be-floating-actions {
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
            border: 1px solid rgba(78, 55, 36, .16);
            border-right: 0;
            box-shadow: 0 18px 42px rgba(39,27,19,.14);
            backdrop-filter: blur(14px);
        }
        .be-floating-actions a,
        .be-floating-actions button {
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
            box-shadow: 0 10px 22px rgba(39,27,19,.12);
            transition: transform .25s ease, background .25s ease;
        }
        .be-floating-actions a:hover,
        .be-floating-actions button:hover { transform: translateX(-3px); }
        .be-floating-actions button.is-active { background: color-mix(in srgb, var(--be-gold) 36%, white); }
        .be-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .be-page {
            position: relative;
            min-height: auto;
            padding: 104px 72px;
            overflow: hidden;
            text-align: center;
        }
        .be-page.slim { padding-top: 84px; padding-bottom: 84px; }
        .be-page > * { position: relative; z-index: 5; }

        .be-page::before {
            z-index: 1;
            opacity: .34;
            background:
                url("{{ asset('assets/batik-elegance/be-floral-corner-cream.png') }}") left top/230px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-floral-corner-cream-mirror.png') }}") right top/230px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-floral-bottom.png') }}") center bottom/108% auto no-repeat;
        }
        .be-page::after {
            z-index: 2;
            opacity: .42;
            background:
                radial-gradient(circle at 50% 34%, rgba(255,255,255,.70), rgba(255,255,255,.20) 46%, transparent 72%),
                linear-gradient(180deg, transparent, rgba(255,255,255,.18), transparent);
        }

        .be-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: fit-content;
            margin: 0 auto 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--be-deep);
            background: rgba(255,255,255,.72);
            border: 1px solid color-mix(in srgb, var(--be-gold) 30%, transparent);
            box-shadow: 0 12px 28px rgba(67,43,28,.08);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .be-label::before,
        .be-label::after { content: ""; width: 28px; height: 1px; background: var(--be-deep); opacity: .40; }

        .be-title {
            margin: 0;
            color: var(--be-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: .02em;
            line-height: .96;
            text-wrap: balance;
        }
        .be-script { font-family: Georgia, "Times New Roman", serif; font-style: italic; font-weight: 400; letter-spacing: .01em; }
        .be-note { max-width: 700px; margin: 20px auto 0; color: color-mix(in srgb, var(--be-ink) 84%, transparent); line-height: 1.9; }

        .be-btn {
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
            background: linear-gradient(135deg, var(--be-deep), var(--be-dark));
            box-shadow: 0 16px 34px rgba(63, 42, 27, .20);
            font-weight: 950;
            letter-spacing: .03em;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .be-btn:hover { transform: translateY(-2px); }
        .be-btn.light { color: var(--be-deep); background: rgba(255,255,255,.84); border: 1px solid rgba(78,55,36,.16); }
        .be-btn.gold { color: #332315; background: linear-gradient(135deg, #e3bd6b, #f6e5a8); }
        .be-btn::after,
        .be-copy-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -88%;
            width: 48%;
            height: 240%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: beShine 4.2s ease-in-out infinite;
        }

        /* HERO - mengikuti Undangan252: pohon, rumah joglo, bangau, panel batik gelap */
        .be-hero {
            min-height: 920px;
            padding: 72px 72px 0;
            display: grid;
            place-items: center;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,248,229,.82), rgba(244,232,207,.46) 46%, rgba(45,35,25,.90) 100%),
                radial-gradient(circle at 50% 22%, rgba(255,255,255,.82), rgba(255,255,255,.24) 48%, transparent 72%);
        }
        .be-hero::before {
            opacity: .96;
            background:
                url("{{ asset('assets/batik-elegance/be-crane-top-right.png') }}") right 2%/300px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-tree-left-autumn.png') }}") left 2%/38% auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-tree-right-autumn.png') }}") right 12%/38% auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-joglo-house-soft.png') }}") center 54%/74% auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-batik-patch-left.png') }}") left 58%/280px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-batik-patch-right.png') }}") right 66%/270px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-dark-batik-cloud.png') }}") center bottom/112% auto no-repeat;
        }
        .be-hero::after {
            opacity: .68;
            background:
                linear-gradient(180deg, rgba(255,255,255,.22) 0%, rgba(255,255,255,.10) 46%, rgba(0,0,0,.18) 100%),
                url("{{ asset('assets/batik-elegance/be-warm-haze-soft.png') }}") center center/120% 100% no-repeat;
        }
        .be-hero-inner {
            width: min(100%, 620px);
            margin: 0 auto;
            padding: 104px 0 360px;
        }
        .be-hero-kicker { color: var(--be-ink); font-size: 12px; font-weight: 950; letter-spacing: .20em; text-transform: uppercase; }
        .be-hero-title {
            margin-top: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: var(--be-deep);
            font-size: clamp(3rem, 6.2vw, 6rem);
            line-height: .94;
            text-transform: uppercase;
            text-shadow: 0 14px 30px rgba(56,35,22,.18);
        }
        .be-hero-and { display: block; color: var(--be-ink); font-size: clamp(2rem, 4vw, 3.2rem); line-height: .78; text-transform: none; }
        .be-hero-date { margin-top: 26px; color: #3b3025; font-size: 1rem; letter-spacing: .24em; font-weight: 850; }
        .be-hero-actions { margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .be-quote-card {
            width: min(100%, 640px);
            margin: 0 auto 34px;
            padding: 28px 30px;
            border-radius: 34px;
            color: rgba(255,255,255,.90);
            background: rgba(42,31,22,.72);
            border: 1px solid rgba(245,223,174,.18);
            box-shadow: 0 20px 54px rgba(39,27,19,.20);
            backdrop-filter: blur(6px);
            text-align: left;
        }
        .be-quote-card .be-note { color: rgba(255,255,255,.88); margin: 0; font-size: .95rem; line-height: 1.85; }

        /* Couple - gunungan, daun, foto mempelai */
        .be-couple {
            background:
                linear-gradient(180deg, rgba(42,31,22,.95) 0%, rgba(45,34,25,.80) 26%, rgba(255,248,229,.64) 100%),
                url("{{ asset('assets/batik-elegance/be-dark-batik-cloud.png') }}") center top/cover no-repeat;
            color: #fff8e8;
        }
        .be-couple::before {
            opacity: .84;
            background:
                url("{{ asset('assets/batik-elegance/be-leaf-left.png') }}") left 8%/250px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-leaf-right.png') }}") right 8%/250px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-gunungan-center.png') }}") center top/390px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-floral-bottom.png') }}") center bottom/108% auto no-repeat;
        }
        .be-couple .be-title,
        .be-couple .be-label { color: var(--be-gold); }
        .be-couple .be-note { color: rgba(255,248,232,.82); }
        .be-couple-stage {
            width: min(100%, 1040px);
            margin: 58px auto 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 28px;
            align-items: stretch;
        }
        .be-person-card {
            position: relative;
            min-height: 650px;
            padding: 42px 32px 46px;
            border-radius: 42px;
            background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(38,28,20,.62));
            border: 1px solid rgba(245,223,174,.22);
            box-shadow: 0 30px 84px rgba(20,13,8,.28);
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            text-align: center;
        }
        .be-person-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .40;
            background:
                url("{{ asset('assets/batik-elegance/be-gunungan-gold.png') }}") center 24px/62% auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-floral-bottom.png') }}") center bottom/124% auto no-repeat;
            pointer-events: none;
        }
        .be-person-photo-wrap {
            position: relative;
            z-index: 2;
            width: min(100%, 290px);
            margin: 0 auto;
            padding: 10px;
            border-radius: 999px 999px 34px 34px;
            background: rgba(255,250,232,.94);
            box-shadow: 0 22px 58px rgba(20,13,8,.24);
        }
        .be-person-photo-wrap img,
        .be-person-initial {
            width: 100%;
            aspect-ratio: 3/4;
            display: grid;
            place-items: center;
            object-fit: cover;
            border-radius: 999px 999px 26px 26px;
            background: color-mix(in srgb, var(--be-gold) 14%, white);
            color: var(--be-deep);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4.2rem;
            font-weight: 700;
        }
        .be-person-content { position: relative; z-index: 2; margin-top: 30px; }
        .be-person-subtitle { color: var(--be-gold); font-family: Georgia, serif; font-style: italic; font-size: clamp(2.2rem, 4vw, 3.6rem); line-height: 1; }
        .be-person-name { margin: 10px 0 0; color: #fff7e4; font-family: Georgia,"Times New Roman",serif; font-size: clamp(1.9rem, 3.2vw, 3rem); line-height: 1.08; font-weight: 700; }
        .be-person-family { max-width: 390px; margin: 16px auto 0; color: rgba(255,248,232,.82); line-height: 1.78; }

        .be-invitation-card {
            width: min(100%, 880px);
            margin: 0 auto;
            padding: 54px 48px;
            border-radius: 44px;
            background: linear-gradient(145deg, rgba(255,255,255,.78), rgba(250,240,215,.58));
            border: 1px solid rgba(78,55,36,.14);
            box-shadow: 0 28px 84px rgba(67,43,28,.10);
        }
        .be-invitation-card h2 { font-size: clamp(3rem, 6vw, 6.6rem); }

        /* Save the Date */
        .be-save-date {
            min-height: 820px;
            padding: 100px 72px 120px;
            display: grid;
            place-items: center;
            background: linear-gradient(180deg, color-mix(in srgb, var(--be-paper) 92%, white), color-mix(in srgb, var(--be-dark) 92%, black));
        }
        .be-save-date::before {
            opacity: .78;
            background:
                url("{{ asset('assets/batik-elegance/be-gunungan-center.png') }}") center 8%/340px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-leaf-left.png') }}") left center/240px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-leaf-right.png') }}") right center/240px auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-dark-batik-cloud.png') }}") center bottom/112% auto no-repeat;
        }
        .be-count-panel {
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 62px 36px;
            border-radius: 46px;
            background: rgba(255,248,232,.74);
            border: 1px solid rgba(78,55,36,.14);
            box-shadow: 0 26px 72px rgba(67,43,28,.14);
            backdrop-filter: blur(8px);
        }
        .be-count-title { font-size: clamp(3rem, 6vw, 6rem); }
        .be-count-grid { width: min(100%, 540px); margin: 40px auto 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .be-count-card { padding: 22px 14px; border-radius: 28px; background: rgba(255,255,255,.82); border: 1px solid rgba(78,55,36,.12); box-shadow: 0 14px 34px rgba(67,43,28,.08); }
        .be-count-number { display: block; color: var(--be-deep); font-family: Georgia,"Times New Roman",serif; font-size: clamp(2.5rem, 6vw, 4.6rem); line-height: 1; font-weight: 800; }
        .be-count-label { display: block; margin-top: 8px; color: #665849; font-size: 12px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase; }
        .be-count-actions { margin-top: 40px; }

        /* Event */
        .be-event-layout { width: min(100%, 1040px); margin: 46px auto 0; display: grid; grid-template-columns: minmax(0, .96fr) minmax(340px, 1.04fr); gap: 34px; align-items: stretch; }
        .be-event-layout.is-single { grid-template-columns: minmax(0, 760px); justify-content: center; }
        .be-event-card,
        .be-map-card {
            border-radius: 42px;
            background: linear-gradient(145deg, rgba(255,255,255,.84), rgba(250,240,215,.62));
            border: 1px solid rgba(78,55,36,.14);
            box-shadow: 0 28px 82px rgba(67,43,28,.11);
            overflow: hidden;
        }
        .be-event-card { position: relative; padding: 64px 38px 52px; text-align: center; border-radius: 42px; overflow: hidden; }
        .be-event-card::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .32;
            background:
                url("{{ asset('assets/batik-elegance/be-gunungan-gold.png') }}") center 22px/46% auto no-repeat,
                url("{{ asset('assets/batik-elegance/be-floral-bottom.png') }}") center bottom/120% auto no-repeat;
            pointer-events: none;
        }
        .be-event-card > * { position: relative; z-index: 2; }
        .be-event-card h3 { font-size: clamp(2.4rem, 4.8vw, 4.4rem); line-height: 1.04; max-width: 440px; margin: 0 auto; color: var(--be-deep); }
        .be-date-split { margin: 32px auto 24px; display: grid; grid-template-columns: 1fr auto 1fr; gap: 22px; align-items: center; width: min(100%, 520px); }
        .be-date-side { color: #665849; font-family: Georgia,"Times New Roman",serif; font-size: 1.08rem; }
        .be-date-center { padding: 0 26px; border-left: 1px solid rgba(78,55,36,.28); border-right: 1px solid rgba(78,55,36,.28); }
        .be-date-center b { display: block; color: var(--be-deep); font-family: Georgia,"Times New Roman",serif; font-size: clamp(3rem, 6vw, 5.2rem); line-height: .9; }
        .be-date-center span { display: block; margin-top: 10px; color: #665849; font-weight: 700; }
        .be-date-end-label { margin: 16px 0 10px; color: var(--be-deep); font-size: .9rem; font-weight: 850; letter-spacing: .08em; text-transform: uppercase; opacity: .82; }
        .be-date-split-end { margin-top: 0; }
        .be-event-line { margin-top: 20px; color: #584d41; line-height: 1.85; font-weight: 750; }
        .be-event-place { margin-top: 30px; color: #33291f; font-weight: 950; }
        .be-event-address { margin: 10px auto 0; color: #665849; line-height: 1.75; width: min(100%, 560px); }
        .be-event-actions { margin-top: 32px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

        .be-map-card { display: flex; flex-direction: column; min-height: 520px; }
        .be-map-frame,
        .be-map-placeholder { width: 100%; height: 420px; min-height: 420px; border: 0; display: block; }
        .be-map-placeholder { display: flex; align-items: center; justify-content: center; text-align: center; text-decoration: none; color: inherit; padding: 32px; background: linear-gradient(135deg, rgba(151,112,73,.13), rgba(177,80,66,.11)), #f4ead6; }
        .be-map-pin { width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 999px; display: grid; place-items: center; background: var(--be-deep); color: #fff; font-size: 2rem; box-shadow: 0 18px 40px rgba(67,43,28,.20); }
        .be-map-footer { padding: 22px 26px; display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; background: rgba(255,255,255,.84); border-top: 1px solid rgba(78,55,36,.12); }
        .be-map-title { margin: 0; color: #33291f; font-weight: 950; }
        .be-map-address { margin: 7px 0 0; color: #665849; line-height: 1.65; white-space: pre-line; overflow-wrap: anywhere; }

        .be-gallery-grid { width: min(100%, 1040px); margin: 44px auto 0; display: grid; grid-template-columns: repeat(12, 1fr); grid-auto-rows: 110px; gap: 12px; }
        .be-gallery-item { display: block; overflow: hidden; padding: 6px; background: rgba(255,255,255,.84); border: 1px solid rgba(78,55,36,.15); box-shadow: 0 14px 34px rgba(67,43,28,.08); border-radius: 32px; }
        .be-gallery-item:nth-child(1) { grid-column: span 5; grid-row: span 4; border-radius: 999px 999px 28px 28px; }
        .be-gallery-item:nth-child(2) { grid-column: span 4; grid-row: span 2; }
        .be-gallery-item:nth-child(3) { grid-column: span 3; grid-row: span 2; }
        .be-gallery-item:nth-child(n+4) { grid-column: span 3; grid-row: span 2; }
        .be-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit; transition: transform .7s ease; }
        .be-gallery-item:hover img { transform: scale(1.055); }

        .be-gift-grid { width: min(100%, 920px); margin: 42px auto 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .be-gift-grid.is-single { grid-template-columns: minmax(0, 450px); justify-content: center; }
        .be-gift-card { position: relative; overflow: hidden; min-height: 210px; padding: 32px 28px; border-radius: 34px; text-align: left; background: linear-gradient(145deg, rgba(255,255,255,.88), rgba(250,240,215,.68)); border: 1px solid rgba(78,55,36,.15); box-shadow: 0 18px 48px rgba(67,43,28,.10); }
        .be-gift-card::before { content:""; position:absolute; inset:auto -20px -65px -20px; height: 140px; background: color-mix(in srgb, var(--be-gold) 20%, transparent); transform: skewY(-7deg); }
        .be-gift-title,.be-gift-number,.be-copy-btn { position: relative; z-index: 2; }
        .be-gift-title { color: var(--be-deep); font-weight: 950; font-size: 1.25rem; }
        .be-gift-number { margin-top: 18px; color: #33291f; font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.4rem); }
        .be-copy-btn { overflow: hidden; margin-top: 18px; border: 0; border-radius: 999px; padding: 12px 18px; color: #fffdf1; background: var(--be-deep); font-weight: 950; cursor: pointer; }
        .be-copy-btn.copied { background: #16803c; }

        .be-rsvp-layout { width: min(100%, 1080px); margin: 44px auto 0; display: grid; grid-template-columns: minmax(280px,.84fr) minmax(420px,1.16fr); gap: 34px; align-items: start; text-align: left; }
        .be-rsvp-copy { padding: 42px 34px; border-radius: 40px; background: linear-gradient(145deg, rgba(255,255,255,.80), rgba(250,240,215,.58)); border: 1px solid rgba(78,55,36,.14); box-shadow: 0 18px 48px rgba(67,43,28,.08); }
        .be-rsvp-copy h3 { font-size: clamp(2rem, 3.3vw, 3.4rem); }
        .be-form-card { padding: 26px; border-radius: 28px; background: rgba(255,255,255,.86); border: 1px solid rgba(78,55,36,.14); box-shadow: 0 18px 48px rgba(67,43,28,.08); text-align: left; }
        .be-form-label { display: block; color: var(--be-deep); font-size: 12px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; text-align: left; }
        .be-input { width: 100%; margin-top: 8px; border: 1px solid rgba(78,55,36,.14); background: rgba(255,255,255,.94); color: var(--be-ink); border-radius: 14px; padding: 13px 14px; outline: none; text-align: left; }
        .be-summary-grid { grid-column: 1 / -1; margin-top: 10px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .be-summary-grid > div { padding: 18px 10px; text-align: center; border-radius: 22px; background: rgba(255,255,255,.76); border: 1px solid rgba(78,55,36,.12); }
        .be-summary-grid b { display: block; color: var(--be-deep); font-size: 2rem; line-height: 1; }
        .be-message-list { grid-column: 1 / -1; display: grid; gap: 12px; margin-top: 20px; }
        .be-message-card { padding: 18px; border-radius: 22px; background: rgba(255,255,255,.82); border: 1px solid rgba(78,55,36,.12); box-shadow: 0 10px 24px rgba(67,43,28,.06); }

        .be-closing-card { width: min(100%, 720px); margin: 0 auto; padding: 80px 34px 240px; text-align: center; }
        .be-closing-card h2 { font-size: clamp(3rem, 7vw, 6.5rem); }
        .be-closing-photo { width: 210px; height: 270px; margin: 0 auto 28px; object-fit: cover; display: block; border-radius: 999px 999px 28px 28px; border: 8px solid #fff; outline: 1px solid rgba(78,55,36,.20); box-shadow: 0 20px 52px rgba(67,43,28,.14); }

        [data-reveal] { opacity: 0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay, 0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes beShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes beFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .be-floating-actions a, .be-floating-actions button { animation: beFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1440px) {
            .be-shell { width: min(100%, 1320px); }
            .be-page { padding-left: 92px; padding-right: 92px; }
            .be-hero-title { font-size: clamp(5rem, 7vw, 7.4rem); }
        }

        @media (max-width: 980px) {
            .be-shell { padding: 14px; }
            .be-page { padding: 90px 38px; }
            .be-hero { min-height: 840px; padding: 78px 38px 0; }
            .be-hero::before {
                background-size: 230px auto, 52% auto, 52% auto, 104% auto, 230px auto, 230px auto, 134% auto;
            }
            .be-hero-inner { padding-top: 100px; padding-bottom: 320px; }
            .be-couple-stage,
            .be-event-layout,
            .be-rsvp-layout { grid-template-columns: 1fr; text-align: center; }
            .be-gift-grid { grid-template-columns: 1fr; }
            .be-gallery-grid { grid-template-columns: repeat(6, 1fr); }
            .be-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
            .be-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; }
            .be-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        }

        @media (max-width: 640px) {
            .be-shell { padding: 0; }
            .be-book { border-radius: 0; border-left: 0; border-right: 0; box-shadow: none; }
            .be-page,
            .be-page.slim { padding: 76px 22px; }
            .be-floating-actions { right: 0; gap: 7px; }
            .be-floating-actions a, .be-floating-actions button { width: 40px; height: 40px; }
            .be-hero { min-height: 100svh; padding: 60px 22px 0; }
            .be-hero::before {
                background:
                    url("{{ asset('assets/batik-elegance/be-crane-top-right.png') }}") right 2%/170px auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-tree-left-autumn.png') }}") left 2%/62% auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-tree-right-autumn.png') }}") right 15%/62% auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-joglo-house-soft.png') }}") center 60%/132% auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-batik-patch-left.png') }}") left 62%/170px auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-batik-patch-right.png') }}") right 70%/160px auto no-repeat,
                    url("{{ asset('assets/batik-elegance/be-dark-batik-cloud.png') }}") center bottom/170% auto no-repeat;
            }
            .be-hero-inner { padding-top: 90px; padding-bottom: 330px; }
            .be-hero-title { font-size: clamp(2.4rem, 11vw, 3.8rem); line-height: .98; }
            .be-hero-actions, .be-event-actions { flex-direction: column; }
            .be-hero-actions .be-btn, .be-event-actions .be-btn, .be-btn { width: 100%; }
            .be-label { font-size: 10px; letter-spacing: .13em; }
            .be-label::before, .be-label::after { width: 18px; }
            .be-quote-card { padding: 22px 20px; }
            .be-person-card { min-height: auto; padding: 36px 20px 42px; }
            .be-person-photo-wrap { width: min(240px, 74vw); }
            .be-date-split { grid-template-columns: 1fr; gap: 14px; }
            .be-date-center { border-left: 0; border-right: 0; border-top: 1px solid rgba(78,55,36,.28); border-bottom: 1px solid rgba(78,55,36,.28); padding: 18px 0; }
            .be-count-panel { padding: 48px 18px; border-radius: 34px; }
            .be-count-grid { grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; }
            .be-event-card { padding: 50px 20px 42px; }
            .be-map-frame, .be-map-placeholder { height: 320px; min-height: 320px; }
            .be-map-footer { flex-direction: column; align-items: stretch; }
            .be-gallery-grid { grid-template-columns: 1fr; grid-auto-rows: auto; }
            .be-gallery-item, .be-gallery-item:nth-child(n) { grid-column: auto; grid-row: auto; height: auto; aspect-ratio: 4/5; }
            .be-rsvp-layout { gap: 22px; }
            .be-rsvp-copy, .be-form-card { padding: 26px 20px; border-radius: 28px; }
            .be-summary-grid { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }

        /* Ubah warna judul Mempelai jadi gold terang */
        .be-couple > .be-title {
            color: #f8d98a !important;
            text-shadow:
                0 2px 0 rgba(0,0,0,.35),
                0 8px 20px rgba(0,0,0,.35) !important;
        }
    </style>
</head>
@php
    $beThemeKey = $invitation->theme_color ?: 'maroon';
    $beThemes = [
        'maroon' => ['paper' => '#f7ead2', 'mist' => '#e5d1b8', 'dark' => '#2a211a', 'deep' => '#5b281d', 'gold' => '#d5a65a', 'accent' => '#9f4b39', 'terracotta' => '#b7674f', 'ink' => '#2f261f'],
        'emerald' => ['paper' => '#f3ead4', 'mist' => '#ded4bb', 'dark' => '#1f2b24', 'deep' => '#315843', 'gold' => '#d0a75f', 'accent' => '#56775a', 'terracotta' => '#b36a4c', 'ink' => '#25322a'],
        'navy' => ['paper' => '#f3ead6', 'mist' => '#d9d4c6', 'dark' => '#1e2632', 'deep' => '#2d4261', 'gold' => '#d1aa62', 'accent' => '#435f83', 'terracotta' => '#af664f', 'ink' => '#26303a'],
        'rose' => ['paper' => '#f8e8d6', 'mist' => '#e8cfc3', 'dark' => '#2d1e22', 'deep' => '#704050', 'gold' => '#d6a85f', 'accent' => '#a85f66', 'terracotta' => '#b96f58', 'ink' => '#342728'],
        'gold' => ['paper' => '#fbf0d3', 'mist' => '#e5d8b5', 'dark' => '#2c2417', 'deep' => '#806235', 'gold' => '#d9b15e', 'accent' => '#b58a43', 'terracotta' => '#ac6744', 'ink' => '#30281d'],
        'slate' => ['paper' => '#f0eadc', 'mist' => '#d6d3ca', 'dark' => '#252729', 'deep' => '#5b605d', 'gold' => '#c9a45c', 'accent' => '#74726a', 'terracotta' => '#a6604a', 'ink' => '#2d2f30'],
    ];
    $beTheme = $beThemes[$beThemeKey] ?? $beThemes['maroon'];
@endphp
<body style="
    --be-paper: {{ $beTheme['paper'] }};
    --be-mist: {{ $beTheme['mist'] }};
    --be-dark: {{ $beTheme['dark'] }};
    --be-deep: {{ $beTheme['deep'] }};
    --be-gold: {{ $beTheme['gold'] }};
    --be-accent: {{ $beTheme['accent'] }};
    --be-terracotta: {{ $beTheme['terracotta'] }};
    --be-ink: {{ $beTheme['ink'] }};
">
@php
    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventTitle = trim($invitation->title ?: 'John Doe & Jane Doe');
    $titleParts = str_contains($eventTitle, '&') ? array_map('trim', explode('&', $eventTitle, 2)) : [];
    $brideName = $bride->name ?? ($titleParts[0] ?? 'John Doe');
    $groomName = $groom->name ?? ($titleParts[1] ?? 'Jane Doe');
    $brideSubtitle = $bride->subtitle ?? 'Bride';
    $groomSubtitle = $groom->subtitle ?? 'Groom';

    $photoUrl = function ($path, $fallback = null) {
        if (!$path) return $fallback;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) return asset(ltrim($path, '/'));
        return asset('storage/' . ltrim($path, '/'));
    };

    $defaultCover = asset('assets/batik-elegance/be-couple-placeholder.png');
    $coverDisplay = $photoUrl($invitation->cover_image ?? null, $defaultCover);
    $bridePhoto = $photoUrl($bride->photo ?? $bride->image ?? null, $coverDisplay);
    $groomPhoto = $photoUrl($groom->photo ?? $groom->image ?? null, $coverDisplay);

    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->locale('id') : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->locale('id') : null;
    $hasDifferentEndDate = !empty($invitation->event_end_date) && $endDate && $startDate && !$startDate->isSameDay($endDate);

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
    $endDayText = $endDate ? $endDate->translatedFormat('l') : null;
    $endMonthText = $endDate ? $endDate->translatedFormat('F') : null;
    $endYearText = $endDate ? $endDate->translatedFormat('Y') : null;
    $endDayNumber = $endDate ? $endDate->format('d') : null;

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }
    $locationText = $invitation->location_name ?: 'Pendopo Batik Heritage';
    $addressText = $invitation->address ?: 'Jl. Batik Elegance No. 12, Yogyakarta';
    $descriptionText = $invitation->description ?: 'Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu.';

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
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    if ($addressText) { $shareMessage .= "Alamat: {$addressText}\n"; }
    if ($mapOpenUrl) { $shareMessage .= "Maps: {$mapOpenUrl}\n"; }
    $shareMessage .= "\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\nKlik link undangan berikut:\n{$shareUrl}\n\nTerima kasih.\nWassalamu'alaikum Wr. Wb.";
    $shareText = rawurlencode($shareMessage);

    $musicSrc = asset('assets/music/background1.mp3');
    if ($invitation->music_url) {
        $musicPath = $invitation->music_url;
        if (\Illuminate\Support\Str::startsWith($musicPath, ['http://', 'https://'])) $musicSrc = $musicPath;
        elseif (\Illuminate\Support\Str::startsWith($musicPath, ['/storage/', 'storage/'])) $musicSrc = asset(ltrim($musicPath, '/'));
        else $musicSrc = asset('storage/' . ltrim($musicPath, '/'));
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

<div class="be-shell">
    <main class="be-book" id="top">
        <div class="be-floating-actions" aria-label="Aksi undangan">
            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan" aria-label="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan"></a>
            <button type="button" id="music-toggle" title="Music" aria-label="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music"></button>
            <button type="button" id="scroll-toggle" title="Auto Scroll" aria-label="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll"></button>
            @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi" aria-label="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi"></a>@endif
        </div>

        <audio id="invitation-music" src="{{ $musicSrc }}" preload="auto" loop></audio>

        <section id="opening" class="be-page be-hero">
            <div class="be-hero-inner" data-reveal="zoom">
                <p class="be-hero-kicker responsive-text">{{ strtoupper($invitation->event_name ?: 'The Wedding Of') }}</p>
                <h1 class="be-title be-hero-title responsive-text">
                    <span>{{ $brideName }}</span>
                    <span class="be-script be-hero-and">&</span>
                    <span>{{ $groomName }}</span>
                </h1>
                <p class="be-hero-date responsive-text">{{ $eventDateShort }}</p>
                <div class="be-hero-actions">
                    <a href="#couple" class="be-btn gold">Buka Undangan</a>
                    <a href="{{ $googleCalendarUrl }}" target="_blank" class="be-btn light">Simpan Tanggal</a>
                </div>
            </div>
        </section>

        <section id="couple" class="be-page be-couple">
            <p class="be-label" data-reveal="zoom">Groom & Bride</p>
            <h2 class="be-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Mempelai</h2>
            <p class="be-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $descriptionText }}</p>
            <div class="be-couple-stage">
                <article class="be-person-card" data-reveal="left">
                    <div class="be-person-photo-wrap">
                        @if ($bridePhoto)<img src="{{ $bridePhoto }}" alt="{{ $brideName }}">@else<div class="be-person-initial">{{ \Illuminate\Support\Str::substr($brideName, 0, 1) }}</div>@endif
                    </div>
                    <div class="be-person-content">
                        <div class="be-person-subtitle responsive-text">{{ $brideSubtitle }}</div>
                        <h3 class="be-person-name responsive-text">{{ $brideName }}</h3>
                        <p class="be-person-family responsive-text">{{ $bride->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>
                <article class="be-person-card" data-reveal="right" style="--reveal-delay:.10s">
                    <div class="be-person-photo-wrap">
                        @if ($groomPhoto)<img src="{{ $groomPhoto }}" alt="{{ $groomName }}">@else<div class="be-person-initial">{{ \Illuminate\Support\Str::substr($groomName, 0, 1) }}</div>@endif
                    </div>
                    <div class="be-person-content">
                        <div class="be-person-subtitle responsive-text">{{ $groomSubtitle }}</div>
                        <h3 class="be-person-name responsive-text">{{ $groomName }}</h3>
                        <p class="be-person-family responsive-text">{{ $groom->family_name ?? 'Putra/putri dari keluarga tercinta' }}</p>
                    </div>
                </article>
            </div>
        </section>

        <section id="invitation" class="be-page slim">
            <div class="be-invitation-card" data-reveal="zoom">
                <p class="be-label">With Love</p>
                <h2 class="be-title be-script responsive-text">Undangan Pernikahan</h2>
                <p class="be-note responsive-text">Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu pada hari bahagia kami.</p>
            </div>
        </section>

        <section id="countdown" class="be-page be-save-date">
            <div class="be-count-panel" data-reveal="zoom">
                <h2 class="be-title be-script be-count-title responsive-text">Save The Date</h2>
                <div class="be-count-grid" data-countdown="{{ $targetDateTime }}">
                    <div class="be-count-card"><span class="be-count-number" data-days>0</span><span class="be-count-label">Days</span></div>
                    <div class="be-count-card"><span class="be-count-number" data-hours>0</span><span class="be-count-label">Hours</span></div>
                    <div class="be-count-card"><span class="be-count-number" data-minutes>0</span><span class="be-count-label">Minutes</span></div>
                    <div class="be-count-card"><span class="be-count-number" data-seconds>0</span><span class="be-count-label">Seconds</span></div>
                </div>
                <div class="be-count-actions"><a href="{{ $googleCalendarUrl }}" target="_blank" class="be-btn gold">Add to Calendar</a></div>
            </div>
        </section>

        <section id="acara" class="be-page">
            <p class="be-label" data-reveal="zoom">Wedding Event</p>
            <h2 class="be-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Detail Acara</h2>
            <p class="be-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Acara pernikahan kami akan dilaksanakan pada:</p>

            <div class="be-event-layout {{ $mapOpenUrl || $mapEmbedUrl ? '' : 'is-single' }}">
                <article class="be-event-card" data-reveal="left">
                    <h3 class="be-title responsive-text">Acara Pernikahan</h3>
                    <div class="be-date-split">
                        <div class="be-date-side">{{ $eventDayText }}</div>
                        <div class="be-date-center"><b>{{ $startDate ? $startDate->format('d') : '--' }}</b><span>{{ $startDate ? $startDate->translatedFormat('Y') : '' }}</span></div>
                        <div class="be-date-side">{{ $startDate ? $startDate->translatedFormat('F') : '' }}</div>
                    </div>
                    @if ($hasDifferentEndDate)
                        <div class="be-date-end-label">Sampai</div>
                        <div class="be-date-split be-date-split-end">
                            <div class="be-date-side">{{ $endDayText }}</div>
                            <div class="be-date-center"><b>{{ $endDayNumber }}</b><span>{{ $endYearText }}</span></div>
                            <div class="be-date-side">{{ $endMonthText }}</div>
                        </div>
                    @endif
                    @if ($eventTimeText)<p class="be-event-line responsive-text">Pukul {{ $eventTimeText }}</p>@endif
                    <p class="be-event-place responsive-text">{{ $locationText }}</p>
                    <p class="be-event-address responsive-text">{!! nl2br(e($addressText)) !!}</p>
                    <div class="be-event-actions">
                        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="be-btn">Google Maps</a>@endif
                        <a href="{{ $googleCalendarUrl }}" target="_blank" class="be-btn light">Calendar</a>
                    </div>
                </article>
                @if ($mapOpenUrl || $mapEmbedUrl)
                    <div class="be-map-card" data-reveal="right">
                        @if ($mapEmbedUrl)
                            <iframe class="be-map-frame" src="{{ $mapEmbedUrl }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="be-map-placeholder"><div><div class="be-map-pin">⌖</div><strong>{{ $locationText }}</strong></div></a>
                        @endif
                        <div class="be-map-footer">
                            <div><p class="be-map-title responsive-text">{{ $locationText }}</p><p class="be-map-address responsive-text">{{ $addressText }}</p></div>
                            @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="be-btn">Buka Maps</a>@endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @if ($galleryPhotos->count())
            <section id="galeri" class="be-page">
                <p class="be-label" data-reveal="zoom">Our Gallery</p>
                <h2 class="be-title responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Precious Moment</h2>
                <div class="be-gallery-grid">
                    @foreach ($galleryPhotos as $photo)
                        @php $src = $photoUrl($photo->image_path ?? $photo->path ?? null, null); @endphp
                        @if ($src)
                            <a href="{{ $src }}" target="_blank" class="be-gallery-item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .04 }}s"><img src="{{ $src }}" alt="Galeri {{ $loop->iteration }}"></a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($gifts->count())
            <section id="gift" class="be-page slim">
                <p class="be-label" data-reveal="zoom">Wedding Gift</p>
                <h2 class="be-title be-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Tanda Kasih</h2>
                <p class="be-note responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                <div class="be-gift-grid {{ $gifts->count() === 1 ? 'is-single' : '' }}">
                    @foreach ($gifts as $gift)
                        <div class="be-gift-card" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * .08 }}s">
                            <div class="be-gift-title responsive-text">{{ $gift->label ?? 'Wedding Gift' }}</div>
                            <div class="be-gift-number responsive-text">{{ $gift->account_number ?? '-' }}</div>
                            <p class="responsive-text" style="position:relative;z-index:2;margin:12px 0 0;color:#665849;">{{ $gift->account_name ?? $eventTitle }}</p>
                            <button type="button" class="be-copy-btn" data-copy="{{ $gift->account_number ?? '' }}">Salin Nomor</button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section id="rsvp" class="be-page slim">
            <p class="be-label" data-reveal="zoom">RSVP</p>
            <h2 class="be-title be-script responsive-text" data-reveal="zoom" style="font-size:clamp(3rem,6vw,6rem);">Kirim Pesan</h2>
            <div class="be-rsvp-layout">
                <div class="be-rsvp-copy" data-reveal="left">
                    <h3 class="be-title be-script responsive-text">Kehadiran Anda</h3>
                    <p class="be-note responsive-text" style="margin-left:0;">Mohon konfirmasi kehadiran dan kirimkan doa terbaik untuk kedua mempelai.</p>
                </div>
                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="be-form-card space-y-4" data-reveal="right">
                    @csrf
                    <div><label class="be-form-label">Nama</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="be-input" placeholder="Nama lengkap" required></div>
                    <div><label class="be-form-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="be-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                    <div><label class="be-form-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="be-input"></div>
                    <div><label class="be-form-label">Pesan</label><textarea name="message" rows="4" class="be-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                    <button type="submit" class="be-btn" style="width:100%;">Kirim Pesan</button>
                </form>
                <div class="be-summary-grid" data-reveal="zoom">
                    <div><b>{{ $tidakHadir }}</b><span>Tidak Hadir</span></div>
                    <div><b>{{ $hadir }}</b><span>Hadir</span></div>
                    <div><b>{{ $ragu }}</b><span>Ragu</span></div>
                </div>
                <div class="be-message-list">
                    @forelse ($messages->take(5) as $message)
                        <div class="be-message-card" data-reveal="zoom">
                            <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--be-deep);">{{ $message->guest_name }}</p><p class="text-xs mt-1" style="color:#7a6b5b">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:rgba(213,166,90,.18);color:var(--be-deep);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                            <p class="responsive-text mt-3" style="color:#665849;line-height:1.8;">{{ $message->message }}</p>
                        </div>
                    @empty
                        <div class="be-message-card text-center" style="color:#665849;">Belum ada ucapan.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="closing" class="be-page be-hero">
            <div class="be-closing-card" data-reveal="zoom">
                <img src="{{ $coverDisplay }}" alt="{{ $eventTitle }}" class="be-closing-photo">
                <p class="be-note responsive-text" style="margin-bottom:18px;">Terima Kasih</p>
                <h2 class="be-title responsive-text">{{ $eventTitle }}</h2>
                <p class="be-note responsive-text">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu. Atas kehadiran dan doa restunya kami ucapkan terima kasih.</p>
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
            if (autoScrollFrame) cancelAnimationFrame(autoScrollFrame);
            autoScrollFrame = null;
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
            lastAutoScrollTime = 0;
            document.documentElement.style.scrollBehavior = 'auto';
            setScrollIcon(true);
            autoScrollFrame = requestAnimationFrame(autoScrollStep);
        }
        if (scrollToggle) {
            scrollToggle.addEventListener('click', function () { autoScrollActive ? stopAutoScroll() : startAutoScroll(); });
            ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                window.addEventListener(eventName, function () { if (autoScrollActive) stopAutoScroll(); }, { passive: true });
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
        if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) || (event.ctrlKey && ['u', 's', 'p'].includes(key))) {
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
