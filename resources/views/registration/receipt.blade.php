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
                    <div class="row align-items-center mb-4">
                        <div class="col-2 text-center">
                            <img src="{{ asset('images/logo-yapisda.svg') }}"
                                 alt="Logo YAPISDA"
                                 class="img-fluid"
                                 style="max-height: 60px; object-fit: contain;">
                        </div>
                        <div class="col-8 text-center">
                            <h6 class="fw-bold mb-0" style="font-family: 'Times New Roman', Times, serif; font-size: 11pt;">YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH</h6>
                            <h5 class="fw-bold mb-1" style="font-family: 'Times New Roman', Times, serif; font-size: 13pt; color: #0f5f4a;">SMKS YAPISDA CISOKA</h5>
                            <small class="text-muted" style="font-size: 7.5pt; display: block; line-height: 1.2;">Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kec. Cisoka, Kab. Tangerang, Banten 15730</small>
                        </div>
                        <div class="col-2 text-center">
                            <img src="{{ asset('images/LOGO PROVINSI BANTEN.svg') }}"
                                 alt="Logo Banten"
                                 class="img-fluid"
                                 style="max-height: 60px; object-fit: contain;">
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
                                <strong>Waktu Registrasi:</strong><br>
                                {{ $applicant->registered_at_label }}
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
                        4. Hubungi panitia jika ada kendala: (021) 59751260 / 082260203332 / 0895323042450<br>
                        5. <a href="https://chat.whatsapp.com/I1w3uf9IVpr8DXjCwEDLgL" target="_blank" class="text-success fw-bold text-decoration-none">
                            <i class="fab fa-whatsapp"></i> Gabung Grup WhatsApp PPDB YAPISDA
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-home me-1"></i>Home
                </a>
                <button onclick="printReceipt()" class="btn btn-primary me-2">
                    <i class="fas fa-print me-1"></i>Cetak
                </button>
                <a href="{{ route('registration.receipt.pdf', $applicant->id) }}" class="btn btn-danger me-2">
                    <i class="fas fa-file-pdf me-1"></i>Unduh PDF
                </a>
                <a href="https://chat.whatsapp.com/I1w3uf9IVpr8DXjCwEDLgL"
                   target="_blank"
                   class="btn me-2"
                   style="background-color: #25D366; border-color: #25D366; color: white;">
                    <i class="fab fa-whatsapp me-1"></i>Grup WhatsApp
                </a>
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
