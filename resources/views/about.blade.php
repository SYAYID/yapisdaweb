@extends('layouts.app')

@section('title', 'Profil - YAPISDA')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Profil Yayasan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <img src="{{ asset('images/logo-yapisda.png') }}" 
                                 alt="Logo YAPISDA" 
                                 class="img-fluid rounded-circle shadow-lg"
                                 style="max-width: 250px; border: 5px solid #2563eb;"
                                 onerror="this.src='https://via.placeholder.com/250x250/2563eb/ffffff?text=YAPISDA'">
                            <h5 class="mt-3 fw-bold">YAPISDA</h5>
                            <p class="text-muted mb-0">Yayasan Pendidikan Islam Daar El Rohmah</p>
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-3">Yayasan Pendidikan Daar El Rohmah (YAPISDA)</h3>
                            
                            <p class="lead">
                                <i class="fas fa-quote-left text-primary me-2"></i>
                                Menjadi sekolah menengah kejuruan yang unggul dalam prestasi, berkarakter islami, berdaya saing global, serta mampu mencetak lulusan yang profesional, kreatif, dan siap menghadapi tantangan dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.
                                <i class="fas fa-quote-right text-primary ms-2"></i>
                            </p>
                            
                            <hr>
                            
                            <p class="text-justify">
                                Sejarah SMKS YAPISDA Cisoka

SMKS YAPISDA Cisoka merupakan salah satu sekolah menengah kejuruan swasta yang berdiri di bawah naungan Yayasan Pendidikan Islam Daar El Rohmah. Sekolah ini secara resmi mulai beroperasi pada 25 September 2003 berdasarkan Surat Keputusan Dinas Pendidikan Kabupaten Tangerang. Kehadirannya menjadi jawaban atas kebutuhan masyarakat Kecamatan Cisoka dan sekitarnya akan lembaga pendidikan kejuruan yang mampu mencetak lulusan berkompeten dan siap terjun ke dunia kerja.
                            </p>
                            
                            <p class="text-justify">
                                Dengan pengalaman lebih dari 23 tahun dalam dunia pendidikan, YAPISDA telah berhasil meluluskan ribuan siswa yang kini menjadi bagian dari masyarakat yang produktif dan berkontribusi positif bagi bangsa dan negara. Kami percaya bahwa pendidikan adalah investasi terbaik untuk masa depan generasi penerus bangsa.
                            </p>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card border-primary mb-3">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-primary mb-2">
                                                <i class="fas fa-graduation-cap me-2"></i>Unit Pendidikan
                                            </h6>
                                            <ul class="mb-0">
                                                <li>SMKS YAPISDA (Sekolah Menengah Kejuruan)</li>
                                                <li>SMPS YAPISDA (Sekolah Menengah Pertama)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-success mb-3">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-success mb-2">
                                                <i class="fas fa-medal me-2"></i>Prestasi
                                            </h6>
                                            <ul class="mb-0">
                                                <li>Juara 1 LKS Tingkat Provinsi 2025</li>
                                                <li>Juara 2 Olimpiade Sains Nasional 2024</li>
                                                <li>Akreditasi A (Unggul)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- Fasilitas -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-building me-2"></i>Fasilitas Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Ruang Kelas</h6>
                                    <p class="mb-0 text-muted">Yang nyaman dan aman untuk belajar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-microchip fa-3x text-success mb-3"></i>
                                    <h6 class="fw-bold">Lab Komputer</h6>
                                    <p class="mb-0 text-muted">Laptop Terbaru</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-cogs fa-3x text-info mb-3"></i>
                                    <h6 class="fw-bold">Lab Praktikum</h6>
                                    <p class="mb-0 text-muted">TKR, TKJ, TSM, DKV, MPLB</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-book fa-3x text-warning mb-3"></i>
                                    <h6 class="fw-bold">Perpustakaan</h6>
                                    <p class="mb-0 text-muted">1.000+ Koleksi Buku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-dumbbell fa-3x text-danger mb-3"></i>
                                    <h6 class="fw-bold">Lapangan Olahraga</h6>
                                    <p class="mb-0 text-muted">Futsal, Basket, Volly, Badminton</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-wifi fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Internet Gratis</h6>
                                    <p class="mb-0 text-muted">WiFi Coverage Area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 2px;
    background: #2563eb;
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-badge {
    position: absolute;
    left: 50%;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    transform: translateX(-50%);
    z-index: 1;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.timeline-content {
    width: calc(50% - 60px);
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-left: calc(50% + 30px);
}

.timeline-item:nth-child(even) .timeline-content {
    margin-right: calc(50% + 30px);
}

.timeline-item:nth-child(even) .timeline-badge {
    left: 50%;
}

@media (max-width: 768px) {
    .timeline::before {
        left: 30px;
    }
    
    .timeline-badge {
        left: 30px;
    }
    
    .timeline-content {
        width: calc(100% - 90px);
        margin-left: 90px !important;
        margin-right: 0 !important;
    }
}
</style>
@endsection