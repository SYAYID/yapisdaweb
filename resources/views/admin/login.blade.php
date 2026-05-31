@extends('layouts.auth')

@section('title', 'Login Admin SMKS - YAPISDA')

@section('content')
@include('admin.partials.auth-login-card', [
    'panel' => 'Admin SMKS',
    'icon' => 'fa-industry',
    'title' => 'Login Admin SMKS',
    'subtitle' => 'Verifikasi pendaftaran, kuota jurusan, dan data calon siswa SMKS.',
    'intro' => 'Satu tempat untuk memantau pendaftaran, memeriksa berkas, dan mengambil keputusan verifikasi dengan cepat.',
    'action' => route('admin.login.post'),
    'emailLabel' => 'Email Admin SMKS',
    'emailPlaceholder' => 'admin-smk@yapisda.sch.id',
])
@endsection
