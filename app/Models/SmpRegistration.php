<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmpRegistration extends Model
{
    use HasFactory;

    protected $table = 'smp_registrations'; // Tabel khusus SMP

    protected $fillable = [
        'school_program', // 'Umum' atau 'Pesantren' (menggantikan 'major')
        'quota',
        'used_quota'
    ];

    /**
     * Accessor: Kuota tersedia
     */
    public function getAvailableQuotaAttribute()
    {
        return max(0, $this->quota - $this->used_quota);
    }

    /**
     * Accessor: Persentase terisi
     */
    public function getPercentageAttribute()
    {
        return $this->quota > 0
            ? round(($this->used_quota / $this->quota) * 100, 2)
            : 0;
    }

    /**
     * Accessor: Status kuota (full/low/available)
     */
    public function getStatusAttribute()
    {
        if ($this->available_quota <= 0) {
            return 'full';
        } elseif ($this->available_quota <= 10) {
            return 'low';
        }
        return 'available';
    }

    /**
     * Relasi ke tabel applicants SMP (jika dipisah)
     */
    public function applicants()
    {
        return $this->hasMany(SmpApplicant::class, 'school_program', 'school_program');
    }
}
