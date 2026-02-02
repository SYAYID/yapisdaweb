<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'wilayah_kk', 'no_kk', 'nik', 'nisn', 'nama_lengkap',
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
        'no_hp', 'email', 'asal_sekolah', 'jurusan_pilihan_1',
        'jurusan_pilihan_2', 'kewarganegaraan', 'no_akta_lahir',
        'tinggi_badan', 'berat_badan', 'lingkar_kepala',
        'jumlah_saudara', 'anak_ke', 'disabilitas', 'foto_pas'
    ];
}