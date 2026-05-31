<?php

use App\Http\Controllers\Api\PaidApplicantController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
    Route::get('/paid-applicants', [PaidApplicantController::class, 'index'])
        ->name('api.paid-applicants.index');

    Route::get('/pendaftar-sudah-bayar', [PaidApplicantController::class, 'index'])
        ->name('api.pendaftar-sudah-bayar.index');
});
