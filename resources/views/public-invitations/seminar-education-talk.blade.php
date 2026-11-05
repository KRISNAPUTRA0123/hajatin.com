<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $browserTitle = trim(($invitation->event_name ?: 'Seminar') . ' ' . ($invitation->title ?: 'Education Talk'));
    @endphp

    <title>{{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::title($browserTitle), 55, '...') }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: #23324a;
            background:
                radial-gradient(circle at top left, rgba(255, 203, 107, .22), transparent 30%),
                radial-gradient(circle at top right, rgba(115, 180, 255, .18), transparent 30%),
                linear-gradient(180deg, #fffdf6 0%, #f7fbff 48%, #ffffff 100%);
        }

        .edu-shell {
            width: min(100%, 1220px);
            margin: 0 auto;
            padding: 24px;
        }

        .edu-wrap {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            border-radius: 42px;
            background:
                radial-gradient(circle at 10% 10%, rgba(255, 214, 120, .14), transparent 22%),
                radial-gradient(circle at 88% 10%, rgba(135, 206, 250, .14), transparent 24%),
                linear-gradient(180deg, rgba(255,255,255,.97), rgba(248,251,255,.98));
            border: 1px solid rgba(35, 50, 74, .08);
            box-shadow: 0 30px 90px rgba(35, 50, 74, .10);
        }

        .edu-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(35, 50, 74, .06) 1.4px, transparent 1.4px);
            background-size: 24px 24px;
            opacity: .45;
            pointer-events: none;
            z-index: 0;
        }

        .edu-date-line,
        .edu-time-line {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
            width: 100%;
            white-space: normal !important;
            line-height: 1.5;
        }

        .edu-date-line span,
        .edu-time-line span {
            display: inline;
        }

        .planner-item .edu-date-line,
        .planner-item .edu-time-line {
            justify-content: flex-start;
            text-align: left;
        }

        .edu-wrap > * {
            position: relative;
            z-index: 1;
        }

        .edu-section {
            min-height: 100vh;
            padding: 92px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .edu-section.compact {
            min-height: auto;
            padding-top: 82px;
            padding-bottom: 82px;
        }

        .responsive-text {
            display: block;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: break-word;
            word-wrap: break-word;
            white-space: pre-line;
        }

        .edu-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 950;
            letter-spacing: .24em;
            text-transform: uppercase;
            color: var(--edu-primary);
        }

        .edu-label::before {
            content: "";
            width: 34px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--edu-primary), var(--edu-accent));
            display: inline-block;
        }

        .edu-title {
            color: #20304c;
            line-height: .95;
            letter-spacing: -.06em;
            font-weight: 950;
        }

        .edu-gradient {
            background: linear-gradient(135deg, #20304c, var(--edu-primary), var(--edu-secondary));
            -webkit-background-clip: text;
            color: transparent;
        }

        .edu-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .edu-pill {
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(35, 50, 74, .08);
            box-shadow: 0 10px 24px rgba(35, 50, 74, .06);
            color: #4a5b77;
            font-size: 12px;
            font-weight: 900;
        }

        .edu-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 26px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 900;
            color: white;
            background: linear-gradient(135deg, var(--edu-primary), var(--edu-secondary));
            box-shadow: 0 16px 36px rgba(102, 126, 234, .25);
        }

        .edu-btn.secondary {
            background: #ffffff;
            color: #23324a;
            border: 1px solid rgba(35, 50, 74, .10);
            box-shadow: 0 12px 26px rgba(35, 50, 74, .08);
        }

        .edu-nav {
            position: sticky;
            top: 18px;
            z-index: 30;
            margin: 18px auto 0;
            width: fit-content;
            max-width: calc(100% - 24px);
            display: flex;
            gap: 6px;
            padding: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.86);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(35, 50, 74, .08);
            box-shadow: 0 12px 30px rgba(35, 50, 74, .08);
            overflow-x: auto;
        }

        .edu-nav a {
            text-decoration: none;
            color: #4d607d;
            font-size: 12px;
            font-weight: 900;
            padding: 10px 14px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .edu-nav a:hover {
            background: rgba(102, 126, 234, .08);
            color: var(--edu-primary);
        }

        .floating-actions {
            position: fixed;
            right: 22px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-actions a,
        .floating-action-button {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 14px 30px rgba(35,50,74,.16);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .floating-action-button.is-active {
            background: rgba(255, 214, 120, .45);
        }

        .floating-icon {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.03fr .97fr;
            gap: 48px;
            align-items: center;
        }

        .hero-copy {
            max-width: 680px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 38px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid rgba(35, 50, 74, .08);
            box-shadow: 0 14px 34px rgba(35,50,74,.08);
            border-radius: 28px;
            padding: 22px;
            text-align: center;
        }

        .stat-value {
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            color: #20304c;
        }

        .stat-text {
            margin-top: 10px;
            font-size: 11px;
            letter-spacing: .16em;
            font-weight: 900;
            text-transform: uppercase;
            color: #7d8ba3;
        }

        .hero-board {
            position: relative;
            min-height: 560px;
            border-radius: 36px;
            padding: 18px;
            background: linear-gradient(135deg, rgba(255,214,120,.55), rgba(140,208,255,.45));
            box-shadow: 0 28px 70px rgba(35,50,74,.16);
        }

        .hero-board-inner {
            position: relative;
            min-height: 524px;
            border-radius: 28px;
            padding: 30px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(250,252,255,.98));
            border: 2px dashed rgba(35, 50, 74, .10);
        }

        .hero-board-inner img.cover-photo {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .18;
        }

        .board-sticker {
            position: absolute;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 12px;
            font-weight: 900;
            color: #20304c;
            background: #ffffff;
            box-shadow: 0 12px 26px rgba(35,50,74,.08);
        }

        .sticker-one {
            top: 18px;
            right: 18px;
            transform: rotate(8deg);
        }

        .sticker-two {
            left: 18px;
            bottom: 18px;
            transform: rotate(-7deg);
            background: #fff4c9;
        }

        .board-main {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }

        .board-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .board-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            font-size: 12px;
            font-weight: 900;
            color: var(--edu-primary);
        }

        .board-dots {
            display: flex;
            gap: 7px;
        }

        .board-dots span {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(35,50,74,.22);
        }

        .board-body h2 {
            margin: 18px 0 0;
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            line-height: .95;
            letter-spacing: -.06em;
            color: #20304c;
            font-weight: 950;
        }

        .board-body p {
            margin-top: 16px;
            color: #566a88;
            line-height: 1.8;
        }

        .board-mini-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 28px;
        }

        .board-mini {
            padding: 16px;
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 12px 24px rgba(35,50,74,.06);
        }

        .board-mini small {
            display: block;
            color: #8a97ab;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-size: 10px;
        }

        .board-mini strong {
            display: block;
            margin-top: 7px;
            color: #20304c;
            font-size: 15px;
            line-height: 1.5;
        }

        .note-grid {
            display: grid;
            gap: 20px;
            margin-top: 36px;
            justify-content: center;
        }

        .note-grid.note-count-1 {
            grid-template-columns: minmax(280px, 360px);
        }

        .note-grid.note-count-2 {
            grid-template-columns: repeat(2, minmax(280px, 360px));
        }

        .note-grid.note-count-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .note-card {
            padding: 24px;
            border-radius: 30px;
            background: #ffffff;
            box-shadow: 0 18px 40px rgba(35,50,74,.08);
            border: 1px solid rgba(35,50,74,.08);
            position: relative;
        }

        .note-card:nth-child(2) {
            background: #fff7da;
        }

        .note-card:nth-child(3) {
            background: #eef8ff;
        }

        .note-pin {
            width: 42px;
            height: 42px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--edu-primary), var(--edu-accent));
            color: white;
            font-weight: 950;
            box-shadow: 0 12px 24px rgba(102,126,234,.18);
        }

        .note-card h3 {
            color: #20304c;
            margin-top: 18px;
            font-size: 1.25rem;
            font-weight: 900;
        }

        .note-card p {
            color: #566a88;
            margin-top: 10px;
            line-height: 1.8;
        }

        .speaker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 340px));
            justify-content: center;
            gap: 20px;
            margin-top: 36px;
        }

        .speaker-grid.single-speaker {
            grid-template-columns: minmax(0, 380px);
            justify-content: center;
        }

        .speaker-card {
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 18px 42px rgba(35,50,74,.08);
            border-radius: 32px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .speaker-card::before {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -50px;
            border-radius: 999px;
            background: rgba(255, 214, 120, .22);
        }

        .speaker-photo,
        .speaker-placeholder {
            width: 122px;
            height: 122px;
            border-radius: 28px;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff, #f2f8ff);
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 12px 28px rgba(35,50,74,.08);
            font-size: 40px;
            font-weight: 950;
            color: var(--edu-primary);
        }

        .speaker-role {
            display: inline-block;
            margin-top: 18px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(102,126,234,.08);
            color: var(--edu-primary);
            font-size: 12px;
            font-weight: 900;
        }

        .speaker-card h3 {
            margin-top: 16px;
            color: #20304c;
            font-size: 1.7rem;
            font-weight: 900;
        }

        .speaker-card p {
            color: #566a88;
            margin-top: 8px;
            line-height: 1.7;
        }

        .planner-layout {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            gap: 22px;
            margin-top: 40px;
            align-items: start;
        }

        .planner-card {
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 20px 46px rgba(35,50,74,.08);
            border-radius: 34px;
            padding: 28px;
        }

        .planner-card h3 {
            color: #20304c;
            font-size: 2rem;
            font-weight: 900;
            margin: 0;
        }

        .planner-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .planner-item {
            background: #f8fbff;
            border: 1px solid rgba(35,50,74,.06);
            border-radius: 24px;
            padding: 18px;
        }

        .planner-item small {
            display: block;
            color: #7b8ca7;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-size: 10px;
            font-weight: 900;
        }

        .planner-item strong {
            display: block;
            margin-top: 10px;
            color: #20304c;
            font-size: 18px;
            line-height: 1.6;
            font-weight: 900;
        }

        .planner-item.full {
            grid-column: span 2;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .countdown-card {
            background: linear-gradient(180deg, #fffdfa, #f7fbff);
            border: 1px solid rgba(35,50,74,.08);
            border-radius: 24px;
            text-align: center;
            padding: 20px 12px;
            box-shadow: 0 10px 26px rgba(35,50,74,.06);
        }

        .countdown-number {
            display: block;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            color: #20304c;
        }

        .countdown-label {
            display: block;
            margin-top: 10px;
            color: #8a98ad;
            font-size: 11px;
            letter-spacing: .16em;
            font-weight: 900;
            text-transform: uppercase;
        }

        .map-card {
            margin-top: 20px;
            overflow: hidden;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 16px 38px rgba(35,50,74,.08);
        }

        .map-frame,
        .map-placeholder {
            width: 100%;
            height: 300px;
            border: 0;
            display: block;
        }

        .map-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px;
            background: linear-gradient(180deg, #fffef8, #f6fbff);
            color: #20304c;
            text-decoration: none;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 34px;
        }

        .gallery-item {
            background: #ffffff;
            border-radius: 26px;
            padding: 10px;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 16px 36px rgba(35,50,74,.08);
            transform: rotate(0deg);
        }

        .gallery-item:nth-child(2) {
            transform: rotate(-2deg);
        }

        .gallery-item:nth-child(3) {
            transform: rotate(2deg);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            border-radius: 20px;
        }

        .rsvp-wrap {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        .form-card,
        .message-card,
        .summary-card {
            background: #ffffff;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 16px 34px rgba(35,50,74,.08);
            border-radius: 30px;
        }

        .form-card {
            padding: 28px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .summary-card {
            text-align: center;
            padding: 20px;
        }

        .summary-card strong {
            display: block;
            color: #20304c;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .summary-card span {
            display: block;
            margin-top: 8px;
            color: #7c8ca5;
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
            padding: 22px;
        }

        .message-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .message-info {
            min-width: 0;
            flex: 1;
        }

        .message-badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(102,126,234,.08);
            color: var(--edu-primary);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .closing-card {
            max-width: 780px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(255,214,120,.28), rgba(135,206,250,.22));
            border: 1px solid rgba(35,50,74,.08);
            border-radius: 36px;
            padding: 40px 34px;
            box-shadow: 0 20px 44px rgba(35,50,74,.08);
        }

        @media (max-width: 980px) {
            .edu-shell {
                padding: 16px;
            }

            .edu-section {
                padding: 82px 38px;
            }

            .hero-grid,
            .speaker-grid,
            .planner-layout,
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .note-grid.note-count-3 {
                grid-template-columns: repeat(2, minmax(280px, 360px));
            }

            .hero-board {
                min-height: auto;
            }

            .hero-board-inner {
                min-height: 500px;
            }

            .stats-grid,
            .planner-grid,
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .edu-shell {
                padding: 0;
            }

            .edu-wrap {
                border-radius: 0;
                box-shadow: none;
            }

            .edu-section {
                padding: 74px 24px;
            }

            .edu-section.compact {
                padding-top: 68px;
                padding-bottom: 68px;
            }

            .edu-title {
                font-size: 3rem;
                line-height: 1.03;
            }

            .hero-copy {
                text-align: center;
            }

            .edu-pill-row,
            .hero-copy .flex {
                justify-content: center;
            }

            .note-grid,
            .note-grid.note-count-1,
            .note-grid.note-count-2,
            .note-grid.note-count-3 {
                grid-template-columns: 1fr;
            }

            .stats-grid,
            .board-mini-grid,
            .planner-grid,
            .countdown-grid,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .planner-item.full {
                grid-column: span 1;
            }

            .hero-board-inner {
                min-height: 430px;
                padding: 24px;
            }

            .floating-actions {
                right: 10px;
            }
        }


        /* =====================================================
           EDUCATION TALK V2 - LAB / CAMPUS BOARD REDESIGN
           Tambahan ini menimpa desain lama tanpa menambah field.
        ===================================================== */
        :root { --edu-ink-soft: rgba(35, 50, 74, .08); }

        .edu-wrap::before {
            background-image:
                linear-gradient(to right, rgba(35, 50, 74, .055) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(35, 50, 74, .055) 1px, transparent 1px);
            background-size: 34px 34px;
        }

        .edu-hero-lab {
            min-height: 100vh;
            padding: 86px 64px 96px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 34px;
            align-items: center;
        }

        .lab-copy { position: relative; padding: 38px 0; }
        .lab-copy::before {
            content: ""; position: absolute; left: -42px; top: 8px; width: 170px; height: 170px;
            border-radius: 42px; transform: rotate(-10deg);
            background: color-mix(in srgb, var(--edu-accent) 24%, transparent); z-index: -1;
        }

        .lab-kicker {
            display: inline-flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 999px;
            background: rgba(255,255,255,.9); border: 1px solid rgba(35, 50, 74, .08);
            box-shadow: 0 12px 26px rgba(35,50,74,.06); color: var(--edu-primary);
            font-size: 12px; font-weight: 950; letter-spacing: .18em; text-transform: uppercase;
        }
        .lab-kicker::before {
            content: "✦"; width: 28px; height: 28px; border-radius: 999px; display: inline-flex;
            align-items: center; justify-content: center; color: white; letter-spacing: 0;
            background: linear-gradient(135deg, var(--edu-primary), var(--edu-secondary));
        }

        .lab-title {
            margin-top: 28px; max-width: 760px; color: #20304c;
            font-size: clamp(3.4rem, 7.4vw, 7rem); line-height: .88; letter-spacing: -.085em; font-weight: 950;
        }
        .lab-desc { max-width: 650px; margin-top: 28px; color: #53667f; font-size: 1.05rem; line-height: 1.9; }
        .lab-chip-row { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 28px; }
        .lab-chip {
            display: inline-flex; align-items: center; gap: 8px; padding: 11px 15px; border-radius: 999px;
            background: white; border: 1px solid rgba(35,50,74,.08); box-shadow: 0 10px 22px rgba(35,50,74,.06);
            color: #4d607d; font-size: 12px; font-weight: 900;
        }
        .lab-action-row { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 34px; }
        .lab-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 38px; max-width: 680px; }
        .lab-stat { position: relative; overflow: hidden; padding: 22px; border-radius: 30px; background: rgba(255,255,255,.92); border: 1px solid rgba(35,50,74,.08); box-shadow: 0 14px 34px rgba(35,50,74,.08); }
        .lab-stat::after { content: ""; position: absolute; width: 88px; height: 88px; right: -36px; top: -36px; border-radius: 999px; background: color-mix(in srgb, var(--edu-accent) 26%, transparent); }
        .lab-stat strong { position: relative; z-index: 2; display: block; color: #20304c; font-size: 34px; line-height: 1; font-weight: 950; }
        .lab-stat span { position: relative; z-index: 2; display: block; margin-top: 10px; color: #7d8ba3; font-size: 11px; letter-spacing: .16em; text-transform: uppercase; font-weight: 900; }

        .lab-visual { position: relative; min-height: 650px; }
        .learning-orbit { position: absolute; inset: 32px 18px 18px 54px; border-radius: 60px; background: linear-gradient(135deg, color-mix(in srgb, var(--edu-primary) 20%, white), color-mix(in srgb, var(--edu-accent) 30%, white)); box-shadow: 0 30px 76px rgba(35,50,74,.16); padding: 18px; transform: rotate(2deg); }
        .learning-frame { position: relative; min-height: 582px; overflow: hidden; border-radius: 46px; border: 2px dashed rgba(35,50,74,.11); background: radial-gradient(circle at 20% 18%, color-mix(in srgb, var(--edu-accent) 26%, transparent), transparent 34%), radial-gradient(circle at 80% 80%, color-mix(in srgb, var(--edu-secondary) 16%, transparent), transparent 30%), linear-gradient(180deg, #ffffff, #f8fbff); transform: rotate(-2deg); }
        .learning-frame img.cover-photo { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: .22; }
        .learning-frame-content { position: relative; z-index: 2; min-height: 582px; padding: 34px; display: flex; flex-direction: column; justify-content: space-between; }
        .lab-window-top { display: flex; justify-content: space-between; gap: 12px; align-items: center; }
        .lab-badge { display: inline-flex; align-items: center; gap: 9px; padding: 11px 15px; border-radius: 999px; background: #ffffff; border: 1px solid rgba(35,50,74,.08); color: var(--edu-primary); font-size: 12px; font-weight: 950; box-shadow: 0 12px 26px rgba(35,50,74,.06); }
        .lab-window-dots { display: flex; gap: 7px; }
        .lab-window-dots span { width: 11px; height: 11px; border-radius: 999px; background: rgba(35,50,74,.20); }
        .lab-window-dots span:nth-child(1) { background: var(--edu-primary); }
        .lab-window-dots span:nth-child(2) { background: var(--edu-accent); }
        .lab-window-dots span:nth-child(3) { background: var(--edu-secondary); }
        .learning-main h2 { color: #20304c; font-size: clamp(2.3rem, 5vw, 4.6rem); line-height: .92; letter-spacing: -.065em; font-weight: 950; }
        .learning-main p { max-width: 480px; margin-top: 18px; color: #53667f; line-height: 1.85; }
        .learning-mini-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-top: 24px; }
        .learning-mini { padding: 16px; border-radius: 24px; background: rgba(255,255,255,.88); border: 1px solid rgba(35,50,74,.08); box-shadow: 0 12px 24px rgba(35,50,74,.06); }
        .learning-mini small { display: block; color: #8494aa; font-size: 10px; letter-spacing: .14em; text-transform: uppercase; font-weight: 950; }
        .learning-mini strong { display: block; margin-top: 8px; color: #20304c; font-size: 15px; line-height: 1.5; font-weight: 950; }
        .learning-frame-content {
            position: relative;
            z-index: 2;
            min-height: 582px;
            padding: 34px 34px 34px 34px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .learning-main {
            padding-right: 96px;
        }

        .lab-visual {
            position: relative;
            min-height: auto !important;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .lab-side-notes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            width: 100%;
        }

        .lab-side-notes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            width: 100%;
            margin-top: 18px;
        }

        .floating-class-card,
        .floating-live-card {
            position: relative;
            overflow: hidden;
            width: 100%;
            min-height: 122px;
            padding: 22px 22px 20px;
            border-radius: 28px;
            border: 1px solid rgba(35,50,74,.08);
            box-shadow: 0 18px 38px rgba(35,50,74,.10);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .floating-class-card:hover,
        .floating-live-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 22px 44px rgba(35,50,74,.14);
        }

        .floating-class-card {
            background: rgba(255,255,255,.97);
            text-align: left;
        }

        .floating-class-card small {
            display: block;
            color: #7d8ba3;
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .floating-class-card p {
            margin-top: 8px;
            color: #20304c;
            font-weight: 950;
            line-height: 1.55;
        }

        .floating-live-card {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: color-mix(in srgb, var(--edu-accent) 28%, white);
            color: #20304c;
            font-size: 13px;
            line-height: 1.6;
            font-weight: 950;
        }

        .floating-class-card small {
            display: block;
            color: #7d8ba3;
            font-size: 10px;
            letter-spacing: .15em;
            text-transform: uppercase;
            font-weight: 950;
        }

        .floating-class-card p {
            margin-top: 8px;
            color: #20304c;
            font-weight: 950;
            line-height: 1.55;
        }

        .mosaic-grid { display: grid; grid-template-columns: 1.15fr .85fr; gap: 20px; margin-top: 40px; align-items: stretch; }
        .mosaic-side { display: grid; gap: 20px; }
        .mosaic-card { position: relative; overflow: hidden; min-height: 220px; padding: 30px; border-radius: 34px; background: #ffffff; border: 1px solid rgba(35,50,74,.08); box-shadow: 0 18px 42px rgba(35,50,74,.08); }
        .mosaic-card.featured { min-height: 460px; background: radial-gradient(circle at top right, color-mix(in srgb, var(--edu-accent) 30%, transparent), transparent 32%), linear-gradient(180deg, #ffffff, #fffaf0); }
        .mosaic-card:nth-child(2n) { background: #eef8ff; }
        .mosaic-index { width: 48px; height: 48px; border-radius: 18px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 950; background: linear-gradient(135deg, var(--edu-primary), var(--edu-secondary)); box-shadow: 0 12px 24px color-mix(in srgb, var(--edu-primary) 18%, transparent); }
        .mosaic-card h3 { margin-top: 18px; color: #20304c; font-size: 1.45rem; font-weight: 950; }
        .mosaic-card.featured h3 { font-size: clamp(2rem, 4vw, 3.3rem); line-height: 1; letter-spacing: -.055em; }
        .mosaic-card p { color: #53667f; margin-top: 12px; line-height: 1.85; }

        .access-layout { display: grid; grid-template-columns: .9fr 1.1fr; gap: 24px; margin-top: 42px; align-items: start; }
        .access-ticket, .access-board { background: #ffffff; border: 1px solid rgba(35,50,74,.08); box-shadow: 0 18px 44px rgba(35,50,74,.08); border-radius: 34px; padding: 30px; }
        .access-ticket { position: sticky; top: 110px; overflow: hidden; background: radial-gradient(circle at top right, color-mix(in srgb, var(--edu-accent) 22%, transparent), transparent 34%), #ffffff; }
        .access-ticket::after { content: ""; position: absolute; width: 160px; height: 160px; right: -64px; bottom: -64px; border-radius: 999px; background: color-mix(in srgb, var(--edu-primary) 10%, transparent); }
        .access-ticket h3, .access-board h3 { color: #20304c; font-size: 2rem; font-weight: 950; margin: 0; }
        .access-list { display: grid; gap: 14px; margin-top: 24px; }
        .access-row { display: grid; grid-template-columns: 110px 1fr; gap: 14px; padding: 16px 0; border-top: 1px dashed rgba(35,50,74,.12); }
        .access-row small { color: #7d8ba3; font-size: 10px; text-transform: uppercase; letter-spacing: .14em; font-weight: 950; }
        .access-row strong { color: #20304c; line-height: 1.6; font-weight: 950; }

        .gallery-item:nth-child(3n+1) { transform: rotate(-1.6deg); }
        .gallery-item:nth-child(3n+2) { transform: translateY(24px) rotate(1.4deg); }
        .gallery-item:nth-child(3n+3) { transform: rotate(.8deg); }

        @media (max-width: 1100px) {
            .edu-hero-lab, .access-layout, .mosaic-grid { grid-template-columns: 1fr; }
            .lab-visual { min-height: 700px; }
            .access-ticket { position: relative; top: auto; }
        }
        @media (max-width: 980px) {
            .edu-hero-lab { padding-left: 38px; padding-right: 38px; }
            .lab-stats, .learning-mini-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .gallery-item:nth-child(n) { transform: none; }
            .learning-main {
                padding-right: 0;
            }

            .floating-class-card {
                left: -12px;
                bottom: -26px;
                width: 190px;
            }

            .floating-live-card {
                right: -14px;
                top: 18px;
                width: 132px;
                height: 132px;
                font-size: 11px;
                padding: 14px;
            }
        }
        @media (max-width: 640px) {
             .lab-side-notes {
                grid-template-columns: 1fr;
            }

            .floating-class-card,
            .floating-live-card {
                text-align: center;
            }
            .edu-hero-lab { padding: 74px 24px; }
            .lab-copy { text-align: center; padding-top: 12px; }
            .lab-title { font-size: clamp(3.1rem, 17vw, 5rem); }
            .lab-chip-row, .lab-action-row { justify-content: center; }
            .lab-stats, .learning-mini-grid { grid-template-columns: 1fr; }
            .lab-visual { min-height: auto; }
            .learning-orbit { position: relative; inset: auto; transform: none; min-height: auto; }
            .learning-frame { transform: none; min-height: 500px; }
            .learning-frame-content { min-height: 500px; padding: 24px; }
            .floating-class-card, .floating-live-card { position: relative; left: auto; right: auto; top: auto; bottom: auto; width: auto; height: auto; margin-top: 14px; border-radius: 26px; }
            .mosaic-side { grid-template-columns: 1fr; }
            .access-row { grid-template-columns: 1fr; gap: 6px; }
        }

        /* =====================================================
        FIX FINAL HERO EDUCATION TALK
        Membuat layout stabil, tidak overlap, dan responsif
        ===================================================== */

        .edu-hero-lab {
            min-height: auto !important;
            padding: 86px 64px 96px !important;
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 520px) !important;
            gap: 42px !important;
            align-items: start !important;
        }

        .lab-copy {
            padding: 32px 0 !important;
            min-width: 0 !important;
        }

        .lab-title {
            font-size: clamp(3rem, 6vw, 5.8rem) !important;
            line-height: .95 !important;
            letter-spacing: -.065em !important;
            max-width: 720px !important;
        }

        .lab-desc {
            max-width: 620px !important;
        }

        .lab-visual {
            position: relative !important;
            min-height: auto !important;
            width: 100% !important;
            min-width: 0 !important;
        }

        /* ini yang paling penting: jangan absolute */
        .learning-orbit {
            position: relative !important;
            inset: auto !important;
            transform: none !important;
            width: 100% !important;
            min-height: auto !important;
            border-radius: 46px !important;
        }

        .learning-frame {
            transform: none !important;
            min-height: auto !important;
            border-radius: 36px !important;
        }

        .learning-frame-content {
            min-height: auto !important;
            padding: 30px !important;
            display: block !important;
        }

        .learning-main {
            padding-right: 0 !important;
            margin-top: 48px !important;
        }

        .learning-main h2 {
            font-size: clamp(2.2rem, 4vw, 3.8rem) !important;
            line-height: .98 !important;
            letter-spacing: -.055em !important;
        }

        .learning-main p {
            max-width: 100% !important;
        }

        .learning-mini-grid {
            margin-top: 26px !important;
        }

        /* floating dibuat ikut alur normal, bukan menutupi */
        .floating-class-card,
        .floating-live-card {
            position: relative !important;
            left: auto !important;
            right: auto !important;
            top: auto !important;
            bottom: auto !important;
            width: 100% !important;
            height: auto !important;
            margin-top: 16px !important;
            border-radius: 26px !important;
        }

        .floating-live-card {
            min-height: auto !important;
            padding: 18px !important;
        }

        .floating-class-card {
            padding: 18px !important;
        }

        /* supaya about tidak naik menabrak hero */
        #about {
            clear: both !important;
        }

        /* tablet */
        @media (max-width: 1100px) {
            .edu-hero-lab {
                grid-template-columns: 1fr !important;
                gap: 30px !important;
            }

            .lab-copy {
                text-align: center !important;
            }

            .lab-title,
            .lab-desc {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .lab-chip-row,
            .lab-action-row {
                justify-content: center !important;
            }

            .lab-stats {
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        /* mobile */
        @media (max-width: 640px) {
            .edu-hero-lab {
                padding: 72px 22px 82px !important;
            }

            .lab-title {
                font-size: clamp(2.6rem, 14vw, 4.2rem) !important;
                line-height: 1 !important;
            }

            .learning-frame-content {
                padding: 24px !important;
            }

            .learning-main h2 {
                font-size: clamp(2rem, 11vw, 3.2rem) !important;
            }

            .learning-mini-grid {
                grid-template-columns: 1fr !important;
            }

            .lab-stats {
                grid-template-columns: 1fr !important;
            }
        }

        /* FIX alignment tanggal & waktu di Learning Pass */
        .access-row .edu-date-line,
        .access-row .edu-time-line {
            justify-content: flex-start !important;
            text-align: left !important;
            width: auto !important;
        }

        .access-row .edu-date-line span,
        .access-row .edu-time-line span {
            text-align: left !important;
        }

        /* Hiasan untuk kotak highlight utama */
        .mosaic-card.featured {
            position: relative;
            overflow: hidden;
            min-height: 460px;
            display: flex;
            flex-direction: column;
        }

        /* lingkaran besar dekorasi kanan bawah */
        .mosaic-card.featured::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -80px;
            bottom: -80px;
            border-radius: 999px;
            background:
                radial-gradient(circle,
                    color-mix(in srgb, var(--edu-accent) 42%, transparent) 0%,
                    color-mix(in srgb, var(--edu-accent) 20%, transparent) 48%,
                    transparent 70%
                );
            z-index: 0;
        }

        /* pastikan konten tetap di atas hiasan */
        .mosaic-card.featured .mosaic-index,
        .mosaic-card.featured h3,
        .mosaic-card.featured p {
            position: relative;
            z-index: 2;
        }

        /* tambahan teks dekorasi bawah */
        .mosaic-card.featured .mosaic-decor-text {
            position: relative;
            z-index: 2;
            margin-top: auto;
            padding-top: 34px;
            color: rgba(32, 48, 76, .16);
            font-size: clamp(2.8rem, 6vw, 5.2rem);
            line-height: .9;
            letter-spacing: -.07em;
            font-weight: 950;
        }

        .floating-class-card {
            background:
                radial-gradient(circle at top right, rgba(108, 99, 255, .10), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,251,255,.96));
            text-align: left;
        }

        .floating-class-card::before {
            content: "";
            position: absolute;
            width: 88px;
            height: 88px;
            right: -22px;
            top: -22px;
            border-radius: 999px;
            background: rgba(108, 99, 255, .08);
        }

        .floating-class-card::after {
            content: "🎓";
            position: absolute;
            right: 18px;
            bottom: 16px;
            font-size: 28px;
            opacity: .14;
        }

        .floating-class-card small {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #7d8ba3;
            font-size: 10px;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 950;
            position: relative;
            z-index: 2;
        }

        .floating-class-card small::before {
            content: "";
            width: 24px;
            height: 6px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--edu-primary), var(--edu-accent));
            display: inline-block;
        }

        .floating-class-card p {
            position: relative;
            z-index: 2;
            margin-top: 12px;
            color: #20304c;
            font-weight: 950;
            line-height: 1.45;
            font-size: 1.05rem;
            max-width: 85%;
        }

        .floating-live-card {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background:
                radial-gradient(circle at bottom left, rgba(255, 204, 112, .18), transparent 34%),
                linear-gradient(180deg, rgba(255, 246, 219, .95), rgba(255, 250, 238, .98));
            color: #20304c;
            font-size: 1rem;
            line-height: 1.65;
            font-weight: 900;
        }

        .floating-live-card::before {
            content: "💡";
            position: absolute;
            left: 18px;
            top: 16px;
            font-size: 20px;
            opacity: .85;
        }

        .floating-live-card::after {
            content: "";
            position: absolute;
            width: 94px;
            height: 94px;
            right: -18px;
            bottom: -18px;
            border-radius: 999px;
            background: rgba(255, 204, 112, .16);
        }

        .floating-live-card span,
        .floating-live-card p {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 640px) {
            .lab-side-notes {
                grid-template-columns: 1fr;
            }

            .floating-class-card,
            .floating-live-card {
                min-height: auto;
                text-align: center;
            }

            .floating-class-card p {
                max-width: 100%;
            }

            .floating-live-card::before {
                left: 50%;
                transform: translateX(-50%);
                top: 12px;
            }
        }

        /* =====================================================
        LUXURY EDUCATION TALK ANIMATION
        Tempel sebelum penutup style
        ===================================================== */

        /* Elemen muncul saat scroll */
        .edu-reveal,
        .edu-section > p,
        .edu-section > h1,
        .edu-section > h2,
        .edu-section > h3,
        .edu-label,
        .edu-title,
        .edu-gradient,
        .edu-nav,
        .lab-copy,
        .lab-kicker,
        .lab-title,
        .lab-desc,
        .lab-chip,
        .edu-btn,
        .lab-stat,
        .lab-visual,
        .learning-orbit,
        .learning-frame,
        .learning-mini,
        .floating-class-card,
        .floating-live-card,
        .mosaic-card,
        .mosaic-index,
        .speaker-card,
        .planner-card,
        .planner-item,
        .access-ticket,
        .access-board,
        .access-row,
        .countdown-card,
        .map-card,
        .gallery-item,
        .form-card,
        .summary-card,
        .message-card,
        .closing-card {
            opacity: 0;
            transform: translateY(34px) scale(.985);
            filter: blur(8px);
            transition:
                opacity .9s cubic-bezier(.2, .8, .2, 1),
                transform .9s cubic-bezier(.2, .8, .2, 1),
                filter .9s cubic-bezier(.2, .8, .2, 1),
                box-shadow .35s ease,
                border-color .35s ease;
            will-change: opacity, transform, filter;
        }

        .edu-show {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
            filter: blur(0) !important;
        }

        /* Navbar masuk halus */
        .edu-nav {
            animation: eduNavEnter .85s cubic-bezier(.2, .8, .2, 1) both;
        }

        /* Hero langsung tampil elegan */
        #opening .lab-copy {
            animation: eduHeroCopyIn 1s cubic-bezier(.2, .8, .2, 1) both;
        }

        #opening .lab-kicker {
            animation: eduFadeDown .85s ease .12s both;
        }

        #opening .lab-title {
            animation: eduTitleIn 1.15s cubic-bezier(.2, .8, .2, 1) .28s both;
        }

        #opening .lab-desc {
            animation: eduFadeUp .85s ease .42s both;
        }

        #opening .lab-chip {
            animation: eduFadeUp .85s ease .52s both;
        }

        #opening .edu-btn {
            animation: eduFadeUp .85s ease .62s both;
        }

        #opening .lab-stat {
            animation: eduFadeUp .85s ease .72s both;
        }

        #opening .learning-orbit {
            animation:
                eduBoardEnter 1.1s cubic-bezier(.2, .8, .2, 1) .35s both,
                eduBoardFloat 5.4s ease-in-out 1.5s infinite;
        }

        #opening .floating-class-card {
            animation:
                eduFloatingNoteIn .95s cubic-bezier(.2, .8, .2, 1) .62s both,
                eduFloatingNoteMove 4.7s ease-in-out 1.5s infinite;
        }

        #opening .floating-live-card {
            animation:
                eduFloatingNoteIn .95s cubic-bezier(.2, .8, .2, 1) .78s both,
                eduFloatingNoteMove 5s ease-in-out 1.7s infinite;
        }

        /* Background hidup dan mewah */
        .edu-wrap {
            animation: eduWrapGlow 8s ease-in-out infinite alternate;
        }

        .edu-wrap::before {
            animation: eduPatternMove 18s linear infinite;
        }

        /* Dekorasi hero bergerak halus */
        .lab-copy::before,
        .learning-orbit,
        .mosaic-card.featured::after,
        .floating-class-card::before,
        .floating-live-card::after,
        .access-ticket::after {
            animation: eduDecorFloat 6.5s ease-in-out infinite;
        }

        /* Label/kicker glow */
        .edu-label::before,
        .lab-kicker::before,
        .floating-class-card small::before {
            animation: eduIconGlow 2.8s ease-in-out infinite alternate;
        }

        /* Dots board bergerak */
        .lab-window-dots span {
            animation: eduDotPulse 1.8s ease-in-out infinite;
        }

        .lab-window-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        .lab-window-dots span:nth-child(3) {
            animation-delay: .36s;
        }

        /* Tombol efek kilau */
        .edu-btn,
        button.edu-btn,
        button[onclick*="clipboard"] {
            position: relative;
            overflow: hidden;
        }

        .edu-btn::after,
        button.edu-btn::after,
        button[onclick*="clipboard"]::after {
            content: "";
            position: absolute;
            top: -70%;
            left: -80%;
            width: 48%;
            height: 240%;
            transform: rotate(22deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.58),
                transparent
            );
            animation: eduButtonShine 3.35s ease-in-out infinite;
            pointer-events: none;
        }

        /* Hover premium desktop */
        @media (hover: hover) {
            .lab-stat:hover,
            .learning-orbit:hover,
            .learning-mini:hover,
            .floating-class-card:hover,
            .floating-live-card:hover,
            .mosaic-card:hover,
            .speaker-card:hover,
            .planner-card:hover,
            .planner-item:hover,
            .access-ticket:hover,
            .access-board:hover,
            .countdown-card:hover,
            .map-card:hover,
            .gallery-item:hover,
            .form-card:hover,
            .summary-card:hover,
            .message-card:hover,
            .closing-card:hover {
                transform: translateY(-7px) scale(1.012) !important;
                border-color: color-mix(in srgb, var(--edu-primary) 30%, transparent) !important;
                box-shadow:
                    0 32px 82px rgba(35, 50, 74, .15),
                    0 0 44px color-mix(in srgb, var(--edu-primary) 12%, transparent),
                    inset 0 1px 0 rgba(255,255,255,.78) !important;
            }

            .learning-orbit:hover img,
            .gallery-item:hover img,
            .speaker-card:hover img {
                transform: scale(1.055);
                filter: saturate(1.06) contrast(1.04);
            }

            .edu-nav a:hover {
                box-shadow: 0 0 24px color-mix(in srgb, var(--edu-primary) 12%, transparent);
            }
        }

        .learning-frame img,
        .gallery-item img,
        .speaker-photo {
            transition: transform .75s ease, filter .75s ease;
        }

        /* Pin/highlight pulse */
        .mosaic-index,
        .note-pin,
        .feature-number {
            animation: eduIconPulse 3s ease-in-out infinite;
        }

        /* Speaker glow */
        .speaker-card::before {
            animation: eduSpeakerGlow 4s ease-in-out infinite alternate;
        }

        /* Countdown glow */
        .countdown-number {
            animation: eduNumberGlow 2.2s ease-in-out infinite alternate;
        }

        /* Gallery rotasi tetap halus */
        .gallery-item:nth-child(3n+1) {
            animation: eduGalleryLeft 4.8s ease-in-out infinite;
        }

        .gallery-item:nth-child(3n+2) {
            animation: eduGalleryMiddle 4.8s ease-in-out infinite;
        }

        .gallery-item:nth-child(3n+3) {
            animation: eduGalleryRight 4.8s ease-in-out infinite;
        }

        /* Floating action */
        .floating-actions a,
        .floating-action-button {
            animation: eduFloatingButton 3.4s ease-in-out infinite;
        }

        .floating-actions a:nth-child(2),
        .floating-action-button:nth-child(2) {
            animation-delay: .18s;
        }

        .floating-actions a:nth-child(3),
        .floating-action-button:nth-child(3) {
            animation-delay: .36s;
        }

        .floating-actions a:nth-child(4),
        .floating-action-button:nth-child(4) {
            animation-delay: .54s;
        }

        /* Keyframes */
        @keyframes eduNavEnter {
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

        @keyframes eduHeroCopyIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes eduFadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes eduFadeUp {
            from {
                opacity: 0;
                transform: translateY(26px);
                filter: blur(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes eduTitleIn {
            from {
                opacity: 0;
                transform: translateY(38px) scale(.94);
                filter: blur(12px);
                letter-spacing: -.02em;
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes eduBoardEnter {
            from {
                opacity: 0;
                transform: translateY(42px) scale(.93) rotate(2deg);
                filter: blur(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(0);
                filter: blur(0);
            }
        }

        @keyframes eduBoardFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-8px) scale(1.012);
            }
        }

        @keyframes eduFloatingNoteIn {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.94);
                filter: blur(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes eduFloatingNoteMove {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-7px) scale(1.012);
            }
        }

        @keyframes eduWrapGlow {
            from {
                box-shadow:
                    0 30px 90px rgba(35, 50, 74, .10),
                    0 0 0 rgba(255,255,255,0);
            }
            to {
                box-shadow:
                    0 38px 112px rgba(35, 50, 74, .13),
                    0 0 54px color-mix(in srgb, var(--edu-primary) 10%, transparent);
            }
        }

        @keyframes eduPatternMove {
            from {
                background-position: 0 0;
            }
            to {
                background-position: 96px 96px;
            }
        }

        @keyframes eduDecorFloat {
            0%, 100% {
                transform: translateY(0) rotate(-8deg) scale(1);
            }
            50% {
                transform: translateY(-10px) rotate(-4deg) scale(1.025);
            }
        }

        @keyframes eduIconGlow {
            from {
                box-shadow: 0 0 0 color-mix(in srgb, var(--edu-primary) 0%, transparent);
                filter: saturate(1);
            }
            to {
                box-shadow: 0 0 22px color-mix(in srgb, var(--edu-primary) 24%, transparent);
                filter: saturate(1.12);
            }
        }

        @keyframes eduDotPulse {
            0%, 100% {
                opacity: .38;
                transform: translateY(0);
            }
            50% {
                opacity: .9;
                transform: translateY(-2px);
            }
        }

        @keyframes eduButtonShine {
            0%, 48% {
                left: -80%;
            }
            75%, 100% {
                left: 130%;
            }
        }

        @keyframes eduIconPulse {
            0%, 100% {
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 24px color-mix(in srgb, var(--edu-primary) 14%, transparent);
            }
            50% {
                transform: translateY(-4px) scale(1.055);
                box-shadow:
                    0 18px 38px color-mix(in srgb, var(--edu-primary) 22%, transparent),
                    0 0 28px color-mix(in srgb, var(--edu-accent) 20%, transparent);
            }
        }

        @keyframes eduSpeakerGlow {
            from {
                opacity: .12;
                transform: scale(1);
            }
            to {
                opacity: .24;
                transform: scale(1.08);
            }
        }

        @keyframes eduNumberGlow {
            from {
                text-shadow: 0 0 8px color-mix(in srgb, var(--edu-accent) 18%, transparent);
            }
            to {
                text-shadow:
                    0 0 18px color-mix(in srgb, var(--edu-accent) 42%, transparent),
                    0 0 34px color-mix(in srgb, var(--edu-primary) 18%, transparent);
            }
        }

        @keyframes eduGalleryLeft {
            0%, 100% {
                transform: rotate(-1.6deg) translateY(0);
            }
            50% {
                transform: rotate(-1deg) translateY(-6px);
            }
        }

        @keyframes eduGalleryMiddle {
            0%, 100% {
                transform: translateY(24px) rotate(1.4deg);
            }
            50% {
                transform: translateY(16px) rotate(1deg);
            }
        }

        @keyframes eduGalleryRight {
            0%, 100% {
                transform: rotate(.8deg) translateY(0);
            }
            50% {
                transform: rotate(1.3deg) translateY(-6px);
            }
        }

        @keyframes eduFloatingButton {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        /* Mobile lebih ringan */
        @media (max-width: 640px) {
            .edu-reveal,
            .edu-section > p,
            .edu-section > h1,
            .edu-section > h2,
            .edu-section > h3,
            .edu-label,
            .edu-title,
            .edu-gradient,
            .edu-nav,
            .lab-copy,
            .lab-kicker,
            .lab-title,
            .lab-desc,
            .lab-chip,
            .edu-btn,
            .lab-stat,
            .lab-visual,
            .learning-orbit,
            .learning-frame,
            .learning-mini,
            .floating-class-card,
            .floating-live-card,
            .mosaic-card,
            .mosaic-index,
            .speaker-card,
            .planner-card,
            .planner-item,
            .access-ticket,
            .access-board,
            .access-row,
            .countdown-card,
            .map-card,
            .gallery-item,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card {
                transform: translateY(22px) scale(.99);
                filter: blur(5px);
            }

            .gallery-item:nth-child(n) {
                animation: none;
                transform: none;
            }

            #opening .learning-orbit {
                animation:
                    eduFadeUp .9s ease .3s both,
                    eduFloatingButton 5s ease-in-out 1.2s infinite;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            .edu-reveal,
            .edu-section > p,
            .edu-section > h1,
            .edu-section > h2,
            .edu-section > h3,
            .edu-label,
            .edu-title,
            .edu-gradient,
            .edu-nav,
            .lab-copy,
            .lab-kicker,
            .lab-title,
            .lab-desc,
            .lab-chip,
            .edu-btn,
            .lab-stat,
            .lab-visual,
            .learning-orbit,
            .learning-frame,
            .learning-mini,
            .floating-class-card,
            .floating-live-card,
            .mosaic-card,
            .mosaic-index,
            .speaker-card,
            .planner-card,
            .planner-item,
            .access-ticket,
            .access-board,
            .access-row,
            .countdown-card,
            .map-card,
            .gallery-item,
            .form-card,
            .summary-card,
            .message-card,
            .closing-card,
            .edu-wrap,
            .edu-wrap::before,
            .floating-actions a,
            .floating-action-button,
            .countdown-number {
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
    $themeColor = $invitation->theme_color ?? 'rose';

    $themes = [
        'maroon' => [
            'primary' => '#ef476f',
            'secondary' => '#7b61ff',
            'accent' => '#ffb703',
            'ink' => '#23324a',
        ],
        'emerald' => [
            'primary' => '#22a699',
            'secondary' => '#4d96ff',
            'accent' => '#ffd166',
            'ink' => '#173f46',
        ],
        'navy' => [
            'primary' => '#4d96ff',
            'secondary' => '#7b61ff',
            'accent' => '#ffd166',
            'ink' => '#16213e',
        ],
        'rose' => [
            'primary' => '#ff5f9e',
            'secondary' => '#6c63ff',
            'accent' => '#ffcc70',
            'ink' => '#23324a',
        ],
        'gold' => [
            'primary' => '#f59e0b',
            'secondary' => '#6366f1',
            'accent' => '#f97316',
            'ink' => '#2f2a1e',
        ],
        'slate' => [
            'primary' => '#5b6c8f',
            'secondary' => '#7c8cb5',
            'accent' => '#ffbf69',
            'ink' => '#1f2937',
        ],
    ];

    $activeTheme = $themes[$themeColor] ?? $themes['rose'];

    $firstPhoto = $invitation->photos->first();
    $shareUrl = route('invitation.public', $invitation->slug);

    $eventTitle = $invitation->title ?: 'Undangan Acara';
    $eventName = $invitation->event_name ?: 'Acara';
    $hostName = $invitation->host_name ?: null;

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

    $locationText = $invitation->location_name ?: null;

    $shareMessage =
        "Assalamu'alaikum Wr. Wb.\n\n" .
        "Dengan penuh rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara:\n\n" .
        "*{$eventName}*\n" .
        "*{$eventTitle}*\n\n";

    if ($hostName) {
        $shareMessage .= "Diselenggarakan oleh: {$hostName}\n";
    }

    $shareMessage .= "Tanggal: {$eventDateText}\n";

    if ($eventTimeText) {
        $shareMessage .= "Waktu: {$eventTimeText}\n";
    }

    if ($locationText) {
        $shareMessage .= "Tempat: {$locationText}\n";
    }

    $shareMessage .=
        "\nSilakan buka undangan lengkap melalui link berikut:\n" .
        $shareUrl .
        "\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa terbaik.\n\n" .
        "Wassalamu'alaikum Wr. Wb.";

    $shareText = urlencode($shareMessage);

    $eventMode = strtolower($invitation->event_mode ?: 'offline');
    $isOnlineEvent = $eventMode === 'online';
    $onlineUrl = trim((string) ($invitation->online_url ?? ''));

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
            $startTime = !empty($invitation->event_time)
                ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i:s')
                : '00:00:00';

            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime);

            $endDate = $invitation->event_end_date
                ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d')
                : $startDate;

            if (!empty($invitation->event_end_time)) {
                $endTime = \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i:s');
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime);
            } else {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
                $endDateTime = $startDateTime->copy()->addHours(3);
            }

            $calendarTitle = trim(($invitation->event_name ?: 'Education Talk') . ' - ' . $invitation->title);
            $calendarDetails = trim(($invitation->description ?: 'Undangan Education Talk') . "\n\nLink Undangan: " . $shareUrl);

            $calendarLocation = $isOnlineEvent
                ? trim($onlineUrl ?: ($invitation->location_name ?: 'Online Education Talk'))
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

    $mapOpenUrl = $isOnlineEvent ? null : ($mapData['open_url'] ?? $invitation->maps_url);
    $mapEmbedUrl = $isOnlineEvent ? null : ($mapData['embed_url'] ?? null);

    $accessTypeLabel = $isOnlineEvent ? 'Platform' : 'Lokasi';
    $accessName = $invitation->location_name ?: ($isOnlineEvent ? 'Online Education Talk' : 'Lokasi Education Talk');

    $accessDescription = $invitation->address ?: ($isOnlineEvent
        ? 'Gunakan tombol Join Online untuk masuk ke sesi webinar/education talk.'
        : 'Alamat lengkap belum ditambahkan.');

    $accessActionUrl = $isOnlineEvent ? $onlineUrl : $mapOpenUrl;
    $accessActionText = $isOnlineEvent ? 'Join Online' : 'Buka Maps';
    $accessActionIcon = $isOnlineEvent ? '🌐' : '📍';

    $educationHighlights = collect($invitation->event_highlights ?? [])
        ->filter(function ($item) {
            return !empty($item['title']) || !empty($item['description']);
        })
        ->take(12)
        ->values();
@endphp

<body
    style="
        --edu-primary: {{ $activeTheme['primary'] }};
        --edu-secondary: {{ $activeTheme['secondary'] }};
        --edu-accent: {{ $activeTheme['accent'] }};
        --edu-ink: {{ $activeTheme['ink'] ?? '#20304c' }};
    "
>
    <main class="edu-shell">
        <div class="edu-wrap">

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
                   src="{{ $invitation->music_url ? asset('storage/' . $invitation->music_url) : asset('assets/music/background3.mp3') }}"
                   preload="auto"
                   loop>
            </audio>

            <nav class="edu-nav">
                <a href="#opening">Home</a>
                <a href="#about">Tentang</a>
                <a href="#speakers">Pembicara</a>
                <a href="#detail">Detail</a>
                <a href="#message">RSVP</a>
            </nav>


            {{-- HERO --}}
            <section id="opening" class="edu-hero-lab">
                <div class="lab-copy">
                    <div class="lab-kicker">Education Talk</div>

                    <h1 class="responsive-text lab-title edu-gradient">
                        {{ $invitation->title ?: 'Education Talk 2026' }}
                    </h1>

                    <p class="responsive-text lab-desc">
                        {{ $invitation->description ?: 'Acara edukatif yang dibuat lebih hangat, ceria, dan menyenangkan untuk menghadirkan insight, inspirasi, dan pengalaman belajar yang berkesan.' }}
                    </p>

                    <div class="lab-chip-row">
                        <span class="lab-chip">{{ $invitation->event_name ?: 'Seminar Pendidikan' }}</span>
                        <span class="lab-chip">{{ $invitation->host_name ?: 'Komunitas Belajar' }}</span>
                        <span class="lab-chip">{{ $isOnlineEvent ? 'Online' : 'Offline' }}</span>
                    </div>

                    <div class="lab-action-row">
                        @if ($accessActionUrl)
                            <a href="{{ $accessActionUrl }}" target="_blank" class="edu-btn">
                                {{ $accessActionIcon }} {{ $accessActionText }}
                            </a>
                        @else
                            <a href="#detail" class="edu-btn">Detail Acara</a>
                        @endif

                        <a href="#about" class="edu-btn secondary">Lihat Highlight</a>
                    </div>

                    <div class="lab-stats">
                        <div class="lab-stat">
                            <strong>{{ max($invitation->people->count(), 1) }}</strong>
                            <span>Pembicara</span>
                        </div>
                        <div class="lab-stat">
                            <strong>{{ $educationHighlights->count() ?: 0 }}</strong>
                            <span>Topik</span>
                        </div>
                        <div class="lab-stat">
                            <strong>
                                @if ($invitation->event_date)
                                    {{ \Carbon\Carbon::parse($invitation->event_date)->format('d') }}
                                @else
                                    --
                                @endif
                            </strong>
                            <span>Tanggal</span>
                        </div>
                    </div>
                </div>

                <div class="lab-visual">
                    <div class="learning-orbit">
                        <div class="learning-frame">
                            @if ($invitation->cover_image)
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}" alt="Cover" class="cover-photo">
                            @elseif ($firstPhoto)
                                <img src="{{ asset('storage/' . $firstPhoto->image_path) }}" alt="Foto" class="cover-photo">
                            @endif

                            <div class="learning-frame-content">
                                <div class="lab-window-top">
                                    <div class="lab-badge">{{ $invitation->event_name ?: 'Education Talk' }}</div>
                                    <div class="lab-window-dots"><span></span><span></span><span></span></div>
                                </div>

                                <div class="learning-main">
                                    <h2 class="responsive-text">
                                        {{ $invitation->seminar_about_title ?: 'Belajar, Bertumbuh, dan Terinspirasi Bersama' }}
                                    </h2>

                                    <p class="responsive-text">
                                        {{ $invitation->host_name ? 'Diselenggarakan oleh ' . $invitation->host_name : 'Tempat bertemu ide-ide baik, pembicara inspiratif, dan pengalaman belajar yang ringan namun bermakna.' }}
                                    </p>

                                    <div class="learning-mini-grid">
                                        <div class="learning-mini">
                                            <small>Tanggal</small>
                                            <strong class="edu-date-line">
                                                @if ($invitation->event_date)
                                                    <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                                    @if ($invitation->event_end_date)
                                                        <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                                    @endif
                                                @else
                                                    <span>Belum diatur</span>
                                                @endif
                                            </strong>
                                        </div>

                                        <div class="learning-mini">
                                            <small>Waktu</small>
                                            <strong class="edu-time-line">
                                                @if ($invitation->event_time)
                                                    <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>
                                                    @if ($invitation->event_end_time)
                                                        <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                                    @endif
                                                @else
                                                    <span>Belum diatur</span>
                                                @endif
                                            </strong>
                                        </div>

                                        <div class="learning-mini">
                                            <small>Mode</small>
                                            <strong class="responsive-text">{{ $isOnlineEvent ? 'Online Session' : 'Offline Session' }}</strong>
                                        </div>

                                        <div class="learning-mini">
                                            <small>Lokasi</small>
                                            <strong class="responsive-text">{{ $invitation->location_name ?: ($isOnlineEvent ? 'Platform Online' : 'Lokasi Acara') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lab-side-notes">
                        <div class="floating-class-card">
                            <small>Presented by</small>
                            <p class="responsive-text">{{ $invitation->host_name ?: 'Education Community' }}</p>
                        </div>

                        <div class="floating-live-card">
                            <span>
                                {{ $isOnlineEvent ? 'Live online session siap diakses peserta.' : 'Sesi tatap muka penuh insight dan diskusi.' }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ABOUT --}}
            <section id="about" class="edu-section compact">
                <div class="section-head">
                    <p class="edu-label justify-center">Why Join This Talk</p>

                    <h2 class="responsive-text edu-title text-5xl md:text-6xl mt-6">
                        {{ $invitation->seminar_about_title ?: 'Education Talk yang Ringan, Hangat, dan Penuh Insight' }}
                    </h2>

                    <p class="responsive-text desc text-lg">
                        {{ $invitation->host_name ? 'Acara ini dipersembahkan oleh ' . $invitation->host_name . ' untuk menghadirkan suasana belajar yang menyenangkan dan inspiratif.' : 'Acara ini dirancang agar peserta bisa belajar dengan suasana yang menyenangkan, visual ceria, dan isi yang tetap profesional.' }}
                    </p>
                </div>

                @php
                    $highlightCount = $educationHighlights->count();
                @endphp

                @if ($highlightCount)
                    <div class="mosaic-grid">
                        @foreach ($educationHighlights as $index => $highlight)
                            @if ($index === 0)
                                <div class="mosaic-card featured">
                                    <div class="mosaic-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    @if (!empty($highlight['title']))
                                        <h3 class="responsive-text">{{ $highlight['title'] }}</h3>
                                    @endif
                                    @if (!empty($highlight['description']))
                                        <p class="responsive-text">{{ $highlight['description'] }}</p>
                                    @endif
                                    <div class="mosaic-decor-text">
                                        Learn<br>Grow
                                    </div>
                                </div>

                                @if ($educationHighlights->count() > 1)
                                    <div class="mosaic-side">
                                @endif
                            @else
                                <div class="mosaic-card">
                                    <div class="mosaic-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                    @if (!empty($highlight['title']))
                                        <h3 class="responsive-text">{{ $highlight['title'] }}</h3>
                                    @endif
                                    @if (!empty($highlight['description']))
                                        <p class="responsive-text">{{ $highlight['description'] }}</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach

                        @if ($educationHighlights->count() > 1)
                            </div>
                        @endif
                    </div>
                @endif
            </section>
            {{-- SPEAKERS --}}
            <section id="speakers" class="edu-section compact text-center">
                <p class="edu-label justify-center">
                    Inspiring Speakers
                </p>

                <h2 class="edu-title text-5xl md:text-6xl mt-6">
                    Pembicara Education Talk
                </h2>

                <p class="text-slate-600 mt-4 max-w-2xl mx-auto leading-7">
                    Tampilkan pembicara, mentor, moderator, host, atau narasumber utama.
                </p>

                <div class="speaker-grid {{ $invitation->people->count() <= 1 ? 'single-speaker' : '' }}">
                    @forelse ($invitation->people as $person)
                        <div class="speaker-card text-left">
                            @if ($person->photo)
                                <img src="{{ asset('storage/' . $person->photo) }}"
                                     class="speaker-photo"
                                     alt="{{ $person->name }}">
                            @else
                                <div class="speaker-placeholder">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($person->name ?: 'E', 0, 1)) }}
                                </div>
                            @endif

                            <span class="speaker-role">
                                {{ $person->subtitle ?: 'Pembicara' }}
                            </span>

                            <h3 class="responsive-text">
                                {{ $person->name ?: 'Nama Pembicara' }}
                            </h3>
                        </div>
                    @empty
                        <div class="speaker-card text-left">
                            <div class="speaker-placeholder">E</div>
                            <span class="speaker-role">Pembicara</span>
                            <h3>Education Speaker</h3>
                            <p>Data pembicara belum ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>


            {{-- DETAIL --}}
            <section id="detail" class="edu-section compact">
                <div class="section-head">
                    <p class="edu-label justify-center">Schedule & Access</p>

                    <h2 class="edu-title text-5xl md:text-6xl mt-6">
                        Detail Education Talk
                    </h2>

                    <p class="responsive-text desc">
                        Informasi lengkap mengenai jadwal, lokasi, mode acara, dan akses ke event.
                    </p>
                </div>

                <div class="access-layout">
                    <div class="access-ticket">
                        <h3>Learning Pass</h3>

                        <div class="access-list">
                            <div class="access-row">
                                <small>Acara</small>
                                <strong class="responsive-text">{{ $invitation->event_name ?: 'Education Talk' }}</strong>
                            </div>

                            <div class="access-row">
                                <small>Tanggal</small>
                                <strong class="edu-date-line">
                                    @if ($invitation->event_date)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d M Y') }}</span>
                                        @if ($invitation->event_end_date)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </strong>
                            </div>

                            <div class="access-row">
                                <small>Waktu</small>
                                <strong class="edu-time-line">
                                    @if ($invitation->event_time)
                                        <span>{{ \Carbon\Carbon::parse($invitation->event_time)->format('H:i') }}</span>
                                        @if ($invitation->event_end_time)
                                            <span>- {{ \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') }}</span>
                                        @endif
                                    @else
                                        <span>Belum diatur</span>
                                    @endif
                                </strong>
                            </div>

                            <div class="access-row">
                                <small>Mode</small>
                                <strong class="responsive-text">{{ $isOnlineEvent ? 'Online Education Session' : 'Offline Education Session' }}</strong>
                            </div>

                            <div class="access-row">
                                <small>{{ $accessTypeLabel }}</small>
                                <strong class="responsive-text">{{ $accessName }}</strong>
                            </div>

                            <div class="access-row">
                                <small>{{ $isOnlineEvent ? 'Info' : 'Alamat' }}</small>
                                <strong class="responsive-text">{{ $accessDescription }}</strong>
                            </div>
                        </div>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @if ($googleCalendarUrl)
                                <a href="{{ $googleCalendarUrl }}" target="_blank" class="edu-btn">📅 Atur Pengingat</a>
                            @endif

                            @if ($accessActionUrl)
                                <a href="{{ $accessActionUrl }}" target="_blank" class="edu-btn secondary">
                                    {{ $accessActionIcon }} {{ $accessActionText }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="access-board">
                            <p class="text-xs uppercase tracking-[.22em] font-black text-slate-400" id="countdown-note">
                                @if ($countdownTarget)
                                    Hitung mundur menuju acara
                                @else
                                    Tanggal acara belum diatur
                                @endif
                            </p>

                            <h3 class="mt-3">Countdown Belajar</h3>

                            <p class="text-slate-600 mt-3 leading-7">
                                Siapkan waktumu untuk bergabung di education talk ini.
                            </p>

                            <div class="countdown-grid" @if ($countdownTarget) data-countdown-target="{{ $countdownTarget }}" @endif>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-days">00</span><span class="countdown-label">Hari</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-hours">00</span><span class="countdown-label">Jam</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-minutes">00</span><span class="countdown-label">Menit</span></div>
                                <div class="countdown-card"><span class="countdown-number" id="countdown-seconds">00</span><span class="countdown-label">Detik</span></div>
                            </div>
                        </div>

                        @if ($isOnlineEvent || $invitation->location_name || $invitation->address || $mapOpenUrl || $mapEmbedUrl)
                            <div class="map-card">
                                @if ($isOnlineEvent)
                                    @if ($onlineUrl)
                                        <a href="{{ $onlineUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">💻</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Online Education Talk' }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk masuk ke sesi online.' }}</p>
                                                <p class="responsive-text mt-4 font-bold" style="color: var(--edu-primary);">Join Online →</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">💻</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Online Education Talk' }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Link sesi online belum ditambahkan.' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if ($mapEmbedUrl)
                                        <iframe src="{{ $mapEmbedUrl }}" class="map-frame" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                    @elseif ($mapOpenUrl)
                                        <a href="{{ $mapOpenUrl }}" target="_blank" class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Education Talk' }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address ?: 'Klik untuk membuka lokasi acara.' }}</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="map-placeholder">
                                            <div>
                                                <p class="text-5xl">📍</p>
                                                <p class="responsive-text font-black mt-3 text-slate-900">{{ $invitation->location_name ?: 'Lokasi Education Talk' }}</p>
                                                <p class="responsive-text text-slate-600 mt-2">{{ $invitation->address }}</p>
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
            @if ($invitation->photos->count())
                <section id="gallery" class="edu-section compact text-center">
                    <p class="edu-label justify-center">
                        Event Moments
                    </p>

                    <h2 class="edu-title text-5xl md:text-6xl mt-6">
                        Galeri Education Talk
                    </h2>

                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Galeri Education Talk">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- RSVP --}}
            <section id="message" class="edu-section compact">
                <div class="text-center">
                    <p class="edu-label justify-center">
                        RSVP & Message
                    </p>

                    <h2 class="edu-title text-5xl md:text-6xl mt-6">
                        Konfirmasi Kehadiran
                    </h2>

                    <p class="text-slate-600 mt-4 max-w-2xl mx-auto">
                        Isi form kehadiran dan tulis pesan singkat untuk panitia.
                    </p>
                </div>

                <div class="rsvp-wrap mt-8">
                    @if (session('message_success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
                            {{ session('message_success') }}
                        </div>
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
                          class="form-card space-y-4">
                        @csrf

                        <div>
                            <label class="uk-label">Nama Peserta</label>
                            <input type="text"
                                   name="guest_name"
                                   value="{{ old('guest_name') }}"
                                   class="uk-input mt-1"
                                   placeholder="Nama lengkap"
                                   required>
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
                            <label class="uk-label">Jumlah Peserta</label>
                            <input type="number"
                                   name="guest_count"
                                   value="{{ old('guest_count', 1) }}"
                                   min="1"
                                   max="10"
                                   class="uk-input mt-1">
                        </div>

                        <div>
                            <label class="uk-label">Pesan / Pertanyaan</label>
                            <textarea name="message"
                                      rows="4"
                                      class="uk-input mt-1"
                                      placeholder="Tulis pesan atau pertanyaan..."
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full edu-btn">
                            Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="summary-grid">
                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'tidak_hadir')->count() }}</strong>
                            <span>Tidak hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'hadir')->sum('guest_count') }}</strong>
                            <span>Hadir</span>
                        </div>

                        <div class="summary-card">
                            <strong>{{ $invitation->messages->where('attendance_status', 'ragu')->count() }}</strong>
                            <span>Ragu</span>
                        </div>
                    </div>

                    <div class="message-list">
                        @forelse ($invitation->messages as $message)
                            <div class="message-card">
                                <div class="message-head">
                                    <div class="message-info">
                                        <p class="responsive-text font-black text-slate-950">
                                            {{ $message->guest_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $message->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    @if ($message->attendance_status)
                                        <span class="message-badge">
                                            {{ str_replace('_', ' ', $message->attendance_status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="responsive-text text-slate-600 mt-4 leading-7">{{ trim($message->message) }}</p>
                            </div>
                        @empty
                            <div class="message-card text-center">
                                <p class="text-slate-500">Belum ada konfirmasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- CLOSING --}}
            <section id="closing" class="edu-section text-center">
                <div class="closing-card">
                    <p class="edu-label justify-center">
                        See You There
                    </p>

                    <h2 class="responsive-text edu-title edu-gradient text-5xl md:text-7xl mt-8">
                        Sampai Jumpa
                    </h2>

                    <p class="responsive-text text-slate-600 mt-6 leading-8 max-w-2xl mx-auto">
                        Terima kasih atas perhatian dan partisipasi Anda.
                        Semoga education talk ini membawa banyak manfaat, wawasan, dan inspirasi baru.
                    </p>

                    <h3 class="responsive-text text-3xl md:text-4xl font-black mt-10 text-slate-950">
                        {{ $invitation->title }}
                    </h3>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countdownContainer = document.querySelector('[data-countdown-target]');

            if (countdownContainer) {
                const targetValue = countdownContainer.getAttribute('data-countdown-target');
                const targetDate = new Date(targetValue);

                const daysEl = document.getElementById('countdown-days');
                const hoursEl = document.getElementById('countdown-hours');
                const minutesEl = document.getElementById('countdown-minutes');
                const secondsEl = document.getElementById('countdown-seconds');
                const noteEl = document.getElementById('countdown-note');

                function formatNumber(number) {
                    return String(number).padStart(2, '0');
                }

                function updateCountdown() {
                    if (isNaN(targetDate.getTime())) {
                        if (noteEl) {
                            noteEl.textContent = 'Format tanggal atau waktu acara belum valid.';
                        }
                        return;
                    }

                    const now = new Date();
                    let distance = targetDate.getTime() - now.getTime();

                    if (distance < 0) {
                        distance = 0;
                    }

                    const totalSeconds = Math.floor(distance / 1000);
                    const days = Math.floor(totalSeconds / (60 * 60 * 24));
                    const hours = Math.floor((totalSeconds % (60 * 60 * 24)) / (60 * 60));
                    const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
                    const seconds = Math.floor(totalSeconds % 60);

                    if (daysEl) daysEl.textContent = formatNumber(days);
                    if (hoursEl) hoursEl.textContent = formatNumber(hours);
                    if (minutesEl) minutesEl.textContent = formatNumber(minutes);
                    if (secondsEl) secondsEl.textContent = formatNumber(seconds);

                    if (noteEl) {
                        noteEl.textContent = distance > 0
                            ? 'Hitung mundur menuju acara'
                            : 'Acara sedang berlangsung atau telah dimulai';
                    }
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

                            if (musicIcon) {
                                musicIcon.src = musicIcon.dataset.iconOn;
                            }
                        } else {
                            musicAudio.pause();
                            musicToggle.classList.remove('is-active');

                            if (musicIcon) {
                                musicIcon.src = musicIcon.dataset.iconOff;
                            }
                        }
                    } catch (error) {
                        console.log('Audio tidak bisa diputar:', error);
                    }
                });
            }

            const scrollToggle = document.getElementById('scroll-toggle');

            let autoScrollActive = false;
            let autoScrollFrame = null;
            let scrollSpeed = 1.15;

            function getScroller() {
                return document.scrollingElement || document.documentElement || document.body;
            }

            function updateScrollButton(active) {
                if (!scrollToggle) return;

                const scrollIcon = scrollToggle.querySelector('img');

                if (active) {
                    scrollToggle.classList.add('is-active');

                    if (scrollIcon && scrollIcon.dataset.iconOn) {
                        scrollIcon.src = scrollIcon.dataset.iconOn;
                    }
                } else {
                    scrollToggle.classList.remove('is-active');

                    if (scrollIcon && scrollIcon.dataset.iconOff) {
                        scrollIcon.src = scrollIcon.dataset.iconOff;
                    }

                    if (autoScrollFrame) {
                        cancelAnimationFrame(autoScrollFrame);
                        autoScrollFrame = null;
                    }
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

                    if (autoScrollActive) {
                        autoScrollStep();
                    }
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

            /*
            |--------------------------------------------------------------------------
            | Luxury Scroll Reveal
            |--------------------------------------------------------------------------
            */
            const revealElements = document.querySelectorAll(`
                .edu-section > p,
                .edu-section > h1,
                .edu-section > h2,
                .edu-section > h3,
                .edu-label,
                .edu-title,
                .edu-gradient,
                .edu-nav,
                .lab-copy,
                .lab-kicker,
                .lab-title,
                .lab-desc,
                .lab-chip,
                .edu-btn,
                .lab-stat,
                .lab-visual,
                .learning-orbit,
                .learning-frame,
                .learning-mini,
                .floating-class-card,
                .floating-live-card,
                .mosaic-card,
                .mosaic-index,
                .speaker-card,
                .planner-card,
                .planner-item,
                .access-ticket,
                .access-board,
                .access-row,
                .countdown-card,
                .map-card,
                .gallery-item,
                .form-card,
                .summary-card,
                .message-card,
                .closing-card
            `);

            revealElements.forEach(function (element, index) {
                element.style.transitionDelay = Math.min(index * 34, 300) + 'ms';
            });

            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('edu-show');
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

            /*
            |--------------------------------------------------------------------------
            | Anti Inspect Ringan Tanpa Notice
            |--------------------------------------------------------------------------
            */

            /* Blok klik kanan */
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });

            /* Blok select text kecuali input/form */
            document.addEventListener('selectstart', function (event) {
                const tagName = event.target.tagName ? event.target.tagName.toLowerCase() : '';

                if (!['input', 'textarea', 'select', 'option'].includes(tagName)) {
                    event.preventDefault();
                }
            });

            /* Blok drag gambar / teks */
            document.addEventListener('dragstart', function (event) {
                event.preventDefault();
            });

            /* Blok shortcut inspect umum */
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
