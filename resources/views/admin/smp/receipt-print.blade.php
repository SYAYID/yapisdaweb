<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran - {{ $applicant->registration_number }}</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #dbeafe;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --gray: #64748b;
            --light: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.4;
            font-size: 11px;
            padding: 10px;
        }

        .receipt-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: var(--white);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        /* Header - Compact */
        .header {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 3px double var(--primary);
            background: var(--white);
            gap: 12px;
        }

        .logo-wrapper {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo { max-width: 60px; max-height: 60px; object-fit: contain; }

        .school-info { flex: 1; min-width: 0; text-align: center; }
        .school-info h1 { font-size: 11px; font-weight: 700; color: var(--primary-dark); line-height: 1.2; }
        .school-info h2 { font-size: 11px; font-weight: 700; color: var(--primary); margin: 2px 0; }
        .school-info .address { font-size: 8px; color: var(--gray); line-height: 1.3; }
        .school-info .contact { font-size: 8.5px; color: var(--primary); font-weight: 600; margin-top: 1px; }

        /* Title Banner - Compact */
        .title-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            text-align: center;
            padding: 8px 15px;
        }
        .title-banner h3 { font-size: 13px; font-weight: 700; letter-spacing: 0.3px; }
        .title-banner p { font-size: 9px; opacity: 0.95; }
        .academic-year {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 9px;
            margin-top: 4px;
            font-weight: 500;
        }

        /* Top Bar: QR + Reg Number */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: var(--light);
            border-bottom: 1px dashed var(--border);
            gap: 10px;
        }

        .qr-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--primary);
        }
        .qr-code { width: 45px; height: 45px; }
        .qr-code img { width: 100%; height: 100%; object-fit: contain; }
        .qr-text { font-size: 9px; color: var(--gray); line-height: 1.3; }

        .reg-number-box {
            text-align: right;
            padding: 8px 12px;
            background: linear-gradient(135deg, var(--dark), var(--primary-dark));
            border-radius: 6px;
            color: white;
            min-width: 180px;
        }
        .reg-number-box .label { font-size: 9px; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px; }
        .reg-number-box .number { font-size: 14px; font-weight: 700; font-family: monospace; letter-spacing: 1px; word-break: break-all; }

        /* Content */
        .content { padding: 12px 15px; }

        .section { margin-bottom: 12px; break-inside: avoid; }
        .section-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--primary-dark);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 4px 8px;
            background: var(--primary-light);
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
        }

        /* Compact Info Grid - 2 columns for labels */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px 15px;
            font-size: 10px;
        }
        .info-item { display: flex; align-items: center; }
        .info-item .label {
            flex: 0 0 100px;
            font-weight: 600;
            color: var(--dark);
            white-space: nowrap;
        }
        .info-item .colon {
            flex: 0 0 12px;
            font-weight: 600;
            color: var(--dark);
        }
        .info-item .value {
            flex: 1;
            color: #334155;
            word-break: break-word;
            font-weight: 500;
        }
        .info-item .value.highlight { color: var(--primary-dark); font-weight: 700; }

        /* Address - Compact */
        .address-box {
            background: var(--light);
            border-left: 3px solid var(--primary);
            padding: 6px 10px;
            border-radius: 0 4px 4px 0;
            font-size: 10px;
            line-height: 1.5;
        }
        .address-box .label { font-weight: 600; color: var(--dark); display: block; margin-bottom: 2px; }

        /* Missing Documents - Compact */
        .missing-documents {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 9px;
            margin: 8px 0;
        }
        .missing-documents .header {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #fcd34d;
            font-weight: 600;
            color: #92400e;
        }
        .missing-documents ul { margin: 0; padding-left: 15px; }
        .missing-documents li { margin: 2px 0; color: #92400e; }
        .missing-documents .contact-note {
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px dashed #fcd34d;
            font-weight: 500;
            color: #92400e;
        }

        /* Status Bar - Compact */
        .status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: var(--light);
            border-radius: 6px;
            margin: 8px 0;
            border: 1px solid var(--border);
            font-size: 10px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-verified { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .timestamp { text-align: right; }
        .timestamp .value { font-weight: 600; color: var(--dark); }

        /* Notes - Ultra Compact */
        .notes {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 9px;
            margin: 8px 0;
        }
        .notes .title { font-weight: 700; color: var(--primary-dark); margin-bottom: 4px; }
        .notes ol { padding-left: 15px; margin: 0; }
        .notes li { margin: 2px 0; }
        .notes li strong { color: var(--primary); }

        /* Footer - Compact */
        .footer {
            padding: 10px 15px 15px;
            border-top: 1px solid var(--border);
            margin-top: 5px;
            font-size: 9px;
            color: var(--gray);
            text-align: center;
        }
        .footer strong { color: var(--dark); }

        .signature {
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
            margin-top: 15px;
        }
        .signature-item {
            text-align: center;
            width: 180px;
        }
        .signature-title, .signature-role {
            font-size: 9px;
            color: var(--dark);
            margin-bottom: 2px;
        }
        .signature-space {
            height: 40px;
        }
        .signature-line {
            width: 130px;
            height: 1px;
            background: var(--dark);
            margin: 0 auto 4px;
        }
        .signature-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 9px;
            text-transform: uppercase;
        }

        .disclaimer {
            margin-top: 10px;
            font-size: 8px;
            opacity: 0.7;
            font-style: italic;
        }

        /* Print Button */
        .print-btn {
            position: fixed;
            bottom: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 100;
        }
        .print-btn:hover { background: var(--primary-dark); }

        /* === PRINT OPTIMIZATION === */
        @media print {
            @page { margin: 5mm; size: A4; }

            body {
                background: white;
                padding: 0;
                font-size: 10px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-container {
                width: 100%;
                min-height: auto;
                border: none;
                box-shadow: none;
            }

            .print-btn { display: none !important; }

            /* Force content to stay together */
            .content { padding: 8px 12px; }
            .section { margin-bottom: 8px; }
            .info-grid { gap: 4px 8px; }
            .info-item .label { flex-basis: 85px; font-size: 9px; }
            .info-item .value { font-size: 9px; }

            /* Prevent page breaks inside critical sections */
            .status-bar, .notes, .missing-documents, .address-box {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            /* Compact footer for print */
            .footer { padding: 8px 12px 12px; }
            .signature { gap: 30px; margin-top: 10px; }
            .signature-line { margin: 15px auto 3px; width: 90px; }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .receipt-container { width: 100%; border-radius: 8px; }
            .header { flex-wrap: wrap; }
            .info-grid { grid-template-columns: 1fr; }
            .info-item .label { flex-basis: auto; font-weight: 600; color: var(--primary); }
            .top-bar { flex-direction: column; align-items: stretch; }
            .reg-number-box { text-align: center; min-width: auto; }
            .status-bar { flex-direction: column; gap: 8px; text-align: center; }
            .timestamp { text-align: center; }
            .signature { flex-direction: column; gap: 20px; }
        }
    </style>
</head>
<body>
    <!-- Print Button (Hidden when printing) -->
    <button class="print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Bukti
    </button>

    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-wrapper">
                <img src="{{ asset('images/LOGO SMPS YAPISDA.svg') }}"
                     alt="Logo YAPISDA"
                     class="logo"
                     onerror="this.style.display='none'; this.parentElement.style.display='none';">
            </div>
            <div class="school-info">
                <h1 style="font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin: 0; line-height: 1.2;">YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h1>
                <h2 style="font-family: 'Times New Roman', Times, serif; font-size: 13pt; margin: 2px 0; line-height: 1.2;">SMPS YAPISDA CISOKA</h2>
                <p class="address">Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kec. Cisoka, Kab. Tangerang, Banten 15730</p>
                <p class="contact">Telp: (021) 59751260 | WhatsApp: 0812-8906-113</p>
            </div>
            <div class="logo-wrapper">
                <img src="{{ asset('images/LOGO PROVINSI BANTEN.svg') }}"
                     alt="Logo Provinsi Banten"
                     class="logo"
                     onerror="this.style.display='none'; this.parentElement.style.display='none';">
            </div>
        </div>

        <!-- Title Banner -->
        <div class="title-banner">
            <h3>BUKTI PENDAFTARAN SISWA BARU</h3>
            <p>Sistem PPDB Online - Tahun Ajaran 2026/2027</p>
        </div>

        <!-- Top Bar: QR + Registration Number -->
        <div class="top-bar">
            <div class="qr-box">
                <div class="qr-code">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(45)->generate($applicant->registration_number) !!}
                </div>
                <div class="qr-text">🔍 Scan untuk<br>verifikasi data</div>
            </div>
            <div class="reg-number-box">
                <div class="label">Nomor Pendaftaran</div>
                <div class="number">{{ $applicant->registration_number }}</div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Data Siswa -->
            <div class="section">
                <div class="section-title"><i class="fas fa-user-graduate"></i> Data Siswa</div>
                <div class="info-grid">
                    <div class="info-item"><span class="label">Nama Lengkap</span><span class="colon">:</span><span class="value highlight">{{ $applicant->full_name }}</span></div>
                    <div class="info-item"><span class="label">NIK</span><span class="colon">:</span><span class="value">{{ $applicant->nik }}</span></div>
                    <div class="info-item"><span class="label">Tempat, Tgl Lahir</span><span class="colon">:</span><span class="value">{{ $applicant->birth_place }}, {{ \Carbon\Carbon::parse($applicant->birth_date)->format('d/m/Y') }}</span></div>
                    <div class="info-item"><span class="label">Jenis Kelamin</span><span class="colon">:</span><span class="value">{{ $applicant->gender }}</span></div>
                    <div class="info-item"><span class="label">Agama</span><span class="colon">:</span><span class="value">{{ $applicant->religion }}</span></div>
                    <div class="info-item"><span class="label">No. HP/WA</span><span class="colon">:</span><span class="value highlight">{{ $applicant->phone }}</span></div>
                    <div class="info-item"><span class="label">Email</span><span class="colon">:</span><span class="value">{{ $applicant->email }}</span></div>
                    <div class="info-item"><span class="label">Asal Sekolah</span><span class="colon">:</span><span class="value">{{ $applicant->previous_school }}</span></div>
                    <div class="info-item"><span class="label">Program Pilihan</span><span class="colon">:</span><span class="value highlight">{{ $applicant->school_program }}</span></div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="section">
                <div class="section-title"><i class="fas fa-map-marker-alt"></i> Alamat Domisili</div>
                <div class="address-box">
                    <span class="label">📍 Alamat Lengkap</span>
                    {{ $applicant->current_village }}, RT{{ $applicant->current_rt }}/RW{{ $applicant->current_rw }}, {{ $applicant->current_subdistrict }}, {{ $applicant->current_district }}, {{ $applicant->current_city }}, {{ $applicant->current_province }}
                </div>
            </div>

            <!-- Missing Documents Warning -->
            @php
                $missingDocuments = [];
                $requiredDocuments = [
                    'photo_path' => '📷 Pas Foto',
                    'kk_path' => '📄 KK',
                    'birth_certificate_path' => '📜 Akta Kelahiran',
                    'mother_ktp_path' => '🆔 KTP Ibu',
                    'father_ktp_path' => '🆔 KTP Ayah',
                    'report_card_path' => '📋 Rapor'
                ];
                foreach ($requiredDocuments as $field => $label) {
                    if (empty($applicant->{$field})) $missingDocuments[] = $label;
                }
                if ($applicant->has_guardian && empty($applicant->guardian_ktp_path)) {
                    $missingDocuments[] = '🆔 KTP Wali';
                }
            @endphp

            @if(!empty($missingDocuments))
                <div class="section">
                    <div class="missing-documents">
                        <div class="header"><i class="fas fa-exclamation-triangle"></i> ⚠️ BERKAS BELUM LENGKAP</div>
                        <ul>@foreach($missingDocuments as $doc)<li>{{ $doc }}</li>@endforeach</ul>
                        <p class="contact-note">📞 Hubungi: (021) 59751260 / 08128906113</p>
                    </div>
                </div>
            @endif

            <!-- Status Bar -->
            <div class="section">
                <div class="status-bar">
                    <div>
                        <strong>Status:</strong>
                        <span class="status-badge status-{{ $applicant->status }}">
                            @if($applicant->status == 'pending') <i class="fas fa-clock"></i> Menunggu Verifikasi
                            @elseif($applicant->status == 'verified') <i class="fas fa-check-circle"></i> Terverifikasi
                            @else <i class="fas fa-times-circle"></i> Ditolak @endif
                        </span>
                    </div>
                    <div class="timestamp">
                        <div>📅 {{ $applicant->registered_date_label }}</div>
                        <div class="value">{{ $applicant->registered_time_label }}</div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="section">
                <div class="notes">
                    <div class="title">⚠️ PENTING</div>
                    <ol>
                        <li><strong>Simpan bukti ini</strong> untuk verifikasi berkas di sekolah</li>
                        <li><strong>Verifikasi:</strong> 1-15 Mei 2026 (08.00-15.00 WIB)</li>
                        <li><strong>Lengkapi berkas</strong> yang masih kurang sebelum verifikasi</li>
                        <li><strong>Hasil seleksi</strong> diumumkan via website & SMS</li>
                        <li><strong>Kendala?</strong> Hubungi: (021) 59751260 / 08128906113</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Yayasan Pendidikan Islam Daar El Rohmah</strong><br>Mewujudkan Generasi Berakhlak, Cerdas, Berprestasi</p>
            <div class="signature">
                <div class="signature-item">
                    <div class="signature-title">Mengetahui,</div>
                    <div class="signature-role">Panitia PPDB SMPS YAPISDA</div>
                    <div class="signature-space"></div>
                    <div class="signature-line"></div>
                    <div class="signature-name">Panitia PPDB</div>
                </div>
                <div class="signature-item">
                    <div class="signature-title">Cisoka, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
                    <div class="signature-role">Sistem PPDB Online</div>
                    <div class="signature-space"></div>
                    <div class="signature-line"></div>
                    <div class="signature-name">Tanggal Cetak</div>
                </div>
            </div>
            <p class="disclaimer">Dokumen otomatis sistem • Tidak memerlukan tanda tangan basah</p>
        </div>
    </div>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        // Shortcut Ctrl+P / Cmd+P
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
        
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
