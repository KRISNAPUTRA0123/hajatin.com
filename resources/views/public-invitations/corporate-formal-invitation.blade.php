<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Corporate Formal Invitation') . ' ' . ($invitation->title ?: 'Corporate Formal Invitation'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--news-dark);
            background:
                radial-gradient(circle at top left, var(--news-glow-1), transparent 28%),
                radial-gradient(circle at top right, var(--news-glow-2), transparent 24%),
                linear-gradient(180deg, #f8f8f7 0%, #efefec 100%);
            font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .news-shell {
            width: min(100%, 1320px);
            margin: 0 auto;
            padding: 24px;
        }

        .news-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(247,247,245,.98)),
                repeating-linear-gradient(
                    0deg,
                    rgba(0,0,0,.016) 0px,
                    rgba(0,0,0,.016) 1px,
                    transparent 1px,
                    transparent 26px
                );
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 24px 80px rgba(0,0,0,.08);
            isolation: isolate;
        }

        .news-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(to right, rgba(0,0,0,.05) 1px, transparent 1px);
            background-size: 33.333% 100%;
            pointer-events: none;
            opacity: .28;
            z-index: 0;
        }

        .news-wrap::after {
            content: "";
            position: absolute;
            inset: 18px;
            border: 1px solid color-mix(in srgb, var(--news-accent) 24%, rgba(0,0,0,.08));
            pointer-events: none;
            z-index: 0;
        }

        .news-wrap > * {
            position: relative;
            z-index: 1;
        }

        .responsive-text {
            display: block;
            min-width: 0;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .serif-title {
            font-family: Georgia, "Times New Roman", serif;
            letter-spacing: -.03em;
        }

        .top-nav {
            position: sticky;
            top: 14px;
            z-index: 60;
            width: fit-content;
            max-width: calc(100% - 24px);
            margin: 16px auto -18px;
            padding: 8px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scrollbar-width: none;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 12px 34px rgba(0,0,0,.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .top-nav::-webkit-scrollbar { display: none; }

        .top-nav a {
            flex: 0 0 auto;
            padding: 10px 14px;
            border-radius: 999px;
            text-decoration: none;
            color: #333;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            transition: .25s ease;
        }

        .top-nav a:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--news-accent-dark), var(--news-accent));
            transform: translateY(-1px);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 80;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            border: 1px solid rgba(0,0,0,.10);
            background: rgba(255,255,255,.95);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 14px 34px rgba(0,0,0,.10);
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            transition: .25s ease;
        }

        .floating-action-button.is-active {
            background: color-mix(in srgb, var(--news-accent) 16%, white);
        }

        .floating-actions a:hover,
        .floating-action-button:hover {
            transform: translateY(-2px);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .news-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 13px 24px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            font-weight: 900;
            background: linear-gradient(135deg, var(--news-accent-dark), var(--news-accent));
            box-shadow: 0 18px 40px color-mix(in srgb, var(--news-accent) 28%, transparent);
            transition: .25s ease;
        }

        .news-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 46px color-mix(in srgb, var(--news-accent) 34%, transparent);
        }

        .news-btn.secondary {
            color: var(--news-dark);
            background: #fff;
            border: 1px solid rgba(0,0,0,.12);
            box-shadow: 0 12px 28px rgba(0,0,0,.06);
        }

        .section {
            min-height: 100vh;
            padding: 92px 54px 74px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .section.compact {
            min-height: auto;
            padding-top: 76px;
            padding-bottom: 76px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--news-accent-dark);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .24em;
            text-transform: uppercase;
        }

        .section-label::before,
        .section-label::after {
            content: "";
            width: 34px;
            height: 1px;
            background: color-mix(in srgb, var(--news-accent) 40%, rgba(0,0,0,.12));
        }

        .section-title {
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            line-height: .94;
            letter-spacing: -.04em;
            margin: 14px 0 0;
            color: var(--news-dark);
        }

        .section-desc {
            margin-top: 16px;
            max-width: 760px;
            color: var(--news-muted);
            line-height: 1.9;
        }

        .news-card,
        .people-card,
        .highlight-card,
        .gift-card,
        .summary-card,
        .message-card,
        .rsvp-card,
        .detail-card,
        .cover-card,
        .gallery-card {
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 16px 40px rgba(0,0,0,.05);
        }

        /* ================= HERO - NEWSPAPER ================= */
        .hero-formal {
            position: relative;
            padding: 118px 48px 72px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-formal::before {
            content: "";
            position: absolute;
            inset: 28px;
            border: 2px solid rgba(0,0,0,.06);
            pointer-events: none;
        }

        .masthead {
            text-align: center;
            padding-bottom: 18px;
            border-bottom: 3px double rgba(0,0,0,.18);
            margin-bottom: 18px;
        }

        .masthead-top {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--news-muted);
        }

        .masthead-title {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.8rem, 7vw, 6rem);
            line-height: .92;
            letter-spacing: -.06em;
            text-transform: uppercase;
            color: #111;
        }

        .masthead-sub {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--news-accent-dark);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: .62fr 1.08fr .78fr;
            gap: 22px;
            align-items: start;
            margin-top: 20px;
        }

        .news-column {
            min-width: 0;
        }

        .hero-meta-stack {
            display: grid;
            gap: 14px;
        }

        .news-mini-card {
            padding: 18px;
            border-radius: 18px;
        }

        .news-mini-card small {
            display: block;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--news-muted);
        }

        .news-mini-card strong {
            display: block;
            margin-top: 10px;
            color: var(--news-dark);
            font-size: 1.12rem;
            line-height: 1.42;
            font-weight: 950;
        }

        .news-mini-card span {
            display: block;
            margin-top: 6px;
            color: var(--news-muted);
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .news-mini-card.accent {
            background: linear-gradient(135deg, var(--news-accent-dark), var(--news-accent));
            border-color: transparent;
            box-shadow: 0 18px 44px color-mix(in srgb, var(--news-accent) 26%, transparent);
        }

        .news-mini-card.accent small,
        .news-mini-card.accent strong,
        .news-mini-card.accent span {
            color: #fff;
        }

        .headline-board {
            padding: 10px 4px;
        }

        .headline-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(0,0,0,.10);
            color: var(--news-accent-dark);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .headline-tag::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--news-accent-dark), var(--news-accent));
        }

        .headline-title {
            margin: 18px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(3rem, 6vw, 5.6rem);
            line-height: .9;
            letter-spacing: -.06em;
            color: #111;
        }

        .headline-divider {
            margin: 16px 0 18px;
            width: 110px;
            height: 4px;
            background: linear-gradient(90deg, var(--news-accent-dark), var(--news-accent));
            border-radius: 999px;
        }

        .headline-desc {
            font-size: 1.02rem;
            line-height: 1.95;
            color: var(--news-muted);
            max-width: 90%;
        }

        .headline-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
        }

        .headline-bottom-strip {
            margin-top: 26px;
            padding-top: 16px;
            border-top: 1px dashed rgba(0,0,0,.16);
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .headline-bottom-item {
            padding: 14px 12px;
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(0,0,0,.08);
            border-radius: 16px;
        }

        .headline-bottom-item small {
            display: block;
            color: var(--news-muted);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .headline-bottom-item strong {
            display: block;
            margin-top: 8px;
            color: var(--news-dark);
            font-size: 1rem;
            line-height: 1.45;
            font-weight: 950;
        }

        .cover-card {
            border-radius: 26px;
            overflow: hidden;
            padding: 16px;
            position: relative;
        }

        .cover-card::before {
            content: "";
            position: absolute;
            inset: 14px;
            border: 1px dashed color-mix(in srgb, var(--news-accent) 30%, rgba(0,0,0,.12));
            pointer-events: none;
        }

        .cover-card-top {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--news-muted);
            margin-bottom: 14px;
        }

        .cover-media {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 5;
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(180deg, #f7f7f5, #ecece7);
            border: 1px solid rgba(0,0,0,.08);
        }

        .cover-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cover-media.default-media {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .cover-media.default-media img {
            width: min(100%, 280px);
            height: auto;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 18px 40px rgba(0,0,0,.10));
        }

        .cover-caption {
            margin-top: 14px;
            padding: 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(247,247,245,.98));
            border: 1px solid rgba(0,0,0,.08);
        }

        .cover-caption small {
            display: block;
            color: var(--news-accent-dark);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .cover-caption strong {
            display: block;
            margin-top: 8px;
            color: var(--news-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(1.35rem, 2.6vw, 2rem);
            line-height: 1.05;
            font-weight: 900;
        }

        .formal-ribbon {
            margin-top: 20px;
            padding: 14px 20px;
            border-top: 1px solid rgba(0,0,0,.12);
            border-bottom: 1px solid rgba(0,0,0,.12);
            text-align: center;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--news-muted);
        }

        /* ================= COMMON GRIDS ================= */
        .head-center {
            text-align: center;
        }

        .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
            margin-top: 36px;
        }

        .people-card {
            border-radius: 22px;
            overflow: hidden;
            padding: 18px;
        }

        .people-photo,
        .people-placeholder {
            width: 100%;
            aspect-ratio: 4 / 4.8;
            border-radius: 18px;
            object-fit: cover;
            display: block;
            background: linear-gradient(180deg, #f8f8f6, #efefea);
        }

        .people-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 900;
            color: var(--news-accent-dark);
            font-family: Georgia, "Times New Roman", serif;
        }

        .people-role {
            display: inline-block;
            margin-top: 16px;
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--news-accent) 10%, white);
            color: var(--news-accent-dark);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .people-card h3 {
            margin: 14px 0 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--news-dark);
            font-size: 1.7rem;
            line-height: 1.08;
        }

        .people-card p {
            margin-top: 8px;
            color: var(--news-muted);
            line-height: 1.75;
        }

        .highlight-grid {
            display: grid;
            gap: 18px;
            margin-top: 36px;
        }

        .highlight-grid.count-1 { grid-template-columns: minmax(280px, 720px); justify-content: center; }
        .highlight-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 1fr)); }
        .highlight-grid.count-3 { grid-template-columns: repeat(3, minmax(220px, 1fr)); }

        .highlight-card {
            border-radius: 22px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .highlight-card::before {
            content: attr(data-number);
            position: absolute;
            right: 18px;
            top: 14px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 3.2rem;
            font-weight: 900;
            color: color-mix(in srgb, var(--news-accent) 18%, rgba(0,0,0,.06));
            line-height: 1;
        }

        .highlight-card small {
            display: block;
            color: var(--news-accent-dark);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .highlight-card h3 {
            margin-top: 12px;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--news-dark);
            font-size: 1.7rem;
            line-height: 1.08;
        }

        .highlight-card p {
            margin-top: 10px;
            color: var(--news-muted);
            line-height: 1.85;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 1.04fr .96fr;
            gap: 22px;
            margin-top: 36px;
        }

        .detail-card {
            border-radius: 24px;
            padding: 24px;
        }

        .detail-card h3 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--news-dark);
            font-size: 2rem;
            line-height: 1;
        }

        .detail-list {
            display: grid;
            gap: 0;
            margin-top: 22px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 16px;
            padding: 14px 0;
            border-top: 1px dashed rgba(0,0,0,.14);
        }

        .detail-row .label {
            color: var(--news-muted);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .detail-row .value {
            color: var(--news-dark);
            font-weight: 850;
            line-height: 1.7;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .countdown-card {
            padding: 18px 10px;
            text-align: center;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff, #f5f5f2);
            border: 1px solid rgba(0,0,0,.08);
        }

        .countdown-number {
            display: block;
            color: var(--news-accent-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
        }

        .countdown-label {
            display: block;
            margin-top: 8px;
            color: var(--news-muted);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 20px;
            overflow: hidden;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,.10);
            background: #fff;
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 320px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
            text-align: center;
            text-decoration: none;
            color: var(--news-dark);
            background:
                linear-gradient(180deg, rgba(255,255,255,.96), rgba(244,244,241,.98));
        }

        .article-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr 1fr;
            gap: 16px;
            margin-top: 34px;
        }

        .gallery-col {
            display: grid;
            gap: 16px;
        }

        .gallery-card {
            padding: 10px;
            border-radius: 20px;
            overflow: hidden;
        }

        .gallery-card img {
            width: 100%;
            display: block;
            border-radius: 14px;
            object-fit: cover;
        }

        .gallery-card.tall img { height: 340px; }
        .gallery-card.short img { height: 210px; }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gift-grid.gift-count-1 {
            grid-template-columns: minmax(280px, 620px);
            justify-content: center;
        }

        .gift-card {
            border-radius: 22px;
            padding: 24px;
        }

        .gift-card h3 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--news-dark);
            font-size: 1.6rem;
        }

        .gift-box {
            margin-top: 18px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,.08);
            background: linear-gradient(180deg, #fff, #f7f7f4);
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
        }

        .gift-box small {
            display: block;
            color: var(--news-muted);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .gift-number {
            display: block;
            margin-top: 8px;
            color: var(--news-accent-dark);
            font-size: 1.08rem;
            font-weight: 950;
        }

        .copy-gift-btn {
            flex-shrink: 0;
            border: none;
            cursor: pointer;
            padding: 10px 14px;
            border-radius: 999px;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--news-accent-dark), var(--news-accent));
        }

        .copy-gift-btn.copied {
            background: linear-gradient(135deg, #15803d, #22c55e);
        }

        .rsvp-wrap {
            max-width: 980px;
            width: 100%;
            margin: 0 auto;
        }

        .rsvp-card {
            border-radius: 22px;
            padding: 24px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            border-radius: 18px;
            padding: 20px;
            text-align: center;
        }

        .summary-card strong {
            display: block;
            color: var(--news-accent-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: var(--news-muted);
            font-size: 12px;
            font-weight: 900;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
        }

        .message-card {
            border-radius: 18px;
            padding: 20px;
        }

        .message-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--news-accent) 10%, white);
            color: var(--news-accent-dark);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 860px;
            margin: 0 auto;
            border-radius: 26px;
            padding: 44px 30px;
            text-align: center;
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(246,246,243,.98));
            border: 1px solid rgba(0,0,0,.10);
            box-shadow: 0 18px 44px rgba(0,0,0,.05);
        }

        .closing-card .thank-title {
            margin-top: 18px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2.6rem, 5vw, 4.6rem);
            line-height: .92;
            letter-spacing: -.04em;
        }

        /* Reveal */
        [data-reveal] {
            opacity: 0;
            transform: translateY(32px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .82s cubic-bezier(.2,.8,.2,1),
                transform .82s cubic-bezier(.2,.8,.2,1),
                filter .82s cubic-bezier(.2,.8,.2,1);
            transition-delay: var(--reveal-delay, 0s);
            will-change: opacity, transform, filter;
        }

        [data-reveal="left"] { transform: translateX(-34px) scale(.985); }
        [data-reveal="right"] { transform: translateX(34px) scale(.985); }
        [data-reveal="zoom"] { transform: translateY(22px) scale(.94); }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0,0) scale(1);
            filter: blur(0);
        }

        @media (hover: hover) {
            .news-card:hover,
            .people-card:hover,
            .highlight-card:hover,
            .gift-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .rsvp-card:hover,
            .detail-card:hover,
            .cover-card:hover,
            .gallery-card:hover,
            .news-mini-card:hover {
                transform: translateY(-4px);
                transition: .28s ease;
                box-shadow: 0 24px 50px rgba(0,0,0,.08);
            }
        }

        @keyframes newsFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes newsShine {
            0%,48% { left: -80%; }
            75%,100% { left: 130%; }
        }

        @keyframes newsPulse {
            0%,100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        @media (max-width: 1180px) {
            .hero-grid,
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .hero-formal {
                padding-left: 28px;
                padding-right: 28px;
            }

            .headline-desc {
                max-width: 100%;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-col {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .news-shell {
                padding: 0;
            }

            .news-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .top-nav {
                top: 10px;
                margin: 12px auto -14px;
                max-width: calc(100% - 20px);
            }

            .section,
            .hero-formal {
                padding: 86px 22px 64px;
            }

            .masthead-title {
                font-size: clamp(2.2rem, 11vw, 4rem);
            }

            .headline-title {
                font-size: clamp(2.4rem, 12vw, 4rem);
            }

            .headline-bottom-strip,
            .summary-grid,
            .countdown-grid,
            .gift-grid,
            .gallery-col {
                grid-template-columns: 1fr;
            }

            .highlight-grid.count-2,
            .highlight-grid.count-3 {
                grid-template-columns: 1fr;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .floating-actions {
                right: 10px;
                transform: translateY(-50%) scale(.92);
                transform-origin: right center;
            }

            .gift-box {
                flex-direction: column;
                align-items: flex-start;
            }

            .copy-gift-btn {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
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

        /* =========================================================
        FIX CORPORATE FORMAL INVITATION
        Paragraf center + cover tidak terlalu banyak space kosong
        ========================================================= */

        /* 1. Semua deskripsi section yang judulnya center ikut benar-benar center */
        .head-center {
            text-align: center !important;
        }

        .head-center .section-desc,
        .head-center p.section-desc,
        .section .head-center > p,
        .section.compact .head-center > p {
            width: min(100%, 760px) !important;
            max-width: 760px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            text-align: center !important;
        }

        /* Supaya teks yang memakai responsive-text di area heading tidak terlihat geser */
        .head-center .responsive-text {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* Label section tetap center */
        .head-center .section-label {
            justify-content: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* 2. Cover card default jangan melebar penuh saat tablet/laptop */
        .cover-card {
            width: 100%;
        }

        /* Desktop normal tetap aman */
        .cover-media.default-media {
            padding: 0 !important;
        }

        .cover-media.default-media img {
            width: 100% !important;
            height: 100% !important;
            max-width: none !important;
            max-height: none !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        /* 3. Laptop/tablet: card cover dibuat mengikuti ukuran gambar, bukan full lebar halaman */
        @media (max-width: 1180px) {
            .hero-grid > .news-column:last-child {
                width: 100% !important;
                max-width: 560px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .cover-card {
                width: 100% !important;
                max-width: 560px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .cover-media {
                aspect-ratio: 4 / 3 !important;
                min-height: 0 !important;
            }

            .cover-media.default-media img {
                object-fit: cover !important;
            }
        }

        /* 4. Mobile tetap rapi */
        @media (max-width: 760px) {
            .head-center .section-desc,
            .head-center p.section-desc,
            .section .head-center > p,
            .section.compact .head-center > p {
                width: min(100%, 92vw) !important;
                max-width: 92vw !important;
                text-align: center !important;
                line-height: 1.8 !important;
            }

            .cover-card {
                max-width: 100% !important;
            }

            .cover-media {
                aspect-ratio: 4 / 3 !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'navy';

    $themes = [
        'maroon' => ['accent' => '#9f1239', 'accentDark' => '#6f1027', 'soft' => '#fef2f2', 'glow1' => 'rgba(244,63,94,.13)', 'glow2' => 'rgba(190,24,93,.10)'],
        'emerald' => ['accent' => '#059669', 'accentDark' => '#065f46', 'soft' => '#ecfdf5', 'glow1' => 'rgba(16,185,129,.13)', 'glow2' => 'rgba(5,150,105,.10)'],
        'navy'    => ['accent' => '#2563eb', 'accentDark' => '#1e3a8a', 'soft' => '#eff6ff', 'glow1' => 'rgba(37,99,235,.13)', 'glow2' => 'rgba(56,189,248,.10)'],
        'rose'    => ['accent' => '#e11d48', 'accentDark' => '#9f1239', 'soft' => '#fff1f2', 'glow1' => 'rgba(244,63,94,.13)', 'glow2' => 'rgba(251,113,133,.10)'],
        'gold'    => ['accent' => '#d97706', 'accentDark' => '#92400e', 'soft' => '#fffbeb', 'glow1' => 'rgba(245,158,11,.13)', 'glow2' => 'rgba(251,191,36,.10)'],
        'slate'   => ['accent' => '#64748b', 'accentDark' => '#334155', 'soft' => '#f8fafc', 'glow1' => 'rgba(100,116,139,.13)', 'glow2' => 'rgba(148,163,184,.10)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['navy'];

    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $people = $invitation->people ?? collect();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $giftCount = $gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Corporate Formal Invitation';
    $eventName = $invitation->event_name ?: 'Corporate Event';
    $hostName = $invitation->host_name ?: 'Corporate Team';

    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Agenda Formal';
    $highlightSectionDesc = 'Rangkaian agenda utama, materi, atau susunan acara corporate yang ingin ditampilkan secara profesional.';

    $eventDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y')
        : 'Tanggal belum diatur';

    if ($invitation->event_end_date) {
        $eventDateText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y');
    }

    $eventTimeText = $invitation->event_time
        ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i')
        : null;

    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));

    $mapOpenUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : (isset($mapData) ? ($mapData['embed_url'] ?? null) : null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Event Room' : 'Lokasi Acara');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang acara.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $shareMessage = "Halo Bapak/Ibu/Saudara/i,\n\n"
        . "Dengan hormat, kami mengundang Anda untuk hadir dalam acara:\n\n"
        . "*{$eventName}*\n"
        . "*{$eventTitle}*\n\n"
        . "Diselenggarakan oleh: {$hostName}\n"
        . "Tanggal: {$eventDateText}\n"
        . ($eventTimeText ? "Waktu: {$eventTimeText}\n" : "");

    if ($isOnlineEvent) {
        $shareMessage .= "Mode: Online\n";
        if ($onlineUrl) {
            $shareMessage .= "Link Online: {$onlineUrl}\n";
        }
    } else {
        $shareMessage .= "Mode: Offline\n";
        if ($invitation->location_name) {
            $shareMessage .= "Tempat: {$invitation->location_name}\n";
        }
        if ($invitation->address) {
            $shareMessage .= "Alamat: {$invitation->address}\n";
        }
    }

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n{$shareUrl}\n\nTerima kasih.";

    $shareText = urlencode($shareMessage);

    $countdownTarget = null;
    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
        $timePart = '00:00:00';

        if (!empty($invitation->event_time)) {
            try {
                $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s');
            } catch (\Exception $e) {
                $timePart = '00:00:00';
            }
        }

        $countdownTarget = $datePart . 'T' . $timePart;
    }

    $googleCalendarUrl = null;
    if ($invitation->event_date) {
        try {
            $startDate = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
            $startTime = !empty($invitation->event_time) ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00';
            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);

            $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d') : $startDate;
            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Corporate Event') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan corporate formal') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online'))
                : trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) {
            $googleCalendarUrl = null;
        }
    }

    $launchHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();

    $highlightCount = $launchHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };
@endphp

<body
    style="
        --news-accent: {{ $activeTheme['accent'] }};
        --news-accent-dark: {{ $activeTheme['accentDark'] }};
        --news-soft: {{ $activeTheme['soft'] }};
        --news-glow-1: {{ $activeTheme['glow1'] }};
        --news-glow-2: {{ $activeTheme['glow2'] }};
        --news-dark: #111111;
        --news-muted: #5c5c5c;
    "
>
    <main class="news-shell">
        <div class="news-wrap">
            <nav class="top-nav">
                <a href="#people">Team</a>
                <a href="#about">Agenda</a>
                <a href="#detail">Detail</a>
                @if($photos->count())
                    <a href="#gallery">Galeri</a>
                @endif
                @if($giftCount)
                    <a href="#gift">Support</a>
                @endif
                <a href="#message">RSVP</a>
            </nav>

            <div class="floating-actions">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan" class="floating-icon">
                </a>

                <button type="button" id="music-toggle" class="floating-action-button" title="Music">
                    <img src="{{ asset('assets/icons/music-off.png') }}"
                         data-icon-on="{{ asset('assets/icons/music-on.png') }}"
                         data-icon-off="{{ asset('assets/icons/music-off.png') }}"
                         alt="Music"
                         class="floating-icon">
                </button>

                <button type="button" id="scroll-toggle" class="floating-action-button" title="Auto Scroll">
                    <img src="{{ asset('assets/icons/scroll-off.png') }}"
                         data-icon-on="{{ asset('assets/icons/scroll-on.png') }}"
                         data-icon-off="{{ asset('assets/icons/scroll-off.png') }}"
                         alt="Auto Scroll"
                         class="floating-icon">
                </button>

                @if (!$isOnlineEvent && $mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi">
                        <img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon">
                    </a>
                @endif

                @if ($isOnlineEvent && $onlineUrl)
                    <a href="{{ $onlineUrl }}" target="_blank" title="Join Online">
                        <img src="{{ asset('assets/icons/meeting.png') }}" alt="Join Online" class="floating-icon">
                    </a>
                @endif
            </div>

            <audio id="invitation-music"
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background5.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            {{-- HERO --}}
            <section id="opening" class="hero-formal">
                <div class="masthead" data-reveal="zoom">
                    <h1 class="masthead-title serif-title">Corporate Times</h1>
                    <div class="masthead-sub">{{ $eventName }}</div>
                </div>

                <div class="hero-grid">
                    <div class="news-column hero-meta-stack" data-reveal="left">
                        <div class="news-card news-mini-card accent">
                            <small>Tanggal Terbit Acara</small>
                            <strong class="responsive-text">{{ $eventDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="news-card news-mini-card">
                            <small>Mode Acara</small>
                            <strong>{{ $isOnlineEvent ? 'Online Event' : 'Offline Event' }}</strong>
                            <span>{{ $isOnlineEvent ? 'Akses melalui link online' : 'Hadir langsung di lokasi acara' }}</span>
                        </div>

                        <div class="news-card news-mini-card">
                            <small>{{ $accessTypeLabel }}</small>
                            <strong class="responsive-text">{{ $accessName }}</strong>
                            <span class="responsive-text">{{ $isOnlineEvent ? ($onlineUrl ?: 'Link online belum ditambahkan') : $accessDescription }}</span>
                        </div>

                        <div class="news-card news-mini-card">
                            <small>Hosted by</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span>Bagian ini menampilkan nama penyelenggara atau host corporate event.</span>
                        </div>
                    </div>

                    <div class="news-column headline-board" data-reveal="zoom" style="--reveal-delay:.06s">
                        <span class="headline-tag">Headline Invitation</span>

                        <h2 class="headline-title responsive-text serif-title">{{ $eventTitle }}</h2>

                        <div class="headline-divider"></div>

                        <p class="headline-desc responsive-text">
                            {{ $invitation->description ?: 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara corporate formal yang dirancang elegan, profesional, dan informatif sebagai bagian dari momen penting perusahaan, institusi, maupun organisasi.' }}
                        </p>

                        <div class="headline-actions">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="news-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="news-btn">Lihat Detail</a>
                            @endif

                            <a href="#about" class="news-btn secondary">Agenda Acara</a>
                            <a href="#message" class="news-btn secondary">Konfirmasi Kehadiran</a>
                        </div>

                        <div class="headline-bottom-strip">
                            <div class="headline-bottom-item">
                                <small>Acara</small>
                                <strong class="responsive-text">{{ $eventName }}</strong>
                            </div>

                            <div class="headline-bottom-item">
                                <small>Waktu</small>
                                <strong class="responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</strong>
                            </div>

                            <div class="headline-bottom-item">
                                <small>{{ $accessTypeLabel }}</small>
                                <strong class="responsive-text">{{ $accessName }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="news-column" data-reveal="right" style="--reveal-delay:.12s">
                        <div class="cover-card">
                            <div class="cover-card-top">
                                <span>Featured Cover</span>
                                <span>{{ $isOnlineEvent ? 'Digital Access' : 'Venue Access' }}</span>
                            </div>

                            @if ($invitation->cover_image)
                                <div class="cover-media">
                                    <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Corporate Formal Invitation">
                                </div>
                            @elseif ($firstPhoto)
                                <div class="cover-media">
                                    <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Corporate Formal Invitation">
                                </div>
                            @else
                                <div class="cover-media default-media">
                                    <img src="{{ asset('assets/icons/corporate2.png') }}" alt="Default Corporate">
                                </div>
                            @endif

                            <div class="cover-caption">
                                <small>Main Story</small>
                                <strong class="responsive-text serif-title">{{ $eventTitle }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="formal-ribbon" data-reveal="zoom" style="--reveal-delay:.18s">
                    Corporate • Formal Invitation • Editorial Layout • Professional Gathering • Strategic Session
                </div>
            </section>

            {{-- PEOPLE --}}
            <section id="people" class="section compact">
                <div class="head-center">
                    <div class="section-label" data-reveal="zoom">Editorial Team Section</div>
                    <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">Tim & Perwakilan</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">
                        Bagian ini menampilkan pihak utama, perwakilan perusahaan, host, narasumber, atau tokoh yang terkait dalam acara corporate formal.
                    </p>
                </div>

                <div class="people-grid">
                    @forelse ($people as $index => $person)
                        <div class="people-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.05, 0.26) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="people-photo">
                            @else
                                <div class="people-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'C', 0, 1)) }}</div>
                            @endif

                            <span class="people-role">{{ $person->subtitle ?: 'Corporate Representative' }}</span>
                            <h3 class="responsive-text serif-title">{{ $person->name ?: 'Nama Perwakilan' }}</h3>

                            @if ($person->family_name)
                                <p class="responsive-text">{{ $person->family_name }}</p>
                            @else
                                <p class="responsive-text">Bagian ini dapat digunakan untuk deskripsi singkat, jabatan, afiliasi, atau keterangan lain.</p>
                            @endif
                        </div>
                    @empty
                        <div class="people-card" data-reveal="zoom">
                            <div class="people-placeholder">C</div>
                            <span class="people-role">Corporate Representative</span>
                            <h3 class="responsive-text serif-title">Nama Perwakilan</h3>
                            <p>Data tim atau perwakilan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- AGENDA / HIGHLIGHTS --}}
            <section id="about" class="section compact">
                <div class="head-center">
                    <div class="section-label" data-reveal="zoom">Main Article</div>
                    <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">{{ $agendaSectionTitle }}</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">{{ $highlightSectionDesc }}</p>
                </div>

                @if ($highlightCount > 0)
                    <div class="highlight-grid {{ $highlightGridClass }}">
                        @foreach ($launchHighlights as $index => $highlight)
                            <div class="highlight-card" data-number="{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.05, 0.28) }}s">
                                <small>Agenda {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</small>
                                <h3 class="responsive-text serif-title">{{ $highlight['title'] ?? 'Agenda Corporate' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi agenda corporate formal.' }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="highlight-grid count-1">
                        <div class="highlight-card" data-number="01" data-reveal="zoom">
                            <small>Agenda 01</small>
                            <h3 class="responsive-text serif-title">Agenda Acara</h3>
                            <p class="responsive-text">Belum ada poin agenda yang ditambahkan. Pengguna dapat mengisi poin acara melalui editor tanpa menambah form baru.</p>
                        </div>
                    </div>
                @endif
            </section>

            {{-- DETAIL --}}
            <section id="detail" class="section compact">
                <div class="head-center">
                    <div class="section-label" data-reveal="zoom">Event Information</div>
                    <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">Detail Acara</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">
                        Informasi jadwal, akses acara, lokasi/platform, dan hitung mundur menuju acara.
                    </p>
                </div>

                <div class="detail-layout">
                    <div class="detail-card" data-reveal="left">
                        <h3 class="serif-title">Informasi Formal</h3>

                        <div class="detail-list">
                            <div class="detail-row">
                                <div class="label">Acara</div>
                                <div class="value responsive-text">{{ $eventName }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">Judul</div>
                                <div class="value responsive-text">{{ $eventTitle }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">Host</div>
                                <div class="value responsive-text">{{ $hostName }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">Mode</div>
                                <div class="value responsive-text">{{ $isOnlineEvent ? 'Online Event' : 'Offline Event' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">Tanggal</div>
                                <div class="value responsive-text">{{ $eventDateText }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">Waktu</div>
                                <div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">{{ $accessTypeLabel }}</div>
                                <div class="value responsive-text">{{ $accessName }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div>
                                <div class="value responsive-text">{{ $accessDescription }}</div>
                            </div>
                        </div>

                        <div class="article-actions">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="news-btn">📅 Add Calendar</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="news-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="detail-card" data-reveal="right">
                        <h3 class="serif-title">Akses & Countdown</h3>

                        <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                            <div class="countdown-card">
                                <span class="countdown-number" data-unit="days">00</span>
                                <span class="countdown-label">Hari</span>
                            </div>
                            <div class="countdown-card">
                                <span class="countdown-number" data-unit="hours">00</span>
                                <span class="countdown-label">Jam</span>
                            </div>
                            <div class="countdown-card">
                                <span class="countdown-number" data-unit="minutes">00</span>
                                <span class="countdown-label">Menit</span>
                            </div>
                            <div class="countdown-card">
                                <span class="countdown-number" data-unit="seconds">00</span>
                                <span class="countdown-label">Detik</span>
                            </div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--news-muted);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--news-accent-dark);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">🌐</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--news-muted);">Link online belum ditambahkan.</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe src="{{ $mapEmbedUrl }}"
                                                class="map-frame"
                                                loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade"
                                                allowfullscreen>
                                        </iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--news-muted);">{{ $accessDescription }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--news-accent-dark);">Buka Google Maps →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3">{{ $accessName }}</p>
                                                <p class="responsive-text mt-2" style="color: var(--news-muted);">{{ $accessDescription }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="section compact">
                    <div class="head-center">
                        <div class="section-label" data-reveal="zoom">Photo Reportage</div>
                        <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">Galeri Acara</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">
                            Dokumentasi visual, suasana corporate, atau gambar pendukung acara.
                        </p>
                    </div>

                    <div class="gallery-grid">
                        <div class="gallery-col">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.05, 0.22) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Corporate Formal Invitation">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-col">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.05, 0.22) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Corporate Formal Invitation">
                                </div>
                            @endforeach
                        </div>

                        <div class="gallery-col">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.05, 0.22) }}s">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Corporate Formal Invitation">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- SUPPORT / GIFTS --}}
            @if ($giftCount)
                <section id="gift" class="section compact">
                    <div class="head-center">
                        <div class="section-label" data-reveal="zoom">Support Desk</div>
                        <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">Support / Partner / Kontak</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">
                            Bagian ini dapat dipakai untuk menampilkan partner, sponsor, contact desk, atau informasi support tanpa menambah form baru.
                        </p>
                    </div>

                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Support / Rekening';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp

                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.05, 0.26) }}s">
                                <h3 class="responsive-text serif-title">{{ $giftLabel }}</h3>

                                <div class="gift-box">
                                    <div>
                                        <small>Nomor Rekening / E-wallet</small>
                                        <span class="gift-number responsive-text">{{ $giftNumber }}</span>
                                        <p class="responsive-text text-sm mt-2" style="color: var(--news-muted);">Atas Nama {{ $giftName }}</p>
                                    </div>

                                    @if ($giftNumber !== '-')
                                        <button type="button" class="copy-gift-btn" data-copy="{{ $giftNumber }}">Salin</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="section compact">
                <div class="head-center">
                    <div class="section-label" data-reveal="zoom">Reader Response</div>
                    <h2 class="section-title serif-title responsive-text" data-reveal="zoom" style="--reveal-delay:.06s">Ucapan & Kehadiran</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.12s">
                        Silakan kirim ucapan terbaik dan konfirmasi kehadiran Anda.
                    </p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                            <p class="font-bold">Mohon periksa kembali isian:</p>
                            <ul class="list-disc ml-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('guest-messages.store', $invitation) }}"
                          class="rsvp-card space-y-4"
                          data-reveal="up">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Tamu</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="uk-input mt-1" placeholder="Nama lengkap" required>
                        </div>

                        <div>
                            <label class="uk-label">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="uk-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="uk-label">Jumlah Tamu</label>
                            <input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Ucapan / Doa</label>
                            <textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full news-btn">Kirim Ucapan</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card" data-reveal="zoom">
                            <strong>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</strong>
                            <span>Tidak hadir</span>
                        </div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.05s">
                            <strong>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong>
                            <span>Hadir</span>
                        </div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.10s">
                            <strong>{{ $messages->where('attendance_status', 'ragu')->count() }}</strong>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="message-list">
                        @forelse ($messages as $index => $message)
                            <div class="message-card" data-reveal="up" style="--reveal-delay: {{ min($index * 0.04, 0.24) }}s">
                                <div class="message-head">
                                    <div>
                                        <p class="responsive-text font-black" style="color: var(--news-dark);">{{ $message->guest_name }}</p>
                                        <p class="text-xs mt-1" style="color: var(--news-muted);">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>
                                    @endif
                                </div>

                                <p class="responsive-text mt-4 leading-7" style="color: var(--news-muted);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center" data-reveal="up">
                                <p style="color: var(--news-muted);">Belum ada ucapan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <div class="section-label justify-center">Final Note</div>
                    <h2 class="thank-title serif-title responsive-text">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--news-muted);">
                        Terima kasih atas perhatian, dukungan, dan kesediaan Anda untuk hadir. Semoga acara ini berjalan lancar dan membawa manfaat, kolaborasi, serta hasil terbaik bagi semua pihak.
                    </p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 serif-title" style="color: var(--news-dark);">{{ $eventTitle }}</h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Music */
            const music = document.getElementById('invitation-music');
            const musicToggle = document.getElementById('music-toggle');
            const musicIcon = musicToggle ? musicToggle.querySelector('img') : null;
            let isMusicPlaying = false;

            function setMusicIcon(active) {
                if (!musicIcon || !musicToggle) return;
                musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
                musicToggle.classList.toggle('is-active', active);
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

            /* Auto Scroll Smooth */
            const scrollToggle = document.getElementById('scroll-toggle');
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            if (scrollToggle) {
                const scrollIcon = scrollToggle.querySelector('img');

                function setScrollIcon(active) {
                    scrollToggle.classList.toggle('is-active', active);

                    if (scrollIcon) {
                        scrollIcon.src = active
                            ? scrollIcon.dataset.iconOn
                            : scrollIcon.dataset.iconOff;
                    }
                }

                function stopAutoScroll() {
                    autoScrollActive = false;

                    if (autoScrollFrame) {
                        cancelAnimationFrame(autoScrollFrame);
                        autoScrollFrame = null;
                    }

                    setScrollIcon(false);
                }

                function autoScrollStep() {
                    if (!autoScrollActive) return;

                    const maxY = document.documentElement.scrollHeight - window.innerHeight;
                    const nextY = Math.min(window.scrollY + scrollSpeed, maxY);

                    window.scrollTo({
                        top: nextY,
                        behavior: 'auto'
                    });

                    if (nextY >= maxY) {
                        stopAutoScroll();
                        return;
                    }

                    autoScrollFrame = requestAnimationFrame(autoScrollStep);
                }

                function startAutoScroll() {
                    stopAutoScroll();

                    autoScrollActive = true;
                    setScrollIcon(true);

                    autoScrollFrame = requestAnimationFrame(autoScrollStep);
                }

                scrollToggle.addEventListener('click', function () {
                    if (autoScrollActive) {
                        stopAutoScroll();
                    } else {
                        startAutoScroll();
                    }
                });

                ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                    window.addEventListener(eventName, function () {
                        if (autoScrollActive) {
                            stopAutoScroll();
                        }
                    }, { passive: true });
                });
            }

            /* Countdown */
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

                function pad(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    const now = Date.now();
                    let diff = Math.max(0, target - now);

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    diff -= days * (1000 * 60 * 60 * 24);
                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    diff -= hours * (1000 * 60 * 60);
                    const minutes = Math.floor(diff / (1000 * 60));
                    diff -= minutes * (1000 * 60);
                    const seconds = Math.floor(diff / 1000);

                    if (units.days) units.days.textContent = pad(days);
                    if (units.hours) units.hours.textContent = pad(hours);
                    if (units.minutes) units.minutes.textContent = pad(minutes);
                    if (units.seconds) units.seconds.textContent = pad(seconds);
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

            /* Copy Gift */
            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';

                    try {
                        await navigator.clipboard.writeText(value);
                        button.classList.add('copied');
                        const oldText = button.textContent;
                        button.textContent = 'Tersalin';

                        setTimeout(function () {
                            button.textContent = oldText;
                            button.classList.remove('copied');
                        }, 1600);
                    } catch (error) {
                        const textarea = document.createElement('textarea');
                        textarea.value = value;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
                });
            });

            /* Reveal */
            const revealElements = document.querySelectorAll('[data-reveal]');

            if (!('IntersectionObserver' in window)) {
                revealElements.forEach(function (element) {
                    element.classList.add('is-visible');
                });
            } else {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -60px 0px'
                });

                revealElements.forEach(function (element) {
                    revealObserver.observe(element);
                });
            }

            /* Anti inspect ringan */
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';
                if (!['input', 'textarea', 'select', 'option'].includes(tagName)) {
                    event.preventDefault();
                }
            });

            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });

            document.addEventListener('keydown', function (event) {
                const key = event.key ? event.key.toLowerCase() : '';
                const blocked =
                    event.key === 'F12' ||
                    (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) ||
                    (event.ctrlKey && ['u', 's', 'p'].includes(key)) ||
                    (event.metaKey && event.altKey && ['i', 'j', 'c'].includes(key)) ||
                    (event.metaKey && ['u', 's', 'p'].includes(key));

                if (blocked) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            });
        });
    </script>
</body>
</html>
