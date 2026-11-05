<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $browserTitle = trim(($invitation->event_name ?: 'Pernikahan') . ' ' . ($invitation->title ?: 'Elegant White'));
    @endphp
    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: #f8f1dc;
            background:
                radial-gradient(circle at 12% 8%, rgba(214,173,92,.14), transparent 24%),
                radial-gradient(circle at 88% 20%, rgba(255,255,255,.06), transparent 24%),
                linear-gradient(180deg, #050505, #111 46%, #050505);
        }
        .responsive-text { display:block; max-width:100%; overflow-wrap:anywhere; word-break:break-word; white-space:pre-line; }
        .mbg-shell { width:min(100%,1180px); margin:0 auto; padding:24px; }
        .mbg-wrap {
            position:relative; overflow:hidden; min-height:100vh; border-radius:28px;
            background:
                radial-gradient(circle at 50% -8%, rgba(214,173,92,.16), transparent 28%),
                radial-gradient(circle at 0% 35%, rgba(255,255,255,.055), transparent 26%),
                radial-gradient(circle at 100% 70%, rgba(214,173,92,.10), transparent 26%),
                linear-gradient(180deg,#171717,#060606 42%,#111);
            border:1px solid rgba(214,173,92,.22);
            box-shadow:0 34px 100px rgba(0,0,0,.48);
        }
        .mbg-wrap::before {
            content:""; position:absolute; inset:0; z-index:0; pointer-events:none;
            background:
                linear-gradient(90deg, rgba(214,173,92,.05) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, rgba(214,173,92,.035) 1px, transparent 1px) 0 0/42px 42px,
                radial-gradient(circle, rgba(255,255,255,.08) 0 1px, transparent 1.5px) 0 0/24px 24px;
            opacity:.34;
        }
        .mbg-wrap::after {
            content:""; position:absolute; inset:16px; z-index:0; pointer-events:none; border-radius:22px;
            border:1px solid rgba(214,173,92,.25);
            box-shadow:inset 0 0 0 1px rgba(255,255,255,.03), inset 0 0 80px rgba(214,173,92,.03);
        }
        .mbg-wrap>* { position:relative; z-index:2; }
        .mbg-silk {
            position:absolute; inset:0; z-index:1; pointer-events:none; opacity:.30;
            background:
                linear-gradient(115deg, transparent 0 35%, rgba(255,255,255,.11) 36%, transparent 43%),
                linear-gradient(68deg, transparent 0 58%, rgba(214,173,92,.10) 59%, transparent 64%),
                radial-gradient(ellipse at 72% 20%, rgba(255,255,255,.08), transparent 28%),
                radial-gradient(ellipse at 18% 76%, rgba(255,255,255,.05), transparent 30%);
        }
        .mbg-section { position:relative; min-height:100vh; padding:96px 58px; display:flex; flex-direction:column; justify-content:center; }
        .mbg-section.compact { min-height:auto; padding-top:88px; padding-bottom:88px; }
        .mbg-label {
            width:fit-content; margin:0 auto; display:inline-flex; align-items:center; gap:10px; padding:9px 16px;
            border-radius:999px; color:#e7c574; background:rgba(255,255,255,.045); border:1px solid rgba(214,173,92,.32);
            box-shadow:0 12px 30px rgba(0,0,0,.18); font-size:11px; font-weight:950; letter-spacing:.16em; text-transform:uppercase;
        }
        .mbg-label::before { content:"✦"; color:#f5dc9a; }
        .mbg-title { font-family:Georgia,"Times New Roman",serif; color:#e2bd65; font-weight:900; line-height:1.05; letter-spacing:-.035em; }
        .mbg-text { color:rgba(248,241,220,.78); line-height:1.9; }
        .mbg-btn {
            display:inline-flex; align-items:center; justify-content:center; gap:9px; border:none; cursor:pointer; text-decoration:none;
            padding:13px 24px; color:#080808; background:linear-gradient(135deg,#b88739,#f1d487,#b88639);
            box-shadow:0 18px 32px rgba(214,173,92,.17); font-weight:950; letter-spacing:.04em; text-transform:uppercase;
        }
        .mbg-btn.dark { background:#0b0b0b; color:#e2bd65; border:1px solid rgba(214,173,92,.32); }

        .floating-actions { position:fixed; right:22px; top:50%; transform:translateY(-50%); z-index:60; display:flex; flex-direction:column; gap:10px; }
        .floating-actions a,.floating-action-button {
            width:45px; height:45px; border-radius:999px; background:rgba(255,255,255,.94); box-shadow:0 14px 30px rgba(0,0,0,.28);
            display:flex; align-items:center; justify-content:center; text-decoration:none; border:1px solid rgba(214,173,92,.18); cursor:pointer; padding:0;
        }
        .floating-action-button.is-active { background:#e5c678; }
        .floating-icon { width:22px; height:22px; object-fit:contain; }

        .mbg-nav {
            position:sticky; top:14px; z-index:45; width:fit-content; max-width:calc(100% - 24px); margin:18px auto 0; padding:7px;
            display:flex; gap:4px; overflow-x:auto; border-radius:999px; background:rgba(4,4,4,.72); border:1px solid rgba(214,173,92,.30);
            backdrop-filter:blur(16px); box-shadow:0 18px 40px rgba(0,0,0,.28);
        }
        .mbg-nav a { color:#d8bd74; text-decoration:none; padding:9px 13px; border-radius:999px; font-size:11px; font-weight:900; letter-spacing:.06em; white-space:nowrap; text-transform:uppercase; }
        .mbg-nav a:hover { background:rgba(214,173,92,.12); }

        .mbg-hero { padding-top:84px; overflow:hidden; }
        .mbg-hero-bg {
            position:absolute; inset:0; z-index:0; pointer-events:none;
            background:linear-gradient(180deg,rgba(0,0,0,.62),rgba(0,0,0,.74)), var(--mbg-hero-image, none);
            background-size:cover; background-position:center; filter:grayscale(1); transform:scale(1.02);
        }
        .mbg-hero-bg::after {
            content:""; position:absolute; inset:0;
            background:linear-gradient(90deg,rgba(0,0,0,.64),transparent 38%,rgba(0,0,0,.66)), linear-gradient(180deg,rgba(0,0,0,.30),transparent 34%,rgba(0,0,0,.68));
        }
        .mbg-hero-inner { width:min(100%,760px); min-height:720px; margin:0 auto; padding:60px 40px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; }
        .mbg-hero-kicker { color:#e2bd65; font-weight:950; letter-spacing:.18em; text-transform:uppercase; font-size:13px; }
        .mbg-names { margin-top:24px; color:#e6c372; font-size:clamp(3rem,7vw,6.7rem); line-height:.95; letter-spacing:.05em; text-transform:uppercase; text-shadow:0 18px 40px rgba(0,0,0,.55); }
        .mbg-hero-date { margin-top:20px; color:rgba(248,241,220,.88); font-size:14px; font-weight:900; letter-spacing:.34em; }
        .mbg-hero-to { margin-top:42px; color:rgba(248,241,220,.76); line-height:1.9; font-family:Georgia,"Times New Roman",serif; font-size:1.15rem; }
        .mbg-hero-actions { margin-top:28px; display:flex; justify-content:center; gap:12px; flex-wrap:wrap; }

        .mbg-cover-grid { display:grid; grid-template-columns:1fr; gap:28px; align-items:center; text-align:center; }
        .mbg-photo-card { width:min(100%,650px); margin:0 auto; border-radius:34px; overflow:hidden; background:#111; border:1px solid rgba(214,173,92,.22); box-shadow:0 26px 72px rgba(0,0,0,.35); }
        .mbg-photo-card img,.mbg-photo-placeholder { display:block; width:100%; height:auto; max-height:720px; object-fit:contain; background:radial-gradient(circle at center,rgba(214,173,92,.14),transparent 28%),#111; filter:grayscale(1); }
        .mbg-photo-placeholder { aspect-ratio:4/5; }
        .mbg-quote-card { width:min(100%,760px); margin:0 auto; padding:32px 28px; background:rgba(255,255,255,.035); border:1px solid rgba(214,173,92,.22); box-shadow:0 20px 46px rgba(0,0,0,.22); }
        .mbg-quote-card h2 { color:#e2bd65; font-size:clamp(2rem,5vw,3.8rem); }
        .mbg-quote-card p { color:rgba(248,241,220,.76); line-height:2; margin-top:18px; }

        .mbg-couple-grid { margin-top:42px; display:grid; grid-template-columns:1fr; gap:34px; }
        .mbg-person { width:min(100%,660px); margin:0 auto; text-align:center; }
        .mbg-person-photo { width:100%; max-height:560px; object-fit:cover; object-position:center; display:block; border-radius:28px; filter:grayscale(1); border:1px solid rgba(214,173,92,.24); box-shadow:0 26px 70px rgba(0,0,0,.36); background:#111; }
        .mbg-person-placeholder { width:100%; aspect-ratio:4/5; border-radius:28px; background:radial-gradient(circle at center,rgba(214,173,92,.16),transparent 26%),linear-gradient(135deg,#171717,#050505); border:1px solid rgba(214,173,92,.24); display:flex; align-items:center; justify-content:center; color:#e2bd65; font-size:4rem; font-weight:950; }
        .mbg-person h3 { margin-top:22px; color:#e2bd65; font-size:clamp(2rem,5vw,3.5rem); }
        .mbg-person .sub { margin-top:10px; color:rgba(248,241,220,.74); font-weight:800; }
        .mbg-person .family { margin-top:12px; color:rgba(248,241,220,.64); line-height:1.8; }

        .mbg-count-grid { max-width:680px; margin:34px auto 0; display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:16px; }
        .mbg-count-card { text-align:center; padding:22px 10px; background:rgba(255,255,255,.04); border:1px solid rgba(214,173,92,.22); box-shadow:0 18px 40px rgba(0,0,0,.22); }
        .mbg-count-number { display:block; color:#e2bd65; font-size:clamp(2rem,5vw,3rem); line-height:1; font-weight:950; }
        .mbg-count-label { display:block; margin-top:10px; color:rgba(248,241,220,.78); font-size:12px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; }

        .mbg-detail-card { width:min(100%,760px); margin:36px auto 0; text-align:center; padding:38px 30px; background:linear-gradient(180deg,rgba(255,255,255,.055),rgba(255,255,255,.028)),linear-gradient(135deg,rgba(214,173,92,.08),transparent); border:1px solid rgba(214,173,92,.28); box-shadow:0 26px 70px rgba(0,0,0,.30); }
        .mbg-detail-card h3 { color:#e2bd65; font-size:clamp(2rem,5vw,3.4rem); text-transform:uppercase; }
        .mbg-detail-line { margin-top:18px; color:rgba(248,241,220,.84); line-height:1.9; font-weight:800; }
        .mbg-detail-place { margin-top:18px; color:rgba(248,241,220,.66); line-height:1.8; }
        .mbg-map-card { width:min(100%,850px); margin:28px auto 0; overflow:hidden; border:1px solid rgba(214,173,92,.22); background:#111; box-shadow:0 24px 62px rgba(0,0,0,.30); }
        .mbg-map-frame,.mbg-map-placeholder { width:100%; height:320px; border:0; display:block; }
        .mbg-map-placeholder { text-decoration:none; color:#e2bd65; display:flex; align-items:center; justify-content:center; text-align:center; padding:28px; background:radial-gradient(circle at center,rgba(214,173,92,.13),transparent 28%),#111; }

        .mbg-gallery-grid { margin-top:36px; display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
        .mbg-gallery-item { display:block; overflow:hidden; border-radius:22px; border:1px solid rgba(214,173,92,.20); background:#111; box-shadow:0 18px 46px rgba(0,0,0,.24); }
        .mbg-gallery-item:first-child { grid-column:span 2; grid-row:span 2; }
        .mbg-gallery-item img { width:100%; height:220px; object-fit:cover; display:block; filter:grayscale(1); }
        .mbg-gallery-item:first-child img { height:454px; }

        .mbg-gift-grid { margin-top:36px; display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:20px; }
        .mbg-gift-card,.mbg-form-card,.mbg-message-card,.mbg-closing-card { background:linear-gradient(180deg,rgba(255,255,255,.055),rgba(255,255,255,.028)); border:1px solid rgba(214,173,92,.24); box-shadow:0 24px 62px rgba(0,0,0,.28); }
        .mbg-gift-card { padding:28px; }
        .mbg-gift-title { color:#e2bd65; font-size:1.35rem; font-weight:950; }
        .mbg-gift-box { margin-top:18px; padding:16px; background:rgba(0,0,0,.24); border:1px solid rgba(214,173,92,.16); }
        .mbg-copy-btn { margin-top:16px; width:100%; border:none; cursor:pointer; padding:12px 16px; background:linear-gradient(135deg,#b88739,#f1d487,#b88639); color:#080808; font-weight:950; }

        .mbg-form-wrap { width:min(100%,760px); margin:34px auto 0; }
        .mbg-form-card { padding:28px; }
        .mbg-input { width:100%; border:1px solid rgba(214,173,92,.22); background:rgba(0,0,0,.28); color:#f8f1dc; border-radius:0; padding:13px 14px; outline:none; }
        .mbg-input::placeholder { color:rgba(248,241,220,.40); }
        .mbg-label-form { display:block; color:rgba(248,241,220,.74); font-size:13px; font-weight:900; letter-spacing:.04em; }
        .mbg-summary-grid { margin-top:24px; display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; text-align:center; }
        .mbg-summary-grid>div { padding:18px 12px; background:rgba(255,255,255,.035); border:1px solid rgba(214,173,92,.18); }
        .mbg-summary-grid b { color:#e2bd65; font-size:2rem; line-height:1; }
        .mbg-message-list { margin-top:26px; display:grid; gap:14px; }
        .mbg-message-card { padding:20px; }

        .mbg-closing-card { width:min(100%,760px); margin:0 auto; text-align:center; padding:42px 34px; }
        .mbg-closing-photo { width:210px; height:250px; object-fit:cover; display:block; margin:0 auto 26px; border-radius:999px 999px 26px 26px; border:1px solid rgba(214,173,92,.28); filter:grayscale(1); background:#111; }

        @media (max-width:900px) {
            .mbg-shell { padding:14px; }
            .mbg-wrap { border-radius:24px; }
            .mbg-section { padding:86px 36px; }
            .mbg-gallery-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
        }
        @media (max-width:640px) {
            .mbg-shell { padding:0; }
            .mbg-wrap { border-radius:0; border-left:0; border-right:0; }
            .mbg-wrap::after { inset:10px; border-radius:16px; }
            .mbg-section { padding:76px 24px; }
            .mbg-section.compact { padding-top:68px; padding-bottom:68px; }
            .mbg-hero-inner { min-height:690px; padding:50px 24px; }
            .mbg-names { font-size:clamp(2.45rem,12vw,4.2rem); letter-spacing:.03em; }
            .mbg-count-grid,.mbg-summary-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .mbg-gallery-grid { grid-template-columns:1fr; }
            .mbg-gallery-item:first-child { grid-column:auto; grid-row:auto; }
            .mbg-gallery-item img,.mbg-gallery-item:first-child img { height:270px; }
            .floating-actions { right:10px; gap:8px; }
            .floating-actions a,.floating-action-button { width:42px; height:42px; }
        }

        /* =====================================================
           THEME FIX - Elegant White
           Accent mengikuti 6 warna editor + hero lebih terang
        ===================================================== */

        .mbg-wrap {
            background:
                radial-gradient(circle at 50% -8%, var(--mbg-glow), transparent 28%),
                radial-gradient(circle at 0% 35%, rgba(255,255,255,.06), transparent 26%),
                radial-gradient(circle at 100% 70%, var(--mbg-glow), transparent 30%),
                linear-gradient(180deg, #191817, #070707 43%, #11100f) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 38%, transparent) !important;
        }

        .mbg-wrap::before {
            background:
                linear-gradient(90deg, color-mix(in srgb, var(--mbg-accent) 12%, transparent) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, color-mix(in srgb, var(--mbg-accent) 8%, transparent) 1px, transparent 1px) 0 0/42px 42px,
                radial-gradient(circle, rgba(255,255,255,.10) 0 1px, transparent 1.5px) 0 0/24px 24px !important;
        }

        .mbg-wrap::after {
            border-color: color-mix(in srgb, var(--mbg-accent) 30%, transparent) !important;
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.035),
                inset 0 0 90px color-mix(in srgb, var(--mbg-accent) 8%, transparent) !important;
        }

        .mbg-silk {
            opacity: .38 !important;
            background:
                linear-gradient(115deg, transparent 0 35%, rgba(255,255,255,.14) 36%, transparent 43%),
                linear-gradient(68deg, transparent 0 58%, color-mix(in srgb, var(--mbg-accent) 16%, transparent) 59%, transparent 64%),
                radial-gradient(ellipse at 72% 20%, rgba(255,255,255,.10), transparent 28%),
                radial-gradient(ellipse at 18% 76%, color-mix(in srgb, var(--mbg-accent) 10%, transparent), transparent 30%) !important;
        }

        .mbg-nav {
            background:
                linear-gradient(135deg, var(--mbg-nav), rgba(8,8,8,.90)) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 42%, transparent) !important;
            box-shadow:
                0 18px 40px rgba(0,0,0,.34),
                inset 0 1px 0 rgba(255,255,255,.06),
                inset 0 -1px 0 color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
        }

        .mbg-nav a {
            color: var(--mbg-accent-2) !important;
        }

        .mbg-nav a:hover {
            background: color-mix(in srgb, var(--mbg-accent) 16%, transparent) !important;
            color: #ffffff !important;
        }

        .mbg-label,
        .mbg-title,
        .mbg-hero-kicker,
        .mbg-count-number,
        .mbg-gift-title,
        .mbg-detail-card h3,
        .mbg-message-card .font-black {
            color: var(--mbg-accent) !important;
        }

        .mbg-label {
            background: rgba(255,255,255,.06) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 44%, transparent) !important;
        }

        .mbg-label::before {
            color: var(--mbg-accent-2) !important;
        }

        .mbg-btn,
        .mbg-copy-btn {
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--mbg-accent) 70%, #5d4217),
                    var(--mbg-accent-2),
                    color-mix(in srgb, var(--mbg-accent) 74%, #6b4610)
                ) !important;
            color: #080808 !important;
            box-shadow:
                0 18px 34px color-mix(in srgb, var(--mbg-accent) 20%, transparent),
                inset 0 1px 0 rgba(255,255,255,.32) !important;
        }

        .mbg-btn.dark {
            background: rgba(8,8,8,.86) !important;
            color: var(--mbg-accent) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 42%, transparent) !important;
        }

        .mbg-hero-bg {
            background:
                linear-gradient(180deg, rgba(0,0,0,.34), rgba(0,0,0,.52)),
                radial-gradient(circle at 50% 42%, rgba(255,255,255,.06), transparent 34%),
                var(--mbg-hero-image, none) !important;
            background-size: cover !important;
            background-position: center !important;
            filter: grayscale(1) contrast(1.05) brightness(1.06) !important;
        }

        .mbg-hero-bg::after {
            background:
                linear-gradient(90deg, rgba(0,0,0,.46), transparent 38%, rgba(0,0,0,.48)),
                linear-gradient(180deg, rgba(0,0,0,.18), transparent 38%, rgba(0,0,0,.45)),
                radial-gradient(circle at center, transparent 0 28%, rgba(0,0,0,.22) 68%) !important;
        }

        .mbg-hero-inner {
            min-height: 680px !important;
        }

        .mbg-names {
            color: var(--mbg-accent-2) !important;
            text-shadow:
                0 2px 0 rgba(0,0,0,.58),
                0 18px 45px rgba(0,0,0,.72),
                0 0 24px color-mix(in srgb, var(--mbg-accent) 22%, transparent) !important;
        }

        .mbg-hero-date,
        .mbg-hero-to {
            color: rgba(255,255,255,.86) !important;
            text-shadow: 0 12px 26px rgba(0,0,0,.65);
        }

        .mbg-text,
        .mbg-quote-card p,
        .mbg-detail-line {
            color: rgba(255,255,255,.82) !important;
        }

        .mbg-detail-place,
        .mbg-person .family,
        .mbg-person .sub {
            color: rgba(255,255,255,.66) !important;
        }

        .mbg-photo-card,
        .mbg-quote-card,
        .mbg-person-photo,
        .mbg-person-placeholder,
        .mbg-count-card,
        .mbg-detail-card,
        .mbg-map-card,
        .mbg-gallery-item,
        .mbg-gift-card,
        .mbg-form-card,
        .mbg-message-card,
        .mbg-closing-card {
            border-color: color-mix(in srgb, var(--mbg-accent) 34%, transparent) !important;
            box-shadow:
                0 26px 72px rgba(0,0,0,.35),
                inset 0 1px 0 rgba(255,255,255,.045) !important;
        }

        .mbg-count-card,
        .mbg-detail-card,
        .mbg-gift-card,
        .mbg-form-card,
        .mbg-message-card,
        .mbg-closing-card {
            background:
                linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.03)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--mbg-accent) 12%, transparent), transparent 40%) !important;
        }

        .floating-action-button.is-active {
            background: var(--mbg-accent) !important;
        }

        @media (max-width: 640px) {
            .mbg-hero-bg {
                background:
                    linear-gradient(180deg, rgba(0,0,0,.28), rgba(0,0,0,.48)),
                    radial-gradient(circle at 50% 45%, rgba(255,255,255,.07), transparent 34%),
                    var(--mbg-hero-image, none) !important;
                background-size: cover !important;
                background-position: center !important;
            }

            .mbg-hero-inner {
                min-height: 650px !important;
                padding-top: 72px !important;
            }

            .mbg-nav {
                top: 10px;
                max-width: calc(100% - 24px);
            }
        }

        /* =====================================================
        FINAL HERO VISIBILITY FIX
        Agar tulisan hero tetap muncul jelas saat cover/gambar ditambahkan
        ===================================================== */

        .mbg-hero {
            position: relative;
            isolation: isolate;
            background: #050505 !important;
        }

        .mbg-hero-bg {
            z-index: 0 !important;
            opacity: 1 !important;
            filter: grayscale(1) contrast(.95) brightness(.88) !important;
            transform: scale(1.02);
        }

        .mbg-hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 46%, rgba(0,0,0,.18), transparent 28%),
                linear-gradient(180deg, rgba(0,0,0,.18), rgba(0,0,0,.46));
        }

        .mbg-hero-bg::after {
            z-index: 2;
            background:
                linear-gradient(90deg, rgba(0,0,0,.62), rgba(0,0,0,.22) 48%, rgba(0,0,0,.62)),
                linear-gradient(180deg, rgba(0,0,0,.34), rgba(0,0,0,.14) 38%, rgba(0,0,0,.58)) !important;
        }

        .mbg-hero-inner {
            position: relative !important;
            z-index: 8 !important;
            isolation: isolate;
        }

        .mbg-hero-inner::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: min(760px, 94vw);
            height: min(560px, 72vh);
            transform: translate(-50%, -50%);
            z-index: -1;
            pointer-events: none;
            border-radius: 999px;
            background:
                radial-gradient(circle at center,
                    rgba(0,0,0,.54) 0%,
                    rgba(0,0,0,.42) 36%,
                    rgba(0,0,0,.18) 62%,
                    transparent 78%
                );
            filter: blur(2px);
        }

        .mbg-hero-kicker,
        .mbg-names,
        .mbg-hero-date,
        .mbg-hero-to,
        .mbg-hero-to p {
            opacity: 1 !important;
        }

        .mbg-hero-kicker {
            color: var(--mbg-accent-2) !important;
            text-shadow:
                0 2px 3px rgba(0,0,0,.92),
                0 0 18px color-mix(in srgb, var(--mbg-accent) 35%, transparent) !important;
        }

        .mbg-names {
            color: var(--mbg-accent-2) !important;
            filter: none !important;
            text-shadow:
                0 3px 4px rgba(0,0,0,.95),
                0 14px 34px rgba(0,0,0,.86),
                0 0 32px color-mix(in srgb, var(--mbg-accent) 34%, transparent) !important;
        }

        .mbg-hero-date {
            color: #ffffff !important;
            text-shadow:
                0 2px 4px rgba(0,0,0,.95),
                0 0 18px rgba(0,0,0,.70) !important;
        }

        .mbg-hero-to,
        .mbg-hero-to p {
            color: rgba(255,255,255,.92) !important;
            text-shadow:
                0 2px 4px rgba(0,0,0,.95),
                0 0 18px rgba(0,0,0,.70) !important;
        }

        .mbg-hero-actions {
            position: relative;
            z-index: 9;
        }

        .mbg-nav {
            z-index: 12 !important;
        }

        /* =====================================================
        FINAL PHOTO RESPONSIVE FIX
        Foto mengikuti rasio asli gambar user, tidak terpotong,
        dan tidak meninggalkan bidang kosong besar
        ===================================================== */

        .mbg-photo-card {
            width: fit-content !important;
            max-width: min(100%, 720px) !important;
            margin-left: auto !important;
            margin-right: auto !important;
            padding: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 34px !important;
            overflow: hidden !important;
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--mbg-accent) 30%, #090909),
                    #090909
                ) !important;
        }

        .mbg-photo-card img {
            display: block !important;
            width: auto !important;
            max-width: 100% !important;
            height: auto !important;
            max-height: min(82vh, 760px) !important;
            object-fit: contain !important;
            object-position: center center !important;
            border-radius: 24px !important;
            background: #0b0b0b !important;
        }

        .mbg-photo-placeholder {
            width: min(100%, 460px) !important;
            aspect-ratio: 4 / 5 !important;
            height: auto !important;
            max-height: none !important;
            border-radius: 24px !important;
        }

        .mbg-person {
            width: fit-content !important;
            max-width: min(100%, 660px) !important;
        }

        .mbg-person-photo {
            display: block !important;
            width: auto !important;
            max-width: 100% !important;
            height: auto !important;
            max-height: min(82vh, 620px) !important;
            object-fit: contain !important;
            object-position: center center !important;
            margin-left: auto !important;
            margin-right: auto !important;
            background: #0b0b0b !important;
        }

        @media (max-width: 768px) {
            .mbg-photo-card {
                width: fit-content !important;
                max-width: 100% !important;
                padding: 8px !important;
                border-radius: 28px !important;
            }

            .mbg-photo-card img {
                max-width: 100% !important;
                max-height: 78vh !important;
                border-radius: 20px !important;
            }

            .mbg-person-photo {
                max-height: 78vh !important;
                border-radius: 22px !important;
            }
        }

        @media (max-width: 480px) {
            .mbg-photo-card {
                padding: 7px !important;
                border-radius: 24px !important;
            }

            .mbg-photo-card img {
                max-height: 74vh !important;
                border-radius: 18px !important;
            }

            .mbg-person-photo {
                max-height: 74vh !important;
            }
        }

        /* =====================================================
        LUXURY ANIMATION - Elegant White
        Tempel sebelum penutup style
        ===================================================== */

        .mbg-animate,
        .mbg-label,
        .mbg-title,
        .mbg-text,
        .mbg-hero-kicker,
        .mbg-names,
        .mbg-hero-date,
        .mbg-hero-to,
        .mbg-hero-actions,
        .mbg-photo-card,
        .mbg-quote-card,
        .mbg-person,
        .mbg-count-card,
        .mbg-detail-card,
        .mbg-map-card,
        .mbg-gallery-item,
        .mbg-gift-card,
        .mbg-form-card,
        .mbg-message-card,
        .mbg-closing-card {
            opacity: 0;
            transform: translateY(34px);
            filter: blur(8px);
            transition:
                opacity .9s cubic-bezier(.2, .8, .2, 1),
                transform .9s cubic-bezier(.2, .8, .2, 1),
                filter .9s cubic-bezier(.2, .8, .2, 1);
            will-change: opacity, transform, filter;
        }

        .mbg-show {
            opacity: 1 !important;
            transform: translateY(0) !important;
            filter: blur(0) !important;
        }

        /* Animasi hero langsung tampil lebih elegan */
        .mbg-hero .mbg-hero-kicker {
            animation: mbgFadeDown .9s ease .15s both;
        }

        .mbg-hero .mbg-names {
            animation: mbgLuxuryTitle 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        .mbg-hero .mbg-hero-date {
            animation: mbgFadeUp .9s ease .48s both;
        }

        .mbg-hero .mbg-hero-to {
            animation: mbgFadeUp .9s ease .62s both;
        }

        .mbg-hero .mbg-hero-actions {
            animation: mbgFadeUp .9s ease .78s both;
        }

        /* Background hero bergerak pelan */
        .mbg-hero-bg {
            animation: mbgHeroBreath 9s ease-in-out infinite alternate;
        }

        /* Silk/glow background agar tidak kaku */
        .mbg-silk {
            animation: mbgSilkMove 13s ease-in-out infinite alternate;
        }

        /* Navbar mewah */
        .mbg-nav {
            animation: mbgNavDrop .8s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Label ada efek kilau halus */
        .mbg-label {
            position: relative;
            overflow: hidden;
        }

        .mbg-label::after {
            content: "";
            position: absolute;
            top: -40%;
            left: -60%;
            width: 45%;
            height: 180%;
            opacity: .55;
            transform: rotate(22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.42),
                transparent
            );
            animation: mbgShine 3.6s ease-in-out infinite;
        }

        /* Card hover untuk desktop */
        @media (hover: hover) {
            .mbg-photo-card,
            .mbg-quote-card,
            .mbg-person,
            .mbg-count-card,
            .mbg-detail-card,
            .mbg-gallery-item,
            .mbg-gift-card,
            .mbg-form-card,
            .mbg-message-card,
            .mbg-closing-card {
                transition:
                    opacity .9s cubic-bezier(.2, .8, .2, 1),
                    transform .9s cubic-bezier(.2, .8, .2, 1),
                    filter .9s cubic-bezier(.2, .8, .2, 1),
                    box-shadow .35s ease,
                    border-color .35s ease;
            }

            .mbg-photo-card:hover,
            .mbg-quote-card:hover,
            .mbg-person:hover,
            .mbg-count-card:hover,
            .mbg-detail-card:hover,
            .mbg-gallery-item:hover,
            .mbg-gift-card:hover,
            .mbg-form-card:hover,
            .mbg-message-card:hover,
            .mbg-closing-card:hover {
                transform: translateY(-6px) !important;
                border-color: color-mix(in srgb, var(--mbg-accent) 60%, transparent) !important;
                box-shadow:
                    0 32px 86px rgba(0,0,0,.42),
                    0 0 42px color-mix(in srgb, var(--mbg-accent) 16%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.08) !important;
            }
        }

        /* Tombol lebih hidup */
        .mbg-btn,
        .mbg-copy-btn {
            position: relative;
            overflow: hidden;
        }

        .mbg-btn::after,
        .mbg-copy-btn::after {
            content: "";
            position: absolute;
            top: -60%;
            left: -60%;
            width: 48%;
            height: 220%;
            transform: rotate(22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.48),
                transparent
            );
            animation: mbgButtonShine 3.2s ease-in-out infinite;
        }

        /* Floating action muncul halus */
        .floating-actions a,
        .floating-action-button {
            animation: mbgFloatButton 3.6s ease-in-out infinite;
        }

        .floating-actions a:nth-child(2),
        .floating-action-button:nth-child(2) {
            animation-delay: .2s;
        }

        .floating-actions a:nth-child(3),
        .floating-action-button:nth-child(3) {
            animation-delay: .4s;
        }

        .floating-actions a:nth-child(4),
        .floating-action-button:nth-child(4) {
            animation-delay: .6s;
        }

        /* Gallery zoom halus */
        .mbg-gallery-item img {
            transition: transform .7s ease, filter .7s ease;
        }

        .mbg-gallery-item:hover img {
            transform: scale(1.045);
            filter: grayscale(.75) contrast(1.08);
        }

        /* Countdown angka sedikit glow */
        .mbg-count-number {
            animation: mbgNumberGlow 2.4s ease-in-out infinite alternate;
        }

        /* Keyframes */
        @keyframes mbgFadeUp {
            from {
                opacity: 0;
                transform: translateY(26px);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes mbgFadeDown {
            from {
                opacity: 0;
                transform: translateY(-22px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes mbgLuxuryTitle {
            from {
                opacity: 0;
                transform: translateY(34px) scale(.94);
                letter-spacing: .16em;
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes mbgHeroBreath {
            from {
                transform: scale(1.02);
            }
            to {
                transform: scale(1.075);
            }
        }

        @keyframes mbgSilkMove {
            from {
                transform: translate3d(-10px, -8px, 0) scale(1);
                opacity: .28;
            }
            to {
                transform: translate3d(12px, 10px, 0) scale(1.04);
                opacity: .42;
            }
        }

        @keyframes mbgNavDrop {
            from {
                opacity: 0;
                transform: translateY(-18px) scale(.96);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes mbgShine {
            0%, 45% {
                left: -70%;
            }
            70%, 100% {
                left: 130%;
            }
        }

        @keyframes mbgButtonShine {
            0%, 50% {
                left: -70%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes mbgFloatButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes mbgNumberGlow {
            from {
                text-shadow: 0 0 10px color-mix(in srgb, var(--mbg-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 16px color-mix(in srgb, var(--mbg-accent) 36%, transparent),
                    0 0 32px color-mix(in srgb, var(--mbg-accent) 18%, transparent);
            }
        }

        /* Mobile: animasi dibuat lebih ringan */
        @media (max-width: 640px) {
            .mbg-animate,
            .mbg-label,
            .mbg-title,
            .mbg-text,
            .mbg-hero-kicker,
            .mbg-names,
            .mbg-hero-date,
            .mbg-hero-to,
            .mbg-hero-actions,
            .mbg-photo-card,
            .mbg-quote-card,
            .mbg-person,
            .mbg-count-card,
            .mbg-detail-card,
            .mbg-map-card,
            .mbg-gallery-item,
            .mbg-gift-card,
            .mbg-form-card,
            .mbg-message-card,
            .mbg-closing-card {
                transform: translateY(22px);
                filter: blur(5px);
            }

            .mbg-hero-bg {
                animation-duration: 12s;
            }
        }

        /* Hormati user yang mengaktifkan reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .mbg-animate,
            .mbg-label,
            .mbg-title,
            .mbg-text,
            .mbg-hero-kicker,
            .mbg-names,
            .mbg-hero-date,
            .mbg-hero-to,
            .mbg-hero-actions,
            .mbg-photo-card,
            .mbg-quote-card,
            .mbg-person,
            .mbg-count-card,
            .mbg-detail-card,
            .mbg-map-card,
            .mbg-gallery-item,
            .mbg-gift-card,
            .mbg-form-card,
            .mbg-message-card,
            .mbg-closing-card,
            .mbg-hero-bg,
            .mbg-silk,
            .mbg-nav,
            .floating-actions a,
            .floating-action-button,
            .mbg-count-number {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }

        /* =====================================================
           ELEGANT WHITE FINAL OVERRIDE
           Susunan mengikuti Wedding Minimal Black Gold,
           warna utama menjadi putih dan aksen mengikuti 6 tema.
        ===================================================== */

        body {
            color: #182033 !important;
            background:
                radial-gradient(circle at 10% 6%, color-mix(in srgb, var(--mbg-accent) 10%, transparent), transparent 26%),
                radial-gradient(circle at 90% 12%, color-mix(in srgb, var(--mbg-accent-2) 18%, transparent), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 48%, #ffffff 100%) !important;
        }

        .mbg-shell {
            width: min(100%, 1180px) !important;
            margin: 0 auto !important;
            padding: 24px !important;
        }

        .mbg-wrap {
            background:
                linear-gradient(90deg, rgba(15, 23, 42, .026) 1px, transparent 1px) 0 0 / 42px 42px,
                linear-gradient(0deg, rgba(15, 23, 42, .020) 1px, transparent 1px) 0 0 / 42px 42px,
                radial-gradient(circle at 50% -8%, color-mix(in srgb, var(--mbg-accent) 9%, transparent), transparent 30%),
                radial-gradient(circle at 0% 38%, color-mix(in srgb, var(--mbg-accent) 7%, transparent), transparent 28%),
                radial-gradient(circle at 100% 70%, color-mix(in srgb, var(--mbg-accent-2) 18%, transparent), transparent 30%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 46%, #ffffff 100%) !important;
            border: 1px solid color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
            box-shadow:
                0 34px 100px rgba(15, 23, 42, .09),
                inset 0 1px 0 rgba(255,255,255,.95) !important;
        }

        .mbg-wrap::before {
            background:
                linear-gradient(90deg, color-mix(in srgb, var(--mbg-accent) 10%, transparent) 1px, transparent 1px) 0 0/42px 42px,
                linear-gradient(0deg, color-mix(in srgb, var(--mbg-accent) 7%, transparent) 1px, transparent 1px) 0 0/42px 42px,
                radial-gradient(circle, rgba(15,23,42,.06) 0 1px, transparent 1.5px) 0 0/24px 24px !important;
            opacity: .40 !important;
        }

        .mbg-wrap::after {
            border-color: color-mix(in srgb, var(--mbg-accent) 20%, transparent) !important;
            box-shadow:
                inset 0 0 0 1px rgba(255,255,255,.86),
                inset 0 0 90px color-mix(in srgb, var(--mbg-accent) 5%, transparent) !important;
        }

        .mbg-silk {
            opacity: .68 !important;
            background:
                linear-gradient(115deg, transparent 0 34%, rgba(255,255,255,.72) 35%, transparent 44%),
                linear-gradient(68deg, transparent 0 58%, color-mix(in srgb, var(--mbg-accent) 9%, transparent) 59%, transparent 66%),
                radial-gradient(ellipse at 72% 20%, rgba(255,255,255,.82), transparent 28%),
                radial-gradient(ellipse at 18% 76%, color-mix(in srgb, var(--mbg-accent-2) 16%, transparent), transparent 30%) !important;
        }

        .mbg-section {
            position: relative !important;
        }

        .mbg-label {
            color: var(--mbg-accent) !important;
            background: rgba(255,255,255,.88) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 20%, transparent) !important;
            box-shadow: 0 14px 32px rgba(15,23,42,.06) !important;
            backdrop-filter: blur(12px);
        }

        .mbg-label::before {
            color: var(--mbg-accent) !important;
        }

        .mbg-title,
        .mbg-detail-card h3,
        .mbg-gift-title,
        .mbg-message-card .font-black {
            color: #162033 !important;
        }

        .mbg-names,
        .mbg-hero-kicker,
        .mbg-count-number {
            color: var(--mbg-accent) !important;
        }

        .mbg-text,
        .mbg-quote-card p,
        .mbg-detail-line,
        .mbg-hero-to,
        .mbg-hero-to p {
            color: #4b5563 !important;
            text-shadow: none !important;
        }

        .mbg-detail-place,
        .mbg-person .family,
        .mbg-person .sub {
            color: #64748b !important;
        }

        .mbg-btn,
        .mbg-copy-btn {
            color: #ffffff !important;
            background:
                linear-gradient(135deg,
                    color-mix(in srgb, var(--mbg-accent) 82%, #334155),
                    var(--mbg-accent-2),
                    color-mix(in srgb, var(--mbg-accent) 76%, #0f172a)
                ) !important;
            border-radius: 999px !important;
            box-shadow:
                0 18px 34px color-mix(in srgb, var(--mbg-accent) 18%, transparent),
                inset 0 1px 0 rgba(255,255,255,.34) !important;
        }

        .mbg-btn.dark {
            background: rgba(255,255,255,.92) !important;
            color: var(--mbg-accent) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 24%, transparent) !important;
            box-shadow: 0 14px 30px rgba(15,23,42,.07) !important;
        }

        .floating-actions a,
        .floating-action-button {
            background: rgba(255,255,255,.96) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 16%, transparent) !important;
            box-shadow: 0 14px 30px rgba(15,23,42,.14) !important;
        }

        .floating-action-button.is-active {
            background: var(--mbg-accent) !important;
        }

        .mbg-nav {
            background: rgba(255,255,255,.82) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
            box-shadow:
                0 18px 40px rgba(15,23,42,.08),
                inset 0 1px 0 rgba(255,255,255,.88) !important;
            backdrop-filter: blur(18px) !important;
            -webkit-backdrop-filter: blur(18px) !important;
            scrollbar-width: none;
        }

        .mbg-nav::-webkit-scrollbar {
            display: none;
        }

        .mbg-nav a {
            color: #162033 !important;
        }

        .mbg-nav a:hover {
            background: color-mix(in srgb, var(--mbg-accent) 11%, white) !important;
            color: var(--mbg-accent) !important;
        }

        .mbg-hero {
            background:
                radial-gradient(circle at 50% 18%, color-mix(in srgb, var(--mbg-accent) 10%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff, #f8fafc) !important;
            isolation: isolate !important;
        }

        .mbg-hero-bg {
            z-index: 0 !important;
            opacity: .72 !important;
            filter: saturate(.96) contrast(1.02) brightness(1.06) !important;
            transform: scale(1.035) !important;
            background:
                linear-gradient(180deg, rgba(255,255,255,.56), rgba(255,255,255,.78)),
                radial-gradient(circle at 50% 42%, rgba(255,255,255,.28), transparent 34%),
                var(--mbg-hero-image, none) !important;
            background-size: cover !important;
            background-position: center !important;
        }

        .mbg-hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 48%, rgba(255,255,255,.52), transparent 36%),
                linear-gradient(180deg, rgba(255,255,255,.38), rgba(255,255,255,.80)) !important;
        }

        .mbg-hero-bg::after {
            z-index: 2 !important;
            background:
                linear-gradient(90deg, rgba(255,255,255,.86), rgba(255,255,255,.38) 48%, rgba(255,255,255,.86)),
                linear-gradient(180deg, rgba(255,255,255,.62), rgba(255,255,255,.24) 38%, rgba(255,255,255,.82)) !important;
        }

        .mbg-hero-inner {
            position: relative !important;
            z-index: 8 !important;
            isolation: isolate;
        }

        .mbg-hero-inner::before {
            background:
                radial-gradient(circle at center,
                    rgba(255,255,255,.82) 0%,
                    rgba(255,255,255,.62) 38%,
                    rgba(255,255,255,.26) 62%,
                    transparent 78%
                ) !important;
            box-shadow: 0 0 90px color-mix(in srgb, var(--mbg-accent) 10%, transparent);
        }

        .mbg-hero-kicker {
            color: var(--mbg-accent) !important;
            text-shadow: none !important;
        }

        .mbg-names {
            color: var(--mbg-accent) !important;
            text-shadow:
                0 14px 36px color-mix(in srgb, var(--mbg-accent) 13%, transparent),
                0 2px 0 rgba(255,255,255,.72) !important;
        }

        .mbg-hero-date {
            color: #162033 !important;
            text-shadow: none !important;
        }

        .mbg-photo-card,
        .mbg-quote-card,
        .mbg-person-photo,
        .mbg-person-placeholder,
        .mbg-count-card,
        .mbg-detail-card,
        .mbg-map-card,
        .mbg-gallery-item,
        .mbg-gift-card,
        .mbg-form-card,
        .mbg-message-card,
        .mbg-closing-card {
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(255,255,255,.76)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--mbg-accent) 8%, transparent), transparent 42%) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
            box-shadow:
                0 26px 72px rgba(15,23,42,.08),
                inset 0 1px 0 rgba(255,255,255,.92) !important;
            color: #162033 !important;
        }

        .mbg-photo-card {
            border-radius: 34px !important;
        }

        .mbg-photo-card img,
        .mbg-person-photo,
        .mbg-gallery-item img,
        .mbg-closing-photo {
            filter: none !important;
            background: #ffffff !important;
        }

        .mbg-photo-placeholder,
        .mbg-person-placeholder {
            background:
                radial-gradient(circle at center, color-mix(in srgb, var(--mbg-accent) 12%, transparent), transparent 28%),
                color-mix(in srgb, var(--mbg-accent-2) 35%, #ffffff) !important;
            color: var(--mbg-accent) !important;
        }

        .mbg-gift-box,
        .mbg-summary-grid > div {
            background: rgba(255,255,255,.74) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 14%, transparent) !important;
        }

        .mbg-input {
            color: #162033 !important;
            background: rgba(255,255,255,.88) !important;
            border-color: color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
            border-radius: 18px !important;
        }

        .mbg-input::placeholder {
            color: #94a3b8 !important;
        }

        .mbg-label-form {
            color: #162033 !important;
        }

        .mbg-map-placeholder {
            color: var(--mbg-accent) !important;
            background:
                radial-gradient(circle at center, color-mix(in srgb, var(--mbg-accent) 9%, transparent), transparent 28%),
                #ffffff !important;
        }

        .mbg-map-placeholder p,
        .mbg-gift-box small,
        .mbg-gift-box p {
            color: #64748b !important;
        }

        .mbg-gift-box strong,
        .mbg-summary-grid b {
            color: var(--mbg-accent) !important;
        }

        .mbg-message-card p {
            color: #475569 !important;
        }

        .mbg-closing-photo {
            border-color: color-mix(in srgb, var(--mbg-accent) 20%, transparent) !important;
        }

        @media (hover: hover) {
            .mbg-photo-card:hover,
            .mbg-quote-card:hover,
            .mbg-person:hover,
            .mbg-count-card:hover,
            .mbg-detail-card:hover,
            .mbg-gallery-item:hover,
            .mbg-gift-card:hover,
            .mbg-form-card:hover,
            .mbg-message-card:hover,
            .mbg-closing-card:hover {
                border-color: color-mix(in srgb, var(--mbg-accent) 34%, transparent) !important;
                box-shadow:
                    0 32px 86px rgba(15,23,42,.12),
                    0 0 42px color-mix(in srgb, var(--mbg-accent) 10%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.95) !important;
            }
        }

        @media (max-width: 900px) {
            .mbg-shell {
                padding: 14px !important;
            }

            .mbg-wrap {
                border-radius: 24px !important;
            }
        }

        @media (max-width: 640px) {
            .mbg-shell {
                padding: 0 !important;
            }

            .mbg-wrap {
                border-radius: 0 !important;
                border-left: 0 !important;
                border-right: 0 !important;
            }

            .mbg-hero-bg {
                opacity: .58 !important;
            }

            .mbg-hero-inner::before {
                width: min(650px, 96vw) !important;
                height: min(520px, 72vh) !important;
            }
        }

        /* =====================================================
        FIX TEXT CONTRAST - COUNTDOWN & RSVP SUMMARY
        Untuk wedding-elegant-white
        ===================================================== */

        /* Card countdown */
        .mbg-count-card {
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.92)),
                radial-gradient(circle at 50% 0%, color-mix(in srgb, var(--mbg-accent) 10%, transparent), transparent 42%) !important;
            border: 1px solid color-mix(in srgb, var(--mbg-accent) 24%, transparent) !important;
            box-shadow:
                0 20px 46px rgba(15,23,42,.08),
                inset 0 1px 0 rgba(255,255,255,.96) !important;
        }

        /* Angka countdown */
        .mbg-count-number {
            color: var(--mbg-accent) !important;
            opacity: 1 !important;
            text-shadow:
                0 2px 0 rgba(255,255,255,.85),
                0 10px 24px color-mix(in srgb, var(--mbg-accent) 18%, transparent) !important;
        }

        /* Label DAYS / HOURS / MINUTES / SECONDS */
        .mbg-count-label {
            color: #334155 !important;
            opacity: 1 !important;
            font-weight: 950 !important;
            letter-spacing: .10em !important;
            text-shadow: none !important;
        }

        /* Card summary RSVP */
        .mbg-summary-grid > div {
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.92)) !important;
            border: 1px solid color-mix(in srgb, var(--mbg-accent) 22%, transparent) !important;
            box-shadow:
                0 18px 40px rgba(15,23,42,.07),
                inset 0 1px 0 rgba(255,255,255,.96) !important;
        }

        /* Angka RSVP */
        .mbg-summary-grid b {
            color: var(--mbg-accent) !important;
            opacity: 1 !important;
            text-shadow:
                0 2px 0 rgba(255,255,255,.85),
                0 10px 22px color-mix(in srgb, var(--mbg-accent) 16%, transparent) !important;
        }

        /* Label Hadir / Tidak Hadir / Ragu */
        .mbg-summary-grid span {
            color: #334155 !important;
            opacity: 1 !important;
            font-weight: 850 !important;
            text-shadow: none !important;
        }

        /* Supaya teks kecil dalam form/message tetap terbaca */
        .mbg-form-card small,
        .mbg-message-card small,
        .mbg-detail-place,
        .mbg-gift-box small,
        .mbg-gift-box p {
            color: #475569 !important;
            opacity: 1 !important;
        }

        /* =====================================================
        HERO DEFAULT COVER - ELEGANT WHITE
        ===================================================== */

        .mbg-hero {
            position: relative !important;
            overflow: hidden !important;
            background:
                radial-gradient(circle at 50% 38%, color-mix(in srgb, var(--mbg-accent) 8%, transparent), transparent 34%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
        }

        /* Background hero tetap di belakang tulisan */
        .mbg-hero-bg {
            position: absolute !important;
            inset: 0 !important;
            z-index: 0 !important;
            pointer-events: none !important;
            background-image:
                linear-gradient(180deg, rgba(255,255,255,.50), rgba(255,255,255,.82)),
                var(--mbg-hero-image) !important;
            background-repeat: no-repeat !important;
        }

        /* Jika cover kosong/reset: pasangan.png tampil hitam putih, soft, dominan putih */
        .mbg-hero-bg.is-default-cover {
            opacity: .42 !important;
            filter: grayscale(1) brightness(1.85) contrast(.78) !important;
            background-size: contain !important;
            background-position: center bottom !important;
            transform: scale(1.02) !important;
        }

        /* Jika user upload cover: default hilang, gambar user tampil */
        .mbg-hero-bg.is-uploaded-cover {
            opacity: .30 !important;
            filter: grayscale(.12) brightness(1.08) contrast(.96) !important;
            background-size: cover !important;
            background-position: center center !important;
            transform: scale(1.035) !important;
        }

        /* Overlay putih agar teks tetap terbaca */
        .mbg-hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background:
                radial-gradient(circle at center, rgba(255,255,255,.35), rgba(255,255,255,.72) 70%),
                linear-gradient(180deg, rgba(255,255,255,.42), rgba(255,255,255,.82)) !important;
        }

        /* Untuk default, overlay dibuat lebih putih */
        .mbg-hero-bg.is-default-cover::before {
            background:
                radial-gradient(circle at center, rgba(255,255,255,.18), rgba(255,255,255,.70) 72%),
                linear-gradient(180deg, rgba(255,255,255,.34), rgba(255,255,255,.78)) !important;
        }

        /* Untuk cover upload, overlay dibuat lebih kuat supaya tulisan aman */
        .mbg-hero-bg.is-uploaded-cover::before {
            background:
                radial-gradient(circle at center, rgba(255,255,255,.42), rgba(255,255,255,.82) 74%),
                linear-gradient(180deg, rgba(255,255,255,.54), rgba(255,255,255,.86)) !important;
        }

        /* Matikan overlay gelap lama */
        .mbg-hero-bg::after {
            background:
                linear-gradient(90deg, rgba(255,255,255,.88), rgba(255,255,255,.42) 48%, rgba(255,255,255,.88)),
                linear-gradient(180deg, rgba(255,255,255,.72), rgba(255,255,255,.28) 38%, rgba(255,255,255,.88)) !important;
        }

        /* Konten hero harus berada di atas background */
        .mbg-hero-inner,
        .mbg-hero-kicker,
        .mbg-names,
        .mbg-hero-date,
        .mbg-hero-to,
        .mbg-hero-actions {
            position: relative !important;
            z-index: 8 !important;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .mbg-hero-bg.is-default-cover {
                opacity: .30 !important;
                background-size: cover !important;
                background-position: center bottom !important;
            }

            .mbg-hero-bg.is-uploaded-cover {
                opacity: .22 !important;
            }
        }

        /* =====================================================
        FIX HERO IMAGE DEFAULT - ELEGANT WHITE
        Paksa pasangan.png terlihat di hero
        ===================================================== */

        .mbg-hero {
            position: relative !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        .mbg-hero-bg {
            position: absolute !important;
            inset: 0 !important;
            z-index: 0 !important;
            pointer-events: none !important;

            background-image: var(--mbg-hero-image) !important;
            background-repeat: no-repeat !important;
            background-position: center bottom !important;
            background-size: contain !important;

            opacity: 1 !important;
            transform: none !important;
        }

        /* Jika cover kosong/reset: pasangan.png terlihat hitam putih dominan putih */
        .mbg-hero-bg.is-default-cover {
            opacity: .42 !important;
            filter: grayscale(1) brightness(1.55) contrast(.9) !important;
            background-size: contain !important;
            background-position: center bottom !important;
        }

        /* Jika user upload cover */
        .mbg-hero-bg.is-uploaded-cover {
            opacity: .24 !important;
            filter: grayscale(.15) brightness(1.08) contrast(.98) !important;
            background-size: cover !important;
            background-position: center center !important;
        }

        /* Overlay putih tipis saja, jangan sampai menutupi gambar */
        .mbg-hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,.35), rgba(255,255,255,.70)),
                radial-gradient(circle at center, rgba(255,255,255,.10), rgba(255,255,255,.58));
            pointer-events: none;
        }

        /* Matikan overlay gelap/putih lama yang terlalu menutup */
        .mbg-hero-bg::after {
            display: none !important;
        }

        /* Konten tetap di atas gambar */
        .mbg-hero-inner,
        .mbg-nav {
            position: relative !important;
            z-index: 5 !important;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .mbg-hero-bg.is-default-cover {
                opacity: .30 !important;
                background-size: cover !important;
                background-position: center bottom !important;
            }
        }

        /* ===============================
        HERO IMAGE FULL LEFT-RIGHT
        =============================== */

        .mbg-hero {
            position: relative !important;
            overflow: hidden !important;
        }

        .mbg-hero-image-layer {
            position: absolute !important;
            inset: 0 !important;
            z-index: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        .mbg-hero-image {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: block !important;
        }

        /* Default pasangan.png */
        .mbg-hero-image-layer.is-default-cover .mbg-hero-image {
            object-fit: cover !important;
            object-position: center center !important;
            opacity: .30 !important;
            filter: grayscale(1) brightness(1.55) contrast(.92) !important;
        }

        /* Kalau user upload cover */
        .mbg-hero-image-layer.is-uploaded-cover .mbg-hero-image {
            object-fit: cover !important;
            object-position: center center !important;
            opacity: .22 !important;
            filter: grayscale(.08) brightness(1.08) contrast(.96) !important;
        }

        /* overlay putih agar teks tetap terbaca */
        .mbg-hero-image-layer::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,.60), rgba(255,255,255,.78)),
                radial-gradient(circle at center, rgba(255,255,255,.12), rgba(255,255,255,.38));
            z-index: 1;
        }

        /* konten hero tetap di atas gambar */
        .mbg-nav,
        .mbg-hero-inner,
        .mbg-hero-content,
        .mbg-hero-text,
        .mbg-hero-actions {
            position: relative !important;
            z-index: 3 !important;
        }

        /* =====================================================
        HAPUS EFEK LINGKARAN EMAS HERO
        Wedding Elegant White
        ===================================================== */

        /* Hilangkan background lingkaran emas dari hero */
        .mbg-hero {
            background:
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
        }

        /* Jika masih ada background hero lama */
        .mbg-hero-bg,
        .mbg-hero-bg::before,
        .mbg-hero-bg::after {
            background-image: none !important;
            box-shadow: none !important;
        }

        /* Hilangkan lingkaran/glow besar di belakang teks */
        .mbg-hero-inner::before {
            display: none !important;
            content: none !important;
            background: none !important;
            box-shadow: none !important;
        }

        /* Untuk hero versi gambar langsung */
        .mbg-hero-image-layer::after {
            background:
                linear-gradient(180deg, rgba(255,255,255,.58), rgba(255,255,255,.80)) !important;
        }

        /* Pastikan tidak ada radial glow tambahan */
        .mbg-hero-image-layer::before {
            display: none !important;
            content: none !important;
        }

        /* Konten tetap aman di atas gambar */
        .mbg-nav,
        .mbg-hero-inner,
        .mbg-hero-kicker,
        .mbg-names,
        .mbg-hero-date,
        .mbg-hero-to,
        .mbg-hero-actions {
            position: relative !important;
            z-index: 5 !important;
        }

    </style>
</head>

@php
    $photos = $invitation->photos ?? collect();
    $firstPhoto = $photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Ivan & Fanny';
    $eventName = $invitation->event_name ?: 'Pernikahan';

    $nameParts = preg_split('/\s+(?:&|dan|\+)\s+/i', $eventTitle);
    $firstName = trim($nameParts[0] ?? $eventTitle);
    $secondName = trim($nameParts[1] ?? '');

    if ($secondName === '' && str_contains($eventTitle, '&')) {
        [$firstName, $secondName] = array_map('trim', explode('&', $eventTitle, 2));
    }
    if ($secondName === '') { $secondName = 'Pasangan'; }

    $people = $invitation->people ?? collect();
    $bride = $people->get(0);
    $groom = $people->get(1);

    $eventDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y')
        : 'Tanggal belum diatur';

    $eventEndDateText = $invitation->event_end_date
        ? \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y')
        : null;

    $eventDateRangeText = $eventDateText;

    if ($eventEndDateText && $eventEndDateText !== $eventDateText) {
        $eventDateRangeText = $eventDateText . ' - ' . $eventEndDateText;
    }

    $eventStartInfoText = $eventDateText;
    $eventEndInfoText = $eventEndDateText;

    $heroDateText = $invitation->event_date
        ? \Carbon\Carbon::parse($invitation->event_date)->format('d . m . y')
        : '-- . -- . --';

    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) {
        $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i');
    }

    $locationText = $invitation->location_name ?: 'Lokasi Acara';
    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;

    $countdownTarget = null;
    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
        $timePart = '00:00:00';
        if (!empty($invitation->event_time)) {
            try { $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s'); } catch (\Exception $e) { $timePart = '00:00:00'; }
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

    $shareMessage =
        "Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n*{$eventTitle}*\n\nTanggal: {$eventDateRangeText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    $shareMessage .= "\nBuka undangan lengkap:\n{$shareUrl}";
    $shareText = urlencode($shareMessage);

    $coverPhoto = $invitation->cover_image
        ? asset('storage/' . $invitation->cover_image)
        : null;

    /*
    |--------------------------------------------------------------------------
    | Hero cover
    |--------------------------------------------------------------------------
    | Jika user upload cover, pakai cover user.
    | Jika cover kosong / reset, pakai pasangan.png default.
    */
    $heroDefaultCover = asset('assets/elegant-white/pasangan.png');
    $heroImage = $coverPhoto ?: $heroDefaultCover;
    $heroUsesDefaultCover = empty($invitation->cover_image);

    $closingPhoto = $coverPhoto ?: ($firstPhoto ? asset('storage/' . $firstPhoto->image_path) : null);
@endphp


@php
    $themeColor = $invitation->theme_color ?? 'gold';

    if ($themeColor === 'golden') {
        $themeColor = 'gold';
    }

    $mbgThemes = [
        'maroon' => [
            'accent' => '#b95f52',
            'accent2' => '#f1b07e',
            'soft' => '#ffd9c8',
            'glow' => 'rgba(185, 95, 82, .24)',
            'nav' => 'rgba(31, 8, 7, .86)',
        ],
        'emerald' => [
            'accent' => '#3dd6a3',
            'accent2' => '#c9f7df',
            'soft' => '#d7ffe9',
            'glow' => 'rgba(61, 214, 163, .22)',
            'nav' => 'rgba(4, 29, 24, .86)',
        ],
        'navy' => [
            'accent' => '#7aa7ff',
            'accent2' => '#d8e6ff',
            'soft' => '#e6efff',
            'glow' => 'rgba(122, 167, 255, .22)',
            'nav' => 'rgba(5, 13, 33, .86)',
        ],
        'rose' => [
            'accent' => '#f28bb2',
            'accent2' => '#ffd6e5',
            'soft' => '#ffe7ef',
            'glow' => 'rgba(242, 139, 178, .22)',
            'nav' => 'rgba(42, 8, 22, .86)',
        ],
        'gold' => [
            'accent' => '#e2bd65',
            'accent2' => '#fff0b8',
            'soft' => '#fff4cf',
            'glow' => 'rgba(226, 189, 101, .24)',
            'nav' => 'rgba(17, 13, 5, .86)',
        ],
        'slate' => [
            'accent' => '#cbd5e1',
            'accent2' => '#f1f5f9',
            'soft' => '#f8fafc',
            'glow' => 'rgba(203, 213, 225, .18)',
            'nav' => 'rgba(10, 15, 22, .86)',
        ],
    ];

    $mbgTheme = $mbgThemes[$themeColor] ?? $mbgThemes['gold'];
@endphp

<body
    style="
        --mbg-accent: {{ $mbgTheme['accent'] }};
        --mbg-accent-2: {{ $mbgTheme['accent2'] }};
        --mbg-soft: {{ $mbgTheme['soft'] }};
        --mbg-glow: {{ $mbgTheme['glow'] }};
        --mbg-nav: {{ $mbgTheme['nav'] }};
    "
>
    <main class="mbg-shell">
        <div class="mbg-wrap">
            <div class="mbg-silk"></div>

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
                @if ($mapOpenUrl)
                    <a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon"></a>
                @endif
            </div>

            <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background1.mp3') }}" preload="auto" loop></audio>


            <section id="opening" class="mbg-section mbg-hero">

                <div class="mbg-hero-image-layer {{ $heroUsesDefaultCover ? 'is-default-cover' : 'is-uploaded-cover' }}">
                    <img src="{{ $heroImage }}"
                        alt="Hero Cover"
                        class="mbg-hero-image">
                </div>
                <div class="mbg-hero-inner">
                    <p class="mbg-hero-kicker">The Wedding Of</p>
                    <h1 class="mbg-title mbg-names responsive-text">{{ $firstName }} & {{ $secondName }}</h1>
                    <p class="mbg-hero-date">{{ $heroDateText }}</p>
                    <div class="mbg-hero-to">
                        <p>Dear;</p>
                        <p>Family & Friends</p>
                    </div>
                    <div class="mbg-hero-actions">
                        <a href="#quote" class="mbg-btn">Open Invitation</a>
                    </div>
                </div>
            </section>

            <section id="quote" class="mbg-section compact">
                <div class="mbg-cover-grid">
                    <p class="mbg-label">The Wedding Of</p>
                    <h2 class="mbg-title text-4xl md:text-6xl responsive-text">{{ $firstName }} & {{ $secondName }}</h2>
                    <p class="mbg-hero-date">{{ $heroDateText }}</p>
                    <div class="mbg-photo-card">
                        @if ($coverPhoto) <img src="{{ $coverPhoto }}" alt="{{ $eventTitle }}"> @else <div class="mbg-photo-placeholder"></div> @endif
                    </div>
                    <div class="mbg-quote-card">
                        <h2 class="mbg-title responsive-text">{{ $eventName }}</h2>
                        <p class="responsive-text">{{ $invitation->description ?: 'Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia kami.' }}</p>
                    </div>
                </div>
            </section>

            <section id="couple" class="mbg-section compact text-center">
                <p class="mbg-label">Bride & Groom</p>
                <h2 class="mbg-title text-4xl md:text-6xl mt-5">{{ $firstName }} & {{ $secondName }}</h2>

                <div class="mbg-couple-grid">
                    <div class="mbg-person">
                        @if ($bride?->photo)
                            <img src="{{ asset('storage/' . $bride->photo) }}" alt="{{ $bride->name }}" class="mbg-person-photo">
                        @else
                            <div class="mbg-person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($bride?->name ?: $firstName, 0, 1)) }}</div>
                        @endif
                        <h3 class="mbg-title responsive-text">{{ $bride?->name ?: $firstName }}</h3>
                        <div class="sub responsive-text">{{ $bride?->subtitle ?: 'Mempelai Wanita' }}</div>
                        <div class="family responsive-text">{{ $bride?->family_name ?: 'Putri dari keluarga tercinta' }}</div>
                    </div>

                    <div class="mbg-person">
                        @if ($groom?->photo)
                            <img src="{{ asset('storage/' . $groom->photo) }}" alt="{{ $groom->name }}" class="mbg-person-photo">
                        @else
                            <div class="mbg-person-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($groom?->name ?: $secondName, 0, 1)) }}</div>
                        @endif
                        <h3 class="mbg-title responsive-text">{{ $groom?->name ?: $secondName }}</h3>
                        <div class="sub responsive-text">{{ $groom?->subtitle ?: 'Mempelai Pria' }}</div>
                        <div class="family responsive-text">{{ $groom?->family_name ?: 'Putra dari keluarga tercinta' }}</div>
                    </div>
                </div>
            </section>

            <section id="date" class="mbg-section compact text-center">
                <p class="mbg-label">Count The Date</p>
                <h2 class="mbg-title text-4xl md:text-6xl mt-5">Count The Date</h2>
                <div class="mbg-count-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                    <div class="mbg-count-card"><span class="mbg-count-number" id="countdown-days">00</span><span class="mbg-count-label">Days</span></div>
                    <div class="mbg-count-card"><span class="mbg-count-number" id="countdown-hours">00</span><span class="mbg-count-label">Hours</span></div>
                    <div class="mbg-count-card"><span class="mbg-count-number" id="countdown-minutes">00</span><span class="mbg-count-label">Minutes</span></div>
                    <div class="mbg-count-card"><span class="mbg-count-number" id="countdown-seconds">00</span><span class="mbg-count-label">Seconds</span></div>
                </div>
                @if ($googleCalendarUrl)
                    <div class="mt-8"><a href="{{ $googleCalendarUrl }}" target="_blank" class="mbg-btn">Add To Calendar</a></div>
                @endif
            </section>

            <section id="detail" class="mbg-section compact text-center">
                <p class="mbg-label">Wedding Detail</p>
                <div class="mbg-detail-card">
                    <h3 class="mbg-title responsive-text">{{ $eventName }}</h3>
                    <div class="mbg-detail-line">
                        @if ($eventEndInfoText && $eventEndInfoText !== $eventStartInfoText)
                            <span class="block text-xs uppercase tracking-[.18em] opacity-70">
                                Mulai Acara
                            </span>
                            {{ $eventStartInfoText }}<br>

                            <span class="block text-xs uppercase tracking-[.18em] opacity-70 mt-3">
                                Berakhir Acara
                            </span>
                            {{ $eventEndInfoText }}<br>

                            <span class="block text-xs uppercase tracking-[.18em] opacity-70 mt-3">
                                Waktu
                            </span>
                            {{ $eventTimeText ? $eventTimeText : 'Waktu belum diatur' }}
                        @else
                            <span class="block text-xs uppercase tracking-[.18em] opacity-70">
                                Tanggal Acara
                            </span>
                            {{ $eventDateText }}<br>

                            <span class="block text-xs uppercase tracking-[.18em] opacity-70 mt-3">
                                Waktu
                            </span>
                            {{ $eventTimeText ? $eventTimeText : 'Waktu belum diatur' }}
                        @endif
                    </div>
                    <div class="mbg-detail-place responsive-text">
                        {{ $locationText }}
                        @if ($invitation->address)<br>{{ $invitation->address }}@endif
                    </div>
                    @if ($mapOpenUrl)<div class="mt-6"><a href="{{ $mapOpenUrl }}" target="_blank" class="mbg-btn">View Location</a></div>@endif
                </div>

                @if ($invitation->address || $mapOpenUrl)
                    <div class="mbg-map-card">
                        @if ($mapEmbedUrl)
                            <iframe src="{{ $mapEmbedUrl }}" class="mbg-map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                        @elseif ($mapOpenUrl)
                            <a href="{{ $mapOpenUrl }}" target="_blank" class="mbg-map-placeholder">
                                <div><p class="text-5xl">📍</p><p class="font-black mt-3">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p><p class="mt-2" style="color:rgba(248,241,220,.62);">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p></div>
                            </a>
                        @else
                            <div class="mbg-map-placeholder"><div><p class="text-5xl">📍</p><p class="font-black mt-3">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p><p class="mt-2" style="color:rgba(248,241,220,.62);">{{ $invitation->address }}</p></div></div>
                        @endif
                    </div>
                @endif
            </section>

            @if ($photos->count())
                <section id="gallery" class="mbg-section compact text-center">
                    <p class="mbg-label">Our Gallery</p>
                    <h2 class="mbg-title text-4xl md:text-6xl mt-5">Our Moment</h2>
                    <div class="mbg-gallery-grid">
                        @foreach ($photos as $photo)
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="mbg-gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Gallery">
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($invitation->gifts->count())
                <section id="gift" class="mbg-section compact">
                    <div class="text-center">
                        <p class="mbg-label">Wedding Gift</p>
                        <h2 class="mbg-title text-4xl md:text-6xl mt-5">Wedding Gift</h2>
                        <p class="mbg-text mt-4 max-w-2xl mx-auto">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi berikut.</p>
                    </div>
                    <div class="mbg-gift-grid">
                        @foreach ($invitation->gifts as $gift)
                            <div class="mbg-gift-card">
                                <div class="mbg-gift-title responsive-text">{{ $gift->label ?: 'Wedding Gift' }}</div>
                                <div class="mbg-gift-box">
                                    <small class="font-black uppercase tracking-[.15em]" style="color:rgba(248,241,220,.48);">Nomor / Rekening</small>
                                    <strong class="responsive-text block mt-2 text-xl" style="color:#e2bd65;">{{ $gift->account_number ?: '-' }}</strong>
                                    <p class="responsive-text mt-2" style="color:rgba(248,241,220,.62);">{{ $gift->account_name ?: 'Atas nama penerima' }}</p>
                                </div>
                                @if ($gift->account_number)
                                    <button type="button" class="mbg-copy-btn" data-copy="{{ $gift->account_number }}">Salin Nomor</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="message" class="mbg-section compact">
                <div class="text-center">
                    <p class="mbg-label">RSVP Form</p>
                    <h2 class="mbg-title text-4xl md:text-6xl mt-5">RSVP & Wishes</h2>
                    <p class="mbg-text mt-4 max-w-2xl mx-auto">Mohon konfirmasi kehadiran dan tuliskan ucapan terbaik Anda.</p>
                </div>

                <div class="mbg-form-wrap">
                    @if (session('message_success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>@endif
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                            <p class="font-bold">Mohon periksa kembali isian:</p>
                            <ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="mbg-form-card space-y-4">
                        @csrf
                        <div><label class="mbg-label-form">Nama</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="mbg-input mt-1" placeholder="Nama" required></div>
                        <div>
                            <label class="mbg-label-form">Konfirmasi Kehadiran</label>
                            <select name="attendance_status" class="mbg-input mt-1">
                                <option value="">Pilih status kehadiran</option>
                                <option value="hadir">Saya berencana hadir</option>
                                <option value="tidak_hadir">Tidak bisa hadir</option>
                                <option value="ragu">Masih ragu</option>
                            </select>
                        </div>
                        <div><label class="mbg-label-form">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="mbg-input mt-1"></div>
                        <div><label class="mbg-label-form">Pesan</label><textarea name="message" rows="4" class="mbg-input mt-1" placeholder="Tulis pesan..." required>{{ old('message') }}</textarea></div>
                        <button type="submit" class="w-full mbg-btn">Kirim Konfirmasi</button>
                    </form>

                    <div class="mbg-summary-grid">
                        <div><b>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</b><p class="text-xs mt-2" style="color:rgba(107, 92, 46, 0.52);">Tidak hadir</p></div>
                        <div><b>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</b><p class="text-xs mt-2" style="color:rgba(107, 92, 46, 0.52);">Hadir</p></div>
                        <div><b>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</b><p class="text-xs mt-2" style="color:rgba(107, 92, 46, 0.52);">Ragu</p></div>
                    </div>

                    <div class="mbg-message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="mbg-message-card">
                                <div class="flex items-start justify-between gap-3">
                                    <div><p class="responsive-text font-black" style="color:#e2bd65;">{{ $message->guest_name }}</p><p class="text-xs mt-1" style="color:rgba(107, 92, 46, 0.46);">{{ $message->created_at->format('d M Y, H:i') }}</p></div>
                                    @if ($message->attendance_status)<span class="px-3 py-1 rounded-full text-xs font-black" style="background:rgba(214,173,92,.14); color:#e2bd65;">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif
                                </div>
                                <p class="responsive-text mt-4 leading-7" style="color:rgba(107, 92, 46, 0.64);">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="mbg-message-card text-center"><p style="color:rgba(107, 92, 46, 0.52);">Belum ada pesan.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="closing" class="mbg-section compact text-center">
                <div class="mbg-closing-card">
                    <p class="mbg-label">Thank You</p>
                    <h2 class="mbg-title text-4xl md:text-6xl mt-5">{{ $firstName }} & {{ $secondName }}</h2>
                    <p class="mbg-text mt-6 max-w-2xl mx-auto">Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.</p>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');
            if (countdownContainer) {
                const targetDate = new Date(countdownContainer.getAttribute('data-countdown-target'));
                const daysEl = document.getElementById('countdown-days');
                const hoursEl = document.getElementById('countdown-hours');
                const minutesEl = document.getElementById('countdown-minutes');
                const secondsEl = document.getElementById('countdown-seconds');

                function pad(number) { return String(number).padStart(2, '0'); }
                function updateCountdown() {
                    if (isNaN(targetDate.getTime())) return;
                    let distance = targetDate.getTime() - new Date().getTime();
                    if (distance < 0) distance = 0;
                    const totalSeconds = Math.floor(distance / 1000);
                    const days = Math.floor(totalSeconds / (60 * 60 * 24));
                    const hours = Math.floor((totalSeconds % (60 * 60 * 24)) / (60 * 60));
                    const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
                    const seconds = Math.floor(totalSeconds % 60);
                    if (daysEl) daysEl.textContent = pad(days);
                    if (hoursEl) hoursEl.textContent = pad(hours);
                    if (minutesEl) minutesEl.textContent = pad(minutes);
                    if (secondsEl) secondsEl.textContent = pad(seconds);
                }
                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            const musicToggle = document.getElementById('music-toggle');
            const musicAudio = document.getElementById('invitation-music');
            if (musicToggle && musicAudio) {
                const musicIcon = musicToggle.querySelector('img');
                musicToggle.addEventListener('click', async function () {
                    try {
                        if (musicAudio.paused) {
                            await musicAudio.play();
                            musicToggle.classList.add('is-active');
                            if (musicIcon) musicIcon.src = musicIcon.dataset.iconOn;
                        } else {
                            musicAudio.pause();
                            musicToggle.classList.remove('is-active');
                            if (musicIcon) musicIcon.src = musicIcon.dataset.iconOff;
                        }
                    } catch (error) {
                        console.log('Audio tidak bisa diputar:', error);
                    }
                });
            }

            const scrollToggle = document.getElementById('scroll-toggle');
            let autoScrollActive = false;
            let autoScrollFrame = null;
            const scrollSpeed = 1.15;

            function getScroller() { return document.scrollingElement || document.documentElement || document.body; }
            function updateScrollButton(active) {
                if (!scrollToggle) return;
                const scrollIcon = scrollToggle.querySelector('img');
                if (active) {
                    scrollToggle.classList.add('is-active');
                    if (scrollIcon && scrollIcon.dataset.iconOn) scrollIcon.src = scrollIcon.dataset.iconOn;
                } else {
                    scrollToggle.classList.remove('is-active');
                    if (scrollIcon && scrollIcon.dataset.iconOff) scrollIcon.src = scrollIcon.dataset.iconOff;
                    if (autoScrollFrame) cancelAnimationFrame(autoScrollFrame);
                    autoScrollFrame = null;
                }
            }
            function autoScrollStep() {
                if (!autoScrollActive) return;
                const scroller = getScroller();
                const maxScroll = scroller.scrollHeight - window.innerHeight;
                const currentScroll = scroller.scrollTop;
                if (currentScroll >= maxScroll - 2) {
                    autoScrollActive = false;
                    updateScrollButton(false);
                    return;
                }
                scroller.scrollTop = currentScroll + scrollSpeed;
                autoScrollFrame = requestAnimationFrame(autoScrollStep);
            }
            if (scrollToggle) {
                scrollToggle.addEventListener('click', function () {
                    autoScrollActive = !autoScrollActive;
                    updateScrollButton(autoScrollActive);
                    if (autoScrollActive) autoScrollStep();
                });
            }
            window.addEventListener('wheel', function () {
                if (autoScrollActive) {
                    autoScrollActive = false;
                    updateScrollButton(false);
                }
            }, { passive: true });
            window.addEventListener('touchstart', function () {
                if (autoScrollActive) {
                    autoScrollActive = false;
                    updateScrollButton(false);
                }
            }, { passive: true });

            document.querySelectorAll('[data-copy]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const text = this.getAttribute('data-copy');
                    try {
                        await navigator.clipboard.writeText(text);
                        const original = this.textContent;
                        this.textContent = 'Berhasil Disalin';
                        setTimeout(() => { this.textContent = original; }, 1800);
                    } catch (error) {
                        alert('Gagal menyalin teks.');
                    }
                });
            });

            /* =====================================================
            SCROLL REVEAL ANIMATION
            ===================================================== */

            const revealElements = document.querySelectorAll(`
                .mbg-label,
                .mbg-title,
                .mbg-text,
                .mbg-photo-card,
                .mbg-quote-card,
                .mbg-person,
                .mbg-count-card,
                .mbg-detail-card,
                .mbg-map-card,
                .mbg-gallery-item,
                .mbg-gift-card,
                .mbg-form-card,
                .mbg-message-card,
                .mbg-closing-card
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 35, 280) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('mbg-show');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.14,
                rootMargin: '0px 0px -60px 0px'
            });

            revealElements.forEach(function (element) {
                revealObserver.observe(element);
            });

            /* =====================================================
            ANTI INSPECT RINGAN UNTUK HALAMAN PREVIEW/PUBLIC
            Catatan: ini hanya mempersulit, bukan keamanan mutlak.
            ===================================================== */

            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';

                if (!['input', 'textarea', 'select'].includes(tagName)) {
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

                    const notice = document.createElement('div');
                    notice.textContent = 'Akses inspeksi halaman dinonaktifkan.';
                    notice.style.position = 'fixed';
                    notice.style.left = '50%';
                    notice.style.bottom = '24px';
                    notice.style.transform = 'translateX(-50%)';
                    notice.style.zIndex = '99999';
                    notice.style.padding = '12px 18px';
                    notice.style.borderRadius = '999px';
                    notice.style.background = 'rgba(8,8,8,.92)';
                    notice.style.color = 'var(--mbg-accent-2)';
                    notice.style.border = '1px solid color-mix(in srgb, var(--mbg-accent) 42%, transparent)';
                    notice.style.boxShadow = '0 18px 40px rgba(0,0,0,.35)';
                    notice.style.fontWeight = '800';
                    notice.style.fontSize = '13px';
                    notice.style.pointerEvents = 'none';

                    document.body.appendChild(notice);

                    setTimeout(function () {
                        notice.style.opacity = '0';
                        notice.style.transition = 'opacity .25s ease';

                        setTimeout(function () {
                            notice.remove();
                        }, 280);
                    }, 1600);
                }
            });
        });
    </script>
</body>
</html>
