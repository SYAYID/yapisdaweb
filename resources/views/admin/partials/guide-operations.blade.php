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
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1.1rem;
    position: relative;
}

.guide-flow-step {
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.25rem 1.15rem;
    position: relative;
    transition: var(--transition-smooth);
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
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
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
    color: white;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-weight: 900;
    font-size: 1rem;
    border: 3px solid var(--bg-page);
    box-shadow: var(--shadow-xs);
}

.guide-step-icon {
    font-size: 1.45rem;
    color: var(--primary);
    margin-top: 0.35rem;
}

.guide-flow-step h5 {
    font-weight: 800;
    font-size: 0.95rem;
    margin: 0;
    color: var(--text-dark);
}

.guide-flow-step p {
    margin: 0;
    font-size: 0.8rem;
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

@media (max-width: 1200px) {
    .guide-flow {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        row-gap: 1.75rem;
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
            <i class="fas fa-building-columns"></i>
        </div>
        <div class="guide-hero-text">
            <h3>Panduan Alur Kerja Staf Operasional</h3>
            <p>Selamat datang di Pusat Bantuan Staf Operasional YAPISDA. Halaman ini menjelaskan tata kelola rombongan belajar (rombel), monitoring persediaan gudang seragam, verifikasi arsip digital berkas, checklist kelayakan final siswa, serta pemeliharaan sistem.</p>
        </div>
    </div>

    <!-- Alur Kerja -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-circle-nodes"></i> Alur Kerja Operasional & Kesiapan Rombel</h4>
        <div class="guide-flow">
            <div class="guide-flow-step">
                <span class="guide-step-number">1</span>
                <div class="guide-step-icon"><i class="fas fa-rotate"></i></div>
                <h5>Sinkronisasi Data</h5>
                <p>Buka menu <strong>Siswa Aktif</strong>, klik tombol <strong>Sinkronkan</strong> untuk menarik data pendaftar yang pembayarannya telah dinyatakan lunas oleh divisi Keuangan.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">2</span>
                <div class="guide-step-icon"><i class="fas fa-graduation-cap"></i></div>
                <h5>Input Rombel & Status</h5>
                <p>Tentukan nama kelas/rombongan belajar (Rombel) siswa, sesuaikan status keaktifannya (Aktif/Hold/Nonaktif), lalu klik Simpan.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">3</span>
                <div class="guide-step-icon"><i class="fas fa-boxes-stacked"></i></div>
                <h5>Monitoring Seragam</h5>
                <p>Buka menu <strong>Stok Seragam</strong>. Bandingkan jumlah kebutuhan fisik siswa (berdasarkan ukuran tercatat) dengan jumlah persediaan stok barang di gudang.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">4</span>
                <div class="guide-step-icon"><i class="fas fa-list-check"></i></div>
                <h5>Checklist Akhir & Final</h5>
                <p>Buka menu <strong>Checklist Final</strong>. Kontrol kelengkapan 6 parameter siswa. Jika sudah terpenuhi semua, set status menjadi <strong>Finalized</strong>.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">5</span>
                <div class="guide-step-icon"><i class="fas fa-file-export"></i></div>
                <h5>Backup & Export</h5>
                <p>Unduh data excel Dapodik/Sekolah di menu <strong>Export Resmi</strong>. Lakukan backup snapshot berkala pada menu <strong>Backup & Health</strong>.</p>
            </div>
        </div>
    </div>

    <!-- Detail Menu & Fungsi -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-list"></i> Penjelasan Menu Utama Operasional</h4>
        <div class="guide-menu-grid">
            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-gauge-high"></i></div>
                <div class="guide-menu-info">
                    <h5>Dashboard Operasional</h5>
                    <p>Menampilkan grafik distribusi program keahlian, status ketersediaan stok logistik, jumlah siswa aktif terdaftar, status kelengkapan arsip, serta ringkasan kesehatan server.</p>
                    <div class="guide-badge-list">
                        <span>KPI Logistik</span>
                        <span>Rasio Rombel</span>
                        <span>Status Sistem</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="guide-menu-info">
                    <h5>Master Siswa Aktif</h5>
                    <p>Tempat pemetaan rombel kelas siswa baru (SMKS / SMPS) yang sudah lunas administrasi. Dilengkapi fitur sinkronisasi dengan database transaksi keuangan.</p>
                    <div class="guide-badge-list">
                        <span>Sinkron Database</span>
                        <span>Manajemen Rombel</span>
                        <span>Status Aktif/Hold</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-boxes-stacked"></i></div>
                <div class="guide-menu-info">
                    <h5>Stok Seragam & Logistik</h5>
                    <p>Modul pemantauan stok fisik gudang. Dilengkapi kalkulator pembanding otomatis kebutuhan ukuran siswa terverifikasi dengan stok yang tersedia (menampilkan sisa gap selisih).</p>
                    <div class="guide-badge-list">
                        <span>Input Stok</span>
                        <span>Kategori Barang</span>
                        <span>Gap Analisis Ukuran</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-list-check"></i></div>
                <div class="guide-menu-info">
                    <h5>Checklist Status Final</h5>
                    <p>Pintu gerbang penentu kesiapan siswa untuk masuk Dapodik. Memantau kelengkapan berkas unggahan, kelunasan pembayaran, pencetakan kartu, serta pendistribusian atribut seragam.</p>
                    <div class="guide-badge-list">
                        <span>6 Indikator Kelayakan</span>
                        <span>Set Status Final</span>
                        <span>Catatan Rombel</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-file-export"></i></div>
                <div class="guide-menu-info">
                    <h5>Export Resmi Sekolah</h5>
                    <p>Tempat pengunduhan data master (Data Pendaftar DPD, Data Keuangan, Siswa Aktif, Logistik) berformat Excel yang siap diunggah ke Dapodik atau dijadikan laporan rapat yayasan.</p>
                    <div class="guide-badge-list">
                        <span>Excel DPD</span>
                        <span>Excel Dapodik</span>
                        <span>Arsip Sekolah</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-folder-open"></i></div>
                <div class="guide-menu-info">
                    <h5>Arsip Dokumen Digital</h5>
                    <p>Memungkinkan staf operasional memeriksa keberadaan file upload fisik di disk server (seperti KK, Ijazah, Akta) untuk seluruh siswa terdaftar secara praktis.</p>
                    <div class="guide-badge-list">
                        <span>File Exist Check</span>
                        <span>Direct Preview</span>
                        <span>Problem Filter</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-shield-heart"></i></div>
                <div class="guide-menu-info">
                    <h5>Backup & Health Check</h5>
                    <p>Modul pemeliharaan server. Menampilkan status database, sisa kuota storage, ketepatan waktu sistem, serta pembuatan dan pengunduhan file backup snapshot database sql.</p>
                    <div class="guide-badge-list">
                        <span>Kesehatan Storage</span>
                        <span>Buat Snapshot</span>
                        <span>Restore Check</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Penting (Notice) -->
    <div class="guide-notice-box">
        <i class="fas fa-circle-exclamation"></i>
        <div class="guide-notice-content">
            <h5>Ketentuan Sinkronisasi Data Siswa Aktif</h5>
            <p>Data siswa pada menu <strong>Siswa Aktif</strong> tidak bertambah secara otomatis untuk menghindari ketidaksesuaian data. Ketika divisi Keuangan mengonfirmasi kelunasan siswa baru, Anda harus menekan tombol <strong>Sinkronkan</strong> di bagian kanan atas halaman Siswa Aktif untuk memuat data terbaru siswa tersebut ke dalam tabel kelas.</p>
        </div>
    </div>
</div>
