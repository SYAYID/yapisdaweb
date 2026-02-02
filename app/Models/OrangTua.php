<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id', 'nik_ayah', 'nama_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
        'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'hp_ayah', 'disabilitas_ayah',
        'nik_ibu', 'nama_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
        'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'hp_ibu', 'disabilitas_ibu',
        'ada_wali', 'nik_wali', 'nama_wali', 'tempat_lahir_wali', 'tanggal_lahir_wali',
        'pendidikan_wali', 'pekerjaan_wali', 'penghasilan_wali', 'hp_wali', 'disabilitas_wali'
    ];
}