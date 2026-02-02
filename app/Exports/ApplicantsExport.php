<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicantsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Applicant::all([
            'registration_number',
            'full_name',
            'nik',
            'birth_date',
            'major_choice',
            'phone',
            'email',
            'parent_ktp_village',
            'parent_ktp_rt',
            'parent_ktp_rw',
            'parent_ktp_subdistrict',
            'parent_ktp_district',
            'parent_ktp_city', // 👈 TAMBAHAN
            'parent_ktp_province',
            'current_village',
            'current_rt',
            'current_rw',
            'current_subdistrict',
            'current_district',
            'current_city', // 👈 TAMBAHAN
            'current_province',
            'status'
        ]);
    }

    public function headings(): array
    {
        return [
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'NIK',
            'Tanggal Lahir',
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
            'Status'
        ];
    }
}