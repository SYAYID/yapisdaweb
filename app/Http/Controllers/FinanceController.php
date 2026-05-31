<?php

namespace App\Http\Controllers;

use App\Exports\FinalReEnrollmentExport;
use App\Models\Applicant;
use App\Models\AuditLog;
use App\Models\PaymentTransaction;
use App\Models\PaymentType;
use App\Models\SmpApplicant;
use App\Models\UniformProfile;
use App\Services\StudentIdentificationNumberService;
use App\Support\AuditLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function login()
    {
        return view('admin.finance.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $guard = Auth::guard('finance');

        if ($guard->attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (!$guard->user()->hasRole(['finance', 'super_admin'])) {
                $guard->logout();

                return back()
                    ->withInput($request->only('username'))
                    ->with('error', 'Akun ini tidak memiliki akses keuangan.');
            }

            return redirect()->intended(route('admin.finance.dashboard'));
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Email atau password tidak sesuai.');
    }

    public function logout(Request $request)
    {
        Auth::guard('finance')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('admin.finance.login');
    }

    public function index(Request $request)
    {
        $adminSection = match ($request->route()?->getName()) {
            'admin.finance.transactions.create' => 'payment-form',
            'admin.finance.uniform-report' => 'uniform-report',
            'admin.finance.daily-report' => 'daily-report',
            'admin.finance.mutations' => 'mutation-report',
            'admin.finance.payment-types' => 'payment-types',
            'admin.finance.final-progress' => 'final-progress',
            'admin.finance.uniform-sizes' => 'uniform-sizes',
            'admin.finance.guide' => 'guide',
            default => 'dashboard',
        };

        $uniformType = $this->ensureUniformPaymentType();
        $this->syncStudentNumbersForPaidStudents($uniformType);

        $reportDate = $request->date('date') ?: today();
        $studentType = $request->query('student_type');
        $direction = $request->query('direction');
        $search = trim((string) $request->query('search'));
        $status = $request->query('status');

        $paymentTypes = PaymentType::orderByDesc('is_active')
            ->orderBy('direction')
            ->orderBy('name')
            ->get();

        $transactionsQuery = PaymentTransaction::with(['paymentType', 'smkApplicant', 'smpApplicant', 'creator'])
            ->when(in_array($studentType, ['smk', 'smp'], true), fn($query) => $query->where('student_type', $studentType))
            ->when(in_array($direction, ['income', 'outcome'], true), fn($query) => $query->where('direction', $direction))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('reference_number', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('smkApplicant', fn($student) => $student
                            ->where('full_name', 'like', "%{$search}%")
                            ->orWhere('registration_number', 'like', "%{$search}%"))
                        ->orWhereHas('smpApplicant', fn($student) => $student
                            ->where('full_name', 'like', "%{$search}%")
                            ->orWhere('registration_number', 'like', "%{$search}%"));
                });
            })
            ->latest('paid_at');

        $transactions = $transactionsQuery->paginate(30)->withQueryString();
        $cardStates = $this->buildStudentCardStates($transactions->getCollection(), $uniformType);
        $dailyBase = PaymentTransaction::confirmed()->whereDate('paid_at', $reportDate);
        $monthBase = PaymentTransaction::confirmed()
            ->whereYear('paid_at', $reportDate->year)
            ->whereMonth('paid_at', $reportDate->month);

        $dailyIncome = (int) (clone $dailyBase)->where('direction', 'income')->sum('amount');
        $dailyOutcome = (int) (clone $dailyBase)->where('direction', 'outcome')->sum('amount');
        $monthlyIncome = (int) (clone $monthBase)->where('direction', 'income')->sum('amount');
        $monthlyOutcome = (int) (clone $monthBase)->where('direction', 'outcome')->sum('amount');

        $dailyByType = (clone $dailyBase)
            ->with('paymentType')
            ->selectRaw('payment_type_id, direction, SUM(amount) as total, COUNT(*) as transaction_count')
            ->groupBy('payment_type_id', 'direction')
            ->get();

        $receivables = $this->buildUniformReceivables(
            $uniformType,
            $adminSection === 'uniform-report' ? $search : null,
            $adminSection === 'uniform-report' ? $studentType : null,
            $adminSection === 'uniform-report' ? $status : null
        );
        $finalRows = $this->buildFinalReEnrollmentRows($uniformType);
        $students = $this->buildStudentOptions();
        $finalProgress = $this->buildFinalProgress($uniformType);
        $uniformSizeRows = $this->buildUniformSizeRows(
            $uniformType,
            $adminSection === 'uniform-sizes' ? $search : null,
            $adminSection === 'uniform-sizes' ? $studentType : null,
            $adminSection === 'uniform-sizes' ? $status : null
        );

        $summary = [
            'date' => $reportDate,
            'daily_income' => $dailyIncome,
            'daily_outcome' => $dailyOutcome,
            'daily_net' => $dailyIncome - $dailyOutcome,
            'monthly_income' => $monthlyIncome,
            'monthly_outcome' => $monthlyOutcome,
            'monthly_net' => $monthlyIncome - $monthlyOutcome,
            'uniform_required' => $receivables['required_total'],
            'uniform_collected' => $receivables['paid_total'],
            'uniform_remaining' => $receivables['remaining_total'],
            'uniform_paid_students' => $receivables['paid_students'],
            'uniform_total_students' => $receivables['total_students'],
            'final_reenrollment_total' => $finalRows->count(),
            'final_progress_rate' => $finalProgress['overall']['final_rate'],
        ];

        return view('admin.finance.dashboard', compact(
            'paymentTypes',
            'transactions',
            'dailyByType',
            'summary',
            'receivables',
            'students',
            'uniformType',
            'cardStates',
            'adminSection',
            'finalProgress',
            'uniformSizeRows'
        ));
    }

    public function searchVerifiedStudents(Request $request)
    {
        $search = trim((string) $request->query('q'));

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $smk = Applicant::where('status', 'verified')
            ->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('student_identification_number', 'like', "%{$search}%");
            })
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice'])
            ->map(fn($student) => $this->formatStudentOption($student, 'smk'));

        $smp = SmpApplicant::where('status', 'verified')
            ->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('student_identification_number', 'like', "%{$search}%");
            })
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program'])
            ->map(fn($student) => $this->formatStudentOption($student, 'smp'));

        return response()->json(
            $smk->merge($smp)->sortBy('label')->values()
        );
    }

    public function finalReport(Request $request)
    {
        $uniformType = $this->ensureUniformPaymentType();
        $this->syncStudentNumbersForPaidStudents($uniformType);

        $unit = $request->query('unit');
        $search = trim((string) $request->query('search'));
        $rows = $this->buildFinalReEnrollmentRows($uniformType, in_array($unit, ['smk', 'smp'], true) ? $unit : null, $search);

        $summary = [
            'total_students' => $rows->count(),
            'smk_students' => $rows->where('type', 'smk')->count(),
            'smp_students' => $rows->where('type', 'smp')->count(),
            'paid_total' => $rows->sum('paid_amount'),
        ];

        return view('admin.finance.final-report', compact('rows', 'summary', 'uniformType', 'unit', 'search'));
    }

    public function exportFinalReport(Request $request)
    {
        $uniformType = $this->ensureUniformPaymentType();
        $this->syncStudentNumbersForPaidStudents($uniformType);

        $unit = $request->query('unit');
        $search = trim((string) $request->query('search'));
        $rows = $this->buildFinalReEnrollmentRows($uniformType, in_array($unit, ['smk', 'smp'], true) ? $unit : null, $search);

        AuditLogger::record('finance.final_report_exported', 'Laporan daftar ulang final diexport.', null, [
            'unit' => $unit ?: 'all',
            'search' => $search ?: 'all',
            'total_rows' => $rows->count(),
        ]);

        return Excel::download(new FinalReEnrollmentExport($rows), 'laporan-daftar-ulang-final-' . now('Asia/Jakarta')->format('Y-m-d') . '.xlsx');
    }

    public function printStudentCard(PaymentTransaction $transaction)
    {
        $transaction->loadMissing(['paymentType', 'smkApplicant', 'smpApplicant', 'creator']);

        if ($transaction->status !== 'confirmed' || $transaction->direction !== 'income' || !in_array($transaction->student_type, ['smk', 'smp'], true)) {
            return redirect()
                ->route('admin.finance.dashboard')
                ->with('error', 'Kartu siswa hanya bisa dicetak dari transaksi income yang sudah confirmed.');
        }

        $student = $transaction->student_type === 'smp'
            ? $transaction->smpApplicant
            : $transaction->smkApplicant;

        if (!$student || $student->status !== 'verified') {
            return redirect()
                ->route('admin.finance.dashboard')
                ->with('error', 'Kartu siswa hanya bisa dicetak untuk siswa yang sudah verified.');
        }

        $uniformType = $this->ensureUniformPaymentType();
        $uniformPaidQuery = PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', $transaction->student_type);

        if ($transaction->student_type === 'smp') {
            $uniformPaidQuery->where('smp_applicant_id', $student->id);
        } else {
            $uniformPaidQuery->where('applicant_id', $student->id);
        }

        $uniformPaid = (int) $uniformPaidQuery->sum('amount');

        $this->assignStudentNumber($transaction->student_type, $student, $transaction);
        $student->refresh();

        if (!$student->student_identification_number) {
            return redirect()
                ->route('admin.finance.dashboard')
                ->with('error', 'NIS belum berhasil dibuat. Silakan coba cetak ulang setelah transaksi tersimpan.');
        }

        $choice = $this->studentChoice($transaction->student_type, $student);

        AuditLogger::record('finance.student_card_printed', 'Kartu siswa dicetak.', $transaction, [
            'student_type' => $transaction->student_type,
            'student_id' => $student->id,
            'student_identification_number' => $student->student_identification_number,
        ]);

        $card = [
            'unit' => $transaction->student_type === 'smp' ? 'SMPS' : 'SMKS',
            'name' => $student->full_name,
            'student_identification_number' => $student->student_identification_number,
            'registration_number' => $student->registration_number,
            'choice' => $choice,
            'theme_color' => $this->cardColorForChoice($choice),
            'photo_url' => $student->photo_path
                ? route('admin.finance.student-photo', ['type' => $transaction->student_type, 'id' => $student->id])
                : null,
            'uniform_required' => (int) $uniformType->default_amount,
            'uniform_paid' => $uniformPaid,
        ];

        return view('admin.finance.student-card-print', compact('transaction', 'student', 'card'));
    }

    public function printReceipt(PaymentTransaction $transaction)
    {
        $transaction->loadMissing(['paymentType', 'smkApplicant', 'smpApplicant', 'creator']);

        abort_unless($transaction->status === 'confirmed', 404);

        $student = $this->studentForTransaction($transaction);
        $choice = $student ? $this->studentChoice($transaction->student_type, $student) : null;

        AuditLogger::record('finance.receipt_printed', 'Kwitansi pembayaran dicetak.', $transaction, [
            'reference_number' => $transaction->reference_number,
            'amount' => $transaction->amount,
        ]);

        $receipt = [
            'unit' => $transaction->student_unit,
            'student_name' => $student?->full_name ?? '-',
            'student_identification_number' => $student?->student_identification_number,
            'registration_number' => $student?->registration_number,
            'choice' => $choice,
            'reference_number' => $transaction->reference_number,
            'payment_type' => $transaction->paymentType?->name ?? '-',
            'amount' => (int) $transaction->amount,
            'direction' => $transaction->direction === 'income' ? 'Pemasukan' : 'Pengeluaran',
            'payment_method' => strtoupper($transaction->payment_method),
            'paid_at' => $this->formatWib($transaction->paid_at),
            'description' => $transaction->description,
            'officer' => $transaction->creator?->name ?? Auth::user()?->name ?? '-',
        ];

        return view('admin.finance.payment-receipt-print', compact('transaction', 'receipt'));
    }

    public function printStudentLetter(string $type, int $id, string $template)
    {
        abort_unless(in_array($type, ['smk', 'smp'], true), 404);
        abort_unless(in_array($template, ['accepted', 'reenrollment', 'parent-call'], true), 404);

        $student = $type === 'smp'
            ? SmpApplicant::findOrFail($id)
            : Applicant::findOrFail($id);

        $uniformType = $this->ensureUniformPaymentType();
        $stats = $this->uniformPaymentStats($uniformType, $type)->get($student->id);
        $paidAmount = (int) ($stats->paid_amount ?? 0);
        $requiredAmount = (int) $uniformType->default_amount;
        $profile = UniformProfile::where('student_type', $type)
            ->where('student_id', $student->id)
            ->first();

        $letter = [
            'template' => $template,
            'title' => $this->letterTitle($template),
            'number' => 'SPMB/' . strtoupper($type) . '/' . now('Asia/Jakarta')->format('Ymd') . '/' . str_pad((string) $student->id, 4, '0', STR_PAD_LEFT),
            'unit' => $type === 'smp' ? 'SMPS YAPISDA' : 'SMKS YAPISDA',
            'student_type' => $type,
            'name' => $student->full_name,
            'registration_number' => $student->registration_number,
            'student_identification_number' => $student->student_identification_number,
            'choice' => $this->studentChoice($type, $student),
            'phone' => $student->phone,
            'status' => $student->status,
            'registered_at' => $student->registered_at_label,
            'paid_amount' => $paidAmount,
            'required_amount' => $requiredAmount,
            'remaining_amount' => max(0, $requiredAmount - $paidAmount),
            'uniform_profile' => $profile,
            'printed_at' => now('Asia/Jakarta')->translatedFormat('d F Y H:i') . ' WIB',
            'officer' => Auth::user()?->name ?? 'Petugas Administrasi',
        ];

        AuditLogger::record('finance.student_letter_printed', 'Surat otomatis siswa dicetak.', $student, [
            'student_type' => $type,
            'template' => $template,
            'registration_number' => $student->registration_number,
        ]);

        return view('admin.finance.student-letter-print', compact('student', 'letter'));
    }

    public function storeUniformProfile(Request $request)
    {
        $validated = $request->validate([
            'student_key' => ['required', 'string', 'max:40'],
            'shirt_size' => ['nullable', 'string', 'max:20'],
            'pants_size' => ['nullable', 'string', 'max:20'],
            'attribute_status' => ['required', 'in:not_recorded,recorded,prepared,distributed'],
            'picked_up_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $student = $this->resolveVerifiedStudent($validated['student_key']);

        if (!$student) {
            return back()
                ->withInput()
                ->with('error', 'Siswa tidak ditemukan atau belum berstatus verified.');
        }

        $profile = UniformProfile::updateOrCreate(
            [
                'student_type' => $student['type'],
                'student_id' => $student['id'],
            ],
            [
                'shirt_size' => $validated['shirt_size'] ?? null,
                'pants_size' => $validated['pants_size'] ?? null,
                'attribute_status' => $validated['attribute_status'],
                'picked_up_at' => $validated['picked_up_at'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'updated_by_user_id' => Auth::id(),
            ]
        );

        AuditLogger::record('finance.uniform_profile_saved', 'Ukuran seragam siswa disimpan.', $profile, [
            'student_type' => $student['type'],
            'student_id' => $student['id'],
            'student_name' => $student['model']->full_name,
            'attribute_status' => $profile->attribute_status,
        ]);

        return redirect()
            ->route('admin.finance.uniform-sizes')
            ->with('success', 'Ukuran seragam dan atribut siswa berhasil disimpan.');
    }

    public function auditLogs(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $event = trim((string) $request->query('event'));

        $logs = AuditLog::query()
            ->with('user')
            ->when($event !== '', fn($query) => $query->where('event', $event))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('description', 'like', "%{$search}%")
                        ->orWhere('subject_label', 'like', "%{$search}%")
                        ->orWhere('user_name', 'like', "%{$search}%")
                        ->orWhere('event', 'like', "%{$search}%");
                });
            })
            ->latest('occurred_at')
            ->paginate(40)
            ->withQueryString();

        $events = AuditLog::query()
            ->select('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        return view('admin.finance.audit-logs', compact('logs', 'events', 'search', 'event'));
    }

    public function previewStudentPhoto(string $type, int $id)
    {
        abort_unless(in_array($type, ['smk', 'smp'], true), 404);

        $student = $type === 'smp'
            ? SmpApplicant::where('status', 'verified')->findOrFail($id)
            : Applicant::where('status', 'verified')->findOrFail($id);

        abort_if(!$student->photo_path || !Storage::disk('public')->exists($student->photo_path), 404);

        return response()->file(Storage::disk('public')->path($student->photo_path), [
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    public function storePaymentType(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'default_amount' => ['required', 'integer', 'min:0'],
            'direction' => ['required', 'in:income,outcome'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $code = $validated['code'] ?: Str::upper(Str::slug($validated['name'], '_'));
        $baseCode = $code;
        $suffix = 2;

        while (PaymentType::where('code', $code)->exists()) {
            $code = $baseCode . '_' . $suffix;
            $suffix++;
        }

        $paymentType = PaymentType::create([
            'name' => $validated['name'],
            'code' => $code,
            'description' => $validated['description'] ?? null,
            'default_amount' => $validated['default_amount'],
            'direction' => $validated['direction'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        AuditLogger::record('finance.payment_type_created', 'Jenis pembayaran baru dibuat.', $paymentType, [
            'code' => $paymentType->code,
            'direction' => $paymentType->direction,
            'default_amount' => $paymentType->default_amount,
        ]);

        return back()->with('success', 'Jenis pembayaran berhasil dibuat.');
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'direction' => ['nullable', 'in:income,outcome'],
            'amount' => ['nullable', 'integer', 'min:1'],
            'student_key' => ['nullable', 'string', 'max:40'],
            'payment_method' => ['required', 'string', 'max:50'],
            'paid_at' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:80', 'unique:payment_transactions,reference_number'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $paymentType = PaymentType::findOrFail($validated['payment_type_id']);
        $direction = $validated['direction'] ?? $paymentType->direction;
        $student = $this->resolveVerifiedStudent($validated['student_key'] ?? null);
        $amount = (int) (($validated['amount'] ?? null) ?: $paymentType->default_amount);

        if (($validated['student_key'] ?? null) && !$student) {
            return back()
                ->withInput()
                ->with('error', 'Siswa tidak ditemukan atau belum berstatus verified.');
        }

        if ($paymentType->code === 'SERAGAM' && !$student) {
            return back()
                ->withInput()
                ->with('error', 'Pembayaran uang seragam wajib memilih siswa yang sudah verified.');
        }

        if ($amount < 1) {
            return back()
                ->withInput()
                ->with('error', 'Nominal transaksi harus lebih dari 0.');
        }

        $transaction = DB::transaction(function () use ($paymentType, $direction, $amount, $student, $validated) {
            $transaction = PaymentTransaction::create([
                'payment_type_id' => $paymentType->id,
                'direction' => $direction,
                'amount' => $amount,
                'student_type' => $student['type'] ?? null,
                'applicant_id' => ($student['type'] ?? null) === 'smk' ? $student['id'] : null,
                'smp_applicant_id' => ($student['type'] ?? null) === 'smp' ? $student['id'] : null,
                'payment_method' => $validated['payment_method'],
                'reference_number' => ($validated['reference_number'] ?? null) ?: $this->makeReferenceNumber(),
                'paid_at' => $validated['paid_at'],
                'description' => $validated['description'] ?? $paymentType->name,
                'notes' => $validated['notes'] ?? null,
                'created_by_user_id' => Auth::id(),
                'status' => 'confirmed',
            ]);

            AuditLogger::record('finance.transaction_created', 'Transaksi keuangan dicatat.', $transaction, [
                'payment_type' => $paymentType->code,
                'direction' => $transaction->direction,
                'amount' => $transaction->amount,
                'student_type' => $transaction->student_type,
            ]);

            if ($student && $direction === 'income') {
                $this->assignStudentNumber($student['type'], $student['model'], $transaction);
            }

            return $transaction;
        });

        return back()->with('success', 'Transaksi berhasil dicatat. No. referensi: ' . $transaction->reference_number);
    }

    private function ensureUniformPaymentType(): PaymentType
    {
        return PaymentType::firstOrCreate(
            ['code' => 'SERAGAM'],
            [
                'name' => 'Uang Seragam',
                'description' => 'Pembayaran wajib seragam siswa.',
                'default_amount' => 1000000,
                'direction' => 'income',
                'is_active' => true,
            ]
        );
    }

    private function buildFinalProgress(PaymentType $uniformType): array
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');
        $uniformProfiles = UniformProfile::all()->keyBy(fn($profile) => $profile->student_key);
        $cardPrintedKeys = $this->studentCardPrintedKeys();

        $smkRows = Applicant::where('status', 'verified')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice'])
            ->map(fn($student) => $this->finalProgressStudentRow('smk', $student, $smkPaid->get($student->id), $requiredAmount, $uniformProfiles, $cardPrintedKeys));

        $smpRows = SmpApplicant::where('status', 'verified')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program'])
            ->map(fn($student) => $this->finalProgressStudentRow('smp', $student, $smpPaid->get($student->id), $requiredAmount, $uniformProfiles, $cardPrintedKeys));

        $rows = $smkRows->merge($smpRows)->values();

        return [
            'required_amount' => $requiredAmount,
            'overall' => $this->progressSummaryForRows($rows),
            'by_unit' => [
                'smk' => $this->progressSummaryForRows($smkRows),
                'smp' => $this->progressSummaryForRows($smpRows),
            ],
            'lanes' => $this->progressLanesForRows($rows),
            'attention_rows' => $rows
                ->filter(fn($row) => !$row['is_final'] || !$row['has_uniform_profile'])
                ->sortByDesc('remaining_amount')
                ->take(12)
                ->values(),
        ];
    }

    private function finalProgressStudentRow(string $type, $student, $paymentStats, int $requiredAmount, Collection $uniformProfiles, array $cardPrintedKeys): array
    {
        $paidAmount = (int) ($paymentStats->paid_amount ?? 0);
        $key = $type . ':' . $student->id;

        return [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'student_id' => $student->id,
            'student_key' => $key,
            'registration_number' => $student->registration_number,
            'student_identification_number' => $student->student_identification_number,
            'name' => $student->full_name,
            'choice' => $this->studentChoice($type, $student),
            'paid_amount' => $paidAmount,
            'remaining_amount' => max(0, $requiredAmount - $paidAmount),
            'has_payment' => $paidAmount > 0,
            'is_paid' => $paidAmount >= $requiredAmount,
            'has_student_number' => (bool) $student->student_identification_number,
            'has_card_printed' => in_array($key, $cardPrintedKeys, true),
            'has_uniform_profile' => $uniformProfiles->has($key),
            'is_final' => $paidAmount >= $requiredAmount && (bool) $student->student_identification_number,
        ];
    }

    private function progressSummaryForRows(Collection $rows): array
    {
        $total = $rows->count();

        return [
            'verified' => $total,
            'has_payment' => $rows->where('has_payment', true)->count(),
            'paid' => $rows->where('is_paid', true)->count(),
            'student_number' => $rows->where('has_student_number', true)->count(),
            'card_printed' => $rows->where('has_card_printed', true)->count(),
            'uniform_profile' => $rows->where('has_uniform_profile', true)->count(),
            'final' => $rows->where('is_final', true)->count(),
            'final_rate' => $total > 0 ? round(($rows->where('is_final', true)->count() / $total) * 100, 1) : 0,
        ];
    }

    private function progressLanesForRows(Collection $rows): array
    {
        $total = max(1, $rows->count());

        return [
            ['label' => 'Berkas terverifikasi', 'count' => $rows->count(), 'percent' => $rows->count() ? 100 : 0],
            ['label' => 'Administrasi tercatat', 'count' => $rows->where('has_payment', true)->count(), 'percent' => round(($rows->where('has_payment', true)->count() / $total) * 100, 1)],
            ['label' => 'Administrasi lengkap', 'count' => $rows->where('is_paid', true)->count(), 'percent' => round(($rows->where('is_paid', true)->count() / $total) * 100, 1)],
            ['label' => 'NIS aktif', 'count' => $rows->where('has_student_number', true)->count(), 'percent' => round(($rows->where('has_student_number', true)->count() / $total) * 100, 1)],
            ['label' => 'Kartu tercetak', 'count' => $rows->where('has_card_printed', true)->count(), 'percent' => round(($rows->where('has_card_printed', true)->count() / $total) * 100, 1)],
            ['label' => 'Ukuran atribut tercatat', 'count' => $rows->where('has_uniform_profile', true)->count(), 'percent' => round(($rows->where('has_uniform_profile', true)->count() / $total) * 100, 1)],
        ];
    }

    private function buildUniformSizeRows(PaymentType $uniformType, ?string $search = null, ?string $studentType = null, ?string $status = null): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $profiles = UniformProfile::with('updater')->get()->keyBy(fn($profile) => $profile->student_key);
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');

        $smkRows = Applicant::where('status', 'verified')
            ->orderBy('major_choice')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice'])
            ->map(fn($student) => $this->uniformSizeRow('smk', $student, $profiles, $smkPaid->get($student->id), $requiredAmount));

        $smpRows = SmpApplicant::where('status', 'verified')
            ->orderBy('school_program')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program'])
            ->map(fn($student) => $this->uniformSizeRow('smp', $student, $profiles, $smpPaid->get($student->id), $requiredAmount));

        $rows = $smkRows->merge($smpRows);

        if ($search !== null && $search !== '') {
            $searchLower = Str::lower($search);
            $rows = $rows->filter(function ($row) use ($searchLower) {
                return Str::contains(Str::lower($row['name']), $searchLower)
                    || Str::contains(Str::lower($row['registration_number']), $searchLower)
                    || Str::contains(Str::lower($row['student_identification_number']), $searchLower);
            });
        }

        if ($studentType === 'smk' || $studentType === 'smp') {
            $unitLabel = $studentType === 'smp' ? 'SMPS' : 'SMKS';
            $rows = $rows->filter(fn($row) => $row['unit'] === $unitLabel);
        }

        if ($status !== null && $status !== '') {
            $rows = $rows->filter(function ($row) use ($status) {
                $profileStatus = $row['profile']?->attribute_status ?: 'not_recorded';
                return $profileStatus === $status;
            });
        }

        return $rows
            ->sortBy([
                ['has_profile', 'asc'],
                ['unit', 'asc'],
                ['choice', 'asc'],
                ['name', 'asc'],
            ])
            ->values();
    }

    private function uniformSizeRow(string $type, $student, Collection $profiles, $paymentStats, int $requiredAmount): array
    {
        $key = $type . ':' . $student->id;
        $profile = $profiles->get($key);
        $paidAmount = (int) ($paymentStats->paid_amount ?? 0);

        return [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'student_id' => $student->id,
            'student_key' => $key,
            'student_identification_number' => $student->student_identification_number,
            'registration_number' => $student->registration_number,
            'name' => $student->full_name,
            'choice' => $this->studentChoice($type, $student),
            'paid_amount' => $paidAmount,
            'is_paid' => $paidAmount >= $requiredAmount,
            'profile' => $profile,
            'attribute_status_label' => $this->attributeStatusLabel($profile?->attribute_status),
            'has_profile' => (bool) $profile,
        ];
    }

    private function studentCardPrintedKeys(): array
    {
        return AuditLog::where('event', 'finance.student_card_printed')
            ->latest('occurred_at')
            ->get()
            ->map(function ($log) {
                $type = data_get($log->properties, 'student_type');
                $id = data_get($log->properties, 'student_id');

                return $type && $id ? $type . ':' . $id : null;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function letterTitle(string $template): string
    {
        return match ($template) {
            'reenrollment' => 'Surat Keterangan Administrasi Daftar Ulang',
            'parent-call' => 'Surat Undangan Konfirmasi Orang Tua/Wali',
            default => 'Surat Keterangan Diterima',
        };
    }

    private function attributeStatusLabel(?string $status): string
    {
        return match ($status) {
            'prepared' => 'Disiapkan',
            'distributed' => 'Sudah Diserahkan',
            'not_recorded' => 'Belum Dicatat',
            default => 'Tercatat',
        };
    }

    private function buildStudentOptions(): Collection
    {
        $smk = Applicant::where('status', 'verified')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice'])
            ->map(fn($student) => $this->formatStudentOption($student, 'smk'));

        $smp = SmpApplicant::where('status', 'verified')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program'])
            ->map(fn($student) => $this->formatStudentOption($student, 'smp'));

        return $smk->merge($smp)->sortBy('label')->values();
    }

    private function buildUniformReceivables(PaymentType $uniformType, ?string $search = null, ?string $studentType = null, ?string $status = null): array
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', 'smk')
            ->whereNotNull('applicant_id')
            ->selectRaw('applicant_id, SUM(amount) as total')
            ->groupBy('applicant_id')
            ->pluck('total', 'applicant_id');

        $smpPaid = PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', 'smp')
            ->whereNotNull('smp_applicant_id')
            ->selectRaw('smp_applicant_id, SUM(amount) as total')
            ->groupBy('smp_applicant_id')
            ->pluck('total', 'smp_applicant_id');

        $smkRows = Applicant::where('status', 'verified')
            ->latest()
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice'])
            ->map(function ($student) use ($requiredAmount, $smkPaid) {
                $paid = (int) ($smkPaid[$student->id] ?? 0);

                return [
                    'unit' => 'SMKS',
                    'student_identification_number' => $student->student_identification_number,
                    'registration_number' => $student->registration_number,
                    'name' => $student->full_name,
                    'choice' => $student->major_choice,
                    'required' => $requiredAmount,
                    'paid' => $paid,
                    'remaining' => max(0, $requiredAmount - $paid),
                ];
            });

        $smpRows = SmpApplicant::where('status', 'verified')
            ->latest()
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program'])
            ->map(function ($student) use ($requiredAmount, $smpPaid) {
                $paid = (int) ($smpPaid[$student->id] ?? 0);

                return [
                    'unit' => 'SMPS',
                    'student_identification_number' => $student->student_identification_number,
                    'registration_number' => $student->registration_number,
                    'name' => $student->full_name,
                    'choice' => $student->school_program,
                    'required' => $requiredAmount,
                    'paid' => $paid,
                    'remaining' => max(0, $requiredAmount - $paid),
                ];
            });

        $allRows = $smkRows->merge($smpRows);
        $rows = $allRows;

        if ($search !== null && $search !== '') {
            $searchLower = Str::lower($search);
            $rows = $rows->filter(function ($row) use ($searchLower) {
                return Str::contains(Str::lower($row['name']), $searchLower)
                    || Str::contains(Str::lower($row['registration_number']), $searchLower)
                    || Str::contains(Str::lower($row['student_identification_number']), $searchLower);
            });
        }

        if ($studentType === 'smk' || $studentType === 'smp') {
            $unitLabel = $studentType === 'smp' ? 'SMPS' : 'SMKS';
            $rows = $rows->filter(fn($row) => $row['unit'] === $unitLabel);
        }

        if ($status === 'paid') {
            $rows = $rows->filter(fn($row) => $row['remaining'] <= 0);
        } elseif ($status === 'unpaid') {
            $rows = $rows->filter(fn($row) => $row['remaining'] > 0);
        }

        $rowsSorted = $rows->sortByDesc('remaining')->values();

        return [
            'rows' => $rowsSorted,
            'total_students' => $allRows->count(),
            'paid_students' => $allRows->filter(fn($row) => $row['remaining'] <= 0)->count(),
            'required_total' => $allRows->sum('required'),
            'paid_total' => $allRows->sum('paid'),
            'remaining_total' => $allRows->sum('remaining'),
        ];
    }

    private function buildStudentCardStates(Collection $transactions, PaymentType $uniformType): array
    {
        $states = [];
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');

        foreach ($transactions as $transaction) {
            $relatedStudent = $this->studentForTransaction($transaction);
            $studentId = $relatedStudent?->id;
            $paidStats = $transaction->student_type === 'smp'
                ? ($studentId ? $smpPaid->get($studentId) : null)
                : ($studentId ? $smkPaid->get($studentId) : null);
            $paidAmount = (int) ($paidStats->paid_amount ?? 0);
            $remaining = max(0, $requiredAmount - $paidAmount);
            $canPrint = $transaction->status === 'confirmed'
                && $transaction->direction === 'income'
                && in_array($transaction->student_type, ['smk', 'smp'], true)
                && $relatedStudent?->status === 'verified';

            $states[$transaction->id] = [
                'can_print' => $canPrint,
                'paid_amount' => $paidAmount,
                'remaining' => $remaining,
                'label' => $canPrint ? 'Cetak' : '-',
            ];
        }

        return $states;
    }

    private function syncStudentNumbersForPaidStudents(PaymentType $uniformType): void
    {
        foreach ($this->paidStudentModels($uniformType) as $item) {
            if ($item['student']->student_identification_number) {
                continue;
            }

            $studentNumber = $this->assignStudentNumber($item['type'], $item['student']);

            AuditLogger::record('finance.student_number_backfilled', 'NIS dibuat otomatis untuk siswa yang sudah lunas.', $item['student'], [
                'student_type' => $item['type'],
                'student_identification_number' => $studentNumber,
            ]);
        }
    }

    private function paidStudentModels(PaymentType $uniformType): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');

        $smkStudents = Applicant::where('status', 'verified')
            ->whereIn('id', $smkPaid->keys())
            ->get()
            ->filter(fn($student) => (int) ($smkPaid[$student->id]->paid_amount ?? 0) >= $requiredAmount)
            ->map(fn($student) => ['type' => 'smk', 'student' => $student]);

        $smpStudents = SmpApplicant::where('status', 'verified')
            ->whereIn('id', $smpPaid->keys())
            ->get()
            ->filter(fn($student) => (int) ($smpPaid[$student->id]->paid_amount ?? 0) >= $requiredAmount)
            ->map(fn($student) => ['type' => 'smp', 'student' => $student]);

        return $smkStudents->merge($smpStudents)->values();
    }

    private function buildFinalReEnrollmentRows(PaymentType $uniformType, ?string $studentType = null, ?string $search = null): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $rows = collect();

        if (!$studentType || $studentType === 'smk') {
            $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
            $rows = $rows->merge(
                Applicant::where('status', 'verified')
                    ->whereIn('id', $smkPaid->keys())
                    ->orderBy('major_choice')
                    ->orderBy('full_name')
                    ->get()
                    ->map(fn($student) => $this->finalReportRow('smk', $student, $smkPaid[$student->id] ?? null, $requiredAmount))
            );
        }

        if (!$studentType || $studentType === 'smp') {
            $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');
            $rows = $rows->merge(
                SmpApplicant::where('status', 'verified')
                    ->whereIn('id', $smpPaid->keys())
                    ->orderBy('school_program')
                    ->orderBy('full_name')
                    ->get()
                    ->map(fn($student) => $this->finalReportRow('smp', $student, $smpPaid[$student->id] ?? null, $requiredAmount))
            );
        }

        $rows = $rows->filter();

        if ($search !== null && $search !== '') {
            $searchLower = Str::lower($search);
            $rows = $rows->filter(function ($row) use ($searchLower) {
                return Str::contains(Str::lower($row['name']), $searchLower)
                    || Str::contains(Str::lower($row['registration_number']), $searchLower)
                    || Str::contains(Str::lower($row['student_identification_number']), $searchLower);
            });
        }

        return $rows
            ->sortBy([
                ['unit', 'asc'],
                ['choice', 'asc'],
                ['student_identification_number', 'asc'],
            ])
            ->values();
    }

    private function finalReportRow(string $type, $student, $paymentStats, int $requiredAmount): ?array
    {
        $paidAmount = (int) ($paymentStats->paid_amount ?? 0);

        if ($paidAmount < $requiredAmount) {
            return null;
        }

        if (!$student->student_identification_number) {
            $this->assignStudentNumber($type, $student);
            $student->refresh();
        }

        return [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'student_id' => $student->id,
            'student_identification_number' => $student->student_identification_number,
            'registration_number' => $student->registration_number,
            'name' => $student->full_name,
            'choice' => $this->studentChoice($type, $student),
            'phone' => $student->phone,
            'registered_at' => $student->registered_at_label,
            'paid_at' => $this->formatWib($paymentStats->latest_paid_at ?? null),
            'transaction_count' => (int) ($paymentStats->transaction_count ?? 0),
            'latest_transaction_id' => (int) ($paymentStats->latest_transaction_id ?? 0),
            'paid_amount' => $paidAmount,
            'required_amount' => $requiredAmount,
        ];
    }

    private function uniformPaymentStats(PaymentType $uniformType, string $type): Collection
    {
        $studentKey = $type === 'smp' ? 'smp_applicant_id' : 'applicant_id';

        return PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', $type)
            ->whereNotNull($studentKey)
            ->selectRaw($studentKey . ' as student_id, SUM(amount) as paid_amount, COUNT(*) as transaction_count, MIN(paid_at) as first_paid_at, MAX(paid_at) as latest_paid_at, MAX(id) as latest_transaction_id')
            ->groupBy($studentKey)
            ->get()
            ->keyBy('student_id');
    }

    private function assignStudentNumber(string $type, $student, ?PaymentTransaction $transaction = null): string
    {
        $studentNumber = app(StudentIdentificationNumberService::class)->assignIfMissing($type, $student);

        AuditLogger::record('finance.student_number_assigned', 'NIS siswa dibuat otomatis setelah seragam lunas.', $transaction ?: $student, [
            'student_type' => $type,
            'student_id' => $student->id,
            'student_name' => $student->full_name,
            'student_identification_number' => $studentNumber,
        ]);

        return $studentNumber;
    }

    private function resolveVerifiedStudent(?string $studentKey): ?array
    {
        $student = $this->parseStudentKey($studentKey);

        if (!$student) {
            return null;
        }

        $model = $student['type'] === 'smp'
            ? SmpApplicant::where('status', 'verified')->find($student['id'])
            : Applicant::where('status', 'verified')->find($student['id']);

        if (!$model) {
            return null;
        }

        return $student + ['model' => $model];
    }

    private function formatStudentOption($student, string $type): array
    {
        $choice = $type === 'smp' ? $student->school_program : $student->major_choice;
        $unit = $type === 'smp' ? 'SMPS' : 'SMKS';
        $studentNumber = $student->student_identification_number ?: 'Belum ada NIS';

        return [
            'key' => $type . ':' . $student->id,
            'unit' => $unit,
            'student_identification_number' => $student->student_identification_number,
            'registration_number' => $student->registration_number,
            'name' => $student->full_name,
            'choice' => $choice,
            'label' => $studentNumber . ' - ' . $student->registration_number . ' - ' . $student->full_name . ' (' . $choice . ')',
        ];
    }

    private function studentForTransaction(PaymentTransaction $transaction)
    {
        if ($transaction->student_type === 'smp') {
            return $transaction->smpApplicant;
        }

        if ($transaction->student_type === 'smk') {
            return $transaction->smkApplicant;
        }

        return null;
    }

    private function studentChoice(?string $type, $student): ?string
    {
        return $type === 'smp'
            ? $student?->school_program
            : $student?->major_choice;
    }

    private function formatWib($value): string
    {
        if (!$value) {
            return '-';
        }

        return Carbon::parse($value)->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB';
    }

    private function cardColorForChoice(?string $choice): string
    {
        $colors = [
            'akuntansi dan keuangan lembaga' => '#0f766e',
            'desain komunikasi visual' => '#7c3aed',
            'manajemen perkantoran dan layanan bisnis' => '#2563eb',
            'teknik kendaraan ringan' => '#dc2626',
            'teknik komputer dan jaringan' => '#0891b2',
            'teknik sepeda motor' => '#ea580c',
            'sekolah umum' => '#16a34a',
            'sekolah dan asrama' => '#9333ea',
        ];

        $key = Str::lower(trim((string) $choice));

        if (isset($colors[$key])) {
            return $colors[$key];
        }

        $palette = ['#0f766e', '#2563eb', '#7c3aed', '#dc2626', '#0891b2', '#ca8a04', '#be123c', '#15803d'];
        $index = ((int) sprintf('%u', crc32($key ?: 'yapisda'))) % count($palette);

        return $palette[$index];
    }

    private function parseStudentKey(?string $studentKey): ?array
    {
        if (!$studentKey || !str_contains($studentKey, ':')) {
            return null;
        }

        [$type, $id] = explode(':', $studentKey, 2);

        if (!in_array($type, ['smk', 'smp'], true) || !ctype_digit($id)) {
            return null;
        }

        return ['type' => $type, 'id' => (int) $id];
    }

    private function makeReferenceNumber(): string
    {
        do {
            $reference = 'TRX-' . now()->format('Ymd-His') . '-' . Str::upper(Str::random(4));
        } while (PaymentTransaction::where('reference_number', $reference)->exists());

        return $reference;
    }
}
