<?php

namespace Tests\Feature;

use App\Models\Applicant;
use App\Models\PaymentTransaction;
use App\Models\PaymentType;
use App\Models\Registration;
use App\Models\SmpApplicant;
use App\Models\SmpRegistration;
use App\Models\UniformProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected int $studentSequence = 1;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_smk_admin_dashboard_returns_a_successful_response(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smk']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin');
        $response->assertSee('admin-shell');
        $response->assertSee('admin-sidebar');
        $response->assertSee('Data Pendaftar');
        $response->assertSee('Peta Kerja Hari Ini');
        $response->assertSee('Akses Cepat');
        $response->assertSee('Aktivitas Terbaru');
        $response->assertSee('/admin/analytics');
        $response->assertSee('/admin/quotas');
        $response->assertSee('/admin/applicants');
        $response->assertDontSee('Tren Pendaftaran');
        $response->assertDontSee('Waktu Daftar');
        $response->assertSee('Cetak Halaman');
        $response->assertSee('adminPrintRoot');
    }

    public function test_smk_admin_sections_are_real_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smk']);

        $this->actingAs($admin)->get('/admin/analytics')
            ->assertOk()
            ->assertSee('Heatmap Waktu Pendaftaran')
            ->assertSee('Tren Pendaftaran');

        $this->actingAs($admin)->get('/admin/quotas')
            ->assertOk()
            ->assertSee('Kuota Pendaftaran per Jurusan')
            ->assertSee('Statistik Verifikasi per Jurusan');

        $this->actingAs($admin)->get('/admin/applicants')
            ->assertOk()
            ->assertSee('Data Pendaftar')
            ->assertSee('Waktu Daftar');
    }

    public function test_smp_admin_dashboard_returns_a_successful_response(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smp']);

        $response = $this->actingAs($admin)->get('/admin/smp/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin SMPS');
        $response->assertSee('admin-shell');
        $response->assertSee('admin-sidebar');
        $response->assertSee('Data Pendaftar');
        $response->assertSee('Peta Kerja Hari Ini');
        $response->assertSee('Akses Cepat');
        $response->assertSee('Aktivitas Terbaru');
        $response->assertSee('/admin/smp/analytics');
        $response->assertSee('/admin/smp/quotas');
        $response->assertSee('/admin/smp/applicants');
        $response->assertDontSee('Tren Pendaftaran');
        $response->assertDontSee('Waktu Daftar');
        $response->assertSee('Cetak Halaman');
        $response->assertSee('adminPrintRoot');
    }

    public function test_smp_admin_sections_are_real_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smp']);

        $this->actingAs($admin)->get('/admin/smp/analytics')
            ->assertOk()
            ->assertSee('Heatmap Waktu Pendaftaran')
            ->assertSee('Tren Pendaftaran');

        $this->actingAs($admin)->get('/admin/smp/quotas')
            ->assertOk()
            ->assertSee('Kuota Pendaftaran per Program Sekolah');

        $this->actingAs($admin)->get('/admin/smp/applicants')
            ->assertOk()
            ->assertSee('Data Pendaftar')
            ->assertSee('Waktu Daftar');
    }

    public function test_finance_dashboard_returns_a_successful_response(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);

        $response = $this->actingAs($finance)->get('/admin/finance/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Keuangan');
        $response->assertSee('Uang Seragam');
        $response->assertSee('Mutasi Kas');
        $response->assertSee('Pusat Tindakan Keuangan');
        $response->assertSee('Progres Uang Seragam');
        $response->assertSee('Mutasi Terbaru');
        $response->assertSee('admin-sidebar');
        $response->assertDontSee('Simpan Transaksi');
        $response->assertDontSee('Jenis Pembayaran Baru');
        $response->assertSee('Cetak Halaman');
        $response->assertSee('adminPrintRoot');
    }

    public function test_finance_sections_are_real_pages(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);

        $this->actingAs($finance)->get('/admin/finance/transactions/create')
            ->assertOk()
            ->assertSee('Catat Transaksi')
            ->assertSee('Simpan Transaksi');

        $this->actingAs($finance)->get('/admin/finance/uniform-report')
            ->assertOk()
            ->assertSee('Laporan Uang Seragam');

        $this->actingAs($finance)->get('/admin/finance/daily-report')
            ->assertOk()
            ->assertSee('Laporan Harian');

        $this->actingAs($finance)->get('/admin/finance/mutations')
            ->assertOk()
            ->assertSee('Mutasi Kas')
            ->assertSee('Cari Mutasi');

        $this->actingAs($finance)->get('/admin/finance/payment-types')
            ->assertOk()
            ->assertSee('Jenis Pembayaran Baru');

        $this->actingAs($finance)->get('/admin/finance/final-progress')
            ->assertOk()
            ->assertSee('Dashboard Progress Final')
            ->assertSee('Perlu Ditindaklanjuti');

        $this->actingAs($finance)->get('/admin/finance/uniform-sizes')
            ->assertOk()
            ->assertSee('Manajemen Ukuran Seragam')
            ->assertSee('Ketik nama, NIS, atau nomor pendaftaran siswa')
            ->assertSee('Simpan Ukuran Seragam');
    }

    public function test_smp_registration_form_returns_a_successful_response(): void
    {
        $response = $this->get('/smp-registration');

        $response->assertStatus(200);
        $response->assertSee('Formulir Pendaftaran SMPS');
        $response->assertSee('smp-registration-page');
    }

    public function test_finance_can_create_payment_type_and_transaction(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);

        $this->actingAs($finance)->post('/admin/finance/payment-types', [
            'name' => 'Pembelian ATK',
            'code' => 'ATK',
            'description' => 'Pengeluaran alat tulis kantor.',
            'default_amount' => 250000,
            'direction' => 'outcome',
            'is_active' => 1,
        ])->assertRedirect();

        $this->assertDatabaseHas('payment_types', [
            'code' => 'ATK',
            'direction' => 'outcome',
            'default_amount' => 250000,
        ]);

        $paymentTypeId = \App\Models\PaymentType::where('code', 'ATK')->value('id');

        $this->actingAs($finance)->post('/admin/finance/transactions', [
            'payment_type_id' => $paymentTypeId,
            'direction' => 'outcome',
            'amount' => 250000,
            'payment_method' => 'cash',
            'paid_at' => now()->format('Y-m-d H:i:s'),
            'description' => 'Pembelian ATK loket pendaftaran.',
        ])->assertRedirect();

        $this->assertDatabaseHas('payment_transactions', [
            'payment_type_id' => $paymentTypeId,
            'direction' => 'outcome',
            'amount' => 250000,
            'created_by_user_id' => $finance->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'finance.payment_type_created',
            'subject_label' => 'ATK',
        ]);
    }

    public function test_finance_student_search_only_returns_verified_students(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $verified = $this->makeSmkApplicant([
            'registration_number' => 'SMK-VER-001',
            'full_name' => 'Ahmad Verified',
            'status' => 'verified',
        ]);
        foreach (range(1, 16) as $index) {
            $this->makeSmkApplicant([
                'registration_number' => 'SMK-VER-BULK-' . str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                'full_name' => 'Ahmad Verified Bulk ' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'status' => 'verified',
            ]);
        }

        $this->makeSmkApplicant([
            'registration_number' => 'SMK-PEN-001',
            'full_name' => 'Ahmad Pending',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($finance)->getJson('/admin/finance/students/search?q=Ahmad');

        $response->assertOk();
        $this->assertCount(17, $response->json());
        $response->assertJsonFragment([
            'key' => 'smk:' . $verified->id,
            'name' => 'Ahmad Verified',
        ]);
        $response->assertJsonMissing([
            'name' => 'Ahmad Pending',
        ]);
    }

    public function test_finance_uniform_report_shows_all_verified_students(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);

        foreach (range(1, 25) as $index) {
            $this->makeSmkApplicant([
                'registration_number' => 'SMK-ROW-' . str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                'full_name' => 'Siswa Laporan Seragam ' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'status' => 'verified',
            ]);
        }

        $response = $this->actingAs($finance)->get('/admin/finance/uniform-report');

        $response->assertOk();
        $response->assertSee('25 dari 25 siswa verified');
        $response->assertSee('SMK-ROW-001');
        $response->assertSee('SMK-ROW-025');
    }

    public function test_finance_can_print_student_card_after_verified_payment(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-CARD-001',
            'full_name' => 'Siswa Cetak Kartu',
            'major_choice' => 'Teknik Komputer dan Jaringan',
            'status' => 'verified',
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        $transaction = PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-CARD-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/student-card/' . $transaction->id);
        $student->refresh();

        $response->assertOk();
        $response->assertSee('Kartu Siswa');
        $response->assertSee('Siswa Cetak Kartu');
        $response->assertSee('Teknik Komputer dan Jaringan');
        $response->assertSee($student->student_identification_number);
        $response->assertSee('Siswa Aktif');
        $response->assertDontSee('No. Pendaftaran');
        $response->assertDontSee('Seragam Lunas');
        $response->assertDontSee('TRX-CARD-001');
    }

    public function test_uniform_payment_generates_student_identification_number_and_audit_log(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-NIS-001',
            'full_name' => 'Siswa Nomor Induk',
            'major_choice' => 'Teknik Komputer dan Jaringan',
            'status' => 'verified',
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);

        $this->actingAs($finance)->post('/admin/finance/transactions', [
            'payment_type_id' => $paymentType->id,
            'amount' => 1000000,
            'student_key' => 'smk:' . $student->id,
            'payment_method' => 'cash',
            'paid_at' => now()->format('Y-m-d H:i:s'),
            'reference_number' => 'TRX-NIS-001',
            'description' => 'Pelunasan uang seragam.',
        ])->assertRedirect();

        $prefix = now('Asia/Jakarta')->format('y') . now('Asia/Jakarta')->copy()->addYear()->format('y') . '04';
        $student->refresh();

        $this->assertSame($prefix . '001', $student->student_identification_number);
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'finance.student_number_assigned',
        ]);
    }

    public function test_student_card_can_print_after_income_even_when_uniform_is_not_fully_paid(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-CARD-PENDING-001',
            'full_name' => 'Siswa Belum Lunas Kartu',
            'status' => 'verified',
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        $transaction = PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 500000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-CARD-PENDING-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/student-card/' . $transaction->id);
        $student->refresh();

        $response->assertOk();
        $response->assertSee('Kartu Siswa');
        $response->assertSee('Siswa Belum Lunas Kartu');
        $response->assertSee($student->student_identification_number);
    }

    public function test_finance_can_print_official_payment_receipt(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-RECEIPT-001',
            'full_name' => 'Siswa Kwitansi',
            'status' => 'verified',
            'student_identification_number' => '262704002',
            'student_identification_assigned_at' => now(),
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        $transaction = PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-RECEIPT-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/receipt/' . $transaction->id);

        $response->assertOk();
        $response->assertSee('Kwitansi Pembayaran');
        $response->assertSee('TRX-RECEIPT-001');
        $response->assertSee('262704002');
        $response->assertSee('Rp 1.000.000');
    }

    public function test_finance_final_reenrollment_report_lists_paid_students(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-FINAL-001',
            'full_name' => 'Siswa Final',
            'major_choice' => 'Akuntansi',
            'status' => 'verified',
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-FINAL-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/final-report');
        $student->refresh();

        $response->assertOk();
        $response->assertSee('Laporan Daftar Ulang Final');
        $response->assertSee('Siswa Final');
        $response->assertSee($student->student_identification_number);
    }

    public function test_finance_can_manage_uniform_size_profile(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-UNIFORM-001',
            'full_name' => 'Siswa Ukuran Seragam',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($finance)->post('/admin/finance/uniform-sizes', [
            'student_key' => 'smk:' . $student->id,
            'shirt_size' => 'XL',
            'pants_size' => '30',
            'attribute_status' => 'prepared',
            'notes' => 'Atribut disiapkan gelombang pertama.',
        ]);

        $response->assertRedirect('/admin/finance/uniform-sizes');
        $this->assertDatabaseHas('uniform_profiles', [
            'student_type' => 'smk',
            'student_id' => $student->id,
            'shirt_size' => 'XL',
            'attribute_status' => 'prepared',
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'finance.uniform_profile_saved',
        ]);
    }

    public function test_finance_can_print_student_letter_template(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-LETTER-001',
            'full_name' => 'Siswa Surat Otomatis',
            'status' => 'verified',
        ]);

        UniformProfile::create([
            'student_type' => 'smk',
            'student_id' => $student->id,
            'shirt_size' => 'L',
            'attribute_status' => 'recorded',
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/letters/smk/' . $student->id . '/accepted');

        $response->assertOk();
        $response->assertSee('Surat Keterangan Diterima');
        $response->assertSee('Siswa Surat Otomatis');
        $response->assertSee('SMK-LETTER-001');
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'finance.student_letter_printed',
        ]);
    }

    public function test_finance_can_view_audit_logs(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);

        \App\Models\AuditLog::create([
            'user_id' => $finance->id,
            'user_name' => $finance->name,
            'user_role' => $finance->role,
            'event' => 'finance.transaction_created',
            'subject_label' => 'TRX-AUDIT-001',
            'description' => 'Transaksi test audit.',
            'occurred_at' => now(),
        ]);

        $response = $this->actingAs($finance)->get('/admin/finance/audit-logs');

        $response->assertOk();
        $response->assertSee('Audit Log Sistem');
        $response->assertSee('TRX-AUDIT-001');
    }

    public function test_paid_applicants_api_requires_token(): void
    {
        config(['services.yapisda_api.token' => 'secret-token']);

        $this->getJson('/api/paid-applicants')
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Token API tidak valid.',
            ]);
    }

    public function test_paid_applicants_api_returns_confirmed_uniform_payments(): void
    {
        config(['services.yapisda_api.token' => 'secret-token']);

        $finance = User::factory()->create(['role' => 'finance']);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        $paidStudent = $this->makeSmkApplicant([
            'registration_number' => 'SMK-API-PAID-001',
            'full_name' => 'Siswa API Lunas',
            'status' => 'verified',
        ]);
        $partialStudent = $this->makeSmpApplicant([
            'registration_number' => 'SMP-API-PARTIAL-001',
            'full_name' => 'Siswa API Parsial',
            'status' => 'verified',
        ]);
        $this->makeSmkApplicant([
            'registration_number' => 'SMK-API-UNPAID-001',
            'full_name' => 'Siswa API Belum Bayar',
            'status' => 'verified',
        ]);

        PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $paidStudent->id,
            'payment_method' => 'transfer',
            'reference_number' => 'TRX-API-PAID-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);
        PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 500000,
            'student_type' => 'smp',
            'smp_applicant_id' => $partialStudent->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-API-PARTIAL-001',
            'status' => 'confirmed',
            'paid_at' => now()->subDay(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this
            ->withHeader('Authorization', 'Bearer secret-token')
            ->getJson('/api/paid-applicants?include_transactions=1&per_page=all');

        $response->assertOk();
        $response->assertJsonPath('meta.total', 2);
        $response->assertJsonFragment([
            'registration_number' => 'SMK-API-PAID-001',
            'full_name' => 'Siswa API Lunas',
        ]);
        $response->assertJsonFragment([
            'registration_number' => 'SMP-API-PARTIAL-001',
            'full_name' => 'Siswa API Parsial',
        ]);
        $response->assertJsonMissing([
            'registration_number' => 'SMK-API-UNPAID-001',
        ]);
        $response->assertJsonFragment([
            'reference_number' => 'TRX-API-PAID-001',
            'amount' => 1000000,
        ]);

        $paidOnly = $this
            ->withHeader('X-API-KEY', 'secret-token')
            ->getJson('/api/pendaftar-sudah-bayar?payment_status=paid&per_page=all');

        $paidOnly->assertOk();
        $paidOnly->assertJsonPath('meta.total', 1);
        $paidOnly->assertJsonFragment([
            'registration_number' => 'SMK-API-PAID-001',
        ]);
        $paidOnly->assertJsonMissing([
            'registration_number' => 'SMP-API-PARTIAL-001',
        ]);

        $privateResponse = $this
            ->withHeader('Authorization', 'Bearer secret-token')
            ->getJson('/api/paid-applicants?search=SMK-API-PAID-001&include_private=1&per_page=all');

        $privateResponse->assertOk();
        $privateResponse->assertJsonPath('data.0.private_data.identity.kk_number', '1234567890123456');
        $privateResponse->assertJsonPath('data.0.private_data.identity.nik', $paidStudent->nik);
        $privateResponse->assertJsonPath('data.0.private_data.parents.father.name', 'Ayah Test');
        $privateResponse->assertJsonPath('data.0.private_data.parents.mother.name', 'Ibu Test');
        $privateResponse->assertJsonPath('data.0.private_data.documents.photo.path', 'photos/test.jpg');
    }

    public function test_operations_can_sync_active_students_from_completed_reenrollment(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-ACTIVE-001',
            'full_name' => 'Siswa Aktif Operasional',
            'student_identification_number' => '262704099',
            'student_identification_assigned_at' => now(),
            'status' => 'verified',
        ]);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-ACTIVE-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $admin->id,
        ]);

        $this->actingAs($admin, 'operations')->post('/admin/operations/active-students/sync')
            ->assertRedirect();

        $this->assertDatabaseHas('active_students', [
            'student_type' => 'smk',
            'student_id' => $student->id,
            'full_name' => 'Siswa Aktif Operasional',
            'student_identification_number' => '262704099',
        ]);

        $response = $this->actingAs($admin, 'operations')->get('/admin/operations/active-students');

        $response->assertOk();
        $response->assertSee('Master Data Siswa Aktif');
        $response->assertSee('Siswa Aktif Operasional');
    }

    public function test_operations_can_manage_uniform_stock_and_final_checklist(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-CHECKLIST-001',
            'full_name' => 'Siswa Checklist Final',
            'status' => 'verified',
        ]);

        $this->actingAs($admin, 'operations')->post('/admin/operations/uniform-stock', [
            'name' => 'Baju Praktik',
            'category' => 'shirt',
            'size' => 'L',
            'unit' => 'pcs',
            'stock_qty' => 30,
            'reserved_qty' => 5,
            'distributed_qty' => 2,
            'minimum_qty' => 10,
            'notes' => 'Stok awal gelombang pertama.',
        ])->assertRedirect();

        $this->assertDatabaseHas('uniform_stock_items', [
            'name' => 'Baju Praktik',
            'category' => 'shirt',
            'size' => 'L',
            'stock_qty' => 30,
        ]);

        $this->actingAs($admin, 'operations')->patch('/admin/operations/final-checklist/smk/' . $student->id, [
            'final_status' => 'blocked',
            'notes' => 'Menunggu kelengkapan arsip.',
        ])->assertRedirect();

        $this->assertDatabaseHas('student_final_checklists', [
            'student_type' => 'smk',
            'student_id' => $student->id,
            'final_status' => 'blocked',
            'notes' => 'Menunggu kelengkapan arsip.',
        ]);
    }

    public function test_operations_export_archive_health_and_backup_pages_work(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create(['role' => 'super_admin']);
        $this->makeSmkApplicant([
            'registration_number' => 'SMK-OPS-001',
            'full_name' => 'Siswa Operasional Arsip',
            'status' => 'verified',
        ]);

        $this->actingAs($admin, 'operations')->get('/admin/operations/dashboard')
            ->assertOk()
            ->assertSee('Dashboard Operasional');

        $this->actingAs($admin, 'operations')->get('/admin/operations/official-exports')
            ->assertOk()
            ->assertSee('Export Data Resmi')
            ->assertSee('Master Data Siswa Aktif');

        $this->actingAs($admin, 'operations')->get('/admin/operations/official-exports/document-archive')
            ->assertOk()
            ->assertHeader('content-disposition');

        $this->actingAs($admin, 'operations')->get('/admin/operations/archive-center')
            ->assertOk()
            ->assertSee('Pusat Arsip Dokumen')
            ->assertSee('Siswa Operasional Arsip');

        $this->actingAs($admin, 'operations')->post('/admin/operations/backups')
            ->assertRedirect();

        $this->assertDatabaseCount('backup_snapshots', 1);

        $this->actingAs($admin, 'operations')->get('/admin/operations/health')
            ->assertOk()
            ->assertSee('Health Check Sistem')
            ->assertSee('Backup Operasional');
    }

    public function test_admin_finance_and_operations_can_stay_logged_in_together(): void
    {
        $smkAdmin = User::factory()->create([
            'email' => 'smk-multi@example.test',
            'role' => 'admin_smk',
        ]);
        $finance = User::factory()->create([
            'email' => 'finance-multi@example.test',
            'role' => 'finance',
        ]);
        $yayasan = User::factory()->create([
            'email' => 'yayasan-multi@example.test',
            'role' => 'yayasan',
        ]);

        $this->post('/admin/login', [
            'username' => $smkAdmin->email,
            'password' => 'password',
        ])->assertRedirect('/admin/dashboard');

        $this->post('/admin/finance/login', [
            'username' => $finance->email,
            'password' => 'password',
        ])->assertRedirect('/admin/finance/dashboard');

        $this->post('/admin/operations/login', [
            'username' => $yayasan->email,
            'password' => 'password',
        ])->assertRedirect('/admin/operations/executive-dashboard');

        $this->get('/admin/dashboard')->assertOk()->assertSee('Dashboard Admin');
        $this->get('/admin/finance/dashboard')->assertOk()->assertSee('Dashboard Keuangan');
        $this->get('/admin/operations/executive-dashboard')->assertOk()->assertSee('Dashboard Kepala Sekolah/Yayasan');

        $this->get('/admin/operations/logout')->assertRedirect('/admin/operations/login');

        $this->get('/admin/dashboard')->assertOk()->assertSee('Dashboard Admin');
        $this->get('/admin/finance/dashboard')->assertOk()->assertSee('Dashboard Keuangan');
        $this->get('/admin/operations/dashboard')->assertRedirect('/admin/operations/login');
    }

    public function test_smk_admin_can_add_follow_up_note_to_applicant(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smk']);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-NOTE-001',
            'full_name' => 'Siswa Catatan SMK',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)->post('/admin/activities/' . $student->id, [
            'category' => 'document',
            'body' => 'Rapor perlu diupload ulang dengan halaman nilai yang lengkap.',
            'follow_up_at' => now()->addDay()->format('Y-m-d\TH:i'),
            'is_pinned' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('applicant_activities', [
            'applicant_type' => 'smk',
            'applicant_id' => $student->id,
            'user_id' => $admin->id,
            'category' => 'document',
            'body' => 'Rapor perlu diupload ulang dengan halaman nilai yang lengkap.',
            'is_pinned' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/documents/' . $student->id);

        $response->assertOk();
        $response->assertSee('Catatan Tindak Lanjut');
        $response->assertSee('Rapor perlu diupload ulang');
    }

    public function test_smk_admin_can_change_verified_applicant_back_to_pending(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smk']);
        $registration = Registration::create([
            'major' => 'Teknik Komputer dan Jaringan',
            'quota' => 10,
            'used_quota' => 1,
        ]);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-STATUS-001',
            'full_name' => 'Siswa Koreksi Status',
            'major_choice' => 'Teknik Komputer dan Jaringan',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->patch('/admin/status/' . $student->id, [
            'status' => 'pending',
            'note' => 'Menunggu konfirmasi administrasi atribut.',
        ]);

        $response->assertRedirect();
        $student->refresh();

        $this->assertSame('pending', $student->status);
        $this->assertNull($student->verified_at);
        $this->assertSame(0, $registration->fresh()->used_quota);
        $this->assertDatabaseHas('applicant_activities', [
            'applicant_type' => 'smk',
            'applicant_id' => $student->id,
            'category' => 'status',
            'title' => 'Status pendaftaran diperbarui',
        ]);
    }

    public function test_smp_admin_can_change_verified_applicant_back_to_pending(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smp']);
        $registration = SmpRegistration::create([
            'school_program' => 'Sekolah Umum',
            'quota' => 10,
            'used_quota' => 1,
        ]);
        $student = $this->makeSmpApplicant([
            'registration_number' => 'SMP-STATUS-001',
            'full_name' => 'Siswa SMP Koreksi Status',
            'school_program' => 'Sekolah Umum',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->patch('/admin/smp/status/' . $student->id, [
            'status' => 'pending',
            'note' => 'Menunggu konfirmasi administrasi atribut.',
        ]);

        $response->assertRedirect();
        $student->refresh();

        $this->assertSame('pending', $student->status);
        $this->assertNull($student->verified_at);
        $this->assertSame(0, $registration->fresh()->used_quota);
        $this->assertDatabaseHas('applicant_activities', [
            'applicant_type' => 'smp',
            'applicant_id' => $student->id,
            'category' => 'status',
            'title' => 'Status pendaftaran diperbarui',
        ]);
    }

    public function test_public_receipt_shows_registration_time_in_wib(): void
    {
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-TIME-001',
            'full_name' => 'Siswa Jam Registrasi',
            'created_at' => now('Asia/Jakarta')->setTime(9, 25),
        ]);

        $response = $this->get('/registration/receipt/' . $student->id);

        $response->assertOk();
        $response->assertSee('Waktu Registrasi');
        $response->assertSee($student->fresh()->registered_at_label);
    }

    public function test_public_reenrollment_status_page_returns_successfully(): void
    {
        $response = $this->get('/status-daftar-ulang');

        $response->assertOk();
        $response->assertSee('Status Daftar Ulang');
        $response->assertSee('Status resmi peserta didik mengikuti kelengkapan administrasi daftar ulang.');
    }

    public function test_verified_applicant_without_uniform_payment_is_not_active_student_yet(): void
    {
        PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);

        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-REENROLL-001',
            'full_name' => 'Siswa Perlu Konfirmasi',
            'status' => 'verified',
        ]);

        $response = $this->get('/status-daftar-ulang?q=' . $student->registration_number);

        $response->assertOk();
        $response->assertSee('Siswa Perlu Konfirmasi');
        $response->assertSee('Administrasi daftar ulang belum lengkap');
        $response->assertSee('Hubungi Panitia');
        $response->assertSee('Datang Langsung Ke Sekolah');
        $response->assertDontSee('Administrasi daftar ulang lengkap');
    }

    public function test_verified_applicant_with_uniform_payment_is_active_student(): void
    {
        $finance = User::factory()->create(['role' => 'finance']);
        $paymentType = PaymentType::create([
            'name' => 'Uang Seragam',
            'code' => 'SERAGAM',
            'description' => 'Pembayaran wajib seragam siswa.',
            'default_amount' => 1000000,
            'direction' => 'income',
            'is_active' => true,
        ]);
        $student = $this->makeSmkApplicant([
            'registration_number' => 'SMK-REENROLL-002',
            'full_name' => 'Siswa Administrasi Lengkap',
            'status' => 'verified',
        ]);

        PaymentTransaction::create([
            'payment_type_id' => $paymentType->id,
            'direction' => 'income',
            'amount' => 1000000,
            'student_type' => 'smk',
            'applicant_id' => $student->id,
            'payment_method' => 'cash',
            'reference_number' => 'TRX-REENROLL-001',
            'status' => 'confirmed',
            'paid_at' => now(),
            'created_by_user_id' => $finance->id,
        ]);

        $response = $this->get('/status-daftar-ulang?q=' . $student->registration_number);

        $response->assertOk();
        $response->assertSee('Siswa Administrasi Lengkap');
        $response->assertSee('Administrasi daftar ulang lengkap');
        $response->assertDontSee('Hubungi Panitia');
        $response->assertDontSee('Opsi Tindak Lanjut:');
    }

    public function test_smp_admin_can_add_follow_up_note_to_applicant(): void
    {
        $admin = User::factory()->create(['role' => 'admin_smp']);
        $student = $this->makeSmpApplicant([
            'registration_number' => 'SMP-NOTE-001',
            'full_name' => 'Siswa Catatan SMP',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)->post('/admin/smp/activities/' . $student->id, [
            'category' => 'phone',
            'body' => 'Orang tua sudah dihubungi untuk melengkapi berkas KK.',
        ])->assertRedirect();

        $this->assertDatabaseHas('applicant_activities', [
            'applicant_type' => 'smp',
            'applicant_id' => $student->id,
            'user_id' => $admin->id,
            'category' => 'phone',
            'body' => 'Orang tua sudah dihubungi untuk melengkapi berkas KK.',
        ]);

        $response = $this->actingAs($admin)->get('/admin/smp/documents/' . $student->id);

        $response->assertOk();
        $response->assertSee('Timeline Aktivitas');
        $response->assertSee('Orang tua sudah dihubungi');
    }

    private function makeSmkApplicant(array $overrides = []): Applicant
    {
        $sequence = $this->studentSequence++;

        return Applicant::create(array_merge([
            'registration_number' => 'SMK-TEST-' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT),
            'kk_area' => 'Dalam Banten',
            'kk_number' => '1234567890123456',
            'nik' => str_pad((string) (9000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'nisn' => 'NISN' . $sequence,
            'full_name' => 'Siswa Test ' . $sequence,
            'gender' => 'Laki-laki',
            'birth_place' => 'Serang',
            'birth_date' => '2010-01-01',
            'religion' => 'Islam',
            'phone' => '081234567' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT),
            'email' => 'student' . $sequence . '@example.test',
            'previous_school' => 'SMP Asal',
            'major_choice' => 'Teknik Komputer dan Jaringan',
            'citizenship' => 'WNI',
            'birth_certificate_number' => 'AKTA-' . $sequence,
            'height' => 165,
            'weight' => 55,
            'head_circumference' => 52,
            'siblings_count' => 2,
            'child_order' => 1,
            'disability' => 'Tidak Ada',
            'parent_ktp_village' => 'Desa Test',
            'parent_ktp_rt' => '001',
            'parent_ktp_rw' => '002',
            'parent_ktp_subdistrict' => 'Kecamatan Test',
            'parent_ktp_district' => 'Kabupaten Test',
            'parent_ktp_city' => 'Kota Test',
            'parent_ktp_province' => 'Banten',
            'parent_ktp_residence_status' => 'Milik Sendiri',
            'parent_ktp_distance_to_school' => '5 km',
            'parent_ktp_transportation' => 'Motor',
            'same_as_ktp' => true,
            'current_village' => 'Desa Test',
            'current_rt' => '001',
            'current_rw' => '002',
            'current_subdistrict' => 'Kecamatan Test',
            'current_district' => 'Kabupaten Test',
            'current_city' => 'Kota Test',
            'current_province' => 'Banten',
            'current_residence_status' => 'Milik Sendiri',
            'current_distance_to_school' => '5 km',
            'current_transportation' => 'Motor',
            'father_nik' => str_pad((string) (8000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'father_name' => 'Ayah Test',
            'father_birth_place' => 'Serang',
            'father_birth_date' => '1980-01-01',
            'father_education' => 'SMA',
            'father_occupation' => 'Wiraswasta',
            'father_income' => '3000000',
            'father_phone' => '0811111111',
            'father_disability' => 'Tidak Ada',
            'mother_nik' => str_pad((string) (7000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'mother_name' => 'Ibu Test',
            'mother_birth_place' => 'Serang',
            'mother_birth_date' => '1982-01-01',
            'mother_education' => 'SMA',
            'mother_occupation' => 'Ibu Rumah Tangga',
            'mother_income' => '0',
            'mother_phone' => '0822222222',
            'mother_disability' => 'Tidak Ada',
            'has_guardian' => false,
            'guardian_nik' => null,
            'guardian_name' => null,
            'guardian_birth_place' => null,
            'guardian_birth_date' => null,
            'guardian_education' => null,
            'guardian_occupation' => null,
            'guardian_income' => null,
            'guardian_phone' => null,
            'guardian_disability' => null,
            'photo_path' => 'photos/test.jpg',
            'kk_path' => 'documents/kk.pdf',
            'birth_certificate_path' => 'documents/akta.pdf',
            'mother_ktp_path' => 'documents/ktp-ibu.pdf',
            'father_ktp_path' => 'documents/ktp-ayah.pdf',
            'guardian_ktp_path' => null,
            'diploma_path' => null,
            'report_card_path' => 'documents/rapor.pdf',
            'status' => 'verified',
            'verified_at' => now(),
        ], $overrides));
    }

    private function makeSmpApplicant(array $overrides = []): SmpApplicant
    {
        $sequence = $this->studentSequence++;

        return SmpApplicant::create(array_merge([
            'registration_number' => 'SMP-TEST-' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT),
            'kk_area' => 'Dalam Banten',
            'kk_number' => '2234567890123456',
            'nik' => str_pad((string) (6000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'nisn' => 'SMPNISN' . $sequence,
            'full_name' => 'Siswa SMP Test ' . $sequence,
            'gender' => 'Laki-laki',
            'birth_place' => 'Tangerang',
            'birth_date' => '2011-01-01',
            'religion' => 'Islam',
            'phone' => '081345678' . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT),
            'email' => 'smpstudent' . $sequence . '@example.test',
            'previous_school' => 'SD Asal',
            'school_program' => 'Sekolah Umum',
            'citizenship' => 'WNI',
            'birth_certificate_number' => 'SMP-AKTA-' . $sequence,
            'height' => 150,
            'weight' => 45,
            'head_circumference' => 50,
            'siblings_count' => 2,
            'child_order' => 1,
            'disability' => 'Tidak Ada',
            'parent_ktp_village' => 'Desa Test',
            'parent_ktp_rt' => '001',
            'parent_ktp_rw' => '002',
            'parent_ktp_subdistrict' => 'Kecamatan Test',
            'parent_ktp_district' => 'Kabupaten Test',
            'parent_ktp_city' => 'Kota Test',
            'parent_ktp_province' => 'Banten',
            'parent_ktp_residence_status' => 'Milik Sendiri',
            'parent_ktp_distance_to_school' => '5 km',
            'parent_ktp_transportation' => 'Motor',
            'same_as_ktp' => true,
            'current_village' => 'Desa Test',
            'current_rt' => '001',
            'current_rw' => '002',
            'current_subdistrict' => 'Kecamatan Test',
            'current_district' => 'Kabupaten Test',
            'current_city' => 'Kota Test',
            'current_province' => 'Banten',
            'current_residence_status' => 'Milik Sendiri',
            'current_distance_to_school' => '5 km',
            'current_transportation' => 'Motor',
            'father_nik' => str_pad((string) (5000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'father_name' => 'Ayah SMP Test',
            'father_birth_place' => 'Tangerang',
            'father_birth_date' => '1980-01-01',
            'father_education' => 'SMA',
            'father_occupation' => 'Wiraswasta',
            'father_income' => '3000000',
            'father_phone' => '0811111111',
            'father_disability' => 'Tidak Ada',
            'mother_nik' => str_pad((string) (4000000000000000 + $sequence), 16, '0', STR_PAD_LEFT),
            'mother_name' => 'Ibu SMP Test',
            'mother_birth_place' => 'Tangerang',
            'mother_birth_date' => '1982-01-01',
            'mother_education' => 'SMA',
            'mother_occupation' => 'Ibu Rumah Tangga',
            'mother_income' => '0',
            'mother_phone' => '0822222222',
            'mother_disability' => 'Tidak Ada',
            'has_guardian' => false,
            'guardian_nik' => null,
            'guardian_name' => null,
            'guardian_birth_place' => null,
            'guardian_birth_date' => null,
            'guardian_education' => null,
            'guardian_occupation' => null,
            'guardian_income' => null,
            'guardian_phone' => null,
            'guardian_disability' => null,
            'photo_path' => 'smp/photos/test.jpg',
            'kk_path' => 'smp/documents/kk.pdf',
            'birth_certificate_path' => 'smp/documents/akta.pdf',
            'mother_ktp_path' => 'smp/documents/ktp-ibu.pdf',
            'father_ktp_path' => 'smp/documents/ktp-ayah.pdf',
            'guardian_ktp_path' => null,
            'diploma_path' => null,
            'report_card_path' => 'smp/documents/rapor.pdf',
            'status' => 'verified',
            'verified_at' => now(),
        ], $overrides));
    }
}
