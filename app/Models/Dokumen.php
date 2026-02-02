<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id', 'kk_path', 'akta_lahir_path', 'ktp_ayah_path',
        'ktp_ibu_path', 'ktp_wali_path', 'ijazah_path'
    ];
}