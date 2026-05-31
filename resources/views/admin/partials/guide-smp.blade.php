@push('styles')
<style>
.guide-container {
    display: grid;
    gap: 2rem;
    margin-top: 1rem;
}

.guide-hero {
    background: linear-gradient(135deg, rgba(46, 107, 79, 0.1) 0%, rgba(201, 168, 76, 0.15) 100%);
    border: 1px solid rgba(201, 168, 76, 0.2);
    border-radius: var(--radius-lg);
    padding: 2.5rem 2rem;
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 1.5rem;
    align-items: center;
}

.guide-hero-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border-radius: 20px;
    display: grid;
    place-items: center;
    font-size: 2.2rem;
    box-shadow: var(--shadow-md);
}

.guide-hero-text h3 {
    font-family: var(--ff-display);
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--primary-dark);
    margin: 0;
}

.guide-hero-text p {
    margin: 0.5rem 0 0;
    color: var(--text-mid);
    font-size: 1rem;
    line-height: 1.6;
}

.guide-section-title {
    font-family: var(--ff-display);
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary-dark);
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 2px solid var(--border);
    padding-bottom: 0.5rem;
}

.guide-section-title i {
    color: var(--gold-dark);
}

.guide-flow {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1.25rem;
    position: relative;
}

.guide-flow-step {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem;
    position: relative;
    transition: var(--transition-smooth);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    box-shadow: var(--shadow-sm);
}

.guide-flow-step:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
    border-color: rgba(46, 107, 79, 0.25);
}

.guide-step-number {
    position: absolute;
    top: -15px;
    left: 20px;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
    color: white;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-weight: 900;
    font-size: 1.1rem;
    border: 3px solid var(--bg-page);
    box-shadow: var(--shadow-xs);
}

.guide-step-icon {
    font-size: 1.6rem;
    color: var(--primary);
    margin-top: 0.5rem;
}

.guide-flow-step h5 {
    font-weight: 800;
    font-size: 1.05rem;
    margin: 0;
    color: var(--text-dark);
}

.guide-flow-step p {
    margin: 0;
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

.guide-menu-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.5rem;
}

.guide-menu-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem;
    display: grid;
    grid-template-columns: 50px 1fr;
    gap: 1.25rem;
    box-shadow: var(--shadow-sm);
    transition: var(--transition-smooth);
}

.guide-menu-card:hover {
    transform: translateY(-2px);
    border-color: rgba(201, 168, 76, 0.35);
    box-shadow: var(--shadow-md);
}

.guide-menu-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--primary-50);
    color: var(--primary);
    display: grid;
    place-items: center;
    font-size: 1.35rem;
}

.guide-menu-info h5 {
    font-weight: 800;
    font-size: 1.1rem;
    margin: 0 0 0.35rem 0;
    color: var(--text-dark);
}

.guide-menu-info p {
    margin: 0 0 0.75rem 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

.guide-badge-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.guide-badge-list span {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    background: var(--bg-page);
    color: var(--text-mid);
    border: 1px solid var(--border);
}

.guide-notice-box {
    background: linear-gradient(135deg, rgba(201, 168, 76, 0.05) 0%, rgba(201, 168, 76, 0.15) 100%);
    border-left: 4px solid var(--gold-dark);
    border-radius: var(--radius);
    padding: 1.25rem 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.guide-notice-box i {
    font-size: 1.4rem;
    color: var(--gold-dark);
    margin-top: 0.15rem;
}

.guide-notice-content h5 {
    font-weight: 800;
    font-size: 1.05rem;
    margin: 0 0 0.35rem 0;
    color: var(--text-dark);
}

.guide-notice-content p {
    margin: 0;
    font-size: 0.88rem;
    color: var(--text-mid);
    line-height: 1.6;
}

@media (max-width: 1024px) {
    .guide-flow {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .guide-hero {
        grid-template-columns: 1fr;
        text-align: center;
        justify-items: center;
    }
    .guide-menu-grid, .guide-flow {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

<div class="guide-container">
    <!-- Hero Banner -->
    <div class="guide-hero">
        <div class="guide-hero-icon">
            <i class="fas fa-school"></i>
        </div>
        <div class="guide-hero-text">
            <h3>Panduan Alur Kerja Admin SMPS</h3>
            <p>Selamat datang di Pusat Bantuan Admin SMPS YAPISDA. Halaman ini menjelaskan seluruh fungsi menu, alur verifikasi berkas calon siswa baru tingkat SMP, serta ketentuan kuota program sekolah secara detail dan prosedural.</p>
        </div>
    </div>

    <!-- Alur Kerja -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-circle-nodes"></i> Alur Kerja Verifikasi Pendaftaran</h4>
        <div class="guide-flow">
            <div class="guide-flow-step">
                <span class="guide-step-number">1</span>
                <div class="guide-step-icon"><i class="fas fa-chart-line"></i></div>
                <h5>Pantau Peta Kerja</h5>
                <p>Mulai hari Anda dengan memantau jumlah pendaftar baru dan data yang masuk pada menu <strong>Dashboard</strong> atau widget <strong>Peta Kerja Hari Ini</strong>.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">2</span>
                <div class="guide-step-icon"><i class="fas fa-qrcode"></i></div>
                <h5>Cari & Scan QR</h5>
                <p>Buka menu <strong>Data Pendaftar</strong>, cari siswa berdasarkan nama/NIK, atau gunakan fitur <strong>Scan QR Code</strong> pada bukti cetak fisik pendaftaran siswa.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">3</span>
                <div class="guide-step-icon"><i class="fas fa-folder-open"></i></div>
                <h5>Periksa Berkas & NIK</h5>
                <p>Klik tombol <strong>Lihat Berkas</strong> (ikon folder) untuk mengecek kelengkapan file upload (KK, Akta Kelahiran, dll.) serta validitas NIK pendaftar.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">4</span>
                <div class="guide-step-icon"><i class="fas fa-check-double"></i></div>
                <h5>Update Status Siswa</h5>
                <p>Gunakan opsi status inline pada tabel data pendaftar atau halaman detail untuk mengubah status menjadi <strong>Verified</strong> atau <strong>Rejected</strong>.</p>
            </div>
        </div>
    </div>

    <!-- Detail Menu & Fungsi -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-list"></i> Penjelasan Menu Utama</h4>
        <div class="guide-menu-grid">
            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-gauge-high"></i></div>
                <div class="guide-menu-info">
                    <h5>Dashboard Utama</h5>
                    <p>Halaman pusat informasi harian yang memuat grafik statistik pendaftaran, KPI harian (pendaftar hari ini, pending verifikasi), akses cepat modul, serta log aktivitas pendaftaran terbaru.</p>
                    <div class="guide-badge-list">
                        <span>KPI Stats</span>
                        <span>Akses Cepat</span>
                        <span>Aktivitas Terbaru</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-chart-pie"></i></div>
                <div class="guide-menu-info">
                    <h5>Analytics Pendaftaran</h5>
                    <p>Memuat visualisasi grafik tren harian pendaftaran, rasio status verifikasi pendaftar, grafik sebaran peminat program sekolah, serta Heatmap Jam & Hari tersibuk untuk analisa efisiensi tim.</p>
                    <div class="guide-badge-list">
                        <span>Tren Harian</span>
                        <span>Donut Chart</span>
                        <span>Time Heatmap</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-layer-group"></i></div>
                <div class="guide-menu-info">
                    <h5>Kuota Program</h5>
                    <p>Menampilkan kapasitas maksimum, jumlah kuota terpakai, dan sisa kuota masing-masing program sekolah (Reguler, Boarding, dll.). Dilengkapi bar presentase keterisian kuota secara langsung.</p>
                    <div class="guide-badge-list">
                        <span>Kapasitas</span>
                        <span>Sisa Kuota</span>
                        <span>Verifikasi Rate</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-table"></i></div>
                <div class="guide-menu-info">
                    <h5>Data Pendaftar</h5>
                    <p>Modul kerja utama admin untuk mencari, menyaring (berdasarkan status/program), mengecek file unggahan berkas, mencetak ulang formulir bukti pendaftaran, serta melakukan verifikasi akhir.</p>
                    <div class="guide-badge-list">
                        <span>Verifikasi Berkas</span>
                        <span>Cetak Bukti</span>
                        <span>Hubungi WhatsApp</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Penting (Notice) -->
    <div class="guide-notice-box">
        <i class="fas fa-circle-exclamation"></i>
        <div class="guide-notice-content">
            <h5>Ketentuan Kuota Program Secara Otomatis (Sistem Terintegrasi)</h5>
            <p>Sistem YAPISDA dilengkapi dengan fitur pengurangan kuota otomatis. Kuota program sekolah <strong>hanya akan berkurang</strong> jika Anda mengubah status pendaftar menjadi <strong>Verified</strong>. Apabila status diubah kembali menjadi <em>Pending</em> atau <em>Rejected</em>, kuota program yang terpakai akan otomatis dikembalikan secara real-time. Pastikan kuota program masih tersedia sebelum melakukan verifikasi.</p>
        </div>
    </div>
</div>
