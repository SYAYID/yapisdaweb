<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number', 'kk_area', 'kk_number', 'nik', 'nisn', 'full_name',
        'gender', 'birth_place', 'birth_date', 'religion', 'phone', 'email',
        'previous_school', 'major_choice', 'citizenship', 'birth_certificate_number',
        'height', 'weight', 'head_circumference', 'siblings_count', 'child_order',
        'disability', 'parent_ktp_village', 'parent_ktp_rt', 'parent_ktp_rw',
        'parent_ktp_subdistrict', 'parent_ktp_district','parent_ktp_city', 'parent_ktp_province',
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
    ];

    public function getRegistrationNumberAttribute($value)
    {
        return strtoupper($value);
    }
}