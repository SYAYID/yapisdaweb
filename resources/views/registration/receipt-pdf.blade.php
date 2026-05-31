<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - {{ $applicant->registration_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .p-3 { padding: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table td { padding: 5px; vertical-align: top; }
        .col-label { width: 30%; font-weight: bold; }
        .col-value { width: 70%; }
        .border-bottom { border-bottom: 1px solid #ccc; margin-bottom: 15px; padding-bottom: 15px; }
        .bg-primary { background-color: #0d6efd; color: white; padding: 10px; border-radius: 5px; }
        .bg-light { background-color: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6; }
        .qr-code { text-align: center; margin-bottom: 15px; }
        .header-text { margin: 0; line-height: 1.2; }
    </style>
</head>
<body>
    <table style="width: 100%; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle; padding: 0;">
                <img src="{{ public_path('images/logo-yapisda.png') }}" style="max-height: 60px; max-width: 60px;">
            </td>
            <td style="width: 70%; text-align: center; vertical-align: middle; padding: 0;">
                <h3 style="margin: 0; font-size: 11px; font-weight: bold; font-family: sans-serif; color: #0b4537; line-height: 1.2;">YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h3>
                <h2 style="margin: 2px 0; font-size: 13px; font-weight: bold; font-family: sans-serif; color: #0f5f4a; line-height: 1.2;">SMKS YAPISDA CISOKA</h2>
                <p style="margin: 0; font-size: 8px; color: #374151; font-family: sans-serif; line-height: 1.3;">
                    Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kec. Cisoka, Kab. Tangerang, Banten 15730<br>
                    Telp: (021) 59751260 | WhatsApp: 0812-8906-113
                </p>
            </td>
            <td style="width: 15%; text-align: right; vertical-align: middle; padding: 0;">
                <img src="{{ public_path('images/LOGO PROVINSI BANTEN.svg') }}" style="max-height: 60px; max-width: 60px;">
            </td>
        </tr>
    </table>

    <div class="qr-code">
        <img src="data:image/png;base64, {!! $qrCode !!}" style="max-width: 150px;">
    </div>

    <div class="text-center mb-4">
        <div class="bg-primary">
            <h3 style="margin:0;">{{ $applicant->registration_number }}</h3>
            <p style="margin:0; font-size: 10px;">Nomor Pendaftaran</p>
        </div>
    </div>

    <div class="border-bottom">
        <table>
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-value">: {{ $applicant->full_name }}</td>
            </tr>
            <tr>
                <td class="col-label">NIK</td>
                <td class="col-value">: {{ $applicant->nik }}</td>
            </tr>
            <tr>
                <td class="col-label">TTL</td>
                <td class="col-value">: {{ $applicant->birth_place }}, {{ $formattedDates['birth_date'] }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis Kelamin</td>
                <td class="col-value">: {{ $applicant->gender }}</td>
            </tr>
            <tr>
                <td class="col-label">HP/WhatsApp</td>
                <td class="col-value">: {{ $applicant->phone }}</td>
            </tr>
            <tr>
                <td class="col-label">Email</td>
                <td class="col-value">: {{ $applicant->email }}</td>
            </tr>
            <tr>
                <td class="col-label">Asal Sekolah</td>
                <td class="col-value">: {{ $applicant->previous_school }}</td>
            </tr>
            <tr>
                <td class="col-label">Jurusan</td>
                <td class="col-value">: {{ $applicant->major_choice }}</td>
            </tr>
            <tr>
                <td class="col-label">Status</td>
                <td class="col-value">: {{ ucfirst($applicant->status) }}</td>
            </tr>
            <tr>
                <td class="col-label">Waktu Registrasi</td>
                <td class="col-value">: {{ $applicant->registered_at_label }}</td>
            </tr>
        </table>
    </div>

    <div class="bg-light">
        <strong>CATATAN:</strong><br>
        1. Simpan nomor pendaftaran ini dengan baik<br>
        2. Bawa bukti ini saat verifikasi berkas di sekolah<br>
        3. Verifikasi dilakukan pada tanggal 1 Februari - 11 Juli 2026<br>
        4. Hubungi panitia jika ada kendala: (021) 59751260 / 082260203332 / 0895323042450
    </div>
</body>
</html>
