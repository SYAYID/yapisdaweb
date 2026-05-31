@extends('layouts.app')

@section('title', 'Formulir Pendaftaran - SPMB 2026/2027')

@push('styles')
<style>
/* === INHERIT DESIGN TOKENS dari layouts.app === */
:root {
    --primary:       #2E6B4F;
    --primary-dark:  #1E4535;
    --primary-light: #3D8B67;
    --gold:          #C9A84C;
    --gold-light:    #E8C97A;
    --gold-dark:     #A07830;
    --gold-pale:     #F5EDD8;
    --forest:        #0D2118;
    --forest-mid:    #163328;
    --forest-soft:   #1E4535;
    --moss:          #2E6B4F;
    --moss-light:    #3D8B67;
    --ivory:         #FAF7F0;
    --ivory-dark:    #EDE8DC;
    --cream:         #F0EAD6;
    --text-dark:     #1A1208;
    --text-mid:      #4A3F28;
    --text-muted:    #8A7A58;

    --bg-page:       var(--ivory);
    --bg-card:       #ffffff;
    --text-primary:  var(--text-dark);
    --border:        var(--ivory-dark);
    --border-focus:  var(--gold-dark);

    --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 20px rgba(0,0,0,0.10);
    --shadow-gold: 0 8px 30px rgba(201,168,76,0.22);

    --radius:    14px;
    --radius-lg: 20px;

    --transition: all 0.2s ease-in-out;

    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;
}

/* === BASE === */
body {
    font-family: var(--ff-body);
    background: var(--bg-page);
    color: var(--text-primary);
    line-height: 1.6;
}

/* === FORM CONTAINER === */
.form-wrapper {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

.form-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-bottom: 2rem;
}

.form-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    padding: 1.5rem 2rem;
    color: white;
    border-bottom: 2px solid var(--gold);
    position: relative;
}

.form-header::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 2rem;
    width: 60px;
    height: 2px;
    background: var(--gold-light);
    border-radius: 999px;
}

.form-header h4 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.4rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-header h4 i {
    color: var(--gold-light);
    font-size: 1.2rem;
}

.form-body {
    padding: 2rem;
}

/* === ALERTS === */
.alert-custom {
    border: none;
    border-left: 4px solid;
    border-radius: var(--radius);
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    font-size: 0.9rem;
}

.alert-warning-custom {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-left-color: var(--warning);
    color: var(--warning-text);
}

.alert-info-custom {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-left-color: var(--info);
    color: var(--info-text);
}

.alert-custom h5 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-custom ol,
.alert-custom ul {
    margin: 0;
    padding-left: 1.25rem;
}

.alert-custom li {
    margin-bottom: 0.25rem;
}

/* === QUOTA CARDS === */
.quota-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin: 1.5rem 0;
}

.quota-card {
    background: var(--bg-card);
    border: 2px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.quota-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.quota-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.quota-card:hover::before {
    opacity: 1;
}

.quota-card.available { border-color: var(--success); }
.quota-card.low { border-color: var(--warning); }
.quota-card.full { border-color: var(--danger); opacity: 0.85; }

.quota-card h6 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.75rem;
    color: var(--forest);
}

.quota-progress {
    margin: 0.75rem 0;
}

.quota-progress .progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.quota-progress .progress {
    height: 6px;
    background: var(--ivory-dark);
    border-radius: 999px;
    overflow: hidden;
}

.quota-progress .progress-bar {
    border-radius: 999px;
    transition: width 0.4s ease;
}

.quota-progress .progress-bar.available { background: linear-gradient(90deg, var(--moss-light), var(--moss)); }
.quota-progress .progress-bar.low { background: var(--warning); }
.quota-progress .progress-bar.full { background: var(--danger); }

.quota-status {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.quota-status.available { background: var(--success-bg); color: var(--success-text); }
.quota-status.low { background: var(--warning-bg); color: var(--warning-text); }
.quota-status.full { background: var(--danger-bg); color: var(--danger-text); }

/* === SECTION DIVIDER === */
.form-section {
    margin: 2rem 0;
    padding-top: 1.5rem;
    border-top: 1px dashed var(--border);
}

.form-section:first-child {
    margin-top: 0;
    padding-top: 0;
    border-top: none;
}

.form-section-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.2rem;
    color: var(--forest);
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--gold-pale);
}

.form-section-title i {
    color: var(--gold-dark);
}

.form-section-title small {
    font-family: var(--ff-body);
    font-size: 0.85rem;
    font-weight: 400;
    color: var(--danger);
    margin-left: auto;
}

/* === FORM FIELDS === */
.form-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-mid);
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-label .required {
    color: var(--danger);
    font-weight: 700;
}

.form-control,
.form-select {
    padding: 0.7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--ff-body);
    background: white;
    color: var(--text-dark);
    transition: var(--transition);
    width: 100%;
}

.form-control:focus,
.form-select:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 4px rgba(160, 120, 48, 0.12);
    background: #fffef9;
}

.form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: var(--danger);
    background-image: none;
}

.form-control.is-invalid:focus,
.form-select.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
}

.invalid-feedback {
    font-size: 0.8rem;
    color: var(--danger);
    margin-top: 0.3rem;
    font-weight: 500;
}

/* === FILE UPLOAD === */
.file-upload-wrapper {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    padding: 1rem;
    background: var(--ivory);
    transition: var(--transition);
}

.file-upload-wrapper:hover {
    border-color: var(--gold);
    background: var(--gold-pale);
}

.file-upload-wrapper input[type="file"] {
    font-size: 0.9rem;
}

.file-upload-wrapper small {
    display: block;
    margin-top: 0.4rem;
    color: var(--text-muted);
    font-size: 0.8rem;
}

/* === CHECKBOX & RADIO === */
.form-check {
    padding-left: 1.75rem;
    margin-bottom: 0.5rem;
}

.form-check-input {
    width: 1.1rem;
    height: 1.1rem;
    margin-left: -1.75rem;
    border: 2px solid var(--border);
    border-radius: 6px;
    cursor: pointer;
    transition: var(--transition);
}

.form-check-input:checked {
    background-color: var(--moss);
    border-color: var(--moss);
}

.form-check-input:focus {
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 4px rgba(160, 120, 48, 0.12);
}

.form-check-label {
    font-weight: 500;
    color: var(--text-mid);
    cursor: pointer;
    font-size: 0.95rem;
}

/* === TOGGLE FIELDS === */
.toggle-fields {
    background: var(--ivory);
    border-radius: var(--radius);
    padding: 1.25rem;
    margin-top: 0.5rem;
    border: 1px solid var(--border);
    transition: var(--transition);
}

.toggle-fields.d-none {
    display: none !important;
}

/* === SUBMIT BUTTON === */
.form-actions {
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.btn-submit {
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    border: none;
    border-radius: var(--radius);
    font-weight: 700;
    font-size: 1.05rem;
    font-family: var(--ff-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(46, 107, 79, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.btn-submit:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(46, 107, 79, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit i {
    font-size: 1.1rem;
}

/* === ERROR SUMMARY === */
.error-summary {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 1px solid #fecaca;
    border-left: 4px solid var(--danger);
    border-radius: var(--radius);
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}

.error-summary h5 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.05rem;
    color: var(--danger-text);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.error-summary ul {
    margin: 0;
    padding-left: 1.25rem;
    color: var(--danger-text);
    font-size: 0.9rem;
}

.error-summary li {
    margin-bottom: 0.25rem;
}

/* === HELPER TEXT === */
.form-text {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.3rem;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .form-wrapper {
        padding: 0 1rem;
        margin: 1rem auto;
    }

    .form-body {
        padding: 1.5rem;
    }

    .form-header {
        padding: 1.25rem 1.5rem;
    }

    .form-header h4 {
        font-size: 1.2rem;
    }

    .quota-grid {
        grid-template-columns: 1fr;
    }

    .btn-submit {
        font-size: 1rem;
        padding: 0.9rem 1.5rem;
    }
}

/* === PRINT === */
@media print {
    .form-wrapper {
        margin: 0;
        padding: 0;
    }

    .form-card {
        box-shadow: none;
        border: 1px solid #ccc;
    }

    .btn-submit,
    .file-upload-wrapper,
    .form-actions {
        display: none;
    }
}

/* === ANIMATIONS === */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-section {
    animation: fadeIn 0.3s ease forwards;
}

.form-section:nth-child(1) { animation-delay: 0.05s; }
.form-section:nth-child(2) { animation-delay: 0.1s; }
.form-section:nth-child(3) { animation-delay: 0.15s; }
.form-section:nth-child(4) { animation-delay: 0.2s; }
.form-section:nth-child(5) { animation-delay: 0.25s; }
</style>
@endpush

@section('content')
<div class="form-wrapper">

    <div class="form-card">
        <!-- Header -->
        <div class="form-header">
            <h4>
                <i class="fas fa-edit"></i>
                Formulir Pendaftaran Siswa Baru 2026/2027
            </h4>
        </div>

        <div class="form-body">

            <!-- Alerts -->
            <div class="alert-custom alert-warning-custom">
                <h5><i class="fas fa-exclamation-triangle"></i>Perhatian!</h5>
                <ol>
                    <li>Semua field bertanda <span class="required">*</span> wajib diisi</li>
                    <li>Ukuran file maksimal 2MB untuk setiap dokumen</li>
                    <li>Format file: PDF, JPG, JPEG, PNG</li>
                    <li>Pastikan data sesuai dokumen asli</li>
                    <li>NIK tidak dapat digunakan lebih dari satu kali</li>
                </ol>
            </div>

            <div class="alert-custom alert-info-custom">
                <h5><i class="fas fa-info-circle"></i>Informasi Kuota</h5>
                <p class="mb-0">Pilih jurusan yang masih memiliki kuota tersedia. Kuota berkurang setelah verifikasi admin.</p>
            </div>

            <!-- Quota Cards -->
            <div class="quota-grid">
                @foreach($quotaInfo as $quota)
                    <div class="quota-card {{ $quota['status'] }}">
                        <h6>{{ $quota['major'] }}</h6>

                        <div class="quota-progress">
                            <div class="progress-label">
                                <small>Tersedia</small>
                                <small class="fw-bold">{{ $quota['available_quota'] }}/{{ $quota['quota'] }}</small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar {{ $quota['status'] }}"
                                     style="width: {{ $quota['percentage'] }}%">
                                </div>
                            </div>
                            <small class="text-muted">{{ $quota['percentage'] }}% terisi</small>
                        </div>

                        @if($quota['status'] == 'full')
                            <span class="quota-status full"><i class="fas fa-times-circle"></i>Penuh</span>
                        @elseif($quota['status'] == 'low')
                            <span class="quota-status low"><i class="fas fa-exclamation-triangle"></i>Sedikit</span>
                        @else
                            <span class="quota-status available"><i class="fas fa-check-circle"></i>Tersedia</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Error Summary -->
            @if($errors->any())
                <div class="error-summary">
                    <h5><i class="fas fa-exclamation-circle"></i>Perbaiki Kesalahan:</h5>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                @csrf

                <!-- DATA PRIBADI SISWA -->
                <div class="form-section">
                    <h5 class="form-section-title">
                        <i class="fas fa-user"></i>Data Pribadi Siswa
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Wilayah KK <span class="required">*</span></label>
                            <select name="kk_area" class="form-select @error('kk_area') is-invalid @enderror" required>
                                <option value="">Pilih Wilayah</option>
                                <option value="Dalam Wilayah Banten" {{ old('kk_area') == 'Dalam Wilayah Banten' ? 'selected' : '' }}>Dalam Wilayah Banten</option>
                                <option value="Di Luar Wilayah Banten" {{ old('kk_area') == 'Di Luar Wilayah Banten' ? 'selected' : '' }}>Di Luar Wilayah Banten</option>
                            </select>
                            @error('kk_area')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor KK (16 digit) <span class="required">*</span></label>
                            <input type="text" name="kk_number" class="form-control @error('kk_number') is-invalid @enderror"
                                   value="{{ old('kk_number') }}" maxlength="16" required placeholder="Contoh: 3601012345678901">
                            @error('kk_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor NIK <span class="required">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                   value="{{ old('nik') }}" maxlength="16" required placeholder="16 digit angka">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                                   value="{{ old('nisn') }}" placeholder="Opsional">
                            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name') }}" required placeholder="Sesuai akta kelahiran">
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="required">*</span></label>
                            <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror"
                                   value="{{ old('birth_place') }}" required>
                            @error('birth_place')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                            <input type="text" name="birth_date" class="form-control datepicker @error('birth_date') is-invalid @enderror"
                                value="{{ old('birth_date') }}" placeholder="dd/mm/yyyy" required>
                            @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agama <span class="required">*</span></label>
                            <select name="religion" class="form-select @error('religion') is-invalid @enderror" required>
                                <option value="">Pilih Agama</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $rel)
                                    <option value="{{ $rel }}" {{ old('religion') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                @endforeach
                            </select>
                            @error('religion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No HP/WhatsApp <span class="required">*</span></label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Asal Sekolah <span class="required">*</span></label>
                            <input type="text" name="previous_school" class="form-control @error('previous_school') is-invalid @enderror"
                                   value="{{ old('previous_school') }}" required>
                            @error('previous_school')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jurusan Pilihan <span class="required">*</span></label>
                            <select name="major_choice" class="form-select @error('major_choice') is-invalid @enderror" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($quotaInfo as $quota)
                                    <option value="{{ $quota['major'] }}"
                                            {{ old('major_choice') == $quota['major'] ? 'selected' : '' }}
                                            {{ $quota['status'] == 'full' ? 'disabled' : '' }}>
                                        {{ $quota['major'] }}
                                        @if($quota['status'] == 'full') - (Penuh)
                                        @elseif($quota['status'] == 'low') - (Sisa {{ $quota['available_quota'] }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('major_choice')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kewarganegaraan <span class="required">*</span></label>
                            <select name="citizenship" class="form-select @error('citizenship') is-invalid @enderror" required>
                                <option value="">Pilih</option>
                                <option value="WNI" {{ old('citizenship') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('citizenship') == 'WNA' ? 'selected' : '' }}>WNA</option>
                            </select>
                            @error('citizenship')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Akta Kelahiran <span class="required">*</span></label>
                            <input type="text" name="birth_certificate_number" class="form-control @error('birth_certificate_number') is-invalid @enderror"
                                   value="{{ old('birth_certificate_number') }}" required>
                            @error('birth_certificate_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tinggi Badan (cm) <span class="required">*</span></label>
                            <input type="number" name="height" class="form-control @error('height') is-invalid @enderror"
                                   value="{{ old('height') }}" required min="50" max="250">
                            @error('height')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Berat Badan (kg) <span class="required">*</span></label>
                            <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                                   value="{{ old('weight') }}" required min="20" max="200">
                            @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Lingkar Kepala (cm)</label>
                            <input type="number" name="head_circumference" class="form-control @error('head_circumference') is-invalid @enderror"
                                   value="{{ old('head_circumference') }}" min="30" max="80">
                            @error('head_circumference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Saudara <span class="required">*</span></label>
                            <input type="number" name="siblings_count" class="form-control @error('siblings_count') is-invalid @enderror"
                                   value="{{ old('siblings_count') }}" required min="0">
                            @error('siblings_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Anak Ke <span class="required">*</span></label>
                            <input type="number" name="child_order" class="form-control @error('child_order') is-invalid @enderror"
                                   value="{{ old('child_order') }}" required min="1">
                            @error('child_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Berkebutuhan Khusus <span class="required">*</span></label>
                            <select name="disability" class="form-select @error('disability') is-invalid @enderror" required>
                                <option value="Tidak Ada" {{ old('disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                @foreach(['Tuna Netra','Tuna Rungu','Tuna Wicara','Tuna Daksa','Tuna Laras','Autis','ADHD','Slow Learner'] as $d)
                                    <option value="{{ $d }}" {{ old('disability') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="mt-4">
                        <label class="form-label">Pas Foto Siswa <span class="required">*</span></label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*" required>
                            <small><i class="fas fa-info-circle me-1"></i>Maksimal 2MB, latar merah, seragam sekolah, format JPG/PNG</small>
                        </div>
                        @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- ALAMAT KTP ORANG TUA -->
                <div class="form-section">
                    <h5 class="form-section-title">
                        <i class="fas fa-home"></i>Alamat KTP Orang Tua
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kampung/Dusun <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_village" class="form-control @error('parent_ktp_village') is-invalid @enderror"
                                   value="{{ old('parent_ktp_village') }}" required>
                            @error('parent_ktp_village')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">RT <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_rt" class="form-control @error('parent_ktp_rt') is-invalid @enderror"
                                   value="{{ old('parent_ktp_rt') }}" required maxlength="3">
                            @error('parent_ktp_rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">RW <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_rw" class="form-control @error('parent_ktp_rw') is-invalid @enderror"
                                   value="{{ old('parent_ktp_rw') }}" required maxlength="3">
                            @error('parent_ktp_rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Desa/Kelurahan <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_subdistrict" class="form-control @error('parent_ktp_subdistrict') is-invalid @enderror"
                                   value="{{ old('parent_ktp_subdistrict') }}" required>
                            @error('parent_ktp_subdistrict')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kecamatan <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_district" class="form-control @error('parent_ktp_district') is-invalid @enderror"
                                   value="{{ old('parent_ktp_district') }}" required>
                            @error('parent_ktp_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_city" class="form-control @error('parent_ktp_city') is-invalid @enderror"
                                value="{{ old('parent_ktp_city') }}" required>
                            @error('parent_ktp_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Provinsi <span class="required">*</span></label>
                            <input type="text" name="parent_ktp_province" class="form-control @error('parent_ktp_province') is-invalid @enderror"
                                   value="{{ old('parent_ktp_province') }}" required>
                            @error('parent_ktp_province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Tempat Tinggal <span class="required">*</span></label>
                            <select name="parent_ktp_residence_status" class="form-select @error('parent_ktp_residence_status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                @foreach(['Milik Sendiri','Sewa/Kontrak','Bersama Orang Tua','Lainnya'] as $s)
                                    <option value="{{ $s }}" {{ old('parent_ktp_residence_status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_residence_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jarak ke Sekolah <span class="required">*</span></label>
                            <select name="parent_ktp_distance_to_school" class="form-select @error('parent_ktp_distance_to_school') is-invalid @enderror" required>
                                <option value="">Pilih Jarak</option>
                                @foreach(['< 1 km','1 - 3 km','3 - 5 km','> 5 km'] as $d)
                                    <option value="{{ $d }}" {{ old('parent_ktp_distance_to_school') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_distance_to_school')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Moda Transportasi <span class="required">*</span></label>
                            <select name="parent_ktp_transportation" class="form-select @error('parent_ktp_transportation') is-invalid @enderror" required>
                                <option value="">Pilih Transportasi</option>
                                @foreach(['Jalan Kaki','Sepeda','Motor','Mobil','Angkutan Umum','Antar Jemput Sekolah'] as $t)
                                    <option value="{{ $t }}" {{ old('parent_ktp_transportation') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('parent_ktp_transportation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- ALAMAT DOMISILI -->
                <div class="form-section">
                    <h5 class="form-section-title">
                        <i class="fas fa-map-marker-alt"></i>Alamat Domisili Siswa
                    </h5>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="same_as_ktp" id="sameAsKtp" {{ old('same_as_ktp') ? 'checked' : '' }}>
                        <label class="form-check-label" for="sameAsKtp">
                            Alamat domisili sama dengan alamat KTP orang tua
                        </label>
                    </div>

                    <div id="currentAddressFields" class="toggle-fields {{ old('same_as_ktp') ? 'd-none' : '' }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kampung/Dusun <span class="required">*</span></label>
                                <input type="text" name="current_village" class="form-control @error('current_village') is-invalid @enderror"
                                       value="{{ old('current_village') }}">
                                @error('current_village')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RT <span class="required">*</span></label>
                                <input type="text" name="current_rt" class="form-control @error('current_rt') is-invalid @enderror"
                                       value="{{ old('current_rt') }}">
                                @error('current_rt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RW <span class="required">*</span></label>
                                <input type="text" name="current_rw" class="form-control @error('current_rw') is-invalid @enderror"
                                       value="{{ old('current_rw') }}">
                                @error('current_rw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Desa/Kelurahan <span class="required">*</span></label>
                                <input type="text" name="current_subdistrict" class="form-control @error('current_subdistrict') is-invalid @enderror"
                                       value="{{ old('current_subdistrict') }}">
                                @error('current_subdistrict')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kecamatan <span class="required">*</span></label>
                                <input type="text" name="current_district" class="form-control @error('current_district') is-invalid @enderror"
                                       value="{{ old('current_district') }}">
                                @error('current_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                                <input type="text" name="current_city" class="form-control @error('current_city') is-invalid @enderror"
                                    value="{{ old('current_city') }}">
                                @error('current_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="required">*</span></label>
                                <input type="text" name="current_province" class="form-control @error('current_province') is-invalid @enderror"
                                       value="{{ old('current_province') }}">
                                @error('current_province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span class="required">*</span></label>
                                <select name="current_residence_status" class="form-select @error('current_residence_status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    @foreach(['Milik Sendiri','Sewa/Kontrak','Bersama Orang Tua','Lainnya'] as $s)
                                        <option value="{{ $s }}" {{ old('current_residence_status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('current_residence_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah <span class="required">*</span></label>
                                <select name="current_distance_to_school" class="form-select @error('current_distance_to_school') is-invalid @enderror">
                                    <option value="">Pilih Jarak</option>
                                    @foreach(['< 1 km','1 - 3 km','3 - 5 km','> 5 km'] as $d)
                                        <option value="{{ $d }}" {{ old('current_distance_to_school') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endforeach
                                </select>
                                @error('current_distance_to_school')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Moda Transportasi <span class="required">*</span></label>
                                <select name="current_transportation" class="form-select @error('current_transportation') is-invalid @enderror">
                                    <option value="">Pilih Transportasi</option>
                                    @foreach(['Jalan Kaki','Sepeda','Motor','Mobil','Angkutan Umum','Antar Jemput Sekolah'] as $t)
                                        <option value="{{ $t }}" {{ old('current_transportation') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('current_transportation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DATA ORANG TUA -->
                <div class="form-section">
                    <h5 class="form-section-title">
                        <i class="fas fa-user-friends"></i>Data Orang Tua
                        <small>Wajib Diisi</small>
                    </h5>

                    <!-- Ayah -->
                    <h6 class="mt-4 mb-3 fw-semibold" style="color: var(--forest); border-left: 3px solid var(--gold); padding-left: 0.75rem;">Data Ayah</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIK Ayah <span class="required">*</span></label>
                            <input type="text" name="father_nik" class="form-control @error('father_nik') is-invalid @enderror"
                                   value="{{ old('father_nik') }}" maxlength="16" required>
                            @error('father_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Ayah <span class="required">*</span></label>
                            <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror"
                                   value="{{ old('father_name') }}" required>
                            @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir Ayah <span class="required">*</span></label>
                            <input type="text" name="father_birth_place" class="form-control @error('father_birth_place') is-invalid @enderror"
                                   value="{{ old('father_birth_place') }}" required>
                            @error('father_birth_place')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir Ayah <span class="required">*</span></label>
                            <input type="text" name="father_birth_date" class="form-control datepicker @error('father_birth_date') is-invalid @enderror"
                                value="{{ old('father_birth_date') }}" placeholder="dd/mm/yyyy" required>
                            @error('father_birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Ayah <span class="required">*</span></label>
                            <select name="father_education" class="form-select @error('father_education') is-invalid @enderror" required>
                                <option value="">Pilih Pendidikan</option>
                                @foreach(['Tidak Sekolah','Putus Sekolah','SD/MI/Sederajat','SMP/MTs/Sederajat','SMA/SMK/MA/Sederajat','D1','D2','D3','D4/S1','S2','S3'] as $edu)
                                    <option value="{{ $edu }}" {{ old('father_education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                @endforeach
                            </select>
                            @error('father_education')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ayah <span class="required">*</span></label>
                            <select name="father_occupation" class="form-select @error('father_occupation') is-invalid @enderror" required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach(['Tidak Bekerja','Nelayan','Petani','Peternak','PNS/TNI/Polri','Karyawan Swasta','Pedagang','Wiraswasta','Buruh','Pensiunan','Lainnya'] as $job)
                                    <option value="{{ $job }}" {{ old('father_occupation') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                @endforeach
                            </select>
                            @error('father_occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penghasilan Ayah <span class="required">*</span></label>
                            <select name="father_income" class="form-select @error('father_income') is-invalid @enderror" required>
                                <option value="">Pilih Penghasilan</option>
                                @foreach(['< Rp 500.000','Rp 500.000 - Rp 1.000.000','Rp 1.000.000 - Rp 2.000.000','Rp 2.000.000 - Rp 3.000.000','Rp 3.000.000 - Rp 5.000.000','> Rp 5.000.000'] as $inc)
                                    <option value="{{ $inc }}" {{ old('father_income') == $inc ? 'selected' : '' }}>{{ $inc }}</option>
                                @endforeach
                            </select>
                            @error('father_income')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP Ayah <span class="required">*</span></label>
                            <input type="tel" name="father_phone" class="form-control @error('father_phone') is-invalid @enderror"
                                   value="{{ old('father_phone') }}" required>
                            @error('father_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Berkebutuhan Khusus Ayah <span class="required">*</span></label>
                            <select name="father_disability" class="form-select @error('father_disability') is-invalid @enderror" required>
                                <option value="Tidak Ada" {{ old('father_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                @foreach(['Tuna Netra','Tuna Rungu','Tuna Wicara','Tuna Daksa','Tuna Laras','Autis','ADHD','Slow Learner'] as $d)
                                    <option value="{{ $d }}" {{ old('father_disability') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('father_disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Ibu -->
                    <h6 class="mt-4 mb-3 fw-semibold" style="color: var(--forest); border-left: 3px solid var(--gold); padding-left: 0.75rem;">Data Ibu</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIK Ibu <span class="required">*</span></label>
                            <input type="text" name="mother_nik" class="form-control @error('mother_nik') is-invalid @enderror"
                                   value="{{ old('mother_nik') }}" maxlength="16" required>
                            @error('mother_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Ibu <span class="required">*</span></label>
                            <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror"
                                   value="{{ old('mother_name') }}" required>
                            @error('mother_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir Ibu <span class="required">*</span></label>
                            <input type="text" name="mother_birth_place" class="form-control @error('mother_birth_place') is-invalid @enderror"
                                   value="{{ old('mother_birth_place') }}" required>
                            @error('mother_birth_place')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir Ibu <span class="required">*</span></label>
                            <input type="text" name="mother_birth_date" class="form-control datepicker @error('mother_birth_date') is-invalid @enderror"
                                value="{{ old('mother_birth_date') }}" placeholder="dd/mm/yyyy" required>
                            @error('mother_birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Ibu <span class="required">*</span></label>
                            <select name="mother_education" class="form-select @error('mother_education') is-invalid @enderror" required>
                                <option value="">Pilih Pendidikan</option>
                                @foreach(['Tidak Sekolah','Putus Sekolah','SD/MI/Sederajat','SMP/MTs/Sederajat','SMA/SMK/MA/Sederajat','D1','D2','D3','D4/S1','S2','S3'] as $edu)
                                    <option value="{{ $edu }}" {{ old('mother_education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                @endforeach
                            </select>
                            @error('mother_education')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Ibu <span class="required">*</span></label>
                            <select name="mother_occupation" class="form-select @error('mother_occupation') is-invalid @enderror" required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach(['Tidak Bekerja','Nelayan','Petani','Peternak','PNS/TNI/Polri','Karyawan Swasta','Pedagang','Wiraswasta','Buruh','Pensiunan','Lainnya'] as $job)
                                    <option value="{{ $job }}" {{ old('mother_occupation') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                @endforeach
                            </select>
                            @error('mother_occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penghasilan Ibu <span class="required">*</span></label>
                            <select name="mother_income" class="form-select @error('mother_income') is-invalid @enderror" required>
                                <option value="">Pilih Penghasilan</option>
                                @foreach(['< Rp 500.000','Rp 500.000 - Rp 1.000.000','Rp 1.000.000 - Rp 2.000.000','Rp 2.000.000 - Rp 3.000.000','Rp 3.000.000 - Rp 5.000.000','> Rp 5.000.000'] as $inc)
                                    <option value="{{ $inc }}" {{ old('mother_income') == $inc ? 'selected' : '' }}>{{ $inc }}</option>
                                @endforeach
                            </select>
                            @error('mother_income')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP Ibu <span class="required">*</span></label>
                            <input type="tel" name="mother_phone" class="form-control @error('mother_phone') is-invalid @enderror"
                                   value="{{ old('mother_phone') }}" required>
                            @error('mother_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Berkebutuhan Khusus Ibu <span class="required">*</span></label>
                            <select name="mother_disability" class="form-select @error('mother_disability') is-invalid @enderror" required>
                                <option value="Tidak Ada" {{ old('mother_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                @foreach(['Tuna Netra','Tuna Rungu','Tuna Wicara','Tuna Daksa','Tuna Laras','Autis','ADHD','Slow Learner'] as $d)
                                    <option value="{{ $d }}" {{ old('mother_disability') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                            @error('mother_disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Wali (Opsional) -->
                    <div class="form-check mt-4 mb-3">
                        <input class="form-check-input" type="checkbox" name="has_guardian" id="hasGuardian" {{ old('has_guardian') ? 'checked' : '' }}>
                        <label class="form-check-label" for="hasGuardian">
                            Memiliki Wali (centang jika ada)
                        </label>
                    </div>

                    <div id="guardianFields" class="toggle-fields {{ old('has_guardian') ? '' : 'd-none' }}">
                        <h6 class="mb-3 fw-semibold" style="color: var(--forest); border-left: 3px solid var(--gold); padding-left: 0.75rem;">Data Wali</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK Wali</label>
                                <input type="text" name="guardian_nik" class="form-control @error('guardian_nik') is-invalid @enderror"
                                       value="{{ old('guardian_nik') }}" maxlength="16">
                                @error('guardian_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Wali</label>
                                <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror"
                                       value="{{ old('guardian_name') }}">
                                @error('guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Wali</label>
                                <input type="text" name="guardian_birth_date" class="form-control datepicker @error('guardian_birth_date') is-invalid @enderror"
                                    value="{{ old('guardian_birth_date') }}" placeholder="dd/mm/yyyy">
                                @error('guardian_birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Wali</label>
                                <select name="guardian_education" class="form-select @error('guardian_education') is-invalid @enderror">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach(['Tidak Sekolah','Putus Sekolah','SD/MI/Sederajat','SMP/MTs/Sederajat','SMA/SMK/MA/Sederajat','D1','D2','D3','D4/S1','S2','S3'] as $edu)
                                        <option value="{{ $edu }}" {{ old('guardian_education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_education')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Wali</label>
                                <select name="guardian_occupation" class="form-select @error('guardian_occupation') is-invalid @enderror">
                                    <option value="">Pilih Pekerjaan</option>
                                    @foreach(['Tidak Bekerja','Nelayan','Petani','Peternak','PNS/TNI/Polri','Karyawan Swasta','Pedagang','Wiraswasta','Buruh','Pensiunan','Lainnya'] as $job)
                                        <option value="{{ $job }}" {{ old('guardian_occupation') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Wali</label>
                                <select name="guardian_income" class="form-select @error('guardian_income') is-invalid @enderror">
                                    <option value="">Pilih Penghasilan</option>
                                    @foreach(['< Rp 500.000','Rp 500.000 - Rp 1.000.000','Rp 1.000.000 - Rp 2.000.000','Rp 2.000.000 - Rp 3.000.000','Rp 3.000.000 - Rp 5.000.000','> Rp 5.000.000'] as $inc)
                                        <option value="{{ $inc }}" {{ old('guardian_income') == $inc ? 'selected' : '' }}>{{ $inc }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_income')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. HP Wali</label>
                                <input type="tel" name="guardian_phone" class="form-control @error('guardian_phone') is-invalid @enderror"
                                       value="{{ old('guardian_phone') }}">
                                @error('guardian_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Wali</label>
                                <select name="guardian_disability" class="form-select @error('guardian_disability') is-invalid @enderror">
                                    <option value="Tidak Ada" {{ old('guardian_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    @foreach(['Tuna Netra','Tuna Rungu','Tuna Wicara','Tuna Daksa','Tuna Laras','Autis','ADHD','Slow Learner'] as $d)
                                        <option value="{{ $d }}" {{ old('guardian_disability') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endforeach
                                </select>
                                @error('guardian_disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UPLOAD BERKAS -->
                <div class="form-section">
                    <h5 class="form-section-title">
                        <i class="fas fa-file-upload"></i>Upload Berkas
                        <small>Maks. 2MB per file</small>
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kartu Keluarga (KK) <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="kk_file" class="form-control @error('kk_file') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('kk_file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Akta Kelahiran <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="birth_certificate" class="form-control @error('birth_certificate') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('birth_certificate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">KTP Ibu <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="mother_ktp" class="form-control @error('mother_ktp') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('mother_ktp')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">KTP Ayah <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="father_ktp" class="form-control @error('father_ktp') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('father_ktp')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">KTP Wali (Opsional)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="guardian_ktp" class="form-control @error('guardian_ktp') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('guardian_ktp')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ijazah/SKL (Opsional)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="diploma" class="form-control @error('diploma') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('diploma')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rapor Siswa <span class="required">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="report_card" class="form-control @error('report_card') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small>Format: PDF, JPG, PNG</small>
                            </div>
                            @error('report_card')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>DAFTAR SEKARANG
                    </button>
                    <small class="form-text text-center d-block mt-2">
                        <i class="fas fa-lock me-1"></i>Data Anda aman dan hanya digunakan untuk keperluan pendaftaran
                    </small>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Init datepicker dengan format dd/mm/yyyy
    flatpickr(".datepicker", {
        dateFormat: "d/m/Y",
        locale: "id",
        allowInput: true,
        altInput: true,
        altFormat: "d/m/Y"
    });

    // Toggle alamat domisili
    const sameAsKtp = document.getElementById('sameAsKtp');
    const currentFields = document.getElementById('currentAddressFields');

    sameAsKtp?.addEventListener('change', function() {
        currentFields?.classList.toggle('d-none', this.checked);

        if (this.checked) {
            // Copy values from KTP to current address
            document.querySelectorAll('[name^="current_"]').forEach(input => {
                const ktpField = input.name.replace('current_', 'parent_ktp_');
                const ktpInput = document.querySelector(`[name="${ktpField}"]`);
                if (ktpInput) input.value = ktpInput.value;
            });
        }
    });

    // Toggle data wali
    const hasGuardian = document.getElementById('hasGuardian');
    const guardianFields = document.getElementById('guardianFields');

    hasGuardian?.addEventListener('change', function() {
        guardianFields?.classList.toggle('d-none', !this.checked);
    });

    // Auto-format NIK & KK (16 digits only)
    document.querySelectorAll('input[name="nik"], input[name="kk_number"], input[name$="_nik"]').forEach(input => {
        input?.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    });

    // Auto-format phone numbers
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input?.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 13);
        });
    });

    // Smooth scroll to first error on validation fail
    const invalidField = document.querySelector('.is-invalid');
    if (invalidField) {
        invalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        invalidField.focus();
    }
});
</script>
@endpush
