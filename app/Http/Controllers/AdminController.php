<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicantsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username == 'admin' && $request->password == 'admin123') {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::get('admin_logged_in')) {
                return redirect()->route('admin.login');
            }
            return $next($request);
        })
        ->except(['login', 'postLogin', 'logout']);
    }

    public function index()
    {
        $applicants = Applicant::latest()->paginate(20);
        $quotas = Registration::all();
        
        $stats = [
            'total' => Applicant::count(),
            'pending' => Applicant::where('status', 'pending')->count(),
            'verified' => Applicant::where('status', 'verified')->count(),
            'rejected' => Applicant::where('status', 'rejected')->count(),
        ];
        
        return view('admin.dashboard', compact('applicants', 'quotas', 'stats'));
    }

    /**
     * ✅ KURANGI KUOTA SAAT VERIFIKASI
     */
    public function verify($id)
    {
        $applicant = Applicant::findOrFail($id);
        
        // Cek apakah sudah terverifikasi
        if ($applicant->status == 'verified') {
            return redirect()->back()->with('error', 'Pendaftaran sudah terverifikasi!');
        }
        
        // Cek kuota tersedia
        $registration = Registration::where('major', $applicant->major_choice)->first();
        
        if (!$registration) {
            return redirect()->back()->with('error', 'Jurusan tidak ditemukan!');
        }
        
        // Cek apakah kuota masih tersedia
        if ($registration->available_quota <= 0) {
            return redirect()->back()->with('error', 'Maaf, kuota untuk jurusan ' . $applicant->major_choice . ' sudah penuh!');
        }
        
        // ✅ KURANGI KUOTA DI SINI
        $registration->increment('used_quota');
        
        // Update status pendaftar menjadi verified
        $applicant->update([
            'status' => 'verified',
            'verified_at' => now()
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diverifikasi! Kuota telah dikurangi.');
    }

    /**
     * KEMBALIKAN KUOTA JIKA DITOLAK (jika sebelumnya verified)
     */
    public function reject($id)
    {
        $applicant = Applicant::findOrFail($id);
        
        // Jika sebelumnya sudah verified, kembalikan kuota
        if ($applicant->status == 'verified') {
            $registration = Registration::where('major', $applicant->major_choice)->first();
            if ($registration && $registration->used_quota > 0) {
                $registration->decrement('used_quota');
            }
        }
        
        // Update status menjadi rejected
        $applicant->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak!');
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
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $applicants = $query->latest()->paginate(20);
        $quotas = Registration::all();
        
        $stats = [
            'total' => Applicant::count(),
            'pending' => Applicant::where('status', 'pending')->count(),
            'verified' => Applicant::where('status', 'verified')->count(),
            'rejected' => Applicant::where('status', 'rejected')->count(),
        ];
        
        return view('admin.dashboard', compact('applicants', 'quotas', 'stats'))
            ->with('search', true);
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
        
        return view('admin.documents', compact('applicant', 'formattedDates', 'documents'));
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
        
        $filePath = storage_path('app/public/' . $fileMap[$type]);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }
        
        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    private function formatDate($date)
    {
        if (!$date) return '-';
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }
}