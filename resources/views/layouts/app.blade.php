<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YAPISDA - Sistem Penerimaan Murid Baru')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--secondary-color), #1e3a8a);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
        
        .quota-badge {
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 20px;
        }
        
        .quota-available {
            background-color: #10b981;
        }
        
        .quota-low {
            background-color: #f59e0b;
        }
        
        .quota-full {
            background-color: #ef4444;
        }

        /* Flatpickr Custom Style */
        .flatpickr-input {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
        }

        .flatpickr-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-school me-2"></i>YAPISDA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(!request()->routeIs('admin.*'))
                        <!-- Public Navigation -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <i class="fas fa-info-circle me-1"></i>Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vision') ? 'active' : '' }}" href="{{ route('vision') }}">
                                <i class="fas fa-bullseye me-1"></i>Visi & Misi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                <i class="fas fa-phone me-1"></i>Kontak
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-dark ms-2" href="{{ route('registration.form') }}">
                                <i class="fas fa-user-graduate me-1"></i>SPMB 2026/2027
                            </a>
                        </li>
                    @else
                        <!-- Admin Navigation -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.export.excel') }}">
                                <i class="fas fa-file-excel me-1"></i>Export Excel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.logout') }}">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-school me-2"></i>YAYASAN PENDIDIKAN ISLAM DAAR EL ROHMAH (YAPISDA)</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Jl. Raya Cisoka - Tigaraksa Kp.Saga, Ds.Caringin, Kec.Cisoka, Kab.Tangerang-Banten, Banten</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i>(021) 59751260 / 082260203332 / 0895323042450</p>
                    <p class="mb-0"><i class="fas fa-envelope me-2"></i>Coming Soon</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-2"><strong>SMKS YAPISDA & SMPS YAPISDA</strong></p>
                    <p class="mb-2">Jl. Raya Cisoka - Tigaraksa Kp.Saga, Ds.Caringin, Kec.Cisoka, Kab.Tangerang-Banten</p>
                    
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} YAPISDA. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    @stack('scripts')
</body>
</html>