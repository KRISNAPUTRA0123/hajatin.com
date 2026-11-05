<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Corporate Grand Opening Pro') . ' ' . ($invitation->title ?: 'Corporate Grand Opening Pro'));
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
            color: var(--startup-dark);
            background:
                radial-gradient(circle at 7% 4%, rgba(59,130,246,.12), transparent 28%),
                radial-gradient(circle at 93% 7%, rgba(236,72,153,.11), transparent 30%),
                radial-gradient(circle at 13% 92%, rgba(250,204,21,.13), transparent 26%),
                radial-gradient(circle at 88% 88%, rgba(34,197,94,.10), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .startup-shell {
            width: min(100%, 1500px);
            margin: 0 auto;
            padding: clamp(0px, 1.8vw, 24px);
        }

        .startup-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: clamp(0px, 3vw, 42px);
            background:
                radial-gradient(circle at 12% 8%, rgba(59,130,246,.08), transparent 26%),
                radial-gradient(circle at 86% 10%, rgba(236,72,153,.07), transparent 30%),
                radial-gradient(circle at 18% 88%, rgba(250,204,21,.09), transparent 26%),
                radial-gradient(circle at 82% 84%, rgba(34,197,94,.07), transparent 28%),
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(248,250,252,.97));
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 38px 110px rgba(15,23,42,.10);
            isolation: isolate;
        }

        .startup-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .08;
            background-image:
                linear-gradient(to right, rgba(59,130,246,.22) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59,130,246,.22) 1px, transparent 1px);
            background-size: 44px 44px;
            z-index: 0;
            animation: startupGridMove 24s linear infinite;
        }

        .startup-wrap::after {
            content: "";
            position: absolute;
            width: 760px;
            height: 760px;
            right: -340px;
            top: -300px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(99,102,241,.14), transparent 66%);
            pointer-events: none;
            z-index: 0;
            animation: startupFloat 8s ease-in-out infinite;
        }

        .startup-wrap > * { position: relative; z-index: 1; }

        .responsive-text {
            display: block;
            min-width: 0;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: normal;
            white-space: pre-line;
        }

        .startup-gradient {
            background: linear-gradient(135deg, var(--startup-dark), var(--startup-primary), var(--startup-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .startup-nav {
            position: sticky;
            top: 14px;
            z-index: 70;
            width: fit-content;
            max-width: calc(100% - 24px);
            margin: 18px auto -34px;
            padding: 8px;
            display: flex;
            gap: 6px;
            overflow-x: auto;
            border-radius: 999px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 18px 44px rgba(15,23,42,.08), inset 0 1px 0 rgba(255,255,255,.92);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            scrollbar-width: none;
        }

        .startup-nav::-webkit-scrollbar { display: none; }

        .startup-nav a {
            flex: 0 0 auto;
            padding: 10px 15px;
            border-radius: 999px;
            text-decoration: none;
            color: var(--startup-text);
            font-size: 12px;
            font-weight: 950;
            transition: .26s ease;
        }

        .startup-nav a:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            transform: translateY(-1px);
        }

        .floating-actions {
            position: fixed;
            right: clamp(10px, 1.7vw, 24px);
            top: 50%;
            transform: translateY(-50%);
            z-index: 90;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: auto;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.22);
            box-shadow: 0 16px 34px rgba(15,23,42,.14);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
            animation: startupButtonFloat 3.6s ease-in-out infinite;
        }

        .floating-action-button.is-active { background: color-mix(in srgb, var(--startup-accent) 54%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }

        .startup-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 14px 25px;
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 18px 44px color-mix(in srgb, var(--startup-primary) 25%, transparent);
            transition: .28s ease;
        }

        .startup-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -80%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.56), transparent);
            animation: startupShine 3.5s ease-in-out infinite;
            pointer-events: none;
        }

        .startup-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 58px color-mix(in srgb, var(--startup-primary) 34%, transparent);
        }

        .startup-btn.secondary {
            color: var(--startup-dark);
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            backdrop-filter: blur(12px);
        }

        .startup-section {
            min-height: 100vh;
            padding: clamp(66px, 7vw, 96px) clamp(20px, 4.6vw, 70px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .startup-section.compact {
            min-height: auto;
            padding-top: clamp(60px, 6vw, 82px);
            padding-bottom: clamp(60px, 6vw, 82px);
        }

        .section-head { text-align: center; }

        .startup-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--startup-primary);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .2em;
            text-transform: uppercase;
        }

        .startup-label::before,
        .startup-label::after {
            content: "";
            width: 38px;
            height: 1px;
            background: color-mix(in srgb, var(--startup-primary) 40%, transparent);
        }

        .startup-title {
            color: var(--startup-dark);
            font-size: clamp(2.35rem, 5vw, 5rem);
            line-height: .96;
            letter-spacing: -.06em;
            font-weight: 950;
            margin-top: 18px;
        }

        .section-desc {
            width: min(100%, 760px);
            margin: 16px auto 0;
            color: var(--startup-text);
            line-height: 1.88;
            text-align: center;
        }

        /* ================= HERO WHITE VSCODE STARTUP ================= */
        .editor-startup-hero {
            position: relative;
            min-height: 100vh;
            padding: clamp(96px, 8vw, 138px) clamp(20px, 4.6vw, 70px) clamp(62px, 6vw, 90px);
            overflow: hidden;
            isolation: isolate;
        }

        .editor-startup-hero::before {
            content: "";
            position: absolute;
            inset: 72px clamp(12px, 1.7vw, 26px) 40px;
            z-index: -2;
            border-radius: clamp(28px, 3vw, 44px);
            background:
                radial-gradient(circle at 12% 16%, rgba(59,130,246,.11), transparent 22%),
                radial-gradient(circle at 86% 14%, rgba(236,72,153,.10), transparent 24%),
                radial-gradient(circle at 18% 84%, rgba(250,204,21,.11), transparent 20%),
                radial-gradient(circle at 82% 82%, rgba(34,197,94,.09), transparent 22%),
                linear-gradient(180deg, rgba(255,255,255,.92), rgba(250,251,255,.96));
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.85), 0 30px 90px rgba(15,23,42,.08);
        }

        .editor-orb,
        .editor-line,
        .editor-star {
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }

        .editor-orb {
            border-radius: 999px;
            filter: blur(1px);
            opacity: .65;
            animation: startupFloat 7.2s ease-in-out infinite;
        }

        .editor-orb.one { width: 230px; height: 230px; left: 2%; top: 10%; background: rgba(59,130,246,.13); }
        .editor-orb.two { width: 290px; height: 290px; right: 4%; top: 9%; background: rgba(236,72,153,.10); animation-delay: -1.6s; }
        .editor-orb.three { width: 160px; height: 160px; left: 46%; bottom: 12%; background: rgba(250,204,21,.14); animation-delay: -3s; }
        .editor-orb.four { width: 120px; height: 120px; right: 18%; bottom: 10%; background: rgba(34,197,94,.12); animation-delay: -2.1s; }

        .editor-line { height: 1px; background: linear-gradient(90deg, transparent, rgba(99,102,241,.32), transparent); opacity: .75; }
        .editor-line.one { width: 280px; left: 54px; top: 154px; }
        .editor-line.two { width: 220px; right: 76px; bottom: 122px; }

        .editor-star { font-size: 20px; opacity: .62; animation: startupPulse 3.4s ease-in-out infinite; }
        .editor-star.one { left: 10%; top: 29%; color: #60a5fa; }
        .editor-star.two { right: 12%; top: 36%; color: #f472b6; animation-delay: -.8s; }
        .editor-star.three { left: 58%; bottom: 20%; color: #facc15; animation-delay: -1.4s; }

        .editor-hero-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(420px, 580px);
            gap: clamp(28px, 3.4vw, 48px);
            align-items: center;
        }

        .editor-copy { min-width: 0; }

        .editor-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(148,163,184,.16);
            color: var(--startup-primary);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
            box-shadow: 0 14px 34px rgba(15,23,42,.06);
        }

        .editor-kicker::before {
            content: "</>";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            color: #fff;
            font-size: 11px;
            font-weight: 950;
            box-shadow: 0 0 18px color-mix(in srgb, var(--startup-primary) 30%, transparent);
        }

        .editor-title {
            margin-top: 24px;
            max-width: 760px;
            color: var(--startup-dark);
            font-size: clamp(3rem, 6vw, 6.2rem);
            line-height: .88;
            letter-spacing: -.08em;
            font-weight: 950;
        }

        .editor-title .accent {
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary), #8b5cf6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .editor-desc {
            max-width: 680px;
            margin-top: 22px;
            color: var(--startup-text);
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .editor-chip-row {
            margin-top: 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .editor-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            color: var(--startup-dark);
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 12px 26px rgba(15,23,42,.06);
        }

        .editor-chip::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 0 14px color-mix(in srgb, var(--startup-primary) 36%, transparent);
        }

        .editor-actions,
        .netflix-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px; }

        .editor-meta-grid {
            margin-top: 32px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .editor-meta-card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 24px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 16px 38px rgba(15,23,42,.07);
        }

        .editor-meta-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--startup-accent) 35%, transparent);
        }

        .editor-meta-card small,
        .editor-meta-card strong,
        .editor-meta-card span { position: relative; z-index: 2; display: block; }
        .editor-meta-card small { color: var(--startup-primary); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .editor-meta-card strong { margin-top: 8px; color: var(--startup-dark); line-height: 1.35; font-weight: 950; }
        .editor-meta-card span { margin-top: 6px; color: var(--startup-text); font-size: 13px; line-height: 1.45; font-weight: 800; }

        .editor-window-zone {
            position: relative;
            min-height: 680px;
            display: flex;
            align-items: center;
        }

        .editor-vscode-window {
            position: relative;
            width: 100%;
            min-height: 670px;
            border-radius: 34px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(148,163,184,.20);
            box-shadow: 0 34px 92px rgba(15,23,42,.14);
        }

        .editor-vscode-window::before {
            content: "";
            position: absolute;
            inset: 14px;
            border-radius: 26px;
            border: 1px dashed rgba(99,102,241,.18);
            pointer-events: none;
            z-index: 10;
        }

        .editor-window-top {
            position: relative;
            z-index: 3;
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            background: #f8fafc;
            border-bottom: 1px solid rgba(148,163,184,.16);
        }

        .editor-window-dots { display: flex; align-items: center; gap: 7px; }
        .editor-window-dots span { width: 11px; height: 11px; border-radius: 999px; }
        .editor-window-dots span:nth-child(1) { background: #fb7185; }
        .editor-window-dots span:nth-child(2) { background: #facc15; }
        .editor-window-dots span:nth-child(3) { background: #34d399; }

        .editor-tabs { display: flex; gap: 8px; margin-left: 10px; flex-wrap: wrap; }
        .editor-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 34px;
            padding: 8px 12px;
            border-radius: 12px 12px 0 0;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.14);
            color: #334155;
            font-size: 11px;
            font-weight: 900;
        }
        .editor-tab::before { content: ""; width: 9px; height: 9px; border-radius: 999px; background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary)); }

        .editor-window-body {
            display: grid;
            grid-template-columns: 64px minmax(0, 1fr) minmax(220px, 290px);
            min-height: 614px;
        }

        .editor-sidebar { background: #111827; padding: 18px 0; display: flex; flex-direction: column; align-items: center; gap: 14px; }
        .editor-side-icon { width: 34px; height: 34px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.06); }
        .editor-side-icon.active { background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary)); box-shadow: 0 0 18px color-mix(in srgb, var(--startup-primary) 30%, transparent); }

        .editor-code-pane {
            position: relative;
            padding: 26px 24px;
            background: linear-gradient(180deg, #1e1e1e, #191c22);
            color: #d4d4d4;
            overflow: hidden;
            min-width: 0;
        }

        .editor-code-pane::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 8% 0%, rgba(59,130,246,.10), transparent 24%),
                radial-gradient(circle at 92% 10%, rgba(236,72,153,.08), transparent 28%);
            pointer-events: none;
        }

        .editor-code-title {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            color: #e2e8f0;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .editor-code-lines {
            position: relative;
            z-index: 2;
            margin-top: 18px;
            display: grid;
            gap: 10px;
            font-family: "Fira Code", "Consolas", monospace;
            font-size: 13px;
            line-height: 1.75;
        }

        .code-line { display: grid; grid-template-columns: 34px minmax(0, 1fr); gap: 12px; min-width: 0; }
        .line-no { color: rgba(255,255,255,.34); text-align: right; user-select: none; }
        .token-key { color: #c586c0; }
        .token-var { color: #9cdcfe; }
        .token-op  { color: #d4d4d4; }
        .token-str { color: #ce9178; }
        .token-fn  { color: #dcdcaa; }
        .token-prop { color: #4ec9b0; }
        .token-num { color: #b5cea8; }
        .token-com { color: #6a9955; }

        .editor-preview-pane {
            position: relative;
            padding: 18px;
            background: linear-gradient(180deg, #f8fbff, #eef4ff);
            border-left: 1px solid rgba(148,163,184,.16);
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-width: 0;
        }

        .editor-preview-badge {
            display: inline-flex;
            align-items: center;
            align-self: flex-start;
            gap: 8px;
            min-height: 34px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 10px 22px rgba(15,23,42,.06);
            color: var(--startup-primary);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .editor-preview-card {
            position: relative;
            flex: 1;
            min-height: 430px;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 14px 32px rgba(15,23,42,.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .editor-preview-media {
            position: relative;
            flex: 1 1 auto;
            min-height: 300px;
            background: linear-gradient(135deg, rgba(239,246,255,.92), rgba(255,255,255,.98));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .editor-preview-media > img {
            display: block;
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .editor-preview-fallback {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            width: 100%;
            height: 100%;
            min-height: 260px;
            text-align: center;
        }

        .editor-preview-fallback img {
            width: min(100%, 180px);
            height: auto;
            max-height: 180px;
            object-fit: contain;
            filter: drop-shadow(0 18px 40px color-mix(in srgb, var(--startup-primary) 18%, transparent));
        }

        .editor-preview-footer { padding: 18px 18px 20px; background: #ffffff; border-top: 1px solid rgba(148,163,184,.12); }
        .editor-preview-footer small,
        .editor-preview-footer strong,
        .editor-preview-footer span { display: block; }
        .editor-preview-footer small { color: var(--startup-primary); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .editor-preview-footer strong { margin-top: 8px; color: var(--startup-dark); font-size: 1.22rem; line-height: 1.12; font-weight: 950; }
        .editor-preview-footer span { margin-top: 6px; color: var(--startup-text); font-size: 13px; line-height: 1.5; font-weight: 800; }

        .editor-float-card {
            position: absolute;
            z-index: 9;
            padding: 16px 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 18px 36px rgba(15,23,42,.10);
            backdrop-filter: blur(12px);
            animation: startupFloat 5.3s ease-in-out infinite;
        }
        .editor-float-card small,
        .editor-float-card strong,
        .editor-float-card span { display: block; }
        .editor-float-card small { color: var(--startup-primary); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .editor-float-card strong { margin-top: 6px; color: var(--startup-dark); line-height: 1.35; font-weight: 950; }
        .editor-float-card span { margin-top: 4px; color: var(--startup-text); font-size: 12px; font-weight: 800; }
        .editor-float-card.one { left: -18px; top: 74px; width: 190px; }
        .editor-float-card.two { right: -18px; bottom: 145px; width: 210px; animation-delay: -1.2s; }

        .editor-bottom-ribbon {
            margin-top: 34px;
            padding: 16px 22px;
            border-radius: 999px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 16px 36px rgba(15,23,42,.06);
            color: #475569;
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        /* ================= CONTENT SECTIONS ================= */
        .people-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 330px)); justify-content: center; gap: 22px; margin-top: 42px; }

        .person-card,
        .highlight-card,
        .detail-card,
        .gift-card,
        .summary-card,
        .message-card,
        .form-card,
        .gallery-card,
        .closing-card,
        .countdown-card,
        .map-card {
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 18px 46px rgba(15,23,42,.08);
            backdrop-filter: blur(12px);
            color: var(--startup-dark);
        }

        .person-card { position: relative; overflow: hidden; border-radius: 34px; padding: 22px; transition: .35s ease; }
        .person-card::after,
        .highlight-card::after,
        .detail-card::after,
        .gift-card::after { content: ""; position: absolute; width: 150px; height: 150px; right: -58px; bottom: -58px; border-radius: 999px; background: color-mix(in srgb, var(--startup-accent) 42%, transparent); pointer-events: none; }

        .person-photo,
        .person-placeholder {
            position: relative;
            z-index: 2;
            width: 132px;
            height: 132px;
            border-radius: 34px;
            object-fit: cover;
            background: color-mix(in srgb, var(--startup-primary) 10%, #ffffff);
            border: 8px solid rgba(255,255,255,.94);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--startup-primary);
            font-size: 44px;
            font-weight: 950;
        }

        .person-role,
        .message-badge { position: relative; z-index: 2; display: inline-block; margin-top: 18px; padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--startup-primary) 10%, #ffffff); color: var(--startup-primary); font-size: 12px; font-weight: 950; }
        .person-card h3,
        .person-card p { position: relative; z-index: 2; }
        .person-card h3 { margin-top: 16px; color: var(--startup-dark); font-size: 1.65rem; line-height: 1.12; font-weight: 950; }
        .person-card p { margin-top: 8px; color: var(--startup-text); line-height: 1.7; }

        .highlight-grid { display: grid; gap: 20px; margin-top: 42px; justify-content: center; }
        .highlight-grid.count-1 { grid-template-columns: minmax(280px, 560px); }
        .highlight-grid.count-2 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
        .highlight-grid.count-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .highlight-card { position: relative; overflow: hidden; min-height: 236px; padding: 30px; border-radius: 36px; }
        .highlight-number { position: relative; z-index: 2; width: 56px; height: 56px; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary)); font-weight: 950; margin-bottom: 22px; box-shadow: 0 16px 34px color-mix(in srgb, var(--startup-primary) 20%, transparent); }
        .highlight-card h3,
        .highlight-card p { position: relative; z-index: 2; }
        .highlight-card h3 { color: var(--startup-dark); font-size: 1.42rem; font-weight: 950; }
        .highlight-card p { color: var(--startup-text); margin-top: 10px; line-height: 1.8; }

        .detail-layout { display: grid; grid-template-columns: .96fr 1.04fr; gap: 24px; margin-top: 42px; align-items: start; }
        .detail-card { position: relative; overflow: hidden; border-radius: 38px; padding: 32px; }
        .detail-card h3 { position: relative; z-index: 2; color: var(--startup-dark); font-size: 2rem; font-weight: 950; margin: 0; }
        .detail-list { position: relative; z-index: 2; display: grid; gap: 14px; margin-top: 24px; }
        .detail-row { display: grid; grid-template-columns: 120px 1fr; gap: 16px; padding: 16px 0; border-top: 1px dashed color-mix(in srgb, var(--startup-primary) 22%, transparent); }
        .detail-row .label { color: var(--startup-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .detail-row .value { color: var(--startup-dark); font-weight: 900; line-height: 1.65; }

        .countdown-grid { position: relative; z-index: 2; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .countdown-card { padding: 22px 14px; text-align: center; border-radius: 26px; }
        .countdown-number { display: block; color: var(--startup-dark); font-size: 34px; line-height: 1; font-weight: 950; animation: startupNumberGlow 2.4s ease-in-out infinite alternate; }
        .countdown-label { display: block; margin-top: 10px; color: var(--startup-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }

        .map-card { position: relative; z-index: 2; margin-top: 22px; overflow: hidden; border-radius: 32px; }
        .map-frame,
        .map-placeholder { width: 100%; height: 310px; display: block; border: 0; }
        .map-placeholder { display: flex; align-items: center; justify-content: center; padding: 32px; text-align: center; text-decoration: none; color: var(--startup-dark); background: linear-gradient(180deg, #ffffff, #f8fbff); }

        .gallery-startup { display: grid; grid-template-columns: 1.1fr .9fr 1fr; gap: 18px; margin-top: 38px; }
        .gallery-column { display: grid; gap: 18px; }
        .gallery-card { padding: 10px; border-radius: 30px; overflow: hidden; transition: .35s ease; }
        .gallery-card img { width: 100%; object-fit: cover; border-radius: 22px; display: block; transition: .7s ease; }
        .gallery-card.tall img { height: 360px; }
        .gallery-card.short img { height: 220px; }

        .gift-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 34px; }
        .gift-grid.gift-count-1 { grid-template-columns: minmax(280px, 540px); justify-content: center; }
        .gift-card { position: relative; overflow: hidden; border-radius: 36px; padding: 28px; }
        .gift-card h3,
        .gift-copy-box,
        .gift-card p { position: relative; z-index: 2; }
        .gift-card h3 { color: var(--startup-dark); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: color-mix(in srgb, var(--startup-primary) 7%, #ffffff); border: 1px solid rgba(148,163,184,.18); }
        .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 950; color: var(--startup-text); }
        .gift-number { display: block; margin-top: 6px; color: var(--startup-primary); font-size: 1.1rem; font-weight: 950; }
        .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: #fff; font-size: 12px; font-weight: 950; background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary)); }
        .copy-gift-btn.copied { background: linear-gradient(135deg, #16a34a, #22c55e); }

        .rsvp-wrap { max-width: 900px; width: 100%; margin: 0 auto; }
        .form-card,
        .message-card,
        .summary-card { border-radius: 30px; }
        .form-card { padding: 28px; }
        .form-card .uk-label { color: var(--startup-text); font-weight: 800; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
        .summary-card { padding: 20px; text-align: center; }
        .summary-card strong { display: block; color: var(--startup-dark); font-size: 30px; line-height: 1; font-weight: 950; }
        .summary-card span { display: block; margin-top: 8px; color: var(--startup-text); font-size: 12px; font-weight: 950; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; }
        .message-card { padding: 22px; }
        .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .message-info { min-width: 0; flex: 1; }
        .message-badge { margin-top: 0; white-space: nowrap; }

        .closing-card {
            max-width: 880px;
            margin: 0 auto;
            text-align: center;
            border-radius: 44px;
            padding: 52px 36px;
            background:
                radial-gradient(circle at bottom left, color-mix(in srgb, var(--startup-primary) 12%, transparent), transparent 38%),
                radial-gradient(circle at top right, color-mix(in srgb, var(--startup-accent) 30%, transparent), transparent 36%),
                rgba(255,255,255,.92);
        }

        [data-reveal] {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(8px);
            transition: opacity .82s cubic-bezier(.2,.8,.2,1), transform .82s cubic-bezier(.2,.8,.2,1), filter .82s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .35s ease;
            transition-delay: var(--reveal-delay, 0s);
            will-change: opacity, transform, filter;
        }
        [data-reveal="left"] { transform: translateX(-38px) scale(.985); }
        [data-reveal="right"] { transform: translateX(38px) scale(.985); }
        [data-reveal="zoom"] { transform: translateY(22px) scale(.94); }
        [data-reveal].is-visible { opacity: 1; transform: translate(0,0) scale(1); filter: blur(0); }

        @media (hover:hover) {
            .editor-meta-card:hover,
            .editor-vscode-window:hover,
            .person-card:hover,
            .highlight-card:hover,
            .detail-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--startup-primary) 35%, transparent) !important;
                box-shadow: 0 34px 88px color-mix(in srgb, var(--startup-primary) 13%, transparent), 0 0 58px color-mix(in srgb, var(--startup-accent) 17%, transparent), inset 0 1px 0 rgba(255,255,255,.70) !important;
            }
            .editor-vscode-window:hover img,
            .gallery-card:hover img,
            .person-card:hover img { transform: scale(1.035); filter: saturate(1.06) contrast(1.03); }
        }

        .editor-preview-media img,
        .gallery-card img,
        .person-photo { transition: transform .75s ease, filter .75s ease; }

        @keyframes startupGridMove { from { background-position: 0 0, 0 0; } to { background-position: 176px 176px, 176px 176px; } }
        @keyframes startupFloat { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-10px) scale(1.04); } }
        @keyframes startupButtonFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes startupPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.035); } }
        @keyframes startupShine { 0%,48% { left: -80%; } 75%,100% { left: 130%; } }
        @keyframes startupNumberGlow { from { text-shadow: 0 0 8px color-mix(in srgb, var(--startup-accent) 18%, transparent); } to { text-shadow: 0 0 18px color-mix(in srgb, var(--startup-accent) 44%, transparent), 0 0 34px color-mix(in srgb, var(--startup-primary) 16%, transparent); } }

        @media (min-width: 1700px) {
            .startup-shell { width: min(100%, 1680px); }
            .editor-hero-grid { grid-template-columns: minmax(0, 1fr) minmax(520px, 680px); }
            .editor-vscode-window { min-height: 760px; }
            .editor-window-body { min-height: 704px; grid-template-columns: 72px minmax(0, 1fr) minmax(300px, 380px); }
            .editor-preview-card { min-height: 520px; }
        }

        @media (max-width: 1120px) {
            .editor-startup-hero { padding: 116px 42px 72px; }
            .editor-hero-grid { grid-template-columns: 1fr; gap: 36px; }
            .editor-copy { text-align: center; }
            .editor-kicker,
            .editor-actions,
            .editor-chip-row { justify-content: center; margin-left: auto; margin-right: auto; }
            .editor-desc { margin-left: auto; margin-right: auto; }
            .editor-meta-grid { margin-left: auto; margin-right: auto; width: min(100%, 820px); }
            .editor-window-zone { min-height: auto; }
            .editor-float-card { position: relative; left: auto !important; right: auto !important; top: auto !important; bottom: auto !important; width: 100% !important; margin-top: 14px; animation: none; }
            .detail-layout,
            .gift-grid { grid-template-columns: 1fr; }
            .highlight-grid.count-3 { grid-template-columns: repeat(2, minmax(280px, 460px)); }
            .gallery-startup { grid-template-columns: 1fr; }
            .gallery-column { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 820px) {
            .editor-window-body { grid-template-columns: 52px 1fr; }
            .editor-preview-pane { grid-column: 1 / -1; border-left: 0; border-top: 1px solid rgba(148,163,184,.16); }
            .editor-preview-card { min-height: 390px; }
            .editor-preview-media { min-height: 260px; }
            .editor-meta-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .startup-shell { padding: 0; }
            .startup-wrap { border-radius: 0; box-shadow: none; }
            .startup-nav { top: 10px; max-width: calc(100% - 24px); margin: 12px auto -24px; padding: 7px; }
            .startup-nav a { padding: 9px 12px; font-size: 11px; }

            .floating-actions {
                top: auto;
                right: 50%;
                bottom: 14px;
                transform: translateX(50%);
                flex-direction: row;
                gap: 8px;
            }
            .floating-actions a,
            .floating-action-button { width: 42px; height: 42px; }
            .floating-icon { width: 21px; height: 21px; }

            .editor-startup-hero { padding: 96px 22px 76px; }
            .editor-startup-hero::before { inset: 72px 12px 28px; border-radius: 30px; }
            .editor-title { font-size: clamp(2.45rem, 12.8vw, 4rem); line-height: .95; }
            .editor-desc { font-size: 1rem; }
            .editor-actions { display: grid; grid-template-columns: 1fr; }
            .editor-meta-grid { grid-template-columns: 1fr; }
            .editor-vscode-window { min-height: auto; border-radius: 26px; }
            .editor-vscode-window::before { inset: 9px; border-radius: 18px; }
            .editor-window-top { height: auto; padding: 14px; flex-wrap: wrap; }
            .editor-tabs { margin-left: 0; width: 100%; overflow-x: auto; flex-wrap: nowrap; padding-bottom: 2px; scrollbar-width: none; }
            .editor-tabs::-webkit-scrollbar { display: none; }
            .editor-tab { flex: 0 0 auto; }
            .editor-window-body { grid-template-columns: 1fr; min-height: auto; }
            .editor-sidebar { display: none; }
            .editor-code-pane { padding: 18px; max-height: 380px; overflow: auto; }
            .editor-code-lines { font-size: 12px; gap: 8px; }
            .editor-preview-pane { padding: 16px; }
            .editor-preview-card { min-height: 340px; }
            .editor-preview-media { min-height: 230px; padding: 14px; }
            .editor-preview-media > img { height: auto; max-height: 260px; }
            .editor-bottom-ribbon { border-radius: 24px; line-height: 1.6; margin-bottom: 56px; }

            .startup-section { padding: 72px 22px; }
            .startup-section.compact { padding-top: 64px; padding-bottom: 64px; }
            .startup-title { font-size: clamp(2.2rem, 11vw, 3.5rem); }
            .highlight-grid,
            .highlight-grid.count-1,
            .highlight-grid.count-2,
            .highlight-grid.count-3,
            .countdown-grid,
            .summary-grid,
            .gift-grid,
            .gift-grid.gift-count-1,
            .gallery-column { grid-template-columns: 1fr; }
            .detail-row { grid-template-columns: 1fr; gap: 6px; }
            .gift-copy-box { align-items: flex-start; flex-direction: column; }
            .copy-gift-btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
            [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        }


        /* =========================================================
           FINAL RESPONSIVE FIX - CENTER, FLOAT BUTTON RIGHT, MODE CARD BELOW
           Tambahan override paling akhir agar aman HP - 4K
        ========================================================= */
        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden !important;
        }

        .startup-wrap,
        .editor-startup-hero,
        .editor-hero-grid,
        .editor-window-zone,
        .editor-vscode-window {
            max-width: 100%;
        }

        .editor-copy {
            min-width: 0;
        }

        .editor-title,
        .editor-desc,
        .editor-kicker,
        .editor-chip-row,
        .editor-actions,
        .editor-meta-grid {
            max-width: 100%;
        }

        .editor-title {
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .editor-preview-media img,
        .editor-preview-fallback img {
            width: auto !important;
            height: auto !important;
            max-width: 100% !important;
            max-height: 100% !important;
            object-fit: contain !important;
        }

        .editor-preview-media {
            overflow: hidden;
        }

        /* Tombol samping selalu di sisi kanan, bukan di bawah */
        .floating-actions {
            position: fixed !important;
            right: clamp(8px, 1.4vw, 22px) !important;
            top: 50% !important;
            bottom: auto !important;
            left: auto !important;
            transform: translateY(-50%) !important;
            flex-direction: column !important;
            z-index: 120 !important;
        }

        /* Laptop kecil/tablet: window di atas, card Mode/Theme turun di bawah */
        @media (max-width: 1120px) {
            .editor-startup-hero {
                text-align: center;
                padding-left: clamp(18px, 4vw, 42px) !important;
                padding-right: clamp(18px, 4vw, 42px) !important;
            }

            .editor-hero-grid {
                width: 100%;
                grid-template-columns: minmax(0, 1fr) !important;
                justify-items: center;
                align-items: start;
            }

            .editor-copy {
                width: min(100%, 920px);
                margin-left: auto;
                margin-right: auto;
                text-align: center !important;
            }

            .editor-title,
            .editor-desc {
                margin-left: auto !important;
                margin-right: auto !important;
                text-align: center !important;
            }

            .editor-kicker,
            .editor-chip-row,
            .editor-actions {
                justify-content: center !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .editor-chip-row {
                width: min(100%, 760px);
            }

            .editor-meta-grid {
                width: min(100%, 820px) !important;
            }

            .editor-window-zone {
                width: min(100%, 980px);
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 14px;
                align-items: start;
                justify-items: stretch;
                margin-left: auto;
                margin-right: auto;
                min-height: auto !important;
            }

            .editor-vscode-window {
                width: 100%;
                grid-row: 1;
            }

            .editor-float-card {
                position: static !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                width: 100% !important;
                margin: 0 !important;
                transform: none !important;
                animation: none !important;
                text-align: left;
            }

            .editor-float-card.one {
                grid-row: 2;
            }

            .editor-float-card.two {
                grid-row: 3;
            }
        }

        @media (min-width: 641px) and (max-width: 1120px) {
            .editor-window-zone {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .editor-vscode-window {
                grid-column: 1 / -1;
            }

            .editor-float-card.one,
            .editor-float-card.two {
                grid-row: auto;
            }
        }

        /* HP: semua center, tidak kepotong, tombol tetap kanan */
        @media (max-width: 640px) {
            .startup-shell {
                padding: 0 !important;
            }

            .startup-wrap {
                border-radius: 0 !important;
            }

            .editor-startup-hero {
                padding: 96px 16px 68px !important;
            }

            .editor-startup-hero::before {
                inset: 72px 8px 28px !important;
            }

            .editor-title {
                width: 100%;
                max-width: 360px;
                font-size: clamp(2.25rem, 11.6vw, 3.35rem) !important;
                line-height: 1.02 !important;
                letter-spacing: -.055em !important;
                text-align: center !important;
            }

            .editor-desc {
                width: min(100%, 360px);
                font-size: .98rem !important;
                line-height: 1.8 !important;
                text-align: center !important;
            }

            .editor-kicker {
                max-width: 100%;
                white-space: normal;
                line-height: 1.45;
                justify-content: center;
                text-align: center;
            }

            .editor-chip-row {
                width: min(100%, 360px);
                justify-content: center !important;
                gap: 10px;
            }

            .editor-chip {
                max-width: 100%;
                white-space: normal;
                text-align: center;
            }

            .editor-actions {
                width: min(100%, 360px);
            }

            .editor-actions .startup-btn {
                width: 100%;
            }

            .editor-meta-grid {
                width: min(100%, 360px) !important;
            }

            .editor-window-zone {
                width: 100%;
            }

            .editor-vscode-window {
                border-radius: 24px !important;
                overflow: hidden;
            }

            .editor-window-top {
                justify-content: center;
            }

            .editor-window-dots {
                width: 100%;
                justify-content: center;
            }

            .editor-window-body {
                grid-template-columns: 1fr !important;
            }

            .editor-sidebar {
                display: none !important;
            }

            .editor-code-pane {
                max-height: 330px !important;
                overflow: auto !important;
            }

            .editor-code-lines {
                font-size: 11.5px !important;
            }

            .code-line {
                grid-template-columns: 26px minmax(0, 1fr) !important;
                gap: 8px !important;
            }

            .code-line > div {
                min-width: 0;
                overflow-wrap: anywhere;
            }

            .editor-preview-pane {
                padding: 14px !important;
            }

            .editor-preview-card {
                min-height: auto !important;
            }

            .editor-preview-media {
                min-height: 240px !important;
                height: auto !important;
                padding: 14px !important;
            }

            .editor-preview-footer {
                text-align: center;
            }

            .editor-float-card {
                text-align: center;
            }

            .floating-actions {
                right: 8px !important;
                top: 50% !important;
                bottom: auto !important;
                transform: translateY(-50%) scale(.88) !important;
                transform-origin: right center;
                flex-direction: column !important;
                gap: 8px !important;
            }

            .floating-actions a,
            .floating-action-button {
                width: 42px !important;
                height: 42px !important;
            }

            .editor-bottom-ribbon {
                margin-bottom: 0 !important;
            }
        }

        /* Layar besar/4K: tetap proporsional dan center */
        @media (min-width: 1700px) {
            .startup-shell {
                width: min(100%, 1720px);
            }

            .editor-hero-grid {
                grid-template-columns: minmax(0, 1fr) minmax(560px, 720px) !important;
                gap: 64px;
            }

            .editor-window-zone {
                min-height: 780px;
            }

            .editor-vscode-window {
                min-height: 760px;
            }

            .editor-window-body {
                min-height: 704px;
                grid-template-columns: 72px minmax(0, 1fr) minmax(280px, 360px);
            }

            .editor-preview-media {
                min-height: 380px;
            }
        }

        /* =========================================================
        FIX TEKS PUTIH - CORPORATE STARTUP EVENT WHITE THEME
        ========================================================= */

        /* Paksa semua section utama kembali ke warna gelap */
        #about,
        #detail,
        #gallery,
        #gift,
        #message,
        #closing {
            color: var(--startup-dark) !important;
        }

        /* Judul section */
        #about .startup-title,
        #detail .startup-title,
        #gallery .startup-title,
        #gift .startup-title,
        #message .startup-title,
        #closing .startup-title {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        /* Deskripsi section */
        #about .section-desc,
        #detail .section-desc,
        #gallery .section-desc,
        #gift .section-desc,
        #message .section-desc,
        #closing .section-desc {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* ================= CLOSING / THANK YOU ================= */

        #closing .closing-card {
            color: var(--startup-dark) !important;
        }

        #closing .closing-card h2 {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
            background: none !important;
        }

        #closing .closing-card h3 {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        #closing .closing-card p:not(.startup-label),
        #closing .closing-card .responsive-text:not(.startup-title):not(.startup-label) {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* Override inline style putih di closing */
        #closing .closing-card [style*="color: #fff"],
        #closing .closing-card [style*="color:#fff"],
        #closing .closing-card [style*="255,255,255"],
        #closing .closing-card [style*="255, 255, 255"] {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* Khusus judul event terakhir di closing */
        #closing .closing-card h3[style*="color"],
        #closing .closing-card h3.responsive-text {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        /* ================= SUPPORT / PARTNER ================= */

        #gift .gift-card,
        #gift .gift-card * {
            color: inherit;
        }

        #gift .gift-card h3 {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        #gift .gift-copy-box {
            background: color-mix(in srgb, var(--startup-primary) 7%, #ffffff) !important;
        }

        #gift .gift-copy-box small {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        #gift .gift-number {
            color: var(--startup-primary) !important;
            -webkit-text-fill-color: var(--startup-primary) !important;
        }

        #gift .gift-copy-box p,
        #gift .gift-copy-box .text-sm,
        #gift .gift-copy-box span,
        #gift .gift-copy-box [style*="color"] {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* Tombol salin tetap putih karena background warna */
        #gift .copy-gift-btn,
        #gift .copy-gift-btn * {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        /* ================= MESSAGE / RSVP ================= */

        #message .message-card {
            color: var(--startup-dark) !important;
        }

        #message .message-info .font-black,
        #message .message-card .font-black {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        #message .message-card p,
        #message .message-card .text-xs,
        #message .message-card .leading-7 {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* Override inline style putih di message */
        #message .message-card [style*="color: #fff"],
        #message .message-card [style*="color:#fff"],
        #message .message-card [style*="255,255,255"],
        #message .message-card [style*="255, 255, 255"] {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        /* Nama tamu tetap gelap */
        #message .message-info .font-black[style*="color"],
        #message .message-card p.font-black[style*="color"] {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        /* Badge status tetap warna tema */
        #message .message-badge {
            color: var(--startup-primary) !important;
            -webkit-text-fill-color: var(--startup-primary) !important;
            background: color-mix(in srgb, var(--startup-primary) 10%, #ffffff) !important;
        }

        /* ================= DETAIL / MAP TEXT ================= */

        #detail .detail-card h3,
        #detail .detail-row .value {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        #detail .detail-row .label,
        #detail .map-placeholder p:not(.font-black):not(.font-bold) {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        #detail .map-placeholder .font-black {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
        }

        #detail .map-placeholder .font-bold {
            color: var(--startup-primary) !important;
            -webkit-text-fill-color: var(--startup-primary) !important;
        }

        /* ================= FORM INPUT TEXT ================= */

        #message .form-card label,
        #message .form-card .uk-label {
            color: var(--startup-text) !important;
            -webkit-text-fill-color: var(--startup-text) !important;
        }

        #message .form-card input,
        #message .form-card select,
        #message .form-card textarea {
            color: var(--startup-dark) !important;
            -webkit-text-fill-color: var(--startup-dark) !important;
            background: #ffffff !important;
        }

        #message .form-card input::placeholder,
        #message .form-card textarea::placeholder {
            color: #94a3b8 !important;
            -webkit-text-fill-color: #94a3b8 !important;
        }


        /* =========================================================
           CORPORATE GRAND OPENING PRO - PROFESSIONAL CALM HERO
           Tambahan CSS khusus template corporate-grand-opening-pro
        ========================================================= */
        .grand-opening-hero {
            position: relative;
            min-height: 100vh;
            padding: clamp(106px, 8vw, 146px) clamp(20px, 4.8vw, 74px) clamp(66px, 6vw, 92px);
            overflow: hidden;
            isolation: isolate;
        }

        .grand-opening-hero::before {
            content: "";
            position: absolute;
            inset: 72px clamp(12px, 1.8vw, 28px) 38px;
            z-index: -2;
            border-radius: clamp(30px, 3vw, 46px);
            background:
                radial-gradient(circle at 13% 12%, color-mix(in srgb, var(--startup-primary) 10%, transparent), transparent 28%),
                radial-gradient(circle at 88% 18%, color-mix(in srgb, var(--startup-secondary) 12%, transparent), transparent 32%),
                radial-gradient(circle at 72% 94%, color-mix(in srgb, var(--startup-accent) 42%, transparent), transparent 34%),
                linear-gradient(135deg, rgba(255,255,255,.94), color-mix(in srgb, var(--startup-soft) 76%, white));
            border: 1px solid rgba(255,255,255,.74);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.92), 0 34px 92px rgba(15,23,42,.08);
        }

        .grand-opening-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            opacity: .12;
            pointer-events: none;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--startup-primary) 18%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--startup-primary) 18%, transparent) 1px, transparent 1px);
            background-size: 52px 52px;
            animation: startupGridMove 28s linear infinite;
        }

        .go-orb,
        .go-line,
        .go-mark {
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }

        .go-orb {
            border-radius: 999px;
            filter: blur(1px);
            opacity: .62;
            animation: startupFloat 7.8s ease-in-out infinite;
        }

        .go-orb.one { width: 240px; height: 240px; left: 2%; top: 13%; background: color-mix(in srgb, var(--startup-primary) 12%, transparent); }
        .go-orb.two { width: 320px; height: 320px; right: 3%; top: 10%; background: color-mix(in srgb, var(--startup-secondary) 11%, transparent); animation-delay: -2s; }
        .go-orb.three { width: 155px; height: 155px; left: 47%; bottom: 12%; background: color-mix(in srgb, var(--startup-accent) 54%, transparent); animation-delay: -3.1s; }

        .go-line { height: 1px; background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--startup-primary) 32%, transparent), transparent); opacity: .70; }
        .go-line.one { width: 300px; left: 56px; top: 166px; }
        .go-line.two { width: 260px; right: 70px; bottom: 120px; }

        .go-mark {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 0 24px color-mix(in srgb, var(--startup-primary) 34%, transparent);
            animation: startupPulse 3.6s ease-in-out infinite;
        }
        .go-mark.one { left: 9%; top: 30%; }
        .go-mark.two { right: 11%; top: 36%; animation-delay: -.8s; }
        .go-mark.three { left: 56%; bottom: 18%; animation-delay: -1.5s; }

        .go-hero-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, .98fr) minmax(420px, 620px);
            gap: clamp(30px, 4vw, 58px);
            align-items: center;
        }

        .go-copy { min-width: 0; }

        .go-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.18);
            color: var(--startup-primary);
            box-shadow: 0 14px 34px rgba(15,23,42,.06);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
        }

        .go-kicker::before {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: inset 0 0 0 8px rgba(255,255,255,.28), 0 0 18px color-mix(in srgb, var(--startup-primary) 28%, transparent);
        }

        .go-title {
            margin-top: 26px;
            max-width: 820px;
            color: var(--startup-dark);
            font-size: clamp(3rem, 6.4vw, 6.7rem);
            line-height: .88;
            letter-spacing: -.078em;
            font-weight: 950;
        }

        .go-title span {
            background: linear-gradient(135deg, var(--startup-dark), var(--startup-primary), var(--startup-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .go-desc {
            max-width: 690px;
            margin-top: 24px;
            color: var(--startup-text);
            font-size: 1.05rem;
            line-height: 1.9;
        }

        .go-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .go-metrics {
            margin-top: 32px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .go-metric-card {
            position: relative;
            overflow: hidden;
            min-height: 132px;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 16px 38px rgba(15,23,42,.07);
        }

        .go-metric-card::after {
            content: "";
            position: absolute;
            right: -34px;
            bottom: -34px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--startup-accent) 38%, transparent);
        }

        .go-metric-card small,
        .go-metric-card strong,
        .go-metric-card span { position: relative; z-index: 2; display: block; }
        .go-metric-card small { color: var(--startup-primary); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .go-metric-card strong { margin-top: 9px; color: var(--startup-dark); line-height: 1.35; font-weight: 950; }
        .go-metric-card span { margin-top: 6px; color: var(--startup-text); font-size: 13px; line-height: 1.45; font-weight: 800; }

        .go-showcase {
            position: relative;
            min-height: 690px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .go-main-card {
            position: relative;
            width: min(100%, 560px);
            min-height: 650px;
            border-radius: 44px;
            overflow: hidden;
            background:
                radial-gradient(circle at 22% 14%, rgba(255,255,255,.82), transparent 26%),
                linear-gradient(135deg, color-mix(in srgb, var(--startup-primary) 10%, white), color-mix(in srgb, var(--startup-soft) 80%, white));
            border: 1px solid color-mix(in srgb, var(--startup-primary) 16%, transparent);
            box-shadow: 0 38px 100px color-mix(in srgb, var(--startup-primary) 15%, transparent), inset 0 1px 0 rgba(255,255,255,.88);
        }

        .go-main-card::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 32px;
            border: 1px dashed color-mix(in srgb, var(--startup-primary) 24%, transparent);
            z-index: 5;
            pointer-events: none;
        }

        .go-card-top {
            position: absolute;
            left: 28px;
            right: 28px;
            top: 24px;
            z-index: 8;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
        }

        .go-card-dots { display: flex; gap: 7px; }
        .go-card-dots span { width: 10px; height: 10px; border-radius: 999px; background: color-mix(in srgb, var(--startup-primary) 36%, white); }
        .go-card-dots span:nth-child(2) { background: color-mix(in srgb, var(--startup-secondary) 38%, white); }
        .go-card-dots span:nth-child(3) { background: color-mix(in srgb, var(--startup-accent) 86%, white); }

        .go-card-badge {
            padding: 8px 12px;
            border-radius: 999px;
            color: var(--startup-primary);
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(148,163,184,.16);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .go-image-wrap {
            position: absolute;
            inset: 74px 28px 126px;
            border-radius: 34px;
            overflow: hidden;
            background: rgba(255,255,255,.70);
            border: 1px solid rgba(148,163,184,.13);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.80);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .go-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .go-image-wrap.contain-img img { object-fit: contain; padding: 24px; }

        .go-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 48%, rgba(15,23,42,.35));
            pointer-events: none;
        }

        .go-event-panel {
            position: absolute;
            z-index: 9;
            left: 48px;
            right: 48px;
            bottom: 44px;
            padding: 22px;
            border-radius: 28px;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 20px 42px rgba(15,23,42,.10);
            backdrop-filter: blur(14px);
        }

        .go-event-panel small,
        .go-event-panel strong,
        .go-event-panel span { display: block; }
        .go-event-panel small { color: var(--startup-primary); font-size: 10px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; }
        .go-event-panel strong { margin-top: 8px; color: var(--startup-dark); font-size: clamp(1.45rem, 2.4vw, 2rem); line-height: 1.1; font-weight: 950; }
        .go-event-panel span { margin-top: 8px; color: var(--startup-text); line-height: 1.55; font-weight: 800; }

        .go-floating-card {
            position: absolute;
            z-index: 12;
            width: 210px;
            padding: 18px;
            border-radius: 26px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 22px 52px rgba(15,23,42,.12);
            backdrop-filter: blur(14px);
            animation: startupFloat 5.5s ease-in-out infinite;
        }

        .go-floating-card small,
        .go-floating-card strong,
        .go-floating-card span { display: block; }
        .go-floating-card small { color: var(--startup-primary); font-size: 10px; letter-spacing: .16em; text-transform: uppercase; font-weight: 950; }
        .go-floating-card strong { margin-top: 7px; color: var(--startup-dark); line-height: 1.35; font-weight: 950; }
        .go-floating-card span { margin-top: 5px; color: var(--startup-text); font-size: 12px; line-height: 1.45; font-weight: 800; }

        .go-floating-card.mode { left: -14px; top: 100px; }
        .go-floating-card.host { right: -16px; bottom: 125px; animation-delay: -1.3s; }

        .go-ribbon {
            position: relative;
            z-index: 2;
            margin-top: 34px;
            padding: 16px 22px;
            border-radius: 999px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 16px 36px rgba(15,23,42,.06);
            color: var(--startup-text);
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .go-date-line { white-space: normal; }

        @media (max-width: 1120px) {
            .grand-opening-hero { text-align: center; padding-left: clamp(18px, 4vw, 42px); padding-right: clamp(18px, 4vw, 42px); }
            .go-hero-grid { grid-template-columns: 1fr; justify-items: center; }
            .go-copy { width: min(100%, 920px); text-align: center; }
            .go-title,
            .go-desc { margin-left: auto; margin-right: auto; text-align: center; }
            .go-kicker,
            .go-actions { justify-content: center; margin-left: auto; margin-right: auto; }
            .go-metrics { width: min(100%, 820px); margin-left: auto; margin-right: auto; }
            .go-showcase { min-height: auto; width: min(100%, 860px); display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
            .go-main-card { grid-column: 1 / -1; width: 100%; min-height: 560px; }
            .go-floating-card { position: relative; left: auto !important; right: auto !important; top: auto !important; bottom: auto !important; width: 100%; animation: none; text-align: left; }
        }

        @media (max-width: 720px) {
            .grand-opening-hero { padding: 96px 16px 68px; }
            .grand-opening-hero::before { inset: 72px 8px 28px; border-radius: 30px; }
            .go-title { width: 100%; max-width: 380px; font-size: clamp(2.35rem, 11.5vw, 3.55rem); line-height: 1; letter-spacing: -.058em; }
            .go-desc { width: min(100%, 380px); font-size: .98rem; line-height: 1.8; }
            .go-kicker { max-width: 100%; white-space: normal; line-height: 1.45; justify-content: center; text-align: center; }
            .go-actions { width: min(100%, 380px); display: grid; grid-template-columns: 1fr; }
            .go-actions .startup-btn { width: 100%; }
            .go-metrics { grid-template-columns: 1fr; width: min(100%, 380px); }
            .go-showcase { width: 100%; grid-template-columns: 1fr; }
            .go-main-card { min-height: 500px; border-radius: 30px; }
            .go-main-card::before { inset: 10px; border-radius: 22px; }
            .go-card-top { left: 18px; right: 18px; top: 18px; }
            .go-image-wrap { inset: 62px 18px 128px; border-radius: 24px; }
            .go-event-panel { left: 28px; right: 28px; bottom: 28px; padding: 18px; text-align: center; }
            .go-floating-card { text-align: center; }
            .go-ribbon { border-radius: 24px; line-height: 1.6; }
        }

        /* =========================================================
        GRAND OPENING PRO - HERO V2 RIBBON GATE
        Rombak total hero agar berbeda dari template corporate lain
        ========================================================= */

        .go-pro-hero-v2 {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            padding: clamp(104px, 8vw, 142px) clamp(18px, 4.8vw, 76px) clamp(64px, 6vw, 92px);
            isolation: isolate;
        }

        .go-pro-hero-v2::before {
            content: "";
            position: absolute;
            inset: 72px clamp(10px, 1.8vw, 28px) 38px;
            z-index: -3;
            border-radius: clamp(28px, 3vw, 48px);
            background:
                linear-gradient(115deg, rgba(255,255,255,.96) 0%, rgba(255,255,255,.90) 42%, color-mix(in srgb, var(--startup-soft) 82%, #ffffff) 100%),
                radial-gradient(circle at 14% 14%, color-mix(in srgb, var(--startup-primary) 12%, transparent), transparent 30%),
                radial-gradient(circle at 88% 18%, color-mix(in srgb, var(--startup-secondary) 14%, transparent), transparent 34%);
            border: 1px solid rgba(255,255,255,.78);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.94),
                0 36px 96px rgba(15,23,42,.10);
        }

        .go-pro-hero-v2::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -2;
            opacity: .13;
            pointer-events: none;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--startup-primary) 18%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--startup-primary) 18%, transparent) 1px, transparent 1px);
            background-size: 54px 54px;
            animation: startupGridMove 28s linear infinite;
        }

        .go-pro-bg-orb,
        .go-pro-line,
        .go-pro-dot {
            position: absolute;
            pointer-events: none;
            z-index: -1;
        }

        .go-pro-bg-orb {
            border-radius: 999px;
            filter: blur(1px);
            opacity: .65;
            animation: startupFloat 7.6s ease-in-out infinite;
        }

        .go-pro-bg-orb.one {
            width: 260px;
            height: 260px;
            left: 3%;
            top: 14%;
            background: color-mix(in srgb, var(--startup-primary) 12%, transparent);
        }

        .go-pro-bg-orb.two {
            width: 330px;
            height: 330px;
            right: 4%;
            top: 10%;
            background: color-mix(in srgb, var(--startup-secondary) 13%, transparent);
            animation-delay: -1.8s;
        }

        .go-pro-bg-orb.three {
            width: 170px;
            height: 170px;
            left: 47%;
            bottom: 10%;
            background: color-mix(in srgb, var(--startup-accent) 58%, transparent);
            animation-delay: -3s;
        }

        .go-pro-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, color-mix(in srgb, var(--startup-primary) 30%, transparent), transparent);
        }

        .go-pro-line.one {
            width: 280px;
            left: 6%;
            top: 172px;
        }

        .go-pro-line.two {
            width: 260px;
            right: 8%;
            bottom: 126px;
        }

        .go-pro-dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 0 24px color-mix(in srgb, var(--startup-primary) 34%, transparent);
            animation: startupPulse 3.4s ease-in-out infinite;
        }

        .go-pro-dot.one { left: 12%; top: 34%; }
        .go-pro-dot.two { right: 12%; top: 36%; animation-delay: -.8s; }
        .go-pro-dot.three { left: 59%; bottom: 17%; animation-delay: -1.4s; }

        .go-pro-layout {
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 210px);
            display: grid;
            grid-template-columns: minmax(170px, 220px) minmax(0, 1fr) minmax(360px, 520px);
            gap: clamp(22px, 3vw, 46px);
            align-items: center;
        }

        /* LEFT CEREMONY RAIL */
        .go-pro-rail {
            position: relative;
            display: grid;
            gap: 14px;
            align-self: stretch;
            align-content: center;
        }

        .go-pro-rail::before {
            content: "";
            position: absolute;
            top: 9%;
            bottom: 9%;
            left: 26px;
            width: 1px;
            background: linear-gradient(180deg, transparent, color-mix(in srgb, var(--startup-primary) 32%, transparent), transparent);
        }

        .go-pro-rail-card {
            position: relative;
            min-height: 132px;
            padding: 20px 18px 20px 54px;
            border-radius: 28px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 18px 42px rgba(15,23,42,.075);
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .go-pro-rail-card::before {
            content: "";
            position: absolute;
            left: 18px;
            top: 24px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 0 0 7px color-mix(in srgb, var(--startup-primary) 10%, transparent);
        }

        .go-pro-rail-card::after {
            content: "";
            position: absolute;
            right: -36px;
            bottom: -36px;
            width: 92px;
            height: 92px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--startup-accent) 42%, transparent);
        }

        .go-pro-rail-card small,
        .go-pro-rail-card strong,
        .go-pro-rail-card span {
            position: relative;
            z-index: 2;
            display: block;
        }

        .go-pro-rail-card small {
            color: var(--startup-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .go-pro-rail-card strong {
            margin-top: 8px;
            color: var(--startup-dark);
            font-size: 1.02rem;
            line-height: 1.35;
            font-weight: 950;
        }

        .go-pro-rail-card span {
            margin-top: 6px;
            color: var(--startup-text);
            font-size: 13px;
            line-height: 1.5;
            font-weight: 800;
        }

        /* CENTER COPY */
        .go-pro-copy {
            min-width: 0;
        }

        .go-pro-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.90);
            border: 1px solid rgba(148,163,184,.18);
            color: var(--startup-primary);
            box-shadow: 0 14px 34px rgba(15,23,42,.06);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .17em;
            text-transform: uppercase;
        }

        .go-pro-kicker::before {
            content: "";
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background:
                radial-gradient(circle at center, #ffffff 0 25%, transparent 26%),
                linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 0 18px color-mix(in srgb, var(--startup-primary) 28%, transparent);
        }

        .go-pro-title {
            margin-top: 24px;
            max-width: 780px;
            color: var(--startup-dark);
            font-size: clamp(3.2rem, 6.6vw, 7.2rem);
            line-height: .87;
            letter-spacing: -.085em;
            font-weight: 950;
        }

        .go-pro-title span {
            background: linear-gradient(135deg, var(--startup-dark), var(--startup-primary), var(--startup-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .go-pro-desc {
            max-width: 690px;
            margin-top: 24px;
            color: var(--startup-text);
            font-size: 1.05rem;
            line-height: 1.92;
        }

        .go-pro-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .go-pro-ribbon-strip {
            width: min(100%, 760px);
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .go-pro-ribbon-strip span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 9px 13px;
            border-radius: 999px;
            color: var(--startup-dark);
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 12px 26px rgba(15,23,42,.055);
            font-size: 12px;
            font-weight: 900;
        }

        .go-pro-ribbon-strip span::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
        }

        /* RIGHT CEREMONY GATE */
        .go-pro-stage {
            position: relative;
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .go-pro-gate {
            position: relative;
            width: min(100%, 500px);
            min-height: 630px;
            border-radius: 999px 999px 46px 46px;
            padding: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,.76), rgba(255,255,255,.96)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--startup-accent) 58%, transparent), transparent 55%);
            border: 1px solid color-mix(in srgb, var(--startup-primary) 18%, transparent);
            box-shadow:
                0 34px 88px rgba(15,23,42,.10),
                inset 0 1px 0 rgba(255,255,255,.92);
            overflow: hidden;
        }

        .go-pro-gate::before {
            content: "";
            position: absolute;
            inset: 16px;
            border-radius: 999px 999px 34px 34px;
            border: 1px dashed color-mix(in srgb, var(--startup-primary) 24%, transparent);
            pointer-events: none;
            z-index: 7;
        }

        .go-pro-gate::after {
            display: none;
            content: none;
        }

        .go-pro-photo-frame {
            position: absolute;
            inset: 54px 28px 170px 28px;
            z-index: 2;
            overflow: hidden;
            border-radius: 999px 999px 28px 28px;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.82);
            background-color: #f8f6ef;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .go-pro-photo-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            padding: 30px;
        }

        .go-pro-photo-fallback img {
            width: min(100%, 210px);
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 20px 40px color-mix(in srgb, var(--startup-primary) 16%, transparent));
        }

        .go-pro-badge-top {
            position: absolute;
            top: 28px;
            right: 32px;
            z-index: 9;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(148,163,184,.16);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            color: var(--startup-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .go-pro-badge-top::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
        }

        .go-pro-ceremony-panel {
            position: absolute;
            left: 42px;
            right: 42px;
            bottom: 34px;
            z-index: 10;
            padding: 22px;
            border-radius: 30px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 20px 46px rgba(15,23,42,.11);
            backdrop-filter: blur(14px);
        }

        .go-pro-ceremony-panel small,
        .go-pro-ceremony-panel strong,
        .go-pro-ceremony-panel span {
            display: block;
        }

        .go-pro-ceremony-panel small {
            color: var(--startup-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .go-pro-ceremony-panel strong {
            margin-top: 9px;
            color: var(--startup-dark);
            font-size: clamp(1.6rem, 2.6vw, 2.35rem);
            line-height: 1.02;
            letter-spacing: -.04em;
            font-weight: 950;
        }

        .go-pro-ceremony-panel span {
            margin-top: 8px;
            color: var(--startup-text);
            font-size: 13px;
            line-height: 1.45;
            font-weight: 800;
        }

        .go-pro-seal {
            position: absolute;
            right: -20px;
            top: 44%;
            z-index: 12;
            width: 132px;
            height: 132px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 18px;
            color: #ffffff;
            background:
                radial-gradient(circle at 30% 25%, rgba(255,255,255,.28), transparent 30%),
                linear-gradient(135deg, var(--startup-primary), var(--startup-secondary));
            box-shadow: 0 24px 54px color-mix(in srgb, var(--startup-primary) 28%, transparent);
            animation: startupFloat 5.4s ease-in-out infinite;
        }

        .go-pro-seal strong {
            display: block;
            font-size: 1.35rem;
            line-height: .95;
            font-weight: 950;
        }

        .go-pro-seal span {
            display: block;
            margin-top: 5px;
            font-size: 9px;
            font-weight: 950;
            letter-spacing: .14em;
            text-transform: uppercase;
            opacity: .92;
        }

        .go-pro-host-card {
            position: absolute;
            left: -24px;
            bottom: 138px;
            z-index: 11;
            width: 230px;
            padding: 18px 20px;
            border-radius: 26px;
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(148,163,184,.18);
            box-shadow: 0 20px 46px rgba(15,23,42,.10);
            backdrop-filter: blur(14px);
            animation: startupFloat 5.8s ease-in-out -.8s infinite;
        }

        .go-pro-host-card small,
        .go-pro-host-card strong,
        .go-pro-host-card span {
            display: block;
        }

        .go-pro-host-card small {
            color: var(--startup-primary);
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .go-pro-host-card strong {
            margin-top: 7px;
            color: var(--startup-dark);
            line-height: 1.35;
            font-weight: 950;
        }

        .go-pro-host-card span {
            margin-top: 5px;
            color: var(--startup-text);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
        }

        /* Responsive */
        @media (max-width: 1180px) {
            .go-pro-layout {
                grid-template-columns: 1fr;
                min-height: auto;
                justify-items: center;
                text-align: center;
            }

            .go-pro-copy {
                width: min(100%, 920px);
                order: 1;
            }

            .go-pro-rail {
                width: min(100%, 920px);
                grid-template-columns: repeat(3, minmax(0, 1fr));
                align-self: auto;
                order: 2;
            }

            .go-pro-rail::before {
                display: none;
            }

            .go-pro-stage {
                width: min(100%, 720px);
                min-height: auto;
                order: 3;
            }

            .go-pro-kicker,
            .go-pro-actions,
            .go-pro-ribbon-strip {
                justify-content: center;
                margin-left: auto;
                margin-right: auto;
            }

            .go-pro-title,
            .go-pro-desc {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }

            .go-pro-gate {
                min-height: 590px;
            }

            .go-pro-host-card,
            .go-pro-seal {
                position: relative;
                left: auto;
                right: auto;
                top: auto;
                bottom: auto;
                width: 100%;
                height: auto;
                margin-top: 14px;
                border-radius: 26px;
                animation: none;
            }

            .go-pro-seal {
                color: #ffffff;
                min-height: 96px;
            }
        }

        @media (max-width: 760px) {
            .go-pro-hero-v2 {
                padding: 96px 16px 68px;
            }

            .go-pro-hero-v2::before {
                inset: 72px 8px 28px;
                border-radius: 30px;
            }

            .go-pro-title {
                width: 100%;
                max-width: 390px;
                font-size: clamp(2.45rem, 12vw, 3.75rem);
                line-height: 1;
                letter-spacing: -.06em;
            }

            .go-pro-desc {
                width: min(100%, 390px);
                font-size: .98rem;
                line-height: 1.82;
            }

            .go-pro-kicker {
                max-width: 100%;
                white-space: normal;
                line-height: 1.45;
                justify-content: center;
                text-align: center;
            }

            .go-pro-actions {
                width: min(100%, 390px);
                display: grid;
                grid-template-columns: 1fr;
            }

            .go-pro-actions .startup-btn {
                width: 100%;
            }

            .go-pro-ribbon-strip {
                width: min(100%, 390px);
            }

            .go-pro-ribbon-strip span {
                flex: 1 1 100%;
                justify-content: center;
            }

            .go-pro-rail {
                width: min(100%, 390px);
                grid-template-columns: 1fr;
            }

            .go-pro-rail-card {
                min-height: auto;
                text-align: left;
            }

            .go-pro-stage {
                width: 100%;
            }

            .go-pro-gate {
                width: min(100%, 390px);
                min-height: 510px;
                border-radius: 999px 999px 32px 32px;
                padding: 18px;
            }

            .go-pro-gate::before {
                inset: 10px;
                border-radius: 999px 999px 24px 24px;
            }

            .go-pro-gate::after {
                left: 10px;
                top: 96px;
                font-size: 10px;
                letter-spacing: .22em;
            }

             .go-pro-photo-frame {
                inset: 42px 18px 142px 18px;
                border-radius: 999px 999px 22px 22px;
                background-size: cover;
                background-position: center top;
            }

            .go-pro-badge-top {
                top: 20px;
                right: 24px;
                font-size: 9px;
            }

            .go-pro-ceremony-panel {
                left: 24px;
                right: 24px;
                bottom: 24px;
                padding: 18px;
                border-radius: 24px;
                text-align: center;
            }

            .go-pro-ceremony-panel strong {
                font-size: 1.55rem;
            }
        }

        /* =========================================================
        FIX UKURAN JUDUL UTAMA HERO GRAND OPENING PRO
        ========================================================= */

        .go-pro-title {
            max-width: 680px !important;
            font-size: clamp(2.65rem, 4.8vw, 5.25rem) !important;
            line-height: .92 !important;
            letter-spacing: -.065em !important;
        }

        /* Laptop / tablet */
        @media (max-width: 1180px) {
            .go-pro-title {
                max-width: 620px !important;
                font-size: clamp(2.55rem, 7vw, 4.6rem) !important;
                line-height: .96 !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        /* Mobile */
        @media (max-width: 760px) {
            .go-pro-title {
                max-width: 360px !important;
                font-size: clamp(2.15rem, 10vw, 3.15rem) !important;
                line-height: 1 !important;
                letter-spacing: -.045em !important;
            }
        }


        /* =========================================================
        CARD PREVIEW LIGHT - KHUSUS 3 TEMPLATE BERAT
        ========================================================= */

        .template-card-preview-light .floating-actions {
            display: none !important;
        }

        /* Reveal langsung terlihat agar tidak blink/blur saat iframe diload */
        .template-card-preview-light [data-reveal] {
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
            transition: none !important;
        }

        /* GRAND OPENING PRO */
        .template-card-preview-light .startup-wrap::before,
        .template-card-preview-light .startup-wrap::after,
        .template-card-preview-light .grand-opening-hero::after,
        .template-card-preview-light .go-pro-hero-v2::after,
        .template-card-preview-light .go-orb,
        .template-card-preview-light .go-line,
        .template-card-preview-light .go-mark,
        .template-card-preview-light .go-pro-bg-orb,
        .template-card-preview-light .go-pro-line,
        .template-card-preview-light .go-pro-dot,
        .template-card-preview-light .editor-orb,
        .template-card-preview-light .editor-line,
        .template-card-preview-light .editor-star,
        .template-card-preview-light .editor-float-card,
        .template-card-preview-light .go-pro-seal,
        .template-card-preview-light .go-pro-host-card,
        .template-card-preview-light .startup-btn::after {
            animation: none !important;
        }

        /* AWARD NIGHT */
        .template-card-preview-light .award-wrap::before,
        .template-card-preview-light .award-wrap::after,
        .template-card-preview-light .award-hero::before,
        .template-card-preview-light .award-spotlight,
        .template-card-preview-light .award-orb,
        .template-card-preview-light .award-spark,
        .template-card-preview-light .award-btn::after,
        .template-card-preview-light .award-seal,
        .template-card-preview-light .award-host-card,
        .template-card-preview-light .countdown-number {
            animation: none !important;
        }

        /* NETWORKING NIGHT */
        .template-card-preview-light .network-wrap::before,
        .template-card-preview-light .network-wrap::after,
        .template-card-preview-light .network-hero::before,
        .template-card-preview-light .network-spotlight,
        .template-card-preview-light .network-orb,
        .template-card-preview-light .network-spark,
        .template-card-preview-light .network-node-map .node,
        .template-card-preview-light .network-node-map,
        .template-card-preview-light .network-btn::after,
        .template-card-preview-light .network-seal,
        .template-card-preview-light .network-host-card,
        .template-card-preview-light .countdown-number {
            animation: none !important;
        }

        /* Kurangi efek repaint berat di preview kecil */
        .template-card-preview-light .award-wrap,
        .template-card-preview-light .startup-wrap,
        .template-card-preview-light .network-wrap,
        .template-card-preview-light .award-hero,
        .template-card-preview-light .grand-opening-hero,
        .template-card-preview-light .go-pro-hero-v2,
        .template-card-preview-light .network-hero,
        .template-card-preview-light .award-stage-card,
        .template-card-preview-light .network-stage-card,
        .template-card-preview-light .editor-vscode-window {
            backface-visibility: hidden;
            transform: translateZ(0);
            will-change: auto !important;
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?? 'rose';

    if ($themeColor === 'golden') {
        $themeColor = 'gold';
    }

    $themes = [
        'maroon' => ['primary' => '#9f1239', 'secondary' => '#e11d48', 'accent' => '#ffe4e6', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fff7f8', 'glow1' => 'rgba(225, 29, 72, .14)', 'glow2' => 'rgba(251, 113, 133, .12)', 'glow3' => 'rgba(255, 228, 230, .28)'],
        'emerald' => ['primary' => '#047857', 'secondary' => '#10b981', 'accent' => '#d1fae5', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f4fff9', 'glow1' => 'rgba(16, 185, 129, .13)', 'glow2' => 'rgba(52, 211, 153, .12)', 'glow3' => 'rgba(209, 250, 229, .28)'],
        'navy' => ['primary' => '#2563eb', 'secondary' => '#38bdf8', 'accent' => '#dbeafe', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f5f9ff', 'glow1' => 'rgba(37, 99, 235, .13)', 'glow2' => 'rgba(56, 189, 248, .12)', 'glow3' => 'rgba(219, 234, 254, .30)'],
        'rose' => ['primary' => '#db2777', 'secondary' => '#fb7185', 'accent' => '#fce7f3', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fff7fb', 'glow1' => 'rgba(219, 39, 119, .14)', 'glow2' => 'rgba(251, 113, 133, .12)', 'glow3' => 'rgba(252, 231, 243, .30)'],
        'gold' => ['primary' => '#b45309', 'secondary' => '#f59e0b', 'accent' => '#fef3c7', 'dark' => '#111827', 'text' => '#475569', 'soft' => '#fffbeb', 'glow1' => 'rgba(245, 158, 11, .14)', 'glow2' => 'rgba(250, 204, 21, .12)', 'glow3' => 'rgba(254, 243, 199, .34)'],
        'slate' => ['primary' => '#475569', 'secondary' => '#64748b', 'accent' => '#e2e8f0', 'dark' => '#0f172a', 'text' => '#475569', 'soft' => '#f8fafc', 'glow1' => 'rgba(100, 116, 139, .12)', 'glow2' => 'rgba(148, 163, 184, .12)', 'glow3' => 'rgba(226, 232, 240, .32)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['rose'];
    $photos = ($invitation->photos ?? collect())->values();
    $firstPhoto = $photos->first();
    $people = $invitation->people ?? collect();
    $gifts = $invitation->gifts ?? collect();
    $messages = $invitation->messages ?? collect();
    $giftCount = $gifts->count();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Grand Opening Ceremony';
    $eventName = $invitation->event_name ?: 'Corporate Grand Opening Pro';
    $hostName = $invitation->host_name ?: 'Corporate Team';
    $agendaSectionTitle = trim($invitation->seminar_about_title ?? '') ?: 'Grand Opening Agenda';

    $eventDateText = 'Tanggal belum diatur';

    if ($invitation->event_date) {
        $startDate = \Carbon\Carbon::parse($invitation->event_date);
        $eventDateText = $startDate->translatedFormat('d M Y');

        if ($invitation->event_end_date) {
            $endDate = \Carbon\Carbon::parse($invitation->event_end_date);

            if ($startDate->isSameDay($endDate)) {
                $eventDateText = $startDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y-m') === $endDate->format('Y-m')) {
                // Contoh: 15 - 23 Mei 2026
                $eventDateText = $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d M Y');
            } elseif ($startDate->format('Y') === $endDate->format('Y')) {
                // Contoh: 30 Mei - 02 Jun 2026
                $eventDateText = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
            } else {
                // Contoh: 30 Des 2026 - 02 Jan 2027
                $eventDateText = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
            }
        }
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
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Opening Room' : 'Grand Opening Venue');
    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke ruang grand opening, webinar, atau live ceremony.'
        : 'Alamat lengkap belum ditambahkan.');
    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $mainPersonName = optional($people->first())->name ?: $hostName;

    $shareMessage = "Halo Bapak/Ibu/Saudara/i,\n\n"
        . "Dengan hormat, kami mengundang Anda untuk hadir dalam acara:\n\n"
        . "*{$eventName}*\n"
        . "*{$eventTitle}*\n\n"
        . "Diselenggarakan oleh: {$hostName}\n"
        . "Tanggal: {$eventDateText}\n";

    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }

    if ($isOnlineEvent) {
        $shareMessage .= "Mode: Online\n";
        if ($onlineUrl) { $shareMessage .= "Link Online: {$onlineUrl}\n"; }
    } else {
        $shareMessage .= "Mode: Offline\n";
        if ($invitation->location_name) { $shareMessage .= "Tempat: {$invitation->location_name}\n"; }
        if ($invitation->address) { $shareMessage .= "Alamat: {$invitation->address}\n"; }
    }

    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n{$shareUrl}\n\nTerima kasih.";
    $shareText = urlencode($shareMessage);

    $countdownTarget = null;
    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
        $timePart = '00:00:00';
        if (!empty($invitation->event_time)) {
            try { $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s'); }
            catch (\Exception $e) { $timePart = '00:00:00'; }
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
            if ($endDateTime->lessThanOrEqualTo($startDateTime)) { $endDateTime = $startDateTime->copy()->addHours(3); }
            $calendarTitle = trim(($invitation->event_name ?: 'Grand Opening Event') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan grand opening') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online'))
                : trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));

            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . rawurlencode($calendarTitle)
                . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis')
                . '&details=' . rawurlencode($calendarDetails)
                . '&location=' . rawurlencode($calendarLocation)
                . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }

    $launchHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) { return !empty($item['title']) || !empty($item['description']); })
        ->take(12)
        ->values();

    $highlightCount = $launchHighlights->count();
    $highlightGridClass = match (true) {
        $highlightCount === 1 => 'count-1',
        $highlightCount === 2 => 'count-2',
        default => 'count-3',
    };

    $isCardPreview = request()->routeIs('templates.live-preview')
    && request()->query('card_preview') === '1';
@endphp

<body
    class="{{ $isCardPreview ? 'template-card-preview-light' : '' }}"
    style="
        --startup-primary: {{ $activeTheme['primary'] }};
        --startup-secondary: {{ $activeTheme['secondary'] }};
        --startup-accent: {{ $activeTheme['accent'] }};
        --startup-dark: {{ $activeTheme['dark'] }};
        --startup-text: {{ $activeTheme['text'] }};
        --startup-soft: {{ $activeTheme['soft'] }};
        --startup-glow-1: {{ $activeTheme['glow1'] }};
        --startup-glow-2: {{ $activeTheme['glow2'] }};
        --startup-glow-3: {{ $activeTheme['glow3'] }};
    "
>
    <main class="startup-shell">
        <div class="startup-wrap">
            <nav class="startup-nav">
                <a href="#about">Agenda</a>
                <a href="#detail">Detail</a>
                @if($photos->count()) <a href="#gallery">Galeri</a> @endif
                @if($giftCount) <a href="#gift">Support</a> @endif
                <a href="#message">RSVP</a>
            </nav>

            <div class="floating-actions">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan">
                    <img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan" class="floating-icon">
                </a>

                <button type="button" id="music-toggle" class="floating-action-button" title="Music">
                    <img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music" class="floating-icon">
                </button>

                <button type="button" id="scroll-toggle" class="floating-action-button" title="Auto Scroll">
                    <img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll" class="floating-icon">
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

            <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background5.mp3') }}" preload="auto" loop></audio>

            {{-- HERO - CORPORATE GRAND OPENING PRO V2 / RIBBON GATE --}}
            <section id="opening" class="go-pro-hero-v2">
                <span class="go-pro-bg-orb one"></span>
                <span class="go-pro-bg-orb two"></span>
                <span class="go-pro-bg-orb three"></span>
                <span class="go-pro-line one"></span>
                <span class="go-pro-line two"></span>
                <span class="go-pro-dot one"></span>
                <span class="go-pro-dot two"></span>
                <span class="go-pro-dot three"></span>

                <div class="go-pro-layout">
                    <aside class="go-pro-rail" data-reveal="right" style="--reveal-delay:.10s">
                        <div class="go-pro-rail-card">
                            <small>Tanggal</small>
                            <strong class="responsive-text">{{ $eventDateText }}</strong>
                            <span>{{ $eventTimeText ?: 'Waktu belum diatur' }}</span>
                        </div>

                        <div class="go-pro-rail-card">
                            <small>{{ $isOnlineEvent ? 'Mode' : 'Venue' }}</small>
                            <strong class="responsive-text">{{ $isOnlineEvent ? 'Online Opening' : 'Offline Opening' }}</strong>
                            <span class="responsive-text">{{ $isOnlineEvent ? 'Join Online' : ($accessName ?: 'Lokasi acara') }}</span>
                        </div>

                        <div class="go-pro-rail-card">
                            <small>Host</small>
                            <strong class="responsive-text">{{ $hostName }}</strong>
                            <span class="responsive-text">{{ $eventName }}</span>
                        </div>
                    </aside>

                    <div class="go-pro-copy">
                        <p class="go-pro-kicker" data-reveal="zoom" style="--reveal-delay:.04s">
                            Grand Opening • Ribbon Ceremony • Professional Moment
                        </p>

                        <h1 class="go-pro-title responsive-text" data-reveal="zoom" style="--reveal-delay:.10s">
                            <span>{{ $eventTitle }}</span>
                        </h1>

                        <p class="go-pro-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.18s">
                            {{ $invitation->description ?: 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara grand opening sebagai momen pembukaan resmi, pengenalan layanan, perluasan relasi, dan langkah awal kolaborasi profesional.' }}
                        </p>

                        <div class="go-pro-actions" data-reveal="zoom" style="--reveal-delay:.26s">
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="startup-btn">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @else
                                <a href="#detail" class="startup-btn">Lihat Detail</a>
                            @endif

                            <a href="#about" class="startup-btn secondary">Agenda Opening</a>
                            <a href="#message" class="startup-btn secondary">Konfirmasi Kehadiran</a>
                        </div>
                    </div>

                    <div class="go-pro-stage" data-reveal="left" style="--reveal-delay:.14s">
                        <div class="go-pro-gate">
                            <div class="go-pro-badge-top">
                                Grand Opening Preview
                            </div>

                            @php
                                $heroPreviewImage = null;

                                if ($invitation->cover_image) {
                                    $heroPreviewImage = asset('storage/' . $invitation->cover_image);
                                } elseif ($firstPhoto) {
                                    $heroPreviewImage = asset('storage/' . $firstPhoto->image_path);
                                } else {
                                    $heroPreviewImage = asset('assets/icons/corporate2.png');
                                    // ganti jika default gambarnya beda
                                }
                            @endphp

                            <div class="go-pro-photo-frame"
                                style="background-image: url('{{ $heroPreviewImage }}');">
                            </div>

                            <div class="go-pro-ceremony-panel">
                                <small>Opening Ceremony</small>
                                <strong class="responsive-text">{{ $eventName }}</strong>
                                <span class="responsive-text">{{ $agendaSectionTitle }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PEOPLE --}}
            <section id="people" class="startup-section compact">
                <div class="section-head">
                    <p class="startup-label" data-reveal="zoom">Opening Team</p>
                    <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Tim & Perwakilan</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Bagian ini menampilkan manajemen, host, partner, tim operasional, atau perwakilan utama pada acara grand opening.</p>
                </div>

                <div class="people-grid">
                    @forelse ($people as $index => $person)
                        <div class="person-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}" class="person-photo">
                            @else
                                <div class="person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'S', 0, 1)) }}</div>
                            @endif
                            <span class="person-role">{{ $person->subtitle ?: 'Corporate Representative' }}</span>
                            <h3 class="responsive-text">{{ $person->name ?: 'Nama Perwakilan' }}</h3>
                            <p class="responsive-text">{{ $person->family_name ?: 'Data tim atau perwakilan dapat ditambahkan melalui editor.' }}</p>
                        </div>
                    @empty
                        <div class="person-card" data-reveal="zoom">
                            <div class="person-placeholder">S</div>
                            <span class="person-role">Corporate Representative</span>
                            <h3 class="responsive-text">Nama Perwakilan</h3>
                            <p>Data tim atau perwakilan belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- AGENDA --}}
            @if ($highlightCount > 0)
                <section id="about" class="startup-section compact">
                    <div class="section-head">
                        <p class="startup-label" data-reveal="zoom">Grand Opening Agenda</p>
                        <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">{{ $agendaSectionTitle }}</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Agenda utama, peresmian, sambutan, company introduction, networking, atau sesi pembukaan yang ingin ditampilkan.</p>
                    </div>

                    <div class="highlight-grid {{ $highlightGridClass }}">
                        @foreach ($launchHighlights as $index => $highlight)
                            <div class="highlight-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <div class="highlight-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <h3 class="responsive-text">{{ $highlight['title'] ?? 'Opening Agenda' }}</h3>
                                <p class="responsive-text">{{ $highlight['description'] ?? 'Deskripsi agenda grand opening.' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- DETAIL --}}
            <section id="detail" class="startup-section compact">
                <div class="section-head">
                    <p class="startup-label" data-reveal="zoom">Event Access</p>
                    <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Detail Acara</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Informasi waktu, lokasi/platform, akses acara, dan countdown menuju grand opening.</p>
                </div>

                <div class="detail-layout">
                    <div class="detail-card" data-reveal="left">
                        <h3>Opening Brief</h3>
                        <div class="detail-list">
                            <div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $eventName }}</div></div>
                            <div class="detail-row"><div class="label">Mode</div><div class="value responsive-text">{{ $isOnlineEvent ? 'Online Grand Opening Event' : 'Offline Grand Opening Event' }}</div></div>
                            <div class="detail-row"><div class="label">Tanggal</div><div class="value responsive-text">{{ $eventDateText }}</div></div>
                            <div class="detail-row"><div class="label">Waktu</div><div class="value responsive-text">{{ $eventTimeText ?: 'Belum diatur' }}</div></div>
                            <div class="detail-row"><div class="label">{{ $accessTypeLabel }}</div><div class="value responsive-text">{{ $accessName }}</div></div>
                            <div class="detail-row"><div class="label">{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</div><div class="value responsive-text">{{ $accessDescription }}</div></div>
                        </div>

                        <div class="netflix-actions mt-6">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="startup-btn">📅 Add Calendar</a>
                            @endif
                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="startup-btn secondary">{{ $accessActionIcon }} {{ $accessActionText }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="detail-card" data-reveal="right">
                        <h3>Countdown & Access</h3>
                        <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                            <div class="countdown-card"><span class="countdown-number" data-unit="days">00</span><span class="countdown-label">Hari</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="hours">00</span><span class="countdown-label">Jam</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="minutes">00</span><span class="countdown-label">Menit</span></div>
                            <div class="countdown-card"><span class="countdown-number" data-unit="seconds">00</span><span class="countdown-label">Detik</span></div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div><p class="text-5xl">🌐</p><p class="responsive-text font-black mt-3">{{ $accessName }}</p><p class="responsive-text mt-2" style="color: var(--startup-text);">{{ $accessDescription }}</p><p class="responsive-text mt-4 font-bold" style="color: var(--startup-primary);">Join Online →</p></div>
                                        </a>
                                    @else
                                        <div class="map-placeholder"><div><p class="text-5xl">🌐</p><p class="responsive-text font-black mt-3">{{ $accessName }}</p><p class="responsive-text mt-2" style="color: var(--startup-text);">Link online belum ditambahkan.</p></div></div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div><p class="text-5xl">📍</p><p class="responsive-text font-black mt-3">{{ $accessName }}</p><p class="responsive-text mt-2" style="color: var(--startup-text);">{{ $accessDescription }}</p><p class="responsive-text mt-4 font-bold" style="color: var(--startup-primary);">Buka Google Maps →</p></div>
                                        </a>
                                    @else
                                        <div class="map-placeholder"><div><p class="text-5xl">📍</p><p class="responsive-text font-black mt-3">{{ $accessName }}</p><p class="responsive-text mt-2" style="color: var(--startup-text);">{{ $accessDescription }}</p></div></div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- GALLERY --}}
            @if ($photos->count())
                <section id="gallery" class="startup-section compact">
                    <div class="section-head">
                        <p class="startup-label" data-reveal="zoom">Opening Gallery</p>
                        <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Galeri Grand Opening</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Dokumentasi visual, venue, brand, tim, atau suasana grand opening.</p>
                    </div>

                    <div class="gallery-startup">
                        <div class="gallery-column">
                            @foreach ($photos->slice(0, 2) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Grand Opening Event"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(2, 2) as $photo)
                                <div class="gallery-card short" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Grand Opening Event"></div>
                            @endforeach
                        </div>
                        <div class="gallery-column">
                            @foreach ($photos->slice(4) as $photo)
                                <div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}" data-reveal="zoom" style="--reveal-delay: {{ min($loop->index * 0.06, 0.30) }}s"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Grand Opening Event"></div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- SUPPORT --}}
            @if ($giftCount)
                <section id="gift" class="startup-section compact">
                    <div class="section-head">
                        <p class="startup-label" data-reveal="zoom">Support</p>
                        <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Partner / Support / Kontak</h2>
                        <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Jika disediakan, tamu dapat menggunakan informasi berikut untuk partner, sponsor, kontak event, atau support.</p>
                    </div>
                    <div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }}">
                        @foreach ($gifts as $index => $gift)
                            @php
                                $giftLabel = data_get($gift, 'label') ?: 'Support / Kontak';
                                $giftNumber = data_get($gift, 'account_number') ?: '-';
                                $giftName = data_get($gift, 'account_name') ?: 'Nama penerima belum diatur';
                            @endphp
                            <div class="gift-card" data-reveal="zoom" style="--reveal-delay: {{ min($index * 0.06, 0.30) }}s">
                                <h3 class="responsive-text">{{ $giftLabel }}</h3>
                                <div class="gift-copy-box">
                                    <div><small>Kontak / Link / Rekening</small><div class="gift-number responsive-text">{{ $giftNumber }}</div><p class="responsive-text text-sm mt-2" style="color: var(--startup-text);">Atas Nama {{ $giftName }}</p></div>
                                    @if ($giftNumber !== '-') <button type="button" class="copy-gift-btn" data-copy="{{ $giftNumber }}">Salin</button> @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="startup-section compact">
                <div class="section-head">
                    <p class="startup-label" data-reveal="zoom">RSVP & Wishes</p>
                    <h2 class="startup-title responsive-text" data-reveal="zoom" style="--reveal-delay:.08s">Ucapan & Kehadiran</h2>
                    <p class="section-desc responsive-text" data-reveal="zoom" style="--reveal-delay:.16s">Kirimkan ucapan terbaik dan konfirmasi kehadiran Anda.</p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5"><p class="font-bold">Mohon periksa kembali isian:</p><ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4" data-reveal="up">
                        @csrf
                        <div><label class="uk-label">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="uk-input mt-1" placeholder="Nama lengkap" required></div>
                        <div><label class="uk-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="uk-input mt-1"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div>
                        <div><label class="uk-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1"></div>
                        <div><label class="uk-label">Ucapan / Doa</label><textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan terbaik..." required>{{ old('message') }}</textarea></div>
                        <button type="submit" class="w-full startup-btn">Kirim Ucapan</button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card" data-reveal="zoom"><strong>{{ $messages->where('attendance_status', 'tidak_hadir')->count() }}</strong><span>Tidak hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.06s"><strong>{{ $messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong><span>Hadir</span></div>
                        <div class="summary-card" data-reveal="zoom" style="--reveal-delay:.12s"><strong>{{ $messages->where('attendance_status', 'ragu')->count() }}</strong><span>Ragu</span></div>
                    </div>

                    <div class="message-list">
                        @forelse ($messages as $index => $message)
                            <div class="message-card" data-reveal="up" style="--reveal-delay: {{ min($index * 0.04, 0.24) }}s">
                                <div class="message-head"><div class="message-info"><p class="responsive-text font-black" style="color: #fff;">{{ $message->guest_name }}</p><p class="text-xs mt-1" style="color: rgba(255,255,255,.58);">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div>
                                <p class="responsive-text mt-4 leading-7" style="color: var(--startup-text);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center" data-reveal="up"><p style="color: var(--startup-text);">Belum ada ucapan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="startup-section text-center">
                <div class="closing-card" data-reveal="zoom">
                    <p class="startup-label">Thank You</p>
                    <h2 class="startup-title startup-gradient responsive-text">Terima Kasih</h2>
                    <p class="responsive-text mt-6 leading-8 max-w-2xl mx-auto" style="color: var(--startup-text);">Terima kasih atas waktu, dukungan, dan kehadiran Anda. Semoga acara grand opening ini menjadi awal yang baik, profesional, dan membawa peluang kerja sama yang berkelanjutan.</p>
                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10" style="color: #fff;">{{ $eventTitle }}</h3>
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
                if (!musicIcon || !musicToggle) return;
                musicIcon.src = active ? musicIcon.dataset.iconOn : musicIcon.dataset.iconOff;
                musicToggle.classList.toggle('is-active', active);
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
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            if (scrollToggle) {
                const scrollIcon = scrollToggle.querySelector('img');
                function setScrollIcon(active) {
                    scrollToggle.classList.toggle('is-active', active);
                    if (scrollIcon) scrollIcon.src = active ? scrollIcon.dataset.iconOn : scrollIcon.dataset.iconOff;
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
                function startAutoScroll() {
                    stopAutoScroll();
                    autoScrollActive = true;
                    setScrollIcon(true);
                    autoScrollFrame = requestAnimationFrame(autoScrollStep);
                }
                scrollToggle.addEventListener('click', function () { autoScrollActive ? stopAutoScroll() : startAutoScroll(); });
                ['wheel', 'touchstart', 'keydown'].forEach(function (eventName) {
                    window.addEventListener(eventName, function () { if (autoScrollActive) stopAutoScroll(); }, { passive: true });
                });
            }

            document.querySelectorAll('[data-countdown-target]').forEach(function (wrap) {
                const targetValue = wrap.dataset.countdownTarget;
                if (!targetValue) return;
                const target = new Date(targetValue).getTime();
                const units = { days: wrap.querySelector('[data-unit="days"]'), hours: wrap.querySelector('[data-unit="hours"]'), minutes: wrap.querySelector('[data-unit="minutes"]'), seconds: wrap.querySelector('[data-unit="seconds"]') };
                function pad(number) { return String(number).padStart(2, '0'); }
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

            document.querySelectorAll('.copy-gift-btn').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const value = button.dataset.copy || '';
                    try {
                        await navigator.clipboard.writeText(value);
                        button.classList.add('copied');
                        const oldText = button.textContent;
                        button.textContent = 'Tersalin';
                        setTimeout(function () { button.textContent = oldText; button.classList.remove('copied'); }, 1600);
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

            const revealElements = document.querySelectorAll('[data-reveal]');
            if (!('IntersectionObserver' in window)) {
                revealElements.forEach(function (element) { element.classList.add('is-visible'); });
            } else {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.14, rootMargin: '0px 0px -60px 0px' });
                revealElements.forEach(function (element) { revealObserver.observe(element); });
            }

            setTimeout(function () {
                document.querySelectorAll('#opening [data-reveal]').forEach(function (element) { element.classList.add('is-visible'); });
            }, 120);

            document.addEventListener('contextmenu', function (event) { event.preventDefault(); });
            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';
                if (!['input', 'textarea', 'select', 'option'].includes(tagName)) event.preventDefault();
            });
            document.addEventListener('dragstart', function (event) { event.preventDefault(); });
            document.addEventListener('keydown', function (event) {
                const key = event.key ? event.key.toLowerCase() : '';
                const blocked = event.key === 'F12' || (event.ctrlKey && event.shiftKey && ['i', 'j', 'c'].includes(key)) || (event.ctrlKey && ['u', 's', 'p'].includes(key)) || (event.metaKey && event.altKey && ['i', 'j', 'c'].includes(key)) || (event.metaKey && ['u', 's', 'p'].includes(key));
                if (blocked) { event.preventDefault(); event.stopPropagation(); return false; }
            });
        });
    </script>
</body>
</html>
