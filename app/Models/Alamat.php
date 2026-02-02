<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id', 'kampung_ktp', 'rt_ktp', 'rw_ktp', 'desa_kelurahan_ktp',
        'kecamatan_ktp', 'provinsi_ktp', 'domisili_sama_ktp',
        'kampung_domisili', 'rt_domisili', 'rw_domisili', 'desa_kelurahan_domisili',
        'kecamatan_domisili', 'provinsi_domisili', 'status_tempat_tinggal',
        'jarak_ke_sekolah', 'moda_transportasi'
    ];
}