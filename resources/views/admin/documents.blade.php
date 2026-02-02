@extends('layouts.app')

@section('title', 'Detail Berkas - ' . $applicant->registration_number)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>Detail Berkas Pendaftaran
                            </h4>
                            <p class="mb-0 mt-2">
                                <i class="fas fa-id-card me-2"></i>
                                <strong>{{ $applicant->registration_number }}</strong> - 
                                {{ $applicant->full_name }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Data Pribadi Siswa (Kiri) -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-user me-2"></i>Data Pribadi Siswa
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <p class="form-control-plaintext">{{ $applicant->full_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIK</label>
                        <p class="form-control-plaintext">{{ $applicant->nik }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">NISN</label>
                        <p class="form-control-plaintext">{{ $applicant->nisn ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tempat, Tanggal Lahir</label>
                        <p class="form-control-plaintext">{{ $applicant->birth_place }}, {{ $formattedDates['birth_date'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <p class="form-control-plaintext">{{ $applicant->gender }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Agama</label>
                        <p class="form-control-plaintext">{{ $applicant->religion }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP/WhatsApp</label>
                        <p class="form-control-plaintext">{{ $applicant->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p class="form-control-plaintext">{{ $applicant->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Asal Sekolah</label>
                        <p class="form-control-plaintext">{{ $applicant->previous_school }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jurusan Pilihan</label>
                        <p class="form-control-plaintext">{{ $applicant->major_choice }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="form-control-plaintext">
                            @if($applicant->status == 'pending')
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @elseif($applicant->status == 'verified')
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat KTP Orang Tua</label>
                <p class="form-control-plaintext">
                    {{ $applicant->parent_ktp_village }}, 
                    RT {{ $applicant->parent_ktp_rt }}/RW {{ $applicant->parent_ktp_rw }}<br>
                    Desa/Kel. {{ $applicant->parent_ktp_subdistrict }}<br>
                    Kec. {{ $applicant->parent_ktp_district }}<br>
                    Kab/Kota. {{ $applicant->parent_ktp_city }}<br> <!-- 👈 TAMBAHAN -->
                    Prov. {{ $applicant->parent_ktp_province }}
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Alamat Domisili Siswa</label>
                <p class="form-control-plaintext">
                    @if($applicant->same_as_ktp)
                        <span class="badge bg-info">Sama dengan alamat KTP</span>
                    @else
                        {{ $applicant->current_village }}, 
                        RT {{ $applicant->current_rt }}/RW {{ $applicant->current_rw }}<br>
                        Desa/Kel. {{ $applicant->current_subdistrict }}<br>
                        Kec. {{ $applicant->current_district }}<br>
                        Kab/Kota. {{ $applicant->current_city }}<br> <!-- 👈 TAMBAHAN -->
                        Prov. {{ $applicant->current_province }}
                    @endif
                </p>
            </div>
            <!-- Data Orang Tua -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user-friends me-2"></i>Data Orang Tua
                </div>
                <div class="card-body">
                    <h6 class="fw-bold text-primary">Ayah</h6>
                    <div class="mb-2">
                        <small>Nama: {{ $applicant->father_name }}</small>
                    </div>
                    <div class="mb-2">
                        <small>NIK: {{ $applicant->father_nik }}</small>
                    </div>
                    <div class="mb-2">
                        <small>Pekerjaan: {{ $applicant->father_occupation }}</small>
                    </div>
                    <div class="mb-3">
                        <small>HP: {{ $applicant->father_phone }}</small>
                    </div>

                    <hr>

                    <h6 class="fw-bold text-primary">Ibu</h6>
                    <div class="mb-2">
                        <small>Nama: {{ $applicant->mother_name }}</small>
                    </div>
                    <div class="mb-2">
                        <small>NIK: {{ $applicant->mother_nik }}</small>
                    </div>
                    <div class="mb-2">
                        <small>Pekerjaan: {{ $applicant->mother_occupation }}</small>
                    </div>
                    <div class="mb-2">
                        <small>HP: {{ $applicant->mother_phone }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Upload (Kanan) -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-folder-open me-2"></i>Dokumen yang Diupload
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($documents as $type => $doc)
                            @if($doc['path'])
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-{{ $doc['required'] ? 'primary' : 'secondary' }}">
                                        <div class="card-body text-center p-3">
                                            <!-- Preview Dokumen -->
                                            @php
                                                $fileExt = pathinfo($doc['path'], PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']);
                                            @endphp

                                            @if($isImage)
                                                <a href="{{ route('admin.document.preview', [$type, $applicant->id]) }}" 
                                                   target="_blank" 
                                                   class="text-decoration-none">
                                                    <div class="mb-2">
                                                        <i class="fas fa-file-image fa-3x text-primary"></i>
                                                    </div>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.document.preview', [$type, $applicant->id]) }}" 
                                                   target="_blank" 
                                                   class="text-decoration-none">
                                                    <div class="mb-2">
                                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                    </div>
                                                </a>
                                            @endif

                                            <h6 class="card-title fw-bold small mb-1">
                                                {{ $doc['label'] }}
                                            </h6>
                                            
                                            @if($doc['required'])
                                                <span class="badge bg-primary mb-2">Wajib</span>
                                            @else
                                                <span class="badge bg-secondary mb-2">Opsional</span>
                                            @endif

                                            <div class="small text-muted mb-2">
                                                {{ strtoupper($fileExt) }}
                                            </div>

                                            <div class="d-grid gap-2">
                                                <a href="{{ route('admin.document.preview', [$type, $applicant->id]) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                                <a href="{{ asset('storage/' . $doc['path']) }}" 
                                                   download 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if(!collect($documents)->filter(fn($d) => $d['path'])->count())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada dokumen yang diupload</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tombol Aksi Verifikasi -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="fas fa-check-circle me-2"></i>Aksi Verifikasi
                            </h5>
                            <small class="text-muted">Periksa semua dokumen sebelum melakukan verifikasi</small>
                        </div>
                        <div class="d-flex gap-2">
                            @if($applicant->status == 'pending')
                                <a href="{{ route('admin.verify', $applicant->id) }}" 
                                   class="btn btn-success"
                                   onclick="return confirm('Apakah Anda yakin ingin memverifikasi pendaftaran ini?\nPastikan semua dokumen sudah sesuai.')">
                                    <i class="fas fa-check me-1"></i>Verifikasi
                                </a>
                                <a href="{{ route('admin.reject', $applicant->id) }}" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran ini?')">
                                    <i class="fas fa-times me-1"></i>Tolak
                                </a>
                            @elseif($applicant->status == 'verified')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check me-1"></i>Sudah Terverifikasi
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times me-1"></i>Ditolak
                                </span>
                            @endif
                            <a href="{{ route('admin.print', $applicant->id) }}" 
                               class="btn btn-info"
                               target="_blank">
                                <i class="fas fa-print me-1"></i>Cetak Bukti
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-body .form-control-plaintext {
    background-color: #f8f9fa;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 8px;
}

.card-title {
    min-height: 40px;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.8rem;
}
</style>
@endsection