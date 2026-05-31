@extends('layouts.admin')

@section('title', 'Dashboard Admin - YAPISDA')

@push('styles')
<!-- QR Code Scanner Library -->
<style>
.border-left-primary { border-left: 4px solid #2563eb !important; }
.border-left-success { border-left: 4px solid #10b981 !important; }
.border-left-warning { border-left: 4px solid #f59e0b !important; }
.border-left-danger { border-left: 4px solid #ef4444 !important; }

.card-body h5 { font-size: 1.25rem; }
.card-body .h5 { font-size: 1.5rem; }

.table thead th { font-weight: 600; }

/* Tombol Scan QR Besar */
.btn-scan-qr {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    padding: 20px 40px;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
    transition: all 0.3s ease;
    min-width: 250px;
}

.btn-scan-qr:hover {
    background: linear-gradient(135deg, #1e40af, #2563eb);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(37, 99, 235, 0.6);
}

.btn-scan-qr i {
    font-size: 1.8rem;
    margin-right: 10px;
}

.scan-qr-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
    padding: 20px;
    background: rgba(37, 99, 235, 0.05);
    border-radius: 20px;
    border: 2px dashed #2563eb;
}

/* Style untuk tombol aksi */


.btn-action.btn-primary:hover { background-color: #1d4ed8; }
.btn-action.btn-info:hover { background-color: #0284c7; }
.btn-action.btn-warning:hover { background-color: #d97706; }
.btn-action.btn-danger:hover { background-color: #dc2626; }
.btn-action.btn-success:hover { background-color: #059669; }
.btn-action.btn-secondary:hover { background-color: #4b5563; }

.admin-status-form {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    min-width: 158px;
}

.admin-status-form select {
    height: 32px;
    max-width: 118px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #1f2937;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 0 0.45rem;
}

.admin-status-form select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.14);
    outline: none;
}

.insight-grid,
.chart-grid,
.analytics-grid {
    display: grid;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.insight-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
.chart-grid { grid-template-columns: minmax(0, 1.35fr) minmax(0, 0.85fr); }
.analytics-grid { grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr); }

.smp-dashboard-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.smp-dashboard-card {
    min-width: 0;
    background: #fff;
    border: 1px solid var(--line, #dce6e2);
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(20, 32, 29, 0.08);
    padding: 1.2rem;
}

.smp-dashboard-card.wide {
    grid-column: 1 / -1;
}

.smp-dashboard-card h5 {
    margin: 0 0 1rem;
    color: #14201d;
    font-size: 1rem;
    font-weight: 800;
}

.smp-work-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.8rem;
}

.smp-work-item,
.smp-link-card,
.smp-dashboard-list-item {
    border: 1px solid var(--line, #dce6e2);
    border-radius: 14px;
    background: #fbfdfc;
}

.smp-work-item {
    padding: 1rem;
}

.smp-work-item span,
.smp-dashboard-list-item span {
    display: block;
    color: #687874;
    font-size: 0.8rem;
    font-weight: 700;
}

.smp-work-item strong {
    display: block;
    margin-top: 0.35rem;
    color: #14201d;
    font-size: 1.55rem;
    line-height: 1;
}

.smp-link-grid,
.smp-dashboard-list {
    display: grid;
    gap: 0.7rem;
}

.smp-link-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem;
    color: #14201d;
    text-decoration: none;
    transition: all 0.2s ease;
}

.smp-link-card:hover {
    background: #edf7f3;
    border-color: rgba(15, 95, 74, 0.3);
    transform: translateY(-1px);
}

.smp-link-card i {
    width: 2.2rem;
    height: 2.2rem;
    display: grid;
    place-items: center;
    border-radius: 12px;
    color: #fff;
    background: linear-gradient(135deg, #0f5f4a, #1f9aa5);
}

.smp-link-card strong {
    display: block;
    font-size: 0.92rem;
}

.smp-link-card small {
    color: #687874;
    font-size: 0.76rem;
    font-weight: 700;
}

.smp-status-row {
    display: grid;
    gap: 0.4rem;
    margin-bottom: 0.75rem;
}

.smp-status-meta {
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
    color: #687874;
    font-size: 0.82rem;
    font-weight: 800;
}

.smp-status-bar {
    height: 0.6rem;
    overflow: hidden;
    border-radius: 999px;
    background: #edf3f0;
}

.smp-status-fill {
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #0f5f4a, #c89b3c);
}

.smp-dashboard-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.8rem;
}

.smp-dashboard-list-item strong {
    color: #14201d;
    font-size: 0.9rem;
}

.smp-dashboard-empty {
    padding: 1rem;
    color: #687874;
    border: 1px dashed var(--line, #dce6e2);
    border-radius: 14px;
    background: #fbfdfc;
    font-weight: 700;
}

.insight-card,
.chart-card,
.heatmap-card,
.activity-card {
    background: #fff;
    border: 1px solid var(--line, #dce6e2);
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(20, 32, 29, 0.08);
}

.insight-card {
    min-height: 126px;
    padding: 1.1rem;
    display: grid;
    align-content: space-between;
}

.insight-label {
    color: #687874;
    font-size: 0.76rem;
    font-weight: 800;
    text-transform: uppercase;
}

.insight-value {
    color: #14201d;
    font-family: var(--ff-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.9rem;
    font-weight: 800;
    line-height: 1;
}

.insight-note {
    color: #687874;
    font-size: 0.82rem;
    margin-top: 0.4rem;
}

.chart-card,
.heatmap-card,
.activity-card {
    padding: 1.25rem;
    min-width: 0;
}

.chart-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

.chart-heading h5,
.analytics-title {
    margin: 0;
    color: #14201d;
    font-size: 1rem;
    font-weight: 800;
}

.chart-box {
    position: relative;
    min-height: 300px;
}

.chart-box-native {
    display: grid;
    gap: 0.8rem;
}

.trend-chart {
    height: 230px;
    display: flex;
    align-items: end;
    gap: 0.38rem;
    padding: 0.75rem 0.4rem 0;
    border-bottom: 1px solid var(--line, #dce6e2);
    background:
        linear-gradient(to top, rgba(220, 230, 226, 0.75) 1px, transparent 1px) 0 0 / 100% 25%,
        linear-gradient(to bottom, rgba(15, 95, 74, 0.04), rgba(200, 155, 60, 0.04));
    border-radius: 14px 14px 0 0;
}

.trend-bar-wrap {
    flex: 1;
    min-width: 5px;
    height: 100%;
    display: flex;
    align-items: end;
}

.trend-bar {
    width: 100%;
    min-height: 3px;
    border-radius: 999px 999px 0 0;
    background: linear-gradient(180deg, #1f9aa5, #0f5f4a);
    box-shadow: 0 8px 18px rgba(15, 95, 74, 0.18);
}

.trend-axis,
.chart-legend {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.8rem;
    color: #687874;
    font-size: 0.75rem;
    font-weight: 800;
}

.chart-legend {
    justify-content: flex-start;
    flex-wrap: wrap;
    font-size: 0.78rem;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.legend-swatch {
    width: 0.65rem;
    height: 0.65rem;
    border-radius: 999px;
    display: inline-block;
}

.status-chart {
    min-height: 250px;
    display: grid;
    place-items: center;
    gap: 1rem;
}

.status-donut {
    width: 176px;
    height: 176px;
    border-radius: 50%;
    position: relative;
    box-shadow: inset 0 0 0 1px rgba(13, 33, 24, 0.08), 0 2px 10px rgba(20, 32, 29, 0.08);
}

.status-donut::after {
    content: '';
    position: absolute;
    inset: 28px;
    border-radius: 50%;
    background: #fff;
    box-shadow: inset 0 0 0 1px var(--line, #dce6e2);
}

.donut-center {
    position: absolute;
    inset: 0;
    display: grid;
    place-content: center;
    text-align: center;
    z-index: 1;
}

.donut-value {
    color: #14201d;
    font-family: var(--ff-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
}

.donut-label {
    color: #687874;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
}

.bar-chart-list,
.quota-chart-list {
    display: grid;
    gap: 0.9rem;
    padding-top: 0.25rem;
}

.bar-chart-row,
.quota-chart-row {
    display: grid;
    grid-template-columns: minmax(120px, 180px) 1fr auto;
    gap: 0.8rem;
    align-items: center;
}

.bar-label,
.quota-label {
    color: #14201d;
    font-size: 0.82rem;
    font-weight: 800;
}

.bar-track,
.quota-stack {
    height: 0.85rem;
    overflow: hidden;
    border-radius: 999px;
    background: #edf3f0;
}

.bar-fill {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #0f5f4a, #1f9aa5);
}

.quota-stack {
    display: flex;
}

.quota-used,
.quota-open {
    display: block;
    height: 100%;
}

.quota-used { background: #0f5f4a; }
.quota-open { background: #c89b3c; }

.bar-value,
.quota-value {
    color: #687874;
    font-size: 0.78rem;
    font-weight: 800;
    white-space: nowrap;
}

.empty-chart {
    min-height: 220px;
    display: grid;
    place-items: center;
    color: #687874;
    font-size: 0.88rem;
    font-weight: 700;
}

.heatmap {
    display: grid;
    gap: 0.45rem;
    margin-top: 1rem;
    overflow-x: auto;
}

.heatmap-row,
.heatmap-header {
    display: grid;
    grid-template-columns: 3.2rem repeat(6, minmax(4rem, 1fr));
    gap: 0.45rem;
    min-width: 520px;
}

.heatmap-header {
    color: #687874;
    font-size: 0.75rem;
    font-weight: 800;
    text-align: center;
}

.heatmap-day {
    color: #687874;
    font-size: 0.78rem;
    font-weight: 800;
    display: flex;
    align-items: center;
}

.heatmap-cell {
    min-height: 42px;
    border: 1px solid rgba(15, 95, 74, 0.08);
    border-radius: 10px;
    display: grid;
    place-items: center;
    color: #14201d;
    font-size: 0.84rem;
    font-weight: 800;
}

.quota-alerts,
.activity-list {
    display: grid;
    gap: 0.65rem;
    margin-top: 1rem;
}

.quota-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    border-radius: 12px;
    background: #fff2cf;
    color: #9f7629;
    padding: 0.7rem 0.85rem;
    font-size: 0.84rem;
    font-weight: 700;
}

.activity-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 0.75rem;
    align-items: center;
    border-bottom: 1px solid var(--line, #dce6e2);
    padding-bottom: 0.75rem;
}

.activity-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.activity-dot {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    background: #0f5f4a;
}

.activity-dot.pending { background: #d97706; }
.activity-dot.verified { background: #16a34a; }
.activity-dot.rejected { background: #dc2626; }

.activity-name {
    color: #14201d;
    font-weight: 800;
    line-height: 1.2;
}

.activity-meta {
    color: #687874;
    font-size: 0.78rem;
}

@media (max-width: 1199px) {
    .smp-dashboard-grid,
    .insight-grid { grid-template-columns: repeat(2, 1fr); }
    .chart-grid,
    .analytics-grid { grid-template-columns: 1fr; }
}

@media (max-width: 575px) {
    .smp-dashboard-grid,
    .smp-work-grid,
    .insight-grid { grid-template-columns: 1fr; }
    .chart-box { height: 260px; }
}
</style>
@endpush

@section('admin_content')
@php
    $adminSection = $adminSection ?? 'dashboard';
    $showDashboard = $adminSection === 'dashboard';
    $showAnalytics = $adminSection === 'analytics';
    $showQuotas = $adminSection === 'quotas';
    $showApplicants = $adminSection === 'applicants' || ($search ?? false);
    $showGuide = $adminSection === 'guide';
@endphp
<div class="container-fluid">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin SMPS - SPMB 2026/2027</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    @if($showDashboard)
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Terverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['verified'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $smpQuotaAlerts = collect($dashboard['quota_alerts']);
        $smpLatestItems = collect($dashboard['latest']);
        $smpStatusLabels = $dashboard['status']['labels'];
        $smpStatusData = $dashboard['status']['data'];
        $smpStatusTotal = max(array_sum($smpStatusData), 1);
    @endphp

    <div class="smp-dashboard-grid">
        <section class="smp-dashboard-card wide">
            <h5><i class="fas fa-clipboard-list me-2"></i>Peta Kerja Hari Ini</h5>
            <div class="smp-work-grid">
                <div class="smp-work-item">
                    <span>Pendaftar hari ini</span>
                    <strong>{{ number_format($dashboard['kpis']['today']) }}</strong>
                </div>
                <div class="smp-work-item">
                    <span>Perlu diverifikasi</span>
                    <strong>{{ number_format($stats['pending']) }}</strong>
                </div>
                <div class="smp-work-item">
                    <span>Kuota perlu perhatian</span>
                    <strong>{{ number_format($smpQuotaAlerts->count()) }}</strong>
                </div>
                <div class="smp-work-item">
                    <span>Rate verifikasi</span>
                    <strong>{{ $dashboard['kpis']['verification_rate'] }}%</strong>
                </div>
            </div>
        </section>

        <section class="smp-dashboard-card">
            <h5><i class="fas fa-bolt me-2"></i>Akses Cepat</h5>
            <div class="smp-link-grid">
                <a href="{{ route('admin.smp.applicants') }}" class="smp-link-card">
                    <i class="fas fa-table"></i>
                    <span><strong>Data Pendaftar</strong><small>Cari, verifikasi, dan edit data.</small></span>
                </a>
                <a href="{{ route('admin.smp.analytics') }}" class="smp-link-card">
                    <i class="fas fa-chart-line"></i>
                    <span><strong>Analytics</strong><small>Grafik tren dan heatmap SMP.</small></span>
                </a>
                <a href="{{ route('admin.smp.quotas') }}" class="smp-link-card">
                    <i class="fas fa-layer-group"></i>
                    <span><strong>Kuota Program</strong><small>Pantau kapasitas pendaftaran.</small></span>
                </a>
                <a href="{{ route('admin.smp.export.excel') }}" class="smp-link-card">
                    <i class="fas fa-file-excel"></i>
                    <span><strong>Export Excel</strong><small>Unduh data pendaftar SMP.</small></span>
                </a>
            </div>
        </section>

        <section class="smp-dashboard-card">
            <h5><i class="fas fa-circle-nodes me-2"></i>Status Pendaftaran</h5>
            @foreach($smpStatusLabels as $index => $label)
                @php
                    $value = (int) ($smpStatusData[$index] ?? 0);
                    $percent = round(($value / $smpStatusTotal) * 100, 1);
                @endphp
                <div class="smp-status-row">
                    <div class="smp-status-meta">
                        <span>{{ $label }}</span>
                        <strong>{{ number_format($value) }} siswa</strong>
                    </div>
                    <div class="smp-status-bar">
                        <div class="smp-status-fill" style="width: {{ $percent }}%;"></div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="smp-dashboard-card">
            <h5><i class="fas fa-triangle-exclamation me-2"></i>Kuota Perlu Perhatian</h5>
            <div class="smp-dashboard-list">
                @forelse($smpQuotaAlerts as $alert)
                    <div class="smp-dashboard-list-item">
                        <span>{{ $alert['label'] }}</span>
                        <strong>{{ $alert['available'] }} sisa</strong>
                    </div>
                @empty
                    <div class="smp-dashboard-empty">Semua kuota masih aman.</div>
                @endforelse
            </div>
        </section>

        <section class="smp-dashboard-card">
            <h5><i class="fas fa-clock-rotate-left me-2"></i>Aktivitas Terbaru</h5>
            <div class="smp-dashboard-list">
                @forelse($smpLatestItems as $item)
                    <div class="smp-dashboard-list-item">
                        <span>
                            <strong>{{ $item['name'] }}</strong><br>
                            {{ $item['registration_number'] }} - {{ $item['choice'] }}
                        </span>
                        <span class="badge bg-{{ $item['status'] === 'verified' ? 'success' : ($item['status'] === 'pending' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($item['status']) }}</span>
                    </div>
                @empty
                    <div class="smp-dashboard-empty">Belum ada aktivitas pendaftaran.</div>
                @endforelse
            </div>
        </section>
    </div>
    @endif

    <!-- Analytics Overview -->
    @if($showAnalytics)
    <div class="insight-grid" id="analytics">
        <div class="insight-card">
            <div>
                <div class="insight-label">Kapasitas Terpakai</div>
                <div class="insight-value">{{ $dashboard['kpis']['capacity_rate'] }}%</div>
            </div>
            <div class="insight-note">
                {{ number_format($dashboard['kpis']['capacity_used']) }} dari {{ number_format($dashboard['kpis']['capacity_total']) }} kursi
            </div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Pendaftar Hari Ini</div>
                <div class="insight-value">{{ number_format($dashboard['kpis']['today']) }}</div>
            </div>
            <div class="insight-note">{{ number_format($dashboard['kpis']['week']) }} pendaftar dalam 7 hari</div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Rate Verifikasi</div>
                <div class="insight-value">{{ $dashboard['kpis']['verification_rate'] }}%</div>
            </div>
            <div class="insight-note">Perbandingan verified terhadap total pendaftar</div>
        </div>
        <div class="insight-card">
            <div>
                <div class="insight-label">Jam Tersibuk</div>
                <div class="insight-value">{{ $dashboard['kpis']['busiest_slot']['label'] }}</div>
            </div>
            <div class="insight-note">{{ number_format($dashboard['kpis']['busiest_slot']['count']) }} pendaftaran dalam periode ini</div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-chart-line me-2"></i>Tren Pendaftaran {{ $dashboard['period'] }} Hari</h5>
                <span class="badge bg-success">Harian</span>
            </div>
            <div id="smpRegistrationTrendChart" class="chart-box chart-box-native" role="img" aria-label="Grafik tren pendaftaran SMP">
                @php
                    $trendLabels = $dashboard['trend']['labels'];
                    $trendTotals = $dashboard['trend']['total'];
                    $trendMax = max(array_merge($trendTotals, [1]));
                    $middleTrendIndex = max(0, (int) floor((count($trendLabels) - 1) / 2));
                @endphp
                <div class="trend-chart">
                    @foreach($trendTotals as $index => $value)
                        @php $height = max(3, ($value / $trendMax) * 100); @endphp
                        <span class="trend-bar-wrap" title="{{ $trendLabels[$index] ?? 'Hari' }}: {{ $value }} pendaftar">
                            <span class="trend-bar" style="height: {{ $height }}%;"></span>
                        </span>
                    @endforeach
                </div>
                <div class="trend-axis">
                    <span>{{ $trendLabels[0] ?? '-' }}</span>
                    <span>{{ $trendLabels[$middleTrendIndex] ?? '-' }}</span>
                    <span>{{ $trendLabels[count($trendLabels) - 1] ?? '-' }}</span>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-swatch" style="background: #0f5f4a;"></span>Total harian</span>
                    <span class="legend-item"><span class="legend-swatch" style="background: #c89b3c;"></span>Puncak: {{ number_format($trendMax) }}</span>
                </div>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-circle-notch me-2"></i>Status Pendaftar</h5>
                <span class="badge bg-info">Total</span>
            </div>
            <div id="smpStatusChart" class="chart-box status-chart" role="img" aria-label="Grafik komposisi status pendaftar SMP">
                @php
                    $statusLabels = $dashboard['status']['labels'];
                    $statusData = $dashboard['status']['data'];
                    $statusColors = ['#d97706', '#16a34a', '#dc2626'];
                    $statusRawTotal = array_sum($statusData);
                    $statusTotal = max($statusRawTotal, 1);
                    $cursor = 0;
                    $segments = [];

                    foreach ($statusData as $statusIndex => $count) {
                        $next = $cursor + (($count / $statusTotal) * 100);
                        $segments[] = ($statusColors[$statusIndex] ?? '#0f5f4a') . " {$cursor}% {$next}%";
                        $cursor = $next;
                    }

                    $donutGradient = $statusRawTotal > 0
                        ? 'conic-gradient(' . implode(', ', $segments) . ')'
                        : '#edf3f0';
                @endphp
                <div class="status-donut" style="background: {{ $donutGradient }};">
                    <div class="donut-center">
                        <span class="donut-value">{{ number_format($statusRawTotal) }}</span>
                        <span class="donut-label">Pendaftar</span>
                    </div>
                </div>
                <div class="chart-legend">
                    @foreach($statusLabels as $index => $label)
                        <span class="legend-item">
                            <span class="legend-swatch" style="background: {{ $statusColors[$index] ?? '#0f5f4a' }};"></span>
                            {{ $label }} <strong>{{ number_format($statusData[$index] ?? 0) }}</strong>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-school me-2"></i>Distribusi Program</h5>
                <span class="badge bg-success">Peminat</span>
            </div>
            <div id="smpProgramDistributionChart" class="chart-box chart-box-native" role="img" aria-label="Grafik distribusi program SMP">
                @php
                    $distributionLabels = $dashboard['distribution']['labels'];
                    $distributionData = $dashboard['distribution']['data'];
                    $distributionMax = max(array_merge($distributionData, [1]));
                @endphp
                <div class="bar-chart-list">
                    @forelse($distributionLabels as $index => $label)
                        @php
                            $value = $distributionData[$index] ?? 0;
                            $width = max(3, ($value / $distributionMax) * 100);
                        @endphp
                        <div class="bar-chart-row">
                            <span class="bar-label">{{ $label }}</span>
                            <span class="bar-track">
                                <span class="bar-fill" style="width: {{ $width }}%;"></span>
                            </span>
                            <span class="bar-value">{{ number_format($value) }}</span>
                        </div>
                    @empty
                        <div class="empty-chart">Belum ada distribusi program.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-heading">
                <h5><i class="fas fa-gauge-high me-2"></i>Penggunaan Kuota</h5>
                <span class="badge bg-warning text-dark">Kursi</span>
            </div>
            <div id="smpQuotaChart" class="chart-box chart-box-native" role="img" aria-label="Grafik penggunaan kuota SMP">
                <div class="quota-chart-list">
                    @forelse($dashboard['quota']['labels'] as $index => $label)
                        @php
                            $used = $dashboard['quota']['used'][$index] ?? 0;
                            $available = $dashboard['quota']['available'][$index] ?? 0;
                            $totalQuota = max($used + $available, 1);
                            $usedWidth = ($used / $totalQuota) * 100;
                            $availableWidth = max(0, 100 - $usedWidth);
                        @endphp
                        <div class="quota-chart-row">
                            <span class="quota-label">{{ $label }}</span>
                            <span class="quota-stack" title="{{ $used }} terpakai, {{ $available }} tersisa">
                                <span class="quota-used" style="width: {{ $usedWidth }}%;"></span>
                                <span class="quota-open" style="width: {{ $availableWidth }}%;"></span>
                            </span>
                            <span class="quota-value">{{ number_format($used) }}/{{ number_format($totalQuota) }}</span>
                        </div>
                    @empty
                        <div class="empty-chart">Belum ada data kuota.</div>
                    @endforelse
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-swatch" style="background: #0f5f4a;"></span>Terpakai</span>
                    <span class="legend-item"><span class="legend-swatch" style="background: #c89b3c;"></span>Tersisa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="analytics-grid">
        <div class="heatmap-card">
            <div class="chart-heading">
                <h5><i class="fas fa-table-cells me-2"></i>Heatmap Waktu Pendaftaran</h5>
                <span class="badge bg-success">{{ $dashboard['period'] }} Hari</span>
            </div>
            <div class="heatmap" aria-label="Heatmap waktu pendaftaran SMP">
                <div class="heatmap-header">
                    <span></span>
                    @foreach($dashboard['heatmap']['slots'] as $slot)
                        <span>{{ $slot }}</span>
                    @endforeach
                </div>
                @foreach($dashboard['heatmap']['rows'] as $row)
                    <div class="heatmap-row">
                        <span class="heatmap-day">{{ $row['label'] }}</span>
                        @foreach($row['cells'] as $cell)
                            @php
                                $alpha = 0.07 + ($cell['intensity'] * 0.78);
                                $textColor = $cell['intensity'] > 0.55 ? '#ffffff' : '#14201d';
                            @endphp
                            <span class="heatmap-cell"
                                  title="{{ $row['label'] }} {{ $cell['label'] }}: {{ $cell['count'] }} pendaftaran"
                                  style="background: rgba(15, 95, 74, {{ $alpha }}); color: {{ $textColor }};">
                                {{ $cell['count'] }}
                            </span>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="activity-card">
            <h5 class="analytics-title"><i class="fas fa-bell me-2"></i>Perlu Perhatian</h5>
            <div class="quota-alerts">
                @forelse($dashboard['quota_alerts'] as $alert)
                    <div class="quota-alert">
                        <span>{{ $alert['label'] }}</span>
                        <strong>{{ $alert['available'] }} sisa · {{ $alert['percentage'] }}%</strong>
                    </div>
                @empty
                    <div class="activity-meta">Semua kuota masih dalam kondisi aman.</div>
                @endforelse
            </div>

            <h5 class="analytics-title mt-4"><i class="fas fa-clock-rotate-left me-2"></i>Aktivitas Terbaru</h5>
            <div class="activity-list">
                @forelse($dashboard['latest'] as $item)
                    <div class="activity-item">
                        <span class="activity-dot {{ $item['status'] }}"></span>
                        <div>
                            <div class="activity-name">{{ $item['name'] }}</div>
                            <div class="activity-meta">{{ $item['registration_number'] }} · {{ $item['choice'] }}</div>
                        </div>
                        <span class="activity-meta">{{ $item['time'] }}</span>
                    </div>
                @empty
                    <div class="activity-meta">Belum ada aktivitas pendaftaran.</div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- Kuota Cards (SMP) -->
    @if($showQuotas)
    <!-- Quota Modern UI Styles (SMP) -->
    <style>
        .quota-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }
        .quota-stat-mini {
            background: #ffffff;
            border: 1px solid rgba(37, 99, 235, 0.12);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 12px rgba(13, 27, 42, 0.03);
            transition: all 0.3s ease;
        }
        .quota-stat-mini:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 27, 42, 0.06);
        }
        .quota-stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1.25rem;
        }
        .quota-stat-icon-wrap.smp-blue {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
        }
        .quota-stat-icon-wrap.smp-gold {
            background: rgba(200, 155, 60, 0.1);
            color: #c89b3c;
        }
        .quota-stat-icon-wrap.smp-red {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }
        .quota-stat-info {
            display: flex;
            flex-direction: column;
        }
        .quota-stat-label {
            font-size: 0.78rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .quota-stat-number {
            font-size: 1.35rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.2;
            margin-top: 0.15rem;
        }

        .quota-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .quota-modern-card {
            background: #ffffff;
            border: 1px solid rgba(37, 99, 235, 0.12);
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(13, 27, 42, 0.03);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .quota-modern-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(13, 27, 42, 0.06);
            border-color: rgba(37, 99, 235, 0.25);
        }
        .quota-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }
        .quota-card-title {
            margin: 0;
            font-family: inherit;
            font-size: 1.15rem;
            font-weight: 900;
            color: #0f172a;
        }
        .quota-edit-btn {
            background: none;
            border: 0;
            color: #64748b;
            font-size: 1rem;
            cursor: pointer;
            padding: 0.35rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .quota-edit-btn:hover {
            background: rgba(37, 99, 235, 0.08);
            color: #2563eb;
        }
        .quota-card-metric {
            margin-bottom: 0.85rem;
        }
        .quota-metric-sisa {
            font-size: 1.25rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 0.15rem;
        }
        .quota-metric-desc {
            font-size: 0.82rem;
            color: #64748b;
            font-weight: 700;
        }
        .quota-progress-container {
            margin-bottom: 1rem;
        }
        .quota-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 0.35rem;
        }
        .quota-progress-bar-wrap {
            height: 8px;
            background: #f1f5f9;
            border-radius: 999px;
            overflow: hidden;
        }
        .quota-progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .quota-progress-fill.available {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
        }
        .quota-progress-fill.low {
            background: #d97706;
        }
        .quota-progress-fill.full {
            background: #dc2626;
        }
        
        .quota-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.85rem;
            border-top: 1px solid #f1f5f9;
            margin-top: auto;
        }
        .quota-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 900;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .quota-pill.available {
            background: #ecfdf5;
            color: #065f46;
        }
        .quota-pill.low {
            background: #fffbeb;
            color: #92400e;
        }
        .quota-pill.full {
            background: #fef2f2;
            color: #991b1b;
        }

        /* Timeline Styles */
        .timeline-card {
            border: 1px solid rgba(37, 99, 235, 0.12);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(13, 27, 42, 0.03);
            margin-top: 2rem;
            overflow: hidden;
        }
        .timeline-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .timeline-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 900;
            color: #0f172a;
        }
        .timeline-body {
            padding: 1.5rem;
        }
        .timeline-list {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-list::before {
            content: '';
            position: absolute;
            top: 4px;
            bottom: 4px;
            left: 7px;
            width: 2px;
            background: #e2e8f0;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        .timeline-badge {
            position: absolute;
            left: -2rem;
            top: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #2563eb;
            z-index: 2;
            display: block;
        }
        .timeline-badge.verify { border-color: #10b981; }
        .timeline-badge.reject { border-color: #ef4444; }
        .timeline-badge.update { border-color: #3b82f6; }
        .timeline-badge.quota { border-color: #f59e0b; }
        
        .timeline-content-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.85rem 1.15rem;
            transition: all 0.2s ease;
        }
        .timeline-content-box:hover {
            background: #ffffff;
            border-color: rgba(37, 99, 235, 0.2);
            box-shadow: 0 4px 12px rgba(13, 27, 42, 0.04);
        }
        .timeline-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 800;
            margin-bottom: 0.25rem;
            flex-wrap: wrap;
            gap: 0.45rem;
        }
        .timeline-user {
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .timeline-date {
            font-weight: 700;
        }
        .timeline-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            margin: 0 0 0.15rem;
        }
        .timeline-desc {
            font-size: 0.88rem;
            color: #475569;
            margin: 0;
            line-height: 1.45;
        }
        .timeline-properties {
            margin-top: 0.45rem;
            font-size: 0.78rem;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid #e2e8f0;
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
            font-family: monospace;
            color: #2563eb;
        }
        .timeline-footer-meta {
            display: flex;
            gap: 0.75rem;
            font-size: 0.74rem;
            color: #64748b;
            margin-top: 0.35rem;
            font-weight: 700;
        }
        .timeline-empty {
            padding: 2.5rem;
            text-align: center;
            color: #64748b;
            font-weight: 800;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h4 class="mb-0 fw-bold" style="color: #0f172a;"><i class="fas fa-chart-bar me-2"></i>Kuota Pendaftaran per Program Sekolah</h4>
        <span class="badge bg-light text-primary fw-bold" style="padding: 0.5rem 1rem; border: 1px solid rgba(37, 99, 235, 0.12);">Update Otomatis</span>
    </div>

    <!-- Quota Stats Panel -->
    <div class="quota-stats-grid">
        @php
            $totalQuotaVal = $quotas->sum('quota');
            $totalUsedVal = $quotas->sum('used_quota');
            $totalAvailableVal = max(0, $totalQuotaVal - $totalUsedVal);
            $globalPercentage = $totalQuotaVal > 0 ? round(($totalUsedVal / $totalQuotaVal) * 100) : 0;
        @endphp
        <div class="quota-stats-grid w-100">
            <div class="quota-stat-mini">
                <div class="quota-stat-icon-wrap smp-blue"><i class="fas fa-school"></i></div>
                <div class="quota-stat-info">
                    <span class="quota-stat-label">Total Kuota SMP</span>
                    <span class="quota-stat-number">{{ number_format($totalQuotaVal) }} Kursi</span>
                </div>
            </div>
            <div class="quota-stat-mini">
                <div class="quota-stat-icon-wrap smp-gold"><i class="fas fa-user-check"></i></div>
                <div class="quota-stat-info">
                    <span class="quota-stat-label">Total Terpakai</span>
                    <span class="quota-stat-number">{{ number_format($totalUsedVal) }} ({{ $globalPercentage }}%)</span>
                </div>
            </div>
            <div class="quota-stat-mini">
                <div class="quota-stat-icon-wrap smp-red"><i class="fas fa-user-plus"></i></div>
                <div class="quota-stat-info">
                    <span class="quota-stat-label">Sisa Kuota Kosong</span>
                    <span class="quota-stat-number">{{ number_format($totalAvailableVal) }} Kursi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quota Cards Grid -->
    <div class="quota-cards-grid">
        @foreach($quotas as $quota)
        @php
            $status = $quota->status;
            $percent = min($quota->percentage, 100);
        @endphp
        <div class="quota-modern-card">
            <div class="quota-card-header">
                <h6 class="quota-card-title">{{ $quota->school_program }}</h6>
                <button type="button" class="quota-edit-btn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editQuotaModal"
                        data-program="{{ $quota->school_program }}"
                        data-quota="{{ $quota->quota }}"
                        data-used="{{ $quota->used_quota }}"
                        title="Edit Kuota {{ $quota->school_program }}">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </div>
            
            <div class="quota-card-metric">
                <div class="quota-metric-sisa">{{ $quota->available_quota }} Kursi</div>
                <div class="quota-metric-desc">Sisa kapasitas program</div>
            </div>

            <div class="quota-progress-container">
                <div class="quota-progress-label">
                    <span>Terisi: {{ $quota->used_quota }}</span>
                    <span>{{ round($quota->percentage) }}%</span>
                </div>
                <div class="quota-progress-bar-wrap">
                    <div class="quota-progress-fill {{ $status }}" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <div class="quota-card-footer">
                <span class="text-small text-muted fw-bold">Kapasitas: {{ $quota->quota }}</span>
                <span class="quota-pill {{ $status }}">
                    @if($status === 'full')
                        Penuh
                    @elseif($status === 'low')
                        Sisa Sedikit
                    @else
                        Tersedia
                    @endif
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Live Audit Log / Log Aktivitas Admin (SMP) -->
    <div class="timeline-card">
        <div class="timeline-header">
            <h5><i class="fas fa-history me-1"></i>Log Aktivitas Admin Terbaru (SMP)</h5>
            <span class="badge bg-secondary">Real-time</span>
        </div>
        <div class="timeline-body">
            @if(isset($auditLogs) && $auditLogs->count() > 0)
                <div class="timeline-list">
                    @foreach($auditLogs as $log)
                        @php
                            $badgeClass = 'update';
                            if (str_contains($log->event, 'verified')) $badgeClass = 'verify';
                            elseif (str_contains($log->event, 'rejected') || str_contains($log->event, 'deleted')) $badgeClass = 'reject';
                            elseif (str_contains($log->event, 'quota_updated')) $badgeClass = 'quota';
                        @endphp
                        <div class="timeline-item">
                            <span class="timeline-badge {{ $badgeClass }}"></span>
                            <div class="timeline-content-box">
                                <div class="timeline-meta">
                                    <span class="timeline-user">
                                        <i class="fas fa-user-shield"></i> {{ $log->user_name ?: 'System' }} 
                                        <small class="text-muted">({{ $log->user_role ?: 'User' }})</small>
                                    </span>
                                    <span class="timeline-date">
                                        {{ $log->occurred_at?->timezone('Asia/Jakarta')->format('d M Y - H:i') }} WIB
                                    </span>
                                </div>
                                <h6 class="timeline-title">{{ $log->description }}</h6>
                                @if($log->subject_label)
                                    <p class="timeline-desc"><strong>Subjek:</strong> {{ $log->subject_label }}</p>
                                @endif
                                @if($log->properties)
                                    <div class="timeline-properties">
                                        @foreach($log->properties as $key => $val)
                                            <div><strong>{{ $key }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="timeline-footer-meta">
                                    <span>IP: {{ $log->ip_address ?: 'local' }}</span>
                                    @if($log->user_agent)
                                        <span class="text-truncate d-inline-block" style="max-width: 320px;" title="{{ $log->user_agent }}">UA: {{ $log->user_agent }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($auditLogs->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $auditLogs->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="timeline-empty">
                    <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                    <p class="mb-0 text-muted">Belum ada aktivitas admin yang tercatat untuk panel ini.</p>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Search Form -->
    @if($showApplicants)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-search me-2"></i>Cari Pendaftar
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.smp.search') }}" method="GET" class="row g-3">
                        <div class="col-md-2">
                            <input type="text" name="registration_number" class="form-control"
                                   placeholder="Nomor Pendaftaran" value="{{ request('registration_number') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="nik" class="form-control"
                                   placeholder="NIK Siswa" value="{{ request('nik') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="full_name" class="form-control"
                                   placeholder="Nama Lengkap" value="{{ request('full_name') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.smp.export.excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </a>
                <button class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row" id="data-pendaftar">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-table me-2"></i>Data Pendaftar
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nomor Pendaftaran</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>Jenis Sekolah</th>
                                    <th>No. HP</th>
                                    <th>Waktu Daftar</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applicants as $index => $applicant)
                                <tr>
                                    <td>{{ $applicants->firstItem() + $index }}</td>
                                    <td><strong>{{ $applicant->registration_number }}</strong></td>
                                    <td>{{ $applicant->full_name }}</td>
                                    <td>{{ $applicant->nik }}</td>
                                    <td>{{ $applicant->school_program }}</td>
                                    <td>{{ $applicant->phone }}</td>
                                    <td>
                                        <strong>{{ $applicant->registered_date_label }}</strong>
                                        <div class="text-muted small">{{ $applicant->registered_time_label }}</div>
                                    </td>
                                    <td>
                                        @if($applicant->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($applicant->status == 'verified')
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="admin-row-actions">
                                            <!-- Tombol Hubungi WA -->
                                            @php 
                                                $waPhone = preg_replace('/^08/', '628', preg_replace('/[^0-9]/', '', $applicant->phone)); 
                                            @endphp
                                            <a href="https://wa.me/{{ $waPhone }}" target="_blank"
                                               class="btn btn-action" style="background: #25D366; color: white; padding: 0.375rem 0.75rem;"
                                               title="Hubungi via WA">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>

                                            <!-- Tombol Lihat Berkas -->
                                            <a href="{{ route('admin.smp.documents', $applicant->id) }}"
                                               class="btn btn-primary btn-action"
                                               title="Lihat Berkas">
                                                <i class="fas fa-folder"></i>
                                            </a>

                                            <!-- Tombol Lihat Detail -->
                                            <a href="{{ route('admin.smp.print', $applicant->id) }}"
                                               class="btn btn-info btn-action"
                                               title="Lihat Detail" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Tombol Edit (SELALU MUNCUL) -->
                                            <a href="{{ route('admin.smp.edit', $applicant->id) }}"
                                               class="btn btn-warning btn-action"
                                               title="Edit Data Pendaftar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete (SELALU MUNCUL) -->
                                            <form action="{{ route('admin.smp.delete', $applicant->id) }}"
                                                  method="POST"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Hapus pendaftaran ini?\n\nData akan dihapus PERMANEN dan siswa dapat mendaftar ulang dengan NIK yang sama.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-action"
                                                        title="Hapus Pendaftaran">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.smp.status.update', $applicant->id) }}" method="POST" class="admin-status-form"
                                                  onsubmit="return confirm('Ubah status pendaftar ini?\\n\\nJika status masuk atau keluar dari verified, kuota program akan disesuaikan otomatis.')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="note" value="Diubah melalui tabel data pendaftar admin SMPS.">
                                                <select name="status" aria-label="Ubah status {{ $applicant->full_name }}">
                                                    <option value="pending" {{ $applicant->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="verified" {{ $applicant->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                                    <option value="rejected" {{ $applicant->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                                <button type="submit" class="btn btn-dark btn-action" title="Simpan Status">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada data pendaftar</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2 w-100">
                            <small>
                                Menampilkan {{ $applicants->firstItem() }} - {{ $applicants->lastItem() }} dari {{ $applicants->total() }} data
                            </small>
                            <div>
                                {{ $applicants->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showGuide)
        @include('admin.partials.guide-smp')
    @endif
</div>

<!-- Modal QR Scanner -->
@if($showApplicants)
<div class="modal fade" id="qrScannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code Scanner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <video id="qr-video" width="100%" height="300" style="border: 2px solid #ccc;"></video>
                    <canvas id="qr-canvas" style="display: none;"></canvas>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Arahkan kamera ke QR Code. Sistem akan otomatis mendeteksi dan redirect.
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Edit Kuota (SMP) -->
<div class="modal fade" id="editQuotaModal" tabindex="-1" aria-labelledby="editQuotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 20px 60px rgba(13, 27, 42, 0.18);">
            <div class="modal-header" style="background: linear-gradient(135deg, #0d1b2a, #1b263b); color: white; border-bottom: 0;">
                <h5 class="modal-title" id="editQuotaModalLabel" style="font-weight: 900;">
                    <i class="fas fa-edit me-1" style="color: #c89b3c;"></i> Edit Kuota Program
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.smp.quotas.update') }}" method="POST" id="editQuotaForm">
                @csrf
                @method('PATCH')
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.85rem; font-weight: 900; color: #64748b;">PROGRAM SEKOLAH</label>
                        <input type="text" class="form-control" id="modalQuotaProgram" name="school_program" readonly 
                               style="background-color: #f1f5f9; border-radius: 10px; font-weight: 800; color: #0f172a;">
                    </div>
                    <div class="mb-3">
                        <label for="modalQuotaInput" class="form-label" style="font-size: 0.85rem; font-weight: 900; color: #64748b;">JUMLAH KUOTA BARU</label>
                        <input type="number" class="form-control" id="modalQuotaInput" name="quota" required min="0"
                               style="border-radius: 10px; padding: 0.6rem; border: 1px solid #cbd5e1;">
                        <div class="form-text text-muted" id="modalQuotaHelp" style="font-size: 0.78rem; font-weight: 700; margin-top: 0.25rem;">
                            Kuota saat ini digunakan: <span id="modalQuotaUsed" class="badge bg-secondary">0</span>
                        </div>
                    </div>
                    <div class="alert alert-warning" style="border-radius: 12px; font-size: 0.82rem; font-weight: 700; display: flex; align-items: start; gap: 0.5rem; border: 1px solid #fef3c7; background: #fffbeb; color: #92400e;">
                        <i class="fas fa-exclamation-triangle mt-1"></i>
                        <span>Catatan: Segala perubahan kuota akan dicatat di log aktivitas admin. Pastikan jumlah kuota baru tidak lebih kecil dari kuota yang sudah terpakai.</span>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            style="border-radius: 10px; font-weight: 800; padding: 0.55rem 1rem;">Batal</button>
                    <button type="submit" class="btn btn-primary" 
                            style="background: #2563eb; border: 0; border-radius: 10px; font-weight: 800; padding: 0.55rem 1.25rem; color: white;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editQuotaModal = document.getElementById('editQuotaModal');
    if (editQuotaModal) {
        editQuotaModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const program = button.getAttribute('data-program');
            const quota = button.getAttribute('data-quota');
            const used = button.getAttribute('data-used');

            const modalProgram = editQuotaModal.querySelector('#modalQuotaProgram');
            const modalInput = editQuotaModal.querySelector('#modalQuotaInput');
            const modalUsed = editQuotaModal.querySelector('#modalQuotaUsed');

            if (modalProgram) modalProgram.value = program;
            if (modalInput) {
                modalInput.value = quota;
                modalInput.min = used;
            }
            if (modalUsed) modalUsed.textContent = used;
        });
    }
});
</script>
@endpush

