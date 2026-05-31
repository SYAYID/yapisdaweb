<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicantsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Applicant::latest()->get();
    }

    public function map($applicant): array
    {
        return [
            $applicant->registration_number,
            $applicant->kk_area,
            "'" . $applicant->kk_number,
            $applicant->full_name,
            "'" . $applicant->nik,
            $applicant->nisn,
            $applicant->gender,
            $applicant->birth_place,
            optional($applicant->birth_date)->format('d/m/Y'),
            $applicant->birth_certificate_number,
            $applicant->religion,
            $applicant->previous_school,
            $applicant->major_choice,
            $applicant->phone,
            $applicant->email,
            $applicant->parent_ktp_village,
            $applicant->parent_ktp_rt,
            $applicant->parent_ktp_rw,
            $applicant->parent_ktp_subdistrict,
            $applicant->parent_ktp_district,
            $applicant->parent_ktp_city,
            $applicant->parent_ktp_province,
            $applicant->current_village,
            $applicant->current_rt,
            $applicant->current_rw,
            $applicant->current_subdistrict,
            $applicant->current_district,
            $applicant->current_city,
            $applicant->current_province,
            $applicant->registered_at_label,
            $applicant->status,
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Pendaftaran',
            'Wilayah KK',
            'Nomor KK',
            'Nama Lengkap',
            'NIK',
            'NISN',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Nomor Akta Lahir',
            'Agama',
            'Asal Sekolah',
            'Jurusan Pilihan',
            'No. HP',
            'Email',
            'Alamat KTP - Kampung',
            'Alamat KTP - RT',
            'Alamat KTP - RW',
            'Alamat KTP - Desa/Kel',
            'Alamat KTP - Kecamatan',
            'Alamat KTP - Kab/Kota', // 👈 TAMBAHAN
            'Alamat KTP - Provinsi',
            'Alamat Domisili - Kampung',
            'Alamat Domisili - RT',
            'Alamat Domisili - RW',
            'Alamat Domisili - Desa/Kel',
            'Alamat Domisili - Kecamatan',
            'Alamat Domisili - Kab/Kota', // 👈 TAMBAHAN
            'Alamat Domisili - Provinsi',
            'Waktu Registrasi',
            'Status'
        ];
    }
}
