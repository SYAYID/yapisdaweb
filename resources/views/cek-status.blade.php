@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran - YAPISDA')

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
    --danger:        #ef4444;
    --danger-bg:     #fef2f2;
    --danger-text:   #991b1b;

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
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

/* === CONTAINER === */
.status-wrapper {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* === CARD === */
.status-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    animation: slideUp 0.5s ease forwards;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

/* === HEADER === */
.status-header {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    padding: 1.75rem 2rem;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.status-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.status-header::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.status-header h2 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.5rem;
    margin: 0 0 0.5rem;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
}

.status-header h2 i {
    color: var(--gold-light);
    font-size: 1.3rem;
}

.status-header p {
    margin: 0;
    opacity: 0.85;
    font-size: 0.95rem;
    position: relative;
    z-index: 1;
}

/* === BODY === */
.status-body {
    padding: 2rem;
}

/* === STUDENT INFO === */
.student-info {
    text-align: center;
    padding: 1.5rem 1rem;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--ivory), white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.student-name {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: 1.4rem;
    color: var(--forest);
    margin: 0 0 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

/* === STATUS BADGE === */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.5rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.status-badge.pending {
    background: var(--warning-bg);
    color: var(--warning-text);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-badge.verified {
    background: var(--success-bg);
    color: var(--success-text);
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-badge.rejected {
    background: var(--danger-bg);
    color: var(--danger-text);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.status-badge i {
    font-size: 1rem;
}

/* === REGISTRATION NUMBER === */
.reg-number {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.9rem;
    background: var(--gold-pale);
    color: var(--gold-dark);
    border-radius: 10px;
    font-family: 'SF Mono', monospace;
    font-weight: 700;
    font-size: 0.95rem;
    border: 1px solid rgba(160, 120, 48, 0.2);
    cursor: pointer;
    transition: var(--transition);
}

.reg-number:hover {
    background: var(--gold-light);
    color: var(--forest);
    transform: translateY(-1px);
}

.reg-number.copied {
    background: var(--success-bg);
    color: var(--success-text);
}

.reg-number .copy-icon {
    font-size: 0.8rem;
    opacity: 0.7;
}

.reg-number:hover .copy-icon {
    opacity: 1;
}

.reg-number.copied .copy-icon::before {
    content: '\f00c'; /* fa-check */
}

/* === INFO LIST === */
.info-list {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    padding: 0.9rem 1.25rem;
    border-bottom: 1px solid var(--border);
    transition: var(--transition);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item:hover {
    background: var(--gold-pale);
}

.info-label {
    flex: 0 0 160px;
    font-weight: 600;
    color: var(--text-muted);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.info-label i {
    color: var(--gold-dark);
    width: 16px;
    text-align: center;
}

.info-value {
    flex: 1;
    color: var(--text-dark);
    font-weight: 500;
    font-size: 0.95rem;
}

.info-value.verified-highlight {
    color: var(--success);
    font-weight: 600;
}

/* === ALERT BOXES === */
.alert-custom {
    padding: 1.25rem 1.5rem;
    border-radius: var(--radius);
    margin: 1.5rem 0;
    border-left: 4px solid;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    animation: fadeIn 0.4s ease;
}

.alert-custom i {
    font-size: 1.2rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.alert-warning-custom {
    background: var(--warning-bg);
    color: var(--warning-text);
    border-color: var(--warning);
}

.alert-success-custom {
    background: var(--success-bg);
    color: var(--success-text);
    border-color: var(--success);
}

.alert-danger-custom {
    background: var(--danger-bg);
    color: var(--danger-text);
    border-color: var(--danger);
}

.alert-custom strong {
    display: block;
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 0.35rem;
}

.alert-custom span {
    display: block;
    line-height: 1.5;
}

.alert-custom a {
    color: inherit;
    font-weight: 600;
    text-decoration: none;
    border-bottom: 1px dashed currentColor;
}

.alert-custom a:hover {
    border-bottom-style: solid;
}

/* === ACTION BUTTONS === */
.action-buttons {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.btn-custom {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.btn-primary-custom {
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    box-shadow: 0 4px 12px rgba(46, 107, 79, 0.25);
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 107, 79, 0.35);
}

.btn-outline-custom {
    background: white;
    color: var(--text-mid);
    border: 1.5px solid var(--border);
}

.btn-outline-custom:hover {
    background: var(--gold-pale);
    border-color: var(--gold-dark);
    color: var(--gold-dark);
    transform: translateY(-1px);
}

.btn-whatsapp {
    background: #25D366;
    color: white;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp:hover {
    background: #128C7E;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
}

/* === EMPTY STATE === */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    opacity: 0.3;
    color: var(--moss);
    display: block;
}

.empty-state h4 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.2rem;
    color: var(--text-mid);
    margin: 0 0 0.5rem;
}

.empty-state p {
    margin: 0 0 1.5rem;
    font-size: 0.95rem;
}

/* === PRINT BUTTON === */
.print-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    z-index: 2;
}

.print-btn:hover {
    background: var(--gold);
    color: var(--forest);
    transform: scale(1.05);
}

/* === TOAST NOTIFICATION === */
.toast {
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
    transition: transform 0.3s ease;
}

.toast.show {
    transform: translateX(-50%) translateY(0);
}

.toast i {
    font-size: 1.1rem;
}

.toast.success {
    background: var(--success);
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .status-wrapper {
        padding: 0 1rem;
        margin: 1rem auto;
    }

    .status-header {
        padding: 1.5rem;
    }

    .status-header h2 {
        font-size: 1.3rem;
    }

    .status-body {
        padding: 1.5rem;
    }

    .info-item {
        flex-direction: column;
        gap: 0.35rem;
        padding: 0.9rem 1rem;
    }

    .info-label {
        flex: none;
        font-size: 0.8rem;
    }

    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-custom {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .status-header h2 {
        font-size: 1.2rem;
    }

    .student-name {
        font-size: 1.2rem;
    }

    .status-badge {
        font-size: 0.85rem;
        padding: 0.5rem 1.25rem;
    }
}

/* === PRINT STYLES === */
@media print {
    .status-wrapper {
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .status-card {
        box-shadow: none;
        border: 1px solid #ccc;
        border-radius: 0;
    }

    .status-header {
        background: white !important;
        color: black !important;
        border-bottom: 2px solid #000;
    }

    .status-header::before,
    .status-header::after,
    .print-btn,
    .action-buttons {
        display: none !important;
    }

    .info-item:hover {
        background: transparent !important;
    }

    body {
        background: white;
        font-size: 12pt;
    }
}
</style>
@endpush

@section('content')
<div class="status-wrapper">

    <div class="status-card">
        <!-- Header -->
        <div class="status-header">
            <button class="print-btn" onclick="window.print()" title="Cetak Status" aria-label="Cetak">
                <i class="fas fa-print"></i>
            </button>
            <h2>
                <i class="fas fa-user-check"></i>
                Status Pendaftaran
            </h2>
            <p>Yayasan Pendidikan Islam Daar El Rohmah</p>
        </div>

        <!-- Body -->
        <div class="status-body">

            @if(session('error'))
                <div class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Error!</strong>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(isset($applicant))
                <!-- Student Info -->
                <div class="student-info">
                    <h3 class="student-name">{{ strtoupper($applicant->full_name) }}</h3>

                    <div class="status-badge status-{{ $applicant->status }}">
                        @if($applicant->status == 'pending')
                            <i class="fas fa-clock"></i>
                            <span>Menunggu Verifikasi</span>
                        @elseif($applicant->status == 'verified')
                            <i class="fas fa-check-circle"></i>
                            <span>Diterima / Lulus</span>
                        @else
                            <i class="fas fa-times-circle"></i>
                            <span>Ditolak</span>
                        @endif
                    </div>

                    <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                        No. Pendaftaran:
                        <span class="reg-number" id="regNumber" onclick="copyRegNumber()" title="Klik untuk salin">
                            {{ $applicant->registration_number }}
                            <i class="fas fa-copy copy-icon"></i>
                        </span>
                    </p>
                </div>

                <!-- Info List -->
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-birthday-cake"></i> Tempat, Tgl Lahir</div>
                        <div class="info-value">{{ $applicant->birth_place }}, {{ \Carbon\Carbon::parse($applicant->birth_date)->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</div>
                        <div class="info-value">{{ $applicant->gender }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-graduation-cap"></i> Jurusan Pilihan</div>
                        <div class="info-value">{{ $applicant->major_choice }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-school"></i> Asal Sekolah</div>
                        <div class="info-value">{{ $applicant->previous_school }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar-plus"></i> Tanggal Daftar</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($applicant->created_at)->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($applicant->status == 'verified' && $applicant->verified_at)
                        <div class="info-item" style="background: var(--success-bg);">
                            <div class="info-label"><i class="fas fa-check-double"></i> Tanggal Verifikasi</div>
                            <div class="info-value verified-highlight">
                                {{ \Carbon\Carbon::parse($applicant->verified_at)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Status Messages -->
                @if($applicant->status == 'pending')
                    <div class="alert-custom alert-warning-custom">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Status: Menunggu Verifikasi</strong>
                            <span>
                                Proses verifikasi membutuhkan waktu <strong>1-3 hari kerja</strong>.
                                Harap bersabar dan pastikan berkas yang diupload sudah lengkap dan jelas.
                                <br><br>
                                <small>💡 Tips: Cek email dan WhatsApp secara berkala untuk update status.</small>
                            </span>
                        </div>
                    </div>

                @elseif($applicant->status == 'verified')
                    <div class="alert-custom alert-success-custom">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>🎉 Selamat! Anda DINYATAKAN LULUS</strong>
                            <span>
                                Anda diterima di program <strong>{{ $applicant->major_choice }}</strong>.
                                <br><br>
                                <strong>Langkah Selanjutnya:</strong>
                                <ol style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                                    <li>Cetak bukti pendaftaran ini (klik ikon 🖨️)</li>
                                    <li>Tunggu informasi jadwal daftar ulang via WA Group</li>
                                </ol>
                            </span>
                        </div>
                    </div>

                @else
                    <div class="alert-custom alert-danger-custom">
                        <i class="fas fa-times-circle"></i>
                        <div>
                            <strong>Mohon Maaf, Pendaftaran Ditolak</strong>
                            <span>
                                Terdapat ketidaksesuaian data atau berkas tidak lengkap.
                                <br><br>
                                <strong>Hubungi Panitia untuk Klarifikasi:</strong>
                                <br>📞 <a href="tel:02159751260">(021) 59751260</a>
                                <br>📱 <a href="https://wa.me/628128906113" target="_blank">WhatsApp Admin</a>
                                <br>🏫 Jl. Raya Serang KM 3, Curug, Tangerang
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('pengumuman') }}" class="btn-custom btn-primary-custom">
                        <i class="fas fa-list-check"></i>Lihat Daftar Kelulusan
                    </a>
                    <a href="{{ route('home') }}" class="btn-custom btn-outline-custom">
                        <i class="fas fa-home"></i>Beranda
                    </a>
                    @if($applicant->status == 'pending')
                        <a href="https://wa.me/628128906113?text=Halo,%20saya%20{{ urlencode($applicant->full_name) }}%20(no.%20{{ $applicant->registration_number }})%20ingin%20konfirmasi%20status%20pendaftaran."
                           class="btn-custom btn-whatsapp"
                           target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i>Hubungi Panitia
                        </a>
                    @endif
                </div>

            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h4>Data Tidak Ditemukan</h4>
                    <p>Nomor pendaftaran yang Anda masukkan tidak terdaftar dalam sistem.</p>
                    <a href="{{ route('home') }}" class="btn-custom btn-primary-custom">
                        <i class="fas fa-arrow-left"></i>Kembali ke Beranda
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Tersalin!</span>
</div>
@endsection

@push('scripts')
<script>
// Copy Registration Number to Clipboard
function copyRegNumber() {
    const regNumber = document.getElementById('regNumber');
    const numberText = regNumber.childNodes[0].textContent.trim();

    navigator.clipboard.writeText(numberText).then(() => {
        // Show visual feedback
        regNumber.classList.add('copied');
        showToast('✅ Nomor pendaftaran disalin!', 'success');

        // Reset after 2 seconds
        setTimeout(() => {
            regNumber.classList.remove('copied');
        }, 2000);
    }).catch(err => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = numberText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        regNumber.classList.add('copied');
        showToast('✅ Nomor pendaftaran disalin!', 'success');

        setTimeout(() => {
            regNumber.classList.remove('copied');
        }, 2000);
    });
}

// Show Toast Notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMessage');

    toastMsg.textContent = message;
    toast.className = `toast ${type} show`;

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Animate info items on load
document.addEventListener('DOMContentLoaded', function() {
    const infoItems = document.querySelectorAll('.info-item');

    infoItems.forEach((item, index) => {
        item.style.animation = `fadeIn 0.3s ease ${0.1 + (index * 0.05)}s both`;
    });

    // Add subtle hover effect
    const infoList = document.querySelector('.info-list');
    if (infoList) {
        infoItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    }

    // Auto-show toast if copied via URL param (optional feature)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('copied') === '1') {
        showToast('✅ Nomor pendaftaran siap digunakan!', 'success');
        // Clean URL
        history.replaceState(null, null, window.location.pathname);
    }
});

// Keyboard shortcut: Ctrl+P or Cmd+P to print
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        window.print();
    }
});
</script>
@endpush
