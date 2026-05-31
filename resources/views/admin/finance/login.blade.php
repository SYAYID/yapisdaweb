@extends('layouts.auth')

@section('title', 'Login Keuangan - YAPISDA')

@section('content')
@include('admin.partials.auth-login-card', [
    'panel' => 'Keuangan',
    'icon' => 'fa-wallet',
    'title' => 'Login Keuangan',
    'subtitle' => 'Catat pembayaran, mutasi kas, laporan harian, dan cetak kartu siswa.',
    'intro' => 'Panel keuangan menyatukan transaksi siswa, laporan pemasukan dan pengeluaran, serta kebutuhan cetak kartu setelah pembayaran.',
    'action' => route('admin.finance.login.post'),
    'emailLabel' => 'Email Keuangan',
    'emailPlaceholder' => 'keuangan@yapisda.sch.id',
])
@endsection
