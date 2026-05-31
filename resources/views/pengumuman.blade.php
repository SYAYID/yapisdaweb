@extends('layouts.app')

@section('title', 'Pengumuman Kelulusan - YAPISDA')

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

/* === HERO SECTION === */
.announcement-hero {
    position: relative;
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    color: white;
    padding: clamp(2.5rem, 6vw, 4rem) 1rem;
    text-align: center;
    overflow: hidden;
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    margin-bottom: 2.5rem;
}

.announcement-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

.announcement-hero::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
    pointer-events: none;
    animation: pulse 12s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 0.3; transform: scale(1.1); }
}

.announcement-hero .container {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.announcement-hero h1 {
    font-family: var(--ff-display);
    font-weight: 700;
    font-size: clamp(1.5rem, 3vw, 2rem);
    margin: 0 0 0.75rem;
    animation: fadeInUp 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
}

.announcement-hero h1 i {
    color: var(--gold-light);
}

.announcement-hero p {
    margin: 0 0 1rem;
    opacity: 0.9;
    font-size: 1rem;
    animation: fadeInUp 0.5s ease 0.1s both;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(201,168,76,0.2);
    color: var(--gold-light);
    padding: 0.5rem 1.25rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.9rem;
    border: 1px solid rgba(201,168,76,0.3);
    animation: fadeInUp 0.5s ease 0.2s both;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

/* === SEARCH SECTION === */
.search-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: clamp(1.5rem, 4vw, 2rem);
    margin: 0 0 2rem;
    box-shadow: var(--shadow-md);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.search-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
}

.search-section h3 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.2rem;
    color: var(--forest);
    margin: 0 0 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.search-section h3 i {
    color: var(--gold-dark);
}

.search-box {
    max-width: 600px;
    margin: 0 auto;
}

.search-box .input-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.search-box .form-control {
    flex: 1;
    min-width: 200px;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    font-size: 0.95rem;
    font-family: var(--ff-body);
    background: white;
    color: var(--text-dark);
    transition: var(--transition);
}

.search-box .form-control:focus {
    outline: none;
    border-color: var(--gold-dark);
    box-shadow: 0 0 0 4px rgba(160, 120, 48, 0.12);
    background: #fffef9;
}

.search-box .form-control::placeholder {
    color: var(--text-muted);
}

.search-box .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-family: var(--ff-body);
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    border: none;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(46, 107, 79, 0.25);
}

.search-box .btn:hover {
    background: linear-gradient(135deg, var(--moss), var(--forest-mid));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(46, 107, 79, 0.35);
}

.search-box small {
    display: block;
    margin-top: 0.75rem;
    color: var(--text-muted);
    font-size: 0.85rem;
}

/* === INFO CARDS === */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1.5rem 0;
}

.info-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--moss), var(--gold));
    opacity: 0;
    transition: var(--transition);
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--gold);
}

.info-card:hover::before {
    opacity: 1;
}

.info-card i {
    font-size: 1.75rem;
    color: var(--moss);
    margin-bottom: 0.6rem;
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--primary-50, #e8f5ef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.6rem;
}

.info-card h4 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    color: var(--forest);
    margin: 0 0 0.35rem;
}

.info-card p {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin: 0;
    font-weight: 500;
}

/* === STUDENTS CARD === */
.students-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin: 1.5rem 0;
}

.students-card .card-header {
    background: linear-gradient(135deg, var(--forest), var(--forest-soft));
    color: white;
    padding: 1rem 1.5rem;
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
}

.students-card .card-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 1.5rem;
    width: 40px;
    height: 2px;
    background: var(--gold);
    border-radius: 999px;
}

.students-card .card-header i {
    color: var(--gold-light);
}

.students-card .card-body {
    padding: 1.5rem;
}

/* === ALERT BOXES === */
.alert-custom {
    padding: 1rem 1.25rem;
    border-radius: var(--radius);
    margin: 1rem 0;
    border-left: 4px solid;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.9rem;
}

.alert-custom i {
    font-size: 1.1rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.alert-info-custom {
    background: var(--info-bg, #eff6ff);
    color: var(--info-text, #1e40af);
    border-color: var(--info, #3b82f6);
}

.alert-warning-custom {
    background: var(--warning-bg);
    color: var(--warning-text);
    border-color: var(--warning);
}

.alert-custom strong {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-custom ul {
    margin: 0.4rem 0 0 1.25rem;
    padding: 0;
}

.alert-custom li {
    margin-bottom: 0.2rem;
}

/* === TABLE STYLES === */
.table-responsive {
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border);
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
}

.table-custom thead {
    background: var(--forest);
}

.table-custom th {
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    padding: 0.9rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid rgba(201,168,76,0.25);
}

.table-custom td {
    padding: 0.9rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark);
    vertical-align: middle;
}

.table-custom tbody tr {
    transition: var(--transition);
    background: white;
}

.table-custom tbody tr:hover {
    background: var(--gold-pale);
}

.table-custom tbody tr:last-child td {
    border-bottom: none;
}

/* === STUDENT BADGES === */
.student-number {
    font-family: 'SF Mono', monospace;
    font-weight: 600;
    color: var(--moss);
    background: var(--primary-50, #e8f5ef);
    padding: 0.25rem 0.6rem;
    border-radius: 8px;
    font-size: 0.85rem;
    border: 1px solid rgba(46,107,79,0.15);
}

.student-name {
    font-weight: 600;
    color: var(--text-dark);
    text-transform: uppercase;
    font-size: 0.9rem;
}

.student-major {
    display: inline-flex;
    padding: 0.25rem 0.75rem;
    background: var(--gold-pale);
    color: var(--gold-dark);
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid rgba(160,120,48,0.2);
}

/* === PAGINATION === */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pagination {
    display: flex;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination .page-link {
    padding: 0.4rem 0.8rem;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    color: var(--text-mid);
    font-size: 0.875rem;
    font-weight: 600;
    font-family: var(--ff-body);
    transition: var(--transition);
    background: white;
    text-decoration: none;
}

.pagination .page-item.active .page-link {
    background: var(--forest);
    border-color: var(--forest);
    color: white;
}

.pagination .page-link:hover:not(.active) {
    background: var(--gold-pale);
    border-color: var(--gold-dark);
    color: var(--gold-dark);
}

/* === EMPTY STATE === */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    opacity: 0.3;
    color: var(--moss);
    display: block;
}

.empty-state h5 {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--text-mid);
    margin: 0 0 0.5rem;
}

.empty-state p {
    margin: 0;
    font-size: 0.95rem;
}

/* === BACK BUTTON === */
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.5rem;
    background: white;
    color: var(--text-mid);
    border-radius: 12px;
    font-weight: 600;
    font-family: var(--ff-body);
    text-decoration: none;
    transition: var(--transition);
    border: 1.5px solid var(--border);
}

.back-btn:hover {
    background: var(--gold-pale);
    border-color: var(--gold-dark);
    color: var(--gold-dark);
    transform: translateY(-2px);
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
    transition: transform 0.3s ease;
    opacity: 0;
}

.copy-toast.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

.copy-toast i {
    font-size: 1.1rem;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .search-box .input-group {
        flex-direction: column;
    }

    .search-box .btn {
        width: 100%;
        justify-content: center;
    }

    .table-custom {
        font-size: 0.85rem;
    }

    .table-custom th,
    .table-custom td {
        padding: 0.75rem 0.5rem;
    }

    .student-name {
        font-size: 0.85rem;
    }

    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .announcement-hero h1 {
        font-size: 1.3rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .students-card .card-header {
        font-size: 1rem;
        padding: 0.9rem 1.25rem;
    }
}

/* === PRINT STYLES === */
@media print {
    .search-section,
    .back-btn,
    .pagination-wrapper {
        display: none !important;
    }

    .announcement-hero {
        background: white !important;
        color: black !important;
        padding: 1rem;
    }

    .students-card {
        box-shadow: none;
        border: 1px solid #ccc;
    }

    body {
        background: white;
        font-size: 11pt;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="announcement-hero">
    <div class="container">
        <h1>
            <i class="fas fa-graduation-cap"></i>
            Pengumuman Kelulusan Verifikasi
        </h1>
        <p>SMKS YAPISDA — Tahun Ajaran 2026/2027</p>
        <div class="verified-badge">
            <i class="fas fa-check-circle"></i>
            <span>Selamat kepada Siswa yang Dinyatakan Lulus</span>
        </div>
    </div>
</section>

<div class="container" style="padding-bottom: 3rem; max-width: 1100px;">

    <!-- Search Section -->
    <div class="search-section">
        <h3><i class="fas fa-search"></i>Cek Status Pendaftaran Anda</h3>
        <div class="search-box">
            <form action="{{ route('cek.status') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="registration_number" class="form-control"
                           placeholder="No. Pendaftaran (YP-2026-XXX)"
                           value="{{ old('registration_number') }}"
                           required>
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i> Cek Status
                    </button>
                </div>
            </form>
            <small>
                <i class="fas fa-info-circle me-1"></i>
                Masukkan nomor pendaftaran dari bukti pendaftaran Anda
            </small>
        </div>
    </div>

    <!-- Info Cards Grid -->
    <div class="info-grid">
        <div class="info-card">
            <i class="fas fa-calendar-check"></i>
            <h4>Pengumuman</h4>
            <p>Februari - Juli 2026</p>
        </div>
        <div class="info-card">
            <i class="fas fa-user-graduate"></i>
            <h4>Daftar Ulang</h4>
            <p>Jadwal Menyusul</p>
        </div>
        <div class="info-card">
            <i class="fas fa-school"></i>
            <h4>Mulai Belajar</h4>
            <p>13 Juli 2026</p>
        </div>
        <div class="info-card">
            <i class="fas fa-phone-alt"></i>
            <h4>Kontak Panitia</h4>
            <p>(021) 59751260</p>
        </div>
    </div>

    <!-- Verified Students List -->
    <div class="students-card">
        <div class="card-header">
            <i class="fas fa-list-check"></i>
            <span>Daftar Siswa yang Diterima</span>
        </div>
        <div class="card-body">
            <div class="alert-custom alert-info-custom">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Catatan:</strong> Daftar siswa yang telah diverifikasi dan diterima di SMKS YAPISDA.
                    Data diurutkan berdasarkan tanggal verifikasi terbaru.
                </div>
            </div>

            @if($verifiedStudents->count() > 0)
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Jurusan</th>
                                <th width="20%">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifiedStudents as $index => $student)
                                <tr>
                                    <td class="fw-bold">
                                        @if(method_exists($verifiedStudents, 'firstItem'))
                                            {{ $verifiedStudents->firstItem() + $index }}
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="student-number" onclick="copyText('{{ $student->registration_number }}')" style="cursor: pointer;" title="Klik untuk salin">
                                            {{ $student->registration_number }}
                                        </span>
                                    </td>
                                    <td class="student-name">{{ strtoupper($student->full_name) }}</td>
                                    <td>
                                        <span class="student-major">{{ $student->major_choice }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($student->verified_at)->format('d/m/Y') }}
                                            <br>
                                            <span style="font-size: 0.75rem; opacity: 0.8;">
                                                {{ \Carbon\Carbon::parse($student->verified_at)->format('H:i') }}
                                            </span>
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($verifiedStudents) && method_exists($verifiedStudents, 'hasPages') && $verifiedStudents->hasPages())
                <div class="pagination-wrapper">
                    <nav>
                        <ul class="pagination">
                            @if($verifiedStudents->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">← Prev</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $verifiedStudents->previousPageUrl() }}">← Prev</a></li>
                            @endif

                            @foreach($verifiedStudents->getUrlRange(max(1, $verifiedStudents->currentPage()-2), min($verifiedStudents->lastPage(), $verifiedStudents->currentPage()+2)) as $page => $url)
                                @if($page == $verifiedStudents->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if($verifiedStudents->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $verifiedStudents->nextPageUrl() }}">Next →</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next →</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                <div class="alert-custom alert-warning-custom mt-4">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Penting:</strong> Jika nama Anda belum tercantum:
                        <ul>
                            <li>Segera verifikasi ke sekolah dengan membawa berkas asli/fotokopi</li>
                            <li>Pastikan data dan dokumen sudah lengkap</li>
                            <li>Hubungi panitia untuk konfirmasi lebih lanjut</li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5>Belum Ada Pengumuman</h5>
                    <p>Tanggal daftar ulang akan diumumkan setelah proses verifikasi selesai dan proses pendaftaran diselesaikan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back to Home Button -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>Kembali ke Beranda
        </a>
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
        showToast('✅ Nomor pendaftaran disalin!');
    }).catch(() => {
        // Fallback
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast('✅ Nomor pendaftaran disalin!');
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

// Enhance table row interactions
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.table-custom tbody tr');

    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Auto-focus search input if error exists
    const searchInput = document.querySelector('.search-box .form-control');
    if (searchInput && searchInput.value) {
        searchInput.focus();
        searchInput.select();
    }
});

// Keyboard shortcut: Ctrl/Cmd + F to focus search
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        const searchInput = document.querySelector('.search-box .form-control');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
});
</script>
@endpush
