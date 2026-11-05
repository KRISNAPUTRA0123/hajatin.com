<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Floral Love'));
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
            color: var(--fl-ink);
            background:
                radial-gradient(circle at 12% 8%, color-mix(in srgb, var(--fl-primary) 10%, transparent), transparent 26%),
                radial-gradient(circle at 90% 2%, color-mix(in srgb, var(--fl-gold) 16%, transparent), transparent 24%),
                linear-gradient(180deg, #e9dec8 0%, var(--fl-paper) 42%, #e9dec8 100%);
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

        .fl-shell {
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 18px;
        }

        .fl-book {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 30px;
            background: #fbfaf5;
            border: 1px solid rgba(46, 55, 66, .16);
            box-shadow: 0 34px 120px rgba(51, 42, 28, .20);
            isolation: isolate;
        }

        .fl-book::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: .82;
            background:
                radial-gradient(circle at 50% 10%, rgba(255,255,255,.80), transparent 30%),
                linear-gradient(90deg, rgba(120,150,156,.045) 1px, transparent 1px) 0 0/34px 34px,
                linear-gradient(0deg, rgba(120,150,156,.035) 1px, transparent 1px) 0 0/34px 34px,
                linear-gradient(180deg, var(--fl-paper), #ffffff 38%, var(--fl-paper));
        }

        .fl-book > * { position: relative; z-index: 2; }

        .fl-floating-actions {
            position: fixed;
            right: max(14px, calc((100vw - 760px) / 2 - 66px));
            top: 50%;
            transform: translateY(-50%);
            z-index: 90;
            display: grid;
            gap: 10px;
        }

        .fl-floating-actions a,
        .fl-floating-actions button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            border: 1px solid color-mix(in srgb, var(--fl-gold) 45%, transparent);
            background: rgba(255,255,255,.92);
            box-shadow: 0 14px 30px rgba(66, 50, 26, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            transition: transform .25s ease, background .25s ease;
        }

        .fl-floating-actions a:hover,
        .fl-floating-actions button:hover { transform: translateY(-3px); }
        .fl-floating-actions button.is-active { background: color-mix(in srgb, var(--fl-gold) 84%, #fff); }
        .fl-floating-actions img { width: 22px; height: 22px; object-fit: contain; }

        .fl-nav {
            position: sticky;
            top: 12px;
            z-index: 80;
            width: fit-content;
            max-width: calc(100% - 28px);
            margin: 18px auto -70px;
            padding: 7px 10px;
            display: flex;
            gap: 4px;
            overflow-x: auto;
            border-radius: 999px;
            background: color-mix(in srgb, var(--fl-primary) 88%, #2b1c12);
            border: 1px solid color-mix(in srgb, var(--fl-gold) 55%, transparent);
            box-shadow: 0 18px 42px rgba(55, 40, 22, .18);
            backdrop-filter: blur(16px);
            scrollbar-width: none;
        }
        .fl-nav::-webkit-scrollbar { display: none; }
        .fl-nav a {
            color: #fff5df;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .fl-nav a:hover { background: rgba(255,255,255,.13); }

        .fl-page {
            position: relative;
            min-height: 960px;
            padding: 116px 42px 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid rgba(46, 55, 66, .10);
            background:
                linear-gradient(180deg, rgba(255,255,255,.74), rgba(255,255,255,.52)),
                var(--fl-page-bg, transparent);
        }

        .fl-page.slim { min-height: auto; padding-top: 94px; padding-bottom: 94px; }
        .fl-page > * { position: relative; z-index: 4; }

        .fl-page::before,
        .fl-page::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .fl-page::before {
            opacity: .58;
            background:
                url("{{ asset('assets/floral-love/floral-corner-rose-gold.png') }}") left top/160px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-corner-rose-gold.png') }}") right top/160px auto no-repeat,
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center bottom/100% auto no-repeat;
        }

        .fl-page::after {
            opacity: .12;
            background: url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top/92% auto no-repeat;
        }

        .fl-title {
            margin: 0;
            color: var(--fl-primary);
            font-family: Georgia, "Times New Roman", serif;
            font-weight: 500;
            letter-spacing: -.035em;
            line-height: .96;
        }

        .fl-script { font-family: Georgia, "Times New Roman", serif; font-style: italic; }

        .fl-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: fit-content;
            margin: 0 auto;
            padding: 9px 18px;
            border-radius: 999px;
            color: var(--fl-primary);
            background: rgba(255,255,255,.72);
            border: 1px solid color-mix(in srgb, var(--fl-gold) 35%, transparent);
            box-shadow: 0 12px 28px rgba(62, 49, 29, .07);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }
        .fl-label::before,
        .fl-label::after { content: ""; width: 22px; height: 1px; background: var(--fl-gold); opacity: .75; }

        .fl-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
            border-radius: 999px;
            padding: 14px 25px;
            min-height: 50px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 950;
            color: #fff8ea;
            background: linear-gradient(135deg, var(--fl-primary), var(--fl-secondary));
            box-shadow: 0 16px 34px color-mix(in srgb, var(--fl-primary) 18%, transparent);
        }
        .fl-btn.gold { color: #442915; background: linear-gradient(135deg, var(--fl-gold-dark), var(--fl-gold), #fff0c4); }
        .fl-btn.light { color: var(--fl-primary); background: rgba(255,255,255,.86); border: 1px solid color-mix(in srgb, var(--fl-gold) 30%, transparent); }
        .fl-btn:hover { transform: translateY(-2px); }

        .fl-btn::after,
        .fl-copy-btn::after {
            content: "";
            position: absolute;
            top: -75%;
            left: -90%;
            width: 52%;
            height: 250%;
            transform: rotate(23deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent);
            animation: flShine 4.2s ease-in-out infinite;
        }

        /* COVER: mendekati page 1 Undangan21 */
        .fl-cover {
            text-align: center;
            justify-content: flex-start;
            padding-top: 116px;
            padding-bottom: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,.70), rgba(255,255,255,.38)),
                radial-gradient(circle at 50% 48%, rgba(255,255,255,.90), transparent 28%),
                linear-gradient(180deg, #fbfaf4, #eef5f3 58%, #fbfaf4);
        }
        .fl-cover::before {
            opacity: .88;
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top/112% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/62% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/62% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 55%/95% auto no-repeat;
        }
        .fl-cover::after {
            opacity: .78;
            background: url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom/112% auto no-repeat;
        }
        .fl-cover-inner { width: min(100%, 520px); margin: 0 auto; padding-top: 210px; }
        .fl-cover-kicker { font-size: 12px; font-weight: 900; letter-spacing: .12em; color: color-mix(in srgb, var(--fl-primary) 75%, #777); text-transform: uppercase; }
        .fl-monogram {
            width: 104px;
            height: 104px;
            margin: 22px auto 18px;
            display: grid;
            place-items: center;
            color: var(--fl-gold-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4.2rem;
            line-height: 1;
            background: radial-gradient(circle at 50% 28%, #fff8df, transparent 56%);
            text-shadow: 0 8px 20px color-mix(in srgb, var(--fl-gold) 26%, transparent);
        }
        .fl-cover-title { font-size: clamp(3.2rem, 9vw, 5.8rem); color: var(--fl-primary); }
        .fl-cover-date { margin-top: 22px; color: #6e665b; font-size: 13px; letter-spacing: .06em; }
        .fl-cover-actions { margin-top: 34px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .fl-cover-bottom-space { flex: 1; min-height: 240px; }

        /* MIRROR PORTRAIT: page 2 feel */
        .fl-mirror-page {
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.74), rgba(255,255,255,.46)),
                repeating-radial-gradient(circle at 50% 20%, rgba(125,154,160,.10) 0 2px, transparent 2px 24px),
                #f8fbf8;
        }
        .fl-mirror-page::before {
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center 64px/72% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left center/54% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right center/54% auto no-repeat;
            opacity: .78;
        }
        .fl-mirror-wrap { width: min(100%, 440px); margin: 42px auto 0; position: relative; }
        .fl-mirror-crown { width: 132px; margin: 0 auto -46px; display: block; position: relative; z-index: 8; filter: drop-shadow(0 16px 22px rgba(110,79,35,.18)); }
        .fl-mirror-frame {
            position: relative;
            padding: 20px;
            border-radius: 999px 999px 46px 46px;
            background: linear-gradient(135deg, color-mix(in srgb, var(--fl-gold) 88%, #fff), #fff9df, color-mix(in srgb, var(--fl-primary) 56%, var(--fl-gold)));
            box-shadow: 0 28px 78px rgba(74, 55, 24, .20), inset 0 0 0 1px rgba(255,255,255,.65);
        }
        .fl-mirror-frame::before {
            content: "";
            position: absolute;
            inset: 12px;
            border: 1px dashed rgba(112,86,44,.28);
            border-radius: 999px 999px 36px 36px;
            pointer-events: none;
            z-index: 5;
        }
        .fl-mirror-photo,
        .fl-mirror-placeholder {
            width: 100%;
            aspect-ratio: 4/5.7;
            display: grid;
            place-items: center;
            object-fit: cover;
            object-position: center;
            border-radius: 999px 999px 34px 34px;
            background: #eff3ef;
            color: var(--fl-primary);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 4rem;
            font-weight: 700;
            box-shadow: inset 0 0 0 8px rgba(255,255,255,.48);
        }
        .fl-mirror-caption { margin-top: 32px; color: var(--fl-primary); }
        .fl-mirror-caption h3 { margin: 8px 0 0; font-size: clamp(2.8rem, 7vw, 4.8rem); }
        .fl-couple-duo { margin-top: 38px; display: grid; gap: 18px; }
        .fl-couple-card {
            padding: 22px;
            border-radius: 999px 999px 30px 30px;
            background: rgba(255,255,255,.76);
            border: 1px solid color-mix(in srgb, var(--fl-gold) 34%, transparent);
            box-shadow: 0 18px 46px rgba(80,64,35,.10);
        }
        .fl-couple-card h4 { font-size: clamp(2rem, 6vw, 3.6rem); margin: 0; }
        .fl-couple-card p { margin: 8px 0 0; color: #675f53; line-height: 1.75; }
        .fl-couple-amp { font-family: Georgia,"Times New Roman",serif; font-style: italic; font-size: 4rem; color: var(--fl-primary); line-height: 1; margin: -6px auto -4px; }

        /* PRECIOUS MOMENT: page 3 feel */
        .fl-moment-page { padding-left: 0; padding-right: 0; text-align: center; justify-content: flex-start; background: #fffdf8; }
        .fl-moment-page::before {
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top/112% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center 78px/76% auto no-repeat;
            opacity: .72;
        }
        .fl-moment-head { padding: 118px 38px 42px; min-height: 310px; display: flex; flex-direction: column; justify-content: center; }
        .fl-chandelier { color: var(--fl-gold-dark); font-size: 52px; line-height: 1; opacity: .75; margin-bottom: 6px; }
        .fl-moment-title { font-size: clamp(2.4rem, 7vw, 4.8rem); }
        .fl-moment-text { margin: 18px auto 0; max-width: 530px; color: #6c665f; line-height: 1.85; }
        .fl-moment-photo-wrap { width: 100%; margin: 0; padding: 0; background: #111; }
        .fl-moment-photo-wrap img,
        .fl-moment-fallback {
            display: block;
            width: 100%;
            min-height: 620px;
            max-height: 840px;
            object-fit: cover;
            object-position: center;
            background: linear-gradient(135deg,#eaf1f0,#fbfaf6);
        }
        .fl-moment-fallback { display: grid; place-items: center; color: var(--fl-primary); font-family: Georgia,"Times New Roman",serif; font-size: 3rem; }

        /* SAVE DATE + DETAIL: page 4 / 7 feel */
        .fl-date-page {
            text-align: center;
            justify-content: flex-start;
            background:
                linear-gradient(180deg, rgba(255,255,255,.50), rgba(255,255,255,.70)),
                #f5faf7;
        }
        .fl-date-page::before {
            background:
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center top/110% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 18%/65% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right 18%/65% auto no-repeat,
                url("{{ asset('assets/floral-love/detail-palace-soft.png') }}") center bottom/100% auto no-repeat;
            opacity: .64;
        }
        .fl-pattern-band { height: 92px; margin: 255px -42px 0; background: color-mix(in srgb, var(--fl-secondary) 36%, #e9f0ed); opacity: .72; }
        .fl-count-panel {
            margin: -28px auto 0;
            width: min(100%, 620px);
            padding: 34px 24px 24px;
            background: color-mix(in srgb, var(--fl-secondary) 36%, #e4ecea);
            color: #fff;
            border-radius: 0 0 34px 34px;
            box-shadow: 0 22px 50px rgba(71,87,83,.12);
        }
        .fl-count-title { font-size: clamp(2.2rem, 6vw, 4rem); color: #fff; text-shadow: 0 10px 22px rgba(0,0,0,.12); }
        .fl-count-grid { margin-top: 24px; display: grid; grid-template-columns: repeat(4,1fr); gap: 0; background: rgba(255,255,255,.90); border-radius: 0; overflow: hidden; }
        .fl-count-card { padding: 16px 8px; color: #6d746f; border-right: 1px solid rgba(80,90,85,.18); }
        .fl-count-card:last-child { border-right: 0; }
        .fl-count-number { display: block; color: color-mix(in srgb, var(--fl-primary) 64%, #777); font-size: clamp(1.5rem, 5vw, 2.4rem); line-height: 1; font-weight: 950; }
        .fl-count-label { display: block; margin-top: 7px; font-size: 10px; font-weight: 950; letter-spacing: .12em; text-transform: uppercase; }
        .fl-contract-card {
            width: min(100%, 560px);
            margin: 110px auto 0;
            padding: 50px 30px;
            border-radius: 44px;
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(255,255,255,.65);
            box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--fl-gold) 25%, transparent), 0 26px 62px rgba(64,52,31,.08);
            backdrop-filter: blur(4px);
        }
        .fl-contract-card h3 { font-size: clamp(2.4rem, 7vw, 4.8rem); color: var(--fl-primary); }
        .fl-contract-line { margin-top: 20px; color: #6b665f; line-height: 1.9; font-weight: 700; }
        .fl-map-wrap { margin-top: 26px; border-radius: 28px; overflow: hidden; border: 1px solid color-mix(in srgb, var(--fl-gold) 34%, transparent); box-shadow: 0 16px 42px rgba(64,52,31,.10); background: #fff; }
        .fl-map-frame,.fl-map-placeholder { display: block; width: 100%; height: 310px; border: 0; text-decoration: none; color: var(--fl-primary); }
        .fl-map-placeholder { display: grid; place-items: center; padding: 24px; text-align: center; background: rgba(255,255,255,.72); }

        /* GALLERY: different mosaic */
        .fl-gallery-page { text-align: center; background: #fffefa; }
        .fl-gallery-page::before {
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top/85% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/58% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/58% auto no-repeat;
            opacity: .55;
        }
        .fl-gallery-grid {
            margin-top: 38px;
            display: grid;
            grid-template-columns: repeat(6,1fr);
            grid-auto-rows: 120px;
            gap: 10px;
        }
        .fl-gallery-item { display: block; overflow: hidden; border-radius: 999px 999px 20px 20px; padding: 6px; background: rgba(255,255,255,.80); border: 1px solid color-mix(in srgb, var(--fl-gold) 28%, transparent); box-shadow: 0 12px 30px rgba(65,50,25,.08); }
        .fl-gallery-item:nth-child(1) { grid-column: span 3; grid-row: span 3; }
        .fl-gallery-item:nth-child(2) { grid-column: span 3; grid-row: span 2; border-radius: 26px; }
        .fl-gallery-item:nth-child(n+3) { grid-column: span 2; grid-row: span 2; }
        .fl-gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit; transition: transform .7s ease; }
        .fl-gallery-item:hover img { transform: scale(1.055); }

        /* GIFT: envelope style, not generic cards */
        .fl-gift-page { text-align: center; background: #fbfbf6; }
        .fl-gift-page::before {
            background:
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/68% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/68% auto no-repeat;
            opacity: .48;
        }
        .fl-gift-grid { margin-top: 38px; display: grid; gap: 18px; }
        .fl-gift-card {
            position: relative;
            overflow: hidden;
            padding: 34px 28px 30px;
            min-height: 200px;
            border-radius: 28px;
            text-align: left;
            background: linear-gradient(145deg, rgba(255,255,255,.86), color-mix(in srgb, var(--fl-paper) 90%, #fff));
            border: 1px solid color-mix(in srgb, var(--fl-gold) 32%, transparent);
            box-shadow: 0 18px 48px rgba(64,52,31,.10);
        }
        .fl-gift-card::before { content:""; position:absolute; inset:auto -20px -62px -20px; height:130px; background: color-mix(in srgb, var(--fl-gold) 18%, transparent); transform: skewY(-7deg); }
        .fl-gift-title { position:relative; color: var(--fl-primary); font-size: 1.35rem; font-weight: 950; }
        .fl-gift-number { position:relative; margin-top: 18px; color: var(--fl-primary); font-size: clamp(1.6rem, 5vw, 2.6rem); font-weight: 900; letter-spacing: .03em; }
        .fl-copy-btn { position:relative; overflow:hidden; margin-top: 18px; border:0; border-radius:999px; padding: 12px 18px; color:#fff8ea; background: var(--fl-primary); font-weight:950; cursor:pointer; }
        .fl-copy-btn.copied { background: #16803c; }

        /* RSVP: page 5/6 feel */
        .fl-rsvp-page { text-align: center; background: #fffefb; }
        .fl-rsvp-page::before {
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top / 92% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left center / 60% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat;
            opacity: .56;
        }
        .fl-rsvp-title { font-family: Inter, ui-sans-serif, system-ui; letter-spacing: .42em; font-weight: 300; font-size: clamp(2.2rem, 7vw, 4.8rem); color: var(--fl-primary); }
        .fl-rsvp-bar { margin: 30px auto; width: min(100%, 560px); padding: 12px 16px; color:#fff8ea; background: var(--fl-gold-dark); font-weight: 950; letter-spacing: .06em; text-transform: uppercase; }
        .fl-rsvp-note { margin: 0 auto 28px; max-width: 520px; color:#777068; line-height:1.75; }
        .fl-form-card { width:min(100%,560px); margin:0 auto; padding: 24px; border-radius: 18px; background: rgba(255,255,255,.78); border:1px solid rgba(113,86,44,.10); box-shadow: 0 16px 44px rgba(64,52,31,.08); text-align:left; }
        .fl-label-form { display:block; color: var(--fl-primary); font-size:12px; font-weight:950; letter-spacing:.12em; text-transform:uppercase; }
        .fl-input { width:100%; margin-top:7px; border:1px solid rgba(113,86,44,.14); background: rgba(255,255,255,.86); color: var(--fl-ink); border-radius: 12px; padding:13px 14px; outline:none; }
        .fl-summary-grid { margin:28px auto 0; width:min(100%,560px); display:grid; grid-template-columns: repeat(3,1fr); gap:10px; }
        .fl-summary-grid > div { padding:16px 10px; border-radius:18px; background:rgba(255,255,255,.72); border:1px solid rgba(113,86,44,.10); }
        .fl-summary-grid b { display:block; color:var(--fl-primary); font-size:2rem; line-height:1; }
        .fl-message-list { margin:28px auto 0; width:min(100%,560px); display:grid; gap:12px; text-align:left; }
        .fl-message-card { padding:18px; border-radius:20px; background:rgba(255,255,255,.78); border:1px solid rgba(113,86,44,.10); box-shadow: 0 12px 30px rgba(64,52,31,.07); }

        .fl-closing-page { text-align:center; background:#fffefb; }
        .fl-closing-page::before {
            background:
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/70% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/70% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat;
            opacity: .64;
        }
        .fl-closing-card { width:min(100%,560px); margin:0 auto; padding:76px 26px 230px; }
        .fl-closing-card h2 { font-size: clamp(2.6rem,8vw,5rem); }
        .fl-closing-photo { width:190px; height:240px; object-fit:cover; border-radius:999px 999px 24px 24px; margin: 0 auto 26px; display:block; border:7px solid #fff; outline:1px solid color-mix(in srgb, var(--fl-gold) 34%, transparent); box-shadow: 0 20px 52px rgba(64,52,31,.12); }

        [data-reveal] { opacity:0; transform: translateY(34px); filter: blur(7px); transition: opacity .85s cubic-bezier(.2,.8,.2,1), transform .85s cubic-bezier(.2,.8,.2,1), filter .85s cubic-bezier(.2,.8,.2,1); transition-delay: var(--reveal-delay,0s); }
        [data-reveal="left"] { transform: translateX(-34px); }
        [data-reveal="right"] { transform: translateX(34px); }
        [data-reveal="zoom"] { transform: translateY(20px) scale(.94); }
        [data-reveal].is-visible { opacity:1; transform: translate(0,0) scale(1); filter: blur(0); }

        @keyframes flShine { 0%,48% { left:-90%; } 75%,100% { left:135%; } }
        @keyframes flFloat { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-8px); } }
        .fl-mirror-crown, .fl-floating-actions a, .fl-floating-actions button { animation: flFloat 4.4s ease-in-out infinite; }

        @media (min-width: 1200px) { .fl-shell { width: min(100%, 820px); } .fl-book { border-radius: 36px; } }
        @media (max-width: 820px) { .fl-shell { padding: 0; } .fl-book { border-radius: 0; border-left: 0; border-right: 0; } .fl-floating-actions { right: 10px; gap:8px; } .fl-floating-actions a,.fl-floating-actions button { width:42px; height:42px; } }
        @media (max-width: 640px) {
            .fl-page { min-height: 100svh; padding: 98px 22px 66px; }
            .fl-page.slim { padding-top: 78px; padding-bottom: 78px; }
            .fl-page::before { background-size: 112px auto, 112px auto, 120% auto; }
            .fl-nav { top: 10px; margin: 12px auto -58px; max-width: calc(100% - 18px); padding: 6px; }
            .fl-nav a { padding: 9px 11px; font-size: 9px; }
            .fl-cover { padding-top: 80px; }
            .fl-cover-inner { padding-top: 150px; }
            .fl-cover-bottom-space { min-height: 210px; }
            .fl-cover::before { background-size: 136% auto, 86% auto, 86% auto, 126% auto; }
            .fl-mirror-wrap { width: min(100%, 340px); }
            .fl-mirror-crown { width: 110px; margin-bottom: -38px; }
            .fl-moment-head { padding: 96px 22px 36px; min-height: 280px; }
            .fl-moment-photo-wrap img, .fl-moment-fallback { min-height: 520px; }
            .fl-pattern-band { margin-left: -22px; margin-right: -22px; margin-top: 210px; }
            .fl-count-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .fl-count-card { padding: 13px 4px; }
            .fl-contract-card { margin-top: 80px; padding: 42px 22px; }
            .fl-gallery-grid { grid-template-columns: 1fr 1fr; grid-auto-rows: 140px; }
            .fl-gallery-item:nth-child(n) { grid-column: span 1; grid-row: span 1; border-radius: 999px 999px 18px 18px; }
            .fl-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
            .fl-summary-grid { grid-template-columns: 1fr; }
            .fl-btn { width:100%; }
        }
        @media (prefers-reduced-motion: reduce) { *,*::before,*::after { animation:none!important; transition:none!important; scroll-behavior:auto!important; } [data-reveal]{ opacity:1!important; transform:none!important; filter:none!important; } }

        /* =====================================================
           FINAL V3 - WIDE LAYOUT FIX WEDDING FLORAL LOVE
           Tujuan:
           - Lebar seperti template lain
           - Tidak terlalu portrait sempit
           - Section bawah tidak monoton
           - Tetap mempertahankan nuansa Undangan21
        ===================================================== */

        .fl-shell {
            width: min(100%, 1180px) !important;
            padding: 24px !important;
        }

        .fl-book {
            border-radius: 34px !important;
            overflow: hidden !important;
        }

        .fl-page {
            min-height: auto !important;
            padding: 100px 68px !important;
            display: block !important;
            border-bottom: 1px solid rgba(96, 76, 45, .10) !important;
        }

        .fl-page.slim {
            padding-top: 92px !important;
            padding-bottom: 92px !important;
        }

        .fl-title {
            text-wrap: balance;
        }

        .fl-rsvp-note,
        .fl-moment-text,
        .fl-contract-line {
            font-size: 1.02rem !important;
            line-height: 1.9 !important;
        }

        /* COVER dibuat lebar, tetap rasa Undangan21 */
        .fl-cover {
            min-height: 860px !important;
            padding: 110px 78px 72px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .fl-cover::before {
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top/92% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/42% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/42% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 58%/76% auto no-repeat !important;
        }

        .fl-cover::after {
            background: url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat !important;
            opacity: .72 !important;
        }

        .fl-cover-inner {
            width: min(100%, 760px) !important;
            padding-top: 90px !important;
            margin: 0 auto !important;
        }

        .fl-cover-title {
            font-size: clamp(4.4rem, 8vw, 7.6rem) !important;
        }

        .fl-cover-bottom-space {
            display: none !important;
        }

        .fl-cover-actions .fl-btn {
            min-width: 190px;
        }

        /* MEMPELAI: foto mirror kiri, biodata kanan */
        .fl-mirror-page {
            display: grid !important;
            grid-template-columns: minmax(310px, .82fr) minmax(0, 1.18fr) !important;
            grid-template-areas:
                "label label"
                "photo title"
                "photo couple" !important;
            gap: 18px 56px !important;
            align-items: center !important;
            text-align: left !important;
            background:
                linear-gradient(180deg, rgba(238,246,244,.50), rgba(234,219,189,.30)),
                radial-gradient(circle at 15% 18%, color-mix(in srgb, var(--fl-gold) 16%, transparent), transparent 26%),
                radial-gradient(circle at 90% 55%, color-mix(in srgb, var(--fl-secondary) 15%, transparent), transparent 28%) !important;
        }

        .fl-mirror-page > .fl-label {
            grid-area: label !important;
            justify-self: center !important;
            text-align: center !important;
        }

        .fl-mirror-wrap {
            grid-area: photo !important;
            width: min(100%, 430px) !important;
            margin: 30px auto 0 !important;
        }

        .fl-mirror-caption {
            grid-area: title !important;
            margin-top: 0 !important;
            max-width: 620px !important;
            color: var(--fl-primary) !important;
        }

        .fl-mirror-caption h3 {
            font-size: clamp(3rem, 5vw, 5.4rem) !important;
            line-height: .98 !important;
        }

        .fl-couple-duo {
            grid-area: couple !important;
            margin-top: 10px !important;
            display: grid !important;
            grid-template-columns: 1fr auto 1fr !important;
            align-items: stretch !important;
            gap: 14px !important;
        }

        .fl-couple-card {
            border-radius: 30px !important;
            padding: 28px !important;
            min-height: 210px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.82), rgba(255,255,255,.62)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--fl-gold) 13%, transparent), transparent 34%) !important;
        }

        .fl-couple-card h4 {
            font-size: clamp(2.1rem, 3.2vw, 3.6rem) !important;
        }

        .fl-couple-amp {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 3.2rem !important;
            margin: 0 !important;
            padding: 0 4px !important;
        }

        /* INVITATION: bukan satu blok kosong */
        #invitation.fl-rsvp-page {
            min-height: 520px !important;
            display: grid !important;
            place-items: center !important;
            text-align: center !important;
            padding-top: 92px !important;
            padding-bottom: 104px !important;
            background:
                radial-gradient(circle at 18% 40%, rgba(127,160,168,.18), transparent 28%),
                radial-gradient(circle at 82% 60%, rgba(214,181,105,.17), transparent 28%),
                linear-gradient(180deg, rgba(247,241,223,.34), rgba(238,246,244,.44)) !important;
        }

        #invitation .fl-rsvp-title,
        #invitation .fl-title {
            max-width: 900px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        #invitation .fl-rsvp-note {
            position: relative !important;
            max-width: 760px !important;
            margin: 26px auto 0 !important;
            padding: 34px 42px !important;
            border-radius: 38px !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.70), rgba(255,255,255,.38)) !important;
            border: 1px solid rgba(174,136,62,.18) !important;
            box-shadow: 0 24px 70px rgba(72,56,28,.09) !important;
            backdrop-filter: blur(8px) !important;
        }

        #invitation .fl-rsvp-note::before,
        #invitation .fl-rsvp-note::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 86px;
            height: 1px;
            background: color-mix(in srgb, var(--fl-gold) 72%, transparent);
        }

        #invitation .fl-rsvp-note::before {
            left: -46px;
        }

        #invitation .fl-rsvp-note::after {
            right: -46px;
        }

        #invitation .fl-rsvp-note {
            max-width: 820px !important;
        }

        /* MOMENT: heading kiri, foto kanan */
        .fl-moment-page {
            display: grid !important;
            grid-template-columns: minmax(280px, .78fr) minmax(420px, 1.22fr) !important;
            gap: 44px !important;
            align-items: center !important;
            text-align: left !important;
            padding: 98px 68px !important;
            background: #fffdf8 !important;
        }

        .fl-moment-page::before {
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") left top/48% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") left 80px/42% auto no-repeat !important;
            opacity: .52 !important;
        }

        .fl-moment-head {
            padding: 0 !important;
            min-height: auto !important;
            display: block !important;
        }

        .fl-moment-title {
            font-size: clamp(3rem, 5vw, 5.8rem) !important;
        }

        .fl-moment-photo-wrap {
            border-radius: 44px !important;
            overflow: hidden !important;
            box-shadow: 0 30px 78px rgba(64,52,31,.16) !important;
            background: #111 !important;
        }

        .fl-moment-photo-wrap img,
        .fl-moment-fallback {
            min-height: 540px !important;
            max-height: 720px !important;
            object-fit: cover !important;
            border-radius: 44px !important;
        }

        /* ACARA: countdown dan detail sejajar */
        .fl-date-page {
            display: grid !important;
            grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr) !important;
            gap: 34px !important;
            align-items: center !important;
            padding: 108px 68px !important;
            text-align: center !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.58), rgba(255,255,255,.70)),
                #f5faf7 !important;
        }

        .fl-date-page::before {
            background:
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center top/82% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/44% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/44% auto no-repeat !important;
            opacity: .54 !important;
        }

        .fl-pattern-band {
            display: none !important;
        }

        .fl-count-panel {
            width: 100% !important;
            margin: 0 !important;
            padding: 42px 26px !important;
            border-radius: 42px !important;
            background:
                linear-gradient(180deg, color-mix(in srgb, var(--fl-secondary) 46%, #e7eeea), color-mix(in srgb, var(--fl-secondary) 32%, #f6f6ef)) !important;
            color: #fff !important;
        }

        .fl-contract-card {
            width: 100% !important;
            margin: 0 !important;
            padding: 52px 34px !important;
            border-radius: 42px !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.82), rgba(255,255,255,.62)),
                url("{{ asset('assets/floral-love/detail-palace-soft.png') }}") center bottom/cover no-repeat !important;
        }

        .fl-map-wrap {
            grid-column: 1 / -1 !important;
            margin-top: 8px !important;
        }

        /* Gallery lebih lebar dan hidup */
        .fl-gallery-grid {
            grid-template-columns: repeat(12, 1fr) !important;
            grid-auto-rows: 105px !important;
            gap: 12px !important;
        }

        .fl-gallery-item:nth-child(1) { grid-column: span 5 !important; grid-row: span 4 !important; }
        .fl-gallery-item:nth-child(2) { grid-column: span 4 !important; grid-row: span 2 !important; border-radius: 34px !important; }
        .fl-gallery-item:nth-child(3) { grid-column: span 3 !important; grid-row: span 2 !important; }
        .fl-gallery-item:nth-child(n+4) { grid-column: span 3 !important; grid-row: span 2 !important; }

        /* Gift dua kolom agar tidak panjang monoton */
        .fl-gift-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 20px !important;
        }

        .fl-gift-card {
            min-height: 220px !important;
            border-radius: 34px !important;
        }

        /* RSVP dibuat dua kolom: teks + form */
        #rsvp.fl-rsvp-page {
            display: grid !important;
            grid-template-columns: minmax(280px, .82fr) minmax(420px, 1.18fr) !important;
            gap: 34px 46px !important;
            align-items: start !important;
            text-align: left !important;
        }

        #rsvp .fl-rsvp-title,
        #rsvp .fl-rsvp-note,
        #rsvp .fl-rsvp-bar {
            grid-column: 1 !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #rsvp .fl-form-card {
            grid-column: 2 !important;
            grid-row: 1 / span 4 !important;
            width: 100% !important;
            max-width: none !important;
        }

        #rsvp .fl-summary-grid,
        #rsvp .fl-message-list {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .fl-rsvp-title {
            letter-spacing: .30em !important;
            font-size: clamp(2.8rem, 4.5vw, 5.4rem) !important;
        }

        /* Closing lebih compact dan rapi */
        .fl-closing-page {
            min-height: 720px !important;
            display: grid !important;
            place-items: center !important;
        }

        .fl-closing-card {
            width: min(100%, 720px) !important;
            padding: 70px 36px 190px !important;
        }

        @media (min-width: 1440px) {
            .fl-shell {
                width: min(100%, 1280px) !important;
            }

            .fl-page {
                padding-left: 86px !important;
                padding-right: 86px !important;
            }

            .fl-cover-title {
                font-size: clamp(5rem, 7vw, 8.4rem) !important;
            }
        }

        @media (max-width: 980px) {
            .fl-shell {
                width: min(100%, 860px) !important;
                padding: 14px !important;
            }

            .fl-page {
                padding: 84px 36px !important;
            }

            .fl-mirror-page,
            .fl-moment-page,
            .fl-date-page,
            #rsvp.fl-rsvp-page {
                display: block !important;
                text-align: center !important;
            }

            .fl-mirror-caption {
                margin-top: 28px !important;
            }

            .fl-couple-duo {
                grid-template-columns: 1fr !important;
                margin-top: 26px !important;
            }

            .fl-couple-amp {
                min-height: 58px !important;
            }

            .fl-moment-head {
                text-align: center !important;
                margin-bottom: 34px !important;
            }

            .fl-count-panel,
            .fl-contract-card {
                margin: 0 auto 26px !important;
            }

            #rsvp .fl-rsvp-title,
            #rsvp .fl-rsvp-note,
            #rsvp .fl-rsvp-bar,
            #rsvp .fl-form-card,
            #rsvp .fl-summary-grid,
            #rsvp .fl-message-list {
                grid-column: auto !important;
                grid-row: auto !important;
                width: min(100%, 620px) !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .fl-gift-grid {
                grid-template-columns: 1fr !important;
            }

            .fl-gallery-grid {
                grid-template-columns: repeat(6, 1fr) !important;
            }

            .fl-gallery-item:nth-child(1) { grid-column: span 3 !important; grid-row: span 3 !important; }
            .fl-gallery-item:nth-child(2) { grid-column: span 3 !important; grid-row: span 2 !important; }
            .fl-gallery-item:nth-child(n+3) { grid-column: span 2 !important; grid-row: span 2 !important; }
        }

        @media (max-width: 640px) {
            .fl-mirror-page {
                padding: 86px 22px 76px !important;
            }

            .fl-mirror-caption {
                padding: 26px 22px 20px !important;
                text-align: center !important;
            }

            .fl-couple-card,
            .fl-couple-card:nth-child(3) {
                border-radius: 28px !important;
                min-height: auto !important;
            }

            #invitation.fl-rsvp-page {
                min-height: auto !important;
                padding: 76px 22px 86px !important;
            }

            #invitation .fl-rsvp-note {
                padding: 26px 22px !important;
            }

            #invitation .fl-rsvp-note::before,
            #invitation .fl-rsvp-note::after {
                display: none !important;
            }
            .fl-shell {
                padding: 0 !important;
            }

            .fl-book {
                border-radius: 0 !important;
            }

            .fl-page,
            .fl-page.slim {
                padding: 72px 22px !important;
            }

            .fl-cover {
                min-height: 760px !important;
                padding: 86px 22px 58px !important;
            }

            .fl-cover::before {
                background:
                    url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top/122% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/74% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/74% auto no-repeat,
                    url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 58%/115% auto no-repeat !important;
            }

            .fl-cover-inner {
                padding-top: 130px !important;
            }

            .fl-cover-title {
                font-size: clamp(3.2rem, 14vw, 5.2rem) !important;
            }

            .fl-cover-actions {
                flex-direction: column !important;
            }

            .fl-cover-actions .fl-btn {
                width: 100% !important;
            }

            .fl-mirror-wrap {
                width: min(100%, 360px) !important;
            }

            .fl-mirror-photo,
            .fl-mirror-placeholder {
                aspect-ratio: 4 / 5.2 !important;
            }

            .fl-moment-photo-wrap img,
            .fl-moment-fallback {
                min-height: 390px !important;
                max-height: 540px !important;
                border-radius: 28px !important;
            }

            .fl-moment-photo-wrap {
                border-radius: 28px !important;
            }

            .fl-count-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .fl-count-card {
                border-right: 0 !important;
                border-bottom: 1px solid rgba(80,90,85,.14) !important;
            }

            .fl-gallery-grid {
                grid-template-columns: 1fr !important;
                grid-auto-rows: auto !important;
            }

            .fl-gallery-item,
            .fl-gallery-item:nth-child(n) {
                grid-column: auto !important;
                grid-row: auto !important;
                height: 270px !important;
            }

            .fl-rsvp-title {
                text-align: center !important;
                letter-spacing: .22em !important;
            }

            .fl-floating-actions {
                right: 10px !important;
            }
        }



        /* =====================================================
           FINAL V4 - CLEAN CONTINUOUS WIDE LAYOUT
           Fokus:
           - background nyambung antar section
           - tidak terpotong per section
           - layout lebih rapi dan stabil
           - floating actions mepet kanan
        ===================================================== */

        html,
        body {
            overflow-x: hidden !important;
        }

        body {
            background:
                radial-gradient(circle at 8% 10%, color-mix(in srgb, var(--fl-secondary) 12%, transparent), transparent 26%),
                radial-gradient(circle at 92% 8%, color-mix(in srgb, var(--fl-gold) 14%, transparent), transparent 25%),
                linear-gradient(180deg, #e9dfcc 0%, #fbf8ef 34%, #edf4f2 67%, #e9dfcc 100%) !important;
        }

        .fl-shell {
            width: min(100%, 1240px) !important;
            padding: 26px !important;
        }

        .fl-book {
            position: relative !important;
            border-radius: 36px !important;
            overflow: hidden !important;
            background:
                linear-gradient(180deg, #f7f1df 0%, #eef6f4 30%, #eadbbd 58%, #eef6f4 100%) !important;
            box-shadow: 0 34px 120px rgba(56, 45, 27, .17) !important;
        }

        .fl-book::before {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 0 !important;
            pointer-events: none !important;
            opacity: .72 !important;
            background:
                url("{{ asset('assets/floral-love/floral-corner-rose-gold.png') }}") left top/210px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-corner-rose-gold.png') }}") right top/210px auto no-repeat,
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 0/88% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 16%/390px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right 16%/390px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 46%/420px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right 46%/420px auto no-repeat,
                url("{{ asset('assets/floral-love/detail-palace-soft.png') }}") center 63%/100% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 88%/430px auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right 88%/430px auto no-repeat,
                linear-gradient(90deg, rgba(120,150,156,.035) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, rgba(120,150,156,.028) 1px, transparent 1px) 0 0/42px 42px !important;
        }

        .fl-book::after {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 1 !important;
            pointer-events: none !important;
            opacity: .26 !important;
            background:
                radial-gradient(circle at 18% 22%, rgba(127, 160, 168, .18), transparent 24%),
                radial-gradient(circle at 82% 38%, rgba(214, 181, 105, .16), transparent 26%),
                radial-gradient(circle at 18% 68%, rgba(127, 160, 168, .16), transparent 25%),
                radial-gradient(circle at 82% 86%, rgba(214, 181, 105, .15), transparent 25%);
        }

        .fl-book > * {
            position: relative !important;
            z-index: 3 !important;
        }

        .fl-page,
        .fl-page.slim,
        .fl-cover,
        .fl-mirror-page,
        .fl-moment-page,
        .fl-date-page,
        .fl-gallery-page,
        .fl-gift-page,
        .fl-rsvp-page,
        .fl-closing-page {
            background: transparent !important;
            border-bottom: 0 !important;
        }

        .fl-page {
            position: relative !important;
            min-height: auto !important;
            padding: 104px 76px !important;
            overflow: hidden !important;
        }

        .fl-page + .fl-page {
            margin-top: -1px !important;
        }

        .fl-page::before,
        .fl-page::after {
            pointer-events: none !important;
        }

        .fl-page::before {
            opacity: .25 !important;
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top/70% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat !important;
        }

        .fl-page::after {
            opacity: .20 !important;
            background:
                linear-gradient(
                    180deg,
                    transparent 0%,
                    rgba(238,246,244,.34) 22%,
                    rgba(234,219,189,.24) 62%,
                    transparent 100%
                ) !important;
        }

        .fl-page > * {
            position: relative !important;
            z-index: 5 !important;
        }

        .fl-label {
            margin-bottom: 18px !important;
            background: rgba(255,255,255,.84) !important;
            backdrop-filter: blur(8px) !important;
        }

        .fl-title,
        .fl-rsvp-title {
            text-wrap: balance !important;
        }

        .fl-rsvp-note,
        .fl-moment-text,
        .fl-contract-line,
        .fl-couple-card p {
            line-height: 1.88 !important;
        }

        /* Floating action benar-benar mepet kanan */
        .fl-floating-actions {
            right: 0 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 999 !important;
            gap: 8px !important;
            padding: 8px 0 8px 8px !important;
            border-radius: 18px 0 0 18px !important;
            background: rgba(255,255,255,.70) !important;
            border: 1px solid rgba(160,124,58,.18) !important;
            border-right: 0 !important;
            box-shadow: 0 18px 42px rgba(70, 54, 28, .12) !important;
            backdrop-filter: blur(14px) !important;
        }

        .fl-floating-actions a,
        .fl-floating-actions button {
            width: 42px !important;
            height: 42px !important;
            border-radius: 16px 0 0 16px !important;
            background: rgba(255,255,255,.94) !important;
            box-shadow: 0 10px 22px rgba(70,54,28,.10) !important;
        }

        .fl-floating-actions a:hover,
        .fl-floating-actions button:hover {
            transform: translateX(-3px) !important;
        }

        /* Cover lebih clean, tidak terlalu penuh */
        .fl-cover {
            min-height: 790px !important;
            padding: 118px 76px 94px !important;
            display: grid !important;
            place-items: center !important;
            text-align: center !important;
        }

        .fl-cover::before {
            opacity: .70 !important;
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center 18px/72% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/34% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/34% auto no-repeat,
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 50%/64% auto no-repeat !important;
        }

        .fl-cover::after {
            opacity: .20 !important;
        }

        .fl-cover-inner {
            width: min(100%, 720px) !important;
            padding: 130px 32px 70px !important;
            margin: 0 auto !important;
            border-radius: 42px !important;
            background: radial-gradient(circle at 50% 50%, rgba(255,255,255,.74), rgba(255,255,255,.20) 68%, transparent 100%) !important;
        }

        .fl-cover-title {
            font-size: clamp(4rem, 7vw, 7.4rem) !important;
            line-height: .95 !important;
        }

        .fl-cover-bottom-space {
            display: none !important;
        }

        /* Mempelai rapi: image dan teks tidak saling tabrak */
        .fl-mirror-page {
            padding: 118px 82px 96px !important;
            display: grid !important;
            grid-template-columns: minmax(320px, .78fr) minmax(0, 1.22fr) !important;
            grid-template-areas:
                "label label"
                "photo title"
                "photo couple" !important;
            gap: 30px 64px !important;
            align-items: center !important;
            text-align: left !important;
            background:
                radial-gradient(circle at 14% 42%, rgba(127,160,168,.18), transparent 30%),
                radial-gradient(circle at 86% 52%, rgba(214,181,105,.16), transparent 28%),
                linear-gradient(135deg, rgba(238,246,244,.62), rgba(247,241,223,.48), rgba(234,219,189,.34)) !important;
        }

        .fl-mirror-page > .fl-label {
            grid-area: label !important;
            justify-self: center !important;
        }

        .fl-mirror-wrap {
            grid-area: photo !important;
            width: min(100%, 430px) !important;
            margin: 0 auto !important;
            padding: 18px !important;
            border-radius: 999px 999px 46px 46px !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.72), rgba(255,255,255,.30)) !important;
            box-shadow: 0 28px 80px rgba(72,56,28,.13) !important;
        }

        .fl-mirror-frame {
            padding: 14px !important;
            border-radius: 999px 999px 34px 34px !important;
        }

        .fl-mirror-photo,
        .fl-mirror-placeholder {
            aspect-ratio: 4 / 5.05 !important;
            border-radius: 999px 999px 26px 26px !important;
        }

        .fl-mirror-caption {
            grid-area: title !important;
            margin: 0 !important;
            max-width: 700px !important;
            padding: 34px 38px 24px !important;
            border-radius: 36px !important;
            background:
                linear-gradient(135deg, rgba(255,255,255,.52), rgba(255,255,255,.18)) !important;
            border: 1px solid rgba(174,136,62,.13) !important;
            box-shadow: 0 18px 56px rgba(72,56,28,.07) !important;
        }

        .fl-mirror-caption h3 {
            font-size: clamp(3rem, 4.8vw, 5.3rem) !important;
            line-height: .98 !important;
        }

        .fl-couple-duo {
            grid-area: couple !important;
            display: grid !important;
            grid-template-columns: 1fr auto 1fr !important;
            gap: 18px !important;
            align-items: stretch !important;
            margin-top: 16px !important;
        }

        .fl-couple-card {
            position: relative !important;
            overflow: hidden !important;
            min-height: 210px !important;
            padding: 30px 28px !important;
            border-radius: 34px 34px 90px 34px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.82), rgba(255,255,255,.48)) !important;
            border: 1px solid rgba(174,136,62,.22) !important;
            box-shadow: 0 22px 58px rgba(72,56,28,.10) !important;
            backdrop-filter: blur(8px) !important;
        }

        .fl-couple-card:nth-child(3) {
            border-radius: 34px 34px 34px 90px !important;
        }

        .fl-couple-card::before {
            content: "";
            position: absolute;
            inset: auto -20px -54px -20px;
            height: 110px;
            background: color-mix(in srgb, var(--fl-gold) 16%, transparent);
            transform: rotate(-5deg);
            pointer-events: none;
        }

        .fl-couple-card h4 {
            font-size: clamp(2.1rem, 3.1vw, 3.4rem) !important;
        }

        .fl-couple-amp {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            font-size: 3rem !important;
        }

        /* Invitation dibuat sebagai panel, bukan section kosong */
        #invitation {
            min-height: 420px !important;
            display: grid !important;
            place-items: center !important;
            text-align: center !important;
        }

        #invitation::before {
            opacity: .36 !important;
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top/54% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/28% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/28% auto no-repeat !important;
        }

        #invitation > * {
            width: min(100%, 860px) !important;
        }

        /* Moment: tidak terpotong, image proporsional */
        .fl-moment-page {
            display: grid !important;
            grid-template-columns: minmax(280px, .78fr) minmax(420px, 1.22fr) !important;
            gap: 48px !important;
            align-items: center !important;
            text-align: left !important;
        }

        .fl-moment-head {
            padding: 0 !important;
            min-height: auto !important;
        }

        .fl-moment-title {
            font-size: clamp(3rem, 4.6vw, 5.5rem) !important;
            line-height: .98 !important;
        }

        .fl-moment-photo-wrap {
            width: 100% !important;
            border-radius: 38px !important;
            overflow: hidden !important;
            box-shadow: 0 28px 70px rgba(64,52,31,.14) !important;
        }

        .fl-moment-photo-wrap img,
        .fl-moment-fallback {
            width: 100% !important;
            min-height: 500px !important;
            max-height: 650px !important;
            object-fit: cover !important;
            border-radius: 0 !important;
        }

        /* Acara: dua kolom dan map nyambung */
        .fl-date-page {
            display: grid !important;
            grid-template-columns: minmax(0, .92fr) minmax(0, 1.08fr) !important;
            gap: 30px !important;
            align-items: stretch !important;
        }

        .fl-date-page::before {
            opacity: .42 !important;
            background:
                url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center top/74% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/34% auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/34% auto no-repeat !important;
        }

        .fl-pattern-band {
            display: none !important;
        }

        .fl-count-panel,
        .fl-contract-card {
            width: 100% !important;
            margin: 0 !important;
            border-radius: 34px !important;
        }

        .fl-count-panel {
            padding: 42px 26px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            background: linear-gradient(180deg, color-mix(in srgb, var(--fl-secondary) 44%, #e7eeea), color-mix(in srgb, var(--fl-secondary) 30%, #f7f2e7)) !important;
        }

        .fl-contract-card {
            padding: 48px 32px !important;
            background: rgba(255,255,255,.72) !important;
            backdrop-filter: blur(7px) !important;
        }

        .fl-map-wrap {
            grid-column: 1 / -1 !important;
            margin-top: 4px !important;
            border-radius: 30px !important;
            background: rgba(255,255,255,.80) !important;
            box-shadow: 0 20px 54px rgba(64,52,31,.08) !important;
        }

        /* Gift dan RSVP lebih stabil */
        .fl-gift-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 22px !important;
        }

        .fl-gift-card {
            min-height: 205px !important;
            border-radius: 30px !important;
        }

        #rsvp {
            display: grid !important;
            grid-template-columns: minmax(280px, .82fr) minmax(420px, 1.18fr) !important;
            gap: 28px 46px !important;
            align-items: start !important;
            text-align: left !important;
        }

        #rsvp .fl-rsvp-title,
        #rsvp .fl-rsvp-note,
        #rsvp .fl-rsvp-bar {
            grid-column: 1 !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        #rsvp .fl-form-card {
            grid-column: 2 !important;
            grid-row: 1 / span 4 !important;
            width: 100% !important;
            max-width: none !important;
            background: rgba(255,255,255,.76) !important;
            backdrop-filter: blur(7px) !important;
        }

        #rsvp .fl-summary-grid,
        #rsvp .fl-message-list {
            grid-column: 1 / -1 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .fl-rsvp-title {
            font-size: clamp(2.7rem, 4vw, 5rem) !important;
            letter-spacing: .30em !important;
        }

        .fl-summary-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .fl-closing-page {
            min-height: 680px !important;
            display: grid !important;
            place-items: center !important;
        }

        .fl-closing-card {
            width: min(100%, 720px) !important;
            padding: 64px 32px 150px !important;
        }

        @media (min-width: 1440px) {
            .fl-shell {
                width: min(100%, 1320px) !important;
            }
            .fl-page {
                padding-left: 92px !important;
                padding-right: 92px !important;
            }
        }

        @media (max-width: 980px) {
            .fl-shell {
                width: min(100%, 860px) !important;
                padding: 12px !important;
            }
            .fl-book {
                border-radius: 26px !important;
            }
            .fl-page,
            .fl-page.slim {
                padding: 82px 36px !important;
            }
            .fl-mirror-page,
            .fl-moment-page,
            .fl-date-page,
            #rsvp {
                display: block !important;
                text-align: center !important;
            }
            .fl-mirror-caption {
                margin-top: 26px !important;
            }
            .fl-couple-duo {
                grid-template-columns: 1fr !important;
                margin-top: 26px !important;
            }
            .fl-couple-amp {
                min-height: 54px !important;
            }
            .fl-moment-head {
                text-align: center !important;
                margin-bottom: 30px !important;
            }
            .fl-moment-photo-wrap img,
            .fl-moment-fallback {
                min-height: 420px !important;
            }
            .fl-count-panel,
            .fl-contract-card {
                margin: 0 auto 24px !important;
            }
            #rsvp .fl-rsvp-title,
            #rsvp .fl-rsvp-note,
            #rsvp .fl-rsvp-bar,
            #rsvp .fl-form-card,
            #rsvp .fl-summary-grid,
            #rsvp .fl-message-list {
                grid-column: auto !important;
                grid-row: auto !important;
                width: min(100%, 650px) !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .fl-gift-grid {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            .fl-shell {
                padding: 0 !important;
            }
            .fl-book {
                border-radius: 0 !important;
                border-left: 0 !important;
                border-right: 0 !important;
            }
            .fl-book::before {
                opacity: .56 !important;
                background:
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 8%/82% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right 30%/82% auto no-repeat,
                    url("{{ asset('assets/floral-love/detail-palace-soft.png') }}") center 62%/140% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left 92%/88% auto no-repeat,
                    linear-gradient(90deg, rgba(120,150,156,.025) 1px, transparent 1px) 0 0/34px 34px !important;
            }
            .fl-page,
            .fl-page.slim {
                padding: 72px 22px !important;
            }
            .fl-cover {
                min-height: 760px !important;
                padding: 82px 22px 60px !important;
            }
            .fl-cover::before {
                background:
                    url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top/122% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom/78% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom/78% auto no-repeat,
                    url("{{ asset('assets/floral-love/palace-fountain-soft.png') }}") center 58%/116% auto no-repeat !important;
            }
            .fl-cover-inner {
                padding: 132px 10px 60px !important;
                background: radial-gradient(circle at 50% 50%, rgba(255,255,255,.66), transparent 72%) !important;
            }
            .fl-cover-title {
                font-size: clamp(3.1rem, 14vw, 5.1rem) !important;
            }
            .fl-cover-actions {
                flex-direction: column !important;
            }
            .fl-cover-actions .fl-btn,
            .fl-btn {
                width: 100% !important;
            }
            .fl-mirror-wrap {
                width: min(100%, 355px) !important;
            }
            .fl-mirror-photo,
            .fl-mirror-placeholder {
                aspect-ratio: 4 / 5.15 !important;
            }
            .fl-moment-photo-wrap,
            .fl-moment-photo-wrap img,
            .fl-moment-fallback {
                border-radius: 28px !important;
            }
            .fl-moment-photo-wrap img,
            .fl-moment-fallback {
                min-height: 380px !important;
                max-height: 520px !important;
            }
            .fl-date-page {
                padding-top: 78px !important;
            }
            .fl-count-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .fl-count-card {
                border-right: 0 !important;
                border-bottom: 1px solid rgba(80,90,85,.14) !important;
            }
            .fl-summary-grid {
                grid-template-columns: 1fr !important;
            }
            .fl-rsvp-title {
                text-align: center !important;
                letter-spacing: .20em !important;
            }
            .fl-floating-actions {
                right: 0 !important;
                gap: 6px !important;
            }
            .fl-floating-actions a,
            .fl-floating-actions button {
                width: 40px !important;
                height: 40px !important;
            }
        }

        /* =====================================================
        HERO FIX ONLY - Floral Love
        Fokus: gambar hero tidak terpotong desktop & mobile
        ===================================================== */

        .fl-cover {
            position: relative !important;
            min-height: clamp(720px, 86vh, 920px) !important;
            padding: 96px 72px 82px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            text-align: center !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.50), rgba(255,255,255,.34)),
                radial-gradient(circle at 50% 50%, rgba(255,255,255,.84), rgba(255,255,255,.35) 38%, transparent 68%) !important;
        }

        /* Matikan style background lama yang membuat gambar terpotong */
        .fl-cover::before {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            z-index: 1 !important;
            pointer-events: none !important;
            opacity: .86 !important;

            background-image:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}"),
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}"),
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") !important;


            background-repeat:
                no-repeat,
                no-repeat,
                no-repeat,
                no-repeat !important;

            background-position:
                center 18px,
                left bottom,
                right bottom,
                center 52% !important;

            background-size:
                min(920px, 82%) auto,
                min(520px, 42%) auto,
                min(520px, 42%) auto,
                min(820px, 70%) auto !important;
        }

        /* Layer bunga bawah/palace agar tidak memotong frame utama */
        .fl-cover::after {
            content: "" !important;
            position: absolute !important;
            inset: auto 0 0 0 !important;
            height: 34% !important;
            z-index: 2 !important;
            pointer-events: none !important;
            opacity: .38 !important;
            background:
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / min(980px, 86%) auto no-repeat !important;
        }

        /* Panel teks dibuat lebih aman, tidak menabrak frame */
        .fl-cover-inner {
            position: relative !important;
            z-index: 5 !important;
            width: min(100%, 760px) !important;
            margin: 0 auto !important;
            padding: clamp(96px, 13vw, 150px) 32px 48px !important;
            border-radius: 48px !important;
            background:
                radial-gradient(circle at 50% 48%, rgba(255,255,255,.82), rgba(255,255,255,.38) 62%, transparent 78%) !important;
        }

        .fl-cover-title {
            font-size: clamp(4rem, 7vw, 7.4rem) !important;
            line-height: .94 !important;
            max-width: 760px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .fl-cover-date {
            margin-top: 28px !important;
        }

        .fl-cover-actions {
            margin-top: 38px !important;
            display: flex !important;
            justify-content: center !important;
            gap: 18px !important;
            flex-wrap: wrap !important;
        }

        .fl-cover-actions .fl-btn {
            width: auto !important;
            min-width: 210px !important;
        }

        /* Desktop besar */
        @media (min-width: 1440px) {
            .fl-cover {
                min-height: 900px !important;
            }

            .fl-cover::before {
                background-size:
                    min(1040px, 78%) auto,
                    min(600px, 40%) auto,
                    min(600px, 40%) auto,
                    min(920px, 66%) auto !important;

                background-position:
                    center 18px,
                    left bottom,
                    right bottom,
                    center 52% !important;
            }
        }

        /* Tablet */
        @media (max-width: 980px) {
            .fl-cover {
                min-height: 760px !important;
                padding: 82px 34px 66px !important;
            }

            .fl-cover::before {
                background-size:
                    min(760px, 104%) auto,
                    min(460px, 62%) auto,
                    min(460px, 62%) auto,
                    min(700px, 92%) auto !important;

                background-position:
                    center 8px,
                    left bottom,
                    right bottom,
                    center 52% !important;
            }

            .fl-cover-inner {
                padding-top: clamp(118px, 22vw, 165px) !important;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .fl-cover {
                min-height: 100svh !important;
                padding: 76px 24px 58px !important;
                border-radius: 0 0 28px 28px !important;
            }

            .fl-cover::before {
                opacity: .92 !important;

                background-image:
                    url("{{ asset('assets/floral-love/reception-door-frame.png') }}"),
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") !important;

                background-repeat:
                    no-repeat,
                    no-repeat !important;

                background-position:
                    center 0,
                    right bottom !important;

                background-size:
                    128% auto,
                    88% auto !important;
            }

            .fl-cover::after {
                height: 30% !important;
                opacity: .30 !important;
                background-size: 120% auto !important;
            }

            .fl-cover-inner {
                width: 100% !important;
                padding: 142px 8px 34px !important;
                border-radius: 30px !important;
                background:
                    radial-gradient(circle at 50% 48%, rgba(255,255,255,.78), rgba(255,255,255,.36) 64%, transparent 82%) !important;
            }

            .fl-cover-title {
                font-size: clamp(3.25rem, 15vw, 5.2rem) !important;
                line-height: .96 !important;
            }

            .fl-cover-date {
                margin-top: 24px !important;
                font-size: 13px !important;
            }

            .fl-cover-actions {
                margin-top: 34px !important;
                gap: 14px !important;
            }

            .fl-cover-actions .fl-btn {
                width: 100% !important;
                min-width: 0 !important;
            }
        }

        /* Mobile kecil */
        @media (max-width: 430px) {
            .fl-cover::before {
                background-image:
                    url("{{ asset('assets/floral-love/reception-door-frame.png') }}"),
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") !important;

                background-repeat:
                    no-repeat,
                    no-repeat !important;

                background-position:
                    center 0,
                    right bottom !important;

                background-size:
                    136% auto,
                    96% auto !important;
            }

            .fl-cover-inner {
                padding-top: 150px !important;
            }
        }
        /* =====================================================
        HERO BACKGROUND BLEND FIX
        Menghilangkan area putih kosong dan menyatukan image hero
        ===================================================== */

        .fl-cover {
            background:
                linear-gradient(180deg, rgba(247,242,229,.88), rgba(237,244,242,.82)),
                radial-gradient(circle at 50% 48%, rgba(246,241,226,.62), rgba(226,237,236,.48) 42%, rgba(232,221,196,.40) 72%),
                color-mix(in srgb, var(--fl-paper) 72%, #dfecea) !important;
        }

        /* Background utama dibuat lebih penuh, tidak terlalu transparan */
        .fl-cover-bg {
            opacity: 1 !important;
            background:
                url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center 14px / min(980px, 82%) auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom / min(620px, 44%) auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom / min(620px, 44%) auto no-repeat,
                linear-gradient(180deg, #f7f1df 0%, #edf5f3 52%, #e6d8b9 100%) !important;
        }

        /* Layer ini sebelumnya membuat area putih. Ganti jadi tint lembut, bukan putih */
        .fl-cover-overlay {
            opacity: .56 !important;
            background:
                linear-gradient(180deg, rgba(225,209,166,.20), transparent 28%, rgba(140,170,176,.16) 64%, rgba(213,185,119,.18) 100%),
                radial-gradient(circle at 50% 45%, rgba(255,250,236,.28), transparent 34%),
                radial-gradient(circle at 20% 68%, rgba(134,166,174,.22), transparent 23%),
                radial-gradient(circle at 82% 70%, rgba(213,178,96,.20), transparent 24%),
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / min(1080px, 92%) auto no-repeat !important;
        }

        /* Hilangkan efek kotak putih besar di tengah */
        .fl-cover-inner {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* Tambahkan shadow halus hanya di belakang teks, bukan bidang putih */
        .fl-cover-inner::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: min(760px, 92%);
            height: 68%;
            transform: translate(-50%, -48%);
            z-index: -1;
            pointer-events: none;
            border-radius: 999px;
            background:
                radial-gradient(circle at center,
                    rgba(255,250,235,.46) 0%,
                    rgba(255,250,235,.28) 38%,
                    rgba(255,250,235,.10) 62%,
                    transparent 78%
                );
            filter: blur(6px);
        }

        /* Biar bagian bawah tidak terlihat putih kosong */
        .fl-cover::after {
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 42%;
            z-index: 2;
            pointer-events: none;
            opacity: .42 !important;
            background:
                linear-gradient(180deg, transparent, rgba(216,196,146,.20) 56%, rgba(157,183,187,.20)),
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / min(1080px, 92%) auto no-repeat !important;
        }

        /* Biar hiasan atas kiri-kanan lebih menyatu */
        .fl-cover-corner-left,
        .fl-cover-corner-right {
            opacity: .55 !important;
            mix-blend-mode: multiply;
        }

        /* Desktop besar: background diperbesar agar mengisi area */
        @media (min-width: 1280px) {
            .fl-cover-bg {
                background-size:
                    min(1080px, 84%) auto,
                    min(700px, 48%) auto,
                    min(700px, 48%) auto,
                    min(1040px, 78%) auto,
                    auto !important;

                background-position:
                    center 8px,
                    left bottom,
                    right bottom,
                    center 54%,
                    center !important;
            }
        }

        /* Mobile: jangan ada putih besar di kanan/kiri */
        @media (max-width: 640px) {
            .fl-cover {
                background:
                    linear-gradient(180deg, #f7f1df 0%, #edf5f3 58%, #e8dcc0 100%) !important;
            }

            .fl-cover-bg {
                background:
                    url("{{ asset('assets/floral-love/reception-door-frame.png') }}") center top / 136% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom / 92% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom / 92% auto no-repeat,
                    linear-gradient(180deg, #f7f1df 0%, #edf5f3 58%, #e8dcc0 100%) !important;
            }

            .fl-cover-overlay {
                opacity: .50 !important;
                background:
                    linear-gradient(180deg, rgba(218,196,134,.18), transparent 30%, rgba(130,165,174,.18) 66%, rgba(212,181,105,.20)),
                    radial-gradient(circle at 50% 42%, rgba(255,250,236,.22), transparent 36%),
                    url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 124% auto no-repeat !important;
            }

            .fl-cover-inner::before {
                width: 108%;
                height: 58%;
                background:
                    radial-gradient(circle at center,
                        rgba(255,250,235,.34) 0%,
                        rgba(255,250,235,.18) 46%,
                        transparent 76%
                    );
            }
        }

        /* =====================================================
        COUPLE SHOWCASE FIX
        Section mempelai lebih rapi, tidak double, lebih mewah
        ===================================================== */

        .fl-couple-showcase {
            min-height: 780px !important;
            padding: 108px 86px 112px !important;
            display: grid !important;
            grid-template-columns: minmax(320px, .82fr) minmax(0, 1.18fr) !important;
            grid-template-areas:
                "heading heading"
                "photo couple" !important;
            gap: 46px 72px !important;
            align-items: center !important;
            text-align: left !important;
        }

        .fl-couple-showcase .fl-couple-heading {
            grid-area: heading !important;
            width: min(100%, 780px) !important;
            margin: 0 auto 4px !important;
            text-align: center !important;
        }

        .fl-couple-showcase .fl-couple-heading .fl-label {
            margin-bottom: 16px !important;
        }

        .fl-couple-showcase .fl-couple-heading h2 {
            font-size: clamp(3.2rem, 5vw, 6.4rem) !important;
            line-height: .9 !important;
            margin: 0 !important;
        }

        .fl-couple-showcase .fl-couple-heading p:not(.fl-label) {
            max-width: 620px !important;
            margin: 20px auto 0 !important;
            color: #6f665a !important;
            line-height: 1.85 !important;
        }

        .fl-couple-showcase .fl-mirror-wrap {
            grid-area: photo !important;
            width: min(100%, 430px) !important;
            margin: 0 auto !important;
            padding: 18px !important;
            border-radius: 999px 999px 44px 44px !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.78), rgba(255,255,255,.34)) !important;
            box-shadow: 0 30px 90px rgba(72,56,28,.15) !important;
        }

        .fl-couple-showcase .fl-mirror-frame {
            padding: 14px !important;
            border-radius: 999px 999px 34px 34px !important;
        }

        .fl-couple-showcase .fl-mirror-photo {
            aspect-ratio: 4 / 5.05 !important;
            border-radius: 999px 999px 26px 26px !important;
        }

        .fl-couple-showcase .fl-couple-duo {
            grid-area: couple !important;
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 18px !important;
            margin: 0 !important;
            max-width: 620px !important;
        }

        .fl-couple-showcase .fl-couple-card {
            position: relative !important;
            overflow: hidden !important;
            min-height: 190px !important;
            padding: 30px 34px !important;
            border-radius: 38px !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.84), rgba(255,255,255,.48)) !important;
            border: 1px solid rgba(174,136,62,.20) !important;
            box-shadow: 0 22px 60px rgba(72,56,28,.10) !important;
            backdrop-filter: blur(8px) !important;
        }

        .fl-couple-showcase .fl-couple-card::before {
            content: "";
            position: absolute;
            inset: auto -30px -60px -30px;
            height: 120px;
            background: color-mix(in srgb, var(--fl-gold) 16%, transparent);
            transform: rotate(-4deg);
            pointer-events: none;
        }

        .fl-couple-showcase .fl-couple-card h4 {
            font-size: clamp(2.4rem, 3.6vw, 4.2rem) !important;
            line-height: .92 !important;
            margin: 0 !important;
        }

        .fl-couple-showcase .fl-couple-card p {
            position: relative !important;
            margin-top: 16px !important;
            color: #6a6258 !important;
            line-height: 1.75 !important;
        }

        .fl-person-tag {
            display: inline-flex;
            width: fit-content;
            margin-bottom: 14px;
            padding: 7px 13px;
            border-radius: 999px;
            color: var(--fl-primary);
            background: color-mix(in srgb, var(--fl-gold) 18%, rgba(255,255,255,.78));
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .fl-couple-showcase .fl-couple-amp {
            width: 54px !important;
            height: 54px !important;
            margin: -4px auto !important;
            display: grid !important;
            place-items: center !important;
            border-radius: 999px !important;
            color: var(--fl-primary) !important;
            background: rgba(255,255,255,.72) !important;
            border: 1px solid rgba(174,136,62,.18) !important;
            box-shadow: 0 14px 34px rgba(72,56,28,.08) !important;
            font-size: 2rem !important;
            line-height: 1 !important;
        }

        /* Tablet & mobile */
        @media (max-width: 980px) {
            .fl-couple-showcase {
                display: block !important;
                padding: 88px 34px 92px !important;
                text-align: center !important;
            }

            .fl-couple-showcase .fl-mirror-wrap {
                margin: 34px auto !important;
            }

            .fl-couple-showcase .fl-couple-duo {
                max-width: 620px !important;
                margin: 0 auto !important;
            }

            .fl-person-tag {
                margin-left: auto;
                margin-right: auto;
            }

            .fl-couple-showcase .fl-couple-card {
                text-align: center !important;
            }
        }

        @media (max-width: 640px) {
            .fl-couple-showcase {
                padding: 78px 22px 82px !important;
            }

            .fl-couple-showcase .fl-couple-heading h2 {
                font-size: clamp(3rem, 14vw, 4.8rem) !important;
            }

            .fl-couple-showcase .fl-couple-card {
                padding: 28px 22px !important;
                border-radius: 30px !important;
            }

            .fl-couple-showcase .fl-couple-card h4 {
                font-size: clamp(2.4rem, 12vw, 3.6rem) !important;
            }
        }

        /* =====================================================
        COUPLE DUO PHOTO
        Foto mempelai diambil dari people photo / fallback cover
        ===================================================== */

        .fl-couple-duo .fl-person-card {
            display: grid !important;
            grid-template-columns: 118px minmax(0, 1fr) !important;
            gap: 22px !important;
            align-items: center !important;
            padding: 22px 26px !important;
            min-height: 190px !important;
        }

        .fl-person-photo {
            position: relative;
            width: 118px;
            height: 150px;
            padding: 6px;
            border-radius: 999px 999px 26px 26px;
            background:
                linear-gradient(145deg, color-mix(in srgb, var(--fl-gold) 72%, #fff), rgba(255,255,255,.86));
            box-shadow: 0 18px 38px rgba(72,56,28,.13);
            overflow: hidden;
        }

        .fl-person-photo::after {
            content: "";
            position: absolute;
            inset: 11px;
            border: 1px solid rgba(255,255,255,.60);
            border-radius: 999px 999px 20px 20px;
            pointer-events: none;
        }

        .fl-person-photo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
            border-radius: 999px 999px 22px 22px;
        }

        .fl-person-info {
            min-width: 0;
            position: relative;
            z-index: 2;
        }

        .fl-person-tag {
            display: inline-flex;
            width: fit-content;
            margin-bottom: 10px;
            padding: 7px 12px;
            border-radius: 999px;
            color: var(--fl-primary);
            background: color-mix(in srgb, var(--fl-gold) 18%, rgba(255,255,255,.78));
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .fl-couple-duo .fl-person-card h4 {
            font-size: clamp(2rem, 3vw, 3.35rem) !important;
            line-height: .94 !important;
        }

        .fl-couple-duo .fl-person-card p {
            margin-top: 12px !important;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .fl-couple-duo .fl-person-card {
                grid-template-columns: 1fr !important;
                justify-items: center !important;
                text-align: center !important;
                padding: 26px 22px !important;
            }

            .fl-person-photo {
                width: 140px;
                height: 176px;
            }

            .fl-person-tag {
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* =====================================================
        HERO PREVIEW TOP SPACE FIX
        Tambah ruang atas agar hero tidak terlihat terpotong di preview
        ===================================================== */

        .fl-cover {
            padding-top: 300px !important;
            min-height: clamp(780px, 88vh, 960px) !important;
        }

        .fl-cover::before {
            background-position:
                center 58px,
                left bottom,
                right bottom !important;
        }

        .fl-cover-inner {
            padding-top: clamp(120px, 13vw, 170px) !important;
        }

        /* Preview/card biasanya mengambil tampilan kecil, jadi tablet-mobile juga perlu diturunkan */
        @media (max-width: 980px) {
            .fl-cover {
                padding-top: 120px !important;
                min-height: 800px !important;
            }

            .fl-cover::before {
                background-position:
                    center 42px,
                    left bottom,
                    right bottom !important;
            }

            .fl-cover-inner {
                padding-top: clamp(128px, 22vw, 178px) !important;
            }
        }

        @media (max-width: 640px) {
            .fl-cover {
                padding-top: 108px !important;
                min-height: 820px !important;
            }

            .fl-cover::before {
                background-position:
                    center 34px,
                    left bottom,
                    right bottom !important;
            }

            .fl-cover-inner {
                padding-top: 160px !important;
            }
        }

        @media (max-width: 430px) {
            .fl-cover::before {
                background-position:
                    center 32px,
                    left bottom,
                    right bottom !important;
            }

            .fl-cover-inner {
                padding-top: 168px !important;
            }
        }

        /* =====================================================
        INVITATION SECTION POLISH
        Perbaiki susunan "Dengan Penuh Cinta"
        ===================================================== */

        #invitation.fl-rsvp-page {
            position: relative !important;
            min-height: 560px !important;
            padding: 110px 76px 118px !important;
            display: grid !important;
            place-items: center !important;
            text-align: center !important;
            overflow: hidden !important;
        }

        #invitation.fl-rsvp-page::before {
            opacity: .46 !important;
            background:
                url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center 28px / min(620px, 56%) auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom / min(430px, 34%) auto no-repeat,
                url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom / min(430px, 34%) auto no-repeat,
                url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat !important;
        }

        #invitation.fl-rsvp-page::after {
            opacity: .28 !important;
            background:
                radial-gradient(circle at 50% 48%, rgba(255,255,255,.64), transparent 36%),
                radial-gradient(circle at 18% 70%, rgba(127,160,168,.16), transparent 24%),
                radial-gradient(circle at 82% 70%, rgba(214,181,105,.14), transparent 24%) !important;
        }

        #invitation > .fl-label {
            margin-bottom: 22px !important;
            padding: 9px 34px !important;
            min-width: 260px !important;
            justify-self: center !important;
        }

        #invitation h2 {
            width: min(100%, 760px) !important;
            margin: 0 auto !important;
            font-size: clamp(3.4rem, 6.2vw, 6.6rem) !important;
            line-height: .92 !important;
            letter-spacing: -.055em !important;
        }

        #invitation .fl-rsvp-note {
            position: relative !important;
            width: min(100%, 760px) !important;
            max-width: 760px !important;
            margin: 34px auto 0 !important;
            padding: 38px 58px !important;
            border-radius: 44px !important;
            color: #676157 !important;
            font-size: 1.05rem !important;
            line-height: 2 !important;
            background:
                linear-gradient(145deg, rgba(255,255,255,.78), rgba(255,255,255,.42)) !important;
            border: 1px solid rgba(174,136,62,.16) !important;
            box-shadow:
                0 26px 76px rgba(72,56,28,.09),
                inset 0 0 0 1px rgba(255,255,255,.46) !important;
            backdrop-filter: blur(10px) !important;
        }

        #invitation .fl-rsvp-note::before,
        #invitation .fl-rsvp-note::after {
            content: "" !important;
            position: absolute !important;
            top: 50% !important;
            width: 96px !important;
            height: 1px !important;
            background: linear-gradient(90deg, transparent, var(--fl-gold), transparent) !important;
            opacity: .72 !important;
        }

        #invitation .fl-rsvp-note::before {
            left: -78px !important;
        }

        #invitation .fl-rsvp-note::after {
            right: -78px !important;
        }

        /* Mobile */
        @media (max-width: 640px) {
            #invitation.fl-rsvp-page {
                min-height: auto !important;
                padding: 82px 22px 92px !important;
            }

            #invitation.fl-rsvp-page::before {
                background:
                    url("{{ asset('assets/floral-love/floral-top-vine-soft.png') }}") center top / 112% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft.png') }}") left bottom / 76% auto no-repeat,
                    url("{{ asset('assets/floral-love/floral-side-soft-mirror.png') }}") right bottom / 76% auto no-repeat,
                    url("{{ asset('assets/floral-love/palace-silhouette-bottom.png') }}") center bottom / 100% auto no-repeat !important;
                opacity: .38 !important;
            }

            #invitation > .fl-label {
                min-width: 0 !important;
                width: fit-content !important;
                padding: 8px 22px !important;
            }

            #invitation h2 {
                font-size: clamp(3rem, 13vw, 4.8rem) !important;
                line-height: .95 !important;
            }

            #invitation .fl-rsvp-note {
                width: 100% !important;
                margin-top: 26px !important;
                padding: 28px 22px !important;
                border-radius: 30px !important;
                font-size: .95rem !important;
                line-height: 1.9 !important;
            }

            #invitation .fl-rsvp-note::before,
            #invitation .fl-rsvp-note::after {
                display: none !important;
            }
        }

        /* =====================================================
        EVENT DETAIL CARD POLISH
        Membuat Marriage Contract lebih elegan dan rapi
        ===================================================== */

        .fl-event-detail-card {
            position: relative !important;
            overflow: hidden !important;
            min-height: 520px !important;
            padding: 56px 54px 48px !important;
            border-radius: 46px !important;
            text-align: center !important;
            background:
                radial-gradient(circle at 50% 0%, rgba(214,181,105,.16), transparent 30%),
                linear-gradient(145deg, rgba(255,255,255,.90), rgba(255,255,255,.54)) !important;
            border: 1px solid rgba(174,136,62,.22) !important;
            box-shadow:
                0 30px 86px rgba(72,56,28,.11),
                inset 0 0 0 1px rgba(255,255,255,.56) !important;
            backdrop-filter: blur(10px) !important;
        }

        .fl-event-detail-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 34px;
            border: 1px solid rgba(174,136,62,.16);
            pointer-events: none;
        }

        .fl-event-detail-card::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 22px;
            width: 84px;
            height: 84px;
            transform: translateX(-50%);
            opacity: .16;
            background:
                radial-gradient(circle, var(--fl-gold) 0 2px, transparent 3px),
                radial-gradient(circle, transparent 42%, var(--fl-gold) 43%, transparent 46%);
            pointer-events: none;
        }

        .fl-event-mini-label {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding: 8px 18px;
            border-radius: 999px;
            color: var(--fl-primary);
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(174,136,62,.18);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .fl-event-mini-label::before,
        .fl-event-mini-label::after {
            content: "";
            width: 20px;
            height: 1px;
            background: var(--fl-gold);
            opacity: .75;
        }

        .fl-event-detail-card h3 {
            position: relative !important;
            z-index: 2 !important;
            margin: 0 auto 34px !important;
            max-width: 560px !important;
            font-size: clamp(3.2rem, 4.8vw, 5.8rem) !important;
            line-height: .88 !important;
            letter-spacing: -.045em !important;
        }

        .fl-event-detail-list {
            position: relative;
            z-index: 2;
            width: min(100%, 560px);
            margin: 0 auto;
            display: grid;
            gap: 13px;
            text-align: left;
        }

        .fl-event-detail-item {
            display: grid;
            grid-template-columns: 44px minmax(0, 1fr);
            gap: 14px;
            align-items: center;
            padding: 15px 18px;
            border-radius: 24px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.72), rgba(255,255,255,.38));
            border: 1px solid rgba(174,136,62,.13);
            box-shadow: 0 12px 30px rgba(72,56,28,.055);
        }

        .fl-event-detail-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            color: var(--fl-primary);
            background: color-mix(in srgb, var(--fl-gold) 24%, rgba(255,255,255,.80));
            border: 1px solid rgba(174,136,62,.18);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 1.15rem;
        }

        .fl-event-detail-item small {
            display: block;
            margin-bottom: 4px;
            color: color-mix(in srgb, var(--fl-primary) 68%, #888);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .fl-event-detail-item strong {
            display: block;
            color: #5f574e;
            font-size: 1rem;
            line-height: 1.55;
            font-weight: 850;
        }

        .fl-map-detail-btn {
            position: relative !important;
            z-index: 2 !important;
            margin-top: 30px !important;
            min-width: 190px !important;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .fl-event-detail-card {
                min-height: auto !important;
                padding: 42px 22px 38px !important;
                border-radius: 34px !important;
            }

            .fl-event-detail-card::before {
                inset: 12px;
                border-radius: 26px;
            }

            .fl-event-detail-card h3 {
                font-size: clamp(2.9rem, 13vw, 4.6rem) !important;
                margin-bottom: 28px !important;
            }

            .fl-event-detail-list {
                gap: 11px;
            }

            .fl-event-detail-item {
                grid-template-columns: 38px minmax(0, 1fr);
                gap: 12px;
                padding: 14px;
                border-radius: 20px;
            }

            .fl-event-detail-icon {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }

            .fl-event-detail-item strong {
                font-size: .94rem;
            }
        }

        /* =====================================================
        FLORAL LOVE HERO NAME RESPONSIVE FIX
        Nama pasangan mengikuti Data Mempelai dan tidak terpotong
        ===================================================== */

        .fl-cover-couple-name {
            width: min(100%, 760px) !important;
            max-width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;

            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: center !important;
            gap: .12em .22em !important;

            font-size: clamp(2.6rem, 6.4vw, 6.4rem) !important;
            line-height: .94 !important;
            letter-spacing: -.045em !important;

            overflow-wrap: normal !important;
            word-break: normal !important;
            white-space: normal !important;
            text-align: center !important;
        }

        .fl-cover-couple-name span {
            display: inline-block !important;
            max-width: 100% !important;
            overflow-wrap: anywhere !important;
            word-break: normal !important;
            white-space: normal !important;
        }

        .fl-cover-couple-name .fl-cover-amp {
            flex: 0 0 auto !important;
            font-size: .78em !important;
            line-height: .9 !important;
            margin: 0 .02em !important;
            color: var(--fl-gold-dark) !important;
            letter-spacing: -.02em !important;
        }

        /* Kalau nama terlalu panjang, tetap aman di tablet */
        @media (max-width: 820px) {
            .fl-cover-couple-name {
                width: min(100%, 620px) !important;
                font-size: clamp(2.25rem, 9vw, 4.6rem) !important;
                line-height: .96 !important;
                gap: .08em .18em !important;
            }
        }

        /* Mobile preview/editor */
        @media (max-width: 640px) {
            .fl-cover-couple-name {
                width: 100% !important;
                font-size: clamp(2.05rem, 11vw, 3.9rem) !important;
                line-height: .98 !important;
                letter-spacing: -.035em !important;
                padding: 0 4px !important;
                gap: .05em .16em !important;
            }

            .fl-cover-couple-name .fl-cover-amp {
                font-size: .68em !important;
            }
        }

        /* Mobile kecil */
        @media (max-width: 430px) {
            .fl-cover-couple-name {
                font-size: clamp(1.85rem, 10.5vw, 3.35rem) !important;
                line-height: 1 !important;
                letter-spacing: -.03em !important;
            }
        }

        .fl-cover-couple-name.is-stacked {
            flex-direction: column !important;
            gap: 4px !important;
        }

        .fl-cover-couple-name.is-stacked .fl-cover-amp {
            line-height: .75 !important;
            margin: -2px 0 !important;
        }

</style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'gold';
    if ($themeColor === 'golden') { $themeColor = 'gold'; }

    $flThemes = [
        'maroon' => ['primary'=>'#673029','secondary'=>'#8f4f3c','gold'=>'#d9b56a','goldDark'=>'#a97834','paper'=>'#fff3e5','ink'=>'#3f2c23','rose'=>'#e9b8a5'],
        'emerald' => ['primary'=>'#164f43','secondary'=>'#32775f','gold'=>'#d9b56a','goldDark'=>'#a97834','paper'=>'#f7fff8','ink'=>'#203d35','rose'=>'#e6b8a7'],
        'navy' => ['primary'=>'#243047','secondary'=>'#495c7e','gold'=>'#d9b56a','goldDark'=>'#a97834','paper'=>'#f7f9ff','ink'=>'#20283a','rose'=>'#e8bbad'],
        'rose' => ['primary'=>'#8d3b52','secondary'=>'#b66b7b','gold'=>'#d9b56a','goldDark'=>'#a97834','paper'=>'#fff3f6','ink'=>'#432a33','rose'=>'#f0aebe'],
        'gold' => ['primary'=>'#6a461f','secondary'=>'#9b6b28','gold'=>'#d6a846','goldDark'=>'#8c641c','paper'=>'#fff8e8','ink'=>'#493816','rose'=>'#e8baa2'],
        'slate' => ['primary'=>'#374151','secondary'=>'#64748b','gold'=>'#d6a846','goldDark'=>'#8c641c','paper'=>'#f8fafc','ink'=>'#1f2937','rose'=>'#d9b3a3'],
    ];
    $flTheme = $flThemes[$themeColor] ?? $flThemes['gold'];

    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $secondPhoto = $photos->skip(1)->first() ?: $firstPhoto;
    $thirdPhoto = $photos->skip(2)->first() ?: $firstPhoto;
    $people = ($invitation->people ?? collect())->values();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();

    $eventTitle = $invitation->title ?: 'Design & Preset';
    $eventName = $invitation->event_name ?: 'The Wedding Of';
    $hostName = $invitation->host_name ?: 'Keluarga Besar';

    $bride = $people->get(0);
    $groom = $people->get(1);
    $brideName = $bride->name ?? (str_contains($eventTitle, '&') ? trim(explode('&', $eventTitle)[0]) : 'Alina');
    $groomName = $groom->name ?? (str_contains($eventTitle, '&') ? trim(explode('&', $eventTitle)[1] ?? 'Aldian') : 'Aldian');
    $monogram = strtoupper(\Illuminate\Support\Str::substr($brideName, 0, 1) . \Illuminate\Support\Str::substr($groomName, 0, 1));

    $personPhotoUrl = function ($person, $fallback) {
        $path = $person->photo ?? $person->image ?? null;

        if (!$path) {
            return $fallback;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $shareUrl = route('invitation.public', $invitation->slug);
    $startDate = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date) : null;
    $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date) : null;

    $eventDateText = $startDate ? $startDate->translatedFormat('d F Y') : 'Tanggal belum diatur';
    $eventDateShort = $startDate ? $startDate->translatedFormat('d • m • Y') : 'Tanggal belum diatur';
    $eventDayText = $startDate ? $startDate->translatedFormat('l') : 'Hari belum diatur';
    $eventDateRangeText = $eventDateText;

    if ($startDate && $endDate) {
        if ($startDate->isSameDay($endDate)) { $eventDateRangeText = $startDate->translatedFormat('d F Y'); }
        elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) { $eventDateRangeText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y'); }
        elseif ($startDate->format('Y') === $endDate->format('Y')) { $eventDateRangeText = $startDate->translatedFormat('d F') . ' - ' . $endDate->translatedFormat('d F Y'); }
        else { $eventDateRangeText = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y'); }
    }

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }

    $locationText = $invitation->location_name ?: 'Lokasi acara belum diatur';
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

    $coverPhoto = $invitation->cover_image ? asset('storage/' . $invitation->cover_image) : null;
    $defaultCover = asset('assets/floral-love/pasangan.png');
    $coverDisplay = $coverPhoto ?: $defaultCover;

    $bridePhoto = $personPhotoUrl($bride, $coverDisplay);
    $groomPhoto = $personPhotoUrl($groom, $coverDisplay);

    $momentPhotoUrl = $thirdPhoto ? asset('storage/' . $thirdPhoto->image_path) : $coverDisplay;
    $closingPhoto = $secondPhoto ? asset('storage/' . $secondPhoto->image_path) : $coverDisplay;
@endphp

<body style="--fl-primary: {{ $flTheme['primary'] }}; --fl-secondary: {{ $flTheme['secondary'] }}; --fl-gold: {{ $flTheme['gold'] }}; --fl-gold-dark: {{ $flTheme['goldDark'] }}; --fl-paper: {{ $flTheme['paper'] }}; --fl-ink: {{ $flTheme['ink'] }}; --fl-rose: {{ $flTheme['rose'] }};">
    <div class="fl-floating-actions">
        <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan"></a>
        <button type="button" id="music-toggle" title="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music"></button>
        <button type="button" id="scroll-toggle" title="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll"></button>
        @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi"></a>@endif
    </div>

    <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}" preload="auto" loop></audio>

    <main class="fl-shell">
        <div class="fl-book">
            <section id="cover" class="fl-page fl-cover pt-4">
                <div class="fl-cover-inner" data-reveal="zoom">
                    <div class="fl-cover-kicker">{{ $eventName }}</div>
                    <h1 class="fl-title fl-script fl-cover-title fl-cover-couple-name is-stacked">
                        <span>{{ $brideName }}</span>
                        <span class="fl-cover-amp">&</span>
                        <span>{{ $groomName }}</span>
                    </h1>
                    <div class="fl-cover-date responsive-text">{{ $eventDayText }}, {{ $eventDateText }}</div>
                    <div class="fl-cover-actions">
                        <a href="#mempelai" class="fl-btn gold">Buka Undangan</a>
                        <a href="#acara" class="fl-btn light">Save the Date</a>
                    </div>
                </div>
                <div class="fl-cover-bottom-space"></div>
            </section>

            <section id="mempelai" class="fl-page fl-mirror-page fl-couple-showcase">
                <div class="fl-couple-heading" data-reveal="zoom">
                    <p class="fl-label">Bride & Groom</p>
                    <h2 class="fl-title fl-script responsive-text">Mempelai</h2>
                    <p class="responsive-text">
                        Dengan penuh cinta dan doa, kami memperkenalkan kedua mempelai yang akan memulai perjalanan baru bersama.
                    </p>
                </div>

                <div class="fl-mirror-wrap" data-reveal="left" style="--reveal-delay:.08s">
                    <div class="fl-mirror-frame">
                        <img src="{{ $coverDisplay }}" alt="Foto Mempelai" class="fl-mirror-photo">
                    </div>
                </div>

                <div class="fl-couple-duo">
                    <div class="fl-couple-card fl-person-card" data-reveal="left">
                        <div class="fl-person-photo">
                            <img src="{{ $bridePhoto }}" alt="Foto {{ $brideName }}">
                        </div>

                        <div class="fl-person-info">
                            <h4 class="fl-title fl-script responsive-text">{{ $brideName }}</h4>
                            <p class="responsive-text">
                                <strong>{{ $bride->subtitle ?? 'Mempelai Wanita' }}</strong><br>
                                {{ $bride->family_name ?? 'Putri dari keluarga tercinta' }}
                            </p>
                        </div>
                    </div>

                    <div class="fl-couple-amp" data-reveal="zoom">&amp;</div>

                    <div class="fl-couple-card fl-person-card" data-reveal="right">
                        <div class="fl-person-photo">
                            <img src="{{ $groomPhoto }}" alt="Foto {{ $groomName }}">
                        </div>

                        <div class="fl-person-info">
                            <h4 class="fl-title fl-script responsive-text">{{ $groomName }}</h4>
                            <p class="responsive-text">
                                <strong>{{ $groom->subtitle ?? 'Mempelai Pria' }}</strong><br>
                                {{ $groom->family_name ?? 'Putra dari keluarga tercinta' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="invitation" class="fl-page slim fl-rsvp-page">
                <p class="fl-label" data-reveal="zoom">Invitation</p>
                <h2 class="fl-title fl-script responsive-text mt-6" data-reveal="zoom" style="font-size:clamp(2.7rem,8vw,5.2rem); --reveal-delay:.08s">Dengan Penuh Cinta</h2>
                <p class="responsive-text fl-rsvp-note mt-6" data-reveal="zoom" style="--reveal-delay:.16s">
                    {{ $invitation->description ?: 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami. Kehadiran dan doa restu Anda merupakan kebahagiaan yang sangat berarti bagi kami.' }}
                </p>
            </section>

            <section id="moment" class="fl-page fl-moment-page">
                <div class="fl-moment-head">
                    <div class="fl-chandelier" data-reveal="zoom">✦</div>
                    <h2 class="fl-title fl-script fl-moment-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Precious Moment</h2>
                    <p class="responsive-text fl-moment-text" data-reveal="zoom" style="--reveal-delay:.16s">Creating memories is a priceless gift. Memories last a lifetime, objects last only a short time.</p>
                </div>
                <div class="fl-moment-photo-wrap" data-reveal="zoom">
                    @if ($momentPhotoUrl)
                        <img src="{{ $momentPhotoUrl }}" alt="Precious Moment">
                    @else
                        <div class="fl-moment-fallback">{{ $monogram }}</div>
                    @endif
                </div>
            </section>

            <section id="acara" class="fl-page fl-date-page">
                <div class="fl-pattern-band"></div>
                <div class="fl-count-panel" data-reveal="zoom">
                    <h2 class="fl-title fl-script fl-count-title responsive-text">Save the Date</h2>
                    <div class="fl-count-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                        <div class="fl-count-card"><span class="fl-count-number" data-unit="days">00</span><span class="fl-count-label">Days</span></div>
                        <div class="fl-count-card"><span class="fl-count-number" data-unit="hours">00</span><span class="fl-count-label">Hours</span></div>
                        <div class="fl-count-card"><span class="fl-count-number" data-unit="minutes">00</span><span class="fl-count-label">Minutes</span></div>
                        <div class="fl-count-card"><span class="fl-count-number" data-unit="seconds">00</span><span class="fl-count-label">Seconds</span></div>
                    </div>
                    <p class="responsive-text mt-4">{{ $eventDateRangeText }}</p>
                    @if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="fl-btn light mt-5">Tambah ke Kalender</a>@endif
                </div>

                <div class="fl-contract-card fl-event-detail-card" data-reveal="zoom">
                    <span class="fl-event-mini-label">Wedding Ceremony</span>

                    <h3 class="fl-title fl-script responsive-text">Marriage<br>Contract</h3>

                    <div class="fl-event-detail-list">
                        <div class="fl-event-detail-item">
                            <span class="fl-event-detail-icon"><img src="{{ asset('assets/icons/Tanggal.png') }}" alt="tanggal" class="w-6 h-6"></span>
                            <div>
                                <small>Tanggal</small>
                                <strong class="responsive-text">{{ $eventDateRangeText }}</strong>
                            </div>
                        </div>

                        @if ($eventTimeText)
                            <div class="fl-event-detail-item">
                                <span class="fl-event-detail-icon"><img src="{{ asset('assets/icons/Waktu.png') }}" alt="waktu" class="w-6 h-6"></span>
                                <div>
                                    <small>Waktu Acara</small>
                                    <strong class="responsive-text">Pukul {{ $eventTimeText }}</strong>
                                </div>
                            </div>
                        @endif

                        <div class="fl-event-detail-item">
                            <span class="fl-event-detail-icon"><img src="{{ asset('assets/icons/Lokasi.png') }}" alt="tempat" class="w-6 h-6"></span>
                            <div>
                                <small>Tempat</small>
                                <strong class="responsive-text">{{ $locationText }}</strong>
                            </div>
                        </div>

                        <div class="fl-event-detail-item">
                            <span class="fl-event-detail-icon"><img src="{{ asset('assets/icons/Peta.png') }}" alt="alamat" class="w-6 h-6"></span>
                            <div>
                                <small>Alamat</small>
                                <strong class="responsive-text">{{ $addressText }}</strong>
                            </div>
                        </div>
                    </div>

                    @if ($mapOpenUrl)
                        <a href="{{ $mapOpenUrl }}" target="_blank" class="fl-btn gold fl-map-detail-btn">Buka Maps</a>
                    @endif
                </div>

                @if ($mapEmbedUrl || $mapOpenUrl)
                    <div class="fl-map-wrap" data-reveal="zoom">
                        @if ($mapEmbedUrl)
                            <iframe class="fl-map-frame" src="{{ $mapEmbedUrl }}" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="fl-map-placeholder"><span class="responsive-text">📍<br><strong>{{ $locationText }}</strong><br>{{ $addressText }}<br><br>Buka Google Maps →</span></a>
                        @endif
                    </div>
                @endif
            </section>

            @if ($photos->count())
                <section id="gallery" class="fl-page slim fl-gallery-page">
                    <p class="fl-label" data-reveal="zoom">Gallery</p>
                    <h2 class="fl-title fl-script responsive-text mt-6" data-reveal="zoom" style="font-size:clamp(2.7rem,8vw,5.2rem); --reveal-delay:.08s">Our Story Gallery</h2>
                    <div class="fl-gallery-grid">
                        @foreach ($photos as $index => $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="fl-gallery-item" data-reveal="zoom" style="--reveal-delay: {{ min($index * .05, .30) }}s"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Pernikahan"></a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($gifts->count())
                <section id="gift" class="fl-page slim fl-gift-page">
                    <p class="fl-label" data-reveal="zoom">Wedding Gift</p>
                    <h2 class="fl-title fl-script responsive-text mt-6" data-reveal="zoom" style="font-size:clamp(2.7rem,8vw,5.2rem); --reveal-delay:.08s">Blessing Gift</h2>
                    <p class="responsive-text fl-rsvp-note mt-6" data-reveal="zoom" style="--reveal-delay:.16s">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                    <div class="fl-gift-grid">
                        @foreach ($gifts as $index => $gift)
                            <div class="fl-gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .06, .30) }}s">
                                <div class="fl-gift-title responsive-text">{{ $gift->label ?: 'Wedding Gift' }}</div>
                                <div class="fl-gift-number responsive-text">{{ $gift->account_number ?: '-' }}</div>
                                <p class="responsive-text mt-2" style="position:relative;color:#6c665f;">{{ $gift->account_name ?: 'Atas nama penerima' }}</p>
                                @if ($gift->account_number)<button type="button" class="fl-copy-btn" data-copy="{{ $gift->account_number }}">Salin Nomor</button>@endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="rsvp" class="fl-page fl-rsvp-page">
                <h2 class="fl-rsvp-title responsive-text" data-reveal="zoom">RSVP</h2>
                <p class="responsive-text fl-rsvp-note" data-reveal="zoom" style="--reveal-delay:.08s">Silakan kirim ucapan dan konfirmasi kehadiran Anda.</p>
                <div class="fl-rsvp-bar" data-reveal="zoom" style="--reveal-delay:.16s">Reservation Reply</div>

                @if (session('message_success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>@endif
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5 text-left"><p class="font-bold">Mohon periksa kembali isian:</p><ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif

                <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="fl-form-card space-y-4" data-reveal="zoom">
                    @csrf
                    <div><label class="fl-label-form">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="fl-input" placeholder="Nama lengkap" required></div>
                    <div><label class="fl-label-form">Konfirmasi Kehadiran</label><select name="attendance_status" class="fl-input"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                    <div><label class="fl-label-form">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="fl-input"></div>
                    <div><label class="fl-label-form">Ucapan / Doa</label><textarea name="message" rows="4" class="fl-input" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                    <button type="submit" class="w-full fl-btn gold">Submit Now</button>
                </form>

                <div class="fl-summary-grid">
                    <div data-reveal="zoom"><b>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</b><span>Tidak Hadir</span></div>
                    <div data-reveal="zoom" style="--reveal-delay:.06s"><b>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><span>Hadir</span></div>
                    <div data-reveal="zoom" style="--reveal-delay:.12s"><b>{{ $messages->where('attendance_status', 'ragu')->count() }}</b><span>Ragu</span></div>
                </div>

                <div class="fl-message-list">
                    @forelse ($messages as $index => $message)
                        <div class="fl-message-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * .04, .24) }}s">
                            <div class="flex items-start justify-between gap-3"><div><p class="responsive-text font-black" style="color:var(--fl-primary);">{{ $message->guest_name }}</p><p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="text-xs font-black px-3 py-1 rounded-full" style="background:#fff1dd;color:var(--fl-primary);">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                            <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                        </div>
                    @empty
                        <div class="fl-message-card text-center" data-reveal="zoom"><p class="text-slate-500">Belum ada ucapan.</p></div>
                    @endforelse
                </div>
            </section>

            <section id="closing" class="fl-page fl-closing-page">
                <div class="fl-closing-card" data-reveal="zoom">
                    @if ($closingPhoto)<img src="{{ $closingPhoto }}" alt="Foto Penutup" class="fl-closing-photo">@endif
                    <p class="fl-label">Thank You</p>
                    <h2 class="fl-title fl-script responsive-text mt-8">Terima Kasih</h2>
                    <p class="responsive-text fl-rsvp-note mt-6">Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
                    <h3 class="fl-title fl-script responsive-text mt-8" style="font-size:clamp(2.2rem,7vw,4.8rem);">{{ $eventTitle }}</h3>
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
            const scrollSpeed = 1.25;

            function setScrollIcon(active) {
                if (!scrollToggle || !scrollIcon) return;
                scrollToggle.classList.toggle('is-active', active);
                scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
            }
            function stopAutoScroll() {
                autoScrollActive = false;
                if (autoScrollFrame) { cancelAnimationFrame(autoScrollFrame); autoScrollFrame = null; }
                setScrollIcon(false);
            }
            function autoScrollStep() {
                if (!autoScrollActive) return;
                const maxY = document.documentElement.scrollHeight - window.innerHeight;
                const nextY = Math.min(window.scrollY + scrollSpeed, maxY);
                window.scrollTo({ top: nextY, behavior: 'auto' });
                if (nextY >= maxY) { stopAutoScroll(); return; }
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }
            function startAutoScroll() { stopAutoScroll(); autoScrollActive = true; setScrollIcon(true); autoScrollFrame = requestAnimationFrame(autoScrollStep); }
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

            document.querySelectorAll('.fl-copy-btn').forEach(function (button) {
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
            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';
                if (!['input','textarea','select','option'].includes(tagName)) event.preventDefault();
            });
            document.addEventListener('dragstart', function (event) { event.preventDefault(); });
            document.addEventListener('keydown', function (event) {
                const key = event.key ? event.key.toLowerCase() : '';
                const blocked = event.key === 'F12' || (event.ctrlKey && event.shiftKey && ['i','j','c'].includes(key)) || (event.ctrlKey && ['u','s','p'].includes(key)) || (event.metaKey && event.altKey && ['i','j','c'].includes(key)) || (event.metaKey && ['u','s','p'].includes(key));
                if (blocked) { event.preventDefault(); event.stopPropagation(); return false; }
            });
        });
    </script>
</body>
</html>
