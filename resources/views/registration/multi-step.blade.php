@extends('layouts.app')

@section('title', 'Pendaftaran Siswa Baru - SMKS YAPISDA')

@push('styles')
<style>
/* Multi-Step Form Styles */
.step-container {
    display: none;
    animation: fadeIn 0.5s ease;
}

.step-container.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.progress-container {
    margin: 30px 0;
}

.progress-bar-container {
    background: #e2e8f0;
    border-radius: 20px;
    height: 8px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    border-radius: 20px;
    transition: width 0.5s ease;
}

.step-indicator {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.step-dot {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.step-dot.active {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

.step-dot.completed {
    background: #10b981;
    color: white;
}

.step-label {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 5px;
    text-align: center;
    white-space: nowrap;
}

/* Form Navigation */
.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.btn-prev {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-prev:hover {
    background: #e2e8f0;
}

.btn-next, .btn-submit {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    border: none;
}

.btn-next:hover, .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
}

/* Save Draft */
.save-draft {
    margin-top: 15px;
    font-size: 0.85rem;
    color: #64748b;
}

.save-draft i {
    color: #f59e0b;
}

/* Validation */
.invalid-feedback {
    display: none;
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 5px;
}

.is-invalid + .invalid-feedback {
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .step-label {
        font-size: 0.65rem;
    }

    .step-dot {
        width: 25px;
        height: 25px;
        font-size: 0.7rem;
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3><i class="fas fa-user-graduate me-2"></i>PENDAFTARAN SISWA BARU</h3>
                    <p class="mb-0">SMKS YAPISDA - Tahun Ajaran 2026/2027</p>
                </div>

                <div class="card-body p-4">
                    <!-- Progress Bar -->
                    <div class="progress-container">
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" id="progressBar" style="width: 25%;"></div>
                        </div>
                        <div class="step-indicator">
                            <div class="text-center">
                                <div class="step-dot active" data-step="1">1</div>
                                <div class="step-label">Data Pribadi</div>
                            </div>
                            <div class="text-center">
                                <div class="step-dot" data-step="2">2</div>
                                <div class="step-label">Orang Tua</div>
                            </div>
                            <div class="text-center">
                                <div class="step-dot" data-step="3">3</div>
                                <div class="step-label">Upload Dokumen</div>
                            </div>
                            <div class="text-center">
                                <div class="step-dot" data-step="4">4</div>
                                <div class="step-label">Review</div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Steps -->
                    <form id="registrationForm" method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Data Pribadi -->
                        <div class="step-container active" id="step1">
                            <h5 class="mb-4"><i class="fas fa-user me-2"></i>Data Pribadi Siswa</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control"
                                           value="{{ old('nik') }}" maxlength="16" required>
                                    <div class="invalid-feedback">NIK harus 16 digit</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NISN</label>
                                    <input type="text" name="nisn" class="form-control"
                                           value="{{ old('nisn') }}" maxlength="10">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control"
                                           value="{{ old('full_name') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="birth_place" class="form-control"
                                           value="{{ old('birth_place') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="birth_date" class="form-control"
                                           value="{{ old('birth_date') }}" placeholder="dd/mm/yyyy" required>
                                    <small class="text-muted">Format: dd/mm/yyyy</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Agama <span class="text-danger">*</span></label>
                                    <select name="religion" class="form-select" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. HP/WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control"
                                           value="{{ old('phone') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" name="previous_school" class="form-control"
                                           value="{{ old('previous_school') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jurusan Pilihan <span class="text-danger">*</span></label>
                                    <select name="major_choice" class="form-select" required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach($quotaInfo as $quota)
                                            <option value="{{ $quota['major'] }}" {{ old('major_choice') == $quota['major'] ? 'selected' : '' }}
                                                    {{ $quota['status'] == 'full' ? 'disabled' : '' }}>
                                                {{ $quota['major'] }}
                                                @if($quota['status'] == 'full')
                                                    - PENUH
                                                @elseif($quota['status'] == 'low')
                                                    - Sisa {{ $quota['available_quota'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Orang Tua -->
                        <div class="step-container" id="step2">
                            <h5 class="mb-4"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h5>

                            <div class="row g-3">
                                <!-- Ayah -->
                                <div class="col-md-6">
                                    <div class="card p-3">
                                        <h6 class="fw-bold text-primary mb-3">Data Ayah <span class="text-danger">*</span></h6>
                                        <div class="mb-3">
                                            <label class="form-label">NIK Ayah</label>
                                            <input type="text" name="father_nik" class="form-control"
                                                   value="{{ old('father_nik') }}" maxlength="16">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="father_name" class="form-control"
                                                   value="{{ old('father_name') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pekerjaan</label>
                                            <select name="father_occupation" class="form-select">
                                                <option value="">Pilih Pekerjaan</option>
                                                <option value="PNS/TNI/Polri" {{ old('father_occupation') == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                                <option value="Karyawan Swasta" {{ old('father_occupation') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                                <option value="Wiraswasta" {{ old('father_occupation') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                                <option value="Buruh" {{ old('father_occupation') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                                <option value="Petani" {{ old('father_occupation') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                                <option value="Nelayan" {{ old('father_occupation') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                                <option value="Tidak Bekerja" {{ old('father_occupation') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">No. HP</label>
                                            <input type="tel" name="father_phone" class="form-control"
                                                   value="{{ old('father_phone') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Ibu -->
                                <div class="col-md-6">
                                    <div class="card p-3">
                                        <h6 class="fw-bold text-danger mb-3">Data Ibu <span class="text-danger">*</span></h6>
                                        <div class="mb-3">
                                            <label class="form-label">NIK Ibu</label>
                                            <input type="text" name="mother_nik" class="form-control"
                                                   value="{{ old('mother_nik') }}" maxlength="16">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="mother_name" class="form-control"
                                                   value="{{ old('mother_name') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pekerjaan</label>
                                            <select name="mother_occupation" class="form-select">
                                                <option value="">Pilih Pekerjaan</option>
                                                <option value="Ibu Rumah Tangga" {{ old('mother_occupation') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                                <option value="PNS/TNI/Polri" {{ old('mother_occupation') == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                                <option value="Karyawan Swasta" {{ old('mother_occupation') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                                <option value="Wiraswasta" {{ old('mother_occupation') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                                <option value="Buruh" {{ old('mother_occupation') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                                <option value="Tidak Bekerja" {{ old('mother_occupation') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">No. HP</label>
                                            <input type="tel" name="mother_phone" class="form-control"
                                                   value="{{ old('mother_phone') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Upload Dokumen -->
                        <div class="step-container" id="step3">
                            <h5 class="mb-4"><i class="fas fa-file-upload me-2"></i>Upload Dokumen</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Pas Foto (Bg. Merah) <span class="text-danger">*</span></label>
                                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                                    <small class="text-muted">Maksimal 2MB, format JPG/PNG</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                    <input type="file" name="kk_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Maksimal 2MB</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Akta Kelahiran <span class="text-danger">*</span></label>
                                    <input type="file" name="birth_certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Maksimal 2MB</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Rapor Siswa <span class="text-danger">*</span></label>
                                    <input type="file" name="report_card" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Maksimal 2MB</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">KTP Ayah <span class="text-danger">*</span></label>
                                    <input type="file" name="father_ktp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Maksimal 2MB</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">KTP Ibu <span class="text-danger">*</span></label>
                                    <input type="file" name="mother_ktp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Maksimal 2MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review -->
                        <div class="step-container" id="step4">
                            <h5 class="mb-4"><i class="fas fa-check-circle me-2"></i>Review Data</h5>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Periksa kembali data Anda sebelum submit!</strong><br>
                                Pastikan semua data sudah benar karena tidak dapat diubah setelah diverifikasi.
                            </div>

                            <div class="review-summary">
                                <div class="mb-3">
                                    <strong>Nama:</strong> <span id="review_name"></span>
                                </div>
                                <div class="mb-3">
                                    <strong>NIK:</strong> <span id="review_nik"></span>
                                </div>
                                <div class="mb-3">
                                    <strong>Jurusan:</strong> <span id="review_major"></span>
                                </div>
                                <div class="mb-3">
                                    <strong>Email:</strong> <span id="review_email"></span>
                                </div>
                                <div class="mb-3">
                                    <strong>No. HP:</strong> <span id="review_phone"></span>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Dengan mengklik "Submit Pendaftaran", saya menyatakan bahwa data yang saya isi adalah benar dan siap diverifikasi oleh panitia.
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="form-navigation">
                            <button type="button" class="btn btn-prev" id="prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                            </button>
                            <button type="button" class="btn btn-next" id="nextBtn">
                                Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                            <button type="submit" class="btn btn-submit" id="submitBtn" style="display: none;">
                                <i class="fas fa-paper-plane me-1"></i> Submit Pendaftaran
                            </button>
                        </div>

                        <div class="save-draft text-center">
                            <i class="fas fa-save me-1"></i>
                            <span id="saveStatus">Draft tersimpan otomatis</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Multi-Step Form Logic
let currentStep = 1;
const totalSteps = 4;

// Show current step
function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.step-container').forEach(container => {
        container.classList.remove('active');
    });

    // Show current step
    document.getElementById('step' + step).classList.add('active');

    // Update progress bar
    const progress = ((step - 1) / (totalSteps - 1)) * 100;
    document.getElementById('progressBar').style.width = progress + '%';

    // Update step indicators
    document.querySelectorAll('.step-dot').forEach((dot, index) => {
        dot.classList.remove('active', 'completed');
        if (index + 1 < step) {
            dot.classList.add('completed');
        } else if (index + 1 === step) {
            dot.classList.add('active');
        }
    });

    // Update buttons
    if (step === 1) {
        document.getElementById('prevBtn').style.display = 'none';
        document.getElementById('nextBtn').style.display = 'inline-block';
        document.getElementById('submitBtn').style.display = 'none';
    } else if (step === totalSteps) {
        document.getElementById('prevBtn').style.display = 'inline-block';
        document.getElementById('nextBtn').style.display = 'none';
        document.getElementById('submitBtn').style.display = 'inline-block';
    } else {
        document.getElementById('prevBtn').style.display = 'inline-block';
        document.getElementById('nextBtn').style.display = 'inline-block';
        document.getElementById('submitBtn').style.display = 'none';
    }

    // Update review data on step 4
    if (step === 4) {
        updateReviewData();
    }
}

// Next button
document.getElementById('nextBtn').addEventListener('click', function() {
    if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
        saveDraft();
    }
});

// Previous button
document.getElementById('prevBtn').addEventListener('click', function() {
    currentStep--;
    showStep(currentStep);
});

// Validate current step
function validateStep(step) {
    let isValid = true;

    if (step === 1) {
        // Validate Step 1
        const nik = document.querySelector('[name="nik"]').value;
        const fullName = document.querySelector('[name="full_name"]').value;
        const major = document.querySelector('[name="major_choice"]').value;

        if (nik.length !== 16) {
            alert('NIK harus 16 digit!');
            isValid = false;
        }

        if (!fullName) {
            alert('Nama lengkap harus diisi!');
            isValid = false;
        }

        if (!major) {
            alert('Jurusan harus dipilih!');
            isValid = false;
        }
    }

    return isValid;
}

// Update review data
function updateReviewData() {
    document.getElementById('review_name').textContent = document.querySelector('[name="full_name"]').value || '-';
    document.getElementById('review_nik').textContent = document.querySelector('[name="nik"]').value || '-';
    document.getElementById('review_major').textContent = document.querySelector('[name="major_choice"]').value || '-';
    document.getElementById('review_email').textContent = document.querySelector('[name="email"]').value || '-';
    document.getElementById('review_phone').textContent = document.querySelector('[name="phone"]').value || '-';
}

// Save draft to localStorage
function saveDraft() {
    const formData = {};
    const form = document.getElementById('registrationForm');
    const inputs = form.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        if (input.type !== 'file' && input.type !== 'submit') {
            formData[input.name] = input.value;
        }
    });

    localStorage.setItem('registrationDraft', JSON.stringify(formData));
    document.getElementById('saveStatus').textContent = 'Draft tersimpan: ' + new Date().toLocaleTimeString();
}

// Load draft from localStorage
function loadDraft() {
    const draft = localStorage.getItem('registrationDraft');
    if (draft) {
        const data = JSON.parse(draft);
        Object.keys(data).forEach(key => {
            const input = document.querySelector('[name="' + key + '"]');
            if (input && input.type !== 'file') {
                input.value = data[key];
            }
        });
    }
}

// Auto-save every 5 seconds
setInterval(saveDraft, 5000);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadDraft();
    showStep(currentStep);
});

// Handle form submit
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    if (!validateStep(currentStep)) {
        e.preventDefault();
        return;
    }

    // Clear draft after successful submit
    localStorage.removeItem('registrationDraft');
});
</script>
@endpush
@endsection
