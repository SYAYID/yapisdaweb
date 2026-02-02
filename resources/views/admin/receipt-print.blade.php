<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran - {{ $applicant->registration_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: white;
        }
        
        .receipt-container {
            max-width: 21cm;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }
        
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
        
        .school-info {
            margin-left: 20px;
        }
        
        .school-info h3 {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .school-info h4 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .school-info p {
            font-size: 11px;
            color: #666;
        }
        
        .qr-section {
            text-align: center;
            margin: 25px 0;
        }
        
        .qr-code {
            display: inline-block;
            padding: 10px;
            background: white;
            border: 2px solid #2563eb;
        }
        
        .registration-number {
            background: #2563eb;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 20px;
            font-weight: bold;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 8px 15px;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .info-grid strong {
            color: #333;
        }
        
        .info-grid div {
            color: #555;
        }
        
        .status-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #ddd;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending { background: #f59e0b; color: white; }
        .status-verified { background: #10b981; color: white; }
        .status-rejected { background: #ef4444; color: white; }
        
        .notes {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 11px;
        }
        
        .notes strong {
            color: #2563eb;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .receipt-container {
                border: none;
                padding: 20px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/logo-yapisda.png') }}" 
                 alt="Logo YAPISDA" 
                 class="logo"
                 onerror="this.style.display='none'">
            <div class="school-info">
                <h3>YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h3>
                <h4>SMKS YAPISDA</h4>
                <p>Jl. Raya Cisoka -Tigaraksa , Kp.Saga, Ds.Caringin, Kec.Cisoka, Kabupaten Tangerang, Banten</p>
                <p>Telp: (021) 59751260 | 08128906113 </p>
            </div>
        </div>

        <!-- Title -->
        <h2 style="text-align: center; margin: 20px 0; color: #2563eb;">
            <strong>BUKTI PENDAFTARAN</strong>
        </h2>
        <p style="text-align: center; margin-bottom: 30px; color: #666; font-size: 12px;">
            Sistem Penerimaan Murid Baru Tahun Ajaran 2026/2027
        </p>

        <!-- QR Code -->
        <div class="qr-section">
            <div class="qr-code">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($applicant->registration_number) !!}
            </div>
            <p style="margin-top: 10px; font-size: 11px; color: #666;">
                Scan QR Code untuk verifikasi data
            </p>
        </div>

        <!-- Registration Number -->
        <div class="registration-number">
            {{ $applicant->registration_number }}
        </div>

        <!-- Student Info -->
        <div class="info-grid">
            <strong>Nama Lengkap</strong>
            <div>: {{ $applicant->full_name }}</div>
            
            <strong>NIK</strong>
            <div>: {{ $applicant->nik }}</div>
            
            <strong>Tempat, Tanggal Lahir</strong>
            <div>: {{ $applicant->birth_place }}, {{ \Carbon\Carbon::parse($applicant->birth_date)->format('d/m/Y') }}</div>
            
            <strong>Jenis Kelamin</strong>
            <div>: {{ $applicant->gender }}</div>
            
            <strong>Agama</strong>
            <div>: {{ $applicant->religion }}</div>
            
            <strong>No. HP/WhatsApp</strong>
            <div>: {{ $applicant->phone }}</div>
            
            <strong>Email</strong>
            <div>: {{ $applicant->email }}</div>
            
            <strong>Asal Sekolah</strong>
            <div>: {{ $applicant->previous_school }}</div>
            
            <strong>Jurusan Pilihan</strong>
            <div>: {{ $applicant->major_choice }}</div>
        </div>

        <!-- Status -->
        <div class="status-section">
            <div>
                <strong>Status Pendaftaran:</strong><br>
                <span class="status-badge status-{{ $applicant->status }}">
                    {{ ucfirst($applicant->status) }}
                </span>
            </div>
            <div style="text-align: right;">
                <strong>Tanggal Daftar:</strong><br>
                {{ \Carbon\Carbon::parse($applicant->created_at)->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Notes -->
        <div class="notes">
            <strong>PERHATIAN:</strong><br>
            1. Simpan nomor pendaftaran ini dengan baik<br>
            2. Bawa bukti ini saat verifikasi berkas di sekolah<br>
            3. Verifikasi berkas: 1-15 Mei 2026 (Senin-Jumat, 08.00-15.00 WIB)<br>
            4. Hubungi panitia jika ada kendala: (021) 59751260 / 08128906113 
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>