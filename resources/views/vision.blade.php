@extends('layouts.app')

@section('title', 'Visi & Misi - YAPISDA')

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

    /* Status Colors */
    --success:       #10b981;
    --success-bg:    #ecfdf5;
    --success-text:  #065f46;
    --warning:       #f59e0b;
    --warning-bg:    #fffbeb;
    --warning-text:  #92400e;

    /* UI Tokens */
    --bg-page:       var(--ivory);
    --bg-card:       #ffffff;
    --border:        var(--ivory-dark);

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
}

/* === PAGE WRAPPER === */
.vision-wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem 3rem;
}

/* === SECTION CARDS === */
.vision-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-smooth);
    position: relative;
}

.vision-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.vision-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.vision-card:hover::before {
    opacity: 1;
}

/* === CARD HEADER === */
.card-header-yapisda {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    padding: 1.25rem 1.75rem;
    color: white;
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.card-header-yapisda::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 1.75rem;
    width: 40px;
    height: 2px;
    background: var(--gold);
    border-radius: 999px;
}

.card-header-yapisda h4 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-header-yapisda h4 i {
    color: var(--gold-light);
    font-size: 1.2rem;
}

/* === CARD BODY === */
.card-body-yapisda {
    padding: 1.75rem;
}

/* === VISION BOX === */
.vision-box {
    background: linear-gradient(135deg, var(--ivory), white);
    border: 2px solid var(--gold-pale);
    border-radius: var(--radius-lg);
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.vision-box::before {
    content: '';
    position: absolute;
    top: -50%; right: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.vision-icon {
    position: relative;
    z-index: 1;
    margin-bottom: 1.25rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.vision-icon i {
    color: var(--gold);
    font-size: 3rem;
    filter: drop-shadow(0 4px 12px rgba(201,168,76,0.3));
}

.vision-quote {
    position: relative;
    z-index: 1;
    font-family: var(--ff-display);
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--forest);
    line-height: 1.5;
    margin: 0;
}

.vision-quote::before,
.vision-quote::after {
    content: '"';
    color: var(--gold-dark);
    font-size: 2.5rem;
    font-family: Georgia, serif;
    opacity: 0.6;
    position: absolute;
}

.vision-quote::before {
    top: -10px;
    left: -15px;
}

.vision-quote::after {
    content: '"';
    bottom: -25px;
    right: -15px;
    transform: rotate(180deg);
}

/* === MISSION CARDS === */
.mission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.mission-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
    border-left: 4px solid var(--moss);
}

.mission-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.mission-card:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.mission-card:hover::before {
    opacity: 1;
}

.mission-card:nth-child(2) { border-left-color: var(--gold); }
.mission-card:nth-child(3) { border-left-color: var(--warning); }
.mission-card:nth-child(4) { border-left-color: var(--info, #3b82f6); }
.mission-card:nth-child(5) { border-left-color: var(--danger); }
.mission-card:nth-child(6),
.mission-card:nth-child(7) { border-left-color: var(--text-muted); }

.mission-number {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--moss);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.mission-card:hover .mission-number {
    background: var(--gold);
    transform: scale(1.05);
}

.mission-card:nth-child(2) .mission-number { background: var(--gold); }
.mission-card:nth-child(3) .mission-number { background: var(--warning); }
.mission-card:nth-child(4) .mission-number { background: var(--info, #3b82f6); }
.mission-card:nth-child(5) .mission-number { background: var(--danger); }
.mission-card:nth-child(6) .mission-number,
.mission-card:nth-child(7) .mission-number { background: var(--text-muted); }

.mission-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    color: var(--forest);
    margin: 0 0 0.5rem;
    line-height: 1.4;
}

.mission-card:nth-child(2) .mission-title { color: var(--gold-dark); }
.mission-card:nth-child(3) .mission-title { color: var(--warning-text); }
.mission-card:nth-child(4) .mission-title { color: var(--info-text, #1e40af); }
.mission-card:nth-child(5) .mission-title { color: var(--danger-text); }

.mission-desc {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
}

/* === GOALS CARDS === */
.goals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.goal-card {
    background: var(--bg-card);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem;
    transition: var(--transition);
    height: 100%;
}

.goal-card:hover {
    border-color: var(--gold);
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.goal-card.smk { border-color: var(--moss); }
.goal-card.smp { border-color: var(--gold); }

.goal-card.smk:hover { border-color: var(--gold); }
.goal-card.smp:hover { border-color: var(--moss); }

.goal-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0 0 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.goal-card.smk .goal-title { color: var(--moss); }
.goal-card.smp .goal-title { color: var(--gold-dark); }

.goal-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.goal-card li {
    padding: 0.35rem 0;
    padding-left: 1.5rem;
    position: relative;
    color: var(--text-mid);
    font-size: 0.9rem;
    line-height: 1.5;
}

.goal-card li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--gold);
    font-weight: 700;
}

/* === CORE VALUES === */
.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
}

.value-card {
    background: var(--ivory);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem 1rem;
    text-align: center;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.value-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.value-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.value-card:hover::before {
    opacity: 1;
}

.value-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 0.75rem;
    border-radius: 14px;
    background: var(--gold-pale);
    color: var(--gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    transition: var(--transition);
}

.value-card:hover .value-icon {
    background: var(--gold);
    color: var(--forest);
    transform: scale(1.05);
}

.value-name {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    color: var(--forest);
    margin: 0 0 0.35rem;
}

.value-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.4;
}

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

.vision-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.vision-card:nth-child(1) { animation-delay: 0.1s; opacity: 1; }
.vision-card:nth-child(2) { animation-delay: 0.2s; }
.vision-card:nth-child(3) { animation-delay: 0.3s; }
.vision-card:nth-child(4) { animation-delay: 0.4s; }

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .vision-wrapper {
        padding: 1rem;
    }

    .card-header-yapisda {
        padding: 1rem 1.25rem;
    }

    .card-header-yapisda h4 {
        font-size: 1.1rem;
    }

    .card-body-yapisda {
        padding: 1.25rem;
    }

    .vision-box {
        padding: 1.5rem;
    }

    .vision-quote {
        font-size: 1.1rem;
    }

    .mission-grid,
    .goals-grid,
    .values-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .vision-quote {
        font-size: 1rem;
    }

    .mission-number {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }
}

/* === PRINT STYLES === */
@media print {
    .vision-card::before,
    .mission-card::before,
    .value-card::before {
        display: none !important;
    }

    .vision-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        break-inside: avoid;
    }

    body {
        background: white;
        font-size: 11pt;
    }
}
</style>
@endpush

@section('content')
<div class="vision-wrapper">

    <!-- Visi Section -->
    <div class="vision-card">
        <div class="card-header-yapisda">
            <h4>
                <i class="fas fa-eye"></i>
                Visi YAPISDA
            </h4>
        </div>
        <div class="card-body-yapisda">
            <div class="vision-box">
                <div class="vision-icon">
                    <i class="fas fa-star"></i>
                </div>
                <p class="vision-quote">
                    Menjadi sekolah menengah kejuruan yang unggul dalam prestasi, berkarakter islami, berdaya saing global, serta mampu mencetak lulusan yang profesional, kreatif, dan siap menghadapi tantangan dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.
                </p>
            </div>
        </div>
    </div>

    <!-- Misi Section -->
    <div class="vision-card">
        <div class="card-header-yapisda">
            <h4>
                <i class="fas fa-list-check"></i>
                Misi YAPISDA
            </h4>
        </div>
        <div class="card-body-yapisda">
            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-number">1</div>
                    <h5 class="mission-title">Menyelenggarakan pendidikan kejuruan yang berkualitas</h5>
                    <p class="mission-desc">
                        Dengan mengutamakan pembelajaran berbasis kompetensi sesuai kebutuhan dunia industri dan perkembangan teknologi.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">2</div>
                    <h5 class="mission-title">Membentuk karakter siswa yang berakhlak mulia</h5>
                    <p class="mission-desc">
                        Berdisiplin, dan bertanggung jawab melalui pembiasaan nilai-nilai islami dalam kehidupan sehari-hari di lingkungan sekolah.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">3</div>
                    <h5 class="mission-title">Meningkatkan kualitas tenaga pendidik</h5>
                    <p class="mission-desc">
                        Melalui pelatihan, pengembangan profesional, dan penerapan metode pembelajaran inovatif.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">4</div>
                    <h5 class="mission-title">Menyediakan sarana dan prasarana memadai</h5>
                    <p class="mission-desc">
                        Untuk mendukung kegiatan teori maupun praktik secara optimal.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">5</div>
                    <h5 class="mission-title">Menjalin kemitraan dengan DU/DI</h5>
                    <p class="mission-desc">
                        Guna membuka peluang magang, pelatihan, serta penyaluran lulusan ke dunia kerja.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">6</div>
                    <h5 class="mission-title">Mendorong siswa untuk berprestasi</h5>
                    <p class="mission-desc">
                        Dalam bidang akademik, keterampilan kejuruan, maupun ekstrakurikuler di tingkat lokal, regional, dan nasional.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-number">7</div>
                    <h5 class="mission-title">Menanamkan jiwa wirausaha</h5>
                    <p class="mission-desc">
                        Agar lulusan memiliki kemandirian, kreativitas, dan mampu menciptakan peluang usaha di bidang keahliannya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tujuan Section -->
    <div class="vision-card">
        <div class="card-header-yapisda">
            <h4>
                <i class="fas fa-bullseye"></i>
                Tujuan Pendidikan
            </h4>
        </div>
        <div class="card-body-yapisda">
            <div class="goals-grid">
                <div class="goal-card smp">
                    <h5 class="goal-title">
                        <i class="fas fa-graduation-cap"></i>
                        Tujuan SMPS
                    </h5>
                    <ul>
                        <li>Mempersiapkan siswa melanjutkan ke jenjang pendidikan menengah atas/kejuruan</li>
                        <li>Mengembangkan potensi siswa agar menjadi manusia yang beriman dan bertakwa</li>
                        <li>Membekali siswa dengan ilmu pengetahuan, teknologi, dan seni</li>
                        <li>Membentuk karakter siswa yang berbudi pekerti luhur dan berkepribadian Indonesia</li>
                    </ul>
                </div>
                <div class="goal-card smk">
                    <h5 class="goal-title">
                        <i class="fas fa-industry"></i>
                        Tujuan SMKS
                    </h5>
                    <ul>
                        <li>Mempersiapkan tamatan yang kompeten di bidang keahlian tertentu</li>
                        <li>Membekali peserta didik dengan keterampilan profesional sesuai jurusan</li>
                        <li>Mengembangkan sikap profesional, produktif, dan kreatif</li>
                        <li>Membekali peserta didik untuk berwirausaha atau melanjutkan pendidikan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="vision-card">
        <div class="card-header-yapisda">
            <h4>
                <i class="fas fa-heart"></i>
                Nilai-Nilai Inti (Core Values)
            </h4>
        </div>
        <div class="card-body-yapisda">
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h5 class="value-name">Religius</h5>
                    <p class="value-desc">Beriman, bertakwa, dan berakhlak mulia</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h5 class="value-name">Integritas</h5>
                    <p class="value-desc">Jujur, disiplin, dan bertanggung jawab</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5 class="value-name">Inovatif</h5>
                    <p class="value-desc">Kreatif, kritis, dan berpikir maju</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5 class="value-name">Kolaboratif</h5>
                    <p class="value-desc">Kerjasama, toleransi, dan gotong royong</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Smooth scroll for anchor links (if any)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Enhance hover effects on mobile
document.addEventListener('DOMContentLoaded', function() {
    const missionCards = document.querySelectorAll('.mission-card');
    const valueCards = document.querySelectorAll('.value-card');

    // Add touch feedback for mobile
    [...missionCards, ...valueCards].forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'translateY(-2px)';
        });
        card.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });
});
</script>
@endpush
