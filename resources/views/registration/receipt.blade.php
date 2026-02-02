@extends('layouts.app')

@section('title', 'Bukti Pendaftaran - YAPISDA')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Bukti Pendaftaran Card -->
            <div class="card border-0 shadow-lg" id="receiptCard">
                <div class="card-body p-4">
                    <!-- Header dengan Logo -->
                    <div class="row mb-4">
                        <div class="col-3 text-center">
                            <img src="{{ asset('images/logo-yapisda.png') }}" 
                                 alt="Logo YAPISDA" 
                                 class="img-fluid logo-school"
                                 onerror="this.src='https://via.placeholder.com/100x100/2563eb/ffffff?text=YAPISDA'">
                        </div>
                        <div class="col-9 text-center">
                            <h5 class="fw-bold mb-0">YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h5>
                            <h6 class="mb-0">SMKS YAPISDA</h6>
                            <small class="text-muted">Jl. aya Cisoka - Tigaraksa Kp.Saga, Ds.Caringin, Kec.Cisoka, Kab.Tangerang-Banten 15730 </small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- QR Code dan Nomor Pendaftaran -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            {!! $qrCode !!}
                        </div>
                        <div class="bg-primary text-white p-3 rounded">
                            <h4 class="mb-0 fw-bold">{{ $applicant->registration_number }}</h4>
                            <small>Nomor Pendaftaran</small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Data Siswa Ringkas -->
                    <div class="row g-2 mb-3">
                        <div class="col-4"><small><strong>Nama</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->full_name }}</small></div>
                        
                        <div class="col-4"><small><strong>NIK</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->nik }}</small></div>
                        
                        <div class="col-4"><small><strong>TTL</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->birth_place }}, {{ $formattedDates['birth_date'] }}</small></div>
                        
                        <div class="col-4"><small><strong>Jenis Kelamin</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->gender }}</small></div>
                        
                        <div class="col-4"><small><strong>HP/WhatsApp</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->phone }}</small></div>
                        
                        <div class="col-4"><small><strong>Email</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->email }}</small></div>
                        
                        <div class="col-4"><small><strong>Asal Sekolah</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->previous_school }}</small></div>
                        
                        <div class="col-4"><small><strong>Jurusan</strong></small></div>
                        <div class="col-8"><small>: {{ $applicant->major_choice }}</small></div>
                    </div>

                    <hr class="my-3">

                    <!-- Status dan Tanggal -->
                    <div class="row">
                        <div class="col-6">
                            <small>
                                <strong>Status:</strong><br>
                                <span class="badge bg-{{ $applicant->status == 'verified' ? 'success' : ($applicant->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($applicant->status) }}
                                </span>
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <small>
                                <strong>Tanggal Daftar:</strong><br>
                                {{ \Carbon\Carbon::parse($applicant->created_at)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Catatan Penting -->
                    <div class="bg-light p-3 rounded small">
                        <i class="fas fa-info-circle text-primary me-1"></i>
                        <strong>CATATAN:</strong><br>
                        1. Simpan nomor pendaftaran ini dengan baik<br>
                        2. Bawa bukti ini saat verifikasi berkas di sekolah<br>
                        3. Verifikasi dilakukan pada tanggal 1 Februari - 11 Juli 2026<br>
                        4. Hubungi panitia jika ada kendala: (021) 59751260 / 082260203332 / 0895323042450
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-home me-1"></i>Home
                </a>
                <button onclick="printReceipt()" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i>Cetak
                </button>
                <a href="{{ route('registration.form') }}" class="btn btn-success">
                    <i class="fas fa-user-plus me-1"></i>Daftar Lagi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Logo Style */
.logo-school {
    max-height: 80px;
    object-fit: contain;
}

/* Print Styles */
@media print {
    body * {
        visibility: hidden;
    }
    #receiptCard, #receiptCard * {
        visibility: visible;
    }
    #receiptCard {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        border: none !important;
        box-shadow: none !important;
    }
    .navbar, .footer, .btn {
        display: none !important;
    }
    body {
        margin: 0;
        padding: 0;
        background: white !important;
    }
}

/* Card Style untuk Print */
#receiptCard {
    max-width: 21cm; /* Ukuran A4 width */
    margin: 0 auto;
    font-size: 0.85rem;
}

#receiptCard .card-body {
    padding: 20px !important;
}

/* Badge Status */
.badge {
    font-size: 0.75rem;
    padding: 5px 10px;
}
</style>

@push('scripts')
<script>
function printReceipt() {
    window.print();
}
</script>
@endpush
@endsection