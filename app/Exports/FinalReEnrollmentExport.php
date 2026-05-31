<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinalReEnrollmentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(private Collection $rows)
    {
    }

    public function collection()
    {
        return $this->rows->map(fn(array $row) => [
            $row['unit'],
            $row['student_identification_number'],
            $row['registration_number'],
            $row['name'],
            $row['choice'],
            $row['phone'],
            $row['registered_at'],
            $row['paid_at'],
            $row['transaction_count'],
            $row['paid_amount'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Unit',
            'NIS',
            'Nomor Pendaftaran',
            'Nama Siswa',
            'Jurusan/Program',
            'No. HP',
            'Waktu Registrasi',
            'Waktu Lunas',
            'Jumlah Transaksi',
            'Total Dibayar',
        ];
    }
}
