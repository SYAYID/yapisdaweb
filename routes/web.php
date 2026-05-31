<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SmpAdminController;
use App\Http\Controllers\SmpRegistrationController;
use App\Http\Controllers\GraduationController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ReEnrollmentStatusController;
use App\Http\Controllers\OperationsController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/status-daftar-ulang', [ReEnrollmentStatusController::class, 'index'])->name('reenrollment.status');
// Route::get('/pengumuman', [HomeController::class, 'pengumuman'])->name('pengumuman');
//Route::post('/cek-status', [HomeController::class, 'cekStatus'])->name('cek.status');

// Registration routes
Route::get('/registration', [RegistrationController::class, 'showForm'])->name('registration.form');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/registration/receipt/{id}', [RegistrationController::class, 'showReceipt'])->name('registration.receipt');
Route::get('/registration/receipt/{id}/pdf', [RegistrationController::class, 'downloadReceiptPdf'])->name('registration.receipt.pdf');

// Student Routes
Route::prefix('siswa')->group(function () {
    Route::get('/login', [\App\Http\Controllers\StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [\App\Http\Controllers\StudentAuthController::class, 'login'])->name('student.login.post');
    Route::get('/logout', [\App\Http\Controllers\StudentAuthController::class, 'logout'])->name('student.logout');

    // Default auth middleware for applicant
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('student.dashboard');
    });
});

// Admin routes
Route::prefix('admin')->group(function() {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'postLogin'])->name('admin.login.post');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');



    Route::middleware(['admin.auth'])->group(function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/analytics', [AdminController::class, 'index'])->name('admin.analytics');
        Route::get('/quotas', [AdminController::class, 'index'])->name('admin.quotas');
        Route::patch('/quotas/update', [AdminController::class, 'updateQuota'])->name('admin.quotas.update');
        Route::get('/applicants', [AdminController::class, 'index'])->name('admin.applicants');
        Route::get('/guide', [AdminController::class, 'index'])->name('admin.guide');
        Route::patch('/verify/{id}', [AdminController::class, 'verify'])->name('admin.verify');
        Route::patch('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
        Route::patch('/status/{id}', [AdminController::class, 'updateStatus'])->name('admin.status.update');
        Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
        Route::get('/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
        Route::get('/print/{id}', [AdminController::class, 'printReceipt'])->name('admin.print');
        Route::get('/documents/{id}', [AdminController::class, 'viewDocuments'])->name('admin.documents');
        Route::get('/document/view/{type}/{id}', [AdminController::class, 'previewDocument'])->name('admin.document.preview');
        Route::post('/activities/{id}', [AdminController::class, 'storeActivity'])->name('admin.activities.store');

        // Routes edit & delete (HARD DELETE)
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    });
});

Route::prefix('admin/finance')->group(function () {
    Route::get('/login', [FinanceController::class, 'login'])->name('admin.finance.login');
    Route::post('/login', [FinanceController::class, 'postLogin'])->name('admin.finance.login.post');
    Route::get('/logout', [FinanceController::class, 'logout'])->name('admin.finance.logout');

    Route::middleware(['finance.auth'])->group(function () {
        Route::get('/dashboard', [FinanceController::class, 'index'])->name('admin.finance.dashboard');
        Route::get('/transactions/create', [FinanceController::class, 'index'])->name('admin.finance.transactions.create');
        Route::get('/guide', [FinanceController::class, 'index'])->name('admin.finance.guide');
        Route::get('/uniform-report', [FinanceController::class, 'index'])->name('admin.finance.uniform-report');
        Route::get('/daily-report', [FinanceController::class, 'index'])->name('admin.finance.daily-report');
        Route::get('/mutations', [FinanceController::class, 'index'])->name('admin.finance.mutations');
        Route::get('/payment-types', [FinanceController::class, 'index'])->name('admin.finance.payment-types');
        Route::get('/final-progress', [FinanceController::class, 'index'])->name('admin.finance.final-progress');
        Route::get('/uniform-sizes', [FinanceController::class, 'index'])->name('admin.finance.uniform-sizes');
        Route::get('/final-report', [FinanceController::class, 'finalReport'])->name('admin.finance.final-report');
        Route::get('/final-report/export', [FinanceController::class, 'exportFinalReport'])->name('admin.finance.final-report.export');
        Route::get('/audit-logs', [FinanceController::class, 'auditLogs'])->name('admin.finance.audit-logs');
        Route::get('/students/search', [FinanceController::class, 'searchVerifiedStudents'])->name('admin.finance.students.search');
        Route::get('/receipt/{transaction}', [FinanceController::class, 'printReceipt'])->name('admin.finance.receipt');
        Route::get('/student-card/{transaction}', [FinanceController::class, 'printStudentCard'])->name('admin.finance.student-card');
        Route::get('/student-photo/{type}/{id}', [FinanceController::class, 'previewStudentPhoto'])->name('admin.finance.student-photo');
        Route::get('/letters/{type}/{id}/{template}', [FinanceController::class, 'printStudentLetter'])->name('admin.finance.letters.print');
        Route::post('/payment-types', [FinanceController::class, 'storePaymentType'])->name('admin.finance.payment-types.store');
        Route::post('/transactions', [FinanceController::class, 'storeTransaction'])->name('admin.finance.transactions.store');
        Route::post('/uniform-sizes', [FinanceController::class, 'storeUniformProfile'])->name('admin.finance.uniform-sizes.store');
    });
});

Route::prefix('admin/operations')
    ->name('admin.operations.')
    ->group(function () {
        Route::get('/login', [OperationsController::class, 'login'])->name('login');
        Route::post('/login', [OperationsController::class, 'postLogin'])->name('login.post');
        Route::get('/logout', [OperationsController::class, 'logout'])->name('logout');

        Route::middleware(['operations.auth'])->group(function () {
            Route::get('/dashboard', [OperationsController::class, 'index'])->name('dashboard');
            Route::get('/guide', [OperationsController::class, 'index'])->name('guide');
            Route::get('/executive-dashboard', [OperationsController::class, 'index'])->name('executive-dashboard');
            Route::get('/active-students', [OperationsController::class, 'index'])->name('active-students');
            Route::post('/active-students/sync', [OperationsController::class, 'syncActiveStudents'])->name('active-students.sync');
            Route::patch('/active-students/{activeStudent}', [OperationsController::class, 'updateActiveStudent'])->name('active-students.update');
            Route::get('/uniform-stock', [OperationsController::class, 'index'])->name('uniform-stock');
            Route::post('/uniform-stock', [OperationsController::class, 'storeUniformStock'])->name('uniform-stock.store');
            Route::patch('/uniform-stock/{stock}', [OperationsController::class, 'updateUniformStock'])->name('uniform-stock.update');
            Route::get('/final-checklist', [OperationsController::class, 'index'])->name('final-checklist');
            Route::patch('/final-checklist/{type}/{id}', [OperationsController::class, 'updateChecklist'])->name('final-checklist.update');
            Route::get('/official-exports', [OperationsController::class, 'index'])->name('official-exports');
            Route::get('/official-exports/{type}', [OperationsController::class, 'downloadOfficialExport'])->name('official-exports.download');
            Route::get('/archive-center', [OperationsController::class, 'index'])->name('archive-center');
            Route::get('/archive-center/{type}/{id}/{document}', [OperationsController::class, 'previewDocument'])->name('archive.preview');
            Route::get('/health', [OperationsController::class, 'index'])->name('health');
            Route::post('/backups', [OperationsController::class, 'createBackup'])->name('backups.store');
            Route::get('/backups/{backup}/download', [OperationsController::class, 'downloadBackup'])->name('backups.download');
        });
    });


Route::prefix('smp-registration')->group(function () {
    Route::get('/', [SmpRegistrationController::class, 'showForm'])->name('registration.smp-form');
    Route::post('/store', [SmpRegistrationController::class, 'store'])->name('smp.registration.store');
    Route::get('/success', [SmpRegistrationController::class, 'showSuccess'])->name('smp.registration.success');
    Route::get('/registration/receipt/{id}', [SmpRegistrationController::class, 'showReceipt'])->name('registration.smp-receipt');
    Route::get('/registration/receipt/{id}/pdf', [SmpRegistrationController::class, 'downloadReceiptPdf'])->name('registration.smp-receipt.pdf');
});
Route::prefix('admin/smp')->group(function() {
    Route::get('/login', [SmpAdminController::class, 'login'])->name('admin.smp.login');
    Route::post('/login', [SmpAdminController::class, 'postLogin'])->name('admin.smp.login.post');
    Route::get('/logout', [SmpAdminController::class, 'logout'])->name('admin.smp.logout');

    Route::middleware(['smp.auth'])->group(function() {
        Route::get('/dashboard', [SmpAdminController::class, 'index'])->name('admin.smp.dashboard');
        Route::get('/analytics', [SmpAdminController::class, 'index'])->name('admin.smp.analytics');
        Route::get('/quotas', [SmpAdminController::class, 'index'])->name('admin.smp.quotas');
        Route::patch('/quotas/update', [SmpAdminController::class, 'updateQuota'])->name('admin.smp.quotas.update');
        Route::get('/applicants', [SmpAdminController::class, 'index'])->name('admin.smp.applicants');
        Route::get('/guide', [SmpAdminController::class, 'index'])->name('admin.smp.guide');
        Route::patch('/verify/{id}', [SmpAdminController::class, 'verify'])->name('admin.smp.verify');
        Route::patch('/reject/{id}', [SmpAdminController::class, 'reject'])->name('admin.smp.reject');
        Route::patch('/status/{id}', [SmpAdminController::class, 'updateStatus'])->name('admin.smp.status.update');
        Route::get('/search', [SmpAdminController::class, 'search'])->name('admin.smp.search');
        Route::get('/export/excel', [SmpAdminController::class, 'exportExcel'])->name('admin.smp.export.excel');
        Route::get('/print/{id}', [SmpAdminController::class, 'printReceipt'])->name('admin.smp.print');
        Route::get('/documents/{id}', [SmpAdminController::class, 'viewDocuments'])->name('admin.smp.documents');
        Route::get('/document/view/{type}/{id}', [SmpAdminController::class, 'previewDocument'])->name('admin.smp.document.preview');
        Route::post('/activities/{id}', [SmpAdminController::class, 'storeActivity'])->name('admin.smp.activities.store');

        // Routes edit & delete (HARD DELETE)
        Route::get('/edit/{id}', [SmpAdminController::class, 'edit'])->name('admin.smp.edit');
        Route::put('/update/{id}', [SmpAdminController::class, 'update'])->name('admin.smp.update');
        Route::delete('/delete/{id}', [SmpAdminController::class, 'destroy'])->name('admin.smp.delete');
    });
});
