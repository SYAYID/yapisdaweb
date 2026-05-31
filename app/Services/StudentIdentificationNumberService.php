<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\SmpApplicant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentIdentificationNumberService
{
    public function assignIfMissing(string $studentType, Model $student): string
    {
        if ($student->student_identification_number) {
            return $student->student_identification_number;
        }

        return DB::transaction(function () use ($studentType, $student) {
            $student->refresh();

            if ($student->student_identification_number) {
                return $student->student_identification_number;
            }

            $choice = $studentType === 'smp'
                ? ($student->school_program ?? null)
                : ($student->major_choice ?? null);
            $prefix = $this->academicYearCode() . $this->programCode($studentType, $choice);
            $sequence = $this->nextSequence($studentType, $prefix);
            $studentNumber = $prefix . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);

            $student->forceFill([
                'student_identification_number' => $studentNumber,
                'student_identification_assigned_at' => now('Asia/Jakarta'),
            ])->save();

            return $studentNumber;
        });
    }

    public function academicYearCode(): string
    {
        $now = now('Asia/Jakarta');

        return $now->format('y') . $now->copy()->addYear()->format('y');
    }

    public function programCode(string $studentType, ?string $choice): string
    {
        if ($studentType === 'smp') {
            return '00';
        }

        $normalized = Str::of((string) $choice)
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', ' ')
            ->squish()
            ->toString();

        return match (true) {
            str_contains($normalized, 'manajemen perkantoran') || str_contains($normalized, 'mplb') => '01',
            str_contains($normalized, 'kendaraan ringan') || str_contains($normalized, 'tkr') => '02',
            str_contains($normalized, 'teknik komputer') || str_contains($normalized, 'teknik kompter') || str_contains($normalized, 'tkj') => '03',
            str_contains($normalized, 'sepeda motor') || str_contains($normalized, 'tsm') => '04',
            str_contains($normalized, 'desain komunikasi visual') || str_contains($normalized, 'dkv') => '05',
            str_contains($normalized, 'akuntansi') || str_contains($normalized, 'akl') => '06',
            default => '99',
        };
    }

    private function nextSequence(string $studentType, string $prefix): int
    {
        $model = $studentType === 'smp' ? SmpApplicant::query() : Applicant::query();
        $latest = $model
            ->where('student_identification_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->max('student_identification_number');

        return $latest ? ((int) substr($latest, -3)) + 1 : 1;
    }
}
