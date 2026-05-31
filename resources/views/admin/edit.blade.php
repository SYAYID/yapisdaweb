@extends('layouts.admin')

@section('title', 'Edit Data - ' . $applicant->registration_number)

@push('styles')
<style>
/* === YAPISDA DESIGN TOKENS === */
:root {
    /* Core Colors */
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

    /* Text Colors */
    --text-dark:     #1A1208;
    --text-mid:      #4A3F28;
    --text-muted:    #8A7A58;
    --text-light:    #FFFFFF;

    /* Status Colors */
    --success:       #10b981;
    --success-bg:    #ecfdf5;
    --success-text:  #065f46;
    --warning:       #f59e0b;
    --warning-bg:    #fffbeb;
    --warning-text:  #92400e;
    --danger:        #ef4444;
    --danger-bg:     #fef2f2;
    --danger-text:   #991b1b;

    /* UI Tokens */
    --bg-page:       var(--ivory);
    --bg-card:       #ffffff;
    --border:        var(--ivory-dark);
    --border-hover:  #D8D0BE;

    --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 20px rgba(0,0,0,0.10);
    --shadow-lg: 0 12px 36px rgba(0,0,0,0.14);
    --shadow-gold: 0 8px 30px rgba(201,168,76,0.22);

    --radius:    14px;
    --radius-lg: 20px;
    --radius-xl: 28px;

    --transition:        all 0.2s ease-in-out;
    --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);

    /* Typography */
    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;
}

/* === BASE === */
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
    font-family: var(--ff-body);
    background: var(--bg-page);
    color: var(--text-dark);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
}

/* === LAYOUT === */
.edit-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem;
}

/* === HEADER CARD === */
.edit-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    border-radius: var(--radius-lg);
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-lg);
    color: white;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(201,168,76,0.15);
}

.edit-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.edit-header::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.reg-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(201,168,76,0.2);
    color: var(--gold-light);
    padding: 0.4rem 1rem;
    border-radius: 999px;
    font-family: 'SF Mono', monospace;
    font-weight: 600;
    font-size: 0.9rem;
    border: 1px solid rgba(201,168,76,0.3);
}

.student-name {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.5rem;
    margin: 0.5rem 0;
}

.edit-meta {
    font-size: 0.9rem;
    opacity: 0.9;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.edit-meta i {
    color: var(--gold-light);
    width: 16px;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-header {
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    font-family: var(--ff-body);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn-header.btn-outline {
    background: rgba(255,255,255,0.15);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
}

.btn-header.btn-outline:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

.btn-header.btn-white {
    background: white;
    color: var(--forest);
}

.btn-header.btn-white:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-gold);
}

/* === TABS NAVIGATION === */
.tabs-nav {
    display: flex;
    gap: 0.25rem;
    background: var(--bg-card);
    padding: 0.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    overflow-x: auto;
    flex-wrap: wrap;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
}

.tab-btn {
    padding: 0.7rem 1.25rem;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-weight: 500;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
}

.tab-btn:hover {
    background: var(--gold-pale);
    color: var(--gold-dark);
}

.tab-btn.active {
    background: var(--forest);
    color: white;
    font-weight: 600;
    box-shadow: var(--shadow-sm);
}

.tab-btn.active i {
    color: var(--gold-light);
}

.tab-content {
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* === FORM CARD === */
.form-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    margin-bottom: 1rem;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-smooth);
}

.form-card:hover {
    box-shadow: var(--shadow-lg);
}

.form-card-header {
    padding: 1rem 1.5rem;
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--ivory), white);
    color: var(--forest);
}

.form-card-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 1.5rem;
    width: 36px;
    height: 2px;
    background: var(--gold);
    border-radius: 999px;
}

.form-card-header i {
    color: var(--gold-dark);
}

.form-card-body {
    padding: 1.5rem;
}

/* === FORM GRID === */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.25rem 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-mid);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-label .required {
    color: var(--danger);
}

.form-control,
.form-select {
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--ff-body);
    transition: var(--transition);
    background: white;
    color: var(--text-dark);
}

.form-control:focus,
.form-select:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 4px rgba(160, 120, 48, 0.12);
    background: #fffef9;
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
    margin-top: 0.25rem;
    font-weight: 500;
}

.form-text {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

/* === FILE UPLOAD === */
.file-upload {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    padding: 1.25rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    background: var(--ivory);
}

.file-upload:hover {
    border-color: var(--gold);
    background: var(--gold-pale);
}

.file-upload input {
    display: none;
}

.file-upload-icon {
    font-size: 2rem;
    color: var(--gold-dark);
    margin-bottom: 0.5rem;
}

.file-upload-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.file-upload-hint {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.file-preview {
    margin-top: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--ivory);
    border-radius: 8px;
    border: 1px solid var(--border);
}

.file-preview-icon {
    font-size: 1.5rem;
    color: var(--gold-dark);
}

.file-preview-info {
    flex: 1;
}

.file-preview-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-dark);
}

.file-preview-size {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.file-preview-action {
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: var(--moss);
    color: white;
    font-weight: 500;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.file-preview-action:hover {
    background: var(--forest);
    transform: translateY(-1px);
}

/* === ADDRESS BOX === */
.address-box {
    background: var(--ivory);
    padding: 1rem;
    border-radius: var(--radius);
    border-left: 3px solid var(--moss);
    font-size: 0.9rem;
    line-height: 1.6;
}

.address-box.same-as-ktp {
    border-left-color: var(--gold);
    background: var(--gold-pale);
}

.address-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: var(--gold);
    color: var(--forest);
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* === PARENT CARD === */
.parent-card {
    background: var(--ivory);
    border-radius: var(--radius);
    padding: 1rem;
    margin-bottom: 1rem;
    border-left: 3px solid var(--moss);
}

.parent-card:last-child {
    margin-bottom: 0;
}

.parent-title {
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 1rem;
}

.parent-title i {
    color: var(--gold-dark);
}

.parent-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 0.75rem 1.5rem;
}

.parent-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.parent-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.parent-value {
    font-size: 0.95rem;
    color: var(--text-dark);
    font-weight: 500;
}

/* === ACTION PANEL === */
.action-panel {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: 1.5rem;
    position: sticky;
    top: 1rem;
    box-shadow: var(--shadow-md);
}

.action-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--forest);
}

.action-title i {
    color: var(--gold-dark);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.action-btn {
    padding: 0.875rem 1rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    font-family: var(--ff-body);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    text-align: center;
}

.action-btn.btn-save {
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    box-shadow: 0 4px 12px rgba(46, 107, 79, 0.25);
}

.action-btn.btn-save:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 107, 79, 0.35);
}

.action-btn.btn-cancel {
    background: white;
    color: var(--text-mid);
    border: 1.5px solid var(--border);
}

.action-btn.btn-cancel:hover {
    background: var(--gold-pale);
    border-color: var(--gold-dark);
    color: var(--gold-dark);
}

.action-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* === ALERTS === */
.alert-custom {
    border-radius: var(--radius);
    border: none;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    border-left: 4px solid;
}

.alert-custom i {
    font-size: 1.25rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.alert-custom .alert-title {
    font-family: var(--ff-display);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-custom ul {
    margin: 0.5rem 0 0 1.25rem;
    padding: 0;
}

.alert-custom li {
    font-size: 0.9rem;
    margin: 0.25rem 0;
}

.alert-warning-custom {
    background: var(--warning-bg);
    color: var(--warning-text);
    border-color: var(--warning);
}

.alert-danger-custom {
    background: var(--danger-bg);
    color: var(--danger-text);
    border-color: var(--danger);
}

/* === CHECKBOX === */
.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
}

.form-check-input {
    width: 1.1rem;
    height: 1.1rem;
    border-radius: 4px;
    border: 2px solid var(--border);
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
    font-size: 0.95rem;
    color: var(--text-dark);
    cursor: pointer;
    font-weight: 500;
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

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .edit-wrapper {
        padding: 1rem;
    }

    .action-panel {
        position: static;
    }

    .action-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .edit-header {
        padding: 1.25rem;
    }

    .student-name {
        font-size: 1.25rem;
    }

    .tabs-nav {
        padding: 0.375rem;
    }

    .tab-btn {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .action-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .header-actions {
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
    }

    .action-grid {
        grid-template-columns: 1fr;
    }

    .edit-header {
        text-align: center;
    }

    .edit-meta {
        justify-content: center;
    }
}

/* === PRINT STYLES === */
@media print {
    .tabs-nav,
    .action-panel,
    .file-upload,
    .btn-header {
        display: none !important;
    }

    .edit-header {
        background: white !important;
        color: black !important;
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }

    .form-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        break-inside: avoid;
    }

    body {
        background: white;
        font-size: 11pt;
    }
}
</style>
@endpush

@section('admin_content')
<div class="edit-wrapper">

    <!-- Header Card -->
    <div class="edit-header">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <span class="reg-badge">
                    <i class="fas fa-hashtag"></i>{{ $applicant->registration_number }}
                </span>
                <h2 class="student-name">{{ $applicant->full_name }}</h2>
                <div class="edit-meta">
                    <span><i class="fas fa-school"></i>{{ $applicant->previous_school }}</span>
                    <span><i class="fas fa-building"></i>{{ $applicant->major_choice }}</span>
                    <span><i class="fas fa-calendar"></i>{{ $applicant->registered_at_label }}</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.documents', $applicant->id) }}" class="btn-header btn-outline">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <a href="{{ route('admin.print', $applicant->id) }}" class="btn-header btn-white" target="_blank">
                    <i class="fas fa-print"></i>Preview
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('error'))
    <div class="alert-custom alert-danger-custom">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <div class="alert-title">Terjadi Kesalahan</div>
            <div>{{ session('error') }}</div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="alert-custom alert-danger-custom">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <div class="alert-title">Perbaiki Kesalahan Berikut:</div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="student">
            <i class="fas fa-user"></i>Data Siswa
        </button>
        <button class="tab-btn" data-tab="address">
            <i class="fas fa-map-marker-alt"></i>Alamat
        </button>
        <button class="tab-btn" data-tab="parents">
            <i class="fas fa-user-friends"></i>Orang Tua
        </button>
        <button class="tab-btn" data-tab="documents">
            <i class="fas fa-file-upload"></i>Dokumen
        </button>
        <button class="tab-btn" data-tab="actions">
            <i class="fas fa-cog"></i>Simpan
        </button>
    </div>

    <form action="{{ route('admin.update', $applicant->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')

        <!-- Tab: Data Siswa -->
        <div id="tab-student" class="tab-content active">
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-user-graduate"></i>Data Pribadi Siswa
                </div>
                <div class="form-card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Wilayah KK <span class="required">*</span></label>
                            <select name="kk_area" class="form-select" required>
                                <option value="">Pilih Wilayah</option>
                                <option value="Dalam Wilayah Banten" {{ old('kk_area', $applicant->kk_area) == 'Dalam Wilayah Banten' ? 'selected' : '' }}>Dalam Wilayah Banten</option>
                                <option value="Di Luar Wilayah Banten" {{ old('kk_area', $applicant->kk_area) == 'Di Luar Wilayah Banten' ? 'selected' : '' }}>Di Luar Wilayah Banten</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor KK <span class="required">*</span></label>
                            <input type="text" name="kk_number" class="form-control" value="{{ old('kk_number', $applicant->kk_number) }}" maxlength="16" required placeholder="16 digit">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIK <span class="required">*</span></label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', $applicant->nik) }}" maxlength="16" required placeholder="16 digit">
                        </div>
                        <div class="form-group">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $applicant->nisn) }}" placeholder="Opsional">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $applicant->full_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                            <select name="gender" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ old('gender', $applicant->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $applicant->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tempat Lahir <span class="required">*</span></label>
                            <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $applicant->birth_place) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
                            <input type="text" name="birth_date" class="form-control datepicker" value="{{ old('birth_date', $formattedDates['birth_date']) }}" placeholder="dd/mm/yyyy" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Agama <span class="required">*</span></label>
                            <select name="religion" class="form-select" required>
                                <option value="">Pilih</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $rel)
                                <option value="{{ $rel }}" {{ old('religion', $applicant->religion) == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. HP/WhatsApp <span class="required">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $applicant->phone) }}" required placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $applicant->email) }}" required placeholder="email@contoh.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Asal Sekolah <span class="required">*</span></label>
                            <input type="text" name="previous_school" class="form-control" value="{{ old('previous_school', $applicant->previous_school) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Sekolah <span class="required">*</span></label>
                            <select name="major_choice" class="form-select" required>
                                <option value="">Pilih Program</option>
                                <option value="Akuntansi dan Keuangan Lembaga" {{ old('major_choice', $applicant->major_choice) == 'Akuntansi dan Keuangan Lembaga' ? 'selected' : '' }}>Akuntansi dan Keuangan Lembaga</option>
                                <option value="Desain Komunikasi Visual" {{ old('major_choice', $applicant->major_choice) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                                <option value="Manajemen Perkantoran dan Layanan Bisnis" {{ old('major_choice', $applicant->major_choice) == 'Manajemen Perkantoran dan Layanan Bisnis' ? 'selected' : '' }}>Manajemen Perkantoran dan Layanan Bisnis</option>
                                <option value="Teknik Kendaraan Ringan" {{ old('major_choice', $applicant->major_choice) == 'Teknik Kendaraan Ringan' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                <option value="Teknik Komputer dan Jaringan" {{ old('major_choice', $applicant->major_choice) == 'Teknik Komputer dan Jaringan' ? 'selected' : '' }}>Teknik Komputer dan Jaringan</option>
                                <option value="Teknik Sepeda Motor" {{ old('major_choice', $applicant->major_choice) == 'Teknik Sepeda Motor' ? 'selected' : '' }}>Teknik Sepeda Motor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kewarganegaraan <span class="required">*</span></label>
                            <select name="citizenship" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="WNI" {{ old('citizenship', $applicant->citizenship) == 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('citizenship', $applicant->citizenship) == 'WNA' ? 'selected' : '' }}>WNA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Akta Kelahiran <span class="required">*</span></label>
                            <input type="text" name="birth_certificate_number" class="form-control" value="{{ old('birth_certificate_number', $applicant->birth_certificate_number) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tinggi Badan (cm) <span class="required">*</span></label>
                            <input type="number" name="height" class="form-control" value="{{ old('height', $applicant->height) }}" required min="50" max="250">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat Badan (kg) <span class="required">*</span></label>
                            <input type="number" name="weight" class="form-control" value="{{ old('weight', $applicant->weight) }}" required min="20" max="200">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lingkar Kepala (cm)</label>
                            <input type="number" name="head_circumference" class="form-control" value="{{ old('head_circumference', $applicant->head_circumference) }}" min="30" max="80">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Saudara <span class="required">*</span></label>
                            <input type="number" name="siblings_count" class="form-control" value="{{ old('siblings_count', $applicant->siblings_count) }}" required min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Anak Ke- <span class="required">*</span></label>
                            <input type="number" name="child_order" class="form-control" value="{{ old('child_order', $applicant->child_order) }}" required min="1">
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Berkebutuhan Khusus <span class="required">*</span></label>
                            <select name="disability" class="form-select" required>
                                @foreach(['Tidak Ada', 'Tuna Netra', 'Tuna Rungu', 'Tuna Wicara', 'Tuna Daksa', 'Tuna Laras', 'Autis', 'ADHD', 'Slow Learner'] as $dis)
                                <option value="{{ $dis }}" {{ old('disability', $applicant->disability) == $dis ? 'selected' : '' }}>{{ $dis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="mt-4">
                        <label class="form-label">Pas Foto Siswa</label>
                        <label class="file-upload">
                            <input type="file" name="photo" accept="image/*">
                            <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                            <div class="file-upload-label">Klik untuk upload foto baru</div>
                            <div class="file-upload-hint">Maksimal 2MB, format JPG/PNG. Biarkan kosong jika tidak ingin mengganti.</div>
                        </label>
                        @if($applicant->photo_path)
                        <div class="file-preview">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-image file-preview-icon"></i>
                                <div class="file-preview-info">
                                    <div class="file-preview-name">Foto saat ini</div>
                                    <div class="file-preview-size">Klik upload untuk mengganti</div>
                                </div>
                            </div>
                            <button type="button"
                                    class="file-preview-action"
                                    data-admin-preview-url="{{ route('admin.document.preview', ['photo', $applicant->id]) }}"
                                    data-admin-preview-title="Foto siswa"
                                    data-admin-preview-kind="image">
                                <i class="fas fa-eye"></i>Lihat
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Alamat -->
        <div id="tab-address" class="tab-content">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-id-card"></i>Alamat KTP Orang Tua
                        </div>
                        <div class="form-card-body">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label class="form-label">Kampung/Dusun <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_village" class="form-control" value="{{ old('parent_ktp_village', $applicant->parent_ktp_village) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">RT <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_rt" class="form-control" value="{{ old('parent_ktp_rt', $applicant->parent_ktp_rt) }}" required maxlength="3">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">RW <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_rw" class="form-control" value="{{ old('parent_ktp_rw', $applicant->parent_ktp_rw) }}" required maxlength="3">
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Desa/Kelurahan <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_subdistrict" class="form-control" value="{{ old('parent_ktp_subdistrict', $applicant->parent_ktp_subdistrict) }}" required>
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Kecamatan <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_district" class="form-control" value="{{ old('parent_ktp_district', $applicant->parent_ktp_district) }}" required>
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_city" class="form-control" value="{{ old('parent_ktp_city', $applicant->parent_ktp_city) }}" required>
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Provinsi <span class="required">*</span></label>
                                    <input type="text" name="parent_ktp_province" class="form-control" value="{{ old('parent_ktp_province', $applicant->parent_ktp_province) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status Tempat Tinggal <span class="required">*</span></label>
                                    <select name="parent_ktp_residence_status" class="form-select" required>
                                        <option value="">Pilih</option>
                                        @foreach(['Milik Sendiri', 'Sewa/Kontrak', 'Bersama Orang Tua', 'Lainnya'] as $status)
                                        <option value="{{ $status }}" {{ old('parent_ktp_residence_status', $applicant->parent_ktp_residence_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jarak ke Sekolah <span class="required">*</span></label>
                                    <select name="parent_ktp_distance_to_school" class="form-select" required>
                                        <option value="">Pilih</option>
                                        @foreach(['< 1 km', '1 - 3 km', '3 - 5 km', '> 5 km'] as $dist)
                                        <option value="{{ $dist }}" {{ old('parent_ktp_distance_to_school', $applicant->parent_ktp_distance_to_school) == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Transportasi <span class="required">*</span></label>
                                    <select name="parent_ktp_transportation" class="form-select" required>
                                        <option value="">Pilih</option>
                                        @foreach(['Jalan Kaki', 'Sepeda', 'Motor', 'Mobil', 'Angkutan Umum', 'Antar Jemput Sekolah'] as $trans)
                                        <option value="{{ $trans }}" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-home"></i>Alamat Domisili Siswa
                        </div>
                        <div class="form-card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="same_as_ktp" id="sameAsKtp" {{ old('same_as_ktp', $applicant->same_as_ktp) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sameAsKtp">
                                    Sama dengan alamat KTP orang tua
                                </label>
                            </div>

                            <div id="currentAddressFields" class="toggle-fields {{ old('same_as_ktp', $applicant->same_as_ktp) ? 'd-none' : '' }}">
                                <div class="form-grid">
                                    <div class="form-group full-width">
                                        <label class="form-label">Kampung/Dusun <span class="required">*</span></label>
                                        <input type="text" name="current_village" class="form-control" value="{{ old('current_village', $applicant->current_village) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">RT <span class="required">*</span></label>
                                        <input type="text" name="current_rt" class="form-control" value="{{ old('current_rt', $applicant->current_rt) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">RW <span class="required">*</span></label>
                                        <input type="text" name="current_rw" class="form-control" value="{{ old('current_rw', $applicant->current_rw) }}">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Desa/Kelurahan <span class="required">*</span></label>
                                        <input type="text" name="current_subdistrict" class="form-control" value="{{ old('current_subdistrict', $applicant->current_subdistrict) }}">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Kecamatan <span class="required">*</span></label>
                                        <input type="text" name="current_district" class="form-control" value="{{ old('current_district', $applicant->current_district) }}">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                                        <input type="text" name="current_city" class="form-control" value="{{ old('current_city', $applicant->current_city) }}">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Provinsi <span class="required">*</span></label>
                                        <input type="text" name="current_province" class="form-control" value="{{ old('current_province', $applicant->current_province) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status Tempat Tinggal</label>
                                        <select name="current_residence_status" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach(['Milik Sendiri', 'Sewa/Kontrak', 'Bersama Orang Tua', 'Lainnya'] as $status)
                                            <option value="{{ $status }}" {{ old('current_residence_status', $applicant->current_residence_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Jarak ke Sekolah</label>
                                        <select name="current_distance_to_school" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach(['< 1 km', '1 - 3 km', '3 - 5 km', '> 5 km'] as $dist)
                                            <option value="{{ $dist }}" {{ old('current_distance_to_school', $applicant->current_distance_to_school) == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Transportasi</label>
                                        <select name="current_transportation" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach(['Jalan Kaki', 'Sepeda', 'Motor', 'Mobil', 'Angkutan Umum', 'Antar Jemput Sekolah'] as $trans)
                                            <option value="{{ $trans }}" {{ old('current_transportation', $applicant->current_transportation) == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @if(old('same_as_ktp', $applicant->same_as_ktp))
                            <div class="address-box same-as-ktp mt-3">
                                <span class="address-badge"><i class="fas fa-check-circle"></i>Sama dengan KTP</span>
                                <div style="font-size: 0.9rem; opacity: 0.9;">
                                    {{ $applicant->parent_ktp_village }}, RT{{ $applicant->parent_ktp_rt }}/RW{{ $applicant->parent_ktp_rw }}<br>
                                    {{ $applicant->parent_ktp_subdistrict }}, {{ $applicant->parent_ktp_district }}<br>
                                    {{ $applicant->parent_ktp_city }}, {{ $applicant->parent_ktp_province }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Orang Tua -->
        <div id="tab-parents" class="tab-content">
            <div class="row g-3">
                <!-- Data Ayah -->
                <div class="col-lg-6">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-male"></i>Data Ayah
                        </div>
                        <div class="form-card-body">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label class="form-label">Nama Ayah <span class="required">*</span></label>
                                    <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $applicant->father_name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">NIK Ayah <span class="required">*</span></label>
                                    <input type="text" name="father_nik" class="form-control" value="{{ old('father_nik', $applicant->father_nik) }}" maxlength="16" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No. HP Ayah <span class="required">*</span></label>
                                    <input type="tel" name="father_phone" class="form-control" value="{{ old('father_phone', $applicant->father_phone) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="father_birth_place" class="form-control" value="{{ old('father_birth_place', $applicant->father_birth_place) }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <input type="text" name="father_birth_date" class="form-control datepicker" value="{{ old('father_birth_date', $formattedDates['father_birth_date']) }}" placeholder="dd/mm/yyyy">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pendidikan Ayah <span class="required">*</span></label>
                                    <select name="father_education" class="form-select" required>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach(['Tidak Sekolah', 'Putus Sekolah', 'SD/MI/Sederajat', 'SMP/MTs/Sederajat', 'SMA/SMK/MA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $edu)
                                            <option value="{{ $edu }}" {{ old('father_education', $applicant->father_education) == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pekerjaan Ayah <span class="required">*</span></label>
                                    <select name="father_occupation" class="form-select" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang', 'Wiraswasta', 'Buruh', 'Pensiunan', 'Lainnya'] as $job)
                                            <option value="{{ $job }}" {{ old('father_occupation', $applicant->father_occupation) == $job ? 'selected' : '' }}>{{ $job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Penghasilan Ayah <span class="required">*</span></label>
                                    <select name="father_income" class="form-select" required>
                                        <option value="">Pilih Penghasilan</option>
                                        @foreach(['< Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000'] as $income)
                                            <option value="{{ $income }}" {{ old('father_income', $applicant->father_income) == $income ? 'selected' : '' }}>{{ $income }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Berkebutuhan Khusus Ayah <span class="required">*</span></label>
                                    <select name="father_disability" class="form-select" required>
                                        @foreach(['Tidak Ada', 'Tuna Netra', 'Tuna Rungu', 'Tuna Wicara', 'Tuna Daksa', 'Tuna Laras', 'Autis', 'ADHD', 'Slow Learner'] as $dis)
                                            <option value="{{ $dis }}" {{ old('father_disability', $applicant->father_disability) == $dis ? 'selected' : '' }}>{{ $dis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="col-lg-6">
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-female"></i>Data Ibu
                        </div>
                        <div class="form-card-body">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label class="form-label">Nama Ibu <span class="required">*</span></label>
                                    <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $applicant->mother_name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">NIK Ibu <span class="required">*</span></label>
                                    <input type="text" name="mother_nik" class="form-control" value="{{ old('mother_nik', $applicant->mother_nik) }}" maxlength="16" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No. HP Ibu <span class="required">*</span></label>
                                    <input type="tel" name="mother_phone" class="form-control" value="{{ old('mother_phone', $applicant->mother_phone) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="mother_birth_place" class="form-control" value="{{ old('mother_birth_place', $applicant->mother_birth_place) }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <input type="text" name="mother_birth_date" class="form-control datepicker" value="{{ old('mother_birth_date', $formattedDates['mother_birth_date']) }}" placeholder="dd/mm/yyyy">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pendidikan Ibu <span class="required">*</span></label>
                                    <select name="mother_education" class="form-select" required>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach(['Tidak Sekolah', 'Putus Sekolah', 'SD/MI/Sederajat', 'SMP/MTs/Sederajat', 'SMA/SMK/MA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $edu)
                                            <option value="{{ $edu }}" {{ old('mother_education', $applicant->mother_education) == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pekerjaan Ibu <span class="required">*</span></label>
                                    <select name="mother_occupation" class="form-select" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang', 'Wiraswasta', 'Buruh', 'Pensiunan', 'Lainnya'] as $job)
                                            <option value="{{ $job }}" {{ old('mother_occupation', $applicant->mother_occupation) == $job ? 'selected' : '' }}>{{ $job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Penghasilan Ibu <span class="required">*</span></label>
                                    <select name="mother_income" class="form-select" required>
                                        <option value="">Pilih Penghasilan</option>
                                        @foreach(['< Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000'] as $income)
                                            <option value="{{ $income }}" {{ old('mother_income', $applicant->mother_income) == $income ? 'selected' : '' }}>{{ $income }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group full-width">
                                    <label class="form-label">Berkebutuhan Khusus Ibu <span class="required">*</span></label>
                                    <select name="mother_disability" class="form-select" required>
                                        @foreach(['Tidak Ada', 'Tuna Netra', 'Tuna Rungu', 'Tuna Wicara', 'Tuna Daksa', 'Tuna Laras', 'Autis', 'ADHD', 'Slow Learner'] as $dis)
                                            <option value="{{ $dis }}" {{ old('mother_disability', $applicant->mother_disability) == $dis ? 'selected' : '' }}>{{ $dis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Wali (Optional) -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="form-card" style="border-left: 3px solid var(--gold);">
                        <div class="form-card-header">
                            <i class="fas fa-user-shield" style="color: var(--gold-dark);"></i>Data Wali (Jika Ada)
                        </div>
                        <div class="form-card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="has_guardian" id="hasGuardian" {{ old('has_guardian', $applicant->has_guardian) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hasGuardian">
                                    Siswa memiliki wali
                                </label>
                            </div>
                            <div id="guardianFields" class="toggle-fields {{ old('has_guardian', $applicant->has_guardian) ? '' : 'd-none' }}">
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Nama Wali</label>
                                        <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name', $applicant->guardian_name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">NIK Wali</label>
                                        <input type="text" name="guardian_nik" class="form-control" value="{{ old('guardian_nik', $applicant->guardian_nik) }}" maxlength="16">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">No. HP Wali</label>
                                        <input type="tel" name="guardian_phone" class="form-control" value="{{ old('guardian_phone', $applicant->guardian_phone) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pendidikan Wali</label>
                                        <select name="guardian_education" class="form-select">
                                            <option value="">Pilih Pendidikan</option>
                                            @foreach(['Tidak Sekolah', 'Putus Sekolah', 'SD/MI/Sederajat', 'SMP/MTs/Sederajat', 'SMA/SMK/MA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $edu)
                                                <option value="{{ $edu }}" {{ old('guardian_education', $applicant->guardian_education) == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pekerjaan Wali</label>
                                        <select name="guardian_occupation" class="form-select">
                                            <option value="">Pilih Pekerjaan</option>
                                            @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang', 'Wiraswasta', 'Buruh', 'Pensiunan', 'Lainnya'] as $job)
                                                <option value="{{ $job }}" {{ old('guardian_occupation', $applicant->guardian_occupation) == $job ? 'selected' : '' }}>{{ $job }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Penghasilan Wali</label>
                                        <select name="guardian_income" class="form-select">
                                            <option value="">Pilih Penghasilan</option>
                                            @foreach(['< Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000'] as $income)
                                                <option value="{{ $income }}" {{ old('guardian_income', $applicant->guardian_income) == $income ? 'selected' : '' }}>{{ $income }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Berkebutuhan Khusus Wali</label>
                                        <select name="guardian_disability" class="form-select">
                                            @foreach(['Tidak Ada', 'Tuna Netra', 'Tuna Rungu', 'Tuna Wicara', 'Tuna Daksa', 'Tuna Laras', 'Autis', 'ADHD', 'Slow Learner'] as $dis)
                                                <option value="{{ $dis }}" {{ old('guardian_disability', $applicant->guardian_disability) == $dis ? 'selected' : '' }}>{{ $dis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Dokumen -->
        <div id="tab-documents" class="tab-content">
            <div class="alert-custom alert-warning-custom">
                <i class="fas fa-info-circle"></i>
                <div>
                    <div class="alert-title">Upload Dokumen (Opsional)</div>
                    <div>Biarkan kosong jika tidak ingin mengganti file. File baru akan menggantikan file lama.</div>
                </div>
            </div>
            <div class="form-grid">
                @foreach([
                    'photo' => ['label' => 'Foto Siswa', 'required' => true],
                    'kk' => ['label' => 'Kartu Keluarga (KK)', 'required' => true],
                    'birth_certificate' => ['label' => 'Akta Kelahiran', 'required' => true],
                    'mother_ktp' => ['label' => 'KTP Ibu', 'required' => true],
                    'father_ktp' => ['label' => 'KTP Ayah', 'required' => true],
                    'guardian_ktp' => ['label' => 'KTP Wali', 'required' => false],
                    'diploma' => ['label' => 'Ijazah/SKL', 'required' => false],
                    'report_card' => ['label' => 'Rapor Siswa', 'required' => true]
                ] as $field => $info)
                <div class="form-group">
                    <label class="form-label">
                        {{ $info['label'] }}
                        @if($info['required']) <span class="required">*</span> @endif
                    </label>

                    {{-- File Upload Area --}}
                    <label class="file-upload">
                        <input type="file" name="{{ $field }}" accept=".pdf,.jpg,.jpeg,.png">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-label">Upload baru</div>
                        <div class="file-upload-hint">Maks. 2MB • PDF/JPG/PNG</div>
                    </label>

                    {{-- Existing File Preview --}}
                    @if($applicant->{$field . '_path'})
                    <div class="file-preview mt-2">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @php
                                $fileExt = pathinfo($applicant->{$field . '_path'}, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $previewUrl = route('admin.document.preview', [str_replace('_file', '', $field), $applicant->id]);
                            @endphp

                            @if($isImage)
                                <i class="fas fa-image file-preview-icon"></i>
                            @else
                                <i class="fas fa-file-pdf" style="color: var(--danger);"></i>
                            @endif

                            <div class="file-preview-info">
                                <div class="file-preview-name">File sudah diupload</div>
                                <div class="file-preview-size">.{{ strtoupper($fileExt) }}</div>
                            </div>
                        </div>

                        {{-- Preview Button --}}
                        <button type="button"
                                class="file-preview-action"
                                data-admin-preview-url="{{ $previewUrl }}"
                                data-admin-preview-title="{{ $info['label'] }}"
                                data-admin-preview-kind="{{ $isImage ? 'image' : 'pdf' }}">
                            <i class="fas fa-eye"></i>Lihat
                        </button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tab: Actions -->
        <div id="tab-actions" class="tab-content">
            <div class="alert-custom alert-warning-custom">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <div class="alert-title">Perhatian Sebelum Menyimpan</div>
                    <ul class="mb-0">
                        <li>File yang diupload akan <strong>menggantikan</strong> file sebelumnya</li>
                        <li>Pastikan semua data sudah benar sebelum menyimpan</li>
                        <li>Perubahan ini akan langsung berlaku dan tidak bisa dikembalikan</li>
                    </ul>
                </div>
            </div>

            <div class="action-panel">
                <div class="action-title"><i class="fas fa-bolt"></i>Aksi</div>
                <div class="action-grid">
                    <a href="{{ route('admin.documents', $applicant->id) }}" class="action-btn btn-cancel">
                        <i class="fas fa-times"></i>Batal
                    </a>
                    <button type="submit" class="action-btn btn-save">
                        <i class="fas fa-save"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `tab-${targetTab}`) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Flatpickr untuk datepicker
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".datepicker", {
            dateFormat: "d/m/Y",
            locale: "id",
            allowInput: true,
            altInput: true,
            altFormat: "d/m/Y"
        });
    }

    // Toggle required + visibility untuk same_as_ktp
    const sameAsKtp = document.getElementById('sameAsKtp');
    const currentAddressFields = document.getElementById('currentAddressFields');

    if (sameAsKtp && currentAddressFields) {
        function toggleRequired() {
            const inputs = currentAddressFields.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (sameAsKtp.checked) {
                    input.removeAttribute('required');
                    input.disabled = true;
                } else {
                    if (input.name.includes('current_')) {
                        input.setAttribute('required', 'required');
                    }
                    input.disabled = false;
                }
            });
        }
        sameAsKtp.addEventListener('change', toggleRequired);
        toggleRequired();
    }

    // Toggle guardian fields
    const hasGuardian = document.getElementById('hasGuardian');
    const guardianFields = document.getElementById('guardianFields');

    if (hasGuardian && guardianFields) {
        hasGuardian.addEventListener('change', function() {
            guardianFields.classList.toggle('d-none', !this.checked);
        });
    }

    // Form submission with loading state
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            }
        });
    }

    // File upload preview
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files[0]) {
                const fileName = this.files[0].name;
                const label = this.closest('.file-upload')?.querySelector('.file-upload-label');
                if (label) {
                    label.textContent = fileName.length > 25 ? fileName.substring(0, 22) + '...' : fileName;
                }
            }
        });
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
});
</script>
@endpush
