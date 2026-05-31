@extends('layouts.app')

@section('title', 'Dasbor Siswa - YAPISDA')

@section('content')
<div class="student-dashboard">
    <div class="container py-5">
        <div class="dashboard-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="dashboard-title">Halo, {{ $applicant->full_name }}!</h2>
                <p class="text-muted mb-0">Selamat datang di Dasbor Pendaftar YAPISDA.</p>
            </div>
            <a href="{{ route('student.logout') }}" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title text-forest"><i class="fas fa-info-circle me-2"></i>Status Pendaftaran Anda</h5>
                    </div>
                    <div class="card-body">
                        <div class="status-box mb-4">
                            <div class="status-label">Status Verifikasi</div>
                            @if($applicant->status === 'Verified')
                                <div class="status-value text-success">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </div>
                                <p class="status-desc mt-2">Selamat! Data pendaftaran Anda telah diverifikasi oleh Panitia. Silakan melanjutkan ke tahap pembayaran atau melengkapi berkas fisik.</p>
                            @elseif($applicant->status === 'Pending')
                                <div class="status-value text-warning">
                                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                                </div>
                                <p class="status-desc mt-2">Data Anda sedang dalam antrean untuk diverifikasi oleh Panitia. Mohon tunggu informasi selanjutnya.</p>
                            @else
                                <div class="status-value text-danger">
                                    <i class="fas fa-times-circle"></i> Ditolak/Dibatalkan
                                </div>
                                <p class="status-desc mt-2">Mohon maaf, pendaftaran Anda tidak dapat dilanjutkan. Silakan hubungi Panitia untuk informasi lebih lanjut.</p>
                            @endif
                        </div>

                        <div class="row info-grid">
                            <div class="col-md-6 mb-3">
                                <span class="info-label">Nomor Pendaftaran</span>
                                <strong class="info-value">{{ $applicant->registration_number }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="info-label">Tingkat Sekolah</span>
                                <strong class="info-value">{{ strtoupper($type) }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="info-label">Pilihan {{ $type === 'smk' ? 'Jurusan' : 'Program' }}</span>
                                <strong class="info-value">{{ $type === 'smk' ? $applicant->major_choice : $applicant->school_program }}</strong>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="info-label">NISN</span>
                                <strong class="info-value">{{ $applicant->nisn }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="card-title text-forest"><i class="fas fa-download me-2"></i>Unduh Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Unduh dan cetak bukti pendaftaran Anda untuk dibawa saat penyerahan berkas fisik atau daftar ulang.</p>
                        
                        <a href="{{ route('registration.receipt', $applicant->id) }}{{ $type === 'smp' ? '?type=smp' : '' }}" target="_blank" class="btn btn-brand w-100 mb-3 d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-print me-2"></i> Cetak Bukti Daftar</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <div class="alert alert-info border-0 bg-ivory">
                            <i class="fas fa-lightbulb text-brand mb-2"></i>
                            <p class="mb-0 small">Jika Anda sudah membayar biaya pendaftaran, Kartu Ujian/Kartu Pelajar akan dicetak oleh Panitia di sekolah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.student-dashboard {
    background-color: var(--surface);
    min-height: 80vh;
}
.dashboard-title {
    font-family: var(--ff-display);
    font-weight: 700;
    color: var(--forest);
}
.dashboard-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(15, 95, 74, 0.05);
    transition: transform 0.3s ease;
}
.text-forest { color: var(--forest); }
.bg-ivory { background-color: var(--ivory) !important; }
.btn-brand {
    background: var(--brand);
    color: white;
    border: none;
    padding: 0.8rem 1.2rem;
    border-radius: 12px;
    font-weight: 600;
}
.btn-brand:hover {
    background: var(--brand-dark);
    color: white;
}
.status-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
}
.status-label {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}
.status-value {
    font-size: 1.5rem;
    font-weight: 700;
}
.status-desc {
    font-size: 0.95rem;
    color: #475569;
}
.info-grid .info-label {
    display: block;
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 0.2rem;
}
.info-grid .info-value {
    display: block;
    font-size: 1.1rem;
    color: #0f172a;
}
</style>
@endsection
