<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\PaymentTransaction;
use App\Models\PaymentType;
use App\Models\SmpApplicant;
use Illuminate\Http\Request;

class ReEnrollmentStatusController extends Controller
{
    private ?int $uniformAmountCache = null;
    private ?int $uniformTypeIdCache = null;

    public function index(Request $request)
    {
        $query = trim((string) $request->query('q'));
        $results = collect();

        if ($query !== '') {
            $results = $this->findApplicants($query)
                ->map(fn(array $candidate) => $this->buildStatus($candidate))
                ->values();
        }

        return view('registration.reenrollment-status', [
            'query' => $query,
            'results' => $results,
            'uniformAmount' => $this->uniformAmount(),
        ]);
    }

    private function findApplicants(string $query)
    {
        $smk = Applicant::where('registration_number', $query)
            ->orWhere('nik', $query)
            ->limit(3)
            ->get()
            ->map(fn($applicant) => ['type' => 'smk', 'unit' => 'SMKS', 'model' => $applicant]);

        $smp = SmpApplicant::where('registration_number', $query)
            ->orWhere('nik', $query)
            ->limit(3)
            ->get()
            ->map(fn($applicant) => ['type' => 'smp', 'unit' => 'SMPS', 'model' => $applicant]);

        return $smk->merge($smp);
    }

    private function buildStatus(array $candidate): array
    {
        $applicant = $candidate['model'];
        $uniformAmount = $this->uniformAmount();
        $paid = $this->uniformPaid($candidate['type'], $applicant->id);
        $remaining = max(0, $uniformAmount - $paid);
        $choice = $candidate['type'] === 'smp'
            ? $applicant->school_program
            : $applicant->major_choice;

        if ($applicant->status !== 'verified') {
            $stage = $applicant->status === 'rejected' ? 'rejected' : 'not_verified';
            $title = $applicant->status === 'rejected'
                ? 'Pendaftaran belum dapat dilanjutkan'
                : 'Menunggu verifikasi admin';
            $message = $applicant->status === 'rejected'
                ? 'Silakan hubungi panitia untuk klarifikasi data pendaftaran.'
                : 'Data belum berstatus terverifikasi, sehingga belum masuk tahap daftar ulang.';
        } elseif ($remaining <= 0) {
            $stage = 'active_student';
            $title = 'Administrasi daftar ulang lengkap';
            $message = 'Kelengkapan administrasi atribut peserta didik sudah tercatat. Calon peserta didik dapat dinyatakan sebagai siswa YAPISDA sesuai ketentuan sekolah.';
        } else {
            $stage = 'uniform_unpaid';
            $title = 'Administrasi daftar ulang belum lengkap';
            $message = 'Pendaftaran sudah terverifikasi, tetapi status peserta didik aktif menunggu kelengkapan administrasi atribut peserta didik tercatat pada sistem sekolah.';
        }

        return [
            'type' => $candidate['type'],
            'unit' => $candidate['unit'],
            'name' => $applicant->full_name,
            'registration_number' => $applicant->registration_number,
            'choice' => $choice,
            'registration_status' => $applicant->status,
            'registered_at' => $applicant->registered_at_label,
            'verified_at' => $applicant->verified_at
                ? $applicant->verified_at->copy()->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB'
                : null,
            'uniform_required' => $uniformAmount,
            'uniform_paid' => $paid,
            'uniform_remaining' => $remaining,
            'stage' => $stage,
            'title' => $title,
            'message' => $message,
            'latest_payment_at' => $this->latestUniformPaymentAt($candidate['type'], $applicant->id),
        ];
    }

    private function uniformAmount(): int
    {
        return $this->uniformAmountCache ??= (int) (PaymentType::where('code', 'SERAGAM')->value('default_amount') ?: 1000000);
    }

    private function uniformTypeId(): ?int
    {
        return $this->uniformTypeIdCache ??= PaymentType::where('code', 'SERAGAM')->value('id');
    }

    private function uniformPaid(string $type, int $id): int
    {
        $paymentTypeId = $this->uniformTypeId();

        if (!$paymentTypeId) {
            return 0;
        }

        return (int) $this->uniformPaymentBaseQuery($type, $id, $paymentTypeId)->sum('amount');
    }

    private function latestUniformPaymentAt(string $type, int $id): ?string
    {
        $paymentTypeId = $this->uniformTypeId();

        if (!$paymentTypeId) {
            return null;
        }

        $paidAt = $this->uniformPaymentBaseQuery($type, $id, $paymentTypeId)
            ->latest('paid_at')
            ->value('paid_at');

        return $paidAt
            ? \Carbon\Carbon::parse($paidAt)->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB'
            : null;
    }

    private function uniformPaymentBaseQuery(string $type, int $id, int $paymentTypeId)
    {
        return PaymentTransaction::confirmed()
            ->where('payment_type_id', $paymentTypeId)
            ->where('direction', 'income')
            ->where('student_type', $type)
            ->when($type === 'smp',
                fn($query) => $query->where('smp_applicant_id', $id),
                fn($query) => $query->where('applicant_id', $id)
            );
    }
}
