@extends('layouts.auth')

@section('title', 'Login Operasional - YAPISDA')

@section('content')
@include('admin.partials.auth-login-card', [
    'panel' => 'Operasional',
    'icon' => 'fa-building-columns',
    'title' => 'Login Operasional',
    'subtitle' => 'Kelola siswa aktif, stok seragam, checklist final, arsip dokumen, dan dashboard yayasan.',
    'intro' => 'Panel operasional dipisahkan agar admin, keuangan, kepala sekolah, dan yayasan bisa bekerja bersamaan tanpa saling menimpa sesi login.',
    'action' => route('admin.operations.login.post'),
    'emailLabel' => 'Email Operasional',
    'emailPlaceholder' => 'operasional@yapisda.sch.id',
])
@endsection
