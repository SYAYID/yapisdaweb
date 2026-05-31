<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantActivity;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicantsExport;
use App\Support\AuditLogger;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required|string',
        ]);

        $guard = Auth::guard('admin_smk');

        if ($guard->attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (!$guard->user()->hasRole(['admin_smk', 'super_admin'])) {
                $guard->logout();

                return back()->with('error', 'Akun ini tidak memiliki akses admin SMKS.');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Email atau password salah!')->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin_smk')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin_smk')->user() ?: Auth::guard('web')->user();

            if (!$user || !$user->hasRole(['admin_smk', 'super_admin'])) {
                return redirect()->route('admin.login');
            }

            Auth::shouldUse(Auth::guard('admin_smk')->check() ? 'admin_smk' : 'web');

            return $next($request);
        })
        ->except(['login', 'postLogin', 'logout']);
    }

    public function index(Request $request)
    {
        $adminSection = match ($request->route()?->getName()) {
            'admin.analytics' => 'analytics',
            'admin.quotas' => 'quotas',
            'admin.applicants' => 'applicants',
            'admin.guide' => 'guide',
            default => 'dashboard',
        };

        $applicants = Applicant::latest()->paginate(75);
        $quotas = Registration::all();
        $genderStats = DB::table('applicants')
            ->select('gender',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as verified'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected')
            )
            ->groupBy('gender')
            ->get();

        $stats = [
            'total' => Applicant::count(),
            'pending' => Applicant::where('status', 'pending')->count(),
            'verified' => Applicant::where('status', 'verified')->count(),
            'rejected' => Applicant::where('status', 'rejected')->count(),
        ];
        $majorStats = Registration::withCount([
            'applicants as pending_count' => fn($q) => $q->where('status', 'pending'),
            'applicants as verified_count' => fn($q) => $q->where('status', 'verified'),
            'applicants as rejected_count' => fn($q) => $q->where('status', 'rejected'),
            'applicants as total_count' => fn($q) => $q,
        ])
        ->get()
        ->map(function($quota) {
            return [
                'major' => $quota->major,
                'quota' => $quota->quota,
                'used_quota' => $quota->used_quota,
                'available_quota' => $quota->available_quota,
                'percentage' => $quota->percentage,
                'status' => $quota->status,
                // Statistik verifikasi
                'pending_count' => $quota->pending_count,
                'verified_count' => $quota->verified_count,
                'rejected_count' => $quota->rejected_count,
                'total_count' => $quota->total_count,
                'verification_rate' => $quota->total_count > 0
                    ? round(($quota->verified_count / $quota->total_count) * 100, 1)
                    : 0,
            ];
        });
        $dashboard = $this->buildDashboardAnalytics($quotas, $stats);

        $auditLogs = collect();
        if ($adminSection === 'quotas') {
            $auditLogs = \App\Models\AuditLog::where('event', 'LIKE', 'admin.smk%')
                ->latest()
                ->paginate(20, ['*'], 'audit_page')
                ->withQueryString();
        }

        return view('admin.dashboard', compact('stats', 'quotas', 'applicants', 'majorStats', 'genderStats', 'dashboard', 'adminSection', 'auditLogs'));
    }

    public function updateQuota(Request $request)
    {
        $validated = $request->validate([
            'major' => 'required|string|exists:registrations,major',
            'quota' => 'required|integer|min:0',
        ], [
            'major.required' => 'Jurusan wajib diisi.',
            'major.exists' => 'Jurusan tidak terdaftar.',
            'quota.required' => 'Jumlah kuota wajib diisi.',
            'quota.integer' => 'Jumlah kuota harus berupa angka.',
            'quota.min' => 'Jumlah kuota minimal 0.',
        ]);

        $registration = Registration::where('major', $validated['major'])->firstOrFail();
        $oldQuota = $registration->quota;

        if ($validated['quota'] < $registration->used_quota) {
            return redirect()->back()->with('error', 'Jumlah kuota baru tidak boleh lebih kecil dari kuota terpakai (' . $registration->used_quota . ').');
        }

        $registration->update([
            'quota' => $validated['quota']
        ]);

        AuditLogger::record(
            'admin.smk_quota_updated',
            'Kuota jurusan ' . $registration->major . ' diperbarui.',
            $registration,
            [
                'major' => $registration->major,
                'old_quota' => $oldQuota,
                'new_quota' => $validated['quota'],
            ]
        );

        return redirect()->back()->with('success', 'Kuota jurusan ' . $registration->major . ' berhasil diperbarui dari ' . $oldQuota . ' menjadi ' . $validated['quota'] . '.');
    }

    /**
     * ✅ KURANGI KUOTA SAAT VERIFIKASI
     */
    public function verify($id)
    {
        $result = DB::transaction(function () use ($id) {
            $applicant = Applicant::lockForUpdate()->findOrFail($id);

            if ($applicant->status === 'verified') {
                return ['type' => 'error', 'message' => 'Pendaftaran sudah terverifikasi!'];
            }

            $registration = Registration::where('major', $applicant->major_choice)->lockForUpdate()->first();

            if (!$registration) {
                return ['type' => 'error', 'message' => 'Jurusan tidak ditemukan!'];
            }

            if ($registration->quota <= $registration->used_quota) {
                return ['type' => 'error', 'message' => 'Maaf, kuota untuk jurusan ' . $applicant->major_choice . ' sudah penuh!'];
            }

            $registration->increment('used_quota');
            $applicant->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);

            $this->recordActivity(
                'smk',
                $applicant->id,
                'status',
                'Pendaftaran diverifikasi',
                'Status pendaftar diubah menjadi terverifikasi dan kuota jurusan dikurangi.',
                ['status' => 'verified', 'major' => $applicant->major_choice]
            );

            AuditLogger::record('admin.smk_applicant_verified', 'Pendaftar SMKS diverifikasi.', $applicant, [
                'major' => $applicant->major_choice,
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
            $applicant = Applicant::lockForUpdate()->findOrFail($id);

            if ($applicant->status === 'verified') {
                $registration = Registration::where('major', $applicant->major_choice)->lockForUpdate()->first();
                if ($registration && $registration->used_quota > 0) {
                    $registration->decrement('used_quota');
                }
            }

            $applicant->update([
                'status' => 'rejected',
                'verified_at' => null,
            ]);

            $this->recordActivity(
                'smk',
                $applicant->id,
                'status',
                'Pendaftaran ditolak',
                'Status pendaftar diubah menjadi ditolak.',
                ['status' => 'rejected', 'major' => $applicant->major_choice]
            );

            AuditLogger::record('admin.smk_applicant_rejected', 'Pendaftar SMKS ditolak.', $applicant, [
                'major' => $applicant->major_choice,
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
            $applicant = Applicant::lockForUpdate()->findOrFail($id);
            $oldStatus = $applicant->status;
            $newStatus = $validated['status'];

            if ($oldStatus === $newStatus) {
                return ['type' => 'success', 'message' => 'Status pendaftar tidak berubah.'];
            }

            $registration = null;
            if ($oldStatus === 'verified' || $newStatus === 'verified') {
                $registration = Registration::where('major', $applicant->major_choice)
                    ->lockForUpdate()
                    ->first();

                if (!$registration) {
                    return ['type' => 'error', 'message' => 'Jurusan tidak ditemukan, status belum dapat diubah.'];
                }
            }

            if ($oldStatus !== 'verified' && $newStatus === 'verified') {
                if ($registration->quota <= $registration->used_quota) {
                    return ['type' => 'error', 'message' => 'Kuota untuk jurusan ' . $applicant->major_choice . ' sudah penuh.'];
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
                'smk',
                $applicant->id,
                'status',
                'Status pendaftaran diperbarui',
                $body,
                [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'major' => $applicant->major_choice,
                    'note' => $note ?: null,
                ]
            );

            AuditLogger::record('admin.smk_applicant_status_updated', 'Status pendaftar SMKS diperbarui.', $applicant, [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'major' => $applicant->major_choice,
                'registration_number' => $applicant->registration_number,
            ]);

            return ['type' => 'success', 'message' => 'Status pendaftar berhasil diubah menjadi ' . $newLabel . '.'];
        });

        return redirect()->back()->with($result['type'], $result['message']);
    }

    public function search(Request $request)
    {
        $query = Applicant::query();

        if ($request->registration_number) {
            $query->where('registration_number', 'LIKE', '%' . $request->registration_number . '%');
        }

        if ($request->nik) {
            $query->where('nik', 'LIKE', '%' . $request->nik . '%');
        }
        if ($request->full_name) {
            $query->where('full_name', 'LIKE', '%' . trim($request->full_name) . '%');
        }

        if ($request->major) {
        $query->where('major_choice', $request->major);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $applicants = $query->latest()->paginate(75)->withQueryString();
        $quotas = Registration::all();

        $genderStats = DB::table('applicants')
        ->select('gender',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as verified'),
            DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
            DB::raw('SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected')
        )
        ->groupBy('gender')
        ->get();

        $stats = [
            'total' => Applicant::count(),
            'pending' => Applicant::where('status', 'pending')->count(),
            'verified' => Applicant::where('status', 'verified')->count(),
            'rejected' => Applicant::where('status', 'rejected')->count(),
        ];
        $majorStats = Registration::withCount([
            'applicants as pending_count' => fn($q) => $q->where('status', 'pending'),
            'applicants as verified_count' => fn($q) => $q->where('status', 'verified'),
            'applicants as rejected_count' => fn($q) => $q->where('status', 'rejected'),
            'applicants as total_count' => fn($q) => $q,
        ])
        ->get()
        ->map(function($quota) {
            return [
                'major' => $quota->major,
                'quota' => $quota->quota,
                'used_quota' => $quota->used_quota,
                'available_quota' => $quota->available_quota,
                'percentage' => $quota->percentage,
                'status' => $quota->status,
                // Statistik verifikasi
                'pending_count' => $quota->pending_count,
                'verified_count' => $quota->verified_count,
                'rejected_count' => $quota->rejected_count,
                'total_count' => $quota->total_count,
                'verification_rate' => $quota->total_count > 0
                    ? round(($quota->verified_count / $quota->total_count) * 100, 1)
                    : 0,
            ];
        });

        $dashboard = $this->buildDashboardAnalytics($quotas, $stats);
        $adminSection = 'applicants';

        return view('admin.dashboard', compact('applicants', 'quotas', 'stats', 'majorStats', 'genderStats', 'dashboard', 'adminSection'))
            ->with('search', true);
    }

    private function buildDashboardAnalytics($quotas, array $stats): array
    {
        $period = max(7, min((int) request('period', 30), 90));
        $startDate = now()->subDays($period - 1)->startOfDay();
        $recentApplicants = Applicant::where('created_at', '>=', $startDate)
            ->get(['id', 'full_name', 'registration_number', 'major_choice', 'status', 'gender', 'created_at']);

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

        $majorDistribution = Applicant::selectRaw('major_choice as label, COUNT(*) as total')
            ->groupBy('major_choice')
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
        $weekCount = Applicant::where('created_at', '>=', now()->subDays(6)->startOfDay())->count();

        return [
            'period' => $period,
            'trend' => $trend,
            'status' => [
                'labels' => ['Pending', 'Terverifikasi', 'Ditolak'],
                'data' => [(int) $stats['pending'], (int) $stats['verified'], (int) $stats['rejected']],
            ],
            'distribution' => [
                'labels' => $majorDistribution->pluck('label')->values()->all(),
                'data' => $majorDistribution->pluck('total')->values()->all(),
            ],
            'quota' => [
                'labels' => $quotas->pluck('major')->values()->all(),
                'used' => $quotas->pluck('used_quota')->map(fn($value) => (int) $value)->values()->all(),
                'available' => $quotas->map(fn($quota) => max(0, (int) $quota->available_quota))->values()->all(),
                'percentage' => $quotas->map(fn($quota) => round((float) $quota->percentage, 1))->values()->all(),
            ],
            'heatmap' => $heatmap,
            'kpis' => [
                'today' => Applicant::whereDate('created_at', today())->count(),
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
                    'label' => $quota->major,
                    'available' => (int) $quota->available_quota,
                    'percentage' => round((float) $quota->percentage, 1),
                ])
                ->values()
                ->all(),
            'latest' => Applicant::latest()
                ->limit(5)
                ->get(['registration_number', 'full_name', 'major_choice', 'status', 'created_at'])
                ->map(fn($applicant) => [
                    'registration_number' => $applicant->registration_number,
                    'name' => $applicant->full_name,
                    'choice' => $applicant->major_choice,
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
        return Excel::download(new ApplicantsExport, 'data-pendaftar-' . date('Y-m-d') . '.xlsx');
    }

    public function printReceipt($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('admin.receipt-print', compact('applicant'));
    }

    public function viewDocuments($id)
    {
        $applicant = Applicant::findOrFail($id);

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

        $activities = $this->loadApplicantActivities('smk', $applicant->id);

        return view('admin.documents', compact('applicant', 'formattedDates', 'documents', 'activities'));
    }

    public function storeActivity(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $validated = $this->validateActivity($request);

        ApplicantActivity::create([
            'applicant_type' => 'smk',
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
        $applicant = Applicant::findOrFail($id);

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
        $applicant = Applicant::findOrFail($id); // 👈 HANYA findOrFail(), bukan withTrashed()

        // Format tanggal untuk ditampilkan di form
        $formattedDates = [
            'birth_date' => $this->formatDateForDisplay($applicant->birth_date),
            'father_birth_date' => $this->formatDateForDisplay($applicant->father_birth_date),
            'mother_birth_date' => $this->formatDateForDisplay($applicant->mother_birth_date),
            'guardian_birth_date' => $applicant->guardian_birth_date ? $this->formatDateForDisplay($applicant->guardian_birth_date) : null,
        ];

        return view('admin.edit', compact('applicant', 'formattedDates'));
    }

    /**
     * Update data pendaftar
     */
    public function update(Request $request, $id)
{
    try {
        // Debug logging
        Log::info('=== UPDATE SMK START ===', ['applicant_id' => $id]);

        $applicant = Applicant::findOrFail($id);

        // ✅ VALIDASI LENGKAP - Semua field required divalidasi
        $validated = $request->validate([
            // Data Siswa - Required
            'full_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'kk_number' => 'required|digits:16',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date_format:d/m/Y',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'religion' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'previous_school' => 'required|string|max:255',
            'major_choice' => 'required|string',
            'kk_area' => 'required|string',
            'birth_certificate_number' => 'required|string',
            'height' => 'required|integer|min:50|max:250',
            'weight' => 'required|integer|min:20|max:200',
            'siblings_count' => 'required|integer|min:0',
            'child_order' => 'required|integer|min:1',
            'disability' => 'required|string',
            'citizenship' => 'required|in:WNI,WNA',

            // Alamat KTP - Required
            'parent_ktp_village' => 'required|string|max:255',
            'parent_ktp_rt' => 'required|string|max:10',
            'parent_ktp_rw' => 'required|string|max:10',
            'parent_ktp_subdistrict' => 'required|string|max:100',
            'parent_ktp_district' => 'required|string|max:100',
            'parent_ktp_city' => 'required|string|max:100',
            'parent_ktp_province' => 'required|string|max:100',
            'parent_ktp_residence_status' => 'required|string',
            'parent_ktp_distance_to_school' => 'required|string',
            'parent_ktp_transportation' => 'required|string',

            // Field opsional
            'nisn' => 'nullable|string|max:50',
            'head_circumference' => 'nullable|integer|min:30|max:80',

            // Data Orang Tua - Required
            'father_nik' => 'required|digits:16',
            'father_name' => 'required|string|max:255',
            'father_birth_place' => 'required|string|max:100',
            'father_birth_date' => 'required|date_format:d/m/Y',
            'father_education' => 'required|string',
            'father_occupation' => 'required|string',
            'father_income' => 'required|string',
            'father_phone' => 'required|string|max:20',
            'father_disability' => 'required|string',

            'mother_nik' => 'required|digits:16',
            'mother_name' => 'required|string|max:255',
            'mother_birth_place' => 'required|string|max:100',
            'mother_birth_date' => 'required|date_format:d/m/Y',
            'mother_education' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_income' => 'required|string',
            'mother_phone' => 'required|string|max:20',
            'mother_disability' => 'required|string',

            // Data Wali - Nullable
            'guardian_nik' => 'nullable|digits:16',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birth_place' => 'nullable|string|max:100',
            'guardian_birth_date' => 'nullable|date_format:d/m/Y',
            'guardian_education' => 'nullable|string',
            'guardian_occupation' => 'nullable|string',
            'guardian_income' => 'nullable|string',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_disability' => 'nullable|string',

        ], [
            // Custom error messages
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka',
            'kk_number.digits' => 'Nomor KK harus terdiri dari 16 digit angka',
            'birth_date.date_format' => 'Format tanggal harus dd/mm/yyyy',
            'father_nik.digits' => 'NIK Ayah harus 16 digit',
            'mother_nik.digits' => 'NIK Ibu harus 16 digit',
            'email.email' => 'Format email tidak valid',
        ]);

        // ✅ CEK NIK DUPLIKAT (kecuali milik pendaftar ini)
        $existingApplicant = Applicant::where('nik', $validated['nik'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingApplicant) {
            return back()->with('error', 'NIK tersebut sudah digunakan oleh pendaftar lain!')
                ->withInput();
        }

        // ✅ KONVERSI TANGGAL dd/mm/yyyy → yyyy-mm-dd
        $updateData = array_merge($validated, [
            'birth_date' => $this->convertDateFormat($request->birth_date),
            'father_birth_date' => $this->convertDateFormat($request->father_birth_date),
            'mother_birth_date' => $this->convertDateFormat($request->mother_birth_date),
            'guardian_birth_date' => $request->guardian_birth_date ? $this->convertDateFormat($request->guardian_birth_date) : null,
        ]);

        if ($applicant->status === 'verified' && $applicant->major_choice !== $request->major_choice) {
        $oldMajor = $applicant->major_choice;
        $newMajor = $request->major_choice;

        // 1. Kembalikan kuota ke jurusan lama
        $oldRegistration = Registration::where('major', $oldMajor)->first();
        if ($oldRegistration && $oldRegistration->used_quota > 0) {
            $oldRegistration->decrement('used_quota');
        }

        // 2. Cek ketersediaan jurusan baru
        $newRegistration = Registration::where('major', $newMajor)->first();
        if (!$newRegistration) {
            if ($oldRegistration) $oldRegistration->increment('used_quota'); // Rollback
            return back()->with('error', 'Jurusan baru tidak ditemukan!')->withInput();
        }

        if ($newRegistration->available_quota <= 0) {
            if ($oldRegistration) $oldRegistration->increment('used_quota'); // Rollback
            return back()->with('error', 'Maaf, kuota untuk jurusan ' . $newMajor . ' sudah penuh!')->withInput();
        }

        // 3. Kurangi kuota jurusan baru
        $newRegistration->increment('used_quota');
    }

        // ✅ LOGIKA same_as_ktp YANG BENAR + FALLBACK
        $isSameAsKtp = $request->has('same_as_ktp');
        $updateData['same_as_ktp'] = $isSameAsKtp;

        if ($isSameAsKtp) {
            // Jika sama dengan KTP, copy dari parent_ktp
            $updateData['current_village'] = $request->parent_ktp_village;
            $updateData['current_rt'] = $request->parent_ktp_rt;
            $updateData['current_rw'] = $request->parent_ktp_rw;
            $updateData['current_subdistrict'] = $request->parent_ktp_subdistrict;
            $updateData['current_district'] = $request->parent_ktp_district;
            $updateData['current_city'] = $request->parent_ktp_city;
            $updateData['current_province'] = $request->parent_ktp_province;
            $updateData['current_residence_status'] = $request->parent_ktp_residence_status;
            $updateData['current_distance_to_school'] = $request->parent_ktp_distance_to_school;
            $updateData['current_transportation'] = $request->parent_ktp_transportation;
        } else {
            // Jika berbeda, ambil dari request dengan fallback ke nilai lama
            $updateData['current_village'] = $request->current_village ?? $applicant->current_village;
            $updateData['current_rt'] = $request->current_rt ?? $applicant->current_rt;
            $updateData['current_rw'] = $request->current_rw ?? $applicant->current_rw;
            $updateData['current_subdistrict'] = $request->current_subdistrict ?? $applicant->current_subdistrict;
            $updateData['current_district'] = $request->current_district ?? $applicant->current_district;
            $updateData['current_city'] = $request->current_city ?? $applicant->current_city;
            $updateData['current_province'] = $request->current_province ?? $applicant->current_province;
            $updateData['current_residence_status'] = $request->current_residence_status ?? $applicant->current_residence_status;
            $updateData['current_distance_to_school'] = $request->current_distance_to_school ?? $applicant->current_distance_to_school;
            $updateData['current_transportation'] = $request->current_transportation ?? $applicant->current_transportation;
        }

        // ✅ HANDLE FILE UPLOADS
        $files = [
            'photo' => ['field' => 'photo_path', 'folder' => 'photos'],
            'kk_file' => ['field' => 'kk_path', 'folder' => 'documents'],
            'birth_certificate' => ['field' => 'birth_certificate_path', 'folder' => 'documents'],
            'mother_ktp' => ['field' => 'mother_ktp_path', 'folder' => 'documents'],
            'father_ktp' => ['field' => 'father_ktp_path', 'folder' => 'documents'],
            'guardian_ktp' => ['field' => 'guardian_ktp_path', 'folder' => 'documents'],
            'diploma' => ['field' => 'diploma_path', 'folder' => 'documents'],
            'report_card' => ['field' => 'report_card_path', 'folder' => 'documents'],
        ];

        foreach ($files as $inputName => $config) {
            if ($request->hasFile($inputName)) {
                // Hapus file lama jika ada
                $oldPath = $applicant->{$config['field']};
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                // Upload file baru
                $updateData[$config['field']] = $request->file($inputName)->store($config['folder'], 'public');
            }
        }

        // ✅ UPDATE DATA KE DATABASE
        $applicant->update($updateData);

        $this->recordActivity(
            'smk',
            $applicant->id,
            'document',
            'Data pendaftar diperbarui',
            'Admin memperbarui data atau berkas pendaftar.',
            ['updated_by' => Auth::id()]
        );

        AuditLogger::record('admin.smk_applicant_updated', 'Data pendaftar SMKS diperbarui.', $applicant, [
            'major' => $applicant->major_choice,
            'registration_number' => $applicant->registration_number,
        ]);

        Log::info('=== UPDATE SUCCESS ===', ['applicant_id' => $id]);

        return redirect()->route('admin.documents', $applicant->id)
            ->with('success', '✅ Data pendaftar berhasil diperbarui!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed:', $e->errors());
        return redirect()->back()->withErrors($e->errors())->withInput();

    } catch (\Exception $e) {
        Log::error('Update error: ' . $e->getMessage());
        Log::error('Trace: ' . $e->getTraceAsString());
        return redirect()->back()->with('error', '❌ Gagal menyimpan: ' . $e->getMessage());
    }
}

    /**
     * HAPUS PERMANEN (HARD DELETE)
     */
    public function destroy($id)
    {
        $files = DB::transaction(function () use ($id) {
            $applicant = Applicant::lockForUpdate()->findOrFail($id);

            if ($applicant->status === 'verified') {
                $registration = Registration::where('major', $applicant->major_choice)->lockForUpdate()->first();
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

            AuditLogger::record('admin.smk_applicant_deleted', 'Pendaftar SMKS dihapus permanen.', $applicant, [
                'major' => $applicant->major_choice,
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

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pendaftaran berhasil dihapus permanen! Siswa dapat mendaftar ulang dengan NIK yang sama.');
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
