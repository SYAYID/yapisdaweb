@extends('layouts.app')

@section('title', 'Dashboard Admin - YAPISDA')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin - SPMB 2026/2027</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
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

    <!-- Kuota Cards -->
    <!-- Kuota Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-2"></i>Kuota Pendaftaran per Jurusan
                    <span class="badge bg-info ms-2">Update Otomatis Setelah Verifikasi</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Total Kuota</th>
                                    <th>Terpakai</th>
                                    <th>Tersisa</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotas as $quota)
                                <tr>
                                    <td><strong>{{ $quota->major }}</strong></td>
                                    <td>{{ $quota->quota }}</td>
                                    <td>{{ $quota->used_quota }}</td>
                                    <td>
                                        <span class="badge bg-{{ $quota->available_quota <= 0 ? 'danger' : ($quota->available_quota <= 10 ? 'warning' : 'success') }}">
                                            {{ $quota->available_quota }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($quota->available_quota <= 0)
                                            <span class="badge bg-danger">Penuh</span>
                                        @elseif($quota->available_quota <= 10)
                                            <span class="badge bg-warning text-dark">Sedikit</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-{{ $quota->available_quota <= 0 ? 'danger' : ($quota->available_quota <= 10 ? 'warning' : 'success') }}" 
                                                role="progressbar" 
                                                style="width: {{ $quota->percentage }}%">
                                                {{ $quota->percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-search me-2"></i>Cari Pendaftar
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.search') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="registration_number" class="form-control" 
                                   placeholder="Nomor Pendaftaran" value="{{ request('registration_number') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="nik" class="form-control" 
                                   placeholder="NIK Siswa" value="{{ request('nik') }}">
                        </div>
                        <div class="col-md-3">
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
                <a href="{{ route('admin.export.excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </a>
                <button class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
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
                                    <th>Jurusan</th>
                                    <th>No. HP</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applicants as $index => $applicant)
                                <tr>
                                    <td>{{ $applicants->firstItem() + $index }}</td>
                                    <td><strong>{{ $applicant->registration_number }}</strong></td>
                                    <td>{{ $applicant->full_name }}</td>
                                    <td>{{ $applicant->nik }}</td>
                                    <td>{{ $applicant->major_choice }}</td>
                                    <td>{{ $applicant->phone }}</td>
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
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.documents', $applicant->id) }}" 
                                            class="btn btn-primary" title="Lihat Berkas">
                                                <i class="fas fa-folder"></i>
                                            </a>
                                            <a href="{{ route('admin.print', $applicant->id) }}" 
                                            class="btn btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($applicant->status == 'pending')
                                                <a href="{{ route('admin.verify', $applicant->id) }}" 
                                                class="btn btn-success" 
                                                onclick="return confirm('Verifikasi pendaftaran ini?')" 
                                                title="Verifikasi">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="{{ route('admin.reject', $applicant->id) }}" 
                                                class="btn btn-danger" 
                                                onclick="return confirm('Tolak pendaftaran ini?')" 
                                                title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Menampilkan {{ $applicants->firstItem() }} - {{ $applicants->lastItem() }} dari {{ $applicants->total() }} data
                        </div>
                        <div>
                            {{ $applicants->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #2563eb !important; }
.border-left-success { border-left: 4px solid #10b981 !important; }
.border-left-warning { border-left: 4px solid #f59e0b !important; }
.border-left-danger { border-left: 4px solid #ef4444 !important; }

.card-body h5 { font-size: 1.25rem; }
.card-body .h5 { font-size: 1.5rem; }

.table thead th { font-weight: 600; }
</style>
@endsection