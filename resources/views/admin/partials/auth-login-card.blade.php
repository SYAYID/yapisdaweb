<main class="auth-shell">
    <section class="auth-intro" aria-label="Informasi akses admin">
        <a href="{{ route('home') }}" class="auth-brand">
            <img src="{{ asset('images/logo-yapisda.svg') }}" alt="Logo YAPISDA">
            <span>
                <strong>YAPISDA</strong>
                <span>Daar El Rohmah</span>
            </span>
        </a>

        <div>
            <h1>Panel kerja YAPISDA</h1>
            <p>{{ $intro ?? 'Akses internal untuk memantau pendaftaran, verifikasi berkas, dan operasional sekolah secara rapi.' }}</p>
        </div>

        <nav class="auth-panel-links" aria-label="Pilih panel login">
            <a href="{{ route('admin.login') }}" class="{{ request()->routeIs('admin.login', 'admin.login.post') ? 'is-active' : '' }}">
                <i class="fas fa-industry"></i> SMKS
            </a>
            <a href="{{ route('admin.smp.login') }}" class="{{ request()->routeIs('admin.smp.login', 'admin.smp.login.post') ? 'is-active' : '' }}">
                <i class="fas fa-school"></i> SMPS
            </a>
            <a href="{{ route('admin.finance.login') }}" class="{{ request()->routeIs('admin.finance.login', 'admin.finance.login.post') ? 'is-active' : '' }}">
                <i class="fas fa-wallet"></i> Keuangan
            </a>
            <a href="{{ route('admin.operations.login') }}" class="{{ request()->routeIs('admin.operations.login', 'admin.operations.login.post') ? 'is-active' : '' }}">
                <i class="fas fa-building-columns"></i> Operasional
            </a>
        </nav>
    </section>

    <section class="auth-card" aria-label="{{ $title }}">
        <header class="auth-card-header">
            <div class="auth-badge">
                <i class="fas {{ $icon }}"></i>
                {{ $panel }}
            </div>
            <h2>{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </header>

        <div class="auth-card-body">
            @if(session('error'))
                <div class="auth-alert" role="alert">
                    <i class="fas fa-circle-exclamation mt-1"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ $action }}" method="POST" class="auth-form" id="loginForm">
                @csrf

                <div class="auth-field">
                    <label for="username">{{ $emailLabel }}</label>
                    <div class="auth-input">
                        <span><i class="fas fa-envelope"></i></span>
                        <input type="email"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               class="@error('username') is-invalid @enderror"
                               placeholder="{{ $emailPlaceholder }}"
                               autocomplete="email"
                               required
                               autofocus>
                    </div>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password">Password</label>
                    <div class="auth-input">
                        <span><i class="fas fa-lock"></i></span>
                        <input type="password"
                               name="password"
                               id="password"
                               class="@error('password') is-invalid @enderror"
                               placeholder="Masukkan password"
                               autocomplete="current-password"
                               required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-submit" id="submitBtn">
                    <i class="fas fa-right-to-bracket"></i>
                    Login Sekarang
                </button>
            </form>

            <p class="auth-footnote">
                <i class="fas fa-lock"></i>
                Akses terbatas untuk staf berwenang
            </p>
        </div>
    </section>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const button = document.getElementById('submitBtn');
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    if (username?.value && password) {
        password.focus();
    }

    form?.addEventListener('submit', () => {
        if (!button) return;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
});
</script>
@endpush
