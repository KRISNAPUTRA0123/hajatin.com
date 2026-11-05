<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - Hajatin.com</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (max-width: 768px) {
            body {
                font-size: 15px;
            }

            .uk-card {
                padding: 18px !important;
                border-radius: 22px !important;
            }

            .uk-input {
                font-size: 16px !important;
                min-height: 46px;
            }

            textarea.uk-input {
                min-height: 120px;
            }

            .uk-label {
                font-size: 13px !important;
            }

            .editor-layout h2 {
                font-size: 1.1rem !important;
                line-height: 1.35;
            }

            .editor-layout p,
            .editor-layout span,
            .editor-layout label {
                line-height: 1.55;
            }
        }

        /* =========================
        MODAL / POPUP PROFESSIONAL
        ========================= */
        .ui-modal.hidden {
            display: none;
        }

        .ui-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .ui-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(4px);
            animation: uiFadeIn .18s ease;
        }

        .ui-modal-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.20);
            border: 1px solid rgba(148, 163, 184, 0.18);
            animation: uiScaleIn .18s ease;
        }

        .ui-modal-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 18px;
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.20);
        }

        .ui-modal-icon.warning {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 12px 24px rgba(245, 158, 11, 0.22);
        }

        .ui-modal-icon.danger {
            background: linear-gradient(135deg, #ef4444, #f43f5e);
            box-shadow: 0 12px 24px rgba(239, 68, 68, 0.22);
        }

        .ui-modal-icon.success {
            background: linear-gradient(135deg, #10b981, #22c55e);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.22);
        }

        .ui-modal-icon.info {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.22);
        }

        .ui-modal-title {
            margin: 0 0 8px;
            font-size: 22px;
            line-height: 1.3;
            font-weight: 800;
            color: #0f172a;
        }

        .ui-modal-message {
            margin: 0;
            font-size: 15px;
            line-height: 1.75;
            color: #475569;
        }

        .ui-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 22px;
            flex-wrap: wrap;
        }

        .ui-btn {
            border: none;
            border-radius: 14px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s ease;
        }

        .ui-btn:hover {
            transform: translateY(-1px);
        }

        .ui-btn-light {
            background: #f8fafc;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .ui-btn-light:hover {
            background: #f1f5f9;
        }

        .ui-btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.18);
        }

        .ui-btn-danger {
            color: #fff;
            background: linear-gradient(135deg, #ef4444, #f43f5e);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.18);
        }

        .ui-btn-success {
            color: #fff;
            background: linear-gradient(135deg, #10b981, #22c55e);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.18);
        }

        /* =========================
        TOAST
        ========================= */
        .ui-toast-wrap {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: min(360px, calc(100vw - 24px));
        }

        .ui-toast {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 18px;
            padding: 14px 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
            animation: uiToastIn .18s ease;
        }

        .ui-toast-icon {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 16px;
        }

        .ui-toast.success .ui-toast-icon {
            background: linear-gradient(135deg, #10b981, #22c55e);
        }

        .ui-toast.error .ui-toast-icon {
            background: linear-gradient(135deg, #ef4444, #f43f5e);
        }

        .ui-toast.warning .ui-toast-icon {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }

        .ui-toast.info .ui-toast-icon {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
        }

        .ui-toast-body {
            min-width: 0;
        }

        .ui-toast-title {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }

        .ui-toast-message {
            margin: 4px 0 0;
            font-size: 13px;
            line-height: 1.6;
            color: #475569;
        }

        @keyframes uiFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes uiScaleIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes uiToastIn {
            from {
                opacity: 0;
                transform: translateX(18px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 640px) {
            .ui-modal-card {
                max-width: 100%;
                border-radius: 20px;
                padding: 20px;
            }

            .ui-modal-title {
                font-size: 20px;
            }

            .ui-modal-actions {
                flex-direction: column-reverse;
            }

            .ui-btn {
                width: 100%;
            }

            .ui-toast-wrap {
                top: auto;
                bottom: 16px;
                right: 12px;
                left: 12px;
                width: auto;
            }
        }
        #reset-editor-btn {
            background: linear-gradient(135deg, #dc2626, #e11d48);
            color: #ffffff;
            border: 1px solid rgba(220, 38, 38, .18);
            box-shadow: 0 10px 22px rgba(220, 38, 38, .18);
        }

        #reset-editor-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #be123c);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <form method="POST" action="{{ route('editor.update', $invitation) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="reset_delete_gallery" id="reset-delete-gallery-input" value="0">

        <header class="bg-white/90 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 md:px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                    class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition">
                        ←
                    </a>

                    <div>
                        <h1 class="font-extrabold text-slate-900">
                            {{ $invitation->template->name }}
                        </h1>

                        <div class="flex items-center gap-2 mt-1">
                            <span class="uk-badge
                                @if ($invitation->status === 'active')
                                    uk-badge-active
                                @else
                                    uk-badge-draft
                                @endif
                            ">
                                {{ strtoupper($invitation->status) }}
                            </span>

                            <span class="text-xs text-slate-400">
                                Editor Undangan
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 md:flex md:items-center gap-2 md:gap-3 w-full md:w-auto">
                    <button type="button"
                            id="reset-editor-btn"
                            class="py-2 px-3 md:px-4 text-sm md:text-base rounded-xl font-bold text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 shadow-sm transition">
                        Reset
                    </button>

                     <button type="submit" class="uk-btn-secondary py-2 px-3 md:px-4 text-sm md:text-base">
                        Simpan Draft
                    </button>

                    <button type="submit"
                        form="publish-form"
                        class="uk-btn-primary py-2 px-3 md:px-4 text-sm md:text-base">
                        Publish
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 md:px-6 py-5 md:py-8">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <p class="font-bold">Ada data yang belum sesuai:</p>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $templateView = $invitation->template->view_name ?? 'general';

                /*
                |--------------------------------------------------------------------------
                | Konfigurasi fitur per template
                |--------------------------------------------------------------------------
                | people      = menampilkan form Tokoh Utama / Pasangan
                | gifts       = menampilkan form Amplop Digital
                | people_min  = jumlah default form tokoh
                | people_max  = batas maksimal tokoh yang bisa ditambah
                */

                $templateFeatures = [
                    'classic-letter' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tokoh / Pasangan',
                        'people_desc' => 'Bagian ini akan tampil sebagai 2 card utama pada template.',
                        'people_item_label' => 'Orang',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'birthday-fun' => [
                        'people' => false,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini akan tampil sebagai bintang utama pesta ulang tahun.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'birthday-candy' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Birthday Star',
                        'people_desc' => 'Bagian ini akan tampil sebagai tokoh utama pada template Candy Birthday.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'birthday-kids-party' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini akan tampil sebagai Birthday Crew atau bintang utama pesta anak.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 4,
                    ],

                    'birthday-elegant' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Birthday Honoree',
                        'people_desc' => 'Bagian ini akan tampil sebagai tokoh utama pada template Birthday Elegant.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'seminar-pro' => [
                        'people' => true,
                        'gifts' => false,
                        'people_title' => 'Data Pembicara',
                        'people_desc' => 'Bagian ini akan tampil sebagai pembicara, moderator, narasumber, atau tokoh utama acara seminar.',
                        'people_item_label' => 'Pembicara',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'seminar-webinar-modern' => [
                        'people' => true,
                        'gifts' => false,
                        'people_title' => 'Data Pembicara Webinar',
                        'people_desc' => 'Bagian ini akan tampil sebagai pembicara, host, moderator, atau narasumber webinar.',
                        'people_item_label' => 'Pembicara',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'seminar-tech-conference' => [
                        'people' => true,
                        'gifts' => false,
                        'people_title' => 'Data Pembicara Tech Conference',
                        'people_desc' => 'Bagian ini akan tampil sebagai speaker, mentor, panelis, host, atau narasumber tech conference.',
                        'people_item_label' => 'Speaker',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'seminar-education-talk' => [
                        'people' => true,
                        'gifts' => false,
                        'people_title' => 'Data Pembicara Education Talk',
                        'people_desc' => 'Bagian ini akan tampil sebagai pembicara, moderator, mentor, atau narasumber education talk.',
                        'people_item_label' => 'Pembicara',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'syukuran-ceria' => [
                        'people' => false,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini tidak digunakan pada template syukuran-ceria.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 1,
                    ],

                    'syukuran-warm' => [
                        'people' => false,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini tidak digunakan pada template syukuran-warm.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 1,
                    ],

                    'syukuran-doa-bersama' => [
                        'people' => false,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini tidak digunakan pada template syukuran-doa-bersama.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 1,
                    ],

                    'syukuran-soft' => [
                        'people' => false,
                        'gifts' => true,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini tidak digunakan pada template syukuran-soft.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 1,
                    ],

                    'wisuda-graduation-day' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Wisudawan',
                        'people_desc' => 'Bagian ini akan tampil sebagai profil wisudawan, lulusan, atau tokoh utama acara wisuda.',
                        'people_item_label' => 'Wisudawan',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'wisuda-golden-graduation' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Wisudawan',
                        'people_desc' => 'Bagian ini akan tampil sebagai profil wisudawan, lulusan, atau tokoh utama acara wisuda.',
                        'people_item_label' => 'Wisudawan',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'wisuda-campus-pride' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Wisudawan',
                        'people_desc' => 'Bagian ini akan tampil sebagai profil wisudawan, lulusan, atau tokoh utama acara wisuda.',
                        'people_item_label' => 'Wisudawan',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'wisuda-elegant-graduate' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Wisudawan',
                        'people_desc' => 'Bagian ini akan tampil sebagai profil wisudawan, lulusan, atau tokoh utama acara wisuda.',
                        'people_item_label' => 'Wisudawan',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'wisuda-simple-graduation' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Wisudawan',
                        'people_desc' => 'Bagian ini akan tampil sebagai profil wisudawan, lulusan, atau tokoh utama acara wisuda.',
                        'people_item_label' => 'Wisudawan',
                        'people_min' => 1,
                        'people_max' => 6,
                    ],

                    'aqiqah-soft' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Buah Hati',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak pada undangan aqiqah.',
                        'people_item_label' => 'Buah Hati',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'aqiqah-baby-blessing' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Buah Hati',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak / buah hati pada template aqiqah.',
                        'people_item_label' => 'Buah Hati',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'aqiqah-little-prince' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Buah Hati',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak / buah hati pada template aqiqah little prince.',
                        'people_item_label' => 'Buah Hati',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'aqiqah-little-princess' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Buah Hati',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak / buah hati pada template aqiqah little princess.',
                        'people_item_label' => 'Buah Hati',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'aqiqah-islamic' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Buah Hati',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak / buah hati pada template aqiqah islamic.',
                        'people_item_label' => 'Buah Hati',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'khitanan-ceria' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Ananda',
                        'people_desc' => 'Bagian ini akan tampil sebagai data anak / ananda pada template khitanan.',
                        'people_item_label' => 'Ananda',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'khitanan-little-hero' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Ananda',
                        'people_desc' => 'Bagian ini akan tampil sebagai data ananda pada template Khitanan Little Hero.',
                        'people_item_label' => 'Ananda',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'khitanan-fun-party' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Ananda',
                        'people_desc' => 'Bagian ini akan tampil sebagai data ananda pada template Khitanan Fun Party.',
                        'people_item_label' => 'Ananda',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'khitanan-blue' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Ananda',
                        'people_desc' => 'Bagian ini akan tampil sebagai data ananda pada template Khitanan Blue.',
                        'people_item_label' => 'Ananda',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'khitanan-islamic' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Ananda',
                        'people_desc' => 'Bagian ini akan tampil sebagai data ananda pada template Khitanan Islamic.',
                        'people_item_label' => 'Ananda',
                        'people_min' => 1,
                        'people_max' => 2,
                    ],

                    'corporate-launch' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tim / Pembicara',
                        'people_desc' => 'Bagian ini akan tampil sebagai founder, CEO, speaker, product lead, partner, atau tokoh utama pada template Corporate Launch.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-business-opening' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tim / Perwakilan Bisnis',
                        'people_desc' => 'Bagian ini akan tampil sebagai owner, founder, direktur, manager, perwakilan bisnis, partner, atau tokoh utama pada template Corporate Business Opening.',
                        'people_item_label' => 'Perwakilan',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-product-launch' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tim / Product Speaker',
                        'people_desc' => 'Bagian ini akan tampil sebagai founder, product manager, speaker, demonstrator, business lead, partner, atau tokoh utama pada template Corporate Product Launch.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-company-gathering' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tim / Perwakilan Gathering',
                        'people_desc' => 'Bagian ini akan tampil sebagai pimpinan perusahaan, HR, panitia gathering, MC, partner, atau tokoh utama pada template Corporate Company Gathering.',
                        'people_item_label' => 'Perwakilan',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-formal-invitation' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Perwakilan / Tokoh Formal',
                        'people_desc' => 'Bagian ini akan tampil sebagai pimpinan perusahaan, perwakilan institusi, pembicara, sekretaris acara, public relations, atau tokoh utama pada template Corporate Formal Invitation.',
                        'people_item_label' => 'Perwakilan',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-startup-event' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Founder / Startup Team',
                        'people_desc' => 'Bagian ini akan tampil sebagai founder, speaker, mentor, product lead, growth team, investor relation, partner, atau perwakilan utama pada template Corporate Startup Event.',
                        'people_item_label' => 'Tokoh Startup',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-grand-opening-pro' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tim / Perwakilan Grand Opening',
                        'people_desc' => 'Bagian ini akan tampil sebagai owner, founder, manajemen, MC, guest relations, partner, atau tokoh utama pada template Corporate Grand Opening Pro.',
                        'people_item_label' => 'Perwakilan',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-award-night' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Tokoh / Perwakilan Award Night',
                        'people_desc' => 'Bagian ini akan tampil sebagai penerima penghargaan, host, MC, panitia, pimpinan perusahaan, partner, atau tokoh utama pada template Corporate Award Night.',
                        'people_item_label' => 'Tokoh Award',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-business-seminar' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Pembicara Business Seminar',
                        'people_desc' => 'Bagian ini akan tampil sebagai keynote speaker, moderator, panelis, mentor, business coach, partner, atau narasumber pada template Corporate Business Seminar.',
                        'people_item_label' => 'Pembicara',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'corporate-networking-night' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Host / Perwakilan Networking',
                        'people_desc' => 'Bagian ini akan tampil sebagai host, moderator, community lead, partner, sponsor, atau tokoh utama pada template Corporate Networking Night.',
                        'people_item_label' => 'Perwakilan',
                        'people_min' => 1,
                        'people_max' => 8,
                    ],

                    'wedding-nusantara' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Nusantara.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-minimal-black-gold' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Minimal Black Gold.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-royal-javanese' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Royal Javanese.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-golden-romance' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Golden Romance.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-elegant-white' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Elegant White.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-floral-love' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai dua card mempelai pada template Wedding Floral Love.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-rustic-garden' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Rustic Garden.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-green-garden' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Green Garden.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-classic-letter' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Classic Letter.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-luxury-maroon' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Luxury Maroon.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-vintage-romance' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Groom & Bride pada template Wedding Vintage Romance.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-peach-blossom' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Peach Blossom.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-batik-elegance' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Groom & Bride pada template Wedding Batik Elegance.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-modern-couple' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Modern Couple.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-emerald-wedding' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Emerald Wedding.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-soft-sakura' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Soft Sakura.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-ocean-love' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai Bride & Groom pada template Wedding Ocean Love.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-pastel-wedding' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Pastel Wedding.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'wedding-simple-nikah' => [
                        'people' => true,
                        'gifts' => true,
                        'people_title' => 'Data Mempelai',
                        'people_desc' => 'Bagian ini akan tampil sebagai data mempelai pada template Wedding Simple Nikah.',
                        'people_item_label' => 'Mempelai',
                        'people_min' => 2,
                        'people_max' => 2,
                    ],

                    'general' => [
                        'people' => false,
                        'gifts' => false,
                        'people_title' => 'Tokoh Utama',
                        'people_desc' => 'Bagian ini akan tampil pada template.',
                        'people_item_label' => 'Tokoh',
                        'people_min' => 1,
                        'people_max' => 1,
                    ],
                ];

                $feature = $templateFeatures[$templateView] ?? $templateFeatures['general'];

                $showPeopleForm = $feature['people'];
                $showGiftForm = $feature['gifts'];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 editor-layout">

            <section class="space-y-6 order-2 md:order-1">
                    <div class="uk-card p-6">
                        <h2 class="text-xl font-bold mb-2">
                            Data Utama Undangan
                        </h2>

                        <p class="text-sm text-slate-500 mb-5">
                            Data ini akan menjadi informasi utama yang tampil di halaman undangan dan digunakan untuk membuat link undangan.
                        </p>

                        <div class="mt-2 mb-4 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <span class="text-red-500 font-bold">*</span>
                                <span>Wajib diisi</span>
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="uk-label">Judul Utama Undangan <span class="text-red-500 font-bold">*</span></label>
                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title', $invitation->title) }}"
                                    class="uk-input mt-1"
                                    placeholder="Contoh: Alex & Oktavia, Seminar Digital Marketing, Grand Opening Cafe Luna"
                                    required
                                >

                                <p class="text-xs text-slate-500 mt-1">
                                    Untuk pernikahan, isi dengan nama pasangan (Mempelai Pria & Wanita). Untuk acara lain, isi dengan judul acara utama.
                                </p>
                            </div>

                            <div>
                                <label class="uk-label">Jenis Acara <span class="text-red-500 font-bold">*</span></label>
                                <input
                                    type="text"
                                    name="event_name"
                                    value="{{ old('event_name', $invitation->event_name) }}"
                                    class="uk-input mt-1"
                                    placeholder="Contoh: Pernikahan, Ulang Tahun, Seminar, Grand Opening"
                                >

                                <p class="text-xs text-slate-500 mt-1">
                                    Jenis acara hanya digunakan sebagai informasi tampilan undangan. Link publik dibuat otomatis dengan kode acak agar lebih sulit ditebak.
                                </p>
                            </div>

                            <div>
                                <label class="uk-label">Nama Pengundang / Tuan Rumah <span class="text-red-500 font-bold">*</span></label>
                                <input
                                    type="text"
                                    name="host_name"
                                    value="{{ old('host_name', $invitation->host_name) }}"
                                    class="uk-input mt-1"
                                    placeholder="Contoh: Keluarga Besar Alex & Oktavia, HIMTI,Cafe Luna"
                                >

                                <p class="text-xs text-slate-500 mt-1">
                                    Isi dengan nama keluarga, organisasi, instansi, komunitas, atau pihak yang mengadakan acara.
                                </p>
                            </div>

                            <div>
                                <label class="uk-label">Kalimat Undangan / Deskripsi Singkat</label>
                                <textarea
                                    name="description"
                                    rows="5"
                                    class="uk-input uk-break-input mt-1"
                                    placeholder="Contoh: Dengan segala kerendahan hati, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara kami..."
                                >{{ old('description', $invitation->description) }}</textarea>

                                <p class="text-xs text-slate-500 mt-1">
                                    Anda dapat mengubah kalimat ini sesuai kebutuhan acara, atau membiarkannya tetap seperti teks bawaan apabila sudah dirasa sesuai.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card p-6">
                        <h2 class="text-xl font-bold mb-4">
                            Warna Tema
                        </h2>

                        @php
                            $selectedTheme = old('theme_color', $invitation->theme_color ?? 'maroon');

                            $themeOptions = [
                                'maroon' => ['label' => 'Maroon Elegan', 'from' => '#5c123f', 'to' => '#8d2c63'],
                                'emerald' => ['label' => 'Emerald Calm', 'from' => '#0f4c45', 'to' => '#1f7a68'],
                                'navy' => ['label' => 'Navy Classic', 'from' => '#1e293b', 'to' => '#334155'],
                                'rose' => ['label' => 'Rose Soft', 'from' => '#be3b63', 'to' => '#f06292'],
                                'gold' => ['label' => 'Gold Luxury', 'from' => '#9a6b16', 'to' => '#d6a43a'],
                                'slate' => ['label' => 'Slate Minimal', 'from' => '#334155', 'to' => '#64748b'],
                            ];
                        @endphp

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($themeOptions as $key => $theme)
                                <label class="relative cursor-pointer">
                                    <input type="radio"
                                        name="theme_color"
                                        value="{{ $key }}"
                                        class="sr-only peer"
                                        {{ $selectedTheme === $key ? 'checked' : '' }}>

                                    <div class="rounded-2xl border-2 p-3 transition peer-checked:border-purple-600 peer-checked:ring-4 peer-checked:ring-purple-100">
                                        <div class="h-16 rounded-xl"
                                            style="background: linear-gradient(135deg, {{ $theme['from'] }}, {{ $theme['to'] }});">
                                        </div>

                                        <p class="text-sm font-bold text-slate-800 mt-3">
                                            {{ $theme['label'] }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <p class="text-xs text-slate-500 mt-3">
                            Warna ini akan memengaruhi background, tombol, badge, dan aksen template.
                        </p>
                    </div>


                    <div class="uk-card p-6">
                        <h2 class="text-xl font-bold mb-2">
                            Foto Utama Undangan
                        </h2>

                        <p class="text-sm text-slate-500 mb-4">
                            Foto ini digunakan sebagai gambar utama template. Pada beberapa desain, foto dapat tampil di bagian awal, tengah, atau akhir undangan sesuai layout template.
                        </p>

                        @if ($invitation->cover_image)
                            <div class="mb-4" id="cover-preview-box">
                                <img src="{{ asset('storage/' . $invitation->cover_image) }}"
                                    class="w-full h-56 object-cover rounded-xl"
                                    alt="Foto Utama Undangan">

                                <label class="mt-4 flex items-start gap-3 rounded-2xl border border-red-100 bg-red-50 p-4 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        id="delete-cover-checkbox"
                                        name="delete_cover"
                                        value="1"
                                        class="mt-1 rounded border-red-300 text-red-600 focus:ring-red-500"
                                    >

                                    <div>
                                        <p class="font-semibold text-red-700">
                                            Hapus foto utama yang sudah diupload
                                        </p>

                                        <p class="text-xs text-red-500 mt-1">
                                            Jika dicentang lalu disimpan, foto utama yang diupload akan dihapus dan template akan memakai foto default.
                                        </p>
                                    </div>
                                </label>
                            </div>
                        @else
                            <div class="mb-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5 text-center">
                                <p class="text-sm font-semibold text-slate-700">
                                    Belum ada foto utama upload
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    Template akan memakai gambar bawaan sesuai desain.
                                </p>
                            </div>
                        @endif

                        <div>
                            <label class="uk-label">Upload Foto Utama Baru</label>
                            <input
                                type="file"
                                name="cover_image"
                                accept="image/*"
                                class="w-full border rounded-xl p-3 mt-1 bg-white"
                            >

                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, PNG, WEBP. Maksimal 10 MB. Jika upload foto utama baru, foto utama lama akan diganti.
                            </p>
                        </div>
                    </div>

                    @php
                        $isSyukuranTemplate = in_array($templateView, [
                            'syukuran-ceria',
                            'syukuran-warm',
                            'syukuran-doa-bersama',
                            'syukuran-soft',
                        ]);

                        $isAqiqahTemplate = in_array($templateView, [
                            'aqiqah-soft',
                            'aqiqah-baby-blessing',
                            'aqiqah-little-prince',
                            'aqiqah-little-princess',
                            'aqiqah-islamic',
                        ]);

                        $isKhitananTemplate = in_array($templateView, [
                            'khitanan-ceria',
                            'khitanan-little-hero',
                            'khitanan-fun-party',
                            'khitanan-blue',
                            'khitanan-islamic',
                        ]);

                        $isWisudaTemplate = in_array($templateView, [
                            'wisuda-graduation-day',
                            'wisuda-golden-graduation',
                            'wisuda-campus-pride',
                            'wisuda-elegant-graduate',
                            'wisuda-simple-graduation',
                        ]);

                        $isSeminarTemplate = in_array($templateView, [
                            'seminar-pro',
                            'seminar-webinar-modern',
                            'seminar-tech-conference',
                            'seminar-education-talk',
                        ]);

                        $isCorporateTemplate =
                            \Illuminate\Support\Str::startsWith($templateView, 'corporate-')
                            || str_contains(strtolower($invitation->template->category->slug ?? ''), 'corporate')
                            || str_contains(strtolower($invitation->template->category->name ?? ''), 'corporate');

                        $isProductLaunchTemplate = $templateView === 'corporate-product-launch';
                        $isBusinessOpeningTemplate = $templateView === 'corporate-business-opening';
                        $isCompanyGatheringTemplate = $templateView === 'corporate-company-gathering';
                        $isFormalInvitationTemplate = $templateView === 'corporate-formal-invitation';
                        $isStartupEventTemplate = $templateView === 'corporate-startup-event';
                        $isGrandOpeningProTemplate = $templateView === 'corporate-grand-opening-pro';
                        $isAwardNightTemplate = $templateView === 'corporate-award-night';
                        $isBusinessSeminarTemplate = $templateView === 'corporate-business-seminar';
                        $isNetworkingNightTemplate = $templateView === 'corporate-networking-night';

                        $corporateAgendaProfiles = [
                            'corporate-product-launch' => [
                                'heading' => 'Highlight / Agenda Product Launch',
                                'agenda_label' => 'Agenda Product Launch',
                                'section_title_label' => 'Judul Section Agenda Product Launch',
                                'section_placeholder' => 'Contoh: Product Reveal, Live Demo, dan Market Insight',
                                'section_help' => 'Judul ini tampil di bagian agenda product launch sebelum kotak poin product launch.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda product reveal, live demo, fitur utama, market insight, promo launching, atau networking. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Product Launch',
                                'title_placeholder' => 'Contoh: Product Reveal',
                                'desc_placeholder' => 'Contoh: Sesi product reveal, live demo, fitur unggulan, market insight, dan networking profesional.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Product Reveal',
                                        'description' => 'Momen perkenalan produk, fitur utama, value proposition, atau inovasi terbaru kepada audiens.',
                                    ],
                                    [
                                        'title' => 'Live Demo',
                                        'description' => 'Sesi demonstrasi produk, cara penggunaan, benefit, dan pengalaman pengguna secara langsung.',
                                    ],
                                    [
                                        'title' => 'Market Insight',
                                        'description' => 'Paparan peluang pasar, strategi peluncuran, kolaborasi bisnis, dan networking profesional.',
                                    ],
                                ],
                            ],
                            'corporate-business-opening' => [
                                'heading' => 'Highlight / Agenda Opening',
                                'agenda_label' => 'Agenda Opening',
                                'section_title_label' => 'Judul Section Agenda Opening',
                                'section_placeholder' => 'Contoh: Opening Ceremony & Business Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda opening sebelum kotak poin business opening.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda opening, business introduction, networking, layanan utama, atau poin penting acara pembukaan bisnis. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Opening',
                                'title_placeholder' => 'Contoh: Opening Ceremony',
                                'desc_placeholder' => 'Contoh: Acara pembukaan bisnis, perkenalan layanan, networking, dan sesi relasi profesional.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Opening Ceremony',
                                        'description' => 'Momen pembukaan resmi bisnis, kantor, cabang, showroom, toko, layanan, atau brand baru.',
                                    ],
                                    [
                                        'title' => 'Business Introduction',
                                        'description' => 'Perkenalan konsep, layanan, nilai bisnis, dan arah kolaborasi kepada tamu undangan.',
                                    ],
                                    [
                                        'title' => 'Networking Session',
                                        'description' => 'Kesempatan membangun relasi profesional bersama pelanggan, partner, investor, dan komunitas.',
                                    ],
                                ],
                            ],
                            'corporate-company-gathering' => [
                                'heading' => 'Highlight / Agenda Gathering',
                                'agenda_label' => 'Agenda Gathering',
                                'section_title_label' => 'Judul Section Agenda Gathering',
                                'section_placeholder' => 'Contoh: Gathering Moment, Team Appreciation, dan Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda gathering sebelum kotak poin company gathering.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda gathering, team appreciation, hiburan, ramah tamah, networking, atau poin penting acara kebersamaan perusahaan. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Gathering',
                                'title_placeholder' => 'Contoh: Team Appreciation',
                                'desc_placeholder' => 'Contoh: Sesi apresiasi tim, ramah tamah, hiburan, kebersamaan, dan networking perusahaan.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Team Appreciation',
                                        'description' => 'Momen apresiasi untuk tim, karyawan, partner, atau pihak yang berkontribusi dalam perjalanan perusahaan.',
                                    ],
                                    [
                                        'title' => 'Togetherness Session',
                                        'description' => 'Sesi kebersamaan, ramah tamah, hiburan, makan bersama, atau aktivitas internal perusahaan.',
                                    ],
                                    [
                                        'title' => 'Networking & Collaboration',
                                        'description' => 'Kesempatan mempererat relasi profesional antar divisi, partner, tamu undangan, dan keluarga besar perusahaan.',
                                    ],
                                ],
                            ],
                            'corporate-formal-invitation' => [
                                'heading' => 'Highlight / Agenda Formal',
                                'agenda_label' => 'Agenda Formal',
                                'section_title_label' => 'Judul Section Agenda Formal',
                                'section_placeholder' => 'Contoh: Formal Agenda, Executive Session, dan Professional Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda formal sebelum kotak poin corporate formal invitation.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda formal, sesi executive, sambutan, presentasi resmi, networking profesional, atau susunan acara corporate formal. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Formal',
                                'title_placeholder' => 'Contoh: Executive Session',
                                'desc_placeholder' => 'Contoh: Sambutan resmi, presentasi formal, sesi executive, dan networking profesional.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Formal Opening',
                                        'description' => 'Pembukaan acara secara resmi dengan suasana profesional, rapi, dan berkesan.',
                                    ],
                                    [
                                        'title' => 'Executive Session',
                                        'description' => 'Sesi utama untuk penyampaian informasi, arahan, presentasi, atau agenda strategis perusahaan.',
                                    ],
                                    [
                                        'title' => 'Professional Networking',
                                        'description' => 'Kesempatan membangun relasi formal bersama tamu undangan, partner, stakeholder, dan jajaran perusahaan.',
                                    ],
                                ],
                            ],
                            'corporate-startup-event' => [
                                'heading' => 'Highlight / Agenda Startup',
                                'agenda_label' => 'Agenda Startup',
                                'section_title_label' => 'Judul Section Agenda Startup',
                                'section_placeholder' => 'Contoh: Startup Agenda, Pitch Session, dan Growth Talk',
                                'section_help' => 'Judul ini tampil di bagian agenda startup sebelum kotak poin startup event.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda startup, pitch session, growth talk, demo produk, networking, komunitas, mentor session, atau poin penting acara startup. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Startup',
                                'title_placeholder' => 'Contoh: Pitch Session',
                                'desc_placeholder' => 'Contoh: Pitch session, growth talk, demo produk, mentor session, dan networking startup.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Pitch Session',
                                        'description' => 'Sesi presentasi ide, produk, layanan, atau inovasi startup kepada audiens, partner, investor, dan komunitas.',
                                    ],
                                    [
                                        'title' => 'Growth Talk',
                                        'description' => 'Sesi insight tentang pertumbuhan bisnis, strategi branding, market fit, kolaborasi, dan pengembangan startup.',
                                    ],
                                    [
                                        'title' => 'Networking Session',
                                        'description' => 'Kesempatan membangun relasi bersama founder, mentor, investor, partner, komunitas, dan tim kreatif.',
                                    ],
                                ],
                            ],
                            'corporate-grand-opening-pro' => [
                                'heading' => 'Highlight / Agenda Grand Opening',
                                'agenda_label' => 'Agenda Grand Opening',
                                'section_title_label' => 'Judul Section Agenda Grand Opening',
                                'section_placeholder' => 'Contoh: Grand Opening Ceremony, Ribbon Cutting, dan Business Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda grand opening sebelum kotak poin grand opening.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda grand opening, opening ceremony, ribbon cutting, business introduction, networking, atau poin penting acara pembukaan. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Grand Opening',
                                'title_placeholder' => 'Contoh: Ribbon Cutting',
                                'desc_placeholder' => 'Contoh: Prosesi pembukaan resmi, sambutan, pengenalan bisnis, dan networking bersama tamu undangan.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Grand Opening Ceremony',
                                        'description' => 'Momen pembukaan resmi kantor, cabang, showroom, toko, venue, atau layanan baru dengan suasana profesional.',
                                    ],
                                    [
                                        'title' => 'Ribbon Cutting',
                                        'description' => 'Prosesi simbolis pembukaan acara bersama pimpinan, partner, atau tamu kehormatan.',
                                    ],
                                    [
                                        'title' => 'Business Networking',
                                        'description' => 'Kesempatan membangun relasi bersama pelanggan, partner, investor, komunitas, dan tamu undangan.',
                                    ],
                                ],
                            ],
                            'corporate-award-night' => [
                                'heading' => 'Highlight / Agenda Award Night',
                                'agenda_label' => 'Agenda Award Night',
                                'section_title_label' => 'Judul Section Agenda Award Night',
                                'section_placeholder' => 'Contoh: Award Ceremony, Appreciation Night, dan Gala Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda award night sebelum kotak poin award night.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda award night, penghargaan, apresiasi, nominasi, gala dinner, hiburan, atau networking. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Award Night',
                                'title_placeholder' => 'Contoh: Award Ceremony',
                                'desc_placeholder' => 'Contoh: Sesi pemberian penghargaan, apresiasi pencapaian, gala dinner, dan networking profesional.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Award Ceremony',
                                        'description' => 'Sesi pemberian penghargaan untuk individu, tim, partner, atau pihak yang berprestasi.',
                                    ],
                                    [
                                        'title' => 'Appreciation Night',
                                        'description' => 'Momen apresiasi atas kontribusi, loyalitas, pencapaian, dan kerja sama selama periode tertentu.',
                                    ],
                                    [
                                        'title' => 'Gala Networking',
                                        'description' => 'Kesempatan membangun relasi formal dalam suasana malam penghargaan yang elegan dan berkesan.',
                                    ],
                                ],
                            ],
                            'corporate-business-seminar' => [
                                'heading' => 'Highlight / Agenda Business Seminar',
                                'agenda_label' => 'Agenda Business Seminar',
                                'section_title_label' => 'Judul Section Agenda Business Seminar',
                                'section_placeholder' => 'Contoh: Keynote Session, Business Insight, dan Professional Networking',
                                'section_help' => 'Judul ini tampil di bagian agenda business seminar sebelum kotak poin business seminar.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda business seminar, keynote session, materi bisnis, panel discussion, workshop, atau networking. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Business Seminar',
                                'title_placeholder' => 'Contoh: Business Insight',
                                'desc_placeholder' => 'Contoh: Sesi keynote, insight bisnis, panel discussion, studi kasus, dan networking profesional.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Keynote Session',
                                        'description' => 'Sesi utama dari pembicara atau narasumber untuk membahas topik bisnis yang relevan dan aplikatif.',
                                    ],
                                    [
                                        'title' => 'Business Insight',
                                        'description' => 'Paparan strategi, tren pasar, peluang kolaborasi, atau studi kasus untuk pengembangan bisnis.',
                                    ],
                                    [
                                        'title' => 'Professional Networking',
                                        'description' => 'Momen memperluas koneksi bersama peserta, partner, komunitas, investor, dan relasi profesional.',
                                    ],
                                ],
                            ],
                            'corporate-networking-night' => [
                                'heading' => 'Highlight / Agenda Networking Night',
                                'agenda_label' => 'Agenda Networking Night',
                                'section_title_label' => 'Judul Section Agenda Networking Night',
                                'section_placeholder' => 'Contoh: Networking Night, Business Matching, dan Community Meetup',
                                'section_help' => 'Judul ini tampil di bagian agenda networking night sebelum kotak poin networking.',
                                'desc' => 'Bagian ini akan tampil sebagai agenda networking night, business matching, community meetup, sharing session, atau relasi profesional. Kosongkan jika tidak ingin ditampilkan.',
                                'item_label' => 'Agenda Networking Night',
                                'title_placeholder' => 'Contoh: Business Matching',
                                'desc_placeholder' => 'Contoh: Sesi networking, business matching, sharing singkat, dan relasi profesional dalam suasana santai.',
                                'default_highlights' => [
                                    [
                                        'title' => 'Networking Session',
                                        'description' => 'Sesi utama untuk mempertemukan peserta, partner, founder, komunitas, dan relasi profesional.',
                                    ],
                                    [
                                        'title' => 'Business Matching',
                                        'description' => 'Kesempatan memperkenalkan profil bisnis, bertukar kontak, dan membuka peluang kolaborasi.',
                                    ],
                                    [
                                        'title' => 'Community Night',
                                        'description' => 'Momen santai untuk membangun koneksi, berbagi insight, dan memperkuat hubungan antar peserta.',
                                    ],
                                ],
                            ],
                        ];

                        $corporateAgendaProfile = $corporateAgendaProfiles[$templateView] ?? null;
                        $corporateHighlightHeading = $corporateAgendaProfile['heading'] ?? 'Highlight / Agenda Corporate';
                        $corporateHighlightDescription = $corporateAgendaProfile['desc'] ?? 'Bagian ini akan tampil sebagai agenda corporate, business insight, demo, kolaborasi, atau networking. Kosongkan jika tidak ingin ditampilkan.';
                        $corporateSectionTitleLabel = $corporateAgendaProfile['section_title_label'] ?? 'Judul Section Agenda Corporate';
                        $corporateSectionTitlePlaceholder = $corporateAgendaProfile['section_placeholder'] ?? 'Contoh: Agenda Corporate untuk Inovasi, Kolaborasi, dan Pertumbuhan Bisnis';
                        $corporateSectionTitleHelp = $corporateAgendaProfile['section_help'] ?? 'Judul ini tampil di bagian agenda corporate sebelum kotak poin corporate.';
                        $corporateDefaultHighlights = $corporateAgendaProfile['default_highlights'] ?? [
                            [
                                'title' => 'Business Insight',
                                'description' => 'Paparan strategi, visi, dan peluang kolaborasi bersama stakeholder, partner, dan calon pelanggan.',
                            ],
                            [
                                'title' => 'Professional Session',
                                'description' => 'Sesi utama acara corporate yang dirancang rapi, relevan, dan mudah dipahami tamu.',
                            ],
                            [
                                'title' => 'Networking Session',
                                'description' => 'Momen untuk memperluas koneksi bisnis, komunitas, investor, dan relasi profesional.',
                            ],
                        ];

                        $highlightSectionTitlePlaceholder = $isWisudaTemplate
                            ? 'Contoh: Merayakan Perjalanan, Prestasi, dan Masa Depan'
                            : ($isAqiqahTemplate
                                ? 'Contoh: Doa, Syukur, dan Kebahagiaan Keluarga'
                                : ($isKhitananTemplate
                                    ? 'Contoh: Doa, Syukur, dan Kebahagiaan Ananda'
                                    : ($isSyukuranTemplate
                                        ? 'Contoh: Momen Syukuran yang Hangat dan Bermakna'
                                        : ($isCorporateTemplate
                                            ? $corporateSectionTitlePlaceholder
                                            : 'Contoh: Seminar yang Dirancang untuk Insight, Networking, dan Aksi'))));

                        $highlightItemLabel = $isWisudaTemplate
                            ? 'Poin Wisuda'
                            : ($isAqiqahTemplate
                                ? 'Poin Aqiqah'
                                : ($isKhitananTemplate
                                    ? 'Poin Khitanan'
                                    : ($isSyukuranTemplate
                                        ? 'Poin Syukuran'
                                        : ($isCorporateTemplate ? ($corporateAgendaProfile['item_label'] ?? 'Agenda Corporate') : 'Poin Seminar'))));

                        $highlightTitlePlaceholder = $isWisudaTemplate
                            ? 'Contoh: Momen Kelulusan'
                            : ($isAqiqahTemplate
                                ? 'Contoh: Tasyakuran Aqiqah'
                                : ($isKhitananTemplate
                                    ? 'Contoh: Tasyakuran Khitanan'
                                    : ($isSyukuranTemplate
                                        ? 'Contoh: Momen Syukur'
                                        : ($isCorporateTemplate ? ($corporateAgendaProfile['title_placeholder'] ?? 'Contoh: Business Insight') : 'Contoh: Materi Terarah'))));

                        $highlightDescriptionPlaceholder = $isWisudaTemplate
                            ? 'Contoh: Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih.'
                            : ($isAqiqahTemplate
                                ? 'Contoh: Momen penuh rasa syukur atas kelahiran buah hati tercinta.'
                                : ($isKhitananTemplate
                                    ? 'Contoh: Acara tasyakuran khitanan sebagai wujud syukur dan doa terbaik untuk ananda.'
                                    : ($isSyukuranTemplate
                                        ? 'Contoh: Acara ini menjadi momen untuk berkumpul, bersyukur, dan berbagi kebahagiaan.'
                                        : ($isCorporateTemplate ? ($corporateAgendaProfile['desc_placeholder'] ?? 'Contoh: Sesi business insight, agenda corporate, kolaborasi, dan networking profesional.') : 'Contoh: Bahasan acara dibuat ringkas dan relevan.'))));

                        $canChooseEventMode = $isSeminarTemplate || $isWisudaTemplate || $isCorporateTemplate;
                    @endphp

                    @if ($isCorporateTemplate || in_array($templateView, ['seminar-pro', 'seminar-webinar-modern', 'seminar-tech-conference', 'seminar-education-talk', 'syukuran-ceria', 'syukuran-warm', 'syukuran-doa-bersama', 'syukuran-soft', 'wisuda-graduation-day', 'wisuda-golden-graduation', 'wisuda-campus-pride', 'wisuda-elegant-graduate',  'wisuda-simple-graduation', 'aqiqah-soft', 'aqiqah-baby-blessing', 'aqiqah-little-prince', 'aqiqah-little-princess', 'aqiqah-islamic',  'khitanan-ceria', 'khitanan-little-hero', 'khitanan-fun-party', 'khitanan-blue', 'khitanan-islamic',  ]))
                        <div class="uk-card p-6">
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <div>
                                    <h2 class="text-xl font-bold">
                                        @if ($isWisudaTemplate)
                                            Highlight / Momen Wisuda
                                        @elseif ($isAqiqahTemplate)
                                            Highlight / Momen Aqiqah
                                        @elseif ($isKhitananTemplate)
                                            Highlight / Momen Khitanan
                                        @elseif ($isSyukuranTemplate)
                                            Highlight / Poin Acara Syukuran
                                        @elseif ($isCorporateTemplate)
                                            {{ $corporateHighlightHeading }}
                                        @else
                                            Highlight / Benefit Seminar
                                        @endif
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">
                                        @if ($isWisudaTemplate)
                                            Bagian ini akan tampil sebagai poin momen, prestasi, atau informasi penting acara wisuda. Kosongkan jika tidak ingin ditampilkan.
                                        @elseif ($isAqiqahTemplate)
                                            Bagian ini akan tampil sebagai poin acara aqiqah, doa, syukur, atau informasi penting keluarga. Kosongkan jika tidak ingin ditampilkan.
                                        @elseif ($isKhitananTemplate)
                                            Bagian ini akan tampil sebagai poin acara khitanan, doa, syukur, atau informasi penting keluarga. Kosongkan jika tidak ingin ditampilkan.
                                        @elseif ($isSyukuranTemplate)
                                            Bagian ini akan tampil sebagai kotak informasi pada section Tentang Acara. Kosongkan jika tidak ingin ditampilkan.
                                        @elseif ($isCorporateTemplate)
                                            {{ $corporateHighlightDescription }}
                                        @else
                                            Bagian ini akan tampil sebagai kotak poin seminar. Kosongkan jika tidak ingin ditampilkan.
                                        @endif
                                    </p>
                                </div>

                                <button type="button"
                                        id="add-highlight-btn"
                                        class="px-4 py-2 rounded-xl bg-purple-600 text-white font-semibold whitespace-nowrap">
                                    + Tambah Poin
                                </button>
                            </div>

                            <div class="mb-5">
                                <label class="uk-label">
                                   @if ($isWisudaTemplate)
                                        Judul Section Momen Wisuda
                                    @elseif ($isAqiqahTemplate)
                                        Judul Section Momen Aqiqah
                                    @elseif ($isKhitananTemplate)
                                        Judul Section Momen Khitanan
                                    @elseif ($isSyukuranTemplate)
                                        Judul Section Tentang Acara
                                    @elseif ($isCorporateTemplate)
                                        {{ $corporateSectionTitleLabel }}
                                    @else
                                        Judul Section Highlight
                                    @endif
                                </label>

                                <input type="text"
                                    name="seminar_about_title"
                                    value="{{ old('seminar_about_title', $invitation->seminar_about_title) }}"
                                    class="uk-input mt-1"
                                    placeholder="{{ $highlightSectionTitlePlaceholder }}">

                                <p class="text-xs text-slate-500 mt-1">
                                    @if ($isWisudaTemplate)
                                        Judul ini tampil di bagian momen wisuda sebelum kotak poin wisuda.
                                    @elseif ($isAqiqahTemplate)
                                        Judul ini tampil di bagian momen aqiqah sebelum poin acara aqiqah.
                                    @elseif ($isKhitananTemplate)
                                        Judul ini tampil di bagian momen khitanan sebelum poin acara khitanan.
                                    @elseif ($isSyukuranTemplate)
                                        Judul ini tampil di bagian Tentang Acara sebelum kotak poin syukuran.
                                    @elseif ($isCorporateTemplate)
                                        {{ $corporateSectionTitleHelp }}
                                    @else
                                        Judul ini tampil di bagian About The Event sebelum kotak poin seminar.
                                    @endif
                                </p>
                            </div>

                           @php
                                if ($isWisudaTemplate) {
                                    $defaultHighlights = [
                                        [
                                            'title' => 'Momen Kelulusan',
                                            'description' => 'Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih dengan penuh rasa bangga.',
                                        ],
                                        [
                                            'title' => 'Syukuran Keluarga',
                                            'description' => 'Acara ini menjadi momen berbagi rasa syukur bersama keluarga, sahabat, dan orang-orang terdekat.',
                                        ],
                                        [
                                            'title' => 'Kenangan Berharga',
                                            'description' => 'Abadikan momen wisuda dengan galeri, ucapan tamu, detail acara, dan undangan digital yang meriah.',
                                        ],
                                    ];
                                } elseif ($isAqiqahTemplate) {
                                    $defaultHighlights = [
                                        [
                                            'title' => 'Tasyakuran Aqiqah',
                                            'description' => 'Momen penuh rasa syukur atas kelahiran buah hati tercinta.',
                                        ],
                                        [
                                            'title' => 'Doa Bersama',
                                            'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang anak.',
                                        ],
                                        [
                                            'title' => 'Kebersamaan Keluarga',
                                            'description' => 'Acara ini menjadi ruang hangat untuk berkumpul dan berbagi kebahagiaan.',
                                        ],
                                    ];
                                } elseif ($isKhitananTemplate) {
                                    $defaultHighlights = [
                                        [
                                            'title' => 'Tasyakuran Khitanan',
                                            'description' => 'Momen penuh rasa syukur atas terlaksananya khitanan ananda tercinta.',
                                        ],
                                        [
                                            'title' => 'Doa untuk Ananda',
                                            'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang ananda.',
                                        ],
                                        [
                                            'title' => 'Kebersamaan Keluarga',
                                            'description' => 'Acara ini menjadi ruang hangat untuk berkumpul, bersilaturahmi, dan berbagi kebahagiaan.',
                                        ],
                                    ];
                                } elseif ($isSyukuranTemplate) {
                                    $defaultHighlights = [
                                        [
                                            'title' => 'Momen Syukur',
                                            'description' => 'Acara ini menjadi momen untuk berkumpul, bersyukur, dan berbagi kebahagiaan bersama keluarga.',
                                        ],
                                        [
                                            'title' => 'Silaturahmi Hangat',
                                            'description' => 'Tampilkan detail acara, galeri, amplop digital, dan ucapan tamu dalam satu halaman undangan.',
                                        ],
                                    ];
                                } elseif ($isCorporateTemplate) {
                                    $defaultHighlights = $corporateDefaultHighlights;
                                } else {
                                    $defaultHighlights = [
                                        [
                                            'title' => 'Materi Terarah',
                                            'description' => 'Bahasan acara dibuat ringkas, relevan, dan mudah dipahami peserta.',
                                        ],
                                        [
                                            'title' => 'Pembicara Kompeten',
                                            'description' => 'Tampilkan narasumber, moderator, mentor, atau tokoh utama acara.',
                                        ],
                                        [
                                            'title' => 'RSVP Peserta',
                                            'description' => 'Peserta dapat mengirim ucapan, konfirmasi hadir, dan jumlah tamu.',
                                        ],
                                    ];
                                }

                                $eventHighlights = old(
                                    'event_highlights',
                                    is_null($invitation->event_highlights) ? $defaultHighlights : $invitation->event_highlights
                                );
                            @endphp

                            <div id="highlight-list"
                                class="space-y-4"
                                data-max-highlights="12"
                                data-default-highlights='@json($defaultHighlights)'>
                                @foreach ($eventHighlights as $index => $highlight)
                                    <div class="highlight-item rounded-2xl border border-slate-200 p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="font-bold">
                                                {{ $highlightItemLabel }} {{ $index + 1 }}
                                            </h3>

                                            <button type="button" class="remove-highlight text-red-500 text-sm">
                                                Hapus
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="uk-label">Judul Poin</label>
                                                <input type="text"
                                                    name="event_highlights[{{ $index }}][title]"
                                                    value="{{ $highlight['title'] ?? '' }}"
                                                    class="uk-input mt-1"
                                                    placeholder="{{ $highlightTitlePlaceholder }}">
                                            </div>

                                            <div>
                                                <label class="uk-label">Deskripsi Poin</label>
                                                <textarea name="event_highlights[{{ $index }}][description]"
                                                        rows="3"
                                                        class="uk-input uk-break-input mt-1"
                                                        placeholder="{{ $highlightDescriptionPlaceholder }}">{{ $highlight['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <p class="text-xs text-slate-500 mt-4">
                                Maksimal 12 poin. Jika judul dan deskripsi kosong, poin tidak akan ditampilkan.
                            </p>
                        </div>
                    @endif

                    @if ($showPeopleForm)
                        <div class="uk-card p-6">
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <div>
                                    <h2 class="text-xl font-bold">
                                        {{ $feature['people_title'] }}
                                    </h2>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $feature['people_desc'] }}
                                    </p>
                                </div>

                                @if (($feature['people_max'] ?? 1) > ($feature['people_min'] ?? 1))
                                    <button type="button"
                                            id="add-person-btn"
                                            class="px-4 py-2 rounded-xl bg-purple-600 text-white font-semibold whitespace-nowrap">
                                        + Tambah Tokoh
                                    </button>
                                @endif
                            </div>

                            @php
                                $defaultPeople = [];

                                for ($i = 0; $i < ($feature['people_min'] ?? 1); $i++) {
                                    $defaultPeople[] = [
                                        'name' => '',
                                        'subtitle' => '',
                                        'family_name' => '',
                                    ];
                                }

                                $people = old('people', $invitation->people->count()
                                    ? $invitation->people->toArray()
                                    : $defaultPeople
                                );

                                $peopleMax = $feature['people_max'] ?? count($people);
                                $peopleItemLabel = $feature['people_item_label'] ?? 'Tokoh';
                                $isSeminarTemplate = in_array($templateView, [
                                    'seminar-pro',
                                    'seminar-webinar-modern',
                                    'seminar-tech-conference',
                                    'seminar-education-talk',
                                ]);
                            @endphp

                            <div id="people-list"
                                class="grid grid-cols-1 md:grid-cols-2 gap-6"
                                data-min-people="{{ $feature['people_min'] ?? 1 }}"
                                data-max-people="{{ $peopleMax }}"
                                data-item-label="{{ $peopleItemLabel }}"
                                data-template-view="{{ $templateView }}">
                                @foreach ($people as $index => $person)
                                    <div class="person-item rounded-2xl border border-slate-200 p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="font-bold">
                                                {{ $peopleItemLabel }} {{ $index + 1 }}
                                            </h3>

                                            @if ($index >= ($feature['people_min'] ?? 1))
                                                <button type="button" class="remove-person text-red-500 text-sm">
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>

                                        @php
                                            $savedPersonPhoto = $invitation->people[$index]->photo ?? ($person['photo'] ?? null);
                                        @endphp

                                        @if (!empty($savedPersonPhoto))
                                            <img src="{{ asset('storage/' . $savedPersonPhoto) }}"
                                                class="w-28 h-28 object-cover rounded-xl mb-4"
                                                alt="Foto">

                                            <input type="hidden"
                                                name="people[{{ $index }}][existing_photo]"
                                                value="{{ $savedPersonPhoto }}">
                                        @endif

                                        <div class="mb-4">
                                            <label class="uk-label">Foto</label>
                                            <input type="file"
                                                name="people_photos[{{ $index }}]"
                                                accept="image/*"
                                                class="w-full border rounded-xl p-3 mt-1 bg-white">

                                            <p class="text-xs text-slate-500 mt-1">
                                                Kosongkan jika ingin tetap memakai foto sebelumnya.
                                            </p>
                                        </div>

                                        @php
                                            $isWeddingCoupleTemplate = in_array($templateView, [
                                                'classic-letter',
                                                'wedding-nusantara',
                                                'wedding-minimal-black-gold',
                                                'wedding-royal-javanese',
                                                'wedding-golden-romance',
                                                'wedding-elegant-white',
                                                'wedding-floral-love',
                                                'wedding-rustic-garden',
                                                'wedding-green-garden',
                                                'wedding-classic-letter',
                                                'wedding-luxury-maroon',
                                                'wedding-vintage-romance',
                                                'wedding-peach-blossom',
                                                'wedding-batik-elegance',
                                                'wedding-modern-couple',
                                                'wedding-emerald-wedding',
                                                'wedding-soft-sakura',
                                                'wedding-ocean-love',
                                                'wedding-pastel-wedding',
                                                'wedding-simple-nikah',
                                            ]);
                                        @endphp

                                        <div class="mb-4">
                                            <label class="uk-label">
                                                {{ $isWeddingCoupleTemplate ? 'Nama Pengantin / Tokoh' : 'Nama' }}
                                            </label>

                                            <input type="text"
                                                name="people[{{ $index }}][name]"
                                                value="{{ $person['name'] ?? '' }}"
                                                class="uk-input mt-1"
                                                placeholder="{{ $isWeddingCoupleTemplate
                                                    ? ($index === 0 ? 'Contoh: Aisha Putri' : 'Contoh: Rangga Pratama')
                                                    : 'Contoh: Alya, Naufal, Raka' }}">
                                        </div>

                                        <div class="mb-4">
                                            <label class="uk-label">
                                                {{ $isWeddingCoupleTemplate ? 'Keterangan Pengantin' : 'Keterangan kecil' }}
                                            </label>

                                            <input type="text"
                                                name="people[{{ $index }}][subtitle]"
                                                value="{{ $person['subtitle'] ?? '' }}"
                                                class="uk-input mt-1"
                                                placeholder="{{ $isWeddingCoupleTemplate
                                                    ? ($index === 0 ? 'Contoh: Mempelai Wanita' : 'Contoh: Mempelai Pria')
                                                    : 'Contoh: Birthday Star / Turns 8 / Anak Ceria' }}">
                                        </div>

                                        @if (! $isSeminarTemplate)
                                            <div>
                                                <label class="uk-label">
                                                    {{ $isCorporateTemplate
                                                        ? 'Keterangan Peran / Agenda'
                                                        : ($isWeddingCoupleTemplate ? 'Nama Orang Tua / Keluarga' : 'Nama keluarga / orang tua') }}
                                                </label>

                                                <input type="text"
                                                    name="people[{{ $index }}][family_name]"
                                                    value="{{ $person['family_name'] ?? '' }}"
                                                    class="uk-input mt-1"
                                                    placeholder="{{ $isBusinessOpeningTemplate
                                                        ? 'Contoh: Opening Speech / Ribbon Cutting / Guest Relations'
                                                        : ($isCorporateTemplate
                                                            ? 'Contoh: Opening Keynote / Product Demo / Partnership Session'
                                                            : ($isWeddingCoupleTemplate
                                                                ? ($index === 0 ? 'Contoh: Putri dari Bapak Ahmad & Ibu Siti' : 'Contoh: Putra dari Bapak Budi & Ibu Dewi')
                                                                : 'Contoh: Putra dari Bapak Andi & Ibu Rina')) }}">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <p class="text-xs text-slate-500 mt-4">
                                Maksimal {{ $peopleMax }} {{ strtolower($peopleItemLabel) }} untuk template ini.
                            </p>
                        </div>
                    @endif

                    <div class="uk-card p-6">
                        <h2 class="text-xl font-bold mb-4">
                            Galeri Foto Tambahan
                        </h2>

                        @php
                            $maxGalleryPhotos = 6;
                            $currentGalleryCount = $invitation->photos->count();
                            $remainingGallerySlots = max(0, $maxGalleryPhotos - $currentGalleryCount);
                        @endphp

                        <div>
                            <label class="uk-label">Upload Foto Galeri</label>
                            <input
                                type="file"
                                name="gallery_images[]"
                                accept="image/*"
                                multiple
                                {{ $remainingGallerySlots <= 0 ? 'disabled' : '' }}
                                class="w-full border rounded-xl p-3 mt-1 bg-white {{ $remainingGallerySlots <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            >

                            <p class="text-xs text-gray-500 mt-2">
                                Maksimal {{ $maxGalleryPhotos }} foto. Saat ini sudah ada {{ $currentGalleryCount }} foto.
                                Sisa upload: {{ $remainingGallerySlots }} foto. Ukuran 10 MB per foto.
                            </p>

                            @if ($remainingGallerySlots <= 0)
                                <div class="mt-3 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-sm text-orange-700">
                                    Galeri sudah mencapai batas maksimal. Hapus beberapa foto lama terlebih dahulu jika ingin upload foto baru.
                                </div>
                            @endif
                        </div>

                        @if ($invitation->photos->count())
                            <div id="gallery-preview-box" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                                @foreach ($invitation->photos as $photo)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $photo->image_path) }}"
                                            class="w-full h-32 object-cover rounded-xl"
                                            alt="Foto Galeri">

                                        <button type="button"
                                                class="delete-photo-btn absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-1 rounded-lg transition"
                                                data-form-id="delete-photo-{{ $photo->id }}">
                                            Hapus
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="uk-card p-6">
                        <h2 class="text-xl font-bold mb-2">
                            Detail Waktu & Lokasi
                        </h2>

                        <p class="text-sm text-slate-500 mb-5">
                            Isi tanggal dan jam mulai acara. Tanggal sampai dan jam selesai bersifat opsional.
                        </p>

                        <div class="mt-2 mb-4 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <span class="text-red-500 font-bold">*</span>
                                <span>Wajib diisi</span>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="uk-label">Tanggal Mulai</label>
                                <input
                                    type="date"
                                    name="event_date"
                                    value="{{ old('event_date', $invitation->event_date ? \Carbon\Carbon::parse($invitation->event_date)->format('Y-m-d') : '') }}"
                                    class="uk-input mt-1"
                                >
                            </div>

                            <div>
                                <label class="uk-label">Jam Mulai</label>

                                <div class="flex gap-2 mt-1">
                                    <input
                                        type="time"
                                        name="event_time"
                                        id="event-time-input"
                                        value="{{ old('event_time', $invitation->event_time ? \Carbon\Carbon::parse($invitation->event_time)->format('H:i') : '') }}"
                                        class="uk-input flex-1"
                                    >

                                    <button
                                        type="button"
                                        id="clear-event-time"
                                        class="px-4 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold hover:bg-slate-50 transition"
                                    >
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="uk-label">Tanggal Selesai / Sampai</label>
                                <input
                                    type="date"
                                    name="event_end_date"
                                    value="{{ old('event_end_date', $invitation->event_end_date ? \Carbon\Carbon::parse($invitation->event_end_date)->format('Y-m-d') : '') }}"
                                    class="uk-input mt-1"
                                >

                                <p class="text-xs text-slate-500 mt-1">
                                    Opsional. Kosongkan jika acara hanya satu hari.
                                </p>
                            </div>

                            <div>
                                <label class="uk-label">Jam Selesai</label>

                                <div class="flex gap-2 mt-1">
                                    <input
                                        type="time"
                                        id="event-end-time-input"
                                        name="event_end_time"
                                        value="{{ old('event_end_time', $invitation->event_end_time ? \Carbon\Carbon::parse($invitation->event_end_time)->format('H:i') : '') }}"
                                        class="uk-input"
                                    >

                                    <button
                                        type="button"
                                        id="clear-end-time-btn"
                                        class="px-4 rounded-2xl border border-slate-200 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200 text-slate-600 font-semibold transition"
                                    >
                                        Clear
                                    </button>
                                </div>

                                <p class="text-xs text-slate-500 mt-1">
                                    Opsional. Klik Clear jika tidak ingin menampilkan jam selesai.
                                </p>
                            </div>
                        </div>

                        @if ($canChooseEventMode)
                            @php
                                $selectedEventMode = old('event_mode', $invitation->event_mode ?: 'offline');
                            @endphp

                            <div class="mt-4">
                                <label class="uk-label">Mode Acara</label>

                                <select name="event_mode"
                                        id="event-mode-select"
                                        class="uk-input mt-1">
                                    <option value="offline" {{ $selectedEventMode === 'offline' ? 'selected' : '' }}>
                                        Offline
                                    </option>
                                    <option value="online" {{ $selectedEventMode === 'online' ? 'selected' : '' }}>
                                        Online
                                    </option>
                                </select>

                                <p class="text-xs text-slate-500 mt-1">
                                    Pilihan Online hanya tersedia untuk acara Seminar, Wisuda, atau Corporate.
                                </p>
                            </div>

                            <div id="online-url-field" class="mt-4">
                                <label class="uk-label">Link Webinar / Google Meet / Zoom <span class="text-red-500 font-bold">*</span></label>

                                <input
                                    type="text"
                                    name="online_url"
                                    value="{{ old('online_url', $invitation->online_url) }}"
                                    class="uk-input mt-1"
                                    placeholder="Contoh: https://meet.google.com/xxx-xxxx-xxx atau link Zoom"
                                >

                                <p class="text-xs text-slate-500 mt-1">
                                    Untuk mode Online, cukup isi link meeting/webinar. Nama lokasi, alamat, dan Google Maps tidak perlu diisi.
                                </p>
                            </div>
                        @else
                            <input type="hidden" name="event_mode" value="offline">
                        @endif

                        @php
                            $isOnlineOfflineTemplate = $canChooseEventMode;
                        @endphp

                        <div id="offline-location-fields">
                            <div class="mt-4">
                                <label class="uk-label">
                                    {{ $isOnlineOfflineTemplate ? 'Nama Lokasi / Platform' : 'Nama Lokasi' }} <span class="text-red-500 font-bold">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="location_name"
                                    value="{{ old('location_name', $invitation->location_name) }}"
                                    class="uk-input mt-1"
                                    placeholder="{{ $isOnlineOfflineTemplate ? 'Contoh: Zoom Meeting, Google Meet, Aula Kampus, Convention Center' : 'Contoh: Gedung Graha, Cafe Luna, Aula Kampus' }}"
                                >

                                @if ($isOnlineOfflineTemplate)
                                    <p class="text-xs text-slate-500 mt-1">
                                        Jika mode online, isi dengan platform seperti Zoom Meeting atau Google Meet.
                                        Jika offline, isi dengan nama venue atau lokasi acara.
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <label class="uk-label">
                                    {{ $isOnlineOfflineTemplate ? 'Keterangan / Alamat' : 'Alamat Lengkap' }} <span class="text-red-500 font-bold">*</span>
                                </label>

                                <textarea
                                    name="address"
                                    rows="4"
                                    class="uk-input uk-break-input mt-1"
                                    placeholder="{{ $isOnlineOfflineTemplate ? 'Contoh: Link akan dibagikan sebelum acara / alamat venue jika offline' : 'Tulis alamat lengkap acara...' }}"
                                >{{ old('address', $invitation->address) }}</textarea>

                                @if ($isOnlineOfflineTemplate)
                                    <p class="text-xs text-slate-500 mt-1">
                                        Untuk online bisa diisi keterangan tambahan. Untuk offline isi alamat lengkap acara.
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <label class="uk-label">
                                    {{ $isOnlineOfflineTemplate ? 'Link Google Maps Khusus Offline' : 'Link Google Maps' }} <span class="text-red-500 font-bold">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="maps_url"
                                    value="{{ old('maps_url', $invitation->maps_url) }}"
                                    class="uk-input mt-1"
                                    placeholder="Tempel link Google Maps di sini"
                                >

                                @if ($isOnlineOfflineTemplate)
                                    <p class="text-xs text-slate-500 mt-1">
                                        Kosongkan jika acara online. Isi hanya jika acara offline atau hybrid.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($showGiftForm)
                        @php
                            $corporateGiftProfiles = [
                                'corporate-product-launch' => [
                                    'section_title' => 'Support / Partner / Product Info',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner, sponsor, contact product, link katalog, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Product Info / Partner',
                                    'label_text' => 'Nama Partner / Product Info',
                                    'label_placeholder' => 'Misal: Product Partner / Media Launch / Link Katalog',
                                    'number_label' => 'Kontak / Link Katalog / Product Page',
                                    'number_placeholder' => 'Contoh: product@company.com / https://company.com/product',
                                    'name_label' => 'Nama Brand / PIC Product',
                                    'name_placeholder' => 'Contoh: Nusantara Product Team / Raka Pratama',
                                ],
                                'corporate-business-opening' => [
                                    'section_title' => 'Support / Partner / Kontak Opening',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner pembukaan bisnis, sponsor, contact desk, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Opening',
                                    'label_text' => 'Nama Partner / Support Opening',
                                    'label_placeholder' => 'Misal: Opening Partner / Venue Partner / Contact Desk',
                                    'number_label' => 'Kontak / Link / Informasi Support',
                                    'number_placeholder' => 'Contoh: opening@company.com / https://company.com',
                                    'name_label' => 'Nama Brand / PIC Opening',
                                    'name_placeholder' => 'Contoh: Nusantara Business Center / Raka Pratama',
                                ],
                                'corporate-company-gathering' => [
                                    'section_title' => 'Support / Partner / Kontak Gathering',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner gathering, sponsor, contact person, link informasi acara, atau support tanpa menambah form baru.',
                                    'item_title' => 'Support Gathering',
                                    'label_text' => 'Nama Partner / Support Gathering',
                                    'label_placeholder' => 'Misal: Gathering Partner / Sponsor / Contact Person',
                                    'number_label' => 'Kontak / Link Info Gathering',
                                    'number_placeholder' => 'Contoh: gathering@company.com / https://company.com/gathering',
                                    'name_label' => 'Nama Brand / PIC Gathering',
                                    'name_placeholder' => 'Contoh: Nusantara Gathering Team / Raka Pratama',
                                ],
                                'corporate-formal-invitation' => [
                                    'section_title' => 'Support / Partner / Kontak Formal',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner formal, sponsor, contact desk, sekretariat acara, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Formal',
                                    'label_text' => 'Nama Partner / Support Formal',
                                    'label_placeholder' => 'Misal: Formal Partner / Sponsor / Secretariat Desk',
                                    'number_label' => 'Kontak / Link Info Formal',
                                    'number_placeholder' => 'Contoh: secretary@company.com / https://company.com/formal-event',
                                    'name_label' => 'Nama Brand / PIC Formal',
                                    'name_placeholder' => 'Contoh: Nusantara Executive Group / Nadia Kirana',
                                ],
                                'corporate-startup-event' => [
                                    'section_title' => 'Support / Partner / Kontak Startup',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner startup, sponsor, contact event, link komunitas, pitch deck, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Startup',
                                    'label_text' => 'Nama Partner / Support Startup',
                                    'label_placeholder' => 'Misal: Startup Partner / Investor Relation / Community Partner',
                                    'number_label' => 'Kontak / Link Startup / Pitch Deck',
                                    'number_placeholder' => 'Contoh: startup@company.com / https://company.com/pitchdeck',
                                    'name_label' => 'Nama Brand / PIC Startup',
                                    'name_placeholder' => 'Contoh: Nusantara Startup Lab / Raka Pratama',
                                ],
                                'corporate-grand-opening-pro' => [
                                    'section_title' => 'Support / Partner / Kontak Grand Opening',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner grand opening, sponsor, contact desk, link booking, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Grand Opening',
                                    'label_text' => 'Nama Partner / Support Grand Opening',
                                    'label_placeholder' => 'Misal: Venue Partner / Sponsor / Contact Desk',
                                    'number_label' => 'Kontak / Link Info Grand Opening',
                                    'number_placeholder' => 'Contoh: opening@company.com / https://company.com/grand-opening',
                                    'name_label' => 'Nama Brand / PIC Grand Opening',
                                    'name_placeholder' => 'Contoh: Nusantara Opening Team / Raka Pratama',
                                ],
                                'corporate-award-night' => [
                                    'section_title' => 'Support / Partner / Kontak Award Night',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner award night, sponsor, contact desk, link nominasi, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Award Night',
                                    'label_text' => 'Nama Partner / Support Award Night',
                                    'label_placeholder' => 'Misal: Award Partner / Sponsor / Gala Desk',
                                    'number_label' => 'Kontak / Link Info Award Night',
                                    'number_placeholder' => 'Contoh: award@company.com / https://company.com/award-night',
                                    'name_label' => 'Nama Brand / PIC Award Night',
                                    'name_placeholder' => 'Contoh: Nusantara Award Team / Nadia Kirana',
                                ],
                                'corporate-business-seminar' => [
                                    'section_title' => 'Support / Partner / Kontak Seminar',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner seminar, sponsor, contact person, link materi, link pendaftaran, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Business Seminar',
                                    'label_text' => 'Nama Partner / Support Seminar',
                                    'label_placeholder' => 'Misal: Seminar Partner / Sponsor / Registration Desk',
                                    'number_label' => 'Kontak / Link Info Seminar',
                                    'number_placeholder' => 'Contoh: seminar@company.com / https://company.com/business-seminar',
                                    'name_label' => 'Nama Brand / PIC Seminar',
                                    'name_placeholder' => 'Contoh: Nusantara Seminar Team / Arman Wijaya',
                                ],
                                'corporate-networking-night' => [
                                    'section_title' => 'Support / Partner / Kontak Networking',
                                    'section_desc' => 'Bagian ini dapat dipakai untuk menampilkan partner networking, sponsor, contact person, link komunitas, atau informasi support tanpa menambah form baru.',
                                    'item_title' => 'Support Networking Night',
                                    'label_text' => 'Nama Partner / Support Networking',
                                    'label_placeholder' => 'Misal: Community Partner / Sponsor / Networking Desk',
                                    'number_label' => 'Kontak / Link Info Networking',
                                    'number_placeholder' => 'Contoh: networking@company.com / https://company.com/networking-night',
                                    'name_label' => 'Nama Brand / PIC Networking',
                                    'name_placeholder' => 'Contoh: Nusantara Networking Team / Raka Pratama',
                                ],
                            ];

                            $corporateGiftProfile = $corporateGiftProfiles[$templateView] ?? null;

                            $giftSectionTitle = $corporateGiftProfile['section_title'] ?? ($isCorporateTemplate ? 'Support / Partner / Kontak' : 'Amplop Digital');
                            $giftSectionDesc = $corporateGiftProfile['section_desc'] ?? ($isCorporateTemplate
                                ? 'Bagian ini dapat dipakai untuk menampilkan partner, sponsor, contact desk, atau informasi support tanpa menambah form baru.'
                                : 'Bisa tambah lebih dari satu rekening, e-wallet, atau alamat kado.');
                            $giftItemTitle = $corporateGiftProfile['item_title'] ?? ($isCorporateTemplate ? 'Support / Partner' : 'Kotak Amplop');
                            $giftLabelText = $corporateGiftProfile['label_text'] ?? ($isCorporateTemplate ? 'Nama Partner / Jenis Support' : 'Keterangan');
                            $giftLabelPlaceholder = $corporateGiftProfile['label_placeholder'] ?? ($isCorporateTemplate ? 'Misal: Strategic Partner / Media Partner / Contact Desk' : 'Misal: Bank BCA / E-Wallet / Alamat Kado');
                            $giftNumberLabel = $corporateGiftProfile['number_label'] ?? ($isCorporateTemplate ? 'Kontak / Link / Kode Partner' : 'Nomor ATM / Nomor Rekening');
                            $giftNumberPlaceholder = $corporateGiftProfile['number_placeholder'] ?? ($isCorporateTemplate ? 'Contoh: partnership@company.com / https://company.com' : 'Contoh: 1234567890');
                            $giftNameLabel = $corporateGiftProfile['name_label'] ?? ($isCorporateTemplate ? 'Nama Brand / PIC' : 'Atas Nama');
                            $giftNamePlaceholder = $corporateGiftProfile['name_placeholder'] ?? ($isCorporateTemplate ? 'Contoh: Spektakuler Creative Group / Raka Pratama' : 'Contoh: Pengguna Rekening atau Nama Penerima Kado');
                        @endphp

                        <div class="uk-card p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-xl font-bold">
                                        {{ $giftSectionTitle }}
                                    </h2>

                                    <p class="text-sm text-slate-500">
                                        {{ $giftSectionDesc }}
                                    </p>
                                </div>

                                <button type="button"
                                        id="add-gift-btn"
                                        class="px-4 py-2 rounded-xl bg-purple-600 text-white font-semibold">
                                    {{ $isCorporateTemplate ? '+ Tambah Support' : '+ Tambah Kotak' }}
                                </button>
                            </div>

                            <div id="gift-list" class="space-y-4">
                                @php
                                    $gifts = old('gifts', $invitation->gifts->count() ? $invitation->gifts->toArray() : [
                                        ['label' => '', 'account_number' => '', 'account_name' => '']
                                    ]);
                                @endphp

                                @foreach ($gifts as $index => $gift)
                                    <div class="gift-item rounded-2xl border border-slate-200 p-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="font-bold">
                                                {{ $giftItemTitle }} {{ $index + 1 }}
                                            </h3>

                                            <button type="button" class="remove-gift text-red-500 text-sm">
                                                Hapus
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="uk-label">{{ $giftLabelText }}</label>
                                                <input type="text"
                                                    name="gifts[{{ $index }}][label]"
                                                    value="{{ $gift['label'] ?? '' }}"
                                                    class="uk-input mt-1"
                                                    placeholder="{{ $giftLabelPlaceholder }}">
                                            </div>

                                            <div>
                                                <label class="uk-label">{{ $giftNumberLabel }}</label>
                                                <input type="text"
                                                    name="gifts[{{ $index }}][account_number]"
                                                    value="{{ $gift['account_number'] ?? '' }}"
                                                    class="uk-input mt-1"
                                                    placeholder="{{ $giftNumberPlaceholder }}">
                                            </div>

                                            <div>
                                                <label class="uk-label">{{ $giftNameLabel }}</label>
                                                <input type="text"
                                                    name="gifts[{{ $index }}][account_name]"
                                                    value="{{ $gift['account_name'] ?? '' }}"
                                                    class="uk-input mt-1"
                                                    placeholder="{{ $giftNamePlaceholder }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                <section class="order-1 md:order-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4 md:p-6 md:sticky md:top-24">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">
                                    Preview Undangan
                                </h2>

                                <p class="text-xs text-slate-500 mt-1">
                                    Preview ini memakai template asli.
                                </p>
                            </div>

                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                Setelah disimpan
                            </span>
                        </div>

                        <div class="bg-slate-900 rounded-[2rem] p-2 md:p-3">
                            <div class="bg-white rounded-[1.5rem] overflow-hidden h-[520px] md:h-[720px]">
                                <iframe
                                    src="{{ route('editor.preview', $invitation) }}"
                                    class="w-full h-full border-0"
                                    loading="lazy">
                                </iframe>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <a href="{{ route('editor.preview', $invitation) }}"
                            target="_blank"
                            class="text-center bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 rounded-xl">
                                Lihat Preview
                            </a>

                            <a href="{{ route('invitation.public', $invitation->slug) }}"
                            target="_blank"
                            class="text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl">
                                Lihat Undangan Publik
                            </a>
                        </div>

                        <p class="text-sm text-gray-500 mt-4 text-center">
                            Klik “Simpan Draft” agar perubahan form masuk ke preview.
                        </p>

                        @if ($invitation->status === 'active')
                        <div class="mt-5 rounded-3xl border border-purple-100 bg-gradient-to-br from-purple-50 via-white to-slate-50 p-5 text-sm shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-purple-100 text-purple-700">
                                    🔗
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="font-extrabold text-slate-900">
                                        Link Undangan Siap Dibagikan
                                    </p>

                                    <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                        Gunakan link ini untuk dibagikan ke tamu. Link memakai kode acak dan tidak menampilkan nama acara atau nama pelanggan.
                                    </p>

                                    <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-3">
                                        <p class="truncate text-xs font-semibold text-slate-500">
                                            {{ route('invitation.public', $invitation->slug) }}
                                        </p>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 gap-2 md:grid-cols-2">
                                        <a href="{{ route('invitation.public', $invitation->slug) }}"
                                        target="_blank"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 font-bold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                                            <span>↗</span>
                                            <span>Buka Link</span>
                                        </a>

                                        <button type="button"
                                            data-copy-public-link="{{ route('invitation.public', $invitation->slug) }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-3 font-bold text-white shadow-sm transition hover:bg-emerald-700">
                                            <span><img src="{{ asset('assets/icons/copy.png') }}"
                                                    alt="Salin"
                                                    class="w-3 h-3"></span>
                                            <span>Salin Link</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="uk-card p-6 border border-amber-100 bg-amber-50 mt-4">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                                    !
                                </div>

                                <div>
                                    <h2 class="text-lg font-extrabold text-slate-900">
                                        Link Undangan Belum Aktif
                                    </h2>

                                    <p class="text-sm text-slate-600 mt-1 leading-6">
                                        Link publik akan muncul setelah undangan dipublish. Klik tombol <b>Publish</b> di bagian atas jika data undangan sudah siap dibagikan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </section>
            </div>
        </main>
    </form>
    <form id="publish-form"
        method="POST"
        action="{{ route('editor.publish', $invitation) }}">
        @csrf
    </form>
    @foreach ($invitation->photos as $photo)
        <form id="delete-photo-{{ $photo->id }}"
            method="POST"
            action="{{ route('editor.photos.delete', $photo) }}">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    {{-- GLOBAL POPUP / MODAL --}}
    <div id="uiModal" class="ui-modal hidden">
        <div class="ui-modal-backdrop"></div>

        <div class="ui-modal-card" role="dialog" aria-modal="true" aria-labelledby="uiModalTitle">
            <div class="ui-modal-icon" id="uiModalIcon">
                !
            </div>

            <div class="ui-modal-content">
                <h3 id="uiModalTitle" class="ui-modal-title">Konfirmasi</h3>
                <p id="uiModalMessage" class="ui-modal-message">
                    Apakah Anda yakin?
                </p>
            </div>

            <div class="ui-modal-actions">
                <button type="button" id="uiModalCancel" class="ui-btn ui-btn-light">
                    Batal
                </button>
                <button type="button" id="uiModalConfirm" class="ui-btn ui-btn-primary">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    {{-- TOAST NOTIFICATION --}}
    <div id="uiToastWrap" class="ui-toast-wrap"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const uiModal = document.getElementById('uiModal');
        const uiModalTitle = document.getElementById('uiModalTitle');
        const uiModalMessage = document.getElementById('uiModalMessage');
        const uiModalConfirm = document.getElementById('uiModalConfirm');
        const uiModalCancel = document.getElementById('uiModalCancel');
        const uiModalIcon = document.getElementById('uiModalIcon');
        const uiToastWrap = document.getElementById('uiToastWrap');

        let uiModalResolver = null;

        function openModal({
            title = 'Konfirmasi',
            message = 'Apakah Anda yakin?',
            type = 'info',
            confirmText = 'Ya, Lanjutkan',
            cancelText = 'Batal',
            confirmClass = 'ui-btn-primary',
            showCancel = true,
            iconText = '!'
        } = {}) {
            return new Promise(function (resolve) {
                uiModalResolver = resolve;

                uiModalTitle.textContent = title;
                uiModalMessage.textContent = message;

                uiModalConfirm.textContent = confirmText;
                uiModalCancel.textContent = cancelText;
                uiModalCancel.style.display = showCancel ? 'inline-flex' : 'none';

                uiModalIcon.className = 'ui-modal-icon ' + type;
                uiModalIcon.textContent = iconText;

                uiModalConfirm.className = 'ui-btn ' + confirmClass;
                uiModal.classList.remove('hidden');
            });
        }

        function closeModal(result = false) {
            uiModal.classList.add('hidden');

            if (typeof uiModalResolver === 'function') {
                uiModalResolver(result);
                uiModalResolver = null;
            }
        }

        if (uiModalConfirm) {
            uiModalConfirm.addEventListener('click', function () {
                closeModal(true);
            });
        }

        if (uiModalCancel) {
            uiModalCancel.addEventListener('click', function () {
                closeModal(false);
            });
        }

        if (uiModal) {
            uiModal.addEventListener('click', function (event) {
                if (event.target.classList.contains('ui-modal-backdrop')) {
                    closeModal(false);
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (uiModal && !uiModal.classList.contains('hidden') && event.key === 'Escape') {
                closeModal(false);
            }
        });

        function showConfirm(options = {}) {
            return openModal({
                type: options.type || 'warning',
                iconText: options.iconText || '!',
                confirmClass: options.confirmClass || 'ui-btn-primary',
                ...options
            });
        }

        function showAlert(options = {}) {
            return openModal({
                title: options.title || 'Informasi',
                message: options.message || '',
                type: options.type || 'info',
                iconText: options.iconText || 'i',
                confirmText: options.confirmText || 'Oke',
                showCancel: false,
                confirmClass: options.confirmClass || 'ui-btn-primary'
            });
        }

        function showToast({
            title = 'Berhasil',
            message = '',
            type = 'success',
            duration = 3000
        } = {}) {
            if (!uiToastWrap) {
                return;
            }

            const toast = document.createElement('div');
            toast.className = 'ui-toast ' + type;

            let icon = 'i';

            if (type === 'success') icon = '✓';
            if (type === 'error') icon = '✕';
            if (type === 'warning') icon = '!';
            if (type === 'info') icon = 'i';

            toast.innerHTML = `
                <div class="ui-toast-icon">${icon}</div>
                <div class="ui-toast-body">
                    <p class="ui-toast-title">${title}</p>
                    <p class="ui-toast-message">${message}</p>
                </div>
            `;

            uiToastWrap.appendChild(toast);

            setTimeout(function () {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                toast.style.transition = 'all .2s ease';

                setTimeout(function () {
                    toast.remove();
                }, 220);
            }, duration);
        }

        @if (session('success'))
            showToast({
                title: 'Berhasil',
                message: @json(session('success')),
                type: 'success',
                duration: 3500
            });
        @endif

        @if (session('error'))
            showAlert({
                title: 'Gagal',
                message: @json(session('error')),
                type: 'error',
                iconText: '✕',
                confirmClass: 'ui-btn-danger'
            });
        @endif

        @if ($errors->any())
            showAlert({
                title: 'Ada Data yang Belum Sesuai',
                message: 'Mohon periksa kembali isian form. Beberapa data masih belum valid.',
                type: 'warning',
                iconText: '!',
                confirmText: 'Periksa Form'
            });
        @endif

        const addGiftBtn = document.getElementById('add-gift-btn');
        const giftList = document.getElementById('gift-list');
        const addPersonBtn = document.getElementById('add-person-btn');
        const peopleList = document.getElementById('people-list');
        const addHighlightBtn = document.getElementById('add-highlight-btn');
        const highlightList = document.getElementById('highlight-list');
        const resetEditorBtn = document.getElementById('reset-editor-btn');
        const resetDeleteGalleryInput = document.getElementById('reset-delete-gallery-input');
        const deleteCoverCheckbox = document.getElementById('delete-cover-checkbox');
        const coverPreviewBox = document.getElementById('cover-preview-box');
        const galleryPreviewBox = document.getElementById('gallery-preview-box');
        const eventModeSelect = document.getElementById('event-mode-select');
        const onlineUrlField = document.getElementById('online-url-field');
        const offlineLocationFields = document.getElementById('offline-location-fields');
        const editorTemplateView = @json($templateView);
        const editorIsCorporateTemplate = editorTemplateView.startsWith('corporate-');
        const editorIsProductLaunchTemplate = editorTemplateView === 'corporate-product-launch';
        const editorIsBusinessOpeningTemplate = editorTemplateView === 'corporate-business-opening';
        const editorIsCompanyGatheringTemplate = editorTemplateView === 'corporate-company-gathering';
        const editorIsFormalInvitationTemplate = editorTemplateView === 'corporate-formal-invitation';
        const editorIsStartupEventTemplate = editorTemplateView === 'corporate-startup-event';
        const editorIsGrandOpeningProTemplate = editorTemplateView === 'corporate-grand-opening-pro';
        const editorIsAwardNightTemplate = editorTemplateView === 'corporate-award-night';
        const editorIsBusinessSeminarTemplate = editorTemplateView === 'corporate-business-seminar';
        const editorIsNetworkingNightTemplate = editorTemplateView === 'corporate-networking-night';

        const giftEditorProfiles = {
            'corporate-product-launch': {
                titlePrefix: "Product Info / Partner",
                label: "Nama Partner / Product Info",
                labelPlaceholder: "Misal: Product Partner / Media Launch / Link Katalog",
                numberLabel: "Kontak / Link Katalog / Product Page",
                numberPlaceholder: "Contoh: product@company.com / https://company.com/product",
                nameLabel: "Nama Brand / PIC Product",
                namePlaceholder: "Contoh: Nusantara Product Team / Raka Pratama",
            },
            'corporate-business-opening': {
                titlePrefix: "Support Opening",
                label: "Nama Partner / Support Opening",
                labelPlaceholder: "Misal: Opening Partner / Venue Partner / Contact Desk",
                numberLabel: "Kontak / Link / Informasi Support",
                numberPlaceholder: "Contoh: opening@company.com / https://company.com",
                nameLabel: "Nama Brand / PIC Opening",
                namePlaceholder: "Contoh: Nusantara Business Center / Raka Pratama",
            },
            'corporate-company-gathering': {
                titlePrefix: "Support Gathering",
                label: "Nama Partner / Support Gathering",
                labelPlaceholder: "Misal: Gathering Partner / Sponsor / Contact Person",
                numberLabel: "Kontak / Link Info Gathering",
                numberPlaceholder: "Contoh: gathering@company.com / https://company.com/gathering",
                nameLabel: "Nama Brand / PIC Gathering",
                namePlaceholder: "Contoh: Nusantara Gathering Team / Raka Pratama",
            },
            'corporate-formal-invitation': {
                titlePrefix: "Support Formal",
                label: "Nama Partner / Support Formal",
                labelPlaceholder: "Misal: Formal Partner / Sponsor / Secretariat Desk",
                numberLabel: "Kontak / Link Info Formal",
                numberPlaceholder: "Contoh: secretary@company.com / https://company.com/formal-event",
                nameLabel: "Nama Brand / PIC Formal",
                namePlaceholder: "Contoh: Nusantara Executive Group / Nadia Kirana",
            },
            'corporate-startup-event': {
                titlePrefix: "Support Startup",
                label: "Nama Partner / Support Startup",
                labelPlaceholder: "Misal: Startup Partner / Investor Relation / Community Partner",
                numberLabel: "Kontak / Link Startup / Pitch Deck",
                numberPlaceholder: "Contoh: startup@company.com / https://company.com/pitchdeck",
                nameLabel: "Nama Brand / PIC Startup",
                namePlaceholder: "Contoh: Nusantara Startup Lab / Raka Pratama",
            },
            'corporate-grand-opening-pro': {
                titlePrefix: "Support Grand Opening",
                label: "Nama Partner / Support Grand Opening",
                labelPlaceholder: "Misal: Venue Partner / Sponsor / Contact Desk",
                numberLabel: "Kontak / Link Info Grand Opening",
                numberPlaceholder: "Contoh: opening@company.com / https://company.com/grand-opening",
                nameLabel: "Nama Brand / PIC Grand Opening",
                namePlaceholder: "Contoh: Nusantara Opening Team / Raka Pratama",
            },
            'corporate-award-night': {
                titlePrefix: "Support Award Night",
                label: "Nama Partner / Support Award Night",
                labelPlaceholder: "Misal: Award Partner / Sponsor / Gala Desk",
                numberLabel: "Kontak / Link Info Award Night",
                numberPlaceholder: "Contoh: award@company.com / https://company.com/award-night",
                nameLabel: "Nama Brand / PIC Award Night",
                namePlaceholder: "Contoh: Nusantara Award Team / Nadia Kirana",
            },
            'corporate-business-seminar': {
                titlePrefix: "Support Business Seminar",
                label: "Nama Partner / Support Seminar",
                labelPlaceholder: "Misal: Seminar Partner / Sponsor / Registration Desk",
                numberLabel: "Kontak / Link Info Seminar",
                numberPlaceholder: "Contoh: seminar@company.com / https://company.com/business-seminar",
                nameLabel: "Nama Brand / PIC Seminar",
                namePlaceholder: "Contoh: Nusantara Seminar Team / Arman Wijaya",
            },
            'corporate-networking-night': {
                titlePrefix: "Support Networking Night",
                label: "Nama Partner / Support Networking",
                labelPlaceholder: "Misal: Community Partner / Sponsor / Networking Desk",
                numberLabel: "Kontak / Link Info Networking",
                numberPlaceholder: "Contoh: networking@company.com / https://company.com/networking-night",
                nameLabel: "Nama Brand / PIC Networking",
                namePlaceholder: "Contoh: Nusantara Networking Team / Raka Pratama",
            },
        };

        function getGiftEditorTexts(indexNumber) {
            const number = indexNumber || 1;
            const profile = giftEditorProfiles[editorTemplateView];

            if (profile) {
                return {
                    title: `${profile.titlePrefix} ${number}`,
                    label: profile.label,
                    labelPlaceholder: profile.labelPlaceholder,
                    numberLabel: profile.numberLabel,
                    numberPlaceholder: profile.numberPlaceholder,
                    nameLabel: profile.nameLabel,
                    namePlaceholder: profile.namePlaceholder
                };
            }

            if (editorIsCorporateTemplate) {
                return { title: `Support / Partner ${number}`, label: 'Nama Partner / Jenis Support', labelPlaceholder: 'Misal: Strategic Partner / Media Partner / Contact Desk', numberLabel: 'Kontak / Link / Kode Partner', numberPlaceholder: 'Contoh: partnership@company.com / https://company.com', nameLabel: 'Nama Brand / PIC', namePlaceholder: 'Contoh: Spektakuler Creative Group / Raka Pratama' };
            }

            return { title: `Kotak Amplop ${number}`, label: 'Keterangan', labelPlaceholder: 'Misal: Bank BCA / E-Wallet / Alamat Kado', numberLabel: 'Nomor ATM / Nomor Rekening', numberPlaceholder: 'Contoh: 1234567890', nameLabel: 'Atas Nama', namePlaceholder: 'Contoh: Pengguna Rekening atau Nama Penerima Kado' };
        }

        function updateEventModeFields() {
            if (!eventModeSelect || !onlineUrlField || !offlineLocationFields) {
                return;
            }

            const isOnline = eventModeSelect.value === 'online';

            onlineUrlField.style.display = isOnline ? 'block' : 'none';
            offlineLocationFields.style.display = isOnline ? 'none' : 'block';

            const offlineInputs = offlineLocationFields.querySelectorAll('input, textarea, select');

            offlineInputs.forEach(function (input) {
                input.disabled = isOnline;
            });
        }

        if (eventModeSelect) {
            updateEventModeFields();
            eventModeSelect.addEventListener('change', updateEventModeFields);
        }

        if (addGiftBtn && giftList) {
            addGiftBtn.addEventListener('click', function () {
                const index = giftList.querySelectorAll('.gift-item').length;
                const giftText = getGiftEditorTexts(index + 1);

                const html = `
                    <div class="gift-item rounded-2xl border border-slate-200 p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold">${giftText.title}</h3>
                            <button type="button" class="remove-gift text-red-500 text-sm">Hapus</button>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="uk-label">${giftText.label}</label>
                                <input type="text" name="gifts[${index}][label]" class="uk-input mt-1" placeholder="${giftText.labelPlaceholder}">
                            </div>

                            <div>
                                <label class="uk-label">${giftText.numberLabel}</label>
                                <input type="text" name="gifts[${index}][account_number]" class="uk-input mt-1" placeholder="${giftText.numberPlaceholder}">
                            </div>

                            <div>
                                <label class="uk-label">${giftText.nameLabel}</label>
                                <input type="text" name="gifts[${index}][account_name]" class="uk-input mt-1" placeholder="${giftText.namePlaceholder}">
                            </div>
                        </div>
                    </div>
                `;

                giftList.insertAdjacentHTML('beforeend', html);
            });

            giftList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-gift')) {
                    e.target.closest('.gift-item').remove();
                }
            });
        }

        if (addPersonBtn && peopleList) {
            addPersonBtn.addEventListener('click', function () {
                const currentItems = peopleList.querySelectorAll('.person-item').length;
                const maxPeople = parseInt(peopleList.dataset.maxPeople || '1', 10);
                const itemLabel = peopleList.dataset.itemLabel || 'Tokoh';
                const templateView = peopleList.dataset.templateView || 'general';

                const isSeminarTemplate = [
                    'seminar-pro',
                    'seminar-webinar-modern',
                    'seminar-tech-conference',
                    'seminar-education-talk'
                ].includes(templateView);

                const isCorporateTemplate = templateView.startsWith('corporate-');
                const isProductLaunchTemplate = templateView === 'corporate-product-launch';
                const isBusinessOpeningTemplate = templateView === 'corporate-business-opening';
                const isCompanyGatheringTemplate = templateView === 'corporate-company-gathering';
                const isFormalInvitationTemplate = templateView === 'corporate-formal-invitation';
                const isStartupEventTemplate = templateView === 'corporate-startup-event';
                const isGrandOpeningProTemplate = templateView === 'corporate-grand-opening-pro';
                const isAwardNightTemplate = templateView === 'corporate-award-night';
                const isBusinessSeminarTemplate = templateView === 'corporate-business-seminar';
                const isNetworkingNightTemplate = templateView === 'corporate-networking-night';

                if (currentItems >= maxPeople) {
                    showToast({
                        title: 'Batas Maksimal',
                        message: `Maksimal ${maxPeople} ${itemLabel.toLowerCase()} untuk template ini.`,
                        type: 'warning'
                    });
                    return;
                }

                const index = currentItems;

                const isWeddingCoupleTemplate = [
                    'classic-letter',
                    'wedding-nusantara',
                    'wedding-minimal-black-gold',
                    'wedding-royal-javanese',
                    'wedding-golden-romance',
                    'wedding-elegant-white',
                    'wedding-floral-love',
                    'wedding-rustic-garden',
                    'wedding-green-garden',
                    'wedding-classic-letter',
                    'wedding-luxury-maroon',
                    'wedding-vintage-romance',
                    'wedding-peach-blossom',
                    'wedding-batik-elegance',
                    'wedding-modern-couple',
                    'wedding-emerald-wedding',
                    'wedding-soft-sakura',
                    'wedding-ocean-love',
                    'wedding-pastel-wedding',
                    'wedding-simple-nikah',
                ].includes(templateView);

                const corporatePeopleProfiles = {
                    'corporate-business-opening': {
                        name: "Contoh: Owner / Founder / General Manager",
                        subtitle: "Contoh: Owner / Director / Operations Manager",
                        family: "Contoh: Opening Speech / Ribbon Cutting / Guest Relations",
                    },
                    'corporate-product-launch': {
                        name: "Contoh: Product Manager / Demo Speaker",
                        subtitle: "Contoh: Chief Product Officer / Product Lead",
                        family: "Contoh: Product Keynote / Live Demo / Market Insight",
                    },
                    'corporate-company-gathering': {
                        name: "Contoh: HR Lead / Ketua Panitia Gathering",
                        subtitle: "Contoh: Human Capital Lead / Event Coordinator",
                        family: "Contoh: Opening Speech / Awarding / Gathering Coordinator",
                    },
                    'corporate-formal-invitation': {
                        name: "Contoh: Direktur / Sekretaris Acara",
                        subtitle: "Contoh: CEO / Corporate Secretary / PR Lead",
                        family: "Contoh: Formal Opening / Executive Session / Guest Relations",
                    },
                    'corporate-startup-event': {
                        name: "Contoh: Founder / Startup Mentor / Product Lead",
                        subtitle: "Contoh: Founder / Growth Lead / Startup Mentor",
                        family: "Contoh: Pitch Session / Growth Talk / Mentor Session",
                    },
                    'corporate-grand-opening-pro': {
                        name: "Contoh: Owner / Founder / Grand Opening Host",
                        subtitle: "Contoh: Owner / Director / Opening Coordinator",
                        family: "Contoh: Ribbon Cutting / Opening Speech / Guest Relations",
                    },
                    'corporate-award-night': {
                        name: "Contoh: Award Recipient / Host / Committee Lead",
                        subtitle: "Contoh: CEO / Award Host / Event Director",
                        family: "Contoh: Award Ceremony / Appreciation Night / Gala Host",
                    },
                    'corporate-business-seminar': {
                        name: "Contoh: Keynote Speaker / Business Mentor",
                        subtitle: "Contoh: CEO / Business Coach / Moderator",
                        family: "Contoh: Keynote Session / Panel Discussion / Business Insight",
                    },
                    'corporate-networking-night': {
                        name: "Contoh: Community Lead / Networking Host",
                        subtitle: "Contoh: Host / Partnership Lead / Community Manager",
                        family: "Contoh: Business Matching / Networking Session / Community Night",
                    },
                };

                const corporatePeopleProfile = corporatePeopleProfiles[templateView] || {
                    name: 'Contoh: Raka Pratama / Nadia Kirana',
                    subtitle: 'Contoh: CEO / Head of Product / Partnership Lead',
                    family: 'Contoh: Opening Keynote / Product Demo / Partnership Session'
                };

                const namePlaceholder = isWeddingCoupleTemplate
                    ? (index === 0 ? 'Contoh: Aisha Putri' : 'Contoh: Rangga Pratama')
                    : isSeminarTemplate
                        ? 'Contoh: Dr. Andika Pratama'
                        : isCorporateTemplate
                            ? corporatePeopleProfile.name
                            : 'Contoh: Alya, Naufal, Raka';

                const subtitlePlaceholder = isWeddingCoupleTemplate
                    ? (index === 0 ? 'Contoh: Mempelai Wanita' : 'Contoh: Mempelai Pria')
                    : isSeminarTemplate
                        ? 'Contoh: Keynote Speaker / Moderator / AI Engineer'
                        : isCorporateTemplate
                            ? corporatePeopleProfile.subtitle
                            : 'Contoh: Birthday Star / Turns 8 / Anak Ceria';

                const familyPlaceholder = isCorporateTemplate
                    ? corporatePeopleProfile.family
                    : isWeddingCoupleTemplate
                        ? (index === 0 ? 'Contoh: Putri dari Bapak Ahmad & Ibu Siti' : 'Contoh: Putra dari Bapak Budi & Ibu Dewi')
                        : 'Contoh: Putra dari Bapak Andi & Ibu Rina';

                const item = document.createElement('div');
                item.className = 'person-item rounded-2xl border border-slate-200 p-4';

                item.innerHTML = `
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold">${itemLabel} ${index + 1}</h3>

                        <button type="button" class="remove-person text-red-500 text-sm">
                            Hapus
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="uk-label">Foto</label>
                        <input type="file"
                            name="people_photos[${index}]"
                            accept="image/*"
                            class="w-full border rounded-xl p-3 mt-1 bg-white">
                    </div>

                    <div class="mb-4">
                        <label class="uk-label">Nama</label>
                        <input type="text"
                            name="people[${index}][name]"
                            class="uk-input mt-1"
                            placeholder="${namePlaceholder}">
                    </div>

                    <div class="mb-4">
                        <label class="uk-label">Keterangan kecil</label>
                        <input type="text"
                            name="people[${index}][subtitle]"
                            class="uk-input mt-1"
                            placeholder="${subtitlePlaceholder}">
                    </div>

                    ${!isSeminarTemplate ? `
                        <div>
                            <label class="uk-label">${isCorporateTemplate ? 'Keterangan Peran / Agenda' : 'Nama keluarga / orang tua'}</label>
                            <input type="text"
                                name="people[${index}][family_name]"
                                class="uk-input mt-1"
                                placeholder="${familyPlaceholder}">
                        </div>
                    ` : ''}
                `;

                peopleList.appendChild(item);
            });

            peopleList.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-person')) {
                    const item = event.target.closest('.person-item');

                    if (item) {
                        item.remove();
                        refreshPersonIndexes();
                    }
                }
            });

            function refreshPersonIndexes() {
                const items = peopleList.querySelectorAll('.person-item');
                const itemLabel = peopleList.dataset.itemLabel || 'Tokoh';

                items.forEach(function (item, index) {
                    const title = item.querySelector('h3');

                    if (title) {
                        title.textContent = `${itemLabel} ${index + 1}`;
                    }

                    const photoInput = item.querySelector('input[type="file"]');
                    const nameInput = item.querySelector('input[name*="[name]"]');
                    const subtitleInput = item.querySelector('input[name*="[subtitle]"]');
                    const familyInput = item.querySelector('input[name*="[family_name]"]');

                    if (photoInput) {
                        photoInput.name = `people_photos[${index}]`;
                    }

                    if (nameInput) {
                        nameInput.name = `people[${index}][name]`;
                    }

                    if (subtitleInput) {
                        subtitleInput.name = `people[${index}][subtitle]`;
                    }

                    if (familyInput) {
                        familyInput.name = `people[${index}][family_name]`;
                    }
                });
            }
        }

        const templateView = "{{ $templateView }}";

        const isSyukuranTemplate = [
            'syukuran-ceria',
            'syukuran-warm',
            'syukuran-doa-bersama',
            'syukuran-soft'
        ].includes(templateView);

        const isAqiqahTemplate = [
            'aqiqah-soft',
            'aqiqah-baby-blessing',
            'aqiqah-little-prince',
            'aqiqah-little-princess',
            'aqiqah-islamic',
        ].includes(templateView);

        const isKhitananTemplate = [
            'khitanan-ceria',
            'khitanan-little-hero',
            'khitanan-fun-party',
            'khitanan-blue',
            'khitanan-islamic',
        ].includes(templateView);

        const isWisudaTemplate = [
            'wisuda-graduation-day',
            'wisuda-golden-graduation',
            'wisuda-campus-pride',
            'wisuda-elegant-graduate',
            'wisuda-simple-graduation',
        ].includes(templateView);

        const isCorporateTemplate = templateView.startsWith('corporate-');
        const isProductLaunchTemplate = templateView === 'corporate-product-launch';
        const isBusinessOpeningTemplate = templateView === 'corporate-business-opening';
        const isCompanyGatheringTemplate = templateView === 'corporate-company-gathering';
        const isFormalInvitationTemplate = templateView === 'corporate-formal-invitation';
        const isStartupEventTemplate = templateView === 'corporate-startup-event';
        const isGrandOpeningProTemplate = templateView === 'corporate-grand-opening-pro';
        const isAwardNightTemplate = templateView === 'corporate-award-night';
        const isBusinessSeminarTemplate = templateView === 'corporate-business-seminar';
        const isNetworkingNightTemplate = templateView === 'corporate-networking-night';

        const highlightEditorProfiles = {
            'corporate-product-launch': {
                itemLabel: "Agenda Product Launch",
                titlePlaceholder: "Contoh: Product Reveal",
                descPlaceholder: "Contoh: Sesi product reveal, live demo, fitur unggulan, market insight, dan networking profesional.",
            },
            'corporate-business-opening': {
                itemLabel: "Agenda Opening",
                titlePlaceholder: "Contoh: Opening Ceremony",
                descPlaceholder: "Contoh: Acara pembukaan bisnis, perkenalan layanan, networking, dan sesi relasi profesional.",
            },
            'corporate-company-gathering': {
                itemLabel: "Agenda Gathering",
                titlePlaceholder: "Contoh: Team Appreciation",
                descPlaceholder: "Contoh: Sesi apresiasi tim, ramah tamah, hiburan, kebersamaan, dan networking perusahaan.",
            },
            'corporate-formal-invitation': {
                itemLabel: "Agenda Formal",
                titlePlaceholder: "Contoh: Executive Session",
                descPlaceholder: "Contoh: Sambutan resmi, presentasi formal, sesi executive, dan networking profesional.",
            },
            'corporate-startup-event': {
                itemLabel: "Agenda Startup",
                titlePlaceholder: "Contoh: Pitch Session",
                descPlaceholder: "Contoh: Pitch session, growth talk, demo produk, mentor session, dan networking startup.",
            },
            'corporate-grand-opening-pro': {
                itemLabel: "Agenda Grand Opening",
                titlePlaceholder: "Contoh: Ribbon Cutting",
                descPlaceholder: "Contoh: Prosesi pembukaan resmi, sambutan, pengenalan bisnis, dan networking bersama tamu undangan.",
            },
            'corporate-award-night': {
                itemLabel: "Agenda Award Night",
                titlePlaceholder: "Contoh: Award Ceremony",
                descPlaceholder: "Contoh: Sesi pemberian penghargaan, apresiasi pencapaian, gala dinner, dan networking profesional.",
            },
            'corporate-business-seminar': {
                itemLabel: "Agenda Business Seminar",
                titlePlaceholder: "Contoh: Business Insight",
                descPlaceholder: "Contoh: Sesi keynote, insight bisnis, panel discussion, studi kasus, dan networking profesional.",
            },
            'corporate-networking-night': {
                itemLabel: "Agenda Networking Night",
                titlePlaceholder: "Contoh: Business Matching",
                descPlaceholder: "Contoh: Sesi networking, business matching, sharing singkat, dan relasi profesional dalam suasana santai.",
            },
        };
        const highlightEditorProfile = highlightEditorProfiles[templateView] || null;

        const pointLabel = isWisudaTemplate
            ? 'Poin Wisuda'
            : (isAqiqahTemplate
                ? 'Poin Aqiqah'
                : (isKhitananTemplate
                    ? 'Poin Khitanan'
                    : (isSyukuranTemplate
                        ? 'Poin Syukuran'
                        : (isCorporateTemplate ? (highlightEditorProfile?.itemLabel || 'Agenda Corporate') : 'Poin Seminar'))));

        function getHighlightPlaceholderTitle() {
            if (isWisudaTemplate) return 'Contoh: Momen Kelulusan';
            if (isAqiqahTemplate) return 'Contoh: Tasyakuran Aqiqah';
            if (isKhitananTemplate) return 'Contoh: Tasyakuran Khitanan';
            if (isSyukuranTemplate) return 'Contoh: Momen Syukur';
            if (isCorporateTemplate) return highlightEditorProfile?.titlePlaceholder || 'Contoh: Business Insight';
            return 'Contoh: Materi Terarah';
        }

        function getHighlightPlaceholderDescription() {
            if (isWisudaTemplate) return 'Contoh: Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih.';
            if (isAqiqahTemplate) return 'Contoh: Momen penuh rasa syukur atas kelahiran buah hati tercinta.';
            if (isKhitananTemplate) return 'Contoh: Acara tasyakuran khitanan sebagai wujud syukur dan doa terbaik untuk ananda.';
            if (isSyukuranTemplate) return 'Contoh: Acara ini menjadi momen untuk berkumpul, bersyukur, dan berbagi kebahagiaan.';
            if (isCorporateTemplate) return highlightEditorProfile?.descPlaceholder || 'Contoh: Sesi business insight, agenda corporate, kolaborasi, dan networking profesional.';
            return 'Contoh: Bahasan acara dibuat ringkas dan relevan.';
        }

        function createHighlightItem(index, highlight = {}) {
            const titleValue = highlight.title ?? '';
            const descriptionValue = highlight.description ?? '';

            return `
                <div class="highlight-item rounded-2xl border border-slate-200 p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold">${pointLabel} ${index + 1}</h3>

                        <button type="button" class="remove-highlight text-red-500 text-sm">
                            Hapus
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="uk-label">Judul Poin</label>
                            <input type="text"
                                name="event_highlights[${index}][title]"
                                value="${escapeHtml(titleValue)}"
                                class="uk-input mt-1"
                                placeholder="${getHighlightPlaceholderTitle()}">
                        </div>

                        <div>
                            <label class="uk-label">Deskripsi Poin</label>
                            <textarea name="event_highlights[${index}][description]"
                                    rows="3"
                                    class="uk-input uk-break-input mt-1"
                                    placeholder="${getHighlightPlaceholderDescription()}">${escapeHtml(descriptionValue)}</textarea>
                        </div>
                    </div>
                </div>
            `;
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function resetHighlightsToDefault() {
            if (!highlightList) {
                return;
            }

            let defaultHighlights = [];

            try {
                defaultHighlights = JSON.parse(highlightList.dataset.defaultHighlights || '[]');
            } catch (error) {
                defaultHighlights = [];
            }

            if (!defaultHighlights.length) {
                showAlert({
                    title: 'Default Highlight Tidak Tersedia',
                    message: 'Data default highlight untuk template ini belum tersedia.',
                    type: 'warning',
                    iconText: '!',
                    confirmText: 'Mengerti'
                });
                return;
            }

            highlightList.innerHTML = '';

            defaultHighlights.forEach(function (highlight, index) {
                highlightList.insertAdjacentHTML('beforeend', createHighlightItem(index, highlight));
            });
        }

        function clearBasicInputs() {
            const editorForm = document.querySelector('form[action="{{ route('editor.update', $invitation) }}"]');

            if (!editorForm) {
                return;
            }

            editorForm.querySelectorAll('input, textarea, select').forEach(function (field) {
                const type = (field.getAttribute('type') || '').toLowerCase();
                const name = field.getAttribute('name') || '';

                // Jangan reset token Laravel dan method PUT
                if (name === '_token' || name === '_method') {
                    return;
                }

                // Jangan reset radio warna tema, karena user mungkin hanya mau reset isi
                if (type === 'radio') {
                    return;
                }

                // File upload: kosongkan file yang baru dipilih
                if (type === 'file') {
                    field.value = '';
                    return;
                }

                // Checkbox seperti delete_cover: matikan
                if (type === 'checkbox') {
                    field.checked = false;
                    return;
                }

                // Select mode acara: kembalikan ke offline agar umum
                if (field.tagName === 'SELECT') {
                    if (field.name === 'event_mode') {
                        field.value = 'offline';
                        field.dispatchEvent(new Event('change'));
                    }
                    return;
                }

                // Kosongkan semua input text/date/time/textarea
                field.value = '';
            });
        }

        function resetPeopleToDefault() {
            if (!peopleList) {
                return;
            }

            const minPeople = parseInt(peopleList.dataset.minPeople || '1', 10);
            const itemLabel = peopleList.dataset.itemLabel || 'Tokoh';
            const templateView = peopleList.dataset.templateView || 'general';
            const isCorporateTemplate = templateView.startsWith('corporate-');
            const isProductLaunchTemplate = templateView === 'corporate-product-launch';
            const isBusinessOpeningTemplate = templateView === 'corporate-business-opening';
            const isCompanyGatheringTemplate = templateView === 'corporate-company-gathering';
            const isFormalInvitationTemplate = templateView === 'corporate-formal-invitation';
            const isStartupEventTemplate = templateView === 'corporate-startup-event';
            const isGrandOpeningProTemplate = templateView === 'corporate-grand-opening-pro';
            const isAwardNightTemplate = templateView === 'corporate-award-night';
            const isBusinessSeminarTemplate = templateView === 'corporate-business-seminar';
            const isNetworkingNightTemplate = templateView === 'corporate-networking-night';

            const isSeminarTemplate = [
                'seminar-pro',
                'seminar-webinar-modern',
                'seminar-tech-conference',
                'seminar-education-talk'
            ].includes(templateView);

            peopleList.innerHTML = '';

            for (let index = 0; index < minPeople; index++) {
                const isWeddingCoupleTemplate = [
                    'classic-letter',
                    'wedding-nusantara',
                    'wedding-minimal-black-gold',
                    'wedding-royal-javanese',
                    'wedding-golden-romance',
                    'wedding-elegant-white',
                    'wedding-floral-love',
                    'wedding-rustic-garden',
                    'wedding-green-garden',
                    'wedding-classic-letter',
                    'wedding-luxury-maroon',
                    'wedding-vintage-romance',
                    'wedding-peach-blossom',
                    'wedding-batik-elegance',
                    'wedding-modern-couple',
                    'wedding-emerald-wedding',
                    'wedding-soft-sakura',
                    'wedding-ocean-love',
                    'wedding-pastel-wedding',
                    'wedding-simple-nikah',
                ].includes(templateView);

                const corporatePeopleProfiles = {
                    'corporate-business-opening': {
                        name: "Contoh: Owner / Founder / General Manager",
                        subtitle: "Contoh: Owner / Director / Operations Manager",
                        family: "Contoh: Opening Speech / Ribbon Cutting / Guest Relations",
                    },
                    'corporate-product-launch': {
                        name: "Contoh: Product Manager / Demo Speaker",
                        subtitle: "Contoh: Chief Product Officer / Product Lead",
                        family: "Contoh: Product Keynote / Live Demo / Market Insight",
                    },
                    'corporate-company-gathering': {
                        name: "Contoh: HR Lead / Ketua Panitia Gathering",
                        subtitle: "Contoh: Human Capital Lead / Event Coordinator",
                        family: "Contoh: Opening Speech / Awarding / Gathering Coordinator",
                    },
                    'corporate-formal-invitation': {
                        name: "Contoh: Direktur / Sekretaris Acara",
                        subtitle: "Contoh: CEO / Corporate Secretary / PR Lead",
                        family: "Contoh: Formal Opening / Executive Session / Guest Relations",
                    },
                    'corporate-startup-event': {
                        name: "Contoh: Founder / Startup Mentor / Product Lead",
                        subtitle: "Contoh: Founder / Growth Lead / Startup Mentor",
                        family: "Contoh: Pitch Session / Growth Talk / Mentor Session",
                    },
                    'corporate-grand-opening-pro': {
                        name: "Contoh: Owner / Founder / Grand Opening Host",
                        subtitle: "Contoh: Owner / Director / Opening Coordinator",
                        family: "Contoh: Ribbon Cutting / Opening Speech / Guest Relations",
                    },
                    'corporate-award-night': {
                        name: "Contoh: Award Recipient / Host / Committee Lead",
                        subtitle: "Contoh: CEO / Award Host / Event Director",
                        family: "Contoh: Award Ceremony / Appreciation Night / Gala Host",
                    },
                    'corporate-business-seminar': {
                        name: "Contoh: Keynote Speaker / Business Mentor",
                        subtitle: "Contoh: CEO / Business Coach / Moderator",
                        family: "Contoh: Keynote Session / Panel Discussion / Business Insight",
                    },
                    'corporate-networking-night': {
                        name: "Contoh: Community Lead / Networking Host",
                        subtitle: "Contoh: Host / Partnership Lead / Community Manager",
                        family: "Contoh: Business Matching / Networking Session / Community Night",
                    },
                };
                const corporatePeopleProfile = corporatePeopleProfiles[templateView] || {
                    name: 'Contoh: Raka Pratama / Nadia Kirana',
                    subtitle: 'Contoh: CEO / Head of Product / Partnership Lead',
                    family: 'Contoh: Opening Keynote / Product Demo / Partnership Session'
                };

                const namePlaceholder = isWeddingCoupleTemplate
                    ? (index === 0 ? 'Contoh: Aisha Putri' : 'Contoh: Rangga Pratama')
                    : isSeminarTemplate
                        ? 'Contoh: Dr. Andika Pratama'
                        : isCorporateTemplate
                            ? corporatePeopleProfile.name
                            : 'Contoh: Alya, Naufal, Raka';

                const subtitlePlaceholder = isWeddingCoupleTemplate
                    ? (index === 0 ? 'Contoh: Mempelai Wanita' : 'Contoh: Mempelai Pria')
                    : isSeminarTemplate
                        ? 'Contoh: Keynote Speaker / Moderator / AI Engineer'
                        : isCorporateTemplate
                            ? corporatePeopleProfile.subtitle
                            : 'Contoh: Birthday Star / Turns 8 / Anak Ceria';

                const familyPlaceholder = isCorporateTemplate
                    ? corporatePeopleProfile.family
                    : isWeddingCoupleTemplate
                        ? (index === 0 ? 'Contoh: Putri dari Bapak Ahmad & Ibu Siti' : 'Contoh: Putra dari Bapak Budi & Ibu Dewi')
                        : 'Contoh: Putra dari Bapak Andi & Ibu Rina';

                const nameLabel = isWeddingCoupleTemplate
                    ? 'Nama Pengantin / Tokoh'
                    : 'Nama';

                const subtitleLabel = isWeddingCoupleTemplate
                    ? 'Keterangan Pengantin'
                    : 'Keterangan kecil';

                const familyLabel = isCorporateTemplate
                    ? 'Keterangan Peran / Agenda'
                    : (isWeddingCoupleTemplate
                        ? 'Nama Orang Tua / Keluarga'
                        : 'Nama keluarga / orang tua');

                const html = `
                    <div class="person-item rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold">${itemLabel} ${index + 1}</h3>
                        </div>

                        <div class="mb-4">
                            <label class="uk-label">Foto</label>
                            <input type="file"
                                name="people_photos[${index}]"
                                accept="image/*"
                                class="w-full border rounded-xl p-3 mt-1 bg-white">
                        </div>

                        <div class="mb-4">
                            <label class="uk-label">${nameLabel}</label>
                            <input type="text"
                                name="people[${index}][name]"
                                class="uk-input mt-1"
                                placeholder="${namePlaceholder}">
                        </div>

                        <div class="mb-4">
                            <label class="uk-label">${subtitleLabel}</label>
                            <input type="text"
                                name="people[${index}][subtitle]"
                                class="uk-input mt-1"
                                placeholder="${subtitlePlaceholder}">
                        </div>

                        ${!isSeminarTemplate ? `
                            <div>
                               <label class="uk-label">${familyLabel}</label>
                                <input type="text"
                                    name="people[${index}][family_name]"
                                    class="uk-input mt-1"
                                    placeholder="${familyPlaceholder}">
                            </div>
                        ` : ''}
                    </div>
                `;

                peopleList.insertAdjacentHTML('beforeend', html);
            }
        }

        function resetGiftsToDefault() {
            if (!giftList) {
                return;
            }

            const giftText = getGiftEditorTexts(1);

            giftList.innerHTML = `
                <div class="gift-item rounded-2xl border border-slate-200 p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold">${giftText.title}</h3>

                        <button type="button" class="remove-gift text-red-500 text-sm">
                            Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="uk-label">${giftText.label}</label>
                            <input type="text"
                                name="gifts[0][label]"
                                class="uk-input mt-1"
                                placeholder="${giftText.labelPlaceholder}">
                        </div>

                        <div>
                            <label class="uk-label">${giftText.numberLabel}</label>
                            <input type="text"
                                name="gifts[0][account_number]"
                                class="uk-input mt-1"
                                placeholder="${giftText.numberPlaceholder}">
                        </div>

                        <div>
                            <label class="uk-label">${giftText.nameLabel}</label>
                            <input type="text"
                                name="gifts[0][account_name]"
                                class="uk-input mt-1"
                                placeholder="${giftText.namePlaceholder}">
                        </div>
                    </div>
                </div>
            `;
        }

        function resetSavedImages() {
            // Hapus cover yang sudah tersimpan saat Simpan Draft ditekan
            if (deleteCoverCheckbox) {
                deleteCoverCheckbox.checked = true;
            }

            // Hapus semua galeri lama saat Simpan Draft ditekan
            if (resetDeleteGalleryInput) {
                resetDeleteGalleryInput.value = '1';
            }

            // Sembunyikan preview cover dari tampilan editor
            if (coverPreviewBox) {
                coverPreviewBox.style.display = 'none';
            }

            // Sembunyikan preview galeri dari tampilan editor
            if (galleryPreviewBox) {
                galleryPreviewBox.style.display = 'none';
            }

            // Kosongkan input upload baru
            document.querySelectorAll('input[type="file"]').forEach(function (input) {
                input.value = '';
            });
        }

        function resetAllEditorInputs() {
            clearBasicInputs();

            // Tandai gambar lama agar ikut dihapus saat Simpan Draft
            resetSavedImages();

            // Highlight kembali ke default template
            resetHighlightsToDefault();

            // People dan gift dibuat kosong/default lagi
            resetPeopleToDefault();
            resetGiftsToDefault();

            // Clear jam selesai
            if (eventEndTimeInput) {
                eventEndTimeInput.value = '';
            }

            // Update tampilan mode acara jika ada
            updateEventModeFields();
        }

        if (resetEditorBtn) {
            resetEditorBtn.addEventListener('click', async function () {
                const confirmReset = await showConfirm({
                    title: 'Reset Form Editor',
                    message: 'Semua perubahan yang belum disimpan akan dikembalikan ke kondisi default template, termasuk teks, highlight, people, gift, cover, dan galeri. Apakah Anda yakin ingin melanjutkan?',
                    type: 'warning',
                    iconText: '↺',
                    confirmText: 'Ya, Reset',
                    cancelText: 'Batal',
                    confirmClass: 'ui-btn-danger'
                });

                if (!confirmReset) {
                    return;
                }

                resetAllEditorInputs();

                showToast({
                    title: 'Reset Diproses',
                    message: 'Form sudah dikembalikan ke default. Klik Simpan Draft untuk menyimpan hasil reset.',
                    type: 'info',
                    duration: 3500
                });
            });
        }

        if (addHighlightBtn && highlightList) {
            addHighlightBtn.addEventListener('click', function () {
                const currentItems = highlightList.querySelectorAll('.highlight-item').length;
                const maxHighlights = parseInt(highlightList.dataset.maxHighlights || '12', 10);

                if (currentItems >= maxHighlights) {
                    showToast({
                        title: 'Batas Maksimal',
                        message: `Maksimal ${maxHighlights} ${pointLabel.toLowerCase()}.`,
                        type: 'warning'
                    });
                    return;
                }

                const index = currentItems;

                const html = createHighlightItem(index, {
                    title: '',
                    description: ''
                });

                highlightList.insertAdjacentHTML('beforeend', html);
            });

            highlightList.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-highlight')) {
                    event.target.closest('.highlight-item').remove();
                    refreshHighlightIndexes();
                }
            });

            function refreshHighlightIndexes() {
                const items = highlightList.querySelectorAll('.highlight-item');

                items.forEach(function (item, index) {
                    const title = item.querySelector('h3');
                    const titleInput = item.querySelector('input[name*="[title]"]');
                    const descInput = item.querySelector('textarea[name*="[description]"]');

                    if (title) {
                        title.textContent = `${pointLabel} ${index + 1}`;
                    }

                    if (titleInput) {
                        titleInput.name = `event_highlights[${index}][title]`;
                    }

                    if (descInput) {
                        descInput.name = `event_highlights[${index}][description]`;
                    }
                });
            }
        }

        document.querySelectorAll('.delete-photo-btn').forEach(function (button) {
            button.addEventListener('click', async function () {
                const formId = this.dataset.formId;
                const form = document.getElementById(formId);

                if (!form) {
                    showAlert({
                        title: 'Form Tidak Ditemukan',
                        message: 'Form hapus foto tidak ditemukan. Silakan refresh halaman dan coba lagi.',
                        type: 'error',
                        iconText: '✕',
                        confirmClass: 'ui-btn-danger'
                    });
                    return;
                }

                const confirmed = await showConfirm({
                    title: 'Hapus Foto Galeri',
                    message: 'Foto ini akan dihapus permanen dari galeri undangan. Apakah Anda yakin ingin melanjutkan?',
                    type: 'danger',
                    iconText: '🗑',
                    confirmText: 'Ya, Hapus',
                    cancelText: 'Batal',
                    confirmClass: 'ui-btn-danger'
                });

                if (!confirmed) {
                    return;
                }

                form.submit();
            });
        });

        const clearEndTimeBtn = document.getElementById('clear-end-time-btn');
        const eventEndTimeInput = document.getElementById('event-end-time-input');

        if (clearEndTimeBtn && eventEndTimeInput) {
            clearEndTimeBtn.addEventListener('click', function () {
                eventEndTimeInput.value = '';
                eventEndTimeInput.dispatchEvent(new Event('change'));
            });
        }
    });
    </script>

        <script>
        const uiModal = document.getElementById('uiModal');
        const uiModalTitle = document.getElementById('uiModalTitle');
        const uiModalMessage = document.getElementById('uiModalMessage');
        const uiModalConfirm = document.getElementById('uiModalConfirm');
        const uiModalCancel = document.getElementById('uiModalCancel');
        const uiModalIcon = document.getElementById('uiModalIcon');
        const uiToastWrap = document.getElementById('uiToastWrap');

        let uiModalResolver = null;

        function openModal({
            title = 'Konfirmasi',
            message = 'Apakah Anda yakin?',
            type = 'info',
            confirmText = 'Ya, Lanjutkan',
            cancelText = 'Batal',
            confirmClass = 'ui-btn-primary',
            showCancel = true,
            iconText = '!'
        } = {}) {
            return new Promise((resolve) => {
                uiModalResolver = resolve;

                uiModalTitle.textContent = title;
                uiModalMessage.textContent = message;

                uiModalConfirm.textContent = confirmText;
                uiModalCancel.textContent = cancelText;
                uiModalCancel.style.display = showCancel ? 'inline-flex' : 'none';

                uiModalIcon.className = 'ui-modal-icon ' + type;
                uiModalIcon.textContent = iconText;

                uiModalConfirm.className = 'ui-btn ' + confirmClass;
                uiModal.classList.remove('hidden');
            });
        }

        function closeModal(result = false) {
            uiModal.classList.add('hidden');

            if (typeof uiModalResolver === 'function') {
                uiModalResolver(result);
                uiModalResolver = null;
            }
        }

        uiModalConfirm.addEventListener('click', function () {
            closeModal(true);
        });

        uiModalCancel.addEventListener('click', function () {
            closeModal(false);
        });

        uiModal.addEventListener('click', function (e) {
            if (e.target.classList.contains('ui-modal-backdrop')) {
                closeModal(false);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (!uiModal.classList.contains('hidden') && e.key === 'Escape') {
                closeModal(false);
            }
        });

        function showConfirm(options = {}) {
            return openModal({
                type: options.type || 'warning',
                iconText: options.iconText || '!',
                confirmClass: options.confirmClass || 'ui-btn-primary',
                ...options
            });
        }

        function showAlert(options = {}) {
            return openModal({
                title: options.title || 'Informasi',
                message: options.message || '',
                type: options.type || 'info',
                iconText: options.iconText || 'i',
                confirmText: options.confirmText || 'Oke',
                showCancel: false,
                confirmClass: options.confirmClass || 'ui-btn-primary'
            });
        }

        function showToast({
            title = 'Berhasil',
            message = '',
            type = 'success',
            duration = 3000
        } = {}) {
            const toast = document.createElement('div');
            toast.className = 'ui-toast ' + type;

            let icon = 'i';
            if (type === 'success') icon = '✓';
            if (type === 'error') icon = '✕';
            if (type === 'warning') icon = '!';
            if (type === 'info') icon = 'i';

            toast.innerHTML = `
                <div class="ui-toast-icon">${icon}</div>
                <div class="ui-toast-body">
                    <p class="ui-toast-title">${title}</p>
                    <p class="ui-toast-message">${message}</p>
                </div>
            `;

            uiToastWrap.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';
                toast.style.transition = 'all .2s ease';

                setTimeout(() => {
                    toast.remove();
                }, 220);
            }, duration);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const eventTimeInput = document.getElementById('event-time-input');
            const clearEventTimeBtn = document.getElementById('clear-event-time');

            if (eventTimeInput && clearEventTimeBtn) {
                clearEventTimeBtn.addEventListener('click', function () {
                    eventTimeInput.value = '';
                });
            }

            document.querySelectorAll('[data-copy-public-link]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const link = this.dataset.copyPublicLink || '';
                    const originalText = this.innerHTML;

                    if (!link) {
                        alert('Link undangan belum tersedia.');
                        return;
                    }

                    try {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(link);
                        } else {
                            const textarea = document.createElement('textarea');
                            textarea.value = link;
                            textarea.style.position = 'fixed';
                            textarea.style.left = '-9999px';
                            document.body.appendChild(textarea);
                            textarea.focus();
                            textarea.select();
                            document.execCommand('copy');
                            document.body.removeChild(textarea);
                        }

                        this.innerHTML = '✓ Link Tersalin';

                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 1800);
                    } catch (error) {
                        alert('Gagal menyalin link. Silakan salin manual.');
                    }
                });
            });
        });
    </script>

    <div id="uiModal" class="ui-modal hidden">
        <div class="ui-modal-backdrop"></div>

        <div class="ui-modal-card" role="dialog" aria-modal="true" aria-labelledby="uiModalTitle">
            <div class="ui-modal-icon" id="uiModalIcon">!</div>

            <div class="ui-modal-content">
                <h3 id="uiModalTitle" class="ui-modal-title">Konfirmasi</h3>
                <p id="uiModalMessage" class="ui-modal-message">Apakah Anda yakin?</p>
            </div>

            <div class="ui-modal-actions">
                <button type="button" id="uiModalCancel" class="ui-btn ui-btn-light">
                    Batal
                </button>

                <button type="button" id="uiModalConfirm" class="ui-btn ui-btn-primary">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <div id="uiToastWrap" class="ui-toast-wrap"></div>
</body>
</html>
