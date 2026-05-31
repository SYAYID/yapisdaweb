@extends('layouts.app')

@section('title', 'Formulir Pendaftaran SMPS - SPMB 2026/2027')

@push('styles')
<style>
.smp-registration-page {
    max-width: 1120px;
    margin: 0 auto;
    padding: clamp(1.25rem, 3vw, 2.25rem) 1.25rem 2.5rem;
}

.smp-form-card {
    overflow: hidden;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: white;
    box-shadow: var(--shadow-sm);
}

.smp-form-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.45rem 1.6rem;
    color: white;
    background:
        radial-gradient(circle at 92% 0%, rgba(31, 154, 165, 0.22), transparent 12rem),
        linear-gradient(135deg, var(--brand-800), var(--brand));
}

.smp-form-header h1 {
    margin: 0;
    font-family: var(--ff-display);
    font-size: clamp(1.25rem, 2vw, 1.65rem);
    font-weight: 900;
}

.smp-form-header p {
    margin: 0.45rem 0 0;
    color: rgba(255, 255, 255, 0.74);
    font-weight: 700;
}

.smp-form-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 999px;
    padding: 0.45rem 0.75rem;
    background: rgba(255, 255, 255, 0.12);
    color: var(--gold-soft);
    font-weight: 900;
}

.smp-form-body {
    display: grid;
    gap: 1.25rem;
    padding: clamp(1rem, 2.3vw, 1.6rem);
}

.smp-alert {
    border: 1px solid var(--line);
    border-left: 4px solid var(--gold);
    border-radius: 14px;
    padding: 1rem 1.05rem;
    background: var(--gold-soft);
    color: #76520f;
    font-weight: 700;
}

.smp-alert h2 {
    margin: 0 0 0.45rem;
    color: var(--brand-800);
    font-size: 1rem;
    font-weight: 900;
}

.smp-alert ul {
    margin: 0;
    padding-left: 1.15rem;
}

.smp-program-grid,
.smp-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}

.smp-program-card,
.smp-info-card {
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 1rem;
    background: #f8fbfa;
}

.smp-program-card h3,
.smp-info-card h3 {
    margin: 0 0 0.45rem;
    color: var(--brand-800);
    font-size: 1rem;
    font-weight: 900;
}

.smp-program-meter {
    height: 8px;
    overflow: hidden;
    border-radius: 999px;
    background: #dbe7e2;
}

.smp-program-meter span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--brand), var(--aqua));
}

.smp-program-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: 0.75rem;
    border-radius: 999px;
    padding: 0.3rem 0.65rem;
    font-size: 0.76rem;
    font-weight: 900;
}

.smp-program-status.available {
    background: var(--mint);
    color: var(--brand);
}

.smp-program-status.low {
    background: var(--gold-soft);
    color: var(--warning);
}

.smp-program-status.full {
    background: #fee2e2;
    color: #991b1b;
}

.smp-form-section {
    display: grid;
    gap: 1rem;
    padding-top: 1.25rem;
    border-top: 1px dashed var(--line);
}

.smp-form-section:first-of-type {
    border-top: 0;
    padding-top: 0;
}

.smp-section-title {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin: 0;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: 1.08rem;
    font-weight: 900;
}

.smp-section-title i {
    color: var(--gold);
}

.smp-fields {
    display: grid;
    grid-template-columns: repeat(12, minmax(0, 1fr));
    gap: 0.9rem;
}

.smp-field {
    grid-column: span 6;
}

.smp-field.third {
    grid-column: span 4;
}

.smp-field.full {
    grid-column: 1 / -1;
}

.smp-fields.full {
    grid-column: 1 / -1;
}

.smp-field label,
.smp-check label {
    display: block;
    margin-bottom: 0.35rem;
    color: var(--ink);
    font-size: 0.84rem;
    font-weight: 900;
}

.smp-field input,
.smp-field select,
.smp-field textarea {
    width: 100%;
    min-height: 44px;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 0.68rem 0.8rem;
    color: var(--text);
    background: #fff;
    font-weight: 700;
}

.smp-field input:focus,
.smp-field select:focus,
.smp-field textarea:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.12);
    outline: none;
}

.smp-check {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: 0.55rem;
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 0.75rem 0.85rem;
    background: #f8fbfa;
}

.smp-check input {
    width: 1.05rem;
    height: 1.05rem;
}

.smp-check label {
    margin: 0;
}

.smp-upload-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.9rem;
}

.smp-upload {
    border: 1px dashed #b8cbc4;
    border-radius: 14px;
    padding: 0.9rem;
    background: #f8fbfa;
}

.smp-upload label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--ink);
    font-size: 0.82rem;
    font-weight: 900;
}

.smp-upload input {
    width: 100%;
    font-size: 0.86rem;
}

.smp-upload small,
.smp-help {
    display: block;
    margin-top: 0.45rem;
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 700;
}

.smp-submit {
    min-height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    border: 0;
    border-radius: 12px;
    padding: 0.85rem 1.1rem;
    background: linear-gradient(135deg, var(--brand), var(--aqua));
    color: white;
    font-weight: 900;
}

.required {
    color: var(--danger);
}

@media (max-width: 820px) {
    .smp-program-grid,
    .smp-info-grid,
    .smp-upload-grid {
        grid-template-columns: 1fr;
    }

    .smp-field,
    .smp-field.third {
        grid-column: 1 / -1;
    }
}

@media (max-width: 560px) {
    .smp-registration-page {
        padding-left: 0.85rem;
        padding-right: 0.85rem;
    }

    .smp-form-body {
        padding: 1rem;
    }
}
</style>
@endpush

@section('content')
@php
    $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    $disabilities = ['Tidak Ada', 'Tuna Netra', 'Tuna Rungu', 'Tuna Wicara', 'Tuna Daksa', 'Tuna Laras', 'Autis', 'ADHD', 'Slow Learner'];
    $educationOptions = ['Tidak Sekolah', 'Putus Sekolah', 'SD/MI/Sederajat', 'SMP/MTs/Sederajat', 'SMA/SMK/MA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'];
    $jobOptions = ['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang', 'Wiraswasta', 'Buruh', 'Pensiunan', 'Lainnya'];
    $incomeOptions = ['< Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000'];
    $residenceOptions = ['Milik Sendiri', 'Sewa/Kontrak', 'Bersama Orang Tua', 'Lainnya'];
    $distanceOptions = ['< 1 km', '1 - 3 km', '3 - 5 km', '> 5 km'];
    $transportOptions = ['Jalan Kaki', 'Sepeda', 'Motor', 'Mobil', 'Angkutan Umum', 'Antar Jemput Sekolah'];

    $personalFields = [
        ['name' => 'kk_number', 'label' => 'Nomor KK', 'required' => true, 'maxlength' => 16, 'placeholder' => '16 digit'],
        ['name' => 'nik', 'label' => 'NIK Siswa', 'required' => true, 'maxlength' => 16, 'placeholder' => '16 digit'],
        ['name' => 'nisn', 'label' => 'NISN', 'required' => false, 'placeholder' => 'Opsional'],
        ['name' => 'full_name', 'label' => 'Nama Lengkap', 'required' => true, 'placeholder' => 'Sesuai dokumen resmi'],
        ['name' => 'birth_place', 'label' => 'Tempat Lahir', 'required' => true],
        ['name' => 'birth_date', 'label' => 'Tanggal Lahir', 'required' => true, 'class' => 'datepicker', 'placeholder' => 'dd/mm/yyyy'],
        ['name' => 'phone', 'label' => 'No HP/WhatsApp', 'required' => true, 'type' => 'tel', 'placeholder' => '08xxxxxxxxxx'],
        ['name' => 'email', 'label' => 'Email', 'required' => true, 'type' => 'email'],
        ['name' => 'previous_school', 'label' => 'Asal Sekolah', 'required' => true],
        ['name' => 'birth_certificate_number', 'label' => 'No. Akta Kelahiran', 'required' => true],
        ['name' => 'height', 'label' => 'Tinggi Badan (cm)', 'required' => true, 'type' => 'number', 'class' => 'third'],
        ['name' => 'weight', 'label' => 'Berat Badan (kg)', 'required' => true, 'type' => 'number', 'class' => 'third'],
        ['name' => 'head_circumference', 'label' => 'Lingkar Kepala (cm)', 'required' => false, 'type' => 'number', 'class' => 'third'],
        ['name' => 'siblings_count', 'label' => 'Jumlah Saudara', 'required' => true, 'type' => 'number'],
        ['name' => 'child_order', 'label' => 'Anak Ke', 'required' => true, 'type' => 'number'],
    ];

    $parentAddressFields = [
        ['name' => 'parent_ktp_village', 'label' => 'Kampung/Dusun'],
        ['name' => 'parent_ktp_rt', 'label' => 'RT', 'class' => 'third'],
        ['name' => 'parent_ktp_rw', 'label' => 'RW', 'class' => 'third'],
        ['name' => 'parent_ktp_subdistrict', 'label' => 'Desa/Kelurahan'],
        ['name' => 'parent_ktp_district', 'label' => 'Kecamatan'],
        ['name' => 'parent_ktp_city', 'label' => 'Kabupaten/Kota'],
        ['name' => 'parent_ktp_province', 'label' => 'Provinsi'],
    ];

    $currentAddressFields = [
        ['name' => 'current_village', 'label' => 'Kampung/Dusun'],
        ['name' => 'current_rt', 'label' => 'RT', 'class' => 'third'],
        ['name' => 'current_rw', 'label' => 'RW', 'class' => 'third'],
        ['name' => 'current_subdistrict', 'label' => 'Desa/Kelurahan'],
        ['name' => 'current_district', 'label' => 'Kecamatan'],
        ['name' => 'current_city', 'label' => 'Kabupaten/Kota'],
        ['name' => 'current_province', 'label' => 'Provinsi'],
    ];

    $fatherFields = [
        ['name' => 'father_nik', 'label' => 'NIK Ayah', 'maxlength' => 16],
        ['name' => 'father_name', 'label' => 'Nama Ayah'],
        ['name' => 'father_birth_place', 'label' => 'Tempat Lahir Ayah'],
        ['name' => 'father_birth_date', 'label' => 'Tanggal Lahir Ayah', 'class' => 'datepicker', 'placeholder' => 'dd/mm/yyyy'],
        ['name' => 'father_phone', 'label' => 'No HP Ayah', 'type' => 'tel'],
    ];

    $motherFields = [
        ['name' => 'mother_nik', 'label' => 'NIK Ibu', 'maxlength' => 16],
        ['name' => 'mother_name', 'label' => 'Nama Ibu'],
        ['name' => 'mother_birth_place', 'label' => 'Tempat Lahir Ibu'],
        ['name' => 'mother_birth_date', 'label' => 'Tanggal Lahir Ibu', 'class' => 'datepicker', 'placeholder' => 'dd/mm/yyyy'],
        ['name' => 'mother_phone', 'label' => 'No HP Ibu', 'type' => 'tel'],
    ];

    $guardianFields = [
        ['name' => 'guardian_nik', 'label' => 'NIK Wali', 'maxlength' => 16],
        ['name' => 'guardian_name', 'label' => 'Nama Wali'],
        ['name' => 'guardian_birth_place', 'label' => 'Tempat Lahir Wali'],
        ['name' => 'guardian_birth_date', 'label' => 'Tanggal Lahir Wali', 'class' => 'datepicker', 'placeholder' => 'dd/mm/yyyy'],
        ['name' => 'guardian_phone', 'label' => 'No HP Wali', 'type' => 'tel'],
    ];

    $uploads = [
        ['name' => 'photo', 'label' => 'Pas Foto Siswa', 'accept' => 'image/*', 'required' => true, 'help' => 'JPG/PNG maksimal 2MB.'],
        ['name' => 'kk_file', 'label' => 'Kartu Keluarga', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => true],
        ['name' => 'birth_certificate', 'label' => 'Akta Kelahiran', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => true],
        ['name' => 'mother_ktp', 'label' => 'KTP Ibu', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => true],
        ['name' => 'father_ktp', 'label' => 'KTP Ayah', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => true],
        ['name' => 'guardian_ktp', 'label' => 'KTP Wali', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => false],
        ['name' => 'diploma', 'label' => 'Ijazah/SKL', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => false],
        ['name' => 'report_card', 'label' => 'Rapor Siswa', 'accept' => '.pdf,.jpg,.jpeg,.png', 'required' => true],
    ];
@endphp

<div class="smp-registration-page">
    <article class="smp-form-card">
        <header class="smp-form-header">
            <div>
                <h1><i class="fas fa-school me-2"></i>Formulir Pendaftaran SMPS</h1>
                <p>Lengkapi data calon siswa, orang tua, alamat, dan dokumen pendukung.</p>
            </div>
            <span class="smp-form-badge"><i class="fas fa-calendar-check"></i>SPMB 2026/2027</span>
        </header>

        <div class="smp-form-body">
            <div class="smp-alert">
                <h2><i class="fas fa-circle-info me-2"></i>Petunjuk Pengisian</h2>
                <ul>
                    <li>Field bertanda <span class="required">*</span> wajib diisi.</li>
                    <li>Dokumen maksimal 2MB dengan format PDF, JPG, JPEG, atau PNG.</li>
                    <li>Pastikan NIK dan nomor KK sesuai dokumen asli.</li>
                </ul>
            </div>

            <div class="smp-info-grid">
                <div class="smp-info-card">
                    <h3><i class="fas fa-sun me-2"></i>Sekolah Umum</h3>
                    <p class="mb-0">Siswa belajar pagi hingga siang seperti sekolah reguler.</p>
                </div>
                <div class="smp-info-card">
                    <h3><i class="fas fa-mosque me-2"></i>Sekolah dan Asrama</h3>
                    <p class="mb-0">Siswa tinggal di asrama dengan pembinaan keagamaan lebih intensif.</p>
                </div>
            </div>

            <section class="smp-form-section">
                <h2 class="smp-section-title"><i class="fas fa-layer-group"></i>Kuota Program</h2>
                <div class="smp-program-grid">
                    @foreach($quotaInfo as $quota)
                        <div class="smp-program-card">
                            <h3>{{ $quota['program'] }}</h3>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="smp-help m-0">Tersedia</span>
                                <strong>{{ $quota['available_quota'] }}/{{ $quota['quota'] }}</strong>
                            </div>
                            <div class="smp-program-meter">
                                <span style="width: {{ $quota['percentage'] }}%"></span>
                            </div>
                            <span class="smp-program-status {{ $quota['status'] }}">
                                @if($quota['status'] === 'full')
                                    <i class="fas fa-xmark-circle"></i>Kuota penuh
                                @elseif($quota['status'] === 'low')
                                    <i class="fas fa-triangle-exclamation"></i>Tersisa sedikit
                                @else
                                    <i class="fas fa-check-circle"></i>Tersedia
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-circle-exclamation me-2"></i>Perbaiki data berikut:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('smp.registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                @csrf

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-user"></i>Data Pribadi Siswa</h2>
                    <div class="smp-fields">
                        <div class="smp-field">
                            <label>Wilayah KK <span class="required">*</span></label>
                            <select name="kk_area" required>
                                <option value="">Pilih Wilayah</option>
                                <option value="Dalam Wilayah Banten" {{ old('kk_area') === 'Dalam Wilayah Banten' ? 'selected' : '' }}>Dalam Wilayah Banten</option>
                                <option value="Di Luar Wilayah Banten" {{ old('kk_area') === 'Di Luar Wilayah Banten' ? 'selected' : '' }}>Di Luar Wilayah Banten</option>
                            </select>
                            @error('kk_area')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        @foreach($personalFields as $field)
                            <div class="smp-field {{ $field['class'] ?? '' }}">
                                <label>{{ $field['label'] }} @if($field['required'] ?? true)<span class="required">*</span>@endif</label>
                                <input type="{{ $field['type'] ?? 'text' }}"
                                       name="{{ $field['name'] }}"
                                       value="{{ old($field['name']) }}"
                                       class="{{ $field['class'] ?? '' }}"
                                       placeholder="{{ $field['placeholder'] ?? '' }}"
                                       @if(!empty($field['maxlength'])) maxlength="{{ $field['maxlength'] }}" @endif
                                       @if($field['required'] ?? true) required @endif>
                                @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        @endforeach

                        <div class="smp-field">
                            <label>Jenis Kelamin <span class="required">*</span></label>
                            <select name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Agama <span class="required">*</span></label>
                            <select name="religion" required>
                                <option value="">Pilih Agama</option>
                                @foreach($religions as $option)
                                    <option value="{{ $option }}" {{ old('religion') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('religion')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Program Sekolah <span class="required">*</span></label>
                            <select name="school_program" required>
                                <option value="">Pilih Program</option>
                                @foreach($quotaInfo as $quota)
                                    <option value="{{ $quota['program'] }}"
                                            {{ old('school_program') === $quota['program'] ? 'selected' : '' }}
                                            {{ $quota['status'] === 'full' ? 'disabled' : '' }}>
                                        {{ $quota['program'] }}
                                        @if($quota['status'] === 'full') - Kuota Penuh
                                        @elseif($quota['status'] === 'low') - Sisa {{ $quota['available_quota'] }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('school_program')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Kewarganegaraan <span class="required">*</span></label>
                            <select name="citizenship" required>
                                <option value="">Pilih Kewarganegaraan</option>
                                <option value="WNI" {{ old('citizenship') === 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('citizenship') === 'WNA' ? 'selected' : '' }}>WNA</option>
                            </select>
                            @error('citizenship')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field full">
                            <label>Berkebutuhan Khusus <span class="required">*</span></label>
                            <select name="disability" required>
                                @foreach($disabilities as $option)
                                    <option value="{{ $option }}" {{ old('disability', 'Tidak Ada') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('disability')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </section>

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-location-dot"></i>Alamat KTP Orang Tua</h2>
                    <div class="smp-fields">
                        @foreach($parentAddressFields as $field)
                            <div class="smp-field {{ $field['class'] ?? '' }}">
                                <label>{{ $field['label'] }} <span class="required">*</span></label>
                                <input type="text" name="{{ $field['name'] }}" value="{{ old($field['name']) }}" required>
                                @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        @endforeach

                        <div class="smp-field">
                            <label>Status Tempat Tinggal <span class="required">*</span></label>
                            <select name="parent_ktp_residence_status" required>
                                <option value="">Pilih Status</option>
                                @foreach($residenceOptions as $option)
                                    <option value="{{ $option }}" {{ old('parent_ktp_residence_status') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_residence_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Jarak ke Sekolah <span class="required">*</span></label>
                            <select name="parent_ktp_distance_to_school" required>
                                <option value="">Pilih Jarak</option>
                                @foreach($distanceOptions as $option)
                                    <option value="{{ $option }}" {{ old('parent_ktp_distance_to_school') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_distance_to_school')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Transportasi <span class="required">*</span></label>
                            <select name="parent_ktp_transportation" required>
                                <option value="">Pilih Transportasi</option>
                                @foreach($transportOptions as $option)
                                    <option value="{{ $option }}" {{ old('parent_ktp_transportation') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_transportation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </section>

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-house-user"></i>Alamat Domisili Siswa</h2>
                    <div class="smp-fields">
                        <div class="smp-check">
                            <input type="checkbox" name="same_as_ktp" id="sameAsKtp" {{ old('same_as_ktp') ? 'checked' : '' }}>
                            <label for="sameAsKtp">Alamat domisili sama dengan alamat KTP orang tua</label>
                        </div>

                        <div class="smp-fields full" id="currentAddressFields">
                            @foreach($currentAddressFields as $field)
                                <div class="smp-field {{ $field['class'] ?? '' }}">
                                    <label>{{ $field['label'] }}</label>
                                    <input type="text" name="{{ $field['name'] }}" value="{{ old($field['name']) }}">
                                    @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            @endforeach

                            <div class="smp-field">
                                <label>Status Tempat Tinggal</label>
                                <select name="current_residence_status">
                                    <option value="">Pilih Status</option>
                                    @foreach($residenceOptions as $option)
                                        <option value="{{ $option }}" {{ old('current_residence_status') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('current_residence_status')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="smp-field">
                                <label>Jarak ke Sekolah</label>
                                <select name="current_distance_to_school">
                                    <option value="">Pilih Jarak</option>
                                    @foreach($distanceOptions as $option)
                                        <option value="{{ $option }}" {{ old('current_distance_to_school') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('current_distance_to_school')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="smp-field">
                                <label>Transportasi</label>
                                <select name="current_transportation">
                                    <option value="">Pilih Transportasi</option>
                                    @foreach($transportOptions as $option)
                                        <option value="{{ $option }}" {{ old('current_transportation') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('current_transportation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-user-group"></i>Data Orang Tua</h2>
                    <div class="smp-fields">
                        @foreach($fatherFields as $field)
                            <div class="smp-field">
                                <label>{{ $field['label'] }} <span class="required">*</span></label>
                                <input type="{{ $field['type'] ?? 'text' }}"
                                       name="{{ $field['name'] }}"
                                       value="{{ old($field['name']) }}"
                                       class="{{ $field['class'] ?? '' }}"
                                       placeholder="{{ $field['placeholder'] ?? '' }}"
                                       @if(!empty($field['maxlength'])) maxlength="{{ $field['maxlength'] }}" @endif
                                       required>
                                @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        @endforeach

                        <div class="smp-field">
                            <label>Pendidikan Ayah <span class="required">*</span></label>
                            <select name="father_education" required>
                                <option value="">Pilih Pendidikan</option>
                                @foreach($educationOptions as $option)
                                    <option value="{{ $option }}" {{ old('father_education') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('father_education')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Pekerjaan Ayah <span class="required">*</span></label>
                            <select name="father_occupation" required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($jobOptions as $option)
                                    <option value="{{ $option }}" {{ old('father_occupation') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('father_occupation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Penghasilan Ayah <span class="required">*</span></label>
                            <select name="father_income" required>
                                <option value="">Pilih Penghasilan</option>
                                @foreach($incomeOptions as $option)
                                    <option value="{{ $option }}" {{ old('father_income') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('father_income')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Berkebutuhan Khusus Ayah <span class="required">*</span></label>
                            <select name="father_disability" required>
                                @foreach($disabilities as $option)
                                    <option value="{{ $option }}" {{ old('father_disability', 'Tidak Ada') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('father_disability')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        @foreach($motherFields as $field)
                            <div class="smp-field">
                                <label>{{ $field['label'] }} <span class="required">*</span></label>
                                <input type="{{ $field['type'] ?? 'text' }}"
                                       name="{{ $field['name'] }}"
                                       value="{{ old($field['name']) }}"
                                       class="{{ $field['class'] ?? '' }}"
                                       placeholder="{{ $field['placeholder'] ?? '' }}"
                                       @if(!empty($field['maxlength'])) maxlength="{{ $field['maxlength'] }}" @endif
                                       required>
                                @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        @endforeach

                        <div class="smp-field">
                            <label>Pendidikan Ibu <span class="required">*</span></label>
                            <select name="mother_education" required>
                                <option value="">Pilih Pendidikan</option>
                                @foreach($educationOptions as $option)
                                    <option value="{{ $option }}" {{ old('mother_education') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('mother_education')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Pekerjaan Ibu <span class="required">*</span></label>
                            <select name="mother_occupation" required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($jobOptions as $option)
                                    <option value="{{ $option }}" {{ old('mother_occupation') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('mother_occupation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Penghasilan Ibu <span class="required">*</span></label>
                            <select name="mother_income" required>
                                <option value="">Pilih Penghasilan</option>
                                @foreach($incomeOptions as $option)
                                    <option value="{{ $option }}" {{ old('mother_income') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('mother_income')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="smp-field">
                            <label>Berkebutuhan Khusus Ibu <span class="required">*</span></label>
                            <select name="mother_disability" required>
                                @foreach($disabilities as $option)
                                    <option value="{{ $option }}" {{ old('mother_disability', 'Tidak Ada') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('mother_disability')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </section>

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-user-shield"></i>Data Wali</h2>
                    <div class="smp-fields">
                        <div class="smp-check">
                            <input type="checkbox" name="has_guardian" id="hasGuardian" {{ old('has_guardian') ? 'checked' : '' }}>
                            <label for="hasGuardian">Calon siswa memiliki wali selain orang tua</label>
                        </div>

                        <div class="smp-fields full {{ old('has_guardian') ? '' : 'd-none' }}" id="guardianFields">
                            @foreach($guardianFields as $field)
                                <div class="smp-field">
                                    <label>{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] ?? 'text' }}"
                                           name="{{ $field['name'] }}"
                                           value="{{ old($field['name']) }}"
                                           class="{{ $field['class'] ?? '' }}"
                                           placeholder="{{ $field['placeholder'] ?? '' }}"
                                           @if(!empty($field['maxlength'])) maxlength="{{ $field['maxlength'] }}" @endif>
                                    @error($field['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            @endforeach

                            <div class="smp-field">
                                <label>Pendidikan Wali</label>
                                <select name="guardian_education">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach($educationOptions as $option)
                                        <option value="{{ $option }}" {{ old('guardian_education') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_education')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="smp-field">
                                <label>Pekerjaan Wali</label>
                                <select name="guardian_occupation">
                                    <option value="">Pilih Pekerjaan</option>
                                    @foreach($jobOptions as $option)
                                        <option value="{{ $option }}" {{ old('guardian_occupation') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_occupation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="smp-field">
                                <label>Penghasilan Wali</label>
                                <select name="guardian_income">
                                    <option value="">Pilih Penghasilan</option>
                                    @foreach($incomeOptions as $option)
                                        <option value="{{ $option }}" {{ old('guardian_income') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_income')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="smp-field">
                                <label>Berkebutuhan Khusus Wali</label>
                                <select name="guardian_disability">
                                    @foreach($disabilities as $option)
                                        <option value="{{ $option }}" {{ old('guardian_disability', 'Tidak Ada') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_disability')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="smp-form-section">
                    <h2 class="smp-section-title"><i class="fas fa-file-arrow-up"></i>Upload Dokumen</h2>
                    <div class="smp-upload-grid">
                        @foreach($uploads as $upload)
                            <div class="smp-upload">
                                <label>{{ $upload['label'] }} @if($upload['required'])<span class="required">*</span>@endif</label>
                                <input type="file"
                                       name="{{ $upload['name'] }}"
                                       accept="{{ $upload['accept'] }}"
                                       @if($upload['required']) required @endif>
                                <small>{{ $upload['help'] ?? 'PDF/JPG/PNG maksimal 2MB.' }}</small>
                                @error($upload['name'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="smp-form-section">
                    <button type="submit" class="smp-submit">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pendaftaran SMPS
                    </button>
                </div>
            </form>
        </div>
    </article>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sameAsKtp = document.getElementById('sameAsKtp');
    const currentAddress = document.getElementById('currentAddressFields');
    const hasGuardian = document.getElementById('hasGuardian');
    const guardianFields = document.getElementById('guardianFields');

    function syncSameAsKtp() {
        currentAddress?.classList.toggle('d-none', sameAsKtp?.checked);
    }

    function syncGuardian() {
        guardianFields?.classList.toggle('d-none', !hasGuardian?.checked);
    }

    sameAsKtp?.addEventListener('change', syncSameAsKtp);
    hasGuardian?.addEventListener('change', syncGuardian);
    syncSameAsKtp();
    syncGuardian();

    if (window.flatpickr) {
        flatpickr('.datepicker', {
            dateFormat: 'd/m/Y',
            allowInput: true,
            locale: window.flatpickr.l10ns?.id || undefined,
        });
    }
});
</script>
@endpush
