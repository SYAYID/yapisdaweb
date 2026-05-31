@extends('layouts.admin')

@section('title', 'Detail Berkas - ' . $applicant->registration_number)

@push('styles')
<style>
/* === DESIGN TOKENS — selaras dengan layouts.app === */
:root {
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
    --text-dark:     #1A1208;
    --text-mid:      #4A3F28;
    --text-muted:    #8A7A58;

    --success:       #10b981;
    --success-bg:    #ecfdf5;
    --success-text:  #065f46;
    --warning:       #f59e0b;
    --warning-bg:    #fffbeb;
    --warning-text:  #92400e;
    --danger:        #ef4444;
    --danger-bg:     #fef2f2;
    --danger-text:   #991b1b;
    --info:          #0ea5e9;
    --info-bg:       #f0f9ff;
    --info-text:     #075985;

    --border:        var(--ivory-dark);
    --shadow-sm:     0 2px 8px rgba(0,0,0,0.07);
    --shadow-md:     0 6px 20px rgba(0,0,0,0.10);
    --shadow-lg:     0 12px 36px rgba(0,0,0,0.14);
    --shadow-gold:   0 8px 30px rgba(201,168,76,0.22);

    --radius:        12px;
    --radius-lg:     20px;
    --radius-xl:     28px;

    --ff-display: 'Playfair Display', Georgia, serif;
    --ff-body:    'DM Sans', 'Segoe UI', sans-serif;

    --transition:        all 0.2s ease-in-out;
    --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

/* === LAYOUT === */
.detail-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 2.5rem;
    font-family: var(--ff-body);
}

/* === HEADER CARD === */
.header-card {
    background: linear-gradient(135deg, var(--forest) 0%, var(--forest-soft) 100%);
    border-radius: var(--radius-lg);
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(201,168,76,0.15);
    box-shadow: var(--shadow-lg);
}

/* Gold top accent */
.header-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent 5%, var(--gold-dark) 30%, var(--gold-light) 50%, var(--gold-dark) 70%, transparent 95%);
}

/* Radial glow */
.header-card::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px; border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.header-card .reg-number {
    font-family: 'SF Mono', 'JetBrains Mono', monospace;
    background: rgba(201,168,76,0.2);
    border: 1px solid rgba(201,168,76,0.3);
    color: var(--gold-light);
    padding: 0.3rem 0.85rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.85rem;
    display: inline-block;
    position: relative;
    z-index: 1;
}

.header-card .student-name {
    font-family: var(--ff-display);
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0.5rem 0 0.35rem;
    position: relative;
    z-index: 1;
}

.header-card .meta-info {
    font-size: 0.875rem;
    opacity: 0.8;
    position: relative;
    z-index: 1;
}

.header-actions {
    display: flex;
    gap: 0.6rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.btn-header {
    padding: 0.55rem 1.1rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    font-family: var(--ff-body);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn-header.btn-outline {
    background: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.85);
    border: 1px solid rgba(255,255,255,0.2);
}

.btn-header.btn-outline:hover {
    background: rgba(255,255,255,0.18);
    color: white;
}

.btn-header.btn-gold {
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest);
    box-shadow: var(--shadow-gold);
}

.btn-header.btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(201,168,76,0.4);
    color: var(--forest);
}

/* === TABS NAV === */
.tabs-nav {
    display: flex;
    gap: 0.25rem;
    background: white;
    padding: 0.5rem;
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
    overflow-x: auto;
    flex-wrap: wrap;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
}

.tab-btn {
    padding: 0.6rem 1.25rem;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-weight: 500;
    font-size: 0.9rem;
    font-family: var(--ff-body);
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
}

.tab-btn:hover {
    background: var(--ivory);
    color: var(--moss);
}

.tab-btn.active {
    background: var(--forest);
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13,33,24,0.25);
}

.tab-btn.active i { color: var(--gold-light); }

.tab-content {
    display: none;
    animation: fadeInUp 0.3s ease;
}

.tab-content.active { display: block; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* === INFO CARDS === */
.info-card {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    margin-bottom: 1.25rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition-smooth);
}

.info-card:hover { box-shadow: var(--shadow-md); }

.info-card-header {
    padding: 0.95rem 1.5rem;
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 1px solid var(--border);
    position: relative;
}

/* Gold underline accent */
.info-card-header::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 1.5rem;
    width: 32px; height: 2px;
    background: var(--gold);
    border-radius: 999px;
}

.info-card-header.bg-student {
    background: linear-gradient(to bottom, var(--ivory), white);
    color: var(--forest);
}
.info-card-header.bg-student i { color: var(--moss); }

.info-card-header.bg-address {
    background: linear-gradient(to bottom, #e8f5ef, white);
    color: var(--forest);
}
.info-card-header.bg-address i { color: var(--moss); }

.info-card-header.bg-parents {
    background: linear-gradient(to bottom, var(--gold-pale), white);
    color: var(--forest);
}
.info-card-header.bg-parents i { color: var(--gold-dark); }

.info-card-header.bg-docs {
    background: linear-gradient(to bottom, #ede9fe, white);
    color: var(--forest);
}
.info-card-header.bg-docs i { color: #6d28d9; }

.info-card-body { padding: 1.25rem 1.5rem; }

/* === DATA GRID === */
.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.9rem 1.5rem;
}

.data-item { display: flex; flex-direction: column; gap: 0.25rem; }

.data-label {
    font-size: 0.72rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 700;
}

.data-value {
    font-size: 0.95rem;
    color: var(--text-dark);
    font-weight: 500;
    word-break: break-word;
}

.data-item.full-width { grid-column: 1 / -1; }

/* === ADDRESS BOX === */
.address-box {
    background: var(--ivory);
    padding: 0.875rem 1rem;
    border-radius: 10px;
    border-left: 3px solid var(--moss);
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--text-mid);
}

.address-box strong { color: var(--forest); }

.address-box.same-as-ktp {
    border-left-color: var(--gold-dark);
    background: var(--gold-pale);
}

.address-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest);
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

/* === STATUS BADGES === */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.9rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.status-pending  { background: var(--warning-bg); color: var(--warning-text); }
.status-verified { background: var(--success-bg); color: var(--success-text); }
.status-rejected { background: var(--danger-bg);  color: var(--danger-text);  }

/* === DOCUMENTS GRID === */
.docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
    gap: 0.85rem;
}

.doc-card {
    background: white;
    border: 2px solid var(--border);
    border-radius: var(--radius);
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition-smooth);
    position: relative;
}

.doc-card:hover {
    border-color: var(--moss);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(46,107,79,0.12);
}

.doc-card.missing {
    border-style: dashed;
    border-color: var(--border);
    opacity: 0.6;
    cursor: not-allowed;
}

.doc-card.missing:hover {
    transform: none;
    border-color: var(--border);
    box-shadow: none;
}

.doc-icon-wrapper {
    width: 50px;
    height: 50px;
    margin: 0 auto 0.6rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.doc-icon-wrapper.image   { background: var(--success-bg); color: var(--moss);   }
.doc-icon-wrapper.pdf     { background: var(--danger-bg);  color: var(--danger); }
.doc-icon-wrapper.missing { background: var(--ivory);      color: var(--text-muted); }

.doc-name {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.2rem;
    line-height: 1.3;
}

.doc-type {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.doc-required {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: var(--danger);
    color: white;
    font-size: 0.62rem;
    padding: 0.15rem 0.45rem;
    border-radius: 999px;
    font-weight: 700;
}

.doc-actions {
    display: flex;
    justify-content: center;
    gap: 0.35rem;
    margin-top: 0.5rem;
}

.doc-actions button,
.doc-actions a {
    padding: 0.3rem 0.6rem;
    font-size: 0.72rem;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-family: var(--ff-body);
    font-weight: 600;
    text-decoration: none;
}

.doc-actions .btn-view {
    background: linear-gradient(135deg, var(--moss-light), var(--moss));
    color: white;
}

.doc-actions .btn-download {
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest);
}

.doc-actions button:hover,
.doc-actions a:hover { transform: scale(1.06); filter: brightness(1.08); }

/* === ACTION PANEL === */
.action-panel {
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    padding: 1.25rem;
    position: sticky;
    top: 1rem;
    box-shadow: var(--shadow-sm);
}

.action-title {
    font-family: var(--ff-display);
    font-weight: 600;
    font-size: 1rem;
    color: var(--forest);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.action-title i { color: var(--gold-dark); }

.action-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.6rem;
}

.action-btn {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    font-family: var(--ff-body);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    text-align: center;
}

.action-btn.btn-edit {
    background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
    color: var(--forest);
}

.action-btn.btn-delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.action-btn.btn-verify {
    background: linear-gradient(135deg, var(--moss-light), var(--forest-soft));
    color: white;
    box-shadow: 0 4px 12px rgba(46,107,79,0.25);
}

.action-btn.btn-reject {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.action-btn.btn-print {
    background: linear-gradient(135deg, var(--forest-soft), var(--forest));
    color: white;
    box-shadow: 0 4px 12px rgba(13,33,24,0.2);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    filter: brightness(1.06);
}

.action-btn.full-width { grid-column: 1 / -1; }

.status-change-card {
    grid-column: 1 / -1;
    display: grid;
    gap: 0.55rem;
    padding: 0.8rem;
    border: 1px solid rgba(46,107,79,0.18);
    border-radius: 12px;
    background: rgba(250,247,240,0.75);
}

.status-change-card label {
    margin: 0;
    color: var(--forest);
    font-size: 0.78rem;
    font-weight: 700;
}

.status-change-card select,
.status-change-card textarea {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: white;
    color: var(--text-dark);
    font: inherit;
    font-size: 0.85rem;
    padding: 0.65rem 0.75rem;
    outline: none;
}

.status-change-card textarea {
    min-height: 76px;
    resize: vertical;
}

.status-change-card select:focus,
.status-change-card textarea:focus {
    border-color: var(--moss);
    box-shadow: 0 0 0 3px rgba(46,107,79,0.14);
}

/* === PARENT CARD === */
.parent-card {
    background: var(--ivory);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1rem 1.1rem;
    margin-bottom: 0.85rem;
    transition: var(--transition);
}

.parent-card:last-child { margin-bottom: 0; }

.parent-card:hover {
    border-color: rgba(46,107,79,0.2);
    box-shadow: var(--shadow-sm);
}

.parent-title {
    font-family: var(--ff-display);
    font-weight: 600;
    color: var(--forest);
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.95rem;
}

.parent-info {
    font-size: 0.875rem;
    color: var(--text-muted);
    line-height: 1.75;
}

.parent-info strong { color: var(--text-dark); }

/* === ALERT OVERRIDE === */
.alert-warning {
    background: var(--warning-bg);
    color: var(--warning-text);
    border: none;
    border-left: 4px solid var(--warning);
    border-radius: 10px;
    font-size: 0.875rem;
    padding: 0.85rem 1rem;
}

/* === EMPTY STATE === */
.empty-docs {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-muted);
}

.empty-docs i {
    display: block;
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.25;
    color: var(--moss);
}

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .detail-container { padding: 1.25rem 1.5rem; }
    .action-panel { position: static; }
    .action-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
    .detail-container { padding: 1rem; }
    .header-card { padding: 1.25rem; }
    .header-card .student-name { font-size: 1.2rem; }
    .data-grid { grid-template-columns: 1fr; }
    .docs-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    .action-grid { grid-template-columns: repeat(2, 1fr); }
    .tabs-nav { padding: 0.375rem; }
    .tab-btn { padding: 0.5rem 0.875rem; font-size: 0.85rem; }
    .info-card-body { padding: 1rem; }
}

@media (max-width: 480px) {
    .header-actions { width: 100%; justify-content: center; margin-top: 0.75rem; }
    .action-grid { grid-template-columns: 1fr; }
    .docs-grid { grid-template-columns: repeat(2, 1fr); }
}
.compact-timeline-item {
    border-bottom: 1px solid var(--border);
}
.compact-timeline-item:last-child {
    border-bottom: none;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
.timeline-icon {
    font-size: 0.95rem;
    color: var(--gold-dark);
    margin-top: 2px;
}
</style>
@endpush

@section('admin_content')
<div class="detail-container">

    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <span class="reg-number">
                    <i class="fas fa-hashtag me-1"></i>{{ $applicant->registration_number }}
                </span>
                <h2 class="student-name">{{ $applicant->full_name }}</h2>
                <div class="meta-info">
                    <i class="fas fa-school me-1"></i>{{ $applicant->previous_school }}
                    <span class="mx-2">•</span>
                    <i class="fas fa-industry me-1"></i>{{ $applicant->major_choice }}
                    <span class="mx-2">•</span>
                    <i class="fas fa-calendar me-1"></i>{{ $applicant->registered_at_label }}
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-header btn-outline">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <a href="{{ route('admin.print', $applicant->id) }}" class="btn-header btn-gold" target="_blank">
                    <i class="fas fa-print"></i>Cetak
                </a>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <button class="tab-btn active" data-tab="student">
            <i class="fas fa-user"></i>Data Siswa
        </button>
        <button class="tab-btn" data-tab="address">
            <i class="fas fa-map-marker-alt"></i>Alamat
        </button>
        <button class="tab-btn" data-tab="parents">
            <i class="fas fa-user-friends"></i>Orang Tua
        </button>
        <button class="tab-btn" data-tab="documents">
            <i class="fas fa-folder-open"></i>Dokumen
            @if(collect($documents)->filter(fn($d) => !$d['path'] && $d['required'])->count())
                <span class="badge bg-danger ms-1" style="font-size:0.65rem;border-radius:999px;">
                    {{ collect($documents)->filter(fn($d) => !$d['path'] && $d['required'])->count() }}
                </span>
            @endif
        </button>
        <button class="tab-btn" data-tab="actions">
            <i class="fas fa-cog"></i>Aksi
        </button>
        <button class="tab-btn" data-tab="activity">
            <i class="fas fa-clipboard-list"></i>Catatan
            @if(($activities ?? collect())->where('is_pinned', true)->count())
                <span class="badge bg-warning text-dark ms-1" style="font-size:0.65rem;border-radius:999px;">
                    {{ ($activities ?? collect())->where('is_pinned', true)->count() }}
                </span>
            @endif
        </button>
    </div>

    <!-- Tab: Data Siswa -->
    <div id="tab-student" class="tab-content active">
        <div class="info-card">
            <div class="info-card-header bg-student">
                <i class="fas fa-user-graduate"></i>Informasi Pribadi
            </div>
            <div class="info-card-body">
                <div class="data-grid">
                    <div class="data-item">
                        <span class="data-label">NIK</span>
                        <span class="data-value">{{ $applicant->nik }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">NISN</span>
                        <span class="data-value">{{ $applicant->nisn ?? '-' }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Tempat, Tgl Lahir</span>
                        <span class="data-value">{{ $applicant->birth_place }}, {{ $formattedDates['birth_date'] }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Jenis Kelamin</span>
                        <span class="data-value">{{ $applicant->gender }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Agama</span>
                        <span class="data-value">{{ $applicant->religion }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Kewarganegaraan</span>
                        <span class="data-value">{{ $applicant->citizenship }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">No. HP / WhatsApp</span>
                        <span class="data-value">{{ $applicant->phone }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Email</span>
                        <span class="data-value">{{ $applicant->email }}</span>
                    </div>
                    <div class="data-item full-width">
                        <span class="data-label">No. Akta Kelahiran</span>
                        <span class="data-value">{{ $applicant->birth_certificate_number }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Tinggi Badan</span>
                        <span class="data-value">{{ $applicant->height }} cm</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Berat Badan</span>
                        <span class="data-value">{{ $applicant->weight }} kg</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Lingkar Kepala</span>
                        <span class="data-value">{{ $applicant->head_circumference ?? '-' }} cm</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Jumlah Saudara</span>
                        <span class="data-value">{{ $applicant->siblings_count }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Anak Ke-</span>
                        <span class="data-value">{{ $applicant->child_order }}</span>
                    </div>
                    <div class="data-item full-width">
                        <span class="data-label">Berkebutuhan Khusus</span>
                        <span class="data-value">{{ $applicant->disability }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Alamat -->
    <div id="tab-address" class="tab-content">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header bg-address">
                        <i class="fas fa-id-card"></i>Alamat KTP Orang Tua
                    </div>
                    <div class="info-card-body">
                        <div class="address-box">
                            <strong>{{ $applicant->parent_ktp_village }}</strong><br>
                            RT {{ $applicant->parent_ktp_rt }} / RW {{ $applicant->parent_ktp_rw }}<br>
                            {{ $applicant->parent_ktp_subdistrict }}, {{ $applicant->parent_ktp_district }}<br>
                            {{ $applicant->parent_ktp_city }}, {{ $applicant->parent_ktp_province }}
                        </div>
                        <div class="mt-3 data-grid">
                            <div class="data-item">
                                <span class="data-label">Status Tempat Tinggal</span>
                                <span class="data-value">{{ $applicant->parent_ktp_residence_status }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Jarak ke Sekolah</span>
                                <span class="data-value">{{ $applicant->parent_ktp_distance_to_school }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Transportasi</span>
                                <span class="data-value">{{ $applicant->parent_ktp_transportation }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header bg-address">
                        <i class="fas fa-home"></i>Alamat Domisili Siswa
                    </div>
                    <div class="info-card-body">
                        @if($applicant->same_as_ktp)
                            <div class="address-box same-as-ktp">
                                <span class="address-badge">
                                    <i class="fas fa-check-circle"></i>Sama dengan KTP
                                </span>
                                <div style="opacity:0.75;font-size:0.875rem;">
                                    Alamat domisili siswa sama dengan alamat KTP orang tua.
                                </div>
                            </div>
                        @else
                            <div class="address-box">
                                <strong>{{ $applicant->current_village }}</strong><br>
                                RT {{ $applicant->current_rt }} / RW {{ $applicant->current_rw }}<br>
                                {{ $applicant->current_subdistrict }}, {{ $applicant->current_district }}<br>
                                {{ $applicant->current_city }}, {{ $applicant->current_province }}
                            </div>
                            <div class="mt-3 data-grid">
                                <div class="data-item">
                                    <span class="data-label">Status Tempat Tinggal</span>
                                    <span class="data-value">{{ $applicant->current_residence_status }}</span>
                                </div>
                                <div class="data-item">
                                    <span class="data-label">Jarak ke Sekolah</span>
                                    <span class="data-value">{{ $applicant->current_distance_to_school }}</span>
                                </div>
                                <div class="data-item">
                                    <span class="data-label">Transportasi</span>
                                    <span class="data-value">{{ $applicant->current_transportation }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Orang Tua -->
    <div id="tab-parents" class="tab-content">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="parent-card">
                    <div class="parent-title">
                        <i class="fas fa-male" style="color:var(--moss)"></i>Data Ayah
                    </div>
                    <div class="parent-info">
                        <strong>{{ $applicant->father_name }}</strong><br>
                        NIK: {{ $applicant->father_nik }}<br>
                        TTL: {{ $applicant->father_birth_place }}, {{ $formattedDates['father_birth_date'] }}<br>
                        Pendidikan: {{ $applicant->father_education }}<br>
                        Pekerjaan: {{ $applicant->father_occupation }}<br>
                        Penghasilan: {{ $applicant->father_income }}<br>
                        No. HP: {{ $applicant->father_phone }}<br>
                        Berkebutuhan Khusus: {{ $applicant->father_disability }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="parent-card">
                    <div class="parent-title">
                        <i class="fas fa-female" style="color:var(--gold-dark)"></i>Data Ibu
                    </div>
                    <div class="parent-info">
                        <strong>{{ $applicant->mother_name }}</strong><br>
                        NIK: {{ $applicant->mother_nik }}<br>
                        TTL: {{ $applicant->mother_birth_place }}, {{ $formattedDates['mother_birth_date'] }}<br>
                        Pendidikan: {{ $applicant->mother_education }}<br>
                        Pekerjaan: {{ $applicant->mother_occupation }}<br>
                        Penghasilan: {{ $applicant->mother_income }}<br>
                        No. HP: {{ $applicant->mother_phone }}<br>
                        Berkebutuhan Khusus: {{ $applicant->mother_disability }}
                    </div>
                </div>
            </div>
        </div>

        @if($applicant->has_guardian)
        <div class="row mt-2">
            <div class="col-12">
                <div class="parent-card" style="border-left: 3px solid var(--info);">
                    <div class="parent-title">
                        <i class="fas fa-user-shield" style="color:var(--info)"></i>Data Wali
                    </div>
                    <div class="parent-info">
                        <strong>{{ $applicant->guardian_name ?? '-' }}</strong><br>
                        NIK: {{ $applicant->guardian_nik ?? '-' }}<br>
                        TTL: {{ $applicant->guardian_birth_place ?? '-' }}, {{ $formattedDates['guardian_birth_date'] }}<br>
                        Pendidikan: {{ $applicant->guardian_education ?? '-' }}<br>
                        Pekerjaan: {{ $applicant->guardian_occupation ?? '-' }}<br>
                        Penghasilan: {{ $applicant->guardian_income ?? '-' }}<br>
                        No. HP: {{ $applicant->guardian_phone ?? '-' }}<br>
                        Berkebutuhan Khusus: {{ $applicant->guardian_disability ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Tab: Dokumen -->
    <div id="tab-documents" class="tab-content">
        <div class="info-card">
            <div class="info-card-header bg-docs">
                <i class="fas fa-file-alt"></i>Berkas Upload
                <span class="ms-auto" style="font-weight:500;font-size:0.85rem;font-family:var(--ff-body);color:var(--text-muted);">
                    {{ collect($documents)->filter(fn($d) => $d['path'])->count() }}/{{ count($documents) }} terupload
                </span>
            </div>
            <div class="info-card-body">
                @if(collect($documents)->filter(fn($d) => $d['path'])->count())
                    <div class="docs-grid">
                        @foreach($documents as $type => $doc)
                            @php
                                $previewUrl = $doc['path'] ? route('admin.document.preview', [$type, $applicant->id]) : null;
                                $fileExt = $doc['path'] ? pathinfo($doc['path'], PATHINFO_EXTENSION) : null;
                                $isImage = $fileExt && in_array(strtolower($fileExt), ['jpg','jpeg','png','gif','webp']);
                            @endphp
                            <div class="doc-card {{ !$doc['path'] ? 'missing' : '' }}"
                                 @if($previewUrl)
                                     data-admin-preview-url="{{ $previewUrl }}"
                                     data-admin-preview-title="{{ $doc['label'] }}"
                                     data-admin-preview-kind="{{ $isImage ? 'image' : 'pdf' }}"
                                     role="button"
                                     tabindex="0"
                                 @endif>

                                @if($doc['required'])
                                    <span class="doc-required">Wajib</span>
                                @endif

                                @if($doc['path'])
                                    <div class="doc-icon-wrapper {{ $isImage ? 'image' : 'pdf' }}">
                                        <i class="fas fa-{{ $isImage ? 'image' : 'file-pdf' }}"></i>
                                    </div>
                                    <div class="doc-name">{{ $doc['label'] }}</div>
                                    <div class="doc-type">.{{ strtoupper($fileExt) }}</div>
                                    <div class="doc-actions">
                                        <button type="button" class="btn-view"
                                                data-admin-preview-url="{{ $previewUrl }}"
                                                data-admin-preview-title="{{ $doc['label'] }}"
                                                data-admin-preview-kind="{{ $isImage ? 'image' : 'pdf' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ $previewUrl }}"
                                           class="btn-download"
                                           target="_blank"
                                           rel="noopener"
                                           onclick="event.stopPropagation();">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="doc-icon-wrapper missing">
                                        <i class="fas fa-file"></i>
                                    </div>
                                    <div class="doc-name">{{ $doc['label'] }}</div>
                                    <div class="doc-type">Belum upload</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-docs">
                        <i class="fas fa-inbox"></i>
                        <p style="font-family:var(--ff-display);font-size:1rem;font-weight:600;color:var(--text-mid);margin:0;">
                            Belum ada dokumen yang diupload
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab: Aksi -->
    <div id="tab-actions" class="tab-content">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="info-card">
                    <div class="info-card-header" style="background:linear-gradient(to bottom,var(--ivory),white);color:var(--forest);">
                        <i class="fas fa-info-circle" style="color:var(--gold-dark)"></i>Status Pendaftaran
                    </div>
                    <div class="info-card-body">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div>
                                <span class="data-label">Status Saat Ini</span>
                                <div class="mt-1">
                                    @if($applicant->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                                        </span>
                                    @elseif($applicant->status == 'verified')
                                        <span class="status-badge status-verified">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($applicant->verified_at)
                            <div>
                                <span class="data-label">Terverifikasi Pada</span>
                                <div class="mt-1 data-value">
                                    {{ $applicant->verified_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($applicant->status == 'pending')
                        <div class="alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Pendaftaran ini masih menunggu verifikasi. Pastikan semua dokumen wajib sudah lengkap sebelum memverifikasi.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="action-panel">
                    <div class="action-title">
                        <i class="fas fa-bolt"></i>Aksi Cepat
                    </div>
                    <div class="action-grid">
                        <a href="{{ route('admin.edit', $applicant->id) }}" class="action-btn btn-edit">
                            <i class="fas fa-edit"></i>Edit Data
                        </a>

                        <form action="{{ route('admin.delete', $applicant->id) }}" method="POST"
                              style="display:contents;"
                              onsubmit="return confirm('Hapus pendaftaran ini?\n\n⚠️ Data akan dihapus PERMANEN!\nSiswa dapat mendaftar ulang dengan NIK yang sama.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn-delete">
                                <i class="fas fa-trash"></i>Hapus
                            </button>
                        </form>

                        <form action="{{ route('admin.status.update', $applicant->id) }}" method="POST" class="status-change-card"
                              onsubmit="return confirm('Ubah status pendaftar ini?\n\nJika status masuk atau keluar dari verified, kuota jurusan akan disesuaikan otomatis.')">
                            @csrf @method('PATCH')
                            <label for="status-update-{{ $applicant->id }}">Ubah Status Verifikasi</label>
                            <select id="status-update-{{ $applicant->id }}" name="status">
                                <option value="pending" {{ $applicant->status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ $applicant->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="rejected" {{ $applicant->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <textarea name="note" placeholder="Catatan perubahan status, misalnya perlu peninjauan ulang administrasi."></textarea>
                            <button type="submit" class="action-btn btn-verify full-width">
                                <i class="fas fa-save"></i>Simpan Status
                            </button>
                        </form>

                        <a href="{{ route('admin.print', $applicant->id) }}" class="action-btn btn-print full-width" target="_blank">
                            <i class="fas fa-print"></i>Cetak Bukti Pendaftaran
                        </a>
                    </div>
                </div>

                <div class="info-card mt-3">
                    <div class="info-card-header" style="background:linear-gradient(to bottom,var(--ivory),white);color:var(--forest);">
                        <i class="fas fa-history" style="color:var(--gold-dark)"></i>Log Aktivitas Terbaru
                    </div>
                    <div class="info-card-body p-3">
                        <div class="compact-timeline">
                            @forelse(($activities ?? collect())->take(5) as $act)
                                <div class="compact-timeline-item d-flex gap-2 mb-2 pb-2">
                                    <div class="timeline-icon text-muted">
                                        <i class="fas {{ $act->category_icon }} fa-fw"></i>
                                    </div>
                                    <div class="timeline-body flex-grow-1" style="font-size: 0.8rem;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong style="color: var(--forest);">{{ $act->title }}</strong>
                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $act->created_at?->diffForHumans() }}</small>
                                        </div>
                                        @if($act->body)
                                            <div class="text-muted mt-1" style="line-height: 1.3;">{{ $act->body }}</div>
                                        @endif
                                        <div class="text-muted mt-1" style="font-size: 0.72rem;">
                                            <i class="fas fa-user-shield me-1"></i>{{ $act->user->name ?? 'Sistem' }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-3" style="font-size: 0.8rem;">
                                    <i class="fas fa-info-circle me-1"></i>Belum ada aktivitas tercatat
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Catatan -->
    <div id="tab-activity" class="tab-content">
        @include('admin.partials.applicant-activities', [
            'activities' => $activities,
            'activityStoreRoute' => route('admin.activities.store', $applicant->id),
        ])
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabBtns     = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.tab;

            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            tabContents.forEach(c => {
                c.classList.remove('active');
                if (c.id === `tab-${target}`) c.classList.add('active');
            });
        });
    });

    // Ctrl/Cmd + Arrow key tab navigation
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey || e.metaKey) {
            const tabs  = Array.from(tabBtns);
            const idx   = tabs.indexOf(document.querySelector('.tab-btn.active'));

            if (e.key === 'ArrowRight' && idx < tabs.length - 1) {
                e.preventDefault(); tabs[idx + 1].click();
            } else if (e.key === 'ArrowLeft' && idx > 0) {
                e.preventDefault(); tabs[idx - 1].click();
            }
        }
    });
});
</script>
@endpush
