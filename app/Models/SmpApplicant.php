<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmpApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'registration_number', 'kk_area', 'kk_number', 'nik', 'nisn',
        'student_identification_number', 'student_identification_assigned_at', 'full_name',
        'parent_ktp_residence_status', 'parent_ktp_distance_to_school',
        'parent_ktp_transportation', 'same_as_ktp', 'current_village',
        'current_rt', 'current_rw', 'current_subdistrict', 'current_district','current_city',
        'current_province', 'current_residence_status', 'current_distance_to_school',
        'current_transportation', 'father_nik', 'father_name', 'father_birth_place',
        'father_birth_date', 'father_education', 'father_occupation', 'father_income',
        'father_phone', 'father_disability', 'mother_nik', 'mother_name',
        'mother_birth_place', 'mother_birth_date', 'mother_education',
        'mother_occupation', 'mother_income', 'mother_phone', 'mother_disability',
        'has_guardian', 'guardian_nik', 'guardian_name', 'guardian_birth_place',
        'guardian_birth_date', 'guardian_education', 'guardian_occupation',
        'guardian_income', 'guardian_phone', 'guardian_disability', 'photo_path',
        'kk_path', 'birth_certificate_path', 'mother_ktp_path', 'father_ktp_path',
        'guardian_ktp_path', 'diploma_path', 'report_card_path', 'status'
    ];

    protected $casts = [
        'birth_date' => 'date:d/m/Y',
        'father_birth_date' => 'date:d/m/Y',
        'mother_birth_date' => 'date:d/m/Y',
        'guardian_birth_date' => 'date:d/m/Y',
        'same_as_ktp' => 'boolean',
        'has_guardian' => 'boolean',
        'verified_at' => 'datetime',
        'student_identification_assigned_at' => 'datetime',
    ];

    public function getRegistrationNumberAttribute($value)
    {
        return strtoupper($value);
    }

    public function freshTimestamp()
    {
        return now('Asia/Jakarta');
    }

    public function getRegisteredAtWibAttribute()
    {
        return $this->created_at?->copy()->timezone('Asia/Jakarta');
    }

    public function getRegisteredAtLabelAttribute(): string
    {
        return $this->registered_at_wib
            ? $this->registered_at_wib->format('d/m/Y H:i') . ' WIB'
            : '-';
    }

    public function getRegisteredDateLabelAttribute(): string
    {
        return $this->registered_at_wib
            ? $this->registered_at_wib->format('d/m/Y')
            : '-';
    }

    public function getRegisteredTimeLabelAttribute(): string
    {
        return $this->registered_at_wib
            ? $this->registered_at_wib->format('H:i') . ' WIB'
            : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->hasMany(ApplicantActivity::class, 'applicant_id')
            ->where('applicant_type', 'smp')
            ->latest();
    }
}
