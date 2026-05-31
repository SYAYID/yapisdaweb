<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Cek apakah pendaftar SMK atau SMP
        $applicant = $user->applicant ?? $user->smpApplicant;

        if (!$applicant) {
            return redirect()->route('home')->with('error', 'Data pendaftar tidak ditemukan pada akun ini.');
        }

        $type = $user->applicant ? 'smk' : 'smp';

        return view('student.dashboard', compact('applicant', 'type'));
    }
}
