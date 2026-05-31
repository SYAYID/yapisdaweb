<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\PaymentTransaction;
use App\Models\PaymentType;
use App\Models\SmpApplicant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaidApplicantController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'unit' => ['nullable', 'in:all,smk,smp,SMKS,SMPS'],
            'payment_status' => ['nullable', 'in:any,partial,paid'],
            'search' => ['nullable', 'string', 'max:120'],
            'include_transactions' => ['nullable', 'boolean'],
            'include_private' => ['nullable', 'boolean'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $uniformType = PaymentType::where('code', 'SERAGAM')->first();

        if (!$uniformType) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'total' => 0,
                    'count' => 0,
                    'message' => 'Jenis pembayaran SERAGAM belum tersedia.',
                ],
            ]);
        }

        $includeTransactions = $request->boolean('include_transactions');
        $includePrivate = $request->boolean('include_private');
        $rows = $this->paidApplicantRows($uniformType, $includeTransactions, $includePrivate);
        $rows = $this->applyFilters($rows, $request);
        $rows = $rows
            ->sortBy([
                ['latest_paid_at_sort', 'desc'],
                ['unit', 'asc'],
                ['full_name', 'asc'],
            ])
            ->values()
            ->map(fn(array $row) => collect($row)->except('latest_paid_at_sort')->all());

        $total = $rows->count();
        $perPageInput = $request->query('per_page', 50);

        if ($perPageInput === 'all') {
            $data = $rows->values();
            $page = 1;
            $perPage = 'all';
        } else {
            $perPage = max(1, min((int) $perPageInput, 200));
            $page = max(1, (int) $request->query('page', 1));
            $data = $rows->forPage($page, $perPage)->values();
        }

        return response()->json([
            'data' => $data,
            'meta' => [
                'total' => $total,
                'count' => $data->count(),
                'page' => $page,
                'per_page' => $perPage,
                'filters' => [
                    'unit' => $request->query('unit', 'all'),
                    'payment_status' => $request->query('payment_status', 'any'),
                    'search' => $request->query('search'),
                    'include_transactions' => $includeTransactions,
                    'include_private' => $includePrivate,
                ],
            ],
        ]);
    }

    private function paidApplicantRows(PaymentType $uniformType, bool $includeTransactions, bool $includePrivate): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkStats = $this->paymentStats($uniformType, 'smk');
        $smpStats = $this->paymentStats($uniformType, 'smp');
        $transactionDetails = $includeTransactions
            ? $this->transactionDetails($uniformType)
            : collect();

        $smk = Applicant::whereIn('id', $smkStats->keys())
            ->get()
            ->map(fn($student) => $this->studentRow('smk', $student, $smkStats->get($student->id), $requiredAmount, $transactionDetails, $includePrivate));

        $smp = SmpApplicant::whereIn('id', $smpStats->keys())
            ->get()
            ->map(fn($student) => $this->studentRow('smp', $student, $smpStats->get($student->id), $requiredAmount, $transactionDetails, $includePrivate));

        return $smk->merge($smp)->values();
    }

    private function studentRow(string $type, $student, $paymentStats, int $requiredAmount, Collection $transactionDetails, bool $includePrivate): array
    {
        $paidAmount = (int) ($paymentStats->paid_amount ?? 0);
        $latestPaidAt = $paymentStats?->latest_paid_at
            ? Carbon::parse($paymentStats->latest_paid_at)->timezone('Asia/Jakarta')
            : null;
        $firstPaidAt = $paymentStats?->first_paid_at
            ? Carbon::parse($paymentStats->first_paid_at)->timezone('Asia/Jakarta')
            : null;
        $studentKey = $type . ':' . $student->id;

        $row = [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'applicant_id' => $student->id,
            'registration_number' => $student->registration_number,
            'student_identification_number' => $student->student_identification_number,
            'full_name' => $student->full_name,
            'program' => $type === 'smp' ? $student->school_program : $student->major_choice,
            'gender' => $student->gender,
            'phone' => $student->phone,
            'email' => $student->email,
            'registration_status' => $student->status,
            'registered_at' => $student->created_at?->timezone('Asia/Jakarta')->toIso8601String(),
            'payment' => [
                'required_amount' => $requiredAmount,
                'paid_amount' => $paidAmount,
                'remaining_amount' => max(0, $requiredAmount - $paidAmount),
                'payment_status' => $paidAmount >= $requiredAmount ? 'paid' : 'partial',
                'transaction_count' => (int) ($paymentStats->transaction_count ?? 0),
                'first_paid_at' => $firstPaidAt?->toIso8601String(),
                'latest_paid_at' => $latestPaidAt?->toIso8601String(),
                'latest_reference_number' => $paymentStats->latest_reference_number ?? null,
            ],
            'latest_paid_at_sort' => $latestPaidAt?->timestamp ?? 0,
        ];

        if ($transactionDetails->isNotEmpty()) {
            $row['transactions'] = $transactionDetails->get($studentKey, collect())->values();
        }

        if ($includePrivate) {
            $row['private_data'] = $this->privateData($type, $student);
        }

        return $row;
    }

    private function privateData(string $type, $student): array
    {
        return [
            'identity' => [
                'kk_area' => $student->kk_area,
                'kk_number' => $student->kk_number,
                'nik' => $student->nik,
                'nisn' => $student->nisn,
                'citizenship' => $student->citizenship,
                'birth_certificate_number' => $student->birth_certificate_number,
                'student_identification_assigned_at' => $this->dateTimeValue($student->student_identification_assigned_at),
            ],
            'personal' => [
                'birth_place' => $student->birth_place,
                'birth_date' => $this->dateValue($student->birth_date),
                'religion' => $student->religion,
                'previous_school' => $student->previous_school,
                'program_field' => $type === 'smp' ? 'school_program' : 'major_choice',
                'program_value' => $type === 'smp' ? $student->school_program : $student->major_choice,
            ],
            'physical' => [
                'height' => $student->height,
                'weight' => $student->weight,
                'head_circumference' => $student->head_circumference,
                'siblings_count' => $student->siblings_count,
                'child_order' => $student->child_order,
                'disability' => $student->disability,
            ],
            'address' => [
                'same_as_ktp' => (bool) $student->same_as_ktp,
                'ktp' => [
                    'village' => $student->parent_ktp_village,
                    'rt' => $student->parent_ktp_rt,
                    'rw' => $student->parent_ktp_rw,
                    'subdistrict' => $student->parent_ktp_subdistrict,
                    'district' => $student->parent_ktp_district,
                    'city' => $student->parent_ktp_city,
                    'province' => $student->parent_ktp_province,
                    'residence_status' => $student->parent_ktp_residence_status,
                    'distance_to_school' => $student->parent_ktp_distance_to_school,
                    'transportation' => $student->parent_ktp_transportation,
                ],
                'current' => [
                    'village' => $student->current_village,
                    'rt' => $student->current_rt,
                    'rw' => $student->current_rw,
                    'subdistrict' => $student->current_subdistrict,
                    'district' => $student->current_district,
                    'city' => $student->current_city,
                    'province' => $student->current_province,
                    'residence_status' => $student->current_residence_status,
                    'distance_to_school' => $student->current_distance_to_school,
                    'transportation' => $student->current_transportation,
                ],
            ],
            'parents' => [
                'father' => [
                    'nik' => $student->father_nik,
                    'name' => $student->father_name,
                    'birth_place' => $student->father_birth_place,
                    'birth_date' => $this->dateValue($student->father_birth_date),
                    'education' => $student->father_education,
                    'occupation' => $student->father_occupation,
                    'income' => $student->father_income,
                    'phone' => $student->father_phone,
                    'disability' => $student->father_disability,
                ],
                'mother' => [
                    'nik' => $student->mother_nik,
                    'name' => $student->mother_name,
                    'birth_place' => $student->mother_birth_place,
                    'birth_date' => $this->dateValue($student->mother_birth_date),
                    'education' => $student->mother_education,
                    'occupation' => $student->mother_occupation,
                    'income' => $student->mother_income,
                    'phone' => $student->mother_phone,
                    'disability' => $student->mother_disability,
                ],
            ],
            'guardian' => [
                'has_guardian' => (bool) $student->has_guardian,
                'nik' => $student->guardian_nik,
                'name' => $student->guardian_name,
                'birth_place' => $student->guardian_birth_place,
                'birth_date' => $this->dateValue($student->guardian_birth_date),
                'education' => $student->guardian_education,
                'occupation' => $student->guardian_occupation,
                'income' => $student->guardian_income,
                'phone' => $student->guardian_phone,
                'disability' => $student->guardian_disability,
            ],
            'documents' => $this->documentsData($student),
            'timestamps' => [
                'created_at' => $this->dateTimeValue($student->created_at),
                'updated_at' => $this->dateTimeValue($student->updated_at),
                'verified_at' => $this->dateTimeValue($student->verified_at),
            ],
        ];
    }

    private function documentsData($student): array
    {
        return collect([
            'photo' => ['label' => 'Pas Foto', 'path' => $student->photo_path],
            'kk' => ['label' => 'Kartu Keluarga', 'path' => $student->kk_path],
            'birth_certificate' => ['label' => 'Akta Kelahiran', 'path' => $student->birth_certificate_path],
            'mother_ktp' => ['label' => 'KTP Ibu', 'path' => $student->mother_ktp_path],
            'father_ktp' => ['label' => 'KTP Ayah', 'path' => $student->father_ktp_path],
            'guardian_ktp' => ['label' => 'KTP Wali', 'path' => $student->guardian_ktp_path],
            'diploma' => ['label' => 'Ijazah/SKL', 'path' => $student->diploma_path],
            'report_card' => ['label' => 'Rapor', 'path' => $student->report_card_path],
        ])
            ->map(function (array $document) {
                $path = $document['path'];
                $isValidPath = filled($path)
                    && !str_contains($path, '..')
                    && !str_starts_with($path, '/')
                    && !str_starts_with($path, '\\');
                $exists = $isValidPath && Storage::disk('public')->exists($path);

                return [
                    'label' => $document['label'],
                    'path' => $path,
                    'exists' => $exists,
                    'url' => $exists ? url(Storage::url($path)) : null,
                ];
            })
            ->all();
    }

    private function dateValue($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    private function dateTimeValue($value): ?string
    {
        return $value ? Carbon::parse($value)->timezone('Asia/Jakarta')->toIso8601String() : null;
    }

    private function applyFilters(Collection $rows, Request $request): Collection
    {
        $unit = Str::lower((string) $request->query('unit', 'all'));
        $paymentStatus = (string) $request->query('payment_status', 'any');
        $search = Str::lower(trim((string) $request->query('search')));

        return $rows
            ->when(in_array($unit, ['smk', 'smp'], true), fn(Collection $items) => $items->where('type', $unit))
            ->when($paymentStatus !== 'any', fn(Collection $items) => $items->filter(fn(array $row) => $row['payment']['payment_status'] === $paymentStatus))
            ->when($search !== '', function (Collection $items) use ($search) {
                return $items->filter(function (array $row) use ($search) {
                    return Str::contains(Str::lower(implode(' ', [
                        $row['registration_number'],
                        $row['student_identification_number'],
                        $row['full_name'],
                        $row['program'],
                        $row['phone'],
                    ])), $search);
                });
            })
            ->values();
    }

    private function paymentStats(PaymentType $uniformType, string $type): Collection
    {
        $studentColumn = $type === 'smp' ? 'smp_applicant_id' : 'applicant_id';

        return PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', $type)
            ->whereNotNull($studentColumn)
            ->selectRaw($studentColumn . ' as student_id, SUM(amount) as paid_amount, COUNT(*) as transaction_count, MIN(paid_at) as first_paid_at, MAX(paid_at) as latest_paid_at')
            ->selectSub(function ($query) use ($uniformType, $type, $studentColumn) {
                $query->from('payment_transactions as latest_transactions')
                    ->select('latest_transactions.reference_number')
                    ->whereColumn('latest_transactions.' . $studentColumn, 'payment_transactions.' . $studentColumn)
                    ->where('latest_transactions.payment_type_id', $uniformType->id)
                    ->where('latest_transactions.direction', 'income')
                    ->where('latest_transactions.status', 'confirmed')
                    ->where('latest_transactions.student_type', $type)
                    ->orderByDesc('latest_transactions.paid_at')
                    ->orderByDesc('latest_transactions.id')
                    ->limit(1);
            }, 'latest_reference_number')
            ->groupBy($studentColumn)
            ->get()
            ->keyBy('student_id');
    }

    private function transactionDetails(PaymentType $uniformType): Collection
    {
        return PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->whereIn('student_type', ['smk', 'smp'])
            ->orderBy('paid_at')
            ->get(['id', 'student_type', 'applicant_id', 'smp_applicant_id', 'reference_number', 'amount', 'payment_method', 'paid_at', 'description'])
            ->map(function (PaymentTransaction $transaction) {
                $studentId = $transaction->student_type === 'smp'
                    ? $transaction->smp_applicant_id
                    : $transaction->applicant_id;

                return [
                    'student_key' => $transaction->student_type . ':' . $studentId,
                    'reference_number' => $transaction->reference_number,
                    'amount' => (int) $transaction->amount,
                    'payment_method' => $transaction->payment_method,
                    'paid_at' => $transaction->paid_at?->timezone('Asia/Jakarta')->toIso8601String(),
                    'description' => $transaction->description,
                ];
            })
            ->groupBy('student_key')
            ->map(fn(Collection $items) => $items->map(fn(array $item) => collect($item)->except('student_key')->all())->values());
    }
}
