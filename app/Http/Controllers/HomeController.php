<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Applicant;
use App\Models\SmpRegistration;
use Illuminate\Http\Request;
use App\Models\SmpApplicant;

class HomeController extends Controller
{
    public function index()
    {
        $smkQuotas = Registration::all();
        $smpQuotas = SmpRegistration::all(); // Ambil data kuota untuk SMP

        $smpStats = [
            'total_applicants' => SmpApplicant::count(),
            'pending_applicants' => SmpApplicant::where('status', 'pending')->count(),
            'verified_applicants' => SmpApplicant::where('status', 'verified')->count(),
            'rejected_applicants' => SmpApplicant::where('status', 'rejected')->count(),
        ];
        // Hitung statistik dari tabel applicants langsung
        $smkStats = [
            'total_applicants' => Applicant::count(),
            'pending_applicants' => Applicant::where('status', 'pending')->count(),
            'verified_applicants' => Applicant::where('status', 'verified')->count(),
            'rejected_applicants' => Applicant::where('status', 'rejected')->count(),
        ];

        return view('home', compact('smkQuotas', 'smpQuotas', 'smkStats', 'smpStats'));
    }
    public function pengumuman()
    {
        // Ambil hanya siswa yang sudah diverifikasi (limit 100 terbaru)
        $verifiedStudents = Applicant::where('status', 'verified')
            ->orderBy('verified_at', 'desc')
            ->limit(700)
            ->get();

        return view('pengumuman', compact('verifiedStudents'));
    }

    // Cek status pendaftaran
    public function cekStatus(Request $request)
    {
        $request->validate([
            'registration_number' => 'required'
        ]);

        $applicant = Applicant::where('registration_number', $request->registration_number)->first();

        if (!$applicant) {
            return back()->with('error', 'Nomor pendaftaran tidak ditemukan. Pastikan nomor yang Anda masukkan benar.');
        }

        return view('cek-status', compact('applicant'));
    }
    public function about()
    {
        return view('about');
    }

    public function vision()
    {
        return view('vision');
    }

    public function contact()
    {
        return view('contact');
    }
}