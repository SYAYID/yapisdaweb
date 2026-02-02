@extends('layouts.app')

@section('title', 'Kontak - YAPISDA')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header Banner -->
            <div class="card mb-4 border-0 shadow-lg">
                <div class="card-body bg-gradient text-white text-center p-5">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-address-book me-3"></i>Hubungi Kami
                    </h1>
                    <p class="lead mb-0">Yayasan Pendidikan Islam Daar El Rohmah</p>
                </div>
            </div>

            <div class="row">
                <!-- Informasi Kontak (Kiri) -->
                <div class="col-lg-6">
                    <!-- Alamat -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="contact-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon bg-primary text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-school fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-primary mb-2">Kantor Yayasan</h6>
                                        <p class="mb-0 text-muted">
                                            Jl. Raya Cisoka - Tigaraksa <br>
                                            Desa/Kelurahan: Caringin<br>
                                            Kecamatan: Cisoka<br>
                                            Kabupaten/Kota: Tangerang<br>
                                            Provinsi: Banten 15730<br>
                                            Indonesia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon bg-info text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-building fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-info mb-2">SMKS YAPISDA</h6>
                                        <p class="mb-0 text-muted">
                                            Jl. Raya Cisoka - Tigaraksa Kp.Saga, Ds.Caringin, Kec.Cisoka, Kab.Tangerang-Banten, Banten<br>
                                            (Bersebelahan dengan Kantor Yayasan)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="d-flex align-items-start">
                                    <div class="icon bg-success text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-building fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-success mb-2">SMPS YAPISDA</h6>
                                        <p class="mb-0 text-muted">
                                            Jl. Raya Cisoka - Tigaraksa Kp.Saga, Ds.Caringin, Kec.Cisoka, Kab.Tangerang-Banten, Banten<br>
                                            (Bersebelahan dengan Kantor Yayasan)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Telepon & Email -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-phone-alt me-2"></i>Kontak Telepon & Email
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="contact-box p-3 border-start border-4 border-primary bg-light h-100">
                                        <div class="text-center mb-3">
                                            <i class="fas fa-phone fa-3x text-primary"></i>
                                        </div>
                                        <h6 class="fw-bold text-primary mb-2">Telepon</h6>
                                        <p class="mb-1">
                                            <i class="fas fa-phone me-2"></i>(021) 59751260
                                        </p>
                                        <p class="mb-1">
                                            <i class="fas fa-fax me-2"></i>(021) 59751261
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-mobile-alt me-2"></i>08128906113
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-box p-3 border-start border-4 border-info bg-light h-100">
                                        <div class="text-center mb-3">
                                            <i class="fas fa-envelope fa-3x text-info"></i>
                                        </div>
                                        <h6 class="fw-bold text-info mb-2">Email</h6>
                                        <p class="mb-2">
                                            <i class="fas fa-envelope me-2"></i>Coming Soon
                                        </p>
                                        <p class="mb-2">
                                            <i class="fas fa-user-graduate me-2"></i>Coming Soon
                                        </p>
                                        <p class="mb-0">
                                            <i class="fas fa-building me-2"></i>Coming Soon
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Sosial -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-share-alt me-2"></i>Media Sosial
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="#" class="social-link d-block p-3 text-decoration-none bg-facebook rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-facebook-f fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">Facebook</div>
                                                <small class="text-white">/yapisda.official</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="social-link d-block p-3 text-decoration-none bg-instagram rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-instagram fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">Instagram</div>
                                                <small class="text-white">@yapisda_official</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="social-link d-block p-3 text-decoration-none bg-youtube rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-youtube fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">YouTube</div>
                                                <small class="text-white">YAPISDA Official</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="social-link d-block p-3 text-decoration-none bg-twitter rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-twitter fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">Twitter</div>
                                                <small class="text-white">@yapisda_id</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps & Form (Kanan) -->
                <div class="col-lg-6">
                    <!-- Google Maps -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-map me-2"></i>Lokasi Kami
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="map-container" style="height: 300px;">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.009689023817!2d106.42823072393941!3d-6.262453112382149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42043022fe465f%3A0x7782f126083ce65!2sSMK%20Yapisda!5e0!3m2!1sen!2sid!4v1769761650336!5m2!1sen!2sid" 
                                    width="100%" 
                                    height="300" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                            <div class="card-body">
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Klik pada peta untuk melihat lokasi lebih detail di Google Maps
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clock me-2"></i>Jam Operasional
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="schedule-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold text-primary mb-1">Senin - Jumat</h6>
                                        <small class="text-muted">Jam Kerja Administrasi</small>
                                    </div>
                                    <span class="badge bg-primary">07.00 - 15.00 WIB</span>
                                </div>
                            </div>
                            
                            <div class="schedule-item mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold text-success mb-1">Sabtu</h6>
                                        <small class="text-muted">Jam Kerja Terbatas</small>
                                    </div>
                                    <span class="badge bg-success">07.00 - 15.00 WIB</span>
                                </div>
                            </div>
                            
                            <div class="schedule-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold text-danger mb-1">Minggu & Hari Libur</h6>
                                        <small class="text-muted">Tutup</small>
                                    </div>
                                    <span class="badge bg-danger">Libur</span>
                                </div>
                            </div>

                            <hr>

                            <div class="alert alert-info mb-0">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Pelayanan Khusus PPDB:</strong><br>
                                Senin - Sabtu, 07.00 - 15.00 WIB (Februari - Juli)
                            </div>
                        </div>
                    </div>

                    <!-- Form Kontak -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-envelope-open-text me-2"></i>Kirim Pesan
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Anda" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Masukkan email Anda" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">No. Telepon</label>
                                    <input type="tel" class="form-control" placeholder="Masukkan nomor telepon">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subjek <span class="text-danger">*</span></label>
                                    <select class="form-select" required>
                                        <option value="">Pilih subjek pesan</option>
                                        <option value="ppdb">Pertanyaan PPDB</option>
                                        <option value="akademik">Pertanyaan Akademik</option>
                                        <option value="kerja-sama">Kerjasama/Kemitraan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pesan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </form>
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

.contact-item {
    padding: 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: rgba(37, 99, 235, 0.05);
    transform: translateX(5px);
}

.contact-box {
    transition: all 0.3s ease;
}

.contact-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.social-link {
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.bg-facebook { background: #3b5998; }
.bg-instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.bg-youtube { background: #ff0000; }
.bg-twitter { background: #1da1f2; }

.map-container iframe {
    border-radius: 8px 8px 0 0;
}

.schedule-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.schedule-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}
</style>
@endsection