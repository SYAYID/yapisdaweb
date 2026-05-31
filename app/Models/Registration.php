<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['major', 'quota', 'used_quota'];

    public function getAvailableQuotaAttribute()
    {
        return max(0, $this->quota - $this->used_quota);
    }
     public function getPercentageAttribute()
    {
        return $this->quota > 0 ? round(($this->used_quota / $this->quota) * 100, 2) : 0;
    }

    /**
     * Accessor untuk status kuota
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
    // Di app/Models/Registration.php
public function applicants()
{
    return $this->hasMany(Applicant::class, 'major_choice', 'major');
}
}
