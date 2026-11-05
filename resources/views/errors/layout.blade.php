<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Terjadi Kesalahan' }} | Hajatin.com</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(147, 51, 234, .12), transparent 32%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, .10), transparent 34%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #0f172a;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
            position: relative;
            overflow: hidden;
        }

        .error-page::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(to right, rgba(15, 23, 42, .045) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, .045) 1px, transparent 1px);
            background-size: 38px 38px;
            mask-image: linear-gradient(to bottom, black, transparent 86%);
            pointer-events: none;
        }

        .error-card {
            width: min(100%, 820px);
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(148, 163, 184, .22);
            box-shadow: 0 28px 90px rgba(15, 23, 42, .10);
            border-radius: 34px;
            padding: 44px;
            overflow: hidden;
        }

        .error-card::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            right: -90px;
            top: -90px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(147, 51, 234, .18), rgba(59, 130, 246, .13));
        }

        .error-card::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            left: -60px;
            bottom: -60px;
            border-radius: 999px;
            background: rgba(236, 72, 153, .10);
        }

        .error-content {
            position: relative;
            z-index: 2;
        }

        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, .22);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
            color: #7c3aed;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .error-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            color: white;
            font-weight: 900;
            font-size: 16px;
        }

        .error-code {
            margin: 28px 0 0;
            font-size: clamp(4rem, 14vw, 9rem);
            line-height: .85;
            letter-spacing: -.08em;
            font-weight: 950;
            background: linear-gradient(135deg, #0f172a, #7c3aed, #2563eb);
            -webkit-background-clip: text;
            color: transparent;
        }

        .error-title {
            margin: 22px 0 0;
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 1;
            letter-spacing: -.05em;
            font-weight: 950;
            color: #0f172a;
        }

        .error-message {
            margin: 20px 0 0;
            max-width: 620px;
            color: #64748b;
            font-size: 1.05rem;
            line-height: 1.85;
        }

        .error-actions {
            margin-top: 34px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 13px 22px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 900;
            border: none;
            cursor: pointer;
            transition: .18s ease;
        }

        .error-btn:hover {
            transform: translateY(-1px);
        }

        .error-btn.primary {
            color: #ffffff;
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            box-shadow: 0 16px 32px rgba(124, 58, 237, .20);
        }

        .error-btn.secondary {
            color: #0f172a;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, .26);
            box-shadow: 0 12px 24px rgba(15, 23, 42, .06);
        }

        .error-help {
            margin-top: 28px;
            padding: 18px;
            border-radius: 22px;
            background: rgba(248, 250, 252, .82);
            border: 1px solid rgba(148, 163, 184, .18);
            color: #64748b;
            font-size: .92rem;
            line-height: 1.7;
        }

        @media (max-width: 640px) {
            .error-card {
                padding: 30px 22px;
                border-radius: 26px;
            }

            .error-actions {
                flex-direction: column;
            }

            .error-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="error-page">
        <section class="error-card">
            <div class="error-content">
                <div class="error-badge">
                    <span class="error-icon">{{ $icon ?? '!' }}</span>
                    {{ $badge ?? 'Hajatin.com' }}
                </div>

                <h1 class="error-code">
                    {{ $code ?? 'Oops' }}
                </h1>

                <h2 class="error-title">
                    {{ $title ?? 'Terjadi Kesalahan' }}
                </h2>

                <p class="error-message">
                    {{ $message ?? 'Maaf, terjadi kesalahan saat memuat halaman ini.' }}
                </p>

                <div class="error-actions">
                    <a href="{{ url('/') }}" class="error-btn primary">
                        Kembali ke Beranda
                    </a>

                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="error-btn secondary">
                        Kembali Sebelumnya
                    </a>
                </div>

                <div class="error-help">
                    Jika masalah masih terjadi, silakan coba muat ulang halaman atau hubungi admin website.
                </div>
            </div>
        </section>
    </main>
</body>
</html>
