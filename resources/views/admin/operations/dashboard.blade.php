@extends('layouts.admin')

@push('styles')
<style>
.ops-wrapper {
    display: grid;
    gap: 1rem;
}

.ops-header {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    align-items: flex-start;
    padding: 1.25rem;
    border: 1px solid var(--line);
    border-radius: 8px;
    background: linear-gradient(135deg, #ffffff 0%, #f4faf7 100%);
    box-shadow: var(--shadow-sm);
}

.ops-header h1 {
    margin: 0;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: clamp(1.35rem, 2vw, 2rem);
    font-weight: 900;
}

.ops-header p {
    margin: 0.35rem 0 0;
    max-width: 760px;
    color: var(--muted);
    font-weight: 700;
}

.ops-header-actions,
.ops-filter,
.ops-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.65rem;
    align-items: center;
}

.ops-button,
.ops-link {
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.65rem 0.85rem;
    border: 0;
    border-radius: 8px;
    background: var(--brand-700);
    color: #fff;
    text-decoration: none;
    font-weight: 900;
    cursor: pointer;
}

.ops-link.secondary,
.ops-button.secondary {
    background: #eef5f2;
    color: var(--brand-800);
}

.ops-kpi-grid,
.ops-card-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.85rem;
}

.ops-kpi,
.ops-panel,
.ops-card {
    border: 1px solid var(--line);
    border-radius: 8px;
    background: #fff;
    box-shadow: var(--shadow-sm);
}

.ops-kpi {
    padding: 1rem;
}

.ops-kpi span,
.ops-card small,
.ops-muted {
    color: var(--muted);
    font-size: 0.78rem;
    font-weight: 800;
}

.ops-kpi strong {
    display: block;
    margin-top: 0.25rem;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: 1.45rem;
    font-weight: 900;
}

.ops-panel-header {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid var(--line);
}

.ops-panel-header h2 {
    margin: 0;
    color: var(--brand-800);
    font-size: 1rem;
    font-weight: 900;
}

.ops-panel-body {
    padding: 1rem;
}

.ops-table-wrap {
    overflow-x: auto;
}

.ops-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.ops-table th,
.ops-table td {
    padding: 0.75rem;
    border-bottom: 1px solid var(--line);
    text-align: left;
    vertical-align: top;
    font-size: 0.86rem;
}

.ops-table th {
    color: var(--brand-800);
    background: #f7fbf9;
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.ops-field,
.ops-filter input,
.ops-filter select,
.ops-table input,
.ops-table select,
.ops-table textarea,
.ops-form-grid input,
.ops-form-grid select,
.ops-form-grid textarea {
    width: 100%;
    min-height: 38px;
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 0.55rem 0.65rem;
    background: #fff;
    color: var(--text);
    font-weight: 700;
}

.ops-form-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.8rem;
}

.ops-form-grid .wide {
    grid-column: span 2;
}

.ops-form-grid .full {
    grid-column: 1 / -1;
}

.ops-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.55rem;
    border-radius: 999px;
    background: #eef5f2;
    color: var(--brand-800);
    font-size: 0.74rem;
    font-weight: 900;
}

.ops-pill.ok {
    background: #dcfce7;
    color: #166534;
}

.ops-pill.warn {
    background: #fef3c7;
    color: #92400e;
}

.ops-pill.danger {
    background: #fee2e2;
    color: #991b1b;
}

.ops-progress {
    height: 9px;
    overflow: hidden;
    border-radius: 999px;
    background: #e5e7eb;
}

.ops-progress i {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, var(--brand-700), var(--gold));
}

.ops-card {
    display: grid;
    gap: 0.5rem;
    padding: 1rem;
    text-decoration: none;
    color: var(--text);
}

.ops-card i {
    color: var(--gold);
    font-size: 1.35rem;
}

.ops-card strong {
    color: var(--brand-800);
    font-weight: 900;
}

.ops-doc-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    min-width: 260px;
}

.ops-doc-grid a {
    text-decoration: none;
}

.ops-empty {
    padding: 1rem;
    color: var(--muted);
    text-align: center;
    font-weight: 800;
}

@media (max-width: 1100px) {
    .ops-kpi-grid,
    .ops-card-grid,
    .ops-form-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 700px) {
    .ops-header {
        flex-direction: column;
    }

    .ops-kpi-grid,
    .ops-card-grid,
    .ops-form-grid {
        grid-template-columns: 1fr;
    }

    .ops-form-grid .wide {
        grid-column: auto;
    }
}
</style>
@endpush

@section('admin_content')
@php
    $titles = [
        'dashboard' => ['Dashboard Operasional', 'Ringkasan siswa aktif, checklist final, stok seragam, arsip dokumen, dan kondisi sistem.'],
        'executive-dashboard' => ['Dashboard Kepala Sekolah/Yayasan', 'Ringkasan strategis untuk memantau kesiapan peserta didik dan operasional daftar ulang.'],
        'active-students' => ['Master Data Siswa Aktif', 'Data siswa final yang sudah masuk daftar operasional sekolah.'],
        'uniform-stock' => ['Manajemen Stok Seragam', 'Pantau stok, kebutuhan berdasarkan ukuran, dan barang yang perlu ditambah.'],
        'final-checklist' => ['Checklist Berkas & Status Final', 'Kontrol akhir sebelum siswa dinyatakan siap masuk data operasional sekolah.'],
        'official-exports' => ['Export Data Resmi', 'Unduh data resmi untuk arsip sekolah, rapat, dan kebutuhan administrasi.'],
        'archive-center' => ['Pusat Arsip Dokumen', 'Periksa keberadaan file upload pendaftar tanpa membuka folder server satu per satu.'],
        'health' => ['Backup & Health Check Sistem', 'Cek kesiapan database, storage, arsip file, dan backup operasional.'],
        'guide' => ['Panduan Alur Operasional', 'Petunjuk langkah-demi-langkah penggunaan modul-modul pada panel operasional.'],
    ];
    [$pageTitle, $pageSubtitle] = $titles[$section] ?? $titles['dashboard'];
    $rupiah = fn($value) => 'Rp ' . number_format((int) $value, 0, ',', '.');
    $activeLabels = ['active' => 'Aktif', 'hold' => 'Ditahan', 'inactive' => 'Nonaktif', 'graduated' => 'Lulus'];
    $finalLabels = ['needs_review' => 'Perlu Dicek', 'ready' => 'Siap Final', 'finalized' => 'Final', 'blocked' => 'Tertahan'];
    $finalTone = ['needs_review' => 'warn', 'ready' => 'ok', 'finalized' => 'ok', 'blocked' => 'danger'];
    $healthTone = ['ok' => 'ok', 'warning' => 'warn', 'danger' => 'danger'];
@endphp

<div class="ops-wrapper">
    <header class="ops-header">
        <div>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageSubtitle }}</p>
        </div>
        <div class="ops-header-actions">
            <a class="ops-link secondary" href="{{ route('admin.operations.executive-dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard Yayasan</a>
            <a class="ops-link" href="{{ route('admin.operations.official-exports') }}"><i class="fas fa-file-export"></i> Export Resmi</a>
        </div>
    </header>

    <section class="ops-kpi-grid">
        <div class="ops-kpi">
            <span>Siswa Aktif</span>
            <strong>{{ number_format($summary['active_total'], 0, ',', '.') }}</strong>
            <small>{{ number_format($summary['eligible_active_total'], 0, ',', '.') }} memenuhi daftar ulang</small>
        </div>
        <div class="ops-kpi">
            <span>Progress Final</span>
            <strong>{{ $summary['final_rate'] }}%</strong>
            <small>{{ number_format($summary['final_ready'], 0, ',', '.') }} siap/final dari {{ number_format($summary['final_total'], 0, ',', '.') }}</small>
        </div>
        <div class="ops-kpi">
            <span>Penerimaan Seragam</span>
            <strong>{{ $rupiah($summary['uniform_collected']) }}</strong>
            <small>Target terverifikasi {{ $rupiah($summary['uniform_target']) }}</small>
        </div>
        <div class="ops-kpi">
            <span>Arsip & Stok</span>
            <strong>{{ number_format($summary['archive_missing'], 0, ',', '.') }}</strong>
            <small>{{ number_format($summary['stock_alerts'], 0, ',', '.') }} stok perlu perhatian</small>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($section === 'dashboard')
    <section class="ops-card-grid">
        <a class="ops-card" href="{{ route('admin.operations.active-students') }}">
            <i class="fas fa-user-graduate"></i>
            <strong>Master Data Siswa Aktif</strong>
            <small>Kelola rombel, status, dan catatan siswa yang sudah final.</small>
        </a>
        <a class="ops-card" href="{{ route('admin.operations.uniform-stock') }}">
            <i class="fas fa-boxes-stacked"></i>
            <strong>Manajemen Stok Seragam</strong>
            <small>Bandingkan kebutuhan ukuran dengan stok tersedia.</small>
        </a>
        <a class="ops-card" href="{{ route('admin.operations.final-checklist') }}">
            <i class="fas fa-list-check"></i>
            <strong>Checklist Status Final</strong>
            <small>Pastikan berkas, administrasi, kartu, dan atribut selesai.</small>
        </a>
        <a class="ops-card" href="{{ route('admin.operations.health') }}">
            <i class="fas fa-shield-heart"></i>
            <strong>Backup & Health Check</strong>
            <small>Periksa storage, dokumen upload, database, dan backup.</small>
        </a>
    </section>
    @endif

    @if($section === 'executive-dashboard' || $section === 'dashboard')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-chart-simple me-2"></i>Distribusi Siswa Final per Program</h2>
            <span class="ops-muted">{{ $summary['program_distribution']->count() }} program teratas</span>
        </div>
        <div class="ops-panel-body">
            <div class="ops-table-wrap">
                <table class="ops-table">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Jumlah</th>
                            <th>Proporsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summary['program_distribution'] as $item)
                        @php $percent = $summary['eligible_active_total'] > 0 ? round(($item['count'] / $summary['eligible_active_total']) * 100, 1) : 0; @endphp
                        <tr>
                            <td><strong>{{ $item['label'] }}</strong></td>
                            <td>{{ number_format($item['count'], 0, ',', '.') }}</td>
                            <td>
                                <div class="ops-progress"><i style="width: {{ $percent }}%;"></i></div>
                                <span class="ops-muted">{{ $percent }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="ops-empty">Belum ada siswa final untuk ditampilkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    @if($section === 'active-students')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-user-graduate me-2"></i>Master Data Siswa Aktif</h2>
            <form action="{{ route('admin.operations.active-students.sync') }}" method="POST">
                @csrf
                <button class="ops-button" type="submit"><i class="fas fa-rotate"></i> Sinkronkan</button>
            </form>
        </div>
        <div class="ops-panel-body">
            <form class="ops-filter" method="GET" action="{{ route('admin.operations.active-students') }}">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, nomor pendaftaran, atau rombel">
                <select name="unit">
                    <option value="">Semua unit</option>
                    <option value="SMKS" @selected(request('unit') === 'SMKS')>SMKS</option>
                    <option value="SMPS" @selected(request('unit') === 'SMPS')>SMPS</option>
                </select>
                <select name="status">
                    <option value="">Semua status</option>
                    @foreach($activeLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="ops-button secondary" type="submit"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>NIS / No. Daftar</th>
                        <th>Nama</th>
                        <th>Program</th>
                        <th>Rombel</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeStudents as $student)
                    @php $formId = 'active-student-' . $student->id; @endphp
                    <tr>
                        <td><span class="ops-pill ok">{{ $student->unit }}</span></td>
                        <td>
                            <strong>{{ $student->student_identification_number ?: '-' }}</strong>
                            <div class="ops-muted">{{ $student->registration_number }}</div>
                        </td>
                        <td><strong>{{ $student->full_name }}</strong></td>
                        <td>{{ $student->program }}</td>
                        <td>
                            <form id="{{ $formId }}" action="{{ route('admin.operations.active-students.update', $student) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                            <input form="{{ $formId }}" type="text" name="class_group" value="{{ $student->class_group }}" placeholder="Contoh: X TJKT 1">
                        </td>
                        <td>
                            <select form="{{ $formId }}" name="status">
                                @foreach($activeLabels as $value => $label)
                                    <option value="{{ $value }}" @selected($student->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><textarea form="{{ $formId }}" name="notes" rows="2" placeholder="Catatan">{{ $student->notes }}</textarea></td>
                        <td><button form="{{ $formId }}" class="ops-button secondary" type="submit"><i class="fas fa-floppy-disk"></i> Simpan</button></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="ops-empty">Belum ada siswa aktif. Klik sinkronkan setelah transaksi daftar ulang lengkap.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

    @if($section === 'uniform-stock')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-boxes-stacked me-2"></i>Input Stok Seragam</h2>
            <span class="ops-muted">{{ number_format($stockItems->count(), 0, ',', '.') }} item stok</span>
        </div>
        <div class="ops-panel-body">
            <form action="{{ route('admin.operations.uniform-stock.store') }}" method="POST" class="ops-form-grid">
                @csrf
                <div class="wide">
                    <label>Nama Barang</label>
                    <input type="text" name="name" placeholder="Contoh: Baju Praktik" required>
                </div>
                <div>
                    <label>Kategori</label>
                    <select name="category" required>
                        @foreach($stockCategories as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Ukuran</label>
                    <input type="text" name="size" placeholder="L / 39 / Paket">
                </div>
                <div><label>Satuan</label><input type="text" name="unit" value="pcs" required></div>
                <div><label>Stok</label><input type="number" name="stock_qty" min="0" value="0" required></div>
                <div><label>Dipesan</label><input type="number" name="reserved_qty" min="0" value="0" required></div>
                <div><label>Diserahkan</label><input type="number" name="distributed_qty" min="0" value="0" required></div>
                <div><label>Minimum</label><input type="number" name="minimum_qty" min="0" value="0" required></div>
                <div class="full"><label>Catatan</label><textarea name="notes" rows="2" placeholder="Keterangan stok, vendor, atau gudang penyimpanan."></textarea></div>
                <div class="full"><button class="ops-button" type="submit"><i class="fas fa-plus"></i> Simpan Stok</button></div>
            </form>
        </div>
    </section>

    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-ruler-combined me-2"></i>Kebutuhan Berdasarkan Ukuran Tercatat</h2>
            <span class="ops-muted">{{ number_format($uniformNeeds->sum('gap'), 0, ',', '.') }} estimasi kekurangan</span>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead><tr><th>Jenis</th><th>Ukuran</th><th>Kebutuhan</th><th>Tersedia</th><th>Selisih</th></tr></thead>
                <tbody>
                    @forelse($uniformNeeds as $need)
                    <tr>
                        <td>{{ $need['label'] }}</td>
                        <td><strong>{{ $need['size'] }}</strong></td>
                        <td>{{ number_format($need['needed'], 0, ',', '.') }}</td>
                        <td>{{ number_format($need['available'], 0, ',', '.') }}</td>
                        <td><span class="ops-pill {{ $need['gap'] > 0 ? 'warn' : 'ok' }}">{{ $need['gap'] > 0 ? number_format($need['gap'], 0, ',', '.') : 'Aman' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="ops-empty">Belum ada ukuran seragam yang tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="ops-panel">
        <div class="ops-panel-header"><h2><i class="fas fa-warehouse me-2"></i>Daftar Stok</h2></div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead><tr><th>Barang</th><th>Kategori</th><th>Ukuran</th><th>Stok</th><th>Dipesan</th><th>Diserahkan</th><th>Tersedia</th><th>Minimum</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($stockItems as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong><div class="ops-muted">{{ $item->notes }}</div></td>
                        <td>{{ $stockCategories[$item->category] ?? $item->category }}</td>
                        <td>{{ $item->size ?: '-' }}</td>
                        <td>{{ number_format($item->stock_qty, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->reserved_qty, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->distributed_qty, 0, ',', '.') }}</td>
                        <td><strong>{{ number_format($item->available_qty, 0, ',', '.') }}</strong></td>
                        <td>{{ number_format($item->minimum_qty, 0, ',', '.') }}</td>
                        <td><span class="ops-pill {{ $item->is_low_stock ? 'warn' : 'ok' }}">{{ $item->is_low_stock ? 'Perlu Ditambah' : 'Aman' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="ops-empty">Belum ada stok seragam.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

    @if($section === 'final-checklist')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-list-check me-2"></i>Checklist Final Siswa Verified</h2>
            <span class="ops-muted">{{ number_format($checklistRows->count(), 0, ',', '.') }} siswa verified</span>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Progress</th>
                        <th>Berkas</th>
                        <th>Administrasi</th>
                        <th>NIS</th>
                        <th>Kartu</th>
                        <th>Ukuran</th>
                        <th>Atribut</th>
                        <th>Status Final</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($checklistRows as $row)
                    @php $formId = 'final-checklist-' . $row['type'] . '-' . $row['student_id']; @endphp
                    <tr>
                        <td>
                            <strong>{{ $row['name'] }}</strong>
                            <div class="ops-muted">{{ $row['unit'] }} - {{ $row['registration_number'] }} - {{ $row['choice'] }}</div>
                        </td>
                        <td>
                            <div class="ops-progress"><i style="width: {{ $row['completion_percent'] }}%;"></i></div>
                            <span class="ops-muted">{{ $row['completion_percent'] }}%</span>
                        </td>
                        @foreach(['documents_complete', 'administration_complete', 'student_number_assigned', 'card_printed', 'uniform_size_recorded', 'attribute_distributed'] as $flag)
                            <td><span class="ops-pill {{ $row[$flag] ? 'ok' : 'warn' }}">{{ $row[$flag] ? 'Ya' : 'Belum' }}</span></td>
                        @endforeach
                        <td>
                            <form id="{{ $formId }}" action="{{ route('admin.operations.final-checklist.update', [$row['type'], $row['student_id']]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                            <select form="{{ $formId }}" name="final_status">
                                @foreach($finalLabels as $value => $label)
                                    <option value="{{ $value }}" @selected($row['final_status'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="mt-1"><span class="ops-pill {{ $finalTone[$row['final_status']] ?? 'warn' }}">{{ $finalLabels[$row['final_status']] ?? $row['final_status'] }}</span></div>
                        </td>
                        <td><textarea form="{{ $formId }}" name="notes" rows="2" placeholder="Catatan final">{{ $row['checklist_notes'] }}</textarea></td>
                        <td><button form="{{ $formId }}" class="ops-button secondary" type="submit"><i class="fas fa-floppy-disk"></i> Simpan</button></td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="ops-empty">Belum ada siswa verified untuk checklist final.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

    @if($section === 'official-exports')
    <section class="ops-card-grid">
        @foreach($exportCards as $card)
            <a class="ops-card" href="{{ route('admin.operations.official-exports.download', $card['type']) }}">
                <i class="fas fa-file-excel"></i>
                <strong>{{ $card['title'] }}</strong>
                <small>{{ $card['body'] }}</small>
            </a>
        @endforeach
    </section>
    @endif

    @if($section === 'archive-center')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-folder-open me-2"></i>Pusat Arsip Dokumen</h2>
            <span class="ops-muted">{{ number_format($archiveRows->count(), 0, ',', '.') }} data tampil</span>
        </div>
        <div class="ops-panel-body">
            <form class="ops-filter" method="GET" action="{{ route('admin.operations.archive-center') }}">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, atau nomor pendaftaran">
                <select name="unit">
                    <option value="">Semua unit</option>
                    <option value="SMKS" @selected(request('unit') === 'SMKS')>SMKS</option>
                    <option value="SMPS" @selected(request('unit') === 'SMPS')>SMPS</option>
                </select>
                <label class="ops-pill"><input type="checkbox" name="problem" value="1" @checked(request()->boolean('problem'))> Hanya bermasalah</label>
                <button class="ops-button secondary" type="submit"><i class="fas fa-search"></i> Terapkan</button>
            </form>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead><tr><th>Siswa</th><th>Status</th><th>Ringkasan</th><th>Dokumen</th></tr></thead>
                <tbody>
                    @forelse($archiveRows as $row)
                    <tr>
                        <td>
                            <strong>{{ $row['name'] }}</strong>
                            <div class="ops-muted">{{ $row['unit'] }} - {{ $row['registration_number'] }} - {{ $row['choice'] }}</div>
                        </td>
                        <td><span class="ops-pill {{ $row['complete'] ? 'ok' : 'warn' }}">{{ $row['complete'] ? 'Lengkap' : 'Perlu Dicek' }}</span></td>
                        <td>
                            <strong>{{ $row['existing_count'] }}</strong> file tersedia
                            <div class="ops-muted">{{ $row['missing_required_count'] }} dokumen wajib belum ditemukan</div>
                        </td>
                        <td>
                            <div class="ops-doc-grid">
                                @foreach($row['documents'] as $document)
                                    @if($document['exists'])
                                        <a class="ops-pill ok" href="{{ $document['preview_url'] }}" target="_blank" rel="noopener">{{ $document['label'] }}</a>
                                    @else
                                        <span class="ops-pill {{ $document['required'] ? 'danger' : 'warn' }}">{{ $document['label'] }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="ops-empty">Tidak ada data arsip sesuai filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

    @if($section === 'health')
    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-shield-heart me-2"></i>Health Check Sistem</h2>
            <span class="ops-muted">{{ $health['app_time'] }}</span>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead><tr><th>Komponen</th><th>Status</th><th>Detail</th></tr></thead>
                <tbody>
                    @foreach($health['checks'] as $check)
                    <tr>
                        <td><strong>{{ $check['label'] }}</strong></td>
                        <td><span class="ops-pill {{ $healthTone[$check['status']] ?? 'warn' }}">{{ strtoupper($check['status']) }}</span></td>
                        <td>{{ $check['detail'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="ops-panel">
        <div class="ops-panel-header">
            <h2><i class="fas fa-database me-2"></i>Backup Operasional</h2>
            <form action="{{ route('admin.operations.backups.store') }}" method="POST">
                @csrf
                <button class="ops-button" type="submit"><i class="fas fa-download"></i> Buat Backup</button>
            </form>
        </div>
        <div class="ops-table-wrap">
            <table class="ops-table">
                <thead><tr><th>Nama</th><th>Waktu</th><th>Ukuran</th><th>Dibuat Oleh</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($backups as $backup)
                    <tr>
                        <td><strong>{{ $backup->name }}</strong><div class="ops-muted">{{ $backup->path }}</div></td>
                        <td>{{ $backup->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
                        <td>{{ number_format($backup->size_bytes / 1024, 1, ',', '.') }} KB</td>
                        <td>{{ $backup->creator?->name ?: '-' }}</td>
                        <td><a class="ops-link secondary" href="{{ route('admin.operations.backups.download', $backup) }}"><i class="fas fa-download"></i> Download</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="ops-empty">Belum ada backup operasional.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @endif

    @if($section === 'guide')
        @include('admin.partials.guide-operations')
    @endif
</div>
@endsection
