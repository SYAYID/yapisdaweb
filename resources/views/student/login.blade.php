@extends('layouts.app')

@section('title', 'Login Siswa - YAPISDA')

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-user-graduate login-icon"></i>
            <h2>Masuk Panel Siswa</h2>
            <p>Masukkan Nomor Pendaftaran dan Password untuk melihat status pendaftaran Anda.</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('student.login.post') }}" class="login-form">
            @csrf
            
            <div class="form-group">
                <label for="username">Nomor Pendaftaran</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                    <input type="text" id="username" name="username" class="form-control" 
                           placeholder="Contoh: SMK-26-0001" value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password (Default: NIK Siswa)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="Masukkan password" required>
                </div>
            </div>

            <div class="form-group form-check mt-3 mb-4">
                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-primary login-btn">
                <span>Masuk</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<style>
.login-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 1.5rem;
    background: var(--surface);
}

.login-container {
    background: white;
    width: 100%;
    max-width: 440px;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 10px 40px rgba(15, 95, 74, 0.08);
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-icon {
    font-size: 3rem;
    color: var(--brand);
    margin-bottom: 1rem;
    background: var(--ivory);
    width: 80px; height: 80px;
    line-height: 80px;
    border-radius: 50%;
}

.login-header h2 {
    font-family: var(--ff-display);
    color: var(--forest);
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.login-header p {
    color: var(--text-muted);
    font-size: 0.95rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--forest);
}

.input-group {
    display: flex;
    align-items: stretch;
    border: 2px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.input-group:focus-within {
    border-color: var(--brand);
    box-shadow: 0 0 0 4px rgba(15, 95, 74, 0.1);
}

.input-group-text {
    background: var(--surface);
    padding: 0.8rem 1rem;
    color: var(--text-muted);
    border: none;
    border-right: 1px solid var(--border);
}

.form-control {
    flex: 1;
    border: none;
    padding: 0.8rem 1rem;
    outline: none;
    width: 100%;
}

.login-btn {
    width: 100%;
    padding: 1rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.alert-danger {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #f87171;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
}
</style>
@endsection
