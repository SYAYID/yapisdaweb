@extends('layouts.admin')

@section('title', 'Dashboard Keuangan - YAPISDA')

@push('styles')
<style>
.finance-page {
    display: grid;
    gap: 1.2rem;
}

.finance-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.35rem 1.5rem;
    color: white;
    border-radius: 18px;
    background:
        radial-gradient(circle at 90% 15%, rgba(31, 154, 165, 0.28), transparent 16rem),
        linear-gradient(135deg, var(--brand-800), var(--brand));
    box-shadow: var(--shadow-md);
}

.finance-header h1 {
    margin: 0;
    font-size: clamp(1.35rem, 2vw, 1.8rem);
    font-weight: 900;
}

.finance-header p {
    margin: 0.35rem 0 0;
    color: rgba(255, 255, 255, 0.72);
    font-weight: 700;
}

.finance-date-form {
    display: flex;
    gap: 0.55rem;
    align-items: center;
    flex-wrap: wrap;
}

.finance-date-form input,
.finance-date-form select,
.finance-date-form button,
.finance-date-form a {
    min-height: 42px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.16);
    padding: 0.55rem 0.8rem;
    font-weight: 800;
}

.finance-date-form input,
.finance-date-form select {
    background: rgba(255, 255, 255, 0.96);
    color: var(--ink);
}

.finance-date-form button,
.finance-date-form a {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    background: var(--gold-soft);
    color: var(--brand-800);
    text-decoration: none;
}

.finance-quick-nav {
    display: flex;
    gap: 0.55rem;
    flex-wrap: wrap;
}

.finance-quick-nav a {
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 0.48rem 0.82rem;
    background: white;
    color: var(--brand);
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 900;
}

.finance-quick-nav a:hover {
    background: var(--mint);
}

.finance-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
}

.finance-card,
.finance-panel {
    background: white;
    border: 1px solid var(--line);
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
}

.finance-card {
    min-height: 128px;
    display: grid;
    align-content: space-between;
    padding: 1.15rem;
}

.finance-card span {
    color: var(--muted);
    font-size: 0.74rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.finance-card strong {
    color: var(--ink);
    font-family: var(--ff-display);
    font-size: clamp(1.45rem, 2.3vw, 2rem);
    font-weight: 900;
    line-height: 1.05;
}

.finance-card small {
    color: var(--muted);
    font-weight: 700;
}

.finance-card.income strong { color: var(--success); }
.finance-card.outcome strong { color: var(--danger); }
.finance-card.net strong { color: var(--brand); }
.finance-card.remaining strong { color: var(--warning); }

.finance-dashboard-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.15fr) minmax(340px, 0.85fr);
    gap: 1rem;
}

.finance-dashboard-panel {
    min-width: 0;
    background: white;
    border: 1px solid var(--line);
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    padding: 1.15rem;
}

.finance-dashboard-panel.wide {
    grid-column: 1 / -1;
}

.finance-dashboard-panel h2 {
    margin: 0 0 1rem;
    color: var(--ink);
    font-size: 1rem;
    font-weight: 900;
}

.finance-action-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem;
}

.finance-action-card,
.finance-mini-item {
    border: 1px solid var(--line);
    border-radius: 14px;
    background: #fbfdfc;
}

.finance-action-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem;
    color: var(--ink);
    text-decoration: none;
    transition: all 0.2s ease;
}

.finance-action-card:hover {
    border-color: rgba(15, 95, 74, 0.3);
    background: var(--mint);
    transform: translateY(-1px);
}

.finance-action-card i {
    width: 2.2rem;
    height: 2.2rem;
    display: grid;
    place-items: center;
    flex: 0 0 auto;
    border-radius: 12px;
    color: white;
    background: linear-gradient(135deg, var(--brand), var(--aqua));
}

.finance-action-card strong {
    display: block;
    font-size: 0.9rem;
}

.finance-action-card small,
.finance-mini-item span,
.finance-progress-meta {
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.finance-mini-list {
    display: grid;
    gap: 0.7rem;
}

.finance-mini-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.8rem;
    padding: 0.8rem;
}

.finance-mini-item strong {
    color: var(--ink);
    font-size: 0.9rem;
}

.finance-progress-bar {
    height: 0.7rem;
    overflow: hidden;
    border-radius: 999px;
    background: #edf3f0;
    margin: 0.75rem 0 0.6rem;
}

.finance-progress-fill {
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--brand), var(--success));
}

.finance-progress-meta {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.finance-empty-note {
    padding: 1rem;
    color: var(--muted);
    border: 1px dashed var(--line);
    border-radius: 14px;
    background: #fbfdfc;
    font-weight: 800;
}

.finance-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.15fr) minmax(360px, 0.85fr);
    gap: 1rem;
}

.finance-panel {
    overflow: hidden;
}

.finance-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.15rem;
    border-bottom: 1px solid var(--line);
    background: linear-gradient(180deg, #fbfdfc, #ffffff);
}

.finance-panel-header h2 {
    margin: 0;
    color: var(--ink);
    font-size: 1rem;
    font-weight: 900;
}

.finance-panel-header span {
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.finance-panel-body {
    padding: 1.15rem;
}

.finance-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.85rem;
}

.finance-field.full {
    grid-column: 1 / -1;
}

.finance-field label {
    display: block;
    margin-bottom: 0.35rem;
    color: var(--ink);
    font-size: 0.78rem;
    font-weight: 900;
}

.finance-field input,
.finance-field select,
.finance-field textarea {
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 0.68rem 0.78rem;
    color: var(--text);
    background: #fff;
    font-weight: 700;
}

.finance-field textarea {
    min-height: 86px;
    resize: vertical;
}

.finance-submit {
    min-height: 44px;
    border: 0;
    border-radius: 10px;
    padding: 0.7rem 1rem;
    background: linear-gradient(135deg, var(--brand), var(--aqua));
    color: white;
    font-weight: 900;
}

.finance-table-wrap {
    overflow-x: auto;
}

.finance-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.88rem;
}

.finance-table th {
    padding: 0.8rem 0.9rem;
    background: var(--brand-800);
    color: white;
    font-size: 0.72rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
}

.finance-table td {
    padding: 0.85rem 0.9rem;
    border-bottom: 1px solid var(--line);
    vertical-align: middle;
}

.finance-table tr:last-child td {
    border-bottom: 0;
}

.finance-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    border-radius: 999px;
    padding: 0.28rem 0.65rem;
    font-size: 0.75rem;
    font-weight: 900;
    white-space: nowrap;
}

.finance-pill.income {
    background: var(--mint);
    color: var(--brand);
}

.finance-pill.outcome {
    background: #fee2e2;
    color: #991b1b;
}

.finance-pill.warning {
    background: var(--gold-soft);
    color: var(--warning);
}

.finance-muted {
    color: var(--muted);
    font-size: 0.8rem;
    font-weight: 700;
}

.finance-empty {
    padding: 2rem;
    text-align: center;
    color: var(--muted);
    font-weight: 800;
}

.student-search-box {
    position: relative;
    display: grid;
    gap: 0.45rem;
}

.student-search-control {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 42px;
    gap: 0.5rem;
}

.student-search-clear {
    width: 42px;
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: #fff;
    color: var(--muted);
}

.student-search-results {
    position: absolute;
    z-index: 30;
    top: calc(100% + 0.25rem);
    left: 0;
    right: 0;
    display: none;
    max-height: 290px;
    overflow-y: auto;
    border: 1px solid var(--line);
    border-radius: 12px;
    background: #fff;
    box-shadow: var(--shadow-md);
}

.student-search-results.is-open {
    display: grid;
}

.student-search-item {
    display: grid;
    gap: 0.18rem;
    width: 100%;
    border: 0;
    border-bottom: 1px solid var(--line);
    padding: 0.75rem 0.9rem;
    background: #fff;
    text-align: left;
    color: var(--ink);
}

.student-search-item:last-child {
    border-bottom: 0;
}

.student-search-item:hover,
.student-search-item:focus {
    background: var(--mint);
    outline: none;
}

.student-search-item strong {
    font-weight: 900;
}

.student-search-item span {
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.student-search-help {
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.finance-action-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    min-height: 34px;
    border-radius: 999px;
    padding: 0.38rem 0.72rem;
    background: var(--brand);
    color: white;
    font-size: 0.76rem;
    font-weight: 900;
    text-decoration: none;
    white-space: nowrap;
}

.finance-action-link:hover {
    color: white;
    filter: brightness(0.96);
}

.finance-action-link + .finance-action-link {
    margin-left: 0.35rem;
    margin-top: 0.25rem;
}

.final-progress-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 0.75rem;
}

.final-progress-step {
    display: grid;
    gap: 0.55rem;
    min-height: 132px;
    padding: 0.9rem;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: #fbfdfc;
}

.final-progress-step strong {
    color: var(--ink);
    font-size: 1.35rem;
    font-weight: 900;
    line-height: 1;
}

.final-progress-step span {
    color: var(--muted);
    font-size: 0.74rem;
    font-weight: 900;
    line-height: 1.3;
}

.final-progress-track {
    height: 0.55rem;
    overflow: hidden;
    border-radius: 999px;
    background: #e8f0ed;
}

.final-progress-track i {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--brand), var(--aqua));
}

.finance-letter-stack {
    display: flex;
    gap: 0.35rem;
    flex-wrap: wrap;
}

.finance-letter-link {
    min-height: 32px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    border-radius: 999px;
    padding: 0.34rem 0.62rem;
    background: #f8fbfa;
    color: var(--brand);
    border: 1px solid var(--line);
    font-size: 0.72rem;
    font-weight: 900;
    text-decoration: none;
    white-space: nowrap;
}

.finance-letter-link:hover {
    color: var(--brand-800);
    background: var(--mint);
}

.uniform-profile-form {
    align-items: end;
}

.uniform-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    min-height: 28px;
    border-radius: 999px;
    padding: 0 0.65rem;
    background: var(--gold-soft);
    color: var(--warning);
    font-size: 0.74rem;
    font-weight: 900;
    white-space: nowrap;
}

.uniform-status-pill.recorded,
.uniform-status-pill.prepared,
.uniform-status-pill.distributed {
    background: var(--mint);
    color: var(--brand);
}

@media (max-width: 1180px) {
    .finance-kpi-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .finance-dashboard-grid,
    .finance-grid {
        grid-template-columns: 1fr;
    }

    .final-progress-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 620px) {
    .finance-kpi-grid,
    .finance-action-grid,
    .finance-form-grid,
    .final-progress-grid {
        grid-template-columns: 1fr;
    }
}
.finance-filter-row {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    align-items: center;
}
.finance-filter-row .filter-group {
    flex: 1;
    min-width: 180px;
}
.form-control-minimal {
    width: 100%;
    height: 42px;
    padding: 0 0.85rem;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: #ffffff;
    color: var(--ink);
    font-size: 0.88rem;
    font-weight: 700;
    transition: all 0.2s ease;
}
.form-control-minimal:focus {
    border-color: var(--brand);
    outline: none;
    box-shadow: 0 0 0 3px rgba(16, 92, 75, 0.08);
}
.btn-filter-submit {
    min-height: 42px;
    border-radius: 10px;
    background: var(--brand);
    color: #ffffff;
    border: 0;
    padding: 0 1.25rem;
    font-weight: 900;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-filter-submit:hover {
    background: var(--brand-800);
}
.btn-filter-reset {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    border-radius: 10px;
    background: #ffffff;
    color: var(--muted);
    border: 1px solid var(--line);
    padding: 0 1rem;
    font-weight: 900;
    font-size: 0.88rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-filter-reset:hover {
    background: #f1f5f9;
    color: var(--ink);
}
</style>
@endpush

@section('admin_content')
@php
    $adminSection = $adminSection ?? 'dashboard';
    $showDashboard = $adminSection === 'dashboard';
    $showPaymentForm = $adminSection === 'payment-form';
    $showUniformReport = $adminSection === 'uniform-report';
    $showDailyReport = $adminSection === 'daily-report';
    $showMutationReport = $adminSection === 'mutation-report';
    $showPaymentTypes = $adminSection === 'payment-types';
    $showFinalProgress = $adminSection === 'final-progress';
    $showUniformSizes = $adminSection === 'uniform-sizes';
    $showGuide = $adminSection === 'guide';
    $financeSectionTitle = [
        'dashboard' => 'Dashboard Keuangan',
        'payment-form' => 'Catat Transaksi',
        'uniform-report' => 'Laporan Uang Seragam',
        'daily-report' => 'Laporan Harian',
        'mutation-report' => 'Mutasi Kas',
        'payment-types' => 'Jenis Pembayaran',
        'final-progress' => 'Dashboard Progress Final',
        'uniform-sizes' => 'Manajemen Ukuran Seragam',
        'guide' => 'Panduan Alur Keuangan',
    ][$adminSection] ?? 'Dashboard Keuangan';
    $financeSectionDescription = [
        'dashboard' => 'Ringkasan pemasukan, pengeluaran, saldo, dan status daftar ulang.',
        'payment-form' => 'Input transaksi income atau outcome dengan detail siswa, waktu, dan referensi.',
        'uniform-report' => 'Pantau kewajiban uang seragam, terbayar, dan sisa tagihan siswa.',
        'daily-report' => 'Rekap income dan outcome berdasarkan tanggal transaksi.',
        'mutation-report' => 'Daftar mutasi kas lengkap dengan kwitansi dan akses cetak kartu.',
        'payment-types' => 'Kelola jenis pembayaran, nominal default, arah mutasi, dan keterangan.',
        'final-progress' => 'Pantau perjalanan calon peserta didik dari verifikasi sampai status final, NIS, kartu, dan atribut.',
        'uniform-sizes' => 'Catat ukuran seragam dan status atribut peserta didik untuk kebutuhan distribusi harian.',
        'guide' => 'Petunjuk langkah-demi-langkah penggunaan modul-modul pada panel keuangan.',
    ][$adminSection] ?? 'Laporan pemasukan, pengeluaran, mutasi kas, dan pembayaran siswa.';
    $rupiah = fn($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
    $selectedStudent = $students->firstWhere('key', old('student_key'));
    $selectedStudentLabel = $selectedStudent ? $selectedStudent['unit'] . ' - ' . $selectedStudent['label'] : '';
@endphp

<div class="finance-page">
    <header class="finance-header" id="summary">
        <div>
            <h1><i class="fas fa-wallet me-2"></i>{{ $financeSectionTitle }}</h1>
            <p>{{ $financeSectionDescription }}</p>
        </div>
        <form class="finance-date-form" action="{{ url()->current() }}" method="GET">
            <input type="date" name="date" value="{{ $summary['date']->format('Y-m-d') }}">
            <select name="direction">
                <option value="">Semua Mutasi</option>
                <option value="income" {{ request('direction') === 'income' ? 'selected' : '' }}>Income</option>
                <option value="outcome" {{ request('direction') === 'outcome' ? 'selected' : '' }}>Outcome</option>
            </select>
            <select name="student_type">
                <option value="">Semua Unit</option>
                <option value="smk" {{ request('student_type') === 'smk' ? 'selected' : '' }}>SMKS</option>
                <option value="smp" {{ request('student_type') === 'smp' ? 'selected' : '' }}>SMPS</option>
            </select>
            <button type="submit"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </header>

    <nav class="finance-quick-nav" aria-label="Akses cepat keuangan">
        <a href="{{ route('admin.finance.transactions.create') }}"><i class="fas fa-cash-register"></i>Catat Transaksi</a>
        <a href="{{ route('admin.finance.uniform-report') }}"><i class="fas fa-shirt"></i>Uang Seragam</a>
        <a href="{{ route('admin.finance.uniform-sizes') }}"><i class="fas fa-ruler-combined"></i>Ukuran Seragam</a>
        <a href="{{ route('admin.finance.final-progress') }}"><i class="fas fa-chart-line"></i>Progress Final</a>
        <a href="{{ route('admin.finance.daily-report') }}"><i class="fas fa-calendar-day"></i>Laporan Harian</a>
        <a href="{{ route('admin.finance.final-report') }}"><i class="fas fa-clipboard-check"></i>Daftar Ulang Final</a>
        <a href="{{ route('admin.finance.mutations') }}"><i class="fas fa-arrow-right-arrow-left"></i>Mutasi Kas</a>
        <a href="{{ route('admin.finance.payment-types') }}"><i class="fas fa-tags"></i>Jenis Pembayaran</a>
        <a href="{{ route('admin.finance.audit-logs') }}"><i class="fas fa-clock-rotate-left"></i>Audit Log</a>
    </nav>

    @if($showDashboard)
    <section class="finance-kpi-grid">
        <div class="finance-card income">
            <span>Income Harian</span>
            <strong>{{ $rupiah($summary['daily_income']) }}</strong>
            <small>Bulan ini {{ $rupiah($summary['monthly_income']) }}</small>
        </div>
        <div class="finance-card outcome">
            <span>Outcome Harian</span>
            <strong>{{ $rupiah($summary['daily_outcome']) }}</strong>
            <small>Bulan ini {{ $rupiah($summary['monthly_outcome']) }}</small>
        </div>
        <div class="finance-card net">
            <span>Saldo Bersih Harian</span>
            <strong>{{ $rupiah($summary['daily_net']) }}</strong>
            <small>Net bulan ini {{ $rupiah($summary['monthly_net']) }}</small>
        </div>
        <div class="finance-card remaining">
            <span>Sisa Tagihan Seragam</span>
            <strong>{{ $rupiah($summary['uniform_remaining']) }}</strong>
            <small>{{ $summary['uniform_paid_students'] }} dari {{ $summary['uniform_total_students'] }} siswa lunas</small>
        </div>
        <div class="finance-card net">
            <span>Daftar Ulang Final</span>
            <strong>{{ number_format($summary['final_reenrollment_total'], 0, ',', '.') }}</strong>
            <small>Progress final {{ $summary['final_progress_rate'] }}%</small>
        </div>
    </section>

    @php
        $uniformProgress = $summary['uniform_required'] > 0
            ? min(100, round(($summary['uniform_collected'] / $summary['uniform_required']) * 100, 1))
            : 0;
        $recentTransactions = $transactions->getCollection()->take(5);
        $remainingReceivables = $receivables['rows']->where('remaining', '>', 0)->take(5);
    @endphp

    <section class="finance-dashboard-grid">
        <div class="finance-dashboard-panel wide">
            <h2><i class="fas fa-bolt me-2"></i>Pusat Tindakan Keuangan</h2>
            <div class="finance-action-grid">
                <a href="{{ route('admin.finance.transactions.create') }}" class="finance-action-card">
                    <i class="fas fa-cash-register"></i>
                    <span><strong>Catat Transaksi</strong><small>Input income, outcome, siswa, dan waktu transaksi.</small></span>
                </a>
                <a href="{{ route('admin.finance.uniform-report') }}" class="finance-action-card">
                    <i class="fas fa-shirt"></i>
                    <span><strong>Laporan Seragam</strong><small>Lihat tagihan, terbayar, dan sisa per siswa.</small></span>
                </a>
                <a href="{{ route('admin.finance.uniform-sizes') }}" class="finance-action-card">
                    <i class="fas fa-ruler-combined"></i>
                    <span><strong>Ukuran Seragam</strong><small>Catat ukuran dan status atribut peserta didik.</small></span>
                </a>
                <a href="{{ route('admin.finance.final-progress') }}" class="finance-action-card">
                    <i class="fas fa-chart-line"></i>
                    <span><strong>Progress Final</strong><small>Pantau verifikasi, administrasi, NIS, kartu, dan atribut.</small></span>
                </a>
                <a href="{{ route('admin.finance.mutations') }}" class="finance-action-card">
                    <i class="fas fa-arrow-right-arrow-left"></i>
                    <span><strong>Mutasi Kas</strong><small>Cetak kwitansi dan kartu dari transaksi income.</small></span>
                </a>
                <a href="{{ route('admin.finance.payment-types') }}" class="finance-action-card">
                    <i class="fas fa-tags"></i>
                    <span><strong>Jenis Pembayaran</strong><small>Tambah nominal default dan keterangan pembayaran.</small></span>
                </a>
            </div>
        </div>

        <div class="finance-dashboard-panel">
            <h2><i class="fas fa-chart-simple me-2"></i>Progres Uang Seragam</h2>
            <div class="finance-progress-meta">
                <span>{{ $summary['uniform_paid_students'] }} dari {{ $summary['uniform_total_students'] }} siswa lunas</span>
                <strong>{{ $uniformProgress }}%</strong>
            </div>
            <div class="finance-progress-bar">
                <div class="finance-progress-fill" style="width: {{ $uniformProgress }}%;"></div>
            </div>
            <div class="finance-mini-list mt-3">
                <div class="finance-mini-item">
                    <span>Total wajib</span>
                    <strong>{{ $rupiah($summary['uniform_required']) }}</strong>
                </div>
                <div class="finance-mini-item">
                    <span>Sudah diterima</span>
                    <strong>{{ $rupiah($summary['uniform_collected']) }}</strong>
                </div>
                <div class="finance-mini-item">
                    <span>Sisa tagihan</span>
                    <strong>{{ $rupiah($summary['uniform_remaining']) }}</strong>
                </div>
            </div>
        </div>

        <div class="finance-dashboard-panel">
            <h2><i class="fas fa-calendar-day me-2"></i>Ringkasan Harian</h2>
            <div class="finance-mini-list">
                @forelse($dailyByType->take(5) as $item)
                    <div class="finance-mini-item">
                        <span>
                            <strong>{{ $item->paymentType?->name ?? 'Tanpa Jenis' }}</strong><br>
                            {{ number_format($item->transaction_count, 0, ',', '.') }} transaksi
                        </span>
                        <span class="finance-pill {{ $item->direction }}">{{ $rupiah($item->total) }}</span>
                    </div>
                @empty
                    <div class="finance-empty-note">Belum ada transaksi pada tanggal ini.</div>
                @endforelse
            </div>
        </div>

        <div class="finance-dashboard-panel">
            <h2><i class="fas fa-receipt me-2"></i>Mutasi Terbaru</h2>
            <div class="finance-mini-list">
                @forelse($recentTransactions as $transaction)
                    <div class="finance-mini-item">
                        <span>
                            <strong>{{ $transaction->reference_number }}</strong><br>
                            {{ $transaction->student_name ?: ($transaction->description ?: 'Transaksi umum') }}
                        </span>
                        <span class="finance-pill {{ $transaction->direction }}">{{ $rupiah($transaction->amount) }}</span>
                    </div>
                @empty
                    <div class="finance-empty-note">Belum ada mutasi kas.</div>
                @endforelse
            </div>
        </div>

        <div class="finance-dashboard-panel">
            <h2><i class="fas fa-user-clock me-2"></i>Sisa Tagihan Teratas</h2>
            <div class="finance-mini-list">
                @forelse($remainingReceivables as $row)
                    <div class="finance-mini-item">
                        <span>
                            <strong>{{ $row['name'] }}</strong><br>
                            {{ $row['unit'] }} - {{ $row['registration_number'] }}
                        </span>
                        <strong>{{ $rupiah($row['remaining']) }}</strong>
                    </div>
                @empty
                    <div class="finance-empty-note">Tidak ada sisa tagihan pada daftar ringkas.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    @if($showFinalProgress)
    <section class="finance-kpi-grid">
        <div class="finance-card net">
            <span>Verified</span>
            <strong>{{ number_format($finalProgress['overall']['verified'], 0, ',', '.') }}</strong>
            <small>Total pendaftar terverifikasi</small>
        </div>
        <div class="finance-card income">
            <span>Administrasi Lengkap</span>
            <strong>{{ number_format($finalProgress['overall']['paid'], 0, ',', '.') }}</strong>
            <small>Dari {{ number_format($finalProgress['overall']['verified'], 0, ',', '.') }} siswa verified</small>
        </div>
        <div class="finance-card net">
            <span>NIS Aktif</span>
            <strong>{{ number_format($finalProgress['overall']['student_number'], 0, ',', '.') }}</strong>
            <small>Nomor induk sudah tersedia</small>
        </div>
        <div class="finance-card remaining">
            <span>Progress Final</span>
            <strong>{{ $finalProgress['overall']['final_rate'] }}%</strong>
            <small>{{ number_format($finalProgress['overall']['final'], 0, ',', '.') }} siswa final</small>
        </div>
    </section>

    <section class="finance-panel">
        <div class="finance-panel-header">
            <h2><i class="fas fa-chart-line me-2"></i>Dashboard Progress Final</h2>
            <span>Verifikasi sampai atribut tercatat</span>
        </div>
        <div class="finance-panel-body">
            <div class="final-progress-grid">
                @foreach($finalProgress['lanes'] as $lane)
                    <div class="final-progress-step">
                        <span>{{ $lane['label'] }}</span>
                        <strong>{{ number_format($lane['count'], 0, ',', '.') }}</strong>
                        <div class="final-progress-track">
                            <i style="width: {{ $lane['percent'] }}%;"></i>
                        </div>
                        <span>{{ $lane['percent'] }}%</span>
                    </div>
                @endforeach
            </div>

            <div class="finance-dashboard-grid mt-3">
                <div class="finance-dashboard-panel">
                    <h2><i class="fas fa-industry me-2"></i>SMKS</h2>
                    <div class="finance-mini-list">
                        <div class="finance-mini-item"><span>Verified</span><strong>{{ number_format($finalProgress['by_unit']['smk']['verified'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>Administrasi lengkap</span><strong>{{ number_format($finalProgress['by_unit']['smk']['paid'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>NIS aktif</span><strong>{{ number_format($finalProgress['by_unit']['smk']['student_number'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>Kartu tercetak</span><strong>{{ number_format($finalProgress['by_unit']['smk']['card_printed'], 0, ',', '.') }}</strong></div>
                    </div>
                </div>
                <div class="finance-dashboard-panel">
                    <h2><i class="fas fa-school me-2"></i>SMPS</h2>
                    <div class="finance-mini-list">
                        <div class="finance-mini-item"><span>Verified</span><strong>{{ number_format($finalProgress['by_unit']['smp']['verified'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>Administrasi lengkap</span><strong>{{ number_format($finalProgress['by_unit']['smp']['paid'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>NIS aktif</span><strong>{{ number_format($finalProgress['by_unit']['smp']['student_number'], 0, ',', '.') }}</strong></div>
                        <div class="finance-mini-item"><span>Kartu tercetak</span><strong>{{ number_format($finalProgress['by_unit']['smp']['card_printed'], 0, ',', '.') }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="finance-panel">
        <div class="finance-panel-header">
            <h2><i class="fas fa-triangle-exclamation me-2"></i>Perlu Ditindaklanjuti</h2>
            <span>{{ $finalProgress['attention_rows']->count() }} data ringkas</span>
        </div>
        <div class="finance-panel-body p-0">
            <div class="finance-table-wrap">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Administrasi</th>
                            <th>NIS</th>
                            <th>Kartu</th>
                            <th>Ukuran</th>
                            <th>Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finalProgress['attention_rows'] as $row)
                        <tr>
                            <td><span class="finance-pill income">{{ $row['unit'] }}</span></td>
                            <td>
                                <strong>{{ $row['name'] }}</strong>
                                <div class="finance-muted">{{ $row['registration_number'] }}</div>
                            </td>
                            <td>{{ $row['choice'] }}</td>
                            <td><span class="finance-pill {{ $row['is_paid'] ? 'income' : 'warning' }}">{{ $row['is_paid'] ? 'Lengkap' : $rupiah($row['remaining_amount']) }}</span></td>
                            <td>{{ $row['has_student_number'] ? $row['student_identification_number'] : '-' }}</td>
                            <td>{{ $row['has_card_printed'] ? 'Sudah' : 'Belum' }}</td>
                            <td>{{ $row['has_uniform_profile'] ? 'Tercatat' : 'Belum' }}</td>
                            <td>
                                <div class="finance-letter-stack">
                                    <a class="finance-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'accepted']) }}" target="_blank" rel="noopener">Diterima</a>
                                    <a class="finance-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'reenrollment']) }}" target="_blank" rel="noopener">Administrasi</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="finance-empty">Semua data final sudah rapi pada ringkasan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    @if($showUniformSizes)
    <section class="finance-panel" id="uniform-sizes">
        <div class="finance-panel-header">
            <h2><i class="fas fa-ruler-combined me-2"></i>Manajemen Ukuran Seragam</h2>
            <span>{{ $uniformSizeRows->where('has_profile', true)->count() }} sudah tercatat</span>
        </div>
        <div class="finance-panel-body">
            <form action="{{ route('admin.finance.uniform-sizes.store') }}" method="POST" class="finance-form-grid uniform-profile-form">
                @csrf
                <div class="finance-field full">
                    <label>Siswa Verified</label>
                    <div class="student-search-box"
                         data-search-endpoint="{{ route('admin.finance.students.search') }}">
                        <div class="student-search-control">
                            <input type="text"
                                   data-student-search-input
                                   value="{{ $selectedStudentLabel }}"
                                   placeholder="Ketik nama, NIS, atau nomor pendaftaran siswa"
                                   autocomplete="off"
                                   required>
                            <button type="button" class="student-search-clear" data-student-search-clear title="Kosongkan siswa">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>
                        <input type="hidden" name="student_key" data-student-key-input value="{{ old('student_key') }}">
                        <div class="student-search-results" data-student-search-results aria-live="polite"></div>
                        <div class="student-search-help">
                            Ketik minimal 2 karakter. Cari berdasarkan nama siswa, NIS, atau nomor pendaftaran.
                        </div>
                    </div>
                </div>
                <div class="finance-field">
                    <label>Ukuran Baju</label>
                    <select name="shirt_size">
                        <option value="">Belum dicatat</option>
                        @foreach(['XS','S','M','L','XL','XXL','XXXL'] as $size)
                            <option value="{{ $size }}" {{ old('shirt_size') === $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="finance-field">
                    <label>Ukuran Celana/Rok</label>
                    <input type="text" name="pants_size" value="{{ old('pants_size') }}" placeholder="Contoh: 28, 30, L">
                </div>
                <div class="finance-field">
                    <label>Status Atribut</label>
                    <select name="attribute_status" required>
                        <option value="recorded" {{ old('attribute_status') === 'recorded' ? 'selected' : '' }}>Tercatat</option>
                        <option value="prepared" {{ old('attribute_status') === 'prepared' ? 'selected' : '' }}>Disiapkan</option>
                        <option value="distributed" {{ old('attribute_status') === 'distributed' ? 'selected' : '' }}>Sudah Diserahkan</option>
                        <option value="not_recorded" {{ old('attribute_status') === 'not_recorded' ? 'selected' : '' }}>Belum Dicatat</option>
                    </select>
                </div>
                <div class="finance-field">
                    <label>Waktu Serah Terima</label>
                    <input type="datetime-local" name="picked_up_at" value="{{ old('picked_up_at') }}">
                </div>
                <div class="finance-field full">
                    <label>Catatan</label>
                    <textarea name="notes" placeholder="Contoh: baju XL, celana 30, sepatu 41, atribut disiapkan gelombang 2.">{{ old('notes') }}</textarea>
                </div>
                <div class="finance-field full">
                    <button type="submit" class="finance-submit">
                        <i class="fas fa-save me-2"></i>Simpan Ukuran Seragam
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="finance-panel">
        <div class="finance-panel-header">
            <h2><i class="fas fa-table me-2"></i>Data Ukuran dan Atribut</h2>
            <span>{{ $uniformSizeRows->count() }} siswa verified</span>
        </div>
        <div class="finance-panel-body">
            <!-- Search & Filter Controls -->
            <form action="{{ route('admin.finance.uniform-sizes') }}" method="GET" class="finance-filter-row mb-4">
                <div class="filter-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIS, No. Daftar..." class="form-control-minimal">
                </div>
                <div class="filter-group">
                    <select name="student_type" class="form-control-minimal">
                        <option value="">Semua Unit</option>
                        <option value="smk" {{ request('student_type') === 'smk' ? 'selected' : '' }}>SMKS</option>
                        <option value="smp" {{ request('student_type') === 'smp' ? 'selected' : '' }}>SMPS</option>
                    </select>
                </div>
                <div class="filter-group">
                    <select name="status" class="form-control-minimal">
                        <option value="">Semua Status Atribut</option>
                        <option value="recorded" {{ request('status') === 'recorded' ? 'selected' : '' }}>Tercatat</option>
                        <option value="prepared" {{ request('status') === 'prepared' ? 'selected' : '' }}>Disiapkan</option>
                        <option value="distributed" {{ request('status') === 'distributed' ? 'selected' : '' }}>Sudah Diserahkan</option>
                        <option value="not_recorded" {{ request('status') === 'not_recorded' ? 'selected' : '' }}>Belum Dicatat</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter-submit"><i class="fas fa-search me-1"></i> Cari</button>
                @if(request('search') || request('student_type') || request('status'))
                    <a href="{{ route('admin.finance.uniform-sizes') }}" class="btn-filter-reset"><i class="fas fa-undo me-1"></i> Reset</a>
                @endif
            </form>

            <div class="finance-table-wrap">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>NIS/No. Daftar</th>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Baju</th>
                            <th>Celana/Rok</th>
                            <th>Status</th>
                            <th>Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($uniformSizeRows as $row)
                        <tr>
                            <td><span class="finance-pill income">{{ $row['unit'] }}</span></td>
                            <td>
                                <strong>{{ $row['student_identification_number'] ?: '-' }}</strong>
                                <div class="finance-muted">{{ $row['registration_number'] }}</div>
                            </td>
                            <td>
                                <strong>{{ $row['name'] }}</strong>
                                <div class="finance-muted">{{ $row['is_paid'] ? 'Administrasi lengkap' : 'Administrasi proses' }}</div>
                            </td>
                            <td>{{ $row['choice'] }}</td>
                            <td>{{ $row['profile']?->shirt_size ?: '-' }}</td>
                            <td>{{ $row['profile']?->pants_size ?: '-' }}</td>
                            <td>
                                <span class="uniform-status-pill {{ $row['profile']?->attribute_status ?: 'not_recorded' }}">
                                    {{ $row['has_profile'] ? $row['attribute_status_label'] : 'Belum Dicatat' }}
                                </span>
                                @if($row['profile']?->picked_up_at)
                                    <div class="finance-muted">{{ $row['profile']->picked_up_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</div>
                                @endif
                            </td>
                            <td>
                                <div class="finance-letter-stack">
                                    <a class="finance-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'accepted']) }}" target="_blank" rel="noopener">Diterima</a>
                                    <a class="finance-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'reenrollment']) }}" target="_blank" rel="noopener">Administrasi</a>
                                    <a class="finance-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'parent-call']) }}" target="_blank" rel="noopener">Panggilan</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="finance-empty">Belum ada siswa verified untuk dicatat ukuran seragamnya.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    @if($showPaymentForm || $showPaymentTypes)
    <section class="finance-grid">
        @if($showPaymentForm)
        <div class="finance-panel" id="payment-form">
            <div class="finance-panel-header">
                <h2><i class="fas fa-cash-register me-2"></i>Catat Transaksi</h2>
                <span>Income atau outcome</span>
            </div>
            <div class="finance-panel-body">
                <form action="{{ route('admin.finance.transactions.store') }}" method="POST" class="finance-form-grid">
                    @csrf
                    <div class="finance-field">
                        <label>Jenis Pembayaran</label>
                        <select name="payment_type_id" id="paymentTypeSelect" required>
                            @foreach($paymentTypes as $type)
                                <option value="{{ $type->id }}"
                                        data-amount="{{ $type->default_amount }}"
                                        data-direction="{{ $type->direction }}">
                                    {{ $type->name }} - {{ $rupiah($type->default_amount) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="finance-field">
                        <label>Arah Mutasi</label>
                        <select name="direction" id="directionSelect">
                            <option value="income">Income</option>
                            <option value="outcome">Outcome</option>
                        </select>
                    </div>
                    <div class="finance-field full">
                        <label>Siswa Terverifikasi</label>
                        <div class="student-search-box"
                             data-search-endpoint="{{ route('admin.finance.students.search') }}">
                            <div class="student-search-control">
                                <input type="text"
                                       id="studentSearchInput"
                                       data-student-search-input
                                       value="{{ $selectedStudentLabel }}"
                                       placeholder="Cari nama atau nomor pendaftaran"
                                       autocomplete="off">
                                <button type="button" class="student-search-clear" id="studentSearchClear" data-student-search-clear title="Kosongkan siswa">
                                    <i class="fas fa-xmark"></i>
                                </button>
                            </div>
                            <input type="hidden" name="student_key" id="studentKeyInput" data-student-key-input value="{{ old('student_key') }}">
                            <div class="student-search-results" id="studentSearchResults" data-student-search-results aria-live="polite"></div>
                            <div class="student-search-help">
                                Ketik minimal 2 karakter. Hanya siswa berstatus verified yang bisa dipilih.
                            </div>
                        </div>
                    </div>
                    <div class="finance-field">
                        <label>Nominal</label>
                        <input type="number" name="amount" id="amountInput" min="1" placeholder="Kosongkan untuk nominal default">
                    </div>
                    <div class="finance-field">
                        <label>Metode</label>
                        <select name="payment_method" required>
                            <option value="cash">Tunai</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="finance-field">
                        <label>Waktu Transaksi</label>
                        <input type="datetime-local" name="paid_at" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="finance-field">
                        <label>No. Referensi</label>
                        <input type="text" name="reference_number" placeholder="Otomatis jika dikosongkan">
                    </div>
                    <div class="finance-field full">
                        <label>Keterangan</label>
                        <textarea name="description" placeholder="Contoh: Pelunasan uang seragam, pembelian ATK, refund, dan sebagainya."></textarea>
                    </div>
                    <div class="finance-field full">
                        <label>Catatan Internal</label>
                        <textarea name="notes" placeholder="Catatan tambahan untuk audit keuangan."></textarea>
                    </div>
                    <div class="finance-field full">
                        <button type="submit" class="finance-submit">
                            <i class="fas fa-save me-2"></i>Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if($showPaymentTypes)
        <div class="finance-panel" id="payment-types">
            <div class="finance-panel-header">
                <h2><i class="fas fa-tags me-2"></i>Jenis Pembayaran Baru</h2>
                <span>Nominal default</span>
            </div>
            <div class="finance-panel-body">
                <form action="{{ route('admin.finance.payment-types.store') }}" method="POST" class="finance-form-grid">
                    @csrf
                    <div class="finance-field full">
                        <label>Nama Jenis</label>
                        <input type="text" name="name" placeholder="Contoh: Uang Kegiatan" required>
                    </div>
                    <div class="finance-field">
                        <label>Kode</label>
                        <input type="text" name="code" placeholder="Opsional">
                    </div>
                    <div class="finance-field">
                        <label>Nominal</label>
                        <input type="number" name="default_amount" min="0" value="0" required>
                    </div>
                    <div class="finance-field">
                        <label>Jenis Mutasi</label>
                        <select name="direction" required>
                            <option value="income">Income</option>
                            <option value="outcome">Outcome</option>
                        </select>
                    </div>
                    <div class="finance-field">
                        <label>Status</label>
                        <select name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="finance-field full">
                        <label>Keterangan</label>
                        <textarea name="description" placeholder="Jelaskan tujuan pembayaran ini."></textarea>
                    </div>
                    <div class="finance-field full">
                        <button type="submit" class="finance-submit">
                            <i class="fas fa-plus me-2"></i>Buat Jenis Pembayaran
                        </button>
                    </div>
                </form>

                <div class="finance-table-wrap mt-3">
                    <table class="finance-table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Mutasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentTypes as $type)
                            <tr>
                                <td>
                                    <strong>{{ $type->name }}</strong>
                                    <div class="finance-muted">{{ $type->code }}</div>
                                </td>
                                <td>{{ $rupiah($type->default_amount) }}</td>
                                <td>
                                    <span class="finance-pill {{ $type->direction }}">
                                        {{ $type->direction === 'income' ? 'Income' : 'Outcome' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </section>
    @endif

    @if($showUniformReport)
    <section class="finance-panel" id="uniform-report">
        <div class="finance-panel-header">
            <h2><i class="fas fa-shirt me-2"></i>Laporan Uang Seragam</h2>
            <span>{{ number_format($receivables['rows']->count(), 0, ',', '.') }} dari {{ number_format($summary['uniform_total_students'], 0, ',', '.') }} siswa verified</span>
        </div>
        <div class="finance-panel-body">
            <!-- Search & Filter Controls -->
            <form action="{{ route('admin.finance.uniform-report') }}" method="GET" class="finance-filter-row mb-4">
                <div class="filter-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIS, No. Daftar..." class="form-control-minimal">
                </div>
                <div class="filter-group">
                    <select name="student_type" class="form-control-minimal">
                        <option value="">Semua Unit</option>
                        <option value="smk" {{ request('student_type') === 'smk' ? 'selected' : '' }}>SMKS</option>
                        <option value="smp" {{ request('student_type') === 'smp' ? 'selected' : '' }}>SMPS</option>
                    </select>
                </div>
                <div class="filter-group">
                    <select name="status" class="form-control-minimal">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter-submit"><i class="fas fa-search me-1"></i> Cari</button>
                @if(request('search') || request('student_type') || request('status'))
                    <a href="{{ route('admin.finance.uniform-report') }}" class="btn-filter-reset"><i class="fas fa-undo me-1"></i> Reset</a>
                @endif
            </form>

            <div class="finance-table-wrap">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>NIS</th>
                            <th>No. Daftar</th>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>Wajib</th>
                            <th>Terbayar</th>
                            <th>Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receivables['rows'] as $row)
                        <tr>
                            <td><span class="finance-pill income">{{ $row['unit'] }}</span></td>
                            <td><strong>{{ $row['student_identification_number'] ?: '-' }}</strong></td>
                            <td>{{ $row['registration_number'] }}</td>
                            <td><strong>{{ $row['name'] }}</strong></td>
                            <td>{{ $row['choice'] }}</td>
                            <td>{{ $rupiah($row['required']) }}</td>
                            <td>{{ $rupiah($row['paid']) }}</td>
                            <td>
                                <span class="finance-pill {{ $row['remaining'] <= 0 ? 'income' : 'warning' }}">
                                    {{ $row['remaining'] <= 0 ? 'Lunas' : $rupiah($row['remaining']) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="finance-empty">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    @if($showDailyReport || $showMutationReport)
    <section class="finance-grid">
        @if($showDailyReport)
        <div class="finance-panel">
            <div class="finance-panel-header">
                <h2><i class="fas fa-calendar-day me-2"></i>Laporan Harian</h2>
                <span>{{ $summary['date']->translatedFormat('d F Y') }}</span>
            </div>
            <div class="finance-panel-body">
                <div class="finance-table-wrap">
                    <table class="finance-table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Mutasi</th>
                                <th>Transaksi</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dailyByType as $item)
                            <tr>
                                <td>{{ $item->paymentType?->name ?? 'Tanpa Jenis' }}</td>
                                <td><span class="finance-pill {{ $item->direction }}">{{ $item->direction === 'income' ? 'Income' : 'Outcome' }}</span></td>
                                <td>{{ number_format($item->transaction_count, 0, ',', '.') }}</td>
                                <td><strong>{{ $rupiah($item->total) }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="finance-empty">Belum ada transaksi pada tanggal ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($showMutationReport)
        <div class="finance-panel">
            <div class="finance-panel-header">
                <h2><i class="fas fa-search me-2"></i>Cari Mutasi</h2>
                <span>No. referensi atau nama siswa</span>
            </div>
            <div class="finance-panel-body">
                <form action="{{ route('admin.finance.mutations') }}" method="GET" class="finance-form-grid">
                    <div class="finance-field full">
                        <label>Kata Kunci</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi">
                    </div>
                    <div class="finance-field">
                        <label>Tanggal</label>
                        <input type="date" name="date" value="{{ $summary['date']->format('Y-m-d') }}">
                    </div>
                    <div class="finance-field">
                        <label>Mutasi</label>
                        <select name="direction">
                            <option value="">Semua</option>
                            <option value="income" {{ request('direction') === 'income' ? 'selected' : '' }}>Income</option>
                            <option value="outcome" {{ request('direction') === 'outcome' ? 'selected' : '' }}>Outcome</option>
                        </select>
                    </div>
                    <div class="finance-field full">
                        <button type="submit" class="finance-submit">
                            <i class="fas fa-search me-2"></i>Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </section>
    @endif

    @if($showMutationReport)
    <section class="finance-panel" id="mutation-report">
        <div class="finance-panel-header">
            <h2><i class="fas fa-arrow-right-arrow-left me-2"></i>Mutasi Kas</h2>
            <span>{{ $transactions->total() }} transaksi</span>
        </div>
        <div class="finance-panel-body p-0">
            <div class="finance-table-wrap">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Referensi</th>
                            <th>Jenis</th>
                            <th>Siswa</th>
                            <th>Mutasi</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        @php
                            $relatedStudent = $transaction->student_type === 'smp'
                                ? $transaction->smpApplicant
                                : $transaction->smkApplicant;
                            $cardState = $cardStates[$transaction->id] ?? ['can_print' => false, 'label' => '-'];
                            $canPrintCard = $cardState['can_print'];
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $transaction->paid_at->format('d/m/Y') }}</strong>
                                <div class="finance-muted">{{ $transaction->paid_at->format('H:i') }}</div>
                            </td>
                            <td>{{ $transaction->reference_number }}</td>
                            <td>{{ $transaction->paymentType?->name ?? '-' }}</td>
                            <td>
                                <strong>{{ $transaction->student_name }}</strong>
                                <div class="finance-muted">{{ $transaction->student_unit }} {{ $relatedStudent?->student_identification_number ?: $transaction->student_registration }}</div>
                            </td>
                            <td><span class="finance-pill {{ $transaction->direction }}">{{ $transaction->direction === 'income' ? 'Income' : 'Outcome' }}</span></td>
                            <td><strong>{{ $rupiah($transaction->amount) }}</strong></td>
                            <td>{{ strtoupper($transaction->payment_method) }}</td>
                            <td>{{ $transaction->creator?->name ?? '-' }}</td>
                            <td>
                                @if($transaction->status === 'confirmed')
                                    <a href="{{ route('admin.finance.receipt', $transaction) }}"
                                       class="finance-action-link"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="fas fa-receipt"></i>Kwitansi
                                    </a>
                                @endif
                                @if($canPrintCard)
                                    <a href="{{ route('admin.finance.student-card', $transaction) }}"
                                       class="finance-action-link"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="fas fa-id-card"></i>Cetak
                                    </a>
                                @elseif(($cardState['label'] ?? '-') !== '-')
                                    <span class="finance-muted">{{ $cardState['label'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="finance-empty">Belum ada mutasi kas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
            <div class="p-3">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </section>
    @endif

    @if($showGuide)
        @include('admin.partials.guide-finance')
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const paymentType = document.getElementById('paymentTypeSelect');
    const direction = document.getElementById('directionSelect');
    const amount = document.getElementById('amountInput');
    const studentBoxes = document.querySelectorAll('.student-search-box');
    const initialStudents = Object.values(@json($students));

    function syncPaymentType() {
        const selected = paymentType?.selectedOptions?.[0];
        if (!selected) return;
        if (direction) direction.value = selected.dataset.direction || 'income';
        if (amount && !amount.value) amount.placeholder = selected.dataset.amount ? `Default Rp ${Number(selected.dataset.amount).toLocaleString('id-ID')}` : 'Nominal';
    }

    paymentType?.addEventListener('change', syncPaymentType);
    syncPaymentType();

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[char]));
    }

    function renderStudentResults(studentResults, items, message = '') {
        if (!studentResults) return;

        if (message) {
            studentResults.innerHTML = `<div class="student-search-item"><span>${message}</span></div>`;
            studentResults.classList.add('is-open');
            return;
        }

        if (!items.length) {
            studentResults.innerHTML = '<div class="student-search-item"><span>Tidak ada siswa verified yang cocok.</span></div>';
            studentResults.classList.add('is-open');
            return;
        }

        studentResults.innerHTML = items.map((student) => `
            <button type="button"
                    class="student-search-item"
                    data-key="${escapeHtml(student.key)}"
                    data-label="${escapeHtml(`${student.unit} - ${student.label}`)}">
                <strong>${escapeHtml(student.name)}</strong>
                <span>${escapeHtml(`${student.unit} - ${student.student_identification_number || 'Belum ada NIS'} - ${student.registration_number} - ${student.choice}`)}</span>
            </button>
        `).join('');
        studentResults.classList.add('is-open');
    }

    function findLocalStudents(term) {
        const keyword = term.toLowerCase();

        return initialStudents
            .filter((student) => [
                student.name,
                student.registration_number,
                student.student_identification_number,
                student.choice,
                student.label,
            ].join(' ').toLowerCase().includes(keyword))
            .slice(0, 10);
    }

    async function fetchStudents(term, studentBox) {
        if (!studentBox?.dataset.searchEndpoint) {
            return findLocalStudents(term);
        }

        const url = `${studentBox.dataset.searchEndpoint}?q=${encodeURIComponent(term)}`;
        const response = await fetch(url, { headers: { Accept: 'application/json' } });

        if (!response.ok) {
            return findLocalStudents(term);
        }

        return response.json();
    }

    function setupStudentSearch(studentBox) {
        const studentSearch = studentBox.querySelector('[data-student-search-input]');
        const studentKey = studentBox.querySelector('[data-student-key-input]');
        const studentResults = studentBox.querySelector('[data-student-search-results]');
        const studentClear = studentBox.querySelector('[data-student-search-clear]');
        let searchTimer = null;

        studentSearch?.addEventListener('input', () => {
            const term = studentSearch.value.trim();
            if (studentKey) studentKey.value = '';
            clearTimeout(searchTimer);

            if (term.length < 2) {
                studentResults?.classList.remove('is-open');
                if (studentResults) studentResults.innerHTML = '';
                return;
            }

            renderStudentResults(studentResults, findLocalStudents(term), 'Mencari siswa verified...');
            searchTimer = setTimeout(async () => {
                try {
                    renderStudentResults(studentResults, await fetchStudents(term, studentBox));
                } catch (error) {
                    renderStudentResults(studentResults, findLocalStudents(term));
                }
            }, 220);
        });

        studentSearch?.addEventListener('focus', () => {
            const term = studentSearch.value.trim();

            if (term.length >= 2 && !studentResults?.classList.contains('is-open')) {
                renderStudentResults(studentResults, findLocalStudents(term));
            }
        });

        studentResults?.addEventListener('click', (event) => {
            const item = event.target.closest('.student-search-item[data-key]');
            if (!item) return;

            if (studentSearch) studentSearch.value = item.dataset.label || '';
            if (studentKey) studentKey.value = item.dataset.key || '';
            studentResults.classList.remove('is-open');
        });

        studentClear?.addEventListener('click', () => {
            if (studentSearch) studentSearch.value = '';
            if (studentKey) studentKey.value = '';
            if (studentResults) {
                studentResults.innerHTML = '';
                studentResults.classList.remove('is-open');
            }
            studentSearch?.focus();
        });
    }

    studentBoxes.forEach(setupStudentSearch);

    document.addEventListener('click', (event) => {
        studentBoxes.forEach((studentBox) => {
            if (!studentBox.contains(event.target)) {
                studentBox.querySelector('[data-student-search-results]')?.classList.remove('is-open');
            }
        });
    });
});
</script>
@endpush
