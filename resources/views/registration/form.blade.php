@extends('layouts.app')

@section('title', 'Formulir Pendaftaran - SPMB 2026/2027')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Formulir Pendaftaran Siswa Baru 2026/2027
                </div>
                <div class="card-body">
                    <!-- Peringatan dan Tata Cara -->
                    <div class="alert alert-warning mb-4">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Perhatian!</h5>
                        <ol class="mb-0">
                            <li>Semua field bertanda <span class="text-danger">*</span> wajib diisi</li>
                            <li>Ukuran file maksimal 2MB untuk setiap dokumen</li>
                            <li>Format file yang diterima: PDF, JPG, JPEG, PNG</li>
                            <li>Pastikan data yang diisi sesuai dengan dokumen asli</li>
                            <li>Nomor NIK tidak dapat digunakan lebih dari satu kali</li>
                        </ol>
                    </div>
                    <!-- Kuota Information Alert -->
                    <div class="alert alert-info mb-4">
                        <h5><i class="fas fa-info-circle me-2"></i>Informasi Kuota Pendaftaran</h5>
                        <p class="mb-0">Pilih jurusan yang masih memiliki kuota tersedia. Kuota akan dikurangi setelah pendaftaran Anda diverifikasi oleh admin.</p>
                    </div>

                    <!-- Kuota Cards -->
                    <div class="row g-3 mb-4">
                        @foreach($quotaInfo as $quota)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-{{ $quota['status'] == 'full' ? 'danger' : ($quota['status'] == 'low' ? 'warning' : 'success') }} h-100">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold">{{ $quota['major'] }}</h6>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small>Kuota Tersedia</small>
                                                <small class="fw-bold">
                                                    <span class="badge bg-{{ $quota['status'] == 'full' ? 'danger' : ($quota['status'] == 'low' ? 'warning' : 'success') }}">
                                                        {{ $quota['available_quota'] }}/{{ $quota['quota'] }}
                                                    </span>
                                                </small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-{{ $quota['status'] == 'full' ? 'danger' : ($quota['status'] == 'low' ? 'warning' : 'success') }}" 
                                                    role="progressbar" 
                                                    style="width: {{ $quota['percentage'] }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $quota['percentage'] }}% terisi</small>
                                        </div>
                                        
                                        @if($quota['status'] == 'full')
                                            <div class="alert alert-danger p-2 mb-0 small">
                                                <i class="fas fa-times-circle me-1"></i>Kuota sudah penuh
                                            </div>
                                        @elseif($quota['status'] == 'low')
                                            <div class="alert alert-warning p-2 mb-0 small">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Kuota tersisa sedikit
                                            </div>
                                        @else
                                            <div class="alert alert-success p-2 mb-0 small">
                                                <i class="fas fa-check-circle me-1"></i>Kuota masih tersedia
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="my-4">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h5><i class="fas fa-exclamation-circle me-2"></i>Perbaiki Kesalahan Berikut:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                        @csrf
                        
                        <!-- DATA PRIBADI SISWA -->
                        <h4 class="mb-3 mt-4"><i class="fas fa-user me-2"></i>Data Pribadi Siswa</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilihan Wilayah KK <span class="text-danger">*</span></label>
                                <select name="kk_area" class="form-select @error('kk_area') is-invalid @enderror" required>
                                    <option value="">Pilih Wilayah</option>
                                    <option value="Dalam Wilayah Banten" {{ old('kk_area') == 'Dalam Wilayah Banten' ? 'selected' : '' }}>Dalam Wilayah Banten</option>
                                    <option value="Di Luar Wilayah Banten" {{ old('kk_area') == 'Di Luar Wilayah Banten' ? 'selected' : '' }}>Di Luar Wilayah Banten</option>
                                </select>
                                @error('kk_area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor KK (16 digit) <span class="text-danger">*</span></label>
                                <input type="text" name="kk_number" class="form-control @error('kk_number') is-invalid @enderror" 
                                       value="{{ old('kk_number') }}" maxlength="16" required>
                                @error('kk_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" 
                                       value="{{ old('nik') }}" maxlength="16" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" 
                                       value="{{ old('nisn') }}">
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                                       value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" 
                                       value="{{ old('birth_place') }}" required>
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_date" class="form-control datepicker @error('birth_date') is-invalid @enderror" 
                                    value="{{ old('birth_date') }}" placeholder="dd/mm/yyyy" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="religion" class="form-select @error('religion') is-invalid @enderror" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No HP/WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="previous_school" class="form-control @error('previous_school') is-invalid @enderror" 
                                       value="{{ old('previous_school') }}" required>
                                @error('previous_school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan Pilihan <span class="text-danger">*</span></label>
                                <select name="major_choice" class="form-select @error('major_choice') is-invalid @enderror" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($quotaInfo as $quota)
                                        <option value="{{ $quota['major'] }}" 
                                                {{ old('major_choice') == $quota['major'] ? 'selected' : '' }}
                                                {{ $quota['status'] == 'full' ? 'disabled' : '' }}>
                                            {{ $quota['major'] }} 
                                            @if($quota['status'] == 'full')
                                                - (Kuota Penuh)
                                            @elseif($quota['status'] == 'low')
                                                - (Tersisa {{ $quota['available_quota'] }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('major_choice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                <select name="citizenship" class="form-select @error('citizenship') is-invalid @enderror" required>
                                    <option value="">Pilih Kewarganegaraan</option>
                                    <option value="WNI" {{ old('citizenship') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ old('citizenship') == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select>
                                @error('citizenship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor Akta Kelahiran <span class="text-danger">*</span></label>
                                <input type="text" name="birth_certificate_number" class="form-control @error('birth_certificate_number') is-invalid @enderror" 
                                       value="{{ old('birth_certificate_number') }}" required>
                                @error('birth_certificate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                <input type="number" name="height" class="form-control @error('height') is-invalid @enderror" 
                                       value="{{ old('height') }}" required>
                                @error('height')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                                <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                       value="{{ old('weight') }}" required>
                                @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" name="head_circumference" class="form-control @error('head_circumference') is-invalid @enderror" 
                                       value="{{ old('head_circumference') }}">
                                @error('head_circumference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                                <input type="number" name="siblings_count" class="form-control @error('siblings_count') is-invalid @enderror" 
                                       value="{{ old('siblings_count') }}" required>
                                @error('siblings_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Anak Ke <span class="text-danger">*</span></label>
                                <input type="number" name="child_order" class="form-control @error('child_order') is-invalid @enderror" 
                                       value="{{ old('child_order') }}" required>
                                @error('child_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus <span class="text-danger">*</span></label>
                                <select name="disability" class="form-select @error('disability') is-invalid @enderror" required>
                                    <option value="Tidak Ada" {{ old('disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('disability') == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('disability') == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('disability') == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('disability') == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('disability') == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('disability') == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('disability') == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('disability') == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                                @error('disability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="mt-4">
                            <label class="form-label">Upload Pas Foto Siswa (Bg. Merah, Seragam Sekolah Asal) <span class="text-danger">*</span></label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*" required>
                            <small class="text-muted">Maksimal 2MB, format JPG/PNG</small>
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ALAMAT KTP ORANG TUA -->
                        <h4 class="mb-3 mt-5"><i class="fas fa-home me-2"></i>Alamat KTP Orang Tua</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kampung/Dusun <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_village" class="form-control @error('parent_ktp_village') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_village') }}" required>
                                @error('parent_ktp_village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_rt" class="form-control @error('parent_ktp_rt') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_rt') }}" required>
                                @error('parent_ktp_rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_rw" class="form-control @error('parent_ktp_rw') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_rw') }}" required>
                                @error('parent_ktp_rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_subdistrict" class="form-control @error('parent_ktp_subdistrict') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_subdistrict') }}" required>
                                @error('parent_ktp_subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_district" class="form-control @error('parent_ktp_district') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_district') }}" required>
                                @error('parent_ktp_district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- 👇 KOLOM BARU: KABUPATEN/KOTA -->
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_city" class="form-control @error('parent_ktp_city') is-invalid @enderror" 
                                    value="{{ old('parent_ktp_city') }}" required>
                                @error('parent_ktp_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="parent_ktp_province" class="form-control @error('parent_ktp_province') is-invalid @enderror" 
                                       value="{{ old('parent_ktp_province') }}" required>
                                @error('parent_ktp_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span class="text-danger">*</span></label>
                                <select name="parent_ktp_residence_status" class="form-select @error('parent_ktp_residence_status') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Milik Sendiri" {{ old('parent_ktp_residence_status') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa/Kontrak" {{ old('parent_ktp_residence_status') == 'Sewa/Kontrak' ? 'selected' : '' }}>Sewa/Kontrak</option>
                                    <option value="Bersama Orang Tua" {{ old('parent_ktp_residence_status') == 'Bersama Orang Tua' ? 'selected' : '' }}>Bersama Orang Tua</option>
                                    <option value="Lainnya" {{ old('parent_ktp_residence_status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('parent_ktp_residence_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah <span class="text-danger">*</span></label>
                                <select name="parent_ktp_distance_to_school" class="form-select @error('parent_ktp_distance_to_school') is-invalid @enderror" required>
                                    <option value="">Pilih Jarak</option>
                                    <option value="< 1 km" {{ old('parent_ktp_distance_to_school') == '< 1 km' ? 'selected' : '' }}>&lt; 1 km</option>
                                    <option value="1 - 3 km" {{ old('parent_ktp_distance_to_school') == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                    <option value="3 - 5 km" {{ old('parent_ktp_distance_to_school') == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                    <option value="> 5 km" {{ old('parent_ktp_distance_to_school') == '> 5 km' ? 'selected' : '' }}>&gt; 5 km</option>
                                </select>
                                @error('parent_ktp_distance_to_school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Moda Transportasi <span class="text-danger">*</span></label>
                                <select name="parent_ktp_transportation" class="form-select @error('parent_ktp_transportation') is-invalid @enderror" required>
                                    <option value="">Pilih Transportasi</option>
                                    <option value="Jalan Kaki" {{ old('parent_ktp_transportation') == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                    <option value="Sepeda" {{ old('parent_ktp_transportation') == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                                    <option value="Motor" {{ old('parent_ktp_transportation') == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="Mobil" {{ old('parent_ktp_transportation') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="Angkutan Umum" {{ old('parent_ktp_transportation') == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                    <option value="Antar Jemput Sekolah" {{ old('parent_ktp_transportation') == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                </select>
                                @error('parent_ktp_transportation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ALAMAT DOMISILI SISWA -->
                        <h4 class="mb-3 mt-5"><i class="fas fa-map-marker-alt me-2"></i>Alamat Domisili Siswa</h4>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="same_as_ktp" id="sameAsKtp" {{ old('same_as_ktp') ? 'checked' : '' }}>
                            <label class="form-check-label" for="sameAsKtp">
                                Data sama dengan alamat KTP orang tua
                            </label>
                        </div>

                        <div id="currentAddressFields" class="row g-3 {{ old('same_as_ktp') ? 'd-none' : '' }}">
                            <div class="col-md-6">
                                <label class="form-label">Kampung/Dusun <span class="text-danger">*</span></label>
                                <input type="text" name="current_village" class="form-control @error('current_village') is-invalid @enderror" 
                                       value="{{ old('current_village') }}">
                                @error('current_village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="current_rt" class="form-control @error('current_rt') is-invalid @enderror" 
                                       value="{{ old('current_rt') }}">
                                @error('current_rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="current_rw" class="form-control @error('current_rw') is-invalid @enderror" 
                                       value="{{ old('current_rw') }}">
                                @error('current_rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" name="current_subdistrict" class="form-control @error('current_subdistrict') is-invalid @enderror" 
                                       value="{{ old('current_subdistrict') }}">
                                @error('current_subdistrict')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="current_district" class="form-control @error('current_district') is-invalid @enderror" 
                                       value="{{ old('current_district') }}">
                                @error('current_district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" name="current_city" class="form-control @error('current_city') is-invalid @enderror" 
                                    value="{{ old('current_city') }}">
                                @error('current_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="current_province" class="form-control @error('current_province') is-invalid @enderror" 
                                       value="{{ old('current_province') }}">
                                @error('current_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Tempat Tinggal <span class="text-danger">*</span></label>
                                <select name="current_residence_status" class="form-select @error('current_residence_status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="Milik Sendiri" {{ old('current_residence_status') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa/Kontrak" {{ old('current_residence_status') == 'Sewa/Kontrak' ? 'selected' : '' }}>Sewa/Kontrak</option>
                                    <option value="Bersama Orang Tua" {{ old('current_residence_status') == 'Bersama Orang Tua' ? 'selected' : '' }}>Bersama Orang Tua</option>
                                    <option value="Lainnya" {{ old('current_residence_status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('current_residence_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah <span class="text-danger">*</span></label>
                                <select name="current_distance_to_school" class="form-select @error('current_distance_to_school') is-invalid @enderror">
                                    <option value="">Pilih Jarak</option>
                                    <option value="< 1 km" {{ old('current_distance_to_school') == '< 1 km' ? 'selected' : '' }}>&lt; 1 km</option>
                                    <option value="1 - 3 km" {{ old('current_distance_to_school') == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                    <option value="3 - 5 km" {{ old('current_distance_to_school') == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                    <option value="> 5 km" {{ old('current_distance_to_school') == '> 5 km' ? 'selected' : '' }}>&gt; 5 km</option>
                                </select>
                                @error('current_distance_to_school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Moda Transportasi <span class="text-danger">*</span></label>
                                <select name="current_transportation" class="form-select @error('current_transportation') is-invalid @enderror">
                                    <option value="">Pilih Transportasi</option>
                                    <option value="Jalan Kaki" {{ old('current_transportation') == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                    <option value="Sepeda" {{ old('current_transportation') == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                                    <option value="Motor" {{ old('current_transportation') == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="Mobil" {{ old('current_transportation') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="Angkutan Umum" {{ old('current_transportation') == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                    <option value="Antar Jemput Sekolah" {{ old('current_transportation') == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                </select>
                                @error('current_transportation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <h4 class="mb-3 mt-5"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h4>
                        
                        <!-- Data Ayah -->
                        <h5 class="mt-4">Data Ayah <span class="text-danger">*</span></h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_nik" class="form-control @error('father_nik') is-invalid @enderror" 
                                       value="{{ old('father_nik') }}" maxlength="16" required>
                                @error('father_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" 
                                       value="{{ old('father_name') }}" required>
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_birth_place" class="form-control @error('father_birth_place') is-invalid @enderror" 
                                       value="{{ old('father_birth_place') }}" required>
                                @error('father_birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                              <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="father_birth_date" class="form-control datepicker @error('father_birth_date') is-invalid @enderror" 
                                    value="{{ old('father_birth_date') }}" placeholder="dd/mm/yyyy" required>
                                @error('father_birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Ayah <span class="text-danger">*</span></label>
                                <select name="father_education" class="form-select @error('father_education') is-invalid @enderror" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('father_education') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('father_education') == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('father_education') == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('father_education') == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('father_education') == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('father_education') == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('father_education') == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('father_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('father_education') == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('father_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('father_education') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('father_education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                <select name="father_occupation" class="form-select @error('father_occupation') is-invalid @enderror" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('father_occupation') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('father_occupation') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('father_occupation') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('father_occupation') == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('father_occupation') == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('father_occupation') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('father_occupation') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('father_occupation') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('father_occupation') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('father_occupation') == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('father_occupation') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('father_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Ayah <span class="text-danger">*</span></label>
                                <select name="father_income" class="form-select @error('father_income') is-invalid @enderror" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('father_income') == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('father_income') == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('father_income') == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('father_income') == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('father_income') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('father_income') == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                                @error('father_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Ayah <span class="text-danger">*</span></label>
                                <input type="tel" name="father_phone" class="form-control @error('father_phone') is-invalid @enderror" 
                                       value="{{ old('father_phone') }}" required>
                                @error('father_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Ayah <span class="text-danger">*</span></label>
                                <select name="father_disability" class="form-select @error('father_disability') is-invalid @enderror" required>
                                    <option value="Tidak Ada" {{ old('father_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('father_disability') == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('father_disability') == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('father_disability') == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('father_disability') == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('father_disability') == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('father_disability') == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('father_disability') == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('father_disability') == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                                @error('father_disability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <h5 class="mt-4">Data Ibu <span class="text-danger">*</span></h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_nik" class="form-control @error('mother_nik') is-invalid @enderror" 
                                       value="{{ old('mother_nik') }}" maxlength="16" required>
                                @error('mother_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror" 
                                       value="{{ old('mother_name') }}" required>
                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_birth_place" class="form-control @error('mother_birth_place') is-invalid @enderror" 
                                       value="{{ old('mother_birth_place') }}" required>
                                @error('mother_birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="mother_birth_date" class="form-control datepicker @error('mother_birth_date') is-invalid @enderror" 
                                    value="{{ old('mother_birth_date') }}" placeholder="dd/mm/yyyy" required>
                                @error('mother_birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_education" class="form-select @error('mother_education') is-invalid @enderror" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('mother_education') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('mother_education') == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('mother_education') == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('mother_education') == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('mother_education') == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('mother_education') == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('mother_education') == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('mother_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('mother_education') == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('mother_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('mother_education') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('mother_education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_occupation" class="form-select @error('mother_occupation') is-invalid @enderror" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('mother_occupation') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('mother_occupation') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('mother_occupation') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('mother_occupation') == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('mother_occupation') == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('mother_occupation') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('mother_occupation') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('mother_occupation') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('mother_occupation') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('mother_occupation') == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('mother_occupation') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('mother_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Ibu <span class="text-danger">*</span></label>
                                <select name="mother_income" class="form-select @error('mother_income') is-invalid @enderror" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('mother_income') == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('mother_income') == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('mother_income') == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('mother_income') == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('mother_income') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('mother_income') == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                                @error('mother_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Ibu <span class="text-danger">*</span></label>
                                <input type="tel" name="mother_phone" class="form-control @error('mother_phone') is-invalid @enderror" 
                                       value="{{ old('mother_phone') }}" required>
                                @error('mother_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Ibu <span class="text-danger">*</span></label>
                                <select name="mother_disability" class="form-select @error('mother_disability') is-invalid @enderror" required>
                                    <option value="Tidak Ada" {{ old('mother_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('mother_disability') == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('mother_disability') == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('mother_disability') == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('mother_disability') == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('mother_disability') == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('mother_disability') == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('mother_disability') == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('mother_disability') == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                                @error('mother_disability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Data Wali -->
                        <div class="form-check mt-4 mb-3">
                            <input class="form-check-input" type="checkbox" name="has_guardian" id="hasGuardian" {{ old('has_guardian') ? 'checked' : '' }}>
                            <label class="form-check-label" for="hasGuardian">
                                Memiliki Wali (Centang jika memiliki wali)
                            </label>
                        </div>

                        <div id="guardianFields" class="row g-3 {{ old('has_guardian') ? '' : 'd-none' }}">
                            <h5 class="mt-4">Data Wali</h5>
                            
                            <div class="col-md-6">
                                <label class="form-label">NIK Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_nik" class="form-control @error('guardian_nik') is-invalid @enderror" 
                                       value="{{ old('guardian_nik') }}" maxlength="16">
                                @error('guardian_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" 
                                       value="{{ old('guardian_name') }}">
                                @error('guardian_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Wali <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_birth_date" class="form-control datepicker @error('guardian_birth_date') is-invalid @enderror" 
                                    value="{{ old('guardian_birth_date') }}" placeholder="dd/mm/yyyy">
                                @error('guardian_birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Wali <span class="text-danger">*</span></label>
                                <input type="date" name="guardian_birth_date" class="form-control @error('guardian_birth_date') is-invalid @enderror" 
                                       value="{{ old('guardian_birth_date') }}">
                                @error('guardian_birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_education" class="form-select @error('guardian_education') is-invalid @enderror">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="Tidak Sekolah" {{ old('guardian_education') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="Putus Sekolah" {{ old('guardian_education') == 'Putus Sekolah' ? 'selected' : '' }}>Putus Sekolah</option>
                                    <option value="SD/MI/Sederajat" {{ old('guardian_education') == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('guardian_education') == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/SMK/MA/Sederajat" {{ old('guardian_education') == 'SMA/SMK/MA/Sederajat' ? 'selected' : '' }}>SMA/SMK/MA/Sederajat</option>
                                    <option value="D1" {{ old('guardian_education') == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('guardian_education') == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('guardian_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="D4/S1" {{ old('guardian_education') == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                    <option value="S2" {{ old('guardian_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('guardian_education') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('guardian_education')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_occupation" class="form-select @error('guardian_occupation') is-invalid @enderror">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Tidak Bekerja" {{ old('guardian_occupation') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                    <option value="Nelayan" {{ old('guardian_occupation') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Petani" {{ old('guardian_occupation') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Peternak" {{ old('guardian_occupation') == 'Peternak' ? 'selected' : '' }}>Peternak</option>
                                    <option value="PNS/TNI/Polri" {{ old('guardian_occupation') == 'PNS/TNI/Polri' ? 'selected' : '' }}>PNS/TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('guardian_occupation') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Pedagang" {{ old('guardian_occupation') == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                    <option value="Wiraswasta" {{ old('guardian_occupation') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Buruh" {{ old('guardian_occupation') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Pensiunan" {{ old('guardian_occupation') == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Lainnya" {{ old('guardian_occupation') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('guardian_occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penghasilan Wali <span class="text-danger">*</span></label>
                                <select name="guardian_income" class="form-select @error('guardian_income') is-invalid @enderror">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp 500.000" {{ old('guardian_income') == '< Rp 500.000' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                                    <option value="Rp 500.000 - Rp 1.000.000" {{ old('guardian_income') == 'Rp 500.000 - Rp 1.000.000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                                    <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('guardian_income') == 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                                    <option value="Rp 2.000.000 - Rp 3.000.000" {{ old('guardian_income') == 'Rp 2.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 3.000.000</option>
                                    <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('guardian_income') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                    <option value="> Rp 5.000.000" {{ old('guardian_income') == '> Rp 5.000.000' ? 'selected' : '' }}>&gt; Rp 5.000.000</option>
                                </select>
                                @error('guardian_income')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. HP Wali <span class="text-danger">*</span></label>
                                <input type="tel" name="guardian_phone" class="form-control @error('guardian_phone') is-invalid @enderror" 
                                       value="{{ old('guardian_phone') }}">
                                @error('guardian_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Berkebutuhan Khusus Wali <span class="text-danger">*</span></label>
                                <select name="guardian_disability" class="form-select @error('guardian_disability') is-invalid @enderror">
                                    <option value="Tidak Ada" {{ old('guardian_disability') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Tuna Netra" {{ old('guardian_disability') == 'Tuna Netra' ? 'selected' : '' }}>Tuna Netra</option>
                                    <option value="Tuna Rungu" {{ old('guardian_disability') == 'Tuna Rungu' ? 'selected' : '' }}>Tuna Rungu</option>
                                    <option value="Tuna Wicara" {{ old('guardian_disability') == 'Tuna Wicara' ? 'selected' : '' }}>Tuna Wicara</option>
                                    <option value="Tuna Daksa" {{ old('guardian_disability') == 'Tuna Daksa' ? 'selected' : '' }}>Tuna Daksa</option>
                                    <option value="Tuna Laras" {{ old('guardian_disability') == 'Tuna Laras' ? 'selected' : '' }}>Tuna Laras</option>
                                    <option value="Autis" {{ old('guardian_disability') == 'Autis' ? 'selected' : '' }}>Autis</option>
                                    <option value="ADHD" {{ old('guardian_disability') == 'ADHD' ? 'selected' : '' }}>ADHD</option>
                                    <option value="Slow Learner" {{ old('guardian_disability') == 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                                </select>
                                @error('guardian_disability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- UPLOAD BERKAS -->
                        <h4 class="mb-3 mt-5"><i class="fas fa-file-upload me-2"></i>Upload Berkas</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">KK <span class="text-danger">*</span></label>
                                <input type="file" name="kk_file" class="form-control @error('kk_file') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('kk_file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Akta Kelahiran <span class="text-danger">*</span></label>
                                <input type="file" name="birth_certificate" class="form-control @error('birth_certificate') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('birth_certificate')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">KTP Ibu <span class="text-danger">*</span></label>
                                <input type="file" name="mother_ktp" class="form-control @error('mother_ktp') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('mother_ktp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">KTP Ayah <span class="text-danger">*</span></label>
                                <input type="file" name="father_ktp" class="form-control @error('father_ktp') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('father_ktp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">KTP Wali (Opsional)</label>
                                <input type="file" name="guardian_ktp" class="form-control @error('guardian_ktp') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('guardian_ktp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ijazah Terakhir/SKL (Opsional)</label>
                                <input type="file" name="diploma" class="form-control @error('diploma') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('diploma')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Rapor Siswa <span class="text-danger">*</span></label>
                                <input type="file" name="report_card" class="form-control @error('report_card') is-invalid @enderror" 
                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('report_card')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>DAFTAR SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle current address fields
document.getElementById('sameAsKtp').addEventListener('change', function() {
    document.getElementById('currentAddressFields').classList.toggle('d-none', this.checked);
    
    if (this.checked) {
        // Copy values from KTP fields to current address fields
        document.querySelectorAll('[name^="current_"]').forEach(input => {
            const ktpField = input.name.replace('current_', 'parent_ktp_');
            const ktpValue = document.querySelector(`[name="${ktpField}"]`).value;
            input.value = ktpValue;
        });
    }
});

// Toggle guardian fields
document.getElementById('hasGuardian').addEventListener('change', function() {
    document.getElementById('guardianFields').classList.toggle('d-none', !this.checked);
});

// Form validation before submit
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    // Check if NIK already exists (client-side check, server-side validation is more important)
    const nik = document.querySelector('[name="nik"]').value;
    // This would normally make an AJAX call to check if NIK exists
});
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi datepicker
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
        
        if (this.checked) {
            // Copy values from KTP fields to current address fields
            document.querySelectorAll('[name^="current_"]').forEach(input => {
                const ktpField = input.name.replace('current_', 'parent_ktp_');
                const ktpValue = document.querySelector(`[name="${ktpField}"]`).value;
                input.value = ktpValue;
            });
        }
    });

    // Toggle guardian fields
    document.getElementById('hasGuardian').addEventListener('change', function() {
        document.getElementById('guardianFields').classList.toggle('d-none', !this.checked);
    });
});
</script>
@endpush
@endsection