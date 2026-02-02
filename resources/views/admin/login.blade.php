@extends('layouts.app')

@section('title', 'Login Admin - YAPISDA')

@section('content')
<div class="container" style="min-height: 80vh;">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4><i class="fas fa-lock me-2"></i>Login Admin</h4>
                    <p class="mb-0">Sistem Penerimaan Murid Baru 2026/2027</p>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.post') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                       value="{{ old('username') }}" required autofocus>
                            </div>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Default Login:<br>
                            Username: admin<br>
                            Password: admin123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection