@php
    $nameParts = preg_split('/\s+/', trim($card['name'])) ?: [];
    $initials = '';

    foreach (array_slice($nameParts, 0, 2) as $part) {
        $initials .= strtoupper(substr($part, 0, 1));
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Siswa - {{ $card['student_identification_number'] }}</title>
    <style>
        :root {
            --card-color: {{ $card['theme_color'] }};
            --ink: #102a43;
            --muted: #62748e;
            --line: #d8e0ea;
            --paper: #f3f6fa;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .print-actions {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(243, 246, 250, 0.92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .print-actions button,
        .print-actions a {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            background: var(--card-color);
            color: #fff;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .print-actions a {
            background: #fff;
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .print-shell {
            width: min(100%, 420px);
            min-height: calc(100vh - 76px);
            display: grid;
            place-items: center;
            margin: 0 auto;
            padding: 2rem;
        }

        .student-card {
            width: 54mm;
            height: 85.6mm;
            position: relative;
            overflow: hidden;
            border-radius: 4mm;
            background:
                linear-gradient(180deg, var(--card-color) 0%, var(--card-color) 38%, #ffffff 38%, #ffffff 100%);
            color: var(--ink);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.2);
            isolation: isolate;
        }

        .student-card::before {
            content: "";
            position: absolute;
            top: -16mm;
            left: -18mm;
            width: 58mm;
            height: 58mm;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            z-index: -1;
        }

        .student-card::after {
            content: "";
            position: absolute;
            right: -18mm;
            top: 12mm;
            width: 48mm;
            height: 48mm;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.22);
            z-index: -1;
        }

        .card-inner {
            height: 100%;
            display: grid;
            grid-template-rows: auto auto 1fr auto;
            gap: 3mm;
            padding: 4.2mm;
        }

        .card-top {
            display: grid;
            grid-template-columns: 10mm 1fr;
            align-items: center;
            gap: 2.6mm;
            color: #fff;
        }

        .card-logo {
            width: 10mm;
            height: 10mm;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.96);
            overflow: hidden;
        }

        .card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .school-name {
            display: grid;
            gap: 0.5mm;
            line-height: 1;
        }

        .school-name strong {
            font-size: 9pt;
            font-weight: 900;
            text-transform: uppercase;
        }

        .school-name span {
            color: rgba(255, 255, 255, 0.78);
            font-size: 5.7pt;
            font-weight: 700;
        }

        .card-title {
            color: #fff;
            text-align: center;
        }

        .card-title strong {
            display: block;
            font-size: 10pt;
            font-weight: 900;
            text-transform: uppercase;
        }

        .card-title span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 5.8mm;
            margin-top: 1.6mm;
            border-radius: 999px;
            padding: 1mm 3mm;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            font-size: 6pt;
            font-weight: 900;
        }

        .photo-frame {
            width: 29mm;
            height: 36mm;
            justify-self: center;
            margin-top: -1mm;
            border: 1.4mm solid #fff;
            border-radius: 3mm;
            background: rgba(255, 255, 255, 0.9);
            overflow: hidden;
            box-shadow: 0 7px 18px rgba(15, 23, 42, 0.16);
        }

        .photo-frame img,
        .photo-fallback {
            width: 100%;
            height: 100%;
        }

        .photo-frame img {
            display: block;
            object-fit: cover;
        }

        .photo-fallback {
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--card-color);
            font-size: 20pt;
            font-weight: 900;
        }

        .photo-fallback.has-photo-fallback {
            display: none;
        }

        .student-info {
            min-width: 0;
            display: grid;
            align-content: start;
            gap: 2.4mm;
            text-align: center;
        }

        .student-info h1 {
            margin: 0;
            color: var(--ink);
            font-size: 11pt;
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: 0;
            overflow-wrap: anywhere;
        }

        .student-meta {
            display: grid;
            gap: 1.5mm;
            text-align: left;
        }

        .meta-row {
            display: grid;
            gap: 0.6mm;
            border: 1px solid #e5edf5;
            border-radius: 2.2mm;
            padding: 1.8mm 2.2mm;
            background: #f8fbfd;
        }

        .meta-row span {
            color: var(--muted);
            font-size: 5.4pt;
            font-weight: 900;
            text-transform: uppercase;
        }

        .meta-row strong {
            color: var(--ink);
            font-size: 7pt;
            line-height: 1.18;
            font-weight: 900;
            overflow-wrap: anywhere;
        }

        .card-footer {
            min-height: 7.5mm;
            display: grid;
            place-items: center;
            border-radius: 2.4mm;
            background: var(--card-color);
            color: #fff;
            font-size: 6.1pt;
            font-weight: 900;
            text-transform: uppercase;
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {
            body {
                min-height: auto;
                background: #fff;
            }

            .print-actions {
                display: none;
            }

            .print-shell {
                width: auto;
                min-height: auto;
                display: block;
                margin: 0;
                padding: 0;
            }

            .student-card {
                box-shadow: none;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Cetak Kartu</button>
        <a href="{{ route('admin.finance.dashboard') }}">Kembali ke Keuangan</a>
    </div>

    <main class="print-shell">
        <section class="student-card" aria-label="Kartu siswa {{ $card['name'] }}">
            <div class="card-inner">
                <header class="card-top">
                    <div class="card-logo">
                        <img src="{{ asset('images/logobaru.png') }}" alt="Logo YAPISDA">
                    </div>
                    <div class="school-name">
                        <strong>YAPISDA</strong>
                        <span>Daar El Rohmah</span>
                    </div>
                </header>

                <div class="card-title">
                    <strong>Kartu Siswa</strong>
                    <span>{{ $card['unit'] }}</span>
                </div>

                <div class="photo-frame">
                    @if($card['photo_url'])
                        <img src="{{ $card['photo_url'] }}"
                             alt="Pas foto {{ $card['name'] }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                        <div class="photo-fallback has-photo-fallback">{{ $initials ?: 'YS' }}</div>
                    @else
                        <div class="photo-fallback">{{ $initials ?: 'YS' }}</div>
                    @endif
                </div>

                <div class="student-info">
                    <h1>{{ $card['name'] }}</h1>
                    <div class="student-meta">
                        <div class="meta-row">
                            <span>Nomor Induk Siswa</span>
                            <strong>{{ $card['student_identification_number'] }}</strong>
                        </div>
                        <div class="meta-row">
                            <span>Jurusan / Program</span>
                            <strong>{{ $card['choice'] }}</strong>
                        </div>
                    </div>
                </div>

                <footer class="card-footer">
                    Siswa Aktif
                </footer>
            </div>
        </section>
    </main>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => window.print(), 450);
        });
    </script>
</body>
</html>
