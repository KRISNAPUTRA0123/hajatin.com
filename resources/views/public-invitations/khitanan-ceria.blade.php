<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Khitanan') . ' ' . ($invitation->title ?: 'Khitan Ceria'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--kh-dark);
            background:
                radial-gradient(circle at 8% 6%, var(--kh-glow-1), transparent 30%),
                radial-gradient(circle at 92% 4%, var(--kh-glow-2), transparent 32%),
                linear-gradient(180deg, #fff 0%, var(--kh-soft) 50%, #fff 100%);
        }
        .kh-shell { width: min(100%, 1240px); margin: 0 auto; padding: 24px; }
        .kh-wrap {
            position: relative; overflow: hidden; min-height: 100vh; border-radius: 44px;
            background:
                radial-gradient(circle at 10% 10%, color-mix(in srgb, var(--kh-accent) 52%, transparent), transparent 30%),
                radial-gradient(circle at 90% 12%, color-mix(in srgb, var(--kh-primary) 11%, transparent), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.99), rgba(255,255,255,.96));
            border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent);
            box-shadow: 0 34px 90px rgba(15,23,42,.08);
        }
        .kh-wrap::before {
            content: ""; position: absolute; inset: 0; pointer-events: none; opacity: .18;
            background-image:
                linear-gradient(to right, color-mix(in srgb, var(--kh-primary) 9%, transparent) 1px, transparent 1px),
                linear-gradient(to bottom, color-mix(in srgb, var(--kh-primary) 9%, transparent) 1px, transparent 1px);
            background-size: 42px 42px;
        }
        .kh-wrap > * { position: relative; z-index: 1; }
        .responsive-text { display: block; max-width: 100%; min-width: 0; overflow-wrap: anywhere; word-break: break-word; white-space: pre-line; }
        .kh-section { min-height: 100vh; padding: 90px 64px; display: flex; flex-direction: column; justify-content: center; }
        .kh-section.compact { min-height: auto; padding-top: 78px; padding-bottom: 78px; }
        .kh-nav {
            position: sticky; top: 18px; z-index: 30; width: fit-content; max-width: calc(100% - 28px);
            margin: 18px auto 0; padding: 8px; display: flex; gap: 6px; overflow-x: auto;
            border-radius: 999px; background: rgba(255,255,255,.90); backdrop-filter: blur(18px);
            border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent);
            box-shadow: 0 14px 34px rgba(15,23,42,.08);
        }
        .kh-nav a { padding: 10px 14px; border-radius: 999px; color: var(--kh-text); font-size: 12px; font-weight: 900; text-decoration: none; white-space: nowrap; }
        .kh-nav a:hover { color: var(--kh-primary); background: color-mix(in srgb, var(--kh-primary) 8%, white); }
        .floating-actions { position: fixed; right: 22px; top: 50%; transform: translateY(-50%); z-index: 60; display: flex; flex-direction: column; gap: 10px; }
        .floating-actions a, .floating-action-button { width: 46px; height: 46px; border-radius: 999px; background: rgba(255,255,255,.96); box-shadow: 0 14px 30px rgba(15,23,42,.16); display: flex; align-items: center; justify-content: center; text-decoration: none; border: none; cursor: pointer; padding: 0; }
        .floating-action-button.is-active { background: color-mix(in srgb, var(--kh-accent) 42%, white); }
        .floating-icon { width: 23px; height: 23px; object-fit: contain; }
        .kh-label { display: inline-flex; align-items: center; justify-content: center; gap: 12px; color: var(--kh-primary); font-size: 12px; font-weight: 950; letter-spacing: .22em; text-transform: uppercase; }
        .kh-label::before, .kh-label::after { content: ""; width: 36px; height: 1px; background: color-mix(in srgb, var(--kh-primary) 36%, transparent); }
        .kh-title { color: var(--kh-dark); line-height: .96; letter-spacing: -.055em; font-weight: 950; }
        .kh-gradient-text { background: linear-gradient(135deg, var(--kh-dark), var(--kh-primary), var(--kh-secondary)); -webkit-background-clip: text; color: transparent; }
        .kh-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 26px; border-radius: 999px; text-decoration: none; border: none; cursor: pointer; font-weight: 900; color: white; background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); box-shadow: 0 18px 40px color-mix(in srgb, var(--kh-primary) 20%, transparent); }
        .kh-btn.secondary { color: var(--kh-dark); background: #fff; border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 14px 28px rgba(15,23,42,.07); }

        /* HERO - berbeda dari template aqiqah */
        .kh-hero { position: relative; min-height: auto; padding: 92px 64px 104px; display: grid; grid-template-columns: minmax(0,.92fr) minmax(420px,1.08fr); gap: 58px; align-items: center; isolation: isolate; }
        .kh-hero::before { content: ""; position: absolute; right: 36%; top: 48%; width: 680px; height: 680px; border-radius: 999px; background: radial-gradient(circle, color-mix(in srgb, var(--kh-accent) 38%, transparent), transparent 68%); transform: translate(50%,-50%); z-index: 0; pointer-events: none; }
        .kh-copy, .kh-visual { position: relative; z-index: 2; min-width: 0; }
        .kh-kicker { display: inline-flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 999px; background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 16px 32px rgba(15,23,42,.07); color: var(--kh-primary); font-size: 12px; font-weight: 950; letter-spacing: .18em; text-transform: uppercase; }
        .kh-kicker span { width: 30px; height: 30px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; color: white; background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); }
        .kh-hero-title { margin-top: 30px; max-width: 650px; font-size: clamp(3rem, 5.4vw, 5.15rem); line-height: .96; letter-spacing: -.058em; font-weight: 950; }
        .kh-hero-title .line-accent { display: block; color: color-mix(in srgb, var(--kh-primary) 78%, var(--kh-dark)); }
        .kh-desc { max-width: 590px; margin-top: 24px; color: var(--kh-text); font-size: 1.05rem; line-height: 1.95; }
        .kh-host-ticket { width: min(100%, 540px); margin-top: 30px; padding: 18px 20px; border-radius: 30px; background: rgba(255,255,255,.90); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 16px 34px rgba(15,23,42,.06); display: grid; grid-template-columns: 54px 1fr; gap: 16px; align-items: center; }
        .kh-host-icon { width: 54px; height: 54px; border-radius: 18px; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at 35% 30%, #fff, transparent 35%), color-mix(in srgb, var(--kh-accent) 64%, white); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); color: var(--kh-primary); font-size: 24px; }
        .kh-host-ticket small { display: block; color: var(--kh-text); font-size: 10px; font-weight: 950; letter-spacing: .18em; text-transform: uppercase; }
        .kh-host-ticket strong { display: block; margin-top: 6px; color: var(--kh-dark); font-size: 1.08rem; font-weight: 950; line-height: 1.45; }
        .kh-action-row { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 32px; }
        .kh-mini-row { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 12px; margin-top: 36px; max-width: 610px; }
        .kh-mini-stat { position: relative; overflow: hidden; padding: 17px 18px; border-radius: 28px; background: rgba(255,255,255,.93); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 14px 30px rgba(15,23,42,.06); text-align: center; }
        .kh-mini-stat::after { content: ""; position: absolute; right: -28px; bottom: -34px; width: 92px; height: 92px; border-radius: 999px; background: color-mix(in srgb, var(--kh-accent) 42%, white); }
        .kh-mini-stat strong, .kh-mini-stat span { position: relative; z-index: 2; display: block; }
        .kh-mini-stat strong { color: var(--kh-dark); font-size: 1.8rem; line-height: 1; font-weight: 950; }
        .kh-mini-stat span { margin-top: 8px; color: var(--kh-text); font-size: 10px; letter-spacing: .15em; text-transform: uppercase; font-weight: 950; }
        .kh-visual { min-height: 720px; }
        .kh-stage { position: relative; min-height: 700px; }
        .kh-ribbon-track { position: absolute; inset: 56px 24px auto auto; width: 480px; height: 480px; border-radius: 42% 58% 62% 38% / 42% 48% 52% 58%; background: radial-gradient(circle at 36% 28%, rgba(255,255,255,.84), transparent 34%), color-mix(in srgb, var(--kh-accent) 58%, white); box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--kh-primary) 9%, transparent), 0 32px 74px rgba(15,23,42,.08); transform: rotate(-8deg); z-index: 0; }
        .kh-orbit { position: absolute; left: 48px; top: 128px; width: 360px; height: 360px; border: 1px dashed color-mix(in srgb, var(--kh-primary) 18%, transparent); border-radius: 999px; transform: rotate(-16deg); z-index: 0; }
        .kh-orbit::before, .kh-orbit::after { content: ""; position: absolute; border-radius: 999px; }
        .kh-orbit::before { width: 18px; height: 18px; left: 54px; top: 46px; background: var(--kh-primary); opacity: .65; }
        .kh-orbit::after { width: 11px; height: 11px; right: 58px; bottom: 50px; background: var(--kh-secondary); opacity: .72; }
        .kh-boy-card { position: absolute; z-index: 5; left: 0; top: 76px; width: 185px; min-height: 230px; padding: 24px 18px; border-radius: 36px 36px 999px 999px; background: rgba(255,255,255,.97); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 24px 52px rgba(15,23,42,.11); text-align: center; }
        .kh-boy-icon { width: 74px; height: 74px; margin: 0 auto 14px; border-radius: 24px; display: flex; align-items: center; justify-content: center; color: white; font-size: 34px; background: radial-gradient(circle at 35% 25%, rgba(255,255,255,.35), transparent 36%), linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); box-shadow: 0 16px 30px color-mix(in srgb, var(--kh-primary) 20%, transparent); }
        .kh-boy-card small { display: block; color: var(--kh-text); font-size: 10px; letter-spacing: .18em; text-transform: uppercase; font-weight: 950; }
        .kh-boy-card strong { display: block; margin-top: 8px; color: var(--kh-dark); font-size: 1.2rem; line-height: 1.35; font-weight: 950; }
        .kh-main-card { position: absolute; z-index: 3; right: 0; top: 112px; width: min(100%, 500px); min-height: 520px; padding: 28px; border-radius: 54px 54px 120px 54px; background: rgba(255,255,255,.97); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 34px 86px rgba(15,23,42,.12); overflow: hidden; }
        .kh-main-card::before { content: ""; position: absolute; inset: 16px; border-radius: 40px 40px 98px 40px; border: 2px dashed color-mix(in srgb, var(--kh-primary) 15%, transparent); pointer-events: none; z-index: 2; }
        .kh-main-card::after { content: ""; position: absolute; right: -76px; top: -54px; width: 210px; height: 210px; border-radius: 999px; background: color-mix(in srgb, var(--kh-accent) 52%, transparent); z-index: 0; }
        .kh-cover-photo { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: .10; z-index: 0; }
        .kh-card-content { position: relative; z-index: 3; min-height: 468px; display: flex; flex-direction: column; justify-content: space-between; }
        .kh-card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
        .kh-card-badge { display: inline-flex; padding: 8px 13px; border-radius: 999px; color: var(--kh-primary); background: color-mix(in srgb, var(--kh-accent) 40%, white); font-size: 11px; font-weight: 950; }
        .kh-card-dots { display: flex; gap: 7px; padding-top: 6px; }
        .kh-card-dots span { width: 10px; height: 10px; border-radius: 999px; background: var(--kh-primary); opacity: .65; }
        .kh-card-dots span:nth-child(2) { background: var(--kh-secondary); } .kh-card-dots span:nth-child(3) { background: var(--kh-accent); }
        .kh-card-body { max-width: 380px; margin: 36px auto 0; text-align: center; }
        .kh-badge-mark { width: 98px; height: 98px; margin: 0 auto 24px; border-radius: 30px; transform: rotate(-6deg); display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at 35% 25%, #fff, color-mix(in srgb, var(--kh-accent) 48%, white)); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 18px 38px rgba(15,23,42,.08); }
        .kh-badge-mark span { display: block; transform: rotate(6deg); font-size: 44px; line-height: 1; }
        .kh-card-body h2 { color: var(--kh-dark); font-size: clamp(2.25rem, 4.1vw, 3.45rem); line-height: 1.02; letter-spacing: -.055em; font-weight: 950; }
        .kh-card-body p { margin-top: 18px; color: var(--kh-text); line-height: 1.85; }
        .kh-info-row { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 10px; margin-top: 28px; }
        .kh-info-pill { min-width: 0; padding: 13px 12px; border-radius: 22px; background: rgba(255,255,255,.94); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 10px 22px rgba(15,23,42,.05); text-align: center; }
        .kh-info-pill small { display: block; color: var(--kh-text); font-size: 9px; letter-spacing: .14em; text-transform: uppercase; font-weight: 950; }
        .kh-info-pill strong { display: block; margin-top: 7px; color: var(--kh-dark); font-size: 13px; line-height: 1.45; font-weight: 950; }
        .kh-floating-date { position: absolute; z-index: 6; left: 138px; bottom: 70px; width: 142px; min-height: 142px; padding: 20px 18px; border-radius: 38px; background: linear-gradient(180deg, rgba(255,255,255,.97), color-mix(in srgb, var(--kh-soft) 88%, white)); border: 1px solid color-mix(in srgb, var(--kh-primary) 12%, transparent); box-shadow: 0 24px 48px rgba(15,23,42,.10); text-align: center; transform: rotate(5deg); }
        .kh-floating-date b { display: block; color: var(--kh-dark); font-size: 2.8rem; line-height: 1; font-weight: 950; }
        .kh-floating-date span { display: block; margin-top: 9px; color: var(--kh-primary); font-size: 11px; letter-spacing: .18em; text-transform: uppercase; font-weight: 950; }
        .kh-blessing-card { position: absolute; z-index: 6; right: 24px; bottom: 6px; width: min(78%,370px); padding: 18px 22px; border-radius: 999px; background: rgba(255,255,255,.96); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 20px 44px rgba(15,23,42,.10); color: var(--kh-dark); font-weight: 950; line-height: 1.55; display: flex; gap: 12px; align-items: center; }
        .kh-blessing-card span { flex: 0 0 auto; width: 42px; height: 42px; border-radius: 999px; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); color: white; }
        .kh-confetti { position: absolute; z-index: 5; width: 16px; height: 16px; border-radius: 6px; background: var(--kh-primary); opacity: .72; transform: rotate(22deg); }
        .kh-confetti.one { right: 136px; top: 58px; } .kh-confetti.two { left: 260px; top: 180px; width: 10px; height: 10px; background: var(--kh-secondary); } .kh-confetti.three { right: 206px; bottom: 164px; width: 12px; height: 12px; background: var(--kh-accent); } .kh-confetti.four { right: 40px; top: 258px; width: 9px; height: 9px; border-radius: 999px; background: var(--kh-primary); }

        .section-head { text-align: center; } .section-head .desc { max-width: 760px; margin: 16px auto 0; color: var(--kh-text); line-height: 1.8; }
        .kh-grid { display: grid; gap: 20px; margin-top: 38px; justify-content: center; } .kh-grid.count-1 { grid-template-columns: minmax(280px,460px); } .kh-grid.count-2 { grid-template-columns: repeat(2,minmax(280px,460px)); } .kh-grid.count-3 { grid-template-columns: repeat(3,minmax(0,1fr)); }
        .kh-highlight-card, .child-card, .kh-card, .gift-card, .form-card, .message-card, .summary-card { background: rgba(255,255,255,.93); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 18px 42px rgba(15,23,42,.07); }
        .kh-highlight-card { position: relative; overflow: hidden; min-height: 230px; padding: 28px; border-radius: 34px; }
        .kh-highlight-card::after { content: ""; position: absolute; width: 138px; height: 138px; right: -44px; bottom: -44px; border-radius: 999px; background: color-mix(in srgb, var(--kh-accent) 26%, transparent); }
        .kh-highlight-number { position: relative; z-index: 2; width: 48px; height: 48px; border-radius: 18px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 950; background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); margin-bottom: 18px; }
        .kh-highlight-card h3, .kh-highlight-card p { position: relative; z-index: 2; } .kh-highlight-card h3 { color: var(--kh-dark); font-size: 1.35rem; font-weight: 950; } .kh-highlight-card p { margin-top: 10px; color: var(--kh-text); line-height: 1.8; }
        .child-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px,340px)); justify-content: center; gap: 20px; margin-top: 38px; } .child-grid.single-child { grid-template-columns: minmax(0,380px); }
        .child-card { position: relative; overflow: hidden; padding: 24px; border-radius: 34px; text-align: left; }
        .child-card::before { content: ""; position: absolute; width: 130px; height: 130px; right: -46px; top: -46px; border-radius: 999px; background: color-mix(in srgb, var(--kh-accent) 30%, transparent); }
        .child-photo, .child-placeholder { position: relative; z-index: 2; width: 118px; height: 118px; border-radius: 32px; object-fit: cover; display: flex; align-items: center; justify-content: center; background: linear-gradient(180deg,#fff,color-mix(in srgb,var(--kh-soft) 90%,white)); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 12px 28px rgba(15,23,42,.07); font-size: 42px; font-weight: 950; color: var(--kh-primary); }
        .child-role { position: relative; z-index: 2; display: inline-block; margin-top: 18px; padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--kh-primary) 10%, white); color: var(--kh-primary); font-size: 12px; font-weight: 900; }
        .child-card h3 { position: relative; z-index: 2; margin-top: 16px; color: var(--kh-dark); font-size: 1.7rem; font-weight: 950; } .child-card p { position: relative; z-index: 2; margin-top: 8px; color: var(--kh-text); line-height: 1.7; }
        .focus-layout { display: grid; grid-template-columns: .95fr 1.05fr; gap: 24px; margin-top: 42px; align-items: start; }
        .kh-card { padding: 30px; border-radius: 36px; } .kh-card h3 { margin: 0; color: var(--kh-dark); font-size: 2rem; font-weight: 950; }
        .detail-list { display: grid; gap: 14px; margin-top: 24px; } .detail-row { display: grid; grid-template-columns: 110px 1fr; gap: 16px; padding: 16px 0; border-top: 1px dashed color-mix(in srgb, var(--kh-primary) 16%, transparent); } .detail-row .label { color: var(--kh-text); font-size: 11px; font-weight: 950; letter-spacing: .16em; text-transform: uppercase; } .detail-row .value { color: var(--kh-dark); font-weight: 900; line-height: 1.65; }
        .kh-date-line, .kh-time-line { display: inline-flex; flex-wrap: wrap; gap: 6px; width: 100%; line-height: 1.5; }
        .countdown-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 14px; margin-top: 22px; } .countdown-card { border-radius: 26px; padding: 22px 14px; text-align: center; background: linear-gradient(180deg, color-mix(in srgb, var(--kh-soft) 90%, white), white); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); } .countdown-number { display: block; color: var(--kh-dark); font-size: 34px; line-height: 1; font-weight: 950; } .countdown-label { display: block; margin-top: 10px; color: var(--kh-text); font-size: 11px; font-weight: 900; letter-spacing: .16em; text-transform: uppercase; }
        .map-card { margin-top: 24px; overflow: hidden; border-radius: 34px; background: white; border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 18px 44px rgba(15,23,42,.07); } .map-frame, .map-placeholder { width: 100%; height: 320px; display: block; border: 0; } .map-placeholder { display: flex; align-items: center; justify-content: center; text-align: center; padding: 32px; color: var(--kh-dark); text-decoration: none; background: linear-gradient(180deg,#fff,color-mix(in srgb,var(--kh-soft) 90%,white)); }
        .gallery-grid { display: grid; grid-template-columns: 1.1fr .9fr 1.1fr; gap: 18px; margin-top: 38px; align-items: stretch; } .gallery-column { display: grid; gap: 18px; } .gallery-card { padding: 10px; overflow: hidden; border-radius: 28px; background: white; border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 18px 42px rgba(15,23,42,.07); } .gallery-card.tall img { height: 340px; } .gallery-card.short img { height: 220px; } .gallery-card img { width: 100%; object-fit: cover; display: block; border-radius: 20px; }
        .gift-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 18px; margin-top: 34px; } .gift-grid.gift-count-1 { grid-template-columns: minmax(280px,460px); justify-content: center; } .gift-card { position: relative; overflow: hidden; padding: 26px; border-radius: 34px; } .gift-card h3 { color: var(--kh-dark); font-size: 1.4rem; font-weight: 950; }
        .gift-copy-box { margin-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 14px; border-radius: 20px; background: color-mix(in srgb, var(--kh-primary) 7%, white); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); } .gift-copy-box small { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 900; color: var(--kh-text); } .gift-number { display: block; margin-top: 6px; color: var(--kh-primary); font-size: 1.1rem; font-weight: 950; } .copy-gift-btn { flex-shrink: 0; border: none; cursor: pointer; border-radius: 999px; padding: 10px 14px; color: white; font-size: 12px; font-weight: 900; background: linear-gradient(135deg, var(--kh-primary), var(--kh-secondary)); } .copy-gift-btn.copied { background: linear-gradient(135deg,#16a34a,#22c55e); }
        .rsvp-wrap { max-width: 860px; width: 100%; margin: 0 auto; } .form-card, .message-card, .summary-card { border-radius: 30px; } .form-card { padding: 28px; } .summary-grid { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 14px; margin-top: 22px; } .summary-card { text-align: center; padding: 20px; } .summary-card strong { display: block; color: var(--kh-dark); font-size: 30px; line-height: 1; font-weight: 950; } .summary-card span { display: block; margin-top: 8px; color: var(--kh-text); font-size: 12px; font-weight: 900; }
        .message-list { display: flex; flex-direction: column; gap: 14px; margin-top: 24px; } .message-card { padding: 22px; } .message-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; } .message-info { min-width: 0; flex: 1; } .message-badge { padding: 8px 12px; border-radius: 999px; background: color-mix(in srgb, var(--kh-primary) 10%, white); color: var(--kh-primary); font-size: 12px; font-weight: 900; white-space: nowrap; }
        .closing-card { position: relative; overflow: hidden; max-width: 840px; margin: 0 auto; padding: 46px 34px; text-align: center; border-radius: 40px; background: linear-gradient(135deg, color-mix(in srgb, var(--kh-primary) 10%, white), color-mix(in srgb, var(--kh-accent) 26%, white)); border: 1px solid color-mix(in srgb, var(--kh-primary) 10%, transparent); box-shadow: 0 20px 44px rgba(15,23,42,.07); } .closing-card::before, .closing-card::after { content: ""; position: absolute; width: 140px; height: 140px; border-radius: 999px; background: rgba(255,255,255,.38); } .closing-card::before { left: -42px; top: -42px; } .closing-card::after { right: -42px; bottom: -42px; }

        @media (max-width: 1100px) { .kh-hero, .focus-layout, .gift-grid { grid-template-columns: 1fr; } .kh-copy { text-align: center; } .kh-kicker, .kh-action-row { justify-content: center; margin-left: auto; margin-right: auto; } .kh-hero-title, .kh-desc, .kh-mini-row, .kh-host-ticket { margin-left: auto; margin-right: auto; } .kh-visual { min-height: auto; } .kh-stage { min-height: auto; display: grid; gap: 16px; } .kh-ribbon-track, .kh-orbit, .kh-confetti { display: none; } .kh-boy-card, .kh-main-card, .kh-floating-date, .kh-blessing-card { position: relative; left: auto; right: auto; top: auto; bottom: auto; width: 100%; margin: 0; transform: none; } .kh-boy-card { min-height: auto; border-radius: 34px; display: grid; grid-template-columns: 88px 1fr; gap: 16px; align-items: center; text-align: left; } .kh-boy-icon { margin: 0; } .kh-main-card { border-radius: 42px; } .kh-main-card::before { border-radius: 30px; } .kh-card-content { min-height: auto; } .kh-floating-date { border-radius: 28px; } .kh-blessing-card { border-radius: 28px; } .gallery-grid { grid-template-columns: 1fr; } .gallery-column { grid-template-columns: repeat(2,minmax(0,1fr)); } .kh-grid.count-3 { grid-template-columns: repeat(2,minmax(280px,460px)); } }
        @media (max-width: 980px) { .kh-shell { padding: 16px; } .kh-section { padding: 82px 38px; } .kh-hero { padding: 82px 38px 90px; } .summary-grid, .countdown-grid { grid-template-columns: repeat(2,minmax(0,1fr)); } }
        @media (max-width: 640px) { .kh-shell { padding: 0; } .kh-wrap { border-radius: 0; box-shadow: none; } .kh-section { padding: 72px 22px; } .kh-section.compact { padding-top: 64px; padding-bottom: 64px; } .kh-hero { padding: 72px 22px 82px; } .kh-hero-title { font-size: clamp(2.45rem, 11.5vw, 3.8rem); line-height: 1.02; } .kh-mini-row, .kh-info-row, .kh-grid, .kh-grid.count-1, .kh-grid.count-2, .kh-grid.count-3, .gallery-column, .summary-grid, .countdown-grid, .gift-grid, .gift-grid.gift-count-1 { grid-template-columns: 1fr; } .kh-host-ticket { grid-template-columns: 1fr; text-align: center; } .kh-host-icon { margin: 0 auto; } .kh-boy-card { grid-template-columns: 1fr; text-align: center; } .kh-boy-icon { margin: 0 auto 8px; } .kh-main-card { padding: 18px; border-radius: 32px; } .kh-main-card::before { inset: 12px; border-radius: 24px; } .kh-card-content { padding: 12px 4px 6px; } .kh-card-body h2 { font-size: clamp(2rem,10vw,3rem); } .kh-blessing-card { flex-direction: column; text-align: center; } .detail-row { grid-template-columns: 1fr; gap: 6px; } .gift-copy-box { align-items: flex-start; flex-direction: column; } .copy-gift-btn { width: 100%; } .floating-actions { right: 10px; } }


        /* =====================================================
           KHITANAN CERIA - LUXURY SCROLL ANIMATION
           Animasi halus untuk teks, kartu, ornamen, dan area konten.
        ===================================================== */
        .kh-reveal {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(10px);
            transition:
                opacity .9s cubic-bezier(.2,.8,.2,1),
                transform .9s cubic-bezier(.2,.8,.2,1),
                filter .9s cubic-bezier(.2,.8,.2,1),
                box-shadow .35s ease,
                border-color .35s ease;
            transition-delay: var(--kh-delay, 0ms);
            will-change: opacity, transform, filter;
        }

        .kh-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        .kh-kicker,
        .kh-label,
        .kh-card-badge,
        .message-badge {
            animation: khSoftGlow 3.2s ease-in-out infinite alternate;
        }

        .kh-ribbon-track,
        .kh-orbit,
        .kh-confetti,
        .kh-boy-card,
        .kh-main-card,
        .kh-floating-date,
        .kh-blessing-card,
        .kh-highlight-card::after,
        .child-card::before,
        .closing-card::before,
        .closing-card::after {
            animation: khLuxuryFloat 6.4s ease-in-out infinite;
        }

        .kh-confetti.two,
        .kh-floating-date {
            animation-delay: .22s;
        }

        .kh-confetti.three,
        .kh-blessing-card {
            animation-delay: .42s;
        }

        .kh-wrap {
            animation: khWrapGlow 8s ease-in-out infinite alternate;
        }

        .kh-wrap::before {
            animation: khPatternMove 22s linear infinite;
        }

        .kh-btn,
        button.kh-btn,
        .copy-gift-btn {
            position: relative;
            overflow: hidden;
        }

        .kh-btn::after,
        button.kh-btn::after,
        .copy-gift-btn::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -85%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.62), transparent);
            animation: khButtonShine 3.4s ease-in-out infinite;
            pointer-events: none;
        }

        .countdown-number,
        .kh-highlight-number,
        .child-placeholder,
        .kh-badge-mark,
        .gift-number {
            animation: khSoftPulse 3s ease-in-out infinite;
        }

        @media (hover: hover) {
            .kh-host-ticket:hover,
            .kh-mini-stat:hover,
            .kh-boy-card:hover,
            .kh-main-card:hover,
            .kh-floating-date:hover,
            .kh-blessing-card:hover,
            .kh-highlight-card:hover,
            .child-card:hover,
            .kh-card:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-card:hover,
            .gift-card:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--kh-primary) 34%, transparent) !important;
                box-shadow:
                    0 34px 86px color-mix(in srgb, var(--kh-primary) 14%, transparent),
                    0 0 46px color-mix(in srgb, var(--kh-accent) 30%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.82) !important;
            }

            .gallery-card:hover img,
            .child-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.08) contrast(1.04);
            }
        }

        .gallery-card img,
        .child-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        @keyframes khLuxuryFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-9px) scale(1.025); }
        }

        @keyframes khWrapGlow {
            from { box-shadow: 0 34px 90px rgba(15,23,42,.08); }
            to {
                box-shadow:
                    0 42px 118px rgba(15,23,42,.11),
                    0 0 60px color-mix(in srgb, var(--kh-accent) 30%, transparent);
            }
        }

        @keyframes khPatternMove {
            from { background-position: 0 0; }
            to { background-position: 126px 126px; }
        }

        @keyframes khButtonShine {
            0%, 48% { left: -85%; }
            75%, 100% { left: 135%; }
        }

        @keyframes khSoftPulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-3px) scale(1.035); }
        }

        @keyframes khSoftGlow {
            from { filter: saturate(1); }
            to { filter: saturate(1.16) drop-shadow(0 0 14px color-mix(in srgb, var(--kh-primary) 20%, transparent)); }
        }

        @media (prefers-reduced-motion: reduce) {
            .kh-reveal,
            .kh-kicker,
            .kh-label,
            .kh-card-badge,
            .message-badge,
            .kh-ribbon-track,
            .kh-orbit,
            .kh-confetti,
            .kh-boy-card,
            .kh-main-card,
            .kh-floating-date,
            .kh-blessing-card,
            .kh-wrap,
            .kh-wrap::before,
            .kh-btn::after,
            button.kh-btn::after,
            .copy-gift-btn::after,
            .countdown-number,
            .kh-highlight-number,
            .child-placeholder,
            .kh-badge-mark,
            .gift-number {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }
    </style>
</head>

@php
    $themeColor = $invitation->theme_color ?: 'emerald';

    $themes = [
        'maroon' => ['primary'=>'#e11d48','secondary'=>'#fb7185','accent'=>'#fde2e9','dark'=>'#4a1623','text'=>'#76505b','soft'=>'#fff7fa','glow1'=>'rgba(225, 29, 72, .12)','glow2'=>'rgba(251, 113, 133, .10)'],
        'emerald' => ['primary'=>'#10b981','secondary'=>'#34d399','accent'=>'#e4f8ee','dark'=>'#064e3b','text'=>'#58766b','soft'=>'#f7fffb','glow1'=>'rgba(16, 185, 129, .12)','glow2'=>'rgba(52, 211, 153, .10)'],
        'navy' => ['primary'=>'#2563eb','secondary'=>'#38bdf8','accent'=>'#e8f3ff','dark'=>'#172554','text'=>'#5b6b82','soft'=>'#f8fbff','glow1'=>'rgba(37, 99, 235, .11)','glow2'=>'rgba(56, 189, 248, .10)'],
        'rose' => ['primary'=>'#ec4899','secondary'=>'#f472b6','accent'=>'#fff0f7','dark'=>'#5b2140','text'=>'#765c69','soft'=>'#fffafd','glow1'=>'rgba(236, 72, 153, .12)','glow2'=>'rgba(244, 114, 182, .10)'],
        'gold' => ['primary'=>'#d97706','secondary'=>'#f59e0b','accent'=>'#fff4d7','dark'=>'#4a3511','text'=>'#75644e','soft'=>'#fffdf7','glow1'=>'rgba(217, 119, 6, .12)','glow2'=>'rgba(245, 158, 11, .10)'],
        'slate' => ['primary'=>'#475569','secondary'=>'#94a3b8','accent'=>'#f1f5f9','dark'=>'#1e293b','text'=>'#64748b','soft'=>'#ffffff','glow1'=>'rgba(71, 85, 105, .08)','glow2'=>'rgba(148, 163, 184, .08)'],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['emerald'];
    $firstPhoto = $invitation->photos->first();
    $children = $invitation->people ?? collect();
    $childCount = $children->count();
    $firstChild = $children->first();
    $eventTitle = $invitation->title ?: 'Khitan Ceria';
    $eventName = $invitation->event_name ?: 'Tasyakuran Khitanan';
    $hostName = $invitation->host_name ?: null;
    $shareUrl = route('invitation.public', $invitation->slug);
    $eventDateText = $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') : 'Tanggal belum diatur';
    if ($invitation->event_end_date) { $eventDateText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y'); }
    $eventTimeText = $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : null;
    if ($invitation->event_end_time) { $eventTimeText .= ' - ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i'); }
    $locationText = $invitation->location_name ?: null;
    $shareMessage = "Assalamu'alaikum Wr. Wb.\n\nDengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n*{$eventName}*\n*{$eventTitle}*\n\n";
    if ($hostName) { $shareMessage .= "Diselenggarakan oleh: {$hostName}\n"; }
    $shareMessage .= "Tanggal: {$eventDateText}\n";
    if ($eventTimeText) { $shareMessage .= "Waktu: {$eventTimeText}\n"; }
    if ($locationText) { $shareMessage .= "Tempat: {$locationText}\n"; }
    $shareMessage .= "\nSilakan buka undangan lengkap melalui link berikut:\n" . $shareUrl . "\n\nMerupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.\n\nWassalamu'alaikum Wr. Wb.";
    $shareText = urlencode($shareMessage);
    // Template Khitanan hanya mendukung acara offline.
    // Variabel ini dipertahankan agar kode lama tetap aman jika masih ada pengecekan lama.
    $eventMode = 'offline';
    $isOnlineEvent = false;
    $onlineUrl = '';
    $countdownTarget = null;
    if ($invitation->event_date) {
        $datePart = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
        $timePart = '00:00:00';
        if (!empty($invitation->event_time)) { try { $timePart = \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s'); } catch (\Exception $e) { $timePart = '00:00:00'; } }
        $countdownTarget = $datePart . 'T' . $timePart;
    }
    $googleCalendarUrl = null;
    if ($invitation->event_date) {
        try {
            $startDate = \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d');
            $startTime = !empty($invitation->event_time) ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s') : '00:00:00';
            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);
            $endDate = $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d') : $startDate;
            $endDateTime = !empty($invitation->event_end_time) ? \Carbon\Carbon::parse($endDate . ' ' . \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s')) : $startDateTime->copy()->addHours(3);
            if ($endDateTime->lessThanOrEqualTo($startDateTime)) { $endDateTime = $startDateTime->copy()->addHours(3); }
            $calendarTitle = trim(($invitation->event_name ?: 'Khitanan') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan khitanan') . "\n\nLink Undangan: " . $shareUrl);
            $calendarLocation = trim(($invitation->location_name ?: '') . ($invitation->address ? ' - ' . $invitation->address : ''));
            $googleCalendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE' . '&text=' . rawurlencode($calendarTitle) . '&dates=' . $startDateTime->format('Ymd\THis') . '/' . $endDateTime->format('Ymd\THis') . '&details=' . rawurlencode($calendarDetails) . '&location=' . rawurlencode($calendarLocation) . '&ctz=Asia/Jakarta';
        } catch (\Exception $e) { $googleCalendarUrl = null; }
    }
    $mapOpenUrl = isset($mapData) ? ($mapData['open_url'] ?? $invitation->maps_url) : $invitation->maps_url;
    $mapEmbedUrl = isset($mapData) ? ($mapData['embed_url'] ?? null) : null;
    $khitanHighlights = collect($invitation->event_highlights ?? [])->filter(fn($item) => !empty($item['title']) || !empty($item['description']))->take(12)->values();
    $highlightCount = $khitanHighlights->count();
    $highlightGridClass = match (true) { $highlightCount === 1 => 'count-1', $highlightCount === 2 => 'count-2', default => 'count-3' };
    $giftCount = $invitation->gifts->count();
@endphp

<body style="--kh-primary: {{ $activeTheme['primary'] }}; --kh-secondary: {{ $activeTheme['secondary'] }}; --kh-accent: {{ $activeTheme['accent'] }}; --kh-dark: {{ $activeTheme['dark'] }}; --kh-text: {{ $activeTheme['text'] }}; --kh-soft: {{ $activeTheme['soft'] }}; --kh-glow-1: {{ $activeTheme['glow1'] }}; --kh-glow-2: {{ $activeTheme['glow2'] }};">
    <main class="kh-shell">
        <div class="kh-wrap">
            <div class="floating-actions">
                <a href="https://wa.me/?text={{ $shareText }}" target="_blank" title="Bagikan"><img src="{{ asset('assets/icons/paperlane.png') }}" alt="Bagikan" class="floating-icon"></a>
                <button type="button" id="music-toggle" class="floating-action-button" title="Music"><img src="{{ asset('assets/icons/music-off.png') }}" data-icon-on="{{ asset('assets/icons/music-on.png') }}" data-icon-off="{{ asset('assets/icons/music-off.png') }}" alt="Music" class="floating-icon"></button>
                <button type="button" id="scroll-toggle" class="floating-action-button" title="Auto Scroll"><img src="{{ asset('assets/icons/scroll-off.png') }}" data-icon-on="{{ asset('assets/icons/scroll-on.png') }}" data-icon-off="{{ asset('assets/icons/scroll-off.png') }}" alt="Auto Scroll" class="floating-icon"></button>
                @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" title="Lokasi"><img src="{{ asset('assets/icons/map.png') }}" alt="Lokasi" class="floating-icon"></a>@endif
            </div>
            <audio id="invitation-music" src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background4.mp3') }}" preload="auto" loop></audio>
            <nav class="kh-nav"><a href="#children">Ananda</a><a href="#detail">Detail</a>@if ($giftCount)<a href="#gift">Amplop</a>@endif<a href="#message">Ucapan</a></nav>

            <section id="opening" class="kh-hero">
                <div class="kh-copy">
                    <div class="kh-kicker"><span>✦</span> Khitanan Ceria</div>
                    <h1 class="kh-hero-title responsive-text">{{ $invitation->title ?: 'Khitanan Ceria' }}<span class="line-accent">Penuh Bahagia</span></h1>
                    <p class="kh-desc responsive-text">{{ $invitation->description ?: 'Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara khitanan putra kami.' }}</p>
                    <div class="kh-host-ticket"><div class="kh-host-icon"><img src="{{ asset('assets/icons/family.png') }}" alt="Keluarga" class="w-8 h-8"></div><div><small>Diselenggarakan Oleh</small><strong class="responsive-text">{{ $invitation->host_name ?: 'Keluarga Besar' }}</strong></div></div>
                    <div class="kh-action-row"><a href="#detail" class="kh-btn">Lihat Detail</a><a href="#message" class="kh-btn secondary">Kirim Ucapan</a></div>
                    <div class="kh-mini-row"><div class="kh-mini-stat"><strong>{{ max($childCount, 1) }}</strong><span>Ananda</span></div><div class="kh-mini-stat"><strong>{{ $highlightCount }}</strong><span>Poin Acara</span></div><div class="kh-mini-stat"><strong>@if ($invitation->event_date){{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}@else--@endif</strong><span>Tanggal</span></div></div>
                </div>
                <div class="kh-visual"><div class="kh-stage">
                    <div class="kh-ribbon-track"></div><div class="kh-orbit"></div><div class="kh-confetti one"></div><div class="kh-confetti two"></div><div class="kh-confetti three"></div><div class="kh-confetti four"></div>
                    <div class="kh-boy-card"><div class="kh-boy-icon"><img src="{{ asset('assets/icons/sparkle.png') }}" alt="Bintang" class="w-8 h-8"></div><small>Ananda</small><strong class="responsive-text">{{ $firstChild?->name ?: 'Nama Anak' }}</strong></div>
                    <div class="kh-main-card">
                        @if ($invitation->cover_image)<img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover Khitanan" class="kh-cover-photo">@elseif ($firstPhoto)<img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto Khitanan" class="kh-cover-photo">@endif
                        <div class="kh-card-content"><div class="kh-card-top"><span class="kh-card-badge">{{ $invitation->event_name ?: 'Tasyakuran Khitanan' }}</span><div class="kh-card-dots"><span></span><span></span><span></span></div></div>
                            <div class="kh-card-body"><div class="kh-badge-mark"><span><img src="{{ asset('assets/icons/star.png') }}" alt="Bintang" class="w-12 h-12"></span></div><h2 class="responsive-text">{{ $invitation->seminar_about_title ?: 'Hari Bahagia untuk Jagoan Kecil' }}</h2><p class="responsive-text">{{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name . ' sebagai momen syukur, doa, dan kebahagiaan keluarga.' : 'Momen penuh rasa syukur, doa, dan kebahagiaan bersama keluarga serta sahabat terdekat.' }}</p></div>
                            <div class="kh-info-row"><div class="kh-info-pill"><small>Tanggal</small><strong class="responsive-text">@if ($invitation->event_date){{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}@else Belum diatur @endif</strong></div><div class="kh-info-pill"><small>Waktu</small><strong class="responsive-text">@if ($invitation->event_time){{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}@else Belum diatur @endif</strong></div><div class="kh-info-pill"><small>Lokasi</small><strong class="responsive-text">{{ $invitation->location_name ?: 'Kediaman Keluarga' }}</strong></div></div>
                        </div>
                    </div>
                </div></div>
            </section>

            <section id="about" class="kh-section compact text-center">
                <p class="kh-label">Tentang Khitanan</p>

                <h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">
                    {{ $invitation->seminar_about_title ?: 'Doa, Syukur, dan Kebahagiaan Keluarga' }}
                </h2>

                <p class="responsive-text desc text-slate-600 mt-4 max-w-3xl mx-auto leading-8">
                    {{ $invitation->host_name
                        ? 'Acara ini dipersembahkan oleh ' . $invitation->host_name . ' sebagai wujud syukur dan doa baik untuk ananda tercinta.'
                        : 'Acara khitanan ini menjadi momen untuk berkumpul, berbagi doa, dan merayakan hari bahagia ananda dengan penuh rasa syukur.' }}
                </p>

                @if ($highlightCount > 0)
                    <div class="kh-grid {{ $highlightGridClass }} text-left">
                        @foreach ($khitanHighlights as $index => $highlight)
                            <div class="kh-highlight-card">
                                <div class="kh-highlight-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <h3 class="responsive-text">
                                    {{ $highlight['title'] ?: 'Momen Khitanan' }}
                                </h3>

                                <p class="responsive-text">
                                    {{ $highlight['description'] ?: 'Deskripsi momen khitanan akan tampil di sini.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section id="children" class="kh-section compact text-center"><p class="kh-label">Ananda</p><h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">Yang Berbahagia</h2><p class="responsive-text text-slate-600 mt-4 max-w-2xl mx-auto leading-7">Data ananda akan tampil di bagian ini sesuai isian pada editor.</p><div class="child-grid {{ $childCount <= 1 ? 'single-child' : '' }}">@forelse ($children as $person)<div class="child-card">@if ($person->photo)<img src="{{ asset('storage/' . $person->photo) }}" class="child-photo" alt="{{ $person->name }}">@else<div class="child-placeholder">{{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'A', 0, 1)) }}</div>@endif<span class="child-role">{{ $person->subtitle ?: 'Ananda' }}</span><h3 class="responsive-text">{{ $person->name ?: 'Nama Anak' }}</h3>@if (!empty($person->description))<p class="responsive-text">{{ $person->description }}</p>@elseif (!empty($person->family_name))<p class="responsive-text">{{ $person->family_name }}</p>@endif</div>@empty<div class="child-card"><div class="child-placeholder">A</div><span class="child-role">Ananda</span><h3>Nama Anak</h3><p>Data ananda belum ditambahkan.</p></div>@endforelse</div></section>

            <section id="detail" class="kh-section compact"><div class="section-head"><p class="kh-label">Detail Acara</p><h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">Informasi Kehadiran</h2><p class="responsive-text desc">Simpan jadwalnya, lihat lokasinya, dan jangan sampai terlewat momen bahagia ini.</p></div><div class="focus-layout"><div class="kh-card"><h3>Detail Khitanan</h3><div class="detail-list"><div class="detail-row"><div class="label">Acara</div><div class="value responsive-text">{{ $invitation->event_name ?: 'Tasyakuran Khitanan' }}</div></div><div class="detail-row"><div class="label">Tanggal</div><div class="value kh-date-line">@if ($invitation->event_date)<span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>@if ($invitation->event_end_date)<span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>@endif @else <span>Belum diatur</span> @endif</div></div><div class="detail-row"><div class="label">Waktu</div><div class="value kh-time-line">@if ($invitation->event_time)<span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>@if ($invitation->event_end_time)<span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>@endif @else <span>Belum diatur</span> @endif</div></div><div class="detail-row"><div class="label">Lokasi</div><div class="value responsive-text">{{ $invitation->location_name ?: 'Kediaman Keluarga' }}</div></div><div class="detail-row"><div class="label">Alamat</div><div class="value responsive-text">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan' }}</div></div></div><div class="mt-7 flex flex-wrap gap-3">@if ($googleCalendarUrl)<a href="{{ $googleCalendarUrl }}" target="_blank" class="kh-btn">📅 Atur Pengingat</a>@endif @if ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="kh-btn secondary">📍 Buka Maps</a>@endif</div></div><div><div class="kh-card"><p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">@if ($countdownTarget) Hitung mundur menuju acara @else Tanggal acara belum diatur @endif</p><h3 class="mt-3">Countdown Acara</h3><p class="responsive-text text-slate-600 mt-3 leading-7">Siapkan waktu terbaik untuk hadir dan memberikan doa untuk ananda.</p><div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif><div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div><div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div><div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div><div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div></div></div>@if ($invitation->address || $mapOpenUrl || $mapEmbedUrl)<div class="map-card">@if ($mapEmbedUrl)<iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>@elseif ($mapOpenUrl)<a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder"><div><p class="text-5xl">📍</p><p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p><p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p><p class="responsive-text mt-4 font-bold" style="color: var(--kh-primary);">Buka Google Maps →</p></div></a>@else<div class="map-placeholder"><div><p class="text-5xl">📍</p><p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Acara' }}</p><p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Alamat lengkap belum ditambahkan.' }}</p></div></div>@endif</div>@endif</div></div></section>

            @if ($invitation->photos->count())<section id="gallery" class="kh-section compact text-center"><p class="kh-label">Galeri</p><h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">Momen Bahagia</h2><div class="gallery-grid">@foreach ($invitation->photos->chunk(2) as $chunk)<div class="gallery-column">@foreach ($chunk as $photo)<div class="gallery-card {{ $loop->first ? 'tall' : 'short' }}"><img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Khitanan"></div>@endforeach</div>@endforeach</div></section>@endif

            @if ($giftCount)<section id="gift" class="kh-section compact text-center"><p class="kh-label">Amplop Digital</p><h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">Kirim Tanda Kasih</h2><p class="responsive-text text-slate-600 mt-4 max-w-2xl mx-auto leading-8">Jika berkenan, Anda dapat mengirimkan tanda kasih melalui informasi di bawah ini.</p><div class="gift-grid {{ $giftCount === 1 ? 'gift-count-1' : '' }} text-left">@foreach ($invitation->gifts as $gift)@php $giftLabel = $gift->label ?? ($gift->bank_name ?? ($gift->ewallet_name ?? 'Amplop Digital')); $accountName = $gift->account_name ?? null; $accountNumber = $gift->account_number ?? ($gift->ewallet_number ?? null); @endphp<div class="gift-card"><h3 class="responsive-text">{{ $giftLabel ?: 'Amplop Digital' }}</h3><p class="responsive-text text-slate-600 mt-2 leading-7">{{ $accountName ?: 'Atas nama penerima' }}</p><div class="gift-copy-box"><div><small>Nomor</small><strong class="gift-number responsive-text">{{ $accountNumber ?: '-' }}</strong></div>@if ($accountNumber)<button type="button" class="copy-gift-btn" data-copy="{{ $accountNumber }}">Salin</button>@endif</div></div>@endforeach</div></section>@endif

            <section id="message" class="kh-section compact"><div class="section-head"><p class="kh-label">RSVP & Ucapan</p><h2 class="responsive-text kh-title text-5xl md:text-6xl mt-6">Konfirmasi Kehadiran</h2><p class="responsive-text desc">Silakan isi form untuk konfirmasi kehadiran dan kirim ucapan terbaik.</p></div><div class="rsvp-wrap mt-8">@if (session('message_success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('message_success') }}</div>@endif @if ($errors->any())<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5"><p class="font-bold">Mohon periksa kembali isian:</p><ul class="list-disc ml-5 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif<form method="POST" action="{{ route('guest-messages.store', $invitation) }}" class="form-card space-y-4">@csrf<div><label class="uk-label">Nama Tamu</label><input type="text" name="guest_name" value="{{ old('guest_name') }}" class="uk-input mt-1" placeholder="Nama lengkap" required></div><div><label class="uk-label">Konfirmasi Kehadiran</label><select name="attendance_status" class="uk-input mt-1"><option value="">Pilih status kehadiran</option><option value="hadir">Saya berencana hadir</option><option value="tidak_hadir">Tidak bisa hadir</option><option value="ragu">Masih ragu</option></select></div><div><label class="uk-label">Jumlah Tamu</label><input type="number" name="guest_count" value="{{ old('guest_count', 1) }}" min="1" max="10" class="uk-input mt-1"></div><div><label class="uk-label">Ucapan / Pesan</label><textarea name="message" rows="4" class="uk-input mt-1" placeholder="Tulis ucapan atau pesan..." required>{{ old('message') }}</textarea></div><button type="submit" class="w-full kh-btn">Kirim Konfirmasi</button></form><div class="summary-grid"><div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong><span>Tidak hadir</span></div><div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong><span>Hadir</span></div><div class="summary-card"><strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong><span>Ragu</span></div></div><div class="message-list">@forelse ($invitation->messages as $message)<div class="message-card"><div class="message-head"><div class="message-info"><p class="responsive-text font-black text-slate-950">{{ $message->guest_name }}</p><p class="text-xs text-slate-500 mt-1">{{ $message->created_at->format('d M Y, H:i') }}</p></div>@if ($message->attendance_status)<span class="message-badge">{{ str_replace('_', ' ', $message->attendance_status) }}</span>@endif</div><p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p></div>@empty<div class="message-card text-center"><p class="text-slate-500">Belum ada konfirmasi.</p></div>@endforelse</div></div></section>

            <section id="closing" class="kh-section text-center"><div class="closing-card"><p class="kh-label">Terima Kasih</p><h2 class="responsive-text kh-title kh-gradient-text text-5xl md:text-7xl mt-8">Sampai Jumpa</h2><p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">Terima kasih atas doa, perhatian, dan kehadiran Anda. Semoga acara khitanan ini menjadi momen penuh kebahagiaan dan keberkahan bagi keluarga kami.</p><h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">{{ $invitation->title ?: 'Khitan Ceria' }}</h3></div></section>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');
            if (countdownContainer) {
                const targetDate = new Date(countdownContainer.getAttribute('data-countdown-target'));
                const daysEl = document.getElementById('countdown-days'), hoursEl = document.getElementById('countdown-hours'), minutesEl = document.getElementById('countdown-minutes'), secondsEl = document.getElementById('countdown-seconds'), noteEl = document.getElementById('countdown-note');
                function pad(n){ return String(n).padStart(2,'0'); }
                function updateCountdown(){ if (isNaN(targetDate.getTime())) { if(noteEl) noteEl.textContent='Format tanggal atau waktu acara belum valid.'; return; } const now = new Date(); let distance = targetDate.getTime() - now.getTime(); if(distance < 0) distance = 0; const total = Math.floor(distance/1000); const days = Math.floor(total/(60*60*24)); const hours = Math.floor((total%(60*60*24))/(60*60)); const minutes = Math.floor((total%(60*60))/60); const seconds = Math.floor(total%60); if(daysEl) daysEl.textContent=pad(days); if(hoursEl) hoursEl.textContent=pad(hours); if(minutesEl) minutesEl.textContent=pad(minutes); if(secondsEl) secondsEl.textContent=pad(seconds); if(noteEl) noteEl.textContent = distance > 0 ? 'Hitung mundur menuju acara' : 'Acara sedang berlangsung atau telah dimulai'; }
                updateCountdown(); setInterval(updateCountdown, 1000);
            }
            const musicToggle = document.getElementById('music-toggle'); const musicAudio = document.getElementById('invitation-music');
            if (musicToggle && musicAudio) { const icon = musicToggle.querySelector('img'); musicToggle.addEventListener('click', async function(){ try { if(musicAudio.paused){ await musicAudio.play(); musicToggle.classList.add('is-active'); if(icon) icon.src = icon.dataset.iconOn; } else { musicAudio.pause(); musicToggle.classList.remove('is-active'); if(icon) icon.src = icon.dataset.iconOff; } } catch(e){ console.log('Audio tidak bisa diputar:', e); } }); }
            const scrollToggle = document.getElementById('scroll-toggle'); let autoScrollActive = false; let autoScrollFrame = null; const scrollSpeed = 1.15;
            function getScroller(){ return document.scrollingElement || document.documentElement || document.body; }
            function updateScrollButton(active){ if(!scrollToggle) return; const icon = scrollToggle.querySelector('img'); if(active){ scrollToggle.classList.add('is-active'); if(icon && icon.dataset.iconOn) icon.src=icon.dataset.iconOn; } else { scrollToggle.classList.remove('is-active'); if(icon && icon.dataset.iconOff) icon.src=icon.dataset.iconOff; if(autoScrollFrame){ cancelAnimationFrame(autoScrollFrame); autoScrollFrame = null; } } }
            function autoScrollStep(){ if(!autoScrollActive) return; const scroller = getScroller(); const maxScroll = scroller.scrollHeight - window.innerHeight; const current = scroller.scrollTop; if(current >= maxScroll - 2){ autoScrollActive=false; updateScrollButton(false); return; } scroller.scrollTop = current + scrollSpeed; autoScrollFrame = requestAnimationFrame(autoScrollStep); }
            if(scrollToggle){ scrollToggle.addEventListener('click', function(){ autoScrollActive = !autoScrollActive; updateScrollButton(autoScrollActive); if(autoScrollActive) autoScrollStep(); }); }
            window.addEventListener('wheel', function(){ if(autoScrollActive){ autoScrollActive=false; updateScrollButton(false); } }, {passive:true});
            window.addEventListener('touchstart', function(){ if(autoScrollActive){ autoScrollActive=false; updateScrollButton(false); } }, {passive:true});
            document.querySelectorAll('[data-copy]').forEach(function(button){ button.addEventListener('click', async function(){ const text = this.getAttribute('data-copy'); try { await navigator.clipboard.writeText(text); const original = this.textContent; this.textContent = 'Berhasil Disalin'; this.classList.add('copied'); setTimeout(() => { this.textContent = original; this.classList.remove('copied'); }, 1800); } catch(e){ alert('Gagal menyalin teks.'); } }); });


            /* Scroll animation mewah */
            const revealTargets = [
                '.kh-nav', '.kh-kicker', '.kh-hero-title', '.kh-desc', '.kh-host-ticket', '.kh-action-row', '.kh-mini-stat',
                '.kh-ribbon-track', '.kh-orbit', '.kh-confetti', '.kh-boy-card', '.kh-main-card', '.kh-floating-date', '.kh-blessing-card',
                '.kh-label', '.kh-title', '.section-head .desc', '.kh-highlight-card', '.child-card', '.kh-card', '.detail-row',
                '.countdown-card', '.map-card', '.gallery-card', '.gift-card', '.form-card', '.summary-card', '.message-card', '.closing-card'
            ];

            const revealElements = document.querySelectorAll(revealTargets.join(','));
            revealElements.forEach(function (el, index) {
                el.classList.add('kh-reveal');
                el.style.setProperty('--kh-delay', Math.min(index % 8, 7) * 70 + 'ms');
            });

            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('kh-show');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });

                revealElements.forEach(function (el) { revealObserver.observe(el); });
            } else {
                revealElements.forEach(function (el) { el.classList.add('kh-show'); });
            }

            /* Anti inspect ringan tanpa notice/alert. Ini hanya deterrent frontend, bukan proteksi source code penuh. */
            document.addEventListener('contextmenu', function (e) { e.preventDefault(); }, { capture: true });
            document.addEventListener('keydown', function (e) {
                const key = (e.key || '').toLowerCase();
                const blocked =
                    key === 'f12' ||
                    ((e.ctrlKey || e.metaKey) && e.shiftKey && ['i', 'j', 'c'].includes(key)) ||
                    ((e.ctrlKey || e.metaKey) && ['u', 's'].includes(key));

                if (blocked) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }, { capture: true });
        });
    </script>
</body>
</html>
