@extends('layouts.app')

@section('title', 'Home - YAPISDA')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Selamat Datang di YAPISDA
                </div>
                <div class="card-body">
                    <h2 class="card-title mb-4">Yayasan Pendidikan Islam Daar El Rohmah</h2>
                    <p class="lead mb-4">Menyelenggarakan Pendidikan Berkualitas untuk Generasi Penerus Bangsa</p>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-bullhorn me-2"></i>
                        <strong>PENGUMUMAN SPMB 2026/2027</strong><br>
                        Penerimaan Siswa Baru Tahun Ajaran 2026/2027 telah dibuka. Segera daftarkan putra-putri Anda!
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">SMKS YAPISDA</h5>
                                    <p class="card-text">Sekolah Menengah Kejuruan dengan 6 jurusan unggulan</p>
                                    <a href="{{ route('registration.form') }}" class="btn btn-primary">Daftar Sekarang</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">SMPS YAPISDA</h5>
                                    <p class="card-text">Sekolah Menengah Pertama dengan kurikulum terpadu</p>
                                    <a href="" class="btn btn-primary">Tidak Tersedia</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5   ">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-2"></i>Kuota Pendaftaran
                </div>
                <div class="card-body">
                    @foreach($quotas as $quota)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold">{{ $quota->major }}</span>
                                <span class="badge quota-badge 
                                    @if($quota->available_quota <= 10) quota-low
                                    @elseif($quota->available_quota == 0) quota-full
                                    @else quota-available @endif">
                                    {{ $quota->available_quota }}/{{ $quota->quota }}
                                </span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar 
                                    @if($quota->available_quota <= 10) bg-warning
                                    @elseif($quota->available_quota == 0) bg-danger
                                    @else bg-success @endif"
                                    role="progressbar" 
                                    style="width: {{ ($quota->used_quota/$quota->quota)*100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-2"></i>Jadwal Penting
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>Pendaftaran Online</strong><br>
                            <small>1 Februari - 11 Juli 2026</small>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-file-alt text-primary me-2"></i>
                            <strong>Verifikasi Berkas</strong><br>
                            <small>1 Februari - 11 Juli 2026</small>
                        </li>
                        
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <strong>Masuk Sekolah</strong></strong><br>
                            <small>13 Juli 2026</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection