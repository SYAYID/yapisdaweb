@extends('layouts.app')

@section('title', 'Visi & Misi - YAPISDA')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header Banner -->
            <div class="card mb-4 border-0 shadow-lg">
                <div class="card-body bg-gradient text-white text-center p-5">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-bullseye me-3"></i>Visi & Misi
                    </h1>
                    <p class="lead mb-0">Yayasan Pendidikan Islam Daar El Rohmah</p>
                </div>
            </div>

            <!-- Visi Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Visi YAPISDA
                    </h4>
                </div>
                <div class="card-body">
                    <div class="vision-box p-5 text-center">
                        <div class="vision-icon mb-4">
                            <i class="fas fa-star fa-4x text-warning"></i>
                        </div>
                        <blockquote class="blockquote">
                            <p class="mb-0 fs-3 fw-bold text-primary">
                                "Menjadi sekolah menengah kejuruan yang unggul dalam prestasi, berkarakter islami, berdaya saing global, serta mampu mencetak lulusan yang profesional, kreatif, dan siap menghadapi tantangan dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi."
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Misi Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-list-check me-2"></i>Misi YAPISDA
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-primary bg-light">
                                <div class="mission-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">1</span>
                                </div>
                                <h5 class="fw-bold text-primary mb-3">Menyelenggarakan pendidikan kejuruan yang berkualitas</h5>
                                <p class="mb-0 text-muted">
                                    Dengan mengutamakan pembelajaran berbasis kompetensi sesuai kebutuhan dunia industri dan perkembangan teknologi.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-success bg-light">
                                <div class="mission-number bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">2</span>
                                </div>
                                <h5 class="fw-bold text-success mb-3">Membentuk karakter siswa yang berakhlak mulia, berdisiplin, dan bertanggung jawabss</h5>
                                <p class="mb-0 text-muted">
                                    Melalui pembiasaan nilai-nilai islami dalam kehidupan sehari-hari di lingkungan sekolah.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-warning bg-light">
                                <div class="mission-number bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">3</span>
                                </div>
                                <h5 class="fw-bold text-warning mb-3">Meningkatkan kualitas tenaga pendidik dan tenaga kependidikan</h5>
                                <p class="mb-0 text-muted">
                                    Melalui pelatihan, pengembangan profesional, dan penerapan metode pembelajaran inovatif.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-info bg-light">
                                <div class="mission-number bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">4</span>
                                </div>
                                <h5 class="fw-bold text-info mb-3">Menyediakan sarana dan prasarana pembelajaran yang memadai</h5>
                                <p class="mb-0 text-muted">
                                    Untuk mendukung kegiatan teori maupun praktik secara optimal.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-danger bg-light">
                                <div class="mission-number bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">5</span>
                                </div>
                                <h5 class="fw-bold text-danger mb-3">Menjalin kemitraan dengan dunia usaha dan industri (DU/DI)/h5>
                                <p class="mb-0 text-muted">
                                    Guna membuka peluang magang, pelatihan, serta penyaluran lulusan ke dunia kerja..
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-secondary bg-light">
                                <div class="mission-number bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">6</span>
                                </div>
                                <h5 class="fw-bold text-secondary mb-3">Mendorong siswa untuk berprestasi</h5>
                                <p class="mb-0 text-muted">
                                    Dalam bidang akademik, keterampilan kejuruan, maupun kegiatan ekstrakurikuler di tingkat lokal, regional, dan nasional.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mission-card p-4 border-start border-4 border-secondary bg-light">
                                <div class="mission-number bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <span class="fs-4 fw-bold">7</span>
                                </div>
                                <h5 class="fw-bold text-secondary mb-3">Menanamkan jiwa wirausaha</h5>
                                <p class="mb-0 text-muted">
                                    Agar lulusan memiliki kemandirian, kreativitas, dan mampu menciptakan peluang usaha di bidang keahliannya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tujuan Section -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-bullseye me-2"></i>Tujuan Pendidikan
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-100 border-info">
                                <div class="card-body">
                                    <h5 class="fw-bold text-info mb-3">
                                        <i class="fas fa-graduation-cap me-2"></i>Tujuan SMPS
                                    </h5>
                                    <ul class="mb-0">
                                        <li class="mb-2">Mempersiapkan siswa melanjutkan ke jenjang pendidikan menengah atas/kejuruan</li>
                                        <li class="mb-2">Mengembangkan potensi siswa agar menjadi manusia yang beriman dan bertakwa</li>
                                        <li class="mb-2">Membekali siswa dengan ilmu pengetahuan, teknologi, dan seni</li>
                                        <li>Membentuk karakter siswa yang berbudi pekerti luhur dan berkepribadian Indonesia</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-warning">
                                <div class="card-body">
                                    <h5 class="fw-bold text-warning mb-3">
                                        <i class="fas fa-industry me-2"></i>Tujuan SMKS
                                    </h5>
                                    <ul class="mb-0">
                                        <li class="mb-2">Mempersiapkan tamatan yang kompeten di bidang keahlian tertentu</li>
                                        <li class="mb-2">Membekali peserta didik dengan keterampilan profesional sesuai jurusan</li>
                                        <li class="mb-2">Mengembangkan sikap profesional, produktif, dan kreatif</li>
                                        <li>Membekali peserta didik untuk berwirausaha atau melanjutkan pendidikan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai-Nilai Inti -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-heart me-2"></i>Nilai-Nilai Inti (Core Values)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-4 text-center">
                        <div class="col-md-3">
                            <div class="core-value p-4 bg-primary bg-opacity-10 rounded">
                                <i class="fas fa-mosque fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold text-primary">Religius</h5>
                                <p class="mb-0 text-muted small">Beriman, bertakwa, dan berakhlak mulia</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="core-value p-4 bg-success bg-opacity-10 rounded">
                                <i class="fas fa-balance-scale fa-3x text-success mb-3"></i>
                                <h5 class="fw-bold text-success">Integritas</h5>
                                <p class="mb-0 text-muted small">Jujur, disiplin, dan bertanggung jawab</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="core-value p-4 bg-info bg-opacity-10 rounded">
                                <i class="fas fa-lightbulb fa-3x text-info mb-3"></i>
                                <h5 class="fw-bold text-info">Inovatif</h5>
                                <p class="mb-0 text-muted small">Kreatif, kritis, dan berpikir maju</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="core-value p-4 bg-danger bg-opacity-10 rounded">
                                <i class="fas fa-handshake fa-3x text-danger mb-3"></i>
                                <h5 class="fw-bold text-danger">Kolaboratif</h5>
                                <p class="mb-0 text-muted small">Kerjasama, toleransi, dan gotong royong</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

.vision-box {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(30, 64, 175, 0.1) 100%);
    border-radius: 15px;
    border: 2px solid #2563eb;
}

.vision-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.mission-card {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.mission-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    background: white;
}

.mission-number {
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
}

.core-value {
    transition: all 0.3s ease;
}

.core-value:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endsection