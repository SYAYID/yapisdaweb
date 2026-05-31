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
            <i class="fas fa-wallet"></i>
        </div>
        <div class="guide-hero-text">
            <h3>Panduan Alur Kerja Staf Keuangan</h3>
            <p>Selamat datang di Pusat Bantuan Staf Keuangan YAPISDA. Halaman ini memuat alur penanganan pendaftaran ulang siswa lunas, pencatatan transaksi keuangan sekolah, pengukuran seragam, serta pencetakan dokumen resmi pendaftar.</p>
        </div>
    </div>

    <!-- Alur Kerja -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-circle-nodes"></i> Alur Kerja Penerimaan & Daftar Ulang Siswa</h4>
        <div class="guide-flow">
            <div class="guide-flow-step">
                <span class="guide-step-number">1</span>
                <div class="guide-step-icon"><i class="fas fa-user-check"></i></div>
                <h5>Siswa Terverifikasi</h5>
                <p>Proses dimulai setelah pendaftar dinyatakan <strong>Verified</strong> oleh admin SMK/SMP. Siswa otomatis masuk ke data pencarian keuangan.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">2</span>
                <div class="guide-step-icon"><i class="fas fa-cash-register"></i></div>
                <h5>Pencatatan Pembayaran</h5>
                <p>Buka menu <strong>Catat Transaksi</strong>, cari nama siswa, pilih jenis pembayaran (Seragam/DU), masukkan jumlah nominal, lalu simpan.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">3</span>
                <div class="guide-step-icon"><i class="fas fa-shirt"></i></div>
                <h5>Input Ukuran Seragam</h5>
                <p>Buka menu <strong>Ukuran Seragam</strong>, pilih siswa, catat ukuran baju, celana, sepatu, dan atur status atribut menjadi <em>Tercatat</em>.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">4</span>
                <div class="guide-step-icon"><i class="fas fa-address-card"></i></div>
                <h5>Penerbitan NIS & Kartu</h5>
                <p>Setelah pembayaran Lunas, sistem otomatis menerbitkan NIS. Buka <strong>Mutasi Kas</strong>, cetak Kwitansi serta Kartu Siswa fisik.</p>
            </div>
            <div class="guide-flow-step">
                <span class="guide-step-number">5</span>
                <div class="guide-step-icon"><i class="fas fa-envelope-open-text"></i></div>
                <h5>Cetak Surat Resmi</h5>
                <p>Buka menu <strong>Progress Final</strong>, cetak <em>Surat Diterima</em> dan <em>Rincian Administrasi</em> pada baris siswa untuk diserahkan ke wali murid.</p>
            </div>
        </div>
    </div>

    <!-- Detail Menu & Fungsi -->
    <div>
        <h4 class="guide-section-title"><i class="fas fa-list"></i> Penjelasan Menu Utama Keuangan</h4>
        <div class="guide-menu-grid">
            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-gauge-high"></i></div>
                <div class="guide-menu-info">
                    <h5>Dashboard Keuangan</h5>
                    <p>Menyajikan KPI keuangan real-time: total income harian/bulanan, outcome, progres lunas uang seragam, chart harian, mutasi terbaru, serta daftar tagihan teratas.</p>
                    <div class="guide-badge-list">
                        <span>KPI Kas</span>
                        <span>Uang Seragam Chart</span>
                        <span>Tagihan Teratas</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-cash-register"></i></div>
                <div class="guide-menu-info">
                    <h5>Catat Transaksi</h5>
                    <p>Formulir utama pencatatan mutasi kas sekolah. Ketik nama siswa pada kolom pencarian otomatis untuk memuat unit (SMK/SMP) dan pilihan programnya secara otomatis.</p>
                    <div class="guide-badge-list">
                        <span>Auto-complete Siswa</span>
                        <span>Income / Outcome</span>
                        <span>Metode Bayar</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-shirt"></i></div>
                <div class="guide-menu-info">
                    <h5>Laporan Uang Seragam</h5>
                    <p>Memuat rekapitulasi pembayaran uang seragam seluruh siswa verified. Memudahkan pemantauan nominal wajib, total yang sudah dibayar, sisa tagihan, serta status kelunasan.</p>
                    <div class="guide-badge-list">
                        <span>Total Wajib</span>
                        <span>Sudah Dibayar</span>
                        <span>Sisa Piutang</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-ruler-combined"></i></div>
                <div class="guide-menu-info">
                    <h5>Ukuran Seragam</h5>
                    <p>Formulir pencatatan detail fisik ukuran siswa (baju, celana/rok, sepatu, topi/kerudung), status logistik atribut (Tercatat, Disiapkan, Diserahkan), dan tanggal serah terima.</p>
                    <div class="guide-badge-list">
                        <span>Detail Fisik</span>
                        <span>Logistik Status</span>
                        <span>picked_up_at</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-chart-line"></i></div>
                <div class="guide-menu-info">
                    <h5>Progress Final</h5>
                    <p>Modul pemantauan alur lengkap siswa verified hingga final. Dilengkapi tombol aksi cetak langsung untuk Surat Keputusan Diterima dan Surat Rincian Administrasi.</p>
                    <div class="guide-badge-list">
                        <span>Aksi Cetak Surat</span>
                        <span>Tabel Perhatian</span>
                        <span>Tracking Tahapan</span>
                    </div>
                </div>
            </div>

            <div class="guide-menu-card">
                <div class="guide-menu-icon"><i class="fas fa-arrow-right-arrow-left"></i></div>
                <div class="guide-menu-info">
                    <h5>Mutasi Kas & Kartu</h5>
                    <p>Daftar riwayat transaksi kas masuk dan keluar. Di sini staf keuangan dapat mencetak Kwitansi Pembayaran resmi dan mencetak Kartu Siswa fisik (bersyarat lunas).</p>
                    <div class="guide-badge-list">
                        <span>Cetak Kwitansi</span>
                        <span>Cetak Kartu Siswa</span>
                        <span>Metode Filter</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Penting (Notice) -->
    <div class="guide-notice-box">
        <i class="fas fa-circle-exclamation"></i>
        <div class="guide-notice-content">
            <h5>Ketentuan NIS & Kartu Siswa Otomatis</h5>
            <p>NIS (Nomor Induk Siswa) akan <strong>otomatis dibuat oleh sistem</strong> setelah total pembayaran siswa untuk jenis pembayaran wajib (Daftar Ulang/Seragam) bernilai lunas (Sisa tagihan Rp 0). Tombol <strong>Cetak Kartu Siswa</strong> pada menu Mutasi Kas hanya akan muncul apabila NIS siswa tersebut sudah diterbitkan secara sistem.</p>
        </div>
    </div>
</div>
