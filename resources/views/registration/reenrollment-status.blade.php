@extends('layouts.app')

@section('title', 'Status Daftar Ulang - YAPISDA')

@push('styles')
<style>
.reenroll-page {
    background: linear-gradient(180deg, #f8fbfa 0%, #eef5f2 52%, #ffffff 100%);
    min-height: calc(100vh - 84px);
    padding: clamp(1.5rem, 4vw, 3.5rem) 0;
}

.reenroll-wrap {
    width: min(1100px, calc(100% - 2rem));
    margin: 0 auto;
    display: grid;
    gap: 1rem;
}

.reenroll-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(280px, 0.78fr);
    gap: 1rem;
    align-items: stretch;
}

.reenroll-intro,
.reenroll-search,
.reenroll-card,
.reenroll-empty {
    border: 1px solid var(--line);
    border-radius: 18px;
    background: #ffffff;
    box-shadow: var(--shadow-sm);
}

.reenroll-intro {
    padding: clamp(1.3rem, 3vw, 2rem);
    background:
        linear-gradient(135deg, rgba(16, 92, 75, 0.92), rgba(6, 45, 37, 0.96)),
        #0f4f41;
    color: #ffffff;
    overflow: hidden;
    position: relative;
}

.reenroll-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    min-height: 30px;
    padding: 0 0.7rem;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    color: var(--gold-light, #e8c97a);
    font-size: 0.76rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.reenroll-intro h1 {
    max-width: 680px;
    margin: 1rem 0 0.6rem;
    font-family: var(--ff-display);
    font-size: clamp(1.8rem, 4vw, 3.1rem);
    font-weight: 900;
    line-height: 1.04;
}

.reenroll-intro p {
    max-width: 720px;
    margin: 0;
    color: rgba(255, 255, 255, 0.78);
    font-size: 1rem;
    line-height: 1.7;
}

.reenroll-note {
    display: grid;
    gap: 0.55rem;
    margin-top: 1.2rem;
    padding: 1rem;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.1);
}

.reenroll-note strong {
    color: #ffffff;
}

.reenroll-search {
    padding: 1.1rem;
    display: grid;
    align-content: center;
}

.reenroll-search h2 {
    margin: 0 0 0.3rem;
    color: var(--brand-800);
    font-family: var(--ff-display);
    font-size: 1.25rem;
    font-weight: 900;
}

.reenroll-search p {
    margin: 0 0 1rem;
    color: var(--muted);
    font-weight: 700;
}

.reenroll-form {
    display: grid;
    gap: 0.7rem;
}

.reenroll-form input {
    width: 100%;
    min-height: 48px;
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 0 0.9rem;
    font: inherit;
}

.reenroll-form input:focus {
    border-color: rgba(16, 92, 75, 0.42);
    box-shadow: 0 0 0 0.22rem rgba(16, 92, 75, 0.12);
    outline: none;
}

.reenroll-form button {
    min-height: 48px;
    border: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--brand), var(--brand-800));
    color: #ffffff;
    font-weight: 900;
}

.reenroll-results {
    display: grid;
    gap: 1rem;
}

.reenroll-card {
    overflow: hidden;
}

.reenroll-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid var(--line);
    background: linear-gradient(180deg, #ffffff, #f8fbfa);
}

.reenroll-card-head h3 {
    margin: 0;
    color: var(--text);
    font-size: 1.15rem;
    font-weight: 900;
}

.reenroll-card-head span {
    color: var(--muted);
    font-size: 0.85rem;
    font-weight: 800;
}

.reenroll-unit {
    display: inline-flex;
    align-items: center;
    min-height: 32px;
    padding: 0 0.7rem;
    border-radius: 999px;
    background: var(--mint);
    color: var(--brand-800);
    font-size: 0.78rem;
    font-weight: 900;
}

.reenroll-card-body {
    padding: 1rem;
    display: grid;
    gap: 1rem;
}

.reenroll-status {
    display: grid;
    gap: 0.35rem;
    padding: 1rem;
    border-radius: 14px;
}

.reenroll-status h4 {
    margin: 0;
    font-family: var(--ff-display);
    font-size: 1.18rem;
    font-weight: 900;
}

.reenroll-status p {
    margin: 0;
    font-weight: 700;
    line-height: 1.55;
}

.reenroll-status.active_student {
    background: #ecfdf5;
    color: #065f46;
}

.reenroll-status.uniform_unpaid {
    background: #fffbeb;
    color: #92400e;
}

.reenroll-status.not_verified,
.reenroll-status.rejected {
    background: #fef2f2;
    color: #991b1b;
}

.reenroll-facts {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.75rem;
}

.reenroll-fact {
    padding: 0.8rem;
    border: 1px solid var(--line);
    border-radius: 13px;
    background: #ffffff;
}

.reenroll-fact span {
    display: block;
    color: var(--muted);
    font-size: 0.73rem;
    font-weight: 900;
    text-transform: uppercase;
}

.reenroll-fact strong {
    display: block;
    margin-top: 0.18rem;
    color: var(--text);
    font-size: 0.96rem;
    font-weight: 900;
}

.reenroll-money {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.75rem;
}

.reenroll-money .reenroll-fact strong {
    color: var(--brand-800);
}

.reenroll-empty {
    padding: 1.3rem;
    text-align: center;
}

.reenroll-empty i {
    color: var(--brand);
    font-size: 2rem;
}

.reenroll-empty h3 {
    margin: 0.7rem 0 0.25rem;
    color: var(--text);
    font-weight: 900;
}

.reenroll-empty p {
    margin: 0;
    color: var(--muted);
    font-weight: 700;
}

/* Popout Modal Styles */
.status-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(13, 33, 24, 0.65);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    animation: fadeIn 0.3s var(--ease-expo) both;
}

.status-modal-container {
    width: 100%;
    max-width: 540px;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid rgba(201, 168, 76, 0.25);
    box-shadow: var(--shadow-deep);
    overflow: hidden;
    animation: scaleUp 0.4s var(--ease-back) both;
}

.status-modal-header {
    background: linear-gradient(135deg, var(--forest), var(--forest-mid));
    color: #ffffff;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.status-modal-title {
    font-family: var(--ff-display);
    font-size: 1.25rem;
    font-weight: 800;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.status-modal-title i {
    color: var(--gold-light);
}

.status-modal-close {
    background: none;
    border: none;
    color: #ffffff;
    font-size: 1.25rem;
    cursor: pointer;
    opacity: 0.8;
    transition: opacity 0.2s, transform 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-modal-close:hover {
    opacity: 1;
    transform: scale(1.1);
}

.status-modal-body {
    padding: 1.75rem 1.5rem;
}

.modal-student-info {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--ivory-dark);
}

.modal-student-name {
    font-family: var(--ff-display);
    font-size: 1.45rem;
    font-weight: 900;
    color: var(--text-dark);
    margin: 0 0 0.35rem;
}

.modal-student-meta {
    font-size: 0.88rem;
    color: var(--text-muted);
    font-weight: 700;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.modal-badge {
    background: var(--gold-pale);
    color: var(--gold-dark);
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
}

.modal-action-box {
    background: var(--ivory);
    border: 1px solid var(--ivory-dark);
    padding: 1.25rem;
    border-radius: 16px;
    margin-top: 1.5rem;
}

.modal-action-title {
    font-weight: 800;
    font-size: 0.95rem;
    color: var(--text-dark);
    margin: 0 0 0.5rem;
}

.modal-action-desc {
    font-size: 0.84rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0 0 1rem;
}

.modal-btn-whatsapp {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    min-height: 46px;
    background: #25D366;
    color: #ffffff;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 800;
    font-size: 0.9rem;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25);
    transition: all 0.3s var(--ease-expo);
}

.modal-btn-whatsapp:hover {
    background: #20ba59;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.35);
    color: #ffffff;
}

.modal-visit-box {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #ffffff;
    border: 1px solid var(--ivory-dark);
    padding: 0.85rem 1rem;
    border-radius: 10px;
    font-size: 0.8rem;
    color: var(--text-mid);
    margin-top: 0.75rem;
    line-height: 1.55;
}

.modal-visit-box i {
    color: var(--gold);
    font-size: 1rem;
    margin-top: 0.15rem;
    flex-shrink: 0;
}

.status-modal-footer {
    background: var(--ivory);
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--ivory-dark);
    display: flex;
    justify-content: flex-end;
}

.status-modal-close-btn {
    min-height: 40px;
    padding: 0 1.5rem;
    border: none;
    border-radius: 8px;
    background: var(--text-muted);
    color: #ffffff;
    font-weight: 800;
    font-size: 0.88rem;
    cursor: pointer;
    transition: background 0.2s;
}

.status-modal-close-btn:hover {
    background: var(--text-mid);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleUp {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

@media (max-width: 920px) {
    .reenroll-hero,
    .reenroll-facts,
    .reenroll-money {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="reenroll-page">
    <div class="reenroll-wrap">
        <section class="reenroll-hero">
            <div class="reenroll-intro">
                <span class="reenroll-kicker"><i class="fas fa-id-card"></i>Status Daftar Ulang</span>
                <h1>Status resmi peserta didik mengikuti kelengkapan administrasi daftar ulang.</h1>
                <p>
                    Tes kemampuan dasar dipakai sebagai data pemetaan awal, bukan patokan utama kelulusan.
                    Calon peserta didik dinyatakan aktif setelah data terverifikasi dan kelengkapan administrasi atribut peserta didik tercatat pada sistem sekolah.
                </p>
                <div class="reenroll-note">
                    <strong>Alur singkat</strong>
                    <span>Verifikasi berkas oleh admin, konfirmasi administrasi atribut peserta didik oleh petugas, lalu kartu siswa dapat dicetak.</span>
                </div>
            </div>

            <aside class="reenroll-search">
                <h2>Cek Status</h2>
                <p>Masukkan nomor pendaftaran atau NIK calon siswa.</p>
                <form class="reenroll-form" action="{{ route('reenrollment.status') }}" method="GET">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Contoh: YP-2026-XXXX atau NIK" required>
                    <button type="submit">
                        <i class="fas fa-search me-1"></i>Cek Daftar Ulang
                    </button>
                </form>
            </aside>
        </section>

        @if($query !== '')
            <div class="status-modal-overlay" id="statusModalOverlay">
                <div class="status-modal-container">
                    <div class="status-modal-header">
                        <h5 class="status-modal-title">
                            <i class="fas fa-id-card"></i> Hasil Status Daftar Ulang
                        </h5>
                        <button type="button" class="status-modal-close" onclick="closeStatusModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="status-modal-body">
                        @forelse($results as $result)
                            <div class="modal-student-info">
                                <h3 class="modal-student-name">{{ $result['name'] }}</h3>
                                <div class="modal-student-meta">
                                    <span>{{ $result['registration_number'] }}</span>
                                    <span>•</span>
                                    <span>{{ $result['choice'] }}</span>
                                    <span>•</span>
                                    <span class="modal-badge">{{ $result['unit'] }}</span>
                                </div>
                            </div>

                            <div class="reenroll-status {{ $result['stage'] }}">
                                <h4>{{ $result['title'] }}</h4>
                                <p>{{ $result['message'] }}</p>
                            </div>

                            @if($result['stage'] !== 'active_student')
                                <div class="modal-action-box">
                                    <h4 class="modal-action-title">Opsi Tindak Lanjut:</h4>
                                    <p class="modal-action-desc">
                                        Anda belum menyelesaikan kelengkapan administrasi daftar ulang. Silakan pilih salah satu opsi di bawah ini untuk proses konfirmasi:
                                    </p>
                                    <a href="https://wa.me/628128906113" target="_blank" class="modal-btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i> Hubungi Panitia (WhatsApp)
                                    </a>
                                    <div class="modal-visit-box">
                                        <i class="fas fa-location-dot"></i>
                                        <div>
                                            <strong>Datang Langsung Ke Sekolah</strong><br>
                                            Membawa bukti pendaftaran ke sekretariat panitia PPDB pada jam kerja (Senin - Sabtu, 08.00 - 14.00 WIB).
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="reenroll-empty">
                                <i class="fas fa-magnifying-glass"></i>
                                <h3>Data tidak ditemukan</h3>
                                <p>Periksa kembali nomor pendaftaran atau NIK yang dimasukkan.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="status-modal-footer">
                        <button type="button" class="status-modal-close-btn" onclick="closeStatusModal()">Tutup</button>
                    </div>
                </div>
            </div>

            <script>
                function closeStatusModal() {
                    const overlay = document.getElementById('statusModalOverlay');
                    if (overlay) {
                        overlay.style.display = 'none';
                        const url = new URL(window.location);
                        url.searchParams.delete('q');
                        window.history.replaceState({}, '', url);
                    }
                }
                
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeStatusModal();
                    }
                });

                document.getElementById('statusModalOverlay').addEventListener('click', function(event) {
                    if (event.target === this) {
                        closeStatusModal();
                    }
                });
            </script>
        @endif
    </div>
</div>
@endsection
