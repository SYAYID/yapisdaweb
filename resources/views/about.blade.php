@extends('layouts.app')

@section('title', 'Profil - YAPISDA')

@push('styles')
<style>
/* === YAPISDA DESIGN TOKENS === */
:root {
    /* Core Colors */
    --primary:       #2E6B4F;
    --primary-dark:  #1E4535;
    --primary-light: #3D8B67;
    --gold:          #C9A84C;
    --gold-light:    #E8C97A;
    --gold-dark:     #A07830;
    --gold-pale:     #F5EDD8;
    --forest:        #0D2118;
    --forest-mid:    #163328;
    --forest-soft:   #1E4535;
    --moss:          #2E6B4F;
    --moss-light:    #3D8B67;
    --ivory:         #FAF7F0;
    --ivory-dark:    #EDE8DC;
    --cream:         #F0EAD6;

    /* Text Colors */
    --text-dark:     #1A1208;
    --text-mid:      #4A3F28;
    --text-muted:    #8A7A58;
    --text-light:    #FFFFFF;

    /* UI Tokens */
    --bg-page:       var(--ivory);
    --bg-card:       #ffffff;
    --border:        var(--ivory-dark);
    --border-hover:  #D8D0BE;

    --shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.07);
    --shadow-md: 0 6px 20px rgba(0,0,0,0.10);
    --shadow-lg: 0 12px 36px rgba(0,0,0,0.14);
    --shadow-gold: 0 8px 30px rgba(201,168,76,0.22);

    --radius:    14px;
    --radius-lg: 20px;
    --radius-xl: 28px;

    --transition:        all 0.2s ease-in-out;
    --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);

    /* Typography */
    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;
}

/* === BASE === */
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
    font-family: var(--ff-body);
    background: var(--bg-page);
    color: var(--text-dark);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}

/* === HERO SECTION === */
.profile-hero {
    position: relative;
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    padding: clamp(2.5rem, 6vw, 4rem) 0;
    overflow: hidden;
}

.profile-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.profile-hero::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
    animation: pulse 12s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 0.3; transform: scale(1.1); }
}

.profile-hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 2.5rem;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.profile-logo {
    flex-shrink: 0;
    width: 160px;
    height: 160px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-lg);
    border: 4px solid var(--gold-light);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.profile-logo img {
    width: 120px;
    height: 120px;
    object-fit: contain;
    border-radius: 50%;
}

.profile-hero-text {
    flex: 1;
    color: white;
}

.profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(201,168,76,0.2);
    color: var(--gold-light);
    padding: 0.4rem 1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(201,168,76,0.3);
}

.profile-hero-text h1 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: clamp(1.5rem, 3vw, 2rem);
    margin: 0 0 0.5rem;
    line-height: 1.3;
}

.profile-hero-text .subtitle {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0 0 1.25rem;
    font-weight: 400;
    max-width: 600px;
}

.profile-stats {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.profile-stat {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.profile-stat-value {
    font-family: var(--ff-display);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gold-light);
    line-height: 1.2;
}

.profile-stat-label {
    font-size: 0.8rem;
    opacity: 0.85;
    font-weight: 500;
}

/* === MAIN CONTAINER === */
.profile-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
}

/* === SECTIONS === */
.profile-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md);
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.profile-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.profile-section:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.profile-section:hover::before {
    opacity: 1;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gold-pale);
}

.section-header i {
    color: var(--gold-dark);
    font-size: 1.3rem;
}

.section-header h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.25rem;
    color: var(--forest);
    margin: 0;
}

/* === VISION & MISSION === */
.vision-mission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.vm-card {
    background: var(--ivory);
    border-radius: var(--radius);
    padding: 1.25rem;
    border-left: 4px solid var(--moss);
    transition: var(--transition);
}

.vm-card:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-sm);
}

.vm-card.mission {
    border-left-color: var(--gold);
}

.vm-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin-bottom: 0.75rem;
    font-size: 1.05rem;
}

.vm-title i {
    color: var(--moss);
}

.vm-card.mission .vm-title i {
    color: var(--gold-dark);
}

.vm-content {
    color: var(--text-mid);
    line-height: 1.7;
    font-size: 0.95rem;
    margin: 0;
}

/* === HISTORY TIMELINE === */
.timeline {
    position: relative;
    padding: 0.5rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0.5rem;
    bottom: 0.5rem;
    left: 22px;
    width: 2px;
    background: linear-gradient(to bottom, var(--moss), var(--gold));
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    padding-left: 56px;
    margin-bottom: 1.75rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: 12px;
    top: 0.25rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--moss);
    border: 4px solid white;
    box-shadow: var(--shadow-sm);
    z-index: 1;
    transition: var(--transition);
}

.timeline-item:hover .timeline-dot {
    transform: scale(1.15);
    background: var(--gold);
}

.timeline-year {
    font-family: var(--ff-display);
    font-weight: 700;
    color: var(--moss);
    font-size: 0.9rem;
    margin-bottom: 0.2rem;
}

.timeline-title {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.timeline-content {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.6;
}

/* === FACILITIES === */
.facilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
}

.facility-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem;
    text-align: center;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.facility-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.facility-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.facility-card:hover::before {
    opacity: 1;
}

.facility-icon {
    width: 52px;
    height: 52px;
    margin: 0 auto 0.75rem;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: var(--primary-50, #e8f5ef);
    color: var(--moss);
    transition: var(--transition);
}

.facility-card:hover .facility-icon {
    background: var(--gold-pale);
    color: var(--gold-dark);
    transform: scale(1.05);
}

.facility-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.facility-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* === EDUCATIONAL UNITS === */
.units-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.25rem;
}

.unit-card {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    color: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: var(--transition-smooth);
    border: 1px solid rgba(201,168,76,0.2);
}

.unit-card::before {
    content: '';
    position: absolute;
    top: -50%; right: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
    opacity: 0;
    transition: var(--transition);
}

.unit-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-gold);
}

.unit-card:hover::before {
    opacity: 1;
}

.unit-card.smp {
    background: linear-gradient(135deg, var(--moss) 0%, var(--primary-dark) 100%);
}

.unit-icon {
    font-size: 1.75rem;
    margin-bottom: 0.75rem;
    color: var(--gold-light);
}

.unit-name {
    font-family: var(--ff-display);
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.unit-desc {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.unit-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--gold-light);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    background: rgba(201,168,76,0.15);
}

.unit-link:hover {
    gap: 0.6rem;
    background: var(--gold);
    color: var(--forest);
}

/* === CONTACT INFO === */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--ivory);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    transition: var(--transition);
    cursor: pointer;
}

.contact-item:hover {
    background: var(--gold-pale);
    border-color: var(--gold);
    transform: translateX(3px);
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--gold-pale);
    color: var(--gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--transition);
}

.contact-item:hover .contact-icon {
    background: var(--gold);
    color: var(--forest);
}

.contact-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 600;
    margin-bottom: 0.15rem;
}

.contact-value {
    font-weight: 500;
    color: var(--text-dark);
    font-size: 0.9rem;
    line-height: 1.4;
}

.contact-value a {
    color: var(--moss);
    text-decoration: none;
    transition: var(--transition);
    font-weight: 600;
}

.contact-value a:hover {
    color: var(--gold-dark);
}

/* === COPY TOAST === */
.copy-toast {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: var(--forest);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: var(--shadow-lg);
    z-index: 9999;
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0;
}

.copy-toast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

.copy-toast i {
    font-size: 1.1rem;
    color: var(--gold-light);
}

/* === SCROLL ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

.profile-section {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.profile-section:nth-child(1) { animation-delay: 0.1s; opacity: 1; }
.profile-section:nth-child(2) { animation-delay: 0.2s; }
.profile-section:nth-child(3) { animation-delay: 0.3s; }
.profile-section:nth-child(4) { animation-delay: 0.4s; }
.profile-section:nth-child(5) { animation-delay: 0.5s; }

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .profile-hero-content {
        flex-direction: column;
        text-align: center;
        padding: 0 1rem;
    }

    .profile-stats {
        justify-content: center;
    }

    .profile-stat {
        align-items: center;
    }

    .profile-container {
        padding: 0 1rem 2rem;
    }

    .profile-section {
        padding: 1.5rem;
    }

    .timeline::before {
        left: 16px;
    }

    .timeline-item {
        padding-left: 44px;
    }

    .timeline-dot {
        left: 8px;
        width: 16px;
        height: 16px;
    }

    .facilities-grid,
    .units-grid,
    .contact-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .profile-hero {
        padding: 2rem 0;
    }

    .profile-logo {
        width: 130px;
        height: 130px;
    }

    .profile-logo img {
        width: 100px;
        height: 100px;
    }

    .profile-hero-text h1 {
        font-size: 1.4rem;
    }

    .profile-stats {
        gap: 1rem;
    }

    .profile-stat-value {
        font-size: 1.3rem;
    }

    .facilities-grid,
    .units-grid,
    .contact-grid {
        grid-template-columns: 1fr;
    }
}

/* === PRINT STYLES === */
@media print {
    .profile-hero::before,
    .profile-hero::after,
    .profile-section::before,
    .unit-link {
        display: none !important;
    }

    .profile-hero {
        background: white !important;
        color: black !important;
        padding: 1rem 0;
    }

    .profile-logo {
        border-color: #ccc !important;
        animation: none !important;
    }

    .profile-section {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        break-inside: avoid;
    }

    body {
        background: white;
        font-size: 11pt;
        color: black;
    }

    a {
        text-decoration: none;
        color: black;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="profile-hero">
    <div class="profile-hero-content">
        <div class="profile-logo">
            <img src="{{ asset('images/logo-yapisda.svg') }}"
                 alt="Logo YAPISDA"
                 onerror="this.src='https://via.placeholder.com/140x140/2E6B4F/E8C97A?text=YAPISDA'">
        </div>
        <div class="profile-hero-text">
            <div class="profile-badge">
                <i class="fas fa-school"></i>
                Profil Resmi
            </div>
            <h1>Yayasan Pendidikan Islam Daar El Rohmah</h1>
            <p class="subtitle">Mencetak Generasi Unggul yang Berakhlak, Cerdas, dan Kompetitif</p>

            <div class="profile-stats">
                <div class="profile-stat">
                    <span class="profile-stat-value">23+</span>
                    <span class="profile-stat-label">Tahun Pengalaman</span>
                </div>
                <div class="profile-stat">
                    <span class="profile-stat-value">10.000+</span>
                    <span class="profile-stat-label">Alumni</span>
                </div>
                <div class="profile-stat">
                    <span class="profile-stat-value">8</span>
                    <span class="profile-stat-label">Jurusan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="profile-container">

    <!-- About Section -->
    <div class="profile-section">
        <div class="section-header">
            <i class="fas fa-info-circle"></i>
            <h3>Tentang YAPISDA</h3>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <p style="color: var(--text-dark); font-weight: 500; font-size: 1.05rem; border-left: 3px solid var(--gold); padding-left: 1rem; margin-bottom: 1.25rem;">
                    <i class="fas fa-quote-left me-2" style="color: var(--gold-dark);"></i>
                    Menjadi sekolah menengah kejuruan yang unggul dalam prestasi, berkarakter islami, berdaya saing global, serta mampu mencetak lulusan yang profesional, kreatif, dan siap menghadapi tantangan dunia kerja.
                    <i class="fas fa-quote-right ms-2" style="color: var(--gold-dark);"></i>
                </p>

                <p style="color: var(--text-mid); line-height: 1.8;">
                    SMKS YAPISDA Cisoka merupakan salah satu sekolah menengah kejuruan swasta yang berdiri di bawah naungan Yayasan Pendidikan Islam Daar El Rohmah. Sekolah ini secara resmi mulai beroperasi pada <strong style="color: var(--forest);">25 September 2003</strong> berdasarkan Surat Keputusan Dinas Pendidikan Kabupaten Tangerang.
                </p>

                <p style="color: var(--text-mid); line-height: 1.8; margin-top: 0.75rem;">
                    Kehadirannya menjadi jawaban atas kebutuhan masyarakat Kecamatan Cisoka dan sekitarnya akan lembaga pendidikan kejuruan yang mampu mencetak lulusan berkompeten dan siap terjun ke dunia kerja. Dengan pengalaman lebih dari 23 tahun dalam dunia pendidikan, YAPISDA telah berhasil meluluskan ribuan siswa yang kini menjadi bagian dari masyarakat yang produktif dan berkontribusi positif bagi bangsa dan negara.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="vm-card">
                    <div class="vm-title">
                        <i class="fas fa-bullseye"></i>
                        Visi Kami
                    </div>
                    <p class="vm-content">
                        Mencetak generasi penerus bangsa yang berakhlak mulia, cerdas intelektual, terampil vokasional, dan siap bersaing di era global.
                    </p>
                </div>
                <div class="vm-card mission mt-3">
                    <div class="vm-title">
                        <i class="fas fa-rocket"></i>
                        Misi Kami
                    </div>
                    <p class="vm-content">
                        Menyelenggarakan pendidikan berkualitas dengan integrasi nilai-nilai Islam, pengembangan karakter, dan kompetensi vokasional yang relevan dengan kebutuhan industri.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- History Timeline -->
    <div class="profile-section">
        <div class="section-header">
            <i class="fas fa-history"></i>
            <h3>Sejarah Singkat</h3>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-year">2003</div>
                <div class="timeline-title">Pendirian YAPISDA</div>
                <div class="timeline-content">
                    SMKS YAPISDA resmi beroperasi berdasarkan SK Dinas Pendidikan Kabupaten Tangerang, membuka jurusan pertama: Teknik Komputer dan Jaringan.
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-year">2008</div>
                <div class="timeline-title">Ekspansi Jurusan</div>
                <div class="timeline-content">
                    Menambah 2 jurusan baru: Teknik Kendaraan Ringan (TKR) dan Teknik Sepeda Motor (TSM) untuk memenuhi kebutuhan industri otomotif.
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-year">2015</div>
                <div class="timeline-title">Pendirian SMPS</div>
                <div class="timeline-content">
                    Membuka jenjang pendidikan menengah pertama (SMPS YAPISDA) dengan program reguler dan boarding school untuk pembentukan karakter sejak dini.
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-year">2020</div>
                <div class="timeline-title">Modernisasi Fasilitas</div>
                <div class="timeline-content">
                    Renovasi total laboratorium dan penambahan fasilitas digital learning untuk mendukung pembelajaran berbasis teknologi.
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-year">2026</div>
                <div class="timeline-title">Era Baru Pendidikan</div>
                <div class="timeline-content">
                    Fokus pada pengembangan kurikulum merdeka, penguatan karakter islami, dan kemitraan industri untuk kesiapan kerja lulusan.
                </div>
            </div>
        </div>
    </div>

    <!-- Facilities -->
    <div class="profile-section">
        <div class="section-header">
            <i class="fas fa-building"></i>
            <h3>Fasilitas Lengkap</h3>
        </div>

        <div class="facilities-grid">
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="facility-name">Ruang Kelas</div>
                <div class="facility-desc">AC, Proyektor, Nyaman</div>
            </div>
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-laptop-code"></i></div>
                <div class="facility-name">Lab Komputer</div>
                <div class="facility-desc">50+ Unit Laptop Terbaru</div>
            </div>
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-tools"></i></div>
                <div class="facility-name">Lab Praktikum</div>
                <div class="facility-desc">TKR, TKJ, TSM, DKV, MPLB</div>
            </div>
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-book-open"></i></div>
                <div class="facility-name">Perpustakaan</div>
                <div class="facility-desc">1.000+ Koleksi Buku</div>
            </div>
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-futbol"></i></div>
                <div class="facility-name">Lapangan Olahraga</div>
                <div class="facility-desc">Futsal, Basket, Volly</div>
            </div>
            <div class="facility-card">
                <div class="facility-icon"><i class="fas fa-wifi"></i></div>
                <div class="facility-name">Internet Gratis</div>
                <div class="facility-desc">WiFi Coverage Area</div>
            </div>
        </div>
    </div>

    <!-- Educational Units -->
    <div class="profile-section">
        <div class="section-header">
            <i class="fas fa-graduation-cap"></i>
            <h3>Unit Pendidikan</h3>
        </div>

        <div class="units-grid">
            <div class="unit-card">
                <i class="fas fa-industry unit-icon"></i>
                <h4 class="unit-name">SMKS YAPISDA</h4>
                <p class="unit-desc">Sekolah Menengah Kejuruan dengan 6 jurusan unggulan untuk kesiapan kerja dan wirausaha.</p>
                <a href="{{ route('registration.form') }}" class="unit-link">
                    Daftar Sekarang <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="unit-card smp">
                <i class="fas fa-school unit-icon"></i>
                <h4 class="unit-name">SMPS YAPISDA</h4>
                <p class="unit-desc">Sekolah Menengah Pertama dengan pilihan reguler atau boarding school untuk pembentukan karakter.</p>
                <a href="{{ route('registration.smp-form') }}" class="unit-link">
                    Daftar Sekarang <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="profile-section">
        <div class="section-header">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Hubungi Kami</h3>
        </div>

        <div class="contact-grid">
            <div class="contact-item" onclick="copyText('Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730')" title="Klik untuk salin alamat">
                <div class="contact-icon"><i class="fas fa-map-pin"></i></div>
                <div>
                    <div class="contact-label">Alamat</div>
                    <div class="contact-value">
                        Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin, Kecamatan Cisoka, Kabupaten Tangerang, Provinsi Banten 15730
                    </div>
                </div>
            </div>

            <div class="contact-item" onclick="copyText('02159751260')" title="Klik untuk salin nomor">
                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <div class="contact-label">Telepon</div>
                    <div class="contact-value">
                        <a href="tel:02159751260">(021) 59751260</a>
                    </div>
                </div>
            </div>

            <div class="contact-item" onclick="copyText('08128906113')" title="Klik untuk salin WhatsApp">
                <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="contact-label">WhatsApp</div>
                    <div class="contact-value">
                        <a href="https://wa.me/628128906113" target="_blank" rel="noopener">08128906113</a>
                    </div>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="contact-label">Jam Operasional</div>
                    <div class="contact-value">
                        Senin - Jumat: 07.00 - 16.00 WIB<br>
                        Sabtu: 07.00 - 12.00 WIB
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Copy Toast Notification -->
<div class="copy-toast" id="copyToast">
    <i class="fas fa-check-circle"></i>
    <span id="copyMessage">Tersalin!</span>
</div>
@endsection

@push('scripts')
<script>
// Copy text to clipboard with toast notification
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('✅ Disalin ke clipboard!');
    }).catch(() => {
        // Fallback untuk browser lama
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast('✅ Disalin ke clipboard!');
    });
}

// Show toast notification
function showToast(message) {
    const toast = document.getElementById('copyToast');
    const msg = document.getElementById('copyMessage');

    msg.textContent = message;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Scroll animation for sections (progressive enhancement)
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.profile-section');

    // Show first section immediately, animate others on scroll
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        sections.forEach((section, index) => {
            if (index > 0) {
                section.style.opacity = '0';
                section.style.transform = 'translateY(24px)';
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(section);
            }
        });
    }

    // Add hover effect enhancement for contact items
    const contactItems = document.querySelectorAll('.contact-item');
    contactItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});

// Keyboard shortcut: Ctrl/Cmd + C to copy phone number
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
        const activeElement = document.activeElement;
        // Only copy if not in input/textarea
        if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            copyText('08128906113');
        }
    }
});
</script>
@endpush
