@extends('layouts.admin')

@section('title', 'Edit Data Pendaftar - ' . $applicant->registration_number)

@push('styles')
<style>
.smp-edit-page {
    display: grid;
    gap: 1rem;
}

.smp-edit-page .card {
    overflow: hidden;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: #ffffff;
    box-shadow: var(--shadow-sm);
}

.smp-edit-page .card-header {
    padding: 1rem 1.1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.14);
    background:
        linear-gradient(135deg, rgba(201, 168, 76, 0.2), rgba(31, 154, 165, 0.14)),
        linear-gradient(135deg, var(--brand-800), var(--brand)) !important;
    color: #ffffff !important;
}

.smp-edit-page .card-header h4 {
    font-family: var(--ff-display);
    font-size: clamp(1.08rem, 1.8vw, 1.45rem);
    font-weight: 900;
}

.smp-edit-page .card-header .badge {
    min-height: 34px;
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16) !important;
    color: #ffffff;
}

.smp-edit-page .card-header .btn {
    min-height: 36px;
    border: 0;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.92);
    color: var(--brand-800);
    font-weight: 900;
}

.smp-edit-page .card-body {
    padding: clamp(1rem, 2vw, 1.4rem);
}

.smp-edit-page form > h5,
.smp-edit-page #guardianFields > h6 {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    margin: 1.6rem 0 0.85rem !important;
    padding: 0.8rem 0.95rem;
    border: 1px solid var(--line);
    border-radius: 13px;
    background: linear-gradient(180deg, #ffffff, #f8fbfa);
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: 1rem;
    font-weight: 900;
}

.smp-edit-page .form-label {
    color: var(--text);
    font-size: 0.83rem;
    font-weight: 900;
}

.smp-edit-page .form-control,
.smp-edit-page .form-select {
    min-height: 44px;
    border-color: var(--line);
    border-radius: 11px;
    background-color: #ffffff;
}

.smp-edit-page textarea.form-control {
    min-height: 96px;
}

.smp-edit-page .form-control:focus,
.smp-edit-page .form-select:focus {
    border-color: rgba(16, 92, 75, 0.42);
    box-shadow: 0 0 0 0.22rem rgba(16, 92, 75, 0.12);
}

.smp-edit-page .form-check {
    padding: 0.9rem 1rem 0.9rem 2.8rem;
    border: 1px solid var(--line);
    border-radius: 13px;
    background: #f8fbfa;
}

.smp-edit-page .form-check-input {
    margin-left: -1.8rem;
}

.smp-edit-page .admin-photo-preview,
.smp-edit-page .admin-current-file {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.6rem;
    padding: 0.75rem;
    border: 1px solid var(--line);
    border-radius: 13px;
    background: linear-gradient(180deg, #ffffff, #f8fbfa);
    color: var(--text);
    text-align: left;
    cursor: pointer;
    transition: transform 180ms ease, border-color 180ms ease, box-shadow 180ms ease;
}

.smp-edit-page .admin-photo-preview:hover,
.smp-edit-page .admin-current-file:hover {
    border-color: rgba(16, 92, 75, 0.28);
    box-shadow: var(--shadow-sm);
    transform: translateY(-1px);
}

.smp-edit-page .admin-photo-preview img {
    width: 86px;
    height: 108px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid var(--line);
    background: #ffffff;
}

.smp-edit-page .admin-current-icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: var(--mint);
    color: var(--brand);
    font-size: 1.05rem;
}

.smp-edit-page .admin-current-copy {
    min-width: 0;
    display: grid;
    gap: 0.15rem;
}

.smp-edit-page .admin-current-copy strong {
    color: var(--text);
    font-size: 0.9rem;
    font-weight: 900;
}

.smp-edit-page .admin-current-copy small {
    color: var(--muted);
    font-weight: 700;
}

.smp-edit-page .admin-upload-field {
    height: 100%;
    padding: 0.85rem;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: #ffffff;
}

.smp-edit-page .alert-warning {
    border: 1px solid rgba(180, 83, 9, 0.16);
    border-radius: 14px;
    background: #fff7ed;
    color: #92400e;
}

.smp-edit-page .btn {
    min-height: 42px;
    border-radius: 11px;
    font-weight: 900;
}

@media (max-width: 768px) {
    .smp-edit-page .card-header .d-flex,
    .smp-edit-page .card-header .d-flex > div:last-child {
        align-items: stretch !important;
        flex-direction: column;
        gap: 0.6rem;
    }

    .smp-edit-page .card-header .btn,
    .smp-edit-page .card-header .badge {
        justify-content: center;
        width: 100%;
    }
}
</style>
@endpush

@section('admin_content')
<div class="container-fluid admin-edit-page smp-edit-page">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Data Pendaftar
                        </h4>
                        <div>
                            <span class="badge bg-info">No. Pendaftaran: {{ $applicant->registration_number }}</span>
                            <a href="{{ route('admin.smp.documents', $applicant->id) }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Perbaiki Kesalahan Berikut:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.smp.update', $applicant->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- DATA PRIBADI SISWA -->
                        <h5 class="mb-3 mt-4"><i class="fas fa-user me-2"></i>Data Pribadi Siswa</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilihan Wilayah KK <span class="text-danger">*</span></label>
                                <select name="kk_area" class="form-select" required>
                                    <option value="">Pilih Wilayah</option>
                                    <option value="Dalam Wilayah Banten" {{ old('kk_area', $applicant->kk_area) == 'Dalam Wilayah Banten' ? 'selected' : '' }}>Dalam Wilayah Banten</option>
                                    <option value="Di Luar Wilayah Banten" {{ old('kk_area', $applicant->kk_area) == 'Di Luar Wilayah Banten' ? 'selected' : '' }}>Di Luar Wilayah Banten</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor KK (16 digit) <span class="text-danger">*</span></label>
                                <input type="text" name="kk_number" class="form-control"
                                       value="{{ old('kk_number', $applicant->kk_number) }}" maxlength="16" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control"
                                       value="{{ old('nik', $applicant->nik) }}" maxlength="16" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control"
                                       value="{{ old('nisn', $applicant->nisn) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control"
                                       value="{{ old('full_name', $applicant->full_name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender', $applicant->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $applicant->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_place" class="form-control"
                                       value="{{ old('birth_place', $applicant->birth_place) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_date" class="form-control datepicker"
                                       value="{{ old('birth_date', $formattedDates['birth_date']) }}" placeholder="dd/mm/yyyy" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="religion" class="form-select" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('religion', $applicant->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion', $applicant->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('religion', $applicant->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('religion', $applicant->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('religion', $applicant->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('religion', $applicant->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No HP/WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control"
                                       value="{{ old('phone', $applicant->phone) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $applicant->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="previous_school" class="form-control"
                                       value="{{ old('previous_school', $applicant->previous_school) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jurusan Pilihan <span class="text-danger">*</span></label>
                                <select name="school_program" class="form-select" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="Sekolah Umum" {{ old('school_program', $applicant->school_program) == 'Sekolah Umum' ? 'selected' : '' }}>Sekolah Umum</option>
                                    <option value="Sekolah dan Asrama" {{ old('school_program', $applicant->school_program) == 'Sekolah dan Asrama' ? 'selected' : '' }}>Sekolah dan Asrama</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                <select name="citizenship" class="form-select" required>
                                    <option value="">Pilih Kewarganegaraan</option>
                                    <option value="WNI" {{ old('citizenship', $applicant->citizenship) == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ old('citizenship', $applicant->citizenship) == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select> <!-- ✅ TAMBAHKAN INI -->
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor Akta Kelahiran <span class="text-danger">*</span></label>
                                <input type="text" name="birth_certificate_number" class="form-control"
                                       value="{{ old('birth_certificate_number', $applicant->birth_certificate_number) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                <input type="number" name="height" class="form-control"
                                       value="{{ old('height', $applicant->height) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                                <input type="number" name="weight" class="form-control"
                                       value="{{ old('weight', $applicant->weight) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" name="head_circumference" class="form-control"
                                       value="{{ old('head_circumference', $applicant->head_circumference) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                                <input type="number" name="siblings_count" class="form-control"
                                       value="{{ old('siblings_count', $applicant->siblings_count) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Anak Ke <span class="text-danger">*</span></label>
                                <input type="number" name="child_order" class="form-control"
                                       value="{{ old('child_order', $applicant->child_order) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus <span class="text-danger">*</span></label>
                                <select name="disability" class="form-select" required>
                                    <option value="Tidak Ada" {{ old('disability', $applicant->disability) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('disability', $applicant->disability) == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('disability', $applicant->disability) == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('disability', $applicant->disability) == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('disability', $applicant->disability) == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('disability', $applicant->disability) == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('disability', $applicant->disability) == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('disability', $applicant->disability) == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('disability', $applicant->disability) == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="mt-4">
                            <label class="form-label">Upload Pas Foto Siswa (Bg. Merah, Seragam Sekolah Asal)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Maksimal 2MB, format JPG/PNG. Biarkan kosong jika tidak ingin mengganti.</small>
                            @if($applicant->photo_path)
                                <button type="button"
                                        class="admin-photo-preview"
                                        data-admin-preview-url="{{ route('admin.smp.document.preview', ['photo', $applicant->id]) }}"
                                        data-admin-preview-title="Foto siswa"
                                        data-admin-preview-kind="image">
                                    <img src="{{ route('admin.smp.document.preview', ['photo', $applicant->id]) }}"
                                         alt="Foto saat ini"
                                         class="img-thumbnail">
                                    <span class="admin-current-copy">
                                        <strong>Foto saat ini</strong>
                                        <small>Klik untuk preview tanpa membuka halaman baru</small>
                                    </span>
                                </button>
                            @endif
                        </div>

                        <!-- ALAMAT KTP ORANG TUA -->
                        <h5 class="mb-3 mt-5"><i class="fas fa-home me-2"></i>Alamat KTP Orang Tua</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kampung/Dusun <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_village" class="form-control"
                                       value="{{ old('parent_ktp_village', $applicant->parent_ktp_village) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_rt" class="form-control"
                                       value="{{ old('parent_ktp_rt', $applicant->parent_ktp_rt) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_rw" class="form-control"
                                       value="{{ old('parent_ktp_rw', $applicant->parent_ktp_rw) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_subdistrict" class="form-control"
                                       value="{{ old('parent_ktp_subdistrict', $applicant->parent_ktp_subdistrict) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_district" class="form-control"
                                       value="{{ old('parent_ktp_district', $applicant->parent_ktp_district) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_city" class="form-control"
                                       value="{{ old('parent_ktp_city', $applicant->parent_ktp_city) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_province" class="form-control"
                                       value="{{ old('parent_ktp_province', $applicant->parent_ktp_province) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span class="text-danger">*</span></label>
                                <select name="parent_ktp_residence_status" class="form-select" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Milik Sendiri" {{ old('parent_ktp_residence_status', $applicant->parent_ktp_residence_status) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa/Kontrak" {{ old('parent_ktp_residence_status', $applicant->parent_ktp_residence_status) == 'Sewa/Kontrak' ? 'selected' : '' }}>Sewa/Kontrak</option>
                                    <option value="Bersama Orang Tua" {{ old('parent_ktp_residence_status', $applicant->parent_ktp_residence_status) == 'Bersama Orang Tua' ? 'selected' : '' }}>Bersama Orang Tua</option>
                                    <option value="Lainnya" {{ old('parent_ktp_residence_status', $applicant->parent_ktp_residence_status) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah <span class="text-danger">*</span></label>
                                <select name="parent_ktp_distance_to_school" class="form-select" required>
                                    <option value="">Pilih Jarak</option>
                                    <option value="< 1 km" {{ old('parent_ktp_distance_to_school', $applicant->parent_ktp_distance_to_school) == '< 1 km' ? 'selected' : '' }}>&lt; 1 km</option>
                                    <option value="1 - 3 km" {{ old('parent_ktp_distance_to_school', $applicant->parent_ktp_distance_to_school) == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                    <option value="3 - 5 km" {{ old('parent_ktp_distance_to_school', $applicant->parent_ktp_distance_to_school) == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                    <option value="> 5 km" {{ old('parent_ktp_distance_to_school', $applicant->parent_ktp_distance_to_school) == '> 5 km' ? 'selected' : '' }}>&gt; 5 km</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Moda Transportasi <span class="text-danger">*</span></label>
                                <select name="parent_ktp_transportation" class="form-select" required>
                                    <option value="">Pilih Transportasi</option>
                                    <option value="Jalan Kaki" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                    <option value="Sepeda" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                                    <option value="Motor" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="Mobil" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="Angkutan Umum" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                    <option value="Antar Jemput Sekolah" {{ old('parent_ktp_transportation', $applicant->parent_ktp_transportation) == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                </select>
                            </div>
                        </div>

                        <!-- ALAMAT DOMISILI SISWA -->
                        <h5 class="mb-3 mt-5"><i class="fas fa-map-marker-alt me-2"></i>Alamat Domisili Siswa</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="same_as_ktp" id="sameAsKtp" {{ old('same_as_ktp', $applicant->same_as_ktp) ? 'checked' : '' }}>
                            <label class="form-check-label" for="sameAsKtp">
                                Data sama dengan alamat KTP orang tua
                            </label>
                        </div>

                        <div id="currentAddressFields" class="row g-3 {{ old('same_as_ktp', $applicant->same_as_ktp) ? 'd-none' : '' }}">
                            <div class="col-md-6">
                                <label class="form-label">Kampung/Dusun <span class="text-danger">*</span></label>
                                <input type="text" name="current_village" class="form-control"
                                       value="{{ old('current_village', $applicant->current_village) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="current_rt" class="form-control"
                                       value="{{ old('current_rt', $applicant->current_rt) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="current_rw" class="form-control"
                                       value="{{ old('current_rw', $applicant->current_rw) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" name="current_subdistrict" class="form-control"
                                       value="{{ old('current_subdistrict', $applicant->current_subdistrict) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="current_district" class="form-control"
                                       value="{{ old('current_district', $applicant->current_district) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" name="current_city" class="form-control"
                                       value="{{ old('current_city', $applicant->current_city) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="current_province" class="form-control"
                                       value="{{ old('current_province', $applicant->current_province) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span class="text-danger">*</span></label>
                                <select name="current_residence_status" class="form-select">
                                    <option value="">Pilih Status</option>
                                    <option value="Milik Sendiri" {{ old('current_residence_status', $applicant->current_residence_status) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa/Kontrak" {{ old('current_residence_status', $applicant->current_residence_status) == 'Sewa/Kontrak' ? 'selected' : '' }}>Sewa/Kontrak</option>
                                    <option value="Bersama Orang Tua" {{ old('current_residence_status', $applicant->current_residence_status) == 'Bersama Orang Tua' ? 'selected' : '' }}>Bersama Orang Tua</option>
                                    <option value="Lainnya" {{ old('current_residence_status', $applicant->current_residence_status) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah <span class="text-danger">*</span></label>
                                <select name="current_distance_to_school" class="form-select">
                                    <option value="">Pilih Jarak</option>
                                    <option value="< 1 km" {{ old('current_distance_to_school', $applicant->current_distance_to_school) == '< 1 km' ? 'selected' : '' }}>&lt; 1 km</option>
                                    <option value="1 - 3 km" {{ old('current_distance_to_school', $applicant->current_distance_to_school) == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                    <option value="3 - 5 km" {{ old('current_distance_to_school', $applicant->current_distance_to_school) == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                    <option value="> 5 km" {{ old('current_distance_to_school', $applicant->current_distance_to_school) == '> 5 km' ? 'selected' : '' }}>&gt; 5 km</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Moda Transportasi <span class="text-danger">*</span></label>
                                <select name="current_transportation" class="form-select">
                                    <option value="">Pilih Transportasi</option>
                                    <option value="Jalan Kaki" {{ old('current_transportation', $applicant->current_transportation) == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                    <option value="Sepeda" {{ old('current_transportation', $applicant->current_transportation) == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                                    <option value="Motor" {{ old('current_transportation', $applicant->current_transportation) == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="Mobil" {{ old('current_transportation', $applicant->current_transportation) == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="Angkutan Umum" {{ old('current_transportation', $applicant->current_transportation) == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                    <option value="Antar Jemput Sekolah" {{ old('current_transportation', $applicant->current_transportation) == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                </select>
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <h5 class="mb-3 mt-5"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h5>

                        <!-- Data Ayah -->
                        <h6 class="mt-4">Data Ayah <span class="text-danger">*</span></h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_nik" class="form-control"
                                       value="{{ old('father_nik', $applicant->father_nik) }}" maxlength="16" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_name" class="form-control"
                                       value="{{ old('father_name', $applicant->father_name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_birth_place" class="form-control"
                                       value="{{ old('father_birth_place', $applicant->father_birth_place) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_birth_date" class="form-control datepicker"
                                       value="{{ old('father_birth_date', $formattedDates['father_birth_date']) }}" placeholder="dd/mm/yyyy" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Ayah <span class="text-danger">*</span></label>
                                <select name="father_education" class="form-select" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('father_education', $applicant->father_education) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('father_education', $applicant->father_education) == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('father_education', $applicant->father_education) == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('father_education', $applicant->father_education) == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('father_education', $applicant->father_education) == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('father_education', $applicant->father_education) == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('father_education', $applicant->father_education) == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('father_education', $applicant->father_education) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('father_education', $applicant->father_education) == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('father_education', $applicant->father_education) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('father_education', $applicant->father_education) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                <select name="father_occupation" class="form-select" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('father_occupation', $applicant->father_occupation) == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('father_occupation', $applicant->father_occupation) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('father_occupation', $applicant->father_occupation) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('father_occupation', $applicant->father_occupation) == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('father_occupation', $applicant->father_occupation) == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('father_occupation', $applicant->father_occupation) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('father_occupation', $applicant->father_occupation) == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('father_occupation', $applicant->father_occupation) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('father_occupation', $applicant->father_occupation) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('father_occupation', $applicant->father_occupation) == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('father_occupation', $applicant->father_occupation) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Ayah <span class="text-danger">*</span></label>
                                <select name="father_income" class="form-select" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('father_income', $applicant->father_income) == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('father_income', $applicant->father_income) == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('father_income', $applicant->father_income) == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('father_income', $applicant->father_income) == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('father_income', $applicant->father_income) == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('father_income', $applicant->father_income) == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Ayah <span class="text-danger">*</span></label>
                                <input type="tel" name="father_phone" class="form-control"
                                       value="{{ old('father_phone', $applicant->father_phone) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Ayah <span class="text-danger">*</span></label>
                                <select name="father_disability" class="form-select" required>
                                    <option value="Tidak Ada" {{ old('father_disability', $applicant->father_disability) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('father_disability', $applicant->father_disability) == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('father_disability', $applicant->father_disability) == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('father_disability', $applicant->father_disability) == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('father_disability', $applicant->father_disability) == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('father_disability', $applicant->father_disability) == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('father_disability', $applicant->father_disability) == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('father_disability', $applicant->father_disability) == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('father_disability', $applicant->father_disability) == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <h6 class="mt-4">Data Ibu <span class="text-danger">*</span></h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_nik" class="form-control"
                                       value="{{ old('mother_nik', $applicant->mother_nik) }}" maxlength="16" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_name" class="form-control"
                                       value="{{ old('mother_name', $applicant->mother_name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_birth_place" class="form-control"
                                       value="{{ old('mother_birth_place', $applicant->mother_birth_place) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_birth_date" class="form-control datepicker"
                                       value="{{ old('mother_birth_date', $formattedDates['mother_birth_date']) }}" placeholder="dd/mm/yyyy" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_education" class="form-select" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('mother_education', $applicant->mother_education) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('mother_education', $applicant->mother_education) == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('mother_education', $applicant->mother_education) == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('mother_education', $applicant->mother_education) == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('mother_education', $applicant->mother_education) == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('mother_education', $applicant->mother_education) == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('mother_education', $applicant->mother_education) == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('mother_education', $applicant->mother_education) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('mother_education', $applicant->mother_education) == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('mother_education', $applicant->mother_education) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('mother_education', $applicant->mother_education) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_occupation" class="form-select" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('mother_occupation', $applicant->mother_occupation) == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('mother_occupation', $applicant->mother_occupation) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('mother_occupation', $applicant->mother_occupation) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('mother_occupation', $applicant->mother_occupation) == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('mother_occupation', $applicant->mother_occupation) == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('mother_occupation', $applicant->mother_occupation) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('mother_occupation', $applicant->mother_occupation) == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('mother_occupation', $applicant->mother_occupation) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('mother_occupation', $applicant->mother_occupation) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('mother_occupation', $applicant->mother_occupation) == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('mother_occupation', $applicant->mother_occupation) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_income" class="form-select" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('mother_income', $applicant->mother_income) == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('mother_income', $applicant->mother_income) == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('mother_income', $applicant->mother_income) == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('mother_income', $applicant->mother_income) == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('mother_income', $applicant->mother_income) == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('mother_income', $applicant->mother_income) == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Ibu <span class="text-danger">*</span></label>
                                <input type="tel" name="mother_phone" class="form-control"
                                       value="{{ old('mother_phone', $applicant->mother_phone) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Ibu <span class="text-danger">*</span></label>
                                <select name="mother_disability" class="form-select" required>
                                    <option value="Tidak Ada" {{ old('mother_disability', $applicant->mother_disability) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('mother_disability', $applicant->mother_disability) == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('mother_disability', $applicant->mother_disability) == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('mother_disability', $applicant->mother_disability) == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('mother_disability', $applicant->mother_disability) == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('mother_disability', $applicant->mother_disability) == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('mother_disability', $applicant->mother_disability) == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('mother_disability', $applicant->mother_disability) == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('mother_disability', $applicant->mother_disability) == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                            </div>
                        </div>

                        <!-- Data Wali -->
                        <div class="form-check mt-4 mb-3">
                            <input class="form-check-input" type="checkbox" name="has_guardian" id="hasGuardian" {{ old('has_guardian', $applicant->has_guardian) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hasGuardian">
                                Memiliki Wali (Centang jika memiliki wali)
                            </label>
                        </div>

                        <div id="guardianFields" class="row g-3 {{ old('has_guardian', $applicant->has_guardian) ? '' : 'd-none' }}">
                            <h6 class="mt-4">Data Wali</h6>

                            <div class="col-md-6">
                                <label class="form-label">NIK Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_nik" class="form-control"
                                       value="{{ old('guardian_nik', $applicant->guardian_nik) }}" maxlength="16">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_name" class="form-control"
                                       value="{{ old('guardian_name', $applicant->guardian_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_birth_place" class="form-control"
                                       value="{{ old('guardian_birth_place', $applicant->guardian_birth_place) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_birth_date" class="form-control datepicker"
                                       value="{{ old('guardian_birth_date', $formattedDates['guardian_birth_date']) }}" placeholder="dd/mm/yyyy">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_education" class="form-select">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('guardian_education', $applicant->guardian_education) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('guardian_education', $applicant->guardian_education) == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('guardian_education', $applicant->guardian_education) == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('guardian_education', $applicant->guardian_education) == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('guardian_education', $applicant->guardian_education) == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('guardian_education', $applicant->guardian_education) == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('guardian_education', $applicant->guardian_education) == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('guardian_education', $applicant->guardian_education) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('guardian_education', $applicant->guardian_education) == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('guardian_education', $applicant->guardian_education) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('guardian_education', $applicant->guardian_education) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_occupation" class="form-select">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('guardian_occupation', $applicant->guardian_occupation) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_income" class="form-select">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('guardian_income', $applicant->guardian_income) == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('guardian_income', $applicant->guardian_income) == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('guardian_income', $applicant->guardian_income) == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('guardian_income', $applicant->guardian_income) == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('guardian_income', $applicant->guardian_income) == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('guardian_income', $applicant->guardian_income) == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Wali <span class="text-danger">*</span></label>
                                <input type="tel" name="guardian_phone" class="form-control"
                                       value="{{ old('guardian_phone', $applicant->guardian_phone) }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Wali <span class="text-danger">*</span></label>
                                <select name="guardian_disability" class="form-select">
                                    <option value="Tidak Ada" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('guardian_disability', $applicant->guardian_disability) == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('guardian_disability', $applicant->guardian_disability) == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('guardian_disability', $applicant->guardian_disability) == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('guardian_disability', $applicant->guardian_disability) == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                            </div>
                        </div>

                        <!-- UPLOAD BERKAS -->
                        <h5 class="mb-3 mt-5"><i class="fas fa-file-upload me-2"></i>Upload Berkas (Opsional - Biarkan kosong jika tidak ingin mengganti)</h5>

                        @php
                            $uploadFields = [
                                'kk' => ['label' => 'Kartu Keluarga', 'input' => 'kk_file', 'path' => 'kk_path'],
                                'birth_certificate' => ['label' => 'Akta Kelahiran', 'input' => 'birth_certificate', 'path' => 'birth_certificate_path'],
                                'mother_ktp' => ['label' => 'KTP Ibu', 'input' => 'mother_ktp', 'path' => 'mother_ktp_path'],
                                'father_ktp' => ['label' => 'KTP Ayah', 'input' => 'father_ktp', 'path' => 'father_ktp_path'],
                                'guardian_ktp' => ['label' => 'KTP Wali (Opsional)', 'input' => 'guardian_ktp', 'path' => 'guardian_ktp_path'],
                                'diploma' => ['label' => 'Ijazah Terakhir/SKL (Opsional)', 'input' => 'diploma', 'path' => 'diploma_path'],
                                'report_card' => ['label' => 'Rapor Siswa', 'input' => 'report_card', 'path' => 'report_card_path'],
                            ];
                        @endphp

                        <div class="row g-3">
                            @foreach($uploadFields as $type => $file)
                                @php
                                    $currentPath = $applicant->{$file['path']};
                                    $fileExt = $currentPath ? pathinfo($currentPath, PATHINFO_EXTENSION) : null;
                                    $isImage = $fileExt && in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="col-md-6">
                                    <div class="admin-upload-field">
                                        <label class="form-label">{{ $file['label'] }}</label>
                                        <input type="file" name="{{ $file['input'] }}" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Maksimal 2MB, PDF/JPG/PNG. Kosongkan jika tidak diganti.</small>
                                        @if($currentPath)
                                            <button type="button"
                                                    class="admin-current-file"
                                                    data-admin-preview-url="{{ route('admin.smp.document.preview', [$type, $applicant->id]) }}"
                                                    data-admin-preview-title="{{ $file['label'] }}"
                                                    data-admin-preview-kind="{{ $isImage ? 'image' : 'pdf' }}">
                                                <span class="admin-current-icon">
                                                    <i class="fas {{ $isImage ? 'fa-file-image' : 'fa-file-pdf' }}"></i>
                                                </span>
                                                <span class="admin-current-copy">
                                                    <strong>File saat ini</strong>
                                                    <small>.{{ strtoupper($fileExt) }} - klik untuk preview</small>
                                                </span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong><br>
                                - File yang diupload akan menggantikan file sebelumnya<br>
                                - Pastikan data yang diisi sudah benar sebelum menyimpan<br>
                                - Perubahan ini akan langsung berlaku dan tidak bisa dikembalikan
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.smp.documents', $applicant->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Flatpickr untuk semua input tanggal
document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".datepicker", {
        dateFormat: "d/m/Y",
        locale: "id",
        allowInput: true,
        altInput: true,
        altFormat: "d/m/Y"
    });

    // Toggle current address fields
    document.getElementById('sameAsKtp').addEventListener('change', function() {
        document.getElementById('currentAddressFields').classList.toggle('d-none', this.checked);
    });

    // Toggle guardian fields
    document.getElementById('hasGuardian').addEventListener('change', function() {
        document.getElementById('guardianFields').classList.toggle('d-none', !this.checked);
    });
});
</script>
@endpush
@endsection
