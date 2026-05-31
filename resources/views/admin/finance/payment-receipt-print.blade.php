@php
    $rupiah = fn($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $receipt['reference_number'] }}</title>
    <style>
        :root {
            --brand: #0f5f4a;
            --brand-dark: #083229;
            --gold: #c89b3c;
            --ink: #14201d;
            --muted: #687874;
            --line: #dce6e2;
            --paper: #f5f8f6;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Inter, "Segoe UI", system-ui, sans-serif;
        }

        .print-actions {
            position: sticky;
            top: 0;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(245, 248, 246, 0.94);
            border-bottom: 1px solid var(--line);
        }

        .print-actions button,
        .print-actions a {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
        }

        .print-actions button {
            border: 0;
            background: var(--brand);
            color: #fff;
        }

        .print-actions a {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
        }

        .receipt-shell {
            width: min(100%, 860px);
            margin: 0 auto;
            padding: 2rem;
        }

        .receipt {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(20, 32, 29, 0.12);
        }

        .receipt-head {
            display: grid;
            grid-template-columns: 72px 1fr auto;
            gap: 1rem;
            align-items: center;
            padding: 1.4rem;
            color: #fff;
            background: linear-gradient(135deg, var(--brand-dark), var(--brand));
        }

        .receipt-logo {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #fff;
            overflow: hidden;
        }

        .receipt-logo img {
            width: 58px;
            height: 58px;
            object-fit: contain;
        }

        .receipt-school strong {
            display: block;
            font-size: 1.45rem;
            font-weight: 900;
            line-height: 1;
        }

        .receipt-school span {
            display: block;
            margin-top: 0.35rem;
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.86rem;
            font-weight: 700;
        }

        .receipt-number {
            text-align: right;
            font-weight: 900;
        }

        .receipt-number span {
            display: block;
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.76rem;
            text-transform: uppercase;
        }

        .receipt-body {
            padding: 1.4rem;
        }

        .receipt-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.2rem;
            padding-bottom: 0.9rem;
            border-bottom: 1px solid var(--line);
        }

        .receipt-title h1 {
            margin: 0;
            color: var(--brand-dark);
            font-size: 1.45rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .receipt-status {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            border-radius: 999px;
            padding: 0 0.8rem;
            background: #dff5ee;
            color: var(--brand);
            font-weight: 900;
        }

        .receipt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .receipt-row {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 0.8rem;
            background: #fbfdfc;
        }

        .receipt-row span {
            display: block;
            color: var(--muted);
            font-size: 0.74rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .receipt-row strong {
            display: block;
            margin-top: 0.18rem;
            color: var(--ink);
            font-size: 0.98rem;
            font-weight: 900;
        }

        .receipt-amount {
            margin: 1rem 0;
            border: 1px solid rgba(200, 155, 60, 0.45);
            border-radius: 14px;
            padding: 1rem;
            background: #fff8e7;
        }

        .receipt-amount span {
            color: #8a651f;
            font-size: 0.78rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .receipt-amount strong {
            display: block;
            margin-top: 0.15rem;
            color: var(--brand-dark);
            font-size: 2rem;
            font-weight: 900;
        }

        .receipt-foot {
            display: grid;
            grid-template-columns: 1fr 220px;
            gap: 1rem;
            align-items: end;
            margin-top: 1.4rem;
        }

        .receipt-note {
            color: var(--muted);
            font-size: 0.86rem;
            font-weight: 700;
        }

        .receipt-sign {
            text-align: center;
        }

        .receipt-sign span {
            display: block;
            color: var(--muted);
            font-weight: 800;
        }

        .receipt-sign strong {
            display: block;
            margin-top: 3.2rem;
            border-top: 1px solid var(--line);
            padding-top: 0.45rem;
            font-weight: 900;
        }

        @page {
            size: A4 portrait;
            margin: 14mm;
        }

        @media print {
            body { background: #fff; }
            .print-actions { display: none; }
            .receipt-shell { width: auto; padding: 0; }
            .receipt { box-shadow: none; print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        }

        @media (max-width: 720px) {
            .receipt-head,
            .receipt-grid,
            .receipt-foot {
                grid-template-columns: 1fr;
            }

            .receipt-number {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Cetak Kwitansi</button>
        <a href="{{ route('admin.finance.dashboard') }}">Kembali ke Keuangan</a>
    </div>

    <main class="receipt-shell">
        <section class="receipt">
            <header class="receipt-head">
                <div class="receipt-logo">
                    <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo YAPISDA">
                </div>
                <div class="receipt-school">
                    <strong>YAPISDA</strong>
                    <span>Yayasan Pendidikan Islam Daar El Rohmah</span>
                    <span>Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730</span>
                </div>
                <div class="receipt-number">
                    <span>No. Kwitansi</span>
                    {{ $receipt['reference_number'] }}
                </div>
            </header>

            <div class="receipt-body">
                <div class="receipt-title">
                    <h1>Kwitansi Pembayaran</h1>
                    <span class="receipt-status">{{ $receipt['direction'] }}</span>
                </div>

                <div class="receipt-grid">
                    <div class="receipt-row">
                        <span>Nama Siswa</span>
                        <strong>{{ $receipt['student_name'] }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>NIS</span>
                        <strong>{{ $receipt['student_identification_number'] ?: '-' }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Unit / Program</span>
                        <strong>{{ $receipt['unit'] }}{{ $receipt['choice'] ? ' - ' . $receipt['choice'] : '' }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Nomor Pendaftaran</span>
                        <strong>{{ $receipt['registration_number'] ?: '-' }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Jenis Pembayaran</span>
                        <strong>{{ $receipt['payment_type'] }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Waktu Pembayaran</span>
                        <strong>{{ $receipt['paid_at'] }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Metode</span>
                        <strong>{{ $receipt['payment_method'] }}</strong>
                    </div>
                    <div class="receipt-row">
                        <span>Petugas</span>
                        <strong>{{ $receipt['officer'] }}</strong>
                    </div>
                </div>

                <div class="receipt-amount">
                    <span>Nominal diterima</span>
                    <strong>{{ $rupiah($receipt['amount']) }}</strong>
                </div>

                <div class="receipt-row">
                    <span>Keterangan</span>
                    <strong>{{ $receipt['description'] ?: '-' }}</strong>
                </div>

                <div class="receipt-foot">
                    <p class="receipt-note">
                        Kwitansi ini sah sebagai bukti pembayaran apabila tercatat di sistem keuangan YAPISDA.
                    </p>
                    <div class="receipt-sign">
                        <span>Cisoka, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</span>
                        <strong>{{ $receipt['officer'] }}</strong>
                    </div>
                </div>
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
