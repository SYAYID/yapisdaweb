<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantActivity;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SmpApplicantsExport;
use App\Models\SmpApplicant;
use App\Models\SmpRegistration;
use App\Support\AuditLogger;
use Carbon\Carbon;

class SmpAdminController extends Controller
{
    public function login()
    {
        return view('admin.smp.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required|string',
        ]);

        $guard = Auth::guard('admin_smp');

        if ($guard->attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (!$guard->user()->hasRole(['admin_smp', 'super_admin'])) {
                $guard->logout();

                return back()->with('error', 'Akun ini tidak memiliki akses admin SMPS.');
            }

            return redirect()->intended(route('admin.smp.dashboard'));
        }

        return back()->with('error', 'Email atau password salah!')->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin_smp')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('admin.smp.login');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin_smp')->user() ?: Auth::guard('web')->user();

            if (!$user || !$user->hasRole(['admin_smp', 'super_admin'])) {
                return redirect()->route('admin.smp.login');
            }

            Auth::shouldUse(Auth::guard('admin_smp')->check() ? 'admin_smp' : 'web');

            return $next($request);
        })
        ->except(['login', 'postLogin', 'logout']);
    }

    public function index(Request $request)
    {
        $adminSection = match ($request->route()?->getName()) {
            'admin.smp.analytics' => 'analytics',
            'admin.smp.quotas' => 'quotas',
            'admin.smp.applicants' => 'applicants',
            'admin.smp.guide' => 'guide',
            default => 'dashboard',
        };

        $applicants = SmpApplicant::latest()->paginate(20);
        $quotas = SmpRegistration::all();

        $stats = [
            'total' => SmpApplicant::count(),
            'pending' => SmpApplicant::where('status', 'pending')->count(),
            'verified' => SmpApplicant::where('status', 'verified')->count(),
            'rejected' => SmpApplicant::where('status', 'rejected')->count(),
        ];
        $dashboard = $this->buildDashboardAnalytics($quotas, $stats);

        $auditLogs = collect();
        if ($adminSection === 'quotas') {
            $auditLogs = \App\Models\AuditLog::where('event', 'LIKE', 'admin.smp%')
                ->latest()
                ->paginate(20, ['*'], 'audit_page')
                ->withQueryString();
        }

        return view('admin.smp.dashboard', compact('applicants', 'quotas', 'stats', 'dashboard', 'adminSection', 'auditLogs'));
    }

    public function updateQuota(Request $request)
    {
        $validated = $request->validate([
            'school_program' => 'required|string|exists:smp_registrations,school_program',
            'quota' => 'required|integer|min:0',
        ], [
            'school_program.required' => 'Program sekolah wajib diisi.',
            'school_program.exists' => 'Program sekolah tidak terdaftar.',
            'quota.required' => 'Jumlah kuota wajib diisi.',
            'quota.integer' => 'Jumlah kuota harus berupa angka.',
            'quota.min' => 'Jumlah kuota minimal 0.',
        ]);

        $registration = SmpRegistration::where('school_program', $validated['school_program'])->firstOrFail();
        $oldQuota = $registration->quota;

        if ($validated['quota'] < $registration->used_quota) {
            return redirect()->back()->with('error', 'Jumlah kuota baru tidak boleh lebih kecil dari kuota terpakai (' . $registration->used_quota . ').');
        }

        $registration->update([
            'quota' => $validated['quota']
        ]);

        AuditLogger::record(
            'admin.smp_quota_updated',
            'Kuota program ' . $registration->school_program . ' diperbarui.',
            $registration,
            [
                'school_program' => $registration->school_program,
                'old_quota' => $oldQuota,
                'new_quota' => $validated['quota'],
            ]
        );

        return redirect()->back()->with('success', 'Kuota program ' . $registration->school_program . ' berhasil diperbarui dari ' . $oldQuota . ' menjadi ' . $validated['quota'] . '.');
    }

    /**
     * ✅ KURANGI KUOTA SAAT VERIFIKASI
     */
    public function verify($id)
    {
        $result = DB::transaction(function () use ($id) {
            $applicant = SmpApplicant::lockForUpdate()->findOrFail($id);

            if ($applicant->status === 'verified') {
                return ['type' => 'error', 'message' => 'Pendaftaran sudah terverifikasi!'];
            }

            $registration = SmpRegistration::where('school_program', $applicant->school_program)->lockForUpdate()->first();

            if (!$registration) {
                return ['type' => 'error', 'message' => 'Program sekolah tidak ditemukan!'];
            }

            if ($registration->quota <= $registration->used_quota) {
                return ['type' => 'error', 'message' => 'Maaf, kuota untuk program ' . $applicant->school_program . ' sudah penuh!'];
            }

            $registration->increment('used_quota');
            $applicant->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);

            $this->recordActivity(
                'smp',
                $applicant->id,
                'status',
                'Pendaftaran diverifikasi',
                'Status pendaftar diubah menjadi terverifikasi dan kuota program dikurangi.',
                ['status' => 'verified', 'program' => $applicant->school_program]
            );

            AuditLogger::record('admin.smp_applicant_verified', 'Pendaftar SMPS diverifikasi.', $applicant, [
                'program' => $applicant->school_program,
                'registration_number' => $applicant->registration_number,
            ]);

            return ['type' => 'success', 'message' => 'Pendaftaran berhasil diverifikasi! Kuota telah dikurangi.'];
        });

        return redirect()->back()->with($result['type'], $result['message']);
    }

    /**
     * KEMBALIKAN KUOTA JIKA DITOLAK (jika sebelumnya verified)
     */
    public function reject($id)
    {
        DB::transaction(function () use ($id) {
            $applicant = SmpApplicant::lockForUpdate()->findOrFail($id);

            if ($applicant->status === 'verified') {
                $registration = SmpRegistration::where('school_program', $applicant->school_program)->lockForUpdate()->first();
                if ($registration && $registration->used_quota > 0) {
                    $registration->decrement('used_quota');
                }
            }

            $applicant->update([
                'status' => 'rejected',
                'verified_at' => null,
            ]);

            $this->recordActivity(
                'smp',
                $applicant->id,
                'status',
                'Pendaftaran ditolak',
                'Status pendaftar diubah menjadi ditolak.',
                ['status' => 'rejected', 'program' => $applicant->school_program]
            );

            AuditLogger::record('admin.smp_applicant_rejected', 'Pendaftar SMPS ditolak.', $applicant, [
                'program' => $applicant->school_program,
                'registration_number' => $applicant->registration_number,
            ]);
        });

        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak!');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'note' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Status baru wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'note.max' => 'Catatan status maksimal 500 karakter.',
        ]);

        $result = DB::transaction(function () use ($id, $validated) {
            $applicant = SmpApplicant::lockForUpdate()->findOrFail($id);
            $oldStatus = $applicant->status;
            $newStatus = $validated['status'];

            if ($oldStatus === $newStatus) {
                return ['type' => 'success', 'message' => 'Status pendaftar tidak berubah.'];
            }

            $registration = null;
            if ($oldStatus === 'verified' || $newStatus === 'verified') {
                $registration = SmpRegistration::where('school_program', $applicant->school_program)
                    ->lockForUpdate()
                    ->first();

                if (!$registration) {
                    return ['type' => 'error', 'message' => 'Program sekolah tidak ditemukan, status belum dapat diubah.'];
                }
            }

            if ($oldStatus !== 'verified' && $newStatus === 'verified') {
                if ($registration->quota <= $registration->used_quota) {
                    return ['type' => 'error', 'message' => 'Kuota untuk program ' . $applicant->school_program . ' sudah penuh.'];
                }

                $registration->increment('used_quota');
            }

            if ($oldStatus === 'verified' && $newStatus !== 'verified' && $registration && $registration->used_quota > 0) {
                $registration->decrement('used_quota');
            }

            $applicant->update([
                'status' => $newStatus,
                'verified_at' => $newStatus === 'verified' ? now() : null,
            ]);

            $oldLabel = $this->statusLabel($oldStatus);
            $newLabel = $this->statusLabel($newStatus);
            $note = trim((string) ($validated['note'] ?? ''));
            $body = 'Status pendaftar diubah dari ' . $oldLabel . ' menjadi ' . $newLabel . '.';
            if ($note !== '') {
                $body .= ' Catatan: ' . $note;
            }

            $this->recordActivity(
                'smp',
                $applicant->id,
                'status',
                'Status pendaftaran diperbarui',
                $body,
                [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'program' => $applicant->school_program,
                    'note' => $note ?: null,
                ]
            );

            AuditLogger::record('admin.smp_applicant_status_updated', 'Status pendaftar SMPS diperbarui.', $applicant, [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'program' => $applicant->school_program,
                'registration_number' => $applicant->registration_number,
            ]);

            return ['type' => 'success', 'message' => 'Status pendaftar berhasil diubah menjadi ' . $newLabel . '.'];
        });

        return redirect()->back()->with($result['type'], $result['message']);
    }

    public function search(Request $request)
    {
        $query = SmpApplicant::query();

        if ($request->registration_number) {
            $query->where('registration_number', 'LIKE', '%' . $request->registration_number . '%');
        }

        if ($request->nik) {
            $query->where('nik', 'LIKE', '%' . $request->nik . '%');
        }
        if ($request->full_name) {
            $query->where('full_name', 'LIKE', '%' . trim($request->full_name) . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $applicants = $query->latest()->paginate(20)->withQueryString();
        $quotas = SmpRegistration::all();

        $stats = [
            'total' => SmpApplicant::count(),
            'pending' => SmpApplicant::where('status', 'pending')->count(),
            'verified' => SmpApplicant::where('status', 'verified')->count(),
            'rejected' => SmpApplicant::where('status', 'rejected')->count(),
        ];
        $dashboard = $this->buildDashboardAnalytics($quotas, $stats);
        $adminSection = 'applicants';

        return view('admin.smp.dashboard', compact('applicants', 'quotas', 'stats', 'dashboard', 'adminSection'))
            ->with('search', true);
    }

    private function buildDashboardAnalytics($quotas, array $stats): array
    {
        $period = max(7, min((int) request('period', 30), 90));
        $startDate = now()->subDays($period - 1)->startOfDay();
        $recentApplicants = SmpApplicant::where('created_at', '>=', $startDate)
            ->get(['id', 'full_name', 'registration_number', 'school_program', 'status', 'gender', 'created_at']);

        $dates = collect(range($period - 1, 0))->map(fn($i) => now()->subDays($i)->startOfDay());
        $trend = [
            'labels' => $dates->map(fn($date) => $date->locale('id')->isoFormat('D MMM'))->values()->all(),
            'total' => [],
            'verified' => [],
            'pending' => [],
            'rejected' => [],
        ];

        foreach ($dates as $date) {
            $items = $recentApplicants->filter(fn($applicant) => $applicant->created_at->isSameDay($date));
            $trend['total'][] = $items->count();
            $trend['verified'][] = $items->where('status', 'verified')->count();
            $trend['pending'][] = $items->where('status', 'pending')->count();
            $trend['rejected'][] = $items->where('status', 'rejected')->count();
        }

        $programDistribution = SmpApplicant::selectRaw('school_program as label, COUNT(*) as total')
            ->groupBy('school_program')
            ->orderByDesc('total')
            ->get()
            ->map(fn($row) => [
                'label' => $row->label ?: 'Belum memilih',
                'total' => (int) $row->total,
            ])
            ->values();

        $heatmap = $this->buildRegistrationHeatmap($recentApplicants);
        $capacityTotal = (int) $quotas->sum('quota');
        $capacityUsed = (int) $quotas->sum('used_quota');
        $capacityAvailable = max(0, $capacityTotal - $capacityUsed);
        $weekCount = SmpApplicant::where('created_at', '>=', now()->subDays(6)->startOfDay())->count();

        return [
            'period' => $period,
            'trend' => $trend,
            'status' => [
                'labels' => ['Pending', 'Terverifikasi', 'Ditolak'],
                'data' => [(int) $stats['pending'], (int) $stats['verified'], (int) $stats['rejected']],
            ],
            'distribution' => [
                'labels' => $programDistribution->pluck('label')->values()->all(),
                'data' => $programDistribution->pluck('total')->values()->all(),
            ],
            'quota' => [
                'labels' => $quotas->pluck('school_program')->values()->all(),
                'used' => $quotas->pluck('used_quota')->map(fn($value) => (int) $value)->values()->all(),
                'available' => $quotas->map(fn($quota) => max(0, (int) $quota->available_quota))->values()->all(),
                'percentage' => $quotas->map(fn($quota) => round((float) $quota->percentage, 1))->values()->all(),
            ],
            'heatmap' => $heatmap,
            'kpis' => [
                'today' => SmpApplicant::whereDate('created_at', today())->count(),
                'week' => $weekCount,
                'daily_average' => round($weekCount / 7, 1),
                'capacity_total' => $capacityTotal,
                'capacity_used' => $capacityUsed,
                'capacity_available' => $capacityAvailable,
                'capacity_rate' => $capacityTotal > 0 ? round(($capacityUsed / $capacityTotal) * 100, 1) : 0,
                'verification_rate' => $stats['total'] > 0 ? round(($stats['verified'] / $stats['total']) * 100, 1) : 0,
                'busiest_slot' => $heatmap['busiest_slot'],
            ],
            'quota_alerts' => $quotas
                ->filter(fn($quota) => $quota->available_quota <= 10 || $quota->percentage >= 85)
                ->map(fn($quota) => [
                    'label' => $quota->school_program,
                    'available' => (int) $quota->available_quota,
                    'percentage' => round((float) $quota->percentage, 1),
                ])
                ->values()
                ->all(),
            'latest' => SmpApplicant::latest()
                ->limit(5)
                ->get(['registration_number', 'full_name', 'school_program', 'status', 'created_at'])
                ->map(fn($applicant) => [
                    'registration_number' => $applicant->registration_number,
                    'name' => $applicant->full_name,
                    'choice' => $applicant->school_program,
                    'status' => $applicant->status,
                    'time' => $applicant->created_at->diffForHumans(),
                ])
                ->values()
                ->all(),
        ];
    }

    private function buildRegistrationHeatmap($applicants): array
    {
        $dayLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $slots = [
            ['label' => '00-03', 'start' => 0, 'end' => 3],
            ['label' => '04-07', 'start' => 4, 'end' => 7],
            ['label' => '08-11', 'start' => 8, 'end' => 11],
            ['label' => '12-15', 'start' => 12, 'end' => 15],
            ['label' => '16-19', 'start' => 16, 'end' => 19],
            ['label' => '20-23', 'start' => 20, 'end' => 23],
        ];

        $matrix = [];
        $max = 0;
        $busiest = ['label' => '-', 'count' => 0];

        foreach ($dayLabels as $dayIndex => $dayLabel) {
            foreach ($slots as $slotIndex => $slot) {
                $count = $applicants->filter(function ($applicant) use ($dayIndex, $slot) {
                    $created = $applicant->created_at;

                    return $created->dayOfWeekIso === $dayIndex + 1
                        && $created->hour >= $slot['start']
                        && $created->hour <= $slot['end'];
                })->count();

                $matrix[$dayIndex][$slotIndex] = $count;
                if ($count > $max) {
                    $max = $count;
                    $busiest = ['label' => $dayLabel . ' ' . $slot['label'], 'count' => $count];
                }
            }
        }

        return [
            'slots' => collect($slots)->pluck('label')->values()->all(),
            'rows' => collect($dayLabels)->map(function ($dayLabel, $dayIndex) use ($slots, $matrix, $max) {
                return [
                    'label' => $dayLabel,
                    'cells' => collect($slots)->map(function ($slot, $slotIndex) use ($matrix, $dayIndex, $max) {
                        $count = $matrix[$dayIndex][$slotIndex] ?? 0;

                        return [
                            'label' => $slot['label'],
                            'count' => $count,
                            'intensity' => $max > 0 ? round($count / $max, 2) : 0,
                        ];
                    })->values()->all(),
                ];
            })->values()->all(),
            'max' => $max,
            'busiest_slot' => $busiest,
        ];
    }

    public function exportExcel()
    {
        return Excel::download(new SmpApplicantsExport, 'data-pendaftar-' . date('Y-m-d') . '.xlsx');
    }

    public function printReceipt($id)
    {
        $applicant = SmpApplicant::findOrFail($id);
        return view('admin.smp.receipt-print', compact('applicant'));
    }

    public function viewDocuments($id)
    {
        $applicant = SmpApplicant::findOrFail($id);

        // Format tanggal untuk ditampilkan
        $formattedDates = [
            'birth_date' => $this->formatDate($applicant->birth_date),
            'father_birth_date' => $this->formatDate($applicant->father_birth_date),
            'mother_birth_date' => $this->formatDate($applicant->mother_birth_date),
            'guardian_birth_date' => $applicant->guardian_birth_date ? $this->formatDate($applicant->guardian_birth_date) : '-',
        ];

        // Daftar dokumen yang diupload
        $documents = [
            'photo' => [
                'label' => 'Pas Foto Siswa',
                'path' => $applicant->photo_path,
                'required' => true
            ],
            'kk' => [
                'label' => 'Kartu Keluarga (KK)',
                'path' => $applicant->kk_path,
                'required' => true
            ],
            'birth_certificate' => [
                'label' => 'Akta Kelahiran',
                'path' => $applicant->birth_certificate_path,
                'required' => true
            ],
            'mother_ktp' => [
                'label' => 'KTP Ibu',
                'path' => $applicant->mother_ktp_path,
                'required' => true
            ],
            'father_ktp' => [
                'label' => 'KTP Ayah',
                'path' => $applicant->father_ktp_path,
                'required' => true
            ],
            'guardian_ktp' => [
                'label' => 'KTP Wali',
                'path' => $applicant->guardian_ktp_path,
                'required' => false
            ],
            'diploma' => [
                'label' => 'Ijazah/SKL',
                'path' => $applicant->diploma_path,
                'required' => false
            ],
            'report_card' => [
                'label' => 'Rapor Siswa',
                'path' => $applicant->report_card_path,
                'required' => true
            ],
        ];

        $activities = $this->loadApplicantActivities('smp', $applicant->id);

        return view('admin.smp.documents', compact('applicant', 'formattedDates', 'documents', 'activities'));
    }

    public function storeActivity(Request $request, $id)
    {
        $applicant = SmpApplicant::findOrFail($id);
        $validated = $this->validateActivity($request);

        ApplicantActivity::create([
            'applicant_type' => 'smp',
            'applicant_id' => $applicant->id,
            'user_id' => Auth::id(),
            'category' => $validated['category'],
            'title' => $this->activityTitle($validated['category']),
            'body' => trim($validated['body']),
            'follow_up_at' => $validated['follow_up_at'] ?? null,
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return back()->with('success', 'Catatan tindak lanjut berhasil disimpan.');
    }

    public function previewDocument($type, $id)
    {
        $applicant = SmpApplicant::findOrFail($id);

        $fileMap = [
            'photo' => $applicant->photo_path,
            'kk' => $applicant->kk_path,
            'birth_certificate' => $applicant->birth_certificate_path,
            'mother_ktp' => $applicant->mother_ktp_path,
            'father_ktp' => $applicant->father_ktp_path,
            'guardian_ktp' => $applicant->guardian_ktp_path,
            'diploma' => $applicant->diploma_path,
            'report_card' => $applicant->report_card_path,
        ];

        if (!isset($fileMap[$type]) || !$fileMap[$type]) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        $relativePath = $fileMap[$type];
        if (str_contains($relativePath, '..') || str_starts_with($relativePath, '/') || str_starts_with($relativePath, '\\')) {
            abort(404, 'File tidak valid');
        }

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = Storage::disk('public')->path($relativePath);
        $mimeType = Storage::disk('public')->mimeType($relativePath) ?: 'application/octet-stream';

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    /**
     * Tampilkan form edit data pendaftar
     */
    public function edit($id)
    {
        $applicant = SmpApplicant::findOrFail($id); // 👈 HANYA findOrFail(), bukan withTrashed()

        // Format tanggal untuk ditampilkan di form
        $formattedDates = [
            'birth_date' => $this->formatDateForDisplay($applicant->birth_date),
            'father_birth_date' => $this->formatDateForDisplay($applicant->father_birth_date),
            'mother_birth_date' => $this->formatDateForDisplay($applicant->mother_birth_date),
            'guardian_birth_date' => $applicant->guardian_birth_date ? $this->formatDateForDisplay($applicant->guardian_birth_date) : null,
        ];

        return view('admin.smp.edit', compact('applicant', 'formattedDates'));
    }

    /**
     * Update data pendaftar
     */
    public function update(Request $request, $id)
    {
        $applicant = SmpApplicant::findOrFail($id); // 👈 HANYA findOrFail()

        // Validasi dasar
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'phone' =>'required',
            'email' => 'required|email',
            'school_program' => 'required|string',
        ]);

        // Cek NIK duplikat (kecuali NIK milik pendaftar ini)
        $existingApplicant = SmpApplicant::where('nik', $request->nik)
            ->where('id', '!=', $id)
            ->first();

        if ($existingApplicant) {
            return back()->with('error', 'NIK tersebut sudah digunakan oleh pendaftar lain!')
                ->withInput();
        }

        // Handle upload file baru (opsional)
        $updateData = [
            'kk_area' => $request->kk_area,
            'kk_number' => $request->kk_number,
            'nik' => $request->nik,
            'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $this->convertDateFormat($request->birth_date),
            'religion' => $request->religion,
            'phone' => $request->phone,
            'email' => $request->email,
            'previous_school' => $request->previous_school,
            'school_program' => $request->school_program,
            'citizenship' => $request->citizenship,
            'birth_certificate_number' => $request->birth_certificate_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'head_circumference' => $request->head_circumference,
            'siblings_count' => $request->siblings_count,
            'child_order' => $request->child_order,
            'disability' => $request->disability,

            // Alamat KTP Orang Tua
            'parent_ktp_village' => $request->parent_ktp_village,
            'parent_ktp_rt' => $request->parent_ktp_rt,
            'parent_ktp_rw' => $request->parent_ktp_rw,
            'parent_ktp_subdistrict' => $request->parent_ktp_subdistrict,
            'parent_ktp_district' => $request->parent_ktp_district,
            'parent_ktp_city' => $request->parent_ktp_city,
            'parent_ktp_province' => $request->parent_ktp_province,
            'parent_ktp_residence_status' => $request->parent_ktp_residence_status,
            'parent_ktp_distance_to_school' => $request->parent_ktp_distance_to_school,
            'parent_ktp_transportation' => $request->parent_ktp_transportation,

            // Alamat Domisili Siswa
            'same_as_ktp' => $request->has('same_as_ktp'),
            'current_village' => $request->same_as_ktp ? $request->parent_ktp_village : $request->current_village,
            'current_rt' => $request->same_as_ktp ? $request->parent_ktp_rt : $request->current_rt,
            'current_rw' => $request->same_as_ktp ? $request->parent_ktp_rw : $request->current_rw,
            'current_subdistrict' => $request->same_as_ktp ? $request->parent_ktp_subdistrict : $request->current_subdistrict,
            'current_district' => $request->same_as_ktp ? $request->parent_ktp_district : $request->current_district,
            'current_city' => $request->same_as_ktp ? $request->parent_ktp_city : $request->current_city,
            'current_province' => $request->same_as_ktp ? $request->parent_ktp_province : $request->current_province,
            'current_residence_status' => $request->same_as_ktp ? $request->parent_ktp_residence_status : $request->current_residence_status,
            'current_distance_to_school' => $request->same_as_ktp ? $request->parent_ktp_distance_to_school : $request->current_distance_to_school,
            'current_transportation' => $request->same_as_ktp ? $request->parent_ktp_transportation : $request->current_transportation,

            // Data Ayah
            'father_nik' => $request->father_nik,
            'father_name' => $request->father_name,
            'father_birth_place' => $request->father_birth_place,
            'father_birth_date' => $this->convertDateFormat($request->father_birth_date),
            'father_education' => $request->father_education,
            'father_occupation' => $request->father_occupation,
            'father_income' => $request->father_income,
            'father_phone' => $request->father_phone,
            'father_disability' => $request->father_disability,

            // Data Ibu
            'mother_nik' => $request->mother_nik,
            'mother_name' => $request->mother_name,
            'mother_birth_place' => $request->mother_birth_place,
            'mother_birth_date' => $this->convertDateFormat($request->mother_birth_date),
            'mother_education' => $request->mother_education,
            'mother_occupation' => $request->mother_occupation,
            'mother_income' => $request->mother_income,
            'mother_phone' => $request->mother_phone,
            'mother_disability' => $request->mother_disability,

            // Data Wali
            'has_guardian' => $request->has('has_guardian'),
            'guardian_nik' => $request->guardian_nik ?? null,
            'guardian_name' => $request->guardian_name ?? null,
            'guardian_birth_place' => $request->guardian_birth_place ?? null,
            'guardian_birth_date' => $request->guardian_birth_date ? $this->convertDateFormat($request->guardian_birth_date) : null,
            'guardian_education' => $request->guardian_education ?? null,
            'guardian_occupation' => $request->guardian_occupation ?? null,
            'guardian_income' => $request->guardian_income ?? null,
            'guardian_phone' => $request->guardian_phone ?? null,
            'guardian_disability' => $request->guardian_disability ?? null,
        ];

        // Handle upload file baru
        if ($request->hasFile('photo')) {
            // Hapus file lama jika ada
            if ($applicant->photo_path && Storage::disk('public')->exists($applicant->photo_path)) {
                Storage::disk('public')->delete($applicant->photo_path);
            }
            $updateData['photo_path'] = $request->file('photo')->store('smp/photos', 'public');
        }

        if ($request->hasFile('kk_file')) {
            if ($applicant->kk_path && Storage::disk('public')->exists($applicant->kk_path)) {
                Storage::disk('public')->delete($applicant->kk_path);
            }
            $updateData['kk_path'] = $request->file('kk_file')->store('smp/documents', 'public');
        }

        if ($request->hasFile('birth_certificate')) {
            if ($applicant->birth_certificate_path && Storage::disk('public')->exists($applicant->birth_certificate_path)) {
                Storage::disk('public')->delete($applicant->birth_certificate_path);
            }
            $updateData['birth_certificate_path'] = $request->file('birth_certificate')->store('smp/documents', 'public');
        }

        if ($request->hasFile('mother_ktp')) {
            if ($applicant->mother_ktp_path && Storage::disk('public')->exists($applicant->mother_ktp_path)) {
                Storage::disk('public')->delete($applicant->mother_ktp_path);
            }
            $updateData['mother_ktp_path'] = $request->file('mother_ktp')->store('smp/documents', 'public');
        }

        if ($request->hasFile('father_ktp')) {
            if ($applicant->father_ktp_path && Storage::disk('public')->exists($applicant->father_ktp_path)) {
                Storage::disk('public')->delete($applicant->father_ktp_path);
            }
            $updateData['father_ktp_path'] = $request->file('father_ktp')->store('smp/documents', 'public');
        }

        if ($request->hasFile('guardian_ktp')) {
            if ($applicant->guardian_ktp_path && Storage::disk('public')->exists($applicant->guardian_ktp_path)) {
                Storage::disk('public')->delete($applicant->guardian_ktp_path);
            }
            $updateData['guardian_ktp_path'] = $request->file('guardian_ktp')->store('smp/documents', 'public');
        }

        if ($request->hasFile('diploma')) {
            if ($applicant->diploma_path && Storage::disk('public')->exists($applicant->diploma_path)) {
                Storage::disk('public')->delete($applicant->diploma_path);
            }
            $updateData['diploma_path'] = $request->file('diploma')->store('smp/documents', 'public');
        }

        if ($request->hasFile('report_card')) {
            if ($applicant->report_card_path && Storage::disk('public')->exists($applicant->report_card_path)) {
                Storage::disk('public')->delete($applicant->report_card_path);
            }
            $updateData['report_card_path'] = $request->file('report_card')->store('smp/documents', 'public');
        }

        // Update data
        $applicant->update($updateData);

        $this->recordActivity(
            'smp',
            $applicant->id,
            'document',
            'Data pendaftar diperbarui',
            'Admin memperbarui data atau berkas pendaftar.',
            ['updated_by' => Auth::id()]
        );

        AuditLogger::record('admin.smp_applicant_updated', 'Data pendaftar SMPS diperbarui.', $applicant, [
            'program' => $applicant->school_program,
            'registration_number' => $applicant->registration_number,
        ]);

        return redirect()->route('admin.smp.documents', $applicant->id)
            ->with('success', 'Data pendaftar berhasil diperbarui!');
    }

    /**
     * HAPUS PERMANEN (HARD DELETE)
     */
    /**
 * HAPUS PERMANEN (HARD DELETE) + KEMBALIKAN KUOTA
 */
public function destroy($id)
{
    $files = DB::transaction(function () use ($id) {
        $applicant = SmpApplicant::lockForUpdate()->findOrFail($id);

        if ($applicant->status === 'verified') {
            $registration = SmpRegistration::where('school_program', $applicant->school_program)->lockForUpdate()->first();

            if ($registration && $registration->used_quota > 0) {
                $registration->decrement('used_quota');
            }
        }

        $files = [
            $applicant->photo_path,
            $applicant->kk_path,
            $applicant->birth_certificate_path,
            $applicant->mother_ktp_path,
            $applicant->father_ktp_path,
            $applicant->guardian_ktp_path,
            $applicant->diploma_path,
            $applicant->report_card_path,
        ];

        AuditLogger::record('admin.smp_applicant_deleted', 'Pendaftar SMPS dihapus permanen.', $applicant, [
            'program' => $applicant->school_program,
            'registration_number' => $applicant->registration_number,
        ]);

        $applicant->delete();

        return $files;
    });

    foreach ($files as $file) {
        if ($file && Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

    return redirect()->route('admin.smp.dashboard')
        ->with('success', 'Pendaftaran berhasil dihapus permanen! Kuota telah dikembalikan.');
}

    /**
     * Helper: Konversi format tanggal dd/mm/yyyy ke yyyy-mm-dd
     */
    protected function convertDateFormat($dateString)
    {
        if (!$dateString) return null;

        $parts = explode('/', $dateString);
        if (count($parts) === 3) {
            $day = intval($parts[0]);
            $month = intval($parts[1]);
            $year = intval($parts[2]);

            if (checkdate($month, $day, $year)) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        return $dateString;
    }

    /**
     * Helper: Format tanggal untuk ditampilkan
     */
    protected function formatDateForDisplay($date)
    {
        if (!$date) return null;
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function formatDate($date)
    {
        if (!$date) return '-';
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function loadApplicantActivities(string $type, int $id)
    {
        return ApplicantActivity::with('user')
            ->forApplicant($type, $id)
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
    }

    private function validateActivity(Request $request): array
    {
        return $request->validate([
            'category' => 'required|in:note,document,phone,visit,payment,warning',
            'body' => 'required|string|max:2000',
            'follow_up_at' => 'nullable|date',
            'is_pinned' => 'nullable|boolean',
        ], [
            'body.required' => 'Catatan wajib diisi.',
            'body.max' => 'Catatan maksimal 2000 karakter.',
        ]);
    }

    private function activityTitle(string $category): string
    {
        return match ($category) {
            'document' => 'Catatan berkas',
            'phone' => 'Follow-up telepon',
            'visit' => 'Rencana kunjungan',
            'payment' => 'Catatan keuangan',
            'warning' => 'Perhatian verifikasi',
            default => 'Catatan admin',
        };
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    private function recordActivity(string $type, int $id, string $category, string $title, ?string $body = null, array $metadata = []): void
    {
        try {
            ApplicantActivity::create([
                'applicant_type' => $type,
                'applicant_id' => $id,
                'user_id' => Auth::id(),
                'category' => $category,
                'title' => $title,
                'body' => $body,
                'metadata' => $metadata ?: null,
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Gagal mencatat aktivitas pendaftar', [
                'applicant_type' => $type,
                'applicant_id' => $id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
