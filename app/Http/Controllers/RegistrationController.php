<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon; // 👈 BARIS INI DITAMBAHKAN

class RegistrationController extends Controller
{
    /**
     * Konversi format tanggal dd/mm/yyyy ke yyyy-mm-dd
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
     * Format tanggal untuk ditampilkan (yyyy-mm-dd ke dd/mm/yyyy)
     */
    protected function formatDateForDisplay($date)
    {
        if (!$date) return '-';
        return Carbon::parse($date)->format('d/m/Y');
    }

    /**
     * Tampilkan form pendaftaran
     */
    public function showForm()
    {
        $quotas = Registration::all();

        // Format data kuota untuk ditampilkan
        $quotaInfo = $quotas->map(function($quota) {
            return [
                'major' => $quota->major,
                'quota' => $quota->quota,
                'used_quota' => $quota->used_quota,
                'available_quota' => $quota->available_quota,
                'percentage' => $quota->quota > 0 ? round(($quota->used_quota / $quota->quota) * 100, 1) : 0,
                'status' => $quota->available_quota <= 0 ? 'full' :
                           ($quota->available_quota <= 10 ? 'low' : 'available')
            ];
        });

        return view('registration.form', compact('quotaInfo'));
    }

    /**
     * Proses simpan data pendaftaran
     */
    public function store(Request $request)
    {
        // Validasi NIK yang sudah terdaftar
        $existingApplicant = Applicant::where('nik', $request->nik)->first();
        if ($existingApplicant) {
            return back()->with('error', 'NIK tersebut sudah terdaftar dalam sistem!')
                ->withInput();
        }

        // CEK KUOTA TERLEBIH DAHULU
        $registration = Registration::where('major', $request->major_choice)->first();
        if (!$registration) {
            return back()->with('error', 'Jurusan tidak ditemukan!')
                ->withInput();
        }

        // Tampilkan peringatan jika kuota hampir penuh, tapi tetap izinkan daftar
        if ($registration->available_quota <= 0) {
            return back()->with('error', 'Maaf, kuota untuk jurusan ' . $request->major_choice . ' sudah penuh. Silakan pilih jurusan lain.')
                ->withInput();
        }

        // Validasi data dan file upload
        $validated = $request->validate([
            'kk_area' => 'required|string|max:100',
            'kk_number' => 'required|digits:16',
            'nik' => 'required|digits:16|unique:applicants,nik',
            'nisn' => 'nullable|string|max:50',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|string',
            'religion' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'previous_school' => 'required|string|max:255',
            'major_choice' => 'required|string|max:255',
            'citizenship' => 'required|in:WNI,WNA',
            'birth_certificate_number' => 'required|string|max:100',
            'height' => 'required|integer|min:50|max:250',
            'weight' => 'required|integer|min:20|max:200',
            'head_circumference' => 'nullable|integer|min:30|max:80',
            'siblings_count' => 'required|integer|min:0',
            'child_order' => 'required|integer|min:1',
            'disability' => 'required|string|max:100',
            'parent_ktp_village' => 'required|string|max:255',
            'parent_ktp_rt' => 'required|string|max:10',
            'parent_ktp_rw' => 'required|string|max:10',
            'parent_ktp_subdistrict' => 'required|string|max:100',
            'parent_ktp_district' => 'required|string|max:100',
            'parent_ktp_city' => 'required|string|max:100',
            'parent_ktp_province' => 'required|string|max:100',
            'parent_ktp_residence_status' => 'required|string|max:100',
            'parent_ktp_distance_to_school' => 'required|string|max:100',
            'parent_ktp_transportation' => 'required|string|max:100',
            'current_village' => 'nullable|string|max:255',
            'current_rt' => 'nullable|string|max:10',
            'current_rw' => 'nullable|string|max:10',
            'current_subdistrict' => 'nullable|string|max:100',
            'current_district' => 'nullable|string|max:100',
            'current_city' => 'nullable|string|max:100',
            'current_province' => 'nullable|string|max:100',
            'current_residence_status' => 'nullable|string|max:100',
            'current_distance_to_school' => 'nullable|string|max:100',
            'current_transportation' => 'nullable|string|max:100',
            'father_nik' => 'required|digits:16',
            'father_name' => 'required|string|max:255',
            'father_birth_place' => 'required|string|max:100',
            'father_birth_date' => 'required|string',
            'father_education' => 'required|string|max:100',
            'father_occupation' => 'required|string|max:100',
            'father_income' => 'required|string|max:100',
            'father_phone' => 'required|string|max:20',
            'father_disability' => 'required|string|max:100',
            'mother_nik' => 'required|digits:16',
            'mother_name' => 'required|string|max:255',
            'mother_birth_place' => 'required|string|max:100',
            'mother_birth_date' => 'required|string',
            'mother_education' => 'required|string|max:100',
            'mother_occupation' => 'required|string|max:100',
            'mother_income' => 'required|string|max:100',
            'mother_phone' => 'required|string|max:20',
            'mother_disability' => 'required|string|max:100',
            'guardian_nik' => 'nullable|digits:16',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_birth_place' => 'nullable|string|max:100',
            'guardian_birth_date' => 'nullable|string',
            'guardian_education' => 'nullable|string|max:100',
            'guardian_occupation' => 'nullable|string|max:100',
            'guardian_income' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_disability' => 'nullable|string|max:100',
            'photo' => 'required|image|max:2048|mimes:jpeg,png,jpg',
            'kk_file' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'birth_certificate' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'mother_ktp' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'father_ktp' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'guardian_ktp' => 'nullable|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'diploma' => 'nullable|file|max:2048|mimes:pdf,jpeg,png,jpg',
            'report_card' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg',
        ]);

        // Validasi manual untuk tanggal
        $birthDate = $this->convertDateFormat($request->birth_date);
        $fatherBirthDate = $this->convertDateFormat($request->father_birth_date);
        $motherBirthDate = $this->convertDateFormat($request->mother_birth_date);
        $guardianBirthDate = $request->guardian_birth_date
            ? $this->convertDateFormat($request->guardian_birth_date)
            : null;

        if (!$birthDate || !$fatherBirthDate || !$motherBirthDate) {
            return back()->with('error', 'Format tanggal tidak valid! Gunakan format dd/mm/yyyy')
                ->withInput();
        }

        // Generate nomor pendaftaran unik
        $registrationNumber = 'YP-' . date('Y') . '-' . strtoupper(Str::random(6));

        // Simpan file upload
        $photoPath = $request->file('photo')->store('photos', 'public');
        $kkPath = $request->file('kk_file')->store('documents', 'public');
        $birthCertPath = $request->file('birth_certificate')->store('documents', 'public');
        $motherKtpPath = $request->file('mother_ktp')->store('documents', 'public');
        $fatherKtpPath = $request->file('father_ktp')->store('documents', 'public');
        $guardianKtpPath = $request->hasFile('guardian_ktp')
            ? $request->file('guardian_ktp')->store('documents', 'public') : null;
        $diplomaPath = $request->hasFile('diploma')
            ? $request->file('diploma')->store('documents', 'public') : null;
        $reportCardPath = $request->file('report_card')->store('documents', 'public');

        // Simpan data pendaftar dengan status PENDING dan buat akun User
        // ❌ JANGAN KURANGI KUOTA DI SINI
        $applicant = DB::transaction(function () use ($request, $birthDate, $fatherBirthDate, $motherBirthDate, $guardianBirthDate, $registrationNumber, $photoPath, $kkPath, $birthCertPath, $motherKtpPath, $fatherKtpPath, $guardianKtpPath, $diplomaPath, $reportCardPath) {
            
            $user = \App\Models\User::create([
                'name' => $request->full_name,
                'username' => $registrationNumber,
                'password' => \Illuminate\Support\Facades\Hash::make($request->nik),
                'role' => 'applicant',
            ]);

            return Applicant::create([
                'user_id' => $user->id,
                'registration_number' => $registrationNumber,
                'kk_area' => $request->kk_area,
                'kk_number' => $request->kk_number,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $birthDate,
            'religion' => $request->religion,
            'phone' => $request->phone,
            'email' => $request->email,
            'previous_school' => $request->previous_school,
            'major_choice' => $request->major_choice,
            'citizenship' => $request->citizenship,
            'birth_certificate_number' => $request->birth_certificate_number,
            'height' => $request->height,
            'weight' => $request->weight,
            'head_circumference' => $request->head_circumference,
            'siblings_count' => $request->siblings_count,
            'child_order' => $request->child_order,
            'disability' => $request->disability,
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
            'father_nik' => $request->father_nik,
            'father_name' => $request->father_name,
            'father_birth_place' => $request->father_birth_place,
            'father_birth_date' => $fatherBirthDate,
            'father_education' => $request->father_education,
            'father_occupation' => $request->father_occupation,
            'father_income' => $request->father_income,
            'father_phone' => $request->father_phone,
            'father_disability' => $request->father_disability,
            'mother_nik' => $request->mother_nik,
            'mother_name' => $request->mother_name,
            'mother_birth_place' => $request->mother_birth_place,
            'mother_birth_date' => $motherBirthDate,
            'mother_education' => $request->mother_education,
            'mother_occupation' => $request->mother_occupation,
            'mother_income' => $request->mother_income,
            'mother_phone' => $request->mother_phone,
            'mother_disability' => $request->mother_disability,
            'has_guardian' => $request->has('has_guardian'),
            'guardian_nik' => $request->guardian_nik ?? null,
            'guardian_name' => $request->guardian_name ?? null,
            'guardian_birth_place' => $request->guardian_birth_place ?? null,
            'guardian_birth_date' => $guardianBirthDate,
            'guardian_education' => $request->guardian_education ?? null,
            'guardian_occupation' => $request->guardian_occupation ?? null,
            'guardian_income' => $request->guardian_income ?? null,
            'guardian_phone' => $request->guardian_phone ?? null,
            'guardian_disability' => $request->guardian_disability ?? null,
            'photo_path' => $photoPath,
            'kk_path' => $kkPath,
            'birth_certificate_path' => $birthCertPath,
            'mother_ktp_path' => $motherKtpPath,
            'father_ktp_path' => $fatherKtpPath,
            'guardian_ktp_path' => $guardianKtpPath,
            'diploma_path' => $diplomaPath,
            'report_card_path' => $reportCardPath,
            'status' => 'pending' // Status pending, BELUM diverifikasi
        ]);
        });

        // ✅ KUOTA TIDAK DIKURANGI DI SINI
        // Kuota akan dikurangi saat admin melakukan verifikasi

        // Redirect ke halaman bukti pendaftaran
        return redirect()->route('registration.receipt', $applicant->id)
            ->with('success', 'Pendaftaran berhasil! Silakan simpan bukti pendaftaran Anda.');
    }

    /**
     * Tampilkan bukti pendaftaran
     */
    public function showReceipt($id)
    {
        $applicant = Applicant::findOrFail($id);

        // Format tanggal untuk ditampilkan
        $formattedDates = [
            'birth_date' => $this->formatDateForDisplay($applicant->birth_date),
            'father_birth_date' => $this->formatDateForDisplay($applicant->father_birth_date),
            'mother_birth_date' => $this->formatDateForDisplay($applicant->mother_birth_date),
            'guardian_birth_date' => $applicant->guardian_birth_date ? $this->formatDateForDisplay($applicant->guardian_birth_date) : '-',
        ];

        // Cek berkas yang kurang
        $missingDocuments = $this->checkMissingDocuments($applicant);

        $qrCode = QrCode::size(200)->generate($applicant->registration_number);

        return view('registration.receipt', compact('applicant', 'qrCode', 'formattedDates', 'missingDocuments'));
    }

    /**
     * Cek berkas yang kurang
     */
    protected function checkMissingDocuments($applicant)
    {
        $missing = [];

        // Dokumen wajib
        $requiredDocuments = [
            'photo_path' => 'Pas Foto Siswa',
            'kk_path' => 'Kartu Keluarga (KK)',
            'birth_certificate_path' => 'Akta Kelahiran',
            'mother_ktp_path' => 'KTP Ibu',
            'father_ktp_path' => 'KTP Ayah',
            'report_card_path' => 'Rapor Siswa'
        ];

        foreach ($requiredDocuments as $field => $label) {
            if (empty($applicant->{$field})) {
                $missing[] = $label;
            }
        }

        // Jika tidak memiliki wali, KTP wali opsional
        // Tapi jika memiliki wali, KTP wali wajib
        if ($applicant->has_guardian && empty($applicant->guardian_ktp_path)) {
            $missing[] = 'KTP Wali';
        }

        return $missing;
    }

    /**
     * Download bukti pendaftaran PDF
     */
    public function downloadReceiptPdf($id)
    {
        $applicant = Applicant::findOrFail($id);

        // Format tanggal untuk ditampilkan
        $formattedDates = [
            'birth_date' => $this->formatDateForDisplay($applicant->birth_date),
            'father_birth_date' => $this->formatDateForDisplay($applicant->father_birth_date),
            'mother_birth_date' => $this->formatDateForDisplay($applicant->mother_birth_date),
            'guardian_birth_date' => $applicant->guardian_birth_date ? $this->formatDateForDisplay($applicant->guardian_birth_date) : '-',
        ];

        // Cek berkas yang kurang
        $missingDocuments = $this->checkMissingDocuments($applicant);

        // Ubah format QR code untuk PDF (gunakan base64 agar tampil di dompdf)
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($applicant->registration_number));

        // Karena kita belum membuat receipt-pdf.blade.php khusus SMK, kita bisa gunakan yang sudah ada, tapi sebaiknya buat file baru jika receipt.blade.php terlalu berat.
        // Untuk amannya, kita load view registration.receipt-pdf jika sudah ada, atau buat on-the-fly.
        // Asumsi kita buat view 'registration.receipt-pdf'
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('registration.receipt-pdf', compact('applicant', 'qrCode', 'formattedDates', 'missingDocuments'));
        
        return $pdf->download('Bukti-Pendaftaran-' . $applicant->registration_number . '.pdf');
    }
}
