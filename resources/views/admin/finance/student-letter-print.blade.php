<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $letter['title'] }} - {{ $letter['registration_number'] }}</title>
    <style>
        :root {
            --brand: #0f5f4a;
            --brand-dark: #083229;
            --gold: #c89b3c;
            --ink: #14201d;
            --muted: #66756f;
            --line: #dce6e2;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            background: #eef4f1;
            font-family: Arial, "Segoe UI", sans-serif;
            line-height: 1.55;
        }

        .print-actions {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(238, 244, 241, 0.94);
            border-bottom: 1px solid var(--line);
        }

        .print-actions button,
        .print-actions a {
            min-height: 42px;
            border: 0;
            border-radius: 9px;
            padding: 0.65rem 1rem;
            background: var(--brand);
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

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 18px auto;
            padding: 18mm;
            background: #fff;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
        }

        .letterhead {
            display: grid;
            grid-template-columns: 24mm 1fr 22mm;
            gap: 5mm;
            align-items: center;
            padding-bottom: 5mm;
            border-bottom: 3px solid var(--brand);
        }

        .letterhead img {
            width: 22mm;
            height: 22mm;
            object-fit: contain;
        }

        .letterhead h1,
        .letterhead p {
            margin: 0;
            text-align: center;
        }

        .letterhead h1 {
            color: var(--brand-dark);
            font-size: 15pt;
            line-height: 1.18;
            text-transform: uppercase;
        }

        .letterhead p {
            color: var(--muted);
            font-size: 8.5pt;
        }

        .doc-title {
            margin: 10mm 0 6mm;
            text-align: center;
        }

        .doc-title h2 {
            display: inline-block;
            margin: 0 0 1.5mm;
            border-bottom: 1px solid var(--ink);
            color: var(--ink);
            font-size: 13pt;
            text-transform: uppercase;
        }

        .doc-title p {
            margin: 0;
            color: var(--muted);
            font-size: 9pt;
        }

        .content {
            font-size: 11pt;
        }

        .content p {
            margin: 0 0 4mm;
            text-align: justify;
        }

        .student-table {
            width: 100%;
            margin: 4mm 0 6mm;
            border-collapse: collapse;
            font-size: 10.5pt;
        }

        .student-table td {
            padding: 1.5mm 0;
            vertical-align: top;
        }

        .student-table td:first-child {
            width: 42mm;
            color: var(--muted);
        }

        .note-box {
            margin: 5mm 0;
            padding: 4mm;
            border: 1px solid var(--line);
            border-left: 4px solid var(--gold);
            background: #fbf8ef;
            font-size: 10pt;
        }

        .signature {
            width: 72mm;
            margin-left: auto;
            margin-top: 14mm;
            text-align: center;
            font-size: 10.5pt;
        }

        .signature .space {
            height: 22mm;
        }

        .footer-note {
            margin-top: 8mm;
            color: var(--muted);
            font-size: 8.5pt;
            text-align: center;
        }

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {
            body { background: #fff; }
            .print-actions { display: none; }
            .page {
                width: auto;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Cetak Surat</button>
        <a href="{{ route('admin.finance.dashboard') }}">Kembali</a>
    </div>

    <main class="page">
        <header class="letterhead">
            <img src="{{ asset($letter['student_type'] === 'smp' ? 'images/LOGO SMPS YAPISDA.svg' : 'images/LOGO SMK YAPISDA.jpg') }}" alt="Logo Unit">
            <div>
                <h1>Yayasan Pendidikan Islam Daar El Rohmah<br>{{ $letter['unit'] }}</h1>
                <p>Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730</p>
                <p>Telp. (021) 59751260 | WhatsApp 0812-8906-113</p>
            </div>
            <img src="{{ asset('images/LOGO PROVINSI BANTEN.svg') }}" alt="Logo Provinsi Banten">
        </header>

        <section class="doc-title">
            <h2>{{ $letter['title'] }}</h2>
            <p>Nomor: {{ $letter['number'] }}</p>
        </section>

        <section class="content">
            <p>Yang bertanda tangan di bawah ini menerangkan bahwa data calon peserta didik berikut tercatat pada sistem penerimaan peserta didik baru YAPISDA:</p>

            <table class="student-table">
                <tr>
                    <td>Nama</td>
                    <td>: <strong>{{ $letter['name'] }}</strong></td>
                </tr>
                <tr>
                    <td>Nomor Pendaftaran</td>
                    <td>: {{ $letter['registration_number'] }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>: {{ $letter['student_identification_number'] ?: 'Belum diterbitkan' }}</td>
                </tr>
                <tr>
                    <td>Unit/Jurusan</td>
                    <td>: {{ $letter['unit'] }} - {{ $letter['choice'] }}</td>
                </tr>
                <tr>
                    <td>Waktu Registrasi</td>
                    <td>: {{ $letter['registered_at'] }}</td>
                </tr>
            </table>

            @if($letter['template'] === 'accepted')
                <p>Berdasarkan pemeriksaan data dan berkas, calon peserta didik tersebut telah melewati tahapan verifikasi administrasi penerimaan peserta didik baru. Status peserta didik aktif mengikuti kelengkapan administrasi daftar ulang dan atribut peserta didik sesuai ketentuan sekolah.</p>
                <div class="note-box">
                    Surat ini digunakan sebagai keterangan administratif internal/sekolah dan tidak menggantikan dokumen resmi lain yang diterbitkan kemudian oleh satuan pendidikan.
                </div>
            @elseif($letter['template'] === 'reenrollment')
                <p>Calon peserta didik tersebut tercatat dalam proses administrasi daftar ulang dan atribut peserta didik. Data administrasi pada sistem menunjukkan nominal tercatat sebesar <strong>Rp {{ number_format($letter['paid_amount'], 0, ',', '.') }}</strong> dari kebutuhan administrasi atribut peserta didik sebesar <strong>Rp {{ number_format($letter['required_amount'], 0, ',', '.') }}</strong>.</p>
                <p>Sisa administrasi yang belum tercatat pada sistem adalah <strong>Rp {{ number_format($letter['remaining_amount'], 0, ',', '.') }}</strong>. Apabila terdapat perbedaan data, orang tua/wali dapat melakukan konfirmasi kepada petugas administrasi sekolah.</p>
                <div class="note-box">
                    Status atribut: {{ $letter['uniform_profile'] ? ucfirst(str_replace('_', ' ', $letter['uniform_profile']->attribute_status)) : 'Belum tercatat' }}.
                    Ukuran baju: {{ $letter['uniform_profile']?->shirt_size ?: '-' }},
                    celana/rok: {{ $letter['uniform_profile']?->pants_size ?: '-' }}.
                </div>
            @else
                <p>Dengan hormat, orang tua/wali dari calon peserta didik tersebut dimohon hadir ke sekolah untuk melakukan konfirmasi data dan administrasi daftar ulang. Kehadiran orang tua/wali diperlukan agar data sekolah, pilihan program, serta kebutuhan atribut peserta didik dapat dipastikan dengan benar.</p>
                <div class="note-box">
                    Jadwal kehadiran dapat dikoordinasikan dengan panitia PPDB melalui kontak resmi sekolah. Mohon membawa identitas diri dan dokumen pendukung apabila diperlukan.
                </div>
            @endif

            <p>Demikian surat ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
        </section>

        <section class="signature">
            <div>Tangerang, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
            <div>Petugas Administrasi</div>
            <div class="space"></div>
            <strong>{{ $letter['officer'] }}</strong>
        </section>

        <div class="footer-note">
            Dicetak dari sistem YAPISDA pada {{ $letter['printed_at'] }}.
        </div>
    </main>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => window.print(), 450);
        });
    </script>
</body>
</html>
