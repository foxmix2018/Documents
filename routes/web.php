<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyOTPController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoriesController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/verifyOTP', [VerifyOTPController::class, 'showVerifyForm']);
Route::post('/verifyOTP', [VerifyOTPController::class, 'verifyOTP']);
Route::post('/resend-otp', [VerifyOTPController::class, 'resendOTP'])->name('resend.otp');
Route::group(['middleware' => 'TwoFA'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

//Documents Access
Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
Route::post('/documents/{docPDF}', [DocumentController::class, 'download'])->name('documents.download');


Route::put('/documents/{document}/approve', [DocumentController::class, 'statusAppr'])->name('documents.statusAppr');
Route::put('/documents/{document}/reject', [DocumentController::class, 'statusRej'])->name('documents.statusRej');
Route::get('/documents/D/{id}', [DocumentController::class, 'softDelete'])->name('documents.softDelete');

Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
//Route::get('/give-admin-role/{userId}', [HomeController::class, 'giveAdminRole']);
