<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMK Yapisda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section { margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; }
        .form-label { font-weight: bold; }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Pendaftaran Siswa Baru SMK Yapisda</h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- DATA PRIBADI SISWA -->
                        <div class="form-section">
                            <h5>1. Data Pribadi Siswa</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Wilayah KK</label>
                                    <select name="wilayah_kk" class="form-control" required>
                                        <option value="">Pilih Wilayah</option>
                                        <option value="Dalam Wilayah Banten">Dalam Wilayah Banten</option>
                                        <option value="Luar Wilayah Banten">Luar Wilayah Banten</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor KK</label>
                                    <input type="text" name="no_kk" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NISN (Opsional)</label>
                                    <input type="text" name="nisn" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-control" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email (Opsional)</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jurusan Pilihan 1</label>
                                    <select name="jurusan_pilihan_1" class="form-control" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="Akuntansi">Akuntansi</option>
                                        <option value="Multimedia">Multimedia</option>
                                        <option value="Manajemen dan Pelayanan Bisnis">Manajemen dan Pelayanan Bisnis</option>
                                        <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                                        <option value="Teknik dan Bisnis Sepeda Motor">Teknik dan Bisnis Sepeda Motor</option>
                                        <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jurusan Pilihan 2</label>
                                    <select name="jurusan_pilihan_2" class="form-control" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="Akuntansi">Akuntansi</option>
                                        <option value="Multimedia">Multimedia</option>
                                        <option value="Manajemen dan Pelayanan Bisnis">Manajemen dan Pelayanan Bisnis</option>
                                        <option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
                                        <option value="Teknik dan Bisnis Sepeda Motor">Teknik dan Bisnis Sepeda Motor</option>
                                        <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <select name="kewarganegaraan" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Akta Kelahiran</label>
                                    <input type="text" name="no_akta_lahir" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi_badan" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Berat Badan (kg)</label>
                                    <input type="number" name="berat_badan" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Lingkar Kepala (cm)</label>
                                    <input type="number" name="lingkar_kepala" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah Saudara</label>
                                    <input type="number" name="jumlah_saudara" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Anak Ke-</label>
                                    <input type="number" name="anak_ke" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Berkebutuhan Khusus</label>
                                    <input type="text" name="disabilitas" class="form-control" placeholder="Contoh: Disabilitas Umum">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Upload Pas Foto (Background Merah)</label>
                                <input type="file" name="foto_pas" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <!-- ALAMAT KTP -->
                        <div class="form-section">
                            <h5>2. Alamat KTP</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Kampung/Dusun</label>
                                    <input type="text" name="kampung_ktp" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">RT</label>
                                    <input type="text" name="rt_ktp" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">RW</label>
                                    <input type="text" name="rw_ktp" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Desa/Kelurahan</label>
                                    <input type="text" name="desa_kelurahan_ktp" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan_ktp" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi_ktp" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- ALAMAT DOMISILI -->
                        <div class="form-section">
                            <h5>3. Alamat Domisili (Tempat Tinggal Saat Ini)</h5>
                            <div class="form-check mb-3">
                                <input type="checkbox" id="domisili_sama_ktp" name="domisili_sama_ktp" class="form-check-input">
                                <label for="domisili_sama_ktp" class="form-check-label">Sama dengan alamat KTP</label>
                            </div>

                            <div id="domisili_fields">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Kampung/Dusun</label>
                                        <input type="text" name="kampung_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">RT</label>
                                        <input type="text" name="rt_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">RW</label>
                                        <input type="text" name="rw_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Desa/Kelurahan</label>
                                        <input type="text" name="desa_kelurahan_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" name="kecamatan_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" name="provinsi_domisili" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Tempat Tinggal</label>
                                        <select name="status_tempat_tinggal" class="form-control">
                                            <option value="">Pilih Status</option>
                                            <option value="Milik Sendiri">Milik Sendiri</option>
                                            <option value="Sewa">Sewa</option>
                                            <option value="Kontrak">Kontrak</option>
                                            <option value="Bersama Keluarga">Bersama Keluarga</option>
                                            <option value="Asrama">Asrama</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jarak ke Sekolah</label>
                                        <select name="jarak_ke_sekolah" class="form-control">
                                            <option value="">Pilih Jarak</option>
                                            <option value="<1 km"><1 km</option>
                                            <option value="1-3 km">1-3 km</option>
                                            <option value="3-5 km">3-5 km</option>
                                            <option value=">5 km">>5 km</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Moda Transportasi</label>
                                        <input type="text" name="moda_transportasi" class="form-control" placeholder="Contoh: Sepeda, Angkot, Mobil Pribadi">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ORANG TUA -->
                        <div class="form-section">
                            <h5>4. Data Orang Tua</h5>

                            <h6>Data Ayah</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ayah</label>
                                    <input type="date" name="tanggal_lahir_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendidikan Ayah</label>
                                    <input type="text" name="pendidikan_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penghasilan Ayah</label>
                                    <input type="text" name="penghasilan_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. HP Ayah</label>
                                    <input type="text" name="hp_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Berkebutuhan Khusus Ayah</label>
                                    <input type="text" name="disabilitas_ayah" class="form-control" placeholder="Contoh: Tidak Ada">
                                </div>
                            </div>

                            <h6 class="mt-4">Data Ibu</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir Ibu</label>
                                    <input type="date" name="tanggal_lahir_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendidikan Ibu</label>
                                    <input type="text" name="pendidikan_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penghasilan Ibu</label>
                                    <input type="text" name="penghasilan_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. HP Ibu</label>
                                    <input type="text" name="hp_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Berkebutuhan Khusus Ibu</label>
                                    <input type="text" name="disabilitas_ibu" class="form-control" placeholder="Contoh: Tidak Ada">
                                </div>
                            </div>

                            <h6 class="mt-4">Data Wali (Jika Ada)</h6>
                            <div class="form-check mb-3">
                                <input type="checkbox" id="ada_wali" name="ada_wali" class="form-check-input">
                                <label for="ada_wali" class="form-check-label">Saya memiliki wali</label>
                            </div>

                            <div id="wali_fields" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">NIK Wali</label>
                                        <input type="text" name="nik_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap Wali</label>
                                        <input type="text" name="nama_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir Wali</label>
                                        <input type="text" name="tempat_lahir_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir Wali</label>
                                        <input type="date" name="tanggal_lahir_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pendidikan Wali</label>
                                        <input type="text" name="pendidikan_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Pekerjaan Wali</label>
                                        <input type="text" name="pekerjaan_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Penghasilan Wali</label>
                                        <input type="text" name="penghasilan_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. HP Wali</label>
                                        <input type="text" name="hp_wali" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Berkebutuhan Khusus Wali</label>
                                        <input type="text" name="disabilitas_wali" class="form-control" placeholder="Contoh: Tidak Ada">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- UPLOAD DOKUMEN -->
                        <div class="form-section">
                            <h5>5. Upload Dokumen</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Kartu Keluarga (KK)</label>
                                    <input type="file" name="kk" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <input type="file" name="akta_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">KTP Ayah</label>
                                    <input type="file" name="ktp_ayah" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">KTP Ibu</label>
                                    <input type="file" name="ktp_ibu" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">KTP Wali (Jika Ada)</label>
                                    <input type="file" name="ktp_wali" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ijazah Terakhir / SKL</label>
                                    <input type="file" name="ijazah" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle alamat domisili jika sama dengan KTP
    document.getElementById('domisili_sama_ktp').addEventListener('change', function() {
        const fields = document.getElementById('domisili_fields');
        if (this.checked) {
            fields.style.display = 'none';
        } else {
            fields.style.display = 'block';
        }
    });

    // Toggle data wali jika dicentang
    document.getElementById('ada_wali').addEventListener('change', function() {
        const waliFields = document.getElementById('wali_fields');
        if (this.checked) {
            waliFields.style.display = 'block';
        } else {
            waliFields.style.display = 'none';
        }
    });
</script>

</body>
</html>