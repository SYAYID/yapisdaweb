<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Alamat;
use App\Models\OrangTua;
use App\Models\Dokumen;

class PPDBController extends Controller
{
    public function create()
    {
        return view('ppdb.form');
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|unique:siswas,nik',
            'no_kk' => 'required',
            'foto_pas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_lahir' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan data siswa
        $siswa = Siswa::create($request->only([
            'wilayah_kk', 'no_kk', 'nik', 'nisn', 'nama_lengkap',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
            'no_hp', 'email', 'asal_sekolah', 'jurusan_pilihan_1',
            'jurusan_pilihan_2', 'kewarganegaraan', 'no_akta_lahir',
            'tinggi_badan', 'berat_badan', 'lingkar_kepala',
            'jumlah_saudara', 'anak_ke', 'disabilitas'
        ]));

        // Upload foto pas
        if ($request->hasFile('foto_pas')) {
            $path = $request->file('foto_pas')->store('uploads/foto', 'public');
            $siswa->update(['foto_pas' => $path]);
        }

        // Simpan alamat
        $alamatData = $request->only([
            'kampung_ktp', 'rt_ktp', 'rw_ktp', 'desa_kelurahan_ktp',
            'kecamatan_ktp', 'provinsi_ktp', 'status_tempat_tinggal',
            'jarak_ke_sekolah', 'moda_transportasi'
        ]);
        $alamatData['siswa_id'] = $siswa->id;
        $alamatData['domisili_sama_ktp'] = $request->filled('domisili_sama_ktp');

        Alamat::create($alamatData);

        // Simpan orang tua
        $ortuData = $request->only([
            // Ayah
            'nik_ayah', 'nama_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
            'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'hp_ayah', 'disabilitas_ayah',
            // Ibu
            'nik_ibu', 'nama_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
            'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'hp_ibu', 'disabilitas_ibu',
            // Wali
            'ada_wali', 'nik_wali', 'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali',
            'pendidikan_wali', 'pekerjaan_wali', 'penghasilan_wali', 'hp_wali', 'disabilitas_wali'
        ]);
        $ortuData['siswa_id'] = $siswa->id;
        OrangTua::create($ortuData);

        // Simpan dokumen
        $dokumen = new Dokumen();
        $dokumen->siswa_id = $siswa->id;

        // Upload file dokumen
        foreach (['kk', 'akta_lahir', 'ktp_ayah', 'ktp_ibu', 'ktp_wali', 'ijazah'] as $doc) {
            if ($request->hasFile($doc)) {
                $path = $request->file($doc)->store('uploads/dokumen', 'public');
                $dokumen->{$doc . '_path'} = $path;
            }
        }

        $dokumen->save();

        return redirect()->back()->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $siswa->id);
    }
}