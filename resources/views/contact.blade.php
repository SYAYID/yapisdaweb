@extends('layouts.app')

@section('title', 'Kontak - YAPISDA')

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
    --border-hover:  #D8D0BE;

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

/* === HERO SECTION === */
.contact-hero {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    padding: clamp(2.5rem, 6vw, 4rem) 0;
    color: white;
    position: relative;
    overflow: hidden;
}

.contact-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.contact-hero::after {
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

.contact-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 700px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.contact-hero h1 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: clamp(1.5rem, 3vw, 2.25rem);
    margin: 0 0 0.75rem;
    line-height: 1.3;
}

.contact-hero p {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0 0 1.5rem;
    max-width: 550px;
    margin-left: auto;
    margin-right: auto;
}

.contact-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(201,168,76,0.2);
    color: var(--gold-light);
    padding: 0.4rem 1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
    border: 1px solid rgba(201,168,76,0.3);
}

/* === MAIN CONTAINER === */
.contact-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
}

/* === CONTACT CARD === */
.contact-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    box-shadow: var(--shadow-md);
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.contact-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.contact-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.contact-card:hover::before {
    opacity: 1;
}

.card-header-yapisda {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gold-pale);
}

.card-header-yapisda i {
    color: var(--gold-dark);
    font-size: 1.3rem;
}

.card-header-yapisda h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.15rem;
    color: var(--forest);
    margin: 0;
}

/* === LOCATION ITEMS === */
.location-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--ivory);
    border-radius: var(--radius);
    margin-bottom: 0.75rem;
    transition: var(--transition);
    border-left: 4px solid var(--moss);
}

.location-item:hover {
    transform: translateX(4px);
    background: var(--gold-pale);
}

.location-item.smk { border-left-color: var(--gold); }
.location-item.smp { border-left-color: var(--warning); }

.location-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    background: var(--gold-pale);
    color: var(--gold-dark);
    transition: var(--transition);
}

.location-item:hover .location-icon {
    background: var(--gold);
    color: var(--forest);
}

.location-content h4 {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.35rem;
    font-size: 0.95rem;
}

.location-content p {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.5;
}

.location-content small {
    display: block;
    margin-top: 0.25rem;
    color: var(--gold-dark);
    font-weight: 500;
}

/* === INFO BOXES === */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 0.75rem;
}

.info-box {
    background: var(--ivory);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem 1rem;
    text-align: center;
    transition: var(--transition-smooth);
}

.info-box:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.info-icon {
    width: 52px;
    height: 52px;
    margin: 0 auto 0.75rem;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: var(--gold-pale);
    color: var(--gold-dark);
    transition: var(--transition);
}

.info-box:hover .info-icon {
    background: var(--gold);
    color: var(--forest);
    transform: scale(1.05);
}

.info-box.phone .info-icon { background: var(--primary-50, #e8f5ef); color: var(--moss); }
.info-box.whatsapp .info-icon { background: var(--success-bg); color: var(--success); }
.info-box.email .info-icon { background: var(--info-bg, #eff6ff); color: var(--info, #3b82f6); }

.info-box h4 {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
}

.info-box p {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin: 0.15rem 0;
}

.info-box a {
    color: var(--moss);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.info-box a:hover {
    color: var(--gold-dark);
}

/* === SOCIAL MEDIA === */
.social-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 0.6rem;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem;
    border-radius: var(--radius);
    text-decoration: none;
    color: white;
    transition: var(--transition);
    font-size: 0.85rem;
    background: var(--forest);
}

.social-link:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
    box-shadow: var(--shadow-gold);
}

.social-link i {
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
}

.social-link .social-info {
    flex: 1;
    min-width: 0;
}

.social-link .social-name {
    font-weight: 600;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.social-link .social-handle {
    font-size: 0.75rem;
    opacity: 0.85;
    display: block;
}

.social-link.facebook { background: #1877F2; }
.social-link.instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.social-link.youtube { background: #FF0000; }
.social-link.twitter { background: #1DA1F2; }
.social-link.tiktok { background: #000000; }
.social-link.whatsapp { background: #25D366; }

/* === MAP SECTION === */
.map-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.map-header {
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    border-bottom: 1px solid var(--border);
    background: var(--ivory);
}

.map-header i {
    color: var(--gold-dark);
    font-size: 1.2rem;
}

.map-header h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin: 0;
    font-size: 1.1rem;
}

.map-container {
    height: 280px;
    position: relative;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
    filter: grayscale(20%) contrast(1.05);
    transition: var(--transition);
}

.map-container:hover iframe {
    filter: none;
}

.map-overlay {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    right: 1rem;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(8px);
    padding: 0.6rem 0.9rem;
    border-radius: 10px;
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.4rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
}

.map-overlay i {
    color: var(--gold-dark);
}

/* === SCHEDULE SECTION === */
.schedule-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
}

.schedule-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gold-pale);
}

.schedule-header i {
    color: var(--gold-dark);
    font-size: 1.2rem;
}

.schedule-header h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin: 0;
    font-size: 1.1rem;
}

.schedule-list {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.schedule-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: var(--ivory);
    border-radius: 10px;
    transition: var(--transition);
}

.schedule-item:hover {
    background: var(--gold-pale);
    transform: translateX(3px);
}

.schedule-day {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.9rem;
}

.schedule-day small {
    display: block;
    font-weight: 400;
    color: var(--text-muted);
    font-size: 0.75rem;
    margin-top: 0.15rem;
}

.schedule-time {
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
}

.schedule-time.available { background: var(--success-bg); color: var(--success-text); }
.schedule-time.limited { background: var(--warning-bg); color: var(--warning-text); }
.schedule-time.closed { background: var(--danger-bg, #fef2f2); color: var(--danger-text, #991b1b); }

.schedule-note {
    margin-top: 1rem;
    padding: 0.9rem;
    background: var(--gold-pale);
    border-radius: 10px;
    font-size: 0.85rem;
    color: var(--gold-dark);
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    border: 1px solid rgba(160,120,48,0.2);
}

.schedule-note i {
    margin-top: 0.15rem;
    color: var(--gold);
}

/* === CONTACT FORM === */
.form-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    box-shadow: var(--shadow-md);
}

.form-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gold-pale);
}

.form-header i {
    color: var(--gold-dark);
    font-size: 1.2rem;
}

.form-header h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin: 0;
    font-size: 1.1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-mid);
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}

.form-label .required {
    color: var(--danger, #ef4444);
}

.form-control,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--ff-body);
    transition: var(--transition);
    background: white;
    color: var(--text-dark);
}

.form-control:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 4px rgba(160, 120, 48, 0.12);
    background: #fffef9;
}

.form-textarea {
    min-height: 110px;
    resize: vertical;
}

.form-hint {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.btn-submit {
    width: 100%;
    padding: 0.8rem 1.5rem;
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    font-family: var(--ff-body);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(46, 107, 79, 0.25);
}

.btn-submit:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 107, 79, 0.35);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
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

/* === ANIMATIONS === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

.contact-card,
.map-card,
.schedule-card,
.form-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.contact-card:nth-child(1) { animation-delay: 0.1s; opacity: 1; }
.contact-card:nth-child(2) { animation-delay: 0.2s; }
.contact-card:nth-child(3) { animation-delay: 0.3s; }
.map-card { animation-delay: 0.2s; opacity: 1; }
.schedule-card { animation-delay: 0.3s; }
.form-card { animation-delay: 0.4s; }

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .contact-hero {
        padding: 2.5rem 0;
    }

    .contact-container {
        padding: 0 1rem 2rem;
    }

    .contact-grid {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .social-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .contact-card,
    .form-card,
    .schedule-card {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .contact-hero h1 {
        font-size: 1.4rem;
    }

    .contact-hero p {
        font-size: 0.95rem;
    }

    .info-grid,
    .social-grid {
        grid-template-columns: 1fr;
    }

    .schedule-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .schedule-time {
        align-self: flex-end;
    }
}

/* === PRINT STYLES === */
@media print {
    .contact-hero::before,
    .contact-hero::after,
    .contact-card::before,
    .map-overlay,
    .btn-submit {
        display: none !important;
    }

    .contact-hero {
        background: white !important;
        color: black !important;
        padding: 1rem 0;
    }

    .contact-card,
    .map-card,
    .schedule-card,
    .form-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        break-inside: avoid;
    }

    body {
        background: white;
        font-size: 11pt;
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
<section class="contact-hero">
    <div class="contact-hero-content">
        <div class="contact-badge">
            <i class="fas fa-headset"></i>
            Hubungi Kami
        </div>
        <h1>Kontak YAPISDA</h1>
        <p>
            Kami siap membantu Anda dengan pertanyaan seputar pendaftaran, akademik,
            atau kerjasama. Silakan hubungi kami melalui berbagai saluran di bawah ini.
        </p>
    </div>
</section>

<!-- Main Content -->
<div class="contact-container">
    <div class="contact-grid">
        <!-- Left Column: Contact Info -->
        <div class="contact-column">
            <!-- Location Card -->
            <div class="contact-card">
                <div class="card-header-yapisda">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Alamat Lengkap</h3>
                </div>

                <div class="location-item">
                    <div class="location-icon"><i class="fas fa-building"></i></div>
                    <div class="location-content">
                        <h4>Kantor Yayasan</h4>
                        <p>
                            Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin<br>
                            Kecamatan Cisoka, Kabupaten Tangerang<br>
                            Provinsi Banten 15730<br>
                            Indonesia
                        </p>
                    </div>
                </div>

                <div class="location-item smk">
                    <div class="location-icon"><i class="fas fa-industry"></i></div>
                    <div class="location-content">
                        <h4>SMKS YAPISDA</h4>
                        <p>
                            Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin<br>
                            Kecamatan Cisoka, Kabupaten Tangerang<br>
                            Provinsi Banten 15730<br>
                            <small>(Bersebelahan dengan Kantor Yayasan)</small>
                        </p>
                    </div>
                </div>

                <div class="location-item smp">
                    <div class="location-icon"><i class="fas fa-school"></i></div>
                    <div class="location-content">
                        <h4>SMPS YAPISDA</h4>
                        <p>
                            Jl. Raya Cisoka - Tigaraksa, Kp. Saga, Desa Caringin<br>
                            Kecamatan Cisoka, Kabupaten Tangerang<br>
                            Provinsi Banten 15730<br>
                            <small>(Bersebelahan dengan Kantor Yayasan)</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Methods Card -->
            <div class="contact-card">
                <div class="card-header-yapisda">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Kontak Telepon & Email</h3>
                </div>

                <div class="info-grid">
                    <div class="info-box phone">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <h4>Telepon</h4>
                        <p><a href="tel:02159751260">(021) 59751260</a></p>
                        <p><a href="tel:02159751261">(021) 59751261</a></p>
                        <p><a href="tel:08128906113">08128906113</a></p>
                    </div>

                    <div class="info-box whatsapp">
                        <div class="info-icon"><i class="fab fa-whatsapp"></i></div>
                        <h4>WhatsApp</h4>
                        <p><a href="https://wa.me/628128906113" target="_blank" rel="noopener">Chat Sekarang</a></p>
                        <p class="form-hint">Respon cepat 24/7</p>
                    </div>

                    <div class="info-box email">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <h4>Email</h4>
                        <p>Coming Soon</p>
                        <p class="form-hint">info@yapisda.sch.id</p>
                    </div>
                </div>
            </div>

            <!-- Social Media Card -->
            <div class="contact-card">
                <div class="card-header-yapisda">
                    <i class="fas fa-share-alt"></i>
                    <h3>Media Sosial</h3>
                </div>

                <div class="social-grid">
                    <a href="#" class="social-link facebook" target="_blank" rel="noopener">
                        <i class="fab fa-facebook-f"></i>
                        <div class="social-info">
                            <span class="social-name">Facebook</span>
                            <span class="social-handle">/yapisda.official</span>
                        </div>
                    </a>

                    <a href="#" class="social-link instagram" target="_blank" rel="noopener">
                        <i class="fab fa-instagram"></i>
                        <div class="social-info">
                            <span class="social-name">Instagram</span>
                            <span class="social-handle">@yapisda_official</span>
                        </div>
                    </a>

                    <a href="#" class="social-link youtube" target="_blank" rel="noopener">
                        <i class="fab fa-youtube"></i>
                        <div class="social-info">
                            <span class="social-name">YouTube</span>
                            <span class="social-handle">YAPISDA Official</span>
                        </div>
                    </a>

                    <a href="#" class="social-link tiktok" target="_blank" rel="noopener">
                        <i class="fab fa-tiktok"></i>
                        <div class="social-info">
                            <span class="social-name">TikTok</span>
                            <span class="social-handle">@yapisda_id</span>
                        </div>
                    </a>

                    <a href="#" class="social-link twitter" target="_blank" rel="noopener">
                        <i class="fab fa-twitter"></i>
                        <div class="social-info">
                            <span class="social-name">Twitter</span>
                            <span class="social-handle">@yapisda_id</span>
                        </div>
                    </a>

                    <a href="https://wa.me/628128906113" class="social-link whatsapp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i>
                        <div class="social-info">
                            <span class="social-name">WhatsApp</span>
                            <span class="social-handle">08128906113</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Map & Form -->
        <div class="contact-column">
            <!-- Google Maps Card -->
            <div class="map-card">
                <div class="map-header">
                    <i class="fas fa-map"></i>
                    <h3>Lokasi Kami</h3>
                </div>
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.009689023817!2d106.42823072393941!3d-6.262453112382149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42043022fe465f%3A0x7782f126083ce65!2sSMK%20Yapisda!5e0!3m2!1sen!2sid!4v1769761650336!5m2!1sen!2sid"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi YAPISDA di Google Maps">
                    </iframe>
                    <div class="map-overlay">
                        <i class="fas fa-info-circle"></i>
                        Klik peta untuk melihat lokasi lebih detail
                    </div>
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="schedule-card">
                <div class="schedule-header">
                    <i class="fas fa-clock"></i>
                    <h3>Jam Operasional</h3>
                </div>

                <div class="schedule-list">
                    <div class="schedule-item">
                        <div class="schedule-day">
                            Senin - Jumat
                            <small>Jam Kerja Administrasi</small>
                        </div>
                        <span class="schedule-time available">07.00 - 15.00 WIB</span>
                    </div>

                    <div class="schedule-item">
                        <div class="schedule-day">
                            Sabtu
                            <small>Jam Kerja Terbatas</small>
                        </div>
                        <span class="schedule-time limited">07.00 - 12.00 WIB</span>
                    </div>

                    <div class="schedule-item">
                        <div class="schedule-day">
                            Minggu & Hari Libur
                            <small>Tutup</small>
                        </div>
                        <span class="schedule-time closed">Libur</span>
                    </div>
                </div>

                <div class="schedule-note">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Pelayanan Khusus PPDB:</strong><br>
                        Senin - Sabtu, 07.00 - 15.00 WIB (Februari - Juli)
                    </div>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="form-card">
                <div class="form-header">
                    <i class="fas fa-envelope-open-text"></i>
                    <h3>Kirim Pesan</h3>
                </div>

                <form action="#" method="POST" id="contactForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama Anda" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan email Anda" required>
                        <small class="form-hint">Kami akan membalas ke email ini</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon / WhatsApp</label>
                        <input type="tel" class="form-control" name="phone" placeholder="08xxxxxxxxxx" id="phoneInput">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subjek <span class="required">*</span></label>
                        <select class="form-select" name="subject" required>
                            <option value="">Pilih subjek pesan</option>
                            <option value="ppdb">❓ Pertanyaan PPDB</option>
                            <option value="akademik">📚 Pertanyaan Akademik</option>
                            <option value="kerjasama">🤝 Kerjasama/Kemitraan</option>
                            <option value="lainnya">💬 Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pesan <span class="required">*</span></label>
                        <textarea class="form-textarea" name="message" placeholder="Tulis pesan Anda di sini..." required maxlength="1000"></textarea>
                        <small class="form-hint"><span id="charCount">0</span>/1000 karakter</small>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>Kirim Pesan
                    </button>
                </form>
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
// Copy phone/email to clipboard
function copyText(text, label) {
    navigator.clipboard.writeText(text).then(() => {
        showToast(`✅ ${label} disalin!`);
    }).catch(() => {
        // Fallback
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast(`✅ ${label} disalin!`);
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

// Form handling
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const phoneInput = document.getElementById('phoneInput');
    const messageInput = document.querySelector('textarea[name="message"]');
    const charCount = document.getElementById('charCount');

    // Character counter for textarea
    if (messageInput && charCount) {
        messageInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Auto-format phone number
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0') && value.length > 1) {
                value = '62' + value.slice(1);
            }
            e.target.value = value.slice(0, 13);
        });
    }

    // Form submission
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Mengirim...';

            // Simulate form submission (replace with actual AJAX)
            setTimeout(() => {
                showToast('✅ Pesan berhasil dikirim! Kami akan segera membalas.');
                contactForm.reset();
                if (charCount) charCount.textContent = '0';

                // Restore button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 1500);
        });
    }

    // Add click-to-copy for phone numbers
    document.querySelectorAll('.info-box.phone a[href^="tel:"]').forEach(link => {
        link.addEventListener('click', function(e) {
            // Allow default tel: behavior, but also copy to clipboard
            const phone = this.textContent.trim();
            copyText(phone.replace(/[^\d+]/g, ''), 'Nomor telepon');
        });
    });
});
</script>
@endpush
