@extends('layouts.admin')

@section('title', 'Laporan Daftar Ulang Final - YAPISDA')

@push('styles')
<style>
.final-page { display: grid; gap: 1rem; }
.final-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.35rem 1.5rem;
    border-radius: 18px;
    color: #fff;
    background: linear-gradient(135deg, var(--brand-800), var(--brand));
    box-shadow: var(--shadow-md);
}
.final-header h1 { margin: 0; font-size: clamp(1.35rem, 2vw, 1.8rem); font-weight: 900; }
.final-header p { margin: 0.35rem 0 0; color: rgba(255,255,255,.72); font-weight: 700; }
.final-actions { display: flex; gap: .55rem; flex-wrap: wrap; }
.final-actions a, .final-actions button, .final-actions select {
    min-height: 42px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,.18);
    padding: .55rem .8rem;
    font-weight: 900;
}
.final-actions a, .final-actions button {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: var(--gold-soft);
    color: var(--brand-800);
    text-decoration: none;
}
.final-actions select { background: #fff; color: var(--ink); }
.final-kpis {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
}
.final-kpi, .final-panel {
    border: 1px solid var(--line);
    border-radius: 16px;
    background: #fff;
    box-shadow: var(--shadow-sm);
}
.final-kpi { padding: 1rem; display: grid; gap: .35rem; }
.final-kpi span { color: var(--muted); font-size: .74rem; font-weight: 900; text-transform: uppercase; }
.final-kpi strong { color: var(--brand-800); font-family: var(--ff-display); font-size: 1.7rem; font-weight: 900; }
.final-panel { overflow: hidden; }
.final-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.15rem;
    border-bottom: 1px solid var(--line);
    background: linear-gradient(180deg, #fbfdfc, #fff);
}
.final-panel-head h2 { margin: 0; color: var(--ink); font-size: 1rem; font-weight: 900; }
.final-table-wrap { overflow-x: auto; }
.final-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: .88rem; }
.final-table th {
    padding: .8rem .9rem;
    background: var(--brand-800);
    color: #fff;
    font-size: .72rem;
    letter-spacing: .06em;
    text-transform: uppercase;
    white-space: nowrap;
}
.final-table td { padding: .85rem .9rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
.final-table tr:last-child td { border-bottom: 0; }
.final-pill {
    display: inline-flex;
    min-height: 28px;
    align-items: center;
    border-radius: 999px;
    padding: 0 .65rem;
    background: var(--mint);
    color: var(--brand);
    font-size: .75rem;
    font-weight: 900;
    white-space: nowrap;
}
.final-muted { color: var(--muted); font-size: .8rem; font-weight: 700; }
.final-link {
    min-height: 34px;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    border-radius: 999px;
    padding: .38rem .72rem;
    background: var(--brand);
    color: #fff;
    font-size: .76rem;
    font-weight: 900;
    text-decoration: none;
    white-space: nowrap;
}
.final-link:hover { color: #fff; }
.final-letter-stack { display: flex; gap: .35rem; flex-wrap: wrap; margin-top: .35rem; }
.final-letter-link {
    min-height: 30px;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    border-radius: 999px;
    padding: .32rem .58rem;
    border: 1px solid var(--line);
    background: #fbfdfc;
    color: var(--brand);
    font-size: .7rem;
    font-weight: 900;
    text-decoration: none;
}
.final-letter-link:hover { color: var(--brand-800); background: var(--mint); }
.final-empty { padding: 2rem; text-align: center; color: var(--muted); font-weight: 800; }
@media (max-width: 900px) { .final-kpis { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 560px) { .final-kpis { grid-template-columns: 1fr; } }
</style>
@endpush

@section('admin_content')
@php
    $rupiah = fn($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
@endphp

<div class="final-page">
    <header class="final-header">
        <div>
            <h1><i class="fas fa-clipboard-check me-2"></i>Laporan Daftar Ulang Final</h1>
            <p>Siswa yang sudah verified, seragam lunas, dan sudah memiliki NIS.</p>
        </div>
        <form class="final-actions" action="{{ route('admin.finance.final-report') }}" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIS, No. Daftar..." 
                   style="min-height: 42px; border-radius: 10px; border: 1px solid rgba(255,255,255,.18); padding: .55rem .8rem; font-weight: 700; background: #fff; color: #000;">
            <select name="unit">
                <option value="">Semua Unit</option>
                <option value="smk" {{ $unit === 'smk' ? 'selected' : '' }}>SMKS</option>
                <option value="smp" {{ $unit === 'smp' ? 'selected' : '' }}>SMPS</option>
            </select>
            <button type="submit"><i class="fas fa-filter"></i> Filter</button>
            @if(request('search') || request('unit'))
                <a href="{{ route('admin.finance.final-report') }}" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2);"><i class="fas fa-undo"></i> Reset</a>
            @endif
            <a href="{{ route('admin.finance.final-report.export', request()->only(['unit', 'search'])) }}">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </form>
    </header>

    <section class="final-kpis">
        <div class="final-kpi">
            <span>Total Siswa Final</span>
            <strong>{{ number_format($summary['total_students'], 0, ',', '.') }}</strong>
        </div>
        <div class="final-kpi">
            <span>SMKS</span>
            <strong>{{ number_format($summary['smk_students'], 0, ',', '.') }}</strong>
        </div>
        <div class="final-kpi">
            <span>SMPS</span>
            <strong>{{ number_format($summary['smp_students'], 0, ',', '.') }}</strong>
        </div>
        <div class="final-kpi">
            <span>Total Seragam Masuk</span>
            <strong>{{ $rupiah($summary['paid_total']) }}</strong>
        </div>
    </section>

    <section class="final-panel">
        <div class="final-panel-head">
            <h2><i class="fas fa-table me-2"></i>Data Siswa Final</h2>
            <span class="final-muted">Tagihan wajib {{ $rupiah($uniformType->default_amount) }}</span>
        </div>
        <div class="final-table-wrap">
            <table class="final-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>NIS</th>
                        <th>No. Daftar</th>
                        <th>Nama</th>
                        <th>Jurusan/Program</th>
                        <th>No. HP</th>
                        <th>Waktu Daftar</th>
                        <th>Waktu Lunas</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                    <tr>
                        <td><span class="final-pill">{{ $row['unit'] }}</span></td>
                        <td><strong>{{ $row['student_identification_number'] }}</strong></td>
                        <td>{{ $row['registration_number'] }}</td>
                        <td><strong>{{ $row['name'] }}</strong></td>
                        <td>{{ $row['choice'] }}</td>
                        <td>{{ $row['phone'] }}</td>
                        <td>{{ $row['registered_at'] }}</td>
                        <td>{{ $row['paid_at'] }}</td>
                        <td><strong>{{ $rupiah($row['paid_amount']) }}</strong></td>
                        <td>
                            @if($row['latest_transaction_id'])
                                <a class="final-link" href="{{ route('admin.finance.student-card', $row['latest_transaction_id']) }}" target="_blank" rel="noopener">
                                    <i class="fas fa-id-card"></i>Kartu
                                </a>
                            @endif
                            <div class="final-letter-stack">
                                <a class="final-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'accepted']) }}" target="_blank" rel="noopener">Diterima</a>
                                <a class="final-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'reenrollment']) }}" target="_blank" rel="noopener">Administrasi</a>
                                <a class="final-letter-link" href="{{ route('admin.finance.letters.print', [$row['type'], $row['student_id'], 'parent-call']) }}" target="_blank" rel="noopener">Panggilan</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="final-empty">Belum ada siswa yang masuk laporan final.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
