<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Registration routes
Route::get('/registration', [RegistrationController::class, 'showForm'])->name('registration.form');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/registration/receipt/{id}', [RegistrationController::class, 'showReceipt'])->name('registration.receipt');

// Admin routes
Route::prefix('admin')->group(function() {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'postLogin'])->name('admin.login.post');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware(['web'])->group(function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/verify/{id}', [AdminController::class, 'verify'])->name('admin.verify');
        Route::get('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
        Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
        Route::get('/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
        Route::get('/print/{id}', [AdminController::class, 'printReceipt'])->name('admin.print');
        Route::get('/documents/{id}', [AdminController::class, 'viewDocuments'])->name('admin.documents');
        Route::get('/document/view/{type}/{id}', [AdminController::class, 'previewDocument'])->name('admin.document.preview');
    });
    
});