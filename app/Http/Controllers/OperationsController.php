<?php

namespace App\Http\Controllers;

use App\Exports\OfficialDataExport;
use App\Models\ActiveStudent;
use App\Models\Applicant;
use App\Models\AuditLog;
use App\Models\BackupSnapshot;
use App\Models\PaymentTransaction;
use App\Models\PaymentType;
use App\Models\SmpApplicant;
use App\Models\StudentFinalChecklist;
use App\Models\UniformProfile;
use App\Models\UniformStockItem;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class OperationsController extends Controller
{
    public function login()
    {
        return view('admin.operations.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $guard = Auth::guard('operations');

        if ($guard->attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (!$guard->user()->hasRole(['operasional', 'admin_smk', 'admin_smp', 'finance', 'kepala_sekolah', 'yayasan', 'super_admin'])) {
                $guard->logout();

                return back()
                    ->withInput($request->only('username'))
                    ->with('error', 'Akun ini tidak memiliki akses operasional.');
            }

            if ($guard->user()->hasRole(['kepala_sekolah', 'yayasan'])) {
                return redirect()->intended(route('admin.operations.executive-dashboard'));
            }

            return redirect()->intended(route('admin.operations.dashboard'));
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Email atau password tidak sesuai.');
    }

    public function logout(Request $request)
    {
        Auth::guard('operations')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('admin.operations.login');
    }

    public function index(Request $request)
    {
        $section = match ($request->route()?->getName()) {
            'admin.operations.active-students' => 'active-students',
            'admin.operations.uniform-stock' => 'uniform-stock',
            'admin.operations.final-checklist' => 'final-checklist',
            'admin.operations.official-exports' => 'official-exports',
            'admin.operations.archive-center' => 'archive-center',
            'admin.operations.health' => 'health',
            'admin.operations.executive-dashboard' => 'executive-dashboard',
            'admin.operations.guide' => 'guide',
            default => 'dashboard',
        };

        $uniformType = $this->ensureUniformPaymentType();
        $this->syncActiveStudentsFromPayments(false);

        $activeStudents = collect();
        $stockItems = collect();
        $uniformNeeds = collect();
        $checklistRows = collect();
        $archiveRows = collect();
        $health = [];
        $backups = collect();

        if (in_array($section, ['dashboard', 'executive-dashboard', 'active-students'], true)) {
            $activeStudents = $this->activeStudentQuery($request)->get();
        }

        if (in_array($section, ['dashboard', 'executive-dashboard', 'uniform-stock'], true)) {
            $stockItems = UniformStockItem::orderBy('category')->orderBy('name')->orderBy('size')->get();
            $uniformNeeds = $this->buildUniformNeeds($stockItems);
        }

        if (in_array($section, ['dashboard', 'executive-dashboard', 'final-checklist'], true)) {
            $checklistRows = $this->buildFinalChecklistRows($uniformType);
        }

        if ($section === 'archive-center') {
            $archiveRows = $this->buildArchiveRows($request);
        }

        if ($section === 'health') {
            $health = $this->buildHealthReport();
            $backups = BackupSnapshot::latest()->limit(10)->get();
        }

        $summary = $this->buildSummary($uniformType, $activeStudents, $stockItems, $checklistRows);
        $exportCards = $this->officialExportCards();
        $stockCategories = $this->stockCategories();

        return view('admin.operations.dashboard', compact(
            'section',
            'summary',
            'activeStudents',
            'stockItems',
            'uniformNeeds',
            'checklistRows',
            'archiveRows',
            'health',
            'backups',
            'exportCards',
            'stockCategories',
            'uniformType'
        ));
    }

    public function syncActiveStudents()
    {
        $result = $this->syncActiveStudentsFromPayments(true);

        return back()->with('success', 'Master siswa aktif disinkronkan: ' . $result['created'] . ' baru, ' . $result['updated'] . ' diperbarui.');
    }

    public function updateActiveStudent(Request $request, ActiveStudent $activeStudent)
    {
        $validated = $request->validate([
            'class_group' => ['nullable', 'string', 'max:80'],
            'status' => ['required', 'in:active,hold,inactive,graduated'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $activeStudent->update([
            'class_group' => $validated['class_group'] ?? null,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'updated_by_user_id' => Auth::id(),
        ]);

        AuditLogger::record('operations.active_student_updated', 'Master siswa aktif diperbarui.', $activeStudent, [
            'student_key' => $activeStudent->student_key,
            'class_group' => $activeStudent->class_group,
            'status' => $activeStudent->status,
        ]);

        return back()->with('success', 'Data siswa aktif berhasil diperbarui.');
    }

    public function storeUniformStock(Request $request)
    {
        $validated = $this->validateUniformStock($request);

        $stock = UniformStockItem::updateOrCreate(
            [
                'name' => $validated['name'],
                'category' => $validated['category'],
                'size' => $validated['size'] ?? null,
            ],
            array_merge($validated, [
                'created_by_user_id' => Auth::id(),
                'updated_by_user_id' => Auth::id(),
            ])
        );

        AuditLogger::record('operations.uniform_stock_saved', 'Stok seragam disimpan.', $stock, [
            'category' => $stock->category,
            'size' => $stock->size,
            'available_qty' => $stock->available_qty,
        ]);

        return back()->with('success', 'Stok seragam berhasil disimpan.');
    }

    public function updateUniformStock(Request $request, UniformStockItem $stock)
    {
        $validated = $this->validateUniformStock($request);
        $stock->update(array_merge($validated, ['updated_by_user_id' => Auth::id()]));

        AuditLogger::record('operations.uniform_stock_updated', 'Stok seragam diperbarui.', $stock, [
            'category' => $stock->category,
            'size' => $stock->size,
            'available_qty' => $stock->available_qty,
        ]);

        return back()->with('success', 'Stok seragam berhasil diperbarui.');
    }

    public function updateChecklist(Request $request, string $type, int $id)
    {
        abort_unless(in_array($type, ['smk', 'smp'], true), 404);

        $validated = $request->validate([
            'final_status' => ['required', 'in:needs_review,ready,finalized,blocked'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $uniformType = $this->ensureUniformPaymentType();
        $row = $this->buildFinalChecklistRows($uniformType)
            ->first(fn(array $item) => $item['type'] === $type && (int) $item['student_id'] === $id);

        abort_unless($row, 404);

        $checklist = StudentFinalChecklist::updateOrCreate(
            ['student_type' => $type, 'student_id' => $id],
            [
                'documents_complete' => $row['documents_complete'],
                'administration_complete' => $row['administration_complete'],
                'student_number_assigned' => $row['student_number_assigned'],
                'card_printed' => $row['card_printed'],
                'uniform_size_recorded' => $row['uniform_size_recorded'],
                'attribute_distributed' => $row['attribute_distributed'],
                'final_status' => $validated['final_status'],
                'notes' => $validated['notes'] ?? null,
                'reviewed_by_user_id' => Auth::id(),
                'reviewed_at' => now('Asia/Jakarta'),
            ]
        );

        AuditLogger::record('operations.final_checklist_updated', 'Checklist final siswa diperbarui.', $checklist, [
            'student_type' => $type,
            'student_id' => $id,
            'final_status' => $checklist->final_status,
        ]);

        return back()->with('success', 'Checklist final siswa berhasil diperbarui.');
    }

    public function downloadOfficialExport(string $type)
    {
        $payload = $this->officialExportPayload($type);
        abort_unless($payload, 404);

        AuditLogger::record('operations.official_export_downloaded', 'Export data resmi diunduh.', null, [
            'type' => $type,
            'rows' => $payload['rows']->count(),
        ]);

        return Excel::download(
            new OfficialDataExport($payload['headings'], $payload['rows']),
            $payload['filename']
        );
    }

    public function createBackup()
    {
        $name = 'backup-yapisda-' . now('Asia/Jakarta')->format('Ymd-His');
        $path = 'backups/' . $name . '.json';
        $payload = $this->backupPayload();

        Storage::disk('local')->put($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $backup = BackupSnapshot::create([
            'name' => $name,
            'disk' => 'local',
            'path' => $path,
            'size_bytes' => Storage::disk('local')->size($path),
            'metadata' => $payload['metadata'],
            'created_by_user_id' => Auth::id(),
        ]);

        AuditLogger::record('operations.backup_created', 'Backup data operasional dibuat.', $backup, [
            'path' => $path,
            'size_bytes' => $backup->size_bytes,
        ]);

        return back()->with('success', 'Backup sistem berhasil dibuat.');
    }

    public function downloadBackup(BackupSnapshot $backup)
    {
        abort_unless(Storage::disk($backup->disk)->exists($backup->path), 404);

        return Storage::disk($backup->disk)->download($backup->path, $backup->name . '.json');
    }

    public function previewDocument(string $type, int $id, string $document)
    {
        abort_unless(in_array($type, ['smk', 'smp'], true), 404);

        $student = $type === 'smp'
            ? SmpApplicant::findOrFail($id)
            : Applicant::findOrFail($id);

        $definitions = $this->documentDefinitions();
        abort_unless(isset($definitions[$document]), 404);

        $path = $student->{$definitions[$document]['field']} ?? null;
        abort_unless($this->validStoragePath($path) && Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path), [
            'Content-Type' => Storage::disk('public')->mimeType($path) ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    private function validateUniformStock(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'in:shirt,pants,skirt,headwear,shoes,attribute,other'],
            'size' => ['nullable', 'string', 'max:40'],
            'unit' => ['required', 'string', 'max:40'],
            'stock_qty' => ['required', 'integer', 'min:0'],
            'reserved_qty' => ['required', 'integer', 'min:0'],
            'distributed_qty' => ['required', 'integer', 'min:0'],
            'minimum_qty' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function activeStudentQuery(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $unit = $request->query('unit');
        $status = $request->query('status');

        return ActiveStudent::query()
            ->when(in_array($unit, ['SMKS', 'SMPS'], true), fn($query) => $query->where('unit', $unit))
            ->when(in_array($status, ['active', 'hold', 'inactive', 'graduated'], true), fn($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('full_name', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%")
                        ->orWhere('student_identification_number', 'like', "%{$search}%")
                        ->orWhere('class_group', 'like', "%{$search}%");
                });
            })
            ->orderBy('unit')
            ->orderBy('program')
            ->orderBy('full_name');
    }

    private function syncActiveStudentsFromPayments(bool $recordAudit): array
    {
        $rows = $this->paidVerifiedRows($this->ensureUniformPaymentType());
        $created = 0;
        $updated = 0;

        foreach ($rows as $row) {
            $active = ActiveStudent::firstOrNew([
                'student_type' => $row['type'],
                'student_id' => $row['student_id'],
            ]);

            if (!$active->exists) {
                $active->status = 'active';
                $active->enrolled_at = now('Asia/Jakarta')->toDateString();
                $active->created_by_user_id = Auth::id();
                $created++;
            } else {
                $updated++;
            }

            $active->fill([
                'unit' => $row['unit'],
                'registration_number' => $row['registration_number'],
                'student_identification_number' => $row['student_identification_number'],
                'full_name' => $row['name'],
                'program' => $row['choice'],
                'updated_by_user_id' => Auth::id(),
            ]);
            $active->save();
        }

        if ($recordAudit) {
            AuditLogger::record('operations.active_students_synced', 'Master siswa aktif disinkronkan.', null, [
                'created' => $created,
                'updated' => $updated,
                'eligible' => $rows->count(),
            ]);
        }

        return ['created' => $created, 'updated' => $updated, 'eligible' => $rows->count()];
    }

    private function buildSummary(PaymentType $uniformType, Collection $activeStudents, Collection $stockItems, Collection $checklistRows): array
    {
        if ($activeStudents->isEmpty()) {
            $activeStudents = ActiveStudent::all();
        }

        if ($stockItems->isEmpty()) {
            $stockItems = UniformStockItem::all();
        }

        if ($checklistRows->isEmpty()) {
            $checklistRows = $this->buildFinalChecklistRows($uniformType);
        }

        $verifiedTotal = Applicant::where('status', 'verified')->count() + SmpApplicant::where('status', 'verified')->count();
        $paidRows = $this->paidVerifiedRows($uniformType);
        $confirmedUniform = PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income');

        $archiveSummary = $this->archiveSummary();
        $finalized = $checklistRows->where('final_status', 'finalized')->count();
        $ready = $checklistRows->whereIn('final_status', ['ready', 'finalized'])->count();

        return [
            'total_applicants' => Applicant::count() + SmpApplicant::count(),
            'verified_total' => $verifiedTotal,
            'active_total' => $activeStudents->count(),
            'eligible_active_total' => $paidRows->count(),
            'uniform_collected' => (int) (clone $confirmedUniform)->sum('amount'),
            'uniform_target' => $verifiedTotal * (int) $uniformType->default_amount,
            'stock_alerts' => $stockItems->filter(fn(UniformStockItem $item) => $item->is_low_stock)->count(),
            'archive_missing' => $archiveSummary['missing_required'],
            'archive_total_files' => $archiveSummary['total_files'],
            'final_ready' => $ready,
            'finalized' => $finalized,
            'final_total' => $checklistRows->count(),
            'final_rate' => $checklistRows->count() > 0 ? round(($ready / $checklistRows->count()) * 100, 1) : 0,
            'latest_backup' => BackupSnapshot::latest()->first(),
            'program_distribution' => $paidRows
                ->groupBy(fn(array $row) => $row['unit'] . ' - ' . ($row['choice'] ?: 'Tanpa Program'))
                ->map(fn(Collection $rows, string $label) => ['label' => $label, 'count' => $rows->count()])
                ->sortByDesc('count')
                ->take(8)
                ->values(),
        ];
    }

    private function paidVerifiedRows(PaymentType $uniformType): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');

        $smk = Applicant::where('status', 'verified')
            ->orderBy('major_choice')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'major_choice', 'phone'])
            ->map(fn($student) => $this->baseStudentRow('smk', $student, $smkPaid->get($student->id), $requiredAmount));

        $smp = SmpApplicant::where('status', 'verified')
            ->orderBy('school_program')
            ->orderBy('full_name')
            ->get(['id', 'registration_number', 'student_identification_number', 'full_name', 'school_program', 'phone'])
            ->map(fn($student) => $this->baseStudentRow('smp', $student, $smpPaid->get($student->id), $requiredAmount));

        return $smk->merge($smp)
            ->filter(fn(array $row) => $row['paid_amount'] >= $requiredAmount)
            ->values();
    }

    private function baseStudentRow(string $type, $student, $paymentStats, int $requiredAmount): array
    {
        $paidAmount = (int) ($paymentStats->paid_amount ?? 0);

        return [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'student_id' => $student->id,
            'student_key' => $type . ':' . $student->id,
            'registration_number' => $student->registration_number,
            'student_identification_number' => $student->student_identification_number,
            'name' => $student->full_name,
            'choice' => $this->studentChoice($type, $student),
            'phone' => $student->phone,
            'paid_amount' => $paidAmount,
            'required_amount' => $requiredAmount,
            'remaining_amount' => max(0, $requiredAmount - $paidAmount),
            'transaction_count' => (int) ($paymentStats->transaction_count ?? 0),
            'last_paid_at' => $paymentStats?->last_paid_at ? Carbon::parse($paymentStats->last_paid_at)->timezone('Asia/Jakarta') : null,
        ];
    }

    private function buildFinalChecklistRows(PaymentType $uniformType): Collection
    {
        $requiredAmount = (int) $uniformType->default_amount;
        $smkPaid = $this->uniformPaymentStats($uniformType, 'smk');
        $smpPaid = $this->uniformPaymentStats($uniformType, 'smp');
        $profiles = UniformProfile::all()->keyBy(fn(UniformProfile $profile) => $profile->student_key);
        $checklists = StudentFinalChecklist::all()->keyBy(fn(StudentFinalChecklist $checklist) => $checklist->student_key);
        $cardPrintedKeys = $this->studentCardPrintedKeys();

        $smk = Applicant::where('status', 'verified')
            ->orderBy('major_choice')
            ->orderBy('full_name')
            ->get()
            ->map(fn($student) => $this->finalChecklistRow('smk', $student, $smkPaid->get($student->id), $requiredAmount, $profiles, $checklists, $cardPrintedKeys));

        $smp = SmpApplicant::where('status', 'verified')
            ->orderBy('school_program')
            ->orderBy('full_name')
            ->get()
            ->map(fn($student) => $this->finalChecklistRow('smp', $student, $smpPaid->get($student->id), $requiredAmount, $profiles, $checklists, $cardPrintedKeys));

        return $smk->merge($smp)
            ->sortBy([
                ['final_status', 'asc'],
                ['unit', 'asc'],
                ['choice', 'asc'],
                ['name', 'asc'],
            ])
            ->values();
    }

    private function finalChecklistRow(string $type, $student, $paymentStats, int $requiredAmount, Collection $profiles, Collection $checklists, array $cardPrintedKeys): array
    {
        $base = $this->baseStudentRow($type, $student, $paymentStats, $requiredAmount);
        $documentStatus = $this->documentStatus($type, $student);
        $profile = $profiles->get($base['student_key']);
        $checklist = $checklists->get($base['student_key']);

        $flags = [
            'documents_complete' => $documentStatus['missing_required_count'] === 0,
            'administration_complete' => $base['paid_amount'] >= $requiredAmount,
            'student_number_assigned' => filled($base['student_identification_number']),
            'card_printed' => in_array($base['student_key'], $cardPrintedKeys, true),
            'uniform_size_recorded' => (bool) $profile,
            'attribute_distributed' => $profile?->attribute_status === 'distributed',
        ];

        $completeCount = collect($flags)->filter()->count();
        $autoStatus = $completeCount === count($flags) ? 'ready' : 'needs_review';

        return array_merge($base, $flags, [
            'profile' => $profile,
            'document_status' => $documentStatus,
            'completion_percent' => round(($completeCount / count($flags)) * 100),
            'final_status' => $checklist?->final_status ?? $autoStatus,
            'checklist_notes' => $checklist?->notes,
            'reviewed_at' => $checklist?->reviewed_at,
        ]);
    }

    private function buildUniformNeeds(Collection $stockItems): Collection
    {
        $profiles = UniformProfile::all();
        $stockIndex = $stockItems->keyBy(fn(UniformStockItem $item) => $item->category . '|' . Str::lower((string) $item->size));
        $definitions = [
            ['label' => 'Baju', 'field' => 'shirt_size', 'category' => 'shirt'],
            ['label' => 'Celana/Rok', 'field' => 'pants_size', 'category' => 'pants'],
        ];

        return collect($definitions)
            ->flatMap(function (array $definition) use ($profiles, $stockIndex) {
                return $profiles
                    ->pluck($definition['field'])
                    ->filter()
                    ->map(fn($size) => trim((string) $size))
                    ->countBy()
                    ->map(function (int $count, string $size) use ($definition, $stockIndex) {
                        $stock = $stockIndex->get($definition['category'] . '|' . Str::lower($size));

                        return [
                            'label' => $definition['label'],
                            'category' => $definition['category'],
                            'size' => $size,
                            'needed' => $count,
                            'available' => $stock?->available_qty ?? 0,
                            'gap' => max(0, $count - ($stock?->available_qty ?? 0)),
                        ];
                    })
                    ->values();
            })
            ->sortByDesc('gap')
            ->values();
    }

    private function buildArchiveRows(Request $request): Collection
    {
        $search = trim((string) $request->query('search'));
        $unit = $request->query('unit');
        $problem = $request->boolean('problem');

        $smk = Applicant::latest()
            ->get()
            ->map(fn($student) => $this->archiveRow('smk', $student));

        $smp = SmpApplicant::latest()
            ->get()
            ->map(fn($student) => $this->archiveRow('smp', $student));

        return $smk->merge($smp)
            ->when(in_array($unit, ['SMKS', 'SMPS'], true), fn(Collection $rows) => $rows->where('unit', $unit))
            ->when($search !== '', function (Collection $rows) use ($search) {
                $keyword = Str::lower($search);

                return $rows->filter(fn(array $row) => Str::contains(Str::lower($row['name'] . ' ' . $row['registration_number'] . ' ' . $row['student_identification_number']), $keyword));
            })
            ->when($problem, fn(Collection $rows) => $rows->filter(fn(array $row) => $row['missing_required_count'] > 0))
            ->values();
    }

    private function archiveRow(string $type, $student): array
    {
        $status = $this->documentStatus($type, $student);

        return [
            'type' => $type,
            'unit' => $type === 'smp' ? 'SMPS' : 'SMKS',
            'student_id' => $student->id,
            'registration_number' => $student->registration_number,
            'student_identification_number' => $student->student_identification_number,
            'name' => $student->full_name,
            'choice' => $this->studentChoice($type, $student),
            'status' => $student->status,
            'documents' => $status['documents'],
            'existing_count' => $status['existing_count'],
            'missing_required_count' => $status['missing_required_count'],
            'complete' => $status['missing_required_count'] === 0,
        ];
    }

    private function documentStatus(string $type, $student): array
    {
        $documents = collect($this->documentDefinitions())
            ->map(function (array $definition, string $key) use ($student, $type) {
                $path = $student->{$definition['field']} ?? null;
                $exists = $this->validStoragePath($path) && Storage::disk('public')->exists($path);

                return [
                    'key' => $key,
                    'label' => $definition['label'],
                    'required' => $definition['required'],
                    'path' => $path,
                    'exists' => $exists,
                    'preview_url' => $exists ? route('admin.operations.archive.preview', [$type, $student->id, $key]) : null,
                ];
            })
            ->values();

        return [
            'documents' => $documents,
            'existing_count' => $documents->where('exists', true)->count(),
            'missing_required_count' => $documents->filter(fn(array $document) => $document['required'] && !$document['exists'])->count(),
            'missing_required_labels' => $documents
                ->filter(fn(array $document) => $document['required'] && !$document['exists'])
                ->pluck('label')
                ->values(),
        ];
    }

    private function archiveSummary(): array
    {
        $rows = $this->buildArchiveRows(new Request());
        $totalFiles = $rows->sum(fn(array $row) => count($row['documents']));

        return [
            'total_files' => $totalFiles,
            'missing_required' => $rows->sum('missing_required_count'),
            'complete_students' => $rows->where('complete', true)->count(),
            'total_students' => $rows->count(),
        ];
    }

    private function buildHealthReport(): array
    {
        $checks = [];

        try {
            DB::connection()->getPdo();
            $checks[] = ['label' => 'Koneksi Database', 'status' => 'ok', 'detail' => 'Database dapat diakses.'];
        } catch (Throwable $exception) {
            $checks[] = ['label' => 'Koneksi Database', 'status' => 'danger', 'detail' => $exception->getMessage()];
        }

        $publicDiskPath = Storage::disk('public')->path('');
        $checks[] = [
            'label' => 'Folder Upload',
            'status' => is_dir($publicDiskPath) && is_writable($publicDiskPath) ? 'ok' : 'danger',
            'detail' => $publicDiskPath,
        ];

        $publicStoragePath = public_path('storage');
        $checks[] = [
            'label' => 'Public Storage Link',
            'status' => file_exists($publicStoragePath) ? 'ok' : 'warning',
            'detail' => file_exists($publicStoragePath) ? 'public/storage tersedia.' : 'Jalankan php artisan storage:link jika file upload tidak tampil.',
        ];

        $archive = $this->archiveSummary();
        $checks[] = [
            'label' => 'Arsip Dokumen',
            'status' => $archive['missing_required'] === 0 ? 'ok' : 'warning',
            'detail' => $archive['missing_required'] . ' dokumen wajib belum ditemukan dari ' . $archive['total_files'] . ' referensi.',
        ];

        $latestBackup = BackupSnapshot::latest()->first();
        $checks[] = [
            'label' => 'Backup Terakhir',
            'status' => $latestBackup ? 'ok' : 'warning',
            'detail' => $latestBackup ? $latestBackup->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB' : 'Belum ada backup operasional.',
        ];

        return [
            'checks' => $checks,
            'archive' => $archive,
            'latest_backup' => $latestBackup,
            'php_version' => PHP_VERSION,
            'app_time' => now('Asia/Jakarta')->format('d/m/Y H:i:s') . ' WIB',
        ];
    }

    private function backupPayload(): array
    {
        return [
            'metadata' => [
                'generated_at' => now('Asia/Jakarta')->toIso8601String(),
                'generated_by' => Auth::user()?->email,
                'app' => config('app.name'),
                'tables' => [
                    'applicants' => Applicant::count(),
                    'smp_applicants' => SmpApplicant::count(),
                    'payment_transactions' => PaymentTransaction::count(),
                    'active_students' => ActiveStudent::count(),
                    'uniform_profiles' => UniformProfile::count(),
                    'uniform_stock_items' => UniformStockItem::count(),
                    'student_final_checklists' => StudentFinalChecklist::count(),
                ],
            ],
            'data' => [
                'applicants' => Applicant::all(),
                'smp_applicants' => SmpApplicant::all(),
                'payment_types' => PaymentType::all(),
                'payment_transactions' => PaymentTransaction::all(),
                'active_students' => ActiveStudent::all(),
                'uniform_profiles' => UniformProfile::all(),
                'uniform_stock_items' => UniformStockItem::all(),
                'student_final_checklists' => StudentFinalChecklist::all(),
            ],
        ];
    }

    private function officialExportPayload(string $type): ?array
    {
        $uniformType = $this->ensureUniformPaymentType();

        return match ($type) {
            'active-students' => [
                'filename' => 'master-siswa-aktif-' . date('Y-m-d') . '.xlsx',
                'headings' => ['Unit', 'NIS', 'No. Pendaftaran', 'Nama', 'Program', 'Rombel', 'Status', 'Tanggal Masuk', 'Catatan'],
                'rows' => ActiveStudent::orderBy('unit')->orderBy('program')->orderBy('full_name')->get()->map(fn(ActiveStudent $student) => [
                    $student->unit,
                    $student->student_identification_number,
                    $student->registration_number,
                    $student->full_name,
                    $student->program,
                    $student->class_group,
                    $student->status,
                    $student->enrolled_at?->format('d/m/Y'),
                    $student->notes,
                ]),
            ],
            'final-checklist' => [
                'filename' => 'checklist-status-final-' . date('Y-m-d') . '.xlsx',
                'headings' => ['Unit', 'NIS', 'No. Pendaftaran', 'Nama', 'Program', 'Berkas', 'Administrasi', 'Kartu', 'Ukuran', 'Atribut', 'Status Final', 'Progress', 'Catatan'],
                'rows' => $this->buildFinalChecklistRows($uniformType)->map(fn(array $row) => [
                    $row['unit'],
                    $row['student_identification_number'],
                    $row['registration_number'],
                    $row['name'],
                    $row['choice'],
                    $row['documents_complete'] ? 'Lengkap' : 'Belum',
                    $row['administration_complete'] ? 'Lengkap' : 'Belum',
                    $row['card_printed'] ? 'Sudah' : 'Belum',
                    $row['uniform_size_recorded'] ? 'Tercatat' : 'Belum',
                    $row['attribute_distributed'] ? 'Sudah' : 'Belum',
                    $row['final_status'],
                    $row['completion_percent'] . '%',
                    $row['checklist_notes'],
                ]),
            ],
            'uniform-stock' => [
                'filename' => 'stok-seragam-' . date('Y-m-d') . '.xlsx',
                'headings' => ['Nama', 'Kategori', 'Ukuran', 'Stok', 'Dipesan', 'Diserahkan', 'Tersedia', 'Minimum', 'Status', 'Catatan'],
                'rows' => UniformStockItem::orderBy('category')->orderBy('name')->get()->map(fn(UniformStockItem $item) => [
                    $item->name,
                    $this->stockCategoryLabel($item->category),
                    $item->size,
                    $item->stock_qty,
                    $item->reserved_qty,
                    $item->distributed_qty,
                    $item->available_qty,
                    $item->minimum_qty,
                    $item->is_low_stock ? 'Perlu Ditambah' : 'Aman',
                    $item->notes,
                ]),
            ],
            'document-archive' => [
                'filename' => 'pusat-arsip-dokumen-' . date('Y-m-d') . '.xlsx',
                'headings' => ['Unit', 'No. Pendaftaran', 'NIS', 'Nama', 'Program', 'Status Pendaftaran', 'Dokumen Ada', 'Dokumen Wajib Hilang', 'Status Arsip'],
                'rows' => $this->buildArchiveRows(new Request())->map(fn(array $row) => [
                    $row['unit'],
                    $row['registration_number'],
                    $row['student_identification_number'],
                    $row['name'],
                    $row['choice'],
                    $row['status'],
                    $row['existing_count'],
                    $row['missing_required_count'],
                    $row['complete'] ? 'Lengkap' : 'Perlu dicek',
                ]),
            ],
            default => null,
        };
    }

    private function officialExportCards(): array
    {
        return [
            ['type' => 'active-students', 'title' => 'Master Data Siswa Aktif', 'body' => 'NIS, rombel, program, status, dan kontak dasar siswa final.'],
            ['type' => 'final-checklist', 'title' => 'Checklist Berkas & Status Final', 'body' => 'Berkas, administrasi, kartu, ukuran, atribut, dan status final.'],
            ['type' => 'uniform-stock', 'title' => 'Manajemen Stok Seragam', 'body' => 'Stok, distribusi, minimum, dan tanda stok menipis.'],
            ['type' => 'document-archive', 'title' => 'Pusat Arsip Dokumen', 'body' => 'Kondisi file upload dan dokumen wajib yang belum ditemukan.'],
        ];
    }

    private function buildStockCards(Collection $stockItems): array
    {
        return [
            'total' => $stockItems->count(),
            'available' => $stockItems->sum(fn(UniformStockItem $item) => $item->available_qty),
            'low' => $stockItems->filter(fn(UniformStockItem $item) => $item->is_low_stock)->count(),
        ];
    }

    private function uniformPaymentStats(PaymentType $uniformType, string $type): Collection
    {
        $idColumn = $type === 'smp' ? 'smp_applicant_id' : 'applicant_id';

        return PaymentTransaction::confirmed()
            ->where('payment_type_id', $uniformType->id)
            ->where('direction', 'income')
            ->where('student_type', $type)
            ->whereNotNull($idColumn)
            ->selectRaw($idColumn . ' as student_id, SUM(amount) as paid_amount, COUNT(*) as transaction_count, MAX(paid_at) as last_paid_at')
            ->groupBy($idColumn)
            ->get()
            ->keyBy('student_id');
    }

    private function studentCardPrintedKeys(): array
    {
        return AuditLog::where('event', 'finance.student_card_printed')
            ->get()
            ->map(function (AuditLog $log) {
                $type = data_get($log->properties, 'student_type');
                $id = data_get($log->properties, 'student_id');

                return $type && $id ? $type . ':' . $id : null;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
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

    private function studentChoice(string $type, $student): string
    {
        return $type === 'smp'
            ? (string) ($student->school_program ?? '-')
            : (string) ($student->major_choice ?? '-');
    }

    private function documentDefinitions(): array
    {
        return [
            'photo' => ['field' => 'photo_path', 'label' => 'Pas Foto', 'required' => true],
            'kk' => ['field' => 'kk_path', 'label' => 'Kartu Keluarga', 'required' => true],
            'birth_certificate' => ['field' => 'birth_certificate_path', 'label' => 'Akta Kelahiran', 'required' => true],
            'mother_ktp' => ['field' => 'mother_ktp_path', 'label' => 'KTP Ibu', 'required' => true],
            'father_ktp' => ['field' => 'father_ktp_path', 'label' => 'KTP Ayah', 'required' => true],
            'guardian_ktp' => ['field' => 'guardian_ktp_path', 'label' => 'KTP Wali', 'required' => false],
            'diploma' => ['field' => 'diploma_path', 'label' => 'Ijazah/SKL', 'required' => false],
            'report_card' => ['field' => 'report_card_path', 'label' => 'Rapor', 'required' => true],
        ];
    }

    private function validStoragePath(?string $path): bool
    {
        return filled($path)
            && !str_contains($path, '..')
            && !str_starts_with($path, '/')
            && !str_starts_with($path, '\\');
    }

    private function stockCategories(): array
    {
        return [
            'shirt' => 'Baju',
            'pants' => 'Celana',
            'skirt' => 'Rok',
            'headwear' => 'Kerudung/Topi',
            'shoes' => 'Sepatu',
            'attribute' => 'Atribut',
            'other' => 'Lainnya',
        ];
    }

    private function stockCategoryLabel(string $category): string
    {
        return $this->stockCategories()[$category] ?? Str::headline($category);
    }
}
