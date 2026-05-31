@extends('layouts.auth')

@section('title', 'Login Admin SMPS - YAPISDA')

@section('content')
@include('admin.partials.auth-login-card', [
    'panel' => 'Admin SMPS',
    'icon' => 'fa-school',
    'title' => 'Login Admin SMPS',
    'subtitle' => 'Kelola pendaftaran, verifikasi berkas, dan kuota program SMPS.',
    'intro' => 'Panel SMPS dibuat untuk memudahkan admin memantau calon siswa, status berkas, dan kebutuhan verifikasi harian.',
    'action' => route('admin.smp.login.post'),
    'emailLabel' => 'Email Admin SMPS',
    'emailPlaceholder' => 'admin-smp@yapisda.sch.id',
])
@endsection
