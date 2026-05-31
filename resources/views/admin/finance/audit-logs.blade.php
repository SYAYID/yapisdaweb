@extends('layouts.admin')

@section('title', 'Audit Log Sistem - YAPISDA')

@push('styles')
<style>
.audit-page { display: grid; gap: 1rem; }
.audit-header {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1.35rem 1.5rem;
    border-radius: 18px;
    color: #fff;
    background: linear-gradient(135deg, var(--brand-800), var(--brand));
    box-shadow: var(--shadow-md);
}
.audit-header h1 { margin: 0; font-size: clamp(1.35rem, 2vw, 1.8rem); font-weight: 900; }
.audit-header p { margin: .35rem 0 0; color: rgba(255,255,255,.72); font-weight: 700; }
.audit-filter { display: flex; gap: .55rem; flex-wrap: wrap; align-items: center; }
.audit-filter input, .audit-filter select, .audit-filter button {
    min-height: 42px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,.18);
    padding: .55rem .8rem;
    font-weight: 800;
}
.audit-filter input, .audit-filter select { background: #fff; color: var(--ink); }
.audit-filter button { background: var(--gold-soft); color: var(--brand-800); }
.audit-panel {
    overflow: hidden;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: #fff;
    box-shadow: var(--shadow-sm);
}
.audit-table-wrap { overflow-x: auto; }
.audit-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: .88rem; }
.audit-table th {
    padding: .8rem .9rem;
    background: var(--brand-800);
    color: #fff;
    font-size: .72rem;
    letter-spacing: .06em;
    text-transform: uppercase;
    white-space: nowrap;
}
.audit-table td { padding: .85rem .9rem; border-bottom: 1px solid var(--line); vertical-align: top; }
.audit-table tr:last-child td { border-bottom: 0; }
.audit-event {
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
.audit-muted { color: var(--muted); font-size: .78rem; font-weight: 700; }
.audit-desc strong { display: block; color: var(--ink); font-weight: 900; }
.audit-desc span { color: var(--muted); font-size: .8rem; font-weight: 700; }
.audit-empty { padding: 2rem; text-align: center; color: var(--muted); font-weight: 800; }
</style>
@endpush

@section('admin_content')
<div class="audit-page">
    <header class="audit-header">
        <div>
            <h1><i class="fas fa-clock-rotate-left me-2"></i>Audit Log Sistem</h1>
            <p>Jejak aktivitas penting: transaksi, NIS, cetak kartu, kwitansi, dan export laporan.</p>
        </div>
        <form class="audit-filter" action="{{ route('admin.finance.audit-logs') }}" method="GET">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari aktivitas, user, referensi">
            <select name="event">
                <option value="">Semua Event</option>
                @foreach($events as $eventOption)
                    <option value="{{ $eventOption }}" {{ $event === $eventOption ? 'selected' : '' }}>{{ $eventOption }}</option>
                @endforeach
            </select>
            <button type="submit"><i class="fas fa-filter me-1"></i>Filter</button>
        </form>
    </header>

    <section class="audit-panel">
        <div class="audit-table-wrap">
            <table class="audit-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Subjek</th>
                        <th>Deskripsi</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <strong>{{ $log->occurred_at?->timezone('Asia/Jakarta')->format('d/m/Y') }}</strong>
                            <div class="audit-muted">{{ $log->occurred_at?->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            <strong>{{ $log->user_name ?: '-' }}</strong>
                            <div class="audit-muted">{{ $log->user_role ?: '-' }}</div>
                        </td>
                        <td><span class="audit-event">{{ $log->event }}</span></td>
                        <td>
                            <strong>{{ $log->subject_label ?: '-' }}</strong>
                            <div class="audit-muted">{{ class_basename($log->subject_type ?: '') }}</div>
                        </td>
                        <td class="audit-desc">
                            <strong>{{ $log->description }}</strong>
                            @if($log->properties)
                                <span>{{ collect($log->properties)->map(fn($value, $key) => $key . ': ' . (is_array($value) ? json_encode($value) : $value))->implode(' | ') }}</span>
                            @endif
                        </td>
                        <td class="audit-muted">{{ $log->ip_address ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="audit-empty">Belum ada audit log.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-3">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</div>
@endsection
